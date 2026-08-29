<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#f59e0b;">🏷️ AI Dynamic Repricer &amp; Profit Maximizer</h2>
      <p class="text-muted mb-0">Automated margin optimization, charm pricing, and 1-click catalog-wide repricing</p>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-warning text-white btn-sm px-3 shadow-sm font-weight-bold mr-2" data-toggle="modal" data-target="#batchRepriceModal"><i class="fa fa-bolt mr-1"></i> 1-Click Catalog Reprice</button>
      <button class="btn btn-primary btn-sm px-3 shadow-sm" data-toggle="modal" data-target="#newRuleModal"><i class="fa fa-plus mr-1"></i> New Pricing Rule</button>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?><div class="alert alert-success alert-dismissible fade show"><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div><?php endif; ?>

  <!-- Stats Row -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #f59e0b;">
        <i class="fa fa-layer-group fa-2x mb-2 text-warning"></i>
        <div style="font-size:1.5rem;font-weight:800;">₹<?= number_format($total_catalog_val, 2) ?></div>
        <div class="text-muted small">Total Catalog Valuation</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #1cc88a;">
        <i class="fa fa-cogs fa-2x mb-2 text-success"></i>
        <div style="font-size:1.5rem;font-weight:800;"><?= count($rules) ?></div>
        <div class="text-muted small">Active Pricing Guardrail Rules</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:3px solid #4e73df;">
        <i class="fa fa-history fa-2x mb-2 text-primary"></i>
        <div style="font-size:1.5rem;font-weight:800;"><?= count($audit_log) ?></div>
        <div class="text-muted small">Price Adjustments Executed</div>
      </div>
    </div>
  </div>

  <!-- Live Catalog Price Tuner -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold"><i class="fa fa-sliders-h mr-2 text-primary"></i>Quick-Tuner (Instant Single Product Repricing)</div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Product Title</th><th>Current Base Price</th><th>Compare At</th><th>Quick Update (₹)</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($catalog_products as $p): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($p['title']) ?></td>
          <td>₹<?= number_format($p['base_price'], 2) ?></td>
          <td class="text-muted"><del>₹<?= number_format($p['compare_at_price'] ?? 0, 2) ?></del></td>
          <form method="post" action="<?= base_url('admin/ai_engine/repricer') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="repricer_action" value="update_single_price">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <td>
              <input type="number" step="0.01" name="new_price" class="form-control form-control-sm" value="<?= $p['base_price'] ?>" style="max-width:120px;" required>
            </td>
            <td>
              <button type="submit" class="btn btn-sm btn-outline-success">Update Price</button>
            </td>
          </form>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Rules Table -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold"><i class="fa fa-shield-alt mr-2 text-warning"></i>Automated Pricing Guardrails</div>
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead><tr><th>Rule Name</th><th>Strategy Type</th><th>Value</th><th>Floor Price</th><th>Ceiling Price</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($rules as $r): ?>
        <tr>
          <td class="fw-bold"><?= htmlspecialchars($r['name']) ?></td>
          <td><code><?= htmlspecialchars($r['rule_type']) ?></code></td>
          <td><?= $r['value'] ?></td>
          <td><?= $r['min_price'] ? '₹' . number_format($r['min_price'], 2) : '—' ?></td>
          <td><?= $r['max_price'] ? '₹' . number_format($r['max_price'], 2) : '—' ?></td>
          <td><span class="badge badge-<?= $r['is_active'] ? 'success' : 'secondary' ?>"><?= $r['is_active'] ? 'Active' : 'Off' ?></span></td>
          <td>
            <form method="post" action="<?= base_url('admin/ai_engine/repricer') ?>" class="d-inline">
              <?= csrf_field() ?><input type="hidden" name="repricer_action" value="toggle_rule"><input type="hidden" name="rule_id" value="<?= $r['id'] ?>">
              <button class="btn btn-sm btn-outline-<?= $r['is_active'] ? 'warning' : 'success' ?>"><?= $r['is_active'] ? 'Pause' : 'Enable' ?></button>
            </form>
            <form method="post" action="<?= base_url('admin/ai_engine/repricer') ?>" class="d-inline" onsubmit="return confirm('Delete this pricing rule?')">
              <?= csrf_field() ?><input type="hidden" name="repricer_action" value="delete_rule"><input type="hidden" name="rule_id" value="<?= $r['id'] ?>">
              <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($rules)): ?><tr><td colspan="7" class="text-center text-muted py-4">No pricing guardrail rules defined yet.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal 1-Click Catalog Reprice -->
<div class="modal fade" id="batchRepriceModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">⚡ 1-Click Catalog-Wide Repricer</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/ai_engine/repricer') ?>" onsubmit="return confirm('Apply this repricing strategy to all products in your catalog?')">
        <?= csrf_field() ?>
        <input type="hidden" name="repricer_action" value="batch_reprice">
        <div class="modal-body">
          <p class="text-muted small">Select an AI pricing strategy to instantly re-calculate prices across the entire catalog:</p>
          <div class="form-group">
            <div class="custom-control custom-radio mb-3">
              <input type="radio" id="strat1" name="pricing_strategy" value="boost_profit" class="custom-control-input" checked>
              <label class="custom-control-label fw-bold" for="strat1">📈 Profit Maximizer (+12% with smart charm pricing)</label>
              <small class="text-muted d-block pl-4">Increases margins across all active items and applies 99-charm rounding.</small>
            </div>
            <div class="custom-control custom-radio mb-3">
              <input type="radio" id="strat2" name="pricing_strategy" value="clearance_velocity" class="custom-control-input">
              <label class="custom-control-label fw-bold" for="strat2">🚀 Velocity Clearance (-10% Discount)</label>
              <small class="text-muted d-block pl-4">Reduces prices store-wide to drive higher conversion volume and liquidate slow-moving stock.</small>
            </div>
            <div class="custom-control custom-radio">
              <input type="radio" id="strat3" name="pricing_strategy" value="enforce_markup" class="custom-control-input">
              <label class="custom-control-label fw-bold" for="strat3">🔒 Enforce Minimum Gross Margin Floor (2.8x)</label>
              <small class="text-muted d-block pl-4">Guarantees that all products meet your target margin threshold.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-warning text-white font-weight-bold">Execute Strategy Now</button></div>
      </form>
    </div>
  </div>
</div>

<!-- Modal New Rule -->
<div class="modal fade" id="newRuleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">New Pricing Rule</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form method="post" action="<?= base_url('admin/ai_engine/repricer') ?>">
        <?= csrf_field() ?><input type="hidden" name="repricer_action" value="create_rule">
        <div class="modal-body">
          <div class="form-group"><label>Rule Name</label><input type="text" name="name" class="form-control" required placeholder="e.g. Min 60% Gross Margin"></div>
          <div class="form-group"><label>Strategy Type</label><select name="rule_type" class="form-control"><option value="margin_percent">Margin % Target</option><option value="competitor_match">Competitor Price Match</option><option value="demand_surge">High Demand Surge</option><option value="clearance">Clearance</option></select></div>
          <div class="row"><div class="col-4"><div class="form-group"><label>Value</label><input type="number" step="0.01" name="value" class="form-control" required placeholder="2.8"></div></div><div class="col-4"><div class="form-group"><label>Floor (₹)</label><input type="number" step="0.01" name="min_price" class="form-control" placeholder="499"></div></div><div class="col-4"><div class="form-group"><label>Ceiling (₹)</label><input type="number" step="0.01" name="max_price" class="form-control" placeholder="9999"></div></div></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button><button class="btn btn-primary">Create Rule</button></div>
      </form>
    </div>
  </div>
</div>
