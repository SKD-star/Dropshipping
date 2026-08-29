<div class="card shadow">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>💳 Payments & Revenue Ledger</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover usr-table mb-0">
        <thead>
          <tr>
            <th>Txn ID</th>
            <th>Order #</th>
            <th>Payment Method</th>
            <th>Amount Processed</th>
            <th>Status</th>
            <th>Timestamp</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($payments) && empty($paid_orders)): ?>
            <tr><td colspan="6" class="text-center py-5 text-muted">No captured payment records found.</td></tr>
          <?php else: ?>
            <?php if (!empty($payments)): ?>
              <?php foreach ($payments as $pay): ?>
                <tr>
                  <td><code><?= htmlspecialchars($pay['gateway_payment_id'] ?? ('PAY-' . $pay['id'])) ?></code></td>
                  <td>#<?= (int)$pay['order_id'] ?></td>
                  <td><?= strtoupper(htmlspecialchars($pay['gateway'] ?? 'Razorpay')) ?></td>
                  <td><strong>₹<?= number_format($pay['amount'], 2) ?></strong></td>
                  <td><span class="badge badge-success"><?= ucfirst($pay['status']) ?></span></td>
                  <td><?= date('d M Y, H:i', strtotime($pay['created_at'])) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <?php foreach ($paid_orders as $op): ?>
                <tr>
                  <td><code>TXN-<?= $op['id'] ?></code></td>
                  <td>#<?= htmlspecialchars($op['order_number'] ?? $op['id']) ?></td>
                  <td><?= strtoupper(htmlspecialchars($op['payment_method'] ?? 'Online UPI / Card')) ?></td>
                  <td><strong>₹<?= number_format($op['total_amount'], 2) ?></strong></td>
                  <td><span class="badge badge-success">Captured</span></td>
                  <td><?= date('d M Y, H:i', strtotime($op['created_at'])) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
