<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0">📁 Product Categories</h2>
      <p class="text-muted mb-0">Organize store catalog hierarchy and collections</p>
    </div>
    <button class="btn btn-primary btn-sm px-4" data-toggle="modal" data-target="#catModal"><i class="fa fa-plus mr-1"></i> Add Category</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Category Name</th><th>Slug</th><th>Parent</th><th>Sort Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($categories as $cat):
          $parent_name = '— Top Level —';
          foreach ($categories as $c2) {
            if ($c2['id'] == $cat['parent_id']) { $parent_name = $c2['name']; break; }
          }
        ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($cat['name']) ?></td>
          <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
          <td><small class="text-muted"><?= htmlspecialchars($parent_name) ?></small></td>
          <td><?= $cat['sort_order'] ?? 0 ?></td>
          <td><span class="badge badge-<?= $cat['is_active'] ? 'success' : 'secondary' ?>"><?= $cat['is_active'] ? 'Active' : 'Disabled' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/products/categories') ?>" class="d-inline" onsubmit="return confirm('Delete this category?')">
              <?= csrf_field() ?>
              <input type="hidden" name="cat_action" value="delete">
              <input type="hidden" name="id" value="<?= $cat['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($categories)): ?><tr><td colspan="6" class="text-center text-muted py-5">No product categories created yet.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="catModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Category</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/products/categories') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="cat_action" value="save">
        <input type="hidden" name="id" value="0">
        <div class="modal-body">
          <div class="form-group"><label>Category Name *</label><input type="text" name="name" class="form-control" required placeholder="e.g. Smart Electronics"></div>
          <div class="form-group"><label>URL Slug (leave empty for auto)</label><input type="text" name="slug" class="form-control" placeholder="smart-electronics"></div>
          <div class="form-group">
            <label>Parent Category</label>
            <select name="parent_id" class="form-control">
              <option value="">— None (Top Level) —</option>
              <?php foreach ($categories as $c): ?>
              <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" class="form-control" value="0"></div>
          <div class="custom-control custom-switch mt-2">
            <input type="checkbox" class="custom-control-input" id="catActive" name="is_active" value="1" checked>
            <label class="custom-control-label" for="catActive">Active &amp; Visible</label>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save Category</button></div>
      </form>
    </div>
  </div>
</div>
