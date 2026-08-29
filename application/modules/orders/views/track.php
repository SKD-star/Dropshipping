<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">📦 Track Your Order</h1>
        <p class="text-muted">Enter your Order Number and Email or Phone to see real-time delivery status.</p>
      </div>

      <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
          <form method="get" action="<?= base_url('orders/track') ?>" class="row g-3">
            <div class="col-md-6 form-group">
              <label class="form-label fw-bold small">Order Number *</label>
              <input type="text" name="order_number" class="form-control" placeholder="e.g. ND-10023" value="<?= htmlspecialchars($order_number ?? '') ?>" required>
            </div>
            <div class="col-md-6 form-group">
              <label class="form-label fw-bold small">Email or Phone</label>
              <input type="text" name="contact" class="form-control" placeholder="e.g. customer@example.com" value="<?= htmlspecialchars($email_or_phone ?? '') ?>">
            </div>
            <div class="col-12 mt-3">
              <button type="submit" class="btn btn-primary btn-block w-100 py-2 fw-bold">Track Shipment</button>
            </div>
          </form>
        </div>
      </div>

      <?php if (!empty($order)):
        $status_steps = ['placed' => 1, 'confirmed' => 2, 'processing' => 3, 'shipped' => 4, 'delivered' => 5];
        $current_status = strtolower($order['fulfillment_status'] ?? $order['status'] ?? 'placed');
        $step_num = $status_steps[$current_status] ?? 2;
      ?>
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0 fw-bold">Order #<?= htmlspecialchars($order['order_number'] ?? $order['id']) ?></h5>
            <small class="text-muted">Placed on <?= date('d M Y, h:i A', strtotime($order['created_at'] ?? 'now')) ?></small>
          </div>
          <span class="badge badge-success px-3 py-2 text-uppercase"><?= htmlspecialchars($current_status) ?></span>
        </div>
        <div class="card-body p-4">
          <!-- Stepper -->
          <div class="d-flex justify-content-between text-center mb-4 position-relative">
            <div class="flex-fill">
              <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white bg-success" style="width:36px;height:36px;">✓</div>
              <small class="fw-bold d-block">Placed</small>
            </div>
            <div class="flex-fill">
              <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white <?= $step_num >= 2 ? 'bg-success' : 'bg-secondary' ?>" style="width:36px;height:36px;"><?= $step_num >= 2 ? '✓' : '2' ?></div>
              <small class="fw-bold d-block">Confirmed</small>
            </div>
            <div class="flex-fill">
              <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white <?= $step_num >= 3 ? 'bg-success' : 'bg-secondary' ?>" style="width:36px;height:36px;"><?= $step_num >= 3 ? '✓' : '3' ?></div>
              <small class="fw-bold d-block">Processing</small>
            </div>
            <div class="flex-fill">
              <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white <?= $step_num >= 4 ? 'bg-success' : 'bg-secondary' ?>" style="width:36px;height:36px;"><?= $step_num >= 4 ? '✓' : '4' ?></div>
              <small class="fw-bold d-block">Shipped</small>
            </div>
            <div class="flex-fill">
              <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center text-white <?= $step_num >= 5 ? 'bg-success' : 'bg-secondary' ?>" style="width:36px;height:36px;"><?= $step_num >= 5 ? '✓' : '5' ?></div>
              <small class="fw-bold d-block">Delivered</small>
            </div>
          </div>

          <hr>

          <h6 class="fw-bold mb-3">Items in this Order</h6>
          <div class="table-responsive">
            <table class="table table-sm mb-0">
              <thead><tr><th>Item</th><th>Qty</th><th class="text-right">Price</th></tr></thead>
              <tbody>
              <?php foreach ($items as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['title'] ?? $item['product_name'] ?? 'Product Item') ?></td>
                <td><?= $item['quantity'] ?? 1 ?></td>
                <td class="text-right">₹<?= number_format($item['price'] ?? 0, 2) ?></td>
              </tr>
              <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr><th colspan="2" class="text-right">Total:</th><th class="text-right">₹<?= number_format($order['total_amount'] ?? $order['total_price'] ?? 0, 2) ?></th></tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
      <?php elseif (!empty($order_number)): ?>
      <div class="alert alert-warning text-center">
        <i class="fa fa-search mr-2"></i> No order details found for order number: <strong><?= htmlspecialchars($order_number) ?></strong>. Please verify and try again.
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
