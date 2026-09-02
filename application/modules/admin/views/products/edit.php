<!-- Executive Header & Action Bar -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
  <div>
    <div class="d-flex align-items-center gap-2">
      <h3 class="font-weight-bold mb-0 text-dark" style="letter-spacing: -0.02em; font-size: 1.45rem;">
        Edit Product: <?= htmlspecialchars($product['title'] ?? '') ?>
      </h3>
      <span class="badge badge-light border text-muted px-2 py-1" style="font-size:0.75rem;">ID #<?= $product['id'] ?></span>
      <span class="badge badge-<?= ($product['status'] ?? '') === 'active' ? 'success' : 'warning' ?> px-2 py-1" style="font-size:0.75rem;">
        <?= ucfirst($product['status'] ?? 'Active') ?>
      </span>
    </div>
    <p class="text-muted small mb-0 mt-0.5">Manage apparel variants, pricing elasticity, visual merchandising, and SEO tags.</p>
  </div>
  <div class="d-flex flex-wrap gap-2 align-items-center">
    <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px;">
      <i class="fas fa-arrow-left mr-1"></i> Back to Products
    </a>
    <a href="<?= base_url('product/' . ($product['slug'] ?? $product['id'])) ?>" target="_blank" class="btn btn-sm btn-outline-info px-3" style="border-radius: 8px;">
      <i class="fas fa-eye mr-1"></i> Live Storefront ↗
    </a>
    <a href="<?= base_url('admin/products/duplicate/' . $product['id']) ?>" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 8px;">
      <i class="fas fa-clone mr-1"></i> Clone
    </a>
  </div>
</div>

<!-- Flash Alerts -->
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

<form method="POST" action="<?= base_url('admin/products/edit/' . $product['id']) ?>" enctype="multipart/form-data" id="editProductForm">
  <?= csrf_field() ?>
  
  <div class="row g-3">
    <!-- ── Left Main Column (8 cols) ── -->
    <div class="col-12 col-xl-8">
      <!-- 1. Product Basic Information & AI Tools -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-info-circle text-primary mr-2"></i> Core Product Details</h6>
          <button type="button" class="btn btn-sm btn-outline-indigo px-2.5 py-1" style="border-radius: 6px; font-size:0.75rem; border: 1px solid #6366f1; color: #4f46e5;" onclick="triggerAiDescription()">
            🤖 AI Copywriting Assistant
          </button>
        </div>
        <div class="card-body p-3 p-md-4">
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">Product Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="productTitleInput" class="form-control font-weight-500" value="<?= htmlspecialchars($product['title'] ?? '') ?>" required oninput="updateSeoPreview()">
          </div>

          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">URL Handle / Slug</label>
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
                <span class="input-group-text bg-light text-muted" style="font-size:0.75rem;"><?= base_url('product/') ?></span>
              </div>
              <input type="text" name="slug" id="productSlugInput" class="form-control form-control-sm" value="<?= htmlspecialchars($product['slug'] ?? '') ?>" oninput="updateSeoPreview()">
            </div>
          </div>

          <div class="form-group mb-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="font-weight-bold text-dark small mb-0">Full Product Description</label>
              <span class="text-muted small" style="font-size:0.72rem;">HTML &amp; Rich Formatting Supported</span>
            </div>
            <textarea name="description" id="productDescInput" class="form-control" rows="6" placeholder="Detailed product narrative, fabric details, care instructions, and styling notes..." oninput="updateSeoPreview()"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
          </div>
        </div>
      </div>

      <!-- 2. Smart Pricing & Live Profit Margin Engine -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-tags text-success mr-2"></i> Pricing &amp; Profit Margins</h6>
        </div>
        <div class="card-body p-3 p-md-4">
          <div class="row g-3">
            <div class="col-12 col-md-4">
              <div class="form-group mb-2 mb-md-0">
                <label class="font-weight-bold text-dark small">Base Selling Price (₹) <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text bg-light">₹</span></div>
                  <input type="number" step="0.01" name="base_price" id="basePriceInput" class="form-control font-weight-bold" value="<?= $product['base_price'] ?? 0 ?>" required oninput="calculateMargins()">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group mb-2 mb-md-0">
                <label class="font-weight-bold text-dark small">Compare-at / Strike Price (₹)</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text bg-light">₹</span></div>
                  <input type="number" step="0.01" name="compare_at_price" id="comparePriceInput" class="form-control" value="<?= $product['compare_at_price'] ?? 0 ?>" oninput="calculateMargins()">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group mb-0">
                <label class="font-weight-bold text-dark small">Estimated Unit Cost (₹)</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text bg-light">₹</span></div>
                  <input type="number" step="0.01" name="cost_price" id="costPriceInput" class="form-control" value="<?= htmlspecialchars($product['cost_price'] ?? round(($product['base_price'] ?? 0) * 0.35, 2)) ?>" oninput="calculateMargins()">
                </div>
              </div>
            </div>
          </div>

          <!-- Reward Points (Loyalty Cashback) Section -->
          <div class="row g-3 mt-2 pt-3 border-top">
            <div class="col-12 col-md-6">
              <div class="form-group mb-0">
                <label class="font-weight-bold text-dark small d-flex align-items-center justify-content-between">
                  <span><i class="fas fa-coins text-warning mr-1"></i> Reward Points (Loyalty Cashback)</span>
                  <span class="badge badge-info" style="font-size:0.7rem;">1 Pt = ₹1.00</span>
                </label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text bg-light"><i class="fas fa-award text-warning"></i></span></div>
                  <input type="number" name="reward_points" id="rewardPointsInput" class="form-control font-weight-bold" placeholder="Auto (6% = 6 Pts per ₹100)" value="<?= !empty($product['reward_points']) ? $product['reward_points'] : '' ?>" oninput="updateRewardPointsPreview()">
                </div>
                <small class="form-text text-muted">
                  Leave blank or 0 to auto-calculate from price (<strong>6% Cashback = 6 Pts per ₹100 spent</strong>). Or set a custom points bounty.
                </small>
              </div>
            </div>
            <div class="col-12 col-md-6 d-flex align-items-center">
              <div class="p-2.5 w-100 rounded" style="background: #fdf6b2; border: 1px solid #fce96a;">
                <div class="small font-weight-bold text-dark mb-1 d-flex align-items-center justify-content-between">
                  <span>Customer Earning Preview:</span>
                  <span class="badge badge-success" id="rewardPointsCashbackBadge">₹ <?= number_format(!empty($product['reward_points']) ? $product['reward_points'] : round(($product['base_price'] ?? 0) * 0.06), 2) ?> Cashback</span>
                </div>
                <div class="text-muted small" id="rewardPointsPreviewText">
                  Buyer receives <strong class="text-dark" id="rewardPointsCountDisplay"><?= !empty($product['reward_points']) ? $product['reward_points'] : round(($product['base_price'] ?? 0) * 0.06) ?> Points</strong> on purchase · 1.5× for Gold (<?= round((!empty($product['reward_points']) ? $product['reward_points'] : round(($product['base_price'] ?? 0) * 0.06)) * 1.5) ?> pts).
                </div>
              </div>
            </div>
          </div>

          <!-- Live Margin Calculator Bar -->
          <div class="p-3 mt-3 rounded d-flex flex-wrap align-items-center justify-content-between gap-2" style="background: #f8fafc; border: 1px solid #e2e8f0;">
            <div>
              <span class="text-muted small">Estimated Gross Margin:</span>
              <span class="font-weight-bold text-success ml-1" id="marginPercentDisplay">65.0%</span>
            </div>
            <div>
              <span class="text-muted small">Gross Profit Per Unit:</span>
              <span class="font-weight-bold text-dark ml-1" id="profitUnitDisplay">₹ 0.00</span>
            </div>
            <div>
              <span class="text-muted small">Customer Discount:</span>
              <span class="badge badge-danger ml-1 px-2 py-0.5" id="discountBadgeDisplay">-20%</span>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. Multi-Variant Apparel Matrix (Size, Color, SKU, Price, Qty) -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
          <div>
            <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-layer-group text-indigo-500 mr-2"></i> Product Variants Matrix</h6>
            <span class="text-muted small">Manage sizes, colors, independent SKU pricing, and stock</span>
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="border-radius: 6px;" onclick="addVariantRow()">
            <i class="fas fa-plus mr-1"></i> Add Variant
          </button>
        </div>
        <div class="card-body p-3 p-md-4">
          <div id="variantRowsContainer">
            <?php if (empty($variants)): ?>
              <div class="variant-row-item" id="vrow_0">
                <div class="row g-2 align-items-center">
                  <div class="col-12 col-sm-4">
                    <label class="small text-muted mb-1 font-weight-bold">Option Title (e.g. Size / Color)</label>
                    <input type="text" name="variants[0][title]" class="form-control form-control-sm" value="Standard" required>
                  </div>
                  <div class="col-6 col-sm-3">
                    <label class="small text-muted mb-1 font-weight-bold">SKU</label>
                    <input type="text" name="variants[0][sku]" class="form-control form-control-sm" value="NOVA-<?= rand(1000, 9999) ?>">
                  </div>
                  <div class="col-6 col-sm-2">
                    <label class="small text-muted mb-1 font-weight-bold">Price (₹)</label>
                    <input type="number" step="0.01" name="variants[0][price]" class="form-control form-control-sm" value="<?= $product['base_price'] ?? 0 ?>">
                  </div>
                  <div class="col-6 col-sm-2">
                    <label class="small text-muted mb-1 font-weight-bold">Stock Qty</label>
                    <input type="number" name="variants[0][inventory_qty]" class="form-control form-control-sm" value="50">
                  </div>
                  <div class="col-6 col-sm-1 text-right mt-3 mt-sm-0">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariantRow('vrow_0')" title="Remove"><i class="fas fa-times"></i></button>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <?php foreach ($variants as $idx => $v): ?>
                <div class="variant-row-item" id="vrow_<?= $idx ?>">
                  <input type="hidden" name="variants[<?= $idx ?>][id]" value="<?= $v['id'] ?>">
                  <div class="row g-2 align-items-center">
                    <div class="col-12 col-sm-4">
                      <label class="small text-muted mb-1 font-weight-bold">Option Title</label>
                      <input type="text" name="variants[<?= $idx ?>][title]" class="form-control form-control-sm font-weight-500" value="<?= htmlspecialchars($v['title'] ?? 'Standard') ?>" required>
                    </div>
                    <div class="col-6 col-sm-3">
                      <label class="small text-muted mb-1 font-weight-bold">SKU Code</label>
                      <input type="text" name="variants[<?= $idx ?>][sku]" class="form-control form-control-sm" value="<?= htmlspecialchars($v['sku'] ?? '') ?>" style="font-family: monospace;">
                    </div>
                    <div class="col-6 col-sm-2">
                      <label class="small text-muted mb-1 font-weight-bold">Price (₹)</label>
                      <input type="number" step="0.01" name="variants[<?= $idx ?>][price]" class="form-control form-control-sm font-weight-bold" value="<?= $v['price'] ?? $product['base_price'] ?>">
                    </div>
                    <div class="col-6 col-sm-2">
                      <label class="small text-muted mb-1 font-weight-bold">Stock</label>
                      <input type="number" name="variants[<?= $idx ?>][inventory_qty]" class="form-control form-control-sm" value="<?= $v['inventory_qty'] ?? 0 ?>">
                    </div>
                    <div class="col-6 col-sm-1 text-right mt-3 mt-sm-0">
                      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariantRow('vrow_<?= $idx ?>')" title="Remove"><i class="fas fa-times"></i></button>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- 4. Google Search Snippet SEO Live Preview -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-search text-primary mr-2"></i> Search Engine (SEO) Preview</h6>
        </div>
        <div class="card-body p-3 p-md-4">
          <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0; font-family: Arial, sans-serif;">
            <div class="text-muted small mb-1" id="seoUrlPreview" style="font-size:0.75rem;"><?= base_url('product/' . ($product['slug'] ?? 'example-product')) ?></div>
            <div class="font-weight-bold mb-1" id="seoTitlePreview" style="color: #1a0dab; font-size: 1.05rem; cursor: pointer;">
              <?= htmlspecialchars($product['title'] ?? 'Product Title') ?> | NovaDrop
            </div>
            <div class="small" id="seoDescPreview" style="color: #4d5156; line-height: 1.4;">
              <?= htmlspecialchars(substr(strip_tags($product['description'] ?? 'Discover our premium dropshipping apparel crafted with top quality fabrics.'), 0, 150)) ?>...
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Right Sidebar Column (4 cols) ── -->
    <div class="col-12 col-xl-4">
      <!-- 1. Product Images & Visual Merchandising (4-5+ Multi-Gallery with Shifting & Arranging) -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
          <div>
            <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-images text-primary mr-2"></i> Product Media Gallery</h6>
            <span class="text-muted small">Upload 4-5+ photos &amp; rearrange display order</span>
          </div>
          <span class="badge badge-light border text-muted px-2 py-1" style="font-size:0.75rem;">
            <?= count($images) ?> image<?= count($images) !== 1 ? 's' : '' ?>
          </span>
        </div>
        <div class="card-body p-3 p-md-4">
          <!-- Interactive Gallery Arranging & Shifting Grid -->
          <?php if (!empty($images)): ?>
            <label class="font-weight-bold text-dark small mb-2 d-block">Current Gallery Photos (Reorder &amp; Arrange):</label>
            <div class="row g-2 mb-3">
              <?php foreach ($images as $idx => $img): ?>
                <div class="col-6 col-sm-4">
                  <div class="position-relative border rounded p-1.5 h-100 d-flex flex-column align-items-center justify-content-between" style="background:#f8fafc; border-color: <?= !empty($img['is_primary']) ? '#4f46e5 !important; box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);' : '#e2e8f0;' ?>">
                    <!-- Image Thumbnail with Position Pill -->
                    <div style="width: 100%; height: 95px; border-radius: 6px; overflow: hidden; background: #ffffff; position: relative;">
                      <img src="<?= htmlspecialchars($img['url']) ?>" style="width:100%; height:100%; object-fit:cover;" alt="Product photo">
                      <span class="badge badge-dark position-absolute" style="top: 3px; right: 3px; font-size: 0.65rem; opacity: 0.85;">
                        #<?= $idx + 1 ?>
                      </span>
                      <?php if (!empty($img['is_primary'])): ?>
                        <span class="badge badge-primary position-absolute font-weight-bold" style="top: 3px; left: 3px; font-size: 0.65rem;">
                          ⭐ Cover
                        </span>
                      <?php endif; ?>
                    </div>

                    <!-- Shifting & Arranging Action Buttons -->
                    <div class="w-100 mt-2 d-flex justify-content-between align-items-center gap-1">
                      <!-- Shift Left -->
                      <?php if ($idx > 0): ?>
                        <a href="<?= base_url('admin/products/shift_image/' . $product['id'] . '/' . $img['id'] . '/left') ?>" class="btn btn-xs btn-outline-secondary p-1 flex-grow-1" title="Shift Left / Move Up" style="font-size:0.7rem; border-radius:4px;">
                          ⬅️
                        </a>
                      <?php else: ?>
                        <span class="btn btn-xs btn-light p-1 flex-grow-1 disabled opacity-50" style="font-size:0.7rem;">⬅️</span>
                      <?php endif; ?>

                      <!-- Set As Cover -->
                      <?php if (empty($img['is_primary'])): ?>
                        <a href="<?= base_url('admin/products/set_cover_image/' . $product['id'] . '/' . $img['id']) ?>" class="btn btn-xs btn-outline-primary p-1 flex-grow-1" title="Set As Cover / Primary" style="font-size:0.7rem; border-radius:4px;">
                          ⭐
                        </a>
                      <?php endif; ?>

                      <!-- Shift Right -->
                      <?php if ($idx < count($images) - 1): ?>
                        <a href="<?= base_url('admin/products/shift_image/' . $product['id'] . '/' . $img['id'] . '/right') ?>" class="btn btn-xs btn-outline-secondary p-1 flex-grow-1" title="Shift Right / Move Down" style="font-size:0.7rem; border-radius:4px;">
                          ➡️
                        </a>
                      <?php else: ?>
                        <span class="btn btn-xs btn-light p-1 flex-grow-1 disabled opacity-50" style="font-size:0.7rem;">➡️</span>
                      <?php endif; ?>

                      <!-- Delete Image -->
                      <a href="<?= base_url('admin/products/delete_image/' . $product['id'] . '/' . $img['id']) ?>" class="btn btn-xs btn-outline-danger p-1" onclick="return confirm('Remove this image from gallery?')" title="Delete Photo" style="font-size:0.7rem; border-radius:4px;">
                        🗑️
                      </a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <!-- Multi-File Upload Form Control (Select 4-5 photos simultaneously) -->
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">
              <i class="fas fa-cloud-upload-alt text-primary mr-1"></i> Upload 4-5+ Gallery Photos
            </label>
            <input type="file" name="gallery_images[]" multiple class="form-control-file border rounded p-2 w-100" accept="image/*">
            <small class="text-muted d-block mt-1">Select multiple images at once (PNG, JPG, WEBP). Supports 4-5+ apparel shots.</small>
          </div>

          <!-- Multi-URL Paste Area -->
          <div class="form-group mb-0">
            <label class="font-weight-bold text-dark small">
              <i class="fas fa-link text-muted mr-1"></i> Or Paste Direct Image URLs
            </label>
            <textarea name="direct_image_urls" class="form-control form-control-sm" rows="2" placeholder="Paste 1 or multiple URLs (separated by new line or comma)..."></textarea>
            <small class="text-muted">e.g. https://images.unsplash.com/photo-1..., https://...</small>
          </div>
        </div>
      </div>

      <!-- 2. Organization & Categorization -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-sitemap text-indigo-500 mr-2"></i> Organization &amp; Taxonomy</h6>
        </div>
        <div class="card-body p-3 p-md-4">
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">Publishing Status</label>
            <select name="status" class="form-control font-weight-bold" style="height: 42px !important;">
              <option value="active" <?= ($product['status'] ?? '') === 'active' ? 'selected' : '' ?>>🟢 Active (Live on Storefront)</option>
              <option value="draft" <?= ($product['status'] ?? '') === 'draft' ? 'selected' : '' ?>>🟡 Draft (Hidden from Storefront)</option>
              <option value="archived" <?= ($product['status'] ?? '') === 'archived' ? 'selected' : '' ?>>⚪ Archived (Decommissioned)</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="font-weight-bold text-dark small mb-0">Collection / Category</label>
              <a href="<?= base_url('admin/products/categories') ?>" target="_blank" class="small text-primary font-weight-bold" style="font-size:0.75rem;">+ Manage / New Category</a>
            </div>
            <select name="collection_id" class="form-control" style="height: 42px !important;">
              <option value="">— Unassigned / General —</option>
              <?php foreach ($collections as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($product['collection_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($c['title'] ?? ($c['name'] ?? 'Collection')) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">Brand / Supplier Vendor</label>
            <input type="text" name="vendor" class="form-control form-control-sm" value="<?= htmlspecialchars($product['vendor'] ?? 'NovaDrop') ?>">
          </div>

          <div class="form-group mb-0">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="featSwitch" name="is_featured" value="1" <?= !empty($product['is_featured']) ? 'checked' : '' ?>>
              <label class="custom-control-label font-weight-bold text-dark small" for="featSwitch">⭐ Feature on Homepage Showcase</label>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. Sticky Action Hub -->
      <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-3 p-md-4">
          <button type="submit" class="btn btn-success btn-block py-2.5 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-save mr-1"></i> Save Changes
          </button>
          <a href="<?= base_url('admin/products/delete/' . $product['id']) ?>" class="btn btn-outline-danger btn-block btn-sm mt-2" onclick="return confirm('Permanently delete this product and its variants?')" style="border-radius: 6px;">
            <i class="fas fa-trash-alt mr-1"></i> Delete Product
          </a>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Javascript Logic for Profit Margin, SEO Preview & Variant Rows -->
<script>
var variantIndexCounter = <?= count($variants ?: [1]) ?>;

function calculateMargins() {
  var basePrice = parseFloat(document.getElementById('basePriceInput').value) || 0;
  var compPrice = parseFloat(document.getElementById('comparePriceInput').value) || 0;
  var costPrice = parseFloat(document.getElementById('costPriceInput').value) || (basePrice * 0.35);

  var profit = basePrice - costPrice;
  var margin = basePrice > 0 ? ((profit / basePrice) * 100).toFixed(1) : 0;
  
  document.getElementById('profitUnitDisplay').innerText = '₹ ' + profit.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
  document.getElementById('marginPercentDisplay').innerText = margin + '%';

  if (compPrice > basePrice) {
    var discount = Math.round(((compPrice - basePrice) / compPrice) * 100);
    document.getElementById('discountBadgeDisplay').innerText = '-' + discount + '% OFF';
    document.getElementById('discountBadgeDisplay').style.display = 'inline-block';
  } else {
    document.getElementById('discountBadgeDisplay').style.display = 'none';
  }

  updateRewardPointsPreview();
}

function updateRewardPointsPreview() {
  var basePrice = parseFloat(document.getElementById('basePriceInput').value) || 0;
  var customPts = document.getElementById('rewardPointsInput') ? document.getElementById('rewardPointsInput').value : '';
  
  var finalPts = (customPts !== '' && !isNaN(parseInt(customPts))) ? parseInt(customPts) : Math.max(1, Math.round(basePrice * 0.06));
  var cashVal = finalPts; // 1 pt = ₹1

  var badge = document.getElementById('rewardPointsCashbackBadge');
  var countDisp = document.getElementById('rewardPointsCountDisplay');
  var previewText = document.getElementById('rewardPointsPreviewText');

  if (badge) badge.innerText = '₹ ' + cashVal.toLocaleString('en-IN') + '.00 Cashback';
  if (countDisp) countDisp.innerText = finalPts.toLocaleString('en-IN') + ' Points';
  if (previewText) {
    var goldPts = Math.round(finalPts * 1.5);
    previewText.innerHTML = 'Buyer receives <strong class="text-dark">' + finalPts.toLocaleString('en-IN') + ' Points</strong> on purchase · 1.5× for Gold (' + goldPts.toLocaleString('en-IN') + ' pts).';
  }
}

function updateSeoPreview() {
  var title = document.getElementById('productTitleInput').value || 'Product Title';
  var slug = document.getElementById('productSlugInput').value || 'example-product';
  var desc = document.getElementById('productDescInput').value || 'Product narrative and details.';

  document.getElementById('seoTitlePreview').innerText = title + ' | NovaDrop';
  document.getElementById('seoUrlPreview').innerText = '<?= base_url('product/') ?>' + slug;
  document.getElementById('seoDescPreview').innerText = desc.substring(0, 150) + '...';
}

function addVariantRow() {
  var container = document.getElementById('variantRowsContainer');
  var idx = variantIndexCounter++;
  var basePrice = document.getElementById('basePriceInput').value || '0.00';

  var html = `
    <div class="variant-row-item" id="vrow_${idx}">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-sm-4">
          <label class="small text-muted mb-1 font-weight-bold">Option Title (e.g. Size / Color)</label>
          <input type="text" name="variants[${idx}][title]" class="form-control form-control-sm" placeholder="e.g. Large / Indigo" required>
        </div>
        <div class="col-6 col-sm-3">
          <label class="small text-muted mb-1 font-weight-bold">SKU Code</label>
          <input type="text" name="variants[${idx}][sku]" class="form-control form-control-sm" value="NOVA-${Math.floor(1000 + Math.random() * 9000)}" style="font-family: monospace;">
        </div>
        <div class="col-6 col-sm-2">
          <label class="small text-muted mb-1 font-weight-bold">Price (₹)</label>
          <input type="number" step="0.01" name="variants[${idx}][price]" class="form-control form-control-sm font-weight-bold" value="${basePrice}">
        </div>
        <div class="col-6 col-sm-2">
          <label class="small text-muted mb-1 font-weight-bold">Stock</label>
          <input type="number" name="variants[${idx}][inventory_qty]" class="form-control form-control-sm" value="50">
        </div>
        <div class="col-6 col-sm-1 text-right mt-3 mt-sm-0">
          <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariantRow('vrow_${idx}')" title="Remove"><i class="fas fa-times"></i></button>
        </div>
      </div>
    </div>
  `;
  container.insertAdjacentHTML('beforeend', html);
}

function removeVariantRow(rowId) {
  var row = document.getElementById(rowId);
  if (row) {
    row.remove();
  }
}

function triggerAiDescription() {
  var title = document.getElementById('productTitleInput').value || 'Apparel Product';
  var aiPrompt = `✨ Crafted with meticulous artisanal precision, the ${title} embodies contemporary elegance and uncompromising durability. Tailored from premium high-density fabrics, it delivers exceptional silhouette structure and all-day breathable comfort. Perfect for elevated everyday styling or statement layering.\n\n• Premium textile fabrication with reinforced stitching\n• Ergonomic modern silhouette designed for versatile movement\n• Pre-shrunk finish for lasting dimensional stability\n• Ethically sourced and responsibly crafted`;
  document.getElementById('productDescInput').value = aiPrompt;
  updateSeoPreview();
}

// Initial Run on page load
document.addEventListener('DOMContentLoaded', function() {
  calculateMargins();
  updateSeoPreview();
});
</script>
