<?php
namespace App\Jobs;

use PDO;
use Throwable;

/**
 * VendorOrderRoutingJob — Multi-Vendor Order Splitting & Instant Notification Engine
 * Splits line items by vendor_id, calculates immutable commission per line item,
 * and dispatches instant dashboard, email, and WhatsApp notifications to onboarded sellers.
 */
class VendorOrderRoutingJob
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id = 1)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    public function handle(array $payload = []): bool
    {
        $order_id = (int)($payload['order_id'] ?? 0);
        if (!$order_id) {
            $order_id = (int)($this->pdo->query("SELECT id FROM orders ORDER BY id DESC LIMIT 1")->fetchColumn() ?: 0);
        }
        if (!$order_id) return true;

        // 1. Fetch Order & Shipping Details
        $stmt_ord = $this->pdo->prepare("SELECT * FROM orders WHERE id = ? AND store_id = ?");
        $stmt_ord->execute([$order_id, $this->store_id]);
        $order = $stmt_ord->fetch();
        if (!$order) return true;

        // 2. Fetch Order Items
        $stmt_items = $this->pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt_items->execute([$order_id]);
        $items = $stmt_items->fetchAll();
        if (empty($items)) return true;

        // 3. Group by Vendor ID (NULL = Platform / Automated Supplier fulfilled)
        $vendor_groups = [];
        foreach ($items as $item) {
            $vid = $item['vendor_id'] ? (int)$item['vendor_id'] : 0;
            if ($vid > 0) {
                $vendor_groups[$vid][] = $item;
            }
        }

        // If no human vendor items in order, return true
        if (empty($vendor_groups)) {
            return true;
        }

        // 4. Process Each Vendor's Line Items
        foreach ($vendor_groups as $vendor_id => $v_items) {
            // Fetch Vendor Profile & Commission Rate
            $stmt_v = $this->pdo->prepare("SELECT * FROM vendors WHERE id = ? AND store_id = ?");
            $stmt_v->execute([$vendor_id, $this->store_id]);
            $vendor = $stmt_v->fetch();

            if (!$vendor) continue;

            $comm_type = $vendor['commission_type']; // 'percent' or 'flat'
            $comm_val = (float)$vendor['commission_value'];

            $vendor_subtotal = 0.00;
            $vendor_total_commission = 0.00;
            $vendor_item_titles = [];

            // Calculate Commission per Line Item
            foreach ($v_items as $vi) {
                $item_id = (int)$vi['id'];
                $item_price = (float)$vi['total_price'];
                $vendor_subtotal += $item_price;

                if ($comm_type === 'percent') {
                    $item_commission = round($item_price * ($comm_val / 100), 2);
                } else {
                    $item_commission = min($item_price, round($comm_val * (int)$vi['quantity'], 2));
                }

                $vendor_total_commission += $item_commission;
                $vendor_item_titles[] = "{$vi['product_title']} (x{$vi['quantity']})";

                // Update order_item with immutable commission record
                $this->pdo->prepare("
                    UPDATE order_items 
                    SET vendor_commission_amount = ?,
                        vendor_fulfillment_status = 'unfulfilled'
                    WHERE id = ?
                ")->execute([$item_commission, $item_id]);

                // Create Dashboard Notification Record
                $this->pdo->prepare("
                    INSERT INTO vendor_order_notifications (order_item_id, order_id, vendor_id, channel, payload_json, sent_at, status)
                    VALUES (?, ?, ?, 'dashboard', ?, NOW(), 'sent')
                ")->execute([
                    $item_id,
                    $order_id,
                    $vendor_id,
                    json_encode([
                        'order_number' => $order['order_number'],
                        'item_title'   => $vi['product_title'],
                        'quantity'     => $vi['quantity'],
                        'price'        => $vi['total_price'],
                        'commission'   => $item_commission,
                        'net_payable'  => $item_price - $item_commission,
                    ])
                ]);
            }

            // Dispatched Email Notification to Vendor
            if (!empty($vendor['email'])) {
                $this->pdo->prepare("
                    INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at)
                    VALUES (?, 'email', ?, 'pending', NOW(), NOW())
                ")->execute([
                    $this->store_id,
                    json_encode([
                        'job'            => 'send_email',
                        'to'             => $vendor['email'],
                        'name'           => $vendor['contact_name'],
                        'subject'        => "📦 New Order Assigned: #{$order['order_number']} — {$vendor['business_name']}",
                        'template'       => 'vendor_order_notification',
                        'order_number'   => $order['order_number'],
                        'items'          => implode(', ', $vendor_item_titles),
                        'vendor_subtotal'=> $vendor_subtotal,
                        'action_url'     => (getenv('APP_URL') ?: 'http://localhost/Dropshipping') . "/vendor/orders/view/$order_id",
                    ])
                ]);
            }

            // WhatsApp Notification Payload to Vendor Phone
            if (!empty($vendor['phone'])) {
                $wa_msg = sprintf(
                    "Hello %s! 🚀 New Order *%s* has been assigned to *%s*.\n\nItems to Dispatch:\n• %s\n\nTotal: ₹%s (Net: ₹%s)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 %s",
                    $vendor['contact_name'],
                    $order['order_number'],
                    $vendor['business_name'],
                    implode("\n• ", $vendor_item_titles),
                    number_format($vendor_subtotal, 2),
                    number_format($vendor_subtotal - $vendor_total_commission, 2),
                    (getenv('APP_URL') ?: 'http://localhost/Dropshipping') . "/vendor/orders"
                );

                $this->pdo->prepare("
                    INSERT INTO ai_agent_tasks (store_id, agent, input_json, output_text, status, created_at)
                    VALUES (?, 'vendor_whatsapp_dispatch', ?, ?, 'done', NOW())
                ")->execute([
                    $this->store_id,
                    json_encode(['vendor_id' => $vendor_id, 'phone' => $vendor['phone'], 'order_id' => $order_id]),
                    $wa_msg
                ]);
            }

            // Log Order Timeline
            $this->pdo->prepare("
                INSERT INTO order_timeline (order_id, actor_type, event, detail, created_at)
                VALUES (?, 'system', 'vendor.order_routed', ?, NOW())
            ")->execute([
                $order_id,
                "Order routed to Marketplace Seller '{$vendor['business_name']}' (" . count($v_items) . " item(s))."
            ]);
        }

        return true;
    }
}
