<?php
namespace App\Services;

use PDO;
use Throwable;

/**
 * ApiKeyService — Scoped Bearer Authentication & Active Rolling Rate Limiter
 * Manages API keys with SHA-256 hashing, fine-grained scope authorization,
 * and strict per-minute request rate limiting.
 */
class ApiKeyService
{
    private PDO $pdo;
    private int $store_id;

    public function __construct(PDO $pdo, int $store_id = 1)
    {
        $this->pdo = $pdo;
        $this->store_id = $store_id;
    }

    /**
     * Generate New Scoped API Key (Raw key returned only once)
     */
    public function create_key(string $owner_type, int $owner_id, string $name, array $scopes, int $rate_limit_per_min = 60): array
    {
        $prefix = 'nova_sk_live_' . substr(bin2hex(random_bytes(4)), 0, 6);
        $secret_part = bin2hex(random_bytes(24));
        $raw_key = $prefix . '_' . $secret_part;
        $key_hash = hash('sha256', $raw_key);

        $stmt = $this->pdo->prepare("
            INSERT INTO api_keys (store_id, owner_type, owner_id, name, key_prefix, key_hash, scopes_json, rate_limit_per_min, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())
        ");
        $stmt->execute([
            $this->store_id,
            $owner_type,
            $owner_id,
            $name,
            $prefix,
            $key_hash,
            json_encode($scopes),
            $rate_limit_per_min
        ]);
        $key_id = (int)$this->pdo->lastInsertId();

        return [
            'key_id'             => $key_id,
            'name'               => $name,
            'key_prefix'         => $prefix,
            'raw_key'            => $raw_key, // Display once to user
            'scopes'             => $scopes,
            'rate_limit_per_min' => $rate_limit_per_min,
        ];
    }

    /**
     * Authenticate Incoming Bearer Token
     */
    public function authenticate_token(?string $bearer_header): ?array
    {
        if (!$bearer_header || !preg_match('/Bearer\s+(nova_sk_[a-zA-Z0-9_]+)/i', $bearer_header, $matches)) {
            return null;
        }

        $raw_token = $matches[1];
        $key_hash = hash('sha256', $raw_token);

        $stmt = $this->pdo->prepare("
            SELECT * FROM api_keys 
            WHERE key_hash = ? AND is_active = 1 AND store_id = ?
        ");
        $stmt->execute([$key_hash, $this->store_id]);
        $key = $stmt->fetch();

        if (!$key) return null;

        // Update last used timestamp
        $this->pdo->prepare("UPDATE api_keys SET last_used_at = NOW() WHERE id = ?")->execute([$key['id']]);

        $key['scopes'] = json_decode($key['scopes_json'], true) ?: [];
        return $key;
    }

    /**
     * Check Rolling Window Rate Limit (Last 60 Seconds)
     * Returns true if allowed, false if limit exceeded
     */
    public function check_rate_limit(int $api_key_id, int $limit_per_min): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM api_request_log 
            WHERE api_key_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)
        ");
        $stmt->execute([$api_key_id]);
        $requests_in_last_minute = (int)$stmt->fetchColumn();

        return ($requests_in_last_minute < $limit_per_min);
    }

    /**
     * Log API Request Telemetry
     */
    public function log_request(int $api_key_id, string $endpoint, string $method, int $status_code, string $ip, float $latency_ms): void
    {
        try {
            $this->pdo->prepare("
                INSERT INTO api_request_log (api_key_id, endpoint, method, status_code, ip_address, latency_ms, created_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ")->execute([
                $api_key_id,
                $endpoint,
                $method,
                $status_code,
                $ip,
                $latency_ms
            ]);
        } catch (Throwable $e) {
            // Non-fatal logging
        }
    }

    /**
     * Verify Scope Access
     */
    public function has_scope(array $key_data, string $required_scope): bool
    {
        $scopes = $key_data['scopes'] ?? [];
        if (in_array('*', $scopes) || in_array('admin:all', $scopes)) {
            return true;
        }
        return in_array($required_scope, $scopes);
    }
}
