<?php
/**
 * Migration 004: One-Click Buy Now & Idempotency Engine
 * Adds customer default checkout preferences and creates idempotency_keys ledger
 */

require_once __DIR__ . '/../config.php';

try {
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

    echo "Connected to database successfully.\n";

    // 1. Add default_address_id to customers
    $stmt = $pdo->query("SHOW COLUMNS FROM `customers` LIKE 'default_address_id'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE `customers` ADD COLUMN `default_address_id` INT UNSIGNED NULL AFTER `loyalty_tier`");
        echo "[+] Added `default_address_id` column to `customers`.\n";
    } else {
        echo "[.] `default_address_id` column already exists on `customers`.\n";
    }

    // 2. Add default_payment_method to customers
    $stmt = $pdo->query("SHOW COLUMNS FROM `customers` LIKE 'default_payment_method'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE `customers` ADD COLUMN `default_payment_method` VARCHAR(30) NULL DEFAULT 'cod' AFTER `default_address_id`");
        echo "[+] Added `default_payment_method` column to `customers`.\n";
    } else {
        echo "[.] `default_payment_method` column already exists on `customers`.\n";
    }

    // 3. Create idempotency_keys table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `idempotency_keys` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `store_id` INT UNSIGNED DEFAULT 1,
        `idempotency_key` VARCHAR(64) NOT NULL,
        `customer_id` INT UNSIGNED NULL,
        `order_id` INT UNSIGNED NULL,
        `status` ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending',
        `response_json` LONGTEXT NULL,
        `created_at` DATETIME NOT NULL,
        `expires_at` DATETIME NOT NULL,
        UNIQUE KEY `uniq_idempotency_key` (`idempotency_key`),
        INDEX `idx_customer` (`customer_id`),
        INDEX `idx_expires` (`expires_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "[+] Created/verified `idempotency_keys` table.\n";

    // 4. Populate default_address_id for existing customers who have a default address
    $customers = $pdo->query("SELECT id FROM `customers` WHERE default_address_id IS NULL")->fetchAll();
    foreach ($customers as $c) {
        $cid = (int)$c['id'];
        $addr = $pdo->query("SELECT id FROM `addresses` WHERE customer_id = $cid ORDER BY is_default DESC, id DESC LIMIT 1")->fetch();
        if ($addr) {
            $aid = (int)$addr['id'];
            $pdo->exec("UPDATE `customers` SET default_address_id = $aid WHERE id = $cid");
            echo "[+] Set default_address_id = $aid for customer $cid.\n";
        }
    }

    echo "Migration 004 completed successfully.\n";

} catch (Throwable $e) {
    echo "[ERROR] Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
