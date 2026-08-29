<div class="min-h-[85vh] flex items-center justify-center py-8 sm:py-12 px-4 sm:px-6">
  <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-12 rounded-3xl overflow-hidden shadow-2xl border border-stone-200/90 bg-white">
    
    <!-- Left Column: Editorial Atmospheric Brand Showcase -->
    <div class="md:col-span-5 relative bg-stone-950 text-white p-8 md:p-10 flex flex-col justify-between overflow-hidden hidden md:flex">
      <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1000&q=85" alt="Atelier Couture" class="w-full h-full object-cover opacity-45 filter saturate-[0.85] scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-black/60"></div>
      </div>

      <div class="relative z-10">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-mono uppercase tracking-widest text-[#e9c176] mb-6 border border-[#e9c176]/30">
          <span class="w-1.5 h-1.5 rounded-full bg-[#e9c176] animate-pulse"></span>
          <span>Atelier VIP Access</span>
        </div>
        <h2 class="font-display-lg text-3xl font-serif font-light leading-snug">
          Where Craft Meets<br/>
          <span class="font-serif italic text-[#e9c176] font-normal">Considered Form.</span>
        </h2>
      </div>

      <div class="relative z-10 border-t border-white/15 pt-6 text-xs text-white/70 font-light space-y-2.5 font-mono">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-sm text-[#e9c176]">lock_open</span>
          <span>1-Click Passwordless OTP Access</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-sm text-[#e9c176]">verified</span>
          <span>Private Capsule Allocations &amp; Perks</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-sm text-[#e9c176]">local_shipping</span>
          <span>Live GPS Priority Express Tracking</span>
        </div>
      </div>
    </div>

    <!-- Right Column: Dual Auth System (1-Click OTP + Password) -->
    <div class="md:col-span-7 p-6 sm:p-10 md:p-12 flex flex-col justify-center bg-white">
      
      <div class="mb-6">
        <span class="font-mono text-[10px] text-[#a16207] uppercase tracking-[0.2em] block mb-1.5 font-bold">✦ Client Verification ✦</span>
        <h1 class="text-2xl sm:text-3xl text-stone-950 font-serif font-bold tracking-tight">Customer Sign In</h1>
        <p class="text-xs text-stone-600 font-light mt-1.5 leading-relaxed">Access your saved capsule wardrobe, live shipment tracking, and bespoke styling privileges.</p>
      </div>

      <!-- Auth Mode Tabs (OTP vs Password) -->
      <div class="flex p-1 bg-stone-100 rounded-2xl mb-6 border border-stone-200/80">
        <button type="button" id="tabOtpBtn" onclick="switchAuthTab('otp')" class="flex-1 py-2.5 text-xs font-mono font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm bg-stone-950 text-white flex items-center justify-center gap-1.5 cursor-pointer">
          <span class="material-symbols-outlined text-sm text-[#e9c176]">smartphone</span>
          <span>1-Click OTP Login</span>
        </button>
        <button type="button" id="tabPwdBtn" onclick="switchAuthTab('pwd')" class="flex-1 py-2.5 text-xs font-mono font-medium uppercase tracking-wider rounded-xl transition-all text-stone-600 hover:text-stone-950 flex items-center justify-center gap-1.5 cursor-pointer">
          <span class="material-symbols-outlined text-sm">key</span>
          <span>Password</span>
        </button>
      </div>

      <!-- Flash Messages -->
      <?php if ($this->session->flashdata('error')): ?>
      <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-sm">error</span>
        <span><?= $this->session->flashdata('error') ?></span>
      </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('success')): ?>
      <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-sm">check_circle</span>
        <span><?= $this->session->flashdata('success') ?></span>
      </div>
      <?php endif; ?>

      <!-- ══════════════════════════════════════════════
           TAB 1: 1-CLICK OTP LOGIN (PHONE + EMAIL)
      ══════════════════════════════════════════════ -->
      <div id="otpAuthPane" class="space-y-4">
        
        <!-- Step 1: Input Mobile Phone & Email -->
        <div id="otpStep1" class="space-y-3.5">
          <!-- Mobile Phone Field -->
          <div>
            <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 block mb-1.5 font-bold flex justify-between items-center">
              <span>Mobile Phone Number *</span>
              <span class="text-[10px] text-emerald-700 font-bold bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">● OTP Sent Here</span>
            </label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-lg">call</span>
              <input type="tel" id="otpPhoneInput" placeholder="e.g. 9876543210" required
                     class="w-full pl-11 pr-4 py-3.5 bg-stone-50/80 border border-stone-300 rounded-xl text-xs font-mono text-stone-950 outline-none focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 transition-all shadow-2xs">
            </div>
          </div>

          <!-- Email Address Field -->
          <div>
            <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 block mb-1.5 font-bold flex justify-between items-center">
              <span>Email Address *</span>
              <span class="text-[10px] text-stone-400 font-mono">For Invoices &amp; VIP Perks</span>
            </label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-lg">mail</span>
              <input type="email" id="otpEmailInput" placeholder="client@domain.com" required
                     class="w-full pl-11 pr-4 py-3.5 bg-stone-50/80 border border-stone-300 rounded-xl text-xs font-mono text-stone-950 outline-none focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 transition-all shadow-2xs">
            </div>
            <span class="text-[10px] text-stone-500 font-mono mt-1.5 block">Instant 6-digit authentication code will be sent to your mobile phone via SMS / WhatsApp.</span>
          </div>

          <button type="button" id="sendOtpBtn" onclick="requestCustomerOtp()" class="w-full py-3.5 bg-stone-950 hover:bg-stone-850 text-white font-mono text-xs uppercase tracking-widest font-extrabold rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer active:scale-95">
            <span>Get 6-Digit OTP Code</span>
            <span class="material-symbols-outlined text-sm text-[#e9c176]">send</span>
          </button>
        </div>

        <!-- Step 2: Enter 6-Digit OTP -->
        <div id="otpStep2" class="space-y-4 hidden">
          <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs font-mono text-amber-900 flex justify-between items-center">
            <span id="otpSentTargetText">Code sent to: +91 98765 43210</span>
            <button type="button" onclick="resetOtpStep()" class="text-xs text-[#a16207] underline font-bold cursor-pointer">Edit</button>
          </div>

          <div>
            <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 block mb-2 font-bold text-center">
              Enter 6-Digit Verification Code
            </label>
            
            <!-- 6-Box Digits Grid -->
            <div class="flex justify-center gap-2 sm:gap-3" id="otpBoxContainer">
              <input type="text" maxlength="1" class="otp-box w-11 h-12 text-center text-lg font-mono font-bold bg-stone-50 border-2 border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:outline-none transition-all" data-idx="0">
              <input type="text" maxlength="1" class="otp-box w-11 h-12 text-center text-lg font-mono font-bold bg-stone-50 border-2 border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:outline-none transition-all" data-idx="1">
              <input type="text" maxlength="1" class="otp-box w-11 h-12 text-center text-lg font-mono font-bold bg-stone-50 border-2 border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:outline-none transition-all" data-idx="2">
              <input type="text" maxlength="1" class="otp-box w-11 h-12 text-center text-lg font-mono font-bold bg-stone-50 border-2 border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:outline-none transition-all" data-idx="3">
              <input type="text" maxlength="1" class="otp-box w-11 h-12 text-center text-lg font-mono font-bold bg-stone-50 border-2 border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:outline-none transition-all" data-idx="4">
              <input type="text" maxlength="1" class="otp-box w-11 h-12 text-center text-lg font-mono font-bold bg-stone-50 border-2 border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:outline-none transition-all" data-idx="5">
            </div>
          </div>

          <!-- Auto / Quick Fill Demo Code Pill -->
          <div class="flex items-center justify-between text-xs font-mono pt-1">
            <button type="button" id="quickFillOtpBtn" onclick="quickFillDemoOtp()" class="text-emerald-700 hover:text-emerald-900 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-lg font-bold text-[10px] uppercase cursor-pointer">
              ⚡ Quick Fill Code: <span id="demoOtpBadge">123456</span>
            </button>
            <span id="otpCountdownText" class="text-stone-500 text-[11px]">Resend in <strong id="timerVal">30s</strong></span>
          </div>

          <button type="button" id="verifyOtpBtn" onclick="submitVerifyOtp()" class="w-full py-3.5 bg-stone-950 hover:bg-stone-850 text-white font-mono text-xs uppercase tracking-widest font-extrabold rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer active:scale-95 border border-stone-900">
            <span class="material-symbols-outlined text-sm text-[#e9c176]">lock_open</span>
            <span>Verify &amp; Enter Atelier</span>
          </button>
        </div>

      </div>

      <!-- ══════════════════════════════════════════════
           TAB 2: TRADITIONAL PASSWORD SIGN IN
      ══════════════════════════════════════════════ -->
      <div id="pwdAuthPane" class="space-y-4 hidden">
        <form method="post" action="<?= base_url('account/login' . (!empty($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '')) ?>" class="space-y-4">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
          <?php if (!empty($_GET['redirect'])): ?>
          <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect']) ?>">
          <?php endif; ?>

          <div>
            <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 block mb-1 font-bold">Email Address *</label>
            <input type="email" name="email" value="<?= set_value('email') ?>" class="w-full text-xs bg-stone-50/80 px-3.5 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 outline-none font-sans" required placeholder="your.name@example.com">
            <?= form_error('email', '<div class="text-[11px] text-red-600 mt-1">', '</div>') ?>
          </div>

          <div>
            <div class="flex justify-between items-center mb-1">
              <label class="font-mono text-[11px] uppercase tracking-wider text-stone-700 font-bold">Password *</label>
              <a href="<?= base_url('account/forgot-password') ?>" class="text-[11px] text-[#a16207] hover:underline font-mono uppercase tracking-wider font-bold">Forgot Password?</a>
            </div>
            <div class="relative">
              <input type="password" id="loginPassword" name="password" class="w-full text-xs bg-stone-50/80 px-3.5 py-3 border border-stone-300 rounded-xl focus:border-stone-950 focus:bg-white focus:ring-1 focus:ring-stone-950 outline-none pr-10 font-sans" required placeholder="••••••••">
              <button type="button" onclick="togglePasswordVisibility('loginPassword', this)" class="absolute right-3 top-3 text-stone-400 hover:text-stone-950 cursor-pointer">
                <span class="material-symbols-outlined text-base">visibility</span>
              </button>
            </div>
            <?= form_error('password', '<div class="text-[11px] text-red-600 mt-1">', '</div>') ?>
          </div>

          <button type="submit" class="w-full py-3.5 bg-stone-950 text-white font-mono text-xs uppercase tracking-widest hover:bg-stone-850 transition-colors shadow-md flex items-center justify-center gap-2 cursor-pointer rounded-xl font-bold active:scale-95">
            <span>Authorize Access</span>
            <span class="material-symbols-outlined text-sm text-[#e9c176]">arrow_forward</span>
          </button>
        </form>
      </div>

      <!-- Divider -->
      <div class="flex items-center gap-4 my-6">
        <div class="flex-1 h-px bg-stone-200"></div>
        <span class="font-mono text-[10px] uppercase tracking-widest text-stone-400">✦ Or Connect With ✦</span>
        <div class="flex-1 h-px bg-stone-200"></div>
      </div>

      <!-- Google 1-Click Button -->
      <a href="<?= base_url('account/google') ?>" class="w-full py-3 px-4 bg-white text-stone-800 border border-stone-300 rounded-xl hover:border-stone-950 hover:shadow-xs transition-all flex items-center justify-center gap-3 font-mono text-xs uppercase tracking-wider font-semibold cursor-pointer active:scale-98">
        <svg class="w-4 h-4" viewBox="0 0 24 24">
          <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
          <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
          <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
          <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
        </svg>
        <span>Continue with Google</span>
      </a>

      <div class="mt-6 pt-4 border-t border-stone-200 text-center text-xs text-stone-600 font-light">
        New to Lumina Atelier? <a href="<?= base_url('account/register') ?>" class="text-[#a16207] font-bold hover:underline">Create Full Profile →</a>
      </div>

    </div>

  </div>
</div>

<script>
var activeAuthTab = 'otp';
var activeOtpPhone = '';
var activeOtpEmail = '';
var activeDemoOtp = '123456';
var countdownInterval = null;
var redirectParam = '<?= htmlspecialchars($_GET['redirect'] ?? '') ?>';

function switchAuthTab(tab) {
  activeAuthTab = tab;
  var tabOtpBtn = document.getElementById('tabOtpBtn');
  var tabPwdBtn = document.getElementById('tabPwdBtn');
  var otpPane = document.getElementById('otpAuthPane');
  var pwdPane = document.getElementById('pwdAuthPane');

  if (tab === 'otp') {
    tabOtpBtn.className = 'flex-1 py-2.5 text-xs font-mono font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm bg-stone-950 text-white flex items-center justify-center gap-1.5 cursor-pointer';
    tabPwdBtn.className = 'flex-1 py-2.5 text-xs font-mono font-medium uppercase tracking-wider rounded-xl transition-all text-stone-600 hover:text-stone-950 flex items-center justify-center gap-1.5 cursor-pointer';
    otpPane.classList.remove('hidden');
    pwdPane.classList.add('hidden');
  } else {
    tabPwdBtn.className = 'flex-1 py-2.5 text-xs font-mono font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm bg-stone-950 text-white flex items-center justify-center gap-1.5 cursor-pointer';
    tabOtpBtn.className = 'flex-1 py-2.5 text-xs font-mono font-medium uppercase tracking-wider rounded-xl transition-all text-stone-600 hover:text-stone-950 flex items-center justify-center gap-1.5 cursor-pointer';
    pwdPane.classList.remove('hidden');
    otpPane.classList.add('hidden');
  }
}

function requestCustomerOtp() {
  var phoneInput = document.getElementById('otpPhoneInput');
  var emailInput = document.getElementById('otpEmailInput');
  var phone = (phoneInput ? phoneInput.value : '').trim();
  var email = (emailInput ? emailInput.value : '').trim();

  if (!phone) {
    if (typeof ndToast === 'function') ndToast('Please enter your mobile phone number.', 'error');
    else alert('Please enter your mobile phone number.');
    if (phoneInput) phoneInput.focus();
    return;
  }

  if (!email || !email.includes('@')) {
    if (typeof ndToast === 'function') ndToast('Please enter a valid email address.', 'error');
    else alert('Please enter a valid email address.');
    if (emailInput) emailInput.focus();
    return;
  }

  var btn = document.getElementById('sendOtpBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> <span>Sending OTP...</span>';

  var fd = new FormData();
  fd.append('phone', phone);
  fd.append('email', email);
  fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url('account/send-otp') ?>', {
    method: 'POST',
    body: fd,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(res => {
    btn.disabled = false;
    btn.innerHTML = '<span>Get 6-Digit OTP Code</span> <span class="material-symbols-outlined text-sm text-[#e9c176]">send</span>';
    
    if (res.success) {
      activeOtpPhone = phone;
      activeOtpEmail = email;
      activeDemoOtp = res.data?.demo_otp || '123456';
      
      document.getElementById('otpSentTargetText').textContent = 'Code sent to: ' + phone + ' (' + email + ')';
      document.getElementById('demoOtpBadge').textContent = activeDemoOtp;
      
      document.getElementById('otpStep1').classList.add('hidden');
      document.getElementById('otpStep2').classList.remove('hidden');
      
      // Auto-focus first digit box
      var firstBox = document.querySelector('.otp-box[data-idx="0"]');
      if (firstBox) firstBox.focus();

      startOtpCountdown(30);

      if (typeof ndToast === 'function') {
        ndToast('✓ 6-Digit OTP sent to ' + phone + ' (Code: ' + activeDemoOtp + ')', 'success');
      }
    } else {
      if (typeof ndToast === 'function') ndToast(res.message || 'Unable to send OTP', 'error');
      else alert(res.message);
    }
  })
  .catch(err => {
    btn.disabled = false;
    btn.innerHTML = '<span>Get 6-Digit OTP Code</span> <span class="material-symbols-outlined text-sm text-[#e9c176]">send</span>';
    if (typeof ndToast === 'function') ndToast('Network error while requesting OTP', 'error');
  });
}

function resetOtpStep() {
  document.getElementById('otpStep2').classList.add('hidden');
  document.getElementById('otpStep1').classList.remove('hidden');
  if (countdownInterval) clearInterval(countdownInterval);
}

function startOtpCountdown(seconds) {
  if (countdownInterval) clearInterval(countdownInterval);
  var s = seconds;
  var cdText = document.getElementById('otpCountdownText');
  cdText.innerHTML = 'Resend in <strong id="timerVal">' + s + 's</strong>';
  
  countdownInterval = setInterval(() => {
    s--;
    if (s <= 0) {
      clearInterval(countdownInterval);
      cdText.innerHTML = '<button type="button" onclick="requestCustomerOtp()" class="text-[#a16207] underline font-bold cursor-pointer">Resend OTP</button>';
    } else {
      var timerEl = document.getElementById('timerVal');
      if (timerEl) timerEl.textContent = s + 's';
    }
  }, 1000);
}

function quickFillDemoOtp() {
  var digits = activeDemoOtp.split('');
  var boxes = document.querySelectorAll('.otp-box');
  boxes.forEach((box, i) => {
    box.value = digits[i] || '';
  });
  if (boxes[5]) boxes[5].focus();
  setTimeout(submitVerifyOtp, 250);
}

function getEnteredOtp() {
  var boxes = document.querySelectorAll('.otp-box');
  var code = '';
  boxes.forEach(b => code += (b.value || ''));
  return code.trim();
}

function submitVerifyOtp() {
  var code = getEnteredOtp();
  if (code.length < 6) {
    if (typeof ndToast === 'function') ndToast('Please enter the full 6-digit OTP code.', 'error');
    else alert('Please enter the full 6-digit OTP code.');
    return;
  }

  var btn = document.getElementById('verifyOtpBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> <span>Verifying &amp; Securing Access...</span>';

  var fd = new FormData();
  fd.append('phone', activeOtpPhone);
  fd.append('email', activeOtpEmail);
  fd.append('otp_code', code);
  fd.append('redirect', redirectParam);
  fd.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');

  fetch('<?= base_url('account/verify-otp') ?>', {
    method: 'POST',
    body: fd,
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(r => r.json())
  .then(res => {
    if (res.success) {
      if (typeof ndToast === 'function') ndToast('✓ Logged in successfully!', 'success');
      setTimeout(() => {
        window.location.href = res.data?.redirect || '<?= base_url('account') ?>';
      }, 350);
    } else {
      btn.disabled = false;
      btn.innerHTML = '<span class="material-symbols-outlined text-sm text-[#e9c176]">lock_open</span> <span>Verify &amp; Enter Atelier</span>';
      if (typeof ndToast === 'function') ndToast(res.message || 'Verification failed', 'error');
      else alert(res.message);
    }
  })
  .catch(() => {
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-sm text-[#e9c176]">lock_open</span> <span>Verify &amp; Enter Atelier</span>';
    if (typeof ndToast === 'function') ndToast('Network error during verification', 'error');
  });
}

// Digits input auto-focus navigation
document.addEventListener('DOMContentLoaded', () => {
  var boxes = document.querySelectorAll('.otp-box');
  boxes.forEach((box, index) => {
    box.addEventListener('input', (e) => {
      var val = e.target.value;
      if (val.length >= 1) {
        e.target.value = val.slice(-1);
        if (index < boxes.length - 1) {
          boxes[index + 1].focus();
        } else {
          // All 6 digits filled -> auto-submit
          setTimeout(submitVerifyOtp, 200);
        }
      }
    });

    box.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !e.target.value && index > 0) {
        boxes[index - 1].focus();
      }
    });

    box.addEventListener('paste', (e) => {
      e.preventDefault();
      var paste = (e.clipboardData || window.clipboardData).getData('text').trim();
      if (paste) {
        var pDigits = paste.replace(/\D/g, '').split('');
        boxes.forEach((b, i) => {
          if (pDigits[i]) b.value = pDigits[i];
        });
        if (pDigits.length >= 6) {
          setTimeout(submitVerifyOtp, 200);
        }
      }
    });
  });
});

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
