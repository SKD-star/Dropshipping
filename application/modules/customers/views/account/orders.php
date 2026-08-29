<div class="flex-grow pt-8 flex max-w-container-max mx-auto w-full px-margin-mobile md:px-margin-desktop gap-gutter pb-stack-lg min-h-[70vh]">
  
  <!-- Sidebar Navigation (Desktop) -->
  <aside class="hidden md:block w-64 shrink-0">
    <div class="sticky top-[120px] liquid-glass p-6 rounded-DEFAULT border border-outline-variant/50">
      <span class="font-label-caps text-[10px] text-accent uppercase tracking-widest block mb-1 font-semibold">Atelier Member</span>
      <h2 class="font-headline-sm text-xl text-primary font-serif mb-4">Account Portal</h2>
      <nav class="flex flex-col gap-2 text-xs font-label-caps uppercase tracking-wider">
        <a class="text-on-surface-variant hover:text-primary transition-colors py-2" href="<?= base_url('account') ?>">Profile</a>
        <a class="text-primary font-bold flex items-center gap-2 py-2 border-l-2 border-primary pl-3 bg-surface-container/60 rounded-r" href="<?= base_url('account/orders') ?>">
          <span class="material-symbols-outlined text-sm text-accent">local_shipping</span>
          <span>Tracking &amp; Orders</span>
        </a>
        <a class="text-on-surface-variant hover:text-primary transition-colors py-2" href="<?= base_url('account/wishlist') ?>">Saved Capsules</a>
        <a class="text-on-surface-variant hover:text-red-600 transition-colors py-2 border-t border-outline-variant/30 mt-2 pt-3" href="<?= base_url('account/logout') ?>">Logout</a>
      </nav>
    </div>
  </aside>

  <!-- Main Content Canvas -->
  <div class="flex-grow min-w-0 flex flex-col gap-6">
    
    <!-- Track Order Search Section -->
    <section class="liquid-glass p-6 md:p-8 rounded-DEFAULT border border-outline-variant/50">
      <div class="max-w-2xl">
        <span class="font-label-caps text-xs text-accent uppercase tracking-widest block mb-1 font-semibold">Insured Logistics</span>
        <h1 class="font-headline-md text-2xl md:text-3xl text-primary font-serif mb-2">Track Atelier Shipments</h1>
        <p class="text-xs text-on-surface-variant mb-6 font-light">Inspect white-glove transport status, quality inspections, and estimated delivery dates.</p>
        
        <form method="get" action="<?= base_url('account/orders') ?>" class="flex gap-3 items-end">
          <div class="flex-grow relative">
            <label class="font-label-caps text-[10px] uppercase tracking-wider text-on-surface-variant block mb-1">Order / Tracking Number</label>
            <input class="input-line w-full text-xs bg-surface px-3 py-2.5 border border-outline-variant outline-none" name="q" placeholder="e.g. LUM-84920" type="text" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"/>
          </div>
          <button type="submit" class="bg-primary text-white font-button text-xs uppercase tracking-widest px-6 py-2.5 hover:bg-secondary transition-colors shadow-lg cursor-pointer">
            Track Shipment
          </button>
        </form>
      </div>
    </section>

    <!-- Active Shipment Timeline (If orders exist) -->
    <?php $latest = $orders[0] ?? null; ?>
    <?php if ($latest): ?>
    <section class="liquid-glass p-6 md:p-8 rounded-DEFAULT border border-outline-variant/50">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-6 gap-2">
        <div>
          <span class="text-[10px] font-label-caps text-accent uppercase tracking-widest block font-semibold">Active Dispatch</span>
          <h2 class="font-headline-sm text-xl text-primary font-serif">Order #<?= htmlspecialchars($latest['order_number']) ?></h2>
          <p class="text-xs text-on-surface-variant mt-0.5">Placed on <?= date('d M Y', strtotime($latest['created_at'])) ?></p>
        </div>
        <span class="text-xs font-bold text-emerald-700 bg-emerald-500/10 px-3 py-1 rounded-full uppercase tracking-wider font-label-caps">
          ● <?= ucfirst($latest['status']) ?>
        </span>
      </div>

      <!-- Live Node Timeline -->
      <div class="py-6 px-2">
        <div class="grid grid-cols-4 gap-2 text-center relative">
          <!-- Step 1 -->
          <div class="flex flex-col items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-primary text-white text-xs flex items-center justify-center shadow-lg font-bold">✓</div>
            <span class="font-serif text-xs font-bold text-primary">Atelier Created</span>
            <span class="text-[10px] text-on-surface-variant"><?= date('d M', strtotime($latest['created_at'])) ?></span>
          </div>

          <!-- Step 2 -->
          <div class="flex flex-col items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-primary text-white text-xs flex items-center justify-center shadow-lg font-bold">✓</div>
            <span class="font-serif text-xs font-bold text-primary">Craft Inspected</span>
            <span class="text-[10px] text-on-surface-variant">Verified</span>
          </div>

          <!-- Step 3 -->
          <div class="flex flex-col items-center gap-2">
            <div class="w-8 h-8 rounded-full <?= in_array($latest['status'], ['shipped', 'delivered']) ? 'bg-primary text-white' : 'bg-surface border-2 border-accent text-accent animate-pulse' ?> text-xs flex items-center justify-center shadow-lg font-bold">
              <?= in_array($latest['status'], ['shipped', 'delivered']) ? '✓' : '3' ?>
            </div>
            <span class="font-serif text-xs font-bold text-primary">White-Glove Transit</span>
            <span class="text-[10px] text-accent font-semibold">Express Courier</span>
          </div>

          <!-- Step 4 -->
          <div class="flex flex-col items-center gap-2">
            <div class="w-8 h-8 rounded-full <?= $latest['status'] === 'delivered' ? 'bg-primary text-white' : 'bg-surface border-2 border-outline-variant text-stone-400' ?> text-xs flex items-center justify-center font-bold">
              <?= $latest['status'] === 'delivered' ? '✓' : '4' ?>
            </div>
            <span class="font-serif text-xs font-bold text-stone-500">Delivered</span>
            <span class="text-[10px] text-on-surface-variant"><?= $latest['status'] === 'delivered' ? 'Completed' : 'Estimated 2 Days' ?></span>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- Recent Orders History Grid -->
    <section class="liquid-glass p-6 md:p-8 rounded-DEFAULT border border-outline-variant/50">
      <h2 class="font-headline-sm text-xl text-primary font-serif mb-4">Acquisition History</h2>
      
      <?php if (empty($orders)): ?>
        <div class="p-12 text-center text-on-surface-variant border border-dashed border-outline-variant/60 rounded">
          <p class="text-xs mb-4">No order history recorded yet in your atelier portfolio.</p>
          <a href="<?= base_url('shop') ?>" class="bg-primary text-white px-6 py-2.5 text-xs font-button uppercase tracking-wider inline-block">
            Discover Collection →
          </a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach ($orders as $o): ?>
          <div class="border border-outline-variant/40 p-4 rounded-DEFAULT bg-surface flex flex-col justify-between gap-3 hover:border-primary transition-colors">
            <div class="flex justify-between items-start">
              <div>
                <p class="font-mono text-xs font-bold text-primary"><?= htmlspecialchars($o['order_number']) ?></p>
                <p class="text-[11px] text-on-surface-variant mt-0.5"><?= date('d M Y', strtotime($o['created_at'])) ?></p>
              </div>
              <span class="text-[10px] font-bold uppercase tracking-wider text-accent bg-amber-500/10 px-2 py-0.5 rounded"><?= $o['status'] ?></span>
            </div>
            <div class="flex justify-between items-center text-xs border-t border-outline-variant/30 pt-3">
              <span class="font-serif font-bold text-primary">₹<?= number_format($o['total'], 0) ?></span>
              <a href="<?= base_url('account/order/' . $o['order_number']) ?>" class="text-xs uppercase font-semibold text-primary hover:underline">
                Receipt →
              </a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>

  </div>

</div>
