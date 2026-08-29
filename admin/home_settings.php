<?php
require_once __DIR__ . '/layout_header.php';

// Load current settings
$hs_res = $conn->query("SELECT * FROM `home_settings` WHERE store_id=1 LIMIT 1");
$hs = ($hs_res && $hs_res->num_rows > 0) ? $hs_res->fetch_assoc() : [];

// Load products for picker dropdowns
$prod_res = $conn->query("SELECT id, title, base_price FROM `products` WHERE status='active' ORDER BY id ASC");
$all_products = [];
if ($prod_res) {
    while ($pr = $prod_res->fetch_assoc()) $all_products[] = $pr;
}

$save_msg = $save_err = '';
if (isset($_GET['saved']) && $_GET['saved'] == 1) $save_msg = 'Home page settings saved successfully! Changes are live on the storefront.';
if (isset($_GET['err']))   $save_err = 'Failed to save settings. Please try again.';
?>

<style>
.hs-card { background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:24px; margin-bottom:20px; }
.hs-card h5 { font-weight:700; font-size:15px; color:#111; border-bottom:2px solid #f3f4f6; padding-bottom:10px; margin-bottom:18px; display:flex; align-items:center; gap:8px; }
.hs-card h5 .badge-dot { width:10px;height:10px;border-radius:50%;display:inline-block; }
.hs-toggle { display:flex; align-items:center; gap:10px; }
.hs-toggle input[type=checkbox] { width:40px;height:22px;cursor:pointer;accent-color:#a16207; }
.hs-form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
@media(max-width:600px){ .hs-form-row { grid-template-columns:1fr; } }
</style>

<div class="container-fluid py-4">

  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 style="font-size:22px;font-weight:800;color:#111;margin:0;">Home Page Settings</h2>
      <p class="text-muted mb-0" style="font-size:13px;">All changes are reflected live on the storefront immediately after saving.</p>
    </div>
    <a href="../shop" target="_blank" class="btn btn-outline-dark btn-sm">Open Live Store</a>
  </div>

  <?php if ($save_msg): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <strong>Saved!</strong> <?= htmlspecialchars($save_msg) ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
  <?php endif; ?>

  <?php if ($save_err): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($save_err) ?></div>
  <?php endif; ?>

  <form method="POST" action="update.php?q=homesettings" id="homeSettingsForm">

    <!-- Announcement Bar -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#f59e0b;"></span> Announcement Bar (Top Strip)</h5>
      <div class="hs-toggle mb-3">
        <input type="checkbox" name="announcement_enabled" id="ann_en" value="1" <?= !empty($hs['announcement_enabled']) ? 'checked' : '' ?>>
        <label for="ann_en" class="mb-0 font-weight-bold" style="cursor:pointer;">Enable Announcement Bar</label>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Announcement Text</label>
        <input type="text" name="announcement_text" class="form-control"
               value="<?= htmlspecialchars($hs['announcement_text'] ?? 'Complimentary White-Glove Express Dispatch on All Pieces · Apply VIP Code: LUMINA50') ?>"
               placeholder="e.g. Free shipping on orders above 999 Â· Apply VIP Code: SAVE20">
        <small class="text-muted">To show a copy-able VIP code, include: <code>Apply VIP Code: YOUR_CODE</code> in the text</small>
      </div>
      <div class="hs-form-row">
        <div class="form-group">
          <label class="font-weight-bold">Background Color</label>
          <input type="color" name="announcement_bg_color" class="form-control" style="width:60px;height:38px;padding:2px;"
                 value="<?= htmlspecialchars($hs['announcement_bg_color'] ?? '#0a0b0e') ?>">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Text / Accent Color</label>
          <input type="color" name="announcement_text_color" class="form-control" style="width:60px;height:38px;padding:2px;"
                 value="<?= htmlspecialchars($hs['announcement_text_color'] ?? '#e9c176') ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Announcement Link URL <span class="text-muted font-weight-normal">(optional)</span></label>
        <input type="text" name="announcement_link" class="form-control"
               value="<?= htmlspecialchars($hs['announcement_link'] ?? '') ?>" placeholder="e.g. /shop">
      </div>
    </div>

    <!-- Hero Section -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#6366f1;"></span> Hero Section (Main Banner)</h5>
      <div class="form-group">
        <label class="font-weight-bold">Hero Label Badge</label>
        <input type="text" name="hero_label" class="form-control"
               value="<?= htmlspecialchars($hs['hero_label'] ?? 'Exclusive VIP Release Â· Live Catalog') ?>">
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Hero Headline</label>
        <input type="text" name="hero_headline" class="form-control"
               value="<?= htmlspecialchars($hs['hero_headline'] ?? 'Form Without Compromise.') ?>">
        <small class="text-muted">The last word (before a period) gets styled in italic gold automatically.</small>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Hero Body Text</label>
        <textarea name="hero_body" class="form-control" rows="3"><?= htmlspecialchars($hs['hero_body'] ?? 'An architectural study in pure double-faced Mongolian cashmere, 14.5oz Okayama selvedge denim, and bespoke Italian tailoring.') ?></textarea>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Hero Background Image URL</label>
        <input type="text" name="hero_bg_image" class="form-control" id="heroBgInput"
               value="<?= htmlspecialchars($hs['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920&q=85') ?>"
               oninput="updateHeroPreview(this.value)">
        <small class="text-muted">Enter Unsplash URL or path like <code>/Dropshipping/img/filename.jpg</code></small>
        <div id="heroBgPreview" style="margin-top:8px;height:70px;border-radius:8px;background-size:cover;background-position:center;border:1px solid #ddd;display:flex;align-items:center;padding:12px;">
          <span style="color:#e9c176;font-weight:700;font-size:12px;text-shadow:0 1px 4px #000">Hero Preview</span>
        </div>
      </div>
      <div class="hs-form-row">
        <div class="form-group">
          <label class="font-weight-bold">CTA Button Text</label>
          <input type="text" name="hero_cta_text" class="form-control"
                 value="<?= htmlspecialchars($hs['hero_cta_text'] ?? 'Explore Boutique') ?>">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">CTA Button URL</label>
          <input type="text" name="hero_cta_url" class="form-control"
                 value="<?= htmlspecialchars($hs['hero_cta_url'] ?? '/shop') ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Hero Featured Product (right card)</label>
        <select name="hero_product_id" class="form-control">
          <option value="">-- Auto (first featured product) --</option>
          <?php


foreach ($all_products as $p): ?>
            <option value="<?= $p['id'] ?>" <?= ($hs['hero_product_id'] ?? '') == $p['id'] ? 'selected' : '' ?>>
              #<?= $p['id'] ?> â€” <?= htmlspecialchars($p['title']) ?> (&#8377;<?= number_format($p['base_price']) ?>)
            </option>
          <?php


endforeach; ?>
        </select>
      </div>
    </div>

    <!-- Flash Deals -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#ef4444;"></span> Flash Deals Section</h5>
      <div class="hs-toggle mb-3">
        <input type="checkbox" name="flash_section_enabled" id="flash_en" value="1" <?= !empty($hs['flash_section_enabled']) ? 'checked' : '' ?>>
        <label for="flash_en" class="mb-0 font-weight-bold" style="cursor:pointer;">Show Flash Deals Section</label>
      </div>
      <div class="hs-form-row">
        <div class="form-group">
          <label class="font-weight-bold">Section Title</label>
          <input type="text" name="flash_section_title" class="form-control"
                 value="<?= htmlspecialchars($hs['flash_section_title'] ?? "Today's VIP Flash Deals.") ?>">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Flash Timer Hours</label>
          <input type="number" name="flash_timer_hours" class="form-control" min="1" max="72"
                 value="<?= (int)($hs['flash_timer_hours'] ?? 7) ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Section Subtitle</label>
        <input type="text" name="flash_section_subtitle" class="form-control"
               value="<?= htmlspecialchars($hs['flash_section_subtitle'] ?? 'These curated atelier pieces are available at privilege pricing for members only.') ?>">
      </div>
      <div class="alert alert-info mb-0" style="font-size:13px;">
        Products with a Compare-At Price higher than base price appear as flash deals. <a href="index.php?q=1">Set prices in Products</a>.
      </div>
    </div>

    <!-- Featured Products -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#10b981;"></span> Featured Products Section</h5>
      <div class="hs-toggle mb-3">
        <input type="checkbox" name="featured_section_enabled" id="feat_en" value="1" <?= !empty($hs['featured_section_enabled']) ? 'checked' : '' ?>>
        <label for="feat_en" class="mb-0 font-weight-bold" style="cursor:pointer;">Show Featured Products Grid</label>
      </div>
      <div class="hs-form-row">
        <div class="form-group">
          <label class="font-weight-bold">Section Title</label>
          <input type="text" name="featured_section_title" class="form-control"
                 value="<?= htmlspecialchars($hs['featured_section_title'] ?? 'Curated Wardrobe') ?>">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Section Subtitle</label>
          <input type="text" name="featured_section_subtitle" class="form-control"
                 value="<?= htmlspecialchars($hs['featured_section_subtitle'] ?? 'The Current Collection') ?>">
        </div>
      </div>
    </div>

    <!-- New Arrivals -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#8b5cf6;"></span> New Arrivals Section</h5>
      <div class="hs-toggle mb-3">
        <input type="checkbox" name="arrivals_section_enabled" id="arr_en" value="1" <?= !empty($hs['arrivals_section_enabled']) ? 'checked' : '' ?>>
        <label for="arr_en" class="mb-0 font-weight-bold" style="cursor:pointer;">Show New Arrivals Section</label>
      </div>
      <div class="hs-form-row">
        <div class="form-group">
          <label class="font-weight-bold">Section Title</label>
          <input type="text" name="arrivals_section_title" class="form-control"
                 value="<?= htmlspecialchars($hs['arrivals_section_title'] ?? 'Just Arrived in the Atelier') ?>">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Section Subtitle</label>
          <input type="text" name="arrivals_section_subtitle" class="form-control"
                 value="<?= htmlspecialchars($hs['arrivals_section_subtitle'] ?? 'Explore signature silhouettes crafted from raw organic fibers.') ?>">
        </div>
      </div>
    </div>

    <!-- Sticky Bar -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#0ea5e9;"></span> Sticky Bottom Buy Bar</h5>
      <div class="hs-toggle mb-3">
        <input type="checkbox" name="sticky_bar_enabled" id="sticky_en" value="1" <?= !empty($hs['sticky_bar_enabled']) ? 'checked' : '' ?>>
        <label for="sticky_en" class="mb-0 font-weight-bold" style="cursor:pointer;">Show Sticky Bottom Bar</label>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Featured Product in Sticky Bar</label>
        <select name="sticky_bar_product_id" class="form-control">
          <option value="">-- Auto (first featured product) --</option>
          <?php


foreach ($all_products as $p): ?>
            <option value="<?= $p['id'] ?>" <?= ($hs['sticky_bar_product_id'] ?? '') == $p['id'] ? 'selected' : '' ?>>
              #<?= $p['id'] ?> â€” <?= htmlspecialchars($p['title']) ?> (&#8377;<?= number_format($p['base_price']) ?>)
            </option>
          <?php


endforeach; ?>
        </select>
      </div>
    </div>

    <!-- WhatsApp -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#25d366;"></span> WhatsApp Concierge Button</h5>
      <div class="hs-toggle mb-3">
        <input type="checkbox" name="whatsapp_enabled" id="wa_en" value="1" <?= !empty($hs['whatsapp_enabled']) ? 'checked' : '' ?>>
        <label for="wa_en" class="mb-0 font-weight-bold" style="cursor:pointer;">Show WhatsApp Button</label>
      </div>
      <div class="hs-form-row">
        <div class="form-group">
          <label class="font-weight-bold">WhatsApp Number (with country code, no +)</label>
          <input type="text" name="whatsapp_number" class="form-control"
                 value="<?= htmlspecialchars($hs['whatsapp_number'] ?? '919999999999') ?>"
                 placeholder="919876543210">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Auto-Message</label>
          <input type="text" name="whatsapp_message" class="form-control"
                 value="<?= htmlspecialchars($hs['whatsapp_message'] ?? 'Hi! I found your store and need help.') ?>">
        </div>
      </div>
    <!-- Brand & Global Storefront Identity -->
    <div class="hs-card">
      <h5><span class="badge-dot" style="background:#4361ee;"></span> Brand & Global Storefront Identity</h5>
      <div class="hs-form-row">
        <div class="form-group">
          <label class="font-weight-bold">Brand / Store Name</label>
          <input type="text" name="brand_name" class="form-control"
                 value="<?= htmlspecialchars($hs['brand_name'] ?? 'LUMINA') ?>"
                 placeholder="LUMINA">
        </div>
        <div class="form-group">
          <label class="font-weight-bold">Concierge Contact Email</label>
          <input type="email" name="contact_email" class="form-control"
                 value="<?= htmlspecialchars($hs['contact_email'] ?? 'concierge@lumina-atelier.com') ?>"
                 placeholder="concierge@lumina-atelier.com">
        </div>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Brand Tagline / Mission Text (Shown in Footer)</label>
        <textarea name="brand_tagline" class="form-control" rows="2"><?= htmlspecialchars($hs['brand_tagline'] ?? 'Curated luxury garments and architectural objects for the considered space. Designed with intention, crafted to last.') ?></textarea>
      </div>
      <div class="form-group">
        <label class="font-weight-bold">Footer Copyright Notice</label>
        <input type="text" name="copyright_text" class="form-control"
               value="<?= htmlspecialchars($hs['copyright_text'] ?? 'Â© 2026 LUMINA ATELIER COLLECTIVE. ALL RIGHTS RESERVED.') ?>">
      </div>
    </div>

    <!-- Save -->
    <div style="position:sticky;bottom:0;background:#fff;border-top:1px solid #e5e7eb;padding:16px 0;z-index:100;display:flex;gap:12px;align-items:center;">

      <button type="submit" class="btn btn-lg font-weight-bold px-5" style="background:#a16207;border:none;color:#fff;border-radius:8px;">
        Save All Home Page Settings
      </button>
      <a href="../shop" target="_blank" class="btn btn-outline-secondary">Open Live Storefront</a>
    </div>

  </form>
</div>

<script>
function updateHeroPreview(url) {
  const preview = document.getElementById('heroBgPreview');
  if (preview && url) preview.style.backgroundImage = "url('" + url + "')";
}
document.addEventListener('DOMContentLoaded', function() {
  const heroInput = document.getElementById('heroBgInput');
  if (heroInput && heroInput.value) updateHeroPreview(heroInput.value);
});
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
