<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#3b82f6;">📦 Product Bundles</h2>
      <p class="text-muted mb-0">Create "Buy Together &amp; Save" package discounts</p>
    </div>
    <button class="btn btn-primary btn-sm px-4" data-toggle="modal" data-target="#bundleModal"><i class="fa fa-plus mr-1"></i> New Bundle</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Bundle Title</th><th>Description</th><th>Discount</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($bundles as $b): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($b['title']) ?></td>
          <td><small class="text-muted"><?= htmlspecialchars($b['description'] ?? '') ?></small></td>
          <td><?= $b['discount_value'] ?><?= $b['discount_type'] === 'percent' ? '%' : ' flat' ?> off</td>
          <td><span class="badge badge-<?= $b['is_active'] ? 'success' : 'secondary' ?>"><?= $b['is_active'] ? 'Active' : 'Disabled' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/promotions/bundles') ?>" class="d-inline" onsubmit="return confirm('Delete this bundle?')">
              <?= csrf_field() ?>
              <input type="hidden" name="bundle_action" value="delete_bundle">
              <input type="hidden" name="bundle_id" value="<?= $b['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($bundles)): ?><tr><td colspan="5" class="text-center text-muted py-5">No product bundles created yet.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="bundleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Product Bundle</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/promotions/bundles') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="bundle_action" value="create_bundle">
        <div class="modal-body">
          <div class="form-group"><label>Bundle Title *</label><input type="text" name="title" class="form-control" required placeholder="e.g. Starter Pack (Watch + Strap)"></div>
          <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="2" placeholder="Save 15% when bought together"></textarea></div>
          <div class="row">
            <div class="col-6 form-group"><label>Discount Type</label><select name="discount_type" class="form-control"><option value="percent">Percentage (%)</option><option value="fixed">Fixed (₹)</option></select></div>
            <div class="col-6 form-group"><label>Discount Value *</label><input type="number" step="0.01" min="0" name="discount_value" class="form-control" required placeholder="15"></div>
          </div>
          <div class="form-group">
            <label>Product IDs (comma separated)</label>
            <input type="text" name="product_ids" class="form-control" placeholder="e.g. 1, 4, 7">
            <small class="text-muted">Enter product IDs from your catalog that belong to this bundle.</small>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create Bundle</button></div>
      </form>
    </div>
  </div>
</div>
