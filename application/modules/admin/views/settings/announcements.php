<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── Dynamic Announcement Banners Premium UI ── */
.ann-hero {
  background: linear-gradient(135deg, #d97706 0%, #ea580c 50%, #f59e0b 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 24px rgba(217, 119, 6, 0.2);
}
.ann-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 10px rgba(0,0,0,.04);
  background: #fff;
  overflow: hidden;
}
.ann-card .card-header {
  background: #fff;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 20px;
  font-weight: 700;
  color: #1e293b;
}
.ann-pill {
  display: inline-flex;
  padding: 6px 14px;
  border-radius: 8px;
  align-items: center;
  gap: 8px;
  font-size: .88rem;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(0,0,0,.06);
}
</style>

<div class="container-fluid px-3 px-md-4 py-3">

  <!-- Hero Header -->
  <div class="ann-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.75rem;">📢</span>
        <h3 class="fw-bold mb-0 text-white font-weight-bold">Dynamic Announcement Banners</h3>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Display scheduled promotional alerts, discount countdowns &amp; flash notices across your storefront top bar</p>
    </div>
    <button type="button" class="btn btn-light btn-sm font-weight-bold px-3 shadow-sm" onclick="openNewBannerModal()" style="border-radius:8px;">
      <i class="fa fa-plus mr-1"></i> New Banner
    </button>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <!-- Banners Table -->
  <div class="ann-card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span><i class="fa fa-bullhorn text-warning mr-2"></i>Active &amp; Scheduled Banners</span>
      <span class="badge badge-warning text-dark font-weight-bold"><?= count($announcements) ?> Banners</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="bg-light">
            <tr>
              <th class="px-3">Banner Message &amp; Visual Preview</th>
              <th>Destination Link</th>
              <th>Schedule</th>
              <th>Status</th>
              <th class="text-right pr-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($announcements)): ?>
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">
                <div style="font-size:2.2rem;">📢</div>
                <div class="mt-2 font-weight-bold">No announcement banners created yet.</div>
                <small class="text-muted">Click "New Banner" above to publish your first site-wide announcement.</small>
              </td>
            </tr>
            <?php else: foreach ($announcements as $ann): 
              $msg = $ann['message'] ?? ($ann['text'] ?? ($ann['content'] ?? ($ann['announcement_text'] ?? ($ann['title'] ?? 'Store Announcement Banner'))));
              if (empty($msg)) $msg = '🔥 Free Express Shipping on prepaid orders above ₹499!';
              $bg  = $ann['bg_color'] ?? '#4f46e5';
              $txt = $ann['text_color'] ?? '#ffffff';
              $lnk = $ann['link_url'] ?? '';
              $st  = $ann['starts_at'] ?? '';
              $en  = $ann['ends_at'] ?? '';
            ?>
            <tr>
              <td class="px-3">
                <div class="ann-pill" style="background:<?= $bg ?>; color:<?= $txt ?>; max-width: 460px;">
                  <span class="text-truncate"><?= htmlspecialchars($msg) ?></span>
                </div>
              </td>
              <td>
                <?php if (!empty($lnk)): ?>
                  <a href="<?= htmlspecialchars($lnk) ?>" target="_blank" class="small font-mono text-decoration-none">
                    <i class="fa fa-link mr-1"></i><?= htmlspecialchars(mb_strimwidth($lnk, 0, 30, '…')) ?>
                  </a>
                <?php else: ?>
                  <span class="text-muted small">None</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="small text-dark font-weight-bold"><?= !empty($st) ? date('d M Y, H:i', strtotime($st)) : 'Immediate' ?></div>
                <div class="text-muted" style="font-size:.75rem;">to <?= !empty($en) ? date('d M Y, H:i', strtotime($en)) : 'Never expires' ?></div>
              </td>
              <td>
                <span class="badge badge-<?= ($ann['is_active'] ?? 0) ? 'success' : 'secondary' ?> px-2.5 py-1">
                  <?= ($ann['is_active'] ?? 0) ? '● Active' : 'Disabled' ?>
                </span>
              </td>
              <td class="text-right pr-3">
                <!-- Edit Button -->
                <button type="button" class="btn btn-sm btn-outline-info py-1 px-2 mr-1" title="Edit Banner" onclick='openEditBannerModal(<?= json_encode([
                  "id"         => $ann["id"],
                  "message"    => $msg,
                  "bg_color"   => $bg,
                  "text_color" => $txt,
                  "link_url"   => $lnk,
                  "starts_at"  => !empty($st) ? date("Y-m-d\TH:i", strtotime($st)) : "",
                  "ends_at"    => !empty($en) ? date("Y-m-d\TH:i", strtotime($en)) : ""
                ]) ?>)'>
                  <i class="fa fa-edit"></i>
                </button>

                <!-- Toggle Active -->
                <form method="post" action="<?= base_url('admin/settings/announcements') ?>" class="d-inline">
                  <?= csrf_field() ?>
                  <input type="hidden" name="ann_action" value="toggle">
                  <input type="hidden" name="id" value="<?= $ann['id'] ?>">
                  <button class="btn btn-sm btn-outline-<?= ($ann['is_active'] ?? 0) ? 'warning' : 'success' ?> py-1 px-2 mr-1" title="<?= ($ann['is_active'] ?? 0) ? 'Disable' : 'Enable' ?>">
                    <i class="fa <?= ($ann['is_active'] ?? 0) ? 'fa-pause' : 'fa-play' ?>"></i>
                  </button>
                </form>

                <!-- Delete -->
                <form method="post" action="<?= base_url('admin/settings/announcements') ?>" class="d-inline" onsubmit="return confirm('Delete this announcement banner?')">
                  <?= csrf_field() ?>
                  <input type="hidden" name="ann_action" value="delete">
                  <input type="hidden" name="id" value="<?= $ann['id'] ?>">
                  <button class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                    <i class="fa fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- Modal: Create / Edit Banner -->
<div class="modal fade" id="annModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title font-weight-bold" id="annModalTitle"><i class="fa fa-bullhorn mr-2"></i>Create Announcement Banner</h5>
        <button type="button" class="close text-dark" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/settings/announcements') ?>" id="annForm">
        <?= csrf_field() ?>
        <input type="hidden" name="ann_action" value="save">
        <input type="hidden" id="modalAnnId" name="id" value="0">
        <div class="modal-body">
          
          <div class="form-group">
            <label class="font-weight-bold small">Banner Message Text *</label>
            <input type="text" id="modalAnnText" name="message" class="form-control" required placeholder="⚡ Flash Sale: 20% OFF with code NOVA20!" oninput="updateModalPreview()">
          </div>

          <div class="row">
            <div class="col-6 form-group">
              <label class="font-weight-bold small">Background Color</label>
              <div class="input-group">
                <input type="color" id="modalBgColor" name="bg_color" class="form-control form-control-color" value="#4f46e5" style="max-width:55px;height:40px;padding:3px;" onchange="updateModalPreview()">
                <input type="text" id="modalBgText" class="form-control font-mono small" value="#4f46e5" oninput="document.getElementById('modalBgColor').value=this.value; updateModalPreview();">
              </div>
            </div>
            <div class="col-6 form-group">
              <label class="font-weight-bold small">Text Color</label>
              <div class="input-group">
                <input type="color" id="modalTextColor" name="text_color" class="form-control form-control-color" value="#ffffff" style="max-width:55px;height:40px;padding:3px;" onchange="updateModalPreview()">
                <input type="text" id="modalTextText" class="form-control font-mono small" value="#ffffff" oninput="document.getElementById('modalTextColor').value=this.value; updateModalPreview();">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="font-weight-bold small">Target Link URL (Optional)</label>
            <input type="text" id="modalLinkUrl" name="link_url" class="form-control font-mono" placeholder="https://... or /shop or /collections">
          </div>

          <div class="row">
            <div class="col-6 form-group">
              <label class="font-weight-bold small">Start Date/Time (Optional)</label>
              <input type="datetime-local" id="modalStartsAt" name="starts_at" class="form-control small">
            </div>
            <div class="col-6 form-group">
              <label class="font-weight-bold small">End Date/Time (Optional)</label>
              <input type="datetime-local" id="modalEndsAt" name="ends_at" class="form-control small">
            </div>
          </div>

          <!-- Live Preview Inside Modal -->
          <label class="font-weight-bold small text-muted mt-2">Live Visual Ribbon Preview:</label>
          <div id="modalPreviewBox" class="p-2.5 text-center font-weight-bold rounded-3 shadow-sm transition-all" style="background:#4f46e5; color:#ffffff; font-size:.85rem;">
            ⚡ Flash Sale: 20% OFF with code NOVA20!
          </div>

        </div>
        <div class="modal-footer bg-light p-3">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
          <button type="submit" id="modalSubmitBtn" class="btn btn-warning text-dark font-weight-bold btn-sm px-4">
            <i class="fa fa-save mr-1"></i> Save Banner
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function updateModalPreview() {
  var txt = document.getElementById('modalAnnText').value || '⚡ Sample Banner Text Preview';
  var bg  = document.getElementById('modalBgColor').value || '#4f46e5';
  var col = document.getElementById('modalTextColor').value || '#ffffff';
  
  var box = document.getElementById('modalPreviewBox');
  box.innerText = txt;
  box.style.background = bg;
  box.style.color = col;

  document.getElementById('modalBgText').value = bg;
  document.getElementById('modalTextText').value = col;
}

function openNewBannerModal() {
  document.getElementById('modalAnnId').value = '0';
  document.getElementById('modalAnnText').value = '';
  document.getElementById('modalBgColor').value = '#4f46e5';
  document.getElementById('modalTextColor').value = '#ffffff';
  document.getElementById('modalLinkUrl').value = '';
  document.getElementById('modalStartsAt').value = '';
  document.getElementById('modalEndsAt').value = '';
  document.getElementById('annModalTitle').innerHTML = '<i class="fa fa-plus-circle mr-2"></i>Create Announcement Banner';
  document.getElementById('modalSubmitBtn').innerHTML = '<i class="fa fa-save mr-1"></i> Publish Banner';
  updateModalPreview();
  $('#annModal').modal('show');
}

function openEditBannerModal(data) {
  document.getElementById('modalAnnId').value = data.id || '0';
  document.getElementById('modalAnnText').value = data.message || '';
  document.getElementById('modalBgColor').value = data.bg_color || '#4f46e5';
  document.getElementById('modalTextColor').value = data.text_color || '#ffffff';
  document.getElementById('modalLinkUrl').value = data.link_url || '';
  document.getElementById('modalStartsAt').value = data.starts_at || '';
  document.getElementById('modalEndsAt').value = data.ends_at || '';
  document.getElementById('annModalTitle').innerHTML = '<i class="fa fa-edit mr-2"></i>Edit Announcement Banner';
  document.getElementById('modalSubmitBtn').innerHTML = '<i class="fa fa-save mr-1"></i> Update Banner';
  updateModalPreview();
  $('#annModal').modal('show');
}
</script>
