<div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-md min-h-[70vh]">
  
  <!-- Top Obsidian Header Banner -->
  <div class="bg-[#0a0b0e] text-white py-7 sm:py-9 px-5 sm:px-8 rounded-3xl border border-white/10 shadow-2xl mb-8 relative overflow-hidden">
    <div class="absolute w-80 h-80 rounded-full bg-amber-500/10 blur-[90px] top-0 right-0 pointer-events-none"></div>
    <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
      <div>
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-mono text-white/60 mb-2.5 uppercase tracking-wider">
          <a class="text-[#e9c176] font-bold border-b border-[#e9c176]/60 pb-0.5" href="<?= base_url('cart') ?>">Curated Bag</a>
          <span class="material-symbols-outlined text-[13px] text-white/40">chevron_right</span>
          <span class="text-white/60">White-Glove Checkout</span>
        </nav>
        <span class="font-mono text-[10px] sm:text-xs text-[#e9c176] uppercase tracking-[0.2em] block mb-1 font-bold">Your Atelier Selection</span>
        <h1 class="font-serif text-3xl sm:text-4xl text-white font-bold tracking-tight">Curated Bag<span class="text-[#e9c176]">.</span></h1>
      </div>
      <span class="px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs text-white/90 font-mono backdrop-blur-sm shadow-xs">
        <?= count($cart['items'] ?? []) ?> Artifact<?= count($cart['items'] ?? []) === 1 ? '' : 's' ?>
      </span>
    </div>
  </div>

  <?php
    $cart_items = $items ?? ($cart['items'] ?? []);
    $cart_subtotal = (float)($subtotal ?? ($cart['subtotal'] ?? 0));
    $cart_discount = (float)($discount_amount ?? ($cart['discount_amount'] ?? 0));
    $cart_total = (float)($total ?? ($cart['total'] ?? max(0, $cart_subtotal - $cart_discount)));
  ?>

  <?php if (empty($cart_items)): ?>
    <div class="p-16 text-center border border-dashed border-outline-variant/60 rounded-DEFAULT bg-surface liquid-glass">
      <span class="material-symbols-outlined text-5xl text-accent mb-4 block animate-bounce">shopping_bag</span>
      <h2 class="font-headline-sm text-2xl text-primary font-serif mb-2">Your Bag is Currently Empty</h2>
      <p class="font-body-md text-on-surface-variant mb-8 max-w-sm mx-auto text-xs">Explore our curated gallery of architectural garments and handcrafted lifestyle essentials.</p>
      <a href="<?= base_url('shop') ?>" class="inline-block bg-primary text-white font-button text-xs uppercase tracking-widest px-8 py-4 hover:bg-secondary transition-colors shadow-xl">
        Discover Creations →
      </a>
    </div>
  <?php else: ?>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
      
      <!-- Items List (8 cols) -->
      <div class="lg:col-span-8 border border-outline-variant/40 bg-surface rounded-DEFAULT overflow-hidden liquid-glass">
        <div class="divide-y divide-outline-variant/30">
          <?php foreach ($cart_items as $item): ?>
          <?php 
            $item_total = (float)($item['total_price'] ?? ($item['quantity'] * ($item['unit_price'] ?? $item['price'] ?? 0)));
            $item_slug = !empty($item['slug']) ? $item['slug'] : (!empty($item['product_slug']) ? $item['product_slug'] : '#');
          ?>
          <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            
            <div class="flex items-center gap-4">
              <div class="w-20 h-24 bg-surface-container overflow-hidden rounded-DEFAULT flex-shrink-0">
                <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&q=80') ?>" class="w-full h-full object-cover" alt="<?= htmlspecialchars($item['product_title'] ?? $item['title'] ?? 'Garment') ?>">
              </div>
              <div>
                <a href="<?= $item_slug !== '#' ? base_url('products/' . $item_slug) : '#' ?>" class="font-headline-sm text-base text-primary hover:underline font-serif font-bold">
                  <?= htmlspecialchars($item['product_title'] ?? $item['title'] ?? 'Garment Piece') ?>
                </a>
                <p class="text-xs text-accent font-mono mt-0.5"><?= htmlspecialchars($item['variant_title'] ?? 'Standard Edition') ?></p>
                <p class="text-xs text-on-surface-variant mt-1"><span data-price-inr="<?= (float)($item['unit_price'] ?? $item['price'] ?? 0) ?>">₹<?= number_format((float)($item['unit_price'] ?? $item['price'] ?? 0), 0) ?></span> each</p>
              </div>
            </div>

            <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
              <!-- Qty Stepper -->
              <div class="flex items-center border border-outline-variant rounded-DEFAULT bg-surface">
                <button onclick="updateCartItem(<?= $item['variant_id'] ?>, <?= $item['quantity'] - 1 ?>)" class="px-3 py-1.5 text-on-surface-variant hover:text-primary transition-colors cursor-pointer">
                  <span class="material-symbols-outlined text-sm">remove</span>
                </button>
                <span class="px-3 font-semibold text-xs font-mono"><?= $item['quantity'] ?></span>
                <button onclick="updateCartItem(<?= $item['variant_id'] ?>, <?= $item['quantity'] + 1 ?>)" class="px-3 py-1.5 text-on-surface-variant hover:text-primary transition-colors cursor-pointer">
                  <span class="material-symbols-outlined text-sm">add</span>
                </button>
              </div>

              <!-- Price & Remove -->
              <div class="text-right min-w-[90px]">
                <div class="font-bold text-primary font-serif text-base" data-price-inr="<?= $item_total ?>">₹<?= number_format($item_total, 0) ?></div>
                <button onclick="updateCartItem(<?= $item['variant_id'] ?>, 0)" class="text-[11px] text-red-600 hover:underline mt-1 cursor-pointer">Remove</button>
              </div>
            </div>

          </div>
          <?php endforeach; ?>
        </div>

        <!-- White-Glove Packaging Feature -->
        <div class="p-4 bg-surface-container-low border-t border-outline-variant/30 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-accent text-xl">redeem</span>
            <div class="text-xs">
              <span class="font-bold text-primary block">Complimentary White-Glove Packaging</span>
              <span class="text-on-surface-variant">Includes signature linen garment bag and certified provenance seal.</span>
            </div>
          </div>
          <span class="text-xs text-emerald-600 font-semibold bg-emerald-500/10 px-2 py-0.5 rounded">Included</span>
        </div>

      </div>

      <!-- Right Summary Panel (4 cols) -->
      <div class="lg:col-span-4 liquid-glass p-6 md:p-8 rounded-DEFAULT ambient-elevation border border-outline-variant/60 flex flex-col gap-6 sticky top-[100px]">
        <h3 class="font-headline-sm text-xl text-primary font-serif border-b border-outline-variant/30 pb-3">Acquisition Summary</h3>

        <!-- Voucher Code -->
        <form method="post" action="<?= base_url('cart/apply_discount') ?>" class="flex gap-2">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
          <input type="text" name="code" placeholder="Enter Privilege Code (e.g. LUMINA15)" class="input-line flex-1 text-xs bg-surface px-3 py-2 border border-outline-variant/60 outline-none" required>
          <button type="submit" class="px-4 py-2 bg-primary text-white font-button text-xs uppercase tracking-wider hover:bg-secondary transition-colors cursor-pointer">
            Apply
          </button>
        </form>

        <div class="flex flex-col gap-3 text-xs text-on-surface-variant border-t border-outline-variant/30 pt-4">
          <div class="flex justify-between items-center">
            <span>Subtotal</span>
            <span class="text-primary font-semibold text-sm" data-price-inr="<?= $cart_subtotal ?>">₹<?= number_format($cart_subtotal, 0) ?></span>
          </div>
          <?php if ($cart_discount > 0): ?>
          <div class="flex justify-between items-center text-emerald-600 font-semibold">
            <span>Atelier Privilege Discount</span>
            <span>-<span data-price-inr="<?= $cart_discount ?>">₹<?= number_format($cart_discount, 0) ?></span></span>
          </div>
          <?php endif; ?>
          <div class="flex justify-between items-center">
            <span>Insured White-Glove Delivery</span>
            <span class="text-emerald-600 font-semibold"><?= $cart_subtotal >= 500 ? 'Complimentary' : '₹99' ?></span>
          </div>
          <div class="flex justify-between items-baseline mt-2 pt-3 border-t border-outline-variant/40">
            <span class="font-headline-sm text-base text-primary font-serif">Total Investment</span>
            <span class="font-headline-sm text-2xl font-bold text-primary font-serif" data-price-inr="<?= $cart_total ?>">₹<?= number_format($cart_total, 0) ?></span>
          </div>
        </div>

        <a href="<?= base_url('checkout') ?>" class="w-full py-4 bg-primary text-white font-button text-xs uppercase tracking-widest text-center hover:bg-secondary transition-colors shadow-2xl block cursor-pointer">
          Proceed to White-Glove Checkout →
        </a>

        <div class="text-[10px] text-center text-on-surface-variant flex items-center justify-center gap-1.5">
          <span class="material-symbols-outlined text-xs text-emerald-600">lock</span>
          <span>Encrypted 256-bit checkout · 7-day atelier exchange</span>
        </div>
      </div>

    </div>
  <?php endif; ?>

</div>

<script>
function updateCartItem(variantId, qty) {
  var formData = new FormData();
  formData.append('variant_id', variantId);
  formData.append('quantity', qty);
  formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url('cart/update') ?>', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.json())
    .then(d => {
      if (d.success || d.status === 'success') {
        window.location.reload();
      } else {
        window.location.reload();
      }
    })
    .catch(() => window.location.reload());
}
</script>
