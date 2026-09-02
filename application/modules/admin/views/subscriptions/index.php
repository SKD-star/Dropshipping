<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Header Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-sync-alt text-primary mr-2"></i>Membership &amp; Apparel Subscriptions
      </h3>
      <p class="text-muted small mb-0">Automated recurring billing, monthly graphic tee clubs, and VIP mystery capsules</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/subscriptions/plans') ?>" class="btn btn-primary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-layer-group mr-1"></i> Manage Plans &amp; Pricing
      </a>
      <a href="<?= base_url('admin/loyalty') ?>" class="btn btn-outline-warning text-dark btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-crown mr-1"></i> VIP Loyalty Hub
      </a>
    </div>
  </div>

  <!-- KPI Metric Cards Grid -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #4f46e5 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Active Plans</div>
        <div class="font-weight-bold text-dark" style="font-size:1.3rem;"><?= count($plans) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #10b981 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Active Subscribers</div>
        <div class="font-weight-bold text-success" style="font-size:1.3rem;"><?= number_format($active_count) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #f59e0b !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Billing Engine</div>
        <div class="font-weight-bold text-dark" style="font-size:1.1rem;"><span class="badge badge-success px-2 py-1">Razorpay Auto-Debit</span></div>
      </div>
    </div>
    <div class="col-6 col-md-3 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #8b5cf6 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Automated Dispatch</div>
        <div class="font-weight-bold text-dark" style="font-size:1.1rem;"><span class="badge badge-primary px-2 py-1">Supplier Auto-Print</span></div>
      </div>
    </div>
  </div>

  <!-- Subscription Plans Grid -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark"><i class="fas fa-boxes text-primary mr-2"></i> Active Membership Plans</span>
      <a href="<?= base_url('admin/subscriptions/plans') ?>" class="small font-weight-bold text-primary">Configure Plans &rarr;</a>
    </div>
    <div class="card-body p-3 p-md-4">
      <div class="row g-3">
        <?php foreach ($plans as $p): 
          $feats = json_decode($p['features_json'] ?? '[]', true) ?: [];
        ?>
        <div class="col-md-6 mb-3">
          <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="font-weight-bold text-dark mb-0"><?= htmlspecialchars($p['name']) ?></h5>
              <span class="badge badge-primary font-mono text-uppercase px-2 py-1"><?= $p['billing_cycle'] ?></span>
            </div>
            <div class="text-success font-weight-bold mb-2" style="font-size:1.4rem;">
              ₹<?= number_format($p['price'], 2) ?> <small class="text-muted font-weight-normal">/ <?= $p['billing_cycle'] ?></small>
            </div>
            <p class="text-muted small mb-3"><?= htmlspecialchars($p['description']) ?></p>
            <ul class="list-unstyled small text-dark mb-0 space-y-1">
              <?php foreach ($feats as $f): ?>
                <li class="mb-1"><i class="fas fa-check text-success mr-1.5"></i> <?= htmlspecialchars($f) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Subscribers Table Card -->
  <div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark"><i class="fas fa-users text-success mr-2"></i> Active Subscribers Ledger</span>
      <span class="badge badge-light border font-weight-bold px-2.5 py-1"><?= count($subscribers) ?> Active</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3">Subscriber Email</th>
              <th class="py-3">Membership Plan</th>
              <th class="py-3">Status</th>
              <th class="py-3">Next Renewal Date</th>
              <th class="py-3 text-right px-3">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($subscribers as $s): ?>
          <tr>
            <td class="px-3 font-weight-bold text-dark"><?= htmlspecialchars($s['customer_email'] ?? '#'.$s['customer_id']) ?></td>
            <td><span class="badge badge-light border font-weight-bold"><?= htmlspecialchars($s['plan_name'] ?? '#'.$s['plan_id']) ?></span></td>
            <td><span class="badge badge-<?= ($s['status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> px-2.5 py-1"><?= ucfirst($s['status'] ?? 'active') ?></span></td>
            <td><small class="text-muted font-mono"><?= $s['renewal_date'] ?? date('Y-m-d', strtotime('+30 days')) ?></small></td>
            <td class="text-right px-3">
              <?php if (($s['status'] ?? 'active') === 'active'): ?>
              <a href="<?= base_url('admin/subscriptions/cancel_subscriber/'.$s['id']) ?>" class="btn btn-outline-danger btn-sm font-weight-bold" onclick="return confirm('Cancel this subscription?')">Cancel Subscription</a>
              <?php else: ?>
              <span class="text-muted small">Cancelled</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($subscribers)): ?>
          <tr><td colspan="5" class="text-center text-muted py-4">No active recurring subscribers found yet</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
