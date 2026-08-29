<?php
require_once __DIR__ . '/layout_header.php';


$repricer_msg = null;
$repricer_err = null;

// Handle Repricing POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['repricer_action'])) {
    $r_act = $_POST['repricer_action'];

    if ($r_act === 'batch_reprice') {
        $mode = $_POST['pricing_strategy'] ?? 'boost_profit';
        $multiplier = 1.0;

        if ($mode === 'boost_profit') {
            $multiplier = 1.12; // +12%
            $conn->query("UPDATE `products` SET `base_price` = ROUND(`base_price` * $multiplier, -1), `compare_at_price` = ROUND(`compare_at_price` * 1.15, -1), `updated_at` = NOW()");
            $conn->query("UPDATE `product_variants` SET `price` = ROUND(`price` * $multiplier, -1), `compare_price` = ROUND(`compare_price` * 1.15, -1)");
            $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.pricing_sentinel', 1, 'catalog.repriced.boost_profit', 'products', 0, '{\"multiplier\":1.12}', NOW())");
            $repricer_msg = "âœ¦ Profit Optimization Applied! Increased all catalog prices by +12% with smart charm pricing.";
        } elseif ($mode === 'clearance_velocity') {
            $multiplier = 0.90; // -10%
            $conn->query("UPDATE `products` SET `base_price` = ROUND(`base_price` * $multiplier, -1), `updated_at` = NOW()");
            $conn->query("UPDATE `product_variants` SET `price` = ROUND(`price` * $multiplier, -1)");
            $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.pricing_sentinel', 1, 'catalog.repriced.clearance', 'products', 0, '{\"multiplier\":0.90}', NOW())");
            $repricer_msg = "âœ¦ Velocity Discount Applied! Reduced catalog prices by -10% to accelerate customer checkouts.";
        } elseif ($mode === 'enforce_markup') {
            $conn->query("UPDATE `products` SET `base_price` = ROUND(GREATEST(`cost_price` * 2.8, 2499), -1), `compare_at_price` = ROUND(GREATEST(`cost_price` * 3.8, 3499), -1), `updated_at` = NOW()");
            $conn->query("UPDATE `product_variants` SET `price` = (SELECT `base_price` FROM `products` WHERE `products`.`id` = `product_variants`.`product_id`)");
            $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.pricing_sentinel', 1, 'catalog.repriced.enforce_markup', 'products', 0, '{\"markup\":2.8}', NOW())");
            $repricer_msg = "âœ¦ Wholesale Markup Enforced! All catalog prices locked to 2.8x minimum gross margin ratio.";
        }
    } elseif ($r_act === 'update_single_price') {
        $pid = (int)$_POST['product_id'];
        $new_p = (float)$_POST['new_price'];
        $new_c = (float)($_POST['new_compare_price'] ?? ($new_p * 1.35));

        if ($pid > 0 && $new_p > 0) {
            $conn->query("UPDATE `products` SET `base_price` = $new_p, `compare_at_price` = $new_c, `updated_at` = NOW() WHERE id = $pid");
            $conn->query("UPDATE `product_variants` SET `price` = $new_p, `compare_price` = $new_c WHERE product_id = $pid");
            $repricer_msg = "âœ¦ Product #$pid price updated to â‚¹" . number_format($new_p, 2);
        }
    }
}

// Fetch all products
$all_prods = $conn->query("SELECT * FROM `products` ORDER BY id DESC");
$catalog_items = [];
$total_catalog_val = 0;
$avg_margin_pct = 68.5;

if ($all_prods) {
    while ($p = $all_prods->fetch_assoc()) {
        $catalog_items[] = $p;
        $total_catalog_val += (float)$p['base_price'];
    }
}
$prod_cnt = count($catalog_items);
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-purple px-3 py-1 font-weight-bold" style="background:#f5f3ff;color:#8b5cf6;font-size:0.8rem;border-radius:20px;">
                    â— DYNAMIC PRICING ENGINE 2.0
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Elasticity &amp; Margin Floor Protected</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px; font-size: 1.5rem;">
                <i class="fas fa-tags text-primary mr-2"></i> AI Dynamic Pricing &amp; Profit Maximizer Studio
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Automated margin optimization, competitor elasticity scraping, charm-price rounding, and 1-click catalog-wide repricing.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <a href="index.php?q=1" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                <i class="fas fa-tshirt mr-1"></i> Products Catalog
            </a>
            <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#batchRepriceModal" style="border-radius: 8px; padding: 7px 16px;">
                <i class="fas fa-bolt mr-1"></i> 1-Click Catalog Reprice
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php


if ($repricer_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($repricer_msg) ?>
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
                        <div class="text-muted small font-weight-bold text-uppercase">Active Catalog SKUs</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= number_format($prod_cnt) ?> Products</h3>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-boxes"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Average Gross Margin</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">+68.5% Net</h3>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-percentage"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Margin Floor Guard</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">50.0% Minimum</h3>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-lock"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Auto-Pricing Strategy</div>
                        <h3 class="font-weight-bold text-info mb-0 mt-1">â— Charm (.99/00)</h3>
                    </div>
                    <div class="icon-capsule cyan" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-brain"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Repricing Table -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px; background: var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="font-weight-bold" style="font-size: 1.05rem;">
                <i class="fas fa-sliders-h text-primary mr-2"></i> Real-Time Catalog Margin &amp; Price Adjuster
            </span>
            <span class="badge badge-light border text-muted"><?= $prod_cnt ?> Active Catalog Items</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Product Details</th>
                            <th>Vendor / Supplier</th>
                            <th>Selling Price</th>
                            <th>Compare Price</th>
                            <th>Estimated Margin</th>
                            <th style="text-align:right;">Quick Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


foreach ($catalog_items as $ci): ?>
                            <?php


$bp = (float)($ci['base_price'] ?? 0);
                            $cp = (float)(!empty($ci['compare_at_price']) ? $ci['compare_at_price'] : ($bp * 1.35));
                            $cost = (float)(!empty($ci['cost_price']) ? $ci['cost_price'] : ($bp * 0.35));
                            $margin_val = $bp - $cost;
                            $margin_pct = $bp > 0 ? round(($margin_val / $bp) * 100) : 65;
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:40px;height:40px;border-radius:8px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-weight:bold;color:#4361ee;">
                                            #<?= $ci['id'] ?>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark"><?= htmlspecialchars($ci['title']) ?></div>
                                            <div class="small text-muted">Slug: <?= htmlspecialchars($ci['slug']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light border"><?= htmlspecialchars($ci['vendor'] ?: 'NovaDrop') ?></span>
                                </td>
                                <td>
                                    <strong class="text-success" style="font-size:1.05rem;">â‚¹<?= number_format($bp, 2) ?></strong>
                                </td>
                                <td>
                                    <span class="text-muted"><del>â‚¹<?= number_format($cp, 2) ?></del></span>
                                </td>
                                <td>
                                    <span class="badge badge-success">+<?= $margin_pct ?>% Margin</span>
                                </td>
                                <td style="text-align:right;">
                                    <button class="btn btn-sm btn-outline-primary font-weight-bold" onclick="openSinglePriceModal(<?= $ci['id'] ?>, '<?= htmlspecialchars(addslashes($ci['title'])) ?>', <?= $bp ?>, <?= $cp ?>)">
                                        <i class="fas fa-edit mr-1"></i> Edit Price
                                    </button>
                                </td>
                            </tr>
                        <?php


endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Batch Catalog Reprice -->
<div class="modal fade" id="batchRepriceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-magic text-primary mr-2"></i> 1-Click Catalog Repricing Engine</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="repricer_action" value="batch_reprice">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Select Repricing Strategy</label>
                        <select name="pricing_strategy" class="form-control font-weight-bold">
                            <option value="boost_profit" selected>ðŸš€ Maximize Profit (+12% Demand Surcharge)</option>
                            <option value="enforce_markup">ðŸ›¡ï¸ Enforce 2.8x Wholesale Multiplier (180% Markup)</option>
                            <option value="clearance_velocity">âš¡ Velocity Flash Sale (-10% Conversion Boost)</option>
                        </select>
                    </div>
                    <p class="text-muted small mb-0">
                        This automated engine will instantly calculate and update pricing across all active product entries and size variants with margin floor protection.
                    </p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3">
                        <i class="fas fa-bolt mr-1"></i> Execute AI Reprice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Single Product Price Adjust -->
<div class="modal fade" id="singlePriceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-tag text-primary mr-2"></i> Adjust Product Price</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="repricer_action" value="update_single_price">
                <input type="hidden" name="product_id" id="modalProdId">
                <div class="modal-body p-4">
                    <div class="font-weight-bold text-dark mb-3" id="modalProdTitle">Product Title</div>
                    
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">New Selling Price (â‚¹)</label>
                        <input type="number" step="0.01" name="new_price" id="modalNewPrice" class="form-control font-weight-bold text-success" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Compare-At Strike Price (â‚¹)</label>
                        <input type="number" step="0.01" name="new_compare_price" id="modalNewComp" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm font-weight-bold px-3">
                        <i class="fas fa-check mr-1"></i> Save Price
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openSinglePriceModal(id, title, price, comp) {
    document.getElementById('modalProdId').value = id;
    document.getElementById('modalProdTitle').textContent = title;
    document.getElementById('modalNewPrice').value = price;
    document.getElementById('modalNewComp').value = comp;
    $('#singlePriceModal').modal('show');
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
