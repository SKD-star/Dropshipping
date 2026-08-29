<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">📄 CMS Pages</h2>
    <a href="<?= base_url('admin/settings/pages?edit=0') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus mr-1"></i> New Page</a>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="row g-3">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold">All Pages</div>
        <div class="card-body p-0">
          <div class="list-group list-group-flush">
            <?php foreach ($pages as $p): ?>
            <a href="<?= base_url('admin/settings/pages?edit='.$p['id']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= ($edit_page && $edit_page['id'] == $p['id']) ? 'active' : '' ?>">
              <div>
                <div class="fw-bold"><?= htmlspecialchars($p['title']) ?></div>
                <small class="text-muted">/page/<?= htmlspecialchars($p['slug']) ?></small>
              </div>
              <span class="badge badge-<?= $p['is_active'] ? 'success' : 'secondary' ?>"><?= $p['is_active'] ? 'Live' : 'Draft' ?></span>
            </a>
            <?php endforeach; ?>
            <?php if (empty($pages)): ?><div class="list-group-item text-muted small py-4 text-center">No CMS pages yet</div><?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><?= $edit_page ? 'Edit: ' . htmlspecialchars($edit_page['title']) : 'Create New Page' ?></div>
        <form method="post" action="<?= base_url('admin/settings/pages') ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="page_action" value="save">
          <input type="hidden" name="id" value="<?= $edit_page['id'] ?? 0 ?>">
          <div class="card-body">
            <div class="form-group">
              <label>Page Title *</label>
              <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($edit_page['title'] ?? '') ?>" required placeholder="e.g. Terms and Conditions">
            </div>
            <div class="form-group">
              <label>URL Slug (leave empty for auto)</label>
              <input type="text" name="slug" class="form-control" value="<?= htmlspecialchars($edit_page['slug'] ?? '') ?>" placeholder="terms-and-conditions">
            </div>
            <div class="form-group">
              <label>Content (HTML / Markdown)</label>
              <textarea name="content" class="form-control font-monospace" rows="10" placeholder="Write page content here..."><?= htmlspecialchars($edit_page['content'] ?? '') ?></textarea>
            </div>
            <div class="row">
              <div class="col-6 form-group">
                <label>SEO Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="<?= htmlspecialchars($edit_page['meta_title'] ?? '') ?>">
              </div>
              <div class="col-6 form-group">
                <label>SEO Meta Description</label>
                <input type="text" name="meta_desc" class="form-control" value="<?= htmlspecialchars($edit_page['meta_desc'] ?? '') ?>">
              </div>
            </div>
            <div class="custom-control custom-switch mt-2">
              <input type="checkbox" class="custom-control-input" id="pageActive" name="is_active" value="1" <?= ($edit_page['is_active'] ?? 1) ? 'checked' : '' ?>>
              <label class="custom-control-label" for="pageActive">Published &amp; Live</label>
            </div>
          </div>
          <div class="card-footer bg-white d-flex justify-content-between">
            <button type="submit" class="btn btn-primary px-4">Save Page</button>
            <?php if ($edit_page): ?>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="if(confirm('Delete page?')){ document.getElementById('delPageForm').submit(); }">Delete</button>
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
