<?php
/**
 * ====================================================================
 *  NovaDrop Commerce OS — Master Configuration Shim
 *  Reads all environment variables from .env as the Single Source of Truth.
 * ====================================================================
 */

// Bootstrap .env
$env_path = __DIR__ . '/.env';
if (file_exists($env_path)) {
    foreach (file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k);
        $v = trim($v, " \t\n\r\0\x0B\"'");
        if (!isset($_ENV[$k])) {
            putenv("$k=$v");
            $_ENV[$k] = $v;
            $_SERVER[$k] = $v;
        }
    }
}

// ─── Canonical Constants (derived from .env) ────────────────────────
if (!defined('DB_HOST')) define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
if (!defined('DB_PORT')) define('DB_PORT', (int)(getenv('DB_PORT') ?: 3306));
if (!defined('DB_NAME')) define('DB_NAME', getenv('DB_NAME') ?: 'novadrop');
if (!defined('DB_USER')) define('DB_USER', getenv('DB_USER') ?: 'root');
if (!defined('DB_PASS')) define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

if (!defined('APP_NAME')) define('APP_NAME', getenv('APP_NAME') ?: 'NovaDrop');
if (!defined('APP_URL'))  define('APP_URL', getenv('APP_URL') ?: '');
if (!defined('APP_ENV'))  define('APP_ENV', getenv('APP_ENV') ?: 'development');

if (!defined('STORE_NAME')) define('STORE_NAME', getenv('APP_NAME') ?: 'NovaDrop');
if (!defined('STORE_CURRENCY')) define('STORE_CURRENCY', getenv('STORE_CURRENCY') ?: 'INR');
if (!defined('STORE_CURRENCY_SYMBOL')) define('STORE_CURRENCY_SYMBOL', getenv('STORE_CURRENCY_SYMBOL') ?: '₹');

// Payment Gateway Constants
if (!defined('RAZORPAY_KEY_ID')) define('RAZORPAY_KEY_ID', getenv('RAZORPAY_KEY_ID') ?: '');
if (!defined('RAZORPAY_KEY_SECRET')) define('RAZORPAY_KEY_SECRET', getenv('RAZORPAY_KEY_SECRET') ?: '');
if (!defined('STRIPE_PUBLIC_KEY')) define('STRIPE_PUBLIC_KEY', getenv('STRIPE_PUBLIC_KEY') ?: '');
if (!defined('STRIPE_SECRET_KEY')) define('STRIPE_SECRET_KEY', getenv('STRIPE_SECRET_KEY') ?: '');
