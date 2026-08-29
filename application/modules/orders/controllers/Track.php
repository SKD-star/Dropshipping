<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $order_number = trim($this->input->get('order_number', true) ?: $this->input->post('order_number', true) ?: '');
        $email_or_phone = trim($this->input->get('contact', true) ?: $this->input->post('contact', true) ?: '');

        $order = null;
        $items = [];
        $fulfillments = [];

        if (!empty($order_number)) {
            $this->db->group_start()
                ->where('order_number', $order_number)
                ->or_where('id', (int)$order_number)
                ->group_end();

            if (!empty($email_or_phone)) {
                $this->db->group_start()
                    ->where('customer_email', $email_or_phone)
                    ->or_where('customer_phone', $email_or_phone)
                    ->group_end();
            }

            $order = $this->db->get('orders')->row_array();

            if ($order) {
                $items = $this->db->where('order_id', $order['id'])->get('order_items')->result_array();
                if ($this->db->table_exists('fulfillments')) {
                    $fulfillments = $this->db->where('order_id', $order['id'])->order_by('id', 'ASC')->get('fulfillments')->result_array();
                }
            } else {
                $this->session->set_flashdata('error', 'No order found matching the provided details.');
            }
        }

        $data = [
            'title'          => 'Track Your Order — NovaDrop',
            'order_number'   => $order_number,
            'email_or_phone' => $email_or_phone,
            'order'          => $order,
            'items'          => $items,
            'fulfillments'   => $fulfillments,
        ];

        // Load storefront layout if available
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('orders/track', $data);
        $this->load->view('storefront/layout/footer', $data);
    }
}
