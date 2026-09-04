<?php
/**
 * Migration 005: Orders Channel & Subsystem Integrations
 */
$pdo = new PDO('mysql:host=127.0.0.1;dbname=novadrop;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Running Migration 005: Orders Channel & Subsystems...\n";

// 1. Add channel column to orders if not present
$cols = $pdo->query("SHOW COLUMNS FROM orders LIKE 'channel'")->fetchAll(PDO::FETCH_COLUMN);
if (empty($cols)) {
    $pdo->exec("ALTER TABLE orders ADD COLUMN channel VARCHAR(30) NOT NULL DEFAULT 'cart' AFTER source");
    $pdo->exec("ALTER TABLE orders ADD INDEX idx_orders_channel (channel)");
    echo "✓ Added 'channel' column to orders table.\n";
} else {
    echo "ℹ 'channel' column already exists in orders.\n";
}

// 2. Set existing orders with source = 'storefront_buynow' to channel = 'buy_now'
$pdo->exec("UPDATE orders SET channel = 'buy_now' WHERE source = 'storefront_buynow'");
echo "✓ Updated existing Buy Now orders to channel = 'buy_now'.\n";

// 3. Ensure abandoned_carts can store buy_now carts with cart_id as string/hash if needed
$cartIdCol = $pdo->query("SHOW COLUMNS FROM abandoned_carts LIKE 'cart_id'")->fetch(PDO::FETCH_ASSOC);
if ($cartIdCol && strpos(strtolower($cartIdCol['Type']), 'int') !== false) {
    // If cart_id is INT, make sure we can store alphanumeric or add cart_hash
    $hashCol = $pdo->query("SHOW COLUMNS FROM abandoned_carts LIKE 'cart_hash'")->fetchAll(PDO::FETCH_COLUMN);
    if (empty($hashCol)) {
        $pdo->exec("ALTER TABLE abandoned_carts ADD COLUMN cart_hash VARCHAR(64) NULL AFTER cart_id");
        $pdo->exec("ALTER TABLE abandoned_carts ADD INDEX idx_abandoned_cart_hash (cart_hash)");
        echo "✓ Added 'cart_hash' to abandoned_carts for Buy Now session tracking.\n";
    }
}

// 4. Ensure customer_subscriptions has order_id if not present
$subCols = $pdo->query("SHOW COLUMNS FROM customer_subscriptions LIKE 'order_id'")->fetchAll(PDO::FETCH_COLUMN);
if (empty($subCols)) {
    $pdo->exec("ALTER TABLE customer_subscriptions ADD COLUMN order_id INT NULL AFTER customer_id");
    echo "✓ Added 'order_id' to customer_subscriptions.\n";
}

// 5. Ensure idempotency_keys supports 'preview' status
$pdo->exec("ALTER TABLE idempotency_keys MODIFY COLUMN status ENUM('preview','pending','completed','failed') NOT NULL DEFAULT 'pending'");
echo "✓ Ensured idempotency_keys supports 'preview' status.\n";

echo "Migration 005 completed successfully!\n";
