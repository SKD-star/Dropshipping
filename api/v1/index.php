<?php
/**
 * NovaDrop Public REST API V1 — Shopify-Style Extensible Integration Platform
 * Version: 1.0.0
 * Authentication: Authorization: Bearer nova_sk_live_...
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=UTF-8');
    header('X-API-Version: 1.0.0');
}

$start_time = microtime(true);
$ip_address = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

require_once __DIR__ . '/../../db.php';
require_once __DIR__ . '/../../application/core/services/ApiKeyService.php';
require_once __DIR__ . '/../../application/core/agents/VendorMarketplaceAgent.php';
require_once __DIR__ . '/../../application/jobs/WebhookDeliveryJob.php';

use App\Services\ApiKeyService;
use App\Agents\VendorMarketplaceAgent;
use App\Jobs\WebhookDeliveryJob;

$pdo_api = new PDO(
    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST') ?: '127.0.0.1', getenv('DB_PORT') ?: '3306', getenv('DB_NAME') ?: 'novadrop'),
    getenv('DB_USER') ?: 'root',
    getenv('DB_PASS') ?: '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

$api_key_service = new ApiKeyService($pdo_api, 1);

// If included as library in CLI test, only export helper functions
if (defined('CLI_TEST_MODE')) {
    return;
}

// Parse Route & Method
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($uri, PHP_URL_PATH);

// Normalize path relative to /api/v1
$base_segment = '/api/v1';
$route = '';
$pos = strpos($path, $base_segment);
if ($pos !== false) {
    $route = substr($path, $pos + strlen($base_segment));
}
$route = trim($route, '/');
$segments = explode('/', $route);
$resource = $segments[0] ?? '';
$resource_id = $segments[1] ?? null;
$sub_action = $segments[2] ?? null;

// Read JSON Body Input
$raw_input = file_get_contents('php://input');
$body = json_decode($raw_input, true) ?: [];

// ─── 1. PUBLIC OPENAPI SPEC & DOCS (NO AUTH REQUIRED) ───────────
if ($resource === 'openapi.json') {
    echo json_encode(get_openapi_spec(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($resource === 'docs') {
    if (!headers_sent()) {
        header('Content-Type: text/html; charset=UTF-8');
    }
    echo render_swagger_ui();
    exit;
}

// ─── 2. AUTHENTICATION & RATE LIMITING MIDDLEWARE ───────────────
$auth_header = $_SERVER['HTTP_AUTHORIZATION'] ?? ($_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null);
if (!$auth_header && function_exists('apache_request_headers')) {
    $headers = apache_request_headers();
    $auth_header = $headers['Authorization'] ?? ($headers['authorization'] ?? null);
}

$key_data = $api_key_service->authenticate_token($auth_header);

if (!$key_data) {
    http_response_code(401);
    echo json_encode([
        'error'   => 'Unauthorized',
        'message' => 'Missing or invalid API Bearer token. Please supply Authorization: Bearer nova_sk_live_... header.',
        'docs'    => '/api/v1/docs',
    ]);
    exit;
}

// Check Rate Limiting (429)
$api_key_id = (int)$key_data['id'];
$rate_limit = (int)$key_data['rate_limit_per_min'];

if (!$api_key_service->check_rate_limit($api_key_id, $rate_limit)) {
    http_response_code(429);
    $latency = round((microtime(true) - $start_time) * 1000, 2);
    $api_key_service->log_request($api_key_id, $route, $method, 429, $ip_address, $latency);
    echo json_encode([
        'error'       => 'Too Many Requests',
        'message'     => "Rate limit of {$rate_limit} requests/minute exceeded for API key '{$key_data['name']}'.",
        'retry_after' => 60,
    ]);
    exit;
}

// ─── 3. ROUTE DISPATCHER ────────────────────────────────────────
$status_code = 200;
$response = [];

try {
    switch ($resource) {
        // ─── PRODUCTS RESOURCE ──────────────────────────────────────
        case 'products':
            if ($method === 'GET' && !$resource_id) {
                // List Products
                require_scope($key_data, 'products:read');
                $limit = min(100, max(1, (int)($_GET['limit'] ?? 20)));
                $page = max(1, (int)($_GET['page'] ?? 1));
                $offset = ($page - 1) * $limit;

                $stmt = $pdo_api->prepare("SELECT id, title, slug, base_price, compare_at_price, status, created_at FROM products WHERE store_id = 1 ORDER BY id DESC LIMIT ? OFFSET ?");
                $stmt->bindValue(1, $limit, PDO::PARAM_INT);
                $stmt->bindValue(2, $offset, PDO::PARAM_INT);
                $stmt->execute();
                $prods = $stmt->fetchAll();

                $total = (int)$pdo_api->query("SELECT COUNT(*) FROM products WHERE store_id = 1")->fetchColumn();
                $response = ['data' => $prods, 'pagination' => ['total' => $total, 'page' => $page, 'limit' => $limit]];
            } elseif ($method === 'GET' && $resource_id) {
                // Get Single Product
                require_scope($key_data, 'products:read');
                $stmt = $pdo_api->prepare("SELECT * FROM products WHERE id = ? AND store_id = 1");
                $stmt->execute([(int)$resource_id]);
                $prod = $stmt->fetch();
                if (!$prod) { $status_code = 404; $response = ['error' => 'Product not found']; break; }

                $stmt_v = $pdo_api->prepare("SELECT * FROM product_variants WHERE product_id = ?");
                $stmt_v->execute([(int)$resource_id]);
                $prod['variants'] = $stmt_v->fetchAll();

                $response = ['data' => $prod];
            } elseif ($method === 'POST') {
                // Create Product
                require_scope($key_data, 'products:write');
                $title = trim($body['title'] ?? '');
                $price = (float)($body['base_price'] ?? 0);
                if (!$title || $price <= 0) { $status_code = 400; $response = ['error' => 'Missing title or base_price']; break; }

                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title)) . '-' . rand(100, 999);
                $stmt = $pdo_api->prepare("INSERT INTO products (store_id, title, slug, base_price, status, created_at) VALUES (1, ?, ?, ?, 'active', NOW())");
                $stmt->execute([$title, $slug, $price]);
                $new_pid = (int)$pdo_api->lastInsertId();

                $status_code = 201;
                $response = ['success' => true, 'product_id' => $new_pid, 'title' => $title, 'slug' => $slug, 'base_price' => $price];
            } elseif ($method === 'DELETE' && $resource_id) {
                // Delete Product
                require_scope($key_data, 'products:write');
                $pdo_api->prepare("UPDATE products SET status = 'archived' WHERE id = ? AND store_id = 1")->execute([(int)$resource_id]);
                $response = ['success' => true, 'message' => "Product #$resource_id archived"];
            } else {
                $status_code = 405; $response = ['error' => 'Method Not Allowed'];
            }
            break;

        // ─── INVENTORY RESOURCE ─────────────────────────────────────
        case 'inventory':
            if ($method === 'GET') {
                require_scope($key_data, 'inventory:read');
                $stmt = $pdo_api->query("
                    SELECT pv.id AS variant_id, pv.sku, pv.title AS variant_title, pv.inventory_qty, p.title AS product_title 
                    FROM product_variants pv JOIN products p ON p.id = pv.product_id 
                    WHERE p.store_id = 1 LIMIT 100
                ");
                $response = ['data' => $stmt->fetchAll()];
            } elseif ($method === 'POST') {
                require_scope($key_data, 'inventory:write');
                $variant_id = (int)($body['variant_id'] ?? 0);
                $qty = (int)($body['inventory_qty'] ?? 0);
                if (!$variant_id) { $status_code = 400; $response = ['error' => 'Missing variant_id']; break; }

                $pdo_api->prepare("UPDATE product_variants SET inventory_qty = ?, updated_at = NOW() WHERE id = ?")->execute([$qty, $variant_id]);
                $response = ['success' => true, 'variant_id' => $variant_id, 'inventory_qty' => $qty];
            } else {
                $status_code = 405; $response = ['error' => 'Method Not Allowed'];
            }
            break;

        // ─── ORDERS RESOURCE ────────────────────────────────────────
        case 'orders':
            if ($method === 'GET' && !$resource_id) {
                require_scope($key_data, 'orders:read');
                $vendor_filter = isset($_GET['vendor_id']) ? (int)$_GET['vendor_id'] : null;

                $sql = "SELECT id, order_number, guest_email, status, payment_status, fulfillment_status, total, currency, created_at FROM orders WHERE store_id = 1";
                $params = [];

                if ($vendor_filter) {
                    $sql .= " AND EXISTS (SELECT 1 FROM order_items oi WHERE oi.order_id = orders.id AND oi.vendor_id = ?)";
                    $params[] = $vendor_filter;
                }
                $sql .= " ORDER BY id DESC LIMIT 50";

                $stmt = $pdo_api->prepare($sql);
                $stmt->execute($params);
                $orders = $stmt->fetchAll();
                $response = ['data' => $orders];
            } elseif ($method === 'GET' && $resource_id) {
                require_scope($key_data, 'orders:read');
                $stmt = $pdo_api->prepare("SELECT * FROM orders WHERE id = ? AND store_id = 1");
                $stmt->execute([(int)$resource_id]);
                $order = $stmt->fetch();
                if (!$order) { $status_code = 404; $response = ['error' => 'Order not found']; break; }

                $stmt_it = $pdo_api->prepare("SELECT * FROM order_items WHERE order_id = ?");
                $stmt_it->execute([(int)$resource_id]);
                $order['items'] = $stmt_it->fetchAll();

                $stmt_sh = $pdo_api->prepare("SELECT * FROM shipments WHERE order_id = ?");
                $stmt_sh->execute([(int)$resource_id]);
                $order['shipments'] = $stmt_sh->fetchAll();

                $response = ['data' => $order];
            } elseif ($method === 'POST' && $resource_id && $sub_action === 'fulfill') {
                // Fulfill Order Action
                require_scope($key_data, 'orders:write');
                $carrier = trim($body['carrier'] ?? 'BlueDart Express');
                $tracking = trim($body['tracking_number'] ?? ('AWB-' . rand(100000, 999999)));
                $vendor_id = (int)($body['vendor_id'] ?? 0);

                if ($vendor_id > 0) {
                    $v_agent = new VendorMarketplaceAgent($pdo_api, 1);
                    $f_res = $v_agent->vendor_mark_shipped($vendor_id, (int)$resource_id, $carrier, $tracking);
                    $response = $f_res;
                } else {
                    $pdo_api->prepare("UPDATE orders SET status = 'shipped', fulfillment_status = 'fulfilled', tracking_number = ?, updated_at = NOW() WHERE id = ?")->execute([$tracking, (int)$resource_id]);
                    $response = ['success' => true, 'order_id' => (int)$resource_id, 'fulfillment_status' => 'fulfilled', 'carrier' => $carrier, 'tracking_number' => $tracking];
                }
            } else {
                $status_code = 405; $response = ['error' => 'Method Not Allowed'];
            }
            break;

        // ─── CUSTOMERS RESOURCE ─────────────────────────────────────
        case 'customers':
            require_scope($key_data, 'customers:read');
            $stmt = $pdo_api->query("SELECT id, name, email, phone, total_spent, orders_count, created_at FROM customers WHERE store_id = 1 ORDER BY id DESC LIMIT 50");
            $response = ['data' => $stmt->fetchAll()];
            break;

        // ─── VENDORS RESOURCE ───────────────────────────────────────
        case 'vendors':
            if ($method === 'GET') {
                require_scope($key_data, 'vendors:read');
                $stmt = $pdo_api->query("SELECT id, business_name, contact_name, email, phone, status, commission_value, rating, total_orders_fulfilled, created_at FROM vendors WHERE store_id = 1 ORDER BY id DESC");
                $response = ['data' => $stmt->fetchAll()];
            } elseif ($method === 'POST') {
                require_scope($key_data, 'vendors:write');
                $b_name = trim($body['business_name'] ?? '');
                $c_name = trim($body['contact_name'] ?? '');
                $email = trim($body['email'] ?? '');
                $phone = trim($body['phone'] ?? '');

                if (!$b_name || !$email) { $status_code = 400; $response = ['error' => 'Missing business_name or email']; break; }

                $stmt = $pdo_api->prepare("INSERT INTO vendors (store_id, business_name, contact_name, email, phone, status, created_at) VALUES (1, ?, ?, ?, ?, 'approved', NOW())");
                $stmt->execute([$b_name, $c_name, $email, $phone]);
                $status_code = 201;
                $response = ['success' => true, 'vendor_id' => (int)$pdo_api->lastInsertId(), 'business_name' => $b_name];
            } else {
                $status_code = 405; $response = ['error' => 'Method Not Allowed'];
            }
            break;

        // ─── WEBHOOKS SUBSCRIPTIONS RESOURCE ────────────────────────
        case 'webhooks':
            if ($method === 'GET') {
                require_scope($key_data, 'webhooks:manage');
                $stmt = $pdo_api->query("SELECT id, event, target_url, is_active, failure_count, created_at FROM webhook_subscriptions WHERE store_id = 1 ORDER BY id DESC");
                $response = ['data' => $stmt->fetchAll()];
            } elseif ($method === 'POST') {
                require_scope($key_data, 'webhooks:manage');
                $event = trim($body['event'] ?? '');
                $target_url = trim($body['target_url'] ?? '');
                if (!$event || !$target_url) { $status_code = 400; $response = ['error' => 'Missing event or target_url']; break; }

                $secret = bin2hex(random_bytes(16));
                $stmt = $pdo_api->prepare("INSERT INTO webhook_subscriptions (store_id, owner_type, owner_id, event, target_url, secret, is_active, created_at) VALUES (1, 'admin', 1, ?, ?, ?, 1, NOW())");
                $stmt->execute([$event, $target_url, $secret]);
                $status_code = 201;
                $response = ['success' => true, 'subscription_id' => (int)$pdo_api->lastInsertId(), 'event' => $event, 'target_url' => $target_url, 'secret' => $secret];
            } elseif ($method === 'DELETE' && $resource_id) {
                require_scope($key_data, 'webhooks:manage');
                $pdo_api->prepare("DELETE FROM webhook_subscriptions WHERE id = ? AND store_id = 1")->execute([(int)$resource_id]);
                $response = ['success' => true, 'message' => "Webhook subscription #$resource_id deleted"];
            } else {
                $status_code = 405; $response = ['error' => 'Method Not Allowed'];
            }
            break;

        default:
            $status_code = 404;
            $response = ['error' => 'Endpoint Not Found', 'available_endpoints' => ['/api/v1/products', '/api/v1/inventory', '/api/v1/orders', '/api/v1/customers', '/api/v1/vendors', '/api/v1/webhooks', '/api/v1/openapi.json']];
            break;
    }
} catch (\Exception $e) {
    if ($e->getMessage() === 'SCOPE_DENIED') {
        $status_code = 403;
        $response = ['error' => 'Forbidden', 'message' => 'Your API key does not have the required permission scope for this endpoint.'];
    } else {
        $status_code = 500;
        $response = ['error' => 'Internal Server Error', 'message' => $e->getMessage()];
    }
}

// ─── 4. LOG & EMIT RESPONSE ─────────────────────────────────────
$latency = round((microtime(true) - $start_time) * 1000, 2);
$api_key_service->log_request($api_key_id, $route, $method, $status_code, $ip_address, $latency);

http_response_code($status_code);
if (!headers_sent()) {
    header('X-Response-Time-Ms: ' . $latency);
}
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;

// ─── HELPER FUNCTIONS ───────────────────────────────────────────
function require_scope(array $key_data, string $scope): void
{
    $scopes = $key_data['scopes'] ?? [];
    if (!in_array('*', $scopes) && !in_array('admin:all', $scopes) && !in_array($scope, $scopes)) {
        throw new \Exception('SCOPE_DENIED');
    }
}

function get_openapi_spec(): array
{
    return [
        'openapi' => '3.0.3',
        'info'    => [
            'title'       => 'NovaDrop Commerce OS Public REST API',
            'version'     => '1.0.0',
            'description' => 'Enterprise REST API and Webhook integration platform for NovaDrop Multi-Vendor & Dropshipping Commerce.',
        ],
        'servers' => [
            ['url' => '/api/v1', 'description' => 'Production API Endpoint']
        ],
        'components' => [
            'securitySchemes' => [
                'BearerAuth' => [
                    'type'         => 'http',
                    'scheme'       => 'bearer',
                    'bearerFormat' => 'nova_sk_live_...',
                    'description'  => 'API Key generated from NovaDrop Admin -> Developers -> API Keys'
                ]
            ]
        ],
        'security' => [['BearerAuth' => []]],
        'paths'    => [
            '/products' => [
                'get'  => ['summary' => 'List products with pagination', 'tags' => ['Products']],
                'post' => ['summary' => 'Create new storefront product', 'tags' => ['Products']]
            ],
            '/products/{id}' => [
                'get'    => ['summary' => 'Get product details & variants', 'tags' => ['Products']],
                'delete' => ['summary' => 'Archive product', 'tags' => ['Products']]
            ],
            '/inventory' => [
                'get'  => ['summary' => 'Get variant stock levels', 'tags' => ['Inventory']],
                'post' => ['summary' => 'Update stock quantity', 'tags' => ['Inventory']]
            ],
            '/orders' => [
                'get' => ['summary' => 'List orders with vendor filters', 'tags' => ['Orders']]
            ],
            '/orders/{id}/fulfill' => [
                'post' => ['summary' => 'Fulfill order with carrier & tracking AWB', 'tags' => ['Orders']]
            ],
            '/vendors' => [
                'get'  => ['summary' => 'List onboarded marketplace sellers', 'tags' => ['Vendors']],
                'post' => ['summary' => 'Register new seller', 'tags' => ['Vendors']]
            ],
            '/webhooks' => [
                'get'    => ['summary' => 'List active outbound webhook subscriptions', 'tags' => ['Webhooks']],
                'post'   => ['summary' => 'Subscribe to event with HMAC secret', 'tags' => ['Webhooks']],
                'delete' => ['summary' => 'Unsubscribe webhook', 'tags' => ['Webhooks']]
            ]
        ]
    ];
}

function render_swagger_ui(): string
{
    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NovaDrop API Reference & Swagger UI</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@4/swagger-ui.css">
    <style>body { margin: 0; background: #fafafa; font-family: sans-serif; }</style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@4/swagger-ui-bundle.js"></script>
    <script>
    window.onload = function() {
        SwaggerUIBundle({
            url: "/Dropshipping/api/v1/openapi.json",
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [SwaggerUIBundle.presets.apis, SwaggerUIBundle.SwaggerUIStandalonePreset],
            layout: "BaseLayout"
        });
    };
    </script>
</body>
</html>
HTML;
}
