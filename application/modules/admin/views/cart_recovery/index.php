<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-1">🛒 Cart Recovery</h2>
  <p class="text-muted mb-3">Track abandoned carts &amp; recovery rates</p>

  <div class="row g-3 mb-4">
    <?php $kpis = [
      ['Abandoned Carts', number_format($total_abandoned), 'fa-shopping-cart', '#e74a3b'],
      ['Recovered', number_format($converted), 'fa-check-circle', '#1cc88a'],
      ['Recovery Rate', $recovery_rate.'%', 'fa-percentage', $recovery_rate >= 10 ? '#1cc88a' : '#f59e0b'],
    ]; foreach ($kpis as $k): ?>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid <?= $k[3] ?>;">
        <i class="fa <?= $k[2] ?> fa-2x mb-2" style="color:<?= $k[3] ?>;"></i>
        <div style="font-size:1.5rem;font-weight:800;"><?= $k[1] ?></div>
        <div class="text-muted small text-uppercase"><?= $k[0] ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="mb-3"><a href="<?= base_url('admin/cart_recovery/sequences') ?>" class="btn btn-primary btn-sm px-4"><i class="fa fa-cogs mr-1"></i> Manage Recovery Sequences</a></div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">Recent Abandoned Carts</div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead><tr><th>Customer</th><th>Cart Value</th><th>Status</th><th>Abandoned At</th></tr></thead>
        <tbody>
        <?php foreach ($recent_logs as $log): ?>
        <tr>
          <td><?= htmlspecialchars($log['customer_email'] ?? $log['customer_id'] ?? 'Guest') ?></td>
          <td>&#8377;<?= number_format($log['cart_value'] ?? 0, 2) ?></td>
          <td><span class="badge badge-<?= $log['status']==='converted' ? 'success' : ($log['status']==='recovery_sent' ? 'info' : 'secondary') ?>"><?= $log['status'] ?? 'abandoned' ?></span></td>
          <td><small><?= $log['created_at'] ?? '' ?></small></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($recent_logs)): ?><tr><td colspan="4" class="text-center text-muted py-4">No abandoned carts tracked yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
