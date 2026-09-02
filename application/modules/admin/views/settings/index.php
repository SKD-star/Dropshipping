<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.settings-hero { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); border-radius: 16px; padding: 28px 32px; color: #fff; margin-bottom: 1.5rem; }
.settings-hero h2 { font-size: 1.7rem; font-weight: 800; }
.setting-card { border-radius: 14px; overflow: hidden; text-decoration: none !important; transition: all .22s ease; display: block; border: 1.5px solid #e8ecf0; }
.setting-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.1) !important; }
.setting-card .icon-wrap { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
.setting-card h6 { font-size: .95rem; font-weight: 700; color: #111827; margin-bottom: 3px; }
.setting-card small { color: #6b7280; }
.health-bar { height: 6px; border-radius: 3px; background: #e5e7eb; overflow: hidden; }
.health-bar-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg, #10b981, #34d399); }
@media (max-width: 576px) {
  .settings-hero { padding: 20px 18px; }
  .settings-hero h2 { font-size: 1.3rem; }
}
</style>

<div class="container-fluid py-4">

  <!-- Hero -->
  <div class="settings-hero mb-4">
    <div class="d-flex align-items-center gap-3 mb-2">
      <div style="font-size:2.2rem;">⚙️</div>
      <div>
        <h2 class="mb-1">System Settings</h2>
        <p class="mb-0" style="opacity:.8;">Manage your store branding, content, integrations &amp; diagnostics</p>
      </div>
    </div>
  </div>

  <!-- Settings Grid -->
  <div class="row g-3 mb-4">
    <?php $sections = [
      ['icon' => '🩺', 'label' => 'System Health', 'desc' => 'Diagnostics, self-healing &amp; integrity scanner', 'url' => 'admin/settings/health', 'color' => '#10b981', 'bg' => '#d1fae5'],
      ['icon' => '🎨', 'label' => 'Store Appearance', 'desc' => 'Brand colors, hero text, footer identity', 'url' => 'admin/settings/appearance', 'color' => '#2563eb', 'bg' => '#dbeafe'],
      ['icon' => '📢', 'label' => 'Announcement Bars', 'desc' => 'Dynamic site-wide banner alerts', 'url' => 'admin/settings/announcements', 'color' => '#d97706', 'bg' => '#fef3c7'],
      ['icon' => '📄', 'label' => 'CMS Pages', 'desc' => 'About, Privacy Policy, Terms of Service', 'url' => 'admin/settings/pages', 'color' => '#0891b2', 'bg' => '#cffafe'],
      ['icon' => '❓', 'label' => 'FAQ Manager', 'desc' => 'Categorized customer support answers', 'url' => 'admin/settings/faq', 'color' => '#7c3aed', 'bg' => '#ede9fe'],
      ['icon' => '🌍', 'label' => 'International', 'desc' => 'Multi-currency &amp; language localization', 'url' => 'admin/settings/international', 'color' => '#dc2626', 'bg' => '#fee2e2'],
      ['icon' => '🔌', 'label' => 'API & Gateways', 'desc' => 'Payment gateway &amp; integration API keys', 'url' => 'admin/marketing/gateways', 'color' => '#059669', 'bg' => '#d1fae5'],
    ];
    foreach ($sections as $s): ?>
    <div class="col-6 col-md-4 col-xl-3">
      <a href="<?= base_url($s['url']) ?>" class="setting-card card border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-start gap-3 py-3">
          <div class="icon-wrap" style="background:<?= $s['bg'] ?>;">
            <span style="font-size:1.4rem;"><?= $s['icon'] ?></span>
          </div>
          <div>
            <h6><?= $s['label'] ?></h6>
            <small><?= $s['desc'] ?></small>
          </div>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Quick System Status -->
  <div class="card border-0 shadow-sm" style="border-radius:14px;">
    <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
      <span><i class="fa fa-shield-alt text-success mr-2"></i>Quick System Status</span>
      <a href="<?= base_url('admin/settings/health') ?>" class="btn btn-sm btn-outline-success">Full Diagnostics</a>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <?php
          $qs = [
            ['label' => 'PHP Engine', 'val' => 'PHP ' . PHP_VERSION, 'ok' => version_compare(PHP_VERSION, '7.4', '>=')],
            ['label' => 'Database', 'val' => 'Connected', 'ok' => true],
            ['label' => 'Cache Dir', 'val' => is_writable(APPPATH.'cache/') ? 'Writable' : 'Check Perms', 'ok' => is_writable(APPPATH.'cache/')],
            ['label' => 'Uploads Dir', 'val' => is_dir(FCPATH.'assets/uploads/') ? 'Exists' : 'Missing', 'ok' => is_dir(FCPATH.'assets/uploads/')],
          ];
          foreach ($qs as $qs_item):
        ?>
        <div class="col-6 col-md-3">
          <div class="p-3 rounded-3" style="background:<?= $qs_item['ok'] ? '#f0fdf4' : '#fef2f2' ?>; border:1px solid <?= $qs_item['ok'] ? '#bbf7d0' : '#fecaca' ?>;">
            <div class="d-flex align-items-center gap-2 mb-1">
              <span style="font-size:1rem;"><?= $qs_item['ok'] ? '✅' : '⚠️' ?></span>
              <span class="fw-bold small"><?= $qs_item['label'] ?></span>
            </div>
            <div class="small text-muted"><?= $qs_item['val'] ?></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
