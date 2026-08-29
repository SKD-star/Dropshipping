<?php
require_once __DIR__ . '/layout_header.php';
/**
 * NovaDrop Advanced Product Editor & Variant Studio
 */

$ccid = $_GET['ccid'] ?? '';
$pid = (int)($_GET['pid'] ?? 0);

// Resolve product ID
if ($pid === 0 && !empty($ccid)) {
    if (strpos($ccid, 'prod_') === 0) {
        $pid = (int)substr($ccid, 5);
    } else {
        $chk_p = $conn->query("SELECT id FROM `products` WHERE slug = '$ccid' OR id = '$ccid' LIMIT 1");
        if ($chk_p && $row = $chk_p->fetch_assoc()) {
            $pid = (int)$row['id'];
        }
    }
}

if ($pid === 0) {
    $first_p = $conn->query("SELECT id FROM `products` ORDER BY id ASC LIMIT 1");
    if ($first_p && $row = $first_p->fetch_assoc()) {
        $pid = (int)$row['id'];
    }
}

$save_msg = null;
$error_msg = null;

// Handle Product Update POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['save_product'])) {
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $cat_id = (int)($_POST['collection_id'] ?? 1);
    $status = $_POST['status'] ?? 'active';
    $vendor = trim($_POST['vendor'] ?? 'NovaDrop');
    $base_price = (float)($_POST['base_price'] ?? 0);
    $compare_price = (float)($_POST['compare_at_price'] ?? ($base_price * 1.35));
    $description = trim($_POST['description'] ?? '');
    $seo_title = trim($_POST['seo_title'] ?? $title);
    $seo_desc = trim($_POST['seo_description'] ?? substr(strip_tags($description), 0, 160));

    if (!empty($title) && $pid > 0) {
        $stmt_u = $conn->prepare("UPDATE `products` SET `title` = ?, `slug` = ?, `collection_id` = ?, `status` = ?, `vendor` = ?, `base_price` = ?, `compare_at_price` = ?, `description` = ?, `seo_title` = ?, `seo_description` = ?, `updated_at` = NOW() WHERE `id` = ?");
        $stmt_u->bind_param("ssissddsssi", $title, $slug, $cat_id, $status, $vendor, $base_price, $compare_price, $description, $seo_title, $seo_desc, $pid);
        if ($stmt_u->execute()) {
            // Sync legacy product table
            $conn->query("UPDATE `product` SET `pname` = '" . $conn->real_escape_string($title) . "', `mrp` = $base_price, `descp` = '" . $conn->real_escape_string($description) . "' WHERE `ccid` = 'prod_$pid'");
            // ✅ Sync product_variants price so storefront always shows the admin-set price
            $conn->query("UPDATE `product_variants` SET `price` = $base_price, `compare_price` = $compare_price WHERE `product_id` = $pid");
            $save_msg = "Product details & pricing updated successfully!";
        } else {
            $error_msg = "Failed to update product: " . $conn->error;
        }
    }
}

// Fetch Product Details
$product = null;
if ($pid > 0) {
    $res_p = $conn->query("SELECT p.*, c.title as category_title FROM `products` p LEFT JOIN `collections` c ON p.collection_id = c.id WHERE p.id = $pid LIMIT 1");
    if ($res_p && $res_p->num_rows > 0) {
        $product = $res_p->fetch_assoc();
    }
}

if (!$product) {
    echo '<div class="container py-5"><div class="alert alert-warning">Product not found. <a href="index.php?q=1">Back to Catalog</a></div></div>';
    return;
}

$variants = [];
$res_v = $conn->query("SELECT * FROM `product_variants` WHERE `product_id` = $pid ORDER BY id ASC");
if ($res_v) {
    while ($v = $res_v->fetch_assoc()) {
        $variants[] = $v;
    }
}

$base_price = (float)$product['base_price'];
$compare_price = (float)($product['compare_at_price'] ?: ($base_price * 1.35));
$margin_pct = $compare_price > 0 ? round((($compare_price - $base_price) / $compare_price) * 100) : 35;
?>

<div class="container-fluid py-4 cont">
    <!-- Header Navigation & Actions -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom">
        <div class="d-flex flex-wrap align-items-center mb-3 mb-md-0">
            <a href="index.php?q=1" class="btn btn-outline-secondary btn-sm mr-3 mb-2 mb-sm-0" style="border-radius: 8px; font-weight: 600;">
                <i class="fas fa-arrow-left mr-1"></i> Back to Products
            </a>
            <div>
                <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.45rem; letter-spacing: -0.3px;"><?= htmlspecialchars($product['title']) ?></h3>
                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <span class="badge badge-success px-2 py-1"><?= ucfirst($product['status']) ?></span>
                    <span class="text-muted small">SKU Ref: #PROD-<?= $product['id'] ?></span>
                    <span class="text-muted small ml-2"><i class="fas fa-folder mr-1 text-primary"></i> <?= htmlspecialchars($product['category_title'] ?? 'Apparel') ?></span>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
            <a href="../product/<?= urlencode($product['slug']) ?>" target="_blank" class="btn btn-outline-primary btn-sm font-weight-bold" style="border-radius: 8px;">
                <i class="fas fa-external-link-alt mr-1"></i> View on Live Store
            </a>
            <button type="submit" form="productEditorForm" class="btn btn-primary btn-sm font-weight-bold" style="border-radius: 8px; padding: 6px 18px;">
                <i class="fas fa-save mr-1"></i> Save Changes
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if ($save_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($save_msg) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
        <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($error_msg) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <form id="productEditorForm" method="POST">
        <input type="hidden" name="save_product" value="1">
        <div class="row">
            <!-- Left Column: Core Product Info, Copywriting, Variants -->
            <div class="col-lg-8">
                <!-- 1. Title & Description Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-info-circle text-primary mr-2"></i> Product Information
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Product Title</label>
                            <input type="text" name="title" class="form-control font-weight-bold" value="<?= htmlspecialchars($product['title']) ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">URL Handle / Slug</label>
                                <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($product['slug']) ?>" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">Brand / Vendor</label>
                                <input type="text" name="vendor" class="form-control" value="<?= htmlspecialchars($product['vendor'] ?? 'NovaDrop') ?>">
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="font-weight-bold mb-0">Description & Specification Bullets</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="injectAiBullets()">
                                    <i class="fas fa-magic mr-1"></i> AI Benefit Enhancer
                                </button>
                            </div>
                            <textarea name="description" id="productDescField" class="form-control" rows="6"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Pricing & Profit Margin Matrix -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-tag text-success mr-2"></i> Pricing & Margin Economics
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4 form-group mb-3 mb-md-0">
                                <label class="font-weight-bold">Base Selling Price (₹)</label>
                                <input type="number" step="0.01" name="base_price" id="basePriceInput" class="form-control font-weight-bold text-dark" value="<?= $base_price ?>" oninput="recalcMargin()">
                            </div>
                            <div class="col-md-4 form-group mb-3 mb-md-0">
                                <label class="font-weight-bold">Compare-At Price (₹)</label>
                                <input type="number" step="0.01" name="compare_at_price" id="compPriceInput" class="form-control text-muted" value="<?= $compare_price ?>" oninput="recalcMargin()">
                            </div>
                            <div class="col-md-4 text-center">
                                <label class="font-weight-bold text-muted text-uppercase small d-block mb-1">Calculated Gross Margin</label>
                                <span class="badge badge-success px-3 py-2" id="marginBadge" style="font-size: 1.1rem;">
                                    +<?= $margin_pct ?>% Profit
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Variant & Inventory Matrix -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold"><i class="fas fa-boxes text-info mr-2"></i> Variant & Stock Matrix</span>
                        <span class="badge badge-info"><?= count($variants) ?> Active SKUs</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Variant Title</th>
                                        <th>SKU Code</th>
                                        <th>Price</th>
                                        <th>Available Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($variants)): ?>
                                        <?php foreach ($variants as $v): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($v['title']) ?></strong></td>
                                                <td><code><?= htmlspecialchars($v['sku']) ?></code></td>
                                                <td><strong>₹<?= number_format((float)$v['price'], 2) ?></strong></td>
                                                <td>
                                                    <span class="badge <?= ((int)$v['inventory_qty'] > 10) ? 'badge-success' : 'badge-warning' ?>">
                                                        <?= (int)$v['inventory_qty'] ?> units
                                                    </span>
                                                </td>
                                                <td><span class="badge badge-success">In Stock</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td><strong>Standard / Free Size</strong></td>
                                            <td><code>SKU-<?= $pid ?>-STD</code></td>
                                            <td><strong>₹<?= number_format($base_price, 2) ?></strong></td>
                                            <td><span class="badge badge-success">50 units</span></td>
                                            <td><span class="badge badge-success">In Stock</span></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Publishing, Category, SEO -->
            <div class="col-lg-4">
                <!-- Status & Organization -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fas fa-sliders-h text-primary mr-2"></i> Organization & Status
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Catalog Status</label>
                            <select name="status" class="form-control">
                                <option value="active" <?= ($product['status'] === 'active') ? 'selected' : '' ?>>Active (Visible on Store)</option>
                                <option value="draft" <?= ($product['status'] === 'draft') ? 'selected' : '' ?>>Draft (Hidden)</option>
                                <option value="archived" <?= ($product['status'] === 'archived') ? 'selected' : '' ?>>Archived</option>
                            </select>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold">Primary Category / Collection</label>
                            <select name="collection_id" class="form-control">
                                <?php
                                $cats = $conn->query("SELECT * FROM `collections` ORDER BY id ASC");
                                if ($cats && $cats->num_rows > 0) {
                                    while ($c = $cats->fetch_assoc()) {
                                        $sel = ($c['id'] == $product['collection_id']) ? 'selected' : '';
                                        echo "<option value='{$c['id']}' $sel>" . htmlspecialchars($c['title']) . "</option>";
                                    }
                                } else {
                                    echo "<option value='1' selected>Apparel & Lifestyle</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Google Search SEO Snippet Preview -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white font-weight-bold">
                        <i class="fab fa-google text-danger mr-2"></i> Google Search SERP Preview
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">SEO Meta Title</label>
                            <input type="text" name="seo_title" id="seoTitleInput" class="form-control" value="<?= htmlspecialchars($product['seo_title'] ?: $product['title']) ?>" oninput="updateSeoPreview()">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">SEO Meta Description</label>
                            <textarea name="seo_description" id="seoDescInput" class="form-control" rows="3" oninput="updateSeoPreview()"><?= htmlspecialchars($product['seo_description'] ?: substr(strip_tags($product['description']), 0, 150)) ?></textarea>
                        </div>
                        <div class="p-3 border rounded bg-light">
                            <div class="small text-success mb-1">https://novadrop.in/product/<?= htmlspecialchars($product['slug']) ?></div>
                            <div class="font-weight-bold text-primary" id="seoTitlePreview" style="font-size: 1.05rem;"><?= htmlspecialchars($product['seo_title'] ?: $product['title']) ?></div>
                            <div class="small text-muted" id="seoDescPreview"><?= htmlspecialchars($product['seo_description'] ?: 'Shop high-performance apparel and gear with free express delivery.') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function recalcMargin() {
    var base = parseFloat(document.getElementById('basePriceInput').value) || 0;
    var comp = parseFloat(document.getElementById('compPriceInput').value) || (base * 1.35);
    var margin = comp > 0 ? Math.round(((comp - base) / comp) * 100) : 35;
    var badge = document.getElementById('marginBadge');
    if (badge) {
        badge.innerText = '+' + margin + '% Profit';
    }
}

function injectAiBullets() {
    var currentDesc = document.getElementById('productDescField').value;
    var extraAi = "\n\n✦ Key Features & Specifications:\n• Ultra-durable aerospace-grade fabric blend.\n• Ergonomic contours designed for maximum comfort.\n• Moisture-wicking dynamic temperature regulation.\n• Machine washable with color-lock retention.";
    document.getElementById('productDescField').value = currentDesc + extraAi;
}

function updateSeoPreview() {
    var t = document.getElementById('seoTitleInput').value;
    var d = document.getElementById('seoDescInput').value;
    document.getElementById('seoTitlePreview').innerText = t || 'Product Title';
    document.getElementById('seoDescPreview').innerText = d || 'Product description snippet for Google results.';
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>