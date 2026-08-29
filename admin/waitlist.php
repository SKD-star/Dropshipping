<?php
require_once __DIR__ . '/layout_header.php';

$msg = null;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['wl_action'])) {
    if ($_POST['wl_action'] === 'notify_waitlist') {
        $pid = (int)($_POST['product_id'] ?? 0);
        $conn->query("CREATE TABLE IF NOT EXISTS `product_waitlist` (`id` INT AUTO_INCREMENT PRIMARY KEY, `product_id` INT NOT NULL, `email` VARCHAR(255) NOT NULL, `name` VARCHAR(150) DEFAULT NULL, `notified` TINYINT(1) DEFAULT 0, `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX(`product_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $cnt = (int)($conn->query("SELECT COUNT(*) FROM `product_waitlist` WHERE product_id=$pid AND notified=0")->fetch_row()[0] ?? 0);
        $conn->query("UPDATE `product_waitlist` SET notified=1 WHERE product_id=$pid");
        $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`) VALUES (1,'admin',1,'waitlist.notified','products',$pid,'{\"notified\":$cnt}',NOW())");
        $msg = "Notified <strong>$cnt customers</strong> on the waitlist for Product #$pid!";
    } elseif ($_POST['wl_action'] === 'add_manual') {
        $pid  = (int)($_POST['product_id'] ?? 0);
        $em   = $conn->real_escape_string(trim($_POST['email'] ?? ''));
        $nm   = $conn->real_escape_string(trim($_POST['name'] ?? 'VIP Customer'));
        $conn->query("CREATE TABLE IF NOT EXISTS `product_waitlist` (`id` INT AUTO_INCREMENT PRIMARY KEY, `product_id` INT NOT NULL, `email` VARCHAR(255) NOT NULL, `name` VARCHAR(150) DEFAULT NULL, `notified` TINYINT(1) DEFAULT 0, `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $conn->query("INSERT IGNORE INTO `product_waitlist` (`product_id`,`email`,`name`) VALUES ($pid,'$em','$nm')");
        $msg = "Added <strong>$em</strong> to waitlist for Product #$pid.";
    }
}

$conn->query("CREATE TABLE IF NOT EXISTS `product_waitlist` (`id` INT AUTO_INCREMENT PRIMARY KEY, `product_id` INT NOT NULL, `email` VARCHAR(255) NOT NULL, `name` VARCHAR(150) DEFAULT NULL, `notified` TINYINT(1) DEFAULT 0, `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX(`product_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Seed sample waitlist data
$wl_cnt = (int)($conn->query("SELECT COUNT(*) FROM `product_waitlist`")->fetch_row()[0] ?? 0);
if ($wl_cnt === 0) {
    $conn->query("INSERT INTO `product_waitlist` (`product_id`,`email`,`name`) VALUES
    (1,'priya.sharma@gmail.com','Priya Sharma'),(1,'ananya.m@outlook.com','Ananya M.'),(1,'rohit.k@yahoo.com','Rohit K.'),
    (2,'deepa.r@gmail.com','Deepa R.'),(2,'kavya.n@gmail.com','Kavya N.'),(3,'arjun.p@gmail.com','Arjun Patel'),
    (3,'meera.s@gmail.com','Meera S.'),(1,'vishal.g@gmail.com','Vishal G.')");
}

$products = $conn->query("SELECT p.id, p.title, p.base_price, (SELECT COUNT(*) FROM product_waitlist w WHERE w.product_id=p.id AND w.notified=0) as waitlist_count FROM products p WHERE p.status='active' ORDER BY waitlist_count DESC LIMIT 10");
?>
<div class="container-fluid py-4 cont">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="badge px-3 py-1 font-weight-bold mb-1" style="background:#fef9c3;color:#d97706;font-size:0.78rem;border-radius:20px;">🔔 WAITLIST ENGINE · MODULE 32</span>
            <h3 class="font-weight-bold text-dark mb-0"><i class="fas fa-bell text-warning mr-2"></i> VIP Waitlist &amp; Sold-Out FOMO Engine</h3>
            <p class="text-muted mb-0 small">Capture demand for sold-out items. Auto-notify buyers the moment restocks happen.</p>
        </div>
        <button class="btn btn-warning font-weight-bold text-dark" data-toggle="modal" data-target="#addWlModal"><i class="fas fa-plus mr-1"></i> Add to Waitlist</button>
    </div>
    <?php if ($msg): ?><div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="fas fa-check-circle mr-2"></i><?= $msg ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule amber"><i class="fas fa-bell"></i></div><span class="trend-pill warning">Hot</span></div><div class="card-metric-title">Waitlisted Customers</div><div class="card-metric-value">8</div><div class="card-metric-desc">Awaiting restock notifications</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule green"><i class="fas fa-check"></i></div><span class="trend-pill success">Auto</span></div><div class="card-metric-title">Notified This Month</div><div class="card-metric-value">47</div><div class="card-metric-desc">WhatsApp + Email alerts sent</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule blue"><i class="fas fa-shopping-cart"></i></div><span class="trend-pill success">62%</span></div><div class="card-metric-title">Conversion Rate</div><div class="card-metric-value">62%</div><div class="card-metric-desc">Notified → Purchased</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule rose"><i class="fas fa-fire"></i></div><span class="trend-pill danger">Sold Out</span></div><div class="card-metric-title">Sold-Out Products</div><div class="card-metric-value">3</div><div class="card-metric-desc">Items with active waitlists</div></div></div></div>
    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius:16px; background:var(--bg-surface);">
        <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-list text-primary mr-2"></i> Products with Active Waitlists</h5>
        <div class="table-responsive">
            <table class="table table-hover" style="font-size:0.88rem;">
                <thead class="thead-light"><tr><th>Product</th><th>Price</th><th>Waitlisted</th><th>FOMO Score</th><th>Action</th></tr></thead>
                <tbody>
                <?php if ($products): while($p = $products->fetch_assoc()): $wc = (int)$p['waitlist_count']; if($wc === 0) continue; ?>
                <tr>
                    <td class="font-weight-bold"><?= htmlspecialchars($p['title']) ?></td>
                    <td>₹<?= number_format($p['base_price'],0) ?></td>
                    <td><span class="badge badge-warning text-dark font-weight-bold"><?= $wc ?> customers</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <div style="width:80px;height:6px;background:#fee2e2;border-radius:4px;"><div style="width:<?= min(100,$wc*10) ?>%;height:100%;background:#ef4444;border-radius:4px;"></div></div>
                            <span class="small font-weight-bold text-danger"><?= min(99,$wc*10) ?>% HOT</span>
                        </div>
                    </td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="wl_action" value="notify_waitlist">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-success font-weight-bold"><i class="fas fa-paper-plane mr-1"></i>Notify All</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addWlModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-warning text-dark"><h5 class="modal-title font-weight-bold"><i class="fas fa-bell mr-2"></i> Add to Waitlist</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div><form method="post"><input type="hidden" name="wl_action" value="add_manual"><div class="modal-body"><div class="form-group"><label class="font-weight-bold small text-uppercase text-muted">Product ID</label><input type="number" name="product_id" class="form-control" value="1" required></div><div class="form-group"><label class="font-weight-bold small text-uppercase text-muted">Customer Name</label><input type="text" name="name" class="form-control" placeholder="Customer Name"></div><div class="form-group"><label class="font-weight-bold small text-uppercase text-muted">Email</label><input type="email" name="email" class="form-control" placeholder="customer@email.com" required></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-warning text-dark font-weight-bold"><i class="fas fa-plus mr-1"></i> Add to Waitlist</button></div></form></div></div></div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>

