<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Page Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h4 class="font-weight-bold mb-0 text-dark">⭐ Product Reviews &amp; Moderation</h4>
        <span class="badge badge-primary px-2 py-1" style="font-size:0.75rem;"><?= count($reviews) ?> Reviews</span>
      </div>
      <p class="text-muted small mb-0">Approve, moderate, or remove customer reviews before they appear on the live storefront.</p>
    </div>
    <div class="d-flex gap-1">
      <a href="?filter=pending" class="btn btn-sm <?= $filter === 'pending' ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-warning' ?>">
        <i class="fas fa-clock mr-1"></i> Pending (<?= count(array_filter($reviews, fn($r) => (empty($r['status']) || $r['status'] === 'pending') && empty($r['is_approved']))) ?>)
      </a>
      <a href="?filter=approved" class="btn btn-sm <?= $filter === 'approved' ? 'btn-success font-weight-bold' : 'btn-outline-success' ?>">
        <i class="fas fa-check-circle mr-1"></i> Approved
      </a>
      <a href="?filter=all" class="btn btn-sm <?= $filter === 'all' ? 'btn-primary font-weight-bold' : 'btn-outline-secondary' ?>">
        All Reviews
      </a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
      <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
        <thead class="bg-light text-muted text-uppercase small font-weight-bold">
          <tr>
            <th style="min-width:180px;">Product</th>
            <th style="min-width:120px;">Rating</th>
            <th style="min-width:250px;">Review Content</th>
            <th style="min-width:140px;">Customer</th>
            <th style="min-width:120px;">Status</th>
            <th style="min-width:140px;" class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($reviews as $r): 
            $is_app = (!empty($r['status']) && $r['status'] === 'approved') || (!empty($r['is_approved']));
          ?>
          <tr>
            <!-- Product -->
            <td>
              <strong class="text-dark d-block"><?= htmlspecialchars($r['product_title'] ?? ('Product #' . ($r['product_id'] ?? ''))) ?></strong>
              <small class="text-muted">Product ID: #<?= $r['product_id'] ?? '—' ?></small>
            </td>

            <!-- Rating Stars -->
            <td>
              <div class="text-warning small font-weight-bold">
                <?php 
                  $rating = (int)($r['rating'] ?? 5);
                  for ($i = 1; $i <= 5; $i++): 
                ?>
                  <?= $i <= $rating ? '★' : '☆' ?>
                <?php endfor; ?>
                <span class="text-dark ml-1">(<?= $rating ?>.0)</span>
              </div>
            </td>

            <!-- Review Content -->
            <td>
              <?php if (!empty($r['title'])): ?>
                <div class="font-weight-bold text-dark small mb-0.5"><?= htmlspecialchars($r['title']) ?></div>
              <?php endif; ?>
              <div class="text-secondary small"><?= htmlspecialchars(mb_strimwidth($r['body'] ?? ($r['comment'] ?? ''), 0, 140, '…')) ?></div>
            </td>

            <!-- Reviewer -->
            <td>
              <span class="font-weight-medium text-dark d-block small">
                <?= htmlspecialchars($r['reviewer_name'] ?? ($r['name'] ?? 'Verified Buyer')) ?>
              </span>
              <small class="text-muted"><?= htmlspecialchars($r['reviewer_email'] ?? '') ?></small>
            </td>

            <!-- Status Badge -->
            <td>
              <?php if ($is_app): ?>
                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Live</span>
              <?php else: ?>
                <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-clock mr-1"></i> Pending</span>
              <?php endif; ?>
            </td>

            <!-- Action Buttons -->
            <td class="text-right">
              <div class="d-inline-flex gap-1">
                <?php if (!$is_app): ?>
                  <form method="post" action="<?= base_url('admin/products/reviews') ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="review_action" value="approve">
                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                    <button class="btn btn-xs btn-success px-2 py-1 font-weight-bold" style="font-size:0.75rem;">
                      <i class="fas fa-check mr-1"></i> Approve
                    </button>
                  </form>
                <?php else: ?>
                  <form method="post" action="<?= base_url('admin/products/reviews') ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="review_action" value="reject">
                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                    <button class="btn btn-xs btn-outline-warning px-2 py-1" style="font-size:0.75rem;">
                      <i class="fas fa-eye-slash mr-1"></i> Hide
                    </button>
                  </form>
                <?php endif; ?>

                <form method="post" action="<?= base_url('admin/products/reviews') ?>" class="d-inline" onsubmit="return confirm('Permanently delete this customer review?')">
                  <?= csrf_field() ?>
                  <input type="hidden" name="review_action" value="delete">
                  <input type="hidden" name="id" value="<?= $r['id'] ?>">
                  <button class="btn btn-xs btn-outline-danger px-2 py-1" title="Delete Review" style="font-size:0.75rem;">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>

          <?php if (empty($reviews)): ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-5">
                <i class="fas fa-comment-slash fa-2x mb-2 d-block opacity-50"></i>
                No reviews found matching the selected filter.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
