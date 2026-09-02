<?php
/**
 * One-Off Legacy Non-Clothing Cleanup & Seeder
 * Run manually via CLI when resetting seed catalog. Never run in live web request paths.
 * Usage: php migrations/one_off_clothing_cleanup.php
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

echo "Starting one-off legacy catalog cleanup...\n";

// Remove legacy gadget / electronics keywords if present
$stmt = $pdo->prepare("
    DELETE FROM products 
    WHERE slug LIKE '%powerbank%' OR slug LIKE '%wireless%' OR slug LIKE '%charger%' 
       OR slug LIKE '%qi2%' OR slug LIKE '%headphone%' OR slug LIKE '%watch%' 
       OR slug LIKE '%lamp%' OR slug LIKE '%aerowave%' 
       OR title LIKE '%Powerbank%' OR title LIKE '%Wireless%' OR title LIKE '%Charger%' 
       OR title LIKE '%AeroWave%' OR title LIKE '%Headphone%' OR title LIKE '%Lamp%' 
       OR title LIKE '%Watch%' OR title LIKE '%AirPods%' OR title LIKE '%Chronograph%'
");
$stmt->execute();
$deleted = $stmt->rowCount();

$pdo->exec("DELETE FROM product_images WHERE product_id NOT IN (SELECT id FROM products)");
$pdo->exec("DELETE FROM product_variants WHERE product_id NOT IN (SELECT id FROM products)");

echo "Cleanup completed. Removed {$deleted} legacy non-clothing rows.\n";
