<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">🎰 Gamification Wheels</h2>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newWheelModal"><i class="fa fa-plus mr-1"></i> New Wheel</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success"><?= htmlspecialchars($this->session->flashdata('success')) ?></div><?php endif; ?>

  <?php if (empty($wheels)): ?>
  <p class="text-muted">No spin wheels configured. Create one to start capturing leads with gamification.</p>
  <?php else: foreach ($wheels as $w): $s = $spins_map[$w['id']] ?? []; ?>
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body d-flex align-items-center justify-content-between">
      <div>
        <h6 class="fw-bold mb-0"><?= htmlspecialchars($w['title']??'Wheel') ?></h6>
        <small class="text-muted">Trigger: <strong><?= $w['trigger_event']??'' ?></strong> | Spins: <?= $s['total_spins']??0 ?> | Redeemed: <?= $s['redeemed']??0 ?></small>
        <?php $slices = json_decode($w['slices_json']??'[]', true); if (!empty($slices)): ?>
        <div class="mt-1"><?php foreach($slices as $sl): ?><span class="badge badge-secondary mr-1"><?= htmlspecialchars($sl['label']??'') ?></span><?php endforeach; ?></div>
        <?php endif; ?>
      </div>
      <div>
        <span class="badge badge-<?= $w['is_active']?'success':'secondary' ?> mr-2"><?= $w['is_active']?'Active':'Off' ?></span>
        <form method="post" action="<?= base_url('admin/loyalty/gamification') ?>" class="d-inline" onsubmit="return confirm('Delete this wheel and all its spins?')">
          <?= csrf_field() ?><input type="hidden" name="game_action" value="delete_wheel"><input type="hidden" name="wheel_id" value="<?= $w['id'] ?>">
          <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach; endif; ?>
</div>

<div class="modal fade" id="newWheelModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
  <div class="modal-header"><h5 class="modal-title">New Spin Wheel</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
  <form method="post" action="<?= base_url('admin/loyalty/gamification') ?>">
    <?= csrf_field() ?><input type="hidden" name="game_action" value="save_wheel_config"><input type="hidden" name="wheel_id" value="0">
    <div class="modal-body">
      <div class="form-group"><label>Wheel Title</label><input type="text" name="title" class="form-control" required placeholder="Diwali Spin &amp; Win"></div>
      <div class="row"><div class="col-6 form-group"><label>Trigger Event</label><select name="trigger_event" class="form-control"><option value="exit_intent">Exit Intent</option><option value="time_delay">Time Delay</option><option value="scroll_depth">Scroll Depth</option><option value="manual_click">Manual Click</option></select></div><div class="col-6 form-group"><label>Trigger Value (seconds/px)</label><input type="number" name="trigger_value" class="form-control" value="5"></div></div>
      <div class="form-group"><label>Slices JSON <small class="text-muted">[{"label":"10% Off","type":"discount","value":10},...]</small></label><textarea name="slices_json" class="form-control font-monospace" rows="4">[]</textarea></div>
      <div class="d-flex gap-3">
        <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="req_email" name="require_email" value="1" checked><label class="custom-control-label" for="req_email">Require Email</label></div>
        <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="wActive" name="is_active" value="1" checked><label class="custom-control-label" for="wActive">Active</label></div>
      </div>
    </div>
    <div class="modal-footer"><button class="btn btn-primary">Create Wheel</button></div>
  </form>
</div></div></div>
