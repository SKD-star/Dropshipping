<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">📋 Subscription Plans</h2>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#planModal"><i class="fa fa-plus mr-1"></i> New Plan</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('error')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="row g-3">
    <?php foreach ($plans as $p):
      $p_name   = $p['name'] ?? ($p['title'] ?? ($p['plan_name'] ?? 'Membership Plan'));
      $p_cycle  = $p['billing_cycle'] ?? ($p['interval'] ?? 'monthly');
      $p_price  = (float)($p['price'] ?? ($p['amount'] ?? 0));
      $p_trial  = (int)($p['trial_days'] ?? 0);
      $p_active = (int)($p['is_active'] ?? 1);
      $p_count  = (int)($p['subscriber_count'] ?? 0);
      $features = json_decode($p['features_json'] ?? '[]', true) ?: [];
    ?>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm <?= $p_active ? '' : 'opacity-75' ?>">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
          <span class="fw-bold"><?= htmlspecialchars($p_name) ?></span>
          <span class="badge badge-<?= $p_active ? 'success' : 'secondary' ?>"><?= $p_active ? 'Active' : 'Off' ?></span>
        </div>
        <div class="card-body text-center">
          <div style="font-size:2rem;font-weight:800;color:#4e73df;">&#8377;<?= number_format($p_price, 0) ?></div>
          <div class="text-muted small mb-2">per <?= htmlspecialchars($p_cycle) ?></div>
          <?php if ($p_trial > 0): ?><div class="badge badge-info mb-2"><?= $p_trial ?>-day free trial</div><?php endif; ?>
          <div class="badge badge-success mb-3"><?= number_format($p_count) ?> active subscribers</div>
          <ul class="list-unstyled text-left small">
            <?php foreach ($features as $f): ?><li class="mb-1"><i class="fa fa-check text-success mr-2"></i><?= htmlspecialchars($f) ?></li><?php endforeach; ?>
          </ul>
        </div>
        <div class="card-footer bg-white d-flex gap-2">
          <form method="post" action="<?= base_url('admin/subscriptions/plans') ?>" class="flex-fill">
            <?= csrf_field() ?><input type="hidden" name="plan_action" value="toggle"><input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button class="btn btn-sm btn-outline-<?= $p['is_active'] ? 'warning' : 'success' ?> w-100"><?= $p['is_active'] ? 'Deactivate' : 'Activate' ?></button>
          </form>
          <form method="post" action="<?= base_url('admin/subscriptions/plans') ?>" class="d-inline" onsubmit="return confirm('Delete plan?')">
            <?= csrf_field() ?><input type="hidden" name="plan_action" value="delete"><input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($plans)): ?><div class="col"><p class="text-muted">No plans yet. Create your first plan.</p></div><?php endif; ?>
  </div>
</div>

<div class="modal fade" id="planModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
  <div class="modal-header"><h5 class="modal-title">New Subscription Plan</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
  <form method="post" action="<?= base_url('admin/subscriptions/plans') ?>">
    <?= csrf_field() ?><input type="hidden" name="plan_action" value="create">
    <div class="modal-body">
      <div class="form-group"><label>Plan Name *</label><input type="text" name="name" class="form-control" required placeholder="e.g. Premium"></div>
      <div class="row"><div class="col-6 form-group"><label>Price (&#8377;) *</label><input type="number" step="0.01" name="price" class="form-control" required></div><div class="col-6 form-group"><label>Billing Cycle</label><select name="billing_cycle" class="form-control"><option value="monthly">Monthly</option><option value="quarterly">Quarterly</option><option value="annual">Annual</option></select></div></div>
      <div class="form-group"><label>Trial Days</label><input type="number" min="0" name="trial_days" class="form-control" value="0"></div>
      <div class="form-group"><label>Features (one per line)</label><textarea name="features" class="form-control" rows="4" placeholder="Free shipping&#10;Priority support&#10;Early access"></textarea></div>
    </div>
    <div class="modal-footer"><button class="btn btn-primary">Create Plan</button></div>
  </form>
</div></div></div>
