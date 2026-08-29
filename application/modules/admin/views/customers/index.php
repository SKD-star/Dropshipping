<div class="row mb-4 align-items-center">
  <div class="col-md-6">
    <h3 class="font-weight-bold text-dark mb-1">👥 Registered Users & Customers</h3>
    <p class="text-muted mb-0">Manage customer accounts and assign personalized discounts.</p>
  </div>
  <div class="col-md-6">
    <div class="input-group">
      <input type="text" id="searchInput" class="form-control" placeholder="Search by Email, Username, or Name..." autocomplete="off">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button" onclick="searchTable()">
          🔍 Search
        </button>
      </div>
    </div>
  </div>
</div>

<div class="card shadow">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>👤 Customer Directory</span>
    <span class="small text-white-50">Total: <?= count($customers) ?> customers</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover usr-table mb-0" id="userTable">
        <thead>
          <tr>
            <th style="width: 50px;">ID</th>
            <th>📧 Email</th>
            <th>👤 Name</th>
            <th>📱 Phone</th>
            <th>🗓️ Registered</th>
            <th>🕒 Last Login</th>
            <th style="text-align: right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($customers)): ?>
            <tr><td colspan="7" class="text-center py-5 text-muted">No registered customers found.</td></tr>
          <?php else: ?>
            <?php foreach ($customers as $c): ?>
            <tr>
              <td><strong>#<?= $c['id'] ?></strong></td>
              <td><a href="mailto:<?= htmlspecialchars($c['email']) ?>"><?= htmlspecialchars($c['email']) ?></a></td>
              <td><strong><?= htmlspecialchars(trim(($c['first_name'] ?? '') . ' ' . ($c['last_name'] ?? ''))) ?: 'Valued Customer' ?></strong></td>
              <td><?= htmlspecialchars($c['phone'] ?: '—') ?></td>
              <td><?= date("d M Y", strtotime($c['created_at'])) ?></td>
              <td><?= !empty($c['last_login_at']) ? date("d M Y, H:i", strtotime($c['last_login_at'])) : '—' ?></td>
              <td style="text-align: right;">
                <button class="btn btn-sm btn-outline-primary" onclick="alert('Customer account active.')">
                  View Orders
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
