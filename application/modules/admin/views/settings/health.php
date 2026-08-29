<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#1cc88a;">🩺 System Health Diagnostics &amp; Self-Healing</h2>
      <p class="text-muted mb-0">Automated diagnostic scanner and 1-click self-healing engine for database, cache &amp; storage integrity</p>
    </div>
    <form method="post" action="<?= base_url('admin/settings/health') ?>" onsubmit="return confirm('Run automated self-healing maintenance cycle?')">
      <?= csrf_field() ?>
      <input type="hidden" name="health_action" value="self_heal">
      <button type="submit" class="btn btn-success btn-sm px-4 shadow-sm font-weight-bold">
        <i class="fa fa-magic mr-1"></i> Run 1-Click Self-Healing
      </button>
    </form>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="row g-3 mb-4">
    <?php foreach ($diagnostics as $diag):
      $badge_class = ($diag['status'] === 'healthy') ? 'badge-success' : (($diag['status'] === 'warning') ? 'badge-warning text-dark' : 'badge-danger');
      $border_color = ($diag['status'] === 'healthy') ? '#1cc88a' : (($diag['status'] === 'warning') ? '#f59e0b' : '#e74a3b');
    ?>
    <div class="col-md-6 col-xl-4">
      <div class="card border-0 shadow-sm h-100" style="border-left:4px solid <?= $border_color ?>!important;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold text-dark mb-0"><?= htmlspecialchars($diag['name']) ?></h6>
            <span class="badge <?= $badge_class ?>"><?= htmlspecialchars($diag['value']) ?></span>
          </div>
          <p class="text-muted small mb-0"><?= htmlspecialchars($diag['description']) ?></p>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="card border-0 shadow-sm bg-light">
    <div class="card-body p-4">
      <h6 class="fw-bold mb-2"><i class="fa fa-shield-alt text-primary mr-2"></i>Automated Self-Healing Capabilities</h6>
      <ul class="small text-muted mb-0 pl-3">
        <li><strong>Media Storage Restoration:</strong> Automatically creates and verifies file permissions on <code>assets/uploads/</code> for smooth product image uploads.</li>
        <li><strong>Cache Pruning:</strong> Checks write permissions on <code>application/cache/</code> for fast view caching.</li>
        <li><strong>Stale Session Garbage Collection:</strong> Automatically purges expired session records from <code>ci_sessions</code> to prevent database bloat.</li>
        <li><strong>Stale Task Queue Cleanup:</strong> Flushes old failed queue records from <code>ai_agent_tasks</code> older than 30 days.</li>
      </ul>
    </div>
  </div>
</div>
