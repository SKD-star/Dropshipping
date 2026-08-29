<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CarrierInterface
 * Every shipping carrier adapter (Shiprocket, Delhivery, Manual) implements this.
 */
interface CarrierInterface
{
    public function get_slug(): string;

    /**
     * Get available shipping rates for a shipment.
     *
     * @param  array  $params  ['weight_grams', 'from_pincode', 'to_pincode', 'cod'=>bool, 'declared_value']
     * @return array  ['success', 'rates' => [['name', 'price', 'estimated_days', 'service_code'], ...]]
     */
    public function get_rates(array $params): array;

    /**
     * Create a shipment / generate a label.
     *
     * @param  array  $shipment  ['order_id', 'items', 'from_address', 'to_address', 'weight_grams', 'cod_amount']
     * @return array  ['success', 'carrier_shipment_id', 'tracking_number', 'label_url', 'tracking_url']
     */
    public function create_shipment(array $shipment): array;

    /**
     * Get real-time tracking status.
     *
     * @param  string  $tracking_number
     * @return array   ['success', 'status', 'events' => [['timestamp', 'location', 'description'], ...]]
     */
    public function track(string $tracking_number): array;

    /**
     * Cancel a shipment before pickup.
     *
     * @param  string  $carrier_shipment_id
     * @return array   ['success', 'message']
     */
    public function cancel(string $carrier_shipment_id): array;
}
