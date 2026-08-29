<?php
require_once __DIR__ . '/layout_header.php';


$intl_msg = null;
$intl_err = null;

// Handle Currency Update POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['intl_action'])) {
    $act = $_POST['intl_action'];

    if ($act === 'update_rates') {
        $rates = $_POST['rates'] ?? [];
        foreach ($rates as $code => $r_val) {
            $r_float = (float)$r_val;
            $conn->query("UPDATE `currency_rates` SET `exchange_rate` = $r_float, `updated_at` = NOW() WHERE `code` = '" . $conn->real_escape_string($code) . "'");
        }
        $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.forex_sentinel', 1, 'currency_rates.updated', 'currency_rates', 0, '{\"status\":\"updated\"}', NOW())");
        $intl_msg = "âœ¦ Global currency exchange rates successfully updated and synchronized across all international storefront checkout sessions!";
    }
}

// Fetch currencies
$currencies_res = $conn->query("SELECT * FROM `currency_rates` ORDER BY id ASC");
$currencies = [];
if ($currencies_res) {
    while ($c = $currencies_res->fetch_assoc()) $currencies[] = $c;
}
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-purple px-3 py-1 font-weight-bold" style="background:#f5f3ff;color:#8b5cf6;font-size:0.8rem;border-radius:20px;">
                    â— GLOBAL TRADE &amp; FOREX 2.0
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">7 Currencies Supported</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px; font-size: 1.5rem;">
                <i class="fas fa-globe text-primary mr-2"></i> Global Multi-Currency &amp; International Trade Studio
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Configure real-time exchange rates, manage geo-location price auto-conversion, and monitor international cross-border delivery SLAs.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <a href="index.php?q=4" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                <i class="fas fa-receipt mr-1"></i> Ledger Studio
            </a>
            <button type="submit" form="currencyForm" class="btn btn-primary btn-sm font-weight-bold shadow-sm" style="border-radius: 8px; padding: 7px 16px;">
                <i class="fas fa-save mr-1"></i> Save Forex Rates
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php


if ($intl_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($intl_msg) ?>
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
                        <div class="text-muted small font-weight-bold text-uppercase">Active Currencies</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= count($currencies) ?> Markets</h3>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-coins"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Base Store Currency</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">INR (â‚¹) Base</h3>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-rupee-sign"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Geo-IP Auto-Detection</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">â— Armed &amp; Active</h3>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-map-marked-alt"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Global Carrier Health</div>
                        <h3 class="font-weight-bold text-info mb-0 mt-1">99.4% On-Time</h3>
                    </div>
                    <div class="icon-capsule cyan" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-plane-departure"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Currency Exchange Table -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px; background: var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="font-weight-bold" style="font-size: 1.05rem;">
                <i class="fas fa-exchange-alt text-primary mr-2"></i> Real-Time Multi-Currency Forex Rate Multipliers
            </span>
            <span class="badge badge-light border text-muted">Auto-Updated Relative to 1 INR</span>
        </div>
        <div class="card-body p-0">
            <form method="POST" id="currencyForm">
                <input type="hidden" name="intl_action" value="update_rates">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Currency Name</th>
                                <th>Code &amp; Symbol</th>
                                <th>Rate (1 INR = X)</th>
                                <th>Sample Product Price (â‚¹4,199)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php


foreach ($currencies as $cur): ?>
                                <?php


$rate = (float)$cur['exchange_rate'];
                                $sample_calc = $cur['symbol'] . number_format(4199.00 * $rate, 2);
                                ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark"><?= htmlspecialchars($cur['name']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border font-weight-bold"><?= $cur['code'] ?> (<?= $cur['symbol'] ?>)</span>
                                    </td>
                                    <td>
                                        <div class="input-group" style="max-width: 160px;">
                                            <input type="number" step="0.0001" name="rates[<?= $cur['code'] ?>]" class="form-control font-weight-bold" value="<?= $rate ?>" <?= ($cur['code'] === 'INR') ? 'readonly' : '' ?>>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success"><?= $sample_calc ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-success px-2 py-1">â— Enabled</span>
                                    </td>
                                </tr>
                            <?php


endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
