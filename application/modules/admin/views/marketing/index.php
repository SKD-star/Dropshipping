<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="mb-4">
    <h2 class="fw-bold mb-1" style="color:#4e73df;">📣 Marketing &amp; Growth Studio</h2>
    <p class="text-muted mb-0">Autonomous traffic, email marketing, Google Shopping feeds &amp; multi-channel ad copy generation</p>
  </div>

  <div class="row g-3 mb-4">
    <?php $items = [
      ['🔍 SEO & Google Feeds', 'Google Shopping XML & sitemaps', '#8b5cf6', 'admin/marketing/seo_studio', 'fa-search-dollar'],
      ['✉️ AI Email Studio', 'Autonomous newsletters & campaigns', '#ec4899', 'admin/marketing/email_ai', 'fa-envelope-open-text'],
      ['📢 AI Ad Generator', 'Meta, TikTok & Google Ads + ROAS', '#f59e0b', 'admin/marketing/ad_generator', 'fa-bullhorn'],
      ['🎟️ Discount Codes', $discount_count . ' promo codes active', '#4e73df', 'admin/marketing/discounts', 'fa-tags'],
      ['📋 Product Waitlist', $waitlist_count . ' customer signups', '#10b981', 'admin/marketing/waitlist', 'fa-clipboard-list'],
      ['🔌 Integrations', 'Payment gateways & APIs', '#3b82f6', 'admin/marketing/gateways', 'fa-plug'],
    ]; foreach ($items as $item): ?>
    <div class="col-md-6 col-xl-4">
      <a href="<?= base_url($item[3]) ?>" class="card border-0 shadow-sm text-decoration-none h-100" style="border-left:4px solid <?= $item[2] ?>!important;transition: transform 0.15s ease-in-out;">
        <div class="card-body py-4 d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:48px;height:48px;background:<?= $item[2] ?>18;min-width:48px;">
            <i class="fa <?= $item[4] ?> fa-lg" style="color:<?= $item[2] ?>;"></i>
          </div>
          <div>
            <h6 class="fw-bold text-dark mb-1"><?= $item[0] ?></h6>
            <small class="text-muted"><?= $item[1] ?></small>
          </div>
        </div>
      </a>
    </div>
    <?php endforeach; ?>
  </div>
</div>
