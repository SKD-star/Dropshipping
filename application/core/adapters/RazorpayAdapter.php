<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/../interfaces/PaymentGatewayInterface.php';

/**
 * RazorpayAdapter — implements PaymentGatewayInterface
 * Uses Razorpay REST API v1 (no SDK needed — raw curl)
 * Webhook HMAC-SHA256 verification enforced.
 */
class RazorpayAdapter implements PaymentGatewayInterface
{
    private string $key_id;
    private string $key_secret;
    private string $webhook_secret;
    private string $base_url = 'https://api.razorpay.com/v1/';

    public function __construct()
    {
        $this->key_id       = env('RAZORPAY_KEY_ID', '');
        $this->key_secret   = env('RAZORPAY_KEY_SECRET', '');
        $this->webhook_secret = env('RAZORPAY_WEBHOOK_SECRET', '');
    }

    public function get_slug(): string { return 'razorpay'; }

    public function create_order(array $order): array
    {
        try {
            $is_demo = empty($this->key_id) || strpos($this->key_id, 'XXXXX') !== false || empty($this->key_secret) || strpos($this->key_secret, 'your_secret') !== false;

            if ($is_demo) {
                $mock_order_id = 'order_rzp_' . substr(md5($order['id'] . time()), 0, 14);
                return [
                    'success'          => true,
                    'gateway_order_id' => $mock_order_id,
                    'gateway_data'     => [
                        'key'         => $this->key_id ?: 'rzp_test_lumina',
                        'order_id'    => $mock_order_id,
                        'amount'      => (int)round($order['total'] * 100),
                        'currency'    => $order['currency'] ?? 'INR',
                        'name'        => env('APP_NAME', 'LUMINA ATELIER'),
                        'description' => "Order #{$order['order_number']}",
                        'is_demo'     => true,
                        'prefill'     => [
                            'email' => $order['customer_email'] ?? '',
                            'name'  => $order['customer_name'] ?? '',
                        ],
                        'theme' => ['color' => '#0c0d12'],
                    ],
                ];
            }

            $payload = [
                'amount'          => (int)round($order['total'] * 100),  // paise
                'currency'        => $order['currency'] ?? 'INR',
                'receipt'         => 'order_' . $order['id'],
                'notes'           => [
                    'novadrop_order_id' => $order['id'],
                    'customer_email'    => $order['customer_email'] ?? '',
                ],
            ];
            $response = $this->_api_call('POST', 'orders', $payload);
            if (empty($response['id'])) {
                return ['success' => false, 'error' => 'Razorpay did not return an order ID'];
            }
            return [
                'success'          => true,
                'gateway_order_id' => $response['id'],
                'gateway_data'     => [
                    'key'         => $this->key_id,
                    'order_id'    => $response['id'],
                    'amount'      => $payload['amount'],
                    'currency'    => $payload['currency'],
                    'name'        => env('APP_NAME', 'LUMINA ATELIER'),
                    'description' => "Order #{$order['order_number']}",
                    'is_demo'     => false,
                    'prefill'     => [
                        'email' => $order['customer_email'] ?? '',
                        'name'  => $order['customer_name'] ?? '',
                    ],
                    'theme' => ['color' => '#0c0d12'],
                ],
            ];
        } catch (Throwable $e) {
            $this->_log_error($e, 'create_order');
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function verify_payment(array $payload): array
    {
        try {
            $order_id   = $payload['razorpay_order_id']   ?? '';
            $payment_id = $payload['razorpay_payment_id'] ?? '';
            $signature  = $payload['razorpay_signature']  ?? '';

            if (empty($order_id) || empty($payment_id)) {
                return ['success' => false, 'error' => 'Missing Razorpay payload fields'];
            }

            // Demo mode is ONLY when credentials are genuinely missing/placeholder
            // Never base demo-mode on the order_id string pattern — that bypassed real-money verification
            $is_demo = empty($this->key_secret) || strpos($this->key_secret, 'your_secret') !== false;
            if ($is_demo) {
                // In demo mode, still require a non-empty signature field as a basic sanity check
                if (empty($signature)) {
                    return ['success' => false, 'error' => 'Missing payment signature'];
                }
                return [
                    'success'            => true,
                    'gateway_payment_id' => $payment_id ?: ('pay_demo_' . substr(md5(uniqid()), 0, 14)),
                    'status'             => 'captured',
                    'amount_captured'    => 0,
                    'is_demo'            => true,
                ];
            }

            // Production: strict HMAC-SHA256 signature verification required
            if (empty($signature)) {
                return ['success' => false, 'error' => 'Missing payment signature'];
            }

            $expected = hash_hmac('sha256', "$order_id|$payment_id", $this->key_secret);
            if ( ! hash_equals($expected, $signature)) {
                return ['success' => false, 'error' => 'Signature verification failed'];
            }

            // Fetch payment details from Razorpay to confirm amount
            $payment = $this->_api_call('GET', "payments/$payment_id");

            return [
                'success'            => true,
                'gateway_payment_id' => $payment_id,
                'status'             => $payment['status'] ?? 'authorized',
                'amount_captured'    => ($payment['amount'] ?? 0) / 100,
            ];
        } catch (Throwable $e) {
            $this->_log_error($e, 'verify_payment');
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function refund(string $gateway_payment_id, float $amount, string $reason = ''): array
    {
        try {
            $payload = [
                'amount' => (int)round($amount * 100),
                'notes'  => ['reason' => $reason],
            ];
            $response = $this->_api_call('POST', "payments/{$gateway_payment_id}/refund", $payload);
            return [
                'success'           => true,
                'gateway_refund_id' => $response['id'] ?? '',
                'status'            => $response['status'] ?? 'initiated',
            ];
        } catch (Throwable $e) {
            $this->_log_error($e, 'refund');
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function verify_webhook(string $raw_body, array $headers): bool
    {
        $signature = $headers['X-Razorpay-Signature'] ?? $headers['x-razorpay-signature'] ?? '';
        if (empty($signature) || empty($this->webhook_secret)) {
            return false;
        }
        $expected = hash_hmac('sha256', $raw_body, $this->webhook_secret);
        return hash_equals($expected, $signature);
    }

    public function parse_webhook(string $raw_body): array
    {
        $data = json_decode($raw_body, true) ?? [];
        $event   = $data['event'] ?? '';
        $payload = $data['payload'] ?? [];

        $payment_entity = $payload['payment']['entity'] ?? [];
        $order_entity   = $payload['order']['entity']   ?? [];

        return [
            'event'              => $event,
            'gateway_payment_id' => $payment_entity['id'] ?? '',
            'gateway_order_id'   => $order_entity['id']   ?? ($payment_entity['order_id'] ?? ''),
            'amount'             => ($payment_entity['amount'] ?? 0) / 100,
            'status'             => $payment_entity['status'] ?? '',
            'raw'                => $data,
        ];
    }

    // ─── Private helpers ─────────────────────────────────────

    private function _api_call(string $method, string $endpoint, array $body = []): array
    {
        $ch = curl_init($this->base_url . $endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD        => "{$this->key_id}:{$this->key_secret}",
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'Accept: application/json'],
            CURLOPT_TIMEOUT        => 15,
        ]);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }
        $raw = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($raw === false || $curl_error) {
            throw new RuntimeException("Razorpay curl error: $curl_error");
        }
        $decoded = json_decode($raw, true);
        if ($http_code >= 400) {
            $msg = $decoded['error']['description'] ?? "HTTP $http_code";
            throw new RuntimeException("Razorpay API error: $msg");
        }
        return $decoded ?? [];
    }

    private function _log_error(Throwable $e, string $context): void
    {
        log_message('error', "[RazorpayAdapter::$context] " . $e->getMessage() . "\n" . $e->getTraceAsString());
        // Error table insert happens at controller level via $this->log_error()
    }
}
