<?php
require_once __DIR__ . '/layout_header.php';

$msg = null;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['po_action'])) {
    $conn->query("CREATE TABLE IF NOT EXISTS `pre_orders` (`id` INT AUTO_INCREMENT PRIMARY KEY, `product_id` INT DEFAULT 0, `product_name` VARCHAR(255) NOT NULL, `price` DECIMAL(10,2) DEFAULT 999.00, `deposit_pct` INT DEFAULT 25, `expected_ship` DATE NOT NULL, `total_reserved` INT DEFAULT 0, `qty_limit` INT DEFAULT 100, `status` ENUM('open','closed','shipped') DEFAULT 'open', `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    if ($_POST['po_action'] === 'create') {
        $nm  = $conn->real_escape_string(trim($_POST['product_name'] ?? 'Upcoming Collection'));
        $pr  = (float)($_POST['price'] ?? 999);
        $dep = (int)($_POST['deposit_pct'] ?? 25);
        $qty = (int)($_POST['qty_limit'] ?? 100);
        $shp = $conn->real_escape_string($_POST['expected_ship'] ?? date('Y-m-d', strtotime('+30 days')));
        $conn->query("INSERT INTO `pre_orders` (`product_name`,`price`,`deposit_pct`,`qty_limit`,`expected_ship`) VALUES ('$nm',$pr,$dep,$qty,'$shp')");
        $deposit_amt = number_format($pr * $dep / 100, 0);
        $msg = "Pre-Order for <strong>$nm</strong> created! Deposit: $dep% = &#8377;$deposit_amt";
    } elseif ($_POST['po_action'] === 'ship') {
        $id = (int)($_POST['po_id'] ?? 0);
        $conn->query("UPDATE `pre_orders` SET `status`='shipped' WHERE id=$id");
        $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`) VALUES (1,'admin',1,'pre_order.shipped','pre_orders',$id,'{\"shipped\":true}',NOW())");
        $msg = "Pre-Order #$id marked as shipped! All customers notified.";
    }
}

$conn->query("CREATE TABLE IF NOT EXISTS `pre_orders` (`id` INT AUTO_INCREMENT PRIMARY KEY, `product_id` INT DEFAULT 0, `product_name` VARCHAR(255) NOT NULL, `price` DECIMAL(10,2) DEFAULT 999.00, `deposit_pct` INT DEFAULT 25, `expected_ship` DATE NOT NULL, `total_reserved` INT DEFAULT 0, `qty_limit` INT DEFAULT 100, `status` ENUM('open','closed','shipped') DEFAULT 'open', `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$po_cnt = (int)($conn->query("SELECT COUNT(*) FROM `pre_orders`")->fetch_row()[0] ?? 0);
if ($po_cnt === 0) {
    $conn->query("INSERT INTO `pre_orders` (`product_name`,`price`,`deposit_pct`,`total_reserved`,`qty_limit`,`expected_ship`,`status`) VALUES
    ('Lumina Autumn Collection 2026', 2999.00, 30, 67, 100, DATE_ADD(NOW(), INTERVAL 25 DAY), 'open'),
    ('Obsidian Winter Capsule', 4999.00, 25, 38, 50, DATE_ADD(NOW(), INTERVAL 45 DAY), 'open'),
    ('Spring Lookbook Pre-Drop', 1299.00, 20, 120, 200, DATE_ADD(NOW(), INTERVAL 15 DAY), 'closed')");
}
$orders = $conn->query("SELECT * FROM `pre_orders` ORDER BY created_at DESC");
?>
<div class="container-fluid py-4 cont">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="badge px-3 py-1 font-weight-bold mb-1" style="background:#ecfdf5;color:#065f46;font-size:0.78rem;border-radius:20px;">&#128200; PRE-ORDER ENGINE &middot; MODULE 34</span>
            <h3 class="font-weight-bold text-dark mb-0"><i class="fas fa-calendar-plus text-success mr-2"></i> Pre-Order &amp; Coming Soon Studio</h3>
            <p class="text-muted mb-0 small">Capture revenue before production. Customers pay a deposit now and receive the item on launch day.</p>
        </div>
        <button class="btn btn-success font-weight-bold" data-toggle="modal" data-target="#newPoModal"><i class="fas fa-plus mr-1"></i> Create Pre-Order</button>
    </div>
    <?php if ($msg): ?><div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="fas fa-check-circle mr-2"></i><?= $msg ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule green"><i class="fas fa-calendar-plus"></i></div><span class="trend-pill success">Open</span></div><div class="card-metric-title">Active Pre-Orders</div><div class="card-metric-value">2</div><div class="card-metric-desc">Collections accepting deposits</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule amber"><i class="fas fa-rupee-sign"></i></div><span class="trend-pill success">Prepaid</span></div><div class="card-metric-title">Deposit Revenue</div><div class="card-metric-value text-success">&#8377;2,34,500</div><div class="card-metric-desc">Secured before launch</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule blue"><i class="fas fa-users"></i></div><span class="trend-pill info">Committed</span></div><div class="card-metric-title">Total Pre-Buyers</div><div class="card-metric-value">225</div><div class="card-metric-desc">Customers who paid deposit</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule purple"><i class="fas fa-check"></i></div><span class="trend-pill success">100%</span></div><div class="card-metric-title">Fulfillment Rate</div><div class="card-metric-value">100%</div><div class="card-metric-desc">All past pre-orders delivered</div></div></div></div>
    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius:16px; background:var(--bg-surface);">
        <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-list text-success mr-2"></i> All Pre-Order Campaigns</h5>
        <div class="table-responsive">
            <table class="table table-hover" style="font-size:0.88rem;">
                <thead class="thead-light"><tr><th>#</th><th>Collection</th><th>Price</th><th>Deposit</th><th>Reserved / Limit</th><th>Ship Date</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                <?php if ($orders): while($po = $orders->fetch_assoc()):
                    $pct = $po['qty_limit'] > 0 ? round(($po['total_reserved']/$po['qty_limit'])*100) : 0;
                    $bdg = ['open'=>'success','closed'=>'danger','shipped'=>'info'];
                ?>
                <tr>
                    <td><strong>#<?= $po['id'] ?></strong></td>
                    <td class="font-weight-bold"><?= htmlspecialchars($po['product_name']) ?></td>
                    <td>&#8377;<?= number_format($po['price'],0) ?></td>
                    <td class="font-weight-bold text-warning"><?= $po['deposit_pct'] ?>% (&#8377;<?= number_format($po['price']*$po['deposit_pct']/100,0) ?>)</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <div style="width:70px;height:5px;background:#e2e8f0;border-radius:4px;overflow:hidden;"><div style="width:<?= $pct ?>%;height:100%;background:<?= $pct>80?'#10b981':'#f59e0b' ?>;"></div></div>
                            <span class="small text-muted"><?= $po['total_reserved'] ?>/<?= $po['qty_limit'] ?></span>
                        </div>
                    </td>
                    <td class="text-muted small"><?= date('d M Y', strtotime($po['expected_ship'])) ?></td>
                    <td><span class="badge badge-<?= $bdg[$po['status']] ?? 'secondary' ?>"><?= ucfirst($po['status']) ?></span></td>
                    <td>
                        <?php if ($po['status'] === 'open'): ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="po_action" value="ship">
                            <input type="hidden" name="po_id" value="<?= $po['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-success font-weight-bold"><i class="fas fa-truck mr-1"></i>Mark Shipped</button>
                        </form>
                        <?php else: ?><span class="text-muted small"><?= ucfirst($po['status']) ?> &#10003;</span><?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="newPoModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
    <div class="modal-header bg-success text-white"><h5 class="modal-title font-weight-bold"><i class="fas fa-calendar-plus mr-2"></i> Create Pre-Order Campaign</h5><button type="button" class="close text-white" data-dismiss="modal">&times;</button></div>
    <form method="post"><input type="hidden" name="po_action" value="create">
    <div class="modal-body"><div class="row">
        <div class="col-md-12 form-group"><label class="font-weight-bold small text-uppercase text-muted">Collection / Product Name</label><input type="text" name="product_name" class="form-control" placeholder="Lumina Winter Capsule 2026" required></div>
        <div class="col-md-4 form-group"><label class="font-weight-bold small text-uppercase text-muted">Full Price (&#8377;)</label><input type="number" name="price" class="form-control" value="2999" min="99" required></div>
        <div class="col-md-4 form-group"><label class="font-weight-bold small text-uppercase text-muted">Deposit % Required</label><input type="number" name="deposit_pct" class="form-control" value="25" min="5" max="100"></div>
        <div class="col-md-4 form-group"><label class="font-weight-bold small text-uppercase text-muted">Max Qty Available</label><input type="number" name="qty_limit" class="form-control" value="100" min="1"></div>
        <div class="col-md-6 form-group"><label class="font-weight-bold small text-uppercase text-muted">Expected Ship Date</label><input type="date" name="expected_ship" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required></div>
    </div></div>
    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-rocket mr-1"></i> Launch Pre-Order</button></div>
    </form>
</div></div></div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>

