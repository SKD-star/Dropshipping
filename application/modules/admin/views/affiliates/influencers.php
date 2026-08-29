<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">🌟 Influencers</h2>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#infModal"><i class="fa fa-plus mr-1"></i> Add Influencer</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Name</th><th>Platform</th><th>Handle</th><th>Code</th><th>Commission</th><th>Referrals</th><th>Earned</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($influencers as $inf): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($inf['name']) ?></td>
          <td><?= htmlspecialchars($inf['platform'] ?? '—') ?></td>
          <td><a href="#" class="text-decoration-none">@<?= htmlspecialchars($inf['handle'] ?? '') ?></a></td>
          <td><code><?= htmlspecialchars($inf['referral_code'] ?? '') ?></code></td>
          <td><?= $inf['commission_rate'] ?>%</td>
          <td><?= number_format($inf['referral_count'] ?? 0) ?></td>
          <td>&#8377;<?= number_format($inf['total_earned'] ?? 0, 2) ?></td>
          <td><span class="badge badge-<?= $inf['status']==='active' ? 'success' : 'secondary' ?>"><?= ucfirst($inf['status']) ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/affiliates/influencers') ?>" class="d-inline">
              <?= csrf_field() ?><input type="hidden" name="influencer_action" value="toggle"><input type="hidden" name="id" value="<?= $inf['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $inf['status']==='active' ? 'warning' : 'success' ?>"><?= $inf['status']==='active' ? 'Pause' : 'Activate' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/affiliates/influencers') ?>" class="d-inline" onsubmit="return confirm('Remove?')">
              <?= csrf_field() ?><input type="hidden" name="influencer_action" value="delete"><input type="hidden" name="id" value="<?= $inf['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($influencers)): ?><tr><td colspan="9" class="text-center text-muted py-4">No influencers yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="infModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
  <div class="modal-header"><h5 class="modal-title">Add Influencer</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
  <form method="post" action="<?= base_url('admin/affiliates/influencers') ?>">
    <?= csrf_field() ?><input type="hidden" name="influencer_action" value="create">
    <div class="modal-body">
      <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
      <div class="row"><div class="col-6 form-group"><label>Platform</label><select name="platform" class="form-control"><option>Instagram</option><option>YouTube</option><option>TikTok</option><option>Twitter</option><option>Blog</option></select></div><div class="col-6 form-group"><label>Handle</label><input type="text" name="handle" class="form-control" placeholder="@username"></div></div>
      <div class="form-group"><label>Commission Rate (%)</label><input type="number" step="0.01" min="0" name="commission_rate" class="form-control" value="10"></div>
    </div>
    <div class="modal-footer"><button class="btn btn-primary">Add Influencer</button></div>
  </form>
</div></div></div>
