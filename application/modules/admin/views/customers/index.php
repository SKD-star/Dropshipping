<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Top Navigation Bar -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-users text-primary mr-2"></i>Registered Users &amp; Customers
      </h3>
      <p class="text-muted small mb-0">Manage customer accounts, view lifetime orders, reward points, and VIP loyalty tiers</p>
    </div>
    <div class="d-flex gap-2">
      <a href="<?= base_url('admin/loyalty') ?>" class="btn btn-warning text-dark btn-sm font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-crown mr-1"></i> VIP Loyalty Hub
      </a>
      <a href="<?= base_url('admin/loyalty/badges') ?>" class="btn btn-outline-primary btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-medal mr-1"></i> Badges &amp; Streaks
      </a>
    </div>
  </div>

  <!-- Search & Filter Card -->
  <div class="card border-0 shadow-sm p-3 mb-3 bg-white" style="border-radius:12px;">
    <form method="get" class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
      <div class="input-group input-group-sm w-100" style="max-width:420px;">
        <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" class="form-control font-weight-bold" placeholder="Search by email, name, phone...">
        <div class="input-group-append">
          <button class="btn btn-primary px-3"><i class="fa fa-search mr-1"></i> Search</button>
        </div>
      </div>
      <div class="text-muted small font-weight-bold">
        <span>Total Customers: </span><span class="badge badge-light border text-dark font-weight-bold"><?= count($customers) ?></span>
      </div>
    </form>
  </div>

  <!-- Customers Table Card -->
  <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="userTable">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3" style="width: 50px;">ID</th>
              <th class="py-3">Customer Account</th>
              <th class="py-3">Phone Number</th>
              <th class="py-3">Loyalty Points</th>
              <th class="py-3">VIP Tier</th>
              <th class="py-3">Registered Date</th>
              <th class="py-3">Last Active</th>
              <th class="py-3 text-right px-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($customers)): ?>
              <tr><td colspan="8" class="text-center py-5 text-muted"><i class="fas fa-user-slash fa-2x mb-2 d-block opacity-50"></i>No registered customers found.</td></tr>
            <?php else: ?>
              <?php foreach ($customers as $c): 
                $full_name = trim(($c['first_name'] ?? '') . ' ' . ($c['last_name'] ?? ''));
                $full_name = $full_name ?: 'Valued Customer';
                $tier = $c['loyalty_tier'] ?? 'Silver';
                $pts = (int)($c['loyalty_points'] ?? 0);
              ?>
              <tr>
                <td class="px-3 font-weight-bold text-muted">#<?= $c['id'] ?></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mr-2.5 text-primary font-weight-bold" style="width:36px; height:36px; flex-shrink:0;">
                      <?= strtoupper(substr($full_name, 0, 1)) ?>
                    </div>
                    <div>
                      <div class="font-weight-bold text-dark"><?= htmlspecialchars($full_name) ?></div>
                      <a href="mailto:<?= htmlspecialchars($c['email']) ?>" class="text-muted small text-decoration-none" style="font-size:0.75rem;">
                        <?= htmlspecialchars($c['email']) ?>
                      </a>
                    </div>
                  </div>
                </td>
                <td><small class="font-mono text-dark"><?= htmlspecialchars($c['phone'] ?: '—') ?></small></td>
                <td>
                  <span class="badge badge-success px-2.5 py-1 font-weight-bold font-mono">
                    <?= number_format($pts) ?> pts
                  </span>
                </td>
                <td>
                  <span class="badge badge-light border text-dark font-weight-bold">
                    <?= htmlspecialchars($tier) ?>
                  </span>
                </td>
                <td><small class="text-muted"><?= date("d M Y", strtotime($c['created_at'])) ?></small></td>
                <td><small class="text-muted"><?= !empty($c['last_login_at']) ? date("d M Y, H:i", strtotime($c['last_login_at'])) : '—' ?></small></td>
                <td class="text-right px-3">
                  <div class="btn-group btn-group-sm">
                    <a href="<?= base_url('admin/orders?customer_id='.$c['id'].'&q='.urlencode($c['email'])) ?>" class="btn btn-outline-primary font-weight-bold px-2.5 py-1" style="border-radius:6px;" title="View Customer Orders">
                      <i class="fas fa-shopping-bag mr-1"></i> Orders
                    </a>
                    <button type="button" class="btn btn-outline-warning text-dark font-weight-bold px-2.5 py-1" style="border-radius:6px;" data-toggle="modal" data-target="#custPointsModal<?= $c['id'] ?>" title="Adjust Loyalty Points">
                      <i class="fas fa-coins mr-1"></i> Points
                    </button>
                  </div>

                  <!-- Quick Points Adjustment Modal -->
                  <div class="modal fade" id="custPointsModal<?= $c['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                      <div class="modal-content border-0 shadow-lg" style="border-radius:12px;">
                        <div class="modal-header bg-dark text-white py-2 px-3">
                          <h6 class="modal-title font-weight-bold mb-0">Award Points: <?= htmlspecialchars($full_name) ?></h6>
                          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <form method="post" action="<?= base_url('admin/loyalty') ?>">
                          <?= csrf_field() ?>
                          <input type="hidden" name="customer_id" value="<?= $c['id'] ?>">
                          <div class="modal-body p-3 text-left">
                            <div class="mb-2">
                              <span class="text-muted small">Current Balance:</span>
                              <div class="font-weight-bold text-success" style="font-size:1.1rem;"><?= number_format($pts) ?> pts</div>
                            </div>
                            <div class="form-group mb-2">
                              <label class="small font-weight-bold">Points Amount</label>
                              <input type="number" name="points" class="form-control form-control-sm font-weight-bold" value="100" min="1" required>
                            </div>
                            <div class="form-group mb-0">
                              <label class="small font-weight-bold">Reason / Note</label>
                              <input type="text" name="reason" class="form-control form-control-sm" value="VIP Loyalty Credit" required>
                            </div>
                          </div>
                          <div class="modal-footer py-2 px-3">
                            <button type="submit" name="loyalty_action" value="award_points" class="btn btn-success btn-sm font-weight-bold px-3">Credit Points</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
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
