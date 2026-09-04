<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/interfaces/PaymentGatewayInterface.php';
require_once APPPATH . 'core/adapters/StripeAdapter.php';

/**
 * Stripe Payment Controller
 * Handles Checkout Session redirect, verification callback, and webhooks
 */
class Stripe extends MY_Controller
{
    private StripeAdapter $adapter;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('orders/Order_model');
        $this->adapter = new StripeAdapter();
    }

    public function init()
    {
        $order_id = (int)$this->input->get('order_id');
        $order = $this->Order_model->get_with_items($order_id);

        if (!$order) {
            redirect('');
            return;
        }

        $res = $this->adapter->create_order($order);

        if ($res['success'] && !empty($res['redirect_url'])) {
            $this->db->insert('payments', [
                'order_id'         => $order['id'],
                'store_id'         => $this->store_id,
                'gateway'          => 'stripe',
                'gateway_order_id' => $res['gateway_order_id'],
                'amount'           => $order['total'],
                'currency'         => $order['currency'],
                'status'           => 'created',
                'created_at'       => date('Y-m-d H:i:s'),
            ]);

            redirect($res['redirect_url']);
        } else {
            $this->session->set_flashdata('error', 'Stripe checkout error: ' . ($res['error'] ?? 'Unknown error'));
            redirect('checkout');
        }
    }

    public function verify()
    {
        $session_id = $this->input->get('session_id', true);

        if (empty($session_id)) {
            $this->session->set_flashdata('error', 'Invalid payment session.');
            redirect('checkout');
            return;
        }

        // Authoritative: look up which order this session_id actually belongs to
        // The payment row was inserted at init() time when we controlled the data
        $payment = $this->db->where('gateway_order_id', $session_id)
                            ->where('gateway', 'stripe')
                            ->get('payments')->row_array();

        if (!$payment) {
            $this->session->set_flashdata('error', 'Payment session not found.');
            redirect('checkout');
            return;
        }

        $order_id = (int)$payment['order_id'];

        // Idempotency guard: if already captured, don't re-process
        if ($payment['status'] === 'captured') {
            redirect('checkout/success/' . $order_id);
            return;
        }

        $res = $this->adapter->verify_payment(['session_id' => $session_id]);

        if ($res['success']) {
            $this->db->where('id', $payment['id'])
                     ->where('status', 'created')   // Prevent double-capture
                     ->update('payments', [
                         'gateway_payment_id' => $res['gateway_payment_id'],
                         'status'             => 'captured',
                         'updated_at'         => date('Y-m-d H:i:s'),
                     ]);

            $this->Order_model->mark_paid($order_id, $res['gateway_payment_id'], 'stripe');
            $this->session->unset_userdata('cart_id');
            redirect('checkout/success/' . $order_id);
        } else {
            $this->session->set_flashdata('error', 'Payment verification failed.');
            redirect('checkout');
        }
    }

    public function webhook()
    {
        $raw_body = file_get_contents('php://input');
        $headers  = getallheaders();

        if (!$this->adapter->verify_webhook($raw_body, $headers)) {
            $this->output->set_status_header(400)->set_output('Invalid Stripe signature');
            return;
        }

        $event = $this->adapter->parse_webhook($raw_body);
        $hash = hash('sha256', $raw_body);

        $exists = $this->db->where('payload_hash', $hash)->count_all_results('webhooks_log');
        if ($exists) {
            $this->output->set_status_header(200)->set_output('OK - Already processed');
            return;
        }

        $this->db->insert('webhooks_log', [
            'store_id'     => $this->store_id,
            'source'       => 'stripe',
            'event'        => $event['event'],
            'payload_hash' => $hash,
            'raw_body'     => $raw_body,
            'headers'      => json_encode($headers),
            'hmac_valid'   => 1,
            'processed'    => 1,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        if ($event['event'] === 'checkout.session.completed') {
            $payment = $this->db->where('gateway_order_id', $event['gateway_order_id'])->get('payments')->row_array();
            if ($payment) {
                $this->Order_model->mark_paid($payment['order_id'], $event['gateway_payment_id'], 'stripe');
            }
        }

        $this->output->set_status_header(200)->set_output('OK');
    }
}
