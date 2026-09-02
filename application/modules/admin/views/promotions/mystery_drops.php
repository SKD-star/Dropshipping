<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#8b5cf6;">🎁 Mystery Drops</h2>
      <p class="text-muted mb-0">Surprise product reveals with countdown clocks and blind-box sales</p>
    </div>
    <button class="btn btn-primary btn-sm px-4" data-toggle="modal" data-target="#mysteryModal" style="background:#8b5cf6;border-color:#8b5cf6;"><i class="fa fa-plus mr-1"></i> New Mystery Drop</button>
  </div>
  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Drop Title</th><th>Blind Box Price</th><th>Reveal Date/Time</th><th>Stock Cap</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($drops as $d):
          $d_title    = $d['title'] ?? ($d['name'] ?? ($d['drop_name'] ?? 'Mystery Drop'));
          $d_price    = (float)($d['price'] ?? ($d['amount'] ?? 0));
          $d_reveal   = $d['reveal_at'] ?? ($d['reveal_date'] ?? null);
          $d_stock    = $d['stock_limit'] ?? ($d['max_stock'] ?? null);
          $d_active   = (int)($d['is_active'] ?? ($d['active'] ?? 1));
        ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($d_title) ?></td>
          <td>₹<?= number_format($d_price, 2) ?></td>
          <td><small><?= $d_reveal ? date('d M Y, h:i A', strtotime($d_reveal)) : 'No date set' ?></small></td>
          <td><?= $d_stock ? number_format($d_stock) : 'Unlimited' ?></td>
          <td><span class="badge badge-<?= $d_active ? 'success' : 'secondary' ?>"><?= $d_active ? 'Active' : 'Disabled' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/promotions/mystery_drops') ?>" class="d-inline">
              <?= csrf_field() ?>
              <input type="hidden" name="mystery_action" value="toggle">
              <input type="hidden" name="id" value="<?= $d['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $d_active ? 'warning' : 'success' ?>"><?= $d_active ? 'Disable' : 'Enable' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/promotions/mystery_drops') ?>" class="d-inline" onsubmit="return confirm('Delete this mystery drop?')">
              <?= csrf_field() ?>
              <input type="hidden" name="mystery_action" value="delete">
              <input type="hidden" name="id" value="<?= $d['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($drops)): ?><tr><td colspan="6" class="text-center text-muted py-5">No mystery drops currently active.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="mysteryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Mystery Drop</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/promotions/mystery_drops') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="mystery_action" value="create">
        <div class="modal-body">
          <div class="form-group"><label>Campaign Title *</label><input type="text" name="title" class="form-control" required placeholder="e.g. Cyber Mystery Box #1"></div>
          <div class="row">
            <div class="col-6 form-group"><label>Blind Price (₹) *</label><input type="number" step="0.01" min="1" name="price" class="form-control" required placeholder="499"></div>
            <div class="col-6 form-group"><label>Stock Limit</label><input type="number" min="1" name="stock_limit" class="form-control" placeholder="100"></div>
          </div>
          <div class="form-group"><label>Reveal At (Countdown Ends) *</label><input type="datetime-local" name="reveal_at" class="form-control" required></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-primary" style="background:#8b5cf6;border-color:#8b5cf6;">Create Drop</button></div>
      </form>
    </div>
  </div>
</div>
