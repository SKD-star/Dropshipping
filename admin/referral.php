<?php
require_once __DIR__ . '/layout_header.php';

// Ensure referral tables exist
$conn->query("CREATE TABLE IF NOT EXISTS `referrals` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `referrer_id` INT NOT NULL COMMENT 'customer who referred',
  `referee_id` INT DEFAULT NULL COMMENT 'customer who signed up via referral',
  `referral_code` VARCHAR(32) NOT NULL UNIQUE,
  `clicks` INT DEFAULT 0,
  `conversions` INT DEFAULT 0,
  `earnings` DECIMAL(12,2) DEFAULT 0.00,
  `pending_payout` DECIMAL(12,2) DEFAULT 0.00,
  `total_paid_out` DECIMAL(12,2) DEFAULT 0.00,
  `tier` TINYINT DEFAULT 1 COMMENT '1=standard 2=super 3=elite',
  `is_active` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE IF NOT EXISTS `affiliate_payouts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `referrer_id` INT NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL,
  `method` VARCHAR(50) DEFAULT 'bank',
  `status` ENUM('pending','approved','paid','rejected') DEFAULT 'pending',
  `note` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$msg = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $action = $_POST['ref_action'] ?? '';

    if ($action === 'generate_code') {
        $cust_id = (int)$_POST['customer_id'];
        if ($cust_id > 0) {
            $code = strtoupper(substr(md5($cust_id . time()), 0, 8));
            $conn->query("INSERT IGNORE INTO `referrals` (store_id, referrer_id, referral_code) VALUES (1, $cust_id, '$code')");
            $msg = "✦ Referral code <strong>$code</strong> generated for Customer #$cust_id!";
        }
    } elseif ($action === 'approve_payout') {
        $pid = (int)$_POST['payout_id'];
        $conn->query("UPDATE `affiliate_payouts` SET status='approved' WHERE id=$pid");
        $conn->query("UPDATE `referrals` r
            JOIN `affiliate_payouts` p ON r.referrer_id = p.referrer_id
            SET r.total_paid_out = r.total_paid_out + p.amount, r.pending_payout = GREATEST(0, r.pending_payout - p.amount)
            WHERE p.id=$pid AND p.status='approved'");
        $msg = "✦ Payout #$pid approved and balance updated!";
    } elseif ($action === 'update_commission') {
        $tier1 = (float)$_POST['tier1_pct'];
        $tier2 = (float)$_POST['tier2_pct'];
        $tier3 = (float)$_POST['tier3_pct'];
        // store in store_settings json if available, or a simple meta table
        $conn->query("INSERT INTO `store_settings` (store_id, `key`, `value`) VALUES (1,'ref_tier1','$tier1') ON DUPLICATE KEY UPDATE `value`='$tier1'");
        $conn->query("INSERT INTO `store_settings` (store_id, `key`, `value`) VALUES (1,'ref_tier2','$tier2') ON DUPLICATE KEY UPDATE `value`='$tier2'");
        $conn->query("INSERT INTO `store_settings` (store_id, `key`, `value`) VALUES (1,'ref_tier3','$tier3') ON DUPLICATE KEY UPDATE `value`='$tier3'");
        $msg = "✦ Commission rates saved! Tier 1: {$tier1}% | Tier 2: {$tier2}% | Tier 3: {$tier3}%";
    }
}

// Fetch commission settings
$t1 = 8; $t2 = 4; $t3 = 2;
$cr = $conn->query("SELECT `key`, `value` FROM `store_settings` WHERE store_id=1 AND `key` IN ('ref_tier1','ref_tier2','ref_tier3')");
if ($cr) { while ($row = $cr->fetch_assoc()) {
    if ($row['key']==='ref_tier1') $t1 = (float)$row['value'];
    if ($row['key']==='ref_tier2') $t2 = (float)$row['value'];
    if ($row['key']==='ref_tier3') $t3 = (float)$row['value'];
}}

// Stats
$total_affiliates = (int)($conn->query("SELECT COUNT(*) FROM `referrals`")->fetch_row()[0] ?? 0);
$total_earnings_r = $conn->query("SELECT COALESCE(SUM(earnings),0), COALESCE(SUM(pending_payout),0), COALESCE(SUM(conversions),0) FROM `referrals`");
[$total_earn, $total_pending, $total_conv] = $total_earnings_r ? $total_earnings_r->fetch_row() : [0,0,0];

$affiliates = [];
$ar = $conn->query("SELECT r.*, c.name as cust_name, c.email FROM `referrals` r LEFT JOIN `customers` c ON r.referrer_id=c.id ORDER BY r.earnings DESC LIMIT 20");
if ($ar) { while ($a = $ar->fetch_assoc()) $affiliates[] = $a; }

$payouts = [];
$pr = $conn->query("SELECT p.*, c.name as cust_name FROM `affiliate_payouts` p LEFT JOIN `customers` c ON p.referrer_id=c.id ORDER BY p.id DESC LIMIT 10");
if ($pr) { while ($p = $pr->fetch_assoc()) $payouts[] = $p; }

$customers = [];
$cust_r = $conn->query("SELECT id, name, email FROM `customers` ORDER BY name LIMIT 50");
if ($cust_r) { while ($c = $cust_r->fetch_assoc()) $customers[] = $c; }
?>

<div class="container-fluid py-4 cont">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge px-3 py-1 font-weight-bold" style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;font-size:0.8rem;border-radius:20px;">
                    🔗 3-TIER AFFILIATE ENGINE
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Auto-Commission · Referral Links · Payout Manager</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing:-0.5px;font-size:1.5rem;">
                <i class="fas fa-network-wired text-success mr-2"></i> Referral &amp; Affiliate Growth Engine
            </h3>
            <p class="text-muted mb-0" style="font-size:0.9rem;">3-tier commission architecture. Customers earn money by referring friends — auto-tracked, auto-calculated.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-success btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#generateCodeModal" style="border-radius:8px;padding:7px 16px;">
                <i class="fas fa-link mr-1"></i> Generate Referral Link
            </button>
            <button class="btn btn-outline-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#commissionModal" style="border-radius:8px;">
                <i class="fas fa-percent mr-1"></i> Commission Rates
            </button>
        </div>
    </div>

    <?php if ($msg): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle mr-2"></i> <?= $msg ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- KPI Row -->
    <div class="row mb-4">
        <?php $kpis = [
            ['Total Affiliates','fas fa-users','#10b981','#ecfdf5', number_format($total_affiliates),'Active Referrers'],
            ['Total Conversions','fas fa-handshake','#3b82f6','#eff6ff', number_format((int)$total_conv),'Orders via Referral'],
            ['Total Earned','fas fa-coins','#f59e0b','#fffbeb','₹'.number_format((float)$total_earn),'Commission Paid'],
            ['Pending Payouts','fas fa-clock','#8b5cf6','#f5f3ff','₹'.number_format((float)$total_pending),'Awaiting Approval'],
        ];
        foreach ($kpis as [$label, $icon, $color, $bg, $val, $sub]): ?>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px;background:var(--bg-surface);border-left:4px solid <?= $color ?> !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase"><?= $label ?></div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= $val ?></h3>
                        <div class="text-muted" style="font-size:0.75rem;"><?= $sub ?></div>
                    </div>
                    <div style="width:48px;height:48px;background:<?= $bg ?>;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:<?= $color ?>;"><i class="<?= $icon ?>"></i></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Commission Tier Visual -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;background:var(--bg-surface);">
        <div class="card-body p-4">
            <h5 class="font-weight-bold mb-3"><i class="fas fa-sitemap text-primary mr-2"></i> 3-Tier Commission Architecture</h5>
            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <div class="p-3 rounded-lg" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border:2px solid #10b981;">
                        <div style="font-size:2rem;">🧑</div>
                        <div class="font-weight-bold text-success mt-1">Tier 1 — Direct Referral</div>
                        <div style="font-size:2rem;font-weight:900;color:#059669;"><?= $t1 ?>%</div>
                        <div class="text-muted small">On every order from direct referrals</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 rounded-lg" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:2px solid #3b82f6;">
                        <div style="font-size:2rem;">👥</div>
                        <div class="font-weight-bold text-primary mt-1">Tier 2 — Sub-Referral</div>
                        <div style="font-size:2rem;font-weight:900;color:#2563eb;"><?= $t2 ?>%</div>
                        <div class="text-muted small">When your referrals bring friends</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-3 rounded-lg" style="background:linear-gradient(135deg,#f5f3ff,#ede9fe);border:2px solid #8b5cf6;">
                        <div style="font-size:2rem;">🌐</div>
                        <div class="font-weight-bold mt-1" style="color:#7c3aed;">Tier 3 — Network</div>
                        <div style="font-size:2rem;font-weight:900;color:#7c3aed;"><?= $t3 ?>%</div>
                        <div class="text-muted small">3-level deep passive income</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Affiliate Leaderboard + Payouts -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius:14px;background:var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="font-weight-bold"><i class="fas fa-trophy text-warning mr-2"></i> Top Affiliate Leaderboard</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="font-size:0.85rem;">
                            <thead class="thead-light">
                                <tr><th>#</th><th>Affiliate</th><th>Code</th><th>Clicks</th><th>Conversions</th><th>Earned</th><th>Pending</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($affiliates)): ?>
                                    <?php foreach ($affiliates as $i => $a): ?>
                                    <tr>
                                        <td><strong class="text-muted"><?= $i+1 ?></strong></td>
                                        <td>
                                            <div class="font-weight-bold"><?= htmlspecialchars($a['cust_name'] ?? 'Guest') ?></div>
                                            <div class="text-muted" style="font-size:0.75rem;"><?= htmlspecialchars($a['email'] ?? '') ?></div>
                                        </td>
                                        <td><code class="px-2 py-1 rounded" style="background:#f0fdf4;color:#166534;font-size:0.82rem;"><?= htmlspecialchars($a['referral_code']) ?></code></td>
                                        <td><?= number_format((int)$a['clicks']) ?></td>
                                        <td><span class="badge badge-success"><?= (int)$a['conversions'] ?></span></td>
                                        <td class="font-weight-bold text-success">₹<?= number_format((float)$a['earnings']) ?></td>
                                        <td class="text-warning font-weight-bold">₹<?= number_format((float)$a['pending_payout']) ?></td>
                                        <td><?= $a['is_active'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="8" class="text-center py-5 text-muted"><i class="fas fa-network-wired fa-2x mb-2 d-block text-success"></i><strong>No affiliates yet.</strong><div class="small">Generate referral codes above to onboard your first affiliate.</div></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:14px;background:var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom">
                    <span class="font-weight-bold"><i class="fas fa-money-check-alt text-info mr-2"></i> Payout Requests</span>
                </div>
                <div class="card-body p-0" style="max-height:350px;overflow-y:auto;">
                    <?php if (!empty($payouts)): ?>
                        <?php foreach ($payouts as $p):
                            $sc = ['pending'=>'warning','approved'=>'primary','paid'=>'success','rejected'=>'danger'][$p['status']] ?? 'secondary'; ?>
                        <div class="p-3 border-bottom" style="font-size:0.83rem;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="font-weight-bold"><?= htmlspecialchars($p['cust_name'] ?? 'Customer') ?></div>
                                    <div class="text-success font-weight-bold">₹<?= number_format((float)$p['amount']) ?></div>
                                    <div class="text-muted" style="font-size:0.72rem;"><?= date('d M Y', strtotime($p['created_at'])) ?></div>
                                </div>
                                <div class="text-right">
                                    <span class="badge badge-<?= $sc ?>"><?= ucfirst($p['status']) ?></span>
                                    <?php if ($p['status']==='pending'): ?>
                                    <form method="POST" class="mt-1">
                                        <input type="hidden" name="ref_action" value="approve_payout">
                                        <input type="hidden" name="payout_id" value="<?= $p['id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-success py-0 px-2" style="font-size:0.72rem;">Approve</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted small"><i class="fas fa-money-check-alt fa-2x mb-2 d-block"></i>No payout requests yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Generate Referral Code -->
<div class="modal fade" id="generateCodeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#10b981,#059669);border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-link mr-2"></i> Generate Affiliate Referral Link</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="ref_action" value="generate_code">
                <div class="modal-body p-4">
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Select Customer / Affiliate</label>
                        <select name="customer_id" class="form-control font-weight-bold">
                            <?php foreach ($customers as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name'] ?: 'Guest') ?> — <?= htmlspecialchars($c['email']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm font-weight-bold px-4">
                        <i class="fas fa-magic mr-1"></i> Generate Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Commission Rates -->
<div class="modal fade" id="commissionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#4361ee,#7209b7);border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-percent mr-2"></i> Configure Commission Rates</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="ref_action" value="update_commission">
                <div class="modal-body p-4">
                    <div class="form-group"><label class="font-weight-bold">Tier 1 — Direct Referral %</label><div class="input-group"><input type="number" step="0.5" name="tier1_pct" class="form-control font-weight-bold" value="<?= $t1 ?>"><div class="input-group-append"><span class="input-group-text">%</span></div></div></div>
                    <div class="form-group"><label class="font-weight-bold">Tier 2 — Sub-Referral %</label><div class="input-group"><input type="number" step="0.5" name="tier2_pct" class="form-control font-weight-bold" value="<?= $t2 ?>"><div class="input-group-append"><span class="input-group-text">%</span></div></div></div>
                    <div class="form-group mb-0"><label class="font-weight-bold">Tier 3 — Network Deep %</label><div class="input-group"><input type="number" step="0.5" name="tier3_pct" class="form-control font-weight-bold" value="<?= $t3 ?>"><div class="input-group-append"><span class="input-group-text">%</span></div></div></div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-4"><i class="fas fa-save mr-1"></i> Save Rates</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
