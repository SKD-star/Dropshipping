<!-- Executive Header & Action Bar -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
  <div>
    <h3 class="font-weight-bold mb-0 text-dark" style="letter-spacing: -0.02em; font-size: 1.45rem;">
      <i class="fas fa-plus-circle text-primary mr-2"></i> Create New Apparel Product
    </h3>
    <p class="text-muted small mb-0 mt-0.5">Publish new merchandise with multi-variant apparel options, AI copywriter, and profit margins.</p>
  </div>
  <div class="d-flex flex-wrap gap-2 align-items-center">
    <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px;">
      <i class="fas fa-arrow-left mr-1"></i> Cancel &amp; Back
    </a>
  </div>
</div>

<form method="POST" action="<?= base_url('admin/products/create') ?>" enctype="multipart/form-data" id="createProductForm">
  <?= csrf_field() ?>
  
  <div class="row g-3">
    <!-- ── Left Main Column (8 cols) ── -->
    <div class="col-12 col-xl-8">
      <!-- 1. Product Basic Information & AI Tools -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-info-circle text-primary mr-2"></i> Product Details</h6>
          <button type="button" class="btn btn-sm btn-outline-indigo px-2.5 py-1" style="border-radius: 6px; font-size:0.75rem; border: 1px solid #6366f1; color: #4f46e5;" onclick="triggerAiDescription()">
            🤖 AI Copywriting Assistant
          </button>
        </div>
        <div class="card-body p-3 p-md-4">
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">Product Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="productTitleInput" class="form-control font-weight-500" placeholder="e.g. Italian Pleated Wool Overcoat" required oninput="updateSeoPreview()">
          </div>

          <div class="form-group mb-0">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="font-weight-bold text-dark small mb-0">Full Product Description</label>
              <span class="text-muted small" style="font-size:0.72rem;">HTML &amp; Rich Formatting Supported</span>
            </div>
            <textarea name="description" id="productDescInput" class="form-control" rows="6" placeholder="Detailed product narrative, craftsmanship details, care instructions, and sizing notes..." oninput="updateSeoPreview()"></textarea>
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
                  <input type="number" step="0.01" name="base_price" id="basePriceInput" class="form-control font-weight-bold" placeholder="2999.00" required oninput="calculateMargins()">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group mb-2 mb-md-0">
                <label class="font-weight-bold text-dark small">Compare-at / Strike Price (₹)</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text bg-light">₹</span></div>
                  <input type="number" step="0.01" name="compare_at_price" id="comparePriceInput" class="form-control" placeholder="3999.00" oninput="calculateMargins()">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-group mb-0">
                <label class="font-weight-bold text-dark small">Estimated Unit Cost (₹)</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text bg-light">₹</span></div>
                  <input type="number" step="0.01" name="cost_price" id="costPriceInput" class="form-control" placeholder="1050.00" oninput="calculateMargins()">
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
                  <input type="number" name="reward_points" id="rewardPointsInput" class="form-control font-weight-bold" placeholder="Auto (6% = 6 Pts per ₹100)" oninput="updateRewardPointsPreview()">
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
                  <span class="badge badge-success" id="rewardPointsCashbackBadge">₹ 0.00 Cashback</span>
                </div>
                <div class="text-muted small" id="rewardPointsPreviewText">
                  Buyer receives <strong class="text-dark" id="rewardPointsCountDisplay">0 Points</strong> on purchase · 1.5× for Gold members.
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
              <span class="badge badge-danger ml-1 px-2 py-0.5" id="discountBadgeDisplay" style="display: none;">-20%</span>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. Multi-Variant Apparel Matrix (Size, Color, SKU, Price, Qty) -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
          <div>
            <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-layer-group text-indigo-500 mr-2"></i> Initial Variants &amp; Inventory</h6>
            <span class="text-muted small">Add standard size &amp; color SKUs</span>
          </div>
          <button type="button" class="btn btn-sm btn-outline-primary px-2.5 py-1" style="border-radius: 6px;" onclick="addVariantRow()">
            <i class="fas fa-plus mr-1"></i> Add Variant
          </button>
        </div>
        <div class="card-body p-3 p-md-4">
          <div id="variantRowsContainer">
            <div class="variant-row-item" id="vrow_0">
              <div class="row g-2 align-items-center">
                <div class="col-12 col-sm-4">
                  <label class="small text-muted mb-1 font-weight-bold">Option Title (e.g. Size / Color)</label>
                  <input type="text" name="variants[0][title]" class="form-control form-control-sm" value="Standard / Medium" required>
                </div>
                <div class="col-6 col-sm-3">
                  <label class="small text-muted mb-1 font-weight-bold">SKU</label>
                  <input type="text" name="variants[0][sku]" class="form-control form-control-sm" value="NOVA-<?= rand(1000, 9999) ?>">
                </div>
                <div class="col-6 col-sm-2">
                  <label class="small text-muted mb-1 font-weight-bold">Price (₹)</label>
                  <input type="number" step="0.01" name="variants[0][price]" class="form-control form-control-sm" placeholder="2999.00">
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
            <div class="text-muted small mb-1" id="seoUrlPreview" style="font-size:0.75rem;"><?= base_url('product/new-product') ?></div>
            <div class="font-weight-bold mb-1" id="seoTitlePreview" style="color: #1a0dab; font-size: 1.05rem; cursor: pointer;">
              Product Title | NovaDrop
            </div>
            <div class="small" id="seoDescPreview" style="color: #4d5156; line-height: 1.4;">
              Discover our premium dropshipping apparel crafted with top quality fabrics...
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Right Sidebar Column (4 cols) ── -->
    <div class="col-12 col-xl-4">
      <!-- 1. Product Images & Visual Merchandising (4-5+ Multi-Gallery Support) -->
      <div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3 px-3 px-3 px-md-4">
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-camera text-primary mr-2"></i> Product Media Gallery</h6>
          <span class="text-muted small">Upload 4-5+ photos for storefront gallery</span>
        </div>
        <div class="card-body p-3 p-md-4">
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">
              <i class="fas fa-cloud-upload-alt text-primary mr-1"></i> Upload 4-5+ Gallery Photos
            </label>
            <input type="file" name="gallery_images[]" multiple class="form-control-file border rounded p-2 w-100" accept="image/*">
            <small class="text-muted d-block mt-1">Hold Ctrl/Cmd or Shift to select multiple photos at once.</small>
          </div>

          <div class="form-group mb-0">
            <label class="font-weight-bold text-dark small">
              <i class="fas fa-link text-muted mr-1"></i> Or Paste Direct Image URLs
            </label>
            <textarea name="image_url" class="form-control form-control-sm" rows="2" placeholder="Paste 1 or multiple URLs (separated by new line or comma)..."></textarea>
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
              <option value="active" selected>🟢 Active (Publish Immediately)</option>
              <option value="draft">🟡 Draft (Keep Hidden)</option>
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
                <option value="<?= $c['id'] ?>">
                  <?= htmlspecialchars($c['title'] ?? ($c['name'] ?? 'Collection')) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small">Brand / Supplier Vendor</label>
            <input type="text" name="vendor" class="form-control form-control-sm" value="NovaDrop">
          </div>

          <div class="form-group mb-0">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="featSwitch" name="is_featured" value="1">
              <label class="custom-control-label font-weight-bold text-dark small" for="featSwitch">⭐ Feature on Homepage Showcase</label>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. Sticky Publish Hub -->
      <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-3 p-md-4">
          <button type="submit" class="btn btn-primary btn-block py-2.5 font-weight-bold shadow-sm" style="border-radius: 8px;">
            <i class="fas fa-check-circle mr-1"></i> Save &amp; Publish Product
          </button>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Javascript Logic for Profit Margin, SEO Preview & Variant Rows -->
<script>
var variantIndexCounter = 1;

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
  var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
  var desc = document.getElementById('productDescInput').value || 'Discover our premium dropshipping apparel crafted with top quality fabrics.';

  document.getElementById('seoTitlePreview').innerText = title + ' | NovaDrop';
  document.getElementById('seoUrlPreview').innerText = '<?= base_url('product/') ?>' + (slug || 'new-product');
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
</script>
