<?php
require_once __DIR__ . '/layout_header.php';

$msg = null;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['mbox_action'])) {
    $act = $_POST['mbox_action'];
    if ($act === 'create_drop') {
        $name   = $conn->real_escape_string(trim($_POST['drop_name'] ?? 'Atelier Mystery Drop'));
        $price  = (float)($_POST['price'] ?? 1299);
        $qty    = (int)($_POST['qty'] ?? 50);
        $reveal = $conn->real_escape_string($_POST['reveal_at'] ?? date('Y-m-d H:i:s', strtotime('+7 days')));
        $tier   = $conn->real_escape_string($_POST['tier'] ?? 'gold');
        $conn->query("INSERT INTO `mystery_drops` (`name`,`tier`,`price`,`qty_total`,`reveal_at`) VALUES ('$name','$tier',$price,$qty,'$reveal')");
        $msg = "Mystery Drop '<strong>$name</strong>' launched with $qty units!";
    } elseif ($act === 'reveal_drop') {
        $did = (int)($_POST['drop_id'] ?? 0);
        $conn->query("UPDATE `mystery_drops` SET `status`='revealed' WHERE id=$did");
        $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`) VALUES (1,'admin',1,'mystery_drop.revealed','mystery_drops',$did,'{\"revealed\":true}',NOW())");
        $msg = "🎉 Mystery Drop #$did revealed!";
    }
}

$conn->query("CREATE TABLE IF NOT EXISTS `mystery_drops` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `tier` VARCHAR(50) DEFAULT 'gold',
    `price` DECIMAL(10,2) DEFAULT 1299.00,
    `qty_total` INT DEFAULT 50,
    `qty_sold` INT DEFAULT 0,
    `reveal_at` DATETIME NOT NULL DEFAULT (DATE_ADD(NOW(), INTERVAL 7 DAY)),
    `status` ENUM('upcoming','live','revealed','sold_out') DEFAULT 'upcoming',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$drop_cnt = (int)($conn->query("SELECT COUNT(*) FROM `mystery_drops`")->fetch_row()[0] ?? 0);
if ($drop_cnt === 0) {
    $conn->query("INSERT INTO `mystery_drops` (`name`,`tier`,`price`,`qty_total`,`qty_sold`,`reveal_at`,`status`) VALUES
    ('Atelier Obsidian Mystery Box', 'black_diamond', 2499.00, 30, 18, DATE_ADD(NOW(), INTERVAL 2 DAY), 'live'),
    ('Lumina Gold Capsule Collection', 'gold', 1299.00, 50, 44, DATE_ADD(NOW(), INTERVAL 5 DAY), 'live'),
    ('Silver Wardrobe Surprise Drop', 'silver', 799.00, 100, 67, DATE_ADD(NOW(), INTERVAL 10 DAY), 'upcoming')");
}

$drops = $conn->query("SELECT * FROM `mystery_drops` ORDER BY created_at DESC LIMIT 20");
?>

<div class="container-fluid py-4 cont">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="badge px-3 py-1 font-weight-bold mb-1" style="background:#1e0a3c;color:#c084fc;font-size:0.78rem;border-radius:20px;">🎁 MYSTERY DROP ENGINE · MODULE 31</span>
            <h3 class="font-weight-bold text-dark mb-0"><i class="fas fa-box-open mr-2" style="color:#8b5cf6;"></i> Mystery Box &amp; Blind Drop Commerce</h3>
            <p class="text-muted mb-0 small">FOMO-driven surprise reveals — customers buy before seeing contents. Avg. 3× AOV vs standard products.</p>
        </div>
        <button class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#newDropModal">
            <i class="fas fa-plus mr-1"></i> Create Mystery Drop
        </button>
    </div>

    <?php if ($msg): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="fas fa-check-circle mr-2"></i><?= $msg ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
    <?php endif; ?>

    <!-- KPI Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule purple"><i class="fas fa-box"></i></div><span class="trend-pill success">● Live</span></div><div class="card-metric-title">Active Drops</div><div class="card-metric-value">3</div><div class="card-metric-desc">Live mystery boxes</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule rose"><i class="fas fa-fire"></i></div><span class="trend-pill success">+24% WoW</span></div><div class="card-metric-title">Total Buyers</div><div class="card-metric-value">129</div><div class="card-metric-desc">Pre-reveal purchasers</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule green"><i class="fas fa-rupee-sign"></i></div><span class="trend-pill success">This Month</span></div><div class="card-metric-title">Drop Revenue</div><div class="card-metric-value text-success">₹1,87,350</div><div class="card-metric-desc">Across all active tiers</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule amber"><i class="fas fa-smile-beam"></i></div><span class="trend-pill success">Excellent</span></div><div class="card-metric-title">Reveal Satisfaction</div><div class="card-metric-value">94%</div><div class="card-metric-desc">Post-reveal happiness score</div></div></div></div>
    </div>

    <!-- Tier Cards -->
    <div class="card shadow-sm border-0 mb-4 p-4" style="border-radius:16px; background:var(--bg-surface);">
        <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-layer-group text-primary mr-2"></i> Mystery Tier System — Click to Launch</h5>
        <div class="row">
            <?php
            $tiers = [
                ['name'=>'Silver Blind Box','tier'=>'silver','price'=>799,'icon'=>'🥈','color'=>'#94a3b8','desc'=>'3 curated basics + 1 surprise accessory. Valued at ₹1,800+.'],
                ['name'=>'Gold Capsule Drop','tier'=>'gold','price'=>1299,'icon'=>'🥇','color'=>'#f59e0b','desc'=>'5 premium pieces + 1 signature VIP item. Valued at ₹3,500+.'],
                ['name'=>'Platinum Atelier Box','tier'=>'platinum','price'=>2099,'icon'=>'💎','color'=>'#8b5cf6','desc'=>'7 luxury pieces + exclusive collab item. Valued at ₹6,000+.'],
                ['name'=>'Black Diamond Edition','tier'=>'black_diamond','price'=>3999,'icon'=>'🖤','color'=>'#1e293b','desc'=>'Full 10-piece bespoke wardrobe. Numbered & signed.'],
            ];
            foreach($tiers as $t): ?>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-top:4px solid <?= $t['color'] ?> !important; background:var(--bg-surface);">
                    <div class="text-center mb-2" style="font-size:2.2rem;"><?= $t['icon'] ?></div>
                    <h6 class="font-weight-bold text-dark text-center mb-1"><?= $t['name'] ?></h6>
                    <div class="text-center font-weight-bold mb-2" style="font-size:1.3rem; color:<?= $t['color'] ?>;">₹<?= number_format($t['price']) ?></div>
                    <p class="text-muted small text-center mb-3"><?= $t['desc'] ?></p>
                    <form method="post">
                        <input type="hidden" name="mbox_action" value="create_drop">
                        <input type="hidden" name="tier" value="<?= $t['tier'] ?>">
                        <input type="hidden" name="drop_name" value="<?= $t['name'] ?> — <?= date('M Y') ?>">
                        <input type="hidden" name="price" value="<?= $t['price'] ?>">
                        <input type="hidden" name="qty" value="50">
                        <input type="hidden" name="reveal_at" value="<?= date('Y-m-d H:i:s', strtotime('+7 days')) ?>">
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100 font-weight-bold">
                            <i class="fas fa-rocket mr-1"></i> Launch This Tier
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Drops Table -->
    <div class="card shadow-sm border-0 p-4" style="border-radius:16px; background:var(--bg-surface);">
        <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-calendar-check text-primary mr-2"></i> All Active &amp; Scheduled Drops</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle" style="font-size:0.88rem;">
                <thead class="thead-light"><tr><th>#</th><th>Drop Name</th><th>Tier</th><th>Price</th><th>Sold / Total</th><th>Reveal Date</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                <?php if ($drops): while($dr = $drops->fetch_assoc()):
                    $pct = $dr['qty_total'] > 0 ? round(($dr['qty_sold']/$dr['qty_total'])*100) : 0;
                    $bdg = ['upcoming'=>'secondary','live'=>'success','revealed'=>'info','sold_out'=>'danger'];
                    $bc  = $bdg[$dr['status']] ?? 'secondary';
                ?>
                <tr>
                    <td><strong>#<?= $dr['id'] ?></strong></td>
                    <td class="font-weight-bold"><?= htmlspecialchars($dr['name']) ?></td>
                    <td><span class="badge badge-light font-weight-bold text-uppercase" style="font-size:0.68rem;letter-spacing:0.5px;"><?= str_replace('_',' ',$dr['tier']) ?></span></td>
                    <td class="font-weight-bold text-success">₹<?= number_format($dr['price'],0) ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:80px;height:5px;background:#e2e8f0;border-radius:4px;overflow:hidden;">
                                <div style="width:<?= $pct ?>%;height:100%;background:<?= $pct>80?'#10b981':'#f59e0b' ?>;"></div>
                            </div>
                            <span class="small text-muted"><?= $dr['qty_sold'] ?>/<?= $dr['qty_total'] ?></span>
                        </div>
                    </td>
                    <td class="text-muted small"><?= date('d M Y g:ia', strtotime($dr['reveal_at'])) ?></td>
                    <td><span class="badge badge-<?= $bc ?>"><?= ucfirst(str_replace('_',' ',$dr['status'])) ?></span></td>
                    <td>
                        <?php if ($dr['status'] !== 'revealed'): ?>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="mbox_action" value="reveal_drop">
                            <input type="hidden" name="drop_id" value="<?= $dr['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-outline-success font-weight-bold"><i class="fas fa-eye mr-1"></i>Reveal</button>
                        </form>
                        <?php else: ?><span class="text-muted small">Revealed ✓</span><?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- New Drop Modal -->
<div class="modal fade" id="newDropModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1e0a3c,#2d1a60); color:#c084fc;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-box-open mr-2"></i> Create New Mystery Drop</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#c084fc;">&times;</button>
            </div>
            <form method="post">
                <input type="hidden" name="mbox_action" value="create_drop">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Drop Name</label>
                            <input type="text" name="drop_name" class="form-control" value="Atelier Mystery Drop <?= date('M Y') ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Tier</label>
                            <select name="tier" class="form-control">
                                <option value="silver">🥈 Silver (₹799)</option>
                                <option value="gold" selected>🥇 Gold (₹1,299)</option>
                                <option value="platinum">💎 Platinum (₹2,099)</option>
                                <option value="black_diamond">🖤 Black Diamond (₹3,999)</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Price (₹)</label>
                            <input type="number" name="price" class="form-control" value="1299" min="99" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Total Quantity</label>
                            <input type="number" name="qty" class="form-control" value="50" min="1" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold small text-uppercase text-muted">Reveal Date &amp; Time</label>
                            <input type="datetime-local" name="reveal_at" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime('+7 days')) ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-rocket mr-1"></i> Launch Mystery Drop</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>

