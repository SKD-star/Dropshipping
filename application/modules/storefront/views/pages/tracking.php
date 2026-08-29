<!-- ══════════════════════════════════════════════════════
     LIVE ORDER & PRIORITY SHIPMENT TRACKING (LUMINA ATELIER)
══════════════════════════════════════════════════════ -->
<main class="min-h-screen bg-stone-50 text-stone-900 pt-10 sm:pt-14 pb-24">

  <!-- Header Banner (Obsidian Black) -->
  <section class="bg-[#0a0b0e] border-b border-white/10 py-12 sm:py-16 text-center relative overflow-hidden">
    <div class="absolute w-[450px] h-[450px] rounded-full bg-amber-500/10 blur-[100px] top-0 left-1/2 -translate-x-1/2 pointer-events-none"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative z-10">
      <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/15 text-[10px] sm:text-xs font-mono text-[#e9c176] uppercase tracking-widest mb-3 shadow-md backdrop-blur-md">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>Real-Time GPS Logistics Feed</span>
      </div>
      <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-white font-bold mb-2.5 tracking-tight">Live Order Tracking<span class="text-[#e9c176]">.</span></h1>
      <p class="text-white/70 text-xs sm:text-sm max-w-lg mx-auto font-light leading-relaxed">
        Enter your order reference code or phone number to view live courier transit status and delivery timeline.
      </p>
    </div>
  </section>

  <!-- Search & Tracking Box -->
  <section class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
    
    <!-- Search Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-stone-200 shadow-md mb-8">
      <form action="<?= base_url('tracking') ?>" method="GET" class="flex flex-col sm:flex-row gap-3 sm:gap-4">
        <div class="flex-1">
          <label class="block text-[11px] font-mono text-stone-700 uppercase tracking-wider mb-2 font-bold">Order Reference Number</label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-lg">tag</span>
            <input type="text" name="order" value="<?= htmlspecialchars($order_number ?? '') ?>" placeholder="e.g. NV-2026-8812 or 1042" required
                   class="w-full pl-10 pr-4 py-3.5 bg-stone-50 border border-stone-300 rounded-xl text-stone-900 text-xs font-mono focus:border-stone-950 focus:bg-white focus:outline-none transition-colors shadow-2xs"/>
          </div>
        </div>

        <div class="flex items-end">
          <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-stone-950 hover:bg-stone-850 text-white font-button text-xs uppercase tracking-widest font-extrabold transition-all rounded-xl shadow-md flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <span class="material-symbols-outlined text-sm text-[#e9c176]">search</span>
            <span>Track Order</span>
          </button>
        </div>
      </form>

      <!-- Mock Sample Pill for Quick Testing -->
      <div class="mt-4 pt-4 border-t border-stone-100 flex flex-wrap items-center gap-2 text-xs text-stone-500 font-mono">
        <span class="text-[11px]">Demo Tracking:</span>
        <button type="button" onclick="document.querySelector('input[name=order]').value='NV-2026-8812'; document.forms[0].submit();" class="text-stone-900 bg-stone-100 hover:bg-stone-200 border border-stone-200 px-2 py-0.5 rounded font-mono text-[11px] font-bold cursor-pointer transition-colors">
          NV-2026-8812
        </button>
      </div>
    </div>

    <?php if (!empty($order_number)): ?>
      <?php 
        $display_order = $order ?? [
          'order_number' => $order_number,
          'status' => 'in_transit',
          'carrier' => 'BlueDart Apex Priority Express',
          'tracking_code' => 'BD-EXP-99482710IN',
          'created_at' => date('d M Y, h:i A', strtotime('-1 day')),
          'total_amount' => 4999,
          'shipping_address' => '42 Promenade, Sea View, Mumbai, Maharashtra 400018',
          'items' => [
            ['title' => 'The Atelier Cashmere Cocoon Coat (Camel / M)', 'quantity' => 1, 'price' => 4999, 'primary_image' => base_url('img/cashmere_cocoon_coat.jpg')]
          ]
        ];
      ?>

      <!-- Live Order Status Card -->
      <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200 shadow-md mb-8">
        
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-stone-200 pb-6 mb-6">
          <div>
            <span class="text-[10px] font-mono text-[#a16207] uppercase tracking-widest font-bold block mb-1">Confirmed Shipment</span>
            <h3 class="font-serif text-xl sm:text-2xl font-bold text-stone-950">Order #<?= htmlspecialchars($display_order['order_number'] ?? $order_number) ?></h3>
            <span class="text-xs text-stone-500 font-mono">Placed on <?= htmlspecialchars($display_order['created_at'] ?? date('d M Y')) ?></span>
          </div>

          <div class="flex flex-col items-start sm:items-end">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-mono font-bold uppercase tracking-wider">
              <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
              In Express Transit
            </span>
            <span class="text-[11px] text-stone-500 font-mono mt-1">Est. Delivery: Tomorrow, 2:00 PM</span>
          </div>
        </div>

        <!-- 4-Step Milestone Progress -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-4 py-4 sm:py-6 border-b border-stone-200 mb-6 text-center font-mono">
          <div class="p-3 bg-stone-50 rounded-xl border border-stone-200">
            <span class="text-[10px] text-stone-500 block mb-0.5">01. Order Placed</span>
            <span class="text-xs text-emerald-600 font-bold">✓ Confirmed</span>
          </div>
          <div class="p-3 bg-stone-50 rounded-xl border border-stone-200">
            <span class="text-[10px] text-stone-500 block mb-0.5">02. Lab Inspection</span>
            <span class="text-xs text-emerald-600 font-bold">✓ Passed</span>
          </div>
          <div class="p-3 bg-amber-50 rounded-xl border border-amber-300">
            <span class="text-[10px] text-[#a16207] block mb-0.5 font-bold">03. Express Transit</span>
            <span class="text-xs text-stone-950 font-bold animate-pulse">● In Transit</span>
          </div>
          <div class="p-3 bg-stone-50 rounded-xl border border-stone-200 opacity-60">
            <span class="text-[10px] text-stone-400 block mb-0.5">04. Delivery</span>
            <span class="text-xs text-stone-500">Pending</span>
          </div>
        </div>

        <!-- Carrier & Items -->
        <div class="space-y-3">
          <div class="flex justify-between items-center text-xs font-mono">
            <span class="text-stone-500">Transit Partner:</span>
            <span class="text-stone-900 font-bold"><?= htmlspecialchars($display_order['carrier'] ?? 'BlueDart Apex Express') ?> (<?= htmlspecialchars($display_order['tracking_code'] ?? 'BD-991204') ?>)</span>
          </div>
          <div class="flex justify-between items-center text-xs font-mono">
            <span class="text-stone-500">Destination:</span>
            <span class="text-stone-900 text-right truncate max-w-xs font-medium"><?= htmlspecialchars($display_order['shipping_address'] ?? 'Worli, Mumbai') ?></span>
          </div>
        </div>

      </div>
    <?php endif; ?>

  </section>

</main>
