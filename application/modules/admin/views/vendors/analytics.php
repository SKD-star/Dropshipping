<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-4">
  <!-- Top Header Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-chart-line text-primary mr-2"></i>Vendor Marketplace Analytics
      </h3>
      <p class="text-muted small mb-0">Comprehensive performance ledger: Gross Merchandise Value (GMV), platform commission yields, and net payout settlements</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="<?= base_url('admin/vendors/payouts') ?>" class="btn btn-outline-success btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-money-bill-wave mr-1.5"></i> Settlements Ledger
      </a>
      <a href="<?= base_url('admin/vendors') ?>" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-arrow-left mr-1.5"></i> All Vendors
      </a>
    </div>
  </div>

  <!-- KPI Metric Cards Grid -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm h-100" style="border-radius:14px; border-left:4px solid #4f46e5 !important;">
        <div class="card-body p-3.5">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted small font-weight-bold text-uppercase">Marketplace GMV</span>
            <div class="rounded-circle p-2" style="background:rgba(79,70,229,0.1); color:#4f46e5;">
              <i class="fas fa-shopping-bag fa-sm"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-dark mb-1 font-mono">₹<?= number_format((float)($gmv['total_gmv'] ?? 0), 2) ?></h3>
          <span class="text-muted small font-mono"><?= number_format((int)($gmv['total_orders'] ?? 0)) ?> Paid Orders (<?= number_format((int)($gmv['total_units_sold'] ?? 0)) ?> Items)</span>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm h-100" style="border-radius:14px; border-left:4px solid #10b981 !important;">
        <div class="card-body p-3.5">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted small font-weight-bold text-uppercase">Platform Yield</span>
            <div class="rounded-circle p-2" style="background:rgba(16,185,129,0.1); color:#10b981;">
              <i class="fas fa-percentage fa-sm"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-success mb-1 font-mono">₹<?= number_format((float)($gmv['total_commission'] ?? 0), 2) ?></h3>
          <span class="text-muted small">Retained Marketplace Take</span>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm h-100" style="border-radius:14px; border-left:4px solid #06b6d4 !important;">
        <div class="card-body p-3.5">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted small font-weight-bold text-uppercase">Paid Out to Date</span>
            <div class="rounded-circle p-2" style="background:rgba(6,182,212,0.1); color:#06b6d4;">
              <i class="fas fa-check-double fa-sm"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-info mb-1 font-mono">₹<?= number_format((float)($payouts['total_paid_out'] ?? 0), 2) ?></h3>
          <span class="text-muted small font-mono"><?= (int)($payouts['paid_cycles_count'] ?? 0) ?> Settled Payout Cycles</span>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="card border-0 shadow-sm h-100" style="border-radius:14px; border-left:4px solid #f59e0b !important;">
        <div class="card-body p-3.5">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted small font-weight-bold text-uppercase">Pending Pipeline</span>
            <div class="rounded-circle p-2" style="background:rgba(245,158,11,0.1); color:#f59e0b;">
              <i class="fas fa-clock fa-sm"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-warning mb-1 font-mono">₹<?= number_format((float)($payouts['pending_settlements'] ?? 0), 2) ?></h3>
          <span class="text-muted small font-mono"><?= (int)($payouts['pending_cycles_count'] ?? 0) ?> Cycles Awaiting Bank Transfer</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor Performance Table -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
      <h6 class="font-weight-bold text-dark mb-0">
        <i class="fas fa-award text-warning mr-2"></i>Seller Performance &amp; Revenue Breakdown
      </h6>
      <span class="badge badge-light border text-muted px-2 py-1"><?= count($vendor_perf) ?> Registered Sellers</span>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
        <thead class="bg-light text-muted small text-uppercase font-weight-bold">
          <tr>
            <th class="py-3 px-4">Seller / Business</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-center">Active Catalog</th>
            <th class="py-3 text-center">Paid Orders</th>
            <th class="py-3 text-right">Gross Sales (GMV)</th>
            <th class="py-3 text-right">Commission Rate</th>
            <th class="py-3 text-right">Platform Yield</th>
            <th class="py-3 text-right">Net Earned</th>
            <th class="py-3 text-center px-4">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($vendor_perf)): ?>
            <tr>
              <td colspan="9" class="text-center py-5 text-muted">
                <i class="fas fa-store fa-2x mb-2 d-block text-muted"></i>
                No sellers found in the marketplace.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($vendor_perf as $v): ?>
              <tr>
                <td class="px-4">
                  <div class="font-weight-bold text-dark"><?= htmlspecialchars($v['business_name']) ?></div>
                  <div class="text-muted small" style="font-size:0.75rem;">
                    <?= htmlspecialchars($v['contact_name'] ?: 'Contact Unset') ?> • <?= htmlspecialchars($v['email'] ?: '') ?>
                  </div>
                </td>
                <td>
                  <?php if ($v['status'] === 'approved'): ?>
                    <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>Approved</span>
                  <?php elseif ($v['status'] === 'pending'): ?>
                    <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-clock mr-1"></i>Pending</span>
                  <?php else: ?>
                    <span class="badge badge-danger px-2 py-1"><?= htmlspecialchars(ucfirst($v['status'])) ?></span>
                  <?php endif; ?>
                </td>
                <td class="text-center font-mono"><?= (int)$v['active_products'] ?> items</td>
                <td class="text-center font-mono font-weight-bold"><?= (int)$v['paid_orders_count'] ?></td>
                <td class="text-right font-mono font-weight-bold text-dark">
                  ₹<?= number_format((float)$v['vendor_gmv'], 2) ?>
                </td>
                <td class="text-right font-mono text-muted">
                  <?= $v['commission_type'] === 'percent' ? ((float)$v['commission_value'] . '%') : ('₹' . number_format((float)$v['commission_value'], 2)) ?>
                </td>
                <td class="text-right font-mono text-success font-weight-bold">
                  ₹<?= number_format((float)$v['platform_commission'], 2) ?>
                </td>
                <td class="text-right font-mono font-weight-bold text-primary">
                  ₹<?= number_format((float)$v['net_earned'], 2) ?>
                </td>
                <td class="text-center px-4">
                  <a href="<?= base_url('admin/vendors/detail/' . $v['id']) ?>" class="btn btn-outline-primary btn-sm px-2.5 shadow-sm" style="border-radius:6px;" title="View Vendor Profile">
                    <i class="fas fa-external-link-alt"></i> Detail
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Recent Payout Settlements Ledger -->
  <div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
      <h6 class="font-weight-bold text-dark mb-0">
        <i class="fas fa-history text-info mr-2"></i>Recent Settlement Cycles
      </h6>
      <a href="<?= base_url('admin/vendors/payouts') ?>" class="text-primary font-weight-bold small">
        View All Settlements →
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
        <thead class="bg-light text-muted small text-uppercase font-weight-bold">
          <tr>
            <th class="py-3 px-4">ID</th>
            <th class="py-3">Vendor</th>
            <th class="py-3">Period</th>
            <th class="py-3 text-right">Net Payable</th>
            <th class="py-3 text-center">Status</th>
            <th class="py-3">Bank Reference</th>
            <th class="py-3 text-right px-4">Settled At</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recent_payouts)): ?>
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">No recent payout settlement cycles recorded.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($recent_payouts as $rp): ?>
              <tr>
                <td class="px-4 font-mono font-weight-bold text-muted">#<?= $rp['id'] ?></td>
                <td class="font-weight-bold text-dark"><?= htmlspecialchars($rp['business_name'] ?? ('Vendor #' . $rp['vendor_id'])) ?></td>
                <td class="font-mono small text-muted"><?= htmlspecialchars($rp['period_start']) ?> → <?= htmlspecialchars($rp['period_end']) ?></td>
                <td class="text-right font-mono font-weight-bold text-success">₹<?= number_format((float)$rp['net_payable'], 2) ?></td>
                <td class="text-center">
                  <?php if ($rp['status'] === 'paid'): ?>
                    <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>PAID</span>
                  <?php else: ?>
                    <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-clock mr-1"></i>PENDING</span>
                  <?php endif; ?>
                </td>
                <td class="font-mono small text-muted"><?= htmlspecialchars($rp['reference'] ?: 'Pending Transfer') ?></td>
                <td class="text-right px-4 font-mono small text-muted"><?= $rp['paid_at'] ? date('M d, Y', strtotime($rp['paid_at'])) : '—' ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
