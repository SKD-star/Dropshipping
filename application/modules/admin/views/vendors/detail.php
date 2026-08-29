<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0"><?= htmlspecialchars($vendor['business_name']??'Vendor') ?></h2>
      <span class="badge badge-<?= $vendor['status']==='approved'?'success':($vendor['status']==='suspended'?'danger':'warning') ?> mr-2"><?= ucfirst($vendor['status']) ?></span>
      <small class="text-muted"><?= htmlspecialchars($vendor['email']??'') ?></small>
    </div>
    <a href="<?= base_url('admin/vendors') ?>" class="btn btn-outline-secondary btn-sm">&#8592; Back to Vendors</a>
  </div>
  <div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><h6 class="fw-bold">Contact</h6><p class="mb-1"><?= htmlspecialchars($vendor['contact_name']??'—') ?></p><p class="mb-1"><?= htmlspecialchars($vendor['phone']??'') ?></p><p class="mb-0"><small><?= htmlspecialchars($vendor['payout_method']??'Bank Transfer') ?></small></p></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><h6 class="fw-bold">Commission</h6><div style="font-size:1.5rem;font-weight:800;"><?= $vendor['commission_value']??0 ?><?= $vendor['commission_type']==='flat'?'&#8377;':'%' ?></div></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><h6 class="fw-bold">Products Listed</h6><div style="font-size:1.5rem;font-weight:800;"><?= count($products) ?></div></div></div></div>
  </div>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold">Listed Products</div>
    <div class="card-body p-0"><table class="table table-sm mb-0">
      <thead><tr><th>Title</th><th>Price</th><th>Status</th></tr></thead>
      <tbody>
      <?php foreach ($products as $p): ?>
      <tr><td><?= htmlspecialchars($p['title']??'') ?></td><td>&#8377;<?= number_format($p['base_price']??0,2) ?></td><td><span class="badge badge-<?= $p['product_status']==='active'?'success':'secondary' ?>"><?= $p['product_status'] ?></span></td></tr>
      <?php endforeach; ?>
      <?php if(empty($products)): ?><tr><td colspan="3" class="text-center text-muted py-3">No products listed</td></tr><?php endif; ?>
      </tbody></table></div></div>

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold">Recent Orders</div>
    <div class="card-body p-0"><table class="table table-sm mb-0">
      <thead><tr><th>Order #</th><th>Item</th><th>Revenue</th><th>Date</th></tr></thead>
      <tbody>
      <?php foreach (array_slice($orders, 0, 20) as $o): ?>
      <tr><td><?= htmlspecialchars($o['order_number']??'') ?></td><td><?= htmlspecialchars($o['product_title']??'') ?></td><td>&#8377;<?= number_format($o['total_price']??0,2) ?></td><td><small><?= $o['order_date']??'' ?></small></td></tr>
      <?php endforeach; ?>
      <?php if(empty($orders)): ?><tr><td colspan="4" class="text-center text-muted py-3">No orders yet</td></tr><?php endif; ?>
      </tbody></table></div></div>
</div>
