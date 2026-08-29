<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0">📦 Inventory Management</h2>
      <p class="text-muted mb-0">Adjust variant stock levels, update SKUs, and view low-stock alerts</p>
    </div>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <form method="post" action="<?= base_url('admin/products/stock') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="stock_action" value="bulk_update">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead><tr><th>Product Title</th><th>Variant Name</th><th>SKU</th><th>Current Stock</th><th>Update Stock Qty</th></tr></thead>
          <tbody>
          <?php foreach ($variants as $v):
            $is_low = ($v['inventory_qty'] ?? 0) <= $low_stock_threshold;
          ?>
          <tr class="<?= $is_low ? 'table-warning' : '' ?>">
            <td>
              <a href="<?= base_url('admin/products/edit/' . $v['product_id']) ?>" class="fw-bold text-decoration-none">
                <?= htmlspecialchars($v['product_title'] ?? ('Product #' . $v['product_id'])) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($v['title'] ?? 'Standard') ?></td>
            <td>
              <input type="text" name="variant[<?= $v['id'] ?>][sku]" class="form-control form-control-sm" value="<?= htmlspecialchars($v['sku'] ?? '') ?>" style="max-width:140px;">
            </td>
            <td>
              <?php if ($is_low): ?>
              <span class="text-danger fw-bold"><i class="fa fa-exclamation-triangle mr-1"></i> <?= $v['inventory_qty'] ?? 0 ?> (Low)</span>
              <?php else: ?>
              <span class="text-success font-weight-bold"><?= $v['inventory_qty'] ?? 0 ?> in stock</span>
              <?php endif; ?>
            </td>
            <td>
              <input type="number" min="0" name="variant[<?= $v['id'] ?>][qty]" class="form-control form-control-sm" value="<?= $v['inventory_qty'] ?? 0 ?>" style="max-width:100px;">
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($variants)): ?><tr><td colspan="5" class="text-center text-muted py-5">No product variants found in the database.</td></tr><?php endif; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer bg-white text-right">
        <button type="submit" class="btn btn-primary px-4"><i class="fa fa-save mr-1"></i> Save All Stock Updates</button>
      </div>
    </div>
  </form>
</div>
