<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Checkout_model
 * Handles tax calculations (GST: CGST/SGST/IGST), shipping rate calculation, and atomic checkout validation
 */
class Checkout_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['cart/Cart_model', 'orders/Order_model']);
    }

    /**
     * Compute full order financial summary:
     * subtotal, discount, shipping, tax breakdown (CGST, SGST, IGST), grand total
     */
    public function calculate_totals(string $cart_id, ?array $shipping_address = null): array
    {
        $cart = $this->Cart_model->get_or_create($cart_id);
        $items = $this->Cart_model->get_items($cart_id);
        $subtotal = $this->Cart_model->get_subtotal($cart_id);

        $discount_amount = (float)($cart['discount_amount'] ?? 0);
        $discounted_subtotal = max(0, $subtotal - $discount_amount);

        // Calculate shipping
        $shipping_amount = 0.00;
        if ($discounted_subtotal < 500) {
            $shipping_amount = 60.00; // Flat ₹60 if under ₹500
        }

        // GST Tax calculation (Assuming 18% standard GST inclusive in product price)
        // If shipping state matches store state (e.g. Maharashtra), split into CGST (9%) + SGST (9%), else IGST (18%)
        $store_state = 'Maharashtra';
        $customer_state = $shipping_address['state'] ?? 'Maharashtra';

        $taxable_amount = $discounted_subtotal / 1.18;
        $total_tax = $discounted_subtotal - $taxable_amount;

        $cgst = 0.00;
        $sgst = 0.00;
        $igst = 0.00;

        if (strcasecmp($store_state, $customer_state) === 0) {
            $cgst = round($total_tax / 2, 2);
            $sgst = round($total_tax / 2, 2);
        } else {
            $igst = round($total_tax, 2);
        }

        $grand_total = $discounted_subtotal + $shipping_amount;

        return [
            'subtotal'            => $subtotal,
            'discount_amount'     => $discount_amount,
            'discount_code'       => $cart['discount_code'] ?? null,
            'discounted_subtotal' => $discounted_subtotal,
            'shipping_amount'     => $shipping_amount,
            'tax_amount'          => round($total_tax, 2),
            'cgst_amount'         => $cgst,
            'sgst_amount'         => $sgst,
            'igst_amount'         => $igst,
            'total'               => round($grand_total, 2),
            'items'               => $items,
        ];
    }
}
