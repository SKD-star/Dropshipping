<!-- ══════════════════════════════════════════════════════
     SEARCH RESULTS — NOVADROP CURATED ATELIER ARCHIVE
     HAUTE COUTURE LUXURY CARDS · ANIMATED BUTTONS · 3D TILT
══════════════════════════════════════════════════════ -->
<style>
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
</style>

<main class="min-h-screen bg-[#FAF8F5] text-stone-900 pt-20 sm:pt-24 pb-28">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-8 sm:mb-12 border-b border-stone-200 pb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
      <div>
        <nav class="text-xs font-mono text-stone-500 flex items-center gap-2 uppercase tracking-wider mb-2">
          <a href="<?= base_url() ?>" class="hover:text-stone-900 transition-colors">Atelier</a>
          <span>/</span>
          <span class="text-[#a16207] font-semibold">Search Results</span>
        </nav>
        <h1 class="font-serif text-2xl sm:text-4xl text-stone-950 font-normal leading-tight">
          <?php if (!empty($query)): ?>
            Search Results for “<span class="text-[#a16207] font-semibold"><?= htmlspecialchars($query) ?></span>”
          <?php else: ?>
            Discover All Curated Pieces
          <?php endif; ?>
        </h1>
        <p class="text-xs text-stone-500 mt-1 font-mono">
          Found <strong><?= $total ?></strong> <?= $total === 1 ? 'creation' : 'creations' ?>
        </p>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?= base_url('shop') ?>" class="px-5 py-2.5 bg-white border border-stone-200 text-stone-800 text-xs font-mono uppercase tracking-wider rounded-xl hover:border-stone-900 hover:bg-stone-50 transition-all shadow-2xs">
          View Full Boutique →
        </a>
      </div>
    </div>

    <?php if (empty($products)): ?>
      <div class="bg-white rounded-3xl p-10 sm:p-16 border border-stone-200 text-center max-w-2xl mx-auto shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-amber-50 text-[#a16207] flex items-center justify-center mx-auto mb-4 border border-amber-200">
          <span class="material-symbols-outlined text-3xl">search_off</span>
        </div>
        <h2 class="font-serif text-2xl font-bold text-stone-950 mb-2">No Matching Pieces Found</h2>
        <p class="text-stone-600 text-xs sm:text-sm mb-6 leading-relaxed font-light">
          Try refining your search with terms like “Cashmere Coat”, “Selvedge Denim”, “Mulberry Silk”, “Wool Blazer”, or “Knitwear”.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
          <a href="<?= base_url('shop') ?>" class="px-6 py-3 bg-stone-950 text-white text-xs font-button uppercase tracking-widest font-bold rounded-xl shadow-md hover:bg-stone-800 transition-all">
            Browse Boutique Catalog
          </a>
          <a href="<?= base_url('collections') ?>" class="px-6 py-3 bg-stone-100 border border-stone-200 text-stone-800 text-xs font-button uppercase tracking-widest rounded-xl hover:bg-stone-200 transition-all">
            View Capsule Collections
          </a>
        </div>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
        <?php foreach ($products as $p): ?>
        <?php 
          $price = (float)($p['min_price'] ?? $p['base_price'] ?? 0); 
          $img = !empty($p['primary_image']) ? $p['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
          $vendor = $p['vendor'] ?? 'Lumina Haute Couture';
          $card_pts = !empty($p['reward_points']) ? (int)$p['reward_points'] : max(1, round($price * 0.06));
        ?>
        <div class="store-product-card tilt-card group bg-white rounded-xl sm:rounded-2xl border border-stone-200 hover:border-[#a16207]/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-xs hover:shadow-xl p-2.5 sm:p-3 cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $p['slug']) ?>'">
          
          <div class="tilt-glare"></div>

          <div>
            <div class="relative aspect-[3/4] bg-stone-100 rounded-lg sm:rounded-xl overflow-hidden mb-2.5">
              <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
              
              <!-- Badges -->
              <div class="absolute top-2 left-2 z-10">
                <span class="px-2 py-0.5 rounded-full bg-black/85 backdrop-blur-md text-[#e9c176] text-[8.5px] font-mono font-bold uppercase tracking-wider border border-white/10 flex items-center gap-1 shadow-md">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176]"></span>
                  <span>Atelier Cut</span>
                </span>
              </div>

              <!-- Top-Right Wishlist -->
              <div class="absolute top-2 right-2 z-10" onclick="event.stopPropagation()">
                <div class="heart-container w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/90 hover:bg-white border border-stone-200 shadow-xs transition-all hover:scale-110 active:scale-90 flex items-center justify-center cursor-pointer" title="Save to Wardrobe">
                  <input type="checkbox" class="checkbox" data-wishlist-id="<?= (int)$p['id'] ?>" onchange="toggleWishlistItem({id:<?= (int)$p['id'] ?>, title:'<?= addslashes(htmlspecialchars($p['title'])) ?>', price:<?= $price ?>, image:'<?= addslashes($img) ?>'}, event)">
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

            <span class="text-[8.5px] sm:text-[9px] font-mono text-[#a16207] uppercase tracking-widest block mb-1 font-bold truncate">
              <?= htmlspecialchars($vendor) ?>
            </span>

            <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 mb-1 line-clamp-1 group-hover:text-[#a16207] transition-colors">
              <?= htmlspecialchars($p['title']) ?>
            </h3>

            <div class="flex items-baseline justify-between gap-1 mb-1 sm:mb-2">
              <span class="font-serif font-bold text-sm sm:text-base text-stone-950" data-price-inr="<?= $price ?>">₹<?= number_format($price, 0) ?></span>
              <span class="inline-flex items-center gap-1 text-[8.5px] font-mono font-bold text-amber-900 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded">
                <span>🪙</span>
                <span>+<?= number_format($card_pts) ?> pts</span>
              </span>
            </div>
          </div>

          <!-- Animated Action Buttons -->
          <div class="pt-2 border-t border-stone-100 grid grid-cols-2 gap-1.5" onclick="event.stopPropagation()">
            <button type="button" 
                    data-tooltip="Acquire" 
                    onclick="addToCart({id:<?= $p['id'] ?>, title:'<?= addslashes(htmlspecialchars($p['title'])) ?>', price:<?= (float)$price ?>, image:'<?= addslashes($img) ?>'}, 1)" 
                    class="uiverse-action-btn uiverse-acquire-btn active:scale-95">
              <div class="uiverse-btn-wrapper">
                <div class="uiverse-btn-text">
                  <span class="material-symbols-outlined text-[12px] sm:text-[13px] text-[#a16207]">shopping_bag</span>
                  <span>Acquire</span>
                </div>
                <span class="uiverse-btn-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                  <span>Add to Bag</span>
                </span>
              </div>
            </button>

            <button type="button" 
                    data-tooltip="Instant: ₹<?= number_format($price, 0) ?>" 
                    onclick="openExpressCheckout(<?= $p['id'] ?>, '<?= addslashes($p['title']) ?>', <?= $price ?>, '<?= addslashes($img) ?>', <?= $p['id'] ?>);" 
                    class="uiverse-action-btn uiverse-buy-btn active:scale-95">
              <div class="uiverse-btn-wrapper">
                <div class="uiverse-btn-text">
                  <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current text-[#e9c176] flex-shrink-0" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
                  <span>Buy</span>
                </div>
                <span class="uiverse-btn-icon">
                  <svg viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5 text-[#e9c176]"><path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/></svg>
                  <span>1-Click</span>
                </span>
              </div>
            </button>
          </div>

        </div>
        <?php endforeach; ?>
      </div>

      <?php if (!empty($total_pages) && $total_pages > 1): ?>
      <div class="flex justify-center items-center gap-2 mt-12 pt-6 border-t border-stone-200">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="<?= base_url('search?q=' . urlencode($query) . '&page=' . $i) ?>" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-mono transition-all <?= ($page ?? 1) === $i ? 'bg-stone-950 text-white font-bold shadow-md' : 'bg-white text-stone-700 border border-stone-200 hover:border-stone-900' ?>">
          <?= $i ?>
        </a>
        <?php endfor; ?>
      </div>
      <?php endif; ?>

    <?php endif; ?>

  </div>
</main>
