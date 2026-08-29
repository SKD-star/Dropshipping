<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name('js239');
    session_start();
}
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
$current_file = basename($_SERVER['SCRIPT_FILENAME'] ?? '');
$script_to_q = [
    'ai_swarm.php'       => 10,
    'vendors.php'        => 11,
    'email_ai.php'       => 12,
    'gateways.php'       => 14,
    'importer.php'       => 15,
    'autopilot.php'      => 16,
    'repricer.php'       => 17,
    'reviews.php'        => 18,
    'cart_recovery.php'  => 19,
    'inventory.php'      => 20,
    'ad_generator.php'   => 21,
    'seo_studio.php'     => 22,
    'international.php'  => 23,
    'loyalty.php'        => 24,
    'referral.php'       => 25,
    'flash_sales.php'    => 26,
    'bundles.php'        => 27,
    'subscriptions.php'  => 28,
    'group_buying.php'   => 29,
    'gamification.php'   => 30,
    'mystery_drops.php'  => 31,
    'waitlist.php'       => 32,
    'influencer.php'     => 33,
    'pre_orders.php'     => 34,
    'home_settings.php'  => 88,
    'app.php'            => 8,
    'add.php'            => 1,
    'prod.php'           => 1,
    'users.php'          => 2,
    'adminscart.php'     => 2,
    'signup.php'         => 9,
    'edit.php'           => 9,
];
if (isset($_GET['q'])) {
    $current_q = (int)$_GET['q'];
} elseif (isset($script_to_q[$current_file])) {
    $current_q = $script_to_q[$current_file];
} else {
    $current_q = 0;
}
$admin_name  = $_SESSION['admin'] ?? 'Administrator';
$appsActive  = in_array($current_q, [5,6,7,8,9,11,12,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,88]);
$colorMap    = ['brand'=>'#6366f1','success'=>'#059669','warning'=>'#d97706','danger'=>'#dc2626','info'=>'#0e7490','purple'=>'#9333ea','pink'=>'#be185d','orange'=>'#c2410c','teal'=>'#0f766e'];
?>

<nav class="navbar custom-navbar" role="navigation" aria-label="Admin navigation">

    <!-- Brand (Left) -->
    <div class="ty">
        <a class="navbar-brand" href="index.php?q=0" aria-label="NovaDrop Dashboard">
            <div class="brand-badge-icon">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <div class="brand-text-wrap">
                <span class="brand-title">NOVADROP</span>
                <span class="brand-version-pill">OS 2.0</span>
            </div>
        </a>
        <button class="custom-navbar-toggler" id="hamburger-icon" onclick="toggleNavbar()" aria-label="Toggle navigation">
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
        </button>
    </div>

    <!-- Nav + Utilities -->
    <div class="custom-navbar-collapse" id="navbar-nav">

        <!-- Core Nav Links -->
        <ul class="custom-navbar-nav">
            <li class="nav-item <?= ($current_q===0)?'active':'' ?>">
                <a class="nav-link" href="index.php?q=0" title="Dashboard · Alt+D">
                    <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item <?= ($current_q===1)?'active':'' ?>">
                <a class="nav-link" href="index.php?q=1" title="Products">
                    <i class="fa-solid fa-shirt"></i><span>Products</span>
                </a>
            </li>
            <li class="nav-item <?= ($current_q===3)?'active':'' ?>">
                <a class="nav-link" href="index.php?q=3" title="Orders">
                    <i class="fa-solid fa-bag-shopping"></i><span>Orders</span>
                </a>
            </li>
            <li class="nav-item <?= ($current_q===2)?'active':'' ?>">
                <a class="nav-link" href="index.php?q=2">
                    <i class="fa-solid fa-users"></i><span>Customers</span>
                </a>
            </li>
            <li class="nav-item <?= ($current_q===4)?'active':'' ?>">
                <a class="nav-link" href="index.php?q=4">
                    <i class="fa-solid fa-receipt"></i><span>Ledger</span>
                </a>
            </li>
            <li class="nav-item <?= ($current_q===10)?'active':'' ?>">
                <a class="nav-link nav-link-ai" href="index.php?q=10" title="AI Autonomous Swarm">
                    <i class="fa-solid fa-robot"></i><span>AI Swarm</span>
                    <span class="ai-pulse-dot"></span>
                </a>
            </li>

            <!-- Apps & Models Mega-Dropdown -->
            <li class="nav-item dropdown <?= $appsActive?'active':'' ?>">
                <a class="nav-link dropdown-toggle" href="#" id="appsDropdown"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Apps &amp; Models</span>
                    <?php if ($appsActive): ?><span style="width:5px;height:5px;border-radius:50%;background:var(--brand);flex-shrink:0;margin-left:2px;"></span><?php endif; ?>
                </a>

                <div class="dropdown-menu mega-dropdown-menu" aria-labelledby="appsDropdown"
                     style="min-width:800px;padding:20px;left:0;border-radius:18px;margin-top:8px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0;">

                        <!-- Column 1 -->
                        <div style="padding-right:16px;border-right:1px solid var(--border);">
                            <div style="font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:var(--text-muted);margin-bottom:10px;padding:0 8px;">
                                <i class="fa-solid fa-gear" style="margin-right:4px;opacity:.6;"></i> Supply &amp; Automation
                            </div>
                            <?php foreach ([
                                [15,'fa-satellite-dish','warning','Supplier Pusher'],
                                [16,'fa-truck-fast',    'success','Auto Dispatch'],
                                [20,'fa-warehouse',     'brand',  'Warehouses &amp; POs'],
                                [17,'fa-tags',          'brand',  'Dynamic Repricer'],
                                [18,'fa-star',          'warning','Social Reviews'],
                                [19,'fa-cart-shopping', 'danger', 'Cart Recovery'],
                                [14,'fa-credit-card',   'info',   'Gateways'],
                                [11,'fa-store',         'purple', 'Multi-Vendor'],
                            ] as [$nav_q,$icon,$c,$label]): ?>
                            <a class="dropdown-item <?= ($current_q===$nav_q)?'active':'' ?>" href="index.php?q=<?= $nav_q ?>">
                                <span style="width:24px;height:24px;border-radius:7px;background:<?= $colorMap[$c] ?>1a;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;margin-right:9px;">
                                    <i class="fa-solid <?= $icon ?>" style="font-size:0.68rem;color:<?= $colorMap[$c] ?>;"></i>
                                </span><?= $label ?>
                            </a>
                            <?php endforeach; ?>
                        </div>

                        <!-- Column 2 -->
                        <div style="padding:0 16px;border-right:1px solid var(--border);">
                            <div style="font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:var(--text-muted);margin-bottom:10px;padding:0 8px;">
                                <i class="fa-solid fa-rocket" style="margin-right:4px;opacity:.6;"></i> Business Models
                                <span style="background:var(--brand-light);color:var(--brand);border-radius:20px;padding:1px 6px;font-size:0.6rem;margin-left:3px;">11</span>
                            </div>
                            <?php foreach ([
                                [24,'fa-crown',          'warning','VIP Loyalty Tiers'],
                                [25,'fa-network-wired',  'success','3-Tier Affiliates'],
                                [26,'fa-bolt',           'danger', 'Flash Sales / FOMO'],
                                [27,'fa-boxes-stacked',  'purple', 'Bundles &amp; BOGO'],
                                [28,'fa-rotate',         'info',   'VIP Subscriptions'],
                                [29,'fa-people-group',   'pink',   'Social Group Buy'],
                                [30,'fa-dharmachakra',   'warning','Lucky Spin Wheel'],
                                [31,'fa-box-open',       'purple', 'Mystery Box Drops'],
                                [32,'fa-bell',           'orange', 'VIP Waitlist'],
                                [33,'fa-user-group',     'pink',   'Influencer &amp; UGC'],
                                [34,'fa-calendar-plus',  'teal',   'Pre-Order Studio'],
                            ] as [$nav_q,$icon,$c,$label]): ?>
                            <a class="dropdown-item <?= ($current_q===$nav_q)?'active':'' ?>" href="index.php?q=<?= $nav_q ?>">
                                <span style="width:24px;height:24px;border-radius:7px;background:<?= $colorMap[$c] ?>1a;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;margin-right:9px;">
                                    <i class="fa-solid <?= $icon ?>" style="font-size:0.68rem;color:<?= $colorMap[$c] ?>;"></i>
                                </span><?= $label ?>
                            </a>
                            <?php endforeach; ?>
                        </div>

                        <!-- Column 3 -->
                        <div style="padding-left:16px;">
                            <div style="font-size:0.65rem;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;color:var(--text-muted);margin-bottom:10px;padding:0 8px;">
                                <i class="fa-solid fa-chart-line" style="margin-right:4px;opacity:.6;"></i> Growth &amp; Catalog
                            </div>
                            <?php foreach ([
                                [21,'fa-bullhorn',                 'brand',  'AI Ad Studio'],
                                [22,'fa-magnifying-glass-dollar',  'success','SEO &amp; Feeds'],
                                [23,'fa-globe',                    'info',   'Multi-Currency'],
                                [7, 'fa-chart-line',               'brand',  'Analytics Studio'],
                                [5, 'fa-headphones',               'warning','Support &amp; Tickets'],
                                [6, 'fa-clock-rotate-left',        'info',   'Audit &amp; Activity'],
                                [8, 'fa-palette',                  'danger', 'Appearance &amp; CMS'],
                                [12,'fa-paper-plane',              'success','Email Marketing'],
                                [88,'fa-sliders',                  'brand',  'Home Settings'],
                            ] as [$nav_q,$icon,$c,$label]): ?>
                            <a class="dropdown-item <?= ($current_q===$nav_q)?'active':'' ?>" href="index.php?q=<?= $nav_q ?>">
                                <span style="width:24px;height:24px;border-radius:7px;background:<?= $colorMap[$c] ?>1a;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;margin-right:9px;">
                                    <i class="fa-solid <?= $icon ?>" style="font-size:0.68rem;color:<?= $colorMap[$c] ?>;"></i>
                                </span><?= $label ?>
                            </a>
                            <?php endforeach; ?>
                        </div>

                    </div><!-- /grid -->
                </div><!-- /dropdown-menu -->
            </li>

        </ul><!-- /custom-navbar-nav -->

        <!-- Right Utilities -->
        <ul class="custom-navbar-nav ml-auto custom-navbar-right">

            <!-- Live Store -->
            <li class="nav-item">
                <a href="../shop" target="_blank" rel="noopener" class="btn-live-store" title="Open live storefront">
                    <span class="live-indicator-dot"></span>
                    <span class="d-none d-lg-inline">Live Store</span>
                    <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.65rem;opacity:.7;"></i>
                </a>
            </li>

            <!-- Notifications -->
            <li class="nav-item">
                <button class="theme-toggle-btn" style="position:relative;" onclick="ndToast('No new notifications', 'info', 2000)" title="Notifications">
                    <i class="fa-solid fa-bell"></i>
                    <span aria-hidden="true" style="position:absolute;top:7px;right:7px;width:6px;height:6px;border-radius:50%;background:var(--danger);border:1.5px solid var(--bg-surface);"></span>
                </button>
            </li>

            <!-- Theme Toggle -->
            <li class="nav-item">
                <button class="theme-toggle-btn" onclick="toggleMode()" title="Toggle dark/light mode (press T)">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </li>

            <!-- Admin Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle admin-profile-pill" href="#" id="userDropdown"
                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="admin-avatar"><?= strtoupper(substr($admin_name,0,2)) ?></div>
                    <span class="d-none d-xl-inline admin-profile-name"><?= htmlspecialchars(ucfirst($admin_name)) ?></span>
                    <i class="fa-solid fa-chevron-down" style="font-size:0.58rem;color:var(--text-muted);"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown" style="min-width:230px;">
                    <div style="padding:12px 14px 14px;border-bottom:1px solid var(--border);margin-bottom:6px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--brand),var(--brand-3));color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.82rem;box-shadow:0 4px 12px var(--brand-glow);">
                                <?= strtoupper(substr($admin_name,0,2)) ?>
                            </div>
                            <div>
                                <div style="font-weight:700;font-size:0.88rem;color:var(--text-primary);"><?= htmlspecialchars(ucfirst($admin_name)) ?></div>
                                <div style="font-size:0.72rem;color:var(--text-muted);">Super Administrator</div>
                            </div>
                        </div>
                        <div style="margin-top:10px;">
                            <span style="display:inline-flex;align-items:center;gap:4px;font-size:0.7rem;font-weight:650;color:#059669;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);border-radius:20px;padding:3px 9px;">
                                <span style="width:5px;height:5px;border-radius:50%;background:#10b981;box-shadow:0 0 4px #10b981;"></span>
                                Online &middot; Active
                            </span>
                        </div>
                    </div>
                    <a class="dropdown-item" href="index.php?q=9&step=1">
                        <i class="fa-solid fa-user-gear" style="color:var(--brand);width:16px;margin-right:9px;"></i>Team Settings
                    </a>
                    <a class="dropdown-item" href="index.php?q=6">
                        <i class="fa-solid fa-clock-rotate-left" style="color:var(--info);width:16px;margin-right:9px;"></i>Activity Trail
                    </a>
                    <a class="dropdown-item" href="index.php?q=0">
                        <i class="fa-solid fa-gauge-high" style="color:var(--success);width:16px;margin-right:9px;"></i>Dashboard
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php?type=admin"
                       style="color:var(--danger)!important;font-weight:600!important;"
                       onclick="return confirm('Sign out of NovaDrop?');">
                        <i class="fa-solid fa-right-from-bracket" style="width:16px;margin-right:9px;"></i>Sign Out
                    </a>
                </div>
            </li>

        </ul><!-- /custom-navbar-right -->
    </div><!-- /navbar-collapse -->
</nav>

<script>
// Press T to toggle dark mode (when not typing)
document.addEventListener('keydown', function(e) {
    const tag = document.activeElement ? document.activeElement.tagName : '';
    if (e.key === 't' && !e.ctrlKey && !e.altKey && !e.metaKey && tag !== 'INPUT' && tag !== 'TEXTAREA' && tag !== 'SELECT') {
        if (typeof toggleMode === 'function') toggleMode();
    }
});
</script>
