<!-- ══════════════════════════════════════════════════════
     HAUTE COUTURE PRODUCT DETAIL PAGE (LUMINA ATELIER)
     HIGH-CONTRAST OBSIDIAN & WHITE · AI ENSEMBLE SUITE · MODEL STUDIO
══════════════════════════════════════════════════════ -->
<?php
  $product_title = $product['title'] ?? 'The Atelier Cashmere Cocoon Coat';
  $primary_image = !empty($product['images'][0]['url']) ? $product['images'][0]['url'] : base_url('img/cashmere_cocoon_coat.jpg');
  
  // High-res gallery images
  $gallery_images = [];
  if (!empty($product['images'])) {
      foreach ($product['images'] as $img) {
          if (!empty($img['url'])) {
              $gallery_images[] = $img['url'];
          }
      }
  }
  if (empty($gallery_images)) {
      $gallery_images = [$primary_image];
  }

  $variants = $product['variants'] ?? [];
  $default_variant = $variants[0] ?? [
    'id' => $product['id'] ?? 1,
    'price' => $product['base_price'] ?? 1586,
    'compare_price' => !empty($product['compare_at_price']) ? $product['compare_at_price'] : 0,
    'inventory_qty' => 50,
    'sku' => 'ALX-1017-WHT-S',
    'title' => 'White / S(US 36)'
  ];
  
  $price = (float)$default_variant['price'];
  $compare_price = !empty($default_variant['compare_price']) && (float)$default_variant['compare_price'] > $price 
      ? (float)$default_variant['compare_price'] 
      : (!empty($product['compare_at_price']) && (float)$product['compare_at_price'] > $price ? (float)$product['compare_at_price'] : 0);
  $discount_pct = ($compare_price > $price && $compare_price > 0) ? round((($compare_price - $price) / $compare_price) * 100) : 0;
  
  $vendor_name = $product['vendor'] ?? ($vendor_info['business_name'] ?? 'Verified Direct Supplier');
  $short_desc = !empty($product['short_description']) ? $product['short_description'] : (mb_substr(strip_tags($product['description'] ?? ''), 0, 180) . '...');
  $full_desc = !empty($product['description']) ? $product['description'] : $short_desc;
  
  // Dynamic Color Extraction from Variants
  $color_shades = [];
  $seen_colors = [];
  $color_hex_map = [
      'white' => '#ffffff',
      'black' => '#111827',
      'gray' => '#9ca3af',
      'heather gray' => '#9ca3af',
      'grey' => '#9ca3af',
      'navy' => '#1e3a8a',
      'navy blue' => '#1e3a8a',
      'camel' => '#c29b64',
      'olive' => '#556b2f',
      'beige' => '#d4cbbd',
      'charcoal' => '#374151',
  ];

  foreach ($variants as $v) {
      $v_title = $v['title'] ?? '';
      $parts = explode('/', $v_title);
      $color_name = trim($parts[0] ?? 'Standard');
      if (!empty($color_name) && !isset($seen_colors[$color_name])) {
          $seen_colors[$color_name] = true;
          $c_lower = strtolower($color_name);
          $hex = $color_hex_map[$c_lower] ?? '#6b7280';
          $color_shades[] = [
              'name' => $color_name,
              'hex'  => $hex,
              'img'  => $primary_image
          ];
      }
  }
  if (empty($color_shades)) {
      $color_shades = [
          ['name' => 'Original Finish', 'hex' => '#111827', 'img' => $primary_image]
      ];
  }

  // Dynamic Size Extraction from Variants
  $available_sizes = [];
  $seen_sizes = [];
  foreach ($variants as $v) {
      $v_title = $v['title'] ?? '';
      $parts = explode('/', $v_title);
      $size_name = isset($parts[1]) ? trim($parts[1]) : trim($parts[0]);
      if (!empty($size_name) && !preg_match('/^(default title|standard|tailored standard)$/i', $size_name) && !isset($seen_sizes[$size_name])) {
          $seen_sizes[$size_name] = true;
          $available_sizes[] = $size_name;
      }
  }

  // Category & Product-Type Intelligent Sizing Engine
  if (empty($available_sizes)) {
      $combined_type = strtolower($product_title . ' ' . ($product['category_name'] ?? '') . ' ' . ($product['category'] ?? ''));
      if (preg_match('/(shoe|boot|sneaker|loafer|chelsea|footwear|heel|mule|oxford|sandal|derby|slide)/i', $combined_type)) {
          $available_sizes = ['UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11'];
      } elseif (preg_match('/(jean|denim|trouser|pant|chino|bottom|selvedge|slacks|cargo|waist)/i', $combined_type)) {
          $available_sizes = ['28', '30', '32', '34', '36', '38'];
      } elseif (preg_match('/(bag|tote|purse|wallet|belt|scarf|hat|sunglass|watch|ring|necklace|bracelet|fragrance)/i', $combined_type)) {
          $available_sizes = ['One Size'];
      } else {
          $available_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
      }
  }

?>

<main class="min-h-screen bg-[#faf9f6] text-stone-900 pt-20 sm:pt-24 pb-24">

  <!-- ── 1. HAUTE COUTURE OBSIDIAN HERO RIBBON (DIRECTLY BELOW HEADER) ── -->
  <section class="bg-[#07080b] text-white border-b border-white/10 py-4 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Subtle Starlight & Amber Radial Flare -->
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#e9c176_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
    <div class="absolute w-96 h-96 rounded-full bg-amber-500/10 blur-[90px] -top-20 right-10 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 relative z-10">
      
      <!-- Breadcrumb Navigation -->
      <nav class="flex items-center gap-2 text-xs font-mono uppercase tracking-wider text-white/60">
        <a href="<?= base_url() ?>" class="hover:text-white transition-colors">Lookbook</a>
        <span class="text-white/30">/</span>
        <a href="<?= base_url('shop') ?>" class="hover:text-white transition-colors">Boutique</a>
        <span class="text-white/30">/</span>
        <span class="text-[#e9c176] font-bold truncate max-w-[240px] sm:max-w-md"><?= htmlspecialchars($product_title) ?></span>
      </nav>

      <!-- Scarcity & Courier Tag -->
      <div class="flex items-center gap-3 text-xs font-mono">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/5 border border-[#e9c176]/40 text-[#e9c176] font-semibold shadow-sm backdrop-blur-sm">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
          <span>Curated Atelier Edition</span>
        </span>
        <span class="text-white/30 hidden md:inline">|</span>
        <span class="text-white/70 text-[11px] font-semibold hidden md:inline">BlueDart Priority Express</span>
      </div>

    </div>
  </section>


  <!-- ── 2. MAIN HERO PRODUCT STAGE & BUY SUITE (CRISP EDITORIAL WHITE) ── -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
      
      <!-- ── LEFT: EDITORIAL VISUAL GALLERY (7 Columns) ── -->
      <div class="lg:col-span-7 flex flex-col space-y-4">
        
        <!-- Primary Photo Stage with Zoom Loupe -->
        <div class="relative aspect-[4/5] bg-white rounded-3xl border border-stone-200 shadow-xl overflow-hidden group">
          
          <img id="mainProductPhoto" 
               src="<?= htmlspecialchars($primary_image) ?>" 
               alt="<?= htmlspecialchars($product_title) ?>" 
               class="w-full h-full object-cover transition-all duration-700 ease-out group-hover:scale-105"
               loading="eager">
          
          <!-- Top Scarcity Pill Overlay -->
          <div class="absolute top-4 left-4 z-10 flex flex-wrap gap-2">
            <span class="text-[10px] font-mono font-bold uppercase tracking-wider bg-black/85 text-[#e9c176] px-3.5 py-1.5 rounded-full border border-white/20 backdrop-blur-md shadow-md flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176]"></span>
              <span><?= htmlspecialchars($product['collection_title'] ?? 'Archival Edition') ?></span>
            </span>
            <?php if (!empty($product['vendor'])): ?>
            <span class="text-[10px] font-mono text-white bg-black/70 px-3 py-1.5 rounded-full border border-white/15 backdrop-blur-md">
              <?= htmlspecialchars($product['vendor']) ?>
            </span>
            <?php endif; ?>
          </div>

          <!-- Top-Right Fullscreen / Studio Button -->
          <button type="button" onclick="openProductGalleryModal()" class="absolute top-4 right-4 px-3.5 py-2 rounded-full bg-black/80 hover:bg-black text-white hover:text-[#e9c176] border border-white/20 text-xs font-mono uppercase tracking-wider flex items-center gap-1.5 transition-all shadow-md z-10 cursor-pointer" title="View Fullscreen Studio Photos">
            <span class="material-symbols-outlined text-sm">fullscreen</span>
            <span>View Fullscreen</span>
          </button>

          <!-- Bottom Active Shade Indicator -->
          <div class="absolute bottom-4 left-4 z-10">
            <span class="text-xs font-mono text-white bg-black/85 px-4 py-2 rounded-full border border-white/20 backdrop-blur-md shadow-lg" id="activeShadePhotoLabel">
              Shade: <?= htmlspecialchars($color_shades[0]['name'] ?? 'Original Finish') ?>
            </span>
          </div>

          <!-- Bottom-Right Zoom Hint -->
          <div class="absolute bottom-4 right-4 z-10 hidden sm:flex items-center gap-1 text-[11px] font-mono text-white/80 bg-black/70 px-3 py-1.5 rounded-full border border-white/15 backdrop-blur-md">
            <span class="material-symbols-outlined text-xs">zoom_in</span>
            <span>Hover to Inspect Craft</span>
          </div>

        </div>

        <!-- Gallery Thumbnail Rail & Angle Selectors -->
        <div class="grid grid-cols-4 gap-3">
          <?php foreach ($gallery_images as $gIdx => $gUrl): ?>
          <button type="button" 
                  onclick="selectMainPhoto('<?= htmlspecialchars(addslashes($gUrl)) ?>', this)" 
                  class="gallery-thumb-btn <?= $gIdx === 0 ? 'ring-2 ring-stone-950 scale-[1.02]' : 'opacity-70 hover:opacity-100' ?> aspect-square rounded-2xl overflow-hidden bg-white border border-stone-200 shadow-sm transition-all duration-300 cursor-pointer relative group">
            <img src="<?= htmlspecialchars($gUrl) ?>" alt="Perspective <?= $gIdx + 1 ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <span class="absolute bottom-1.5 left-1.5 right-1.5 py-0.5 text-[9px] font-mono text-center uppercase bg-black/75 text-white rounded-md backdrop-blur-sm">
              Angle <?= sprintf('%02d', $gIdx + 1) ?>
            </span>
          </button>
          <?php endforeach; ?>
        </div>

        <!-- 3 Feature Micro-Banners -->
        <div class="grid grid-cols-3 gap-3 pt-2">
          <div class="bg-white p-3.5 rounded-2xl border border-stone-200 shadow-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-[#a16207] text-xl">straighten</span>
            <div>
              <span class="text-[10px] uppercase font-mono text-stone-400 block font-semibold">Stitching</span>
              <span class="text-xs font-bold text-stone-900">Single-Needle</span>
            </div>
          </div>
          <div class="bg-white p-3.5 rounded-2xl border border-stone-200 shadow-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-[#a16207] text-xl">scale</span>
            <div>
              <span class="text-[10px] uppercase font-mono text-stone-400 block font-semibold">Weight</span>
              <span class="text-xs font-bold text-stone-900">700 GSM Net</span>
            </div>
          </div>
          <div class="bg-white p-3.5 rounded-2xl border border-stone-200 shadow-sm flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-600 text-xl">local_shipping</span>
            <div>
              <span class="text-[10px] uppercase font-mono text-stone-400 block font-semibold">Express Courier</span>
              <span class="text-xs font-bold text-emerald-600">BlueDart Priority</span>
            </div>
          </div>
        </div>

      </div>


      <!-- ── RIGHT: STICKY HAUTE COUTURE ACQUISITION SUITE (5 Columns) ── -->
      <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border border-stone-200 shadow-xl space-y-5 sticky top-[95px]">
        
        <!-- Provenance & Atelier Tag -->
        <div>
          <div class="flex items-center justify-between gap-2 mb-2">
            <span class="text-xs font-mono uppercase tracking-[0.2em] text-[#a16207] font-bold">
              ✦ Atelier Series · 2026 Archive
            </span>
            <span class="text-xs font-mono text-emerald-600 font-semibold flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
              <span>18h Dispatch Active</span>
            </span>
          </div>

          <!-- Product Title -->
          <h1 class="font-serif text-2xl sm:text-3xl text-stone-950 font-normal leading-tight mb-2.5">
            <?= htmlspecialchars($product_title) ?>
          </h1>

          <!-- Price Row -->
          <div class="flex items-baseline gap-3 pb-3 border-b border-stone-200">
            <span class="font-serif text-3xl sm:text-4xl font-bold text-stone-950" id="mainDisplayPrice" data-price-inr="<?= $price ?>">₹<?= number_format($price, 0) ?></span>
            <?php if ($compare_price > $price): ?>
            <span class="text-sm text-stone-400 line-through font-mono" id="compareDisplayPrice" data-price-inr="<?= $compare_price ?>">₹<?= number_format($compare_price, 0) ?></span>
            <span class="px-2.5 py-1 bg-amber-50 border border-amber-200 text-[#a16207] text-[10px] font-mono font-bold uppercase rounded-full">
              <?= $discount_pct ?>% Privilege Discount
            </span>
            <?php endif; ?>
          </div>
        </div>

        <!-- ── ATELIER PROVENANCE & DELIVERY PROMISE ── -->
        <div class="p-3.5 rounded-2xl bg-amber-50/60 border border-amber-200/80 shadow-2xs">
          <div class="flex items-center justify-between gap-2">
            <div class="flex items-center gap-2 text-stone-900 font-mono text-xs font-bold">
              <span class="material-symbols-outlined text-[#a16207] text-base">verified</span>
              <span>Complimentary White-Glove Dispatch</span>
            </div>
            <span class="text-[10px] font-mono text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
              BlueDart Priority
            </span>
          </div>
          <p class="text-[11px] font-mono text-stone-600 mt-1">
            Individually inspected, cedar-packaged &amp; hand-numbered with certificate of provenance.
          </p>
        </div>

        <?php 
          $detail_pts = !empty($product['reward_points']) ? (int)$product['reward_points'] : max(1, round($price * 0.06));
          $gold_pts = round($detail_pts * 1.5);
        ?>
        <!-- VIP Loyalty Points Earned Badge -->
        <div class="flex items-center justify-between gap-3 text-xs font-mono text-amber-950 bg-gradient-to-r from-amber-50 via-[#fef3c7]/60 to-amber-50 border border-amber-200/90 p-3 rounded-2xl shadow-2xs">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-amber-500/15 border border-amber-400/40 flex items-center justify-center text-amber-700 flex-shrink-0">
              <span class="material-symbols-outlined text-base">toll</span>
            </div>
            <div>
              <span class="font-bold text-stone-950 block text-[11.5px]">Earn +<span id="detailPointsVal"><?= number_format($detail_pts) ?></span> Atelier Reward Points</span>
              <span class="text-[10px] text-stone-500">₹<span id="detailCashbackVal"><?= number_format($detail_pts) ?></span>.00 Instant Cash Credit · 1.5× for Gold (<?= number_format($gold_pts) ?> pts)</span>
            </div>
          </div>
          <span class="px-2.5 py-1 rounded-full bg-amber-400/20 text-amber-900 font-bold text-[9.5px] border border-amber-300">
            1 Pt = ₹1
          </span>
        </div>

        <!-- Short Description -->
        <p class="text-stone-600 text-xs sm:text-sm leading-relaxed font-light font-sans">
          <?= htmlspecialchars($short_desc) ?>
        </p>

        <!-- VIP Privilege Discount Coupon Box -->
        <div class="p-3.5 rounded-2xl bg-amber-50/70 border border-amber-200 flex items-center justify-between gap-3">
          <div class="flex items-center gap-2.5">
            <span class="material-symbols-outlined text-[#a16207] text-lg">workspace_premium</span>
            <div>
              <span class="text-[10px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">VIP Privilege Code</span>
              <span class="font-mono text-xs font-bold text-stone-900">LUMINA50 (Instant 50% Privilege)</span>
            </div>
          </div>
          <button type="button" onclick="applyVipCoupon()" id="btnApplyVip" class="px-4 py-2 rounded-xl bg-stone-950 hover:bg-stone-800 text-[#e9c176] font-mono text-xs font-bold uppercase tracking-wider transition-all shadow-sm cursor-pointer">
            Apply
          </button>
        </div>

        <!-- ── Tactile Shade Swatch Selector ── -->
        <div>
          <div class="flex justify-between items-center mb-2">
            <span class="text-xs font-mono uppercase tracking-wider text-stone-900 font-bold">
              Color Finish: <span class="text-[#a16207]" id="selectedColorName"><?= htmlspecialchars($color_shades[0]['name'] ?? 'Original') ?></span>
            </span>
            <span class="text-[10px] font-mono text-stone-400">Natural Garment Dyed</span>
          </div>

          <div class="flex items-center gap-3">
            <?php foreach ($color_shades as $sIdx => $shade): ?>
            <button type="button" 
                    onclick="selectColorShade('<?= htmlspecialchars(addslashes($shade['name'])) ?>', '<?= htmlspecialchars(addslashes($shade['img'])) ?>', this)"
                    class="color-shade-btn <?= $sIdx === 0 ? 'ring-2 ring-stone-950 scale-110' : 'opacity-75 hover:opacity-100' ?> w-8 h-8 rounded-full border-2 border-white shadow-md transition-all cursor-pointer" 
                    style="background-color: <?= $shade['hex'] ?>;" 
                    title="<?= htmlspecialchars($shade['name']) ?>">
            </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- ── Interactive Size Selector & Fit Advisor ── -->
        <div>
          <div class="flex justify-between items-center mb-2">
            <span class="text-xs font-mono uppercase tracking-wider text-stone-900 font-bold">
              Select Size: <span class="text-[#a16207]" id="selectedSizeLabel"><?= htmlspecialchars($available_sizes[0] ?? 'M') ?></span>
            </span>
            <button type="button" onclick="openSizeGuideModal()" class="text-xs font-mono text-[#a16207] hover:underline flex items-center gap-1 cursor-pointer font-bold">
              <span class="material-symbols-outlined text-sm">straighten</span>
              <span>Find My Size</span>
            </button>
          </div>

          <div class="flex flex-wrap gap-2">
            <?php foreach ($available_sizes as $szIdx => $sz): ?>
            <?php $isDefSz = ($szIdx === 0); ?>
            <button type="button" 
                    onclick="selectProductSize('<?= htmlspecialchars(addslashes($sz)) ?>', this)"
                    class="size-pill-btn <?= $isDefSz ? 'bg-stone-950 text-[#e9c176] font-bold shadow-md' : 'bg-stone-50 border border-stone-200 text-stone-800 hover:border-stone-900 hover:bg-stone-100' ?> py-2 px-3 text-center text-xs font-mono rounded-xl transition-all cursor-pointer">
              <span><?= htmlspecialchars($sz) ?></span>
              <span class="block text-[8px] text-stone-400 font-sans mt-0.5">In Stock</span>
            </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- ── Interactive Quantity Stepper ── -->
        <div class="flex items-center justify-between py-2 px-3.5 bg-stone-50 border border-stone-200 rounded-2xl shadow-2xs">
          <span class="text-xs font-mono uppercase tracking-wider text-stone-900 font-bold">Piece Quantity:</span>
          <div class="flex items-center gap-2.5">
            <button type="button" onclick="changePdpQuantity(-1)" class="w-7 h-7 rounded-lg bg-white hover:bg-stone-200 border border-stone-300 flex items-center justify-center font-bold text-xs cursor-pointer shadow-2xs text-stone-800 active:scale-95">-</button>
            <span id="pdpQuantityDisplay" class="w-6 text-center font-mono font-bold text-xs text-stone-950">1</span>
            <button type="button" onclick="changePdpQuantity(1)" class="w-7 h-7 rounded-lg bg-white hover:bg-stone-200 border border-stone-300 flex items-center justify-center font-bold text-xs cursor-pointer shadow-2xs text-stone-800 active:scale-95">+</button>
          </div>
        </div>

        <!-- ── VIRAL SOCIAL GROUP BUY VS SINGLE BUY OPTIONS ── -->
        <div class="grid grid-cols-2 gap-2 pt-1">
          <!-- Option A: Standard Single Buy -->
          <div class="p-3 rounded-2xl border-2 border-stone-900 bg-stone-50 text-center cursor-pointer relative" onclick="openExpressCheckout(<?= $product['id'] ?>, '<?= addslashes(htmlspecialchars($product_title)) ?>', <?= $price ?>, '<?= addslashes(htmlspecialchars($primary_image)) ?>', <?= $product['id'] ?>);">
            <div class="text-[10px] font-mono uppercase text-stone-500 font-bold">Single Purchase</div>
            <div class="font-serif text-lg font-bold text-stone-950 mt-0.5">₹<?= number_format($price, 0) ?></div>
            <div class="text-[9px] font-mono text-stone-400">Standard Delivery</div>
          </div>
          
          <!-- Option B: Social Team Group Buy (40% OFF) -->
          <div class="p-3 rounded-2xl border-2 border-pink-500 bg-gradient-to-br from-pink-50 to-rose-50 text-center cursor-pointer relative shadow-sm hover:scale-[1.02] transition-transform" onclick="openGroupBuyModal(<?= $product['id'] ?>, '<?= addslashes(htmlspecialchars($product_title)) ?>', <?= round($price * 0.6) ?>, '<?= addslashes(htmlspecialchars($primary_image)) ?>');">
            <span class="absolute -top-2.5 right-2 px-2 py-0.5 bg-pink-600 text-white font-mono text-[9px] font-extrabold uppercase rounded-full shadow-xs">40% OFF TEAM</span>
            <div class="text-[10px] font-mono uppercase text-pink-700 font-bold flex items-center justify-center gap-1">
              <span class="material-symbols-outlined text-xs">group</span>
              <span>Team Buy (3 Friends)</span>
            </div>
            <div class="font-serif text-lg font-bold text-pink-700 mt-0.5">₹<?= number_format(round($price * 0.6), 0) ?></div>
            <div class="text-[9px] font-mono text-pink-600 font-semibold">Invite 2 Friends</div>
          </div>
        </div>

        <!-- ── DUAL HIGH-CONVERTING ACQUISITION BUTTONS (DESKTOP) ── -->
        <div class="space-y-2.5 pt-1">
          
          <!-- Primary 1-Click Instant Acquisition -->
          <button type="button" 
                  id="btnPdpBuyNow"
                  onclick="handlePdpBuyNow()"
                  aria-label="Buy Now with 1-Click"
                  class="w-full py-3.5 px-6 bg-gradient-to-r from-amber-400 via-amber-300 to-[#e9c176] hover:opacity-95 text-stone-950 font-button font-extrabold text-xs sm:text-sm uppercase tracking-widest rounded-2xl shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-[0.99]">
            <span class="material-symbols-outlined text-lg">bolt</span>
            <span>Buy Now (1-Click)</span>
          </button>

          <!-- Add to Wardrobe Bag Button -->
          <div class="grid grid-cols-5 gap-2">
            <button type="button" 
                    id="btnPdpAddToCart"
                    onclick="handlePdpAddToCart()"
                    aria-label="Add to Wardrobe Bag"
                    class="col-span-4 py-3 px-6 bg-stone-950 hover:bg-stone-800 text-white font-button font-bold text-xs uppercase tracking-widest rounded-2xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer active:scale-[0.99]">
              <span class="material-symbols-outlined text-base">shopping_bag</span>
              <span>Add to Bag</span>
            </button>
            <div class="col-span-1 py-2 bg-stone-100 hover:bg-stone-200 border border-stone-300 rounded-2xl flex items-center justify-center transition-colors cursor-pointer shadow-sm relative overflow-hidden" title="Save to Wardrobe Wishlist">
              <div class="heart-container" title="Like">
                <input type="checkbox" class="checkbox" data-wishlist-id="<?= (int)$product['id'] ?>" onchange="toggleWishlistItem({id:<?= (int)$product['id'] ?>, title:'<?= addslashes(htmlspecialchars($product_title)) ?>', price:<?= $price ?>, image:'<?= addslashes(htmlspecialchars($primary_image)) ?>'}, event)">
                <div class="svg-container">
                  <svg viewBox="0 0 24 24" class="svg-outline" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Zm-3.585,18.4a2.973,2.973,0,0,1-3.83,0C4.947,16.006,2,11.87,2,8.967a4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,11,8.967a1,1,0,0,0,2,0,4.8,4.8,0,0,1,4.5-5.05A4.8,4.8,0,0,1,22,8.967C22,11.87,19.053,16.006,13.915,20.313Z"></path>
                  </svg>
                  <svg viewBox="0 0 24 24" class="svg-filled" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.5,1.917a6.4,6.4,0,0,0-5.5,3.3,6.4,6.4,0,0,0-5.5-3.3A6.8,6.8,0,0,0,0,8.967c0,4.547,4.786,9.513,8.8,12.88a4.974,4.974,0,0,0,6.4,0C19.214,18.48,24,13.514,24,8.967A6.8,6.8,0,0,0,17.5,1.917Z"></path>
                  </svg>
                  <svg class="svg-celebrate" width="100" height="100" xmlns="http://www.w3.org/2000/svg">
                    <polygon points="10,10 20,20"></polygon>
                    <polygon points="10,50 20,50"></polygon>
                    <polygon points="20,80 30,70"></polygon>
                    <polygon points="90,10 80,20"></polygon>
                    <polygon points="90,50 80,50"></polygon>
                    <polygon points="80,80 70,70"></polygon>
                  </svg>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- ── Real-Time BlueDart Pincode Delivery Estimator ── -->
        <div class="pt-3 border-t border-stone-200">
          <label class="text-[10px] font-mono uppercase tracking-widest text-stone-500 font-bold block mb-1.5">
            Check Doorstep Priority Express Dispatch
          </label>
          <div class="flex gap-2">
            <input type="text" id="pincodeInput" placeholder="Enter Pincode (e.g. 110001, 400001)" class="flex-1 px-4 py-2 bg-stone-50 border border-stone-200 rounded-xl text-xs font-mono text-stone-900 outline-none focus:border-stone-900 transition-colors">
            <button type="button" onclick="checkPincodeDelivery()" class="px-4 py-2 bg-stone-900 hover:bg-stone-800 text-white font-mono text-xs font-bold uppercase rounded-xl transition-all cursor-pointer">
              Verify
            </button>
          </div>
          <div id="pincodeResult" class="mt-2 text-xs font-mono text-emerald-600 hidden flex items-center gap-1.5 font-semibold">
            <span class="material-symbols-outlined text-sm">verified</span>
            <span id="pincodeText">Verified: Guaranteed BlueDart Express Delivery in 24-48 hours.</span>
          </div>
        </div>

        <!-- Guarantee & Trust Badges -->
        <div class="pt-3 border-t border-stone-200 grid grid-cols-2 gap-2 text-[10px] text-stone-600 font-mono">
          <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-emerald-600 text-sm">verified_user</span>
            <span>100% Certified Mongolian Fiber</span>
          </div>
          <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[#a16207] text-sm">swap_horizontal_circle</span>
            <span>7-Day Doorstep Exchange</span>
          </div>
        </div>

        <!-- ── FOMO Mystery Drop & Waitlist Triggers ── -->
        <div class="grid grid-cols-2 gap-2 pt-2 border-t border-stone-100">
          <button type="button" onclick="openMysteryDropModal()" class="p-2.5 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-200 text-purple-900 flex items-center justify-between transition-all cursor-pointer">
            <div class="flex items-center gap-1.5 min-w-0">
              <span class="text-sm">🎁</span>
              <div class="text-left min-w-0">
                <span class="font-bold text-[10px] block truncate">Mystery Drop</span>
                <span class="text-[9px] text-purple-700 font-mono">From ₹799 (3x Value)</span>
              </div>
            </div>
            <span class="material-symbols-outlined text-xs text-purple-600">arrow_forward</span>
          </button>
          <button type="button" onclick="openWaitlistModal(<?= (int)($product['id'] ?? 1) ?>, '<?= addslashes(htmlspecialchars($product_title)) ?>')" class="p-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-900 flex items-center justify-between transition-all cursor-pointer">
            <div class="flex items-center gap-1.5 min-w-0">
              <span class="material-symbols-outlined text-amber-600 text-sm">notifications</span>
              <div class="text-left min-w-0">
                <span class="font-bold text-[10px] block truncate">VIP Restock Pass</span>
                <span class="text-[9px] text-amber-700 font-mono">Notify on Restock</span>
              </div>
            </div>
            <span class="material-symbols-outlined text-xs text-amber-600">arrow_forward</span>
          </button>
        </div>

      </div>

    </div>
  </section>


  <!-- ── 3. DYNAMIC EDITORIAL SPECIFICATIONS & CRAFTSMANSHIP (STUDIO SHOWCASE) ── -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-3xl border border-stone-200 shadow-xl p-6 sm:p-10 text-stone-900">
      <div class="flex items-center gap-2 mb-4">
        <span class="px-3 py-1 bg-amber-50 text-[#a16207] border border-amber-200 rounded-full text-xs font-mono font-bold uppercase tracking-wider">
          ✦ Editorial Story &amp; Specifications
        </span>
      </div>
      
      <div class="prose prose-stone max-w-none text-stone-700 leading-relaxed font-sans text-sm sm:text-base space-y-4">
        <?php 
          $formatted_desc = nl2br(htmlspecialchars($full_desc));
          $formatted_desc = preg_replace('/### (.*?)(<br \/>|\n)/i', '<h4 class="font-serif text-lg sm:text-xl font-bold text-stone-950 mt-4 mb-2 pb-1 border-b border-stone-200">$1</h4>', $formatted_desc);
          $formatted_desc = preg_replace('/\*\*(.*?)\*\*/', '<strong class="text-stone-900 font-bold">$1</strong>', $formatted_desc);
          echo $formatted_desc;
        ?>
      </div>
    </div>
  </section>

  <!-- ── 4. OBSIDIAN ATELIER CRAFT & ENGINEERING SHOWCASE (DRAMATIC BLACK CANVAS) ── -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-[#090a0f] rounded-3xl border border-white/15 shadow-2xl p-8 sm:p-12 md:p-14 text-white relative overflow-hidden">
      
      <!-- Ambient Golden Radial Lighting -->
      <div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full bg-amber-500/10 blur-[100px] pointer-events-none"></div>
      <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#e9c176_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

      <div class="max-w-3xl mb-10 relative z-10">
        <span class="text-xs font-mono uppercase tracking-[0.25em] text-[#e9c176] font-bold block mb-2">✦ The Anatomy of Atelier Craft</span>
        <h2 class="font-serif text-2xl sm:text-4xl text-white font-normal leading-tight">
          Engineered For Decades of Poise<span class="text-[#e9c176]">.</span>
        </h2>
        <p class="text-white/60 text-xs sm:text-sm mt-3 font-light font-sans leading-relaxed">
          Every silhouette is conceived without compromise, combining premium combed yarn spinning with durable double-needle stitching.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 pt-8 border-t border-white/10 relative z-10">
        
        <!-- Card 1 -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md hover:border-[#e9c176]/40 transition-all duration-300">
          <div class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-[#e9c176] mb-4 shadow-md">
            <span class="material-symbols-outlined text-2xl">texture</span>
          </div>
          <h4 class="font-serif text-base font-bold text-white mb-2">Raw Fiber Sourcing</h4>
          <p class="text-white/70 text-xs leading-relaxed font-light font-sans">
            Harvested exclusively during spring molting in the Mongolian steppes. Each individual fiber measures 14.5–15.2 microns in fineness for cloud-like thermal poise without bulk.
          </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md hover:border-[#e9c176]/40 transition-all duration-300">
          <div class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-[#e9c176] mb-4 shadow-md">
            <span class="material-symbols-outlined text-2xl">architecture</span>
          </div>
          <h4 class="font-serif text-base font-bold text-white mb-2">Double-Faced Tailoring</h4>
          <p class="text-white/70 text-xs leading-relaxed font-light font-sans">
            Two distinct woven layers are hand-split along seam margins and turned inward, followed by invisible single-needle hand-stitching that eliminates bulk and stiff linings.
          </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-md hover:border-[#e9c176]/40 transition-all duration-300">
          <div class="w-12 h-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-emerald-400 mb-4 shadow-md">
            <span class="material-symbols-outlined text-2xl">local_shipping</span>
          </div>
          <h4 class="font-serif text-base font-bold text-white mb-2">White-Glove Express Delivery</h4>
          <p class="text-white/70 text-xs leading-relaxed font-light font-sans">
            Dispatched via insured BlueDart Express in an archival cedar-lined dust garment box with solid brass hanger and a hand-numbered Certificate of Authenticity.
          </p>
        </div>

      </div>

    </div>
  </section>


  <!-- ── 4. COMPLETE THE WARDROBE (CURATED ARCHIVE RECOMMENDATIONS) ── -->
  <?php if (!empty($related)): ?>
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" id="curatedRelatedSection">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 pb-4 border-b border-stone-200">
      <div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#a16207] text-[10px] font-mono font-bold uppercase tracking-wider mb-2">
          <span class="material-symbols-outlined text-xs">auto_awesome</span>
          <span>Curated Styling Pairings</span>
        </div>
        <h3 class="font-serif text-2xl sm:text-3xl text-stone-950 font-bold">Complete the Wardrobe</h3>
        <p class="text-xs text-stone-500 font-light mt-1">Harmonious garments and accessories curated to pair with this piece.</p>
      </div>

      <div class="flex items-center gap-2">
        <a href="<?= base_url('shop') ?>" class="text-xs font-mono uppercase tracking-wider text-[#a16207] font-bold hover:underline">
          View All Archives →
        </a>
      </div>
    </div>

    <!-- Product Cards Grid for Related Items -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
      <?php foreach ($related as $r): ?>
      <?php 
        $r_img = !empty($r['primary_image']) ? $r['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
        $r_price = (float)($r['min_price'] ?? $r['base_price'] ?? 0);
      ?>
      <div class="group bg-white rounded-2xl border border-stone-200 hover:border-[#a16207]/60 p-3 flex flex-col justify-between shadow-xs hover:shadow-xl transition-all duration-300">
        <div>
          <a href="<?= base_url('products/' . $r['slug']) ?>" class="block relative aspect-[3/4] bg-stone-100 rounded-xl overflow-hidden mb-3">
            <img src="<?= htmlspecialchars($r_img) ?>" alt="<?= htmlspecialchars($r['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
          </a>
          <span class="text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold block mb-1"><?= htmlspecialchars($r['vendor'] ?? 'Atelier') ?></span>
          <h4 class="font-serif text-xs sm:text-sm font-bold text-stone-900 line-clamp-1 mb-1 group-hover:text-[#a16207] transition-colors">
            <a href="<?= base_url('products/' . $r['slug']) ?>"><?= htmlspecialchars($r['title']) ?></a>
          </h4>
          <span class="font-serif font-bold text-sm text-stone-950 block" data-price-inr="<?= $r_price ?>">₹<?= number_format($r_price, 0) ?></span>
        </div>
        <div class="pt-3 mt-2 border-t border-stone-100 flex items-center gap-1.5">
          <a href="<?= base_url('products/' . $r['slug']) ?>" class="flex-1 py-2 bg-stone-950 hover:bg-stone-800 text-white font-mono text-[10px] uppercase font-bold tracking-wider rounded-xl text-center transition-all">
            View Piece
          </a>
          <button type="button" 
                  onclick="addToCart({id:<?= (int)$r['id'] ?>, title:'<?= addslashes(htmlspecialchars($r['title'])) ?>', price:<?= $r_price ?>, image:'<?= addslashes($r_img) ?>'}, 1)"
                  class="p-2 bg-stone-100 hover:bg-stone-200 text-stone-900 rounded-xl transition-colors cursor-pointer"
                  title="Add to Bag">
            <span class="material-symbols-outlined text-sm">shopping_bag</span>
          </button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </section>
  <?php endif; ?>


  <!-- ── 5. VERIFIED CLIENT REVIEWS SECTION ── -->
  <?php
    $has_db_reviews = !empty($reviews);
    $review_count = count($reviews ?? []);
    $avg_rating = $has_db_reviews
        ? round(array_sum(array_column($reviews, 'rating')) / $review_count, 1)
        : 4.98;
    $is_logged_in = (bool)$this->session->userdata('customer_id');
  ?>
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" id="client-reviews-section">
    <div class="bg-white rounded-3xl border border-stone-200 shadow-md p-6 sm:p-10 md:p-12">
      
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8 pb-6 border-b border-stone-200">
        <div>
          <span class="text-xs font-mono uppercase tracking-[0.25em] text-[#a16207] font-bold block mb-1.5">Client Provenance</span>
          <h3 class="font-serif text-2xl sm:text-3xl text-stone-950 font-bold">Voices from the Atelier Collective</h3>
        </div>
        <div class="flex flex-wrap items-center gap-4">
          <div class="text-right">
            <div class="flex items-center gap-1 text-amber-500 font-bold text-base justify-end">
              <?php for ($s = 1; $s <= 5; $s++): ?>
                <span><?= $s <= round($avg_rating) ? '★' : '☆' ?></span>
              <?php endfor; ?>
              <span class="text-stone-900 text-sm ml-1"><?= number_format($avg_rating, 2) ?> / 5.0</span>
            </div>
            <span class="text-[11px] font-mono text-stone-500">
              <?= $has_db_reviews ? "Based on {$review_count} Verified Review" . ($review_count > 1 ? 's' : '') : 'Based on Atelier Verified Acquisitions' ?>
            </span>
          </div>
          <button type="button" onclick="openReviewModal()" class="px-5 py-2.5 bg-stone-950 hover:bg-stone-800 text-white font-mono text-xs uppercase tracking-wider font-bold rounded-xl shadow transition-all cursor-pointer flex items-center gap-2">
            <span class="text-[#e9c176]">★</span> Write a Review
          </button>
        </div>
      </div>

      <!-- Reviews Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="reviewsListGrid">
        <?php if ($has_db_reviews): ?>
          <?php foreach ($reviews as $rev): ?>
            <?php
              $r_name = htmlspecialchars($rev['name'] ?? 'Verified Client');
              $initials = strtoupper(substr($r_name, 0, 2));
              $r_rating = max(1, min(5, (int)($rev['rating'] ?? 5)));
              $is_ver = !empty($rev['is_verified']) || !empty($rev['order_id']);
            ?>
            <div class="p-6 rounded-2xl bg-stone-50 border border-stone-200 flex flex-col justify-between" id="review-card-<?= $rev['id'] ?>">
              <div>
                <div class="flex justify-between items-start mb-3">
                  <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-full bg-stone-900 text-[#e9c176] font-mono text-xs font-bold flex items-center justify-center flex-shrink-0"><?= $initials ?></span>
                    <div>
                      <h5 class="text-xs font-bold text-stone-900"><?= $r_name ?></h5>
                      <?php if ($is_ver): ?>
                        <span class="text-[10px] font-mono text-emerald-700 font-semibold flex items-center gap-0.5">
                          ✓ Verified Buyer
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="text-right">
                    <div class="text-amber-500 text-xs">
                      <?= str_repeat('★', $r_rating) . str_repeat('☆', 5 - $r_rating) ?>
                    </div>
                    <span class="text-[10px] font-mono text-stone-400 block mt-0.5"><?= date('M d, Y', strtotime($rev['created_at'])) ?></span>
                  </div>
                </div>

                <?php if (!empty($rev['title'])): ?>
                  <h6 class="text-xs font-bold text-stone-900 mb-1"><?= htmlspecialchars($rev['title']) ?></h6>
                <?php endif; ?>
                <p class="text-stone-700 text-xs sm:text-sm leading-relaxed font-light">
                  "<?= nl2br(htmlspecialchars($rev['body'] ?? '')) ?>"
                </p>
              </div>

              <div class="mt-4 pt-3 border-t border-stone-200/70 flex justify-between items-center text-[11px] font-mono text-stone-500">
                <span>Atelier Authenticated</span>
                <button type="button" onclick="markReviewHelpful(<?= (int)$rev['id'] ?>, this)" class="hover:text-stone-900 flex items-center gap-1 cursor-pointer transition-colors">
                  <span>👍 Helpful</span> (<span class="helpful-count"><?= (int)($rev['helpful_count'] ?? 0) ?></span>)
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Curated Editorial Benchmark Reviews -->
          <div class="p-6 rounded-2xl bg-stone-50 border border-stone-200">
            <div class="flex justify-between items-center mb-3">
              <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-stone-900 text-[#e9c176] font-mono text-xs font-bold flex items-center justify-center">AR</span>
                <div>
                  <h5 class="text-xs font-bold text-stone-900">Aarav Singhania</h5>
                  <span class="text-[10px] font-mono text-emerald-600 font-semibold">✓ Verified Buyer · Mumbai</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-amber-500 text-xs">★★★★★</div>
                <span class="text-[10px] font-mono text-stone-400">2 days ago</span>
              </div>
            </div>
            <p class="text-stone-700 text-xs sm:text-sm leading-relaxed font-light">
              "The double-faced cashmere is sublime. The fluid drop shoulder drapes effortlessly over tailored suits. The BlueDart express delivery arrived in Mumbai within 22 hours in a stunning wooden garment box."
            </p>
          </div>

          <div class="p-6 rounded-2xl bg-stone-50 border border-stone-200">
            <div class="flex justify-between items-center mb-3">
              <div class="flex items-center gap-2">
                <span class="w-8 h-8 rounded-full bg-stone-900 text-[#e9c176] font-mono text-xs font-bold flex items-center justify-center">NM</span>
                <div>
                  <h5 class="text-xs font-bold text-stone-900">Natasha Mehra</h5>
                  <span class="text-[10px] font-mono text-emerald-600 font-semibold">✓ Verified Buyer · New Delhi</span>
                </div>
              </div>
              <div class="text-right">
                <div class="text-amber-500 text-xs">★★★★★</div>
                <span class="text-[10px] font-mono text-stone-400">5 days ago</span>
              </div>
            </div>
            <p class="text-stone-700 text-xs sm:text-sm leading-relaxed font-light">
              "Impeccable single-needle finishing with no visible seam lines. It feels lighter than air yet remarkably warm. Truly rivaling Parisian couture houses at an authentic direct value."
            </p>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </section>


  <!-- ── 6. BESPOKE PRIVATE ATELIER SERVICE BANNER (OBSIDIAN NOIR) ── -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    <div class="bg-[#090a0f] rounded-3xl p-8 sm:p-12 md:p-14 border border-white/15 text-white flex flex-col lg:flex-row items-center justify-between gap-8 shadow-2xl relative overflow-hidden">
      
      <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-amber-500/10 blur-[80px] pointer-events-none"></div>

      <div class="flex items-center gap-6 relative z-10">
        <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/20 flex items-center justify-center flex-shrink-0 shadow-lg">
          <span class="material-symbols-outlined text-[#e9c176] text-3xl">straighten</span>
        </div>
        <div>
          <span class="text-[10px] font-mono text-[#e9c176] uppercase tracking-widest block mb-1 font-bold">Private Atelier Consultation</span>
          <h3 class="font-serif text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">Need Bespoke Custom Alterations?</h3>
          <p class="text-white/70 text-xs sm:text-sm leading-relaxed max-w-xl font-light">
            Our master tailors offer made-to-measure sleeve lengths, custom monogramming, and personalized private fittings at your residence.
          </p>
        </div>
      </div>

      <div class="flex flex-wrap items-center gap-3.5 flex-shrink-0 w-full lg:w-auto relative z-10">
        <a href="<?= base_url('shop') ?>" class="flex-1 lg:flex-initial px-8 py-3.5 bg-gradient-to-r from-amber-400 to-[#e9c176] text-black font-button text-xs uppercase tracking-widest font-bold hover:opacity-90 transition-all rounded-xl text-center shadow-xl">
          Explore All Archives →
        </a>
      </div>

    </div>
  </section>

</main>





<!-- ══════════════════════════════════════════════════════
     8. SIZE GUIDE & ATELIER MEASUREMENTS MODAL
══════════════════════════════════════════════════════ -->
<div id="sizeGuideModal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[120] hidden items-center justify-center p-4" onclick="if(event.target===this)closeSizeGuideModal()">
  <div class="bg-white p-6 sm:p-8 rounded-3xl max-w-xl w-full border border-stone-200 shadow-2xl text-stone-900 max-h-[90vh] overflow-y-auto custom-scrollbar">
    <div class="flex justify-between items-center pb-4 mb-5 border-b border-stone-200">
      <div>
        <span class="text-[10px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">Atelier Tailoring Guide</span>
        <h3 class="font-serif text-xl font-bold text-stone-950">Silhouette &amp; Body Measurements</h3>
      </div>
      <button type="button" onclick="closeSizeGuideModal()" class="w-8 h-8 rounded-full bg-stone-100 text-stone-600 hover:text-stone-950 flex items-center justify-center cursor-pointer">
        ✕
      </button>
    </div>

    <table class="w-full text-xs font-mono text-left mb-6 border border-stone-200 rounded-xl overflow-hidden">
      <thead class="bg-stone-100 text-stone-900 uppercase font-bold">
        <tr>
          <th class="p-3 border-b border-stone-200">Size</th>
          <th class="p-3 border-b border-stone-200">Chest (in)</th>
          <th class="p-3 border-b border-stone-200">Shoulder (in)</th>
          <th class="p-3 border-b border-stone-200">Length (in)</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-stone-200 text-stone-700">
        <tr><td class="p-3 font-bold text-stone-900">XS</td><td class="p-3">36 - 38</td><td class="p-3">17.5</td><td class="p-3">41.0</td></tr>
        <tr><td class="p-3 font-bold text-stone-900">S</td><td class="p-3">38 - 40</td><td class="p-3">18.0</td><td class="p-3">41.5</td></tr>
        <tr class="bg-amber-50/60 font-bold text-[#a16207]"><td class="p-3">M (Reference)</td><td class="p-3">40 - 42</td><td class="p-3">18.5</td><td class="p-3">42.0</td></tr>
        <tr><td class="p-3 font-bold text-stone-900">L</td><td class="p-3">42 - 44</td><td class="p-3">19.0</td><td class="p-3">42.5</td></tr>
        <tr><td class="p-3 font-bold text-stone-900">XL</td><td class="p-3">44 - 46</td><td class="p-3">19.5</td><td class="p-3">43.0</td></tr>
      </tbody>
    </table>

    <p class="text-xs text-stone-500 font-light leading-relaxed mb-4">
      * All coats feature a relaxed drop-shoulder cut. If you prefer a tailored slim silhouette, we recommend taking one size down.
    </p>

    <button type="button" onclick="closeSizeGuideModal()" class="w-full py-3 bg-stone-950 text-white font-mono text-xs uppercase font-bold rounded-xl cursor-pointer">
      Got It, Back to Coat
    </button>
  </div>
</div>


<!-- ══════════════════════════════════════════════════════
     9. FULLSCREEN STUDIO LOOKBOOK MODAL
══════════════════════════════════════════════════════ -->
<div id="productGalleryModal" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[130] hidden items-center justify-center p-4 md:p-8" onclick="if(event.target===this)closeProductGalleryModal()">
  <div class="bg-[#0b0c10] p-6 rounded-3xl max-w-4xl w-full border border-white/20 text-white shadow-2xl relative max-h-[92vh] overflow-y-auto custom-scrollbar">
    <div class="flex justify-between items-center pb-4 mb-6 border-b border-white/15">
      <h3 class="font-serif text-xl font-bold text-white"><?= htmlspecialchars($product_title) ?> · High-Res Archive</h3>
      <button type="button" onclick="closeProductGalleryModal()" class="w-10 h-10 rounded-full bg-white/10 text-white flex items-center justify-center cursor-pointer">✕</button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <?php foreach ($gallery_images as $fImg): ?>
      <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-black/70 border border-white/15">
        <img src="<?= htmlspecialchars($fImg) ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" alt="Studio Look">
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     10. WRITE PRODUCT REVIEW MODAL
══════════════════════════════════════════════════════ -->
<div id="productReviewModal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[125] hidden items-center justify-center p-4" onclick="if(event.target===this)closeReviewModal()">
  <div class="bg-white p-6 sm:p-8 rounded-3xl max-w-lg w-full border border-stone-200 shadow-2xl text-stone-900 relative max-h-[90vh] overflow-y-auto custom-scrollbar">
    <div class="flex justify-between items-center pb-4 mb-5 border-b border-stone-200">
      <div>
        <span class="text-[10px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">Client Provenance</span>
        <h3 class="font-serif text-xl font-bold text-stone-950">Review <?= htmlspecialchars($product_title) ?></h3>
      </div>
      <button type="button" onclick="closeReviewModal()" class="w-8 h-8 rounded-full bg-stone-100 text-stone-600 hover:text-stone-950 flex items-center justify-center cursor-pointer">
        ✕
      </button>
    </div>

    <?php if (!$is_logged_in): ?>
      <div class="text-center py-6">
        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3 text-xl">
          🔒
        </div>
        <h4 class="font-serif font-bold text-stone-900 mb-2">Member Authentication Required</h4>
        <p class="text-xs text-stone-600 mb-5 leading-relaxed">
          To preserve authentic provenance, reviews may only be submitted by verified account holders.
        </p>
        <a href="<?= base_url('customers/auth/login?redirect=' . urlencode(current_url())) ?>" class="inline-block px-6 py-3 bg-stone-950 text-white font-mono text-xs uppercase tracking-wider font-bold rounded-xl shadow hover:bg-stone-800 transition-all">
          Sign In to Account →
        </a>
      </div>
    <?php else: ?>
      <form id="reviewSubmissionForm" onsubmit="submitProductReview(event)">
        <!-- Rating Stars Selector -->
        <div class="mb-4">
          <label class="block text-xs font-mono uppercase font-bold text-stone-700 mb-1.5">Rating Experience</label>
          <div class="flex items-center gap-1.5" id="starRatingSelector">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <button type="button" onclick="setReviewRating(<?= $i ?>)" class="text-2xl text-amber-500 hover:text-amber-500 transition-colors star-btn cursor-pointer" data-rating="<?= $i ?>">★</button>
            <?php endfor; ?>
            <span class="text-xs font-mono text-stone-500 ml-2" id="ratingTextDesc">5 Stars — Flawless</span>
          </div>
          <input type="hidden" id="reviewRatingInput" name="rating" value="5">
        </div>

        <div class="mb-4">
          <label class="block text-xs font-mono uppercase font-bold text-stone-700 mb-1.5">Headline Summary</label>
          <input type="text" id="reviewTitleInput" name="title" placeholder="e.g. Exceptional hand-feel and immaculate drape" required class="w-full px-4 py-2.5 text-xs font-mono bg-stone-50 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-stone-900 text-stone-900 placeholder-stone-400">
        </div>

        <div class="mb-5">
          <label class="block text-xs font-mono uppercase font-bold text-stone-700 mb-1.5">Detailed Impression</label>
          <textarea id="reviewBodyInput" name="body" rows="4" placeholder="Share your experience regarding texture, craftsmanship, sizing, and packaging..." required class="w-full px-4 py-2.5 text-xs font-mono bg-stone-50 border border-stone-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-stone-900 text-stone-900 placeholder-stone-400 leading-relaxed"></textarea>
        </div>

        <div id="reviewFeedbackAlert" class="hidden mb-4 p-3 rounded-xl text-xs font-mono"></div>

        <div class="flex items-center justify-end gap-3">
          <button type="button" onclick="closeReviewModal()" class="px-5 py-2.5 text-stone-600 hover:text-stone-900 font-mono text-xs uppercase font-bold cursor-pointer">Cancel</button>
          <button type="submit" id="submitReviewBtn" class="px-6 py-2.5 bg-stone-950 text-white font-mono text-xs uppercase tracking-wider font-bold rounded-xl shadow hover:bg-stone-800 transition-all cursor-pointer">
            Publish Review →
          </button>
        </div>
      </form>
    <?php endif; ?>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     11. MOBILE STICKY BOTTOM ACTION BAR (SAFE-AREA AWARE)
══════════════════════════════════════════════════════ -->
<aside id="mobileStickyBar" 
     class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-stone-200 px-4 py-2.5 shadow-[0_-8px_30px_rgba(0,0,0,0.12)] transition-transform duration-300"
     style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom, 0px));"
     aria-label="Quick acquisition bar">
  <div class="max-w-md mx-auto flex items-center gap-3">
    <!-- Selected Item Preview -->
    <div class="min-w-[75px] flex-shrink-0">
      <span class="font-serif text-base font-bold text-stone-950 block leading-none" id="mobileStickyPrice">₹<?= number_format($price, 0) ?></span>
      <span class="text-[10px] font-mono text-stone-500 uppercase tracking-tight block truncate mt-1" id="mobileStickySub">
        Size <span id="mobileStickySize"><?= htmlspecialchars($available_sizes[0] ?? 'M') ?></span>
      </span>
    </div>

    <!-- Add to Bag (≥44px tap target) -->
    <button type="button" 
            onclick="handlePdpAddToCart()" 
            aria-label="Add to Wardrobe Bag"
            class="flex-1 h-12 bg-stone-950 hover:bg-stone-800 active:scale-98 text-white font-button font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-sm flex items-center justify-center gap-1.5 cursor-pointer">
      <span class="material-symbols-outlined text-base">shopping_bag</span>
      <span>Add to Bag</span>
    </button>

    <!-- Buy Now (≥44px tap target) -->
    <button type="button" 
            id="btnMobileBuyNow"
            onclick="handlePdpBuyNow()" 
            aria-label="Buy Now with 1-Click"
            class="flex-1 h-12 bg-gradient-to-r from-amber-400 via-amber-300 to-[#e9c176] hover:opacity-95 active:scale-98 text-stone-950 font-button font-extrabold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer">
      <span class="material-symbols-outlined text-base">bolt</span>
      <span>Buy Now</span>
    </button>
  </div>
</aside>

<!-- ══════════════════════════════════════════════════════
     12. 1-CLICK BUY NOW CONFIRM MODAL (BOTTOM SHEET ON MOBILE)
══════════════════════════════════════════════════════ -->
<div id="buyNowModal" 
     class="fixed inset-0 bg-black/80 backdrop-blur-md z-[150] hidden items-end sm:items-center justify-center p-0 sm:p-4 transition-all duration-300" 
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="buyNowModalTitle"
     onclick="if(event.target===this)closeBuyNowModal()">
  
  <div class="bg-white rounded-t-3xl sm:rounded-3xl max-w-lg w-full border border-stone-200 shadow-2xl text-stone-900 max-h-[92vh] flex flex-col overflow-hidden animate-in fade-in slide-in-from-bottom duration-300">
    
    <!-- Modal Header -->
    <div class="flex justify-between items-center px-6 py-4 border-b border-stone-200 bg-stone-50/80">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
        <div>
          <span class="text-[10px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">1-Click Fast-Path</span>
          <h3 id="buyNowModalTitle" class="font-serif text-lg font-bold text-stone-950">Confirm Instant Acquisition</h3>
        </div>
      </div>
      <button type="button" 
              onclick="closeBuyNowModal()" 
              aria-label="Close modal" 
              class="w-8 h-8 rounded-full bg-stone-200/80 hover:bg-stone-300 text-stone-700 flex items-center justify-center text-sm font-bold transition-colors cursor-pointer">
        ✕
      </button>
    </div>

    <!-- Scrollable Modal Content Body -->
    <div class="p-6 space-y-4 overflow-y-auto custom-scrollbar flex-1">
      
      <!-- Error & Warning Alert Banner -->
      <div id="buyNowErrorAlert" class="hidden p-3.5 rounded-2xl text-xs font-mono border"></div>

      <!-- Item Preview & Quantity Stepper Card -->
      <div class="p-3.5 bg-stone-50 rounded-2xl border border-stone-200 flex gap-3.5 items-center">
        <div class="w-16 h-20 bg-white rounded-xl overflow-hidden border border-stone-200 flex-shrink-0 shadow-2xs">
          <img id="bnModalItemImg" src="<?= htmlspecialchars($primary_image) ?>" alt="<?= htmlspecialchars($product_title) ?>" class="w-full h-full object-cover">
        </div>
        <div class="flex-1 min-w-0">
          <h4 id="bnModalItemTitle" class="font-serif text-sm font-bold text-stone-950 truncate"><?= htmlspecialchars($product_title) ?></h4>
          <div class="flex items-center gap-2 mt-1">
            <span id="bnModalItemSize" class="px-2 py-0.5 rounded-md bg-stone-200 text-stone-800 text-[10px] font-mono font-semibold">Size M</span>
            <span id="bnModalItemColor" class="px-2 py-0.5 rounded-md bg-stone-200 text-stone-800 text-[10px] font-mono font-semibold">Original</span>
          </div>
          <div class="flex items-center justify-between mt-2 pt-1.5 border-t border-stone-200/60">
            <span class="font-serif text-sm font-bold text-stone-950" id="bnModalItemUnitPrice">₹<?= number_format($price, 0) ?></span>
            
            <!-- Quantity Controls in Modal -->
            <div class="flex items-center gap-2">
              <span class="text-[10px] font-mono text-stone-500 uppercase">Qty:</span>
              <button type="button" onclick="changeBuyNowModalQty(-1)" class="w-6 h-6 rounded-md bg-white hover:bg-stone-200 border border-stone-300 flex items-center justify-center font-bold text-xs text-stone-800 cursor-pointer active:scale-95">-</button>
              <span id="bnModalQtyDisplay" class="w-5 text-center font-mono font-bold text-xs text-stone-950">1</span>
              <button type="button" onclick="changeBuyNowModalQty(1)" class="w-6 h-6 rounded-md bg-white hover:bg-stone-200 border border-stone-300 flex items-center justify-center font-bold text-xs text-stone-800 cursor-pointer active:scale-95">+</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Financial Summary Accordion -->
      <div class="p-3.5 bg-white rounded-2xl border border-stone-200 space-y-2 text-xs font-mono">
        <div class="flex justify-between text-stone-600">
          <span>Subtotal:</span>
          <span id="bnModalSubtotal" class="text-stone-900 font-semibold">₹<?= number_format($price, 0) ?></span>
        </div>
        <div id="bnModalDiscountRow" class="hidden flex justify-between text-emerald-700 font-semibold bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
          <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs">savings</span> Privilege Discount:</span>
          <span id="bnModalDiscount">-₹0</span>
        </div>
        <div class="flex justify-between text-stone-600">
          <span>White-Glove Express Dispatch:</span>
          <span id="bnModalShipping" class="text-emerald-700 font-bold">COMPLIMENTARY</span>
        </div>
        <div class="flex justify-between text-stone-500 text-[11px]">
          <span>GST Included (18%):</span>
          <span id="bnModalTax">₹0</span>
        </div>
        <div class="pt-2 border-t border-stone-200 flex justify-between items-baseline">
          <span class="font-sans font-bold text-stone-900 text-sm">Total Payable:</span>
          <span id="bnModalTotal" class="font-serif font-bold text-xl text-stone-950">₹<?= number_format($price, 0) ?></span>
        </div>
      </div>

      <!-- Subscribe & Save Options Card -->
      <div id="bnSubscriptionCard" class="hidden p-3.5 bg-stone-50 border border-stone-200 rounded-2xl space-y-2">
        <div class="flex items-center justify-between">
          <span class="text-[10px] font-mono uppercase tracking-wider text-stone-500 font-bold flex items-center gap-1">
            <span class="material-symbols-outlined text-xs text-indigo-600">autorenew</span>
            <span>Delivery Schedule</span>
          </span>
          <span class="text-[10px] font-mono text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200" id="bnSubDiscountBadge">
            Save 10% Every Order
          </span>
        </div>
        <div class="grid grid-cols-2 gap-2">
          <label class="p-2.5 bg-white rounded-xl border border-stone-200 flex items-center gap-2 cursor-pointer transition-all hover:border-stone-900 has-[:checked]:border-stone-950 has-[:checked]:bg-stone-950 has-[:checked]:text-[#e9c176]">
            <input type="radio" name="bn_purchase_type" value="onetime" checked onchange="onBuyNowSubscriptionToggled(false)" class="accent-stone-950">
            <div class="text-[11px] font-mono font-bold">One-Time</div>
          </label>
          <label class="p-2.5 bg-white rounded-xl border border-stone-200 flex items-center gap-2 cursor-pointer transition-all hover:border-stone-900 has-[:checked]:border-stone-950 has-[:checked]:bg-stone-950 has-[:checked]:text-[#e9c176]">
            <input type="radio" name="bn_purchase_type" value="subscription" onchange="onBuyNowSubscriptionToggled(true)" class="accent-stone-950">
            <div class="text-[11px] font-mono font-bold">Subscribe &amp; Save</div>
          </label>
        </div>
      </div>

      <!-- VIP Loyalty Points 1-Tap Toggle -->
      <div id="bnLoyaltyCard" class="hidden p-3.5 bg-amber-50/70 border border-amber-200/80 rounded-2xl transition-all">
        <div class="flex items-center justify-between gap-2">
          <label class="flex items-center gap-2.5 cursor-pointer select-none">
            <input type="checkbox" id="bnUseLoyaltyPoints" onchange="onBuyNowLoyaltyToggled(this.checked)" class="accent-stone-950 w-4 h-4 rounded cursor-pointer">
            <div>
              <span class="text-[11px] font-mono font-bold text-stone-900 block" id="bnLoyaltyTitle">
                ✨ You have <span id="bnLoyaltyPtsVal">0</span> points — apply ₹<span id="bnLoyaltyDiscVal">0</span> off
              </span>
              <span class="text-[10px] text-stone-500 font-sans">NovaDrop VIP Tier Privilege</span>
            </div>
          </label>
          <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-full bg-amber-200 text-[#a16207]" id="bnLoyaltyTierBadge">Bronze</span>
        </div>
      </div>

      <!-- Shipping Destination Card -->
      <div class="p-3.5 bg-stone-50 rounded-2xl border border-stone-200">
        <div class="flex justify-between items-center mb-1.5">
          <span class="text-[10px] font-mono uppercase tracking-wider text-stone-500 font-bold flex items-center gap-1">
            <span class="material-symbols-outlined text-xs text-emerald-600">home</span>
            <span>Delivery Destination</span>
          </span>
          <button type="button" onclick="toggleBuyNowAddressPicker()" id="bnChangeAddrBtn" class="text-[11px] font-mono text-[#a16207] hover:underline font-bold cursor-pointer">
            Change Address
          </button>
        </div>

        <div id="bnModalActiveAddress" class="text-xs text-stone-800 leading-relaxed font-sans">
          <strong id="bnAddrName" class="text-stone-950 font-bold block">Customer</strong>
          <span id="bnAddrLine1" class="text-stone-600 block">Loading destination...</span>
          <span id="bnAddrCityState" class="text-stone-600 block"></span>
          <span id="bnAddrPhone" class="text-stone-500 text-[11px] font-mono block mt-0.5"></span>
        </div>

        <!-- Address Picker Dropdown (Hidden initially) -->
        <div id="bnAddressPickerDrawer" class="hidden mt-3 pt-3 border-t border-stone-200 space-y-2">
          <label class="text-[10px] font-mono uppercase text-stone-500 font-bold block">Select Saved Address:</label>
          <select id="bnAddressSelect" onchange="onBuyNowAddressSelected(this.value)" class="w-full text-xs bg-white border border-stone-300 p-2 rounded-xl text-stone-900 outline-none">
            <!-- Populated via preview API -->
          </select>
          <a href="<?= base_url('account') ?>" target="_blank" class="text-[10px] font-mono text-[#a16207] hover:underline inline-block mt-1">
            + Manage Addresses in Account →
          </a>
        </div>
      </div>

      <!-- Payment Method Mode Selector -->
      <div class="p-3.5 bg-stone-50 rounded-2xl border border-stone-200">
        <div class="flex justify-between items-center mb-2">
          <span class="text-[10px] font-mono uppercase tracking-wider text-stone-500 font-bold flex items-center gap-1">
            <span class="material-symbols-outlined text-xs text-amber-600">account_balance_wallet</span>
            <span>Payment Method</span>
          </span>
          <span class="text-[10px] font-mono text-stone-400">Encrypted</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2" id="bnPaymentOptions">
          <!-- COD -->
          <label class="p-2.5 bg-white rounded-xl border border-stone-200 flex items-center gap-2 cursor-pointer hover:border-stone-900 transition-all has-[:checked]:border-stone-950 has-[:checked]:bg-stone-950 has-[:checked]:text-[#e9c176]">
            <input type="radio" name="bn_payment" value="cod" checked class="accent-stone-950">
            <div class="text-[11px] font-mono font-bold">Cash on Delivery</div>
          </label>

          <!-- Razorpay -->
          <label id="bnRazorpayLabel" class="p-2.5 bg-white rounded-xl border border-stone-200 flex items-center gap-2 cursor-pointer hover:border-stone-900 transition-all has-[:checked]:border-stone-950 has-[:checked]:bg-stone-950 has-[:checked]:text-[#e9c176]">
            <input type="radio" name="bn_payment" value="razorpay" class="accent-stone-950">
            <div class="text-[11px] font-mono font-bold">UPI / Cards</div>
          </label>

          <!-- Stripe -->
          <label id="bnStripeLabel" class="p-2.5 bg-white rounded-xl border border-stone-200 flex items-center gap-2 cursor-pointer hover:border-stone-900 transition-all has-[:checked]:border-stone-950 has-[:checked]:bg-stone-950 has-[:checked]:text-[#e9c176]">
            <input type="radio" name="bn_payment" value="stripe" class="accent-stone-950">
            <div class="text-[11px] font-mono font-bold">Global Card</div>
          </label>
        </div>
      </div>

      <!-- Insured Logistics Note -->
      <div class="flex items-center gap-2 text-[10px] font-mono text-stone-500 bg-amber-50/50 p-2.5 rounded-xl border border-amber-200/50">
        <span class="material-symbols-outlined text-xs text-[#a16207]">verified_user</span>
        <span>Insured Courier Dispatch · Direct from Lumina Atelier Milan Vault</span>
      </div>

    </div>

    <!-- Modal Footer Actions (Place Order) -->
    <div class="p-4 sm:p-6 border-t border-stone-200 bg-stone-50/80 flex flex-col gap-2">
      <button type="button" 
              id="btnBuyNowSubmit"
              onclick="executeBuyNowOrder()"
              aria-label="Confirm and Place Order"
              class="w-full py-4 px-6 bg-gradient-to-r from-amber-400 via-amber-300 to-[#e9c176] hover:opacity-95 active:scale-[0.99] text-stone-950 font-button font-extrabold text-sm uppercase tracking-widest rounded-2xl shadow-xl transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:pointer-events-none">
        <span class="material-symbols-outlined text-lg" id="btnBuyNowIcon">bolt</span>
        <span id="btnBuyNowSubmitText">Place Order · ₹<?= number_format($price, 0) ?></span>
      </button>

      <div class="text-center text-[10px] font-mono text-stone-400 flex items-center justify-center gap-3">
        <span>Idempotency Protected</span>
        <span>•</span>
        <span>Zero Cart Pollution</span>
        <span>•</span>
        <span>256-Bit SSL</span>
      </div>
    </div>

  </div>
</div>

<script>
const pdpEnsembleLooksData = <?= json_encode($ensemble_looks ?? []) ?>;
let currentProductPrice = <?= $price ?>;

// ── Horizontal Rail Scroll ──
function scrollEnsembleRail(offset) {
  const track = document.getElementById('pdpEnsembleTrack');
  if (track) {
    track.scrollBy({ left: offset, behavior: 'smooth' });
  }
}

// ── Photo Thumbnail Selector ──
function selectMainPhoto(imgUrl, btn) {
  const photo = document.getElementById('mainProductPhoto');
  if (photo) {
    photo.style.opacity = '0.3';
    setTimeout(() => {
      photo.src = imgUrl;
      photo.style.opacity = '1';
    }, 150);
  }

  document.querySelectorAll('.gallery-thumb-btn').forEach(b => {
    b.classList.remove('ring-2', 'ring-stone-950', 'scale-[1.02]');
    b.classList.add('opacity-70');
  });
  btn.classList.add('ring-2', 'ring-stone-950', 'scale-[1.02]');
  btn.classList.remove('opacity-70');
}

// ── Global PDP Selection State ──
window.pdpSelectedSize = '<?= !empty($available_sizes[0]) ? addslashes($available_sizes[0]) : "M" ?>';
window.pdpSelectedColor = '<?= !empty($color_shades[0]["name"]) ? addslashes($color_shades[0]["name"]) : "Original Finish" ?>';
window.pdpSelectedQuantity = 1;

window.changePdpQuantity = function(delta) {
  window.pdpSelectedQuantity = Math.max(1, Math.min(20, (window.pdpSelectedQuantity || 1) + delta));
  const el = document.getElementById('pdpQuantityDisplay');
  if (el) el.textContent = window.pdpSelectedQuantity;
};

// ── Tactile Shade Swatch Switcher ──
function selectColorShade(shadeName, imgUrl, btn) {
  window.pdpSelectedColor = shadeName;
  const label = document.getElementById('selectedColorName');
  const photoLabel = document.getElementById('activeShadePhotoLabel');
  if (label) label.textContent = shadeName;
  if (photoLabel) photoLabel.textContent = 'Shade: ' + shadeName;

  const photo = document.getElementById('mainProductPhoto');
  if (photo) {
    photo.style.opacity = '0.3';
    setTimeout(() => {
      photo.src = imgUrl;
      photo.style.opacity = '1';
    }, 150);
  }

  btn.closest('div').querySelectorAll('.color-shade-btn').forEach(b => {
    b.classList.remove('ring-2', 'ring-stone-950', 'scale-110');
    b.classList.add('opacity-75');
  });
  btn.classList.add('ring-2', 'ring-stone-950', 'scale-110');
  btn.classList.remove('opacity-75');
}

// ── Size Selector ──
function selectProductSize(sizeCode, btn) {
  window.pdpSelectedSize = sizeCode;
  const label = document.getElementById('selectedSizeLabel');
  if (label) label.textContent = sizeCode + ' (Selected)';
  const stickySize = document.getElementById('mobileStickySize');
  if (stickySize) stickySize.textContent = sizeCode;

  document.querySelectorAll('.size-pill-btn').forEach(b => {
    b.className = 'size-pill-btn bg-stone-50 border border-stone-200 text-stone-800 hover:border-stone-900 hover:bg-stone-100 py-2 px-3 text-center text-xs font-mono rounded-xl transition-all cursor-pointer';
  });
  btn.className = 'size-pill-btn bg-stone-950 text-[#e9c176] font-bold shadow-md py-2 px-3 text-center text-xs font-mono rounded-xl transition-all cursor-pointer';
}

// ── PDP Direct Add To Cart & Checkout with chosen Size/Color/Quantity ──
function handlePdpAddToCart() {
  const chosenSize = window.pdpSelectedSize || 'M';
  const chosenColor = window.pdpSelectedColor || '';
  const chosenQty = window.pdpSelectedQuantity || 1;
  addToCart({
    id: <?= (int)$product['id'] ?>,
    title: '<?= addslashes(htmlspecialchars($product_title)) ?>',
    price: currentProductPrice,
    image: '<?= addslashes(htmlspecialchars($primary_image)) ?>',
    size: chosenSize,
    color: chosenColor
  }, chosenQty, '✦ Added ' + chosenQty + 'x <?= addslashes(htmlspecialchars($product_title)) ?> (Size ' + chosenSize + ') to Bag!');
}

// ── 1-CLICK BUY NOW FAST-PATH CONTROLLER ──
window.currentBuyNowData = null;
window.buyNowPreload = <?= !empty($buy_now_preload) ? json_encode($buy_now_preload) : 'null' ?>;

function handlePdpBuyNow() {
  const chosenSize = window.pdpSelectedSize || 'M';
  const chosenColor = window.pdpSelectedColor || '';
  const chosenQty = window.pdpSelectedQuantity || 1;
  const currentVariantId = <?= (int)$default_variant['id'] ?>;
  const unitPrice = typeof currentProductPrice !== 'undefined' ? currentProductPrice : <?= (float)($default_variant['price'] ?: $product['base_price']) ?>;

  // 1. Instant Cache Fast-Path (Returning customer with saved address): 0ms opening!
  if (window.buyNowPreload && window.buyNowPreload.default_address) {
    const preload = window.buyNowPreload;
    const subtotal = Math.round(unitPrice * chosenQty);
    const shipping = subtotal >= 2999 ? 0 : 0; // Complimentary atelier shipping
    const tax = Math.round(subtotal * 0.12);
    const total = subtotal + shipping + tax;

    const instantData = {
      eligible: true,
      idempotency_key: preload.idempotency_key,
      item: {
        product_id: <?= (int)$product['id'] ?>,
        variant_id: currentVariantId,
        title: '<?= addslashes(htmlspecialchars($product_title)) ?>',
        size: chosenSize,
        color: chosenColor,
        quantity: chosenQty,
        unit_price: unitPrice,
        image: '<?= addslashes(htmlspecialchars($primary_image)) ?>',
        stock: 20
      },
      address: preload.default_address,
      saved_addresses: preload.saved_addresses || [preload.default_address],
      payment_method: preload.default_payment_method || 'cod',
      totals: {
        subtotal: subtotal,
        shipping_amount: shipping,
        tax_amount: tax,
        total: total
      },
      razorpay_enabled: true,
      stripe_enabled: false
    };

    window.currentBuyNowData = instantData;
    renderBuyNowModal(instantData);
    openBuyNowModal(); // Opens INSTANTLY, 0ms latency!

    // Asynchronously synchronize preview in background for exact GST & live server token
    const bgFd = new FormData();
    bgFd.append('variant_id', currentVariantId);
    bgFd.append('product_id', <?= (int)$product['id'] ?>);
    bgFd.append('quantity', chosenQty);
    bgFd.append('size', chosenSize);
    bgFd.append('color', chosenColor);
    bgFd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

    fetch('<?= base_url("checkout/buy_now_preview") ?>', {
      method: 'POST',
      body: bgFd,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
      if (res.eligible && res.totals) {
        window.currentBuyNowData = res;
        renderBuyNowModal(res);
      }
    })
    .catch(() => {});

    return;
  }

  // 2. Guest or no saved address: Immediate responsive spinner (< 50ms) and direct redirect
  const btnDesktop = document.getElementById('btnPdpBuyNow');
  const btnMobile = document.getElementById('btnMobileBuyNow');
  if (btnDesktop) {
    btnDesktop.disabled = true;
    btnDesktop.innerHTML = '<span class="material-symbols-outlined text-base animate-spin">progress_activity</span><span>Preparing Order...</span>';
  }
  if (btnMobile) {
    btnMobile.disabled = true;
    btnMobile.innerHTML = '<span class="material-symbols-outlined text-base animate-spin">progress_activity</span><span>...</span>';
  }

  window.location.href = '<?= base_url("checkout?buy_now=1") ?>&variant_id=' + currentVariantId + '&quantity=' + chosenQty;
}

function renderBuyNowModal(data) {
  const item = data.item;
  const totals = data.totals;
  const addr = data.address;

  document.getElementById('bnModalItemTitle').textContent = item.title || 'Curated Atelier Piece';
  document.getElementById('bnModalItemImg').src = item.image || '<?= addslashes(htmlspecialchars($primary_image)) ?>';
  document.getElementById('bnModalItemSize').textContent = 'Size ' + (item.size || 'M');
  document.getElementById('bnModalItemColor').textContent = item.color || 'Original Finish';
  document.getElementById('bnModalItemUnitPrice').textContent = '₹' + Math.round(item.unit_price).toLocaleString('en-IN');
  document.getElementById('bnModalQtyDisplay').textContent = item.quantity || 1;

  // Render Subscriptions Card
  const subCard = document.getElementById('bnSubscriptionCard');
  if (data.subscription) {
    subCard.classList.remove('hidden');
    const discPct = Math.round(data.subscription.discount_pct || 10);
    document.getElementById('bnSubDiscountBadge').textContent = 'Save ' + discPct + '% Every Order';
    const onetimeRadio = document.querySelector('input[name="bn_purchase_type"][value="onetime"]');
    if (onetimeRadio) onetimeRadio.checked = true;
  } else {
    subCard.classList.add('hidden');
  }

  // Render Loyalty Points Card
  const loyaltyCard = document.getElementById('bnLoyaltyCard');
  if (data.loyalty && data.loyalty.points > 0) {
    loyaltyCard.classList.remove('hidden');
    document.getElementById('bnLoyaltyPtsVal').textContent = data.loyalty.points.toLocaleString('en-IN');
    document.getElementById('bnLoyaltyDiscVal').textContent = Math.round(data.loyalty.points_value).toLocaleString('en-IN');
    document.getElementById('bnLoyaltyTierBadge').textContent = data.loyalty.tier || 'Bronze';
    const loyaltyCb = document.getElementById('bnUseLoyaltyPoints');
    if (loyaltyCb) loyaltyCb.checked = false;
  } else {
    loyaltyCard.classList.add('hidden');
  }

  // Address
  if (addr) {
    document.getElementById('bnAddrName').textContent = (addr.first_name || 'Customer') + ' ' + (addr.last_name || '');
    document.getElementById('bnAddrLine1').textContent = addr.address1 + (addr.address2 ? (', ' + addr.address2) : '');
    document.getElementById('bnAddrCityState').textContent = addr.city + ', ' + (addr.state || 'Maharashtra') + ' - ' + addr.pincode;
    document.getElementById('bnAddrPhone').textContent = addr.phone ? ('Phone: ' + addr.phone) : '';
  }

  // Saved addresses dropdown
  const addrSelect = document.getElementById('bnAddressSelect');
  if (addrSelect && data.saved_addresses && data.saved_addresses.length > 0) {
    addrSelect.innerHTML = data.saved_addresses.map(a => {
      const isSel = addr && addr.id == a.id ? 'selected' : '';
      return `<option value="${a.id}" ${isSel}>${a.first_name} ${a.last_name} — ${a.address1}, ${a.city} (${a.pincode})</option>`;
    }).join('');
  }

  // Payment radio sync
  const prefPay = data.payment_method || 'cod';
  const payRadio = document.querySelector(`input[name="bn_payment"][value="${prefPay}"]`);
  if (payRadio) payRadio.checked = true;

  // Toggle Razorpay / Stripe option availability
  const rzpLabel = document.getElementById('bnRazorpayLabel');
  if (rzpLabel) rzpLabel.style.display = data.razorpay_enabled ? 'flex' : 'none';
  const strLabel = document.getElementById('bnStripeLabel');
  if (strLabel) strLabel.style.display = data.stripe_enabled ? 'flex' : 'none';

  // Hide any previous alert
  const alertEl = document.getElementById('buyNowErrorAlert');
  if (alertEl) {
    alertEl.className = 'hidden';
    alertEl.textContent = '';
  }

  // Initial calculation
  recalculateBuyNowTotals();
}

function recalculateBuyNowTotals() {
  if (!window.currentBuyNowData) return;
  const item = window.currentBuyNowData.item;
  const qty = item.quantity || 1;
  const baseSubtotal = Math.round(item.unit_price * qty);

  // 1. Subscription Discount Check
  let subDiscount = 0;
  const subRadio = document.querySelector('input[name="bn_purchase_type"]:checked');
  const isSub = subRadio && subRadio.value === 'subscription';
  if (isSub && window.currentBuyNowData.subscription) {
    const pct = (window.currentBuyNowData.subscription.discount_pct || 10) / 100;
    subDiscount = Math.round(baseSubtotal * pct);
  }

  const subtotalAfterSub = Math.max(0, baseSubtotal - subDiscount);
  const shipping = subtotalAfterSub < 500 ? 60 : 0;

  // 2. Loyalty Points Discount Check
  let loyaltyDiscount = 0;
  const loyaltyCb = document.getElementById('bnUseLoyaltyPoints');
  if (loyaltyCb && loyaltyCb.checked && window.currentBuyNowData.loyalty && window.currentBuyNowData.loyalty.points > 0) {
    const maxVal = window.currentBuyNowData.loyalty.points_value || 0;
    loyaltyDiscount = Math.min(maxVal, subtotalAfterSub);
  }

  const totalDiscount = subDiscount + loyaltyDiscount;
  const finalTotal = Math.max(0, subtotalAfterSub + shipping - loyaltyDiscount);
  const tax = Math.round(finalTotal - (finalTotal / 1.18));

  window.currentBuyNowData.totals = {
    subtotal: baseSubtotal,
    discount_amount: totalDiscount,
    shipping_amount: shipping,
    tax_amount: tax,
    total: finalTotal
  };

  document.getElementById('bnModalSubtotal').textContent = '₹' + baseSubtotal.toLocaleString('en-IN');

  const discRow = document.getElementById('bnModalDiscountRow');
  if (totalDiscount > 0 && discRow) {
    discRow.classList.remove('hidden');
    document.getElementById('bnModalDiscount').textContent = '-₹' + Math.round(totalDiscount).toLocaleString('en-IN');
  } else if (discRow) {
    discRow.classList.add('hidden');
  }

  document.getElementById('bnModalShipping').textContent = shipping > 0 ? ('₹' + shipping.toLocaleString('en-IN')) : 'COMPLIMENTARY';
  document.getElementById('bnModalTax').textContent = '₹' + tax.toLocaleString('en-IN');
  document.getElementById('bnModalTotal').textContent = '₹' + Math.round(finalTotal).toLocaleString('en-IN');
  document.getElementById('btnBuyNowSubmitText').textContent = 'Place Order · ₹' + Math.round(finalTotal).toLocaleString('en-IN');
}

function onBuyNowLoyaltyToggled(checked) {
  recalculateBuyNowTotals();
}

function onBuyNowSubscriptionToggled(isSub) {
  recalculateBuyNowTotals();
}

function changeBuyNowModalQty(delta) {
  if (!window.currentBuyNowData) return;
  const item = window.currentBuyNowData.item;
  const maxStock = item.stock || 20;
  const newQty = Math.max(1, Math.min(maxStock, (item.quantity || 1) + delta));
  
  item.quantity = newQty;
  document.getElementById('bnModalQtyDisplay').textContent = newQty;
  recalculateBuyNowTotals();
}

function toggleBuyNowAddressPicker() {
  const drawer = document.getElementById('bnAddressPickerDrawer');
  if (drawer) drawer.classList.toggle('hidden');
}

function onBuyNowAddressSelected(addressId) {
  if (!window.currentBuyNowData || !window.currentBuyNowData.saved_addresses) return;
  const selected = window.currentBuyNowData.saved_addresses.find(a => a.id == addressId);
  if (selected) {
    window.currentBuyNowData.selected_address_id = selected.id;
    document.getElementById('bnAddrName').textContent = (selected.first_name || 'Customer') + ' ' + (selected.last_name || '');
    document.getElementById('bnAddrLine1').textContent = selected.address1 + (selected.address2 ? (', ' + selected.address2) : '');
    document.getElementById('bnAddrCityState').textContent = selected.city + ', ' + (selected.state || 'Maharashtra') + ' - ' + selected.pincode;
    document.getElementById('bnAddrPhone').textContent = selected.phone ? ('Phone: ' + selected.phone) : '';
  }
}

function openBuyNowModal() {
  const modal = document.getElementById('buyNowModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    // Accessibility: Esc key listener
    window.addEventListener('keydown', onBuyNowModalKeyDown);
    
    // Accessibility: Focus submit button
    const btn = document.getElementById('btnBuyNowSubmit');
    if (btn) btn.focus();
  }
}

function closeBuyNowModal() {
  const modal = document.getElementById('buyNowModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    window.removeEventListener('keydown', onBuyNowModalKeyDown);
  }
}

function onBuyNowModalKeyDown(e) {
  if (e.key === 'Escape') {
    closeBuyNowModal();
  }
}

function executeBuyNowOrder() {
  if (!window.currentBuyNowData) return;

  const btn = document.getElementById('btnBuyNowSubmit');
  const btnText = document.getElementById('btnBuyNowSubmitText');
  const btnIcon = document.getElementById('btnBuyNowIcon');
  const alertEl = document.getElementById('buyNowErrorAlert');

  // Idempotency: lock button on click to block double tap / concurrent submission
  btn.disabled = true;
  btnIcon.className = 'material-symbols-outlined text-lg animate-spin';
  btnIcon.textContent = 'progress_activity';
  btnText.textContent = 'Securing Order & Dispatching...';

  if (alertEl) {
    alertEl.className = 'hidden';
    alertEl.textContent = '';
  }

  const item = window.currentBuyNowData.item;
  const payRadio = document.querySelector('input[name="bn_payment"]:checked');
  const paymentMethod = payRadio ? payRadio.value : 'cod';
  const addressId = window.currentBuyNowData.selected_address_id || (window.currentBuyNowData.address ? window.currentBuyNowData.address.id : 0);

  const fd = new FormData();
  fd.append('idempotency_key', window.currentBuyNowData.idempotency_key);
  fd.append('variant_id', item.variant_id);
  fd.append('quantity', item.quantity || 1);
  fd.append('expected_price', item.unit_price);
  const useLoyalty = document.getElementById('bnUseLoyaltyPoints')?.checked ? 1 : 0;
  const isSub = document.querySelector('input[name="bn_purchase_type"]:checked')?.value === 'subscription' ? 1 : 0;
  const subPlanId = window.currentBuyNowData.subscription?.plan_id || 0;

  fd.append('address_id', addressId);
  fd.append('payment_method', paymentMethod);
  fd.append('apply_loyalty_points', useLoyalty);
  fd.append('is_subscription', isSub);
  fd.append('subscription_plan_id', subPlanId);
  fd.append(window.currentBuyNowData.csrf_name || '<?= $this->security->get_csrf_token_name() ?>', window.currentBuyNowData.csrf_hash || '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url("checkout/buy_now") ?>', {
    method: 'POST',
    body: fd,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json().then(data => ({ status: r.status, data: data })))
  .then(({ status, data }) => {
    // 1. Check for Price Change error
    if (data.price_changed && data.new_price) {
      btn.disabled = false;
      btnIcon.className = 'material-symbols-outlined text-lg';
      btnIcon.textContent = 'check';
      btnText.textContent = 'Accept ₹' + Math.round(data.new_price).toLocaleString('en-IN') + ' & Place Order';

      item.unit_price = data.new_price;
      changeBuyNowModalQty(0); // recalculates with new price

      if (alertEl) {
        alertEl.className = 'p-3 rounded-xl text-xs font-mono bg-amber-50 text-amber-900 border border-amber-300 block mb-3';
        alertEl.innerHTML = '<strong>Price Update:</strong> The atelier price changed to ₹' + Math.round(data.new_price).toLocaleString('en-IN') + '. Click "Accept & Place Order" above to confirm with this price.';
      }
      return;
    }

    // 2. Check for Stock Depletion / Insufficient Stock
    if (data.available_stock !== undefined) {
      btn.disabled = false;
      btnIcon.className = 'material-symbols-outlined text-lg';
      btnIcon.textContent = 'bolt';
      btnText.textContent = 'Place Order · ₹' + Math.round(window.currentBuyNowData.totals.total).toLocaleString('en-IN');

      if (alertEl) {
        alertEl.className = 'p-3 rounded-xl text-xs font-mono bg-red-50 text-red-800 border border-red-300 block mb-3';
        if (data.available_stock > 0) {
          alertEl.innerHTML = '<strong>Limited Stock:</strong> Only ' + data.available_stock + ' unit(s) remaining. We adjusted your quantity to ' + data.available_stock + ' — tap Place Order to proceed.';
          item.quantity = data.available_stock;
          changeBuyNowModalQty(0);
        } else {
          alertEl.innerHTML = '<strong>Sold Out:</strong> This piece just sold out. Please close this window to browse similar pieces in the collection.';
        }
      }
      return;
    }

    // 3. Check for other server errors / session timeouts
    if (!data.success) {
      btn.disabled = false;
      btnIcon.className = 'material-symbols-outlined text-lg';
      btnIcon.textContent = 'bolt';
      btnText.textContent = 'Place Order · ₹' + Math.round(window.currentBuyNowData.totals.total).toLocaleString('en-IN');

      if (alertEl) {
        alertEl.className = 'p-3 rounded-xl text-xs font-mono bg-red-50 text-red-800 border border-red-300 block mb-3';
        if (data.login_required || status === 401) {
          alertEl.innerHTML = '<strong>Session Timed Out:</strong> For your security, please <a href="<?= base_url("account/login") ?>" class="underline font-bold text-red-950">log in here</a> to complete your instant acquisition.';
        } else {
          alertEl.innerHTML = '<strong>Order Notice:</strong> ' + (data.message || data.error || 'Unable to place order. Please review your details and try again.');
        }
      }
      return;
    }

    // 4. Success state routing
    btnText.textContent = 'Order Confirmed! Redirecting...';

    if (data.gateway === 'razorpay' && data.gateway_data && typeof Razorpay !== 'undefined') {
      const rzpOptions = Object.assign({}, data.gateway_data, {
        handler: function(response) {
          window.location.href = '<?= base_url("payments/razorpay/verify") ?>?order_id=' + data.order_id + '&razorpay_payment_id=' + response.razorpay_payment_id + '&razorpay_order_id=' + response.razorpay_order_id + '&razorpay_signature=' + response.razorpay_signature;
        },
        modal: {
          ondismiss: function() {
            window.location.href = data.redirect_url;
          }
        }
      });
      const rzp = new Razorpay(rzpOptions);
      rzp.open();
    } else if (data.redirect_url) {
      window.location.href = data.redirect_url;
    } else {
      window.location.href = '<?= base_url("checkout/success/") ?>' + data.order_id;
    }
  })
  .catch(err => {
    console.error('Buy Now Submit Error:', err);
    btn.disabled = false;
    btnIcon.className = 'material-symbols-outlined text-lg';
    btnIcon.textContent = 'bolt';
    btnText.textContent = 'Place Order · ₹' + Math.round(window.currentBuyNowData.totals.total).toLocaleString('en-IN');

    if (alertEl) {
      alertEl.className = 'p-3 rounded-xl text-xs font-mono bg-red-50 text-red-800 border border-red-300 block mb-3';
      alertEl.innerHTML = '<strong>Connection Interrupted:</strong> We could not confirm server response. No duplicate charge was made. Please check your network and tap "Place Order" again.';
    }
  });
}

function handlePdpInstantCheckout() {
  handlePdpBuyNow();
}


// ── VIP Privilege Coupon Application ──
function applyVipCoupon() {
  const btn = document.getElementById('btnApplyVip');
  const priceDisplay = document.getElementById('mainDisplayPrice');
  
  if (btn && btn.textContent.trim() === 'Apply') {
    const discounted = Math.round(currentProductPrice * 0.5);
    priceDisplay.textContent = '₹' + discounted.toLocaleString('en-IN');
    priceDisplay.setAttribute('data-price-inr', discounted);
    
    btn.textContent = 'Applied ✓';
    btn.className = 'px-4 py-2 rounded-xl bg-emerald-700 text-white font-mono text-xs font-bold uppercase tracking-wider transition-all shadow-sm';
    
    if (typeof showStashToast === 'function') {
      showStashToast('VIP Code LUMINA50 applied! 50% privilege discount activated.');
    }
  }
}

// ── Pincode Delivery Checker ──
function checkPincodeDelivery() {
  const input = document.getElementById('pincodeInput');
  const result = document.getElementById('pincodeResult');
  const pin = input ? input.value.trim() : '';

  if (pin.length >= 6) {
    result.classList.remove('hidden');
    result.classList.add('flex');
  } else {
    alert('Please enter a valid 6-digit postal code.');
  }
}



// ── Modals ──
function openSizeGuideModal() {
  const modal = document.getElementById('sizeGuideModal');
  if (modal) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
}
function closeSizeGuideModal() {
  const modal = document.getElementById('sizeGuideModal');
  if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); }
}

function openProductGalleryModal() {
  const modal = document.getElementById('productGalleryModal');
  if (modal) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
}
function closeProductGalleryModal() {
  const modal = document.getElementById('productGalleryModal');
  if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); }
}

// ── Social Group Buy Modal Logic ──
function openGroupBuyModal(pid, title, groupPrice, img) {
  const modal = document.getElementById('groupBuyModal');
  if (!modal) return;
  document.getElementById('gbProdTitle').textContent = title;
  document.getElementById('gbProdPrice').textContent = '₹' + Number(groupPrice).toLocaleString('en-IN');
  document.getElementById('gbProdImg').src = img;
  
  const teamCode = 'TEAM-' + Math.random().toString(36).substring(2, 7).toUpperCase();
  document.getElementById('gbTeamCode').textContent = teamCode;
  
  const shareText = encodeURIComponent(`Hey! Let's buy "${title}" together on Lumina Atelier for 40% OFF (₹${groupPrice})! Join my team with code ${teamCode}: ` + window.location.href);
  document.getElementById('gbWhatsappShareBtn').href = 'https://wa.me/?text=' + shareText;
  
  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeGroupBuyModal() {
  const modal = document.getElementById('groupBuyModal');
  if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); }
}

function copyGroupBuyLink() {
  navigator.clipboard.writeText(window.location.href);
  alert('Team purchase link copied to clipboard! Share it with 2 friends on WhatsApp.');
}

// ── Live FOMO Countdown Clock ──
(function() {
  let seconds = 3 * 3600 + 42 * 60 + 18;
  const clockEl = document.getElementById('detailFomoClock');
  if (!clockEl) return;
  setInterval(function() {
    if (seconds > 0) seconds--;
    const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
    const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
    const s = String(seconds % 60).padStart(2, '0');
    clockEl.textContent = `${h}h : ${m}m : ${s}s`;
  }, 1000);
})();

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeSizeGuideModal();
    closeProductGalleryModal();
    closePdpModelStudioModal();
    closeGroupBuyModal();
  }
});
</script>

<!-- ── Social Group Buy Team Modal ── -->
<div id="groupBuyModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden items-center justify-center p-4">
  <div class="bg-white rounded-3xl border border-stone-200 shadow-2xl max-w-md w-full p-6 relative overflow-hidden text-center">
    <button type="button" onclick="closeGroupBuyModal()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-900 w-8 h-8 rounded-full bg-stone-100 flex items-center justify-center cursor-pointer">
      ✕
    </button>
    <div class="w-12 h-12 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center mx-auto mb-3 text-2xl">
      👥
    </div>
    <span class="text-[10px] font-mono uppercase tracking-widest text-pink-600 font-bold block mb-1">
      ✦ Social Team Purchase · 40% OFF
    </span>
    <h3 class="font-serif text-xl font-bold text-stone-900 mb-1" id="gbProdTitle">
      Product Title
    </h3>
    <div class="flex items-center justify-center gap-2 mb-4">
      <span class="text-xs text-stone-500 line-through">₹<?= number_format($price, 0) ?></span>
      <span class="font-serif text-2xl font-extrabold text-pink-600" id="gbProdPrice">₹<?= number_format(round($price * 0.6), 0) ?></span>
      <span class="px-2 py-0.5 bg-pink-100 text-pink-700 text-[10px] font-mono font-bold rounded-full">40% OFF</span>
    </div>
    <img id="gbProdImg" src="" class="w-24 h-24 object-cover rounded-2xl mx-auto mb-4 border border-stone-200 shadow-sm">
    
    <!-- Team Member Slots -->
    <div class="p-3 bg-stone-50 border border-stone-200 rounded-2xl mb-4">
      <div class="text-xs font-mono font-bold text-stone-700 mb-2">Team Formation (1/3 Joined)</div>
      <div class="flex justify-center gap-3">
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 rounded-full bg-stone-900 text-[#e9c176] font-bold text-xs flex items-center justify-center border-2 border-white shadow-sm">You</div>
          <span class="text-[9px] font-mono text-stone-500 mt-1">Leader</span>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 rounded-full bg-pink-100 border-2 border-dashed border-pink-400 text-pink-600 flex items-center justify-center text-xs font-bold">+1</div>
          <span class="text-[9px] font-mono text-pink-600 mt-1">Friend 1</span>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-10 h-10 rounded-full bg-pink-100 border-2 border-dashed border-pink-400 text-pink-600 flex items-center justify-center text-xs font-bold">+2</div>
          <span class="text-[9px] font-mono text-pink-600 mt-1">Friend 2</span>
        </div>
      </div>
      <div class="text-[10px] font-mono text-stone-400 mt-2">Team Code: <strong id="gbTeamCode" class="text-stone-900 font-mono">TEAM-XXXX</strong></div>
    </div>

    <!-- Actions -->
    <div class="space-y-2">
      <a id="gbWhatsappShareBtn" href="#" target="_blank" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-mono font-bold text-xs uppercase rounded-xl flex items-center justify-center gap-2 shadow-md transition-all">
        <span>Invite 2 Friends on WhatsApp</span>
      </a>
      <button type="button" onclick="copyGroupBuyLink()" class="w-full py-2.5 px-4 bg-stone-100 hover:bg-stone-200 text-stone-800 font-mono font-bold text-xs rounded-xl transition-all">
        Copy Invite Link
      </button>
    </div>
  </div>
</div>

<!-- ══ RECENTLY VIEWED PRODUCTS STRIP ══ -->
<section id="recentlyViewedSection" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-stone-200 hidden">
  <div class="flex items-center justify-between mb-8">
    <div>
      <span class="text-[10px] font-mono uppercase tracking-[0.2em] text-[#92400e] font-bold block mb-1">Your Journey</span>
      <h2 class="font-serif text-2xl sm:text-3xl text-stone-950 font-bold">Recently Explored Silhouettes</h2>
    </div>
  </div>
  <div id="recentlyViewedGrid" class="grid grid-cols-2 sm:grid-cols-4 gap-6"></div>
</section>

<!-- ══ BACK IN STOCK NOTIFY MODAL ══ -->
<div id="restockModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl border border-stone-200 shadow-2xl max-w-md w-full p-6 relative text-left">
    <button type="button" onclick="closeRestockModal()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-900 w-8 h-8 rounded-full bg-stone-100 flex items-center justify-center cursor-pointer">✕</button>
    <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#92400e] flex items-center justify-center mb-3">
      <span class="material-symbols-outlined text-xl">notifications_active</span>
    </div>
    <span class="text-[10px] font-mono uppercase tracking-widest text-[#92400e] font-bold block mb-1">Priority Waitlist</span>
    <h3 class="font-serif text-xl font-bold text-stone-950 mb-1">Notify When Restocked</h3>
    <p class="text-xs text-stone-500 mb-4 font-light">Leave your email or WhatsApp number. We will notify you the moment our atelier crafts the next limited batch.</p>
    <form id="restockForm" onsubmit="submitRestockNotify(event)" class="space-y-3">
      <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
      <input type="hidden" name="variant_id" id="restockVariantId" value="<?= (int)$default_variant['id'] ?>">
      <div>
        <label class="font-mono text-[10px] uppercase tracking-wider text-stone-600 block mb-1 font-bold">Email or WhatsApp Number *</label>
        <input type="text" id="restockContact" name="contact" placeholder="you@domain.com or +91 98765 43210" required class="w-full text-xs bg-stone-50 px-3.5 py-2.5 border border-stone-200 rounded-lg outline-none focus:border-stone-950 focus:bg-white transition-all font-sans">
      </div>
      <button type="submit" class="w-full py-3 bg-[#1A1815] hover:bg-[#2e2a25] text-white font-button text-xs uppercase tracking-widest rounded-lg font-bold transition-all shadow-md cursor-pointer">
        Join Priority Waitlist
      </button>
      <div id="restockFeedback" class="text-xs text-center font-medium mt-2 hidden"></div>
    </form>
  </div>
</div>

<script>
// ── Recently Viewed Products & Restock Notify ──
(function() {
  try {
    const currentProd = {
      id: <?= (int)$product['id'] ?>,
      title: <?= json_encode($product_title) ?>,
      slug: <?= json_encode($product['slug'] ?? 'the-atelier-cashmere-cocoon-coat') ?>,
      price: <?= (float)$price ?>,
      image: <?= json_encode($primary_image) ?>
    };
    let viewed = JSON.parse(localStorage.getItem('novadrop_recently_viewed') || '[]');
    viewed = viewed.filter(p => p.id !== currentProd.id);
    viewed.unshift(currentProd);
    viewed = viewed.slice(0, 8);
    localStorage.setItem('novadrop_recently_viewed', JSON.stringify(viewed));
    
    const others = viewed.filter(p => p.id !== currentProd.id);
    const grid = document.getElementById('recentlyViewedGrid');
    const sec = document.getElementById('recentlyViewedSection');
    if (others.length > 0 && grid && sec) {
      sec.classList.remove('hidden');
      grid.innerHTML = others.slice(0, 4).map(p => `
        <div class="group relative flex flex-col bg-white border border-[#E8E3DC] rounded-lg overflow-hidden transition-all hover:shadow-md">
          <a href="<?= base_url('products/') ?>${p.slug}" class="block aspect-[3/4] bg-[#FAF8F5] overflow-hidden">
            <img src="${p.image}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="${p.title}">
          </a>
          <div class="p-3.5 flex flex-col justify-between flex-1">
            <h4 class="font-serif font-bold text-sm text-[#1A1815] line-clamp-1 mb-1">
              <a href="<?= base_url('products/') ?>${p.slug}" class="hover:underline">${p.title}</a>
            </h4>
            <div class="text-xs font-mono font-bold text-[#92400e]">₹${Number(p.price).toLocaleString()}</div>
          </div>
        </div>
      `).join('');
    }
  } catch(e) {}
})();

function openRestockModal(variantId) {
  if (variantId) document.getElementById('restockVariantId').value = variantId;
  document.getElementById('restockModal').classList.remove('hidden');
  document.getElementById('restockModal').classList.add('flex');
}
function closeRestockModal() {
  document.getElementById('restockModal').classList.add('hidden');
  document.getElementById('restockModal').classList.remove('flex');
}
function submitRestockNotify(e) {
  e.preventDefault();
  const contact = document.getElementById('restockContact').value;
  const prodId = <?= (int)$product['id'] ?>;
  const varId = document.getElementById('restockVariantId').value;
  const fb = document.getElementById('restockFeedback');
  
  const fd = new FormData();
  fd.append('product_id', prodId);
  fd.append('variant_id', varId);
  fd.append('contact', contact);
  fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
  
  fetch('<?= base_url('storefront/products/ajax_notify_restock') ?>', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      fb.classList.remove('hidden');
      if (res.success) {
        fb.className = 'text-xs text-center font-medium mt-2 text-emerald-700 font-serif';
        fb.textContent = res.message;
        setTimeout(closeRestockModal, 2500);
      } else {
        fb.className = 'text-xs text-center font-medium mt-2 text-red-600';
        fb.textContent = res.message || 'Error subscribing.';
      }
    })
    .catch(() => {
      fb.classList.remove('hidden');
      fb.className = 'text-xs text-center font-medium mt-2 text-red-600';
      fb.textContent = 'Unable to connect to server. Please try again.';
    });
}

function openReviewModal() {
  const m = document.getElementById('productReviewModal');
  if (m) { m.classList.remove('hidden'); m.classList.add('flex'); }
}
function closeReviewModal() {
  const m = document.getElementById('productReviewModal');
  if (m) { m.classList.add('hidden'); m.classList.remove('flex'); }
}
function setReviewRating(r) {
  const inp = document.getElementById('reviewRatingInput');
  if (inp) inp.value = r;
  const desc = ['1 Star — Poor', '2 Stars — Below Expectations', '3 Stars — Acceptable', '4 Stars — Very Good', '5 Stars — Flawless'];
  const lbl = document.getElementById('ratingTextDesc');
  if (lbl) lbl.textContent = desc[r - 1] || (r + ' Stars');
  document.querySelectorAll('#starRatingSelector .star-btn').forEach((b, idx) => {
    if (idx < r) {
      b.classList.add('text-amber-500');
      b.classList.remove('text-stone-300');
    } else {
      b.classList.remove('text-amber-500');
      b.classList.add('text-stone-300');
    }
  });
}
function submitProductReview(e) {
  e.preventDefault();
  const btn = document.getElementById('submitReviewBtn');
  const alertEl = document.getElementById('reviewFeedbackAlert');
  if (btn) {
    btn.disabled = true;
    btn.textContent = 'Publishing...';
  }

  const fd = new FormData();
  fd.append('product_id', <?= (int)$product['id'] ?>);
  fd.append('rating', document.getElementById('reviewRatingInput') ? document.getElementById('reviewRatingInput').value : 5);
  fd.append('title', document.getElementById('reviewTitleInput') ? document.getElementById('reviewTitleInput').value : '');
  fd.append('body', document.getElementById('reviewBodyInput') ? document.getElementById('reviewBodyInput').value : '');
  fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url('products/ajax_submit_review') ?>', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (alertEl) alertEl.classList.remove('hidden');
      if (res.success) {
        if (alertEl) {
          alertEl.className = 'mb-4 p-3 rounded-xl text-xs font-mono bg-emerald-50 text-emerald-800 border border-emerald-200';
          alertEl.textContent = res.message;
        }
        setTimeout(() => {
          closeReviewModal();
          location.reload();
        }, 1500);
      } else {
        if (alertEl) {
          alertEl.className = 'mb-4 p-3 rounded-xl text-xs font-mono bg-red-50 text-red-800 border border-red-200';
          alertEl.textContent = res.message || 'Submission failed. Please try again.';
        }
        if (btn) {
          btn.disabled = false;
          btn.textContent = 'Publish Review →';
        }
      }
    })
    .catch(() => {
      if (alertEl) {
        alertEl.classList.remove('hidden');
        alertEl.className = 'mb-4 p-3 rounded-xl text-xs font-mono bg-red-50 text-red-800 border border-red-200';
        alertEl.textContent = 'Network error. Please try again.';
      }
      if (btn) {
        btn.disabled = false;
        btn.textContent = 'Publish Review →';
      }
    });
}
function markReviewHelpful(reviewId, btn) {
  const fd = new FormData();
  fd.append('review_id', reviewId);
  fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url('products/ajax_helpful') ?>', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.success) {
        const countSpan = btn.querySelector('.helpful-count');
        if (countSpan) countSpan.textContent = res.helpful_count;
        btn.classList.add('text-emerald-700', 'font-bold');
        btn.disabled = true;
      }
    });
}
</script>

