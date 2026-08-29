<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Vendor Payouts</h2>
    <div><a href="?status=pending" class="btn btn-sm btn-<?= $status==='pending'?'warning':'outline-warning' ?> mr-1">Pending</a><a href="?status=paid" class="btn btn-sm btn-<?= $status==='paid'?'success':'outline-success' ?>">Paid</a></div>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
  <div class="card border-0 shadow-sm"><div class="card-body p-0"><table class="table table-hover mb-0">
    <thead><tr><th>ID</th><th>Vendor</th><th>Amount</th><th>Period</th><th>Status</th><th>Reference</th><th>Action</th></tr></thead>
    <tbody>
    <?php foreach ($payouts as $p): ?>
    <tr>
      <td><?= $p['id'] ?></td>
      <td class="fw-bold"><?= htmlspecialchars($p['business_name']??'#'.$p['vendor_id']) ?></td>
      <td>&#8377;<?= number_format($p['net_payable']??0, 2) ?></td>
      <td><small><?= $p['period_start']??'' ?> – <?= $p['period_end']??'' ?></small></td>
      <td><span class="badge badge-<?= $p['status']==='paid'?'success':'warning' ?>"><?= $p['status'] ?></span></td>
      <td><small><?= htmlspecialchars($p['reference']??'—') ?></small></td>
      <td>
        <?php if ($p['status']==='pending'): ?>
        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#payModal<?= $p['id'] ?>">Mark Paid</button>
        <div class="modal fade" id="payModal<?= $p['id'] ?>" tabindex="-1"><div class="modal-dialog modal-sm"><div class="modal-content">
          <div class="modal-header"><h6 class="modal-title">Mark Payout #<?= $p['id'] ?> Paid</h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
          <form method="post" action="<?= base_url('admin/vendors/payout_mark_paid/'.$p['id']) ?>">
            <?= csrf_field() ?>
            <div class="modal-body"><div class="form-group"><label>Reference / UTR</label><input type="text" name="reference" class="form-control" placeholder="NEFT-123456"></div></div>
            <div class="modal-footer py-2"><button class="btn btn-success btn-sm">Confirm Paid</button></div>
          </form>
        </div></div></div>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($payouts)): ?><tr><td colspan="7" class="text-center text-muted py-5">No payouts found for status: <?= $status ?></td></tr><?php endif; ?>
    </tbody></table></div></div>
</div>
