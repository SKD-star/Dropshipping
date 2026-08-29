<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">📢 Announcement Banners</h2>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#annModal"><i class="fa fa-plus mr-1"></i> New Banner</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Message Preview</th><th>Schedule</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($announcements as $ann): ?>
        <tr>
          <td>
            <div style="background:<?= $ann['bg_color'] ?? '#4e73df' ?>;color:<?= $ann['text_color'] ?? '#fff' ?>;padding:6px 12px;border-radius:4px;display:inline-block;font-size:0.85rem;">
              <?= htmlspecialchars($ann['message'] ?? '') ?>
            </div>
          </td>
          <td><small><?= $ann['starts_at'] ?? 'Immediate' ?> – <?= $ann['ends_at'] ?? 'Never expires' ?></small></td>
          <td><span class="badge badge-<?= $ann['is_active'] ? 'success' : 'secondary' ?>"><?= $ann['is_active'] ? 'Active' : 'Disabled' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/settings/announcements') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="ann_action" value="toggle">
              <input type="hidden" name="id" value="<?= $ann['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $ann['is_active'] ? 'warning' : 'success' ?>"><?= $ann['is_active'] ? 'Disable' : 'Enable' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/settings/announcements') ?>" class="d-inline" onsubmit="return confirm('Delete announcement banner?')">
              <?= csrf_field() ?>
              <input type="hidden" name="ann_action" value="delete">
              <input type="hidden" name="id" value="<?= $ann['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($announcements)): ?><tr><td colspan="4" class="text-center text-muted py-5">No announcement banners created yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="annModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Banner</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/settings/announcements') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="ann_action" value="create">
        <div class="modal-body">
          <div class="form-group"><label>Banner Text *</label><input type="text" name="message" class="form-control" required placeholder="⚡ Flash Sale: 20% OFF all items today!"></div>
          <div class="row">
            <div class="col-6 form-group"><label>Background Color</label><input type="color" name="bg_color" class="form-control form-control-color w-100" value="#4e73df"></div>
            <div class="col-6 form-group"><label>Text Color</label><input type="color" name="text_color" class="form-control form-control-color w-100" value="#ffffff"></div>
          </div>
          <div class="form-group"><label>Click URL (optional)</label><input type="url" name="link_url" class="form-control" placeholder="https://..."></div>
          <div class="row">
            <div class="col-6 form-group"><label>Starts At</label><input type="datetime-local" name="starts_at" class="form-control"></div>
            <div class="col-6 form-group"><label>Ends At</label><input type="datetime-local" name="ends_at" class="form-control"></div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create Banner</button></div>
      </form>
    </div>
  </div>
</div>
