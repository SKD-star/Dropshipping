<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#10b981;">⏰ Pre-Orders</h2>
      <p class="text-muted mb-0">Accept orders and advance deposits for upcoming products</p>
    </div>
    <button class="btn btn-success btn-sm px-4" data-toggle="modal" data-target="#preOrderModal"><i class="fa fa-plus mr-1"></i> New Pre-Order</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Product ID</th><th>Available From</th><th>Max Qty</th><th>Deposit Required</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($pre_orders as $po): ?>
        <tr>
          <td class="fw-bold">Product #<?= $po['product_id'] ?></td>
          <td><small><?= $po['available_from'] ? date('d M Y', strtotime($po['available_from'])) : 'TBD' ?></small></td>
          <td><?= $po['max_quantity'] ? number_format($po['max_quantity']) : 'Unlimited' ?></td>
          <td><?= $po['deposit_required'] > 0 ? '₹' . number_format($po['deposit_required'], 2) : 'Full Price' ?></td>
          <td><span class="badge badge-<?= $po['is_active'] ? 'success' : 'secondary' ?>"><?= $po['is_active'] ? 'Active' : 'Disabled' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/promotions/pre_orders') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="preorder_action" value="toggle">
              <input type="hidden" name="id" value="<?= $po['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $po['is_active'] ? 'warning' : 'success' ?>"><?= $po['is_active'] ? 'Disable' : 'Enable' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/promotions/pre_orders') ?>" class="d-inline" onsubmit="return confirm('Delete this pre-order campaign?')">
              <?= csrf_field() ?>
              <input type="hidden" name="preorder_action" value="delete">
              <input type="hidden" name="id" value="<?= $po['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($pre_orders)): ?><tr><td colspan="6" class="text-center text-muted py-5">No pre-order campaigns active.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="preOrderModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Pre-Order Campaign</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/promotions/pre_orders') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="preorder_action" value="create">
        <div class="modal-body">
          <div class="form-group">
            <label>Product *</label>
            <select name="product_id" class="form-control" required>
              <option value="">Select product...</option>
              <?php foreach ($products as $p): ?>
              <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['title']) ?> (₹<?= number_format($p['base_price'], 2) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row">
            <div class="col-6 form-group">
              <label>Expected Release Date</label>
              <input type="date" name="available_from" class="form-control" required>
            </div>
            <div class="col-6 form-group">
              <label>Max Pre-Order Units</label>
              <input type="number" min="1" name="max_quantity" class="form-control" placeholder="Optional cap">
            </div>
          </div>
          <div class="form-group">
            <label>Deposit Amount (₹, 0 for full price)</label>
            <input type="number" step="0.01" min="0" name="deposit_required" class="form-control" value="0">
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success">Start Pre-Orders</button></div>
      </form>
    </div>
  </div>
</div>
