<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Promotions HMVC Controller
 * Route: admin/promotions
 * Handles: flash sales, product bundles, pre-orders, mystery drops, group buying
 */
class Promotions extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $flash_count  = $this->db->where('is_active', 1)->count_all_results('flash_sales');
        $bundle_count = $this->db->table_exists('product_bundles') ? $this->db->where('is_active', 1)->count_all_results('product_bundles') : 0;
        $preorder_count = $this->db->table_exists('pre_orders') ? $this->db->count_all('pre_orders') : 0;
        $mystery_count  = $this->db->table_exists('mystery_drops') ? $this->db->count_all('mystery_drops') : 0;
        $group_count    = $this->db->table_exists('group_buy_campaigns') ? $this->db->count_all('group_buy_campaigns') : 0;

        $data = [
            'title'         => 'Promotions — NovaDrop Admin',
            'flash_count'   => $flash_count,
            'bundle_count'  => $bundle_count,
            'preorder_count'=> $preorder_count,
            'mystery_count' => $mystery_count,
            'group_count'   => $group_count,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/promotions/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Flash Sales ──────────────────────────────────────────
    public function flash_sales()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('flash_action');

            if ($act === 'create_flash') {
                $title = trim($this->input->post('title', true));
                $dval  = (float)$this->input->post('discount_value');
                $dtype = in_array($this->input->post('discount_type'), ['percent','fixed']) ? $this->input->post('discount_type') : 'percent';

                if (empty($title) || $dval <= 0) {
                    $this->session->set_flashdata('error', 'Title and discount value are required.');
                } else {
                    $row = [
                        'store_id'       => $this->store_id,
                        'title'          => $title,
                        'description'    => $this->input->post('description', true),
                        'discount_type'  => $dtype,
                        'discount_value' => $dval,
                        'min_purchase'   => (float)($this->input->post('min_purchase') ?: 0),
                        'max_uses'       => $this->input->post('max_uses') ? (int)$this->input->post('max_uses') : null,
                        'starts_at'      => $this->input->post('starts_at') ?: date('Y-m-d H:i:s'),
                        'ends_at'        => $this->input->post('ends_at') ?: date('Y-m-d H:i:s', strtotime('+24 hours')),
                        'badge_text'     => trim($this->input->post('badge_text', true)) ?: 'FLASH DEAL',
                        'show_timer'     => $this->input->post('show_timer') ? 1 : 0,
                        'show_stock_bar' => $this->input->post('show_stock_bar') ? 1 : 0,
                        'is_active'      => 1,
                        'created_at'     => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('flash_sales', $row);
                    $this->audit('flash_sale.created', 'flash_sales', $this->db->insert_id(), [], $row);
                    $this->session->set_flashdata('success', "Flash sale '{$title}' created.");
                }

            } elseif ($act === 'toggle_flash') {
                $fid = (int)$this->input->post('flash_id');
                $cur = $this->db->where('id', $fid)->get('flash_sales')->row_array();
                if ($cur) {
                    $new = $cur['is_active'] ? 0 : 1;
                    $this->db->where('id', $fid)->update('flash_sales', ['is_active' => $new]);
                    $this->session->set_flashdata('success', 'Flash sale ' . ($new ? 'activated' : 'deactivated') . '.');
                }

            } elseif ($act === 'delete_flash') {
                $fid = (int)$this->input->post('flash_id');
                $this->db->where('id', $fid)->delete('flash_sales');
                $this->session->set_flashdata('success', 'Flash sale deleted.');
            }

            redirect('admin/promotions/flash_sales');
        }

        $fs_q = $this->db->order_by('id', 'DESC');
        if ($this->db->field_exists('store_id', 'flash_sales')) {
            $fs_q->where('store_id', $this->store_id);
        }
        $flash_sales = $fs_q->get('flash_sales')->result_array();
        $data = [
            'title'       => 'Flash Sales — NovaDrop Admin',
            'flash_sales' => $flash_sales,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/promotions/flash_sales', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Bundles ──────────────────────────────────────────────
    public function bundles()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('bundle_action');

            if ($act === 'create_bundle') {
                $row = [
                    'store_id'       => $this->store_id,
                    'title'          => trim($this->input->post('title', true)),
                    'description'    => $this->input->post('description', true),
                    'discount_type'  => in_array($this->input->post('discount_type'), ['percent','fixed']) ? $this->input->post('discount_type') : 'percent',
                    'discount_value' => (float)$this->input->post('discount_value'),
                    'is_active'      => 1,
                    'created_at'     => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('product_bundles', $row);
                $bundle_id = $this->db->insert_id();

                // Insert bundle items
                $product_ids = array_filter(explode(',', $this->input->post('product_ids') ?: ''));
                foreach ($product_ids as $pid) {
                    $this->db->insert('bundle_items', [
                        'bundle_id'  => $bundle_id,
                        'product_id' => (int)trim($pid),
                        'qty'        => 1,
                    ]);
                }
                $this->audit('bundle.created', 'product_bundles', $bundle_id, [], $row);
                $this->session->set_flashdata('success', 'Bundle created.');

            } elseif ($act === 'delete_bundle') {
                $bid = (int)$this->input->post('bundle_id');
                $this->db->where('bundle_id', $bid)->delete('bundle_items');
                $this->db->where('id', $bid)->delete('product_bundles');
                $this->session->set_flashdata('success', 'Bundle deleted.');
            }

            redirect('admin/promotions/bundles');
        }

        $bq = $this->db->order_by('id', 'DESC');
        if ($this->db->field_exists('store_id', 'product_bundles')) {
            $bq->where('store_id', $this->store_id);
        }
        $bundles = $bq->get('product_bundles')->result_array();
        $products = $this->db->where('status', 'active')->order_by('title', 'ASC')->get('products')->result_array();
        $data = [
            'title'    => 'Product Bundles — NovaDrop Admin',
            'bundles'  => $bundles,
            'products' => $products,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/promotions/bundles', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Pre-Orders ───────────────────────────────────────────
    public function pre_orders()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('preorder_action');

            if ($act === 'create') {
                $row = [
                    'store_id'         => $this->store_id,
                    'product_id'       => (int)$this->input->post('product_id'),
                    'available_from'   => $this->input->post('available_from'),
                    'max_quantity'     => $this->input->post('max_quantity') ? (int)$this->input->post('max_quantity') : null,
                    'deposit_required' => (float)($this->input->post('deposit_required') ?: 0),
                    'is_active'        => 1,
                    'created_at'       => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('pre_orders', $row);
                $this->audit('pre_order.created', 'pre_orders', $this->db->insert_id(), [], $row);
                $this->session->set_flashdata('success', 'Pre-order campaign created.');

            } elseif ($act === 'delete') {
                $pid = (int)$this->input->post('id');
                $this->db->where('id', $pid)->delete('pre_orders');
                $this->session->set_flashdata('success', 'Pre-order deleted.');

            } elseif ($act === 'toggle') {
                $pid = (int)$this->input->post('id');
                $cur = $this->db->where('id', $pid)->get('pre_orders')->row_array();
                if ($cur) {
                    $this->db->where('id', $pid)->update('pre_orders', ['is_active' => $cur['is_active'] ? 0 : 1]);
                }
                $this->session->set_flashdata('success', 'Pre-order status toggled.');
            }

            redirect('admin/promotions/pre_orders');
        }

        $pq = $this->db->order_by('id', 'DESC');
        if ($this->db->field_exists('store_id', 'pre_orders')) {
            $pq->where('store_id', $this->store_id);
        }
        $pre_orders = $pq->get('pre_orders')->result_array();
        $products   = $this->db->where('status', 'active')->order_by('title', 'ASC')->get('products')->result_array();
        $data = [
            'title'      => 'Pre-Orders — NovaDrop Admin',
            'pre_orders' => $pre_orders,
            'products'   => $products,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/promotions/pre_orders', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Mystery Drops ────────────────────────────────────────
    public function mystery_drops()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('mystery_action');
            if ($act === 'create') {
                $row = [
                    'store_id'    => $this->store_id,
                    'title'       => trim($this->input->post('title', true)),
                    'price'       => (float)$this->input->post('price'),
                    'reveal_at'   => $this->input->post('reveal_at'),
                    'stock_limit' => $this->input->post('stock_limit') ? (int)$this->input->post('stock_limit') : null,
                    'is_active'   => 1,
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('mystery_drops', $row);
                $this->session->set_flashdata('success', 'Mystery drop created.');
            } elseif ($act === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('mystery_drops')->row_array();
                if ($cur) { $this->db->where('id', $id)->update('mystery_drops', ['is_active' => $cur['is_active'] ? 0 : 1]); }
                $this->session->set_flashdata('success', 'Status toggled.');
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('mystery_drops');
                $this->session->set_flashdata('success', 'Mystery drop deleted.');
            }
            redirect('admin/promotions/mystery_drops');
        }

        $dq = $this->db->order_by('id', 'DESC');
        if ($this->db->field_exists('store_id', 'mystery_drops')) {
            $dq->where('store_id', $this->store_id);
        }
        $drops = $dq->get('mystery_drops')->result_array();
        $data  = ['title' => 'Mystery Drops — NovaDrop Admin', 'drops' => $drops];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/promotions/mystery_drops', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Group Buying ─────────────────────────────────────────
    public function group_buying()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('group_action');
            if ($act === 'create') {
                $row = [
                    'store_id'        => $this->store_id,
                    'product_id'      => (int)$this->input->post('product_id'),
                    'title'           => trim($this->input->post('title', true)),
                    'group_price'     => (float)$this->input->post('group_price'),
                    'min_participants'=> (int)$this->input->post('min_participants'),
                    'max_participants'=> $this->input->post('max_participants') ? (int)$this->input->post('max_participants') : null,
                    'ends_at'         => $this->input->post('ends_at'),
                    'is_active'       => 1,
                    'created_at'      => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('group_buy_campaigns', $row);
                $this->session->set_flashdata('success', 'Group buy campaign created.');
            } elseif ($act === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('group_buy_campaigns')->row_array();
                if ($cur) { $this->db->where('id', $id)->update('group_buy_campaigns', ['is_active' => $cur['is_active'] ? 0 : 1]); }
                $this->session->set_flashdata('success', 'Status toggled.');
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('campaign_id', $id)->delete('group_buy_teams');
                $this->db->where('id', $id)->delete('group_buy_campaigns');
                $this->session->set_flashdata('success', 'Group buy campaign deleted.');
            }
            redirect('admin/promotions/group_buying');
        }

        $gq = $this->db->order_by('id', 'DESC');
        if ($this->db->field_exists('store_id', 'group_buy_campaigns')) {
            $gq->where('store_id', $this->store_id);
        }
        $campaigns = $gq->get('group_buy_campaigns')->result_array();
        $products   = $this->db->where('status', 'active')->order_by('title', 'ASC')->get('products')->result_array();

        // Add participant count
        foreach ($campaigns as &$camp) {
            $row = $this->db->where('campaign_id', $camp['id'])->count_all_results('group_buy_teams');
            $camp['participant_count'] = $row;
        }
        unset($camp);

        $data = ['title' => 'Group Buying — NovaDrop Admin', 'campaigns' => $campaigns, 'products' => $products];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/promotions/group_buying', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Coordinated Ensemble Packs & DTC Lookbook Manager ────
    public function ensembles()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('action');
            
            if ($act === 'save_discounts') {
                $b3 = max(0, min(90, (float)$this->input->post('bundle_discount_3')));
                $b2 = max(0, min(90, (float)$this->input->post('bundle_discount_2')));
                $enabled = $this->input->post('bundle_discount_enabled') ? 1 : 0;
                $free_ship = $this->input->post('bundle_free_shipping') ? 1 : 0;

                // Ensure columns exist in home_settings
                $this->load->dbforge();
                if ($this->db->table_exists('home_settings')) {
                    $fields = $this->db->list_fields('home_settings');
                    $to_add = [];
                    if (!in_array('bundle_discount_3', $fields)) $to_add['bundle_discount_3'] = ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 15.00];
                    if (!in_array('bundle_discount_2', $fields)) $to_add['bundle_discount_2'] = ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 10.00];
                    if (!in_array('bundle_discount_enabled', $fields)) $to_add['bundle_discount_enabled'] = ['type' => 'TINYINT', 'constraint' => '1', 'default' => 1];
                    if (!in_array('bundle_free_shipping', $fields)) $to_add['bundle_free_shipping'] = ['type' => 'TINYINT', 'constraint' => '1', 'default' => 1];
                    if (!in_array('ensemble_looks_json', $fields)) $to_add['ensemble_looks_json'] = ['type' => 'TEXT', 'null' => TRUE];
                    if (!empty($to_add)) {
                        $this->dbforge->add_column('home_settings', $to_add);
                    }

                    $save_data = [
                        'bundle_discount_3'       => $b3,
                        'bundle_discount_2'       => $b2,
                        'bundle_discount_enabled' => $enabled,
                        'bundle_free_shipping'    => $free_ship,
                        'updated_at'              => date('Y-m-d H:i:s')
                    ];

                    $existing = $this->db->where('store_id', $this->store_id)->get('home_settings')->row_array();
                    if ($existing) {
                        $this->db->where('store_id', $this->store_id)->update('home_settings', $save_data);
                    } else {
                        $save_data['store_id'] = $this->store_id;
                        $this->db->insert('home_settings', $save_data);
                    }
                }

                $this->audit('promotions.ensembles_saved', 'home_settings', 0, [], ['b3' => $b3, 'b2' => $b2]);
                $this->session->set_flashdata('success', 'Coordinated Ensemble discounts and settings updated successfully! ✦');
                redirect('admin/promotions/ensembles');
            }
        }

        $hs = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        if (!$hs) {
            $hs = $this->db->limit(1)->get('home_settings')->row_array() ?: [];
        }

        $products = $this->db->where('status', 'active')->order_by('title', 'ASC')->get('products')->result_array();

        $data = [
            'title'         => 'Coordinated Ensemble Packs — NovaDrop Admin',
            'home_settings' => $hs,
            'products'      => $products,
            'b3_discount'   => isset($hs['bundle_discount_3']) ? (float)$hs['bundle_discount_3'] : 15.0,
            'b2_discount'   => isset($hs['bundle_discount_2']) ? (float)$hs['bundle_discount_2'] : 10.0,
            'b_enabled'     => isset($hs['bundle_discount_enabled']) ? (int)$hs['bundle_discount_enabled'] : 1,
            'b_freeship'    => isset($hs['bundle_free_shipping']) ? (int)$hs['bundle_free_shipping'] : 1,
            'looks_json'    => $hs['ensemble_looks_json'] ?? '',
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/promotions/ensembles', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
