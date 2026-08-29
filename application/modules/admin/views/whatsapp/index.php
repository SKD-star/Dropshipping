<div class="row">
  <!-- Tickets Table -->
  <div class="col-lg-7 mb-4">
    <div class="card shadow h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>🎧 Support Inquiries & Tickets</span>
        <span class="small text-white-50"><?= count($tickets) ?> pending</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-hover usr-table mb-0">
            <thead>
              <tr>
                <th>Ticket</th>
                <th>Customer</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($tickets)): ?>
                <tr><td colspan="5" class="text-center py-5 text-muted">No open customer support tickets.</td></tr>
              <?php else: ?>
                <?php foreach ($tickets as $t): ?>
                  <tr>
                    <td><code><?= htmlspecialchars($t['tid'] ?? ('#'.$t['id'])) ?></code></td>
                    <td>
                      <strong><?= htmlspecialchars($t['name']) ?></strong>
                      <div class="small text-muted"><?= htmlspecialchars($t['email']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($t['subject']) ?></td>
                    <td><span class="badge badge-warning"><?= htmlspecialchars($t['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- WhatsApp Broadcast Panel -->
  <div class="col-lg-5 mb-4">
    <div class="card shadow h-100">
      <div class="card-header">
        <span>📲 WhatsApp & CRM Broadcast</span>
      </div>
      <div class="card-body p-4">
        <div class="form-group mb-3">
          <label class="font-weight-bold">Audience Group:</label>
          <select class="form-control">
            <option>All Registered Customers</option>
            <option>VIP Buyers (Order value > ₹5,000)</option>
            <option>Cart Abandoners (Last 24 hours)</option>
          </select>
        </div>

        <div class="form-group mb-3">
          <label class="font-weight-bold">Broadcast Message:</label>
          <textarea class="form-control" rows="5" placeholder="✦ NovaDrop Special Release: Enjoy complimentary express shipping with promo code NOVA50..."></textarea>
        </div>

        <button type="button" class="btn btn-primary btn-block font-weight-bold" onclick="alert('Broadcast sent successfully!')">
          <i class="fa fa-paper-plane mr-1"></i> Send Campaign Broadcast
        </button>
      </div>
    </div>
  </div>
</div>
