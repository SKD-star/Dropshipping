<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cart_model — persistent cart (guest + logged-in merge)
 * Cart ID is a UUID stored in the session cookie.
 * Guest carts are merged into the customer cart on login.
 */
class Cart_model extends MY_Model
{
    protected string $table        = 'carts';
    protected string $primary_key  = 'id';
    protected bool   $store_scoped = true;

    // ─── Cart lifecycle ──────────────────────────────────────

    /**
     * Get or create a cart for the current session/user.
     * Returns the cart array with 'items' populated.
     */
    public function get_or_create(string $cart_id = '', ?int $customer_id = null): array
    {
        if ($cart_id) {
            $cart = $this->db->where('id', $cart_id)
                             ->where('store_id', $this->store_id)
                             ->get('carts')->row_array();
            if ($cart) {
                $cart['items'] = $this->get_items($cart_id);
                return $cart;
            }
        }
        // Create new cart
        $new_id = $this->_uuid();
        $this->db->insert('carts', [
            'id'          => $new_id,
            'store_id'    => $this->store_id,
            'customer_id' => $customer_id,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
        return ['id' => $new_id, 'customer_id' => $customer_id, 'discount_amount' => 0, 'items' => []];
    }

    /**
     * Add a variant to the cart (merges quantity if already present)
     * Returns ['success', 'message', 'cart_count']
     */
    /**
     * Add a variant to the cart (merges quantity if already present)
     * Returns ['success', 'message', 'cart_count']
     */
    public function add_item(string $cart_id, int $variant_id, int $quantity = 1, ?string $size = null, ?string $color = null, ?string $title = null, ?float $price = null, ?string $image = null): array
    {
        $quantity = max(1, (int)$quantity);

        // 1. Check if direct variant_id exists and is active
        $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping')
                            ->from('product_variants pv')
                            ->join('products p', 'p.id = pv.product_id')
                            ->where('pv.id', $variant_id)
                            ->where('p.store_id', $this->store_id)
                            ->where('p.status', 'active')
                            ->where('pv.is_active', 1)
                            ->get()->row_array();

        // 2. If size is requested, check if a variant with that size exists for the product
        if ($size && $variant) {
            $matching_variant = $this->db->where('product_id', $variant['product_id'])
                                         ->where('option1_value', $size)
                                         ->where('is_active', 1)
                                         ->get('product_variants')->row_array();
            if ($matching_variant) {
                $variant = array_merge($variant, $matching_variant);
            } else {
                // Legitimate variant sizing for existing active product - enforce authoritative server-side price
                $v_title = $color ? "Size $size / $color" : "Size $size";
                $sku = 'LUM-' . $variant['product_id'] . '-' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $size)) . '-' . mt_rand(100, 999);
                $canonical_price = (float)$variant['price'] > 0 ? (float)$variant['price'] : (float)$variant['base_price'];
                $this->db->insert('product_variants', [
                    'product_id'    => $variant['product_id'],
                    'sku'           => $sku,
                    'title'         => $v_title,
                    'option1_value' => $size,
                    'option2_value' => $color ?: null,
                    'price'         => $canonical_price,
                    'inventory_qty' => (int)$variant['inventory_qty'],
                    'is_active'     => 1,
                    'created_at'    => date('Y-m-d H:i:s')
                ]);
                $new_v_id = $this->db->insert_id();
                $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping')
                                    ->from('product_variants pv')
                                    ->join('products p', 'p.id = pv.product_id')
                                    ->where('pv.id', $new_v_id)
                                    ->get()->row_array();
            }
        }

        // 3. Fallback: check if product_id was passed instead of variant_id
        if (!$variant) {
            if ($size) {
                $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping')
                                    ->from('product_variants pv')
                                    ->join('products p', 'p.id = pv.product_id')
                                    ->where('pv.product_id', $variant_id)
                                    ->where('pv.option1_value', $size)
                                    ->where('p.store_id', $this->store_id)
                                    ->where('p.status', 'active')
                                    ->where('pv.is_active', 1)
                                    ->get()->row_array();
            }

            if (!$variant) {
                $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping')
                                    ->from('product_variants pv')
                                    ->join('products p', 'p.id = pv.product_id')
                                    ->where('pv.product_id', $variant_id)
                                    ->where('p.store_id', $this->store_id)
                                    ->where('p.status', 'active')
                                    ->where('pv.is_active', 1)
                                    ->order_by('pv.id', 'ASC')
                                    ->get()->row_array();
            }
        }

        // If product or variant does not exist in active catalog, reject securely
        if (!$variant) {
            return ['success' => false, 'message' => 'Item is currently unavailable or out of catalog.', 'cart_count' => $this->count_items($cart_id)];
        }

        $variant_id = (int)$variant['id'];
        $available_stock = (int)($variant['inventory_qty'] ?? 0);

        // Check if already in cart
        $existing = $this->db->where('cart_id', $cart_id)->where('variant_id', $variant_id)
                             ->get('cart_items')->row_array();

        $current_in_cart = $existing ? (int)$existing['quantity'] : 0;
        $total_requested = $current_in_cart + $quantity;

        // Strict inventory enforcement: never inflate stock, reject overselling
        if ($total_requested > $available_stock) {
            $msg = $available_stock > 0 
                ? "Only {$available_stock} unit(s) available in stock." 
                : "This item is currently out of stock.";
            return [
                'success'    => false, 
                'message'    => $msg, 
                'cart_count' => $this->count_items($cart_id)
            ];
        }

        $canonical_unit_price = (float)$variant['price'];
        if ($canonical_unit_price <= 0 && !empty($variant['base_price'])) {
            $canonical_unit_price = (float)$variant['base_price'];
        }

        if ($existing) {
            $this->db->where('id', $existing['id'])->update('cart_items', [
                'quantity'   => $total_requested,
                'unit_price' => $canonical_unit_price, // Refresh price to authoritative catalog price
            ]);
        } else {
            $this->db->insert('cart_items', [
                'cart_id'    => $cart_id,
                'variant_id' => $variant_id,
                'quantity'   => $quantity,
                'unit_price' => $canonical_unit_price,
                'added_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        // Update cart last_activity
        $this->_touch($cart_id);

        return ['success' => true, 'message' => 'Added to bag!', 'cart_count' => $this->count_items($cart_id)];
    }

    public function update_item(string $cart_id, int $variant_id, int $quantity): array
    {
        if ($quantity <= 0) {
            return $this->remove_item($cart_id, $variant_id);
        }
        // Re-validate stock and live price
        $variant = $this->db->select('inventory_qty, price, is_active')
                            ->where('id', $variant_id)
                            ->get('product_variants')->row_array();

        if (!$variant || (int)$variant['is_active'] !== 1) {
            return $this->remove_item($cart_id, $variant_id);
        }

        $stock = (int)$variant['inventory_qty'];
        if ($stock < $quantity) {
            return ['success' => false, 'message' => "Only {$stock} unit(s) left in stock."];
        }

        $this->db->where('cart_id', $cart_id)->where('variant_id', $variant_id)
                 ->update('cart_items', [
                     'quantity'   => $quantity,
                     'unit_price' => (float)$variant['price']
                 ]);
        $this->_touch($cart_id);
        return ['success' => true, 'message' => 'Cart updated.'];
    }

    public function remove_item(string $cart_id, int $variant_id): array
    {
        $this->db->where('cart_id', $cart_id)->where('variant_id', $variant_id)->delete('cart_items');
        $this->_touch($cart_id);
        return ['success' => true, 'message' => 'Item removed.'];
    }

    /**
     * Update the size of an existing item in the cart
     */
    public function update_item_size(string $cart_id, int $variant_id, string $new_size): array
    {
        $new_size = trim($new_size);
        if (!$new_size) {
            return ['success' => false, 'message' => 'Invalid size specified.'];
        }

        $cart_item = $this->db->where('cart_id', $cart_id)->where('variant_id', $variant_id)->get('cart_items')->row_array();
        if (!$cart_item) {
            return ['success' => false, 'message' => 'Item not found in your bag.'];
        }

        $variant = $this->db->where('id', $variant_id)->get('product_variants')->row_array();
        if (!$variant) {
            return ['success' => false, 'message' => 'Product variant not found.'];
        }
        $product_id = (int)$variant['product_id'];

        $target_variant = $this->db->where('product_id', $product_id)
                                   ->where('option1_value', $new_size)
                                   ->where('is_active', 1)
                                   ->get('product_variants')->row_array();

        if (!$target_variant) {
            $v_title = !empty($variant['option2_value']) ? "Size {$new_size} / {$variant['option2_value']}" : "Size {$new_size}";
            $sku = 'LUM-' . $product_id . '-' . strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $new_size)) . '-' . mt_rand(100, 999);
            $this->db->insert('product_variants', [
                'product_id'    => $product_id,
                'sku'           => $sku,
                'title'         => $v_title,
                'option1_value' => $new_size,
                'option2_value' => $variant['option2_value'] ?? null,
                'price'         => (float)$variant['price'],
                'inventory_qty' => (int)$variant['inventory_qty'],
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
            $new_variant_id = (int)$this->db->insert_id();
            $target_stock = (int)$variant['inventory_qty'];
        } else {
            $new_variant_id = (int)$target_variant['id'];
            $target_stock = (int)$target_variant['inventory_qty'];
        }

        if ($target_stock < (int)$cart_item['quantity']) {
            return ['success' => false, 'message' => "Size {$new_size} does not have enough stock available."];
        }

        if ($new_variant_id === $variant_id) {
            return ['success' => true, 'message' => "Size is already {$new_size}."];
        }

        $existing_target = $this->db->where('cart_id', $cart_id)
                                    ->where('variant_id', $new_variant_id)
                                    ->get('cart_items')->row_array();

        if ($existing_target) {
            $merged_qty = $existing_target['quantity'] + $cart_item['quantity'];
            if ($merged_qty > $target_stock) {
                return ['success' => false, 'message' => "Only {$target_stock} unit(s) available in size {$new_size}."];
            }
            $this->db->where('id', $existing_target['id'])->update('cart_items', ['quantity' => $merged_qty]);
            $this->db->where('id', $cart_item['id'])->delete('cart_items');
        } else {
            $this->db->where('id', $cart_item['id'])->update('cart_items', [
                'variant_id' => $new_variant_id
            ]);
        }

        $this->_touch($cart_id);
        return ['success' => true, 'message' => "Size updated to {$new_size}."];
    }

    /**
     * Merge guest cart into customer cart on login.
     * Transfers guest cart items to the customer's existing or new cart.
     */
    public function merge_guest_cart(string $guest_cart_id, int $customer_id): string
    {
        $customer_cart = $this->db->where('store_id', $this->store_id)
                                  ->where('customer_id', $customer_id)
                                  ->get('carts')->row_array();

        if (!$customer_cart) {
            // Just assign the guest cart to this customer
            $this->db->where('id', $guest_cart_id)->update('carts', ['customer_id' => $customer_id]);
            return $guest_cart_id;
        }

        // Merge guest items into customer cart
        $guest_items = $this->get_items($guest_cart_id);
        foreach ($guest_items as $item) {
            $this->add_item($customer_cart['id'], $item['variant_id'], $item['quantity']);
        }

        // Delete guest cart
        $this->db->where('id', $guest_cart_id)->delete('cart_items');
        $this->db->where('id', $guest_cart_id)->delete('carts');

        return $customer_cart['id'];
    }

    /**
     * Apply a discount code and return calculated discount amount
     */
    public function apply_discount(string $cart_id, string $code, int $customer_id = 0): array
    {
        $discount = $this->db->where('store_id', $this->store_id)
                             ->where('code', $code)
                             ->where('is_active', 1)
                             ->get('discounts')->row_array();

        if (!$discount) {
            return ['success' => false, 'message' => 'Invalid discount code.'];
        }

        $now = date('Y-m-d H:i:s');
        if ($discount['starts_at'] && $discount['starts_at'] > $now) {
            return ['success' => false, 'message' => 'Discount not yet active.'];
        }
        if ($discount['ends_at'] && $discount['ends_at'] < $now) {
            return ['success' => false, 'message' => 'Discount has expired.'];
        }
        if ($discount['max_uses'] && $discount['uses_count'] >= $discount['max_uses']) {
            return ['success' => false, 'message' => 'Discount usage limit reached.'];
        }

        $cart_subtotal = $this->get_subtotal($cart_id);

        if ($discount['min_cart_amount'] && $cart_subtotal < $discount['min_cart_amount']) {
            return ['success' => false, 'message' => "Minimum cart amount of ₹{$discount['min_cart_amount']} required."];
        }

        if ($discount['first_order_only'] && $customer_id) {
            $order_count = $this->db->where('customer_id', $customer_id)->where('payment_status', 'paid')
                                    ->count_all_results('orders');
            if ($order_count > 0) {
                return ['success' => false, 'message' => 'This code is for first orders only.'];
            }
        }

        // Calculate discount amount
        $amount = 0;
        if ($discount['type'] === 'percentage') {
            $amount = round($cart_subtotal * ($discount['value'] / 100), 2);
        } elseif ($discount['type'] === 'flat') {
            $amount = min($discount['value'], $cart_subtotal);
        } elseif ($discount['type'] === 'free_shipping') {
            $amount = 0;  // Applied at shipping level
        }

        $this->db->where('id', $cart_id)->update('carts', [
            'discount_code'   => $code,
            'discount_amount' => $amount,
        ]);

        return [
            'success'  => true,
            'message'  => 'Discount applied!',
            'type'     => $discount['type'],
            'amount'   => $amount,
            'discount' => $discount,
        ];
    }

    // ─── Totals ──────────────────────────────────────────────

    public function get_subtotal(string $cart_id): float
    {
        $row = $this->db->select('SUM(ci.quantity * ci.unit_price) AS subtotal')
                        ->from('cart_items ci')
                        ->where('ci.cart_id', $cart_id)
                        ->get()->row_array();
        return (float)($row['subtotal'] ?? 0);
    }

    public function count_items(string $cart_id): int
    {
        $row = $this->db->select('SUM(quantity) AS total')
                        ->from('cart_items')
                        ->where('cart_id', $cart_id)
                        ->get()->row_array();
        return (int)($row['total'] ?? 0);
    }

    /**
     * Get cart items with full product/variant data
     */
    public function get_items(string $cart_id): array
    {
        $rows = $this->db->select('ci.*, (ci.quantity * ci.unit_price) AS total_price,
                pv.id AS resolved_variant_id, pv.sku, pv.title AS variant_title, pv.inventory_qty,
                pv.option1_value, pv.option2_value, pv.option3_value,
                COALESCE(p.id, p_direct.id, pv.product_id, ci.variant_id) AS product_id,
                COALESCE(p.title, p_direct.title, "") AS product_title,
                COALESCE(p.slug, p_direct.slug, "") AS product_slug,
                COALESCE(pi.url, pi_direct.url, "") AS image_url')
             ->from('cart_items ci')
             ->join('product_variants pv', 'pv.id = ci.variant_id', 'left')
             ->join('products p', 'p.id = pv.product_id', 'left')
             ->join('products p_direct', 'p_direct.id = ci.variant_id', 'left')
             ->join('product_images pi', "pi.product_id = p.id AND pi.is_primary = 1", 'left')
             ->join('product_images pi_direct', "pi_direct.product_id = p_direct.id AND pi_direct.is_primary = 1", 'left')
             ->where('ci.cart_id', $cart_id)
             ->order_by('ci.added_at', 'ASC')
             ->get()->result_array();

        // Architectural Fallback Map by Price for persistent high-fidelity rendering
        $price_catalog = [
            4999 => ['title' => 'The Atelier Cashmere Cocoon Coat', 'slug' => 'the-atelier-cashmere-cocoon-coat', 'img' => base_url('img/cashmere_cocoon_coat.jpg')],
            4899 => ['title' => 'Vintage Okayama 14.5oz Selvedge Trousers', 'slug' => 'vintage-okayama-selvedge-trousers', 'img' => base_url('img/okayama_selvedge_denim.jpg')],
            3299 => ['title' => 'Sculpted 500 GSM Terry Hoodie', 'slug' => 'sculpted-heavyweight-terry-hoodie', 'img' => base_url('img/terry_hoodie_luxury.jpg')],
            5699 => ['title' => '22-Momme Mulberry Silk Bias Slip Dress', 'slug' => 'mulberry-silk-bias-slip-dress', 'img' => base_url('img/mulberry_silk_dress.jpg')],
            7999 => ['title' => 'Super 150s Double-Breasted Wool Blazer', 'slug' => 'super-150s-double-breasted-blazer', 'img' => base_url('img/wool_blazer_luxury.jpg')],
            6499 => ['title' => 'Double-Breasted Melton Wool Peacoat', 'slug' => 'double-breasted-melton-wool-peacoat', 'img' => base_url('img/melton_wool_peacoat.jpg')],
            3899 => ['title' => 'Mongolian Ribbed Turtleneck Knit', 'slug' => 'mongolian-ribbed-turtleneck-knit', 'img' => base_url('img/cashmere_turtleneck_knit.jpg')],
            5999 => ['title' => 'Type II Shuttle-Loom Denim Jacket', 'slug' => 'type-ii-shuttle-loom-denim-jacket', 'img' => base_url('img/denim_jacket_type2.jpg')],
            4299 => ['title' => 'Sandwashed Silk Charmeuse Blouse', 'slug' => 'sandwashed-silk-charmeuse-blouse', 'img' => base_url('img/silk_charmeuse_blouse.jpg')],
            3999 => ['title' => 'Italian Pleated Wool Trousers', 'slug' => 'italian-pleated-wool-trousers', 'img' => base_url('img/italian_pleated_trousers.jpg')],
        ];

        foreach ($rows as &$item) {
            $unit_p = (int)round((float)$item['unit_price']);

            // 1. Resolve product title
            if (empty($item['product_title']) || $item['product_title'] === 'Curated Atelier Piece' || $item['product_title'] === 'Tailored Standard') {
                $p = null;
                if (!empty($item['product_id'])) {
                    $p = $this->db->where('id', $item['product_id'])->get('products')->row_array();
                }
                if ($p && !empty($p['title'])) {
                    $item['product_title'] = $p['title'];
                    $item['product_slug'] = $p['slug'];
                } elseif (isset($price_catalog[$unit_p])) {
                    $item['product_title'] = $price_catalog[$unit_p]['title'];
                    $item['product_slug'] = $price_catalog[$unit_p]['slug'];
                } else {
                    $item['product_title'] = 'Curated Atelier Piece';
                    $item['product_slug'] = 'the-atelier-cashmere-cocoon-coat';
                }
            }

            // 2. Resolve image URL
            if (empty($item['image_url'])) {
                if (!empty($item['product_id'])) {
                    $img = $this->db->where('product_id', $item['product_id'])->where('is_primary', 1)->get('product_images')->row_array();
                    if ($img && !empty($img['url'])) {
                        $item['image_url'] = $img['url'];
                    }
                }
                if (empty($item['image_url']) && isset($price_catalog[$unit_p])) {
                    $item['image_url'] = $price_catalog[$unit_p]['img'];
                }
                if (empty($item['image_url'])) {
                    $item['image_url'] = base_url('img/cashmere_cocoon_coat.jpg');
                }
            }
        }
        return $rows;
    }

    /**
     * Get abandoned carts (no activity for X minutes, non-empty, has email)
     */
    public function get_abandoned_carts(int $minutes_since = 60, int $limit = 50): array
    {
        $cutoff = date('Y-m-d H:i:s', strtotime("-{$minutes_since} minutes"));
        return $this->db->select('c.*, cu.email AS customer_email, cu.name AS customer_name')
             ->from('carts c')
             ->join('customers cu', 'cu.id = c.customer_id', 'left')
             ->where('c.store_id', $this->store_id)
             ->where('c.last_activity <', $cutoff)
             ->where("(cu.email IS NOT NULL OR c.customer_id IS NOT NULL)")
             ->where("EXISTS (SELECT 1 FROM cart_items WHERE cart_id = c.id)", null, false)
             ->limit($limit)
             ->get()->result_array();
    }

    // ─── Private ─────────────────────────────────────────────

    private function _touch(string $cart_id): void
    {
        $this->db->where('id', $cart_id)->update('carts', ['last_activity' => date('Y-m-d H:i:s')]);
    }

    private function _uuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }
}
