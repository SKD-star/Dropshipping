<?php
namespace App\Agents;

use PDO;
use Throwable;

/**
 * EmailMarketingAgent — Automated Lifecycle & Segmented Email Engine
 * Handles Welcome Series, Rule-based Dynamic Segments, Auto-compiled Newsletters,
 * Open/Click Tracking, and Cross-Channel Frequency Deduplication.
 */
class EmailMarketingAgent
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id = 1)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    /**
     * Subscribe Customer to Email Marketing
     */
    public function subscribe_customer(string $email, ?int $customer_id = null, string $source = 'signup'): bool
    {
        $clean_email = strtolower(trim($email));
        if (!filter_var($clean_email, FILTER_VALIDATE_EMAIL)) return false;

        $stmt = $this->pdo->prepare("
            INSERT INTO email_subscribers (store_id, customer_id, email, subscribed, source, created_at)
            VALUES (?, ?, ?, 1, ?, NOW())
            ON DUPLICATE KEY UPDATE 
                subscribed = 1,
                unsubscribed_at = NULL
        ");
        return $stmt->execute([$this->store_id, $customer_id, $clean_email, $source]);
    }

    /**
     * Automation 1: 3-Stage Welcome Series
     */
    public function send_welcome_series(string $email, string $name = 'Friend', int $step = 1): array
    {
        // Verify subscriber status
        $stmt_sub = $this->pdo->prepare("SELECT subscribed FROM email_subscribers WHERE email = ? AND store_id = ?");
        $stmt_sub->execute([$email, $this->store_id]);
        $is_sub = (int)$stmt_sub->fetchColumn();
        if ($is_sub === 0) {
            return ['success' => false, 'error' => 'User not subscribed or opted out'];
        }

        $app_url = getenv('APP_URL') ?: 'http://localhost/Dropshipping';
        $subject = '';
        $body_html = '';

        if ($step === 1) {
            // Stage 1: Brand Niche Story
            $subject = "Welcome to NovaDrop — Elevate Your Daily Performance";
            $body_html = "<h2>Welcome to NovaDrop, {$name}!</h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.</p><p><a href='{$app_url}/shop' style='background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;'>Explore Collection &rarr;</a></p>";
        } elseif ($step === 2) {
            // Stage 2: First-Order Incentive
            $subject = "Here is your exclusive 10% First Order Welcome Gift: WELCOME10";
            $body_html = "<h2>Your Welcome Gift Awaits</h2><p>Use code <strong>WELCOME10</strong> at checkout for 10% off your first order.</p><p><a href='{$app_url}/shop?coupon=WELCOME10'>Claim Your 10% Discount &rarr;</a></p>";
        } else {
            // Stage 3: Best Sellers & Popular Gear
            $subject = "Trending Gear: The Ergonomic Setups Founders Love";
            $body_html = "<h2>Our Most Loved Workspace Tools</h2><p>Discover our award-winning ergonomic power accessories.</p><p><a href='{$app_url}/shop'>View Top Rated Gear &rarr;</a></p>";
        }

        // Record in jobs_queue for async dispatch via EmailJob
        $this->pdo->prepare("
            INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at)
            VALUES (?, 'send_email', ?, 'pending', NOW(), NOW())
        ")->execute([
            $this->store_id,
            json_encode(['job' => 'send_email', 'to' => $email, 'subject' => $subject, 'body_html' => $body_html])
        ]);

        return ['success' => true, 'email' => $email, 'step' => $step, 'subject' => $subject];
    }

    /**
     * Automation 2: Evaluate and Execute Dynamic Segmented Campaigns
     */
    public function evaluate_and_run_segmented_campaigns(): array
    {
        $stmt_seg = $this->pdo->prepare("SELECT * FROM email_segments WHERE store_id = ?");
        $stmt_seg->execute([$this->store_id]);
        $segments = $stmt_seg->fetchAll();

        $processed = [];
        foreach ($segments as $seg) {
            $rules = json_decode($seg['rule_json'], true) ?: [];
            $days_gt = (int)($rules['last_order_days_gt'] ?? 0);
            $spent_gt = (float)($rules['total_spent_gt'] ?? 0);

            $stmt_recipients = $this->pdo->prepare("
                SELECT c.email, c.name, c.phone, SUM(o.total) AS total_spend, DATEDIFF(NOW(), MAX(o.created_at)) AS days_inactive
                FROM customers c
                JOIN orders o ON o.customer_id = c.id
                JOIN email_subscribers es ON es.email = c.email COLLATE utf8mb4_unicode_ci AND es.subscribed = 1
                WHERE o.payment_status = 'paid'
                GROUP BY c.id
                HAVING total_spend >= ? AND days_inactive >= ?
                LIMIT 50
            ");
            $stmt_recipients->execute([$spent_gt, $days_gt]);
            $candidates = $stmt_recipients->fetchAll();

            $dispatched_count = 0;
            foreach ($candidates as $cand) {
                // Cross-Channel Deduplication Guard: Skip if received WhatsApp message in last 24h
                if ($this->has_cross_channel_fatigue($cand['phone'], $cand['email'])) {
                    continue;
                }

                // Enqueue personalized winback email
                $this->pdo->prepare("
                    INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at)
                    VALUES (?, 'send_email', ?, 'pending', NOW(), NOW())
                ")->execute([
                    $this->store_id,
                    json_encode([
                        'job'       => 'send_email',
                        'to'        => $cand['email'],
                        'subject'   => "VIP Access: Exclusive 15% VIP Reward for " . $cand['name'],
                        'body_html' => "<p>Hi {$cand['name']}, as a valued VIP customer, enjoy ₹500 off your next setup upgrade with code <strong>VIP500</strong>.</p>"
                    ])
                ]);
                $dispatched_count++;
            }
            $processed[] = ['segment_id' => $seg['id'], 'name' => $seg['name'], 'dispatched' => $dispatched_count];
        }

        return ['success' => true, 'segments' => $processed];
    }

    /**
     * Cross-Channel Deduplication Check (WhatsApp & Email Fatigue)
     */
    private function has_cross_channel_fatigue(?string $phone, ?string $email): bool
    {
        if (!$phone && !$email) return false;
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM message_frequency_log 
            WHERE (recipient_phone = ? OR recipient_email = ?) 
              AND sent_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ");
        $stmt->execute([$phone ?: '', $email ?: '']);
        return ((int)$stmt->fetchColumn() > 0);
    }

    /**
     * Automation 3: Generate Weekly Newsletter HTML Digest
     */
    public function generate_weekly_newsletter(): array
    {
        $app_url = getenv('APP_URL') ?: 'http://localhost/Dropshipping';
        $new_arrivals = $this->pdo->query("SELECT title, base_price, slug FROM products WHERE status = 'active' ORDER BY id DESC LIMIT 3")->fetchAll();

        $html = "<div style='font-family:sans-serif;max-width:600px;margin:auto;'>";
        $html .= "<h1 style='color:#4338ca;'>NovaDrop Weekly Innovation Digest</h1>";
        $html .= "<p>Here is what's new and trending this week in our high-performance workspace catalog:</p>";
        $html .= "<ul>";
        foreach ($new_arrivals as $p) {
            $html .= "<li><strong>" . htmlspecialchars($p['title']) . "</strong> — ₹" . number_format($p['base_price'], 2) . " (<a href='{$app_url}/product/" . urlencode($p['slug']) . "'>View Details</a>)</li>";
        }
        $html .= "</ul>";
        $html .= "<p><a href='{$app_url}/shop' style='background:#4338ca;color:#fff;padding:10px 18px;text-decoration:none;border-radius:6px;'>Shop All New Arrivals &rarr;</a></p>";
        $html .= "<hr><small style='color:#888;'>You are receiving this because you subscribed to NovaDrop updates. <a href='{$app_url}/unsubscribe'>Unsubscribe</a></small>";
        $html .= "</div>";

        // Save as Draft Campaign for Admin Review
        $campaign_name = 'Weekly Innovation Digest - ' . date('Y-m-d');
        $this->pdo->prepare("
            INSERT INTO email_campaigns (store_id, name, subject, body_html, status, created_at)
            VALUES (?, ?, '⚡ This Week at NovaDrop: New Ergonomic Releases', ?, 'draft', NOW())
        ")->execute([$this->store_id, $campaign_name, $html]);

        $campaign_id = (int)$this->pdo->lastInsertId();
        return ['success' => true, 'campaign_id' => $campaign_id, 'status' => 'draft'];
    }
}
