<div class="container" style="padding-top:40px;padding-bottom:80px">
  <div style="font-size:12px;color:var(--text-3);margin-bottom:16px">
    <a href="<?= base_url('account') ?>">My Account</a> / <a href="<?= base_url('account/orders') ?>">Order History</a> / <span><?= htmlspecialchars($order['order_number']) ?></span>
  </div>

  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:12px">
    <div>
      <h1 style="font-size:28px;font-weight:800;margin-bottom:4px">Order <?= htmlspecialchars($order['order_number']) ?></h1>
      <div style="font-size:13px;color:var(--text-2)">Placed on <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></div>
    </div>
    <div style="display:flex;gap:10px">
      <span class="nd-badge <?= $order['payment_status'] === 'paid' ? 'success' : 'warning' ?>" style="font-size:13px;padding:6px 14px">
        Payment: <?= strtoupper($order['payment_status']) ?>
      </span>
      <span class="nd-badge <?= $order['fulfillment_status'] === 'fulfilled' ? 'success' : 'neutral' ?>" style="font-size:13px;padding:6px 14px">
        Fulfillment: <?= ucfirst($order['fulfillment_status']) ?>
      </span>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1fr 340px;gap:36px;align-items:start">
    <!-- Left: Items & Shipments -->
    <div>
      <!-- Shipment Tracking if available -->
      <?php if (!empty($order['shipments'])): ?>
      <div style="background:var(--bg-2);border:1px solid rgba(16,185,129,0.3);border-radius:var(--radius);padding:24px;margin-bottom:24px">
        <h2 style="font-size:16px;font-weight:700;margin-bottom:12px;color:var(--success)">🚚 Shipment Tracking</h2>
        <?php foreach ($order['shipments'] as $shp): ?>
        <div style="font-size:14px;color:var(--text-2);line-height:1.6">
          <div>Carrier: <strong><?= htmlspecialchars($shp['carrier']) ?></strong></div>
          <div>Tracking Number: <strong style="color:var(--text-1)"><?= htmlspecialchars($shp['tracking_number']) ?></strong></div>
          <?php if (!empty($shp['tracking_url'])): ?>
            <div style="margin-top:8px">
              <a href="<?= htmlspecialchars($shp['tracking_url']) ?>" target="_blank" class="nd-btn nd-btn-outline nd-btn-sm">Track Package Live →</a>
            </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- Items List -->
      <div style="background:var(--bg-2);border:1px solid var(--border);border-radius:var(--radius);padding:24px">
        <h2 style="font-size:16px;font-weight:700;margin-bottom:20px">Items in this Order</h2>
        <div style="display:flex;flex-direction:column;gap:16px">
          <?php foreach ($order['items'] as $item): ?>
          <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:16px;border-bottom:1px solid var(--border)">
            <div>
              <div style="font-weight:700;font-size:14px;color:var(--text-1)"><?= htmlspecialchars($item['product_title']) ?></div>
              <?php if (!empty($item['variant_title']) && $item['variant_title'] !== 'Default'): ?>
                <div style="font-size:12px;color:var(--text-3);margin-top:2px"><?= htmlspecialchars($item['variant_title']) ?></div>
              <?php endif; ?>
              <div style="font-size:12px;color:var(--text-2);margin-top:4px">Qty: <?= $item['quantity'] ?> × ₹<?= number_format($item['unit_price'], 0) ?></div>
            </div>
            <div style="font-weight:800;font-size:15px">₹<?= number_format($item['total_price'], 0) ?></div>
          </div>
          <?php endforeach; ?>
        </div>

        <div style="padding-top:16px;font-size:13px;color:var(--text-2);max-width:280px;margin-left:auto">
          <div style="display:flex;justify-content:space-between;margin-bottom:6px">
            <span>Subtotal</span>
            <span>₹<?= number_format($order['subtotal'], 0) ?></span>
          </div>
          <?php if ($order['discount_amount'] > 0): ?>
          <div style="display:flex;justify-content:space-between;margin-bottom:6px;color:#34d399">
            <span>Discount</span>
            <span>-₹<?= number_format($order['discount_amount'], 0) ?></span>
          </div>
          <?php endif; ?>
          <div style="display:flex;justify-content:space-between;margin-bottom:6px">
            <span>Shipping</span>
            <span><?= $order['shipping_amount'] == 0 ? 'FREE' : '₹' . number_format($order['shipping_amount'], 0) ?></span>
          </div>
          <div style="border-top:1px solid var(--border);padding-top:10px;margin-top:8px;display:flex;justify-content:space-between;font-size:16px;font-weight:900;color:var(--text-1)">
            <span>Total</span>
            <span>₹<?= number_format($order['total'], 0) ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Delivery Address -->
    <div style="background:var(--bg-2);border:1px solid var(--border);border-radius:var(--radius);padding:24px">
      <h3 style="font-size:14px;font-weight:700;text-transform:uppercase;color:var(--text-3);margin-bottom:12px">Delivery Address</h3>
      <div style="font-size:13px;color:var(--text-2);line-height:1.6">
        <strong style="color:var(--text-1)"><?= htmlspecialchars($order['shipping_address']['first_name'] ?? 'Customer') ?> <?= htmlspecialchars($order['shipping_address']['last_name'] ?? '') ?></strong><br>
        <?= htmlspecialchars($order['shipping_address']['address1'] ?? '') ?><br>
        <?php if (!empty($order['shipping_address']['address2'])): ?><?= htmlspecialchars($order['shipping_address']['address2']) ?><br><?php endif; ?>
        <?= htmlspecialchars($order['shipping_address']['city'] ?? '') ?>, <?= htmlspecialchars($order['shipping_address']['state'] ?? '') ?> - <?= htmlspecialchars($order['shipping_address']['pincode'] ?? '') ?><br>
        Phone: <?= htmlspecialchars($order['shipping_address']['phone'] ?? '') ?>
      </div>
    </div>
  </div>
</div>
