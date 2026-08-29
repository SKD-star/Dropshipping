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





<?php 
  $_wa_enabled = isset($home_settings['whatsapp_enabled']) ? (int)$home_settings['whatsapp_enabled'] : 1;
  $_wa_num = !empty($home_settings['whatsapp_number']) ? preg_replace('/[^0-9]/', '', $home_settings['whatsapp_number']) : '919999999999';
  $_wa_msg = !empty($home_settings['whatsapp_message']) ? urlencode($home_settings['whatsapp_message']) : urlencode('Hi! I found your Lumina Atelier store and need styling help.');
?>
<?php if ($_wa_enabled): ?>
<!-- ══ WHATSAPP LIVE CONCIERGE BUTTON ══ -->
<a id="whatsappBtn" href="https://wa.me/<?= $_wa_num ?>?text=<?= $_wa_msg ?>" target="_blank" rel="noopener" class="fixed bottom-5 sm:bottom-6 right-4 sm:right-6 z-40 w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center shadow-2xl transition-all duration-300 hover:scale-110 active:scale-95 cursor-pointer" style="background: linear-gradient(135deg, #25d366, #128c7e);" title="Chat on WhatsApp">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="26" height="26">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
  </svg>
</a>
<?php endif; ?>


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
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
              <span id="heroCountdownTimer">04h : 38m : 12s</span>
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
                <span class="material-symbols-outlined text-xs">check_circle</span>
                <span>Only 3 Left</span>
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
                <span class="text-[10px] sm:text-[11px] text-emerald-400 font-bold block sm:mt-0.5">Save <span data-price-inr="<?= $save_amount ?>">₹<?= number_format($save_amount, 0) ?></span></span>
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

          <!-- Interactive Motion Stage Badge -->
          <div class="absolute bottom-4 sm:bottom-6 left-4 sm:left-6 right-4 sm:right-6 flex justify-between items-end gap-2">
            <div>
              <span class="font-label-caps text-[9px] sm:text-[10px] uppercase tracking-widest text-[#e9c176] block mb-1" id="motionStageTag">Category 01 · Outerwear</span>
              <h3 class="font-headline-sm text-base sm:text-xl text-white font-serif truncate" id="motionStageTitle">The Atelier Cashmere Cocoon Coat</h3>
              <p class="text-[11px] sm:text-xs text-white/70 font-light mt-0.5 line-clamp-1" id="motionStageDesc">Relaxed drop shoulder with double-faced insulation.</p>
            </div>
            <button id="motionStageBtn" onclick="event.stopPropagation(); addToCart(1, 1)" data-cursor="ACQUIRE" class="px-3.5 sm:px-5 py-2 sm:py-2.5 bg-white text-black font-button text-[10px] sm:text-xs uppercase tracking-wider hover:bg-[#e9c176] transition-colors rounded-none shadow-lg cursor-pointer flex-shrink-0">
              Acquire +
            </button>
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

          $stock_left = 3 + ($idx % 5);
        ?>
        <div class="store-product-card group bg-white text-stone-900 rounded-xl sm:rounded-2xl border border-stone-200 hover:border-[#a16207]/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-sm hover:shadow-xl" data-category="<?= $cat_tag ?>">
          
          <!-- Image & Scarcity Badge -->
          <div class="relative aspect-[3/4] bg-stone-100 overflow-hidden cursor-pointer" onclick="window.location.href='<?= base_url('products/' . $prod['slug']) ?>'">
            <img src="<?= htmlspecialchars($prod_img) ?>" alt="<?= htmlspecialchars($prod['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            
            <!-- Top Badges -->
            <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-col gap-1 z-10">
              <span class="text-[8px] sm:text-[9px] font-mono font-bold uppercase tracking-wider bg-black/80 backdrop-blur-md text-[#e9c176] px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full border border-white/10 flex items-center gap-1 shadow-md">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Only <?= $stock_left ?> Left</span>
              </span>
            </div>

            <!-- Quick Direct Actions -->
            <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex items-center gap-1 sm:gap-1.5 z-10" onclick="event.stopPropagation()">
              <button type="button" onclick="toggleWishlistItem({id:<?= (int)$prod['id'] ?>, title:'<?= addslashes(htmlspecialchars($prod['title'])) ?>', price:<?= $prod_price ?>, image:'<?= addslashes($prod_img) ?>'})" 
                 class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/80 hover:bg-black text-rose-400 flex items-center justify-center border border-white/20 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 cursor-pointer group/fav"
                 title="Save to Wardrobe">
                <span class="material-symbols-outlined text-[11px] sm:text-[13px] group-hover/fav:scale-110 transition-transform">favorite</span>
              </button>
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
                <span class="text-[8px] sm:text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold truncate">Atelier</span>
                <span class="inline-flex items-center gap-0.5 text-[9px] sm:text-[10px] font-mono font-bold text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded-full border border-amber-200">
                  <span class="text-amber-500 text-[10px]">★</span> 4.9
                </span>
              </div>

              <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 mb-1 group-hover:text-[#a16207] transition-colors line-clamp-1">
                <a href="<?= base_url('products/' . $prod['slug']) ?>"><?= htmlspecialchars($prod['title']) ?></a>
              </h3>

              <div class="flex items-baseline justify-between gap-1 mb-2 sm:mb-4">
                <span class="font-serif font-bold text-xs sm:text-base text-stone-950" data-price-inr="<?= $prod_price ?>">₹<?= number_format($prod_price, 0) ?></span>
                <span class="hidden sm:flex text-[9px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-mono font-bold items-center gap-1 border border-emerald-200">
                  <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                  <span>Free Air</span>
                </span>
              </div>
            </div>

            <!-- Direct In-Site Buy Action Buttons -->
            <div class="pt-2 sm:pt-3 border-t border-stone-100">
              <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                <button onclick="openAtelierFitModal({id: <?= $prod['id'] ?>, title: '<?= addslashes($prod['title']) ?>', price: <?= $prod_price ?>, compare_price: 0, image: '<?= htmlspecialchars($prod_img) ?>', vendor: '<?= addslashes($prod['vendor'] ?? 'Lumina Atelier') ?>', category: '<?= $cat_tag ?>'});" class="w-full py-1.5 sm:py-2.5 bg-stone-50 border border-stone-200 hover:border-stone-400 text-stone-900 font-mono text-[8.5px] sm:text-[10px] uppercase font-bold tracking-wider hover:bg-stone-100 transition-all flex items-center justify-center gap-1 cursor-pointer shadow-2xs rounded-lg sm:rounded-xl active:scale-95">
                  <span class="material-symbols-outlined text-[11px] sm:text-[13px] text-[#a16207]">shopping_bag</span>
                  <span>Acquire</span>
                </button>
                <button onclick="openExpressCheckout(<?= $prod['id'] ?>, '<?= addslashes($prod['title']) ?>', <?= $prod_price ?>, '<?= htmlspecialchars($prod_img) ?>', <?= $prod['id'] ?>);" 
                   class="w-full py-1.5 sm:py-2.5 bg-stone-950 hover:bg-stone-800 text-white font-mono font-extrabold text-[8.5px] sm:text-[10.5px] uppercase tracking-wider transition-all flex items-center justify-center gap-1 cursor-pointer shadow-sm rounded-lg sm:rounded-xl active:scale-95 border border-stone-900">
                  <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current text-[#e9c176] flex-shrink-0" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
                  <span>Buy</span>
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
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
              <span>Only <?= (2 + ($idx % 4)) ?> Left</span>
            </span>
          </div>

          <!-- Top-Right Actions -->
          <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex items-center gap-1 sm:gap-1.5 z-10" onclick="event.stopPropagation()">
            <button type="button" onclick="toggleWishlistItem({id:<?= (int)$nprod['id'] ?>, title:'<?= addslashes(htmlspecialchars($nprod['title'])) ?>', price:<?= $n_price ?>, image:'<?= addslashes($n_img) ?>'})" 
               class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/80 hover:bg-black text-rose-400 flex items-center justify-center border border-white/20 shadow-md backdrop-blur-md transition-all hover:scale-110 active:scale-95 cursor-pointer group/fav"
               title="Save to Wardrobe">
              <span class="material-symbols-outlined text-[11px] sm:text-[13px] group-hover/fav:scale-110 transition-transform">favorite</span>
            </button>
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
              <span class="text-[8px] sm:text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold truncate">Atelier</span>
              <span class="inline-flex items-center gap-0.5 text-[9px] sm:text-[10px] font-mono font-bold text-amber-700 bg-amber-50 px-1.5 py-0.2 rounded-full border border-amber-200">
                <span class="text-amber-500 text-[10px]">★</span> 4.9
              </span>
            </div>

            <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 mb-1 group-hover:text-[#a16207] transition-colors line-clamp-1">
              <a href="<?= base_url('products/' . $nprod['slug']) ?>"><?= htmlspecialchars($nprod['title']) ?></a>
            </h3>

            <div class="flex items-baseline justify-between gap-1 mb-2 sm:mb-4">
              <span class="font-serif font-bold text-xs sm:text-base text-stone-950" data-price-inr="<?= $n_price ?>">₹<?= number_format($n_price, 0) ?></span>
              <span class="hidden sm:flex text-[9px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md font-mono font-bold items-center gap-1 border border-emerald-200">
                <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Free Air</span>
              </span>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-stone-100">
            <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
              <button onclick="openAtelierFitModal({id: <?= $nprod['id'] ?>, title: '<?= addslashes($nprod['title']) ?>', price: <?= $n_price ?>, compare_price: 0, image: '<?= htmlspecialchars($n_img) ?>', vendor: '<?= addslashes($nprod['vendor'] ?? 'Lumina Atelier') ?>', category: 'new'});" class="w-full py-1.5 sm:py-2.5 bg-stone-50 border border-stone-200 hover:border-stone-400 text-stone-900 font-mono text-[8.5px] sm:text-[10px] uppercase font-bold tracking-wider hover:bg-stone-100 transition-all flex items-center justify-center gap-1 cursor-pointer shadow-2xs rounded-lg sm:rounded-xl active:scale-95">
                <span class="material-symbols-outlined text-[11px] sm:text-[13px] text-[#a16207]">shopping_bag</span>
                <span>Acquire</span>
              </button>
              <button onclick="openExpressCheckout(<?= $nprod['id'] ?>, '<?= addslashes($nprod['title']) ?>', <?= $n_price ?>, '<?= htmlspecialchars($n_img) ?>', <?= $nprod['id'] ?>);" 
                 class="w-full py-1.5 sm:py-2.5 bg-stone-950 hover:bg-stone-800 text-white font-mono font-extrabold text-[8.5px] sm:text-[10.5px] uppercase tracking-wider transition-all flex items-center justify-center gap-1 cursor-pointer shadow-sm rounded-lg sm:rounded-xl active:scale-95 border border-stone-900">
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current text-[#e9c176] flex-shrink-0" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
                <span>Buy</span>
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
var motionTilesData = [
  {
    tag: "Category 01 · Outerwear",
    title: "The Atelier Cashmere Cocoon Coat",
    desc: "100% Double-faced Mongolian cashmere with hand-stitched horn buttons.",
    img: "<?= base_url('img/cashmere_cocoon_coat.jpg') ?>",
    id: 6
  },
  {
    tag: "Category 02 · Denim",
    title: "13.5oz Okayama Selvedge Trousers",
    desc: "Woven on vintage shuttle looms in Japan with custom brass hardware.",
    img: "https://images.unsplash.com/photo-1509631179647-0177331693ae?w=1000&q=85",
    id: 3
  },
  {
    tag: "Category 03 · Essentials",
    title: "Sculpted Heavyweight Terry Hoodie",
    desc: "480GSM organic cotton French terry with pre-shrunk density.",
    img: "https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=1000&q=85",
    id: 2
  },
  {
    tag: "Category 04 · Eveningwear",
    title: "Mulberry Silk Bias-Cut Slip Dress",
    desc: "22-Momme Grade 6A mulberry silk with sandwashed liquid drape.",
    img: "https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1000&q=85",
    id: 4
  },
  {
    tag: "Category 05 · Suiting",
    title: "Super 150s Italian Wool Blazer",
    desc: "Vitale Barberis Canonico virgin wool with floating horsehair canvas.",
    img: "https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1000&q=85",
    id: 5
  },
  {
    tag: "Category 06 · Tailoring",
    title: "Architectural Linen & Wool Blazers",
    desc: "Unstructured drape designed for multi-seasonal layering.",
    img: "<?= base_url('img/italian_pleated_trousers.jpg') ?>",
    id: 1
  },
  {
    tag: "Category 07 · Limited Edition",
    title: "Hand-Numbered Atelier Capsule 08",
    desc: "Only 50 pieces crafted worldwide per seasonal release.",
    img: "https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1000&q=85",
    id: 4
  }
];

function activateMotionTile(index) {
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
  img.style.opacity = '0.3';
  img.style.transform = 'scale(0.97)';

  setTimeout(() => {
    img.src = data.img;
    document.getElementById('motionStageTag').textContent = data.tag;
    document.getElementById('motionStageTitle').textContent = data.title;
    document.getElementById('motionStageDesc').textContent = data.desc;
    document.getElementById('motionStageBtn').setAttribute('onclick', 'addToCart(' + data.id + ', 1)');
    img.style.opacity = '1';
    img.style.transform = 'scale(1)';
  }, 180);
}

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

          <!-- Try On CTA -->
          <button onclick="openVirtualTryOn()" class="w-full py-3 rounded-xl border border-stone-300 bg-white text-[#a16207] text-xs font-button uppercase tracking-wider hover:bg-amber-50 transition-all flex items-center justify-center gap-2 group cursor-pointer shadow-2xs font-semibold">
            <span class="material-symbols-outlined text-sm group-hover:animate-bounce">camera_alt</span>
            <span>Try On Look (Virtual Mirror) →</span>
          </button>
        </div>

      </div>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     AI BLOCK 2: VIRTUAL FITTING ROOM (CAMERA / UPLOAD / SIZING)
══════════════════════════════════════════════════════ -->
<section class="py-16 bg-black border-y border-white/10 relative overflow-hidden scroll-unfold-section" id="vtrSection">
  <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(ellipse 60% 80% at 50% 50%, rgba(233,193,118,0.06), transparent);"></div>

  <div class="max-w-7xl mx-auto px-4 md:px-8 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

      <!-- Left: Text -->
      <div>
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-[#e9c176]/10 border border-[#e9c176]/25 text-[#e9c176] text-xs font-mono uppercase tracking-widest mb-5">
          <span class="material-symbols-outlined text-sm">camera_front</span>
          Virtual Fitting Room · AI Try-On
        </div>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-serif text-white mb-4 leading-tight">
          See It On <span class="italic text-[#e9c176]">Your Body.</span><br>Before You Buy.
        </h2>
        <p class="text-white/60 text-sm leading-relaxed mb-6 max-w-md font-light">
          Upload your photo or take a live camera shot. Choose your body type and exact size (XS–3XL). Our AI models how garments drape on your silhouette with real-time sizing advice.
        </p>

        <!-- Feature Pills -->
        <div class="flex flex-wrap gap-2.5 mb-8">
          <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full text-[11px] text-white/70"><span class="text-emerald-400">✓</span> Processed locally & safely</span>
          <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full text-[11px] text-white/70"><span class="text-emerald-400">✓</span> Precision sizes XS to 3XL</span>
          <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full text-[11px] text-white/70"><span class="text-emerald-400">✓</span> 4 body silhouettes</span>
          <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full text-[11px] text-white/70"><span class="text-emerald-400">✓</span> AI Fit Score & drape</span>
        </div>

        <button onclick="openVirtualTryOn()" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-[#a16207] to-[#e9c176] text-black font-button text-sm uppercase tracking-wider font-extrabold rounded-2xl hover:opacity-90 hover:scale-105 transition-all shadow-xl shadow-amber-900/30 cursor-pointer">
          <span class="material-symbols-outlined">camera_alt</span>
          Launch Virtual Fitting Room
        </button>
      </div>

      <!-- Right: Preview Phone Card -->
      <div class="relative">
        <div class="relative mx-auto" style="max-width:320px;">
          <div class="bg-gradient-to-b from-[#1a1a1a] to-[#0a0a0a] rounded-[40px] p-3 shadow-2xl border border-white/10" style="box-shadow: 0 40px 80px rgba(0,0,0,0.8);">
            <!-- Phone Notch -->
            <div class="w-24 h-5 bg-black rounded-full mx-auto mb-2 flex items-center justify-center">
              <div class="w-2.5 h-2.5 rounded-full bg-[#222] border border-white/10"></div>
            </div>
            <!-- Screen content -->
            <div class="bg-black rounded-[28px] overflow-hidden" style="aspect-ratio:9/16;max-height:460px;position:relative;">
              <div class="absolute inset-0 flex items-center justify-center" style="background:linear-gradient(180deg,#141414 0%,#090909 100%);">

                <!-- Vector Model Simulation -->
                <svg viewBox="0 0 120 220" style="width:62%;height:82%;opacity:0.95;" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <!-- Head -->
                  <circle cx="60" cy="24" r="16" fill="#fcd34d" fill-opacity="0.2" stroke="#e9c176" stroke-width="1.2"/>
                  <!-- Torso / Garment -->
                  <path d="M24 50 Q36 45 48 47 L54 47 L60 45 L66 47 L72 47 Q84 45 96 50 L100 90 Q86 95 72 96 L48 96 Q34 95 20 90 Z" fill="#1e1e1e" stroke="#e9c176" stroke-width="1.5"/>
                  <!-- Collar -->
                  <path d="M54 47 L60 55 L66 47" stroke="#e9c176" stroke-width="1.5" fill="none"/>
                  <!-- Arms -->
                  <path d="M24 50 L12 88 Q12 92 18 92 L24 70 L30 90 Q34 94 38 91 L32 50" fill="#1e1e1e" stroke="rgba(233,193,118,0.5)" stroke-width="1"/>
                  <path d="M96 50 L108 88 Q108 92 102 92 L96 70 L90 90 Q86 94 82 91 L88 50" fill="#1e1e1e" stroke="rgba(233,193,118,0.5)" stroke-width="1"/>
                  <!-- Belt -->
                  <rect x="46" y="96" width="28" height="4" rx="2" fill="#e9c176"/>
                  <!-- Trousers -->
                  <path d="M46 100 L40 170 Q39 175 46 176 L52 176 L57 112 L57 100 Z" fill="#16181d" stroke="rgba(100,100,160,0.5)" stroke-width="1"/>
                  <path d="M74 100 L80 170 Q81 175 74 176 L68 176 L63 112 L63 100 Z" fill="#16181d" stroke="rgba(100,100,160,0.5)" stroke-width="1"/>
                  <!-- Shoes -->
                  <ellipse cx="43" cy="178" rx="8" ry="3.5" fill="#332211"/>
                  <ellipse cx="77" cy="178" rx="8" ry="3.5" fill="#332211"/>
                </svg>

                <!-- Size Badge in Mockup -->
                <div style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.85);border:1px solid #e9c176;border-radius:20px;padding:3px 10px;color:#e9c176;font-size:9px;font-family:monospace;font-weight:700;">SIZE M · 96% FIT</div>

                <!-- AI Analysis Mockup -->
                <div style="position:absolute;bottom:12px;left:12px;right:12px;background:rgba(0,0,0,0.88);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:8px 10px;">
                  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                    <span style="font-size:9px;font-family:monospace;color:rgba(255,255,255,0.5);text-transform:uppercase;">AI Drape Analysis</span>
                    <span style="font-size:10px;color:#10b981;font-weight:700;">Optimal</span>
                  </div>
                  <div style="height:3px;background:rgba(255,255,255,0.1);border-radius:2px;overflow:hidden;">
                    <div style="height:100%;width:96%;background:linear-gradient(90deg,#a16207,#e9c176);border-radius:2px;"></div>
                  </div>
                  <div style="font-size:9px;color:rgba(255,255,255,0.6);margin-top:4px;">Shoulders &amp; waist aligned seamlessly.</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════════════════
     ATELIER SIZE & STYLE CONCIERGE MODAL (PURE WHITE · COMPLETE LOOKS)
══════════════════════════════════════════════════════ -->
<div id="atelierFitModal" data-lenis-prevent="true" data-lenis-prevent-wheel="true" data-lenis-prevent-touch="true" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[120] hidden items-center justify-center p-2 sm:p-4 md:p-6 overflow-y-auto" style="overscroll-behavior: contain;" onclick="if(event.target===this)closeAtelierFitModal()">
  <div id="atelierFitModalInner" data-lenis-prevent="true" data-lenis-prevent-wheel="true" data-lenis-prevent-touch="true" class="bg-white text-stone-900 p-5 sm:p-7 md:p-8 rounded-3xl max-w-4xl w-full border border-stone-200 shadow-2xl relative my-auto overflow-y-auto max-h-[92vh] custom-scrollbar" style="overscroll-behavior: contain; -webkit-overflow-scrolling: touch;">
    
    <!-- Modal Header -->
    <div class="flex items-center justify-between pb-4 border-b border-stone-200 mb-6">
      <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-[#a16207] text-[10px] font-mono font-bold uppercase tracking-wider mb-1.5 border border-amber-200">
          <span class="w-1.5 h-1.5 rounded-full bg-[#a16207] animate-ping"></span>
          <span>Atelier Fit &amp; Ensemble Styling</span>
        </div>
        <h3 class="font-serif text-xl sm:text-2xl text-stone-900 font-bold" id="afmModalHeading">Select Fit &amp; Complete The Look</h3>
      </div>
      <button type="button" onclick="closeAtelierFitModal()" class="w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center cursor-pointer transition-all hover:scale-105" aria-label="Close Modal">
        <span class="material-symbols-outlined text-lg">close</span>
      </button>
    </div>

    <!-- ── 1. SELECTED PRODUCT FIT & SIZE SELECTION (PRIMARY) ── -->
    <div class="bg-stone-50 border border-stone-200 rounded-2xl p-4 sm:p-5 mb-6">
      <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-4 pb-4 border-b border-stone-200">
        <img id="afmProductImg" src="<?= base_url('img/cashmere_cocoon_coat.jpg') ?>" class="w-20 h-24 sm:w-24 sm:h-28 object-cover rounded-xl border border-stone-200 shadow-sm flex-shrink-0 bg-stone-100 cursor-pointer hover:opacity-90 transition-opacity" onclick="openProductQuickViewModal(currentAfmProduct)" alt="Product Image">
        <div class="flex-1 min-w-0">
          <div class="flex items-center gap-2 mb-1">
            <span class="text-[10px] uppercase font-mono tracking-widest text-[#a16207] font-semibold" id="afmVendor">LUMINA ATELIER</span>
            <span class="text-[10px] bg-emerald-50 text-emerald-700 font-mono px-2 py-0.5 rounded-full border border-emerald-200 font-medium">★ 4.9 · In Stock (Only 3 Left)</span>
          </div>
          <h4 id="afmProductTitle" class="font-serif text-base sm:text-lg text-stone-900 font-bold truncate cursor-pointer hover:text-[#a16207] transition-colors" onclick="openProductQuickViewModal(currentAfmProduct)">The Atelier Cashmere Cocoon Coat</h4>
          <div class="flex items-baseline gap-2 mt-1">
            <span id="afmProductPrice" class="font-serif font-bold text-lg sm:text-xl text-stone-900" data-price-inr="4999">₹4,999</span>
            <span id="afmProductComparePrice" class="text-xs text-stone-400 line-through" data-price-inr="8999">₹8,999</span>
            <span class="text-[10px] text-emerald-600 font-semibold font-mono">Complimentary Insured Express Delivery</span>
          </div>
        </div>
      </div>

      <!-- Size Selection Row -->
      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="text-xs font-mono uppercase tracking-wider text-stone-700 font-bold">1. Select Your Size / Fit:</label>
          <span class="text-[11px] text-[#a16207] font-mono font-semibold" id="afmActiveSizeLabel">Selected: Size M (Regular Tailored)</span>
        </div>
        <div class="flex gap-2 flex-wrap mb-3" id="afmSizePills">
          <button type="button" onclick="selectAfmSize('XS', this)" class="afm-size-pill px-4 py-2 rounded-xl border border-stone-300 bg-white text-stone-800 hover:border-amber-500 text-xs font-mono font-bold transition-all cursor-pointer shadow-sm">XS</button>
          <button type="button" onclick="selectAfmSize('S', this)" class="afm-size-pill px-4 py-2 rounded-xl border border-stone-300 bg-white text-stone-800 hover:border-amber-500 text-xs font-mono font-bold transition-all cursor-pointer shadow-sm">S</button>
          <button type="button" onclick="selectAfmSize('M', this)" class="afm-size-pill px-4 py-2 rounded-xl border-2 border-amber-500 bg-amber-50 text-amber-900 text-xs font-mono font-bold transition-all cursor-pointer shadow-md">M</button>
          <button type="button" onclick="selectAfmSize('L', this)" class="afm-size-pill px-4 py-2 rounded-xl border border-stone-300 bg-white text-stone-800 hover:border-amber-500 text-xs font-mono font-bold transition-all cursor-pointer shadow-sm">L</button>
          <button type="button" onclick="selectAfmSize('XL', this)" class="afm-size-pill px-4 py-2 rounded-xl border border-stone-300 bg-white text-stone-800 hover:border-amber-500 text-xs font-mono font-bold transition-all cursor-pointer shadow-sm">XL</button>
          <button type="button" onclick="selectAfmSize('XXL', this)" class="afm-size-pill px-4 py-2 rounded-xl border border-stone-300 bg-white text-stone-800 hover:border-amber-500 text-xs font-mono font-bold transition-all cursor-pointer shadow-sm">XXL</button>
          <button type="button" onclick="selectAfmSize('3XL', this)" class="afm-size-pill px-4 py-2 rounded-xl border border-stone-300 bg-white text-stone-800 hover:border-amber-500 text-xs font-mono font-bold transition-all cursor-pointer shadow-sm">3XL</button>
        </div>
        <div class="text-[11px] text-stone-500 font-mono flex items-center gap-1.5" id="afmSizeGuideDesc">
          <span class="material-symbols-outlined text-sm text-[#a16207]">straighten</span>
          <span>Chest: 38–40" · Waist: 30–32" · Hip: 40–42" · True to bespoke size</span>
        </div>
      </div>
    </div>

    <!-- ── 2. MATCHING ENSEMBLE GROUPS (COMPLETE LOOKS · HORIZONTAL SCROLL WITH INLINE TRY-ON TO RIGHT) ── -->
    <div class="mb-6">
      <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-3 pb-3 border-b border-stone-200 gap-2">
        <div>
          <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#a16207] font-mono mb-1">
            <span class="material-symbols-outlined text-base">styler</span>
            <span>2. Complete The Look · Coordinated Ensembles</span>
          </div>
          <p class="text-xs text-stone-600 font-light" id="afmEnsembleSubtitle">
            Curated pairings tailored to match this piece. Click any product to inspect details or preview all 3 on the standing model.
          </p>
        </div>
        <div class="flex items-center gap-2 text-[11px] font-mono text-stone-500">
          <span class="hidden sm:inline">← Scroll Ensembles →</span>
          <button type="button" onclick="scrollAfmEnsembles(-1)" class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center cursor-pointer transition-all" aria-label="Scroll Left">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
          </button>
          <button type="button" onclick="scrollAfmEnsembles(1)" class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center cursor-pointer transition-all" aria-label="Scroll Right">
            <span class="material-symbols-outlined text-sm">chevron_right</span>
          </button>
        </div>
      </div>

      <!-- Horizontal Scrollable Container for Look Cards (with inline Try-On to the right) -->
      <div class="flex flex-nowrap overflow-x-auto gap-4 sm:gap-5 pb-3 pt-1 snap-x custom-scrollbar" id="afmEnsembleContainer" style="-webkit-overflow-scrolling: touch;">
        <!-- Rendered dynamically by JavaScript -->
      </div>
    </div>

    <!-- ── 3. FINAL ACTION CTAS (ADD TO BAG & INSTANT BUY) ── -->
    <div class="pt-4 border-t border-stone-200">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <button type="button" onclick="confirmAfmAddToCart()" class="w-full py-3.5 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 text-stone-950 font-button font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer hover:opacity-95">
          <span class="material-symbols-outlined text-base">shopping_bag</span>
          <span id="afmAddToCartBtnText">Acquire Size M</span>
        </button>
        <button type="button" onclick="confirmAfmInstantBuy()" class="w-full py-3.5 bg-stone-900 hover:bg-black text-white font-button font-bold text-xs uppercase tracking-wider rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm">
          <span class="material-symbols-outlined text-base text-amber-400">bolt</span>
          <span>Instant Buy (1-Click)</span>
        </button>
      </div>
    </div>

  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     PRODUCT QUICK VIEW POPUP (INSPECT INDIVIDUAL PIECE)
══════════════════════════════════════════════════════ -->
<div id="atelierProductQuickViewModal" data-lenis-prevent="true" class="fixed inset-0 bg-black/65 backdrop-blur-md z-[130] hidden items-center justify-center p-3 sm:p-6 overflow-y-auto" onclick="if(event.target===this)closeProductQuickViewModal()">
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

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center mb-4">
      <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-stone-100 border border-stone-200 relative group">
        <img id="apqvImage" src="" alt="Product" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <span class="absolute top-2 left-2 bg-stone-900/80 text-white text-[8px] font-mono px-2 py-0.5 rounded uppercase" id="apqvBadge">Atelier Piece</span>
      </div>
      <div class="flex flex-col justify-between space-y-3">
        <div>
          <span class="text-[9px] uppercase font-mono tracking-widest text-[#a16207] font-bold block mb-1">Lumina Atelier</span>
          <h4 id="apqvTitle" class="font-serif font-bold text-base sm:text-lg text-stone-900 leading-snug">Product Title</h4>
          <div class="flex items-baseline gap-2 mt-2">
            <span id="apqvPrice" class="font-serif font-bold text-lg text-stone-900">₹0</span>
            <span class="text-[10px] text-emerald-600 font-mono font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">★ 4.9 · In Stock</span>
          </div>
        </div>

        <p class="text-xs text-stone-600 font-light leading-relaxed bg-stone-50 p-2.5 rounded-xl border border-stone-100" id="apqvDesc">
          Crafted with sartorial precision in Japan and Italy using natural double-faced fibers.
        </p>

        <!-- Color Palette -->
        <div>
          <label class="text-[10px] font-mono uppercase font-bold text-stone-600 block mb-1">Atelier Colors:</label>
          <div class="flex gap-2 items-center flex-wrap" id="apqvColorSwatches">
            <!-- Dynamic Colors -->
          </div>
        </div>

        <!-- Available Sizes -->
        <div>
          <label class="text-[10px] font-mono uppercase font-bold text-stone-600 block mb-1">Available Sizes:</label>
          <div class="flex gap-1.5 flex-wrap" id="apqvSizePills">
            <!-- Dynamic sizes -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════
     INTERACTIVE ATELIER MODEL FITTING STUDIO (FULL LOOK CUSTOMIZER)
══════════════════════════════════════════════════════ -->
<div id="atelierModelFittingStudioModal" data-lenis-prevent="true" data-lenis-prevent-wheel="true" data-lenis-prevent-touch="true" class="fixed inset-0 bg-black/70 backdrop-blur-md z-[130] hidden items-center justify-center p-2 sm:p-4 md:p-6 overflow-y-auto" onclick="if(event.target===this)closeModelFittingStudioModal()">
  <div class="relative my-auto max-w-5xl w-full">
    
    <!-- Left Round Arrow Button (No Text) -->
    <button type="button" onclick="navigateStudioLook(-1)" class="fixed sm:absolute left-2 sm:-left-5 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-stone-900/90 hover:bg-black text-white backdrop-blur-md border border-stone-600/80 shadow-2xl flex items-center justify-center cursor-pointer transition-all hover:scale-110 active:scale-95 z-50 group" id="amfsPrevLookBtn" aria-label="Previous Curated Look" title="Previous Look">
      <span class="material-symbols-outlined text-lg sm:text-xl text-stone-200 group-hover:text-amber-400 transition-colors">chevron_left</span>
    </button>

    <!-- Right Round Arrow Button (No Text) -->
    <button type="button" onclick="navigateStudioLook(1)" class="fixed sm:absolute right-2 sm:-right-5 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-stone-900/90 hover:bg-black text-white backdrop-blur-md border border-stone-600/80 shadow-2xl flex items-center justify-center cursor-pointer transition-all hover:scale-110 active:scale-95 z-50 group" id="amfsNextLookBtn" aria-label="Next Curated Look" title="Next Look">
      <span class="material-symbols-outlined text-lg sm:text-xl text-stone-200 group-hover:text-amber-400 transition-colors">chevron_right</span>
    </button>

    <!-- Modal Content Card -->
    <div class="bg-white text-stone-900 p-5 sm:p-7 md:p-8 rounded-3xl w-full border border-stone-200 shadow-2xl overflow-y-auto max-h-[94vh] custom-scrollbar">
      
      <!-- Modal Header (Clean with Subtle Look Counter) -->
      <div class="flex items-center justify-between pb-4 border-b border-stone-200 mb-5">
        <div>
          <div class="flex items-center gap-2 mb-1">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-[#a16207] text-[10px] font-mono font-bold uppercase tracking-wider border border-amber-200">
              <span class="material-symbols-outlined text-xs">accessibility_new</span>
              <span>Interactive Model Fitting Studio</span>
            </div>
            <span class="text-[10px] font-mono font-bold text-stone-600 bg-stone-100 px-2.5 py-0.5 rounded-full border border-stone-200" id="amfsLookCounter">01 / 03</span>
          </div>
          <h3 class="font-serif text-lg sm:text-2xl text-stone-900 font-bold" id="amfsHeading">The Milan Executive · Complete 3-Piece Fitting</h3>
        </div>

        <button type="button" onclick="closeModelFittingStudioModal()" class="w-9 h-9 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-700 flex items-center justify-center cursor-pointer transition-all hover:scale-105 ml-2" aria-label="Close Studio">
          <span class="material-symbols-outlined text-lg">close</span>
        </button>
      </div>

      <!-- Studio Grid: Model Stand on Left + Interactive 3-Piece Customizer on Right -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-2">
        
        <!-- LEFT: Standing Model Preview Frame -->
        <div class="lg:col-span-5 bg-stone-50 border border-stone-200 rounded-2xl p-3 shadow-xs">
          <div class="relative w-full aspect-[3/4] rounded-xl overflow-hidden bg-stone-100 shadow-inner group" id="amfsModelFrameContainer">
            <img id="amfsModelImage" src="<?= base_url('img/model_look_executive.jpg') ?>" alt="Model Wearing Ensemble" class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-700">
            
            <div class="absolute top-2.5 left-2.5 bg-stone-900/85 backdrop-blur-sm text-white px-2.5 py-1 rounded-full text-[9px] font-mono flex items-center gap-1.5 shadow">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
              <span>Live Editorial Model Drape</span>
            </div>

            <!-- Active Colors & 3D Spatial Drape Tag -->
            <div class="absolute top-2.5 right-2.5 bg-white/95 backdrop-blur-xs text-stone-900 px-2 py-1 rounded-lg text-[9px] font-mono font-bold shadow flex items-center gap-1.5" id="amfsActiveColorsBadge">
              <span class="w-2 h-2 rounded-full bg-amber-500"></span>
              <span id="amfsActiveColorsText">3D Spatial Drape</span>
            </div>

            <!-- Omitted Layer Indicator Warning Overlay (if any layer unchecked) -->
            <div id="amfsOmitWarningBadge" class="hidden absolute bottom-14 left-2.5 right-2.5 bg-amber-950/85 backdrop-blur-md text-amber-200 p-2 rounded-xl text-[10px] font-mono flex items-center justify-between border border-amber-500/50 shadow-lg">
              <div class="flex items-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-amber-400">layers_clear</span>
                <span id="amfsOmitWarningText">Layer Omitted from Fitted Silhouette</span>
              </div>
              <span class="text-[9px] uppercase font-bold text-amber-300">Customized Drape</span>
            </div>

            <div class="absolute bottom-2.5 left-2.5 right-2.5 bg-white/95 backdrop-blur-xs p-2.5 rounded-xl border border-stone-200 shadow-sm text-stone-800 text-[10px] font-mono flex items-center justify-between">
              <div>
                <span class="block font-bold text-stone-900">Model: 6'1" · 185cm</span>
                <span class="text-stone-500">Wearing Size M / 32 / 9 UK</span>
              </div>
              <span class="bg-amber-100 text-amber-900 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Bespoke Drape</span>
            </div>
          </div>

          <p class="text-[11px] text-stone-600 font-light mt-3 leading-relaxed px-1" id="amfsFitDescription">
            All 3 pieces harmonize with exact drape proportions. Customize colors, sizes, or toggle any layer below.
          </p>
        </div>

        <!-- RIGHT: Interactive 3-Piece Garment Customizer & Sizer -->
        <div class="lg:col-span-7 space-y-4 flex flex-col justify-between">
          
          <div class="flex items-center justify-between pb-2 border-b border-stone-200">
            <span class="text-xs font-mono uppercase tracking-wider font-bold text-stone-800">Customize Layers, Colors &amp; Sizes:</span>
            <span class="text-[10px] font-mono text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 font-bold" id="amfsBundleBadge">12% Ensemble Discount Applied</span>
          </div>

          <!-- 3 Layers Container -->
          <div class="space-y-3" id="amfsLayersContainer">
            <!-- Rendered dynamically by JavaScript -->
          </div>

          <!-- Dynamic Live Pricing Summary & Add All To Bag CTA -->
          <div class="bg-stone-50 border-2 border-stone-200 rounded-2xl p-4 sm:p-5 mt-4">
            <div class="flex items-baseline justify-between mb-3 pb-3 border-b border-stone-200">
              <div>
                <span class="text-xs text-stone-500 font-mono block" id="amfsSelectedCountLabel">Ensemble Total (3 Pieces):</span>
                <div class="flex items-baseline gap-2 mt-0.5">
                  <span class="font-serif font-bold text-xl sm:text-2xl text-stone-900" id="amfsFinalPrice">₹12,141</span>
                  <span class="text-xs text-stone-400 line-through" id="amfsOriginalPrice">₹13,797</span>
                  <span class="text-[11px] text-emerald-600 font-mono font-bold" id="amfsSavingsLabel">Save ₹1,656</span>
                </div>
              </div>
              <div class="text-right">
                <span class="text-[10px] font-mono text-stone-500 block">Insured White-Glove Express</span>
                <span class="text-[10px] font-mono text-[#a16207] font-bold">100% Cashmere &amp; Selvedge Guarantee</span>
              </div>
            </div>

            <!-- Acquire Button -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
              <button type="button" onclick="confirmStudioEnsembleAddToCart()" id="amfsAddToCartBtn" class="w-full py-3.5 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer hover:scale-101">
                <span class="material-symbols-outlined text-base">shopping_bag</span>
                <span id="amfsAddToCartBtnText">Acquire Fitted Ensemble (3 Items)</span>
              </button>
              <button type="button" onclick="confirmStudioEnsembleInstantBuy()" class="w-full py-3.5 bg-stone-900 hover:bg-black text-white font-button font-bold text-xs uppercase tracking-wider rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                <span class="material-symbols-outlined text-base text-amber-400">bolt</span>
                <span>Instant Buy Look (1-Click)</span>
              </button>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>
</div>

<script>
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

  // Center Outfit Grid
  const gridEl = document.getElementById('outfitItemsGrid');
  let totalOrig = 0;
  let totalCombo = 0;

  if (gridEl && arch.items) {
    gridEl.innerHTML = arch.items.map(item => {
      totalOrig += (item.compare_price || (item.price * 1.35));
      totalCombo += item.price;
      const qvData = JSON.stringify({
        id: item.id,
        title: item.title,
        price: item.price,
        compare_price: item.compare_price || 0,
        image: item.img,
        vendor: item.vendor || 'Lumina Atelier',
        description: item.tag || 'Bespoke tailoring piece.'
      }).replace(/"/g, '&quot;');

      return `
        <div class="bg-white border border-stone-200 hover:border-[#a16207]/60 rounded-xl sm:rounded-2xl p-2.5 sm:p-3.5 flex flex-col justify-between shadow-xs hover:shadow-md transition-all group">
          <div>
            <div class="relative aspect-[3/4] rounded-lg sm:rounded-xl overflow-hidden bg-stone-100 mb-2">
              <img src="${item.img}" alt="${item.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              <span class="absolute top-1.5 left-1.5 px-1.5 sm:px-2 py-0.5 rounded bg-black/85 text-[#e9c176] font-mono text-[7.5px] sm:text-[8px] font-bold uppercase backdrop-blur-sm shadow-xs">
                ${item.tag}
              </span>
              <button type="button" onclick="openQuickView(${qvData})" class="absolute bottom-1.5 right-1.5 w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-white/95 text-stone-900 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow cursor-pointer" title="Quick View">
                <span class="material-symbols-outlined text-[10px] sm:text-xs">visibility</span>
              </button>
            </div>
            <span class="text-[8px] sm:text-[9px] font-mono uppercase text-[#a16207] font-bold block mb-0.5">${item.vendor || 'Lumina Atelier'}</span>
            <h4 class="font-serif text-xs sm:text-sm font-bold text-stone-900 truncate mb-1" title="${item.title}">${item.title}</h4>
            <div class="flex items-baseline gap-1.5">
              <span class="font-serif font-bold text-xs sm:text-sm text-stone-900" data-price-inr="${item.price}">₹${Number(item.price).toLocaleString('en-IN')}</span>
              ${item.compare_price ? `<span class="font-mono text-[9px] sm:text-[10px] text-stone-400 line-through">₹${Number(item.compare_price).toLocaleString('en-IN')}</span>` : ''}
            </div>
          </div>
          <div class="pt-2 sm:pt-2.5 mt-1.5 sm:mt-2 border-t border-stone-100">
            <button type="button" onclick="addToCart({id:${item.id}, title:'${item.title.replace(/'/g, "\\'")}', price:${item.price}, image:'${item.img}'}, 1)" class="w-full py-1.5 sm:py-2 bg-stone-950 hover:bg-stone-800 text-white font-mono text-[8.5px] sm:text-[9px] uppercase font-bold rounded-lg transition-all flex items-center justify-center gap-1 cursor-pointer">
              <span class="material-symbols-outlined text-[10px] sm:text-[11px]">shopping_bag</span>
              <span>Add Piece</span>
            </button>
          </div>
        </div>
      `;
    }).join('');
  }

  // Pricing totals
  const priceEl = document.getElementById('comboTotalPrice');
  const saveEl = document.getElementById('comboTotalSave');
  const savings = Math.max(0, Math.round(totalOrig - totalCombo));

  if (priceEl) {
    priceEl.setAttribute('data-price-inr', totalCombo);
    priceEl.textContent = '₹' + Number(totalCombo).toLocaleString('en-IN');
  }
  if (saveEl) {
    saveEl.textContent = '₹' + Number(savings).toLocaleString('en-IN');
  }
};

window.shuffleOutfit = function() {
  const keys = Object.keys(AI_STYLE_ARCHETYPES);
  const nextIdx = (keys.indexOf(currentActiveMoodKey) + 1) % keys.length;
  selectMood(keys[nextIdx]);
};

window.addComboToCart = function() {
  const arch = AI_STYLE_ARCHETYPES[currentActiveMoodKey] || AI_STYLE_ARCHETYPES['business'];
  if (!arch || !arch.items) return;

  arch.items.forEach((it, idx) => {
    setTimeout(() => {
      addToCart({
        id: it.id,
        title: it.title,
        price: it.price,
        image: it.img
      }, 1);
    }, idx * 100);
  });

  if (typeof showStashToast === 'function') {
    showStashToast('Added Full Outfit (' + arch.title + ') to Bag! 🛍️');
  }
};

// Auto-run initial mood curation immediately
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => selectMood('business'));
} else {
  selectMood('business');
}

// ════════════════════════════════════════════════════════════
// 2. LUMINA ATELIER FIT & ENSEMBLE STYLING ENGINE
// ════════════════════════════════════════════════════════════

const SIZE_GUIDE_MAP = {
  XS: 'Chest: 32–34" · Waist: 24–26" · Hip: 34–36" · Tailored slim ease',
  S:  'Chest: 34–36" · Waist: 26–28" · Hip: 36–38" · Structured drape',
  M:  'Chest: 38–40" · Waist: 30–32" · Hip: 40–42" · True to bespoke size',
  L:  'Chest: 40–42" · Waist: 32–34" · Hip: 42–44" · Relaxed luxury contour',
  XL: 'Chest: 42–44" · Waist: 34–36" · Hip: 44–46" · Extended chest ease',
  XXL:'Chest: 44–46" · Waist: 36–38" · Hip: 46–48" · Generous atelier cut',
  '3XL':'Chest: 46–50" · Waist: 38–42" · Hip: 48–52" · Full comfort fit'
};

// Complete Wardrobe Catalog for Ensembles with Editorial Mannequin & Model Images, Descriptions & Colors
const ENSEMBLE_CATALOG = {
  tops: [
    {
      id: 1,
      title: 'The Atelier Cashmere Cocoon Coat',
      price: 4999,
      img: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>',
      tag: 'Coat',
      category: 'top',
      desc: '100% double-faced Mongolian cashmere unlined for featherweight draping with raw horn buttons.',
      colors: [
        { name: 'Camel Hair', hex: '#c19a6b' },
        { name: 'Onyx Black', hex: '#18181b' },
        { name: 'Flannel Grey', hex: '#64748b' }
      ]
    },
    {
      id: 5,
      title: 'Super 150s Merino Wool Blazer',
      price: 8999,
      img: '<?= base_url("img/wool_blazer_luxury.jpg") ?>',
      tag: 'Tailored Blazer',
      category: 'top',
      desc: 'Woven in Biella, Italy with floating canvas chest piece and hand-stitched pick lapels.',
      colors: [
        { name: 'Midnight Navy', hex: '#1e293b' },
        { name: 'Charcoal Wool', hex: '#334155' },
        { name: 'Deep Espresso', hex: '#3f2e27' }
      ]
    },
    {
      id: 8,
      title: 'Cashmere Turtleneck Knit',
      price: 4299,
      img: '<?= base_url("img/cashmere_turtleneck_knit.jpg") ?>',
      tag: 'Knitwear',
      category: 'top',
      desc: 'Seamless 12-gauge Scottish cashmere ribbed neck with tailored cuff contour.',
      colors: [
        { name: 'Ecru Sand', hex: '#e2d9cc' },
        { name: 'Pitch Black', hex: '#18181b' },
        { name: 'Sage Stone', hex: '#78866b' }
      ]
    },
    {
      id: 6,
      title: '480GSM French Terry Hoodie',
      price: 3499,
      img: '<?= base_url("img/terry_hoodie_luxury.jpg") ?>',
      tag: 'Heavyweight Hoodie',
      category: 'top',
      desc: 'Ultra-dense combed cotton with double-layer hood and drop-shoulder architectural cut.',
      colors: [
        { name: 'Washed Charcoal', hex: '#27272a' },
        { name: 'Chalk Bone', hex: '#f4f4f5' },
        { name: 'Forest Moss', hex: '#2d3b2d' }
      ]
    }
  ],
  bottoms: [
    {
      id: 2,
      title: 'Okayama 14.5oz Selvedge',
      price: 4499,
      img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>',
      tag: 'Raw Denim',
      category: 'bottom',
      desc: 'Shuttle-loom woven with pink selvedge ID, rope-dyed indigo, and custom brass rivets.',
      colors: [
        { name: 'Raw Indigo', hex: '#172554' },
        { name: 'Faded Stone', hex: '#475569' },
        { name: 'Washed Black', hex: '#262626' }
      ]
    },
    {
      id: 9,
      title: 'Italian Pleated Wool Trousers',
      price: 4999,
      img: '<?= base_url("img/italian_pleated_trousers.jpg") ?>',
      tag: 'Pleated Trousers',
      category: 'bottom',
      desc: 'High-rise forward pleats with side adjusters and a gentle sartorial taper.',
      colors: [
        { name: 'Olive Bronze', hex: '#5b533f' },
        { name: 'Charcoal Grey', hex: '#334155' },
        { name: 'Cream Chalk', hex: '#e7e5e4' }
      ]
    },
    {
      id: 10,
      title: 'Tailored Cashmere Relaxed Pant',
      price: 4199,
      img: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>',
      tag: 'Relaxed Trousers',
      category: 'bottom',
      desc: 'Drawstring elasticated waistband tailored in brushed cashmere blend for loungewear luxury.',
      colors: [
        { name: 'Heather Charcoal', hex: '#3f3f46' },
        { name: 'Sand Taupe', hex: '#a8a29e' },
        { name: 'Pure Black', hex: '#18181b' }
      ]
    }
  ],
  shoes: [
    {
      id: 11,
      title: 'Handcrafted Italian Chelsea Boots',
      price: 5999,
      img: '<?= base_url("img/chelsea_leather_boots.jpg") ?>',
      tag: 'Chelsea Boots',
      category: 'shoes',
      desc: 'Tuscan box calfskin with Goodyear-welted leather soles and tonal elastic side gussets.',
      colors: [
        { name: 'Burnished Espresso', hex: '#3b2219' },
        { name: 'Onyx Black', hex: '#18181b' },
        { name: 'Tobacco Suede', hex: '#7c5335' }
      ]
    },
    {
      id: 12,
      title: 'Burnished Calfskin Penny Loafers',
      price: 5499,
      img: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>',
      tag: 'Penny Loafers',
      category: 'shoes',
      desc: 'Hand-burnished apron stitch with soft leather lining and stacked leather heel.',
      colors: [
        { name: 'Classic Black', hex: '#0f172a' },
        { name: 'Rich Burgundy', hex: '#451a03' },
        { name: 'Chestnut Brown', hex: '#713f12' }
      ]
    },
    {
      id: 13,
      title: 'Minimalist Sand Suede Derby Shoes',
      price: 4899,
      img: '<?= base_url("img/minimalist_suede_derby.jpg") ?>',
      tag: 'Suede Derby',
      category: 'shoes',
      desc: 'Velvety Italian split suede on a lightweight natural crepe rubber sole.',
      colors: [
        { name: 'Sand Taupe', hex: '#d6c7b2' },
        { name: 'Slate Grey', hex: '#64748b' },
        { name: 'Dark Chocolate', hex: '#292524' }
      ]
    }
  ]
};

let currentAfmProduct = null;
let currentAfmSelectedSize = 'M';
let currentActiveLooks = [];

// Studio State for Interactive Model Fitting Popup
let activeStudioLookIndex = 0;
let studioState = {
  lookName: 'The Milan Executive Look',
  modelImg: '<?= base_url("img/model_look_executive.jpg") ?>',
  top: { item: null, included: true, size: 'M', color: 'Camel Hair' },
  bottom: { item: null, included: true, size: '32', color: 'Raw Indigo' },
  shoes: { item: null, included: true, size: '9 UK', color: 'Burnished Espresso' }
};

// Quick View State
let currentQuickViewItem = null;
let currentQuickViewSize = 'M';
let currentQuickViewColor = '';

// Helper to determine product category
function detectGarmentType(prod) {
  const text = ((prod.category || '') + ' ' + (prod.title || '') + ' ' + (prod.slug || '')).toLowerCase();
  if (text.includes('denim') || text.includes('trouser') || text.includes('pant') || text.includes('jogger') || text.includes('bottom') || prod.id === 2) {
    return 'bottom';
  }
  if (text.includes('boot') || text.includes('loafer') || text.includes('derby') || text.includes('shoe') || text.includes('footwear') || text.includes('sneaker')) {
    return 'shoes';
  }
  return 'top';
}

// ── Open Atelier Fit & Styling Modal ──
window.openAtelierFitModal = function(prodData) {
  currentAfmProduct = typeof prodData === 'string' ? JSON.parse(prodData) : (prodData || {});
  
  // Set Product Info
  const titleEl = document.getElementById('afmProductTitle');
  if (titleEl) titleEl.textContent = currentAfmProduct.title || 'The Atelier Masterpiece';
  
  const imgEl = document.getElementById('afmProductImg');
  const prodImg = currentAfmProduct.image || currentAfmProduct.img || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';
  if (imgEl) imgEl.src = prodImg;
  
  const vendorEl = document.getElementById('afmVendor');
  if (vendorEl) vendorEl.textContent = (currentAfmProduct.vendor || 'LUMINA ATELIER').toUpperCase();
  
  const price = currentAfmProduct.price || 4999;
  const pEl = document.getElementById('afmProductPrice');
  if (pEl) {
    pEl.setAttribute('data-price-inr', price);
    pEl.textContent = typeof window.formatPrice === 'function' ? window.formatPrice(price) : '₹' + Number(price).toLocaleString('en-IN');
  }
  
  const cpEl = document.getElementById('afmProductComparePrice');
  if (cpEl) {
    if (currentAfmProduct.compare_price && currentAfmProduct.compare_price > price) {
      cpEl.setAttribute('data-price-inr', currentAfmProduct.compare_price);
      cpEl.textContent = typeof window.formatPrice === 'function' ? window.formatPrice(currentAfmProduct.compare_price) : '₹' + Number(currentAfmProduct.compare_price).toLocaleString('en-IN');
      cpEl.classList.remove('hidden');
    } else {
      cpEl.classList.add('hidden');
    }
  }

  // Open modal
  const modal = document.getElementById('atelierFitModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    if (window.lenisInstance && typeof window.lenisInstance.stop === 'function') {
      window.lenisInstance.stop();
    }
  }

  // Default to Size M
  selectAfmSize('M');

  // Render Dynamic Ensemble Groups
  renderEnsembleGroups(currentAfmProduct);
};

window.closeAtelierFitModal = function() {
  const modal = document.getElementById('atelierFitModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    if (window.lenisInstance && typeof window.lenisInstance.start === 'function') {
      window.lenisInstance.start();
    }
  }
};

// ── Size Selection ──
window.selectAfmSize = function(size, btn) {
  currentAfmSelectedSize = size;
  document.querySelectorAll('.afm-size-pill').forEach(b => {
    b.className = 'afm-size-pill px-4 py-2 rounded-xl border border-stone-300 bg-white text-stone-800 hover:border-amber-500 text-xs font-mono font-bold transition-all cursor-pointer shadow-sm';
  });
  
  if (btn) {
    btn.className = 'afm-size-pill px-4 py-2 rounded-xl border-2 border-amber-500 bg-amber-50 text-amber-900 text-xs font-mono font-bold transition-all cursor-pointer shadow-md';
  } else {
    document.querySelectorAll('.afm-size-pill').forEach(b => {
      if (b.textContent.trim() === size) {
        b.className = 'afm-size-pill px-4 py-2 rounded-xl border-2 border-amber-500 bg-amber-50 text-amber-900 text-xs font-mono font-bold transition-all cursor-pointer shadow-md';
      }
    });
  }

  const labelEl = document.getElementById('afmActiveSizeLabel');
  if (labelEl) labelEl.textContent = `Selected: Size ${size} (Regular Tailored)`;

  const guideEl = document.getElementById('afmSizeGuideDesc');
  if (guideEl) guideEl.innerHTML = `<span class="material-symbols-outlined text-sm text-[#a16207]">straighten</span><span>${SIZE_GUIDE_MAP[size] || ''}</span>`;

  const ctaBtnText = document.getElementById('afmAddToCartBtnText');
  if (ctaBtnText) ctaBtnText.textContent = `Acquire Size ${size}`;
};

// ── Confirm Add To Bag with Size ──
window.confirmAfmAddToCart = function() {
  if (!currentAfmProduct) return;
  const prodId = currentAfmProduct.id || 1;
  const title = currentAfmProduct.title || 'Curated Piece';
  const price = currentAfmProduct.price || 4999;
  const img = currentAfmProduct.image || currentAfmProduct.img || '';
  const size = currentAfmSelectedSize || 'M';
  const sizeMsg = `Size ${size} "${title}" added to bag! 🛍️`;
  
  if (typeof addToCart === 'function') {
    addToCart({
      id: prodId,
      title: title,
      price: price,
      image: img,
      size: size
    }, 1, sizeMsg);
  } else if (typeof ndToast === 'function') {
    ndToast(sizeMsg, 'success');
  }
  
  closeAtelierFitModal();
};

// ── Confirm Instant Buy with Size ──
window.confirmAfmInstantBuy = function() {
  if (!currentAfmProduct) return;
  const prodId = currentAfmProduct.id || 1;
  const title = currentAfmProduct.title || 'Curated Piece';
  const price = currentAfmProduct.price || 4999;
  const img = currentAfmProduct.image || currentAfmProduct.img || '';

  closeAtelierFitModal();
  if (typeof openExpressCheckout === 'function') {
    openExpressCheckout(prodId, title + ` (Size ${currentAfmSelectedSize})`, price, img, prodId);
  } else {
    window.location.href = '<?= base_url('checkout') ?>';
  }
};

// ── Add Full 3-Piece Ensemble to Bag ──
window.addEnsembleLookToCart = function(items) {
  if (!items || !items.length) return;
  items.forEach(it => {
    if (typeof addToCart === 'function') {
      addToCart({
        id: it.id,
        title: it.title,
        price: it.price,
        image: it.img || it.image,
        size: it.size || 'M',
        color: it.color || ''
      }, 1, false);
    }
  });
  if (typeof ndToast === 'function') {
    ndToast(`Complete ${items.length}-Piece Ensemble added to Bag! 🛍️`, 'success');
  }
  closeAtelierFitModal();
  setTimeout(() => {
    if (typeof toggleQuickBagDrawer === 'function') {
      var overlay = document.getElementById('quickBagOverlay');
      if (overlay && overlay.classList.contains('hidden')) {
        toggleQuickBagDrawer();
      }
    }
  }, 350);
};

// ── Horizontal Scroll Helper ──
window.scrollAfmEnsembles = function(dir) {
  const container = document.getElementById('afmEnsembleContainer');
  if (container) {
    container.scrollBy({ left: dir * 360, behavior: 'smooth' });
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
    price: selectedProd.price || 4999,
    img: selectedProd.image || selectedProd.img || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>',
    tag: 'Selected Piece',
    category: garmentType,
    desc: 'Handcrafted masterwork designed for optimal layering ease and drape.',
    colors: [
      { name: 'Original', hex: '#c19a6b' },
      { name: 'Onyx Black', hex: '#18181b' },
      { name: 'Slate Grey', hex: '#64748b' }
    ]
  };

  // Define 3 Curated Looks with Real Dressed Mannequin & Model Images
  if (garmentType === 'top') {
    if (subtitleEl) subtitleEl.textContent = 'This is a topwear piece. Below are 3 curated looks. Click any box to inspect or open the Model Studio.';
    currentActiveLooks = [
      {
        name: 'The Milan Executive Look',
        vibe: 'Formal & Sharp Sartorial Cut',
        modelImg: '<?= base_url("img/model_look_executive.jpg") ?>',
        top: selectedItem,
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Selvedge Denim
        shoes: ENSEMBLE_CATALOG.shoes[0]     // Chelsea Leather Boots
      },
      {
        name: 'The Tailored Atelier Classic',
        vibe: 'Refined Contemporary Drape',
        modelImg: '<?= base_url("img/model_look_classic.jpg") ?>',
        top: selectedItem,
        bottom: ENSEMBLE_CATALOG.bottoms[1], // Italian Pleated Wool Trousers
        shoes: ENSEMBLE_CATALOG.shoes[1]     // Calfskin Penny Loafers
      },
      {
        name: 'The Monochromatic Street Look',
        vibe: 'Heavyweight Minimalist Movement',
        modelImg: '<?= base_url("img/model_look_street.jpg") ?>',
        top: selectedItem,
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Selvedge Denim
        shoes: ENSEMBLE_CATALOG.shoes[2]     // Minimalist Sand Suede Derby
      }
    ];
  } else if (garmentType === 'bottom') {
    if (subtitleEl) subtitleEl.textContent = 'This is a bottomwear piece. Matching topwear is on top, selected bottom in middle, and shoes below.';
    currentActiveLooks = [
      {
        name: 'The Executive Suiting Look',
        vibe: 'Formal & Sharp Silhouette',
        modelImg: '<?= base_url("img/model_look_executive.jpg") ?>',
        top: ENSEMBLE_CATALOG.tops[0],       // Cashmere Cocoon Coat
        bottom: selectedItem,                // Selected Bottom
        shoes: ENSEMBLE_CATALOG.shoes[0]     // Chelsea Leather Boots
      },
      {
        name: 'The Tailored Atelier Classic',
        vibe: 'Luxurious Autumnal Layering',
        modelImg: '<?= base_url("img/model_look_classic.jpg") ?>',
        top: ENSEMBLE_CATALOG.tops[2],       // Cashmere Turtleneck
        bottom: selectedItem,                // Selected Bottom
        shoes: ENSEMBLE_CATALOG.shoes[1]     // Calfskin Penny Loafers
      },
      {
        name: 'The Monochromatic Street Look',
        vibe: 'Heavyweight Architectural Casual',
        modelImg: '<?= base_url("img/model_look_street.jpg") ?>',
        top: ENSEMBLE_CATALOG.tops[3],       // French Terry Hoodie
        bottom: selectedItem,                // Selected Bottom
        shoes: ENSEMBLE_CATALOG.shoes[2]     // Minimalist Sand Suede Derby
      }
    ];
  } else { // shoes
    if (subtitleEl) subtitleEl.textContent = 'This is a footwear piece. Curated topwear and bottomwear stacked above your selected shoes.';
    currentActiveLooks = [
      {
        name: 'The Executive Suiting Look',
        vibe: 'Complete Formal Ensemble',
        modelImg: '<?= base_url("img/model_look_executive.jpg") ?>',
        top: ENSEMBLE_CATALOG.tops[0],       // Cashmere Cocoon Coat
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Denim
        shoes: selectedItem                  // Selected Shoes
      },
      {
        name: 'The Tailored Atelier Classic',
        vibe: 'Effortless Milan Drape',
        modelImg: '<?= base_url("img/model_look_classic.jpg") ?>',
        top: ENSEMBLE_CATALOG.tops[2],       // Cashmere Turtleneck
        bottom: ENSEMBLE_CATALOG.bottoms[1], // Pleated Trousers
        shoes: selectedItem                  // Selected Shoes
      },
      {
        name: 'The Monochromatic Street Look',
        vibe: 'Relaxed Architectural Streetwear',
        modelImg: '<?= base_url("img/model_look_street.jpg") ?>',
        top: ENSEMBLE_CATALOG.tops[3],       // French Terry Hoodie
        bottom: ENSEMBLE_CATALOG.bottoms[0], // Okayama Denim
        shoes: selectedItem                  // Selected Shoes
      }
    ];
  }

  // Render Horizontal Cards
  container.innerHTML = currentActiveLooks.map((look, lIdx) => {
    const totalOriginal = look.top.price + look.bottom.price + look.shoes.price;
    const ensemblePrice = Math.round(totalOriginal * 0.88); // 12% bundle privilege
    const savings = totalOriginal - ensemblePrice;
    const itemsJson = JSON.stringify([look.top, look.bottom, look.shoes]).replace(/"/g, '&quot;');

    // Helper to render individual item row in vertical stack with Quick View click
    const renderStackedSlot = (slotItem, slotType, slotStep, isSelected) => {
      const slotItemJson = JSON.stringify(slotItem).replace(/"/g, '&quot;');
      return `
        <div class="bg-white border ${isSelected ? 'border-amber-400 bg-amber-50/25 ring-1 ring-amber-400/50' : 'border-stone-200'} rounded-2xl p-2.5 sm:p-3 flex items-center justify-between gap-2.5 shadow-xs hover:border-stone-400 transition-all group cursor-pointer" onclick="openProductQuickViewModal(${slotItemJson})">
          
          <!-- Left: Image & Step Badge -->
          <div class="flex items-center gap-2.5 min-w-0">
            <div class="relative w-12 h-14 sm:w-14 sm:h-16 rounded-xl overflow-hidden bg-stone-100 flex-shrink-0 border border-stone-200 shadow-xs">
              <img src="${slotItem.img}" alt="${slotItem.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
              <span class="absolute top-1 left-1 bg-stone-900/85 text-white text-[7px] font-mono px-1 py-0.5 rounded font-bold">${slotStep}</span>
              <span class="absolute bottom-1 right-1 bg-white/90 text-stone-900 text-[8px] font-mono rounded p-0.5 opacity-0 group-hover:opacity-100 transition-opacity shadow" title="Quick View">
                <span class="material-symbols-outlined text-[10px] block">visibility</span>
              </span>
            </div>

            <div class="min-w-0 flex-1">
              <div class="flex items-center gap-1 mb-0.5">
                <span class="text-[8px] font-mono uppercase font-bold tracking-wider ${isSelected ? 'text-[#a16207] bg-amber-100/80 px-1 rounded' : 'text-stone-500'}">
                  ${isSelected ? '★ ' + slotType + ' (Active)' : slotType}
                </span>
              </div>

              <h5 class="font-serif text-xs font-bold text-stone-900 truncate group-hover:text-[#a16207] transition-colors" title="${slotItem.title}">
                ${slotItem.title}
              </h5>

              <div class="flex items-baseline gap-1 mt-0.5">
                <span class="font-serif font-bold text-xs text-stone-900" data-price-inr="${slotItem.price}">₹${Number(slotItem.price).toLocaleString('en-IN')}</span>
                <span class="text-[9px] font-mono text-stone-400">· Click to inspect</span>
              </div>
            </div>
          </div>

          <!-- Right: Action Button -->
          <div class="flex-shrink-0" onclick="event.stopPropagation()">
            ${isSelected 
              ? `<span class="inline-flex items-center gap-0.5 px-2 py-1 bg-amber-100 text-amber-900 rounded-lg text-[9px] font-mono font-bold border border-amber-300">
                  <span class="material-symbols-outlined text-[11px]">check</span>
                  <span>Active</span>
                 </span>`
              : `<button type="button" onclick="addToCart(${slotItem.id}, 1, 'Added ${slotItem.title.replace(/'/g, "\\'")} to Bag! 🛍️');" class="px-2.5 py-1.5 bg-stone-900 hover:bg-black text-white rounded-lg text-[9px] font-mono font-bold transition-all flex items-center gap-1 cursor-pointer shadow-xs">
                  <span class="material-symbols-outlined text-[11px]">add_shopping_bag</span>
                  <span>Add</span>
                 </button>`
            }
          </div>

        </div>
      `;
    };

    return `
      <div class="w-[300px] sm:w-[330px] flex-shrink-0 snap-start bg-stone-50 border border-stone-200 hover:border-amber-300/80 rounded-3xl p-4 sm:p-5 flex flex-col justify-between shadow-sm transition-all duration-300" id="lookCard_${lIdx}">
        
        <div>
          <!-- Look Card Header -->
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-stone-200">
            <div class="flex items-center gap-2">
              <span class="w-6 h-6 rounded-full bg-stone-900 text-white font-mono text-xs font-bold flex items-center justify-center shadow-xs">0${lIdx + 1}</span>
              <div>
                <h4 class="font-serif font-bold text-xs sm:text-sm text-stone-900 truncate max-w-[170px]">${look.name}</h4>
                <span class="text-[10px] text-stone-500 font-light block">${look.vibe}</span>
              </div>
            </div>
            <span class="text-[9px] font-mono uppercase bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-bold">12% Off</span>
          </div>

          <!-- Stacked Items (01 Top -> 02 Bottom -> 03 Shoes) -->
          <div class="space-y-2 mb-4">
            ${renderStackedSlot(look.top, 'Top Wear', '01', garmentType === 'top')}
            
            <div class="flex items-center justify-center -my-0.5">
              <div class="w-0.5 h-2 bg-stone-300"></div>
            </div>

            ${renderStackedSlot(look.bottom, 'Bottom Wear', '02', garmentType === 'bottom')}
            
            <div class="flex items-center justify-center -my-0.5">
              <div class="w-0.5 h-2 bg-stone-300"></div>
            </div>

            ${renderStackedSlot(look.shoes, 'Footwear', '03', garmentType === 'shoes')}
          </div>
        </div>

        <!-- Look Actions & Model Studio Button -->
        <div class="pt-3 border-t border-stone-200 space-y-2.5">
          
          <!-- Dedicated Model Studio Action Button -->
          <button type="button" onclick="openModelFittingStudioModal(${lIdx})" class="w-full py-2.5 bg-stone-900 hover:bg-black text-white rounded-xl text-xs font-mono font-bold flex items-center justify-center gap-1.5 transition-all cursor-pointer shadow-xs">
            <span class="material-symbols-outlined text-sm text-amber-400">accessibility_new</span>
            <span>Interactive Model Studio</span>
          </button>

          <!-- Combo Pricing -->
          <div class="flex items-baseline justify-between text-xs px-1">
            <span class="text-stone-500 font-mono text-[11px]">Look Total:</span>
            <div class="flex items-baseline gap-1.5">
              <span class="font-serif font-bold text-sm text-stone-900" data-price-inr="${ensemblePrice}">₹${Number(ensemblePrice).toLocaleString('en-IN')}</span>
              <span class="text-[10px] text-stone-400 line-through" data-price-inr="${totalOriginal}">₹${Number(totalOriginal).toLocaleString('en-IN')}</span>
              <span class="text-[10px] text-emerald-600 font-mono font-bold">Save ₹${Number(savings).toLocaleString('en-IN')}</span>
            </div>
          </div>

          <!-- Acquire Complete 3-Piece Look Button -->
          <button type="button" onclick="addEnsembleLookToCart(${itemsJson})" class="w-full py-2.5 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 hover:from-amber-300 hover:to-[#e9c176] text-stone-950 font-button font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer hover:scale-101">
            <span class="material-symbols-outlined text-sm">checkroom</span>
            <span>Acquire Complete 3-Piece Look</span>
          </button>
        </div>

      </div>
    `;
  }).join('');
}

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

  const imgEl = document.getElementById('apqvImage');
  if (imgEl) imgEl.src = item.img || item.image || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';

  const priceEl = document.getElementById('apqvPrice');
  if (priceEl) priceEl.textContent = '₹' + Number(item.price || 4999).toLocaleString('en-IN');

  const tagEl = document.getElementById('apqvCategoryTag');
  if (tagEl) tagEl.textContent = item.tag || 'Atelier Garment';

  const descEl = document.getElementById('apqvDesc');
  if (descEl) descEl.textContent = item.desc || 'Crafted with sartorial precision in Japan and Italy using natural double-faced fibers.';

  // Color Swatches
  const colorCont = document.getElementById('apqvColorSwatches');
  const colors = item.colors || [
    { name: 'Original', hex: '#c19a6b' },
    { name: 'Onyx Black', hex: '#18181b' },
    { name: 'Charcoal', hex: '#64748b' }
  ];
  currentQuickViewColor = colors[0].name;

  if (colorCont) {
    colorCont.innerHTML = colors.map((c, idx) => `
      <div class="flex items-center gap-1.5 bg-stone-100 px-2 py-1 rounded-lg border ${idx===0 ? 'border-amber-500' : 'border-stone-200'} text-[10px] font-mono">
        <span class="w-3 h-3 rounded-full border border-stone-300" style="background-color: ${c.hex};"></span>
        <span>${c.name}</span>
      </div>
    `).join('');
  }

  // Size pills based on category
  const sizeCont = document.getElementById('apqvSizePills');
  const cat = detectGarmentType(item);
  let sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
  if (cat === 'bottom') sizes = ['28', '30', '32', '34', '36', '38'];
  if (cat === 'shoes') sizes = ['7 UK', '8 UK', '9 UK', '10 UK', '11 UK'];

  if (sizeCont) {
    sizeCont.innerHTML = sizes.map(s => `
      <span class="px-2.5 py-1 rounded-lg border border-stone-200 bg-stone-50 text-stone-700 text-[10px] font-mono font-medium">
        ${s}
      </span>
    `).join('');
  }

  modal.classList.remove('hidden');
  modal.classList.add('flex');
};

window.closeProductQuickViewModal = function() {
  const modal = document.getElementById('atelierProductQuickViewModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
};

// ════════════════════════════════════════════════════════════
// 2. INTERACTIVE MODEL FITTING STUDIO (FULL LOOK CUSTOMIZER)
// ════════════════════════════════════════════════════════════
window.openModelFittingStudioModal = function(lookIdx) {
  activeStudioLookIndex = lookIdx || 0;
  loadStudioLook(activeStudioLookIndex);

  const modal = document.getElementById('atelierModelFittingStudioModal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }
};

window.closeModelFittingStudioModal = function() {
  const modal = document.getElementById('atelierModelFittingStudioModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
};

// ── Next / Previous Look Navigator ──
window.navigateStudioLook = function(dir) {
  if (!currentActiveLooks.length) return;
  activeStudioLookIndex = (activeStudioLookIndex + dir + currentActiveLooks.length) % currentActiveLooks.length;
  loadStudioLook(activeStudioLookIndex);
  
  if (typeof ndToast === 'function') {
    ndToast(`Switched to "${studioState.lookName}"! 🪞`, 'info');
  }
};

function loadStudioLook(idx) {
  const look = currentActiveLooks[idx] || currentActiveLooks[0];
  if (!look) return;

  const topColors = (look.top && look.top.colors) || [{ name: 'Camel Hair', hex: '#c19a6b' }];
  const bottomColors = (look.bottom && look.bottom.colors) || [{ name: 'Raw Indigo', hex: '#172554' }];
  const shoeColors = (look.shoes && look.shoes.colors) || [{ name: 'Espresso', hex: '#3b2219' }];

  studioState = {
    lookName: look.name,
    modelImg: look.modelImg || '<?= base_url("img/model_look_executive.jpg") ?>',
    top: { item: Object.assign({}, look.top), included: true, size: 'M', color: topColors[0].name, hex: topColors[0].hex },
    bottom: { item: Object.assign({}, look.bottom), included: true, size: '32', color: bottomColors[0].name, hex: bottomColors[0].hex },
    shoes: { item: Object.assign({}, look.shoes), included: true, size: '9 UK', color: shoeColors[0].name, hex: shoeColors[0].hex }
  };

  renderStudioCustomizer();
}

// ── Render Studio Customizer Layers & Price ──
function renderStudioCustomizer() {
  const headingEl = document.getElementById('amfsHeading');
  if (headingEl) headingEl.textContent = `${studioState.lookName} · Interactive Atelier Fitting`;

  const modelImgEl = document.getElementById('amfsModelImage');
  if (modelImgEl) modelImgEl.src = studioState.modelImg;

  // Next / Prev Labels & Counter
  const counterEl = document.getElementById('amfsLookCounter');
  if (counterEl) counterEl.textContent = `0${activeStudioLookIndex + 1} / 0${currentActiveLooks.length}`;

  const nextIdx = (activeStudioLookIndex + 1) % currentActiveLooks.length;
  const prevIdx = (activeStudioLookIndex - 1 + currentActiveLooks.length) % currentActiveLooks.length;

  const nextLabelEl = document.getElementById('amfsNextLookLabel');
  if (nextLabelEl && currentActiveLooks[nextIdx]) {
    nextLabelEl.textContent = `Next: ${currentActiveLooks[nextIdx].name}`;
  }

  const prevLabelEl = document.getElementById('amfsPrevLookLabel');
  if (prevLabelEl && currentActiveLooks[prevIdx]) {
    prevLabelEl.textContent = `Prev: ${currentActiveLooks[prevIdx].name}`;
  }

  // Active Colors 3D Spatial Tag
  const colorsTextEl = document.getElementById('amfsActiveColorsText');
  if (colorsTextEl) {
    const activeColorParts = [];
    if (studioState.top.included) activeColorParts.push(studioState.top.color);
    if (studioState.bottom.included) activeColorParts.push(studioState.bottom.color);
    if (studioState.shoes.included) activeColorParts.push(studioState.shoes.color);
    colorsTextEl.textContent = activeColorParts.length ? activeColorParts.join(' · ') : 'Omitted Drape';
  }

  // Check if any layer is omitted from the model
  const omittedLayers = [];
  if (!studioState.top.included) omittedLayers.push('Top Wear');
  if (!studioState.bottom.included) omittedLayers.push('Bottom Wear');
  if (!studioState.shoes.included) omittedLayers.push('Footwear');

  const omitBadge = document.getElementById('amfsOmitWarningBadge');
  const omitText = document.getElementById('amfsOmitWarningText');
  const modelFrame = document.getElementById('amfsModelFrameContainer');

  if (omittedLayers.length > 0) {
    if (omitBadge) {
      omitBadge.classList.remove('hidden');
      if (omitText) omitText.textContent = `${omittedLayers.join(' & ')} Omitted from Look`;
    }
    if (modelFrame) {
      modelFrame.classList.add('ring-2', 'ring-amber-500/80');
    }
  } else {
    if (omitBadge) omitBadge.classList.add('hidden');
    if (modelFrame) modelFrame.classList.remove('ring-2', 'ring-amber-500/80');
  }

  const container = document.getElementById('amfsLayersContainer');
  if (!container) return;

  const topSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'];
  const bottomSizes = ['28', '30', '32', '34', '36', '38'];
  const shoeSizes = ['7 UK', '8 UK', '9 UK', '10 UK', '11 UK'];

  // Helper to render layer card
  const renderStudioLayer = (layerKey, layerLabel, layerStep, layerData, sizesList) => {
    const isInc = layerData.included;
    const item = layerData.item;
    const colors = item.colors || [{ name: 'Default', hex: '#c19a6b' }];

    return `
      <div class="bg-white border ${isInc ? 'border-stone-200 shadow-xs' : 'border-dashed border-stone-300 opacity-60 bg-stone-50'} rounded-2xl p-3.5 transition-all">
        
        <!-- Header: Toggle Checkbox + Image + Title + Price -->
        <div class="flex items-center justify-between gap-3 mb-2.5">
          <div class="flex items-center gap-2.5 min-w-0">
            <label class="relative flex items-center cursor-pointer" title="${isInc ? 'Uncheck to remove this garment from model & bundle' : 'Check to include'}">
              <input type="checkbox" ${isInc ? 'checked' : ''} onchange="toggleStudioLayer('${layerKey}', this.checked)" class="w-4 h-4 text-amber-500 rounded border-stone-300 focus:ring-amber-400 cursor-pointer">
            </label>
            <img src="${item.img}" class="w-12 h-14 object-cover rounded-lg border border-stone-200 flex-shrink-0" alt="${layerLabel}">
            <div class="min-w-0">
              <div class="flex items-center gap-1.5">
                <span class="text-[8px] font-mono uppercase bg-stone-100 text-stone-700 px-1.5 py-0.5 rounded font-bold">${layerStep} ${layerLabel}</span>
                <span class="text-xs font-serif font-bold text-stone-900">₹${Number(item.price).toLocaleString('en-IN')}</span>
                ${!isInc ? `<span class="text-[8px] font-mono text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded font-bold">Omitted from Look</span>` : ''}
              </div>
              <h5 class="font-serif text-xs font-bold text-stone-900 truncate mt-0.5">${item.title}</h5>
            </div>
          </div>
        </div>

        <!-- Description -->
        <p class="text-[11px] text-stone-600 font-light leading-relaxed bg-stone-50/80 p-2 rounded-lg border border-stone-100 mb-2.5">
          ${item.desc || 'Bespoke tailoring constructed with unlined precision and luxury natural fibers.'}
        </p>

        <!-- Customizer Row: Colors + Sizes (Only if included) -->
        ${isInc ? `
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2.5 border-t border-stone-100 items-center">
            
            <!-- Color Swatches -->
            <div>
              <span class="text-[9px] font-mono uppercase font-bold text-stone-500 block mb-1">Color: <strong class="text-stone-800">${layerData.color}</strong></span>
              <div class="flex items-center gap-1.5 flex-wrap">
                ${colors.map(c => `
                  <button type="button" onclick="setStudioLayerColor('${layerKey}', '${c.name}', '${c.hex}')" class="flex items-center gap-1 px-2 py-0.5 rounded-lg border text-[9px] font-mono font-bold cursor-pointer transition-all ${layerData.color === c.name ? 'border-amber-500 bg-amber-50 text-amber-900 shadow-xs' : 'border-stone-200 bg-white text-stone-700 hover:border-stone-300'}" title="${c.name}">
                    <span class="w-2.5 h-2.5 rounded-full border border-black/10" style="background-color: ${c.hex};"></span>
                    <span>${c.name}</span>
                  </button>
                `).join('')}
              </div>
            </div>

            <!-- Size Pills -->
            <div>
              <span class="text-[9px] font-mono uppercase font-bold text-stone-500 block mb-1">Size: <strong class="text-stone-800">${layerData.size}</strong></span>
              <div class="flex gap-1 flex-wrap">
                ${sizesList.map(s => `
                  <button type="button" onclick="setStudioLayerSize('${layerKey}', '${s}')" class="px-2 py-0.5 rounded-md text-[9px] font-mono font-bold cursor-pointer transition-all ${layerData.size === s ? 'bg-amber-500 text-stone-950 border border-amber-600 shadow-xs' : 'bg-stone-100 hover:bg-stone-200 text-stone-700 border border-stone-200'}">
                    ${s}
                  </button>
                `).join('')}
              </div>
            </div>

          </div>
        ` : ''}

      </div>
    `;
  };

  container.innerHTML = `
    ${renderStudioLayer('top', 'Top Wear', '01', studioState.top, topSizes)}
    ${renderStudioLayer('bottom', 'Bottom Wear', '02', studioState.bottom, bottomSizes)}
    ${renderStudioLayer('shoes', 'Footwear', '03', studioState.shoes, shoeSizes)}
  `;

  // Calculate Subtotal & Discount
  let rawSubtotal = 0;
  let itemsCount = 0;
  if (studioState.top.included) { rawSubtotal += studioState.top.item.price; itemsCount++; }
  if (studioState.bottom.included) { rawSubtotal += studioState.bottom.item.price; itemsCount++; }
  if (studioState.shoes.included) { rawSubtotal += studioState.shoes.item.price; itemsCount++; }

  const discountRate = itemsCount === 3 ? 0.12 : (itemsCount === 2 ? 0.08 : 0);
  const finalPrice = Math.round(rawSubtotal * (1 - discountRate));
  const savings = rawSubtotal - finalPrice;

  const countLabel = document.getElementById('amfsSelectedCountLabel');
  if (countLabel) countLabel.textContent = `Ensemble Total (${itemsCount} ${itemsCount === 1 ? 'Piece' : 'Pieces'} Selected):`;

  const finalPriceEl = document.getElementById('amfsFinalPrice');
  if (finalPriceEl) finalPriceEl.textContent = '₹' + Number(finalPrice).toLocaleString('en-IN');

  const origPriceEl = document.getElementById('amfsOriginalPrice');
  if (origPriceEl) {
    if (savings > 0) {
      origPriceEl.textContent = '₹' + Number(rawSubtotal).toLocaleString('en-IN');
      origPriceEl.classList.remove('hidden');
    } else {
      origPriceEl.classList.add('hidden');
    }
  }

  const savEl = document.getElementById('amfsSavingsLabel');
  if (savEl) {
    if (savings > 0) {
      savEl.textContent = `Save ₹${Number(savings).toLocaleString('en-IN')} (${Math.round(discountRate * 100)}% Off)`;
      savEl.classList.remove('hidden');
    } else {
      savEl.classList.add('hidden');
    }
  }

  const btnTextEl = document.getElementById('amfsAddToCartBtnText');
  if (btnTextEl) btnTextEl.textContent = `Acquire Fitted Ensemble (${itemsCount} ${itemsCount === 1 ? 'Item' : 'Items'} · ₹${Number(finalPrice).toLocaleString('en-IN')})`;

  const badgeEl = document.getElementById('amfsBundleBadge');
  if (badgeEl) {
    badgeEl.textContent = itemsCount === 3 ? '12% Full Ensemble Privilege' : (itemsCount === 2 ? '8% Duo Privilege' : 'Standard Privilege');
  }
}

// ── Studio Layer Toggle / Color / Size ──
window.toggleStudioLayer = function(layerKey, isIncluded) {
  if (studioState[layerKey]) {
    studioState[layerKey].included = isIncluded;
    renderStudioCustomizer();
    if (typeof ndToast === 'function') {
      ndToast(isIncluded ? `Included ${layerKey} in look drape!` : `Omitted ${layerKey} from look drape.`, 'info');
    }
  }
};

window.setStudioLayerColor = function(layerKey, colorName, hex) {
  if (studioState[layerKey]) {
    studioState[layerKey].color = colorName;
    studioState[layerKey].hex = hex;
    renderStudioCustomizer();
  }
};

window.setStudioLayerSize = function(layerKey, size) {
  if (studioState[layerKey]) {
    studioState[layerKey].size = size;
    renderStudioCustomizer();
  }
};

// ── Confirm Studio Ensemble Add to Cart with all selected sizes & colors ──
window.confirmStudioEnsembleAddToCart = function() {
  const itemsToAdd = [];
  if (studioState.top.included && studioState.top.item) {
    itemsToAdd.push({
      id: studioState.top.item.id,
      title: studioState.top.item.title,
      price: studioState.top.item.price,
      image: studioState.top.item.img || studioState.top.item.image,
      size: studioState.top.size,
      color: studioState.top.color
    });
  }
  if (studioState.bottom.included && studioState.bottom.item) {
    itemsToAdd.push({
      id: studioState.bottom.item.id,
      title: studioState.bottom.item.title,
      price: studioState.bottom.item.price,
      image: studioState.bottom.item.img || studioState.bottom.item.image,
      size: studioState.bottom.size,
      color: studioState.bottom.color
    });
  }
  if (studioState.shoes.included && studioState.shoes.item) {
    itemsToAdd.push({
      id: studioState.shoes.item.id,
      title: studioState.shoes.item.title,
      price: studioState.shoes.item.price,
      image: studioState.shoes.item.img || studioState.shoes.item.image,
      size: studioState.shoes.size,
      color: studioState.shoes.color
    });
  }

  if (itemsToAdd.length === 0) {
    if (typeof ndToast === 'function') ndToast('Please select at least 1 item to acquire.', 'error');
    return;
  }

  itemsToAdd.forEach(it => {
    if (typeof addToCart === 'function') {
      addToCart(it, 1, false);
    }
  });

  const detailsSummary = itemsToAdd.map(i => `${i.color} / Size ${i.size}`).join(' · ');
  if (typeof ndToast === 'function') {
    ndToast(`Fitted ${itemsToAdd.length}-Piece Look (${detailsSummary}) added to Bag! 🛍️`, 'success');
  }

  closeModelFittingStudioModal();
  closeAtelierFitModal();

  setTimeout(() => {
    if (typeof toggleQuickBagDrawer === 'function') {
      var overlay = document.getElementById('quickBagOverlay');
      if (overlay && overlay.classList.contains('hidden')) {
        toggleQuickBagDrawer();
      }
    }
  }, 350);
};

window.confirmStudioEnsembleInstantBuy = function() {
  confirmStudioEnsembleAddToCart();
  setTimeout(() => {
    window.location.href = '<?= base_url('checkout') ?>';
  }, 350);
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
            <button onclick="toggleWishlistItem({id:<?= $fd['id'] ?>, title:'<?= addslashes($fd['title']) ?>', price:<?= $fd_flash ?>, image:'<?= addslashes($fd_img) ?>'})" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/70 hover:bg-black text-rose-400 flex items-center justify-center border border-white/20 shadow-md transition-all hover:scale-110 cursor-pointer" title="Save to Wardrobe">
              <span class="material-symbols-outlined text-[11px] sm:text-xs">favorite</span>
            </button>
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

          <!-- Action Buttons -->
          <div class="grid grid-cols-2 gap-1.5 sm:gap-2 mt-auto pt-2 sm:pt-3 border-t border-stone-100">
            <button onclick="addToCart({id:<?= $fd['id'] ?>, title:'<?= addslashes(htmlspecialchars($fd['title'])) ?>', price:<?= $fd_flash ?>, image:'<?= addslashes($fd_img) ?>'}, 1)" class="w-full py-1.5 sm:py-2.5 bg-stone-50 border border-stone-200 text-stone-900 font-mono text-[8.5px] sm:text-[11px] uppercase tracking-wider hover:bg-stone-100 transition-all flex items-center justify-center gap-1 cursor-pointer rounded-lg sm:rounded-xl font-semibold active:scale-95">
              <span class="material-symbols-outlined text-[10px] sm:text-xs text-[#a16207]">shopping_bag</span>
              <span>Acquire</span>
            </button>
            <button onclick="openExpressCheckout(<?= $fd['id'] ?>, '<?= addslashes($fd['title']) ?>', <?= $fd_flash ?>, '<?= addslashes($fd_img) ?>', <?= $fd['id'] ?>)" class="w-full py-1.5 sm:py-2.5 bg-stone-950 hover:bg-stone-800 text-white font-mono text-[8.5px] sm:text-[11px] uppercase tracking-wider font-extrabold transition-all flex items-center justify-center gap-1 cursor-pointer rounded-lg sm:rounded-xl shadow-sm border border-stone-900 active:scale-95">
              <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-current text-[#e9c176] flex-shrink-0" viewBox="0 0 24 24"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>
              <span>Buy</span>
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
     PRIVATE ACCESS: REQUEST ATELIER INVITATION
══════════════════════════════════════════════════════ -->
<!-- ══════════════════════════════════════════════════════
     PRIVATE ACCESS: REQUEST ATELIER INVITATION (LUXURY WHITE)
══════════════════════════════════════════════════════ -->
<section class="py-16 md:py-24 bg-[#faf9f6] border-t border-b border-stone-200 text-stone-900 scroll-unfold-section relative overflow-hidden" id="newsletterSection">
  <!-- Subtle warm ambient backdrop glow -->
  <div class="absolute w-96 h-96 rounded-full bg-amber-500/5 blur-[100px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

  <div class="max-w-xl mx-auto px-4 text-center relative z-10">
    <span class="font-mono text-xs text-[#a16207] uppercase tracking-[0.25em] block mb-2 font-bold">✦ Private Access ✦</span>
    <h2 class="font-serif text-3xl sm:text-4xl text-stone-950 font-bold mb-3 tracking-tight">Request Atelier Invitation</h2>
    <p class="text-stone-600 mb-8 text-xs sm:text-sm font-light leading-relaxed max-w-md mx-auto">
      Receive private access to hand-numbered capsule releases, bespoke fittings, and runway previews.
    </p>

    <form class="flex flex-col sm:flex-row gap-2.5 max-w-md mx-auto" onsubmit="event.preventDefault(); ndToast('Your invitation request has been prioritized by the Atelier.', 'success'); this.reset();">
      <input type="email" placeholder="Enter your private email" required class="flex-1 bg-white px-4 py-3.5 text-xs text-stone-900 border border-stone-300 focus:border-stone-950 focus:ring-1 focus:ring-stone-950 rounded-xl outline-none shadow-2xs font-sans">
      <button type="submit" data-cursor="SUBMIT" class="bg-gradient-to-r from-amber-400 to-[#e9c176] hover:opacity-95 text-stone-950 font-mono text-xs uppercase tracking-wider px-7 py-3.5 font-extrabold shadow-md active:scale-95 transition-all cursor-pointer rounded-xl flex-shrink-0">
        Request Invitation
      </button>
    </form>

    <div class="mt-6 flex items-center justify-center gap-6 text-[10px] font-mono text-stone-500">
      <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs text-emerald-600">lock</span> Confidential &amp; Encrypted</span>
      <span class="flex items-center gap-1"><span class="material-symbols-outlined text-xs text-[#a16207]">verified</span> Strict Zero Spam Guarantee</span>
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




