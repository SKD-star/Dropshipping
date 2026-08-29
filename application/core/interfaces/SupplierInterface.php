<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SupplierInterface
 * Every supplier adapter (CJ, AliExpress, Mock) implements this.
 * The dropshipping engine never calls a supplier directly.
 */
interface SupplierInterface
{
    /** @return string  e.g. 'cj', 'aliexpress', 'mock' */
    public function get_slug(): string;

    /**
     * Search supplier catalog.
     *
     * @param  array  $params  ['query'=>'', 'category'=>'', 'page'=>1, 'per_page'=>20]
     * @return array  ['success', 'products' => [...], 'total', 'page']
     */
    public function search_products(array $params): array;

    /**
     * Get full product details + variants + images from supplier.
     *
     * @param  string  $supplier_product_id
     * @return array   ['success', 'product' => [...supplier product data...]]
     */
    public function get_product(string $supplier_product_id): array;

    /**
     * Get current price and stock for a supplier product.
     *
     * @param  string  $supplier_product_id
     * @return array   ['success', 'price', 'stock', 'variants' => [['id', 'price', 'stock'], ...]]
     */
    public function get_stock_and_price(string $supplier_product_id): array;

    /**
     * Batch get stock/price for multiple products (for sync jobs).
     *
     * @param  array  $supplier_product_ids
     * @return array  keyed by supplier_product_id => ['price', 'stock']
     */
    public function batch_get_stock(array $supplier_product_ids): array;

    /**
     * Push an order to the supplier for fulfillment.
     *
     * @param  array  $order   Our normalized order: customer, shipping_address, items with supplier SKUs
     * @return array  ['success', 'supplier_order_id', 'estimated_ship_date', 'raw_response']
     */
    public function push_order(array $order): array;

    /**
     * Get the status + tracking of a previously pushed supplier order.
     *
     * @param  string  $supplier_order_id
     * @return array   ['success', 'status', 'tracking_number', 'tracking_url', 'carrier']
     */
    public function get_order_tracking(string $supplier_order_id): array;
}
