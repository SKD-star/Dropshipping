<?php
namespace App\Jobs;

use PDO;
use Throwable;

/**
 * WebhookDeliveryJob — Outbound HMAC-SHA256 Signed Webhook Dispatcher
 * Dispatches event payloads to third-party subscribers with cryptographic signatures
 * and delivery attempt logging.
 */
class WebhookDeliveryJob
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id = 1)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    public function handle(array $payload): bool
    {
        $event = $payload['event'] ?? 'order.created';
        $event_data = $payload['data'] ?? [];
        $payload_json = json_encode([
            'event'     => $event,
            'timestamp' => date('Y-m-d\TH:i:s\Z'),
            'store_id'  => $this->store_id,
            'data'      => $event_data,
        ], JSON_UNESCAPED_SLASHES);

        // Fetch Active Subscriptions for this event or wildcard '*'
        $stmt = $this->pdo->prepare("
            SELECT * FROM webhook_subscriptions 
            WHERE (event = ? OR event = '*') AND is_active = 1 AND store_id = ?
        ");
        $stmt->execute([$event, $this->store_id]);
        $subscriptions = $stmt->fetchAll();

        if (empty($subscriptions)) {
            return true; // No active subscribers
        }

        foreach ($subscriptions as $sub) {
            $sub_id = (int)$sub['id'];
            $target_url = $sub['target_url'];
            $secret = $sub['secret'];

            // Cryptographic HMAC-SHA256 Signature
            $signature = hash_hmac('sha256', $payload_json, $secret);

            $response_code = 0;
            $response_body = '';
            $status = 'failed';

            // Dispatch HTTP POST via cURL
            try {
                $ch = curl_init($target_url);
                curl_setopt_array($ch, [
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => $payload_json,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT        => 8,
                    CURLOPT_CONNECTTIMEOUT => 4,
                    CURLOPT_HTTPHEADER     => [
                        'Content-Type: application/json',
                        'User-Agent: NovaDrop-Webhook-Engine/2.0',
                        'X-NovaDrop-Event: ' . $event,
                        'X-NovaDrop-Signature: ' . $signature,
                    ],
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);

                $response_body = curl_exec($ch);
                $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($response_code >= 200 && $response_code < 300) {
                    $status = 'delivered';
                }
            } catch (Throwable $e) {
                $response_body = 'cURL Error: ' . $e->getMessage();
            }

            // Record to webhook_deliveries
            $this->pdo->prepare("
                INSERT INTO webhook_deliveries (subscription_id, event, payload_json, response_code, response_body, attempt, delivered_at, status, created_at)
                VALUES (?, ?, ?, ?, ?, 1, NOW(), ?, NOW())
            ")->execute([
                $sub_id,
                $event,
                $payload_json,
                $response_code,
                substr($response_body ?: '', 0, 1000),
                $status
            ]);

            // Update Subscription Failure Counts
            if ($status === 'delivered') {
                $this->pdo->prepare("UPDATE webhook_subscriptions SET failure_count = 0 WHERE id = ?")->execute([$sub_id]);
            } else {
                $this->pdo->prepare("UPDATE webhook_subscriptions SET failure_count = failure_count + 1 WHERE id = ?")->execute([$sub_id]);
            }
        }

        return true;
    }
}
