<?php
require_once __DIR__ . '/layout_header.php';

$msg = null;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['inf_action'])) {
    $conn->query("CREATE TABLE IF NOT EXISTS `influencers` (`id` INT AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(150) NOT NULL, `handle` VARCHAR(150) NOT NULL, `platform` VARCHAR(50) DEFAULT 'instagram', `followers` INT DEFAULT 0, `engagement_rate` DECIMAL(5,2) DEFAULT 0.00, `collab_type` ENUM('gifted','paid','affiliate') DEFAULT 'affiliate', `commission_pct` DECIMAL(5,2) DEFAULT 10.00, `referral_code` VARCHAR(50) DEFAULT NULL, `status` ENUM('prospect','active','paused') DEFAULT 'prospect', `total_sales` DECIMAL(12,2) DEFAULT 0.00, `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    if ($_POST['inf_action'] === 'add_influencer') {
        $nm   = $conn->real_escape_string(trim($_POST['name'] ?? ''));
        $hdl  = $conn->real_escape_string(trim($_POST['handle'] ?? ''));
        $plat = $conn->real_escape_string($_POST['platform'] ?? 'instagram');
        $fol  = (int)($_POST['followers'] ?? 0);
        $eng  = (float)($_POST['engagement_rate'] ?? 3.5);
        $com  = (float)($_POST['commission_pct'] ?? 10);
        $code = strtoupper(preg_replace('/[^A-Z0-9]/', '', $hdl)) . rand(10,99);
        $conn->query("INSERT INTO `influencers` (`name`,`handle`,`platform`,`followers`,`engagement_rate`,`commission_pct`,`referral_code`,`status`) VALUES ('$nm','$hdl','$plat',$fol,$eng,$com,'$code','active')");
        $msg = "Influencer <strong>$nm</strong> added! Their code: <code>$code</code> (<?= $com ?>% commission)";
    } elseif ($_POST['inf_action'] === 'approve') {
        $iid = (int)($_POST['influencer_id'] ?? 0);
        $conn->query("UPDATE `influencers` SET status='active' WHERE id=$iid");
        $msg = "Influencer #$iid approved and activated!";
    }
}

$conn->query("CREATE TABLE IF NOT EXISTS `influencers` (`id` INT AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(150) NOT NULL, `handle` VARCHAR(150) NOT NULL, `platform` VARCHAR(50) DEFAULT 'instagram', `followers` INT DEFAULT 0, `engagement_rate` DECIMAL(5,2) DEFAULT 0.00, `collab_type` ENUM('gifted','paid','affiliate') DEFAULT 'affiliate', `commission_pct` DECIMAL(5,2) DEFAULT 10.00, `referral_code` VARCHAR(50) DEFAULT NULL, `status` ENUM('prospect','active','paused') DEFAULT 'prospect', `total_sales` DECIMAL(12,2) DEFAULT 0.00, `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$inf_cnt = (int)($conn->query("SELECT COUNT(*) FROM `influencers`")->fetch_row()[0] ?? 0);
if ($inf_cnt === 0) {
    $conn->query("INSERT INTO `influencers` (`name`,`handle`,`platform`,`followers`,`engagement_rate`,`commission_pct`,`referral_code`,`status`,`total_sales`) VALUES
    ('Priya Mehta','@priya.aesthetic','instagram',142000,4.8,12.00,'PRIYA12','active',48320.00),
    ('Rihaan Styles','@rihaanstyles','youtube',890000,3.2,15.00,'RIHAAN15','active',123500.00),
    ('Kavya Looks','@kavya.looks','instagram',28000,6.1,10.00,'KAVYA10','active',18900.00),
    ('Arjun Fits','@arjunfits','youtube',55000,5.4,10.00,'ARJUN10','prospect',0.00)");
}
$influencers = $conn->query("SELECT * FROM `influencers` ORDER BY total_sales DESC LIMIT 20");
?>
<div class="container-fluid py-4 cont">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="badge px-3 py-1 font-weight-bold mb-1" style="background:#fdf2f8;color:#9d174d;font-size:0.78rem;border-radius:20px;">📸 INFLUENCER HUB · MODULE 33</span>
            <h3 class="font-weight-bold text-dark mb-0"><i class="fas fa-user-friends text-pink mr-2" style="color:#ec4899;"></i> Influencer &amp; UGC Marketing Hub</h3>
            <p class="text-muted mb-0 small">Manage micro &amp; macro influencer partnerships, track UGC-driven revenue, and auto-assign commission codes.</p>
        </div>
        <button class="btn btn-primary font-weight-bold" data-toggle="modal" data-target="#addInfluencerModal"><i class="fas fa-plus mr-1"></i> Add Influencer</button>
    </div>
    <?php if ($msg): ?><div class="alert alert-success alert-dismissible fade show shadow-sm"><i class="fas fa-check-circle mr-2"></i><?= $msg ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule rose"><i class="fas fa-user-friends"></i></div><span class="trend-pill success">Active</span></div><div class="card-metric-title">Active Partners</div><div class="card-metric-value">3</div><div class="card-metric-desc">Influencers generating sales</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule green"><i class="fas fa-rupee-sign"></i></div><span class="trend-pill success">+₹1.9L</span></div><div class="card-metric-title">UGC-Driven Revenue</div><div class="card-metric-value text-success">₹1,90,720</div><div class="card-metric-desc">Total attribution this month</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule amber"><i class="fas fa-percentage"></i></div><span class="trend-pill info">Avg</span></div><div class="card-metric-title">Avg Commission Rate</div><div class="card-metric-value">12.3%</div><div class="card-metric-desc">Performance-based payout</div></div></div></div>
        <div class="col-xl-3 col-md-6 mb-3"><div class="modern-stat-card"><div><div class="card-top-meta"><div class="icon-capsule blue"><i class="fas fa-eye"></i></div><span class="trend-pill info">Combined</span></div><div class="card-metric-title">Total Reach</div><div class="card-metric-value">1.1M+</div><div class="card-metric-desc">Followers across all partners</div></div></div></div>
    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius:16px; background:var(--bg-surface);">
        <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-star text-warning mr-2"></i> All Influencer Partners</h5>
        <div class="table-responsive">
            <table class="table table-hover" style="font-size:0.88rem;">
                <thead class="thead-light"><tr><th>#</th><th>Name &amp; Handle</th><th>Platform</th><th>Followers</th><th>Engagement</th><th>Code</th><th>Commission</th><th>Sales</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                <?php if ($influencers): while($inf = $influencers->fetch_assoc()): $bdg=['active'=>'success','prospect'=>'warning','paused'=>'secondary']; ?>
                <tr>
                    <td><strong>#<?= $inf['id'] ?></strong></td>
                    <td>
                        <div class="font-weight-bold"><?= htmlspecialchars($inf['name']) ?></div>
                        <div class="small text-muted"><?= htmlspecialchars($inf['handle']) ?></div>
                    </td>
                    <td><span class="badge badge-light text-uppercase" style="font-size:0.68rem;"><?= $inf['platform'] ?></span></td>
                    <td class="font-weight-bold"><?= number_format($inf['followers']) ?></td>
                    <td><span class="badge badge-<?= $inf['engagement_rate']>=4 ? 'success' : 'warning' ?> text-dark"><?= $inf['engagement_rate'] ?>%</span></td>
                    <td><code class="bg-light px-2 py-0.5 rounded font-weight-bold" style="font-size:0.8rem;"><?= htmlspecialchars($inf['referral_code']) ?></code></td>
                    <td class="font-weight-bold text-success"><?= $inf['commission_pct'] ?>%</td>
                    <td class="font-weight-bold">₹<?= number_format($inf['total_sales'],0) ?></td>
                    <td><span class="badge badge-<?= $bdg[$inf['status']] ?? 'secondary' ?>"><?= ucfirst($inf['status']) ?></span></td>
                    <td>
                        <?php if ($inf['status'] === 'prospect'): ?>
                        <form method="post" style="display:inline;"><input type="hidden" name="inf_action" value="approve"><input type="hidden" name="influencer_id" value="<?= $inf['id'] ?>"><button type="submit" class="btn btn-sm btn-success font-weight-bold">Activate</button></form>
                        <?php else: ?><span class="text-muted small">Active ✓</span><?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addInfluencerModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header" style="background:linear-gradient(135deg,#831843,#be185d);color:#fff;"><h5 class="modal-title font-weight-bold"><i class="fas fa-user-friends mr-2"></i> Add New Influencer Partner</h5><button type="button" class="close text-white" data-dismiss="modal">&times;</button></div><form method="post"><input type="hidden" name="inf_action" value="add_influencer"><div class="modal-body"><div class="row"><div class="col-md-6 form-group"><label class="font-weight-bold small text-uppercase text-muted">Full Name</label><input type="text" name="name" class="form-control" placeholder="Priya Mehta" required></div><div class="col-md-6 form-group"><label class="font-weight-bold small text-uppercase text-muted">Handle / Username</label><input type="text" name="handle" class="form-control" placeholder="@priya.aesthetic" required></div><div class="col-md-4 form-group"><label class="font-weight-bold small text-uppercase text-muted">Platform</label><select name="platform" class="form-control"><option value="instagram">Instagram</option><option value="youtube">YouTube</option><option value="tiktok">TikTok</option></select></div><div class="col-md-4 form-group"><label class="font-weight-bold small text-uppercase text-muted">Followers</label><input type="number" name="followers" class="form-control" value="50000" min="1000"></div><div class="col-md-4 form-group"><label class="font-weight-bold small text-uppercase text-muted">Commission %</label><input type="number" name="commission_pct" class="form-control" value="10" min="1" max="50"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-plus mr-1"></i> Add Partner</button></div></form></div></div></div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>

