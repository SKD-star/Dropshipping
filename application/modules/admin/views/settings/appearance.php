<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-3">🎨 Store Appearance</h2>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <form method="post" action="<?= base_url('admin/settings/appearance') ?>">
    <?= csrf_field() ?>
    <div class="row">
      <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white fw-bold">Branding &amp; Identity</div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Store Name</label>
                <input type="text" name="store_name" class="form-control" value="<?= htmlspecialchars($settings['store_name'] ?? 'NovaDrop') ?>">
              </div>
              <div class="col-md-6 form-group">
                <label>Tagline</label>
                <input type="text" name="tagline" class="form-control" value="<?= htmlspecialchars($settings['tagline'] ?? 'Next-Gen E-Commerce') ?>">
              </div>
              <div class="col-md-12 form-group">
                <label>Hero Title</label>
                <input type="text" name="hero_title" class="form-control" value="<?= htmlspecialchars($settings['hero_title'] ?? 'Discover Trending Products') ?>">
              </div>
              <div class="col-md-12 form-group">
                <label>Hero Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control" value="<?= htmlspecialchars($settings['hero_subtitle'] ?? 'Curated products with fast delivery across India') ?>">
              </div>
              <div class="col-md-6 form-group">
                <label>Primary Theme Color</label>
                <input type="color" name="primary_color" class="form-control form-control-color w-100" value="<?= $settings['primary_color'] ?? '#4e73df' ?>" style="height:42px;">
              </div>
              <div class="col-md-6 form-group">
                <label>Accent Color</label>
                <input type="color" name="accent_color" class="form-control form-control-color w-100" value="<?= $settings['accent_color'] ?? '#1cc88a' ?>" style="height:42px;">
              </div>
              <div class="col-md-12 form-group">
                <label>Announcement Bar Text</label>
                <input type="text" name="announcement_bar" class="form-control" value="<?= htmlspecialchars($settings['announcement_bar'] ?? '') ?>" placeholder="🔥 Free Shipping on prepaid orders above ₹499!">
              </div>
              <div class="col-md-12 form-group">
                <label>Footer Copyright Text</label>
                <input type="text" name="footer_text" class="form-control" value="<?= htmlspecialchars($settings['footer_text'] ?? '© 2026 NovaDrop Inc. All rights reserved.') ?>">
              </div>
            </div>
            <button type="submit" class="btn btn-primary px-4">Save Appearance Settings</button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-light">
          <div class="card-body">
            <h6 class="fw-bold mb-2">💡 Quick Links</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="<?= base_url('admin/settings/announcements') ?>" class="text-decoration-none"><i class="fa fa-bullhorn mr-2"></i>Announcement Bars</a></li>
              <li class="mb-2"><a href="<?= base_url('admin/settings/pages') ?>" class="text-decoration-none"><i class="fa fa-file-alt mr-2"></i>CMS Pages</a></li>
              <li class="mb-2"><a href="<?= base_url('admin/settings/faq') ?>" class="text-decoration-none"><i class="fa fa-question-circle mr-2"></i>FAQ Manager</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
