<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── International & Multi-Currency Premium UI ── */
.intl-wrapper {
  padding-top: 10px;
  max-width: 1440px;
  margin: 0 auto;
}
.intl-hero {
  background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0284c7 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 24px rgba(37, 99, 235, 0.2);
}
.intl-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 10px rgba(0,0,0,.04);
  background: #fff;
  overflow: hidden;
}
.intl-card .card-header {
  background: #fff;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 20px;
  font-weight: 700;
  color: #1e293b;
}
.kpi-chip {
  background: #fff;
  border-radius: 12px;
  padding: 14px 18px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 8px rgba(0,0,0,.04);
  flex: 1;
  min-width: 140px;
}
.currency-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #ecfdf5;
  color: #065f46;
  border: 1px solid #a7f3d0;
  border-radius: 8px;
  padding: 3px 10px;
  font-weight: 800;
  font-size: .88rem;
}
.lang-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #eff6ff;
  color: #1e40af;
  border: 1px solid #bfdbfe;
  border-radius: 8px;
  padding: 3px 10px;
  font-weight: 700;
  font-size: .88rem;
}
.nav-pills .nav-link.active {
  background: #2563eb;
  color: #fff;
  font-weight: 700;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.nav-pills .nav-link {
  color: #475569;
  font-weight: 600;
  border-radius: 8px;
  padding: 8px 18px;
}
.calc-box {
  background: #f8fafc;
  border: 1.5px dashed #cbd5e1;
  border-radius: 12px;
  padding: 18px;
}
</style>

<div class="container-fluid px-3 px-md-4 py-3 intl-wrapper">

  <!-- Hero Header -->
  <div class="intl-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.75rem;">🌍</span>
        <h3 class="fw-bold mb-0 text-white font-weight-bold">Internationalization &amp; Multi-Currency Engine</h3>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Manage global exchange rates, localized dialects, regional RTL support, and multi-currency checkouts</p>
    </div>
    
    <div class="d-flex gap-2 flex-wrap">
      <form method="post" action="<?= base_url('admin/settings/international') ?>" class="d-inline" onsubmit="return confirm('Seed and reset all 20 standard global currencies and 20 languages?')">
        <?= csrf_field() ?>
        <input type="hidden" name="intl_action" value="seed_all_defaults">
        <button type="submit" class="btn btn-light btn-sm font-weight-bold px-3 shadow-sm" style="border-radius:8px;">
          <i class="fa fa-sync-alt mr-1 text-primary"></i> Seed All 20 Currencies &amp; 20 Languages
        </button>
      </form>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Stats KPI Strip -->
  <?php
    $tot_cur  = count($currencies);
    $act_cur  = count(array_filter($currencies, fn($c) => $c['is_active'] ?? 0));
    $tot_lng  = count($languages);
    $act_lng  = count(array_filter($languages, fn($l) => $l['is_active'] ?? 0));
    $base_cur = current(array_filter($currencies, fn($c) => !empty($c['is_default']))) ?: ['code' => 'INR', 'symbol' => '₹'];
    $base_lng = current(array_filter($languages, fn($l) => !empty($l['is_default']))) ?: ['name' => 'English', 'code' => 'en'];
  ?>
  <div class="d-flex flex-wrap gap-3 mb-4">
    <div class="kpi-chip" style="border-left:4px solid #10b981;">
      <div class="small text-muted font-weight-bold text-uppercase" style="font-size:.72rem;">Base Currency</div>
      <div class="h5 mb-0 font-weight-bold text-dark mt-1">
        <span class="currency-badge"><?= $base_cur['symbol'] ?> <?= $base_cur['code'] ?></span>
      </div>
    </div>
    <div class="kpi-chip" style="border-left:4px solid #2563eb;">
      <div class="small text-muted font-weight-bold text-uppercase" style="font-size:.72rem;">Active Currencies</div>
      <div class="h5 mb-0 font-weight-bold text-primary mt-1"><?= $act_cur ?> / <?= $tot_cur ?> Active</div>
    </div>
    <div class="kpi-chip" style="border-left:4px solid #8b5cf6;">
      <div class="small text-muted font-weight-bold text-uppercase" style="font-size:.72rem;">Primary Language</div>
      <div class="h5 mb-0 font-weight-bold text-dark mt-1">
        <span class="lang-badge">🇬🇧 <?= $base_lng['name'] ?> (<?= $base_lng['code'] ?>)</span>
      </div>
    </div>
    <div class="kpi-chip" style="border-left:4px solid #f59e0b;">
      <div class="small text-muted font-weight-bold text-uppercase" style="font-size:.72rem;">Supported Languages</div>
      <div class="h5 mb-0 font-weight-bold text-warning mt-1"><?= $act_lng ?> / <?= $tot_lng ?> Active</div>
    </div>
  </div>

  <!-- Navigation Tabs -->
  <ul class="nav nav-pills mb-4 bg-white p-2 rounded-3 border shadow-sm d-inline-flex">
    <li class="nav-item">
      <a class="nav-link active" id="curTab" data-toggle="pill" href="#currenciesSection">
        <i class="fa fa-money-bill-wave mr-1.5"></i> Global Currencies (<?= $tot_cur ?>)
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="langTab" data-toggle="pill" href="#languagesSection">
        <i class="fa fa-language mr-1.5"></i> Multi-Languages &amp; Regional (<?= $tot_lng ?>)
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="calcTab" data-toggle="pill" href="#converterSection">
        <i class="fa fa-calculator mr-1.5"></i> Live Currency Converter &amp; Test Tool
      </a>
    </li>
  </ul>

  <!-- Tab Contents -->
  <div class="tab-content">
    
    <!-- ── 1. Currencies Manager Tab ── -->
    <div class="tab-pane fade show active" id="currenciesSection">
      <div class="intl-card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <i class="fa fa-coins text-success mr-2"></i>
            <span>Supported Global Currencies</span>
          </div>
          <button class="btn btn-success btn-sm font-weight-bold px-3" data-toggle="modal" data-target="#addCurrencyModal" style="border-radius:8px;">
            <i class="fa fa-plus mr-1"></i> Add Currency
          </button>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="px-3">Code &amp; Symbol</th>
                  <th>Currency Name</th>
                  <th>Exchange Rate (1 <?= $base_cur['code'] ?> =)</th>
                  <th>Status</th>
                  <th>Base Default</th>
                  <th class="text-right pr-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($currencies as $c): ?>
                <tr>
                  <td class="px-3">
                    <span class="currency-badge">
                      <span style="font-size:1.1rem;"><?= htmlspecialchars($c['symbol'] ?? '') ?></span>
                      <span><?= htmlspecialchars($c['code'] ?? '') ?></span>
                    </span>
                  </td>
                  <td>
                    <div class="fw-bold text-dark"><?= htmlspecialchars($c['name'] ?? '') ?></div>
                  </td>
                  <td>
                    <code class="font-weight-bold" style="font-size:.95rem;color:#0f172a;">
                      <?= number_format((float)($c['exchange_rate'] ?? 1), 6) ?> <?= htmlspecialchars($c['code']) ?>
                    </code>
                  </td>
                  <td>
                    <span class="badge badge-<?= ($c['is_active'] ?? 0) ? 'success' : 'secondary' ?> px-2.5 py-1">
                      <?= ($c['is_active'] ?? 0) ? '● Active' : 'Disabled' ?>
                    </span>
                  </td>
                  <td>
                    <?php if (!empty($c['is_default'])): ?>
                      <span class="badge badge-primary px-2.5 py-1"><i class="fa fa-star mr-1"></i>Base Currency</span>
                    <?php else: ?>
                      <form method="post" action="<?= base_url('admin/settings/international') ?>" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="intl_action" value="set_default_currency">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-primary py-0 px-2 font-weight-bold" title="Make Base Currency">
                          Set Base
                        </button>
                      </form>
                    <?php endif; ?>
                  </td>
                  <td class="text-right pr-3">
                    <?php if (empty($c['is_default'])): ?>
                      <form method="post" action="<?= base_url('admin/settings/international') ?>" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="intl_action" value="toggle_currency">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-<?= ($c['is_active'] ?? 0) ? 'warning' : 'success' ?> py-1 px-2" title="Toggle Active">
                          <i class="fa <?= ($c['is_active'] ?? 0) ? 'fa-pause' : 'fa-play' ?>"></i>
                        </button>
                      </form>
                      <button type="button" class="btn btn-sm btn-outline-info py-1 px-2" data-toggle="modal" data-target="#editCurModal<?= $c['id'] ?>" title="Edit Rate">
                        <i class="fa fa-edit"></i>
                      </button>
                      <form method="post" action="<?= base_url('admin/settings/international') ?>" class="d-inline" onsubmit="return confirm('Remove currency <?= $c['code'] ?>?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="intl_action" value="delete_currency">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    <?php else: ?>
                      <span class="text-muted small">Locked (Primary)</span>
                    <?php endif; ?>
                  </td>
                </tr>

                <!-- Edit Rate Modal -->
                <div class="modal fade" id="editCurModal<?= $c['id'] ?>" tabindex="-1">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
                      <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title font-weight-bold">Edit <?= $c['code'] ?> Rate</h6>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post" action="<?= base_url('admin/settings/international') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="intl_action" value="save_currency">
                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                        <input type="hidden" name="code" value="<?= $c['code'] ?>">
                        <input type="hidden" name="name" value="<?= $c['name'] ?>">
                        <input type="hidden" name="symbol" value="<?= $c['symbol'] ?>">
                        <input type="hidden" name="is_active" value="<?= $c['is_active'] ?>">
                        <div class="modal-body">
                          <div class="form-group mb-2">
                            <label class="small font-weight-bold">Exchange Rate (1 <?= $base_cur['code'] ?> = )</label>
                            <input type="number" step="0.000001" name="exchange_rate" class="form-control font-mono" value="<?= $c['exchange_rate'] ?>" required>
                          </div>
                        </div>
                        <div class="modal-footer p-2">
                          <button type="submit" class="btn btn-primary btn-block btn-sm font-weight-bold">Update Rate</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ── 2. Languages Manager Tab ── -->
    <div class="tab-pane fade" id="languagesSection">
      <div class="intl-card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <i class="fa fa-language text-primary mr-2"></i>
            <span>Supported Languages &amp; Dialects</span>
          </div>
          <button class="btn btn-primary btn-sm font-weight-bold px-3" data-toggle="modal" data-target="#addLangModal" style="border-radius:8px;">
            <i class="fa fa-plus mr-1"></i> Add Language
          </button>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="px-3">Code</th>
                  <th>Language Name</th>
                  <th>Native Script</th>
                  <th>Direction</th>
                  <th>Status</th>
                  <th>Default</th>
                  <th class="text-right pr-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($languages as $l): ?>
                <tr>
                  <td class="px-3">
                    <span class="lang-badge font-mono"><?= htmlspecialchars($l['code'] ?? '') ?></span>
                  </td>
                  <td>
                    <div class="fw-bold text-dark"><?= htmlspecialchars($l['name'] ?? '') ?></div>
                  </td>
                  <td>
                    <span class="font-weight-bold text-primary" style="font-size:1.05rem;"><?= htmlspecialchars($l['native_name'] ?? $l['name']) ?></span>
                  </td>
                  <td>
                    <span class="badge badge-<?= ($l['direction'] ?? 'ltr') === 'rtl' ? 'warning text-dark' : 'light border' ?>">
                      <?= strtoupper(htmlspecialchars($l['direction'] ?? 'ltr')) ?>
                    </span>
                  </td>
                  <td>
                    <span class="badge badge-<?= ($l['is_active'] ?? 0) ? 'success' : 'secondary' ?> px-2.5 py-1">
                      <?= ($l['is_active'] ?? 0) ? '● Active' : 'Disabled' ?>
                    </span>
                  </td>
                  <td>
                    <?php if (!empty($l['is_default'])): ?>
                      <span class="badge badge-primary px-2.5 py-1"><i class="fa fa-star mr-1"></i>Primary Default</span>
                    <?php else: ?>
                      <form method="post" action="<?= base_url('admin/settings/international') ?>" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="intl_action" value="set_default_language">
                        <input type="hidden" name="id" value="<?= $l['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-primary py-0 px-2 font-weight-bold" title="Make Primary Language">
                          Set Primary
                        </button>
                      </form>
                    <?php endif; ?>
                  </td>
                  <td class="text-right pr-3">
                    <?php if (empty($l['is_default'])): ?>
                      <form method="post" action="<?= base_url('admin/settings/international') ?>" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="intl_action" value="toggle_language">
                        <input type="hidden" name="id" value="<?= $l['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-<?= ($l['is_active'] ?? 0) ? 'warning' : 'success' ?> py-1 px-2" title="Toggle Active">
                          <i class="fa <?= ($l['is_active'] ?? 0) ? 'fa-pause' : 'fa-play' ?>"></i>
                        </button>
                      </form>
                      <form method="post" action="<?= base_url('admin/settings/international') ?>" class="d-inline" onsubmit="return confirm('Remove language <?= $l['name'] ?>?')">
                        <?= csrf_field() ?>
                        <input type="hidden" name="intl_action" value="delete_language">
                        <input type="hidden" name="id" value="<?= $l['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                          <i class="fa fa-trash"></i>
                        </button>
                      </form>
                    <?php else: ?>
                      <span class="text-muted small">Locked (Primary)</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- ── 3. Live Converter Test Simulator ── -->
    <div class="tab-pane fade" id="converterSection">
      <div class="intl-card p-4">
        <h5 class="fw-bold mb-1 text-dark"><i class="fa fa-calculator text-primary mr-2"></i>Multi-Currency Conversion Simulator</h5>
        <p class="text-muted small mb-4">Test real-time catalog price conversion from Base <?= $base_cur['code'] ?> to all enabled global storefront currencies.</p>

        <div class="row g-4 mb-4">
          <div class="col-md-5">
            <div class="calc-box">
              <label class="font-weight-bold small text-dark">Enter Base Amount in <?= $base_cur['code'] ?> (<?= $base_cur['symbol'] ?>):</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text font-weight-bold"><?= $base_cur['symbol'] ?></span>
                </div>
                <input type="number" id="simAmount" class="form-control font-weight-bold" style="font-size:1.2rem;" value="1499" oninput="runLiveConversion()">
              </div>
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('simAmount').value=499; runLiveConversion();">₹499</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('simAmount').value=999; runLiveConversion();">₹999</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('simAmount').value=1499; runLiveConversion();">₹1,499</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('simAmount').value=4999; runLiveConversion();">₹4,999</button>
              </div>
            </div>
          </div>

          <div class="col-md-7">
            <div class="row g-2" id="conversionGrid">
              <!-- Dynamically populated via JS -->
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<!-- Modal: Add Currency -->
<div class="modal fade" id="addCurrencyModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title font-weight-bold"><i class="fa fa-plus-circle mr-2"></i>Add Storefront Currency</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/settings/international') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="intl_action" value="save_currency">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="is_active" value="1">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-6 form-group">
              <label class="small font-weight-bold">Currency Code *</label>
              <input type="text" name="code" class="form-control text-uppercase font-mono" placeholder="e.g. USD" required maxlength="5">
            </div>
            <div class="col-6 form-group">
              <label class="small font-weight-bold">Currency Symbol *</label>
              <input type="text" name="symbol" class="form-control" placeholder="e.g. $" required maxlength="10">
            </div>
            <div class="col-12 form-group">
              <label class="small font-weight-bold">Full Currency Name *</label>
              <input type="text" name="name" class="form-control" placeholder="e.g. United States Dollar" required>
            </div>
            <div class="col-12 form-group">
              <label class="small font-weight-bold">Exchange Rate (1 <?= $base_cur['code'] ?> = ?)</label>
              <input type="number" step="0.000001" name="exchange_rate" class="form-control font-mono" value="1.000000" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success font-weight-bold px-4">Add Currency</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: Add Language -->
<div class="modal fade" id="addLangModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title font-weight-bold"><i class="fa fa-plus-circle mr-2"></i>Add Storefront Language</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/settings/international') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="intl_action" value="save_language">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="is_active" value="1">
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-6 form-group">
              <label class="small font-weight-bold">Language Code (ISO) *</label>
              <input type="text" name="code" class="form-control text-lowercase font-mono" placeholder="e.g. fr" required maxlength="10">
            </div>
            <div class="col-6 form-group">
              <label class="small font-weight-bold">Text Direction</label>
              <select name="direction" class="form-control">
                <option value="ltr">LTR (Left to Right)</option>
                <option value="rtl">RTL (Right to Left - Arabic/Urdu)</option>
              </select>
            </div>
            <div class="col-6 form-group">
              <label class="small font-weight-bold">English Name *</label>
              <input type="text" name="name" class="form-control" placeholder="e.g. French" required>
            </div>
            <div class="col-6 form-group">
              <label class="small font-weight-bold">Native Script Name</label>
              <input type="text" name="native_name" class="form-control" placeholder="e.g. Français">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold px-4">Add Language</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
var curList = <?= json_encode($currencies) ?>;

function runLiveConversion() {
  var amt = parseFloat(document.getElementById('simAmount').value) || 0;
  var container = document.getElementById('conversionGrid');
  if (!container) return;
  container.innerHTML = '';

  curList.forEach(function(c){
    var rate = parseFloat(c.exchange_rate) || 1;
    var converted = amt * rate;
    var col = document.createElement('div');
    col.className = 'col-6 col-sm-4 mb-2';
    col.innerHTML = '<div class="p-2.5 bg-white rounded border shadow-sm">' +
      '<div class="d-flex justify-content-between align-items-center mb-1">' +
        '<span class="badge badge-light border font-mono">' + c.code + '</span>' +
        '<small class="text-muted">' + c.name + '</small>' +
      '</div>' +
      '<div class="h6 mb-0 font-weight-bold text-success">' + c.symbol + ' ' + converted.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</div>' +
    '</div>';
    container.appendChild(col);
  });
}

document.addEventListener('DOMContentLoaded', runLiveConversion);
</script>
