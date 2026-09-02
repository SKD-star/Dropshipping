<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── Analytics & Reports Premium Responsive UI ── */
.analytics-hero {
  background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
  border-radius: 16px;
  padding: 26px 30px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 24px rgba(49, 46, 129, 0.2);
}
.kpi-card {
  background: #fff;
  border-radius: 14px;
  padding: 18px 16px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 10px rgba(0,0,0,.04);
  transition: all .2s ease;
  position: relative;
  overflow: hidden;
}
.kpi-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 22px rgba(0,0,0,.08);
}
.kpi-card .kpi-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  margin-bottom: 10px;
}
.kpi-card .kpi-val {
  font-size: 1.45rem;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.2;
}
.kpi-card .kpi-lbl {
  font-size: .75rem;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: .05em;
  margin-top: 4px;
}
.chart-box {
  background: #fff;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 12px rgba(0,0,0,.05);
  overflow: hidden;
}
.chart-box .card-header {
  background: #fff;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 20px;
  font-weight: 700;
  color: #1e293b;
}
.period-btn {
  border-radius: 8px;
  padding: 5px 14px;
  font-size: .82rem;
  font-weight: 700;
  border: 1px solid #e2e8f0;
  color: #475569;
  background: #fff;
  transition: all .15s ease;
}
.period-btn:hover, .period-btn.active {
  background: #4f46e5;
  color: #fff;
  border-color: #4f46e5;
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}
@media (max-width: 576px) {
  .analytics-hero { padding: 20px 16px; }
  .analytics-hero h2 { font-size: 1.3rem; }
  .kpi-card .kpi-val { font-size: 1.2rem; }
}
</style>

<div class="container-fluid py-4">

  <!-- Hero Header -->
  <div class="analytics-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.75rem;">⚡</span>
        <h2 class="fw-bold mb-0 text-white">Analytics &amp; Performance Reports</h2>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Real-time sales velocity, order analytics, customer retention &amp; catalog metrics</p>
    </div>
    
    <!-- Controls & Period Filter -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
      <div class="bg-white p-1 rounded-3 shadow-sm d-flex gap-1">
        <?php foreach ([7, 14, 30, 60, 90] as $d): ?>
        <a href="<?= base_url('admin/analytics?period='.$d) ?>" class="period-btn text-decoration-none <?= $period == $d ? 'active' : '' ?>">
          <?= $d ?>D
        </a>
        <?php endforeach; ?>
      </div>
      <button onclick="window.print()" class="btn btn-outline-light btn-sm font-weight-bold px-3" style="border-radius:8px;">
        <i class="fa fa-print mr-1"></i> Print / PDF
      </button>
    </div>
  </div>

  <!-- KPI Matrix -->
  <div class="row g-3 mb-4">
    <!-- Revenue -->
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-card" style="border-left: 4px solid #10b981;">
        <div class="kpi-icon" style="background:#d1fae5; color:#059669;">
          <i class="fa fa-rupee-sign"></i>
        </div>
        <div class="kpi-val">₹<?= number_format($total_revenue, 2) ?></div>
        <div class="kpi-lbl">Total Revenue</div>
      </div>
    </div>

    <!-- Orders -->
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-card" style="border-left: 4px solid #4f46e5;">
        <div class="kpi-icon" style="background:#e0e7ff; color:#4f46e5;">
          <i class="fa fa-shopping-bag"></i>
        </div>
        <div class="kpi-val"><?= number_format($orders_count) ?></div>
        <div class="kpi-lbl">Total Orders</div>
      </div>
    </div>

    <!-- AOV -->
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-card" style="border-left: 4px solid #0891b2;">
        <div class="kpi-icon" style="background:#cffafe; color:#0891b2;">
          <i class="fa fa-chart-pie"></i>
        </div>
        <div class="kpi-val">₹<?= number_format($aov, 2) ?></div>
        <div class="kpi-lbl">Average Order (AOV)</div>
      </div>
    </div>

    <!-- Paid Conversion -->
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-card" style="border-left: 4px solid #f59e0b;">
        <div class="kpi-icon" style="background:#fef3c7; color:#d97706;">
          <i class="fa fa-check-double"></i>
        </div>
        <div class="kpi-val"><?= $orders_count > 0 ? round(($paid_orders_count / $orders_count) * 100, 1) : 100 ?>%</div>
        <div class="kpi-lbl">Paid Ratio (<?= $paid_orders_count ?> paid)</div>
      </div>
    </div>

    <!-- New Customers -->
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-card" style="border-left: 4px solid #8b5cf6;">
        <div class="kpi-icon" style="background:#ede9fe; color:#7c3aed;">
          <i class="fa fa-user-plus"></i>
        </div>
        <div class="kpi-val"><?= number_format($new_customers) ?></div>
        <div class="kpi-lbl">New Customers</div>
      </div>
    </div>

    <!-- Loyalty Points -->
    <div class="col-6 col-md-4 col-xl-2">
      <div class="kpi-card" style="border-left: 4px solid #ec4899;">
        <div class="kpi-icon" style="background:#fce7f3; color:#db2777;">
          <i class="fa fa-coins"></i>
        </div>
        <div class="kpi-val"><?= number_format($loyalty_stats['awarded'] ?? 0) ?></div>
        <div class="kpi-lbl">Loyalty Awarded</div>
      </div>
    </div>
  </div>

  <!-- Charts & Visual Breakdown Row -->
  <div class="row g-4 mb-4">
    <!-- Main Daily Revenue Chart -->
    <div class="col-lg-8">
      <div class="chart-box h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="fa fa-chart-line text-primary mr-2"></i>Daily Sales Trajectory</span>
          <span class="badge badge-primary badge-pill font-mono"><?= $period ?> Days Timeline</span>
        </div>
        <div class="card-body p-3">
          <div style="position: relative; height: 280px; width: 100%;">
            <canvas id="revenueChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- By Collection Breakdown -->
    <div class="col-lg-4">
      <div class="chart-box h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="fa fa-layer-group text-success mr-2"></i>Category &amp; Collections</span>
          <span class="badge badge-success badge-pill"><?= count($collection_revenue) ?> Active</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:.88rem;">
              <thead class="bg-light">
                <tr>
                  <th class="px-3">Collection</th>
                  <th class="text-right">Catalog Val</th>
                  <th class="text-right pr-3">Items</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($collection_revenue)): ?>
                <tr><td colspan="3" class="text-center text-muted py-4">No collection metrics available.</td></tr>
                <?php else: foreach ($collection_revenue as $cr): ?>
                <tr>
                  <td class="px-3 fw-bold text-dark">
                    <span class="d-inline-block rounded-circle mr-1" style="width:8px;height:8px;background:#4f46e5;"></span>
                    <?= htmlspecialchars($cr['name'] ?? 'General') ?>
                  </td>
                  <td class="text-right font-weight-bold text-success">₹<?= number_format($cr['revenue'] ?? 0, 2) ?></td>
                  <td class="text-right pr-3"><span class="badge badge-light border font-mono"><?= (int)($cr['product_count'] ?? 0) ?></span></td>
                </tr>
                <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Top Products & Price Activity -->
  <div class="row g-4">
    <!-- Top Products Leaderboard -->
    <div class="col-lg-7">
      <div class="chart-box">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="fa fa-trophy text-warning mr-2"></i>Top High-Demand Catalog Items</span>
          <a href="<?= base_url('admin/products') ?>" class="small text-decoration-none">View All Products &rarr;</a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="px-3">#</th>
                  <th>Product Title</th>
                  <th class="text-right">Unit Price / Sales</th>
                  <th class="text-right pr-3">Units Sold</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($top_products)): ?>
                <tr><td colspan="4" class="text-center text-muted py-5">No catalog sales data yet.</td></tr>
                <?php else: foreach ($top_products as $idx => $tp): ?>
                <tr>
                  <td class="px-3 text-muted font-mono" style="width:40px;"><?= $idx + 1 ?></td>
                  <td class="fw-bold text-dark"><?= htmlspecialchars($tp['title'] ?? 'Product #'.$tp['product_id']) ?></td>
                  <td class="text-right font-weight-bold text-primary">₹<?= number_format((float)($tp['revenue'] ?? 0), 2) ?></td>
                  <td class="text-right pr-3">
                    <span class="badge badge-info font-mono"><?= number_format((int)($tp['units_sold'] ?? 0)) ?> sold</span>
                  </td>
                </tr>
                <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- AI Pricing Audit & Log -->
    <div class="col-lg-5">
      <div class="chart-box">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span><i class="fa fa-history text-secondary mr-2"></i>Pricing &amp; Repricing Activity</span>
          <a href="<?= base_url('admin/ai_engine/repricer') ?>" class="badge badge-warning text-dark"><i class="fa fa-bolt mr-1"></i>Repricer</a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" style="font-size:.82rem;">
              <thead class="bg-light">
                <tr>
                  <th class="px-3">Action</th>
                  <th>Entity</th>
                  <th class="text-right pr-3">Date</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($pricing_changes)): ?>
                <tr><td colspan="3" class="text-center text-muted py-4">No recent pricing adjustments logged.</td></tr>
                <?php else: foreach (array_slice($pricing_changes, 0, 8) as $pc): ?>
                <tr>
                  <td class="px-3"><code><?= htmlspecialchars($pc['action'] ?? 'price_adjusted') ?></code></td>
                  <td><?= htmlspecialchars($pc['table_name'] ?? 'products') ?> #<?= $pc['record_id'] ?? 0 ?></td>
                  <td class="text-right pr-3 text-muted"><?= !empty($pc['created_at']) ? date('d M, H:i', strtotime($pc['created_at'])) : '—' ?></td>
                </tr>
                <?php endforeach; endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Chart.js Engine -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
(function(){
  var ctx = document.getElementById('revenueChart');
  if (!ctx) return;

  var dailyData = <?= json_encode($daily_revenue) ?>;
  var labels = [];
  var revenues = [];
  var orders = [];

  if (dailyData && dailyData.length > 0) {
    dailyData.forEach(function(item){
      labels.push(item.day || 'Day');
      revenues.push(parseFloat(item.revenue || 0));
      orders.push(parseInt(item.orders || 0));
    });
  } else {
    // Generate placeholder timeline if empty
    labels = ['Wk 1', 'Wk 2', 'Wk 3', 'Today'];
    revenues = [0, 0, 0, 0];
    orders = [0, 0, 0, 0];
  }

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Revenue (₹)',
          data: revenues,
          borderColor: '#4f46e5',
          backgroundColor: 'rgba(79, 70, 229, 0.12)',
          fill: true,
          tension: 0.35,
          pointRadius: 4,
          pointBackgroundColor: '#4f46e5',
          borderWidth: 2.5
        },
        {
          label: 'Orders Count',
          data: orders,
          borderColor: '#10b981',
          backgroundColor: 'transparent',
          borderDash: [4, 4],
          tension: 0.3,
          pointRadius: 3,
          borderWidth: 2,
          yAxisID: 'yOrders'
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
          labels: { font: { family: 'inherit', size: 12 } }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              if (context.datasetIndex === 0) {
                return ' Revenue: ₹' + Number(context.raw).toLocaleString('en-IN', {minimumFractionDigits: 2});
              }
              return ' Orders: ' + context.raw;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: '#f1f5f9' },
          ticks: {
            callback: function(val) { return '₹' + val; }
          }
        },
        yOrders: {
          beginAtZero: true,
          position: 'right',
          grid: { drawOnChartArea: false },
          ticks: { stepSize: 1 }
        },
        x: {
          grid: { display: false }
        }
      }
    }
  });
})();
</script>
