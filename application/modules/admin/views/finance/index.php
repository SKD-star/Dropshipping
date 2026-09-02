<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Page Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h4 class="font-weight-bold mb-0 text-dark">💳 Payments &amp; Revenue Ledger</h4>
        <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Live Transactions</span>
      </div>
      <p class="text-muted small mb-0">Audit merchant payment captures, COD disbursements, and gateway transaction IDs.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-shopping-bag mr-1"></i> Orders Center
      </a>
      <a href="<?= base_url('admin/analytics') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-chart-line mr-1"></i> Financial Analytics
      </a>
    </div>
  </div>

  <?php
    $all_records = !empty($payments) ? $payments : $paid_orders;
    $total_captured = 0;
    foreach ($all_records as $r) {
        $total_captured += (float)($r['amount'] ?? ($r['total'] ?? ($r['total_amount'] ?? 0)));
    }
    $avg_tx = count($all_records) > 0 ? ($total_captured / count($all_records)) : 0;
  ?>

  <!-- Financial Summary Metric Strip -->
  <div class="row g-2 mb-3">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Total Processed Volume</div>
        <div class="h5 font-weight-bold text-dark mb-0">₹<?= number_format($total_captured, 2) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Captured Transactions</div>
        <div class="h5 font-weight-bold text-success mb-0"><?= count($all_records) ?> <span class="small font-weight-normal text-muted">settled</span></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Average Transaction Value</div>
        <div class="h5 font-weight-bold text-primary mb-0">₹<?= number_format($avg_tx, 2) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Settlement Success Rate</div>
        <div class="h5 font-weight-bold text-info mb-0">99.4% <span class="small font-weight-normal text-muted">uptime</span></div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
      <h6 class="font-weight-bold mb-0 text-dark">
        <i class="fas fa-file-invoice-dollar text-success mr-2"></i> Payment Records &amp; Gateways
      </h6>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
        <thead class="bg-light text-muted text-uppercase small font-weight-bold">
          <tr>
            <th style="min-width:140px;">Transaction ID</th>
            <th style="min-width:120px;">Order #</th>
            <th style="min-width:160px;">Payment Method</th>
            <th style="min-width:140px;">Amount Processed</th>
            <th style="min-width:120px;">Status</th>
            <th style="min-width:160px;" class="text-right">Timestamp</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($payments) && empty($paid_orders)): ?>
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="fas fa-receipt fa-2x mb-2 d-block opacity-50"></i>
                No captured payment records found.
              </td>
            </tr>
          <?php else: ?>
            <?php if (!empty($payments)): ?>
              <?php foreach ($payments as $pay): 
                $amt = (float)($pay['amount'] ?? 0);
              ?>
                <tr>
                  <td><code class="text-primary font-weight-bold"><?= htmlspecialchars($pay['gateway_payment_id'] ?? ('PAY-' . $pay['id'])) ?></code></td>
                  <td><strong class="text-dark">#<?= (int)$pay['order_id'] ?></strong></td>
                  <td>
                    <span class="badge badge-light border text-dark px-2 py-1">
                      <i class="fas fa-credit-card mr-1 text-muted"></i> <?= strtoupper(htmlspecialchars($pay['gateway'] ?? 'Razorpay')) ?>
                    </span>
                  </td>
                  <td><strong class="text-success">₹<?= number_format($amt, 2) ?></strong></td>
                  <td><span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> <?= ucfirst($pay['status']) ?></span></td>
                  <td class="text-right text-muted"><?= date('d M Y, H:i', strtotime($pay['created_at'])) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <?php foreach ($paid_orders as $op): 
                $amt = (float)($op['total'] ?? $op['total_amount'] ?? 0);
                $pm = $op['payment_method'] ?? 'COD';
              ?>
                <tr>
                  <td><code class="text-primary font-weight-bold">TXN-<?= $op['id'] ?></code></td>
                  <td><strong class="text-dark">#<?= htmlspecialchars($op['order_number'] ?? $op['id']) ?></strong></td>
                  <td>
                    <span class="badge badge-light border text-dark px-2 py-1">
                      <i class="fas fa-money-bill-wave mr-1 text-muted"></i> <?= strtoupper(htmlspecialchars($pm)) ?>
                    </span>
                  </td>
                  <td><strong class="text-success">₹<?= number_format($amt, 2) ?></strong></td>
                  <td><span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Processed</span></td>
                  <td class="text-right text-muted"><?= date('d M Y, H:i', strtotime($op['created_at'])) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
