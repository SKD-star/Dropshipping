<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="fw-bold mb-0" style="color:#f59e0b;">⚡ Flash Sales</h2><p class="text-muted mb-0">Time-limited deals with countdown &amp; stock bars</p></div>
    <button class="btn btn-warning text-white btn-sm px-4" data-toggle="modal" data-target="#createFlashModal"><i class="fa fa-plus mr-1"></i> New Flash Sale</button>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('error')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead style="background:#fef3cd;"><tr><th>Title</th><th>Discount</th><th>Starts</th><th>Ends</th><th>Badge</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if (empty($flash_sales)): ?>
        <tr><td colspan="7" class="text-center text-muted py-5">No flash sales yet. Create your first one!</td></tr>
        <?php else: foreach ($flash_sales as $fs): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($fs['title']) ?></td>
          <td><?= $fs['discount_value'] ?><?= $fs['discount_type']==='percent' ? '%' : ' flat' ?> off</td>
          <td><small><?= $fs['starts_at'] ?></small></td>
          <td><small><?= $fs['ends_at'] ?></small></td>
          <td><span class="badge badge-warning text-dark"><?= htmlspecialchars($fs['badge_text'] ?? 'FLASH') ?></span></td>
          <td>
            <?php $now = date('Y-m-d H:i:s');
            if (!$fs['is_active']) { echo '<span class="badge badge-secondary">Inactive</span>'; }
            elseif ($fs['ends_at'] < $now) { echo '<span class="badge badge-danger">Expired</span>'; }
            elseif ($fs['starts_at'] > $now) { echo '<span class="badge badge-info">Scheduled</span>'; }
            else { echo '<span class="badge badge-success">Live</span>'; } ?>
          </td>
          <td>
            <form method="post" action="<?= base_url('admin/promotions/flash_sales') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="flash_action" value="toggle_flash">
              <input type="hidden" name="flash_id" value="<?= $fs['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $fs['is_active'] ? 'warning' : 'success' ?>"><?= $fs['is_active'] ? 'Deactivate' : 'Activate' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/promotions/flash_sales') ?>" class="d-inline" onsubmit="return confirm('Delete this flash sale?')">
              <?= csrf_field() ?>
              <input type="hidden" name="flash_action" value="delete_flash">
              <input type="hidden" name="flash_id" value="<?= $fs['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createFlashModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Flash Sale</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/promotions/flash_sales') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="flash_action" value="create_flash">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 form-group"><label>Title *</label><input type="text" name="title" class="form-control" required placeholder="e.g. Diwali Flash Sale"></div>
            <div class="col-md-3 form-group"><label>Discount Type</label><select name="discount_type" class="form-control"><option value="percent">Percent (%)</option><option value="fixed">Fixed (&#8377;)</option></select></div>
            <div class="col-md-3 form-group"><label>Value *</label><input type="number" step="0.01" min="0" name="discount_value" class="form-control" required placeholder="20"></div>
            <div class="col-md-6 form-group"><label>Starts At</label><input type="datetime-local" name="starts_at" class="form-control"></div>
            <div class="col-md-6 form-group"><label>Ends At</label><input type="datetime-local" name="ends_at" class="form-control"></div>
            <div class="col-md-4 form-group"><label>Badge Text</label><input type="text" name="badge_text" class="form-control" value="FLASH DEAL"></div>
            <div class="col-md-4 form-group"><label>Min Purchase (&#8377;)</label><input type="number" step="0.01" min="0" name="min_purchase" class="form-control" value="0"></div>
            <div class="col-md-4 form-group"><label>Max Uses</label><input type="number" min="0" name="max_uses" class="form-control" placeholder="Unlimited"></div>
            <div class="col-md-6"><div class="custom-control custom-switch mt-3"><input type="checkbox" class="custom-control-input" id="showTimer" name="show_timer" value="1" checked><label class="custom-control-label" for="showTimer">Show Countdown Timer</label></div></div>
            <div class="col-md-6"><div class="custom-control custom-switch mt-3"><input type="checkbox" class="custom-control-input" id="showStock" name="show_stock_bar" value="1" checked><label class="custom-control-label" for="showStock">Show Stock Bar</label></div></div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-warning text-white">Create Flash Sale</button></div>
      </form>
    </div>
  </div>
</div>
