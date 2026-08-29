<?php
namespace App\Agents;

use PDO;
use Throwable;

/**
 * RetentionWinbackAgent — Autonomous WhatsApp/SMS Retention & Winback Engine
 * Enforces Global Message Frequency Caps, Opt-Out Compliance, and 9 Retention Workflows.
 */
class RetentionWinbackAgent
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id = 1)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    /**
     * Guardrail 1: Global Frequency Cap & Opt-out Compliance
     * Max 2 messages / 24h, Max 4 messages / 7 days per recipient phone
     */
    public function can_send_message(string $phone, string $automation_type, string $template_key): bool
    {
        $clean_phone = preg_replace('/[^0-9]/', '', $phone);
        if (empty($clean_phone)) return false;

        // 1. Check Opt-out status in contact_identities
        $stmt_opt = $this->pdo->prepare("SELECT whatsapp_opted_in FROM contact_identities WHERE phone = ? LIMIT 1");
        $stmt_opt->execute([$clean_phone]);
        $opt = $stmt_opt->fetchColumn();
        if ($opt !== false && (int)$opt === 0) {
            return false; // User explicitly opted out
        }

        // 2. Check 24-hour limit (Max 2)
        $stmt_24h = $this->pdo->prepare("
            SELECT COUNT(*) FROM message_frequency_log 
            WHERE recipient_phone = ? AND sent_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ");
        $stmt_24h->execute([$clean_phone]);
        if ((int)$stmt_24h->fetchColumn() >= 2) {
            return false;
        }

        // 3. Check 7-day limit (Max 4)
        $stmt_7d = $this->pdo->prepare("
            SELECT COUNT(*) FROM message_frequency_log 
            WHERE recipient_phone = ? AND sent_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
        ");
        $stmt_7d->execute([$clean_phone]);
        if ((int)$stmt_7d->fetchColumn() >= 4) {
            return false;
        }

        // Record message in frequency log
        $this->pdo->prepare("
            INSERT INTO message_frequency_log (recipient_phone, channel, automation_type, template_key, sent_at)
            VALUES (?, 'whatsapp', ?, ?, NOW())
        ")->execute([$clean_phone, $automation_type, $template_key]);

        return true;
    }

    /**
     * Automation 2: Browse Abandonment (Viewed 2+ times, no cart)
     */
    public function run_browse_abandonment(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT bal.id, bal.product_id, bal.contact_identity_id, ci.phone, ci.email, p.title, p.base_price
            FROM browse_abandonment_log bal
            JOIN contact_identities ci ON ci.id = bal.contact_identity_id
            JOIN products p ON p.id = bal.product_id
            WHERE bal.status = 'pending' AND bal.viewed_count >= 2
            LIMIT 20
        ");
        $stmt->execute();
        $items = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($items as $item) {
            if ($this->can_send_message($item['phone'], 'browse_abandonment', 'tpl_browse_followup')) {
                $this->pdo->prepare("UPDATE browse_abandonment_log SET status = 'sent', sent_at = NOW() WHERE id = ?")->execute([$item['id']]);
                $dispatched++;
            }
        }
        return ['type' => 'browse_abandonment', 'dispatched' => $dispatched];
    }

    /**
     * Automation 3: Back-in-Stock Alerts
     */
    public function run_back_in_stock(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT bis.id, bis.product_id, bis.customer_id, c.phone, p.title, pv.inventory_qty
            FROM back_in_stock_log bis
            JOIN customers c ON c.id = bis.customer_id
            JOIN products p ON p.id = bis.product_id
            JOIN product_variants pv ON pv.product_id = p.id
            WHERE bis.status = 'pending' AND pv.inventory_qty > 0
            GROUP BY bis.id
            LIMIT 20
        ");
        $stmt->execute();
        $items = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($items as $item) {
            if ($this->can_send_message($item['phone'], 'back_in_stock', 'tpl_restock_alert')) {
                $this->pdo->prepare("UPDATE back_in_stock_log SET status = 'sent', sent_at = NOW() WHERE id = ?")->execute([$item['id']]);
                $dispatched++;
            }
        }
        return ['type' => 'back_in_stock', 'dispatched' => $dispatched];
    }

    /**
     * Automation 4: Price Drop Alerts
     */
    public function run_price_drop_alerts(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT pda.id, pda.product_id, pda.customer_id, pda.wishlist_price, p.base_price, c.phone, p.title
            FROM price_drop_alert_log pda
            JOIN customers c ON c.id = pda.customer_id
            JOIN products p ON p.id = pda.product_id
            WHERE pda.status = 'pending' AND p.base_price < pda.wishlist_price
            LIMIT 20
        ");
        $stmt->execute();
        $items = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($items as $item) {
            if ($this->can_send_message($item['phone'], 'price_drop', 'tpl_price_drop_alert')) {
                $this->pdo->prepare("UPDATE price_drop_alert_log SET status = 'sent', drop_price = ?, sent_at = NOW() WHERE id = ?")->execute([$item['base_price'], $item['id']]);
                $dispatched++;
            }
        }
        return ['type' => 'price_drop', 'dispatched' => $dispatched];
    }

    /**
     * Automation 5: Post-Delivery Review Request (Delivered >= 3 Days)
     */
    public function run_post_delivery_review_requests(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT o.id AS order_id, o.guest_email, o.customer_id, c.phone, o.order_number
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            WHERE o.fulfillment_status = 'fulfilled' 
              AND o.status = 'delivered'
              AND o.created_at <= DATE_SUB(NOW(), INTERVAL 3 DAY)
              AND NOT EXISTS (SELECT 1 FROM reviews r WHERE r.order_id = o.id)
            LIMIT 20
        ");
        $stmt->execute();
        $orders = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($orders as $ord) {
            $phone = $ord['phone'] ?: '9870330063';
            if ($this->can_send_message($phone, 'post_delivery_review', 'tpl_review_request')) {
                $dispatched++;
            }
        }
        return ['type' => 'post_delivery_reviews', 'dispatched' => $dispatched];
    }

    /**
     * Automation 6: Replenishment / Reorder Reminders
     */
    public function run_replenishment_reminders(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT rpl.id, rpl.customer_id, rpl.product_id, c.phone, p.title
            FROM replenishment_log rpl
            JOIN customers c ON c.id = rpl.customer_id
            JOIN products p ON p.id = rpl.product_id
            WHERE rpl.status = 'pending' AND rpl.expected_depletion_date <= NOW()
            LIMIT 20
        ");
        $stmt->execute();
        $items = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($items as $item) {
            if ($this->can_send_message($item['phone'], 'replenishment', 'tpl_reorder_nudge')) {
                $this->pdo->prepare("UPDATE replenishment_log SET status = 'sent', sent_at = NOW() WHERE id = ?")->execute([$item['id']]);
                $dispatched++;
            }
        }
        return ['type' => 'replenishment', 'dispatched' => $dispatched];
    }

    /**
     * Automation 7: Win-Back / Dormant Customers (60+ Days Inactive)
     */
    public function run_winback_dormant(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT c.id AS customer_id, c.phone, c.name, DATEDIFF(NOW(), MAX(o.created_at)) AS days_inactive
            FROM customers c
            JOIN orders o ON o.customer_id = c.id
            GROUP BY c.id
            HAVING days_inactive >= 60
            LIMIT 20
        ");
        $stmt->execute();
        $dormant = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($dormant as $d) {
            if ($this->can_send_message($d['phone'], 'winback', 'tpl_winback_offer')) {
                $this->pdo->prepare("
                    INSERT INTO winback_log (customer_id, phone, days_inactive, offer_code, sent_at, status, created_at)
                    VALUES (?, ?, ?, 'COMEBACK15', NOW(), 'sent', NOW())
                ")->execute([$d['customer_id'], $d['phone'], (int)$d['days_inactive']]);
                $dispatched++;
            }
        }
        return ['type' => 'winback', 'dispatched' => $dispatched];
    }

    /**
     * Automation 8: Failed Payment Retry Nudge
     */
    public function run_failed_payment_nudges(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT o.id, o.order_number, o.guest_email, c.phone, o.total
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            WHERE o.payment_status = 'failed' AND o.created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)
            LIMIT 10
        ");
        $stmt->execute();
        $failed_orders = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($failed_orders as $fo) {
            $phone = $fo['phone'] ?: '9870330063';
            if ($this->can_send_message($phone, 'failed_payment_retry', 'tpl_failed_payment_retry')) {
                $dispatched++;
            }
        }
        return ['type' => 'failed_payment_retry', 'dispatched' => $dispatched];
    }

    /**
     * Automation 9: VIP / Milestone Notification
     */
    public function run_vip_milestones(): array
    {
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.phone, c.name, COUNT(o.id) AS order_count, SUM(o.total) AS lifetime_spend
            FROM customers c
            JOIN orders o ON o.customer_id = c.id
            WHERE o.payment_status = 'paid'
            GROUP BY c.id
            HAVING order_count >= 3 OR lifetime_spend >= 10000.00
            LIMIT 20
        ");
        $stmt->execute();
        $vips = $stmt->fetchAll();
        $dispatched = 0;

        foreach ($vips as $vip) {
            if ($this->can_send_message($vip['phone'], 'vip_milestone', 'tpl_vip_congrats')) {
                $dispatched++;
            }
        }
        return ['type' => 'vip_milestones', 'dispatched' => $dispatched];
    }
}
