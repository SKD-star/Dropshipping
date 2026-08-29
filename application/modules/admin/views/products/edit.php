<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Edit Product: <?= htmlspecialchars($product['title'] ?? '') ?></h2>
    <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary btn-sm">← Back to Products</a>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <form method="post" action="<?= base_url('admin/products/edit/' . $product['id']) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row">
      <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white fw-bold">Product Information</div>
          <div class="card-body">
            <div class="form-group">
              <label>Title *</label>
              <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($product['title'] ?? '') ?>" required>
            </div>
            <div class="form-group">
              <label>Description</label>
              <textarea name="description" class="form-control" rows="6"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>
            <div class="row">
              <div class="col-6 form-group">
                <label>Base Price (₹) *</label>
                <input type="number" step="0.01" name="base_price" class="form-control" value="<?= $product['base_price'] ?? 0 ?>" required>
              </div>
              <div class="col-6 form-group">
                <label>Compare-at / Strike Price (₹)</label>
                <input type="number" step="0.01" name="compare_at_price" class="form-control" value="<?= $product['compare_at_price'] ?? 0 ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-6 form-group">
                <label>Vendor</label>
                <input type="text" name="vendor" class="form-control" value="<?= htmlspecialchars($product['vendor'] ?? 'NovaDrop') ?>">
              </div>
              <div class="col-6 form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="active" <?= ($product['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                  <option value="draft" <?= ($product['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                  <option value="archived" <?= ($product['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Collection / Category</label>
              <select name="collection_id" class="form-control">
                <option value="">— Uncategorized —</option>
                <?php foreach ($collections as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($product['collection_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['name'] ?? '') ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="custom-control custom-switch mt-2">
              <input type="checkbox" class="custom-control-input" id="featCheck" name="is_featured" value="1" <?= !empty($product['is_featured']) ? 'checked' : '' ?>>
              <label class="custom-control-label" for="featCheck">Featured on Homepage</label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white fw-bold">Images &amp; Media</div>
          <div class="card-body">
            <?php if (!empty($images)): ?>
            <div class="d-flex flex-wrap gap-2 mb-3">
              <?php foreach ($images as $img): ?>
              <div class="position-relative border rounded p-1" style="width:72px;height:72px;">
                <img src="<?= htmlspecialchars($img['url']) ?>" style="width:100%;height:100%;object-fit:cover;border-radius:4px;" alt="">
                <?php if (!empty($img['is_primary'])): ?>
                <span class="badge badge-primary position-absolute" style="top:2px;left:2px;font-size:0.6rem;">Cover</span>
                <?php endif; ?>
              </div>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="form-group mb-0">
              <label class="small">Upload New Cover Image</label>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
            <span>Inventory / Variants</span>
            <a href="<?= base_url('admin/products/stock') ?>" class="btn btn-sm btn-link p-0 text-primary">Manage Stock</a>
          </div>
          <div class="card-body p-0">
            <table class="table table-sm mb-0">
              <thead><tr><th>SKU</th><th>Title</th><th>Qty</th></tr></thead>
              <tbody>
              <?php foreach ($variants as $v): ?>
              <tr>
                <td><code><?= htmlspecialchars($v['sku'] ?? '—') ?></code></td>
                <td><?= htmlspecialchars($v['title'] ?? 'Standard') ?></td>
                <td><strong class="<?= ($v['inventory_qty'] ?? 0) <= 5 ? 'text-danger' : 'text-success' ?>"><?= $v['inventory_qty'] ?? 0 ?></strong></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <button type="submit" class="btn btn-success btn-block py-2 fw-bold"><i class="fa fa-save mr-1"></i> Save Changes</button>
        <a href="<?= base_url('admin/products/delete/' . $product['id']) ?>" class="btn btn-outline-danger btn-block btn-sm mt-2" onclick="return confirm('Permanently delete this product and its variants?')"><i class="fa fa-trash mr-1"></i> Delete Product</a>
      </div>
    </div>
  </form>
</div>
