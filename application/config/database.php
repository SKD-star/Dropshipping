<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| NovaDrop / Lumina — Unified Database Config
| Reads directly from the master /config.php file!
|--------------------------------------------------------------------------
*/

// 1. Load Master Root config.php if present
if (file_exists(FCPATH . 'config.php')) {
    require_once FCPATH . 'config.php';
}

// 2. Load .env fallback if present
if (file_exists(FCPATH . '.env')) {
    foreach (file(FCPATH . '.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k); $v = trim($v);
        if (!isset($_ENV[$k])) { putenv("$k=$v"); $_ENV[$k] = $v; $_SERVER[$k] = $v; }
    }
}

function _db_val(string $key, string $default = ''): string {
    if (defined($key)) return (string)constant($key);
    $val = $_ENV[$key] ?? getenv($key);
    return ($val === false || $val === '') ? $default : (string)$val;
}

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = [
    'dsn'          => '',
    'hostname'     => _db_val('DB_HOST', '127.0.0.1'),
    'port'         => _db_val('DB_PORT', '3306'),
    'username'     => _db_val('DB_USER', 'root'),
    'password'     => _db_val('DB_PASS', ''),
    'database'     => _db_val('DB_NAME', 'novadrop'),
    'dbdriver'     => 'mysqli',
    'dbprefix'     => '',
    'pconnect'     => FALSE,
    'db_debug'     => (bool)(_db_val('APP_ENV', 'production') === 'development'),
    'cache_on'     => FALSE,
    'cachedir'     => '',
    'char_set'     => 'utf8mb4',
    'dbcollat'     => 'utf8mb4_unicode_ci',
    'swap_pre'     => '',
    'encrypt'      => FALSE,
    'compress'     => FALSE,
    'stricton'     => FALSE,
    'failover'     => [],
    'save_queries' => FALSE,
];
