<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Top Navigation & Vendor Header -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h3 class="font-weight-bold text-dark mb-0">
          <?= htmlspecialchars($vendor['business_name'] ?? 'Vendor Profile') ?>
        </h3>
        <?php
          $status_badges = [
            'approved'  => '<span class="badge badge-success px-2.5 py-1">Approved Seller</span>',
            'pending'   => '<span class="badge badge-warning text-dark px-2.5 py-1">Pending Verification</span>',
            'suspended' => '<span class="badge badge-danger px-2.5 py-1">Suspended</span>',
          ];
          echo $status_badges[$vendor['status'] ?? 'pending'] ?? '<span class="badge badge-secondary px-2 py-1">'.ucfirst($vendor['status'] ?? 'active').'</span>';
        ?>
      </div>
      <p class="text-muted small mb-0">
        <i class="fas fa-envelope mr-1 text-primary"></i> <?= htmlspecialchars($vendor['email'] ?? 'No email') ?> • 
        <i class="fas fa-calendar mr-1 text-muted"></i> Joined <?= !empty($vendor['created_at']) ? date('d M Y', strtotime($vendor['created_at'])) : 'Recently' ?>
      </p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/vendors') ?>" class="btn btn-outline-secondary btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-arrow-left mr-1"></i> Back to Vendors
      </a>
      <a href="<?= base_url('admin/vendors/payouts') ?>" class="btn btn-primary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-money-bill-wave mr-1"></i> Payouts Ledger
      </a>
    </div>
  </div>

  <!-- Vendor Profile Info Cards Grid -->
  <div class="row g-3 mb-4">
    <!-- Contact & Bank Card -->
    <div class="col-md-6 col-lg-3 mb-2">
      <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; border-left: 4px solid #4f46e5 !important;">
        <div class="text-muted text-uppercase font-weight-bold small mb-2" style="font-size:0.7rem;">
          <i class="fas fa-id-card text-primary mr-1"></i> Seller Contact &amp; Bank
        </div>
        <div class="font-weight-bold text-dark mb-1"><?= htmlspecialchars($vendor['contact_name'] ?? '—') ?></div>
        <div class="text-muted small mb-1"><i class="fas fa-phone mr-1"></i> <?= htmlspecialchars($vendor['phone'] ?? '—') ?></div>
        <div class="badge badge-light border text-left mt-auto py-1.5 px-2 small text-truncate">
          <i class="fas fa-university text-success mr-1"></i> <?= htmlspecialchars($vendor['payout_method'] ?? 'Bank NEFT / UPI') ?>
        </div>
      </div>
    </div>

    <!-- Commission Split Card -->
    <div class="col-md-6 col-lg-3 mb-2">
      <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; border-left: 4px solid #8b5cf6 !important;">
        <div class="text-muted text-uppercase font-weight-bold small mb-2" style="font-size:0.7rem;">
          <i class="fas fa-percentage text-purple mr-1"></i> Commission Split
        </div>
        <div class="font-weight-bold text-dark" style="font-size:1.4rem;">
          <?= $vendor['commission_value'] ?? 15 ?><?= ($vendor['commission_type'] ?? 'percent') === 'flat' ? '₹ flat' : '%' ?>
        </div>
        <div class="text-muted small mt-1">Platform fee retained per order</div>
      </div>
    </div>

    <!-- Products Listed Card -->
    <div class="col-md-6 col-lg-3 mb-2">
      <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; border-left: 4px solid #10b981 !important;">
        <div class="text-muted text-uppercase font-weight-bold small mb-2" style="font-size:0.7rem;">
          <i class="fas fa-tshirt text-success mr-1"></i> Listed SKUs / Apparel
        </div>
        <div class="font-weight-bold text-dark" style="font-size:1.4rem;">
          <?= count($products) ?>
        </div>
        <div class="text-muted small mt-1">Active items in catalog</div>
      </div>
    </div>

    <!-- Total Sales GMV Card -->
    <div class="col-md-6 col-lg-3 mb-2">
      <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; border-left: 4px solid #f59e0b !important;">
        <div class="text-muted text-uppercase font-weight-bold small mb-2" style="font-size:0.7rem;">
          <i class="fas fa-chart-line text-warning mr-1"></i> Lifetime Sales GMV
        </div>
        <div class="font-weight-bold text-dark" style="font-size:1.4rem;">
          ₹<?= number_format($total_sales ?? 0, 2) ?>
        </div>
        <div class="text-muted small mt-1">₹<?= number_format($total_comm ?? 0, 2) ?> platform commission</div>
      </div>
    </div>
  </div>

  <!-- 1. Listed Products Section -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark">
        <i class="fas fa-boxes text-primary mr-2"></i> Listed Products &amp; Garments
      </span>
      <span class="badge badge-light border font-weight-bold px-2.5 py-1"><?= count($products) ?> SKUs Listed</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3" style="width:50px;">#</th>
              <th class="py-3">Garment / Product Title</th>
              <th class="py-3">Retail Price</th>
              <th class="py-3">Catalog Status</th>
              <th class="py-3 text-right px-3">Storefront Preview</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($products as $idx => $p): 
            $img = !empty($p['primary_image']) ? $p['primary_image'] : 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=800&auto=format&fit=crop&q=80';
          ?>
          <tr>
            <td class="px-3 text-muted font-weight-bold"><?= $idx + 1 ?></td>
            <td>
              <div class="d-flex align-items-center">
                <img src="<?= htmlspecialchars($img) ?>" class="rounded border mr-2.5 shadow-xs" style="width:40px; height:40px; object-fit:cover; flex-shrink:0;" alt="">
                <div>
                  <div class="font-weight-bold text-dark"><?= htmlspecialchars($p['title']) ?></div>
                  <div class="text-muted small" style="font-size:0.75rem;">SKU ID: VP-<?= $p['id'] ?></div>
                </div>
              </div>
            </td>
            <td class="font-weight-bold text-dark">₹<?= number_format($p['base_price'] ?? 0, 2) ?></td>
            <td>
              <span class="badge badge-<?= ($p['product_status'] ?? 'active') === 'active' ? 'success' : 'secondary' ?> px-2.5 py-1">
                <?= ucfirst($p['product_status'] ?? 'active') ?>
              </span>
            </td>
            <td class="text-right px-3">
              <a href="<?= base_url('product/'.($p['slug'] ?? 'mens-mountain-peak-graphic-oversized-t-shirt')) ?>" target="_blank" class="btn btn-outline-primary btn-sm px-2.5 py-1 font-weight-bold" style="border-radius:6px;">
                <i class="fas fa-external-link-alt mr-1"></i> View on Store
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($products)): ?>
          <tr><td colspan="5" class="text-center text-muted py-4">No products listed by this seller yet</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 2. Recent Orders & Line Items Section -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark">
        <i class="fas fa-shopping-bag text-success mr-2"></i> Recent Orders &amp; Vendor Line Items
      </span>
      <span class="badge badge-light border font-weight-bold px-2.5 py-1"><?= count($orders) ?> Orders</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3">Order Number</th>
              <th class="py-3">Purchased Item</th>
              <th class="py-3 text-center">Qty</th>
              <th class="py-3">Total Revenue</th>
              <th class="py-3">Platform Fee</th>
              <th class="py-3">Fulfillment Status</th>
              <th class="py-3">Order Date</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach (array_slice($orders, 0, 20) as $o): ?>
          <tr>
            <td class="px-3 font-weight-bold">
              <a href="<?= base_url('admin/orders/view/'.($o['order_id'] ?? 1)) ?>" class="text-decoration-none text-dark hover:text-primary">
                <?= htmlspecialchars($o['order_number'] ?? '#ORD-'.($o['order_id'] ?? 1)) ?>
              </a>
            </td>
            <td>
              <div class="font-weight-bold text-dark small"><?= htmlspecialchars($o['product_title'] ?? 'Custom Apparel') ?></div>
              <?php if (!empty($o['variant_title'])): ?>
              <div class="text-muted small" style="font-size:0.75rem;"><?= htmlspecialchars($o['variant_title']) ?></div>
              <?php endif; ?>
            </td>
            <td class="text-center font-weight-bold"><?= $o['quantity'] ?? 1 ?></td>
            <td class="font-weight-bold text-dark">₹<?= number_format($o['total_price'] ?? 0, 2) ?></td>
            <td class="text-purple font-weight-bold">₹<?= number_format($o['vendor_commission_amount'] ?? 0, 2) ?></td>
            <td>
              <?php
                $f_status = $o['vendor_fulfillment_status'] ?? 'unfulfilled';
                $f_badge = ($f_status === 'shipped') ? 'badge-success' : 'badge-warning text-dark';
              ?>
              <span class="badge <?= $f_badge ?> px-2.5 py-1"><?= ucfirst($f_status) ?></span>
            </td>
            <td><small class="text-muted"><?= !empty($o['order_date']) ? date('d M Y, h:i A', strtotime($o['order_date'])) : '—' ?></small></td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($orders)): ?>
          <tr><td colspan="7" class="text-center text-muted py-4">No order items recorded for this seller yet</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- 3. Payout History Section -->
  <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark">
        <i class="fas fa-receipt text-warning mr-2"></i> Payout Settlements History
      </span>
      <span class="badge badge-light border font-weight-bold px-2.5 py-1"><?= count($payouts) ?> Settlements</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3" style="width:60px;">ID</th>
              <th class="py-3">Settlement Amount</th>
              <th class="py-3">Period</th>
              <th class="py-3">Status</th>
              <th class="py-3">Bank Reference / UTR</th>
              <th class="py-3 text-right px-3">Date</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($payouts as $py): ?>
          <tr>
            <td class="px-3 font-weight-bold text-muted">#<?= $py['id'] ?></td>
            <td class="font-weight-bold text-success" style="font-size:1.05rem;">
              ₹<?= number_format($py['net_payable'] ?? ($py['amount'] ?? 0), 2) ?>
            </td>
            <td>
              <span class="badge badge-light border font-mono small text-muted">
                <?= !empty($py['period_start']) ? date('d M', strtotime($py['period_start'])) : '' ?> – <?= !empty($py['period_end']) ? date('d M Y', strtotime($py['period_end'])) : date('d M Y') ?>
              </span>
            </td>
            <td>
              <span class="badge badge-<?= ($py['status'] ?? 'pending') === 'paid' ? 'success' : 'warning text-dark' ?> px-2.5 py-1">
                <?= ucfirst($py['status'] ?? 'pending') ?>
              </span>
            </td>
            <td>
              <code class="font-mono font-weight-bold text-dark"><?= htmlspecialchars($py['reference'] ?? 'Pending Processing') ?></code>
            </td>
            <td class="text-right px-3 text-muted small">
              <?= !empty($py['created_at']) ? date('d M Y', strtotime($py['created_at'])) : '—' ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($payouts)): ?>
          <tr><td colspan="6" class="text-center text-muted py-4">No payout settlements generated yet</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
