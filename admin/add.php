<?php
require_once __DIR__ . '/layout_header.php';
?>
<div class="container-fluid py-4 cont">
  <!-- Top Stat Cards -->
  <?php
  $stat_total = (int)$conn->query("SELECT COUNT(*) FROM `products`")->fetch_row()[0];
  $stat_active = (int)$conn->query("SELECT COUNT(*) FROM `products` WHERE `status` = 'active'")->fetch_row()[0];
  $stat_cats = (int)$conn->query("SELECT COUNT(*) FROM `collections`")->fetch_row()[0];
  $stat_avg_price = (float)$conn->query("SELECT AVG(base_price) FROM `products`")->fetch_row()[0];
  ?>
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
      <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small font-weight-bold text-uppercase">Total Catalog SKUs</div>
            <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($stat_total) ?></h3>
          </div>
          <div class="icon-capsule blue" style="width:46px;height:46px;font-size:1.2rem;"><i class="fas fa-boxes"></i></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
      <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small font-weight-bold text-uppercase">Live Active Storefront</div>
            <h3 class="font-weight-bold text-success mb-0 mt-1"><?= number_format($stat_active) ?></h3>
          </div>
          <div class="icon-capsule green" style="width:46px;height:46px;font-size:1.2rem;"><i class="fas fa-check-circle"></i></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
      <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small font-weight-bold text-uppercase">Active Collections</div>
            <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= number_format($stat_cats) ?></h3>
          </div>
          <div class="icon-capsule indigo" style="width:46px;height:46px;font-size:1.2rem;"><i class="fas fa-tags"></i></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
      <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-muted small font-weight-bold text-uppercase">Avg Product Ticket</div>
            <h3 class="font-weight-bold text-dark mb-0 mt-1">₹<?= number_format($stat_avg_price, 2) ?></h3>
          </div>
          <div class="icon-capsule amber" style="width:46px;height:46px;font-size:1.2rem;"><i class="fas fa-rupee-sign"></i></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Catalog Table Container -->
  <div class="card shadow-sm border-0" style="border-radius: 14px; overflow: hidden; background: var(--bg-surface);">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom">
      <div class="d-flex align-items-center gap-2">
        <span class="font-weight-bold" style="font-size: 1.05rem; color: var(--text-primary);">
          <i class="fas fa-tshirt mr-2 text-primary"></i> Product Catalog &amp; Inventory Management
        </span>
        <span class="badge badge-light border text-muted font-weight-bold ml-1"><?= $stat_total ?> SKUs</span>
      </div>
      <div class="d-flex gap-2 flex-wrap align-items-center">
        <div style="min-width: 250px;">
          <input type="text" id="prodSearchInput" class="form-control form-control-sm" placeholder="🔍 Search product title or SKU..." onkeyup="filterProductTable()" style="border-radius: 8px;">
        </div>
        <button class="btn btn-sm btn-primary font-weight-bold" data-toggle="modal" data-target="#addProductModal" style="border-radius: 8px; padding: 6px 14px;">
          <i class="fas fa-plus mr-1"></i> Add Product
        </button>
        <button class="btn btn-sm btn-outline-secondary font-weight-bold" data-toggle="modal" data-target="#addCategoryModal" style="border-radius: 8px; padding: 6px 14px;">
          <i class="fas fa-tags mr-1"></i> Add Category
        </button>
      </div>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle usr-table mb-0" id="productTable">
          <thead style="background: #f8fafc; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
            <tr>
              <th style="width: 50px; text-align: center;">#</th>
              <th style="width: 70px; text-align: center;">Image</th>
              <th>Product Title &amp; SKU</th>
              <th>Category</th>
              <th>Selling Price</th>
              <th>Compare At</th>
              <th style="text-align: center;">Status</th>
              <th style="text-align: right; width: 170px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $c = 1;
            $res_p = $conn->query("
              SELECT p.*, c.title as category_title, pi.url as img_url 
              FROM `products` p 
              LEFT JOIN `collections` c ON p.collection_id = c.id 
              LEFT JOIN `product_images` pi ON pi.product_id = p.id AND pi.is_primary = 1
              ORDER BY p.id ASC
            ");

            if ($res_p && $res_p->num_rows > 0) {
                while ($row = $res_p->fetch_assoc()) {
                    $pid = $row['id'];
                    $pname = htmlspecialchars($row['title']);
                    $cat_name = htmlspecialchars($row['category_title'] ?: 'Apparel & Lifestyle');
                    $base_price = (float)$row['base_price'];
                    $comp_price = (float)($row['compare_at_price'] ?: ($base_price * 1.35));
                    $discount_pct = $comp_price > $base_price ? round((($comp_price - $base_price) / $comp_price) * 100) : 0;
                    $slug = htmlspecialchars($row['slug']);
                    $img_url = $row['img_url'] ?: ($row['og_image_url'] ?: '../img/blogor.png');
                    ?>
                    <tr style="border-bottom: 1px solid rgba(226, 232, 240, 0.6); vertical-align: middle;">
                      <!-- # -->
                      <td style="text-align: center; color: #94a3b8; font-weight: 700;"><?= $c ?></td>
                      
                      <!-- Product Image Thumbnail -->
                      <td style="text-align: center;">
                        <a href="index.php?q=1&step=1&pid=<?= $pid ?>">
                          <img src="<?= $img_url ?>" alt="<?= $pname ?>" class="prod-thumb-img" onerror="this.src='../img/blogor.png'" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid #e2e8f0; background: #f1f5f9;">
                        </a>
                      </td>

                      <!-- Product Title & SKU -->
                      <td>
                        <a href="index.php?q=1&step=1&pid=<?= $pid ?>" class="font-weight-bold" style="color: #1e293b; text-decoration: none; font-size: 0.93rem; display: block;">
                          <?= $pname ?>
                        </a>
                        <div class="d-flex align-items-center gap-2 mt-1">
                          <span class="badge badge-light border text-muted" style="font-size: 0.68rem; font-family: monospace; padding: 2px 6px;">#PROD-<?= $pid ?></span>
                          <span class="text-muted small" style="font-size: 0.75rem;"><i class="fas fa-tag mr-1 opacity-50"></i> <?= htmlspecialchars($row['vendor'] ?? 'NovaDrop') ?></span>
                        </div>
                      </td>

                      <!-- Category -->
                      <td>
                        <span class="badge" style="background: rgba(67, 97, 238, 0.1); color: #4361ee; border: 1px solid rgba(67, 97, 238, 0.2); border-radius: 6px; font-weight: 600; padding: 4px 8px; font-size: 0.76rem;">
                          <?= $cat_name ?>
                        </span>
                      </td>

                      <!-- Selling Price -->
                      <td>
                        <span class="font-weight-bold" style="font-size: 0.95rem; color: #0f172a;">
                          ₹<?= number_format($base_price, 2) ?>
                        </span>
                      </td>

                      <!-- Compare At & Discount -->
                      <td>
                        <span class="text-muted small mr-1" style="text-decoration: line-through;">₹<?= number_format($comp_price, 2) ?></span>
                        <?php if ($discount_pct > 0): ?>
                          <span class="badge badge-success" style="font-size: 0.68rem; padding: 3px 6px; border-radius: 4px;"><?= $discount_pct ?>% OFF</span>
                        <?php endif; ?>
                      </td>

                      <!-- Stock Status -->
                      <td style="text-align: center;">
                        <?php if ($row['status'] === 'active'): ?>
                          <span class="badge badge-success" style="font-size: 0.72rem; padding: 4px 8px; border-radius: 20px; background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3);">
                            ● Active
                          </span>
                        <?php else: ?>
                          <span class="badge badge-secondary" style="font-size: 0.72rem; padding: 4px 8px; border-radius: 20px;">
                            ● <?= ucfirst($row['status']) ?>
                          </span>
                        <?php endif; ?>
                      </td>

                      <!-- Actions -->
                      <td style="text-align: right; white-space: nowrap;">
                        <a href="index.php?q=1&step=1&pid=<?= $pid ?>" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; padding: 4px 10px; font-weight: 600; font-size: 0.8rem;" title="Edit Product in Studio">
                          <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <a href="../products/<?= urlencode($slug) ?>" target="_blank" class="btn btn-sm btn-outline-info" style="border-radius: 6px; padding: 4px 8px;" title="View on Live Store">
                          <i class="fas fa-external-link-alt"></i>
                        </a>
                        <a href="update.php?q=delprod&pid=<?= $pid ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete product #<?= $pid ?> (<?= addslashes($pname) ?>)?')" style="border-radius: 6px; padding: 4px 8px;" title="Delete Product">
                          <i class="fas fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                    <?php
                    $c++;
                }
            } else {
                echo '<tr><td colspan="8" class="text-center py-5 text-muted"><i class="fas fa-box-open fa-3x mb-3 text-muted"></i><br>No products in catalog. Click "+ Add Product" to create your first item.</td></tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Add Product -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-radius: 14px; border: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
      <div class="modal-header border-bottom py-3">
        <h5 class="modal-title font-weight-bold" style="color: #1e293b;"><i class="fas fa-plus-circle text-primary mr-2"></i> Add New Product to Catalog</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="index.php?q=0" method="POST">
        <input type="hidden" name="dashboard_action" value="quick_add_product">
        <div class="modal-body p-4">
          <div class="row">
            <div class="col-md-8 form-group mb-3">
              <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Product Title</label>
              <input type="text" name="title" class="form-control" placeholder="e.g. Sculpted Heavyweight French Terry Hoodie" required style="border-radius: 8px;">
            </div>
            <div class="col-md-4 form-group mb-3">
              <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Collection / Category</label>
              <select name="collection_id" class="form-control" style="border-radius: 8px;">
                <?php
                $cats = $conn->query("SELECT * FROM `collections` ORDER BY id ASC");
                if ($cats && $cats->num_rows > 0) {
                    while ($c = $cats->fetch_assoc()) {
                        echo "<option value='{$c['id']}'>" . htmlspecialchars($c['title']) . "</option>";
                    }
                } else {
                    echo "<option value='1'>Apparel & Lifestyle</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Selling Price (₹)</label>
              <input type="number" step="0.01" name="price" class="form-control" placeholder="3499.00" required style="border-radius: 8px;">
            </div>
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Compare-At Price (₹)</label>
              <input type="number" step="0.01" name="compare_at" class="form-control" placeholder="4999.00" style="border-radius: 8px;">
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Product Image URL or Asset Path</label>
            <input type="text" name="image_url" class="form-control" placeholder="e.g. img/terry_hoodie_luxury.jpg or https://..." style="border-radius: 8px;">
            <small class="text-muted">High-res JPEG/PNG product photography path or CDN link.</small>
          </div>
          <div class="form-group mb-0">
            <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Product Description &amp; Specifications</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Enter high-converting product features, specifications, and fabric provenance notes..." style="border-radius: 8px;"></textarea>
          </div>
        </div>
        <div class="modal-footer border-top py-3">
          <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; padding: 6px 18px;"><i class="fas fa-check mr-1"></i> Save &amp; Publish</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Add Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 14px; border: 0; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
      <div class="modal-header border-bottom py-3">
        <h5 class="modal-title font-weight-bold" style="color: #1e293b;"><i class="fas fa-tags text-primary mr-2"></i> Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="update.php?q=addcatg" method="POST">
        <div class="modal-body p-4">
          <div class="form-group mb-3">
            <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Category Name</label>
            <input type="text" name="pname" class="form-control" placeholder="e.g. Footwear &amp; Accessories" required style="border-radius: 8px;">
          </div>
          <div class="form-group mb-0">
            <label class="font-weight-bold" style="font-size: 0.85rem; color: #475569;">Description</label>
            <textarea name="descpr" class="form-control" rows="3" placeholder="Category summary for storefront filter..." style="border-radius: 8px;"></textarea>
          </div>
        </div>
        <div class="modal-footer border-top py-3">
          <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold" style="border-radius: 8px; padding: 6px 18px;">Create Category</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function filterProductTable() {
  var input = document.getElementById("prodSearchInput");
  var filter = input.value.toUpperCase();
  var table = document.getElementById("productTable");
  var tr = table.getElementsByTagName("tr");
  for (var i = 1; i < tr.length; i++) {
    var tdTitle = tr[i].getElementsByTagName("td")[2];
    if (tdTitle) {
      var txtValue = tdTitle.textContent || tdTitle.innerText;
      tr[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
    }
  }
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
