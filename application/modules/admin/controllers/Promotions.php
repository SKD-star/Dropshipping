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

        $flash_sales = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('flash_sales')->result_array();
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

        $bundles = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('product_bundles')->result_array();
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

        $pre_orders = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('pre_orders')->result_array();
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

        $drops = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('mystery_drops')->result_array();
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

        $campaigns = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('group_buy_campaigns')->result_array();
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
}
