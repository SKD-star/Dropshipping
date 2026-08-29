<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-1">🤖 Autopilot Config</h2>
  <p class="text-muted mb-4">Configure which AI tasks run automatically on schedule</p>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><i class="fa fa-magic mr-2 text-success"></i>Automation Settings</div>
        <form method="post" action="<?= base_url('admin/ai_engine/autopilot') ?>">
          <?= csrf_field() ?>
          <input type="hidden" name="autopilot_action" value="save_config">
          <div class="card-body">
            <div class="row">
              <?php $toggles = [
                ['auto_pricing', '💰 Auto Pricing', 'Automatically reprice products daily'],
                ['auto_restock', '📦 Auto Restock Alerts', 'Send low-stock alert emails'],
                ['auto_email', '📧 Auto Email Campaigns', 'Run abandoned cart + loyalty emails'],
                ['auto_seo', '🔍 Auto SEO Content', 'Generate product descriptions weekly'],
              ]; foreach ($toggles as $t): ?>
              <div class="col-md-12 mb-3">
                <div class="card bg-light border-0">
                  <div class="card-body py-2 d-flex align-items-center justify-content-between">
                    <div>
                      <div class="fw-bold"><?= $t[0] ?></div>
                      <small class="text-muted"><?= $t[2] ?></small>
                    </div>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="<?= $t[0] ?>" name="<?= $t[0] ?>" value="1" <?= !empty($config[$t[0]]) ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="<?= $t[0] ?>"></label>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
              <div class="col-md-6 form-group">
                <label>Run Every (hours)</label>
                <input type="number" name="interval_hours" class="form-control" value="<?= $config['run_interval_hours'] ?? 24 ?>" min="1" max="168">
              </div>
            </div>
          </div>
          <div class="card-footer bg-white text-right">
            <button type="submit" class="btn btn-success px-4">Save Autopilot Config</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
