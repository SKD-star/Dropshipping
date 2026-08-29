<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * COD Payment Controller
 * Handles Cash on Delivery order finalization
 */
class Cod extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('orders/Order_model');
    }

    public function place()
    {
        $order_id = (int)$this->input->post('order_id');
        $order = $this->Order_model->get_with_items($order_id);

        if (!$order) {
            redirect('checkout');
            return;
        }

        $this->db->insert('payments', [
            'order_id'   => $order['id'],
            'store_id'   => $this->store_id,
            'gateway'    => 'cod',
            'amount'     => $order['total'],
            'currency'   => $order['currency'],
            'status'     => 'created',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->unset_userdata('cart_id');
        redirect('checkout/success/' . $order_id);
    }
}
