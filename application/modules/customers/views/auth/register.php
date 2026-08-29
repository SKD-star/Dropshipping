<div class="min-h-[85vh] flex items-center justify-center py-8 sm:py-12 px-4 sm:px-6">
  <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-12 rounded-3xl overflow-hidden shadow-2xl border border-stone-200/90 bg-white">
    
    <!-- Left Column: Editorial Atmospheric Brand Showcase -->
    <div class="md:col-span-5 relative bg-stone-950 text-white p-8 md:p-10 flex flex-col justify-between overflow-hidden hidden md:flex">
      <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1000&q=85" alt="Atelier Runway" class="w-full h-full object-cover opacity-45 filter saturate-[0.85] scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-black/60"></div>
      </div>

      <div class="relative z-10">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-mono uppercase tracking-widest text-[#e9c176] mb-6 border border-[#e9c176]/30">
          <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176] animate-pulse"></span>
          <span>New Collector Registration</span>
        </div>
        <h2 class="font-display-lg text-3xl font-serif font-light leading-snug">
          Join The Atelier<br/>
          <span class="font-serif italic text-[#e9c176] font-normal">Collective.</span>
        </h2>
      </div>

      <div class="relative z-10 border-t border-white/15 pt-6 text-xs text-white/70 font-light space-y-2.5 font-mono">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-sm text-[#e9c176]">redeem</span>
          <span>15% Welcome Privilege on First Piece</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-sm text-emerald-400">chat</span>
          <span>Direct WhatsApp Tailoring &amp; Design Notes</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-sm text-[#e9c176]">verified</span>
          <span>Numbered Certificate &amp; Priority Dispatch</span>
        </div>
      </div>
    </div>

    <!-- Right Column: Luxury Registration Form & Google Auth -->
    <div class="md:col-span-7 p-6 sm:p-10 md:p-12 flex flex-col justify-center bg-white">
      
      <div class="mb-6">
        <span class="font-mono text-[10px] text-[#a16207] uppercase tracking-[0.2em] block mb-1.5 font-bold">✦ Private Membership ✦</span>
        <h1 class="text-2xl sm:text-3xl text-stone-950 font-serif font-bold tracking-tight">Create Atelier Account</h1>
        <p class="text-xs text-stone-600 font-light mt-1.5 leading-relaxed">Register for express white-glove acquisitions and personalized design consultations.</p>
      </div>

      <!-- Google 1-Click Registration Button -->
      <a href="<?= base_url('account/google') ?>" class="w-full py-3 px-4 bg-white text-stone-800 border border-stone-300 rounded-xl hover:border-stone-950 hover:shadow-xs transition-all flex items-center justify-center gap-3 font-mono text-xs uppercase tracking-wider font-semibold mb-6 cursor-pointer active:scale-98">
        <svg class="w-4 h-4" viewBox="0 0 24 24">
          <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
          <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
          <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
          <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
        </svg>
        <span>Continue with Google</span>
      </a>

      <!-- Divider -->
      <div class="flex items-center gap-4 mb-6">
        <div class="flex-1 h-px bg-stone-200"></div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-stone-400">✦ Or Register with Details ✦</span>
        <div class="flex-1 h-px bg-stone-200"></div>
      </div>

      <form method="post" action="<?= base_url('account/register') ?>" class="space-y-4">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

        <!-- Full Name -->
        <div>
          <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 block mb-1 font-bold">Full Name *</label>
          <input type="text" name="name" value="<?= set_value('name') ?>" class="w-full text-xs bg-stone-50/80 px-3.5 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 outline-none font-sans" required placeholder="Elena Rostova">
          <?= form_error('name', '<div class="text-[11px] text-red-600 mt-1">', '</div>') ?>
        </div>

        <!-- Email Address -->
        <div>
          <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 block mb-1 font-bold">Email Address *</label>
          <input type="email" name="email" value="<?= set_value('email') ?>" class="w-full text-xs bg-stone-50/80 px-3.5 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 outline-none font-sans" required placeholder="elena@example.com">
          <?= form_error('email', '<div class="text-[11px] text-red-600 mt-1">', '</div>') ?>
        </div>

        <!-- WhatsApp Phone Number Input with Country Code -->
        <div>
          <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 flex items-center justify-between mb-1 font-bold">
            <span>WhatsApp / Mobile Number</span>
            <span class="text-emerald-700 flex items-center gap-1 font-bold text-[10px] bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
              <span class="material-symbols-outlined text-[13px]">chat</span>
              <span>WhatsApp Alerts</span>
            </span>
          </label>
          <div class="flex items-center gap-2">
            <select name="country_code" class="text-xs bg-stone-50/80 px-3 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white outline-none font-mono">
              <option value="+91" selected>🇮🇳 +91 (IN)</option>
              <option value="+1">🇺🇸 +1 (US)</option>
              <option value="+44">🇬🇧 +44 (UK)</option>
              <option value="+971">🇦🇪 +971 (UAE)</option>
              <option value="+33">🇫🇷 +33 (FR)</option>
              <option value="+49">🇩🇪 +49 (DE)</option>
              <option value="+81">🇯🇵 +81 (JP)</option>
              <option value="+65">🇸🇬 +65 (SG)</option>
            </select>
            <input type="tel" name="phone" value="<?= set_value('phone') ?>" class="flex-1 text-xs bg-stone-50/80 px-3.5 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 outline-none font-mono" placeholder="98765 43210">
          </div>
          <?= form_error('phone', '<div class="text-[11px] text-red-600 mt-1">', '</div>') ?>
        </div>

        <!-- Delivery Address / Residence (Requested by User) -->
        <div class="border-t border-stone-200 pt-3">
          <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 flex items-center justify-between mb-1.5 font-bold">
            <span>Delivery Address / Residence</span>
            <span class="text-[10px] text-stone-400 font-mono">For Priority White-Glove Transit</span>
          </label>
          
          <input type="text" name="address" value="<?= set_value('address') ?>" class="w-full text-xs bg-stone-50/80 px-3.5 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 outline-none font-sans mb-2" placeholder="House / Flat No., Street, Landmark">
          
          <div class="grid grid-cols-3 gap-2">
            <input type="text" name="city" value="<?= set_value('city') ?>" class="text-xs bg-stone-50/80 px-3 py-2.5 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white outline-none font-sans" placeholder="City">
            <input type="text" name="state" value="<?= set_value('state') ?>" class="text-xs bg-stone-50/80 px-3 py-2.5 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white outline-none font-sans" placeholder="State">
            <input type="text" name="pincode" value="<?= set_value('pincode') ?>" class="text-xs bg-stone-50/80 px-3 py-2.5 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white outline-none font-mono" placeholder="PIN Code">
          </div>
        </div>

        <!-- Password -->
        <div>
          <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 block mb-1 font-bold">Password * (Minimum 6 Characters)</label>
          <div class="relative">
            <input type="password" id="regPassword" name="password" class="w-full text-xs bg-stone-50/80 px-3.5 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 outline-none pr-10 font-sans" required placeholder="••••••••">
            <button type="button" onclick="togglePasswordVisibility('regPassword', this)" class="absolute right-3 top-3 text-stone-400 hover:text-stone-950 cursor-pointer">
              <span class="material-symbols-outlined text-base">visibility</span>
            </button>
          </div>
          <?= form_error('password', '<div class="text-[11px] text-red-600 mt-1">', '</div>') ?>
        </div>

        <!-- WhatsApp Opt-In Toggle -->
        <div class="p-3.5 bg-stone-50 rounded-xl border border-stone-200/80 flex items-start gap-3">
          <input type="checkbox" name="whatsapp_optin" id="whatsappOptin" value="1" checked class="accent-stone-950 w-4 h-4 mt-0.5 cursor-pointer">
          <label for="whatsappOptin" class="text-xs text-stone-700 leading-snug cursor-pointer select-none">
            <strong class="text-stone-950 block font-bold">Enable WhatsApp Concierge</strong>
            Receive bespoke lookbook previews, AI stylist design consultations, and real-time white-glove shipment milestones on WhatsApp.
          </label>
        </div>

        <button type="submit" class="w-full py-3.5 bg-stone-950 text-white font-mono text-xs uppercase tracking-widest hover:bg-stone-850 transition-colors shadow-md flex items-center justify-center gap-2 cursor-pointer rounded-xl font-bold active:scale-95 mt-2">
          <span>Create Atelier Account</span>
          <span class="material-symbols-outlined text-sm text-[#e9c176]">arrow_forward</span>
        </button>
      </form>

      <div class="mt-6 pt-4 border-t border-stone-200 text-center text-xs text-stone-600 font-light">
        Already registered? <a href="<?= base_url('account/login') ?>" class="text-[#a16207] font-bold hover:underline">Sign In Here →</a>
      </div>

    </div>

  </div>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
  var input = document.getElementById(inputId);
  var icon = btn.querySelector('.material-symbols-outlined');
  if (input.type === 'password') {
    input.type = 'text';
    icon.textContent = 'visibility_off';
  } else {
    input.type = 'password';
    icon.textContent = 'visibility';
  }
}
</script>
