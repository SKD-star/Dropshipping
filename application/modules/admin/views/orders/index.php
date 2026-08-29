<div class="card shadow">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>📦 Orders Management</span>
    <span class="small text-white-50">Total Orders: <?= count($orders) ?></span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover usr-table mb-0">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Items</th>
            <th>Total Amount</th>
            <th>Payment Status</th>
            <th>Fulfillment</th>
            <th>Order Date</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($orders)): ?>
            <tr><td colspan="8" class="text-center py-5 text-muted">No orders found.</td></tr>
          <?php else: ?>
            <?php foreach ($orders as $ord): ?>
              <?php
                $badge_pay = $ord['payment_status'] === 'paid' ? 'badge-success' : ($ord['payment_status'] === 'pending' ? 'badge-warning' : 'badge-danger');
                $badge_ful = $ord['fulfillment_status'] === 'fulfilled' ? 'badge-success' : 'badge-secondary';
                $shipping = json_decode($ord['shipping_address_json'] ?? '', true);
                $cust_name = $shipping['name'] ?? 'Customer';
              ?>
              <tr>
                <td><strong>#<?= htmlspecialchars($ord['order_number'] ?? $ord['id']) ?></strong></td>
                <td><?= htmlspecialchars($cust_name) ?></td>
                <td><?= (int)($ord['item_count'] ?? 1) ?> items</td>
                <td><strong>₹<?= number_format($ord['total_amount'], 2) ?></strong></td>
                <td><span class="badge <?= $badge_pay ?>"><?= ucfirst($ord['payment_status']) ?></span></td>
                <td><span class="badge <?= $badge_ful ?>"><?= ucfirst($ord['fulfillment_status']) ?></span></td>
                <td><?= date('d M Y, H:i', strtotime($ord['created_at'])) ?></td>
                <td style="text-align: right;">
                  <button class="btn btn-sm btn-outline-primary" onclick="alert('Order #<?= $ord['id'] ?> details loaded.')">
                    Details
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
