<?php
namespace App\Jobs;

use PDO;
use Throwable;

/**
 * AbandonedCartJob — Multi-Step Staged Cart Recovery Orchestrator
 * Dispatches automated 3-stage omnichannel sequences (Email + WhatsApp)
 * based on abandoned_cart_sequences and abandoned_cart_steps.
 */
class AbandonedCartJob
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
        $specific_cart_id = $payload['cart_id'] ?? null;

        // 1. Fetch Active Sequences and Steps
        $stmt_seq = $this->pdo->prepare("SELECT * FROM abandoned_cart_sequences WHERE store_id = ? AND is_active = 1 LIMIT 1");
        $stmt_seq->execute([$this->store_id]);
        $seq = $stmt_seq->fetch();
        if (!$seq) return true;

        $stmt_steps = $this->pdo->prepare("SELECT * FROM abandoned_cart_steps WHERE sequence_id = ? ORDER BY delay_minutes ASC");
        $stmt_steps->execute([$seq['id']]);
        $steps = $stmt_steps->fetchAll();
        if (empty($steps)) return true;

        // 2. Query Abandoned Carts
        if ($specific_cart_id) {
            $sql = "
                SELECT c.id, c.customer_id, c.last_activity, c.created_at,
                       COALESCE(cu.email, '') AS customer_email,
                       COALESCE(cu.name, 'Valued Customer') AS customer_name,
                       COALESCE(cu.phone, '') AS customer_phone,
                       (SELECT COUNT(*) FROM cart_items ci WHERE ci.cart_id = c.id) AS item_count,
                       (SELECT SUM(ci.quantity * ci.unit_price) FROM cart_items ci WHERE ci.cart_id = c.id) AS cart_total
                FROM carts c
                LEFT JOIN customers cu ON cu.id = c.customer_id
                WHERE c.store_id = ? AND c.id = ?
            ";
            $params = [$this->store_id, $specific_cart_id];
        } else {
            $sql = "
                SELECT c.id, c.customer_id, c.last_activity, c.created_at,
                       COALESCE(cu.email, '') AS customer_email,
                       COALESCE(cu.name, 'Valued Customer') AS customer_name,
                       COALESCE(cu.phone, '') AS customer_phone,
                       (SELECT COUNT(*) FROM cart_items ci WHERE ci.cart_id = c.id) AS item_count,
                       (SELECT SUM(ci.quantity * ci.unit_price) FROM cart_items ci WHERE ci.cart_id = c.id) AS cart_total
                FROM carts c
                LEFT JOIN customers cu ON cu.id = c.customer_id
                WHERE c.store_id = ?
                  AND c.last_activity <= DATE_SUB(NOW(), INTERVAL 45 MINUTE)
                  AND NOT EXISTS (SELECT 1 FROM orders o WHERE o.cart_id = c.id AND o.payment_status = 'paid')
            ";
            $params = [$this->store_id];
        }

        $stmt_carts = $this->pdo->prepare($sql);
        $stmt_carts->execute($params);
        $carts = $stmt_carts->fetchAll();

        $dispatched_count = 0;

        foreach ($carts as $cart) {
            if ((int)$cart['item_count'] === 0) continue;

            $cart_id = $cart['id'];
            $email = $cart['customer_email'];
            $phone = $cart['customer_phone'];
            $name = $cart['customer_name'];
            $cart_age_minutes = round((time() - strtotime($cart['last_activity'])) / 60);

            // Fetch already executed steps for this cart
            $stmt_logs = $this->pdo->prepare("SELECT step_id FROM abandoned_cart_log WHERE cart_id = ?");
            $stmt_logs->execute([$cart_id]);
            $completed_steps = $stmt_logs->fetchAll(PDO::FETCH_COLUMN);

            foreach ($steps as $step) {
                $step_id = (int)$step['id'];
                $delay = (int)$step['delay_minutes'];
                $channel = $step['channel'];

                // If step already sent or not yet eligible by delay, skip
                if (in_array($step_id, $completed_steps) || (!$specific_cart_id && $cart_age_minutes < $delay)) {
                    continue;
                }

                // Stage-Specific Recovery Offer
                if ($delay <= 60) {
                    $promo_code = 'SAVE10';
                    $discount_desc = '10% OFF';
                    $subject = "👋 $name, you left something in your NovaDrop cart!";
                } elseif ($delay <= 1440) {
                    $promo_code = 'FREESHIP';
                    $discount_desc = 'Free Express Shipping';
                    $subject = "⚡ Free Shipping unlocked for your reserved cart ($promo_code)";
                } else {
                    $promo_code = 'RECOVER15';
                    $discount_desc = '15% VIP Recovery Discount';
                    $subject = "🔥 Final reminder: 15% OFF expires tonight on your cart";
                }

                $recovery_url = (getenv('APP_URL') ?: 'http://localhost/Dropshipping') . "/cart?recover=$cart_id&code=$promo_code";

                // Channel Dispatch
                if ($channel === 'email' && !empty($email)) {
                    $this->pdo->prepare("
                        INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at)
                        VALUES (?, 'email', ?, 'pending', NOW(), NOW())
                    ")->execute([
                        $this->store_id,
                        json_encode([
                            'job'          => 'send_email',
                            'to'           => $email,
                            'name'         => $name,
                            'subject'      => $subject,
                            'template'     => 'cart_recovery',
                            'promo_code'   => $promo_code,
                            'discount'     => $discount_desc,
                            'recovery_url' => $recovery_url,
                        ])
                    ]);
                }

                // WhatsApp Recovery Payload
                if ($channel === 'whatsapp' || !empty($phone)) {
                    $wa_msg = "Hi $name! Your NovaDrop cart is reserved. Complete checkout now and get $discount_desc with promo code $promo_code: $recovery_url";
                    $this->pdo->prepare("
                        INSERT INTO ai_agent_tasks (store_id, agent, input_json, output_text, status, created_at)
                        VALUES (?, 'whatsapp_recovery', ?, ?, 'done', NOW())
                    ")->execute([
                        $this->store_id,
                        json_encode(['cart_id' => $cart_id, 'phone' => $phone, 'step' => $step_id]),
                        $wa_msg
                    ]);
                }

                // Record to abandoned_cart_log
                $this->pdo->prepare("
                    INSERT INTO abandoned_cart_log (cart_id, step_id, sent_at, status)
                    VALUES (?, ?, NOW(), 'sent')
                ")->execute([$cart_id, $step_id]);

                $dispatched_count++;
                break; // Process one progressive step per run
            }
        }

        return true;
    }
}
