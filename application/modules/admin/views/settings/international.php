<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <h2 class="fw-bold mb-3">🌍 International &amp; Currencies</h2>
  <div class="row g-3">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><i class="fa fa-money-bill mr-2 text-success"></i>Supported Currencies</div>
        <div class="card-body">
          <?php if (empty($currencies)): ?>
          <p class="text-muted small">No currencies configured. Default: INR (₹).</p>
          <?php else: ?>
          <table class="table table-sm mb-0">
            <thead><tr><th>Code</th><th>Symbol</th><th>Exchange Rate</th><th>Default</th></tr></thead>
            <tbody>
            <?php foreach ($currencies as $c): ?>
            <tr>
              <td class="fw-bold"><?= htmlspecialchars($c['code'] ?? '') ?></td>
              <td><?= htmlspecialchars($c['symbol'] ?? '') ?></td>
              <td><?= $c['exchange_rate'] ?? 1 ?></td>
              <td><?= !empty($c['is_default']) ? '<span class="badge badge-success">Primary</span>' : '—' ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold"><i class="fa fa-language mr-2 text-primary"></i>Supported Languages</div>
        <div class="card-body">
          <?php if (empty($languages)): ?>
          <p class="text-muted small">No multi-language options configured. Default: English (en).</p>
          <?php else: ?>
          <table class="table table-sm mb-0">
            <thead><tr><th>Code</th><th>Language Name</th><th>Default</th></tr></thead>
            <tbody>
            <?php foreach ($languages as $l): ?>
            <tr>
              <td class="fw-bold"><?= htmlspecialchars($l['code'] ?? '') ?></td>
              <td><?= htmlspecialchars($l['name'] ?? '') ?></td>
              <td><?= !empty($l['is_default']) ? '<span class="badge badge-success">Primary</span>' : '—' ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
