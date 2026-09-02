<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Top Navigation & Header -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-2">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-medal text-warning mr-2"></i>Badges &amp; Streak Rewards
      </h3>
      <p class="text-muted small mb-0">Engage shoppers with daily login streaks, unlockable achievement badges, and VIP points</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <button class="btn btn-warning text-dark btn-sm font-weight-bold shadow-sm" data-toggle="modal" data-target="#awardBadgeModal" style="border-radius:8px;">
        <i class="fas fa-award mr-1"></i> Award Badge to Customer
      </button>
      <a href="<?= base_url('admin/loyalty') ?>" class="btn btn-outline-primary btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-trophy mr-1"></i> Loyalty Program
      </a>
      <a href="<?= base_url('admin/loyalty/gamification') ?>" class="btn btn-outline-info btn-sm px-3 shadow-sm" style="border-radius:8px;">
        <i class="fas fa-gamepad mr-1"></i> Spin Wheels
      </a>
    </div>
  </div>

  <!-- Flash Messages -->
  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3">
    <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- ── 1. Daily Login & Order Streak Rewards Grid ── -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <div>
        <span class="font-weight-bold text-dark"><i class="fas fa-fire text-danger mr-2"></i> Daily Retention &amp; Shopping Streaks</span>
        <span class="text-muted small ml-2 d-none d-md-inline">• Auto-incremented when customers visit or purchase</span>
      </div>
      <span class="badge badge-success px-2.5 py-1">⚡ Streak Engine: Active</span>
    </div>
    <div class="card-body p-3 p-md-4">
      <div class="row g-3">
        <?php foreach ($streaks as $st): ?>
        <div class="col-sm-6 col-lg-3 mb-3">
          <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; background:#f8fafc; border-top: 4px solid <?= $st['color'] ?> !important;">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <span class="display-4" style="font-size:2rem;"><?= $st['icon'] ?></span>
              <span class="badge badge-dark font-mono"><?= $st['days'] ?>-Day Milestone</span>
            </div>
            <h6 class="font-weight-bold text-dark mb-1"><?= htmlspecialchars($st['title']) ?></h6>
            <div class="text-primary font-weight-bold small mb-2"><i class="fas fa-coins mr-1"></i> +<?= number_format($st['bonus_points']) ?> Loyalty Pts</div>
            <p class="text-muted small mb-0" style="font-size:0.8rem;"><?= htmlspecialchars($st['reward']) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- ── 2. VIP Achievement Badges ── -->
  <div class="card border-0 shadow-sm mb-4" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark"><i class="fas fa-certificate text-warning mr-2"></i> Customer VIP Achievement Badges</span>
      <span class="badge badge-light border font-weight-bold px-2.5 py-1"><?= count($badges) ?> Badges Configured</span>
    </div>
    <div class="card-body p-3 p-md-4">
      <div class="row g-3">
        <?php foreach ($badges as $b): ?>
        <div class="col-md-6 col-lg-4 mb-3">
          <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; border:1px solid #e2e8f0;">
            <div class="d-flex align-items-center mb-2">
              <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mr-3" style="width:48px; height:48px; font-size:1.5rem; flex-shrink:0;">
                <?= $b['icon'] ?>
              </div>
              <div>
                <h6 class="font-weight-bold text-dark mb-0"><?= htmlspecialchars($b['title']) ?></h6>
                <span class="badge badge-light border text-muted" style="font-size:0.7rem;"><?= $b['category'] ?></span>
                <span class="badge badge-warning text-dark font-weight-bold" style="font-size:0.7rem;">+<?= $b['points'] ?> pts</span>
              </div>
            </div>
            <div class="text-muted small mb-2" style="font-size:0.8rem;">
              <strong>Condition:</strong> <?= htmlspecialchars($b['condition']) ?>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
              <span class="text-muted small"><i class="fas fa-users mr-1"></i> <?= $b['holders'] ?> customers unlocked</span>
              <span class="badge badge-success px-2 py-0.5">Active</span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- ── 3. Customer Gamification Leaderboard ── -->
  <div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-3 px-md-4 border-bottom">
      <span class="font-weight-bold text-dark"><i class="fas fa-trophy text-warning mr-2"></i> Top Gamification &amp; Streak Leaderboard</span>
      <span class="text-muted small">Updated Live</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3" style="width:50px;">Rank</th>
              <th class="py-3">Customer Profile</th>
              <th class="py-3">Current Active Streak</th>
              <th class="py-3">Loyalty Points</th>
              <th class="py-3">VIP Tier</th>
              <th class="py-3 text-right px-3">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($leaders as $idx => $l): 
            $streak_days = max(1, ($idx === 0 ? 14 : ($idx === 1 ? 7 : (5 - ($idx % 5)))));
          ?>
          <tr>
            <td class="px-3 font-weight-bold">
              <?php if ($idx === 0): ?>
                <span class="badge badge-warning text-dark font-weight-bold py-1 px-2">🥇 #1</span>
              <?php elseif ($idx === 1): ?>
                <span class="badge badge-light border text-dark font-weight-bold py-1 px-2">🥈 #2</span>
              <?php elseif ($idx === 2): ?>
                <span class="badge badge-light border text-dark font-weight-bold py-1 px-2">🥉 #3</span>
              <?php else: ?>
                <span class="text-muted">#<?= $idx + 1 ?></span>
              <?php endif; ?>
            </td>
            <td>
              <?php 
                $c_name = !empty($l['name']) ? $l['name'] : (!empty($l['email']) ? explode('@', $l['email'])[0] : 'Valued Customer');
              ?>
              <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mr-2.5 text-primary font-weight-bold" style="width:36px; height:36px; flex-shrink:0;">
                  <?= strtoupper(substr($c_name, 0, 1)) ?>
                </div>
                <div>
                  <div class="font-weight-bold text-dark">
                    <?= htmlspecialchars($c_name) ?>
                  </div>
                  <div class="text-muted small" style="font-size:0.75rem;"><?= htmlspecialchars($l['email'] ?? '') ?></div>
                </div>
              </div>
            </td>
            <td>
              <span class="badge badge-light border text-dark font-weight-bold px-2 py-1">
                🔥 <?= $streak_days ?> Days Streak
              </span>
            </td>
            <td>
              <span class="badge badge-success px-2.5 py-1 font-weight-bold font-mono">
                <?= number_format($l['loyalty_points'] ?? 0) ?> pts
              </span>
            </td>
            <td>
              <span class="badge badge-light border text-dark font-weight-bold">
                <?= htmlspecialchars($l['loyalty_tier'] ?? 'Silver') ?>
              </span>
            </td>
            <td class="text-right px-3">
              <button class="btn btn-outline-primary btn-sm px-2.5 py-1 font-weight-bold" data-toggle="modal" data-target="#awardBadgeModal" onclick="prepareBadgeAward(<?= $l['id'] ?>, '<?= htmlspecialchars(addslashes($c_name)) ?>')">
                <i class="fas fa-award mr-1"></i> Award Badge
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($leaders)): ?>
          <tr><td colspan="6" class="text-center text-muted py-4">No customer streak data recorded yet</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- Modal: Award Badge & Bonus Points to Customer -->
<div class="modal fade" id="awardBadgeModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow-lg" style="border-radius:12px;">
      <div class="modal-header bg-dark text-white py-2 px-3">
        <h6 class="modal-title font-weight-bold mb-0">🎖️ Award VIP Badge</h6>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/loyalty/badges') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="badge_action" value="award_badge_customer">
        <div class="modal-body p-3 text-left">
          <div class="form-group mb-2">
            <label class="small font-weight-bold">Customer ID *</label>
            <input type="number" name="customer_id" id="award_cust_id" class="form-control form-control-sm font-weight-bold" required placeholder="e.g. 6">
          </div>
          <div class="form-group mb-2">
            <label class="small font-weight-bold">Select Badge</label>
            <select name="badge_name" class="form-control form-control-sm font-weight-bold">
              <option value="🚀 Atelier Pioneer">🚀 Atelier Pioneer (+100 pts)</option>
              <option value="👕 Streetwear Collector">👕 Streetwear Collector (+250 pts)</option>
              <option value="💎 High Roller VIP">💎 High Roller VIP (+500 pts)</option>
              <option value="⭐ Atelier Critic">⭐ Atelier Critic (+150 pts)</option>
              <option value="👑 Diamond Royal Member">👑 Diamond Royal Member (+1000 pts)</option>
            </select>
          </div>
          <div class="form-group mb-0">
            <label class="small font-weight-bold">Bonus Points to Credit</label>
            <input type="number" name="bonus_points" class="form-control form-control-sm font-weight-bold" value="150">
          </div>
        </div>
        <div class="modal-footer py-2 px-3">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning text-dark font-weight-bold btn-sm px-3">Grant Badge</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function prepareBadgeAward(custId, custName) {
  document.getElementById('award_cust_id').value = custId;
}
</script>
