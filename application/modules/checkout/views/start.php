<main class="min-h-screen bg-[#faf8f5] py-8 sm:py-12">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- ── Luxury Breadcrumb & 3-Step Progress Stepper ── -->
    <div class="mb-10">
      <nav class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-stone-500 mb-6">
        <a href="<?= base_url('cart') ?>" class="hover:text-stone-950 transition-colors">Bag</a>
        <span class="text-stone-300">/</span>
        <span class="text-stone-950 font-bold border-b border-stone-950 pb-0.5">Shipping</span>
        <span class="text-stone-300">/</span>
        <span class="text-stone-400">Settlement</span>
      </nav>

      <!-- Stepper Pills with Connecting Progress Line -->
      <div class="relative max-w-2xl mx-auto">
        <div class="grid grid-cols-3 gap-3 sm:gap-4 relative z-10">
          <!-- Step 1: Active -->
          <div class="p-3 sm:p-3.5 rounded-xl bg-stone-950 text-white shadow-lg border border-stone-900 flex items-center gap-3 relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-12 h-12 bg-amber-400/20 rounded-full blur-lg pointer-events-none"></div>
            <div class="w-7 h-7 rounded-full bg-gradient-to-r from-amber-400 to-[#e9c176] text-stone-950 flex items-center justify-center text-xs font-extrabold flex-shrink-0 shadow-md">
              1
            </div>
            <div class="hidden sm:block">
              <span class="text-[9px] font-mono uppercase tracking-widest text-[#e9c176] font-bold block">Step 01 · Active</span>
              <span class="text-xs font-serif font-bold text-white">Shipping</span>
            </div>
          </div>

          <!-- Step 2: Pending -->
          <div class="p-3 sm:p-3.5 rounded-xl bg-stone-100/80 border border-stone-200 text-stone-400 flex items-center gap-3">
            <div class="w-7 h-7 rounded-full bg-stone-200 text-stone-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
              2
            </div>
            <div class="hidden sm:block">
              <span class="text-[9px] font-mono uppercase tracking-widest text-stone-400 font-medium block">Step 02</span>
              <span class="text-xs font-serif font-medium text-stone-500">Payment</span>
            </div>
          </div>

          <!-- Step 3: Pending -->
          <div class="p-3 sm:p-3.5 rounded-xl bg-stone-100/80 border border-stone-200 text-stone-400 flex items-center gap-3">
            <div class="w-7 h-7 rounded-full bg-stone-200 text-stone-500 flex items-center justify-center text-xs font-bold flex-shrink-0">
              3
            </div>
            <div class="hidden sm:block">
              <span class="text-[9px] font-mono uppercase tracking-widest text-stone-400 font-medium block">Step 03</span>
              <span class="text-xs font-serif font-medium text-stone-500">Confirmation</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      
      <!-- ── Left Form Area (7 cols) ── -->
      <div class="lg:col-span-7 flex flex-col gap-6">
        
        <form method="post" action="<?= base_url('checkout') ?>" id="checkoutForm" class="space-y-6">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

          <!-- Step 1: Client Contact -->
          <div class="p-6 sm:p-8 rounded-2xl bg-white border border-stone-200 shadow-sm">
            <div class="flex justify-between items-center mb-5 border-b border-stone-200/80 pb-4">
              <div>
                <span class="text-[10px] font-mono uppercase tracking-[0.2em] text-[#a16207] font-bold block mb-1">Identification</span>
                <h2 class="font-serif text-xl text-stone-950 font-bold">
                  Client Contact Information
                </h2>
              </div>
              <?php if (empty($customer['id'])): ?>
              <a class="text-xs font-mono uppercase tracking-wider text-[#a16207] hover:text-stone-950 font-bold border-b border-[#a16207] pb-0.5 transition-colors" href="<?= base_url('account/login?redirect=checkout') ?>">
                Sign In to Auto-Fill →
              </a>
              <?php else: ?>
              <span class="text-[10px] font-mono font-bold text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-full">
                ✓ Logged In
              </span>
              <?php endif; ?>
            </div>
            <div>
              <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">Email Address for Insured Tracking &amp; Invoices *</label>
              <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-sans" id="email" name="email" value="<?= htmlspecialchars($email ?: ($customer['email'] ?? '')) ?>" placeholder="client.name@domain.com" required type="email"/>
            </div>
          </div>

          <!-- Step 2: Destination Address -->
          <div class="p-6 sm:p-8 rounded-2xl bg-white border border-stone-200 shadow-sm">
            <div class="border-b border-stone-200/80 pb-4 mb-5">
              <span class="text-[10px] font-mono uppercase tracking-[0.2em] text-[#a16207] font-bold block mb-1">Transit Logistics</span>
              <h2 class="font-serif text-xl text-stone-950 font-bold">
                Destination Delivery Address
              </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">First Name *</label>
                <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-sans" id="first_name" name="first_name" value="<?= htmlspecialchars($shipping['first_name'] ?? ($customer['first_name'] ?? '')) ?>" placeholder="First name" required type="text"/>
              </div>
              <div>
                <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">Last Name *</label>
                <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-sans" id="last_name" name="last_name" value="<?= htmlspecialchars($shipping['last_name'] ?? ($customer['last_name'] ?? '')) ?>" placeholder="Last name" required type="text"/>
              </div>
            </div>

            <div class="mb-4">
              <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">Street Address, Suite / Apartment *</label>
              <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-sans" id="address1" name="address1" value="<?= htmlspecialchars($shipping['address1'] ?? '') ?>" placeholder="Flat/House No, Building, Street, Landmark" required type="text"/>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
              <div>
                <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">City *</label>
                <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-sans" id="city" name="city" value="<?= htmlspecialchars($shipping['city'] ?? '') ?>" placeholder="City" required type="text"/>
              </div>
              <div>
                <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">State *</label>
                <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-sans" id="state" name="state" value="<?= htmlspecialchars($shipping['state'] ?? 'Maharashtra') ?>" placeholder="State" required type="text"/>
              </div>
              <div>
                <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">PIN Code *</label>
                <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-sans font-mono" id="pincode" name="pincode" value="<?= htmlspecialchars($shipping['pincode'] ?? '') ?>" placeholder="400001" required type="text"/>
              </div>
            </div>

            <div>
              <label class="font-mono text-[11px] uppercase tracking-wider text-stone-600 block mb-1.5 font-bold">Contact Phone (For Courier Handover) *</label>
              <input class="w-full text-xs bg-stone-50 px-4 py-3 border border-stone-200 rounded-xl outline-none focus:border-stone-950 focus:bg-white transition-all font-mono" id="phone" name="phone" value="<?= htmlspecialchars($shipping['phone'] ?? ($customer['phone'] ?? '')) ?>" placeholder="+91 98765 43210" required type="tel"/>
            </div>
          </div>

          <button type="submit" class="group w-full py-4.5 bg-stone-950 hover:bg-stone-800 text-white font-button text-xs uppercase tracking-[0.2em] font-extrabold transition-all shadow-xl hover:shadow-[0_0_25px_rgba(233,193,118,0.25)] flex items-center justify-center gap-3 cursor-pointer rounded-xl border border-stone-800">
            <span>Continue to Payment Selection</span>
            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
          </button>

        </form>
      </div>

      <!-- ── Right Side: Order Summary Card (5 cols) ── -->
      <?php
        $summary = $totals ?? $cart ?? [];
        $items = $summary['items'] ?? [];
        $subtotal = (float)($summary['subtotal'] ?? 0);
        $discount = (float)($summary['discount_amount'] ?? 0);
        $total = (float)($summary['total'] ?? 0);
      ?>
      <div class="lg:col-span-5 p-6 sm:p-8 rounded-2xl bg-white border border-stone-200 shadow-sm sticky top-[100px]">
        <div class="flex justify-between items-center border-b border-stone-200 pb-3 mb-5">
          <div>
            <span class="text-[10px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">Acquisition Summary</span>
            <h3 class="font-serif text-xl text-stone-950 font-bold">Order Breakdown</h3>
          </div>
          <span class="text-[11px] font-mono text-stone-500 bg-stone-100 px-2.5 py-1 rounded-full uppercase tracking-wider font-semibold">
            <?= count($items) ?> <?= count($items) === 1 ? 'Piece' : 'Pieces' ?>
          </span>
        </div>
        
        <div class="divide-y divide-stone-100 mb-6 max-h-72 overflow-y-auto pr-1 custom-scrollbar">
          <?php if (empty($items)): ?>
            <div class="py-4 text-center text-xs text-stone-400">Your bag is currently empty.</div>
          <?php else: ?>
            <?php foreach ($items as $item): ?>
            <?php 
              $item_price = (float)($item['total_price'] ?? ($item['quantity'] * ($item['unit_price'] ?? $item['price'] ?? 0)));
              $item_img = !empty($item['image_url']) ? $item['image_url'] : (!empty($item['primary_image']) ? $item['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg'));
            ?>
            <div class="py-3.5 flex items-center justify-between gap-3 text-xs group">
              <div class="flex items-center gap-3.5">
                <div class="w-14 h-16 rounded-lg bg-stone-100 overflow-hidden border border-stone-200 flex-shrink-0">
                  <img src="<?= htmlspecialchars($item_img) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="<?= htmlspecialchars($item['product_title'] ?? $item['title'] ?? 'Garment') ?>">
                </div>
                <div>
                  <h4 class="font-serif font-bold text-stone-950 text-sm leading-snug"><?= htmlspecialchars($item['product_title'] ?? $item['title'] ?? 'Garment Piece') ?></h4>
                  <p class="text-[11px] text-[#a16207] font-mono font-semibold mt-0.5">
                    <?= htmlspecialchars($item['variant_title'] ?? 'Standard') ?> × <?= $item['quantity'] ?? 1 ?>
                  </p>
                </div>
              </div>
              <span class="font-serif font-bold text-stone-950 text-sm whitespace-nowrap" data-price-inr="<?= $item_price ?>">₹<?= number_format($item_price, 0) ?></span>
            </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="space-y-3 text-xs text-stone-600">
          <div class="flex justify-between items-center">
            <span>Subtotal</span>
            <span class="text-stone-950 font-semibold font-serif text-sm" data-price-inr="<?= $subtotal ?>">₹<?= number_format($subtotal, 0) ?></span>
          </div>

          <!-- VIP Loyalty Points Redemption Widget -->
          <div class="p-3 bg-amber-50/80 border border-amber-200/80 rounded-xl my-2">
            <div class="flex items-center justify-between gap-2 mb-1.5">
              <span class="text-[10px] font-mono uppercase text-[#a16207] font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">stars</span>
                <span>NovaDrop VIP Loyalty Points</span>
              </span>
              <span class="text-[10px] font-mono bg-amber-200 text-[#a16207] px-1.5 py-0.5 rounded font-bold">500 PTS</span>
            </div>
            <div class="flex gap-2">
              <button type="button" onclick="this.textContent='✓ ₹100 Points Applied!'; this.disabled=true; this.classList.remove('bg-stone-950'); this.classList.add('bg-emerald-700');" class="w-full py-1.5 px-3 bg-stone-950 hover:bg-stone-800 text-[#e9c176] font-mono text-[10px] font-bold uppercase rounded-lg transition-all cursor-pointer shadow-xs">
                Redeem 200 Points (₹100 Off)
              </button>
            </div>
          </div>

          <?php if ($discount > 0): ?>
          <div class="flex justify-between items-center text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-1.5 rounded-lg border border-emerald-200">
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check_circle</span> Atelier Privilege (<?= htmlspecialchars($summary['discount_code'] ?? '') ?>)</span>
            <span>-<span data-price-inr="<?= $discount ?>">₹<?= number_format($discount, 0) ?></span></span>
          </div>
          <?php endif; ?>

          <div class="flex justify-between items-center">
            <span>Insured White-Glove Transit</span>
            <span class="text-emerald-700 font-bold font-mono text-[11px] bg-emerald-100/60 px-2 py-0.5 rounded">
              <?= ($summary['shipping_amount'] ?? 0) == 0 ? 'COMPLIMENTARY' : '<span data-price-inr="' . $summary['shipping_amount'] . '">₹' . number_format($summary['shipping_amount'], 0) . '</span>' ?>
            </span>
          </div>

          <div class="flex justify-between items-baseline pt-4 border-t border-stone-200 mt-2">
            <div>
              <span class="font-serif text-base text-stone-950 font-bold block">Total Due</span>
              <span class="text-[10px] text-stone-500 font-light">All-inclusive express delivery</span>
            </div>
            <span class="font-serif text-3xl font-extrabold text-stone-950 tracking-tight" data-price-inr="<?= $total ?>">₹<?= number_format($total, 0) ?></span>
          </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-6 p-4 rounded-xl bg-stone-50 border border-stone-200 flex items-center gap-3">
          <span class="material-symbols-outlined text-[#a16207] text-xl">verified_user</span>
          <div class="text-[11px] leading-relaxed">
            <strong class="text-stone-950 block font-serif font-bold">256-Bit SSL Encrypted</strong>
            <span class="text-stone-500">Insured Atelier Priority Transit &amp; 7-Day Exchange</span>
          </div>
        </div>
      </div>

    </div>

  </div>
</main>
