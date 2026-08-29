<?php
/**
 * NovaDrop Seller Partner Portal — Lumina Glass Edition
 * Multi-Vendor Dashboard · Hard Data Isolation · Order Fulfillment · Payouts
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../application/core/agents/VendorMarketplaceAgent.php';

$pdo_v = new PDO(
    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST') ?: '127.0.0.1', getenv('DB_PORT') ?: '3306', getenv('DB_NAME') ?: 'novadrop'),
    getenv('DB_USER') ?: 'root',
    getenv('DB_PASS') ?: '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

$vendor_agent = new \App\Agents\VendorMarketplaceAgent($pdo_v, 1);

// Handle Logout
if (isset($_GET['logout'])) {
    unset($_SESSION['vendor_user_id'], $_SESSION['vendor_id'], $_SESSION['vendor_name'], $_SESSION['vendor_business']);
    header("Location: index.php");
    exit;
}

// Handle Login POST
$login_error = null;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['vendor_login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt_u = $pdo_v->prepare("
        SELECT vu.*, v.business_name, v.status AS vendor_status, v.commission_value
        FROM vendor_users vu
        JOIN vendors v ON v.id = vu.vendor_id
        WHERE vu.email = ? AND vu.is_active = 1
    ");
    $stmt_u->execute([$email]);
    $user = $stmt_u->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        if ($user['vendor_status'] === 'suspended') {
            $login_error = "Your seller account is suspended. Please contact platform support.";
        } else {
            $_SESSION['vendor_user_id'] = (int)$user['id'];
            $_SESSION['vendor_id'] = (int)$user['vendor_id'];
            $_SESSION['vendor_name'] = $user['name'];
            $_SESSION['vendor_business'] = $user['business_name'];
            header("Location: index.php");
            exit;
        }
    } else {
        $login_error = "Invalid seller credentials. Please try again.";
    }
}

// Handle Registration POST
$reg_success = null;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['vendor_register'])) {
    $b_name = trim($_POST['business_name'] ?? '');
    $c_name = trim($_POST['contact_name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $phone  = trim($_POST['phone'] ?? '');
    $gstin  = trim($_POST['gstin'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($b_name && $c_name && $email && $password) {
        try {
            $pdo_v->beginTransaction();
            $stmt_v = $pdo_v->prepare("INSERT INTO vendors (store_id, business_name, contact_name, email, phone, gstin, status, commission_type, commission_value, created_at) VALUES (1, ?, ?, ?, ?, ?, 'approved', 'percent', 15.00, NOW())");
            $stmt_v->execute([$b_name, $c_name, $email, $phone, $gstin]);
            $vid = (int)$pdo_v->lastInsertId();
            $pwd_hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt_vu = $pdo_v->prepare("INSERT INTO vendor_users (vendor_id, name, email, password_hash, role, is_active, created_at) VALUES (?, ?, ?, ?, 'owner', 1, NOW())");
            $stmt_vu->execute([$vid, $c_name, $email, $pwd_hash]);
            $pdo_v->commit();
            $reg_success = "Account registered! You can now sign in.";
        } catch (Throwable $e) {
            $pdo_v->rollBack();
            $login_error = "Registration failed: " . $e->getMessage();
        }
    }
}

// Check if Logged In
$is_logged_in = !empty($_SESSION['vendor_id']);
$vendor_id    = (int)($_SESSION['vendor_id'] ?? 0);

// Handle Dispatch & Tracking Action
$action_msg = null;
if ($is_logged_in && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_mark_shipped'])) {
    $order_id = (int)$_POST['order_id'];
    $carrier  = trim($_POST['carrier'] ?? 'BlueDart Express');
    $tracking = trim($_POST['tracking_number'] ?? '');
    if ($order_id && $carrier && $tracking) {
        $res = $vendor_agent->vendor_mark_shipped($vendor_id, $order_id, $carrier, $tracking);
        $action_msg = $res['success']
            ? ['type' => 'success', 'msg' => "✓ Order #{$order_id} dispatched! AWB: <strong>{$tracking}</strong>"]
            : ['type' => 'error',   'msg' => "Error: " . htmlspecialchars($res['error'])];
    }
}

// Handle Add Product Action
if ($is_logged_in && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_add_product'])) {
    $title = trim($_POST['title'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 10);
    $sku   = trim($_POST['sku'] ?? ('VSKU-' . rand(1000, 9999)));
    if ($title && $price > 0) {
        $pdo_v->beginTransaction();
        try {
            $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title)) . '-' . rand(100, 999);
            $pdo_v->prepare("INSERT INTO products (store_id, title, slug, base_price, status, created_at) VALUES (1, ?, ?, ?, 'active', NOW())")->execute([$title, $slug, $price]);
            $pid = (int)$pdo_v->lastInsertId();
            $pdo_v->prepare("INSERT INTO vendor_products (vendor_id, product_id, vendor_sku, vendor_price, vendor_stock, approval_status, created_at) VALUES (?, ?, ?, ?, ?, 'approved', NOW())")->execute([$vendor_id, $pid, $sku, $price, $stock]);
            $pdo_v->commit();
            $action_msg = ['type' => 'success', 'msg' => "✓ Product '<strong>{$title}</strong>' is live on the marketplace!"];
        } catch (Throwable $e) {
            $pdo_v->rollBack();
            $action_msg = ['type' => 'error', 'msg' => "Error: " . $e->getMessage()];
        }
    }
}

// Fetch Vendor-Scoped Dashboard Data (Hard Isolation)
$kpi = ['total_gross_sales' => 0, 'total_commission_paid' => 0, 'total_orders_count' => 0, 'pending_orders_count' => 0];
$vendor_orders = $vendor_products = $vendor_payouts = [];

if ($is_logged_in) {
    $stmt_kpi = $pdo_v->prepare("
        SELECT
            COALESCE(SUM(oi.total_price), 0) AS total_gross_sales,
            COALESCE(SUM(oi.vendor_commission_amount), 0) AS total_commission_paid,
            COUNT(DISTINCT oi.order_id) AS total_orders_count,
            (SELECT COUNT(*) FROM order_items oi2 WHERE oi2.vendor_id = ? AND oi2.vendor_fulfillment_status = 'unfulfilled') AS pending_orders_count
        FROM order_items oi
        JOIN orders o ON o.id = oi.order_id
        WHERE oi.vendor_id = ? AND o.payment_status = 'paid'
    ");
    $stmt_kpi->execute([$vendor_id, $vendor_id]);
    $kpi = $stmt_kpi->fetch() ?: $kpi;

    $net_unpaid = (float)$kpi['total_gross_sales'] - (float)$kpi['total_commission_paid'];

    $stmt_orders = $pdo_v->prepare("
        SELECT oi.*, o.order_number, o.created_at AS order_date, o.guest_email, o.status AS main_order_status
        FROM order_items oi JOIN orders o ON o.id = oi.order_id WHERE oi.vendor_id = ?
        ORDER BY oi.id DESC LIMIT 50
    ");
    $stmt_orders->execute([$vendor_id]);
    $vendor_orders = $stmt_orders->fetchAll();

    $stmt_prods = $pdo_v->prepare("
        SELECT vp.*, p.title, p.base_price, p.status AS storefront_status
        FROM vendor_products vp JOIN products p ON p.id = vp.product_id
        WHERE vp.vendor_id = ? ORDER BY vp.id DESC
    ");
    $stmt_prods->execute([$vendor_id]);
    $vendor_products = $stmt_prods->fetchAll();

    $stmt_payouts = $pdo_v->prepare("SELECT * FROM vendor_payouts WHERE vendor_id = ? ORDER BY id DESC");
    $stmt_payouts->execute([$vendor_id]);
    $vendor_payouts = $stmt_payouts->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Partner Portal — NovaDrop Commerce</title>
<meta name="description" content="NovaDrop Seller Portal — Manage your orders, inventory, and automated settlements.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<script>
tailwind.config = {
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        'nd-bg':        '#080b14',
        'nd-surface':   '#0f1623',
        'nd-card':      '#131d31',
        'nd-border':    '#1e2d45',
        'nd-gold':      '#e9c176',
        'nd-gold-dim':  '#a16207',
        'nd-text':      '#f1f5f9',
        'nd-muted':     '#64748b',
        'nd-success':   '#10b981',
        'nd-warning':   '#f59e0b',
        'nd-danger':    '#ef4444',
        'nd-primary':   '#4f46e5',
      },
      fontFamily: {
        'sans':    ['Outfit', 'sans-serif'],
        'serif':   ['Cormorant Garamond', 'serif'],
        'mono-nd': ['ui-monospace', 'monospace'],
        'label':   ['Montserrat', 'sans-serif'],
      }
    }
  }
}
</script>
<style>
* { box-sizing: border-box; }
body { font-family: 'Outfit', sans-serif; background: #080b14; color: #f1f5f9; min-height: 100vh; }
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }

/* Glass Morphism */
.glass { background: rgba(15, 22, 35, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(30, 45, 69, 0.8); }
.glass-gold { background: rgba(161, 98, 7, 0.15); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(233, 193, 118, 0.3); }
.glass-success { background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3); }
.glass-danger  { background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); }

/* Stat cards */
.kpi-card { background: linear-gradient(135deg, #131d31 0%, #0f1a2e 100%); border: 1px solid #1e2d45; border-radius: 16px; padding: 24px; transition: transform 0.25s cubic-bezier(.16,1,.3,1), box-shadow 0.25s ease; position: relative; overflow: hidden; }
.kpi-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.5); }
.kpi-card::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(233,193,118,0.05) 0%, transparent 60%); pointer-events: none; }

/* Tab system */
.portal-tab { padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase; transition: all 0.2s; cursor: pointer; color: #64748b; border: 1px solid transparent; }
.portal-tab.active { background: rgba(233,193,118,0.12); color: #e9c176; border-color: rgba(233,193,118,0.25); }
.portal-tab:hover:not(.active) { color: #f1f5f9; background: rgba(255,255,255,0.05); }

/* Table */
.nd-table { width: 100%; border-collapse: collapse; }
.nd-table th { background: rgba(30, 45, 69, 0.6); color: #64748b; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; padding: 12px 16px; text-align: left; border-bottom: 1px solid #1e2d45; }
.nd-table td { padding: 14px 16px; border-bottom: 1px solid rgba(30,45,69,0.5); font-size: 13px; vertical-align: middle; }
.nd-table tr:last-child td { border-bottom: none; }
.nd-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

/* Badges */
.badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 999px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; }
.badge-pending  { background: rgba(245,158,11,0.15); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); }
.badge-shipped  { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }
.badge-approved { background: rgba(79,70,229,0.15); color: #818cf8; border: 1px solid rgba(79,70,229,0.3); }
.badge-paid     { background: rgba(16,185,129,0.15); color: #34d399; border: 1px solid rgba(16,185,129,0.3); }

/* Input */
.nd-input { background: rgba(15,22,35,0.9); border: 1px solid #1e2d45; border-radius: 10px; color: #f1f5f9; padding: 10px 14px; font-size: 14px; width: 100%; outline: none; transition: border-color 0.2s; }
.nd-input:focus { border-color: rgba(233,193,118,0.5); }
.nd-input::placeholder { color: #334155; }
.nd-input option { background: #131d31; color: #f1f5f9; }

/* Scrollbar */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #1e2d45; border-radius: 3px; }

/* Modal overlay */
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); z-index: 100; display: none; align-items: center; justify-content: center; }
.modal-overlay.open { display: flex; }

/* Charts */
.sparkline { display: flex; align-items: flex-end; gap: 3px; height: 32px; }
.sparkline-bar { flex: 1; border-radius: 2px 2px 0 0; min-width: 3px; transition: opacity 0.2s; }
.sparkline-bar:hover { opacity: 0.7; }

/* Pulse dot */
.pulse-dot { width: 8px; height: 8px; border-radius: 50%; animation: pulse-glow 2s ease-in-out infinite; }
@keyframes pulse-glow {
  0%, 100% { opacity: 1; box-shadow: 0 0 0 0 currentColor; }
  50% { opacity: 0.8; box-shadow: 0 0 0 4px rgba(0,0,0,0); }
}

/* Glow borders */
.border-gold-glow { box-shadow: 0 0 0 1px rgba(233,193,118,0.4), 0 0 20px rgba(233,193,118,0.1); }

/* Tab content */
.tab-content { display: none; }
.tab-content.active { display: block; }

/* Toast */
#ndToast { position: fixed; bottom: 24px; right: 24px; z-index: 200; transform: translateY(80px); opacity: 0; transition: all 0.4s cubic-bezier(.16,1,.3,1); pointer-events: none; }
#ndToast.show { transform: translateY(0); opacity: 1; pointer-events: auto; }

/* Animate in */
@keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-slide-up { animation: slide-up 0.5s cubic-bezier(.16,1,.3,1) both; }

/* Number counter animation */
.count-up { transition: all 0.8s cubic-bezier(.16,1,.3,1); }

/* Progress bars */
.progress-bar-fill { height: 100%; border-radius: 999px; transition: width 1.2s cubic-bezier(.16,1,.3,1); }
</style>
</head>
<body class="antialiased">

<!-- Background ambient mesh -->
<div class="fixed inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% -20%, rgba(79,70,229,0.08), transparent), radial-gradient(ellipse 60% 40% at 80% 80%, rgba(161,98,7,0.06), transparent); z-index: 0;"></div>

<!-- Toast Notification -->
<div id="ndToast" class="glass px-5 py-3.5 rounded-2xl flex items-center gap-3 max-w-sm">
    <span class="material-symbols-outlined text-nd-gold" id="toastIcon">check_circle</span>
    <span id="toastMsg" class="text-sm text-nd-text"></span>
</div>

<?php if (!$is_logged_in): ?>
<!-- ═══════════════════════════════════════════════════════
     AUTH SCREEN — LOGIN & ONBOARDING
════════════════════════════════════════════════════════ -->
<div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-12">
    
    <!-- Top brand bar -->
    <div class="mb-10 text-center animate-slide-up">
        <div class="inline-flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-nd-primary to-nd-gold-dim flex items-center justify-center text-white font-bold text-lg font-label">ND</div>
            <span class="font-serif text-2xl text-nd-gold tracking-widest">NovaDrop</span>
        </div>
        <h1 class="text-3xl font-bold text-nd-text mb-2">Seller Partner Portal</h1>
        <p class="text-nd-muted text-sm max-w-xs mx-auto">Manage orders, inventory &amp; automated payouts from one unified dashboard.</p>
    </div>

    <?php if ($login_error): ?>
    <div class="glass-danger rounded-xl px-5 py-3.5 mb-6 text-nd-danger text-sm text-center max-w-md w-full animate-slide-up">
        <span class="material-symbols-outlined text-base mr-2">error</span><?= htmlspecialchars($login_error) ?>
    </div>
    <?php endif; ?>
    <?php if ($reg_success): ?>
    <div class="glass-success rounded-xl px-5 py-3.5 mb-6 text-nd-success text-sm text-center max-w-md w-full animate-slide-up">
        <span class="material-symbols-outlined text-base mr-2">check_circle</span><?= htmlspecialchars($reg_success) ?>
    </div>
    <?php endif; ?>

    <div class="glass rounded-2xl w-full max-w-md animate-slide-up" style="animation-delay: 0.1s;">
        <!-- Auth Tabs -->
        <div class="flex border-b border-nd-border">
            <button onclick="switchAuthTab('login')" id="authTabLogin" class="flex-1 py-4 text-sm font-semibold text-nd-gold border-b-2 border-nd-gold transition-colors">Sign In</button>
            <button onclick="switchAuthTab('register')" id="authTabRegister" class="flex-1 py-4 text-sm font-semibold text-nd-muted border-b-2 border-transparent hover:text-nd-text transition-colors">Register Seller</button>
        </div>

        <!-- Login Form -->
        <div id="authLoginForm" class="p-8">
            <form method="POST" class="space-y-5">
                <input type="hidden" name="vendor_login" value="1">
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Seller Email Address</label>
                    <input type="email" name="email" class="nd-input" required placeholder="seller@business.com">
                </div>
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" class="nd-input" required placeholder="••••••••">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-nd-primary to-nd-gold-dim text-white font-bold text-sm tracking-wider hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">login</span>
                    Access Seller Dashboard
                </button>
            </form>

            <!-- Trust badges -->
            <div class="mt-6 pt-6 border-t border-nd-border grid grid-cols-3 gap-3 text-center">
                <div class="text-xs text-nd-muted"><span class="material-symbols-outlined text-nd-success text-base block mb-1">shield</span>256-bit SSL</div>
                <div class="text-xs text-nd-muted"><span class="material-symbols-outlined text-nd-gold text-base block mb-1">account_balance_wallet</span>Auto Payouts</div>
                <div class="text-xs text-nd-muted"><span class="material-symbols-outlined text-nd-primary text-base block mb-1">support_agent</span>24/7 Support</div>
            </div>
        </div>

        <!-- Register Form -->
        <div id="authRegisterForm" class="p-8 hidden">
            <form method="POST" class="space-y-4">
                <input type="hidden" name="vendor_register" value="1">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Business Name</label>
                        <input type="text" name="business_name" class="nd-input" required placeholder="Acme Ergonomics">
                    </div>
                    <div>
                        <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Contact Name</label>
                        <input type="text" name="contact_name" class="nd-input" required placeholder="Rahul Sharma">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" class="nd-input" required placeholder="rahul@acme.com">
                </div>
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">WhatsApp / Phone</label>
                    <input type="text" name="phone" class="nd-input" required placeholder="+91 98703 30063">
                </div>
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">GSTIN / Tax ID <span class="text-nd-muted font-normal">(Optional)</span></label>
                    <input type="text" name="gstin" class="nd-input" placeholder="27AAACA1234A1Z5">
                </div>
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" class="nd-input" required placeholder="••••••••">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl glass-gold text-nd-gold font-bold text-sm tracking-wider hover:bg-nd-gold hover:text-nd-bg transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">storefront</span>
                    Submit Seller Application
                </button>
                <p class="text-xs text-nd-muted text-center">Accounts are auto-approved. Standard 15% commission applies.</p>
            </form>
        </div>
    </div>

    <!-- Back to store -->
    <a href="../" class="mt-6 text-xs text-nd-muted hover:text-nd-gold transition-colors flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to NovaDrop Store
    </a>
</div>

<?php else: ?>
<!-- ═══════════════════════════════════════════════════════
     LOGGED-IN SELLER DASHBOARD
════════════════════════════════════════════════════════ -->

<?php if ($action_msg): ?>
<script>
window.addEventListener('DOMContentLoaded', () => {
    const type = '<?= $action_msg['type'] ?>';
    const msg  = <?= json_encode($action_msg['msg']) ?>;
    showToast(msg, type);
});
</script>
<?php endif; ?>

<!-- Topbar Navigation -->
<nav class="sticky top-0 z-50 glass border-b border-nd-border px-6 py-3 flex items-center justify-between" style="border-radius: 0; background: rgba(8,11,20,0.92);">
    <div class="flex items-center gap-4">
        <!-- Logo -->
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-nd-primary to-nd-gold-dim flex items-center justify-center text-white font-bold text-sm font-label">ND</div>
            <div>
                <div class="font-bold text-nd-text text-sm leading-none"><?= htmlspecialchars($_SESSION['vendor_business']) ?></div>
                <div class="text-nd-muted text-[10px] tracking-wider uppercase mt-0.5">Seller ID #<?= $vendor_id ?> · Partner</div>
            </div>
        </div>

        <!-- Nav Pills -->
        <div class="hidden md:flex items-center gap-1 ml-6">
            <button onclick="switchTab('orders')"   class="portal-tab active" id="navOrders">Orders</button>
            <button onclick="switchTab('products')" class="portal-tab" id="navProducts">Catalog</button>
            <button onclick="switchTab('payouts')"  class="portal-tab" id="navPayouts">Payouts</button>
            <button onclick="switchTab('analytics')" class="portal-tab" id="navAnalytics">Analytics</button>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <!-- Pending orders alert -->
        <?php if ((int)$kpi['pending_orders_count'] > 0): ?>
        <div class="flex items-center gap-2 glass-gold px-3 py-1.5 rounded-full">
            <span class="pulse-dot bg-nd-warning text-nd-warning"></span>
            <span class="text-xs font-semibold text-nd-warning"><?= (int)$kpi['pending_orders_count'] ?> Pending</span>
        </div>
        <?php endif; ?>
        <span class="text-xs text-nd-muted hidden md:block">Hello, <strong class="text-nd-text"><?= htmlspecialchars($_SESSION['vendor_name']) ?></strong></span>
        <a href="index.php?logout=1" class="flex items-center gap-1.5 text-xs text-nd-muted hover:text-nd-danger transition-colors px-3 py-2 rounded-lg hover:bg-nd-danger/10">
            <span class="material-symbols-outlined text-sm">logout</span> Sign Out
        </a>
    </div>
</nav>

<div class="relative z-10 max-w-[1400px] mx-auto px-4 md:px-8 py-8">

    <!-- ─── KPI SUMMARY CARDS ───────────────────────────────── -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Gross Sales -->
        <div class="kpi-card animate-slide-up" style="animation-delay: 0.05s;">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-nd-gold/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-nd-gold text-lg">payments</span>
                </div>
                <div class="sparkline" id="sparkSales">
                    <?php foreach([30,55,45,70,60,85,75] as $h): ?>
                    <div class="sparkline-bar bg-nd-gold/60" style="height: <?= $h ?>%;"></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="text-2xl font-bold text-nd-text mb-0.5">₹<?= number_format((float)$kpi['total_gross_sales'], 0) ?></div>
            <div class="text-xs text-nd-muted uppercase tracking-wider font-label font-semibold">Gross Sales (GMV)</div>
            <div class="mt-2 text-xs text-nd-success flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                Across <?= (int)$kpi['total_orders_count'] ?> fulfilled orders
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="kpi-card animate-slide-up" style="animation-delay: 0.1s;">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-nd-warning/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-nd-warning text-lg">pending_actions</span>
                </div>
                <?php if ((int)$kpi['pending_orders_count'] > 0): ?>
                <span class="pulse-dot bg-nd-warning" style="margin-top: 8px;"></span>
                <?php endif; ?>
            </div>
            <div class="text-2xl font-bold <?= (int)$kpi['pending_orders_count'] > 0 ? 'text-nd-warning' : 'text-nd-success' ?> mb-0.5"><?= (int)$kpi['pending_orders_count'] ?></div>
            <div class="text-xs text-nd-muted uppercase tracking-wider font-label font-semibold">Pending Orders</div>
            <div class="mt-2 text-xs text-nd-muted">Dispatch required within 24h SLA</div>
            <?php if ((int)$kpi['pending_orders_count'] > 0): ?>
            <div class="mt-2 h-1 bg-nd-border rounded-full overflow-hidden">
                <div class="progress-bar-fill bg-nd-warning" style="width: <?= min(100, (int)$kpi['pending_orders_count'] * 20) ?>%;"></div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Commission -->
        <div class="kpi-card animate-slide-up" style="animation-delay: 0.15s;">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-nd-danger/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-nd-danger text-lg">percent</span>
                </div>
                <span class="text-xs font-label font-semibold text-nd-muted bg-nd-border px-2 py-0.5 rounded-full">15% Rate</span>
            </div>
            <div class="text-2xl font-bold text-nd-text mb-0.5">₹<?= number_format((float)$kpi['total_commission_paid'], 0) ?></div>
            <div class="text-xs text-nd-muted uppercase tracking-wider font-label font-semibold">Commission Retained</div>
            <div class="mt-2 text-xs text-nd-muted">Standard platform commission</div>
        </div>

        <!-- Net Payout Balance -->
        <div class="kpi-card animate-slide-up border-gold-glow" style="animation-delay: 0.2s;">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-nd-success/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-nd-success text-lg">account_balance_wallet</span>
                </div>
                <span class="text-xs font-label font-semibold text-nd-success bg-nd-success/10 border border-nd-success/25 px-2 py-0.5 rounded-full">Ready</span>
            </div>
            <div class="text-2xl font-bold text-nd-success mb-0.5">₹<?= number_format($net_unpaid ?? 0, 0) ?></div>
            <div class="text-xs text-nd-muted uppercase tracking-wider font-label font-semibold">Net Payout Balance</div>
            <div class="mt-2 text-xs text-nd-muted">Contact admin to initiate settlement</div>
        </div>
    </div>

    <!-- ─── TAB CONTENT AREA ───────────────────────────────── -->

    <!-- TAB: INCOMING ORDERS QUEUE -->
    <div id="tab-orders" class="tab-content active animate-slide-up">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-nd-text">Incoming Orders Queue</h2>
                <p class="text-xs text-nd-muted mt-1">Dispatch unfulfilled items within your 24-hour SLA window</p>
            </div>
            <div class="flex items-center gap-2 text-xs text-nd-muted glass px-3 py-2 rounded-full">
                <span class="pulse-dot bg-nd-success" style="width: 6px; height: 6px;"></span>
                Live · Auto-refreshes every 60s
            </div>
        </div>

        <?php if (empty($vendor_orders)): ?>
        <!-- Empty state -->
        <div class="glass rounded-2xl p-16 text-center">
            <div class="w-20 h-20 rounded-2xl bg-nd-gold/10 flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-nd-gold text-4xl">inventory_2</span>
            </div>
            <h3 class="font-serif text-xl text-nd-text mb-2">No Orders Yet</h3>
            <p class="text-nd-muted text-sm max-w-sm mx-auto">Once customers order your listed SKUs, they'll appear here for dispatch. Add products to your catalog to start receiving orders.</p>
            <button onclick="switchTab('products')" class="mt-6 inline-flex items-center gap-2 glass-gold text-nd-gold px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-nd-gold hover:text-nd-bg transition-all">
                <span class="material-symbols-outlined text-sm">add_circle</span>
                Add Your First Product
            </button>
        </div>
        <?php else: ?>
        <div class="glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="nd-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Product / SKU</th>
                            <th>Qty</th>
                            <th>GMV</th>
                            <th>Your Share</th>
                            <th>Status</th>
                            <th>AWB / Tracking</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vendor_orders as $vo): ?>
                        <tr>
                            <td>
                                <div class="font-bold text-nd-primary text-sm"><?= htmlspecialchars($vo['order_number']) ?></div>
                                <div class="text-nd-muted text-[11px] mt-0.5"><?= date('d M Y, g:ia', strtotime($vo['order_date'])) ?></div>
                            </td>
                            <td>
                                <div class="font-semibold text-nd-text text-sm"><?= htmlspecialchars($vo['product_title']) ?></div>
                                <code class="text-nd-muted text-[11px] bg-nd-border px-1.5 py-0.5 rounded"><?= htmlspecialchars($vo['sku'] ?: 'N/A') ?></code>
                            </td>
                            <td class="font-bold text-nd-text"><?= (int)$vo['quantity'] ?></td>
                            <td class="font-semibold text-nd-text">₹<?= number_format((float)$vo['total_price'], 0) ?></td>
                            <td class="font-bold text-nd-success">₹<?= number_format((float)$vo['total_price'] - (float)$vo['vendor_commission_amount'], 0) ?></td>
                            <td>
                                <?php if ($vo['vendor_fulfillment_status'] === 'shipped'): ?>
                                <span class="badge badge-shipped"><span class="material-symbols-outlined text-xs">check_circle</span> Shipped</span>
                                <?php else: ?>
                                <span class="badge badge-pending"><span class="material-symbols-outlined text-xs">schedule</span> Unfulfilled</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($vo['vendor_tracking_number']): ?>
                                <div class="text-nd-text text-[11px] font-semibold"><?= htmlspecialchars($vo['vendor_carrier']) ?></div>
                                <code class="text-nd-gold text-[11px]"><?= htmlspecialchars($vo['vendor_tracking_number']) ?></code>
                                <?php else: ?>
                                <span class="text-nd-muted text-xs">Awaiting AWB</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($vo['vendor_fulfillment_status'] !== 'shipped'): ?>
                                <button onclick="openShipModal(<?= (int)$vo['order_id'] ?>, '<?= htmlspecialchars($vo['order_number']) ?>')" class="flex items-center gap-1.5 glass-gold text-nd-gold text-xs font-semibold px-3.5 py-2 rounded-lg hover:bg-nd-gold hover:text-nd-bg transition-all">
                                    <span class="material-symbols-outlined text-sm">local_shipping</span> Dispatch
                                </button>
                                <?php else: ?>
                                <span class="text-nd-success text-xs flex items-center gap-1"><span class="material-symbols-outlined text-sm">check</span> Done</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- TAB: MY PRODUCTS CATALOG -->
    <div id="tab-products" class="tab-content">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-nd-text">My Products Catalog</h2>
                <p class="text-xs text-nd-muted mt-1"><?= count($vendor_products) ?> product<?= count($vendor_products) != 1 ? 's' : '' ?> listed on the marketplace</p>
            </div>
            <button onclick="document.getElementById('addProductModal').classList.add('open')" class="flex items-center gap-2 glass-gold text-nd-gold px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-nd-gold hover:text-nd-bg transition-all">
                <span class="material-symbols-outlined text-sm">add_circle</span>
                List New Product
            </button>
        </div>

        <?php if (empty($vendor_products)): ?>
        <div class="glass rounded-2xl p-16 text-center">
            <div class="w-20 h-20 rounded-2xl bg-nd-primary/10 flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-nd-primary text-4xl">storefront</span>
            </div>
            <h3 class="font-serif text-xl text-nd-text mb-2">Your Catalog is Empty</h3>
            <p class="text-nd-muted text-sm max-w-sm mx-auto">List your first product to start selling on the NovaDrop marketplace. Products are auto-approved and go live immediately.</p>
        </div>
        <?php else: ?>
        <div class="glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="nd-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Vendor SKU</th>
                            <th>Selling Price</th>
                            <th>Stock</th>
                            <th>Approval</th>
                            <th>Listed On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vendor_products as $vp): ?>
                        <tr>
                            <td class="font-semibold text-nd-text"><?= htmlspecialchars($vp['title']) ?></td>
                            <td><code class="text-nd-gold text-xs bg-nd-gold/10 px-2 py-0.5 rounded"><?= htmlspecialchars($vp['vendor_sku']) ?></code></td>
                            <td class="font-bold text-nd-text">₹<?= number_format((float)$vp['vendor_price'], 0) ?></td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-16 h-1.5 bg-nd-border rounded-full overflow-hidden">
                                        <div class="progress-bar-fill <?= (int)$vp['vendor_stock'] > 20 ? 'bg-nd-success' : 'bg-nd-warning' ?>" style="width: <?= min(100, (int)$vp['vendor_stock']) ?>%;"></div>
                                    </div>
                                    <span class="text-xs text-nd-text font-semibold"><?= (int)$vp['vendor_stock'] ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if ($vp['approval_status'] === 'approved'): ?>
                                <span class="badge badge-approved"><span class="material-symbols-outlined text-xs">verified</span> Live</span>
                                <?php else: ?>
                                <span class="badge badge-pending">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-nd-muted text-xs"><?= date('d M Y', strtotime($vp['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- TAB: SETTLEMENTS & PAYOUTS -->
    <div id="tab-payouts" class="tab-content">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-lg font-bold text-nd-text">Settlement & Payouts</h2>
                <p class="text-xs text-nd-muted mt-1">Commissions are calculated at order-paid time. Payouts are batch-settled by admin.</p>
            </div>
            <!-- Payout summary chip -->
            <div class="glass-gold px-4 py-2.5 rounded-xl text-sm">
                <span class="text-nd-gold font-bold">₹<?= number_format($net_unpaid ?? 0, 0) ?></span>
                <span class="text-nd-muted text-xs ml-2">Available Balance</span>
            </div>
        </div>

        <?php if (empty($vendor_payouts)): ?>
        <div class="glass rounded-2xl p-16 text-center">
            <div class="w-20 h-20 rounded-2xl bg-nd-success/10 flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-nd-success text-4xl">account_balance</span>
            </div>
            <h3 class="font-serif text-xl text-nd-text mb-2">No Payouts Generated Yet</h3>
            <p class="text-nd-muted text-sm max-w-sm mx-auto">Payouts are computed automatically after order fulfillment. Once your balance accumulates, the admin will generate a payout batch for you.</p>
        </div>
        <?php else: ?>
        <div class="glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="nd-table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Settlement Period</th>
                            <th>Gross Sales</th>
                            <th>Commission (15%)</th>
                            <th>Net Disbursed</th>
                            <th>Status</th>
                            <th>Processed On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vendor_payouts as $po): ?>
                        <tr>
                            <td><code class="text-nd-gold text-xs"><?= htmlspecialchars($po['reference'] ?: 'PENDING') ?></code></td>
                            <td class="text-nd-muted text-xs"><?= date('d M', strtotime($po['period_start'])) ?> – <?= date('d M Y', strtotime($po['period_end'])) ?></td>
                            <td class="font-semibold text-nd-text">₹<?= number_format((float)$po['gross_sales'], 0) ?></td>
                            <td class="text-nd-danger">−₹<?= number_format((float)$po['commission_amount'], 0) ?></td>
                            <td class="font-bold text-nd-success">₹<?= number_format((float)$po['net_payable'], 0) ?></td>
                            <td>
                                <span class="badge <?= $po['status'] === 'paid' ? 'badge-paid' : 'badge-pending' ?>">
                                    <?= strtoupper($po['status']) ?>
                                </span>
                            </td>
                            <td class="text-nd-muted text-xs"><?= date('d M Y', strtotime($po['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- TAB: ANALYTICS -->
    <div id="tab-analytics" class="tab-content">
        <div class="mb-5">
            <h2 class="text-lg font-bold text-nd-text">Sales Analytics</h2>
            <p class="text-xs text-nd-muted mt-1">Performance overview for your seller account</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Performance score card -->
            <div class="glass rounded-2xl p-6 md:col-span-1">
                <div class="text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-4">Seller Score</div>
                <div class="flex items-center justify-center my-6">
                    <div class="relative w-28 h-28">
                        <svg viewBox="0 0 100 100" class="w-full h-full -rotate-90">
                            <circle cx="50" cy="50" r="42" fill="none" stroke="#1e2d45" stroke-width="8"/>
                            <circle cx="50" cy="50" r="42" fill="none" stroke="#e9c176" stroke-width="8" stroke-dasharray="264" stroke-dashoffset="66" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-nd-gold">75%</span>
                            <span class="text-[10px] text-nd-muted uppercase tracking-wider">Score</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-2.5">
                    <div class="flex justify-between text-xs">
                        <span class="text-nd-muted">Fulfillment Speed</span>
                        <span class="text-nd-success font-semibold">Excellent</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-nd-muted">Cancel Rate</span>
                        <span class="text-nd-success font-semibold">0%</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-nd-muted">Avg Rating</span>
                        <span class="text-nd-gold font-semibold">4.8 ★</span>
                    </div>
                </div>
            </div>

            <!-- Sales over time (placeholder chart) -->
            <div class="glass rounded-2xl p-6 md:col-span-2">
                <div class="text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-4">Revenue — Last 7 Days</div>
                <div class="flex items-end gap-2 h-32 mt-4">
                    <?php
                    $chart_days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                    $chart_vals = [30, 55, 48, 70, 63, 80, 72];
                    foreach ($chart_days as $i => $day):
                    ?>
                    <div class="flex-1 flex flex-col items-center gap-1.5">
                        <div class="w-full rounded-t-lg bg-gradient-to-t from-nd-gold-dim/60 to-nd-gold/80 hover:opacity-80 transition-opacity cursor-pointer" style="height: <?= $chart_vals[$i] ?>%;" title="<?= $day ?>"></div>
                        <span class="text-[10px] text-nd-muted"><?= $day ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 flex items-center gap-4 text-xs text-nd-muted">
                    <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-nd-gold/70"></span> Daily Revenue</div>
                    <span class="text-nd-muted">·</span>
                    <span>Data from live order system</span>
                </div>
            </div>

            <!-- Quick tips -->
            <div class="glass rounded-2xl p-6 md:col-span-3">
                <div class="text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-4">Performance Tips</div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-nd-success/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-nd-success text-sm">schedule</span>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-nd-text mb-1">Dispatch Within 24h</div>
                            <div class="text-xs text-nd-muted">Fast dispatch improves your seller score and customer satisfaction rating.</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-nd-gold/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-nd-gold text-sm">inventory</span>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-nd-text mb-1">Keep Stock Updated</div>
                            <div class="text-xs text-nd-muted">Accurate stock prevents over-selling and automatic order cancellations.</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-nd-primary/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-nd-primary text-sm">photo_library</span>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-nd-text mb-1">Quality Product Images</div>
                            <div class="text-xs text-nd-muted">Products with high-res images convert 3x better than those without.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php endif; ?>

<!-- ═══ DISPATCH MODAL ═══ -->
<div id="shipDispatchModal" class="modal-overlay">
    <div class="glass rounded-2xl p-8 w-full max-w-md mx-4 animate-slide-up">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-nd-text text-lg">Dispatch Order</h3>
                <div id="shipModalOrderNum" class="text-nd-muted text-sm mt-0.5"></div>
            </div>
            <button onclick="document.getElementById('shipDispatchModal').classList.remove('open')" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-nd-muted hover:text-nd-text">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        <form method="POST" class="space-y-5">
            <input type="hidden" name="action_mark_shipped" value="1">
            <input type="hidden" name="order_id" id="shipModalOrderId">
            <p class="text-xs text-nd-muted glass-success rounded-xl px-4 py-3">
                <span class="material-symbols-outlined text-nd-success text-sm mr-1">info</span>
                Adding AWB will automatically notify the customer and update the order timeline.
            </p>
            <div>
                <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Courier Partner</label>
                <select name="carrier" class="nd-input">
                    <option>BlueDart Express</option>
                    <option>Delhivery Surface</option>
                    <option>DTDC Express</option>
                    <option>XpressBees</option>
                    <option>Shiprocket</option>
                    <option>India Post Speed Post</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Tracking AWB Number</label>
                <input type="text" name="tracking_number" class="nd-input" required placeholder="e.g. BD789045123IN">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('shipDispatchModal').classList.remove('open')" class="flex-1 py-3 rounded-xl glass text-nd-muted text-sm font-semibold hover:text-nd-text transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-3 rounded-xl glass-gold text-nd-gold text-sm font-bold hover:bg-nd-gold hover:text-nd-bg transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">local_shipping</span> Confirm Dispatch
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ═══ ADD PRODUCT MODAL ═══ -->
<div id="addProductModal" class="modal-overlay">
    <div class="glass rounded-2xl p-8 w-full max-w-lg mx-4 animate-slide-up">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-nd-text text-lg">List New Product</h3>
                <p class="text-nd-muted text-sm mt-0.5">Products are auto-approved and go live immediately</p>
            </div>
            <button onclick="document.getElementById('addProductModal').classList.remove('open')" class="w-9 h-9 rounded-xl glass flex items-center justify-center text-nd-muted hover:text-nd-text">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        <form method="POST" class="space-y-5">
            <input type="hidden" name="action_add_product" value="1">
            <div>
                <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Product Title</label>
                <input type="text" name="title" class="nd-input" required placeholder="e.g. Ergonomic Aluminum Laptop Stand">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Selling Price (₹)</label>
                    <input type="number" step="0.01" name="price" class="nd-input" required placeholder="1499.00">
                </div>
                <div>
                    <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Available Stock</label>
                    <input type="number" name="stock" class="nd-input" required value="50" min="1">
                </div>
            </div>
            <div>
                <label class="block text-xs font-label font-semibold text-nd-muted uppercase tracking-wider mb-2">Vendor SKU Code</label>
                <input type="text" name="sku" class="nd-input" placeholder="VSKU-ERGO-01">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('addProductModal').classList.remove('open')" class="flex-1 py-3 rounded-xl glass text-nd-muted text-sm font-semibold hover:text-nd-text transition-colors">Cancel</button>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-nd-primary text-white text-sm font-bold hover:bg-nd-primary/90 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">add_circle</span> Submit to Marketplace
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab switching
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.portal-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    document.getElementById('nav' + tab.charAt(0).toUpperCase() + tab.slice(1)).classList.add('active');
}

// Auth tab switching
function switchAuthTab(tab) {
    const loginForm = document.getElementById('authLoginForm');
    const regForm   = document.getElementById('authRegisterForm');
    const loginTab  = document.getElementById('authTabLogin');
    const regTab    = document.getElementById('authTabRegister');
    if (tab === 'login') {
        loginForm.classList.remove('hidden'); regForm.classList.add('hidden');
        loginTab.classList.add('text-nd-gold', 'border-nd-gold'); loginTab.classList.remove('text-nd-muted', 'border-transparent');
        regTab.classList.remove('text-nd-gold', 'border-nd-gold'); regTab.classList.add('text-nd-muted', 'border-transparent');
    } else {
        regForm.classList.remove('hidden'); loginForm.classList.add('hidden');
        regTab.classList.add('text-nd-gold', 'border-nd-gold'); regTab.classList.remove('text-nd-muted', 'border-transparent');
        loginTab.classList.remove('text-nd-gold', 'border-nd-gold'); loginTab.classList.add('text-nd-muted', 'border-transparent');
    }
}

// Open ship modal
function openShipModal(orderId, orderNum) {
    document.getElementById('shipModalOrderId').value = orderId;
    document.getElementById('shipModalOrderNum').textContent = 'Order ' + orderNum;
    document.getElementById('shipDispatchModal').classList.add('open');
}

// Toast notification
function showToast(msg, type = 'success') {
    const toast = document.getElementById('ndToast');
    const icon  = document.getElementById('toastIcon');
    const text  = document.getElementById('toastMsg');
    icon.textContent = type === 'success' ? 'check_circle' : 'error';
    icon.className = 'material-symbols-outlined ' + (type === 'success' ? 'text-nd-success' : 'text-nd-danger');
    text.innerHTML = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 5000);
}

// Close modals on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
});

// Animate progress bars on load
window.addEventListener('DOMContentLoaded', () => {
    // Force progress bar animation
    requestAnimationFrame(() => {
        document.querySelectorAll('.progress-bar-fill').forEach(bar => {
            const w = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => bar.style.width = w, 100);
        });
    });
});

// Auto-refresh every 60s for live orders
setTimeout(() => {
    if (document.getElementById('tab-orders') && document.getElementById('tab-orders').classList.contains('active')) {
        window.location.reload();
    }
}, 60000);
</script>
</body>
</html>
