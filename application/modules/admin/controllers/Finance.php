<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $payments = [];
        if ($this->db->table_exists('payments')) {
            $payments = $this->db->order_by('id', 'DESC')->get('payments')->result_array();
        }

        $paid_orders = $this->db->where('payment_status', 'paid')->order_by('id', 'DESC')->get('orders')->result_array();

        $data = [
            'title'       => 'Payments & Finance — NovaDrop Admin',
            'payments'    => $payments,
            'paid_orders' => $paid_orders,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/finance/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
