<?php
namespace App\Jobs;

use PDO;
use Throwable;

/**
 * DataMoatScoringJob — First-Party Product Performance Data Moat
 * Continuously learns from live conversion rates, cart adds, and RTO return rates
 * to refine product selection algorithms and prioritize winning SKUs.
 */
class DataMoatScoringJob
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
        // 1. Fetch All Active Products
        $stmt_prods = $this->pdo->prepare("
            SELECT p.id, p.title, p.base_price, p.views_count,
                   COALESCE((SELECT COUNT(*) FROM cart_items ci JOIN product_variants pv ON pv.id = ci.variant_id WHERE pv.product_id = p.id), 0) AS cart_adds,
                   COALESCE((SELECT SUM(oi.quantity) FROM order_items oi JOIN orders o ON o.id = oi.order_id WHERE oi.product_title LIKE CONCAT('%', p.title, '%') AND o.payment_status = 'paid'), 0) AS units_sold,
                   COALESCE((SELECT COUNT(*) FROM orders o JOIN rto_risk_evaluations rto ON rto.order_id = o.id WHERE o.status = 'returned'), 0) AS rto_returns
            FROM products p
            WHERE p.store_id = ?
        ");
        $stmt_prods->execute([$this->store_id]);
        $products = $stmt_prods->fetchAll();

        $updated_count = 0;

        foreach ($products as $p) {
            $pid = (int)$p['id'];
            $views = max(1, (int)$p['views_count']);
            $cart_adds = (int)$p['cart_adds'];
            $purchases = (int)$p['units_sold'];
            $rto_count = (int)$p['rto_returns'];
            $price = (float)$p['base_price'];

            // Compute Conversion & CTR metrics
            $ctr = round(($cart_adds / $views) * 100, 2);
            $cvr = round(($purchases / $views) * 100, 2);
            $rto_pct = ($purchases > 0) ? round(($rto_count / $purchases) * 100, 2) : 0.00;
            $gross_margin_yield = $purchases * ($price * 0.60);

            // Compute First-Party Data Moat Score
            // Formula: (CVR * 3.5) + (CTR * 1.5) + (Gross Margin Yield * 0.005) - (RTO Rate * 2.0)
            $moat_score = round(($cvr * 3.5) + ($ctr * 1.5) + ($gross_margin_yield * 0.005) - ($rto_pct * 2.0) + 50.0, 2);

            // Upsert into product_performance_metrics
            $this->pdo->prepare("
                INSERT INTO product_performance_metrics (product_id, views_count, cart_adds_count, purchases_count, rto_returns_count, ctr_pct, conversion_rate_pct, gross_margin_yield, data_moat_score, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                    views_count = VALUES(views_count),
                    cart_adds_count = VALUES(cart_adds_count),
                    purchases_count = VALUES(purchases_count),
                    rto_returns_count = VALUES(rto_returns_count),
                    ctr_pct = VALUES(ctr_pct),
                    conversion_rate_pct = VALUES(conversion_rate_pct),
                    gross_margin_yield = VALUES(gross_margin_yield),
                    data_moat_score = VALUES(data_moat_score),
                    updated_at = NOW()
            ")->execute([
                $pid,
                $views,
                $cart_adds,
                $purchases,
                $rto_count,
                $ctr,
                $cvr,
                $gross_margin_yield,
                $moat_score
            ]);

            // Synchronize back to product_winning_scores
            $this->pdo->prepare("
                UPDATE product_winning_scores 
                SET winning_score = ?,
                    is_flagged_winner = IF(? >= 75.0, 1, 0),
                    updated_at = NOW()
                WHERE product_id = ?
            ")->execute([$moat_score, $moat_score, $pid]);

            $updated_count++;
        }

        return true;
    }
}
