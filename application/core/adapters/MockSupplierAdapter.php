<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MockSupplierAdapter
 * Implements SupplierInterface with realistic stubbed data.
 * Replace this with CjSupplierAdapter / AliexpressAdapter when ready.
 * All methods return the same shape as a real adapter so the engine works end-to-end.
 */
class MockSupplierAdapter implements SupplierInterface
{
    public function get_slug(): string { return 'mock'; }

    public function search_products(array $params): array
    {
        $query   = $params['query'] ?? '';
        $page    = (int)($params['page'] ?? 1);
        $per_page = (int)($params['per_page'] ?? 20);

        $products = $this->_fake_catalog($query);
        $total   = count($products);
        $items   = array_slice($products, ($page - 1) * $per_page, $per_page);

        return ['success' => true, 'products' => $items, 'total' => $total, 'page' => $page];
    }

    public function get_product(string $supplier_product_id): array
    {
        $product = [
            'supplier_product_id' => $supplier_product_id,
            'title'       => "Mock Product #$supplier_product_id",
            'description' => "High-quality mock product for testing. Perfect for dropshipping demos.",
            'images'      => [
                ['url' => "https://picsum.photos/seed/{$supplier_product_id}/800/800", 'position' => 0],
                ['url' => "https://picsum.photos/seed/{$supplier_product_id}2/800/800", 'position' => 1],
            ],
            'variants' => [
                ['supplier_variant_id' => "{$supplier_product_id}-S", 'option1' => 'Small',  'price' => 12.50, 'stock' => 100],
                ['supplier_variant_id' => "{$supplier_product_id}-M", 'option1' => 'Medium', 'price' => 12.50, 'stock' => 150],
                ['supplier_variant_id' => "{$supplier_product_id}-L", 'option1' => 'Large',  'price' => 13.00, 'stock' => 80],
                ['supplier_variant_id' => "{$supplier_product_id}-XL", 'option1' => 'XL',   'price' => 13.50, 'stock' => 40],
            ],
            'options' => [
                ['name' => 'Size', 'values' => ['Small', 'Medium', 'Large', 'XL']],
            ],
            'weight_grams' => 350,
            'category'    => 'General',
        ];
        return ['success' => true, 'product' => $product];
    }

    public function get_stock_and_price(string $supplier_product_id): array
    {
        return [
            'success' => true,
            'price'   => 12.50 + (float)substr($supplier_product_id, -1) * 0.25,
            'stock'   => rand(0, 200),
            'variants' => [
                ['id' => "{$supplier_product_id}-S",  'price' => 12.50, 'stock' => rand(0, 100)],
                ['id' => "{$supplier_product_id}-M",  'price' => 12.50, 'stock' => rand(0, 150)],
                ['id' => "{$supplier_product_id}-L",  'price' => 13.00, 'stock' => rand(0, 80)],
                ['id' => "{$supplier_product_id}-XL", 'price' => 13.50, 'stock' => rand(0, 40)],
            ],
        ];
    }

    public function batch_get_stock(array $supplier_product_ids): array
    {
        $result = [];
        foreach ($supplier_product_ids as $pid) {
            $result[$pid] = ['price' => 12.50, 'stock' => rand(10, 200)];
        }
        return $result;
    }

    public function push_order(array $order): array
    {
        // Simulate a small failure rate (5%) to test retry logic
        if (rand(1, 20) === 1) {
            return ['success' => false, 'error' => 'Simulated supplier timeout — please retry'];
        }
        $supplier_order_id = 'MOCK-' . strtoupper(substr(md5(json_encode($order)), 0, 8));
        return [
            'success'              => true,
            'supplier_order_id'    => $supplier_order_id,
            'estimated_ship_date'  => date('Y-m-d', strtotime('+3 days')),
            'raw_response'         => ['mock' => true, 'order_id' => $supplier_order_id],
        ];
    }

    public function get_order_tracking(string $supplier_order_id): array
    {
        return [
            'success'         => true,
            'status'          => 'shipped',
            'tracking_number' => 'CJ' . strtoupper(substr(md5($supplier_order_id), 0, 10)),
            'tracking_url'    => 'https://track.cjdropshipping.com/' . $supplier_order_id,
            'carrier'         => 'CJDropshippingExpress',
        ];
    }

    // ─── Private ─────────────────────────────────────────────

    private function _fake_catalog(string $query): array
    {
        $products = [];
        $names = [
            'Premium Cotton T-Shirt', 'Minimalist Watch', 'Wireless Earbuds',
            'Leather Wallet', 'Smart Phone Case', 'Yoga Mat Premium',
            'Coffee Mug Insulated', 'Running Shoes', 'Sunglasses UV400',
            'Canvas Backpack', 'Desk Organizer', 'Bamboo Toothbrush Set',
            'LED Desk Lamp', 'Portable Charger', 'Silk Pillowcase',
        ];
        foreach ($names as $i => $name) {
            if ($query && stripos($name, $query) === false) continue;
            $id = 'MOCK-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $products[] = [
                'supplier_product_id' => $id,
                'title'              => $name,
                'price'              => round(10 + $i * 1.5, 2),
                'stock'              => rand(50, 500),
                'image_url'          => "https://picsum.photos/seed/$id/400/400",
                'category'           => 'General',
            ];
        }
        return $products;
    }
}
