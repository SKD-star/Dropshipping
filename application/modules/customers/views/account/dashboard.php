<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-md min-h-[75vh]">
  
  <!-- Header Bar -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 border-b border-outline-variant/40 pb-6 gap-4">
    <div>
      <div class="inline-flex items-center gap-2 liquid-glass px-3 py-1 rounded-full text-[10px] font-label-caps uppercase tracking-widest text-accent mb-2 font-semibold">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
        <span>Verified Atelier Collector</span>
      </div>
      <h1 class="font-headline-md text-3xl sm:text-4xl text-primary font-serif">Welcome, <?= htmlspecialchars($customer['name']) ?></h1>
      <p class="text-xs text-on-surface-variant font-light mt-1"><?= htmlspecialchars($customer['email']) ?></p>
    </div>
    
    <div class="flex items-center gap-3">
      <a href="<?= base_url('shop') ?>" class="px-5 py-2.5 bg-primary text-white font-button text-xs uppercase tracking-wider hover:bg-secondary transition-colors shadow-lg">
        Explore Capsules →
      </a>
      <a href="<?= base_url('account/logout') ?>" class="px-4 py-2.5 border border-outline-variant text-primary font-button text-xs uppercase tracking-wider hover:border-primary transition-colors">
        Sign Out
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter items-start">
    
    <!-- Left Navigation Sidebar (4 cols) -->
    <aside class="md:col-span-4 flex flex-col gap-6">
      
      <!-- Account Menu Card -->
      <div class="liquid-glass p-6 rounded-DEFAULT border border-outline-variant/50">
        <span class="font-label-caps text-[10px] text-accent uppercase tracking-widest block mb-3 font-semibold">Atelier Portfolio</span>
        <nav class="flex flex-col gap-1 text-xs font-label-caps uppercase tracking-wider">
          <a href="<?= base_url('account') ?>" class="flex items-center gap-2.5 py-2.5 px-3 rounded bg-primary text-white font-semibold">
            <span class="material-symbols-outlined text-sm text-[#e9c176]">dashboard</span>
            <span>Dashboard</span>
          </a>
          <a href="<?= base_url('account/orders') ?>" class="flex items-center gap-2.5 py-2.5 px-3 rounded text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-sm">local_shipping</span>
            <span>Tracking &amp; Orders</span>
          </a>
          <a href="<?= base_url('account/wishlist') ?>" class="flex items-center gap-2.5 py-2.5 px-3 rounded text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-sm">favorite</span>
            <span>Saved Pieces (<?= count($wishlist) ?>)</span>
          </a>
        </nav>
      </div>

      <!-- WhatsApp Concierge & Design Updates Status Card -->
      <div class="liquid-glass p-6 rounded-DEFAULT border border-outline-variant/50">
        <div class="flex items-center justify-between mb-3">
          <span class="font-label-caps text-[10px] text-emerald-600 uppercase tracking-widest font-semibold flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">chat</span>
            <span>WhatsApp Concierge</span>
          </span>
          <span class="text-[10px] bg-emerald-500/10 text-emerald-700 px-2 py-0.5 rounded font-bold">Active</span>
        </div>
        
        <p class="text-xs text-on-surface-variant font-light mb-3 leading-relaxed">
          Connected for bespoke styling consultations, real-time dispatch alerts, and seasonal lookbook releases.
        </p>

        <div class="p-3 bg-surface rounded border border-outline-variant/40 text-xs flex justify-between items-center">
          <span class="text-on-surface-variant font-light">Registered Number:</span>
          <span class="font-mono font-bold text-primary"><?= htmlspecialchars($customer['phone'] ?? '+91 (Not Set)') ?></span>
        </div>
      </div>

    </aside>

    <!-- Right Main Content Area (8 cols) -->
    <div class="md:col-span-8 flex flex-col gap-6">

      <!-- 1-Click Buy Now Preferences Card -->
      <section class="liquid-glass p-6 md:p-8 rounded-DEFAULT border border-outline-variant/50 relative overflow-hidden" id="buyNowSettingsCard">
        <div class="flex items-center justify-between gap-3 mb-4 pb-3 border-b border-outline-variant/30">
          <div>
            <span class="text-[10px] font-label-caps text-accent uppercase tracking-widest font-semibold flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#e9c176]">bolt</span>
              <span>Express Fast-Path</span>
            </span>
            <h2 class="font-headline-sm text-xl text-primary font-serif font-bold">1-Click Buy Now Setup</h2>
          </div>
          <span class="text-[11px] font-mono <?= !empty($default_address) ? 'text-emerald-700 bg-emerald-500/10 border-emerald-500/30' : 'text-amber-700 bg-amber-500/10 border-amber-500/30' ?> px-2.5 py-1 rounded-full border font-semibold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full <?= !empty($default_address) ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
            <span><?= !empty($default_address) ? 'Active' : 'Setup Required' ?></span>
          </span>
        </div>

        <p class="text-xs text-on-surface-variant font-light mb-5">
          Configure your default dispatch address and preferred payment method to activate frictionless, instant 1-Click Buy Now on all collection pieces.
        </p>

        <form id="buyNowPrefForm" onsubmit="saveBuyNowPreferences(event)" class="space-y-4">
          <!-- Default Address Selector -->
          <div>
            <label class="font-label-caps text-[11px] uppercase tracking-wider text-primary block mb-1.5 font-bold">
              Default Shipping Address
            </label>
            <?php if (!empty($addresses)): ?>
              <select name="default_address_id" id="prefAddressSelect" class="w-full text-xs bg-surface border border-outline-variant p-2.5 rounded text-primary outline-none focus:border-primary">
                <?php foreach ($addresses as $addr): ?>
                  <?php $isSel = (!empty($default_address['id']) && $default_address['id'] == $addr['id']); ?>
                  <option value="<?= (int)$addr['id'] ?>" <?= $isSel ? 'selected' : '' ?>>
                    <?= htmlspecialchars($addr['first_name'] . ' ' . $addr['last_name']) ?> — <?= htmlspecialchars($addr['address1'] . ', ' . $addr['city'] . ' (' . $addr['pincode'] . ')') ?>
                  </option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <div class="p-3 bg-surface rounded border border-dashed border-outline-variant text-xs text-on-surface-variant flex justify-between items-center">
                <span>No saved address yet. Add your primary shipping address below.</span>
                <button type="button" onclick="document.getElementById('quickAddressForm').classList.toggle('hidden')" class="text-xs font-bold text-accent uppercase hover:underline cursor-pointer">
                  + Add Address
                </button>
              </div>
            <?php endif; ?>
          </div>

          <!-- Quick Add Address Drawer (Collapsible) -->
          <div id="quickAddressForm" class="<?= empty($addresses) ? '' : 'hidden' ?> p-4 bg-surface rounded border border-outline-variant/60 space-y-3">
            <div class="font-label-caps text-[10px] text-accent uppercase tracking-wider font-bold">Add New Delivery Address</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <input type="text" id="newAddrFirst" placeholder="First Name *" class="text-xs bg-white border border-outline-variant p-2 rounded text-primary">
              <input type="text" id="newAddrLast" placeholder="Last Name" class="text-xs bg-white border border-outline-variant p-2 rounded text-primary">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <input type="text" id="newAddrPhone" placeholder="Mobile Phone (10-digit) *" class="text-xs bg-white border border-outline-variant p-2 rounded text-primary">
              <input type="text" id="newAddrPincode" placeholder="Pincode (6-digit) *" class="text-xs bg-white border border-outline-variant p-2 rounded text-primary">
            </div>
            <input type="text" id="newAddrStreet" placeholder="Flat / Building / Street Address *" class="w-full text-xs bg-white border border-outline-variant p-2 rounded text-primary">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
              <input type="text" id="newAddrCity" placeholder="City *" class="text-xs bg-white border border-outline-variant p-2 rounded text-primary">
              <input type="text" id="newAddrState" placeholder="State *" value="Maharashtra" class="text-xs bg-white border border-outline-variant p-2 rounded text-primary">
            </div>
            <button type="button" onclick="submitQuickAddress()" class="px-4 py-2 bg-primary text-white text-xs font-button uppercase tracking-wider hover:bg-secondary rounded">
              Save &amp; Set as Default
            </button>
          </div>

          <!-- Preferred Payment Method -->
          <div>
            <label class="font-label-caps text-[11px] uppercase tracking-wider text-primary block mb-1.5 font-bold">
              Preferred 1-Click Payment Mode
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
              <label class="p-3 bg-surface rounded border border-outline-variant/60 flex items-center gap-2.5 cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                <input type="radio" name="default_payment_method" value="cod" <?= ($default_payment_method ?? 'cod') === 'cod' ? 'checked' : '' ?> class="accent-primary">
                <div>
                  <span class="text-xs font-bold text-primary block">Cash on Delivery</span>
                  <span class="text-[10px] text-on-surface-variant font-light">Pay at delivery</span>
                </div>
              </label>

              <label class="p-3 bg-surface rounded border border-outline-variant/60 flex items-center gap-2.5 cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                <input type="radio" name="default_payment_method" value="razorpay" <?= ($default_payment_method ?? '') === 'razorpay' ? 'checked' : '' ?> class="accent-primary">
                <div>
                  <span class="text-xs font-bold text-primary block">Razorpay</span>
                  <span class="text-[10px] text-on-surface-variant font-light">UPI, Cards, NetBanking</span>
                </div>
              </label>

              <label class="p-3 bg-surface rounded border border-outline-variant/60 flex items-center gap-2.5 cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                <input type="radio" name="default_payment_method" value="stripe" <?= ($default_payment_method ?? '') === 'stripe' ? 'checked' : '' ?> class="accent-primary">
                <div>
                  <span class="text-xs font-bold text-primary block">Stripe</span>
                  <span class="text-[10px] text-on-surface-variant font-light">Global Credit Cards</span>
                </div>
              </label>
            </div>
          </div>

          <div class="flex items-center justify-between pt-2">
            <span id="buyNowSaveMsg" class="text-xs font-mono text-emerald-600 hidden"></span>
            <button type="submit" id="btnSaveBuyNowPref" class="ml-auto px-5 py-2.5 bg-primary hover:bg-secondary text-white font-button text-xs uppercase tracking-wider rounded transition-colors shadow-sm cursor-pointer flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm">check</span>
              <span>Save 1-Click Settings</span>
            </button>
          </div>
        </form>
      </section>

      <!-- Recent Acquisitions Card -->
      <div class="liquid-glass p-6 md:p-8 rounded-DEFAULT border border-outline-variant/50">
        <div class="flex justify-between items-center mb-6 border-b border-outline-variant/30 pb-3">
          <h2 class="font-headline-sm text-xl text-primary font-serif font-bold">Recent Acquisitions</h2>
          <a href="<?= base_url('account/orders') ?>" class="text-xs text-accent uppercase font-label-caps tracking-wider hover:underline">View All →</a>
        </div>

        <?php if (empty($orders)): ?>
          <div class="p-8 text-center text-on-surface-variant text-xs font-light">
            <span class="material-symbols-outlined text-3xl text-accent mb-2 block">shopping_bag</span>
            <p>You have not placed any orders yet in your atelier portfolio.</p>
            <a href="<?= base_url('shop') ?>" class="text-accent font-semibold hover:underline mt-2 inline-block">Explore Current Capsule →</a>
          </div>
        <?php else: ?>
          <div class="divide-y divide-outline-variant/20">
            <?php foreach ($orders as $o): ?>
            <div class="py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
              <div>
                <span class="font-mono text-xs font-bold text-primary block"><?= htmlspecialchars($o['order_number']) ?></span>
                <span class="text-[11px] text-on-surface-variant"><?= date('d M Y', strtotime($o['created_at'])) ?></span>
              </div>
              <div class="flex items-center gap-4">
                <span class="text-[10px] font-bold uppercase tracking-wider text-accent bg-amber-500/10 px-2.5 py-1 rounded">
                  ● <?= ucfirst($o['status']) ?>
                </span>
                <span class="font-serif font-bold text-primary text-sm">₹<?= number_format($o['total'], 0) ?></span>
                <a href="<?= base_url('account/orders/' . $o['id']) ?>" class="px-3 py-1.5 bg-primary text-white text-xs font-button uppercase tracking-wider hover:bg-secondary">
                  Receipt →
                </a>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Saved Wishlist Preview -->
      <?php if (!empty($wishlist)): ?>
      <div class="liquid-glass p-6 md:p-8 rounded-DEFAULT border border-outline-variant/50">
        <h2 class="font-headline-sm text-xl text-primary font-serif font-bold mb-4">Saved Wishlist Pieces</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <?php foreach (array_slice($wishlist, 0, 3) as $w): ?>
          <div class="p-3 bg-surface rounded-DEFAULT border border-outline-variant/40 group cursor-pointer" onclick="window.location='<?= base_url('products/' . $w['slug']) ?>'">
            <div class="aspect-square bg-surface-container rounded overflow-hidden mb-2">
              <img src="<?= htmlspecialchars($w['image_url'] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&q=80') ?>" alt="<?= htmlspecialchars($w['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            <h4 class="font-serif text-xs font-bold text-primary truncate"><?= htmlspecialchars($w['title']) ?></h4>
            <span class="text-xs text-accent font-semibold">₹<?= number_format($w['min_price'], 0) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

    </div>

  </div>

</div>

<script>
function saveBuyNowPreferences(e) {
  if (e) e.preventDefault();
  var form = document.getElementById('buyNowPrefForm');
  var btn = document.getElementById('btnSaveBuyNowPref');
  var msg = document.getElementById('buyNowSaveMsg');
  
  btn.disabled = true;
  btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">progress_activity</span><span>Saving...</span>';

  var fd = new FormData(form);
  fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url("account/set_default_preferences") ?>', {
    method: 'POST',
    body: fd,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(data => {
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-sm">check</span><span>Save 1-Click Settings</span>';
    if (data.success) {
      msg.textContent = '✓ Preferences updated!';
      msg.className = 'text-xs font-mono text-emerald-600 block';
      setTimeout(() => { msg.className = 'hidden'; }, 3500);
    } else {
      alert(data.error || data.message || 'Failed to update preferences.');
    }
  })
  .catch(err => {
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-sm">check</span><span>Save 1-Click Settings</span>';
    alert('Network error updating preferences.');
  });
}

function submitQuickAddress() {
  var first = document.getElementById('newAddrFirst').value.trim();
  var last = document.getElementById('newAddrLast').value.trim();
  var phone = document.getElementById('newAddrPhone').value.trim();
  var street = document.getElementById('newAddrStreet').value.trim();
  var city = document.getElementById('newAddrCity').value.trim();
  var state = document.getElementById('newAddrState').value.trim();
  var pincode = document.getElementById('newAddrPincode').value.trim();

  if (!first || !phone || !street || !city || !pincode) {
    alert('Please fill in First Name, Mobile Phone, Street, City, and Pincode.');
    return;
  }

  var fd = new FormData();
  fd.append('first_name', first);
  fd.append('last_name', last);
  fd.append('phone', phone);
  fd.append('address1', street);
  fd.append('city', city);
  fd.append('state', state);
  fd.append('pincode', pincode);
  fd.append('is_default', '1');
  fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url("account/save_address") ?>', {
    method: 'POST',
    body: fd,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      window.location.reload();
    } else {
      alert(data.error || data.message || 'Failed to save address.');
    }
  })
  .catch(() => {
    alert('Network error saving address.');
  });
}
</script>

