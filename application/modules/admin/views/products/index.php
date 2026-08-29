<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <form method="GET" action="<?= base_url('admin/products') ?>" class="d-flex gap-2 align-items-center flex-wrap">
    <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search title or vendor..." class="form-control" style="width:240px">
    <select name="status" class="form-control" style="width:130px" onchange="this.form.submit()">
      <option value="">All Status</option>
      <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
      <option value="draft" <?= ($status ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
      <option value="archived" <?= ($status ?? '') === 'archived' ? 'selected' : '' ?>>Archived</option>
    </select>
    <select name="collection_id" class="form-control" style="width:160px" onchange="this.form.submit()">
      <option value="">All Collections</option>
      <?php foreach ($collections as $c): ?>
      <option value="<?= $c['id'] ?>" <?= ($collection_id ?? '') == $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['title']) ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-outline-primary">Filter</button>
  </form>
  <div>
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-primary">
      <i class="fa fa-plus-circle mr-1"></i> + Add Product
    </a>
  </div>
</div>

<div class="card shadow">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>🛍️ Products Catalog</span>
    <span class="small text-white-50">Showing <?= count($products) ?> products</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover usr-table mb-0">
        <thead>
          <tr>
            <th style="width: 50px;">ID</th>
            <th>Product Title</th>
            <th>Vendor</th>
            <th>Status</th>
            <th>Price</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($products)): ?>
            <tr><td colspan="6" class="text-center py-5 text-muted">No products found. Click "+ Add Product" to add items to your catalog.</td></tr>
          <?php else: ?>
            <?php foreach ($products as $p): ?>
            <tr>
              <td><?= $p['id'] ?></td>
              <td>
                <strong><?= htmlspecialchars($p['title']) ?></strong>
                <div class="small text-muted"><?= htmlspecialchars($p['slug']) ?></div>
              </td>
              <td><?= htmlspecialchars($p['vendor'] ?: 'NovaDrop') ?></td>
              <td>
                <span class="badge <?= $p['status'] === 'active' ? 'badge-success' : 'badge-warning' ?>">
                  <?= ucfirst($p['status']) ?>
                </span>
              </td>
              <td><strong>₹<?= number_format($p['base_price'], 2) ?></strong></td>
              <td style="text-align: right;">
                <a href="<?= base_url('product/' . $p['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-info mr-1" title="View Storefront">
                  <i class="fa fa-eye"></i>
                </a>
                <a href="<?= base_url('admin/products/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete Product">
                  <i class="fa fa-trash"></i>
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
