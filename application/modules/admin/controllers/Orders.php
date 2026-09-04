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
        $filter  = $this->input->get('filter', true);
        $cust_id = (int)$this->input->get('customer_id');
        $q       = trim($this->input->get('q', true) ?: '');

        if ($filter === 'failed') {
            $this->db->group_start()
                     ->where_in('status', ['cancelled', 'refunded'])
                     ->or_where('payment_status', 'failed')
                     ->group_end();
        } elseif ($filter === 'unfulfilled') {
            $this->db->where('fulfillment_status !=', 'fulfilled');
        } elseif ($filter === 'paid') {
            $this->db->where('payment_status', 'paid');
        } elseif ($filter === 'buy_now') {
            $this->db->where('channel', 'buy_now');
        }

        if ($cust_id > 0) {
            $this->db->where('customer_id', $cust_id);
        } elseif (!empty($q)) {
            $this->db->group_start()
                     ->like('order_number', $q)
                     ->or_like('guest_email', $q)
                     ->group_end();
        }

        $orders = $this->db->order_by('id', 'DESC')->get('orders')->result_array();

        // Calculate summary metrics
        $total_orders     = count($orders);
        $total_amount     = array_sum(array_map(fn($o) => (float)($o['total'] ?? $o['total_amount'] ?? 0), $orders));
        $unfulfilled_cnt  = count(array_filter($orders, fn($o) => ($o['fulfillment_status'] ?? '') !== 'fulfilled'));
        $paid_cnt         = count(array_filter($orders, fn($o) => ($o['payment_status'] ?? '') === 'paid'));
        $buynow_cnt       = $this->db->where('channel', 'buy_now')->count_all_results('orders');

        $data = [
            'title'            => 'Orders Management — NovaDrop Admin',
            'orders'           => $orders,
            'filter'           => $filter,
            'cust_id'          => $cust_id,
            'q'                => $q,
            'total_orders'     => $total_orders,
            'total_amount'     => $total_amount,
            'unfulfilled_cnt'  => $unfulfilled_cnt,
            'paid_cnt'         => $paid_cnt,
            'buynow_cnt'       => $buynow_cnt,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/orders/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function detail($id)
    {
        $id = (int)$id;
        $order = $this->db->where('id', $id)->get('orders')->row_array();
        if (!$order) {
            if ($this->input->is_ajax_request()) {
                return $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Order not found']));
            }
            show_404();
        }

        $items = $this->db->table_exists('order_items')
            ? $this->db->where('order_id', $id)->get('order_items')->result_array()
            : [];

        $payment = $this->db->table_exists('payments')
            ? $this->db->where('order_id', $id)->order_by('id', 'DESC')->get('payments')->row_array()
            : null;

        if ($this->input->is_ajax_request()) {
            return $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'order'   => $order,
                'items'   => $items,
                'payment' => $payment,
            ]));
        }

        $data = [
            'title'   => "Order #{$order['order_number']} Details — NovaDrop Admin",
            'order'   => $order,
            'items'   => $items,
            'payment' => $payment,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/orders/detail', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function update_status($id)
    {
        $id = (int)$id;
        if ($this->input->method() === 'post') {
            $up = [];
            if ($this->input->post('fulfillment_status')) {
                $up['fulfillment_status'] = trim($this->input->post('fulfillment_status', true));
            }
            if ($this->input->post('payment_status')) {
                $up['payment_status'] = trim($this->input->post('payment_status', true));
            }
            if ($this->input->post('tracking_carrier')) {
                $up['shipping_carrier'] = trim($this->input->post('tracking_carrier', true));
            }
            if ($this->input->post('tracking_number')) {
                $up['tracking_number'] = trim($this->input->post('tracking_number', true));
            }
            if (!empty($up)) {
                $up['updated_at'] = date('Y-m-d H:i:s');
                $this->db->where('id', $id)->update('orders', $up);
                $this->session->set_flashdata('success', "Order #{$id} updated successfully.");
            }
        }
        redirect('admin/orders');
    }
}
