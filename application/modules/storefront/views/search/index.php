<!-- ══════════════════════════════════════════════════════
     SEARCH RESULTS — NOVADROP CURATED ARCHIVE
══════════════════════════════════════════════════════ -->
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
        <a href="<?= base_url('collections') ?>" class="px-5 py-2.5 bg-white border border-stone-200 text-stone-800 text-xs font-mono uppercase tracking-wider rounded-xl hover:border-stone-900 hover:bg-stone-50 transition-all shadow-2xs">
          Explore Capsules →
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
          $vendor = $p['vendor'] ?? 'NovaDrop Atelier';
        ?>
        <div class="group bg-white rounded-2xl border border-stone-200 hover:border-[#a16207]/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-2xs hover:shadow-xl p-3 cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $p['slug']) ?>'">
          
          <div>
            <div class="relative aspect-[3/4] bg-stone-100 rounded-xl overflow-hidden mb-3">
              <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
              
              <div class="absolute top-2.5 right-2.5 z-10" onclick="event.stopPropagation()">
                <div class="heart-container w-7 h-7 rounded-full bg-white/95 hover:bg-white border border-stone-200 shadow-xs transition-all hover:scale-110 active:scale-90 flex items-center justify-center cursor-pointer" title="Save to Wardrobe">
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

            <span class="text-[9px] font-mono text-[#a16207] uppercase tracking-widest block mb-1 font-bold truncate">
              <?= htmlspecialchars($vendor) ?>
            </span>

            <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 mb-2 line-clamp-1 group-hover:text-[#a16207] transition-colors">
              <?= htmlspecialchars($p['title']) ?>
            </h3>
          </div>

          <div class="flex items-center justify-between pt-2.5 border-t border-stone-100 mt-1">
            <span class="font-serif font-bold text-sm sm:text-base text-stone-950" data-price-inr="<?= $price ?>">₹<?= number_format($price, 0) ?></span>
            
            <button type="button" 
                    onclick="event.stopPropagation(); addToCart({id:<?= $p['id'] ?>, title:'<?= addslashes(htmlspecialchars($p['title'])) ?>', price:<?= (float)$price ?>, image:'<?= addslashes($img) ?>'}, 1)" 
                    class="px-3 py-1.5 bg-stone-950 hover:bg-stone-800 text-white text-[10px] font-mono uppercase tracking-wider font-bold rounded-lg transition-colors flex items-center gap-1 cursor-pointer">
              <span class="material-symbols-outlined text-[12px]">shopping_bag</span>
              <span>Add</span>
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
