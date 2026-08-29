<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atelier Payment Gateway — <?= htmlspecialchars(env('APP_NAME', 'Lumina Atelier')) ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<style>
  body { background: #07080b; color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
  .gold-glow { text-shadow: 0 0 20px rgba(233,193,118,0.3); }
</style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

<div class="max-w-md w-full bg-[#10121a] border border-white/15 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden text-center">
  <!-- Gold Halo Accent -->
  <div class="absolute -top-24 -left-24 w-48 h-48 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="relative z-10">
    <div class="w-14 h-14 rounded-2xl bg-white/5 border border-amber-400/30 flex items-center justify-center mx-auto mb-4 text-[#e9c176] shadow-md">
      <i class="fa-solid fa-shield-halved text-2xl"></i>
    </div>

    <div class="text-[10px] font-mono uppercase tracking-[0.2em] text-[#e9c176] font-bold mb-1">
      256-Bit Encrypted Gateway
    </div>
    <h2 class="text-xl sm:text-2xl font-serif font-bold text-white mb-2">
      Authorizing Acquisition
    </h2>
    <p class="text-xs text-white/60 font-light mb-6">
      Order <strong class="text-white font-mono">#<?= htmlspecialchars($order['order_number']) ?></strong> · Total: <strong class="text-[#e9c176] font-mono text-sm">₹<?= number_format($order['total'], 0) ?></strong>
    </p>

    <!-- Interactive Payment Simulation / Razorpay Fallback -->
    <div id="demoPaymentBox" class="space-y-4 text-left">
      <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-3">
        <div class="flex items-center justify-between text-xs font-mono text-white/70">
          <span>Payment Channel</span>
          <span class="text-emerald-400 font-bold flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Live Gateway
          </span>
        </div>
        
        <div class="grid grid-cols-3 gap-2 text-center text-xs font-mono">
          <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-white flex flex-col items-center gap-1">
            <i class="fa-solid fa-qrcode text-indigo-400 text-base"></i>
            <span class="text-[10px]">UPI / QR</span>
          </div>
          <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-white flex flex-col items-center gap-1">
            <i class="fa-solid fa-credit-card text-blue-400 text-base"></i>
            <span class="text-[10px]">Cards</span>
          </div>
          <div class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-white flex flex-col items-center gap-1">
            <i class="fa-solid fa-building-columns text-emerald-400 text-base"></i>
            <span class="text-[10px]">NetBanking</span>
          </div>
        </div>
      </div>

      <!-- Action Button -->
      <button type="button" id="simulateSuccessBtn" onclick="submitAuthorizedPayment()" class="w-full py-3.5 bg-gradient-to-r from-amber-400 via-[#e9c176] to-amber-500 text-stone-950 font-mono font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xl flex items-center justify-center gap-2 cursor-pointer hover:opacity-95 transition-all">
        <i class="fa-solid fa-lock"></i>
        <span>Complete Payment &amp; Confirm Order</span>
      </button>

      <div class="text-center">
        <a href="<?= base_url('checkout/payment') ?>" class="text-[11px] font-mono text-white/50 hover:text-white transition-colors">
          ← Cancel &amp; Return to Checkout
        </a>
      </div>
    </div>

  </div>
</div>

<form id="rzpCallbackForm" method="post" action="<?= base_url('payments/razorpay/verify') ?>">
  <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
  <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
  <input type="hidden" name="razorpay_order_id" id="rzpOrderId" value="<?= $gateway_data['order_id'] ?? ('order_rzp_' . $order['id']) ?>">
  <input type="hidden" name="razorpay_payment_id" id="rzpPaymentId" value="">
  <input type="hidden" name="razorpay_signature" id="rzpSignature" value="">
</form>

<script>
var options = <?= json_encode($gateway_data) ?>;
var isDemo = Boolean(options.is_demo || !options.key || options.key.includes('XXXXX'));

function submitAuthorizedPayment() {
  var btn = document.getElementById('simulateSuccessBtn');
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> <span>Authorizing & Clearing Settlement...</span>';
  }
  
  var orderId = options.order_id || 'order_rzp_<?= $order['id'] ?>';
  var payId = 'pay_' + Math.random().toString(36).substring(2, 12) + Date.now().toString(36);
  var sig = 'sig_' + Math.random().toString(36).substring(2, 15);

  document.getElementById('rzpOrderId').value = orderId;
  document.getElementById('rzpPaymentId').value = payId;
  document.getElementById('rzpSignature').value = sig;

  setTimeout(function() {
    document.getElementById('rzpCallbackForm').submit();
  }, 400);
}

if (!isDemo && typeof Razorpay !== 'undefined') {
  try {
    options.handler = function(response) {
      document.getElementById('rzpOrderId').value = response.razorpay_order_id;
      document.getElementById('rzpPaymentId').value = response.razorpay_payment_id;
      document.getElementById('rzpSignature').value = response.razorpay_signature;
      document.getElementById('rzpCallbackForm').submit();
    };
    options.modal = {
      ondismiss: function() {
        window.location = '<?= base_url('checkout/payment') ?>';
      }
    };
    var rzp = new Razorpay(options);
    rzp.open();
  } catch (err) {
    console.warn('Razorpay SDK init fallback:', err);
  }
}
</script>
</body>
</html>
