<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.gw-card { border-radius: 14px; transition: all .2s ease; border: 1.5px solid #e8ecf0; }
.gw-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.09); transform: translateY(-2px); }
.gw-header { border-radius: 13px 13px 0 0; padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
.gw-icon { font-size: 1.9rem; line-height: 1; }
.gw-badge-configured { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
.gw-badge-placeholder { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
.gw-badge-missing { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.key-input { font-family: 'JetBrains Mono', monospace; font-size: .8rem; letter-spacing: .03em; }
.gw-save-btn { font-weight: 600; letter-spacing: .03em; }
.stat-card { border-radius: 14px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; }
.stat-val { font-size: 1.9rem; font-weight: 800; line-height: 1; }
</style>

<div class="container-fluid py-4">
  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
      <h2 class="fw-bold mb-1" style="font-size:1.6rem;">🔌 Integration Hub &amp; API Key Manager</h2>
      <p class="text-muted mb-0">Configure payment gateways, shipping, AI &amp; messaging integrations — and enter API keys directly</p>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-outline-secondary btn-sm px-3" data-toggle="modal" data-target="#simPayModal">
        <i class="fa fa-play mr-1"></i> Simulate Payment
      </button>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm">
    <?= htmlspecialchars($this->session->flashdata('error')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- KPI Row -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="stat-card border-0 shadow-sm" style="background:linear-gradient(135deg,#d1fae5,#ecfdf5);">
        <div style="font-size:2.2rem;">💰</div>
        <div>
          <div class="stat-val text-success">₹<?= number_format($tot_captured, 2) ?></div>
          <div class="text-muted small mt-1">Total Captured Volume via Gateways</div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="stat-card border-0 shadow-sm" style="background:linear-gradient(135deg,#ede9fe,#f5f3ff);">
        <div style="font-size:2.2rem;">⚡</div>
        <div>
          <div class="stat-val" style="color:#7c3aed;"><?= number_format($tot_txns) ?></div>
          <div class="text-muted small mt-1">Processed Gateway Transactions</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Summary Bar -->
  <?php
    $configured_count = count(array_filter($gateways, fn($g) => $g['status'] === 'configured'));
    $total_count = count($gateways);
  ?>
  <div class="alert border-0 shadow-sm mb-4 d-flex align-items-center gap-3" style="background:#f0f9ff; border-left:4px solid #0ea5e9!important; border-radius:10px;">
    <i class="fa fa-info-circle fa-lg text-info"></i>
    <span>
      <strong><?= $configured_count ?> / <?= $total_count ?></strong> integrations configured.
      <?php if ($configured_count < $total_count): ?>
        Enter API keys below and click <strong>Save Keys</strong> to activate missing integrations.
      <?php else: ?>
        All integrations are live! 🎉
      <?php endif; ?>
    </span>
  </div>

  <!-- Integration Cards Grid -->
  <h5 class="fw-bold mb-3"><i class="fa fa-plug text-primary mr-2"></i>Active Integrations — Click to Configure</h5>

  <form method="post" action="<?= base_url('admin/marketing/gateways') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="gateway_action" value="save_keys">

    <div class="row g-3 mb-4">
    <?php foreach ($gateways as $gw):
      $status_map = [
        'configured'  => ['gw-badge-configured', '✅ Configured'],
        'placeholder' => ['gw-badge-placeholder', '⚠ Needs Key'],
        'missing'     => ['gw-badge-missing', '❌ Missing'],
      ];
      $sm = $status_map[$gw['status']] ?? ['gw-badge-missing', 'Unknown'];
      $gw_id = 'gw_' . $gw['key'];
    ?>
    <div class="col-md-6 col-xl-4">
      <div class="card gw-card border-0 shadow-sm h-100">
        <div class="gw-header" style="background:<?= htmlspecialchars($gw['color'] ?? '#f3f4f6') ?>18; border-bottom:1px solid <?= htmlspecialchars($gw['color'] ?? '#ddd') ?>30;">
          <span class="gw-icon"><?= $gw['icon'] ?></span>
          <div class="flex-fill">
            <div class="fw-bold" style="color:#111827;"><?= htmlspecialchars($gw['label']) ?></div>
            <a href="<?= htmlspecialchars($gw['docs'] ?? '#') ?>" target="_blank" class="small text-muted" style="text-decoration:none;">
              <i class="fa fa-external-link-alt fa-xs mr-1"></i>View Docs
            </a>
          </div>
          <span class="badge px-2 py-1 <?= $sm[0] ?>" style="font-size:.72rem;border-radius:20px;"><?= $sm[1] ?></span>
        </div>
        <div class="card-body pt-3 pb-3">
          <?php foreach ($gw['keys'] as $k): ?>
          <div class="mb-2">
            <label class="small fw-bold text-muted mb-1 d-block" style="font-size:.7rem;letter-spacing:.06em;text-transform:uppercase;"><?= htmlspecialchars($k) ?></label>
            <input
              type="text"
              name="gw_keys[<?= htmlspecialchars($k) ?>]"
              class="form-control form-control-sm key-input"
              placeholder="Paste your <?= htmlspecialchars($k) ?> here…"
              value="<?= htmlspecialchars($gw['values'][$k] ?? '') ?>"
              autocomplete="off"
              spellcheck="false"
            >
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-end mb-5">
      <button type="submit" class="btn btn-success btn-lg px-5 shadow gw-save-btn" style="border-radius:10px;">
        <i class="fa fa-save mr-2"></i>Save All API Keys
      </button>
    </div>
  </form>

  <!-- Recent Payments Ledger -->
  <?php if (!empty($recent_payments)): ?>
  <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white fw-bold py-3 border-bottom" style="font-size:.95rem;">
      <i class="fa fa-history text-info mr-2"></i>Recent Captured Payments (Live Ledger)
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead style="background:#f8fafc;">
            <tr>
              <th class="small text-muted fw-bold px-4">TXN ID</th>
              <th class="small text-muted fw-bold">ORDER #</th>
              <th class="small text-muted fw-bold">GATEWAY</th>
              <th class="small text-muted fw-bold">AMOUNT</th>
              <th class="small text-muted fw-bold">STATUS</th>
              <th class="small text-muted fw-bold">TIME</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($recent_payments as $rp): ?>
          <tr>
            <td class="px-4"><code class="small"><?= htmlspecialchars($rp['gateway_payment_id'] ?? '#'.$rp['id']) ?></code></td>
            <td>Order #<?= $rp['order_id'] ?></td>
            <td><span class="badge badge-info px-2 py-1"><?= strtoupper(htmlspecialchars($rp['gateway'])) ?></span></td>
            <td class="fw-bold text-success">₹<?= number_format($rp['amount'], 2) ?></td>
            <td><span class="badge badge-success">Captured</span></td>
            <td><small class="text-muted"><?= $rp['created_at'] ?? '' ?></small></td>
          </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<!-- Simulate Payment Modal -->
<div class="modal fade" id="simPayModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
      <div class="modal-header" style="background:linear-gradient(135deg,#1e3a5f,#2563eb);color:#fff;">
        <h5 class="modal-title">⚡ Simulate Live Payment Transaction</h5>
        <button type="button" class="close text-white" data-dismiss="modal" style="opacity:.8;">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/marketing/gateways') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="gateway_action" value="simulate_payment">
        <div class="modal-body">
          <div class="form-group">
            <label class="fw-bold small">Order ID</label>
            <input type="number" name="sim_order_id" class="form-control" value="1" required>
          </div>
          <div class="form-group">
            <label class="fw-bold small">Amount (₹) *</label>
            <input type="number" step="0.01" min="1" name="sim_amount" class="form-control" value="1499.00" required>
          </div>
          <div class="form-group">
            <label class="fw-bold small">Payment Gateway</label>
            <select name="sim_gateway" class="form-control">
              <option value="razorpay_upi">Razorpay Instant UPI</option>
              <option value="razorpay_cards">Razorpay Credit/Debit Card</option>
              <option value="stripe">Stripe International</option>
              <option value="cod">Cash on Delivery (COD Verified)</option>
            </select>
          </div>
          <div class="alert alert-info small border-0 mb-0" style="border-radius:8px;">
            This simulates a captured payment without touching a real gateway. Useful for testing webhook reconciliation.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary fw-bold">Run Simulation &amp; Reconcile Ledger</button>
        </div>
      </form>
    </div>
  </div>
</div>
