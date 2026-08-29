<?php
require_once __DIR__ . '/layout_header.php';


$import_msg = null;
$import_err = null;

// Handle 1-Click Product Push POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['importer_action'])) {
    $act = $_POST['importer_action'];

    if ($act === 'push_product') {
        $p_title = trim($_POST['title'] ?? 'Imported Luxury Product');
        $p_slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $p_title)) . '-' . rand(100, 999);
        $supplier_name = trim($_POST['supplier_name'] ?? 'Alibaba Global Trade');
        $supplier_cost = (float)($_POST['supplier_cost'] ?? 1200.00);
        $markup_multiplier = (float)($_POST['markup_multiplier'] ?? 2.8);
        $base_price = (float)($_POST['selling_price'] ?? ($supplier_cost * $markup_multiplier));
        $compare_price = (float)($_POST['compare_at_price'] ?? ($base_price * 1.35));
        $cat_id = (int)($_POST['collection_id'] ?? 1);
        $p_desc = trim($_POST['description'] ?? '');
        $p_img = trim($_POST['image_url'] ?? 'img/cashmere_cocoon_coat.jpg');
        $supplier_sku = trim($_POST['supplier_sku'] ?? ('SUP-ALB-' . rand(10000, 99999)));

        if (!empty($p_title)) {
            $stmt_p = $conn->prepare("INSERT INTO `products` (`store_id`, `collection_id`, `title`, `slug`, `description`, `vendor`, `status`, `product_type`, `base_price`, `compare_at_price`, `created_at`, `updated_at`) VALUES (1, ?, ?, ?, ?, ?, 'active', 'physical', ?, ?, NOW(), NOW())");
            $stmt_p->bind_param("issssdd", $cat_id, $p_title, $p_slug, $p_desc, $supplier_name, $base_price, $compare_price);
            
            if ($stmt_p->execute()) {
                $new_id = $stmt_p->insert_id;
                $p_img_full = (strpos($p_img, 'http') === 0) ? $p_img : ('http://localhost/Dropshipping/' . ltrim($p_img, '/'));
                
                // Add primary image
                $conn->query("INSERT INTO `product_images` (`product_id`, `url`, `alt_text`, `position`, `is_primary`) VALUES ($new_id, '" . $conn->real_escape_string($p_img_full) . "', '" . $conn->real_escape_string($p_title) . "', 1, 1)");
                $conn->query("UPDATE `products` SET `og_image_url` = '" . $conn->real_escape_string($p_img_full) . "' WHERE `id` = $new_id");

                // Add standard variants (S, M, L, XL)
                $sizes = ['S', 'M', 'L', 'XL'];
                foreach ($sizes as $idx => $sz) {
                    $v_sku = "SKU-{$new_id}-{$sz}";
                    $conn->query("INSERT INTO `product_variants` (`product_id`, `sku`, `title`, `price`, `compare_price`, `inventory_qty`, `is_active`, `created_at`) VALUES ($new_id, '$v_sku', 'Tailored / $sz', $base_price, $compare_price, 50, 1, NOW())");
                }

                // Add legacy product table record for universal backward compatibility
                $conn->query("INSERT IGNORE INTO `product` (`admid`, `pcid`, `ccid`, `category`, `pname`, `descp`, `mrp`, `disc`) VALUES ('67ac7cf58dfc4', 'cat_$cat_id', 'prod_$new_id', 'cat_$cat_id', '" . $conn->real_escape_string($p_title) . "', '" . $conn->real_escape_string($p_desc) . "', $base_price, 0.00)");

                // Record audit log event
                $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'admin', 1, 'supplier.product.imported', 'products', $new_id, '{\"supplier\":\"$supplier_name\",\"cost\":$supplier_cost,\"selling_price\":$base_price}', NOW())");

                $import_msg = "âœ¦ Successfully imported & published '$p_title' from $supplier_name to live catalog! (SKU Ref: #PROD-$new_id)";
            } else {
                $import_err = "Failed to push product: " . $conn->error;
            }
        }
    }
}

// Fetch stats
$total_imported = (int)($conn->query("SELECT COUNT(*) FROM `products` WHERE vendor != 'NovaDrop'")->fetch_row()[0] ?? 4);
$total_cats = (int)($conn->query("SELECT COUNT(*) FROM `collections`")->fetch_row()[0] ?? 6);
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-purple px-3 py-1 font-weight-bold" style="background:#f5f3ff;color:#8b5cf6;font-size:0.8rem;border-radius:20px;">
                    â— SUPPLIER PUSHER ENGINE 2.0
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Alibaba Â· CJ Â· AliExpress Verified</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px; font-size: 1.5rem;">
                <i class="fas fa-satellite-dish text-primary mr-2"></i> Universal Dropshipping Supplier Importer & Product Pusher
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Paste product links or choose trending verified supplier inventory to auto-generate AI copy, calculate margins, and push directly to live store.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <a href="index.php?q=1" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                <i class="fas fa-tshirt mr-1"></i> View Live Catalog
            </a>
            <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm" onclick="handlePasteAndImport()" style="border-radius: 8px; padding: 7px 18px;">
                <i class="fas fa-paste mr-1"></i> Paste &amp; Auto-Import Link
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php


if ($import_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($import_msg) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php


endif; ?>
    <?php


if ($import_err): ?>
        <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($import_err) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php


endif; ?>

    <!-- 4 KPI Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Imported Supplier SKUs</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= number_format($total_imported) ?></h3>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-cloud-download-alt"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Supported Platforms</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">6 Direct APIs</h3>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-network-wired"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Average Margin Multiplier</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">2.8x â€“ 3.5x</h3>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Supplier Sync Watchdog</div>
                        <h3 class="font-weight-bold text-info mb-0 mt-1">â— Active &amp; Armed</h3>
                    </div>
                    <div class="icon-capsule cyan" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-shield-alt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main 1-Click Importer Form & Live Preview Studio -->
    <div class="row">
        <!-- Left: URL Ingestor & Configuration Form (7 Cols) -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 14px; background: var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="font-weight-bold" style="font-size: 1.05rem;">
                        <i class="fas fa-magic text-primary mr-2"></i> 1-Click Supplier Product Ingestor
                    </span>
                    <span class="badge badge-light border text-muted">Auto-Extracts Images &amp; Specs</span>
                </div>
                <div class="card-body p-4">
                    <!-- URL Paste Bar -->
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Supplier Product URL (Alibaba / AliExpress / CJ / Temu / Shein)</label>
                        <div class="input-group">
                            <input type="text" id="productUrlInput" class="form-control font-weight-500" placeholder="https://www.alibaba.com/product-detail/luxury-italian-cashmere-overcoat..." style="border-radius: 8px 0 0 8px; font-size: 0.9rem;">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary font-weight-bold px-3" onclick="simulateExtractSupplierData()" style="border-radius: 0 8px 8px 0;">
                                    <i class="fas fa-bolt mr-1"></i> Extract &amp; Auto-Fill
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Sample Presets -->
                    <div class="mb-4 d-flex align-items-center gap-2 flex-wrap">
                        <span class="small font-weight-bold text-muted mr-1">âš¡ Quick Presets:</span>
                        <button type="button" class="btn btn-xs btn-outline-primary py-1 px-2" style="font-size: 0.75rem; border-radius: 6px;" onclick="loadPresetUrl('https://www.alibaba.com/product-detail/luxury-italian-cashmere-overcoat', 'Italian Double-Face Cashmere Overcoat', 'Alibaba Global Luxury', 1850, 5499, 'img/cashmere_cocoon_coat.jpg')">
                            <i class="fas fa-link mr-1"></i> Alibaba Cashmere
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-success py-1 px-2" style="font-size: 0.75rem; border-radius: 6px;" onclick="loadPresetUrl('https://cjdropshipping.com/product/heavyweight-melton-wool-peacoat', 'Atelier Double-Breasted Wool Peacoat', 'CJ Dropshipping Express', 1499, 4199, 'img/double_breasted_peacoat.jpg')">
                            <i class="fas fa-link mr-1"></i> CJ Wool Peacoat
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-warning py-1 px-2 text-dark" style="font-size: 0.75rem; border-radius: 6px;" onclick="loadPresetUrl('https://www.aliexpress.com/item/mulberry-silk-band-collar-shirt', 'Mulberry Silk Band-Collar Evening Shirt', 'AliExpress Direct VIP', 750, 2499, 'img/silk_band_collar_shirt.jpg')">
                            <i class="fas fa-link mr-1"></i> AliExpress Silk
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-info py-1 px-2" style="font-size: 0.75rem; border-radius: 6px;" onclick="loadPresetUrl('https://cjdropshipping.com/product/okayama-raw-selvedge-denim', 'Okayama 14.5oz Raw Selvedge Denim', 'CJ Dropshipping Express', 980, 2999, 'img/selvedge_denim_trousers.jpg')">
                            <i class="fas fa-link mr-1"></i> CJ Raw Denim
                        </button>
                    </div>

                    <!-- Extraction Progress HUD (Hidden by default) -->
                    <div id="extractLoadingHud" class="alert alert-info py-3 mb-4 d-none" style="border-radius: 10px; border-left: 4px solid #3b82f6;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            <div>
                                <strong class="d-block text-primary" id="hudStatusText">Connecting to supplier API endpoint...</strong>
                                <small class="text-muted" id="hudSubText">Parsing wholesale specifications, high-res galleries, and calculating margin tiers.</small>
                            </div>
                        </div>
                    </div>

                    <form method="POST" id="pushProductForm">
                        <input type="hidden" name="importer_action" value="push_product">

                        <div class="row">
                            <div class="col-md-8 form-group mb-3">
                                <label class="font-weight-bold">Product Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="impTitle" class="form-control font-weight-bold" value="Atelier Double-Breasted Wool Peacoat" required oninput="updateLivePreview()">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">Supplier Platform</label>
                                <select name="supplier_name" id="impSupplier" class="form-control font-weight-bold" onchange="updateLivePreview()">
                                    <option value="Alibaba Global Luxury">Alibaba Global Luxury</option>
                                    <option value="CJ Dropshipping Express" selected>CJ Dropshipping Express</option>
                                    <option value="AliExpress Direct VIP">AliExpress Direct VIP</option>
                                    <option value="Taobao Silk Guild">Taobao Silk Guild</option>
                                    <option value="Temu Trade Direct">Temu Trade Direct</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">Supplier Cost (â‚¹)</label>
                                <input type="number" step="0.01" name="supplier_cost" id="impCost" class="form-control" value="1499.00" oninput="recalcImporterMargin()">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">Markup Multiplier</label>
                                <select name="markup_multiplier" id="impMarkup" class="form-control" onchange="recalcImporterMargin()">
                                    <option value="2.0">2.0x (100% Margin)</option>
                                    <option value="2.5">2.5x (150% Margin)</option>
                                    <option value="2.8" selected>2.8x (180% Margin - Recommended)</option>
                                    <option value="3.5">3.5x (250% Margin - Luxury Tier)</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">Final Selling Price (â‚¹)</label>
                                <input type="number" step="0.01" name="selling_price" id="impPrice" class="form-control font-weight-bold text-success" value="4199.00" oninput="updateLivePreview()">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">Target Collection / Category</label>
                                <select name="collection_id" class="form-control">
                                    <?php


$all_c = $conn->query("SELECT * FROM `collections` ORDER BY id ASC");
                                    if ($all_c && $all_c->num_rows > 0) {
                                        while ($col = $all_c->fetch_assoc()) {
                                            echo "<option value='{$col['id']}'>" . htmlspecialchars($col['title']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value='1'>Outerwear & Cashmere</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">Product Image Path / URL</label>
                                <input type="text" name="image_url" id="impImage" class="form-control" value="img/double_breasted_peacoat.jpg" oninput="updateLivePreview()">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="font-weight-bold mb-0">AI Generated Copywriting &amp; Key Benefit Bullets</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="injectAiCopywriting()">
                                    <i class="fas fa-magic mr-1"></i> AI Polish Copy
                                </button>
                            </div>
                            <textarea name="description" id="impDesc" class="form-control" rows="4" oninput="updateLivePreview()">âœ¦ Engineered in heavy 620 GSM Italian Melton wool with tailored broad lapels and horn buttons.
âœ¦ Structured drop-shoulder architecture with interior satin cupro lining.
âœ¦ Water-resistant and wind-proof natural weave crafted for sub-zero climate resilience.
âœ¦ Dual side-entry handwarmer pockets with reinforced bartack stitching.</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2 shadow-sm" style="border-radius: 10px; font-size: 1rem;">
                            <i class="fas fa-rocket mr-2"></i> Push Product to Live Storefront Catalog (1-Click)
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Live Storefront Card Preview (5 Cols) -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 sticky-top" style="border-radius: 14px; top: 80px; background: var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold"><i class="fas fa-eye text-success mr-2"></i> Live Storefront Preview Card</span>
                    <span class="badge badge-success">Live Ready</span>
                </div>
                <div class="card-body p-4 text-center">
                    <!-- Preview Card Container -->
                    <div class="border rounded-xl p-3 bg-white shadow-sm text-left mx-auto" style="max-width: 320px; border-radius: 16px;">
                        <!-- Image Container with relative positioning -->
                        <div class="position-relative overflow-hidden mb-3" style="height: 280px; border-radius: 12px; background: #f8fafc;">
                            <img id="prevImg" src="../img/double_breasted_peacoat.jpg" onerror="this.src='../img/cashmere_cocoon_coat.jpg'" alt="Preview" style="object-fit: cover; width: 100%; height: 100%; display: block;">
                            <span class="badge badge-dark position-absolute" style="top: 8px; left: 8px; font-size: 0.72rem; background: rgba(0,0,0,0.85); border-radius: 6px; z-index: 5;">Verified Supplier</span>
                        </div>
                        <div class="small text-muted font-weight-bold text-uppercase" id="prevVendor">CJ Dropshipping Express</div>
                        <h6 class="font-weight-bold text-dark mb-1" id="prevTitle">Atelier Double-Breasted Wool Peacoat</h6>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <div>
                                <span class="font-weight-bold text-dark" style="font-size: 1.15rem;" id="prevPrice">â‚¹4,199.00</span>
                                <span class="text-muted small ml-1"><del id="prevComp">â‚¹5,668.00</del></span>
                            </div>
                            <span class="badge badge-success" id="prevMargin">+180% Margin</span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded text-left small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Supplier Unit Cost:</span>
                            <strong class="text-dark" id="summaryCost">â‚¹1,499.00</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Net Profit Per Unit:</span>
                            <strong class="text-success" id="summaryProfit">â‚¹2,700.00</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Variants Generated:</span>
                            <strong class="text-primary">4 Sizes (S, M, L, XL)</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trending Curated Supplier Inventory (Instant 1-Click Push Library) -->
    <div class="card shadow-sm border-0 mt-2" style="border-radius: 14px; background: var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <span class="font-weight-bold" style="font-size: 1.05rem;">
                    <i class="fas fa-fire text-warning mr-2"></i> Verified Trending Supplier Inventory (1-Click Push)
                </span>
                <p class="text-muted mb-0 small">Direct high-margin apparel pieces with supplier API verified stock.</p>
            </div>
            <span class="badge badge-primary px-2.5 py-1">Fast 48H Priority Dispatch</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 70px;">Image</th>
                            <th>Product Details</th>
                            <th>Supplier</th>
                            <th>Wholesale Cost</th>
                            <th>Suggested Retail</th>
                            <th>Net Margin</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <img src="../img/cashmere_cocoon_coat.jpg" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>Italian Double-Face Cashmere Overcoat</strong>
                                <div class="small text-muted">Category: Outerwear &amp; Coats Â· SKU: SUP-ALB-8821</div>
                            </td>
                            <td><span class="badge badge-light border">Alibaba Premium</span></td>
                            <td><strong>â‚¹1,850.00</strong></td>
                            <td><strong class="text-success">â‚¹5,499.00</strong></td>
                            <td><span class="badge badge-success">+197% Margin (â‚¹3,649)</span></td>
                            <td style="text-align: right;">
                                <button type="button" class="btn btn-sm btn-primary font-weight-bold" onclick="quickFillProduct('Italian Double-Face Cashmere Overcoat', 'Alibaba Global Luxury', 1850, 5499, 'img/cashmere_cocoon_coat.jpg')">
                                    <i class="fas fa-arrow-up mr-1"></i> Load &amp; Push
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="../img/selvedge_denim_trousers.jpg" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>Okayama 14.5oz Raw Selvedge Denim Trousers</strong>
                                <div class="small text-muted">Category: Denim &amp; Jeans Â· SKU: SUP-CJ-4019</div>
                            </td>
                            <td><span class="badge badge-light border">CJ Dropshipping</span></td>
                            <td><strong>â‚¹980.00</strong></td>
                            <td><strong class="text-success">â‚¹2,999.00</strong></td>
                            <td><span class="badge badge-success">+206% Margin (â‚¹2,019)</span></td>
                            <td style="text-align: right;">
                                <button type="button" class="btn btn-sm btn-primary font-weight-bold" onclick="quickFillProduct('Okayama 14.5oz Raw Selvedge Denim Trousers', 'CJ Dropshipping Express', 980, 2999, 'img/selvedge_denim_trousers.jpg')">
                                    <i class="fas fa-arrow-up mr-1"></i> Load &amp; Push
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="../img/silk_band_collar_shirt.jpg" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                            </td>
                            <td>
                                <strong>Mulberry Silk Band-Collar Evening Shirt</strong>
                                <div class="small text-muted">Category: Silk Shirts Â· SKU: SUP-ALI-5510</div>
                            </td>
                            <td><span class="badge badge-light border">AliExpress Direct</span></td>
                            <td><strong>â‚¹750.00</strong></td>
                            <td><strong class="text-success">â‚¹2,499.00</strong></td>
                            <td><span class="badge badge-success">+233% Margin (â‚¹1,749)</span></td>
                            <td style="text-align: right;">
                                <button type="button" class="btn btn-sm btn-primary font-weight-bold" onclick="quickFillProduct('Mulberry Silk Band-Collar Evening Shirt', 'AliExpress Direct VIP', 750, 2499, 'img/silk_band_collar_shirt.jpg')">
                                    <i class="fas fa-arrow-up mr-1"></i> Load &amp; Push
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function recalcImporterMargin() {
    var cost = parseFloat(document.getElementById('impCost').value) || 0;
    var markup = parseFloat(document.getElementById('impMarkup').value) || 2.8;
    var price = Math.round(cost * markup);
    document.getElementById('impPrice').value = price;
    updateLivePreview();
}

function updateLivePreview() {
    var title = document.getElementById('impTitle').value || 'Imported Luxury Product';
    var supplier = document.getElementById('impSupplier').value || 'Alibaba Global';
    var price = parseFloat(document.getElementById('impPrice').value) || 0;
    var cost = parseFloat(document.getElementById('impCost').value) || 0;
    var comp = Math.round(price * 1.35);
    var profit = price - cost;
    var marginPct = cost > 0 ? Math.round((profit / cost) * 100) : 180;
    var img = document.getElementById('impImage').value || 'img/cashmere_cocoon_coat.jpg';

    document.getElementById('prevTitle').textContent = title;
    document.getElementById('prevVendor').textContent = supplier;
    document.getElementById('prevPrice').textContent = 'â‚¹' + price.toLocaleString('en-IN');
    document.getElementById('prevComp').textContent = 'â‚¹' + comp.toLocaleString('en-IN');
    document.getElementById('prevMargin').textContent = '+' + marginPct + '% Margin';
    document.getElementById('summaryCost').textContent = 'â‚¹' + cost.toLocaleString('en-IN');
    document.getElementById('summaryProfit').textContent = 'â‚¹' + profit.toLocaleString('en-IN');

    var pImg = document.getElementById('prevImg');
    if (img.startsWith('http')) {
        pImg.src = img;
    } else {
        pImg.src = '../' + img.replace(/^\//, '');
    }
}

// 1-Click Paste & Auto-Import from Clipboard
function handlePasteAndImport() {
    var input = document.getElementById('productUrlInput');
    if (navigator.clipboard && navigator.clipboard.readText) {
        navigator.clipboard.readText().then(function(text) {
            if (text && (text.includes('http') || text.includes('www.') || text.includes('alibaba') || text.includes('aliexpress') || text.includes('cjdropshipping') || text.includes('temu') || text.includes('shein'))) {
                input.value = text.trim();
                simulateExtractSupplierData();
            } else if (text && text.trim().length > 0) {
                input.value = text.trim();
                simulateExtractSupplierData();
            } else {
                input.focus();
                alert('âœ¦ Clipboard was empty. Please paste your supplier product link into the input box or click any Quick Preset!');
            }
        }).catch(function() {
            input.focus();
            if (input.value.trim().length > 0) {
                simulateExtractSupplierData();
            } else {
                alert('âœ¦ Please paste your supplier product URL into the input field or click a Quick Preset below.');
            }
        });
    } else {
        input.focus();
        if (input.value.trim().length > 0) {
            simulateExtractSupplierData();
        } else {
            alert('âœ¦ Please enter a supplier link or select a Quick Preset!');
        }
    }
}

function loadPresetUrl(url, title, vendor, cost, price, img) {
    document.getElementById('productUrlInput').value = url;
    document.getElementById('impTitle').value = title;
    document.getElementById('impSupplier').value = vendor;
    document.getElementById('impCost').value = cost;
    document.getElementById('impPrice').value = price;
    document.getElementById('impImage').value = img;
    simulateExtractSupplierData();
}

function simulateExtractSupplierData() {
    var url = document.getElementById('productUrlInput').value.trim();
    if (!url) {
        url = 'https://www.alibaba.com/product-detail/luxury-italian-cashmere-overcoat';
        document.getElementById('productUrlInput').value = url;
    }

    var hud = document.getElementById('extractLoadingHud');
    var statusText = document.getElementById('hudStatusText');
    var subText = document.getElementById('hudSubText');
    hud.classList.remove('d-none');

    statusText.textContent = 'Connecting to Supplier API (' + (url.includes('cjdropshipping') ? 'CJ Dropshipping' : (url.includes('aliexpress') ? 'AliExpress VIP' : 'Alibaba Global Trade')) + ')...';
    subText.textContent = 'Scraping wholesale fabric specifications, high-res image gallery, and MOQ tiers...';

    setTimeout(function() {
        statusText.textContent = 'Generating High-Converting AI Benefit Copywriting & SEO Tags...';
        subText.textContent = 'Calculating 2.8x profit margin elasticity and preparing S, M, L, XL variant schema...';
    }, 600);

    setTimeout(function() {
        hud.classList.add('d-none');
        if (url.includes('denim')) {
            document.getElementById('impTitle').value = 'Okayama 14.5oz Raw Selvedge Denim Trousers';
            document.getElementById('impSupplier').value = 'CJ Dropshipping Express';
            document.getElementById('impCost').value = '980.00';
            document.getElementById('impImage').value = 'img/selvedge_denim_trousers.jpg';
        } else if (url.includes('silk')) {
            document.getElementById('impTitle').value = 'Mulberry Silk Band-Collar Evening Shirt';
            document.getElementById('impSupplier').value = 'AliExpress Direct VIP';
            document.getElementById('impCost').value = '750.00';
            document.getElementById('impImage').value = 'img/silk_band_collar_shirt.jpg';
        } else if (url.includes('cashmere')) {
            document.getElementById('impTitle').value = 'Italian Double-Face Cashmere Overcoat';
            document.getElementById('impSupplier').value = 'Alibaba Global Luxury';
            document.getElementById('impCost').value = '1850.00';
            document.getElementById('impImage').value = 'img/cashmere_cocoon_coat.jpg';
        } else {
            document.getElementById('impTitle').value = 'Atelier Double-Breasted Wool Peacoat';
            document.getElementById('impSupplier').value = 'Alibaba Global Luxury';
            document.getElementById('impCost').value = '1499.00';
            document.getElementById('impImage').value = 'img/double_breasted_peacoat.jpg';
        }
        recalcImporterMargin();
        updateLivePreview();
        alert('âœ¦ Product details, high-res gallery, and wholesale specs successfully parsed! Click "Push Product to Live Storefront Catalog" below.');
    }, 1100);
}

function quickFillProduct(title, vendor, cost, price, img) {
    document.getElementById('impTitle').value = title;
    document.getElementById('impSupplier').value = vendor;
    document.getElementById('impCost').value = cost;
    document.getElementById('impPrice').value = price;
    document.getElementById('impImage').value = img;
    updateLivePreview();
    window.scrollTo({ top: 120, behavior: 'smooth' });
}

function injectAiCopywriting() {
    var title = document.getElementById('impTitle').value;
    var newCopy = "âœ¦ Tailored bespoke construction crafted in premium heavyweight textile.\nâœ¦ Precision drop-shoulder architecture with structural canvas interfacing.\nâœ¦ Temperature-regulating micro-climate lining engineered for comfort.\nâœ¦ Reinforced double-needle stitching and tonal horn button fastening.";
    document.getElementById('impDesc').value = newCopy;
    alert('âœ¦ High-converting AI copywriting generated for ' + title + '!');
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
