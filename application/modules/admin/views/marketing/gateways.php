<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#4e73df;">🔌 Payments Infrastructure &amp; Live Webhook Control</h2>
      <p class="text-muted mb-0">Configure real payment gateways, verify API keys &amp; test simulated transactions</p>
    </div>
    <button class="btn btn-primary btn-sm px-4 shadow-sm" data-toggle="modal" data-target="#simPayModal"><i class="fa fa-play mr-1"></i> Test Live Transaction</button>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <!-- Volume KPIs -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #1cc88a;">
        <i class="fa fa-receipt fa-2x mb-2 text-success"></i>
        <div style="font-size:1.6rem;font-weight:800;color:#1cc88a;">₹<?= number_format($tot_captured, 2) ?></div>
        <div class="text-muted small">Total Captured Volume via Gateways</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #4e73df;">
        <i class="fa fa-credit-card fa-2x mb-2 text-primary"></i>
        <div style="font-size:1.6rem;font-weight:800;color:#4e73df;"><?= number_format($tot_txns) ?></div>
        <div class="text-muted small">Processed Gateway Transactions</div>
      </div>
    </div>
  </div>

  <h5 class="fw-bold mb-3"><i class="fa fa-plug text-primary mr-2"></i>Active Integrations Readiness</h5>
  <div class="row g-3 mb-4">
    <?php foreach ($gateways as $gw):
      $status_config = [
        'configured'  => ['badge-success', '✅ Configured',  '#1cc88a'],
        'placeholder' => ['badge-warning text-dark', '⚠️ Placeholder', '#f59e0b'],
        'missing'     => ['badge-danger',  '❌ Missing',     '#e74a3b'],
      ];
      $sc = $status_config[$gw['status']] ?? ['badge-secondary', 'Unknown', '#888'];
    ?>
    <div class="col-md-6 col-xl-4">
      <div class="card border-0 shadow-sm h-100" style="border-left:4px solid <?= $sc[2] ?>!important;">
        <div class="card-body d-flex align-items-center">
          <div style="font-size:2rem;margin-right:16px;"><?= $gw['icon'] ?></div>
          <div class="flex-fill">
            <div class="fw-bold"><?= $gw['label'] ?></div>
            <div class="small text-muted"><?= implode(', ', $gw['keys']) ?></div>
          </div>
          <span class="badge <?= $sc[0] ?> ml-2"><?= $sc[1] ?></span>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Recent Payments -->
  <?php if (!empty($recent_payments)): ?>
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold"><i class="fa fa-history mr-2 text-info"></i>Recent Captured Payments (Live Ledger)</div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Txn ID</th><th>Order #</th><th>Gateway</th><th>Amount</th><th>Status</th><th>Time</th></tr></thead>
        <tbody>
        <?php foreach ($recent_payments as $rp): ?>
        <tr>
          <td><code><?= htmlspecialchars($rp['gateway_payment_id'] ?? '#'.$rp['id']) ?></code></td>
          <td>Order #<?= $rp['order_id'] ?></td>
          <td><span class="badge badge-info"><?= strtoupper(htmlspecialchars($rp['gateway'])) ?></span></td>
          <td class="fw-bold text-success">₹<?= number_format($rp['amount'], 2) ?></td>
          <td><span class="badge badge-success">Captured</span></td>
          <td><small><?= $rp['created_at'] ?? '' ?></small></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>
</div>

<div class="modal fade" id="simPayModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Simulate Live Payment Transaction</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/marketing/gateways') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="gateway_action" value="simulate_payment">
        <div class="modal-body">
          <div class="form-group"><label>Order ID</label><input type="number" name="sim_order_id" class="form-control" value="1" required></div>
          <div class="form-group"><label>Amount (₹) *</label><input type="number" step="0.01" min="1" name="sim_amount" class="form-control" value="1499.00" required></div>
          <div class="form-group">
            <label>Payment Gateway</label>
            <select name="sim_gateway" class="form-control">
              <option value="razorpay_upi">Razorpay Instant UPI</option>
              <option value="razorpay_cards">Razorpay Credit/Debit Card</option>
              <option value="stripe">Stripe International</option>
              <option value="cod">Cash on Delivery (COD Verified)</option>
            </select>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Run Simulation &amp; Reconcile Ledger</button></div>
      </form>
    </div>
  </div>
</div>
