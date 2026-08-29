<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="fw-bold mb-0">🎟️ Discount Codes</h2><p class="text-muted mb-0">Create &amp; manage promotional discount codes</p></div>
    <button class="btn btn-primary btn-sm px-4" data-toggle="modal" data-target="#discountModal"><i class="fa fa-plus mr-1"></i> New Discount</button>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?><div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('error')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Code</th><th>Title</th><th>Type</th><th>Value</th><th>Min Order</th><th>Uses</th><th>Validity</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if (empty($discounts)): ?>
        <tr><td colspan="9" class="text-center text-muted py-5">No discount codes yet</td></tr>
        <?php else: foreach ($discounts as $d):
          $is_expired = !empty($d['ends_at']) && $d['ends_at'] < date('Y-m-d H:i:s');
        ?>
        <tr class="<?= ($is_expired && $d['is_active']) ? 'table-warning' : '' ?>">
          <td><code class="fw-bold"><?= htmlspecialchars($d['code']) ?></code></td>
          <td><?= htmlspecialchars($d['title'] ?? '') ?></td>
          <td><?= ucfirst($d['discount_type'] ?? '') ?></td>
          <td><?= $d['discount_type']==='percent' ? $d['value'].'%' : '&#8377;'.$d['value'] ?></td>
          <td><?= $d['min_order_amount'] > 0 ? '&#8377;'.number_format($d['min_order_amount'],0) : '—' ?></td>
          <td><?= $d['times_used'] ?? 0 ?> / <?= $d['max_uses'] ?? '∞' ?></td>
          <td><small><?= $d['starts_at'] ? date('d M', strtotime($d['starts_at'])) : 'Anytime' ?> – <?= $d['ends_at'] ? date('d M y', strtotime($d['ends_at'])) : '∞' ?></small></td>
          <td>
            <?php if ($is_expired): ?><span class="badge badge-warning">Expired</span>
            <?php elseif ($d['is_active']): ?><span class="badge badge-success">Active</span>
            <?php else: ?><span class="badge badge-secondary">Off</span><?php endif; ?>
          </td>
          <td>
            <form method="post" action="<?= base_url('admin/marketing/discounts') ?>" class="d-inline">
              <?= csrf_field() ?><input type="hidden" name="discount_action" value="toggle"><input type="hidden" name="id" value="<?= $d['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $d['is_active'] ? 'warning' : 'success' ?>"><?= $d['is_active'] ? 'Off' : 'On' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/marketing/discounts') ?>" class="d-inline" onsubmit="return confirm('Delete?')">
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

<div class="modal fade" id="discountModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
  <div class="modal-header"><h5 class="modal-title">New Discount Code</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
  <form method="post" action="<?= base_url('admin/marketing/discounts') ?>">
    <?= csrf_field() ?><input type="hidden" name="discount_action" value="create">
    <div class="modal-body">
      <div class="row">
        <div class="col-md-4 form-group"><label>Code *</label><input type="text" name="code" class="form-control text-uppercase" required placeholder="SAVE20" style="text-transform:uppercase;"></div>
        <div class="col-md-4 form-group"><label>Type</label><select name="discount_type" class="form-control"><option value="percent">Percent (%)</option><option value="fixed">Fixed (&#8377;)</option><option value="free_shipping">Free Shipping</option></select></div>
        <div class="col-md-4 form-group"><label>Value *</label><input type="number" step="0.01" min="0" name="value" class="form-control" required></div>
        <div class="col-md-12 form-group"><label>Title / Description</label><input type="text" name="title" class="form-control" placeholder="e.g. Diwali 20% Off"></div>
        <div class="col-md-4 form-group"><label>Min Order (&#8377;)</label><input type="number" step="0.01" min="0" name="min_order_amount" class="form-control" value="0"></div>
        <div class="col-md-4 form-group"><label>Max Uses</label><input type="number" min="0" name="max_uses" class="form-control" placeholder="Unlimited"></div>
        <div class="col-md-6 form-group"><label>Starts At</label><input type="datetime-local" name="starts_at" class="form-control"></div>
        <div class="col-md-6 form-group"><label>Ends At</label><input type="datetime-local" name="ends_at" class="form-control"></div>
      </div>
    </div>
    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary">Create Discount</button></div>
  </form>
</div></div></div>
