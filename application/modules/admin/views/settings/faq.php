<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">❓ FAQ Management</h2>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#faqModal"><i class="fa fa-plus mr-1"></i> Add Question</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>#</th><th>Question</th><th>Category</th><th>Sort Order</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($faqs as $faq): ?>
        <tr>
          <td><?= $faq['id'] ?></td>
          <td class="fw-bold"><?= htmlspecialchars(mb_strimwidth($faq['question'] ?? '', 0, 90, '…')) ?></td>
          <td><span class="badge badge-info"><?= htmlspecialchars($faq['category'] ?? 'General') ?></span></td>
          <td><?= $faq['sort_order'] ?? 0 ?></td>
          <td><span class="badge badge-<?= $faq['is_active'] ? 'success' : 'secondary' ?>"><?= $faq['is_active'] ? 'Active' : 'Hidden' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/settings/faq') ?>" class="d-inline" onsubmit="return confirm('Delete this FAQ?')">
              <?= csrf_field() ?>
              <input type="hidden" name="faq_action" value="delete">
              <input type="hidden" name="id" value="<?= $faq['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($faqs)): ?><tr><td colspan="6" class="text-center text-muted py-5">No FAQ items yet. Click "Add Question" above.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="faqModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add FAQ</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/settings/faq') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="faq_action" value="save">
        <input type="hidden" name="id" value="0">
        <div class="modal-body">
          <div class="form-group"><label>Question *</label><input type="text" name="question" class="form-control" required placeholder="e.g. How long does shipping take?"></div>
          <div class="form-group"><label>Answer *</label><textarea name="answer" class="form-control" rows="4" required placeholder="Shipping usually takes 3-5 business days..."></textarea></div>
          <div class="row">
            <div class="col-6 form-group"><label>Category</label><input type="text" name="category" class="form-control" value="General"></div>
            <div class="col-6 form-group"><label>Sort Order</label><input type="number" name="sort_order" class="form-control" value="0"></div>
          </div>
          <div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input" id="faqActive" name="is_active" value="1" checked><label class="custom-control-label" for="faqActive">Active</label></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Save Question</button></div>
      </form>
    </div>
  </div>
</div>
