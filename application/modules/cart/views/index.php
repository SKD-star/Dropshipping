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
      <p class="font-body-md text-on-surface-variant mb-8 max-w-sm mx-auto text-xs">Nothing saved yet — tap the heart or bag icon on anything you love to build your wardrobe.</p>
      <a href="<?= base_url('shop') ?>" class="inline-block bg-primary text-white font-button text-xs uppercase tracking-widest px-8 py-4 hover:bg-secondary transition-colors shadow-xl">
        Discover Creations →
      </a>
    </div>
  <?php else: ?>
    <?php
      $free_shipping_threshold = 2999;
      $shipping_progress = min(100, round(($cart_subtotal / $free_shipping_threshold) * 100));
      $remaining_for_free = max(0, $free_shipping_threshold - $cart_subtotal);
    ?>
    <!-- Free Shipping Luxury Progress Bar -->
    <div class="mb-6 p-4 bg-white border border-[#E8E3DC] rounded-lg shadow-xs">
      <div class="flex items-center justify-between gap-2 mb-2 text-xs font-mono">
        <span class="flex items-center gap-1.5 text-[#1A1815] font-semibold">
          <span class="material-symbols-outlined text-sm text-[#92400e]">local_shipping</span>
          <?php if ($remaining_for_free > 0): ?>
            Add <span class="text-[#92400e] font-bold">₹<?= number_format($remaining_for_free, 0) ?></span> more for Complimentary Express Delivery
          <?php else: ?>
            <span class="text-emerald-700 font-bold">✨ Unlocked: Complimentary Insured White-Glove Delivery</span>
          <?php endif; ?>
        </span>
        <span class="text-[#6B6560]"><?= $shipping_progress ?>%</span>
      </div>
      <div class="w-full bg-[#FAF8F5] h-2 rounded-full overflow-hidden border border-[#E8E3DC]/60">
        <div class="bg-gradient-to-r from-[#d97706] to-[#92400e] h-full rounded-full transition-all duration-500" style="width: <?= $shipping_progress ?>%;"></div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
      
      <!-- Items List (8 cols) -->
      <div class="lg:col-span-8 space-y-6">
        
        <?php if (count($cart_items) >= 2): ?>
          <?php
            $pack_count = count($cart_items);
            $pack_discount_pct = $pack_count >= 3 ? 15 : 10;
          ?>
          <!-- Distinct Elevated Curated Ensemble Pack Card -->
          <div class="border border-amber-500/30 bg-gradient-to-b from-[#111216] to-[#0c0d10] text-white rounded-3xl overflow-hidden shadow-xl p-6 relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <!-- Pack Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-5 border-b border-white/10 relative z-10">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-400/10 border border-amber-400/30 flex items-center justify-center text-[#e9c176] shadow-inner flex-shrink-0">
                  <span class="material-symbols-outlined text-xl">auto_awesome</span>
                </div>
                <div>
                  <div class="flex items-center gap-2">
                    <span class="font-serif text-lg font-bold text-white">Curated Ensemble Pack</span>
                    <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-[#e9c176] font-mono text-[9px] font-bold border border-amber-400/30">
                      <?= $pack_discount_pct ?>% Privilege Applied
                    </span>
                  </div>
                  <p class="text-xs text-white/60 font-mono mt-0.5"><?= $pack_count ?> Harmonized Atelier Garments · Coordinated Ensemble</p>
                </div>
              </div>
              <button onclick="removeAllPackItems()" class="text-xs font-mono text-stone-400 hover:text-rose-400 transition-colors uppercase tracking-wider underline self-start sm:self-auto cursor-pointer">
                Remove Full Pack
              </button>
            </div>

            <!-- Nested Pack Garments -->
            <div class="divide-y divide-white/10 mt-2">
              <?php foreach ($cart_items as $item): ?>
              <?php 
                $item_total = (float)($item['total_price'] ?? ($item['quantity'] * ($item['unit_price'] ?? $item['price'] ?? 0)));
                $item_slug = !empty($item['slug']) ? $item['slug'] : (!empty($item['product_slug']) ? $item['product_slug'] : '#');
                $i_title_lower = strtolower(($item['product_title'] ?? $item['title'] ?? ''));

                if (preg_match('/(shoe|boot|sneaker|loafer|derby|chelsea|footwear)/i', $i_title_lower)) {
                  $cat_badge = 'FOOTWEAR';
                  $item_possible_sizes = ['UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11'];
                  $default_fallback_sz = 'UK 8';
                } elseif (preg_match('/(jean|denim|trouser|pant|chino|bottom|selvedge|slacks|cargo)/i', $i_title_lower)) {
                  $cat_badge = 'BOTTOM WEAR';
                  $item_possible_sizes = ['28', '30', '32', '34', '36', '38'];
                  $default_fallback_sz = '32';
                } elseif (preg_match('/(bag|tote|purse|wallet|belt|scarf|hat|sunglass|watch)/i', $i_title_lower)) {
                  $cat_badge = 'ACCESSORY';
                  $item_possible_sizes = ['One Size'];
                  $default_fallback_sz = 'One Size';
                } else {
                  $cat_badge = 'TOP WEAR';
                  $item_possible_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                  $default_fallback_sz = 'M';
                }

                $raw_sz = trim($item['option1_value'] ?? ($item['variant_title'] ?? ''));
                $clean_sz = strtoupper(trim(preg_replace('/^Size\s+/i', '', $raw_sz)));
                if (!$clean_sz || preg_match('/^(default title|atelier standard|tailored standard|standard)$/i', $raw_sz)) {
                  $clean_sz = $default_fallback_sz;
                }
                $clean_col = trim($item['option2_value'] ?? '');
              ?>
              <div class="py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                  <div class="w-16 h-20 bg-stone-900 rounded-2xl overflow-hidden flex-shrink-0 border border-white/15">
                    <img src="<?= htmlspecialchars($item['image_url'] ?? 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200&q=80') ?>" class="w-full h-full object-cover" alt="<?= htmlspecialchars($item['product_title'] ?? $item['title'] ?? 'Garment') ?>">
                  </div>
                  <div>
                    <span class="text-[9px] font-mono px-2 py-0.5 rounded bg-white/10 text-[#e9c176] font-bold uppercase tracking-wider mb-1 inline-block"><?= $cat_badge ?></span>
                    <a href="<?= $item_slug !== '#' ? base_url('products/' . $item_slug) : '#' ?>" class="font-headline-sm text-sm text-white hover:text-[#e9c176] font-serif font-bold block">
                      <?= htmlspecialchars($item['product_title'] ?? $item['title'] ?? 'Garment Piece') ?>
                    </a>
                    
                    <!-- Sizing in Pack -->
                    <div class="flex items-center gap-2 mt-1.5">
                      <span class="text-[11px] font-mono text-stone-400 font-semibold">Size:</span>
                      <select onchange="updateCartItemSize(<?= (int)$item['variant_id'] ?>, this.value)" class="text-xs font-mono font-bold bg-stone-900 text-[#e9c176] border border-amber-500/40 rounded-lg px-2.5 py-0.5 cursor-pointer outline-none hover:border-amber-400 focus:ring-1 focus:ring-amber-500">
                        <?php foreach ($item_possible_sizes as $pSz): ?>
                        <option value="<?= $pSz ?>" <?= $clean_sz === strtoupper($pSz) ? 'selected' : '' ?>><?= $pSz ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php if (!empty($clean_col)): ?>
                        <span class="text-xs font-mono text-stone-400">· <?= htmlspecialchars($clean_col) ?></span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-5 w-full sm:w-auto justify-between sm:justify-end">
                  <!-- Qty Stepper -->
                  <div class="flex items-center border border-white/20 rounded-lg bg-stone-900">
                    <button onclick="updateCartItem(<?= $item['variant_id'] ?>, <?= $item['quantity'] - 1 ?>)" class="px-2.5 py-1 text-white/70 hover:text-white transition-colors cursor-pointer">
                      <span class="material-symbols-outlined text-xs">remove</span>
                    </button>
                    <span class="px-2.5 font-semibold text-xs font-mono text-white"><?= $item['quantity'] ?></span>
                    <button onclick="updateCartItem(<?= $item['variant_id'] ?>, <?= $item['quantity'] + 1 ?>)" class="px-2.5 py-1 text-white/70 hover:text-white transition-colors cursor-pointer">
                      <span class="material-symbols-outlined text-xs">add</span>
                    </button>
                  </div>

                  <!-- Price & Remove -->
                  <div class="text-right min-w-[80px]">
                    <div class="font-bold text-white font-serif text-sm" data-price-inr="<?= $item_total ?>">₹<?= number_format($item_total, 0) ?></div>
                    <button onclick="updateCartItem(<?= $item['variant_id'] ?>, 0)" class="text-[10px] font-mono text-stone-400 hover:text-rose-400 mt-1 cursor-pointer underline">Remove</button>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>

            <!-- Pack Footer Bar -->
            <div class="mt-4 pt-4 border-t border-white/10 flex items-center justify-between text-xs font-mono">
              <div class="flex items-center gap-2 text-stone-400">
                <span class="material-symbols-outlined text-base text-[#e9c176]">redeem</span>
                <span>White-Glove Presentation &amp; Insured Box</span>
              </div>
              <span class="text-emerald-400 font-bold">Pack Privilege Active ✓</span>
            </div>
          </div>

        <?php else: ?>
          <!-- Single Product Standard Card -->
          <div class="border border-outline-variant/40 bg-surface rounded-DEFAULT overflow-hidden liquid-glass">
            <div class="divide-y divide-outline-variant/30">
              <?php foreach ($cart_items as $item): ?>
              <?php 
                $item_total = (float)($item['total_price'] ?? ($item['quantity'] * ($item['unit_price'] ?? $item['price'] ?? 0)));
                $item_slug = !empty($item['slug']) ? $item['slug'] : (!empty($item['product_slug']) ? $item['product_slug'] : '#');
                $i_title_lower = strtolower(($item['product_title'] ?? $item['title'] ?? ''));

                if (preg_match('/(shoe|boot|sneaker|loafer|derby|chelsea|footwear)/i', $i_title_lower)) {
                  $item_possible_sizes = ['UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11'];
                  $default_fallback_sz = 'UK 8';
                } elseif (preg_match('/(jean|denim|trouser|pant|chino|bottom|selvedge|slacks|cargo)/i', $i_title_lower)) {
                  $item_possible_sizes = ['28', '30', '32', '34', '36', '38'];
                  $default_fallback_sz = '32';
                } elseif (preg_match('/(bag|tote|purse|wallet|belt|scarf|hat|sunglass|watch)/i', $i_title_lower)) {
                  $item_possible_sizes = ['One Size'];
                  $default_fallback_sz = 'One Size';
                } else {
                  $item_possible_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                  $default_fallback_sz = 'M';
                }

                $raw_sz = trim($item['option1_value'] ?? ($item['variant_title'] ?? ''));
                $clean_sz = strtoupper(trim(preg_replace('/^Size\s+/i', '', $raw_sz)));
                if (!$clean_sz || preg_match('/^(default title|atelier standard|tailored standard|standard)$/i', $raw_sz)) {
                  $clean_sz = $default_fallback_sz;
                }
                $clean_col = trim($item['option2_value'] ?? '');
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
                    
                    <div class="flex items-center gap-2 mt-1">
                      <span class="text-[11px] font-mono text-stone-500 font-semibold">Size:</span>
                      <select onchange="updateCartItemSize(<?= (int)$item['variant_id'] ?>, this.value)" class="text-xs font-mono font-bold bg-amber-50 text-[#92400e] border border-amber-200/80 rounded-lg px-2 py-0.5 cursor-pointer outline-none hover:border-amber-400 focus:ring-1 focus:ring-amber-500">
                        <?php foreach ($item_possible_sizes as $pSz): ?>
                        <option value="<?= $pSz ?>" <?= $clean_sz === strtoupper($pSz) ? 'selected' : '' ?>><?= $pSz ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?php if (!empty($clean_col)): ?>
                        <span class="text-xs font-mono text-stone-500 font-medium">· <?= htmlspecialchars($clean_col) ?></span>
                      <?php endif; ?>
                    </div>
                    <p class="text-xs text-on-surface-variant mt-1.5"><span data-price-inr="<?= (float)($item['unit_price'] ?? $item['price'] ?? 0) ?>">₹<?= number_format((float)($item['unit_price'] ?? $item['price'] ?? 0), 0) ?></span> each</p>
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
        <?php endif; ?>

      </div>

      <!-- Order Summary (4 cols) -->
      <div class="lg:col-span-4 border border-outline-variant/40 bg-surface rounded-DEFAULT p-6 space-y-6 liquid-glass sticky top-24">
        <h2 class="font-headline-sm text-lg text-primary font-serif font-bold pb-4 border-b border-outline-variant/30">Investment Summary</h2>

        <div class="space-y-3 text-xs font-mono">
          <div class="flex justify-between">
            <span class="text-on-surface-variant">Selected Pieces</span>
            <span data-price-inr="<?= $cart_subtotal ?>">₹<?= number_format($cart_subtotal, 0) ?></span>
          </div>
          <?php if ($cart_discount > 0): ?>
          <div class="flex justify-between text-emerald-600 font-bold">
            <span>Privilege Discount <?= !empty($discount_code) ? "($discount_code)" : '' ?></span>
            <span>-₹<?= number_format($cart_discount, 0) ?></span>
          </div>
          <?php endif; ?>
          <div class="flex justify-between text-on-surface-variant">
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
      window.location.reload();
    })
    .catch(() => window.location.reload());
}

function updateCartItemSize(variantId, newSize) {
  var formData = new FormData();
  formData.append('variant_id', variantId);
  formData.append('size', newSize);
  formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url('cart/update_size') ?>', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.json())
    .then(d => {
      window.location.reload();
    })
    .catch(() => window.location.reload());
}

function removeAllPackItems() {
  if (!confirm('Remove this curated ensemble pack from your bag?')) return;
  
  var variantIds = <?= json_encode(array_map(function($it) { return (int)($it['variant_id'] ?? $it['id']); }, $cart_items)) ?>;
  if (!variantIds || !variantIds.length) return;

  var promises = variantIds.map(function(vId) {
    var formData = new FormData();
    formData.append('variant_id', vId);
    formData.append('quantity', 0);
    formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
    return fetch('<?= base_url('cart/update') ?>', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
  });

  Promise.all(promises).then(function() {
    window.location.reload();
  }).catch(function() {
    window.location.reload();
  });
}
</script>
