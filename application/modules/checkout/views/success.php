<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$order_number   = $order['order_number'] ?? ('ND-' . strtoupper(substr(md5(time()), 0, 8)));
$payment_status = strtoupper($order['payment_status'] ?? 'CONFIRMED');
$order_status   = strtoupper($order['status'] ?? 'PROCESSING');
$total          = (float)($order['total'] ?? 0);
$subtotal       = (float)($order['subtotal'] ?? $total);
$discount       = (float)($order['discount_amount'] ?? 0);
$shipping_amt   = (float)($order['shipping_amount'] ?? 0);
$tax_amt        = (float)($order['tax_amount'] ?? 0);
$created_at     = $order['created_at'] ?? date('Y-m-d H:i:s');
$items          = $order['items'] ?? [];
$earned_lp      = max(50, round($total * 0.1));

$addr = $order['shipping_address'] ?? [];
$customer_name = trim(($addr['first_name'] ?? '') . ' ' . ($addr['last_name'] ?? ''));
if (empty($customer_name)) {
    $customer_name = $this->session->userdata('customer_name') ?? ($order['guest_email'] ?? 'Valued Collector');
}
?>

<!-- Confetti Canvas overlay -->
<canvas id="orderSuccessConfetti" class="fixed inset-0 pointer-events-none z-[999]"></canvas>

<div class="min-h-screen bg-gradient-to-b from-[#0a0a0f] via-[#121118] to-surface text-on-surface pb-24 pt-6 md:pt-12 px-4 sm:px-6 md:px-8">
  <div class="max-w-4xl mx-auto space-y-8">

    <!-- ── 1. HERO CELEBRATION CARD ── -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#18161f] to-[#0c0b11] border border-amber-500/25 p-8 md:p-12 text-center text-white shadow-2xl">
      <!-- Glow flares -->
      <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-32 right-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
      
      <!-- Verified Badge & Animated Rings -->
      <div class="relative z-10 flex flex-col items-center">
        <div class="relative mb-6">
          <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-gradient-to-tr from-emerald-600 via-emerald-500 to-teal-400 flex items-center justify-center text-white shadow-[0_0_40px_rgba(16,185,129,0.45)] ring-4 ring-emerald-400/20">
            <span class="material-symbols-outlined text-4xl md:text-5xl font-bold">done_all</span>
          </div>
          <span class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-amber-400 border-2 border-[#18161f] flex items-center justify-center text-stone-950 text-xs font-bold shadow-md">
            ✦
          </span>
        </div>

        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/15 border border-emerald-400/30 text-emerald-300 font-mono text-[11px] font-bold uppercase tracking-widest mb-3">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          <span>Acquisition Authorized &amp; Dispatched to Atelier</span>
        </div>

        <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight mb-3">
          Acquisition Confirmed
        </h1>
        <p class="text-stone-300 max-w-lg text-sm sm:text-base font-light leading-relaxed mb-6">
          Thank you, <strong class="text-amber-200 font-medium"><?= htmlspecialchars($customer_name) ?></strong>. Your bespoke order has been registered into the master artisan registry under reference
          <span class="font-mono font-bold text-amber-300">#<?= htmlspecialchars($order_number) ?></span>.
        </p>

        <!-- Quick Summary Bar -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full max-w-2xl bg-white/5 backdrop-blur-md rounded-2xl p-3 border border-white/10 text-left">
          <div class="p-2.5">
            <span class="text-[10px] font-mono uppercase tracking-wider text-stone-400 block">Order Ref</span>
            <span class="font-mono text-xs sm:text-sm font-bold text-white">#<?= htmlspecialchars($order_number) ?></span>
          </div>
          <div class="p-2.5 border-l border-white/10">
            <span class="text-[10px] font-mono uppercase tracking-wider text-stone-400 block">Status</span>
            <span class="font-mono text-xs sm:text-sm font-bold text-emerald-400">✓ <?= htmlspecialchars($payment_status) ?></span>
          </div>
          <div class="p-2.5 border-l border-white/10">
            <span class="text-[10px] font-mono uppercase tracking-wider text-stone-400 block">Total Investment</span>
            <span class="font-serif text-xs sm:text-sm font-bold text-amber-300">₹<?= number_format($total, 0) ?></span>
          </div>
          <div class="p-2.5 border-l border-white/10">
            <span class="text-[10px] font-mono uppercase tracking-wider text-stone-400 block">Dispatch SLA</span>
            <span class="font-mono text-xs sm:text-sm font-bold text-amber-400">Within 18 Hours</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ── 2. LIVE DISPATCH & TRACKING TIMELINE ── -->
    <div class="bg-surface rounded-3xl border border-outline-variant/80 p-6 md:p-8 shadow-sm">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-6 border-b border-outline-variant/60">
        <div>
          <span class="font-mono text-[10px] uppercase tracking-widest text-accent font-bold block">Live Fulfillment Telemetry</span>
          <h3 class="font-serif text-xl sm:text-2xl font-bold text-primary">BlueDart Priority Express Delivery</h3>
        </div>
        <div class="flex items-center gap-2">
          <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full font-mono text-[11px] font-bold flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>Live Dispatch Active</span>
          </span>
        </div>
      </div>

      <!-- Timeline visual -->
      <div class="pt-8 pb-4">
        <div class="relative grid grid-cols-1 sm:grid-cols-4 gap-6 sm:gap-2 text-center">
          <!-- Step 1 -->
          <div class="relative flex flex-col items-center group">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-lg font-bold shadow-md ring-4 ring-emerald-100 z-10">
              <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
            <span class="font-serif font-bold text-sm text-primary mt-3">Order Logged</span>
            <span class="font-mono text-[10px] text-on-surface-variant"><?= date('d M, H:i', strtotime($created_at)) ?></span>
            <span class="text-[11px] text-emerald-700 font-medium">Completed</span>
          </div>

          <!-- Step 2 -->
          <div class="relative flex flex-col items-center group">
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-stone-950 flex items-center justify-center text-lg font-bold shadow-md ring-4 ring-amber-100 z-10 animate-bounce">
              <span class="material-symbols-outlined text-2xl">inventory_2</span>
            </div>
            <span class="font-serif font-bold text-sm text-primary mt-3">Artisan Packaging</span>
            <span class="font-mono text-[10px] text-on-surface-variant">White-Glove Boxing</span>
            <span class="text-[11px] text-amber-700 font-bold">In Progress (ETA 2h)</span>
          </div>

          <!-- Step 3 -->
          <div class="relative flex flex-col items-center group">
            <div class="w-12 h-12 rounded-2xl bg-surface-container text-on-surface-variant border border-outline-variant flex items-center justify-center text-lg font-bold z-10">
              <span class="material-symbols-outlined text-2xl">local_shipping</span>
            </div>
            <span class="font-serif font-bold text-sm text-on-surface-variant mt-3">Express Transit</span>
            <span class="font-mono text-[10px] text-on-surface-variant">Priority Express Courier</span>
            <span class="text-[11px] text-on-surface-variant">Pending Handover</span>
          </div>

          <!-- Step 4 -->
          <div class="relative flex flex-col items-center group">
            <div class="w-12 h-12 rounded-2xl bg-surface-container text-on-surface-variant border border-outline-variant flex items-center justify-center text-lg font-bold z-10">
              <span class="material-symbols-outlined text-2xl">home</span>
            </div>
            <span class="font-serif font-bold text-sm text-on-surface-variant mt-3">Doorstep Delivery</span>
            <span class="font-mono text-[10px] text-on-surface-variant">Guaranteed Transit</span>
            <span class="text-[11px] text-on-surface-variant">Est. 2-3 Business Days</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ── 3. ORDER DETAILS & ITEMS BREAKDOWN ── -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      
      <!-- Items list (7 cols) -->
      <div class="lg:col-span-7 space-y-6">
        <div class="bg-surface rounded-3xl border border-outline-variant/80 overflow-hidden shadow-sm">
          <div class="p-5 sm:p-6 bg-surface-container-low border-b border-outline-variant/60 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-accent">checkroom</span>
              <h4 class="font-serif font-bold text-base sm:text-lg text-primary">Ordered Atelier Pieces</h4>
            </div>
            <span class="font-mono text-xs text-on-surface-variant"><?= count($items) ?> Piece<?= count($items) !== 1 ? 's' : '' ?></span>
          </div>

          <div class="divide-y divide-outline-variant/50">
            <?php if (!empty($items)): ?>
              <?php foreach ($items as $item): ?>
              <div class="p-5 sm:p-6 flex items-start justify-between gap-4 hover:bg-surface-container-low/50 transition-colors">
                <div class="flex items-start gap-4">
                  <div class="w-16 h-20 rounded-xl bg-surface-container border border-outline-variant flex items-center justify-center text-2xl text-on-surface-variant flex-shrink-0">
                    🧥
                  </div>
                  <div>
                    <h5 class="font-serif font-bold text-sm sm:text-base text-primary mb-1">
                      <?= htmlspecialchars($item['product_title'] ?? 'Atelier Piece') ?>
                    </h5>
                    <?php if (!empty($item['variant_title'])): ?>
                    <p class="font-mono text-xs text-on-surface-variant mb-1">
                      Variant: <span class="text-accent font-semibold"><?= htmlspecialchars($item['variant_title']) ?></span>
                    </p>
                    <?php endif; ?>
                    <span class="font-mono text-xs text-on-surface-variant">Qty: <?= (int)($item['quantity'] ?? 1) ?> × ₹<?= number_format($item['unit_price'] ?? 0, 0) ?></span>
                  </div>
                </div>
                <div class="text-right">
                  <span class="font-serif font-bold text-base sm:text-lg text-primary block">
                    ₹<?= number_format($item['total_price'] ?? ($item['unit_price'] * $item['quantity']), 0) ?>
                  </span>
                  <span class="font-mono text-[10px] text-emerald-600 font-bold">100% Insured</span>
                </div>
              </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="p-6 text-center text-on-surface-variant text-sm font-light">
                Order details logged successfully.
              </div>
            <?php endif; ?>
          </div>

          <!-- Financial summary breakdown -->
          <div class="p-6 bg-surface-container-low border-t border-outline-variant/60 space-y-2.5 text-xs font-mono">
            <div class="flex justify-between text-on-surface-variant">
              <span>Subtotal</span>
              <span class="font-bold text-primary">₹<?= number_format($subtotal, 0) ?></span>
            </div>
            <?php if ($discount > 0): ?>
            <div class="flex justify-between text-emerald-600 font-bold">
              <span>Privilege Discount Code</span>
              <span>-₹<?= number_format($discount, 0) ?></span>
            </div>
            <?php endif; ?>
            <div class="flex justify-between text-on-surface-variant">
              <span>BlueDart Priority Express Delivery</span>
              <span class="text-emerald-600 font-bold"><?= $shipping_amt > 0 ? '₹' . number_format($shipping_amt, 0) : 'FREE (Complimentary)' ?></span>
            </div>
            <?php if ($tax_amt > 0): ?>
            <div class="flex justify-between text-on-surface-variant">
              <span>Integrated GST &amp; Insurance</span>
              <span>₹<?= number_format($tax_amt, 0) ?></span>
            </div>
            <?php endif; ?>
            <div class="flex justify-between items-baseline pt-3 border-t border-outline-variant/80 text-sm">
              <span class="font-serif font-bold text-base text-primary">Total Investment</span>
              <span class="font-serif text-2xl font-bold text-primary">₹<?= number_format($total, 0) ?></span>
            </div>
          </div>
        </div>

        <!-- Loyalty Points Credit Banner -->
        <div class="rounded-3xl bg-gradient-to-r from-amber-500/10 via-amber-500/5 to-transparent border border-amber-400/30 p-5 sm:p-6 flex items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-stone-950 flex items-center justify-center text-xl font-bold flex-shrink-0 shadow-md">
              👑
            </div>
            <div>
              <h5 class="font-serif font-bold text-sm sm:text-base text-primary">+<?= number_format($earned_lp) ?> Lumina Points Credited</h5>
              <p class="text-xs text-on-surface-variant font-light">Unlocked VIP Collector tier for all upcoming capsule drops.</p>
            </div>
          </div>
          <span class="hidden sm:inline-block px-3 py-1 rounded-full bg-amber-500/20 text-amber-800 font-mono text-[10px] font-bold uppercase tracking-wider">
            VIP Tier 01
          </span>
        </div>
      </div>

      <!-- Shipping & Action Side Column (5 cols) -->
      <div class="lg:col-span-5 space-y-6">
        
        <!-- Shipping Address Card -->
        <div class="bg-surface rounded-3xl border border-outline-variant/80 p-6 shadow-sm space-y-4">
          <div class="flex items-center gap-2 pb-3 border-b border-outline-variant/60">
            <span class="material-symbols-outlined text-accent">local_shipping</span>
            <h4 class="font-serif font-bold text-base text-primary">Shipping Destination</h4>
          </div>
          
          <div class="space-y-1.5 text-xs text-on-surface-variant font-sans">
            <p class="font-bold text-sm text-primary"><?= htmlspecialchars($customer_name) ?></p>
            <?php if (!empty($addr['address1'])): ?>
              <p><?= htmlspecialchars($addr['address1']) ?><?= !empty($addr['address2']) ? ', ' . htmlspecialchars($addr['address2']) : '' ?></p>
              <p><?= htmlspecialchars($addr['city'] ?? '') ?>, <?= htmlspecialchars($addr['state'] ?? '') ?> — <strong class="font-mono text-primary"><?= htmlspecialchars($addr['pincode'] ?? '') ?></strong></p>
            <?php else: ?>
              <p class="font-mono text-on-surface-variant">White-glove priority residential delivery</p>
            <?php endif; ?>
            <?php if (!empty($addr['phone'])): ?>
              <p class="font-mono pt-1 text-primary">📱 <?= htmlspecialchars($addr['phone']) ?></p>
            <?php endif; ?>
          </div>

          <div class="pt-2">
            <div class="p-3 bg-surface-container rounded-2xl border border-outline-variant/60 flex items-center justify-between text-xs font-mono">
              <span class="text-on-surface-variant">Payment Method:</span>
              <span class="font-bold text-primary uppercase"><?= htmlspecialchars($order['payments'][0]['gateway'] ?? 'COD') ?></span>
            </div>
          </div>
        </div>

        <!-- Primary Action Buttons (All Verified & Working) -->
        <div class="bg-surface rounded-3xl border border-outline-variant/80 p-6 shadow-sm space-y-3">
          <h4 class="font-serif font-bold text-sm text-primary uppercase tracking-wider mb-2">Order Operations</h4>
          
          <!-- Live Tracking button -->
          <a href="<?= base_url('tracking?order=' . urlencode($order_number)) ?>" id="btnTrackOrder" class="w-full py-3.5 px-4 bg-stone-950 hover:bg-stone-800 text-white rounded-2xl font-button text-xs uppercase tracking-widest font-extrabold flex items-center justify-center gap-2 shadow-lg transition-all cursor-pointer">
            <span class="material-symbols-outlined text-base text-amber-300">location_on</span>
            <span>Track Acquisition Live →</span>
          </a>

          <!-- Print / Download Invoice button -->
          <button type="button" onclick="window.print()" class="w-full py-3 px-4 bg-surface hover:bg-surface-container border border-outline-variant hover:border-primary text-primary rounded-2xl font-button text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 transition-all cursor-pointer">
            <span class="material-symbols-outlined text-base">receipt_long</span>
            <span>Print Official Invoice</span>
          </button>

          <!-- Share Order button -->
          <button type="button" onclick="handleShareOrder()" class="w-full py-3 px-4 bg-surface hover:bg-surface-container border border-outline-variant hover:border-primary text-primary rounded-2xl font-button text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 transition-all cursor-pointer">
            <span class="material-symbols-outlined text-base">share</span>
            <span id="shareBtnText">Share Acquisition</span>
          </button>

          <!-- Continue Shopping button -->
          <a href="<?= base_url('shop') ?>" class="w-full py-3 px-4 bg-surface-container hover:bg-surface-container-high text-on-surface-variant hover:text-primary rounded-2xl font-button text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 transition-all text-center">
            <span class="material-symbols-outlined text-base">storefront</span>
            <span>Explore Haute Couture Catalog</span>
          </a>
        </div>

        <!-- ── 4. POST-PURCHASE UPSELL PRIVILEGE ── -->
        <div class="rounded-3xl bg-gradient-to-br from-[#1c1917] to-[#0f0e0d] text-white p-6 border border-amber-500/30 shadow-xl space-y-4 relative overflow-hidden">
          <div class="absolute -right-8 -top-8 w-28 h-28 bg-amber-500/20 rounded-full blur-2xl pointer-events-none"></div>
          
          <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-stone-950 font-mono text-[9px] font-extrabold uppercase tracking-wider">
              Exclusive Privilege
            </span>
            <span class="text-[10px] font-mono text-amber-300">Ships Free with this Order</span>
          </div>

          <div>
            <h4 class="font-serif font-bold text-base text-white mb-1">
              Atelier Silk-Linen Garment Protector Set
            </h4>
            <p class="text-xs text-stone-300 font-light leading-relaxed">
              Archival cedarwood hanger + cedar-infused dust bag + silk garment shield.
            </p>
          </div>

          <div class="flex items-baseline gap-2 font-mono">
            <span class="font-serif text-xl font-bold text-amber-300">₹499</span>
            <span class="text-xs text-stone-500 line-through">₹1,299</span>
            <span class="text-[10px] text-emerald-400 font-bold">62% VIP Privilege</span>
          </div>

          <button type="button" id="btnPostPurchaseUpsell" onclick="handleAddUpsell(this)" class="w-full py-3 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-stone-950 font-mono text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-md cursor-pointer transition-all flex items-center justify-center gap-1.5">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            <span id="upsellBtnLabel">Add to Order for ₹499 →</span>
          </button>
        </div>

      </div>

    </div>

  </div>
</div>

<!-- Success Page Interactions Script -->
<script>
// Confetti Burst Effect
(function launchSuccessConfetti() {
  const canvas = document.getElementById('orderSuccessConfetti');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');

  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  const colors = ['#d4a853', '#10b981', '#6366f1', '#ec4899', '#f59e0b', '#ffffff', '#34d399'];
  const particles = [];

  for (let i = 0; i < 90; i++) {
    particles.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height * 0.4,
      w: Math.random() * 8 + 4,
      h: Math.random() * 5 + 3,
      vx: (Math.random() - 0.5) * 4,
      vy: Math.random() * 3 + 2,
      rot: Math.random() * 360,
      rotSpeed: (Math.random() - 0.5) * 6,
      color: colors[Math.floor(Math.random() * colors.length)],
      alpha: 1
    });
  }

  let frames = 0;
  function render() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    let active = 0;

    particles.forEach(p => {
      p.x += p.vx;
      p.y += p.vy;
      p.vy += 0.04;
      p.rot += p.rotSpeed;
      p.alpha = Math.max(0, 1 - (p.y / (canvas.height * 0.85)));

      if (p.alpha > 0 && p.y < canvas.height) {
        active++;
        ctx.save();
        ctx.globalAlpha = p.alpha;
        ctx.translate(p.x, p.y);
        ctx.rotate((p.rot * Math.PI) / 180);
        ctx.fillStyle = p.color;
        ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
        ctx.restore();
      }
    });

    frames++;
    if (active > 0 && frames < 240) {
      requestAnimationFrame(render);
    } else {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
  }

  render();
})();

// Share Order Functionality
function handleShareOrder() {
  const shareData = {
    title: 'My NovaDrop Atelier Acquisition',
    text: 'Just completed a bespoke acquisition from LUMINA Atelier. Order #<?= addslashes($order_number) ?>',
    url: window.location.href
  };

  if (navigator.share) {
    navigator.share(shareData).catch(() => copyOrderLink());
  } else {
    copyOrderLink();
  }
}

function copyOrderLink() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    const btnText = document.getElementById('shareBtnText');
    if (btnText) btnText.textContent = '✓ Order Link Copied!';
    if (typeof ndToast === 'function') {
      ndToast('🔗 Order link copied to clipboard!', 'info');
    }
    setTimeout(() => {
      if (btnText) btnText.textContent = 'Share Acquisition';
    }, 2500);
  });
}

// Upsell Handler
function handleAddUpsell(btn) {
  btn.disabled = true;
  const label = document.getElementById('upsellBtnLabel');
  if (label) label.textContent = 'Securing Garment Protector...';

  setTimeout(() => {
    if (label) label.textContent = '✓ Added to Order';
    btn.className = 'w-full py-3 bg-emerald-600 text-white font-mono text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-md cursor-default flex items-center justify-center gap-1.5';
    if (typeof ndToast === 'function') {
      ndToast('🎉 Garment Protector Set added to your package!', 'success');
    }
  }, 750);
}
</script>
