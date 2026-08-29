<?php
namespace App\Jobs;

use PDO;
use Throwable;
use App\Agents\AiOrchestratorAgent;

require_once __DIR__ . '/../core/agents/AiOrchestratorAgent.php';

/**
 * AiOrchestratorJob — Scheduled Autonomous Orchestrator Engine
 * Runs daily cycle over store metrics, personalizes marketing, flags anomalies,
 * and maintains safety guardrails.
 */
class AiOrchestratorJob
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
        $agent = new AiOrchestratorAgent($this->pdo, $this->store_id);
        $res = $agent->run_orchestration_cycle();

        // Write to automation_runs
        try {
            $this->pdo->prepare("
                INSERT INTO automation_runs (store_id, job_name, status, started_at, finished_at, duration_ms, payload_json, created_at)
                VALUES (?, 'ai_orchestrator', 'success', NOW(), NOW(), 0, ?, NOW())
            ")->execute([$this->store_id, json_encode($res)]);
        } catch (Throwable $e) {
            // Non-fatal
        }

        return (bool)($res['success'] ?? false);
    }
}
