<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
/* ── WhatsApp & Support Inquiries Premium UI ── */
.wa-hero {
  background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
  border-radius: 16px;
  padding: 24px 28px;
  color: #fff;
  margin-bottom: 1.5rem;
  box-shadow: 0 8px 24px rgba(5, 150, 105, 0.2);
}
.wa-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 2px 10px rgba(0,0,0,.04);
  background: #fff;
  overflow: hidden;
}
.wa-card .card-header {
  background: #fff;
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 20px;
  font-weight: 700;
  color: #1e293b;
}
.wa-bubble-preview {
  background: #e5ddd5;
  border-radius: 14px;
  padding: 20px 16px;
  min-height: 180px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  background-image: radial-gradient(#d1d5db 1px, transparent 1px);
  background-size: 16px 16px;
}
.wa-bubble {
  background: #dcf8c6;
  border-radius: 10px 10px 0 10px;
  padding: 10px 14px;
  box-shadow: 0 1px 3px rgba(0,0,0,.15);
  font-size: .88rem;
  color: #111827;
  max-width: 90%;
  align-self: flex-end;
  line-height: 1.5;
  white-space: pre-wrap;
}
.wa-template-chip {
  cursor: pointer;
  border-radius: 8px;
  padding: 6px 10px;
  font-size: .75rem;
  font-weight: 700;
  background: #f1f5f9;
  color: #334155;
  border: 1px solid #e2e8f0;
  transition: all .15s ease;
}
.wa-template-chip:hover {
  background: #059669;
  color: #fff;
  border-color: #059669;
}
.status-pill {
  font-size: .72rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 20px;
}
</style>

<div class="container-fluid py-4">

  <!-- Hero Header -->
  <div class="wa-hero d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span style="font-size:1.75rem;">📲</span>
        <h2 class="fw-bold mb-0 text-white">Support Inquiries &amp; WhatsApp CRM</h2>
      </div>
      <p class="mb-0 small" style="opacity:.85;">Manage customer service tickets and dispatch promotional broadcasts directly to shopper phones</p>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-light btn-sm font-weight-bold px-3 shadow-sm" data-toggle="modal" data-target="#newTicketModal" style="border-radius:8px;">
        <i class="fa fa-plus mr-1"></i> Log New Ticket
      </button>
      <a href="<?= base_url('admin/marketing/gateways') ?>" class="btn btn-outline-light btn-sm font-weight-bold px-3" style="border-radius:8px;">
        <i class="fa fa-cog mr-1"></i> Gateway Config
      </a>
    </div>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4">
    <i class="fa fa-check-circle mr-2"></i><?= htmlspecialchars($this->session->flashdata('success')) ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php endif; ?>

  <div class="row g-4">
    
    <!-- Tickets List Table -->
    <div class="col-lg-7">
      <div class="wa-card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <i class="fa fa-headset text-success mr-2"></i>
            <span>Customer Support Tickets</span>
          </div>
          <span class="badge badge-success badge-pill"><?= count($tickets) ?> Total Inquiries</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="px-3">Ticket ID</th>
                  <th>Customer</th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th class="text-right pr-3">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($tickets)): ?>
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                    <div style="font-size:2.2rem;">🎧</div>
                    <div class="mt-2 font-weight-bold">No open customer support tickets.</div>
                    <small class="text-muted">Inquiries sent through your storefront contact form appear here.</small>
                  </td>
                </tr>
                <?php else: foreach ($tickets as $t):
                  $st = strtolower($t['status'] ?? 'open');
                  $st_class = ($st === 'resolved' || $st === 'closed') ? 'badge-success' : (($st === 'in_progress') ? 'badge-info' : 'badge-warning text-dark');
                ?>
                <tr>
                  <td class="px-3">
                    <code class="font-weight-bold text-dark"><?= htmlspecialchars($t['tid'] ?? ('#'.$t['id'])) ?></code>
                    <div class="text-muted" style="font-size:.7rem;"><?= !empty($t['created_at']) ? date('d M Y', strtotime($t['created_at'])) : '—' ?></div>
                  </td>
                  <td>
                    <div class="fw-bold text-dark"><?= htmlspecialchars($t['name'] ?? 'Guest Customer') ?></div>
                    <div class="small text-muted"><?= htmlspecialchars($t['email'] ?? '—') ?></div>
                  </td>
                  <td>
                    <div class="small font-weight-bold"><?= htmlspecialchars(mb_strimwidth($t['subject'] ?? 'Inquiry', 0, 45, '…')) ?></div>
                  </td>
                  <td>
                    <span class="badge <?= $st_class ?>"><?= ucfirst(htmlspecialchars($st)) ?></span>
                  </td>
                  <td class="text-right pr-3">
                    <form method="post" action="<?= base_url('admin/whatsapp') ?>" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="action_type" value="update_ticket">
                      <input type="hidden" name="ticket_id" value="<?= $t['id'] ?>">
                      <?php if ($st !== 'resolved'): ?>
                        <input type="hidden" name="status" value="resolved">
                        <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2" title="Mark Resolved">
                          <i class="fa fa-check"></i>
                        </button>
                      <?php else: ?>
                        <input type="hidden" name="status" value="open">
                        <button type="submit" class="btn btn-sm btn-outline-secondary py-1 px-2" title="Reopen">
                          <i class="fa fa-redo"></i>
                        </button>
                      <?php endif; ?>
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

    <!-- WhatsApp & CRM Broadcast Panel -->
    <div class="col-lg-5">
      <div class="wa-card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div>
            <i class="fab fa-whatsapp text-success mr-2"></i>
            <span>WhatsApp Campaign Broadcast</span>
          </div>
          <span class="badge badge-light border small"><i class="fa fa-users mr-1"></i><?= number_format($total_customers) ?> Shoppers</span>
        </div>
        <div class="card-body p-4">
          
          <!-- Preset Message Templates -->
          <div class="mb-3">
            <label class="font-weight-bold small text-muted d-block mb-1">⚡ 1-Click Message Templates:</label>
            <div class="d-flex flex-wrap gap-1">
              <span class="wa-template-chip" onclick="setBroadcastTemplate('drop')">🔥 Flash Drop</span>
              <span class="wa-template-chip" onclick="setBroadcastTemplate('vip')">💎 VIP Code</span>
              <span class="wa-template-chip" onclick="setBroadcastTemplate('cart')">🛒 Cart Nudge</span>
              <span class="wa-template-chip" onclick="setBroadcastTemplate('tracker')">📦 Order Update</span>
            </div>
          </div>

          <form method="post" action="<?= base_url('admin/whatsapp') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="action_type" value="send_broadcast">

            <div class="form-group mb-3">
              <label class="font-weight-bold small">Target Audience Group:</label>
              <select name="audience_group" class="form-control form-control-sm">
                <option value="All Registered Customers">All Registered Customers (<?= number_format($total_customers) ?> shoppers)</option>
                <option value="VIP Buyers (Order value > ₹5,000)">VIP Buyers (High Lifetime Value)</option>
                <option value="Cart Abandoners (Last 24 hours)">Cart Abandoners (Auto-Nudge)</option>
                <option value="Repeat Shoppers (2+ Orders)">Loyal Repeat Buyers</option>
              </select>
            </div>

            <div class="form-group mb-3">
              <div class="d-flex justify-content-between">
                <label class="font-weight-bold small">Broadcast Message:</label>
                <span id="charCounter" class="text-muted small">0 chars</span>
              </div>
              <textarea id="broadcastText" name="broadcast_message" class="form-control font-monospace" rows="4" style="font-size:.85rem;" required placeholder="✦ NovaDrop Special Release: Enjoy complimentary express shipping with promo code NOVA50..." oninput="updateBubblePreview()"></textarea>
            </div>

            <!-- WhatsApp Live Bubble Preview -->
            <div class="mb-3">
              <label class="font-weight-bold small text-muted mb-1"><i class="fa fa-mobile-alt mr-1"></i> Customer Chat Bubble Preview:</label>
              <div class="wa-bubble-preview">
                <div id="waBubbleContent" class="wa-bubble">✦ NovaDrop Special Release: Enjoy complimentary express shipping with promo code NOVA50...</div>
              </div>
            </div>

            <button type="submit" class="btn btn-success btn-block font-weight-bold py-2 shadow-sm" style="border-radius:8px;">
              <i class="fab fa-whatsapp mr-1"></i> Dispatch WhatsApp Broadcast
            </button>
          </form>

        </div>
      </div>
    </div>

  </div>

</div>

<!-- Log Ticket Modal -->
<div class="modal fade" id="newTicketModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="fa fa-ticket-alt mr-2"></i>Log Support Ticket</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" action="<?= base_url('admin/whatsapp') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="action_type" value="create_ticket">
        <div class="modal-body">
          <div class="form-group">
            <label class="font-weight-bold small">Customer Name *</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Rahul Sharma">
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Customer Email *</label>
            <input type="email" name="email" class="form-control" required placeholder="rahul@example.com">
          </div>
          <div class="form-group">
            <label class="font-weight-bold small">Inquiry Subject / Issue *</label>
            <textarea name="subject" class="form-control" rows="3" required placeholder="Order delivery query, size exchange request, etc..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success font-weight-bold px-4">Create Ticket</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function updateBubblePreview() {
  var text = document.getElementById('broadcastText').value;
  var bubble = document.getElementById('waBubbleContent');
  var counter = document.getElementById('charCounter');
  
  if (text.trim() === '') {
    bubble.innerText = '✦ NovaDrop Special Release: Enjoy complimentary express shipping with promo code NOVA50...';
    counter.innerText = '0 chars';
  } else {
    bubble.innerText = text;
    counter.innerText = text.length + ' chars';
  }
}

function setBroadcastTemplate(type) {
  var tArea = document.getElementById('broadcastText');
  if (type === 'drop') {
    tArea.value = "🔥 *NovaDrop New Release Alert!*\n\nOur latest graphic streetwear drop is officially live. Limited quantities available.\n\n👉 Shop now: https://novadrop.in/shop\nUse code: *DROP10* for 10% OFF!";
  } else if (type === 'vip') {
    tArea.value = "💎 *Exclusive VIP Treat from NovaDrop*\n\nHey there! As a valued shopper, we've unlocked a secret ₹250 wallet credit for your next checkout.\n\nUse Code: *VIPSECRET250* at checkout.\nValid for 48 hours only!";
  } else if (type === 'cart') {
    tArea.value = "🛒 *Did you forget something?*\n\nYour selected items are still reserved in your NovaDrop cart. Complete your order today and get free express shipping!\n\nFinish checkout: https://novadrop.in/cart";
  } else if (type === 'tracker') {
    tArea.value = "📦 *NovaDrop Order Tracking Update*\n\nGood news! Your package is packed and dispatched with our courier partner. Track your parcel live anytime on your customer account dashboard.";
  }
  updateBubblePreview();
}

document.addEventListener('DOMContentLoaded', function(){
  var tArea = document.getElementById('broadcastText');
  if (!tArea.value) {
    setBroadcastTemplate('drop');
  } else {
    updateBubblePreview();
  }
});
</script>
