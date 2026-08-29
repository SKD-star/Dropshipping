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
        // 1. Registered Users Count
        $users_count = $this->db->count_all('customers');
        if ($users_count === 0 && $this->db->table_exists('user')) {
            $users_count = $this->db->count_all('user');
        }

        // 2. Total Orders Count
        $orders_count = $this->db->count_all('orders');

        // 3. Failed/Cancelled Orders Count
        $failed_count = $this->db->where_in('status', ['cancelled', 'refunded'])
                                 ->or_where('payment_status', 'failed')
                                 ->count_all_results('orders');

        // 4. Pending Support Tickets
        $tickets_count = 0;
        if ($this->db->table_exists('tickets')) {
            $tickets_count = $this->db->where('status', 'Pending')->count_all_results('tickets');
        }

        // 5. Total Payments / Revenue
        $total_payments = 0;
        $rev_query = $this->db->select_sum('total_amount')->where('payment_status', 'paid')->get('orders')->row_array();
        $total_payments = (float)($rev_query['total_amount'] ?? 0);
        if ($total_payments == 0 && $this->db->table_exists('payments')) {
            $p_query = $this->db->select_sum('amount')->where('status', 'captured')->get('payments')->row_array();
            $total_payments = (float)($p_query['amount'] ?? 0);
        }

        // 6. Admin Notifications / Activity Alerts
        $notif_count = 0;
        if ($this->db->table_exists('ai_agent_tasks')) {
            $notif_count = $this->db->where('status', 'pending')->count_all_results('ai_agent_tasks');
        }
        if ($notif_count === 0 && $this->db->table_exists('audit_log')) {
            $notif_count = $this->db->count_all('audit_log');
        }

        $data = [
            'title'          => 'Admin Dashboard — NovaDrop',
            'users_count'    => $users_count,
            'orders_count'   => $orders_count,
            'failed_count'   => $failed_count,
            'tickets_count'  => $tickets_count,
            'total_payments' => $total_payments,
            'notif_count'    => $notif_count,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dashboard/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
