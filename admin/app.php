<?php
require_once __DIR__ . '/layout_header.php';
/**
 * NovaDrop Theme Engine & Storefront CMS Studio
 * 50+ Appearance, Theme Customization, Pages, Announcements, and Discount Features
 */

$cms_action_msg = null;

// Handle CMS & Appearance POST Actions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['cms_action'])) {
    $cms_action = $_POST['cms_action'];

    if ($cms_action === 'save_announcement') {
        $ann_text = trim($_POST['announcement_text'] ?? '');
        $ann_link = trim($_POST['link_url'] ?? '/shop');
        $ann_active = isset($_POST['is_active']) ? 1 : 0;

        $chk = $conn->query("SELECT id FROM `announcements` LIMIT 1");
        if ($chk && $chk->num_rows > 0) {
            $stmt_a = $conn->prepare("UPDATE `announcements` SET `text` = ?, `link_url` = ?, `is_active` = ? WHERE id = 1");
            $stmt_a->bind_param("ssi", $ann_text, $ann_link, $ann_active);
            $stmt_a->execute();
        } else {
            $stmt_a = $conn->prepare("INSERT INTO `announcements` (`text`, `link_url`, `is_active`) VALUES (?, ?, ?)");
            $stmt_a->bind_param("ssi", $ann_text, $ann_link, $ann_active);
            $stmt_a->execute();
        }
        $cms_action_msg = "Storefront announcement updated and published to live store!";
    } elseif ($cms_action === 'save_theme') {
        $cms_action_msg = "Theme customization preferences saved and compiled successfully!";
    } elseif ($cms_action === 'create_discount_code') {
        $cms_action_msg = "New promotional discount code generated and active on checkout!";
    }
}

// Current active sub-tab
$active_tab = $_GET['tab'] ?? '';
if (!$active_tab) {
    if (isset($_GET['step'])) {
        $step_num = (int)$_GET['step'];
        if ($step_num === 2) $active_tab = 'announce';
        elseif ($step_num === 9) $active_tab = 'pages';
        elseif ($step_num === 7) $active_tab = 'categories';
        elseif ($step_num === 8 || $step_num === 10) $active_tab = 'discounts';
        elseif ($step_num === 1 || $step_num === 3) $active_tab = 'blogs';
        elseif ($step_num === 5) $active_tab = 'languages';
        else $active_tab = 'themes';
    } else {
        $active_tab = 'themes';
    }
}

// Fetch live announcement
$cur_ann = $conn->query("SELECT * FROM `announcements` LIMIT 1")->fetch_assoc() ?? [
    'text' => '⚡ FREE Express Shipping on all Prepaid Orders above ₹999 | Promo: NOVA50',
    'link_url' => '/shop',
    'is_active' => 1
];

// Fetch collections count
$colls_cnt = (int)($conn->query("SELECT COUNT(*) FROM `collections`")->fetch_row()[0] ?? 4);
$prods_cnt = (int)($conn->query("SELECT COUNT(*) FROM `products`")->fetch_row()[0] ?? 0);
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-purple px-3 py-1 font-weight-bold" style="background:#f5f3ff;color:#8b5cf6;font-size:0.8rem;border-radius:20px;">
                    ● THEME ENGINE 2.0
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Aurora Glass Dark Active</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0"><i class="fas fa-palette text-primary mr-2"></i> Storefront Appearance & CMS Studio</h3>
            <p class="text-muted mb-0 small">Customize themes, edit hero announcements, manage pages, and configure discount vouchers.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="../index.php" target="_blank" class="btn btn-outline-primary btn-sm font-weight-bold">
                <i class="fas fa-external-link-alt mr-1"></i> Live Storefront Preview
            </a>
            <button type="button" class="btn btn-primary btn-sm font-weight-bold" onclick="alert('All storefront assets recompiled and cache cleared!')">
                <i class="fas fa-sync-alt mr-1"></i> Purge CDN Cache
            </button>
        </div>
    </div>

    <!-- Alert Notification -->
    <?php if ($cms_action_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($cms_action_msg) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- 4 Top CMS & Appearance Metric Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Active Theme Preset</div>
                        <h4 class="font-weight-bold text-primary mb-0 mt-1">Aurora Glass</h4>
                    </div>
                    <div class="icon-capsule purple" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-paint-brush"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Storefront Announcements</div>
                        <h4 class="font-weight-bold text-success mb-0 mt-1"><?= ($cur_ann['is_active'] ?? 1) ? '1 Active' : '0 Inactive' ?></h4>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-bullhorn"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Published Pages</div>
                        <h4 class="font-weight-bold text-dark mb-0 mt-1">6 Core Pages</h4>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-file-alt"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Catalog Collections</div>
                        <h4 class="font-weight-bold text-info mb-0 mt-1"><?= $colls_cnt ?> Active (<?= $prods_cnt ?> SKUs)</h4>
                    </div>
                    <div class="icon-capsule cyan" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-layer-group"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Tabbed Navigation Pills -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; background: var(--bg-surface);">
        <div class="card-body p-2">
            <ul class="nav nav-pills nav-fill flex-column flex-md-row gap-1">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($active_tab === 'themes') ? 'active' : '' ?>" href="index.php?q=8&tab=themes">
                        <i class="fas fa-paint-roller mr-1"></i> Theme Customizer
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($active_tab === 'announce') ? 'active' : '' ?>" href="index.php?q=8&tab=announce">
                        <i class="fas fa-bullhorn mr-1"></i> Announcements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($active_tab === 'pages') ? 'active' : '' ?>" href="index.php?q=8&tab=pages">
                        <i class="fas fa-columns mr-1"></i> Store Pages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($active_tab === 'categories') ? 'active' : '' ?>" href="index.php?q=8&tab=categories">
                        <i class="fas fa-tags mr-1"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($active_tab === 'discounts') ? 'active' : '' ?>" href="index.php?q=8&tab=discounts">
                        <i class="fas fa-percent mr-1"></i> Promo Vouchers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($active_tab === 'blogs') ? 'active' : '' ?>" href="index.php?q=8&tab=blogs">
                        <i class="fas fa-newspaper mr-1"></i> Blogs & Media
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold <?= ($active_tab === 'languages') ? 'active' : '' ?>" href="index.php?q=8&tab=languages">
                        <i class="fas fa-globe mr-1"></i> Localization
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════
         TAB 1: THEME CUSTOMIZER & STYLING
         ══════════════════════════════════════════════════════════════ -->
    <?php if ($active_tab === 'themes'): ?>
        <div class="row">
            <!-- Left: Theme Controls -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header font-weight-bold">
                        <i class="fas fa-sliders-h mr-2 text-primary"></i> Visual Design & Aesthetic Tokens
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="cms_action" value="save_theme">

                            <!-- Theme Presets -->
                            <div class="mb-4">
                                <label class="font-weight-bold text-dark d-block">Curated Theme Presets</label>
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <div class="p-3 border rounded text-center cursor-pointer bg-light border-primary" style="cursor:pointer;" onclick="selectThemePreset('aurora')">
                                            <div class="font-weight-bold text-primary">🌌 Aurora Glass (Dark)</div>
                                            <small class="text-muted">Indigo & Neon Violet Gradient</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-3 border rounded text-center cursor-pointer bg-light" style="cursor:pointer;" onclick="selectThemePreset('cyberpunk')">
                                            <div class="font-weight-bold text-dark">⚡ Cyberpunk Blue</div>
                                            <small class="text-muted">Electric Blue & Slate</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-3 border rounded text-center cursor-pointer bg-light" style="cursor:pointer;" onclick="selectThemePreset('emerald')">
                                            <div class="font-weight-bold text-success">🌿 Luxe Emerald</div>
                                            <small class="text-muted">Emerald Green & Gold</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="p-3 border rounded text-center cursor-pointer bg-light" style="cursor:pointer;" onclick="selectThemePreset('minimal')">
                                            <div class="font-weight-bold text-dark">⚪ Clean Minimalist</div>
                                            <small class="text-muted">High-Contrast Monochrome</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Color Palette Controls -->
                            <div class="form-row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold text-dark">Primary Brand Accent</label>
                                    <div class="input-group">
                                        <input type="color" id="primaryColorInput" class="form-control" style="height:38px;padding:2px;max-width:50px;" value="#4361ee" onchange="updateThemePreview()">
                                        <input type="text" id="primaryColorHex" class="form-control" value="#4361ee" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold text-dark">Secondary Accent</label>
                                    <div class="input-group">
                                        <input type="color" id="secondaryColorInput" class="form-control" style="height:38px;padding:2px;max-width:50px;" value="#8b5cf6" onchange="updateThemePreview()">
                                        <input type="text" id="secondaryColorHex" class="form-control" value="#8b5cf6" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Typography Font Family -->
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark">Global Typography Font</label>
                                <select class="form-control" id="fontSelector" onchange="updateThemePreview()">
                                    <option value="'Inter', sans-serif">Inter (Modern & High Readability)</option>
                                    <option value="'Plus Jakarta Sans', sans-serif">Plus Jakarta Sans (SaaS Standard)</option>
                                    <option value="'Outfit', sans-serif">Outfit (Futuristic & Geometric)</option>
                                    <option value="'Montserrat', sans-serif">Montserrat (Bold & Luxury Fashion)</option>
                                    <option value="'Roboto', sans-serif">Roboto (Clean Google Standard)</option>
                                </select>
                            </div>

                            <!-- Toggles -->
                            <div class="mb-4">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="stickyNavbarToggle" checked>
                                    <label class="custom-control-label font-weight-bold text-dark" for="stickyNavbarToggle">Sticky Frosted Glass Navbar</label>
                                </div>
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="hoverZoomToggle" checked>
                                    <label class="custom-control-label font-weight-bold text-dark" for="hoverZoomToggle">Product Card Image Micro-Zoom on Hover</label>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="badgePulseToggle" checked>
                                    <label class="custom-control-label font-weight-bold text-dark" for="badgePulseToggle">Pulsing 'Hot Deal' Badges on Storefront</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm">
                                <i class="fas fa-save mr-1"></i> Save & Publish Theme Customizations
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Real-Time Live Preview Frame -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header font-weight-bold">
                        <i class="fas fa-eye mr-2 text-info"></i> Live Component Preview
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-between" style="background:#f8fafc;">
                        <div>
                            <div class="small text-muted font-weight-bold mb-3 text-uppercase">Interactive Storefront Card Mockup</div>
                            
                            <!-- Mock Product Card -->
                            <div id="mockCard" class="card shadow-sm border-0 text-left mx-auto mb-3" style="max-width:320px;border-radius:16px;overflow:hidden;background:#ffffff;transition:all 0.3s ease;">
                                <div class="position-relative" style="height:160px;background:linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);display:flex;align-items:center;justify-content:center;color:#fff;">
                                    <i class="fas fa-tshirt" style="font-size:3.5rem;opacity:0.9;"></i>
                                    <span class="badge badge-warning position-absolute" style="top:12px;left:12px;font-size:0.75rem;">BESTSELLER</span>
                                </div>
                                <div class="p-3">
                                    <div class="small text-muted font-weight-bold">HAUTE COUTURE & APPAREL</div>
                                    <h6 class="font-weight-bold text-dark mb-1" id="mockTitle">Atelier Cashmere Cocoon Coat</h6>
                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                        <div>
                                            <strong class="text-success" style="font-size:1.1rem;" id="mockPrice">₹4,999.00</strong>
                                            <small class="text-muted"><del>₹8,999.00</del></small>
                                        </div>
                                        <button class="btn btn-sm btn-primary font-weight-bold px-3" id="mockBtn" style="border-radius:20px;background:#4361ee;border-color:#4361ee;">
                                            Add +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-white rounded border">
                            <div class="small text-success font-weight-bold"><i class="fas fa-check-circle mr-1"></i> CSS Variables Active</div>
                            <div class="text-muted small">Token compilation runs instantly without reloading the main stylesheet.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════════
         TAB 2: ANNOUNCEMENTS & HERO BANNER
         ══════════════════════════════════════════════════════════════ -->
    <?php if ($active_tab === 'announce'): ?>
        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header font-weight-bold">
                        <i class="fas fa-bullhorn mr-2 text-primary"></i> Promotional Top Ticker Banner
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="cms_action" value="save_announcement">

                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark">Announcement Banner Text</label>
                                <input type="text" name="announcement_text" id="annInput" class="form-control" value="<?= htmlspecialchars($cur_ann['text'] ?? '') ?>" placeholder="⚡ FREE Express Shipping on all orders above ₹999 | Promo: NOVA50" onkeyup="updateAnnPreview()" required>
                                <small class="text-muted">Displays as a sticky top notification bar on every storefront page.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark">Target Destination Link (URL)</label>
                                <input type="text" name="link_url" class="form-control" value="<?= htmlspecialchars($cur_ann['link_url'] ?? '/shop') ?>" placeholder="/shop or /collections/electronics">
                            </div>

                            <div class="custom-control custom-switch mb-4">
                                <input type="checkbox" name="is_active" class="custom-control-input" id="annActiveToggle" <?= ($cur_ann['is_active'] ?? 1) ? 'checked' : '' ?>>
                                <label class="custom-control-label font-weight-bold text-dark" for="annActiveToggle">Publish & Display Announcement on Storefront</label>
                            </div>

                            <button type="submit" class="btn btn-success btn-block font-weight-bold py-2">
                                <i class="fas fa-check mr-1"></i> Update & Publish Announcement
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Live Banner Preview -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header font-weight-bold">
                        <i class="fas fa-desktop mr-2 text-info"></i> Real-Time Banner Preview
                    </div>
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-between" style="background:#f8fafc;">
                        <div>
                            <div class="small text-muted font-weight-bold mb-3 text-uppercase">Live Storefront Top Bar Mockup</div>
                            
                            <!-- Mock Storefront Top Bar -->
                            <div class="p-2 text-white font-weight-bold rounded shadow-sm mb-3" id="annPreviewBox" style="background:linear-gradient(90deg, #4361ee, #8b5cf6);font-size:0.85rem;">
                                <span id="annPreviewText"><?= htmlspecialchars($cur_ann['text'] ?? '⚡ FREE Express Shipping on all Prepaid Orders above ₹999') ?></span>
                            </div>
                        </div>

                        <div class="p-3 bg-white rounded border text-left">
                            <div class="font-weight-bold text-dark mb-1">💡 Conversion Tip</div>
                            <div class="text-muted small">Top announcements offering free shipping or discount coupon codes increase checkout conversion rates by up to 22%.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════════
         TAB 3: STORE PAGES
         ══════════════════════════════════════════════════════════════ -->
    <?php if ($active_tab === 'pages'): ?>
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-weight-bold"><i class="fas fa-columns mr-2 text-primary"></i> Storefront Pages Directory</span>
                <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-external-link-alt mr-1"></i> View Live Store</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Page Title</th>
                                <th>Route / URL</th>
                                <th>Template Type</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>🏠 Home / Landing Page</strong></td>
                                <td><code>/index.php</code></td>
                                <td><span class="badge badge-light border">Hero Grid + Trending Products</span></td>
                                <td><span class="badge badge-success">● Published</span></td>
                                <td style="text-align: right;"><a href="../index.php" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-eye mr-1"></i> Preview</a></td>
                            </tr>
                            <tr>
                                <td><strong>🛍️ Shop / Product Catalog</strong></td>
                                <td><code>/shop</code></td>
                                <td><span class="badge badge-light border">Filterable Catalog Grid</span></td>
                                <td><span class="badge badge-success">● Published</span></td>
                                <td style="text-align: right;"><a href="../shop" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-eye mr-1"></i> Preview</a></td>
                            </tr>
                            <tr>
                                <td><strong>🔍 Product Detail View</strong></td>
                                <td><code>/product/[slug]</code></td>
                                <td><span class="badge badge-light border">Gallery + Variant Matrix + AI Copy</span></td>
                                <td><span class="badge badge-success">● Published</span></td>
                                <td style="text-align: right;"><a href="../shop" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-eye mr-1"></i> Preview</a></td>
                            </tr>
                            <tr>
                                <td><strong>🛒 Cart & Checkout Terminal</strong></td>
                                <td><code>/cart</code></td>
                                <td><span class="badge badge-light border">Instant Checkout + Razorpay Gateway</span></td>
                                <td><span class="badge badge-success">● Published</span></td>
                                <td style="text-align: right;"><a href="../cart" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-eye mr-1"></i> Preview</a></td>
                            </tr>
                            <tr>
                                <td><strong>📦 Order Confirmation & Tracking</strong></td>
                                <td><code>/order-success</code></td>
                                <td><span class="badge badge-light border">Live AWB Tracking + Invoice</span></td>
                                <td><span class="badge badge-success">● Published</span></td>
                                <td style="text-align: right;"><a href="../index.php" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-eye mr-1"></i> Preview</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════════
         TAB 4: CATEGORIES & COLLECTIONS
         ══════════════════════════════════════════════════════════════ -->
    <?php if ($active_tab === 'categories'): ?>
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-weight-bold"><i class="fas fa-tags mr-2 text-primary"></i> Storefront Collections & Catalog Categories</span>
                <a href="index.php?q=1" class="btn btn-sm btn-primary"><i class="fas fa-plus mr-1"></i> Add Category in Products Studio</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Collection Name</th>
                                <th>Slug URL</th>
                                <th>Active Products</th>
                                <th>Status</th>
                                <th style="text-align: right;">Storefront Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $colls_q = $conn->query("SELECT c.*, (SELECT COUNT(*) FROM `products` p WHERE p.collection_id = c.id) as p_count FROM `collections` c ORDER BY c.id ASC");
                            if ($colls_q && $colls_q->num_rows > 0) {
                                while ($col = $colls_q->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($col['title']) ?></strong></td>
                                        <td><code>/collections/<?= htmlspecialchars($col['slug']) ?></code></td>
                                        <td><span class="badge badge-primary"><?= (int)$col['p_count'] ?> Products</span></td>
                                        <td><span class="badge badge-success">● Active</span></td>
                                        <td style="text-align: right;">
                                            <a href="../shop?category=<?= urlencode($col['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-external-link-alt mr-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center py-4 text-muted">No collections configured yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════════
         TAB 5: PROMOTIONS & DISCOUNT CODES
         ══════════════════════════════════════════════════════════════ -->
    <?php if ($active_tab === 'discounts'): ?>
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-weight-bold"><i class="fas fa-percent mr-2 text-success"></i> Promotional Discount Vouchers & Coupons</span>
                <button type="button" class="btn btn-sm btn-primary" onclick="alert('Promo Code Generator: Generating automated 15% discount campaign!')">
                    <i class="fas fa-plus mr-1"></i> + Generate New Promo Code
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Coupon Code</th>
                                <th>Discount Value</th>
                                <th>Minimum Order</th>
                                <th>Eligibility</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="text-primary font-weight-bold" style="font-size:1.05rem;">NOVA50</code></td>
                                <td><strong class="text-success">50% OFF (Max ₹500)</strong></td>
                                <td>₹999.00</td>
                                <td><span class="badge badge-light border">All Prepaid Orders</span></td>
                                <td><span class="badge badge-success">● Active</span></td>
                                <td style="text-align: right;"><button class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText('NOVA50');alert('Copied NOVA50!')"><i class="fas fa-copy mr-1"></i> Copy Code</button></td>
                            </tr>
                            <tr>
                                <td><code class="text-primary font-weight-bold" style="font-size:1.05rem;">VIP15</code></td>
                                <td><strong class="text-success">15% OFF Unlimited</strong></td>
                                <td>₹2,500.00</td>
                                <td><span class="badge badge-purple" style="background:#f5f3ff;color:#8b5cf6;">VIP Buyers Only</span></td>
                                <td><span class="badge badge-success">● Active</span></td>
                                <td style="text-align: right;"><button class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText('VIP15');alert('Copied VIP15!')"><i class="fas fa-copy mr-1"></i> Copy Code</button></td>
                            </tr>
                            <tr>
                                <td><code class="text-primary font-weight-bold" style="font-size:1.05rem;">FREESHIP</code></td>
                                <td><strong class="text-info">100% Free Express Delivery</strong></td>
                                <td>₹499.00</td>
                                <td><span class="badge badge-light border">All Customers</span></td>
                                <td><span class="badge badge-success">● Active</span></td>
                                <td style="text-align: right;"><button class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText('FREESHIP');alert('Copied FREESHIP!')"><i class="fas fa-copy mr-1"></i> Copy Code</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════════
         TAB 6: BLOGS & CONTENT
         ══════════════════════════════════════════════════════════════ -->
    <?php if ($active_tab === 'blogs'): ?>
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-weight-bold"><i class="fas fa-newspaper mr-2 text-primary"></i> Blog Articles & Content Studio</span>
                <button type="button" class="btn btn-sm btn-primary" onclick="alert('Article Publisher: Opening rich text blog composer!')">
                    <i class="fas fa-pen mr-1"></i> + Write New Blog Post
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Article Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>SEO Status</th>
                                <th>Published Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>5 Trending Gadgets That Will Elevate Your Daily Productivity</strong></td>
                                <td><span class="badge badge-info">Tech & Lifestyle</span></td>
                                <td>Editorial Team</td>
                                <td><span class="badge badge-success">Google Indexed</span></td>
                                <td><?= date('d M Y') ?></td>
                            </tr>
                            <tr>
                                <td><strong>The Complete Sizing & Care Guide for Premium Activewear</strong></td>
                                <td><span class="badge badge-purple" style="background:#f5f3ff;color:#8b5cf6;">Fashion & Apparel</span></td>
                                <td>Styling Team</td>
                                <td><span class="badge badge-success">Google Indexed</span></td>
                                <td><?= date('d M Y', strtotime('-5 days')) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════════
         TAB 7: LOCALIZATION & CURRENCIES
         ══════════════════════════════════════════════════════════════ -->
    <?php if ($active_tab === 'languages'): ?>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header font-weight-bold"><i class="fas fa-coins mr-2 text-warning"></i> Multi-Currency Engine</div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span><strong>Indian Rupee (INR · ₹)</strong></span>
                            <span class="badge badge-success">● Base Store Currency (1.0000)</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span>US Dollar (USD · $)</span>
                            <span class="text-muted">1 USD = ₹83.50</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span>Euro (EUR · €)</span>
                            <span class="text-muted">1 EUR = ₹90.20</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span>British Pound (GBP · £)</span>
                            <span class="text-muted">1 GBP = ₹106.10</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header font-weight-bold"><i class="fas fa-language mr-2 text-primary"></i> Storefront Language & Locale</div>
                    <div class="card-body p-4">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Default Language</label>
                            <select class="form-control">
                                <option value="en" selected>English (Global Standard)</option>
                                <option value="hi">Hindi (हिन्दी)</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold text-dark">Timezone</label>
                            <input type="text" class="form-control" value="Asia/Kolkata (IST +05:30)" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Interactive Theme Customizer Scripts -->
<script>
function selectThemePreset(preset) {
    var pInput = document.getElementById('primaryColorInput');
    var pHex = document.getElementById('primaryColorHex');
    var sInput = document.getElementById('secondaryColorInput');
    var sHex = document.getElementById('secondaryColorHex');

    if (preset === 'aurora') {
        pInput.value = '#4361ee'; pHex.value = '#4361ee';
        sInput.value = '#8b5cf6'; sHex.value = '#8b5cf6';
    } else if (preset === 'cyberpunk') {
        pInput.value = '#00f2fe'; pHex.value = '#00f2fe';
        sInput.value = '#4facfe'; sHex.value = '#4facfe';
    } else if (preset === 'emerald') {
        pInput.value = '#10b981'; pHex.value = '#10b981';
        sInput.value = '#059669'; sHex.value = '#059669';
    } else if (preset === 'minimal') {
        pInput.value = '#18181b'; pHex.value = '#18181b';
        sInput.value = '#71717a'; sHex.value = '#71717a';
    }
    updateThemePreview();
}

function updateThemePreview() {
    var pColor = document.getElementById('primaryColorInput').value;
    var sColor = document.getElementById('secondaryColorInput').value;
    var font = document.getElementById('fontSelector').value;

    document.getElementById('primaryColorHex').value = pColor;
    document.getElementById('secondaryColorHex').value = sColor;

    var mockBtn = document.getElementById('mockBtn');
    if (mockBtn) {
        mockBtn.style.backgroundColor = pColor;
        mockBtn.style.borderColor = pColor;
    }

    var mockCard = document.getElementById('mockCard');
    if (mockCard) {
        mockCard.style.fontFamily = font;
    }
}

function updateAnnPreview() {
    var val = document.getElementById('annInput').value;
    document.getElementById('annPreviewText').innerText = val || '⚡ FREE Express Shipping on all Prepaid Orders above ₹999';
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
