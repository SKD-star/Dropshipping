<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/interfaces/PaymentGatewayInterface.php';
require_once APPPATH . 'core/adapters/RazorpayAdapter.php';

/**
 * Razorpay Payment Controller
 * Handles order checkout init popup, client verification callback, and webhooks with HMAC SHA256 validation
 */
class Razorpay extends MY_Controller
{
    private RazorpayAdapter $adapter;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('orders/Order_model');
        $this->adapter = new RazorpayAdapter();
    }

    public function init()
    {
        $order_id = (int)$this->input->get('order_id');
        $order = $this->Order_model->get_with_items($order_id);

        if (!$order) {
            redirect('');
            return;
        }

        $res = $this->adapter->create_order([
            'id'             => $order['id'],
            'order_number'   => $order['order_number'],
            'total'          => (float)$order['total'],
            'currency'       => $order['currency'],
            'customer_email' => $order['guest_email'],
            'customer_name'  => $order['shipping_address']['first_name'] ?? 'Customer',
        ]);

        if (!$res['success']) {
            $this->session->set_flashdata('error', 'Unable to initiate Razorpay: ' . $res['error']);
            redirect('checkout');
            return;
        }

        // Save gateway order ID
        $this->db->insert('payments', [
            'order_id'         => $order['id'],
            'store_id'         => $this->store_id,
            'gateway'          => 'razorpay',
            'gateway_order_id' => $res['gateway_order_id'],
            'amount'           => $order['total'],
            'currency'         => $order['currency'],
            'status'           => 'created',
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        $data = [
            'order'        => $order,
            'gateway_data' => $res['gateway_data'],
        ];

        $this->load->view('payments/razorpay_checkout', $data);
    }

    public function verify()
    {
        $order_id = (int)$this->input->post('order_id');
        $payload = [
            'razorpay_order_id'   => $this->input->post('razorpay_order_id', true),
            'razorpay_payment_id' => $this->input->post('razorpay_payment_id', true),
            'razorpay_signature'  => $this->input->post('razorpay_signature', true),
        ];

        $res = $this->adapter->verify_payment($payload);

        if ($res['success']) {
            $this->db->where('order_id', $order_id)
                     ->where('gateway', 'razorpay')
                     ->update('payments', [
                         'gateway_payment_id' => $res['gateway_payment_id'],
                         'status'             => 'captured',
                         'updated_at'         => date('Y-m-d H:i:s'),
                     ]);

            $this->Order_model->mark_paid($order_id, $res['gateway_payment_id'], 'razorpay');
            $this->session->unset_userdata('cart_id');
            redirect('checkout/success/' . $order_id);
        } else {
            $this->session->set_flashdata('error', 'Payment verification failed: ' . $res['error']);
            redirect('checkout');
        }
    }

    public function webhook()
    {
        $raw_body = file_get_contents('php://input');
        $headers  = getallheaders();

        if (!$this->adapter->verify_webhook($raw_body, $headers)) {
            $this->output->set_status_header(400)->set_output('Invalid HMAC Signature');
            return;
        }

        $event = $this->adapter->parse_webhook($raw_body);

        // Deduplication & logging
        $hash = hash('sha256', $raw_body);
        $exists = $this->db->where('payload_hash', $hash)->count_all_results('webhooks_log');
        if ($exists) {
            $this->output->set_status_header(200)->set_output('OK - Already processed');
            return;
        }

        $this->db->insert('webhooks_log', [
            'store_id'     => $this->store_id,
            'source'       => 'razorpay',
            'event'        => $event['event'],
            'payload_hash' => $hash,
            'raw_body'     => $raw_body,
            'headers'      => json_encode($headers),
            'hmac_valid'   => 1,
            'processed'    => 1,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        if ($event['event'] === 'payment.captured' || $event['event'] === 'order.paid') {
            $payment = $this->db->where('gateway_order_id', $event['gateway_order_id'])->get('payments')->row_array();
            if ($payment) {
                $this->Order_model->mark_paid($payment['order_id'], $event['gateway_payment_id'], 'razorpay');
            }
        }

        $this->output->set_status_header(200)->set_output('OK');
    }
}
