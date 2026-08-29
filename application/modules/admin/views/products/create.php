<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow">
      <div class="card-header">
        <span><i class="fa fa-plus-circle mr-2"></i> Add New Product</span>
      </div>
      <div class="card-body p-4">
        <form method="POST" action="<?= base_url('admin/products/create') ?>" enctype="multipart/form-data">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

          <div class="form-group mb-3">
            <label class="font-weight-bold">Product Title 📝</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Classic Tailored Trench Coat" required autocomplete="off">
          </div>

          <div class="row">
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold">Base Price (₹) 💰</label>
              <input type="number" step="0.01" min="0" name="base_price" class="form-control" placeholder="2999.00" required>
            </div>
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold">Collection / Category 📑</label>
              <select name="collection_id" class="form-control">
                <option value="">-- Select Collection --</option>
                <?php foreach ($collections as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['title']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold">Vendor / Brand Name</label>
              <input type="text" name="vendor" class="form-control" placeholder="NovaDrop" value="NovaDrop">
            </div>
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold">Publication Status</label>
              <select name="status" class="form-control">
                <option value="active" selected>Active (Visible in Store)</option>
                <option value="draft">Draft</option>
              </select>
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="font-weight-bold">Product Image 🖼️</label>
            <input type="file" name="image" class="form-control" accept="image/*">
          </div>

          <div class="form-group mb-4">
            <label class="font-weight-bold">Product Description 📄</label>
            <textarea name="description" rows="4" class="form-control" placeholder="Detailed product craftsmanship, materials, and sizing info..."></textarea>
          </div>

          <div class="d-flex justify-content-between">
            <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary font-weight-bold">
              <i class="fa fa-check-circle mr-1"></i> Save & Publish Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
