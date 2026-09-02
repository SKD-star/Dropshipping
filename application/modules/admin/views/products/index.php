<!-- Catalog Executive Overview Strip -->
<div class="row g-3 mb-3 mb-md-4">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small font-weight-bold">Total Catalog</span>
          <h4 class="font-weight-bold mb-0 text-dark mt-1"><?= number_format($total_count) ?></h4>
        </div>
        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(99, 102, 241, 0.1); display: flex; align-items: center; justify-content: center; color: #6366f1; font-size: 18px;">
          <i class="fas fa-boxes"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small font-weight-bold">Active Storefront</span>
          <h4 class="font-weight-bold mb-0 text-success mt-1"><?= number_format($active_count) ?></h4>
        </div>
        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 18px;">
          <i class="fas fa-check-circle"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small font-weight-bold">Low / Out of Stock</span>
          <h4 class="font-weight-bold mb-0 text-amber-600 mt-1"><?= number_format($low_stock_count) ?></h4>
        </div>
        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(245, 158, 11, 0.1); display: flex; align-items: center; justify-content: center; color: #f59e0b; font-size: 18px;">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm p-3 h-100" style="border-radius: 12px;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small font-weight-bold">Inventory Value</span>
          <h4 class="font-weight-bold mb-0 text-primary mt-1">₹ <?= number_format($total_inventory_val, 2) ?></h4>
        </div>
        <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 18px;">
          <i class="fas fa-coins"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Header & Fast Actions -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
  <div>
    <h4 class="font-weight-bold mb-0 text-dark" style="letter-spacing: -0.02em;">Products &amp; Inventory Management</h4>
    <p class="text-muted small mb-0">Manage multi-variant apparel catalog, live pricing, stock levels, categories and merchandising.</p>
  </div>
  <div class="d-flex flex-wrap gap-2 align-items-center">
    <a href="<?= base_url('admin/products/categories') ?>" class="btn btn-sm btn-outline-info px-3 font-weight-bold" style="border-radius: 8px;">
      <i class="fas fa-folder-open mr-1"></i> Manage Categories
    </a>
    <a href="<?= base_url('admin/products/export_csv') ?>" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px;" title="Export CSV">
      <i class="fas fa-file-csv mr-1"></i> Export CSV
    </a>
    <a href="<?= base_url('admin/products/import') ?>" class="btn btn-sm btn-outline-primary px-3 font-weight-bold" style="border-radius: 8px;">
      <i class="fas fa-cloud-upload-alt mr-1"></i> Import / Supplier
    </a>
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-sm btn-primary px-3 shadow-sm font-weight-bold" style="border-radius: 8px;">
      <i class="fas fa-plus mr-1"></i> Add Product
    </a>
  </div>
</div>

<!-- Flash Notifications -->
<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" style="border-radius: 8px;">
    <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" style="border-radius: 8px;">
    <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($this->session->flashdata('error')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php endif; ?>

<!-- 🔍 Multi-Filter & Search Bar -->
<div class="card border-0 shadow-sm mb-3" style="border-radius: 12px;">
  <div class="card-body p-3">
    <form method="GET" action="<?= base_url('admin/products') ?>" class="row g-2 align-items-center">
      <div class="col-12 col-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
          </div>
          <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search title, SKU, vendor..." class="form-control border-left-0" style="height: 40px;">
        </div>
      </div>
      <div class="col-6 col-md-2">
        <select name="status" class="form-control" style="height: 40px;" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Active Only</option>
          <option value="draft" <?= ($status ?? '') === 'draft' ? 'selected' : '' ?>>Draft Only</option>
          <option value="archived" <?= ($status ?? '') === 'archived' ? 'selected' : '' ?>>Archived Only</option>
        </select>
      </div>
      <div class="col-6 col-md-2">
        <select name="collection_id" class="form-control" style="height: 40px;" onchange="this.form.submit()">
          <option value="">All Categories / Collections</option>
          <?php foreach ($collections as $c): ?>
          <option value="<?= $c['id'] ?>" <?= ($collection_id ?? '') == $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['title'] ?? ($c['name'] ?? 'Collection')) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-6 col-md-2">
        <select name="stock" class="form-control" style="height: 40px;" onchange="this.form.submit()">
          <option value="">Stock Status</option>
          <option value="in_stock" <?= ($stock_filter ?? '') === 'in_stock' ? 'selected' : '' ?>>In Stock</option>
          <option value="low_stock" <?= ($stock_filter ?? '') === 'low_stock' ? 'selected' : '' ?>>Low Stock (&le; 10)</option>
          <option value="out_of_stock" <?= ($stock_filter ?? '') === 'out_of_stock' ? 'selected' : '' ?>>Out of Stock</option>
        </select>
      </div>
      <div class="col-6 col-md-2">
        <select name="sort" class="form-control" style="height: 40px;" onchange="this.form.submit()">
          <option value="newest" <?= ($sort ?? '') === 'newest' ? 'selected' : '' ?>>Sort: Newest</option>
          <option value="price_asc" <?= ($sort ?? '') === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
          <option value="price_desc" <?= ($sort ?? '') === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
          <option value="title_asc" <?= ($sort ?? '') === 'title_asc' ? 'selected' : '' ?>>Title: A to Z</option>
          <option value="oldest" <?= ($sort ?? '') === 'oldest' ? 'selected' : '' ?>>Sort: Oldest</option>
        </select>
      </div>
      <div class="col-12 col-md-1 d-flex gap-1">
        <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="height: 40px; border-radius: 8px;">Filter</button>
        <?php if (!empty($search) || !empty($status) || !empty($collection_id) || !empty($stock_filter)): ?>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="height: 40px; width: 40px; border-radius: 8px;" title="Reset Filters"><i class="fas fa-times"></i></a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<!-- Bulk Selection Floating Bar -->
<form method="POST" action="<?= base_url('admin/products/bulk_action') ?>" id="bulkActionForm">
  <?= csrf_field() ?>
  <div id="bulkActionBar" class="bulk-action-floating" style="display: none;">
    <div class="d-flex align-items-center gap-2">
      <span class="badge badge-light text-dark font-weight-bold px-2 py-1" id="bulkSelectedCount">0 selected</span>
      <span class="small opacity-90">Bulk Batch Actions:</span>
    </div>
    <div class="d-flex gap-2">
      <button type="submit" name="bulk_action" value="activate" class="btn btn-sm btn-success px-2 py-1 font-weight-bold" style="font-size:0.75rem;">
        <i class="fas fa-check mr-1"></i> Make Active
      </button>
      <button type="submit" name="bulk_action" value="draft" class="btn btn-sm btn-warning px-2 py-1 font-weight-bold text-dark" style="font-size:0.75rem;">
        <i class="fas fa-pause mr-1"></i> Set Draft
      </button>
      <button type="submit" name="bulk_action" value="archive" class="btn btn-sm btn-secondary px-2 py-1 font-weight-bold" style="font-size:0.75rem;">
        <i class="fas fa-archive mr-1"></i> Archive
      </button>
      <button type="submit" name="bulk_action" value="delete" class="btn btn-sm btn-danger px-2 py-1 font-weight-bold" style="font-size:0.75rem;" onclick="return confirm('Permanently delete all selected products?')">
        <i class="fas fa-trash mr-1"></i> Delete
      </button>
    </div>
  </div>

  <!-- 🛍️ Advanced Products Catalog Table -->
  <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-th-list text-primary mr-2"></i> Catalog Items</h6>
        <span class="badge badge-light border text-muted px-2 py-1" style="font-size:0.75rem;"><?= count($products) ?> items listed</span>
      </div>
      <div class="small text-muted">
        Showing all active &amp; draft SKUs
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 usr-table">
          <thead style="background: #f8fafc; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.04em; color: #64748b;">
            <tr>
              <th style="width: 40px;" class="text-center">
                <input type="checkbox" id="selectAllProducts" onchange="toggleSelectAllProducts(this)">
              </th>
              <th style="width: 60px;">ID</th>
              <th style="min-width: 240px;">Product &amp; Visual</th>
              <th style="min-width: 140px;">Category / Collection</th>
              <th>Vendor / Brand</th>
              <th>Status</th>
              <th>Stock &amp; Variants</th>
              <th>Pricing</th>
              <th style="text-align: right; min-width: 150px;">Actions</th>
            </tr>
          </thead>
          <tbody style="font-size: 0.88rem;">
            <?php if (empty($products)): ?>
            <tr>
              <td colspan="9" class="text-center py-5 text-muted">
                <div style="font-size: 40px;" class="mb-2">📦</div>
                <div class="font-weight-bold text-dark">No products found</div>
                <div class="small text-muted mt-1">Try adjusting your filters or click "+ Add Product" to add items to your catalog.</div>
              </td>
            </tr>
            <?php else: ?>
              <?php foreach ($products as $p): ?>
              <tr>
                <!-- Checkbox -->
                <td class="text-center align-middle">
                  <input type="checkbox" name="selected_ids[]" value="<?= $p['id'] ?>" class="product-item-checkbox" onchange="handleProductCheckboxChange()">
                </td>

                <!-- ID -->
                <td class="align-middle text-muted font-weight-bold" style="font-size: 0.8rem;">
                  #<?= $p['id'] ?>
                </td>

                <!-- Product Thumbnail Image on Left + Title -->
                <td class="align-middle">
                  <div class="d-flex align-items-center gap-3">
                    <div class="prod-thumb-box shadow-xs" title="Click to edit product">
                      <?php if (!empty($p['primary_image'])): ?>
                        <img src="<?= htmlspecialchars($p['primary_image']) ?>" class="prod-thumb-img" alt="<?= htmlspecialchars($p['title']) ?>" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'prod-placeholder-icon\'>👕</div>';">
                      <?php else: ?>
                        <div class="prod-placeholder-icon">👕</div>
                      <?php endif; ?>
                    </div>
                    <div>
                      <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>" class="font-weight-bold text-dark text-decoration-none" style="font-size: 0.92rem;">
                        <?= htmlspecialchars($p['title']) ?>
                      </a>
                      <div class="d-flex align-items-center gap-1.5 flex-wrap mt-0.5">
                        <span class="text-muted small" style="font-family: monospace; font-size: 0.72rem;"><?= htmlspecialchars($p['slug']) ?></span>
                        <?php if (!empty($p['is_featured'])): ?>
                          <span class="badge badge-warning text-dark px-1.5 py-0.5 font-weight-bold" style="font-size: 0.68rem;">⭐ Featured</span>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </td>

                <!-- Dedicated Category / Collection Column -->
                <td class="align-middle">
                  <?php if (!empty($p['collection_title'])): ?>
                    <span class="badge badge-light border text-primary px-2 py-1" style="font-size: 0.76rem; font-weight: 600; border-radius: 6px;">
                      <i class="fas fa-folder text-muted mr-1"></i> <?= htmlspecialchars($p['collection_title']) ?>
                    </span>
                  <?php else: ?>
                    <span class="text-muted small italic">Unassigned</span>
                  <?php endif; ?>
                </td>

                <!-- Vendor -->
                <td class="align-middle">
                  <span class="text-dark font-weight-500"><?= htmlspecialchars($p['vendor'] ?: 'NovaDrop') ?></span>
                </td>

                <!-- Status Pill with 1-Click Toggle -->
                <td class="align-middle">
                  <a href="<?= base_url('admin/products/toggle_status/' . $p['id']) ?>" title="Click to toggle status" class="badge badge-<?= ($p['status'] === 'active') ? 'success' : (($p['status'] === 'archived') ? 'secondary' : 'warning') ?> px-2.5 py-1 text-decoration-none font-weight-bold" style="font-size: 0.75rem; border-radius: 6px;">
                    <?= ucfirst($p['status']) ?> ⇄
                  </a>
                </td>

                <!-- Stock & Variants -->
                <td class="align-middle">
                  <div class="d-flex align-items-center">
                    <span class="stock-indicator-dot <?= ($p['total_stock'] > 10) ? 'stock-dot-green' : (($p['total_stock'] > 0) ? 'stock-dot-amber' : 'stock-dot-red') ?>"></span>
                    <span class="font-weight-bold text-dark" style="font-size: 0.85rem;">
                      <?= number_format($p['total_stock']) ?> in stock
                    </span>
                  </div>
                  <div class="text-muted" style="font-size: 0.72rem;">
                    <?= $p['variant_count'] ?> variant<?= $p['variant_count'] > 1 ? 's' : '' ?>
                  </div>
                </td>

                <!-- Pricing & Reward Points -->
                <td class="align-middle">
                  <div class="font-weight-bold text-dark" style="font-size: 0.95rem;">
                    ₹ <?= number_format($p['base_price'], 2) ?>
                  </div>
                  <?php if (!empty($p['compare_at_price']) && $p['compare_at_price'] > $p['base_price']): ?>
                    <div class="text-muted small" style="text-decoration: line-through; font-size: 0.72rem;">
                      ₹ <?= number_format($p['compare_at_price'], 2) ?>
                    </div>
                  <?php endif; ?>
                  <?php 
                    $pts_val = !empty($p['reward_points']) ? (int)$p['reward_points'] : max(1, round(($p['base_price'] ?? 0) * 0.06));
                  ?>
                  <div class="mt-1">
                    <span class="badge badge-warning text-dark font-weight-bold" style="font-size: 0.7rem; background: #fef08a; border: 1px solid #fde047;" title="Shopper earns <?= $pts_val ?> Atelier Points (₹<?= $pts_val ?> cashback value)">
                      🪙 +<?= number_format($pts_val) ?> pts
                    </span>
                  </div>
                </td>

                <!-- Actions -->
                <td class="align-middle" style="text-align: right; white-space: nowrap;">
                  <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary mr-1" title="Edit Product Studio" style="border-radius: 6px;">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="<?= base_url('product/' . $p['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info mr-1" title="Live Storefront Preview" style="border-radius: 6px;">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= base_url('admin/products/duplicate/' . $p['id']) ?>" class="btn btn-sm btn-outline-secondary mr-1" title="Clone / Duplicate" style="border-radius: 6px;">
                    <i class="fas fa-clone"></i>
                  </a>
                  <a href="<?= base_url('admin/products/delete/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Permanently delete this product and all associated variants?')" title="Delete Product" style="border-radius: 6px;">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</form>

<!-- JS for Bulk Checkboxes -->
<script>
function toggleSelectAllProducts(master) {
  var checkboxes = document.querySelectorAll('.product-item-checkbox');
  checkboxes.forEach(function(cb) {
    cb.checked = master.checked;
  });
  handleProductCheckboxChange();
}

function handleProductCheckboxChange() {
  var checkedBoxes = document.querySelectorAll('.product-item-checkbox:checked');
  var bar = document.getElementById('bulkActionBar');
  var countEl = document.getElementById('bulkSelectedCount');
  
  if (checkedBoxes.length > 0) {
    bar.style.display = 'flex';
    countEl.innerText = checkedBoxes.length + ' selected';
  } else {
    bar.style.display = 'none';
    var master = document.getElementById('selectAllProducts');
    if (master) master.checked = false;
  }
}
</script>
