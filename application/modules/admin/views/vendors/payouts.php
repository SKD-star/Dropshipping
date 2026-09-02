<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Header Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-money-bill-wave text-success mr-2"></i>Vendor Commissions &amp; Payouts
      </h3>
      <p class="text-muted small mb-0">Track and settle marketplace seller commissions, bank transfers, and UTR reference logs</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
      <a href="?status=pending" class="btn btn-sm <?= $status==='pending'?'btn-warning text-dark font-weight-bold':'btn-outline-warning text-dark' ?> px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-clock mr-1"></i> Pending Settlements
      </a>
      <a href="?status=paid" class="btn btn-sm <?= $status==='paid'?'btn-success font-weight-bold':'btn-outline-success' ?> px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-check-double mr-1"></i> Settled &amp; Paid
      </a>
      <a href="<?= base_url('admin/vendors') ?>" class="btn btn-outline-secondary btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-arrow-left mr-1"></i> Vendors
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

  <!-- Payout Settlements Card -->
  <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark"><i class="fas fa-hand-holding-usd text-success mr-2"></i> Payout Settlements Ledger</span>
      <span class="badge badge-light border font-weight-bold px-2.5 py-1"><?= count($payouts) ?> Records Found</span>
    </div>
    
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3" style="width: 60px;">ID</th>
              <th class="py-3">Vendor / Business Account</th>
              <th class="py-3">Payable Amount</th>
              <th class="py-3">Settlement Cycle</th>
              <th class="py-3">Payment Status</th>
              <th class="py-3">Bank Reference / UTR</th>
              <th class="py-3 text-right px-3">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($payouts as $p): ?>
          <tr>
            <td class="px-3 font-weight-bold text-muted">#<?= $p['id'] ?></td>
            <td>
              <div class="font-weight-bold text-dark"><?= htmlspecialchars($p['business_name'] ?? 'Vendor #'.$p['vendor_id']) ?></div>
              <div class="text-muted small" style="font-size:0.75rem;"><?= htmlspecialchars($p['vendor_email'] ?? '') ?> • <?= htmlspecialchars($p['payout_method'] ?? 'Bank Account / UPI') ?></div>
            </td>
            <td>
              <span class="font-weight-bold text-success" style="font-size:1.1rem;">
                ₹<?= number_format($p['net_payable'] ?? ($p['amount'] ?? 0), 2) ?>
              </span>
            </td>
            <td>
              <span class="badge badge-light border font-mono small text-muted">
                <?= !empty($p['period_start']) ? date('d M', strtotime($p['period_start'])) : '' ?> – <?= !empty($p['period_end']) ? date('d M Y', strtotime($p['period_end'])) : date('d M Y') ?>
              </span>
            </td>
            <td>
              <?php if (($p['status'] ?? 'pending') === 'paid'): ?>
                <span class="badge badge-success px-2.5 py-1"><i class="fas fa-check mr-1"></i> Paid</span>
              <?php else: ?>
                <span class="badge badge-warning text-dark px-2.5 py-1"><i class="fas fa-hourglass-half mr-1"></i> Pending</span>
              <?php endif; ?>
            </td>
            <td>
              <code class="font-mono text-dark font-weight-bold"><?= htmlspecialchars($p['reference'] ?? '—') ?></code>
            </td>
            <td class="text-right px-3">
              <?php if (($p['status'] ?? 'pending') === 'pending'): ?>
              <button class="btn btn-success btn-sm font-weight-bold px-3 shadow-sm" style="border-radius:6px;" data-toggle="modal" data-target="#payModal<?= $p['id'] ?>">
                <i class="fas fa-check mr-1"></i> Mark Paid
              </button>

              <div class="modal fade" id="payModal<?= $p['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                  <div class="modal-content border-0 shadow-lg" style="border-radius:12px;">
                    <div class="modal-header bg-dark text-white py-2 px-3">
                      <h6 class="modal-title font-weight-bold mb-0">Confirm Settlement #<?= $p['id'] ?></h6>
                      <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <form method="post" action="<?= base_url('admin/vendors/payout_mark_paid/'.$p['id']) ?>">
                      <?= csrf_field() ?>
                      <div class="modal-body p-3 text-left">
                        <div class="mb-2">
                          <span class="text-muted small">Vendor:</span>
                          <div class="font-weight-bold"><?= htmlspecialchars($p['business_name'] ?? 'Vendor') ?></div>
                        </div>
                        <div class="mb-3">
                          <span class="text-muted small">Payable Amount:</span>
                          <div class="font-weight-bold text-success" style="font-size:1.15rem;">₹<?= number_format($p['net_payable'] ?? ($p['amount'] ?? 0), 2) ?></div>
                        </div>
                        <div class="form-group mb-0 text-left">
                          <label class="small font-weight-bold">Bank Reference / NEFT UTR / Transaction ID *</label>
                          <input type="text" name="reference" class="form-control form-control-sm font-mono font-weight-bold" placeholder="e.g. UTR-9819E694" required value="UTR-<?= rand(10000000, 99999999) ?>">
                        </div>
                      </div>
                      <div class="modal-footer py-2 px-3">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm font-weight-bold px-3">Confirm Bank Transfer</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php else: ?>
              <span class="text-success small font-weight-bold"><i class="fas fa-check-double mr-1"></i> Settled</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($payouts)): ?>
          <tr><td colspan="7" class="text-center text-muted py-5"><i class="fas fa-receipt fa-2x mb-2 d-block opacity-50"></i>No payout settlement records found for status: <?= htmlspecialchars($status) ?></td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
