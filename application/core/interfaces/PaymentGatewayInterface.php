<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PaymentGatewayInterface
 * Every payment adapter (Razorpay, Stripe, COD) implements this contract.
 * No feature code should call a gateway directly — always through this interface.
 */
interface PaymentGatewayInterface
{
    /**
     * Create a payment order/intent on the gateway.
     * Returns a gateway-specific order reference needed by the frontend SDK.
     *
     * @param  array  $order  ['id', 'total', 'currency', 'customer_email', 'customer_name']
     * @return array  ['success', 'gateway_order_id', 'gateway_data' (for frontend SDK init)]
     */
    public function create_order(array $order): array;

    /**
     * Verify and capture a payment after frontend SDK callback.
     *
     * @param  array  $payload  Raw POST data from the frontend / webhook
     * @return array  ['success', 'gateway_payment_id', 'status', 'amount_captured']
     */
    public function verify_payment(array $payload): array;

    /**
     * Process a full or partial refund.
     *
     * @param  string  $gateway_payment_id  Original payment ID from gateway
     * @param  float   $amount              Amount to refund (in major currency unit)
     * @param  string  $reason
     * @return array   ['success', 'gateway_refund_id', 'status']
     */
    public function refund(string $gateway_payment_id, float $amount, string $reason = ''): array;

    /**
     * Verify a raw inbound webhook (HMAC signature check).
     * MUST be called before processing any webhook payload.
     *
     * @param  string  $raw_body    Raw request body (do NOT json_decode before this)
     * @param  array   $headers     All HTTP headers as key=>value
     * @return bool
     */
    public function verify_webhook(string $raw_body, array $headers): bool;

    /**
     * Parse a verified webhook body into a normalized event.
     *
     * @param  string  $raw_body
     * @return array   ['event', 'gateway_payment_id', 'gateway_order_id', 'amount', 'status', 'raw']
     */
    public function parse_webhook(string $raw_body): array;

    /**
     * Get the gateway slug used in the `payments` table.
     */
    public function get_slug(): string;
}
