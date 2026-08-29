<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-3">📋 Waitlist</h2>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
  <div class="card border-0 shadow-sm"><div class="card-body p-0"><table class="table table-hover mb-0">
    <thead><tr><th>Email</th><th>Product</th><th>Notified</th><th>Joined</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($waitlist as $w): ?>
    <tr>
      <td><?= htmlspecialchars($w['email']??'') ?></td>
      <td><?= htmlspecialchars($w['product_name']??'#'.$w['product_id']) ?></td>
      <td><?= $w['notified'] ? '<span class="badge badge-success">Notified</span>' : '<span class="badge badge-secondary">Pending</span>' ?></td>
      <td><small><?= $w['created_at']??'' ?></small></td>
      <td>
        <?php if (!$w['notified']): ?>
        <form method="post" action="<?= base_url('admin/marketing/waitlist') ?>" class="d-inline">
          <?= csrf_field() ?><input type="hidden" name="wl_action" value="notify"><input type="hidden" name="id" value="<?= $w['id'] ?>">
          <button class="btn btn-sm btn-success">Notify</button>
        </form>
        <?php endif; ?>
        <form method="post" action="<?= base_url('admin/marketing/waitlist') ?>" class="d-inline" onsubmit="return confirm('Remove from waitlist?')">
          <?= csrf_field() ?><input type="hidden" name="wl_action" value="delete"><input type="hidden" name="id" value="<?= $w['id'] ?>">
          <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($waitlist)): ?><tr><td colspan="5" class="text-center text-muted py-5">No waitlist signups yet</td></tr><?php endif; ?>
    </tbody></table></div></div>
</div>
