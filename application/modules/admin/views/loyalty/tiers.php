<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Header Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-crown text-warning mr-2"></i>VIP Loyalty Tiers &amp; Multipliers
      </h3>
      <p class="text-muted small mb-0">Configure spending thresholds, cashback rates, points multipliers, and luxury perks for each VIP tier</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/loyalty') ?>" class="btn btn-outline-primary btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-arrow-left mr-1"></i> Loyalty Hub
      </a>
      <a href="<?= base_url('admin/loyalty/badges') ?>" class="btn btn-warning text-dark btn-sm font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-medal mr-1"></i> Badges &amp; Streaks
      </a>
    </div>
  </div>

  <!-- Flash Messages -->
  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
    <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <form method="post" action="<?= base_url('admin/loyalty/tiers') ?>">
    <?= csrf_field() ?>
    <div class="row g-3 mb-4">
      <?php 
      $tier_meta = [
        'Bronze'   => ['icon'=>'🥉', 'color'=>'#cd7f32', 'title'=>'Bronze Member', 'bg'=>'rgba(205, 127, 50, 0.08)'],
        'Silver'   => ['icon'=>'🥈', 'color'=>'#94a3b8', 'title'=>'Silver Collector', 'bg'=>'rgba(148, 163, 184, 0.08)'],
        'Gold'     => ['icon'=>'🥇', 'color'=>'#f59e0b', 'title'=>'Gold Connoisseur', 'bg'=>'rgba(245, 158, 11, 0.08)'],
        'Platinum' => ['icon'=>'💎', 'color'=>'#8b5cf6', 'title'=>'Platinum Royal', 'bg'=>'rgba(139, 92, 246, 0.08)'],
        'Diamond'  => ['icon'=>'👑', 'color'=>'#06b6d4', 'title'=>'Diamond Sovereign', 'bg'=>'rgba(6, 182, 212, 0.08)'],
      ];

      foreach ($tiers as $tier): 
        $code = $tier['tier_code'] ?? ($tier['name'] ?? 'Tier');
        $meta = $tier_meta[$code] ?? ['icon'=>'⭐', 'color'=>'#4f46e5', 'title'=>$code, 'bg'=>'rgba(79, 70, 229, 0.08)'];
      ?>
      <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px; overflow:hidden; border-top: 4px solid <?= $meta['color'] ?> !important;">
          <div class="card-header bg-white py-3 px-3 border-bottom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <span class="mr-2" style="font-size:1.5rem;"><?= $meta['icon'] ?></span>
              <h6 class="font-weight-bold text-dark mb-0"><?= htmlspecialchars($code) ?></h6>
            </div>
            <span class="badge badge-light border text-dark font-weight-bold font-mono">
              ≥ ₹<?= number_format($tier['min_spend'] ?? 0) ?>
            </span>
          </div>
          
          <div class="card-body p-3">
            <div class="form-group mb-2">
              <label class="small font-weight-bold text-muted mb-1">Points Multiplier (x)</label>
              <input type="number" step="0.1" min="0.1" name="tier[<?= $code ?>][multiplier]" class="form-control form-control-sm font-weight-bold" value="<?= $tier['points_multiplier'] ?? 1.0 ?>">
            </div>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-muted mb-1">Cashback % Credits</label>
              <input type="number" step="0.1" min="0" max="100" name="tier[<?= $code ?>][cashback]" class="form-control form-control-sm font-weight-bold text-success" value="<?= $tier['cashback_percent'] ?? 0.0 ?>">
            </div>

            <div class="form-group mb-2">
              <label class="small font-weight-bold text-muted mb-1">Min Spend Required (₹)</label>
              <input type="number" step="1" min="0" name="tier[<?= $code ?>][min_spend]" class="form-control form-control-sm font-weight-bold" value="<?= $tier['min_spend'] ?? 0 ?>">
            </div>

            <div class="form-group mb-0">
              <label class="small font-weight-bold text-muted mb-1">Exclusive Tier Perks</label>
              <textarea name="tier[<?= $code ?>][perks]" class="form-control form-control-sm" rows="2" placeholder="e.g. Free express shipping, early drop access..."><?= htmlspecialchars($tier['perks'] ?? '') ?></textarea>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-right">
      <button type="submit" class="btn btn-success font-weight-bold px-4 py-2 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-save mr-1"></i> Save VIP Tier Configurations
      </button>
    </div>
  </form>
</div>
