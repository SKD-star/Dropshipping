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
        $from   = date('Y-m-d', strtotime("-{$days} days"));

        // ── Revenue ──────────────────────────────────────────
        $rev_row = $this->db->select_sum('total_amount')
                             ->where('payment_status', 'paid')
                             ->where('created_at >=', $from)
                             ->get('orders')->row_array();
        $total_revenue = (float)($rev_row['total_amount'] ?? 0);

        $orders_count = $this->db->where('created_at >=', $from)->count_all_results('orders');
        $aov = $orders_count > 0 ? $total_revenue / $orders_count : 0;

        // ── Failed / refunded ─────────────────────────────────
        $failed_count = $this->db->where_in('status', ['cancelled','refunded'])
                                  ->or_where('payment_status', 'failed')
                                  ->where('created_at >=', $from)
                                  ->count_all_results('orders');

        // ── Daily Revenue for chart ───────────────────────────
        $daily_revenue = $this->db
            ->select("DATE(created_at) AS day, SUM(total_amount) AS revenue, COUNT(*) AS orders")
            ->where('payment_status', 'paid')
            ->where('created_at >=', $from)
            ->group_by('DATE(created_at)')
            ->order_by('day', 'ASC')
            ->get('orders')->result_array();

        // ── Top Products ──────────────────────────────────────
        $top_products = $this->db->table_exists('product_performance_metrics')
            ? $this->db
                ->select('ppm.*, p.title, p.base_price')
                ->from('product_performance_metrics ppm')
                ->join('products p', 'p.id = ppm.product_id', 'left')
                ->where('ppm.store_id', $this->store_id)
                ->order_by('ppm.revenue', 'DESC')
                ->limit(10)
                ->get()->result_array()
            : $this->db
                ->select('oi.product_id, p.title, SUM(oi.total_price) AS revenue, SUM(oi.quantity) AS units_sold')
                ->from('order_items oi')
                ->join('products p', 'p.id = oi.product_id', 'left')
                ->join('orders o', 'o.id = oi.order_id', 'left')
                ->where('o.payment_status', 'paid')
                ->where('o.created_at >=', $from)
                ->group_by('oi.product_id')
                ->order_by('revenue', 'DESC')
                ->limit(10)
                ->get()->result_array();

        // ── Pricing Audit Log ─────────────────────────────────
        $pricing_changes = $this->db->table_exists('pricing_audit_log')
            ? $this->db->order_by('id', 'DESC')->limit(20)->get('pricing_audit_log')->result_array()
            : [];

        // ── Customer Stats ────────────────────────────────────
        $new_customers = $this->db->where('created_at >=', $from)->count_all_results('customers');
        $returning_customers = $this->db
            ->select('customer_id')
            ->where('payment_status', 'paid')
            ->where('created_at >=', $from)
            ->where('customer_id IS NOT NULL', null, false)
            ->group_by('customer_id')
            ->having('COUNT(*) >', 1)
            ->count_all_results('orders');

        // ── Collection Revenue ────────────────────────────────
        $collection_revenue = $this->db
            ->select('c.name, SUM(oi.total_price) AS revenue, COUNT(DISTINCT o.id) AS orders')
            ->from('order_items oi')
            ->join('orders o', 'o.id = oi.order_id', 'left')
            ->join('products p', 'p.id = oi.product_id', 'left')
            ->join('collections c', 'c.id = p.collection_id', 'left')
            ->where('o.payment_status', 'paid')
            ->where('o.created_at >=', $from)
            ->group_by('p.collection_id')
            ->order_by('revenue', 'DESC')
            ->limit(8)
            ->get()->result_array();

        // ── Loyalty Points Stats ──────────────────────────────
        $loyalty_stats = [];
        if ($this->db->table_exists('loyalty_transactions')) {
            $lt_row = $this->db->select("SUM(CASE WHEN type='credit' THEN points ELSE 0 END) AS awarded, SUM(CASE WHEN type='debit' THEN points ELSE 0 END) AS redeemed", false)
                               ->where('created_at >=', $from)
                               ->get('loyalty_transactions')->row_array();
            $loyalty_stats = $lt_row;
        }

        $data = [
            'title'               => 'Analytics & Reports — NovaDrop Admin',
            'period'              => $days,
            'total_revenue'       => $total_revenue,
            'orders_count'        => $orders_count,
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
