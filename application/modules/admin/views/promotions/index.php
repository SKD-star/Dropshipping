<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-1" style="color:#4e73df;">🎯 Promotions Hub</h2>
  <p class="text-muted mb-4">Manage flash sales, bundles, pre-orders, mystery drops &amp; group buying</p>

  <div class="row g-3">
    <?php $modules = [
      ['Flash Sales', $flash_count.' active', 'fa-bolt', '#f59e0b', 'admin/promotions/flash_sales', 'Launch time-limited deals with countdown timers'],
      ['Product Bundles', $bundle_count.' active', 'fa-layer-group', '#3b82f6', 'admin/promotions/bundles', 'Create buy-together bundle offers'],
      ['Pre-Orders', $preorder_count.' campaigns', 'fa-clock', '#10b981', 'admin/promotions/pre_orders', 'Accept orders before stock arrives'],
      ['Mystery Drops', $mystery_count.' drops', 'fa-gift', '#8b5cf6', 'admin/promotions/mystery_drops', 'Surprise product reveals with countdown'],
      ['Group Buying', $group_count.' campaigns', 'fa-users', '#ec4899', 'admin/promotions/group_buying', 'Social buying with minimum participants'],
    ]; foreach ($modules as $m): ?>
    <div class="col-md-6 col-xl-4">
      <div class="card border-0 shadow-sm h-100" style="border-left:4px solid <?= $m[3] ?>!important;">
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:48px;height:48px;background:<?= $m[3] ?>22;">
              <i class="fa <?= $m[2] ?> fa-lg" style="color:<?= $m[3] ?>;"></i>
            </div>
            <div>
              <h6 class="mb-0 fw-bold"><?= $m[0] ?></h6>
              <small class="text-muted"><?= $m[1] ?></small>
            </div>
          </div>
          <p class="text-muted small mb-3"><?= $m[4] ?></p>
          <a href="<?= base_url($m[3+1]) ?>" class="btn btn-sm btn-outline-primary">Manage</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
