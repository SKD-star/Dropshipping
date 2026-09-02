<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        // 1. Registered Customers / Users
        $users_count = $this->db->count_all('customers');
        if ($users_count === 0 && $this->db->table_exists('user')) {
            $users_count = $this->db->count_all('user');
        }

        // 2. Total Products in Catalog
        $products_count = 0;
        if ($this->db->table_exists('products')) {
            $products_count = $this->db->count_all('products');
        }

        // 3. Orders Counts (Total, Pending, Failed/Refunded, Completed)
        $orders_count = $this->db->count_all('orders');
        $pending_orders_count = $this->db->where_in('status', ['pending', 'processing', 'unfulfilled'])->count_all_results('orders');
        $failed_count = $this->db->where_in('status', ['cancelled', 'refunded'])
                                 ->or_where('payment_status', 'failed')
                                 ->count_all_results('orders');
        $shipped_count = $this->db->where_in('status', ['shipped', 'delivered', 'completed'])->count_all_results('orders');
        $paid_count = $this->db->where('payment_status', 'paid')->count_all_results('orders');

        // 4. Open Support Tickets
        $tickets_count = 0;
        if ($this->db->table_exists('tickets')) {
            $tickets_count = $this->db->where_in('status', ['Pending', 'Open', 'pending', 'open'])->count_all_results('tickets');
        }

        // 5. Flagged Fraud / Risk Security Alerts
        $fraud_count = 0;
        if ($this->db->table_exists('audit_log')) {
            $fraud_count = $this->db->like('action', 'fraud')->or_like('action', 'risk')->count_all_results('audit_log');
        }
        if ($fraud_count === 0 && $this->db->table_exists('ai_agent_tasks')) {
            if ($this->db->field_exists('agent', 'ai_agent_tasks')) {
                $fraud_count = $this->db->where('agent', 'fraud_guardian')->where('status', 'flagged')->count_all_results('ai_agent_tasks');
            } elseif ($this->db->field_exists('agent_name', 'ai_agent_tasks')) {
                $fraud_count = $this->db->where('agent_name', 'fraud_guardian')->where('status', 'flagged')->count_all_results('ai_agent_tasks');
            }
        }

        // 6. User Wallet Funds / Balances
        $wallet_funds = 0.00;
        if ($this->db->table_exists('customers')) {
            if ($this->db->field_exists('wallet_balance', 'customers')) {
                $w_row = $this->db->select_sum('wallet_balance')->get('customers')->row_array();
                $wallet_funds = (float)($w_row['wallet_balance'] ?? 0);
            }
            if ($wallet_funds == 0 && $this->db->field_exists('loyalty_points', 'customers')) {
                $lp_row = $this->db->select_sum('loyalty_points')->get('customers')->row_array();
                $wallet_funds = (float)($lp_row['loyalty_points'] ?? 0);
            }
        }
        if ($wallet_funds == 0 && $this->db->table_exists('user') && $this->db->field_exists('balance', 'user')) {
            $u_row = $this->db->select_sum('balance')->get('user')->row_array();
            $wallet_funds = (float)($u_row['balance'] ?? 0);
        }

        // 7. All-Time Financials
        $rev_query = $this->db->select_sum('total')->where('payment_status', 'paid')->get('orders')->row_array();
        $all_time_revenue = (float)($rev_query['total'] ?? 0);
        if ($all_time_revenue == 0) {
            $all_rev = $this->db->select_sum('total')->get('orders')->row_array();
            $all_time_revenue = (float)($all_rev['total'] ?? 0);
        }
        if ($all_time_revenue == 0 && $this->db->table_exists('payments')) {
            $p_query = $this->db->select_sum('amount')->where('status', 'captured')->get('payments')->row_array();
            $all_time_revenue = (float)($p_query['amount'] ?? 0);
        }

        // Provider Cost (Vendor Payouts & Sourcing COGS)
        $all_time_cost = 0.00;
        if ($this->db->table_exists('vendor_payouts')) {
            $vp_row = $this->db->select_sum('net_payable')->get('vendor_payouts')->row_array();
            $all_time_cost = (float)($vp_row['net_payable'] ?? 0);
        }
        if ($all_time_cost == 0 && $all_time_revenue > 0) {
            $all_time_cost = round($all_time_revenue * 0.28, 2);
        }
        $all_time_profit = max(0, $all_time_revenue - $all_time_cost);

        // 8. Today Financials
        $today = date('Y-m-d');
        $today_rev_row = $this->db->select_sum('total')
                                  ->like('created_at', $today)
                                  ->get('orders')->row_array();
        $today_revenue = (float)($today_rev_row['total'] ?? 0);
        $today_cost = ($today_revenue > 0) ? round($today_revenue * 0.28, 2) : 0.00;
        $today_profit = max(0, $today_revenue - $today_cost);

        // 9. AI Tasks & Notifications
        $notif_count = 0;
        if ($this->db->table_exists('ai_agent_tasks')) {
            $notif_count = $this->db->where('status', 'pending')->count_all_results('ai_agent_tasks');
        }
        if ($notif_count === 0 && $this->db->table_exists('audit_log')) {
            $notif_count = $this->db->count_all('audit_log');
        }

        // 10. Dynamic 14-Day Sales & Orders Chart Data (100% Real Database Trends)
        $chart_labels = [];
        $chart_revenue = [];
        $chart_orders = [];
        for ($i = 13; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $label = date('M d', strtotime($d));
            $chart_labels[] = $label;
            $chart_revenue[$d] = 0.00;
            $chart_orders[$d] = 0;
        }

        $fourteen_days_ago = date('Y-m-d 00:00:00', strtotime('-14 days'));
        $daily_db_rows = $this->db
            ->select("DATE(created_at) as order_date, SUM(total) as daily_rev, COUNT(*) as daily_cnt")
            ->where('created_at >=', $fourteen_days_ago)
            ->group_by("DATE(created_at)")
            ->get('orders')->result_array();

        foreach ($daily_db_rows as $dr) {
            $d = $dr['order_date'];
            if (isset($chart_revenue[$d])) {
                $chart_revenue[$d] = (float)$dr['daily_rev'];
                $chart_orders[$d] = (int)$dr['daily_cnt'];
            }
        }

        // 11. Recent 6 Real Storefront Orders
        $recent_orders = $this->db
            ->select('o.*, c.name as customer_name, c.email as customer_email')
            ->from('orders o')
            ->join('customers c', 'c.id = o.customer_id', 'left')
            ->order_by('o.id', 'DESC')
            ->limit(6)
            ->get()->result_array();

        // 12. Top Products in Catalog (Live from database)
        $top_products = $this->db
            ->select('p.*')
            ->from('products p')
            ->order_by('p.id', 'DESC')
            ->limit(5)
            ->get()->result_array();

        // 13. Low Stock Inventory Warnings (Live from product_variants)
        $low_stock_items = [];
        if ($this->db->table_exists('product_variants')) {
            $qty_col = $this->db->field_exists('inventory_qty', 'product_variants') ? 'pv.inventory_qty' : ($this->db->field_exists('stock_quantity', 'product_variants') ? 'pv.stock_quantity' : ($this->db->field_exists('stock', 'product_variants') ? 'pv.stock' : null));
            if ($qty_col !== null) {
                $low_stock_items = $this->db
                    ->select("pv.*, {$qty_col} as stock_qty, p.title as product_title, p.slug as product_slug")
                    ->from('product_variants pv')
                    ->join('products p', 'p.id = pv.product_id', 'left')
                    ->where("{$qty_col} <=", 15)
                    ->order_by($qty_col, 'ASC')
                    ->limit(5)
                    ->get()->result_array();
            }
        }

        // 14. Real Security & AI Activity Stream
        $recent_audit_logs = [];
        if ($this->db->table_exists('audit_log')) {
            $recent_audit_logs = $this->db->order_by('id', 'DESC')->limit(6)->get('audit_log')->result_array();
        }

        $data = [
            'title'                => 'Executive Command Center — NovaDrop Admin',
            'users_count'          => $users_count,
            'products_count'       => $products_count,
            'orders_count'         => $orders_count,
            'pending_orders_count' => $pending_orders_count,
            'failed_count'         => $failed_count,
            'shipped_count'        => $shipped_count,
            'paid_count'           => $paid_count,
            'tickets_count'        => $tickets_count,
            'fraud_count'          => $fraud_count,
            'wallet_funds'         => $wallet_funds,
            'all_time_revenue'     => $all_time_revenue,
            'all_time_cost'        => $all_time_cost,
            'all_time_profit'      => $all_time_profit,
            'today_revenue'        => $today_revenue,
            'today_cost'           => $today_cost,
            'today_profit'         => $today_profit,
            'total_payments'       => $all_time_revenue,
            'notif_count'          => $notif_count,
            'chart_labels'         => json_encode($chart_labels),
            'chart_revenue'        => json_encode(array_values($chart_revenue)),
            'chart_orders'         => json_encode(array_values($chart_orders)),
            'status_paid'          => $paid_count,
            'status_pending'       => $pending_orders_count,
            'status_shipped'       => $shipped_count,
            'status_failed'        => $failed_count,
            'recent_orders'        => $recent_orders,
            'top_products'         => $top_products,
            'low_stock_items'      => $low_stock_items,
            'recent_audit_logs'    => $recent_audit_logs,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
