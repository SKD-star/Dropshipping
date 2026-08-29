<!-- ══════════════════════════════════════════════════════
     BOUTIQUE CATALOG HUB (LUMINA ATELIER)
     BLACK HERO STAGE + CRISP EDITORIAL WHITE BODY & ENHANCED FILTERS
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

$active_collection = $_GET['collection'] ?? '';
$active_size = $_GET['size'] ?? '';
$active_price = $_GET['price'] ?? '';
$active_fabric = $_GET['fabric'] ?? '';
$active_fit = $_GET['fit'] ?? '';
$active_avail = $_GET['availability'] ?? '';
$active_sort = $_GET['sort'] ?? 'new';

$has_active_filters = !empty($active_collection) || !empty($active_size) || !empty($active_price) || !empty($active_fabric) || !empty($active_fit) || !empty($active_avail);
?>

<main class="min-h-screen bg-[#faf9f6] text-stone-900 pt-20 sm:pt-24 pb-24">

  <!-- ── 1. HAUTE COUTURE BOUTIQUE HERO (OBSIDIAN NOIR CANVAS) ── -->
  <section class="relative py-14 sm:py-20 bg-[#07080b] text-white border-b border-white/10 overflow-hidden">
    <!-- Ambient Radial Starlight & Subtle Golden Flares -->
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#e9c176_1px,transparent_1px)] [background-size:28px_28px] pointer-events-none"></div>
    <div class="absolute w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-amber-500/10 via-[#e9c176]/5 to-transparent blur-[140px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 pb-6 border-b border-white/10">
        <div>
          <!-- Scarcity Badge -->
          <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-[#e9c176]/40 text-[10px] sm:text-xs font-mono text-[#e9c176] uppercase tracking-[0.25em] mb-4 shadow-xl backdrop-blur-md">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
            <span>LUMINA Curated Boutique · Archival Couture &amp; Ready-to-Wear</span>
          </div>

          <h1 class="font-serif text-3xl sm:text-5xl font-normal text-white uppercase tracking-tight leading-tight">
            The Boutique Catalog<span class="text-[#e9c176] font-bold">.</span>
          </h1>

          <p class="text-white/60 text-xs sm:text-sm max-w-xl mt-2 font-light font-sans leading-relaxed">
            Discover hand-finished garments tailored from Grade-A Mongolian cashmere, Japanese selvedge denim, 22-momme silks, and virgin wool.
          </p>
        </div>

        <!-- View Controls, Filter Button & Sorter -->
        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
          
          <!-- Mobile Filter Drawer Trigger Button -->
          <button type="button" onclick="toggleMobileFilterDrawer()" class="md:hidden flex items-center gap-1.5 px-3.5 py-2.5 bg-stone-900 border border-white/25 hover:border-[#e9c176] text-white text-xs font-mono uppercase tracking-wider rounded-xl cursor-pointer shadow-md active:scale-95 transition-all">
            <span class="material-symbols-outlined text-sm text-[#e9c176]">tune</span>
            <span>Filters</span>
            <?php if ($has_active_filters): ?>
              <span class="w-2 h-2 rounded-full bg-[#e9c176] animate-pulse"></span>
            <?php endif; ?>
          </button>

          <!-- Grid Mode Switcher (2-Grid vs 1-Column List) -->
          <div class="flex items-center border border-white/20 rounded-xl overflow-hidden bg-black/60 p-1 backdrop-blur-md shadow-md">
            <button type="button" onclick="setViewMode('bento')" id="btnViewBento" class="p-2 bg-stone-900 text-[#e9c176] border border-[#e9c176]/50 rounded-lg text-xs cursor-pointer transition-all shadow-xs" title="2-Column Mobile Grid View">
              <span class="material-symbols-outlined text-base">grid_view</span>
            </button>
            <button type="button" onclick="setViewMode('editorial')" id="btnViewEditorial" class="p-2 text-white/60 hover:text-white rounded-lg text-xs cursor-pointer transition-all" title="1-Column List / Single Feed View">
              <span class="material-symbols-outlined text-base">view_day</span>
            </button>
          </div>

          <!-- Sorting Dropdown -->
          <form method="get" action="<?= base_url('shop') ?>" id="sortForm">
            <?php foreach ($_GET as $k => $v): ?>
              <?php if ($k !== 'sort'): ?>
                <input type="hidden" name="<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($v) ?>">
              <?php endif; ?>
            <?php endforeach; ?>
            <select name="sort" onchange="document.getElementById('sortForm').submit()" class="bg-black/80 border border-white/25 px-3.5 py-2.5 text-xs font-mono uppercase tracking-wider text-white cursor-pointer outline-none rounded-xl hover:border-[#e9c176] transition-colors shadow-lg">
              <option value="new" <?= ($active_sort === 'new' || $active_sort === 'created_at_desc') ? 'selected' : '' ?> class="bg-stone-900">Sort: New Arrivals</option>
              <option value="price_asc" <?= ($active_sort === 'price_asc') ? 'selected' : '' ?> class="bg-stone-900">Price: Low to High</option>
              <option value="price_desc" <?= ($active_sort === 'price_desc') ? 'selected' : '' ?> class="bg-stone-900">Price: High to Low</option>
              <option value="views_desc" <?= ($active_sort === 'views_desc') ? 'selected' : '' ?> class="bg-stone-900">Most Curated</option>
            </select>
          </form>
        </div>
      </div>

      <!-- Quick Capsule Filter Tabs (Horizontal Scrollable) -->
      <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pt-5" style="scrollbar-width:none;-ms-overflow-style:none;">
        <a href="<?= build_filter_url('collection', null) ?>" class="px-4 py-2 rounded-full text-xs font-mono uppercase tracking-wider flex-shrink-0 transition-all cursor-pointer <?= empty($active_collection) ? 'bg-stone-950 text-white font-bold shadow-md border border-stone-950' : 'bg-white/10 border border-white/15 text-white/80 hover:border-white/40 hover:text-white' ?>">
          ✦ All Creations (<?= count($products ?? []) ?>)
        </a>
        <?php foreach ($collections as $col): ?>
        <?php $isActive = ($active_collection === $col['slug']); ?>
        <a href="<?= build_filter_url('collection', $col['slug']) ?>" class="px-4 py-2 rounded-full text-xs font-mono uppercase tracking-wider flex-shrink-0 transition-all cursor-pointer <?= $isActive ? 'bg-stone-950 text-white font-bold shadow-md border border-stone-950' : 'bg-white/10 border border-white/15 text-white/80 hover:border-white/40 hover:text-white' ?>">
          <?= htmlspecialchars($col['title']) ?>
        </a>
        <?php endforeach; ?>
      </div>

    </div>
  </section>


  <!-- ── 2. CATALOG PRODUCT SHOWCASE (CRISP EDITORIAL WHITE BODY) ── -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
    
    <div class="flex flex-col md:flex-row gap-8 lg:gap-10 items-start">
      
      <!-- ── ENHANCED LUXURY SIDEBAR FILTERS (SMOOTH NO-CLIPPING SCROLL) ── -->
      <aside class="w-full md:w-72 flex-shrink-0 bg-white p-5 sm:p-6 rounded-3xl border border-stone-200 shadow-md hidden md:block sticky top-[95px] max-h-[calc(100vh-115px)] overflow-y-auto custom-scrollbar space-y-6">
        
        <!-- Sidebar Header with Active Count & Reset -->
        <div class="flex justify-between items-center pb-3 border-b border-stone-200">
          <div class="flex items-center gap-1.5">
            <span class="material-symbols-outlined text-base text-[#a16207]">tune</span>
            <span class="font-mono text-xs uppercase tracking-widest text-stone-900 font-bold">Atelier Filters</span>
          </div>
          <?php if ($has_active_filters): ?>
            <a href="<?= base_url('shop') ?>" class="text-[10px] uppercase font-mono text-rose-600 hover:text-rose-700 font-bold bg-rose-50 px-2.5 py-1 rounded-full border border-rose-200 transition-colors">
              Reset All ✕
            </a>
          <?php endif; ?>
        </div>

        <!-- 1. SIZE FILTER (TAILORED CHIP SELECTOR) -->
        <div>
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-3 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">straighten</span>
              <span>Tailoring Size</span>
            </span>
            <?php if (!empty($active_size)): ?>
              <a href="<?= build_filter_url('size', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="grid grid-cols-3 gap-1.5">
            <?php foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $sz): ?>
            <?php $isSz = ($active_size === $sz); ?>
            <a href="<?= build_filter_url('size', $sz) ?>" class="py-2 text-center text-xs font-mono font-bold rounded-xl border transition-all cursor-pointer <?= $isSz ? 'bg-stone-950 text-[#e9c176] border-stone-950 shadow-md' : 'bg-stone-50 border-stone-200 text-stone-700 hover:border-stone-900 hover:bg-stone-100' ?>">
              <?= $sz ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 2. COLLECTIONS & CAPSULES -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">category</span>
              <span>Capsule World</span>
            </span>
            <?php if (!empty($active_collection)): ?>
              <a href="<?= build_filter_url('collection', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <a href="<?= build_filter_url('collection', null) ?>" class="flex justify-between items-center py-2 px-3 rounded-xl transition-all <?= empty($active_collection) ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:text-stone-950 hover:bg-stone-50' ?>">
              <span>All Masterpieces</span>
              <span class="text-[10px] font-mono text-stone-400"><?= count($products ?? []) ?></span>
            </a>
            <?php foreach ($collections as $col): ?>
            <?php $isCol = ($active_collection === $col['slug']); ?>
            <a href="<?= build_filter_url('collection', $col['slug']) ?>" class="flex justify-between items-center py-2 px-3 rounded-xl transition-all <?= $isCol ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:text-stone-950 hover:bg-stone-50' ?>">
              <span class="line-clamp-1"><?= htmlspecialchars($col['title']) ?></span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 3. FABRIC & RAW MATERIALS -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">texture</span>
              <span>Raw Material</span>
            </span>
            <?php if (!empty($active_fabric)): ?>
              <a href="<?= build_filter_url('fabric', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <?php 
              $fabrics = [
                'Cashmere' => '100% Mongolian Cashmere',
                'Denim' => '14.5oz Okayama Selvedge',
                'Silk' => '22-Momme Mulberry Silk',
                'Wool' => 'Super 150s Virgin Wool',
                'Terry' => '500 GSM French Terry'
              ];
              foreach ($fabrics as $fKey => $fLabel):
              $isFab = ($active_fabric === $fKey);
            ?>
            <a href="<?= build_filter_url('fabric', $fKey) ?>" class="flex justify-between items-center py-1.5 px-3 rounded-xl transition-all <?= $isFab ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span><?= $fLabel ?></span>
              <?php if ($isFab): ?><span class="text-[#a16207] font-bold">✓</span><?php endif; ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 4. BUDGET TIERS -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">payments</span>
              <span>Budget Tiers</span>
            </span>
            <?php if (!empty($active_price)): ?>
              <a href="<?= build_filter_url('price', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <a href="<?= build_filter_url('price', 'under_2000') ?>" class="py-2 px-3 rounded-xl transition-all flex justify-between <?= ($active_price === 'under_2000') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>Under ₹2,000</span>
              <span class="text-[10px] font-mono text-stone-400">Entry</span>
            </a>
            <a href="<?= build_filter_url('price', '2000_5000') ?>" class="py-2 px-3 rounded-xl transition-all flex justify-between <?= ($active_price === '2000_5000') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>₹2,000 – ₹5,000</span>
              <span class="text-[10px] font-mono text-[#a16207]">Core</span>
            </a>
            <a href="<?= build_filter_url('price', 'above_5000') ?>" class="py-2 px-3 rounded-xl transition-all flex justify-between <?= ($active_price === 'above_5000') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>Above ₹5,000</span>
              <span class="text-[10px] font-mono text-amber-600 font-bold">Master</span>
            </a>
          </div>
        </div>

        <!-- 5. SILHOUETTE FIT -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">checkroom</span>
              <span>Silhouette Fit</span>
            </span>
            <?php if (!empty($active_fit)): ?>
              <a href="<?= build_filter_url('fit', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-wrap gap-1.5 text-xs">
            <?php foreach (['Oversized' => 'Relaxed Oversized', 'Structured' => 'Structured', 'Slim' => 'Tailored Slim'] as $fitKey => $fitLbl): ?>
            <?php $isFit = ($active_fit === $fitKey); ?>
            <a href="<?= build_filter_url('fit', $fitKey) ?>" class="px-3 py-1.5 rounded-xl border text-[11px] font-mono transition-all <?= $isFit ? 'bg-stone-950 text-[#e9c176] border-stone-950 font-bold' : 'bg-stone-50 border-stone-200 text-stone-700 hover:border-stone-400' ?>">
              <?= $fitLbl ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 6. AVAILABILITY & SCARCITY -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">verified</span>
              <span>Stock Status</span>
            </span>
            <?php if (!empty($active_avail)): ?>
              <a href="<?= build_filter_url('availability', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <a href="<?= build_filter_url('availability', 'in_stock') ?>" class="py-1.5 px-3 rounded-xl transition-all flex items-center justify-between <?= ($active_avail === 'in_stock') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Priority Express Ready</span>
              </span>
              <?php if ($active_avail === 'in_stock'): ?><span class="text-[#a16207]">✓</span><?php endif; ?>
            </a>
            <a href="<?= build_filter_url('availability', 'low_stock') ?>" class="py-1.5 px-3 rounded-xl transition-all flex items-center justify-between <?= ($active_avail === 'low_stock') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span class="flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                <span>Under 5 Pieces Left</span>
              </span>
              <?php if ($active_avail === 'low_stock'): ?><span class="text-[#a16207]">✓</span><?php endif; ?>
            </a>
          </div>
        </div>

        <!-- Trust Note at Bottom of Sidebar (Fully visible with ample bottom padding) -->
        <div class="border-t border-stone-200 pt-5 pb-2 text-[10px] text-stone-500 flex flex-col gap-2">
          <div class="flex items-center gap-1.5 text-emerald-600 font-bold">
            <span class="material-symbols-outlined text-sm">verified_user</span>
            <span>100% Certified Provenance</span>
          </div>
          <p class="leading-relaxed">Complimentary white-glove BlueDart Express delivery &amp; 7-day doorstep exchange on all boutique acquisitions.</p>
        </div>

      </aside>

      <!-- ── MAIN PRODUCTS GRID AREA ── -->
      <div class="flex-grow w-full">
        
        <!-- Active Filter Badges Bar -->
        <?php if ($has_active_filters): ?>
        <div class="flex flex-wrap items-center gap-2 mb-6 p-4 rounded-2xl bg-white border border-stone-200 shadow-sm text-xs">
          <span class="font-mono text-[10px] uppercase text-stone-400 font-bold mr-1">Active Criteria:</span>
          
          <?php if (!empty($active_collection)): ?>
          <a href="<?= build_filter_url('collection', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-stone-100 border border-stone-300 text-stone-800 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition-colors">
            <span>Capsule: <?= htmlspecialchars($active_collection) ?></span>
            <span class="text-xs">✕</span>
          </a>
          <?php endif; ?>

          <?php if (!empty($active_size)): ?>
          <a href="<?= build_filter_url('size', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-stone-100 border border-stone-300 text-stone-800 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition-colors">
            <span>Size: <?= htmlspecialchars($active_size) ?></span>
            <span class="text-xs">✕</span>
          </a>
          <?php endif; ?>

          <?php if (!empty($active_fabric)): ?>
          <a href="<?= build_filter_url('fabric', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-stone-100 border border-stone-300 text-stone-800 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition-colors">
            <span>Fabric: <?= htmlspecialchars($active_fabric) ?></span>
            <span class="text-xs">✕</span>
          </a>
          <?php endif; ?>

          <?php if (!empty($active_price)): ?>
          <a href="<?= build_filter_url('price', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-stone-100 border border-stone-300 text-stone-800 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition-colors">
            <span>Price: <?= htmlspecialchars(str_replace('_', ' ', $active_price)) ?></span>
            <span class="text-xs">✕</span>
          </a>
          <?php endif; ?>

          <?php if (!empty($active_fit)): ?>
          <a href="<?= build_filter_url('fit', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-stone-100 border border-stone-300 text-stone-800 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition-colors">
            <span>Fit: <?= htmlspecialchars($active_fit) ?></span>
            <span class="text-xs">✕</span>
          </a>
          <?php endif; ?>

          <?php if (!empty($active_avail)): ?>
          <a href="<?= build_filter_url('availability', null) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-stone-100 border border-stone-300 text-stone-800 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-300 transition-colors">
            <span>Availability: <?= htmlspecialchars(str_replace('_', ' ', $active_avail)) ?></span>
            <span class="text-xs">✕</span>
          </a>
          <?php endif; ?>

          <a href="<?= base_url('shop') ?>" class="ml-auto text-[10px] font-mono text-rose-600 hover:underline font-bold">
            Clear All
          </a>
        </div>
        <?php endif; ?>

        <!-- Product Grid (2-Column Mobile, 3-Column Desktop) -->
        <div id="productGridWrapper" class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 transition-all duration-300">
          
          <?php if (empty($products)): ?>
            <div class="col-span-full py-20 text-center flex flex-col items-center justify-center bg-white border border-stone-200 rounded-3xl p-8 shadow-sm">
              <div class="w-16 h-16 rounded-full bg-amber-50 border border-amber-200 flex items-center justify-center mb-4 text-[#a16207]">
                <span class="material-symbols-outlined text-3xl">inventory_2</span>
              </div>
              <h3 class="font-serif text-2xl text-stone-900 mb-2 font-bold">No Atelier Pieces Found</h3>
              <p class="text-stone-500 text-xs max-w-sm mb-6 leading-relaxed">No creations match the selected criteria. Please adjust your filters or reset to view all archives.</p>
              <a href="<?= base_url('shop') ?>" class="px-7 py-3.5 bg-stone-950 text-white font-button text-xs uppercase font-bold tracking-wider rounded-xl shadow-md hover:bg-stone-800 transition-all">
                Reset All Filters
              </a>
            </div>
          <?php else: ?>
            
            <?php foreach ($products as $idx => $p): ?>
            <?php
              $img = !empty($p['primary_image']) ? $p['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
              $vendor_label = !empty($p['vendor']) ? $p['vendor'] : 'LUMINA Atelier';
              $b_price = (float)$p['base_price'];
              $c_price = (float)($p['compare_at_price'] ?? 0);
              $disc_pct = ($c_price > $b_price) ? round((($c_price - $b_price) / $c_price) * 100) : 0;
              $stock_left = 2 + ($idx % 4);
            ?>
            <div class="tilt-card product-item-card group cursor-pointer flex flex-col justify-between h-full bg-white border border-stone-200 hover:border-stone-400 rounded-xl sm:rounded-2xl overflow-hidden p-2.5 sm:p-4 transition-all duration-300 shadow-sm hover:shadow-xl relative" onclick="window.location.href='<?= base_url('products/' . $p['slug']) ?>'">
              
              <div>
                <!-- Image Box -->
                <div class="relative aspect-[3/4] bg-stone-100 mb-2 sm:mb-3.5 overflow-hidden rounded-lg sm:rounded-xl">
                  <img class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-106" src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy"/>
                  
                  <!-- Top Badges -->
                  <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-col gap-1 z-10">
                    <span class="text-[8px] sm:text-[9px] font-mono font-bold uppercase tracking-wider bg-black/85 backdrop-blur-md text-[#e9c176] px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full border border-white/10 flex items-center gap-1 shadow-md">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                      <span>Only <?= $stock_left ?> Left</span>
                    </span>
                    <?php if ($disc_pct > 0): ?>
                    <span class="px-1.5 sm:px-2 py-0.2 sm:py-0.5 rounded-full bg-black/85 border border-amber-400/40 text-[7.5px] sm:text-[9px] font-mono font-bold text-amber-300 backdrop-blur-md shadow-md w-fit">
                      <?= $disc_pct ?>% OFF
                    </span>
                    <?php endif; ?>
                  </div>

                  <!-- Top-Right Actions -->
                  <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex items-center gap-1 sm:gap-1.5 z-10" onclick="event.stopPropagation()">
                    <button type="button" onclick="toggleWishlistItem({id:<?= (int)$p['id'] ?>, title:'<?= addslashes(htmlspecialchars($p['title'])) ?>', price:<?= $b_price ?>, image:'<?= addslashes($img) ?>'})" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/70 hover:bg-black text-rose-400 border border-white/20 flex items-center justify-center transition-all hover:scale-110 active:scale-95 cursor-pointer shadow-md" title="Save to Wardrobe">
                      <span class="material-symbols-outlined text-[11px] sm:text-sm">favorite</span>
                    </button>
                    <button type="button" onclick="openExpressCheckout(<?= $p['id'] ?>, '<?= addslashes($p['title']) ?>', <?= $b_price ?>, '<?= htmlspecialchars($img) ?>', <?= $p['id'] ?>);" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/90 hover:bg-black text-[#e9c176] border border-white/20 flex items-center justify-center shadow-md transition-all hover:scale-110 active:scale-95 cursor-pointer" title="1-Click Instant Acquisition">
                      <svg class="w-3.5 h-3.5 fill-current text-[#e9c176]" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
                    </button>
                  </div>
                </div>

                <!-- Product Meta Info -->
                <div class="space-y-1">
                  <div class="flex items-center justify-between text-[8px] sm:text-[10px] font-mono text-stone-500 uppercase tracking-wider">
                    <span class="truncate"><?= htmlspecialchars($vendor_label) ?></span>
                    <span class="text-amber-600 font-bold flex items-center gap-0.5 flex-shrink-0">
                      ★ 4.9
                    </span>
                  </div>

                  <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 group-hover:text-[#a16207] transition-colors line-clamp-1">
                    <a href="<?= base_url('products/' . $p['slug']) ?>"><?= htmlspecialchars($p['title']) ?></a>
                  </h3>

                  <div class="flex items-baseline gap-1.5 sm:gap-2">
                    <span class="font-serif font-bold text-xs sm:text-base text-stone-900" data-price-inr="<?= $b_price ?>">₹<?= number_format($b_price, 0) ?></span>
                    <?php if ($disc_pct > 0): ?>
                    <span class="text-[10px] sm:text-[11px] text-stone-400 line-through font-mono" data-price-inr="<?= $c_price ?>">₹<?= number_format($c_price, 0) ?></span>
                    <?php endif; ?>
                    <span class="hidden sm:inline text-[10px] text-emerald-600 font-semibold font-mono ml-auto">Free Express</span>
                  </div>
                </div>
              </div>

              <!-- Dual Direct Action Buttons -->
              <div class="pt-2 sm:pt-3 border-t border-stone-100 grid grid-cols-2 gap-1.5 sm:gap-2 mt-2" onclick="event.stopPropagation()">
                <button type="button" onclick="addToCart({id:<?= $p['id'] ?>, title:'<?= addslashes(htmlspecialchars($p['title'])) ?>', price:<?= $b_price ?>, image:'<?= addslashes($img) ?>'}, 1)" class="w-full py-1.5 sm:py-2.5 bg-stone-100 border border-stone-200 text-stone-900 font-button text-[8.5px] sm:text-[11px] uppercase tracking-wider hover:bg-stone-200 transition-all flex items-center justify-center gap-1 cursor-pointer rounded-lg sm:rounded-xl font-semibold">
                  <span class="material-symbols-outlined text-[11px] sm:text-[13px]">shopping_bag</span>
                  <span>Acquire</span>
                </button>
                <button type="button" onclick="openExpressCheckout(<?= $p['id'] ?>, '<?= addslashes($p['title']) ?>', <?= $b_price ?>, '<?= addslashes($img) ?>', <?= $p['id'] ?>);" 
                   class="w-full py-1.5 sm:py-2.5 bg-stone-950 hover:bg-stone-800 text-white font-button font-bold text-[8.5px] sm:text-[11px] uppercase tracking-wider transition-all flex items-center justify-center gap-1 cursor-pointer shadow-sm rounded-lg sm:rounded-xl active:scale-95 border border-stone-900">
                  <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current text-[#e9c176] flex-shrink-0" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
                  <span>Buy</span>
                </button>
              </div>

            </div>
            <?php endforeach; ?>
            
          <?php endif; ?>
        </div>

      </div>

    </div>

  </section>

  <!-- ── Mobile Filter Slide-Over Drawer (UI/UX Pro Max) ── -->
  <div id="mobileFilterDrawer" class="fixed inset-0 z-50 hidden md:hidden" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0" id="mobileFilterBackdrop" onclick="toggleMobileFilterDrawer()"></div>

    <!-- Slide Panel -->
    <div class="fixed inset-y-0 right-0 max-w-[85vw] w-80 bg-white shadow-2xl border-l border-stone-200 flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-out z-10 overflow-y-auto custom-scrollbar" id="mobileFilterPanel">
      <div class="p-5 sm:p-6 space-y-6">
        
        <!-- Drawer Header -->
        <div class="flex justify-between items-center pb-4 border-b border-stone-200">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#a16207]">tune</span>
            <h3 class="font-serif text-lg font-bold text-stone-900">Atelier Filters</h3>
          </div>
          <button type="button" onclick="toggleMobileFilterDrawer()" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-500 hover:text-stone-900 hover:bg-stone-100 transition-colors cursor-pointer" aria-label="Close Filters">
            <span class="material-symbols-outlined text-xl">close</span>
          </button>
        </div>

        <!-- Reset Option -->
        <?php if ($has_active_filters): ?>
          <div class="flex justify-between items-center bg-amber-50 border border-amber-200 rounded-xl p-3">
            <span class="text-xs font-mono font-bold text-amber-900">Active Filters Applied</span>
            <a href="<?= base_url('shop') ?>" class="text-[10px] uppercase font-mono text-rose-600 font-bold bg-white px-2.5 py-1 rounded-lg border border-rose-200 hover:bg-rose-50 transition-colors">
              Reset All ✕
            </a>
          </div>
        <?php endif; ?>

        <!-- 1. SIZE FILTER -->
        <div>
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">straighten</span>
              <span>Tailoring Size</span>
            </span>
            <?php if (!empty($active_size)): ?>
              <a href="<?= build_filter_url('size', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="grid grid-cols-3 gap-1.5">
            <?php foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $sz): ?>
            <?php $isSz = ($active_size === $sz); ?>
            <a href="<?= build_filter_url('size', $sz) ?>" class="py-2 text-center text-xs font-mono font-bold rounded-xl border transition-all cursor-pointer <?= $isSz ? 'bg-stone-950 text-[#e9c176] border-stone-950 shadow-md' : 'bg-stone-50 border-stone-200 text-stone-700 hover:border-stone-900 hover:bg-stone-100' ?>">
              <?= $sz ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 2. COLLECTIONS & CAPSULES -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">category</span>
              <span>Capsule World</span>
            </span>
            <?php if (!empty($active_collection)): ?>
              <a href="<?= build_filter_url('collection', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <a href="<?= build_filter_url('collection', null) ?>" class="flex justify-between items-center py-2 px-3 rounded-xl transition-all <?= empty($active_collection) ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:text-stone-950 hover:bg-stone-50' ?>">
              <span>All Masterpieces</span>
              <span class="text-[10px] font-mono text-stone-400"><?= count($products ?? []) ?></span>
            </a>
            <?php foreach ($collections as $col): ?>
            <?php $isCol = ($active_collection === $col['slug']); ?>
            <a href="<?= build_filter_url('collection', $col['slug']) ?>" class="flex justify-between items-center py-2 px-3 rounded-xl transition-all <?= $isCol ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:text-stone-950 hover:bg-stone-50' ?>">
              <span class="line-clamp-1"><?= htmlspecialchars($col['title']) ?></span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 3. FABRIC & RAW MATERIALS -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">texture</span>
              <span>Raw Material</span>
            </span>
            <?php if (!empty($active_fabric)): ?>
              <a href="<?= build_filter_url('fabric', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <?php 
              $fabrics = [
                'Cashmere' => '100% Mongolian Cashmere',
                'Denim' => '14.5oz Okayama Selvedge',
                'Silk' => '22-Momme Mulberry Silk',
                'Wool' => 'Super 150s Virgin Wool',
                'Terry' => '500 GSM French Terry'
              ];
              foreach ($fabrics as $fKey => $fLabel):
              $isFab = ($active_fabric === $fKey);
            ?>
            <a href="<?= build_filter_url('fabric', $fKey) ?>" class="flex justify-between items-center py-1.5 px-3 rounded-xl transition-all <?= $isFab ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span><?= $fLabel ?></span>
              <?php if ($isFab): ?><span class="text-[#a16207] font-bold">✓</span><?php endif; ?>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 4. BUDGET TIERS -->
        <div class="border-t border-stone-200 pt-5">
          <h4 class="font-label-caps text-xs text-stone-900 uppercase tracking-wider mb-2.5 font-bold flex items-center justify-between">
            <span class="flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">payments</span>
              <span>Budget Tiers</span>
            </span>
            <?php if (!empty($active_price)): ?>
              <a href="<?= build_filter_url('price', null) ?>" class="text-[10px] text-stone-400 hover:text-rose-500 font-mono">Clear</a>
            <?php endif; ?>
          </h4>
          <div class="flex flex-col gap-1 text-xs">
            <a href="<?= build_filter_url('price', 'under_2000') ?>" class="py-2 px-3 rounded-xl transition-all flex justify-between <?= ($active_price === 'under_2000') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>Under ₹2,000</span>
              <span class="text-[10px] font-mono text-stone-400">Entry</span>
            </a>
            <a href="<?= build_filter_url('price', '2000_5000') ?>" class="py-2 px-3 rounded-xl transition-all flex justify-between <?= ($active_price === '2000_5000') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>₹2,000 – ₹5,000</span>
              <span class="text-[10px] font-mono text-[#a16207]">Core</span>
            </a>
            <a href="<?= build_filter_url('price', 'above_5000') ?>" class="py-2 px-3 rounded-xl transition-all flex justify-between <?= ($active_price === 'above_5000') ? 'font-bold text-[#a16207] bg-amber-50 border border-amber-200' : 'text-stone-700 hover:bg-stone-50' ?>">
              <span>Above ₹5,000</span>
              <span class="text-[10px] font-mono text-amber-600 font-bold">Master</span>
            </a>
          </div>
        </div>

      </div>

      <!-- Drawer Footer -->
      <div class="p-5 border-t border-stone-200 bg-stone-50 flex-shrink-0">
        <button type="button" onclick="toggleMobileFilterDrawer()" class="w-full py-3 bg-stone-950 hover:bg-stone-800 text-white font-mono text-xs uppercase font-bold tracking-widest rounded-xl transition-all shadow-md cursor-pointer">
          View <?= count($products ?? []) ?> Pieces
        </button>
      </div>

    </div>
  </div>

</main>

<script>
function setViewMode(mode) {
  var grid = document.getElementById('productGridWrapper');
  var bentoBtn = document.getElementById('btnViewBento');
  var edBtn = document.getElementById('btnViewEditorial');
  if (!grid || !bentoBtn || !edBtn) return;

  if (mode === 'editorial') {
    // 1-Column Single Large Feed View
    grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 transition-all duration-300';
    edBtn.className = 'p-2 bg-stone-900 text-[#e9c176] border border-[#e9c176]/50 rounded-lg text-xs cursor-pointer transition-all shadow-xs';
    bentoBtn.className = 'p-2 text-white/60 hover:text-white rounded-lg text-xs cursor-pointer transition-all border border-transparent';
  } else {
    // 2-Column Side-by-Side Mobile Grid View
    grid.className = 'grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 transition-all duration-300';
    bentoBtn.className = 'p-2 bg-stone-900 text-[#e9c176] border border-[#e9c176]/50 rounded-lg text-xs cursor-pointer transition-all shadow-xs';
    edBtn.className = 'p-2 text-white/60 hover:text-white rounded-lg text-xs cursor-pointer transition-all border border-transparent';
  }

  setTimeout(() => {
    if (window.lenisInstance && typeof window.lenisInstance.resize === 'function') {
      window.lenisInstance.resize();
    }
  }, 60);
}

// ── Mobile Filter Drawer Toggle ──
function toggleMobileFilterDrawer() {
  var drawer = document.getElementById('mobileFilterDrawer');
  var backdrop = document.getElementById('mobileFilterBackdrop');
  var panel = document.getElementById('mobileFilterPanel');
  if (!drawer || !backdrop || !panel) return;

  if (drawer.classList.contains('hidden')) {
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
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
    document.body.style.overflow = '';
    setTimeout(() => {
      drawer.classList.add('hidden');
      drawer.classList.remove('flex');
    }, 300);
  }
}
</script>
