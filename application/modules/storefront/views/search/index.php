<!-- ══════════════════════════════════════════════════════
     SEARCH RESULTS — NOVADROP CURATED ARCHIVE
══════════════════════════════════════════════════════ -->
<main class="min-h-screen bg-[#08090c] text-white pt-20 pb-24">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-10 border-b border-white/10 pb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
      <div>
        <div class="text-xs font-mono text-white/60 flex items-center gap-2 uppercase tracking-wider mb-2">
          <a href="<?= base_url() ?>" class="hover:text-white transition-colors">Atelier</a>
          <span>/</span>
          <span class="text-[#e9c176] font-semibold">Search Results</span>
        </div>
        <h1 class="font-display-lg text-2xl sm:text-4xl text-white font-serif">
          <?php if (!empty($query)): ?>
            Search Results for “<span class="text-[#e9c176]"><?= htmlspecialchars($query) ?></span>”
          <?php else: ?>
            Discover All Curated Pieces
          <?php endif; ?>
        </h1>
        <p class="text-xs text-white/60 mt-1 font-mono">
          Found <strong><?= $total ?></strong> <?= $total === 1 ? 'creation' : 'creations' ?>
        </p>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?= base_url('collections') ?>" class="px-5 py-2.5 bg-white/5 border border-white/20 text-white text-xs font-mono uppercase tracking-wider rounded-xl hover:border-[#e9c176] transition-all">
          Explore Capsules →
        </a>
      </div>
    </div>

    <?php if (empty($products)): ?>
      <div class="bg-[#111218] rounded-3xl p-12 md:p-16 border border-white/10 text-center max-w-2xl mx-auto shadow-2xl">
        <span class="material-symbols-outlined text-[#e9c176] text-5xl mb-4">search_off</span>
        <h3 class="font-serif text-2xl font-bold text-white mb-2">No Matching Pieces Found</h3>
        <p class="text-white/70 text-xs md:text-sm mb-6 leading-relaxed font-light">
          Try searching for keywords like “Cashmere Coat”, “Selvedge Denim”, “Mulberry Silk”, “Wool Blazer”, “French Terry”, or “Knitwear”.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
          <a href="<?= base_url('shop') ?>" class="px-6 py-3.5 bg-[#e9c176] text-black text-xs font-button uppercase tracking-widest font-bold rounded-xl shadow-lg hover:bg-amber-300 transition-all">
            Browse Boutique Catalog
          </a>
          <a href="<?= base_url('collections') ?>" class="px-6 py-3.5 bg-white/5 border border-white/20 text-white text-xs font-button uppercase tracking-widest rounded-xl hover:bg-white/10 transition-all">
            View Capsule Collections
          </a>
        </div>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
        <?php foreach ($products as $p): ?>
        <?php 
          $price = (float)($p['min_price'] ?? $p['base_price'] ?? 4999); 
          $img = !empty($p['primary_image']) ? $p['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
        ?>
        <div class="tilt-card group bg-[#111218] rounded-xl sm:rounded-2xl border border-white/10 hover:border-[#e9c176]/50 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-xl hover:shadow-2xl p-2.5 sm:p-4 cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $p['slug']) ?>'">
          
          <div class="relative aspect-[3/4] bg-black/60 rounded-lg sm:rounded-xl overflow-hidden mb-2 sm:mb-3">
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700">
            
            <div class="absolute top-2.5 left-2.5">
              <span class="text-[9px] font-mono font-bold uppercase tracking-wider bg-black/80 text-[#e9c176] px-2 py-0.5 rounded-full border border-white/10">
                ✦ Verified Piece
              </span>
            </div>

            <button type="button" 
                    onclick="event.stopPropagation(); openExpressCheckout(<?= $p['id'] ?>, '<?= addslashes($p['title']) ?>', <?= $price ?>, '<?= htmlspecialchars($img) ?>', <?= $p['id'] ?>);"
                    class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full bg-[#e9c176] hover:bg-amber-300 text-black flex items-center justify-center shadow-md transition-all hover:scale-110 cursor-pointer"
                    title="1-Click Instant Buy">
              <span class="material-symbols-outlined text-xs">bolt</span>
            </button>
          </div>

          <div>
            <span class="text-[10px] font-mono text-[#e9c176] uppercase tracking-wider block mb-1">
              <?= htmlspecialchars($p['vendor'] ?? 'NovaDrop Studio') ?>
            </span>

            <h4 class="font-serif text-xs font-bold text-white mb-2 line-clamp-1 group-hover:text-[#e9c176] transition-colors">
              <?= htmlspecialchars($p['title']) ?>
            </h4>

            <div class="flex items-center justify-between pt-2 border-t border-white/10">
              <span class="font-serif font-bold text-sm text-[#e9c176]" data-price-inr="<?= $price ?>">₹<?= number_format($price, 0) ?></span>
              
              <button type="button" 
                      onclick="event.stopPropagation(); addToCart({id:<?= $p['id'] ?>, title:'<?= addslashes(htmlspecialchars($p['title'])) ?>', price:<?= (float)$price ?>, image:'<?= addslashes($img) ?>'}, 1)" 
                      class="px-3 py-1.5 bg-white/10 hover:bg-white/20 text-white text-[10px] font-button uppercase tracking-wider rounded-lg transition-colors flex items-center gap-1 cursor-pointer">
                <span>Add +</span>
              </button>
            </div>
          </div>

        </div>
        <?php endforeach; ?>
      </div>

      <?php if ($total_pages > 1): ?>
      <div class="flex justify-center items-center gap-2 mt-12">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="<?= base_url('search?q=' . urlencode($query) . '&page=' . $i) ?>" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-mono transition-all <?= $page === $i ? 'bg-[#e9c176] text-black font-bold shadow-md' : 'bg-white/5 text-white border border-white/15 hover:border-white/40' ?>">
          <?= $i ?>
        </a>
        <?php endfor; ?>
      </div>
      <?php endif; ?>

    <?php endif; ?>

  </div>
</main>
