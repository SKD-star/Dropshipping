<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0">⭐ Product Reviews &amp; Moderation</h2>
      <p class="text-muted mb-0">Approve, reject, or delete customer product reviews</p>
    </div>
    <div>
      <a href="?filter=pending" class="btn btn-sm btn-<?= $filter === 'pending' ? 'warning' : 'outline-warning' ?> mr-1">Pending (<?= count(array_filter($reviews, fn($r) => empty($r['is_approved']))) ?>)</a>
      <a href="?filter=approved" class="btn btn-sm btn-<?= $filter === 'approved' ? 'success' : 'outline-success' ?> mr-1">Approved</a>
      <a href="?filter=all" class="btn btn-sm btn-<?= $filter === 'all' ? 'primary' : 'outline-primary' ?>">All</a>
    </div>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Product</th><th>Rating</th><th>Review Content</th><th>Customer</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($reviews as $r): ?>
        <tr>
          <td><strong class="small"><?= htmlspecialchars($r['product_title'] ?? ('Product #' . ($r['product_id'] ?? ''))) ?></strong></td>
          <td class="text-warning">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <?= $i <= ($r['rating'] ?? 5) ? '★' : '☆' ?>
            <?php endfor; ?>
          </td>
          <td>
            <div class="font-weight-bold small"><?= htmlspecialchars($r['title'] ?? '') ?></div>
            <small class="text-muted"><?= htmlspecialchars(mb_strimwidth($r['body'] ?? '', 0, 100, '…')) ?></small>
          </td>
          <td><small><?= htmlspecialchars($r['reviewer_name'] ?? 'Anonymous') ?></small></td>
          <td>
            <span class="badge badge-<?= !empty($r['is_approved']) ? 'success' : 'warning' ?>">
              <?= !empty($r['is_approved']) ? 'Approved' : 'Pending Moderation' ?>
            </span>
          </td>
          <td>
            <?php if (empty($r['is_approved'])): ?>
            <form method="post" action="<?= base_url('admin/products/reviews') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="review_action" value="approve">
              <input type="hidden" name="id" value="<?= $r['id'] ?>">
              <button class="btn btn-sm btn-success mr-1">Approve</button>
            </form>
            <?php else: ?>
            <form method="post" action="<?= base_url('admin/products/reviews') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="review_action" value="reject">
              <input type="hidden" name="id" value="<?= $r['id'] ?>">
              <button class="btn btn-sm btn-outline-warning mr-1">Hide</button>
            </form>
            <?php endif; ?>
            <form method="post" action="<?= base_url('admin/products/reviews') ?>" class="d-inline" onsubmit="return confirm('Permanently delete review?')">
              <?= csrf_field() ?>
              <input type="hidden" name="review_action" value="delete">
              <input type="hidden" name="id" value="<?= $r['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($reviews)): ?><tr><td colspan="6" class="text-center text-muted py-5">No reviews matching the selected filter.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
