<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Page Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h4 class="font-weight-bold mb-0 text-dark">📦 Orders Management &amp; Fulfillment</h4>
        <span class="badge badge-primary px-2 py-1" style="font-size:0.75rem;"><?= $total_orders ?? count($orders) ?> Orders</span>
      </div>
      <p class="text-muted small mb-0">Manage customer order flow, track automated drop dispatch, and issue shipment updates.</p>
    </div>
    <div class="d-flex gap-2">
      <a href="?filter=all" class="btn btn-sm <?= empty($filter) || $filter === 'all' ? 'btn-primary font-weight-bold' : 'btn-outline-secondary' ?>">All</a>
      <a href="?filter=unfulfilled" class="btn btn-sm <?= ($filter ?? '') === 'unfulfilled' ? 'btn-warning text-dark font-weight-bold' : 'btn-outline-warning' ?>">
        <i class="fas fa-clock mr-1"></i> Unfulfilled (<?= $unfulfilled_cnt ?? 0 ?>)
      </a>
      <a href="?filter=paid" class="btn btn-sm <?= ($filter ?? '') === 'paid' ? 'btn-success font-weight-bold' : 'btn-outline-success' ?>">
        <i class="fas fa-check-circle mr-1"></i> Paid (<?= $paid_cnt ?? 0 ?>)
      </a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
      <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php endif; ?>

  <?php if (!empty($cust_id) || !empty($q)): ?>
  <div class="alert alert-info d-flex justify-content-between align-items-center mb-3 shadow-sm border-0">
    <div>
      <i class="fas fa-filter mr-2"></i> Filtering orders for: <strong><?= htmlspecialchars($q ?: ('Customer #'.$cust_id)) ?></strong>
      <span class="badge badge-light ml-2 font-mono"><?= count($orders) ?> matching</span>
    </div>
    <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-dark bg-white font-weight-bold">
      <i class="fas fa-times mr-1"></i> Clear Filter
    </a>
  </div>
  <?php endif; ?>

  <!-- Order Metrics Strip -->
  <div class="row g-2 mb-3">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Total Processed Revenue</div>
        <div class="h5 font-weight-bold text-dark mb-0">₹<?= number_format($total_amount ?? 0, 2) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Total Orders Placed</div>
        <div class="h5 font-weight-bold text-primary mb-0"><?= number_format($total_orders ?? count($orders)) ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Awaiting Shipment</div>
        <div class="h5 font-weight-bold text-warning mb-0"><?= $unfulfilled_cnt ?? 0 ?></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm p-3 rounded" style="background:#ffffff;">
        <div class="text-muted small">Paid / Settled</div>
        <div class="h5 font-weight-bold text-success mb-0"><?= $paid_cnt ?? 0 ?></div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; overflow:hidden;">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="font-size:0.875rem;">
        <thead class="bg-light text-muted text-uppercase small font-weight-bold">
          <tr>
            <th style="min-width:120px;">Order #</th>
            <th style="min-width:160px;">Customer</th>
            <th style="min-width:100px;">Items</th>
            <th style="min-width:130px;">Total Amount</th>
            <th style="min-width:130px;">Payment Status</th>
            <th style="min-width:130px;">Fulfillment</th>
            <th style="min-width:150px;">Order Date</th>
            <th style="min-width:110px;" class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($orders)): ?>
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="fas fa-shopping-bag fa-2x mb-2 d-block opacity-50"></i>
                No orders matching the current criteria.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($orders as $ord): 
              $pay_status = strtolower($ord['payment_status'] ?? 'unpaid');
              $badge_pay = $pay_status === 'paid' ? 'badge-success' : ($pay_status === 'pending' || $pay_status === 'unpaid' ? 'badge-warning text-dark' : 'badge-danger');
              
              $ful_status = strtolower($ord['fulfillment_status'] ?? 'unfulfilled');
              $badge_ful = $ful_status === 'fulfilled' ? 'badge-success' : ($ful_status === 'in_transit' ? 'badge-info' : 'badge-secondary');
              
              $shipping = json_decode($ord['shipping_address_json'] ?? '', true);
              $cust_name = $shipping['name'] ?? ($ord['customer_name'] ?? ('Customer #' . ($ord['customer_id'] ?? $ord['id'])));
              $total = (float)($ord['total'] ?? $ord['total_amount'] ?? 0);
            ?>
              <tr>
                <!-- Order Number -->
                <td>
                  <strong class="text-primary font-weight-bold">#<?= htmlspecialchars($ord['order_number'] ?? $ord['id']) ?></strong>
                  <div class="small text-muted">ID: <?= $ord['id'] ?></div>
                </td>

                <!-- Customer -->
                <td>
                  <div class="font-weight-bold text-dark"><?= htmlspecialchars($cust_name) ?></div>
                  <small class="text-muted"><?= htmlspecialchars($shipping['city'] ?? ($shipping['phone'] ?? 'Storefront Client')) ?></small>
                </td>

                <!-- Items Count -->
                <td>
                  <span class="badge badge-light border text-dark px-2 py-1">
                    <?= (int)($ord['item_count'] ?? 1) ?> item<?= (int)($ord['item_count'] ?? 1) > 1 ? 's' : '' ?>
                  </span>
                </td>

                <!-- Total Amount -->
                <td>
                  <strong class="text-dark font-weight-bold">₹<?= number_format($total, 2) ?></strong>
                </td>

                <!-- Payment Status -->
                <td>
                  <span class="badge <?= $badge_pay ?> px-2 py-1">
                    <?= ucfirst($pay_status) ?>
                  </span>
                </td>

                <!-- Fulfillment Status -->
                <td>
                  <span class="badge <?= $badge_ful ?> px-2 py-1">
                    <?= ucfirst($ful_status) ?>
                  </span>
                </td>

                <!-- Date -->
                <td>
                  <div class="text-dark small"><?= date('d M Y', strtotime($ord['created_at'])) ?></div>
                  <small class="text-muted"><?= date('H:i A', strtotime($ord['created_at'])) ?></small>
                </td>

                <!-- Action Button (Opens Modal Drawer) -->
                <td class="text-right">
                  <button type="button" class="btn btn-sm btn-primary px-3 font-weight-bold" onclick="openOrderModal(<?= $ord['id'] ?>)">
                    <i class="fas fa-eye mr-1"></i> Details
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

<!-- Order Detail Interactive Modal Drawer -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow:hidden;">
      <div class="modal-header bg-dark text-white py-3 px-4">
        <div>
          <h5 class="modal-title font-weight-bold mb-0" id="modalOrderTitle">
            <i class="fas fa-box-open text-warning mr-2"></i> Order Details
          </h5>
          <span class="text-white-50 small" id="modalOrderSubtitle"></span>
        </div>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body p-4">
        <div id="modalOrderSpinner" class="text-center py-5">
          <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
          <p class="text-muted small">Loading order items and shipment logs...</p>
        </div>

        <div id="modalOrderContent" style="display:none;">
          <!-- Top Status Strip -->
          <div class="row g-2 mb-3">
            <div class="col-6 col-md-3">
              <div class="bg-light p-2.5 rounded border">
                <small class="text-muted d-block">Payment Status</small>
                <strong id="modalPayBadge" class="h6 font-weight-bold"></strong>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="bg-light p-2.5 rounded border">
                <small class="text-muted d-block">Fulfillment</small>
                <strong id="modalFulBadge" class="h6 font-weight-bold"></strong>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="bg-light p-2.5 rounded border">
                <small class="text-muted d-block">Grand Total</small>
                <strong id="modalGrandTotal" class="h6 font-weight-bold text-success"></strong>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="bg-light p-2.5 rounded border">
                <small class="text-muted d-block">Tracking Carrier</small>
                <strong id="modalCarrier" class="h6 font-weight-bold text-dark"></strong>
              </div>
            </div>
          </div>

          <!-- Customer & Shipping Information -->
          <div class="card border mb-3">
            <div class="card-header bg-white py-2 px-3">
              <strong class="small text-dark"><i class="fas fa-shipping-fast text-primary mr-1"></i> Shipping Destination &amp; Recipient</strong>
            </div>
            <div class="card-body p-3">
              <div class="row">
                <div class="col-md-6 mb-2 mb-md-0">
                  <div class="text-muted small">Customer Name:</div>
                  <strong id="modalCustName" class="text-dark"></strong>
                  <div id="modalCustPhone" class="small text-muted"></div>
                </div>
                <div class="col-md-6">
                  <div class="text-muted small">Delivery Address:</div>
                  <div id="modalCustAddress" class="small text-dark font-weight-medium"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Items Table -->
          <h6 class="font-weight-bold text-dark mb-2"><i class="fas fa-list mr-1 text-muted"></i> Purchased Line Items</h6>
          <div class="table-responsive border rounded mb-3">
            <table class="table table-sm table-hover mb-0" style="font-size:0.875rem;">
              <thead class="bg-light text-muted small">
                <tr>
                  <th>Product Item</th>
                  <th class="text-center">Qty</th>
                  <th class="text-right">Unit Price</th>
                  <th class="text-right">Total</th>
                </tr>
              </thead>
              <tbody id="modalItemsTbody">
              </tbody>
            </table>
          </div>

          <!-- Fulfillment Update Form -->
          <form method="post" id="modalStatusForm" action="<?= base_url('admin/orders/update_status/') ?>">
            <?= csrf_field() ?>
            <div class="card border bg-light">
              <div class="card-body p-3">
                <strong class="small text-dark d-block mb-2"><i class="fas fa-cog text-muted mr-1"></i> Update Order &amp; Tracking Status</strong>
                <div class="row g-2">
                  <div class="col-md-4 form-group mb-2">
                    <label class="small text-muted font-weight-bold">Fulfillment Status</label>
                    <select name="fulfillment_status" id="modalSelectFulfillment" class="form-control form-control-sm">
                      <option value="unfulfilled">Unfulfilled</option>
                      <option value="in_transit">In Transit</option>
                      <option value="fulfilled">Fulfilled</option>
                      <option value="delivered">Delivered</option>
                    </select>
                  </div>
                  <div class="col-md-4 form-group mb-2">
                    <label class="small text-muted font-weight-bold">Payment Status</label>
                    <select name="payment_status" id="modalSelectPayment" class="form-control form-control-sm">
                      <option value="unpaid">Unpaid / COD</option>
                      <option value="pending">Pending</option>
                      <option value="paid">Paid</option>
                      <option value="refunded">Refunded</option>
                    </select>
                  </div>
                  <div class="col-md-4 form-group mb-2">
                    <label class="small text-muted font-weight-bold">Tracking Carrier &amp; #</label>
                    <div class="input-group input-group-sm">
                      <input type="text" name="tracking_carrier" id="modalInputCarrier" class="form-control" placeholder="BlueDart / Delhivery">
                      <input type="text" name="tracking_number" id="modalInputTracking" class="form-control" placeholder="AWB #">
                    </div>
                  </div>
                </div>
                <div class="text-right mt-2">
                  <button type="submit" class="btn btn-sm btn-primary px-3 font-weight-bold">
                    <i class="fas fa-save mr-1"></i> Update Shipment Status
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function openOrderModal(orderId) {
  $('#orderDetailModal').modal('show');
  $('#modalOrderSpinner').show();
  $('#modalOrderContent').hide();

  fetch('<?= base_url('admin/orders/detail/') ?>' + orderId, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success || !data.order) {
      alert('Could not load order details.');
      $('#orderDetailModal').modal('hide');
      return;
    }

    var ord = data.order;
    var items = data.items || [];
    
    // Update Title and Subtitle
    document.getElementById('modalOrderTitle').innerHTML = '<i class="fas fa-box-open text-warning mr-2"></i> Order #' + (ord.order_number || ord.id);
    document.getElementById('modalOrderSubtitle').innerText = 'Placed on ' + ord.created_at;

    // Update Statuses
    document.getElementById('modalPayBadge').innerText = (ord.payment_status || 'Unpaid').toUpperCase();
    document.getElementById('modalFulBadge').innerText = (ord.fulfillment_status || 'Unfulfilled').toUpperCase();
    document.getElementById('modalGrandTotal').innerText = '₹' + parseFloat(ord.total || ord.total_amount || 0).toLocaleString('en-IN', {minimumFractionDigits:2});
    document.getElementById('modalCarrier').innerText = ord.shipping_carrier || 'Standard Courier';

    // Parse Customer details
    var shipping = {};
    try {
      if (ord.shipping_address_json) shipping = JSON.parse(ord.shipping_address_json);
    } catch(e) {}

    document.getElementById('modalCustName').innerText = shipping.name || ord.customer_name || 'Storefront Client';
    document.getElementById('modalCustPhone').innerText = shipping.phone ? ('📞 ' + shipping.phone) : '';
    document.getElementById('modalCustAddress').innerText = (shipping.address1 || '') + (shipping.address2 ? (', ' + shipping.address2) : '') + (shipping.city ? (', ' + shipping.city) : '') + (shipping.state ? (', ' + shipping.state) : '') + (shipping.postal_code ? (' - ' + shipping.postal_code) : (shipping.pincode ? (' - ' + shipping.pincode) : ''));

    // Render Items
    var tbody = document.getElementById('modalItemsTbody');
    tbody.innerHTML = '';
    if (items.length === 0) {
      tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">General Order Package (1 item)</td></tr>';
    } else {
      items.forEach(function(it) {
        var tr = document.createElement('tr');
        var price = parseFloat(it.unit_price || it.price || 0);
        var qty = parseInt(it.quantity || it.qty || 1);
        var total = parseFloat(it.total_price || (price * qty));
        tr.innerHTML = '<td><strong>' + (it.product_title || it.title || 'Product Item') + '</strong></td><td class="text-center font-weight-bold">' + qty + '</td><td class="text-right">₹' + price.toFixed(2) + '</td><td class="text-right font-weight-bold text-dark">₹' + total.toFixed(2) + '</td>';
        tbody.appendChild(tr);
      });
    }

    // Set Form Action & Select values
    document.getElementById('modalStatusForm').action = '<?= base_url('admin/orders/update_status/') ?>' + ord.id;
    document.getElementById('modalSelectFulfillment').value = ord.fulfillment_status || 'unfulfilled';
    document.getElementById('modalSelectPayment').value = ord.payment_status || 'unpaid';
    document.getElementById('modalInputCarrier').value = ord.shipping_carrier || '';
    document.getElementById('modalInputTracking').value = ord.tracking_number || '';

    $('#modalOrderSpinner').hide();
    $('#modalOrderContent').fadeIn(150);
  })
  .catch(err => {
    alert('Error loading order details.');
    $('#orderDetailModal').modal('hide');
  });
}
</script>
