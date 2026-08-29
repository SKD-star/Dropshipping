<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="mb-4">
    <h2 class="fw-bold mb-1" style="color:#4e73df;">⚙️ System Settings &amp; Configuration</h2>
    <p class="text-muted mb-0">Manage appearance branding, announcement bars, CMS legal pages, FAQs &amp; system health</p>
  </div>

  <div class="row g-3">
    <?php $sections = [
      ['🩺 System Health & Healing','Automated integrity scanner & diagnostics','admin/settings/health','#1cc88a','fa-heartbeat'],
      ['🎨 Store Appearance','Brand colors, hero text & footer identity','admin/settings/appearance','#4e73df','fa-palette'],
      ['📢 Announcement Banners','Site-wide dynamic top banner alerts','admin/settings/announcements','#f6c23e','fa-bullhorn'],
      ['📄 CMS Legal Pages','About, Privacy Policy, Terms of Service','admin/settings/pages','#36b9cc','fa-file-alt'],
      ['❓ FAQ Manager','Categorized customer support answers','admin/settings/faq','#9333ea','fa-question-circle'],
      ['🌍 Currencies & Languages','International multi-currency localization','admin/settings/international','#e74a3b','fa-globe'],
    ]; foreach ($sections as $s): ?>
    <div class="col-md-6 col-xl-4">
      <a href="<?= base_url($s[2]) ?>" class="card border-0 shadow-sm text-decoration-none h-100" style="border-left:4px solid <?= $s[3] ?>!important;">
        <div class="card-body py-4 d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:48px;height:48px;background:<?= $s[3] ?>18;min-width:48px;">
            <i class="fa <?= $s[4] ?> fa-lg" style="color:<?= $s[3] ?>;"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1"><?= $s[0] ?></h6>
            <small class="text-muted"><?= $s[1] ?></small>
          </div>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
</div>
