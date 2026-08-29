<?php
namespace App\Agents;

use PDO;
use Throwable;

/**
 * VendorMarketplaceAgent — Multi-Vendor Operations & Payouts Engine
 * Enforces strict multi-vendor data isolation, automated order fulfillment updates,
 * line-item commission audit trails, and automated vendor payout batch calculations.
 */
class VendorMarketplaceAgent
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(?PDO $pdo = null, int $store_id = 1)
    {
        if ($pdo) {
            $this->pdo = $pdo;
        } else {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                getenv('DB_HOST') ?: '127.0.0.1',
                getenv('DB_PORT') ?: '3306',
                getenv('DB_NAME') ?: 'novadrop'
            );
            $this->pdo = new PDO($dsn, getenv('DB_USER') ?: 'root', getenv('DB_PASS') ?: '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }
        $this->store_id = $store_id;
    }

    /**
     * Vendor Action: Mark Line Items as Shipped with Tracking Number
     * Strictly enforces that Vendor A can only fulfill Vendor A's items!
     */
    public function vendor_mark_shipped(int $vendor_id, int $order_id, string $carrier, string $tracking_number): array
    {
        // 1. Verify and Fetch Vendor's Line Items for this Order (Hard Security Isolation)
        $stmt = $this->pdo->prepare("
            SELECT oi.*, o.order_number, o.guest_email, v.business_name
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            JOIN vendors v ON v.id = oi.vendor_id
            WHERE oi.order_id = ? AND oi.vendor_id = ?
        ");
        $stmt->execute([$order_id, $vendor_id]);
        $vendor_items = $stmt->fetchAll();

        if (empty($vendor_items)) {
            return [
                'success' => false,
                'error'   => 'Unauthorized or no matching line items found for this seller in order #' . $order_id
            ];
        }

        $this->pdo->beginTransaction();
        try {
            // 2. Update line items
            $this->pdo->prepare("
                UPDATE order_items 
                SET vendor_fulfillment_status = 'shipped',
                    vendor_carrier = ?,
                    vendor_tracking_number = ?,
                    vendor_shipped_at = NOW()
                WHERE order_id = ? AND vendor_id = ?
            ")->execute([$carrier, $tracking_number, $order_id, $vendor_id]);

            // 3. Mark vendor notification as acknowledged
            $this->pdo->prepare("
                UPDATE vendor_order_notifications 
                SET status = 'acknowledged',
                    acknowledged_at = NOW()
                WHERE order_id = ? AND vendor_id = ?
            ")->execute([$order_id, $vendor_id]);

            // 4. Increment vendor total fulfilled orders
            $this->pdo->prepare("
                UPDATE vendors 
                SET total_orders_fulfilled = total_orders_fulfilled + 1,
                    updated_at = NOW()
                WHERE id = ?
            ")->execute([$vendor_id]);

            // 5. Add milestone to order timeline
            $business_name = $vendor_items[0]['business_name'];
            $order_number = $vendor_items[0]['order_number'];
            $this->pdo->prepare("
                INSERT INTO order_timeline (order_id, actor_type, event, detail, created_at)
                VALUES (?, 'vendor', 'vendor.shipped', ?, NOW())
            ")->execute([
                $order_id,
                "Seller '$business_name' dispatched " . count($vendor_items) . " item(s) via $carrier (AWB: $tracking_number)."
            ]);

            // 6. Check if ALL items in order are now fulfilled
            $stmt_unful = $this->pdo->prepare("
                SELECT COUNT(*) FROM order_items 
                WHERE order_id = ? AND (vendor_fulfillment_status = 'unfulfilled' OR (vendor_id IS NULL AND ? != 'fulfilled'))
            ");
            $stmt_unful->execute([$order_id, 'fulfilled']);
            $unfulfilled_count = (int)$stmt_unful->fetchColumn();

            if ($unfulfilled_count === 0) {
                $this->pdo->prepare("
                    UPDATE orders 
                    SET status = 'shipped',
                        fulfillment_status = 'fulfilled',
                        tracking_number = COALESCE(tracking_number, ?),
                        updated_at = NOW()
                    WHERE id = ?
                ")->execute([$tracking_number, $order_id]);
            }

            // 7. Enqueue Customer Notification Email
            $customer_email = $vendor_items[0]['guest_email'] ?: 'customer@example.com';
            $this->pdo->prepare("
                INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at)
                VALUES (?, 'email', ?, 'pending', NOW(), NOW())
            ")->execute([
                $this->store_id,
                json_encode([
                    'job'             => 'send_email',
                    'to'              => $customer_email,
                    'subject'         => "🚚 Package Dispatched by $business_name for Order $order_number",
                    'template'        => 'vendor_shipment_notice',
                    'seller'          => $business_name,
                    'carrier'         => $carrier,
                    'tracking_number' => $tracking_number,
                ])
            ]);

            $this->pdo->commit();

            return [
                'success'         => true,
                'order_id'        => $order_id,
                'vendor_id'       => $vendor_id,
                'items_fulfilled' => count($vendor_items),
                'carrier'         => $carrier,
                'tracking_number' => $tracking_number,
            ];
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            return [
                'success' => false,
                'error'   => 'Fulfillment update failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Generate Vendor Payout Settlement Batch
     */
    public function generate_payout_batch(int $vendor_id, ?string $period_start = null, ?string $period_end = null): array
    {
        $start = $period_start ?: date('Y-m-01 00:00:00');
        $end   = $period_end ?: date('Y-m-d 23:59:59');

        // Fetch unbilled shipped items for this vendor
        $stmt = $this->pdo->prepare("
            SELECT oi.id, oi.total_price, oi.vendor_commission_amount
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            LEFT JOIN vendor_payout_items vpi ON vpi.order_item_id = oi.id
            WHERE oi.vendor_id = ?
              AND oi.vendor_fulfillment_status = 'shipped'
              AND o.payment_status = 'paid'
              AND vpi.id IS NULL
        ");
        $stmt->execute([$vendor_id]);
        $unbilled_items = $stmt->fetchAll();

        if (empty($unbilled_items)) {
            return [
                'success'       => false,
                'message'       => 'No unbilled fulfilled items found for this seller.',
                'gross_sales'   => 0.00,
                'commission'    => 0.00,
                'net_payable'   => 0.00,
            ];
        }

        $gross_sales = 0.00;
        $total_commission = 0.00;

        foreach ($unbilled_items as $item) {
            $gross_sales += (float)$item['total_price'];
            $total_commission += (float)$item['vendor_commission_amount'];
        }

        $net_payable = $gross_sales - $total_commission;

        $this->pdo->beginTransaction();
        try {
            // 1. Create Payout Batch
            $stmt_p = $this->pdo->prepare("
                INSERT INTO vendor_payouts (vendor_id, period_start, period_end, gross_sales, commission_amount, net_payable, status, reference, created_at)
                VALUES (?, ?, ?, ?, ?, ?, 'pending', ?, NOW())
            ");
            $ref = 'PAY-' . strtoupper(substr(md5(uniqid()), 0, 8));
            $stmt_p->execute([$vendor_id, $start, $end, $gross_sales, $total_commission, $net_payable, $ref]);
            $payout_id = (int)$this->pdo->lastInsertId();

            // 2. Link Payout Items
            foreach ($unbilled_items as $item) {
                $amount = (float)$item['total_price'];
                $comm = (float)$item['vendor_commission_amount'];
                $net = $amount - $comm;

                $this->pdo->prepare("
                    INSERT INTO vendor_payout_items (payout_id, order_item_id, amount, commission, net_amount)
                    VALUES (?, ?, ?, ?, ?)
                ")->execute([$payout_id, $item['id'], $amount, $comm, $net]);
            }

            $this->pdo->commit();

            return [
                'success'           => true,
                'payout_id'         => $payout_id,
                'reference'         => $ref,
                'items_count'       => count($unbilled_items),
                'gross_sales'       => $gross_sales,
                'commission_amount' => $total_commission,
                'net_payable'       => $net_payable,
                'status'            => 'pending'
            ];
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            return [
                'success' => false,
                'error'   => 'Payout batch generation failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check Vendor SLA & Auto-Escalate Unacknowledged Orders (> 24 Hours)
     */
    public function check_vendor_acknowledgment_sla(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT von.*, v.business_name, o.order_number
            FROM vendor_order_notifications von
            JOIN vendors v ON v.id = von.vendor_id
            JOIN orders o ON o.id = von.order_id
            WHERE von.status = 'sent' AND von.sent_at <= DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ");
        $stmt->execute();
        $breached = $stmt->fetchAll();

        $escalated_count = 0;

        foreach ($breached as $b) {
            // Escalate status
            $this->pdo->prepare("UPDATE vendor_order_notifications SET status = 'escalated' WHERE id = ?")
                 ->execute([$b['id']]);

            // Create High-Priority Admin Ticket
            $this->pdo->prepare("
                INSERT INTO tickets (tid, customer_id, name, email, subject, message, priority, intent, status, created_at)
                VALUES (?, 1, 'Vendor SLA Sentinel', 'marketplace@novadrop.in', ?, ?, 'Urgent', 'VendorSLA', 'Open', NOW())
            ")->execute([
                'SLA-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                "🚨 Vendor SLA Breach: Order #{$b['order_number']} by {$b['business_name']}",
                "Seller '{$b['business_name']}' has not acknowledged Order #{$b['order_number']} within the 24-hour fulfillment window. Immediate admin intervention required."
            ]);

            $escalated_count++;
        }

        return [
            'success'         => true,
            'audited_count'   => count($breached),
            'escalated_count' => $escalated_count
        ];
    }
}
