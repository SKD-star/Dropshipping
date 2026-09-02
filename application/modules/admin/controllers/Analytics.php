<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Analytics HMVC Controller (Full Implementation)
 * Route: admin/analytics
 * Surfaces: revenue, product performance, pricing audit, customer analytics
 */
class Analytics extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $period = $this->input->get('period') ?: '30';
        $days   = in_array((int)$period, [7, 14, 30, 60, 90]) ? (int)$period : 30;
        $from   = date('Y-m-d 00:00:00', strtotime("-{$days} days"));

        $has_order_store = $this->db->table_exists('orders') && $this->db->field_exists('store_id', 'orders');
        $has_cust_store  = $this->db->table_exists('customers') && $this->db->field_exists('store_id', 'customers');
        $has_prod_store  = $this->db->table_exists('products') && $this->db->field_exists('store_id', 'products');

        // ── Revenue & Order Counts ────────────────────────────
        $total_revenue = 0.0;
        $orders_count  = 0;
        $paid_orders_count = 0;
        $failed_count  = 0;
        $daily_revenue = [];

        if ($this->db->table_exists('orders')) {
            // Total revenue from all non-cancelled/non-refunded orders
            $rev_q = $this->db->select("
                SUM(CASE WHEN status NOT IN ('cancelled','refunded') AND (payment_status = 'paid' OR payment_status IS NULL OR payment_status != 'failed') THEN total ELSE 0 END) AS total_rev,
                COUNT(*) AS total_orders,
                SUM(CASE WHEN payment_status = 'paid' THEN 1 ELSE 0 END) AS paid_orders,
                SUM(CASE WHEN status IN ('cancelled','refunded') OR payment_status = 'failed' THEN 1 ELSE 0 END) AS failed_orders
            ", false)->where('created_at >=', $from);
            
            if ($has_order_store) {
                $rev_q->where('store_id', $this->store_id);
            }
            $stats = $rev_q->get('orders')->row_array() ?: [];
            $total_revenue     = (float)($stats['total_rev'] ?? 0);
            $orders_count      = (int)($stats['total_orders'] ?? 0);
            $paid_orders_count = (int)($stats['paid_orders'] ?? 0);
            $failed_count      = (int)($stats['failed_orders'] ?? 0);

            // Daily Revenue timeline
            $d_q = $this->db->select("DATE(created_at) AS day, SUM(CASE WHEN status NOT IN ('cancelled','refunded') THEN total ELSE 0 END) AS revenue, COUNT(*) AS orders", false)
                            ->where('created_at >=', $from);
            if ($has_order_store) {
                $d_q->where('store_id', $this->store_id);
            }
            $daily_revenue = $d_q->group_by('DATE(created_at)')->order_by('day', 'ASC')->get('orders')->result_array();
        }

        $valid_orders_count = max(1, $orders_count - $failed_count);
        $aov = $orders_count > 0 ? ($total_revenue / $valid_orders_count) : 0.0;

        // ── Top Products ──────────────────────────────────────
        $top_products = [];
        if ($this->db->table_exists('order_items')) {
            $has_oi_title = $this->db->field_exists('product_title', 'order_items');
            $has_oi_pid   = $this->db->field_exists('product_id', 'order_items');
            $has_oi_vid   = $this->db->field_exists('variant_id', 'order_items');

            if ($has_oi_title) {
                $tp_q = $this->db->select('oi.product_title AS title, SUM(oi.total_price) AS revenue, SUM(oi.quantity) AS units_sold', false)
                                 ->from('order_items oi')
                                 ->join('orders o', 'o.id = oi.order_id', 'left')
                                 ->where('o.created_at >=', $from)
                                 ->where_not_in('o.status', ['cancelled','refunded'])
                                 ->group_by('oi.product_title')
                                 ->order_by('revenue', 'DESC')
                                 ->limit(10);
                if ($has_order_store) {
                    $tp_q->where('o.store_id', $this->store_id);
                }
                $top_products = $tp_q->get()->result_array();
            } elseif ($has_oi_pid && $this->db->table_exists('products')) {
                $tp_q = $this->db->select("oi.product_id, COALESCE(p.title, CONCAT('Product #', oi.product_id)) AS title, SUM(oi.total_price) AS revenue, SUM(oi.quantity) AS units_sold", false)
                                 ->from('order_items oi')
                                 ->join('products p', 'p.id = oi.product_id', 'left')
                                 ->join('orders o', 'o.id = oi.order_id', 'left')
                                 ->where('o.created_at >=', $from)
                                 ->where_not_in('o.status', ['cancelled','refunded'])
                                 ->group_by('oi.product_id')
                                 ->order_by('revenue', 'DESC')
                                 ->limit(10);
                if ($has_order_store) {
                    $tp_q->where('o.store_id', $this->store_id);
                }
                $top_products = $tp_q->get()->result_array();
            }
        }

        // Fallback to products catalog if no order items exist yet
        if (empty($top_products) && $this->db->table_exists('products')) {
            $prod_q = $this->db->select('id AS product_id, title, base_price AS revenue, 0 AS units_sold')->order_by('id', 'DESC')->limit(5);
            if ($has_prod_store) {
                $prod_q->where('store_id', $this->store_id);
            }
            $top_products = $prod_q->get('products')->result_array();
        }

        // ── Pricing Audit Log ─────────────────────────────────
        $pricing_changes = $this->db->table_exists('pricing_audit_log')
            ? $this->db->order_by('id', 'DESC')->limit(15)->get('pricing_audit_log')->result_array()
            : [];

        // ── Customer Stats ────────────────────────────────────
        $new_customers = 0;
        $returning_customers = 0;
        if ($this->db->table_exists('customers')) {
            $nc_q = $this->db->where('created_at >=', $from);
            if ($has_cust_store) {
                $nc_q->where('store_id', $this->store_id);
            }
            $new_customers = $nc_q->count_all_results('customers');
        }

        if ($this->db->table_exists('orders')) {
            $ret_q = $this->db->select('customer_id')
                              ->where('created_at >=', $from)
                              ->where('customer_id IS NOT NULL', null, false)
                              ->where('customer_id >', 0)
                              ->where_not_in('status', ['cancelled','refunded'])
                              ->group_by('customer_id')
                              ->having('COUNT(*) >', 1);
            if ($has_order_store) {
                $ret_q->where('store_id', $this->store_id);
            }
            $returning_customers = $ret_q->count_all_results('orders');
        }

        // ── Collection Revenue ────────────────────────────────
        $collection_revenue = [];
        if ($this->db->table_exists('collections') && $this->db->table_exists('products')) {
            $has_c_title  = $this->db->field_exists('title', 'collections');
            $c_name_col   = $has_c_title ? 'c.title' : ($this->db->field_exists('name', 'collections') ? 'c.name' : '"General Collection"');
            $has_p_col_id = $this->db->field_exists('collection_id', 'products');

            if ($has_p_col_id) {
                $cr_q = $this->db->select("c.id, {$c_name_col} AS name, COUNT(p.id) AS product_count, COALESCE(SUM(p.base_price), 0) AS revenue, 0 AS orders", false)
                                 ->from('collections c')
                                 ->join('products p', 'p.collection_id = c.id', 'left')
                                 ->group_by('c.id')
                                 ->order_by('revenue', 'DESC')
                                 ->limit(8);
                if ($has_prod_store) {
                    $cr_q->where('(p.store_id = '.(int)$this->store_id.' OR p.store_id IS NULL)', null, false);
                }
                $collection_revenue = $cr_q->get()->result_array();
            }
        }

        // ── Loyalty Points Stats ──────────────────────────────
        $loyalty_stats = ['awarded' => 0, 'redeemed' => 0];
        if ($this->db->table_exists('loyalty_transactions')) {
            $lt_q = $this->db->select("SUM(CASE WHEN type='credit' THEN points ELSE 0 END) AS awarded, SUM(CASE WHEN type='debit' THEN points ELSE 0 END) AS redeemed", false)
                             ->where('created_at >=', $from);
            if ($this->db->field_exists('store_id', 'loyalty_transactions')) {
                $lt_q->where('store_id', $this->store_id);
            }
            $loyalty_stats = $lt_q->get('loyalty_transactions')->row_array() ?: ['awarded' => 0, 'redeemed' => 0];
        }

        $data = [
            'title'               => 'Analytics & Reports — NovaDrop Admin',
            'period'              => $days,
            'total_revenue'       => $total_revenue,
            'orders_count'        => $orders_count,
            'paid_orders_count'   => $paid_orders_count,
            'aov'                 => $aov,
            'failed_count'        => $failed_count,
            'daily_revenue'       => $daily_revenue,
            'top_products'        => $top_products,
            'pricing_changes'     => $pricing_changes,
            'new_customers'       => $new_customers,
            'returning_customers' => $returning_customers,
            'collection_revenue'  => $collection_revenue,
            'loyalty_stats'       => $loyalty_stats,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/analytics/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
