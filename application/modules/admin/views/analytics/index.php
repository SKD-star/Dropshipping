<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-1" style="color:#4e73df;">⚡ Analytics &amp; Reports</h2>
  <p class="text-muted mb-3">Revenue insights across the last <strong><?= $period ?> days</strong></p>

  <!-- Period Selector -->
  <div class="mb-3">
    <?php foreach ([7,14,30,60,90] as $d): ?>
    <a href="<?= base_url('admin/analytics?period='.$d) ?>" class="btn btn-sm <?= $period==$d ? 'btn-primary' : 'btn-outline-secondary' ?> mr-1"><?= $d ?>d</a>
    <?php endforeach; ?>
  </div>

  <!-- KPI Row -->
  <div class="row g-3 mb-4">
    <?php $kpis = [
      ['Revenue','₹'.number_format($total_revenue,2),'fa-rupee-sign','#1cc88a'],
      ['Orders',number_format($orders_count),'fa-shopping-cart','#4e73df'],
      ['AOV','₹'.number_format($aov,2),'fa-chart-pie','#36b9cc'],
      ['Cancelled/Refunded',number_format($failed_count),'fa-times-circle','#e74a3b'],
      ['New Customers',number_format($new_customers),'fa-user-plus','#f6c23e'],
      ['Returning',number_format($returning_customers),'fa-redo','#9333ea'],
    ]; foreach ($kpis as $k): ?>
    <div class="col-6 col-md-4 col-xl-2">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid <?= $k[3] ?>;">
        <i class="fa <?= $k[2] ?> fa-2x mb-2" style="color:<?= $k[3] ?>;"></i>
        <div style="font-size:1.3rem;font-weight:800;"><?= $k[1] ?></div>
        <div style="font-size:.72rem;color:#888;text-transform:uppercase;letter-spacing:.05em;"><?= $k[0] ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><i class="fa fa-chart-bar mr-2 text-primary"></i>Daily Revenue</div>
        <div class="card-body"><canvas id="revenueChart" height="100"></canvas></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><i class="fa fa-tags mr-2 text-success"></i>By Collection</div>
        <div class="card-body p-0">
          <table class="table table-sm mb-0">
            <thead><tr><th>Collection</th><th>Revenue</th><th>Orders</th></tr></thead>
            <tbody>
            <?php foreach ($collection_revenue as $cr): ?>
            <tr><td><?= htmlspecialchars($cr['name'] ?? 'N/A') ?></td><td>&#8377;<?= number_format($cr['revenue'],0) ?></td><td><?= $cr['orders'] ?></td></tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold"><i class="fa fa-trophy mr-2 text-warning"></i>Top Products</div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>#</th><th>Product</th><th>Revenue</th><th>Units Sold</th></tr></thead>
        <tbody>
        <?php foreach ($top_products as $i => $tp): ?>
        <tr>
          <td><?= $i+1 ?></td>
          <td><?= htmlspecialchars($tp['title'] ?? 'Unknown') ?></td>
          <td>&#8377;<?= number_format($tp['revenue'] ?? 0, 2) ?></td>
          <td><?= number_format($tp['units_sold'] ?? $tp['orders_count'] ?? 0) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($top_products)): ?><tr><td colspan="4" class="text-center text-muted py-4">No data yet</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
(function(){
  var ctx = document.getElementById('revenueChart');
  if (!ctx) return;
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($daily_revenue, 'day')) ?>,
      datasets: [{
        label: 'Revenue',
        data: <?= json_encode(array_column($daily_revenue, 'revenue')) ?>,
        backgroundColor: 'rgba(78,115,223,0.7)',
        borderColor: '#4e73df',
        borderWidth: 1,
        borderRadius: 4
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  });
})();
</script>
