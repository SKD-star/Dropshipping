<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── System Health & Self-Healing Diagnostics UI ── */
.health-hero {
  background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 24px rgba(5, 150, 105, 0.2);
}
.health-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 10px rgba(0,0,0,.04);
  background: #fff;
  transition: all .2s ease;
  overflow: hidden;
}
.health-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0,0,0,.07);
}
</style>

<div class="container-fluid py-4">

  <!-- Hero Header -->
  <div class="health-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.75rem;">🩺</span>
        <h2 class="fw-bold mb-0 text-white">System Diagnostics &amp; Self-Healing</h2>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Automated integrity inspection, database session garbage collection, and 1-click self-repair</p>
    </div>
    
    <form method="post" action="<?= base_url('admin/settings/health') ?>" onsubmit="return confirm('Run automated self-healing maintenance cycle?')">
      <?= csrf_field() ?>
      <input type="hidden" name="health_action" value="self_heal">
      <button type="submit" class="btn btn-light text-success font-weight-bold px-4 shadow-sm" style="border-radius:8px;">
        <i class="fa fa-magic mr-1"></i> Run 1-Click Self-Healing
      </button>
    </form>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Diagnostic Inspection Cards -->
  <div class="row g-3 mb-4">
    <?php foreach ($diagnostics as $diag):
      $is_ok = ($diag['status'] === 'healthy');
      $is_warn = ($diag['status'] === 'warning');
      $border_color = $is_ok ? '#10b981' : ($is_warn ? '#f59e0b' : '#ef4444');
      $badge_class = $is_ok ? 'badge-success' : ($is_warn ? 'badge-warning text-dark' : 'badge-danger');
      $icon = $is_ok ? '✅' : ($is_warn ? '⚠️' : '❌');
    ?>
    <div class="col-md-6 col-xl-4">
      <div class="health-card h-100 p-3" style="border-left: 4px solid <?= $border_color ?> !important;">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <div class="d-flex align-items-center gap-2">
            <span><?= $icon ?></span>
            <h6 class="fw-bold text-dark mb-0 font-weight-bold" style="font-size:.92rem;"><?= htmlspecialchars($diag['name']) ?></h6>
          </div>
          <span class="badge <?= $badge_class ?>"><?= htmlspecialchars($diag['value']) ?></span>
        </div>
        <p class="text-muted small mb-0"><?= htmlspecialchars($diag['description']) ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Capabilities Matrix -->
  <div class="health-card p-4">
    <div class="d-flex align-items-center gap-2 mb-3">
      <i class="fa fa-shield-alt text-success fa-lg"></i>
      <h6 class="fw-bold mb-0 text-dark">Automated Self-Healing Engine Protocol</h6>
    </div>
    <div class="row g-3">
      <div class="col-md-6 col-lg-3">
        <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
          <div class="font-weight-bold small text-dark mb-1">📁 Storage Restorer</div>
          <small class="text-muted">Verifies directory permissions for <code>assets/uploads/</code> to guarantee frictionless product image uploads.</small>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
          <div class="font-weight-bold small text-dark mb-1">⚡ Cache Pruner</div>
          <small class="text-muted">Inspects and resets CodeIgniter query and view fragments in <code>application/cache/</code>.</small>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
          <div class="font-weight-bold small text-dark mb-1">🧹 Session GC</div>
          <small class="text-muted">Purges inactive database sessions older than 7 days from <code>ci_sessions</code> to prevent table bloat.</small>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
          <div class="font-weight-bold small text-dark mb-1">🤖 Queue Flusher</div>
          <small class="text-muted">Cleans stale AI swarm task logs and failed operations older than 30 days to keep databases optimized.</small>
        </div>
      </div>
    </div>
  </div>

</div>
