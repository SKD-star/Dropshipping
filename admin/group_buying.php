<?php
require_once __DIR__ . '/layout_header.php';

// Ensure group buying tables
$conn->query("CREATE TABLE IF NOT EXISTS `group_buy_campaigns` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `title` VARCHAR(255) NOT NULL,
  `product_id` INT NOT NULL,
  `team_size_required` INT NOT NULL DEFAULT 3 COMMENT 'Number of friends required to unlock price',
  `discount_percent` DECIMAL(5,2) NOT NULL DEFAULT 40.00,
  `group_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `single_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `time_limit_hours` INT NOT NULL DEFAULT 24,
  `total_teams_created` INT DEFAULT 0,
  `total_teams_completed` INT DEFAULT 0,
  `total_viral_shoppers` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE IF NOT EXISTS `group_buy_teams` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `campaign_id` INT NOT NULL,
  `team_code` VARCHAR(32) NOT NULL UNIQUE,
  `leader_customer_id` INT NOT NULL,
  `members_joined` INT DEFAULT 1,
  `status` ENUM('forming','completed','expired') DEFAULT 'forming',
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$msg = null;
$err = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $act = $_POST['group_action'] ?? '';

    if ($act === 'create_campaign') {
        $title = $conn->real_escape_string(trim($_POST['title'] ?? ''));
        $pid = (int)$_POST['product_id'];
        $team_size = max(2, (int)($_POST['team_size_required'] ?? 3));
        $disc = (float)($_POST['discount_percent'] ?? 40);
        $hours = max(1, (int)($_POST['time_limit_hours'] ?? 24));

        // Fetch product price
        $pres = $conn->query("SELECT base_price FROM `products` WHERE id=$pid");
        $single_price = (float)($pres ? $pres->fetch_assoc()['base_price'] : 1000);
        $group_price = $single_price * (1 - ($disc / 100));

        if ($title && $pid > 0) {
            $conn->query("INSERT INTO `group_buy_campaigns` (`store_id`,`title`,`product_id`,`team_size_required`,`discount_percent`,`group_price`,`single_price`,`time_limit_hours`,`is_active`)
                VALUES (1,'$title',$pid,$team_size,$disc,$group_price,$single_price,$hours,1)");
            $conn->query("INSERT INTO `audit_log` (`store_id`,`actor_type`,`actor_id`,`action`,`entity_type`,`entity_id`,`meta_json`,`created_at`)
                VALUES (1,'admin',1,'group_buy.created','group_buy_campaigns',LAST_INSERT_ID(),'{\"title\":\"$title\"}',NOW())");
            $msg = "✦ Social Group Buy Campaign '<strong>$title</strong>' successfully launched!";
        } else {
            $err = "Campaign title and product selection are required.";
        }
    } elseif ($act === 'toggle_campaign') {
        $cid = (int)$_POST['campaign_id'];
        $conn->query("UPDATE `group_buy_campaigns` SET is_active = 1 - is_active WHERE id=$cid");
        $msg = "✦ Campaign status updated.";
    } elseif ($act === 'delete_campaign') {
        $cid = (int)$_POST['campaign_id'];
        $conn->query("DELETE FROM `group_buy_campaigns` WHERE id=$cid");
        $msg = "✦ Campaign deleted.";
    }
}

// Fetch products
$prods = [];
$pr = $conn->query("SELECT id, title, base_price FROM `products` WHERE status='active' ORDER BY id DESC LIMIT 40");
if ($pr) { while ($p = $pr->fetch_assoc()) $prods[] = $p; }

// Fetch campaigns
$campaigns = [];
$cpr = $conn->query("SELECT gbc.*, p.title as prod_name, p.og_image_url FROM `group_buy_campaigns` gbc LEFT JOIN `products` p ON gbc.product_id=p.id ORDER BY gbc.id DESC");
if ($cpr) { while ($c = $cpr->fetch_assoc()) $campaigns[] = $c; }

// Active live teams
$teams = [];
$tr = $conn->query("SELECT t.*, c.name as leader_name, gbc.title as campaign_title, gbc.team_size_required 
    FROM `group_buy_teams` t 
    LEFT JOIN `group_buy_campaigns` gbc ON t.campaign_id=gbc.id 
    LEFT JOIN `customers` c ON t.leader_customer_id=c.id 
    ORDER BY t.id DESC LIMIT 15");
if ($tr) { while ($t = $tr->fetch_assoc()) $teams[] = $t; }

// KPIs
$total_camps = count($campaigns);
$active_camps = count(array_filter($campaigns, fn($c) => $c['is_active'] == 1));
$total_teams_completed = (int)($conn->query("SELECT COUNT(*) FROM `group_buy_teams` WHERE status='completed'")->fetch_row()[0] ?? 0);
$total_viral_customers = (int)($conn->query("SELECT COALESCE(SUM(members_joined),0) FROM `group_buy_teams`")->fetch_row()[0] ?? 0);
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge px-3 py-1 font-weight-bold" style="background: linear-gradient(135deg,#ec4899,#be185d); color:#fff; font-size:0.8rem; border-radius:20px;">
                    👥 VIRAL SOCIAL COMMERCE
                </span>
                <span class="badge badge-danger px-2 py-1" style="font-size:0.75rem;">Group Buying · Team Share Deals · Organic Growth Loop</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing:-0.5px; font-size:1.5rem;">
                <i class="fas fa-people-group text-pink mr-2" style="color:#ec4899;"></i> Social Group Buying &amp; Team Purchase Engine
            </h3>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Customers invite 2+ friends on WhatsApp to unlock massive 40% discounts. Exponential zero-ad-cost viral customer acquisition.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <button type="button" class="btn btn-danger btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#createCampaignModal" style="border-radius:8px; padding:7px 16px; background:linear-gradient(135deg,#ec4899,#be185d); border:none;">
                <i class="fas fa-plus-circle mr-1"></i> Launch Group Deal
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
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #ec4899 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Active Group Deals</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= $active_camps ?> <span class="small text-muted" style="font-size:0.75rem;">/ <?= $total_camps ?> Total</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#fdf2f8;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#ec4899;"><i class="fas fa-bullseye"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #10b981 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Completed Teams</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($total_teams_completed) ?> <span class="badge badge-success ml-1">Unlocked</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#ecfdf5;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#10b981;"><i class="fas fa-handshake-angle"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #3b82f6 !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Viral Shoppers Brought</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($total_viral_customers) ?> <span class="small text-muted" style="font-size:0.75rem;">Friends</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#3b82f6;"><i class="fas fa-share-nodes"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:var(--bg-surface); border-left:4px solid #f59e0b !important;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Viral K-Factor</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">2.4x <span class="badge badge-warning text-dark ml-1">Exponential</span></h3>
                    </div>
                    <div style="width:48px;height:48px;background:#fffbeb;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#f59e0b;"><i class="fas fa-bolt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaigns Grid -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; background:var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <span class="font-weight-bold" style="font-size:1.05rem;"><i class="fas fa-fire text-danger mr-2"></i> Live Social Group Buy Campaigns</span>
            <span class="badge badge-danger"><?= count($campaigns) ?> Campaigns</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.85rem;">
                    <thead class="thead-light">
                        <tr>
                            <th>Campaign Title</th>
                            <th>Product</th>
                            <th>Team Requirement</th>
                            <th>Single Price</th>
                            <th>Group Price</th>
                            <th>Time Window</th>
                            <th>Status</th>
                            <th style="text-align:right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($campaigns)): ?>
                            <?php foreach ($campaigns as $c): ?>
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark"><?= htmlspecialchars($c['title']) ?></div>
                                    <div class="text-muted small">Save <?= (float)$c['discount_percent'] ?>% with friends</div>
                                </td>
                                <td><strong><?= htmlspecialchars($c['prod_name'] ?: ('Product #'.$c['product_id'])) ?></strong></td>
                                <td><span class="badge badge-info px-2 py-1"><?= (int)$c['team_size_required'] ?> People Team</span></td>
                                <td class="text-muted text-decoration-line-through">₹<?= number_format((float)$c['single_price']) ?></td>
                                <td><strong class="text-success" style="font-size:1rem;">₹<?= number_format((float)$c['group_price']) ?></strong></td>
                                <td><span class="badge badge-light border"><?= (int)$c['time_limit_hours'] ?> Hours</span></td>
                                <td>
                                    <?= $c['is_active'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Paused</span>' ?>
                                </td>
                                <td style="text-align:right;">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="group_action" value="toggle_campaign">
                                        <input type="hidden" name="campaign_id" value="<?= $c['id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-outline-<?= $c['is_active'] ? 'warning' : 'success' ?> py-1 px-2 mr-1">
                                            <?= $c['is_active'] ? 'Pause' : 'Activate' ?>
                                        </button>
                                    </form>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete campaign?')">
                                        <input type="hidden" name="group_action" value="delete_campaign">
                                        <input type="hidden" name="campaign_id" value="<?= $c['id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-1 px-2"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-people-group fa-2x mb-2 d-block text-pink" style="color:#ec4899;"></i>
                                    <strong>No group buying campaigns running.</strong>
                                    <div class="small mt-1">Launch your first social team buy deal to turn shoppers into your brand advocates!</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Campaign -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#ec4899,#be185d); border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-people-group mr-2"></i> Launch Social Group Buying Deal</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="group_action" value="create_campaign">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-8 form-group mb-3">
                            <label class="font-weight-bold">Deal Headline <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control font-weight-bold" placeholder="e.g. Buy with 2 Friends & Get 40% Off Luxe Silk Shirt" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Select Product <span class="text-danger">*</span></label>
                            <select name="product_id" class="form-control font-weight-bold" required>
                                <?php foreach ($prods as $p): ?>
                                    <option value="<?= $p['id'] ?>">#<?= $p['id'] ?> — <?= htmlspecialchars($p['title']) ?> (₹<?= number_format((float)$p['base_price']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Required Team Size</label>
                            <select name="team_size_required" class="form-control font-weight-bold">
                                <option value="2">2 People (Leader + 1 Friend)</option>
                                <option value="3" selected>3 People (Leader + 2 Friends)</option>
                                <option value="4">4 People (Squad Deal)</option>
                                <option value="5">5 People (Mega Group Buy)</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Group Discount (%)</label>
                            <input type="number" step="1" name="discount_percent" class="form-control font-weight-bold" value="40" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Team Time Limit (Hours)</label>
                            <input type="number" step="1" name="time_limit_hours" class="form-control font-weight-bold" value="24" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm font-weight-bold px-4" style="background:linear-gradient(135deg,#ec4899,#be185d); border:none;">
                        <i class="fas fa-rocket mr-1"></i> Publish Group Deal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>

