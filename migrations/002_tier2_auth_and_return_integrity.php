<?php
/**
 * Migration 002: Tier 2 — Auth & Return Integrity Schema
 * Usage: php migrations/002_tier2_auth_and_return_integrity.php
 *
 * Safe to re-run: all DDL is idempotent (checks before altering).
 */

require_once __DIR__ . '/../config.php';

$pdo = new PDO(
    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        getenv('DB_HOST') ?: '127.0.0.1',
        getenv('DB_PORT') ?: '3306',
        getenv('DB_NAME') ?: 'novadrop'
    ),
    getenv('DB_USER') ?: 'root',
    getenv('DB_PASS') ?: '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

echo "=== Migration 002: Tier 2 Auth & Return Integrity ===\n";

// Helper: check if column exists
function column_exists(PDO $pdo, string $table, string $col): bool {
    $stmt = $pdo->prepare("SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?");
    $stmt->execute([$table, $col]);
    return (bool)$stmt->fetchColumn();
}

// Helper: check if table exists
function table_exists(PDO $pdo, string $table): bool {
    $stmt = $pdo->prepare("SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?");
    $stmt->execute([$table]);
    return (bool)$stmt->fetchColumn();
}

// Helper: check if index exists
function index_exists(PDO $pdo, string $table, string $key_name): bool {
    $stmt = $pdo->prepare("SELECT 1 FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND INDEX_NAME = ?");
    $stmt->execute([$table, $key_name]);
    return (bool)$stmt->fetchColumn();
}

// ── 1. return_requests: add order_item_id ──────────────────────────────
if (table_exists($pdo, 'return_requests') && !column_exists($pdo, 'return_requests', 'order_item_id')) {
    $pdo->exec("ALTER TABLE `return_requests` ADD COLUMN `order_item_id` INT UNSIGNED NULL DEFAULT NULL COMMENT 'Links RMA to specific order_item for vendor payout adjustment'");
    echo "[OK] return_requests.order_item_id column added\n";
} else {
    echo "[SKIP] return_requests.order_item_id already exists\n";
}

// ── 2. refunds: add return_request_id ──────────────────────────────────
if (table_exists($pdo, 'refunds')) {
    if (!column_exists($pdo, 'refunds', 'return_request_id')) {
        $pdo->exec("ALTER TABLE `refunds` ADD COLUMN `return_request_id` INT UNSIGNED NULL DEFAULT NULL COMMENT 'FK to return_requests.id'");
        echo "[OK] refunds.return_request_id column added\n";
    } else {
        echo "[SKIP] refunds.return_request_id already exists\n";
    }

    if (!column_exists($pdo, 'refunds', 'gateway_refund_id')) {
        $pdo->exec("ALTER TABLE `refunds` ADD COLUMN `gateway_refund_id` VARCHAR(191) NULL DEFAULT NULL COMMENT 'Gateway refund reference ID'");
        echo "[OK] refunds.gateway_refund_id column added\n";
    } else {
        echo "[SKIP] refunds.gateway_refund_id already exists\n";
    }

    if (!column_exists($pdo, 'refunds', 'currency')) {
        $pdo->exec("ALTER TABLE `refunds` ADD COLUMN `currency` CHAR(3) NOT NULL DEFAULT 'INR' COMMENT 'ISO 4217 currency code'");
        echo "[OK] refunds.currency column added\n";
    } else {
        echo "[SKIP] refunds.currency already exists\n";
    }
} else {
    echo "[SKIP] refunds table does not exist yet (will be created by Migration 001)\n";
}

// ── 3. customer_otps: performance indexes ──────────────────────────────
if (table_exists($pdo, 'customer_otps')) {
    if (!index_exists($pdo, 'customer_otps', 'idx_otp_expiry')) {
        $pdo->exec("ALTER TABLE `customer_otps` ADD INDEX `idx_otp_expiry` (`expires_at`, `is_used`)");
        echo "[OK] customer_otps idx_otp_expiry index added\n";
    } else {
        echo "[SKIP] customer_otps idx_otp_expiry already exists\n";
    }
    if (!index_exists($pdo, 'customer_otps', 'idx_otp_verify')) {
        $pdo->exec("ALTER TABLE `customer_otps` ADD INDEX `idx_otp_verify` (`identifier`(50), `is_used`, `expires_at`)");
        echo "[OK] customer_otps idx_otp_verify composite index added\n";
    } else {
        echo "[SKIP] customer_otps idx_otp_verify already exists\n";
    }
} else {
    echo "[SKIP] customer_otps table does not exist\n";
}

// ── 4. admin_users: password_hash NOT NULL ─────────────────────────────
if (table_exists($pdo, 'admin_users')) {
    if (column_exists($pdo, 'admin_users', 'password_hash')) {
        $pdo->exec("ALTER TABLE `admin_users` MODIFY COLUMN `password_hash` VARCHAR(255) NOT NULL COMMENT 'bcrypt hash — never store plaintext'");
        echo "[OK] admin_users.password_hash set NOT NULL\n";
    }
} else {
    echo "[SKIP] admin_users table not found\n";
}

// ── 5. payments: gateway_order_id index ────────────────────────────────
if (table_exists($pdo, 'payments')) {
    if (!index_exists($pdo, 'payments', 'idx_gateway_order_id')) {
        $pdo->exec("ALTER TABLE `payments` ADD INDEX `idx_gateway_order_id` (`gateway_order_id`)");
        echo "[OK] payments idx_gateway_order_id index added\n";
    } else {
        echo "[SKIP] payments idx_gateway_order_id already exists\n";
    }
} else {
    echo "[SKIP] payments table not found\n";
}

echo "\n=== Migration 002 complete ===\n";
