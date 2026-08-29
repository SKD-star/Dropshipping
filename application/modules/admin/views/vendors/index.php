<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- ── KPI Cards ─────────────────────────────────────────────── -->
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="fw-bold mb-0" style="color:#4e73df;font-size:1.6rem;">🏪 Vendor Marketplace</h2>
      <p class="text-muted mb-0">Manage all seller accounts, commissions &amp; payouts</p>
    </div>
    <a href="<?= base_url('admin/vendors/payouts') ?>" class="btn btn-primary btn-sm px-4">
      <i class="fa fa-money-bill-wave mr-1"></i> View Payouts
    </a>
  </div>

  <!-- Flash messages -->
  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show"><i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>
  <?php endif; ?>

  <!-- KPI Row -->
  <div class="row g-3 mb-4">
    <?php
    $kpis = [
      ['icon'=>'fa-store','label'=>'Total Vendors','value'=>number_format($kpi['total_vendors']??0),'color'=>'#4e73df'],
      ['icon'=>'fa-check-circle','label'=>'Approved','value'=>number_format($kpi['approved_vendors']??0),'color'=>'#1cc88a'],
      ['icon'=>'fa-clock','label'=>'Pending Review','value'=>number_format($kpi['pending_vendors']??0),'color'=>'#f6c23e'],
      ['icon'=>'fa-ban','label'=>'Suspended','value'=>number_format($kpi['suspended_vendors']??0),'color'=>'#e74a3b'],
      ['icon'=>'fa-chart-line','label'=>'Marketplace GMV','value'=>'₹'.number_format($kpi['marketplace_gmv']??0,2),'color'=>'#36b9cc'],
      ['icon'=>'fa-percentage','label'=>'Platform Commission','value'=>'₹'.number_format($kpi['platform_commission']??0,2),'color'=>'#9333ea'],
      ['icon'=>'fa-hand-holding-usd','label'=>'Pending Payouts','value'=>'₹'.number_format($kpi['pending_payouts']??0,2),'color'=>'#e67e22'],
    ];
    foreach ($kpis as $k):
    ?>
    <div class="col-6 col-md-4 col-xl-3">
      <div class="card border-0 shadow-sm h-100" style="border-left:4px solid <?= $k['color'] ?>!important;">
        <div class="card-body py-3">
          <div class="d-flex align-items-center">
            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:42px;height:42px;background:<?= $k['color'] ?>22;">
              <i class="fa <?= $k['icon'] ?>" style="color:<?= $k['color'] ?>;font-size:1.1rem;"></i>
            </div>
            <div>
              <div style="font-size:.72rem;font-weight:700;letter-spacing:.04em;color:#888;text-transform:uppercase;"><?= $k['label'] ?></div>
              <div style="font-size:1.25rem;font-weight:800;color:#2d3748;"><?= $k['value'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Run Payouts Button -->
  <form method="post" action="<?= base_url('admin/vendors/run_payouts') ?>" class="mb-3" onsubmit="return confirm('Generate pending payout batches for all approved vendors?')">
    <?= csrf_field() ?>
    <button class="btn btn-success btn-sm px-4"><i class="fa fa-play-circle mr-1"></i> Run Batch Payouts for All Approved Vendors</button>
  </form>

  <!-- Search -->
  <form method="get" class="mb-3 d-flex gap-2">
    <input name="q" value="<?= htmlspecialchars($search ?? '') ?>" class="form-control form-control-sm" placeholder="Search by name, email..." style="max-width:320px;">
    <button class="btn btn-outline-primary btn-sm px-3"><i class="fa fa-search"></i></button>
    <?php if (!empty($search)): ?><a href="<?= base_url('admin/vendors') ?>" class="btn btn-outline-secondary btn-sm">Clear</a><?php endif; ?>
  </form>

  <!-- Vendors Table -->
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0" id="vendorsTable">
          <thead style="background:#f8f9fc;">
            <tr>
              <th>#</th>
              <th>Business</th>
              <th>Contact</th>
              <th>Status</th>
              <th>Products</th>
              <th>Total Sales</th>
              <th>Commission</th>
              <th>Pending Payout</th>
              <th>Joined</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($vendors)): ?>
            <tr><td colspan="10" class="text-center text-muted py-5">No vendors found</td></tr>
          <?php else: foreach ($vendors as $v):
            $status_colors = ['approved'=>'success','pending'=>'warning','suspended'=>'danger','rejected'=>'secondary'];
            $sc = $status_colors[$v['status']] ?? 'secondary';
          ?>
            <tr>
              <td class="fw-bold text-muted"><?= $v['id'] ?></td>
              <td>
                <a href="<?= base_url('admin/vendors/detail/'.$v['id']) ?>" class="fw-bold text-decoration-none"><?= htmlspecialchars($v['business_name'] ?? '—') ?></a>
                <div style="font-size:.75rem;color:#888;"><?= htmlspecialchars($v['email'] ?? '') ?></div>
              </td>
              <td><?= htmlspecialchars($v['contact_name'] ?? '—') ?><br><small class="text-muted"><?= htmlspecialchars($v['phone'] ?? '') ?></small></td>
              <td><span class="badge badge-<?= $sc ?>"><?= ucfirst($v['status']) ?></span></td>
              <td class="text-center"><?= number_format($v['listed_products'] ?? 0) ?></td>
              <td>₹<?= number_format($v['total_sales'] ?? 0, 2) ?></td>
              <td><?= $v['commission_value'] ?? 0 ?>%</td>
              <td class="<?= ($v['pending_payout']??0) > 0 ? 'text-warning fw-bold' : '' ?>">₹<?= number_format($v['pending_payout'] ?? 0, 2) ?></td>
              <td><small><?= date('d M Y', strtotime($v['created_at'])) ?></small></td>
              <td>
                <div class="btn-group btn-group-sm">
                  <a href="<?= base_url('admin/vendors/detail/'.$v['id']) ?>" class="btn btn-outline-info" title="View Detail"><i class="fa fa-eye"></i></a>
                  <?php if ($v['status'] !== 'approved'): ?>
                  <a href="<?= base_url('admin/vendors/approve/'.$v['id']) ?>" class="btn btn-outline-success" onclick="return confirm('Approve this vendor?')" title="Approve"><i class="fa fa-check"></i></a>
                  <?php endif; ?>
                  <?php if ($v['status'] !== 'suspended'): ?>
                  <a href="<?= base_url('admin/vendors/suspend/'.$v['id']) ?>" class="btn btn-outline-warning" onclick="return confirm('Suspend this vendor?')" title="Suspend"><i class="fa fa-ban"></i></a>
                  <?php endif; ?>
                  <button class="btn btn-outline-primary" data-toggle="modal" data-target="#commModal<?= $v['id'] ?>" title="Set Commission"><i class="fa fa-percent"></i></button>
                </div>

                <!-- Commission Modal -->
                <div class="modal fade" id="commModal<?= $v['id'] ?>" tabindex="-1">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                      <div class="modal-header"><h6 class="modal-title">Commission — <?= htmlspecialchars($v['business_name']) ?></h6><button type="button" class="close" data-dismiss="modal">&times;</button></div>
                      <form method="post" action="<?= base_url('admin/vendors/commission/'.$v['id']) ?>">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                          <div class="form-group mb-2">
                            <label class="small">Type</label>
                            <select name="commission_type" class="form-control form-control-sm">
                              <option value="percent" <?= ($v['commission_type']??'percent')==='percent'?'selected':'' ?>>Percent (%)</option>
                              <option value="flat" <?= ($v['commission_type']??'')==='flat'?'selected':'' ?>>Flat (₹)</option>
                            </select>
                          </div>
                          <div class="form-group mb-0">
                            <label class="small">Value</label>
                            <input type="number" step="0.01" min="0" max="100" name="commission_value" class="form-control form-control-sm" value="<?= $v['commission_value'] ?? 10 ?>">
                          </div>
                        </div>
                        <div class="modal-footer py-2"><button class="btn btn-primary btn-sm">Save</button></div>
                      </form>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
