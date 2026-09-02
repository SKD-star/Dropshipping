<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── CMS Legal Pages Premium UI ── */
.pages-wrapper {
  padding-top: 10px;
  max-width: 1440px;
  margin: 0 auto;
}
.pages-hero {
  background: linear-gradient(135deg, #0e7490 0%, #0891b2 50%, #06b6d4 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 24px rgba(8, 145, 178, 0.2);
}
.page-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 10px rgba(0,0,0,.04);
  background: #fff;
  overflow: hidden;
}
.page-card .card-header {
  background: #fff;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 20px;
  font-weight: 700;
  color: #1e293b;
}
.snippet-chip {
  cursor: pointer;
  border-radius: 8px;
  padding: 6px 12px;
  font-size: .75rem;
  font-weight: 600;
  background: #f1f5f9;
  color: #0f172a;
  border: 1.5px solid #e2e8f0;
  transition: all .15s ease;
  user-select: none;
}
.snippet-chip:hover {
  background: #0891b2;
  color: #fff;
  border-color: #0891b2;
  transform: translateY(-1px);
}
.snippet-chip:active {
  transform: scale(0.97);
}
</style>

<div class="container-fluid px-3 px-md-4 py-3 pages-wrapper">

  <!-- Hero Header -->
  <div class="pages-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.75rem;">📄</span>
        <h3 class="fw-bold mb-0 text-white font-weight-bold">CMS &amp; Policy Pages</h3>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Publish storefront legal documents, privacy terms, return policies, and custom editorial content</p>
    </div>
    <button type="button" class="btn btn-light btn-sm font-weight-bold px-3 shadow-sm" onclick="createNewPageFocus()" style="border-radius:8px;">
      <i class="fa fa-plus mr-1"></i> New Page
    </button>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <div class="row g-4">
    
    <!-- All Pages Directory -->
    <div class="col-lg-4">
      <div class="page-card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="fa fa-folder-open text-primary mr-2"></i>Page Directory</span>
          <span class="badge badge-info badge-pill"><?= count($pages) ?> Pages</span>
        </div>
        <div class="card-body p-0">
          <div class="list-group list-group-flush" id="pageListGroup">
            <?php if (empty($pages)): ?>
              <div class="p-4 text-center text-muted small">
                <div style="font-size:2rem;">📄</div>
                <div class="mt-2 font-weight-bold">No pages published yet.</div>
                <small class="text-muted">Use the editor on the right or click a starter template to publish your first page.</small>
              </div>
            <?php else: foreach ($pages as $p): 
              $p_title = $p['title'] ?? ($p['page_title'] ?? ($p['name'] ?? 'Untitled Page'));
              $p_slug  = $p['slug'] ?? '';
            ?>
              <a href="<?= base_url('admin/settings/pages?edit='.$p['id']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= ($edit_page && $edit_page['id'] == $p['id']) ? 'active bg-light border-primary' : '' ?>">
                <div>
                  <div class="fw-bold text-dark mb-0"><?= htmlspecialchars($p_title) ?></div>
                  <small class="text-muted font-mono">/page/<?= htmlspecialchars($p_slug) ?></small>
                </div>
                <span class="badge badge-<?= ($p['is_active'] ?? 1) ? 'success' : 'secondary' ?> px-2 py-1">
                  <?= ($p['is_active'] ?? 1) ? 'Live' : 'Draft' ?>
                </span>
              </a>
            <?php endforeach; endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Page Editor -->
    <?php
      $ed_title   = $edit_page['title'] ?? ($edit_page['page_title'] ?? ($edit_page['name'] ?? ''));
      $ed_slug    = $edit_page['slug'] ?? '';
      $ed_content = $edit_page['content'] ?? ($edit_page['body'] ?? '');
      $ed_meta_t  = $edit_page['meta_title'] ?? '';
      $ed_meta_d  = $edit_page['meta_desc'] ?? '';
    ?>
    <div class="col-lg-8" id="editorContainer">
      <div class="page-card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span id="editorHeading">
            <i class="fa fa-edit text-info mr-2"></i>
            <?= $edit_page ? 'Edit: ' . htmlspecialchars($ed_title) : 'Create New Document / Page' ?>
          </span>
          <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 font-weight-bold" onclick="createNewPageFocus()">
            + Clear &amp; New Document
          </button>
        </div>

        <form method="post" action="<?= base_url('admin/settings/pages') ?>" id="pageForm">
          <?= csrf_field() ?>
          <input type="hidden" name="page_action" value="save">
          <input type="hidden" id="pageId" name="id" value="<?= $edit_page['id'] ?? 0 ?>">

          <div class="card-body p-4">
            
            <!-- Preset Policy Templates -->
            <div class="mb-3">
              <label class="font-weight-bold small text-muted d-block mb-2">⚡ 1-Click Policy Starter Templates:</label>
              <div class="d-flex flex-wrap gap-1">
                <span class="snippet-chip" onclick="loadPolicySnippet('terms')">📜 Terms &amp; Conditions</span>
                <span class="snippet-chip" onclick="loadPolicySnippet('privacy')">🔒 Privacy Policy</span>
                <span class="snippet-chip" onclick="loadPolicySnippet('returns')">🔄 Return &amp; Refund</span>
                <span class="snippet-chip" onclick="loadPolicySnippet('shipping')">🚚 Shipping Policy</span>
                <span class="snippet-chip" onclick="loadPolicySnippet('about')">✨ About NovaDrop</span>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-6 form-group">
                <label class="font-weight-bold small">Document Title *</label>
                <input type="text" id="pageTitle" name="title" class="form-control" value="<?= htmlspecialchars($ed_title) ?>" required placeholder="e.g. Terms &amp; Conditions" oninput="autoSlug()">
              </div>
              <div class="col-md-6 form-group">
                <label class="font-weight-bold small">URL Slug</label>
                <input type="text" id="pageSlug" name="slug" class="form-control font-mono" value="<?= htmlspecialchars($ed_slug) ?>" placeholder="terms-and-conditions">
              </div>

              <div class="col-12 form-group">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label class="font-weight-bold small mb-0">Page Content (HTML / Markdown / Plain Text) *</label>
                  <span id="wordCount" class="text-muted small">0 words</span>
                </div>
                <textarea id="pageContent" name="content" class="form-control font-monospace" rows="12" style="font-size:.85rem;" required placeholder="Write or paste your page content here..." oninput="updateWordCount()"><?= htmlspecialchars($ed_content) ?></textarea>
              </div>

              <div class="col-md-6 form-group">
                <label class="font-weight-bold small">SEO Meta Title</label>
                <input type="text" id="pageMetaTitle" name="meta_title" class="form-control" value="<?= htmlspecialchars($ed_meta_t) ?>" placeholder="e.g. Terms of Service | NovaDrop">
              </div>
              <div class="col-md-6 form-group">
                <label class="font-weight-bold small">SEO Meta Description</label>
                <input type="text" id="pageMetaDesc" name="meta_desc" class="form-control" value="<?= htmlspecialchars($ed_meta_d) ?>" placeholder="Official terms and purchasing guidelines for our store.">
              </div>

              <div class="col-12">
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="pageActive" name="is_active" value="1" <?= ($edit_page['is_active'] ?? 1) ? 'checked' : '' ?>>
                  <label class="custom-control-label font-weight-bold" for="pageActive">Publish Page (Make visible on storefront)</label>
                </div>
              </div>
            </div>

          </div>

          <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-info text-white font-weight-bold px-4 shadow-sm" style="border-radius:8px;">
              <i class="fa fa-save mr-1"></i> Save Document
            </button>
            <?php if ($edit_page): ?>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="if(confirm('Delete page <?= htmlspecialchars($ed_title) ?>?')){ document.getElementById('delPageForm').submit(); }">
              <i class="fa fa-trash mr-1"></i> Delete Page
            </button>
            <?php endif; ?>
          </div>
        </form>

        <?php if ($edit_page): ?>
        <form id="delPageForm" method="post" action="<?= base_url('admin/settings/pages') ?>" style="display:none;">
          <?= csrf_field() ?>
          <input type="hidden" name="page_action" value="delete">
          <input type="hidden" name="id" value="<?= $edit_page['id'] ?>">
        </form>
        <?php endif; ?>

      </div>
    </div>

  </div>

</div>

<script>
function createNewPageFocus() {
  document.getElementById('pageId').value = '0';
  document.getElementById('pageTitle').value = '';
  document.getElementById('pageSlug').value = '';
  document.getElementById('pageContent').value = '';
  document.getElementById('pageMetaTitle').value = '';
  document.getElementById('pageMetaDesc').value = '';
  document.getElementById('pageActive').checked = true;
  document.getElementById('editorHeading').innerHTML = '<i class="fa fa-plus-circle text-info mr-2"></i>Create New Document / Page';

  // Remove active highlight from list
  var items = document.querySelectorAll('#pageListGroup a');
  items.forEach(function(el){ el.classList.remove('active', 'bg-light', 'border-primary'); });

  updateWordCount();
  document.getElementById('pageTitle').focus();
  document.getElementById('editorContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function autoSlug() {
  var t = document.getElementById('pageTitle').value;
  var s = document.getElementById('pageSlug');
  s.value = t.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
}

function updateWordCount() {
  var text = document.getElementById('pageContent').value.trim();
  var words = text ? text.split(/\s+/).length : 0;
  document.getElementById('wordCount').innerText = words + ' words';
}

function loadPolicySnippet(type) {
  var title = document.getElementById('pageTitle');
  var content = document.getElementById('pageContent');
  var metaT = document.getElementById('pageMetaTitle');
  var metaD = document.getElementById('pageMetaDesc');
  
  if (type === 'terms') {
    title.value = 'Terms & Conditions';
    metaT.value = 'Terms & Conditions | NovaDrop';
    metaD.value = 'Official customer terms and service agreements for NovaDrop.';
    content.value = "## 1. Overview\nWelcome to NovaDrop. By accessing our platform, you agree to abide by these terms of service and all applicable laws across India.\n\n## 2. Orders & Payments\nAll orders placed on our store are subject to inventory availability and payment verification.\n\n## 3. Shipping & Delivery\nStandard express transit takes 3-5 business days across major metros.\n\n## 4. Customer Support\nFor assistance, reach out via our official support channels or WhatsApp.";
  } else if (type === 'privacy') {
    title.value = 'Privacy Policy';
    metaT.value = 'Privacy Policy | NovaDrop';
    metaD.value = 'How NovaDrop collects, protects, and manages your personal data.';
    content.value = "## Information We Collect\nWe respect your privacy and only collect information required to fulfill your orders, including name, shipping address, email, and contact number.\n\n## Data Security\nAll transactions are secured with 256-bit SSL encryption. We never store raw payment card data on our servers.\n\n## Third-Party Partners\nWe share delivery coordinates strictly with verified courier partners for fulfillment purposes.";
  } else if (type === 'returns') {
    title.value = 'Return & Refund Policy';
    metaT.value = 'Return & Refund Policy | NovaDrop';
    metaD.value = '7-day hassle-free doorstep returns and quick refund processing.';
    content.value = "## 7-Day Hassle-Free Returns\nWe want you to love what you ordered! If you're not satisfied, return eligible items within 7 days of delivery.\n\n## Eligibility\nItems must be unworn, unwashed, with all original tags attached.\n\n## Refund Processing\nRefunds are processed back to the original payment method or store wallet within 48 hours of quality inspection.";
  } else if (type === 'shipping') {
    title.value = 'Shipping Policy';
    metaT.value = 'Shipping Policy | NovaDrop';
    metaD.value = 'Doorstep express delivery coverage across all pin codes in India.';
    content.value = "## Domestic Delivery\nWe offer fast doorstep delivery across all pin codes in India.\n\n- Prepaid Orders: FREE shipping on orders above ₹499.\n- Cash on Delivery: Flat ₹49 COD handling fee applies.\n\n## Order Tracking\nLive tracking details are dispatched via SMS & WhatsApp as soon as your package leaves our fulfillment hub.";
  } else if (type === 'about') {
    title.value = 'About NovaDrop';
    metaT.value = 'About Us | NovaDrop Atelier';
    metaD.value = 'Next-generation dropshipping, limited streetwear drops, and lifestyle essentials.';
    content.value = "## Our Mission\nNovaDrop is a next-generation streetwear and lifestyle drop ecosystem. We curate limited-run apparel, trending essentials, and high-velocity accessories designed for modern creators.\n\nCrafted with premium fabrics and delivered with lightning-fast logistics.";
  }
  autoSlug();
  updateWordCount();
  title.focus();
}

document.addEventListener('DOMContentLoaded', updateWordCount);
</script>
