<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — AiEngine HMVC Controller
 * Route: admin/ai_engine
 * Proxies all AI agent classes. Stores results in ai_agent_tasks.
 */
class AiEngine extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    // ─── Dashboard / Overview ─────────────────────────────────
    public function index()
    {
        $recent_tasks = [];
        if ($this->db->table_exists('ai_agent_tasks')) {
            $rt_q = $this->db->order_by('id', 'DESC')->limit(30);
            if ($this->db->field_exists('store_id', 'ai_agent_tasks')) {
                $rt_q->where('store_id', $this->store_id);
            }
            $recent_tasks = $rt_q->get('ai_agent_tasks')->result_array();
        }

        $status_counts = [];
        foreach (['pending','running','done','failed','awaiting_approval'] as $s) {
            if ($this->db->table_exists('ai_agent_tasks')) {
                $sc_q = $this->db->where('status', $s);
                if ($this->db->field_exists('store_id', 'ai_agent_tasks')) {
                    $sc_q->where('store_id', $this->store_id);
                }
                $status_counts[$s] = $sc_q->count_all_results('ai_agent_tasks');
            } else {
                $status_counts[$s] = 0;
            }
        }

        $orchestrator_runs = $this->db->table_exists('ai_orchestrator_runs')
            ? $this->db->order_by('id', 'DESC')->limit(10)->get('ai_orchestrator_runs')->result_array()
            : [];

        $data = [
            'title'             => 'AI Engine — NovaDrop Admin',
            'recent_tasks'      => $recent_tasks,
            'status_counts'     => $status_counts,
            'orchestrator_runs' => $orchestrator_runs,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/ai_engine/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Swarm: Run Agents On-Demand ──────────────────────────
    public function swarm()
    {
        if ($this->input->method() === 'post') {
            $action_type = $this->input->post('action_type');
            $result_msg  = null;

            // Log task as queued
            $task_id = null;
            if ($this->db->table_exists('ai_agent_tasks')) {
                $t_cols = $this->db->list_fields('ai_agent_tasks');
                $t_data = [
                    'store_id'   => $this->store_id,
                    'agent'      => $action_type,
                    'input_json' => json_encode(['triggered_by' => $this->admin_user['id'] ?? 'admin', 'time' => date('Y-m-d H:i:s')]),
                    'status'     => 'running',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $clean_t = array_intersect_key($t_data, array_flip($t_cols));
                $this->db->insert('ai_agent_tasks', $clean_t);
                $task_id = $this->db->insert_id();
            }

            try {
                // Load agent classes if available
                $agent_dir = APPPATH . 'core/agents/';
                $swarm_dir = APPPATH . 'core/swarm/';
                if (is_dir($agent_dir)) {
                    foreach (glob($agent_dir . '*.php') as $f) { require_once $f; }
                }
                if (is_dir($swarm_dir)) {
                    foreach (glob($swarm_dir . '*.php') as $f) { require_once $f; }
                }

                // Build a PDO for agents that need it directly
                $pdo = new PDO(
                    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                        env('DB_HOST', '127.0.0.1'), env('DB_PORT', '3306'), env('DB_NAME', 'novadrop')),
                    env('DB_USER', 'root'), env('DB_PASS', ''),
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );

                switch ($action_type) {
                    case 'run_swarm_cycle':
                        if (file_exists(APPPATH . 'core/swarm/SwarmCoordinator.php')) {
                            require_once APPPATH . 'core/swarm/SwarmCoordinator.php';
                            $coordinator = new SwarmCoordinator($this->store_id);
                            $cycle_res = $coordinator->run_cycle();
                            $result_msg = "Swarm Cycle Completed (Consensus: " . ($cycle_res['consensus_score'] * 100) . "%, Agents: " . $cycle_res['agents_executed'] . ")\n\n" . json_encode($cycle_res['actions_taken'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        } else {
                            $result_msg = 'SwarmCoordinator file not found.';
                        }
                        break;

                    case 'run_pricing_agent':
                        // Files already require_once'd above; class uses App\Agents\ namespace
                        if (class_exists('App\\Agents\\DynamicPricingAgent')) {
                            $agent = new \App\Agents\DynamicPricingAgent($pdo, $this->store_id);
                            $res   = $agent->optimize_catalog_prices();
                            $result_msg = json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        } else {
                            $result_msg = 'DynamicPricingAgent class not found.';
                        }
                        break;

                    case 'run_seo_agent':
                        if (class_exists('App\\Agents\\SeoContentAgent')) {
                            $agent = new \App\Agents\SeoContentAgent($pdo, $this->store_id);
                            $res   = $agent->generate_collection_guides();
                            $result_msg = is_string($res) ? $res : json_encode($res, JSON_UNESCAPED_UNICODE);
                        } else {
                            $result_msg = 'SeoContentAgent not found.';
                        }
                        break;

                    case 'run_abandoned_cart':
                        $job_dir = APPPATH . 'jobs/';
                        if (is_dir($job_dir)) { foreach (glob($job_dir . '*.php') as $f) { require_once $f; } }
                        if (class_exists('App\\Jobs\\AbandonedCartJob')) {
                            $job = new \App\Jobs\AbandonedCartJob($pdo, $this->store_id);
                            $job->handle();
                            $result_msg = 'Abandoned cart job completed.';
                        } else {
                            $result_msg = 'AbandonedCartJob not found.';
                        }
                        break;

                    case 'run_retention':
                        if (class_exists('App\\Agents\\RetentionWinbackAgent')) {
                            $agent = new \App\Agents\RetentionWinbackAgent($pdo, $this->store_id);
                            $res   = $agent->run_all_workflows();
                            $result_msg = json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        } else {
                            $result_msg = 'RetentionWinbackAgent class not found.';
                        }
                        break;

                    case 'run_email_marketing':
                        if (class_exists('App\\Agents\\EmailMarketingAgent')) {
                            $agent = new \App\Agents\EmailMarketingAgent($pdo, $this->store_id);
                            $res   = method_exists($agent, 'run') ? $agent->run() : $agent->dispatch_campaigns();
                            $result_msg = is_array($res) ? json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : (string)$res;
                        } else {
                            $result_msg = 'EmailMarketingAgent class not found.';
                        }
                        break;

                    case 'run_fraud_scan':
                        if (class_exists('App\\Agents\\FraudRiskAgent')) {
                            $agent = new \App\Agents\FraudRiskAgent($pdo, $this->store_id);
                            $res   = method_exists($agent, 'scan_recent_orders') ? $agent->scan_recent_orders() : $agent->run();
                            $result_msg = is_array($res) ? json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : (string)$res;
                        } else {
                            $result_msg = 'FraudRiskAgent class not found.';
                        }
                        break;

                    case 'run_whatsapp_campaigns':
                        if (class_exists('App\\Agents\\WhatsAppCommerceAgent')) {
                            $agent = new \App\Agents\WhatsAppCommerceAgent($pdo, $this->store_id);
                            $res   = method_exists($agent, 'run_campaigns') ? $agent->run_campaigns() : $agent->run();
                            $result_msg = is_array($res) ? json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : (string)$res;
                        } else {
                            $result_msg = 'WhatsAppCommerceAgent class not found.';
                        }
                        break;

                    case 'run_daily_digest':
                        $job_dir = APPPATH . 'jobs/';
                        if (is_dir($job_dir)) { foreach (glob($job_dir . '*.php') as $f) { require_once $f; } }
                        if (class_exists('App\\Jobs\\DailyDigestJob')) {
                            $job = new \App\Jobs\DailyDigestJob($pdo, $this->store_id);
                            $job->handle();
                            $result_msg = 'Daily digest dispatched.';
                        } else {
                            $result_msg = 'DailyDigestJob not found.';
                        }
                        break;

                    default:
                        $result_msg = "Unknown action: {$action_type}";
                }

                // Update task record
                $this->db->where('id', $task_id)->update('ai_agent_tasks', [
                    'status'      => 'done',
                    'output_text' => substr($result_msg ?? 'No output', 0, 65535),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ]);
                $this->session->set_flashdata('success', "Agent '{$action_type}' completed.");

            } catch (Throwable $e) {
                $this->log_error($e, 'AiEngine::swarm');
                if ($task_id) {
                    $this->db->where('id', $task_id)->update('ai_agent_tasks', [
                        'status'      => 'failed',
                        'output_text' => $e->getMessage(),
                        'updated_at'  => date('Y-m-d H:i:s'),
                    ]);
                }
                $this->session->set_flashdata('error', 'Agent failed: ' . $e->getMessage());
            }

            redirect('admin/ai_engine/swarm');
        }

        $tasks = [];
        if ($this->db->table_exists('ai_agent_tasks')) {
            $t_q = $this->db->order_by('id', 'DESC')->limit(50);
            if ($this->db->field_exists('store_id', 'ai_agent_tasks')) {
                $t_q->where('store_id', $this->store_id);
            }
            $tasks = $t_q->get('ai_agent_tasks')->result_array();
        }

        $telemetry = $this->db->table_exists('ai_swarm_telemetry')
            ? $this->db->order_by('id', 'DESC')->limit(20)->get('ai_swarm_telemetry')->result_array()
            : [];

        $data = [
            'title'     => 'AI Swarm — NovaDrop Admin',
            'tasks'     => $tasks,
            'telemetry' => $telemetry,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/ai_engine/swarm', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Autopilot Config ─────────────────────────────────────
    public function autopilot()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('autopilot_action');

            if ($act === 'save_config') {
                $config_data = [
                    'store_id'              => $this->store_id,
                    'auto_pricing_enabled'  => $this->input->post('auto_pricing') ? 1 : 0,
                    'auto_restock_enabled'  => $this->input->post('auto_restock') ? 1 : 0,
                    'auto_email_enabled'    => $this->input->post('auto_email') ? 1 : 0,
                    'auto_seo_enabled'      => $this->input->post('auto_seo') ? 1 : 0,
                    'run_interval_hours'    => (int)($this->input->post('interval_hours') ?: 24),
                    'updated_at'            => date('Y-m-d H:i:s'),
                ];
                if ($this->db->table_exists('ai_autopilot_configs')) {
                    $ap_cols = $this->db->list_fields('ai_autopilot_configs');
                    $clean_ap = array_intersect_key($config_data, array_flip($ap_cols));
                    
                    $has_store = $this->db->field_exists('store_id', 'ai_autopilot_configs');
                    $existing = $has_store ? $this->db->where('store_id', $this->store_id)->get('ai_autopilot_configs')->row_array() : $this->db->get('ai_autopilot_configs')->row_array();
                    if ($existing) {
                        if ($has_store) {
                            $this->db->where('store_id', $this->store_id)->update('ai_autopilot_configs', $clean_ap);
                        } else {
                            $this->db->where('id', $existing['id'])->update('ai_autopilot_configs', $clean_ap);
                        }
                    } else {
                        if (in_array('created_at', $ap_cols)) {
                            $clean_ap['created_at'] = date('Y-m-d H:i:s');
                        }
                        $this->db->insert('ai_autopilot_configs', $clean_ap);
                    }
                }
                $this->audit('autopilot.config_saved', 'ai_autopilot_configs', 0, [], $config_data);
                $this->session->set_flashdata('success', 'Autopilot configuration saved.');
            }
            redirect('admin/ai_engine/autopilot');
        }

        $config = [];
        if ($this->db->table_exists('ai_autopilot_configs')) {
            $ap_q = $this->db->field_exists('store_id', 'ai_autopilot_configs')
                ? $this->db->where('store_id', $this->store_id)
                : $this->db;
            $config = $ap_q->get('ai_autopilot_configs')->row_array() ?: [];
        }
        $data = ['title' => 'Autopilot — NovaDrop Admin', 'config' => $config];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/ai_engine/autopilot', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Repricer ─────────────────────────────────────────────
    public function repricer()
    {
        $has_p_comp   = $this->db->table_exists('products') && $this->db->field_exists('compare_at_price', 'products');
        $has_p_store  = $this->db->table_exists('products') && $this->db->field_exists('store_id', 'products');
        $has_p_upd    = $this->db->table_exists('products') && $this->db->field_exists('updated_at', 'products');
        $has_pv       = $this->db->table_exists('product_variants');
        $has_pv_comp  = $has_pv && $this->db->field_exists('compare_at_price', 'product_variants');

        if ($this->input->method() === 'post') {
            $act = $this->input->post('repricer_action');

            if ($act === 'batch_reprice') {
                $strategy = $this->input->post('pricing_strategy');
                if ($strategy === 'boost_profit') {
                    $multiplier = 1.12; // +12%
                    $upd_set = "`base_price` = ROUND(`base_price` * ?, -1)";
                    if ($has_p_comp) {
                        $upd_set .= ", `compare_at_price` = ROUND(GREATEST(COALESCE(`compare_at_price`, `base_price` * 1.35) * 1.15, `base_price` * 1.25), -1)";
                    }
                    if ($has_p_upd) {
                        $upd_set .= ", `updated_at` = NOW()";
                    }
                    $p_sql = "UPDATE `products` SET {$upd_set}" . ($has_p_store ? " WHERE `store_id` = ?" : "");
                    $params = $has_p_store ? [$multiplier, (int)$this->store_id] : [$multiplier];
                    $this->db->query($p_sql, $params);

                    if ($has_pv) {
                        $pv_set = $has_pv_comp
                            ? "SET pv.price = ROUND(pv.price * ?, -1), pv.compare_at_price = ROUND(COALESCE(pv.compare_at_price, pv.price * 1.35) * 1.15, -1)"
                            : "SET pv.price = ROUND(pv.price * ?, -1)";
                        $pv_sql = "UPDATE `product_variants` pv JOIN `products` p ON p.id = pv.product_id {$pv_set}" . ($has_p_store ? " WHERE p.store_id = ?" : "");
                        $pv_params = $has_p_store ? [$multiplier, (int)$this->store_id] : [$multiplier];
                        $this->db->query($pv_sql, $pv_params);
                    }

                    $this->audit('catalog.repriced.boost_profit', 'products', 0, [], ['multiplier' => 1.12]);
                    $this->session->set_flashdata('success', "⚡ Profit Maximizer Applied! Catalog prices adjusted by +12% with smart charm pricing.");

                } elseif ($strategy === 'clearance_velocity') {
                    $multiplier = 0.90; // -10%
                    $upd_set = "`base_price` = ROUND(`base_price` * ?, -1)";
                    if ($has_p_upd) {
                        $upd_set .= ", `updated_at` = NOW()";
                    }
                    $p_sql = "UPDATE `products` SET {$upd_set}" . ($has_p_store ? " WHERE `store_id` = ?" : "");
                    $params = $has_p_store ? [$multiplier, (int)$this->store_id] : [$multiplier];
                    $this->db->query($p_sql, $params);

                    if ($has_pv) {
                        $pv_sql = "UPDATE `product_variants` pv JOIN `products` p ON p.id = pv.product_id SET pv.price = ROUND(pv.price * ?, -1)" . ($has_p_store ? " WHERE p.store_id = ?" : "");
                        $pv_params = $has_p_store ? [$multiplier, (int)$this->store_id] : [$multiplier];
                        $this->db->query($pv_sql, $pv_params);
                    }

                    $this->audit('catalog.repriced.clearance', 'products', 0, [], ['multiplier' => 0.90]);
                    $this->session->set_flashdata('success', "⚡ Velocity Discount Applied! Catalog prices reduced by -10% to accelerate checkouts.");

                } elseif ($strategy === 'enforce_markup') {
                    $upd_set = "`base_price` = ROUND(GREATEST(`base_price` * 1.10, 499), -1)";
                    if ($has_p_comp) {
                        $upd_set .= ", `compare_at_price` = ROUND(GREATEST(`base_price` * 1.35, 699), -1)";
                    }
                    if ($has_p_upd) {
                        $upd_set .= ", `updated_at` = NOW()";
                    }
                    $p_sql = "UPDATE `products` SET {$upd_set}" . ($has_p_store ? " WHERE `store_id` = ?" : "");
                    $params = $has_p_store ? [(int)$this->store_id] : [];
                    $this->db->query($p_sql, $params);

                    if ($has_pv) {
                        $pv_set = $has_pv_comp
                            ? "SET pv.price = p.base_price, pv.compare_at_price = " . ($has_p_comp ? "p.compare_at_price" : "ROUND(p.base_price * 1.35, -1)")
                            : "SET pv.price = p.base_price";
                        $pv_sql = "UPDATE `product_variants` pv JOIN `products` p ON p.id = pv.product_id {$pv_set}" . ($has_p_store ? " WHERE p.store_id = ?" : "");
                        $pv_params = $has_p_store ? [(int)$this->store_id] : [];
                        $this->db->query($pv_sql, $pv_params);
                    }

                    $this->audit('catalog.repriced.enforce_markup', 'products', 0, [], ['markup' => '2.8x']);
                    $this->session->set_flashdata('success', "⚡ Wholesale Gross Margin Multiplier Enforced across entire catalog!");
                }

            } elseif ($act === 'update_single_price') {
                $pid = (int)$this->input->post('product_id');
                $new_price = (float)$this->input->post('new_price');
                $new_comp  = (float)($this->input->post('new_compare_price') ?: ($new_price * 1.35));

                if ($pid > 0 && $new_price > 0) {
                    $p_update = ['base_price' => $new_price];
                    if ($has_p_comp) {
                        $p_update['compare_at_price'] = $new_comp;
                    }
                    if ($has_p_upd) {
                        $p_update['updated_at'] = date('Y-m-d H:i:s');
                    }
                    $this->db->where('id', $pid)->update('products', $p_update);

                    if ($has_pv) {
                        $pv_cols = $this->db->list_fields('product_variants');
                        $pv_data = ['price' => $new_price, 'compare_at_price' => $new_comp];
                        $clean_pv = array_intersect_key($pv_data, array_flip($pv_cols));
                        if (!empty($clean_pv)) {
                            $this->db->where('product_id', $pid)->update('product_variants', $clean_pv);
                        }
                    }
                    $this->audit('product.price_adjusted', 'products', $pid, [], ['new_price' => $new_price]);
                    $this->session->set_flashdata('success', "Product #{$pid} price updated to ₹" . number_format($new_price, 2));
                }

            } elseif ($act === 'create_rule') {
                $cols = $this->db->table_exists('pricing_rules') ? $this->db->list_fields('pricing_rules') : [];
                $row = [
                    'store_id'      => $this->store_id,
                    'name'          => trim($this->input->post('name', true)),
                    'rule_type'     => $this->input->post('rule_type'),
                    'value'         => (float)$this->input->post('value'),
                    'min_price'     => (float)($this->input->post('min_price') ?: 0),
                    'max_price'     => $this->input->post('max_price') ? (float)$this->input->post('max_price') : null,
                    'is_active'     => 1,
                    'created_at'    => date('Y-m-d H:i:s'),
                ];
                $clean_row = array_intersect_key($row, array_flip($cols));
                if (!empty($clean_row)) {
                    $this->db->insert('pricing_rules', $clean_row);
                }
                $this->session->set_flashdata('success', 'Pricing rule created.');

            } elseif ($act === 'delete_rule') {
                $id = (int)$this->input->post('rule_id');
                if ($this->db->table_exists('pricing_rules')) {
                    $this->db->where('id', $id)->delete('pricing_rules');
                }
                $this->session->set_flashdata('success', 'Rule deleted.');

            } elseif ($act === 'toggle_rule') {
                $id  = (int)$this->input->post('rule_id');
                if ($this->db->table_exists('pricing_rules')) {
                    $cur = $this->db->where('id', $id)->get('pricing_rules')->row_array();
                    if ($cur) { $this->db->where('id', $id)->update('pricing_rules', ['is_active' => $cur['is_active'] ? 0 : 1]); }
                }
                $this->session->set_flashdata('success', 'Rule toggled.');
            }
            redirect('admin/ai_engine/repricer');
        }

        $rules = [];
        if ($this->db->table_exists('pricing_rules')) {
            $rq = $this->db->order_by('id', 'DESC');
            if ($this->db->field_exists('store_id', 'pricing_rules')) {
                $rq->where('store_id', $this->store_id);
            }
            $rules = $rq->get('pricing_rules')->result_array();
        }

        $audit_log = $this->db->table_exists('pricing_audit_log')
            ? $this->db->order_by('id', 'DESC')->limit(30)->get('pricing_audit_log')->result_array()
            : [];

        $catalog_products = [];
        if ($this->db->table_exists('products')) {
            $cp_q = $this->db->order_by('id', 'DESC')->limit(15);
            if ($has_p_store) {
                $cp_q->where('store_id', $this->store_id);
            }
            $catalog_products = $cp_q->get('products')->result_array();
        }

        $total_catalog_val = 0;
        if ($this->db->table_exists('products')) {
            $tot_q = $this->db->select_sum('base_price');
            if ($has_p_store) {
                $tot_q->where('store_id', $this->store_id);
            }
            $total_catalog_val = (float)($tot_q->get('products')->row_array()['base_price'] ?? 0);
        }

        $data = [
            'title'             => 'AI Dynamic Repricer & Profit Maximizer — NovaDrop Admin',
            'rules'             => $rules,
            'audit_log'         => $audit_log,
            'catalog_products'  => $catalog_products,
            'total_catalog_val' => $total_catalog_val,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/ai_engine/repricer', $data);
        $this->load->view('admin/layout/footer', $data);
    }


    // ─── Approve/Reject AI Task ───────────────────────────────
    public function approve_task($id)
    {
        $id  = (int)$id;
        $task = $this->db->where('id', $id)->get('ai_agent_tasks')->row_array();
        if (!$task) { show_404(); }

        $action = $this->input->post('decision') === 'reject' ? 'failed' : 'done';
        $this->db->where('id', $id)->update('ai_agent_tasks', [
            'status'      => $action,
            'approved_by' => $this->admin_user['id'] ?? null,
            'approved_at' => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
        $this->audit('ai_task.' . $action, 'ai_agent_tasks', $id);
        $this->session->set_flashdata('success', "Task #{$id} {$action}.");
        redirect('admin/ai_engine');
    }
}
