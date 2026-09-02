</main>

<!-- 50+ Feature Spotlight Command Palette (Ctrl+K) -->
<div class="modal fade" id="adminSpotlightModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 650px; margin: 1.25rem auto;">
    <div class="modal-content border-0 shadow-2xl" style="border-radius: 16px; overflow: hidden; background: #ffffff;">
      <div class="modal-header border-0 pb-0 pt-3 px-3 d-flex align-items-center">
        <div class="input-group input-group-lg border-bottom pb-2 w-100">
          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent border-0 text-muted pl-1 pr-2"><i class="fas fa-search"></i></span>
          </div>
          <input type="text" id="spotlightSearchInput" class="form-control border-0 shadow-none font-weight-500" placeholder="Type a feature, module, setting, or command..." style="font-size: 1rem;" onkeyup="filterSpotlightFeatures(this.value)">
          <div class="input-group-append">
            <button type="button" class="close px-2" data-dismiss="modal" aria-label="Close" style="outline: none;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
      <div class="modal-body px-3 py-2" style="max-height: 420px; overflow-y: auto;" id="spotlightResultsContainer">
        <div class="small font-weight-bold text-uppercase text-muted px-2 py-1" style="font-size:0.68rem; letter-spacing:0.06em;">All 50+ NovaDrop Features & Modules</div>
        
        <div class="list-group list-group-flush" id="spotlightList">
          <!-- Commerce & Catalog -->
          <a href="<?= base_url('admin/products') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-box text-primary mr-2"></i><strong>Products Catalog</strong> <span class="badge badge-light ml-2">SKU Management</span></div>
            <span class="text-muted small">admin/products</span>
          </a>
          <a href="<?= base_url('admin/products/categories') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-tags text-primary mr-2"></i><strong>Collections & Categories</strong></div>
            <span class="text-muted small">admin/products/categories</span>
          </a>
          <a href="<?= base_url('admin/products/inventory') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-warehouse text-primary mr-2"></i><strong>Inventory Matrix & Stock Alerts</strong></div>
            <span class="text-muted small">admin/products/inventory</span>
          </a>
          <a href="<?= base_url('admin/products/import') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-file-import text-primary mr-2"></i><strong>CSV Catalog Importer</strong></div>
            <span class="text-muted small">admin/products/import</span>
          </a>
          <a href="<?= base_url('admin/products/reviews') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-star text-warning mr-2"></i><strong>Product Reviews Moderation</strong></div>
            <span class="text-muted small">admin/products/reviews</span>
          </a>
          <a href="<?= base_url('admin/orders') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-shopping-cart text-success mr-2"></i><strong>Customer Orders & Fulfillment</strong></div>
            <span class="text-muted small">admin/orders</span>
          </a>
          <a href="<?= base_url('admin/finance') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-credit-card text-success mr-2"></i><strong>Payments & Captured Revenue</strong></div>
            <span class="text-muted small">admin/finance</span>
          </a>

          <!-- Multi-Vendor Marketplace -->
          <a href="<?= base_url('admin/vendors') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-store text-emerald-500 mr-2"></i><strong>Multi-Vendor Marketplace Hub</strong> <span class="badge badge-success ml-2">Marketplace</span></div>
            <span class="text-muted small">admin/vendors</span>
          </a>
          <a href="<?= base_url('admin/vendors/payouts') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-hand-holding-usd text-emerald-500 mr-2"></i><strong>Vendor Commissions & Payouts</strong></div>
            <span class="text-muted small">admin/vendors/payouts</span>
          </a>

          <!-- Customers & Loyalty -->
          <a href="<?= base_url('admin/customers') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-users text-info mr-2"></i><strong>Customer 360 Directory</strong></div>
            <span class="text-muted small">admin/customers</span>
          </a>
          <a href="<?= base_url('admin/loyalty') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-crown text-warning mr-2"></i><strong>Loyalty Points & VIP Tiers</strong></div>
            <span class="text-muted small">admin/loyalty</span>
          </a>
          <a href="<?= base_url('admin/loyalty/spin_wheels') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-dharmachakra text-warning mr-2"></i><strong>Gamified Spin-the-Wheel</strong></div>
            <span class="text-muted small">admin/loyalty/spin_wheels</span>
          </a>
          <a href="<?= base_url('admin/loyalty/gamification') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-medal text-warning mr-2"></i><strong>Gamification Badges & Streaks</strong></div>
            <span class="text-muted small">admin/loyalty/gamification</span>
          </a>
          <a href="<?= base_url('admin/subscriptions') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-sync-alt text-success mr-2"></i><strong>Recurring Subscriptions & Boxes</strong> <span class="badge badge-success ml-2">MRR</span></div>
            <span class="text-muted small">admin/subscriptions</span>
          </a>
          <a href="<?= base_url('admin/affiliates') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-handshake text-info mr-2"></i><strong>Affiliate & Influencer Referral Tracking</strong></div>
            <span class="text-muted small">admin/affiliates</span>
          </a>
          <a href="<?= base_url('admin/cart_recovery') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-undo text-danger mr-2"></i><strong>Abandoned Cart Recovery Funnels</strong></div>
            <span class="text-muted small">admin/cart_recovery</span>
          </a>

          <!-- Marketing & Promos -->
          <a href="<?= base_url('admin/marketing/discounts') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-percentage text-amber-500 mr-2"></i><strong>Discount & Coupon Codes</strong></div>
            <span class="text-muted small">admin/marketing/discounts</span>
          </a>
          <a href="<?= base_url('admin/marketing/seo_studio') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-search-dollar text-amber-500 mr-2"></i><strong>SEO Studio & Google Feeds</strong></div>
            <span class="text-muted small">admin/marketing/seo_studio</span>
          </a>
          <a href="<?= base_url('admin/marketing/email_ai') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-envelope-open-text text-amber-500 mr-2"></i><strong>AI Email Campaign Studio</strong></div>
            <span class="text-muted small">admin/marketing/email_ai</span>
          </a>
          <a href="<?= base_url('admin/marketing/ad_generator') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-ad text-amber-500 mr-2"></i><strong>AI Ad Copy Generator</strong></div>
            <span class="text-muted small">admin/marketing/ad_generator</span>
          </a>
          <a href="<?= base_url('admin/promotions/flash_sales') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-bolt text-warning mr-2"></i><strong>Flash Sales Engine</strong></div>
            <span class="text-muted small">admin/promotions/flash_sales</span>
          </a>
          <a href="<?= base_url('admin/promotions/bundles') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-layer-group text-primary mr-2"></i><strong>Product Mix-and-Match Bundles</strong></div>
            <span class="text-muted small">admin/promotions/bundles</span>
          </a>
          <a href="<?= base_url('admin/promotions/mystery_drops') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-gift text-purple mr-2"></i><strong>Mystery Blind Boxes & Capsule Drops</strong></div>
            <span class="text-muted small">admin/promotions/mystery_drops</span>
          </a>
          <a href="<?= base_url('admin/promotions/pre_orders') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-hourglass-start text-info mr-2"></i><strong>Pre-Order Launchpad</strong></div>
            <span class="text-muted small">admin/promotions/pre_orders</span>
          </a>
          <a href="<?= base_url('admin/promotions/group_buying') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-user-friends text-success mr-2"></i><strong>Group Buying Campaigns</strong></div>
            <span class="text-muted small">admin/promotions/group_buying</span>
          </a>

          <!-- AI Autonomous Engine -->
          <a href="<?= base_url('admin/ai') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-microchip text-primary mr-2"></i><strong>AI Agent Orchestrator & Task Queue</strong> <span class="badge badge-primary ml-2">Autonomous</span></div>
            <span class="text-muted small">admin/ai</span>
          </a>
          <a href="<?= base_url('admin/ai/swarm') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-network-wired text-primary mr-2"></i><strong>5-Agent Swarm Telemetry</strong></div>
            <span class="text-muted small">admin/ai/swarm</span>
          </a>
          <a href="<?= base_url('admin/ai/repricer') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-chart-line text-success mr-2"></i><strong>Dynamic Repricer & Elasticity Engine</strong></div>
            <span class="text-muted small">admin/ai/repricer</span>
          </a>
          <a href="<?= base_url('admin/ai/autopilot') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-fighter-jet text-danger mr-2"></i><strong>24/7 Commerce Autopilot</strong></div>
            <span class="text-muted small">admin/ai/autopilot</span>
          </a>

          <!-- Intelligence & System -->
          <a href="<?= base_url('admin/analytics') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-chart-pie text-violet-500 mr-2"></i><strong>Analytics & Sales Performance Reports</strong></div>
            <span class="text-muted small">admin/analytics</span>
          </a>
          <a href="<?= base_url('admin/whatsapp') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-headset text-success mr-2"></i><strong>WhatsApp Support Desk & Broadcasts</strong></div>
            <span class="text-muted small">admin/whatsapp</span>
          </a>
          <a href="<?= base_url('admin/audit') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-shield-alt text-warning mr-2"></i><strong>Security Audit Trail & Event Stream</strong></div>
            <span class="text-muted small">admin/audit</span>
          </a>
          <a href="<?= base_url('admin/settings') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-sliders-h text-secondary mr-2"></i><strong>Store Appearance & Branding Settings</strong></div>
            <span class="text-muted small">admin/settings</span>
          </a>
          <a href="<?= base_url('admin/settings/pages') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-file-alt text-secondary mr-2"></i><strong>CMS Pages & Policies</strong></div>
            <span class="text-muted small">admin/settings/pages</span>
          </a>
          <a href="<?= base_url('admin/settings/faq') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-question-circle text-secondary mr-2"></i><strong>FAQ Knowledge Base</strong></div>
            <span class="text-muted small">admin/settings/faq</span>
          </a>
          <a href="<?= base_url('admin/settings/announcements') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-scroll text-secondary mr-2"></i><strong>Announcement Banner Manager</strong></div>
            <span class="text-muted small">admin/settings/announcements</span>
          </a>
          <a href="<?= base_url('admin/settings/health') ?>" class="list-group-item list-group-item-action border-0 rounded px-2 py-2 mb-1 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2"><i class="fas fa-heartbeat text-danger mr-2"></i><strong>System Diagnostics & Autonomous Self-Healing</strong></div>
            <span class="text-muted small">admin/settings/health</span>
          </a>
        </div>
      </div>
      <div class="modal-footer border-top px-3 py-2 bg-light d-flex justify-content-between align-items-center">
        <div class="small text-muted"><span class="badge badge-secondary">ESC</span> to exit</div>
        <div class="small text-muted font-weight-bold">50+ active modules</div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="<?= base_url('assets/js/script.js') ?>"></script>

<script>
// Mobile Drawer Controller
function openAdminMobileDrawer() {
  document.getElementById('adminMobileBackdrop').classList.add('show');
  document.getElementById('adminMobileDrawer').classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeAdminMobileDrawer() {
  document.getElementById('adminMobileBackdrop').classList.remove('show');
  document.getElementById('adminMobileDrawer').classList.remove('show');
  document.body.style.overflow = '';
}

// Spotlight Search Functions
function openAdminSpotlight() {
  $('#adminSpotlightModal').modal('show');
  setTimeout(function() {
    $('#spotlightSearchInput').focus().val('');
    filterSpotlightFeatures('');
  }, 250);
}

// Global Ctrl+K / Cmd+K listener
document.addEventListener('keydown', function(e) {
  if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
    e.preventDefault();
    openAdminSpotlight();
  }
  if (e.key === 'Escape') {
    closeAdminMobileDrawer();
  }
});

function filterSpotlightFeatures(query) {
  var filter = query.toLowerCase();
  var items = document.querySelectorAll('#spotlightList a');
  items.forEach(function(item) {
    var text = item.textContent.toLowerCase();
    if (text.indexOf(filter) > -1) {
      item.style.display = 'flex';
    } else {
      item.style.display = 'none';
    }
  });
}

// Dark/Light Mode Switcher with persistence
function toggleMode() {
  var body = document.body;
  if (body.classList.contains('dark-mode')) {
    body.classList.remove('dark-mode');
    body.classList.add('light-mode');
    localStorage.setItem('novadrop_admin_theme', 'light-mode');
  } else {
    body.classList.remove('light-mode');
    body.classList.add('dark-mode');
    localStorage.setItem('novadrop_admin_theme', 'dark-mode');
  }
}

// Restore saved theme on page load
(function() {
  var savedTheme = localStorage.getItem('novadrop_admin_theme');
  if (savedTheme) {
    document.body.classList.remove('light-mode', 'dark-mode');
    document.body.classList.add(savedTheme);
  }
})();

// Auto-dismiss flash alerts
document.querySelectorAll('.alert').forEach(function(el) {
  setTimeout(function() {
    el.style.transition = 'opacity 0.5s';
    el.style.opacity = '0';
    setTimeout(function() { el.remove(); }, 500);
  }, 4000);
});
</script>
</body>
</html>
