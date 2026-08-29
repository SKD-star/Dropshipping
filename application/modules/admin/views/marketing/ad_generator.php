<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#f59e0b;">📢 Autonomous AI Ad Campaign &amp; ROAS Studio</h2>
      <p class="text-muted mb-0">Multi-channel ad copy generator optimized for Meta (Instagram/Facebook), TikTok, and Google Ads</p>
    </div>
    <button class="btn btn-warning text-white btn-sm px-3 shadow-sm font-weight-bold" data-toggle="modal" data-target="#newAdModal"><i class="fa fa-robot mr-1"></i> Generate AI Ad</button>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="row g-3">
    <?php foreach ($campaigns as $ad): ?>
    <div class="col-md-6 mb-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <span class="badge badge-warning text-dark px-2 py-1"><i class="fa fa-ad mr-1"></i> <?= htmlspecialchars($ad['platform'] ?? 'Meta') ?></span>
          <span class="badge badge-success">Est. ROAS: <?= $ad['est_roas'] ?? '4.2' ?>x</span>
        </div>
        <div class="card-body">
          <h6 class="fw-bold mb-1 text-primary"><?= htmlspecialchars($ad['product_title'] ?? 'Product Ad') ?></h6>
          <p class="font-weight-bold mb-2"><?= htmlspecialchars($ad['headline'] ?? '') ?></p>
          <div class="bg-light p-3 rounded small mb-3" style="white-space: pre-line;">
            <?= htmlspecialchars($ad['primary_text'] ?? '') ?>
          </div>
          <p class="text-muted small mb-0"><strong>Targeting:</strong> <?= htmlspecialchars($ad['target_audience'] ?? 'General') ?></p>
        </div>
        <div class="card-footer bg-white text-right">
          <form method="post" action="<?= base_url('admin/marketing/ad_generator') ?>" class="d-inline" onsubmit="return confirm('Delete this ad campaign?')">
            <?= csrf_field() ?>
            <input type="hidden" name="ad_action" value="delete">
            <input type="hidden" name="id" value="<?= $ad['id'] ?>">
            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash mr-1"></i> Delete</button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($campaigns)): ?>
    <div class="col-12"><div class="card border-0 shadow-sm text-center py-5 text-muted">No AI ad campaigns generated yet. Click "Generate AI Ad" to start!</div></div>
    <?php endif; ?>
  </div>
</div>

<div class="modal fade" id="newAdModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Generate Autonomous AI Ad Campaign</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/marketing/ad_generator') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="ad_action" value="generate_campaign">
        <div class="modal-body">
          <div class="form-group">
            <label>Select Product *</label>
            <select name="product_id" class="form-control" required>
              <option value="">Choose product...</option>
              <?php foreach ($products as $p): ?>
              <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['title']) ?> (₹<?= number_format($p['base_price'], 2) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Target Advertising Platform</label>
            <select name="platform" class="form-control">
              <option value="Meta Instagram Reels">Meta Instagram Reels / Stories</option>
              <option value="TikTok Viral Feed">TikTok Viral Feed</option>
              <option value="Google Performance Max">Google Performance Max &amp; Search</option>
              <option value="Facebook Feeds">Facebook High-Intent Feeds</option>
            </select>
          </div>
          <div class="form-group">
            <label>Creative Angle</label>
            <select name="angle" class="form-control">
              <option value="Luxury Aesthetic">Luxury Aesthetic &amp; Exclusivity</option>
              <option value="FOMO / Limited Drop">Urgency &amp; Limited Drop</option>
              <option value="Problem-Solver / Value">Functional Problem-Solver</option>
              <option value="Social Proof / Viral">Viral Social Proof</option>
            </select>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-warning text-white font-weight-bold">Generate Ad Copy</button></div>
      </form>
    </div>
  </div>
</div>
