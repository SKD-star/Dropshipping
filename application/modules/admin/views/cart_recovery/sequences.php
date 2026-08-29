<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="fw-bold mb-0">📋 Recovery Sequences</h2><p class="text-muted mb-0">Multi-step email/WhatsApp/SMS recovery flows</p></div>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newSeqModal"><i class="fa fa-plus mr-1"></i> New Sequence</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <?php if (empty($sequences)): ?>
  <div class="alert alert-info"><i class="fa fa-info-circle mr-2"></i>No sequences yet. Create your first recovery sequence.</div>
  <?php else: foreach ($sequences as $seq): ?>
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
      <span class="fw-bold"><?= htmlspecialchars($seq['name']) ?></span>
      <div>
        <span class="badge badge-<?= $seq['is_active'] ? 'success' : 'secondary' ?> mr-2"><?= $seq['is_active'] ? 'Active' : 'Paused' ?></span>
        <form method="post" action="<?= base_url('admin/cart_recovery/sequences') ?>" class="d-inline">
          <?= csrf_field() ?><input type="hidden" name="seq_action" value="toggle_sequence"><input type="hidden" name="id" value="<?= $seq['id'] ?>">
          <button class="btn btn-sm btn-outline-<?= $seq['is_active'] ? 'warning' : 'success' ?>"><?= $seq['is_active'] ? 'Pause' : 'Enable' ?></button>
        </form>
      </div>
    </div>
    <div class="card-body">
      <?php if (empty($seq['steps'])): ?>
      <p class="text-muted small mb-2">No steps yet. Add your first touchpoint:</p>
      <?php else: ?>
      <div class="d-flex flex-wrap gap-2 mb-3">
        <?php foreach ($seq['steps'] as $step): ?>
        <div class="card border-0 bg-light px-3 py-2 d-flex flex-row align-items-center" style="min-width:220px;">
          <i class="fa <?= $step['channel']==='email' ? 'fa-envelope' : ($step['channel']==='whatsapp' ? 'fa-whatsapp' : 'fa-sms') ?> mr-2 text-<?= $step['channel']==='email' ? 'primary' : ($step['channel']==='whatsapp' ? 'success' : 'info') ?>"></i>
          <div class="flex-fill"><div class="small fw-bold"><?= $step['delay_minutes'] ?> min → <?= $step['channel'] ?></div><div style="font-size:.7rem;color:#888;"><?= htmlspecialchars($step['template_key'] ?? '') ?></div></div>
          <form method="post" action="<?= base_url('admin/cart_recovery/sequences') ?>" class="d-inline ml-2">
            <?= csrf_field() ?><input type="hidden" name="seq_action" value="delete_step"><input type="hidden" name="step_id" value="<?= $step['id'] ?>">
            <button class="btn btn-xs btn-outline-danger py-0 px-1" style="font-size:.7rem;"><i class="fa fa-times"></i></button>
          </form>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
      <!-- Add Step -->
      <form method="post" action="<?= base_url('admin/cart_recovery/sequences') ?>" class="d-flex gap-2 flex-wrap align-items-end">
        <?= csrf_field() ?><input type="hidden" name="seq_action" value="add_step"><input type="hidden" name="sequence_id" value="<?= $seq['id'] ?>">
        <div><label class="small">Delay (min)</label><input type="number" name="delay_minutes" class="form-control form-control-sm" value="60" style="width:90px;"></div>
        <div><label class="small">Channel</label><select name="channel" class="form-control form-control-sm"><option value="email">Email</option><option value="whatsapp">WhatsApp</option><option value="sms">SMS</option></select></div>
        <div><label class="small">Template Key</label><input type="text" name="template_key" class="form-control form-control-sm" placeholder="cart_recovery_1" style="width:160px;"></div>
        <button class="btn btn-sm btn-success">+ Add Step</button>
      </form>
    </div>
  </div>
  <?php endforeach; endif; ?>
</div>
<div class="modal fade" id="newSeqModal" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content">
  <div class="modal-header"><h6 class="modal-title">New Sequence</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
  <form method="post" action="<?= base_url('admin/cart_recovery/sequences') ?>">
    <?= csrf_field() ?><input type="hidden" name="seq_action" value="create_sequence">
    <div class="modal-body"><div class="form-group"><label>Sequence Name</label><input type="text" name="name" class="form-control" required placeholder="Default Recovery Flow"></div></div>
    <div class="modal-footer"><button class="btn btn-primary btn-sm">Create</button></div>
  </form>
</div></div></div>
