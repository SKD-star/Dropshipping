<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-3">💸 Affiliate Payout Requests</h2>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>ID</th><th>Affiliate / Influencer</th><th>Amount</th><th>Status</th><th>Notes</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($payouts as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td class="fw-bold"><?= htmlspecialchars($p['influencer_name'] ?? ('Influencer #' . ($p['influencer_id'] ?? ''))) ?></td>
          <td>&#8377;<?= number_format($p['amount'] ?? 0, 2) ?></td>
          <td>
            <span class="badge badge-<?= ($p['status'] === 'paid') ? 'success' : (($p['status'] === 'approved') ? 'primary' : (($p['status'] === 'rejected') ? 'danger' : 'warning')) ?>">
              <?= ucfirst($p['status'] ?? 'pending') ?>
            </span>
          </td>
          <td><small><?= htmlspecialchars($p['note'] ?? '—') ?></small></td>
          <td>
            <?php if ($p['status'] === 'pending'): ?>
            <form method="post" action="<?= base_url('admin/affiliates/payouts') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="payout_action" value="approve">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <button class="btn btn-sm btn-success mr-1">Approve</button>
            </form>
            <form method="post" action="<?= base_url('admin/affiliates/payouts') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="payout_action" value="reject">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <button class="btn btn-sm btn-outline-danger">Reject</button>
            </form>
            <?php elseif ($p['status'] === 'approved'): ?>
            <form method="post" action="<?= base_url('admin/affiliates/payouts') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="payout_action" value="pay">
              <input type="hidden" name="id" value="<?= $p['id'] ?>">
              <input type="text" name="reference" class="form-control form-control-sm d-inline" style="width:130px;" placeholder="Txn Ref #" required>
              <button class="btn btn-sm btn-primary ml-1">Mark Paid</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($payouts)): ?><tr><td colspan="6" class="text-center text-muted py-5">No affiliate payout requests pending.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
