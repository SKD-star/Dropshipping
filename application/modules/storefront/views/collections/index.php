<!-- ══════════════════════════════════════════════════════
     EDITORIAL CAPSULE COLLECTIONS HUB (LUMINA ATELIER)
     BLACK HERO STAGE + CRISP WHITE EDITORIAL MAGAZINE FEED
══════════════════════════════════════════════════════ -->
<main class="min-h-screen bg-[#faf9f6] text-stone-900 pt-20 sm:pt-24 pb-24">

  <!-- ── 1. HAUTE COUTURE HERO (BLACK / OBSIDIAN CANVAS BELOW HEADER) ── -->
  <section class="relative py-16 sm:py-24 border-b border-white/10 overflow-hidden bg-[#07080b] text-white">
    <!-- Ambient Radial Starlight & Golden Flare -->
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#e9c176_1px,transparent_1px)] [background-size:28px_28px] pointer-events-none"></div>
    <div class="absolute w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-amber-500/10 via-[#e9c176]/5 to-transparent blur-[140px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
      
      <!-- Scarcity Ribbon -->
      <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-[#e9c176]/40 text-[10px] sm:text-xs font-mono text-[#e9c176] uppercase tracking-[0.25em] mb-6 shadow-2xl backdrop-blur-md">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
        <span>The Atelier Archives · Autonomous Design Universes</span>
      </div>

      <!-- Main Headline -->
      <h1 class="font-serif text-3xl sm:text-5xl md:text-6xl text-white tracking-tight mb-4 font-normal uppercase">
        Editorial Collections<span class="text-[#e9c176] font-bold">.</span>
      </h1>
      
      <p class="text-white/60 text-xs sm:text-sm md:text-base max-w-2xl mx-auto leading-relaxed mb-8 sm:mb-10 font-light font-sans">
        Each LUMINA collection is conceived as an autonomous design universe. Explore architectural outerwear, 14.5oz Japanese selvedge denim, 22-momme fluid silks, and bespoke Super 150s virgin wool tailoring.
      </p>

      <!-- ── Quick Capsule Category Filter Tabs ── -->
      <div class="flex flex-wrap justify-center items-center gap-2 max-w-4xl mx-auto" id="capsuleFilterNav">
        <button type="button" onclick="filterCapsuleCategory('all', this)" class="capsule-nav-tab active px-5 py-2.5 rounded-full bg-gradient-to-r from-amber-400 to-[#e9c176] text-black text-xs font-mono font-bold uppercase tracking-wider shadow-lg transition-all hover:scale-105 cursor-pointer">
          ✦ All Capsules (<?= count($curated_capsules) ?>)
        </button>
        <?php foreach ($curated_capsules as $c): ?>
        <button type="button" onclick="filterCapsuleCategory('<?= $c['category_filter'] ?>', this)" class="capsule-nav-tab px-5 py-2.5 rounded-full bg-white/5 border border-white/15 hover:border-[#e9c176] hover:bg-white/10 text-white/80 text-xs font-mono uppercase tracking-wider transition-all hover:scale-105 cursor-pointer shadow-sm">
          <?= htmlspecialchars($c['title']) ?>
        </button>
        <?php endforeach; ?>
      </div>

    </div>
  </section>


  <!-- ── 2. EDITORIAL CAPSULES FEED (CRISP WHITE MAGAZINE CARDS) ── -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 space-y-16 sm:space-y-24" id="all-capsules-container">
    
    <?php foreach ($curated_capsules as $idx => $cap): ?>
    <?php 
      $isReverse = ($idx % 2 === 1); 
      $capId = 'capsule-' . $cap['slug'];
      $capNumber = sprintf('%02d', $idx + 1);
      $totalCaps = sprintf('%02d', count($curated_capsules));
    ?>
    <article id="<?= $capId ?>" data-category="<?= $cap['category_filter'] ?>" class="capsule-card-entry scroll-mt-28 bg-white rounded-3xl border border-stone-200 overflow-hidden shadow-lg hover:shadow-2xl hover:border-stone-400 transition-all duration-700">
      
      <!-- Top Editorial Story Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 items-stretch">
        
        <!-- Imagery Stage with Tactile Color Swatch Switcher -->
        <div class="lg:col-span-7 relative aspect-[4/3] sm:aspect-[16/10] lg:aspect-auto overflow-hidden group bg-stone-100 <?= $isReverse ? 'lg:order-2' : '' ?>">
          
          <img id="capImg-<?= $idx ?>" 
               src="<?= htmlspecialchars($cap['image_url']) ?>" 
               alt="<?= htmlspecialchars($cap['title']) ?>" 
               class="w-full h-full object-cover group-hover:scale-105 transition-all duration-1000 ease-out"
               loading="lazy">
          
          <!-- Subtle Dark Gradient Overlay -->
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>
          
          <!-- Top Floating Scarcity Badges -->
          <div class="absolute top-5 left-5 flex flex-wrap gap-2 z-10">
            <span class="text-[9px] sm:text-[10px] font-mono font-bold uppercase tracking-widest bg-black/85 text-[#e9c176] px-3.5 py-1.5 rounded-full border border-white/20 backdrop-blur-md shadow-md flex items-center gap-1.5">
              <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176] animate-pulse"></span>
              <span><?= htmlspecialchars($cap['badge']) ?></span>
            </span>
            <span class="text-[9px] sm:text-[10px] font-mono text-white bg-black/70 px-3 py-1.5 rounded-full border border-white/15 backdrop-blur-md">
              <?= $cap['items_count'] ?> Hand-Cut Editions
            </span>
          </div>

          <!-- Top-Right 360° Runway Lightbox Button -->
          <button type="button" onclick="openLookbookModal(<?= $idx ?>)" class="absolute top-5 right-5 px-4 py-2 rounded-full bg-black/80 hover:bg-black text-white hover:text-[#e9c176] border border-white/30 text-[10px] sm:text-[11px] font-mono uppercase tracking-wider flex items-center gap-1.5 transition-all z-10 shadow-lg cursor-pointer" title="View 360° Runway Angles">
            <span class="material-symbols-outlined text-sm">view_in_ar</span>
            <span class="font-bold">360° Runway</span>
          </button>

          <!-- Interactive Color Swatches & Starting Price Bar -->
          <div class="absolute bottom-5 left-5 right-5 flex flex-wrap justify-between items-end gap-3 z-10">
            
            <!-- Tactile Swatch Selector -->
            <div class="bg-black/80 backdrop-blur-md px-3.5 py-2 rounded-2xl border border-white/20 shadow-xl">
              <span class="text-[9px] font-mono uppercase text-white/80 tracking-widest block mb-1.5" id="swatchLabel-<?= $idx ?>">
                Active Shade: <?= htmlspecialchars($cap['palette'][0]['name']) ?>
              </span>
              <div class="flex items-center gap-2">
                <?php foreach ($cap['palette'] as $pIdx => $pal): ?>
                <button type="button" 
                        onclick="switchCapsuleSwatch(<?= $idx ?>, '<?= htmlspecialchars(addslashes($pal['name'])) ?>', '<?= htmlspecialchars(addslashes($pal['img'])) ?>', this)"
                        class="cap-swatch-btn <?= $pIdx === 0 ? 'ring-2 ring-[#e9c176] scale-110' : 'opacity-70 hover:opacity-100' ?> w-6 h-6 rounded-full border border-white/50 shadow-md transition-all cursor-pointer" 
                        style="background-color: <?= $pal['hex'] ?>;" 
                        title="<?= htmlspecialchars($pal['name']) ?>">
                </button>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Price Pill -->
            <span class="text-xs font-mono text-white font-bold bg-black/85 px-4 py-2 rounded-full border border-white/20 backdrop-blur-md shadow-xl" data-price-inr="<?= $cap['min_price'] ?>">
              From ₹<?= number_format($cap['min_price'], 0) ?>
            </span>
          </div>

        </div>

        <!-- Editorial Storytelling & Provenance Column -->
        <div class="lg:col-span-5 p-7 sm:p-10 md:p-12 flex flex-col justify-between bg-white border-t lg:border-t-0 <?= $isReverse ? 'lg:border-r lg:order-1' : 'lg:border-l' ?> border-stone-200">
          
          <div>
            <!-- Capsule Counter & Provenance -->
            <div class="flex items-center justify-between gap-2 mb-3">
              <span class="text-xs font-mono uppercase tracking-[0.25em] text-[#a16207] font-bold">
                Capsule <?= $capNumber ?> / <?= $totalCaps ?>
              </span>
              <span class="text-xs font-mono text-emerald-600 font-semibold flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Active Production</span>
              </span>
            </div>

            <!-- Title & Tagline -->
            <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-950 mb-2 font-bold">
              <?= htmlspecialchars($cap['title']) ?>
            </h2>

            <p class="text-xs font-mono text-[#a16207] mb-4 leading-relaxed tracking-wide font-semibold">
              <?= htmlspecialchars($cap['tagline']) ?>
            </p>

            <p class="text-stone-600 text-xs sm:text-sm leading-relaxed mb-6 font-light font-sans">
              <?= htmlspecialchars($cap['description']) ?>
            </p>

            <!-- Technical Specifications Grid (Clean Table) -->
            <div class="grid grid-cols-2 gap-4 py-4 border-y border-stone-200 mb-6 text-xs font-mono">
              <div>
                <span class="text-[10px] uppercase text-stone-400 block mb-0.5 tracking-wider font-semibold">Tailoring Method</span>
                <span class="font-bold text-xs text-stone-900">Single-Needle Hand Finished</span>
              </div>
              <div>
                <span class="text-[10px] uppercase text-stone-400 block mb-0.5 tracking-wider font-semibold">Priority Transit</span>
                <span class="font-bold text-xs text-emerald-600">Insured BlueDart Air</span>
              </div>
            </div>
          </div>

          <!-- Direct Capsule Actions -->
          <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <a href="<?= base_url('shop?collection=' . urlencode($cap['slug'])) ?>" class="flex-1 py-3.5 px-6 bg-stone-950 hover:bg-stone-800 text-white font-button font-bold text-xs uppercase tracking-widest text-center transition-all shadow-md rounded-xl flex items-center justify-center gap-2 cursor-pointer">
              <span>Acquire <?= htmlspecialchars($cap['title']) ?></span>
              <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
            <button type="button" onclick="openLookbookModal(<?= $idx ?>)" class="py-3.5 px-5 bg-stone-100 hover:bg-stone-200 border border-stone-300 text-stone-800 font-button text-xs uppercase tracking-wider text-center transition-all rounded-xl flex items-center justify-center gap-1.5 cursor-pointer font-semibold">
              <span class="material-symbols-outlined text-sm text-[#a16207]">photo_library</span>
              <span>Lookbook</span>
            </button>
          </div>

        </div>

      </div>

      <!-- ── Bottom Mini-Product Rail (3 Curated Garment Pieces in this Capsule) ── -->
      <?php if (!empty($cap['products'])): ?>
      <div class="border-t border-stone-200 bg-stone-50 p-6 sm:p-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-6">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#a16207] text-lg">checkroom</span>
            <h4 class="font-serif text-sm sm:text-base font-bold text-stone-900 uppercase tracking-wider">Featured Pieces in <?= htmlspecialchars($cap['title']) ?></h4>
          </div>
          <span class="text-[11px] font-mono text-stone-500 font-medium">Complimentary Insured Courier Transit</span>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5">
          <?php foreach ($cap['products'] as $p): ?>
          <?php 
            $p_price = (float)($p['price'] ?? 4999);
            $p_img = !empty($p['image']) ? $p['image'] : base_url('img/cashmere_cocoon_coat.jpg');
          ?>
          <div class="bg-white rounded-xl sm:rounded-2xl border border-stone-200 hover:border-stone-400 p-2.5 sm:p-4 flex flex-col justify-between transition-all duration-300 shadow-sm hover:shadow-md group/item">
            
            <!-- Thumbnail Image -->
            <div class="relative aspect-square rounded-lg sm:rounded-xl overflow-hidden mb-2 sm:mb-3 bg-stone-100 cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $p['slug']) ?>'">
              <img src="<?= htmlspecialchars($p_img) ?>" alt="<?= htmlspecialchars($p['title']) ?>" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-700 ease-out" loading="lazy">
              
              <!-- Fabric Tag -->
              <span class="absolute top-2 left-2 text-[8px] sm:text-[9px] font-mono font-bold uppercase tracking-wider bg-black/80 text-[#e9c176] px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full border border-white/10 backdrop-blur-sm shadow-md">
                <?= htmlspecialchars($p['fabric'] ?? 'Atelier Piece') ?>
              </span>

              <!-- Top-Right 1-Click Instant Acquisition -->
              <button type="button" 
                      onclick="event.stopPropagation(); openExpressCheckout(<?= $p['id'] ?>, '<?= addslashes(htmlspecialchars($p['title'])) ?>', <?= $p_price ?>, '<?= addslashes(htmlspecialchars($p_img)) ?>', <?= $p['id'] ?>);"
                      class="absolute top-2 right-2 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/90 hover:bg-black text-[#e9c176] border border-white/20 flex items-center justify-center shadow-md transition-all hover:scale-110 active:scale-95 cursor-pointer"
                      title="Instant 1-Click Buy">
                <svg class="w-3.5 h-3.5 fill-current text-[#e9c176]" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
              </button>
            </div>

            <!-- Content & Actions -->
            <div>
              <h5 class="font-serif text-xs sm:text-sm font-bold text-stone-900 mb-1 sm:mb-1.5 line-clamp-1 group-hover/item:text-[#a16207] transition-colors">
                <a href="<?= base_url('products/' . $p['slug']) ?>"><?= htmlspecialchars($p['title']) ?></a>
              </h5>
              
              <!-- Price Row -->
              <div class="flex items-baseline gap-1.5 sm:gap-2 mb-2 sm:mb-3">
                <span class="font-serif font-bold text-xs sm:text-sm text-stone-900" data-price-inr="<?= $p_price ?>">₹<?= number_format($p_price, 0) ?></span>
                <?php if (!empty($p['compare_price']) && $p['compare_price'] > $p_price): ?>
                <span class="text-[9px] sm:text-[10px] text-stone-400 line-through font-mono" data-price-inr="<?= $p['compare_price'] ?>">₹<?= number_format($p['compare_price'], 0) ?></span>
                <?php endif; ?>
              </div>

              <!-- Dual Action Buttons -->
              <div class="grid grid-cols-2 gap-1.5 sm:gap-2 pt-2 border-t border-stone-100">
                <?php
                  $acquire_cp_data = [
                    'id' => (int)$p['id'],
                    'title' => $p['title'],
                    'price' => (float)$p_price,
                    'compare_price' => (float)($p['compare_price'] ?? 0),
                    'image' => $p_img,
                    'vendor' => $p['vendor'] ?? 'Lumina Atelier Milano',
                    'description' => strip_tags($p['description'] ?? 'Bespoke collection piece.')
                  ];
                ?>
                <button type="button" 
                        data-tooltip="Fit &amp; Sizing" 
                        data-quickview="<?= htmlspecialchars(json_encode($acquire_cp_data), ENT_QUOTES, 'UTF-8') ?>" 
                        onclick="openQuickView(this.dataset.quickview || this.getAttribute('data-quickview'))" 
                        class="uiverse-action-btn uiverse-acquire-btn active:scale-95">
                  <div class="uiverse-btn-wrapper">
                    <div class="uiverse-btn-text">
                      <span class="material-symbols-outlined text-[12px] sm:text-[13px] text-[#a16207]">shopping_bag</span>
                      <span>Acquire</span>
                    </div>
                    <span class="uiverse-btn-icon">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                      <span>AI Fit</span>
                    </span>
                  </div>
                </button>
                <button type="button" 
                        data-tooltip="Instant: ₹<?= number_format($p_price, 0) ?>" 
                        onclick="openExpressCheckout(<?= $p['id'] ?>, '<?= addslashes(htmlspecialchars($p['title'])) ?>', <?= $p_price ?>, '<?= addslashes(htmlspecialchars($p_img)) ?>', <?= $p['id'] ?>);" 
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

          </div>
          <?php endforeach; ?>
        </div>

      </div>
      <?php endif; ?>

    </article>
    <?php endforeach; ?>

  </section>


  <!-- ── 3. BESPOKE PRIVATE ATELIER SERVICE BANNER (OBSIDIAN CONTRAST) ── -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    <div class="bg-stone-950 rounded-3xl p-8 sm:p-12 md:p-14 border border-stone-800 text-white flex flex-col lg:flex-row items-center justify-between gap-8 shadow-2xl relative overflow-hidden">
      
      <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-amber-500/10 blur-[80px] pointer-events-none"></div>

      <div class="flex items-center gap-6 relative z-10">
        <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center flex-shrink-0 shadow-lg">
          <span class="material-symbols-outlined text-[#e9c176] text-3xl">straighten</span>
        </div>
        <div>
          <span class="text-[10px] font-mono text-[#e9c176] uppercase tracking-widest block mb-1 font-bold">Private Atelier Service</span>
          <h3 class="font-serif text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">Looking for a Bespoke Custom Silhouette?</h3>
          <p class="text-white/70 text-xs sm:text-sm leading-relaxed max-w-xl font-light">
            Our master tailors provide made-to-measure fittings, raw fabric inspections, and personalized capsule recommendations tailored to your proportions.
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
     4. INTERACTIVE 360° RUNWAY LOOKBOOK LIGHTBOX MODAL
══════════════════════════════════════════════════════ -->
<div id="lookbookLightboxModal" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[120] hidden items-center justify-center p-4 md:p-8" onclick="if(event.target===this)closeLookbookModal()">
  <div class="bg-[#0b0c10] p-6 sm:p-8 rounded-3xl max-w-4xl w-full border border-white/20 text-white shadow-2xl relative max-h-[92vh] overflow-y-auto custom-scrollbar flex flex-col justify-between">
    
    <!-- Modal Header -->
    <div class="flex justify-between items-center pb-4 mb-6 border-b border-white/15">
      <div>
        <span class="text-[10px] font-mono uppercase tracking-widest text-[#e9c176] block mb-0.5">Atelier Runway 360° Archive</span>
        <h3 class="font-serif text-xl sm:text-2xl font-bold text-white" id="modalLookbookTitle">Collection Lookbook</h3>
      </div>
      <button type="button" onclick="closeLookbookModal()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer" aria-label="Close Lookbook">
        <span class="material-symbols-outlined text-xl">close</span>
      </button>
    </div>

    <!-- Gallery Grid Injected dynamically -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6" id="modalLookbookGallery"></div>

    <!-- Modal Footer -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-4 border-t border-white/10">
      <span class="text-xs font-mono text-white/50">Multi-Angle Model Runway Photography</span>
      <a href="<?= base_url('shop') ?>" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-amber-400 to-[#e9c176] text-black font-button text-xs uppercase tracking-widest font-bold hover:opacity-90 transition-all rounded-xl text-center shadow-lg">
        Explore Full Catalog →
      </a>
    </div>

  </div>
</div>


<script>
const curatedCapsulesData = <?= json_encode($curated_capsules ?? []) ?>;

// ── Real-Time Category Tab Filter ──
function filterCapsuleCategory(cat, btn) {
  document.querySelectorAll('.capsule-nav-tab').forEach(b => {
    b.className = 'capsule-nav-tab px-5 py-2.5 rounded-full bg-white/5 border border-white/15 hover:border-[#e9c176] hover:bg-white/10 text-white/80 text-xs font-mono uppercase tracking-wider transition-all hover:scale-105 cursor-pointer shadow-sm';
  });
  btn.className = 'capsule-nav-tab active px-5 py-2.5 rounded-full bg-gradient-to-r from-amber-400 to-[#e9c176] text-black text-xs font-mono font-bold uppercase tracking-wider shadow-lg transition-all hover:scale-105 cursor-pointer';

  document.querySelectorAll('.capsule-card-entry').forEach(card => {
    if (cat === 'all' || card.getAttribute('data-category') === cat) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });

  setTimeout(() => {
    if (window.lenisInstance && typeof window.lenisInstance.resize === 'function') {
      window.lenisInstance.resize();
    }
  }, 60);
}

// ── Tactile Swatch Shade Switcher with Image Fade ──
function switchCapsuleSwatch(idx, shadeName, imgUrl, btn) {
  const img = document.getElementById('capImg-' + idx);
  const label = document.getElementById('swatchLabel-' + idx);
  
  if (img) {
    img.style.opacity = '0.3';
    setTimeout(() => {
      img.src = imgUrl;
      img.style.opacity = '1';
    }, 150);
  }
  
  if (label) label.textContent = 'Active Shade: ' + shadeName;

  btn.closest('article').querySelectorAll('.cap-swatch-btn').forEach(b => {
    b.classList.remove('ring-2', 'ring-[#e9c176]', 'scale-110');
    b.classList.add('opacity-70');
  });
  btn.classList.add('ring-2', 'ring-[#e9c176]', 'scale-110');
  btn.classList.remove('opacity-70');
}

// ── Interactive 360° Runway Lightbox Modal ──
function openLookbookModal(idx) {
  const cap = curatedCapsulesData[idx];
  if (!cap) return;

  const modal = document.getElementById('lookbookLightboxModal');
  const title = document.getElementById('modalLookbookTitle');
  const gallery = document.getElementById('modalLookbookGallery');

  title.textContent = cap.title + ' · Runway 360°';

  let html = '';
  (cap.lookbook_images || [cap.image_url]).forEach((img, i) => {
    html += `
      <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-black/80 border border-white/15 relative group">
        <img src="${img}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Runway Angle ${i + 1}">
        <div class="absolute bottom-3 left-3 px-3 py-1 rounded-full bg-black/80 text-[10px] font-mono text-[#e9c176] border border-white/20 backdrop-blur-md">
          Runway Perspective ${i + 1}
        </div>
      </div>
    `;
  });
  gallery.innerHTML = html;

  modal.classList.remove('hidden');
  modal.classList.add('flex');
}

function closeLookbookModal() {
  const modal = document.getElementById('lookbookLightboxModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeLookbookModal();
});
</script>
