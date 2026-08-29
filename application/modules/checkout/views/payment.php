<main class="min-h-screen bg-[#faf8f5] py-8 sm:py-12">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- ── Luxury Breadcrumb & 3-Step Progress Stepper ── -->
    <div class="mb-10">
      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-stone-500 mb-6">
        <a href="<?= base_url('cart') ?>" class="hover:text-stone-950 transition-colors">Bag</a>
        <span class="text-stone-300">/</span>
        <a href="<?= base_url('checkout') ?>" class="hover:text-stone-950 transition-colors">Shipping</a>
        <span class="text-stone-300">/</span>
        <span class="text-stone-950 font-bold border-b border-stone-950 pb-0.5">Settlement</span>
      </nav>

      <!-- Stepper Pills with Connecting Progress Line -->
      <div class="relative max-w-2xl mx-auto">
        <div class="grid grid-cols-3 gap-3 sm:gap-4 relative z-10">
          <!-- Step 1: Done -->
          <a href="<?= base_url('checkout') ?>" class="group p-3 sm:p-3.5 rounded-xl bg-white border border-emerald-500/40 shadow-sm flex items-center gap-3 hover:border-emerald-600 transition-all">
            <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-sm">
              <span class="material-symbols-outlined text-[16px]">check</span>
            </div>
            <div class="hidden sm:block">
              <span class="text-[9px] font-mono uppercase tracking-widest text-emerald-700 font-bold block">Step 01</span>
              <span class="text-xs font-serif font-bold text-stone-900 group-hover:text-emerald-700 transition-colors">Shipping</span>
            </div>
          </a>

          <!-- Step 2: Active -->
          <div class="p-3 sm:p-3.5 rounded-xl bg-stone-950 text-white shadow-lg border border-stone-900 flex items-center gap-3 relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-12 h-12 bg-amber-400/20 rounded-full blur-lg pointer-events-none"></div>
            <div class="w-7 h-7 rounded-full bg-gradient-to-r from-amber-400 to-[#e9c176] text-stone-950 flex items-center justify-center text-xs font-extrabold flex-shrink-0 shadow-md">
              2
            </div>
            <div class="hidden sm:block">
              <span class="text-[9px] font-mono uppercase tracking-widest text-[#e9c176] font-bold block">Step 02 · Active</span>
              <span class="text-xs font-serif font-bold text-white">Payment</span>
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
      
      <!-- ── Left Column: Shipping Summary & Payment Methods (7 cols) ── -->
      <div class="lg:col-span-7 flex flex-col gap-6">
        
        <!-- Verified Delivery Destination Card -->
        <div class="p-5 rounded-2xl bg-white border border-stone-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all hover:border-stone-300">
          <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-800 flex-shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-xl">local_shipping</span>
            </div>
            <div>
              <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-mono uppercase tracking-widest text-[#a16207] font-bold">Client Destination</span>
                <span class="text-[9px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-mono font-bold">✓ Verified</span>
              </div>
              <h4 class="font-serif font-bold text-sm text-stone-900">
                <?= htmlspecialchars($shipping['first_name'] . ' ' . $shipping['last_name']) ?>
                <span class="font-sans font-normal text-xs text-stone-500">· <?= htmlspecialchars($shipping['phone']) ?></span>
              </h4>
              <p class="text-xs text-stone-600 mt-0.5 leading-relaxed font-light">
                <?= htmlspecialchars($shipping['address1'] . (!empty($shipping['address2']) ? ', ' . $shipping['address2'] : '')) ?>, 
                <?= htmlspecialchars($shipping['city'] . ', ' . $shipping['state'] . ' - ' . $shipping['pincode']) ?>
              </p>
            </div>
          </div>

          <a href="<?= base_url('checkout') ?>" class="text-xs font-mono uppercase tracking-wider text-[#a16207] hover:text-stone-950 font-bold border-b border-[#a16207] pb-0.5 flex-shrink-0 transition-colors">
            Edit Address →
          </a>
        </div>

        <!-- Payment Settlement Selection Box -->
        <div class="p-6 sm:p-8 rounded-2xl bg-white border border-stone-200 shadow-sm">
          
          <div class="border-b border-stone-200/80 pb-4 mb-6">
            <div class="inline-flex items-center gap-1.5 text-[10px] font-mono uppercase tracking-[0.2em] text-[#a16207] font-bold mb-1">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
              <span>256-Bit Encrypted Settlement</span>
            </div>
            <h2 class="font-serif text-2xl text-stone-950 font-medium tracking-tight">Select Payment Channel</h2>
            <p class="text-xs text-stone-500 mt-1 font-light">
              Choose your preferred acquisition method. Settle instantly with zero transaction surcharge.
            </p>
          </div>

          <form method="post" action="<?= base_url('checkout/confirm') ?>" id="paymentForm" class="space-y-4">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <!-- 1. Razorpay Secure Option (UPI, Cards, NetBanking) -->
            <label class="payment-card group relative p-5 rounded-xl border-2 border-stone-950 bg-stone-50/50 flex items-start gap-4 cursor-pointer transition-all duration-200 shadow-sm block" onclick="selectPaymentMethod(this, 'razorpay')">
              <div class="pt-0.5">
                <input type="radio" name="payment_method" value="razorpay" checked class="accent-stone-950 w-4 h-4 cursor-pointer">
              </div>
              <div class="flex-1">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                  <div class="flex items-center gap-2">
                    <span class="font-serif font-bold text-sm text-stone-950">Razorpay Secure</span>
                    <span class="text-[9px] font-mono font-extrabold bg-gradient-to-r from-amber-200 to-[#e9c176] text-stone-950 border border-amber-300 px-2 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
                      ★ Recommended
                    </span>
                  </div>
                  <!-- Mini Logos -->
                  <div class="flex items-center gap-1.5 text-xs font-mono">
                    <span class="px-2 py-0.5 bg-white border border-stone-200 rounded text-[10px] font-bold text-indigo-700 shadow-2xs">UPI</span>
                    <span class="px-2 py-0.5 bg-white border border-stone-200 rounded text-[10px] font-bold text-blue-700 shadow-2xs">CARDS</span>
                    <span class="px-2 py-0.5 bg-white border border-stone-200 rounded text-[10px] font-bold text-emerald-700 shadow-2xs">NETBANKING</span>
                  </div>
                </div>
                <p class="text-xs text-stone-600 font-light leading-relaxed">
                  Instant settlement via Google Pay, PhonePe, Paytm, BHIM UPI QR, Debit/Credit Cards, NetBanking &amp; 0% EMI.
                </p>

                <!-- Dynamic Detail Accordion -->
                <div class="payment-details mt-3 pt-3 border-t border-stone-200/60 flex items-center justify-between text-[11px] text-stone-500 font-mono">
                  <span class="flex items-center gap-1 text-emerald-700 font-semibold">
                    <span class="material-symbols-outlined text-[14px]">bolt</span> Instant Confirmation
                  </span>
                  <span>Zero Transaction Fee</span>
                </div>
              </div>
            </label>

            <!-- 2. Stripe Global Cards Option -->
            <label class="payment-card group relative p-5 rounded-xl border border-stone-200 bg-white flex items-start gap-4 cursor-pointer transition-all duration-200 hover:border-stone-400 hover:shadow-sm block" onclick="selectPaymentMethod(this, 'stripe')">
              <div class="pt-0.5">
                <input type="radio" name="payment_method" value="stripe" class="accent-stone-950 w-4 h-4 cursor-pointer">
              </div>
              <div class="flex-1">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                  <div class="flex items-center gap-2">
                    <span class="font-serif font-bold text-sm text-stone-950">Credit / Debit Card (Stripe)</span>
                    <span class="text-[9px] font-mono font-bold bg-blue-50 text-blue-800 border border-blue-200 px-2 py-0.5 rounded-full uppercase tracking-wider">
                      International
                    </span>
                  </div>
                  <div class="flex items-center gap-1 text-xs font-mono">
                    <span class="px-1.5 py-0.5 bg-stone-50 border border-stone-200 rounded text-[9px] font-bold text-stone-700">VISA</span>
                    <span class="px-1.5 py-0.5 bg-stone-50 border border-stone-200 rounded text-[9px] font-bold text-stone-700">MASTERCARD</span>
                    <span class="px-1.5 py-0.5 bg-stone-50 border border-stone-200 rounded text-[9px] font-bold text-stone-700">AMEX</span>
                  </div>
                </div>
                <p class="text-xs text-stone-600 font-light leading-relaxed">
                  Direct encrypted card processing for international and domestic cardholders with 3D-Secure protection.
                </p>
              </div>
            </label>

            <!-- 3. Cash on Delivery (COD) Option -->
            <label class="payment-card group relative p-5 rounded-xl border border-stone-200 bg-white flex items-start gap-4 cursor-pointer transition-all duration-200 hover:border-stone-400 hover:shadow-sm block" onclick="selectPaymentMethod(this, 'cod')">
              <div class="pt-0.5">
                <input type="radio" name="payment_method" value="cod" class="accent-stone-950 w-4 h-4 cursor-pointer">
              </div>
              <div class="flex-1">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                  <div class="flex items-center gap-2">
                    <span class="font-serif font-bold text-sm text-stone-950">Atelier Cash on Delivery (COD)</span>
                    <span class="text-[9px] font-mono font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 px-2 py-0.5 rounded-full uppercase tracking-wider">
                      Doorstep Handover
                    </span>
                  </div>
                  <span class="material-symbols-outlined text-lg text-emerald-600">payments</span>
                </div>
                <p class="text-xs text-stone-600 font-light leading-relaxed">
                  Inspect your wax-sealed packaging and settle via cash or courier UPI QR scan upon doorstep delivery.
                </p>
              </div>
            </label>

            <!-- Lumina Loyalty Points Ingot -->
            <?php $points = round((float)($totals['total'] ?? 0) * 0.1); ?>
            <div class="p-4 rounded-xl bg-gradient-to-r from-amber-500/10 via-[#e9c176]/10 to-transparent border border-[#e9c176]/40 flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-[#e9c176]/20 border border-[#e9c176]/40 flex items-center justify-center text-[#a16207]">
                  <span class="material-symbols-outlined text-xl">workspace_premium</span>
                </div>
                <div>
                  <div class="text-xs font-bold text-stone-950 font-serif">Lumina Collector Rewards</div>
                  <div class="text-[11px] text-stone-600">You will earn <strong class="text-stone-950 font-mono font-bold">+<?= $points ?> LP</strong> upon order completion</div>
                </div>
              </div>
              <span class="text-[10px] font-mono font-bold uppercase text-[#a16207] bg-amber-100 border border-amber-200 px-2.5 py-1 rounded-full whitespace-nowrap">
                10% Points Value
              </span>
            </div>

            <!-- Submit Order CTA Button -->
            <div class="pt-3">
              <button type="submit" id="confirmOrderBtn" class="group w-full py-4.5 px-6 bg-stone-950 hover:bg-stone-800 text-white font-button text-xs uppercase tracking-[0.2em] font-extrabold transition-all shadow-xl hover:shadow-[0_0_25px_rgba(233,193,118,0.25)] flex items-center justify-center gap-3 cursor-pointer rounded-xl border border-stone-800">
                <span class="material-symbols-outlined text-base text-[#e9c176] group-hover:scale-110 transition-transform">verified_user</span>
                <span>Authorize Acquisition &amp; Place Order · <span data-price-inr="<?= $totals['total'] ?>">₹<?= number_format($totals['total'], 0) ?></span></span>
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
              </button>
            </div>

            <!-- Trust & Provenance Badges Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-4 border-t border-stone-200 text-center">
              <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100 flex flex-col items-center gap-1">
                <span class="material-symbols-outlined text-lg text-stone-700">lock</span>
                <span class="text-[10px] font-mono uppercase tracking-wider text-stone-600 font-semibold">256-Bit SSL</span>
              </div>
              <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100 flex flex-col items-center gap-1">
                <span class="material-symbols-outlined text-lg text-emerald-600">shield</span>
                <span class="text-[10px] font-mono uppercase tracking-wider text-stone-600 font-semibold">PCI-DSS Level 1</span>
              </div>
              <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100 flex flex-col items-center gap-1">
                <span class="material-symbols-outlined text-lg text-[#a16207]">flight_takeoff</span>
                <span class="text-[10px] font-mono uppercase tracking-wider text-stone-600 font-semibold">Insured Transit</span>
              </div>
              <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100 flex flex-col items-center gap-1">
                <span class="material-symbols-outlined text-lg text-amber-700">published_with_changes</span>
                <span class="text-[10px] font-mono uppercase tracking-wider text-stone-600 font-semibold">7-Day Guarantee</span>
              </div>
            </div>

          </form>
        </div>

      </div>

      <!-- ── Right Column: Order Summary & Item Breakdown (5 cols) ── -->
      <div class="lg:col-span-5 p-6 sm:p-8 rounded-2xl bg-white border border-stone-200 shadow-sm sticky top-[100px]">
        
        <div class="flex justify-between items-center border-b border-stone-200 pb-3 mb-5">
          <div>
            <span class="text-[10px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">Acquisition Summary</span>
            <h3 class="font-serif text-xl text-stone-950 font-bold">Order Breakdown</h3>
          </div>
          <span class="text-[11px] font-mono text-stone-500 bg-stone-100 px-2.5 py-1 rounded-full uppercase tracking-wider font-semibold">
            <?= count($totals['items'] ?? []) ?> <?= count($totals['items'] ?? []) === 1 ? 'Piece' : 'Pieces' ?>
          </span>
        </div>

        <!-- Item List Preview -->
        <div class="divide-y divide-stone-100 mb-6 max-h-72 overflow-y-auto pr-1 custom-scrollbar">
          <?php if (!empty($totals['items'])): ?>
            <?php foreach ($totals['items'] as $item): ?>
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

        <!-- Privilege Voucher Code Application -->
        <form method="post" action="<?= base_url('cart/apply_discount') ?>" class="flex gap-2 mb-5 pb-4 border-b border-stone-200">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
          <div class="relative flex-1">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-sm">local_offer</span>
            <input type="text" name="code" placeholder="Privilege Code (e.g. LUMINA15)" class="w-full pl-8 pr-3 py-2.5 text-xs bg-stone-50 border border-stone-200 rounded-lg outline-none focus:border-stone-950 uppercase font-mono font-semibold transition-colors" required>
          </div>
          <button type="submit" class="px-4 py-2.5 bg-stone-950 hover:bg-stone-800 text-white font-button text-xs uppercase tracking-wider font-bold rounded-lg transition-colors cursor-pointer whitespace-nowrap">
            Apply
          </button>
        </form>

        <!-- Financial Calculation Breakdown -->
        <div class="space-y-3 text-xs text-stone-600">
          <div class="flex justify-between items-center">
            <span>Subtotal</span>
            <span class="text-stone-950 font-semibold font-serif text-sm" data-price-inr="<?= $totals['subtotal'] ?>">₹<?= number_format($totals['subtotal'], 0) ?></span>
          </div>

          <?php if ($totals['discount_amount'] > 0): ?>
          <div class="flex justify-between items-center text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-1.5 rounded-lg border border-emerald-200">
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">check_circle</span> Atelier Privilege (<?= htmlspecialchars($totals['discount_code'] ?? '') ?>)</span>
            <span>-<span data-price-inr="<?= $totals['discount_amount'] ?>">₹<?= number_format($totals['discount_amount'], 0) ?></span></span>
          </div>
          <?php endif; ?>

          <div class="flex justify-between items-center">
            <span>Insured White-Glove Transit</span>
            <span class="text-emerald-700 font-bold font-mono text-[11px] bg-emerald-100/60 px-2 py-0.5 rounded">
              <?= $totals['shipping_amount'] == 0 ? 'COMPLIMENTARY' : '<span data-price-inr="' . $totals['shipping_amount'] . '">₹' . number_format($totals['shipping_amount'], 0) . '</span>' ?>
            </span>
          </div>

          <div class="flex justify-between items-center text-[11px] text-stone-400">
            <span>GST &amp; Duties (Included)</span>
            <span><span data-price-inr="<?= $totals['tax_amount'] ?>">₹<?= number_format($totals['tax_amount'], 2) ?></span></span>
          </div>

          <!-- Total Due -->
          <div class="flex justify-between items-baseline pt-4 border-t border-stone-200 mt-2">
            <div>
              <span class="font-serif text-base text-stone-950 font-bold block">Total Investment</span>
              <span class="text-[10px] text-stone-500 font-light">All-inclusive express delivery</span>
            </div>
            <span class="font-serif text-3xl font-extrabold text-stone-950 tracking-tight" data-price-inr="<?= $totals['total'] ?>">₹<?= number_format($totals['total'], 0) ?></span>
          </div>
        </div>

        <!-- Signature Atelier Packaging Ingot -->
        <div class="mt-6 p-4 rounded-xl bg-stone-50 border border-stone-200 flex items-center gap-3.5">
          <div class="w-10 h-10 rounded-lg bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-[#a16207] flex-shrink-0">
            <span class="material-symbols-outlined text-xl">redeem</span>
          </div>
          <div class="text-[11px] leading-relaxed">
            <strong class="text-stone-950 block font-serif font-bold">Signature Atelier Packaging Included</strong>
            <span class="text-stone-500">Linen protective dust bag with wax-sealed certified provenance.</span>
          </div>
        </div>

      </div>

    </div>

  </div>
</main>

<script>
function selectPaymentMethod(labelEl, method) {
  document.querySelectorAll('.payment-card').forEach(card => {
    card.classList.remove('border-stone-950', 'bg-stone-50/50', 'shadow-sm');
    card.classList.add('border-stone-200', 'bg-white');
    const radio = card.querySelector('input[type="radio"]');
    if (radio) radio.checked = false;
  });
  
  labelEl.classList.remove('border-stone-200', 'bg-white');
  labelEl.classList.add('border-stone-950', 'bg-stone-50/50', 'shadow-sm');
  const activeRadio = labelEl.querySelector('input[type="radio"]');
  if (activeRadio) activeRadio.checked = true;
}
</script>
