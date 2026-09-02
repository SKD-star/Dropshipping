<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Header Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-sync-alt text-primary mr-2"></i>Returns &amp; Doorstep Exchanges Hub
      </h3>
      <p class="text-muted small mb-0">Automated 7-day doorstep size/color exchanges, Delhivery reverse pickups, and instant refunds</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
      <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline-secondary btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-shopping-bag mr-1"></i> Orders Hub
      </a>
      <a href="<?= base_url('admin/customers') ?>" class="btn btn-outline-primary btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-users mr-1"></i> Customer Directory
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
  <?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3">
    <i class="fas fa-exclamation-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('error')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- KPI Metric Cards Grid -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl-2 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #4f46e5 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Total RMAs</div>
        <div class="font-weight-bold text-dark" style="font-size:1.3rem;"><?= number_format($kpi['total_rma']) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #f59e0b !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Pending Review</div>
        <div class="font-weight-bold text-warning" style="font-size:1.3rem;"><?= number_format($kpi['pending_approval']) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-3 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #06b6d4 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Active Reverse Pickups</div>
        <div class="font-weight-bold text-info" style="font-size:1.3rem;"><?= number_format($kpi['pickup_active']) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #10b981 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Exchanges Done</div>
        <div class="font-weight-bold text-success" style="font-size:1.3rem;"><?= number_format($kpi['exchanges_done']) ?></div>
      </div>
    </div>
    <div class="col-12 col-md-8 col-xl-3 mb-2">
      <div class="card border-0 shadow-sm p-3 h-100" style="border-radius:12px; border-left: 4px solid #8b5cf6 !important;">
        <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.68rem;">Total Refunded Amount</div>
        <div class="font-weight-bold text-dark" style="font-size:1.3rem;">₹<?= number_format($kpi['refunded_amount'], 2) ?></div>
      </div>
    </div>
  </div>

  <!-- Filters & Search Bar -->
  <div class="card border-0 shadow-sm p-3 mb-3 bg-white" style="border-radius:12px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <!-- Status Pills -->
      <div class="d-flex gap-2 flex-wrap small font-weight-bold">
        <a href="?status=all" class="btn btn-sm <?= $status==='all'?'btn-primary':'btn-light text-muted border' ?> px-3" style="border-radius:6px;">All</a>
        <a href="?status=requested" class="btn btn-sm <?= $status==='requested'?'btn-warning text-dark font-weight-bold':'btn-light text-muted border' ?> px-3" style="border-radius:6px;">Pending Review</a>
        <a href="?status=pickup_scheduled" class="btn btn-sm <?= $status==='pickup_scheduled'?'btn-info text-white font-weight-bold':'btn-light text-muted border' ?> px-3" style="border-radius:6px;">Reverse Pickup Active</a>
        <a href="?status=exchanged" class="btn btn-sm <?= $status==='exchanged'?'btn-success font-weight-bold':'btn-light text-muted border' ?> px-3" style="border-radius:6px;">Exchanged</a>
        <a href="?status=refunded" class="btn btn-sm <?= $status==='refunded'?'btn-purple font-weight-bold text-white':'btn-light text-muted border' ?>" style="background:<?= $status==='refunded'?'#8b5cf6':'' ?>; border-radius:6px;">Refunded</a>
      </div>

      <!-- Search Box -->
      <form method="get" class="d-flex gap-2 w-100" style="max-width:320px;">
        <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" class="form-control form-control-sm font-weight-bold" placeholder="Search Order # or AWB...">
        <button class="btn btn-primary btn-sm px-3"><i class="fa fa-search"></i></button>
      </form>
    </div>
  </div>

  <!-- Returns & Exchanges Ledger Table Card -->
  <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3" style="width: 50px;">RMA #</th>
              <th class="py-3">Customer Profile</th>
              <th class="py-3">Original Item &amp; Order</th>
              <th class="py-3">Request Type &amp; Replacement</th>
              <th class="py-3">Reason</th>
              <th class="py-3">Reverse Courier AWB</th>
              <th class="py-3">RMA Status</th>
              <th class="py-3 text-right px-3">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($requests)): ?>
            <tr><td colspan="8" class="text-center text-muted py-5"><i class="fas fa-box-open fa-2x mb-2 d-block opacity-50"></i>No returns or exchanges found matching status</td></tr>
          <?php else: foreach ($requests as $r): 
            $c_name = $r['customer_name'] ?: ($r['guest_email'] ? explode('@', $r['guest_email'])[0] : 'Customer');
          ?>
          <tr>
            <td class="px-3 font-weight-bold text-muted">#RMA-<?= $r['id'] ?></td>
            <td>
              <div class="font-weight-bold text-dark"><?= htmlspecialchars($c_name) ?></div>
              <div class="text-muted small" style="font-size:0.75rem;"><?= htmlspecialchars($r['customer_phone'] ?: ($r['customer_email'] ?: $r['guest_email'])) ?></div>
            </td>
            <td>
              <div class="font-weight-bold text-dark small"><?= htmlspecialchars($r['product_title'] ?? 'Mountain Graphic Tee') ?></div>
              <div class="text-muted small" style="font-size:0.75rem;">Order: <a href="<?= base_url('admin/orders/view/'.$r['order_id']) ?>" class="font-weight-bold text-primary">#<?= htmlspecialchars($r['order_number'] ?? 'ORD-'.$r['order_id']) ?></a></div>
            </td>
            <td>
              <?php if ($r['type'] === 'exchange'): ?>
                <span class="badge badge-primary px-2 py-0.5"><i class="fas fa-sync-alt mr-1"></i> Size/Color Exchange</span>
                <?php if (!empty($r['exchange_variant_title'])): ?>
                <div class="text-success font-weight-bold small mt-1" style="font-size:0.75rem;">
                  ➡️ <?= htmlspecialchars($r['exchange_variant_title']) ?>
                </div>
                <?php endif; ?>
              <?php else: ?>
                <span class="badge badge-purple text-white px-2 py-0.5" style="background:#8b5cf6;"><i class="fas fa-undo mr-1"></i> Return &amp; Refund</span>
                <div class="text-dark font-weight-bold small mt-1" style="font-size:0.75rem;">
                  ₹<?= number_format($r['refund_amount'], 2) ?> (<?= ucfirst(str_replace('_', ' ', $r['refund_mode'])) ?>)
                </div>
              <?php endif; ?>
            </td>
            <td>
              <small class="text-muted font-weight-bold d-block" style="max-width:200px;"><?= htmlspecialchars($r['reason']) ?></small>
            </td>
            <td>
              <?php if (!empty($r['reverse_awb'])): ?>
                <code class="font-mono text-dark font-weight-bold"><?= htmlspecialchars($r['reverse_awb']) ?></code>
                <div class="text-muted small" style="font-size:0.7rem;"><?= htmlspecialchars($r['carrier']) ?></div>
              <?php else: ?>
                <span class="text-muted small">Not generated</span>
              <?php endif; ?>
            </td>
            <td>
              <?php
                $s_badge = [
                  'requested'        => 'badge-warning text-dark',
                  'approved'         => 'badge-info',
                  'pickup_scheduled' => 'badge-info',
                  'received_qc'      => 'badge-primary',
                  'refunded'         => 'badge-purple text-white',
                  'exchanged'        => 'badge-success',
                  'rejected'         => 'badge-danger',
                ];
                $sb = $s_badge[$r['status']] ?? 'badge-secondary';
              ?>
              <span class="badge <?= $sb ?> px-2.5 py-1"><?= ucfirst(str_replace('_', ' ', $r['status'])) ?></span>
            </td>
            <td class="text-right px-3">
              <div class="btn-group btn-group-sm">
                <?php if ($r['status'] === 'requested'): ?>
                  <a href="<?= base_url('admin/returns/approve/'.$r['id']) ?>" class="btn btn-outline-success font-weight-bold" onclick="return confirm('Approve RMA and generate Delhivery reverse pickup AWB?')" title="Approve Reverse Pickup">
                    <i class="fas fa-truck-loading mr-1"></i> Schedule Pickup
                  </a>
                <?php elseif ($r['status'] === 'pickup_scheduled'): ?>
                  <a href="<?= base_url('admin/returns/settle/'.$r['id']) ?>" class="btn btn-success font-weight-bold" onclick="return confirm('Confirm Quality Inspection Passed and Complete Exchange/Refund?')" title="QC Passed & Settle">
                    <i class="fas fa-check-double mr-1"></i> QC Passed &amp; Settle
                  </a>
                <?php else: ?>
                  <span class="text-success small font-weight-bold px-2"><i class="fas fa-check-circle"></i> Resolved</span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
