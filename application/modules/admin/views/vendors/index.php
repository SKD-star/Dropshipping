<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container-fluid px-3 px-md-4 py-3">
  <!-- Top Header -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="fas fa-store text-primary mr-2"></i>Vendor Marketplace
      </h3>
      <p class="text-muted small mb-0">Manage all third-party seller accounts, commission splits, and automated bank payouts</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="<?= base_url('admin/vendors/payouts') ?>" class="btn btn-primary btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
        <i class="fas fa-money-bill-wave mr-1.5"></i> View Payouts &amp; Settlements
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
  <?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3">
    <i class="fas fa-exclamation-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('error')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- KPI Metric Cards Grid -->
  <div class="row g-3 mb-4">
    <?php
    $kpis = [
      ['icon'=>'fa-store','label'=>'Total Vendors','value'=>number_format($kpi['total_vendors']??0),'color'=>'#4f46e5','bg'=>'rgba(79, 70, 229, 0.08)'],
      ['icon'=>'fa-check-circle','label'=>'Approved Sellers','value'=>number_format($kpi['approved_vendors']??0),'color'=>'#10b981','bg'=>'rgba(16, 185, 129, 0.08)'],
      ['icon'=>'fa-clock','label'=>'Pending Review','value'=>number_format($kpi['pending_vendors']??0),'color'=>'#f59e0b','bg'=>'rgba(245, 158, 11, 0.08)'],
      ['icon'=>'fa-ban','label'=>'Suspended','value'=>number_format($kpi['suspended_vendors']??0),'color'=>'#ef4444','bg'=>'rgba(239, 68, 68, 0.08)'],
      ['icon'=>'fa-chart-line','label'=>'Marketplace GMV','value'=>'₹'.number_format($kpi['marketplace_gmv']??0,2),'color'=>'#06b6d4','bg'=>'rgba(6, 182, 212, 0.08)'],
      ['icon'=>'fa-percentage','label'=>'Platform Commission','value'=>'₹'.number_format($kpi['platform_commission']??0,2),'color'=>'#8b5cf6','bg'=>'rgba(139, 92, 246, 0.08)'],
      ['icon'=>'fa-hand-holding-usd','label'=>'Pending Payouts','value'=>'₹'.number_format($kpi['pending_payouts']??0,2),'color'=>'#f97316','bg'=>'rgba(249, 115, 22, 0.08)'],
    ];
    foreach ($kpis as $k):
    ?>
    <div class="col-6 col-md-4 col-xl-3 mb-2">
      <div class="card border-0 shadow-sm h-100 p-3" style="border-radius:12px; border-left: 4px solid <?= $k['color'] ?> !important;">
        <div class="d-flex align-items-center">
          <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width:42px;height:42px;background:<?= $k['bg'] ?>;flex-shrink:0;">
            <i class="fa <?= $k['icon'] ?>" style="color:<?= $k['color'] ?>;font-size:1.1rem;"></i>
          </div>
          <div class="min-w-0">
            <div class="text-muted text-uppercase font-weight-bold" style="font-size:0.7rem; letter-spacing:0.04em;"><?= $k['label'] ?></div>
            <div class="font-weight-bold text-dark text-truncate" style="font-size:1.2rem;"><?= $k['value'] ?></div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Search & Run Batch Payouts Bar -->
  <div class="card border-0 shadow-sm p-3 mb-3 bg-white" style="border-radius:12px;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <form method="get" class="d-flex gap-2 w-100" style="max-width:400px;">
        <div class="input-group input-group-sm">
          <input name="q" value="<?= htmlspecialchars($search ?? '') ?>" class="form-control font-weight-bold" placeholder="Search by business, email, phone...">
          <div class="input-group-append">
            <button class="btn btn-outline-primary px-3"><i class="fa fa-search"></i></button>
          </div>
        </div>
        <?php if (!empty($search)): ?>
        <a href="<?= base_url('admin/vendors') ?>" class="btn btn-outline-secondary btn-sm">Clear</a>
        <?php endif; ?>
      </form>

      <form method="post" action="<?= base_url('admin/vendors/run_payouts') ?>" onsubmit="return confirm('Generate pending payout settlements for all approved vendors?')">
        <?= csrf_field() ?>
        <button class="btn btn-success btn-sm px-3 font-weight-bold shadow-sm" style="border-radius:8px;">
          <i class="fas fa-play-circle mr-1"></i> Run Batch Payouts for All Approved Vendors
        </button>
      </form>
    </div>
  </div>

  <!-- Vendors Table Card -->
  <div class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="vendorsTable">
          <thead class="bg-light text-muted small text-uppercase">
            <tr>
              <th class="py-3 px-3" style="width: 40px;">#</th>
              <th class="py-3">Business Profile</th>
              <th class="py-3">Contact</th>
              <th class="py-3">Status</th>
              <th class="py-3 text-center">Listed SKUs</th>
              <th class="py-3">Total Sales</th>
              <th class="py-3">Commission Split</th>
              <th class="py-3">Pending Settlement</th>
              <th class="py-3">Joined Date</th>
              <th class="py-3 text-right px-3">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (empty($vendors)): ?>
            <tr><td colspan="10" class="text-center text-muted py-5"><i class="fas fa-store-slash fa-2x mb-2 d-block opacity-50"></i>No sellers found matching criteria</td></tr>
          <?php else: foreach ($vendors as $v):
            $status_badges = [
              'approved'  => '<span class="badge badge-success px-2.5 py-1">Approved</span>',
              'pending'   => '<span class="badge badge-warning text-dark px-2.5 py-1">Pending Review</span>',
              'suspended' => '<span class="badge badge-danger px-2.5 py-1">Suspended</span>',
              'rejected'  => '<span class="badge badge-secondary px-2.5 py-1">Rejected</span>'
            ];
            $sb = $status_badges[$v['status']] ?? '<span class="badge badge-secondary px-2 py-1">'.ucfirst($v['status']).'</span>';
          ?>
            <tr>
              <td class="px-3 font-weight-bold text-muted"><?= $v['id'] ?></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center mr-2.5 text-primary font-weight-bold" style="width:36px; height:36px; flex-shrink:0;">
                    <?= strtoupper(substr($v['business_name'] ?? 'V', 0, 1)) ?>
                  </div>
                  <div>
                    <a href="<?= base_url('admin/vendors/detail/'.$v['id']) ?>" class="font-weight-bold text-dark text-decoration-none hover:text-primary">
                      <?= htmlspecialchars($v['business_name'] ?? 'Vendor #' . $v['id']) ?>
                    </a>
                    <div class="text-muted small" style="font-size:0.75rem;"><?= htmlspecialchars($v['email'] ?? '') ?></div>
                  </div>
                </div>
              </td>
              <td>
                <div class="font-weight-bold text-dark small"><?= htmlspecialchars($v['contact_name'] ?? '—') ?></div>
                <div class="text-muted small"><?= htmlspecialchars($v['phone'] ?? '') ?></div>
              </td>
              <td><?= $sb ?></td>
              <td class="text-center font-weight-bold"><?= number_format($v['listed_products'] ?? 0) ?></td>
              <td class="font-weight-bold text-dark">₹<?= number_format($v['total_sales'] ?? 0, 2) ?></td>
              <td>
                <span class="badge badge-light border text-dark font-weight-bold">
                  <?= $v['commission_value'] ?? 15 ?><?= ($v['commission_type'] ?? 'percent') === 'flat' ? '₹ flat' : '%' ?>
                </span>
              </td>
              <td>
                <span class="font-weight-bold <?= ($v['pending_payout'] ?? 0) > 0 ? 'text-warning' : 'text-muted' ?>">
                  ₹<?= number_format($v['pending_payout'] ?? 0, 2) ?>
                </span>
              </td>
              <td><small class="text-muted"><?= !empty($v['created_at']) ? date('d M Y', strtotime($v['created_at'])) : '—' ?></small></td>
              <td class="text-right px-3">
                <div class="btn-group btn-group-sm">
                  <a href="<?= base_url('admin/vendors/detail/'.$v['id']) ?>" class="btn btn-outline-primary" title="View Seller Profile &amp; Ledger">
                    <i class="fa fa-eye"></i>
                  </a>
                  <?php if ($v['status'] !== 'approved'): ?>
                  <a href="<?= base_url('admin/vendors/approve/'.$v['id']) ?>" class="btn btn-outline-success" onclick="return confirm('Approve this vendor for live selling?')" title="Approve Seller">
                    <i class="fa fa-check"></i>
                  </a>
                  <?php endif; ?>
                  <?php if ($v['status'] !== 'suspended'): ?>
                  <a href="<?= base_url('admin/vendors/suspend/'.$v['id']) ?>" class="btn btn-outline-danger" onclick="return confirm('Suspend this vendor account?')" title="Suspend Seller">
                    <i class="fa fa-ban"></i>
                  </a>
                  <?php endif; ?>
                  <button class="btn btn-outline-dark" data-toggle="modal" data-target="#commModal<?= $v['id'] ?>" title="Edit Commission Split">
                    <i class="fa fa-percent"></i>
                  </button>
                </div>

                <!-- Commission Modal -->
                <div class="modal fade" id="commModal<?= $v['id'] ?>" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content border-0 shadow-lg" style="border-radius:12px;">
                      <div class="modal-header bg-dark text-white py-2 px-3">
                        <h6 class="modal-title font-weight-bold mb-0">Commission: <?= htmlspecialchars($v['business_name']) ?></h6>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                      </div>
                      <form method="post" action="<?= base_url('admin/vendors/commission/'.$v['id']) ?>">
                        <?= csrf_field() ?>
                        <div class="modal-body p-3 text-left">
                          <div class="form-group mb-2">
                            <label class="small font-weight-bold">Split Type</label>
                            <select name="commission_type" class="form-control form-control-sm font-weight-bold">
                              <option value="percent" <?= ($v['commission_type']??'percent')==='percent'?'selected':'' ?>>Percentage (%) of Order Subtotal</option>
                              <option value="flat" <?= ($v['commission_type']??'')==='flat'?'selected':'' ?>>Flat Rate (₹ per item)</option>
                            </select>
                          </div>
                          <div class="form-group mb-0">
                            <label class="small font-weight-bold">Commission Value</label>
                            <input type="number" step="0.01" min="0" max="100" name="commission_value" class="form-control form-control-sm font-weight-bold" value="<?= $v['commission_value'] ?? 15 ?>">
                          </div>
                        </div>
                        <div class="modal-footer py-2 px-3">
                          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3">Save Split</button>
                        </div>
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
