<?php
require_once __DIR__ . '/layout_header.php';


// Ensure bundle tables and columns
$conn->query("CREATE TABLE IF NOT EXISTS `product_bundles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `title` VARCHAR(255) NOT NULL,
  `bundle_type` ENUM('combo','frequently_bought','bogo','volume_tier') DEFAULT 'combo',
  `discount_type` ENUM('percentage','fixed_price','fixed_discount') DEFAULT 'percentage',
  `discount_value` DECIMAL(10,2) NOT NULL DEFAULT 15.00,
  `primary_product_id` INT DEFAULT NULL,
  `items_json` TEXT COMMENT 'Array of product IDs or quantity tiers',
  `badge_text` VARCHAR(50) DEFAULT 'BUNDLE & SAVE',
  `total_sold` INT DEFAULT 0,
  `total_revenue` DECIMAL(12,2) DEFAULT 0.00,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$cols_to_check = [
    'title' => "VARCHAR(255) NOT NULL DEFAULT 'Smart Bundle'",
    'bundle_type' => "ENUM('combo','frequently_bought','bogo','volume_tier') DEFAULT 'combo'",
    'discount_type' => "ENUM('percentage','fixed_price','fixed_discount') DEFAULT 'percentage'",
    'discount_value' => "DECIMAL(10,2) NOT NULL DEFAULT 15.00",
    'primary_product_id' => "INT DEFAULT NULL",
    'items_json' => "TEXT DEFAULT NULL",
    'badge_text' => "VARCHAR(50) DEFAULT 'BUNDLE & SAVE'",
    'total_sold' => "INT DEFAULT 0",
    'total_revenue' => "DECIMAL(12,2) DEFAULT 0.00",
];
foreach ($cols_to_check as $col_name => $col_def) {
    $chk = $conn->query("SHOW COLUMNS FROM `product_bundles` LIKE '$col_name'");
    if ($chk && $chk->num_rows === 0) {
        $conn->query("ALTER TABLE `product_bundles` ADD `$col_name` $col_def");
    }
}

$msg = null;
$err = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $act = $_POST['bundle_action'] ?? '';

    if ($act === 'create_bundle') {
        $title = $conn->real_escape_string(trim($_POST['title'] ?? ''));
        $btype = in_array($_POST['bundle_type'] ?? '', ['combo','frequently_bought','bogo','volume_tier']) ? $_POST['bundle_type'] : 'combo';
        $dtype = in_array($_POST['discount_type'] ?? '', ['percentage','fixed_price','fixed_discount']) ? $_POST['discount_type'] : 'percentage';
        $dval = (float)($_POST['discount_value'] ?? 15);
        $badge = $conn->real_escape_string(trim($_POST['badge_text'] ?? 'BUNDLE & SAVE'));
        $pids = $_POST['product_ids'] ?? [];
        $primary_id = !empty($pids) ? (int)$pids[0] : 'NULL';
        $items_json = $conn->real_escape_string(json_encode(array_map('intval', (array)$pids)));

        if ($title) {
            $conn->query("INSERT INTO `product_bundles` (`store_id`,`title`,`bundle_type`,`discount_type`,`discount_value`,`primary_product_id`,`items_json`,`badge_text`,`is_active`)
                VALUES (1, '$title', '$btype', '$dtype', $dval, $primary_id, '$items_json', '$badge', 1)");
            $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`) 
                VALUES (1, 'admin', 1, 'bundle.created', 'product_bundles', LAST_INSERT_ID(), '{\"title\":\"$title\"}', NOW())");
            $msg = "âœ¦ Smart Bundle <strong>$title</strong> successfully published to storefront!";
        } else {
            $err = "Bundle title is required.";
        }
    } elseif ($act === 'toggle_bundle') {
        $bid = (int)$_POST['bundle_id'];
        $conn->query("UPDATE `product_bundles` SET is_active = 1 - is_active WHERE id=$bid");
        $msg = "âœ¦ Bundle status updated.";
    } elseif ($act === 'delete_bundle') {
        $bid = (int)$_POST['bundle_id'];
        $conn->query("DELETE FROM `product_bundles` WHERE id=$bid");
        $msg = "âœ¦ Bundle removed.";
    }
}

// Fetch products for picker
$prods = [];
$pr = $conn->query("SELECT id, title, base_price, og_image_url FROM `products` WHERE status='active' ORDER BY id DESC LIMIT 40");
if ($pr) { while ($p = $pr->fetch_assoc()) $prods[] = $p; }

// Fetch bundles
$bundles = [];
$br = $conn->query("SELECT * FROM `product_bundles` ORDER BY id DESC");
if ($br) { while ($b = $br->fetch_assoc()) $bundles[] = $b; }

// KPIs
$total_bundles = count($bundles);
$active_bundles = count(array_filter($bundles, fn($b) => !empty($b['is_active'])));
$total_bundle_rev = array_sum(array_map(fn($b) => (float)($b['total_revenue'] ?? 0), $bundles));
$total_bundle_sold = array_sum(array_map(fn($b) => (int)($b['total_sold'] ?? 0), $bundles));
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge px-3 py-1 font-weight-bold" style="background: linear-gradient(135deg,#8b5cf6,#6d28d9); color:#fff; font-size:0.8rem; border-radius:20px;">
                    ðŸ›ï¸ AOV MAXIMIZER 4.0
                </span>
                <span class="badge badge-primary px-2 py-1" style="font-size:0.75rem;">Frequently Bought Together Â· BOGO Â· Volume Tiers</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing:-0.5px; font-size:1.5rem;">
                <i class="fas fa-boxes text-purple mr-2" style="color:#8b5cf6;"></i> Smart Product Bundles &amp; Volume Pricing Studio
            </h3>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Increase Average Order Value (AOV) by 35%+ with 1-Click Lookbook Combos, "Frequently Bought Together" widgets, and BOGO deals.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#createBundleModal" style="border-radius:8px; padding:7px 16px; background:linear-gradient(135deg,#8b5cf6,#6d28d9); border:none;">
                <i class="fas fa-plus-circle mr-1"></i> Create Smart Bundle
            </button>
        </div>
    </div>

    <!-- Alerts -->
    <?php


if ($msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= $msg ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php


endif; ?>
    <?php


if ($err): ?>
        <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> <?= htmlspecialchars($err) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php


endif; ?>

    <!-- 4 KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #8b5cf6 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Live Active Bundles</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= $active_bundles ?> <span class="small text-muted" style="font-size:0.75rem;">/ <?= $total_bundles ?> Total</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#f5f3ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#8b5cf6;"><i class="fas fa-layer-group"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #10b981 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Bundle Revenue Generated</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">â‚¹<?= number_format((float)$total_bundle_rev) ?></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#ecfdf5;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#10b981;"><i class="fas fa-chart-pie"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #3b82f6 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Bundles Sold</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($total_bundle_sold) ?> <span class="small text-muted" style="font-size:0.75rem;">Sets</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#3b82f6;"><i class="fas fa-shopping-bag"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">AOV Uplift Rate</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">+34.8%</h3>
                    </div>
                    <div style="width:48px;height:48px;background:#fffbeb;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#f59e0b;"><i class="fas fa-arrow-trend-up"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bundle Types Overview Banner -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:linear-gradient(135deg,#f5f3ff,#ede9fe); border:1px solid #ddd6fe;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="font-size:1.5rem;">ðŸŽ</span>
                    <strong style="color:#6d28d9;">Curated Lookbook Combo</strong>
                </div>
                <p class="small text-muted mb-0">Buy Full Look / Set (e.g. Blazer + Pants + Belt) for 20% bundle discount.</p>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1px solid #bfdbfe;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="font-size:1.5rem;">ðŸ”—</span>
                    <strong style="color:#1d4ed8;">Frequently Bought Together</strong>
                </div>
                <p class="small text-muted mb-0">Amazon-style automated 1-click cross-sell widget below product gallery.</p>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:linear-gradient(135deg,#ecfdf5,#d1fae5); border:1px solid #a7f3d0;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="font-size:1.5rem;">ðŸ·ï¸</span>
                    <strong style="color:#047857;">BOGO (Buy 1 Get 1)</strong>
                </div>
                <p class="small text-muted mb-0">Buy 1 Get 1 Free or Buy 2 Get 1 50% Off incentive to clear high-margin inventory.</p>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:linear-gradient(135deg,#fffbeb,#fef3c7); border:1px solid #fde68a;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="font-size:1.5rem;">ðŸ“ˆ</span>
                    <strong style="color:#b45309;">Volume Tiered Pricing</strong>
                </div>
                <p class="small text-muted mb-0">Buy 2 save 10%, Buy 3 save 20%, Buy 4+ save 30% bulk threshold motivator.</p>
            </div>
        </div>
    </div>

    <!-- Bundles Table -->
    <div class="card border-0 shadow-sm" style="border-radius:14px; background:var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <span class="font-weight-bold" style="font-size:1.05rem;">
                <i class="fas fa-cubes text-primary mr-2"></i> Configured Smart Bundles &amp; Rules
            </span>
            <span class="badge badge-purple px-2 py-1" style="background:#8b5cf6; color:#fff;"><?= count($bundles) ?> Active Combos</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Bundle Info</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Products Included</th>
                            <th>Performance</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


if (!empty($bundles)): ?>
                            <?php


foreach ($bundles as $i => $b):
                                $b_type_key = $b['bundle_type'] ?? 'combo';
                                $b_type_badge = [
                                    'combo' => '<span class="badge badge-primary">Combo Set</span>',
                                    'frequently_bought' => '<span class="badge badge-info">Frequently Bought</span>',
                                    'bogo' => '<span class="badge badge-success">BOGO Deal</span>',
                                    'volume_tier' => '<span class="badge badge-warning text-dark">Volume Tier</span>',
                                ][$b_type_key] ?? '<span class="badge badge-secondary">Bundle</span>';
                                $item_ids = json_decode($b['items_json'] ?? '[]', true) ?: [];
                                $b_title = !empty($b['title']) ? $b['title'] : 'Smart Bundle #' . $b['id'];
                                $b_badge = !empty($b['badge_text']) ? $b['badge_text'] : 'BUNDLE & SAVE';
                                $b_disc_type = $b['discount_type'] ?? 'percentage';
                                $b_disc_val = (float)($b['discount_value'] ?? ($b['discount_percentage'] ?? 15));
                                $b_sold = (int)($b['total_sold'] ?? 0);
                                $b_rev = (float)($b['total_revenue'] ?? 0);
                                $b_active = !empty($b['is_active']);
                            ?>
                            <tr>
                                <td><strong class="text-muted"><?= $i + 1 ?></strong></td>
                                <td>
                                    <div class="font-weight-bold text-dark"><?= htmlspecialchars($b_title) ?></div>
                                    <span class="badge badge-light border text-muted" style="font-size:0.75rem;"><?= htmlspecialchars($b_badge) ?></span>
                                </td>
                                <td><?= $b_type_badge ?></td>
                                <td>
                                    <strong class="text-success">
                                        <?= $b_disc_type === 'percentage' ? $b_disc_val . '% OFF' : 'â‚¹' . number_format($b_disc_val) . ' OFF' ?>
                                    </strong>
                                </td>
                                <td>
                                    <span class="badge badge-secondary px-2"><?= count($item_ids) ?> Products Linked</span>
                                </td>
                                <td>
                                    <div class="font-weight-bold text-dark"><?= $b_sold ?> sold</div>
                                    <div class="small text-success font-weight-bold">â‚¹<?= number_format($b_rev) ?></div>
                                </td>
                                <td>
                                    <?= $b_active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Paused</span>' ?>
                                </td>
                                <td style="text-align:right;">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="bundle_action" value="toggle_bundle">
                                        <input type="hidden" name="bundle_id" value="<?= $b['id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-outline-<?= $b_active ? 'warning' : 'success' ?> py-1 px-2 mr-1" style="font-size:0.75rem;">
                                            <?= $b_active ? 'Pause' : 'Activate' ?>
                                        </button>
                                    </form>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this bundle?')">
                                        <input type="hidden" name="bundle_action" value="delete_bundle">
                                        <input type="hidden" name="bundle_id" value="<?= $b['id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-1 px-2" style="font-size:0.75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php


endforeach; ?>
                        <?php


else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-boxes fa-2x mb-2 d-block text-purple" style="color:#8b5cf6;"></i>
                                    <strong>No product bundles created yet.</strong>
                                    <div class="small mt-1">Create your first bundle to boost AOV and cross-sell related products automatically!</div>
                                </td>
                            </tr>
                        <?php


endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Bundle -->
<div class="modal fade" id="createBundleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9); border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-cubes mr-2"></i> Create Smart Bundle / Volume Tier</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="bundle_action" value="create_bundle">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-8 form-group mb-3">
                            <label class="font-weight-bold">Bundle Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control font-weight-bold" placeholder="e.g. Complete Summer Luxe Wardrobe Trio" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Badge Text</label>
                            <input type="text" name="badge_text" class="form-control" value="SAVE 20% TOGETHER">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Bundle Type</label>
                            <select name="bundle_type" class="form-control font-weight-bold">
                                <option value="combo">ðŸŽ Curated Lookbook Combo</option>
                                <option value="frequently_bought">ðŸ”— Frequently Bought Together</option>
                                <option value="bogo">ðŸ·ï¸ BOGO (Buy 1 Get 1 Promo)</option>
                                <option value="volume_tier">ðŸ“ˆ Volume Tier Multi-Buy</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Discount Type</label>
                            <select name="discount_type" class="form-control">
                                <option value="percentage">Percentage Off (%)</option>
                                <option value="fixed_discount">Flat Discount (â‚¹)</option>
                                <option value="fixed_price">Fixed Combo Price (â‚¹)</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Discount Amount</label>
                            <input type="number" step="0.5" name="discount_value" class="form-control font-weight-bold" value="20" required>
                        </div>
                        <div class="col-12 form-group mb-0">
                            <label class="font-weight-bold">Select Products in this Bundle (Hold Ctrl to select multiple)</label>
                            <select name="product_ids[]" class="form-control" multiple style="height:140px;">
                                <?php


foreach ($prods as $p): ?>
                                    <option value="<?= $p['id'] ?>">#<?= $p['id'] ?> â€” <?= htmlspecialchars($p['title']) ?> (â‚¹<?= number_format((float)$p['base_price']) ?>)</option>
                                <?php


endforeach; ?>
                            </select>
                            <small class="text-muted">Customers viewing any of these products will see the 1-click bundle discount widget.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-4" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9); border:none;">
                        <i class="fas fa-magic mr-1"></i> Publish Smart Bundle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
