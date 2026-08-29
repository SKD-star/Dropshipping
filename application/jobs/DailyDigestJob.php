<?php
namespace App\Jobs;

use PDO;
use Throwable;

/**
 * DailyDigestJob — Executive Financial & Operational Intelligence Rollup
 * Aggregates real-time P&L revenue, AOV, top-selling SKUs, inventory stockout risks,
 * and gateway payment health from production database tables.
 */
class DailyDigestJob
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
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');

        // 1. Sales & Revenue Rollup
        $stmt_sales = $this->pdo->prepare("
            SELECT 
                COUNT(*) AS total_orders,
                COALESCE(SUM(total), 0) AS gross_revenue,
                COALESCE(AVG(total), 0) AS aov,
                COALESCE(SUM(discount_amount), 0) AS total_discounts
            FROM orders
            WHERE store_id = ? AND payment_status = 'paid' AND created_at >= ?
        ");
        $stmt_sales->execute([$this->store_id, $today_start]);
        $sales = $stmt_sales->fetch();

        $gross_rev = (float)$sales['gross_revenue'];
        $orders_cnt = (int)$sales['total_orders'];
        $aov = (float)$sales['aov'];
        $est_cogs = $gross_rev * 0.35;
        $est_net_profit = $gross_rev - $est_cogs - ($gross_rev * 0.0236);

        // 2. Top-Selling SKUs Today
        $stmt_top = $this->pdo->prepare("
            SELECT oi.product_title, SUM(oi.quantity) as units_sold, SUM(oi.total_price) as revenue
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            WHERE o.store_id = ? AND o.payment_status = 'paid' AND o.created_at >= ?
            GROUP BY oi.product_title
            ORDER BY units_sold DESC
            LIMIT 3
        ");
        $stmt_top->execute([$this->store_id, $today_start]);
        $top_skus = $stmt_top->fetchAll();

        // 3. Low-Stock Alert Count (< 10 units)
        $stmt_stock = $this->pdo->prepare("
            SELECT COUNT(*) FROM product_variants pv 
            JOIN products p ON p.id = pv.product_id 
            WHERE p.store_id = ? AND pv.inventory_qty <= 10 AND p.status = 'active'
        ");
        $stmt_stock->execute([$this->store_id]);
        $low_stock_cnt = (int)$stmt_stock->fetchColumn();

        // 4. Failed / Unpaid Payment Attempts
        $stmt_failed = $this->pdo->prepare("
            SELECT COUNT(*) FROM payments 
            WHERE store_id = ? AND status = 'failed' AND created_at >= ?
        ");
        $stmt_failed->execute([$this->store_id, $today_start]);
        $failed_payments = (int)$stmt_failed->fetchColumn();

        // 5. Build Executive Digest Payload
        $top_skus_text = "";
        foreach ($top_skus as $idx => $sku) {
            $top_skus_text .= ($idx + 1) . ". {$sku['product_title']} ({$sku['units_sold']} units · ₹" . number_format($sku['revenue'], 2) . ") ";
        }
        if (empty($top_skus_text)) $top_skus_text = "No items sold yet today.";

        $digest_summary = sprintf(
            "📊 NovaDrop Daily Executive Digest [%s]:\n• Gross GMV: ₹%s across %d orders (AOV: ₹%s)\n• Estimated Net Profit: ₹%s (Margin ~62.6%%)\n• Top Products: %s\n• Critical Low-Stock SKUs: %d items\n• Failed Payment Alerts: %d",
            date('d M Y'),
            number_format($gross_rev, 2),
            $orders_cnt,
            number_format($aov, 2),
            number_format($est_net_profit, 2),
            $top_skus_text,
            $low_stock_cnt,
            $failed_payments
        );

        // 6. Record to ai_agent_tasks Table
        $this->pdo->prepare("
            INSERT INTO ai_agent_tasks (store_id, agent, input_json, output_text, status, created_at)
            VALUES (?, 'daily_digest', ?, ?, 'done', NOW())
        ")->execute([
            $this->store_id,
            json_encode([
                'gross_revenue'   => $gross_rev,
                'orders_count'    => $orders_cnt,
                'aov'             => $aov,
                'low_stock_count' => $low_stock_cnt,
                'failed_payments' => $failed_payments,
                'top_skus'        => $top_skus,
            ]),
            $digest_summary
        ]);

        // 7. Enqueue Admin Email Notification
        $admin_email = getenv('MAIL_FROM_ADDRESS') ?: 'admin@novadrop.in';
        $this->pdo->prepare("
            INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at)
            VALUES (?, 'email', ?, 'pending', NOW(), NOW())
        ")->execute([
            $this->store_id,
            json_encode([
                'job'      => 'send_email',
                'to'       => $admin_email,
                'name'     => 'Store Administrator',
                'subject'  => "📈 NovaDrop Daily Performance Digest — " . date('d M Y'),
                'template' => 'daily_digest',
                'summary'  => $digest_summary,
            ])
        ]);

        return true;
    }
}
