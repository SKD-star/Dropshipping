<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#9333ea;">⚡ Autonomous Multi-Agent Swarm Mesh</h2>
      <p class="text-muted mb-0">Hierarchical consensus network of specialized autonomous AI worker agents</p>
    </div>
    <form method="post" action="<?= base_url('admin/ai_engine/swarm') ?>" onsubmit="return confirm('Execute full multi-agent consensus cycle?')">
      <?= csrf_field() ?>
      <input type="hidden" name="action_type" value="run_swarm_cycle">
      <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm font-weight-bold" style="background:#9333ea;border-color:#9333ea;">
        <i class="fa fa-robot mr-1"></i> Run 1-Click Multi-Agent Swarm Cycle
      </button>
    </form>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= nl2br(htmlspecialchars($this->session->flashdata('success'))) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('error')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <!-- Specialized Worker Agent Cards -->
  <h5 class="fw-bold mb-3"><i class="fa fa-microchip text-primary mr-2"></i>Specialized Worker Agent Nodes</h5>
  <div class="row g-3 mb-4">
    <?php $agents = [
      ['run_pricing_agent', '💰 Dynamic Pricing Agent', 'Real-time price rebalancer & FX elasticity optimizer', '#f59e0b'],
      ['run_seo_agent', '🔍 Marketing & SEO Agent', 'Schema.org microdata & high-converting viral copy generator', '#3b82f6'],
      ['run_abandoned_cart', '🛒 Cart Recovery Agent', 'Stockout prediction & abandoned checkout sequence trigger', '#ec4899'],
      ['run_daily_digest', '📊 Executive Daily Digest', 'Compiles daily KPI revenue briefing for management', '#10b981'],
    ]; foreach ($agents as $ag): ?>
    <div class="col-md-6 col-xl-3">
      <div class="card border-0 shadow-sm h-100" style="border-top:3px solid <?= $ag[3] ?>;">
        <div class="card-body d-flex flex-column">
          <h6 class="fw-bold"><?= $ag[1] ?></h6>
          <p class="text-muted small flex-fill"><?= $ag[2] ?></p>
          <form method="post" action="<?= base_url('admin/ai_engine/swarm') ?>" onsubmit="return confirm('Run agent: <?= $ag[1] ?>?')">
            <?= csrf_field() ?>
            <input type="hidden" name="action_type" value="<?= $ag[0] ?>">
            <button class="btn btn-sm text-white w-100 font-weight-bold" style="background:<?= $ag[3] ?>;">Trigger Node</button>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Task History -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold"><i class="fa fa-history mr-2 text-info"></i>Autonomous Swarm Execution Log</div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead><tr><th>Task #</th><th>Agent / Node</th><th>Status</th><th>Output Preview</th><th>Execution Time</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($tasks as $t):
          $sc = ['done'=>'success','failed'=>'danger','running'=>'info','pending'=>'warning'][$t['status']] ?? 'secondary';
        ?>
        <tr>
          <td>#<?= $t['id'] ?></td>
          <td><code class="small font-weight-bold"><?= htmlspecialchars($t['agent'] ?? '') ?></code></td>
          <td><span class="badge badge-<?= $sc ?>"><?= ucfirst($t['status']) ?></span></td>
          <td><small><?= htmlspecialchars(mb_strimwidth($t['output_text'] ?? 'No output', 0, 100, '…')) ?></small></td>
          <td><small><?= $t['created_at'] ?></small></td>
          <td>
            <button class="btn btn-sm btn-outline-secondary py-0" data-toggle="modal" data-target="#taskModal<?= $t['id'] ?>">View Payload</button>
            <div class="modal fade" id="taskModal<?= $t['id'] ?>" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header"><h6 class="modal-title">Task #<?= $t['id'] ?> (<?= htmlspecialchars($t['agent'] ?? '') ?>)</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                  <div class="modal-body"><pre class="bg-light p-3 border rounded small" style="max-height:400px;overflow-y:auto;"><?= htmlspecialchars($t['output_text'] ?? 'No output') ?></pre></div>
                </div>
              </div>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($tasks)): ?><tr><td colspan="6" class="text-center text-muted py-4">No tasks run yet. Click "Run 1-Click Multi-Agent Swarm Cycle" above!</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
