<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#4e73df;">🚀 Universal Dropshipping Supplier Pusher</h2>
      <p class="text-muted mb-0">Push verified inventory from Alibaba, CJ Dropshipping &amp; AliExpress directly into your live store with 1-click</p>
    </div>
    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#csvModal"><i class="fa fa-file-csv mr-1"></i> Batch CSV Import</button>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('error')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <h5 class="fw-bold mb-3"><i class="fa fa-star text-warning mr-2"></i>Curated Verified Supplier Drops (Ready to Sell)</h5>
  <div class="row g-3 mb-5">
    <?php foreach ($verified_supplier_catalog as $idx => $sup): ?>
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="position-relative">
          <img src="<?= htmlspecialchars($sup['image_url']) ?>" class="card-img-top" style="height:200px;object-fit:cover;" onerror="this.src='<?= base_url('img/placeholder.jpg') ?>'" alt="">
          <span class="badge badge-success position-absolute" style="top:10px;left:10px;"><?= $sup['badge'] ?></span>
          <span class="badge badge-dark position-absolute" style="top:10px;right:10px;"><?= $sup['rating'] ?> (<?= number_format($sup['orders_count']) ?> sold)</span>
        </div>
        <div class="card-body d-flex flex-column">
          <div class="small text-muted mb-1"><i class="fa fa-warehouse mr-1"></i> <?= htmlspecialchars($sup['supplier_name']) ?></div>
          <h6 class="fw-bold mb-2"><?= htmlspecialchars($sup['title']) ?></h6>
          <p class="text-muted small flex-fill"><?= htmlspecialchars($sup['description']) ?></p>
          
          <div class="bg-light p-2 rounded mb-3">
            <div class="d-flex justify-content-between small">
              <span>Supplier Cost:</span>
              <strong class="text-muted">₹<?= number_format($sup['supplier_cost'], 2) ?></strong>
            </div>
            <div class="d-flex justify-content-between small">
              <span>Retail Price (<?= $sup['markup'] ?>x):</span>
              <strong class="text-success">₹<?= number_format($sup['selling_price'], 2) ?></strong>
            </div>
            <div class="d-flex justify-content-between small">
              <span>Estimated Margin:</span>
              <strong class="text-primary">₹<?= number_format($sup['selling_price'] - $sup['supplier_cost'], 2) ?> profit</strong>
            </div>
          </div>

          <form method="post" action="<?= base_url('admin/products/import') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="importer_action" value="push_supplier_product">
            <input type="hidden" name="title" value="<?= htmlspecialchars($sup['title']) ?>">
            <input type="hidden" name="supplier_name" value="<?= htmlspecialchars($sup['supplier_name']) ?>">
            <input type="hidden" name="supplier_cost" value="<?= $sup['supplier_cost'] ?>">
            <input type="hidden" name="selling_price" value="<?= $sup['selling_price'] ?>">
            <input type="hidden" name="compare_at_price" value="<?= $sup['compare_price'] ?>">
            <input type="hidden" name="description" value="<?= htmlspecialchars($sup['description']) ?>">
            <input type="hidden" name="image_url" value="<?= htmlspecialchars($sup['image_url']) ?>">
            <button type="submit" class="btn btn-primary btn-block fw-bold shadow-sm">
              <i class="fa fa-cloud-upload-alt mr-1"></i> Push 1-Click to Store
            </button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="card border-0 shadow-sm bg-light">
    <div class="card-body p-4">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h5 class="fw-bold mb-1"><i class="fa fa-link text-primary mr-2"></i>Import Custom Product by Supplier URL</h5>
          <p class="text-muted small mb-0">Paste any AliExpress, CJ Dropshipping, or Alibaba product URL to auto-extract details, compute margins, and push to catalog.</p>
        </div>
        <div class="col-md-4 text-md-right mt-3 mt-md-0">
          <button class="btn btn-success font-weight-bold" data-toggle="modal" data-target="#customUrlModal">
            <i class="fa fa-plus-circle mr-1"></i> Paste Supplier URL
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Custom URL Import -->
<div class="modal fade" id="customUrlModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Push Custom Supplier Product</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/products/import') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="importer_action" value="push_supplier_product">
        <div class="modal-body">
          <div class="form-group">
            <label>Product Title *</label>
            <input type="text" name="title" class="form-control" required placeholder="e.g. Ergonomic Lumbar Support Memory Pillow">
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label>Supplier / Vendor Name</label>
              <input type="text" name="supplier_name" class="form-control" value="CJ Dropshipping Direct">
            </div>
            <div class="col-md-6 form-group">
              <label>Category</label>
              <select name="collection_id" class="form-control">
                <option value="">— Select Category —</option>
                <?php foreach ($collections as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 form-group">
              <label>Supplier Cost (₹) *</label>
              <input type="number" step="0.01" min="1" id="sup_cost" name="supplier_cost" class="form-control" value="450" required oninput="calcPrice()">
            </div>
            <div class="col-md-4 form-group">
              <label>Markup Multiplier</label>
              <input type="number" step="0.1" min="1" id="sup_mult" name="markup_multiplier" class="form-control" value="2.8" oninput="calcPrice()">
            </div>
            <div class="col-md-4 form-group">
              <label>Store Retail Price (₹) *</label>
              <input type="number" step="0.01" min="1" id="sup_price" name="selling_price" class="form-control" value="1260" required>
            </div>
          </div>
          <div class="form-group">
            <label>Image URL</label>
            <input type="url" name="image_url" class="form-control" placeholder="https://...">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="High-density memory foam with breathable cover..."></textarea>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Publish to Catalog</button></div>
      </form>
    </div>
  </div>
</div>

<!-- Modal CSV -->
<div class="modal fade" id="csvModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Bulk CSV Import</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/products/import') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="importer_action" value="csv_import">
        <div class="modal-body">
          <div class="form-group">
            <label>Select CSV File</label>
            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
            <small class="text-muted">Columns required: <code>title, price, stock, vendor, description</code></small>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Import CSV</button></div>
      </form>
    </div>
  </div>
</div>

<script>
function calcPrice() {
  var cost = parseFloat(document.getElementById('sup_cost').value) || 0;
  var mult = parseFloat(document.getElementById('sup_mult').value) || 2.8;
  document.getElementById('sup_price').value = Math.round(cost * mult);
}
</script>
