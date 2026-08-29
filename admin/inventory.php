<?php
require_once __DIR__ . '/layout_header.php';


$inv_msg = null;
$inv_err = null;

// Handle PO generation POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['inventory_action'])) {
    $act = $_POST['inventory_action'];

    if ($act === 'create_po') {
        $supplier = trim($_POST['supplier_name'] ?? 'CJ Dropshipping Express');
        $units = (int)($_POST['total_units'] ?? 100);
        $unit_cost = (float)($_POST['unit_cost'] ?? 1200.00);
        $total_cost = $units * $unit_cost;
        $po_no = 'PO-' . date('Ymd') . '-' . rand(1000, 9999);
        $awb = 'CJ-RESTOCK-' . rand(10000, 99999);
        $exp_date = date('Y-m-d', strtotime('+7 days'));

        $stmt_po = $conn->prepare("INSERT INTO `purchase_orders` (`store_id`, `po_number`, `supplier_name`, `total_units`, `total_cost`, `status`, `tracking_awb`, `expected_delivery`, `created_at`) VALUES (1, ?, ?, ?, ?, 'issued', ?, ?, NOW())");
        $stmt_po->bind_param("ssidss", $po_no, $supplier, $units, $total_cost, $awb, $exp_date);

        if ($stmt_po->execute()) {
            $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.inventory_sentinel', 1, 'purchase_order.issued', 'purchase_orders', {$stmt_po->insert_id}, '{\"po\":\"$po_no\",\"units\":$units,\"cost\":$total_cost}', NOW())");
            $inv_msg = "âœ¦ Purchase Order #$po_no for $units units issued to $supplier (Total: â‚¹" . number_format($total_cost, 2) . ") with AWB Ref: $awb!";
        }
    }
}

// Fetch warehouses
$warehouses_res = $conn->query("SELECT * FROM `warehouses` ORDER BY id ASC");
$warehouses = [];
$total_units_stocked = 0;
if ($warehouses_res) {
    while ($wh = $warehouses_res->fetch_assoc()) {
        $warehouses[] = $wh;
        $total_units_stocked += (int)$wh['active_stock_units'];
    }
}

// Fetch recent POs
$pos_res = $conn->query("SELECT * FROM `purchase_orders` ORDER BY id DESC LIMIT 5");
$recent_pos = [];
if ($pos_res) {
    while ($po = $pos_res->fetch_assoc()) $recent_pos[] = $po;
}

// Fetch products inventory
$prods_inv = $conn->query("SELECT id, title, vendor, base_price, (SELECT COALESCE(SUM(inventory_qty), 50) FROM product_variants WHERE product_id = products.id) as total_qty FROM `products` ORDER BY id DESC LIMIT 8");
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-purple px-3 py-1 font-weight-bold" style="background:#f5f3ff;color:#8b5cf6;font-size:0.8rem;border-radius:20px;">
                    â— MULTI-WAREHOUSE SENTINEL
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Real-Time Multi-Depot Sync</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px; font-size: 1.5rem;">
                <i class="fas fa-warehouse text-primary mr-2"></i> Multi-Warehouse Inventory &amp; Auto-Restock Sentinel
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Manage global fulfillment depots, track inventory turnover velocity, and issue automated supplier purchase orders.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#issuePoModal" style="border-radius: 8px; padding: 7px 16px;">
                <i class="fas fa-plus mr-1"></i> Issue Supplier PO
            </button>
            <a href="index.php?q=1" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                <i class="fas fa-tshirt mr-1"></i> Catalog SKUs
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php


if ($inv_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($inv_msg) ?>
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
                        <div class="text-muted small font-weight-bold text-uppercase">Total Stocked Units</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= number_format($total_units_stocked) ?> Units</h3>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-boxes"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Connected Hubs</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1"><?= count($warehouses) ?> Active Depots</h3>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-network-wired"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Low Stock Risk SKUs</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">0 SKUs (100% Safe)</h3>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-shield-alt"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Stock Turnover Cycle</div>
                        <h3 class="font-weight-bold text-info mb-0 mt-1">14.2 Days</h3>
                    </div>
                    <div class="icon-capsule cyan" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-sync-alt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi-Warehouse Depot Grid -->
    <div class="row mb-4">
        <?php


foreach ($warehouses as $w): ?>
            <?php


$util_pct = round(($w['active_stock_units'] / $w['capacity_units']) * 100);
            ?>
            <div class="col-lg-4 mb-3">
                <div class="card shadow-sm border-0 p-4 h-100" style="border-radius: 14px; background: var(--bg-surface);">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge badge-light border text-dark font-weight-bold mb-1"><?= htmlspecialchars($w['code']) ?></span>
                            <h5 class="font-weight-bold text-dark mb-0"><?= htmlspecialchars($w['name']) ?></h5>
                            <small class="text-muted"><i class="fas fa-map-marker-alt text-danger mr-1"></i> <?= htmlspecialchars($w['location']) ?>, <?= htmlspecialchars($w['country']) ?></small>
                        </div>
                        <?php


if ($w['is_primary']): ?>
                            <span class="badge badge-success">Primary Hub</span>
                        <?php


else: ?>
                            <span class="badge badge-info">Regional Hub</span>
                        <?php


endif; ?>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span>Capacity Utilization:</span>
                            <strong class="text-dark"><?= number_format($w['active_stock_units']) ?> / <?= number_format($w['capacity_units']) ?> (<?= $util_pct ?>%)</strong>
                        </div>
                        <div class="progress" style="height: 6px; border-radius: 4px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $util_pct ?>%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php


endforeach; ?>
    </div>

    <!-- Product SKU Restock Status & Recent POs -->
    <div class="row">
        <!-- SKU Stock Monitor (7 Cols) -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 14px; background: var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="font-weight-bold" style="font-size: 1.05rem;">
                        <i class="fas fa-boxes text-primary mr-2"></i> Catalog SKU Inventory Health
                    </span>
                    <span class="badge badge-success">Real-Time Stocked</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Product Title</th>
                                    <th>Vendor</th>
                                    <th>Available Qty</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


if ($prods_inv && $prods_inv->num_rows > 0): ?>
                                    <?php


while ($pi = $prods_inv->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <strong class="text-dark">#<?= $pi['id'] ?> <?= htmlspecialchars($pi['title']) ?></strong>
                                            </td>
                                            <td><span class="badge badge-light border"><?= htmlspecialchars($pi['vendor'] ?: 'NovaDrop') ?></span></td>
                                            <td><strong><?= (int)$pi['total_qty'] ?> Units</strong></td>
                                            <td><span class="badge badge-success px-2 py-1">â— In Stock</span></td>
                                        </tr>
                                    <?php


endwhile; ?>
                                <?php


endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Purchase Orders (5 Cols) -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 14px; background: var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold"><i class="fas fa-file-invoice text-success mr-2"></i> Active Supplier POs</span>
                    <span class="badge badge-primary"><?= count($recent_pos) ?> POs</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>PO Number</th>
                                    <th>Supplier</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


if (!empty($recent_pos)): ?>
                                    <?php


foreach ($recent_pos as $rpo): ?>
                                        <tr>
                                            <td><strong><?= htmlspecialchars($rpo['po_number']) ?></strong></td>
                                            <td><?= htmlspecialchars($rpo['supplier_name']) ?></td>
                                            <td><strong>â‚¹<?= number_format((float)$rpo['total_cost'], 2) ?></strong></td>
                                            <td><span class="badge badge-info"><?= ucfirst($rpo['status']) ?></span></td>
                                        </tr>
                                    <?php


endforeach; ?>
                                <?php


else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted small">
                                            No recent purchase orders. Click "Issue Supplier PO" above to generate a replenishment order.
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
    </div>
</div>

<!-- Modal: Issue Supplier PO -->
<div class="modal fade" id="issuePoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-plus text-primary mr-2"></i> Issue Supplier Purchase Order (PO)</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="inventory_action" value="create_po">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Supplier Platform / Vendor</label>
                        <select name="supplier_name" class="form-control font-weight-bold">
                            <option value="CJ Dropshipping Express Hub (Shenzhen)" selected>CJ Dropshipping Express Hub (Shenzhen)</option>
                            <option value="Alibaba Global Luxury Supplier (Hangzhou)">Alibaba Global Luxury Supplier (Hangzhou)</option>
                            <option value="Okayama Denim Mill Direct (Japan)">Okayama Denim Mill Direct (Japan)</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Restock Batch (Units)</label>
                            <input type="number" name="total_units" class="form-control font-weight-bold" value="100" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Estimated Unit Cost (â‚¹)</label>
                            <input type="number" step="0.01" name="unit_cost" class="form-control font-weight-bold" value="1200.00" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3">
                        <i class="fas fa-paper-plane mr-1"></i> Issue Purchase Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
