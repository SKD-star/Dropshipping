<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
.disc-table th { font-size:.72rem; text-transform:uppercase; letter-spacing:.07em; color:#6b7280; font-weight:700; background:#f8fafc; }
.disc-code { font-family:'JetBrains Mono',monospace; font-weight:700; background:#f1f5f9; padding:3px 10px; border-radius:6px; font-size:.82rem; letter-spacing:.05em; color:#1e293b; display:inline-block; }
.disc-card { border-radius:14px; overflow:hidden; }
.type-percent { background:#ede9fe; color:#6d28d9; }
.type-fixed   { background:#d1fae5; color:#065f46; }
.type-free_shipping { background:#dbeafe; color:#1d4ed8; }
.stats-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr)); gap:14px; margin-bottom:1.5rem; }
.stat-pill { border-radius:12px; padding:16px 18px; display:flex; align-items:center; gap:12px; box-shadow:0 2px 8px rgba(0,0,0,.06); }
</style>

<div class="container-fluid py-4">
  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
      <h2 class="fw-bold mb-1" style="font-size:1.6rem;">🎟️ Discount Codes</h2>
      <p class="text-muted mb-0">Create, manage &amp; monitor promotional discount codes</p>
    </div>
    <button class="btn btn-primary btn-sm px-4 shadow-sm" data-toggle="modal" data-target="#discountModal">
      <i class="fa fa-plus mr-2"></i>New Discount
    </button>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3">
    <?= htmlspecialchars($this->session->flashdata('error')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Stats Pills -->
  <?php
    $total    = count($discounts);
    $active   = count(array_filter($discounts, fn($d) => ($d['is_active'] ?? 0) && (empty($d['ends_at']) || $d['ends_at'] >= date('Y-m-d H:i:s'))));
    $expired  = count(array_filter($discounts, fn($d) => !empty($d['ends_at']) && $d['ends_at'] < date('Y-m-d H:i:s')));
    $total_uses = array_sum(array_column($discounts, 'times_used'));
  ?>
  <div class="stats-grid mb-4">
    <div class="stat-pill" style="background:linear-gradient(135deg,#ede9fe,#f5f3ff);">
      <div style="font-size:1.7rem;">🎟️</div>
      <div><div style="font-size:1.5rem;font-weight:800;color:#7c3aed;"><?= $total ?></div><div class="small text-muted">Total Codes</div></div>
    </div>
    <div class="stat-pill" style="background:linear-gradient(135deg,#d1fae5,#ecfdf5);">
      <div style="font-size:1.7rem;">✅</div>
      <div><div style="font-size:1.5rem;font-weight:800;color:#059669;"><?= $active ?></div><div class="small text-muted">Active Now</div></div>
    </div>
    <div class="stat-pill" style="background:linear-gradient(135deg,#fef3c7,#fffbeb);">
      <div style="font-size:1.7rem;">⏰</div>
      <div><div style="font-size:1.5rem;font-weight:800;color:#d97706;"><?= $expired ?></div><div class="small text-muted">Expired</div></div>
    </div>
    <div class="stat-pill" style="background:linear-gradient(135deg,#dbeafe,#eff6ff);">
      <div style="font-size:1.7rem;">📊</div>
      <div><div style="font-size:1.5rem;font-weight:800;color:#2563eb;"><?= $total_uses ?></div><div class="small text-muted">Total Uses</div></div>
    </div>
  </div>

  <!-- Discounts Table -->
  <div class="card border-0 shadow-sm disc-card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th class="px-4">Code</th>
              <th>Title</th>
              <th>Type</th>
              <th>Value</th>
              <th>Min Order</th>
              <th>Uses</th>
              <th>Validity</th>
              <th>Status</th>
              <th class="text-right pr-4">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($discounts)): ?>
          <tr><td colspan="9" class="text-center text-muted py-5">
            <div style="font-size:2.5rem;margin-bottom:8px;">🎟️</div>
            No discount codes yet. Create your first one!
          </td></tr>
          <?php else: foreach ($discounts as $d):
            $dtype      = $d['discount_type'] ?? ($d['type'] ?? 'percent');
            $dval       = (float)($d['value'] ?? 0);
            $dmin       = (float)($d['min_order_amount'] ?? 0);
            $duses      = (int)($d['times_used'] ?? 0);
            $dmaxuses   = $d['max_uses'] ?? null;
            $is_active  = (int)($d['is_active'] ?? 0);
            $ends_at    = $d['ends_at'] ?? null;
            $starts_at  = $d['starts_at'] ?? null;
            $is_expired = $ends_at && $ends_at < date('Y-m-d H:i:s');
            $type_classes = ['percent' => 'type-percent', 'fixed' => 'type-fixed', 'free_shipping' => 'type-free_shipping'];
            $tc = $type_classes[$dtype] ?? 'badge-secondary';
          ?>
          <tr class="<?= ($is_expired && $is_active) ? 'table-warning' : '' ?>">
            <td class="px-4">
              <span class="disc-code"><?= htmlspecialchars($d['code']) ?></span>
            </td>
            <td><?= htmlspecialchars($d['title'] ?? '') ?></td>
            <td>
              <span class="badge px-2 py-1 <?= $tc ?>" style="border-radius:20px;font-size:.74rem;">
                <?= $dtype === 'free_shipping' ? '🚚 Free Ship' : ucfirst($dtype) ?>
              </span>
            </td>
            <td class="fw-bold">
              <?= $dtype === 'percent' ? $dval.'%' : '&#8377;'.number_format($dval,0) ?>
            </td>
            <td><?= $dmin > 0 ? '&#8377;'.number_format($dmin,0) : '<span class="text-muted">—</span>' ?></td>
            <td>
              <?= $duses ?>
              <span class="text-muted">/</span>
              <?= $dmaxuses ?? '<span title="Unlimited">∞</span>' ?>
              <?php if ($dmaxuses && $duses >= $dmaxuses): ?>
              <span class="badge badge-danger ml-1" style="font-size:.65rem;">MAXED</span>
              <?php endif; ?>
            </td>
            <td>
              <small class="text-muted">
                <?= $starts_at ? date('d M', strtotime($starts_at)) : 'Anytime' ?>
                →
                <?= $ends_at ? date('d M y', strtotime($ends_at)) : '∞' ?>
              </small>
            </td>
            <td>
              <?php if ($is_expired): ?>
                <span class="badge badge-warning">Expired</span>
              <?php elseif ($is_active): ?>
                <span class="badge badge-success">Active</span>
              <?php else: ?>
                <span class="badge badge-secondary">Off</span>
              <?php endif; ?>
            </td>
            <td class="text-right pr-3">
              <form method="post" action="<?= base_url('admin/marketing/discounts') ?>" class="d-inline">
                <?= csrf_field() ?><input type="hidden" name="discount_action" value="toggle"><input type="hidden" name="id" value="<?= $d['id'] ?>">
                <button class="btn btn-sm btn-outline-<?= $is_active ? 'warning' : 'success' ?>"><?= $is_active ? 'Deactivate' : 'Activate' ?></button>
              </form>
              <form method="post" action="<?= base_url('admin/marketing/discounts') ?>" class="d-inline" onsubmit="return confirm('Delete this discount code?')">
                <?= csrf_field() ?><input type="hidden" name="discount_action" value="delete"><input type="hidden" name="id" value="<?= $d['id'] ?>">
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

<!-- New Discount Modal -->
<div class="modal fade" id="discountModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
      <div class="modal-header" style="background:linear-gradient(135deg,#1e3a5f,#2563eb);color:#fff;">
        <h5 class="modal-title">🎟️ Create New Discount Code</h5>
        <button type="button" class="close text-white" data-dismiss="modal" style="opacity:.8;">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/marketing/discounts') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="discount_action" value="create">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 form-group">
              <label class="fw-bold small">Code * <span class="text-muted">(auto-uppercased)</span></label>
              <input type="text" name="code" class="form-control" required placeholder="SAVE20" style="text-transform:uppercase;font-family:monospace;letter-spacing:.05em;">
            </div>
            <div class="col-md-4 form-group">
              <label class="fw-bold small">Discount Type</label>
              <select name="discount_type" class="form-control" id="discTypeSelect">
                <option value="percent">Percent (%)</option>
                <option value="fixed">Fixed (₹)</option>
                <option value="free_shipping">Free Shipping</option>
              </select>
            </div>
            <div class="col-md-4 form-group">
              <label class="fw-bold small">Value *</label>
              <input type="number" step="0.01" min="0" name="value" class="form-control" required placeholder="e.g. 20">
            </div>
            <div class="col-md-12 form-group">
              <label class="fw-bold small">Title / Description</label>
              <input type="text" name="title" class="form-control" placeholder="e.g. Diwali 20% Off — all orders above ₹999">
            </div>
            <div class="col-md-4 form-group">
              <label class="fw-bold small">Min Order (₹)</label>
              <input type="number" step="0.01" min="0" name="min_order_amount" class="form-control" value="0">
            </div>
            <div class="col-md-4 form-group">
              <label class="fw-bold small">Max Uses <span class="text-muted">(leave blank = unlimited)</span></label>
              <input type="number" min="1" name="max_uses" class="form-control" placeholder="Unlimited">
            </div>
            <div class="col-md-4 form-group"></div>
            <div class="col-md-6 form-group">
              <label class="fw-bold small">Starts At</label>
              <input type="datetime-local" name="starts_at" class="form-control">
            </div>
            <div class="col-md-6 form-group">
              <label class="fw-bold small">Expires At</label>
              <input type="datetime-local" name="ends_at" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary fw-bold px-4">
            <i class="fa fa-plus mr-1"></i>Create Discount
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
