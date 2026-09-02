<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Page Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h4 class="font-weight-bold mb-0 text-dark">📁 Product Categories &amp; Taxonomy</h4>
        <span class="badge badge-primary px-2 py-1" style="font-size:0.75rem;"><?= count($categories) ?> Categories</span>
      </div>
      <p class="text-muted small mb-0">Organize store collections, navigation menus, and category visual banner cards.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Products Catalog
      </a>
      <button class="btn btn-primary btn-sm px-3 font-weight-bold shadow-sm" data-toggle="modal" data-target="#catModal">
        <i class="fas fa-plus mr-1"></i> Add Category
      </button>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
      <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
        <thead class="bg-light text-muted text-uppercase small font-weight-bold">
          <tr>
            <th style="width:70px;">Media</th>
            <th style="min-width:180px;">Category Name</th>
            <th style="min-width:160px;">URL Slug</th>
            <th style="min-width:140px;">Parent Level</th>
            <th style="min-width:90px;">Sort</th>
            <th style="min-width:110px;">Status</th>
            <th style="min-width:110px;" class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $cat):
            $parent_name = '— Top Level —';
            foreach ($categories as $c2) {
              if ($c2['id'] == ($cat['parent_id'] ?? 0)) { $parent_name = $c2['name']; break; }
            }
            $cat_img = $cat['image_url'] ?? ($cat['image'] ?? '');
          ?>
          <tr>
            <!-- Category Image Thumbnail -->
            <td>
              <div style="width:44px; height:44px; border-radius:8px; overflow:hidden; background:#f1f5f9; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:center;">
                <?php if (!empty($cat_img)): ?>
                  <img src="<?= htmlspecialchars($cat_img) ?>" style="width:100%; height:100%; object-fit:cover;" onerror="this.parentElement.innerHTML='📁'" alt="">
                <?php else: ?>
                  <span style="font-size:1.2rem;">📁</span>
                <?php endif; ?>
              </div>
            </td>

            <!-- Category Name -->
            <td>
              <strong class="text-dark font-weight-bold d-block"><?= htmlspecialchars($cat['name']) ?></strong>
              <small class="text-muted">ID: #<?= $cat['id'] ?></small>
            </td>

            <!-- Slug -->
            <td>
              <code class="text-primary font-weight-bold">/collection/<?= htmlspecialchars($cat['slug']) ?></code>
            </td>

            <!-- Parent -->
            <td>
              <span class="badge badge-light border text-secondary px-2 py-1">
                <?= htmlspecialchars($parent_name) ?>
              </span>
            </td>

            <!-- Sort Order -->
            <td>
              <span class="font-weight-bold text-muted"><?= (int)($cat['sort_order'] ?? 0) ?></span>
            </td>

            <!-- Status -->
            <td>
              <span class="badge badge-<?= !empty($cat['is_active']) ? 'success' : 'secondary' ?> px-2 py-1">
                <?= !empty($cat['is_active']) ? '🟢 Active' : '⚪ Disabled' ?>
              </span>
            </td>

            <!-- Actions -->
            <td class="text-right">
              <form method="post" action="<?= base_url('admin/products/categories') ?>" class="d-inline" onsubmit="return confirm('Delete category \'<?= addslashes($cat['name']) ?>\'?')">
                <?= csrf_field() ?>
                <input type="hidden" name="cat_action" value="delete">
                <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" title="Delete Category">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>

          <?php if (empty($categories)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-5">
                <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                No categories created yet. Click <strong>Add Category</strong> to create one.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal: New Category with Image Upload & Live UI Preview -->
<div class="modal fade" id="catModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
      <div class="modal-header bg-dark text-white py-3 px-4">
        <h5 class="modal-title font-weight-bold mb-0">
          <i class="fas fa-folder-plus text-warning mr-2"></i> New Product Category
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" action="<?= base_url('admin/products/categories') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="cat_action" value="save">
        <input type="hidden" name="id" value="0">

        <div class="modal-body p-4">
          <div class="row">
            <!-- Left Inputs -->
            <div class="col-md-7">
              <div class="form-group mb-3">
                <label class="font-weight-bold text-dark small">Category Name *</label>
                <input type="text" id="catNameInput" name="name" class="form-control font-weight-bold" required placeholder="e.g. Okayama Selvedge Denim" oninput="updateCatPreview()">
              </div>

              <div class="form-group mb-3">
                <label class="font-weight-bold text-dark small">URL Slug</label>
                <input type="text" id="catSlugInput" name="slug" class="form-control" placeholder="okayama-selvedge-denim" oninput="updateCatPreview()">
                <small class="text-muted">Will be used in storefront URLs: <code>/collection/[slug]</code></small>
              </div>

              <div class="form-group mb-3">
                <label class="font-weight-bold text-dark small">Parent Category</label>
                <select name="parent_id" class="form-control" style="height:42px;">
                  <option value="">— None (Top Level Main Category) —</option>
                  <?php foreach ($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Upload Category Image Option -->
              <div class="form-group mb-3">
                <label class="font-weight-bold text-dark small">
                  <i class="fas fa-image text-primary mr-1"></i> Upload Category Banner / Cover
                </label>
                <input type="file" name="image" id="catFileInput" class="form-control-file border rounded p-1.5 w-100" accept="image/*" onchange="previewCatFile(this)">
                <small class="text-muted">PNG, JPG, WEBP banner image for storefront showcase</small>
              </div>

              <div class="form-group mb-3">
                <label class="font-weight-bold text-dark small">Or Paste Direct Image URL</label>
                <input type="url" id="catImageUrlInput" name="image_url" class="form-control form-control-sm" placeholder="https://images.unsplash.com/..." oninput="updateCatPreview()">
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-0">
                    <label class="font-weight-bold text-dark small">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control form-control-sm" value="0">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-0 pt-4">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="catActive" name="is_active" value="1" checked onchange="updateCatPreview()">
                      <label class="custom-control-label font-weight-bold text-dark small" for="catActive">Active &amp; Visible</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right Live UI Preview Box -->
            <div class="col-md-5 mt-4 mt-md-0">
              <label class="font-weight-bold text-dark small mb-2 d-block">
                <i class="fas fa-eye text-success mr-1"></i> Live Storefront UI Preview
              </label>
              
              <div class="border rounded p-3" style="background:#f8fafc;">
                <!-- Category Card Preview -->
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:10px; background:#ffffff;">
                  <div style="height:140px; background:#1e293b; position:relative; overflow:hidden;">
                    <img id="catPreviewImg" src="https://images.unsplash.com/photo-1542272604-780c96856592?w=600&auto=format&fit=crop&q=80" style="width:100%; height:100%; object-fit:cover; opacity:0.85;" alt="Preview">
                    <div class="position-absolute" style="top:10px; right:10px;">
                      <span id="catPreviewStatus" class="badge badge-success">🟢 Active</span>
                    </div>
                    <div class="position-absolute" style="bottom:10px; left:12px; right:12px;">
                      <span class="badge badge-dark bg-dark-50 text-white-50 px-2 py-0.5" style="font-size:0.65rem;">Collection</span>
                      <h6 class="font-weight-bold text-white mb-0" id="catPreviewTitle">Okayama Selvedge Denim</h6>
                    </div>
                  </div>
                  <div class="p-2.5 bg-white border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted small" id="catPreviewSlug" style="font-size:0.75rem;">/collection/okayama-selvedge</span>
                    <span class="badge badge-light border text-primary" style="font-size:0.7rem;">Browse &rarr;</span>
                  </div>
                </div>

                <div class="mt-2 text-center text-muted small" style="font-size:0.75rem;">
                  This is how the category visual tile and title appear across the storefront catalog navigation.
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light py-3 px-4">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">
            <i class="fas fa-save mr-1"></i> Save Category
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function updateCatPreview() {
  var name = document.getElementById('catNameInput').value.trim() || 'New Category Title';
  var slug = document.getElementById('catSlugInput').value.trim();
  if (!slug) {
    slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
  }
  var imgUrl = document.getElementById('catImageUrlInput').value.trim();
  var isActive = document.getElementById('catActive').checked;

  document.getElementById('catPreviewTitle').innerText = name;
  document.getElementById('catPreviewSlug').innerText = '/collection/' + (slug || 'category-slug');
  document.getElementById('catPreviewStatus').innerText = isActive ? '🟢 Active' : '⚪ Disabled';
  document.getElementById('catPreviewStatus').className = 'badge ' + (isActive ? 'badge-success' : 'badge-secondary');

  if (imgUrl) {
    document.getElementById('catPreviewImg').src = imgUrl;
  }
}

function previewCatFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('catPreviewImg').src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
