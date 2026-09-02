<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
<title><?= htmlspecialchars($title ?? 'NovaDrop Commerce · Command Center') ?></title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" href="<?= base_url('assets/img/blogor.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
<style>
  :root {
    --nd-admin-bg: #f8fafc;
    --nd-admin-card: #ffffff;
    --nd-admin-ink: #0f172a;
    --nd-admin-muted: #64748b;
    --nd-admin-primary: #4f46e5;
    --nd-admin-accent: #d97706;
    --nd-admin-border: #e2e8f0;
  }
  html, body {
    overflow-x: hidden !important;
    max-width: 100vw !important;
    width: 100% !important;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: var(--nd-admin-bg);
    color: var(--nd-admin-ink);
    min-height: 100vh;
  }
  /* Modern Luxury Executive Navbar */
  .admin-header-nav {
    background: #ffffff;
    border-bottom: 1px solid var(--nd-admin-border);
    padding: 0.35rem 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 12px rgba(0, 0, 0, 0.02);
    position: sticky;
    top: 0;
    z-index: 1030;
    width: 100%;
  }
  .admin-header-nav .container-fluid {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
    max-width: 1440px;
  }
  .dark-mode .admin-header-nav {
    background: #1e293b;
    border-bottom-color: #334155;
  }
  .brand-logo-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
    text-decoration: none !important;
    flex-shrink: 0;
  }
  .brand-logo-text {
    font-family: 'Playfair Display', Georgia, serif;
    font-weight: 700;
    font-size: 1.1rem;
    letter-spacing: 0.03em;
    color: #1e293b;
    white-space: nowrap;
  }
  .dark-mode .brand-logo-text { color: #f8fafc; }
  .badge-admin-portal {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #ffffff;
    font-size: 0.58rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 1px 4px;
    border-radius: 4px;
  }
  /* Nav Dropdowns - Compact & Sleek */
  .admin-nav-item .nav-link {
    font-size: 0.78rem;
    font-weight: 600;
    color: #475569 !important;
    padding: 0.28rem 0.42rem !important;
    border-radius: 6px;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
    gap: 3px;
    white-space: nowrap;
  }
  .admin-nav-item .nav-link:hover,
  .admin-nav-item.active .nav-link {
    color: #4f46e5 !important;
    background: #f1f5f9;
  }
  .dark-mode .admin-nav-item .nav-link { color: #cbd5e1 !important; }
  .dark-mode .admin-nav-item .nav-link:hover { color: #ffffff !important; background: #334155; }
  .dropdown-menu-luxury {
    border: 1px solid var(--nd-admin-border);
    border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    padding: 8px;
    min-width: 220px;
    margin-top: 6px;
  }
  .dropdown-menu-luxury .dropdown-item {
    font-size: 0.80rem;
    font-weight: 500;
    padding: 6px 10px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #334155;
    transition: background-color 0.12s ease;
  }
  .dropdown-menu-luxury .dropdown-item:hover {
    background-color: #f1f5f9;
    color: #4f46e5;
  }
  .dropdown-menu-luxury .dropdown-item i {
    width: 16px;
    text-align: center;
    color: #64748b;
  }
  .dropdown-menu-luxury .dropdown-item:hover i { color: #4f46e5; }
  .dropdown-divider-luxury {
    margin: 5px 0;
    border-top: 1px solid var(--nd-admin-border);
  }
  /* Mobile Hamburger Button */
  .btn-admin-hamburger {
    background: #f1f5f9;
    border: 1px solid var(--nd-admin-border);
    color: #1e293b;
    border-radius: 8px;
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s ease;
    padding: 0;
    margin-right: 8px;
    flex-shrink: 0;
  }
  .dark-mode .btn-admin-hamburger {
    background: #334155;
    border-color: #475569;
    color: #f8fafc;
  }
  .btn-admin-hamburger:hover {
    background: #e2e8f0;
    color: #4f46e5;
  }
  /* Spotlight search button */
  .btn-spotlight {
    background: #f1f5f9;
    border: 1px solid var(--nd-admin-border);
    border-radius: 20px;
    padding: 3px 8px;
    font-size: 0.74rem;
    font-weight: 500;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    transition: all 0.15s ease;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .btn-spotlight:hover {
    background: #e2e8f0;
    color: #1e293b;
  }
  .dark-mode .btn-spotlight {
    background: #334155;
    border-color: #475569;
    color: #cbd5e1;
  }
  .spotlight-kbd {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    padding: 1px 4px;
    font-size: 0.60rem;
    font-weight: 700;
    box-shadow: 0 1px 1px rgba(0,0,0,0.08);
  }
  .dark-mode .spotlight-kbd {
    background: #1e293b;
    border-color: #475569;
    color: #cbd5e1;
  }
  .view-store-link {
    font-size: 0.74rem;
    font-weight: 600;
    color: #475569 !important;
    padding: 3px 8px;
    border-radius: 20px;
    border: 1px solid var(--nd-admin-border);
    text-decoration: none !important;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .view-store-link:hover {
    background: #f1f5f9;
    color: #4f46e5 !important;
  }
  .dark-mode .view-store-link {
    border-color: #475569;
    color: #cbd5e1 !important;
  }
  .dark-mode .view-store-link:hover {
    background: #334155;
    color: #818cf8 !important;
  }
</style>
</head>
<body class="<?= isset($_SESSION['mode']) ? $_SESSION['mode'] : 'light-mode' ?>">

<!-- Top Modern Executive Command Bar -->
<?php
$seg2 = $this->uri->segment(2) ?: 'dashboard';
$seg3 = $this->uri->segment(3) ?: '';
?>
<header class="admin-header-nav">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-nowrap">
    
    <!-- Left: Mobile Hamburger & Brand Logo -->
    <div class="d-flex align-items-center flex-nowrap mr-2">
      <!-- Mobile Hamburger Button (Visible on < lg) -->
      <button class="btn-admin-hamburger d-lg-none" onclick="openAdminMobileDrawer()" aria-label="Open Mobile Navigation Menu" title="Open Menu">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Brand Logo Link -->
      <a href="<?= base_url('admin/dashboard') ?>" class="brand-logo-wrap mr-1 mr-xl-2">
        <img src="<?= base_url('assets/img/blogor.png') ?>" alt="Logo" style="height: 26px; width: 26px; object-fit: contain;">
        <span class="brand-logo-text d-none d-sm-inline">NOVADROP</span>
        <span class="badge-admin-portal">PRO</span>
      </a>

      <!-- Main Categorized Desktop Navigation (>= lg) -->
      <nav class="d-none d-lg-flex align-items-center flex-nowrap ml-1 ml-xl-2">
        <!-- 1. Home -->
        <div class="admin-nav-item mr-1 <?= ($seg2 === 'dashboard') ? 'active' : '' ?>">
          <a class="nav-link" href="<?= base_url('admin/dashboard') ?>" title="Home Dashboard">
            <i class="fas fa-home"></i> <span>Home</span>
          </a>
        </div>

        <!-- 2. Commerce Dropdown -->
        <div class="dropdown admin-nav-item mr-1 <?= in_array($seg2, ['products', 'orders', 'finance']) ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#" id="navCommerce" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-shopping-bag text-indigo-500"></i> <span>Commerce</span>
          </a>
          <div class="dropdown-menu dropdown-menu-luxury" aria-labelledby="navCommerce">
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">Catalog & Sales</h6>
            <a class="dropdown-item" href="<?= base_url('admin/products') ?>"><i class="fas fa-box-open"></i> All Products</a>
            <a class="dropdown-item" href="<?= base_url('admin/products/categories') ?>"><i class="fas fa-tags"></i> Collections & Categories</a>
            <a class="dropdown-item" href="<?= base_url('admin/products/inventory') ?>"><i class="fas fa-warehouse"></i> Inventory Stock Matrix</a>
            <a class="dropdown-item" href="<?= base_url('admin/products/import') ?>"><i class="fas fa-file-import"></i> CSV Catalog Importer</a>
            <a class="dropdown-item" href="<?= base_url('admin/products/reviews') ?>"><i class="fas fa-star-half-alt"></i> Reviews Moderation</a>
            <div class="dropdown-divider-luxury"></div>
            <a class="dropdown-item font-weight-bold" href="<?= base_url('admin/orders') ?>"><i class="fas fa-shopping-cart text-primary"></i> Customer Orders</a>
            <a class="dropdown-item" href="<?= base_url('admin/returns') ?>"><i class="fas fa-sync-alt text-warning"></i> Returns &amp; Exchanges</a>
            <a class="dropdown-item" href="<?= base_url('admin/finance') ?>"><i class="fas fa-credit-card"></i> Payments &amp; Captured Revenue</a>
          </div>
        </div>

        <!-- 3. Marketplace (Vendors) Dropdown -->
        <div class="dropdown admin-nav-item mr-1 <?= ($seg2 === 'vendors') ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#" id="navVendors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-store text-emerald-500"></i> <span>Vendors</span>
          </a>
          <div class="dropdown-menu dropdown-menu-luxury" aria-labelledby="navVendors">
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">Multi-Vendor Marketplace</h6>
            <a class="dropdown-item" href="<?= base_url('admin/vendors') ?>"><i class="fas fa-users-cog"></i> Manage Vendor Accounts</a>
            <a class="dropdown-item" href="<?= base_url('admin/vendors/payouts') ?>"><i class="fas fa-hand-holding-usd"></i> Seller Commissions & Payouts</a>
          </div>
        </div>

        <!-- 4. Customers Dropdown -->
        <div class="dropdown admin-nav-item mr-1 <?= in_array($seg2, ['customers', 'users', 'loyalty', 'subscriptions', 'affiliates', 'cart_recovery', 'recovery']) ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#" id="navCustomers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-users text-sky-500"></i> <span>Customers</span>
          </a>
          <div class="dropdown-menu dropdown-menu-luxury" aria-labelledby="navCustomers">
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">Customer Growth</h6>
            <a class="dropdown-item" href="<?= base_url('admin/customers') ?>"><i class="fas fa-user-friends"></i> Customer Directory (360)</a>
            <a class="dropdown-item" href="<?= base_url('admin/loyalty') ?>"><i class="fas fa-crown text-warning"></i> Loyalty Program & VIP Tiers</a>
            <a class="dropdown-item" href="<?= base_url('admin/loyalty/spin_wheels') ?>"><i class="fas fa-dharmachakra"></i> Gamified Spin Wheels</a>
            <a class="dropdown-item" href="<?= base_url('admin/loyalty/badges') ?>"><i class="fas fa-medal text-warning"></i> Badges & Streak Rewards</a>
            <div class="dropdown-divider-luxury"></div>
            <a class="dropdown-item" href="<?= base_url('admin/subscriptions') ?>"><i class="fas fa-sync-alt text-success"></i> Membership Subscriptions</a>
            <a class="dropdown-item" href="<?= base_url('admin/affiliates') ?>"><i class="fas fa-handshake text-info"></i> Influencers & Affiliates</a>
            <a class="dropdown-item" href="<?= base_url('admin/cart_recovery') ?>"><i class="fas fa-undo text-danger"></i> Abandoned Cart Recovery</a>
          </div>
        </div>

        <!-- 5. Growth & Promos Dropdown -->
        <div class="dropdown admin-nav-item mr-1 <?= in_array($seg2, ['marketing', 'promotions']) ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#" id="navPromos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bolt text-amber-500"></i> <span>Promos</span>
          </a>
          <div class="dropdown-menu dropdown-menu-luxury" aria-labelledby="navPromos">
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">Autonomous Growth Studio</h6>
            <a class="dropdown-item" href="<?= base_url('admin/marketing') ?>"><i class="fas fa-bullhorn"></i> Marketing Hub</a>
            <a class="dropdown-item" href="<?= base_url('admin/marketing/discounts') ?>"><i class="fas fa-percentage"></i> Promo & Discount Codes</a>
            <a class="dropdown-item" href="<?= base_url('admin/marketing/seo_studio') ?>"><i class="fas fa-search-dollar"></i> SEO Studio & Meta Tags</a>
            <a class="dropdown-item" href="<?= base_url('admin/marketing/email_ai') ?>"><i class="fas fa-envelope-open-text"></i> AI Email Campaign Studio</a>
            <a class="dropdown-item" href="<?= base_url('admin/marketing/ad_generator') ?>"><i class="fas fa-ad"></i> AI Ad Copy Generator</a>
            <div class="dropdown-divider-luxury"></div>
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">Interactive Campaigns</h6>
            <a class="dropdown-item" href="<?= base_url('admin/promotions/ensembles') ?>"><i class="fas fa-tshirt text-amber-500"></i> ✦ Coordinated Ensemble Packs</a>
            <a class="dropdown-item" href="<?= base_url('admin/promotions/flash_sales') ?>"><i class="fas fa-bolt text-warning"></i> Flash Sales Engine</a>
            <a class="dropdown-item" href="<?= base_url('admin/promotions/bundles') ?>"><i class="fas fa-layer-group"></i> Mix-and-Match Bundles</a>
            <a class="dropdown-item" href="<?= base_url('admin/promotions/mystery_drops') ?>"><i class="fas fa-gift text-purple"></i> Mystery Blind Boxes</a>
            <a class="dropdown-item" href="<?= base_url('admin/promotions/pre_orders') ?>"><i class="fas fa-hourglass-start text-info"></i> Pre-Order Launchpad</a>
            <a class="dropdown-item" href="<?= base_url('admin/promotions/group_buying') ?>"><i class="fas fa-user-friends text-success"></i> Group Buying Campaigns</a>
          </div>
        </div>

        <!-- 6. AI Engine Dropdown -->
        <div class="dropdown admin-nav-item mr-1 <?= in_array($seg2, ['ai', 'ai_engine', 'aiengine']) ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle font-weight-bold text-primary" href="#" id="navAI" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-robot text-primary"></i> <span>AI Swarm</span>
          </a>
          <div class="dropdown-menu dropdown-menu-luxury" aria-labelledby="navAI">
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">Autonomous Swarm Mesh</h6>
            <a class="dropdown-item" href="<?= base_url('admin/ai') ?>"><i class="fas fa-microchip text-primary"></i> Agent Orchestrator & Task Queue</a>
            <a class="dropdown-item" href="<?= base_url('admin/ai/swarm') ?>"><i class="fas fa-network-wired"></i> 5-Agent Swarm Telemetry</a>
            <a class="dropdown-item" href="<?= base_url('admin/ai/repricer') ?>"><i class="fas fa-chart-line text-success"></i> Dynamic Elasticity Repricer</a>
            <a class="dropdown-item" href="<?= base_url('admin/ai/autopilot') ?>"><i class="fas fa-fighter-jet text-danger"></i> 24/7 Commerce Autopilot</a>
          </div>
        </div>

        <!-- 7. Intelligence & System Dropdown -->
        <div class="dropdown admin-nav-item mr-1 <?= in_array($seg2, ['analytics', 'reports', 'whatsapp', 'tickets', 'audit', 'activity', 'settings']) ? 'active' : '' ?>">
          <a class="nav-link dropdown-toggle" href="#" id="navSystem" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-chart-pie text-violet-500"></i> <span>Tools</span>
          </a>
          <div class="dropdown-menu dropdown-menu-luxury dropdown-menu-right" aria-labelledby="navSystem">
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">Analytics & Logs</h6>
            <a class="dropdown-item" href="<?= base_url('admin/analytics') ?>"><i class="fas fa-chart-bar text-primary"></i> Performance Reports & Trends</a>
            <a class="dropdown-item" href="<?= base_url('admin/whatsapp') ?>"><i class="fas fa-headset text-success"></i> Support Desk & Broadcasts</a>
            <a class="dropdown-item" href="<?= base_url('admin/audit') ?>"><i class="fas fa-shield-alt text-warning"></i> Security Audit & Event Stream</a>
            <div class="dropdown-divider-luxury"></div>
            <h6 class="dropdown-header text-uppercase font-weight-bold" style="font-size:0.68rem; letter-spacing:0.05em; color:#94a3b8;">System Configuration</h6>
            <a class="dropdown-item" href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog"></i> Storefront Settings & Theme</a>
            <a class="dropdown-item" href="<?= base_url('admin/settings/pages') ?>"><i class="fas fa-file-alt"></i> CMS Pages & Policies</a>
            <a class="dropdown-item" href="<?= base_url('admin/settings/faq') ?>"><i class="fas fa-question-circle"></i> FAQ Knowledge Base</a>
            <a class="dropdown-item" href="<?= base_url('admin/settings/announcements') ?>"><i class="fas fa-scroll"></i> Storefront Announcement Bar</a>
            <a class="dropdown-item" href="<?= base_url('admin/settings/health') ?>"><i class="fas fa-heartbeat text-danger"></i> System Diagnostics & Self-Healing</a>
          </div>
        </div>
      </nav>
    </div>

    <!-- Right: Quick Actions, Search, Live Store, Mode, Profile -->
    <div class="d-flex align-items-center gap-1 gap-sm-2 flex-nowrap ml-auto" style="flex-shrink: 0;">
      <!-- Quick Spotlight Search (Ctrl+K) Trigger (Large screens) -->
      <button class="btn-spotlight d-none d-md-inline-flex" onclick="openAdminSpotlight()" title="Search 50+ Features (Ctrl+K)">
        <i class="fas fa-search"></i>
        <span class="d-none d-xxl-inline">Quick Jump...</span>
        <span class="spotlight-kbd">Ctrl K</span>
      </button>

      <!-- Mobile Search Icon Button (< md) -->
      <button class="btn btn-sm btn-outline-secondary d-inline-flex d-md-none" onclick="openAdminSpotlight()" style="border-radius:20px; padding:3px 8px; font-size:0.75rem;" title="Search Features">
        <i class="fas fa-search"></i>
      </button>

      <!-- View Live Storefront Link -->
      <a href="<?= base_url('shop') ?>" target="_blank" class="view-store-link" title="Open Live Storefront in new tab">
        <i class="fas fa-external-link-alt"></i> <span class="d-none d-xl-inline ml-1">Live Store</span>
      </a>

      <!-- Dark / Light Mode Toggle -->
      <button class="btn btn-sm btn-outline-secondary" onclick="toggleMode()" style="border-radius:20px; padding:3px 7px; font-size:0.75rem;" title="Toggle Dark/Light Mode">
        🌓
      </button>

      <!-- Admin Profile & Logout -->
      <div class="dropdown flex-shrink-0">
        <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" id="adminProfileMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:20px; padding:3px 8px; font-size:0.76rem; font-weight:700; white-space:nowrap;">
          <i class="fas fa-user-shield text-primary"></i> <span class="ml-1">Admin</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-luxury shadow-lg" aria-labelledby="adminProfileMenu">
          <div class="px-3 py-2 border-bottom">
            <div class="font-weight-bold small text-dark">Super Administrator</div>
            <div class="text-muted small" style="font-size:0.75rem;">admin@novadrop.in</div>
          </div>
          <a class="dropdown-item mt-1" href="<?= base_url('admin/settings') ?>"><i class="fas fa-sliders-h"></i> System Settings</a>
          <a class="dropdown-item" href="<?= base_url('admin/settings/health') ?>"><i class="fas fa-stethoscope"></i> Diagnostics</a>
          <div class="dropdown-divider-luxury"></div>
          <a class="dropdown-item text-danger font-weight-bold" href="<?= base_url('admin/logout') ?>"><i class="fas fa-sign-out-alt text-danger"></i> Log Out</a>
        </div>
      </div>
    </div>

  </div>
</header>

<!-- ── Offcanvas Mobile Navigation Drawer & Backdrop ── -->
<div class="admin-mobile-backdrop" id="adminMobileBackdrop" onclick="closeAdminMobileDrawer()"></div>

<div class="admin-mobile-drawer" id="adminMobileDrawer">
  <!-- Drawer Header -->
  <div class="admin-drawer-header">
    <div class="d-flex align-items-center gap-2">
      <img src="<?= base_url('assets/img/blogor.png') ?>" alt="Logo" style="height: 28px; width: 28px; object-fit: contain;">
      <span class="brand-logo-text" style="font-size: 1.1rem;">NOVADROP</span>
      <span class="badge-admin-portal">PRO</span>
    </div>
    <button type="button" class="btn btn-sm btn-light border-0 rounded-circle" onclick="closeAdminMobileDrawer()" style="width:32px; height:32px; padding:0;">
      <i class="fas fa-times"></i>
    </button>
  </div>

  <!-- Drawer Body Navigation -->
  <div class="admin-drawer-body">
    <!-- Quick Search Input Trigger -->
    <div class="mb-3">
      <button class="btn btn-block text-left btn-light border d-flex align-items-center justify-content-between py-2 px-3 text-muted" style="border-radius: 10px; font-size: 0.84rem;" onclick="closeAdminMobileDrawer(); openAdminSpotlight();">
        <span><i class="fas fa-search mr-2 text-primary"></i> Search 50+ Features...</span>
        <span class="badge badge-secondary" style="font-size: 0.65rem;">Ctrl K</span>
      </button>
    </div>

    <!-- Group 1: Dashboard Home -->
    <div class="mobile-nav-group">
      <a href="<?= base_url('admin/dashboard') ?>" class="mobile-nav-header <?= ($seg2 === 'dashboard') ? 'active' : '' ?>">
        <span><i class="fas fa-home text-primary mr-2"></i> Home Dashboard</span>
        <i class="fas fa-arrow-right text-muted" style="font-size: 0.7rem;"></i>
      </a>
    </div>

    <!-- Group 2: Commerce & Catalog -->
    <div class="mobile-nav-group">
      <button class="mobile-nav-header <?= in_array($seg2, ['products', 'orders', 'finance']) ? 'active' : '' ?>" type="button" data-toggle="collapse" data-target="#mobNavCommerce" aria-expanded="<?= in_array($seg2, ['products', 'orders', 'finance']) ? 'true' : 'false' ?>">
        <span><i class="fas fa-shopping-bag text-indigo-500 mr-2"></i> Commerce & Sales</span>
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="collapse <?= in_array($seg2, ['products', 'orders', 'finance']) ? 'show' : '' ?>" id="mobNavCommerce">
        <div class="mobile-nav-subitems">
          <a href="<?= base_url('admin/products') ?>" class="mobile-sub-link <?= ($seg2 === 'products' && empty($seg3)) ? 'active' : '' ?>"><i class="fas fa-box-open"></i> All Products</a>
          <a href="<?= base_url('admin/products/categories') ?>" class="mobile-sub-link <?= ($seg2 === 'products' && $seg3 === 'categories') ? 'active' : '' ?>"><i class="fas fa-tags"></i> Collections & Categories</a>
          <a href="<?= base_url('admin/products/inventory') ?>" class="mobile-sub-link <?= ($seg2 === 'products' && ($seg3 === 'inventory' || $seg3 === 'stock')) ? 'active' : '' ?>"><i class="fas fa-warehouse"></i> Inventory Stock Matrix</a>
          <a href="<?= base_url('admin/products/import') ?>" class="mobile-sub-link <?= ($seg2 === 'products' && $seg3 === 'import') ? 'active' : '' ?>"><i class="fas fa-file-import"></i> CSV Catalog Importer</a>
          <a href="<?= base_url('admin/products/reviews') ?>" class="mobile-sub-link <?= ($seg2 === 'products' && $seg3 === 'reviews') ? 'active' : '' ?>"><i class="fas fa-star-half-alt"></i> Reviews Moderation</a>
          <a href="<?= base_url('admin/orders') ?>" class="mobile-sub-link <?= ($seg2 === 'orders') ? 'active' : '' ?>"><i class="fas fa-shopping-cart text-primary"></i> Customer Orders</a>
          <a href="<?= base_url('admin/finance') ?>" class="mobile-sub-link <?= ($seg2 === 'finance') ? 'active' : '' ?>"><i class="fas fa-credit-card text-success"></i> Captured Revenue</a>
        </div>
      </div>
    </div>

    <!-- Group 3: Multi-Vendor Marketplace -->
    <div class="mobile-nav-group">
      <button class="mobile-nav-header <?= ($seg2 === 'vendors') ? 'active' : '' ?>" type="button" data-toggle="collapse" data-target="#mobNavVendors" aria-expanded="<?= ($seg2 === 'vendors') ? 'true' : 'false' ?>">
        <span><i class="fas fa-store text-emerald-500 mr-2"></i> Vendors & Payouts</span>
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="collapse <?= ($seg2 === 'vendors') ? 'show' : '' ?>" id="mobNavVendors">
        <div class="mobile-nav-subitems">
          <a href="<?= base_url('admin/vendors') ?>" class="mobile-sub-link <?= ($seg2 === 'vendors' && empty($seg3)) ? 'active' : '' ?>"><i class="fas fa-users-cog"></i> Manage Vendor Accounts</a>
          <a href="<?= base_url('admin/vendors/payouts') ?>" class="mobile-sub-link <?= ($seg2 === 'vendors' && $seg3 === 'payouts') ? 'active' : '' ?>"><i class="fas fa-hand-holding-usd text-emerald-500"></i> Seller Commissions & Payouts</a>
        </div>
      </div>
    </div>

    <!-- Group 4: Customers & VIP Growth -->
    <div class="mobile-nav-group">
      <button class="mobile-nav-header <?= in_array($seg2, ['customers', 'users', 'loyalty', 'subscriptions', 'affiliates', 'cart_recovery', 'recovery']) ? 'active' : '' ?>" type="button" data-toggle="collapse" data-target="#mobNavCustomers" aria-expanded="<?= in_array($seg2, ['customers', 'loyalty', 'subscriptions', 'affiliates', 'cart_recovery']) ? 'true' : 'false' ?>">
        <span><i class="fas fa-users text-sky-500 mr-2"></i> Customers & VIP</span>
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="collapse <?= in_array($seg2, ['customers', 'users', 'loyalty', 'subscriptions', 'affiliates', 'cart_recovery', 'recovery']) ? 'show' : '' ?>" id="mobNavCustomers">
        <div class="mobile-nav-subitems">
          <a href="<?= base_url('admin/customers') ?>" class="mobile-sub-link <?= ($seg2 === 'customers') ? 'active' : '' ?>"><i class="fas fa-user-friends"></i> Customer 360 Directory</a>
          <a href="<?= base_url('admin/loyalty') ?>" class="mobile-sub-link <?= ($seg2 === 'loyalty' && empty($seg3)) ? 'active' : '' ?>"><i class="fas fa-crown text-warning"></i> Loyalty Points & Tiers</a>
          <a href="<?= base_url('admin/loyalty/spin_wheels') ?>" class="mobile-sub-link <?= ($seg2 === 'loyalty' && ($seg3 === 'spin_wheels' || $seg3 === 'gamification')) ? 'active' : '' ?>"><i class="fas fa-dharmachakra"></i> Gamified Spin Wheels</a>
          <a href="<?= base_url('admin/loyalty/gamification') ?>" class="mobile-sub-link"><i class="fas fa-medal text-warning"></i> Badges & Streaks</a>
          <a href="<?= base_url('admin/subscriptions') ?>" class="mobile-sub-link <?= ($seg2 === 'subscriptions') ? 'active' : '' ?>"><i class="fas fa-sync-alt text-success"></i> Membership Subscriptions</a>
          <a href="<?= base_url('admin/affiliates') ?>" class="mobile-sub-link <?= ($seg2 === 'affiliates') ? 'active' : '' ?>"><i class="fas fa-handshake text-info"></i> Influencers & Affiliates</a>
          <a href="<?= base_url('admin/cart_recovery') ?>" class="mobile-sub-link <?= in_array($seg2, ['cart_recovery', 'recovery']) ? 'active' : '' ?>"><i class="fas fa-undo text-danger"></i> Cart Recovery Funnels</a>
        </div>
      </div>
    </div>

    <!-- Group 5: Growth & Interactive Promos -->
    <div class="mobile-nav-group">
      <button class="mobile-nav-header <?= in_array($seg2, ['marketing', 'promotions']) ? 'active' : '' ?>" type="button" data-toggle="collapse" data-target="#mobNavPromos" aria-expanded="<?= in_array($seg2, ['marketing', 'promotions']) ? 'true' : 'false' ?>">
        <span><i class="fas fa-bolt text-amber-500 mr-2"></i> Growth & Promos</span>
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="collapse <?= in_array($seg2, ['marketing', 'promotions']) ? 'show' : '' ?>" id="mobNavPromos">
        <div class="mobile-nav-subitems">
          <a href="<?= base_url('admin/marketing') ?>" class="mobile-sub-link <?= ($seg2 === 'marketing' && empty($seg3)) ? 'active' : '' ?>"><i class="fas fa-bullhorn"></i> Marketing Hub</a>
          <a href="<?= base_url('admin/marketing/discounts') ?>" class="mobile-sub-link <?= ($seg2 === 'marketing' && $seg3 === 'discounts') ? 'active' : '' ?>"><i class="fas fa-percentage text-amber-500"></i> Promo & Discount Codes</a>
          <a href="<?= base_url('admin/marketing/seo_studio') ?>" class="mobile-sub-link <?= ($seg2 === 'marketing' && $seg3 === 'seo_studio') ? 'active' : '' ?>"><i class="fas fa-search-dollar"></i> SEO Studio & Meta Tags</a>
          <a href="<?= base_url('admin/marketing/email_ai') ?>" class="mobile-sub-link <?= ($seg2 === 'marketing' && $seg3 === 'email_ai') ? 'active' : '' ?>"><i class="fas fa-envelope-open-text"></i> AI Email Studio</a>
          <a href="<?= base_url('admin/marketing/ad_generator') ?>" class="mobile-sub-link <?= ($seg2 === 'marketing' && $seg3 === 'ad_generator') ? 'active' : '' ?>"><i class="fas fa-ad"></i> AI Ad Generator</a>
          <a href="<?= base_url('admin/promotions/ensembles') ?>" class="mobile-sub-link <?= ($seg2 === 'promotions' && $seg3 === 'ensembles') ? 'active' : '' ?>"><i class="fas fa-tshirt text-amber-500"></i> ✦ Coordinated Ensemble Packs</a>
          <a href="<?= base_url('admin/promotions/flash_sales') ?>" class="mobile-sub-link <?= ($seg2 === 'promotions' && $seg3 === 'flash_sales') ? 'active' : '' ?>"><i class="fas fa-bolt text-warning"></i> Flash Sales Engine</a>
          <a href="<?= base_url('admin/promotions/bundles') ?>" class="mobile-sub-link <?= ($seg2 === 'promotions' && $seg3 === 'bundles') ? 'active' : '' ?>"><i class="fas fa-layer-group"></i> Mix-and-Match Bundles</a>
          <a href="<?= base_url('admin/promotions/mystery_drops') ?>" class="mobile-sub-link <?= ($seg2 === 'promotions' && $seg3 === 'mystery_drops') ? 'active' : '' ?>"><i class="fas fa-gift text-purple"></i> Mystery Blind Boxes</a>
          <a href="<?= base_url('admin/promotions/pre_orders') ?>" class="mobile-sub-link <?= ($seg2 === 'promotions' && $seg3 === 'pre_orders') ? 'active' : '' ?>"><i class="fas fa-hourglass-start text-info"></i> Pre-Order Launchpad</a>
          <a href="<?= base_url('admin/promotions/group_buying') ?>" class="mobile-sub-link <?= ($seg2 === 'promotions' && $seg3 === 'group_buying') ? 'active' : '' ?>"><i class="fas fa-user-friends text-success"></i> Group Buying Campaigns</a>
        </div>
      </div>
    </div>

    <!-- Group 6: Autonomous AI Engine -->
    <div class="mobile-nav-group">
      <button class="mobile-nav-header <?= in_array($seg2, ['ai', 'ai_engine', 'aiengine']) ? 'active' : '' ?>" type="button" data-toggle="collapse" data-target="#mobNavAI" aria-expanded="<?= in_array($seg2, ['ai', 'ai_engine', 'aiengine']) ? 'true' : 'false' ?>">
        <span><i class="fas fa-robot text-primary mr-2"></i> AI Swarm Engine</span>
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="collapse <?= in_array($seg2, ['ai', 'ai_engine', 'aiengine']) ? 'show' : '' ?>" id="mobNavAI">
        <div class="mobile-nav-subitems">
          <a href="<?= base_url('admin/ai') ?>" class="mobile-sub-link <?= (in_array($seg2, ['ai', 'ai_engine', 'aiengine']) && empty($seg3)) ? 'active' : '' ?>"><i class="fas fa-microchip text-primary"></i> Agent Orchestrator</a>
          <a href="<?= base_url('admin/ai/swarm') ?>" class="mobile-sub-link <?= (in_array($seg2, ['ai', 'ai_engine', 'aiengine']) && $seg3 === 'swarm') ? 'active' : '' ?>"><i class="fas fa-network-wired"></i> 5-Agent Telemetry</a>
          <a href="<?= base_url('admin/ai/repricer') ?>" class="mobile-sub-link <?= (in_array($seg2, ['ai', 'ai_engine', 'aiengine']) && $seg3 === 'repricer') ? 'active' : '' ?>"><i class="fas fa-chart-line text-success"></i> Dynamic Repricer</a>
          <a href="<?= base_url('admin/ai/autopilot') ?>" class="mobile-sub-link <?= (in_array($seg2, ['ai', 'ai_engine', 'aiengine']) && $seg3 === 'autopilot') ? 'active' : '' ?>"><i class="fas fa-fighter-jet text-danger"></i> 24/7 Autopilot Loop</a>
        </div>
      </div>
    </div>

    <!-- Group 7: Intelligence & System Configuration -->
    <div class="mobile-nav-group">
      <button class="mobile-nav-header <?= in_array($seg2, ['analytics', 'reports', 'whatsapp', 'tickets', 'audit', 'activity', 'settings']) ? 'active' : '' ?>" type="button" data-toggle="collapse" data-target="#mobNavSystem" aria-expanded="<?= in_array($seg2, ['analytics', 'whatsapp', 'audit', 'settings']) ? 'true' : 'false' ?>">
        <span><i class="fas fa-chart-pie text-violet-500 mr-2"></i> Intelligence & Tools</span>
        <i class="fas fa-chevron-down chevron"></i>
      </button>
      <div class="collapse <?= in_array($seg2, ['analytics', 'reports', 'whatsapp', 'tickets', 'audit', 'activity', 'settings']) ? 'show' : '' ?>" id="mobNavSystem">
        <div class="mobile-nav-subitems">
          <a href="<?= base_url('admin/analytics') ?>" class="mobile-sub-link <?= in_array($seg2, ['analytics', 'reports']) ? 'active' : '' ?>"><i class="fas fa-chart-bar text-primary"></i> Analytics & Trends</a>
          <a href="<?= base_url('admin/whatsapp') ?>" class="mobile-sub-link <?= in_array($seg2, ['whatsapp', 'tickets']) ? 'active' : '' ?>"><i class="fas fa-headset text-success"></i> Support Desk & Broadcasts</a>
          <a href="<?= base_url('admin/audit') ?>" class="mobile-sub-link <?= in_array($seg2, ['audit', 'activity']) ? 'active' : '' ?>"><i class="fas fa-shield-alt text-warning"></i> Security Audit Trail</a>
          <a href="<?= base_url('admin/settings') ?>" class="mobile-sub-link <?= ($seg2 === 'settings' && empty($seg3)) ? 'active' : '' ?>"><i class="fas fa-cog"></i> Store Settings & Theme</a>
          <a href="<?= base_url('admin/settings/pages') ?>" class="mobile-sub-link <?= ($seg2 === 'settings' && $seg3 === 'pages') ? 'active' : '' ?>"><i class="fas fa-file-alt"></i> CMS Pages & Policies</a>
          <a href="<?= base_url('admin/settings/faq') ?>" class="mobile-sub-link <?= ($seg2 === 'settings' && $seg3 === 'faq') ? 'active' : '' ?>"><i class="fas fa-question-circle"></i> FAQ Knowledge Base</a>
          <a href="<?= base_url('admin/settings/announcements') ?>" class="mobile-sub-link <?= ($seg2 === 'settings' && $seg3 === 'announcements') ? 'active' : '' ?>"><i class="fas fa-scroll"></i> Announcement Bar</a>
          <a href="<?= base_url('admin/settings/health') ?>" class="mobile-sub-link <?= ($seg2 === 'settings' && $seg3 === 'health') ? 'active' : '' ?>"><i class="fas fa-heartbeat text-danger"></i> System Diagnostics</a>
        </div>
      </div>
    </div>

    <!-- Direct Quick Store & Theme Actions -->
    <div class="pt-3 border-top mt-3 d-flex gap-2">
      <a href="<?= base_url('shop') ?>" target="_blank" class="btn btn-sm btn-outline-primary btn-block text-center font-weight-bold py-2" style="border-radius: 8px;">
        <i class="fas fa-external-link-alt mr-1"></i> Live Store ↗
      </a>
      <button class="btn btn-sm btn-outline-secondary py-2 px-3" onclick="toggleMode()" style="border-radius: 8px;" title="Toggle Dark/Light Mode">
        🌓
      </button>
    </div>
  </div>

  <!-- Drawer Footer -->
  <div class="admin-drawer-footer">
    <div class="d-flex align-items-center gap-2">
      <div style="width:32px; height:32px; border-radius:50%; background:#e0e7ff; color:#4338ca; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.75rem;">
        <i class="fas fa-user-shield"></i>
      </div>
      <div>
        <div class="font-weight-bold small text-dark" style="font-size: 0.8rem;">Super Admin</div>
        <div class="text-muted" style="font-size: 0.7rem;">admin@novadrop.in</div>
      </div>
    </div>
    <a href="<?= base_url('admin/logout') ?>" class="btn btn-sm btn-outline-danger font-weight-bold px-2 py-1" style="border-radius: 6px; font-size: 0.75rem;">
      <i class="fas fa-sign-out-alt mr-1"></i> Exit
    </a>
  </div>
</div>

<!-- ── Ergonomic Bottom Mobile Navigation Bar (< 768px) ── -->
<nav class="admin-mobile-bottom-bar" aria-label="Mobile Navigation">
  <a href="<?= base_url('admin/dashboard') ?>" class="admin-bottom-tab <?= ($seg2 === 'dashboard') ? 'active' : '' ?>">
    <i class="fas fa-home"></i>
    <span>Home</span>
  </a>
  <a href="<?= base_url('admin/products') ?>" class="admin-bottom-tab <?= in_array($seg2, ['products', 'orders']) ? 'active' : '' ?>">
    <i class="fas fa-shopping-bag"></i>
    <span>Commerce</span>
  </a>
  <a href="<?= base_url('admin/promotions') ?>" class="admin-bottom-tab <?= in_array($seg2, ['marketing', 'promotions']) ? 'active' : '' ?>">
    <i class="fas fa-bolt"></i>
    <span>Promos</span>
  </a>
  <a href="<?= base_url('admin/ai') ?>" class="admin-bottom-tab <?= in_array($seg2, ['ai', 'ai_engine', 'aiengine']) ? 'active' : '' ?>">
    <i class="fas fa-robot"></i>
    <span>AI Swarm</span>
  </a>
  <button type="button" class="admin-bottom-tab border-0 bg-transparent" onclick="openAdminMobileDrawer()" aria-label="Open Full Menu">
    <i class="fas fa-th-large"></i>
    <span>Menu</span>
  </button>
</nav>

<main class="admin-main-content container-fluid px-3 px-md-4 py-3 py-md-4" style="max-width: 1440px; margin: 0 auto;">
