<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Page Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h4 class="font-weight-bold mb-0 text-dark">📦 Inventory &amp; Stock Management</h4>
        <span class="badge badge-primary px-2 py-1" style="font-size:0.75rem;"><?= count($variants) ?> Variants</span>
      </div>
      <p class="text-muted small mb-0">Track real-time stock levels, supplier origin, SKUs, and auto-dispatch restock alerts.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Products Catalog
      </a>
      <a href="<?= base_url('admin/products/import') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-1"></i> Import / Restock
      </a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
      <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php endif; ?>

  <!-- Summary Metric Strip -->
  <?php 
    $low_count = count(array_filter($variants, fn($v) => ($v['inventory_qty'] ?? 0) <= $low_stock_threshold));
    $total_qty = array_sum(array_column($variants, 'inventory_qty'));
  ?>
  <div class="row g-2 mb-3">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Total Variant Units</div>
        <div class="h5 font-weight-bold text-dark mb-0"><?= number_format($total_qty) ?> <span class="small text-muted font-weight-normal">units</span></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Low Stock Warnings</div>
        <div class="h5 font-weight-bold text-danger mb-0"><?= $low_count ?> <span class="small font-weight-normal text-danger">need attention</span></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Catalog Variants</div>
        <div class="h5 font-weight-bold text-primary mb-0"><?= count($variants) ?> <span class="small text-muted font-weight-normal">SKUs</span></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Low Threshold</div>
        <div class="h5 font-weight-bold text-warning mb-0">&le; <?= $low_stock_threshold ?> <span class="small text-muted font-weight-normal">units</span></div>
      </div>
    </div>
  </div>

  <form method="post" action="<?= base_url('admin/products/stock') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="stock_action" value="bulk_update">

    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">
      <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
        <h6 class="font-weight-bold mb-0 text-dark">
          <i class="fas fa-boxes text-primary mr-2"></i> Real-Time Inventory Matrix
        </h6>
        <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm font-weight-bold">
          <i class="fas fa-save mr-1"></i> Save All Stock Updates
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
          <thead class="bg-light text-muted text-uppercase small font-weight-bold">
            <tr>
              <th style="min-width:200px;">Product &amp; Title</th>
              <th style="min-width:140px;">Vendor / Supplier</th>
              <th style="min-width:130px;">Category</th>
              <th style="min-width:130px;">Variant Option</th>
              <th style="min-width:140px;">SKU Identifier</th>
              <th style="min-width:120px;">Current Stock</th>
              <th style="min-width:130px;" class="text-right">Update Qty</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($variants as $v):
              $qty = (int)($v['inventory_qty'] ?? 0);
              $is_low = $qty <= $low_stock_threshold;
              $vendor = $v['product_vendor'] ?? 'NovaDrop Direct';
            ?>
            <tr class="<?= $is_low ? 'table-warning' : '' ?>">
              <!-- Product Title -->
              <td>
                <a href="<?= base_url('admin/products/edit/' . $v['product_id']) ?>" class="font-weight-bold text-dark text-decoration-none">
                  <?= htmlspecialchars($v['product_title'] ?? ('Product #' . $v['product_id'])) ?>
                </a>
                <div class="small text-muted">ID: #<?= $v['product_id'] ?></div>
              </td>

              <!-- Vendor / Supplier -->
              <td>
                <span class="badge badge-light border text-dark px-2 py-1" style="font-size:0.75rem;">
                  <i class="fas fa-warehouse text-muted mr-1"></i> <?= htmlspecialchars($vendor) ?>
                </span>
              </td>

              <!-- Category -->
              <td>
                <span class="badge badge-light border text-primary px-2 py-1" style="font-size:0.75rem;">
                  <?= htmlspecialchars($v['collection_title'] ?? 'General') ?>
                </span>
              </td>

              <!-- Variant Name -->
              <td>
                <span class="font-weight-semibold text-secondary">
                  <?= htmlspecialchars($v['title'] ?? 'Standard') ?>
                </span>
              </td>

              <!-- SKU -->
              <td>
                <input type="text" name="variant[<?= $v['id'] ?>][sku]" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars($v['sku'] ?? '') ?>" style="max-width:150px; height:36px;">
              </td>

              <!-- Current Stock Status -->
              <td>
                <?php if ($qty <= 0): ?>
                  <span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Out of Stock (0)</span>
                <?php elseif ($is_low): ?>
                  <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-exclamation-triangle mr-1"></i> <?= $qty ?> (Low Stock)</span>
                <?php else: ?>
                  <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> <?= $qty ?> in stock</span>
                <?php endif; ?>
              </td>

              <!-- Update Stock Input -->
              <td class="text-right">
                <input type="number" min="0" name="variant[<?= $v['id'] ?>][qty]" class="form-control form-control-sm text-right d-inline-block font-weight-bold" value="<?= $qty ?>" style="max-width:100px; height:36px;">
              </td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($variants)): ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-5">
                  <i class="fas fa-box-open fa-2x mb-2 d-block text-muted opacity-50"></i>
                  No product variants found in the database.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer bg-white border-top py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
        <span class="text-muted small">Showing <?= count($variants) ?> variant SKUs across all supplier lines</span>
        <button type="submit" class="btn btn-primary px-4 shadow-sm font-weight-bold">
          <i class="fas fa-save mr-1"></i> Save All Stock Updates
        </button>
      </div>
    </div>
  </form>
</div>
