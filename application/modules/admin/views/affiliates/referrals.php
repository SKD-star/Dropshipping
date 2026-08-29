<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-3">📣 Referral Log</h2>
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Referral Code</th><th>Referred Customer</th><th>Status</th><th>Reward Earned</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach ($referrals as $r): ?>
        <tr>
          <td><code><?= htmlspecialchars($r['referral_code'] ?? '') ?></code></td>
          <td><?= htmlspecialchars($r['referred_email'] ?? 'Customer #' . ($r['referred_customer_id'] ?? '')) ?></td>
          <td><span class="badge badge-<?= ($r['status'] ?? '') === 'converted' ? 'success' : 'warning' ?>"><?= ucfirst($r['status'] ?? 'pending') ?></span></td>
          <td>&#8377;<?= number_format($r['reward_amount'] ?? 0, 2) ?></td>
          <td><small><?= $r['created_at'] ?? '' ?></small></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($referrals)): ?><tr><td colspan="5" class="text-center text-muted py-5">No referral conversions recorded yet.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
