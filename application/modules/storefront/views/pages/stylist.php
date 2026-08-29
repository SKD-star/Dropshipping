<!-- ══════════════════════════════════════════════════════
     AI STYLIST CONCIERGE & SILHOUETTE ARCHITECT (LUMINA)
══════════════════════════════════════════════════════ -->
<main class="min-h-screen bg-[#08090c] text-white pt-20 pb-24">

  <!-- Header -->
  <section class="relative py-16 border-b border-white/10 overflow-hidden text-center">
    <div class="absolute w-[500px] h-[500px] rounded-full bg-amber-500/10 blur-[120px] top-0 left-1/2 -translate-x-1/2 pointer-events-none"></div>
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
      <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-[#e9c176]/40 text-[11px] font-mono text-[#e9c176] uppercase tracking-widest mb-4 shadow-xl">
        <span class="material-symbols-outlined text-xs">auto_awesome</span>
        <span>Lumina AI Haute Couture Concierge</span>
      </div>

      <h1 class="font-display-lg text-3xl sm:text-4xl md:text-5xl font-serif text-white mb-4 tracking-tight">
        AI Stylist Concierge
      </h1>

      <p class="text-white/70 text-xs md:text-sm max-w-xl mx-auto leading-relaxed font-light">
        Consult our proprietary sartorial intelligence on tailored silhouette proportions, garment draping, and bespoke textile pairings.
      </p>
    </div>
  </section>

  <!-- Interactive Stylist Consultation Studio -->
  <section class="max-w-4xl mx-auto px-margin-mobile md:px-margin-desktop py-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      
      <!-- Left: Interactive Preferences (7 cols) -->
      <div class="lg:col-span-7 space-y-8">
        
        <!-- Question 1: Occasion & Environment -->
        <div class="bg-[#111218] p-6 md:p-8 rounded-3xl border border-white/10 shadow-2xl">
          <span class="text-[10px] font-mono text-[#e9c176] uppercase tracking-widest block mb-2 font-semibold">Step 01 · Wardrobe Occasion</span>
          <h3 class="font-serif text-lg text-white font-bold mb-4">Where will you showcase this piece?</h3>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="occasionSelector">
            <button type="button" onclick="setStylistOption('occasion', 'alpine', this)" class="stylist-btn active p-4 rounded-2xl border-2 border-[#e9c176] bg-[#e9c176]/10 text-left transition-all cursor-pointer">
              <span class="block text-xs font-bold text-white">Autumn Alpine &amp; Travel</span>
              <span class="block text-[10px] text-white/60 mt-0.5 font-mono">700 GSM Mongolian Cashmere Coat</span>
            </button>

            <button type="button" onclick="setStylistOption('occasion', 'gala', this)" class="stylist-btn p-4 rounded-2xl border border-white/15 bg-white/5 text-left hover:border-[#e9c176]/50 transition-all cursor-pointer">
              <span class="block text-xs font-bold text-white">Haute Couture Soirée &amp; Gala</span>
              <span class="block text-[10px] text-white/60 mt-0.5 font-mono">22-Momme Mulberry Silk Bias Gown</span>
            </button>

            <button type="button" onclick="setStylistOption('occasion', 'boardroom', this)" class="stylist-btn p-4 rounded-2xl border border-white/15 bg-white/5 text-left hover:border-[#e9c176]/50 transition-all cursor-pointer">
              <span class="block text-xs font-bold text-white">Executive Boardroom &amp; Suiting</span>
              <span class="block text-[10px] text-white/60 mt-0.5 font-mono">Super 150s Italian Virgin Wool</span>
            </button>

            <button type="button" onclick="setStylistOption('occasion', 'metropolitan', this)" class="stylist-btn p-4 rounded-2xl border border-white/15 bg-white/5 text-left hover:border-[#e9c176]/50 transition-all cursor-pointer">
              <span class="block text-xs font-bold text-white">Metropolitan Weekend &amp; Gallery</span>
              <span class="block text-[10px] text-white/60 mt-0.5 font-mono">14.5oz Okayama Selvedge Denim</span>
            </button>
          </div>
        </div>

        <!-- Question 2: Colorway & Textile Finish -->
        <div class="bg-[#111218] p-6 md:p-8 rounded-3xl border border-white/10 shadow-2xl">
          <span class="text-[10px] font-mono text-[#e9c176] uppercase tracking-widest block mb-2 font-semibold">Step 02 · Signature Palette</span>
          <h3 class="font-serif text-lg text-white font-bold mb-4">Preferred Textile Shade</h3>
          
          <div class="grid grid-cols-3 gap-3" id="fitSelector">
            <button type="button" onclick="setStylistOption('fit', 'camel', this)" class="stylist-btn active p-3.5 rounded-xl border-2 border-[#e9c176] bg-[#e9c176]/10 text-center transition-all cursor-pointer">
              <span class="block text-xs font-bold text-white">Camel Cashmere</span>
              <span class="block text-[10px] text-white/50 mt-0.5 font-mono">Warm Golden</span>
            </button>

            <button type="button" onclick="setStylistOption('fit', 'obsidian', this)" class="stylist-btn p-3.5 rounded-xl border border-white/15 bg-white/5 text-center hover:border-[#e9c176]/50 transition-all cursor-pointer">
              <span class="block text-xs font-bold text-white">Onyx Noir</span>
              <span class="block text-[10px] text-white/50 mt-0.5 font-mono">Stealth Black</span>
            </button>

            <button type="button" onclick="setStylistOption('fit', 'indigo', this)" class="stylist-btn p-3.5 rounded-xl border border-white/15 bg-white/5 text-center hover:border-[#e9c176]/50 transition-all cursor-pointer">
              <span class="block text-xs font-bold text-white">Natural Indigo</span>
              <span class="block text-[10px] text-white/50 mt-0.5 font-mono">Okayama Vat</span>
            </button>
          </div>
        </div>

        <!-- AI Query Box -->
        <div class="bg-[#111218] p-6 md:p-8 rounded-3xl border border-white/10 shadow-2xl">
          <span class="text-[10px] font-mono text-[#e9c176] uppercase tracking-widest block mb-2 font-semibold">Live AI Concierge</span>
          <h3 class="font-serif text-lg text-white font-bold mb-3">Ask Any Styling, Cut, or Fabric Question</h3>
          
          <div class="flex gap-2">
            <input type="text" id="stylistInput" placeholder="e.g. How to layer the 700 GSM Cashmere Coat over a silk dress?"
                   class="flex-1 px-4 py-3.5 bg-black/60 border border-white/20 rounded-xl text-xs text-white placeholder-white/40 focus:border-[#e9c176] focus:outline-none"/>
            <button onclick="askLiveStylist()" class="px-6 py-3.5 bg-gradient-to-r from-amber-400 to-[#e9c176] text-black text-xs font-bold font-button uppercase tracking-wider rounded-xl flex items-center gap-1.5 hover:from-amber-300 hover:to-[#e9c176] transition-all cursor-pointer">
              <span class="material-symbols-outlined text-sm">send</span>
              <span>Consult</span>
            </button>
          </div>

          <div id="stylistLiveResponse" class="mt-4 text-xs text-white/90 bg-white/5 p-4 rounded-xl border border-white/10 hidden leading-relaxed font-light"></div>
        </div>

      </div>

      <!-- Right: AI Recommendation Card (5 cols) -->
      <div class="lg:col-span-5">
        <div class="sticky top-[100px] bg-[#111218] p-6 md:p-8 rounded-3xl border border-[#e9c176]/40 shadow-2xl space-y-6">
          <div class="flex items-center gap-2 text-xs font-mono text-[#e9c176] uppercase tracking-widest">
            <span class="w-2 h-2 rounded-full bg-[#e9c176] animate-ping"></span>
            <span>Atelier Curated Piece</span>
          </div>

          <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-black/60 relative">
            <img id="recommendationImg" src="<?= base_url('img/cashmere_cocoon_coat.jpg') ?>" class="w-full h-full object-cover" alt="Recommended Piece">
            <div class="absolute bottom-3 left-3 px-3 py-1 bg-black/80 rounded-full text-[10px] font-mono text-[#e9c176] border border-white/15">
              99.8% Sartorial Harmony
            </div>
          </div>

          <div>
            <h4 class="font-serif text-lg text-white font-bold mb-1" id="recommendationTitle">The Atelier Cashmere Cocoon Coat</h4>
            <p class="text-xs text-white/70 font-light leading-relaxed mb-4" id="recommendationDesc">
              Hand-cut from 700 GSM pure Mongolian cashmere with fluid drop shoulders, unlined double-faced construction, and water buffalo horn buttons.
            </p>
            <div class="flex items-center justify-between pt-3 border-t border-white/10">
              <span class="font-serif text-xl font-bold text-[#e9c176]" id="recommendationPrice">₹6,999</span>
              <a id="recommendationLink" href="<?= base_url('products/the-atelier-cashmere-cocoon-coat') ?>" class="px-5 py-2.5 bg-[#e9c176] hover:bg-amber-300 text-black font-button text-xs uppercase tracking-wider font-bold rounded-xl transition-all">
                Acquire Piece →
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>

  </section>

</main>

<script>
let currentOccasion = 'alpine';
let currentFit = 'camel';

function setStylistOption(type, val, btn) {
  const container = btn.parentElement;
  container.querySelectorAll('.stylist-btn').forEach(b => {
    b.className = 'stylist-btn p-4 rounded-2xl border border-white/15 bg-white/5 text-left hover:border-[#e9c176]/50 transition-all cursor-pointer';
  });
  btn.className = 'stylist-btn active p-4 rounded-2xl border-2 border-[#e9c176] bg-[#e9c176]/10 text-left transition-all cursor-pointer';

  if (type === 'occasion') currentOccasion = val;
  if (type === 'fit') currentFit = val;
  updateStylistRecommendation();
}

function updateStylistRecommendation() {
  const title = document.getElementById('recommendationTitle');
  const desc = document.getElementById('recommendationDesc');
  const img = document.getElementById('recommendationImg');
  const price = document.getElementById('recommendationPrice');
  const link = document.getElementById('recommendationLink');

  if (currentOccasion === 'gala') {
    title.textContent = '22-Momme Mulberry Silk Bias Slip Dress';
    desc.textContent = 'Certified 22-momme Mulberry silk with liquid bias drape and French seams for effortless contouring.';
    img.src = 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80';
    price.textContent = '₹5,699';
    link.href = '<?= base_url("collections#mulberry-silk") ?>';
  } else if (currentOccasion === 'boardroom') {
    title.textContent = 'Super 150s Double-Breasted Wool Blazer';
    desc.textContent = 'Woven in Biella, Italy with floating horsehair canvas that molds to your silhouette for bespoke structure.';
    img.src = 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80';
    price.textContent = '₹7,999';
    link.href = '<?= base_url("collections#tailored-suiting") ?>';
  } else if (currentOccasion === 'metropolitan') {
    title.textContent = 'Vintage Okayama 14.5oz Selvedge Trousers';
    desc.textContent = 'Shuttle-loomed in Okayama, Japan with natural indigo rope-dyeing and red-line selvedge ID.';
    img.src = 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80';
    price.textContent = '₹4,899';
    link.href = '<?= base_url("collections#okayama-denim") ?>';
  } else {
    title.textContent = 'The Atelier Cashmere Cocoon Coat';
    desc.textContent = 'Hand-cut from 700 GSM pure Mongolian cashmere with fluid drop shoulders and unlined double-faced craftsmanship.';
    img.src = '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';
    price.textContent = '₹6,999';
    link.href = '<?= base_url("products/the-atelier-cashmere-cocoon-coat") ?>';
  }
}

function askLiveStylist() {
  const input = document.getElementById('stylistInput');
  const res = document.getElementById('stylistLiveResponse');
  const q = input.value.trim();
  if (!q) return;

  res.classList.remove('hidden');
  res.innerHTML = '<span class="animate-pulse text-[#e9c176]">✦ Atelier AI analyzing garment silhouette, drape &amp; textile harmony...</span>';

  setTimeout(() => {
    res.innerHTML = '<strong>Atelier Stylist Insight:</strong> For "' + q + '", we recommend layering <em>The Atelier Cashmere Cocoon Coat</em> over our <em>22-Momme Mulberry Silk Dress</em> or pairing it with <em>Okayama 14.5oz Selvedge</em> for an architectural, understated luxury poise.';
  }, 750);
}
</script>
