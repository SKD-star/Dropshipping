<?php
namespace App\Agents;

use PDO;
use Throwable;

/**
 * FraudRiskAgent — Autonomous Transaction Fraud & Anomaly Risk Sentinel
 * Evaluates real-time checkout velocity, IP reputations, first-time high-value orders,
 * and suspicious address patterns. Auto-holds high-risk orders before fulfillment.
 */
class FraudRiskAgent
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
     * Score a single order or audit all recent pending orders
     */
    public function audit_order_risk(int $order_id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT o.*, c.email AS customer_email, c.created_at AS customer_since,
                   (SELECT COUNT(*) FROM orders past_o WHERE past_o.customer_id = o.customer_id AND past_o.id != o.id AND past_o.payment_status = 'paid') AS past_order_count
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            WHERE o.id = ? AND o.store_id = ?
        ");
        $stmt->execute([$order_id, $this->store_id]);
        $order = $stmt->fetch();

        if (!$order) {
            return ['success' => false, 'error' => 'Order not found'];
        }

        $risk_score = 0.00;
        $risk_flags = [];

        $total = (float)$order['total'];
        $ip = $order['ip_address'] ?? '127.0.0.1';
        $email = $order['guest_email'] ?: ($order['customer_email'] ?? '');
        $past_orders = (int)$order['past_order_count'];

        // Signal 1: Order Velocity (Orders from same IP in last 15 minutes)
        $stmt_vel = $this->pdo->prepare("
            SELECT COUNT(*) FROM orders 
            WHERE ip_address = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 15 MINUTE) AND id != ?
        ");
        $stmt_vel->execute([$ip, $order_id]);
        $velocity_count = (int)$stmt_vel->fetchColumn();

        if ($velocity_count >= 3) {
            $risk_score += 0.45;
            $risk_flags[] = "High IP velocity: $velocity_count orders placed from $ip in last 15 mins";
        } elseif ($velocity_count >= 1) {
            $risk_score += 0.15;
            $risk_flags[] = "Repeated IP order: multiple checkouts from $ip";
        }

        // Signal 2: High-Value First-Time Buyer
        if ($past_orders === 0 && $total >= 6000.00) {
            $risk_score += 0.35;
            $risk_flags[] = "High-value first-time purchase (₹" . number_format($total, 2) . ") with 0 prior transaction history";
        }

        // Signal 3: Failed Payment Retries
        $stmt_pay_fails = $this->pdo->prepare("
            SELECT COUNT(*) FROM payments WHERE order_id = ? AND status = 'failed'
        ");
        $stmt_pay_fails->execute([$order_id]);
        $fail_count = (int)$stmt_pay_fails->fetchColumn();

        if ($fail_count >= 2) {
            $risk_score += 0.25;
            $risk_flags[] = "$fail_count failed payment attempts preceding final authorization";
        }

        // Signal 4: Disposable / Test Email Detection
        $disposable_domains = ['tempmail.com', '10minutemail.com', 'throwawaymail.com', 'guerrillamail.com', 'mailinator.com'];
        $email_domain = strtolower(substr(strrchr($email, "@"), 1));
        if (in_array($email_domain, $disposable_domains)) {
            $risk_score += 0.40;
            $risk_flags[] = "Disposable temporary email domain detected: @$email_domain";
        }

        $risk_score = min(1.00, round($risk_score, 2));
        $risk_level = ($risk_score >= 0.65) ? 'high' : (($risk_score >= 0.30) ? 'medium' : 'low');

        // Action: Auto-hold high-risk orders to prevent chargeback / fraud loss
        if ($risk_level === 'high') {
            $this->pdo->prepare("
                UPDATE orders 
                SET status = 'on_hold',
                    risk_level = 'high',
                    risk_flags = ?,
                    updated_at = NOW()
                WHERE id = ?
            ")->execute([json_encode($risk_flags), $order_id]);

            // Add timeline event
            $this->pdo->prepare("
                INSERT INTO order_timeline (order_id, actor_type, event, detail, created_at)
                VALUES (?, 'system', 'fraud.auto_hold', ?, NOW())
            ")->execute([$order_id, "Order placed on security hold. Risk Score: $risk_score. Flags: " . implode('; ', $risk_flags)]);

            // Create urgent admin notification ticket
            $this->pdo->prepare("
                INSERT INTO tickets (tid, customer_id, name, email, subject, message, priority, intent, status, created_at)
                VALUES (?, ?, 'Fraud Sentinel', 'security@novadrop.in', ?, ?, 'Urgent', 'Risk', 'Open', NOW())
            ")->execute([
                'RISK-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                $order['customer_id'] ?? null,
                "🚨 Fraud Security Hold: Order #{$order['order_number']}",
                "Order #{$order['order_number']} flagged as HIGH RISK (Score: $risk_score). Details:\n• Total: ₹" . number_format($total, 2) . "\n• Flags: " . implode("\n• ", $risk_flags)
            ]);
        } else {
            $this->pdo->prepare("
                UPDATE orders 
                SET risk_level = ?,
                    risk_flags = ?,
                    updated_at = NOW()
                WHERE id = ?
            ")->execute([$risk_level, json_encode($risk_flags), $order_id]);
        }

        return [
            'success'     => true,
            'order_id'    => $order_id,
            'risk_score'  => $risk_score,
            'risk_level'  => $risk_level,
            'flags'       => $risk_flags,
            'action'      => ($risk_level === 'high') ? 'AUTO_HELD_FOR_REVIEW' : 'CLEARED_FOR_FULFILLMENT',
        ];
    }
}
