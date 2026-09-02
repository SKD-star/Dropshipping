<!-- ══════════════════════════════════════════════════════
     HAUTE COUTURE BOUTIQUE CATALOG (WESTSIDE & ATELIER LUXURY)
     EDITORIAL ARCHITECTURE · FULL-WIDTH FLUID GRID · 3D MAGNETIC TILT
     ANIMATED SLIDING BUTTONS · DUAL-IMAGE CROSSFADE · QUICK-BAG ENGINE
══════════════════════════════════════════════════════ -->
<?php
// Helper to build URL with preserved query parameters
function build_filter_url($param_key, $param_val) {
    $params = $_GET;
    if ($param_val === null || (isset($params[$param_key]) && $params[$param_key] === (string)$param_val)) {
        unset($params[$param_key]);
    } else {
        $params[$param_key] = $param_val;
    }
    unset($params['page']); // Reset page on filter change
    return base_url('shop' . (!empty($params) ? '?' . http_build_query($params) : ''));
}

$active_collection = $_GET['collection'] ?? ($collection['slug'] ?? '');
$active_size = $_GET['size'] ?? '';
$active_price = $_GET['price'] ?? '';
$active_fabric = $_GET['fabric'] ?? '';
$active_fit = $_GET['fit'] ?? '';
$active_avail = $_GET['availability'] ?? '';
$active_sort = $_GET['sort'] ?? 'new';
$active_min = $_GET['min'] ?? '';
$active_max = $_GET['max'] ?? '';

$has_active_filters = !empty($active_collection) || !empty($active_size) || !empty($active_price) || !empty($active_fabric) || !empty($active_fit) || !empty($active_avail) || !empty($active_min) || !empty($active_max);
$total_products_count = $total ?? count($products ?? []);
$col_title = !empty($collection['title']) ? $collection['title'] : 'All Creations';
?>

<style>
/* ─── Haute Couture 3D Tilt & Card Refinements ─── */
.tilt-card, .store-product-card {
  transform-style: preserve-3d;
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease, border-color 0.35s ease;
  will-change: transform, box-shadow;
  position: relative;
}

.tilt-glare {
  position: absolute;
  inset: 0;
  pointer-events: none;
  border-radius: inherit;
  background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.22), transparent 65%);
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 15;
}

.tilt-card:hover .tilt-glare,
.store-product-card:hover .tilt-glare {
  opacity: 1;
}

/* Custom Scrollbar for Drawer & Overlays */
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: #f5f5f4;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #d6d3d1;
  border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #a8a29e;
}
</style>

<main class="min-h-screen bg-[#faf9f6] text-stone-900 pt-16 sm:pt-20 pb-28 font-sans selection:bg-black selection:text-white">

  <!-- ── 1. WESTSIDE SUB-NAVIGATION RIBBON (MOBILE CAPSULE SCROLL & DESKTOP SUBNAV) ── -->
  <nav class="bg-white/95 backdrop-blur-md border-b border-stone-200 sticky top-14 sm:top-20 z-30 transition-all shadow-xs" id="westsideSubnav">
    <div class="max-w-[1440px] mx-auto px-3 sm:px-6 lg:px-10">
      
      <!-- Smooth Horizontal Inertia Scrollable Bar -->
      <div class="flex items-center justify-between gap-3 sm:gap-6 py-2.5 sm:py-3.5 overflow-x-auto no-scrollbar scroll-smooth" style="scrollbar-width:none;-ms-overflow-style:none;-webkit-overflow-scrolling:touch;">
        
        <!-- Category Navigation Links (Mobile Pills / Desktop Tabs) -->
        <div class="flex items-center gap-2 sm:gap-6 whitespace-nowrap text-xs font-sans tracking-wide">
          
          <!-- All Creations -->
          <a href="<?= base_url('shop') ?>" class="flex-shrink-0 transition-all flex items-center gap-1.5 <?= empty($active_collection) ? 'bg-black text-white font-bold px-3.5 py-1.5 sm:px-0 sm:py-1 sm:bg-transparent sm:text-black sm:border-b-2 sm:border-black rounded-full sm:rounded-none shadow-2xs sm:shadow-none' : 'bg-stone-100 sm:bg-transparent text-stone-600 hover:text-black font-medium px-3.5 py-1.5 sm:px-0 sm:py-1 rounded-full sm:rounded-none' ?>">
            <span>All (<?= $total_products_count ?>)</span>
          </a>

          <?php foreach ($collections as $cNav): ?>
          <?php $isColActive = ($active_collection === $cNav['slug']); ?>
          <a href="<?= base_url('shop/' . $cNav['slug']) ?>" class="flex-shrink-0 transition-all flex items-center gap-1 <?= $isColActive ? 'bg-black text-white font-bold px-3.5 py-1.5 sm:px-0 sm:py-1 sm:bg-transparent sm:text-black sm:border-b-2 sm:border-black rounded-full sm:rounded-none shadow-2xs sm:shadow-none' : 'bg-stone-100 sm:bg-transparent text-stone-600 hover:text-black font-medium px-3.5 py-1.5 sm:px-0 sm:py-1 rounded-full sm:rounded-none' ?>">
            <span><?= htmlspecialchars($cNav['title']) ?></span>
            <span class="hidden sm:inline material-symbols-outlined text-[13px] text-stone-400">expand_more</span>
          </a>
          <?php endforeach; ?>

          <!-- Curated Materials -->
          <a href="<?= build_filter_url('fabric', 'Cashmere') ?>" class="flex-shrink-0 transition-all flex items-center gap-1 <?= ($active_fabric === 'Cashmere') ? 'bg-black text-white font-bold px-3.5 py-1.5 sm:px-0 sm:py-1 sm:bg-transparent sm:text-black sm:border-b-2 sm:border-black rounded-full sm:rounded-none shadow-2xs sm:shadow-none' : 'bg-stone-100 sm:bg-transparent text-stone-600 hover:text-black font-medium px-3.5 py-1.5 sm:px-0 sm:py-1 rounded-full sm:rounded-none' ?>">
            <span>Cashmere</span>
          </a>
          <a href="<?= build_filter_url('fabric', 'Denim') ?>" class="flex-shrink-0 transition-all flex items-center gap-1 <?= ($active_fabric === 'Denim') ? 'bg-black text-white font-bold px-3.5 py-1.5 sm:px-0 sm:py-1 sm:bg-transparent sm:text-black sm:border-b-2 sm:border-black rounded-full sm:rounded-none shadow-2xs sm:shadow-none' : 'bg-stone-100 sm:bg-transparent text-stone-600 hover:text-black font-medium px-3.5 py-1.5 sm:px-0 sm:py-1 rounded-full sm:rounded-none' ?>">
            <span>Selvedge Denim</span>
          </a>
          <a href="<?= build_filter_url('fabric', 'Silk') ?>" class="flex-shrink-0 transition-all flex items-center gap-1 <?= ($active_fabric === 'Silk') ? 'bg-black text-white font-bold px-3.5 py-1.5 sm:px-0 sm:py-1 sm:bg-transparent sm:text-black sm:border-b-2 sm:border-black rounded-full sm:rounded-none shadow-2xs sm:shadow-none' : 'bg-stone-100 sm:bg-transparent text-stone-600 hover:text-black font-medium px-3.5 py-1.5 sm:px-0 sm:py-1 rounded-full sm:rounded-none' ?>">
            <span>Mulberry Silk</span>
          </a>
        </div>

        <!-- Search Trigger (Desktop) -->
        <a href="<?= base_url('search') ?>" class="hidden xl:flex items-center gap-2 text-stone-600 hover:text-black text-xs font-mono pl-6 border-l border-stone-200 flex-shrink-0 cursor-pointer">
          <span class="material-symbols-outlined text-base">search</span>
          <span>Search</span>
        </a>

      </div>
    </div>
  </nav>


  <!-- ── 2. EDITORIAL CONTROL & HEADER BAR ── -->
  <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-4 sm:pt-6 pb-3">
    
    <!-- Top Breadcrumb & Live Count (Desktop) -->
    <div class="hidden sm:flex items-center justify-between gap-2 text-xs font-mono text-stone-500 mb-2">
      <div class="flex items-center gap-2">
        <a href="<?= base_url() ?>" class="hover:text-black transition-colors">Home</a>
        <span>/</span>
        <a href="<?= base_url('shop') ?>" class="hover:text-black transition-colors">Shop</a>
        <?php if (!empty($collection)): ?>
          <span>/</span>
          <span class="text-[#a16207] font-semibold uppercase"><?= htmlspecialchars($collection['title']) ?></span>
        <?php else: ?>
          <span>/</span>
          <span class="text-stone-900 font-semibold uppercase">Catalog</span>
        <?php endif; ?>
      </div>
      <div class="text-[#a16207] font-bold tracking-wider uppercase text-[11px] bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200/60">
        <?= $total_products_count ?> <?= $total_products_count === 1 ? 'Design' : 'Designs' ?>
      </div>
    </div>

    <!-- Main Title & Controls in One Seamless Row -->
    <div class="flex items-center justify-between gap-3 pb-3 sm:pb-4 border-b border-stone-200">
      
      <!-- Title & Mobile Count -->
      <div class="flex items-baseline gap-2">
        <h1 class="font-serif text-xl sm:text-3xl md:text-4xl font-normal text-stone-950 uppercase tracking-tight truncate">
          <?= htmlspecialchars($col_title) ?><span class="text-[#a16207] font-bold">.</span>
        </h1>
        <span class="sm:hidden text-xs font-mono text-stone-500 font-semibold">(<?= $total_products_count ?>)</span>
      </div>

      <!-- Right Controls: Sort + Grid Switchers + FILTER BUTTON -->
      <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
        
        <!-- Grid View Switchers (Desktop) -->
        <div class="hidden sm:flex items-center border border-stone-200 rounded-xl overflow-hidden bg-stone-50 p-0.5 shadow-2xs">
          <!-- 4-Col Grid -->
          <button type="button" onclick="setCatalogLayout('grid-4')" id="btnGrid4" class="p-1.5 bg-black text-white rounded-lg transition-all cursor-pointer shadow-2xs" title="4-Column Grid">
            <span class="material-symbols-outlined text-[18px]">grid_on</span>
          </button>
          <!-- 3-Col Grid -->
          <button type="button" onclick="setCatalogLayout('grid-3')" id="btnGrid3" class="p-1.5 text-stone-500 hover:text-black rounded-lg transition-all cursor-pointer" title="3-Column Grid">
            <span class="material-symbols-outlined text-[18px]">grid_view</span>
          </button>
          <!-- 2-Col Grid -->
          <button type="button" onclick="setCatalogLayout('grid-2')" id="btnGrid2" class="p-1.5 text-stone-500 hover:text-black rounded-lg transition-all cursor-pointer" title="2-Column Grid">
            <span class="material-symbols-outlined text-[18px]">view_agenda</span>
          </button>
        </div>

        <!-- Sorter Dropdown (Compact on Mobile) -->
        <form method="get" action="<?= base_url('shop') ?>" id="catalogSortForm" class="m-0">
          <?php foreach ($_GET as $k => $v): ?>
            <?php if ($k !== 'sort'): ?>
              <input type="hidden" name="<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($v) ?>">
            <?php endif; ?>
          <?php endforeach; ?>
          <select name="sort" onchange="document.getElementById('catalogSortForm').submit()" class="bg-white border border-stone-300 hover:border-[#a16207] text-black text-[11px] sm:text-xs font-mono uppercase tracking-wider py-1.5 sm:py-2 px-2.5 sm:px-4 rounded-xl outline-none cursor-pointer transition-colors shadow-2xs font-semibold">
            <option value="new" <?= ($active_sort === 'new' || $active_sort === 'created_at_desc') ? 'selected' : '' ?>>Sort: New</option>
            <option value="price_asc" <?= ($active_sort === 'price_asc') ? 'selected' : '' ?>>Price: Low → High</option>
            <option value="price_desc" <?= ($active_sort === 'price_desc') ? 'selected' : '' ?>>Price: High → Low</option>
            <option value="views_desc" <?= ($active_sort === 'views_desc') ? 'selected' : '' ?>>Popular</option>
            <option value="title_asc" <?= ($active_sort === 'title_asc') ? 'selected' : '' ?>>A–Z</option>
          </select>
        </form>

        <!-- Westside-Style FILTER Button -->
        <button type="button" onclick="toggleFilterDrawer()" class="inline-flex items-center gap-1.5 sm:gap-2 px-3.5 sm:px-5 py-1.5 sm:py-2 bg-black hover:bg-stone-900 text-white text-[11px] sm:text-xs font-mono uppercase tracking-widest font-bold rounded-xl cursor-pointer shadow-xs active:scale-95 transition-all">
          <span class="material-symbols-outlined text-[15px] sm:text-sm">tune</span>
          <span>FILTER</span>
          <?php if ($has_active_filters): ?>
            <span class="w-2 h-2 rounded-full bg-[#e9c176] animate-ping"></span>
          <?php endif; ?>
        </button>

      </div>

    </div>

    <!-- Active Criteria Removable Tags -->
    <?php if ($has_active_filters): ?>
    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 mt-2.5 pt-1 text-xs">
      <span class="font-mono text-[10px] sm:text-[11px] uppercase text-stone-500 font-bold mr-1">Active:</span>

      <?php if (!empty($active_collection)): ?>
      <a href="<?= base_url('shop') ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-stone-900 text-[#e9c176] border border-stone-800 text-[11px] font-mono font-medium shadow-2xs hover:bg-black transition-colors">
        <span><?= htmlspecialchars($active_collection) ?></span>
        <span class="text-xs font-bold text-white/80">✕</span>
      </a>
      <?php endif; ?>

      <?php if (!empty($active_size)): ?>
      <a href="<?= build_filter_url('size', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-white border border-stone-300 text-stone-900 hover:border-black text-[11px] font-mono font-medium shadow-2xs transition-colors">
        <span>Size: <?= htmlspecialchars($active_size) ?></span>
        <span class="text-xs font-bold text-stone-500">✕</span>
      </a>
      <?php endif; ?>

      <?php if (!empty($active_fabric)): ?>
      <a href="<?= build_filter_url('fabric', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-white border border-stone-300 text-stone-900 hover:border-black text-[11px] font-mono font-medium shadow-2xs transition-colors">
        <span><?= htmlspecialchars($active_fabric) ?></span>
        <span class="text-xs font-bold text-stone-500">✕</span>
      </a>
      <?php endif; ?>

      <?php if (!empty($active_price)): ?>
      <a href="<?= build_filter_url('price', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-white border border-stone-300 text-stone-900 hover:border-black text-[11px] font-mono font-medium shadow-2xs transition-colors">
        <span><?= htmlspecialchars(str_replace('_', ' ', $active_price)) ?></span>
        <span class="text-xs font-bold text-stone-500">✕</span>
      </a>
      <?php endif; ?>

      <a href="<?= base_url('shop') ?>" class="ml-1 text-[11px] font-mono text-[#a16207] hover:text-stone-950 font-bold underline">
        <span>Reset All</span>
      </a>
    </div>
    <?php endif; ?>

  </section>


  <!-- ── 3. FULL-WIDTH PRODUCT SHOWCASE (4-COL / 3-COL / 2-COL WITH 3D MAGNETIC TILT & ANIMATED BUTTONS) ── -->
  <section class="max-w-[1440px] mx-auto px-3 sm:px-6 lg:px-10 py-3 sm:py-4">
    
    <?php if (empty($products)): ?>
      <!-- Empty State -->
      <div class="py-24 text-center flex flex-col items-center justify-center bg-white border border-stone-200 rounded-3xl p-8 shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-amber-50 text-[#a16207] flex items-center justify-center mx-auto mb-4 border border-amber-200">
          <span class="material-symbols-outlined text-3xl">inventory_2</span>
        </div>
        <h3 class="font-serif text-2xl text-stone-950 mb-2 font-normal">No Creations Found</h3>
        <p class="text-stone-500 text-xs max-w-sm mb-6 leading-relaxed">No garments match the selected criteria. Please adjust your filters or reset to view the complete atelier catalog.</p>
        <a href="<?= base_url('shop') ?>" class="px-7 py-3 bg-black hover:bg-stone-800 text-white font-mono text-xs uppercase font-bold tracking-wider rounded-xl shadow-md transition-all">
          Reset All Filters
        </a>
      </div>
    <?php else: ?>

      <!-- Dynamic Full-Width Product Grid -->
      <div id="productGridContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 lg:gap-7 transition-all duration-300">
        
        <?php foreach ($products as $idx => $p): ?>
        <?php
          $img1 = !empty($p['primary_image']) ? $p['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
          $img2 = !empty($p['secondary_image']) ? $p['secondary_image'] : (!empty($p['gallery'][1]) ? $p['gallery'][1] : $img1);
          $vendor_label = !empty($p['vendor']) ? $p['vendor'] : 'Lumina Haute Couture';
          $b_price = (float)$p['base_price'];
          $c_price = (float)($p['compare_at_price'] ?? 0);
          $disc_pct = ($c_price > $b_price) ? round((($c_price - $b_price) / $c_price) * 100) : 0;
          $p_points = !empty($p['reward_points']) ? (int)$p['reward_points'] : max(1, round($b_price * 0.06));

          // Category accurate default sizes
          $p_title_lower = strtolower(($p['title'] ?? '') . ' ' . ($p['category_name'] ?? ''));
          if (preg_match('/(shoe|boot|sneaker|loafer|chelsea|footwear|heel|mule|oxford|sandal|derby|slide)/i', $p_title_lower)) {
            $card_sizes = ['UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11'];
            $default_card_sz = 'UK 8';
          } elseif (preg_match('/(jean|denim|trouser|pant|chino|bottom|selvedge|slacks|cargo|waist)/i', $p_title_lower)) {
            $card_sizes = ['28', '30', '32', '34', '36', '38'];
            $default_card_sz = '32';
          } elseif (preg_match('/(bag|tote|purse|wallet|belt|scarf|hat|sunglass|watch|ring|necklace|bracelet|fragrance)/i', $p_title_lower)) {
            $card_sizes = ['One Size'];
            $default_card_sz = 'One Size';
          } else {
            $card_sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
            $default_card_sz = 'M';
          }
          $grid_cols_num = count($card_sizes);
          $grid_cls = $grid_cols_num === 6 ? 'grid-cols-6' : ($grid_cols_num === 5 ? 'grid-cols-5' : ($grid_cols_num === 1 ? 'grid-cols-1' : 'grid-cols-4'));

          $p_json = htmlspecialchars(json_encode([
            'id' => (int)$p['id'],
            'title' => $p['title'],
            'slug' => $p['slug'] ?? '',
            'price' => $b_price,
            'compare_price' => $c_price,
            'discount' => $disc_pct,
            'reward_points' => $p_points,
            'image' => $img1,
            'secondary_image' => $img2,
            'vendor' => $vendor_label,
            'description' => strip_tags($p['short_description'] ?? ($p['description'] ?? 'Tailored with intention in the atelier.'))
          ]), ENT_QUOTES, 'UTF-8');
        ?>

        <!-- Haute Couture Luxury Product Card (with Specular Glare & Magnetic 3D Tilt) -->
        <div class="product-card store-product-card tilt-card group relative flex flex-col justify-between bg-white rounded-xl sm:rounded-2xl border border-stone-200 hover:border-[#a16207]/60 overflow-hidden p-2.5 sm:p-3 transition-all duration-500 shadow-xs hover:shadow-xl"
             data-product-id="<?= (int)$p['id'] ?>"
             data-selected-size="<?= $default_card_sz ?>">
          
          <div class="tilt-glare"></div>

          <div>
            <!-- Image Stage with Dual Angle Flip / Zoom & Direct Product Link -->
            <div class="relative aspect-[3/4] bg-stone-100 overflow-hidden rounded-lg sm:rounded-xl mb-2.5 select-none cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $p['slug']) ?>'">
              
              <!-- Primary Image -->
              <img src="<?= htmlspecialchars($img1) ?>" 
                   alt="<?= htmlspecialchars($p['title']) ?>" 
                   class="w-full h-full object-cover transition-all duration-700 ease-out group-hover:scale-105 <?= ($img2 !== $img1) ? 'group-hover:opacity-0' : '' ?>"
                   loading="lazy"/>
              
              <!-- Secondary Hover Image (Alternate Runway Angle) -->
              <?php if ($img2 !== $img1): ?>
              <img src="<?= htmlspecialchars($img2) ?>" 
                   alt="<?= htmlspecialchars($p['title']) ?> alternate view" 
                   class="w-full h-full object-cover absolute inset-0 opacity-0 group-hover:opacity-100 transition-all duration-700 ease-out group-hover:scale-105 pointer-events-none"
                   loading="lazy"/>
              <?php endif; ?>

              <!-- Top-Left Atelier Badges -->
              <div class="absolute top-2 sm:top-2.5 left-2 sm:left-2.5 flex flex-col gap-1 z-10 pointer-events-none">
                <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-black/85 backdrop-blur-md text-[#e9c176] text-[8.5px] sm:text-[9px] font-mono font-bold uppercase tracking-wider border border-white/10 flex items-center gap-1 shadow-md">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176]"></span>
                  <span>Atelier Cut</span>
                </span>
                <?php if ($disc_pct > 0): ?>
                <span class="px-2 py-0.5 rounded-full bg-stone-900/90 backdrop-blur-md text-white text-[8px] sm:text-[8.5px] font-mono font-bold uppercase tracking-wider border border-white/10 shadow-2xs w-fit">
                  <?= $disc_pct ?>% OFF
                </span>
                <?php endif; ?>
              </div>

              <!-- Top-Right Actions: Heart & Quick View -->
              <div class="absolute top-2 sm:top-2.5 right-2 sm:right-2.5 flex items-center gap-1.5 z-10" onclick="event.stopPropagation()">
                <div class="heart-container w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/90 hover:bg-white border border-stone-200/80 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 flex items-center justify-center cursor-pointer" title="Save to Wardrobe">
                  <input type="checkbox" class="checkbox" data-wishlist-id="<?= (int)$p['id'] ?>" onchange="toggleWishlistItem({id:<?= (int)$p['id'] ?>, title:'<?= addslashes(htmlspecialchars($p['title'])) ?>', price:<?= $b_price ?>, image:'<?= addslashes($img1) ?>'}, event)">
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

                <button type="button" 
                        onclick="openProductQuickView(<?= $p_json ?>)" 
                        class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/85 hover:bg-black text-[#e9c176] border border-white/20 flex items-center justify-center shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 cursor-pointer hidden sm:flex" 
                        title="Atelier Quick View"
                        aria-label="Quick View">
                  <span class="material-symbols-outlined text-[15px] sm:text-[16px]">visibility</span>
                </button>
              </div>

              <!-- Interactive Quick Size Selector Drawer (Dark Glassmorphism) -->
              <div class="absolute inset-x-2 bottom-2 bg-black/85 backdrop-blur-md p-2 rounded-xl border border-white/15 shadow-2xl translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 z-10 hidden sm:block" onclick="event.stopPropagation()">
                <div class="flex items-center justify-between text-[9px] font-mono uppercase tracking-wider mb-1 px-0.5">
                  <span class="card-size-status flex items-center gap-1 font-bold text-[#e9c176]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176] animate-pulse"></span>
                    <span>Select Size</span>
                  </span>
                  <span class="text-[8.5px] text-white/50">Auto-Bags</span>
                </div>
                <div class="grid <?= $grid_cls ?> gap-1">
                  <?php foreach ($card_sizes as $szChip): ?>
                  <button type="button" 
                          onclick="selectCardSize(this, <?= $p['id'] ?>, '<?= addslashes(htmlspecialchars($p['title'])) ?>', <?= $b_price ?>, '<?= addslashes($img1) ?>', '<?= $szChip ?>', event)" 
                          class="card-size-btn py-1 text-[10px] sm:text-[10.5px] font-mono font-bold text-white/90 bg-white/10 hover:bg-[#e9c176] hover:text-black border border-white/15 rounded-md transition-all text-center cursor-pointer <?= ($szChip === $default_card_sz) ? 'active-size bg-gradient-to-r from-amber-400 to-[#e9c176] text-black font-bold border-amber-400' : '' ?>">
                    <?= $szChip ?>
                  </button>
                  <?php endforeach; ?>
                </div>
              </div>

            </div>

            <!-- Product Meta Info -->
            <div class="space-y-0.5 px-0.5">
              <div class="flex items-center justify-between gap-1 mb-0.5">
                <span class="text-[8.5px] sm:text-[9.5px] font-mono uppercase tracking-widest text-[#a16207] font-bold truncate">
                  <?= htmlspecialchars($vendor_label) ?>
                </span>
                <?php if (!empty($p['rating_avg']) && $p['rating_avg'] > 0): ?>
                <span class="inline-flex items-center gap-0.5 text-[9px] font-mono font-bold text-amber-800 bg-amber-50 px-1.5 py-0.2 rounded-full border border-amber-200">
                  <span class="text-amber-500 text-[10px]">★</span> <?= number_format($p['rating_avg'], 1) ?>
                </span>
                <?php endif; ?>
              </div>

              <h3 class="font-serif text-xs sm:text-sm md:text-[15px] font-bold text-stone-900 mb-1 group-hover:text-[#a16207] transition-colors line-clamp-1">
                <a href="<?= base_url('products/' . $p['slug']) ?>"><?= htmlspecialchars($p['title']) ?></a>
              </h3>

              <div class="flex items-baseline justify-between gap-1 pt-0.5">
                <div class="flex items-baseline gap-1.5">
                  <span class="font-serif font-bold text-sm sm:text-base md:text-lg text-stone-950" data-price-inr="<?= $b_price ?>">₹<?= number_format($b_price, 0) ?></span>
                  <?php if ($disc_pct > 0): ?>
                  <span class="text-[10px] sm:text-xs text-stone-400 line-through font-mono" data-price-inr="<?= $c_price ?>">₹<?= number_format($c_price, 0) ?></span>
                  <?php endif; ?>
                </div>
                <span class="hidden sm:inline-flex text-[8.5px] text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded font-mono font-bold items-center gap-1 border border-emerald-200/70">
                  <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                  <span>Free Air</span>
                </span>
              </div>

              <!-- Points Earning Pill -->
              <div class="flex items-center justify-between gap-1 pt-1.5 mb-1 sm:mb-2">
                <span class="inline-flex items-center gap-1 text-[8.5px] sm:text-[9.5px] font-mono font-bold text-amber-900 bg-gradient-to-r from-amber-50 to-[#fef3c7] border border-[#fde68a] px-2 py-0.5 rounded-md shadow-2xs" title="Earn <?= number_format($p_points) ?> Atelier Reward Points on purchase">
                  <span>🪙</span>
                  <span>+<?= number_format($p_points) ?> pts</span>
                  <span class="text-amber-800/70 font-normal">(₹<?= number_format($p_points) ?>)</span>
                </span>
                <span class="text-[8px] sm:text-[8.5px] font-mono text-stone-400">1.5× for Gold</span>
              </div>
            </div>
          </div>

          <!-- ── Animated Sliding Action Buttons (Same High-End Animation as Index) ── -->
          <div class="pt-2 sm:pt-2.5 border-t border-stone-100">
            <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
              
              <!-- 1. ACQUIRE / BAG BUTTON (Sliding text & tooltip) -->
              <button type="button" 
                      data-tooltip="Acquire (<?= $default_card_sz ?>)" 
                      onclick="handleCardBagClick(this, <?= $p['id'] ?>, '<?= addslashes(htmlspecialchars($p['title'])) ?>', <?= $b_price ?>, '<?= addslashes($img1) ?>', event)" 
                      class="card-bag-btn uiverse-action-btn uiverse-acquire-btn active:scale-95">
                <div class="uiverse-btn-wrapper">
                  <div class="uiverse-btn-text">
                    <span class="material-symbols-outlined text-[12px] sm:text-[13px] text-[#a16207]">shopping_bag</span>
                    <span class="btn-label-text">Acquire</span>
                  </div>
                  <span class="uiverse-btn-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    <span class="btn-hover-text">Add to Bag</span>
                  </span>
                </div>
              </button>

              <!-- 2. INSTANT BUY BUTTON (Sliding text & tooltip) -->
              <button type="button" 
                      data-tooltip="Instant: ₹<?= number_format($b_price, 0) ?>" 
                      onclick="handleCardBuyClick(this, <?= $p['id'] ?>, '<?= addslashes($p['title']) ?>', <?= $b_price ?>, '<?= addslashes($img1) ?>', event)" 
                      class="card-buy-btn uiverse-action-btn uiverse-buy-btn active:scale-95">
                <div class="uiverse-btn-wrapper">
                  <div class="uiverse-btn-text">
                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current text-[#e9c176] flex-shrink-0" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
                    <span class="btn-label-text">Buy</span>
                  </div>
                  <span class="uiverse-btn-icon">
                    <svg viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5 text-[#e9c176]"><path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/></svg>
                    <span class="btn-hover-text">1-Click</span>
                  </span>
                </div>
              </button>

            </div>
          </div>

        </div>
        <?php endforeach; ?>

      </div>

      <!-- Pagination -->
      <?php if (!empty($total_pages) && $total_pages > 1): ?>
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-12 pt-6 border-t border-stone-200">
        <div class="text-xs font-mono text-stone-500">
          Page <span class="font-bold text-black"><?= $page ?></span> of <span class="font-bold text-black"><?= $total_pages ?></span> (<?= $total_products_count ?> Total Pieces)
        </div>
        <div class="flex items-center gap-1.5">
          <?php if ($page > 1): ?>
            <a href="<?= build_filter_url('page', $page - 1) ?>" class="px-4 py-2 rounded-xl bg-white border border-stone-300 text-black hover:border-black text-xs font-mono font-bold transition-all shadow-2xs">← Prev</a>
          <?php endif; ?>
          
          <?php for ($pg = 1; $pg <= min(5, $total_pages); $pg++): ?>
            <a href="<?= build_filter_url('page', $pg) ?>" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-mono font-bold transition-all <?= ($pg === (int)$page) ? 'bg-black text-white shadow-xs' : 'bg-white border border-stone-200 text-stone-700 hover:border-black' ?>">
              <?= $pg ?>
            </a>
          <?php endfor; ?>

          <?php if ($page < $total_pages): ?>
            <a href="<?= build_filter_url('page', $page + 1) ?>" class="px-4 py-2 rounded-xl bg-white border border-stone-300 text-black hover:border-black text-xs font-mono font-bold transition-all shadow-2xs">Next →</a>
          <?php endif; ?>
        </div>
      </div>
      <?php endif; ?>

    <?php endif; ?>

  </section>


  <!-- ── 4. WESTSIDE-STYLE SLIDE-OVER FILTER DRAWER (CLEAN BLACK & WHITE WITH ISOLATED SCROLL) ── -->
  <div id="filterDrawerOverlay" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" style="touch-action: none;">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity duration-300 opacity-0" id="filterDrawerBackdrop" onclick="toggleFilterDrawer()"></div>

    <!-- Drawer Panel (Max Screen Height, Fixed Flex Layout) -->
    <div class="fixed inset-y-0 right-0 w-96 max-w-[90vw] h-full max-h-screen bg-white shadow-2xl border-l border-stone-200 flex flex-col transform translate-x-full transition-transform duration-300 ease-out z-10 overflow-hidden" id="filterDrawerPanel" style="touch-action: auto;">
      
      <!-- Drawer Header -->
      <div class="p-5 sm:p-6 border-b border-stone-200 flex justify-between items-center bg-white flex-shrink-0">
        <div class="flex items-center gap-2.5">
          <span class="material-symbols-outlined text-xl text-[#a16207]">tune</span>
          <h3 class="font-serif text-lg font-bold text-black uppercase tracking-wider">Atelier Filters</h3>
          <span class="text-xs font-mono text-stone-500">(<?= $total_products_count ?>)</span>
        </div>
        <button type="button" onclick="toggleFilterDrawer()" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-500 hover:text-black hover:bg-stone-100 transition-colors cursor-pointer" aria-label="Close">
          <span class="material-symbols-outlined text-xl">close</span>
        </button>
      </div>

      <!-- Drawer Scrollable Body -->
      <div class="p-5 sm:p-6 space-y-6 overflow-y-auto custom-scrollbar flex-1 min-h-0 overscroll-contain" style="overscroll-behavior: contain; -webkit-overflow-scrolling: touch;">
        
        <?php if ($has_active_filters): ?>
        <div class="flex justify-between items-center bg-amber-50 border border-amber-200/60 rounded-xl p-3">
          <span class="text-xs font-mono font-bold text-amber-900 uppercase">Active Criteria</span>
          <a href="<?= base_url('shop') ?>" class="text-[11px] uppercase font-mono text-[#a16207] hover:text-black font-bold underline">
            Reset All
          </a>
        </div>
        <?php endif; ?>

        <!-- 1. Size Filter (Black/White Grid) -->
        <div>
          <h4 class="font-mono text-xs text-black uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span>Size Matrix</span>
            <?php if (!empty($active_size)): ?><a href="<?= build_filter_url('size', null) ?>" class="text-[10px] text-stone-400 hover:text-black font-mono">Clear</a><?php endif; ?>
          </h4>
          <div class="grid grid-cols-3 gap-2">
            <?php foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $sz): ?>
            <?php $isSz = ($active_size === $sz); ?>
            <a href="<?= build_filter_url('size', $sz) ?>" class="py-2 text-center text-xs font-mono font-bold rounded-xl border transition-all <?= $isSz ? 'bg-black text-white border-black shadow-xs' : 'bg-stone-50 border-stone-200 text-stone-800 hover:border-black' ?>">
              <?= $sz ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 2. Categories / Collections -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-mono text-xs text-black uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span>Category</span>
            <?php if (!empty($active_collection)): ?><a href="<?= base_url('shop') ?>" class="text-[10px] text-stone-400 hover:text-black font-mono">Clear</a><?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <a href="<?= base_url('shop') ?>" class="py-2 px-3 rounded-xl flex justify-between items-center <?= empty($active_collection) ? 'font-bold text-black bg-stone-100' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>All Creations</span>
              <span class="font-mono text-stone-400"><?= $total_products_count ?></span>
            </a>
            <?php foreach ($collections as $col): ?>
            <?php $isCol = ($active_collection === $col['slug']); ?>
            <a href="<?= base_url('shop/' . $col['slug']) ?>" class="py-2 px-3 rounded-xl flex justify-between items-center <?= $isCol ? 'font-bold text-black bg-stone-100' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span><?= htmlspecialchars($col['title']) ?></span>
              <span class="material-symbols-outlined text-xs text-stone-400">arrow_forward</span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 3. Raw Materials & Fabric -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-mono text-xs text-black uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span>Fabric &amp; Material</span>
            <?php if (!empty($active_fabric)): ?><a href="<?= build_filter_url('fabric', null) ?>" class="text-[10px] text-stone-400 hover:text-black font-mono">Clear</a><?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <?php 
              $fabrics = [
                'Cashmere' => 'Mongolian Cashmere',
                'Denim'    => 'Okayama Selvedge Denim',
                'Silk'     => 'Mulberry Silk',
                'Wool'     => 'Virgin Wool',
                'Terry'    => 'French Terry Cotton'
              ];
              foreach ($fabrics as $fKey => $fLabel):
              $isFab = ($active_fabric === $fKey);
            ?>
            <a href="<?= build_filter_url('fabric', $fKey) ?>" class="py-2 px-3 rounded-xl flex justify-between items-center <?= $isFab ? 'font-bold text-black bg-stone-100' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span><?= $fLabel ?></span>
              <?php if ($isFab): ?><span class="font-bold text-[#a16207]">✓</span><?php endif; ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 4. Price Tiers -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-mono text-xs text-black uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span>Price Range</span>
            <?php if (!empty($active_price)): ?><a href="<?= build_filter_url('price', null) ?>" class="text-[10px] text-stone-400 hover:text-black font-mono">Clear</a><?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <a href="<?= build_filter_url('price', 'under_2000') ?>" class="py-2 px-3 rounded-xl flex justify-between <?= ($active_price === 'under_2000') ? 'font-bold text-black bg-stone-100' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>Under ₹2,000</span>
              <span class="text-stone-400 font-mono">Entry</span>
            </a>
            <a href="<?= build_filter_url('price', '2000_5000') ?>" class="py-2 px-3 rounded-xl flex justify-between <?= ($active_price === '2000_5000') ? 'font-bold text-black bg-stone-100' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>₹2,000 – ₹5,000</span>
              <span class="text-stone-400 font-mono">Core</span>
            </a>
            <a href="<?= build_filter_url('price', 'above_5000') ?>" class="py-2 px-3 rounded-xl flex justify-between <?= ($active_price === 'above_5000') ? 'font-bold text-black bg-stone-100' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>Above ₹5,000</span>
              <span class="text-stone-400 font-mono">Master</span>
            </a>
          </div>
        </div>

        <!-- 5. Silhouette Fit -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-mono text-xs text-black uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span>Fit</span>
            <?php if (!empty($active_fit)): ?><a href="<?= build_filter_url('fit', null) ?>" class="text-[10px] text-stone-400 hover:text-black font-mono">Clear</a><?php endif; ?>
          </h4>
          <div class="flex flex-wrap gap-1.5 text-xs">
            <?php foreach (['Oversized' => 'Relaxed', 'Structured' => 'Structured', 'Slim' => 'Tailored Slim'] as $fitKey => $fitLbl): ?>
            <?php $isFit = ($active_fit === $fitKey); ?>
            <a href="<?= build_filter_url('fit', $fitKey) ?>" class="px-3.5 py-1.5 rounded-xl border text-[11px] font-mono transition-all <?= $isFit ? 'bg-black text-white border-black font-bold shadow-xs' : 'bg-stone-50 border-stone-200 text-stone-700 hover:border-black' ?>">
              <?= $fitLbl ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

      </div>

      <!-- Drawer Bottom Action Button -->
      <div class="p-5 border-t border-stone-200 bg-stone-50 flex-shrink-0">
        <button type="button" onclick="toggleFilterDrawer()" class="w-full py-3 bg-black hover:bg-stone-800 text-white font-mono text-xs uppercase font-bold tracking-widest rounded-xl transition-all shadow-md cursor-pointer">
          Apply &amp; Show <?= $total_products_count ?> Creations
        </button>
      </div>

    </div>
  </div>


  <!-- ── 5. RUNWAY QUICK-VIEW MODAL ── -->
  <div id="productQuickViewModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true" style="touch-action: none;">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity duration-300 opacity-0" id="qvBackdrop" onclick="closeProductQuickView()"></div>

    <div class="relative bg-white w-full max-w-3xl max-h-[90vh] rounded-2xl overflow-hidden shadow-2xl border border-stone-200 z-10 transform scale-95 opacity-0 transition-all duration-300 flex flex-col md:flex-row overflow-y-auto custom-scrollbar overscroll-contain" id="qvPanel" style="touch-action: auto; overscroll-behavior: contain;">
      <button type="button" onclick="closeProductQuickView()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-black flex items-center justify-center z-20 cursor-pointer shadow-2xs" aria-label="Close">
        <span class="material-symbols-outlined text-lg">close</span>
      </button>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-0 w-full">
        <div class="relative aspect-[3/4] bg-stone-100 overflow-hidden">
          <img id="qvPrimaryImg" src="" alt="Product View" class="w-full h-full object-cover transition-all duration-500"/>
          <div class="absolute bottom-3 left-3 right-3 flex items-center gap-2 bg-black/70 backdrop-blur-md p-1.5 rounded-xl" id="qvThumbsStrip"></div>
        </div>

        <div class="p-6 sm:p-8 flex flex-col justify-between space-y-4">
          <div>
            <div class="text-[10px] font-mono text-[#a16207] uppercase tracking-widest font-bold mb-1" id="qvVendor">
              LUMINA HAUTE COUTURE
            </div>

            <h2 class="font-serif text-2xl font-bold text-black uppercase" id="qvTitle">Product Title</h2>
            
            <div class="flex items-baseline gap-2 mt-2">
              <span class="font-serif text-2xl font-bold text-black" id="qvPrice">₹0</span>
              <span class="text-xs text-stone-400 line-through font-mono" id="qvComparePrice"></span>
              <span class="text-[10px] font-mono font-bold text-amber-900 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-full" id="qvDiscount"></span>
            </div>

            <p class="text-xs text-stone-600 mt-3 leading-relaxed font-sans" id="qvDescription"></p>

            <!-- Size Selector in Modal -->
            <div class="mt-5">
              <span class="text-[10px] font-mono uppercase tracking-wider text-stone-600 font-bold block mb-2">Select Size:</span>
              <div class="grid grid-cols-5 gap-1.5" id="qvSizeMatrix">
                <button type="button" onclick="selectQvSize('XS', this)" class="qv-size-btn py-2 text-xs font-mono font-bold rounded-lg border border-stone-200 text-stone-800 hover:border-black transition-all text-center cursor-pointer">XS</button>
                <button type="button" onclick="selectQvSize('S', this)" class="qv-size-btn py-2 text-xs font-mono font-bold rounded-lg border border-stone-200 text-stone-800 hover:border-black transition-all text-center cursor-pointer">S</button>
                <button type="button" onclick="selectQvSize('M', this)" class="qv-size-btn active py-2 text-xs font-mono font-bold rounded-lg border border-black bg-black text-white shadow-2xs transition-all text-center cursor-pointer">M</button>
                <button type="button" onclick="selectQvSize('L', this)" class="qv-size-btn py-2 text-xs font-mono font-bold rounded-lg border border-stone-200 text-stone-800 hover:border-black transition-all text-center cursor-pointer">L</button>
                <button type="button" onclick="selectQvSize('XL', this)" class="qv-size-btn py-2 text-xs font-mono font-bold rounded-lg border border-stone-200 text-stone-800 hover:border-black transition-all text-center cursor-pointer">XL</button>
              </div>
            </div>
          </div>

          <!-- Bottom Actions -->
          <div class="grid grid-cols-2 gap-2 pt-4 border-t border-stone-200">
            <button type="button" id="qvAddBagBtn" class="py-3 bg-stone-100 hover:bg-stone-200 text-black font-mono text-xs uppercase font-bold tracking-wider rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer border border-stone-300">
              <span class="material-symbols-outlined text-base text-[#a16207]">shopping_bag</span>
              <span>Add to Bag</span>
            </button>
            <button type="button" id="qvBuyNowBtn" class="py-3 bg-black hover:bg-stone-800 text-white font-mono text-xs uppercase font-bold tracking-wider rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-md">
              <svg class="w-3.5 h-3.5 fill-current text-[#e9c176]" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
              <span>Buy Now</span>
            </button>
          </div>

        </div>

      </div>

    </div>
  </div>

</main>


<!-- ── 6. JAVASCRIPT CONTROLLERS & 3D TILT + INTERACTIVE BAG ENGINE ── -->
<script>
window.cardSelectedSizes = window.cardSelectedSizes || {};
var currentQvProduct = null;
var currentQvSelectedSize = 'M';

// ── Initialize 3D Magnetic Gyro Card Tilt with Dynamic Specular Glare ──
function initCardTiltEffects() {
  var tiltableCards = document.querySelectorAll('.store-product-card, .tilt-card');

  tiltableCards.forEach(function(card) {
    var glare = card.querySelector('.tilt-glare');
    if (!glare) {
      glare = document.createElement('div');
      glare.className = 'tilt-glare';
      card.appendChild(glare);
    }

    card.addEventListener('mousemove', function(e) {
      var rect = card.getBoundingClientRect();
      var x = e.clientX - rect.left;
      var y = e.clientY - rect.top;
      var centerX = rect.width / 2;
      var centerY = rect.height / 2;

      var rotateX = ((y - centerY) / centerY) * -8;
      var rotateY = ((x - centerX) / centerX) * 8;

      var glareX = (x / rect.width) * 100;
      var glareY = (y / rect.height) * 100;

      card.style.transform = 'perspective(1000px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale3d(1.02, 1.02, 1.02) translateZ(8px)';
      card.style.boxShadow = '0 20px 40px -12px rgba(0,0,0,0.18), 0 0 20px rgba(233,193,118,0.15)';

      if (glare) {
        glare.style.opacity = '1';
        glare.style.background = 'radial-gradient(circle at ' + glareX + '% ' + glareY + '%, rgba(255,255,255,0.22), transparent 65%)';
      }
    });

    card.addEventListener('mouseleave', function() {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1) translateZ(0px)';
      card.style.boxShadow = '';
      if (glare) glare.style.opacity = '0';
    });
  });
}

// ── Open Bag Drawer Safely ──
window.openBagDrawer = function() {
  if (typeof window.toggleQuickBagDrawer === 'function') {
    window.toggleQuickBagDrawer(true);
  }
  if (typeof window.loadQuickBagItems === 'function') {
    window.loadQuickBagItems();
  }
};

// ── Interactive Size Selector Engine for Product Cards ──
function selectCardSize(btn, prodId, title, price, img, sizeChip, event) {
  if (event) {
    if (typeof event.stopPropagation === 'function') event.stopPropagation();
    if (typeof event.preventDefault === 'function') event.preventDefault();
  }
  
  var card = btn.closest('.product-card');
  if (!card) return;

  // 1. Store size state for this card
  window.cardSelectedSizes[prodId] = sizeChip;
  card.setAttribute('data-selected-size', sizeChip);

  // 2. Visually activate the clicked size in gold gradient & reset siblings
  var sizeButtons = card.querySelectorAll('.card-size-btn');
  sizeButtons.forEach(function(b) {
    b.className = 'card-size-btn py-1 text-[10px] sm:text-[10.5px] font-mono font-bold text-white/90 bg-white/10 hover:bg-[#e9c176] hover:text-black border border-white/15 rounded-md transition-all text-center cursor-pointer';
  });
  btn.className = 'card-size-btn active-size py-1 text-[10px] sm:text-[10.5px] font-mono font-bold text-black bg-gradient-to-r from-amber-400 to-[#e9c176] border border-amber-400 rounded-md shadow-xs scale-105 transition-all text-center cursor-pointer';

  // 3. Update Status Indicator in Size Drawer
  var statusEl = card.querySelector('.card-size-status');
  if (statusEl) {
    statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span><span class="text-[#e9c176] font-bold">Size ' + sizeChip + ' Selected</span>';
  }

  // 4. Update the Bag and Buy Now action buttons tooltips and labels while preserving sliding animation structure
  var bagBtn = card.querySelector('.card-bag-btn');
  if (bagBtn) {
    bagBtn.setAttribute('data-tooltip', 'Acquire (' + sizeChip + ')');
    var labelEl = bagBtn.querySelector('.btn-label-text');
    if (labelEl) labelEl.textContent = 'Acquire (' + sizeChip + ')';
  }
  var buyBtn = card.querySelector('.card-buy-btn');
  if (buyBtn) {
    buyBtn.setAttribute('data-tooltip', 'Instant (' + sizeChip + ')');
    var buyLabelEl = buyBtn.querySelector('.btn-label-text');
    if (buyLabelEl) buyLabelEl.textContent = 'Buy (' + sizeChip + ')';
  }

  // 5. Instantly Add to Bag & Slide open the Bag Drawer
  var itemObj = {
    id: prodId,
    variant_id: prodId,
    product_id: prodId,
    title: title,
    price: price,
    image: img,
    size: sizeChip
  };

  if (typeof window.addToCart === 'function') {
    window.addToCart(itemObj, 1, '✦ Added ' + title + ' (Size ' + sizeChip + ') to Bag!', function() {
      window.openBagDrawer();
    });
    setTimeout(function() {
      window.openBagDrawer();
    }, 450);
  } else {
    window.openBagDrawer();
  }
}

// ── Card Bag Button Handler ──
function handleCardBagClick(btn, prodId, title, price, img, event) {
  if (event) {
    if (typeof event.stopPropagation === 'function') event.stopPropagation();
    if (typeof event.preventDefault === 'function') event.preventDefault();
  }
  var card = btn ? btn.closest('.product-card') : null;
  var chosenSize = (card ? card.getAttribute('data-selected-size') : null) || window.cardSelectedSizes[prodId] || 'M';

  var itemObj = {
    id: prodId,
    variant_id: prodId,
    product_id: prodId,
    title: title,
    price: price,
    image: img,
    size: chosenSize
  };

  if (typeof window.addToCart === 'function') {
    window.addToCart(itemObj, 1, '✦ Added ' + title + ' (Size ' + chosenSize + ') to Bag!', function() {
      window.openBagDrawer();
    });
    setTimeout(function() {
      window.openBagDrawer();
    }, 450);
  } else {
    window.openBagDrawer();
  }
}

// ── Card Buy Now Button Handler ──
function handleCardBuyClick(btn, prodId, title, price, img, event) {
  if (event) {
    if (typeof event.stopPropagation === 'function') event.stopPropagation();
    if (typeof event.preventDefault === 'function') event.preventDefault();
  }
  var card = btn ? btn.closest('.product-card') : null;
  var chosenSize = (card ? card.getAttribute('data-selected-size') : null) || window.cardSelectedSizes[prodId] || 'M';

  if (typeof window.openExpressCheckout === 'function') {
    window.openExpressCheckout(prodId, title + ' (' + chosenSize + ')', price, img, prodId);
  } else {
    handleCardBagClick(btn, prodId, title, price, img, event);
  }
}

// ── Grid Layout Switcher ──
function setCatalogLayout(layout) {
  var grid = document.getElementById('productGridContainer');
  if (!grid) return;

  var b4 = document.getElementById('btnGrid4');
  var b3 = document.getElementById('btnGrid3');
  var b2 = document.getElementById('btnGrid2');

  var allBtns = [b4, b3, b2];
  allBtns.forEach(function(b) {
    if (b) b.className = 'p-1.5 text-stone-500 hover:text-black transition-all rounded-lg cursor-pointer';
  });

  if (layout === 'grid-3') {
    grid.className = 'grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6 lg:gap-7 transition-all duration-300';
    if (b3) b3.className = 'p-1.5 bg-black text-white rounded-lg shadow-2xs transition-all cursor-pointer';
  } else if (layout === 'grid-2') {
    grid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6 lg:gap-8 transition-all duration-300';
    if (b2) b2.className = 'p-1.5 bg-black text-white rounded-lg shadow-2xs transition-all cursor-pointer';
  } else {
    // grid-4 default
    grid.className = 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6 lg:gap-7 transition-all duration-300';
    if (b4) b4.className = 'p-1.5 bg-black text-white rounded-lg shadow-2xs transition-all cursor-pointer';
  }
}

// ── Slide-Over Filter Drawer ──
function toggleFilterDrawer() {
  var drawer = document.getElementById('filterDrawerOverlay');
  var backdrop = document.getElementById('filterDrawerBackdrop');
  var panel = document.getElementById('filterDrawerPanel');
  if (!drawer || !backdrop || !panel) return;

  if (drawer.classList.contains('hidden')) {
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
    
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';
    document.body.style.touchAction = 'none';

    setTimeout(function() {
      backdrop.classList.remove('opacity-0');
      backdrop.classList.add('opacity-100');
      panel.classList.remove('translate-x-full');
      panel.classList.add('translate-x-0');
    }, 15);
  } else {
    backdrop.classList.remove('opacity-100');
    backdrop.classList.add('opacity-0');
    panel.classList.remove('translate-x-0');
    panel.classList.add('translate-x-full');

    document.documentElement.style.overflow = '';
    document.body.style.overflow = '';
    document.body.style.touchAction = '';

    setTimeout(function() {
      drawer.classList.add('hidden');
      drawer.classList.remove('flex');
    }, 300);
  }
}

// ── Quick-View Modal Engine ──
function openProductQuickView(prod) {
  currentQvProduct = prod;
  currentQvSelectedSize = 'M';

  var modal = document.getElementById('productQuickViewModal');
  var backdrop = document.getElementById('qvBackdrop');
  var panel = document.getElementById('qvPanel');

  document.getElementById('qvTitle').innerText = prod.title;
  document.getElementById('qvVendor').innerText = prod.vendor || 'Lumina Haute Couture';
  document.getElementById('qvPrice').innerText = '₹' + Number(prod.price).toLocaleString();
  document.getElementById('qvDescription').innerText = prod.description || 'Tailored with intention in the atelier.';

  if (prod.compare_price && prod.compare_price > prod.price) {
    document.getElementById('qvComparePrice').innerText = '₹' + Number(prod.compare_price).toLocaleString();
    document.getElementById('qvDiscount').innerText = prod.discount + '% OFF';
    document.getElementById('qvDiscount').style.display = 'inline-block';
  } else {
    document.getElementById('qvComparePrice').innerText = '';
    document.getElementById('qvDiscount').style.display = 'none';
  }

  var mainImg = document.getElementById('qvPrimaryImg');
  mainImg.src = prod.image;

  var thumbStrip = document.getElementById('qvThumbsStrip');
  thumbStrip.innerHTML = '';
  var images = [prod.image];
  if (prod.secondary_image && prod.secondary_image !== prod.image) {
    images.push(prod.secondary_image);
  }
  images.forEach(function(imgUrl, idx) {
    var tb = document.createElement('button');
    tb.type = 'button';
    tb.className = 'w-9 h-9 rounded-lg overflow-hidden border-2 transition-all cursor-pointer ' + (idx === 0 ? 'border-amber-400' : 'border-transparent opacity-60 hover:opacity-100');
    tb.innerHTML = '<img src="' + imgUrl + '" class="w-full h-full object-cover">';
    tb.onclick = function() {
      mainImg.src = imgUrl;
      Array.from(thumbStrip.children).forEach(function(c) { c.className = 'w-9 h-9 rounded-lg overflow-hidden border-2 border-transparent opacity-60 hover:opacity-100 transition-all cursor-pointer'; });
      tb.className = 'w-9 h-9 rounded-lg overflow-hidden border-2 border-amber-400 transition-all cursor-pointer opacity-100';
    };
    thumbStrip.appendChild(tb);
  });

  // Reset modal size chips
  var modalSizeBtns = document.querySelectorAll('.qv-size-btn');
  modalSizeBtns.forEach(function(btn) {
    if (btn.innerText.trim() === 'M') {
      btn.className = 'qv-size-btn active py-2 text-xs font-mono font-bold rounded-lg border border-black bg-black text-white shadow-2xs transition-all text-center cursor-pointer';
    } else {
      btn.className = 'qv-size-btn py-2 text-xs font-mono font-bold rounded-lg border border-stone-200 text-stone-800 hover:border-black transition-all text-center cursor-pointer';
    }
  });

  document.getElementById('qvAddBagBtn').onclick = function() {
    if (typeof window.addToCart === 'function') {
      window.addToCart({
        id: prod.id,
        variant_id: prod.id,
        product_id: prod.id,
        title: prod.title,
        price: prod.price,
        image: prod.image,
        size: currentQvSelectedSize
      }, 1, '✦ Added ' + prod.title + ' (Size ' + currentQvSelectedSize + ') to Bag!', function() {
        window.openBagDrawer();
      });
      setTimeout(function() { window.openBagDrawer(); }, 450);
    }
    closeProductQuickView();
  };

  document.getElementById('qvBuyNowBtn').onclick = function() {
    closeProductQuickView();
    if (typeof window.openExpressCheckout === 'function') {
      window.openExpressCheckout(prod.id, prod.title + ' (' + currentQvSelectedSize + ')', prod.price, prod.image, prod.id);
    }
  };

  modal.classList.remove('hidden');
  modal.classList.add('flex');
  document.documentElement.style.overflow = 'hidden';
  document.body.style.overflow = 'hidden';
  setTimeout(function() {
    backdrop.classList.remove('opacity-0');
    backdrop.classList.add('opacity-100');
    panel.classList.remove('scale-95', 'opacity-0');
    panel.classList.add('scale-100', 'opacity-100');
  }, 20);
}

function selectQvSize(size, btn) {
  currentQvSelectedSize = size;
  var btns = document.querySelectorAll('.qv-size-btn');
  btns.forEach(function(b) {
    b.className = 'qv-size-btn py-2 text-xs font-mono font-bold rounded-lg border border-stone-200 text-stone-800 hover:border-black transition-all text-center cursor-pointer';
  });
  btn.className = 'qv-size-btn active py-2 text-xs font-mono font-bold rounded-lg border border-black bg-black text-white shadow-2xs transition-all text-center cursor-pointer';
}

function closeProductQuickView() {
  var modal = document.getElementById('productQuickViewModal');
  var backdrop = document.getElementById('qvBackdrop');
  var panel = document.getElementById('qvPanel');
  if (!modal || !backdrop || !panel) return;

  backdrop.classList.remove('opacity-100');
  backdrop.classList.add('opacity-0');
  panel.classList.remove('scale-100', 'opacity-100');
  panel.classList.add('scale-95', 'opacity-0');
  document.documentElement.style.overflow = '';
  document.body.style.overflow = '';
  setTimeout(function() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }, 250);
}

// ── DOM Ready Init ──
document.addEventListener('DOMContentLoaded', function() {
  initCardTiltEffects();
});
</script>
