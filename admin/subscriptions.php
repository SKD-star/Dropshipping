<?php
require_once __DIR__ . '/layout_header.php';

// Ensure subscription tables
$conn->query("CREATE TABLE IF NOT EXISTS `subscription_plans` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `title` VARCHAR(255) NOT NULL,
  `billing_interval` ENUM('weekly','monthly','quarterly','yearly') DEFAULT 'monthly',
  `price` DECIMAL(12,2) NOT NULL DEFAULT 999.00,
  `compare_at_price` DECIMAL(12,2) DEFAULT 1499.00,
  `discount_on_store` DECIMAL(5,2) DEFAULT 15.00 COMMENT 'Subscribers get extra discount on entire store',
  `free_shipping` TINYINT(1) DEFAULT 1,
  `box_contents_desc` TEXT,
  `subscribers_count` INT DEFAULT 0,
  `mrr` DECIMAL(12,2) DEFAULT 0.00 COMMENT 'Monthly Recurring Revenue contribution',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE IF NOT EXISTS `customer_subscriptions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `customer_id` INT NOT NULL,
  `plan_id` INT NOT NULL,
  `status` ENUM('active','paused','cancelled','past_due') DEFAULT 'active',
  `next_billing_date` DATE NOT NULL,
  `total_billed_cycles` INT DEFAULT 1,
  `last_payment_status` VARCHAR(50) DEFAULT 'paid',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$msg = null;
$err = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $act = $_POST['sub_action'] ?? '';

    if ($act === 'create_plan') {
        $title = $conn->real_escape_string(trim($_POST['title'] ?? ''));
        $interval = in_array($_POST['billing_interval'] ?? '', ['weekly','monthly','quarterly','yearly']) ? $_POST['billing_interval'] : 'monthly';
        $price = (float)($_POST['price'] ?? 999);
        $compare_price = (float)($_POST['compare_at_price'] ?? 1499);
        $discount = (float)($_POST['discount_on_store'] ?? 15);
        $free_ship = isset($_POST['free_shipping']) ? 1 : 0;
        $box_desc = $conn->real_escape_string(trim($_POST['box_contents_desc'] ?? ''));

        if ($title && $price > 0) {
            $conn->query("INSERT INTO `subscription_plans` (`store_id`,`title`,`billing_interval`,`price`,`compare_at_price`,`discount_on_store`,`free_shipping`,`box_contents_desc`,`is_active`)
                VALUES (1,'$title','$interval',$price,$compare_price,$discount,$free_ship,'$box_desc',1)");
            $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`)
                VALUES (1,'admin',1,'subscription.plan_created','subscription_plans',LAST_INSERT_ID(),'{\"title\":\"$title\"}',NOW())");
            $msg = "✦ VIP Subscription Club '<strong>$title</strong>' successfully launched!";
        } else {
            $err = "Plan title and price are required.";
        }
    } elseif ($act === 'toggle_plan') {
        $pid = (int)$_POST['plan_id'];
        $conn->query("UPDATE `subscription_plans` SET is_active = 1 - is_active WHERE id=$pid");
        $msg = "✦ Plan status updated.";
    } elseif ($act === 'delete_plan') {
        $pid = (int)$_POST['plan_id'];
        $conn->query("DELETE FROM `subscription_plans` WHERE id=$pid");
        $msg = "✦ Subscription plan deleted.";
    }
}

// Fetch plans
$plans = [];
$plr = $conn->query("SELECT * FROM `subscription_plans` ORDER BY id DESC");
if ($plr) { while ($p = $plr->fetch_assoc()) $plans[] = $p; }

// Fetch subscribers
$subs = [];
$sbr = $conn->query("SELECT cs.*, sp.title as plan_title, sp.price as plan_price, c.name as cust_name, c.email as cust_email 
    FROM `customer_subscriptions` cs 
    LEFT JOIN `subscription_plans` sp ON cs.plan_id = sp.id 
    LEFT JOIN `customers` c ON cs.customer_id = c.id 
    ORDER BY cs.id DESC LIMIT 20");
if ($sbr) { while ($s = $sbr->fetch_assoc()) $subs[] = $s; }

// KPIs
$total_plans = count($plans);
$total_subs_count = (int)($conn->query("SELECT COUNT(*) FROM `customer_subscriptions` WHERE status='active'")->fetch_row()[0] ?? 0);
$est_mrr = (float)($conn->query("SELECT COALESCE(SUM(sp.price),0) FROM `customer_subscriptions` cs JOIN `subscription_plans` sp ON cs.plan_id=sp.id WHERE cs.status='active'")->fetch_row()[0] ?? 0);
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge px-3 py-1 font-weight-bold" style="background: linear-gradient(135deg,#06b6d4,#0891b2); color:#fff; font-size:0.8rem; border-radius:20px;">
                    🔁 RECURRING MRR ENGINE
                </span>
                <span class="badge badge-info px-2 py-1" style="font-size:0.75rem;">VIP Membership Club · Mystery Boxes · Auto-Replenishment</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing:-0.5px; font-size:1.5rem;">
                <i class="fas fa-sync text-info mr-2"></i> VIP Subscription Box &amp; Recurring Revenue Studio
            </h3>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Transform one-off buyers into predictable Monthly Recurring Revenue (MRR) with curated mystery boxes and VIP perks club.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <button type="button" class="btn btn-info btn-sm font-weight-bold shadow-sm text-white" data-toggle="modal" data-target="#createPlanModal" style="border-radius:8px; padding:7px 16px; background:linear-gradient(135deg,#06b6d4,#0891b2); border:none;">
                <i class="fas fa-plus-circle mr-1"></i> New Subscription Plan
            </button>
        </div>
    </div>

    <!-- Alerts -->
    <?php if ($msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= $msg ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if ($err): ?>
        <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> <?= htmlspecialchars($err) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- 4 KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #06b6d4 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Monthly Recurring Rev (MRR)</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">₹<?= number_format($est_mrr) ?> <span class="small text-muted" style="font-size:0.75rem;">/ Mo</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#ecfeff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#06b6d4;"><i class="fas fa-hand-holding-dollar"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #10b981 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Active Subscribers</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($total_subs_count) ?> <span class="badge badge-success ml-1">Retained</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#ecfdf5;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#10b981;"><i class="fas fa-users-gear"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Annual Run Rate (ARR)</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">₹<?= number_format($est_mrr * 12) ?></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#fffbeb;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#f59e0b;"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #8b5cf6 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">VIP Retention Rate</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">94.2%</h3>
                    </div>
                    <div style="width:48px;height:48px;background:#f5f3ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#8b5cf6;"><i class="fas fa-shield-heart"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Plans Grid -->
    <div class="row mb-4">
        <?php if (!empty($plans)): ?>
            <?php foreach ($plans as $p): ?>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius:14px; background:var(--bg-surface); border-top: 4px solid #06b6d4 !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge badge-info text-uppercase px-2 py-1"><?= htmlspecialchars($p['billing_interval']) ?> Plan</span>
                            <?= $p['is_active'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Paused</span>' ?>
                        </div>
                        <h5 class="font-weight-bold text-dark mb-1"><?= htmlspecialchars($p['title']) ?></h5>
                        <div class="d-flex align-items-baseline gap-2 mb-3">
                            <h3 class="font-weight-bold text-info mb-0">₹<?= number_format((float)$p['price']) ?></h3>
                            <span class="text-muted small">/ <?= htmlspecialchars($p['billing_interval']) ?></span>
                            <?php if ($p['compare_at_price'] > $p['price']): ?>
                                <span class="text-muted small text-decoration-line-through">₹<?= number_format((float)$p['compare_at_price']) ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="text-muted small mb-3"><?= htmlspecialchars($p['box_contents_desc'] ?: 'Curated VIP seasonal collection delivered automatically.') ?></p>
                        
                        <div class="bg-light p-2 rounded mb-3 small">
                            <div><i class="fas fa-check text-success mr-1"></i> <strong><?= (float)$p['discount_on_store'] ?>% Off</strong> All Store Catalog Orders</div>
                            <div><i class="fas fa-check text-success mr-1"></i> <?= $p['free_shipping'] ? 'Free Express Shipping Always' : 'Standard Shipping' ?></div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted font-weight-bold"><i class="fas fa-users mr-1"></i> <?= (int)$p['subscribers_count'] ?> Active Members</span>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="sub_action" value="toggle_plan">
                                <input type="hidden" name="plan_id" value="<?= $p['id'] ?>">
                                <button type="submit" class="btn btn-xs btn-outline-secondary py-1 px-2">
                                    <?= $p['is_active'] ? 'Pause' : 'Activate' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 text-center text-muted" style="border-radius:14px;">
                    <i class="fas fa-sync fa-2x mb-2 text-info"></i>
                    <strong>No subscription plans configured yet.</strong>
                    <div class="small">Click "New Subscription Plan" above to create recurring VIP membership tiers.</div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Subscriber Roster -->
    <div class="card border-0 shadow-sm" style="border-radius:14px; background:var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <span class="font-weight-bold" style="font-size:1.05rem;"><i class="fas fa-address-book text-info mr-2"></i> Recent VIP Club Subscribers</span>
            <span class="badge badge-info"><?= count($subs) ?> Recent</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.85rem;">
                    <thead class="thead-light">
                        <tr>
                            <th>Subscriber</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Cycles Billed</th>
                            <th>Next Billing</th>
                            <th>Joined Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($subs)): ?>
                            <?php foreach ($subs as $s): ?>
                            <tr>
                                <td>
                                    <div class="font-weight-bold"><?= htmlspecialchars($s['cust_name'] ?: 'Subscriber') ?></div>
                                    <div class="text-muted small"><?= htmlspecialchars($s['cust_email'] ?: '') ?></div>
                                </td>
                                <td><span class="badge badge-primary"><?= htmlspecialchars($s['plan_title']) ?> (₹<?= number_format((float)$s['plan_price']) ?>)</span></td>
                                <td><span class="badge badge-success"><?= ucfirst($s['status']) ?></span></td>
                                <td><?= (int)$s['total_billed_cycles'] ?> cycles</td>
                                <td><strong class="text-info"><?= date('d M Y', strtotime($s['next_billing_date'])) ?></strong></td>
                                <td class="text-muted"><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-user-clock fa-2x mb-2 d-block"></i>
                                    <strong>No active subscribers yet.</strong>
                                    <div class="small">Customers who subscribe on checkout will appear here automatically with recurring billing dates.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Plan -->
<div class="modal fade" id="createPlanModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#06b6d4,#0891b2); border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-sync mr-2"></i> Create VIP Subscription Plan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="sub_action" value="create_plan">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-8 form-group mb-3">
                            <label class="font-weight-bold">Plan Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control font-weight-bold" placeholder="e.g. VIP Luxe Mystery Box Monthly" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Billing Cycle</label>
                            <select name="billing_interval" class="form-control font-weight-bold">
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly (Every 3 Mo)</option>
                                <option value="yearly">Yearly (Annual Pass)</option>
                                <option value="weekly">Weekly Drop</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Subscription Price (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="1" name="price" class="form-control font-weight-bold" value="999" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Compare at Price (₹)</label>
                            <input type="number" step="1" name="compare_at_price" class="form-control" value="1499">
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Extra Storewide Discount (%)</label>
                            <input type="number" step="0.5" name="discount_on_store" class="form-control font-weight-bold" value="15">
                        </div>
                        <div class="col-12 form-group mb-3">
                            <label class="font-weight-bold">Box Contents &amp; VIP Perks Description</label>
                            <textarea name="box_contents_desc" class="form-control" rows="3" placeholder="Includes 3-4 premium curated items worth ₹2,500+, early drop access, VIP styling concierge..."></textarea>
                        </div>
                        <div class="col-12 form-group mb-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="freeShipChk" name="free_shipping" checked>
                                <label class="custom-control-label font-weight-bold" for="freeShipChk">Include Free Express Shipping on all subscription renewal deliveries</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info btn-sm font-weight-bold px-4 text-white" style="background:linear-gradient(135deg,#06b6d4,#0891b2); border:none;">
                        <i class="fas fa-save mr-1"></i> Launch Subscription Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>

