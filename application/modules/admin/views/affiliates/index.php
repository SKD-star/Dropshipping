<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-1">🤝 Affiliates</h2>
  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #9333ea;"><div style="font-size:1.4rem;font-weight:800;"><?= number_format($influencer_count) ?></div><div class="text-muted small">Influencers</div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #3b82f6;"><div style="font-size:1.4rem;font-weight:800;"><?= number_format($referral_count) ?></div><div class="text-muted small">Referrals</div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #f59e0b;"><div style="font-size:1.4rem;font-weight:800;"><?= number_format($payout_pending) ?></div><div class="text-muted small">Pending Payouts</div></div></div>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/affiliates/influencers') ?>" class="btn btn-primary btn-sm px-4">Manage Influencers</a>
    <a href="<?= base_url('admin/affiliates/referrals') ?>" class="btn btn-outline-primary btn-sm px-4">Referral Log</a>
    <a href="<?= base_url('admin/affiliates/payouts') ?>" class="btn btn-outline-success btn-sm px-4">Payouts</a>
  </div>
</div>
