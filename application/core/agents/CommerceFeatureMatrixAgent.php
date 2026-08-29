<?php
namespace App\Agents;

use PDO;
use Throwable;

/**
 * CommerceFeatureMatrixAgent — 50+ Core Commerce Extensions & Business Logic
 * Implements bundle fulfillment, gift cards, loyalty points, returns, and third-party integrations.
 */
class CommerceFeatureMatrixAgent
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id = 1)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    /**
     * Feature 5: Product Bundles — Decrement Component Stock on Purchase
     */
    public function decrement_bundle_stock(int $bundle_product_id, int $bundle_qty): array
    {
        $stmt = $this->pdo->prepare("
            SELECT pbi.component_product_id, pbi.quantity 
            FROM product_bundle_items pbi
            JOIN product_bundles pb ON pb.id = pbi.bundle_id
            WHERE pb.bundle_product_id = ? AND pb.is_active = 1
        ");
        $stmt->execute([$bundle_product_id]);
        $components = $stmt->fetchAll();

        $updated = [];
        foreach ($components as $comp) {
            $deduct = $comp['quantity'] * $bundle_qty;
            $this->pdo->prepare("
                UPDATE product_variants 
                SET inventory_qty = GREATEST(0, inventory_qty - ?) 
                WHERE product_id = ?
            ")->execute([$deduct, $comp['component_product_id']]);
            $updated[] = ['component_product_id' => $comp['component_product_id'], 'deducted' => $deduct];
        }

        return ['success' => true, 'bundle_product_id' => $bundle_product_id, 'components_updated' => $updated];
    }

    /**
     * Feature 16: Gift Cards — Issue & Redeem
     */
    public function issue_gift_card(float $amount, ?int $customer_id = null): array
    {
        $code = 'NOVA-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 4)) . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 4));
        $this->pdo->prepare("
            INSERT INTO gift_cards (code, initial_balance, current_balance, customer_id, status, created_at)
            VALUES (?, ?, ?, ?, 'active', NOW())
        ")->execute([$code, $amount, $amount, $customer_id]);

        return ['success' => true, 'code' => $code, 'balance' => $amount];
    }

    public function redeem_gift_card(string $code, float $order_total): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM gift_cards WHERE code = ? AND status = 'active'");
        $stmt->execute([$code]);
        $card = $stmt->fetch();

        if (!$card || (float)$card['current_balance'] <= 0) {
            return ['success' => false, 'error' => 'Invalid or depleted gift card'];
        }

        $balance = (float)$card['current_balance'];
        $applied_amount = min($balance, $order_total);
        $new_balance = $balance - $applied_amount;
        $new_status = ($new_balance <= 0) ? 'redeemed' : 'active';

        $this->pdo->prepare("UPDATE gift_cards SET current_balance = ?, status = ? WHERE id = ?")->execute([$new_balance, $new_status, $card['id']]);

        return [
            'success'        => true,
            'code'           => $code,
            'applied_amount' => $applied_amount,
            'remaining_balance' => $new_balance,
            'payable_total'  => max(0, $order_total - $applied_amount)
        ];
    }

    /**
     * Feature 17: Loyalty Points Engine
     */
    public function award_loyalty_points(int $customer_id, float $order_total): int
    {
        $points_earned = (int)floor($order_total / 100) * 5; // 5 points per ₹100 spent
        $this->pdo->prepare("
            INSERT INTO loyalty_points (customer_id, points_balance, lifetime_earned, lifetime_spent, updated_at)
            VALUES (?, ?, ?, 0, NOW())
            ON DUPLICATE KEY UPDATE 
                points_balance = points_balance + VALUES(points_balance),
                lifetime_earned = lifetime_earned + VALUES(lifetime_earned),
                updated_at = NOW()
        ")->execute([$customer_id, $points_earned, $points_earned]);

        return $points_earned;
    }

    /**
     * Feature 30: Product Recommendation Engine (Co-occurrence Matrix)
     */
    public function get_recommended_products(int $product_id, int $limit = 4): array
    {
        $stmt = $this->pdo->prepare("
            SELECT p.id, p.title, p.base_price, p.slug, COUNT(oi2.order_id) AS co_bought_count
            FROM order_items oi1
            JOIN order_items oi2 ON oi2.order_id = oi1.order_id AND oi2.product_id != oi1.product_id
            JOIN products p ON p.id = oi2.product_id
            WHERE oi1.product_id = ? AND p.status = 'active'
            GROUP BY p.id
            ORDER BY co_bought_count DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $product_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $recs = $stmt->fetchAll();

        if (empty($recs)) {
            // Fallback to top-selling catalog items
            $stmt_top = $this->pdo->prepare("SELECT id, title, base_price, slug FROM products WHERE status = 'active' AND id != ? LIMIT ?");
            $stmt_top->bindValue(1, $product_id, PDO::PARAM_INT);
            $stmt_top->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt_top->execute();
            $recs = $stmt_top->fetchAll();
        }

        return $recs;
    }

    /**
     * Feature 33: Returns & Exchange Management
     */
    public function create_return_request(int $order_id, int $customer_id, int $order_item_id, string $reason): array
    {
        $stmt_oi = $this->pdo->prepare("SELECT total_price FROM order_items WHERE id = ? AND order_id = ?");
        $stmt_oi->execute([$order_item_id, $order_id]);
        $item_price = (float)$stmt_oi->fetchColumn();

        $this->pdo->prepare("
            INSERT INTO return_requests (order_id, order_item_id, customer_id, reason, status, refund_amount, created_at)
            VALUES (?, ?, ?, ?, 'requested', ?, NOW())
        ")->execute([$order_id, $order_item_id, $customer_id, $reason, $item_price]);

        return [
            'success'       => true,
            'return_id'     => (int)$this->pdo->lastInsertId(),
            'order_id'      => $order_id,
            'refund_amount' => $item_price,
            'status'        => 'requested'
        ];
    }

    /**
     * Feature 57: Google Merchant Center & Meta Catalog XML/JSON Feed
     */
    public function generate_product_catalog_feed(string $format = 'xml'): string
    {
        $stmt = $this->pdo->query("
            SELECT p.id, p.title, p.description, p.base_price, p.slug, pv.sku, pv.inventory_qty
            FROM products p
            LEFT JOIN product_variants pv ON pv.product_id = p.id
            WHERE p.status = 'active'
            GROUP BY p.id
        ");
        $products = $stmt->fetchAll();

        if ($format === 'json') {
            return json_encode(['feed_version' => '2.0', 'items' => $products], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        // XML Feed
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . "\n";
        $xml .= "<channel>\n<title>NovaDrop Commerce Catalog Feed</title>\n<link>http://localhost/Dropshipping</link>\n";
        foreach ($products as $p) {
            $xml .= "<item>\n";
            $xml .= "  <g:id>" . $p['id'] . "</g:id>\n";
            $xml .= "  <g:title><![CDATA[" . htmlspecialchars($p['title']) . "]]></g:title>\n";
            $xml .= "  <g:description><![CDATA[" . htmlspecialchars($p['description'] ?: $p['title']) . "]]></g:description>\n";
            $xml .= "  <g:link>http://localhost/Dropshipping/product/" . urlencode($p['slug']) . "</g:link>\n";
            $xml .= "  <g:price>" . number_format((float)$p['base_price'], 2) . " INR</g:price>\n";
            $xml .= "  <g:availability>" . ($p['inventory_qty'] > 0 ? 'in stock' : 'out of stock') . "</g:availability>\n";
            $xml .= "  <g:condition>new</g:condition>\n";
            $xml .= "</item>\n";
        }
        $xml .= "</channel>\n</rss>";
        return $xml;
    }

    /**
     * Feature 59: Accounting Export (Zoho Books / Tally compatible CSV)
     */
    public function generate_accounting_export(string $start_date, string $end_date): string
    {
        $stmt = $this->pdo->prepare("
            SELECT o.order_number, o.created_at AS txn_date, o.total AS gross_amount, 
                   o.payment_method, o.payment_status,
                   COALESCE(SUM(oi.vendor_commission_amount), 0) AS platform_commission,
                   COALESCE(SUM(oi.total_price - oi.vendor_commission_amount), 0) AS vendor_payable
            FROM orders o
            LEFT JOIN order_items oi ON oi.order_id = o.id
            WHERE o.created_at BETWEEN ? AND ? AND o.payment_status = 'paid'
            GROUP BY o.id
            ORDER BY o.id ASC
        ");
        $stmt->execute([$start_date, $end_date]);
        $rows = $stmt->fetchAll();

        $csv = "Voucher_Number,Date,Gross_GMV,Platform_Revenue_Commission,Vendor_Payable,Payment_Gateway,Status\n";
        foreach ($rows as $r) {
            $csv .= sprintf(
                "%s,%s,%.2f,%.2f,%.2f,%s,%s\n",
                $r['order_number'],
                date('Y-m-d', strtotime($r['txn_date'])),
                (float)$r['gross_amount'],
                (float)$r['platform_commission'],
                (float)$r['vendor_payable'],
                $r['payment_method'],
                $r['payment_status']
            );
        }
        return $csv;
    }
}
