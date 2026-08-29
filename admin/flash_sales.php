<?php
require_once __DIR__ . '/layout_header.php';


// Ensure flash_sales table
$conn->query("CREATE TABLE IF NOT EXISTS `flash_sales` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `discount_type` ENUM('percent','fixed') DEFAULT 'percent',
  `discount_value` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `min_purchase` DECIMAL(10,2) DEFAULT 0,
  `max_uses` INT DEFAULT NULL,
  `uses_count` INT DEFAULT 0,
  `product_ids` TEXT COMMENT 'comma-separated product IDs, empty=all',
  `category_ids` TEXT,
  `starts_at` DATETIME NOT NULL,
  `ends_at` DATETIME NOT NULL,
  `is_active` TINYINT DEFAULT 1,
  `show_timer` TINYINT DEFAULT 1,
  `show_stock_bar` TINYINT DEFAULT 1,
  `badge_text` VARCHAR(50) DEFAULT 'FLASH DEAL',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$msg = null; $err = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $act = $_POST['flash_action'] ?? '';

    if ($act === 'create_flash') {
        $title = $conn->real_escape_string(trim($_POST['title'] ?? ''));
        $desc = $conn->real_escape_string(trim($_POST['description'] ?? ''));
        $dtype = in_array($_POST['discount_type'] ?? '', ['percent','fixed']) ? $_POST['discount_type'] : 'percent';
        $dval = (float)($_POST['discount_value'] ?? 0);
        $min_p = (float)($_POST['min_purchase'] ?? 0);
        $max_u = !empty($_POST['max_uses']) ? (int)$_POST['max_uses'] : 'NULL';
        $starts = $conn->real_escape_string($_POST['starts_at'] ?? date('Y-m-d H:i:s'));
        $ends = $conn->real_escape_string($_POST['ends_at'] ?? date('Y-m-d H:i:s', strtotime('+24 hours')));
        $badge = $conn->real_escape_string(trim($_POST['badge_text'] ?? 'FLASH DEAL'));
        $show_t = isset($_POST['show_timer']) ? 1 : 0;
        $show_s = isset($_POST['show_stock_bar']) ? 1 : 0;
        if ($title && $dval > 0) {
            $conn->query("INSERT INTO `flash_sales` (store_id,title,description,discount_type,discount_value,min_purchase,max_uses,starts_at,ends_at,badge_text,show_timer,show_stock_bar)
                VALUES (1,'$title','$desc','$dtype',$dval,$min_p," . ($max_u === 'NULL' ? 'NULL' : $max_u) . ",'$starts','$ends','$badge',$show_t,$show_s)");
            $msg = "âœ¦ Flash Sale '<strong>$title</strong>' launched successfully!";
        } else {
            $err = "Title and discount value are required.";
        }
    } elseif ($act === 'toggle_flash') {
        $fid = (int)$_POST['flash_id'];
        $conn->query("UPDATE `flash_sales` SET is_active = 1 - is_active WHERE id=$fid");
        $msg = "âœ¦ Flash sale status toggled.";
    } elseif ($act === 'delete_flash') {
        $fid = (int)$_POST['flash_id'];
        $conn->query("DELETE FROM `flash_sales` WHERE id=$fid");
        $msg = "âœ¦ Flash sale deleted.";
    }
}

// Fetch active & scheduled sales
$active_sales = [];
$ar = $conn->query("SELECT * FROM `flash_sales` WHERE is_active=1 AND ends_at > NOW() ORDER BY ends_at ASC");
if ($ar) { while ($r = $ar->fetch_assoc()) $active_sales[] = $r; }

$all_sales = [];
$asr = $conn->query("SELECT * FROM `flash_sales` ORDER BY id DESC LIMIT 30");
if ($asr) { while ($r = $asr->fetch_assoc()) $all_sales[] = $r; }

// KPIs
$total_sales = (int)($conn->query("SELECT COUNT(*) FROM `flash_sales`")->fetch_row()[0] ?? 0);
$active_cnt = (int)($conn->query("SELECT COUNT(*) FROM `flash_sales` WHERE is_active=1 AND ends_at > NOW()")->fetch_row()[0] ?? 0);
$total_uses = (int)($conn->query("SELECT COALESCE(SUM(uses_count),0) FROM `flash_sales`")->fetch_row()[0] ?? 0);
?>

<div class="container-fluid py-4 cont">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge px-3 py-1 font-weight-bold" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:0.8rem;border-radius:20px;">
                    âš¡ FLASH SALE ENGINE
                </span>
                <span class="badge badge-danger px-2 py-1" style="font-size:0.75rem;"><?= $active_cnt ?> Live Now Â· Scarcity Timers Â· FOMO Engine</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing:-0.5px;font-size:1.5rem;">
                <i class="fas fa-bolt text-danger mr-2"></i> Flash Sales &amp; Scarcity Engine
            </h3>
            <p class="text-muted mb-0" style="font-size:0.9rem;">Launch time-limited deals with countdown timers, stock bars, and FOMO mechanics. Drive urgency, spike conversions.</p>
        </div>
        <button class="btn btn-danger btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#createFlashModal" style="border-radius:8px;padding:7px 18px;">
            <i class="fas fa-plus mr-1"></i> Launch Flash Sale
        </button>
    </div>

    <?php


if ($msg): ?><div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert"><i class="fas fa-check-circle mr-2"></i> <?= $msg ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php


endif; ?>
    <?php


if ($err): ?><div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert"><i class="fas fa-exclamation-triangle mr-2"></i> <?= htmlspecialchars($err) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php


endif; ?>

    <!-- KPIs -->
    <div class="row mb-4">
        <?php


$kpis = [
            ['Total Flash Sales','fas fa-bolt','#ef4444','#fef2f2', $total_sales,'Created All-Time'],
            ['Live Now','fas fa-fire','#f59e0b','#fffbeb', $active_cnt,'Active Sales'],
            ['Total Redemptions','fas fa-ticket-alt','#10b981','#ecfdf5', number_format($total_uses),'Deals Grabbed'],
            ['FOMO Score','fas fa-brain','#8b5cf6','#f5f3ff', $active_cnt > 0 ? 'ðŸ”¥ HOT' : 'Calm','Urgency Level'],
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
        <?php


endforeach; ?>
    </div>

    <!-- Live Countdown Cards -->
    <?php


if (!empty($active_sales)): ?>
    <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;background:var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
            <i class="fas fa-fire text-danger mr-2"></i>
            <span class="font-weight-bold">âš¡ Live Flash Deals â€” Countdown Timers</span>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <?php


foreach ($active_sales as $s):
                    $ends_ts = strtotime($s['ends_at']);
                    $pct_used = $s['max_uses'] > 0 ? min(100, ($s['uses_count'] / $s['max_uses']) * 100) : rand(30,80);
                    $disc_label = $s['discount_type']==='percent' ? $s['discount_value'].'% OFF' : 'â‚¹'.number_format((float)$s['discount_value']).' OFF';
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px;background:linear-gradient(135deg,#fff5f5,#fff);">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge badge-danger px-2" style="font-size:0.75rem;border-radius:6px;"><?= htmlspecialchars($s['badge_text']) ?></span>
                                <span class="badge badge-success font-weight-bold px-2"><?= $disc_label ?></span>
                            </div>
                            <h6 class="font-weight-bold text-dark"><?= htmlspecialchars($s['title']) ?></h6>
                            <p class="text-muted small mb-2"><?= htmlspecialchars(substr($s['description'], 0, 80)) ?>...</p>
                            <?php


if ($s['show_timer']): ?>
                            <div class="d-flex gap-2 mb-2 text-center countdown-wrap" data-ends="<?= $ends_ts ?>">
                                <?php


foreach (['HH'=>'Hrs','MM'=>'Min','SS'=>'Sec'] as $cls=>$lbl): ?>
                                <div class="flex-fill p-1 rounded text-white <?= $cls ?>" style="background:#dc2626;font-weight:900;font-size:1.1rem;min-width:38px;">
                                    <div>00</div><div style="font-size:0.55rem;font-weight:normal;"><?= $lbl ?></div>
                                </div>
                                <?php


endforeach; ?>
                            </div>
                            <?php


endif; ?>
                            <?php


if ($s['show_stock_bar']): ?>
                            <div class="mt-1">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Claimed</span><span><?= round($pct_used) ?>%</span>
                                </div>
                                <div style="height:6px;background:#fecaca;border-radius:4px;">
                                    <div style="width:<?= $pct_used ?>%;height:100%;background:linear-gradient(90deg,#ef4444,#dc2626);border-radius:4px;transition:width 0.5s;"></div>
                                </div>
                                <div class="small text-danger font-weight-bold mt-1">ðŸ”¥ Only <?= max(0, ($s['max_uses'] ?: 100) - $s['uses_count']) ?> slots left!</div>
                            </div>
                            <?php


endif; ?>
                        </div>
                    </div>
                </div>
                <?php


endforeach; ?>
            </div>
        </div>
    </div>
    <?php


endif; ?>

    <!-- All Sales Table -->
    <div class="card border-0 shadow-sm" style="border-radius:14px;background:var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom">
            <span class="font-weight-bold"><i class="fas fa-list text-primary mr-2"></i> All Flash Sales History</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.85rem;">
                    <thead class="thead-light">
                        <tr><th>Title</th><th>Discount</th><th>Period</th><th>Uses</th><th>Status</th><th style="text-align:right;">Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php


if (!empty($all_sales)): ?>
                            <?php


foreach ($all_sales as $s):
                                $now = time();
                                $is_live = $s['is_active'] && strtotime($s['ends_at']) > $now && strtotime($s['starts_at']) <= $now;
                                $is_sched = $s['is_active'] && strtotime($s['starts_at']) > $now;
                                $disc_label = $s['discount_type']==='percent' ? $s['discount_value'].'%' : 'â‚¹'.number_format((float)$s['discount_value']);
                            ?>
                            <tr>
                                <td>
                                    <div class="font-weight-bold"><?= htmlspecialchars($s['title']) ?></div>
                                    <div class="text-muted" style="font-size:0.75rem;"><?= htmlspecialchars(substr($s['description'],0,50)) ?></div>
                                </td>
                                <td><span class="badge badge-danger"><?= $disc_label ?> <?= $s['discount_type']==='percent'?'OFF':'flat' ?></span></td>
                                <td>
                                    <div style="font-size:0.78rem;"><?= date('d M y, h:i A', strtotime($s['starts_at'])) ?></div>
                                    <div class="text-danger" style="font-size:0.78rem;">â†’ <?= date('d M y, h:i A', strtotime($s['ends_at'])) ?></div>
                                </td>
                                <td><?= (int)$s['uses_count'] ?><?= $s['max_uses'] ? ' / '.$s['max_uses'] : '' ?></td>
                                <td>
                                    <?php


if ($is_live): ?><span class="badge badge-danger">ðŸ”´ LIVE</span>
                                    <?php


elseif ($is_sched): ?><span class="badge badge-warning" style="color:#000;">â° Scheduled</span>
                                    <?php


elseif (!$s['is_active']): ?><span class="badge badge-secondary">Paused</span>
                                    <?php


else: ?><span class="badge badge-light text-muted">Ended</span><?php


endif; ?>
                                </td>
                                <td style="text-align:right;">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="flash_action" value="toggle_flash">
                                        <input type="hidden" name="flash_id" value="<?= $s['id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-outline-<?= $s['is_active'] ? 'warning' : 'success' ?> py-1 px-2 mr-1" style="font-size:0.72rem;">
                                            <?= $s['is_active'] ? 'Pause' : 'Resume' ?>
                                        </button>
                                    </form>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this flash sale?')">
                                        <input type="hidden" name="flash_action" value="delete_flash">
                                        <input type="hidden" name="flash_id" value="<?= $s['id'] ?>">
                                        <button type="submit" class="btn btn-xs btn-outline-danger py-1 px-2" style="font-size:0.72rem;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php


endforeach; ?>
                        <?php


else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted"><i class="fas fa-bolt fa-2x mb-2 d-block text-danger"></i><strong>No flash sales yet.</strong><div class="small mt-1">Launch your first flash deal to drive urgency and spike conversions!</div></td></tr>
                        <?php


endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Flash Sale -->
<div class="modal fade" id="createFlashModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;">
            <div class="modal-header" style="background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:16px 16px 0 0;">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-bolt mr-2"></i> Launch New Flash Sale</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="flash_action" value="create_flash">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-8 form-group mb-3">
                            <label class="font-weight-bold">Deal Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Midnight Madness â€” 50% Off All Tops" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Badge Label</label>
                            <select name="badge_text" class="form-control">
                                <option>FLASH DEAL</option><option>DEAL OF THE DAY</option><option>HOT OFFER</option>
                                <option>LIMITED TIME</option><option>MIDNIGHT DROP</option><option>VIP EARLY ACCESS</option>
                            </select>
                        </div>
                        <div class="col-12 form-group mb-3">
                            <label class="font-weight-bold">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Short deal description shown to customers..."></textarea>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Discount Type</label>
                            <select name="discount_type" class="form-control"><option value="percent">Percentage (%)</option><option value="fixed">Fixed Amount (â‚¹)</option></select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="discount_value" class="form-control" placeholder="30" required>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label class="font-weight-bold">Max Uses (leave blank = unlimited)</label>
                            <input type="number" name="max_uses" class="form-control" placeholder="e.g. 100">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Start Date &amp; Time</label>
                            <input type="datetime-local" name="starts_at" class="form-control" value="<?= date('Y-m-d\TH:i') ?>" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">End Date &amp; Time</label>
                            <input type="datetime-local" name="ends_at" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime('+24 hours')) ?>" required>
                        </div>
                        <div class="col-md-6 form-group mb-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="showTimerChk" name="show_timer" checked>
                                <label class="custom-control-label font-weight-bold" for="showTimerChk">Show Live Countdown Timer on Storefront</label>
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-0">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="showStockChk" name="show_stock_bar" checked>
                                <label class="custom-control-label font-weight-bold" for="showStockChk">Show Scarcity Stock Bar (FOMO engine)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm font-weight-bold px-4">
                        <i class="fas fa-bolt mr-1"></i> Launch Flash Sale Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Live countdown updater
function updateCountdowns() {
    document.querySelectorAll('.countdown-wrap').forEach(function(wrap) {
        var ends = parseInt(wrap.dataset.ends) * 1000;
        var diff = Math.max(0, Math.floor((ends - Date.now()) / 1000));
        var h = Math.floor(diff / 3600), m = Math.floor((diff % 3600) / 60), s = diff % 60;
        var pad = n => String(n).padStart(2,'0');
        var hh = wrap.querySelector('.HH'), mm = wrap.querySelector('.MM'), ss = wrap.querySelector('.SS');
        if (hh) hh.firstChild.textContent = pad(h);
        if (mm) mm.firstChild.textContent = pad(m);
        if (ss) ss.firstChild.textContent = pad(s);
    });
}
setInterval(updateCountdowns, 1000);
updateCountdowns();
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
