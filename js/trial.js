/**
 * ====================================================================
 * LUMINA ATELIER — TRIAL VERSION INTERACTIVE OS (js/trial.js)
 * "Quiet Luxury Meets Intelligent Technology"
 * ====================================================================
 */

// ── 1. GLOBAL STATE & PERSISTENCE ─────────────────────────────────
const TRIAL_STATE = {
  cart: JSON.parse(localStorage.getItem('lumina_trial_cart') || '[]'),
  wishlist: JSON.parse(localStorage.getItem('lumina_trial_wishlist') || '[]'),
  currency: localStorage.getItem('lumina_trial_currency') || 'INR',
  currencyRates: {
    'INR': { symbol: '₹', rate: 1.0, precision: 0 },
    'USD': { symbol: '$', rate: 0.012, precision: 2 },
    'EUR': { symbol: '€', rate: 0.011, precision: 2 },
    'GBP': { symbol: '£', rate: 0.0095, precision: 2 },
    'AED': { symbol: 'AED ', rate: 0.044, precision: 1 },
    'JPY': { symbol: '¥', rate: 1.85, precision: 0 }
  },
  appliedDiscount: JSON.parse(localStorage.getItem('lumina_trial_discount') || 'null'),
  currentQuickViewProduct: null,
  activeMood: 'business',
  activeStudioIndex: 0,
  vtrSilhouette: 'tailored',
  vtrSize: 'M',
  wheelSpun: false
};

// ── 2. TOAST NOTIFICATIONS ─────────────────────────────────────────
function trialToast(message, type = 'gold') {
  let container = document.getElementById('luxuryToastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'luxuryToastContainer';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'luxury-toast';
  
  let iconSvg = '<svg class="w-4 h-4 text-[#dfb76c] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
  if (type === 'error') {
    iconSvg = '<svg class="w-4 h-4 text-rose-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
  } else if (type === 'info') {
    iconSvg = '<svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
  }

  toast.innerHTML = `${iconSvg}<span class="font-medium">${message}</span>`;
  container.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-10px) scale(0.95)';
    toast.style.transition = 'all 0.3s ease';
    setTimeout(() => toast.remove(), 300);
  }, 3200);
}

// ── 3. CURRENCY FORMATTING & CONVERSION ─────────────────────────────
function formatPrice(amountInINR) {
  const num = parseFloat(amountInINR) || 0;
  const cfg = TRIAL_STATE.currencyRates[TRIAL_STATE.currency] || TRIAL_STATE.currencyRates['INR'];
  const converted = num * cfg.rate;
  
  if (cfg.precision === 0) {
    return cfg.symbol + Math.round(converted).toLocaleString();
  }
  return cfg.symbol + converted.toLocaleString(undefined, { minimumFractionDigits: cfg.precision, maximumFractionDigits: cfg.precision });
}

function updateAllPricesInDOM() {
  document.querySelectorAll('[data-price-inr]').forEach(el => {
    const raw = el.getAttribute('data-price-inr');
    if (raw !== null) {
      el.textContent = formatPrice(raw);
    }
  });
  
  // Update currency buttons / badges
  const curLabel = document.getElementById('currentCurrencyLabel');
  if (curLabel) {
    curLabel.textContent = TRIAL_STATE.currency;
  }
}

function setCurrency(curCode) {
  if (TRIAL_STATE.currencyRates[curCode]) {
    TRIAL_STATE.currency = curCode;
    localStorage.setItem('lumina_trial_currency', curCode);
    updateAllPricesInDOM();
    renderQuickBag();
    trialToast(`Currency updated to ${curCode}`, 'info');
  }
  closeCurrencyMenu();
}

function toggleCurrencyMenu() {
  const menu = document.getElementById('currencyDropdownMenu');
  if (menu) {
    menu.classList.toggle('hidden');
  }
}
function closeCurrencyMenu() {
  const menu = document.getElementById('currencyDropdownMenu');
  if (menu) menu.classList.add('hidden');
}

// ── 4. QUICK BAG (CART) MANAGEMENT ─────────────────────────────────
function addToCart(product, qty = 1, options = {}) {
  const item = {
    id: product.id,
    title: product.title,
    price: parseFloat(product.price || product.base_price || 4999),
    compare_price: parseFloat(product.compare_price || product.compare_at_price || 0),
    image: product.image || product.primary_image || 'img/cashmere_cocoon_coat.jpg',
    size: options.size || 'M',
    color: options.color || 'Noir Obsidian',
    qty: parseInt(qty) || 1
  };

  const existingIdx = TRIAL_STATE.cart.findIndex(i => i.id === item.id && i.size === item.size && i.color === item.color);
  if (existingIdx > -1) {
    TRIAL_STATE.cart[existingIdx].qty += item.qty;
  } else {
    TRIAL_STATE.cart.push(item);
  }

  saveCart();
  updateCartBadge();
  renderQuickBag();
  openQuickBagDrawer();
  trialToast(`Added "${item.title}" to Curated Bag`, 'gold');
}

function removeFromCart(index) {
  if (TRIAL_STATE.cart[index]) {
    const removed = TRIAL_STATE.cart.splice(index, 1);
    saveCart();
    updateCartBadge();
    renderQuickBag();
    trialToast(`Removed item from Bag`, 'info');
  }
}

function updateCartQty(index, delta) {
  if (TRIAL_STATE.cart[index]) {
    TRIAL_STATE.cart[index].qty += delta;
    if (TRIAL_STATE.cart[index].qty <= 0) {
      removeFromCart(index);
      return;
    }
    saveCart();
    updateCartBadge();
    renderQuickBag();
  }
}

function saveCart() {
  localStorage.setItem('lumina_trial_cart', JSON.stringify(TRIAL_STATE.cart));
}

function updateCartBadge() {
  const count = TRIAL_STATE.cart.reduce((acc, i) => acc + i.qty, 0);
  document.querySelectorAll('.cart-badge-count').forEach(el => {
    el.textContent = count;
    el.classList.toggle('hidden', count === 0);
  });
}

function renderQuickBag() {
  const container = document.getElementById('quickBagItemsList');
  if (!container) return;

  if (TRIAL_STATE.cart.length === 0) {
    container.innerHTML = `
      <div class="py-16 text-center text-stone-400 flex flex-col items-center justify-center">
        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mb-4 text-[#dfb76c]">
          <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <p class="font-serif text-lg text-stone-200 mb-1">Your Curated Bag is empty</p>
        <p class="text-xs text-stone-500 max-w-xs mb-6">Explore the Haute Couture Archives and discover bespoke garments tailored for you.</p>
        <button onclick="closeQuickBagDrawer(); scrollToSection('storefrontProductsGrid');" class="btn-luxury-primary text-xs">Explore Masterpieces</button>
      </div>
    `;
    updateQuickBagTotals(0);
    return;
  }

  let html = '';
  let subtotal = 0;

  TRIAL_STATE.cart.forEach((item, idx) => {
    const itemTotal = item.price * item.qty;
    subtotal += itemTotal;

    html += `
      <div class="flex gap-3.5 p-3.5 bg-white/5 rounded-2xl border border-white/10 relative group">
        <img src="${item.image}" alt="${item.title}" class="w-20 h-24 object-cover rounded-xl border border-white/10 bg-black flex-shrink-0">
        <div class="flex-1 flex flex-col justify-between min-w-0">
          <div>
            <div class="flex items-start justify-between gap-2">
              <h4 class="font-serif text-sm text-stone-100 font-medium leading-snug line-clamp-1">${item.title}</h4>
              <button onclick="removeFromCart(${idx})" class="text-stone-400 hover:text-rose-400 p-1 transition-colors" title="Remove item">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              </button>
            </div>
            <div class="text-[11px] text-stone-400 mt-1 font-mono flex items-center gap-2">
              <span>Size: <strong class="text-stone-200">${item.size}</strong></span>
              <span>·</span>
              <span>Color: <strong class="text-stone-200">${item.color}</strong></span>
            </div>
          </div>

          <div class="flex items-center justify-between mt-2 pt-2 border-t border-white/10">
            <div class="flex items-center gap-2 bg-black/60 border border-white/15 rounded-lg px-2 py-0.5 text-xs">
              <button onclick="updateCartQty(${idx}, -1)" class="text-stone-400 hover:text-white font-mono font-bold">-</button>
              <span class="font-mono text-stone-200 px-1.5">${item.qty}</span>
              <button onclick="updateCartQty(${idx}, 1)" class="text-stone-400 hover:text-white font-mono font-bold">+</button>
            </div>
            <span class="font-serif text-sm font-bold text-[#dfb76c]">${formatPrice(itemTotal)}</span>
          </div>
        </div>
      </div>
    `;
  });

  container.innerHTML = html;
  updateQuickBagTotals(subtotal);
}

function updateQuickBagTotals(subtotal) {
  const freeShippingThreshold = 2999;
  const meterBar = document.getElementById('quickBagShippingBar');
  const meterText = document.getElementById('quickBagShippingText');
  const subtotalEl = document.getElementById('quickBagSubtotal');
  const discountRow = document.getElementById('quickBagDiscountRow');
  const discountAmountEl = document.getElementById('quickBagDiscountAmount');
  const finalTotalEl = document.getElementById('quickBagFinalTotal');

  if (meterBar && meterText) {
    if (subtotal >= freeShippingThreshold) {
      meterBar.style.width = '100%';
      meterText.innerHTML = '<span class="text-emerald-400 font-bold">✓ Complimentary Express Delivery Unlocked</span>';
    } else {
      const pct = Math.min(100, Math.round((subtotal / freeShippingThreshold) * 100));
      const remaining = freeShippingThreshold - subtotal;
      meterBar.style.width = `${pct}%`;
      meterText.innerHTML = `Add <strong>${formatPrice(remaining)}</strong> more for Free Express Delivery`;
    }
  }

  let discountAmount = 0;
  if (TRIAL_STATE.appliedDiscount && subtotal > 0) {
    if (TRIAL_STATE.appliedDiscount.pct) {
      discountAmount = Math.round(subtotal * (TRIAL_STATE.appliedDiscount.pct / 100));
    } else if (TRIAL_STATE.appliedDiscount.flat) {
      discountAmount = Math.min(subtotal, TRIAL_STATE.appliedDiscount.flat);
    }
  }

  const finalTotal = Math.max(0, subtotal - discountAmount);

  if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);
  if (finalTotalEl) finalTotalEl.textContent = formatPrice(finalTotal);

  if (discountRow && discountAmountEl) {
    if (discountAmount > 0) {
      discountRow.classList.remove('hidden');
      discountAmountEl.textContent = `- ${formatPrice(discountAmount)}`;
      const codeSpan = document.getElementById('quickBagDiscountCode');
      if (codeSpan) codeSpan.textContent = TRIAL_STATE.appliedDiscount.code;
    } else {
      discountRow.classList.add('hidden');
    }
  }
}

function applyQuickBagCoupon() {
  const input = document.getElementById('quickBagCouponInput');
  if (!input) return;
  const code = input.value.trim().toUpperCase();
  if (!code) {
    trialToast('Please enter a privilege promo code', 'error');
    return;
  }

  if (code === 'LUMINA50') {
    TRIAL_STATE.appliedDiscount = { code: 'LUMINA50', pct: 50 };
    trialToast('50% VIP Welcome Privilege Applied! 🎉', 'gold');
  } else if (code === 'VIP25') {
    TRIAL_STATE.appliedDiscount = { code: 'VIP25', pct: 25 };
    trialToast('25% Lucky Spin Privilege Applied! 🎡', 'gold');
  } else if (code === 'FREESHIP') {
    TRIAL_STATE.appliedDiscount = { code: 'FREESHIP', free_shipping: true };
    trialToast('Complimentary Priority Air Delivery Applied!', 'gold');
  } else if (code === 'STAY500') {
    TRIAL_STATE.appliedDiscount = { code: 'STAY500', flat: 500 };
    trialToast('₹500 Instant Privilege Applied!', 'gold');
  } else {
    trialToast('Invalid or expired privilege code', 'error');
    return;
  }

  localStorage.setItem('lumina_trial_discount', JSON.stringify(TRIAL_STATE.appliedDiscount));
  input.value = '';
  renderQuickBag();
}

function toggleQuickBagDrawer() {
  const overlay = document.getElementById('quickBagOverlay');
  const panel = document.getElementById('quickBagPanel');
  if (overlay && panel) {
    const isOpen = overlay.classList.contains('active');
    if (isOpen) {
      closeQuickBagDrawer();
    } else {
      openQuickBagDrawer();
    }
  }
}
function openQuickBagDrawer() {
  const overlay = document.getElementById('quickBagOverlay');
  const panel = document.getElementById('quickBagPanel');
  if (overlay && panel) {
    renderQuickBag();
    overlay.classList.add('active');
    panel.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}
function closeQuickBagDrawer() {
  const overlay = document.getElementById('quickBagOverlay');
  const panel = document.getElementById('quickBagPanel');
  if (overlay && panel) {
    overlay.classList.remove('active');
    panel.classList.remove('active');
    document.body.style.overflow = '';
  }
}

// ── 5. WISHROBE / WISHLIST MANAGEMENT ──────────────────────────────
function toggleWishlistItem(item) {
  const existingIdx = TRIAL_STATE.wishlist.findIndex(w => w.id === item.id);
  if (existingIdx > -1) {
    TRIAL_STATE.wishlist.splice(existingIdx, 1);
    trialToast(`Removed "${item.title}" from Wardrobe`, 'info');
  } else {
    TRIAL_STATE.wishlist.push({
      id: item.id,
      title: item.title,
      price: parseFloat(item.price || 4999),
      image: item.image || 'img/cashmere_cocoon_coat.jpg'
    });
    trialToast(`Saved "${item.title}" to Wardrobe Wishlist`, 'gold');
  }

  localStorage.setItem('lumina_trial_wishlist', JSON.stringify(TRIAL_STATE.wishlist));
  updateWishlistBadges();
  renderWishlistDrawer();
}

function updateWishlistBadges() {
  const count = TRIAL_STATE.wishlist.length;
  document.querySelectorAll('.wishlist-badge-count').forEach(el => {
    el.textContent = count;
    el.classList.toggle('hidden', count === 0);
  });
}

function renderWishlistDrawer() {
  const container = document.getElementById('wishlistItemsList');
  if (!container) return;

  if (TRIAL_STATE.wishlist.length === 0) {
    container.innerHTML = `
      <div class="py-16 text-center text-stone-400 flex flex-col items-center justify-center">
        <div class="w-16 h-16 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mb-4 text-rose-400">
          <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        </div>
        <p class="font-serif text-lg text-stone-200 mb-1">Your Wardrobe Wishlist is empty</p>
        <p class="text-xs text-stone-500 max-w-xs mb-6">Heart any masterpiece to curate your private wardrobe capsule.</p>
        <button onclick="closeWishlistDrawer(); scrollToSection('storefrontProductsGrid');" class="btn-luxury-primary text-xs">Browse Collections</button>
      </div>
    `;
    return;
  }

  let html = '';
  TRIAL_STATE.wishlist.forEach((item, idx) => {
    html += `
      <div class="flex gap-3.5 p-3.5 bg-white/5 rounded-2xl border border-white/10 relative group">
        <img src="${item.image}" alt="${item.title}" class="w-20 h-24 object-cover rounded-xl border border-white/10 bg-black flex-shrink-0">
        <div class="flex-1 flex flex-col justify-between min-w-0">
          <div>
            <div class="flex items-start justify-between gap-2">
              <h4 class="font-serif text-sm text-stone-100 font-medium leading-snug line-clamp-1">${item.title}</h4>
              <button onclick="toggleWishlistItem({id:${item.id}, title:'${escapeQuotes(item.title)}'})" class="text-rose-400 p-1" title="Remove from wishlist">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
              </button>
            </div>
            <span class="font-serif text-sm font-bold text-[#dfb76c] mt-1 block">${formatPrice(item.price)}</span>
          </div>

          <div class="pt-2 border-t border-white/10 flex gap-2">
            <button onclick="addToCart({id:${item.id}, title:'${escapeQuotes(item.title)}', price:${item.price}, image:'${item.image}'}, 1); toggleWishlistItem({id:${item.id}, title:'${escapeQuotes(item.title)}'});" class="btn-luxury-primary text-[10px] py-1.5 px-3 flex-1">
              Move to Bag
            </button>
          </div>
        </div>
      </div>
    `;
  });

  container.innerHTML = html;
}

function toggleWishlistDrawer() {
  const overlay = document.getElementById('wishlistOverlay');
  const panel = document.getElementById('wishlistPanel');
  if (overlay && panel) {
    const isOpen = overlay.classList.contains('active');
    if (isOpen) {
      closeWishlistDrawer();
    } else {
      openWishlistDrawer();
    }
  }
}
function openWishlistDrawer() {
  const overlay = document.getElementById('wishlistOverlay');
  const panel = document.getElementById('wishlistPanel');
  if (overlay && panel) {
    renderWishlistDrawer();
    overlay.classList.add('active');
    panel.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}
function closeWishlistDrawer() {
  const overlay = document.getElementById('wishlistOverlay');
  const panel = document.getElementById('wishlistPanel');
  if (overlay && panel) {
    overlay.classList.remove('active');
    panel.classList.remove('active');
    document.body.style.overflow = '';
  }
}

// ── 6. NEURAL AI STYLIST ENGINE ────────────────────────────────────
const STYLIST_COMBOS = {
  business: {
    title: 'The Milan Executive',
    desc: 'Structured architectural cashmere paired with crisp virgin wool suiting. Exudes gravitas, timeless taste, and effortless poise.',
    scores: { formality: 94, versatility: 78, trend: 86, luxury: 98 },
    bestFor: ['Boardrooms', 'Private Capital Dinners', 'Keynote Summits'],
    advice: [
      'Layer the 700 GSM Cocoon Coat over tailored trousers for a streamlined silhouette.',
      'Fasten only the center horn button to maintain an architectural drape while walking.',
      'Complement with matte calfskin loafers and an unlined silk pocket square.'
    ],
    items: [
      { id: 1, title: 'The Atelier Cashmere Cocoon Coat', price: 6999, image: 'img/cashmere_cocoon_coat.jpg', tag: 'OUTERWEAR' },
      { id: 4, title: 'Italian Pleated Virgin Wool Trousers', price: 4499, image: 'img/italian_pleated_trousers.jpg', tag: 'BOTTOM' },
      { id: 9, title: '22-Momme Sandwashed Silk Blouse', price: 3499, image: 'img/silk_charmeuse_blouse.jpg', tag: 'SHIRT' }
    ]
  },
  street: {
    title: 'Ginza Street Couture',
    desc: '14.5oz shuttle-loomed okayama selvedge denim layered over 500 GSM loopback French terry.',
    scores: { formality: 42, versatility: 95, trend: 96, luxury: 92 },
    bestFor: ['Gallery Openings', 'High-Fashion Events', 'Urban Leisure'],
    advice: [
      'Single-cuff the selvedge denim to highlight the pink shuttle-loom ticker line.',
      'Layer the heavyweight terry hoodie beneath the Type II denim jacket with hood resting back.',
      'Pair with minimalist suede derby shoes or low-profile leather sneakers.'
    ],
    items: [
      { id: 3, title: 'Type II Okayama Selvedge Denim Jacket', price: 5499, image: 'img/denim_jacket_type2.jpg', tag: 'JACKET' },
      { id: 5, title: '500 GSM Heavyweight Loopback Hoodie', price: 3999, image: 'img/terry_hoodie_luxury.jpg', tag: 'HOODIE' },
      { id: 6, title: '14.5oz Okayama Raw Selvedge Denim', price: 4799, image: 'img/okayama_selvedge_denim.jpg', tag: 'DENIM' }
    ]
  },
  evening: {
    title: 'Midnight Parisian Gala',
    desc: 'Fluid pure mulberry silk eveningwear matched with Super 150s virgin wool bespoke tailoring.',
    scores: { formality: 98, versatility: 65, trend: 92, luxury: 99 },
    bestFor: ['Opera Premieres', 'Black-Tie Galas', 'Private Soirées'],
    advice: [
      'Drape the double-breasted virgin wool blazer unbuttoned over the silk dress.',
      'Allow the fluid 22-momme silk to cascade naturally with movement.',
      'Complete the ensemble with handcrafted black calfskin loafers or minimal heels.'
    ],
    items: [
      { id: 8, title: 'Super 150s Virgin Wool Bespoke Blazer', price: 7999, image: 'img/wool_blazer_luxury.jpg', tag: 'BLAZER' },
      { id: 7, title: '22-Momme Sandwashed Silk Evening Dress', price: 5999, image: 'img/mulberry_silk_dress.jpg', tag: 'DRESS' },
      { id: 10, title: 'Hand-Welted Calfskin Penny Loafers', price: 4999, image: 'img/calfskin_penny_loafers.jpg', tag: 'FOOTWEAR' }
    ]
  },
  weekend: {
    title: 'The St. Moritz Edit',
    desc: 'Pure Mongolian ribbed turtleneck knitwear paired with relaxed Italian pleated trousers.',
    scores: { formality: 68, versatility: 92, trend: 88, luxury: 96 },
    bestFor: ['Alpine Getaways', 'Brunch at the Member Club', 'Weekend Travel'],
    advice: [
      'Fold the rib-knit turtleneck once for a clean, architectural neckline.',
      'Tuck lightly at the front into pleated trousers for casual elegance.',
      'Pair with handcrafted Chelsea leather boots in espresso noir.'
    ],
    items: [
      { id: 2, title: 'Mongolian Virgin Cashmere Ribbed Turtleneck', price: 4999, image: 'img/cashmere_turtleneck_knit.jpg', tag: 'KNITWEAR' },
      { id: 4, title: 'Italian Pleated Virgin Wool Trousers', price: 4499, image: 'img/italian_pleated_trousers.jpg', tag: 'TROUSERS' },
      { id: 11, title: 'Italian Full-Grain Chelsea Leather Boots', price: 5499, image: 'img/chelsea_leather_boots.jpg', tag: 'FOOTWEAR' }
    ]
  },
  athleisure: {
    title: 'Aero-Performance Minimalist',
    desc: 'Heavyweight organic loopback fleece combined with relaxed-tapered architectural pants.',
    scores: { formality: 35, versatility: 98, trend: 94, luxury: 90 },
    bestFor: ['Long-Haul First Class Flight', 'Studio Design Sessions', 'Effortless Lounging'],
    advice: [
      'Layer a clean pima cotton tee beneath the heavyweight hoodie for crisp collar contrast.',
      'Pair with minimal leather low-tops and a structured travel tote.',
      'Adjust waistband drawstrings for a relaxed mid-rise drape.'
    ],
    items: [
      { id: 5, title: '500 GSM Heavyweight Loopback Hoodie', price: 3999, image: 'img/terry_hoodie_luxury.jpg', tag: 'HOODIE' },
      { id: 4, title: 'Italian Pleated Virgin Wool Trousers', price: 4499, image: 'img/italian_pleated_trousers.jpg', tag: 'BOTTOM' },
      { id: 12, title: 'Minimalist Handcrafted Suede Derby Shoes', price: 4799, image: 'img/minimalist_suede_derby.jpg', tag: 'SHOES' }
    ]
  }
};

function selectStylistMood(moodKey) {
  TRIAL_STATE.activeMood = moodKey;
  
  // Update mood buttons
  document.querySelectorAll('.stylist-mood-pill').forEach(btn => {
    if (btn.getAttribute('data-mood') === moodKey) {
      btn.className = 'stylist-mood-pill px-4 py-2 rounded-full border border-[#dfb76c] bg-[#dfb76c] text-stone-950 text-xs font-mono font-bold uppercase tracking-wider transition-all shadow-md';
    } else {
      btn.className = 'stylist-mood-pill px-4 py-2 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 text-stone-300 text-xs font-mono uppercase tracking-wider transition-all';
    }
  });

  // Show thinking state
  const thinkingOverlay = document.getElementById('aiThinkingOverlay');
  if (thinkingOverlay) {
    thinkingOverlay.classList.remove('hidden');
    setTimeout(() => {
      thinkingOverlay.classList.add('hidden');
      renderStylistCombo(moodKey);
    }, 450);
  } else {
    renderStylistCombo(moodKey);
  }
}

function renderStylistCombo(moodKey) {
  const combo = STYLIST_COMBOS[moodKey] || STYLIST_COMBOS.business;
  
  // Identity Card
  const titleEl = document.getElementById('stylistStyleTitle');
  const descEl = document.getElementById('stylistStyleDesc');
  if (titleEl) titleEl.textContent = combo.title;
  if (descEl) descEl.textContent = combo.desc;

  // Radar Scores
  const sForm = document.getElementById('score_formality');
  const bForm = document.getElementById('bar_formality');
  if (sForm && bForm) {
    sForm.textContent = combo.scores.formality + '%';
    bForm.style.width = combo.scores.formality + '%';
  }
  const sVers = document.getElementById('score_versatility');
  const bVers = document.getElementById('bar_versatility');
  if (sVers && bVers) {
    sVers.textContent = combo.scores.versatility + '%';
    bVers.style.width = combo.scores.versatility + '%';
  }
  const sTrend = document.getElementById('score_trend');
  const bTrend = document.getElementById('bar_trend');
  if (sTrend && bTrend) {
    sTrend.textContent = combo.scores.trend + '%';
    bTrend.style.width = combo.scores.trend + '%';
  }
  const sLux = document.getElementById('score_luxury');
  const bLux = document.getElementById('bar_luxury');
  if (sLux && bLux) {
    sLux.textContent = combo.scores.luxury + '%';
    bLux.style.width = combo.scores.luxury + '%';
  }

  // Best For Tags
  const tagsContainer = document.getElementById('stylistBestForTags');
  if (tagsContainer) {
    tagsContainer.innerHTML = combo.bestFor.map(t => `<span class="px-2.5 py-1 bg-white/10 text-stone-200 text-[10px] rounded-full font-mono">${t}</span>`).join('');
  }

  // Outfit Items Grid
  const itemsContainer = document.getElementById('stylistOutfitItemsGrid');
  if (itemsContainer) {
    let itemsHtml = '';
    let comboTotal = 0;

    combo.items.forEach(item => {
      comboTotal += item.price;
      itemsHtml += `
        <div class="luxury-card p-3 flex flex-col justify-between group cursor-pointer" onclick="openQuickViewModalById(${item.id})">
          <div class="relative aspect-[3/4] rounded-xl overflow-hidden bg-black mb-2.5">
            <img src="${item.image}" alt="${item.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <span class="absolute top-2 left-2 bg-black/80 backdrop-blur-md text-[#dfb76c] text-[8px] font-mono font-bold px-2 py-0.5 rounded uppercase border border-white/10">${item.tag}</span>
          </div>
          <div>
            <h4 class="font-serif text-xs text-stone-200 font-medium line-clamp-1 group-hover:text-[#dfb76c] transition-colors">${item.title}</h4>
            <span class="font-serif text-xs font-bold text-[#dfb76c] mt-1 block">${formatPrice(item.price)}</span>
          </div>
        </div>
      `;
    });

    itemsContainer.innerHTML = itemsHtml;

    // Pricing
    const regularTotal = Math.round(comboTotal * 1.35);
    const saveAmt = regularTotal - comboTotal;
    const totalEl = document.getElementById('stylistComboTotalPrice');
    const saveEl = document.getElementById('stylistComboTotalSave');
    if (totalEl) totalEl.textContent = formatPrice(comboTotal);
    if (saveEl) saveEl.textContent = formatPrice(saveAmt);
  }

  // Advice
  const adviceList = document.getElementById('stylistHowToWear');
  if (adviceList) {
    adviceList.innerHTML = combo.advice.map(a => `<li class="flex gap-2 text-xs text-stone-300 leading-relaxed"><span class="text-[#dfb76c] font-bold">✦</span><span>${a}</span></li>`).join('');
  }
}

function shuffleStylistOutfit() {
  const moods = Object.keys(STYLIST_COMBOS);
  const currentIdx = moods.indexOf(TRIAL_STATE.activeMood);
  const nextMood = moods[(currentIdx + 1) % moods.length];
  selectStylistMood(nextMood);
  trialToast(`Shuffled to ${STYLIST_COMBOS[nextMood].title}`, 'gold');
}

function acquireFullStylistOutfit() {
  const combo = STYLIST_COMBOS[TRIAL_STATE.activeMood] || STYLIST_COMBOS.business;
  combo.items.forEach(item => {
    addToCart(item, 1, { size: 'M', color: 'Atelier Edition' });
  });
  trialToast(`Added full 3-piece "${combo.title}" ensemble to Bag!`, 'gold');
}

// ── 7. VIRTUAL FITTING ROOM & MIRROR SIMULATOR ──────────────────────
function setVtrSilhouette(silName) {
  TRIAL_STATE.vtrSilhouette = silName;
  document.querySelectorAll('.vtr-silhouette-btn').forEach(b => {
    if (b.getAttribute('data-silhouette') === silName) {
      b.classList.add('border-[#dfb76c]', 'bg-white/10', 'text-[#dfb76c]');
      b.classList.remove('border-white/15', 'text-stone-300');
    } else {
      b.classList.remove('border-[#dfb76c]', 'bg-white/10', 'text-[#dfb76c]');
      b.classList.add('border-white/15', 'text-stone-300');
    }
  });
  updateVtrCalculations();
}

function setVtrSize(sizeLabel) {
  TRIAL_STATE.vtrSize = sizeLabel;
  document.querySelectorAll('.vtr-size-btn').forEach(b => {
    if (b.getAttribute('data-size') === sizeLabel) {
      b.classList.add('bg-[#dfb76c]', 'text-stone-950', 'font-bold', 'border-[#dfb76c]');
      b.classList.remove('bg-white/5', 'text-stone-200');
    } else {
      b.classList.remove('bg-[#dfb76c]', 'text-stone-950', 'font-bold', 'border-[#dfb76c]');
      b.classList.add('bg-white/5', 'text-stone-200');
    }
  });
  updateVtrCalculations();
}

function updateVtrCalculations() {
  const fitScoreEl = document.getElementById('vtrFitScore');
  const fitDrapeEl = document.getElementById('vtrFitDrapeStatus');
  const fitBarEl = document.getElementById('vtrFitProgressBar');

  let baseScore = 96;
  if (TRIAL_STATE.vtrSize === 'L' || TRIAL_STATE.vtrSize === 'S') baseScore = 94;
  if (TRIAL_STATE.vtrSize === 'XS' || TRIAL_STATE.vtrSize === 'XXL') baseScore = 91;

  if (fitScoreEl) fitScoreEl.textContent = `SIZE ${TRIAL_STATE.vtrSize} · ${baseScore}% FIT`;
  if (fitBarEl) fitBarEl.style.width = `${baseScore}%`;
  if (fitDrapeEl) fitDrapeEl.textContent = `Optimal silhouette alignment for ${TRIAL_STATE.vtrSilhouette} body structure.`;
}

function openVirtualTryOnModal() {
  const modal = document.getElementById('vtrModal');
  if (modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    updateVtrCalculations();
  }
}
function closeVirtualTryOnModal() {
  const modal = document.getElementById('vtrModal');
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

function simulateVtrCamera() {
  trialToast('Simulating high-precision camera capture…', 'info');
  const preview = document.getElementById('vtrCameraPreviewBox');
  if (preview) {
    preview.innerHTML = `
      <div class="relative w-full h-full flex flex-col items-center justify-center bg-black/90 p-4 animate-in fade-in duration-300">
        <div class="w-12 h-12 rounded-full border-2 border-[#dfb76c] border-t-transparent animate-spin mb-3"></div>
        <p class="text-xs font-mono text-[#dfb76c] uppercase tracking-wider">Analyzing 3D Body Mesh…</p>
      </div>
    `;
    setTimeout(() => {
      preview.innerHTML = `
        <div class="relative w-full h-full">
          <img src="img/model_look_executive.jpg" alt="Model Simulation" class="w-full h-full object-cover rounded-2xl">
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/30 pointer-events-none"></div>
          <div class="absolute top-3 left-3 bg-black/80 border border-[#dfb76c] px-3 py-1 rounded-full text-[10px] font-mono text-[#dfb76c] font-bold">
            ✓ 3D Silhouette Synchronized
          </div>
        </div>
      `;
      trialToast('Live drape calibration complete! 97% Match', 'gold');
    }, 1200);
  }
}

// ── 8. INTERACTIVE MODEL FITTING STUDIO (3 LOOKS) ───────────────────
const STUDIO_LOOKS = [
  {
    title: 'The Milan Executive · Complete 3-Piece Ensemble',
    counter: '01 / 03',
    modelImage: 'img/model_look_executive.jpg',
    coat: { title: 'The Atelier Cashmere Cocoon Coat', price: 6999, img: 'img/cashmere_cocoon_coat.jpg', tag: 'Outerwear' },
    shirt: { title: '22-Momme Sandwashed Silk Blouse', price: 3499, img: 'img/silk_charmeuse_blouse.jpg', tag: 'Inner Layer' },
    bottom: { title: 'Italian Pleated Virgin Wool Trousers', price: 4499, img: 'img/italian_pleated_trousers.jpg', tag: 'Bottoms' }
  },
  {
    title: 'The Ginza Street · 14.5oz Raw Selvedge Edition',
    counter: '02 / 03',
    modelImage: 'img/model_look_street.jpg',
    coat: { title: 'Type II Okayama Selvedge Denim Jacket', price: 5499, img: 'img/denim_jacket_type2.jpg', tag: 'Jacket' },
    shirt: { title: '500 GSM Loopback Heavyweight Hoodie', price: 3999, img: 'img/terry_hoodie_luxury.jpg', tag: 'Mid Layer' },
    bottom: { title: '14.5oz Okayama Raw Selvedge Denim', price: 4799, img: 'img/okayama_selvedge_denim.jpg', tag: 'Denim' }
  },
  {
    title: 'The Parisian Evening · Super 150s Virgin Wool Bespoke',
    counter: '03 / 03',
    modelImage: 'img/model_look_classic.jpg',
    coat: { title: 'Super 150s Virgin Wool Tailored Peacoat', price: 7499, img: 'img/melton_wool_peacoat.jpg', tag: 'Tailoring' },
    shirt: { title: 'Mongolian Virgin Cashmere Turtleneck', price: 4999, img: 'img/cashmere_turtleneck_knit.jpg', tag: 'Knit' },
    bottom: { title: 'Italian Pleated Virgin Wool Trousers', price: 4499, img: 'img/italian_pleated_trousers.jpg', tag: 'Trousers' }
  }
];

function navigateStudioLook(delta) {
  const len = STUDIO_LOOKS.length;
  TRIAL_STATE.activeStudioIndex = (TRIAL_STATE.activeStudioIndex + delta + len) % len;
  renderStudioModal();
}

function renderStudioModal() {
  const look = STUDIO_LOOKS[TRIAL_STATE.activeStudioIndex];
  
  const heading = document.getElementById('amfsHeading');
  const counter = document.getElementById('amfsLookCounter');
  const modelImg = document.getElementById('amfsModelImage');
  const coatTitle = document.getElementById('amfsCoatTitle');
  const coatPrice = document.getElementById('amfsCoatPrice');
  const coatImg = document.getElementById('amfsCoatImg');
  const shirtTitle = document.getElementById('amfsShirtTitle');
  const shirtPrice = document.getElementById('amfsShirtPrice');
  const shirtImg = document.getElementById('amfsShirtImg');
  const bottomTitle = document.getElementById('amfsBottomTitle');
  const bottomPrice = document.getElementById('amfsBottomPrice');
  const bottomImg = document.getElementById('amfsBottomImg');
  const totalEl = document.getElementById('amfsTotalEnsemblePrice');

  if (heading) heading.textContent = look.title;
  if (counter) counter.textContent = look.counter;
  if (modelImg) modelImg.src = look.modelImage;
  
  if (coatTitle) coatTitle.textContent = look.coat.title;
  if (coatPrice) coatPrice.textContent = formatPrice(look.coat.price);
  if (coatImg) coatImg.src = look.coat.img;

  if (shirtTitle) shirtTitle.textContent = look.shirt.title;
  if (shirtPrice) shirtPrice.textContent = formatPrice(look.shirt.price);
  if (shirtImg) shirtImg.src = look.shirt.img;

  if (bottomTitle) bottomTitle.textContent = look.bottom.title;
  if (bottomPrice) bottomPrice.textContent = formatPrice(look.bottom.price);
  if (bottomImg) bottomImg.src = look.bottom.img;

  const sum = look.coat.price + look.shirt.price + look.bottom.price;
  if (totalEl) totalEl.textContent = formatPrice(sum);
}

function openModelFittingStudioModal() {
  const modal = document.getElementById('atelierModelFittingStudioModal');
  if (modal) {
    renderStudioModal();
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}
function closeModelFittingStudioModal() {
  const modal = document.getElementById('atelierModelFittingStudioModal');
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

function acquireStudioFullLook() {
  const look = STUDIO_LOOKS[TRIAL_STATE.activeStudioIndex];
  addToCart(look.coat, 1, { size: 'M', color: 'Look Edition' });
  addToCart(look.shirt, 1, { size: 'M', color: 'Look Edition' });
  addToCart(look.bottom, 1, { size: '32', color: 'Look Edition' });
  closeModelFittingStudioModal();
  trialToast(`Added "${look.title}" full ensemble to Bag!`, 'gold');
}

// ── 9. LUCKY SPIN WHEEL MODAL ───────────────────────────────────────
const WHEEL_PRIZES = [
  { label: '25% VIP OFF', code: 'VIP25', pct: 25, color: '#dfb76c' },
  { label: 'FREE AIR SHIP', code: 'FREESHIP', free_shipping: true, color: '#161820' },
  { label: '₹500 GIFT', code: 'STAY500', flat: 500, color: '#2a2214' },
  { label: '15% DROP OFF', code: 'DROP15', pct: 15, color: '#161820' },
  { label: '50% MASTERPIECE', code: 'LUMINA50', pct: 50, color: '#dfb76c' },
  { label: 'ATELIER SOCKS', code: 'FREESOCKS', gift: true, color: '#161820' }
];

let wheelAngle = 0;

function drawWheelCanvas() {
  const canvas = document.getElementById('sfWheelCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  const numSlices = WHEEL_PRIZES.length;
  const sliceAngle = (2 * Math.PI) / numSlices;
  const radius = canvas.width / 2;

  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.save();
  ctx.translate(radius, radius);
  ctx.rotate(wheelAngle);

  for (let i = 0; i < numSlices; i++) {
    const startAngle = i * sliceAngle;
    const endAngle = startAngle + sliceAngle;
    
    ctx.beginPath();
    ctx.moveTo(0, 0);
    ctx.arc(0, 0, radius - 4, startAngle, endAngle);
    ctx.fillStyle = WHEEL_PRIZES[i].color;
    ctx.fill();
    ctx.strokeStyle = '#dfb76c';
    ctx.lineWidth = 2;
    ctx.stroke();

    // Text
    ctx.save();
    ctx.rotate(startAngle + sliceAngle / 2);
    ctx.textAlign = 'right';
    ctx.fillStyle = WHEEL_PRIZES[i].color === '#dfb76c' ? '#090a0d' : '#fbf9f5';
    ctx.font = 'bold 10px JetBrains Mono, monospace';
    ctx.fillText(WHEEL_PRIZES[i].label, radius - 20, 4);
    ctx.restore();
  }

  ctx.restore();
}

function spinStorefrontWheel() {
  if (TRIAL_STATE.wheelSpun) {
    trialToast('You have already claimed your lucky spin!', 'info');
    return;
  }

  TRIAL_STATE.wheelSpun = true;
  const targetPrizeIdx = 0; // Lands on 25% VIP OFF
  const totalRots = 5;
  const numSlices = WHEEL_PRIZES.length;
  const sliceAngle = (2 * Math.PI) / numSlices;
  // Indicator is at top (3*PI/2)
  const targetAngle = (totalRots * 2 * Math.PI) + (3 * Math.PI / 2) - (targetPrizeIdx * sliceAngle + sliceAngle / 2);

  const startAngle = wheelAngle;
  const duration = 4000;
  const startTime = performance.now();

  function animateWheel(now) {
    const elapsed = now - startTime;
    const progress = Math.min(1, elapsed / duration);
    // Ease out cubic
    const easeOut = 1 - Math.pow(1 - progress, 3);
    wheelAngle = startAngle + (targetAngle - startAngle) * easeOut;
    drawWheelCanvas();

    if (progress < 1) {
      requestAnimationFrame(animateWheel);
    } else {
      wheelAngle = targetAngle % (2 * Math.PI);
      drawWheelCanvas();
      showWheelWin(WHEEL_PRIZES[targetPrizeIdx]);
    }
  }

  requestAnimationFrame(animateWheel);
}

function showWheelWin(prize) {
  const stage = document.getElementById('sfWheelStage');
  const winBox = document.getElementById('sfWinBox');
  const winCode = document.getElementById('sfWinPromoCode');
  const winLabel = document.getElementById('sfWinPrizeLabel');

  if (stage) stage.classList.add('hidden');
  if (winBox) winBox.classList.remove('hidden');
  if (winCode) winCode.textContent = prize.code;
  if (winLabel) winLabel.textContent = `You unlocked ${prize.label}!`;

  TRIAL_STATE.appliedDiscount = prize;
  localStorage.setItem('lumina_trial_discount', JSON.stringify(prize));
  renderQuickBag();
  trialToast(`🎉 Privilege code ${prize.code} unlocked and applied!`, 'gold');
}

function openStorefrontWheelModal() {
  const modal = document.getElementById('storefrontWheelModal');
  if (modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    setTimeout(drawWheelCanvas, 50);
  }
}
function closeStorefrontWheelModal() {
  const modal = document.getElementById('storefrontWheelModal');
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

// ── 10. EXIT INTENT & VIP WELCOME POPUP ─────────────────────────────
let exitIntentFired = false;
function initExitIntent() {
  document.addEventListener('mouseleave', (e) => {
    if (e.clientY <= 0 && !exitIntentFired && !sessionStorage.getItem('lumina_trial_exit_seen')) {
      exitIntentFired = true;
      sessionStorage.setItem('lumina_trial_exit_seen', '1');
      openExitPopup();
    }
  });

  // Auto trigger for demo after 35s
  setTimeout(() => {
    if (!exitIntentFired && !sessionStorage.getItem('lumina_trial_exit_seen')) {
      exitIntentFired = true;
      openExitPopup();
    }
  }, 35000);
}

function openExitPopup() {
  const overlay = document.getElementById('exitIntentOverlay');
  if (overlay) {
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    startExitCountdown();
  }
}
function closeExitPopup() {
  const overlay = document.getElementById('exitIntentOverlay');
  if (overlay) {
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }
}

let countdownInterval;
function startExitCountdown() {
  let timeLeft = 599; // 09:59
  const timerEl = document.getElementById('exitCountdown');
  if (!timerEl || countdownInterval) return;

  countdownInterval = setInterval(() => {
    timeLeft--;
    if (timeLeft <= 0) {
      clearInterval(countdownInterval);
      return;
    }
    const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
    const s = String(timeLeft % 60).padStart(2, '0');
    timerEl.textContent = `${m}:${s}`;
  }, 1000);
}

function claimOfferCoupon(code, value, type) {
  if (type === 'percent') {
    TRIAL_STATE.appliedDiscount = { code: code, pct: value };
  } else if (type === 'flat') {
    TRIAL_STATE.appliedDiscount = { code: code, flat: value };
  } else if (type === 'shipping') {
    TRIAL_STATE.appliedDiscount = { code: code, free_shipping: true };
  }
  localStorage.setItem('lumina_trial_discount', JSON.stringify(TRIAL_STATE.appliedDiscount));
  renderQuickBag();
  closeExitPopup();
  trialToast(`Privilege Code "${code}" claimed & applied! 🎉`, 'gold');
  openQuickBagDrawer();
}

// ── 11. 1-CLICK EXPRESS CHECKOUT MODAL ─────────────────────────────
let checkoutProductItem = null;

function openExpressCheckout(pid, title, price, image, variantId = 1) {
  checkoutProductItem = {
    id: pid,
    title: title,
    price: parseFloat(price),
    image: image,
    variantId: variantId
  };

  const modal = document.getElementById('expressCheckoutModal');
  const imgEl = document.getElementById('ecProductImg');
  const titleEl = document.getElementById('ecProductTitle');
  const priceEl = document.getElementById('ecProductPrice');
  const totalEl = document.getElementById('ecFinalTotal');

  if (imgEl) imgEl.src = image;
  if (titleEl) titleEl.textContent = title;
  if (priceEl) priceEl.textContent = formatPrice(price);
  if (totalEl) totalEl.textContent = formatPrice(price);

  if (modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}

function closeExpressCheckout() {
  const modal = document.getElementById('expressCheckoutModal');
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

function processExpressCheckout(event) {
  event.preventDefault();
  const form = document.getElementById('expressCheckoutForm');
  const name = form.querySelector('[name="customer_name"]').value.trim();
  const phone = form.querySelector('[name="customer_phone"]').value.trim();
  const address = form.querySelector('[name="customer_address"]').value.trim();

  if (!name || !phone || !address) {
    trialToast('Please fill in your delivery name, phone, and address', 'error');
    return;
  }

  const submitBtn = document.getElementById('ecSubmitBtn');
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-stone-950 border-t-transparent rounded-full mr-2"></span> Transmitting to Atelier…';
  }

  setTimeout(() => {
    closeExpressCheckout();
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = 'Complete Order';
    }
    form.reset();
    trialToast(`🎉 Order Placed Successfully! Ref: #LUM-${Math.floor(100000 + Math.random() * 900000)}`, 'gold');
  }, 1400);
}

// ── 12. QUICK VIEW & SIZE/STYLE CONCIERGE ──────────────────────────
function openQuickView(jsonStr) {
  try {
    const data = typeof jsonStr === 'string' ? JSON.parse(jsonStr) : jsonStr;
    TRIAL_STATE.currentQuickViewProduct = data;

    const modal = document.getElementById('atelierProductQuickViewModal');
    const imgEl = document.getElementById('apqvImage');
    const titleEl = document.getElementById('apqvTitle');
    const priceEl = document.getElementById('apqvPrice');
    const descEl = document.getElementById('apqvDesc');

    if (imgEl) imgEl.src = data.image || 'img/cashmere_cocoon_coat.jpg';
    if (titleEl) titleEl.textContent = data.title;
    if (priceEl) priceEl.textContent = formatPrice(data.price);
    if (descEl) descEl.textContent = data.description || 'Crafted with sartorial precision using natural double-faced organic fibers.';

    if (modal) {
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  } catch (e) {
    console.error('Quick view error', e);
  }
}
function openQuickViewModalById(id) {
  const card = document.querySelector(`.store-product-card[data-product-id="${id}"]`);
  if (card) {
    const btn = card.querySelector('[data-quickview]');
    if (btn) {
      openQuickView(btn.getAttribute('data-quickview'));
      return;
    }
  }
  // Fallback
  openQuickView({
    id: id,
    title: 'Haute Couture Archive Piece',
    price: 4999,
    image: 'img/cashmere_cocoon_coat.jpg',
    description: 'Generational craftsmanship with certified pure natural textiles.'
  });
}
function closeProductQuickViewModal() {
  const modal = document.getElementById('atelierProductQuickViewModal');
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

function openAtelierFitModal(product) {
  TRIAL_STATE.currentAfmProduct = product;
  const modal = document.getElementById('atelierFitModal');
  const imgEl = document.getElementById('afmProductImg');
  const titleEl = document.getElementById('afmProductTitle');
  const priceEl = document.getElementById('afmProductPrice');

  if (imgEl) imgEl.src = product.image;
  if (titleEl) titleEl.textContent = product.title;
  if (priceEl) priceEl.textContent = formatPrice(product.price);

  if (modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}
function closeAtelierFitModal() {
  const modal = document.getElementById('atelierFitModal');
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

// ── 13. LIVE SEARCH MODAL ──────────────────────────────────────────
function toggleSearchModal() {
  const modal = document.getElementById('searchModal');
  if (modal) {
    const isOpen = modal.classList.contains('active');
    if (isOpen) {
      closeSearchModal();
    } else {
      openSearchModal();
    }
  }
}
function openSearchModal() {
  const modal = document.getElementById('searchModal');
  const input = document.getElementById('searchModalInput');
  if (modal) {
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    if (input) {
      setTimeout(() => input.focus(), 100);
    }
  }
}
function closeSearchModal() {
  const modal = document.getElementById('searchModal');
  if (modal) {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  }
}

function handleSearchInput(query) {
  const q = query.trim().toLowerCase();
  const resultsContainer = document.getElementById('searchResultsContainer');
  if (!resultsContainer) return;

  if (!q) {
    resultsContainer.innerHTML = `
      <div class="p-6 text-center text-stone-500 text-xs font-mono">
        Type to search across Cashmere Coats, Okayama Denim, Silk, and Suiting…
      </div>
    `;
    return;
  }

  const allCards = document.querySelectorAll('.store-product-card');
  const matches = [];

  allCards.forEach(card => {
    const title = (card.querySelector('h3') ? card.querySelector('h3').textContent : '').toLowerCase();
    const img = card.querySelector('img') ? card.querySelector('img').src : '';
    const priceStr = card.querySelector('[data-price-inr]') ? card.querySelector('[data-price-inr]').getAttribute('data-price-inr') : '4999';
    const id = card.getAttribute('data-product-id') || '1';

    if (title.includes(q)) {
      matches.push({ id, title: card.querySelector('h3').textContent, img, price: priceStr });
    }
  });

  if (matches.length === 0) {
    resultsContainer.innerHTML = `
      <div class="p-6 text-center text-stone-400 text-xs">
        No atelier pieces found matching "<span class="text-[#dfb76c]">${escapeQuotes(query)}</span>".
      </div>
    `;
    return;
  }

  resultsContainer.innerHTML = matches.map(m => `
    <div class="flex items-center justify-between p-3 bg-white/5 hover:bg-white/10 rounded-xl border border-white/10 cursor-pointer transition-all mb-2" onclick="closeSearchModal(); openQuickViewModalById(${m.id});">
      <div class="flex items-center gap-3">
        <img src="${m.img}" alt="${m.title}" class="w-12 h-14 object-cover rounded-lg border border-white/10">
        <div>
          <h4 class="font-serif text-xs text-stone-200 font-medium">${m.title}</h4>
          <span class="font-serif text-xs font-bold text-[#dfb76c]">${formatPrice(m.price)}</span>
        </div>
      </div>
      <span class="text-[10px] font-mono text-stone-400">Inspect →</span>
    </div>
  `).join('');
}

// ── 14. MOBILE NAVIGATION DRAWER ───────────────────────────────────
function toggleMobileNav() {
  const overlay = document.getElementById('mobileNavOverlay');
  const panel = document.getElementById('mobileNavPanel');
  if (overlay && panel) {
    const isOpen = overlay.classList.contains('active');
    if (isOpen) {
      closeMobileNav();
    } else {
      openMobileNav();
    }
  }
}
function openMobileNav() {
  const overlay = document.getElementById('mobileNavOverlay');
  const panel = document.getElementById('mobileNavPanel');
  if (overlay && panel) {
    overlay.classList.add('active');
    panel.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}
function closeMobileNav() {
  const overlay = document.getElementById('mobileNavOverlay');
  const panel = document.getElementById('mobileNavPanel');
  if (overlay && panel) {
    overlay.classList.remove('active');
    panel.classList.remove('active');
    document.body.style.overflow = '';
  }
}

// ── 15. TEXTILE HERO SWATCHES & ANIMATIONS ─────────────────────────
const HERO_TEXTILES = {
  cashmere: {
    label: '700 GSM Mongolian Cashmere',
    titleMain: 'Form Without',
    titleItalic: 'Compromise.',
    body: 'Double-faced pure virgin cashmere crafted in generational Northern ateliers for pure thermal insulation and fluid drape.',
    img: 'img/cashmere_cocoon_coat.jpg',
    badge: '100% Cashmere'
  },
  denim: {
    label: '14.5oz Okayama Selvedge Denim',
    titleMain: 'Raw Indigo',
    titleItalic: 'Provenance.',
    body: 'Woven on vintage Toyoda shuttle looms with natural botanical indigo dye, developing personalized fade memory over decades.',
    img: 'img/okayama_selvedge_denim.jpg',
    badge: 'Shuttle Loomed'
  },
  silk: {
    label: '22-Momme Sandwashed Silk',
    titleMain: 'Fluid Architectural',
    titleItalic: 'Eveningwear.',
    body: 'Subtle matte sandwashed finish with liquid drape and natural temperature-regulating breathable mulberry fibers.',
    img: 'img/mulberry_silk_dress.jpg',
    badge: 'Pure Mulberry'
  }
};

function switchHeroTextile(key, btn) {
  const textInfo = HERO_TEXTILES[key];
  if (!textInfo) return;

  document.querySelectorAll('.hero-swatch-btn').forEach(b => {
    b.className = 'hero-swatch-btn px-3 py-1 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 text-[10px] font-mono uppercase tracking-wider transition-all flex items-center gap-1.5 cursor-pointer flex-shrink-0';
  });
  if (btn) {
    btn.className = 'hero-swatch-btn active px-3 py-1 rounded-full bg-[#dfb76c] text-stone-950 text-[10px] font-mono font-bold uppercase tracking-wider transition-all shadow-md flex items-center gap-1.5 cursor-pointer flex-shrink-0';
  }

  const modelImg = document.getElementById('heroModelImage');
  if (modelImg) {
    modelImg.style.opacity = '0';
    modelImg.style.transform = 'scale(0.96)';
    setTimeout(() => {
      modelImg.src = textInfo.img;
      modelImg.style.opacity = '1';
      modelImg.style.transform = 'scale(1)';
    }, 250);
  }
}

// ── 16. CATEGORY FILTER IN PRODUCT SHOWCASE ────────────────────────
function filterStorefrontCategory(catKey, btn) {
  document.querySelectorAll('.store-filter-tab').forEach(b => {
    b.className = 'store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-white/5 border border-white/10 text-stone-300 hover:border-stone-400 hover:text-white';
  });
  if (btn) {
    btn.className = 'store-filter-tab active px-4 py-2 rounded-full text-xs font-mono font-bold uppercase tracking-wider transition-all cursor-pointer bg-[#dfb76c] text-stone-950 shadow-md border border-[#dfb76c]';
  }

  const cards = document.querySelectorAll('.store-product-card');
  cards.forEach(card => {
    const cardCat = card.getAttribute('data-category');
    if (catKey === 'all' || cardCat === catKey) {
      card.style.display = 'flex';
      card.style.opacity = '0';
      card.style.transform = 'translateY(10px)';
      setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
        card.style.transition = 'all 0.35s ease';
      }, 50);
    } else {
      card.style.display = 'none';
    }
  });
}

function scrollCategoryStrip(delta) {
  const container = document.getElementById('categoryStripScroll');
  if (container) {
    container.scrollBy({ left: delta, behavior: 'smooth' });
  }
}

function scrollToSection(id) {
  const el = document.getElementById(id);
  if (el) {
    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}

// ── 17. STICKY MOBILE ACTION BAR & SCROLL DETECTOR ─────────────────
function initScrollBehaviors() {
  const header = document.getElementById('mainHeader');
  const stickyBar = document.getElementById('stickyMobileBar');
  const progressBar = document.getElementById('scrollProgressBar');

  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY || window.pageYOffset;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    
    // Progress Line
    if (progressBar && docHeight > 0) {
      const pct = (scrollY / docHeight) * 100;
      progressBar.style.width = `${pct}%`;
    }

    // Header Background
    if (header) {
      if (scrollY > 40) {
        header.classList.add('luxury-glass-heavy');
        header.classList.remove('bg-transparent');
      } else {
        header.classList.remove('luxury-glass-heavy');
      }
    }

    // Sticky Mobile Bar (Show after passing hero)
    if (stickyBar) {
      if (scrollY > 500 && window.innerWidth < 768) {
        stickyBar.classList.add('visible');
      } else {
        stickyBar.classList.remove('visible');
      }
    }
  }, { passive: true });
}

// ── 18. ESCAPE UTILITY ─────────────────────────────────────────────
function escapeQuotes(str) {
  return (str || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

// ── 19. INITIALIZATION ON DOM READY ────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  updateCartBadge();
  updateWishlistBadges();
  updateAllPricesInDOM();
  initScrollBehaviors();
  initExitIntent();
  renderStylistCombo('business');

  // Hero Countdown
  const heroTimer = document.getElementById('heroCountdownTimer');
  if (heroTimer) {
    let secs = 16800; // ~4h 40m
    setInterval(() => {
      secs--;
      if (secs <= 0) secs = 16800;
      const h = String(Math.floor(secs / 3600)).padStart(2, '0');
      const m = String(Math.floor((secs % 3600) / 60)).padStart(2, '0');
      const s = String(secs % 60).padStart(2, '0');
      heroTimer.textContent = `${h}h : ${m}m : ${s}s`;
    }, 1000);
  }
});
