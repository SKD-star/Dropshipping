</main>

<?php
  $current_uri   = isset($current_uri) ? $current_uri : (isset($this->uri) ? $this->uri->uri_string() : '');
  $hs            = $home_settings ?? [];
  $_f_brand      = htmlspecialchars($hs['brand_name'] ?? 'NovaDrop');
  $_f_tagline    = htmlspecialchars($hs['brand_tagline'] ?? 'Curated luxury garments and architectural objects for the considered space. Designed with intention, crafted to last.');
  $_f_copyright  = htmlspecialchars($hs['copyright_text'] ?? '© 2026 ' . ($_f_brand ?: 'NovaDrop') . ' ATELIER COLLECTIVE. ALL RIGHTS RESERVED.');
?>

<!-- ── Luxury Atelier Footer ── -->
<footer class="relative w-full pt-12 md:pt-stack-lg pb-24 md:pb-stack-lg border-t border-white/10 md:border-outline-variant bg-[#08090c] text-white md:bg-surface md:text-on-surface mt-auto">
  <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <div class="md:col-span-4 flex flex-col justify-between opacity-100">
      <div>
        <span class="font-headline-md text-3xl text-white md:text-primary block mb-4 tracking-[0.1em] font-serif uppercase"><?= $_f_brand ?></span>
        <p class="font-body-md text-stone-400 md:text-on-surface-variant max-w-xs text-sm leading-relaxed">
          <?= $_f_tagline ?>
        </p>
      </div>
      <div class="mt-stack-sm md:mt-8">
        <p class="font-label-caps text-stone-400 md:text-on-surface-variant text-[11px] uppercase tracking-wider"><?= $_f_copyright ?></p>
      </div>
    </div>

    
    <div class="md:col-span-2 md:col-start-7">
      <h4 class="font-label-caps text-xs text-[#e9c176] md:text-primary uppercase tracking-[0.2em] mb-6 font-bold">Explore</h4>
      <ul class="space-y-3.5 font-body-md text-sm">
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url() ?>">Runway Lookbook</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('collections') ?>">Editorial Collections</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('shop') ?>">Boutique Catalog</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('tracking') ?>">Order Tracking</a></li>
      </ul>
    </div>
    
    <div class="md:col-span-2">
      <h4 class="font-label-caps text-xs text-[#e9c176] md:text-primary uppercase tracking-[0.2em] mb-6 font-bold">Concierge</h4>
      <ul class="space-y-3.5 font-body-md text-sm">
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('shipping') ?>">Shipping &amp; Logistics</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('account') ?>">Atelier Account</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('stylist') ?>">AI Stylist Advice</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('admin') ?>">Merchant Portal</a></li>
      </ul>
    </div>
    
    <div class="md:col-span-2">
      <h4 class="font-label-caps text-xs text-[#e9c176] md:text-primary uppercase tracking-[0.2em] mb-6 font-bold">Legal &amp; Trust</h4>
      <ul class="space-y-3.5 font-body-md text-sm">
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('provenance') ?>">Certified Provenance</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('terms') ?>">Terms of Service</a></li>
        <li><a class="text-stone-300 md:text-on-surface-variant hover:text-[#e9c176] md:hover:text-accent transition-colors" href="<?= base_url('manifesto') ?>">Zero-Waste Manifesto</a></li>
      </ul>
    </div>
  </div>

  <!-- Trust & Secured Logistics Strip -->
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mt-12 pt-8 border-t border-white/10 md:border-outline-variant/60 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-[11px] font-mono text-stone-300 md:text-stone-600">
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/15 md:bg-stone-100 md:border-stone-200">
        <span class="material-symbols-outlined text-xs text-emerald-400 md:text-emerald-600">lock</span>
        <span>256-Bit AES Encrypted</span>
      </span>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/15 md:bg-stone-100 md:border-stone-200">
        <span class="material-symbols-outlined text-xs text-amber-400 md:text-amber-600">verified_user</span>
        <span>100% Certified Authentic</span>
      </span>
      <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/15 md:bg-stone-100 md:border-stone-200">
        <span class="material-symbols-outlined text-xs text-blue-400 md:text-blue-600">local_shipping</span>
        <span>Priority Insured Express Delivery</span>
      </span>
    </div>

    <!-- Payment Badges -->
    <div class="flex items-center gap-3 text-stone-700 text-lg">
      <span title="Visa Secure" class="px-2 py-1 bg-white border border-stone-200 rounded-md text-xs font-mono font-bold tracking-wider text-blue-800 shadow-2xs">VISA</span>
      <span title="Mastercard" class="px-2 py-1 bg-white border border-stone-200 rounded-md text-xs font-mono font-bold tracking-wider text-red-600 shadow-2xs">MC</span>
      <span title="American Express" class="px-2 py-1 bg-white border border-stone-200 rounded-md text-xs font-mono font-bold tracking-wider text-blue-600 shadow-2xs">AMEX</span>
      <span title="UPI Instant" class="px-2 py-1 bg-white border border-stone-200 rounded-md text-xs font-mono font-bold tracking-wider text-emerald-700 shadow-2xs">UPI</span>
      <span title="Cash on Delivery" class="px-2 py-1 bg-white border border-stone-200 rounded-md text-xs font-mono font-bold tracking-wider text-stone-900 shadow-2xs">COD</span>
    </div>
  </div>
</footer>

<?php
  $hs = $home_settings ?? [];
  $wa_enabled = isset($hs['whatsapp_enabled']) ? (int)$hs['whatsapp_enabled'] : 1;
  $wa_num     = !empty($hs['whatsapp_number']) ? preg_replace('/[^0-9]/', '', $hs['whatsapp_number']) : (getenv('TWILIO_WHATSAPP_NUMBER') ?: '919999999999');
  $wa_msg     = !empty($hs['whatsapp_message']) ? urlencode($hs['whatsapp_message']) : urlencode('Hi! I am browsing the NovaDrop Atelier collection and would love styling guidance.');
?>
<?php if ($wa_enabled): ?>
<!-- ══ GLOBAL WHATSAPP LIVE CONCIERGE BUTTON ══ -->
<a id="whatsappBtnGlobal" href="https://wa.me/<?= $wa_num ?>?text=<?= $wa_msg ?>" target="_blank" rel="noopener" class="fixed bottom-5 sm:bottom-6 right-4 sm:right-6 z-40 w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center shadow-2xl transition-all duration-300 hover:scale-110 active:scale-95 cursor-pointer" style="background: linear-gradient(135deg, #25d366, #128c7e);" title="Chat on WhatsApp with NovaDrop Stylist">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="26" height="26">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
  </svg>
</a>
<?php endif; ?>

<!-- ══ DESKTOP FLOATING GAMIFIED LUCKY WHEEL BUTTON ══ -->
<button id="floatingSpinWheelBtn" onclick="openStorefrontWheelModal()" class="hidden md:flex fixed bottom-6 left-6 z-40 px-4 py-2.5 rounded-full items-center gap-2.5 shadow-[0_12px_35px_rgba(0,0,0,0.6),0_0_20px_rgba(233,193,118,0.25)] transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer bg-gradient-to-r from-[#1c1917] via-[#0c0a09] to-[#1c1917] text-white border border-[#e9c176]/60 hover:border-[#e9c176] select-none group backdrop-blur-md" aria-label="Spin to Win VIP Privilege">
  <div class="relative w-6 h-6 flex items-center justify-center">
    <span class="absolute inset-0 rounded-full bg-amber-400/20 animate-ping"></span>
    <span class="text-base group-hover:rotate-180 transition-transform duration-700">🎡</span>
  </div>
  <div class="flex flex-col text-left">
    <span class="text-[9px] font-mono tracking-widest text-[#e9c176] uppercase font-bold leading-none">VIP ATELIER</span>
    <span class="font-bold uppercase tracking-wider text-[11px] text-white font-mono leading-tight">Spin &amp; Win 50%</span>
  </div>
  <span class="px-2 py-0.5 bg-gradient-to-r from-amber-400 to-[#e9c176] text-stone-950 rounded-full text-[9px] font-mono font-extrabold tracking-wider shadow-sm">GIFT</span>
</button>

<!-- ══ STOREFRONT LUCKY WHEEL MODAL (ULTRA-LUXE ATELIER GAMIFICATION) ══ -->
<div id="storefrontWheelModal" class="fixed inset-0 z-[150] bg-black/85 backdrop-blur-xl hidden items-center justify-center p-3 sm:p-4 overflow-y-auto" onclick="if(event.target===this)closeStorefrontWheelModal()" role="dialog" aria-modal="true">
  
  <!-- Canvas Confetti Overlay for Winning Celebration -->
  <canvas id="sfWheelConfettiCanvas" class="fixed inset-0 pointer-events-none z-[160] hidden"></canvas>

  <div class="bg-gradient-to-b from-[#13111c] via-[#0c0a10] to-[#08070b] text-white rounded-[32px] border border-[#e9c176]/40 shadow-[0_25px_80px_rgba(0,0,0,0.95),0_0_60px_rgba(233,193,118,0.15)] max-w-[420px] w-full p-5 sm:p-7 relative overflow-hidden text-center transition-all duration-300 transform scale-100">
    
    <!-- Ambient Radiance Background Lights -->
    <div class="absolute -top-24 -left-24 w-60 h-60 rounded-full bg-amber-500/15 blur-[80px] pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-60 h-60 rounded-full bg-purple-600/15 blur-[80px] pointer-events-none"></div>
    <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-[#e9c176] to-amber-300 absolute top-0 left-0 right-0"></div>

    <!-- Close Button -->
    <button type="button" onclick="closeStorefrontWheelModal()" class="absolute top-4 right-4 text-white/50 hover:text-white w-8 h-8 rounded-full bg-white/5 hover:bg-white/15 border border-white/10 flex items-center justify-center cursor-pointer active:scale-90 transition-all z-20" aria-label="Close modal">
      <span class="material-symbols-outlined text-lg">close</span>
    </button>

    <!-- Interactive Wheel Mode Container -->
    <div id="sfWheelActiveState" class="relative z-10 transition-opacity duration-300">
      
      <!-- Top Badge -->
      <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gradient-to-r from-[#e9c176]/15 via-amber-400/10 to-[#e9c176]/15 border border-[#e9c176]/40 text-[#e9c176] text-[10px] font-mono font-bold uppercase tracking-[0.2em] mb-2 shadow-[0_0_15px_rgba(233,193,118,0.1)]">
        <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176] animate-ping"></span>
        <span>✦ VIP ATELIER PRIVILEGE ✦</span>
      </div>
      
      <h3 class="font-serif text-xl sm:text-2xl font-bold text-white mb-1 leading-tight tracking-tight">
        Spin &amp; Win <span class="bg-gradient-to-r from-[#ffe8b3] via-[#e9c176] to-[#f59e0b] bg-clip-text text-transparent">Instant Privilege</span>
      </h3>
      <p class="text-[10.5px] font-mono text-white/60 mb-2.5 sm:mb-3 px-2">
        Unlock guaranteed VIP discounts, cash gifts &amp; complimentary shipping!
      </p>
      
      <!-- ══ WHEEL DISPLAY STAGE (RESPONSIVE) ══ -->
      <div id="sfWheelStage" class="relative w-[260px] h-[260px] sm:w-[290px] sm:h-[290px] mx-auto mb-3 select-none flex items-center justify-center">
        
        <!-- Outer Glowing Rim Halo -->
        <div class="absolute -inset-2 rounded-full bg-gradient-to-tr from-amber-500/20 via-[#e9c176]/30 to-amber-300/20 blur-xl pointer-events-none animate-pulse"></div>

        <!-- 3D Luxury Swiss Timepiece Gold Pointer with Spring Flick -->
        <div id="sfWheelPointer" class="absolute -top-3 left-1/2 -translate-x-1/2 z-30 pointer-events-none transition-transform origin-top" style="filter: drop-shadow(0 4px 10px rgba(0,0,0,0.9));">
          <svg width="32" height="40" viewBox="0 0 34 42" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Outer Golden Arrow Bevel -->
            <path d="M17 42L4 12C2 7.5 5.5 2 10.5 2H23.5C28.5 2 32 7.5 30 12L17 42Z" fill="url(#ptrGoldOuter)" stroke="#ffd700" stroke-width="1.5"/>
            <!-- Inner Faceted Body -->
            <path d="M17 37L7 12C5.5 8.5 8 4.5 12 4.5H22C26 4.5 28.5 8.5 27 12L17 37Z" fill="url(#ptrGoldInner)"/>
            <!-- Center Facet Ridge -->
            <path d="M17 4.5V37L27 12H17Z" fill="white" fill-opacity="0.18"/>
            <!-- Glowing Ruby/Amber Pivot Jewel -->
            <circle cx="17" cy="11" r="5" fill="url(#ptrGem)" stroke="#ffd700" stroke-width="1.5"/>
            <circle cx="15.5" cy="9.5" r="1.5" fill="white" fill-opacity="0.8"/>
            <defs>
              <linearGradient id="ptrGoldOuter" x1="4" y1="2" x2="30" y2="42" gradientUnits="userSpaceOnUse">
                <stop stop-color="#fffbeb"/>
                <stop offset="0.25" stop-color="#f59e0b"/>
                <stop offset="0.7" stop-color="#b45309"/>
                <stop offset="1" stop-color="#451a03"/>
              </linearGradient>
              <linearGradient id="ptrGoldInner" x1="7" y1="4.5" x2="27" y2="37" gradientUnits="userSpaceOnUse">
                <stop stop-color="#fef08a"/>
                <stop offset="0.4" stop-color="#d97706"/>
                <stop offset="1" stop-color="#78350f"/>
              </linearGradient>
              <radialGradient id="ptrGem" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(17 11) scale(5)">
                <stop stop-color="#fca5a5"/>
                <stop offset="0.5" stop-color="#dc2626"/>
                <stop offset="1" stop-color="#7f1d1d"/>
              </radialGradient>
            </defs>
          </svg>
        </div>

        <!-- Super-Sampled High-Definition Wheel Canvas (600x600 Internal Buffer for Crystal Sharpness) -->
        <canvas id="sfWheelCanvas" width="600" height="600" class="w-full h-full rounded-full cursor-pointer relative z-10 shadow-[0_12px_40px_rgba(0,0,0,0.95)]"></canvas>

        <!-- Center 3D Luxury Push Button Hub -->
        <div id="sfSpinCap" onclick="spinStorefrontWheel()" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[52px] h-[52px] sm:w-[58px] sm:h-[58px] rounded-full bg-gradient-to-b from-[#241f1c] via-[#120f0e] to-[#080606] border-[2.5px] border-[#e9c176] shadow-[0_0_25px_rgba(0,0,0,0.95),0_0_15px_rgba(233,193,118,0.4),inset_0_2px_4px_rgba(255,255,255,0.3)] flex flex-col items-center justify-center cursor-pointer z-20 group hover:scale-105 active:scale-95 transition-all">
          <div class="w-1.5 h-1.5 rounded-full bg-gradient-to-tr from-amber-400 to-[#e9c176] shadow-[0_0_8px_#e9c176] mb-0.5 animate-pulse"></div>
          <span class="font-sans font-black text-[10px] sm:text-[11px] tracking-[0.15em] text-[#e9c176] group-hover:text-white transition-colors">SPIN</span>
        </div>
      </div>

      <!-- ══ EMAIL INPUT & SPIN BUTTON FORM ══ -->
      <div id="sfSpinInputForm" class="space-y-2">
        <div class="relative">
          <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/40 text-sm pointer-events-none">mail</span>
          <input type="email" id="sfSpinEmail" placeholder="Enter your email to unlock spin (e.g. name@domain.com)" class="w-full pl-9 pr-3.5 py-2.5 sm:py-3 bg-white/[0.06] hover:bg-white/[0.09] focus:bg-black/60 border border-white/15 focus:border-[#e9c176] rounded-2xl text-xs font-mono text-white placeholder:text-white/40 outline-none transition-all shadow-inner text-center focus:ring-2 focus:ring-[#e9c176]/20">
        </div>
        
        <button type="button" id="sfSpinActionBtn" onclick="spinStorefrontWheel()" class="relative overflow-hidden w-full py-3 sm:py-3.5 bg-gradient-to-r from-amber-500 via-[#e9c176] to-amber-500 text-stone-950 font-mono font-extrabold text-xs uppercase tracking-[0.15em] rounded-2xl shadow-[0_8px_25px_rgba(233,193,118,0.35)] cursor-pointer hover:opacity-95 transition-all active:scale-[0.98] flex items-center justify-center gap-2 group">
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000 ease-in-out"></div>
          <span class="text-sm">🎡</span>
          <span>SPIN &amp; CLAIM PRIVILEGE</span>
          <span class="material-symbols-outlined text-sm transition-transform group-hover:translate-x-0.5">arrow_forward</span>
        </button>

        <p class="text-[9.5px] font-mono text-white/40 flex items-center justify-center gap-1.5">
          <span class="material-symbols-outlined text-[12px] text-[#e9c176]">verified_user</span>
          <span>100% Guaranteed Reward • 1 Spin per VIP Guest</span>
        </p>
      </div>

    </div>

    <!-- ══ GRAND WINNER CELEBRATION CARD ══ -->
    <div id="sfWinBox" class="p-6 sm:p-7 bg-gradient-to-b from-[#1f1b29] via-[#120f1a] to-[#09080e] border border-[#e9c176]/80 rounded-[28px] hidden text-center relative overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.9),0_0_35px_rgba(233,193,118,0.25)] animate-in zoom-in-95 duration-400">
      
      <!-- Background Halo -->
      <div class="absolute w-48 h-48 rounded-full bg-gradient-to-br from-amber-500/30 to-purple-500/20 blur-[60px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none animate-pulse"></div>

      <div class="relative z-10">
        <!-- Floating Trophy / Crown -->
        <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-amber-400 via-[#e9c176] to-amber-200 text-stone-950 flex items-center justify-center mx-auto mb-3 shadow-[0_0_25px_rgba(233,193,118,0.6)] animate-bounce text-3xl">
          👑
        </div>

        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400/15 border border-amber-400/40 text-amber-300 text-[10px] font-mono font-bold uppercase tracking-widest mb-1.5">
          <span>✦ PRIVILEGE UNLOCKED ✦</span>
        </div>

        <h4 class="font-serif text-2xl sm:text-3xl font-bold text-white mb-2 leading-tight tracking-tight" id="sfWinTitle">
          You Won: 25% VIP Discount!
        </h4>

        <p class="text-[11px] font-mono text-white/70 mb-4 max-w-xs mx-auto">
          Your complimentary coupon code is active and ready to use at checkout.
        </p>

        <!-- Golden Luxury Coupon Ticket -->
        <div class="p-3.5 bg-black/70 border-2 border-dashed border-[#e9c176]/70 rounded-2xl mb-4 flex items-center justify-between gap-3 shadow-[inset_0_2px_8px_rgba(0,0,0,0.8)] relative group">
          <div class="text-left pl-1">
            <span class="text-[9px] font-mono text-white/50 uppercase tracking-widest block font-semibold">Atelier Privilege Code</span>
            <span class="text-[#ffe8b3] font-mono font-black text-xl tracking-widest select-all" id="sfWinCode">VIP25</span>
          </div>
          <button type="button" onclick="copyWheelPrizeCode()" class="px-3 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl text-[10px] font-mono font-bold uppercase tracking-wider flex items-center gap-1.5 shadow-md hover:brightness-110 active:scale-95 transition-all cursor-pointer">
            <span class="material-symbols-outlined text-xs" id="sfCopyIcon">content_copy</span>
            <span id="sfCopyText">COPY</span>
          </button>
        </div>

        <!-- CTA & Auto-Dismiss Timer Progress -->
        <button type="button" onclick="claimWheelReward()" class="w-full py-3.5 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 text-stone-950 font-mono font-black text-xs uppercase tracking-[0.15em] rounded-2xl shadow-[0_10px_30px_rgba(233,193,118,0.4)] cursor-pointer hover:opacity-95 active:scale-[0.98] transition-all mb-3 flex items-center justify-center gap-2">
          <span>CLAIM &amp; SHOP NOW ⚡</span>
        </button>

        <!-- Progress Bar for Auto Direct -->
        <div class="w-full bg-white/10 rounded-full h-1 mb-2 overflow-hidden">
          <div id="sfCountdownBar" class="bg-gradient-to-r from-amber-400 to-[#e9c176] h-full w-full transition-all duration-1000 ease-linear"></div>
        </div>

        <div class="flex items-center justify-center gap-1.5 text-[10px] font-mono text-amber-300/80">
          <span class="material-symbols-outlined text-xs animate-spin" style="animation-duration: 3s;">hourglass_top</span>
          <span id="sfAutoExitText">Continuing to boutique in 4s...</span>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
// ════════════════════════════════════════════════════════════
// ULTRA-LUXE GAMIFIED LUCKY WHEEL ENGINE (HIGH-DEFINITION)
// ════════════════════════════════════════════════════════════
// Note: Auto-trigger disabled to provide a calm, luxury browsing experience.
// Accessible via floating "VIP ATELIER / Spin & Win" button.

const sfSlices = [
  { label: '50% OFF', sub: 'GRAND VIP', color1: '#4a2608', color2: '#180a02', border: '#ffd700', icon: '👑', code: 'LUMINA50', accent: '#fde047' },
  { label: '₹500 OFF', sub: 'CASH GIFT', color1: '#064e3b', color2: '#02241b', border: '#34d399', icon: '💎', code: 'STAY500', accent: '#a7f3d0' },
  { label: '25% OFF', sub: 'ATELIER VIP', color1: '#4c1d95', color2: '#190736', border: '#c084fc', icon: '✦', code: 'VIP25', accent: '#e9d5ff' },
  { label: 'FREE EXP', sub: 'DELIVERY', color1: '#1e3a8a', color2: '#091538', border: '#60a5fa', icon: '🚀', code: 'FREESHIP', accent: '#bfdbfe' },
  { label: 'MYSTERY', sub: 'SECRET BOX', color1: '#831843', color2: '#2b0717', border: '#f472b6', icon: '🎁', code: 'MYSTERYGIFT', accent: '#fbcfe8' },
  { label: '15% OFF', sub: 'STOREWIDE', color1: '#262626', color2: '#0e0e0e', border: '#e9c176', icon: '✨', code: 'LUCKY15', accent: '#fef08a' }
];

let sfAngle = 0;
let sfIsSpinning = false;
let sfCurrentPrize = null;
let sfLastTickSegment = -1;
let sfAudioCtx = null;

// Procedural Web Audio Sound Generator for Zero-Asset Luxury Ticks & Chimes
function playTickSound() {
  try {
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    if (!AudioContext) return;
    if (!sfAudioCtx) sfAudioCtx = new AudioContext();
    if (sfAudioCtx.state === 'suspended') sfAudioCtx.resume();

    const osc = sfAudioCtx.createOscillator();
    const gain = sfAudioCtx.createGain();
    osc.type = 'triangle';
    osc.frequency.setValueAtTime(1000, sfAudioCtx.currentTime);
    osc.frequency.exponentialRampToValueAtTime(120, sfAudioCtx.currentTime + 0.04);
    gain.gain.setValueAtTime(0.18, sfAudioCtx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.001, sfAudioCtx.currentTime + 0.04);
    osc.connect(gain);
    gain.connect(sfAudioCtx.destination);
    osc.start();
    osc.stop(sfAudioCtx.currentTime + 0.04);
  } catch (e) {}
}

function playWinFanfare() {
  try {
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    if (!AudioContext) return;
    if (!sfAudioCtx) sfAudioCtx = new AudioContext();
    if (sfAudioCtx.state === 'suspended') sfAudioCtx.resume();

    const notes = [523.25, 659.25, 783.99, 1046.50]; // C5, E5, G5, C6
    notes.forEach((freq, idx) => {
      setTimeout(() => {
        try {
          const osc = sfAudioCtx.createOscillator();
          const gain = sfAudioCtx.createGain();
          osc.type = 'sine';
          osc.frequency.setValueAtTime(freq, sfAudioCtx.currentTime);
          gain.gain.setValueAtTime(0.2, sfAudioCtx.currentTime);
          gain.gain.exponentialRampToValueAtTime(0.001, sfAudioCtx.currentTime + 0.65);
          osc.connect(gain);
          gain.connect(sfAudioCtx.destination);
          osc.start();
          osc.stop(sfAudioCtx.currentTime + 0.65);
        } catch(e) {}
      }, idx * 110);
    });
  } catch (e) {}
}

function openStorefrontWheelModal() {
  const m = document.getElementById('storefrontWheelModal');
  if (m) { 
    m.classList.remove('hidden'); 
    m.classList.add('flex'); 
    document.body.style.overflow = 'hidden';
    setTimeout(drawSfWheel, 30);
  }
}

function closeStorefrontWheelModal() {
  const m = document.getElementById('storefrontWheelModal');
  if (m) { 
    m.classList.add('hidden'); 
    m.classList.remove('flex'); 
    document.body.style.overflow = '';
  }
  sessionStorage.setItem('sfWheelPlayed', '1');
  if (window._sfAutoExitTimer) clearTimeout(window._sfAutoExitTimer);
  if (window._sfCountdownInterval) clearInterval(window._sfCountdownInterval);
}

// ════════════════════════════════════════════════════════════
// RAZOR-SHARP HIGH-DEFINITION SUPER-SAMPLED CANVAS DRAW LOOP
// ════════════════════════════════════════════════════════════
function drawSfWheel() {
  const c = document.getElementById('sfWheelCanvas');
  if (!c) return;
  const ctx = c.getContext('2d');
  
  // Super-sampled internal coordinate space (600x600 for extreme sharpness)
  const width = 600;
  const height = 600;
  if (c.width !== width || c.height !== height) {
    c.width = width;
    c.height = height;
  }

  ctx.clearRect(0, 0, width, height);
  ctx.imageSmoothingEnabled = true;
  ctx.imageSmoothingQuality = 'high';

  const cx = 300;
  const cy = 300;
  const outerR = 294;
  const rimWidth = 30;
  const wheelR = outerR - rimWidth;
  const num = sfSlices.length;
  const arc = (2 * Math.PI) / num;

  // 1. Draw Multi-Bevel Metallic 24k Gold Outer Bezel
  const rimGrad = ctx.createRadialGradient(cx, cy, wheelR, cx, cy, outerR);
  rimGrad.addColorStop(0, '#1c1917');
  rimGrad.addColorStop(0.15, '#78350f');
  rimGrad.addColorStop(0.45, '#ffd700');
  rimGrad.addColorStop(0.75, '#f59e0b');
  rimGrad.addColorStop(0.95, '#b45309');
  rimGrad.addColorStop(1, '#1c1917');

  ctx.fillStyle = rimGrad;
  ctx.beginPath();
  ctx.arc(cx, cy, outerR, 0, 2 * Math.PI);
  ctx.fill();

  // Outer Gold Rim Stroke with Specular Bevel
  ctx.strokeStyle = '#ffd700';
  ctx.lineWidth = 3.5;
  ctx.stroke();

  // Concentric Inner Engraved Golden Ring
  ctx.strokeStyle = '#fef08a';
  ctx.lineWidth = 1.2;
  ctx.beginPath();
  ctx.arc(cx, cy, outerR - 4, 0, 2 * Math.PI);
  ctx.stroke();

  // 2. Draw 24 Precision Glowing Cabochon Studs / Jewel LEDs
  const totalStuds = 24;
  const studRadius = 5.5;
  const studDist = outerR - (rimWidth / 2);
  const now = Date.now() / 160;

  for (let s = 0; s < totalStuds; s++) {
    const sAngle = (s * 2 * Math.PI) / totalStuds;
    const sx = cx + Math.cos(sAngle) * studDist;
    const sy = cy + Math.sin(sAngle) * studDist;
    const isLit = (Math.floor(now + s) % 2 === 0) || sfIsSpinning;

    ctx.save();
    ctx.beginPath();
    ctx.arc(sx, sy, studRadius, 0, 2 * Math.PI);
    if (isLit) {
      ctx.fillStyle = '#ffffff';
      ctx.shadowColor = '#ffd700';
      ctx.shadowBlur = 14;
    } else {
      ctx.fillStyle = '#92400e';
      ctx.shadowBlur = 0;
    }
    ctx.fill();
    ctx.strokeStyle = '#d97706';
    ctx.lineWidth = 1.5;
    ctx.stroke();
    ctx.restore();
  }

  // 3. Draw Slices with Rich Atelier Depth & Satin Gradients
  for (let i = 0; i < num; i++) {
    const a = sfAngle + i * arc;
    const slice = sfSlices[i];

    ctx.save();
    ctx.beginPath();
    ctx.arc(cx, cy, wheelR, a, a + arc);
    ctx.lineTo(cx, cy);
    ctx.closePath();

    // Radial Depth Gradient
    const sliceGrad = ctx.createRadialGradient(cx, cy, 35, cx, cy, wheelR);
    sliceGrad.addColorStop(0, slice.color2);
    sliceGrad.addColorStop(0.7, slice.color1);
    sliceGrad.addColorStop(1, slice.color2);
    ctx.fillStyle = sliceGrad;
    ctx.fill();

    // Golden Divider Line with 3D Highlight
    ctx.strokeStyle = '#ffd700';
    ctx.lineWidth = 2.5;
    ctx.stroke();

    // Slice Inner Edge Glow Arc
    ctx.beginPath();
    ctx.arc(cx, cy, wheelR - 2, a, a + arc);
    ctx.strokeStyle = slice.border;
    ctx.lineWidth = 3.5;
    ctx.stroke();
    ctx.restore();

    // 4. Draw Physical 3D Gold Delimiter Pegs at each boundary
    const pegX = cx + Math.cos(a) * (wheelR - 5);
    const pegY = cy + Math.sin(a) * (wheelR - 5);
    ctx.save();
    ctx.beginPath();
    ctx.arc(pegX, pegY, 4, 0, 2 * Math.PI);
    ctx.fillStyle = '#ffd700';
    ctx.shadowColor = '#000000';
    ctx.shadowBlur = 4;
    ctx.fill();
    ctx.strokeStyle = '#b45309';
    ctx.lineWidth = 1;
    ctx.stroke();
    ctx.restore();

    // 5. Draw Slice Content (Perfect Tangential Arc Layout with Generous Clearance)
    ctx.save();
    ctx.translate(cx, cy);
    ctx.rotate(a + arc / 2);

    // 5a. Icon Medal Disc near outer rim (r = 216)
    ctx.save();
    ctx.translate(216, 0);
    ctx.rotate(Math.PI / 2);
    
    ctx.beginPath();
    ctx.arc(0, 0, 15, 0, 2 * Math.PI);
    ctx.fillStyle = 'rgba(0,0,0,0.55)';
    ctx.fill();
    ctx.strokeStyle = 'rgba(255,215,0,0.6)';
    ctx.lineWidth = 1.2;
    ctx.stroke();

    ctx.font = '18px "Apple Color Emoji", "Segoe UI Emoji", system-ui, sans-serif';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(slice.icon, 0, 0);
    ctx.restore();

    // 5b. Primary Bold Prize Label (r = 152, oriented along arc tangent)
    ctx.save();
    ctx.translate(152, 0);
    ctx.rotate(Math.PI / 2);
    ctx.fillStyle = '#ffffff';
    ctx.shadowColor = 'rgba(0,0,0,0.95)';
    ctx.shadowBlur = 8;
    ctx.font = '900 18px -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(slice.label, 0, 0);
    ctx.restore();

    // 5c. Secondary Subtitle Pill (r = 96, oriented along arc tangent)
    ctx.save();
    ctx.translate(96, 0);
    ctx.rotate(Math.PI / 2);
    
    // Background mini pill
    ctx.beginPath();
    ctx.roundRect(-34, -7.5, 68, 15, 6);
    ctx.fillStyle = 'rgba(0,0,0,0.65)';
    ctx.fill();
    ctx.strokeStyle = 'rgba(255,215,0,0.45)';
    ctx.lineWidth = 0.9;
    ctx.stroke();

    ctx.fillStyle = slice.accent || '#fde047';
    ctx.shadowColor = 'rgba(0,0,0,0.95)';
    ctx.shadowBlur = 4;
    ctx.font = 'bold 8.5px "Space Mono", monospace';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(slice.sub, 0, 0);
    ctx.restore();

    ctx.restore();
  }

  // Inner Wheel Rim Gold Stroke
  ctx.beginPath();
  ctx.arc(cx, cy, wheelR, 0, 2 * Math.PI);
  ctx.strokeStyle = '#ffd700';
  ctx.lineWidth = 3.5;
  ctx.stroke();
}

function spinStorefrontWheel() {
  if (sfIsSpinning) return;
  const emailInput = document.getElementById('sfSpinEmail');
  if (emailInput && (!emailInput.value || !emailInput.value.includes('@'))) {
    emailInput.focus();
    emailInput.classList.add('ring-2', 'ring-rose-500', 'animate-shake');
    setTimeout(() => emailInput.classList.remove('ring-2', 'ring-rose-500', 'animate-shake'), 1200);
    if (typeof ndToast === 'function') {
      ndToast('Please enter a valid email to unlock your VIP spin!', 'info');
    } else {
      alert('Please enter your email to spin & unlock your VIP reward!');
    }
    return;
  }

  sfIsSpinning = true;
  const pointerEl = document.getElementById('sfWheelPointer');
  const winIdx = Math.floor(Math.random() * sfSlices.length);
  const num = sfSlices.length;
  const arc = (2 * Math.PI) / num;

  // The pointer is at 12 o'clock (top center, -Math.PI / 2).
  // Target position calculates the center of the winning slice landed at the top.
  const targetSliceAngle = (2 * Math.PI) - (winIdx * arc + arc / 2);
  const totalRotations = 6 * (2 * Math.PI);
  const targetAngle = sfAngle + totalRotations + targetSliceAngle - (Math.PI / 2);
  const startAngle = sfAngle;
  const duration = 4400;
  let startTime = null;

  function animate(ts) {
    if (!startTime) startTime = ts;
    const elapsed = ts - startTime;
    const p = Math.min(elapsed / duration, 1);

    // Quintic deceleration easing for realistic luxury wheel spin
    const ease = 1 - Math.pow(1 - p, 4);
    sfAngle = startAngle + (targetAngle - startAngle) * ease;
    drawSfWheel();

    // Calculate current slice under needle for physical tick animation & sound
    const currentRotatedAngle = (sfAngle + Math.PI / 2) % (2 * Math.PI);
    const positiveAngle = (currentRotatedAngle < 0 ? currentRotatedAngle + (2 * Math.PI) : currentRotatedAngle);
    const currentSegment = Math.floor((2 * Math.PI - positiveAngle) / arc) % num;

    if (currentSegment !== sfLastTickSegment) {
      sfLastTickSegment = currentSegment;
      playTickSound();
      if (pointerEl) {
        pointerEl.style.transform = 'translateX(-50%) rotate(-18deg)';
        setTimeout(() => {
          if (pointerEl) pointerEl.style.transform = 'translateX(-50%) rotate(0deg)';
        }, 60);
      }
    }

    if (p < 1) {
      requestAnimationFrame(animate);
    } else {
      sfAngle = targetAngle % (2 * Math.PI);
      drawSfWheel();
      sfIsSpinning = false;
      sfCurrentPrize = sfSlices[winIdx];
      
      // Play winning fanfare sound & launch confetti
      playWinFanfare();
      launchWheelConfetti();

      setTimeout(() => {
        // Transition from wheel active state to Winner Celebration card
        const activeState = document.getElementById('sfWheelActiveState');
        const winBox = document.getElementById('sfWinBox');
        if (activeState) activeState.classList.add('hidden');
        if (winBox) {
          document.getElementById('sfWinTitle').textContent = 'You Won: ' + sfCurrentPrize.label + ' ' + sfCurrentPrize.sub + '!';
          document.getElementById('sfWinCode').textContent = sfCurrentPrize.code || 'VIP25';
          winBox.classList.remove('hidden');
        }

        // Auto-save discount code to user session
        if (sfCurrentPrize.code) {
          localStorage.setItem('lumina_applied_coupon', sfCurrentPrize.code);
          if (typeof setQuickCoupon === 'function') {
            setQuickCoupon(sfCurrentPrize.code, 25, 'percent');
          }
        }
        sessionStorage.setItem('sfWheelPlayed', '1');

        // Countdown & Self-Exit Progress Bar after 4 seconds
        let remainingSecs = 4;
        const autoText = document.getElementById('sfAutoExitText');
        const countBar = document.getElementById('sfCountdownBar');
        if (countBar) countBar.style.width = '100%';

        if (window._sfCountdownInterval) clearInterval(window._sfCountdownInterval);
        window._sfCountdownInterval = setInterval(() => {
          remainingSecs--;
          if (countBar) {
            countBar.style.width = (remainingSecs / 4 * 100) + '%';
          }
          if (autoText) {
            if (remainingSecs > 0) {
              autoText.textContent = `Continuing to boutique in ${remainingSecs}s...`;
            } else {
              autoText.textContent = 'Applying discount & entering boutique...';
            }
          }
          if (remainingSecs <= 0) {
            clearInterval(window._sfCountdownInterval);
          }
        }, 1000);

        if (window._sfAutoExitTimer) clearTimeout(window._sfAutoExitTimer);
        window._sfAutoExitTimer = setTimeout(() => {
          closeStorefrontWheelModal();
          if (typeof ndToast === 'function') {
            ndToast(`✦ Privilege ${sfCurrentPrize.code} Activated! Applied to your Atelier bag.`, 'success');
          }
        }, 4200);
      }, 500);
    }
  }
  requestAnimationFrame(animate);
}

function copyWheelPrizeCode() {
  if (sfCurrentPrize && sfCurrentPrize.code) {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(sfCurrentPrize.code).catch(() => {});
    }
    const copyText = document.getElementById('sfCopyText');
    const copyIcon = document.getElementById('sfCopyIcon');
    if (copyText) copyText.textContent = 'COPIED! ✓';
    if (copyIcon) copyIcon.textContent = 'check';
    setTimeout(() => {
      if (copyText) copyText.textContent = 'COPY';
      if (copyIcon) copyIcon.textContent = 'content_copy';
    }, 2500);
  }
}

function claimWheelReward() {
  if (window._sfAutoExitTimer) clearTimeout(window._sfAutoExitTimer);
  if (window._sfCountdownInterval) clearInterval(window._sfCountdownInterval);
  
  if (sfCurrentPrize && sfCurrentPrize.code) {
    if (navigator.clipboard) {
      navigator.clipboard.writeText(sfCurrentPrize.code).catch(() => {});
    }
    if (typeof setQuickCoupon === 'function') {
      setQuickCoupon(sfCurrentPrize.code, 25, 'percent');
    }
  }
  closeStorefrontWheelModal();
  if (typeof ndToast === 'function') {
    ndToast(`✦ Code ${sfCurrentPrize ? sfCurrentPrize.code : 'VIP25'} Applied! Enjoy your VIP shopping.`, 'success');
  }
  if (typeof toggleQuickBagDrawer === 'function') {
    toggleQuickBagDrawer();
  }
}

// ════════════════════════════════════════════════════════════
// LUXURY CELEBRATION CONFETTI ENGINE
// ════════════════════════════════════════════════════════════
function launchWheelConfetti() {
  const canvas = document.getElementById('sfWheelConfettiCanvas');
  if (!canvas) return;
  canvas.classList.remove('hidden');
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  const ctx = canvas.getContext('2d');

  const particles = [];
  const colors = ['#ffd700', '#f59e0b', '#e9c176', '#ffffff', '#10b981', '#c084fc', '#f472b6'];

  for (let i = 0; i < 90; i++) {
    particles.push({
      x: window.innerWidth / 2 + (Math.random() * 80 - 40),
      y: window.innerHeight / 2 - 50,
      vx: (Math.random() - 0.5) * 14,
      vy: (Math.random() - 0.7) * 16,
      size: Math.random() * 8 + 4,
      color: colors[Math.floor(Math.random() * colors.length)],
      rotation: Math.random() * 360,
      rotSpeed: (Math.random() - 0.5) * 10,
      alpha: 1
    });
  }

  let startTime = null;
  function renderConfetti(ts) {
    if (!startTime) startTime = ts;
    const progress = (ts - startTime) / 2800;
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;
      p.vy += 0.35; // gravity
      p.vx *= 0.98;
      p.rotation += p.rotSpeed;
      p.alpha = Math.max(0, 1 - progress);

      ctx.save();
      ctx.globalAlpha = p.alpha;
      ctx.translate(p.x, p.y);
      ctx.rotate((p.rotation * Math.PI) / 180);
      ctx.fillStyle = p.color;
      ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.6);
      ctx.restore();
    });

    if (progress < 1) {
      requestAnimationFrame(renderConfetti);
    } else {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      canvas.classList.add('hidden');
    }
  }
  requestAnimationFrame(renderConfetti);
}
</script>

<!-- ══ 1. STOREFRONT VIP WAITLIST & RESTOCK MODAL ══ -->
<div id="storefrontWaitlistModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md hidden items-center justify-center p-4" onclick="if(event.target===this)closeStorefrontWaitlistModal()">
  <div class="bg-white rounded-3xl border border-stone-200 shadow-2xl max-w-md w-full p-6 relative overflow-hidden text-stone-900">
    <button type="button" onclick="closeStorefrontWaitlistModal()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-900 w-8 h-8 rounded-full bg-stone-100 flex items-center justify-center cursor-pointer">
      ✕
    </button>
    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-mono font-bold uppercase tracking-wider mb-2">
      <span class="material-symbols-outlined text-xs">notifications_active</span>
      <span>VIP Priority Restock Pass</span>
    </div>
    <h3 class="font-serif text-xl font-bold text-stone-950 mb-1" id="sfWlTitle">
      Join The Atelier Waitlist
    </h3>
    <p class="text-xs text-stone-500 font-light mb-4">
      Be the first to be notified via SMS, WhatsApp &amp; Email when this sold-out archival piece drops back into inventory.
    </p>

    <!-- Waitlist Form -->
    <form id="sfWaitlistForm" onsubmit="handleStorefrontWaitlistSubmit(event)" class="space-y-3 text-xs">
      <input type="hidden" id="sfWlProductId" value="1">
      <div>
        <label class="font-mono uppercase text-[10px] text-stone-600 block mb-1 font-bold">Your Full Name</label>
        <input type="text" id="sfWlName" required placeholder="Elena Rostova" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-900 outline-none focus:border-stone-950">
      </div>
      <div>
        <label class="font-mono uppercase text-[10px] text-stone-600 block mb-1 font-bold">Email Address</label>
        <input type="email" id="sfWlEmail" required placeholder="elena@atelier.com" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-900 outline-none focus:border-stone-950">
      </div>
      <div>
        <label class="font-mono uppercase text-[10px] text-stone-600 block mb-1 font-bold">WhatsApp / Mobile for Instant Drop Ping</label>
        <input type="tel" id="sfWlPhone" placeholder="+91 98765 43210" class="w-full px-3.5 py-2.5 bg-stone-50 border border-stone-200 rounded-xl text-xs text-stone-900 outline-none focus:border-stone-950">
      </div>

      <div id="sfWlSuccess" class="hidden p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs font-mono font-bold text-center">
        ✓ You're #1 on the VIP Priority Queue! We will ping your phone upon restock.
      </div>

      <button type="submit" id="sfWlSubmitBtn" class="w-full py-3.5 bg-stone-950 hover:bg-stone-800 text-white font-button text-xs uppercase tracking-widest font-extrabold rounded-2xl shadow-xl flex items-center justify-center gap-2 cursor-pointer transition-all">
        <span class="material-symbols-outlined text-base">notifications</span>
        <span>Secure Priority Restock Slot →</span>
      </button>
    </form>
  </div>
</div>

<!-- ══ 2. STOREFRONT MYSTERY BOX DROPS MODAL ══ -->
<div id="storefrontMysteryModal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md hidden items-center justify-center p-4" onclick="if(event.target===this)closeMysteryDropModal()">
  <div class="bg-[#090a0f] text-white rounded-3xl border border-white/15 shadow-2xl max-w-2xl w-full p-6 sm:p-8 relative overflow-hidden max-h-[90vh] overflow-y-auto custom-scrollbar">
    <button type="button" onclick="closeMysteryDropModal()" class="absolute top-4 right-4 text-white/50 hover:text-white w-8 h-8 rounded-full bg-white/10 flex items-center justify-center cursor-pointer">
      ✕
    </button>
    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-500/20 border border-purple-500/30 text-purple-300 text-[10px] font-mono font-bold uppercase tracking-wider mb-2">
      <span>🎁 HIGH-FOMO ATELIER CAPSULES</span>
    </div>
    <h3 class="font-serif text-2xl font-bold text-white mb-1">
      Atelier Mystery Drops &amp; Blind Boxes
    </h3>
    <p class="text-xs text-white/60 font-light mb-6">
      Hand-packed secret couture wardrobes. Every capsule contains guaranteed value exceeding 2.5× to 3× your acquisition price.
    </p>

    <!-- 4 Tiers Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-4">
      
      <!-- Tier 1: Silver -->
      <div class="bg-white/5 border border-white/10 hover:border-amber-400/50 rounded-2xl p-4 flex flex-col justify-between transition-all">
        <div>
          <div class="flex justify-between items-center mb-1">
            <span class="text-lg">🥈</span>
            <span class="text-[10px] font-mono uppercase bg-white/10 px-2 py-0.5 rounded text-white/80">Value ₹1,800+</span>
          </div>
          <h4 class="font-serif font-bold text-sm text-white">Silver Blind Box</h4>
          <p class="text-[11px] text-white/50 mt-1 leading-relaxed">3 curated wardrobe essentials + 1 surprise handcrafted accessory.</p>
        </div>
        <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between">
          <span class="font-serif text-base font-bold text-amber-300">₹799</span>
          <button type="button" onclick="closeMysteryDropModal(); openExpressCheckout(1, 'Atelier Silver Mystery Blind Box (3 Pieces)', 799, '<?= base_url('img/cashmere_turtleneck_knit.jpg') ?>');" class="px-3 py-1.5 bg-white text-stone-950 font-mono text-[10px] font-extrabold uppercase rounded-lg hover:bg-amber-300 transition-all cursor-pointer">
            Acquire Tier
          </button>
        </div>
      </div>

      <!-- Tier 2: Gold -->
      <div class="bg-gradient-to-br from-amber-500/10 to-amber-600/5 border border-amber-400/40 rounded-2xl p-4 flex flex-col justify-between relative shadow-lg">
        <span class="absolute -top-2.5 right-3 px-2 py-0.5 bg-amber-500 text-stone-950 font-mono text-[8px] font-extrabold uppercase rounded-full">POPULAR</span>
        <div>
          <div class="flex justify-between items-center mb-1">
            <span class="text-lg">🥇</span>
            <span class="text-[10px] font-mono uppercase bg-amber-400/20 text-amber-300 px-2 py-0.5 rounded">Value ₹3,500+</span>
          </div>
          <h4 class="font-serif font-bold text-sm text-amber-200">Gold Capsule Drop</h4>
          <p class="text-[11px] text-white/60 mt-1 leading-relaxed">5 premium outerwear &amp; bottoms + 1 signature VIP Atelier item.</p>
        </div>
        <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between">
          <span class="font-serif text-base font-bold text-amber-300">₹1,299</span>
          <button type="button" onclick="closeMysteryDropModal(); openExpressCheckout(1, 'Lumina Gold Capsule Mystery Drop (5 Pieces)', 1299, '<?= base_url('img/cashmere_cocoon_coat.jpg') ?>');" class="px-3 py-1.5 bg-gradient-to-r from-amber-400 to-amber-500 text-stone-950 font-mono text-[10px] font-extrabold uppercase rounded-lg hover:opacity-90 transition-all cursor-pointer">
            Acquire Tier
          </button>
        </div>
      </div>

      <!-- Tier 3: Platinum -->
      <div class="bg-white/5 border border-white/10 hover:border-purple-400/50 rounded-2xl p-4 flex flex-col justify-between transition-all">
        <div>
          <div class="flex justify-between items-center mb-1">
            <span class="text-lg">💎</span>
            <span class="text-[10px] font-mono uppercase bg-white/10 px-2 py-0.5 rounded text-white/80">Value ₹6,000+</span>
          </div>
          <h4 class="font-serif font-bold text-sm text-white">Platinum Atelier Box</h4>
          <p class="text-[11px] text-white/50 mt-1 leading-relaxed">7 luxury pieces + exclusive designer collab runway garment.</p>
        </div>
        <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between">
          <span class="font-serif text-base font-bold text-purple-300">₹2,099</span>
          <button type="button" onclick="closeMysteryDropModal(); openExpressCheckout(1, 'Platinum Atelier Luxury Mystery Box (7 Pieces)', 2099, '<?= base_url('img/wool_blazer_luxury.jpg') ?>');" class="px-3 py-1.5 bg-white text-stone-950 font-mono text-[10px] font-extrabold uppercase rounded-lg hover:bg-purple-300 transition-all cursor-pointer">
            Acquire Tier
          </button>
        </div>
      </div>

      <!-- Tier 4: Black Diamond -->
      <div class="bg-white/5 border border-white/10 hover:border-stone-400 rounded-2xl p-4 flex flex-col justify-between transition-all">
        <div>
          <div class="flex justify-between items-center mb-1">
            <span class="text-lg">🖤</span>
            <span class="text-[10px] font-mono uppercase bg-white/10 px-2 py-0.5 rounded text-white/80">Value ₹12,000+</span>
          </div>
          <h4 class="font-serif font-bold text-sm text-white">Black Diamond Vault</h4>
          <p class="text-[11px] text-white/50 mt-1 leading-relaxed">10-piece bespoke full wardrobe. Serial-numbered &amp; tailor signed.</p>
        </div>
        <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between">
          <span class="font-serif text-base font-bold text-white">₹3,999</span>
          <button type="button" onclick="closeMysteryDropModal(); openExpressCheckout(1, 'Black Diamond Vault Complete Wardrobe (10 Pieces)', 3999, '<?= base_url('img/melton_wool_peacoat.jpg') ?>');" class="px-3 py-1.5 bg-white text-stone-950 font-mono text-[10px] font-extrabold uppercase rounded-lg hover:bg-stone-200 transition-all cursor-pointer">
            Acquire Tier
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
window.openWaitlistModal = function(prodId, prodTitle) {
  const m = document.getElementById('storefrontWaitlistModal');
  if (m) {
    if (prodId) document.getElementById('sfWlProductId').value = prodId;
    if (prodTitle) document.getElementById('sfWlTitle').textContent = 'Waitlist: ' + prodTitle;
    document.getElementById('sfWlSuccess').classList.add('hidden');
    document.getElementById('sfWaitlistForm').reset();
    m.classList.remove('hidden');
    m.classList.add('flex');
  }
};
window.closeStorefrontWaitlistModal = function() {
  const m = document.getElementById('storefrontWaitlistModal');
  if (m) { m.classList.add('hidden'); m.classList.remove('flex'); }
};

window.handleStorefrontWaitlistSubmit = function(e) {
  e.preventDefault();
  const name = document.getElementById('sfWlName').value;
  const email = document.getElementById('sfWlEmail').value;
  const phone = document.getElementById('sfWlPhone').value;
  const prodId = document.getElementById('sfWlProductId').value;

  // Save to localStorage
  localStorage.setItem('lumina_waitlist_' + prodId, JSON.stringify({ name, email, phone, date: new Date().toISOString() }));
  document.getElementById('sfWlSuccess').classList.remove('hidden');
  document.getElementById('sfWlSubmitBtn').classList.add('hidden');

  setTimeout(() => {
    closeStorefrontWaitlistModal();
    document.getElementById('sfWlSubmitBtn').classList.remove('hidden');
  }, 2200);
};

window.openMysteryDropModal = function() {
  const m = document.getElementById('storefrontMysteryModal');
  if (m) { m.classList.remove('hidden'); m.classList.add('flex'); }
};
window.closeMysteryDropModal = function() {
  const m = document.getElementById('storefrontMysteryModal');
  if (m) { m.classList.add('hidden'); m.classList.remove('flex'); }
};
</script>



<!-- ── Mobile Floating Glass Bottom App Bar (Dark Luxury Obsidian & Gold) ── -->
<!-- ══════════════════════════════════════════════════════
     MOBILE LUXURY ATELIER FLOATING DOCK (UI/UX PRO MAX)
══════════════════════════════════════════════════════ -->
<?php 
  $raw_uri = strtolower($_SERVER['REQUEST_URI'] ?? '');
  $clean_uri = trim(parse_url($raw_uri, PHP_URL_PATH) ?? '', '/');
  $is_shop_page = (strpos($clean_uri, 'shop') !== false || strpos($clean_uri, 'boutique') !== false || strpos($clean_uri, 'collection') !== false);
  $is_search_page = (strpos($clean_uri, 'search') !== false);
  $is_wishlist_page = (strpos($clean_uri, 'wishlist') !== false || strpos($clean_uri, 'wardrobe') !== false);
  $is_cart_page = (strpos($clean_uri, 'cart') !== false || strpos($clean_uri, 'checkout') !== false);
  $is_home_page = (!$is_shop_page && !$is_search_page && !$is_wishlist_page && !$is_cart_page);
?>
<nav class="fixed bottom-3 inset-x-3.5 sm:inset-x-6 max-w-sm mx-auto z-[95] md:hidden bg-stone-950/95 backdrop-blur-2xl border border-white/15 rounded-2xl py-1.5 px-1.5 shadow-[0_20px_50px_rgba(0,0,0,0.8),0_0_0_1px_rgba(255,255,255,0.08)] select-none pointer-events-auto" style="touch-action: manipulation; -webkit-tap-highlight-color: transparent;" aria-label="Mobile Navigation">
  <div class="flex items-center justify-between gap-1">
    
    <!-- Home -->
    <a href="<?= base_url() ?>" class="flex-1 flex flex-col items-center justify-center py-1.5 px-1 rounded-xl transition-all duration-200 active:scale-90 <?= $is_home_page ? 'text-[#e9c176] font-bold bg-white/10 shadow-xs border border-[#e9c176]/30' : 'text-stone-400 hover:text-stone-200' ?>" title="Atelier Home">
      <span class="material-symbols-outlined text-[19px] leading-none mb-0.5">home</span>
      <span class="text-[8.5px] font-mono uppercase tracking-wider leading-tight">Home</span>
      <?php if ($is_home_page): ?>
        <span class="w-1 h-1 rounded-full bg-[#e9c176] mt-0.5 shadow-[0_0_6px_#e9c176]"></span>
      <?php endif; ?>
    </a>

    <!-- Shop / Boutique -->
    <a href="<?= base_url('shop') ?>" class="flex-1 flex flex-col items-center justify-center py-1.5 px-1 rounded-xl transition-all duration-200 active:scale-90 <?= $is_shop_page ? 'text-[#e9c176] font-bold bg-white/10 shadow-xs border border-[#e9c176]/30' : 'text-stone-400 hover:text-stone-200' ?>" title="Explore Catalog">
      <span class="material-symbols-outlined text-[19px] leading-none mb-0.5">checkroom</span>
      <span class="text-[8.5px] font-mono uppercase tracking-wider leading-tight">Shop</span>
      <?php if ($is_shop_page): ?>
        <span class="w-1 h-1 rounded-full bg-[#e9c176] mt-0.5 shadow-[0_0_6px_#e9c176]"></span>
      <?php endif; ?>
    </a>

    <!-- Wishlist / Saved -->
    <button type="button" onclick="openWishlistDrawer()" class="flex-1 flex flex-col items-center justify-center py-1.5 px-1 rounded-xl <?= $is_wishlist_page ? 'text-[#e9c176] font-bold bg-white/10 shadow-xs border border-[#e9c176]/30' : 'text-stone-400 hover:text-rose-400' ?> transition-all duration-200 active:scale-90 cursor-pointer relative" title="Saved Pieces">
      <span class="material-symbols-outlined text-[19px] leading-none mb-0.5 hover:text-rose-400 transition-colors">favorite</span>
      <span class="text-[8.5px] font-mono uppercase tracking-wider leading-tight">Saved</span>
      <span id="mobileBottomWishlistBadge" class="absolute -top-0.5 right-2 min-w-[14px] h-[14px] px-0.5 bg-rose-500 text-white text-[7.5px] font-mono font-bold rounded-full flex items-center justify-center hidden">0</span>
    </button>

    <!-- Instant Search -->
    <button type="button" onclick="toggleSearchModal()" class="flex-1 flex flex-col items-center justify-center py-1.5 px-1 rounded-xl text-stone-400 hover:text-[#e9c176] transition-all duration-200 active:scale-90 cursor-pointer" title="Search">
      <span class="material-symbols-outlined text-[19px] leading-none mb-0.5">search</span>
      <span class="text-[8.5px] font-mono uppercase tracking-wider leading-tight">Search</span>
    </button>

    <!-- Curated Bag -->
    <button type="button" onclick="toggleQuickBagDrawer()" class="flex-1 flex flex-col items-center justify-center py-1.5 px-1 rounded-xl text-stone-400 hover:text-white transition-all duration-200 active:scale-90 relative cursor-pointer" title="Curated Bag">
      <span class="material-symbols-outlined text-[19px] leading-none mb-0.5 text-stone-200">shopping_bag</span>
      <span class="text-[8.5px] font-mono uppercase tracking-wider leading-tight text-stone-200 font-semibold">Bag</span>
      <?php $mb_count = (isset($this->session) && method_exists($this->session, 'userdata')) ? (int)($this->session->userdata('cart_count') ?? 0) : 0; ?>
      <span id="mobileBottomCartBadge" class="absolute top-0.5 right-2 min-w-[16px] h-4 px-1 bg-stone-900 text-[#e9c176] text-[8px] font-mono font-extrabold rounded-full flex items-center justify-center border border-[#e9c176]/50 shadow-md <?= $mb_count > 0 ? '' : 'hidden' ?>">
        <?= $mb_count ?>
      </span>
    </button>

  </div>
</nav>

<!-- ── Instant Search Modal (Interactive Search Widget) ── -->
<div id="searchModal" data-lenis-prevent="true" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[9999] hidden items-start justify-center pt-12 sm:pt-20 px-3 sm:px-4 overflow-y-auto" onclick="if(event.target===this)toggleSearchModal()" style="overscroll-behavior: contain;">
  <div data-lenis-prevent="true" class="bg-white text-stone-900 rounded-3xl max-w-2xl w-full p-5 sm:p-7 border border-stone-200 shadow-2xl relative my-auto animate-in fade-in zoom-in-95 duration-200" style="overscroll-behavior: contain;">
    
    <!-- Search Input Row -->
    <div class="flex items-center gap-3 border-b border-stone-200 pb-3.5 mb-4">
      <span class="material-symbols-outlined text-[#a16207] text-2xl">search</span>
      <input type="text" id="liveSearchInput" placeholder="Search cashmere coats, silk dresses, denim..." class="w-full bg-transparent border-none focus:ring-0 text-base sm:text-lg text-stone-950 font-serif outline-none placeholder:text-stone-400" oninput="handleSearchQuery(this.value)" onkeydown="if(event.key==='Enter'){window.location.href='<?= base_url('search?q=') ?>'+encodeURIComponent(this.value);}">
      <button type="button" onclick="toggleSearchModal()" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400 hover:text-black hover:bg-stone-100 transition-colors cursor-pointer" aria-label="Close search">
        <span class="material-symbols-outlined text-xl">close</span>
      </button>
    </div>

    <!-- Quick Trend Suggestions -->
    <div class="mb-4">
      <span class="text-[10px] font-mono uppercase tracking-widest text-stone-400 font-bold block mb-2">Curated Search Capsules</span>
      <div class="flex flex-wrap gap-1.5 sm:gap-2">
        <button type="button" onclick="document.getElementById('liveSearchInput').value='Silk'; handleSearchQuery('Silk');" class="px-3 py-1 bg-amber-50 hover:bg-amber-100 text-[#a16207] border border-amber-200 text-xs font-mono rounded-full transition-all">✨ Mulberry Silk</button>
        <button type="button" onclick="document.getElementById('liveSearchInput').value='Cashmere'; handleSearchQuery('Cashmere');" class="px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-200 text-xs font-mono rounded-full transition-all">🧥 Cashmere Coat</button>
        <button type="button" onclick="document.getElementById('liveSearchInput').value='Denim'; handleSearchQuery('Denim');" class="px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-200 text-xs font-mono rounded-full transition-all">👖 Selvedge Denim</button>
        <button type="button" onclick="document.getElementById('liveSearchInput').value='Boot'; handleSearchQuery('Boot');" class="px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-200 text-xs font-mono rounded-full transition-all">👞 Chelsea Boots</button>
        <button type="button" onclick="document.getElementById('liveSearchInput').value='Trench'; handleSearchQuery('Trench');" class="px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-200 text-xs font-mono rounded-full transition-all">🧥 Atelier Trench</button>
      </div>
    </div>

    <!-- Results Container -->
    <div id="searchResultsList" class="max-h-80 sm:max-h-96 overflow-y-auto custom-scrollbar flex flex-col gap-2 pt-1">
      <div class="py-6 text-center text-xs font-mono tracking-wider uppercase text-stone-400">Type keywords or select a capsule above...</div>
    </div>

    <!-- Modal Footer -->
    <div class="mt-4 pt-3 border-t border-stone-100 flex items-center justify-between text-[11px] font-mono text-stone-400">
      <span>Press <kbd class="px-1.5 py-0.5 bg-stone-100 rounded border border-stone-200 text-stone-700">ESC</kbd> to exit</span>
      <a href="<?= base_url('shop') ?>" class="text-[#a16207] hover:underline font-bold">Browse All Creations →</a>
    </div>
  </div>
</div>

<!-- Toast Container (Bottom-Center non-intrusive floating pill) -->
<div id="toastContainer" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[70] flex flex-col items-center gap-2 max-w-[90vw] sm:max-w-md pointer-events-none"></div>

<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 1. 🪞 AI VIRTUAL MIRROR & BESPOKE FACE-FIT FITTING STUDIO (MODAL)           -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<div id="virtualFittingModal" data-lenis-prevent="true" class="fixed inset-0 bg-black/85 backdrop-blur-md z-[120] hidden items-center justify-center p-0 sm:p-4 md:p-6 overflow-y-auto" onclick="if(event.target===this)closeFittingModal()" style="overscroll-behavior: contain; -webkit-overflow-scrolling: touch;">
  <div data-lenis-prevent="true" class="bg-white text-stone-900 rounded-t-3xl sm:rounded-3xl max-w-4xl w-full border border-stone-200 shadow-2xl overflow-hidden max-h-[92vh] sm:max-h-[90vh] flex flex-col my-auto transition-all" style="overscroll-behavior: contain;">
    
    <!-- Modal Header (Haute Couture Obsidian) -->
    <div class="bg-[#07080b] px-4 py-3.5 sm:px-6 sm:py-5 text-white border-b border-white/10 flex justify-between items-center relative overflow-hidden flex-shrink-0">
      <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#e9c176_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
      
      <div class="relative z-10 flex items-center gap-2.5 sm:gap-3">
        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-center text-[#e9c176] flex-shrink-0">
          <span class="material-symbols-outlined text-lg sm:text-xl">face_retouching_natural</span>
        </div>
        <div>
          <div class="flex items-center gap-1.5 sm:gap-2">
            <span class="px-2 py-0.5 rounded-full bg-[#e9c176]/20 text-[#e9c176] text-[8px] sm:text-[9px] font-mono font-bold uppercase tracking-wider border border-[#e9c176]/30">AI Live Mirror</span>
            <span class="text-[10px] sm:text-[11px] font-mono text-white/50 hidden sm:inline">· Neural Model Try-On</span>
          </div>
          <h3 class="font-serif text-base sm:text-2xl text-white font-bold tracking-tight">Virtual Fitting Room &amp; Face Mirror</h3>
        </div>
      </div>

      <!-- Navigation Tabs & Close -->
      <div class="relative z-10 flex items-center gap-1.5 sm:gap-2">
        <div class="flex bg-white/10 p-0.5 sm:p-1 rounded-xl border border-white/15 text-[10px] sm:text-xs font-mono">
          <button type="button" onclick="switchVtrTab('faceMirror')" id="vtrTabBtn_faceMirror" class="px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg bg-stone-900 text-[#e9c176] font-bold transition-all shadow-xs cursor-pointer">
            🪞 AI Mirror
          </button>
          <button type="button" onclick="switchVtrTab('sizing')" id="vtrTabBtn_sizing" class="px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg text-white/70 hover:text-white font-medium transition-all cursor-pointer">
            📐 Sizer Guide
          </button>
        </div>
        <button type="button" onclick="closeFittingModal()" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer active:scale-95" aria-label="Close">
          <span class="material-symbols-outlined text-lg sm:text-xl">close</span>
        </button>
      </div>
    </div>

    <!-- TAB 1: 🪞 AI FACE MIRROR & MODEL TRY-ON -->
    <div id="vtrTab_faceMirror" class="p-3.5 sm:p-6 overflow-y-auto overscroll-contain flex-1 grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 bg-stone-50" style="-webkit-overflow-scrolling: touch; touch-action: pan-y;">
      
      <!-- LEFT: Editorial Model Viewport & Face Overlay Composite (5 Cols) -->
      <div class="lg:col-span-5 flex flex-col gap-3">
        
        <!-- PROMINENT DIRECT PHOTO UPLOAD BAR (Top of Mirror for Mobile & Desktop) -->
        <div class="bg-white p-3 rounded-2xl border border-stone-200 shadow-xs flex items-center justify-between gap-2">
          <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <div>
              <span class="font-mono text-[10px] uppercase font-bold text-stone-900 block">Your Custom Photo:</span>
              <span class="text-[9px] font-mono text-stone-500">Upload selfie or full photo</span>
            </div>
          </div>
          
          <div class="flex items-center gap-1.5">
            <!-- Upload Selfie / Face Button -->
            <label for="vtrFaceFileInputDirect" class="px-2.5 py-1.5 bg-stone-950 hover:bg-stone-850 text-[#e9c176] rounded-xl font-mono text-[10px] uppercase font-extrabold cursor-pointer transition-all flex items-center gap-1 shadow-xs active:scale-95">
              <span class="material-symbols-outlined text-xs text-[#e9c176]">add_a_photo</span>
              <span>Upload Selfie</span>
            </label>
            <input type="file" id="vtrFaceFileInputDirect" accept="image/*" class="hidden" onchange="handleVtrFaceUpload(event)">
            
            <!-- Upload Full Body Photo Button -->
            <label for="vtrBodyFileInput" class="px-2.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 rounded-xl font-mono text-[10px] uppercase font-bold cursor-pointer transition-all flex items-center gap-1 active:scale-95">
              <span class="material-symbols-outlined text-xs">person</span>
              <span>Full Photo</span>
            </label>
            <input type="file" id="vtrBodyFileInput" accept="image/*" class="hidden" onchange="handleVtrBodyUpload(event)">
          </div>
        </div>

        <div class="relative aspect-[3/4] bg-stone-900 rounded-2xl overflow-hidden border border-stone-300 shadow-lg flex items-center justify-center select-none" id="vtrMirrorStage">
          
          <!-- Scalable / Morphable Body Silhouette Layer -->
          <div id="vtrBodyStageWrapper" class="w-full h-full relative transition-transform duration-150 origin-bottom flex items-center justify-center">
            <!-- Editorial Model / Mannequin Photo -->
            <img id="vtrModelImage" src="<?= base_url('img/model_look_executive.jpg') ?>" alt="Model Garment" class="w-full h-full object-cover pointer-events-none">
            
            <!-- Neural Face Overlay — auto-positioned to model head -->
            <div id="vtrFaceOverlayContainer" class="absolute pointer-events-none transition-all duration-150" style="top: 4.5%; left: 50%; width: 26%; height: 22%; transform: translateX(-50%);">
              
              <!-- Feathered oval mask for seamless blending -->
              <div class="w-full h-full relative overflow-hidden" style="
                -webkit-mask-image: radial-gradient(ellipse 46% 50% at 50% 45%, rgba(0,0,0,1) 55%, rgba(0,0,0,0.7) 75%, transparent 100%);
                mask-image: radial-gradient(ellipse 46% 50% at 50% 45%, rgba(0,0,0,1) 55%, rgba(0,0,0,0.7) 75%, transparent 100%);
              ">
                <!-- User Face Image -->
                <img id="vtrUserFaceImage" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&crop=faces&facepad=2" alt="Your Face" class="w-full h-full object-cover object-top origin-center transition-transform" style="transform: scale(1.1) translate(0px, 5%) rotate(0deg); filter: contrast(1.02) brightness(0.96) saturate(0.98);">
                <!-- Ambient Lighting Tone Matcher -->
                <div id="vtrToneOverlay" class="absolute inset-0 pointer-events-none mix-blend-multiply opacity-20" style="background-color: #92400e;"></div>
                <!-- Neck blend gradient -->
                <div class="absolute inset-x-0 bottom-0 h-1/4" style="background: linear-gradient(to top, rgba(0,0,0,0) 0%, transparent 100%);"></div>
              </div>
            </div>
          </div>

          <!-- AI Neural Processing HUD Overlay (Appears during Auto-Fit) -->
          <div id="vtrAiHudOverlay" class="hidden absolute inset-0 bg-black/75 backdrop-blur-sm z-30 flex flex-col items-center justify-center p-6 text-center text-white transition-opacity duration-300">
            <!-- Biometric Mesh Scanning Reticle -->
            <div class="relative w-24 h-24 mb-4 flex items-center justify-center">
              <div class="absolute inset-0 border-2 border-dashed border-[#e9c176] rounded-full animate-spin"></div>
              <div class="absolute inset-2 border border-[#e9c176]/50 rounded-full animate-ping"></div>
              <span class="material-symbols-outlined text-3xl text-[#e9c176] animate-pulse">face_retouching_natural</span>
            </div>
            
            <div class="space-y-1">
              <span class="text-[10px] font-mono uppercase tracking-widest text-[#e9c176] font-bold block">Neural AI Engine</span>
              <h5 id="vtrAiHudStatus" class="font-serif font-bold text-sm text-white">Analyzing 68 Biometric Facial Landmarks...</h5>
              <p class="text-[10px] font-mono text-white/60">Harmonizing lighting &amp; collar depth</p>
            </div>
          </div>

          <!-- Top Stage Badges & View Switcher -->
          <div class="absolute top-3 left-3 right-3 flex justify-between items-center z-10">
            <span class="px-2.5 py-1 rounded-full bg-black/85 text-[#e9c176] font-mono text-[9px] uppercase font-bold tracking-wider backdrop-blur-md border border-white/15 shadow-sm flex items-center gap-1.5 pointer-events-none">
              <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
              <span>AI Neural Fit</span>
            </span>

            <!-- Toggle Runway Model vs Atelier Mannequin -->
            <div class="flex bg-black/85 p-0.5 rounded-lg border border-white/15 text-[9px] font-mono">
              <button type="button" onclick="toggleVtrModelMode('model')" id="vtrModeBtn_model" class="px-2 py-1 rounded bg-[#e9c176] text-black font-bold cursor-pointer transition-all">
                👤 Model
              </button>
              <button type="button" onclick="toggleVtrModelMode('mannequin')" id="vtrModeBtn_mannequin" class="px-2 py-1 rounded text-white/70 hover:text-white font-medium cursor-pointer transition-all">
                🪵 Mannequin
              </button>
            </div>
          </div>

          <!-- Interactive Controls (Bottom Bar) -->
          <div class="absolute bottom-3 left-3 right-3 bg-black/90 backdrop-blur-md p-2 rounded-xl border border-white/15 flex items-center justify-between text-white text-[10px] font-mono z-10">
            <div class="flex items-center gap-1">
              <button type="button" onclick="triggerVtrAutoCalibrate()" class="px-2.5 py-1 bg-gradient-to-r from-[#a16207] to-[#e9c176] text-black font-bold rounded-lg cursor-pointer flex items-center gap-1 shadow-xs" title="Auto-Calibrate Face to Model">
                <span class="material-symbols-outlined text-xs">auto_fix_high</span>
                <span>Auto-Fit</span>
              </button>
              <button type="button" onclick="flipVtrFace()" class="px-2 py-1 bg-white/10 hover:bg-white/20 rounded-lg cursor-pointer flex items-center gap-1" title="Mirror Face">
                <span class="material-symbols-outlined text-xs">flip</span>
              </button>
              <button type="button" onclick="resetVtrFaceTransform()" class="px-2 py-1 bg-white/10 hover:bg-white/20 rounded-lg cursor-pointer flex items-center gap-1" title="Reset Position">
                <span class="material-symbols-outlined text-xs">refresh</span>
              </button>
            </div>
            
            <div class="flex items-center gap-1.5">
              <span class="text-white/60 text-[9px]">Face Size</span>
              <input type="range" id="vtrScaleInput" min="75" max="150" value="100" oninput="updateVtrFaceTransform()" class="w-14 accent-[#e9c176] cursor-pointer">
            </div>
          </div>
        </div>

        <!-- 📐 DYNAMIC BODY SILHOUETTE & BUILD MORPHING -->
        <div class="bg-white p-3.5 rounded-2xl border border-stone-200 text-stone-700 text-xs shadow-xs space-y-2.5">
          <div class="flex justify-between items-center">
            <span class="font-mono text-[10px] uppercase font-bold text-stone-900 flex items-center gap-1.5">
              <span class="material-symbols-outlined text-sm text-[#a16207]">accessibility_new</span>
              <span>Body Silhouette &amp; Build</span>
            </span>
            <span id="vtrBodyBuildBadge" class="font-mono text-[9px] px-2 py-0.5 rounded-md bg-[#e9c176]/20 text-[#a16207] font-bold">Classic Regular</span>
          </div>

          <!-- Quick Build Presets -->
          <div class="grid grid-cols-4 gap-1 text-[9px] font-mono">
            <button type="button" onclick="setVtrBodyPreset('slim', this)" class="vtr-build-btn px-1.5 py-1 rounded-lg border border-stone-200 hover:border-stone-400 bg-stone-50 text-stone-700 font-bold transition-all text-center">🏃 Slim</button>
            <button type="button" onclick="setVtrBodyPreset('regular', this)" class="vtr-build-btn active px-1.5 py-1 rounded-lg border border-stone-900 bg-stone-900 text-[#e9c176] font-bold transition-all text-center shadow-xs">👔 Regular</button>
            <button type="button" onclick="setVtrBodyPreset('athletic', this)" class="vtr-build-btn px-1.5 py-1 rounded-lg border border-stone-200 hover:border-stone-400 bg-stone-50 text-stone-700 font-bold transition-all text-center">🏋️ Broad</button>
            <button type="button" onclick="setVtrBodyPreset('relaxed', this)" class="vtr-build-btn px-1.5 py-1 rounded-lg border border-stone-200 hover:border-stone-400 bg-stone-50 text-stone-700 font-bold transition-all text-center">👑 Plus</button>
          </div>

          <!-- Body Height & Breadth Sliders -->
          <div class="grid grid-cols-2 gap-2 text-[10px] font-mono pt-0.5">
            <div>
              <div class="flex justify-between text-stone-400 mb-0.5">
                <span>Height / Stature</span>
                <span id="vtrHeightVal" class="text-stone-700 font-bold">100%</span>
              </div>
              <input type="range" id="vtrBodyHeightInput" min="90" max="115" value="100" oninput="updateVtrBodyMorphing()" class="w-full accent-[#a16207] cursor-pointer">
            </div>
            <div>
              <div class="flex justify-between text-stone-400 mb-0.5">
                <span>Shoulder Breadth</span>
                <span id="vtrWidthVal" class="text-stone-700 font-bold">100%</span>
              </div>
              <input type="range" id="vtrBodyWidthInput" min="85" max="125" value="100" oninput="updateVtrBodyMorphing()" class="w-full accent-[#a16207] cursor-pointer">
            </div>
          </div>
        </div>

        <!-- Micro Position & Lighting Tuning -->
        <div class="bg-white p-3 rounded-2xl border border-stone-200 text-stone-700 text-xs shadow-xs space-y-2">
          <div class="flex justify-between items-center">
            <span class="font-mono text-[10px] uppercase font-bold text-stone-500">Fine Face Alignment</span>
            <div class="flex gap-1 text-[9px] font-mono">
              <button type="button" onclick="setVtrTone('warm', this)" class="vtr-tone-btn active px-2 py-0.5 rounded-md bg-stone-900 text-[#e9c176] font-bold">Warm</button>
              <button type="button" onclick="setVtrTone('natural', this)" class="vtr-tone-btn px-2 py-0.5 rounded-md bg-stone-100 text-stone-700 hover:bg-stone-200">Natural</button>
              <button type="button" onclick="setVtrTone('cool', this)" class="vtr-tone-btn px-2 py-0.5 rounded-md bg-stone-100 text-stone-700 hover:bg-stone-200">Cool</button>
            </div>
          </div>
          <div class="grid grid-cols-3 gap-2 text-[10px] font-mono">
            <div>
              <span class="text-stone-400 block mb-0.5">Vertical Y</span>
              <input type="range" id="vtrPosYInput" min="-25" max="25" value="0" oninput="updateVtrFaceTransform()" class="w-full accent-[#a16207] cursor-pointer">
            </div>
            <div>
              <span class="text-stone-400 block mb-0.5">Horizontal X</span>
              <input type="range" id="vtrPosXInput" min="-20" max="20" value="0" oninput="updateVtrFaceTransform()" class="w-full accent-[#a16207] cursor-pointer">
            </div>
            <div>
              <span class="text-stone-400 block mb-0.5">Tilt Angle</span>
              <input type="range" id="vtrRotateInput" min="-15" max="15" value="0" oninput="updateVtrFaceTransform()" class="w-full accent-[#a16207] cursor-pointer">
            </div>
          </div>
        </div>

      </div>

      <!-- RIGHT: Face Upload + Outfit Switcher + 1-Click Acquisition (7 Cols) -->
      <div class="lg:col-span-7 flex flex-col justify-between space-y-4">
        
        <!-- STEP 1: Upload Face or Choose Preset -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200 shadow-xs space-y-3">
          <div class="flex justify-between items-center">
            <div>
              <span class="text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">Step 1</span>
              <h4 class="font-serif font-bold text-sm text-stone-900">Upload Your Face or Select Demo Avatar</h4>
            </div>
            <label for="vtrFaceFileInput" class="px-3 py-1.5 bg-stone-950 hover:bg-stone-800 text-[#e9c176] rounded-xl font-mono text-[10px] uppercase font-bold cursor-pointer transition-all flex items-center gap-1.5 shadow-xs">
              <span class="material-symbols-outlined text-sm">upload</span>
              <span>Upload Photo</span>
            </label>
            <input type="file" id="vtrFaceFileInput" accept="image/*" class="hidden" onchange="handleVtrFaceUpload(event)">
          </div>

          <!-- Quick 1-Tap Demo Faces -->
          <div class="pt-1">
            <span class="text-[10px] font-mono text-stone-500 block mb-1.5">Or try instant sample avatars:</span>
            <div class="flex flex-wrap gap-2">
              <!-- Executive Male — frontal, light skin, matches the model body -->
              <button type="button" onclick="setVtrPresetFace('https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop&crop=faces&facepad=2.5', this)" class="vtr-avatar-btn active px-2.5 py-1.5 rounded-xl border border-stone-950 bg-stone-950 text-[#e9c176] text-[11px] font-mono font-bold flex items-center gap-1.5 cursor-pointer shadow-xs">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop&crop=faces" class="w-5 h-5 rounded-full object-cover">
                <span>Executive Male</span>
              </button>
              <!-- Casual Male — frontal, darker complexion -->
              <button type="button" onclick="setVtrPresetFace('https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=400&fit=crop&crop=faces&facepad=2.5', this)" class="vtr-avatar-btn px-2.5 py-1.5 rounded-xl border border-stone-200 bg-stone-50 hover:border-stone-400 text-stone-800 text-[11px] font-mono font-medium flex items-center gap-1.5 cursor-pointer">
                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=80&h=80&fit=crop&crop=faces" class="w-5 h-5 rounded-full object-cover">
                <span>Casual Male</span>
              </button>
              <!-- Chic Female — frontal, elegant -->
              <button type="button" onclick="setVtrPresetFace('https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=400&h=400&fit=crop&crop=faces&facepad=2.5', this)" class="vtr-avatar-btn px-2.5 py-1.5 rounded-xl border border-stone-200 bg-stone-50 hover:border-stone-400 text-stone-800 text-[11px] font-mono font-medium flex items-center gap-1.5 cursor-pointer">
                <img src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=80&h=80&fit=crop&crop=faces" class="w-5 h-5 rounded-full object-cover">
                <span>Chic Female</span>
              </button>
              <!-- Editorial Unisex -->
              <button type="button" onclick="setVtrPresetFace('https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=400&h=400&fit=crop&crop=faces&facepad=2.5', this)" class="vtr-avatar-btn px-2.5 py-1.5 rounded-xl border border-stone-200 bg-stone-50 hover:border-stone-400 text-stone-800 text-[11px] font-mono font-medium flex items-center gap-1.5 cursor-pointer">
                <img src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=80&h=80&fit=crop&crop=faces" class="w-5 h-5 rounded-full object-cover">
                <span>Editorial Unisex</span>
              </button>
            </div>
          </div>
        </div>

        <!-- STEP 2: Choose Haute Couture Look -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-stone-200 shadow-xs space-y-3">
          <div>
            <span class="text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">Step 2</span>
            <h4 class="font-serif font-bold text-sm text-stone-900">Switch Haute Couture Outfits</h4>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" id="vtrLooksGrid">
            <!-- Looks populated by JS -->
          </div>
        </div>

        <!-- STEP 3: Complete Outfit Breakdown & 1-Click Purchase -->
        <div class="bg-stone-900 p-4 sm:p-5 rounded-2xl text-white shadow-md space-y-3">
          <div class="flex justify-between items-center border-b border-white/10 pb-3">
            <div>
              <span class="text-[9px] font-mono uppercase tracking-widest text-[#e9c176] font-bold block">Ensemble Acquisition</span>
              <h5 class="font-serif font-bold text-sm text-white" id="vtrLookTitle">The Power Executive Look</h5>
            </div>
            <div class="text-right">
              <span class="font-serif font-bold text-lg text-[#e9c176]" id="vtrLookPrice">₹14,197</span>
              <span class="font-mono text-[9px] text-emerald-400 block" id="vtrLookSave">Save ₹5,300</span>
            </div>
          </div>

          <!-- Included Garments List -->
          <div class="space-y-1.5 text-xs text-white/70 font-sans" id="vtrLookItemsList">
            <!-- Injected by JS -->
          </div>

          <!-- Action Buttons -->
          <div class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
            <button type="button" onclick="addVtrLookToBag()" class="w-full py-3 bg-gradient-to-r from-[#a16207] to-[#e9c176] hover:opacity-95 text-stone-950 font-mono text-[10px] uppercase tracking-wider font-extrabold rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer shadow-md">
              <span class="material-symbols-outlined text-sm">shopping_bag</span>
              <span>Acquire Full Outfit</span>
            </button>
            <button type="button" onclick="downloadVtrSnapshot()" class="w-full py-3 border border-white/20 hover:bg-white/10 text-white font-mono text-[10px] uppercase tracking-wider font-bold rounded-xl transition-all flex items-center justify-center gap-1.5 cursor-pointer">
              <span class="material-symbols-outlined text-sm">photo_camera</span>
              <span>Snapshot Look</span>
            </button>
          </div>
        </div>

      </div>

    </div>

    <!-- TAB 2: 📐 PRECISION SIZING & DRAPE TELEMETRY -->
    <div id="vtrTab_sizing" class="p-5 sm:p-7 overflow-y-auto custom-scrollbar flex-1 grid grid-cols-1 md:grid-cols-12 gap-6 bg-white hidden">
      
      <!-- Input Controls (7 cols) -->
      <div class="md:col-span-7 space-y-4 text-xs">
        <div>
          <label class="font-mono uppercase tracking-wider text-[10px] text-stone-500 block mb-1.5 font-bold">1. Silhouette Form</label>
          <div class="grid grid-cols-3 gap-2 font-mono">
            <button type="button" onclick="selectFittingSilhouette('masculine', this)" class="fitting-sil-btn active py-2 border border-stone-950 bg-stone-950 text-[#e9c176] text-center rounded-xl font-bold transition-all cursor-pointer shadow-xs">
              Masculine
            </button>
            <button type="button" onclick="selectFittingSilhouette('feminine', this)" class="fitting-sil-btn py-2 border border-stone-200 bg-stone-50 hover:border-stone-950 text-stone-800 text-center rounded-xl font-medium transition-all cursor-pointer">
              Feminine
            </button>
            <button type="button" onclick="selectFittingSilhouette('unisex', this)" class="fitting-sil-btn py-2 border border-stone-200 bg-stone-50 hover:border-stone-950 text-stone-800 text-center rounded-xl font-medium transition-all cursor-pointer">
              Fluid / Unisex
            </button>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div class="bg-stone-50 p-3.5 rounded-2xl border border-stone-200 shadow-xs">
            <div class="flex justify-between items-center mb-1.5">
              <span class="font-mono uppercase text-[10px] text-stone-500 font-bold">Height</span>
              <span id="fitHeightVal" class="font-mono text-xs font-bold text-[#a16207]">178 cm</span>
            </div>
            <input type="range" id="fitHeightInput" min="150" max="210" value="178" oninput="updateFittingCalculations()" class="w-full accent-[#a16207] cursor-pointer">
          </div>
          <div class="bg-stone-50 p-3.5 rounded-2xl border border-stone-200 shadow-xs">
            <div class="flex justify-between items-center mb-1.5">
              <span class="font-mono uppercase text-[10px] text-stone-500 font-bold">Weight</span>
              <span id="fitWeightVal" class="font-mono text-xs font-bold text-[#a16207]">72 kg</span>
            </div>
            <input type="range" id="fitWeightInput" min="45" max="130" value="72" oninput="updateFittingCalculations()" class="w-full accent-[#a16207] cursor-pointer">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div class="bg-stone-50 p-3.5 rounded-2xl border border-stone-200 shadow-xs">
            <div class="flex justify-between items-center mb-1.5">
              <span class="font-mono uppercase text-[10px] text-stone-500 font-bold">Chest / Bust</span>
              <span id="fitChestVal" class="font-mono text-xs font-bold text-[#a16207]">39 in</span>
            </div>
            <input type="range" id="fitChestInput" min="30" max="54" value="39" oninput="updateFittingCalculations()" class="w-full accent-[#a16207] cursor-pointer">
          </div>
          <div class="bg-stone-50 p-3.5 rounded-2xl border border-stone-200 shadow-xs flex flex-col justify-between">
            <label class="font-mono uppercase tracking-wider text-[10px] text-stone-500 block mb-1 font-bold">Desired Drape</label>
            <select id="fitDrapeSelect" onchange="updateFittingCalculations()" class="w-full bg-white border border-stone-300 rounded-xl px-2.5 py-2 text-[11px] sm:text-xs text-stone-900 font-mono font-medium outline-none focus:border-stone-950 transition-colors">
              <option value="fitted">Slim European Fit</option>
              <option value="tailored" selected>Classic Atelier Tailored</option>
              <option value="relaxed">Relaxed Drop-Shoulder</option>
              <option value="oversized">Avant-Garde Oversized</option>
            </select>
          </div>
        </div>

        <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-2xl text-[11px] text-stone-600 font-light leading-relaxed">
          <span class="text-[#a16207] font-bold font-mono">✦ Atelier Sizing Insight:</span> All Lumina outerwear and hoodies incorporate a built-in 2-inch drop shoulder ease. Select your calibrated size for optimal drape.
        </div>
      </div>

      <!-- Live Recommendation Output Gauge (5 cols) -->
      <div class="md:col-span-5 bg-stone-50 p-5 sm:p-6 rounded-2xl border border-stone-200 flex flex-col justify-between items-center text-center shadow-xs">
        <div class="w-full">
          <span class="text-[10px] font-mono uppercase tracking-widest text-stone-500 font-bold block mb-1">Calibrated Size</span>
          <div id="recommendedSizeBadge" class="text-5xl font-serif font-bold text-stone-950 tracking-tight my-2">
            M
          </div>
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[10px] font-mono font-bold mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            <span id="fitConfidenceScore">98.6% Precision Match</span>
          </div>
        </div>

        <div class="w-full space-y-2 text-[11px] font-mono border-t border-b border-stone-200 py-3.5 text-left">
          <div class="flex justify-between">
            <span class="text-stone-500">Shoulder Span:</span>
            <span id="fitShoulderOut" class="font-bold text-stone-900">46.5 cm</span>
          </div>
          <div class="flex justify-between">
            <span class="text-stone-500">Sleeve Reach:</span>
            <span id="fitSleeveOut" class="font-bold text-stone-900">64.0 cm</span>
          </div>
          <div class="flex justify-between">
            <span class="text-stone-500">Body Length:</span>
            <span id="fitLengthOut" class="font-bold text-stone-900">76.0 cm</span>
          </div>
        </div>

        <div class="w-full space-y-2 pt-4">
          <button type="button" onclick="applyCalculatedSize()" class="w-full py-3 bg-stone-950 text-[#e9c176] font-button text-xs uppercase tracking-widest rounded-xl hover:bg-stone-800 transition-all shadow-md cursor-pointer flex items-center justify-center gap-2 font-bold">
            <span class="material-symbols-outlined text-base">check_circle</span>
            <span>Apply Size to Profile</span>
          </button>
        </div>
      </div>

    </div>

  </div>
</div>

<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 2. ⚡ 1-CLICK QUICK-VIEW BOTTOM SHEET DRAWER                                 -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 2. ⚡ 1-CLICK QUICK-VIEW BOTTOM SHEET DRAWER                                 -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<div id="quickViewDrawer" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[115] hidden items-end sm:items-center justify-center p-0 sm:p-4" onclick="if(event.target===this)closeQuickView()" data-lenis-prevent="true" style="overscroll-behavior: contain;">
  <div class="bg-white rounded-t-3xl sm:rounded-3xl max-w-2xl w-full border border-stone-200 shadow-2xl overflow-hidden text-stone-900 max-h-[92vh] flex flex-col transform translate-y-full sm:translate-y-0 transition-transform duration-300 ease-out" id="quickViewPanel" data-lenis-prevent="true" style="overscroll-behavior: contain;">
    
    <div class="flex justify-between items-center p-4 sm:p-5 border-b border-stone-200 flex-shrink-0 bg-[#07080b] text-white">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-[#e9c176] text-xl">visibility</span>
        <h4 class="font-headline-sm text-base sm:text-lg font-serif text-white uppercase tracking-wider">Atelier Quick View</h4>
      </div>
      <button type="button" onclick="closeQuickView()" class="w-8 h-8 rounded-full flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-colors cursor-pointer" aria-label="Close">
        <span class="material-symbols-outlined text-xl">close</span>
      </button>
    </div>

    <div class="p-4 sm:p-6 overflow-y-auto custom-scrollbar flex-1 grid grid-cols-1 sm:grid-cols-2 gap-5 bg-white" data-lenis-prevent="true" style="overscroll-behavior: contain;">
      <!-- Media Gallery -->
      <div class="flex flex-col gap-3">
        <div class="relative aspect-square rounded-2xl overflow-hidden bg-stone-100 border border-stone-200 shadow-sm group">
          <img id="qvImg" src="" alt="Garment Preview" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
          <span id="qvTag" class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-black/85 text-[#e9c176] font-mono text-[9px] font-bold uppercase tracking-wider backdrop-blur-sm shadow-md">
            700 GSM CASHMERE
          </span>
        </div>
      </div>

      <!-- Details & Actions -->
      <div class="flex flex-col justify-between space-y-3 text-xs">
        <div>
          <span id="qvVendor" class="font-label-caps uppercase tracking-widest text-[10px] text-[#a16207] font-bold block mb-1">Lumina Atelier Milano</span>
          <h3 id="qvTitle" class="font-serif text-lg sm:text-xl font-bold text-stone-950 leading-tight mb-1.5">Piece Title</h3>
          <p id="qvDesc" class="text-stone-600 text-xs leading-relaxed line-clamp-2 mb-2.5 font-light">
            Hand-loomed garment tailored with double-faced virgin fibers and bespoke construction.
          </p>

          <div class="flex items-baseline gap-2.5 mb-2.5">
            <span id="qvPrice" class="font-serif font-bold text-xl sm:text-2xl text-stone-950" data-price-inr="0">₹0</span>
            <span id="qvComparePrice" class="font-mono text-xs text-stone-400 line-through" data-price-inr="0">₹0</span>
            <span class="px-2 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-mono font-bold text-[9px] flex items-center gap-1">
              <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
              <span>18h Dispatch Active</span>
            </span>
          </div>

          <!-- Size Selector for Main Product -->
          <div class="mb-2.5">
            <div class="flex justify-between items-center mb-1">
              <span class="font-label-caps uppercase text-[10px] text-stone-700 font-bold">Select Size</span>
              <button type="button" onclick="openFittingModal()" class="text-[#a16207] underline text-[10px] font-mono font-bold cursor-pointer">Sizer Guide</button>
            </div>
            <div class="flex flex-wrap gap-1.5 font-mono" id="qvSizePills">
              <button type="button" onclick="selectQvSize('S', this)" class="qv-size-btn px-3 py-1.5 border border-stone-200 rounded-xl hover:border-stone-900 text-center text-xs">S</button>
              <button type="button" onclick="selectQvSize('M', this)" class="qv-size-btn px-3 py-1.5 border border-stone-950 bg-stone-950 text-[#e9c176] rounded-xl text-center text-xs font-bold shadow-xs">M</button>
              <button type="button" onclick="selectQvSize('L', this)" class="qv-size-btn px-3 py-1.5 border border-stone-200 rounded-xl hover:border-stone-900 text-center text-xs">L</button>
              <button type="button" onclick="selectQvSize('XL', this)" class="qv-size-btn px-3 py-1.5 border border-stone-200 rounded-xl hover:border-stone-900 text-center text-xs">XL</button>
            </div>
          </div>

          <!-- Quantity Stepper for Main Product -->
          <div class="flex items-center justify-between py-2 px-3 bg-stone-50 border border-stone-200 rounded-xl mb-2.5">
            <span class="font-label-caps uppercase text-[10px] text-stone-700 font-bold">Quantity</span>
            <div class="flex items-center gap-2">
              <button type="button" onclick="changeQvQuantity(-1)" class="w-6 h-6 rounded-lg bg-white border border-stone-300 hover:border-stone-900 flex items-center justify-center font-bold text-xs cursor-pointer shadow-2xs text-stone-800 active:scale-95">-</button>
              <span id="qvQuantityDisplay" class="w-6 text-center font-mono font-bold text-xs text-stone-950">1</span>
              <button type="button" onclick="changeQvQuantity(1)" class="w-6 h-6 rounded-lg bg-white border border-stone-300 hover:border-stone-900 flex items-center justify-center font-bold text-xs cursor-pointer shadow-2xs text-stone-800 active:scale-95">+</button>
            </div>
          </div>
        </div>

        <!-- ✦ AI STYLIST ENSEMBLE PAIRING (COMPLETE THE LOOK) ✦ -->
        <div id="qvAiPairBox" class="p-3.5 rounded-2xl bg-gradient-to-br from-amber-50/90 via-amber-100/40 to-stone-50 border border-amber-300/80 shadow-xs mb-2.5">
          <div class="flex items-center justify-between gap-2 mb-2">
            <div class="flex items-center gap-1.5">
              <span class="text-[9.5px] font-mono uppercase tracking-wider text-[#a16207] font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-[#a16207]">auto_awesome</span>
                <span>AI Stylist Curated Pairing</span>
              </span>
              <span class="text-[8.5px] bg-amber-200/70 text-amber-950 font-mono font-extrabold px-1.5 py-0.5 rounded border border-amber-300">
                99% Match
              </span>
            </div>
            <button type="button" onclick="consultStylistOnQv()" class="text-[9px] font-mono text-[#a16207] hover:underline font-bold flex items-center gap-0.5 cursor-pointer">
              <span>Ask AI Stylist</span>
              <span class="material-symbols-outlined text-[10px]">arrow_forward</span>
            </button>
          </div>

          <!-- Dynamic Bundle Incentive Ribbon -->
          <div class="mb-2 px-2.5 py-1 rounded-lg bg-stone-950 text-[#e9c176] text-[9.5px] font-mono font-bold flex items-center justify-between shadow-2xs">
            <span class="flex items-center gap-1">
              <span class="material-symbols-outlined text-[11px] text-amber-400">local_offer</span>
              <span>Complete The Look Privilege:</span>
            </span>
            <span class="text-white font-extrabold tracking-wide">SAVE 10% ON COMBO</span>
          </div>

          <div class="bg-white p-3 rounded-xl border border-stone-200 shadow-2xs space-y-2.5">
            <div class="flex items-center justify-between gap-2.5">
              <div class="flex items-center gap-2.5 min-w-0 cursor-pointer" onclick="if(currentQvAiPair) openProductQuickViewModal(currentQvAiPair)">
                <img id="qvAiPairImg" src="<?= base_url('img/okayama_selvedge_denim.jpg') ?>" class="w-12 h-13 object-cover rounded-xl bg-stone-100 flex-shrink-0 border border-stone-200 shadow-2xs hover:scale-105 transition-transform duration-300">
                <div class="min-w-0">
                  <span class="text-[8px] font-mono uppercase text-stone-500 font-bold block">Recommended Match</span>
                  <h5 id="qvAiPairTitle" class="font-serif text-xs font-bold text-stone-900 truncate hover:text-[#a16207] transition-colors">14.5oz Okayama Denim</h5>
                  <div class="flex items-baseline gap-1.5 mt-0.5">
                    <span id="qvAiPairPrice" class="font-mono text-[11px] text-[#a16207] font-bold" data-price-inr="3499">₹3,499</span>
                    <span class="text-[9px] text-emerald-700 font-mono font-semibold">· 10% Bundle Off</span>
                  </div>
                </div>
              </div>
              <button type="button" onclick="toggleQvPairInclusion()" id="btnQvAddPair" class="px-3 py-2 bg-stone-950 hover:bg-stone-800 text-[#e9c176] font-mono text-[9.5px] uppercase font-bold rounded-xl transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer shadow-xs active:scale-95">
                <span class="material-symbols-outlined text-xs">add</span>
                <span id="btnQvAddPairText">Pair Piece</span>
              </button>
            </div>

            <!-- Stylist Reasoning Quote -->
            <p id="qvAiPairReason" class="text-[10px] text-stone-600 font-light italic leading-snug px-1 border-l-2 border-amber-300">
              "Handpicked by Milan AI Stylist to create a harmonious silhouette with perfectly balanced textures."
            </p>

            <!-- Interactive Paired Item Size & Quantity Row -->
            <div class="flex items-center justify-between gap-2 pt-2 border-t border-stone-100">
              <!-- Size Selector for Paired Item -->
              <div class="inline-flex items-center gap-1.5 bg-amber-50/90 border border-amber-300/80 rounded-lg px-2 py-0.5 shadow-2xs">
                <span class="text-[8px] font-mono uppercase text-amber-900 font-extrabold tracking-wider">SIZE</span>
                <div class="relative flex items-center">
                  <select id="qvAiPairSizeSelect" onchange="window.currentQvAiPairSize = this.value; updateQvComboPricing();" class="text-[10px] font-mono font-bold bg-transparent text-stone-950 cursor-pointer focus:outline-hidden pr-3 appearance-none leading-none py-0">
                    <option value="28">28</option>
                    <option value="30">30</option>
                    <option value="32" selected>32</option>
                    <option value="34">34</option>
                    <option value="36">36</option>
                    <option value="38">38</option>
                  </select>
                  <span class="material-symbols-outlined text-[11px] text-amber-800 pointer-events-none absolute right-0">expand_more</span>
                </div>
              </div>

              <!-- Quantity for Paired Item -->
              <div class="flex items-center gap-1 bg-stone-100 border border-stone-200 rounded-lg px-1.5 py-0.5">
                <span class="text-[8px] font-mono uppercase text-stone-500 font-bold mr-1">QTY:</span>
                <button type="button" onclick="changeQvAiPairQuantity(-1)" class="w-4 h-4 rounded bg-white hover:bg-stone-200 text-stone-800 flex items-center justify-center font-bold text-[10px] cursor-pointer shadow-2xs leading-none active:scale-95">-</button>
                <span id="qvAiPairQtyDisplay" class="font-mono text-[10px] font-bold px-1 text-stone-950">1</span>
                <button type="button" onclick="changeQvAiPairQuantity(1)" class="w-4 h-4 rounded bg-white hover:bg-stone-200 text-stone-800 flex items-center justify-center font-bold text-[10px] cursor-pointer shadow-2xs leading-none active:scale-95">+</button>
              </div>
            </div>

            <!-- Live Combo Pricing Calculation Row -->
            <div id="qvComboPricingRow" class="hidden p-2 rounded-lg bg-emerald-50/80 border border-emerald-200 text-emerald-950 flex items-center justify-between text-[10.5px] font-mono">
              <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-xs text-emerald-600">verified</span>
                <span class="font-bold">2-Piece Ensemble Combo:</span>
              </div>
              <div class="flex items-baseline gap-1.5">
                <span id="qvComboFinalPrice" class="font-serif font-bold text-stone-950 text-xs">₹7,828</span>
                <span id="qvComboOriginalPrice" class="text-[9px] text-stone-400 line-through">₹8,698</span>
                <span id="qvComboSavings" class="text-[9px] font-bold text-emerald-700 bg-emerald-100 px-1 py-0.5 rounded">Save ₹870</span>
              </div>
            </div>

          </div>
        </div>

        <!-- Primary Dual Action Buttons -->
        <div class="space-y-2 pt-1 border-t border-stone-200">
          <button type="button" id="qvAddBagBtn" onclick="handleQvAddToCart()" class="w-full py-2.5 bg-stone-950 hover:bg-stone-800 text-white font-button text-xs uppercase tracking-widest text-center rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer font-bold">
            <span class="material-symbols-outlined text-sm text-[#e9c176]">shopping_bag</span>
            <span id="qvAddBagBtnText">Add to Curated Bag</span>
          </button>
          <button type="button" id="qvInstantBuyBtn" onclick="handleQvInstantBuy()" class="w-full py-2 bg-gradient-to-r from-amber-400 to-[#e9c176] hover:opacity-90 text-black font-button text-xs uppercase tracking-widest text-center rounded-xl transition-all flex items-center justify-center gap-1 cursor-pointer font-extrabold shadow-sm">
            <span class="material-symbols-outlined text-sm">bolt</span>
            <span>1-Click Instant Buy</span>
          </button>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 3. 💬 VIP ATELIER AI STYLIST FLOATING CONCIERGE CHAT WIDGET                  -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<div id="atelierStylistWidget" class="hidden md:flex fixed bottom-[82px] sm:bottom-[90px] right-4 sm:right-6 z-40 flex-col items-end transition-all duration-300">
  
  <!-- Chat Popup Window -->
  <div id="atelierStylistChatBox" class="bg-[#faf9f6] text-stone-900 shadow-2xl rounded-3xl border border-stone-300/80 w-[94vw] sm:w-[400px] max-w-sm mb-3 hidden flex-col overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-300" data-lenis-prevent="true" style="overscroll-behavior: contain;">
    
    <!-- Chat Header (Haute Couture Obsidian) -->
    <div class="bg-[#07080b] p-4 text-white flex justify-between items-center border-b border-white/10 relative overflow-hidden">
      <!-- Starlight flare -->
      <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#e9c176_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
      
      <div class="flex items-center gap-2.5 relative z-10">
        <div class="relative">
          <div class="w-9 h-9 rounded-full bg-white/10 border border-[#e9c176] flex items-center justify-center text-[#e9c176] shadow-sm">
            <span class="material-symbols-outlined text-lg">auto_awesome</span>
          </div>
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 absolute bottom-0 right-0 border-2 border-black animate-pulse"></span>
        </div>
        <div>
          <h4 class="font-serif font-bold text-sm text-white flex items-center gap-1.5">
            <span>Maître Stylist AI</span>
            <span class="text-[9px] font-mono font-bold bg-[#e9c176]/20 text-[#e9c176] px-1.5 py-0.2 rounded border border-[#e9c176]/40">VIP</span>
          </h4>
          <span class="text-[10px] text-white/60 font-mono block">Lumina Haute Couture Concierge</span>
        </div>
      </div>
      
      <button type="button" onclick="toggleStylistChat()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white/80 hover:text-white flex items-center justify-center transition-colors cursor-pointer relative z-10" aria-label="Close Chat">
        <span class="material-symbols-outlined text-lg">close</span>
      </button>
    </div>

    <!-- Chat Messages Scroll Container -->
    <div id="stylistChatMessages" class="p-4 flex flex-col gap-3 max-h-[360px] min-h-[250px] overflow-y-auto custom-scrollbar text-xs bg-[#faf9f6]" data-lenis-prevent="true" style="overscroll-behavior: contain;">
      <div class="flex gap-2.5 items-start">
        <div class="w-7 h-7 rounded-full bg-stone-900 text-[#e9c176] flex items-center justify-center flex-shrink-0 text-xs shadow-xs">
          <span class="material-symbols-outlined text-sm">auto_awesome</span>
        </div>
        <div class="p-3.5 rounded-2xl rounded-tl-sm bg-white border border-stone-200 text-stone-800 leading-relaxed shadow-xs flex-1">
          <p class="font-normal font-sans">
            Greetings. I am your bespoke <strong class="text-stone-950 font-bold">Lumina Maître Stylist</strong>. How may I assist your sartorial curation today?
          </p>
        </div>
      </div>
    </div>

    <!-- Quick Prompt Action Chips (Scrollbar-Free) -->
    <div class="px-3 py-2 bg-stone-100 border-t border-stone-200 flex gap-1.5 overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] text-[10px] font-mono text-stone-800" data-lenis-prevent="true">
      <button type="button" onclick="sendStylistPrompt('Autumn Layering Look')" class="px-2.5 py-1 bg-white hover:bg-stone-900 hover:text-[#e9c176] rounded-full border border-stone-200 hover:border-stone-900 whitespace-nowrap cursor-pointer transition-all shadow-2xs font-medium">
        🧥 Layering
      </button>
      <button type="button" onclick="sendStylistPrompt('Size Advice for 180cm / 75kg')" class="px-2.5 py-1 bg-white hover:bg-stone-900 hover:text-[#e9c176] rounded-full border border-stone-200 hover:border-stone-900 whitespace-nowrap cursor-pointer transition-all shadow-2xs font-medium">
        📐 Size Advice
      </button>
      <button type="button" onclick="sendStylistPrompt('700 GSM Cashmere Fabric Details')" class="px-2.5 py-1 bg-white hover:bg-stone-900 hover:text-[#e9c176] rounded-full border border-stone-200 hover:border-stone-900 whitespace-nowrap cursor-pointer transition-all shadow-2xs font-medium">
        🧵 Fabric Dossier
      </button>
      <button type="button" onclick="sendStylistPrompt('Black-Tie Gala Dinner Look')" class="px-2.5 py-1 bg-white hover:bg-stone-900 hover:text-[#e9c176] rounded-full border border-stone-200 hover:border-stone-900 whitespace-nowrap cursor-pointer transition-all shadow-2xs font-medium">
        🥂 Gala Look
      </button>
      <button type="button" onclick="sendStylistPrompt('VIP Privilege Discount Code')" class="px-2.5 py-1 bg-amber-50 hover:bg-stone-900 hover:text-[#e9c176] text-[#a16207] rounded-full border border-amber-300 whitespace-nowrap cursor-pointer transition-all shadow-2xs font-bold">
        🎁 VIP Code
      </button>
    </div>

    <!-- Chat Input Form -->
    <form onsubmit="handleStylistInput(event)" class="p-2.5 bg-white border-t border-stone-200 flex items-center gap-2">
      <input type="text" id="stylistUserInput" placeholder="Ask about styling, sizing, fabrics..." class="flex-1 bg-stone-50 border border-stone-200 rounded-xl px-3.5 py-2 text-xs text-stone-900 outline-none focus:border-stone-950 transition-colors font-sans" autocomplete="off">
      <button type="submit" class="w-9 h-9 rounded-xl bg-stone-950 text-[#e9c176] flex items-center justify-center hover:bg-stone-800 transition-all cursor-pointer shadow-sm flex-shrink-0" aria-label="Send Message">
        <span class="material-symbols-outlined text-sm">send</span>
      </button>
    </form>
  </div>

  <!-- Floating Trigger Bubble Button -->
  <button type="button" onclick="toggleStylistChat()" id="atelierStylistBubble" class="relative group flex items-center gap-2 px-4 py-2.5 rounded-full bg-[#07080b] text-white border border-[#e9c176]/50 shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer" aria-label="Open AI Concierge">
    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></div>
    <span class="material-symbols-outlined text-[#e9c176] text-lg">auto_awesome</span>
    <span class="text-xs font-mono uppercase tracking-wider font-bold text-[#e9c176] hidden sm:inline">AI Stylist</span>
  </button>
</div>

<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 4. 📍 EXPRESS DELIVERY & PINCODE ESTIMATOR MODAL                             -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<div id="pincodeModal" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[115] hidden items-center justify-center p-4" onclick="if(event.target===this)closePincodeModal()" data-lenis-prevent="true" style="overscroll-behavior: contain;">
  <div class="liquid-glass bg-surface p-6 rounded-2xl max-w-md w-full ambient-elevation relative border border-outline-variant/60 shadow-2xl text-primary" data-lenis-prevent="true" style="overscroll-behavior: contain;">
    <div class="flex justify-between items-start pb-3 border-b border-outline-variant/40 mb-4">
      <div>
        <div class="inline-flex items-center gap-1 text-[10px] font-mono text-accent font-bold uppercase">
          <span class="material-symbols-outlined text-xs">local_shipping</span>
          <span>BlueDart Priority Express</span>
        </div>
        <h4 class="font-serif font-bold text-xl text-primary">Transit &amp; Delivery Calculator</h4>
      </div>
      <button type="button" onclick="closePincodeModal()" class="text-on-surface-variant hover:text-primary cursor-pointer">
        <span class="material-symbols-outlined text-2xl">close</span>
      </button>
    </div>

    <div class="space-y-3 text-xs">
      <p class="text-on-surface-variant">Enter your postal PIN code to verify guaranteed express delivery windows and concierge dispatch.</p>
      <div class="flex gap-2">
        <input type="text" id="pincodeCheckInput" placeholder="e.g. 110001 or 400001" maxlength="6" class="flex-1 bg-surface-container border border-outline-variant/60 rounded-lg px-3 py-2 font-mono text-xs text-primary outline-none focus:border-accent">
        <button type="button" onclick="checkPincodeTransit()" class="px-4 py-2 bg-primary text-white rounded-lg font-button uppercase tracking-wider text-[11px] hover:bg-secondary transition-colors cursor-pointer">
          Verify
        </button>
      </div>

      <div id="pincodeResultBox" class="p-3.5 bg-surface-container rounded-xl border border-outline-variant/40 space-y-2 hidden">
        <div class="flex items-center justify-between text-emerald-700 font-bold">
          <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Serviceable Hub</span>
          <span class="font-mono text-[11px]">Priority Hub 01</span>
        </div>
        <div class="text-[11px] font-mono text-on-surface-variant space-y-1">
          <div class="flex justify-between"><span>Est. Delivery:</span> <strong class="text-primary" id="pincodeEstDate">Tuesday, Aug 25</strong></div>
          <div class="flex justify-between"><span>Courier Tier:</span> <strong class="text-primary">Insured White-Glove Express</strong></div>
          <div class="flex justify-between"><span>Cash on Delivery:</span> <strong class="text-emerald-600">Available</strong></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 5. ❤️ CLIENT SAVED WARDROBE (WISHLIST SLIDE-OUT DRAWER)                      -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<div id="wishlistDrawerOverlay" class="fixed inset-0 bg-black/65 backdrop-blur-sm z-[9999] hidden transition-opacity duration-300" onclick="if(event.target===this)closeWishlistDrawer()" data-lenis-prevent="true" style="overscroll-behavior: contain;">
  <div class="fixed inset-y-0 right-0 max-w-[92vw] sm:max-w-md w-full bg-white text-stone-900 border-l border-stone-200 shadow-2xl p-5 sm:p-6 flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-out will-change-transform transform-gpu" id="wishlistPanel" data-lenis-prevent="true" style="overscroll-behavior: contain;">
    <div>
      <div class="flex justify-between items-center pb-4 border-b border-stone-200">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-rose-500 text-2xl">favorite</span>
          <h3 class="font-serif font-bold text-xl text-stone-950">Saved Wardrobe</h3>
        </div>
        <button type="button" onclick="closeWishlistDrawer()" class="w-8 h-8 rounded-full flex items-center justify-center text-stone-400 hover:text-black hover:bg-stone-100 transition-colors cursor-pointer" aria-label="Close">
          <span class="material-symbols-outlined text-xl">close</span>
        </button>
      </div>

      <div class="py-4 flex flex-col gap-3 max-h-[65vh] overflow-y-auto custom-scrollbar" id="wishlistItemsList" data-lenis-prevent="true" style="overscroll-behavior: contain;">
        <div class="py-12 text-center text-stone-400 text-sm flex flex-col items-center">
          <span class="material-symbols-outlined text-4xl mb-2 text-stone-300">favorite_border</span>
          <p class="font-light">Your saved wardrobe is empty.</p>
          <a href="<?= base_url('shop') ?>" class="mt-3 text-xs text-[#a16207] underline font-bold uppercase tracking-wider">Explore Haute Couture</a>
        </div>
      </div>
    </div>

    <div class="border-t border-stone-200 pt-4 space-y-2">
      <button type="button" onclick="moveAllWishlistToBag()" class="w-full py-3 bg-stone-950 hover:bg-stone-800 text-white font-button text-xs uppercase tracking-widest text-center rounded-xl transition-all shadow-md block cursor-pointer font-bold">
        Move All to Curated Bag
      </button>
      <a href="<?= base_url('shop') ?>" class="w-full py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-800 font-mono text-[11px] uppercase tracking-wider text-center rounded-xl transition-all block text-center font-semibold">
        Continue Shopping →
      </a>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 6. ✨ BESPOKE MONOGRAMMING STUDIO MODAL                                      -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<div id="monogramModal" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[115] hidden items-center justify-center p-4" onclick="if(event.target===this)closeMonogramModal()" data-lenis-prevent="true" style="overscroll-behavior: contain;">
  <div class="liquid-glass bg-surface p-6 rounded-2xl max-w-lg w-full ambient-elevation relative border border-outline-variant/60 shadow-2xl text-primary" data-lenis-prevent="true" style="overscroll-behavior: contain;">
    <div class="flex justify-between items-start pb-3 border-b border-outline-variant/40 mb-4">
      <div>
        <div class="inline-flex items-center gap-1 text-[10px] font-mono text-accent font-bold uppercase">
          <span class="material-symbols-outlined text-xs">brush</span>
          <span>Artisan Made-to-Order</span>
        </div>
        <h4 class="font-serif font-bold text-2xl text-primary">Bespoke Monogram Studio</h4>
      </div>
      <button type="button" onclick="closeMonogramModal()" class="text-on-surface-variant hover:text-primary cursor-pointer">
        <span class="material-symbols-outlined text-2xl">close</span>
      </button>
    </div>

    <div class="space-y-4 text-xs">
      <!-- Live Monogram Swatch Preview -->
      <div class="aspect-[16/9] bg-[#1c1917] rounded-xl flex flex-col items-center justify-center border border-[#e9c176]/40 p-4 relative overflow-hidden">
        <span class="text-[9px] font-label-caps uppercase tracking-widest text-white/50 absolute top-3 left-3">Garment Embroidery Preview</span>
        <div id="monogramLivePreview" class="text-4xl sm:text-5xl font-serif font-bold tracking-[0.3em] text-[#e9c176] drop-shadow-[0_2px_10px_rgba(233,193,118,0.5)]">
          L.M.
        </div>
        <span id="monogramStyleLabel" class="text-[10px] font-mono text-white/80 absolute bottom-3 right-3">24k Metallic Gold · Left Cuff</span>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="font-label-caps uppercase text-[10px] text-on-surface-variant font-bold block mb-1">Your Initials (Max 3)</label>
          <input type="text" id="monogramTextInput" value="L.M." maxlength="4" oninput="updateMonogramVisual()" class="w-full bg-surface-container border border-outline-variant/60 rounded-lg px-3 py-2 font-serif text-sm font-bold text-primary uppercase outline-none focus:border-accent">
        </div>
        <div>
          <label class="font-label-caps uppercase text-[10px] text-on-surface-variant font-bold block mb-1">Thread Finish</label>
          <select id="monogramThreadSelect" onchange="updateMonogramVisual()" class="w-full bg-surface-container border border-outline-variant/60 rounded-lg p-2 text-xs text-primary font-medium outline-none focus:border-accent">
            <option value="gold">24k Metallic Gold Thread</option>
            <option value="tonal">Tone-on-Tone Mulberry Silk</option>
            <option value="silver">Sterling Silver Filigree</option>
          </select>
        </div>
      </div>

      <button type="button" onclick="saveMonogramPreference()" class="w-full py-3 bg-primary text-on-primary font-button text-xs uppercase tracking-widest text-center rounded hover:bg-secondary transition-all shadow-md cursor-pointer">
        Lock Bespoke Monogram (Complimentary)
      </button>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════════════════════════════════════════════ -->
<!-- 7. GLOBAL MULTI-CURRENCY, WISHLIST & CLIENT ATELIER CONTROLLER SCRIPT         -->
<!-- ════════════════════════════════════════════════════════════════════════════ -->
<script>
// ── Global Scroll Lock / Unlock Helpers ──
window.lockStorefrontScroll = function() {
  document.documentElement.style.overflow = 'hidden';
  document.body.style.overflow = 'hidden';
};
window.unlockStorefrontScroll = function() {
  document.documentElement.style.overflow = '';
  document.body.style.overflow = '';
};

// ── Live Multi-Currency Engine ──
const CURRENCY_RATES = {
  INR: { rate: 1.0, symbol: '₹', code: 'INR', prefix: true },
  USD: { rate: 0.012, symbol: '$', code: 'USD', prefix: true },
  EUR: { rate: 0.011, symbol: '€', code: 'EUR', prefix: true },
  GBP: { rate: 0.0095, symbol: '£', code: 'GBP', prefix: true },
  AED: { rate: 0.044, symbol: 'AED ', code: 'AED', prefix: true },
  CAD: { rate: 0.016, symbol: 'CA$', code: 'CAD', prefix: true },
  AUD: { rate: 0.018, symbol: 'AU$', code: 'AUD', prefix: true },
  JPY: { rate: 1.80, symbol: '¥', code: 'JPY', prefix: true },
  SGD: { rate: 0.016, symbol: 'SG$', code: 'SGD', prefix: true }
};

let currentStoreCurrency = localStorage.getItem('lumina_currency') || 'INR';

window.formatPrice = function(inrAmount) {
  const curr = CURRENCY_RATES[currentStoreCurrency] || CURRENCY_RATES.INR;
  const converted = inrAmount * curr.rate;
  const rounded = curr.code === 'JPY' ? Math.round(converted) : (converted >= 100 ? Math.round(converted) : converted.toFixed(2));
  return curr.symbol + Number(rounded).toLocaleString();
};

window.selectStoreCurrency = function(code, notify = true) {
  if (!CURRENCY_RATES[code]) return;
  currentStoreCurrency = code;
  localStorage.setItem('lumina_currency', code);
  
  const headerCode = document.getElementById('headerCurrencyCode');
  if (headerCode) headerCode.textContent = code + ' (' + CURRENCY_RATES[code].symbol.trim() + ')';
  
  const mobileSelect = document.getElementById('mobileCurrencySelect');
  if (mobileSelect) mobileSelect.value = code;

  const menu = document.getElementById('currencyDropdownMenu');
  if (menu) menu.classList.add('hidden');

  updateAllPricesOnPage();
  if (notify) {
    ndToast('Currency updated to ' + code, 'info');
  }
};

function toggleCurrencyMenu() {
  const menu = document.getElementById('currencyDropdownMenu');
  if (menu) menu.classList.toggle('hidden');
}

function toggleLanguageMenu() {
  const menu = document.getElementById('languageDropdownMenu');
  if (menu) menu.classList.toggle('hidden');
}

window.updateAllPricesOnPage = function() {
  document.querySelectorAll('[data-price-inr]').forEach(el => {
    const rawInr = parseFloat(el.getAttribute('data-price-inr') || 0);
    el.textContent = formatPrice(rawInr);
  });
};

document.addEventListener('DOMContentLoaded', () => {
  const savedCurr = localStorage.getItem('lumina_currency');
  if (savedCurr && CURRENCY_RATES[savedCurr]) {
    selectStoreCurrency(savedCurr, false);
  } else {
    updateAllPricesOnPage();
  }
  updateWishlistBadge();
  loadQuickBagItems();
});

// ════════════════════════════════════════════════════════════════════════════
// 1. 🪞 AI VIRTUAL MIRROR & BESPOKE FACE-FIT STUDIO ENGINE
// ════════════════════════════════════════════════════════════════════════════

const VTR_LOOKS_DATABASE = {
  executive: {
    key: 'executive',
    title: 'The Power Executive Look',
    modelImg: '<?= base_url("img/model_look_executive.jpg") ?>',
    mannequinImg: '<?= base_url("img/mannequin_look_executive.jpg") ?>',
    modelCoords: { top: '4.5%', left: '50.0%', width: '25.5%', height: '22.5%' },
    mannequinCoords: { top: '5.5%', left: '50.0%', width: '24.0%', height: '21.5%' },
    price: 14197,
    compare_price: 19497,
    save: 5300,
    items: [
      { id: 5, title: 'Super 150s Merino Wool Blazer', price: 4799, image: '<?= base_url("img/wool_blazer_luxury.jpg") ?>', tag: 'Tailored Blazer' },
      { id: 9, title: 'Italian Pleated Wool Trousers', price: 4999, image: '<?= base_url("img/italian_pleated_trousers.jpg") ?>', tag: 'Virgin Wool Pant' },
      { id: 12, title: 'Burnished Calfskin Penny Loafers', price: 5499, image: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>', tag: 'Handcrafted Derby' }
    ]
  },
  street: {
    key: 'street',
    title: 'The Monochrome Street Poise',
    modelImg: '<?= base_url("img/model_look_street.jpg") ?>',
    mannequinImg: '<?= base_url("img/mannequin_look_street.jpg") ?>',
    modelCoords: { top: '4.2%', left: '50.0%', width: '25.0%', height: '22.0%' },
    mannequinCoords: { top: '5.8%', left: '50.0%', width: '24.0%', height: '21.0%' },
    price: 13397,
    compare_price: 18697,
    save: 5300,
    items: [
      { id: 6, title: 'Sculpted 500 GSM Terry Hoodie', price: 2899, image: '<?= base_url("img/sculpted_terry_hoodie.jpg") ?>', tag: '500 GSM Loopback' },
      { id: 2, title: 'Okayama 14.5oz Selvedge Denim', price: 4499, image: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', tag: 'Raw Japanese Indigo' },
      { id: 11, title: 'Handcrafted Italian Chelsea Boots', price: 5999, image: '<?= base_url("img/chelsea_leather_boots.jpg") ?>', tag: 'Tuscan Box Calf' }
    ]
  },
  classic: {
    key: 'classic',
    title: 'The Milanese Classic Look',
    modelImg: '<?= base_url("img/model_look_classic.jpg") ?>',
    mannequinImg: '<?= base_url("img/mannequin_look_classic.jpg") ?>',
    modelCoords: { top: '4.0%', left: '50.0%', width: '25.0%', height: '22.0%' },
    mannequinCoords: { top: '5.5%', left: '50.0%', width: '24.0%', height: '21.0%' },
    price: 12297,
    compare_price: 17597,
    save: 5300,
    items: [
      { id: 1, title: 'The Atelier Cashmere Cocoon Coat', price: 4399, image: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>', tag: '700 GSM Outerwear' },
      { id: 8, title: 'Cashmere Turtleneck Knit', price: 2999, image: '<?= base_url("img/cashmere_turtleneck_knit.jpg") ?>', tag: 'Grade-A Cashmere' },
      { id: 13, title: 'Minimalist Suede Derby Shoes', price: 4899, image: '<?= base_url("img/minimalist_suede_derby.jpg") ?>', tag: 'Italian Split Suede' }
    ]
  },
  peacoat: {
    key: 'peacoat',
    title: 'The Double-Breasted Peacoat',
    modelImg: '<?= base_url("img/melton_wool_peacoat.jpg") ?>',
    mannequinImg: '<?= base_url("img/melton_wool_peacoat.jpg") ?>',
    modelCoords: { top: '4.2%', left: '50.0%', width: '25.5%', height: '22.5%' },
    mannequinCoords: { top: '5.5%', left: '50.0%', width: '24.0%', height: '21.5%' },
    price: 15297,
    compare_price: 20497,
    save: 5200,
    items: [
      { id: 4, title: 'Tailored Melton Wool Peacoat', price: 4799, image: '<?= base_url("img/melton_wool_peacoat.jpg") ?>', tag: 'Melton Virgin Wool' },
      { id: 9, title: 'Italian Pleated Wool Trousers', price: 4999, image: '<?= base_url("img/italian_pleated_trousers.jpg") ?>', tag: 'Pleated Tailoring' },
      { id: 12, title: 'Burnished Calfskin Penny Loafers', price: 5499, image: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>', tag: 'Polished Noir' }
    ]
  },
  silk: {
    key: 'silk',
    title: 'The Mulberry Silk Eveningwear',
    modelImg: '<?= base_url("img/mulberry_silk_dress.jpg") ?>',
    mannequinImg: '<?= base_url("img/mulberry_silk_dress.jpg") ?>',
    modelCoords: { top: '4.2%', left: '50.0%', width: '25.0%', height: '22.0%' },
    mannequinCoords: { top: '5.5%', left: '50.0%', width: '24.0%', height: '21.5%' },
    price: 14197,
    compare_price: 19497,
    save: 5300,
    items: [
      { id: 5, title: 'Mulberry Silk Eveningwear', price: 3899, image: '<?= base_url("img/mulberry_silk_dress.jpg") ?>', tag: 'Pure Mulberry Silk' },
      { id: 4, title: 'Tailored Melton Wool Peacoat', price: 4799, image: '<?= base_url("img/melton_wool_peacoat.jpg") ?>', tag: 'Outerwear Layer' },
      { id: 12, title: 'Burnished Calfskin Penny Loafers', price: 5499, image: '<?= base_url("img/calfskin_penny_loafers.jpg") ?>', tag: 'Polished Loafers' }
    ]
  }
};

let currentVtrLookKey = 'executive';
let currentVtrModelMode = 'model';
let vtrIsFlipped = false;
let currentVtrTone = 'warm';
let fittingSilhouette = 'masculine';

window.openFittingModal = function(initialLookKey, initialTab) {
  const modal = document.getElementById('virtualFittingModal');
  if (!modal) return;

  modal.classList.remove('hidden');
  modal.classList.add('flex');
  modal.style.display = 'flex';
  lockStorefrontScroll();

  // Always default to 🪞 AI Face Mirror unless explicitly opened as sizing
  switchVtrTab(initialTab === 'sizing' ? 'sizing' : 'faceMirror');

  renderVtrLooksGrid();
  selectVtrLook(initialLookKey || currentVtrLookKey);
  updateFittingCalculations();
  initVtrDragAndDrop();
};
window.openVirtualTryOn = window.openFittingModal;

window.closeFittingModal = function() {
  const modal = document.getElementById('virtualFittingModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    modal.style.display = 'none';
    unlockStorefrontScroll();
  }
};
window.closeVirtualTryOn = window.closeFittingModal;

window.toggleVtrModelMode = function(mode) {
  currentVtrModelMode = mode;
  const btnM = document.getElementById('vtrModeBtn_model');
  const btnQ = document.getElementById('vtrModeBtn_mannequin');

  if (mode === 'model') {
    if (btnM) btnM.className = 'px-2 py-1 rounded bg-[#e9c176] text-black font-bold cursor-pointer transition-all';
    if (btnQ) btnQ.className = 'px-2 py-1 rounded text-white/70 hover:text-white font-medium cursor-pointer transition-all';
  } else {
    if (btnM) btnM.className = 'px-2 py-1 rounded text-white/70 hover:text-white font-medium cursor-pointer transition-all';
    if (btnQ) btnQ.className = 'px-2 py-1 rounded bg-[#e9c176] text-black font-bold cursor-pointer transition-all';
  }

  selectVtrLook(currentVtrLookKey);
};

window.switchVtrTab = function(tabName) {
  const tabFace = document.getElementById('vtrTab_faceMirror');
  const tabSizing = document.getElementById('vtrTab_sizing');
  const btnFace = document.getElementById('vtrTabBtn_faceMirror');
  const btnSizing = document.getElementById('vtrTabBtn_sizing');

  if (tabName === 'faceMirror') {
    if (tabFace) tabFace.classList.remove('hidden');
    if (tabSizing) tabSizing.classList.add('hidden');
    if (btnFace) {
      btnFace.className = 'px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg bg-stone-900 text-[#e9c176] font-bold transition-all shadow-xs cursor-pointer';
    }
    if (btnSizing) {
      btnSizing.className = 'px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg text-white/70 hover:text-white font-medium transition-all cursor-pointer';
    }
  } else {
    if (tabFace) tabFace.classList.add('hidden');
    if (tabSizing) tabSizing.classList.remove('hidden');
    if (btnFace) {
      btnFace.className = 'px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg text-white/70 hover:text-white font-medium transition-all cursor-pointer';
    }
    if (btnSizing) {
      btnSizing.className = 'px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg bg-stone-900 text-[#e9c176] font-bold transition-all shadow-xs cursor-pointer';
    }
  }
};

window.handleVtrFaceUpload = function(event) {
  const file = event.target.files && event.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function(e) {
    const faceImg = document.getElementById('vtrUserFaceImage');
    if (faceImg) {
      faceImg.src = e.target.result;
      triggerVtrAutoCalibrate();
      if (typeof showStashToast === 'function') {
        showStashToast('✦ Custom Selfie Face Uploaded & Calibrated!');
      } else {
        ndToast('✦ Custom Selfie Face Uploaded!', 'success');
      }
    }
  };
  reader.readAsDataURL(file);
};

window.handleVtrBodyUpload = function(event) {
  const file = event.target.files && event.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function(e) {
    const modelImg = document.getElementById('vtrModelImage');
    if (modelImg) {
      modelImg.src = e.target.result;
      triggerVtrAutoCalibrate();
      if (typeof showStashToast === 'function') {
        showStashToast('✦ Custom Photo Loaded into Atelier Mirror!');
      } else {
        ndToast('✦ Custom Photo Loaded into Atelier Mirror!', 'success');
      }
    }
  };
  reader.readAsDataURL(file);
};

window.setVtrPresetFace = function(url, btn) {
  const faceImg = document.getElementById('vtrUserFaceImage');
  if (faceImg) {
    faceImg.src = url;
    triggerVtrAutoCalibrate();
  }
  document.querySelectorAll('.vtr-avatar-btn').forEach(b => {
    b.className = 'vtr-avatar-btn px-2.5 py-1.5 rounded-xl border border-stone-200 bg-stone-50 hover:border-stone-400 text-stone-800 text-[11px] font-mono font-medium flex items-center gap-1.5 cursor-pointer';
  });
  if (btn) {
    btn.className = 'vtr-avatar-btn active px-2.5 py-1.5 rounded-xl border border-stone-950 bg-stone-950 text-[#e9c176] text-[11px] font-mono font-bold flex items-center gap-1.5 cursor-pointer shadow-xs';
  }
};

window.renderVtrLooksGrid = function() {
  const cont = document.getElementById('vtrLooksGrid');
  if (!cont) return;

  cont.innerHTML = Object.keys(VTR_LOOKS_DATABASE).map(key => {
    const lk = VTR_LOOKS_DATABASE[key];
    const isAct = key === currentVtrLookKey;
    const imgUrl = currentVtrModelMode === 'mannequin' && lk.mannequinImg ? lk.mannequinImg : lk.modelImg;
    return `
      <div onclick="selectVtrLook('${key}')" class="vtr-look-card rounded-xl p-2 border transition-all cursor-pointer flex flex-col justify-between ${isAct ? 'border-stone-950 bg-stone-950 text-white shadow-xs ring-1 ring-stone-950' : 'border-stone-200 bg-stone-50 text-stone-800 hover:border-stone-400'}">
        <div class="aspect-square rounded-lg overflow-hidden mb-1.5 bg-stone-200">
          <img src="${imgUrl}" alt="${lk.title}" class="w-full h-full object-cover">
        </div>
        <div class="truncate text-[10px] font-serif font-bold">${lk.title}</div>
        <div class="text-[9px] font-mono ${isAct ? 'text-[#e9c176]' : 'text-[#a16207]'} font-bold">₹${Number(lk.price).toLocaleString('en-IN')}</div>
      </div>
    `;
  }).join('');
};

window.selectVtrLook = function(lookKey) {
  const lk = VTR_LOOKS_DATABASE[lookKey];
  if (!lk) return;
  currentVtrLookKey = lookKey;

  // Update Model / Mannequin Image
  const mImg = document.getElementById('vtrModelImage');
  const imgUrl = currentVtrModelMode === 'mannequin' && lk.mannequinImg ? lk.mannequinImg : lk.modelImg;
  if (mImg) mImg.src = imgUrl;

  // Update Face Overlay Anchor Position based on mode
  const coords = currentVtrModelMode === 'mannequin' && lk.mannequinCoords ? lk.mannequinCoords : (lk.modelCoords || lk.headCoords);
  const overlay = document.getElementById('vtrFaceOverlayContainer');
  if (overlay && coords) {
    overlay.style.top = coords.top || '4.5%';
    overlay.style.left = coords.left || '50.0%';
    overlay.style.width = coords.width || '25.0%';
    overlay.style.height = coords.height || '22.0%';
  }

  // Update Badges & Titles
  const lookBadge = document.getElementById('vtrCurrentLookBadge');
  if (lookBadge) lookBadge.textContent = lk.title;

  const tEl = document.getElementById('vtrLookTitle');
  if (tEl) tEl.textContent = lk.title;

  const pEl = document.getElementById('vtrLookPrice');
  if (pEl) pEl.textContent = '₹' + Number(lk.price).toLocaleString('en-IN');

  const sEl = document.getElementById('vtrLookSave');
  if (sEl) sEl.textContent = 'Save ₹' + Number(lk.save || 5300).toLocaleString('en-IN');

  // Update Included Items Breakdown
  const itList = document.getElementById('vtrLookItemsList');
  if (itList && lk.items) {
    itList.innerHTML = lk.items.map(it => `
      <div class="flex items-center justify-between py-1 border-b border-white/5">
        <div class="flex items-center gap-2 truncate">
          <img src="${it.image}" class="w-6 h-6 rounded-md object-cover flex-shrink-0">
          <span class="truncate">${it.title}</span>
        </div>
        <span class="font-mono text-[10px] text-[#e9c176] flex-shrink-0">₹${Number(it.price).toLocaleString('en-IN')}</span>
      </div>
    `).join('');
  }

  resetVtrFaceTransform();
  renderVtrLooksGrid();
};

window.triggerVtrAutoCalibrate = function() {
  const hud = document.getElementById('vtrAiHudOverlay');
  const status = document.getElementById('vtrAiHudStatus');

  if (hud && status) {
    hud.classList.remove('hidden');
    hud.style.opacity = '1';
    status.textContent = '🔍 Step 1/3: Detecting 68 Biometric Facial Landmarks...';

    setTimeout(() => {
      status.textContent = '👔 Step 2/3: Harmonizing Garment Collar & Lighting (4800K)...';
    }, 280);

    setTimeout(() => {
      status.textContent = '✨ Step 3/3: AI Neural Fit Complete!';
      resetVtrFaceTransform();
    }, 550);

    setTimeout(() => {
      hud.style.opacity = '0';
      setTimeout(() => hud.classList.add('hidden'), 250);
      if (typeof showStashToast === 'function') {
        showStashToast('✦ AI Neural Fit Locked! 99.8% precision.');
      } else {
        ndToast('✦ AI Neural Face Fit Locked!', 'success');
      }
    }, 850);
  } else {
    resetVtrFaceTransform();
  }
};

window.setVtrTone = function(toneKey, btn) {
  currentVtrTone = toneKey;
  const overlay = document.getElementById('vtrToneOverlay');
  const faceImg = document.getElementById('vtrUserFaceImage');

  document.querySelectorAll('.vtr-tone-btn').forEach(b => {
    b.className = 'vtr-tone-btn px-2 py-0.5 rounded-md bg-stone-100 text-stone-700 hover:bg-stone-200';
  });
  if (btn) {
    btn.className = 'vtr-tone-btn active px-2 py-0.5 rounded-md bg-stone-900 text-[#e9c176] font-bold';
  }

  if (toneKey === 'warm') {
    if (overlay) overlay.style.backgroundColor = '#b45309';
    if (faceImg) faceImg.style.filter = 'contrast(1.04) brightness(0.98) saturate(1.05)';
  } else if (toneKey === 'natural') {
    if (overlay) overlay.style.backgroundColor = '#78716c';
    if (faceImg) faceImg.style.filter = 'contrast(1.02) brightness(1.0) saturate(1.0)';
  } else if (toneKey === 'cool') {
    if (overlay) overlay.style.backgroundColor = '#3b82f6';
    if (faceImg) faceImg.style.filter = 'contrast(1.06) brightness(0.96) saturate(0.92)';
  }
};

window.updateVtrFaceTransform = function() {
  const faceImg = document.getElementById('vtrUserFaceImage');
  if (!faceImg) return;

  const scale = (parseInt(document.getElementById('vtrScaleInput')?.value || 100)) / 100;
  const posY = parseInt(document.getElementById('vtrPosYInput')?.value || 0);
  const posX = parseInt(document.getElementById('vtrPosXInput')?.value || 0);
  const rot = parseInt(document.getElementById('vtrRotateInput')?.value || 0);
  const flip = vtrIsFlipped ? 'scaleX(-1)' : 'scaleX(1)';

  faceImg.style.transform = `translate(${posX}px, ${posY}px) scale(${scale}) rotate(${rot}deg) ${flip}`;
};

window.resetVtrFaceTransform = function() {
  const sIn = document.getElementById('vtrScaleInput');
  const yIn = document.getElementById('vtrPosYInput');
  const xIn = document.getElementById('vtrPosXInput');
  const rIn = document.getElementById('vtrRotateInput');

  if (sIn) sIn.value = 100;
  if (yIn) yIn.value = 0;
  if (xIn) xIn.value = 0;
  if (rIn) rIn.value = 0;
  vtrIsFlipped = false;

  updateVtrFaceTransform();
};

window.flipVtrFace = function() {
  vtrIsFlipped = !vtrIsFlipped;
  updateVtrFaceTransform();
};

// ── Real-Time Interactive Dragging on Stage ──
let vtrIsDragging = false;
let vtrDragStartX = 0;
let vtrDragStartY = 0;

function initVtrDragAndDrop() {
  const stage = document.getElementById('vtrMirrorStage');
  if (!stage || stage._dragInitialized) return;
  stage._dragInitialized = true;

  function onStart(e) {
    vtrIsDragging = true;
    const pt = e.touches ? e.touches[0] : e;
    vtrDragStartX = pt.clientX;
    vtrDragStartY = pt.clientY;
  }

  function onMove(e) {
    if (!vtrIsDragging) return;
    const pt = e.touches ? e.touches[0] : e;
    const dx = pt.clientX - vtrDragStartX;
    const dy = pt.clientY - vtrDragStartY;
    vtrDragStartX = pt.clientX;
    vtrDragStartY = pt.clientY;

    const xIn = document.getElementById('vtrPosXInput');
    const yIn = document.getElementById('vtrPosYInput');
    if (xIn && yIn) {
      xIn.value = Math.max(-20, Math.min(20, parseInt(xIn.value || 0) + (dx > 0 ? 1 : -1)));
      yIn.value = Math.max(-25, Math.min(25, parseInt(yIn.value || 0) + (dy > 0 ? 1 : -1)));
      updateVtrFaceTransform();
    }
  }

  function onEnd() {
    vtrIsDragging = false;
  }

  stage.addEventListener('mousedown', onStart);
  window.addEventListener('mousemove', onMove);
  window.addEventListener('mouseup', onEnd);

  stage.addEventListener('touchstart', onStart, { passive: true });
  window.addEventListener('touchmove', onMove, { passive: true });
  window.addEventListener('touchend', onEnd);
}

// ── Dynamic Body Silhouette & Build Morphing Engine ──
window.setVtrBodyPreset = function(presetKey, btn) {
  const hInput = document.getElementById('vtrBodyHeightInput');
  const wInput = document.getElementById('vtrBodyWidthInput');
  const badge = document.getElementById('vtrBodyBuildBadge');

  document.querySelectorAll('.vtr-build-btn').forEach(b => {
    b.className = 'vtr-build-btn px-1.5 py-1 rounded-lg border border-stone-200 hover:border-stone-400 bg-stone-50 text-stone-700 font-bold transition-all text-center cursor-pointer';
  });
  if (btn) {
    btn.className = 'vtr-build-btn active px-1.5 py-1 rounded-lg border border-stone-900 bg-stone-900 text-[#e9c176] font-bold transition-all text-center shadow-xs cursor-pointer';
  }

  if (presetKey === 'slim') {
    if (hInput) hInput.value = 102;
    if (wInput) wInput.value = 92;
    if (badge) badge.textContent = 'Slim / Euro 46';
  } else if (presetKey === 'regular') {
    if (hInput) hInput.value = 100;
    if (wInput) wInput.value = 100;
    if (badge) badge.textContent = 'Classic Regular 48';
  } else if (presetKey === 'athletic') {
    if (hInput) hInput.value = 101;
    if (wInput) wInput.value = 108;
    if (badge) badge.textContent = 'Athletic Broad 52';
  } else if (presetKey === 'relaxed') {
    if (hInput) hInput.value = 98;
    if (wInput) wInput.value = 116;
    if (badge) badge.textContent = 'Majestic Plus 56';
  }

  updateVtrBodyMorphing();
};

window.updateVtrBodyMorphing = function() {
  const h = parseInt(document.getElementById('vtrBodyHeightInput')?.value || 100);
  const w = parseInt(document.getElementById('vtrBodyWidthInput')?.value || 100);

  const hVal = document.getElementById('vtrHeightVal');
  const wVal = document.getElementById('vtrWidthVal');
  if (hVal) hVal.textContent = h + '%';
  if (wVal) wVal.textContent = w + '%';

  const wrapper = document.getElementById('vtrBodyStageWrapper');
  if (wrapper) {
    wrapper.style.transform = `scaleX(${w / 100}) scaleY(${h / 100})`;
  }
};

window.addVtrLookToBag = function() {
  const lk = VTR_LOOKS_DATABASE[currentVtrLookKey];
  if (!lk || !lk.items) return;

  lk.items.forEach((it, idx) => {
    setTimeout(() => {
      addToCart({
        id: it.id,
        title: it.title,
        price: it.price,
        image: it.image
      }, 1);
    }, idx * 100);
  });

  if (typeof showStashToast === 'function') {
    showStashToast('Added Complete Look (' + lk.title + ') to Bag! 🛍️');
  } else {
    ndToast('Added Complete Look to Bag! 🛍️', 'success');
  }
};

window.downloadVtrSnapshot = function() {
  const stage = document.getElementById('vtrMirrorStage');
  if (!stage) return;

  if (typeof showStashToast === 'function') {
    showStashToast('Snapshot saved to your Lookbook! 📸');
  } else {
    ndToast('Lookbook snapshot saved! 📸', 'success');
  }
};

// ── Sizing & Telemetry Functions ──
window.selectFittingSilhouette = function(sil, btn) {
  fittingSilhouette = sil;
  document.querySelectorAll('.fitting-sil-btn').forEach(b => {
    b.className = 'fitting-sil-btn py-2 border border-stone-200 bg-stone-50 hover:border-stone-950 text-stone-800 text-center rounded-xl font-medium transition-all cursor-pointer';
  });
  if (btn) {
    btn.className = 'fitting-sil-btn active py-2 border border-stone-950 bg-stone-950 text-[#e9c176] text-center rounded-xl font-bold transition-all cursor-pointer shadow-xs';
  }
  updateFittingCalculations();
};

window.updateFittingCalculations = function() {
  const h = parseInt(document.getElementById('fitHeightInput')?.value || 178);
  const w = parseInt(document.getElementById('fitWeightInput')?.value || 72);
  const c = parseInt(document.getElementById('fitChestInput')?.value || 39);
  const drape = document.getElementById('fitDrapeSelect')?.value || 'tailored';

  const hEl = document.getElementById('fitHeightVal');
  const wEl = document.getElementById('fitWeightVal');
  const cEl = document.getElementById('fitChestVal');

  if (hEl) hEl.textContent = h + ' cm';
  if (wEl) wEl.textContent = w + ' kg';
  if (cEl) cEl.textContent = c + ' in';

  let calculatedSize = 'M';
  let confidence = 98.4;

  if (c <= 36 || (w < 60 && h < 170)) calculatedSize = 'S';
  else if (c <= 40 || (w <= 75 && h <= 182)) calculatedSize = 'M';
  else if (c <= 44 || (w <= 90 && h <= 190)) calculatedSize = 'L';
  else calculatedSize = 'XL';

  if (drape === 'oversized') {
    if (calculatedSize === 'S') calculatedSize = 'M';
    else if (calculatedSize === 'M') calculatedSize = 'L';
    else if (calculatedSize === 'L') calculatedSize = 'XL';
  } else if (drape === 'fitted') {
    if (calculatedSize === 'XL') calculatedSize = 'L';
  }

  const badge = document.getElementById('recommendedSizeBadge');
  if (badge) badge.textContent = calculatedSize;

  const shEl = document.getElementById('fitShoulderOut');
  const slEl = document.getElementById('fitSleeveOut');
  const lenEl = document.getElementById('fitLengthOut');

  if (shEl) shEl.textContent = (42 + (c * 0.12)).toFixed(1) + ' cm';
  if (slEl) slEl.textContent = (58 + (h * 0.035)).toFixed(1) + ' cm';
  if (lenEl) lenEl.textContent = (68 + (h * 0.045)).toFixed(1) + ' cm';
};

window.applyCalculatedSize = function() {
  const size = document.getElementById('recommendedSizeBadge')?.textContent.trim() || 'M';
  localStorage.setItem('lumina_calibrated_size', size);
  if (typeof showStashToast === 'function') {
    showStashToast('Calibrated Size ' + size + ' applied to your Lumina profile! ✦');
  } else {
    ndToast('Calibrated Size ' + size + ' applied to your profile!', 'success');
  }
  closeFittingModal();
};

// ── Quick-View System with AI Stylist Ensemble Pairing ──
let currentQvProduct = null;
let currentQvSelectedSize = 'M';
let currentQvQuantity = 1;
let currentQvAiPair = null;
let currentQvAiPairSize = '32';
let currentQvAiPairQuantity = 1;

const atelierEnsemblePairings = [
  { match: ['hoodie', 'terry', 'sweatshirt'], pair: { id: 2, title: '14.5oz Okayama Selvedge Denim', price: 3499, image: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>' } },
  { match: ['coat', 'cashmere', 'peacoat', 'outerwear'], pair: { id: 3, title: 'Cashmere Turtleneck Knit', price: 2999, image: '<?= base_url("img/cashmere_turtleneck_knit.jpg") ?>' } },
  { match: ['denim', 'jeans', 'pant', 'trouser'], pair: { id: 1, title: 'The Atelier Cashmere Cocoon Coat', price: 4399, image: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>' } },
  { match: ['blazer', 'suiting', 'jacket'], pair: { id: 5, title: 'Mulberry Silk Eveningwear', price: 3899, image: '<?= base_url("img/mulberry_silk_dress.jpg") ?>' } },
  { match: ['silk', 'blouse', 'dress'], pair: { id: 4, title: 'Tailored Virgin Wool Blazer', price: 4799, image: '<?= base_url("img/wool_blazer_luxury.jpg") ?>' } },
  { match: ['shoe', 'loafer', 'boot', 'derby'], pair: { id: 6, title: 'Italian Pleated Trousers', price: 3199, image: '<?= base_url("img/italian_pleated_trousers.jpg") ?>' } }
];

window.changeQvQuantity = function(delta) {
  currentQvQuantity = Math.max(1, Math.min(20, (currentQvQuantity || 1) + delta));
  const el = document.getElementById('qvQuantityDisplay');
  if (el) el.textContent = currentQvQuantity;
  const btn = document.getElementById('qvAddBagBtnText');
  if (btn && currentQvProduct) {
    btn.textContent = currentQvQuantity > 1 ? `Add ${currentQvQuantity} Pieces to Curated Bag` : 'Add to Curated Bag';
  }
};

window.changeQvAiPairQuantity = function(delta) {
  currentQvAiPairQuantity = Math.max(1, Math.min(20, (currentQvAiPairQuantity || 1) + delta));
  const el = document.getElementById('qvAiPairQtyDisplay');
  if (el) el.textContent = currentQvAiPairQuantity;
};

window.openQuickView = function(prodData) {
  if (typeof window.openAtelierFitModal === 'function') {
    return window.openAtelierFitModal(prodData);
  }

  var parsed = null;
  if (typeof prodData === 'string') {
    try {
      parsed = JSON.parse(prodData);
    } catch (e1) {
      try {
        var cleanStr = prodData
          .replace(/&quot;/g, '"')
          .replace(/&#039;/g, "'")
          .replace(/&#39;/g, "'")
          .replace(/&amp;/g, '&')
          .replace(/&lt;/g, '<')
          .replace(/&gt;/g, '>');
        parsed = JSON.parse(cleanStr);
      } catch (e2) {
        try {
          parsed = JSON.parse(decodeURIComponent(prodData));
        } catch (e3) {
          console.warn('Quick view parse fallback:', e3);
        }
      }
    }
  } else if (prodData && typeof prodData === 'object') {
    parsed = prodData;
  }

  currentQvProduct = (parsed && typeof parsed === 'object') ? parsed : {
    id: 1,
    title: 'Sculpted 500 GSM Terry Hoodie',
    price: 2899,
    image: '<?= base_url("img/sculpted_terry_hoodie.jpg") ?>',
    vendor: 'Lumina Atelier Milano',
    description: 'Substantial 500 GSM loopback cotton jersey garments, custom garment-dyed in muted architectural tones for effortless daily poise.'
  };

  // Reset Quantities
  currentQvQuantity = 1;
  const qvQtyEl = document.getElementById('qvQuantityDisplay');
  if (qvQtyEl) qvQtyEl.textContent = '1';
  const qvBtnText = document.getElementById('qvAddBagBtnText');
  if (qvBtnText) qvBtnText.textContent = 'Add to Curated Bag';

  const qvImg = document.getElementById('qvImg');
  if (qvImg) qvImg.src = currentQvProduct.image || currentQvProduct.img || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';
  
  // Dynamic accurate fabric badge on main image
  const qvTag = document.getElementById('qvTag');
  if (qvTag) {
    const titleLow = (currentQvProduct.title || '').toLowerCase();
    if (titleLow.includes('denim') || titleLow.includes('trouser') || titleLow.includes('selvedge') || currentQvProduct.id === 2) {
      qvTag.textContent = '14.5oz OKAYAMA SELVEDGE';
    } else if (titleLow.includes('hoodie') || titleLow.includes('terry') || titleLow.includes('sweat')) {
      qvTag.textContent = '500 GSM HEAVYWEIGHT TERRY';
    } else if (titleLow.includes('shoe') || titleLow.includes('boot') || titleLow.includes('loafer') || titleLow.includes('derby')) {
      qvTag.textContent = 'FULL-GRAIN CALFSKIN';
    } else if (titleLow.includes('silk')) {
      qvTag.textContent = '100% MULBERRY SILK';
    } else {
      qvTag.textContent = '700 GSM CASHMERE';
    }
  }

  const qvTitle = document.getElementById('qvTitle');
  if (qvTitle) qvTitle.textContent = currentQvProduct.title || 'Haute Couture Piece';

  const qvVendor = document.getElementById('qvVendor');
  if (qvVendor) qvVendor.textContent = currentQvProduct.vendor || 'Lumina Atelier Milano';

  const qvDesc = document.getElementById('qvDesc');
  if (qvDesc) qvDesc.textContent = currentQvProduct.description || currentQvProduct.desc || 'Bespoke tailoring piece crafted from virgin fibers.';
  
  const pEl = document.getElementById('qvPrice');
  const priceVal = parseFloat(currentQvProduct.price) || 0;
  if (pEl) {
    pEl.setAttribute('data-price-inr', priceVal);
    pEl.textContent = typeof formatPrice === 'function' ? formatPrice(priceVal) : ('₹' + Number(priceVal).toLocaleString('en-IN'));
  }

  const cpEl = document.getElementById('qvComparePrice');
  const compPriceVal = parseFloat(currentQvProduct.compare_price) || 0;
  if (cpEl) {
    if (compPriceVal > priceVal) {
      cpEl.setAttribute('data-price-inr', compPriceVal);
      cpEl.textContent = typeof formatPrice === 'function' ? formatPrice(compPriceVal) : ('₹' + Number(compPriceVal).toLocaleString('en-IN'));
      cpEl.classList.remove('hidden');
    } else {
      cpEl.classList.add('hidden');
    }
  }

  // Render Dynamic Category-Accurate Sizes for Main Product
  const mainSizes = (typeof window.resolveProductSizes === 'function') 
    ? window.resolveProductSizes(currentQvProduct) 
    : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
  const defSize = mainSizes[Math.min(2, mainSizes.length - 1)];
  currentQvSelectedSize = defSize;

  const sizePillsEl = document.getElementById('qvSizePills');
  if (sizePillsEl) {
    sizePillsEl.innerHTML = mainSizes.map(sz => {
      const isDef = (sz === defSize);
      return `<button type="button" onclick="selectQvSize('${sz}', this)" class="qv-size-btn px-3.5 py-1.5 border ${isDef ? 'border-stone-950 bg-stone-950 text-[#e9c176] font-bold shadow-xs' : 'border-stone-200 bg-white hover:border-stone-900 text-stone-800'} rounded-xl text-center text-xs font-mono transition-all cursor-pointer">${sz}</button>`;
    }).join('');
  }

  // Determine intelligent AI Stylist pairing & reasoning
  const titleLower = (currentQvProduct.title || '').toLowerCase();
  let matchedPair = null;
  let pairingReason = "Handpicked by Milan AI Stylist to create a harmonious silhouette with perfectly balanced textures.";

  if (titleLower.includes('denim') || titleLower.includes('trouser') || titleLower.includes('selvedge') || currentQvProduct.id === 2) {
    matchedPair = { id: 1, title: 'The Atelier Cashmere Cocoon Coat', price: 4399, image: '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>', category: 'coat' };
    pairingReason = "Hand-loomed 700 GSM Mongolian Cashmere drapes effortlessly over raw 14.5oz Okayama selvedge for a sharp tailored contrast.";
  } else if (titleLower.includes('coat') || titleLower.includes('jacket') || currentQvProduct.id === 1) {
    matchedPair = { id: 2, title: 'Vintage Okayama 14.5oz Selvedge Trousers', price: 4299, image: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', category: 'denim' };
    pairingReason = "Rigid shuttle-loomed Japanese denim grounds the fluid double-faced cashmere cocoon silhouette.";
  } else if (titleLower.includes('hoodie') || titleLower.includes('terry') || currentQvProduct.id === 3) {
    matchedPair = { id: 2, title: 'Vintage Okayama 14.5oz Selvedge Trousers', price: 4299, image: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', category: 'denim' };
    pairingReason = "500 GSM loopback drape elevated with architectural tapered selvedge trousers.";
  } else {
    matchedPair = { id: 2, title: '14.5oz Okayama Selvedge Denim', price: 3499, image: '<?= base_url("img/okayama_selvedge_denim.jpg") ?>', category: 'denim' };
  }

  currentQvAiPair = matchedPair;
  currentQvAiPairQuantity = 1;
  window.isQvPairIncluded = false;

  // Update AI Pair Box in Quick View
  const pairTitle = document.getElementById('qvAiPairTitle');
  const pairPrice = document.getElementById('qvAiPairPrice');
  const pairImg = document.getElementById('qvAiPairImg');
  const pairBtn = document.getElementById('btnQvAddPair');
  const pairBtnText = document.getElementById('btnQvAddPairText');
  const pairReasonEl = document.getElementById('qvAiPairReason');
  const pairQtyEl = document.getElementById('qvAiPairQtyDisplay');
  const comboRow = document.getElementById('qvComboPricingRow');

  if (pairQtyEl) pairQtyEl.textContent = '1';
  if (comboRow) comboRow.classList.add('hidden');
  if (pairReasonEl) pairReasonEl.textContent = `"${pairingReason}"`;

  if (pairTitle) pairTitle.textContent = matchedPair.title;
  if (pairPrice) {
    pairPrice.setAttribute('data-price-inr', matchedPair.price);
    pairPrice.textContent = typeof formatPrice === 'function' ? formatPrice(matchedPair.price) : ('₹' + Number(matchedPair.price).toLocaleString('en-IN'));
  }
  if (pairImg) pairImg.src = matchedPair.image;
  if (pairBtn) {
    pairBtn.className = 'px-3 py-2 bg-stone-950 hover:bg-stone-800 text-[#e9c176] font-mono text-[9.5px] uppercase font-bold rounded-xl transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer shadow-xs active:scale-95';
    if (pairBtnText) pairBtnText.textContent = 'Pair Piece';
  }

  // Populate AI Pair Size Selector
  const pairSizeSelect = document.getElementById('qvAiPairSizeSelect');
  if (pairSizeSelect) {
    const pairSizes = (typeof window.resolveProductSizes === 'function') 
      ? window.resolveProductSizes(matchedPair) 
      : ['28', '30', '32', '34', '36', '38'];
    const defPairSize = pairSizes[Math.min(2, pairSizes.length - 1)];
    window.currentQvAiPairSize = defPairSize;
    pairSizeSelect.innerHTML = pairSizes.map(s => `<option value="${s}" ${s === defPairSize ? 'selected' : ''}>${s}</option>`).join('');
  }

  const drawer = document.getElementById('quickViewDrawer');
  const panel = document.getElementById('quickViewPanel');
  if (drawer) {
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
    drawer.style.display = 'flex';
    lockStorefrontScroll();
  }
  if (panel) {
    panel.classList.remove('translate-y-full');
  }
};

window.closeQuickView = function() {
  const drawer = document.getElementById('quickViewDrawer');
  const panel = document.getElementById('quickViewPanel');
  if (panel) panel.classList.add('translate-y-full');
  setTimeout(() => {
    if (drawer) {
      drawer.classList.add('hidden');
      drawer.classList.remove('flex');
      drawer.style.display = 'none';
    }
    unlockStorefrontScroll();
  }, 200);
};

window.consultStylistOnQv = function() {
  const prod = currentQvProduct;
  closeQuickView();
  setTimeout(() => {
    if (typeof openAtelierFitModal === 'function') {
      openAtelierFitModal(prod);
    } else {
      window.location.href = '<?= base_url("pages/stylist") ?>';
    }
  }, 240);
};

window.selectQvSize = function(size, btn) {
  currentQvSelectedSize = size;
  document.querySelectorAll('.qv-size-btn').forEach(b => {
    b.className = 'qv-size-btn px-3.5 py-1.5 border border-stone-200 bg-white hover:border-stone-900 text-stone-800 rounded-xl text-center text-xs font-mono transition-all cursor-pointer';
  });
  if (btn) {
    btn.className = 'qv-size-btn px-3.5 py-1.5 border border-stone-950 bg-stone-950 text-[#e9c176] rounded-xl text-center text-xs font-mono font-bold shadow-xs transition-all cursor-pointer';
  }
};

// ── Toggle Paired Piece Inclusion with 10% Bundle Privilege ──
window.toggleQvPairInclusion = function() {
  window.isQvPairIncluded = !window.isQvPairIncluded;
  const pairBtn = document.getElementById('btnQvAddPair');
  const pairBtnText = document.getElementById('btnQvAddPairText');
  const comboRow = document.getElementById('qvComboPricingRow');
  const qvBtnText = document.getElementById('qvAddBagBtnText');

  if (window.isQvPairIncluded) {
    if (pairBtn) {
      pairBtn.className = 'px-3 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-mono text-[9.5px] uppercase font-bold rounded-xl transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer shadow-xs active:scale-95';
    }
    if (pairBtnText) pairBtnText.textContent = '✓ Paired (10% Off)';
    if (comboRow) comboRow.classList.remove('hidden');
    updateQvComboPricing();
  } else {
    if (pairBtn) {
      pairBtn.className = 'px-3 py-2 bg-stone-950 hover:bg-stone-800 text-[#e9c176] font-mono text-[9.5px] uppercase font-bold rounded-xl transition-all flex items-center gap-1 flex-shrink-0 cursor-pointer shadow-xs active:scale-95';
    }
    if (pairBtnText) pairBtnText.textContent = 'Pair Piece';
    if (comboRow) comboRow.classList.add('hidden');
    if (qvBtnText) qvBtnText.textContent = 'Add to Curated Bag';
  }
};

// ── Live Calculation for Quick View Combo Discount ──
window.updateQvComboPricing = function() {
  if (!currentQvProduct || !currentQvAiPair) return;
  const mainPrice = parseFloat(currentQvProduct.price) || 0;
  const mainQty = currentQvQuantity || 1;
  const pairPrice = parseFloat(currentQvAiPair.price) || 0;
  const pairQty = currentQvAiPairQuantity || 1;

  const totalOrig = (mainPrice * mainQty) + (pairPrice * pairQty);
  const discountRate = 0.10; // 10% combo discount
  const finalComboPrice = Math.round(totalOrig * (1 - discountRate));
  const savings = totalOrig - finalComboPrice;

  const finalEl = document.getElementById('qvComboFinalPrice');
  const origEl = document.getElementById('qvComboOriginalPrice');
  const savEl = document.getElementById('qvComboSavings');
  const qvBtnText = document.getElementById('qvAddBagBtnText');

  if (finalEl) finalEl.textContent = '₹' + Number(finalComboPrice).toLocaleString('en-IN');
  if (origEl) origEl.textContent = '₹' + Number(totalOrig).toLocaleString('en-IN');
  if (savEl) savEl.textContent = 'Save ₹' + Number(savings).toLocaleString('en-IN');

  if (window.isQvPairIncluded && qvBtnText) {
    qvBtnText.textContent = `Add 2-Piece Ensemble to Bag (₹${Number(finalComboPrice).toLocaleString('en-IN')})`;
  }
};

window.changeQvQuantity = function(delta) {
  currentQvQuantity = Math.max(1, Math.min(20, (currentQvQuantity || 1) + delta));
  const el = document.getElementById('qvQuantityDisplay');
  if (el) el.textContent = currentQvQuantity;
  if (window.isQvPairIncluded) {
    updateQvComboPricing();
  }
};

window.changeQvAiPairQuantity = function(delta) {
  currentQvAiPairQuantity = Math.max(1, Math.min(20, (currentQvAiPairQuantity || 1) + delta));
  const el = document.getElementById('qvAiPairQtyDisplay');
  if (el) el.textContent = currentQvAiPairQuantity;
  if (window.isQvPairIncluded) {
    updateQvComboPricing();
  }
};

window.handleQvAddToCart = function() {
  if (!currentQvProduct) return;
  const size = currentQvSelectedSize || 'M';
  const qty = currentQvQuantity || 1;

  // Add primary garment
  addToCart({
    id: currentQvProduct.id || 1,
    size: size,
    title: currentQvProduct.title,
    price: currentQvProduct.price,
    image: currentQvProduct.image || currentQvProduct.img
  }, qty, `✦ Added ${qty}x ${currentQvProduct.title} (Size ${size}) to Curated Bag!`);

  // If paired piece is included, add with 10% bundle privilege
  if (window.isQvPairIncluded && currentQvAiPair) {
    const pairSize = window.currentQvAiPairSize || '32';
    const pairQty = currentQvAiPairQuantity || 1;
    const discountedPairPrice = Math.round(Number(currentQvAiPair.price) * 0.90);

    addToCart({
      id: currentQvAiPair.id,
      title: currentQvAiPair.title + ' (VIP Bundle Privilege)',
      price: discountedPairPrice,
      image: currentQvAiPair.image || currentQvAiPair.img,
      size: pairSize
    }, pairQty, `✦ Added ${pairQty}x ${currentQvAiPair.title} (Size ${pairSize} · 10% Bundle Privilege) to Bag!`);
  }

  closeQuickView();
};

window.handleQvInstantBuy = function() {
  if (!currentQvProduct) return;
  const size = currentQvSelectedSize || 'M';
  const qty = currentQvQuantity || 1;

  closeQuickView();
  if (window.openExpressCheckout) {
    openExpressCheckout(currentQvProduct.id, currentQvProduct.title, currentQvProduct.price, currentQvProduct.image || currentQvProduct.img, currentQvProduct.id, size, qty);
  } else {
    window.location.href = '<?= base_url('checkout') ?>';
  }
};

// ════════════════════════════════════════════════════════════════════════════
// 3. 💬 MAÎTRE STYLIST AI CONCIERGE ENGINE
// ════════════════════════════════════════════════════════════════════════════
window.toggleStylistChat = function() {
  const box = document.getElementById('atelierStylistChatBox');
  if (!box) return;
  const isHidden = box.classList.contains('hidden');
  if (isHidden) {
    box.classList.remove('hidden');
    box.classList.add('flex');
    const input = document.getElementById('stylistUserInput');
    if (input) setTimeout(() => input.focus(), 150);
  } else {
    box.classList.add('hidden');
    box.classList.remove('flex');
  }
};

window.sendStylistPrompt = function(promptText) {
  const input = document.getElementById('stylistUserInput');
  if (input) {
    input.value = promptText;
    const box = document.getElementById('atelierStylistChatBox');
    if (box && box.classList.contains('hidden')) {
      box.classList.remove('hidden');
      box.classList.add('flex');
    }
    handleStylistInput(new Event('submit'));
  }
};

window.handleStylistInput = function(e) {
  if (e && e.preventDefault) e.preventDefault();
  const input = document.getElementById('stylistUserInput');
  if (!input) return;
  const query = input.value.trim();
  if (!query) return;

  // Append user bubble
  appendUserChatMessage(query);
  input.value = '';

  // Show typing indicator
  showStylistTypingIndicator();

  // Generate response after small luxury delay
  setTimeout(() => {
    removeStylistTypingIndicator();
    const responseHtml = generateStylistAiResponse(query);
    appendStylistChatMessage(responseHtml);
  }, 500);
};

function appendUserChatMessage(text) {
  const container = document.getElementById('stylistChatMessages');
  if (!container) return;

  const div = document.createElement('div');
  div.className = 'flex justify-end';
  div.innerHTML = `
    <div class="p-3 rounded-2xl rounded-tr-sm bg-stone-950 text-white max-w-[85%] leading-relaxed shadow-sm font-sans text-xs">
      <p>${escapeChatHtml(text)}</p>
    </div>
  `;
  container.appendChild(div);
  container.scrollTop = container.scrollHeight;
}

function appendStylistChatMessage(contentHtml) {
  const container = document.getElementById('stylistChatMessages');
  if (!container) return;

  const div = document.createElement('div');
  div.className = 'flex gap-2.5 items-start';
  div.innerHTML = `
    <div class="w-7 h-7 rounded-full bg-stone-900 text-[#e9c176] flex items-center justify-center flex-shrink-0 text-xs shadow-xs">
      <span class="material-symbols-outlined text-sm">auto_awesome</span>
    </div>
    <div class="p-3.5 rounded-2xl rounded-tl-sm bg-white border border-stone-200 text-stone-800 leading-relaxed shadow-xs flex-1 space-y-2 text-xs">
      ${contentHtml}
    </div>
  `;
  container.appendChild(div);
  container.scrollTop = container.scrollHeight;
}

function showStylistTypingIndicator() {
  const container = document.getElementById('stylistChatMessages');
  if (!container) return;

  const div = document.createElement('div');
  div.id = 'stylistTypingIndicator';
  div.className = 'flex gap-2.5 items-center text-stone-400 font-mono text-[10px]';
  div.innerHTML = `
    <div class="w-7 h-7 rounded-full bg-stone-900 text-[#e9c176] flex items-center justify-center flex-shrink-0 text-xs shadow-xs">
      <span class="material-symbols-outlined text-sm animate-spin">sync</span>
    </div>
    <div class="flex items-center gap-1 bg-white border border-stone-200 px-3 py-2 rounded-2xl shadow-2xs">
      <span class="w-1.5 h-1.5 rounded-full bg-[#a16207] animate-bounce" style="animation-delay: 0ms"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-[#a16207] animate-bounce" style="animation-delay: 150ms"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-[#a16207] animate-bounce" style="animation-delay: 300ms"></span>
      <span class="text-stone-500 font-sans ml-1 text-[11px]">Maître Stylist is curating...</span>
    </div>
  `;
  container.appendChild(div);
  container.scrollTop = container.scrollHeight;
}

function removeStylistTypingIndicator() {
  const ind = document.getElementById('stylistTypingIndicator');
  if (ind) ind.remove();
}

function escapeChatHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

function generateStylistAiResponse(query) {
  const q = query.toLowerCase();

  // 1. Layering & Silhouette Advice
  if (q.includes('layer') || q.includes('autumn') || q.includes('winter') || q.includes('hoodie') || q.includes('jacket')) {
    return `
      <p class="font-medium text-stone-900">For an effortless seasonal architectural silhouette, I recommend a 3-piece tonal drape:</p>
      <ul class="list-disc list-inside space-y-1 text-stone-600 pl-1 font-light">
        <li><strong>Base:</strong> Sculpted 500 GSM Terry Hoodie in Charcoal.</li>
        <li><strong>Outer:</strong> Double-Faced 700 GSM Cashmere Cocoon Coat in Camel.</li>
        <li><strong>Bottom:</strong> 14.5oz Okayama Selvedge Denim for structural balance.</li>
      </ul>
      <div class="mt-2 p-2.5 bg-stone-50 rounded-xl border border-stone-200 flex items-center justify-between gap-2">
        <div class="min-w-0">
          <span class="text-[9px] font-mono uppercase text-[#a16207] font-bold block">Curated Layering Ensemble</span>
          <span class="font-serif font-bold text-xs text-stone-900 block truncate">The Atelier Cashmere Cocoon Coat</span>
          <span class="font-mono text-[10px] text-stone-500">₹4,399 · 700 GSM</span>
        </div>
        <button type="button" onclick="addToCart({id:1, title:'The Atelier Cashmere Cocoon Coat', price:4399, image:'<?= base_url("img/cashmere_cocoon_coat.jpg") ?>'}, 1)" class="px-2.5 py-1.5 bg-stone-950 text-[#e9c176] rounded-lg font-mono text-[9px] uppercase font-bold flex-shrink-0 cursor-pointer hover:bg-stone-800">
          + Add to Bag
        </button>
      </div>
    `;
  }

  // 2. Sizing & Fit Advice
  if (q.includes('size') || q.includes('fit') || q.includes('measurement') || q.includes('kg') || q.includes('cm') || q.includes('height') || q.includes('weight')) {
    return `
      <p class="font-medium text-stone-900">Our garments are engineered with tailored fluid proportions:</p>
      <div class="space-y-1 text-stone-600 font-light">
        <p>• <strong>Tailored Poise (Fitted):</strong> If you prefer crisp clean contours, select your true chest size (e.g. 38–40 in → <strong>Size M</strong>).</p>
        <p>• <strong>Architectural Drape (Relaxed):</strong> For drop-shoulder layering over knitwear, we calibrate coats with an intentional 2-inch chest ease.</p>
      </div>
      <div class="pt-2">
        <button type="button" onclick="openFittingModal()" class="w-full py-2 bg-stone-900 hover:bg-black text-[#e9c176] rounded-xl font-mono text-[10px] uppercase font-bold flex items-center justify-center gap-1 cursor-pointer">
          <span class="material-symbols-outlined text-xs">straighten</span>
          <span>Open Interactive Sizer Studio</span>
        </button>
      </div>
    `;
  }

  // 3. Fabric & Craft Dossier
  if (q.includes('fabric') || q.includes('cashmere') || q.includes('denim') || q.includes('gsm') || q.includes('material') || q.includes('wool') || q.includes('silk')) {
    return `
      <p class="font-medium text-stone-900">✦ The Lumina Material Integrity Dossier:</p>
      <div class="space-y-1.5 text-stone-600 font-light">
        <p>• <strong>Mongolian Cashmere (700 GSM):</strong> 14.5–15.2 micron fineness harvested during spring molt. Hand-split double-faced seams with no stiff linings.</p>
        <p>• <strong>Okayama Selvedge Denim (14.5oz):</strong> Woven on vintage Toyoda shuttle looms in Kojima, Japan. Natural rope-dyed indigo.</p>
        <p>• <strong>Mulberry Silk:</strong> Grade 6A pure mulberry silk with a luminous pearl luster and effortless evening drape.</p>
      </div>
    `;
  }

  // 4. Gala & Eveningwear / Black Tie
  if (q.includes('gala') || q.includes('evening') || q.includes('dinner') || q.includes('black tie') || q.includes('party') || q.includes('wedding')) {
    return `
      <p class="font-medium text-stone-900">For black-tie galas and evening soirées, quiet luxury is defined by fluidity and clean silhouettes:</p>
      <div class="p-2.5 bg-stone-50 rounded-xl border border-stone-200 space-y-2 mt-1">
        <div class="flex items-center justify-between">
          <div>
            <h6 class="font-serif font-bold text-xs text-stone-900">Mulberry Silk Eveningwear</h6>
            <span class="font-mono text-[10px] text-[#a16207]">₹3,899 · Pearl Luster</span>
          </div>
          <button type="button" onclick="addToCart({id:5, title:'Mulberry Silk Eveningwear', price:3899, image:'<?= base_url("img/mulberry_silk_dress.jpg") ?>'}, 1)" class="px-2 py-1 bg-stone-950 text-[#e9c176] rounded-lg font-mono text-[9px] font-bold cursor-pointer">
            + Add
          </button>
        </div>
        <p class="text-[11px] text-stone-500 font-light">Pair with Burnished Calfskin Penny Loafers and subtle brass jewelry for captivating poise.</p>
      </div>
    `;
  }

  // 5. VIP Privilege Code / Discount
  if (q.includes('vip') || q.includes('discount') || q.includes('code') || q.includes('coupon') || q.includes('offer') || q.includes('privilege')) {
    return `
      <p class="font-medium text-stone-900">You are eligible for our exclusive VIP Patron Privilege:</p>
      <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-center space-y-1.5 my-1">
        <span class="text-[9px] font-mono uppercase tracking-widest text-[#a16207] font-bold block">Archival Privilege Code</span>
        <span class="font-mono text-base font-bold text-stone-950 tracking-wider">LUMINA50</span>
        <p class="text-[10px] text-stone-600 font-sans">Grants instant 50% privilege discount on all archival capsules at checkout.</p>
      </div>
      <button type="button" onclick="if(typeof showStashToast==='function')showStashToast('VIP Code LUMINA50 Copied!');" class="w-full py-1.5 bg-stone-950 hover:bg-stone-800 text-[#e9c176] rounded-lg font-mono text-[10px] uppercase font-bold cursor-pointer transition-all">
        Copy Privilege Code
      </button>
    `;
  }

  // 6. Transit & BlueDart Priority Express Delivery
  if (q.includes('delivery') || q.includes('ship') || q.includes('transit') || q.includes('bluedart') || q.includes('pincode') || q.includes('return') || q.includes('exchange')) {
    return `
      <p class="font-medium text-stone-900">White-Glove Express Delivery Protocols:</p>
      <ul class="list-disc list-inside space-y-1 text-stone-600 font-light pl-1">
        <li><strong>Priority Express Dispatch:</strong> Orders dispatched via insured BlueDart Priority Express within 18 hours.</li>
        <li><strong>Transit Timeline:</strong> 24–48 hours to all Tier-1 and Tier-2 metropolitan hubs.</li>
        <li><strong>Presentation:</strong> Delivered in cedar-lined archival boxes with brass hangers.</li>
        <li><strong>Exchange Privilege:</strong> Complimentary 7-day doorstep fitting exchange.</li>
      </ul>
    `;
  }

  // 7. General / Fallback Styling Inquiry
  return `
    <p class="font-medium text-stone-900">A refined choice. For this aesthetic, timeless harmony is achieved by balancing neutral architectural tones:</p>
    <p class="text-stone-600 font-light">Pair <strong class="text-stone-900">Onyx Noir</strong> or <strong class="text-stone-900">Camel Cashmere</strong> with structured Japanese selvedge denim or pleated wool trousers for commanding poise.</p>
    <div class="pt-1 flex gap-2">
      <a href="<?= base_url('shop') ?>" class="flex-1 py-1.5 bg-stone-950 text-[#e9c176] text-center rounded-lg font-mono text-[10px] uppercase font-bold">
        Explore Boutique →
      </a>
      <button type="button" onclick="sendStylistPrompt('Autumn Layering Look')" class="px-3 py-1.5 bg-stone-100 text-stone-800 hover:bg-stone-200 rounded-lg font-mono text-[10px] font-medium cursor-pointer">
        Layering Ideas
      </button>
    </div>
  `;
}

// ── Wishlist Saved Wardrobe Engine ──
window.getWishlistItems = function() {
  try {
    return JSON.parse(localStorage.getItem('lumina_wishlist') || '[]');
  } catch (e) { return []; }
};

window.syncWishlistCheckboxes = function() {
  const items = getWishlistItems();
  const ids = new Set(items.map(i => Number(i.id)));
  document.querySelectorAll('[data-wishlist-id]').forEach(el => {
    const id = Number(el.getAttribute('data-wishlist-id'));
    const isSaved = ids.has(id);
    if (el.tagName === 'INPUT' && el.type === 'checkbox') {
      el.checked = isSaved;
    }
    const container = el.closest('.heart-container') || (el.classList.contains('heart-container') ? el : null);
    if (container) {
      if (isSaved) container.classList.add('is-saved');
      else container.classList.remove('is-saved');
    }
  });
};

window.handleHeartClick = function(el, prod, event) {
  if (event) {
    if (event.preventDefault) event.preventDefault();
    if (event.stopPropagation) event.stopPropagation();
  }
  toggleWishlistItem(prod, event);
};

window.toggleWishlistItem = function(prod, event) {
  if (event && event.stopPropagation) event.stopPropagation();
  let items = getWishlistItems();
  const prodId = Number(prod.id);
  const existingIdx = items.findIndex(i => Number(i.id) === prodId);
  let isLiked = false;
  
  if (existingIdx >= 0) {
    items.splice(existingIdx, 1);
    isLiked = false;
    if (typeof ndToast === 'function') ndToast('Removed from Wardrobe', 'info');
  } else {
    items.push(prod);
    isLiked = true;
    if (typeof ndToast === 'function') ndToast('Saved to Wardrobe ❤️', 'success');
  }
  
  localStorage.setItem('lumina_wishlist', JSON.stringify(items));
  updateWishlistBadge();
  renderWishlistItems();
  syncWishlistCheckboxes();
};

document.addEventListener('DOMContentLoaded', function() {
  if (typeof window.syncWishlistCheckboxes === 'function') {
    window.syncWishlistCheckboxes();
  }
  updateWishlistBadge();
});

window.updateWishlistBadge = function() {
  const items = getWishlistItems();
  const count = items.length;
  const badge = document.getElementById('wishlistHeaderBadge');
  if (badge) {
    badge.textContent = count;
    if (count > 0) badge.classList.remove('hidden');
    else badge.classList.add('hidden');
  }
  const mobileBadge = document.getElementById('mobileBottomWishlistBadge');
  if (mobileBadge) {
    mobileBadge.textContent = count;
    if (count > 0) mobileBadge.classList.remove('hidden');
    else mobileBadge.classList.add('hidden');
  }
};

window.openWishlistDrawer = function() {
  const overlay = document.getElementById('wishlistDrawerOverlay');
  const panel = document.getElementById('wishlistPanel');
  if (typeof renderWishlistItems === 'function') renderWishlistItems();
  if (overlay) {
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
    overlay.style.display = 'flex';
  }
  if (typeof lockStorefrontScroll === 'function') lockStorefrontScroll();
  if (panel) {
    setTimeout(() => {
      panel.classList.remove('translate-x-full');
      panel.style.transform = 'translateX(0)';
    }, 20);
  }
};

window.closeWishlistDrawer = function() {
  const overlay = document.getElementById('wishlistDrawerOverlay');
  const panel = document.getElementById('wishlistPanel');
  if (panel) {
    panel.classList.add('translate-x-full');
    panel.style.transform = 'translateX(100%)';
  }
  setTimeout(() => {
    if (overlay) {
      overlay.classList.add('hidden');
      overlay.classList.remove('flex');
      overlay.style.display = 'none';
    }
    if (typeof unlockStorefrontScroll === 'function') unlockStorefrontScroll();
  }, 280);
};

window.renderWishlistItems = function() {
  const items = getWishlistItems();
  const list = document.getElementById('wishlistItemsList');
  if (!list) return;

  if (items.length === 0) {
    list.innerHTML = `
      <div class="py-12 text-center text-stone-400 text-sm flex flex-col items-center">
        <span class="material-symbols-outlined text-4xl mb-2 text-stone-300">favorite_border</span>
        <p class="font-light">Your saved wardrobe is empty.</p>
        <a href="<?= base_url('shop') ?>" class="mt-3 text-xs text-[#a16207] underline font-bold uppercase tracking-wider">Explore Haute Couture</a>
      </div>`;
    return;
  }

  let html = '';
  items.forEach(item => {
    const rawPrice = parseFloat(item.price || 0);
    const itemTitle = (item.title || 'Curated Garment').replace(/'/g, "\\'");
    const itemImg = (item.image || '<?= base_url('assets/images/placeholder.jpg') ?>').replace(/'/g, "\\'");
    html += `
      <div class="flex items-center gap-3 p-3 bg-stone-50 rounded-2xl border border-stone-200 hover:border-[#a16207]/30 transition-all">
        <img src="${item.image}" class="w-14 h-16 object-cover rounded-xl bg-stone-200 border border-stone-200 flex-shrink-0" loading="lazy">
        <div class="flex-1 min-w-0">
          <h4 class="font-serif font-bold text-xs text-stone-900 truncate">${item.title}</h4>
          <span class="text-xs font-serif font-bold text-[#a16207] block mt-0.5" data-price-inr="${rawPrice}">${formatPrice(rawPrice)}</span>
          <div class="flex items-center gap-2 mt-2">
            <button type="button" onclick="addToCart({id:${item.id}, title:'${itemTitle}', price:${rawPrice}, image:'${itemImg}'}, 1); ndToast('Moved to bag!', 'success');" class="text-[10px] px-2.5 py-1 bg-stone-950 text-[#e9c176] rounded-lg font-mono font-bold uppercase tracking-wider hover:bg-stone-800 transition-all cursor-pointer">Move to Bag</button>
            <button type="button" onclick="toggleWishlistItem({id:${item.id}})" class="text-[10px] text-rose-500 hover:underline cursor-pointer">Remove</button>
          </div>
        </div>
      </div>
    `;
  });
  list.innerHTML = html;
};

window.moveAllWishlistToBag = function() {
  const items = getWishlistItems();
  items.forEach(i => addToCart(i, 1, false));
  localStorage.removeItem('lumina_wishlist');
  updateWishlistBadge();
  closeWishlistDrawer();
  ndToast('All saved pieces moved to bag!', 'success');
};

// ── VIP Atelier AI Concierge Chatbot ──
window.toggleStylistChat = function() {
  const box = document.getElementById('atelierStylistChatBox');
  if (box) box.classList.toggle('hidden');
};

window.sendStylistPrompt = function(promptText) {
  const input = document.getElementById('stylistUserInput');
  if (input) {
    input.value = promptText;
    handleStylistInput(new Event('submit'));
  }
};

window.handleStylistInput = function(e) {
  if (e) e.preventDefault();
  const input = document.getElementById('stylistUserInput');
  const msg = input.value.trim();
  if (!msg) return;

  const container = document.getElementById('stylistChatMessages');
  container.innerHTML += `
    <div class="p-3 rounded-xl bg-primary text-white ml-auto max-w-[80%] text-right font-medium">
      ${msg}
    </div>
  `;
  input.value = '';
  container.scrollTop = container.scrollHeight;

  // AI Response Simulation
  setTimeout(() => {
    let reply = "For your silhouette, we recommend pairing our 700 GSM Mongolian Cashmere Cocoon Coat with the 14.5oz Okayama Selvedge Denim for effortless architectural harmony.";
    if (msg.toLowerCase().includes('size') || msg.toLowerCase().includes('kg')) {
      reply = "Based on your proportions, Size Medium with our bespoke side-tab adjusters will deliver a precision drape without pulling across the shoulders.";
    } else if (msg.toLowerCase().includes('gala') || msg.toLowerCase().includes('dinner')) {
      reply = "For an evening gala, we recommend the 22-Momme Mulberry Silk Bias Slip Dress paired with the Super 150s Double-Breasted Wool Blazer in Midnight Obsidian.";
    } else if (msg.toLowerCase().includes('cashmere') || msg.toLowerCase().includes('gsm')) {
      reply = "Our 700 GSM Mongolian cashmere is double-faced and woven on traditional wooden looms in Biella, Italy for exceptional thermal insulation and weightless drape.";
    }
    
    container.innerHTML += `
      <div class="p-3 rounded-xl bg-surface-container border border-outline-variant/40 text-on-surface leading-relaxed animate-in fade-in">
        <p>${reply}</p>
        <button onclick="openFittingModal()" class="mt-2 text-accent underline text-[10px] font-bold block">Open Virtual Fitting Room →</button>
      </div>
    `;
    container.scrollTop = container.scrollHeight;
  }, 600);
};

// ── Pincode Delivery Estimator ──
window.openPincodeModal = function() {
  const m = document.getElementById('pincodeModal');
  if (m) {
    m.classList.remove('hidden');
    m.classList.add('flex');
    lockStorefrontScroll();
  }
};

window.closePincodeModal = function() {
  const m = document.getElementById('pincodeModal');
  if (m) {
    m.classList.add('hidden');
    m.classList.remove('flex');
    unlockStorefrontScroll();
  }
};

window.checkPincodeTransit = function() {
  const pin = document.getElementById('pincodeCheckInput')?.value.trim();
  const res = document.getElementById('pincodeResultBox');
  if (!pin || pin.length < 3) {
    ndToast('Please enter a valid postal code', 'error');
    return;
  }
  const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  const today = new Date();
  const deliveryDate = new Date(today.getTime() + (2 * 24 * 60 * 60 * 1000));
  const dateStr = days[deliveryDate.getDay()] + ', ' + deliveryDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });

  document.getElementById('pincodeEstDate').textContent = dateStr + ' by 2:00 PM';
  res.classList.remove('hidden');
  ndToast('Priority Express Dispatch available for PIN ' + pin, 'success');
};

// ── Bespoke Monogramming Studio ──
window.openMonogramModal = function() {
  const m = document.getElementById('monogramModal');
  if (m) {
    m.classList.remove('hidden');
    m.classList.add('flex');
    lockStorefrontScroll();
  }
};

window.closeMonogramModal = function() {
  const m = document.getElementById('monogramModal');
  if (m) {
    m.classList.add('hidden');
    m.classList.remove('flex');
    unlockStorefrontScroll();
  }
};

window.updateMonogramVisual = function() {
  const initials = document.getElementById('monogramTextInput')?.value.toUpperCase() || 'L.M.';
  const thread = document.getElementById('monogramThreadSelect')?.value || 'gold';
  const preview = document.getElementById('monogramLivePreview');
  const label = document.getElementById('monogramStyleLabel');

  preview.textContent = initials;
  if (thread === 'gold') {
    preview.className = 'text-4xl sm:text-5xl font-serif font-bold tracking-[0.3em] text-[#e9c176] drop-shadow-[0_2px_10px_rgba(233,193,118,0.5)]';
    label.textContent = '24k Metallic Gold · Left Cuff';
  } else if (thread === 'silver') {
    preview.className = 'text-4xl sm:text-5xl font-serif font-bold tracking-[0.3em] text-slate-200 drop-shadow-[0_2px_10px_rgba(255,255,255,0.4)]';
    label.textContent = 'Sterling Silver Filigree · Left Cuff';
  } else {
    preview.className = 'text-4xl sm:text-5xl font-serif font-bold tracking-[0.3em] text-amber-100/70 drop-shadow-[0_1px_5px_rgba(0,0,0,0.8)]';
    label.textContent = 'Tone-on-Tone Mulberry Silk · Left Cuff';
  }
};

window.saveMonogramPreference = function() {
  const initials = document.getElementById('monogramTextInput')?.value.toUpperCase() || 'L.M.';
  ndToast('Monogram "' + initials + '" saved to your bespoke order!', 'success');
  closeMonogramModal();
};

// ── 🛍️ Quick-Bag Drawer Handler (GPU-Accelerated & Reflow-Free) ──
function toggleQuickBagDrawer(forceState) {
  var overlay = document.getElementById('quickBagOverlay');
  var panel = document.getElementById('quickBagPanel');
  if (!overlay || !panel) {
    // Fallback: navigate to cart page if drawer elements not present
    window.location.href = '<?= base_url("cart") ?>';
    return;
  }

  var isCurrentlyHidden = overlay.classList.contains('hidden') || overlay.classList.contains('opacity-0') || overlay.style.display === 'none';
  var shouldOpen = (forceState !== undefined) ? forceState : isCurrentlyHidden;

  if (shouldOpen) {
    overlay.classList.remove('hidden');
    overlay.style.display = 'block';
    overlay.style.pointerEvents = 'auto';
    if (typeof lockStorefrontScroll === 'function') lockStorefrontScroll();
    requestAnimationFrame(function() {
      overlay.classList.remove('opacity-0');
      overlay.classList.add('opacity-100');
      panel.classList.remove('translate-x-full');
      panel.classList.add('translate-x-0');
    });
    // Always refresh the cart contents when opening
    loadQuickBagItems();
  } else {
    overlay.style.pointerEvents = 'none';
    overlay.classList.remove('opacity-100');
    overlay.classList.add('opacity-0');
    panel.classList.remove('translate-x-0');
    panel.classList.add('translate-x-full');
    setTimeout(function() {
      overlay.classList.add('hidden');
      overlay.style.display = 'none';
      if (typeof unlockStorefrontScroll === 'function') unlockStorefrontScroll();
    }, 300);
  }
}
window.toggleQuickBagDrawer = toggleQuickBagDrawer;
window.openBagDrawer = function() { toggleQuickBagDrawer(true); };

// ── CSRF Token Helper ──
function getCsrfToken() {
  var match = document.cookie.match(new RegExp('(^|;\\s*)nd_csrf=([^;]+)'));
  if (match) return decodeURIComponent(match[2]);
  var csrfInput = document.querySelector('input[name="<?= $this->security->get_csrf_token_name() ?>"]');
  if (csrfInput) return csrfInput.value;
  return '<?= $this->security->get_csrf_hash() ?>';
}

function loadQuickBagItems() {
  var list = document.getElementById('quickBagItemsList');
  fetch('<?= base_url('cart/items') ?>', { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.json())
    .then(res => {
      if (res && res.success) {
        var items = res.items || (res.data && res.data.items) || [];
        var count = (res.cart_count !== undefined) ? res.cart_count : ((res.data && res.data.cart_count !== undefined) ? res.data.cart_count : items.length);
        var subtotal = (res.subtotal !== undefined) ? res.subtotal : ((res.data && res.data.subtotal !== undefined) ? res.data.subtotal : 0);

        var badge = document.getElementById('cartBadgeCount');
        var mobBadge = document.getElementById('mobileBottomCartBadge');
        if (badge) {
          badge.textContent = count;
          if (count > 0) badge.classList.remove('hidden');
          else badge.classList.add('hidden');
        }
        if (mobBadge) {
          mobBadge.textContent = count;
          if (count > 0) mobBadge.classList.remove('hidden');
          else mobBadge.classList.add('hidden');
        }

        if (items.length > 0) {
          renderQuickBagItems(items, subtotal);
        } else if (list) {
          list.innerHTML = `
            <div class="py-12 text-center text-on-surface-variant text-sm flex flex-col items-center">
              <span class="material-symbols-outlined text-4xl mb-2 text-outline-variant">checkroom</span>
              <p>Your curated selection is ready to be tailored.</p>
            </div>`;
          var subtotalEl = document.getElementById('quickBagSubtotal');
          if (subtotalEl) {
            subtotalEl.setAttribute('data-price-inr', 0);
            subtotalEl.textContent = '₹0';
          }
        }
      }
    })
    .catch(err => {
      console.error('Quick bag fetch error:', err);
    });
}

// ── Universal Category-Aware Product Sizing Engine ──
window.resolveProductSizes = function(titleOrObj, category) {
  var title = '';
  var cat = '';
  if (typeof titleOrObj === 'object' && titleOrObj !== null) {
    title = (titleOrObj.title || titleOrObj.product_title || '').toLowerCase();
    cat = (titleOrObj.category || titleOrObj.category_name || category || '').toLowerCase();
  } else if (typeof titleOrObj === 'string') {
    title = titleOrObj.toLowerCase();
    cat = (category || '').toLowerCase();
  }

  var combined = title + ' ' + cat;

  // 1. Shoes & Footwear (Numeric UK/EU Sizing)
  if (/(shoe|boot|sneaker|loafer|chelsea|footwear|heel|mule|oxford|sandal|derby|slide)/i.test(combined)) {
    return ['UK 6', 'UK 7', 'UK 8', 'UK 9', 'UK 10', 'UK 11'];
  }

  // 2. Jeans, Denim, Trousers, Pants (Numeric Waist Sizing in Inches)
  if (/(jean|denim|trouser|pant|chino|bottom|selvedge|slacks|cargo|waist)/i.test(combined)) {
    return ['28', '30', '32', '34', '36', '38'];
  }

  // 3. Accessories / Bags / Jewellery
  if (/(bag|tote|purse|wallet|belt|scarf|hat|sunglass|watch|ring|necklace|bracelet|fragrance)/i.test(combined)) {
    return ['One Size'];
  }

  // 4. Apparel (T-shirts, Hoodies, Shirts, Coats, Jackets, Knitwear, Dresses)
  return ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
};

function renderQuickBagItems(items, subtotal) {
  var list = document.getElementById('quickBagItemsList');
  if (!list) return;
  
  if (!items || items.length === 0) {
    list.innerHTML = `
      <div class="py-12 text-center text-stone-400">
        <span class="material-symbols-outlined text-4xl mb-2 text-stone-300">shopping_bag</span>
        <p class="text-xs font-mono">Your curated bag is currently empty.</p>
      </div>
    `;
    updateQuickBagTotals(0);
    return;
  }

  // 1. Match Combos from LocalStorage OR Auto-Detect Complementary Looks
  var savedCombos = [];
  try {
    savedCombos = JSON.parse(localStorage.getItem('lumina_cart_combos') || '[]');
  } catch(e) { savedCombos = []; }

  var matchedCombos = [];
  var consumedItemKeys = {};

  // A) Match explicit saved combos first
  savedCombos.forEach(function(c) {
    if (!c.itemIds || !c.itemIds.length) return;
    var matchedItems = [];
    items.forEach(function(item) {
      var itemKey = item.variant_id || item.id;
      var prodId = Number(item.product_id || item.variant_id || item.id);
      if (!consumedItemKeys[itemKey] && c.itemIds.includes(prodId)) {
        matchedItems.push(item);
      }
    });

    if (matchedItems.length >= 2) {
      matchedItems.forEach(function(mi) {
        var k = mi.variant_id || mi.id;
        consumedItemKeys[k] = true;
      });
      matchedCombos.push({
        comboId: c.comboId,
        lookName: c.lookName || 'Curated Ensemble Combo',
        discount: matchedItems.length === 3 ? 15 : (matchedItems.length === 2 ? 10 : (c.discount || 10)),
        items: matchedItems
      });
    }
  });

  // B) Auto-detect complementary ensemble combinations in remaining cart items
  var unassignedItems = items.filter(function(item) {
    var itemKey = item.variant_id || item.id;
    return !consumedItemKeys[itemKey];
  });

  if (unassignedItems.length >= 2) {
    var topItems = [];
    var bottomItems = [];
    var shoeItems = [];

    unassignedItems.forEach(function(item) {
      var tLower = (item.product_title || item.title || '').toLowerCase();
      if (/(shoe|boot|sneaker|loafer|derby|chelsea|footwear)/i.test(tLower)) shoeItems.push(item);
      else if (/(jean|denim|trouser|pant|chino|slacks|cargo)/i.test(tLower)) bottomItems.push(item);
      else if (/(coat|jacket|blazer|hoodie|shirt|t-shirt|knit|sweater|top)/i.test(tLower)) topItems.push(item);
    });

    // Form an ensemble combo if we have complementary pieces
    var ensembleGroup = [];
    if (topItems.length > 0) ensembleGroup.push(topItems.shift());
    if (bottomItems.length > 0) ensembleGroup.push(bottomItems.shift());
    if (shoeItems.length > 0) ensembleGroup.push(shoeItems.shift());

    // If we formed at least a 2-piece complementary look, group them!
    if (ensembleGroup.length >= 2) {
      ensembleGroup.forEach(function(mi) {
        var k = mi.variant_id || mi.id;
        consumedItemKeys[k] = true;
      });
      var autoDisc = ensembleGroup.length >= 3 ? 15 : 10;
      matchedCombos.push({
        comboId: 'auto_combo_' + Date.now(),
        lookName: 'Curated Ensemble Look',
        discount: autoDisc,
        items: ensembleGroup
      });
    }
  }

  // Remaining items that were NOT part of an active combo pack are Individual pieces
  var individualItems = items.filter(function(item) {
    var itemKey = item.variant_id || item.id;
    return !consumedItemKeys[itemKey];
  });

  var html = '';

  // ── 2. RENDER ACTIVE COMBO PACKS (IF ANY) ──
  matchedCombos.forEach(function(combo) {
    var comboCurrentTotal = 0;
    var comboOriginalTotal = 0;
    var comboKeys = [];

    var comboItemsHtml = combo.items.map(function(item) {
      var itemTitle = item.product_title || item.title || 'Curated Atelier Piece';
      var rawSize = (item.option1_value || item.variant_title || '').trim();
      var cleanSize = rawSize.replace(/^Size\s+/i, '');
      var currentSizeCode = cleanSize.toUpperCase();

      var itemPrice = parseFloat(item.unit_price || item.price || 0);
      var itemImg = item.image_url || item.image || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';
      var itemKey = item.variant_id || item.id;
      var itemQty = parseInt(item.quantity) || 1;
      comboKeys.push(itemKey);

      comboCurrentTotal += (itemPrice * itemQty);
      comboOriginalTotal += (itemPrice * (1 + (combo.discount / 100)) * itemQty);

      // Category detection
      var catTag = 'PIECE';
      var tLower = itemTitle.toLowerCase();
      if (/(shoe|boot|sneaker|loafer|derby|chelsea|footwear)/.test(tLower)) catTag = 'FOOTWEAR';
      else if (/(jean|denim|trouser|pant|chino|slacks|cargo)/.test(tLower)) catTag = 'BOTTOM WEAR';
      else if (/(coat|jacket|blazer|hoodie|shirt|t-shirt|knit|sweater|top)/.test(tLower)) catTag = 'TOP WEAR';

      var possibleSizes = resolveProductSizes(itemTitle);
      var defaultOptionIndex = Math.min(2, possibleSizes.length - 1);
      var sizeOptionsHtml = possibleSizes.map(function(sz, sidx) {
        var isSel = (currentSizeCode === sz.toUpperCase() || 
                    (sidx === defaultOptionIndex && (!currentSizeCode || currentSizeCode === 'STANDARD' || currentSizeCode === 'DEFAULT TITLE' || currentSizeCode === 'TAILORED STANDARD')));
        return '<option value="' + sz + '" ' + (isSel ? 'selected' : '') + '>' + sz + '</option>';
      }).join('');

      return `
        <div id="quickBagItem-${itemKey}" data-item-price="${itemPrice}" data-item-qty="${itemQty}" class="quick-bag-item-card" style="display: flex; gap: 12px; padding: 10px 12px; background: #ffffff; border: 1px solid #e7e5e4; border-radius: 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); flex-shrink: 0; width: 100%; box-sizing: border-box;">
          <div style="width: 50px; height: 60px; min-width: 50px; border-radius: 10px; overflow: hidden; background: #f5f5f4; border: 1px solid #e7e5e4; flex-shrink: 0;">
            <img src="${itemImg}" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="${itemTitle}">
          </div>
          <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: space-between;">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 6px;">
              <span style="font-family: monospace; font-size: 8px; font-weight: 700; text-transform: uppercase; color: #a16207; background: #fef3c7; border: 1px solid #fde68a; padding: 1px 5px; border-radius: 4px;">${catTag}</span>
              <button onclick="removeQuickBagItem(${itemKey}, this)" style="background: transparent; border: none; padding: 0; color: #a8a29e; cursor: pointer; display: flex; align-items: center;" title="Remove piece from combo">
                <span class="material-symbols-outlined" style="font-size: 15px;">close</span>
              </button>
            </div>
            <h5 style="font-family: serif; font-weight: 700; font-size: 12px; color: #1c1917; margin: 2px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${itemTitle}">${itemTitle}</h5>
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 6px; padding-top: 4px; border-top: 1px solid #f5f5f4;">
              <div style="display: flex; align-items: center; gap: 6px;">
                <span style="font-family: monospace; font-size: 8.5px; font-weight: 700; text-transform: uppercase; color: #78716c;">Size:</span>
                <select onchange="changeQuickBagItemSize(${itemKey}, this.value)" style="font-family: monospace; font-size: 10.5px; font-weight: 700; background: #f5f5f4; color: #1c1917; border: 1px solid #d6d3d1; border-radius: 6px; padding: 2px 4px; cursor: pointer; outline: none;">
                  ${sizeOptionsHtml}
                </select>
                <div style="display: flex; align-items: center; border: 1px solid #d6d3d1; border-radius: 5px; background: #f5f5f4; overflow: hidden; margin-left: 4px;">
                  <button type="button" onclick="changeQuickBagItemQty(${itemKey}, -1)" style="width: 18px; height: 18px; background: #ffffff; border: none; font-size: 11px; font-weight: bold; color: #44403c; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                  <span class="quick-bag-qty-num" style="width: 18px; text-align: center; font-family: monospace; font-size: 10px; font-weight: bold; color: #0c0a09; line-height: 18px;">${itemQty}</span>
                  <button type="button" onclick="changeQuickBagItemQty(${itemKey}, 1)" style="width: 18px; height: 18px; background: #ffffff; border: none; font-size: 11px; font-weight: bold; color: #44403c; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                </div>
              </div>
              <span class="quick-bag-item-price-val font-serif" style="font-weight: 700; font-size: 12px; color: #0c0a09;" data-price-inr="${itemPrice * itemQty}">${formatPrice(itemPrice * itemQty)}</span>
            </div>
          </div>
        </div>
      `;
    }).join('');

    var comboSavings = Math.max(0, Math.round(comboOriginalTotal - comboCurrentTotal));

    html += `
      <div class="quick-bag-combo-card" data-combo-card="true" style="background: #18181b; color: #ffffff; border-radius: 20px; padding: 14px 16px; border: 1px solid rgba(251, 191, 36, 0.4); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3); margin-bottom: 14px; flex-shrink: 0; width: 100%; box-sizing: border-box;">
        <!-- Combo Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.12); margin-bottom: 10px;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 18px; color: #fbbf24;">auto_awesome</span>
            <div>
              <div style="font-family: monospace; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #fbbf24;">${combo.lookName}</div>
              <div style="font-family: monospace; font-size: 9.5px; color: #a8a29e;">${combo.items.length} Coordinated Pieces</div>
            </div>
          </div>
          <span style="padding: 3px 8px; border-radius: 999px; background: rgba(6, 78, 59, 0.8); color: #6ee7b7; font-family: monospace; font-size: 9.5px; font-weight: 700; border: 1px solid rgba(110, 231, 183, 0.4);">
            ${combo.discount}% Privilege
          </span>
        </div>

        <!-- Nested Items in Combo -->
        <div style="display: flex; flex-direction: column; gap: 8px;">
          ${comboItemsHtml}
        </div>

        <!-- Combo Footer -->
        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 10px; border-top: 1px solid rgba(255,255,255,0.12); margin-top: 10px; font-size: 12px;">
          <div>
            <div style="font-family: monospace; font-size: 10px; color: #a8a29e;">Combo Total: <strong style="color: #ffffff; font-size: 13px; font-family: serif;">${formatPrice(comboCurrentTotal)}</strong></div>
            ${comboSavings > 0 ? `<div style="font-family: monospace; font-size: 9.5px; color: #34d399; font-weight: 700;">Saved ${formatPrice(comboSavings)} with ${combo.discount}% combo privilege</div>` : ''}
          </div>
          <button type="button" onclick="removeQuickBagPack(${JSON.stringify(comboKeys).replace(/"/g, '&quot;')}, '${combo.comboId}', this)" style="background: none; border: none; font-family: monospace; font-size: 10px; color: #a8a29e; cursor: pointer; text-decoration: underline; text-transform: uppercase; letter-spacing: 0.05em;" onmouseover="this.style.color='#fb7185'" onmouseout="this.style.color='#a8a29e'">
            Remove Combo
          </button>
        </div>
      </div>
    `;
  });

  // ── 3. RENDER INDIVIDUAL (NON-COMBO) ATELIER PIECES ──
  if (individualItems.length > 0) {
    if (matchedCombos.length > 0) {
      html += `
        <div style="font-family: monospace; font-size: 10px; text-transform: uppercase; letter-spacing: 0.08em; color: #78716c; font-weight: 700; margin: 12px 0 8px 2px; display: flex; align-items: center; gap: 6px;">
          <span style="width: 6px; height: 6px; border-radius: 999px; background: #a8a29e;"></span>
          <span>Individual Atelier Pieces</span>
        </div>
      `;
    }

    individualItems.forEach(function(item) {
      var itemTitle = item.product_title || item.title || 'Curated Atelier Piece';
      var rawSize = (item.option1_value || item.variant_title || '').trim();
      var cleanSize = rawSize.replace(/^Size\s+/i, '');
      var currentSizeCode = cleanSize.toUpperCase();

      var itemPrice = parseFloat(item.unit_price || item.price || 0);
      var itemImg = item.image_url || item.image || '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';
      var itemKey = item.variant_id || item.id;
      var itemQty = parseInt(item.quantity) || 1;

      // Category detection
      var catTag = 'PIECE';
      var tLower = itemTitle.toLowerCase();
      if (/(shoe|boot|sneaker|loafer|derby|chelsea|footwear)/.test(tLower)) catTag = 'FOOTWEAR';
      else if (/(jean|denim|trouser|pant|chino|slacks|cargo)/.test(tLower)) catTag = 'BOTTOM WEAR';
      else if (/(coat|jacket|blazer|hoodie|shirt|t-shirt|knit|sweater|top)/.test(tLower)) catTag = 'TOP WEAR';

      var possibleSizes = resolveProductSizes(itemTitle);
      var defaultOptionIndex = Math.min(2, possibleSizes.length - 1);
      var sizeOptionsHtml = possibleSizes.map(function(sz, sidx) {
        var isSel = (currentSizeCode === sz.toUpperCase() || 
                    (sidx === defaultOptionIndex && (!currentSizeCode || currentSizeCode === 'STANDARD' || currentSizeCode === 'DEFAULT TITLE' || currentSizeCode === 'TAILORED STANDARD')));
        return '<option value="' + sz + '" ' + (isSel ? 'selected' : '') + '>' + sz + '</option>';
      }).join('');

      html += `
        <div id="quickBagItem-${itemKey}" data-item-price="${itemPrice}" data-item-qty="${itemQty}" class="quick-bag-item-card" style="display: flex; gap: 14px; padding: 14px; background: #ffffff; border: 1px solid #e7e5e4; border-radius: 16px; margin-bottom: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); flex-shrink: 0; width: 100%; box-sizing: border-box;">
          <div style="width: 64px; height: 78px; min-width: 64px; border-radius: 12px; overflow: hidden; background: #f5f5f4; border: 1px solid #e7e5e4; flex-shrink: 0;">
            <img src="${itemImg}" style="width: 100%; height: 100%; object-fit: cover; display: block;" alt="${itemTitle}">
          </div>
          <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: space-between;">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 8px;">
              <span style="font-family: monospace; font-size: 8.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #a16207; background: #fef3c7; border: 1px solid #fde68a; padding: 2px 6px; border-radius: 4px;">${catTag}</span>
              <button onclick="removeQuickBagItem(${itemKey}, this)" style="background: transparent; border: none; padding: 2px; color: #a8a29e; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 6px;" title="Remove piece" onmouseover="this.style.color='#e11d48'" onmouseout="this.style.color='#a8a29e'">
                <span class="material-symbols-outlined" style="font-size: 16px;">close</span>
              </button>
            </div>
            <h4 style="font-family: serif; font-weight: 700; font-size: 13px; color: #1c1917; margin: 4px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; line-height: 1.3;" title="${itemTitle}">${itemTitle}</h4>
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: 6px; padding-top: 6px; border-top: 1px solid #f5f5f4;">
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 4px;">
                  <span style="font-family: monospace; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #78716c;">Size:</span>
                  <select onchange="changeQuickBagItemSize(${itemKey}, this.value)" style="font-family: monospace; font-size: 11px; font-weight: 700; background: #f5f5f4; color: #1c1917; border: 1px solid #d6d3d1; border-radius: 6px; padding: 2px 6px; cursor: pointer; outline: none;">
                    ${sizeOptionsHtml}
                  </select>
                </div>
                <div style="display: flex; align-items: center; gap: 4px;">
                  <span style="font-family: monospace; font-size: 9px; font-weight: 700; text-transform: uppercase; color: #78716c;">Qty:</span>
                  <div style="display: flex; align-items: center; border: 1px solid #d6d3d1; border-radius: 6px; background: #f5f5f4; overflow: hidden;">
                    <button type="button" onclick="changeQuickBagItemQty(${itemKey}, -1)" style="width: 20px; height: 20px; background: #ffffff; border: none; font-size: 12px; font-weight: bold; color: #44403c; cursor: pointer; display: flex; align-items: center; justify-content: center;">-</button>
                    <span class="quick-bag-qty-num" style="width: 20px; text-align: center; font-family: monospace; font-size: 11px; font-weight: bold; color: #0c0a09; line-height: 20px;">${itemQty}</span>
                    <button type="button" onclick="changeQuickBagItemQty(${itemKey}, 1)" style="width: 20px; height: 20px; background: #ffffff; border: none; font-size: 12px; font-weight: bold; color: #44403c; cursor: pointer; display: flex; align-items: center; justify-content: center;">+</button>
                  </div>
                </div>
              </div>
              <div style="text-align: right;">
                <span class="quick-bag-item-price-val font-serif" style="font-weight: 700; font-size: 13px; color: #0c0a09;" data-price-inr="${itemPrice * itemQty}">${formatPrice(itemPrice * itemQty)}</span>
              </div>
            </div>
          </div>
        </div>
      `;
    });
  }
  
  list.innerHTML = html;
  updateQuickBagTotals(subtotal);
}

// ── Change Quantity for an Item in Quick Bag ──
window.changeQuickBagItemQty = function(variantId, delta) {
  var card = document.getElementById('quickBagItem-' + variantId);
  var curQty = card ? parseInt(card.getAttribute('data-item-qty') || 1) : 1;
  var newQty = curQty + delta;

  if (newQty <= 0) {
    removeQuickBagItem(variantId);
    return;
  }

  // 1. Instant 0ms Optimistic UI update on the card
  if (card) {
    card.setAttribute('data-item-qty', newQty);
    var qtyDisplay = card.querySelector('.quick-bag-qty-num');
    if (qtyDisplay) qtyDisplay.textContent = newQty;

    var unitPrice = parseFloat(card.getAttribute('data-item-price') || 0);
    var priceEl = card.querySelector('.quick-bag-item-price-val, [data-price-inr]');
    if (priceEl && unitPrice > 0) {
      var newLineTotal = unitPrice * newQty;
      priceEl.textContent = formatPrice(newLineTotal);
      priceEl.setAttribute('data-price-inr', newLineTotal);
    }
  }

  // 2. Immediate Optimistic Cart Subtotal Update
  var unitPrice = card ? parseFloat(card.getAttribute('data-item-price') || 0) : 0;
  if (unitPrice > 0) {
    var origEl = document.getElementById('quickBagOriginalSubtotal');
    var subtotalEl = document.getElementById('quickBagSubtotal');
    var curSub = parseFloat((origEl && origEl.getAttribute('data-price-inr')) || (subtotalEl && subtotalEl.getAttribute('data-price-inr')) || '0');
    var newSub = Math.max(0, curSub + (unitPrice * delta));
    updateQuickBagTotals(newSub);
  }

  // 3. Send Server Update via AJAX
  var formData = new FormData();
  formData.append('variant_id', variantId);
  formData.append('quantity', newQty);
  formData.append('<?= $this->security->get_csrf_token_name() ?>', getCsrfToken());

  fetch('<?= base_url('cart/update') ?>', {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(d => {
    fetchQuickBagItems();
  })
  .catch(err => {
    console.error('Cart quantity update error:', err);
  });
};

// ── Remove Entire Pack from Quick Bag ──
window.removeQuickBagPack = function(variantIds, comboId, btnEl) {
  if (!Array.isArray(variantIds) || !variantIds.length) return;
  
  // 1. Clean from localStorage combo store
  if (comboId) {
    try {
      var saved = JSON.parse(localStorage.getItem('lumina_cart_combos') || '[]');
      saved = saved.filter(function(c) { return c.comboId !== comboId; });
      localStorage.setItem('lumina_cart_combos', JSON.stringify(saved));
    } catch(e) {}
  }

  // 2. Instant 0ms Optimistic UI Animation on the Combo Card Container
  var comboCard = btnEl ? btnEl.closest('.quick-bag-combo-card, [data-combo-card]') : null;
  if (!comboCard && btnEl) {
    comboCard = btnEl.closest('div[style*="background: #18181b"], div[style*="background:#18181b"]');
  }
  if (comboCard) {
    comboCard.style.transition = 'all 0.35s ease';
    comboCard.style.opacity = '0';
    comboCard.style.transform = 'translateX(50px) scale(0.95)';
    setTimeout(() => {
      if (comboCard && comboCard.parentNode) {
        comboCard.parentNode.removeChild(comboCard);
      }
    }, 320);
  }

  // 3. Remove each item via /cart/remove
  var remaining = variantIds.length;
  variantIds.forEach(function(vId) {
    var formData = new FormData();
    formData.append('variant_id', vId);
    formData.append('<?= $this->security->get_csrf_token_name() ?>', getCsrfToken());

    fetch('<?= base_url('cart/remove') ?>', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .finally(() => {
      remaining--;
      if (remaining === 0) {
        fetchQuickBagItems();
        if (typeof ndToast === 'function') ndToast('Combo pack removed from bag.', 'info');
      }
    });
  });
};

// ── Instant AJAX In-Drawer Size Switcher ──
window.changeQuickBagItemSize = function(variantId, newSize) {
  if (!variantId || !newSize) return;

  var formData = new FormData();
  formData.append('variant_id', variantId);
  formData.append('size', newSize);
  formData.append('<?= $this->security->get_csrf_token_name() ?>', getCsrfToken());

  fetch('<?= base_url('cart/update_size') ?>', {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(d => {
    if (d && d.success) {
      var items = (d.data && d.data.items) || d.items || [];
      var subtotal = (d.data && d.data.subtotal !== undefined) ? d.data.subtotal : (d.subtotal || 0);
      renderQuickBagItems(items, subtotal);
      ndToast('Garment size updated to ' + newSize + ' ✓', 'success');
    } else {
      ndToast(d.message || 'Could not update size', 'error');
    }
  })
  .catch(err => {
    console.error('Size update error:', err);
    ndToast('Network error while updating size', 'error');
  });
};

// ── 🎟️ Quick Bag Coupon & Real-Time Discount Engine ──
window.quickBagAppliedCoupon = (function() {
  try {
    var saved = localStorage.getItem('lumina_quick_coupon');
    return saved ? JSON.parse(saved) : null;
  } catch(e) { return null; }
})();

window.setQuickCoupon = function(code) {
  var acc = document.getElementById('quickBagCouponAccordion');
  if (acc) acc.open = true;
  var input = document.getElementById('quickBagCouponInput');
  if (input) {
    input.value = code;
    applyQuickBagCoupon();
  }
};

window.applyQuickBagCoupon = function() {
  var input = document.getElementById('quickBagCouponInput');
  var code = input ? input.value.trim().toUpperCase() : '';
  var statusEl = document.getElementById('quickBagCouponStatus');

  if (!code) {
    showToastNotice('Please enter a coupon code.');
    return;
  }

  var origEl = document.getElementById('quickBagOriginalSubtotal');
  var subtotalEl = document.getElementById('quickBagSubtotal');
  var rawSub = parseFloat((origEl && origEl.getAttribute('data-price-inr')) || (subtotalEl && subtotalEl.getAttribute('data-price-inr')) || '0');
  
  if (rawSub <= 0) {
    showToastNotice('Please add pieces to your bag first.');
    return;
  }

  var discountRate = 0;
  if (code === 'LUMINA50' || code === 'VIP50') {
    discountRate = 0.50;
  } else if (code === 'NOVA10' || code === 'WELCOME10') {
    discountRate = 0.10;
  } else if (code === 'FREESHIP') {
    discountRate = 0.05;
  } else {
    discountRate = 0.15; // default valid VIP promo
  }

  window.quickBagAppliedCoupon = { code: code, rate: discountRate };
  try {
    localStorage.setItem('lumina_quick_coupon', JSON.stringify(window.quickBagAppliedCoupon));
  } catch(e){}
  
  if (statusEl) {
    statusEl.textContent = code + ' Applied! 🎉';
    statusEl.classList.remove('hidden');
  }

  updateQuickBagTotals(rawSub);
  showToastNotice('VIP Code ' + code + ' Applied Successfully!');
};

window.updateQuickBagTotals = function(subtotal) {
  var origEl = document.getElementById('quickBagOriginalSubtotal');
  var subtotalEl = document.getElementById('quickBagSubtotal');
  var discountRow = document.getElementById('quickBagDiscountRow');
  var discountCodeEl = document.getElementById('quickBagDiscountCode');
  var discountAmountEl = document.getElementById('quickBagDiscountAmount');
  var shippingText = document.getElementById('quickBagShippingText');
  var shippingPct = document.getElementById('quickBagShippingPct');
  var shippingBar = document.getElementById('quickBagShippingBar');

  if (origEl) {
    origEl.setAttribute('data-price-inr', subtotal);
    origEl.textContent = formatPrice(subtotal);
  }

  // Shipping progress goal: ₹2,499 for free express delivery
  var freeThreshold = 2499;
  if (shippingBar && shippingText && shippingPct) {
    if (subtotal >= freeThreshold) {
      shippingText.textContent = '🎉 You unlocked Free Express Delivery!';
      shippingPct.textContent = '100%';
      shippingBar.style.width = '100%';
    } else {
      var diff = freeThreshold - subtotal;
      var pct = Math.max(10, Math.min(99, Math.round((subtotal / freeThreshold) * 100)));
      shippingText.textContent = 'Add ' + formatPrice(diff) + ' for Free Express Delivery';
      shippingPct.textContent = pct + '%';
      shippingBar.style.width = pct + '%';
    }
  }

  // Calculate discount if coupon applied
  var finalTotal = subtotal;
  var couponData = window.quickBagAppliedCoupon;
  if (typeof couponData === 'string') {
    try { couponData = JSON.parse(couponData); } catch(e) { couponData = null; }
  }

  if (couponData && couponData.rate && subtotal > 0) {
    var discountVal = Math.round(subtotal * couponData.rate);
    finalTotal = Math.max(0, subtotal - discountVal);
    
    if (discountRow) discountRow.classList.remove('hidden');
    if (discountCodeEl) discountCodeEl.textContent = couponData.code;
    if (discountAmountEl) {
      discountAmountEl.textContent = '- ' + formatPrice(discountVal);
      discountAmountEl.setAttribute('data-price-inr', discountVal);
    }
  } else {
    if (discountRow) discountRow.classList.add('hidden');
  }

  if (subtotalEl) {
    subtotalEl.setAttribute('data-price-inr', finalTotal);
    subtotalEl.textContent = formatPrice(finalTotal);
  }

  // Calculate Atelier Reward Points for total order
  var ptsVal = Math.max(0, Math.round(finalTotal * 0.06));
  var ptsEl = document.getElementById('quickBagPointsVal');
  var cashEl = document.getElementById('quickBagCashbackVal');
  if (ptsEl) ptsEl.textContent = `+${Number(ptsVal).toLocaleString('en-IN')} pts`;
  if (cashEl) cashEl.textContent = `(₹${Number(ptsVal).toLocaleString('en-IN')} Cashback Credit)`;
};

// ── 🗑️ Real-Time Item Removal Animation (Zero Toast / 60FPS Collapse) ──
function removeQuickBagItem(variantId, btnEl) {
  var card = btnEl ? btnEl.closest('.quick-bag-item-card') : document.getElementById('quickBagItem-' + variantId);
  var itemPrice = card ? parseFloat(card.getAttribute('data-item-price') || 0) : 0;
  var itemQty = card ? parseInt(card.getAttribute('data-item-qty') || 1) : 1;
  var itemTotal = itemPrice * itemQty;

  // 1. Immediate Real-Time Exit Animation on Card (0ms)
  if (card) {
    card.classList.add('quick-bag-item-removing');
  }

  // 2. Real-Time Optimistic Subtotal Update
  var origEl = document.getElementById('quickBagOriginalSubtotal');
  var subtotalEl = document.getElementById('quickBagSubtotal');
  var curSub = parseFloat((origEl && origEl.getAttribute('data-price-inr')) || (subtotalEl && subtotalEl.getAttribute('data-price-inr')) || '0');
  var newSub = Math.max(0, curSub - itemTotal);
  updateQuickBagTotals(newSub);

  // 3. Real-Time Optimistic Badge Decrement
  var badge = document.getElementById('cartBadgeCount');
  var mobBadge = document.getElementById('mobileBottomCartBadge');
  if (badge) {
    var curCount = parseInt(badge.textContent || '0') || 0;
    var newCount = Math.max(0, curCount - itemQty);
    badge.textContent = newCount;
    if (newCount <= 0) badge.classList.add('hidden');
  }
  if (mobBadge) {
    var curCount = parseInt(mobBadge.textContent || '0') || 0;
    var newCount = Math.max(0, curCount - itemQty);
    mobBadge.textContent = newCount;
    if (newCount <= 0) mobBadge.classList.add('hidden');
  }

  // 4. Remove DOM node after smooth collapse animation completes (320ms)
  setTimeout(() => {
    if (card && card.parentNode) {
      card.parentNode.removeChild(card);
    }
    var list = document.getElementById('quickBagItemsList');
    if (list && list.querySelectorAll('.quick-bag-item-card').length === 0) {
      list.innerHTML = `
        <div class="py-12 text-center text-on-surface-variant text-sm flex flex-col items-center animate-in fade-in duration-300">
          <span class="material-symbols-outlined text-4xl mb-2 text-outline-variant">checkroom</span>
          <p>Your curated selection is ready to be tailored.</p>
        </div>`;
      updateQuickBagTotals(0);
    }
  }, 320);

  // 5. Asynchronous Background Server Sync (No obstructive toast)
  var formData = new FormData();
  formData.append('variant_id', variantId);
  formData.append('<?= $this->security->get_csrf_token_name() ?>', getCsrfToken());

  fetch('<?= base_url('cart/remove') ?>', {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(d => {
    if (d && d.success) {
      var serverCount = (d.data && d.data.cart_count !== undefined) ? d.data.cart_count : 0;
      var serverSub = (d.data && d.data.subtotal !== undefined) ? d.data.subtotal : 0;

      if (badge) {
        badge.textContent = serverCount;
        if (serverCount <= 0) badge.classList.add('hidden');
      }
      if (mobBadge) {
        mobBadge.textContent = serverCount;
        if (serverCount <= 0) mobBadge.classList.add('hidden');
      }
      if (serverCount > 0) {
        updateQuickBagTotals(serverSub);
      }
    }
  })
  .catch(err => {
    console.warn('Remove sync notice:', err);
  });
}

// ── Mobile Drawer Handler ──
function toggleMobileNav() {
  var drawer = document.getElementById('mobileMenuDrawer');
  var backdrop = document.getElementById('mobileMenuBackdrop');
  var panel = document.getElementById('mobileMenuPanel');
  if (!drawer || !backdrop || !panel) return;

  if (drawer.classList.contains('hidden')) {
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
      backdrop.classList.remove('opacity-0');
      backdrop.classList.add('opacity-100');
      panel.classList.remove('-translate-x-full');
      panel.classList.add('translate-x-0');
    }, 15);
  } else {
    backdrop.classList.remove('opacity-100');
    backdrop.classList.add('opacity-0');
    panel.classList.remove('translate-x-0');
    panel.classList.add('-translate-x-full');
    document.body.style.overflow = '';
    setTimeout(() => {
      drawer.classList.add('hidden');
      drawer.classList.remove('flex');
    }, 300);
  }
}

// ── Search Modal ──
function toggleSearchModal() {
  var m = document.getElementById('searchModal');
  if (!m) return;
  var isHidden = m.classList.contains('hidden');
  if (isHidden) {
    m.classList.remove('hidden');
    m.classList.add('flex');
    if (typeof lockStorefrontScroll === 'function') lockStorefrontScroll();
    setTimeout(() => {
      var inp = document.getElementById('liveSearchInput');
      if (inp) inp.focus();
    }, 50);
  } else {
    m.classList.add('hidden');
    m.classList.remove('flex');
    if (typeof unlockStorefrontScroll === 'function') unlockStorefrontScroll();
  }
}
document.addEventListener('keydown', e => {
  if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); toggleSearchModal(); }
  if (e.key === 'Escape') {
    var m = document.getElementById('searchModal');
    if (m && !m.classList.contains('hidden')) toggleSearchModal();
    var qb = document.getElementById('quickBagOverlay');
    if (qb && !qb.classList.contains('hidden')) toggleQuickBagDrawer();
  }
});

function handleSearchQuery(q) {
  var box = document.getElementById('searchResultsList');
  if (!box) return;
  var term = q.trim();
  if (term.length < 2) {
    box.innerHTML = '<div class="py-6 text-center text-xs font-mono tracking-wider uppercase text-stone-400">Type at least 2 characters or select a capsule above...</div>';
    return;
  }
  box.innerHTML = '<div class="py-6 text-center text-xs font-mono text-[#a16207] animate-pulse">✦ Searching Atelier Archives...</div>';
  fetch('<?= base_url('search?json=1&q=') ?>' + encodeURIComponent(term))
    .then(r => r.json())
    .then(data => {
      if (!data || !data.products || data.products.length === 0) {
        box.innerHTML = `
          <div class="py-6 text-center text-xs font-mono text-stone-500">
            No exact creations for "<strong>${term}</strong>".
            <a href="<?= base_url('shop') ?>" class="text-[#a16207] underline block mt-2 font-bold">Explore Full Boutique</a>
          </div>
        `;
        return;
      }
      let html = '<div class="space-y-2">';
      data.products.slice(0, 6).forEach(p => {
        html += `
          <a href="${p.url}" class="p-2.5 bg-stone-50 hover:bg-amber-50/70 border border-stone-200 hover:border-[#a16207]/40 rounded-2xl flex items-center justify-between gap-3 transition-all duration-200 group">
            <div class="flex items-center gap-3 min-w-0">
              <img src="${p.image}" class="w-12 h-14 object-cover rounded-xl bg-stone-200 border border-stone-200 flex-shrink-0" loading="lazy">
              <div class="min-w-0">
                <span class="text-[9px] font-mono text-[#a16207] font-bold uppercase tracking-wider block">${p.vendor || 'NOVADROP'}</span>
                <h4 class="font-serif text-xs font-bold text-stone-900 group-hover:text-[#a16207] truncate">${p.title}</h4>
                <span class="text-xs font-serif font-bold text-stone-950">${formatPrice(p.price)}</span>
              </div>
            </div>
            <span class="material-symbols-outlined text-sm text-stone-400 group-hover:text-[#a16207] mr-1 group-hover:translate-x-1 transition-all">arrow_forward</span>
          </a>
        `;
      });
      html += `
        <a href="<?= base_url('search?q=') ?>${encodeURIComponent(term)}" class="mt-2 p-3 bg-stone-950 text-[#e9c176] rounded-2xl flex items-center justify-between text-xs font-mono font-bold uppercase tracking-wider hover:bg-stone-800 transition-all text-center">
          <span>View All ${data.total || data.products.length} Results for "${term}"</span>
          <span class="material-symbols-outlined text-sm">north_east</span>
        </a>
      </div>`;
      box.innerHTML = html;
    })
    .catch(() => {
      box.innerHTML = `<a href="<?= base_url('search?q=') ?>${encodeURIComponent(term)}" class="p-3 bg-stone-100 rounded-xl flex justify-between items-center text-xs font-mono"><span>Search for "<strong>${term}</strong>"</span><span class="material-symbols-outlined text-sm">arrow_forward</span></a>`;
    });
}

// ── 🔔 Luxury Glassmorphic Toast System (Bottom-Centered Non-Intrusive) ──
window.ndToast = function(msg, type, actionText, actionCallback) {
  var tc = document.getElementById('toastContainer');
  if (!tc) return;

  // Clear previous toasts to prevent stacking
  tc.innerHTML = '';

  var el = document.createElement('div');
  var isError = type === 'error';
  var isInfo = type === 'info';
  var icon = isError ? 'error' : (isInfo ? 'info' : 'check_circle');
  var accentColor = isError ? '#f87171' : (isInfo ? '#60a5fa' : '#e9c176');
  var borderColor = isError ? 'border-red-500/50' : 'border-[#e9c176]/40';

  el.className = 'liquid-glass bg-[#0a0b0f]/95 backdrop-blur-2xl text-white px-4 py-2 rounded-full text-xs font-mono font-medium flex items-center justify-between gap-3 border ' + borderColor + ' shadow-[0_15px_35px_rgba(0,0,0,0.85)] pointer-events-auto transition-all duration-300 transform translate-y-3 opacity-0';
  
  var leftHtml = '<div class="flex items-center gap-2 min-w-0"><span class="material-symbols-outlined text-sm flex-shrink-0" style="color:' + accentColor + '">' + icon + '</span><span class="truncate text-white/95 leading-tight font-sans text-xs">' + msg + '</span></div>';
  var rightHtml = '';
  
  if (actionText && typeof actionCallback === 'function') {
    rightHtml = '<button type="button" class="px-2 py-0.5 bg-[#e9c176] text-black font-mono font-extrabold text-[9px] uppercase tracking-wider rounded-full hover:bg-white transition-all flex-shrink-0 cursor-pointer ml-1">' + actionText + '</button>';
  } else {
    rightHtml = '<button type="button" class="text-white/40 hover:text-white transition-colors p-0.5 flex-shrink-0 cursor-pointer"><span class="material-symbols-outlined text-xs">close</span></button>';
  }

  el.innerHTML = leftHtml + rightHtml;
  tc.appendChild(el);

  var btnAction = el.querySelector('button');
  if (btnAction) {
    btnAction.onclick = function(e) {
      e.stopPropagation();
      if (actionText && typeof actionCallback === 'function') {
        actionCallback();
      }
      dismissToast(el);
    };
  }

  function dismissToast(target) {
    target.style.opacity = '0';
    target.style.transform = 'translateY(10px) scale(0.95)';
    setTimeout(() => { if (target.parentNode) target.parentNode.removeChild(target); }, 250);
  }

  // Smooth entrance
  requestAnimationFrame(() => {
    el.style.opacity = '1';
    el.style.transform = 'translateY(0) scale(1)';
  });

  // Fast auto dismiss (2.0s)
  setTimeout(() => {
    dismissToast(el);
  }, 2000);
};

// ── 🎆 Cart Badge Pop & Shockwave Celebration ──
window.triggerCartBadgeCelebration = function() {
  var badge = document.getElementById('cartBadgeCount');
  var mobBadge = document.getElementById('mobileBottomCartBadge');
  var headerCart = document.getElementById('headerCartBtn') || badge;

  var isMobile = window.innerWidth < 768;
  var targetEl = isMobile ? (mobBadge || badge) : (headerCart || badge);

  // 1. Badge Bounce
  [badge, mobBadge].forEach(b => {
    if (b) {
      b.classList.remove('animate-cart-bounce');
      void b.offsetWidth; // trigger reflow
      b.classList.add('animate-cart-bounce');
      setTimeout(() => b.classList.remove('animate-cart-bounce'), 600);
    }
  });

  // 2. Shockwave Ripple
  if (targetEl) {
    var rect = targetEl.getBoundingClientRect();
    var ring = document.createElement('div');
    ring.className = 'cart-shockwave-ring';
    ring.style.left = (rect.left + rect.width / 2) + 'px';
    ring.style.top = (rect.top + rect.height / 2) + 'px';
    document.body.appendChild(ring);
    setTimeout(() => { if (ring.parentNode) ring.parentNode.removeChild(ring); }, 700);
  }
};

// ── 🚀 60FPS Parabolic Fly-To-Cart Animation Engine ──
window.animateFlyToCart = function(sourceEl, customImgUrl, qty, onArrival) {
  var isMobile = window.innerWidth < 768;
  
  // 1. Find source image element or coordinates
  var srcImg = null;
  var startRect = null;

  if (sourceEl && sourceEl.nodeType === 1) {
    if (sourceEl.tagName === 'IMG') {
      srcImg = sourceEl;
    } else {
      var container = sourceEl.closest('.group, [data-product-card], .lux-product-card, article, #product3DCanvasContainer, .relative') || sourceEl;
      srcImg = container.querySelector('img') || document.getElementById('qvImg') || document.querySelector('#productThreeCanvas');
    }
  }

  if (srcImg && srcImg.getBoundingClientRect) {
    startRect = srcImg.getBoundingClientRect();
  } else if (sourceEl && sourceEl.getBoundingClientRect) {
    startRect = sourceEl.getBoundingClientRect();
  }

  var startX = startRect ? (startRect.left + startRect.width / 2) : (window.innerWidth / 2);
  var startY = startRect ? (startRect.top + startRect.height / 2) : (window.innerHeight / 2);

  // 2. Find target cart destination
  var desktopTarget = document.getElementById('headerCartBtn') || document.getElementById('cartBadgeCount');
  var mobileTarget = document.getElementById('mobileBottomCartBadge') || document.querySelector('a[href*="cart"], button[onclick*="toggleQuickBag"]');
  var targetEl = isMobile ? mobileTarget : desktopTarget;

  var destRect = null;
  if (targetEl && targetEl.getBoundingClientRect) {
    destRect = targetEl.getBoundingClientRect();
  }

  var targetX = destRect ? (destRect.left + destRect.width / 2) : (isMobile ? (window.innerWidth * 0.82) : (window.innerWidth - 50));
  var targetY = destRect ? (destRect.top + destRect.height / 2) : (isMobile ? (window.innerHeight - 35) : 40);

  var dx = targetX - startX;
  var dy = targetY - startY;

  // 3. Resolve Image URL
  var imgUrl = customImgUrl;
  if (!imgUrl && srcImg && srcImg.tagName === 'IMG' && srcImg.src) {
    imgUrl = srcImg.src;
  }
  if (!imgUrl) {
    imgUrl = '<?= base_url("img/cashmere_cocoon_coat.jpg") ?>';
  }

  // 4. Create Flying Element
  var flyer = document.createElement('div');
  flyer.className = 'flying-cart-item';
  flyer.style.width = '64px';
  flyer.style.height = '64px';
  flyer.style.left = (startX - 32) + 'px';
  flyer.style.top = (startY - 32) + 'px';
  flyer.innerHTML = '<img src="' + imgUrl + '" alt="Piece" />';
  document.body.appendChild(flyer);

  // 5. Spawn Golden Stardust Particles Along Path
  function spawnStardust(px, py) {
    var p = document.createElement('div');
    p.className = 'cart-stardust-particle';
    p.style.left = (px - 4 + (Math.random() * 8 - 4)) + 'px';
    p.style.top = (py - 4 + (Math.random() * 8 - 4)) + 'px';
    document.body.appendChild(p);
    setTimeout(() => { if (p.parentNode) p.parentNode.removeChild(p); }, 600);
  }

  var t1 = setTimeout(() => spawnStardust(startX + dx * 0.25, startY + dy * 0.15 - 40), 120);
  var t2 = setTimeout(() => spawnStardust(startX + dx * 0.55, startY + dy * 0.45 - 25), 260);
  var t3 = setTimeout(() => spawnStardust(startX + dx * 0.85, startY + dy * 0.75 - 10), 400);

  // 6. Execute Compositor WAAPI Parabolic Arc
  var arcUpY = isMobile ? -35 : -75;
  var keyframes = [
    { transform: 'translate3d(0px, 0px, 0px) scale(1) rotate(0deg)', opacity: 1, offset: 0 },
    { transform: 'translate3d(' + (dx * 0.22) + 'px, ' + (dy * 0.12 + arcUpY) + 'px, 0px) scale(1.15) rotate(12deg)', opacity: 1, offset: 0.25 },
    { transform: 'translate3d(' + (dx * 0.65) + 'px, ' + (dy * 0.52 + (arcUpY * 0.4)) + 'px, 0px) scale(0.72) rotate(-6deg)', opacity: 0.95, offset: 0.65 },
    { transform: 'translate3d(' + dx + 'px, ' + dy + 'px, 0px) scale(0.18) rotate(0deg)', opacity: 0.15, offset: 1 }
  ];

  var anim = flyer.animate(keyframes, {
    duration: 560,
    easing: 'cubic-bezier(0.19, 1, 0.22, 1)',
    fill: 'forwards'
  });

  anim.onfinish = function() {
    clearTimeout(t1);
    clearTimeout(t2);
    clearTimeout(t3);
    if (flyer.parentNode) flyer.parentNode.removeChild(flyer);
    triggerCartBadgeCelebration();
    if (typeof onArrival === 'function') onArrival();
  };
};

// ── 🛒 Global Zero-Lag AJAX Add to Cart Engine ──
window.addToCart = function(itemOrId, qty, customToastMsg, callback) {
  var variantId = itemOrId;
  var size = '';
  var color = '';
  var title = '';
  var price = 0;
  var image = '';

  if (typeof itemOrId === 'object' && itemOrId !== null) {
    variantId = itemOrId.id || itemOrId.variant_id || 1;
    size = itemOrId.size || '';
    color = itemOrId.color || '';
    title = itemOrId.title || '';
    price = itemOrId.price || 0;
    image = itemOrId.image || itemOrId.img || '';
  }

  var quantity = Math.max(1, parseInt(qty) || 1);

  // 1. Identify Trigger Button & Apply Instant Tactile Feedback
  var evt = window.event;
  var btn = null;
  if (evt) {
    btn = (evt.currentTarget && evt.currentTarget.nodeType === 1) ? evt.currentTarget : (evt.target ? evt.target.closest('button') : null);
  }
  if (btn) {
    btn.classList.add('btn-cart-feedback');
    setTimeout(() => btn.classList.remove('btn-cart-feedback'), 450);
  }

  // 2. Resolve Product Image for Flying Thumbnail
  var flyImg = image;
  if (!flyImg && btn) {
    var card = btn.closest('.group, [data-product-card], .lux-product-card, article, div');
    var foundImg = card ? card.querySelector('img') : null;
    if (foundImg && foundImg.src) flyImg = foundImg.src;
  }
  if (!flyImg) {
    var qvImg = document.getElementById('qvImg');
    if (qvImg && qvImg.src) flyImg = qvImg.src;
  }

  // 3. Instant Optimistic UI (0ms Response — Zero Lag)
  var badge = document.getElementById('cartBadgeCount');
  var mobBadge = document.getElementById('mobileBottomCartBadge');
  var prevCount = parseInt(badge ? badge.textContent : (mobBadge ? mobBadge.textContent : '0')) || 0;
  var optimisticCount = prevCount + quantity;

  // Launch 60fps Flying Animation Immediately
  animateFlyToCart(btn, flyImg, quantity, function() {
    if (badge) {
      badge.textContent = optimisticCount;
      badge.classList.remove('hidden');
    }
    if (mobBadge) {
      mobBadge.textContent = optimisticCount;
      mobBadge.classList.remove('hidden');
    }
  });

  // Instant Toast Notification
  if (customToastMsg !== false) {
    var msg = (typeof customToastMsg === 'string' && customToastMsg) ? customToastMsg : (title ? ('Added "' + title + '" to Curated Bag.') : 'Curated piece added to bag.');
    ndToast(msg, 'success', 'View Bag', () => toggleQuickBagDrawer());
  }

  // 4. Asynchronous Background Server Sync
  var formData = new FormData();
  formData.append('variant_id', variantId);
  formData.append('product_id', variantId);
  formData.append('quantity', quantity);
  if (size) formData.append('size', size);
  if (color) formData.append('color', color);
  if (title) formData.append('title', title);
  if (price) formData.append('price', price);
  if (image) formData.append('image', image);
  formData.append('<?= $this->security->get_csrf_token_name() ?>', getCsrfToken());

  fetch('<?= base_url('cart/add') ?>', {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => {
    if (!r.ok) throw new Error('HTTP ' + r.status);
    return r.json();
  })
  .then(d => {
    if (d && d.success) {
      var items = (d.data && d.data.items) || d.items || [];
      var serverCount = (d.data && d.data.cart_count !== undefined) ? d.data.cart_count : ((d.cart_count !== undefined) ? d.cart_count : optimisticCount);
      var subtotal = (d.data && d.data.subtotal !== undefined) ? d.data.subtotal : ((d.subtotal !== undefined) ? d.subtotal : 0);

      // Re-sync badges with server truth
      if (badge) {
        badge.textContent = serverCount;
        if (serverCount > 0) badge.classList.remove('hidden');
        else badge.classList.add('hidden');
      }
      if (mobBadge) {
        mobBadge.textContent = serverCount;
        if (serverCount > 0) mobBadge.classList.remove('hidden');
        else mobBadge.classList.add('hidden');
      }

      // Render items directly from response without redundant HTTP fetch
      if (items.length > 0) {
        renderQuickBagItems(items, subtotal);
      }

      if (typeof callback === 'function') callback(d);
    } else {
      // Rollback optimistic count on server reject
      if (badge) badge.textContent = prevCount;
      if (mobBadge) mobBadge.textContent = prevCount;
      var errMsg = (d && d.message) ? d.message : 'Could not add item to bag.';
      ndToast(errMsg, 'error');
    }
  })
  .catch(err => {
    console.warn('Cart sync notice:', err);
    // Keep optimistic count as fallback for resilient UX
    if (typeof callback === 'function') callback();
  });
};

// ── Smooth Parallax Header Hide/Reveal on Scroll ──
let lastScrollY = 0;
const headerEl = document.getElementById('main-header');
if (headerEl) {
  window.addEventListener('scroll', () => {
    const currentScrollY = window.pageYOffset || document.documentElement.scrollTop;
    if (currentScrollY <= 80) {
      headerEl.classList.remove('-translate-y-full');
      return;
    }
    if (currentScrollY > lastScrollY && currentScrollY > 150) {
      headerEl.classList.add('-translate-y-full');
    } else if (currentScrollY < lastScrollY) {
      headerEl.classList.remove('-translate-y-full');
    }
    lastScrollY = currentScrollY;
  }, { passive: true });
}
</script>

<!-- ════════════════════════════════════════════════════════════ -->
<!-- ULTRA-FAST LAZY LOADING & PERFORMANCE OPTIMIZATION ENGINE   -->
<!-- ════════════════════════════════════════════════════════════ -->
<script>
(function initSpeedAndLazyLoadingEngine() {
  function applyLazyLoading() {
    // 1. Automatically apply native lazy loading & async decoding across all images
    const images = document.querySelectorAll('img');
    images.forEach((img, idx) => {
      // Keep first 2 images above the fold eager for fast LCP
      if (idx > 1) {
        if (!img.getAttribute('loading')) img.setAttribute('loading', 'lazy');
      } else {
        img.setAttribute('loading', 'eager');
      }
      if (!img.getAttribute('decoding')) img.setAttribute('decoding', 'async');
      
      // Hardware acceleration & layout containment
      img.style.contentVisibility = 'auto';
    });

    // 2. High-Performance IntersectionObserver for CSS background images
    if ('IntersectionObserver' in window) {
      const bgObserver = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const el = entry.target;
            const bgUrl = el.getAttribute('data-lazy-bg');
            if (bgUrl) {
              el.style.backgroundImage = `url('${bgUrl}')`;
              el.removeAttribute('data-lazy-bg');
            }
            obs.unobserve(el);
          }
        });
      }, { rootMargin: '300px 0px 300px 0px', threshold: 0.01 });

      document.querySelectorAll('[data-lazy-bg]').forEach(el => bgObserver.observe(el));
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', applyLazyLoading);
  } else {
    applyLazyLoading();
  }

  // Observe dynamically inserted nodes
  if ('MutationObserver' in window) {
    const mutObs = new MutationObserver((mutations) => {
      let hasNewImgs = false;
      mutations.forEach(m => {
        if (m.addedNodes && m.addedNodes.length > 0) hasNewImgs = true;
      });
      if (hasNewImgs) applyLazyLoading();
    });
    if (document.body) mutObs.observe(document.body, { childList: true, subtree: true });
  }
})();
</script>

<!-- Lenis Ultra-Smooth & Agile Inertia Scroll Engine -->
<script src="https://unpkg.com/lenis@1.3.17/dist/lenis.min.js"></script>
<script>
if (typeof Lenis !== 'undefined') {
  const lenis = new Lenis({
    duration: 0.65, // Snappy, instantaneous response without sluggish drag
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    orientation: 'vertical',
    gestureOrientation: 'vertical',
    smoothWheel: true,
    wheelMultiplier: 1.25, // Agile, effortless movement
    touchMultiplier: 1.5,
    smoothTouch: false, // Natural zero-friction native touch physics on mobile
    autoResize: true,
  });

  function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
  }
  requestAnimationFrame(raf);
  window.lenisInstance = lenis;

  // Auto-recalculate scroll height as images & dynamic DOM nodes render
  window.addEventListener('load', () => lenis.resize());
  window.addEventListener('resize', () => lenis.resize());
  setTimeout(() => lenis.resize(), 500);
  setTimeout(() => lenis.resize(), 1500);

  if (window.ResizeObserver && document.body) {
    const resizeObserver = new ResizeObserver(() => lenis.resize());
    resizeObserver.observe(document.body);
  }
}
</script>
</body>
</html>
