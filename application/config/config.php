<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| NovaDrop — CI3 Application Config
|--------------------------------------------------------------------------
*/

// 1. Load Master Root config.php
if (file_exists(FCPATH . 'config.php')) {
    require_once FCPATH . 'config.php';
}

// 2. Load .env fallback if present
if (file_exists(FCPATH . '.env') && !function_exists('env')) {
    foreach (file(FCPATH . '.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        [$k, $v] = explode('=', $line, 2);
        $k = trim($k); $v = trim($v);
        if (!isset($_ENV[$k])) { putenv("$k=$v"); $_ENV[$k] = $v; $_SERVER[$k] = $v; }
    }
}

function _env_val(string $key, mixed $default = null): mixed {
    if (defined($key) && constant($key) !== '') return constant($key);
    $val = $_ENV[$key] ?? getenv($key);
    return ($val === false || $val === '') ? $default : $val;
}

if (!function_exists('_env')) {
    function _env(string $key, mixed $default = null): mixed {
        return _env_val($key, $default);
    }
}

// Dynamic Auto Base URL Detection (works on localhost, InfinityFree, and any custom domain!)
$http_host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_https  = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
$protocol  = $is_https ? 'https://' : 'http://';
$script_dir = str_replace(basename($_SERVER['SCRIPT_NAME'] ?? ''), '', $_SERVER['SCRIPT_NAME'] ?? '/');
$auto_base = $protocol . $http_host . rtrim($script_dir, '/') . '/';

$config['base_url'] = rtrim(_env_val('APP_URL', $auto_base), '/') . '/';
$config['index_page'] = '';
$config['uri_protocol'] = 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language'] = 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['log_threshold'] = _env('APP_ENV', 'production') === 'development' ? 4 : 1;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['encryption_key'] = _env('APP_KEY', 'CHANGE_ME_32_CHAR_RANDOM_STRING__');
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = _env('SESSION_COOKIE_NAME', 'novadrop_session');
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = 'ci_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix'] = 'nd_';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = TRUE;
$config['cookie_samesite'] = 'Lax';
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = _env('CSRF_TOKEN_NAME', 'csrf_novadrop');
$config['csrf_cookie_name'] = 'nd_csrf';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = FALSE;
$config['csrf_exclude_uris'] = [
    'payments/webhook/razorpay',
    'payments/webhook/stripe',
    'shipping/webhook/shiprocket',
    'cart/add',
    'cart/remove',
    'cart/update',
    'cart/items',
    'cart/apply_discount',
];
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';

// NovaDrop custom config
$config['store_id'] = (int)_env('STORE_ID', 1);
$config['store_currency'] = 'INR';
$config['store_currency_symbol'] = '₹';
$config['meilisearch_host'] = _env('MEILISEARCH_HOST', 'http://127.0.0.1:7700');
$config['meilisearch_key'] = _env('MEILISEARCH_KEY', '');
$config['gemini_api_key'] = _env('GEMINI_API_KEY', '');
$config['modules_locations'] = [
    APPPATH . 'modules/' => '../modules/',
];
