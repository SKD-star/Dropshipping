<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-1" style="color:#4e73df;">🤖 AI Engine</h2>
  <p class="text-muted mb-3">Agent status, orchestrator runs &amp; task queue</p>

  <!-- Status Summary -->
  <div class="row g-3 mb-4">
    <?php $colors = ['pending'=>'warning','running'=>'info','done'=>'success','failed'=>'danger','awaiting_approval'=>'secondary'];
    foreach ($status_counts as $s => $cnt): ?>
    <div class="col-6 col-md-2">
      <div class="card border-0 shadow-sm text-center py-3"><div style="font-size:1.3rem;font-weight:800;"><?= number_format($cnt) ?></div><div class="text-muted small text-capitalize"><?= str_replace('_',' ',$s) ?></div></div>
    </div>
    <?php endforeach; ?>
    <div class="col-6 col-md-2"><a href="<?= base_url('admin/ai_engine/swarm') ?>" class="card border-0 shadow-sm text-center py-3 d-block text-decoration-none h-100 bg-primary text-white"><i class="fa fa-robot fa-2x mb-1"></i><div class="small">Run Agents</div></a></div>
    <div class="col-6 col-md-2"><a href="<?= base_url('admin/ai_engine/autopilot') ?>" class="card border-0 shadow-sm text-center py-3 d-block text-decoration-none h-100 bg-success text-white"><i class="fa fa-magic fa-2x mb-1"></i><div class="small">Autopilot</div></a></div>
    <div class="col-6 col-md-2"><a href="<?= base_url('admin/ai_engine/repricer') ?>" class="card border-0 shadow-sm text-center py-3 d-block text-decoration-none h-100 bg-warning text-white"><i class="fa fa-tags fa-2x mb-1"></i><div class="small">Repricer</div></a></div>
  </div>

  <!-- Recent Tasks -->
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold"><i class="fa fa-list-alt mr-2 text-primary"></i>Recent Agent Tasks</div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead><tr><th>#</th><th>Agent</th><th>Status</th><th>Output</th><th>Created</th></tr></thead>
        <tbody>
        <?php foreach ($recent_tasks as $t):
          $sc = ['done'=>'success','failed'=>'danger','running'=>'info','pending'=>'warning','awaiting_approval'=>'secondary'][$t['status']] ?? 'secondary';
        ?>
        <tr>
          <td><?= $t['id'] ?></td>
          <td><code><?= htmlspecialchars($t['agent'] ?? '') ?></code></td>
          <td><span class="badge badge-<?= $sc ?>"><?= $t['status'] ?></span></td>
          <td><small class="text-muted"><?= htmlspecialchars(mb_strimwidth($t['output_text'] ?? '', 0, 80, '…')) ?></small></td>
          <td><small><?= $t['created_at'] ?></small></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($recent_tasks)): ?><tr><td colspan="5" class="text-center text-muted py-4">No tasks yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Awaiting Approval -->
  <?php $pending_approval = array_filter($recent_tasks, fn($t) => $t['status'] === 'awaiting_approval'); ?>
  <?php if (!empty($pending_approval)): ?>
  <div class="card border-0 shadow-sm border-warning">
    <div class="card-header bg-warning text-white fw-bold"><i class="fa fa-exclamation-triangle mr-2"></i>Tasks Awaiting Your Approval</div>
    <div class="card-body p-0">
      <table class="table table-sm mb-0">
        <thead><tr><th>#</th><th>Agent</th><th>Preview</th><th>Approve/Reject</th></tr></thead>
        <tbody>
        <?php foreach ($pending_approval as $t): ?>
        <tr>
          <td><?= $t['id'] ?></td>
          <td><code><?= htmlspecialchars($t['agent']) ?></code></td>
          <td><small><?= htmlspecialchars(mb_strimwidth($t['output_text'] ?? '', 0, 120, '…')) ?></small></td>
          <td>
            <form method="post" action="<?= base_url('admin/ai_engine/approve_task/'.$t['id']) ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="decision" value="approve">
              <button class="btn btn-success btn-sm mr-1">Approve</button>
            </form>
            <form method="post" action="<?= base_url('admin/ai_engine/approve_task/'.$t['id']) ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="decision" value="reject">
              <button class="btn btn-danger btn-sm">Reject</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
</div>
