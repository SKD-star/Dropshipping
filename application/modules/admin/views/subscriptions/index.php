<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-1">📦 Subscriptions</h2>
  <p class="text-muted mb-3">Manage recurring subscription plans &amp; subscribers</p>

  <div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #4e73df;"><div style="font-size:1.4rem;font-weight:800;"><?= count($plans) ?></div><div class="text-muted small">Plans</div></div></div>
    <div class="col-md-3"><div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #1cc88a;"><div style="font-size:1.4rem;font-weight:800;"><?= number_format($active_count) ?></div><div class="text-muted small">Active Subscribers</div></div></div>
    <div class="col-md-6 d-flex align-items-center"><a href="<?= base_url('admin/subscriptions/plans') ?>" class="btn btn-primary mr-2">Manage Plans</a></div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">Recent Subscribers</div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead><tr><th>Customer</th><th>Plan</th><th>Status</th><th>Renewal</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($subscribers as $s): ?>
        <tr>
          <td><?= htmlspecialchars($s['customer_email'] ?? '#'.$s['customer_id']) ?></td>
          <td><?= htmlspecialchars($s['plan_name'] ?? '#'.$s['plan_id']) ?></td>
          <td><span class="badge badge-<?= $s['status']==='active' ? 'success' : ($s['status']==='cancelled' ? 'secondary' : 'warning') ?>"><?= ucfirst($s['status'] ?? '') ?></span></td>
          <td><small><?= $s['renewal_date'] ?? '—' ?></small></td>
          <td>
            <?php if ($s['status'] === 'active'): ?>
            <a href="<?= base_url('admin/subscriptions/cancel_subscriber/'.$s['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel this subscription?')">Cancel</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($subscribers)): ?><tr><td colspan="5" class="text-center text-muted py-4">No subscribers yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
