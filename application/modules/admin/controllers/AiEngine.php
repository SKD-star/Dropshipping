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
        $recent_tasks = $this->db->where('store_id', $this->store_id)
                                  ->order_by('id', 'DESC')
                                  ->limit(30)
                                  ->get('ai_agent_tasks')->result_array();

        $status_counts = [];
        foreach (['pending','running','done','failed','awaiting_approval'] as $s) {
            $status_counts[$s] = $this->db->where('store_id', $this->store_id)->where('status', $s)->count_all_results('ai_agent_tasks');
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
            $this->db->insert('ai_agent_tasks', [
                'store_id'   => $this->store_id,
                'agent'      => $action_type,
                'input_json' => json_encode(['triggered_by' => $this->admin_user['id'] ?? 'admin', 'time' => date('Y-m-d H:i:s')]),
                'status'     => 'running',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $task_id = $this->db->insert_id();

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

                        if (class_exists('\\App\\Agents\\DynamicPricingAgent')) {
                            $agent = new \App\Agents\DynamicPricingAgent($pdo, $this->store_id);
                            $res   = $agent->optimize_catalog_prices();
                            $result_msg = json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                        } else {
                            $result_msg = 'DynamicPricingAgent class not found.';
                        }
                        break;

                    case 'run_seo_agent':
                        if (class_exists('\\App\\Agents\\SeoContentAgent')) {
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
                        if (class_exists('\\App\\Jobs\\AbandonedCartJob')) {
                            $job = new \App\Jobs\AbandonedCartJob($pdo, $this->store_id);
                            $job->handle();
                            $result_msg = 'Abandoned cart job completed.';
                        } else {
                            $result_msg = 'AbandonedCartJob not found.';
                        }
                        break;

                    case 'run_daily_digest':
                        $job_dir = APPPATH . 'jobs/';
                        if (is_dir($job_dir)) { foreach (glob($job_dir . '*.php') as $f) { require_once $f; } }
                        if (class_exists('\\App\\Jobs\\DailyDigestJob')) {
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

        $tasks = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->limit(50)->get('ai_agent_tasks')->result_array();
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
                // Upsert
                $existing = $this->db->where('store_id', $this->store_id)->get('ai_autopilot_configs')->row_array();
                if ($existing) {
                    $this->db->where('store_id', $this->store_id)->update('ai_autopilot_configs', $config_data);
                } else {
                    $config_data['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('ai_autopilot_configs', $config_data);
                }
                $this->audit('autopilot.config_saved', 'ai_autopilot_configs', 0, [], $config_data);
                $this->session->set_flashdata('success', 'Autopilot configuration saved.');
            }
            redirect('admin/ai_engine/autopilot');
        }

        $config = $this->db->where('store_id', $this->store_id)->get('ai_autopilot_configs')->row_array() ?: [];
        $data = ['title' => 'Autopilot — NovaDrop Admin', 'config' => $config];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/ai_engine/autopilot', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Repricer ─────────────────────────────────────────────
    public function repricer()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('repricer_action');

            if ($act === 'batch_reprice') {
                $strategy = $this->input->post('pricing_strategy');
                if ($strategy === 'boost_profit') {
                    $multiplier = 1.12; // +12%
                    $this->db->query("UPDATE `products` SET `base_price` = ROUND(`base_price` * {$multiplier}, -1), `compare_at_price` = ROUND(`compare_at_price` * 1.15, -1), `updated_at` = NOW() WHERE `store_id` = " . (int)$this->store_id);
                    $this->db->query("UPDATE `product_variants` pv JOIN `products` p ON p.id = pv.product_id SET pv.price = ROUND(pv.price * {$multiplier}, -1), pv.compare_at_price = ROUND(pv.compare_at_price * 1.15, -1) WHERE p.store_id = " . (int)$this->store_id);
                    $this->audit('catalog.repriced.boost_profit', 'products', 0, [], ['multiplier' => 1.12]);
                    $this->session->set_flashdata('success', "⚡ Profit Maximizer Applied! Catalog prices adjusted by +12% with smart charm pricing.");
                } elseif ($strategy === 'clearance_velocity') {
                    $multiplier = 0.90; // -10%
                    $this->db->query("UPDATE `products` SET `base_price` = ROUND(`base_price` * {$multiplier}, -1), `updated_at` = NOW() WHERE `store_id` = " . (int)$this->store_id);
                    $this->db->query("UPDATE `product_variants` pv JOIN `products` p ON p.id = pv.product_id SET pv.price = ROUND(pv.price * {$multiplier}, -1) WHERE p.store_id = " . (int)$this->store_id);
                    $this->audit('catalog.repriced.clearance', 'products', 0, [], ['multiplier' => 0.90]);
                    $this->session->set_flashdata('success', "⚡ Velocity Discount Applied! Catalog prices reduced by -10% to accelerate checkouts.");
                } elseif ($strategy === 'enforce_markup') {
                    $this->db->query("UPDATE `products` SET `base_price` = ROUND(GREATEST(`base_price` * 1.10, 499), -1), `compare_at_price` = ROUND(GREATEST(`base_price` * 1.35, 699), -1), `updated_at` = NOW() WHERE `store_id` = " . (int)$this->store_id);
                    $this->db->query("UPDATE `product_variants` pv JOIN `products` p ON p.id = pv.product_id SET pv.price = p.base_price, pv.compare_at_price = p.compare_at_price WHERE p.store_id = " . (int)$this->store_id);
                    $this->audit('catalog.repriced.enforce_markup', 'products', 0, [], ['markup' => '2.8x']);
                    $this->session->set_flashdata('success', "⚡ Wholesale Gross Margin Multiplier Enforced across entire catalog!");
                }

            } elseif ($act === 'update_single_price') {
                $pid = (int)$this->input->post('product_id');
                $new_price = (float)$this->input->post('new_price');
                $new_comp  = (float)($this->input->post('new_compare_price') ?: ($new_price * 1.35));

                if ($pid > 0 && $new_price > 0) {
                    $this->db->where('id', $pid)->update('products', ['base_price' => $new_price, 'compare_at_price' => $new_comp, 'updated_at' => date('Y-m-d H:i:s')]);
                    $this->db->where('product_id', $pid)->update('product_variants', ['price' => $new_price, 'compare_at_price' => $new_comp]);
                    $this->audit('product.price_adjusted', 'products', $pid, [], ['new_price' => $new_price]);
                    $this->session->set_flashdata('success', "Product #{$pid} price updated to ₹" . number_format($new_price, 2));
                }

            } elseif ($act === 'create_rule') {
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
                $this->db->insert('pricing_rules', $row);
                $this->session->set_flashdata('success', 'Pricing rule created.');

            } elseif ($act === 'delete_rule') {
                $id = (int)$this->input->post('rule_id');
                $this->db->where('id', $id)->delete('pricing_rules');
                $this->session->set_flashdata('success', 'Rule deleted.');

            } elseif ($act === 'toggle_rule') {
                $id  = (int)$this->input->post('rule_id');
                $cur = $this->db->where('id', $id)->get('pricing_rules')->row_array();
                if ($cur) { $this->db->where('id', $id)->update('pricing_rules', ['is_active' => $cur['is_active'] ? 0 : 1]); }
                $this->session->set_flashdata('success', 'Rule toggled.');
            }
            redirect('admin/ai_engine/repricer');
        }

        $rules    = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('pricing_rules')->result_array();
        $audit_log = $this->db->table_exists('pricing_audit_log')
            ? $this->db->order_by('id', 'DESC')->limit(30)->get('pricing_audit_log')->result_array()
            : [];

        $catalog_products = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->limit(15)->get('products')->result_array();
        $total_catalog_val = (float)($this->db->select_sum('base_price')->where('store_id', $this->store_id)->get('products')->row_array()['base_price'] ?? 0);

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
