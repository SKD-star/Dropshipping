<?php
namespace App\Jobs;

use PDO;
use Throwable;

/**
 * FinanceReconciliationJob — Nightly Automated Financial & Revenue Leak Sentinel
 * Reconciles gateway settlement records against orders.total, payments.amount,
 * and refunds to ensure 100% financial integrity and detect revenue leaks.
 */
class FinanceReconciliationJob
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
        $audit_window_start = date('Y-m-d 00:00:00', strtotime('-7 days'));
        
        // 1. Audit Paid Orders vs Captured Payments
        $stmt_orders = $this->pdo->prepare("
            SELECT o.id, o.order_number, o.total, o.payment_status,
                   COALESCE((SELECT SUM(p.amount) FROM payments p WHERE p.order_id = o.id AND p.status IN ('captured','paid')), 0) AS captured_payment,
                   COALESCE((SELECT SUM(r.amount) FROM refunds r WHERE r.order_id = o.id AND r.status = 'processed'), 0) AS refunded_amount
            FROM orders o
            WHERE o.store_id = ? AND o.created_at >= ?
        ");
        $stmt_orders->execute([$this->store_id, $audit_window_start]);
        $audited_orders = $stmt_orders->fetchAll();

        $mismatches = [];
        $total_audited_revenue = 0.00;
        $total_variance_leak = 0.00;

        foreach ($audited_orders as $ord) {
            $total = (float)$ord['total'];
            $captured = (float)$ord['captured_payment'];
            $refunded = (float)$ord['refunded_amount'];
            $total_audited_revenue += $total;

            // Scenario A: Order marked paid but captured payment < order total
            if ($ord['payment_status'] === 'paid' && abs($total - $captured) > 1.00) {
                $delta = $total - $captured;
                $total_variance_leak += $delta;
                $mismatches[] = [
                    'order_id'     => $ord['id'],
                    'order_number' => $ord['order_number'],
                    'type'         => 'UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD',
                    'order_total'  => $total,
                    'captured'     => $captured,
                    'variance'     => $delta,
                ];
            }

            // Scenario B: Over-refund detected (refunds > captured)
            if ($refunded > $captured && $captured > 0) {
                $mismatches[] = [
                    'order_id'     => $ord['id'],
                    'order_number' => $ord['order_number'],
                    'type'         => 'OVER_REFUND_EXCEEDS_CAPTURED_PAYMENT',
                    'captured'     => $captured,
                    'refunded'     => $refunded,
                    'variance'     => $refunded - $captured,
                ];
            }
        }

        // 2. Audit Orphaned Payments (Captured payments without valid order)
        $stmt_orphan = $this->pdo->prepare("
            SELECT p.id, p.gateway_payment_id, p.amount, p.created_at 
            FROM payments p
            LEFT JOIN orders o ON o.id = p.order_id
            WHERE p.store_id = ? AND p.status IN ('captured','paid') AND (o.id IS NULL OR o.payment_status = 'unpaid')
        ");
        $stmt_orphan->execute([$this->store_id]);
        $orphaned_payments = $stmt_orphan->fetchAll();

        foreach ($orphaned_payments as $orp) {
            $mismatches[] = [
                'type'               => 'ORPHANED_GATEWAY_CAPTURE_MISSING_ORDER',
                'gateway_payment_id' => $orp['gateway_payment_id'],
                'amount'             => (float)$orp['amount'],
                'created_at'         => $orp['created_at'],
            ];
        }

        $status = empty($mismatches) ? 'CLEARED' : 'MISMATCH_DETECTED';

        // 3. Record Audit Summary to ai_agent_tasks Table
        $summary = sprintf(
            "💰 Finance Reconciliation Statement [%s]:\n• Orders Audited: %d (Total Value: ₹%s)\n• Mismatches / Leaks: %d\n• Total Variance Delta: ₹%s\n• Reconciliation Status: %s",
            date('d M Y'),
            count($audited_orders),
            number_format($total_audited_revenue, 2),
            count($mismatches),
            number_format($total_variance_leak, 2),
            $status
        );

        $this->pdo->prepare("
            INSERT INTO ai_agent_tasks (store_id, agent, input_json, output_text, status, created_at)
            VALUES (?, 'finance_reconciliation', ?, ?, 'done', NOW())
        ")->execute([
            $this->store_id,
            json_encode([
                'audited_count'       => count($audited_orders),
                'total_revenue'       => $total_audited_revenue,
                'mismatches_count'    => count($mismatches),
                'mismatches'          => $mismatches,
                'reconciliation_code' => $status,
            ]),
            $summary
        ]);

        return true;
    }
}
