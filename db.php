<?php
/**
 * Universal Enterprise Database Connection Bridge
 * NovaDrop Commerce OS & Unified Admin Platform
 */

if (!function_exists('load_env_file')) {
    function load_env_file($path) {
        if (!file_exists($path)) return;
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
            list($key, $val) = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val, " \t\n\r\0\x0B\"'");
            if (!isset($_ENV[$key])) {
                putenv("$key=$val");
                $_ENV[$key] = $val;
                $_SERVER[$key] = $val;
            }
        }
    }
}

// 1. Load Master Root config.php
if (file_exists(__DIR__ . '/config.php')) {
    require_once __DIR__ . '/config.php';
}

// 2. Load .env fallback
$env_path = __DIR__ . '/.env';
if (file_exists($env_path)) {
    load_env_file($env_path);
}

$db_host = defined('DB_HOST') ? DB_HOST : (getenv('DB_HOST') ?: '127.0.0.1');
$db_port = (int)(defined('DB_PORT') ? DB_PORT : (getenv('DB_PORT') ?: 3306));
$db_user = defined('DB_USER') ? DB_USER : (getenv('DB_USER') ?: 'root');
$db_pass = defined('DB_PASS') ? DB_PASS : (getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
$db_name = defined('DB_NAME') ? DB_NAME : (getenv('DB_NAME') ?: 'novadrop');

// Establish connection
$conn = @new mysqli($db_host, $db_user, $db_pass, '', $db_port);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Ensure database exists
$conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db($db_name);
$conn->set_charset("utf8mb4");

// Global alias for compatibility
$con = $conn;

// Safe base_url helper fallback for standalone admin scripts
if (!function_exists('base_url')) {
    function base_url($uri = '') {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base = $protocol . $host . '/Dropshipping/';
        return $base . ltrim($uri, '/');
    }
}

// ─── 0. Home Page Settings (Admin-controlled homepage content) ────
$conn->query("
CREATE TABLE IF NOT EXISTS `home_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  -- Announcement Bar
  `announcement_text` VARCHAR(500) DEFAULT 'Complimentary White-Glove Air Dispatch on All Pieces · Apply VIP Code: LUMINA50',
  `announcement_bg_color` VARCHAR(30) DEFAULT '#0a0b0e',
  `announcement_text_color` VARCHAR(30) DEFAULT '#e9c176',
  `announcement_link` VARCHAR(500) DEFAULT '',
  `announcement_enabled` TINYINT(1) DEFAULT 1,
  -- Hero Section
  `hero_label` VARCHAR(200) DEFAULT 'Exclusive VIP Release · Live Catalog',
  `hero_headline` VARCHAR(300) DEFAULT 'Form Without Compromise.',
  `hero_subheadline` VARCHAR(300) DEFAULT '',
  `hero_body` TEXT DEFAULT NULL,
  `hero_bg_image` VARCHAR(500) DEFAULT 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920&q=85',
  `hero_cta_text` VARCHAR(100) DEFAULT 'Explore Boutique',
  `hero_cta_url` VARCHAR(500) DEFAULT '/shop',
  `hero_product_id` INT DEFAULT 1,
  -- Flash Deal Section
  `flash_section_enabled` TINYINT(1) DEFAULT 1,
  `flash_section_title` VARCHAR(200) DEFAULT 'Today''s VIP Flash Deals.',
  `flash_section_subtitle` VARCHAR(400) DEFAULT 'These curated atelier pieces are available at privilege pricing for members only.',
  `flash_timer_hours` INT DEFAULT 7,
  -- Featured Products Section
  `featured_section_title` VARCHAR(200) DEFAULT 'Curated Wardrobe',
  `featured_section_subtitle` VARCHAR(300) DEFAULT 'The Current Collection',
  `featured_section_enabled` TINYINT(1) DEFAULT 1,
  -- New Arrivals Section
  `arrivals_section_title` VARCHAR(200) DEFAULT 'Just Arrived in the Atelier',
  `arrivals_section_subtitle` VARCHAR(300) DEFAULT 'Explore signature silhouettes crafted from raw organic fibers.',
  `arrivals_section_enabled` TINYINT(1) DEFAULT 1,
  -- Sticky Bottom Bar (shows first product by default)
  `sticky_bar_product_id` INT DEFAULT 1,
  `sticky_bar_enabled` TINYINT(1) DEFAULT 1,
  -- WhatsApp Button
  `whatsapp_number` VARCHAR(20) DEFAULT '919999999999',
  `whatsapp_message` VARCHAR(300) DEFAULT 'Hi! I found your Lumina Atelier store and need styling help.',
  `whatsapp_enabled` TINYINT(1) DEFAULT 1,
  -- Trust Badges / Footer Bar
  `trust_badge_1` VARCHAR(100) DEFAULT 'Verified',
  `trust_badge_2` VARCHAR(100) DEFAULT '7-Day Return',
  `trust_badge_3` VARCHAR(100) DEFAULT 'White-Glove Delivery',
  -- Brand & Footer Settings
  `brand_name` VARCHAR(100) DEFAULT 'LUMINA',
  `brand_tagline` TEXT DEFAULT NULL,
  `copyright_text` VARCHAR(300) DEFAULT '© 2026 LUMINA ATELIER COLLECTIVE. ALL RIGHTS RESERVED.',
  `contact_email` VARCHAR(255) DEFAULT 'concierge@lumina-atelier.com',
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Add missing columns if upgrading existing table
$chk_brand = $conn->query("SHOW COLUMNS FROM `home_settings` LIKE 'brand_name'");
if ($chk_brand && $chk_brand->num_rows === 0) {
    $conn->query("ALTER TABLE `home_settings` ADD `brand_name` VARCHAR(100) DEFAULT 'LUMINA'");
    $conn->query("ALTER TABLE `home_settings` ADD `brand_tagline` TEXT DEFAULT NULL");
    $conn->query("ALTER TABLE `home_settings` ADD `copyright_text` VARCHAR(300) DEFAULT '© 2026 LUMINA ATELIER COLLECTIVE. ALL RIGHTS RESERVED.'");
    $conn->query("ALTER TABLE `home_settings` ADD `contact_email` VARCHAR(255) DEFAULT 'concierge@lumina-atelier.com'");
}

// Insert default home_settings row if empty
$hs_check = $conn->query("SELECT id FROM `home_settings` WHERE store_id=1 LIMIT 1");
if ($hs_check && $hs_check->num_rows === 0) {
    $conn->query("INSERT INTO `home_settings` (store_id, brand_name, brand_tagline, copyright_text, contact_email) VALUES (1, 'LUMINA', 'Curated luxury garments and architectural objects for the considered space. Designed with intention, crafted to last.', '© 2026 LUMINA ATELIER COLLECTIVE. ALL RIGHTS RESERVED.', 'concierge@lumina-atelier.com')");
}



$conn->query("
CREATE TABLE IF NOT EXISTS `admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admid` VARCHAR(64) NOT NULL UNIQUE,
  `astat` VARCHAR(30) DEFAULT 'admin',
  `perm` VARCHAR(30) DEFAULT 'admin',
  `name` VARCHAR(150) DEFAULT 'Administrator',
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `email` VARCHAR(255) DEFAULT 'admin@novadrop.in',
  `password` VARCHAR(255) NOT NULL,
  `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `adate` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$chk_perm = $conn->query("SHOW COLUMNS FROM `admin` LIKE 'perm'");
if ($chk_perm && $chk_perm->num_rows === 0) {
    $conn->query("ALTER TABLE `admin` ADD `perm` VARCHAR(30) DEFAULT 'admin' AFTER `astat`");
}
$chk_name = $conn->query("SHOW COLUMNS FROM `admin` LIKE 'name'");
if ($chk_name && $chk_name->num_rows === 0) {
    $conn->query("ALTER TABLE `admin` ADD `name` VARCHAR(150) DEFAULT 'Administrator' AFTER `perm`");
}

// ─── 2. Categories & Collections ───────────────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `collections` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `image_url` VARCHAR(500) DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `position` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `catgory` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admid` VARCHAR(64) DEFAULT '67ac7cf58dfc4',
  `ctid` VARCHAR(64) NOT NULL UNIQUE,
  `category` VARCHAR(150) NOT NULL,
  `descp` TEXT DEFAULT NULL,
  `ctimg` LONGBLOB DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 2.5 Product Reviews & Social Proof ────────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `product_id` INT NOT NULL,
  `author_name` VARCHAR(150) NOT NULL,
  `author_location` VARCHAR(100) DEFAULT 'Mumbai, India',
  `rating` INT DEFAULT 5,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `fit_feedback` VARCHAR(50) DEFAULT 'True to Size',
  `is_verified_buyer` TINYINT(1) DEFAULT 1,
  `status` ENUM('approved', 'pending', 'hidden') DEFAULT 'approved',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX(`product_id`),
  INDEX(`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 3. Products, Variants & Images ────────────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `collection_id` INT DEFAULT NULL,
  `supplier_id` INT DEFAULT NULL,
  `supplier_sku` VARCHAR(100) DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` LONGTEXT DEFAULT NULL,
  `vendor` VARCHAR(150) DEFAULT 'NovaDrop',
  `product_type` VARCHAR(100) DEFAULT 'Apparel',
  `status` ENUM('draft','active','archived') DEFAULT 'active',
  `base_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `compare_at_price` DECIMAL(10,2) DEFAULT NULL,
  `cost_price` DECIMAL(10,2) DEFAULT 0.00,
  `is_featured` TINYINT(1) DEFAULT 0,
  `views_count` INT DEFAULT 0,
  `sales_count` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$chk_comp = $conn->query("SHOW COLUMNS FROM `products` LIKE 'compare_at_price'");
if ($chk_comp && $chk_comp->num_rows === 0) {
    $conn->query("ALTER TABLE `products` ADD `compare_at_price` DECIMAL(10,2) DEFAULT NULL AFTER `base_price`");
}
$chk_cost = $conn->query("SHOW COLUMNS FROM `products` LIKE 'cost_price'");
if ($chk_cost && $chk_cost->num_rows === 0) {
    $conn->query("ALTER TABLE `products` ADD `cost_price` DECIMAL(10,2) DEFAULT 0.00 AFTER `compare_at_price`");
}

$conn->query("
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `url` VARCHAR(500) NOT NULL,
  `alt_text` VARCHAR(255) DEFAULT '',
  `position` INT DEFAULT 1,
  `is_primary` TINYINT(1) DEFAULT 1,
  INDEX (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Compatibility legacy product tables
$conn->query("
CREATE TABLE IF NOT EXISTS `product` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admid` VARCHAR(64) DEFAULT '67ac7cf58dfc4',
  `pcid` VARCHAR(64) NOT NULL,
  `ccid` VARCHAR(64) NOT NULL UNIQUE,
  `keyword` VARCHAR(255) DEFAULT NULL,
  `category` VARCHAR(64) NOT NULL,
  `pname` VARCHAR(255) NOT NULL,
  `descp` TEXT DEFAULT NULL,
  `color` VARCHAR(100) DEFAULT 'Default',
  `ccode` VARCHAR(50) DEFAULT '#000000',
  `mrp` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `disc` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `date` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `pimage` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admid` VARCHAR(64) DEFAULT '67ac7cf58dfc4',
  `pcid` VARCHAR(64) NOT NULL,
  `ccid` VARCHAR(64) NOT NULL,
  `imid` VARCHAR(64) NOT NULL UNIQUE,
  `category` VARCHAR(64) DEFAULT NULL,
  `iname` VARCHAR(255) DEFAULT NULL,
  `image` LONGBLOB DEFAULT NULL,
  `date` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `size` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admid` VARCHAR(64) DEFAULT '67ac7cf58dfc4',
  `pcid` VARCHAR(64) NOT NULL,
  `ccid` VARCHAR(64) NOT NULL,
  `szid` VARCHAR(64) NOT NULL UNIQUE,
  `size` VARCHAR(50) NOT NULL,
  `qty` INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `description` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admid` VARCHAR(64) DEFAULT '67ac7cf58dfc4',
  `pcid` VARCHAR(64) NOT NULL,
  `despid` VARCHAR(64) NOT NULL UNIQUE,
  `decph` VARCHAR(255) NOT NULL,
  `descp` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 4. Customers & CRM ─────────────────────────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `customers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) DEFAULT NULL,
  `first_name` VARCHAR(100) DEFAULT '',
  `last_name` VARCHAR(100) DEFAULT '',
  `phone` VARCHAR(30) DEFAULT '',
  `is_active` TINYINT(1) DEFAULT 1,
  `discount_percent` DECIMAL(5,2) DEFAULT 0.00,
  `last_login_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Safe add loyalty columns to customers table
$chk_lpts = $conn->query("SHOW COLUMNS FROM `customers` LIKE 'loyalty_points'");
if ($chk_lpts && $chk_lpts->num_rows === 0) {
$conn->query("ALTER TABLE `customers` ADD `loyalty_points` INT DEFAULT 0");
}
$chk_ltier = $conn->query("SHOW COLUMNS FROM `customers` LIKE 'loyalty_tier'");
if ($chk_ltier && $chk_ltier->num_rows === 0) {
$conn->query("ALTER TABLE `customers` ADD `loyalty_tier` VARCHAR(50) DEFAULT 'Silver'");
}

$conn->query("
CREATE TABLE IF NOT EXISTS `loyalty_tiers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tier_code` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(100) NOT NULL,
  `min_spend` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `points_multiplier` DECIMAL(4,2) NOT NULL DEFAULT 1.00,
  `cashback_percent` DECIMAL(5,2) NOT NULL DEFAULT 5.00,
  `perks` TEXT DEFAULT NULL,
  `color_badge` VARCHAR(50) DEFAULT 'secondary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `loyalty_transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `customer_id` INT NOT NULL,
  `points` INT NOT NULL,
  `type` ENUM('credit','debit') DEFAULT 'credit',
  `reason` VARCHAR(255) NOT NULL,
  `order_id` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");$conn->query("
CREATE TABLE IF NOT EXISTS `store_settings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `key` VARCHAR(100) NOT NULL,
  `value` LONGTEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_store_key` (`store_id`, `key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Insert standard VIP tiers
$conn->query("
INSERT IGNORE INTO `loyalty_tiers` (`tier_code`, `name`, `min_spend`, `points_multiplier`, `cashback_percent`, `perks`, `color_badge`) VALUES
('silver', 'Silver Member', 0.00, 1.00, 5.00, '5% Point Cashback, Seasonal Lookbooks', 'secondary'),
('gold', 'Gold Connoisseur', 15000.00, 1.50, 7.50, '1.5x Points Multiplier, 24H Early Access to Drops', 'warning'),
('platinum', 'Platinum Atelier', 50000.00, 2.00, 10.00, '2.0x Points Multiplier, Free Express Shipping, Stylist Consultation', 'primary'),
('diamond', 'Black Diamond VIP', 150000.00, 3.00, 15.00, '3.0x Points Multiplier, Bespoke Atelier Sizing, Dedicated Concierge', 'dark');
");

$conn->query("
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(64) NOT NULL UNIQUE,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `lsdate` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `userdet` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid` VARCHAR(64) NOT NULL UNIQUE,
  `username` VARCHAR(100) NOT NULL,
  `fname` VARCHAR(100) DEFAULT '',
  `lname` VARCHAR(100) DEFAULT '',
  `phone` VARCHAR(30) DEFAULT '',
  `email` VARCHAR(255) NOT NULL,
  `disc` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `addr1` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 5. Orders, Invoices & Payments ─────────────────────────────
$chk_track = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'tracking_number'");
if ($chk_track && $chk_track->num_rows === 0) {
    $conn->query("ALTER TABLE `orders` ADD `tracking_number` VARCHAR(120) DEFAULT NULL AFTER `shipping_address_id`");
}
$chk_paym = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'payment_method'");
if ($chk_paym && $chk_paym->num_rows === 0) {
    $conn->query("ALTER TABLE `orders` ADD `payment_method` VARCHAR(60) DEFAULT 'razorpay' AFTER `currency`");
}
$chk_shipj = $conn->query("SHOW COLUMNS FROM `orders` LIKE 'shipping_address_json'");
if ($chk_shipj && $chk_shipj->num_rows === 0) {
    $conn->query("ALTER TABLE `orders` ADD `shipping_address_json` LONGTEXT DEFAULT NULL AFTER `payment_method`");
}

$conn->query("
CREATE TABLE IF NOT EXISTS `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `store_id` INT DEFAULT 1,
  `gateway` VARCHAR(50) DEFAULT 'razorpay',
  `gateway_payment_id` VARCHAR(120) DEFAULT NULL,
  `gateway_order_id` VARCHAR(120) DEFAULT NULL,
  `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `currency` CHAR(3) DEFAULT 'INR',
  `status` ENUM('created','authorized','captured','failed','refunded') DEFAULT 'captured',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 5.5 Enterprise Warehouses & Purchase Orders ────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(150) NOT NULL,
  `location` VARCHAR(150) NOT NULL,
  `country` VARCHAR(100) DEFAULT 'India',
  `capacity_units` INT DEFAULT 10000,
  `active_stock_units` INT DEFAULT 2400,
  `is_primary` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `po_number` VARCHAR(50) NOT NULL UNIQUE,
  `supplier_name` VARCHAR(150) NOT NULL,
  `total_units` INT NOT NULL,
  `total_cost` DECIMAL(12,2) NOT NULL,
  `status` ENUM('draft','issued','in_transit','received','cancelled') DEFAULT 'issued',
  `tracking_awb` VARCHAR(100) DEFAULT NULL,
  `expected_delivery` DATE DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `ad_campaigns` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `product_id` INT NOT NULL,
  `platform` VARCHAR(50) DEFAULT 'Meta Instagram',
  `angle` VARCHAR(100) DEFAULT 'Luxury Aesthetic',
  `headline` VARCHAR(255) NOT NULL,
  `primary_text` TEXT NOT NULL,
  `target_audience` VARCHAR(255) DEFAULT 'High-Net-Worth Fashion Lovers 22-45',
  `est_roas` DECIMAL(4,2) DEFAULT 4.20,
  `status` ENUM('active','draft','paused') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `currency_rates` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` CHAR(3) NOT NULL UNIQUE,
  `symbol` VARCHAR(10) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `exchange_rate` DECIMAL(10,4) NOT NULL,
  `is_enabled` TINYINT(1) DEFAULT 1,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Insert standard rates if empty
$conn->query("
INSERT IGNORE INTO `currency_rates` (`code`, `symbol`, `name`, `exchange_rate`, `is_enabled`) VALUES
('INR', '₹', 'Indian Rupee', 1.0000, 1),
('USD', '$', 'US Dollar', 0.0120, 1),
('EUR', '€', 'Euro', 0.0110, 1),
('GBP', '£', 'British Pound', 0.0095, 1),
('AED', 'د.إ', 'UAE Dirham', 0.0440, 1),
('CAD', '$', 'Canadian Dollar', 0.0160, 1),
('AUD', '$', 'Australian Dollar', 0.0180, 1);
");

// Insert standard warehouses if empty
$conn->query("
INSERT IGNORE INTO `warehouses` (`code`, `name`, `location`, `country`, `capacity_units`, `active_stock_units`, `is_primary`) VALUES
('WH-BOM-01', 'Mumbai Central White-Glove Depot', 'Bhiwandi Hub, Mumbai', 'India', 15000, 4850, 1),
('WH-SZX-02', 'Shenzhen CJ Air-Dispatch Terminal', 'Baoan District, Shenzhen', 'China', 50000, 18200, 0),
('WH-LON-03', 'London Mayfair European Atelier', 'Westminster, London', 'UK', 8000, 1420, 0);
");

// ─── 6. Background Queue Engine & AI Tasks ──────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `jobs_queue` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT UNSIGNED NOT NULL DEFAULT 1,
  `queue` VARCHAR(50) NOT NULL DEFAULT 'default',
  `job_type` VARCHAR(100) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  `max_attempts` TINYINT UNSIGNED NOT NULL DEFAULT 3,
  `status` ENUM('pending','running','completed','failed') NOT NULL DEFAULT 'pending',
  `available_at` DATETIME NOT NULL,
  `started_at` DATETIME DEFAULT NULL,
  `completed_at` DATETIME DEFAULT NULL,
  `failed_at` DATETIME DEFAULT NULL,
  `error_message` TEXT DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  INDEX (`status`, `available_at`, `store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `ai_agent_tasks` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `agent_type` VARCHAR(50) NOT NULL,
  `task_name` VARCHAR(150) NOT NULL,
  `payload_json` LONGTEXT DEFAULT NULL,
  `status` ENUM('pending','running','completed','failed') DEFAULT 'pending',
  `result_json` LONGTEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 7. Support Tickets & System Audit Trail ─────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tid` VARCHAR(64) NOT NULL UNIQUE,
  `uid` VARCHAR(64) DEFAULT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `status` VARCHAR(30) DEFAULT 'Pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `ucontact` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) DEFAULT '',
  `email` VARCHAR(255) DEFAULT '',
  `subject` VARCHAR(255) DEFAULT '',
  `message` TEXT DEFAULT NULL,
  `date` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 7b. System Audit Trail (auto-create with all columns) ──────
$conn->query("
CREATE TABLE IF NOT EXISTS `audit_log` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT UNSIGNED DEFAULT 1,
  `actor_type` ENUM('admin','system','customer','api','swarm.pricing_sentinel','swarm.seo_sentinel','swarm.social_proof_sentinel','swarm.cart_sentinel','swarm.fulfillment_sentinel','swarm.inventory_sentinel','swarm.loyalty_sentinel','swarm.forex_sentinel','swarm.ad_growth_sentinel') DEFAULT 'admin',
  `actor_id` INT UNSIGNED DEFAULT 1,
  `action` VARCHAR(120) NOT NULL,
  `details` LONGTEXT DEFAULT NULL,
  `entity_type` VARCHAR(60) DEFAULT NULL,
  `entity_id` INT UNSIGNED DEFAULT NULL,
  `meta_json` LONGTEXT DEFAULT NULL,
  `old_values` LONGTEXT DEFAULT NULL,
  `new_values` LONGTEXT DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (`store_id`, `created_at`),
  INDEX (`actor_type`, `action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Safely add any missing columns to existing audit_log tables
$_al_cols = ['details'=>'LONGTEXT DEFAULT NULL AFTER `action`', 'meta_json'=>'LONGTEXT DEFAULT NULL AFTER `entity_id`', 'old_values'=>'LONGTEXT DEFAULT NULL', 'new_values'=>'LONGTEXT DEFAULT NULL'];
foreach ($_al_cols as $_col => $_def) {
    $chk = $conn->query("SHOW COLUMNS FROM `audit_log` LIKE '$_col'");
    if ($chk && $chk->num_rows === 0) {
        $conn->query("ALTER TABLE `audit_log` ADD `$_col` $_def");
    }
}

// ─── 8. Storefront CMS, Announcements & Settings ─────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `text` VARCHAR(500) NOT NULL,
  `link_url` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `pages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `pageid` VARCHAR(64) DEFAULT '',
  `funord` INT DEFAULT 0,
  `position` VARCHAR(50) DEFAULT 'sidebar',
  `pname` VARCHAR(255) DEFAULT '',
  `url` VARCHAR(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `promo` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `prmoid` VARCHAR(64) DEFAULT '',
  `code` VARCHAR(50) DEFAULT '',
  `disc` DECIMAL(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `discount` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admid` VARCHAR(64) DEFAULT '67ac7cf58dfc4',
  `discid` VARCHAR(64) DEFAULT '',
  `disc` DECIMAL(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 9. Seed Default Master Admin Account ───────────────────────
$chk_admin = $conn->query("SELECT id FROM `admin` WHERE `username` = 'admin'");
if ($chk_admin && $chk_admin->num_rows === 0) {
    $def_pass = password_hash('admin123', PASSWORD_DEFAULT);
    $admid = '67ac7cf58dfc4';
    $stmt = $conn->prepare("INSERT INTO `admin` (`admid`, `astat`, `perm`, `name`, `username`, `email`, `password`, `date`, `adate`) VALUES (?, 'madmin', 'admin', 'Master Administrator', 'admin', 'admin@novadrop.in', ?, NOW(), NOW())");
    $stmt->bind_param("ss", $admid, $def_pass);
    $stmt->execute();
} else {
    $def_pass = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("UPDATE `admin` SET `perm` = 'admin', `password` = '$def_pass' WHERE `username` = 'admin'");
}

// ─── 10. Two-Way Data Sync Between Storefront & Legacy Admin ────
// Sync Products
$chk_pr = $conn->query("SELECT * FROM `products`");
if ($chk_pr && $chk_pr->num_rows > 0) {
    while ($p_row = $chk_pr->fetch_assoc()) {
        $p_ccid = 'prod_' . $p_row['id'];
        $p_pcid = 'cat_' . ($p_row['collection_id'] ?? '1');
        $p_name = $conn->real_escape_string($p_row['title']);
        $p_desc = $conn->real_escape_string($p_row['description'] ?? '');
        $p_mrp = (float)$p_row['base_price'];

        $conn->query("INSERT IGNORE INTO `product` (`admid`, `pcid`, `ccid`, `category`, `pname`, `descp`, `mrp`, `disc`) VALUES ('67ac7cf58dfc4', '$p_pcid', '$p_ccid', '$p_pcid', '$p_name', '$p_desc', $p_mrp, 0.00)");
    }
}

// Sync Customers
$chk_cust = $conn->query("SELECT * FROM `customers`");
if ($chk_cust && $chk_cust->num_rows > 0) {
    while ($c_row = $chk_cust->fetch_assoc()) {
        $c_uid = 'cust_' . $c_row['id'];
        $c_email = $c_row['email'];
        $c_uname = explode('@', $c_email)[0];
        $c_fname = $c_row['first_name'] ?? '';
        $c_lname = $c_row['last_name'] ?? '';
        $c_phone = $c_row['phone'] ?? '';
        $c_created = $c_row['created_at'] ?? date('Y-m-d H:i:s');
        $c_pass = $c_row['password_hash'] ?? password_hash('password123', PASSWORD_DEFAULT);

        $conn->query("INSERT IGNORE INTO `user` (`uid`, `username`, `password`, `date`, `lsdate`) VALUES ('$c_uid', '$c_uname', '$c_pass', '$c_created', '$c_created')");
        $conn->query("INSERT IGNORE INTO `userdet` (`uid`, `username`, `fname`, `lname`, `phone`, `email`, `disc`, `addr1`) VALUES ('$c_uid', '$c_uname', '$c_fname', '$c_lname', '$c_phone', '$c_email', 0.00, '')");
    }
}

// ─── 11. Customer Support Tickets & Helpdesk ───────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `tid` VARCHAR(64) DEFAULT NULL,
  `customer_id` INT DEFAULT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) DEFAULT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `priority` VARCHAR(30) DEFAULT 'Normal',
  `intent` VARCHAR(60) DEFAULT 'General',
  `status` VARCHAR(30) DEFAULT 'Open',
  `reply` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$ticket_cols = [
    'tid' => "VARCHAR(64) DEFAULT NULL",
    'customer_id' => "INT DEFAULT NULL",
    'name' => "VARCHAR(150) NOT NULL DEFAULT 'Customer'",
    'email' => "VARCHAR(255) NOT NULL DEFAULT ''",
    'phone' => "VARCHAR(50) DEFAULT NULL",
    'subject' => "VARCHAR(255) NOT NULL DEFAULT 'Inquiry'",
    'message' => "TEXT DEFAULT NULL",
    'priority' => "VARCHAR(30) DEFAULT 'Normal'",
    'intent' => "VARCHAR(60) DEFAULT 'General'",
    'status' => "VARCHAR(30) DEFAULT 'Open'",
    'reply' => "TEXT DEFAULT NULL",
    'created_at' => "DATETIME DEFAULT CURRENT_TIMESTAMP",
    'updated_at' => "DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
];

foreach ($ticket_cols as $c_name => $c_def) {
    $chk_c = $conn->query("SHOW COLUMNS FROM `tickets` LIKE '$c_name'");
    if ($chk_c && $chk_c->num_rows === 0) {
        $conn->query("ALTER TABLE `tickets` ADD `$c_name` $c_def");
    }
}

// Seed default announcement if empty
$chk_ann = $conn->query("SELECT id FROM `announcements` LIMIT 1");
if ($chk_ann && $chk_ann->num_rows === 0) {
    $conn->query("INSERT INTO `announcements` (`text`, `link_url`, `is_active`) VALUES ('⚡ FREE Express Shipping on all Prepaid Orders above ₹999 | Promo: NOVA50', '/shop', 1)");
}

// ─── 12. Automation Observability & Single Log Table ───────────
$conn->query("
CREATE TABLE IF NOT EXISTS `automation_runs` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `job_name` VARCHAR(120) NOT NULL,
  `status` ENUM('running','success','failed') NOT NULL DEFAULT 'running',
  `started_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finished_at` DATETIME DEFAULT NULL,
  `duration_ms` DECIMAL(10,2) DEFAULT 0.00,
  `affected_rows` INT DEFAULT 0,
  `payload_json` JSON DEFAULT NULL,
  `error_message` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ar_job_status (`job_name`, `status`),
  INDEX idx_ar_created (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 13. Sourcing & Winning Product Scoring Engine ─────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `product_winning_scores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `product_id` INT DEFAULT NULL,
  `supplier_product_id` VARCHAR(120) NOT NULL,
  `cost_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `selling_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `gross_margin_pct` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `shipping_days` INT NOT NULL DEFAULT 7,
  `rating` DECIMAL(3,2) NOT NULL DEFAULT 4.50,
  `review_count` INT NOT NULL DEFAULT 0,
  `trend_index` DECIMAL(5,2) NOT NULL DEFAULT 50.00,
  `winning_score` DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  `is_flagged_winner` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_pws_score (`winning_score`),
  INDEX idx_pws_winner (`is_flagged_winner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 14. Immutable Pricing & Margin Audit Log ──────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `pricing_audit_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `product_id` INT NOT NULL,
  `variant_id` INT DEFAULT NULL,
  `old_price` DECIMAL(12,2) NOT NULL,
  `new_price` DECIMAL(12,2) NOT NULL,
  `old_compare_price` DECIMAL(12,2) DEFAULT NULL,
  `new_compare_price` DECIMAL(12,2) DEFAULT NULL,
  `cost_price` DECIMAL(12,2) DEFAULT NULL,
  `margin_pct` DECIMAL(6,2) DEFAULT NULL,
  `reason` VARCHAR(255) NOT NULL,
  `actor_type` VARCHAR(60) NOT NULL DEFAULT 'DynamicPricingAgent',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_pal_prod (`product_id`),
  INDEX idx_pal_created (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 15. Niche Positioning & Brand Story ───────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `store_positioning` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1 UNIQUE,
  `brand_name` VARCHAR(150) NOT NULL DEFAULT 'LUMINA ATELIER',
  `tagline` VARCHAR(255) NOT NULL DEFAULT 'Haute Couture, Archival Cashmere & Tailored Ready-to-Wear',
  `niche_category` VARCHAR(120) NOT NULL DEFAULT 'Luxury Apparel, Mongolian Cashmere & Bespoke Tailoring',
  `founder_story` TEXT DEFAULT NULL,
  `hero_bundle_title` VARCHAR(255) NOT NULL DEFAULT 'The Winter Cashmere & Selvedge Capsule Wardrobe',
  `hero_bundle_discount_pct` DECIMAL(5,2) NOT NULL DEFAULT 25.00,
  `mission_statement` TEXT DEFAULT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Seed default positioning
$conn->query("
INSERT IGNORE INTO `store_positioning` (`store_id`, `brand_name`, `tagline`, `niche_category`, `founder_story`, `hero_bundle_title`, `hero_bundle_discount_pct`, `mission_statement`)
VALUES (1, 'LUMINA ATELIER', 'Haute Couture, Archival Cashmere & Tailored Ready-to-Wear', 'Luxury Apparel, Mongolian Cashmere & Bespoke Tailoring', 
'Conceived as an independent couture house for discerning individuals who appreciate pure Grade-A Mongolian cashmere, Japanese shuttle-loomed selvedge denim, and 22-momme pure Mulberry silk.',
'The Winter Cashmere & Selvedge Capsule Wardrobe (Cocoon Overcoat + Okayama Trousers + Mulberry Silk Dress)', 25.00,
'Curating architectural silhouettes, certified natural textiles, and museum-grade craftsmanship with zero synthetic blends.');
");

// ─── 16. Subscriptions & Recurring LTV Engine ──────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `customer_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `variant_id` INT DEFAULT NULL,
  `plan_interval` ENUM('30_days','60_days','90_days') NOT NULL DEFAULT '30_days',
  `discount_pct` DECIMAL(5,2) NOT NULL DEFAULT 15.00,
  `price_per_cycle` DECIMAL(12,2) NOT NULL,
  `status` ENUM('active','paused','cancelled') NOT NULL DEFAULT 'active',
  `next_charge_at` DATETIME NOT NULL,
  `last_charged_at` DATETIME DEFAULT NULL,
  `gateway_subscription_id` VARCHAR(120) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_sub_customer (`customer_id`),
  INDEX idx_sub_charge (`status`, `next_charge_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 17. Post-Purchase Upsells & One-Click Cross-Sells ───────────
$conn->query("
CREATE TABLE IF NOT EXISTS `upsell_offers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `trigger_product_id` INT DEFAULT NULL,
  `offer_product_id` INT NOT NULL,
  `headline` VARCHAR(255) NOT NULL,
  `discount_pct` DECIMAL(5,2) NOT NULL DEFAULT 30.00,
  `special_price` DECIMAL(12,2) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `impressions_count` INT DEFAULT 0,
  `conversions_count` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 18. India RTO & COD Risk Reduction ────────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `rto_risk_evaluations` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `order_id` INT NOT NULL,
  `cod_amount` DECIMAL(12,2) NOT NULL,
  `rto_risk_score` DECIMAL(4,2) NOT NULL DEFAULT 0.00,
  `risk_tier` ENUM('low','medium','high') NOT NULL DEFAULT 'low',
  `is_confirmed_via_whatsapp` TINYINT(1) NOT NULL DEFAULT 0,
  `confirmation_token` VARCHAR(64) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `confirmed_at` DATETIME DEFAULT NULL,
  INDEX idx_rto_order (`order_id`),
  INDEX idx_rto_token (`confirmation_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 19. First-Party Product Performance Data Moat ─────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `product_performance_metrics` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL UNIQUE,
  `views_count` INT DEFAULT 0,
  `cart_adds_count` INT DEFAULT 0,
  `purchases_count` INT DEFAULT 0,
  `rto_returns_count` INT DEFAULT 0,
  `ctr_pct` DECIMAL(5,2) DEFAULT 0.00,
  `conversion_rate_pct` DECIMAL(5,2) DEFAULT 0.00,
  `gross_margin_yield` DECIMAL(12,2) DEFAULT 0.00,
  `data_moat_score` DECIMAL(6,2) DEFAULT 0.00,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_ppm_moat (`data_moat_score`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 20. Multi-Vendor Marketplace Core (Block A) ───────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `business_name` VARCHAR(191) NOT NULL,
  `contact_name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `phone` VARCHAR(30) NOT NULL,
  `status` ENUM('pending','approved','suspended') DEFAULT 'pending',
  `commission_type` ENUM('percent','flat') DEFAULT 'percent',
  `commission_value` DECIMAL(8,2) DEFAULT 15.00,
  `payout_method` ENUM('bank','upi','paypal') DEFAULT 'bank',
  `payout_details_json` LONGTEXT DEFAULT NULL,
  `gstin` VARCHAR(30) DEFAULT NULL,
  `kyc_status` ENUM('pending','verified','rejected') DEFAULT 'pending',
  `kyc_docs_json` LONGTEXT DEFAULT NULL,
  `rating` DECIMAL(3,2) DEFAULT 5.00,
  `total_orders_fulfilled` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_v_status (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `vendor_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('owner','staff') DEFAULT 'owner',
  `is_active` TINYINT(1) DEFAULT 1,
  `last_login_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_vu_vendor (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `vendor_products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `vendor_sku` VARCHAR(100) DEFAULT NULL,
  `vendor_price` DECIMAL(12,2) NOT NULL,
  `vendor_stock` INT DEFAULT 0,
  `approval_status` ENUM('pending','approved','rejected') DEFAULT 'pending',
  `rejection_reason` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_vp_vendor (`vendor_id`),
  INDEX idx_vp_prod (`product_id`),
  INDEX idx_vp_status (`approval_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `vendor_payouts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `period_start` DATETIME NOT NULL,
  `period_end` DATETIME NOT NULL,
  `gross_sales` DECIMAL(12,2) NOT NULL,
  `commission_amount` DECIMAL(12,2) NOT NULL,
  `net_payable` DECIMAL(12,2) NOT NULL,
  `status` ENUM('pending','processing','paid','failed') DEFAULT 'pending',
  `paid_at` DATETIME DEFAULT NULL,
  `reference` VARCHAR(120) DEFAULT NULL,
  `notes` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_vp_vend_status (`vendor_id`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `vendor_payout_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `payout_id` INT NOT NULL,
  `order_item_id` INT NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL,
  `commission` DECIMAL(12,2) NOT NULL,
  `net_amount` DECIMAL(12,2) NOT NULL,
  INDEX idx_vpi_payout (`payout_id`),
  INDEX idx_vpi_item (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// Alter order_items table to add vendor columns if not present
$oi_cols = $conn->query("SHOW COLUMNS FROM `order_items` LIKE 'vendor_id'")->num_rows;
if ($oi_cols == 0) {
    $conn->query("ALTER TABLE `order_items` ADD COLUMN `vendor_id` INT NULL DEFAULT NULL AFTER `order_id`");
    $conn->query("ALTER TABLE `order_items` ADD COLUMN `vendor_commission_amount` DECIMAL(12,2) DEFAULT 0.00 AFTER `total_price`");
    $conn->query("ALTER TABLE `order_items` ADD COLUMN `vendor_fulfillment_status` ENUM('unfulfilled','processing','shipped','delivered','cancelled') DEFAULT 'unfulfilled' AFTER `vendor_commission_amount`");
    $conn->query("ALTER TABLE `order_items` ADD COLUMN `vendor_carrier` VARCHAR(80) DEFAULT NULL AFTER `vendor_fulfillment_status`");
    $conn->query("ALTER TABLE `order_items` ADD COLUMN `vendor_tracking_number` VARCHAR(120) DEFAULT NULL AFTER `vendor_carrier`");
    $conn->query("ALTER TABLE `order_items` ADD COLUMN `vendor_shipped_at` DATETIME DEFAULT NULL AFTER `vendor_tracking_number`");
    $conn->query("ALTER TABLE `order_items` ADD INDEX `idx_oi_vendor` (`vendor_id`)");
}

$conn->query("
CREATE TABLE IF NOT EXISTS `vendor_order_notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_item_id` INT NOT NULL,
  `order_id` INT NOT NULL,
  `vendor_id` INT NOT NULL,
  `channel` ENUM('email','whatsapp','webhook','dashboard') NOT NULL,
  `payload_json` LONGTEXT DEFAULT NULL,
  `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `acknowledged_at` DATETIME DEFAULT NULL,
  `status` ENUM('pending','sent','acknowledged','escalated') DEFAULT 'sent',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_von_vendor (`vendor_id`),
  INDEX idx_von_order (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 21. Scoped API Keys & Rolling Rate Limiter (Block B) ─────────
$conn->query("
CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `owner_type` ENUM('admin','vendor','app') NOT NULL DEFAULT 'admin',
  `owner_id` INT DEFAULT 1,
  `name` VARCHAR(150) NOT NULL,
  `key_prefix` VARCHAR(16) NOT NULL,
  `key_hash` VARCHAR(64) NOT NULL UNIQUE,
  `scopes_json` LONGTEXT NOT NULL,
  `rate_limit_per_min` INT NOT NULL DEFAULT 60,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_used_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ak_hash (`key_hash`),
  INDEX idx_ak_owner (`owner_type`, `owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `api_request_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `api_key_id` INT NOT NULL,
  `endpoint` VARCHAR(255) NOT NULL,
  `method` VARCHAR(10) NOT NULL,
  `status_code` INT NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `latency_ms` DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_arl_key_time (`api_key_id`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 22. Outbound Webhooks & HMAC Signed Deliveries (Block B) ───
$conn->query("
CREATE TABLE IF NOT EXISTS `webhook_subscriptions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `owner_type` ENUM('admin','vendor','app') NOT NULL DEFAULT 'admin',
  `owner_id` INT DEFAULT 1,
  `event` VARCHAR(80) NOT NULL,
  `target_url` VARCHAR(255) NOT NULL,
  `secret` VARCHAR(64) NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `failure_count` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ws_event (`event`, `is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `webhook_deliveries` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `subscription_id` INT NOT NULL,
  `event` VARCHAR(80) NOT NULL,
  `payload_json` LONGTEXT NOT NULL,
  `response_code` INT DEFAULT NULL,
  `response_body` TEXT DEFAULT NULL,
  `attempt` INT NOT NULL DEFAULT 1,
  `delivered_at` DATETIME DEFAULT NULL,
  `status` ENUM('pending','delivered','failed') NOT NULL DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_wd_sub (`subscription_id`),
  INDEX idx_wd_status (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 23. Retention & Win-Back Identity + Automations (Block D) ───
$conn->query("
CREATE TABLE IF NOT EXISTS `contact_identities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `customer_id` INT DEFAULT NULL,
  `session_id` VARCHAR(120) DEFAULT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `email` VARCHAR(191) DEFAULT NULL,
  `whatsapp_opted_in` TINYINT(1) DEFAULT 1,
  `captured_via` ENUM('checkout','popup','login','order','browse') DEFAULT 'browse',
  `last_active_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ci_phone (`phone`),
  INDEX idx_ci_cust (`customer_id`),
  INDEX idx_ci_sess (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `message_frequency_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `recipient_phone` VARCHAR(30) NOT NULL,
  `recipient_email` VARCHAR(191) DEFAULT NULL,
  `channel` ENUM('whatsapp','sms','email') NOT NULL DEFAULT 'whatsapp',
  `automation_type` VARCHAR(80) NOT NULL,
  `template_key` VARCHAR(80) NOT NULL,
  `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_mfl_phone_time (`recipient_phone`, `sent_at`),
  INDEX idx_mfl_type (`automation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `browse_abandonment_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `contact_identity_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `viewed_count` INT NOT NULL DEFAULT 1,
  `viewed_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `followup_step` INT NOT NULL DEFAULT 1,
  `sent_at` DATETIME DEFAULT NULL,
  `status` ENUM('pending','sent','converted','opt_out') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_bal_status (`status`, `viewed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `winback_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `days_inactive` INT NOT NULL,
  `offer_code` VARCHAR(50) NOT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `status` ENUM('pending','sent','recovered','ignored') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_wbl_cust (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `replenishment_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `last_order_date` DATETIME NOT NULL,
  `expected_depletion_date` DATETIME NOT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `status` ENUM('pending','sent','reordered','ignored') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_rpl_status (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `price_drop_alert_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `wishlist_price` DECIMAL(12,2) NOT NULL,
  `drop_price` DECIMAL(12,2) NOT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `status` ENUM('pending','sent','purchased') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_pda_cust (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `back_in_stock_log` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `restocked_qty` INT NOT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `status` ENUM('pending','sent','purchased') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_bis_prod (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 24. 50+ Core Commerce Extensions (Block C) ───────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `product_bundles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `bundle_product_id` INT NOT NULL,
  `discount_percentage` DECIMAL(5,2) DEFAULT 15.00,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_pb_prod (`bundle_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `product_bundle_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `bundle_id` INT NOT NULL,
  `component_product_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  INDEX idx_pbi_bundle (`bundle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `gift_cards` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(60) NOT NULL UNIQUE,
  `initial_balance` DECIMAL(12,2) NOT NULL,
  `current_balance` DECIMAL(12,2) NOT NULL,
  `currency` VARCHAR(10) DEFAULT 'INR',
  `customer_id` INT DEFAULT NULL,
  `expires_at` DATETIME DEFAULT NULL,
  `status` ENUM('active','redeemed','expired','disabled') DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_gc_code (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `loyalty_points` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL UNIQUE,
  `points_balance` INT NOT NULL DEFAULT 0,
  `lifetime_earned` INT NOT NULL DEFAULT 0,
  `lifetime_spent` INT NOT NULL DEFAULT 0,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_lp_cust (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT DEFAULT NULL,
  `order_id` INT DEFAULT NULL,
  `customer_name` VARCHAR(150) DEFAULT '',
  `customer_email` VARCHAR(150) DEFAULT '',
  `rating` INT DEFAULT 5,
  `title` VARCHAR(255) DEFAULT '',
  `review_text` TEXT DEFAULT NULL,
  `is_approved` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_rev_order (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$chk_rev = $conn->query("SHOW COLUMNS FROM `reviews` LIKE 'order_id'");
if ($chk_rev && $chk_rev->num_rows === 0) {
    $conn->query("ALTER TABLE `reviews` ADD `order_id` INT DEFAULT NULL AFTER `product_id`");
}

$conn->query("
CREATE TABLE IF NOT EXISTS `customer_addresses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `customer_id` INT NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `address_line1` VARCHAR(255) NOT NULL,
  `address_line2` VARCHAR(255) DEFAULT NULL,
  `city` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100) NOT NULL,
  `postal_code` VARCHAR(20) NOT NULL,
  `country` VARCHAR(50) DEFAULT 'India',
  `is_default` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ca_cust (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `return_requests` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `order_item_id` INT NOT NULL,
  `customer_id` INT NOT NULL,
  `reason` VARCHAR(255) NOT NULL,
  `status` ENUM('requested','approved','rejected','received','refunded') DEFAULT 'requested',
  `refund_amount` DECIMAL(12,2) DEFAULT 0.00,
  `admin_notes` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_rr_order (`order_id`),
  INDEX idx_rr_cust (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 25. Email Marketing Automation (Block E1) ────────────────────
$conn->query("
CREATE TABLE IF NOT EXISTS `email_lists` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `name` VARCHAR(150) NOT NULL,
  `type` ENUM('all_customers','segment','manual') DEFAULT 'all_customers',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `email_segments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `name` VARCHAR(150) NOT NULL,
  `rule_json` LONGTEXT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `email_campaigns` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `name` VARCHAR(150) NOT NULL,
  `segment_id` INT DEFAULT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `body_html` LONGTEXT NOT NULL,
  `status` ENUM('draft','scheduled','sending','sent') DEFAULT 'draft',
  `scheduled_at` DATETIME DEFAULT NULL,
  `sent_count` INT DEFAULT 0,
  `open_count` INT DEFAULT 0,
  `click_count` INT DEFAULT 0,
  `revenue_attributed` DECIMAL(12,2) DEFAULT 0.00,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ec_status (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `email_subscribers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `customer_id` INT DEFAULT NULL,
  `email` VARCHAR(191) NOT NULL UNIQUE,
  `subscribed` TINYINT(1) DEFAULT 1,
  `source` ENUM('signup','checkout','popup','manual') DEFAULT 'signup',
  `unsubscribed_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_es_email (`email`),
  INDEX idx_es_status (`subscribed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 26. AI Autonomous Decision Orchestrator (Block E2) ───────────
$conn->query("
CREATE TABLE IF NOT EXISTS `ai_orchestrator_runs` (
  `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
  `run_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `decisions_json` LONGTEXT NOT NULL,
  `actions_taken_json` LONGTEXT NOT NULL,
  `status` ENUM('completed','partial','failed') DEFAULT 'completed',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS `ai_orchestrator_config` (
  `setting_key` VARCHAR(80) PRIMARY KEY,
  `setting_value` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

// ─── 27. Storefront Homepage Round Category Strip & Features (Block F) ───
try {
    $conn->query("ALTER TABLE `collections` ADD COLUMN `show_on_homepage` TINYINT(1) DEFAULT 1 AFTER `image_url`;");
} catch (Throwable $e) {}
try {
    $conn->query("ALTER TABLE `collections` ADD COLUMN `homepage_position` INT DEFAULT 0 AFTER `show_on_homepage`;");
} catch (Throwable $e) {}
try {
    $conn->query("ALTER TABLE `collections` ADD COLUMN `icon_style` ENUM('photo','illustration') DEFAULT 'photo' AFTER `homepage_position`;");
} catch (Throwable $e) {}

// Seed default collections if empty with rich imagery
$conn->query("
INSERT IGNORE INTO `collections` (`id`, `store_id`, `title`, `slug`, `description`, `image_url`, `show_on_homepage`, `homepage_position`, `is_active`) VALUES
(1, 1, 'Ergonomic Desks', 'ergonomic-desks', 'Precision height-adjustable standing desks.', 'https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?w=400&q=80', 1, 1, 1),
(2, 1, 'Pro Audio & ANC', 'pro-audio-anc', 'Active noise cancelling wireless headphones.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80', 1, 2, 1),
(3, 1, 'Workstation Lights', 'workstation-lights', 'Monitor light bars and ambient LED lighting.', 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400&q=80', 1, 3, 1),
(4, 1, 'Keyboards & Mice', 'keyboards-mice', 'Mechanical split wireless productivity keyboards.', 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&q=80', 1, 4, 1),
(5, 1, 'Desk Accessories', 'desk-accessories', 'Leather desk mats, cable organizers and risers.', 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=400&q=80', 1, 5, 1),
(6, 1, 'Power & Cables', 'power-cables', 'Fast GaN chargers and magnetic braided cables.', 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?w=400&q=80', 1, 6, 1);
");








