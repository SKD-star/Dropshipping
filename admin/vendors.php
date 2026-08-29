<?php
require_once __DIR__ . '/layout_header.php';
require_once __DIR__ . '/../application/core/agents/VendorMarketplaceAgent.php';

$pdo_adm = new PDO(
    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST') ?: '127.0.0.1', getenv('DB_PORT') ?: '3306', getenv('DB_NAME') ?: 'novadrop'),
    getenv('DB_USER') ?: 'root',
    getenv('DB_PASS') ?: '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
);

$vend_agent = new \App\Agents\VendorMarketplaceAgent($pdo_adm, 1);
$admin_msg = null;

// Handle Vendor Status Updates
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['admin_vendor_action'])) {
    $action = $_POST['admin_vendor_action'];
    $vid = (int)$_POST['vendor_id'];

    if ($action === 'approve') {
        $pdo_adm->prepare("UPDATE vendors SET status = 'approved', updated_at = NOW() WHERE id = ?")->execute([$vid]);
        $admin_msg = "<div class='alert alert-success'>✓ Vendor #$vid successfully approved for live selling!</div>";
    } elseif ($action === 'suspend') {
        $pdo_adm->prepare("UPDATE vendors SET status = 'suspended', updated_at = NOW() WHERE id = ?")->execute([$vid]);
        $admin_msg = "<div class='alert alert-warning'>⚠️ Vendor #$vid has been suspended.</div>";
    } elseif ($action === 'override_commission') {
        $comm = (float)$_POST['commission_value'];
        $type = $_POST['commission_type'] ?? 'percent';
        $pdo_adm->prepare("UPDATE vendors SET commission_type = ?, commission_value = ?, updated_at = NOW() WHERE id = ?")->execute([$type, $comm, $vid]);
        $admin_msg = "<div class='alert alert-success'>✓ Commission rate for Vendor #$vid updated to $comm ($type)!</div>";
    }
}

// Handle Batch Payout Run
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_run_all_payouts'])) {
    $all_v = $pdo_adm->query("SELECT id FROM vendors WHERE status = 'approved'")->fetchAll(PDO::FETCH_COLUMN);
    $generated_count = 0;
    foreach ($all_v as $v_id) {
        $p_res = $vend_agent->generate_payout_batch((int)$v_id);
        if ($p_res['success']) $generated_count++;
    }
    $admin_msg = "<div class='alert alert-success'>✓ Generated $generated_count pending payout settlement batches across all active sellers!</div>";
}

// Handle Mark Payout as Paid
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action_mark_payout_paid'])) {
    $payout_id = (int)$_POST['payout_id'];
    $ref = trim($_POST['reference'] ?? ('BANK-' . rand(100000, 999999)));
    $pdo_adm->prepare("UPDATE vendor_payouts SET status = 'paid', paid_at = NOW(), reference = ? WHERE id = ?")->execute([$ref, $payout_id]);
    $admin_msg = "<div class='alert alert-success'>✓ Payout #$payout_id marked as PAID with Reference: <strong>$ref</strong></div>";
}

// Fetch Marketplace KPIs
$stmt_vkpi = $pdo_adm->query("
    SELECT 
        COUNT(*) as total_vendors,
        SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_vendors,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_vendors,
        (SELECT COALESCE(SUM(total_price), 0) FROM order_items WHERE vendor_id IS NOT NULL) as marketplace_gmv,
        (SELECT COALESCE(SUM(vendor_commission_amount), 0) FROM order_items WHERE vendor_id IS NOT NULL) as platform_commission,
        (SELECT COALESCE(SUM(net_payable), 0) FROM vendor_payouts WHERE status = 'pending') as pending_payouts_volume
    FROM vendors
");
$kpi_data = $stmt_vkpi->fetch();

// Fetch All Vendors
$vendors_list = $pdo_adm->query("
    SELECT v.*, 
           (SELECT COUNT(*) FROM vendor_products vp WHERE vp.vendor_id = v.id) as listed_products_count,
           (SELECT COALESCE(SUM(oi.total_price), 0) FROM order_items oi WHERE oi.vendor_id = v.id) as total_vendor_sales
    FROM vendors v 
    ORDER BY v.id DESC
")->fetchAll();

// Fetch All Vendor Payouts
$payouts_list = $pdo_adm->query("
    SELECT vp.*, v.business_name, v.email as vendor_email, v.payout_method
    FROM vendor_payouts vp
    JOIN vendors v ON v.id = vp.vendor_id
    ORDER BY vp.id DESC
")->fetchAll();
?>

<div class="container-fluid py-4 cont">
    <?= $admin_msg ?>

    <!-- Studio Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="font-weight-bold text-dark mb-1"><i class="fas fa-store text-warning mr-2"></i> Multi-Vendor Marketplace Studio</h3>
            <p class="text-muted small mb-0">Manage onboarded sellers, commission structures, order routing, and automated payout settlements.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="../sellers" target="_blank" class="btn btn-outline-primary btn-sm font-weight-bold">
                <i class="fas fa-external-link-alt mr-1"></i> Open Seller Portal
            </a>
            <form method="POST" style="margin:0;">
                <input type="hidden" name="action_run_all_payouts" value="1">
                <button type="submit" class="btn btn-success btn-sm font-weight-bold">
                    <i class="fas fa-calculator mr-1"></i> Run Payout Batch Generator
                </button>
            </form>
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Onboarded Sellers</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= (int)$kpi_data['total_vendors'] ?></h3>
                        <span class="text-success small font-weight-bold"><?= (int)$kpi_data['approved_vendors'] ?> Active · <?= (int)$kpi_data['pending_vendors'] ?> Pending</span>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-users-cog"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Marketplace GMV</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1">₹<?= number_format((float)$kpi_data['marketplace_gmv'], 2) ?></h3>
                        <span class="text-muted small">Total 3rd-party vendor volume</span>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-shopping-bag"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Platform Commission</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">₹<?= number_format((float)$kpi_data['platform_commission'], 2) ?></h3>
                        <span class="text-muted small">Retained platform margin</span>
                    </div>
                    <div class="icon-capsule purple" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-percentage"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Pending Payouts</div>
                        <h3 class="font-weight-bold text-warning mb-0 mt-1">₹<?= number_format((float)$kpi_data['pending_payouts_volume'], 2) ?></h3>
                        <span class="text-muted small">Awaiting settlement</span>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-hand-holding-usd"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-pills mb-4" id="mpTabNav" style="gap: 8px;">
        <li class="nav-item"><a class="nav-link active font-weight-bold" data-toggle="pill" href="#sellersTab"><i class="fas fa-id-badge mr-1"></i> Sellers Directory &amp; Approvals</a></li>
        <li class="nav-item"><a class="nav-link font-weight-bold" data-toggle="pill" href="#payoutsTab"><i class="fas fa-file-invoice-dollar mr-1"></i> Payout Settlements Ledger</a></li>
    </ul>

    <div class="tab-content">
        <!-- ── TAB 1: SELLERS DIRECTORY ───────────────────────────── -->
        <div class="tab-pane fade show active" id="sellersTab">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-dark"><i class="fas fa-users mr-2 text-primary"></i> Registered Marketplace Vendors</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Business Name</th>
                                    <th>Contact &amp; Phone</th>
                                    <th>Commission Rate</th>
                                    <th>Products Listed</th>
                                    <th>Total GMV</th>
                                    <th>Status</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($vendors_list)): ?>
                                <tr><td colspan="7" class="text-center py-4 text-muted">No vendors registered yet. Share the Seller Portal link to onboard sellers.</td></tr>
                                <?php else: foreach ($vendors_list as $v): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($v['business_name']) ?></strong>
                                        <div class="small text-muted">GSTIN: <?= htmlspecialchars($v['gstin'] ?: 'Not Provided') ?></div>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($v['contact_name']) ?>
                                        <div class="small text-muted"><?= htmlspecialchars($v['email']) ?> · <?= htmlspecialchars($v['phone']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary px-2 py-1"><?= $v['commission_value'] ?><?= $v['commission_type'] === 'percent' ? '%' : ' Flat' ?></span>
                                    </td>
                                    <td><strong><?= (int)$v['listed_products_count'] ?></strong> items</td>
                                    <td class="font-weight-bold text-dark">₹<?= number_format((float)$v['total_vendor_sales'], 2) ?></td>
                                    <td>
                                        <?php if ($v['status'] === 'approved'): ?>
                                        <span class="badge badge-success px-2 py-1">APPROVED</span>
                                        <?php elseif ($v['status'] === 'pending'): ?>
                                        <span class="badge badge-warning px-2 py-1">PENDING</span>
                                        <?php else: ?>
                                        <span class="badge badge-danger px-2 py-1">SUSPENDED</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php if ($v['status'] !== 'approved'): ?>
                                        <form method="POST" style="display:inline-block; margin:0;">
                                            <input type="hidden" name="admin_vendor_action" value="approve">
                                            <input type="hidden" name="vendor_id" value="<?= $v['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-success mr-1 font-weight-bold" title="Approve Vendor"><i class="fas fa-check"></i> Approve</button>
                                        </form>
                                        <?php else: ?>
                                        <form method="POST" style="display:inline-block; margin:0;">
                                            <input type="hidden" name="admin_vendor_action" value="suspend">
                                            <input type="hidden" name="vendor_id" value="<?= $v['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger mr-1" title="Suspend Vendor"><i class="fas fa-ban"></i> Suspend</button>
                                        </form>
                                        <?php endif; ?>

                                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#commModal_<?= $v['id'] ?>">
                                            <i class="fas fa-cog"></i> Commission
                                        </button>

                                        <!-- Commission Override Modal -->
                                        <div class="modal fade" id="commModal_<?= $v['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-bold">Commission Override — <?= htmlspecialchars($v['business_name']) ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form method="POST">
                                                        <input type="hidden" name="admin_vendor_action" value="override_commission">
                                                        <input type="hidden" name="vendor_id" value="<?= $v['id'] ?>">
                                                        <div class="modal-body text-left">
                                                            <div class="form-group">
                                                                <label class="font-weight-bold small text-muted">Commission Type</label>
                                                                <select name="commission_type" class="form-control">
                                                                    <option value="percent" <?= $v['commission_type'] === 'percent' ? 'selected' : '' ?>>Percentage of Sale (%)</option>
                                                                    <option value="flat" <?= $v['commission_type'] === 'flat' ? 'selected' : '' ?>>Flat Fee per Item (₹)</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="font-weight-bold small text-muted">Commission Value</label>
                                                                <input type="number" step="0.01" name="commission_value" class="form-control" value="<?= $v['commission_value'] ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary font-weight-bold">Save Commission Rate</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── TAB 2: PAYOUT SETTLEMENTS LEDGER ───────────────────── -->
        <div class="tab-pane fade" id="payoutsTab">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-dark"><i class="fas fa-money-check-alt mr-2 text-success"></i> Marketplace Payout Batches &amp; Disbursements</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Payout Ref</th>
                                    <th>Seller Business</th>
                                    <th>Gross Sales</th>
                                    <th>Commission (Retained)</th>
                                    <th>Net Payable</th>
                                    <th>Status</th>
                                    <th>Reference / Date</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($payouts_list)): ?>
                                <tr><td colspan="8" class="text-center py-4 text-muted">No payout batches generated yet. Click "Run Payout Batch Generator" above to calculate settlements.</td></tr>
                                <?php else: foreach ($payouts_list as $po): ?>
                                <tr>
                                    <td><code><?= htmlspecialchars($po['reference']) ?></code></td>
                                    <td><strong><?= htmlspecialchars($po['business_name']) ?></strong></td>
                                    <td>₹<?= number_format((float)$po['gross_sales'], 2) ?></td>
                                    <td class="text-danger">-₹<?= number_format((float)$po['commission_amount'], 2) ?></td>
                                    <td class="font-weight-bold text-success">₹<?= number_format((float)$po['net_payable'], 2) ?></td>
                                    <td>
                                        <?php if ($po['status'] === 'paid'): ?>
                                        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> PAID</span>
                                        <?php else: ?>
                                        <span class="badge badge-warning px-2 py-1"><i class="fas fa-clock mr-1"></i> PENDING</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= date('d M Y', strtotime($po['created_at'])) ?></small>
                                        <?php if ($po['paid_at']): ?>
                                        <div class="small text-success">Paid: <?= date('d M Y', strtotime($po['paid_at'])) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <?php if ($po['status'] !== 'paid'): ?>
                                        <form method="POST" style="display:inline-block; margin:0;">
                                            <input type="hidden" name="action_mark_payout_paid" value="1">
                                            <input type="hidden" name="payout_id" value="<?= $po['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-success font-weight-bold">
                                                <i class="fas fa-check-double mr-1"></i> Mark as Paid
                                            </button>
                                        </form>
                                        <?php else: ?>
                                        <span class="text-muted small font-weight-bold">Settled ✓</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>

