<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-3">🏆 Loyalty Tiers</h2>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success"><?= htmlspecialchars($this->session->flashdata('success')) ?></div><?php endif; ?>
  <?php if (empty($tiers)): ?>
  <div class="alert alert-info"><i class="fa fa-info-circle mr-2"></i>No tiers found in <code>loyalty_tiers</code> table. Run the schema migration first.</div>
  <?php else: ?>
  <form method="post" action="<?= base_url('admin/loyalty/tiers') ?>">
    <?= csrf_field() ?>
    <div class="row g-3">
      <?php $tier_icons = ['Bronze'=>'🥉','Silver'=>'🥈','Gold'=>'🥇','Platinum'=>'💎','Diamond'=>'💎'];
      foreach ($tiers as $tier): $code = $tier['tier_code'] ?? $tier['name'] ?? 'Tier'; ?>
      <div class="col-md-3"><div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold text-center"><?= $tier_icons[$code] ?? '⭐' ?> <?= htmlspecialchars($code) ?></div>
        <div class="card-body">
          <div class="form-group"><label class="small">Points Multiplier</label><input type="number" step="0.1" min="0.1" name="tier[<?= $code ?>][multiplier]" class="form-control form-control-sm" value="<?= $tier['points_multiplier']??1 ?>"></div>
          <div class="form-group"><label class="small">Cashback %</label><input type="number" step="0.1" min="0" name="tier[<?= $code ?>][cashback]" class="form-control form-control-sm" value="<?= $tier['cashback_percent']??0 ?>"></div>
          <div class="form-group"><label class="small">Min Total Spend (&#8377;)</label><input type="number" step="1" min="0" name="tier[<?= $code ?>][min_spend]" class="form-control form-control-sm" value="<?= $tier['min_spend']??0 ?>"></div>
          <div class="form-group"><label class="small">Perks</label><textarea name="tier[<?= $code ?>][perks]" class="form-control form-control-sm" rows="2"><?= htmlspecialchars($tier['perks']??'') ?></textarea></div>
        </div>
      </div></div>
      <?php endforeach; ?>
    </div>
    <div class="mt-3"><button type="submit" class="btn btn-success px-4">Save Tier Configuration</button></div>
  </form>
  <?php endif; ?>
</div>
