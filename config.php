<?php
/**
 * ====================================================================
 *  LUMINA COMMERCE OS — SINGLE MASTER CONFIGURATION FILE
 *  Change your database and website settings ONLY in this ONE file!
 * ====================================================================
 */

// ─── 1. DATABASE SETTINGS ───────────────────────────────────────────
// Change these 5 lines for InfinityFree, Hostinger, or Localhost:
define('DB_HOST', '127.0.0.1');              // MySQL Host (e.g. 'sql300.infinityfree.com' or '127.0.0.1')
define('DB_PORT', 3306);                     // MySQL Port (Default: 3306)
define('DB_NAME', 'novadrop');               // Database Name (e.g. 'if0_38123456_novadrop')
define('DB_USER', 'root');                   // Database Username (e.g. 'if0_38123456')
define('DB_PASS', '');                       // Database Password

// ─── 2. WEBSITE URL (AUTO-DETECTED) ─────────────────────────────────
// Leave empty '' to automatically detect localhost, InfinityFree, or any live domain!
define('APP_URL', '');

// ─── 3. STORE DETAILS ───────────────────────────────────────────────
define('STORE_NAME', 'Lumina Atelier');
define('STORE_CURRENCY', 'INR');             // 'INR', 'USD', 'EUR', 'GBP', 'AED', 'CAD'
define('STORE_CURRENCY_SYMBOL', '₹');

// ─── 4. PAYMENT GATEWAY KEYS (Optional) ─────────────────────────────
define('RAZORPAY_KEY_ID', 'rzp_test_XXXXXXXXXX');
define('RAZORPAY_KEY_SECRET', 'your_secret_here');
define('STRIPE_PUBLIC_KEY', 'pk_test_XXXXXXXXXX');
define('STRIPE_SECRET_KEY', 'sk_test_XXXXXXXXXX');

// ─── 5. ENVIRONMENT MODE ────────────────────────────────────────────
define('APP_ENV', 'development');            // 'development' or 'production'
