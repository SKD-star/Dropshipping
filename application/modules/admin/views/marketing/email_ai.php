<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#ec4899;">✉️ AI Email Marketing Studio</h2>
      <p class="text-muted mb-0">Autonomous AI newsletter generation &amp; high-converting promotional broadcasts</p>
    </div>
    <div class="d-flex gap-2">
      <form method="post" action="<?= base_url('admin/marketing/email_ai') ?>" class="d-inline mr-2">
        <?= csrf_field() ?>
        <input type="hidden" name="email_action" value="generate_weekly_newsletter">
        <button type="submit" class="btn btn-success btn-sm px-3 shadow-sm"><i class="fa fa-magic mr-1"></i> Auto-Generate Newsletter</button>
      </form>
      <button class="btn btn-primary btn-sm px-3 shadow-sm" data-toggle="modal" data-target="#newEmailModal"><i class="fa fa-plus mr-1"></i> Create Campaign</button>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #ec4899;">
        <i class="fa fa-users fa-2x mb-2 text-primary"></i>
        <div style="font-size:1.5rem;font-weight:800;"><?= number_format($subscribers_count) ?></div>
        <div class="text-muted small">Total Subscribers / Audience Reach</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #10b981;">
        <i class="fa fa-envelope-open-text fa-2x mb-2 text-success"></i>
        <div style="font-size:1.5rem;font-weight:800;"><?= count($campaigns) ?></div>
        <div class="text-muted small">Email Campaigns Compiled</div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">Recent Email Campaigns</div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Campaign Name</th><th>Subject Line</th><th>Status</th><th>Created At</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($campaigns as $c): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($c['name']) ?></td>
          <td><?= htmlspecialchars($c['subject']) ?></td>
          <td><span class="badge badge-<?= $c['status'] === 'sent' ? 'success' : ($c['status'] === 'ready' ? 'primary' : 'secondary') ?>"><?= ucfirst($c['status'] ?? 'draft') ?></span></td>
          <td><small><?= $c['created_at'] ?? '' ?></small></td>
          <td>
            <form method="post" action="<?= base_url('admin/marketing/email_ai') ?>" class="d-inline" onsubmit="return confirm('Delete this email campaign?')">
              <?= csrf_field() ?>
              <input type="hidden" name="email_action" value="delete">
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($campaigns)): ?><tr><td colspan="5" class="text-center text-muted py-5">No email campaigns created yet. Click "Auto-Generate Newsletter" above!</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="newEmailModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Email Campaign</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/marketing/email_ai') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="email_action" value="create_campaign">
        <div class="modal-body">
          <div class="form-group"><label>Campaign Name *</label><input type="text" name="campaign_name" class="form-control" required placeholder="e.g. VIP Summer Drop"></div>
          <div class="form-group"><label>Subject Line *</label><input type="text" name="subject" class="form-control" required placeholder="✨ Exclusive access: The new collection has arrived"></div>
          <div class="form-group"><label>Email Body (HTML) *</label><textarea name="body_html" class="form-control font-monospace" rows="8" required placeholder="<h2>Hello VIP,</h2><p>Check out our latest collection...</p>"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save Draft</button></div>
      </form>
    </div>
  </div>
</div>
