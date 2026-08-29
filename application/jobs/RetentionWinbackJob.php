<?php
namespace App\Jobs;

use PDO;
use Throwable;
use App\Agents\RetentionWinbackAgent;

require_once __DIR__ . '/../core/agents/RetentionWinbackAgent.php';

/**
 * RetentionWinbackJob — Background Task for 9 Retention & Winback Workflows
 * Handles browse abandonment, restock alerts, price drops, post-delivery reviews,
 * replenishment reminders, win-back, and failed payment retry nudges.
 */
class RetentionWinbackJob
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
        $agent = new RetentionWinbackAgent($this->pdo, $this->store_id);

        $results = [
            'browse_abandonment'   => $agent->run_browse_abandonment(),
            'back_in_stock'        => $agent->run_back_in_stock(),
            'price_drop_alerts'    => $agent->run_price_drop_alerts(),
            'post_delivery_review' => $agent->run_post_delivery_review_requests(),
            'replenishment'        => $agent->run_replenishment_reminders(),
            'winback_dormant'      => $agent->run_winback_dormant(),
            'failed_payment_retry' => $agent->run_failed_payment_nudges(),
            'vip_milestones'       => $agent->run_vip_milestones(),
        ];

        // Record in automation_runs
        try {
            $this->pdo->prepare("
                INSERT INTO automation_runs (store_id, job_name, status, started_at, finished_at, duration_ms, payload_json, created_at)
                VALUES (?, 'retention_winback', 'success', NOW(), NOW(), 0, ?, NOW())
            ")->execute([$this->store_id, json_encode($results)]);
        } catch (Throwable $e) {
            // Non-fatal
        }

        return true;
    }
}
