<?php
namespace App\Agents;

use PDO;
use Throwable;

/**
 * WhatsAppCommerceAgent — India-Native WhatsApp Commerce & COD Risk Reducer
 * Handles:
 * 1. COD RTO Risk Evaluation & WhatsApp 1-Click Order Confirmation
 * 2. Real-Time Order Tracking Inquiries
 * 3. Post-Delivery Review Requests & 1-Click Reorder Deep Links
 */
class WhatsAppCommerceAgent
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
     * Evaluate COD RTO Risk & Dispatch WhatsApp Order Confirmation
     */
    public function evaluate_and_send_cod_confirmation(int $order_id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT o.*, c.phone AS customer_phone, c.name AS customer_name,
                   (SELECT COUNT(*) FROM orders past WHERE past.customer_id = o.customer_id AND past.payment_status = 'paid') AS successful_past_orders
            FROM orders o
            LEFT JOIN customers c ON c.id = o.customer_id
            WHERE o.id = ? AND o.store_id = ?
        ");
        $stmt->execute([$order_id, $this->store_id]);
        $order = $stmt->fetch();

        if (!$order) {
            return ['success' => false, 'error' => 'Order not found'];
        }

        $total = (float)$order['total'];
        $past_orders = (int)$order['successful_past_orders'];
        $phone = $order['customer_phone'] ?? '9870330063';
        $name = $order['customer_name'] ?: 'Customer';

        // Calculate India RTO Risk Score (0.00 to 1.00):
        // 1. High COD Value (> ₹2,000) => +0.35
        // 2. First-Time COD Buyer => +0.30
        // 3. Short / Missing Address => +0.20
        $rto_score = 0.05;
        if ($total >= 2000.00) $rto_score += 0.35;
        if ($past_orders === 0) $rto_score += 0.30;
        if (strlen($order['shipping_address_id'] ?? '') < 1) $rto_score += 0.15;

        $rto_score = min(1.00, round($rto_score, 2));
        $risk_tier = ($rto_score >= 0.60) ? 'high' : (($rto_score >= 0.30) ? 'medium' : 'low');

        // Generate confirmation token & link
        $token = bin2hex(random_bytes(16));
        $confirm_url = (getenv('APP_URL') ?: 'http://localhost/Dropshipping') . "/api/v1/cod/confirm?token=$token";

        // Store RTO evaluation record
        $this->pdo->prepare("
            INSERT INTO rto_risk_evaluations (store_id, order_id, cod_amount, rto_risk_score, risk_tier, is_confirmed_via_whatsapp, confirmation_token, created_at)
            VALUES (?, ?, ?, ?, ?, 0, ?, NOW())
        ")->execute([
            $this->store_id,
            $order_id,
            $total,
            $rto_score,
            $risk_tier,
            $token
        ]);

        // WhatsApp Confirmation Message Body
        $wa_message = sprintf(
            "Hello %s! 👋\nThank you for choosing LUMINA ATELIER.\n\nYour Order *%s* (Total: ₹%s) is prepared for dispatch.\n\n🚚 To ensure express priority dispatch, please confirm your delivery address by clicking below:\n👉 %s\n\nOr reply *CONFIRM* to this message.",
            $name,
            $order['order_number'],
            number_format($total, 2),
            $confirm_url
        );

        $wa_link = "https://wa.me/" . preg_replace('/[^0-9]/', '', $phone) . "?text=" . urlencode($wa_message);

        // Record WhatsApp Task
        $this->pdo->prepare("
            INSERT INTO ai_agent_tasks (store_id, agent, input_json, output_text, status, created_at)
            VALUES (?, 'whatsapp_cod_confirmation', ?, ?, 'done', NOW())
        ")->execute([
            $this->store_id,
            json_encode(['order_id' => $order_id, 'phone' => $phone, 'rto_score' => $rto_score, 'risk_tier' => $risk_tier]),
            $wa_message
        ]);

        return [
            'success'          => true,
            'order_id'         => $order_id,
            'rto_risk_score'   => $rto_score,
            'risk_tier'        => $risk_tier,
            'token'            => $token,
            'whatsapp_message' => $wa_message,
            'whatsapp_link'    => $wa_link,
        ];
    }

    /**
     * Confirm COD Order via Token or WhatsApp Webhook
     */
    public function confirm_cod_order(string $token): bool
    {
        $stmt = $this->pdo->prepare("SELECT id, order_id FROM rto_risk_evaluations WHERE confirmation_token = ? AND is_confirmed_via_whatsapp = 0");
        $stmt->execute([$token]);
        $eval = $stmt->fetch();

        if (!$eval) return false;

        $order_id = (int)$eval['order_id'];

        $this->pdo->beginTransaction();
        try {
            // Update RTO record
            $this->pdo->prepare("UPDATE rto_risk_evaluations SET is_confirmed_via_whatsapp = 1, confirmed_at = NOW() WHERE id = ?")
                 ->execute([$eval['id']]);

            // Advance order to processing
            $this->pdo->prepare("UPDATE orders SET status = 'processing', updated_at = NOW() WHERE id = ?")
                 ->execute([$order_id]);

            // Add timeline event
            $this->pdo->prepare("INSERT INTO order_timeline (order_id, actor_type, event, detail, created_at) VALUES (?, 'customer', 'whatsapp.cod_confirmed', 'COD delivery confirmed by customer via WhatsApp.', NOW())")
                 ->execute([$order_id]);

            // Enqueue fulfillment push
            $this->pdo->prepare("INSERT INTO jobs_queue (store_id, queue, payload, status, available_at, created_at) VALUES (?, 'fulfillment', ?, 'pending', NOW(), NOW())")
                 ->execute([$this->store_id, json_encode(['job' => 'push_order_to_supplier', 'order_id' => $order_id])]);

            $this->pdo->commit();
            return true;
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * Handle Customer WhatsApp Order Tracking Query
     */
    public function handle_tracking_inquiry(string $order_ref): array
    {
        $stmt = $this->pdo->prepare("
            SELECT o.*, s.carrier, s.tracking_number AS shipment_awb, s.tracking_url, s.status AS shipment_status
            FROM orders o
            LEFT JOIN shipments s ON s.order_id = o.id
            WHERE o.order_number LIKE ? OR o.id = ?
            LIMIT 1
        ");
        $stmt->execute(['%' . $order_ref . '%', (int)$order_ref]);
        $order = $stmt->fetch();

        if (!$order) {
            return [
                'success' => false,
                'reply'   => "We couldn't find an order matching '$order_ref'. Please verify your Order # (e.g. #10021) or phone number.",
            ];
        }

        $awb = $order['shipment_awb'] ?: ($order['tracking_number'] ?? 'Pending Assignment');
        $carrier = $order['carrier'] ?? 'BlueDart / Delhivery Express';
        $status_label = ucfirst($order['fulfillment_status'] ?? 'Processing');

        $reply = sprintf(
            "📦 *NovaDrop Order Status: %s*\n• Status: *%s*\n• Carrier: %s\n• Live AWB Tracking: `%s`\n• Track Live: %s\n\nNeed assistance? Reply to chat with an executive.",
            $order['order_number'],
            $status_label,
            $carrier,
            $awb,
            $order['tracking_url'] ?: "https://track.novadrop.in/$awb"
        );

        return [
            'success'  => true,
            'order_id' => $order['id'],
            'reply'    => $reply,
        ];
    }

    /**
     * Send Post-Delivery Loyalty Reorder Hook with 1-Click Deep Link
     */
    public function send_post_delivery_reorder_hook(int $order_id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT o.*, c.phone, c.name 
            FROM orders o 
            LEFT JOIN customers c ON c.id = o.customer_id 
            WHERE o.id = ?
        ");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();

        $name = $order['name'] ?: 'Friend';
        $reorder_url = (getenv('APP_URL') ?: 'http://localhost/Dropshipping') . "/shop?loyalty=VIP15";

        $message = sprintf(
            "🌟 Hope you're loving your new NovaDrop gear, %s!\n\nAs a verified owner, we've added an exclusive *15%% VIP Loyalty Discount* to your account for any companion accessory or gift:\n👉 Use Code: *VIP15*\nShop Collection: %s",
            $name,
            $reorder_url
        );

        return [
            'success' => true,
            'message' => $message,
        ];
    }

    /**
     * Dispatch Outbound WhatsApp Message via Meta Cloud API or Configured Gateway
     */
    public function send_whatsapp_message(string $phone, string $text): array
    {
        $clean_phone = preg_replace('/[^0-9]/', '', $phone);
        // Ensure India country code 91 if 10 digits
        if (strlen($clean_phone) === 10) {
            $clean_phone = '91' . $clean_phone;
        }

        $token = getenv('WHATSAPP_CLOUD_API_TOKEN') ?: ($_ENV['WHATSAPP_CLOUD_API_TOKEN'] ?? null);
        $phone_id = getenv('WHATSAPP_PHONE_NUMBER_ID') ?: ($_ENV['WHATSAPP_PHONE_NUMBER_ID'] ?? null);

        if (!empty($token) && !empty($phone_id) && $token !== 'your_meta_permanent_access_token_here') {
            try {
                $url = "https://graph.facebook.com/v19.0/{$phone_id}/messages";
                $payload = json_encode([
                    'messaging_product' => 'whatsapp',
                    'recipient_type'    => 'individual',
                    'to'                => $clean_phone,
                    'type'              => 'text',
                    'text'              => ['preview_url' => true, 'body' => $text]
                ]);

                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => $payload,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT        => 8,
                    CURLOPT_HTTPHEADER     => [
                        'Authorization: Bearer ' . $token,
                        'Content-Type: application/json',
                    ],
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);
                $res = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                return [
                    'success'   => ($http_code >= 200 && $http_code < 300),
                    'http_code' => $http_code,
                    'response'  => json_decode($res, true) ?: $res,
                ];
            } catch (Throwable $e) {
                return ['success' => false, 'error' => $e->getMessage()];
            }
        }

        // Mock / Simulation Mode if credentials not yet configured
        return [
            'success'   => true,
            'simulated' => true,
            'to'        => $clean_phone,
            'message'   => $text,
            'note'      => 'Dispatched in Simulation Mode. Add WHATSAPP_CLOUD_API_TOKEN in .env for live Meta delivery.'
        ];
    }
}
