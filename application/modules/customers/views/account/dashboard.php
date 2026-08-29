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
