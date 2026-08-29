<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/../interfaces/PaymentGatewayInterface.php';

/**
 * StripeAdapter — implements PaymentGatewayInterface
 * Supports Stripe Checkout Session & PaymentIntent API with Webhook HMAC verification
 */
class StripeAdapter implements PaymentGatewayInterface
{
    private string $secret_key;
    private string $webhook_secret;

    public function __construct()
    {
        $this->secret_key     = env('STRIPE_SECRET_KEY', '');
        $this->webhook_secret = env('STRIPE_WEBHOOK_SECRET', '');
        if (!empty($this->secret_key) && class_exists('\Stripe\Stripe')) {
            \Stripe\Stripe::setApiKey($this->secret_key);
        }
    }

    public function get_slug(): string { return 'stripe'; }

    public function create_order(array $order): array
    {
        try {
            if (empty($this->secret_key) || !class_exists('\Stripe\Checkout\Session')) {
                return ['success' => false, 'error' => 'Stripe credentials not configured'];
            }

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency'     => strtolower($order['currency'] ?? 'inr'),
                        'product_data' => [
                            'name' => 'Order #' . $order['order_number'],
                        ],
                        'unit_amount'  => (int)round($order['total'] * 100),
                    ],
                    'quantity'   => 1,
                ]],
                'mode'        => 'payment',
                'success_url' => base_url('payments/stripe/verify?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order['id']),
                'cancel_url'  => base_url('checkout/failed?order_id=' . $order['id']),
                'customer_email' => $order['guest_email'] ?? null,
                'metadata'    => [
                    'order_id' => $order['id'],
                ],
            ]);

            return [
                'success'          => true,
                'gateway_order_id' => $session->id,
                'redirect_url'     => $session->url,
            ];
        } catch (Throwable $e) {
            log_message('error', '[StripeAdapter::create_order] ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function verify_payment(array $payload): array
    {
        try {
            $session_id = $payload['session_id'] ?? '';
            if (empty($session_id) || !class_exists('\Stripe\Checkout\Session')) {
                return ['success' => false, 'error' => 'Invalid session ID'];
            }

            $session = \Stripe\Checkout\Session::retrieve($session_id);
            if ($session->payment_status === 'paid') {
                return [
                    'success'            => true,
                    'gateway_payment_id' => $session->payment_intent,
                    'status'             => 'paid',
                    'amount_captured'    => ($session->amount_total ?? 0) / 100,
                ];
            }

            return ['success' => false, 'error' => 'Payment status: ' . $session->payment_status];
        } catch (Throwable $e) {
            log_message('error', '[StripeAdapter::verify_payment] ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function refund(string $gateway_payment_id, float $amount, string $reason = ''): array
    {
        try {
            if (!class_exists('\Stripe\Refund')) {
                return ['success' => false, 'error' => 'Stripe library missing'];
            }
            $refund = \Stripe\Refund::create([
                'payment_intent' => $gateway_payment_id,
                'amount'         => (int)round($amount * 100),
            ]);
            return [
                'success'           => true,
                'gateway_refund_id' => $refund->id,
                'status'            => $refund->status,
            ];
        } catch (Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function verify_webhook(string $raw_body, array $headers): bool
    {
        $sig_header = $headers['Stripe-Signature'] ?? $headers['stripe-signature'] ?? '';
        if (empty($sig_header) || empty($this->webhook_secret)) return false;

        try {
            \Stripe\Webhook::constructEvent($raw_body, $sig_header, $this->webhook_secret);
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function parse_webhook(string $raw_body): array
    {
        $data = json_decode($raw_body, true) ?? [];
        $type = $data['type'] ?? '';
        $obj  = $data['data']['object'] ?? [];

        return [
            'event'              => $type,
            'gateway_payment_id' => $obj['payment_intent'] ?? ($obj['id'] ?? ''),
            'gateway_order_id'   => $obj['id'] ?? '',
            'amount'             => ($obj['amount_total'] ?? ($obj['amount'] ?? 0)) / 100,
            'status'             => $obj['payment_status'] ?? ($obj['status'] ?? ''),
            'raw'                => $data,
        ];
    }
}
