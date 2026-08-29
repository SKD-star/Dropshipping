<?php
require_once __DIR__ . '/layout_header.php';


$loy_msg = null;
$loy_err = null;

// Handle Loyalty Actions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['loyalty_action'])) {
    $act = $_POST['loyalty_action'];

    if ($act === 'award_points') {
        $cust_id = (int)$_POST['customer_id'];
        $pts = (int)$_POST['points'];
        $reason = trim($_POST['reason'] ?? 'Admin Manual Award');
        if ($cust_id > 0 && $pts > 0) {
            $conn->query("UPDATE `customers` SET `loyalty_points` = COALESCE(`loyalty_points`,0) + $pts WHERE id = $cust_id");
            $conn->query("INSERT INTO `loyalty_transactions` (`store_id`,`customer_id`,`points`,`type`,`reason`,`created_at`) VALUES (1,$cust_id,$pts,'credit','" . $conn->real_escape_string($reason) . "',NOW())");
            // Auto-upgrade tier
            $spend_res = $conn->query("SELECT SUM(total) as ts FROM `orders` WHERE customer_id = $cust_id AND payment_status='paid'");
            $total_spend = (float)($spend_res ? $spend_res->fetch_assoc()['ts'] : 0);
            $new_tier = 'Silver';
            if ($total_spend >= 150000) $new_tier = 'Diamond';
            elseif ($total_spend >= 50000) $new_tier = 'Platinum';
            elseif ($total_spend >= 15000) $new_tier = 'Gold';
            $conn->query("UPDATE `customers` SET `loyalty_tier`='$new_tier' WHERE id=$cust_id");
        $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`) VALUES (1,'admin',1,'loyalty.points.awarded','customers',$cust_id,'{\"points\":$pts}',NOW())");
            $loy_msg = "âœ¦ $pts NovaDrop Points awarded to Customer #$cust_id! Tier auto-upgraded to $new_tier.";
        }
    } elseif ($act === 'deduct_points') {
        $cust_id = (int)$_POST['customer_id'];
        $pts = (int)$_POST['points'];
        $reason = trim($_POST['reason'] ?? 'Admin Point Deduction');
        if ($cust_id > 0 && $pts > 0) {
            $conn->query("UPDATE `customers` SET `loyalty_points` = GREATEST(0, COALESCE(`loyalty_points`,0) - $pts) WHERE id=$cust_id");
            $conn->query("INSERT INTO `loyalty_transactions` (`store_id`,`customer_id`,`points`,`type`,`reason`,`created_at`) VALUES (1,$cust_id,$pts,'debit','" . $conn->real_escape_string($reason) . "',NOW())");
            $loy_msg = "âœ¦ $pts points successfully deducted from Customer #$cust_id.";
        }
    } elseif ($act === 'bulk_award_all') {
        $pts_each = (int)($_POST['bulk_points'] ?? 100);
        $reason = 'Seasonal VIP Bonus â€” NovaDrop Atelier Reward';
        $custs = $conn->query("SELECT id FROM `customers` WHERE is_active=1");
        $cnt = 0;
        if ($custs) {
            while ($c = $custs->fetch_assoc()) {
                $conn->query("UPDATE `customers` SET `loyalty_points`=COALESCE(`loyalty_points`,0)+$pts_each WHERE id={$c['id']}");
                $conn->query("INSERT INTO `loyalty_transactions` (`store_id`,`customer_id`,`points`,`type`,`reason`,`created_at`) VALUES (1,{$c['id']},$pts_each,'credit','" . $conn->real_escape_string($reason) . "',NOW())");
                $cnt++;
            }
        }
        $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`) VALUES (1,'swarm.loyalty_sentinel',1,'loyalty.bulk_award','customers',0,'{\"points_each\":$pts_each,\"customers\":$cnt}',NOW())");
        $loy_msg = "âœ¦ Seasonal Bonus of $pts_each points dispatched to $cnt active VIP members!";
    } elseif ($act === 'update_tier_settings') {
        $tiers = $_POST['tier'] ?? [];
        foreach ($tiers as $code => $t) {
            $mult = (float)($t['multiplier'] ?? 1.0);
            $cash = (float)($t['cashback'] ?? 5.0);
            $min_s = (float)($t['min_spend'] ?? 0);
            $perks = $conn->real_escape_string(trim($t['perks'] ?? ''));
            $conn->query("UPDATE `loyalty_tiers` SET `points_multiplier`=$mult, `cashback_percent`=$cash, `min_spend`=$min_s, `perks`='$perks' WHERE tier_code='" . $conn->real_escape_string($code) . "'");
        }
        $loy_msg = "âœ¦ All VIP Tier configurations updated and synchronized across checkout sessions!";
    }
}

// Fetch data
$tiers_res = $conn->query("SELECT * FROM `loyalty_tiers` ORDER BY min_spend ASC");
$tiers = [];
if ($tiers_res) { while ($t = $tiers_res->fetch_assoc()) $tiers[] = $t; }

$cust_res = $conn->query("SELECT c.*, COALESCE(c.loyalty_points,0) as pts, COALESCE(c.loyalty_tier,'Silver') as tier, (SELECT COUNT(*) FROM `orders` WHERE customer_id=c.id) as order_count, (SELECT COALESCE(SUM(total),0) FROM `orders` WHERE customer_id=c.id AND payment_status='paid') as total_spend FROM `customers` c ORDER BY pts DESC LIMIT 15");
$customers = [];
if ($cust_res) { while ($cr = $cust_res->fetch_assoc()) $customers[] = $cr; }

$txn_res = $conn->query("SELECT lt.*, c.name as cust_name, c.email as cust_email FROM `loyalty_transactions` lt LEFT JOIN `customers` c ON lt.customer_id=c.id ORDER BY lt.id DESC LIMIT 20");
$transactions = [];
if ($txn_res) { while ($tx = $txn_res->fetch_assoc()) $transactions[] = $tx; }

$total_pts_in_circulation = (int)($conn->query("SELECT COALESCE(SUM(loyalty_points),0) FROM `customers`")->fetch_row()[0] ?? 0);
$diamond_cnt = (int)($conn->query("SELECT COUNT(*) FROM `customers` WHERE loyalty_tier='Diamond'")->fetch_row()[0] ?? 0);
$platinum_cnt = (int)($conn->query("SELECT COUNT(*) FROM `customers` WHERE loyalty_tier='Platinum'")->fetch_row()[0] ?? 0);
$gold_cnt = (int)($conn->query("SELECT COUNT(*) FROM `customers` WHERE loyalty_tier='Gold'")->fetch_row()[0] ?? 0);
$total_custs = (int)($conn->query("SELECT COUNT(*) FROM `customers`")->fetch_row()[0] ?? 0);
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge px-3 py-1 font-weight-bold" style="background: linear-gradient(135deg,#f59e0b,#eab308); color:#000; font-size:0.8rem; border-radius:20px;">
                    â˜… VIP LOYALTY ENGINE 3.0
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">4-Tier Automatic Upgrade Â· Point Cashback</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing:-0.5px; font-size:1.5rem;">
                <i class="fas fa-crown text-warning mr-2"></i> VIP Loyalty Points &amp; Tier Rewards Intelligence Studio
            </h3>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Manage Silver â†’ Gold â†’ Platinum â†’ Black Diamond VIP loyalty tiers. Award, deduct, and redeem NovaDrop Points with full transaction ledger.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <button type="button" class="btn btn-warning btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#awardPointsModal" style="border-radius:8px; padding:7px 16px; color:#000;">
                <i class="fas fa-plus-circle mr-1"></i> Award Points
            </button>
            <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#bulkBonusModal" style="border-radius:8px; padding:7px 16px;">
                <i class="fas fa-gift mr-1"></i> Seasonal Bonus Blast
            </button>
            <a href="index.php?q=2" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius:8px;">
                <i class="fas fa-users mr-1"></i> CRM &amp; Customers
            </a>
        </div>
    </div>

    <!-- Alerts -->
    <?php


if ($loy_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($loy_msg) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php


endif; ?>

    <!-- 4 KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Points In Circulation</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($total_pts_in_circulation) ?> <span class="small text-muted" style="font-size:0.75rem;">PTS</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#fffbeb;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#f59e0b;"><i class="fas fa-coins"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #8b5cf6 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Black Diamond VIPs</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= $diamond_cnt ?> <span class="badge badge-dark ml-1" style="font-size:0.7rem;">â‚¹1.5L+ Spenders</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#1e1b4b;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#a5b4fc;"><i class="fas fa-gem"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #3b82f6 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Platinum Members</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= $platinum_cnt ?> <span class="small text-muted" style="font-size:0.75rem;">Gold: <?= $gold_cnt ?></span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#3b82f6;"><i class="fas fa-trophy"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #10b981 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Total Enrolled Members</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($total_custs) ?> Members</h3>
                    </div>
                    <div style="width:48px;height:48px;background:#ecfdf5;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#10b981;"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4-Tier VIP Pyramid Cards -->
    <div class="row mb-4">
        <?php


$tier_styles = [
            'silver'   => ['gradient'=>'linear-gradient(135deg,#64748b,#94a3b8)','icon'=>'fas fa-medal','text'=>'#fff'],
            'gold'     => ['gradient'=>'linear-gradient(135deg,#f59e0b,#eab308)','icon'=>'fas fa-star','text'=>'#000'],
            'platinum' => ['gradient'=>'linear-gradient(135deg,#3b82f6,#6366f1)','icon'=>'fas fa-trophy','text'=>'#fff'],
            'diamond'  => ['gradient'=>'linear-gradient(135deg,#1e1b4b,#312e81)','icon'=>'fas fa-gem','text'=>'#c7d2fe'],
        ];
        foreach ($tiers as $t):
            $ts = $tier_styles[$t['tier_code']] ?? $tier_styles['silver'];
        ?>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius:16px; background:<?= $ts['gradient'] ?>; color:<?= $ts['text'] ?>;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="font-weight-bold mb-0" style="color:<?= $ts['text'] ?>;"><?= htmlspecialchars($t['name']) ?></h5>
                            <div class="small opacity-75">Min Spend: â‚¹<?= number_format((float)$t['min_spend']) ?></div>
                        </div>
                        <i class="<?= $ts['icon'] ?> fa-2x opacity-75"></i>
                    </div>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="font-weight-bold" style="font-size:1.3rem;"><?= number_format((float)$t['points_multiplier'], 1) ?>x</div>
                            <div class="small opacity-75">Points Multiplier</div>
                        </div>
                        <div class="col-6">
                            <div class="font-weight-bold" style="font-size:1.3rem;"><?= number_format((float)$t['cashback_percent'], 1) ?>%</div>
                            <div class="small opacity-75">Point Cashback</div>
                        </div>
                    </div>
                    <hr style="border-color:rgba(255,255,255,0.3); margin:12px 0;">
                    <div class="small opacity-80"><?= htmlspecialchars($t['perks']) ?></div>
                </div>
            </div>
        </div>
        <?php


endforeach; ?>
    </div>

    <!-- Main Content: Customer Leaderboard + Transaction Ledger -->
    <div class="row">
        <!-- Customer VIP Leaderboard -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius:14px; background:var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span class="font-weight-bold" style="font-size:1.05rem;">
                        <i class="fas fa-ranking-star text-warning mr-2"></i> VIP Customer Loyalty Leaderboard
                    </span>
                    <span class="badge badge-warning" style="color:#000;">Top <?= count($customers) ?> Members</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Tier</th>
                                    <th>NovaDrop Points</th>
                                    <th>Total Spend</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


if (!empty($customers)): ?>
                                    <?php


foreach ($customers as $rank => $c):
                                        $tier_lc = strtolower($c['tier'] ?? 'silver');
                                        $tier_clr = ['silver'=>'secondary','gold'=>'warning','platinum'=>'primary','diamond'=>'dark'][$tier_lc] ?? 'secondary';
                                        $pts = (int)$c['pts'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php


if ($rank === 0): ?>
                                                <span style="font-size:1.2rem;">ðŸ¥‡</span>
                                            <?php


elseif ($rank === 1): ?>
                                                <span style="font-size:1.2rem;">ðŸ¥ˆ</span>
                                            <?php


elseif ($rank === 2): ?>
                                                <span style="font-size:1.2rem;">ðŸ¥‰</span>
                                            <?php


else: ?>
                                                <strong class="text-muted">#<?= $rank+1 ?></strong>
                                            <?php


endif; ?>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark"><?= htmlspecialchars($c['name'] ?: 'Guest') ?></div>
                                            <div class="small text-muted"><?= htmlspecialchars($c['email']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $tier_clr ?> px-2 py-1" style="font-size:0.78rem;">
                                                <?= $tier_lc === 'diamond' ? 'â˜… ' : ($tier_lc === 'platinum' ? 'âœ¦ ' : '') ?><?= htmlspecialchars($c['tier']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark"><?= number_format($pts) ?> <span class="text-muted small">pts</span></div>
                                            <div style="height:4px; background:#e5e7eb; border-radius:4px; margin-top:4px; max-width:90px;">
                                                <div style="height:100%; width:<?= min(100, ($pts / max(1, max(array_column($customers, 'pts')))) * 100) ?>%; background:linear-gradient(90deg,#f59e0b,#8b5cf6); border-radius:4px;"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-success">â‚¹<?= number_format((float)$c['total_spend'], 0) ?></strong>
                                            <div class="small text-muted"><?= (int)$c['order_count'] ?> orders</div>
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="btn btn-xs btn-outline-success py-1 px-2"
                                                style="font-size:0.75rem; border-radius:6px;"
                                                onclick="openQuickAward(<?= $c['id'] ?>, '<?= htmlspecialchars(addslashes($c['name'] ?? '')) ?>')">
                                                <i class="fas fa-plus mr-1"></i>Award
                                            </button>
                                        </td>
                                    </tr>
                                    <?php


endforeach; ?>
                                <?php


else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-crown fa-2x mb-2 d-block text-warning"></i>
                                            <strong>No customers enrolled yet.</strong>
                                            <div class="small mt-1">Customers are automatically enrolled when they register on the storefront.</div>
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

        <!-- Right: Tier Config Editor + Recent Transactions -->
        <div class="col-lg-5 mb-4 d-flex flex-column gap-4">

            <!-- Tier Settings Editor -->
            <div class="card shadow-sm border-0" style="border-radius:14px; background:var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold" style="font-size:1rem;"><i class="fas fa-sliders-h text-primary mr-2"></i> Tier Config Editor</span>
                    <button type="submit" form="tierConfigForm" class="btn btn-sm btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Save All
                    </button>
                </div>
                <div class="card-body p-3">
                    <form method="POST" id="tierConfigForm">
                        <input type="hidden" name="loyalty_action" value="update_tier_settings">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0" style="font-size:0.82rem;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Tier</th>
                                        <th>Min â‚¹</th>
                                        <th>Mult.</th>
                                        <th>Cash%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


foreach ($tiers as $t): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($t['name']) ?></strong></td>
                                        <td><input type="number" name="tier[<?= $t['tier_code'] ?>][min_spend]" class="form-control form-control-sm" value="<?= (int)$t['min_spend'] ?>" style="width:70px;"></td>
                                        <td><input type="number" step="0.1" name="tier[<?= $t['tier_code'] ?>][multiplier]" class="form-control form-control-sm" value="<?= number_format((float)$t['points_multiplier'],1) ?>" style="width:55px;"></td>
                                        <td><input type="number" step="0.5" name="tier[<?= $t['tier_code'] ?>][cashback]" class="form-control form-control-sm" value="<?= number_format((float)$t['cashback_percent'],1) ?>" style="width:55px;"></td>
                                        <input type="hidden" name="tier[<?= $t['tier_code'] ?>][perks]" value="<?= htmlspecialchars($t['perks']) ?>">
                                    </tr>
                                    <?php


endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Point Transactions Ledger -->
            <div class="card shadow-sm border-0 flex-grow-1" style="border-radius:14px; background:var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold" style="font-size:1rem;"><i class="fas fa-history text-info mr-2"></i> Recent Point Transactions</span>
                    <span class="badge badge-info"><?= count($transactions) ?> Latest</span>
                </div>
                <div class="card-body p-0" style="max-height:320px; overflow-y:auto;">
                    <?php


if (!empty($transactions)): ?>
                        <?php


foreach ($transactions as $tx): ?>
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom" style="font-size:0.83rem;">
                            <div>
                                <div class="font-weight-bold text-dark"><?= htmlspecialchars(trim($tx['cust_name']) ?: ('Customer #'.$tx['customer_id'])) ?></div>
                                <div class="text-muted" style="font-size:0.75rem;"><?= htmlspecialchars($tx['reason']) ?></div>
                                <div class="text-muted" style="font-size:0.72rem;"><?= date('d M Y, h:i A', strtotime($tx['created_at'])) ?></div>
                            </div>
                            <span class="font-weight-bold <?= $tx['type']==='credit' ? 'text-success' : 'text-danger' ?>" style="font-size:0.95rem; white-space:nowrap;">
                                <?= $tx['type']==='credit' ? '+' : '-' ?><?= number_format($tx['points']) ?> pts
                            </span>
                        </div>
                        <?php


endforeach; ?>
                    <?php


else: ?>
                        <div class="text-center py-4 text-muted small">No transactions yet. Award points above to start.</div>
                    <?php


endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Award Points to Customer -->
<div class="modal fade" id="awardPointsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#f59e0b,#eab308); border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold" style="color:#000;"><i class="fas fa-coins mr-2"></i> Award NovaDrop Points</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#000;">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="loyalty_action" value="award_points">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Select Customer</label>
                        <select name="customer_id" id="awardCustSelect" class="form-control font-weight-bold">
                            <?php


foreach ($customers as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name'] ?: 'Guest') ?> â€” <?= htmlspecialchars($c['email']) ?> (<?= number_format($c['pts']) ?> pts)</option>
                            <?php


endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 form-group mb-3">
                            <label class="font-weight-bold">Points to Award</label>
                            <input type="number" name="points" class="form-control font-weight-bold" value="100" min="1" required>
                        </div>
                        <div class="col-6 form-group mb-3">
                            <label class="font-weight-bold">Quick Presets</label>
                            <div class="d-flex gap-2 flex-wrap mt-1">
                                <button type="button" class="btn btn-xs btn-outline-warning py-1 px-2" style="font-size:0.75rem;" onclick="document.querySelector('[name=points]').value=100">100</button>
                                <button type="button" class="btn btn-xs btn-outline-warning py-1 px-2" style="font-size:0.75rem;" onclick="document.querySelector('[name=points]').value=500">500</button>
                                <button type="button" class="btn btn-xs btn-outline-warning py-1 px-2" style="font-size:0.75rem;" onclick="document.querySelector('[name=points]').value=1000">1000</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Reason / Note</label>
                        <select name="reason" class="form-control">
                            <option value="Birthday VIP Bonus â€” NovaDrop Atelier">ðŸŽ‚ Birthday VIP Bonus</option>
                            <option value="Purchase Reward â€” Order Cashback Credit">ðŸ›’ Purchase Reward</option>
                            <option value="Referral Commission â€” Friend Referral Bonus">ðŸ‘¥ Referral Commission</option>
                            <option value="Loyalty Anniversary Milestone Reward">ðŸ… Anniversary Milestone</option>
                            <option value="Exclusive VIP Drop Early-Access Bonus">ðŸŽ Early Access Bonus</option>
                            <option value="Admin Manual Award">âš™ï¸ Admin Manual Award</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm font-weight-bold px-4" style="color:#000;">
                        <i class="fas fa-coins mr-1"></i> Award Points
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Seasonal Bulk Bonus -->
<div class="modal fade" id="bulkBonusModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#4361ee,#7209b7); border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-gift mr-2"></i> Seasonal VIP Bonus Blast</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="loyalty_action" value="bulk_award_all">
                <div class="modal-body p-4">
                    <div class="alert alert-info py-2 mb-3" style="font-size:0.85rem; border-radius:8px;">
                        <i class="fas fa-info-circle mr-1"></i> This will award bonus points to <strong>ALL <?= $total_custs ?> active members</strong> simultaneously.
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Points Per Member</label>
                        <input type="number" name="bulk_points" class="form-control font-weight-bold" value="200" min="1" required>
                        <small class="text-muted">Each active customer will receive this many bonus points added to their balance.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-4">
                        <i class="fas fa-paper-plane mr-1"></i> Launch Bonus Blast
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openQuickAward(id, name) {
    document.getElementById('awardCustSelect').value = id;
    var modal = new bootstrap.Modal(document.getElementById('awardPointsModal'));
    // Bootstrap 4 compat
    $('#awardPointsModal').modal('show');
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
