<?php
/**
 * Migration 001: Financial & Inventory Integrity (Tier 1 Remediation)
 * Ensures DB constraints, payout_status tracking, and refunds ledger
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

    // 1. Ensure order_items has payout_status and vendor_commission_amount
    $stmt = $pdo->query("SHOW COLUMNS FROM `order_items` LIKE 'payout_status'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE `order_items` ADD COLUMN `payout_status` ENUM('pending', 'in_payout', 'paid', 'cancelled', 'refunded') NOT NULL DEFAULT 'pending' AFTER `vendor_fulfillment_status`");
        echo "[+] Added `payout_status` column to `order_items`.\n";
    } else {
        echo "[.] `payout_status` column already exists on `order_items`.\n";
    }

    $stmt = $pdo->query("SHOW COLUMNS FROM `order_items` LIKE 'vendor_commission_amount'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE `order_items` ADD COLUMN `vendor_commission_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `payout_status`");
        echo "[+] Added `vendor_commission_amount` column to `order_items`.\n";
    } else {
        echo "[.] `vendor_commission_amount` column already exists on `order_items`.\n";
    }

    // Add index on order_items (vendor_id, payout_status)
    try {
        $pdo->exec("ALTER TABLE `order_items` ADD INDEX `idx_vendor_payout` (`vendor_id`, `payout_status`)");
        echo "[+] Added index `idx_vendor_payout` to `order_items`.\n";
    } catch (Throwable $e) {
        // Index may already exist
        echo "[.] Index `idx_vendor_payout` already exists or skipped.\n";
    }

    // 2. Ensure refunds ledger table exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS `refunds` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `store_id` INT DEFAULT 1,
        `order_id` INT NOT NULL,
        `order_item_id` INT DEFAULT NULL,
        `return_request_id` INT DEFAULT NULL,
        `amount` DECIMAL(10,2) NOT NULL,
        `currency` VARCHAR(10) DEFAULT 'INR',
        `gateway` VARCHAR(50) NOT NULL,
        `gateway_refund_id` VARCHAR(191) DEFAULT NULL,
        `reason` VARCHAR(255) DEFAULT NULL,
        `status` ENUM('initiated', 'completed', 'failed') DEFAULT 'completed',
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX (`order_id`),
        INDEX (`store_id`),
        INDEX (`return_request_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    echo "[+] Ensured `refunds` table exists.\n";

    // 3. Ensure payments table has proper indexing
    try {
        $pdo->exec("ALTER TABLE `payments` ADD INDEX `idx_order_gateway_status` (`order_id`, `gateway`, `status`)");
        echo "[+] Added index `idx_order_gateway_status` to `payments`.\n";
    } catch (Throwable $e) {
        echo "[.] Index `idx_order_gateway_status` already exists or skipped.\n";
    }

    echo "Migration 001 executed successfully.\n";

} catch (Exception $e) {
    echo "Migration error: " . $e->getMessage() . "\n";
    exit(1);
}
