<div class="card shadow">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>📜 System Activity & Audit Trail</span>
    <span class="small text-white-50"><?= $total ?> logged events</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover usr-table mb-0">
        <thead>
          <tr>
            <th>Timestamp</th>
            <th>Action</th>
            <th>Actor Type</th>
            <th>Entity</th>
            <th>IP Address</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($logs)): ?>
            <tr><td colspan="5" class="text-center py-5 text-muted">No audit logs recorded yet.</td></tr>
          <?php else: ?>
            <?php foreach ($logs as $l): ?>
              <tr>
                <td><?= date('d M Y, H:i:s', strtotime($l['created_at'])) ?></td>
                <td><code class="text-primary font-weight-bold"><?= htmlspecialchars($l['action']) ?></code></td>
                <td><span class="badge badge-secondary"><?= ucfirst($l['actor_type']) ?></span></td>
                <td><?= htmlspecialchars(($l['entity_type'] ?? '') . ' #' . ($l['entity_id'] ?? '')) ?></td>
                <td><code><?= htmlspecialchars($l['ip_address'] ?? '127.0.0.1') ?></code></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
