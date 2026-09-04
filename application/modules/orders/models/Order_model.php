<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Order_model — full order lifecycle management
 * Status FSM: pending → paid → processing → shipped → delivered → refunded/cancelled
 */
class Order_model extends MY_Model
{
    protected string $table        = 'orders';
    protected bool   $store_scoped = true;

    // ─── Creation ────────────────────────────────────────────

    /**
     * Convert a cart into an order.
     * Returns order ID or false.
     * Atomically decrements inventory within the same transaction.
     */
    public function create_from_cart(string $cart_id, array $data): int|false
    {
        $this->db->trans_start();
        try {
            $order_number = $this->_next_order_number();
            $order_data = array_merge($data, [
                'store_id'     => $this->store_id,
                'order_number' => $order_number,
                'cart_id'      => $cart_id,
                'status'       => 'pending',
                'payment_status' => 'unpaid',
                'fulfillment_status' => 'unfulfilled',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);

            $this->db->insert('orders', $order_data);
            $order_id = $this->db->insert_id();
            if (!$order_id) { $this->db->trans_rollback(); return false; }

            // Insert order items from cart (with inventory decrement and vendor resolution)
            $cart_items = $this->db->select('ci.*, pv.sku, pv.title AS variant_title, 
                    p.id AS product_id, p.title AS product_title, pv.cost_price, vp.vendor_id')
                 ->from('cart_items ci')
                 ->join('product_variants pv', 'pv.id = ci.variant_id')
                 ->join('products p', 'p.id = pv.product_id')
                 ->join('vendor_products vp', 'vp.product_id = p.id AND vp.approval_status = "approved"', 'left')
                 ->where('ci.cart_id', $cart_id)
                 ->get()->result_array();

            if (empty($cart_items)) { $this->db->trans_rollback(); return false; }

            $has_vendor_items = false;
            foreach ($cart_items as $item) {
                $vendor_id = !empty($item['vendor_id']) ? (int)$item['vendor_id'] : null;
                if ($vendor_id) { $has_vendor_items = true; }

                $this->db->insert('order_items', [
                    'order_id'                  => $order_id,
                    'vendor_id'                 => $vendor_id,
                    'variant_id'                => $item['variant_id'],
                    'product_title'             => $item['product_title'],
                    'variant_title'             => $item['variant_title'],
                    'sku'                       => $item['sku'],
                    'quantity'                  => $item['quantity'],
                    'unit_price'                => $item['unit_price'],
                    'total_price'               => $item['quantity'] * $item['unit_price'],
                    'cost_price'                => $item['cost_price'],
                    'vendor_fulfillment_status' => $vendor_id ? 'unfulfilled' : null,
                ]);

                // Reserve inventory
                $this->db->set('inventory_qty', "GREATEST(0, inventory_qty - {$item['quantity']})", false)
                         ->where('id', $item['variant_id'])
                         ->update('product_variants');
            }

            // Add timeline event
            $this->add_timeline($order_id, 'system', null, 'order.created', "Order $order_number created.");

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) return false;

            // Route order to vendors if vendor SKUs are present
            if ($has_vendor_items) {
                $this->_queue_vendor_routing($order_id);
            }

            return $order_id;
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', '[Order_model::create_from_cart] ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }

    // ─── Status transitions ──────────────────────────────────

    /**
     * Mark order as paid after verified payment webhook
     */
    public function mark_paid(int $order_id, string $gateway_payment_id, string $gateway): bool
    {
        $updated = $this->db->where('id', $order_id)
                            ->where('store_id', $this->store_id)
                            ->where('payment_status', 'unpaid')  // idempotent guard
                            ->update('orders', [
                                'status'           => 'paid',
                                'payment_status'   => 'paid',
                                'updated_at'       => date('Y-m-d H:i:s'),
                            ]);

        if ($updated) {
            $this->add_timeline($order_id, 'system', null, 'payment.captured',
                "Payment captured via $gateway. ID: $gateway_payment_id");

            // Queue supplier fulfillment push
            $this->_queue_fulfillment($order_id);

            // Queue vendor order routing
            $this->_queue_vendor_routing($order_id);

            // Queue confirmation email
            $this->_queue_email($order_id, 'order_confirmed');
        }

        return $updated;
    }

    public function update_status(int $order_id, string $status, int $actor_id = 0, string $note = ''): bool
    {
        $allowed = ['pending','paid','processing','shipped','delivered','refunded','cancelled','on_hold'];
        if (!in_array($status, $allowed)) return false;

        $updated = $this->db->where('id', $order_id)->where('store_id', $this->store_id)
                            ->update('orders', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);

        if ($updated) {
            $this->add_timeline($order_id, 'admin', $actor_id, "order.status.$status",
                $note ?: "Status changed to $status.");

            if ($status === 'cancelled') {
                $this->_restore_inventory($order_id);
            }
        }
        return $updated;
    }

    public function mark_shipped(int $order_id, string $tracking_number, string $carrier, string $tracking_url = '', int $actor_id = 0): bool
    {
        $updated = $this->db->where('id', $order_id)->where('store_id', $this->store_id)
                            ->update('orders', [
                                'status'             => 'shipped',
                                'fulfillment_status' => 'fulfilled',
                                'updated_at'         => date('Y-m-d H:i:s'),
                            ]);
        if ($updated) {
            $this->add_timeline($order_id, 'system', $actor_id, 'order.shipped',
                "Shipped via $carrier. Tracking: $tracking_number");
            $this->_queue_email($order_id, 'order_shipped', ['tracking' => $tracking_number, 'carrier' => $carrier, 'tracking_url' => $tracking_url]);
        }
        return $updated;
    }

    // ─── Reads ───────────────────────────────────────────────

    public function get_with_items(int $order_id): ?array
    {
        $order = $this->db->where('id', $order_id)->where('store_id', $this->store_id)
                          ->get('orders')->row_array();
        if (!$order) return null;

        $order['items']    = $this->db->where('order_id', $order_id)->get('order_items')->result_array();
        $order['timeline'] = $this->db->where('order_id', $order_id)->order_by('created_at', 'ASC')->get('order_timeline')->result_array();
        $order['payments'] = $this->db->where('order_id', $order_id)->get('payments')->result_array();
        $order['shipments'] = $this->db->where('order_id', $order_id)->get('shipments')->result_array();

        if ($order['shipping_address_id']) {
            $order['shipping_address'] = $this->db->where('id', $order['shipping_address_id'])->get('addresses')->row_array();
        }
        if ($order['billing_address_id']) {
            $order['billing_address'] = $this->db->where('id', $order['billing_address_id'])->get('addresses')->row_array();
        }

        return $order;
    }

    public function get_for_customer(int $customer_id, int $page = 1, int $per_page = 10): array
    {
        $total = $this->db->where('customer_id', $customer_id)->where('store_id', $this->store_id)
                          ->count_all_results('orders');

        $items = $this->db->where('customer_id', $customer_id)->where('store_id', $this->store_id)
                          ->order_by('created_at', 'DESC')
                          ->limit($per_page, ($page - 1) * $per_page)
                          ->get('orders')->result_array();

        return compact('items', 'total', 'page', 'per_page');
    }

    public function get_admin_list(array $filters = [], int $page = 1, int $per_page = 20): array
    {
        $this->db->where('orders.store_id', $this->store_id);
        if (!empty($filters['status'])) $this->db->where('orders.status', $filters['status']);
        if (!empty($filters['payment_status'])) $this->db->where('payment_status', $filters['payment_status']);
        if (!empty($filters['date_from'])) $this->db->where('orders.created_at >=', $filters['date_from']);
        if (!empty($filters['date_to'])) $this->db->where('orders.created_at <=', $filters['date_to']);
        if (!empty($filters['search'])) {
            $s = $this->db->escape_like_str($filters['search']);
            $this->db->group_start()
                     ->like('orders.order_number', $s)
                     ->or_like('orders.guest_email', $s)
                     ->group_end();
        }

        $total = $this->db->count_all_results('orders', false);
        $items = $this->db->select('orders.*, COALESCE(c.name, orders.guest_email) AS customer_name')
                          ->join('customers c', 'c.id = orders.customer_id', 'left')
                          ->order_by('orders.created_at', 'DESC')
                          ->limit($per_page, ($page - 1) * $per_page)
                          ->get('orders')->result_array();

        return compact('items', 'total', 'page', 'per_page');
    }

    // ─── Timeline ────────────────────────────────────────────

    public function add_timeline(int $order_id, string $actor_type, ?int $actor_id, string $event, string $detail = ''): void
    {
        try {
            $this->db->insert('order_timeline', [
                'order_id'   => $order_id,
                'actor_type' => $actor_type,
                'actor_id'   => $actor_id,
                'event'      => $event,
                'detail'     => $detail,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $e) {
            log_message('error', '[Order_model::add_timeline] ' . $e->getMessage());
        }
    }

    // ─── Analytics ───────────────────────────────────────────

    public function get_dashboard_stats(string $date_from = '', string $date_to = ''): array
    {
        $from = $date_from ?: date('Y-m-01');
        $to   = $date_to   ?: date('Y-m-d 23:59:59');

        $revenue = $this->db->select('SUM(total) AS revenue, COUNT(*) AS count')
            ->where('store_id', $this->store_id)
            ->where('payment_status', 'paid')
            ->where('created_at >=', $from)->where('created_at <=', $to)
            ->get('orders')->row_array();

        $pending = $this->db->where('store_id', $this->store_id)
                            ->where('status', 'pending')->count_all_results('orders');
        $unfulfilled = $this->db->where('store_id', $this->store_id)
                                ->where('fulfillment_status', 'unfulfilled')
                                ->where('payment_status', 'paid')->count_all_results('orders');

        return [
            'revenue'     => (float)($revenue['revenue'] ?? 0),
            'order_count' => (int)($revenue['count'] ?? 0),
            'pending'     => $pending,
            'unfulfilled' => $unfulfilled,
        ];
    }

    // ─── Private ─────────────────────────────────────────────

    private function _next_order_number(): string
    {
        $last = $this->db->select_max('CAST(SUBSTRING(order_number, 2) AS UNSIGNED)', 'max_num')
                         ->where('store_id', $this->store_id)
                         ->get('orders')->row('max_num');
        return '#' . str_pad(((int)$last) + 1001, 5, '0', STR_PAD_LEFT);
    }

    private function _queue_fulfillment(int $order_id): void
    {
        try {
            $this->db->insert('jobs_queue', [
                'store_id'     => $this->store_id,
                'queue'        => 'fulfillment',
                'payload'      => json_encode(['job' => 'push_order_to_supplier', 'order_id' => $order_id]),
                'available_at' => date('Y-m-d H:i:s'),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);

            // Instant automated supplier API push (Qikink / Printrove / CJ)
            if (file_exists(APPPATH . 'jobs/FulfillmentJob.php')) {
                require_once APPPATH . 'jobs/FulfillmentJob.php';
                $pdo = new PDO(
                    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST') ?: '127.0.0.1', getenv('DB_PORT') ?: '3306', getenv('DB_NAME') ?: 'novadrop'),
                    getenv('DB_USER') ?: 'root',
                    getenv('DB_PASS') ?: '',
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
                $job = new \App\Jobs\FulfillmentJob($pdo, $this->store_id, 'qikink');
                $job->handle(['order_id' => $order_id]);
            }
        } catch (Throwable $e) {
            log_message('error', '[Order_model::_queue_fulfillment] ' . $e->getMessage());
        }
    }

    private function _queue_vendor_routing(int $order_id): void
    {
        try {
            $this->db->insert('jobs_queue', [
                'store_id'     => $this->store_id,
                'queue'        => 'fulfillment',
                'payload'      => json_encode(['job' => 'vendor_order_routing', 'order_id' => $order_id]),
                'available_at' => date('Y-m-d H:i:s'),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);

            // Execute synchronously if class exists for real-time dispatch
            if (file_exists(APPPATH . 'jobs/VendorOrderRoutingJob.php')) {
                require_once APPPATH . 'jobs/VendorOrderRoutingJob.php';
                $db_host = function_exists('_env') ? _env('DB_HOST', '127.0.0.1') : (getenv('DB_HOST') ?: '127.0.0.1');
                $db_port = function_exists('_env') ? _env('DB_PORT', '3306') : (getenv('DB_PORT') ?: '3306');
                $db_name = function_exists('_env') ? _env('DB_NAME', 'novadrop') : (getenv('DB_NAME') ?: 'novadrop');
                $db_user = function_exists('_env') ? _env('DB_USER', 'root') : (getenv('DB_USER') ?: 'root');
                $db_pass = function_exists('_env') ? _env('DB_PASS', '') : (getenv('DB_PASS') ?: '');

                $pdo = new PDO(
                    "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4",
                    $db_user,
                    $db_pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
                $job = new \App\Jobs\VendorOrderRoutingJob($pdo, $this->store_id);
                $job->handle(['order_id' => $order_id]);
            }
        } catch (Throwable $e) {
            log_message('error', '[Order_model::_queue_vendor_routing] ' . $e->getMessage());
        }
    }

    private function _queue_email(int $order_id, string $template, array $extra = []): void
    {
        try {
            $this->db->insert('jobs_queue', [
                'store_id'     => $this->store_id,
                'queue'        => 'email',
                'payload'      => json_encode(array_merge(['job' => 'send_email', 'order_id' => $order_id, 'template' => $template], $extra)),
                'available_at' => date('Y-m-d H:i:s'),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $e) {
            log_message('error', '[Order_model::_queue_email] ' . $e->getMessage());
        }
    }

    private function _restore_inventory(int $order_id): void
    {
        $items = $this->db->where('order_id', $order_id)->get('order_items')->result_array();
        foreach ($items as $item) {
            if ($item['variant_id']) {
                $this->db->set('inventory_qty', "inventory_qty + {$item['quantity']}", false)
                         ->where('id', $item['variant_id'])
                         ->update('product_variants');
            }
        }
    }
}
