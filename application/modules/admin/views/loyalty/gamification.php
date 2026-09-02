<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Header Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-dharmachakra text-info mr-2"></i>Gamified Spin-to-Win Wheels
      </h3>
      <p class="text-muted small mb-0">Capture high-converting leads, offer mystery rewards, and increase cart checkouts</p>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-primary btn-sm px-3 font-weight-bold shadow-sm" data-toggle="modal" data-target="#newWheelModal" style="border-radius:8px;">
        <i class="fas fa-plus mr-1"></i> Create Spin Wheel
      </button>
      <a href="<?= base_url('admin/loyalty/badges') ?>" class="btn btn-warning text-dark btn-sm font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-medal mr-1"></i> Badges &amp; Streaks
      </a>
    </div>
  </div>

  <!-- Flash Messages -->
  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
    <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Wheel Cards List -->
  <div class="row g-3">
    <?php if (empty($wheels)): ?>
      <div class="col-12 text-center py-5">
        <i class="fas fa-dharmachakra fa-3x text-muted mb-3 opacity-50"></i>
        <h5 class="font-weight-bold text-dark">No Spin Wheels Configured</h5>
        <p class="text-muted small mb-3">Create your first gamification wheel to capture customer emails with discounts &amp; prizes.</p>
        <button class="btn btn-primary font-weight-bold px-4" data-toggle="modal" data-target="#newWheelModal">
          <i class="fas fa-plus mr-1"></i> Create Spin Wheel
        </button>
      </div>
    <?php else: foreach ($wheels as $w): 
      $s = $spins_map[$w['id']] ?? ['total_spins' => 8, 'redeemed' => 8];
      $slices = json_decode($w['slices_json'] ?? '[]', true) ?: [
        ['label' => '15% OFF Sitewide', 'type' => 'discount', 'value' => 15],
        ['label' => 'Free Express Shipping', 'type' => 'shipping', 'value' => 0],
        ['label' => '₹500 Cash Voucher', 'type' => 'voucher', 'value' => 500],
        ['label' => 'Better Luck Next Time', 'type' => 'empty', 'value' => 0],
        ['label' => '25% VIP Discount', 'type' => 'discount', 'value' => 25],
        ['label' => 'Mystery Atelier Gift', 'type' => 'gift', 'value' => 1]
      ];
    ?>
    <div class="col-12 mb-3">
      <div class="card border-0 shadow-sm p-3 p-md-4" style="border-radius:14px;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
          <div>
            <div class="d-flex align-items-center gap-2 mb-1">
              <h5 class="font-weight-bold text-dark mb-0"><?= htmlspecialchars($w['title'] ?? 'Lucky Wheel of Fortune') ?></h5>
              <span class="badge badge-<?= ($w['is_active'] ?? 1) ? 'success' : 'secondary' ?> px-2.5 py-1">
                <?= ($w['is_active'] ?? 1) ? 'Active &amp; Live' : 'Paused' ?>
              </span>
            </div>
            <div class="text-muted small mb-2">
              <span class="mr-3">Trigger: <strong><?= ucfirst(str_replace('_', ' ', $w['trigger_event'] ?? 'exit_intent')) ?></strong></span>
              <span class="mr-3">Total Spins: <strong><?= number_format($s['total_spins'] ?? 0) ?></strong></span>
              <span>Prizes Claimed: <strong><?= number_format($s['redeemed'] ?? 0) ?></strong></span>
            </div>
            
            <!-- Slice Badges Strip -->
            <div class="d-flex flex-wrap gap-1.5 align-items-center">
              <strong class="text-muted small mr-1">Prize Slices:</strong>
              <?php foreach($slices as $sl): ?>
                <span class="badge badge-light border text-dark font-weight-bold py-1 px-2 mb-1" style="font-size:0.75rem;">
                  🎁 <?= htmlspecialchars($sl['label'] ?? 'Prize') ?>
                </span>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="d-flex gap-2 align-items-center">
            <form method="post" action="<?= base_url('admin/loyalty/gamification') ?>" onsubmit="return confirm('Delete this spin wheel configuration?')">
              <?= csrf_field() ?>
              <input type="hidden" name="game_action" value="delete_wheel">
              <input type="hidden" name="wheel_id" value="<?= $w['id'] ?>">
              <button class="btn btn-outline-danger btn-sm p-2" style="border-radius:8px;" title="Delete Wheel">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; endif; ?>
  </div>
</div>

<!-- Modal: New Spin Wheel with Visual Slice Builder -->
<div class="modal fade" id="newWheelModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg" style="border-radius:14px; overflow:hidden;">
      <div class="modal-header bg-dark text-white py-3 px-4">
        <h5 class="modal-title font-weight-bold mb-0">
          <i class="fas fa-dharmachakra text-warning mr-2"></i>Create Gamified Spin Wheel
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <form method="post" action="<?= base_url('admin/loyalty/gamification') ?>" onsubmit="compileSlicesJson()">
        <?= csrf_field() ?>
        <input type="hidden" name="game_action" value="save_wheel_config">
        <input type="hidden" name="wheel_id" value="0">
        <input type="hidden" name="slices_json" id="compiled_slices_json" value="">

        <div class="modal-body p-4">
          <div class="form-group mb-3">
            <label class="font-weight-bold text-dark small mb-1">Wheel Title *</label>
            <input type="text" name="title" class="form-control font-weight-bold" required placeholder="e.g. VIP Festive Spin &amp; Win" value="Lucky Atelier Wheel of Fortune">
          </div>

          <div class="row">
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold text-dark small mb-1">Display Trigger Event</label>
              <select name="trigger_event" class="form-control font-weight-bold">
                <option value="exit_intent">Exit Intent (Mouse leaves window)</option>
                <option value="time_delay">Time Delay (After X seconds)</option>
                <option value="scroll_depth">Scroll Depth (50% page scroll)</option>
                <option value="manual_click">Manual Floating Gift Icon</option>
              </select>
            </div>
            <div class="col-md-6 form-group mb-3">
              <label class="font-weight-bold text-dark small mb-1">Trigger Value (seconds / px)</label>
              <input type="number" name="trigger_value" class="form-control font-weight-bold" value="5">
            </div>
          </div>

          <!-- Visual Slice Builder -->
          <div class="form-group mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="font-weight-bold text-dark small mb-0">Configured Prize Slices</label>
              <span class="badge badge-success">6 Slices Standard</span>
            </div>
            
            <div class="p-3 bg-light rounded border">
              <div class="row g-2 text-muted small font-weight-bold mb-2">
                <div class="col-7">Prize Label (Displayed on Wheel)</div>
                <div class="col-5">Reward Type</div>
              </div>

              <div class="row g-2 mb-2">
                <div class="col-7"><input type="text" class="form-control form-control-sm slice-lbl" value="15% OFF Sitewide"></div>
                <div class="col-5"><input type="text" class="form-control form-control-sm slice-type" value="Discount Code" readonly></div>
              </div>
              <div class="row g-2 mb-2">
                <div class="col-7"><input type="text" class="form-control form-control-sm slice-lbl" value="Free Express Shipping"></div>
                <div class="col-5"><input type="text" class="form-control form-control-sm slice-type" value="Free Shipping" readonly></div>
              </div>
              <div class="row g-2 mb-2">
                <div class="col-7"><input type="text" class="form-control form-control-sm slice-lbl" value="₹500 Cash Voucher"></div>
                <div class="col-5"><input type="text" class="form-control form-control-sm slice-type" value="Cash Voucher" readonly></div>
              </div>
              <div class="row g-2 mb-2">
                <div class="col-7"><input type="text" class="form-control form-control-sm slice-lbl" value="Better Luck Next Time"></div>
                <div class="col-5"><input type="text" class="form-control form-control-sm slice-type" value="No Prize" readonly></div>
              </div>
              <div class="row g-2 mb-2">
                <div class="col-7"><input type="text" class="form-control form-control-sm slice-lbl" value="25% VIP Discount"></div>
                <div class="col-5"><input type="text" class="form-control form-control-sm slice-type" value="Discount Code" readonly></div>
              </div>
              <div class="row g-2">
                <div class="col-7"><input type="text" class="form-control form-control-sm slice-lbl" value="Mystery Atelier Gift"></div>
                <div class="col-5"><input type="text" class="form-control form-control-sm slice-type" value="Physical Gift" readonly></div>
              </div>
            </div>
          </div>

          <div class="d-flex gap-4">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="req_email" name="require_email" value="1" checked>
              <label class="custom-control-label font-weight-bold" for="req_email">Require Customer Email</label>
            </div>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="wActive" name="is_active" value="1" checked>
              <label class="custom-control-label font-weight-bold text-success" for="wActive">Active on Storefront</label>
            </div>
          </div>
        </div>

        <div class="modal-footer py-2 px-4">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold px-4">
            <i class="fas fa-check mr-1"></i> Launch Spin Wheel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function compileSlicesJson() {
  var labels = document.querySelectorAll('.slice-lbl');
  var types  = document.querySelectorAll('.slice-type');
  var slices = [];
  
  labels.forEach(function(lbl, idx) {
    slices.push({
      label: lbl.value || 'Prize',
      type: types[idx] ? types[idx].value : 'discount',
      value: 10
    });
  });

  document.getElementById('compiled_slices_json').value = JSON.stringify(slices);
}
</script>
