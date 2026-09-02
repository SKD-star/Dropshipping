<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── FAQ Page — Advanced Responsive Premium UI ── */
.faq-hero { background: linear-gradient(135deg, #6d28d9 0%, #4f46e5 100%); border-radius: 16px; padding: 28px 32px; color: #fff; margin-bottom: 1.5rem; }
.faq-hero h2 { font-size: 1.7rem; font-weight: 800; margin-bottom: 4px; }
.faq-card { border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.07); border: none; }
.faq-table th { font-size: .72rem; text-transform: uppercase; letter-spacing: .07em; color: #6b7280; font-weight: 700; background: #f8fafc; }
.faq-acc-item { border: 1px solid #e5e7eb; border-radius: 10px; margin-bottom: 10px; overflow: hidden; }
.faq-acc-header { background: #fff; padding: 14px 18px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 600; gap: 10px; }
.faq-acc-header:hover { background: #f9fafb; }
.faq-acc-body { background: #f9fafb; padding: 12px 18px 16px; border-top: 1px solid #e5e7eb; color: #4b5563; line-height: 1.7; display: none; }
.faq-acc-item.open .faq-acc-body { display: block; }
.faq-acc-item.open .faq-chevron { transform: rotate(180deg); }
.faq-chevron { transition: transform .2s; color: #9ca3af; }
.cat-pill { background: #ede9fe; color: #6d28d9; border-radius: 20px; padding: 2px 10px; font-size: .72rem; font-weight: 700; }
.stats-strip { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 1.5rem; }
.stat-s { background: #fff; border-radius: 12px; padding: 14px 20px; box-shadow: 0 2px 8px rgba(0,0,0,.06); display: flex; align-items: center; gap: 12px; flex: 1; min-width: 120px; }
.stat-s .val { font-size: 1.6rem; font-weight: 800; line-height: 1; }
@media (max-width: 576px) {
  .faq-hero { padding: 20px 18px; }
  .faq-hero h2 { font-size: 1.3rem; }
  .d-flex.header-actions { flex-direction: column; gap: 8px; align-items: stretch !important; }
  .header-actions .btn { width: 100%; }
}
</style>

<div class="container-fluid py-4">

  <!-- Hero Header -->
  <div class="faq-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h2 class="mb-1">❓ FAQ Manager</h2>
      <p class="mb-0" style="opacity:.85;font-size:.95rem;">Categorised customer support Q&amp;A — auto-renders on your storefront help page</p>
    </div>
    <button class="btn btn-light fw-bold px-4 shadow-sm" data-toggle="modal" data-target="#faqModal" style="border-radius:10px;white-space:nowrap;">
      <i class="fa fa-plus mr-2"></i>Add Question
    </button>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Stats Strip -->
  <?php
    $total_faq   = count($faqs);
    $active_faq  = count(array_filter($faqs, fn($f) => $f['is_active'] ?? 0));
    $cats        = count(array_unique(array_column($faqs, 'category')));
  ?>
  <div class="stats-strip">
    <div class="stat-s"><div style="font-size:1.5rem;">📋</div><div><div class="val" style="color:#6d28d9;"><?= $total_faq ?></div><div class="small text-muted">Total</div></div></div>
    <div class="stat-s"><div style="font-size:1.5rem;">✅</div><div><div class="val text-success"><?= $active_faq ?></div><div class="small text-muted">Active</div></div></div>
    <div class="stat-s"><div style="font-size:1.5rem;">🏷️</div><div><div class="val" style="color:#f59e0b;"><?= $cats ?></div><div class="small text-muted">Categories</div></div></div>
    <div class="stat-s"><div style="font-size:1.5rem;">🔇</div><div><div class="val text-secondary"><?= $total_faq - $active_faq ?></div><div class="small text-muted">Hidden</div></div></div>
  </div>

  <!-- View Toggle Tabs -->
  <ul class="nav nav-pills mb-3" id="faqViewTabs">
    <li class="nav-item"><a class="nav-link active" href="#" data-view="accordion">🗂 Accordion Preview</a></li>
    <li class="nav-item"><a class="nav-link" href="#" data-view="table">📊 Manage Table</a></li>
  </ul>

  <!-- Accordion View -->
  <div id="viewAccordion">
    <?php if (empty($faqs)): ?>
    <div class="text-center text-muted py-5 border rounded-3" style="background:#f9fafb;">
      <div style="font-size:2.5rem;">❓</div>
      <p class="mt-2">No FAQ items yet. Click <strong>Add Question</strong> to get started.</p>
    </div>
    <?php else:
      $grouped = [];
      foreach ($faqs as $faq) {
        $cat = $faq['category'] ?? 'General';
        $grouped[$cat][] = $faq;
      }
      foreach ($grouped as $cat => $items): ?>
    <div class="mb-4">
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="cat-pill"><?= htmlspecialchars($cat) ?></span>
        <span class="small text-muted"><?= count($items) ?> question<?= count($items) > 1 ? 's' : '' ?></span>
      </div>
      <?php foreach ($items as $faq): ?>
      <div class="faq-acc-item <?= ($faq['is_active'] ?? 0) ? '' : 'opacity-50' ?>">
        <div class="faq-acc-header" onclick="this.closest('.faq-acc-item').classList.toggle('open')">
          <span><?= htmlspecialchars($faq['question'] ?? '') ?></span>
          <div class="d-flex align-items-center gap-2">
            <?php if (!($faq['is_active'] ?? 0)): ?><span class="badge badge-secondary" style="font-size:.65rem;">Hidden</span><?php endif; ?>
            <i class="fa fa-chevron-down faq-chevron"></i>
          </div>
        </div>
        <div class="faq-acc-body">
          <?= nl2br(htmlspecialchars($faq['answer'] ?? '')) ?>
          <div class="mt-3 d-flex gap-2">
            <form method="post" action="<?= base_url('admin/settings/faq') ?>" class="d-inline" onsubmit="return confirm('Delete this FAQ?')">
              <?= csrf_field() ?><input type="hidden" name="faq_action" value="delete"><input type="hidden" name="id" value="<?= $faq['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash mr-1"></i>Delete</button>
            </form>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Table View (hidden by default) -->
  <div id="viewTable" style="display:none;">
    <div class="card faq-card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead><tr><th class="px-4">#</th><th>Question</th><th>Category</th><th>Sort</th><th>Status</th><th class="text-right pr-3">Actions</th></tr></thead>
            <tbody>
            <?php if (empty($faqs)): ?>
            <tr><td colspan="6" class="text-center py-5 text-muted"><div style="font-size:2rem;">❓</div>No FAQ items yet.</td></tr>
            <?php else: foreach ($faqs as $faq): ?>
            <tr>
              <td class="px-4"><small class="text-muted"><?= $faq['id'] ?></small></td>
              <td class="fw-bold"><?= htmlspecialchars(mb_strimwidth($faq['question'] ?? '', 0, 80, '…')) ?></td>
              <td><span class="cat-pill"><?= htmlspecialchars($faq['category'] ?? 'General') ?></span></td>
              <td><small><?= (int)($faq['sort_order'] ?? 0) ?></small></td>
              <td><span class="badge badge-<?= ($faq['is_active'] ?? 0) ? 'success' : 'secondary' ?>"><?= ($faq['is_active'] ?? 0) ? 'Active' : 'Hidden' ?></span></td>
              <td class="text-right pr-3">
                <form method="post" action="<?= base_url('admin/settings/faq') ?>" class="d-inline" onsubmit="return confirm('Delete this FAQ?')">
                  <?= csrf_field() ?><input type="hidden" name="faq_action" value="delete"><input type="hidden" name="id" value="<?= $faq['id'] ?>">
                  <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                </form>
              </td>
            </tr>
            <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Add FAQ Modal -->
<div class="modal fade" id="faqModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
      <div class="modal-header" style="background:linear-gradient(135deg,#6d28d9,#4f46e5);color:#fff;">
        <h5 class="modal-title">❓ Add FAQ Question</h5>
        <button type="button" class="close text-white" data-dismiss="modal" style="opacity:.8;">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/settings/faq') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="faq_action" value="save">
        <input type="hidden" name="id" value="0">
        <div class="modal-body">
          <div class="form-group">
            <label class="fw-bold small">Question *</label>
            <input type="text" name="question" class="form-control" required placeholder="e.g. How long does shipping take?">
          </div>
          <div class="form-group">
            <label class="fw-bold small">Answer *</label>
            <textarea name="answer" class="form-control" rows="4" required placeholder="Shipping usually takes 3-5 business days…"></textarea>
          </div>
          <div class="row">
            <div class="col-sm-6 form-group">
              <label class="fw-bold small">Category</label>
              <input type="text" name="category" class="form-control" value="General" list="faq-cat-suggestions">
              <datalist id="faq-cat-suggestions">
                <option value="General"><option value="Shipping"><option value="Returns"><option value="Payments"><option value="Products">
              </datalist>
            </div>
            <div class="col-sm-6 form-group">
              <label class="fw-bold small">Sort Order <span class="text-muted">(lower = first)</span></label>
              <input type="number" name="sort_order" class="form-control" value="0" min="0">
            </div>
          </div>
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="faqActive" name="is_active" value="1" checked>
            <label class="custom-control-label fw-bold" for="faqActive">Publish immediately on storefront</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary fw-bold px-4"><i class="fa fa-save mr-1"></i>Save Question</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Toggle views
document.querySelectorAll('[data-view]').forEach(function(tab) {
  tab.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelectorAll('[data-view]').forEach(t => t.classList.remove('active'));
    this.classList.add('active');
    var v = this.getAttribute('data-view');
    document.getElementById('viewAccordion').style.display = v === 'accordion' ? '' : 'none';
    document.getElementById('viewTable').style.display = v === 'table' ? '' : 'none';
  });
});
</script>
