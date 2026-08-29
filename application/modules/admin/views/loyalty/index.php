<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="fw-bold mb-0" style="color:#1cc88a;">🏆 Loyalty Program</h2><p class="text-muted mb-0">Award points, manage tiers &amp; run bulk bonuses</p></div>
    <div>
      <a href="<?= base_url('admin/loyalty/tiers') ?>" class="btn btn-outline-primary btn-sm mr-2">Tier Config</a>
      <a href="<?= base_url('admin/loyalty/gamification') ?>" class="btn btn-outline-info btn-sm">Spin Wheels</a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <!-- Stats Row -->
  <div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #1cc88a;"><i class="fa fa-coins fa-2x mb-2 text-success"></i><div style="font-size:1.4rem;font-weight:800;"><?= number_format($total_pts) ?></div><div class="text-muted small">Total Points Outstanding</div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #f6c23e;"><i class="fa fa-crown fa-2x mb-2 text-warning"></i>
      <?php $gold_count = 0; foreach ($tier_summary as $ts) { if (stripos($ts['loyalty_tier'] ?? '', 'Gold') !== false || stripos($ts['loyalty_tier'] ?? '', 'Platinum') !== false) $gold_count += $ts['cnt']; } ?>
      <div style="font-size:1.4rem;font-weight:800;"><?= number_format($gold_count) ?></div><div class="text-muted small">Gold+ Members</div></div></div>
    <?php foreach ($tier_summary as $ts): ?>
    <div class="col-md-2"><div class="card border-0 shadow-sm text-center py-2"><div style="font-size:1.1rem;font-weight:700;"><?= number_format($ts['cnt']) ?></div><div class="text-muted small"><?= htmlspecialchars($ts['loyalty_tier'] ?? 'No Tier') ?></div></div></div>
    <?php endforeach; ?>
  </div>

  <div class="row g-3">
    <!-- Award Points Form -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><i class="fa fa-gift mr-2 text-success"></i>Award / Deduct Points</div>
        <div class="card-body">
          <form method="post" action="<?= base_url('admin/loyalty') ?>">
            <?= csrf_field() ?>
            <div class="form-group"><label class="small">Customer ID *</label><input type="number" name="customer_id" class="form-control" required></div>
            <div class="form-group"><label class="small">Points *</label><input type="number" name="points" class="form-control" required min="1"></div>
            <div class="form-group"><label class="small">Reason</label><input type="text" name="reason" class="form-control" placeholder="Reason for adjustment"></div>
            <div class="d-flex gap-2">
              <button type="submit" name="loyalty_action" value="award_points" class="btn btn-success btn-sm flex-fill">Award</button>
              <button type="submit" name="loyalty_action" value="deduct_points" class="btn btn-warning btn-sm flex-fill text-dark">Deduct</button>
            </div>
          </form>
          <hr>
          <form method="post" action="<?= base_url('admin/loyalty') ?>" onsubmit="return confirm('Send bonus points to ALL active customers?')">
            <?= csrf_field() ?>
            <div class="form-group"><label class="small">Bulk Bonus Points (each)</label><input type="number" name="bulk_points" class="form-control" value="100" min="1"></div>
            <button type="submit" name="loyalty_action" value="bulk_award_all" class="btn btn-primary btn-sm w-100"><i class="fa fa-paper-plane mr-1"></i>Send to All Active Customers</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Top Customers -->
    <div class="col-md-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><i class="fa fa-medal mr-2 text-warning"></i>Top 20 Customers by Points</div>
        <div class="card-body p-0">
          <table class="table table-sm table-hover mb-0">
            <thead><tr><th>Rank</th><th>Customer</th><th>Email</th><th>Points</th><th>Tier</th></tr></thead>
            <tbody>
            <?php foreach ($top_customers as $i => $c): ?>
            <tr>
              <td><strong>#<?= $i+1 ?></strong></td>
              <td><?= htmlspecialchars($c['first_name'].' '.$c['last_name']) ?></td>
              <td><small><?= htmlspecialchars($c['email']) ?></small></td>
              <td><span class="badge badge-success"><?= number_format($c['loyalty_points'] ?? 0) ?> pts</span></td>
              <td><small><?= htmlspecialchars($c['loyalty_tier'] ?? 'Silver') ?></small></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($top_customers)): ?><tr><td colspan="5" class="text-center text-muted py-4">No loyalty data yet</td></tr><?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Transactions -->
  <div class="card border-0 shadow-sm mt-3">
    <div class="card-header bg-white fw-bold"><i class="fa fa-history mr-2 text-info"></i>Recent Transactions</div>
    <div class="card-body p-0">
      <table class="table table-sm mb-0">
        <thead><tr><th>Customer #</th><th>Type</th><th>Points</th><th>Reason</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach ($recent_txn as $txn): ?>
        <tr>
          <td><?= $txn['customer_id'] ?></td>
          <td><span class="badge badge-<?= $txn['type']==='credit' ? 'success' : 'danger' ?>"><?= ucfirst($txn['type']) ?></span></td>
          <td><?= ($txn['type']==='credit' ? '+' : '-').number_format($txn['points']) ?></td>
          <td><small><?= htmlspecialchars($txn['reason'] ?? '') ?></small></td>
          <td><small><?= $txn['created_at'] ?></small></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($recent_txn)): ?><tr><td colspan="5" class="text-center text-muted py-3">No transactions yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
