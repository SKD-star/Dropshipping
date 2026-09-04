<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.hero-admin-wrap {
  max-width: 1440px;
  margin: 0 auto;
  padding-top: 10px;
}
.hero-dash-card {
  background: linear-gradient(135deg, #090a0f 0%, #171923 50%, #232738 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 30px rgba(0,0,0,0.25);
  border: 1px solid rgba(233,193,118,0.2);
}
.slide-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #fff;
  transition: all 0.2s ease;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.03);
}
.slide-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  border-color: #cbd5e1;
}
.media-preview-container {
  position: relative;
  width: 100%;
  aspect-ratio: 16/9;
  background: #0f172a;
  overflow: hidden;
}
.media-preview-container img,
.media-preview-container video {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.media-type-badge {
  position: absolute;
  top: 10px;
  left: 10px;
  background: rgba(0,0,0,0.75);
  backdrop-filter: blur(8px);
  color: #fff;
  padding: 4px 10px;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  border: 1px solid rgba(255,255,255,0.2);
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.media-type-badge.video {
  border-color: rgba(233,193,118,0.5);
  color: #f3d38e;
}
</style>

<div class="container-fluid px-3 px-md-4 py-3 hero-admin-wrap">

  <!-- Header Banner -->
  <div class="hero-dash-card d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.85rem;">🎬</span>
        <h3 class="fw-bold mb-0 text-white font-weight-bold">Hero Slider &amp; Background Video Engine</h3>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Manage multiple homepage carousel slides, high-definition background runway video loops, and editorial campaign imagery.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-light btn-sm font-weight-bold px-3" style="border-radius:8px;">
        <i class="fa fa-external-link-alt mr-1"></i> View Live Store
      </a>
      <button type="button" class="btn btn-warning btn-sm font-weight-bold px-3 shadow-sm text-dark" style="border-radius:8px;background:#e9c176;border-color:#e9c176;" onclick="openSlideModal('create')">
        <i class="fa fa-plus-circle mr-1"></i> Add New Slide
      </button>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Summary Stats Bar -->
  <?php
    $total_slides = count($slides);
    $active_slides = count(array_filter($slides, fn($s) => !empty($s['is_active'])));
    $video_slides = count(array_filter($slides, fn($s) => ($s['media_type'] ?? '') === 'video'));
  ?>
  <div class="row g-3 mb-4">
    <div class="col-sm-4">
      <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between shadow-sm">
        <div>
          <div class="text-muted small font-weight-bold">TOTAL SLIDES</div>
          <div class="h4 font-weight-bold mb-0 text-dark"><?= $total_slides ?></div>
        </div>
        <div class="p-3 rounded-circle bg-light text-primary" style="font-size:1.3rem;">🎞️</div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between shadow-sm">
        <div>
          <div class="text-muted small font-weight-bold">ACTIVE ON STOREFRONT</div>
          <div class="h4 font-weight-bold mb-0 text-success"><?= $active_slides ?></div>
        </div>
        <div class="p-3 rounded-circle bg-light text-success" style="font-size:1.3rem;">✅</div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="p-3 bg-white rounded-3 border d-flex align-items-center justify-content-between shadow-sm">
        <div>
          <div class="text-muted small font-weight-bold">VIDEO BACKGROUNDS</div>
          <div class="h4 font-weight-bold mb-0 text-warning"><?= $video_slides ?></div>
        </div>
        <div class="p-3 rounded-circle bg-light text-warning" style="font-size:1.3rem;">🎥</div>
      </div>
    </div>
  </div>

  <!-- Slides List -->
  <div class="row g-4">
    <?php if (empty($slides)): ?>
      <div class="col-12 text-center py-5 bg-white rounded-3 border">
        <div style="font-size:3rem;" class="mb-3">🎬</div>
        <h5 class="text-dark font-weight-bold">No Hero Slides Configured</h5>
        <p class="text-muted small mb-3">Add your first slide with a background video or image to launch your storefront carousel.</p>
        <button type="button" class="btn btn-warning btn-sm font-weight-bold px-4" onclick="openSlideModal('create')">
          <i class="fa fa-plus mr-1"></i> Add First Slide
        </button>
      </div>
    <?php else: ?>
      <?php foreach ($slides as $idx => $s): ?>
        <div class="col-md-6 col-lg-4">
          <div class="slide-card h-100 d-flex flex-col justify-content-between">
            <div>
              <!-- Media Preview -->
              <div class="media-preview-container">
                <?php if ($s['media_type'] === 'video' && !empty($s['video_url'])): ?>
                  <video autoplay muted loop playsinline poster="<?= !empty($s['image_url']) ? (str_starts_with($s['image_url'], 'http') ? $s['image_url'] : base_url($s['image_url'])) : '' ?>">
                    <source src="<?= str_starts_with($s['video_url'], 'http') ? $s['video_url'] : base_url($s['video_url']) ?>" type="video/webm">
                    <source src="<?= str_starts_with($s['video_url'], 'http') ? $s['video_url'] : base_url($s['video_url']) ?>" type="video/mp4">
                  </video>
                  <span class="media-type-badge video">
                    <i class="fa fa-video"></i> Video Loop
                  </span>
                <?php else: ?>
                  <img src="<?= !empty($s['image_url']) ? (str_starts_with($s['image_url'], 'http') ? $s['image_url'] : base_url($s['image_url'])) : base_url('assets/img/editorial_runway_hero.jpg') ?>" alt="<?= htmlspecialchars($s['title_main']) ?>">
                  <span class="media-type-badge">
                    <i class="fa fa-image"></i> Image
                  </span>
                <?php endif; ?>

                <!-- Order Badge -->
                <div class="position-absolute" style="top:10px;right:10px;">
                  <span class="badge badge-dark px-2 py-1" style="background:rgba(0,0,0,0.7);backdrop-filter:blur(6px);font-size:0.75rem;">
                    #<?= $idx + 1 ?> (Order: <?= (int)$s['sort_order'] ?>)
                  </span>
                </div>
              </div>

              <!-- Card Body Content -->
              <div class="p-3">
                <div class="text-warning small font-weight-bold font-mono text-uppercase mb-1" style="font-size:0.72rem;letter-spacing:1px;">
                  <?= htmlspecialchars($s['badge']) ?>
                </div>
                <h5 class="font-weight-bold text-dark mb-1">
                  <?= htmlspecialchars($s['title_main']) ?>
                  <span class="text-muted font-italic"><?= htmlspecialchars($s['title_accent']) ?></span>
                </h5>
                <p class="text-muted small mb-3 text-truncate-2" style="font-size:0.8rem;line-height:1.4;max-height:2.8em;overflow:hidden;">
                  <?= htmlspecialchars($s['subtitle']) ?>
                </p>

                <div class="d-flex align-items-center gap-2 flex-wrap small text-muted border-top pt-2">
                  <span><strong>Primary:</strong> <?= htmlspecialchars($s['cta_text']) ?></span>
                  <span>·</span>
                  <span><strong>Secondary:</strong> <?= htmlspecialchars($s['secondary_text']) ?></span>
                </div>
              </div>
            </div>

            <!-- Footer Controls -->
            <div class="p-3 bg-light border-top d-flex align-items-center justify-content-between">
              <!-- Visibility Toggle -->
              <form method="post" action="<?= base_url('admin/settings/hero') ?>" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                <button type="submit" class="btn btn-sm <?= !empty($s['is_active']) ? 'btn-success' : 'btn-secondary' ?> py-1 px-2.5 font-weight-bold" style="border-radius:6px;font-size:0.75rem;">
                  <i class="fa <?= !empty($s['is_active']) ? 'fa-eye' : 'fa-eye-slash' ?> mr-1"></i>
                  <?= !empty($s['is_active']) ? 'Active' : 'Hidden' ?>
                </button>
              </form>

              <!-- Edit & Delete -->
              <div class="d-flex gap-1">
                <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2.5 font-weight-bold" style="border-radius:6px;" onclick='openSlideModal("edit", <?= json_encode($s) ?>)'>
                  <i class="fa fa-edit mr-1"></i> Edit
                </button>
                <form method="post" action="<?= base_url('admin/settings/hero') ?>" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this hero slide?');">
                  <?= csrf_field() ?>
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $s['id'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" style="border-radius:6px;" title="Delete Slide">
                    <i class="fa fa-trash"></i>
                  </button>
                </form>
              </div>
            </div>

          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>

<!-- Modal: Add / Edit Slide -->
<div class="modal fade" id="slideModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
      <form method="post" action="<?= base_url('admin/settings/hero') ?>" enctype="multipart/form-data" id="slideForm">
        <?= csrf_field() ?>
        <input type="hidden" name="action" id="formAction" value="create">
        <input type="hidden" name="id" id="formId" value="0">

        <div class="modal-header bg-dark text-white p-3 px-4">
          <h5 class="modal-title font-weight-bold" id="modalTitle">🎬 Add New Hero Slide</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body p-4">
          <div class="row g-3">
            
            <!-- Quick Presets -->
            <div class="col-12 mb-1">
              <div class="d-flex flex-wrap align-items-center justify-content-between p-2.5 px-3 bg-light rounded-3 border">
                <span class="small font-weight-bold text-muted">⚡ Quick Load Template:</span>
                <div class="btn-group btn-group-sm mt-1 mt-sm-0">
                  <button type="button" class="btn btn-outline-dark font-weight-bold" onclick="loadTemplate('runway')">🎬 Runway Video</button>
                  <button type="button" class="btn btn-warning text-dark font-weight-bold" onclick="loadTemplate('discount')">🏷️ 50% Off VIP Sale</button>
                  <button type="button" class="btn btn-outline-secondary" onclick="loadTemplate('silk')">✨ Silk Archive</button>
                </div>
              </div>
            </div>

            <!-- Slide Titles -->
            <div class="col-sm-6 form-group">
              <label class="font-weight-bold small">Main Headline *</label>
              <input type="text" name="title_main" id="inputTitleMain" class="form-control" placeholder="e.g. Couture in Motion." required>
            </div>
            <div class="col-sm-6 form-group">
              <label class="font-weight-bold small">Italic Gold Accent *</label>
              <input type="text" name="title_accent" id="inputTitleAccent" class="form-control" placeholder="e.g. Bespoke Form." required>
            </div>

            <div class="col-12 form-group">
              <label class="font-weight-bold small">Top Label / Prestige Badge</label>
              <input type="text" name="badge" id="inputBadge" class="form-control" placeholder="e.g. Autumn / Winter 2026 Archive · Runway Edition | Milan · Tokyo">
            </div>

            <div class="col-12 form-group">
              <label class="font-weight-bold small">Narrative Subtitle / Description</label>
              <textarea name="subtitle" id="inputSubtitle" class="form-control" rows="2" placeholder="An architectural curation of double-faced Mongolian cashmere..."></textarea>
            </div>

            <!-- Media Type Selector -->
            <div class="col-12 form-group">
              <label class="font-weight-bold small">Background Media Type *</label>
              <div class="d-flex gap-3">
                <div class="custom-control custom-radio">
                  <input type="radio" id="mediaVideo" name="media_type" value="video" class="custom-control-input" checked onchange="toggleMediaInputs()">
                  <label class="custom-control-label font-weight-bold" for="mediaVideo">🎥 High-Definition Video Loop (Recommended)</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="mediaImage" name="media_type" value="image" class="custom-control-input" onchange="toggleMediaInputs()">
                  <label class="custom-control-label font-weight-bold" for="mediaImage">🖼️ Static High-Res Editorial Image</label>
                </div>
              </div>
            </div>

            <!-- Video Section -->
            <div id="videoInputs" class="col-12 bg-light p-3 rounded-3 border mb-3">
              <div class="row g-2">
                <div class="col-sm-6 form-group mb-2">
                  <label class="font-weight-bold small">Video File URL or Path (.mp4 / .webm)</label>
                  <input type="text" name="video_url" id="inputVideoUrl" class="form-control form-control-sm font-mono" placeholder="assets/videos/runway_editorial_loop.webm">
                  <small class="text-muted">Local file path or online CDN URL</small>
                </div>
                <div class="col-sm-6 form-group mb-2">
                  <label class="font-weight-bold small">Or Upload New Video File</label>
                  <input type="file" name="video_file" class="form-control-file form-control-sm" accept="video/mp4,video/webm,video/ogg">
                  <small class="text-muted">Uploads to <code>assets/videos/</code></small>
                </div>
              </div>
            </div>

            <!-- Image Section -->
            <div id="imageInputs" class="col-12 bg-light p-3 rounded-3 border mb-3">
              <div class="row g-2">
                <div class="col-sm-6 form-group mb-2">
                  <label class="font-weight-bold small">Poster / Fallback Image URL</label>
                  <input type="text" name="image_url" id="inputImageUrl" class="form-control form-control-sm font-mono" placeholder="assets/img/editorial_runway_hero.jpg">
                  <small class="text-muted">Displays while video loads or as main image</small>
                </div>
                <div class="col-sm-6 form-group mb-2">
                  <label class="font-weight-bold small">Or Upload Image File</label>
                  <input type="file" name="image_file" class="form-control-file form-control-sm" accept="image/*">
                  <small class="text-muted">Uploads to <code>assets/img/</code></small>
                </div>
              </div>
            </div>

            <!-- Action Buttons Config -->
            <div class="col-sm-6 form-group">
              <label class="font-weight-bold small">Primary Button Text</label>
              <input type="text" name="cta_text" id="inputCtaText" class="form-control" value="Explore Boutique">
            </div>
            <div class="col-sm-6 form-group">
              <label class="font-weight-bold small">Primary Button URL</label>
              <input type="text" name="cta_url" id="inputCtaUrl" class="form-control font-mono" value="shop">
            </div>

            <div class="col-sm-6 form-group">
              <label class="font-weight-bold small">Secondary Button Text</label>
              <input type="text" name="secondary_text" id="inputSecText" class="form-control" value="AI Stylist">
            </div>
            <div class="col-sm-6 form-group">
              <label class="font-weight-bold small">Secondary Action / Function</label>
              <input type="text" name="secondary_action" id="inputSecAct" class="form-control font-mono" value="openStylistModal()">
            </div>

            <!-- Sort Order & Active -->
            <div class="col-sm-6 form-group">
              <label class="font-weight-bold small">Sort Order (Lower appears first)</label>
              <input type="number" name="sort_order" id="inputSortOrder" class="form-control" value="1">
            </div>
            <div class="col-sm-6 form-group d-flex align-items-center pt-4">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="is_active" id="inputIsActive" class="custom-control-input" value="1" checked>
                <label class="custom-control-label font-weight-bold" for="inputIsActive">Publish &amp; Show on Storefront</label>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer bg-light p-3 px-4 d-flex justify-content-between">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm px-4 font-weight-bold shadow-sm">
            <i class="fa fa-save mr-1"></i> Save Hero Slide
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function toggleMediaInputs() {
  const isVideo = document.getElementById('mediaVideo').checked;
  document.getElementById('videoInputs').style.display = isVideo ? 'block' : 'none';
}

function loadTemplate(type) {
  if (type === 'runway') {
    document.getElementById('inputTitleMain').value = 'Couture & Tailoring.';
    document.getElementById('inputTitleAccent').value = 'Men & Women Luxe.';
    document.getElementById('inputBadge').value = '✦ AW 2026 RUNWAY ARCHIVE · MEN & WOMEN COUTURE ✦';
    document.getElementById('inputSubtitle').value = 'An architectural curation for men and women. Master-tailored cashmere blazers, sculptural silk gowns, and Okayama shuttle-loom selvedge. Crafted without compromise.';
    document.getElementById('mediaVideo').checked = true;
    toggleMediaInputs();
    document.getElementById('inputVideoUrl').value = 'assets/videos/atelier_couture_loop.mp4';
    document.getElementById('inputImageUrl').value = 'assets/img/atelier_couture_poster.jpg';
    document.getElementById('inputCtaText').value = 'Explore Collection';
    document.getElementById('inputCtaUrl').value = 'shop';
    document.getElementById('inputSecText').value = 'AI Stylist';
    document.getElementById('inputSecAct').value = 'openStylistModal()';
  } else if (type === 'discount') {
    document.getElementById('inputTitleMain').value = 'Haute Couture Finale.';
    document.getElementById('inputTitleAccent').value = 'Up To 50% Off.';
    document.getElementById('inputBadge').value = '✦ VIP PRIVILEGE DROP · UP TO 50% OFF ARCHIVE ✦';
    document.getElementById('inputSubtitle').value = 'Private vault acquisition unlocked for discerning collectors. Enjoy complimentary insured express dispatch + extra ₹500 off with code LUMINA50.';
    document.getElementById('mediaImage').checked = true;
    toggleMediaInputs();
    document.getElementById('inputVideoUrl').value = '';
    document.getElementById('inputImageUrl').value = 'assets/img/luxury_privilege_sale_hero.jpg';
    document.getElementById('inputCtaText').value = 'Claim 50% Privilege';
    document.getElementById('inputCtaUrl').value = 'collections';
    document.getElementById('inputSecText').value = 'Copy Code LUMINA50';
    document.getElementById('inputSecAct').value = "copyCouponCode('LUMINA50')";
  } else if (type === 'silk') {
    document.getElementById('inputTitleMain').value = 'Fluid Grace.';
    document.getElementById('inputTitleAccent').value = 'Mulberry Silk.';
    document.getElementById('inputBadge').value = 'Private Atelier Drop · Limited Run | Como Silk Lab';
    document.getElementById('inputSubtitle').value = 'Grade 6A 22-Momme raw mulberry silk slip dresses, cut on a 45° bias with generational French hand-rolled seams.';
    document.getElementById('mediaImage').checked = true;
    toggleMediaInputs();
    document.getElementById('inputVideoUrl').value = '';
    document.getElementById('inputImageUrl').value = 'assets/img/luxury_silk_evening.jpg';
    document.getElementById('inputCtaText').value = 'Discover Silk Archive';
    document.getElementById('inputCtaUrl').value = 'collections';
    document.getElementById('inputSecText').value = 'AI Stylist';
    document.getElementById('inputSecAct').value = 'openStylistModal()';
  }
}

function openSlideModal(mode, data = null) {
  const modal = $('#slideModal');
  const form = document.getElementById('slideForm');
  
  if (mode === 'create') {
    document.getElementById('modalTitle').innerHTML = '🎬 Add New Hero Slide';
    document.getElementById('formAction').value = 'create';
    document.getElementById('formId').value = '0';
    form.reset();
    document.getElementById('mediaVideo').checked = true;
    document.getElementById('inputSortOrder').value = '<?= count($slides) + 1 ?>';
    document.getElementById('inputIsActive').checked = true;
    document.getElementById('inputVideoUrl').value = 'assets/videos/atelier_couture_loop.mp4';
    document.getElementById('inputImageUrl').value = 'assets/img/atelier_couture_poster.jpg';
    document.getElementById('inputCtaText').value = 'Explore Collection';
    document.getElementById('inputCtaUrl').value = 'shop';
    document.getElementById('inputSecText').value = 'AI Stylist';
    document.getElementById('inputSecAct').value = 'openStylistModal()';
  } else if (mode === 'edit' && data) {
    document.getElementById('modalTitle').innerHTML = '✏️ Edit Hero Slide #' + data.id;
    document.getElementById('formAction').value = 'update';
    document.getElementById('formId').value = data.id;
    document.getElementById('inputTitleMain').value = data.title_main || '';
    document.getElementById('inputTitleAccent').value = data.title_accent || '';
    document.getElementById('inputBadge').value = data.badge || '';
    document.getElementById('inputSubtitle').value = data.subtitle || '';
    
    if (data.media_type === 'video') {
      document.getElementById('mediaVideo').checked = true;
    } else {
      document.getElementById('mediaImage').checked = true;
    }
    
    document.getElementById('inputVideoUrl').value = data.video_url || '';
    document.getElementById('inputImageUrl').value = data.image_url || '';
    document.getElementById('inputCtaText').value = data.cta_text || 'Explore Boutique';
    document.getElementById('inputCtaUrl').value = data.cta_url || 'shop';
    document.getElementById('inputSecText').value = data.secondary_text || 'AI Stylist';
    document.getElementById('inputSecAct').value = data.secondary_action || 'openStylistModal()';
    document.getElementById('inputSortOrder').value = data.sort_order || '1';
    document.getElementById('inputIsActive').checked = data.is_active == 1;
  }
  
  toggleMediaInputs();
  modal.modal('show');
}

document.addEventListener('DOMContentLoaded', toggleMediaInputs);
</script>
