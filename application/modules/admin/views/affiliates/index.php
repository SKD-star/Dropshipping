<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Header Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-handshake text-info mr-2"></i>Influencers &amp; Affiliate Growth Hub
      </h3>
      <p class="text-muted small mb-0">Track affiliate referral codes, monitor creator commissions, and issue payout settlements</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/affiliates/influencers') ?>" class="btn btn-primary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-users mr-1"></i> Manage Influencers
      </a>
      <a href="<?= base_url('admin/affiliates/payouts') ?>" class="btn btn-success btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-money-check-alt mr-1"></i> Commission Payouts
      </a>
    </div>
  </div>

  <!-- KPI Metric Cards Grid -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-4 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #8b5cf6 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Registered Creators</div>
        <div class="font-weight-bold text-dark" style="font-size:1.3rem;"><?= number_format($influencer_count) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-4 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #3b82f6 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Total Referral Conversions</div>
        <div class="font-weight-bold text-primary" style="font-size:1.3rem;"><?= number_format($referral_count) ?></div>
      </div>
    </div>
    <div class="col-12 col-md-4 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #f59e0b !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Pending Payout Settlements</div>
        <div class="font-weight-bold text-warning" style="font-size:1.3rem;"><?= number_format($payout_pending) ?></div>
      </div>
    </div>
  </div>

  <!-- Action Hub Navigation Cards -->
  <div class="row g-3">
    <div class="col-md-4 mb-3">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
        <div class="d-flex align-items-center mb-2">
          <span class="mr-2" style="font-size:1.5rem;">📱</span>
          <h6 class="font-weight-bold text-dark mb-0">Creator Roster &amp; Codes</h6>
        </div>
        <p class="text-muted small mb-3">Generate unique referral coupon codes and set custom commission percentages for creators.</p>
        <a href="<?= base_url('admin/affiliates/influencers') ?>" class="btn btn-outline-primary btn-sm font-weight-bold mt-auto" style="border-radius:6px;">
          View Creators Directory &rarr;
        </a>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
        <div class="d-flex align-items-center mb-2">
          <span class="mr-2" style="font-size:1.5rem;">📈</span>
          <h6 class="font-weight-bold text-dark mb-0">Referral Attribution Log</h6>
        </div>
        <p class="text-muted small mb-3">Live stream of customer orders linked to creator affiliate links and promo codes.</p>
        <a href="<?= base_url('admin/affiliates/referrals') ?>" class="btn btn-outline-info btn-sm font-weight-bold mt-auto" style="border-radius:6px;">
          View Conversion Log &rarr;
        </a>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; background:#f8fafc; border:1px solid #e2e8f0;">
        <div class="d-flex align-items-center mb-2">
          <span class="mr-2" style="font-size:1.5rem;">💸</span>
          <h6 class="font-weight-bold text-dark mb-0">Commission Settlements</h6>
        </div>
        <p class="text-muted small mb-3">Review approved creator commissions, generate UTR bank references, and mark payouts paid.</p>
        <a href="<?= base_url('admin/affiliates/payouts') ?>" class="btn btn-outline-success btn-sm font-weight-bold mt-auto" style="border-radius:6px;">
          Process Payouts &rarr;
        </a>
      </div>
    </div>
  </div>
</div>
