<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $filter = $this->input->get('filter', true);
        if ($filter === 'failed') {
            $this->db->group_start()
                     ->where_in('status', ['cancelled', 'refunded'])
                     ->or_where('payment_status', 'failed')
                     ->group_end();
        }

        $orders = $this->db->order_by('id', 'DESC')->get('orders')->result_array();

        $data = [
            'title'  => 'Orders Management — NovaDrop Admin',
            'orders' => $orders,
            'filter' => $filter,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/orders/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
