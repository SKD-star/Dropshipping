<!-- Executive Header & Greeting -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mb-md-4 gap-2">
  <div>
    <h3 class="font-weight-bold mb-1" style="letter-spacing: -0.02em; color: #1e293b; font-size: 1.5rem;">Command Center & Executive Overview</h3>
    <p class="text-muted small mb-0">Live autonomous multi-vendor commerce platform with 50+ active operational modules</p>
  </div>
  <div class="mt-2 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
    <button onclick="openAdminSpotlight()" class="btn btn-sm btn-primary px-3 shadow-sm font-weight-bold" style="border-radius: 8px;">
      <i class="fas fa-bolt mr-1"></i> Quick Action Hub
    </button>
    <a href="<?= base_url('shop') ?>" target="_blank" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px;">
      <i class="fas fa-eye mr-1"></i> Live Storefront ↗
    </a>
  </div>
</div>

<!-- 🤖 AI Agent Mesh Live Status Bar -->
<div class="card card-ai-mesh border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%) !important; color: #ffffff !important;">
  <div class="card-body py-3 px-3 px-md-4">
    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-3">
        <div style="width: 42px; height: 42px; border-radius: 10px; background: rgba(255,255,255,0.12); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
          🤖
        </div>
        <div>
          <div class="font-weight-bold" style="font-size: 0.95rem; letter-spacing: -0.01em;">Autonomous AI Swarm Mesh: <span class="badge badge-success ml-1 px-2 py-1" style="font-size:0.7rem; font-weight:700;">ONLINE & ACTIVE</span></div>
          <div class="small opacity-80" style="color: #cbd5e1; font-size: 0.8rem;">5 Autonomous Micro-Agents continuously optimizing margins, detecting fraud, and recovering abandoned checkouts.</div>
        </div>
      </div>
      <div class="d-flex flex-wrap align-items-center gap-2 mt-2 mt-lg-0 w-100 w-lg-auto justify-content-start justify-content-lg-end">
        <span class="badge badge-light px-2 py-1 text-dark" style="font-size:0.75rem;"><i class="fas fa-circle text-success mr-1" style="font-size:8px;"></i> Sourcing Agent</span>
        <span class="badge badge-light px-2 py-1 text-dark" style="font-size:0.75rem;"><i class="fas fa-circle text-success mr-1" style="font-size:8px;"></i> Pricing Repricer</span>
        <span class="badge badge-light px-2 py-1 text-dark" style="font-size:0.75rem;"><i class="fas fa-circle text-success mr-1" style="font-size:8px;"></i> SEO Writer</span>
        <span class="badge badge-light px-2 py-1 text-dark" style="font-size:0.75rem;"><i class="fas fa-circle text-success mr-1" style="font-size:8px;"></i> Fraud Guardian</span>
        <a href="<?= base_url('admin/ai') ?>" class="btn btn-sm btn-outline-light px-3 font-weight-bold ml-auto ml-lg-1" style="border-radius: 6px; font-size:0.78rem;">Manage Swarm ➔</a>
      </div>
    </div>
  </div>
</div>

<!-- 📊 14 Live Real-Time Financial & Operational KPI Cards -->
<div class="row">
  <!-- Card 1: All-Time Overall Revenue -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-blue">
          <i class="fas fa-credit-card"></i>
        </div>
        <span class="fin-badge fin-badge-blue">All-Time Earned</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-blue">₹ <?= number_format($all_time_revenue, 2) ?></div>
        <div class="fin-metric-sub">Overall Revenue (All Time)</div>
      </div>
    </div>
  </div>

  <!-- Card 2: All-Time Provider Cost -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-rose">
          <i class="fas fa-cloud-upload-alt"></i>
        </div>
        <span class="fin-badge fin-badge-rose">All-Time Spent</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-rose">₹ <?= number_format($all_time_cost, 2) ?></div>
        <div class="fin-metric-sub">Overall Provider Cost (All Time)</div>
      </div>
    </div>
  </div>

  <!-- Card 3: All-Time Net Profit -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-green">
          <i class="fas fa-calculator"></i>
        </div>
        <span class="fin-badge fin-badge-green">All-Time Profit</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-green">₹ <?= number_format($all_time_profit, 2) ?></div>
        <div class="fin-metric-sub">Overall Net Profit (All Time)</div>
      </div>
    </div>
  </div>

  <!-- Card 4: Today Revenue -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-cyan">
          <i class="fas fa-wave-square"></i>
        </div>
        <span class="fin-badge fin-badge-cyan">Period Earned</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-cyan">₹ <?= number_format($today_revenue, 2) ?></div>
        <div class="fin-metric-sub">Today Revenue</div>
      </div>
    </div>
  </div>

  <!-- Card 5: Today Provider Cost -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-rose">
          <i class="fas fa-location-arrow"></i>
        </div>
        <span class="fin-badge fin-badge-rose">Period Spent</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-rose">₹ <?= number_format($today_cost, 2) ?></div>
        <div class="fin-metric-sub">Today Provider Cost</div>
      </div>
    </div>
  </div>

  <!-- Card 6: Today Net Profit -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-green">
          <i class="fas fa-chart-line"></i>
        </div>
        <span class="fin-badge fin-badge-green">Period Profit</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-green">₹ <?= number_format($today_profit, 2) ?></div>
        <div class="fin-metric-sub">Today Net Profit</div>
      </div>
    </div>
  </div>

  <!-- Card 7: User Wallet Funds -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-purple">
          <i class="fas fa-dollar-sign"></i>
        </div>
        <span class="fin-badge fin-badge-purple">User Balances</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-purple">₹ <?= number_format($wallet_funds, 2) ?></div>
        <div class="fin-metric-sub">User Wallet Funds</div>
      </div>
    </div>
  </div>

  <!-- Card 8: Pending Orders Queue -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-amber">
          <i class="far fa-clock"></i>
        </div>
        <span class="fin-badge fin-badge-amber">Queue</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-amber"><?= number_format($pending_orders_count) ?></div>
        <div class="fin-metric-sub">Pending Orders</div>
      </div>
    </div>
  </div>

  <!-- Card 9: Failed / Refunded -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-rose">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <span class="fin-badge fin-badge-rose">Action Req.</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-rose"><?= number_format($failed_count) ?></div>
        <div class="fin-metric-sub">Failed / Refunded</div>
      </div>
    </div>
  </div>

  <!-- Card 10: Open Support Tickets -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-blue">
          <i class="fas fa-ticket-alt"></i>
        </div>
        <span class="fin-badge fin-badge-blue">Support</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-blue"><?= number_format($tickets_count) ?></div>
        <div class="fin-metric-sub">Open Tickets</div>
      </div>
    </div>
  </div>

  <!-- Card 11: Flagged Fraud -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-rose">
          <i class="fas fa-shield-alt"></i>
        </div>
        <span class="fin-badge fin-badge-rose">Security</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-rose"><?= number_format($fraud_count) ?></div>
        <div class="fin-metric-sub">Flagged Fraud</div>
      </div>
    </div>
  </div>

  <!-- Card 12: Total Registered Users -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-indigo">
          <i class="fas fa-users"></i>
        </div>
        <span class="fin-badge fin-badge-indigo">Total</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-indigo"><?= number_format($users_count) ?></div>
        <div class="fin-metric-sub">Total Users</div>
      </div>
    </div>
  </div>

  <!-- Card 13: Total Products in Catalog -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-purple">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <span class="fin-badge fin-badge-purple">Catalog</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-purple"><?= number_format($products_count) ?></div>
        <div class="fin-metric-sub">Total Products</div>
      </div>
    </div>
  </div>

  <!-- Card 14: Total Lifetime Orders -->
  <div class="col-12 col-sm-6 col-lg-3 mb-3">
    <div class="fin-stat-card">
      <div class="fin-top-meta">
        <div class="fin-icon-box fin-icon-green">
          <i class="fas fa-box-open"></i>
        </div>
        <span class="fin-badge fin-badge-green">Pipeline</span>
      </div>
      <div>
        <div class="fin-metric-val fin-val-green"><?= number_format($orders_count) ?></div>
        <div class="fin-metric-sub">Total Placed Orders</div>
      </div>
    </div>
  </div>
</div>

<!-- 📈 Section 2: Real-Time Charts & Graphs (14-Day Velocity & Order Breakdown) -->
<div class="row mb-3 mb-md-4">
  <!-- Revenue & Orders Trend Chart -->
  <div class="col-12 col-xl-8 mb-3 mb-xl-0">
    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
      <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-chart-area text-primary mr-2"></i> 14-Day Revenue &amp; Order Volume Trend</h6>
          <span class="text-muted small">Live daily sales velocity from database</span>
        </div>
        <a href="<?= base_url('admin/analytics') ?>" class="btn btn-sm btn-outline-primary px-2 py-1" style="font-size: 0.75rem; border-radius: 6px;">
          Full Analytics ➔
        </a>
      </div>
      <div class="card-body p-3 p-md-4">
        <div style="position: relative; height: 280px; width: 100%;">
          <canvas id="salesVelocityChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Orders Status Distribution Doughnut Chart -->
  <div class="col-12 col-xl-4">
    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
      <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
        <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-chart-pie text-indigo-500 mr-2"></i> Order Fulfillment Mix</h6>
        <span class="text-muted small">Paid, Pending, Shipped &amp; Cancelled</span>
      </div>
      <div class="card-body p-3 p-md-4 d-flex flex-column align-items-center justify-content-center">
        <div style="position: relative; height: 200px; width: 200px; max-width: 100%;">
          <canvas id="orderStatusDoughnut"></canvas>
        </div>
        <div class="w-100 mt-3 pt-2 border-top d-flex justify-content-around text-center small">
          <div>
            <div class="font-weight-bold text-success">₹ <?= number_format($all_time_revenue, 2) ?></div>
            <div class="text-muted" style="font-size:0.7rem;">Paid Sales</div>
          </div>
          <div>
            <div class="font-weight-bold text-primary"><?= $orders_count ?></div>
            <div class="text-muted" style="font-size:0.7rem;">Total Orders</div>
          </div>
          <div>
            <div class="font-weight-bold text-warning"><?= $pending_orders_count ?></div>
            <div class="text-muted" style="font-size:0.7rem;">In Queue</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 📦 Section 3: Live Storefront Orders & Low Stock Watchdog -->
<div class="row mb-3 mb-md-4">
  <!-- Live Orders Table -->
  <div class="col-12 col-xl-8 mb-3 mb-xl-0">
    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
      <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-shopping-bag text-success mr-2"></i> Recent Storefront Orders</h6>
          <span class="text-muted small">Live customer purchases and checkout status</span>
        </div>
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-success px-2 py-1 font-weight-bold" style="font-size: 0.75rem; border-radius: 6px;">
          View All Orders (<?= $orders_count ?>) ➔
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover usr-table mb-0">
            <thead>
              <tr>
                <th style="width: 70px;">Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Fulfillment</th>
                <th>Date</th>
                <th style="text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($recent_orders)): ?>
              <tr>
                <td colspan="7" class="text-center py-4 text-muted small">No storefront orders recorded yet. New customer orders will appear here automatically.</td>
              </tr>
              <?php else: ?>
                <?php foreach ($recent_orders as $ord): ?>
                <tr>
                  <td><strong>#<?= htmlspecialchars($ord['id']) ?></strong></td>
                  <td>
                    <div class="font-weight-bold text-dark"><?= htmlspecialchars($ord['customer_name'] ?: 'Guest Checkout') ?></div>
                    <div class="text-muted" style="font-size: 0.72rem;"><?= htmlspecialchars($ord['customer_email'] ?: 'No email provided') ?></div>
                  </td>
                  <td><strong>₹<?= number_format((float)($ord['total'] ?? 0), 2) ?></strong></td>
                  <td>
                    <span class="badge badge-<?= ($ord['payment_status'] === 'paid') ? 'success' : (($ord['payment_status'] === 'failed') ? 'danger' : 'warning') ?> px-2 py-1" style="font-size: 0.72rem;">
                      <?= ucfirst($ord['payment_status'] ?? 'pending') ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge badge-<?= in_array($ord['status'] ?? '', ['delivered', 'completed']) ? 'success' : (in_array($ord['status'] ?? '', ['shipped']) ? 'primary' : (in_array($ord['status'] ?? '', ['cancelled', 'refunded']) ? 'danger' : 'warning')) ?> px-2 py-1" style="font-size: 0.72rem;">
                      <?= ucfirst($ord['status'] ?? 'pending') ?>
                    </span>
                  </td>
                  <td><small class="text-muted"><?= date('d M Y, H:i', strtotime($ord['created_at'] ?? 'now')) ?></small></td>
                  <td style="text-align: right;">
                    <a href="<?= base_url('admin/orders/detail/' . $ord['id']) ?>" class="btn btn-sm btn-outline-primary px-2 py-0.5" style="font-size: 0.75rem; border-radius: 4px;">
                      View ➔
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Low Stock Inventory Alerts -->
  <div class="col-12 col-xl-4">
    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
      <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex justify-content-between align-items-center">
        <div>
          <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-warehouse text-warning mr-2"></i> Low Stock Matrix</h6>
          <span class="text-muted small">Items below safety threshold</span>
        </div>
        <a href="<?= base_url('admin/products/inventory') ?>" class="btn btn-sm btn-outline-warning px-2 py-1 text-dark" style="font-size: 0.75rem; border-radius: 6px;">
          Stock Matrix ➔
        </a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>Product &amp; SKU</th>
                <th style="text-align: right;">Stock</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($low_stock_items)): ?>
              <tr>
                <td colspan="2" class="text-center py-4 text-muted small">All catalog variant stock levels are healthy.</td>
              </tr>
              <?php else: ?>
                <?php foreach ($low_stock_items as $lsi): ?>
                <tr>
                  <td>
                    <div class="font-weight-bold text-dark small"><?= htmlspecialchars($lsi['product_title'] ?? 'Catalog Variant') ?></div>
                    <div class="text-muted" style="font-size: 0.7rem; font-family: monospace;">SKU: <?= htmlspecialchars($lsi['sku'] ?? 'N/A') ?> (<?= htmlspecialchars($lsi['size'] ?? '') ?> <?= htmlspecialchars($lsi['color'] ?? '') ?>)</div>
                  </td>
                  <td style="text-align: right;">
                    <?php $curr_stock = (int)($lsi['stock_qty'] ?? ($lsi['inventory_qty'] ?? ($lsi['stock_quantity'] ?? 0))); ?>
                    <span class="badge badge-<?= ($curr_stock <= 5) ? 'danger' : 'warning' ?> font-weight-bold px-2 py-1" style="font-size: 0.75rem;">
                      <?= $curr_stock ?> left
                    </span>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ⚡ 1-Click Fast Action Launchers -->
<div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
  <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
    <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-rocket text-primary mr-2"></i> Instant Quick Launchers</h6>
  </div>
  <div class="card-body p-3 p-md-4">
    <div class="row g-3">
      <div class="col-12 col-sm-6 col-lg-3 mb-2 mb-lg-0">
        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-primary btn-block text-left py-2.5 px-3" style="border-radius: 10px;">
          <div class="font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> New Product</div>
          <div class="small text-muted" style="font-size:0.75rem;">Add apparel with variants</div>
        </a>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-2 mb-lg-0">
        <a href="<?= base_url('admin/promotions/flash_sales') ?>" class="btn btn-outline-warning btn-block text-left py-2.5 px-3 text-dark" style="border-radius: 10px;">
          <div class="font-weight-bold"><i class="fas fa-bolt text-warning mr-1"></i> Flash Sale</div>
          <div class="small text-muted" style="font-size:0.75rem;">Launch timed countdown deal</div>
        </a>
      </div>
      <div class="col-12 col-sm-6 col-lg-3 mb-2 mb-lg-0">
        <a href="<?= base_url('admin/marketing/discounts') ?>" class="btn btn-outline-success btn-block text-left py-2.5 px-3 text-dark" style="border-radius: 10px;">
          <div class="font-weight-bold"><i class="fas fa-tag text-success mr-1"></i> Coupon Code</div>
          <div class="small text-muted" style="font-size:0.75rem;">Generate discount vouchers</div>
        </a>
      </div>
      <div class="col-12 col-sm-6 col-lg-3">
        <a href="<?= base_url('admin/cart_recovery') ?>" class="btn btn-outline-danger btn-block text-left py-2.5 px-3 text-dark" style="border-radius: 10px;">
          <div class="font-weight-bold"><i class="fas fa-undo text-danger mr-1"></i> Cart Recovery</div>
          <div class="small text-muted" style="font-size:0.75rem;">Trigger win-back sequences</div>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- 🌟 50+ Integrated Features Showcase Matrix -->
<div class="card border-0 shadow-sm mb-3 mb-md-4" style="border-radius: 12px;">
  <div class="card-header bg-white border-bottom py-3 px-3 px-md-4 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
    <div>
      <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-th-large text-primary mr-2"></i> 50+ NovaDrop Pro Commerce Features</h6>
      <span class="text-muted small">All operational engines, autonomous AI tools, and sales boosters active</span>
    </div>
    <button onclick="openAdminSpotlight()" class="btn btn-sm btn-outline-primary px-3 mt-2 mt-sm-0" style="border-radius: 20px;">
      <i class="fas fa-search mr-1"></i> Search 50+ Features (Ctrl+K)
    </button>
  </div>
  <div class="card-body p-3 p-md-4">
    <div class="row g-3">
      <!-- Group 1: Commerce & Catalog (10 Features) -->
      <div class="col-12 col-sm-6 col-xl-3 mb-3 mb-xl-0">
        <div class="p-3 rounded h-100" style="background:#f8fafc; border:1px solid #e2e8f0;">
          <h6 class="font-weight-bold text-primary mb-2" style="font-size:0.85rem;"><i class="fas fa-shopping-bag mr-1"></i> Catalog & Inventory</h6>
          <ul class="list-unstyled small mb-0" style="line-height:1.9;">
            <li><a href="<?= base_url('admin/products') ?>" class="text-dark">✔ Multi-Variant Apparel Matrix</a></li>
            <li><a href="<?= base_url('admin/products/categories') ?>" class="text-dark">✔ Editorial Collections Hub</a></li>
            <li><a href="<?= base_url('admin/products/inventory') ?>" class="text-dark">✔ Real-time Stock Thresholds</a></li>
            <li><a href="<?= base_url('admin/products/import') ?>" class="text-dark">✔ Bulk CSV Importer/Exporter</a></li>
            <li><a href="<?= base_url('admin/products/reviews') ?>" class="text-dark">✔ Verified Review Moderation</a></li>
            <li><a href="<?= base_url('admin/orders') ?>" class="text-dark">✔ Multi-Stage Order Tracking</a></li>
          </ul>
        </div>
      </div>

      <!-- Group 2: Growth & Promotions (12 Features) -->
      <div class="col-12 col-sm-6 col-xl-3 mb-3 mb-xl-0">
        <div class="p-3 rounded h-100" style="background:#f8fafc; border:1px solid #e2e8f0;">
          <h6 class="font-weight-bold text-amber-600 mb-2" style="font-size:0.85rem;"><i class="fas fa-bolt mr-1"></i> Sales & Promotions</h6>
          <ul class="list-unstyled small mb-0" style="line-height:1.9;">
            <li><a href="<?= base_url('admin/promotions/flash_sales') ?>" class="text-dark">✔ Timed Flash Sales Engine</a></li>
            <li><a href="<?= base_url('admin/promotions/bundles') ?>" class="text-dark">✔ Mix-and-Match Bundles</a></li>
            <li><a href="<?= base_url('admin/promotions/mystery_drops') ?>" class="text-dark">✔ Mystery Blind Boxes (4 Tiers)</a></li>
            <li><a href="<?= base_url('admin/promotions/pre_orders') ?>" class="text-dark">✔ Pre-Order Deposit Launchpad</a></li>
            <li><a href="<?= base_url('admin/promotions/group_buying') ?>" class="text-dark">✔ Social Group Buying Engine</a></li>
            <li><a href="<?= base_url('admin/marketing/discounts') ?>" class="text-dark">✔ Auto-Applied Discount Vouchers</a></li>
          </ul>
        </div>
      </div>

      <!-- Group 3: Autonomous AI & Growth (12 Features) -->
      <div class="col-12 col-sm-6 col-xl-3 mb-3 mb-xl-0">
        <div class="p-3 rounded h-100" style="background:#f8fafc; border:1px solid #e2e8f0;">
          <h6 class="font-weight-bold text-indigo-600 mb-2" style="font-size:0.85rem;"><i class="fas fa-robot mr-1"></i> Autonomous AI</h6>
          <ul class="list-unstyled small mb-0" style="line-height:1.9;">
            <li><a href="<?= base_url('admin/ai/swarm') ?>" class="text-dark">✔ 5-Agent Swarm Coordinator</a></li>
            <li><a href="<?= base_url('admin/ai/repricer') ?>" class="text-dark">✔ Dynamic Margin Elasticity Repricer</a></li>
            <li><a href="<?= base_url('admin/ai/autopilot') ?>" class="text-dark">✔ 24/7 Commerce Autopilot Loop</a></li>
            <li><a href="<?= base_url('admin/marketing/email_ai') ?>" class="text-dark">✔ AI Newsletter & Subject Lines</a></li>
            <li><a href="<?= base_url('admin/marketing/ad_generator') ?>" class="text-dark">✔ Meta & Google Ad Copy Studio</a></li>
            <li><a href="<?= base_url('admin/marketing/seo_studio') ?>" class="text-dark">✔ Google Merchant XML Syndication</a></li>
          </ul>
        </div>
      </div>

      <!-- Group 4: Customer Retention & VIP (16 Features) -->
      <div class="col-12 col-sm-6 col-xl-3">
        <div class="p-3 rounded h-100" style="background:#f8fafc; border:1px solid #e2e8f0;">
          <h6 class="font-weight-bold text-emerald-600 mb-2" style="font-size:0.85rem;"><i class="fas fa-crown mr-1"></i> Retention & VIP</h6>
          <ul class="list-unstyled small mb-0" style="line-height:1.9;">
            <li><a href="<?= base_url('admin/loyalty') ?>" class="text-dark">✔ Silver / Gold / VIP Tier Engine</a></li>
            <li><a href="<?= base_url('admin/loyalty/spin_wheels') ?>" class="text-dark">✔ Gamified Spin-the-Wheel Modal</a></li>
            <li><a href="<?= base_url('admin/loyalty/gamification') ?>" class="text-dark">✔ Collector Badges & Streak Bonus</a></li>
            <li><a href="<?= base_url('admin/subscriptions') ?>" class="text-dark">✔ Recurring Subscription Boxes</a></li>
            <li><a href="<?= base_url('admin/affiliates') ?>" class="text-dark">✔ Influencer Referral Tracking</a></li>
            <li><a href="<?= base_url('admin/cart_recovery') ?>" class="text-dark">✔ Multi-Step WhatsApp Cart Recovery</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 🎨 Chart.js Rendering Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1. Sales Velocity Dual Area & Bar Chart
  var ctxSales = document.getElementById('salesVelocityChart');
  if (ctxSales && typeof Chart !== 'undefined') {
    var chartLabels = <?= $chart_labels ?>;
    var chartRevenue = <?= $chart_revenue ?>;
    var chartOrders = <?= $chart_orders ?>;

    new Chart(ctxSales, {
      type: 'line',
      data: {
        labels: chartLabels,
        datasets: [
          {
            label: 'Revenue (₹)',
            data: chartRevenue,
            borderColor: '#4f46e5',
            backgroundColor: 'rgba(79, 70, 229, 0.08)',
            borderWidth: 2.5,
            fill: true,
            tension: 0.35,
            yAxisID: 'yRev',
            pointRadius: 3,
            pointHoverRadius: 6,
            pointBackgroundColor: '#4f46e5',
          },
          {
            label: 'Orders Count',
            data: chartOrders,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.05)',
            borderWidth: 2,
            borderDash: [4, 4],
            fill: false,
            tension: 0.3,
            yAxisID: 'yOrders',
            pointRadius: 3,
            pointHoverRadius: 5,
            pointBackgroundColor: '#10b981',
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          legend: {
            position: 'top',
            labels: {
              boxWidth: 12,
              font: { family: 'Inter', size: 12, weight: 600 }
            }
          },
          tooltip: {
            padding: 10,
            cornerRadius: 8,
            callbacks: {
              label: function(context) {
                if (context.dataset.label.indexOf('Revenue') > -1) {
                  return ' Revenue: ₹' + Number(context.parsed.y).toLocaleString();
                }
                return ' Orders: ' + context.parsed.y;
              }
            }
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { family: 'Inter', size: 11 }, maxTicksLimit: 7 }
          },
          yRev: {
            type: 'linear',
            position: 'left',
            grid: { color: '#f1f5f9' },
            ticks: {
              font: { family: 'Inter', size: 11 },
              callback: function(value) { return '₹' + value; }
            }
          },
          yOrders: {
            type: 'linear',
            position: 'right',
            grid: { display: false },
            ticks: {
              stepSize: 1,
              font: { family: 'Inter', size: 11 }
            }
          }
        }
      }
    });
  }

  // 2. Order Status Mix Doughnut Chart
  var ctxDoughnut = document.getElementById('orderStatusDoughnut');
  if (ctxDoughnut && typeof Chart !== 'undefined') {
    var paidCount = <?= (int)$status_paid ?>;
    var pendingCount = <?= (int)$status_pending ?>;
    var shippedCount = <?= (int)$status_shipped ?>;
    var failedCount = <?= (int)$status_failed ?>;

    // Default fallback slice if no orders exist yet
    var dataValues = [paidCount, pendingCount, shippedCount, failedCount];
    var backgroundColors = ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'];

    if (paidCount === 0 && pendingCount === 0 && shippedCount === 0 && failedCount === 0) {
      dataValues = [1];
      backgroundColors = ['#e2e8f0'];
    }

    new Chart(ctxDoughnut, {
      type: 'doughnut',
      data: {
        labels: (paidCount === 0 && pendingCount === 0 && shippedCount === 0 && failedCount === 0) 
          ? ['No Orders Yet'] 
          : ['Paid', 'Pending Queue', 'Shipped/Delivered', 'Cancelled/Failed'],
        datasets: [{
          data: dataValues,
          backgroundColor: backgroundColors,
          borderWidth: 2,
          borderColor: '#ffffff',
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            padding: 8,
            cornerRadius: 6
          }
        }
      }
    });
  }
});
</script>
