<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── Appearance Settings Premium UI ── */
.app-wrapper {
  padding-top: 10px;
  max-width: 1440px;
  margin: 0 auto;
}
.app-hero {
  background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 24px rgba(30, 41, 59, 0.15);
}
.app-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 10px rgba(0,0,0,.04);
  background: #fff;
  overflow: hidden;
}
.app-card .card-header {
  background: #fff;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 20px;
  font-weight: 700;
  color: #1e293b;
}
.live-preview-box {
  border-radius: 14px;
  border: 2px dashed #cbd5e1;
  background: #f8fafc;
  overflow: hidden;
  position: sticky;
  top: 90px;
  z-index: 10;
}
.preview-announcement {
  background: #4f46e5;
  color: #fff;
  font-size: .8rem;
  font-weight: 600;
  text-align: center;
  padding: 8px 12px;
  transition: all .2s ease;
}
.preview-nav {
  background: #fff;
  padding: 14px 18px;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.preview-hero {
  padding: 32px 20px;
  text-align: center;
  background: linear-gradient(180deg, #f1f5f9 0%, #fff 100%);
  transition: all .2s ease;
}
.palette-chip {
  cursor: pointer;
  border-radius: 10px;
  padding: 8px 14px;
  border: 1.5px solid #e2e8f0;
  display: flex;
  align-items: center;
  gap: 8px;
  background: #fff;
  transition: all .15s ease;
  user-select: none;
}
.palette-chip:hover {
  border-color: #6366f1;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
}
.color-dot {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: inline-block;
  box-shadow: inset 0 0 0 1px rgba(0,0,0,.1);
}
@media (max-width: 991px) {
  .live-preview-box { position: static; margin-top: 1.5rem; }
}
</style>

<div class="container-fluid px-3 px-md-4 py-3 app-wrapper">

  <!-- Hero Header -->
  <div class="app-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.75rem;">🎨</span>
        <h3 class="fw-bold mb-0 text-white font-weight-bold">Store Appearance &amp; Branding</h3>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Customize brand colors, store typography, hero banners, and announcement identity across the live store</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/settings/hero') ?>" class="btn btn-warning btn-sm font-weight-bold px-3 shadow-sm text-dark" style="border-radius:8px;background:#e9c176;border-color:#e9c176;">
        <i class="fa fa-film mr-1"></i> 🎬 Hero Slider &amp; Video Backgrounds
      </a>
      <a href="<?= base_url() ?>" target="_blank" class="btn btn-light btn-sm font-weight-bold px-3 shadow-sm" style="border-radius:8px;">
        <i class="fa fa-external-link-alt mr-1"></i> View Live Store
      </a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Theme Preset Palettes -->
  <div class="app-card p-3 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
      <span class="small font-weight-bold text-dark"><i class="fa fa-magic text-primary mr-1"></i> 1-Click Designer Color Palettes:</span>
      <span class="text-muted small">Click any preset to apply directly</span>
    </div>
    <div class="d-flex flex-wrap gap-2">
      <div class="palette-chip" onclick="applyPalette('#4f46e5', '#10b981')">
        <span class="color-dot" style="background:#4f46e5;"></span>
        <span class="color-dot" style="background:#10b981;"></span>
        <span class="small font-weight-bold">Modern Indigo</span>
      </div>
      <div class="palette-chip" onclick="applyPalette('#059669', '#f59e0b')">
        <span class="color-dot" style="background:#059669;"></span>
        <span class="color-dot" style="background:#f59e0b;"></span>
        <span class="small font-weight-bold">Emerald &amp; Amber</span>
      </div>
      <div class="palette-chip" onclick="applyPalette('#e11d48', '#8b5cf6')">
        <span class="color-dot" style="background:#e11d48;"></span>
        <span class="color-dot" style="background:#8b5cf6;"></span>
        <span class="small font-weight-bold">Rose &amp; Violet</span>
      </div>
      <div class="palette-chip" onclick="applyPalette('#0284c7', '#14b8a6')">
        <span class="color-dot" style="background:#0284c7;"></span>
        <span class="color-dot" style="background:#14b8a6;"></span>
        <span class="small font-weight-bold">Oceanic Cyan</span>
      </div>
      <div class="palette-chip" onclick="applyPalette('#18181b', '#f97316')">
        <span class="color-dot" style="background:#18181b;"></span>
        <span class="color-dot" style="background:#f97316;"></span>
        <span class="small font-weight-bold">Cyber Obsidian</span>
      </div>
    </div>
  </div>

  <form method="post" action="<?= base_url('admin/settings/appearance') ?>" id="appearanceForm">
    <?= csrf_field() ?>
    <div class="row g-4">
      
      <!-- Settings Form -->
      <div class="col-lg-7">
        <div class="app-card mb-4">
          <div class="card-header">
            <i class="fa fa-store text-primary mr-2"></i>Branding &amp; Store Identity
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-sm-6 form-group">
                <label class="font-weight-bold small">Store Name *</label>
                <input type="text" id="inputStoreName" name="store_name" class="form-control" value="<?= htmlspecialchars($settings['store_name'] ?? 'NovaDrop') ?>" required oninput="updateLivePreview()">
              </div>
              <div class="col-sm-6 form-group">
                <label class="font-weight-bold small">Brand Tagline</label>
                <input type="text" id="inputTagline" name="tagline" class="form-control" value="<?= htmlspecialchars($settings['tagline'] ?? 'Next-Gen E-Commerce') ?>" oninput="updateLivePreview()">
              </div>

              <div class="col-12 form-group">
                <label class="font-weight-bold small">Homepage Hero Headline</label>
                <input type="text" id="inputHeroTitle" name="hero_title" class="form-control" value="<?= htmlspecialchars($settings['hero_title'] ?? 'Discover Trending Products') ?>" oninput="updateLivePreview()">
              </div>

              <div class="col-12 form-group">
                <label class="font-weight-bold small">Hero Sub-headline / Mission</label>
                <input type="text" id="inputHeroSubtitle" name="hero_subtitle" class="form-control" value="<?= htmlspecialchars($settings['hero_subtitle'] ?? 'Curated products with fast delivery across India') ?>" oninput="updateLivePreview()">
              </div>

              <div class="col-sm-6 form-group">
                <label class="font-weight-bold small">Primary Brand Color</label>
                <div class="input-group">
                  <input type="color" id="inputPrimaryColor" name="primary_color" class="form-control form-control-color" value="<?= !empty($settings['primary_color']) && $settings['primary_color'] !== '#ff00f7' ? $settings['primary_color'] : '#4f46e5' ?>" style="max-width:55px;height:42px;padding:4px;" onchange="updateLivePreview()">
                  <input type="text" id="inputPrimaryText" class="form-control font-mono" value="<?= !empty($settings['primary_color']) && $settings['primary_color'] !== '#ff00f7' ? $settings['primary_color'] : '#4f46e5' ?>" oninput="syncColor('inputPrimaryColor', this.value)">
                </div>
              </div>

              <div class="col-sm-6 form-group">
                <label class="font-weight-bold small">Accent Highlight Color</label>
                <div class="input-group">
                  <input type="color" id="inputAccentColor" name="accent_color" class="form-control form-control-color" value="<?= !empty($settings['accent_color']) && $settings['accent_color'] !== '#ff00f7' ? $settings['accent_color'] : '#10b981' ?>" style="max-width:55px;height:42px;padding:4px;" onchange="updateLivePreview()">
                  <input type="text" id="inputAccentText" class="form-control font-mono" value="<?= !empty($settings['accent_color']) && $settings['accent_color'] !== '#ff00f7' ? $settings['accent_color'] : '#10b981' ?>" oninput="syncColor('inputAccentColor', this.value)">
                </div>
              </div>

              <div class="col-12 form-group">
                <label class="font-weight-bold small">Announcement Banner Bar Text</label>
                <input type="text" id="inputAnnounceBar" name="announcement_bar" class="form-control" value="<?= htmlspecialchars($settings['announcement_bar'] ?? '🔥 Free Express Shipping on prepaid orders above ₹499!') ?>" placeholder="e.g. Free delivery on orders over ₹499" oninput="updateLivePreview()">
              </div>

              <div class="col-12 form-group">
                <label class="font-weight-bold small">Footer Copyright Notice</label>
                <input type="text" name="footer_text" class="form-control" value="<?= htmlspecialchars($settings['footer_text'] ?? '© 2026 NovaDrop Inc. All rights reserved.') ?>">
              </div>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm" style="border-radius:8px;">
              <i class="fa fa-save mr-1"></i> Save Appearance Changes
            </button>
          </div>
        </div>
      </div>

      <!-- Live Storefront Preview -->
      <div class="col-lg-5">
        <div class="live-preview-box shadow-sm">
          <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center">
            <span class="small font-weight-bold text-muted"><i class="fa fa-eye text-primary mr-1"></i> Live Real-Time Preview</span>
            <span class="badge badge-success px-2 py-1">Interactive</span>
          </div>

          <!-- Preview: Announcement -->
          <div id="prevAnnounce" class="preview-announcement">
            🔥 Free Express Shipping on prepaid orders above ₹499!
          </div>

          <!-- Preview: Nav Header -->
          <div class="preview-nav">
            <div class="d-flex align-items-center gap-2">
              <span id="prevBrandDot" class="rounded-circle d-inline-block" style="width:14px;height:14px;background:#4f46e5;"></span>
              <strong id="prevStoreName" style="font-size:1.05rem;color:#0f172a;">NovaDrop</strong>
            </div>
            <div class="d-flex gap-2 align-items-center">
              <span class="badge badge-light border small">Shop</span>
              <span id="prevCartBadge" class="btn btn-sm text-white font-weight-bold py-0 px-2" style="background:#4f46e5;border-radius:6px;font-size:.75rem;">Cart (0)</span>
            </div>
          </div>

          <!-- Preview: Hero Banner -->
          <div class="preview-hero">
            <span id="prevTagline" class="badge px-2.5 py-1 mb-2 font-weight-bold" style="background:#e0e7ff;color:#4f46e5;font-size:.72rem;">Next-Gen E-Commerce</span>
            <h4 id="prevHeroTitle" class="fw-bold text-dark mb-1 font-weight-bold" style="font-size:1.25rem;">Discover Trending Products</h4>
            <p id="prevHeroSubtitle" class="text-muted small mb-3" style="max-width:320px;margin:0 auto;">Curated products with fast delivery across India</p>
            <button type="button" id="prevHeroBtn" class="btn btn-sm text-white font-weight-bold px-3 shadow-sm" style="background:#4f46e5;border-radius:8px;">
              Explore Drop &rarr;
            </button>
          </div>

          <!-- Preview: Product Card Sample -->
          <div class="p-3 bg-white border-top">
            <div class="d-flex align-items-center gap-3 p-2 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
              <div style="font-size:1.8rem;background:#fff;padding:4px 10px;border-radius:8px;border:1px solid #e2e8f0;">👕</div>
              <div class="flex-grow-1">
                <div class="fw-bold small text-dark">Oversized Streetwear Tee</div>
                <div class="text-muted" style="font-size:.75rem;"><del>₹1,299</del> <strong class="text-success font-weight-bold">₹799</strong></div>
              </div>
              <button type="button" id="prevCardBtn" class="btn btn-sm text-white px-2 py-1" style="background:#10b981;border-radius:6px;font-size:.75rem;">
                + Add
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </form>

</div>

<script>
function updateLivePreview() {
  var name = document.getElementById('inputStoreName').value || 'NovaDrop';
  var tagline = document.getElementById('inputTagline').value || 'Next-Gen E-Commerce';
  var title = document.getElementById('inputHeroTitle').value || 'Discover Trending Products';
  var sub = document.getElementById('inputHeroSubtitle').value || 'Curated products with fast delivery across India';
  var bar = document.getElementById('inputAnnounceBar').value || '🔥 Free Express Shipping on prepaid orders above ₹499!';
  var prim = document.getElementById('inputPrimaryColor').value || '#4f46e5';
  var acc = document.getElementById('inputAccentColor').value || '#10b981';

  document.getElementById('prevStoreName').innerText = name;
  document.getElementById('prevTagline').innerText = tagline;
  document.getElementById('prevHeroTitle').innerText = title;
  document.getElementById('prevHeroSubtitle').innerText = sub;
  document.getElementById('prevAnnounce').innerText = bar;

  // Colors
  document.getElementById('prevAnnounce').style.background = prim;
  document.getElementById('prevBrandDot').style.background = prim;
  document.getElementById('prevCartBadge').style.background = prim;
  document.getElementById('prevHeroBtn').style.background = prim;
  document.getElementById('prevTagline').style.color = prim;
  document.getElementById('prevTagline').style.background = prim + '1a';
  document.getElementById('prevCardBtn').style.background = acc;

  document.getElementById('inputPrimaryText').value = prim;
  document.getElementById('inputAccentText').value = acc;
}

function syncColor(colorId, val) {
  if (val.match(/^#[0-9A-Fa-f]{6}$/)) {
    document.getElementById(colorId).value = val;
    updateLivePreview();
  }
}

function applyPalette(primary, accent) {
  document.getElementById('inputPrimaryColor').value = primary;
  document.getElementById('inputPrimaryText').value = primary;
  document.getElementById('inputAccentColor').value = accent;
  document.getElementById('inputAccentText').value = accent;
  updateLivePreview();
}

document.addEventListener('DOMContentLoaded', updateLivePreview);
</script>
