<?php
namespace App\Jobs;

use PDO;

/**
 * SearchSyncJob
 * Syncs updated products to Meilisearch index in the background
 */
class SearchSyncJob
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    public function handle(array $payload = []): bool
    {
        $product_id = (int)($payload['product_id'] ?? 0);
        if (!$product_id) return true;

        $stmt = $this->pdo->prepare("SELECT p.*, p.base_price as min_price FROM products p WHERE p.id = ?");
        $stmt->execute([$product_id]);
        $p = $stmt->fetch();

        if ($p) {
            $host = env('MEILISEARCH_HOST', 'http://127.0.0.1:7700');
            $key  = env('MEILISEARCH_KEY', '');
            if (!empty($host)) {
                $doc = [
                    'id'          => (int)$p['id'],
                    'store_id'    => (int)$p['store_id'],
                    'title'       => $p['title'],
                    'slug'        => $p['slug'],
                    'description' => strip_tags($p['description'] ?? ''),
                    'vendor'      => $p['vendor'],
                    'base_price'  => (float)($p['min_price'] ?? $p['base_price']),
                    'status'      => $p['status'],
                ];
                $ch = curl_init("$host/indexes/products/documents");
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => json_encode([$doc]),
                    CURLOPT_HTTPHEADER     => array_filter(['Content-Type: application/json', $key ? "Authorization: Bearer $key" : '']),
                    CURLOPT_TIMEOUT        => 2,
                ]);
                curl_exec($ch);
                curl_close($ch);
            }

            $this->pdo->prepare("UPDATE products SET meilisearch_synced = 1 WHERE id = ?")->execute([$product_id]);
        }

        return true;
    }
}
