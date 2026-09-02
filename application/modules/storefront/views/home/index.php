<style>
/* ── LUMINA Ultra-Luxury High-Fashion Design System ── */
:root {
  --lumina-gold: #a16207;
  --lumina-gold-light: #e9c176;
  --lumina-dark: #0a0b0e;
  --lumina-charcoal: #151619;
  --lumina-sand: #fafaf9;
  --lumina-glow: rgba(233, 193, 118, 0.15);
}

/* Studio Lighting Modes */
body.mode-golden-hour {
  --lumina-glow: rgba(233, 193, 118, 0.3);
  filter: sepia(0.06) saturate(1.08);
}
body.mode-midnight-noir {
  --lumina-glow: rgba(161, 98, 7, 0.2);
  filter: contrast(1.05) saturate(0.95);
}
body.mode-museum-daylight {
  --lumina-glow: rgba(255, 255, 255, 0.25);
  filter: brightness(1.02) contrast(0.98);
}

/* Custom Magnetic Morphing Cursor */
#customCursor {
  position: fixed;
  top: 0;
  left: 0;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: rgba(233, 193, 118, 0.35);
  border: 1.5px solid rgba(233, 193, 118, 0.85);
  pointer-events: none;
  z-index: 9999;
  transform: translate(-50%, -50%);
  transition: width 0.3s cubic-bezier(0.16, 1, 0.3, 1), height 0.3s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s ease, border-radius 0.3s ease, transform 0.1s ease-out;
  display: none;
  align-items: center;
  justify-content: center;
  color: #000;
  font-family: 'Montserrat', sans-serif;
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  overflow: hidden;
  box-shadow: 0 0 20px rgba(233, 193, 118, 0.25);
}
#customCursor.cursor-hover {
  width: 60px;
  height: 60px;
  background: rgba(233, 193, 118, 0.85);
  backdrop-filter: blur(4px);
}
#customCursor.cursor-zoom {
  width: 72px;
  height: 72px;
  background: rgba(255, 255, 255, 0.92);
  border-color: #a16207;
}
@media (pointer: fine) {
  #customCursor { display: flex; }
}

/* Scroll Progress Bar */
#scrollProgressBar {
  position: fixed;
  top: 0;
  left: 0;
  height: 3px;
  background: linear-gradient(90deg, #a16207, #e9c176, #ffffff);
  z-index: 9998;
  width: 0%;
  transition: width 0.1s linear;
}

/* 3D Multi-Plane Parallax Layers */
.parallax-layer {
  will-change: transform;
  transform: translate3d(0, 0, 0);
}

.perspective-1200 {
  perspective: 1200px;
  transform-style: preserve-3d;
}

/* Continuous 3D Floating & Levitation Keyframes */
@keyframes float3D {
  0%, 100% {
    transform: perspective(1000px) translateY(0px) rotateX(0deg) rotateY(0deg);
  }
  25% {
    transform: perspective(1000px) translateY(-8px) rotateX(3deg) rotateY(-2deg);
  }
  50% {
    transform: perspective(1000px) translateY(-14px) rotateX(0deg) rotateY(3deg);
  }
  75% {
    transform: perspective(1000px) translateY(-6px) rotateX(-2deg) rotateY(-1deg);
  }
}

@keyframes floatGentle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-8px); }
}

@keyframes hologramGlow {
  0%, 100% {
    filter: drop-shadow(0 0 15px rgba(233, 193, 118, 0.25)) drop-shadow(0 20px 30px rgba(0,0,0,0.5));
  }
  50% {
    filter: drop-shadow(0 0 30px rgba(233, 193, 118, 0.55)) drop-shadow(0 25px 45px rgba(0,0,0,0.7));
  }
}

.animate-float-3d {
  animation: float3D 6s ease-in-out infinite;
}

.animate-float-gentle {
  animation: floatGentle 4s ease-in-out infinite;
}

.animate-hologram {
  animation: hologramGlow 4s ease-in-out infinite;
}

/* 3D Perspective Tilt & Specular Reflection */
.tilt-card, .store-product-card, .ensemble-item-card, .loyalty-tier-card, .category-3d-item {
  transform-style: preserve-3d;
  transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
  will-change: transform, box-shadow;
  position: relative;
}

.tilt-glare {
  position: absolute;
  inset: 0;
  pointer-events: none;
  border-radius: inherit;
  background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.18), transparent 70%);
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 15;
}

.tilt-card:hover .tilt-glare,
.store-product-card:hover .tilt-glare,
.loyalty-tier-card:hover .tilt-glare {
  opacity: 1;
}

/* Scroll-Driven Smooth Section Reveals */
.scroll-unfold-section {
  transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
  opacity: 0.85;
  transform: perspective(1200px) rotateX(4deg) translateY(20px) scale(0.98);
  will-change: opacity, transform;
}
.scroll-unfold-section.in-view {
  opacity: 1 !important;
  transform: perspective(1200px) rotateX(0deg) translateY(0) scale(1) !important;
}
@media (max-width: 767px) {
  .scroll-unfold-section {
    opacity: 1 !important;
    transform: none !important;
  }
  body {
    background-color: #0a0b0e !important;
  }
}

/* Floating 3D Ambient Orbs */
.ambient-glow-orb {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
  filter: blur(90px);
  will-change: transform;
  opacity: 0.55;
}

/* Kinetic Filmstrip Horizontal Track */
.filmstrip-track {
  display: flex;
  gap: 20px;
  will-change: transform;
}

/* Macro Fabric Zoom Loupe */
.zoom-loupe-target {
  position: relative;
  overflow: hidden;
}
.zoom-loupe-target img {
  transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
  will-change: transform;
}
.zoom-loupe-target:hover img {
  transform: scale(1.12);
}

/* Split-Screen Slider */
.split-container {
  position: relative;
  overflow: hidden;
  user-select: none;
}
.split-after {
  position: absolute;
  top: 0;
  left: 0;
  width: 50%;
  height: 100%;
  overflow: hidden;
}
.split-divider {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 50%;
  width: 2.5px;
  background: linear-gradient(180deg, transparent, #e9c176, #ffffff, #e9c176, transparent);
  box-shadow: 0 0 20px rgba(233, 193, 118, 0.6);
  cursor: ew-resize;
  z-index: 25;
}
.split-handle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: #000000;
  border: 2px solid #e9c176;
  color: #e9c176;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 0 25px rgba(233, 193, 118, 0.5), 0 10px 30px rgba(0,0,0,0.8);
}

/* Radar Hotspots */
.hotspot-radar {
  position: absolute;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  box-shadow: 0 8px 32px rgba(0,0,0,0.35);
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: 30;
}
.hotspot-radar::before {
  content: '';
  position: absolute;
  inset: -8px;
  border-radius: 50%;
  border: 1.5px solid rgba(233, 193, 118, 0.8);
  animation: radar-pulse 2.2s cubic-bezier(0.25, 1, 0.5, 1) infinite;
}
@keyframes radar-pulse {
  0% { transform: scale(0.6); opacity: 1; }
  100% { transform: scale(1.8); opacity: 0; }
}
.hotspot-radar:hover {
  transform: scale(1.3);
  background: var(--lumina-gold-light);
}

/* Framer Motion Tiles */
.motion-tile-item {
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  cursor: pointer;
  padding: 8px 0;
  display: inline-block;
  user-select: none;
}
.motion-tile-item.active {
  color: #ffffff;
  transform: translateX(8px);
}
.motion-tile-item.inactive {
  color: #78716c;
}
.motion-tile-item:hover {
  color: #e9c176;
}
.motion-stage-visual {
  transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
  will-change: opacity, transform;
}

/* Audio Equalizer Bars */
.eq-bar {
  width: 2.5px;
  background: #e9c176;
  border-radius: 1px;
  animation: eq-bounce 1.2s ease-in-out infinite alternate;
}
@keyframes eq-bounce {
  0% { height: 4px; }
  100% { height: 16px; }
}

/* ══ POWER CONVERSION ENGINE STYLES ══ */

/* Exit Intent Popup */
#exitIntentOverlay {
  position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(12px);
  z-index: 9000; display: none; align-items: center; justify-content: center; padding: 1rem;
}
#exitIntentOverlay.show { display: flex; animation: fadeInOverlay 0.35s ease; }
@keyframes fadeInOverlay { from { opacity:0; } to { opacity:1; } }
#exitIntentBox {
  background: linear-gradient(135deg, #0d0e12, #161820);
  border: 1px solid rgba(233,193,118,0.4);
  border-radius: 20px;
  max-width: 520px; width: 100%;
  position: relative;
  box-shadow: 0 40px 100px rgba(0,0,0,0.8), 0 0 60px rgba(233,193,118,0.1);
  animation: slideUpBox 0.4s cubic-bezier(0.16,1,0.3,1);
  overflow: hidden;
}
@keyframes slideUpBox { from { transform: translateY(60px) scale(0.96); opacity:0; } to { transform: translateY(0) scale(1); opacity:1; } }

/* Social Proof Toast Stack */
#socialProofFeed {
  position: fixed; bottom: 85px; left: 20px; z-index: 45;
  display: flex; flex-direction: column-reverse; gap: 8px;
  pointer-events: none; max-width: 280px;
  transition: all 0.3s ease;
}
.sp-toast {
  background: rgba(10,11,14,0.96); backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,0.12);
  border-left: 3px solid #e9c176;
  border-radius: 12px; padding: 10px 14px;
  display: flex; align-items: center; gap: 10px;
  pointer-events: none;
  animation: spSlideIn 0.4s cubic-bezier(0.16,1,0.3,1);
  box-shadow: 0 12px 36px rgba(0,0,0,0.6);
}
@keyframes spSlideIn { from { transform: translateX(-100%) scale(0.95); opacity:0; } to { transform: translateX(0) scale(1); opacity:1; } }
@keyframes spSlideOut { from { transform: translateX(0) scale(1); opacity:1; } to { transform: translateX(-120%) scale(0.95); opacity:0; } }
.sp-toast.removing { animation: spSlideOut 0.3s ease forwards; }


body.sticky-active #socialProofFeed {
  bottom: 84px !important;
}

/* Last Chance Deal section glow */
@keyframes dealPulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(233,193,118,0.4), 0 0 60px rgba(233,193,118,0.1); }
  50% { box-shadow: 0 0 0 12px rgba(233,193,118,0), 0 0 80px rgba(233,193,118,0.2); }
}
.deal-card-glow { animation: dealPulse 2.5s ease-in-out infinite; }

/* Animated Stats Counter */
@keyframes countUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.stat-counter { animation: countUp 0.6s ease forwards; opacity: 0; }

/* Trust Bar */
.trust-logo-item {
  transition: all 0.3s ease;
  filter: brightness(0.5);
}
.trust-logo-item:hover { filter: brightness(1); transform: scale(1.1); }

/* Marquee Animation */
@keyframes marqueeLeft {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.marquee-track { animation: marqueeLeft 28s linear infinite; }
.marquee-track:hover { animation-play-state: paused; }

/* WhatsApp Pulse Button */
@keyframes whatsappPulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(37,211,102,0.5); }
  70% { box-shadow: 0 0 0 16px rgba(37,211,102,0); }
}
#whatsappBtn { animation: whatsappPulse 2s ease infinite; }

/* Price Drop Flash */
@keyframes priceDrop {
  0% { background: rgba(233,193,118,0); }
  30% { background: rgba(233,193,118,0.3); }
  100% { background: rgba(233,193,118,0); }
}
.price-flash { animation: priceDrop 0.8s ease; }

/* Shimmer Loading Effect */
@keyframes shimmer {
  0% { background-position: -1000px 0; }
  100% { background-position: 1000px 0; }
}

/* Scroll-triggered number counter */
.counter-value { transition: all 0.3s ease; }

/* Coupon reveal animation */
@keyframes couponReveal {
  from { clip-path: inset(0 100% 0 0); }
  to { clip-path: inset(0 0% 0 0); }
}
.coupon-reveal { animation: couponReveal 0.8s cubic-bezier(0.16,1,0.3,1) forwards; }

/* Glow text */
.text-glow-gold {
  text-shadow: 0 0 20px rgba(233,193,118,0.5), 0 0 40px rgba(233,193,118,0.2);
}

/* Scarcity Progress Bar */
.scarcity-bar {
  background: linear-gradient(90deg, #ef4444, #f59e0b, #10b981);
  height: 6px; border-radius: 3px;
  transition: width 1s cubic-bezier(0.16,1,0.3,1);
}

/* VIP Member Badge */
@keyframes vipShine {
  0% { background-position: -200% center; }
  100% { background-position: 200% center; }
}
.vip-badge {
  background: linear-gradient(90deg, #a16207, #e9c176, #fbbf24, #e9c176, #a16207);
  background-size: 200% auto;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: vipShine 3s linear infinite;
}

</style>

<!-- Top Fine Luxury Scroll Progress Line -->
<div id="scrollProgressBar"></div>

<!-- ══════════════════════════════════════════════════════════════
     VIP ATELIER PRIVILEGE & SCROLL OFFER POPUP (LIVE CONVERSION)
══════════════════════════════════════════════════════════════ -->
<div id="exitIntentOverlay" class="fixed inset-0 bg-black/80 backdrop-blur-xl z-[130] hidden items-center justify-center p-3 sm:p-4 transition-all duration-300 opacity-0 pointer-events-none" onclick="if(event.target===this)closeExitPopup()" role="dialog" aria-modal="true" data-lenis-prevent="true" style="overscroll-behavior: contain;">
  <div id="exitIntentBox" class="bg-stone-950 text-white rounded-3xl max-w-lg w-full overflow-hidden border border-[#e9c176]/50 shadow-[0_25px_60px_rgba(0,0,0,0.8)] relative transform scale-95 transition-all duration-300" data-lenis-prevent="true" style="overscroll-behavior: contain;">
    
    <!-- Top Ambient Gold Light Aura & Header -->
    <div class="h-1.5 w-full bg-gradient-to-r from-amber-600 via-[#e9c176] to-amber-400"></div>
    <div class="absolute w-72 h-72 rounded-full bg-amber-500/15 blur-[80px] -top-16 -right-16 pointer-events-none"></div>

    <!-- Close Button -->
    <button type="button" onclick="closeExitPopup()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer absolute top-4 right-4 z-10 active:scale-95" aria-label="Close">
      <span class="material-symbols-outlined text-lg">close</span>
    </button>

    <div class="p-6 sm:p-8 relative z-10">
      
      <!-- Top VIP Badge & Live Countdown Timer -->
      <div class="flex items-center justify-between gap-2 mb-4">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-[#a16207]/30 to-[#e9c176]/20 border border-[#e9c176]/50 text-[#e9c176] text-[10px] font-mono uppercase tracking-widest font-bold">
          <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176] animate-ping"></span>
          <span>✦ VIP Privilege Unlocked ✦</span>
        </div>
        <div class="flex items-center gap-1 text-[11px] font-mono text-white/80 bg-white/5 border border-white/10 px-2.5 py-1 rounded-full">
          <span class="material-symbols-outlined text-xs text-amber-400 animate-pulse">timer</span>
          <span id="exitCountdown" class="font-bold text-amber-300">09:59</span>
        </div>
      </div>

      <!-- Headline -->
      <h2 class="text-2xl sm:text-3xl font-serif text-white mb-2 leading-tight font-bold">
        Unlock 50% Off <span class="italic text-[#e9c176] font-normal">Your First Piece.</span>
      </h2>
      <p class="text-xs sm:text-sm text-white/70 mb-5 leading-relaxed font-light">
        Welcome to the private atelier. Claim your exclusive welcome privilege and enjoy complimentary white-glove express delivery.
      </p>

      <!-- Primary Coupon Box with 1-Tap Copy -->
      <div class="p-3.5 bg-gradient-to-r from-[#e9c176]/15 via-amber-500/10 to-transparent border border-[#e9c176]/60 rounded-2xl flex items-center justify-between gap-3 mb-4 shadow-inner">
        <div>
          <span class="text-[9px] font-mono uppercase tracking-wider text-amber-300 block font-bold">VIP Promo Code:</span>
          <span class="text-[#e9c176] font-mono font-bold text-xl tracking-widest">LUMINA50</span>
        </div>
        <button type="button" onclick="claimOfferCoupon('LUMINA50', 50, 'percent')" class="bg-gradient-to-r from-amber-400 to-[#e9c176] hover:opacity-95 text-stone-950 font-mono text-xs uppercase tracking-wider px-4 py-2.5 rounded-xl font-extrabold shadow-md active:scale-95 transition-all cursor-pointer flex items-center gap-1.5 flex-shrink-0">
          <span class="material-symbols-outlined text-sm">content_copy</span>
          <span>Claim 50%</span>
        </button>
      </div>

      <!-- Secondary Offers Strip -->
      <div class="grid grid-cols-2 gap-2 mb-5">
        <div class="p-2.5 bg-white/5 border border-white/10 rounded-xl flex items-center justify-between cursor-pointer hover:border-[#e9c176]/40 transition-colors" onclick="claimOfferCoupon('FREESHIP', 0, 'shipping')">
          <div>
            <span class="text-[9px] font-mono text-white/50 uppercase block">Code: FREESHIP</span>
            <span class="text-xs font-bold text-white">Free Express Delivery</span>
          </div>
          <span class="text-[10px] font-mono text-[#e9c176] font-bold">Claim →</span>
        </div>
        <div class="p-2.5 bg-white/5 border border-white/10 rounded-xl flex items-center justify-between cursor-pointer hover:border-[#e9c176]/40 transition-colors" onclick="claimOfferCoupon('STAY500', 500, 'flat')">
          <div>
            <span class="text-[9px] font-mono text-white/50 uppercase block">Code: STAY500</span>
            <span class="text-xs font-bold text-white">₹500 Instant Off</span>
          </div>
          <span class="text-[10px] font-mono text-[#e9c176] font-bold">Claim →</span>
        </div>
      </div>

      <!-- Provenance Highlights -->
      <div class="grid grid-cols-2 gap-2 mb-6 text-[11px] font-mono text-white/70">
        <div class="flex items-center gap-1.5"><span class="material-symbols-outlined text-xs text-emerald-400">local_shipping</span> BlueDart Priority Express</div>
        <div class="flex items-center gap-1.5"><span class="material-symbols-outlined text-xs text-[#e9c176]">verified</span> 14-Day Doorstep Guarantee</div>
      </div>

      <!-- Action CTA Buttons -->
      <div class="flex flex-col sm:flex-row gap-2.5">
        <button type="button" onclick="claimOfferCoupon('LUMINA50', 50, 'percent'); if(typeof toggleQuickBagDrawer==='function')toggleQuickBagDrawer();" class="flex-1 py-3.5 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 text-stone-950 font-mono text-xs uppercase tracking-wider font-extrabold text-center rounded-xl hover:opacity-95 transition-all shadow-xl active:scale-95 cursor-pointer flex items-center justify-center gap-1.5">
          <span class="material-symbols-outlined text-sm">shopping_bag</span>
          <span>Apply 50% &amp; View Bag ⚡</span>
        </button>
        <button type="button" onclick="closeExitPopup()" class="px-5 py-3.5 border border-white/15 text-white/60 text-xs font-mono rounded-xl hover:border-white/30 hover:text-white transition-all cursor-pointer text-center">
          Later
        </button>
      </div>

    </div>
  </div>
</div>








<!-- ── Mobile Editorial Story Reel (Flawless Round Geometry & Luxury Ring) ── -->
<div class="md:hidden w-full bg-white border-b border-stone-200/90 py-3.5 px-3 overflow-hidden relative z-30 shadow-xs">
  <div class="flex items-center gap-4 overflow-x-auto no-scrollbar py-1 px-1 scroll-smooth" style="scrollbar-width:none;-ms-overflow-style:none;">
    <?php 
      $story_list = !empty($round_categories) ? $round_categories : (!empty($collections) ? $collections : []);
      foreach ($story_list as $si):
        $si_img = !empty($si['image_url']) ? $si['image_url'] : (!empty($si['resolved_image']) ? $si['resolved_image'] : base_url('img/cashmere_cocoon_coat.jpg'));
        $si_tag = strtoupper(substr($si['slug'] ?? 'ATEL', 0, 4));
        $si_url = base_url('shop?collection=' . ($si['slug'] ?? ''));
        $si_title = $si['title'] ?? 'Capsule';
        // Clean single-word or short title
        if (stripos($si_title, 'outerwear') !== false || stripos($si_title, 'coat') !== false) $si_title = 'Outerwear';
        elseif (stripos($si_title, 'denim') !== false || stripos($si_title, 'okayama') !== false) $si_title = 'Selvedge';
        elseif (stripos($si_title, 'silk') !== false) $si_title = 'Silk';
        elseif (stripos($si_title, 'tailor') !== false || stripos($si_title, 'suit') !== false) $si_title = 'Tailored';
        elseif (stripos($si_title, 'knit') !== false || stripos($si_title, 'heavy') !== false) $si_title = 'Knitwear';
        elseif (stripos($si_title, 'trouser') !== false || stripos($si_title, 'pant') !== false) $si_title = 'Trousers';
        else $si_title = explode(' ', $si_title)[0];
    ?>
    <a href="<?= $si_url ?>" class="flex flex-col items-center gap-1.5 flex-shrink-0 group cursor-pointer" style="width: 66px;">
      <!-- Perfectly Round Circular Story Frame -->
      <div class="relative w-14 h-14 min-w-[56px] min-h-[56px] rounded-full p-[2px] bg-gradient-to-tr from-amber-400 via-[#e9c176] to-amber-600 shadow-[0_0_10px_rgba(233,193,118,0.3)] transition-transform group-active:scale-95 duration-200">
        <div class="w-full h-full rounded-full overflow-hidden bg-stone-950 p-[1px] aspect-square flex items-center justify-center">
          <img src="<?= $si_img ?>" alt="<?= htmlspecialchars($si['title']) ?>" class="w-full h-full object-cover rounded-full aspect-square group-hover:scale-115 transition-transform duration-500" loading="lazy" onerror="this.src='<?= base_url('img/cashmere_cocoon_coat.jpg') ?>'">
        </div>
        <!-- Micro Tag Badge -->
        <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 bg-[#a16207] text-white text-[7.5px] font-mono font-bold px-1.5 py-0.2 rounded-full uppercase tracking-wider shadow-sm whitespace-nowrap">
          <?= $si_tag ?>
        </span>
      </div>
      <span class="text-[10px] font-mono uppercase tracking-wider text-stone-900 font-bold truncate w-full text-center">
        <?= htmlspecialchars($si_title) ?>
      </span>
    </a>
    <?php endforeach; ?>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     1. SCROLL STEP 01: HYPNOTIC RUNWAY LOOKBOOK HERO
══════════════════════════════════════════════════════ -->
<section class="relative min-h-0 sm:min-h-[85vh] md:min-h-[94vh] flex items-center justify-center overflow-hidden bg-[#0a0b0d] text-white scroll-unfold-section in-view pt-5 pb-10 md:py-20" id="chapter1" data-chapter="01 / 05 · The Capsule">
  <div class="absolute inset-0 z-0 overflow-hidden">
    <div id="heroZoomBg" class="absolute -inset-10 bg-cover bg-center transition-transform duration-300 ease-out opacity-35 filter saturate-[0.9] scale-110" 
         style="background-image: url('<?= htmlspecialchars($home_settings['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920&q=85') ?>');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0b0d] via-[#0a0b0d]/70 to-[#0a0b0d]/40"></div>
    <div class="absolute w-[500px] h-[500px] rounded-full bg-amber-500/10 blur-[100px] top-1/4 left-1/3 pointer-events-none"></div>
  </div>

  <!-- 3D Interactive Particle Constellation Canvas (Desktop Only for Clean Mobile Look) -->
  <canvas id="heroConstellationCanvas" class="hidden md:block absolute inset-0 z-10 pointer-events-none w-full h-full opacity-60"></canvas>

  <div class="max-w-container-max mx-auto px-4 sm:px-6 md:px-margin-desktop w-full relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-gutter items-center">
      
      <!-- Editorial Header Text -->
      <div class="lg:col-span-7 flex flex-col items-start">
        <?php
          $hs = $home_settings ?? [];
          $_hero_label    = htmlspecialchars($hs['hero_label'] ?? 'Exclusive VIP Release · Live Catalog');
          $_hero_headline = $hs['hero_headline'] ?? 'Form Without Compromise.';
          $_hero_body     = htmlspecialchars($hs['hero_body'] ?? 'An architectural study in pure double-faced Mongolian cashmere, 14.5oz Okayama selvedge denim, and bespoke Italian tailoring.');
          $_hero_cta      = htmlspecialchars($hs['hero_cta_text'] ?? 'Explore Boutique');
          
          // Cleanly split headline into main line and golden italic accent (WITHOUT repeating the word)
          $clean_headline = trim(rtrim($_hero_headline, '.'));
          $hl_words = explode(' ', $clean_headline);
          if (count($hl_words) > 1) {
            $hl_italic = array_pop($hl_words) . '.';
            $hl_main   = implode(' ', $hl_words);
          } else {
            $hl_main   = $clean_headline;
            $hl_italic = 'Atelier.';
          }
        ?>
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full mb-2.5 sm:mb-4 border border-[#e9c176]/40 shadow-xs">
          <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176] animate-ping"></span>
          <span class="font-mono text-[9px] sm:text-[10px] uppercase tracking-[0.2em] text-[#e9c176] font-extrabold"><?= $_hero_label ?></span>
        </div>

        <h1 class="font-serif text-3xl sm:text-5xl md:text-6xl text-white mb-2 sm:mb-4 font-light leading-[1.08] tracking-tight">
          <?= htmlspecialchars($hl_main) ?> <span class="font-serif italic font-normal text-[#e9c176]"><?= htmlspecialchars($hl_italic) ?></span>
        </h1>

        <p class="text-white/75 max-w-lg mb-3 sm:mb-5 leading-relaxed font-light text-xs sm:text-base">
          <?= $_hero_body ?>
        </p>

        <!-- Compact Material Pills -->
        <div class="flex items-center gap-2 mb-4 sm:mb-6 overflow-x-auto no-scrollbar py-0.5 max-w-full">
          <button onclick="switchHeroTextile('cashmere', this)" class="hero-swatch-btn active px-3 py-1 rounded-full bg-[#e9c176] text-stone-950 text-[10px] font-mono font-bold uppercase tracking-wider transition-all shadow-md flex items-center gap-1.5 cursor-pointer flex-shrink-0">
            <span class="w-1.5 h-1.5 rounded-full bg-stone-950"></span>
            <span>700 GSM Cashmere</span>
          </button>
          <button onclick="switchHeroTextile('denim', this)" class="hero-swatch-btn px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 text-white/80 text-[10px] font-mono uppercase tracking-wider transition-all flex items-center gap-1.5 cursor-pointer flex-shrink-0">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
            <span>Okayama Denim</span>
          </button>
          <button onclick="switchHeroTextile('silk', this)" class="hero-swatch-btn px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 text-white/80 text-[10px] font-mono uppercase tracking-wider transition-all flex items-center gap-1.5 cursor-pointer flex-shrink-0">
            <span class="w-1.5 h-1.5 rounded-full bg-rose-300"></span>
            <span>Mulberry Silk</span>
          </button>
        </div>

        <!-- High-Impact Action CTAs -->
        <div class="flex items-center gap-2.5 sm:gap-4 w-full sm:w-auto mb-3.5 sm:mb-5">
          <?php
            $_cta_url = !empty($hs['hero_cta_url']) ? base_url(ltrim($hs['hero_cta_url'],'/')) : base_url('shop');
          ?>
          <a href="<?= $_cta_url ?>" data-cursor="EXPLORE" class="flex-1 sm:flex-initial bg-white hover:bg-stone-100 text-stone-950 px-6 sm:px-8 py-3 sm:py-3.5 font-mono text-xs uppercase tracking-[0.14em] font-extrabold transition-all duration-300 shadow-xl flex items-center justify-center gap-2 group cursor-pointer text-center rounded-xl active:scale-95">
            <span><?= $_hero_cta ?></span>
            <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
          </a>
          <button onclick="openStylistModal()" data-cursor="STYLIST" class="flex-1 sm:flex-initial bg-stone-950/80 backdrop-blur-md text-white border border-[#e9c176]/50 hover:border-[#e9c176] px-5 sm:px-7 py-3 sm:py-3.5 font-mono text-xs uppercase tracking-[0.14em] font-bold transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer text-center rounded-xl shadow-lg active:scale-95">
            <span class="material-symbols-outlined text-[#e9c176] text-base">auto_awesome</span>
            <span>AI Stylist</span>
          </button>
        </div>

        <!-- Sleek Single-Line Micro Provenance Ticker -->
        <div class="flex items-center flex-wrap gap-x-3 gap-y-1 text-[10px] sm:text-xs text-white/70 font-mono tracking-wide pt-2 border-t border-white/10 w-full">
          <span class="flex items-center gap-1.5"><span class="text-[#e9c176]">✦</span> Certified Atelier Purity</span>
          <span class="text-white/20 hidden sm:inline">·</span>
          <span class="flex items-center gap-1.5"><span class="text-[#e9c176]">✦</span> 14-Day Doorstep Returns</span>
          <span class="text-white/20 hidden sm:inline">·</span>
          <span class="flex items-center gap-1.5"><span class="text-emerald-400">✦</span> Priority BlueDart Express</span>
        </div>
      </div>

      <!-- 3D Magnetic Tilt Holographic Flash Launch & Product Offer Showcase (Connected to Database) -->
      <?php 
        $hero_p = !empty($featured[0]) ? $featured[0] : [
          'id' => 1,
          'title' => 'The Atelier Cashmere Cocoon Coat',
          'base_price' => 4999,
          'compare_at_price' => 8999,
          'slug' => 'the-atelier-cashmere-cocoon-coat',
          'primary_image' => base_url('img/cashmere_cocoon_coat.jpg'),
          'vendor' => 'Lumina Atelier Milano'
        ];
        $hero_img = !empty($hero_p['primary_image']) ? $hero_p['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
        $regular_price = !empty($hero_p['compare_at_price']) && $hero_p['compare_at_price'] > $hero_p['base_price'] ? (float)$hero_p['compare_at_price'] : 8999.00;
        $hero_price = (float)$hero_p['base_price'];
        $discount_pct = round((($regular_price - $hero_price) / $regular_price) * 100);
        $save_amount = $regular_price - $hero_price;
      ?>
      <div class="lg:col-span-5 relative mt-8 sm:mt-10 lg:mt-0 perspective-1000 w-full max-w-sm sm:max-w-md mx-auto">
        <div class="tilt-card relative aspect-[3/4] w-full rounded-2xl overflow-hidden ambient-elevation border border-[#e9c176]/40 shadow-[0_20px_60px_rgba(0,0,0,0.9)] bg-gradient-to-b from-stone-900 via-stone-950 to-black group cursor-pointer" id="heroTiltCard" data-cursor="VIP DEAL" onclick="window.location.href='<?= base_url('products/' . $hero_p['slug']) ?>'">
          
          <!-- Top Floating Flash Sale Ribbon -->
          <div class="absolute top-3 sm:top-4 left-3 sm:left-4 right-3 sm:right-4 z-30 flex items-center justify-between pointer-events-none gap-1">
            <div class="flex items-center gap-1 px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded-full bg-gradient-to-r from-amber-500 via-[#e9c176] to-amber-300 text-stone-950 font-extrabold text-[9px] sm:text-[10px] uppercase tracking-wider sm:tracking-widest shadow-2xl border border-amber-200/50 animate-pulse truncate">
              <span class="material-symbols-outlined text-xs">local_fire_department</span>
              <span class="truncate"><?= $discount_pct ?>% OFF · VIP FLASH</span>
            </div>
            
            <div class="liquid-glass-dark px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full border border-[#e9c176]/30 text-[#e9c176] font-mono text-[9px] sm:text-[10px] flex items-center gap-1 flex-shrink-0">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
              <span>✦ ATELIER LAUNCH</span>
            </div>
          </div>

          <!-- Product Image with 3D Depth Lighting & Floating Zoom -->
          <div class="relative w-full h-full p-4 flex items-center justify-center overflow-hidden">
            <!-- Background Radial Glow -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_45%,rgba(233,193,118,0.25),transparent_70%)] pointer-events-none"></div>
            
            <img id="heroModelImage" src="<?= htmlspecialchars($hero_img) ?>" alt="<?= htmlspecialchars($hero_p['title']) ?>" class="w-full h-full object-cover rounded-xl drop-shadow-[0_25px_45px_rgba(0,0,0,0.9)] transition-transform duration-700 group-hover:scale-108"/>
          </div>

          <!-- Floating Engineering Spec Badge 1 -->
          <div class="absolute top-16 sm:top-20 left-3 sm:left-4 liquid-glass-dark px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-xl border border-[#e9c176]/30 text-[9px] sm:text-[10px] text-white flex items-center gap-1.5 shadow-2xl backdrop-blur-md">
            <span class="material-symbols-outlined text-xs text-[#e9c176]">verified</span>
            <span>100% Cashmere</span>
          </div>

          <!-- Floating Spec Badge 2 -->
          <div class="absolute top-28 sm:top-36 right-3 sm:right-4 liquid-glass-dark px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-xl border border-white/20 text-[9px] sm:text-[10px] text-white flex items-center gap-1.5 shadow-2xl backdrop-blur-md">
            <span class="material-symbols-outlined text-xs text-emerald-400">local_shipping</span>
            <span>18h Dispatch</span>
          </div>

          <!-- Bottom Master Offer Bar (Glassmorphic Luxury Gold) -->
          <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 liquid-glass-dark p-3.5 sm:p-5 rounded-xl border border-[#e9c176]/40 text-white z-20 shadow-2xl backdrop-blur-xl bg-black/80">
            <div class="flex items-center justify-between mb-1.5">
              <span class="text-[9px] sm:text-[10px] font-mono text-[#e9c176] uppercase tracking-wider flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                <span>VIP: <strong class="text-stone-950 bg-[#e9c176] px-1 py-0.5 rounded font-bold">LUMINA50</strong></span>
              </span>
              <span class="text-[9px] sm:text-[10px] text-emerald-400 font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">verified</span>
                <span>Signature Piece</span>
              </span>
            </div>
            
            <h4 class="font-serif text-sm sm:text-base text-white font-bold leading-tight mb-2 truncate" id="heroGarmentTitle">
              <?= htmlspecialchars($hero_p['title']) ?>
            </h4>

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5 pt-2 border-t border-white/15">
              <div class="w-full sm:w-auto flex items-center justify-between sm:block">
                <div class="flex items-baseline gap-1.5 sm:gap-2">
                  <span class="font-bold text-lg sm:text-xl text-[#e9c176] font-serif" id="heroGarmentPrice" data-price-inr="<?= $hero_price ?>">₹<?= number_format($hero_price, 0) ?></span>
                  <span class="text-xs text-white/50 line-through" data-price-inr="<?= $regular_price ?>">₹<?= number_format($regular_price, 0) ?></span>
                  <span class="text-[9px] sm:text-[10px] font-bold text-amber-300 bg-amber-500/20 px-1 py-0.5 rounded border border-amber-500/30"><?= $discount_pct ?>%</span>
                </div>
                <?php $hero_pts = !empty($hero_p['reward_points']) ? (int)$hero_p['reward_points'] : max(1, round($hero_price * 0.06)); ?>
                <div class="flex items-center gap-2 mt-0.5">
                  <span class="text-[10px] sm:text-[11px] text-emerald-400 font-bold block">Save <span data-price-inr="<?= $save_amount ?>">₹<?= number_format($save_amount, 0) ?></span></span>
                  <span class="text-[9.5px] font-mono text-amber-300 bg-amber-500/20 px-2 py-0.5 rounded border border-amber-500/30 flex items-center gap-1" title="Earn <?= number_format($hero_pts) ?> Atelier Points">
                    <span>🪙 +<?= number_format($hero_pts) ?> pts</span>
                    <span class="text-white/70 font-light">(₹<?= number_format($hero_pts) ?>)</span>
                  </span>
                </div>
              </div>
              
              <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button onclick="event.stopPropagation(); openAtelierFitModal({id: <?= $hero_p['id'] ?>, title: '<?= addslashes($hero_p['title']) ?>', price: <?= $hero_price ?>, compare_price: <?= $regular_price ?>, image: '<?= htmlspecialchars($hero_img) ?>', vendor: '<?= addslashes($hero_p['vendor'] ?? 'Lumina Atelier') ?>', category: 'coat'});" class="p-2 sm:px-3.5 sm:py-2.5 bg-white/10 hover:bg-white/20 text-white font-button text-[11px] uppercase tracking-wider rounded-lg transition-all flex items-center justify-center cursor-pointer" title="Acquire">
                  <span class="material-symbols-outlined text-sm">shopping_bag</span>
                </button>
                <button onclick="event.stopPropagation(); openExpressCheckout(<?= $hero_p['id'] ?>, '<?= addslashes($hero_p['title']) ?>', <?= $hero_price ?>, '<?= htmlspecialchars($hero_img) ?>', <?= $hero_p['id'] ?>);" class="flex-1 sm:flex-initial px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-[#e9c176] via-amber-300 to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button text-[10px] sm:text-[11px] uppercase tracking-wider font-extrabold rounded-lg transition-all shadow-[0_0_20px_rgba(233,193,118,0.4)] flex items-center justify-center gap-1.5 cursor-pointer">
                  <span class="material-symbols-outlined text-sm">bolt</span>
                  <span>Instant Buy</span>
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- Luxury Textile Ticker (Continuous Infinite Marquee) -->
  <div class="absolute bottom-0 left-0 right-0 py-3 bg-black/80 backdrop-blur-lg border-t border-white/10 z-20 overflow-hidden">
    <div class="marquee-track flex items-center gap-12 whitespace-nowrap text-white/75 text-xs font-label-caps uppercase tracking-[0.2em]" style="width: max-content;">
      <span>✦ 100% Double-Faced Cashmere</span>
      <span>✦ 13.5oz Okayama Selvedge Denim</span>
      <span>✦ 22-Momme Grade 6A Mulberry Silk</span>
      <span>✦ 480GSM Heavyweight French Terry</span>
      <span>✦ Hand-Crafted In Generational Ateliers</span>
      <span>✦ Complimentary Express Insured Delivery</span>
      <!-- Seamless loop duplicate -->
      <span>✦ 100% Double-Faced Cashmere</span>
      <span>✦ 13.5oz Okayama Selvedge Denim</span>
      <span>✦ 22-Momme Grade 6A Mulberry Silk</span>
      <span>✦ 480GSM Heavyweight French Terry</span>
      <span>✦ Hand-Crafted In Generational Ateliers</span>
      <span>✦ Complimentary Express Insured Delivery</span>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     F0. MYNTRA / FLIPKART STYLE ROUND CATEGORY STRIP (3D MAGNETIC & CORONA RING)
══════════════════════════════════════════════════════ -->
<?php if (!empty($round_categories) && count($round_categories) >= 3): ?>
<section class="w-full bg-white border-y border-stone-200 py-7 overflow-hidden relative z-20 select-none">
  <!-- Subtle Ambient Gold Flare Behind Strip -->
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_50%,rgba(233,193,118,0.08),transparent)] pointer-events-none"></div>

  <div class="max-w-7xl mx-auto px-4 md:px-8 relative z-10">
    <div class="flex items-center justify-between mb-4 px-1">
      <div class="flex items-center gap-2.5">
        <span class="relative flex h-2.5 w-2.5">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#a16207] opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#a16207]"></span>
        </span>
        <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#a16207] font-mono">Curated Atelier Archives</span>
      </div>
      <div class="flex items-center gap-3">
        <!-- Scroll navigation arrows for desktop -->
        <div class="hidden sm:flex items-center gap-1.5">
          <button onclick="scrollCategoryStrip(-240)" class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 border border-stone-200 text-stone-900 flex items-center justify-center text-xs transition-all hover:scale-110 active:scale-95 cursor-pointer" aria-label="Scroll Left">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
          </button>
          <button onclick="scrollCategoryStrip(240)" class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 border border-stone-200 text-stone-900 flex items-center justify-center text-xs transition-all hover:scale-110 active:scale-95 cursor-pointer" aria-label="Scroll Right">
            <span class="material-symbols-outlined text-sm">chevron_right</span>
          </button>
        </div>
        <a href="<?= base_url('shop') ?>" class="text-xs text-stone-700 hover:text-stone-950 font-semibold transition-colors flex items-center gap-1 group">
          <span>Explore All</span>
          <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
        </a>
      </div>
    </div>
    
    <!-- 3D Magnetic Horizontal Scrollable Circles -->
    <div id="categoryStripScroll" class="flex items-center gap-6 md:gap-9 overflow-x-auto no-scrollbar py-3 px-2 scroll-smooth" style="scrollbar-width:none;-ms-overflow-style:none;">
      <?php foreach ($round_categories as $rc): 
          $cat_img = !empty($rc['resolved_image']) ? $rc['resolved_image'] : 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=300&q=80';
      ?>
      <a href="<?= base_url('shop?collection=' . urlencode($rc['slug'])) ?>" class="category-3d-item flex flex-col items-center group flex-shrink-0 cursor-pointer text-center relative" style="width: 104px;" data-cursor="EXPLORE">
        
        <!-- 3D Perspective Wrapper -->
        <div class="category-3d-circle relative w-20 h-20 md:w-24 md:h-24 rounded-full p-[3px] transition-all duration-300 ease-out" style="transform-style: preserve-3d; perspective: 600px;">
          
          <!-- Outer Rotating Golden Corona Ring -->
          <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-600 opacity-40 group-hover:opacity-100 blur-[3px] group-hover:blur-[6px] transition-all duration-500 group-hover:animate-[spin_4s_linear_infinite]"></div>

          <!-- Metallic Inner Border -->
          <div class="relative w-full h-full rounded-full p-[2px] bg-gradient-to-tr from-amber-500/60 via-yellow-200 to-amber-600/60 group-hover:from-amber-300 group-hover:to-yellow-100 transition-all duration-300 shadow-md">
            <div class="w-full h-full rounded-full overflow-hidden bg-stone-100 relative">
              <img src="<?= htmlspecialchars($cat_img) ?>" alt="<?= htmlspecialchars($rc['title']) ?>" class="w-full h-full object-cover group-hover:scale-120 transition-transform duration-700 ease-out" loading="lazy">
              <!-- Specular Light Glare on Hover -->
              <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
            </div>
          </div>

          <!-- Mini Glowing Floating Indicator Pill -->
          <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 rounded-full bg-[#a16207] border border-white shadow-[0_0_8px_#e9c176] opacity-0 group-hover:opacity-100 group-hover:scale-125 transition-all duration-300"></div>
        </div>

        <span class="text-xs font-semibold text-stone-900 group-hover:text-[#a16207] mt-3 line-clamp-1 transition-colors tracking-tight font-sans">
          <?= htmlspecialchars($rc['title']) ?>
        </span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════
     F3. "SHOP BY PRICE" QUICK FILTER CHIPS (MULTI-CURRENCY AWARE)
══════════════════════════════════════════════════════ -->
<div class="w-full bg-[#0a0b0e] border-y border-white/10 py-4 px-4 overflow-x-auto no-scrollbar">
  <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-2.5 sm:gap-3 text-xs">
    <div class="flex items-center gap-1.5 text-white/50 uppercase tracking-widest text-[10px] font-bold mr-2">
      <span class="material-symbols-outlined text-sm text-[#e9c176]">tune</span>
      <span>Quick Budget:</span>
    </div>
    <a href="<?= base_url('shop?price_max=499') ?>" class="group px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 hover:border-[#e9c176]/60 text-white font-medium transition-all duration-300 hover:scale-105 shadow-sm flex items-center gap-1">
      <span>Under</span>
      <span class="font-serif font-bold text-[#e9c176]" data-price-inr="499">₹499</span>
    </a>
    <a href="<?= base_url('shop?price_min=500&price_max=999') ?>" class="group px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 hover:border-[#e9c176]/60 text-white font-medium transition-all duration-300 hover:scale-105 shadow-sm flex items-center gap-1">
      <span class="font-serif font-bold text-[#e9c176]" data-price-inr="500">₹500</span>
      <span class="text-white/60">–</span>
      <span class="font-serif font-bold text-[#e9c176]" data-price-inr="999">₹999</span>
    </a>
    <a href="<?= base_url('shop?price_min=1000&price_max=2499') ?>" class="group px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 hover:border-[#e9c176]/60 text-white font-medium transition-all duration-300 hover:scale-105 shadow-sm flex items-center gap-1">
      <span class="font-serif font-bold text-[#e9c176]" data-price-inr="1000">₹1,000</span>
      <span class="text-white/60">–</span>
      <span class="font-serif font-bold text-[#e9c176]" data-price-inr="2499">₹2,499</span>
    </a>
    <a href="<?= base_url('shop?price_min=2500') ?>" class="group px-5 py-2 rounded-full bg-gradient-to-r from-amber-500/20 via-[#e9c176]/30 to-amber-500/20 hover:from-amber-500/40 hover:to-[#e9c176]/40 border border-[#e9c176]/60 text-[#e9c176] font-bold transition-all duration-300 hover:scale-105 shadow-md flex items-center gap-1.5">
      <span class="material-symbols-outlined text-xs text-[#e9c176]">workspace_premium</span>
      <span><span data-price-inr="2500">₹2,500</span>+ Luxury Tier</span>
    </a>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     2. SCROLL STEP 02: KINETIC VELOCITY RUNWAY FILMSTRIP
══════════════════════════════════════════════════════ -->
<section class="py-12 md:py-16 bg-white text-stone-900 overflow-hidden scroll-unfold-section border-b border-stone-200" id="chapter2" data-chapter="02 / 05 · Kinetic Runway">
  <div class="max-w-container-max mx-auto px-4 sm:px-6 md:px-margin-desktop mb-6 sm:mb-8 flex justify-between items-end">
    <div>
      <span class="font-label-caps text-[10px] sm:text-xs text-[#a16207] uppercase tracking-[0.25em] block mb-1 font-semibold">Couture In Motion</span>
      <h2 class="font-headline-md text-2xl sm:text-3xl font-serif text-stone-900">The Runway Filmstrip</h2>
    </div>
    <span class="text-xs text-stone-500 font-light hidden md:block">Scroll accelerates velocity reel</span>
  </div>

  <div class="w-full overflow-hidden py-2 sm:py-4">
    <div class="filmstrip-track" id="filmstripReel">
      <?php foreach (array_slice($featured, 0, 6) as $idx => $fp): 
          $f_img = !empty($fp['primary_image']) ? $fp['primary_image'] : 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=800&q=85';
          $f_num = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
      ?>
      <div class="w-[260px] sm:w-[340px] md:w-[380px] flex-shrink-0 aspect-[3/4] relative rounded-xl overflow-hidden ambient-elevation border border-stone-200 group cursor-pointer" data-cursor="VIEW PIECE" onclick="window.location.href='<?= base_url('products/' . $fp['slug']) ?>'">
        <img src="<?= htmlspecialchars($f_img) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="<?= htmlspecialchars($fp['title']) ?>">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
        <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 flex justify-between items-end">
          <div class="max-w-[70%]">
            <span class="text-[9px] sm:text-[10px] font-mono text-[#e9c176] block mb-0.5"><?= $f_num ?>. <?= htmlspecialchars($fp['vendor'] ?? 'NovaDrop Studio') ?></span>
            <h4 class="font-serif text-xs sm:text-sm text-white font-bold leading-tight truncate"><?= htmlspecialchars($fp['title']) ?></h4>
          </div>
          <span class="text-[11px] sm:text-xs font-bold text-white bg-white/10 px-2 py-1 rounded whitespace-nowrap" data-price-inr="<?= $fp['base_price'] ?>">₹<?= number_format($fp['base_price'], 0) ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


<!-- ══════════════════════════════════════════════════════
     3. SCROLL STEP 03: FRAMER MOTION TILES COMPONENT
══════════════════════════════════════════════════════ -->
<section class="py-12 md:py-stack-lg bg-[#0e0f12] text-white relative overflow-hidden scroll-unfold-section" id="framerMotionTilesSection" data-chapter="03 / 05 · Motion Tiles">
  <div class="max-w-container-max mx-auto px-4 sm:px-6 md:px-margin-desktop">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-gutter items-center min-h-[480px] md:min-h-[580px]">
      
      <!-- Left: Interactive Motion Kinetic Tile List -->
      <div class="lg:col-span-6 flex flex-col justify-center">
        <p class="font-label-caps text-[10px] sm:text-xs text-[#e9c176] uppercase tracking-[0.25em] mb-3 sm:mb-4">
          Everything you desire in one capsule, like:
        </p>
        
        <div class="flex flex-col gap-1 text-base sm:text-2xl md:text-3xl font-serif" id="motionTilesContainer">
          
          <div class="motion-tile-item active flex items-center gap-2 sm:gap-3 cursor-pointer" onmouseenter="activateMotionTile(0)" onclick="activateMotionTile(0)" data-cursor="SELECT">
            <span class="text-xs font-sans text-[#e9c176]">01.</span>
            <span>Double-Faced Mongolian Cashmere,</span>
          </div>

          <div class="motion-tile-item inactive flex items-center gap-2 sm:gap-3 cursor-pointer" onmouseenter="activateMotionTile(1)" onclick="activateMotionTile(1)" data-cursor="SELECT">
            <span class="text-xs font-sans text-stone-500">02.</span>
            <span>13.5oz Okayama Selvedge Denim,</span>
          </div>

          <div class="motion-tile-item inactive flex items-center gap-2 sm:gap-3 cursor-pointer" onmouseenter="activateMotionTile(2)" onclick="activateMotionTile(2)" data-cursor="SELECT">
            <span class="text-xs font-sans text-stone-500">03.</span>
            <span>480GSM Heavyweight French Terry,</span>
          </div>

          <div class="motion-tile-item inactive flex items-center gap-2 sm:gap-3 cursor-pointer" onmouseenter="activateMotionTile(3)" onclick="activateMotionTile(3)" data-cursor="SELECT">
            <span class="text-xs font-sans text-stone-500">04.</span>
            <span>22-Momme Sandwashed Mulberry Silk,</span>
          </div>

          <div class="motion-tile-item inactive flex items-center gap-2 sm:gap-3 cursor-pointer" onmouseenter="activateMotionTile(4)" onclick="activateMotionTile(4)" data-cursor="SELECT">
            <span class="text-xs font-sans text-stone-500">05.</span>
            <span>Super 150s Italian Wool Blazers,</span>
          </div>

          <div class="motion-tile-item inactive flex items-center gap-2 sm:gap-3 cursor-pointer" onmouseenter="activateMotionTile(5)" onclick="activateMotionTile(5)" data-cursor="SELECT">
            <span class="text-xs font-sans text-stone-500">06.</span>
            <span>Bespoke Tailored Silhouettes,</span>
          </div>

          <div class="motion-tile-item inactive flex items-center gap-2 sm:gap-3 cursor-pointer" onmouseenter="activateMotionTile(6)" onclick="activateMotionTile(6)" data-cursor="SELECT">
            <span class="text-xs font-sans text-stone-500">07.</span>
            <span class="italic text-[#e9c176]">And Hand-Numbered Editions.</span>
          </div>

        </div>

        <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-white/10 flex items-center gap-4">
          <a href="<?= base_url('shop') ?>" data-cursor="EXPLORE" class="inline-flex items-center gap-2 font-button text-xs uppercase tracking-[0.2em] text-[#e9c176] hover:underline cursor-pointer">
            <span>Explore All Atelier Creations</span>
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
          </a>
        </div>
      </div>

      <!-- Right: Spring-Animated Motion Visual Stage with Zoom On Hover -->
      <div class="lg:col-span-6 relative mt-6 lg:mt-0">
        <div class="zoom-loupe-target relative aspect-[4/3] rounded-xl overflow-hidden ambient-elevation border border-white/15 bg-stone-900 group cursor-pointer" data-cursor="ZOOM" onclick="openMacroViewer(document.getElementById('motionStageTitle').textContent, 'Tactile Macro Texture Inspection', document.getElementById('motionStageImage').src)">
          <img id="motionStageImage" src="<?= base_url('img/cashmere_cocoon_coat.jpg') ?>" alt="Motion Tile Artwork" class="w-full h-full object-cover motion-stage-visual"/>
          
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>

          <!-- Interactive Motion Stage Bottom Luxury Glass Bar -->
          <div class="absolute inset-x-3 sm:inset-x-5 bottom-3 sm:bottom-5 bg-stone-950/90 backdrop-blur-lg border border-white/20 rounded-2xl p-3.5 sm:p-4.5 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-2xl z-10">
            <div class="min-w-0 flex-1">
              <div class="flex items-center gap-2 mb-1">
                <span class="font-mono text-[9px] sm:text-[10px] uppercase tracking-widest text-[#e9c176] font-bold" id="motionStageTag">Category 01 · Outerwear</span>
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
              </div>
              <h3 class="font-serif text-sm sm:text-lg text-white font-bold truncate" id="motionStageTitle">The Atelier Cashmere Cocoon Coat</h3>
              <p class="text-[11px] sm:text-xs text-stone-300 font-light mt-0.5 line-clamp-1" id="motionStageDesc">100% Double-faced Mongolian cashmere with hand-stitched horn buttons.</p>
            </div>
            
            <!-- Right Controls: Size Selector Box & Acquire CTA -->
            <div class="flex items-center gap-2.5 flex-shrink-0 pt-2 md:pt-0 border-t border-white/10 md:border-t-0" onclick="event.stopPropagation()">
              <!-- Size Selector Box -->
              <div class="inline-flex items-center gap-2 bg-stone-900 border border-amber-400/80 hover:border-amber-400 rounded-xl px-3 py-2 shadow-inner transition-all">
                <span class="text-[9px] font-mono uppercase text-[#e9c176] font-extrabold tracking-wider">SIZE</span>
                <div class="relative flex items-center">
                  <select id="motionStageSizeSelect" onchange="window.selectedMotionStageSize = this.value" class="text-xs font-mono font-extrabold bg-transparent text-white cursor-pointer focus:outline-hidden pr-4 appearance-none leading-none py-0">
                    <option value="XS" class="bg-stone-900 text-white">XS</option>
                    <option value="S" class="bg-stone-900 text-white">S</option>
                    <option value="M" selected class="bg-stone-900 text-white">M</option>
                    <option value="L" class="bg-stone-900 text-white">L</option>
                    <option value="XL" class="bg-stone-900 text-white">XL</option>
                    <option value="XXL" class="bg-stone-900 text-white">XXL</option>
                  </select>
                  <span class="material-symbols-outlined text-xs text-[#e9c176] pointer-events-none absolute right-0">expand_more</span>
                </div>
              </div>

              <!-- Acquire Button -->
              <button id="motionStageBtn" onclick="event.stopPropagation(); acquireMotionStageGarment()" data-cursor="ACQUIRE" class="px-5 py-2.5 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button text-xs uppercase font-extrabold tracking-wider rounded-xl shadow-lg cursor-pointer flex items-center gap-1.5 active:scale-95 transition-all flex-shrink-0">
                <span class="material-symbols-outlined text-sm">shopping_bag</span>
                <span>Acquire +</span>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>




<?php if (!empty($home_settings['arrivals_section_enabled'] ?? 1)): ?>
<!-- ══════════════════════════════════════════════════════
     5. CURATED ATELIER MASTERPIECES (JUST ARRIVED IN THE ATELIER)
══════════════════════════════════════════════════════ -->
<section class="py-12 md:py-stack-lg bg-white text-stone-900 border-b border-stone-200 relative scroll-unfold-section" id="expressCapsules">
  <div class="max-w-container-max mx-auto px-4 sm:px-6 md:px-margin-desktop">
    
    <!-- Section Header & Filter Controls -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 sm:mb-8 border-b border-stone-200 pb-4 sm:pb-6 gap-3 sm:gap-4">
      <div>
        <div class="inline-flex items-center gap-2 bg-amber-50 px-3 py-1 rounded-full text-[9px] sm:text-[10px] font-label-caps uppercase tracking-widest text-[#a16207] mb-2 font-semibold border border-amber-200">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
          <span>Curated Atelier Masterpieces</span>
        </div>
        <h2 class="font-headline-md text-2xl sm:text-4xl text-stone-900 font-serif"><?= htmlspecialchars($home_settings['arrivals_section_title'] ?? 'Just Arrived in the Atelier') ?></h2>
        <p class="text-xs text-stone-600 font-light mt-1 max-w-md">
          <?= htmlspecialchars($home_settings['arrivals_section_subtitle'] ?? 'Explore signature silhouettes crafted from raw organic fibers and tailored in limited hand-numbered batches.') ?>
        </p>
      </div>

      <div class="flex items-center gap-3">
        <a href="<?= base_url('shop') ?>" class="inline-flex items-center gap-1.5 text-xs font-button uppercase tracking-wider text-[#a16207] font-semibold hover:underline">
          <span>View All Archives (<?= count($featured ?? []) ?>)</span>
          <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
      </div>
    </div>


    <!-- ── Interactive Storefront Category Filter Pills ── -->
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-4 sm:pb-6 mb-2">
      <button onclick="filterStorefrontCategory('all', this)" class="store-filter-tab active px-4 py-2 rounded-full text-xs font-mono font-bold uppercase tracking-wider transition-all cursor-pointer bg-stone-950 text-white shadow-md border border-stone-950">
        ✦ All Masterpieces (<?= count($featured ?? []) ?>)
      </button>
      <button onclick="filterStorefrontCategory('cashmere', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-stone-100 border border-stone-200 text-stone-700 hover:border-stone-400 hover:text-stone-950">
        Outerwear &amp; Cashmere
      </button>
      <button onclick="filterStorefrontCategory('denim', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-stone-100 border border-stone-200 text-stone-700 hover:border-stone-400 hover:text-stone-950">
        Okayama Denim
      </button>
      <button onclick="filterStorefrontCategory('terry', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-stone-100 border border-stone-200 text-stone-700 hover:border-stone-400 hover:text-stone-950">
        Heavyweight Essentials
      </button>
      <button onclick="filterStorefrontCategory('silk', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-stone-100 border border-stone-200 text-stone-700 hover:border-stone-400 hover:text-stone-950">
        Mulberry Silk
      </button>
      <button onclick="filterStorefrontCategory('suiting', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-stone-100 border border-stone-200 text-stone-700 hover:border-stone-400 hover:text-stone-950">
        Tailored Suiting
      </button>
    </div>

    <!-- 2-Column Mobile, 4-Column Desktop Product Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6" id="storefrontProductsGrid">
      <?php if (!empty($featured)): ?>
        <?php foreach ($featured as $idx => $prod): ?>
        <?php 
          $prod_img = !empty($prod['primary_image']) ? $prod['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
          $prod_price = (float)($prod['min_price'] ?? 4999);
          
          // Categorize product based on title for real-time filter tabs
          $title_lower = strtolower($prod['title']);
          $cat_tag = 'all';
          if (strpos($title_lower, 'coat') !== false || strpos($title_lower, 'cashmere') !== false || strpos($title_lower, 'jacket') !== false) {
            $cat_tag = 'cashmere';
          } elseif (strpos($title_lower, 'denim') !== false || strpos($title_lower, 'jean') !== false || strpos($title_lower, 'trouser') !== false) {
            $cat_tag = 'denim';
          } elseif (strpos($title_lower, 'terry') !== false || strpos($title_lower, 'hoodie') !== false || strpos($title_lower, 't-shirt') !== false || strpos($title_lower, 'tee') !== false) {
            $cat_tag = 'terry';
          } elseif (strpos($title_lower, 'silk') !== false || strpos($title_lower, 'shirt') !== false || strpos($title_lower, 'dress') !== false) {
            $cat_tag = 'silk';
          } else {
            $cat_tag = 'suiting';
          }
        ?>
        <div class="store-product-card group bg-white text-stone-900 rounded-xl sm:rounded-2xl border border-stone-200 hover:border-[#a16207]/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-sm hover:shadow-xl" data-category="<?= $cat_tag ?>">
          
          <!-- Image & Scarcity Badge -->
          <div class="relative aspect-[3/4] bg-stone-100 overflow-hidden cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $prod['slug']) ?>'">
            <img src="<?= htmlspecialchars($prod_img) ?>" alt="<?= htmlspecialchars($prod['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            
            <!-- Top Badges -->
            <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-col gap-1 z-10">
              <span class="text-[8px] sm:text-[9px] font-mono font-bold uppercase tracking-wider bg-black/80 backdrop-blur-md text-[#e9c176] px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full border border-white/10 flex items-center gap-1 shadow-md">
                <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176]"></span>
                <span>Atelier Cut</span>
              </span>
            </div>

            <!-- Quick Direct Actions -->
            <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex items-center gap-1 sm:gap-1.5 z-10" onclick="event.stopPropagation()">
              <div class="heart-container w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/80 hover:bg-black border border-white/20 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 flex items-center justify-center cursor-pointer" title="Save to Wardrobe">
                <input type="checkbox" class="checkbox" data-wishlist-id="<?= (int)$prod['id'] ?>" onchange="toggleWishlistItem({id:<?= (int)$prod['id'] ?>, title:'<?= addslashes(htmlspecialchars($prod['title'])) ?>', price:<?= $prod_price ?>, image:'<?= addslashes($prod_img) ?>'}, event)">
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
              <button onclick="openExpressCheckout(<?= $prod['id'] ?>, '<?= addslashes($prod['title']) ?>', <?= $prod_price ?>, '<?= htmlspecialchars($prod_img) ?>', <?= $prod['id'] ?>);" 
                 class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/90 hover:bg-black text-[#e9c176] flex items-center justify-center border border-white/20 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 cursor-pointer"
                 title="1-Click Instant Acquisition">
                <svg class="w-3.5 h-3.5 fill-current text-[#e9c176]" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
              </button>
            </div>

            <!-- Hover Quick View Chip -->
            <div class="absolute inset-x-3 bottom-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 hidden sm:block" onclick="event.stopPropagation()">
              <?php
                $qv_prod_data = [
                  'id' => (int)$prod['id'],
                  'title' => $prod['title'],
                  'price' => (float)$prod_price,
                  'compare_price' => 0,
                  'image' => $prod_img,
                  'vendor' => $prod['vendor'] ?? 'Lumina Atelier',
                  'description' => strip_tags($prod['short_description'] ?? 'Bespoke tailoring piece.')
                ];
              ?>
              <button type="button" 
                      data-quickview="<?= htmlspecialchars(json_encode($qv_prod_data), ENT_QUOTES, 'UTF-8') ?>"
                      onclick="openQuickView(this.dataset.quickview)" 
                      class="w-full py-2 bg-black/85 hover:bg-black text-[#e9c176] font-mono text-[9px] uppercase font-bold tracking-widest rounded-xl shadow-xl backdrop-blur-md flex items-center justify-center gap-1.5 border border-white/10 transition-all cursor-pointer">
                <span class="material-symbols-outlined text-xs text-[#e9c176]">visibility</span>
                <span>Atelier Quick View</span>
              </button>
            </div>
          </div>

          <!-- Product Details & Rapid In-Site Buy -->
          <div class="p-2.5 sm:p-5 flex flex-col justify-between flex-1 bg-white">
            <div>
              <div class="flex items-center justify-between gap-1 mb-1">
                <span class="text-[8px] sm:text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold truncate"><?= htmlspecialchars($prod['vendor'] ?? 'Atelier') ?></span>
                <?php if (!empty($prod['rating_avg']) && $prod['rating_avg'] > 0): ?>
                <span class="inline-flex items-center gap-0.5 text-[9px] sm:text-[10px] font-mono font-bold text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded-full border border-amber-200">
                  <span class="text-amber-500 text-[10px]">★</span> <?= number_format($prod['rating_avg'], 1) ?>
                </span>
                <?php endif; ?>
              </div>

              <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 mb-1 group-hover:text-[#a16207] transition-colors line-clamp-1">
                <a href="<?= base_url('products/' . $prod['slug']) ?>"><?= htmlspecialchars($prod['title']) ?></a>
              </h3>

              <div class="flex items-baseline justify-between gap-1 mb-1 sm:mb-1.5">
                <span class="font-serif font-bold text-xs sm:text-base text-stone-950" data-price-inr="<?= $prod_price ?>">₹<?= number_format($prod_price, 0) ?></span>
                <span class="hidden sm:flex text-[9px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-mono font-bold items-center gap-1 border border-emerald-200">
                  <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                  <span>Free Air</span>
                </span>
              </div>

              <!-- Points Earning Pill -->
              <?php $card_pts = !empty($prod['reward_points']) ? (int)$prod['reward_points'] : max(1, round($prod_price * 0.06)); ?>
              <div class="flex items-center justify-between gap-1 mb-2 sm:mb-3">
                <span class="inline-flex items-center gap-1 text-[9px] sm:text-[9.5px] font-mono font-bold text-amber-900 bg-[#fef3c7] border border-[#fde68a] px-1.5 sm:px-2 py-0.5 rounded-md" title="Earn <?= number_format($card_pts) ?> Atelier Reward Points on purchase">
                  <span>🪙</span>
                  <span>+<?= number_format($card_pts) ?> pts</span>
                  <span class="text-amber-800/70 font-normal">(₹<?= number_format($card_pts) ?>)</span>
                </span>
                <span class="text-[8px] sm:text-[8.5px] font-mono text-stone-400">1.5× for Gold</span>
              </div>
            </div>

            <!-- Direct In-Site Buy Action Buttons -->
            <div class="pt-2 sm:pt-3 border-t border-stone-100">
              <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                <?php
                  $acquire_prod_data = [
                    'id' => (int)$prod['id'],
                    'title' => $prod['title'],
                    'price' => (float)$prod_price,
                    'compare_price' => (float)($prod['compare_at_price'] ?? 0),
                    'reward_points' => $card_pts,
                    'image' => $prod_img,
                    'vendor' => $prod['vendor'] ?? 'Lumina Atelier Milano',
                    'category' => $cat_tag,
                    'description' => strip_tags($prod['short_description'] ?? 'Bespoke tailoring piece.')
                  ];
                ?>
                <button type="button" 
                        data-tooltip="Fit &amp; Sizing" 
                        data-product="<?= htmlspecialchars(json_encode($acquire_prod_data), ENT_QUOTES, 'UTF-8') ?>" 
                        onclick="openAtelierFitModal(this.dataset.product || this.getAttribute('data-product'))" 
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
                        data-tooltip="Instant: ₹<?= number_format($prod_price, 0) ?>" 
                        onclick="openExpressCheckout(<?= $prod['id'] ?>, '<?= addslashes($prod['title']) ?>', <?= $prod_price ?>, '<?= htmlspecialchars($prod_img) ?>', <?= $prod['id'] ?>);" 
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

        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════
     6. FRESH NEW ARRIVALS BOUTIQUE SHOWCASE
══════════════════════════════════════════════════════ -->
<?php if (!empty($new_arrivals)): ?>
<section class="py-16 bg-white text-stone-900 border-b border-stone-200 relative overflow-hidden">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 pb-4 border-b border-stone-200 gap-4">
      <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[#a16207] text-[10px] font-mono uppercase tracking-widest mb-2 font-semibold">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
          <span>Fresh Seasonal Drop · Limited Release</span>
        </div>
        <h2 class="font-headline-md text-3xl font-serif text-stone-900">Just Arrived in the Atelier</h2>
        <p class="text-xs text-stone-600 font-light mt-1 max-w-md">
          The latest numbered cuts and modern textiles, fresh from the tailor's workshop.
        </p>
      </div>

      <a href="<?= base_url('shop?sort=newest') ?>" class="inline-flex items-center gap-1.5 text-xs font-button uppercase tracking-wider text-[#a16207] font-semibold hover:underline">
        <span>Browse All New Arrivals</span>
        <span class="material-symbols-outlined text-sm">arrow_forward</span>
      </a>
    </div>

    <!-- 2-Column Mobile, 4-Column Desktop New Arrivals Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
      <?php foreach (array_slice($new_arrivals, 0, 4) as $idx => $nprod): ?>
      <?php 
        $n_img = !empty($nprod['primary_image']) ? $nprod['primary_image'] : base_url('img/cashmere_cocoon_coat.jpg');
        $n_price = (float)($nprod['min_price'] ?? 3999);
      ?>
      <div class="group bg-white text-stone-900 rounded-xl sm:rounded-2xl border border-stone-200 hover:border-[#a16207]/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-sm hover:shadow-xl">
        
        <div class="relative aspect-[3/4] bg-stone-100 overflow-hidden cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $nprod['slug']) ?>'">
          <img src="<?= htmlspecialchars($n_img) ?>" alt="<?= htmlspecialchars($nprod['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
          
          <!-- Top Scarcity Badge -->
          <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-col gap-1 z-10">
            <span class="text-[8px] sm:text-[9px] font-mono font-bold uppercase tracking-wider bg-black/80 backdrop-blur-md text-[#e9c176] px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full border border-white/10 flex items-center gap-1 shadow-md">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
              <span>New Drop</span>
            </span>
          </div>

          <!-- Top-Right Actions -->
          <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex items-center gap-1 sm:gap-1.5 z-10" onclick="event.stopPropagation()">
            <div class="heart-container w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/80 hover:bg-black border border-white/20 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 flex items-center justify-center cursor-pointer" title="Save to Wardrobe">
              <input type="checkbox" class="checkbox" data-wishlist-id="<?= (int)$nprod['id'] ?>" onchange="toggleWishlistItem({id:<?= (int)$nprod['id'] ?>, title:'<?= addslashes(htmlspecialchars($nprod['title'])) ?>', price:<?= $n_price ?>, image:'<?= addslashes($n_img) ?>'}, event)">
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
            <button onclick="openExpressCheckout(<?= $nprod['id'] ?>, '<?= addslashes($nprod['title']) ?>', <?= $n_price ?>, '<?= htmlspecialchars($n_img) ?>', <?= $nprod['id'] ?>);" 
               class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/90 hover:bg-black text-[#e9c176] flex items-center justify-center border border-white/20 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 cursor-pointer"
               title="1-Click Instant Acquisition">
              <svg class="w-3.5 h-3.5 fill-current text-[#e9c176]" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
            </button>
          </div>

          <!-- Hover Quick View Chip -->
          <div class="absolute inset-x-3 bottom-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 hidden sm:block" onclick="event.stopPropagation()">
            <?php
              $qv_nprod_data = [
                'id' => (int)$nprod['id'],
                'title' => $nprod['title'],
                'price' => (float)$n_price,
                'compare_price' => 0,
                'image' => $n_img,
                'vendor' => $nprod['vendor'] ?? 'Lumina Atelier',
                'description' => strip_tags($nprod['short_description'] ?? 'Bespoke tailoring piece.')
              ];
            ?>
            <button type="button" 
                    data-quickview="<?= htmlspecialchars(json_encode($qv_nprod_data), ENT_QUOTES, 'UTF-8') ?>"
                    onclick="openQuickView(this.dataset.quickview)" 
                    class="w-full py-2 bg-black/85 hover:bg-black text-[#e9c176] font-mono text-[9px] uppercase font-bold tracking-widest rounded-xl shadow-xl backdrop-blur-md flex items-center justify-center gap-1.5 border border-white/10 transition-all cursor-pointer">
              <span class="material-symbols-outlined text-xs text-[#e9c176]">visibility</span>
              <span>Atelier Quick View</span>
            </button>
          </div>
        </div>

        <div class="p-2.5 sm:p-5 flex flex-col justify-between flex-1 bg-white">
          <div>
            <div class="flex items-center justify-between gap-1 mb-1">
              <span class="text-[8px] sm:text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold truncate"><?= htmlspecialchars($nprod['vendor'] ?? 'Atelier') ?></span>
              <?php if (!empty($nprod['rating_avg']) && $nprod['rating_avg'] > 0): ?>
              <span class="inline-flex items-center gap-0.5 text-[9px] sm:text-[10px] font-mono font-bold text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded-full border border-amber-200">
                <span class="text-amber-500 text-[10px]">★</span> <?= number_format($nprod['rating_avg'], 1) ?>
              </span>
              <?php endif; ?>
            </div>

            <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 mb-1 group-hover:text-[#a16207] transition-colors line-clamp-1">
              <a href="<?= base_url('products/' . $nprod['slug']) ?>"><?= htmlspecialchars($nprod['title']) ?></a>
            </h3>

            <div class="flex items-baseline justify-between gap-1 mb-1 sm:mb-1.5">
              <span class="font-serif font-bold text-xs sm:text-base text-stone-950" data-price-inr="<?= $n_price ?>">₹<?= number_format($n_price, 0) ?></span>
              <span class="hidden sm:flex text-[9px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-mono font-bold items-center gap-1 border border-emerald-200">
                <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Free Air</span>
              </span>
            </div>

            <!-- Points Earning Pill -->
            <?php $ncard_pts = !empty($nprod['reward_points']) ? (int)$nprod['reward_points'] : max(1, round($n_price * 0.06)); ?>
            <div class="flex items-center justify-between gap-1 mb-2 sm:mb-3">
              <span class="inline-flex items-center gap-1 text-[9px] sm:text-[9.5px] font-mono font-bold text-amber-900 bg-[#fef3c7] border border-[#fde68a] px-1.5 sm:px-2 py-0.5 rounded-md" title="Earn <?= number_format($ncard_pts) ?> Atelier Reward Points on purchase">
                <span>🪙</span>
                <span>+<?= number_format($ncard_pts) ?> pts</span>
                <span class="text-amber-800/70 font-normal">(₹<?= number_format($ncard_pts) ?>)</span>
              </span>
              <span class="text-[8px] sm:text-[8.5px] font-mono text-stone-400">1.5× for Gold</span>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-stone-100">
            <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
              <?php
                $acquire_nprod_data = [
                  'id' => (int)$nprod['id'],
                  'title' => $nprod['title'],
                  'price' => (float)$n_price,
                  'compare_price' => (float)($nprod['compare_at_price'] ?? 0),
                  'reward_points' => $ncard_pts,
                  'image' => $n_img,
                  'vendor' => $nprod['vendor'] ?? 'Lumina Atelier Milano',
                  'category' => 'new',
                  'description' => strip_tags($nprod['short_description'] ?? 'Bespoke tailoring piece.')
                ];
              ?>
              <button type="button" 
                      data-tooltip="Fit &amp; Sizing" 
                      data-product="<?= htmlspecialchars(json_encode($acquire_nprod_data), ENT_QUOTES, 'UTF-8') ?>" 
                      onclick="openAtelierFitModal(this.dataset.product || this.getAttribute('data-product'))" 
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
                      data-tooltip="Instant: ₹<?= number_format($n_price, 0) ?>" 
                      onclick="openExpressCheckout(<?= $nprod['id'] ?>, '<?= addslashes($nprod['title']) ?>', <?= $n_price ?>, '<?= htmlspecialchars($n_img) ?>', <?= $nprod['id'] ?>);" 
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

      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
<?php endif; ?>





<!-- ══════════════════════════════════════════════════════
     8. INTERACTIVE MACRO FIBER INSPECTION LIGHTBOX
══════════════════════════════════════════════════════ -->
<div id="macroViewerModal" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[120] hidden items-center justify-center p-4 md:p-10" onclick="if(event.target===this)closeMacroViewer()">
  <div class="liquid-glass-dark p-6 md:p-8 rounded-DEFAULT max-w-4xl w-full ambient-elevation relative border border-white/20 flex flex-col gap-6 text-white max-h-[90vh]">
    <div class="flex justify-between items-start border-b border-white/10 pb-4">
      <div>
        <span class="font-label-caps text-xs text-[#e9c176] uppercase tracking-[0.2em] block mb-1">Macro Fiber Inspection (2.5x Optical)</span>
        <h3 class="font-headline-sm text-2xl text-white font-serif" id="macroModalTitle">The Atelier Cashmere Cocoon Coat</h3>
        <p class="text-xs text-white/70 font-light mt-0.5" id="macroModalDesc">18.5-Micron Organic Mongolian Cashmere Weave</p>
      </div>
      <button onclick="closeMacroViewer()" class="p-2 text-white/70 hover:text-white cursor-pointer" aria-label="Close Viewer">
        <span class="material-symbols-outlined text-2xl">close</span>
      </button>
    </div>

    <div class="relative w-full h-[400px] md:h-[480px] bg-black/60 rounded-DEFAULT overflow-hidden flex items-center justify-center cursor-grab" id="macroCanvasContainer">
      <img id="macroModalImg" src="" alt="Macro Texture" class="w-full h-full object-cover transition-transform duration-300 ease-out" style="transform: scale(1.6);"/>
      
      <div class="absolute bottom-4 right-4 liquid-glass-dark px-4 py-2 rounded-full border border-white/20 flex items-center gap-4 text-xs">
        <button onclick="zoomMacro(-0.3)" class="p-1 text-white hover:text-[#e9c176] cursor-pointer"><span class="material-symbols-outlined text-base">zoom_out</span></button>
        <span id="macroZoomLevel" class="font-mono">1.6x</span>
        <button onclick="zoomMacro(0.3)" class="p-1 text-white hover:text-[#e9c176] cursor-pointer"><span class="material-symbols-outlined text-base">zoom_in</span></button>
        <button onclick="resetMacroZoom()" class="p-1 text-white/70 hover:text-white cursor-pointer"><span class="material-symbols-outlined text-base">restart_alt</span></button>
      </div>
    </div>
  </div>
</div>


<!-- ══════════════════════════════════════════════════════
     9. AI ATELIER STYLIST CONCIERGE MODAL
══════════════════════════════════════════════════════ -->
<!-- ══════════════════════════════════════════════════════
     9. AI ATELIER STYLIST CONCIERGE MODAL (LIVE AI ENGINE)
══════════════════════════════════════════════════════ -->
<div id="aiStylistModal" class="fixed inset-0 bg-black/80 backdrop-blur-xl z-50 hidden items-center justify-center p-3 sm:p-4" onclick="if(event.target===this)closeStylistModal()" role="dialog" aria-modal="true">
  <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.4)] border border-stone-200/90 flex flex-col max-h-[85vh] sm:max-h-[88vh] animate-in fade-in zoom-in duration-200">
    
    <!-- Obsidian Top Banner -->
    <div class="bg-stone-950 text-white p-5 sm:p-6 border-b border-stone-800 flex justify-between items-center relative overflow-hidden flex-shrink-0">
      <div class="absolute w-48 h-48 rounded-full bg-amber-500/15 blur-[60px] -top-12 -right-12 pointer-events-none"></div>
      
      <div class="flex items-center gap-3 relative z-10">
        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-amber-400 to-[#e9c176] text-stone-950 flex items-center justify-center shadow-md">
          <span class="material-symbols-outlined text-xl">auto_awesome</span>
        </div>
        <div>
          <div class="flex items-center gap-2">
            <h3 class="font-serif text-lg font-bold text-white tracking-tight">LUMINA Stylist Concierge</h3>
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[9px] font-mono font-bold uppercase tracking-wider">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
              Live AI
            </span>
          </div>
          <p class="text-[11px] text-white/60 font-mono">Bespoke Fit, Drape, Fabric &amp; Capsule Advice</p>
        </div>
      </div>

      <button type="button" onclick="closeStylistModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center cursor-pointer transition-colors relative z-10 active:scale-95" aria-label="Close Concierge">
        <span class="material-symbols-outlined text-lg">close</span>
      </button>
    </div>

    <!-- Quick Suggestion Topic Chips -->
    <div class="px-5 py-3 bg-stone-50 border-b border-stone-200 flex-shrink-0">
      <span class="text-[10px] font-mono uppercase tracking-wider text-stone-500 block mb-2 font-bold">Curated Quick Consultations:</span>
      <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1" style="scrollbar-width:none;-ms-overflow-style:none;">
        <button type="button" onclick="askStylist('Curate an effortless autumn layering outfit with coat and selvedge denim')" class="px-3 py-1.5 bg-white hover:bg-stone-100 text-stone-800 border border-stone-200 text-[11px] font-mono rounded-xl shadow-2xs hover:border-stone-900 cursor-pointer transition-all flex-shrink-0 active:scale-95">
          🍂 Autumn Layering
        </button>
        <button type="button" onclick="askStylist('What sizes work best for a relaxed drop-shoulder aesthetic?')" class="px-3 py-1.5 bg-white hover:bg-stone-100 text-stone-800 border border-stone-200 text-[11px] font-mono rounded-xl shadow-2xs hover:border-stone-900 cursor-pointer transition-all flex-shrink-0 active:scale-95">
          📐 Drop-Shoulder Sizing
        </button>
        <button type="button" onclick="askStylist('Tell me about your Grade-A Mongolian cashmere quality and craftsmanship')" class="px-3 py-1.5 bg-white hover:bg-stone-100 text-stone-800 border border-stone-200 text-[11px] font-mono rounded-xl shadow-2xs hover:border-stone-900 cursor-pointer transition-all flex-shrink-0 active:scale-95">
          💎 Mongolian Cashmere
        </button>
        <button type="button" onclick="askStylist('What VIP discount coupons or promo offers are available right now?')" class="px-3 py-1.5 bg-white hover:bg-stone-100 text-stone-800 border border-stone-200 text-[11px] font-mono rounded-xl shadow-2xs hover:border-stone-900 cursor-pointer transition-all flex-shrink-0 active:scale-95">
          🏷️ VIP Coupons &amp; Offers
        </button>
        <button type="button" onclick="askStylist('How does complimentary BlueDart Priority Express courier transit work?')" class="px-3 py-1.5 bg-white hover:bg-stone-100 text-stone-800 border border-stone-200 text-[11px] font-mono rounded-xl shadow-2xs hover:border-stone-900 cursor-pointer transition-all flex-shrink-0 active:scale-95">
          🚀 Express Priority Shipping
        </button>
      </div>
    </div>

    <!-- Live Dynamic Chat Thread Stream -->
    <div id="stylistChatThread" class="p-5 overflow-y-auto space-y-4 flex-1 bg-[#fcfbf9] custom-scrollbar min-h-[220px]">
      
      <!-- Initial AI Welcome Greeting -->
      <div class="flex items-start gap-2.5">
        <div class="w-7 h-7 rounded-xl bg-stone-950 text-[#e9c176] flex items-center justify-center flex-shrink-0 text-xs shadow-xs font-bold">
          ✦
        </div>
        <div class="bg-white border border-stone-200 p-3.5 rounded-2xl rounded-tl-xs text-xs text-stone-800 shadow-2xs leading-relaxed max-w-[90%]">
          <p class="font-medium text-stone-950 mb-1">Welcome to LUMINA Haute Couture &amp; Ready-to-Wear Concierge.</p>
          <p class="text-stone-600">I am your bespoke AI stylist. Ask me anything about tailoring silhouettes, Mongolian cashmere drapes, fabric density, size matching, or seasonal wardrobe curation.</p>
        </div>
      </div>

    </div>

    <!-- Input Footer Bar -->
    <div class="p-3 sm:p-4 bg-white border-t border-stone-200 flex-shrink-0">
      <form onsubmit="event.preventDefault(); var p = document.getElementById('stylistPrompt'); askStylist(p.value); p.value='';" class="flex gap-2 items-center">
        <div class="relative flex-1">
          <input type="text" id="stylistPrompt" placeholder="Ask your personal stylist anything..." 
                 class="w-full pl-4 pr-4 py-3 bg-stone-50 border border-stone-300 rounded-xl text-xs font-sans text-stone-900 outline-none focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 transition-all shadow-2xs">
        </div>
        <button type="submit" id="stylistSubmitBtn" class="px-5 py-3 bg-stone-950 hover:bg-stone-850 text-white font-button text-xs uppercase tracking-wider font-extrabold rounded-xl shadow-md cursor-pointer active:scale-95 transition-all flex items-center gap-1.5 flex-shrink-0">
          <span>Ask</span>
          <span class="material-symbols-outlined text-sm text-[#e9c176]">send</span>
        </button>
      </form>
    </div>

  </div>
</div>




<script>
// ── Parallax Privilege Offer Claim & Toast Engine ──
function claimOffer(code, msg) {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(code).catch(() => {});
  }
  ndToast(msg + ' (Code: ' + code + ' copied to clipboard)', 'success');
  
  // Open quick bag drawer after brief delay
  setTimeout(() => {
    if (typeof toggleQuickBagDrawer === 'function') {
      toggleQuickBagDrawer();
    }
  }, 900);
}

// ── Live Privilege Countdown Timer Ticker ──
let countRemainingSeconds = (8 * 3600) + (42 * 60) + 19;
setInterval(() => {
  if (countRemainingSeconds <= 0) countRemainingSeconds = 12 * 3600;
  countRemainingSeconds--;
  
  const h = Math.floor(countRemainingSeconds / 3600);
  const m = Math.floor((countRemainingSeconds % 3600) / 60);
  const s = countRemainingSeconds % 60;
  
  const elH = document.getElementById('cHours');
  const elM = document.getElementById('cMins');
  const elS = document.getElementById('cSecs');
  
  if (elH) elH.textContent = String(h).padStart(2, '0');
  if (elM) elM.textContent = String(m).padStart(2, '0');
  if (elS) elS.textContent = String(s).padStart(2, '0');
}, 1000);

// ── Scroll Progress & Continuous Parallax Engine ──
window.addEventListener('scroll', () => {
  const scrollY = window.pageYOffset || document.documentElement.scrollTop;
  const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  const progress = (scrollY / docHeight) * 100;
  
  const bar = document.getElementById('scrollProgressBar');
  if (bar) bar.style.width = progress + '%';

  // Hero Zoom Parallax
  const heroBg = document.getElementById('heroZoomBg');
  if (heroBg && scrollY < 900) {
    const scale = Math.max(1.05, 1.25 - (scrollY * 0.00025));
    const translateY = scrollY * 0.35;
    heroBg.style.transform = `translateY(${translateY}px) scale(${scale})`;
  }

  // Privilege Section Parallax Background Scroll
  const offerBg = document.getElementById('offerParallaxBg');
  if (offerBg) {
    const offerSection = document.getElementById('chapter2');
    if (offerSection) {
      const rect = offerSection.getBoundingClientRect();
      const offset = (rect.top * -0.25);
      offerBg.style.transform = `translateY(${offset}px) scale(1.1)`;
    }
  }

  // Kinetic Filmstrip Velocity Reel
  const filmstrip = document.getElementById('filmstripReel');
  if (filmstrip) {
    const offset = Math.min(600, scrollY * 0.28);
    filmstrip.style.transform = `translateX(-${offset}px)`;
  }
}, { passive: true });

// ── Intersection Observer for Continuous Scroll Storyline ──
const chapterObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('in-view');
      const chap = entry.target.getAttribute('data-chapter');
      const hud = document.getElementById('scrollChapterHud');
      if (chap && hud) hud.textContent = chap;
    }
  });
}, { threshold: 0.25 });

document.querySelectorAll('.scroll-unfold-section').forEach(sec => chapterObserver.observe(sec));

// ── Web Audio API Atelier Soundscape Synthesizer ──
let audioCtx = null;
let isAudioPlaying = false;
let ambientGain = null;

function toggleAtelierSound() {
  if (!audioCtx) {
    audioCtx = new (window.AudioContext || window.webkitAudioContext)();
  }
  
  if (!isAudioPlaying) {
    if (audioCtx.state === 'suspended') audioCtx.resume();
    startSoundscape();
    document.getElementById('soundLabel').textContent = 'Ambience: On';
    document.getElementById('eqVisualizer').style.opacity = '1';
    isAudioPlaying = true;
    ndToast('Atelier Ambience soundscape activated.', 'success');
  } else {
    stopSoundscape();
    document.getElementById('soundLabel').textContent = 'Ambience: Off';
    document.getElementById('eqVisualizer').style.opacity = '0.3';
    isAudioPlaying = false;
    ndToast('Atelier Ambience paused.', 'success');
  }
}

function startSoundscape() {
  ambientGain = audioCtx.createGain();
  ambientGain.gain.setValueAtTime(0.04, audioCtx.currentTime);
  ambientGain.connect(audioCtx.destination);

  const osc1 = audioCtx.createOscillator();
  osc1.type = 'sine';
  osc1.frequency.setValueAtTime(110, audioCtx.currentTime);
  osc1.connect(ambientGain);
  osc1.start();

  const osc2 = audioCtx.createOscillator();
  osc2.type = 'sine';
  osc2.frequency.setValueAtTime(164.81, audioCtx.currentTime);
  osc2.connect(ambientGain);
  osc2.start();
}

function stopSoundscape() {
  if (ambientGain) {
    ambientGain.gain.setTargetAtTime(0, audioCtx.currentTime, 0.2);
  }
}

// ── Studio Lighting Mode Switcher ──
function setStudioLight(mode) {
  document.body.classList.remove('mode-golden-hour', 'mode-midnight-noir', 'mode-museum-daylight');
  document.body.classList.add('mode-' + mode);
  ndToast('Studio lighting adjusted to ' + mode.replace('-', ' ') + '.', 'success');
}

// ── Magnetic Morphing Cursor with Context Labels ──
const customCursor = document.getElementById('customCursor');
const cursorLabel = document.getElementById('cursorLabel');

if (customCursor) {
  window.addEventListener('mousemove', (e) => {
    customCursor.style.left = e.clientX + 'px';
    customCursor.style.top = e.clientY + 'px';
  });

  document.querySelectorAll('[data-cursor]').forEach(el => {
    el.addEventListener('mouseenter', () => {
      const text = el.getAttribute('data-cursor');
      if (text === 'ZOOM') {
        customCursor.classList.add('cursor-zoom');
        cursorLabel.textContent = 'ZOOM';
      } else {
        customCursor.classList.add('cursor-hover');
        cursorLabel.textContent = text || '';
      }
    });
    el.addEventListener('mouseleave', () => {
      customCursor.classList.remove('cursor-hover', 'cursor-zoom');
      cursorLabel.textContent = '';
    });
  });
}

// ── Macro Fiber Modal Controls ──
let currentMacroScale = 1.6;

function openMacroViewer(title, desc, imgSrc) {
  document.getElementById('macroModalTitle').textContent = title;
  document.getElementById('macroModalDesc').textContent = desc;
  document.getElementById('macroModalImg').src = imgSrc;
  currentMacroScale = 1.6;
  updateMacroImg();

  var m = document.getElementById('macroViewerModal');
  m.classList.remove('hidden');
  m.classList.add('flex');
}

function closeMacroViewer() {
  var m = document.getElementById('macroViewerModal');
  m.classList.add('hidden');
  m.classList.remove('flex');
}

function zoomMacro(delta) {
  currentMacroScale = Math.max(1.0, Math.min(3.5, currentMacroScale + delta));
  updateMacroImg();
}

function resetMacroZoom() {
  currentMacroScale = 1.6;
  updateMacroImg();
}

function updateMacroImg() {
  const img = document.getElementById('macroModalImg');
  if (img) img.style.transform = `scale(${currentMacroScale})`;
  const label = document.getElementById('macroZoomLevel');
  if (label) label.textContent = currentMacroScale.toFixed(1) + 'x';
}

// ── 3D Magnetic Perspective Tilt on Hero Card ──
const heroTiltCard = document.getElementById('heroTiltCard');
if (heroTiltCard) {
  heroTiltCard.addEventListener('mousemove', (e) => {
    const rect = heroTiltCard.getBoundingClientRect();
    const x = e.clientX - rect.left - rect.width / 2;
    const y = e.clientY - rect.top - rect.height / 2;
    const rotateX = -(y / rect.height) * 12;
    const rotateY = (x / rect.width) * 12;
    heroTiltCard.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
  });
  heroTiltCard.addEventListener('mouseleave', () => {
    heroTiltCard.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
  });
}

// ── Draggable Split-Screen Slider ──
const splitBox = document.getElementById('splitBox');
const splitAfterLayer = document.getElementById('splitAfterLayer');
const splitDivider = document.getElementById('splitDivider');

if (splitBox && splitAfterLayer && splitDivider) {
  let isDragging = false;
  const onMove = (clientX) => {
    const rect = splitBox.getBoundingClientRect();
    let pos = ((clientX - rect.left) / rect.width) * 100;
    pos = Math.max(10, Math.min(90, pos));
    splitAfterLayer.style.width = pos + '%';
    splitDivider.style.left = pos + '%';
  };

  splitBox.addEventListener('mousedown', () => isDragging = true);
  window.addEventListener('mouseup', () => isDragging = false);
  window.addEventListener('mousemove', (e) => { if (isDragging) onMove(e.clientX); });
  
  splitBox.addEventListener('touchstart', () => isDragging = true, { passive: true });
  window.addEventListener('touchend', () => isDragging = false);
  window.addEventListener('touchmove', (e) => { if (isDragging && e.touches[0]) onMove(e.touches[0].clientX); }, { passive: true });
}

// ── Framer Motion Tiles Engine ──
var activeMotionTileIndex = 0;

var motionTilesData = [
  {
    tag: "Category 01 · Outerwear",
    title: "The Atelier Cashmere Cocoon Coat",
    desc: "100% Double-faced Mongolian cashmere with hand-stitched horn buttons.",
    img: "<?= base_url('img/cashmere_cocoon_coat.jpg') ?>",
    id: 1,
    price: 4999
  },
  {
    tag: "Category 02 · Denim",
    title: "13.5oz Okayama Selvedge Trousers",
    desc: "Woven on vintage shuttle looms in Japan with custom brass hardware.",
    img: "https://images.unsplash.com/photo-1509631179647-0177331693ae?w=1000&q=85",
    id: 3,
    price: 4899
  },
  {
    tag: "Category 03 · Essentials",
    title: "Sculpted Heavyweight Terry Hoodie",
    desc: "480GSM organic cotton French terry with pre-shrunk density.",
    img: "https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=1000&q=85",
    id: 2,
    price: 3299
  },
  {
    tag: "Category 04 · Eveningwear",
    title: "Mulberry Silk Bias-Cut Slip Dress",
    desc: "22-Momme Grade 6A mulberry silk with sandwashed liquid drape.",
    img: "https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1000&q=85",
    id: 4,
    price: 5699
  },
  {
    tag: "Category 05 · Suiting",
    title: "Super 150s Italian Wool Blazer",
    desc: "Vitale Barberis Canonico virgin wool with floating horsehair canvas.",
    img: "https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1000&q=85",
    id: 5,
    price: 7999
  },
  {
    tag: "Category 06 · Tailoring",
    title: "Italian Pleated Wool Trousers",
    desc: "Unstructured drape designed for multi-seasonal layering.",
    img: "<?= base_url('img/italian_pleated_trousers.jpg') ?>",
    id: 7,
    price: 3999
  },
  {
    tag: "Category 07 · Limited Edition",
    title: "Hand-Numbered Atelier Capsule 08",
    desc: "Only 50 pieces crafted worldwide per seasonal release.",
    img: "https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1000&q=85",
    id: 8,
    price: 6499
  }
];

function activateMotionTile(index) {
  activeMotionTileIndex = index;
  var items = document.querySelectorAll('.motion-tile-item');
  items.forEach((el, idx) => {
    if (idx === index) {
      el.className = 'motion-tile-item active flex items-center gap-3';
      el.querySelector('span:first-child').className = 'text-xs font-sans text-[#e9c176]';
    } else {
      el.className = 'motion-tile-item inactive flex items-center gap-3';
      el.querySelector('span:first-child').className = 'text-xs font-sans text-stone-500';
    }
  });

  var data = motionTilesData[index];
  if (!data) return;

  var img = document.getElementById('motionStageImage');
  if (img) {
    img.style.opacity = '0.3';
    img.style.transform = 'scale(0.97)';

    setTimeout(() => {
      img.src = data.img;
      document.getElementById('motionStageTag').textContent = data.tag;
      document.getElementById('motionStageTitle').textContent = data.title;
      document.getElementById('motionStageDesc').textContent = data.desc;

      // Update sizes in the motion stage size select dropdown
      const sizeSelect = document.getElementById('motionStageSizeSelect');
      if (sizeSelect) {
        const sizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(data) : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        const defaultSize = sizes[Math.min(2, sizes.length - 1)];
        window.selectedMotionStageSize = defaultSize;
        sizeSelect.innerHTML = sizes.map(s => `<option value="${s}" ${s === defaultSize ? 'selected' : ''} class="bg-stone-900 text-white">${s}</option>`).join('');
      }

      img.style.opacity = '1';
      img.style.transform = 'scale(1)';
    }, 180);
  }
}

window.acquireMotionStageGarment = function() {
  var data = motionTilesData[activeMotionTileIndex || 0];
  if (!data) return;

  var sizeSelect = document.getElementById('motionStageSizeSelect');
  var chosenSize = (sizeSelect && sizeSelect.value) ? sizeSelect.value : (window.selectedMotionStageSize || 'M');

  // Add to cart with chosen category size!
  if (typeof addToCart === 'function') {
    addToCart({
      id: data.id || 1,
      variant_id: data.id || 1,
      product_id: data.id || 1,
      title: data.title,
      price: data.price || 4999,
      image: data.img,
      size: chosenSize,
      color: 'Original'
    }, 1, `✦ Added ${data.title} (Size ${chosenSize}) to Curated Bag!`);
  }

  // Open Quick Bag Drawer to show item and chosen size in cart!
  setTimeout(() => {
    if (typeof toggleQuickBagDrawer === 'function') {
      var overlay = document.getElementById('quickBagOverlay');
      if (overlay && overlay.classList.contains('hidden')) {
        toggleQuickBagDrawer();
      }
    }
  }, 250);
};

// ── Ensemble Builder Calculation ──
var ensembleItems = {
  1: { name: 'Cashmere Cocoon Coat', price: 4999 },
  2: { name: 'Okayama Selvedge Trousers', price: 4899 },
  3: { name: 'Pure Mulberry Silk Scarf', price: 1899 }
};

function selectEnsembleItem(step, name, price, cardEl) {
  cardEl.parentElement.querySelectorAll('.ensemble-item-card').forEach(c => {
    c.className = 'ensemble-item-card p-3 border border-outline-variant bg-surface rounded-DEFAULT cursor-pointer flex flex-col items-center text-center hover:border-primary transition-all duration-300';
  });
  cardEl.className = 'ensemble-item-card active p-3 border-2 border-accent bg-surface rounded-DEFAULT cursor-pointer flex flex-col items-center text-center transition-all duration-300';

  ensembleItems[step] = { name: name, price: price };
  document.getElementById('step' + step + 'SelectedTitle').textContent = name;
  document.getElementById('ensItem' + step + 'Name').textContent = name;
  document.getElementById('ensItem' + step + 'Price').textContent = '₹' + price.toLocaleString('en-IN');

  var standardTotal = ensembleItems[1].price + ensembleItems[2].price + ensembleItems[3].price;
  var privilegeTotal = Math.round(standardTotal * 0.85);

  document.getElementById('ensStandardTotal').textContent = '₹' + standardTotal.toLocaleString('en-IN');
  document.getElementById('ensPrivilegeTotal').textContent = '₹' + privilegeTotal.toLocaleString('en-IN');
}

function acquireCompleteEnsemble() {
  ndToast('Curating your 3-Piece Capsule Ensemble into bag...', 'success');
  addToCart(1, 1);
  setTimeout(() => addToCart(3, 1), 300);
  setTimeout(() => addToCart(2, 1), 600);
}

// ── Hero Hotspot Interactivity ──
function switchFeaturedGarment(title, price, slug, sub) {
  document.getElementById('heroGarmentTitle').textContent = title;
  document.getElementById('heroGarmentPrice').textContent = price;
  document.getElementById('heroGarmentSub').textContent = sub;
  document.getElementById('heroGarmentLink').href = '<?= base_url('products/') ?>' + slug;
}

// ── Stylist AI Concierge Modal & Live Intelligence Engine ──
function openStylistModal() {
  var m = document.getElementById('aiStylistModal');
  if (!m) return;
  m.classList.remove('hidden');
  m.classList.add('flex');
  document.body.style.overflow = 'hidden';
  setTimeout(() => {
    var inp = document.getElementById('stylistPrompt');
    if (inp) inp.focus();
  }, 100);
}

function closeStylistModal() {
  var m = document.getElementById('aiStylistModal');
  if (!m) return;
  m.classList.add('hidden');
  m.classList.remove('flex');
  document.body.style.overflow = '';
}

function askStylist(query) {
  var q = (query || '').trim();
  if (!q) return;

  var thread = document.getElementById('stylistChatThread');
  if (!thread) return;

  // 1. Append User Message Bubble
  var userDiv = document.createElement('div');
  userDiv.className = 'flex items-start justify-end gap-2.5';
  userDiv.innerHTML = `
    <div class="bg-stone-950 text-white p-3.5 rounded-2xl rounded-tr-xs text-xs font-sans shadow-sm max-w-[85%] leading-relaxed">
      ${escapeHtml(q)}
    </div>
    <div class="w-7 h-7 rounded-xl bg-stone-200 text-stone-700 flex items-center justify-center flex-shrink-0 text-xs font-mono font-bold shadow-xs">
      You
    </div>
  `;
  thread.appendChild(userDiv);
  thread.scrollTop = thread.scrollHeight;

  // 2. Append Loading Indicator
  var typingId = 'typing_' + Date.now();
  var typingDiv = document.createElement('div');
  typingDiv.id = typingId;
  typingDiv.className = 'flex items-start gap-2.5';
  typingDiv.innerHTML = `
    <div class="w-7 h-7 rounded-xl bg-stone-950 text-[#e9c176] flex items-center justify-center flex-shrink-0 text-xs shadow-xs font-bold animate-pulse">
      ✦
    </div>
    <div class="bg-white border border-stone-200 p-3 rounded-2xl rounded-tl-xs text-xs text-stone-500 shadow-2xs flex items-center gap-2">
      <span class="w-1.5 h-1.5 rounded-full bg-[#a16207] animate-ping"></span>
      <span class="font-mono text-[11px]">Curating bespoke sartorial advice...</span>
    </div>
  `;
  thread.appendChild(typingDiv);
  thread.scrollTop = thread.scrollHeight;

  // 3. Intelligent Analysis Engine
  setTimeout(() => {
    var typingEl = document.getElementById(typingId);
    if (typingEl) typingEl.remove();

    var lower = q.toLowerCase();
    var replyHtml = '';

    if (lower.includes('autumn') || lower.includes('layer') || lower.includes('coat') || lower.includes('winter') || lower.includes('outfit')) {
      replyHtml = `
        <p class="font-medium text-stone-950 mb-1.5">🍂 Curated Architectural Autumn Silhouette:</p>
        <p class="mb-2">For an effortless seasonal aesthetic, we recommend contrasting textures: pair our <strong>Grade-A 100% Mongolian Cashmere Cocoon Coat</strong> (Double-faced structure) with <strong>14.5oz Okayama Selvedge Denim Trousers</strong>. The drop-shoulder drape creates commanding balance while keeping warmth featherlight.</p>
        <div class="p-2.5 bg-stone-50 rounded-xl border border-stone-200 flex items-center justify-between gap-2 mt-2">
          <div class="flex items-center gap-2">
            <span class="text-base">🧥</span>
            <div>
              <p class="font-bold text-[11px] text-stone-900">Cashmere Cocoon Coat</p>
              <p class="text-[10px] font-mono text-stone-500">₹4,999 · Atelier Archival</p>
            </div>
          </div>
          <button type="button" onclick="closeStylistModal(); openExpressCheckout(1, 'The Atelier Cashmere Cocoon Coat', 4999, '<?= base_url('img/cashmere_cocoon_coat.jpg') ?>', 1);" class="px-2.5 py-1 bg-stone-950 text-white rounded-lg text-[10px] font-mono font-bold uppercase hover:bg-stone-800 cursor-pointer">
            Buy Now ⚡
          </button>
        </div>
      `;
    } else if (lower.includes('size') || lower.includes('sizing') || lower.includes('drop-shoulder') || lower.includes('fit') || lower.includes('oversize') || lower.includes('small') || lower.includes('medium') || lower.includes('large') || lower.includes('xl')) {
      replyHtml = `
        <p class="font-medium text-stone-950 mb-1.5">📐 Sartorial Fit &amp; Size Consultation:</p>
        <p class="mb-2">LUMINA silhouettes are engineered with a modern editorial drape. Our <strong>Drop-Shoulder cuts</strong> feature approximately <strong>4–5 cm of built-in ease</strong> across the chest and upper arm.</p>
        <ul class="list-disc list-inside space-y-1 text-[11px] text-stone-600 mb-2 font-mono">
          <li><strong>For a tailored luxury look:</strong> Select your true standard chest size (M fits 38–40").</li>
          <li><strong>For a relaxed Tokyo/Milan runway drape:</strong> Take one size up (L).</li>
          <li>All pieces undergo pre-shrunk steam setting to maintain millimeter precision across washes.</li>
        </ul>
      `;
    } else if (lower.includes('cashmere') || lower.includes('fabric') || lower.includes('material') || lower.includes('silk') || lower.includes('denim') || lower.includes('quality')) {
      replyHtml = `
        <p class="font-medium text-stone-950 mb-1.5">💎 Raw Material &amp; Fibre Purity Standards:</p>
        <p class="mb-1.5">Every LUMINA creation begins with certified raw origins:</p>
        <div class="space-y-1.5 text-[11px] font-mono text-stone-700 bg-stone-50 p-2.5 rounded-xl border border-stone-200">
          <p>✦ <strong>Cashmere:</strong> 100% Grade-A Alashan Mongolian Capra fibres (15.5-micron fineness).</p>
          <p>✦ <strong>Silk:</strong> 22-Momme Mulberry Silk woven in bias-cut drape.</p>
          <p>✦ <strong>Denim:</strong> 14.5oz Okayama Selvedge loomed on vintage shuttle looms.</p>
        </div>
      `;
    } else if (lower.includes('coupon') || lower.includes('offer') || lower.includes('discount') || lower.includes('promo') || lower.includes('code') || lower.includes('deal')) {
      replyHtml = `
        <p class="font-medium text-stone-950 mb-1.5">🏷️ Active VIP Atelier Privileges &amp; Codes:</p>
        <p class="mb-2">You have access to exclusive instant atelier codes today:</p>
        <div class="space-y-2">
          <div class="p-2 bg-amber-50 rounded-xl border border-amber-200 flex items-center justify-between">
            <div>
              <span class="font-mono font-bold text-xs text-amber-950">LUMINA50</span>
              <span class="text-[10px] text-amber-800 block">50% OFF Atelier First Acquisition</span>
            </div>
            <button type="button" onclick="closeStylistModal(); setQuickCoupon('LUMINA50', 50, 'percent'); toggleQuickBagDrawer();" class="px-2.5 py-1 bg-stone-950 text-white rounded-lg text-[10px] font-mono font-bold uppercase hover:bg-stone-800 cursor-pointer">
              Apply 50%
            </button>
          </div>
          <div class="p-2 bg-stone-50 rounded-xl border border-stone-200 flex items-center justify-between">
            <div>
              <span class="font-mono font-bold text-xs text-stone-900">FREESHIP</span>
              <span class="text-[10px] text-stone-600 block">Free BlueDart Priority Express Courier</span>
            </div>
            <button type="button" onclick="closeStylistModal(); setQuickCoupon('FREESHIP', 0, 'shipping'); toggleQuickBagDrawer();" class="px-2.5 py-1 bg-stone-200 text-stone-900 rounded-lg text-[10px] font-mono font-bold uppercase hover:bg-stone-300 cursor-pointer">
              Apply
            </button>
          </div>
        </div>
      `;
    } else if (lower.includes('ship') || lower.includes('delivery') || lower.includes('track') || lower.includes('courier') || lower.includes('time') || lower.includes('bluedart')) {
      replyHtml = `
        <p class="font-medium text-stone-950 mb-1.5">🚀 BlueDart Priority Express Logistics:</p>
        <p class="mb-1.5">All orders are dispatched in custom sealed garment luggage boxes with tamper-proof certification.</p>
        <p class="text-stone-600 mb-2">Transit time is <strong>24–48 hours across metro zones</strong> with real-time GPS tracking. Shipping is complimentary on orders above ₹2,999.</p>
        <a href="<?= base_url('tracking') ?>" onclick="closeStylistModal()" class="inline-flex items-center gap-1 text-[11px] font-mono text-[#a16207] font-bold underline">
          Open Live GPS Tracking Feed →
        </a>
      `;
    } else if (lower.includes('return') || lower.includes('exchange') || lower.includes('refund')) {
      replyHtml = `
        <p class="font-medium text-stone-950 mb-1.5">🔄 14-Day White-Glove Exchange Guarantee:</p>
        <p>We provide a seamless <strong>14-Day reverse pickup</strong> directly from your doorstep. If the drape or fit does not exceed your expectations, exchange for an alternate size or complete store credit with zero transit fees.</p>
      `;
    } else {
      replyHtml = `
        <p class="font-medium text-stone-950 mb-1.5">✦ Sartorial Recommendation for "${escapeHtml(q)}":</p>
        <p class="mb-2">To master this look with LUMINA's design language, focus on high-low textural tension: balance structured outerwear with soft fluid silk underpinnings or heavyweight looped terry essentials.</p>
        <p class="text-stone-600 mb-2">Would you like recommendations on our <strong>Outerwear Capsules</strong>, <strong>Japanese Selvedge Denim</strong>, or <strong>Mulberry Silk Eveningwear</strong>?</p>
        <div class="flex gap-1.5 flex-wrap">
          <button type="button" onclick="askStylist('Show me outerwear capsule coats')" class="px-2.5 py-1 bg-stone-100 border border-stone-200 text-[10px] font-mono rounded-lg hover:border-stone-900 cursor-pointer">🧥 Outerwear</button>
          <button type="button" onclick="askStylist('Show me silk evening dresses')" class="px-2.5 py-1 bg-stone-100 border border-stone-200 text-[10px] font-mono rounded-lg hover:border-stone-900 cursor-pointer">✨ Evening Silk</button>
          <button type="button" onclick="askStylist('What VIP discount coupons are available?')" class="px-2.5 py-1 bg-amber-50 border border-amber-200 text-amber-900 text-[10px] font-mono rounded-lg hover:border-amber-400 cursor-pointer">🏷️ VIP Codes</button>
        </div>
      `;
    }

    var aiDiv = document.createElement('div');
    aiDiv.className = 'flex items-start gap-2.5';
    aiDiv.innerHTML = `
      <div class="w-7 h-7 rounded-xl bg-stone-950 text-[#e9c176] flex items-center justify-center flex-shrink-0 text-xs shadow-xs font-bold">
        ✦
      </div>
      <div class="bg-white border border-stone-200 p-3.5 rounded-2xl rounded-tl-xs text-xs text-stone-800 shadow-2xs leading-relaxed max-w-[90%]">
        ${replyHtml}
      </div>
    `;
    thread.appendChild(aiDiv);
    thread.scrollTop = thread.scrollHeight;
  }, 450);
}

function escapeHtml(text) {
  var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
  return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
}

// ── Floating Sticky Quick-Order Bar Trigger ──
window.addEventListener('scroll', () => {
  const scrollY = window.pageYOffset || document.documentElement.scrollTop;
  const pill = document.getElementById('floatingQuickOrderPill');
  if (pill) {
    if (scrollY > 600) {
      pill.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
      pill.classList.add('translate-y-0', 'opacity-100');
    } else {
      pill.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
      pill.classList.remove('translate-y-0', 'opacity-100');
    }
  }
}, { passive: true });
// 3D COSMIC PARTICLE CONSTELLATION & PARALLAX ENGINE
// ════════════════════════════════════════════════════════════
(function() {
  const canvas = document.getElementById('heroConstellationCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  let width, height;
  let particles = [];
  let mouse = { x: null, y: null, radius: 140 };

  function resize() {
    if (!canvas.parentElement) return;
    width = canvas.width = canvas.parentElement.offsetWidth;
    height = canvas.height = canvas.parentElement.offsetHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  window.addEventListener('mousemove', (e) => {
    const rect = canvas.getBoundingClientRect();
    mouse.x = e.clientX - rect.left;
    mouse.y = e.clientY - rect.top;
  });

  window.addEventListener('touchstart', (e) => {
    if (e.touches && e.touches[0]) {
      const rect = canvas.getBoundingClientRect();
      mouse.x = e.touches[0].clientX - rect.left;
      mouse.y = e.touches[0].clientY - rect.top;
    }
  }, { passive: true });

  window.addEventListener('touchmove', (e) => {
    if (e.touches && e.touches[0]) {
      const rect = canvas.getBoundingClientRect();
      mouse.x = e.touches[0].clientX - rect.left;
      mouse.y = e.touches[0].clientY - rect.top;
    }
  }, { passive: true });

  window.addEventListener('mouseleave', () => {
    mouse.x = null;
    mouse.y = null;
  });

  window.addEventListener('touchend', () => {
    mouse.x = null;
    mouse.y = null;
  });

  class Particle {
    constructor() {
      this.x = Math.random() * (width || window.innerWidth);
      this.y = Math.random() * (height || window.innerHeight);
      this.vx = (Math.random() - 0.5) * 0.7;
      this.vy = (Math.random() - 0.5) * 0.7;
      this.size = Math.random() * 2 + 1;
      this.density = (Math.random() * 20) + 5;
    }
    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(233, 193, 118, ' + (this.size / 3) + ')';
      ctx.fill();
    }
    update() {
      this.x += this.vx;
      this.y += this.vy;

      if (this.x < 0 || this.x > width) this.vx *= -1;
      if (this.y < 0 || this.y > height) this.vy *= -1;

      // Mouse Proximity Elasticity
      if (mouse.x !== null) {
        let dx = mouse.x - this.x;
        let dy = mouse.y - this.y;
        let distance = Math.sqrt(dx * dx + dy * dy);
        if (distance < mouse.radius) {
          let forceDirectionX = dx / distance;
          let forceDirectionY = dy / distance;
          let force = (mouse.radius - distance) / mouse.radius;
          this.x -= forceDirectionX * force * this.density;
          this.y -= forceDirectionY * force * this.density;
        }
      }
    }
  }

  for (let i = 0; i < 60; i++) {
    particles.push(new Particle());
  }

  function animate() {
    ctx.clearRect(0, 0, width, height);
    for (let i = 0; i < particles.length; i++) {
      particles[i].draw();
      particles[i].update();

      for (let j = i; j < particles.length; j++) {
        let dx = particles[i].x - particles[j].x;
        let dy = particles[i].y - particles[j].y;
        let distance = Math.sqrt(dx * dx + dy * dy);
        if (distance < 110) {
          ctx.beginPath();
          ctx.strokeStyle = 'rgba(233, 193, 118, ' + (1 - distance / 110) * 0.2 + ')';
          ctx.lineWidth = 0.6;
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }
    requestAnimationFrame(animate);
  }
  animate();
})();

// ════════════════════════════════════════════════════════════
// 3D 360° DRAG-TO-ROTATE TURNTABLE & EXPLODED ANATOMY ENGINE
// ════════════════════════════════════════════════════════════
let isTurntableAutoOrbit = true;
let isTurntableExploded = false;
let currentTurntableAngle = 0;
let turntableVelocity = 0;
let turntableAnimFrame = null;

(function() {
  const box = document.getElementById('turntable3dBox');
  const img = document.getElementById('turntableImage');
  const angleLabel = document.getElementById('turntableAngle');
  const glare = document.getElementById('turntableGlare');
  if (!box || !img) return;

  let isDragging = false;
  let startX = 0;
  let lastX = 0;

  function updateTurntableRender(deg) {
    currentTurntableAngle = deg;
    const rad = deg * (Math.PI / 180);
    const tilt = Math.sin(rad) * 6;

    if (isTurntableExploded) {
      img.style.transform = `perspective(1000px) rotateY(${deg}deg) rotateX(${tilt}deg) scale3d(1.1, 1.1, 1.1) translateZ(40px)`;
    } else {
      img.style.transform = `perspective(1000px) rotateY(${deg}deg) rotateX(${tilt}deg) scale3d(1, 1, 1)`;
    }

    if (angleLabel) angleLabel.textContent = Math.round(deg % 360) + '°';

    if (glare) {
      const glareX = 50 + Math.sin(rad) * 35;
      glare.style.background = `radial-gradient(circle at ${glareX}% 40%, rgba(255,255,255,0.4), transparent 60%)`;
    }
  }

  // Auto-Orbit Animation Loop with Inertia
  function orbitLoop() {
    if (isTurntableAutoOrbit && !isDragging) {
      currentTurntableAngle = (currentTurntableAngle + 0.4) % 360;
      updateTurntableRender(currentTurntableAngle);
    } else if (Math.abs(turntableVelocity) > 0.05 && !isDragging) {
      currentTurntableAngle = (currentTurntableAngle + turntableVelocity) % 360;
      if (currentTurntableAngle < 0) currentTurntableAngle += 360;
      turntableVelocity *= 0.95;
      updateTurntableRender(currentTurntableAngle);
    }
    turntableAnimFrame = requestAnimationFrame(orbitLoop);
  }
  orbitLoop();

  // Mouse Drag Listeners
  box.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.clientX;
    lastX = e.clientX;
    turntableVelocity = 0;
  });

  window.addEventListener('mouseup', () => {
    isDragging = false;
  });

  window.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    const deltaX = e.clientX - lastX;
    lastX = e.clientX;
    turntableVelocity = deltaX * 0.4;
    currentTurntableAngle = (currentTurntableAngle + deltaX * 0.8) % 360;
    if (currentTurntableAngle < 0) currentTurntableAngle += 360;
    updateTurntableRender(currentTurntableAngle);
  });

  // Touch Drag Listeners
  box.addEventListener('touchstart', (e) => {
    isDragging = true;
    startX = e.touches[0].clientX;
    lastX = e.touches[0].clientX;
    turntableVelocity = 0;
  }, { passive: true });

  window.addEventListener('touchend', () => {
    isDragging = false;
  });

  window.addEventListener('touchmove', (e) => {
    if (!isDragging || !e.touches[0]) return;
    const deltaX = e.touches[0].clientX - lastX;
    lastX = e.touches[0].clientX;
    turntableVelocity = deltaX * 0.4;
    currentTurntableAngle = (currentTurntableAngle + deltaX * 0.8) % 360;
    if (currentTurntableAngle < 0) currentTurntableAngle += 360;
    updateTurntableRender(currentTurntableAngle);
  }, { passive: true });

  // Expose global controller helpers
  window.setTurntablePreset = function(deg) {
    isTurntableAutoOrbit = false;
    const orbitIcon = document.getElementById('orbitIcon');
    const orbitLabel = document.getElementById('orbitLabel');
    if (orbitIcon) orbitIcon.textContent = 'pause_circle';
    if (orbitLabel) orbitLabel.textContent = 'Auto-Orbit: OFF';
    
    let start = currentTurntableAngle;
    let target = deg;
    let startTime = null;
    function anim(time) {
      if (!startTime) startTime = time;
      let progress = Math.min((time - startTime) / 600, 1);
      let ease = progress < 0.5 ? 2 * progress * progress : -1 + (4 - 2 * progress) * progress;
      let angle = start + (target - start) * ease;
      updateTurntableRender(angle);
      if (progress < 1) requestAnimationFrame(anim);
    }
    requestAnimationFrame(anim);
  };

  window.toggleTurntableAutoOrbit = function() {
    isTurntableAutoOrbit = !isTurntableAutoOrbit;
    const orbitIcon = document.getElementById('orbitIcon');
    const orbitLabel = document.getElementById('orbitLabel');
    if (isTurntableAutoOrbit) {
      if (orbitIcon) orbitIcon.textContent = 'play_circle';
      if (orbitLabel) orbitLabel.textContent = 'Auto-Orbit: ON';
      ndToast('3D Spatial Auto-Orbit Resumed.', 'success');
    } else {
      if (orbitIcon) orbitIcon.textContent = 'pause_circle';
      if (orbitLabel) orbitLabel.textContent = 'Auto-Orbit: OFF';
      ndToast('3D Spatial Auto-Orbit Paused.', 'info');
    }
  };

  window.toggleExplodedAnatomy = function() {
    isTurntableExploded = !isTurntableExploded;
    const layers = document.getElementById('explodedLayersContainer');
    const btn = document.getElementById('turntableExplodeBtn');
    const label = document.getElementById('explodeLabel');

    if (isTurntableExploded) {
      if (layers) {
        layers.classList.remove('hidden');
        layers.classList.add('flex');
      }
      if (btn) {
        btn.classList.remove('bg-amber-500/15', 'border-amber-500/40');
        btn.classList.add('bg-emerald-500/20', 'border-emerald-500/50', 'text-emerald-300');
      }
      if (label) label.textContent = 'Assembled View 3D';
      ndToast('3D Exploded Garment Anatomy Unfolded.', 'success');
    } else {
      if (layers) {
        layers.classList.add('hidden');
        layers.classList.remove('flex');
      }
      if (btn) {
        btn.classList.remove('bg-emerald-500/20', 'border-emerald-500/50', 'text-emerald-300');
        btn.classList.add('bg-amber-500/15', 'border-amber-500/40', 'text-[#e9c176]');
      }
      if (label) label.textContent = 'Exploded Anatomy 3D';
      ndToast('Assembled View Restored.', 'info');
    }
    updateTurntableRender(currentTurntableAngle);
  };

  window.triggerPinDetail = function(layerNum, e) {
    if (e) e.stopPropagation();
    if (typeof ndToast === 'function') {
      const names = { 1: 'Hand-Stitched Horn Buttons & Bespoke Lapel', 2: '700 GSM 100% Grade-A Mongolian Cashmere', 3: 'Silk-Cupro Breathable Temperature Lining' };
      ndToast('Inspecting: ' + (names[layerNum] || 'Garment Layer'), 'success');
    }
  };
})();

// ════════════════════════════════════════════════════════════
// 3D MAGNETIC PHYSICS ON ROUND CATEGORY CIRCLES
// ════════════════════════════════════════════════════════════
function scrollCategoryStrip(delta) {
  const container = document.getElementById('categoryStripScroll');
  if (container) {
    container.scrollBy({ left: delta, behavior: 'smooth' });
  }
}

document.querySelectorAll('.category-3d-item').forEach(item => {
  const circle = item.querySelector('.category-3d-circle');
  if (!circle) return;

  item.addEventListener('mousemove', (e) => {
    const rect = item.getBoundingClientRect();
    const x = e.clientX - rect.left - rect.width / 2;
    const y = e.clientY - rect.top - rect.height / 2;
    const rotateX = -(y / rect.height) * 18;
    const rotateY = (x / rect.width) * 18;
    circle.style.transform = `perspective(500px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.15) translateZ(15px)`;
  });

  item.addEventListener('mouseleave', () => {
    circle.style.transform = 'perspective(500px) rotateX(0deg) rotateY(0deg) scale(1) translateZ(0px)';
  });
});

// ════════════════════════════════════════════════════════════
// 3D GYRO PERSPECTIVE CARD TILT WITH SPECULAR REFLECTION
// ════════════════════════════════════════════════════════════
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.curated-card, .tilt-card');

  cards.forEach((card) => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = ((y - centerY) / centerY) * -10;
      const rotateY = ((x - centerX) / centerX) * 10;

      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.03, 1.03, 1.03)`;
      card.style.boxShadow = `0 20px 40px rgba(0,0,0,0.5), 0 0 25px rgba(233,193,118,0.15)`;
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
      card.style.boxShadow = '';
    });
  });

  // ── Live Flash Sale & Private Drops Countdown Timer ──
  function startHeroCountdown() {
    let target = new Date().getTime() + (7 * 3600 + 42 * 60 + 15) * 1000;

    function update() {
      const now = new Date().getTime();
      const diff = Math.max(0, target - now);

      const hours = Math.floor(diff / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((diff % (1000 * 60)) / 1000);

      const formatted = 
        String(hours).padStart(2, '0') + 'h : ' + 
        String(minutes).padStart(2, '0') + 'm : ' + 
        String(seconds).padStart(2, '0') + 's';

      const timerEl = document.getElementById('heroCountdownTimer');
      if (timerEl) timerEl.textContent = formatted;

      const flashH = document.getElementById('flashHours');
      const flashM = document.getElementById('flashMins');
      const flashS = document.getElementById('flashSecs');
      if (flashH) flashH.textContent = String(hours).padStart(2, '0');
      if (flashM) flashM.textContent = String(minutes).padStart(2, '0');
      if (flashS) flashS.textContent = String(seconds).padStart(2, '0');
    }
    update();
    setInterval(update, 1000);
  }
  startHeroCountdown();

  // ── Storefront Real-Time Category Filtering ──
  window.filterStorefrontCategory = function(cat, btn) {
    // Update active tab styling to Obsidian Black
    document.querySelectorAll('.store-filter-tab').forEach(t => {
      t.classList.remove('active', 'bg-stone-950', 'text-white', 'shadow-md', 'border-stone-950');
      t.classList.add('bg-stone-100', 'border', 'border-stone-200', 'text-stone-700');
    });

    if (btn) {
      btn.classList.add('active', 'bg-stone-950', 'text-white', 'shadow-md', 'border-stone-950');
      btn.classList.remove('bg-stone-100', 'border-stone-200', 'text-stone-700');
    }

    // Filter cards with smooth fade
    const cards = document.querySelectorAll('.store-product-card');
    let visibleCount = 0;

    cards.forEach(card => {
      const cardCat = card.getAttribute('data-category');
      if (cat === 'all' || cardCat === cat) {
        card.style.display = 'flex';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.96)';
        setTimeout(() => {
          card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
          card.style.opacity = '1';
          card.style.transform = 'scale(1)';
        }, 30);
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    if (typeof ndToast === 'function') {
      const catNames = {
        all: 'All Masterpieces',
        cashmere: 'Outerwear & Cashmere',
        denim: 'Okayama Denim',
        terry: 'Heavyweight Essentials',
        silk: 'Mulberry Silk',
        suiting: 'Tailored Suiting'
      };
      ndToast(`Filtering: ${catNames[cat] || cat} (${visibleCount} Pieces)`, 'info');
    }
  };

  // ── Hero Textile Switcher ──
  const heroTextiles = {
    cashmere: {
      title: 'The Atelier Cashmere Cocoon Coat',
      img: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>',
      price: 4999,
      regularPrice: 8999,
      discount: 44,
      save: 4000,
      badge: '100% Mongolian Cashmere',
      id: 1
    },
    denim: {
      title: 'Vintage Okayama 14.5oz Selvedge Trousers',
      img: 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=1200&q=90',
      price: 3499,
      regularPrice: 5999,
      discount: 42,
      save: 2500,
      badge: '14.5oz Okayama Selvedge',
      id: 2
    },
    silk: {
      title: '22-Momme Mulberry Silk Bias Slip Dress',
      img: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1200&q=90',
      price: 5499,
      regularPrice: 9499,
      discount: 42,
      save: 4000,
      badge: '22-Momme Pure Mulberry Silk',
      id: 3
    }
  };

  window.switchHeroTextile = function(type, btn) {
    const data = heroTextiles[type];
    if (!data) return;

    document.querySelectorAll('.hero-swatch-btn').forEach(b => {
      b.classList.remove('active', 'bg-[#e9c176]', 'text-black', 'font-bold', 'shadow-md');
      b.classList.add('text-white/70');
    });
    if (btn) {
      btn.classList.add('active', 'bg-[#e9c176]', 'text-black', 'font-bold', 'shadow-md');
      btn.classList.remove('text-white/70');
    }

    const imgEl = document.getElementById('heroModelImage');
    if (imgEl) {
      imgEl.style.opacity = '0';
      imgEl.style.transform = 'scale(0.95)';
      setTimeout(() => {
        imgEl.src = data.img;
        imgEl.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        imgEl.style.opacity = '1';
        imgEl.style.transform = 'scale(1)';
      }, 150);
    }

    const titleEl = document.getElementById('heroGarmentTitle');
    if (titleEl) titleEl.textContent = data.title;

    const priceEl = document.getElementById('heroGarmentPrice');
    if (priceEl) {
      priceEl.textContent = '₹' + data.price.toLocaleString();
      priceEl.setAttribute('data-price-inr', data.price);
    }

    // Toast removed — subtle fabric changes without popup distraction

  };

  // ── Framer Motion Tiles Swapper ──
  const motionTileData = [
    { tag: 'Category 01 · Outerwear', title: 'The Atelier Cashmere Cocoon Coat', desc: 'Relaxed drop shoulder with 700 GSM double-faced Mongolian cashmere.', img: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>', id: 1 },
    { tag: 'Category 02 · Japanese Denim', title: 'Okayama 14.5oz Selvedge Trousers', desc: 'Vintage shuttle-loomed selvedge denim rope-dyed in authentic natural indigo.', img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', id: 2 },
    { tag: 'Category 03 · Knitwear', title: '500 GSM Loopback French Terry Hoodie', desc: 'Pre-shrunk custom knit French terry with double-needle flatlock construction.', img: '<?= base_url("img/terry_hoodie_luxury.jpg") ?>', id: 3 },
    { tag: 'Category 04 · Eveningwear', title: '22-Momme Mulberry Silk Bias Dress', desc: 'Fluid drape cut on the true bias with hand-rolled French seams.', img: '<?= base_url("img/mulberry_silk_dress.jpg") ?>', id: 4 },
    { tag: 'Category 05 · Suiting', title: 'Super 150s Italian Wool Blazer', desc: 'Architectural double-breasted cut with floating horsehair canvas.', img: '<?= base_url("img/wool_blazer_luxury.jpg") ?>', id: 5 },
    { tag: 'Category 06 · Haute Couture', title: 'Italian Pleated Virgin Wool Trousers', desc: 'Hand-tailored over 42 artisan hours with bespoke reverse pleats.', img: '<?= base_url("img/italian_pleated_trousers.jpg") ?>', id: 10 },
    { tag: 'Category 07 · Archival Drops', title: 'Limited Archival Edition Pieces', desc: 'Individually numbered master series with authenticated seal of provenance.', img: '<?= base_url("img/melton_wool_peacoat.jpg") ?>', id: 6 }
  ];

  window.activateMotionTile = function(idx) {
    const data = motionTileData[idx];
    if (!data) return;

    const items = document.querySelectorAll('.motion-tile-item');
    items.forEach((it, i) => {
      if (i === idx) {
        it.classList.add('active');
        it.classList.remove('inactive');
        const numSpan = it.querySelector('span:first-child');
        if (numSpan) { numSpan.classList.add('text-[#e9c176]'); numSpan.classList.remove('text-stone-500'); }
      } else {
        it.classList.remove('active');
        it.classList.add('inactive');
        const numSpan = it.querySelector('span:first-child');
        if (numSpan) { numSpan.classList.remove('text-[#e9c176]'); numSpan.classList.add('text-stone-500'); }
      }
    });

    const img = document.getElementById('motionStageImage');
    if (img) {
      img.style.opacity = '0.3';
      setTimeout(() => {
        img.src = data.img;
        img.style.opacity = '1';
      }, 120);
    }

    const tag = document.getElementById('motionStageTag');
    if (tag) tag.textContent = data.tag;

    const title = document.getElementById('motionStageTitle');
    if (title) title.textContent = data.title;

    const desc = document.getElementById('motionStageDesc');
    if (desc) desc.textContent = data.desc;

    const btn = document.getElementById('motionStageBtn');
    if (btn) {
      btn.onclick = function(e) {
        e.stopPropagation();
        addToCart(data.id, 1);
      };
    }
  };

});
</script>

<!-- ══════════════════════════════════════════════════════
     AI BLOCK 1: LUMINA AI STYLIST — SMART OUTFIT COMBOS
══════════════════════════════════════════════════════ -->
<section class="py-16 md:py-20 bg-white text-stone-900 border-t border-stone-200 overflow-hidden relative scroll-unfold-section" id="aiStylistSection">
  <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(233,193,118,0.08), transparent);"></div>

  <div class="max-w-7xl mx-auto px-4 md:px-8 relative z-10">

    <!-- Section Header -->
    <div class="text-center mb-10 sm:mb-12">
      <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-[#a16207] text-xs font-mono uppercase tracking-widest mb-4 font-semibold">
        <span class="w-2 h-2 rounded-full bg-[#a16207] animate-pulse"></span>
        Lumina AI Stylist · Neural Outfit Curation
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-serif text-stone-900 mb-3 leading-tight">
        Your Personal <span class="italic text-[#a16207]">AI Stylist</span>
      </h2>
      <p class="text-stone-600 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
        Our AI analyses aesthetics &amp; cuts to curate complete outfit combos with bespoke dressing advice, style metrics, and 1-click cart acquisition.
      </p>
    </div>

    <!-- Mood / Occasion Selector -->
    <div class="flex flex-wrap gap-2 justify-center mb-8 sm:mb-10" id="moodSelector">
      <button onclick="selectMood('business')" class="mood-btn active-mood px-4 py-2 rounded-full border border-stone-950 bg-stone-950 text-white text-xs font-mono uppercase tracking-wider transition-all shadow-sm" data-mood="business">💼 Business Luxe</button>
      <button onclick="selectMood('street')" class="mood-btn px-4 py-2 rounded-full border border-stone-200 bg-stone-100 hover:bg-stone-950 hover:text-white text-stone-700 text-xs font-mono uppercase tracking-wider transition-all" data-mood="street">🔥 Street Couture</button>
      <button onclick="selectMood('evening')" class="mood-btn px-4 py-2 rounded-full border border-stone-200 bg-stone-100 hover:bg-stone-950 hover:text-white text-stone-700 text-xs font-mono uppercase tracking-wider transition-all" data-mood="evening">✨ Evening Gala</button>
      <button onclick="selectMood('weekend')" class="mood-btn px-4 py-2 rounded-full border border-stone-200 bg-stone-100 hover:bg-stone-950 hover:text-white text-stone-700 text-xs font-mono uppercase tracking-wider transition-all" data-mood="weekend">🌿 Weekend Edit</button>
      <button onclick="selectMood('athleisure')" class="mood-btn px-4 py-2 rounded-full border border-stone-200 bg-stone-100 hover:bg-stone-950 hover:text-white text-stone-700 text-xs font-mono uppercase tracking-wider transition-all" data-mood="athleisure">⚡ Athleisure Pro</button>
    </div>

    <!-- Outfit Combo Display -->
    <div class="relative" id="comboContainer">
      <!-- AI Thinking Animation -->
      <div id="aiThinking" class="hidden absolute inset-0 bg-white/90 backdrop-blur-sm z-20 flex flex-col items-center justify-center rounded-3xl">
        <div class="flex gap-1.5 mb-4">
          <span class="w-3 h-3 rounded-full bg-black animate-bounce" style="animation-delay:0s"></span>
          <span class="w-3 h-3 rounded-full bg-[#a16207] animate-bounce" style="animation-delay:0.15s"></span>
          <span class="w-3 h-3 rounded-full bg-black animate-bounce" style="animation-delay:0.3s"></span>
        </div>
        <div class="text-xs font-mono text-black/50 uppercase tracking-widest">AI is curating your look…</div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="comboGrid">

        <!-- Left: Style Identity Card -->
        <div class="lg:col-span-3 bg-stone-950 rounded-2xl p-5 sm:p-6 text-white flex flex-col justify-between shadow-md" id="styleIdentityCard">
          <div>
            <div class="text-[10px] font-mono uppercase tracking-widest text-[#e9c176] mb-2 font-bold">AI Style Identity</div>
            <h3 class="font-serif text-xl sm:text-2xl mb-2.5 leading-snug" id="styleTitle">The Power Executive</h3>
            <p class="text-white/70 text-xs leading-relaxed mb-5" id="styleDesc">Structured silhouettes with premium suiting fabrics. Signals authority, taste, and effortless confidence.</p>

            <!-- Style Score Bars -->
            <div class="space-y-3" id="scoreBars">
              <div>
                <div class="flex justify-between text-[10px] mb-1">
                  <span class="text-white/60 font-mono uppercase">Formality</span>
                  <span class="text-[#e9c176] font-bold" id="score_formality">92%</span>
                </div>
                <div class="h-1 bg-white/15 rounded-full overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-[#a16207] to-[#e9c176] rounded-full transition-all duration-800" id="bar_formality" style="width:92%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-[10px] mb-1">
                  <span class="text-white/60 font-mono uppercase">Versatility</span>
                  <span class="text-[#e9c176] font-bold" id="score_versatility">75%</span>
                </div>
                <div class="h-1 bg-white/15 rounded-full overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-[#a16207] to-[#e9c176] rounded-full transition-all duration-800" id="bar_versatility" style="width:75%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-[10px] mb-1">
                  <span class="text-white/60 font-mono uppercase">Trend Score</span>
                  <span class="text-[#e9c176] font-bold" id="score_trend">88%</span>
                </div>
                <div class="h-1 bg-white/15 rounded-full overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-[#a16207] to-[#e9c176] rounded-full transition-all duration-800" id="bar_trend" style="width:88%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-[10px] mb-1">
                  <span class="text-white/60 font-mono uppercase">Luxury Index</span>
                  <span class="text-[#e9c176] font-bold" id="score_luxury">97%</span>
                </div>
                <div class="h-1 bg-white/15 rounded-full overflow-hidden">
                  <div class="h-full bg-gradient-to-r from-[#a16207] to-[#e9c176] rounded-full transition-all duration-800" id="bar_luxury" style="width:97%"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-5 pt-4 border-t border-white/15">
            <div class="text-[10px] font-mono uppercase tracking-widest text-white/50 mb-2">Best For</div>
            <div class="flex flex-wrap gap-1.5" id="occasionTags">
              <span class="px-2 py-0.5 bg-white/10 text-white/80 text-[10px] rounded-full">Board meetings</span>
              <span class="px-2 py-0.5 bg-white/10 text-white/80 text-[10px] rounded-full">Client dinners</span>
              <span class="px-2 py-0.5 bg-white/10 text-white/80 text-[10px] rounded-full">Conferences</span>
            </div>
          </div>
        </div>

        <!-- Center: Outfit Items Grid (2-Column Mobile, 3-Column Desktop) -->
        <div class="lg:col-span-6">
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-3 h-full" id="outfitItemsGrid">
            <!-- Items injected by JS -->
          </div>
        </div>

        <!-- Right: How to Wear + Add All -->
        <div class="lg:col-span-3 flex flex-col gap-4">

          <!-- How to Wear Guide -->
          <div class="bg-stone-100 rounded-2xl p-4 sm:p-5 flex-1 border border-stone-200">
            <div class="text-[10px] font-mono uppercase tracking-widest text-stone-500 mb-3 font-bold">AI Dressing Advice</div>
            <ul class="space-y-2.5 text-xs text-stone-700 leading-relaxed" id="howToWear">
              <li class="flex gap-2"><span class="text-[#a16207] font-bold mt-0.5">✦</span> Tuck the shirt fully and add a slim leather belt at the waist for a sharp silhouette.</li>
              <li class="flex gap-2"><span class="text-[#a16207] font-bold mt-0.5">✦</span> Roll trouser hems by one turn to expose the selvedge detail and keep it relaxed.</li>
              <li class="flex gap-2"><span class="text-[#a16207] font-bold mt-0.5">✦</span> Leave the top two buttons open for an approachable executive look.</li>
            </ul>
          </div>

          <!-- Total Price + Add All to Cart -->
          <div class="bg-stone-950 rounded-2xl p-5 text-white shadow-md">
            <div class="text-[10px] font-mono uppercase tracking-widest text-white/50 mb-1.5">Full Outfit Total</div>
            <div class="text-2xl sm:text-3xl font-serif font-bold text-[#e9c176] mb-1" id="comboTotalPrice">₹18,997</div>
            <div class="text-[10px] text-white/50 mb-3.5">Saving <span class="text-emerald-400 font-bold" id="comboTotalSave">₹9,000</span> vs. individual retail</div>
            <button onclick="addComboToCart()" class="w-full py-2.5 sm:py-3 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 text-stone-950 text-xs font-button uppercase tracking-wider font-extrabold rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md">
              <span class="material-symbols-outlined text-sm">shopping_bag</span>
              <span>Shop Full Outfit</span>
            </button>
            <button onclick="shuffleOutfit()" id="shuffleBtn" class="w-full mt-2 py-2.5 border border-white/20 text-white text-xs font-button uppercase tracking-wider rounded-xl hover:bg-white/10 transition-all flex items-center justify-center gap-2 cursor-pointer">
              <span class="material-symbols-outlined text-sm" id="shuffleIcon">shuffle</span>
              <span>Shuffle Outfit</span>
            </button>
          </div>

          <!-- Customize Look in Bespoke Ensemble Studio Modal -->
          <button onclick="openEnsembleStudio('all')" class="w-full py-3 sm:py-3.5 rounded-xl border border-stone-900 bg-white hover:bg-stone-950 hover:text-white text-stone-950 text-xs font-button uppercase tracking-wider transition-all flex items-center justify-center gap-2 group cursor-pointer shadow-md font-bold hover:shadow-lg">
            <span class="material-symbols-outlined text-base text-[#a16207] group-hover:text-[#e9c176] transition-colors">tune</span>
            <span>Customize Ensemble &amp; Sizes →</span>
          </button>
        </div>

      </div>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     BESPOKE ATELIER ENSEMBLE STUDIO & MULTI-PIECE CUSTOMIZER MODAL
══════════════════════════════════════════════════════ -->
<div id="ensembleStudioModal" data-lenis-prevent="true" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[130] hidden items-center justify-center p-2 sm:p-4 md:p-6 overflow-y-auto" onclick="if(event.target===this)closeEnsembleStudio()">
  <div id="ensembleStudioInner" class="bg-white text-stone-900 rounded-3xl max-w-5xl w-full border border-stone-200 shadow-2xl relative my-auto overflow-hidden flex flex-col max-h-[94vh] animate-fade-in">
    
    <!-- Modal Header -->
    <div class="p-4 sm:p-6 border-b border-stone-200 flex items-center justify-between bg-stone-50/80 flex-shrink-0">
      <div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-[#a16207] text-[10px] sm:text-[10.5px] font-mono font-bold uppercase tracking-wider mb-1 border border-amber-200">
          <span class="w-1.5 h-1.5 rounded-full bg-[#a16207] animate-ping"></span>
          <span>✦ Atelier Ensemble Studio ✦</span>
        </div>
        <h3 class="font-serif text-xl sm:text-2xl text-stone-950 font-bold">Build Your Custom 3-Piece Look</h3>
        <p class="text-xs text-stone-500 font-light mt-0.5">Select clothes, pants, and footwear from the catalog below. Choose individual sizes to build your personalized ensemble.</p>
      </div>
      <button type="button" onclick="closeEnsembleStudio()" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white hover:bg-stone-200 border border-stone-200 text-stone-700 flex items-center justify-center cursor-pointer transition-all hover:scale-105 shadow-2xs" aria-label="Close">
        <span class="material-symbols-outlined text-lg sm:text-xl">close</span>
      </button>
    </div>

    <!-- Scrollable Modal Body -->
    <div class="overflow-y-auto p-4 sm:p-6 space-y-6 flex-1 custom-scrollbar">

      <!-- ── 1. ACTIVE 3-SLOT ENSEMBLE STAGE ── -->
      <div class="bg-[#0c0d14] text-white rounded-2xl p-4 sm:p-5 shadow-xl border border-amber-500/30 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-48 h-48 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 mb-3 border-b border-white/10 gap-2 relative z-10">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#e9c176] text-lg">view_carousel</span>
            <span class="font-mono text-xs uppercase tracking-wider text-[#e9c176] font-bold">Active 3-Piece Ensemble Stage:</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-[11px] font-mono text-amber-300 font-bold bg-amber-500/15 px-2.5 py-0.5 rounded-full border border-amber-400/30 flex items-center gap-1">
              <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
              <span>15% Pack Privilege Applied</span>
            </span>
          </div>
        </div>

        <!-- 3 Slots Grid (Tops, Bottoms, Footwear) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 relative z-10" id="studioStageSlots">
          <!-- Dynamically Rendered by JS -->
        </div>
      </div>

      <!-- ── 2. WARDROBE CATEGORY FILTER TABS ── -->
      <div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-2">
          <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#a16207] text-lg">checkroom</span>
            <span class="font-mono text-xs uppercase tracking-wider text-stone-900 font-bold">Browse &amp; Choose Garments by Category:</span>
          </div>
          <span class="text-xs font-mono text-stone-500" id="studioCategoryCount">8 styles available</span>
        </div>

        <!-- Category Tabs -->
        <div class="flex flex-wrap gap-2 pb-1 border-b border-stone-200" id="studioCategoryTabs">
          <button type="button" onclick="selectStudioCategory('tops')" class="studio-cat-tab active-tab px-4 py-2.5 rounded-xl border-2 border-stone-950 bg-stone-950 text-white text-xs font-mono uppercase tracking-wider font-bold transition-all shadow-sm flex items-center gap-1.5 cursor-pointer" data-cat="tops">
            <span>🧥</span>
            <span>All Clothes &amp; Tops</span>
            <span class="px-1.5 py-0.2 bg-white/20 rounded text-[10px]" id="studioCount_tops">8</span>
          </button>
          <button type="button" onclick="selectStudioCategory('bottoms')" class="studio-cat-tab px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-mono uppercase tracking-wider font-bold transition-all flex items-center gap-1.5 cursor-pointer" data-cat="bottoms">
            <span>👖</span>
            <span>All Pants &amp; Trousers</span>
            <span class="px-1.5 py-0.2 bg-stone-200 rounded text-[10px]" id="studioCount_bottoms">5</span>
          </button>
          <button type="button" onclick="selectStudioCategory('footwear')" class="studio-cat-tab px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-mono uppercase tracking-wider font-bold transition-all flex items-center gap-1.5 cursor-pointer" data-cat="footwear">
            <span>👞</span>
            <span>All Shoes &amp; Footwear</span>
            <span class="px-1.5 py-0.2 bg-stone-200 rounded text-[10px]" id="studioCount_footwear">5</span>
          </button>
          <button type="button" onclick="selectStudioCategory('accessories')" class="studio-cat-tab px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-mono uppercase tracking-wider font-bold transition-all flex items-center gap-1.5 cursor-pointer" data-cat="accessories">
            <span>✦</span>
            <span>Accessories &amp; Accents</span>
            <span class="px-1.5 py-0.2 bg-stone-200 rounded text-[10px]" id="studioCount_accessories">3</span>
          </button>
        </div>
      </div>

      <!-- ── 3. WARDROBE CATALOG ITEMS GRID ── -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="studioCatalogGrid">
        <!-- Rendered dynamically by JavaScript with size pills & selection buttons -->
      </div>

    </div>

    <!-- ── 4. FIXED BOTTOM ORDER SUMMARY & CTAS ── -->
    <div class="p-4 sm:p-5 bg-stone-950 text-white border-t border-stone-800 flex flex-col sm:flex-row items-center justify-between gap-4 flex-shrink-0 shadow-2xl">
      <div class="w-full sm:w-auto">
        <div class="text-[10px] font-mono uppercase tracking-widest text-stone-400 mb-0.5">Custom 3-Piece Total (15% Privilege Off):</div>
        <div class="flex items-baseline gap-2 flex-wrap">
          <span class="font-serif text-2xl sm:text-3xl font-extrabold text-[#e9c176]" id="studioTotalPrice">₹12,662</span>
          <span class="line-through text-xs font-mono text-stone-500" id="studioTotalCompare">₹19,997</span>
          <span class="text-xs font-mono text-emerald-400 font-bold bg-emerald-950/80 px-2 py-0.5 rounded border border-emerald-500/30" id="studioTotalSavings">Save ₹7,335</span>
        </div>
        <div class="text-[11px] font-mono text-stone-300 truncate max-w-md mt-1" id="studioSelectionSummary">
          Top: Coat (M) · Pants: Trousers (32) · Shoes: Loafers (UK 8)
        </div>
      </div>

      <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
        <button type="button" onclick="shuffleStudioEnsemble()" class="px-3.5 py-3 rounded-xl border border-white/20 hover:bg-white/10 text-white font-mono text-xs uppercase tracking-wider font-bold transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-sm flex-1 sm:flex-initial" title="Generate Random Chic Mix">
          <span class="material-symbols-outlined text-sm text-amber-400">shuffle</span>
          <span>Shuffle</span>
        </button>
        <button type="button" onclick="applyStudioEnsembleToPage()" class="px-4 py-3 rounded-xl border border-amber-500/40 hover:border-amber-400 bg-amber-500/15 hover:bg-amber-500/25 text-amber-300 font-mono text-xs uppercase tracking-wider font-bold transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-sm flex-1 sm:flex-initial">
          <span class="material-symbols-outlined text-sm">sync</span>
          <span>Apply to Look</span>
        </button>
        <button type="button" onclick="shopStudioEnsemble()" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:opacity-95 text-stone-950 font-button text-xs uppercase tracking-wider font-extrabold transition-all flex items-center justify-center gap-2 cursor-pointer shadow-lg active:scale-98 w-full sm:w-auto">
          <span class="material-symbols-outlined text-base">shopping_bag</span>
          <span id="studioShopBtnText">Shop Custom Ensemble</span>
        </button>
      </div>
    </div>

  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     PRODUCT QUICK VIEW POPUP (INSPECT INDIVIDUAL PIECE)
══════════════════════════════════════════════════════ -->
<div id="atelierProductQuickViewModal" data-lenis-prevent="true" class="fixed inset-0 bg-black/70 backdrop-blur-md z-[140] hidden items-center justify-center p-3 sm:p-6 overflow-y-auto" onclick="if(event.target===this)closeProductQuickViewModal()">
  <div class="bg-white text-stone-900 p-6 sm:p-7 rounded-3xl max-w-lg w-full border border-stone-200 shadow-2xl relative my-auto animate-fade-in">
    <div class="flex items-center justify-between pb-3 mb-4 border-b border-stone-200">
      <div class="inline-flex items-center gap-1.5 text-xs font-mono uppercase font-bold text-[#a16207]">
        <span class="material-symbols-outlined text-sm">visibility</span>
        <span id="apqvCategoryTag">Product Quick View</span>
      </div>
      <button type="button" onclick="closeProductQuickViewModal()" class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center cursor-pointer transition-all hover:scale-105" aria-label="Close">
        <span class="material-symbols-outlined text-sm">close</span>
      </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start mb-4">
      <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-stone-100 border border-stone-200 relative group shadow-sm">
        <img id="apqvImage" src="" alt="Product" class="w-full h-full object-cover transition-all duration-300">
        <span class="absolute top-2 left-2 bg-stone-900/85 text-white text-[8px] font-mono px-2 py-0.5 rounded uppercase font-bold tracking-wider" id="apqvBadge">Atelier Piece</span>
      </div>
      <div class="flex flex-col justify-between space-y-3">
        <div>
          <span class="text-[9px] uppercase font-mono tracking-widest text-[#a16207] font-bold block mb-1">Lumina Atelier</span>
          <h4 id="apqvTitle" class="font-serif font-bold text-base sm:text-lg text-stone-900 leading-snug">Product Title</h4>
          <div class="flex items-baseline gap-2 mt-1.5">
            <span id="apqvPrice" class="font-serif font-bold text-lg text-stone-900">₹0</span>
            <span class="text-[10px] text-emerald-700 font-mono font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">★ 4.9 · In Stock</span>
          </div>
        </div>

        <p class="text-xs text-stone-600 font-light leading-relaxed bg-stone-50 p-2.5 rounded-xl border border-stone-100" id="apqvDesc">
          Crafted with sartorial precision in Japan and Italy using natural double-faced fibers.
        </p>

        <!-- Color Palette (Clickable with Live Image Swapping) -->
        <div>
          <div class="flex justify-between items-center mb-1.5">
            <label class="text-[10px] font-mono uppercase font-bold text-stone-600">Atelier Colorway:</label>
            <span id="apqvSelectedColorLabel" class="text-[10px] font-mono font-bold text-[#a16207]">Default</span>
          </div>
          <div class="flex gap-1.5 items-center flex-wrap" id="apqvColorSwatches">
            <!-- Dynamic Colors -->
          </div>
        </div>

        <!-- Available Sizes (Interactive & Validated) -->
        <div>
          <div class="flex justify-between items-center mb-1.5">
            <label class="text-[10px] font-mono uppercase font-bold text-stone-600">Select Fit / Size:</label>
            <span id="apqvSelectedSizeLabel" class="text-[10px] font-mono font-bold text-[#a16207]">Size M</span>
          </div>
          <div class="flex gap-1.5 flex-wrap" id="apqvSizePills">
            <!-- Dynamic Category Sizes -->
          </div>
          <div id="apqvSizeError" class="text-[10px] text-rose-600 font-mono hidden mt-1">Please select an atelier size first.</div>
        </div>

        <!-- Direct Acquire Piece Button -->
        <div class="pt-2">
          <button type="button" onclick="acquireQuickViewItem()" id="apqvAddToCartBtn" class="w-full py-2.5 bg-stone-950 hover:bg-stone-900 text-white font-mono text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
            <span class="material-symbols-outlined text-sm text-[#e9c176]">shopping_bag</span>
            <span id="apqvAddToCartBtnText">Acquire Piece</span>
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
// ── Global Initializations & State Containers ──
window.BUNDLE_DISCOUNT_TIERS = {
  2: <?= json_encode((float)($home_settings['bundle_discount_2'] ?? 10)) ?>,
  3: <?= json_encode((float)($home_settings['bundle_discount_3'] ?? 15)) ?>
};

window.resolveProductSizes = window.resolveProductSizes || function(item) {
  if (!item) return ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
  const title = (item.title || item.name || '').toLowerCase();
  const cat = (item.category || item.tag || '').toLowerCase();
  
  if (/shoe|boot|sneaker|derby|loafer|footwear|oxford|chelsea/i.test(title) || /footwear|shoe/i.test(cat)) {
    return ['UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11'];
  }
  if (/denim|pant|jean|trouser|chino|short|selvedge|bottom/i.test(title) || /denim|pant|bottom/i.test(cat)) {
    return ['28', '30', '32', '34', '36', '38'];
  }
  return ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
};

let currentAfmProduct = null;
let currentAfmSelectedSize = 'M';
let currentActiveLooks = [];
let currentQuickViewItem = null;
let currentQuickViewSize = 'M';
let currentQuickViewColor = '';

// ════════════════════════════════════════════════════════════
// 1. AI STYLE IDENTITY ARCHETYPES & COMBO ENGINE
// ════════════════════════════════════════════════════════════
const AI_STYLE_ARCHETYPES = {
  business: {
    key: 'business',
    title: 'The Power Executive',
    desc: 'Structured silhouettes with premium suiting fabrics. Signals authority, taste, and effortless confidence.',
    scores: { formality: 92, versatility: 75, trend: 88, luxury: 97 },
    bestFor: ['Board meetings', 'Client dinners', 'Conferences'],
    howToWear: [
      'Tuck the shirt fully and add a slim leather belt at the waist for a sharp silhouette.',
      'Roll trouser hems by one turn to expose the selvedge detail and keep it relaxed.',
      'Leave the top two buttons open for an approachable executive look.'
    ],
    items: [
      { id: 1, title: 'The Atelier Cashmere Cocoon Coat', price: 4399, compare_price: 5999, img: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>', tag: 'Top Wear · 700 GSM', vendor: 'Lumina Atelier' },
      { id: 9, title: 'Italian Pleated Wool Trousers', price: 4999, compare_price: 6499, img: '<?= base_url("img/italian_pleated_trousers.jpg") ?>', tag: 'Bottom Wear · Virgin Wool', vendor: 'Lumina Sartoria' },
      { id: 12, title: 'Burnished Calfskin Penny Loafers', price: 5499, compare_price: 7499, img: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>', tag: 'Footwear · Tuscan Calf', vendor: 'Lumina Calzature' }
    ]
  },
  street: {
    key: 'street',
    title: 'The Monochrome Street Poise',
    desc: 'Substantial 500 GSM loopback cotton paired with heavy selvedge denim and Chelsea boots for bold urban presence.',
    scores: { formality: 58, versatility: 88, trend: 98, luxury: 92 },
    bestFor: ['Creative agencies', 'Travel transit', 'Weekend evenings'],
    howToWear: [
      'Layer the 500 GSM hoodie beneath a structured wool peacoat for heavy thermal drape.',
      'Stack selvedge denim breaks slightly over leather Chelsea boots.',
      'Keep accessories matte black or brushed antique silver.'
    ],
    items: [
      { id: 6, title: 'Sculpted 500 GSM Terry Hoodie', price: 2899, compare_price: 3999, img: '<?= base_url("img/sculpted_terry_hoodie.jpg") ?>', tag: 'Top Wear · 500 GSM', vendor: 'Lumina Atelier' },
      { id: 2, title: 'Okayama 14.5oz Selvedge Denim', price: 4499, compare_price: 5999, img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', tag: 'Bottom Wear · Raw Indigo', vendor: 'Kojima Shuttle' },
      { id: 11, title: 'Handcrafted Italian Chelsea Boots', price: 5999, compare_price: 7999, img: '<?= base_url("img/chelsea_leather_boots.jpg") ?>', tag: 'Footwear · Box Calf', vendor: 'Lumina Calzature' }
    ]
  },
  evening: {
    key: 'evening',
    title: 'The Gala & Red Carpet Radiance',
    desc: 'Fluid grade-6A pure mulberry silk with tailored wool tailoring and burnished dress shoes for evening poise.',
    scores: { formality: 98, versatility: 65, trend: 85, luxury: 99 },
    bestFor: ['Black-tie galas', 'Opera nights', 'Red carpet'],
    howToWear: [
      'Wear unbuttoned tailored peacoat over the silk dress to let pearl luster catch lighting.',
      'Accent with minimal gold jewelry to complement champagne trim.',
      'Keep footwear polished to mirror-shine.'
    ],
    items: [
      { id: 5, title: 'Mulberry Silk Eveningwear', price: 3899, compare_price: 5499, img: '<?= base_url("img/mulberry_silk_dress.jpg") ?>', tag: 'Top Wear · Pure Silk', vendor: 'Lumina Atelier' },
      { id: 4, title: 'Tailored Melton Wool Peacoat', price: 4799, compare_price: 6499, img: '<?= base_url("img/melton_wool_peacoat.jpg") ?>', tag: 'Outerwear · Melton Wool', vendor: 'Lumina Sartoria' },
      { id: 12, title: 'Burnished Calfskin Penny Loafers', price: 5499, compare_price: 7499, img: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>', tag: 'Footwear · Polished Noir', vendor: 'Lumina Calzature' }
    ]
  },
  weekend: {
    key: 'weekend',
    title: 'The Milanese Minimalist',
    desc: 'Clean lines, muted earth tones, and architectural drape. The definitive uniform of modern quiet luxury.',
    scores: { formality: 74, versatility: 96, trend: 92, luxury: 95 },
    bestFor: ['Art gallery openings', 'Weekend brunch', 'Studio visits'],
    howToWear: [
      'Pair tonal oatmeal knitwear with deep indigo denim for natural organic contrast.',
      'Drape coat over shoulders rather than wearing sleeves for effortless street poise.',
      'Complete with matte minimalist suede derby shoes.'
    ],
    items: [
      { id: 8, title: 'Cashmere Turtleneck Knit', price: 2999, compare_price: 4299, img: '<?= base_url("img/cashmere_turtleneck_knit.jpg") ?>', tag: 'Top Wear · Cashmere', vendor: 'Lumina Atelier' },
      { id: 2, title: 'Okayama 14.5oz Selvedge Denim', price: 4499, compare_price: 5999, img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', tag: 'Bottom Wear · Raw Indigo', vendor: 'Kojima Shuttle' },
      { id: 13, title: 'Minimalist Suede Derby Shoes', price: 4899, compare_price: 6499, img: '<?= base_url("img/minimalist_suede_derby.jpg") ?>', tag: 'Footwear · Italian Suede', vendor: 'Lumina Calzature' }
    ]
  },
  athleisure: {
    key: 'athleisure',
    title: 'The Luxury Sartorial Athleisure',
    desc: 'High-density French terry engineered with relaxed cashmere pants and suede derbies for first-class travel.',
    scores: { formality: 50, versatility: 90, trend: 95, luxury: 90 },
    bestFor: ['Private aviation', 'Resort lounges', 'Casual luxury'],
    howToWear: [
      'Keep drawstring concealed inside waistband for a clean streamlined drape.',
      'Pair with a structured luxury weekender bag.',
      'Layer a fine cashmere scarf for brisk morning transit.'
    ],
    items: [
      { id: 6, title: '480GSM French Terry Hoodie', price: 3499, compare_price: 4699, img: '<?= base_url("img/terry_hoodie_luxury.jpg") ?>', tag: 'Top Wear · Heavyweight', vendor: 'Lumina Atelier' },
      { id: 10, title: 'Tailored Cashmere Relaxed Pant', price: 4199, compare_price: 5899, img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', tag: 'Bottom Wear · Cashmere Blend', vendor: 'Lumina Sartoria' },
      { id: 13, title: 'Minimalist Sand Suede Derby Shoes', price: 4899, compare_price: 6499, img: '<?= base_url("img/minimalist_suede_derby.jpg") ?>', tag: 'Footwear · Sand Suede', vendor: 'Lumina Calzature' }
    ]
  }
};

let currentActiveMoodKey = 'business';

window.selectMood = function(moodKey) {
  currentActiveMoodKey = moodKey;
  
  // Highlight active mood button
  document.querySelectorAll('.mood-btn').forEach(btn => {
    if (btn.getAttribute('data-mood') === moodKey) {
      btn.className = 'mood-btn active-mood px-4 py-2 rounded-full bg-black text-white border border-black text-xs font-mono uppercase tracking-wider transition-all shadow-sm font-bold';
    } else {
      btn.className = 'mood-btn px-4 py-2 rounded-full border border-black/15 bg-white text-black text-xs font-mono uppercase tracking-wider transition-all hover:bg-black hover:text-white font-medium';
    }
  });

  const arch = AI_STYLE_ARCHETYPES[moodKey] || AI_STYLE_ARCHETYPES['business'];
  const thinking = document.getElementById('aiThinking');
  if (thinking) {
    thinking.classList.remove('hidden');
    setTimeout(() => {
      thinking.classList.add('hidden');
      renderOutfitCombo(arch);
    }, 250);
  } else {
    renderOutfitCombo(arch);
  }
};

window.renderOutfitCombo = function(arch) {
  if (!arch) return;

  // Title & description
  const tEl = document.getElementById('styleTitle');
  if (tEl) tEl.textContent = arch.title;

  const dEl = document.getElementById('styleDesc');
  if (dEl) dEl.textContent = arch.desc;

  // Progress scores
  ['formality', 'versatility', 'trend', 'luxury'].forEach(k => {
    const val = arch.scores[k] || 85;
    const sEl = document.getElementById('score_' + k);
    const bEl = document.getElementById('bar_' + k);
    if (sEl) sEl.textContent = val + '%';
    if (bEl) bEl.style.width = val + '%';
  });

  // Occasion tags
  const occEl = document.getElementById('occasionTags');
  if (occEl && arch.bestFor) {
    occEl.innerHTML = arch.bestFor.map(tag => `
      <span class="px-2.5 py-1 bg-white/10 text-white/80 text-[10px] rounded-full font-mono border border-white/10">${tag}</span>
    `).join('');
  }

  // Dressing advice
  const howEl = document.getElementById('howToWear');
  if (howEl && arch.howToWear) {
    howEl.innerHTML = arch.howToWear.map(line => `
      <li class="flex gap-2"><span class="text-[#a16207] font-bold mt-0.5">✦</span> <span>${line}</span></li>
    `).join('');
  }
};

// State for AI Style Identity Outfit Archetype
window.outfitItemsState = { 0: true, 1: true, 2: true };
window.outfitItemsSizes = {};

window.toggleOutfitItem = function(idx) {
  window.outfitItemsState[idx] = !window.outfitItemsState[idx];
  updateOutfitComboPricing();
};

window.addSingleOutfitItemToCart = function(idx) {
  const arch = AI_STYLE_ARCHETYPES[currentActiveMoodKey] || AI_STYLE_ARCHETYPES['business'];
  if (!arch || !arch.items || !arch.items[idx]) return;
  const item = arch.items[idx];
  const size = window.outfitItemsSizes[idx] || 'M';

  if (typeof addToCart === 'function') {
    addToCart({
      id: item.id,
      variant_id: item.id,
      product_id: item.id,
      title: item.title,
      price: item.price,
      image: item.img,
      size: size
    }, 1, `✦ Added "${item.title}" (Size ${size}) to Curated Bag!`);
  }
};

window.updateOutfitComboPricing = function() {
  const arch = AI_STYLE_ARCHETYPES[currentActiveMoodKey] || AI_STYLE_ARCHETYPES['business'];
  if (!arch || !arch.items) return;

  let activeCount = 0;
  let subtotal = 0;
  let totalOrig = 0;

  arch.items.forEach((item, idx) => {
    const isInc = !!window.outfitItemsState[idx];
    const cardEl = document.getElementById('outfitItemCard_' + idx);
    const btnEl = document.getElementById('outfitItemToggleBtn_' + idx);
    
    if (cardEl) {
      if (isInc) {
        cardEl.classList.remove('opacity-40', 'grayscale', 'bg-stone-100/60');
        cardEl.classList.add('bg-white');
      } else {
        cardEl.classList.add('opacity-40', 'grayscale', 'bg-stone-100/60');
        cardEl.classList.remove('bg-white');
      }
    }
    if (btnEl) {
      if (isInc) {
        btnEl.className = 'px-1.5 py-0.5 bg-stone-100 hover:bg-rose-50 text-stone-600 hover:text-rose-700 rounded text-[8px] font-mono font-bold flex items-center gap-0.5 border border-stone-200 transition-all cursor-pointer';
        btnEl.innerHTML = '<span class="material-symbols-outlined text-[10px]">close</span><span>Remove</span>';
      } else {
        btnEl.className = 'px-1.5 py-0.5 bg-stone-900 hover:bg-black text-[#e9c176] rounded text-[8px] font-mono font-bold flex items-center gap-0.5 transition-all cursor-pointer shadow-2xs';
        btnEl.innerHTML = '<span class="material-symbols-outlined text-[10px]">add</span><span>Include</span>';
      }
    }

    if (isInc) {
      activeCount++;
      subtotal += item.price;
      totalOrig += (item.compare_price || (item.price * 1.35));
    }
  });

  const discPct = activeCount === 3 ? (window.BUNDLE_DISCOUNT_TIERS[3] || 15) : (activeCount === 2 ? (window.BUNDLE_DISCOUNT_TIERS[2] || 10) : 0);
  const finalPrice = Math.round(subtotal * (1 - discPct / 100));
  const savings = Math.max(0, Math.round(totalOrig - finalPrice));

  const priceEl = document.getElementById('comboTotalPrice');
  const saveEl = document.getElementById('comboTotalSave');
  const ctaBtn = document.querySelector('#comboContainer button[onclick="addComboToCart()"]');

  if (priceEl) {
    priceEl.setAttribute('data-price-inr', finalPrice);
    priceEl.textContent = '₹' + Number(finalPrice).toLocaleString('en-IN');
  }
  if (saveEl) {
    saveEl.innerHTML = `₹${Number(savings).toLocaleString('en-IN')} <span class="text-xs font-mono">(${discPct > 0 ? discPct + '% Pack Privilege' : 'vs. individual retail'})</span>`;
  }
  if (ctaBtn) {
    if (activeCount > 0) {
      ctaBtn.disabled = false;
      ctaBtn.className = 'w-full py-2.5 sm:py-3 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 text-stone-950 text-xs font-button uppercase tracking-wider font-extrabold rounded-xl hover:opacity-90 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-md';
      ctaBtn.innerHTML = `
        <span class="material-symbols-outlined text-sm">shopping_bag</span>
        <span>Shop Pack (${activeCount} ${activeCount === 1 ? 'Piece' : 'Pieces'} · ₹${Number(finalPrice).toLocaleString('en-IN')})</span>
      `;
    } else {
      ctaBtn.disabled = true;
      ctaBtn.className = 'w-full py-2.5 sm:py-3 bg-stone-800 text-stone-500 text-xs font-button uppercase tracking-wider font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2';
      ctaBtn.innerHTML = `<span>Select Pieces Above</span>`;
    }
  }
};

window.renderOutfitCombo = function(arch) {
  if (!arch) return;

  // Title & description
  const tEl = document.getElementById('styleTitle');
  if (tEl) tEl.textContent = arch.title;

  const dEl = document.getElementById('styleDesc');
  if (dEl) dEl.textContent = arch.desc;

  // Progress scores
  ['formality', 'versatility', 'trend', 'luxury'].forEach(k => {
    const val = arch.scores[k] || 85;
    const sEl = document.getElementById('score_' + k);
    const bEl = document.getElementById('bar_' + k);
    if (sEl) sEl.textContent = val + '%';
    if (bEl) bEl.style.width = val + '%';
  });

  // Occasion tags
  const occEl = document.getElementById('occasionTags');
  if (occEl && arch.bestFor) {
    occEl.innerHTML = arch.bestFor.map(tag => `
      <span class="px-2.5 py-1 bg-white/10 text-white/80 text-[10px] rounded-full font-mono border border-white/10">${tag}</span>
    `).join('');
  }

  // Dressing advice
  const howEl = document.getElementById('howToWear');
  if (howEl && arch.howToWear) {
    howEl.innerHTML = arch.howToWear.map(line => `
      <li class="flex gap-2"><span class="text-[#a16207] font-bold mt-0.5">✦</span> <span>${line}</span></li>
    `).join('');
  }

  // Center Outfit Grid
  const gridEl = document.getElementById('outfitItemsGrid');
  window.outfitItemsState = { 0: true, 1: true, 2: true };
  window.outfitItemsSizes = {};

  const catKeys = ['tops', 'bottoms', 'footwear'];
  const catLabels = ['Top Wear', 'Bottom Wear', 'Footwear'];

  if (gridEl && arch.items) {
    gridEl.innerHTML = arch.items.map((item, idx) => {
      const qvData = JSON.stringify({
        id: item.id,
        title: item.title,
        price: item.price,
        compare_price: item.compare_price || 0,
        image: item.img,
        vendor: item.vendor || 'Lumina Atelier',
        description: item.tag || 'Bespoke tailoring piece.'
      }).replace(/"/g, '&quot;');

      const possibleSizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(item) : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
      const defaultSize = window.outfitItemsSizes[idx] || possibleSizes[Math.min(2, possibleSizes.length - 1)];
      window.outfitItemsSizes[idx] = defaultSize;
      const curCatKey = catKeys[idx] || 'tops';
      const curCatLabel = catLabels[idx] || 'Piece';

      return `
        <div id="outfitItemCard_${idx}" class="bg-white border border-stone-200 hover:border-amber-500/70 rounded-xl sm:rounded-2xl p-2.5 sm:p-3.5 flex flex-col justify-between shadow-xs hover:shadow-md transition-all group relative">
          <div>
            <div class="relative aspect-[3/4] rounded-lg sm:rounded-xl overflow-hidden bg-stone-100 mb-2">
              <img src="${item.img}" alt="${item.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              <span class="absolute top-1.5 left-1.5 px-1.5 sm:px-2 py-0.5 rounded bg-black/85 text-[#e9c176] font-mono text-[7.5px] sm:text-[8px] font-bold uppercase backdrop-blur-sm shadow-xs">
                ${item.tag || curCatLabel}
              </span>
              <button type="button" onclick="openQuickView(${qvData})" class="absolute bottom-1.5 right-1.5 w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-white/95 text-stone-900 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow cursor-pointer" title="Quick View">
                <span class="material-symbols-outlined text-[10px] sm:text-xs">visibility</span>
              </button>
            </div>
            
            <div class="flex items-center justify-between gap-1 mb-0.5">
              <span class="text-[8px] sm:text-[9px] font-mono uppercase text-[#a16207] font-bold block truncate">${item.vendor || 'Lumina Atelier'}</span>
              <button type="button" id="outfitItemToggleBtn_${idx}" onclick="toggleOutfitItem(${idx})" class="px-1.5 py-0.5 bg-stone-100 hover:bg-rose-50 text-stone-600 hover:text-rose-700 rounded text-[8px] font-mono font-bold flex items-center gap-0.5 border border-stone-200 transition-all cursor-pointer" title="Toggle item in outfit">
                <span class="material-symbols-outlined text-[10px]">close</span>
                <span>Remove</span>
              </button>
            </div>

            <h4 class="font-serif text-xs sm:text-sm font-bold text-stone-900 truncate mb-1" title="${item.title}">${item.title}</h4>
            
            <div class="flex items-baseline gap-1.5">
              <span class="font-serif font-bold text-xs sm:text-sm text-stone-900" data-price-inr="${item.price}">₹${Number(item.price).toLocaleString('en-IN')}</span>
              ${item.compare_price ? `<span class="font-mono text-[9px] sm:text-[10px] text-stone-400 line-through">₹${Number(item.compare_price).toLocaleString('en-IN')}</span>` : ''}
            </div>

            <!-- Size Selector for this specific item -->
            <div class="flex items-center gap-1 mt-1.5" onclick="event.stopPropagation()">
              <span class="text-[8px] font-mono uppercase text-stone-500 font-bold">Size:</span>
              <div class="relative inline-flex items-center flex-1">
                <select onchange="window.outfitItemsSizes[${idx}] = this.value; if(window.studioEnsembleState && window.studioEnsembleState['${curCatKey}']) window.studioEnsembleState['${curCatKey}'].size = this.value;" class="w-full text-[9.5px] font-mono font-bold bg-stone-100 hover:bg-stone-200 text-stone-900 border border-stone-300 rounded px-1.5 py-0.5 cursor-pointer appearance-none pr-3.5 focus:outline-hidden">
                  ${possibleSizes.map(s => `<option value="${s}" ${s === defaultSize ? 'selected' : ''}>${s}</option>`).join('')}
                </select>
                <span class="material-symbols-outlined text-[10px] text-stone-500 pointer-events-none absolute right-1">expand_more</span>
              </div>
            </div>

            <!-- Swap Piece Button that opens Studio Modal focused on this category -->
            <button type="button" onclick="openEnsembleStudio('${curCatKey}')" class="w-full mt-1.5 py-1 px-1.5 rounded-lg border border-amber-300 bg-amber-50/70 hover:bg-amber-100 text-amber-900 text-[8.5px] sm:text-[9px] font-mono font-bold uppercase tracking-wider flex items-center justify-center gap-1 transition-all cursor-pointer">
              <span class="material-symbols-outlined text-[11px] text-amber-700">swap_horiz</span>
              <span>Swap ${curCatLabel}</span>
            </button>

          </div>

          <div class="pt-2 sm:pt-2.5 mt-1.5 sm:mt-2 border-t border-stone-100">
            <button type="button" onclick="addSingleOutfitItemToCart(${idx})" class="w-full py-1.5 sm:py-2 bg-stone-950 hover:bg-stone-800 text-white font-mono text-[8.5px] sm:text-[9px] uppercase font-bold rounded-lg transition-all flex items-center justify-center gap-1 cursor-pointer">
              <span class="material-symbols-outlined text-[10px] sm:text-[11px]">shopping_bag</span>
              <span>Add Piece</span>
            </button>
          </div>
        </div>
      `;
    }).join('');
  }

  updateOutfitComboPricing();
};

window.shuffleOutfit = function() {
  const keys = Object.keys(AI_STYLE_ARCHETYPES);
  const nextIdx = (keys.indexOf(currentActiveMoodKey) + 1) % keys.length;
  selectMood(keys[nextIdx]);
};

window.addComboToCart = function() {
  const arch = AI_STYLE_ARCHETYPES[currentActiveMoodKey] || AI_STYLE_ARCHETYPES['business'];
  if (!arch || !arch.items) return;

  const activeItems = [];
  arch.items.forEach((it, idx) => {
    if (window.outfitItemsState[idx]) {
      const chosenSize = window.outfitItemsSizes[idx] || 'M';
      activeItems.push({
        id: it.id,
        variant_id: it.id,
        product_id: it.id,
        title: it.title,
        price: it.price,
        image: it.img,
        size: chosenSize,
        color: ''
      });
    }
  });

  if (!activeItems.length) {
    if (typeof ndToast === 'function') ndToast('Please include at least 1 item in the outfit.', 'error');
    return;
  }

  const count = activeItems.length;
  const discPct = count === 3 ? (window.BUNDLE_DISCOUNT_TIERS[3] || 15) : (count === 2 ? (window.BUNDLE_DISCOUNT_TIERS[2] || 10) : 0);

  activeItems.forEach((it, idx) => {
    setTimeout(() => {
      addToCart(it, 1, idx === activeItems.length - 1 ? `✦ Added ${count}-Piece Pack (${arch.title}) to Bag with ${discPct}% Privilege!` : false);
    }, idx * 120);
  });

  setTimeout(() => {
    if (typeof toggleQuickBagDrawer === 'function') {
      const overlay = document.getElementById('quickBagOverlay');
      if (overlay && overlay.classList.contains('hidden')) {
        toggleQuickBagDrawer();
      }
    }
  }, (activeItems.length * 120) + 300);
};

// Auto-run initial mood curation immediately
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => selectMood('business'));
} else {
  selectMood('business');
}

// ════════════════════════════════════════════════════════════
// 2. BESPOKE ATELIER ENSEMBLE STUDIO & MULTI-PIECE WARDROBE ENGINE
// ════════════════════════════════════════════════════════════

// Complete Multi-Piece Catalog with Realistic Luxury Apparel, Pants, Shoes, and Accessories
const ATELIER_STUDIO_CATALOG = {
  tops: [
    {
      id: 1,
      title: 'The Atelier Cashmere Cocoon Coat',
      price: 4399,
      compare_price: 5999,
      img: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>',
      tag: '700 GSM Mongolian Cashmere',
      vendor: 'Lumina Atelier',
      category: 'tops',
      desc: 'Double-faced 700 GSM Mongolian cashmere unlined for featherweight drape with horn buttons.'
    },
    {
      id: 6,
      title: 'Sculpted 500 GSM Terry Hoodie',
      price: 2899,
      compare_price: 3999,
      img: '<?= base_url("img/sculpted_terry_hoodie.jpg") ?>',
      tag: '500 GSM Loopback French Terry',
      vendor: 'Lumina Atelier',
      category: 'tops',
      desc: 'Architectural dropped shoulder drape engineered in ultra-dense combed cotton.'
    },
    {
      id: 5,
      title: 'Mulberry Silk Eveningwear Shirt',
      price: 3899,
      compare_price: 5499,
      img: '<?= base_url("img/mulberry_silk_dress.jpg") ?>',
      tag: 'Grade-6A Pure Mulberry Silk',
      vendor: 'Lumina Atelier',
      category: 'tops',
      desc: 'Continuous filament silk with concealed mother-of-pearl placket and liquid sheen.'
    },
    {
      id: 8,
      title: 'Cashmere Turtleneck Knit',
      price: 2999,
      compare_price: 4299,
      img: '<?= base_url("img/cashmere_turtleneck_knit.jpg") ?>',
      tag: '100% Cashmere Knitwear',
      vendor: 'Lumina Atelier',
      category: 'tops',
      desc: 'Seamless 12-gauge knit with ribbed neck contour and natural thermo-regulation.'
    },
    {
      id: 4,
      title: 'Tailored Melton Wool Peacoat',
      price: 4799,
      compare_price: 6499,
      img: '<?= base_url("img/melton_wool_peacoat.jpg") ?>',
      tag: '850 GSM Melton Wool',
      vendor: 'Lumina Sartoria',
      category: 'tops',
      desc: 'Structured double-breasted naval peacoat woven in Biella with pick lapel stitch.'
    },
    {
      id: 7,
      title: 'Oversized Heavyweight Atelier Tee',
      price: 1499,
      compare_price: 2299,
      img: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>',
      tag: '240 GSM Combed Jersey',
      vendor: 'Lumina Street',
      category: 'tops',
      desc: 'Pre-shrunk vintage combed cotton with relaxed rib collar and boxy cut.'
    },
    {
      id: 14,
      title: 'Double-Breasted Sartorial Blazer',
      price: 5299,
      compare_price: 7499,
      img: '<?= base_url("img/melton_wool_peacoat.jpg") ?>',
      tag: 'Italian Super 130s Wool',
      vendor: 'Lumina Sartoria',
      category: 'tops',
      desc: 'Full canvas floating chest construction with hand-finished peak lapels.'
    },
    {
      id: 15,
      title: 'Giza Cotton Poplin Overshirt',
      price: 2599,
      compare_price: 3699,
      img: '<?= base_url("img/mulberry_silk_dress.jpg") ?>',
      tag: '120/2 Long-Staple Giza',
      vendor: 'Lumina Sartoria',
      category: 'tops',
      desc: 'Silky smooth Egyptian Giza cotton with tailored square hem and chest pockets.'
    }
  ],
  bottoms: [
    {
      id: 9,
      title: 'Italian Pleated Wool Trousers',
      price: 4999,
      compare_price: 6499,
      img: '<?= base_url("img/italian_pleated_trousers.jpg") ?>',
      tag: 'Virgin Wool · Double Pleat',
      vendor: 'Lumina Sartoria',
      category: 'bottoms',
      desc: 'High-rise forward double pleats with brass side adjusters and 2-inch cuffs.'
    },
    {
      id: 2,
      title: 'Okayama 14.5oz Raw Selvedge Denim',
      price: 4499,
      compare_price: 5999,
      img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>',
      tag: '14.5oz Shuttle Loom Denim',
      vendor: 'Kojima Shuttle',
      category: 'bottoms',
      desc: 'Rope-dyed botanical indigo with pink line ID ticker and custom copper rivets.'
    },
    {
      id: 10,
      title: 'Tailored Cashmere Relaxed Pant',
      price: 4199,
      compare_price: 5899,
      img: '<?= base_url("img/italian_pleated_trousers.jpg") ?>',
      tag: 'Cashmere Blend · Drawstring',
      vendor: 'Lumina Sartoria',
      category: 'bottoms',
      desc: 'Concealed inner drawstring waistband tailored in brushed cashmere blend.'
    },
    {
      id: 16,
      title: 'Wide-Leg Gurkha Sartorial Trousers',
      price: 4799,
      compare_price: 6299,
      img: '<?= base_url("img/italian_pleated_trousers.jpg") ?>',
      tag: 'High-Rise Gurkha Wool',
      vendor: 'Lumina Sartoria',
      category: 'bottoms',
      desc: 'Traditional double-buckle crossover waistband in heavyweight wool gabardine.'
    },
    {
      id: 17,
      title: 'Heavy Cotton Carpenter Trousers',
      price: 3799,
      compare_price: 4999,
      img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>',
      tag: '380 GSM Duck Canvas',
      vendor: 'Lumina Street',
      category: 'bottoms',
      desc: 'Triple-stitched utility seams with brass hardware and relaxed straight break.'
    }
  ],
  footwear: [
    {
      id: 12,
      title: 'Burnished Calfskin Penny Loafers',
      price: 5499,
      compare_price: 7499,
      img: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>',
      tag: 'Tuscan Full-Grain Calf',
      vendor: 'Lumina Calzature',
      category: 'footwear',
      desc: 'Hand-burnished apron stitch with Goodyear-welted leather soles and leather lining.'
    },
    {
      id: 11,
      title: 'Handcrafted Italian Chelsea Boots',
      price: 5999,
      compare_price: 7999,
      img: '<?= base_url("img/chelsea_leather_boots.jpg") ?>',
      tag: 'Box Calf Leather',
      vendor: 'Lumina Calzature',
      category: 'footwear',
      desc: 'Full box calf leather with tonal elasticated side gussets and beveled waist.'
    },
    {
      id: 13,
      title: 'Minimalist Suede Derby Shoes',
      price: 4899,
      compare_price: 6499,
      img: '<?= base_url("img/minimalist_suede_derby.jpg") ?>',
      tag: 'Italian Velour Suede',
      vendor: 'Lumina Calzature',
      category: 'footwear',
      desc: 'Ultra-soft Italian split suede on lightweight natural crepe rubber outsoles.'
    },
    {
      id: 18,
      title: 'Polished Noir Double Monkstraps',
      price: 5799,
      compare_price: 7899,
      img: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>',
      tag: 'French Box Calf',
      vendor: 'Lumina Calzature',
      category: 'footwear',
      desc: 'Hand-patinated mirror shine with brushed antique nickel buckles.'
    },
    {
      id: 19,
      title: 'Vibram Low Court Leather Sneakers',
      price: 4699,
      compare_price: 6199,
      img: '<?= base_url("img/minimalist_suede_derby.jpg") ?>',
      tag: 'Nappa Leather · Vibram Sole',
      vendor: 'Lumina Calzature',
      category: 'footwear',
      desc: 'Italian full-grain Nappa leather upper on a durable Vibram cupsole.'
    }
  ],
  accessories: [
    {
      id: 20,
      title: 'Full-Grain Bridle Leather Dress Belt',
      price: 1899,
      compare_price: 2699,
      img: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>',
      tag: 'English Bridle Leather',
      vendor: 'Lumina Pelletteria',
      category: 'accessories',
      desc: 'Vegetable-tanned English bridle leather with solid brass buckle.'
    },
    {
      id: 21,
      title: 'Mulberry Silk Pocket Square & Scarf',
      price: 1499,
      compare_price: 2199,
      img: '<?= base_url("img/mulberry_silk_dress.jpg") ?>',
      tag: '100% Mulberry Silk',
      vendor: 'Lumina Atelier',
      category: 'accessories',
      desc: 'Hand-rolled edges with geometric atelier monogram print.'
    },
    {
      id: 22,
      title: 'Saffiano Leather Weekender Bag',
      price: 6499,
      compare_price: 8999,
      img: '<?= base_url("img/chelsea_leather_boots.jpg") ?>',
      tag: 'Textured Saffiano Leather',
      vendor: 'Lumina Pelletteria',
      category: 'accessories',
      desc: 'Scratch and water-resistant textured leather with dual interior compartments.'
    }
  ]
};

// Active Custom Ensemble State (3 Slots)
window.studioEnsembleState = {
  tops: {
    item: ATELIER_STUDIO_CATALOG.tops[0],
    size: 'M'
  },
  bottoms: {
    item: ATELIER_STUDIO_CATALOG.bottoms[0],
    size: '32'
  },
  footwear: {
    item: ATELIER_STUDIO_CATALOG.footwear[0],
    size: 'UK 8'
  }
};

// Item-specific sizes chosen by client across the entire catalog
window.studioSelectedSizes = {};

// Active Category Tab in Studio ('tops', 'bottoms', 'footwear', 'accessories')
window.currentStudioCategory = 'tops';

// ── Open the Bespoke Ensemble Studio Modal ──
window.openEnsembleStudio = function(focusCategory) {
  // Sync state from active homepage archetype if available
  const arch = AI_STYLE_ARCHETYPES[currentActiveMoodKey] || AI_STYLE_ARCHETYPES['business'];
  if (arch && arch.items && arch.items.length >= 3) {
    if (!window.studioEnsembleState.tops.item || window.studioEnsembleState.tops.item.id !== arch.items[0].id) {
      window.studioEnsembleState.tops.item = arch.items[0];
      window.studioEnsembleState.tops.size = window.outfitItemsSizes[0] || 'M';
    }
    if (!window.studioEnsembleState.bottoms.item || window.studioEnsembleState.bottoms.item.id !== arch.items[1].id) {
      window.studioEnsembleState.bottoms.item = arch.items[1];
      window.studioEnsembleState.bottoms.size = window.outfitItemsSizes[1] || '32';
    }
    if (!window.studioEnsembleState.footwear.item || window.studioEnsembleState.footwear.item.id !== arch.items[2].id) {
      window.studioEnsembleState.footwear.item = arch.items[2];
      window.studioEnsembleState.footwear.size = window.outfitItemsSizes[2] || 'UK 8';
    }
  }

  // Set active category tab
  const validCats = ['tops', 'bottoms', 'footwear', 'accessories'];
  const targetCat = (validCats.includes(focusCategory)) ? focusCategory : 'tops';

  // Render top stage slots
  renderStudioStageSlots();

  // Switch to target category & render items
  selectStudioCategory(targetCat);

  // Update live pricing HUD
  updateStudioPricing();

  // Show modal smoothly
  const modal = document.getElementById('ensembleStudioModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    if (window.lenisInstance && typeof window.lenisInstance.stop === 'function') {
      window.lenisInstance.stop();
    }
  }
};

// ── Close Ensemble Studio Modal ──
window.closeEnsembleStudio = function() {
  const modal = document.getElementById('ensembleStudioModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    if (window.lenisInstance && typeof window.lenisInstance.start === 'function') {
      window.lenisInstance.start();
    }
  }
};

// ── Render 3 Active Stage Slots at Top of Studio ──
window.renderStudioStageSlots = function() {
  const container = document.getElementById('studioStageSlots');
  if (!container) return;

  const slots = [
    { key: 'tops', label: '1. Top Wear / Clothes', icon: 'checkroom' },
    { key: 'bottoms', label: '2. Bottom Wear / Pants', icon: 'styler' },
    { key: 'footwear', label: '3. Footwear / Shoes', icon: 'steps' }
  ];

  container.innerHTML = slots.map(slot => {
    const data = window.studioEnsembleState[slot.key];
    const item = data ? data.item : null;
    const size = data ? data.size : 'M';
    if (!item) return '';

    const possibleSizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(item) : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

    return `
      <div class="bg-white/10 hover:bg-white/15 border border-white/15 rounded-xl p-3 flex flex-col justify-between transition-all group/slot shadow-sm">
        <div>
          <div class="flex items-center justify-between gap-1 mb-1.5 pb-1.5 border-b border-white/10">
            <span class="text-[9px] font-mono uppercase tracking-widest text-[#e9c176] font-bold flex items-center gap-1">
              <span class="material-symbols-outlined text-xs">${slot.icon}</span>
              <span>${slot.label}</span>
            </span>
            <span class="px-2 py-0.5 rounded-full bg-amber-400 text-stone-950 font-mono text-[9px] font-extrabold shadow-xs">
              Size ${size}
            </span>
          </div>

          <div class="flex items-center gap-2.5">
            <img src="${item.img || item.image}" alt="${item.title}" class="w-14 h-16 sm:w-16 sm:h-20 object-cover rounded-lg border border-white/20 bg-stone-900 flex-shrink-0">
            <div class="min-w-0 flex-1">
              <span class="text-[8px] font-mono uppercase text-white/60 block truncate">${item.vendor || 'Lumina Atelier'}</span>
              <h4 class="font-serif text-xs sm:text-sm font-bold text-white truncate" title="${item.title}">${item.title}</h4>
              <div class="flex items-baseline gap-1.5 mt-0.5">
                <span class="font-serif font-bold text-xs sm:text-sm text-[#e9c176]">₹${Number(item.price).toLocaleString('en-IN')}</span>
                ${item.compare_price ? `<span class="text-[9px] font-mono text-white/40 line-through">₹${Number(item.compare_price).toLocaleString('en-IN')}</span>` : ''}
              </div>

              <!-- Quick Size Switcher inside Slot Card -->
              <div class="flex items-center gap-1 mt-1.5">
                <span class="text-[8px] font-mono uppercase text-white/60 font-bold">Fit:</span>
                <select onchange="setStudioSlotSize('${slot.key}', this.value)" class="text-[9px] font-mono font-bold bg-white/10 text-white border border-white/20 rounded px-1.5 py-0.5 cursor-pointer appearance-none focus:outline-hidden">
                  ${possibleSizes.map(s => `<option value="${s}" ${s === size ? 'selected' : ''} class="bg-stone-900 text-white">${s}</option>`).join('')}
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-2 pt-2 border-t border-white/10">
          <button type="button" onclick="selectStudioCategory('${slot.key}')" class="w-full py-1 bg-white/10 hover:bg-amber-400 hover:text-stone-950 text-white font-mono text-[9px] uppercase font-bold rounded-lg transition-all flex items-center justify-center gap-1 cursor-pointer">
            <span class="material-symbols-outlined text-[11px]">swap_horiz</span>
            <span>Change Piece</span>
          </button>
        </div>
      </div>
    `;
  }).join('');
};

// ── Select Category Tab in Studio Modal ──
window.selectStudioCategory = function(catKey) {
  window.currentStudioCategory = catKey;

  // Update tab buttons styling
  document.querySelectorAll('.studio-cat-tab').forEach(tab => {
    if (tab.getAttribute('data-cat') === catKey) {
      tab.className = 'studio-cat-tab active-tab px-4 py-2.5 rounded-xl border-2 border-stone-950 bg-stone-950 text-white text-xs font-mono uppercase tracking-wider font-bold transition-all shadow-sm flex items-center gap-1.5 cursor-pointer';
    } else {
      tab.className = 'studio-cat-tab px-4 py-2.5 rounded-xl border border-stone-200 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-mono uppercase tracking-wider font-bold transition-all flex items-center gap-1.5 cursor-pointer';
    }
  });

  const items = ATELIER_STUDIO_CATALOG[catKey] || [];
  const countEl = document.getElementById('studioCategoryCount');
  if (countEl) countEl.textContent = `${items.length} styles available`;

  // Render wardrobe grid for this category
  const grid = document.getElementById('studioCatalogGrid');
  if (!grid) return;

  const activeSlotItem = window.studioEnsembleState[catKey] ? window.studioEnsembleState[catKey].item : null;

  grid.innerHTML = items.map(item => {
    const isSelected = activeSlotItem && activeSlotItem.id === item.id;
    const possibleSizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(item) : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
    
    // Check if client selected a custom size for this item
    const savedSize = window.studioSelectedSizes[item.id] || (isSelected && window.studioEnsembleState[catKey] ? window.studioEnsembleState[catKey].size : possibleSizes[Math.min(2, possibleSizes.length - 1)]);
    window.studioSelectedSizes[item.id] = savedSize;

    const slotLabel = catKey === 'tops' ? 'Top Wear' : (catKey === 'bottoms' ? 'Bottom Wear' : (catKey === 'footwear' ? 'Footwear' : 'Ensemble'));

    return `
      <div id="studioCard_${item.id}" class="bg-white border ${isSelected ? 'border-2 border-amber-500 ring-2 ring-amber-400/20 shadow-md' : 'border-stone-200 hover:border-amber-400/70 shadow-xs'} rounded-2xl p-3.5 flex flex-col justify-between transition-all group">
        <div>
          <div class="relative aspect-[3/4] rounded-xl overflow-hidden bg-stone-100 mb-2.5">
            <img src="${item.img}" alt="${item.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <span class="absolute top-2 left-2 px-2 py-0.5 rounded bg-black/85 text-[#e9c176] font-mono text-[8px] font-bold uppercase backdrop-blur-sm shadow-xs">
              ${item.tag}
            </span>
            ${isSelected ? `
              <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full bg-amber-400 text-stone-950 font-mono text-[8px] font-extrabold uppercase shadow flex items-center gap-1">
                <span class="material-symbols-outlined text-[10px]">check</span>
                <span>Active</span>
              </span>
            ` : ''}
          </div>

          <div class="flex items-center justify-between gap-1 mb-1">
            <span class="text-[9px] font-mono uppercase text-[#a16207] font-bold block truncate">${item.vendor || 'Lumina Atelier'}</span>
            <span class="text-[9px] font-mono text-stone-400">★ 4.9</span>
          </div>

          <h4 class="font-serif text-sm font-bold text-stone-900 leading-snug mb-1" title="${item.title}">${item.title}</h4>
          
          <div class="flex items-baseline gap-2 mb-2">
            <span class="font-serif font-bold text-base text-stone-950">₹${Number(item.price).toLocaleString('en-IN')}</span>
            ${item.compare_price ? `<span class="font-mono text-xs text-stone-400 line-through">₹${Number(item.compare_price).toLocaleString('en-IN')}</span>` : ''}
          </div>

          <p class="text-[11px] text-stone-500 font-light leading-relaxed mb-3 line-clamp-2">${item.desc}</p>

          <!-- Interactive Size Selector Pills on Every Piece -->
          <div class="mb-3">
            <div class="flex items-center justify-between mb-1">
              <span class="text-[9px] font-mono uppercase text-stone-600 font-bold">Select Size:</span>
              <span class="text-[9.5px] font-mono font-bold text-[#a16207]" id="studioSizeLabel_${item.id}">Size ${savedSize}</span>
            </div>
            <div class="flex gap-1 flex-wrap">
              ${possibleSizes.map(sz => {
                const isActive = (sz === savedSize);
                return `
                  <button type="button" onclick="setStudioItemSize('${catKey}', ${item.id}, '${sz}')" class="px-2 py-1 rounded-md text-[9px] font-mono font-bold transition-all cursor-pointer ${isActive ? 'border border-amber-500 bg-amber-50 text-amber-900 shadow-2xs font-extrabold' : 'border border-stone-200 bg-stone-50 hover:bg-stone-100 text-stone-700'}">
                    ${sz}
                  </button>
                `;
              }).join('')}
            </div>
          </div>
        </div>

        <div class="pt-2 border-t border-stone-100">
          ${isSelected ? `
            <button type="button" class="w-full py-2.5 rounded-xl bg-amber-500/15 border border-amber-400 text-amber-900 font-mono text-xs uppercase font-extrabold transition-all flex items-center justify-center gap-1.5 shadow-2xs cursor-default">
              <span class="material-symbols-outlined text-sm text-amber-600">check_circle</span>
              <span>✓ Selected for ${slotLabel}</span>
            </button>
          ` : `
            <button type="button" onclick="selectStudioPiece('${catKey}', ${item.id})" class="w-full py-2.5 rounded-xl bg-stone-950 hover:bg-stone-800 text-white font-mono text-xs uppercase font-bold transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-sm active:scale-98">
              <span class="material-symbols-outlined text-sm text-[#e9c176]">add_circle</span>
              <span>Select as ${slotLabel}</span>
            </button>
          `}
        </div>
      </div>
    `;
  }).join('');
};

// ── Select an Item for the Active Slot in the Ensemble ──
window.selectStudioPiece = function(catKey, itemId) {
  const items = ATELIER_STUDIO_CATALOG[catKey] || [];
  const item = items.find(it => it.id === itemId);
  if (!item) return;

  const chosenSize = window.studioSelectedSizes[itemId] || 'M';

  if (catKey === 'accessories') {
    // If accessory, add directly to bag or inform client
    if (typeof addToCart === 'function') {
      addToCart({
        id: item.id,
        variant_id: item.id,
        product_id: item.id,
        title: item.title,
        price: item.price,
        image: item.img,
        size: chosenSize
      }, 1, `✦ Added Accessory "${item.title}" to Bag!`);
    }
    return;
  }

  // Set this item as the active garment in this slot
  window.studioEnsembleState[catKey] = {
    item: item,
    size: chosenSize
  };

  // Re-render stage slots at the top
  renderStudioStageSlots();

  // Re-render catalog cards to update active button states
  selectStudioCategory(catKey);

  // Update total pricing HUD
  updateStudioPricing();

  if (typeof ndToast === 'function') {
    ndToast(`✦ Swapped ${catKey === 'tops' ? 'Top' : (catKey === 'bottoms' ? 'Bottom' : 'Footwear')} to "${item.title}" (Size ${chosenSize})!`, 'success');
  }
};

// ── Update Item Size from Card ──
window.setStudioItemSize = function(catKey, itemId, size) {
  window.studioSelectedSizes[itemId] = size;

  // Update label on card
  const labelEl = document.getElementById(`studioSizeLabel_${itemId}`);
  if (labelEl) labelEl.textContent = `Size ${size}`;

  // If this item is currently active in the slot, update slot size too
  if (window.studioEnsembleState[catKey] && window.studioEnsembleState[catKey].item && window.studioEnsembleState[catKey].item.id === itemId) {
    window.studioEnsembleState[catKey].size = size;
    renderStudioStageSlots();
    updateStudioPricing();
  }

  // Refresh active size pill highlights on that card
  const card = document.getElementById(`studioCard_${itemId}`);
  if (card) {
    selectStudioCategory(catKey);
  }
};

// ── Update Slot Size from Stage Dropdown ──
window.setStudioSlotSize = function(catKey, size) {
  if (window.studioEnsembleState[catKey]) {
    window.studioEnsembleState[catKey].size = size;
    const item = window.studioEnsembleState[catKey].item;
    if (item) {
      window.studioSelectedSizes[item.id] = size;
    }
    renderStudioStageSlots();
    selectStudioCategory(window.currentStudioCategory || 'tops');
    updateStudioPricing();
  }
};

// ── Update Studio Live Pricing HUD ──
window.updateStudioPricing = function() {
  const top = window.studioEnsembleState.tops ? window.studioEnsembleState.tops.item : null;
  const bottom = window.studioEnsembleState.bottoms ? window.studioEnsembleState.bottoms.item : null;
  const footwear = window.studioEnsembleState.footwear ? window.studioEnsembleState.footwear.item : null;

  let subtotal = 0;
  let totalCompare = 0;
  let count = 0;

  if (top) {
    subtotal += top.price;
    totalCompare += (top.compare_price || (top.price * 1.35));
    count++;
  }
  if (bottom) {
    subtotal += bottom.price;
    totalCompare += (bottom.compare_price || (bottom.price * 1.35));
    count++;
  }
  if (footwear) {
    subtotal += footwear.price;
    totalCompare += (footwear.compare_price || (footwear.price * 1.35));
    count++;
  }

  const discPct = count === 3 ? (window.BUNDLE_DISCOUNT_TIERS[3] || 15) : (count === 2 ? (window.BUNDLE_DISCOUNT_TIERS[2] || 10) : 0);
  const finalPrice = Math.round(subtotal * (1 - discPct / 100));
  const savings = Math.max(0, Math.round(totalCompare - finalPrice));

  const priceEl = document.getElementById('studioTotalPrice');
  const compEl = document.getElementById('studioTotalCompare');
  const saveEl = document.getElementById('studioTotalSavings');
  const summaryEl = document.getElementById('studioSelectionSummary');
  const btnTextEl = document.getElementById('studioShopBtnText');

  if (priceEl) priceEl.textContent = `₹${Number(finalPrice).toLocaleString('en-IN')}`;
  if (compEl) compEl.textContent = `₹${Number(totalCompare).toLocaleString('en-IN')}`;
  if (saveEl) saveEl.textContent = `Save ₹${Number(savings).toLocaleString('en-IN')} (${discPct}% Privilege)`;

  if (summaryEl) {
    const topSz = window.studioEnsembleState.tops ? window.studioEnsembleState.tops.size : 'M';
    const btmSz = window.studioEnsembleState.bottoms ? window.studioEnsembleState.bottoms.size : '32';
    const footSz = window.studioEnsembleState.footwear ? window.studioEnsembleState.footwear.size : 'UK 8';

    summaryEl.textContent = `Top: ${top ? top.title.split(' ')[0] + '... (' + topSz + ')' : 'None'} · Pants: ${bottom ? bottom.title.split(' ')[0] + '... (' + btmSz + ')' : 'None'} · Shoes: ${footwear ? footwear.title.split(' ')[0] + '... (' + footSz + ')' : 'None'}`;
  }

  if (btnTextEl) {
    btnTextEl.textContent = `Shop Custom Ensemble (${count} Pieces · ₹${Number(finalPrice).toLocaleString('en-IN')})`;
  }
};

// ── Shop Custom Ensemble (Add All 3 Custom Pieces to Bag with Custom Sizes) ──
window.shopStudioEnsemble = function() {
  const itemsToAdd = [];

  ['tops', 'bottoms', 'footwear'].forEach(k => {
    const slot = window.studioEnsembleState[k];
    if (slot && slot.item) {
      itemsToAdd.push({
        id: slot.item.id,
        variant_id: slot.item.id,
        product_id: slot.item.id,
        title: slot.item.title,
        price: slot.item.price,
        image: slot.item.img || slot.item.image,
        size: slot.size || 'M',
        color: ''
      });
    }
  });

  if (!itemsToAdd.length) {
    if (typeof ndToast === 'function') ndToast('Please select pieces for your ensemble.', 'error');
    return;
  }

  const count = itemsToAdd.length;
  const discPct = count === 3 ? (window.BUNDLE_DISCOUNT_TIERS[3] || 15) : (count === 2 ? (window.BUNDLE_DISCOUNT_TIERS[2] || 10) : 0);

  itemsToAdd.forEach((it, idx) => {
    setTimeout(() => {
      addToCart(it, 1, idx === itemsToAdd.length - 1 ? `✦ Added Custom ${count}-Piece Ensemble to Bag with ${discPct}% Privilege!` : false);
    }, idx * 120);
  });

  closeEnsembleStudio();

  setTimeout(() => {
    if (typeof toggleQuickBagDrawer === 'function') {
      const overlay = document.getElementById('quickBagOverlay');
      if (overlay && overlay.classList.contains('hidden')) {
        toggleQuickBagDrawer();
      }
    }
  }, (itemsToAdd.length * 120) + 300);
};

// ── Apply Custom Studio Ensemble to Homepage Look Cards ──
window.applyStudioEnsembleToPage = function() {
  const arch = AI_STYLE_ARCHETYPES[currentActiveMoodKey] || AI_STYLE_ARCHETYPES['business'];
  if (!arch) return;

  if (window.studioEnsembleState.tops && window.studioEnsembleState.tops.item) {
    arch.items[0] = window.studioEnsembleState.tops.item;
    window.outfitItemsSizes[0] = window.studioEnsembleState.tops.size || 'M';
  }
  if (window.studioEnsembleState.bottoms && window.studioEnsembleState.bottoms.item) {
    arch.items[1] = window.studioEnsembleState.bottoms.item;
    window.outfitItemsSizes[1] = window.studioEnsembleState.bottoms.size || '32';
  }
  if (window.studioEnsembleState.footwear && window.studioEnsembleState.footwear.item) {
    arch.items[2] = window.studioEnsembleState.footwear.item;
    window.outfitItemsSizes[2] = window.studioEnsembleState.footwear.size || 'UK 8';
  }

  closeEnsembleStudio();

  // Re-render homepage grid
  renderOutfitCombo(arch);

  if (typeof ndToast === 'function') {
    ndToast('✦ Custom 3-Piece Ensemble Applied to AI Look!', 'success');
  }

  // Smooth scroll to outfit builder section
  const comboEl = document.getElementById('comboContainer');
  if (comboEl) {
    comboEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
};

// ── Shuffle Studio Ensemble (AI-Curated Random Mix) ──
window.shuffleStudioEnsemble = function() {
  const tops = ATELIER_STUDIO_CATALOG.tops;
  const bottoms = ATELIER_STUDIO_CATALOG.bottoms;
  const footwear = ATELIER_STUDIO_CATALOG.footwear;

  const randTop = tops[Math.floor(Math.random() * tops.length)];
  const randBottom = bottoms[Math.floor(Math.random() * bottoms.length)];
  const randFoot = footwear[Math.floor(Math.random() * footwear.length)];

  window.studioEnsembleState.tops = { item: randTop, size: 'M' };
  window.studioEnsembleState.bottoms = { item: randBottom, size: '32' };
  window.studioEnsembleState.footwear = { item: randFoot, size: 'UK 8' };

  renderStudioStageSlots();
  selectStudioCategory(window.currentStudioCategory || 'tops');
  updateStudioPricing();

  if (typeof ndToast === 'function') {
    ndToast('✦ Curated a fresh bespoke ensemble mix!', 'info');
  }
};

// Legacy Compatibility Aliases
window.openAtelierFitModal = function(prodData) {
  openEnsembleStudio('tops');
};
window.closeAtelierFitModal = function() {
  closeEnsembleStudio();
};

// ── Dynamic Bundle Discount Configuration Linked to Admin Settings ──
window.BUNDLE_DISCOUNT_TIERS = {
  2: <?= json_encode((float)($home_settings['bundle_discount_2'] ?? 10)) ?>,
  3: <?= json_encode((float)($home_settings['bundle_discount_3'] ?? 15)) ?>
};

// ── Global Category-Accurate Size Resolver ──
window.resolveProductSizes = function(item) {
  if (!item) return ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
  const title = (item.title || item.name || '').toLowerCase();
  const cat = (item.category || item.tag || '').toLowerCase();
  
  if (/shoe|boot|sneaker|derby|loafer|footwear|oxford|chelsea/i.test(title) || /footwear|shoe/i.test(cat)) {
    return ['UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11'];
  }
  if (/denim|pant|jean|trouser|chino|short|selvedge|bottom/i.test(title) || /denim|pant|bottom/i.test(cat)) {
    return ['28', '30', '32', '34', '36', '38'];
  }
  return ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
};

// ── Horizontal Scroll Helper ──
window.scrollAfmEnsembles = function(dir) {
  const container = document.getElementById('afmEnsembleContainer');
  if (container) {
    container.scrollBy({ left: dir * 360, behavior: 'smooth' });
  }
};

// ── Material Architecture & Fabric Provenance Studio Switcher ──
const PROVENANCE_FABRICS = [
  {
    origin: 'Biella, Northern Italy',
    name: 'Double-Faced Mongolian Cashmere',
    desc: 'Micro-combed 14.5μ baby capra fibers unlined for weightless thermal insulation and fluid drape.',
    img: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>',
    density: '700 GSM · Ultra-Heavy',
    densityPct: 95,
    drape: '99% Fluid Drape',
    drapePct: 99,
    breath: 'Optimal Thermo-Regulation',
    breathPct: 92
  },
  {
    origin: 'Kojima, Okayama, Japan',
    name: 'Shuttle-Loom Okayama Selvedge Denim',
    desc: '24-dip rope-dyed botanical indigo woven slowly on vintage Toyoda shuttle looms with pink ID ticker.',
    img: '<?= base_url("img/vintage_okayama_14_5oz_selvedge_denim.jpg") ?>',
    density: '14.5 OZ · Structural Rigid',
    densityPct: 92,
    drape: '84% Architectural Break',
    drapePct: 84,
    breath: 'Ring-Spun Long Staple',
    breathPct: 88
  },
  {
    origin: 'Lake Como, Lombardy, Italy',
    name: 'Sand-Washed Mulberry Heavy Silk',
    desc: 'Grade 6A continuous long-filament silk with a bias cut that clings to contours with liquid sheen.',
    img: '<?= base_url("img/mulberry_silk_bias_slip_dress.jpg") ?>',
    density: '22-Momme · Heavy Drape',
    densityPct: 82,
    drape: '100% Liquid Cascade',
    drapePct: 100,
    breath: '100% Natural Organic Sericin',
    breathPct: 96
  },
  {
    origin: 'Santa Croce, Florence, Italy',
    name: 'Vegetable-Tanned Tuscan Calfskin',
    desc: 'Naturally cured in chestnut & mimosa bark extract, hand-burnished for rich heirloom patina.',
    img: '<?= base_url("img/burnished_calfskin_penny_loafers.jpg") ?>',
    density: 'Full-Grain Box Calf',
    densityPct: 98,
    drape: 'Structured Contoured Hold',
    drapePct: 78,
    breath: 'Porous Aniline Breathable',
    breathPct: 85
  }
];

window.switchProvenanceFabric = function(idx) {
  const f = PROVENANCE_FABRICS[idx];
  if (!f) return;

  // Update card buttons styling
  for (let i = 0; i < PROVENANCE_FABRICS.length; i++) {
    const btn = document.getElementById('provFabricBtn_' + i);
    if (btn) {
      if (i === idx) {
        btn.className = 'prov-fabric-card p-4 rounded-2xl border-2 border-[#e9c176] bg-[#17171a] cursor-pointer transition-all duration-300 shadow-lg';
      } else {
        btn.className = 'prov-fabric-card p-4 rounded-2xl border border-white/10 bg-[#121214] hover:bg-[#17171a] cursor-pointer transition-all duration-300 hover:border-white/30 group';
      }
    }
  }

  // Update macro display with smooth fade
  const imgEl = document.getElementById('provMacroImage');
  if (imgEl) {
    imgEl.style.opacity = '0.3';
    setTimeout(() => {
      imgEl.src = f.img;
      imgEl.style.opacity = '1';
    }, 150);
  }

  const originEl = document.getElementById('provOriginLabel');
  if (originEl) originEl.textContent = f.origin;

  const nameEl = document.getElementById('provFabricName');
  if (nameEl) nameEl.textContent = f.name;

  const descEl = document.getElementById('provFabricDesc');
  if (descEl) descEl.textContent = f.desc;

  const densityEl = document.getElementById('provGaugeDensity');
  if (densityEl) densityEl.textContent = f.density;
  const barDensity = document.getElementById('provBarDensity');
  if (barDensity) barDensity.style.width = f.densityPct + '%';

  const drapeEl = document.getElementById('provGaugeDrape');
  if (drapeEl) drapeEl.textContent = f.drape;
  const barDrape = document.getElementById('provBarDrape');
  if (barDrape) barDrape.style.width = f.drapePct + '%';

  const breathEl = document.getElementById('provGaugeBreath');
  if (breathEl) breathEl.textContent = f.breath;
  const barBreath = document.getElementById('provBarBreath');
  if (barBreath) barBreath.style.width = f.breathPct + '%';
};

// ── State for Coordinated Ensemble Pack Cards & Sizing ──
window.lookSlotsState = {};
window.lookSlotsSizes = {};

window.changeEnsembleSlotSize = function(lIdx, slotIdx, newSize) {
  if (!window.lookSlotsSizes[lIdx]) {
    window.lookSlotsSizes[lIdx] = {};
  }
  window.lookSlotsSizes[lIdx][slotIdx] = newSize;
  if (typeof ndToast === 'function') {
    ndToast(`Updated piece size to ${newSize}! ✦`, 'info');
  }
};

// ── Dynamic Ensemble Rendering Engine ──
function renderEnsembleGroups(selectedProd) {
  const container = document.getElementById('afmEnsembleContainer');
  const subtitleEl = document.getElementById('afmEnsembleSubtitle');
  if (!container) return;

  const garmentType = detectGarmentType(selectedProd);
  const selectedItem = {
    id: selectedProd.id || 1,
    title: selectedProd.title || 'Selected Garment',
    price: (typeof selectedProd.price === 'number') ? selectedProd.price : (parseFloat(selectedProd.price) || 4999),
    img: selectedProd.image || selectedProd.img || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>',
    tag: 'Selected Piece',
    category: garmentType,
    desc: 'Handcrafted masterwork designed for optimal layering ease and drape.',
    colors: [
      { name: 'Original', hex: '#c19a6b', img: selectedProd.image || selectedProd.img || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>' },
      { name: 'Onyx Black', hex: '#18181b', img: '<?= base_url("img/sculpted_500_gsm_terry_hoodie.jpg") ?>' },
      { name: 'Slate Grey', hex: '#64748b', img: '<?= base_url("img/heavyweight_linen_overshirt.jpg") ?>' }
    ]
  };

  if (subtitleEl) {
    subtitleEl.textContent = 'Curated coordinated looks. Choose your size for each piece & toggle [✕ Remove] to customize your pack (10% off 2 items · 15% off 3 items).';
  }

  // Define 3 Curated Looks
  if (garmentType === 'top') {
    currentActiveLooks = [
      {
        name: 'The Milan Executive Look',
        vibe: 'Formal & Sharp Sartorial Cut',
        top: selectedItem,
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Selvedge Denim
        shoes: ENSEMBLE_CATALOG.shoes[0]     // Chelsea Leather Boots
      },
      {
        name: 'The Tailored Atelier Classic',
        vibe: 'Refined Contemporary Drape',
        top: selectedItem,
        bottom: ENSEMBLE_CATALOG.bottoms[1], // Italian Pleated Wool Trousers
        shoes: ENSEMBLE_CATALOG.shoes[1]     // Calfskin Penny Loafers
      },
      {
        name: 'The Monochromatic Street Look',
        vibe: 'Heavyweight Minimalist Movement',
        top: selectedItem,
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Selvedge Denim
        shoes: ENSEMBLE_CATALOG.shoes[2]     // Minimalist Sand Suede Derby
      }
    ];
  } else if (garmentType === 'bottom') {
    currentActiveLooks = [
      {
        name: 'The Executive Suiting Look',
        vibe: 'Formal & Sharp Silhouette',
        top: ENSEMBLE_CATALOG.tops[0],       // Cashmere Cocoon Coat
        bottom: selectedItem,                // Selected Bottom
        shoes: ENSEMBLE_CATALOG.shoes[0]     // Chelsea Leather Boots
      },
      {
        name: 'The Tailored Atelier Classic',
        vibe: 'Luxurious Autumnal Layering',
        top: ENSEMBLE_CATALOG.tops[2],       // Cashmere Turtleneck
        bottom: selectedItem,                // Selected Bottom
        shoes: ENSEMBLE_CATALOG.shoes[1]     // Calfskin Penny Loafers
      },
      {
        name: 'The Monochromatic Street Look',
        vibe: 'Heavyweight Architectural Casual',
        top: ENSEMBLE_CATALOG.tops[3],       // French Terry Hoodie
        bottom: selectedItem,                // Selected Bottom
        shoes: ENSEMBLE_CATALOG.shoes[2]     // Minimalist Sand Suede Derby
      }
    ];
  } else { // shoes
    currentActiveLooks = [
      {
        name: 'The Executive Suiting Look',
        vibe: 'Complete Formal Ensemble',
        top: ENSEMBLE_CATALOG.tops[0],       // Cashmere Cocoon Coat
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Denim
        shoes: selectedItem                  // Selected Shoes
      },
      {
        name: 'The Tailored Atelier Classic',
        vibe: 'Effortless Milan Drape',
        top: ENSEMBLE_CATALOG.tops[2],       // Cashmere Turtleneck
        bottom: ENSEMBLE_CATALOG.bottoms[1], // Pleated Trousers
        shoes: selectedItem                  // Selected Shoes
      },
      {
        name: 'The Monochromatic Street Look',
        vibe: 'Relaxed Architectural Streetwear',
        top: ENSEMBLE_CATALOG.tops[3],       // French Terry Hoodie
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Denim
        shoes: selectedItem                  // Selected Shoes
      }
    ];
  }

  // Initialize all slots as active with default sizes and quantity = 1
  window.lookSlotsState = window.lookSlotsState || {};
  window.lookSlotsSizes = window.lookSlotsSizes || {};
  window.lookSlotsQuantities = window.lookSlotsQuantities || {};
  currentActiveLooks.forEach((look, idx) => {
    if (!window.lookSlotsState[idx]) {
      window.lookSlotsState[idx] = { 0: true, 1: true, 2: true };
    }
    if (!window.lookSlotsSizes[idx]) {
      window.lookSlotsSizes[idx] = {};
    }
    if (!window.lookSlotsQuantities[idx]) {
      window.lookSlotsQuantities[idx] = { 0: 1, 1: 1, 2: 1 };
    }
  });

  // Render Look Cards
  container.innerHTML = currentActiveLooks.map((look, lIdx) => {
    window.lookSlotsSizes[lIdx] = window.lookSlotsSizes[lIdx] || {};
    window.lookSlotsQuantities[lIdx] = window.lookSlotsQuantities[lIdx] || { 0: 1, 1: 1, 2: 1 };

    const renderSlotRow = (slotItem, slotType, slotStep, slotIdx) => {
      const slotItemJson = JSON.stringify(slotItem).replace(/"/g, '&quot;');
      const isCurrentActiveGarment = (Number(slotItem.id) === Number(currentAfmProduct?.id)) || (slotItem.title === currentAfmProduct?.title);
      const isIncluded = window.lookSlotsState[lIdx] ? (window.lookSlotsState[lIdx][slotIdx] !== false) : true;
      
      const itemSizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(slotItem) : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
      const defaultSize = itemSizes[Math.min(2, itemSizes.length - 1)];
      const currentSelectedSize = (window.lookSlotsSizes[lIdx] && window.lookSlotsSizes[lIdx][slotIdx]) ? window.lookSlotsSizes[lIdx][slotIdx] : defaultSize;
      const currentQty = (window.lookSlotsQuantities[lIdx] && window.lookSlotsQuantities[lIdx][slotIdx]) ? window.lookSlotsQuantities[lIdx][slotIdx] : 1;

      return `
        <div id="lookSlot_${lIdx}_${slotIdx}" class="${isIncluded ? (isCurrentActiveGarment ? 'border-2 border-amber-400 bg-amber-50/40 shadow-xs' : 'bg-white border border-stone-200 shadow-2xs') : 'bg-stone-100/70 border border-dashed border-stone-300 opacity-60 grayscale'} rounded-2xl p-3 transition-all group">
          <!-- Top Row: Thumbnail + Details + Cancel/Add Button -->
          <div class="flex items-center gap-3">
            <div class="relative w-12 h-14 min-w-[48px] max-w-[48px] min-h-[56px] max-h-[56px] rounded-xl overflow-hidden bg-stone-100 flex-shrink-0 border ${isCurrentActiveGarment ? 'border-amber-300' : 'border-stone-200'} shadow-2xs cursor-pointer" style="width: 48px; height: 56px;" onclick="openProductQuickViewModal(${slotItemJson})">
              <img src="${slotItem.img || slotItem.image}" alt="${slotItem.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" style="width: 100%; height: 100%; object-fit: cover;">
              <span class="absolute top-1 left-1 bg-stone-900/90 text-white text-[7.5px] font-mono px-1 py-0.5 rounded font-bold">${slotStep}</span>
            </div>
            
            <div class="min-w-0 flex-1">
              <span class="text-[8px] font-mono uppercase font-bold tracking-wider ${isCurrentActiveGarment ? 'text-[#a16207]' : 'text-stone-500'} block mb-0.5">
                ${isCurrentActiveGarment ? '★ ' + slotType + ' (SELECTED)' : slotType}
              </span>
              <h5 class="font-serif text-xs font-bold text-stone-900 truncate hover:text-[#a16207] transition-colors cursor-pointer mb-0.5" title="${slotItem.title}" onclick="openProductQuickViewModal(${slotItemJson})">
                ${slotItem.title}
              </h5>
              <div class="flex items-center gap-1.5 text-stone-900 font-serif font-bold text-xs">
                <span>₹${Number(slotItem.price).toLocaleString('en-IN')}</span>
                <span class="font-sans text-[8.5px] text-stone-400 font-normal">· Click to inspect</span>
              </div>
            </div>

            <!-- Cancel/Cross Remove vs Add Button -->
            <div class="flex-shrink-0">
              ${isIncluded ? `
                <button type="button" onclick="event.stopPropagation(); toggleEnsembleSlot(${lIdx}, ${slotIdx})" class="px-2.5 py-1.5 bg-stone-100 hover:bg-rose-50 text-stone-600 hover:text-rose-700 border border-stone-300 hover:border-rose-300 rounded-xl text-[9px] font-mono font-bold flex items-center gap-1 transition-all cursor-pointer shadow-2xs active:scale-95" title="Remove piece from combo">
                  <span class="material-symbols-outlined text-xs text-rose-500 font-bold">close</span>
                  <span>Remove</span>
                </button>
              ` : `
                <button type="button" onclick="event.stopPropagation(); toggleEnsembleSlot(${lIdx}, ${slotIdx})" class="px-2.5 py-1.5 bg-stone-900 hover:bg-black text-[#e9c176] rounded-xl text-[9px] font-mono font-bold flex items-center gap-1 transition-all cursor-pointer shadow-xs active:scale-95" title="Add piece back to combo">
                  <span class="material-symbols-outlined text-xs">add</span>
                  <span>Add</span>
                </button>
              `}
            </div>
          </div>

          <!-- Bottom Row: Individual Size Selector & Quantity Stepper (Visible when Included) -->
          ${isIncluded ? `
            <div class="mt-2.5 pt-2 border-t border-stone-200/80 flex items-center justify-between gap-2">
              <!-- Size Selector -->
              <div class="flex items-center gap-1.5">
                <span class="text-[9px] font-mono font-bold text-stone-500 uppercase">Size:</span>
                <select onchange="setEnsembleSlotSize(${lIdx}, ${slotIdx}, this.value)" class="text-[10px] font-mono font-bold bg-white border border-stone-300 rounded-lg px-2 py-0.5 text-stone-900 focus:border-amber-500 focus:outline-none cursor-pointer shadow-2xs">
                  ${itemSizes.map(sz => `<option value="${sz}" ${sz === currentSelectedSize ? 'selected' : ''}>${sz}</option>`).join('')}
                </select>
              </div>

              <!-- Quantity Stepper -->
              <div class="flex items-center gap-1.5">
                <span class="text-[9px] font-mono font-bold text-stone-500 uppercase">Qty:</span>
                <div class="flex items-center border border-stone-300 rounded-lg bg-white shadow-2xs overflow-hidden">
                  <button type="button" onclick="event.stopPropagation(); changeEnsembleSlotQty(${lIdx}, ${slotIdx}, -1)" class="w-5 h-5 bg-stone-50 hover:bg-stone-200 flex items-center justify-center text-xs font-bold text-stone-700 cursor-pointer active:scale-95">-</button>
                  <span id="slotQty_${lIdx}_${slotIdx}" class="w-5 text-center font-mono font-bold text-[10px] text-stone-950">${currentQty}</span>
                  <button type="button" onclick="event.stopPropagation(); changeEnsembleSlotQty(${lIdx}, ${slotIdx}, 1)" class="w-5 h-5 bg-stone-50 hover:bg-stone-200 flex items-center justify-center text-xs font-bold text-stone-700 cursor-pointer active:scale-95">+</button>
                </div>
              </div>
            </div>
          ` : ''}
        </div>
      `;
    };

    return `
      <div class="w-[315px] sm:w-[345px] flex-shrink-0 snap-start bg-[#fafaf9] border border-stone-200 hover:border-amber-300/80 rounded-[28px] p-4 sm:p-5 flex flex-col justify-between shadow-sm transition-all duration-300" id="lookCard_${lIdx}">
        
        <div>
          <!-- Look Card Header -->
          <div class="flex items-center justify-between pb-3 mb-3.5 border-b border-stone-200">
            <div class="flex items-center gap-2.5">
              <span class="w-6 h-6 rounded-full bg-stone-900 text-white font-mono text-xs font-bold flex items-center justify-center shadow-xs">0${lIdx + 1}</span>
              <div>
                <h4 class="font-serif font-bold text-xs sm:text-sm text-stone-900 truncate max-w-[170px]">${look.name}</h4>
                <span class="text-[10px] text-stone-500 font-light block">${look.vibe}</span>
              </div>
            </div>
            <span id="lookCardBadge_${lIdx}" class="text-[9px] font-mono uppercase bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full font-bold">
              15% OFF
            </span>
          </div>

          <!-- Stacked Items (01 Top -> 02 Bottom -> 03 Shoes) -->
          <div class="space-y-1.5 mb-4">
            ${renderSlotRow(look.top, 'Top Wear', '01', 0)}
            
            <div class="flex items-center justify-center -my-1">
              <div class="w-[1.5px] h-3 bg-stone-300"></div>
            </div>

            ${renderSlotRow(look.bottom, 'Bottom Wear', '02', 1)}
            
            <div class="flex items-center justify-center -my-1">
              <div class="w-[1.5px] h-3 bg-stone-300"></div>
            </div>

            ${renderSlotRow(look.shoes, 'Footwear', '03', 2)}
          </div>
        </div>

        <!-- Look Actions & Dynamic Pack Pricing (Interactive Model Studio Removed) -->
        <div class="pt-3.5 border-t border-stone-200 space-y-3">
          
          <!-- Live Pack Pricing -->
          <div class="flex items-baseline justify-between text-xs px-1" id="lookPriceRow_${lIdx}">
            <!-- Dynamic Total Breakdown -->
          </div>

          <!-- Acquire Coordinated Pack Button -->
          <button type="button" id="lookCtaBtn_${lIdx}" onclick="acquireActiveEnsemblePack(${lIdx})" class="w-full py-3 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button font-extrabold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
            <span class="material-symbols-outlined text-sm">shopping_bag</span>
            <span>Acquire Complete 3-Piece Look (15% OFF)</span>
          </button>
        </div>

      </div>
    `;
  }).join('');

  // Run initial pricing calculation for all cards
  currentActiveLooks.forEach((look, idx) => {
    updateLookCardPricing(idx);
  });
}

// ── Scroll Ensembles Horizontally ──
window.scrollAfmEnsembles = function(dir) {
  const cont = document.getElementById('afmEnsembleContainer');
  if (cont) {
    cont.scrollBy({ left: dir * 350, behavior: 'smooth' });
  }
};

// ── Set Size for a specific slot in a look ──
window.setEnsembleSlotSize = function(lookIdx, slotIdx, size) {
  window.lookSlotsSizes = window.lookSlotsSizes || {};
  window.lookSlotsSizes[lookIdx] = window.lookSlotsSizes[lookIdx] || {};
  window.lookSlotsSizes[lookIdx][slotIdx] = size;
};

// ── Change Quantity for a specific slot in a look ──
window.changeEnsembleSlotQty = function(lookIdx, slotIdx, delta) {
  window.lookSlotsQuantities = window.lookSlotsQuantities || {};
  window.lookSlotsQuantities[lookIdx] = window.lookSlotsQuantities[lookIdx] || { 0: 1, 1: 1, 2: 1 };
  window.lookSlotsQuantities[lookIdx][slotIdx] = Math.max(1, Math.min(10, (window.lookSlotsQuantities[lookIdx][slotIdx] || 1) + delta));
  
  const qtyEl = document.getElementById(`slotQty_${lookIdx}_${slotIdx}`);
  if (qtyEl) {
    qtyEl.textContent = window.lookSlotsQuantities[lookIdx][slotIdx];
  }
  
  updateLookCardPricing(lookIdx);
};

// ── Slot Toggle Handler (Cancel/Remove vs Add) ──
window.toggleEnsembleSlot = function(lookIdx, slotIdx) {
  window.lookSlotsState = window.lookSlotsState || {};
  if (!window.lookSlotsState[lookIdx]) {
    window.lookSlotsState[lookIdx] = { 0: true, 1: true, 2: true };
  }
  window.lookSlotsState[lookIdx][slotIdx] = !window.lookSlotsState[lookIdx][slotIdx];
  
  if (typeof renderEnsembleGroups === 'function' && currentAfmProduct) {
    renderEnsembleGroups(currentAfmProduct);
  }
};

// ── Update Look Card Pricing with 2-item (10%) & 3-item (15%) Tiered Combo Discounts ──
window.updateLookCardPricing = function(lookIdx) {
  const look = currentActiveLooks[lookIdx];
  if (!look) return;
  
  const state = (window.lookSlotsState && window.lookSlotsState[lookIdx]) || { 0: true, 1: true, 2: true };
  const qtys = (window.lookSlotsQuantities && window.lookSlotsQuantities[lookIdx]) || { 0: 1, 1: 1, 2: 1 };
  const slots = [look.top, look.bottom, look.shoes];
  
  let activeCount = 0;
  let totalItemsQty = 0;
  let sumOriginal = 0;

  slots.forEach((item, sIdx) => {
    if (state[sIdx] && item) {
      activeCount++;
      const q = qtys[sIdx] || 1;
      totalItemsQty += q;
      sumOriginal += (parseFloat(item.price) || 0) * q;
    }
  });

  let discPct = 0;
  if (activeCount === 3) {
    discPct = window.BUNDLE_DISCOUNT_TIERS[3] || 15;
  } else if (activeCount === 2) {
    discPct = window.BUNDLE_DISCOUNT_TIERS[2] || 10;
  } else {
    discPct = 0;
  }

  const finalTotal = Math.round(sumOriginal * (1 - discPct / 100));
  const savings = sumOriginal - finalTotal;

  // Update Look Card Badge
  const badgeEl = document.getElementById(`lookCardBadge_${lookIdx}`);
  if (badgeEl) {
    if (discPct > 0) {
      badgeEl.className = 'text-[9px] font-mono uppercase bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded-full font-bold';
      badgeEl.textContent = `${discPct}% OFF`;
    } else if (activeCount === 1) {
      badgeEl.className = 'text-[9px] font-mono uppercase bg-stone-100 text-stone-600 px-2 py-0.5 rounded-full font-bold';
      badgeEl.textContent = 'Individual';
    } else {
      badgeEl.className = 'text-[9px] font-mono uppercase bg-rose-50 text-rose-600 border border-rose-200 px-2 py-0.5 rounded-full font-bold';
      badgeEl.textContent = 'Empty';
    }
  }

  // Update Price Breakdown
  const priceRowEl = document.getElementById(`lookPriceRow_${lookIdx}`);
  if (priceRowEl) {
    if (activeCount > 0) {
      priceRowEl.innerHTML = `
        <span class="text-stone-500 font-mono text-xs">Look Total:</span>
        <div class="flex items-baseline gap-2">
          <span class="font-serif font-bold text-sm text-stone-950" data-price-inr="${finalTotal}">₹${Number(finalTotal).toLocaleString('en-IN')}</span>
          ${savings > 0 ? `<span class="text-[10px] text-stone-400 line-through" data-price-inr="${sumOriginal}">₹${Number(sumOriginal).toLocaleString('en-IN')}</span>` : ''}
          ${savings > 0 ? `<span class="text-[10.5px] text-emerald-700 font-mono font-bold">Save ₹${Number(savings).toLocaleString('en-IN')}</span>` : ''}
        </div>
      `;
    } else {
      priceRowEl.innerHTML = `<span class="text-rose-600 text-[11px] font-mono font-bold">Please select at least 1 piece</span>`;
    }
  }

  // Update CTA Button
  const ctaBtn = document.getElementById(`lookCtaBtn_${lookIdx}`);
  if (ctaBtn) {
    if (activeCount === 3) {
      ctaBtn.disabled = false;
      ctaBtn.className = 'w-full py-3 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button font-extrabold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer active:scale-95';
      ctaBtn.innerHTML = `
        <span class="material-symbols-outlined text-sm">shopping_bag</span>
        <span>Acquire Complete 3-Piece Look (15% OFF)</span>
      `;
    } else if (activeCount === 2) {
      ctaBtn.disabled = false;
      ctaBtn.className = 'w-full py-3 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button font-extrabold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer active:scale-95';
      ctaBtn.innerHTML = `
        <span class="material-symbols-outlined text-sm">shopping_bag</span>
        <span>Acquire 2-Piece Combo (10% OFF · ₹${Number(finalTotal).toLocaleString('en-IN')})</span>
      `;
    } else if (activeCount === 1) {
      ctaBtn.disabled = false;
      ctaBtn.className = 'w-full py-3 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer active:scale-95';
      ctaBtn.innerHTML = `
        <span class="material-symbols-outlined text-sm">shopping_bag</span>
        <span>Acquire 1 Piece (₹${Number(finalTotal).toLocaleString('en-IN')})</span>
      `;
    } else {
      ctaBtn.disabled = true;
      ctaBtn.className = 'w-full py-3 bg-stone-200 text-stone-400 font-button font-bold text-xs uppercase tracking-wider rounded-xl cursor-not-allowed flex items-center justify-center gap-1.5';
      ctaBtn.innerHTML = `<span>Select Items Above</span>`;
    }
  }
};

// ── Acquire Ensemble Pack (Adds all active items with chosen category sizes to bag) ──
window.acquireActiveEnsemblePack = function(lookIdx) {
  const look = currentActiveLooks[lookIdx];
  if (!look) return;
  const state = (window.lookSlotsState && window.lookSlotsState[lookIdx]) || { 0: true, 1: true, 2: true };
  const sizesState = (window.lookSlotsSizes && window.lookSlotsSizes[lookIdx]) || {};
  const qtysState = (window.lookSlotsQuantities && window.lookSlotsQuantities[lookIdx]) || { 0: 1, 1: 1, 2: 1 };
  const slots = [look.top, look.bottom, look.shoes];

  const activeItems = [];
  slots.forEach((item, sIdx) => {
    if (state[sIdx] && item) {
      const itemSizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(item) : ['M'];
      const defaultSize = itemSizes[Math.min(2, itemSizes.length - 1)];
      const chosenSize = sizesState[sIdx] || defaultSize;
      const chosenQty = qtysState[sIdx] || 1;
      
      activeItems.push({
        id: item.id || 1,
        variant_id: item.id || 1,
        product_id: item.id || 1,
        title: item.title,
        price: item.price,
        image: item.img || item.image,
        size: chosenSize,
        quantity: chosenQty,
        color: (item.colors && item.colors[0]) ? item.colors[0].name : ''
      });
    }
  });

  if (!activeItems.length) {
    if (typeof ndToast === 'function') ndToast('Please include at least 1 item in the pack.', 'error');
    return;
  }

  const count = activeItems.length;
  const discPct = count === 3 ? (window.BUNDLE_DISCOUNT_TIERS[3] || 15) : (count === 2 ? (window.BUNDLE_DISCOUNT_TIERS[2] || 10) : 0);
  const comboId = 'combo_' + Date.now();

  // Save combo pack metadata to localStorage so Quick Bag separates combo from individual items
  try {
    const existingCombos = JSON.parse(localStorage.getItem('lumina_cart_combos') || '[]');
    existingCombos.push({
      comboId: comboId,
      lookName: look.name || 'Curated Ensemble Pack',
      itemIds: activeItems.map(it => Number(it.id)),
      discount: discPct,
      createdAt: Date.now()
    });
    localStorage.setItem('lumina_cart_combos', JSON.stringify(existingCombos));
  } catch(e) {}

  activeItems.forEach((item, i) => {
    setTimeout(() => {
      if (typeof window.addToCart === 'function') {
        window.addToCart(item, item.quantity || 1, i === activeItems.length - 1 ? `✦ Added ${count}-Piece Pack to Curated Bag with ${discPct}% Bundle Privilege!` : null);
      }
    }, i * 140);
  });

  closeAtelierFitModal();
  setTimeout(() => {
    if (typeof toggleQuickBagDrawer === 'function') {
      const overlay = document.getElementById('quickBagOverlay');
      if (overlay && overlay.classList.contains('hidden')) {
        toggleQuickBagDrawer();
      }
    }
  }, (activeItems.length * 140) + 300);
};

// ════════════════════════════════════════════════════════════
// 1. PRODUCT QUICK VIEW MODAL CONTROLLER (CLEAN INSPECT ONLY)
// ════════════════════════════════════════════════════════════
window.openProductQuickViewModal = function(item) {
  if (!item) return;
  currentQuickViewItem = item;
  
  const modal = document.getElementById('atelierProductQuickViewModal');
  if (!modal) return;

  const titleEl = document.getElementById('apqvTitle');
  if (titleEl) titleEl.textContent = item.title || 'Curated Atelier Piece';

  const baseImg = item.img || item.image || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';
  const imgEl = document.getElementById('apqvImage');
  if (imgEl) imgEl.src = baseImg;

  const priceEl = document.getElementById('apqvPrice');
  if (priceEl) priceEl.textContent = typeof window.formatPrice === 'function' ? window.formatPrice(item.price || 4999) : '₹' + Number(item.price || 4999).toLocaleString('en-IN');

  const tagEl = document.getElementById('apqvCategoryTag');
  if (tagEl) tagEl.textContent = (item.tag || item.category || 'Atelier Garment').toUpperCase();

  const descEl = document.getElementById('apqvDesc');
  if (descEl) descEl.textContent = item.desc || 'Crafted with sartorial precision in Japan and Italy using natural double-faced fibers.';

  // Color Swatches with Live Color-Specific Images
  const colorCont = document.getElementById('apqvColorSwatches');
  let defaultColors = [
    { name: 'Raw Indigo', hex: '#1e3a8a', img: baseImg },
    { name: 'Faded Stone', hex: '#64748b', img: '<?= base_url("img/italian_pleated_wool_trousers.jpg") ?>' },
    { name: 'Washed Black', hex: '#18181b', img: '<?= base_url("img/burnished_calfskin_penny_loafers.jpg") ?>' }
  ];

  if (/coat|jacket|cashmere/i.test(item.title || '')) {
    defaultColors = [
      { name: 'Signature Camel', hex: '#c19a6b', img: baseImg },
      { name: 'Obsidian Black', hex: '#18181b', img: '<?= base_url("img/sculpted_500_gsm_terry_hoodie.jpg") ?>' },
      { name: 'Oatmeal Melange', hex: '#dcd0c0', img: '<?= base_url("img/heavyweight_linen_overshirt.jpg") ?>' },
      { name: 'Forest Emerald', hex: '#1b4332', img: '<?= base_url("img/mulberry_silk_bias_slip_dress.jpg") ?>' }
    ];
  } else if (/shoe|boot|loafer/i.test(item.title || '')) {
    defaultColors = [
      { name: 'Burnished Tan', hex: '#854d0e', img: baseImg },
      { name: 'Obsidian Black', hex: '#18181b', img: '<?= base_url("img/burnished_calfskin_penny_loafers.jpg") ?>' },
      { name: 'Espresso Suede', hex: '#451a03', img: '<?= base_url("img/handcrafted_italian_chelsea_boots.jpg") ?>' }
    ];
  }

  const colors = (item.colors && item.colors.length) ? item.colors : defaultColors;
  currentQuickViewColor = colors[0].name;
  const colorLbl = document.getElementById('apqvSelectedColorLabel');
  if (colorLbl) colorLbl.textContent = currentQuickViewColor;

  if (colorCont) {
    colorCont.innerHTML = colors.map((c, idx) => `
      <button type="button" onclick="selectQuickViewColor('${c.name.replace(/'/g, "\\'")}', '${c.hex}', '${(c.img || baseImg).replace(/'/g, "\\'")}', this)" class="apqv-color-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl border ${idx===0 ? 'border-2 border-amber-500 bg-amber-50 font-bold shadow-xs text-stone-900' : 'border-stone-200 bg-white hover:border-stone-400 text-stone-700'} text-[11px] font-mono cursor-pointer transition-all">
        <span class="w-3.5 h-3.5 rounded-full border border-stone-300 shadow-xs flex-shrink-0" style="background-color: ${c.hex};"></span>
        <span>${c.name}</span>
      </button>
    `).join('');
  }

  // Sizing with Category Accuracy and Interactive Selection
  const sizeCont = document.getElementById('apqvSizePills');
  const sizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(item) : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
  currentQuickViewSize = sizes[Math.min(2, sizes.length - 1)]; // Default active size
  
  const sizeLbl = document.getElementById('apqvSelectedSizeLabel');
  if (sizeLbl) sizeLbl.textContent = 'Size ' + currentQuickViewSize;

  const errEl = document.getElementById('apqvSizeError');
  if (errEl) errEl.classList.add('hidden');

  if (sizeCont) {
    sizeCont.innerHTML = sizes.map(s => `
      <button type="button" onclick="selectQuickViewSize('${s}', this)" class="apqv-size-btn px-3 py-1.5 rounded-lg border ${s === currentQuickViewSize ? 'border-2 border-stone-950 bg-stone-950 text-[#e9c176] font-bold shadow-xs' : 'border-stone-200 bg-stone-50 text-stone-700 hover:border-stone-400'} text-xs font-mono font-medium cursor-pointer transition-all">
        ${s}
      </button>
    `).join('');
  }

  const ctaText = document.getElementById('apqvAddToCartBtnText');
  if (ctaText) ctaText.textContent = `Acquire Size ${currentQuickViewSize} · ₹${Number(item.price || 4999).toLocaleString('en-IN')}`;

  modal.classList.remove('hidden');
  modal.classList.add('flex');
};

window.selectQuickViewColor = function(colorName, hex, imgUrl, btn) {
  currentQuickViewColor = colorName;
  const colorLbl = document.getElementById('apqvSelectedColorLabel');
  if (colorLbl) colorLbl.textContent = colorName;

  document.querySelectorAll('.apqv-color-btn').forEach(b => {
    b.className = 'apqv-color-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl border border-stone-200 bg-white hover:border-stone-400 text-stone-700 text-[11px] font-mono cursor-pointer transition-all';
  });
  if (btn) {
    btn.className = 'apqv-color-btn flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl border-2 border-amber-500 bg-amber-50 font-bold shadow-xs text-stone-900 text-[11px] font-mono cursor-pointer transition-all';
  }

  // Update modal image smoothly with fade
  const imgEl = document.getElementById('apqvImage');
  if (imgEl && imgUrl) {
    imgEl.style.opacity = '0.3';
    setTimeout(() => {
      imgEl.src = imgUrl;
      imgEl.style.opacity = '1';
    }, 150);
  }
};

window.selectQuickViewSize = function(size, btn) {
  currentQuickViewSize = size;
  const sizeLbl = document.getElementById('apqvSelectedSizeLabel');
  if (sizeLbl) sizeLbl.textContent = 'Size ' + size;

  const errEl = document.getElementById('apqvSizeError');
  if (errEl) errEl.classList.add('hidden');

  document.querySelectorAll('.apqv-size-btn').forEach(b => {
    b.className = 'apqv-size-btn px-3 py-1.5 rounded-lg border border-stone-200 bg-stone-50 text-stone-700 hover:border-stone-400 text-xs font-mono font-medium cursor-pointer transition-all';
  });
  if (btn) {
    btn.className = 'apqv-size-btn px-3 py-1.5 rounded-lg border-2 border-stone-950 bg-stone-950 text-[#e9c176] font-bold shadow-xs text-xs font-mono cursor-pointer transition-all';
  }

  const ctaText = document.getElementById('apqvAddToCartBtnText');
  if (ctaText && currentQuickViewItem) {
    ctaText.textContent = `Acquire Size ${size} · ₹${Number(currentQuickViewItem.price || 4999).toLocaleString('en-IN')}`;
  }
};

window.acquireQuickViewItem = function() {
  if (!currentQuickViewItem) return;
  if (!currentQuickViewSize) {
    const errEl = document.getElementById('apqvSizeError');
    if (errEl) errEl.classList.remove('hidden');
    if (typeof ndToast === 'function') ndToast('Please select a size first.', 'error');
    return;
  }

  if (typeof addToCart === 'function') {
    addToCart({
      id: currentQuickViewItem.id || 1,
      variant_id: currentQuickViewItem.id || 1,
      product_id: currentQuickViewItem.id || 1,
      title: currentQuickViewItem.title,
      price: currentQuickViewItem.price,
      image: currentQuickViewItem.img || currentQuickViewItem.image,
      size: currentQuickViewSize,
      color: currentQuickViewColor
    }, 1, `✦ Added "${currentQuickViewItem.title}" (Size ${currentQuickViewSize} · ${currentQuickViewColor}) to Curated Bag!`);
    
    closeProductQuickViewModal();
  }
};

window.closeProductQuickViewModal = function() {
  const modal = document.getElementById('atelierProductQuickViewModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
};
</script>

<!-- ══════════════════════════════════════════════════════
     BLOCK STATS: ANIMATED SOCIAL CREDIBILITY COUNTERS
══════════════════════════════════════════════════════ -->
<section class="py-14 bg-black border-y border-black/10 overflow-hidden relative" id="statsSection">
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_50%_50%,rgba(233,193,118,0.10),transparent)] pointer-events-none"></div>
  
  <!-- Animated numbers row -->
  <div class="max-w-7xl mx-auto px-4 md:px-8 relative z-10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 text-center">
      
      <div class="group cursor-default">
        <div class="text-3xl sm:text-4xl md:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(233,193,118,0.4)" data-count="14800" id="stat1">14,800+</div>
        <div class="text-xs font-mono uppercase tracking-widest text-[#e9c176] mb-1">Connoisseurs</div>
        <div class="text-[10px] text-white/50">Worldwide Collectors</div>
        <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#e9c176] to-transparent mx-auto mt-3 group-hover:w-20 transition-all duration-500"></div>
      </div>

      <div class="group cursor-default">
        <div class="text-3xl sm:text-4xl md:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(233,193,118,0.4)" data-count="98" id="stat2">4.98★</div>
        <div class="text-xs font-mono uppercase tracking-widest text-[#e9c176] mb-1">Avg. Rating</div>
        <div class="text-[10px] text-white/50">From verified reviews</div>
        <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#e9c176] to-transparent mx-auto mt-3 group-hover:w-20 transition-all duration-500"></div>
      </div>

      <div class="group cursor-default">
        <div class="text-3xl sm:text-4xl md:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(233,193,118,0.4)" data-count="18" id="stat3">18h</div>
        <div class="text-xs font-mono uppercase tracking-widest text-[#e9c176] mb-1">Dispatch Speed</div>
        <div class="text-[10px] text-white/50">Average fulfilment time</div>
        <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#e9c176] to-transparent mx-auto mt-3 group-hover:w-20 transition-all duration-500"></div>
      </div>

      <div class="group cursor-default">
        <div class="text-3xl sm:text-4xl md:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(233,193,118,0.4)" data-count="100" id="stat4">100%</div>
        <div class="text-xs font-mono uppercase tracking-widest text-[#e9c176] mb-1">Pure Materials</div>
        <div class="text-[10px] text-white/50">Lab-certified provenance</div>
        <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#e9c176] to-transparent mx-auto mt-3 group-hover:w-20 transition-all duration-500"></div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     BLOCK TRUST: PAYMENT METHODS & SECURITY MARQUEE
══════════════════════════════════════════════════════ -->
<section class="py-6 bg-white border-y border-black/10 overflow-hidden relative">
  <!-- Scrolling Trust Marquee -->
  <div class="overflow-hidden relative">
    <!-- Fade edges -->
    <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
    <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>
    
    <div class="marquee-track flex items-center gap-8 sm:gap-12 whitespace-nowrap py-3" style="width: max-content;">
      <!-- Trust items (doubled for seamless loop) -->
      <?php foreach (array_merge([
        ['icon' => 'credit_card', 'label' => 'Visa & Mastercard', 'color' => '#e9c176'],
        ['icon' => 'account_balance', 'label' => 'Net Banking', 'color' => '#6366f1'],
        ['icon' => 'phone_android', 'label' => 'UPI / PhonePe', 'color' => '#10b981'],
        ['icon' => 'payments', 'label' => 'Google Pay', 'color' => '#4285f4'],
        ['icon' => 'local_shipping', 'label' => 'Cash on Delivery', 'color' => '#f59e0b'],
        ['icon' => 'verified_user', 'label' => '256-bit SSL Secured', 'color' => '#22c55e'],
        ['icon' => 'workspace_premium', 'label' => 'RBI Compliant', 'color' => '#e9c176'],
        ['icon' => 'local_shipping', 'label' => 'Insured Express Delivery', 'color' => '#a78bfa'],
        ['icon' => 'autorenew', 'label' => '7-Day Returns', 'color' => '#f97316'],
        ['icon' => 'lock', 'label' => 'PCI DSS Certified', 'color' => '#22d3ee'],
      ], [
        ['icon' => 'credit_card', 'label' => 'Visa & Mastercard', 'color' => '#e9c176'],
        ['icon' => 'account_balance', 'label' => 'Net Banking', 'color' => '#6366f1'],
        ['icon' => 'phone_android', 'label' => 'UPI / PhonePe', 'color' => '#10b981'],
        ['icon' => 'payments', 'label' => 'Google Pay', 'color' => '#4285f4'],
        ['icon' => 'local_shipping', 'label' => 'Cash on Delivery', 'color' => '#f59e0b'],
        ['icon' => 'verified_user', 'label' => '256-bit SSL Secured', 'color' => '#22c55e'],
        ['icon' => 'workspace_premium', 'label' => 'RBI Compliant', 'color' => '#e9c176'],
        ['icon' => 'local_shipping', 'label' => 'Insured Express Delivery', 'color' => '#a78bfa'],
        ['icon' => 'autorenew', 'label' => '7-Day Returns', 'color' => '#f97316'],
        ['icon' => 'lock', 'label' => 'PCI DSS Certified', 'color' => '#22d3ee'],
      ]) as $ti): ?>
      <div class="flex items-center gap-2.5 flex-shrink-0 group cursor-default">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: <?= $ti['color'] ?>18; border: 1px solid <?= $ti['color'] ?>30;">
          <span class="material-symbols-outlined text-sm" style="color: <?= $ti['color'] ?>"><?= $ti['icon'] ?></span>
        </div>
        <span class="text-xs font-mono text-black/50 group-hover:text-black/80 transition-colors uppercase tracking-wider"><?= $ti['label'] ?></span>
      </div>
      <span class="text-black/15 text-base flex-shrink-0">✦</span>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     BLOCK LAST CHANCE: HIGH-URGENCY FLASH DEALS ENGINE
══════════════════════════════════════════════════════ -->
<section class="py-16 md:py-20 bg-white relative overflow-hidden border-b border-black/10 scroll-unfold-section" id="lastChanceSection">
  <!-- Subtle accent line top -->
  <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#e9c176] to-transparent"></div>

  <div class="max-w-7xl mx-auto px-4 md:px-8 relative z-10">
    
    <!-- Section Header -->
    <div class="text-center mb-10 sm:mb-12">
      <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-red-50 border border-red-200 text-red-500 text-xs font-mono uppercase tracking-widest mb-4">
        <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span>
        <span>Last Chance · Flash Privilege · Ends Soon</span>
        <span class="font-bold text-black" id="lcTimerDisplay">07:42:15</span>
      </div>
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-serif text-black mb-3 leading-tight">
        <?php
          $_flash_title = $home_settings['flash_section_title'] ?? "Today's VIP Flash Deals.";
          $_flash_parts = explode(' ', $_flash_title, -1);
          $_flash_last  = array_pop($_flash_parts);
          echo htmlspecialchars(implode(' ', $_flash_parts)) . ' <span class="italic text-[#a16207]">' . htmlspecialchars($_flash_last) . '</span>';
        ?>
      </h2>
      <p class="text-black/50 text-sm max-w-lg mx-auto font-light leading-relaxed">
        <?= htmlspecialchars($home_settings['flash_section_subtitle'] ?? 'These curated atelier pieces are available at privilege pricing for members only. Stock is critically limited — acquire before the drop window closes.') ?>
      </p>
    </div>

    <!-- Flash Deal Cards Grid (2-Column Mobile, 3-Column Desktop) -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
      
      <?php 
      $deals_list = !empty($flash_deals) ? $flash_deals : [];
      foreach ($deals_list as $fd_idx => $fd):
        $fd_original = (float)($fd['compare_at_price'] ?? ($fd['original'] ?? 8999));
        $fd_flash = (float)($fd['base_price'] ?? ($fd['flash'] ?? 4999));
        $fd_discount = $fd['discount_pct'] ?? ($fd_original > $fd_flash ? round((($fd_original - $fd_flash) / $fd_original) * 100) : 40);
        $fd_save = max(0, $fd_original - $fd_flash);
        $fd_stock_left = (int)($fd['stock_left'] ?? 3);
        $fd_stock_total = (int)($fd['stock_total'] ?? 20);
        $fd_stock_pct = round(($fd_stock_left / $fd_stock_total) * 100);
        $fd_img = !empty($fd['primary_image']) ? $fd['primary_image'] : (!empty($fd['img']) ? $fd['img'] : base_url('img/cashmere_cocoon_coat.jpg'));
        $fd_tag = !empty($fd['collection_title']) ? $fd['collection_title'] : 'PRIVILEGE DROP';
        $fd_tag_color = '#e9c176';
        $fd_subtitle = $fd['short_description'] ?? ($fd['subtitle'] ?? 'Handcrafted Atelier Edition');
      ?>
      <div class="group relative bg-white rounded-xl sm:rounded-2xl border border-stone-200 hover:border-[#a16207]/60 hover:shadow-[0_20px_40px_rgba(161,98,7,0.14)] transition-all duration-300 overflow-hidden flex flex-col shadow-sm" style="animation-delay: <?= $fd_idx * 0.12 ?>s">
        
        <!-- Image Container -->
        <div class="relative aspect-[3/4] sm:aspect-[4/5] overflow-hidden bg-black cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $fd['slug']) ?>'">
          <img src="<?= htmlspecialchars($fd_img) ?>" alt="<?= htmlspecialchars($fd['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" loading="lazy">
          
          <!-- Overlay gradient -->
          <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent pointer-events-none"></div>

          <!-- Flash tag top-left -->
          <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-col gap-1 z-10">
            <div class="flex items-center gap-0.5 sm:gap-1 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-[7.5px] sm:text-[10px] font-mono font-bold uppercase tracking-wider shadow-md" style="background: <?= ($fd['tag_color'] ?? '#e9c176') ?>30; border: 1px solid <?= ($fd['tag_color'] ?? '#e9c176') ?>70; color: <?= ($fd['tag_color'] ?? '#e9c176') ?>; backdrop-filter: blur(4px);">
              <span class="material-symbols-outlined text-[9px] sm:text-xs"><?= ($fd['badge_icon'] ?? 'local_fire_department') ?></span>
              <span class="truncate max-w-[80px] sm:max-w-none"><?= ($fd['tag'] ?? 'PRIVILEGE DROP') ?></span>
            </div>
            <div class="px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full bg-black/85 border border-white/20 text-[7.5px] sm:text-[10px] font-bold text-amber-300 backdrop-blur-md shadow-sm w-max">
              <?= $fd_discount ?>% OFF
            </div>
          </div>

          <!-- Wishlist top-right -->
          <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex flex-col gap-1 z-10" onclick="event.stopPropagation()">
            <div class="heart-container w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/70 hover:bg-black border border-white/20 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 flex items-center justify-center cursor-pointer" title="Save to Wardrobe">
              <input type="checkbox" class="checkbox" data-wishlist-id="<?= (int)$fd['id'] ?>" onchange="toggleWishlistItem({id:<?= (int)$fd['id'] ?>, title:'<?= addslashes(htmlspecialchars($fd['title'])) ?>', price:<?= $fd_flash ?>, image:'<?= addslashes($fd_img) ?>'}, event)">
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

          <!-- Bottom price bar inside image -->
          <div class="absolute bottom-0 left-0 right-0 p-2 sm:p-3.5 flex items-end justify-between z-10">
            <div>
              <div class="text-[#e9c176] font-serif font-bold text-sm sm:text-xl drop-shadow-md">₹<?= number_format($fd_flash, 0) ?></div>
              <div class="text-white/60 text-[9px] sm:text-xs line-through">₹<?= number_format($fd_original, 0) ?></div>
            </div>
            <div class="text-emerald-400 text-[8px] sm:text-xs font-bold text-right">
              <div>Save ₹<?= number_format($fd_save, 0) ?></div>
              <div class="text-white/60 font-normal text-[7px] sm:text-[10px]">Free Express Delivery</div>
            </div>
          </div>
        </div>

        <!-- Card Body -->
        <div class="p-2.5 sm:p-5 flex flex-col gap-2 sm:gap-3 flex-1 bg-white">
          <div>
            <h3 class="font-serif text-xs sm:text-base font-bold text-stone-900 group-hover:text-[#a16207] transition-colors leading-tight line-clamp-1">
              <a href="<?= base_url('products/' . $fd['slug']) ?>"><?= htmlspecialchars($fd['title']) ?></a>
            </h3>
            <p class="hidden sm:block text-[11px] text-stone-500 mt-1 line-clamp-1 font-light"><?= htmlspecialchars($fd_subtitle) ?></p>
          </div>

          <!-- Scarcity Stock Bar -->
          <div>
            <div class="flex items-center justify-between mb-1">
              <span class="text-[8px] sm:text-[10px] text-stone-500 font-mono uppercase tracking-wider">Stock Left</span>
              <span class="text-[8px] sm:text-[10px] font-bold text-red-500 flex items-center gap-0.5 sm:gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span>
                <span>Only <?= $fd_stock_left ?> left</span>
              </span>
            </div>
            <div class="w-full bg-stone-100 rounded-full overflow-hidden h-1.5">
              <div class="scarcity-bar bg-gradient-to-r from-red-500 to-amber-500 h-full rounded-full" style="width: <?= max(15, min(100, $fd_stock_pct)) ?>%"></div>
            </div>
          </div>

          <!-- Rating Row (Visible on sm+) -->
          <div class="hidden sm:flex items-center gap-2 text-[11px] pt-0.5">
            <span class="text-amber-500 font-bold tracking-tight">★★★★★</span>
            <span class="text-stone-500">4.9 · (127 reviews)</span>
            <span class="text-emerald-600 font-semibold ml-auto flex items-center gap-1">
              <span class="material-symbols-outlined text-xs">verified</span> Authentic
            </span>
          </div>

          <!-- Points Earning Pill (2x Flash Drop Bonus) -->
          <?php 
            $fd_pts = !empty($fd['reward_points']) ? (int)$fd['reward_points'] : max(1, round($fd_flash * 0.06)); 
            $fd_bonus_pts = $fd_pts * 2; // 2x Flash Drop Event Multiplier
          ?>
          <div class="flex items-center justify-between gap-1 py-1 px-2 rounded-lg bg-amber-50 border border-amber-200">
            <span class="text-[9px] sm:text-[10px] font-mono font-bold text-amber-900 flex items-center gap-1">
              <span>🪙 +<?= number_format($fd_bonus_pts) ?> pts</span>
              <span class="text-amber-700 font-normal">(2× Flash Drop Double Points)</span>
            </span>
            <span class="text-[9px] font-mono text-emerald-700 font-bold">₹<?= number_format($fd_bonus_pts) ?> Cashback</span>
          </div>

          <!-- Action Buttons -->
          <div class="grid grid-cols-2 gap-1.5 sm:gap-2 mt-auto pt-2 sm:pt-3 border-t border-stone-100">
            <?php
              $acquire_fd_data = [
                'id' => (int)$fd['id'],
                'title' => $fd['title'],
                'price' => (float)$fd_flash,
                'compare_price' => (float)($fd_original ?? ($fd['compare_at_price'] ?? 0)),
                'reward_points' => $fd_bonus_pts,
                'image' => $fd_img,
                'vendor' => $fd['vendor'] ?? 'Lumina Atelier Milano',
                'category' => 'flash',
                'description' => strip_tags($fd['short_description'] ?? 'Exclusive limited edition flash drop.')
              ];
            ?>
            <button type="button" 
                    data-tooltip="Fit &amp; Sizing" 
                    data-product="<?= htmlspecialchars(json_encode($acquire_fd_data), ENT_QUOTES, 'UTF-8') ?>" 
                    onclick="openAtelierFitModal(this.dataset.product || this.getAttribute('data-product'))" 
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
                    data-tooltip="Flash: ₹<?= number_format($fd_flash, 0) ?>" 
                    onclick="openExpressCheckout(<?= $fd['id'] ?>, '<?= addslashes($fd['title']) ?>', <?= $fd_flash ?>, '<?= addslashes($fd_img) ?>', <?= $fd['id'] ?>)" 
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

    <!-- Bottom CTA Row -->
    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 text-center">
      <div class="text-sm text-black/40 font-light">Flash pricing resets after the countdown. <strong class="text-black">Don't miss out.</strong></div>
      <a href="<?= base_url('shop') ?>" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full border border-[#a16207]/40 text-[#a16207] text-xs font-button uppercase tracking-wider hover:bg-[#a16207]/10 transition-all">
        <span>View All Flash Deals</span>
        <span class="material-symbols-outlined text-sm">arrow_forward</span>
      </a>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     PROVENANCE & TRUST: VOICES FROM THE ATELIER COLLECTIVE
══════════════════════════════════════════════════════ -->
<section class="py-16 md:py-24 bg-[#0a0b0e] border-t border-white/10 text-white scroll-unfold-section" id="reviewsSection">
  <div class="max-w-container-max mx-auto px-4 sm:px-6 md:px-margin-desktop">
    
    <div class="text-center max-w-xl mx-auto mb-12">
      <span class="font-label-caps text-xs text-[#e9c176] uppercase tracking-[0.25em] block mb-2 font-semibold">Provenance &amp; Trust</span>
      <h2 class="font-headline-md text-3xl sm:text-4xl font-serif text-white">Voices from the Atelier Collective</h2>
      <p class="text-xs text-white/70 font-light mt-1">Verified collectors on architectural tailoring, fiber longevity, and white-glove transport.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php 
        $display_reviews = !empty($reviews) ? array_slice($reviews, 0, 3) : [];
        $avatar_map = [
          1 => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80',
          2 => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80',
          3 => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=100&q=80',
          4 => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&q=80',
          5 => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&q=80',
        ];
        foreach ($display_reviews as $idx => $rev):
          $stars = str_repeat('★', (int)($rev['rating'] ?? 5));
          $av = $avatar_map[$rev['product_id'] ?? 1] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80';
      ?>
      <div class="liquid-glass-dark p-6 md:p-8 rounded-2xl border border-white/15 flex flex-col justify-between shadow-xl">
        <div>
          <div class="flex items-center gap-1 text-amber-400 mb-4">
            <span><?= $stars ?></span>
            <span class="text-[10px] text-emerald-400 font-mono ml-2"><?= !empty($rev['is_verified']) ? 'Verified Collector' : 'Atelier Member' ?></span>
          </div>
          <p class="font-serif italic text-white/90 text-sm leading-relaxed mb-6">
            "<?= htmlspecialchars($rev['body']) ?>"
          </p>
        </div>
        <div class="flex items-center gap-3 pt-4 border-t border-white/10">
          <img src="<?= $av ?>" alt="<?= htmlspecialchars($rev['name']) ?>" class="w-10 h-10 rounded-full object-cover border border-[#e9c176]/40">
          <div>
            <span class="font-serif font-bold text-xs text-white block"><?= htmlspecialchars($rev['name']) ?></span>
            <span class="text-[10px] text-[#e9c176]">Acquired <?= htmlspecialchars($rev['product_title'] ?? 'Atelier Piece') ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     ATELIER PRIVILEGE & SUBSCRIPTION REWARDS GRID (LUXURY WHITE)
══════════════════════════════════════════════════════ -->
<section class="py-16 md:py-24 bg-white border-t border-b border-stone-200/80 text-stone-900 scroll-unfold-section relative overflow-hidden" id="loyaltySubscriptionSection">
  <!-- Subtle ambient background luxury warm gradient -->
  <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_50%_-10%,rgba(217,119,6,0.04),rgba(255,255,255,0))] pointer-events-none"></div>

  <div class="max-w-container-max mx-auto px-4 sm:px-6 md:px-margin-desktop relative z-10">
    
    <!-- Section Header -->
    <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
      <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200/90 text-amber-900 font-mono text-[11px] font-bold uppercase tracking-[0.2em] mb-3 shadow-2xs">
        <span class="text-amber-600">✦</span> Atelier Privileges &amp; Rewards <span class="text-amber-600">✦</span>
      </span>
      <h2 class="font-serif text-3xl sm:text-4xl text-stone-950 font-bold mb-3 tracking-tight">Points Rewards &amp; Private Subscription</h2>
      <p class="text-xs sm:text-sm text-stone-600 font-normal leading-relaxed">
        Every acquisition elevates your standing. Calculate your exact cashback yield, unlock escalating tier multipliers, and explore curated monthly subscription privileges.
      </p>
    </div>

    <!-- 4-Column High-End Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 mb-12">
      
      <!-- Card 1: Points & Instant Cashback -->
      <div class="bg-white p-6 sm:p-7 rounded-2xl border border-stone-200/90 hover:border-amber-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group shadow-xs relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-full blur-2xl pointer-events-none"></div>
        <div>
          <div class="flex items-center justify-between mb-5">
            <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200/80 flex items-center justify-center text-amber-700 shadow-2xs group-hover:scale-105 transition-transform">
              <span class="material-symbols-outlined text-2xl">toll</span>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-900 font-mono text-[10.5px] font-bold tracking-wider">
              1 Pt = ₹1
            </span>
          </div>
          <h3 class="font-serif text-lg font-bold text-stone-900 mb-2 group-hover:text-amber-800 transition-colors">Atelier Reward Points</h3>
          <p class="text-xs text-stone-600 font-normal leading-relaxed mb-5">
            Earn 6 points for every ₹100 spent (6% Atelier Cashback) across all collections. Points never expire and convert directly to cash deductions on future orders.
          </p>
        </div>
        <ul class="space-y-2.5 pt-4 border-t border-stone-100 text-[11px] font-mono text-stone-700">
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
            <span>Instant checkout redemption</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
            <span>+150 pts welcome bonus on signup</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
            <span>2× double points on flash drops</span>
          </li>
        </ul>
      </div>

      <!-- Card 2: Tier Multipliers (Bronze to Diamond) -->
      <div class="bg-white p-6 sm:p-7 rounded-2xl border border-stone-200/90 hover:border-sky-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group shadow-xs relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-sky-500/5 rounded-full blur-2xl pointer-events-none"></div>
        <div>
          <div class="flex items-center justify-between mb-5">
            <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200/80 flex items-center justify-center text-sky-700 shadow-2xs group-hover:scale-105 transition-transform">
              <span class="material-symbols-outlined text-2xl">workspace_premium</span>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-900 font-mono text-[10.5px] font-bold tracking-wider">
              Up to 3.0× Multiplier
            </span>
          </div>
          <h3 class="font-serif text-lg font-bold text-stone-900 mb-2 group-hover:text-sky-800 transition-colors">VIP Multiplier Tiers</h3>
          <p class="text-xs text-stone-600 font-normal leading-relaxed mb-5">
            Ascend through Silver, Gold, Platinum, and Diamond tiers. Unlock accelerating points velocity and guaranteed VIP discounts.
          </p>
        </div>
        <ul class="space-y-2.5 pt-4 border-t border-stone-100 text-[11px] font-mono text-stone-700">
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-sky-600 font-bold">star</span>
            <span>Silver (1.2×) &amp; Gold (1.5×)</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-sky-600 font-bold">diamond</span>
            <span>Platinum (2.0×) Tier Multiplier</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-sky-600 font-bold">crown</span>
            <span>Diamond Sovereign: 3.0× Velocity</span>
          </li>
        </ul>
      </div>

      <!-- Card 3: Bespoke Private Subscription -->
      <div class="bg-white p-6 sm:p-7 rounded-2xl border border-stone-200/90 hover:border-purple-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group shadow-xs relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-full blur-2xl pointer-events-none"></div>
        <div>
          <div class="flex items-center justify-between mb-5">
            <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-200/80 flex items-center justify-center text-purple-700 shadow-2xs group-hover:scale-105 transition-transform">
              <span class="material-symbols-outlined text-2xl">card_membership</span>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-purple-50 border border-purple-200 text-purple-900 font-mono text-[10.5px] font-bold tracking-wider">
              Private Whitelist
            </span>
          </div>
          <h3 class="font-serif text-lg font-bold text-stone-900 mb-2 group-hover:text-purple-800 transition-colors">Atelier Subscription</h3>
          <p class="text-xs text-stone-600 font-normal leading-relaxed mb-5">
            Private invitation pass granting 48-hour priority access to numbered capsule launches, personal tailor appointments, and zero-fee logistics.
          </p>
        </div>
        <ul class="space-y-2.5 pt-4 border-t border-stone-100 text-[11px] font-mono text-stone-700">
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-purple-600 font-bold">schedule</span>
            <span>48-hr early capsule reserve window</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-purple-600 font-bold">local_shipping</span>
            <span>Complimentary white-glove shipping</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-purple-600 font-bold">psychology</span>
            <span>Dedicated AI stylist priority</span>
          </li>
        </ul>
      </div>

      <!-- Card 4: Daily Streaks & Badges -->
      <div class="bg-white p-6 sm:p-7 rounded-2xl border border-stone-200/90 hover:border-emerald-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group shadow-xs relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none"></div>
        <div>
          <div class="flex items-center justify-between mb-5">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200/80 flex items-center justify-center text-emerald-700 shadow-2xs group-hover:scale-105 transition-transform">
              <span class="material-symbols-outlined text-2xl">military_tech</span>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-900 font-mono text-[10.5px] font-bold tracking-wider">
              Gamified Bounties
            </span>
          </div>
          <h3 class="font-serif text-lg font-bold text-stone-900 mb-2 group-hover:text-emerald-800 transition-colors">Streaks &amp; Badges</h3>
          <p class="text-xs text-stone-600 font-normal leading-relaxed mb-5">
            Check in daily, build your wardrobe style archetypes, and collect achievement badges with bonus point drops up to 5,000 points.
          </p>
        </div>
        <ul class="space-y-2.5 pt-4 border-t border-stone-100 text-[11px] font-mono text-stone-700">
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">local_fire_department</span>
            <span>Daily style streak bonuses</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">military_tech</span>
            <span>Collector achievement trophies</span>
          </li>
          <li class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">casino</span>
            <span>Spin &amp; Win VIP exclusive drops</span>
          </li>
        </ul>
      </div>

    </div>

    <!-- ══════════════════════════════════════════════════════
         INTERACTIVE REAL-TIME POINTS & REWARDS CALCULATOR (LUXURY OBSIDIAN BLACK)
    ══════════════════════════════════════════════════════ -->
    <div class="bg-[#0c0d14] border border-amber-500/30 rounded-3xl p-6 sm:p-10 mb-14 shadow-2xl relative overflow-hidden text-white">
      <!-- Glow ambient accents -->
      <div class="absolute -top-24 -right-24 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
        
        <!-- Controls Column (Left) -->
        <div class="lg:col-span-7 space-y-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-400/30 flex items-center justify-center text-amber-400 shadow-sm">
              <span class="material-symbols-outlined text-2xl">calculate</span>
            </div>
            <div>
              <h3 class="font-serif text-xl sm:text-2xl font-bold text-white tracking-tight">Live Points &amp; Cashback Calculator</h3>
              <p class="text-xs text-stone-400 font-light">Simulate your order spend and tier multiplier to view exact cash credits.</p>
            </div>
          </div>

          <!-- Purchase Amount Slider & Input -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <label class="font-mono text-xs font-bold text-stone-300 uppercase tracking-wider">Planned Purchase Value</label>
              <div class="flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-xl border border-white/20 focus-within:border-amber-400 focus-within:ring-2 focus-within:ring-amber-400/20 shadow-sm transition-all">
                <span class="text-xs font-serif font-bold text-[#e9c176]">₹</span>
                <input type="number" id="calcSpendInput" value="15000" min="500" max="250000" step="500" class="w-24 bg-transparent text-right font-serif font-bold text-sm text-white outline-none border-none">
              </div>
            </div>
            <input type="range" id="calcSpendSlider" min="1000" max="100000" step="1000" value="15000" class="w-full accent-amber-400 bg-white/20 h-2.5 rounded-lg cursor-pointer">
            <div class="flex items-center justify-between text-[11px] font-mono text-stone-400 mt-1">
              <span>₹1,000</span>
              <span>₹25,000</span>
              <span>₹50,000</span>
              <span>₹1,00,000+</span>
            </div>

            <!-- Quick Preset Chips -->
            <div class="flex flex-wrap gap-2 mt-3">
              <button type="button" onclick="setCalcSpend(2500)" class="px-3 py-1 rounded-lg bg-white/5 hover:bg-white/15 border border-white/10 text-[11px] font-mono font-medium text-stone-300 transition-all cursor-pointer">₹2,500</button>
              <button type="button" onclick="setCalcSpend(5000)" class="px-3 py-1 rounded-lg bg-white/5 hover:bg-white/15 border border-white/10 text-[11px] font-mono font-medium text-stone-300 transition-all cursor-pointer">₹5,000</button>
              <button type="button" onclick="setCalcSpend(15000)" class="px-3 py-1 rounded-lg bg-amber-500/20 hover:bg-amber-500/30 border border-amber-400 text-[11px] font-mono font-bold text-amber-300 transition-all cursor-pointer">₹15,000</button>
              <button type="button" onclick="setCalcSpend(35000)" class="px-3 py-1 rounded-lg bg-white/5 hover:bg-white/15 border border-white/10 text-[11px] font-mono font-medium text-stone-300 transition-all cursor-pointer">₹35,000</button>
              <button type="button" onclick="setCalcSpend(75000)" class="px-3 py-1 rounded-lg bg-white/5 hover:bg-white/15 border border-white/10 text-[11px] font-mono font-medium text-stone-300 transition-all cursor-pointer">₹75,000</button>
            </div>
          </div>

          <!-- Select VIP Tier -->
          <div>
            <label class="font-mono text-xs font-bold text-stone-300 uppercase tracking-wider block mb-2">Select Your VIP Tier Multiplier</label>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2" id="calcTierGrid">
              <button type="button" data-multiplier="1.0" data-tier="Bronze" onclick="setCalcTier(this, 1.0, 'Bronze')" class="calc-tier-btn p-2.5 rounded-xl border border-white/10 bg-white/[0.04] hover:border-amber-400/40 text-left transition-all cursor-pointer">
                <div class="text-sm">🥉</div>
                <div class="font-serif text-xs font-bold text-white mt-1">Bronze</div>
                <div class="font-mono text-[10px] text-stone-400">1.0× Base</div>
              </button>
              <button type="button" data-multiplier="1.2" data-tier="Silver" onclick="setCalcTier(this, 1.2, 'Silver')" class="calc-tier-btn p-2.5 rounded-xl border border-white/10 bg-white/[0.04] hover:border-sky-400/50 text-left transition-all cursor-pointer">
                <div class="text-sm">🥈</div>
                <div class="font-serif text-xs font-bold text-white mt-1">Silver</div>
                <div class="font-mono text-[10px] text-sky-300 font-semibold">1.2× Boost</div>
              </button>
              <button type="button" data-multiplier="1.5" data-tier="Gold" onclick="setCalcTier(this, 1.5, 'Gold')" class="calc-tier-btn active-tier p-2.5 rounded-xl border-2 border-amber-400 bg-amber-500/15 text-left transition-all shadow-md ring-2 ring-amber-400/20 cursor-pointer">
                <div class="text-sm">🥇</div>
                <div class="font-serif text-xs font-bold text-amber-300 mt-1">Gold</div>
                <div class="font-mono text-[10px] text-amber-300 font-bold">1.5× Boost</div>
              </button>
              <button type="button" data-multiplier="2.0" data-tier="Platinum" onclick="setCalcTier(this, 2.0, 'Platinum')" class="calc-tier-btn p-2.5 rounded-xl border border-white/10 bg-white/[0.04] hover:border-purple-400/50 text-left transition-all cursor-pointer">
                <div class="text-sm">💎</div>
                <div class="font-serif text-xs font-bold text-white mt-1">Platinum</div>
                <div class="font-mono text-[10px] text-purple-300 font-semibold">2.0× Boost</div>
              </button>
              <button type="button" data-multiplier="3.0" data-tier="Diamond" onclick="setCalcTier(this, 3.0, 'Diamond')" class="calc-tier-btn p-2.5 rounded-xl border border-white/10 bg-white/[0.04] hover:border-cyan-400/50 text-left transition-all cursor-pointer">
                <div class="text-sm">👑</div>
                <div class="font-serif text-xs font-bold text-white mt-1">Diamond</div>
                <div class="font-mono text-[10px] text-cyan-300 font-bold">3.0× Max</div>
              </button>
            </div>
          </div>

          <!-- VIP Subscription Pass Privilege Toggle -->
          <div class="flex items-center justify-between p-3.5 rounded-2xl bg-white/[0.04] border border-white/10 hover:border-amber-400/40 transition-all cursor-pointer" onclick="toggleCalcSubscription()">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-400/30 flex items-center justify-center text-amber-400">
                <span class="material-symbols-outlined text-base">verified</span>
              </div>
              <div>
                <span class="font-serif text-xs font-bold text-white block">Include Atelier VIP Club Pass</span>
                <span class="text-[10px] font-mono text-stone-400">+300 Monthly Point Bounty &amp; 15% VIP Privilege</span>
              </div>
            </div>
            <input type="checkbox" id="calcSubToggle" class="w-4 h-4 accent-amber-400 cursor-pointer" onchange="updateAtelierCalculator()">
          </div>
        </div>

        <!-- Real-Time Calculation Result HUD (Right) -->
        <div class="lg:col-span-5">
          <div class="bg-gradient-to-b from-[#161722] to-[#0a0b10] p-6 sm:p-7 rounded-2xl border border-amber-500/40 shadow-xl flex flex-col justify-between relative overflow-hidden">
            <!-- Top luxury gold accent line -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 via-amber-500 to-[#e9c176]"></div>

            <div class="flex items-center justify-between pb-4 border-b border-white/10">
              <span class="font-mono text-[11px] uppercase tracking-wider text-stone-400 font-semibold">Calculation Breakdown</span>
              <span id="calcTierBadge" class="px-2.5 py-1 rounded-full bg-amber-500/20 border border-amber-400/40 text-amber-300 font-mono text-[10px] font-bold">
                🥇 Gold (1.5×)
              </span>
            </div>

            <!-- Big Stat 1: Total Points -->
            <div class="my-5">
              <span class="text-[10.5px] font-mono text-stone-400 uppercase tracking-wider block mb-1">Total Points Earned</span>
              <div class="flex items-baseline gap-2">
                <span id="calcPointsTotal" class="font-serif text-4xl sm:text-5xl font-extrabold text-[#e9c176] tracking-tight">1,350</span>
                <span class="font-mono text-xs font-bold text-amber-400 uppercase">PTS</span>
              </div>
              <div class="text-[11.5px] font-mono text-emerald-400 font-semibold mt-1 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-emerald-400">savings</span>
                <span>Direct Cash Value: <strong id="calcCashbackVal" class="font-serif text-white text-sm">₹1,350.00</strong></span>
              </div>
            </div>

            <!-- Formula Transparency Card -->
            <div class="p-3.5 rounded-xl bg-white/[0.04] border border-white/10 text-[11px] font-mono text-stone-300 space-y-2 mb-5">
              <div class="flex justify-between">
                <span class="text-stone-400">Base Cashback (6% of spend):</span>
                <span id="calcBasePts" class="font-bold text-white">900 pts</span>
              </div>
              <div class="flex justify-between">
                <span class="text-stone-400">Tier Multiplier:</span>
                <span id="calcMultiplierLabel" class="font-bold text-amber-400">1.5×</span>
              </div>
              <div class="flex justify-between" id="calcSubBonusRow" style="display: none;">
                <span class="text-stone-400">VIP Pass Bounty:</span>
                <span class="font-bold text-purple-400">+300 pts</span>
              </div>
              <div class="flex justify-between pt-2 border-t border-white/10 font-bold">
                <span class="text-[#e9c176]">Effective Return Rate:</span>
                <span id="calcReturnPct" class="text-emerald-400">9.0% Yield</span>
              </div>
            </div>

            <!-- Milestone Progress Bar -->
            <div class="pt-1">
              <div class="flex justify-between text-[10.5px] font-mono mb-1.5">
                <span class="text-stone-400" id="calcProgressLabel">Next Tier: Platinum (₹70,000 away)</span>
                <span class="text-amber-400 font-bold" id="calcProgressPct">18%</span>
              </div>
              <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                <div id="calcProgressBar" class="bg-gradient-to-r from-amber-400 to-[#e9c176] h-full rounded-full transition-all duration-300" style="width: 18%;"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
         ATELIER CURATED SUBSCRIPTION PLANS (REAL & TRANSPARENT WHITE)
    ══════════════════════════════════════════════════════ -->
    <div class="mb-12">
      <div class="text-center max-w-xl mx-auto mb-8">
        <span class="font-mono text-[10.5px] text-amber-800 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full uppercase tracking-[0.2em] inline-block mb-2 font-bold">✦ Curated Deliveries ✦</span>
        <h3 class="font-serif text-2xl sm:text-3xl text-stone-950 font-bold">Bespoke Atelier Subscription Passes</h3>
        <p class="text-xs text-stone-500 font-normal mt-1">Select an ongoing subscription tier for guaranteed monthly designer capsules and whitelist privileges.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
        
        <!-- Plan 1: VIP Monthly Capsule Club -->
        <div class="bg-white p-7 sm:p-8 rounded-3xl border border-stone-200/90 hover:border-amber-400 hover:shadow-xl transition-all duration-300 flex flex-col justify-between group shadow-sm relative overflow-hidden">
          <div>
            <div class="flex items-center justify-between mb-4">
              <span class="px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-900 font-mono text-[10px] font-bold uppercase tracking-wider">
                Monthly Capsule
              </span>
              <span class="text-xs text-stone-500 font-mono">Auto-renews monthly</span>
            </div>
            <h4 class="font-serif text-xl font-bold text-stone-950 mb-1 group-hover:text-amber-800 transition-colors">VIP Monthly Capsule Club</h4>
            <p class="text-xs text-stone-600 font-normal mb-6">1 Exclusive 240 GSM heavy cotton streetwear graphic tee auto-delivered to your doorstep each month.</p>
            
            <div class="flex items-baseline gap-2 mb-6">
              <span class="font-serif text-4xl font-extrabold text-stone-950">₹999</span>
              <span class="font-mono text-xs text-stone-500">/ month</span>
              <span class="line-through font-mono text-xs text-stone-400 ml-1">₹1,999</span>
              <span class="text-[10px] font-mono font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded">50% OFF</span>
            </div>

            <ul class="space-y-3 text-xs font-mono text-stone-700 mb-6">
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
                <span>1 Exclusive Heavyweight Tee (240 GSM) Guaranteed</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
                <span>Free Doorstep Express White-Glove Delivery</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
                <span>15% Off all other catalog pieces</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
                <span>2× Double Points multiplier on all purchases</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-emerald-600 font-bold">check_circle</span>
                <span>Pause, skip, or cancel anytime with 1-click</span>
              </li>
            </ul>
          </div>

          <button type="button" onclick="ndToast('Redirecting to VIP Capsule Pass checkout...', 'info'); setTimeout(() => { window.location.href = '<?= base_url("cart") ?>'; }, 700);" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-400 to-[#e9c176] text-stone-950 font-mono text-xs font-bold uppercase tracking-wider hover:opacity-95 transition-all shadow-md hover:shadow-lg active:scale-98 cursor-pointer">
            Subscribe Now · ₹999/mo
          </button>
        </div>

        <!-- Plan 2: Atelier Seasonal Haute Mystery Box -->
        <div class="bg-white p-7 sm:p-8 rounded-3xl border-2 border-purple-300 hover:border-purple-500 hover:shadow-xl transition-all duration-300 flex flex-col justify-between group shadow-sm relative overflow-hidden">
          <div class="absolute top-0 right-0 px-4 py-1.5 bg-purple-700 text-white font-mono text-[9.5px] font-bold uppercase tracking-wider rounded-bl-xl shadow-xs">
            Collector's Choice
          </div>
          <div>
            <div class="flex items-center justify-between mb-4">
              <span class="px-3 py-1 rounded-full bg-purple-50 border border-purple-200 text-purple-900 font-mono text-[10px] font-bold uppercase tracking-wider">
                Quarterly Delivery
              </span>
              <span class="text-xs text-stone-500 font-mono">Delivered every 3 months</span>
            </div>
            <h4 class="font-serif text-xl font-bold text-stone-950 mb-1 group-hover:text-purple-800 transition-colors">Haute Mystery Capsule Box</h4>
            <p class="text-xs text-stone-600 font-normal mb-6">Curated 3-item luxury streetwear capsule box (3× Retail Value ₹7,500+) delivered every season.</p>
            
            <div class="flex items-baseline gap-2 mb-6">
              <span class="font-serif text-4xl font-extrabold text-stone-950">₹2,499</span>
              <span class="font-mono text-xs text-stone-500">/ quarter</span>
              <span class="line-through font-mono text-xs text-stone-400 ml-1">₹5,499</span>
              <span class="text-[10px] font-mono font-bold text-purple-700 bg-purple-50 border border-purple-200 px-1.5 py-0.5 rounded">55% OFF</span>
            </div>

            <ul class="space-y-3 text-xs font-mono text-stone-700 mb-6">
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-purple-600 font-bold">check_circle</span>
                <span>3 Luxury Streetwear Garments Guaranteed</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-purple-600 font-bold">check_circle</span>
                <span>Includes 1 Heavy Hoodie + 2 Tops/Accessories</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-purple-600 font-bold">check_circle</span>
                <span>48-Hour Private Whitelist Early Access</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-purple-600 font-bold">check_circle</span>
                <span>Priority VIP Doorstep Size Exchanges</span>
              </li>
              <li class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-sm text-purple-600 font-bold">check_circle</span>
                <span>Dedicated VIP AI Stylist Assistance</span>
              </li>
            </ul>
          </div>

          <button type="button" onclick="ndToast('Redirecting to Haute Mystery Box checkout...', 'info'); setTimeout(() => { window.location.href = '<?= base_url("cart") ?>'; }, 700);" class="w-full py-3.5 rounded-xl bg-stone-950 hover:bg-stone-800 text-white font-mono text-xs font-bold uppercase tracking-wider transition-all shadow-md hover:shadow-lg active:scale-98 cursor-pointer">
            Subscribe Now · ₹2,499/quarter
          </button>
        </div>

      </div>

      <!-- Trust Badges Bar -->
      <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-[11px] font-mono text-stone-600">
        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-emerald-600">verified_user</span> 100% Guaranteed Authentic</span>
        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-amber-600">local_shipping</span> Free Express White-Glove Logistics</span>
        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-sky-600">cached</span> Instant Doorstep Size Exchanges</span>
        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-sm text-purple-600">lock</span> Zero Lock-In · Pause or Cancel Anytime</span>
      </div>
    </div>

    <!-- Tier Quick-Indicator Badges Bar -->
    <div class="p-4 sm:p-5 rounded-2xl bg-[#faf9f6] border border-stone-200/90 flex flex-wrap items-center justify-between gap-4 shadow-2xs">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-amber-700 text-lg">military_tech</span>
        <span class="font-mono text-xs font-bold text-stone-800 uppercase tracking-wider">Active VIP Tiers:</span>
      </div>
      <div class="flex flex-wrap items-center gap-2 sm:gap-3">
        <span class="px-3 py-1.5 rounded-xl bg-white border border-stone-200 text-amber-900 font-mono text-xs font-bold flex items-center gap-1.5 shadow-2xs">
          <span>🥉</span> Bronze (1.0× · ₹0+)
        </span>
        <span class="px-3 py-1.5 rounded-xl bg-white border border-sky-200 text-sky-900 font-mono text-xs font-bold flex items-center gap-1.5 shadow-2xs">
          <span>🥈</span> Silver (1.2× · ₹15k+)
        </span>
        <span class="px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-300 text-amber-900 font-mono text-xs font-bold flex items-center gap-1.5 shadow-2xs">
          <span>🥇</span> Gold (1.5× · ₹40k+)
        </span>
        <span class="px-3 py-1.5 rounded-xl bg-white border border-purple-200 text-purple-900 font-mono text-xs font-bold flex items-center gap-1.5 shadow-2xs">
          <span>💎</span> Platinum (2.0× · ₹85k+)
        </span>
        <span class="px-3 py-1.5 rounded-xl bg-white border border-cyan-300 text-cyan-950 font-mono text-xs font-bold flex items-center gap-1.5 shadow-2xs">
          <span>👑</span> Diamond Sovereign (3.0× · ₹1.5L+)
        </span>
      </div>
    </div>

  </div>
</section>

<script>
// ── Atelier Points & Privilege Real-Time Calculator Logic ──
(function initAtelierPointsCalculator() {
  var currentMultiplier = 1.5;
  var currentTierName = 'Gold';
  var tierThresholds = {
    'Bronze': { min: 0, next: 15000, nextName: 'Silver (1.2×)' },
    'Silver': { min: 15000, next: 40000, nextName: 'Gold (1.5×)' },
    'Gold': { min: 40000, next: 85000, nextName: 'Platinum (2.0×)' },
    'Platinum': { min: 85000, next: 150000, nextName: 'Diamond Sovereign (3.0×)' },
    'Diamond': { min: 150000, next: 150000, nextName: 'Max Diamond Tier Unlocked' }
  };

  window.setCalcSpend = function(val) {
    var sInput = document.getElementById('calcSpendInput');
    var sSlider = document.getElementById('calcSpendSlider');
    if (sInput) sInput.value = val;
    if (sSlider) sSlider.value = val;
    updateAtelierCalculator();
  };

  window.setCalcTier = function(btnEl, multiplier, tierName) {
    currentMultiplier = multiplier;
    currentTierName = tierName;

    document.querySelectorAll('#calcTierGrid .calc-tier-btn').forEach(function(b) {
      b.classList.remove('border-2', 'border-amber-400', 'bg-amber-500/15', 'active-tier', 'shadow-md', 'ring-2', 'ring-amber-400/20');
      b.classList.add('border', 'border-white/10', 'bg-white/[0.04]');
      var nameEl = b.querySelector('.font-serif');
      if (nameEl) nameEl.className = 'font-serif text-xs font-bold text-white mt-1';
    });

    if (btnEl) {
      btnEl.classList.remove('border', 'border-white/10', 'bg-white/[0.04]');
      btnEl.classList.add('border-2', 'border-amber-400', 'bg-amber-500/15', 'active-tier', 'shadow-md', 'ring-2', 'ring-amber-400/20');
      var nameEl = btnEl.querySelector('.font-serif');
      if (nameEl) nameEl.className = 'font-serif text-xs font-bold text-amber-300 mt-1';
    }

    var badgeEl = document.getElementById('calcTierBadge');
    if (badgeEl) {
      var icon = tierName === 'Bronze' ? '🥉' : (tierName === 'Silver' ? '🥈' : (tierName === 'Gold' ? '🥇' : (tierName === 'Platinum' ? '💎' : '👑')));
      badgeEl.textContent = icon + ' ' + tierName + ' (' + multiplier.toFixed(1) + '×)';
    }

    updateAtelierCalculator();
  };

  window.toggleCalcSubscription = function() {
    var toggle = document.getElementById('calcSubToggle');
    if (toggle) {
      toggle.checked = !toggle.checked;
      updateAtelierCalculator();
    }
  };

  window.updateAtelierCalculator = function() {
    var spendInput = document.getElementById('calcSpendInput');
    var spend = parseFloat(spendInput ? spendInput.value : 15000) || 0;
    
    // Formula: 6% Base Cashback points (6 pts per ₹100) * Tier Multiplier + Subscription bonus (300 pts)
    var basePts = Math.round(spend * 0.06);
    var subToggle = document.getElementById('calcSubToggle');
    var subBonus = (subToggle && subToggle.checked) ? 300 : 0;
    var totalPts = Math.round((basePts * currentMultiplier) + subBonus);
    var cashVal = totalPts; // 1 pt = ₹1

    // Update Points display
    var ptsEl = document.getElementById('calcPointsTotal');
    if (ptsEl) ptsEl.textContent = totalPts.toLocaleString('en-IN');

    // Update Cash Value
    var cashEl = document.getElementById('calcCashbackVal');
    if (cashEl) cashEl.textContent = '₹' + cashVal.toLocaleString('en-IN') + '.00';

    // Update Base pts
    var baseEl = document.getElementById('calcBasePts');
    if (baseEl) baseEl.textContent = basePts.toLocaleString('en-IN') + ' pts';

    // Multiplier Label
    var multEl = document.getElementById('calcMultiplierLabel');
    if (multEl) multEl.textContent = currentMultiplier.toFixed(1) + '×';

    // Sub bonus row
    var subRow = document.getElementById('calcSubBonusRow');
    if (subRow) subRow.style.display = subBonus > 0 ? 'flex' : 'none';

    // Return Percentage Yield
    var returnPct = spend > 0 ? ((cashVal / spend) * 100).toFixed(1) : '6.0';
    var returnEl = document.getElementById('calcReturnPct');
    if (returnEl) returnEl.textContent = returnPct + '% Yield';

    // Milestone Progress
    var tData = tierThresholds[currentTierName] || tierThresholds['Bronze'];
    var progLabel = document.getElementById('calcProgressLabel');
    var progPctEl = document.getElementById('calcProgressPct');
    var progBar = document.getElementById('calcProgressBar');

    if (currentTierName === 'Diamond') {
      if (progLabel) progLabel.textContent = '👑 Maximum Sovereign Status Achieved';
      if (progPctEl) progPctEl.textContent = '100%';
      if (progBar) progBar.style.width = '100%';
    } else {
      var nextTarget = tData.next;
      var remaining = Math.max(0, nextTarget - spend);
      var pct = Math.min(100, Math.round((spend / nextTarget) * 100));
      if (progLabel) progLabel.textContent = 'Next Tier: ' + tData.nextName + ' (' + (remaining > 0 ? '₹' + remaining.toLocaleString('en-IN') + ' away' : 'Unlocked!') + ')';
      if (progPctEl) progPctEl.textContent = pct + '%';
      if (progBar) progBar.style.width = pct + '%';
    }
  };

  // Sync Input and Slider
  var sInput = document.getElementById('calcSpendInput');
  var sSlider = document.getElementById('calcSpendSlider');
  if (sInput && sSlider) {
    sInput.addEventListener('input', function() {
      sSlider.value = sInput.value;
      updateAtelierCalculator();
    });
    sSlider.addEventListener('input', function() {
      sInput.value = sSlider.value;
      updateAtelierCalculator();
    });
  }

  // Initialize
  setTimeout(updateAtelierCalculator, 100);
})();
</script>

<!-- ══════════════════════════════════════════════════════
     PRIVATE ACCESS: REQUEST ATELIER INVITATION (LUXURY OBSIDIAN BLACK)
══════════════════════════════════════════════════════ -->
<section class="py-16 md:py-24 bg-[#0a0b0e] border-t border-b border-stone-800 text-white scroll-unfold-section relative overflow-hidden" id="newsletterSection">
  <!-- Subtle warm ambient backdrop glow -->
  <div class="absolute w-96 h-96 rounded-full bg-amber-500/10 blur-[120px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

  <div class="max-w-xl mx-auto px-4 text-center relative z-10">
    <span class="font-mono text-xs text-[#e9c176] uppercase tracking-[0.25em] block mb-2 font-bold">✦ Private Access ✦</span>
    <h2 class="font-serif text-3xl sm:text-4xl text-white font-bold mb-3 tracking-tight">Request Atelier Invitation</h2>
    <p class="text-stone-300 mb-8 text-xs sm:text-sm font-light leading-relaxed max-w-md mx-auto">
      Receive private access to hand-numbered capsule releases, bespoke fittings, and runway previews.
    </p>

    <form class="flex flex-col sm:flex-row gap-2.5 max-w-md mx-auto" onsubmit="event.preventDefault(); ndToast('Your invitation request has been prioritized by the Atelier.', 'success'); this.reset();">
      <input type="email" placeholder="Enter your private email" required class="flex-1 bg-white/10 px-4 py-3.5 text-xs text-white placeholder:text-stone-400 border border-white/20 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl outline-none shadow-sm font-sans backdrop-blur-sm">
      <button type="submit" data-cursor="SUBMIT" class="bg-gradient-to-r from-amber-400 to-[#e9c176] hover:opacity-95 text-stone-950 font-mono text-xs uppercase tracking-wider px-7 py-3.5 font-extrabold shadow-md active:scale-95 transition-all cursor-pointer rounded-xl flex-shrink-0">
        Request Invitation
      </button>
    </form>

    <div class="mt-6 flex items-center justify-center gap-6 text-[10px] font-mono text-stone-400">
      <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs text-emerald-400">lock</span> Confidential &amp; Encrypted</span>
      <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs text-[#e9c176]">verified</span> Strict Zero Spam Guarantee</span>
    </div>
  </div>
</section>

<script>
// ════════════════════════════════════════════════════════════
// 3D SPATIAL PARALLAX SCROLLING & THREE.JS HERO ENGINE (OPTIMIZED)
// ════════════════════════════════════════════════════════════
(function initLumina3DParallax() {
  let scrollY = window.pageYOffset || document.documentElement.scrollTop;
  let targetScrollY = scrollY;
  let lastScrollY = scrollY;
  let scrollVelocity = 0;
  let ticking = false;

  // 1. Three.js Hero 3D Constellation & Floating Particle Field with IntersectionObserver Auto-Pause
  function initHero3DConstellation() {
    const canvas = document.getElementById('heroConstellationCanvas');
    if (!canvas || typeof THREE === 'undefined') return;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 30;

    const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true, powerPreference: "high-performance" });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.5));

    // Particle Constellation Geometry
    const particleCount = window.innerWidth < 768 ? 60 : 140;
    const geometry = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const scales = new Float32Array(particleCount);

    for (let i = 0; i < particleCount * 3; i += 3) {
      positions[i] = (Math.random() - 0.5) * 60;
      positions[i + 1] = (Math.random() - 0.5) * 40;
      positions[i + 2] = (Math.random() - 0.5) * 30;
      scales[i / 3] = Math.random() * 1.5 + 0.5;
    }

    geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geometry.setAttribute('scale', new THREE.BufferAttribute(scales, 1));

    const material = new THREE.PointsMaterial({
      color: 0xe9c176,
      size: 0.35,
      transparent: true,
      opacity: 0.65,
      blending: THREE.AdditiveBlending
    });

    const particles = new THREE.Points(geometry, material);
    scene.add(particles);

    // Floating 3D Geometric Ring
    const ringGeo = new THREE.TorusGeometry(8, 0.08, 16, 80);
    const ringMat = new THREE.MeshBasicMaterial({
      color: 0xe9c176,
      transparent: true,
      opacity: 0.25,
      wireframe: true
    });
    const ringMesh = new THREE.Mesh(ringGeo, ringMat);
    ringMesh.position.set(12, 0, -5);
    scene.add(ringMesh);

    // Secondary Nested Ring
    const ringGeo2 = new THREE.TorusGeometry(5.5, 0.05, 16, 60);
    const ringMesh2 = new THREE.Mesh(ringGeo2, ringMat);
    ringMesh2.position.set(12, 0, -5);
    scene.add(ringMesh2);

    let mouseX = 0;
    let mouseY = 0;
    let targetMouseX = 0;
    let targetMouseY = 0;

    window.addEventListener('mousemove', (e) => {
      targetMouseX = (e.clientX / window.innerWidth - 0.5) * 3;
      targetMouseY = (e.clientY / window.innerHeight - 0.5) * 3;
    }, { passive: true });

    let isHeroVisible = true;
    let animFrameId = null;

    // IntersectionObserver to sleep WebGL when scrolled away from Hero
    if ('IntersectionObserver' in window) {
      const heroObs = new IntersectionObserver((entries) => {
        isHeroVisible = entries[0].isIntersecting;
        if (isHeroVisible && !animFrameId) {
          animateConstellation();
        }
      }, { threshold: 0.05 });
      heroObs.observe(canvas.parentElement || canvas);
    }

    function animateConstellation() {
      if (!isHeroVisible) {
        animFrameId = null;
        return;
      }
      animFrameId = requestAnimationFrame(animateConstellation);

      mouseX += (targetMouseX - mouseX) * 0.05;
      mouseY += (targetMouseY - mouseY) * 0.05;

      particles.rotation.y += 0.0008;
      particles.rotation.x += 0.0004;

      ringMesh.rotation.x += 0.003;
      ringMesh.rotation.y += 0.004;
      ringMesh2.rotation.x -= 0.003;
      ringMesh2.rotation.z += 0.002;

      camera.position.x = mouseX;
      camera.position.y = -mouseY;
      camera.lookAt(scene.position);

      renderer.render(scene, camera);
    }
    animateConstellation();

    window.addEventListener('resize', () => {
      camera.aspect = window.innerWidth / window.innerHeight;
      camera.updateProjectionMatrix();
      renderer.setSize(window.innerWidth, window.innerHeight);
    }, { passive: true });
  }

  // 2. Scroll Progress Bar Update
  function updateScrollProgress() {
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    if (docHeight <= 0) return;
    const progress = Math.min(100, Math.max(0, (scrollY / docHeight) * 100));
    const progressBar = document.getElementById('scrollProgressBar');
    if (progressBar) progressBar.style.width = progress + '%';
  }

  // 3. Multi-Plane Parallax Layers Update (GPU Accelerated transform3d)
  const filmstripReel = document.getElementById('filmstripReel');
  const heroZoomBg = document.getElementById('heroZoomBg');
  const heroTiltCard = document.getElementById('heroTiltCard');

  function renderParallax() {
    scrollY += (targetScrollY - scrollY) * 0.15;
    scrollVelocity = (targetScrollY - lastScrollY);
    lastScrollY = targetScrollY;

    // Background Hero Depth Parallax
    if (heroZoomBg && scrollY < window.innerHeight * 1.3) {
      const heroOffset = scrollY * 0.22;
      const heroScale = 1.1 + (scrollY * 0.00015);
      heroZoomBg.style.transform = `translate3d(0, ${heroOffset}px, 0) scale(${heroScale})`;
    }

    // Foreground 3D Card (GPU Composited translate3d without Layout Reflow)
    if (heroTiltCard && scrollY < window.innerHeight * 1.3) {
      const fgOffset = -scrollY * 0.08;
      heroTiltCard.style.transform = `translate3d(0, ${fgOffset}px, 0)`;
    }

    // Kinetic Filmstrip Velocity Physics with 3D Skew
    if (filmstripReel && scrollY > 800 && scrollY < 2600) {
      const reelOffset = -scrollY * 0.35;
      const skewAmount = Math.max(-2.5, Math.min(2.5, scrollVelocity * 0.06));
      filmstripReel.style.transform = `translate3d(${reelOffset}px, 0, 0) skewX(${skewAmount}deg)`;
    }

    updateScrollProgress();

    if (Math.abs(targetScrollY - scrollY) > 0.15 || Math.abs(scrollVelocity) > 0.15) {
      requestAnimationFrame(renderParallax);
      ticking = true;
    } else {
      ticking = false;
    }
  }

  window.addEventListener('scroll', () => {
    targetScrollY = window.pageYOffset || document.documentElement.scrollTop;
    if (!ticking) {
      requestAnimationFrame(renderParallax);
      ticking = true;
    }
  }, { passive: true });

  // 4. Scroll-Unfold 3D IntersectionObserver
  const unfoldSections = document.querySelectorAll('.scroll-unfold-section');
  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  unfoldSections.forEach(sec => sectionObserver.observe(sec));

  // 5. Universal 3D Magnetic Gyro Card Tilt with Dynamic Specular Glare (Desktop & Mobile Touch)
  const tiltableCards = document.querySelectorAll('.tilt-card, .store-product-card, .ensemble-item-card, .loyalty-tier-card, .category-3d-item');

  tiltableCards.forEach(card => {
    let glare = card.querySelector('.tilt-glare');
    if (!glare) {
      glare = document.createElement('div');
      glare.className = 'tilt-glare';
      card.appendChild(glare);
    }

    // Desktop Mouse Move
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = ((y - centerY) / centerY) * -12;
      const rotateY = ((x - centerX) / centerX) * 12;

      const glareX = (x / rect.width) * 100;
      const glareY = (y / rect.height) * 100;

      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.03, 1.03, 1.03) translateZ(10px)`;
      card.style.boxShadow = `0 25px 50px -12px rgba(0,0,0,0.65), 0 0 30px rgba(233,193,118,0.18)`;

      if (glare) {
        glare.style.opacity = '1';
        glare.style.background = `radial-gradient(circle at ${glareX}% ${glareY}%, rgba(255,255,255,0.22), transparent 65%)`;
      }
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1) translateZ(0px)';
      card.style.boxShadow = '';
      if (glare) glare.style.opacity = '0';
    });

    // Mobile Touch Tilt
    card.addEventListener('touchstart', (e) => {
      if (e.touches && e.touches[0]) {
        const rect = card.getBoundingClientRect();
        const x = e.touches[0].clientX - rect.left;
        const y = e.touches[0].clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * -10;
        const rotateY = ((x - centerX) / centerX) * 10;
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.03, 1.03, 1.03) translateZ(8px)`;
        if (glare) glare.style.opacity = '1';
      }
    }, { passive: true });

    card.addEventListener('touchmove', (e) => {
      if (e.touches && e.touches[0]) {
        const rect = card.getBoundingClientRect();
        const x = e.touches[0].clientX - rect.left;
        const y = e.touches[0].clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * -10;
        const rotateY = ((x - centerX) / centerX) * 10;
        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.03, 1.03, 1.03) translateZ(8px)`;
      }
    }, { passive: true });

    card.addEventListener('touchend', () => {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1) translateZ(0px)';
      if (glare) glare.style.opacity = '0';
    });
  });

  // Mobile Device Orientation Gyroscope Tilt
  if (window.DeviceOrientationEvent && window.innerWidth <= 768) {
    window.addEventListener('deviceorientation', (e) => {
      if (e.gamma === null || e.beta === null) return;
      const tiltX = Math.max(-12, Math.min(12, e.gamma * 0.4));
      const tiltY = Math.max(-12, Math.min(12, (e.beta - 45) * 0.3));
      
      const heroCard = document.getElementById('heroTiltCard');
      if (heroCard) {
        heroCard.style.transform = `perspective(1000px) rotateX(${-tiltY}deg) rotateY(${tiltX}deg) scale3d(1.02, 1.02, 1.02)`;
      }
    }, { passive: true });
  }

  // Mobile Dynamic Island Floating Lookbook Pill Scroll Reveal
  window.addEventListener('scroll', () => {
    const island = document.getElementById('mobileDynamicIsland');
    if (!island) return;
    if (window.scrollY > 240) {
      island.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
      island.classList.add('opacity-100', 'translate-y-0');
    } else {
      island.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
      island.classList.remove('opacity-100', 'translate-y-0');
    }
  }, { passive: true });

  // Initial triggers
  initHero3DConstellation();
  renderParallax();
})();
</script>

<!-- ══════════════════════════════════════════════════════
     POWER CONVERSION ENGINE — JAVASCRIPT
══════════════════════════════════════════════════════ -->
<script>
// ════════════════════════════════════════════════════════════
// 1. EXIT INTENT DETECTION & POPUP ENGINE
// ════════════════════════════════════════════════════════════
(function() {
  let exitShown = false;
  
  // Desktop: mouse leaves top of viewport
  document.addEventListener('mouseleave', (e) => {
    if (e.clientY <= 0 && !exitShown && !sessionStorage.getItem('exitPopupShown')) {
      showExitPopup();
    }
  });

  // Mobile: show after 40s of browsing if haven't bought
  setTimeout(() => {
    if (!exitShown && !sessionStorage.getItem('exitPopupShown')) {
      // Only on mobile
      if (window.innerWidth < 768) showExitPopup();
    }
  }, 40000);

  // Also show if user scrolls back up quickly (intent to leave)
  let lastScrollY = 0;
  window.addEventListener('scroll', () => {
    const currentY = window.scrollY;
    if (lastScrollY - currentY > 200 && currentY < 800 && !exitShown && !sessionStorage.getItem('exitPopupShown')) {
      setTimeout(() => {
        if (!exitShown && !sessionStorage.getItem('exitPopupShown')) showExitPopup();
      }, 500);
    }
    lastScrollY = currentY;
  }, { passive: true });
})();

// ════════════════════════════════════════════════════════════
// 1. TIMELY & SCROLL-TRIGGERED VIP OFFER POPUP ENGINE
// ════════════════════════════════════════════════════════════
(function() {
  let offerShown = false;

  function triggerOfferPopup() {
    if (offerShown) return;
    if (sessionStorage.getItem('atelierOfferClaimed')) return;
    offerShown = true;
    showExitPopup();
  }

  // 1. Trigger as soon as user opens website and scrolls down (>180px)
  window.addEventListener('scroll', () => {
    if (!offerShown && window.scrollY > 180) {
      triggerOfferPopup();
    }
  }, { passive: true });

  // 2. Timely automatic popup after 4 seconds on page load
  setTimeout(() => {
    if (!offerShown) {
      triggerOfferPopup();
    }
  }, 4000);

  // 3. Desktop Exit Intent (mouse leaving top)
  document.addEventListener('mouseleave', (e) => {
    if (e.clientY <= 0 && !offerShown) {
      triggerOfferPopup();
    }
  });
})();

function showExitPopup() {
  const overlay = document.getElementById('exitIntentOverlay');
  const box = document.getElementById('exitIntentBox');
  if (!overlay) return;

  overlay.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
  overlay.classList.add('flex', 'opacity-100');
  if (box) {
    box.classList.remove('scale-95');
    box.classList.add('scale-100');
  }
  document.body.style.overflow = 'hidden';

  // Start live 10-min countdown timer
  if (!window._exitCountdownTimer) {
    let exitSecs = 599; // 9:59
    window._exitCountdownTimer = setInterval(() => {
      if (exitSecs <= 0) { clearInterval(window._exitCountdownTimer); return; }
      exitSecs--;
      const m = Math.floor(exitSecs / 60);
      const s = exitSecs % 60;
      const el = document.getElementById('exitCountdown');
      if (el) el.textContent = String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    }, 1000);
  }
}

function closeExitPopup() {
  const overlay = document.getElementById('exitIntentOverlay');
  const box = document.getElementById('exitIntentBox');
  if (!overlay) return;

  if (box) {
    box.classList.remove('scale-100');
    box.classList.add('scale-95');
  }
  overlay.classList.remove('opacity-100');
  overlay.classList.add('opacity-0', 'pointer-events-none');
  document.body.style.overflow = '';
  setTimeout(() => {
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
  }, 250);

  sessionStorage.setItem('atelierOfferClaimed', '1');
}

function claimOfferCoupon(code, amount, type) {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(code).catch(() => {});
  }
  if (typeof setQuickCoupon === 'function') {
    setQuickCoupon(code, amount, type);
  }
  if (typeof ndToast === 'function') {
    ndToast(`✦ Code ${code} copied! Offer applied to your Atelier bag.`, 'success');
  }
  closeExitPopup();
}





// ════════════════════════════════════════════════════════════
// 4. LAST CHANCE COUNTDOWN TIMER
// ════════════════════════════════════════════════════════════
(function() {
  // Set end time in localStorage for consistency across reloads
  const storageKey = 'lumina_flash_end';
  let endTime = parseInt(localStorage.getItem(storageKey) || '0');
  
  if (!endTime || endTime < Date.now()) {
    // 7h42m from now
    endTime = Date.now() + (7 * 3600 + 42 * 60) * 1000;
    localStorage.setItem(storageKey, endTime);
  }

  function updateLC() {
    const diff = Math.max(0, endTime - Date.now());
    if (diff === 0) {
      // Reset to new timer
      endTime = Date.now() + (7 * 3600 + 42 * 60) * 1000;
      localStorage.setItem(storageKey, endTime);
    }
    
    const h = Math.floor(diff / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    
    const formatted = String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
    const el = document.getElementById('lcTimerDisplay');
    if (el) el.textContent = formatted;
  }
  
  updateLC();
  setInterval(updateLC, 1000);
})();

// ════════════════════════════════════════════════════════════
// 5. SCROLL-TRIGGERED STATS COUNTER ANIMATION
// ════════════════════════════════════════════════════════════
(function() {
  const statsSection = document.getElementById('statsSection');
  if (!statsSection) return;
  
  let animated = false;
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting && !animated) {
        animated = true;
        // Animate stat number displays with a pulse
        ['stat1','stat2','stat3','stat4'].forEach((id, i) => {
          const el = document.getElementById(id);
          if (el) {
            setTimeout(() => {
              el.style.animation = 'countUp 0.6s ease forwards';
              el.style.opacity = '1';
              // Flash gold glow
              el.style.transition = 'text-shadow 0.3s ease';
              el.style.textShadow = '0 0 30px rgba(233,193,118,0.8), 0 0 60px rgba(233,193,118,0.4)';
              setTimeout(() => {
                el.style.textShadow = '0 0 20px rgba(233,193,118,0.5), 0 0 40px rgba(233,193,118,0.2)';
              }, 600);
            }, i * 150);
          }
        });
        observer.disconnect();
      }
    });
  }, { threshold: 0.3 });
  
  observer.observe(statsSection);
})();

// ════════════════════════════════════════════════════════════
// 6. LIVE SCARCITY BAR ANIMATE-IN
// ════════════════════════════════════════════════════════════
(function() {
  const lastChanceSection = document.getElementById('lastChanceSection');
  if (!lastChanceSection) return;
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Animate scarcity bars
        document.querySelectorAll('.scarcity-bar').forEach(bar => {
          const targetWidth = bar.style.width;
          bar.style.width = '0%';
          setTimeout(() => {
            bar.style.width = targetWidth;
          }, 300);
        });
        observer.disconnect();
      }
    });
  }, { threshold: 0.2 });
  
  observer.observe(lastChanceSection);
})();

// ════════════════════════════════════════════════════════════
// 7. DYNAMIC TYPING SOCIAL PROOF BANNER
// ════════════════════════════════════════════════════════════
(function() {
  // Randomly fluctuate purchase count in announcement bar-like elements
  const liveCountEls = document.querySelectorAll('[data-live-count]');
  if (!liveCountEls.length) return;
  
  function updateLiveCount() {
    liveCountEls.forEach(el => {
      const base = parseInt(el.getAttribute('data-live-base') || '847');
      const delta = Math.floor((Math.random() - 0.3) * 5);
      const newVal = Math.max(base - 50, Math.min(base + 100, base + delta));
      el.setAttribute('data-live-base', newVal);
      el.textContent = newVal.toLocaleString();
    });
    setTimeout(updateLiveCount, 4000 + Math.random() * 3000);
  }
  
  setTimeout(updateLiveCount, 8000);
})();

// ════════════════════════════════════════════════════════════
// 8. DEAL CARDS VIEWPORT STAGGER ANIMATION
// ════════════════════════════════════════════════════════════
(function() {
  const dealSection = document.getElementById('lastChanceSection');
  if (!dealSection) return;
  
  const dealCards = dealSection.querySelectorAll('.deal-card-glow');
  const dealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        dealCards.forEach((card, i) => {
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
          }, i * 120);
        });
        dealObserver.disconnect();
      }
    });
  }, { threshold: 0.1 });
  
  // Set initial state
  dealCards.forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px) scale(0.97)';
    card.style.transition = 'opacity 0.5s ease, transform 0.5s cubic-bezier(0.16,1,0.3,1)';
  });
  
  dealObserver.observe(dealSection);
})();

// ════════════════════════════════════════════════════════════
// 9. REAL-TIME VIEWER COUNT ON PRODUCT HOVER (Urgency)
// ════════════════════════════════════════════════════════════
(function() {
  // Show "N people viewing" on flash deal cards
  document.querySelectorAll('.deal-card-glow').forEach(card => {
    const count = Math.floor(Math.random() * 30) + 12;
    const badge = document.createElement('div');
    badge.style.cssText = `
      position: absolute; top: 3px; right: 3px; z-index: 20;
      background: rgba(0,0,0,0.75); backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,0.1); border-radius: 20px;
      padding: 3px 8px; font-size: 9px; color: rgba(255,255,255,0.7);
      font-family: monospace; display: flex; align-items: center; gap: 4px;
      pointer-events: none;
    `;
    badge.innerHTML = `<span style="width:5px;height:5px;border-radius:50%;background:#10b981;display:inline-block;box-shadow:0 0 4px #10b981"></span>${count} viewing`;
    
    const imgContainer = card.querySelector('.relative.aspect-\\[4\\/5\\]');
    if (imgContainer) {
      imgContainer.style.position = 'relative';
      imgContainer.appendChild(badge);
      
      // Fluctuate viewer count
      let viewCount = count;
      setInterval(() => {
        viewCount = Math.max(5, viewCount + Math.floor((Math.random() - 0.4) * 3));
        badge.querySelector('span + *') && (badge.lastChild.textContent = ` ${viewCount} viewing`);
        badge.innerHTML = `<span style="width:5px;height:5px;border-radius:50%;background:#10b981;display:inline-block;box-shadow:0 0 4px #10b981"></span>${viewCount} viewing`;
      }, 5000 + Math.random() * 3000);
    }
  });
})();
</script>




