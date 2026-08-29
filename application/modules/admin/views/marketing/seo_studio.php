<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#8b5cf6;">🔍 SEO &amp; Google Merchant Shopping Feed Studio</h2>
      <p class="text-muted mb-0">Generate Google Shopping XML product feeds, dynamic XML sitemaps &amp; JSON-LD search snippets</p>
    </div>
    <div class="d-flex gap-2">
      <form method="post" action="<?= base_url('admin/marketing/seo_studio') ?>" class="d-inline mr-2">
        <?= csrf_field() ?>
        <input type="hidden" name="seo_action" value="generate_google_feed">
        <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm"><i class="fa fa-rss mr-1"></i> Generate Google Feed</button>
      </form>
      <form method="post" action="<?= base_url('admin/marketing/seo_studio') ?>" class="d-inline">
        <?= csrf_field() ?>
        <input type="hidden" name="seo_action" value="generate_sitemap">
        <button type="submit" class="btn btn-outline-primary btn-sm px-3 shadow-sm"><i class="fa fa-sitemap mr-1"></i> Generate Sitemap</button>
      </form>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #8b5cf6;">
        <i class="fa fa-shopping-bag fa-2x mb-2 text-primary"></i>
        <div style="font-size:1.5rem;font-weight:800;"><?= number_format($active_products) ?></div>
        <div class="text-muted small">Active Products in Feed</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #10b981;">
        <i class="fa fa-file-code fa-2x mb-2 text-success"></i>
        <div style="font-size:1.1rem;font-weight:800;margin-top:5px;"><?= $feed_exists ? '✅ Generated (/google_merchant_feed.xml)' : '⚠️ Not Generated' ?></div>
        <div class="text-muted small">Google Shopping Feed</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #3b82f6;">
        <i class="fa fa-sitemap fa-2x mb-2 text-info"></i>
        <div style="font-size:1.1rem;font-weight:800;margin-top:5px;"><?= $sitemap_exists ? '✅ Active (/sitemap.xml)' : '⚠️ Not Generated' ?></div>
        <div class="text-muted small">Search Engine Sitemap</div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold">Recent Products Ready for Indexing</div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Product Title</th><th>Slug</th><th>Price</th><th>SEO Preview Link</th></tr></thead>
        <tbody>
        <?php foreach ($recent_products as $p): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($p['title']) ?></td>
          <td><code><?= htmlspecialchars($p['slug']) ?></code></td>
          <td>₹<?= number_format($p['base_price'], 2) ?></td>
          <td><a href="<?= base_url('product/' . ($p['slug'] ?: $p['id'])) ?>" target="_blank" class="btn btn-sm btn-outline-secondary py-0">View Live <i class="fa fa-external-link-alt ml-1"></i></a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
