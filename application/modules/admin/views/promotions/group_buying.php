<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#ec4899;">👥 Group Buying (Team Deals)</h2>
      <p class="text-muted mb-0">Social buying discounts unlocked when minimum buyers team up</p>
    </div>
    <button class="btn btn-primary btn-sm px-4" data-toggle="modal" data-target="#groupModal" style="background:#ec4899;border-color:#ec4899;"><i class="fa fa-plus mr-1"></i> New Group Buy</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Campaign Title</th><th>Product ID</th><th>Team Price</th><th>Min People</th><th>Teams Formed</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($campaigns as $c): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($c['title']) ?></td>
          <td>Product #<?= $c['product_id'] ?></td>
          <td>₹<?= number_format($c['group_price'], 2) ?></td>
          <td><?= $c['min_participants'] ?> members</td>
          <td><span class="badge badge-info"><?= $c['participant_count'] ?? 0 ?> teams</span></td>
          <td><span class="badge badge-<?= $c['is_active'] ? 'success' : 'secondary' ?>"><?= $c['is_active'] ? 'Active' : 'Disabled' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/promotions/group_buying') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="group_action" value="toggle">
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $c['is_active'] ? 'warning' : 'success' ?>"><?= $c['is_active'] ? 'Disable' : 'Enable' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/promotions/group_buying') ?>" class="d-inline" onsubmit="return confirm('Delete this group buy campaign?')">
              <?= csrf_field() ?>
              <input type="hidden" name="group_action" value="delete">
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($campaigns)): ?><tr><td colspan="7" class="text-center text-muted py-5">No group buying campaigns found.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="groupModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Group Buy Deal</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/promotions/group_buying') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="group_action" value="create">
        <div class="modal-body">
          <div class="form-group"><label>Campaign Title *</label><input type="text" name="title" class="form-control" required placeholder="e.g. 2-Person Team Buy: Wireless Earbuds"></div>
          <div class="form-group">
            <label>Product *</label>
            <select name="product_id" class="form-control" required>
              <option value="">Select product...</option>
              <?php foreach ($products as $p): ?>
              <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['title']) ?> (₹<?= number_format($p['base_price'], 2) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row">
            <div class="col-6 form-group"><label>Group Discounted Price (₹) *</label><input type="number" step="0.01" min="1" name="group_price" class="form-control" required placeholder="299"></div>
            <div class="col-6 form-group"><label>Min Team Size *</label><input type="number" min="2" name="min_participants" class="form-control" value="2" required></div>
          </div>
          <div class="form-group"><label>Campaign Ends At</label><input type="datetime-local" name="ends_at" class="form-control"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary" style="background:#ec4899;border-color:#ec4899;">Create Team Deal</button></div>
      </form>
    </div>
  </div>
</div>
