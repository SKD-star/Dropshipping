<?php
/**
 * ====================================================================
 * LUMINA ATELIER — TRIAL VERSION (trial.php)
 * "Quiet Luxury Meets Intelligent Technology"
 * ====================================================================
 * Standalone Luxury Fashion Experience — Original index.php remains untouched.
 */

// 1. Attempt Database Initialization with Graceful Standalone Fallback
$db_connected = false;
$collections = [];
$featured_products = [];
$flash_deals = [];
$reviews = [];

if (file_exists(__DIR__ . '/db.php')) {
    @require_once __DIR__ . '/db.php';
    if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
        $db_connected = true;
        
        // Fetch collections
        $res_col = @$conn->query("SELECT * FROM collections WHERE is_active = 1 ORDER BY sort_order ASC");
        if ($res_col) {
            while ($row = $res_col->fetch_assoc()) {
                $collections[] = $row;
            }
        }

        // Fetch featured products with images
        $res_prod = @$conn->query("
            SELECT p.*, pi.url AS primary_image, c.title AS collection_title, c.slug AS collection_slug 
            FROM products p 
            LEFT JOIN collections c ON c.id = p.collection_id 
            LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1 
            WHERE p.status = 'active' 
            ORDER BY p.id ASC LIMIT 12
        ");
        if ($res_prod) {
            while ($row = $res_prod->fetch_assoc()) {
                $featured_products[] = $row;
            }
        }

        // Fetch reviews
        $res_rev = @$conn->query("
            SELECT r.*, p.title AS product_title 
            FROM reviews r 
            LEFT JOIN products p ON p.id = r.product_id 
            WHERE r.status = 'approved' 
            ORDER BY r.id ASC LIMIT 6
        ");
        if ($res_rev) {
            while ($row = $res_rev->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
    }
}

// 2. Comprehensive High-Fashion Curated Dataset (Graceful Fallback & Production Data)
if (empty($collections)) {
    $collections = [
        ['id' => 1, 'title' => 'Outerwear & Cashmere', 'slug' => 'outerwear', 'description' => 'Architectural 700 GSM Mongolian Cashmere & Melton Wool Coats', 'image_url' => 'img/cashmere_cocoon_coat.jpg'],
        ['id' => 2, 'title' => 'Okayama Selvedge Denim', 'slug' => 'denim', 'description' => '14.5oz Shuttle-Loomed Japanese Natural Indigo Denim', 'image_url' => 'img/okayama_selvedge_denim.jpg'],
        ['id' => 3, 'title' => 'Mulberry Silk Eveningwear', 'slug' => 'silk', 'description' => 'Fluid 22-Momme Sandwashed Pure Mulberry Silk', 'image_url' => 'img/mulberry_silk_dress.jpg'],
        ['id' => 4, 'title' => 'Tailored Blazers & Suiting', 'slug' => 'tailoring', 'description' => 'Super 150s Italian Virgin Wool Bespoke Suiting', 'image_url' => 'img/wool_blazer_luxury.jpg'],
        ['id' => 5, 'title' => 'Heavyweight French Terry', 'slug' => 'knitwear', 'description' => '500 GSM Custom Knit Loopback Essentials', 'image_url' => 'img/terry_hoodie_luxury.jpg'],
        ['id' => 6, 'title' => 'Fine Knitwear & Cashmere', 'slug' => 'cashmere', 'description' => 'Pure Mongolian Virgin Cashmere Ribbed Sweaters', 'image_url' => 'img/cashmere_turtleneck_knit.jpg']
    ];
}

if (empty($featured_products)) {
    $featured_products = [
        [
            'id' => 1,
            'title' => 'The Atelier Cashmere Cocoon Coat',
            'slug' => 'the-atelier-cashmere-cocoon-coat',
            'base_price' => 6999,
            'compare_at_price' => 11999,
            'primary_image' => 'img/cashmere_cocoon_coat.jpg',
            'collection_title' => 'Outerwear & Cashmere',
            'short_description' => 'Architectural 700 GSM double-faced pure Mongolian cashmere with horn button closures.',
            'category_tag' => 'cashmere'
        ],
        [
            'id' => 2,
            'title' => 'Mongolian Cashmere Ribbed Turtleneck',
            'slug' => 'mongolian-cashmere-ribbed-turtleneck',
            'base_price' => 4999,
            'compare_at_price' => 8499,
            'primary_image' => 'img/cashmere_turtleneck_knit.jpg',
            'collection_title' => 'Fine Knitwear',
            'short_description' => 'Ultra-fine 12-gauge virgin cashmere knit with ribbed collar and architectural cuffs.',
            'category_tag' => 'cashmere'
        ],
        [
            'id' => 3,
            'title' => 'Type II Okayama Selvedge Denim Jacket',
            'slug' => 'type-ii-okayama-selvedge-denim-jacket',
            'base_price' => 5499,
            'compare_at_price' => 8999,
            'primary_image' => 'img/denim_jacket_type2.jpg',
            'collection_title' => 'Okayama Denim',
            'short_description' => '14.5oz shuttle-loomed Japanese natural indigo denim with vintage brass hardware.',
            'category_tag' => 'denim'
        ],
        [
            'id' => 4,
            'title' => 'Italian Pleated Virgin Wool Trousers',
            'slug' => 'italian-pleated-virgin-wool-trousers',
            'base_price' => 4499,
            'compare_at_price' => 7499,
            'primary_image' => 'img/italian_pleated_trousers.jpg',
            'collection_title' => 'Tailoring',
            'short_description' => 'Super 130s Italian virgin wool with double forward pleats and extended tab closure.',
            'category_tag' => 'suiting'
        ],
        [
            'id' => 5,
            'title' => '500 GSM Heavyweight Loopback Hoodie',
            'slug' => '500-gsm-heavyweight-loopback-hoodie',
            'base_price' => 3999,
            'compare_at_price' => 6499,
            'primary_image' => 'img/terry_hoodie_luxury.jpg',
            'collection_title' => 'Heavyweight Essentials',
            'short_description' => 'Custom knit 500 GSM organic cotton loopback French terry with double-needle flatlock seams.',
            'category_tag' => 'terry'
        ],
        [
            'id' => 6,
            'title' => '14.5oz Okayama Raw Selvedge Denim',
            'slug' => '14-5oz-okayama-raw-selvedge-denim',
            'base_price' => 4799,
            'compare_at_price' => 7999,
            'primary_image' => 'img/okayama_selvedge_denim.jpg',
            'collection_title' => 'Okayama Denim',
            'short_description' => 'Unsanforized shuttle-loomed Japanese natural indigo denim with custom copper rivets.',
            'category_tag' => 'denim'
        ],
        [
            'id' => 7,
            'title' => '22-Momme Sandwashed Silk Evening Dress',
            'slug' => '22-momme-sandwashed-silk-evening-dress',
            'base_price' => 5999,
            'compare_at_price' => 9999,
            'primary_image' => 'img/mulberry_silk_dress.jpg',
            'collection_title' => 'Mulberry Silk',
            'short_description' => 'Fluid bias-cut 22-momme sandwashed pure mulberry silk with subtle matte drape.',
            'category_tag' => 'silk'
        ],
        [
            'id' => 8,
            'title' => 'Super 150s Virgin Wool Bespoke Blazer',
            'slug' => 'super-150s-virgin-wool-bespoke-blazer',
            'base_price' => 7999,
            'compare_at_price' => 13499,
            'primary_image' => 'img/wool_blazer_luxury.jpg',
            'collection_title' => 'Tailoring',
            'short_description' => 'Half-canvas tailored jacket crafted from Super 150s Italian virgin wool with horn buttons.',
            'category_tag' => 'suiting'
        ]
    ];
}

if (empty($reviews)) {
    $reviews = [
        [
            'id' => 1,
            'name' => 'Lord Alistair Sterling',
            'body' => 'The 700 GSM Cashmere Cocoon Coat is an absolute triumph of architectural tailoring. The drape is unmatched by Savile Row houses charging four times as much.',
            'rating' => 5,
            'product_title' => 'The Atelier Cashmere Cocoon Coat',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&q=80',
            'is_verified' => 1
        ],
        [
            'id' => 2,
            'name' => 'Elena Rostova',
            'body' => 'The 22-Momme Mulberry Silk Dress feels like liquid starlight against the skin. Flawless white-glove transport to Zurich within 48 hours.',
            'rating' => 5,
            'product_title' => '22-Momme Sandwashed Silk Evening Dress',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=120&q=80',
            'is_verified' => 1
        ],
        [
            'id' => 3,
            'name' => 'Kenji Takahashi',
            'body' => 'As an avid collector of Okayama denim, the 14.5oz shuttle-loomed weave and natural indigo ropedye on this Type II jacket are museum grade.',
            'rating' => 5,
            'product_title' => 'Type II Okayama Selvedge Denim Jacket',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=120&q=80',
            'is_verified' => 1
        ]
    ];
}

// Flash Deals (First 4 with calculated discounts)
$flash_deals = array_slice($featured_products, 0, 4);
foreach ($flash_deals as &$fd) {
    $orig = (float)($fd['compare_at_price'] > 0 ? $fd['compare_at_price'] : $fd['base_price'] * 1.6);
    $curr = (float)$fd['base_price'];
    $fd['discount_pct'] = round((($orig - $curr) / $orig) * 100);
    $fd['save_amount'] = $orig - $curr;
    $fd['stock_left'] = rand(2, 4);
}
unset($fd);

$hero_product = $featured_products[0];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0"/>
  <title>LUMINA Atelier — Autonomous Haute Couture Experience (Trial Edition)</title>
  <meta name="description" content="LUMINA Atelier — Autonomous performance haute couture, 700 GSM Mongolian Cashmere, 14.5oz Okayama Selvedge Denim, and bespoke Italian tailoring."/>
  <meta name="theme-color" content="#090a0d"/>

  <!-- Tailwind CSS CDN for utility baseline -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Dedicated Luxury Design System -->
  <link rel="stylesheet" href="css/trial.css"/>
</head>
<body class="bg-[#090a0d] text-[#fbf9f5] antialiased selection:bg-[#dfb76c] selection:text-[#090a0d]">

  <!-- Top Fine Luxury Scroll Progress Line -->
  <div id="scrollProgressBar" class="fixed top-0 left-0 h-[2.5px] bg-gradient-to-r from-[#b88d3e] via-[#dfb76c] to-white z-[9999] w-0 transition-all duration-150 pointer-events-none"></div>

  <!-- ══════════════════════════════════════════════════════════════
       0. VIP ANNOUNCEMENT & PROMO TICKER
  ══════════════════════════════════════════════════════════════ -->
  <div class="w-full bg-[#12131a] border-b border-white/10 py-2 px-4 text-center select-none relative z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-3 text-[10px] sm:text-xs font-mono">
      <div class="hidden md:flex items-center gap-2 text-stone-400">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
        <span>ATELIER MILANO · TOKYO · PARIS</span>
      </div>

      <div class="flex-1 text-center flex items-center justify-center gap-2">
        <span class="text-[#dfb76c] font-bold">✦ VIP PRIVILEGE DROP:</span>
        <span class="text-stone-200">50% OFF FIRST ACQUISITION WITH CODE</span>
        <button onclick="claimOfferCoupon('LUMINA50', 50, 'percent')" class="px-2 py-0.5 rounded bg-[#dfb76c] text-stone-950 font-extrabold text-[9.5px] uppercase tracking-wider hover:opacity-90 active:scale-95 transition-all cursor-pointer">
          LUMINA50
        </button>
      </div>

      <div class="hidden sm:flex items-center gap-3 text-stone-400">
        <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-[#dfb76c]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Free Insured Express Delivery</span>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════════════════
       1. LIQUID GLASS LUXURY HEADER & NAVIGATION
  ══════════════════════════════════════════════════════════════ -->
  <header id="mainHeader" class="sticky top-0 left-0 right-0 w-full z-40 transition-all duration-300 border-b border-white/5 luxury-glass">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between">
      
      <!-- Mobile Menu Trigger (Left on mobile) -->
      <div class="flex items-center gap-3 lg:hidden">
        <button onclick="toggleMobileNav()" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-stone-200 hover:text-white" aria-label="Open Navigation">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <button onclick="openSearchModal()" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-stone-200 hover:text-white" aria-label="Search">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </button>
      </div>

      <!-- Brand Identity Logo -->
      <div class="flex items-center gap-3">
        <a href="trial.php" class="flex flex-col items-start group">
          <span class="font-serif text-2xl sm:text-3xl font-bold tracking-[0.18em] text-white group-hover:text-[#dfb76c] transition-colors uppercase">
            LUMINA
          </span>
          <span class="text-[8px] font-mono tracking-[0.35em] text-[#dfb76c] uppercase -mt-1 font-semibold">
            Haute Couture Atelier
          </span>
        </a>
      </div>

      <!-- Desktop Navigation Menu -->
      <nav class="hidden lg:flex items-center gap-8 text-xs font-mono uppercase tracking-[0.15em] text-stone-300">
        <a href="#chapter1" class="hover:text-[#dfb76c] transition-colors relative py-1 group">
          <span>Lookbook</span>
          <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#dfb76c] group-hover:w-full transition-all duration-300"></span>
        </a>
        <a href="#expressCapsules" class="hover:text-[#dfb76c] transition-colors relative py-1 group">
          <span>Collections</span>
          <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#dfb76c] group-hover:w-full transition-all duration-300"></span>
        </a>
        <a href="#aiStylistSection" class="hover:text-[#dfb76c] transition-colors relative py-1 group flex items-center gap-1.5 text-[#dfb76c]">
          <span class="w-1.5 h-1.5 rounded-full bg-[#dfb76c] animate-ping"></span>
          <span>AI Stylist</span>
        </a>
        <a href="#vtrSection" class="hover:text-[#dfb76c] transition-colors relative py-1 group">
          <span>Virtual Mirror</span>
          <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#dfb76c] group-hover:w-full transition-all duration-300"></span>
        </a>
        <a href="#reviewsSection" class="hover:text-[#dfb76c] transition-colors relative py-1 group">
          <span>Provenance</span>
          <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#dfb76c] group-hover:w-full transition-all duration-300"></span>
        </a>
      </nav>

      <!-- Utility Icons (Currency, Wishlist, Bag, Search) -->
      <div class="flex items-center gap-2.5 sm:gap-3.5">
        
        <!-- Multi-Currency Switcher Dropdown -->
        <div class="relative hidden sm:block">
          <button onclick="toggleCurrencyMenu()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 text-xs font-mono text-stone-200 transition-all cursor-pointer">
            <span class="text-[#dfb76c]">✦</span>
            <span id="currentCurrencyLabel" class="font-bold">INR</span>
            <svg class="w-3 h-3 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          
          <div id="currencyDropdownMenu" class="hidden absolute right-0 top-full mt-2 w-44 luxury-glass-heavy rounded-2xl p-2 z-50 flex flex-col gap-1 border border-white/15 shadow-2xl">
            <button onclick="setCurrency('INR')" class="px-3 py-1.5 rounded-xl text-left text-xs font-mono text-stone-200 hover:bg-white/10 hover:text-[#dfb76c] transition-colors flex justify-between">
              <span>INR (₹)</span><span class="text-stone-500">India</span>
            </button>
            <button onclick="setCurrency('USD')" class="px-3 py-1.5 rounded-xl text-left text-xs font-mono text-stone-200 hover:bg-white/10 hover:text-[#dfb76c] transition-colors flex justify-between">
              <span>USD ($)</span><span class="text-stone-500">United States</span>
            </button>
            <button onclick="setCurrency('EUR')" class="px-3 py-1.5 rounded-xl text-left text-xs font-mono text-stone-200 hover:bg-white/10 hover:text-[#dfb76c] transition-colors flex justify-between">
              <span>EUR (€)</span><span class="text-stone-500">Europe</span>
            </button>
            <button onclick="setCurrency('GBP')" class="px-3 py-1.5 rounded-xl text-left text-xs font-mono text-stone-200 hover:bg-white/10 hover:text-[#dfb76c] transition-colors flex justify-between">
              <span>GBP (£)</span><span class="text-stone-500">United Kingdom</span>
            </button>
            <button onclick="setCurrency('AED')" class="px-3 py-1.5 rounded-xl text-left text-xs font-mono text-stone-200 hover:bg-white/10 hover:text-[#dfb76c] transition-colors flex justify-between">
              <span>AED (د.إ)</span><span class="text-stone-500">Emirates</span>
            </button>
            <button onclick="setCurrency('JPY')" class="px-3 py-1.5 rounded-xl text-left text-xs font-mono text-stone-200 hover:bg-white/10 hover:text-[#dfb76c] transition-colors flex justify-between">
              <span>JPY (¥)</span><span class="text-stone-500">Japan</span>
            </button>
          </div>
        </div>

        <!-- Desktop Search Trigger -->
        <button onclick="openSearchModal()" class="hidden lg:flex w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 items-center justify-center text-stone-200 hover:text-[#dfb76c] transition-all cursor-pointer" title="Search Archives">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </button>

        <!-- Wardrobe Wishlist Trigger -->
        <button onclick="toggleWishlistDrawer()" class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 border border-white/15 flex items-center justify-center text-stone-200 hover:text-rose-400 transition-all relative cursor-pointer" title="Wardrobe Wishlist">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
          <span class="wishlist-badge-count absolute -top-1 -right-1 min-w-[17px] h-[17px] px-1 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-[9px] font-mono font-bold rounded-full flex items-center justify-center border border-black hidden">0</span>
        </button>

        <!-- Curated Bag Trigger -->
        <button onclick="toggleQuickBagDrawer()" class="h-10 px-3.5 sm:px-4 rounded-full bg-gradient-to-r from-[#dfb76c] to-[#f5dfa8] text-stone-950 flex items-center gap-2 font-mono font-bold text-xs shadow-lg hover:scale-105 active:scale-95 transition-all cursor-pointer" title="Curated Bag">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
          <span class="hidden sm:inline uppercase tracking-wider text-[11px]">Bag</span>
          <span class="cart-badge-count min-w-[18px] h-[18px] px-1 bg-stone-950 text-[#dfb76c] text-[10px] font-mono font-bold rounded-full flex items-center justify-center hidden">0</span>
        </button>

      </div>

    </div>
  </header>

  <!-- ══════════════════════════════════════════════════════════════
       2. CHAPTER 01 · THE CAPSULE (EDITORIAL RUNWAY HERO)
  ══════════════════════════════════════════════════════════════ -->
  <section class="relative min-h-[85vh] md:min-h-[92vh] flex items-center justify-center overflow-hidden bg-[#090a0d] text-white py-12 md:py-20" id="chapter1">
    
    <!-- Ambient Background Lighting & Image Overlay -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
      <div class="absolute -inset-10 bg-cover bg-center opacity-30 filter saturate-[0.85] scale-105" 
           style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920&q=85');"></div>
      <div class="absolute inset-0 bg-gradient-to-t from-[#090a0d] via-[#090a0d]/80 to-[#090a0d]/40"></div>
      <div class="absolute w-[600px] h-[600px] rounded-full bg-[#dfb76c]/10 blur-[130px] top-1/4 left-1/3"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-20">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
        
        <!-- Left Column: Editorial Headline & Actions -->
        <div class="lg:col-span-7 flex flex-col items-start">
          
          <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3.5 py-1.5 rounded-full mb-4 border border-[#dfb76c]/40 shadow-sm">
            <span class="w-1.5 h-1.5 rounded-full bg-[#dfb76c] animate-ping"></span>
            <span class="font-mono text-[9px] sm:text-[10.5px] uppercase tracking-[0.22em] text-[#dfb76c] font-bold">
              Exclusive Haute Couture Release · 2026 Capsule
            </span>
          </div>

          <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl text-white mb-4 font-light leading-[1.05] tracking-tight">
            Form Without <span class="italic font-normal text-gold-gradient">Compromise.</span>
          </h1>

          <p class="text-stone-300 max-w-lg mb-6 leading-relaxed font-light text-sm sm:text-base">
            An architectural study in pure double-faced Mongolian cashmere, 14.5oz Okayama selvedge denim, and bespoke Italian tailoring. Handcrafted for the discerning collector.
          </p>

          <!-- Dynamic Textile Material Swatches -->
          <div class="flex items-center gap-2.5 mb-8 overflow-x-auto no-scrollbar py-1 max-w-full">
            <button onclick="switchHeroTextile('cashmere', this)" class="hero-swatch-btn active px-3.5 py-1.5 rounded-full bg-[#dfb76c] text-stone-950 text-[10px] font-mono font-bold uppercase tracking-wider transition-all shadow-md flex items-center gap-2 cursor-pointer flex-shrink-0">
              <span class="w-2 h-2 rounded-full bg-stone-950"></span>
              <span>700 GSM Cashmere</span>
            </button>
            <button onclick="switchHeroTextile('denim', this)" class="hero-swatch-btn px-3.5 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 text-[10px] font-mono uppercase tracking-wider transition-all flex items-center gap-2 cursor-pointer flex-shrink-0">
              <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
              <span>Okayama Denim</span>
            </button>
            <button onclick="switchHeroTextile('silk', this)" class="hero-swatch-btn px-3.5 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 text-[10px] font-mono uppercase tracking-wider transition-all flex items-center gap-2 cursor-pointer flex-shrink-0">
              <span class="w-2 h-2 rounded-full bg-rose-300"></span>
              <span>Mulberry Silk</span>
            </button>
          </div>

          <!-- High-Impact Action CTAs -->
          <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto mb-6">
            <button onclick="scrollToSection('expressCapsules')" class="btn-luxury-primary flex-1 sm:flex-initial text-xs sm:text-sm py-3.5 px-8">
              <span>Explore Masterpieces</span>
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
            <button onclick="scrollToSection('aiStylistSection')" class="btn-luxury-secondary flex-1 sm:flex-initial text-xs sm:text-sm py-3.5 px-7">
              <span class="text-[#dfb76c]">✦</span>
              <span>AI Stylist</span>
            </button>
          </div>

          <!-- Micro Provenance Ticker -->
          <div class="flex items-center flex-wrap gap-x-4 gap-y-1.5 text-xs text-stone-400 font-mono pt-3 border-t border-white/10 w-full">
            <span class="flex items-center gap-1.5"><span class="text-[#dfb76c]">✦</span> Certified Atelier Purity</span>
            <span class="text-white/20 hidden sm:inline">·</span>
            <span class="flex items-center gap-1.5"><span class="text-[#dfb76c]">✦</span> 14-Day Doorstep Returns</span>
            <span class="text-white/20 hidden sm:inline">·</span>
            <span class="flex items-center gap-1.5"><span class="text-emerald-400">✦</span> Priority BlueDart Air</span>
          </div>

        </div>

        <!-- Right Column: 3D Showcase Card -->
        <div class="lg:col-span-5 relative w-full max-w-sm sm:max-w-md mx-auto">
          <div class="luxury-card overflow-hidden border border-[#dfb76c]/40 relative group cursor-pointer" onclick="openExpressCheckout(<?= $hero_product['id'] ?>, '<?= addslashes($hero_product['title']) ?>', <?= $hero_product['base_price'] ?>, '<?= $hero_product['primary_image'] ?>')">
            
            <!-- Top Badges Ribbon -->
            <div class="absolute top-3 left-3 right-3 z-30 flex items-center justify-between pointer-events-none gap-2">
              <div class="px-3 py-1 rounded-full bg-gradient-to-r from-amber-500 via-[#dfb76c] to-amber-300 text-stone-950 font-bold text-[9px] sm:text-[10px] uppercase tracking-wider shadow-xl flex items-center gap-1">
                <span>🔥</span>
                <span>40% OFF · VIP FLASH</span>
              </div>
              <div class="luxury-glass px-3 py-1 rounded-full border border-[#dfb76c]/40 text-[#dfb76c] font-mono text-[9px] sm:text-[10px] flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span id="heroCountdownTimer">04h : 38m : 12s</span>
              </div>
            </div>

            <!-- Image with Zoom -->
            <div class="relative aspect-[3/4] w-full bg-black overflow-hidden p-3">
              <img id="heroModelImage" src="<?= htmlspecialchars($hero_product['primary_image']) ?>" alt="<?= htmlspecialchars($hero_product['title']) ?>" class="w-full h-full object-cover rounded-xl transition-all duration-700 group-hover:scale-105">
            </div>

            <!-- Floating Spec Badges -->
            <div class="absolute top-20 left-4 luxury-glass px-2.5 py-1 rounded-lg border border-[#dfb76c]/30 text-[9.5px] font-mono text-stone-200">
              100% Cashmere
            </div>
            <div class="absolute top-32 right-4 luxury-glass px-2.5 py-1 rounded-lg border border-white/20 text-[9.5px] font-mono text-emerald-400">
              18h Dispatch
            </div>

            <!-- Bottom Glass Master Offer Bar -->
            <div class="p-4 sm:p-5 luxury-glass-heavy border-t border-white/10 flex items-center justify-between">
              <div>
                <span class="text-[9px] font-mono text-[#dfb76c] uppercase tracking-widest block font-bold">Atelier Masterpiece</span>
                <h3 class="font-serif text-sm sm:text-base font-bold text-white line-clamp-1"><?= htmlspecialchars($hero_product['title']) ?></h3>
                <div class="flex items-baseline gap-2 mt-1">
                  <span class="font-serif text-base sm:text-lg font-bold text-[#dfb76c]" data-price-inr="<?= $hero_product['base_price'] ?>">₹<?= number_format($hero_product['base_price'], 0) ?></span>
                  <span class="text-xs text-stone-500 line-through" data-price-inr="<?= $hero_product['compare_at_price'] ?>">₹<?= number_format($hero_product['compare_at_price'], 0) ?></span>
                </div>
              </div>

              <button class="btn-luxury-primary text-[10px] py-2 px-4 flex-shrink-0">
                Acquire Now
              </button>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       3. CHAPTER 02 · ATELIER ARCHIVES (CIRCULAR CATEGORY STRIP)
  ══════════════════════════════════════════════════════════════ -->
  <section class="w-full bg-[#111218] border-y border-white/10 py-8 overflow-hidden relative z-20 select-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-2.5">
          <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#dfb76c] opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#dfb76c]"></span>
          </span>
          <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#dfb76c] font-mono">Curated Atelier Archives</span>
        </div>
        <div class="flex items-center gap-2">
          <button onclick="scrollCategoryStrip(-240)" class="w-7 h-7 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-stone-200 flex items-center justify-center transition-all cursor-pointer" aria-label="Scroll Left">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          </button>
          <button onclick="scrollCategoryStrip(240)" class="w-7 h-7 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-stone-200 flex items-center justify-center transition-all cursor-pointer" aria-label="Scroll Right">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
      </div>

      <!-- 3D Magnetic Horizontal Scrollable Circles -->
      <div id="categoryStripScroll" class="flex items-center gap-6 sm:gap-8 overflow-x-auto no-scrollbar py-3 scroll-smooth">
        <?php foreach ($collections as $rc): ?>
        <div onclick="scrollToSection('expressCapsules'); filterStorefrontCategory('<?= $rc['slug'] ?>')" class="flex flex-col items-center group flex-shrink-0 cursor-pointer text-center relative" style="width: 108px;">
          
          <div class="category-3d-circle relative w-20 h-20 sm:w-24 sm:h-24 rounded-full p-[3px]">
            <!-- Outer Golden Corona Ring -->
            <div class="gold-corona-ring"></div>

            <div class="relative w-full h-full rounded-full p-[2px] bg-gradient-to-tr from-[#dfb76c]/60 via-yellow-200 to-[#b88d3e]/60">
              <div class="w-full h-full rounded-full overflow-hidden bg-black relative">
                <img src="<?= htmlspecialchars($rc['image_url']) ?>" alt="<?= htmlspecialchars($rc['title']) ?>" class="w-full h-full object-cover group-hover:scale-115 transition-transform duration-500 ease-out" loading="lazy">
              </div>
            </div>
          </div>

          <span class="text-xs font-medium text-stone-300 group-hover:text-[#dfb76c] mt-3 line-clamp-1 transition-colors tracking-tight font-sans">
            <?= htmlspecialchars($rc['title']) ?>
          </span>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- Multi-Currency "Shop by Price" Quick Filter Chips -->
  <div class="w-full bg-[#0a0b0e] border-b border-white/10 py-3.5 px-4 overflow-x-auto no-scrollbar">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-center gap-2.5 text-xs font-mono">
      <span class="text-stone-500 uppercase tracking-widest text-[10px] font-bold mr-2">Quick Budget:</span>
      <button onclick="scrollToSection('expressCapsules')" class="px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-stone-200 hover:border-[#dfb76c]/60 transition-all flex items-center gap-1">
        <span>Under</span> <span class="text-[#dfb76c] font-bold" data-price-inr="499">₹499</span>
      </button>
      <button onclick="scrollToSection('expressCapsules')" class="px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-stone-200 hover:border-[#dfb76c]/60 transition-all flex items-center gap-1">
        <span class="text-[#dfb76c] font-bold" data-price-inr="500">₹500</span><span>–</span><span class="text-[#dfb76c] font-bold" data-price-inr="999">₹999</span>
      </button>
      <button onclick="scrollToSection('expressCapsules')" class="px-3.5 py-1.5 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-stone-200 hover:border-[#dfb76c]/60 transition-all flex items-center gap-1">
        <span class="text-[#dfb76c] font-bold" data-price-inr="1000">₹1,000</span><span>–</span><span class="text-[#dfb76c] font-bold" data-price-inr="2499">₹2,499</span>
      </button>
      <button onclick="scrollToSection('expressCapsules')" class="px-4 py-1.5 rounded-full bg-[#dfb76c]/15 hover:bg-[#dfb76c]/25 border border-[#dfb76c]/50 text-[#dfb76c] font-bold transition-all flex items-center gap-1.5">
        <span>✦</span> <span data-price-inr="2500">₹2,500</span>+ Luxury Tier
      </button>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════════════════════
       4. CHAPTER 03 · KINETIC VELOCITY RUNWAY FILMSTRIP
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-12 md:py-16 bg-[#090a0d] text-white overflow-hidden border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 flex justify-between items-end">
      <div>
        <span class="text-[10px] sm:text-xs text-[#dfb76c] uppercase tracking-[0.25em] block mb-1 font-mono font-bold">Couture In Motion</span>
        <h2 class="font-serif text-2xl sm:text-3xl text-white">The Runway Filmstrip</h2>
      </div>
      <span class="text-xs text-stone-500 font-mono hidden md:block">✦ Continuous Atelier Velocity Reel</span>
    </div>

    <!-- Scrolling Filmstrip Track -->
    <div class="w-full overflow-hidden py-2">
      <div class="flex items-center gap-4 sm:gap-6 overflow-x-auto no-scrollbar px-4">
        <?php foreach (array_slice($featured_products, 0, 6) as $idx => $fp): 
            $f_num = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
        ?>
        <div onclick="openExpressCheckout(<?= $fp['id'] ?>, '<?= addslashes($fp['title']) ?>', <?= $fp['base_price'] ?>, '<?= $fp['primary_image'] ?>')" class="w-[240px] sm:w-[300px] md:w-[340px] flex-shrink-0 aspect-[3/4] relative rounded-2xl overflow-hidden border border-white/10 group cursor-pointer luxury-card">
          <img src="<?= htmlspecialchars($fp['primary_image']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="<?= htmlspecialchars($fp['title']) ?>">
          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/25 to-transparent"></div>
          
          <div class="absolute bottom-3 left-3 right-3 flex justify-between items-end">
            <div class="max-w-[70%]">
              <span class="text-[9px] font-mono text-[#dfb76c] block mb-0.5"><?= $f_num ?>. LUMINA ATELIER</span>
              <h4 class="font-serif text-xs sm:text-sm text-white font-bold leading-tight truncate"><?= htmlspecialchars($fp['title']) ?></h4>
            </div>
            <span class="text-xs font-mono font-bold text-stone-950 bg-[#dfb76c] px-2 py-1 rounded" data-price-inr="<?= $fp['base_price'] ?>">₹<?= number_format($fp['base_price'], 0) ?></span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       5. CHAPTER 04 · CURATED MASTERPIECES (PRODUCT SHOWCASE)
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-14 md:py-20 bg-[#0c0d12] text-white border-b border-white/10 relative" id="expressCapsules">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 pb-4 border-b border-white/10 gap-4">
        <div>
          <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 px-3 py-1 rounded-full text-[10px] font-mono uppercase tracking-widest text-[#dfb76c] mb-2 font-bold">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Curated Atelier Masterpieces</span>
          </div>
          <h2 class="font-serif text-3xl sm:text-4xl text-white font-light">Hand-Numbered Capsule Releases</h2>
          <p class="text-xs text-stone-400 font-light mt-1 max-w-md">
            Explore signature silhouettes crafted from certified organic double-faced fibers and tailored in small numbered editions.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <span class="text-xs font-mono text-[#dfb76c] font-semibold">Total Masterpieces: <?= count($featured_products) ?></span>
        </div>
      </div>

      <!-- Filter Tabs -->
      <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-4 mb-4">
        <button onclick="filterStorefrontCategory('all', this)" class="store-filter-tab active px-4 py-2 rounded-full text-xs font-mono font-bold uppercase tracking-wider transition-all cursor-pointer bg-[#dfb76c] text-stone-950 shadow-md border border-[#dfb76c]">
          ✦ All Archives (<?= count($featured_products) ?>)
        </button>
        <button onclick="filterStorefrontCategory('cashmere', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-white/5 border border-white/10 text-stone-300 hover:border-stone-400 hover:text-white">
          Outerwear &amp; Cashmere
        </button>
        <button onclick="filterStorefrontCategory('denim', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-white/5 border border-white/10 text-stone-300 hover:border-stone-400 hover:text-white">
          Okayama Denim
        </button>
        <button onclick="filterStorefrontCategory('terry', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-white/5 border border-white/10 text-stone-300 hover:border-stone-400 hover:text-white">
          Heavyweight Essentials
        </button>
        <button onclick="filterStorefrontCategory('silk', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-white/5 border border-white/10 text-stone-300 hover:border-stone-400 hover:text-white">
          Mulberry Silk
        </button>
        <button onclick="filterStorefrontCategory('suiting', this)" class="store-filter-tab px-4 py-2 rounded-full text-xs font-mono font-medium uppercase tracking-wider transition-all cursor-pointer bg-white/5 border border-white/10 text-stone-300 hover:border-stone-400 hover:text-white">
          Tailored Suiting
        </button>
      </div>

      <!-- 2-Column Mobile, 4-Column Desktop Product Cards Grid -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6" id="storefrontProductsGrid">
        <?php foreach ($featured_products as $idx => $prod): 
            $cat_tag = $prod['category_tag'] ?? 'cashmere';
            $p_price = (float)$prod['base_price'];
            $p_img = $prod['primary_image'];
            $p_stock = 2 + ($idx % 3);
            $qv_json = htmlspecialchars(json_encode([
                'id' => $prod['id'],
                'title' => $prod['title'],
                'price' => $p_price,
                'image' => $p_img,
                'description' => $prod['short_description'] ?? 'Bespoke tailoring piece.'
            ]), ENT_QUOTES, 'UTF-8');
        ?>
        <div class="store-product-card trial-product-card group" data-category="<?= $cat_tag ?>" data-product-id="<?= $prod['id'] ?>">
          
          <!-- Image Wrapper -->
          <div class="img-wrapper cursor-pointer" onclick="openQuickView(<?= $qv_json ?>)">
            <img src="<?= htmlspecialchars($p_img) ?>" alt="<?= htmlspecialchars($prod['title']) ?>" loading="lazy">

            <!-- Scarcity Badge -->
            <div class="absolute top-2 sm:top-3 left-2 sm:left-3 z-10">
              <span class="text-[8px] sm:text-[9px] font-mono font-bold uppercase tracking-wider bg-black/85 backdrop-blur-md text-[#dfb76c] px-2 py-0.5 rounded-full border border-white/10 flex items-center gap-1 shadow-md">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Only <?= $p_stock ?> Left</span>
              </span>
            </div>

            <!-- Quick Direct Actions (Wishlist + Instant Buy) -->
            <div class="absolute top-2 sm:top-3 right-2 sm:right-3 flex items-center gap-1.5 z-10" onclick="event.stopPropagation()">
              <button onclick="toggleWishlistItem({id:<?= $prod['id'] ?>, title:'<?= addslashes($prod['title']) ?>', price:<?= $p_price ?>, image:'<?= addslashes($p_img) ?>'})" class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-black/80 hover:bg-black text-rose-400 flex items-center justify-center border border-white/20 shadow-md transition-transform hover:scale-110 active:scale-95 cursor-pointer" title="Save to Wardrobe">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
              </button>
            </div>

            <!-- Hover Quick View Bar -->
            <div class="absolute inset-x-2.5 bottom-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 hidden sm:block" onclick="event.stopPropagation()">
              <button onclick="openQuickView(<?= $qv_json ?>)" class="w-full py-1.5 bg-black/90 hover:bg-black text-[#dfb76c] font-mono text-[9px] uppercase font-bold tracking-widest rounded-lg border border-white/10 transition-all cursor-pointer flex items-center justify-center gap-1 shadow-lg">
                <span>Inspect Piece</span>
              </button>
            </div>
          </div>

          <!-- Product Details & CTAs -->
          <div class="p-3 sm:p-4 flex flex-col justify-between flex-1 bg-[#111218]">
            <div>
              <div class="flex items-center justify-between gap-1 mb-1">
                <span class="text-[8.5px] font-mono uppercase tracking-widest text-[#dfb76c] font-bold truncate">LUMINA ATELIER</span>
                <span class="text-[9px] font-mono text-amber-400 font-bold">★ 4.9</span>
              </div>

              <h3 class="font-serif text-xs sm:text-sm font-bold text-white mb-1 group-hover:text-[#dfb76c] transition-colors line-clamp-1">
                <?= htmlspecialchars($prod['title']) ?>
              </h3>

              <div class="flex items-baseline justify-between gap-1 mb-3">
                <span class="font-serif font-bold text-xs sm:text-base text-white" data-price-inr="<?= $p_price ?>">₹<?= number_format($p_price, 0) ?></span>
                <span class="text-[8.5px] font-mono text-emerald-400 bg-emerald-950/60 border border-emerald-500/30 px-1.5 py-0.5 rounded">Free Air</span>
              </div>
            </div>

            <!-- Action Buttons Grid -->
            <div class="pt-2 border-t border-white/10 grid grid-cols-2 gap-1.5 sm:gap-2">
              <button onclick="openAtelierFitModal({id:<?= $prod['id'] ?>, title:'<?= addslashes($prod['title']) ?>', price:<?= $p_price ?>, image:'<?= htmlspecialchars($p_img) ?>'})" class="w-full py-2 bg-white/5 border border-white/15 hover:border-[#dfb76c] text-stone-200 font-mono text-[8.5px] sm:text-[10px] uppercase font-bold tracking-wider rounded-lg transition-all flex items-center justify-center gap-1 active:scale-95 cursor-pointer">
                <span>Acquire</span>
              </button>
              <button onclick="openExpressCheckout(<?= $prod['id'] ?>, '<?= addslashes($prod['title']) ?>', <?= $p_price ?>, '<?= htmlspecialchars($p_img) ?>')" class="w-full py-2 bg-gradient-to-r from-[#dfb76c] to-[#f5dfa8] text-stone-950 font-mono text-[8.5px] sm:text-[10px] uppercase font-extrabold tracking-wider rounded-lg transition-all flex items-center justify-center gap-1 active:scale-95 cursor-pointer shadow-md">
                <span>Buy</span>
              </button>
            </div>

          </div>

        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       6. CHAPTER 05 · NEURAL AI STYLIST (OUTFIT INTELLIGENCE)
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-16 md:py-24 bg-[#090a0d] text-white border-b border-white/10 relative overflow-hidden" id="aiStylistSection">
    <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(ellipse_80%_50%_at_50%_0%,rgba(223,183,108,0.08),transparent)]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Section Header -->
      <div class="text-center mb-10 sm:mb-12">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-[#dfb76c] text-xs font-mono uppercase tracking-widest mb-4 font-bold">
          <span class="w-2 h-2 rounded-full bg-[#dfb76c] animate-pulse"></span>
          Lumina AI Stylist · Neural Outfit Curation
        </div>
        <h2 class="text-3xl sm:text-5xl font-serif text-white mb-3">
          Your Personal <span class="italic text-gold-gradient">AI Stylist</span>
        </h2>
        <p class="text-stone-400 text-xs sm:text-sm max-w-xl mx-auto font-light leading-relaxed">
          Our AI analyses aesthetics, fiber drape, and proportions to curate complete 3-piece ensembles with bespoke styling advice and 1-click bundle acquisition.
        </p>
      </div>

      <!-- Mood Selector Pills -->
      <div class="flex flex-wrap gap-2 justify-center mb-8 sm:mb-10">
        <button onclick="selectStylistMood('business')" data-mood="business" class="stylist-mood-pill px-4 py-2 rounded-full border border-[#dfb76c] bg-[#dfb76c] text-stone-950 text-xs font-mono font-bold uppercase tracking-wider transition-all shadow-md">
          💼 Business Luxe
        </button>
        <button onclick="selectStylistMood('street')" data-mood="street" class="stylist-mood-pill px-4 py-2 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 text-stone-300 text-xs font-mono uppercase tracking-wider transition-all">
          🔥 Street Couture
        </button>
        <button onclick="selectStylistMood('evening')" data-mood="evening" class="stylist-mood-pill px-4 py-2 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 text-stone-300 text-xs font-mono uppercase tracking-wider transition-all">
          ✨ Evening Gala
        </button>
        <button onclick="selectStylistMood('weekend')" data-mood="weekend" class="stylist-mood-pill px-4 py-2 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 text-stone-300 text-xs font-mono uppercase tracking-wider transition-all">
          🌿 Weekend Edit
        </button>
        <button onclick="selectStylistMood('athleisure')" data-mood="athleisure" class="stylist-mood-pill px-4 py-2 rounded-full border border-white/15 bg-white/5 hover:bg-white/10 text-stone-300 text-xs font-mono uppercase tracking-wider transition-all">
          ⚡ Athleisure Pro
        </button>
      </div>

      <!-- AI Outfit Container Grid -->
      <div class="relative">
        
        <!-- AI Thinking Overlay -->
        <div id="aiThinkingOverlay" class="hidden absolute inset-0 bg-[#090a0d]/90 backdrop-blur-md z-30 flex flex-col items-center justify-center rounded-3xl">
          <div class="flex gap-2 mb-4">
            <span class="w-3 h-3 rounded-full bg-[#dfb76c] animate-bounce" style="animation-delay:0s"></span>
            <span class="w-3 h-3 rounded-full bg-white animate-bounce" style="animation-delay:0.15s"></span>
            <span class="w-3 h-3 rounded-full bg-[#dfb76c] animate-bounce" style="animation-delay:0.3s"></span>
          </div>
          <p class="text-xs font-mono text-[#dfb76c] uppercase tracking-widest">Neural AI is synthesizing your capsule look…</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
          
          <!-- Left: Style Identity Card -->
          <div class="lg:col-span-3 luxury-card p-5 sm:p-6 flex flex-col justify-between" id="stylistIdentityCard">
            <div>
              <span class="text-[9px] font-mono uppercase tracking-widest text-[#dfb76c] font-bold block mb-1">AI Style Identity</span>
              <h3 class="font-serif text-xl sm:text-2xl text-white mb-2" id="stylistStyleTitle">The Milan Executive</h3>
              <p class="text-stone-400 text-xs leading-relaxed mb-6 font-light" id="stylistStyleDesc">
                Structured silhouettes with premium cashmere and virgin wool. Exudes authority, taste, and effortless poise.
              </p>

              <!-- Radar Scores -->
              <div class="space-y-3.5">
                <div>
                  <div class="flex justify-between text-[10px] font-mono mb-1">
                    <span class="text-stone-400 uppercase">Formality</span>
                    <span class="text-[#dfb76c] font-bold" id="score_formality">94%</span>
                  </div>
                  <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#b88d3e] to-[#dfb76c] rounded-full transition-all duration-700" id="bar_formality" style="width:94%"></div>
                  </div>
                </div>

                <div>
                  <div class="flex justify-between text-[10px] font-mono mb-1">
                    <span class="text-stone-400 uppercase">Versatility</span>
                    <span class="text-[#dfb76c] font-bold" id="score_versatility">78%</span>
                  </div>
                  <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#b88d3e] to-[#dfb76c] rounded-full transition-all duration-700" id="bar_versatility" style="width:78%"></div>
                  </div>
                </div>

                <div>
                  <div class="flex justify-between text-[10px] font-mono mb-1">
                    <span class="text-stone-400 uppercase">Trend Score</span>
                    <span class="text-[#dfb76c] font-bold" id="score_trend">86%</span>
                  </div>
                  <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#b88d3e] to-[#dfb76c] rounded-full transition-all duration-700" id="bar_trend" style="width:86%"></div>
                  </div>
                </div>

                <div>
                  <div class="flex justify-between text-[10px] font-mono mb-1">
                    <span class="text-stone-400 uppercase">Luxury Index</span>
                    <span class="text-[#dfb76c] font-bold" id="score_luxury">98%</span>
                  </div>
                  <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#b88d3e] to-[#dfb76c] rounded-full transition-all duration-700" id="bar_luxury" style="width:98%"></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-6 pt-4 border-t border-white/10">
              <span class="text-[9px] font-mono uppercase tracking-widest text-stone-500 block mb-2 font-bold">Best For</span>
              <div class="flex flex-wrap gap-1.5" id="stylistBestForTags">
                <!-- Tags injected by JS -->
              </div>
            </div>
          </div>

          <!-- Center: 3 Outfit Pieces -->
          <div class="lg:col-span-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5" id="stylistOutfitItemsGrid">
              <!-- Injected by JS -->
            </div>
          </div>

          <!-- Right: Advice & Bundle Acquisition -->
          <div class="lg:col-span-3 flex flex-col gap-4">
            
            <!-- How to Wear Guide -->
            <div class="luxury-card p-4 sm:p-5">
              <span class="text-[9px] font-mono uppercase tracking-widest text-[#dfb76c] block mb-3 font-bold">AI Dressing Advice</span>
              <ul class="space-y-2.5" id="stylistHowToWear">
                <!-- Injected by JS -->
              </ul>
            </div>

            <!-- Price & Buy Full Outfit -->
            <div class="luxury-card p-5 bg-gradient-to-b from-[#181922] to-[#111218] border border-[#dfb76c]/40">
              <span class="text-[9px] font-mono uppercase tracking-widest text-stone-400 block mb-1">Full 3-Piece Total</span>
              <div class="font-serif text-2xl sm:text-3xl font-bold text-[#dfb76c] mb-1" id="stylistComboTotalPrice">₹14,997</div>
              <p class="text-[11px] text-stone-400 mb-4">Saving <strong class="text-emerald-400" id="stylistComboTotalSave">₹5,000</strong> vs individual acquisition</p>
              
              <button onclick="acquireFullStylistOutfit()" class="btn-luxury-primary w-full text-xs py-3 mb-2">
                <span>Shop Full Outfit</span>
              </button>
              <button onclick="shuffleStylistOutfit()" class="btn-luxury-secondary w-full text-xs py-2.5">
                <span>Shuffle Outfit</span>
              </button>
            </div>

            <!-- Launch Virtual Mirror -->
            <button onclick="openVirtualTryOnModal()" class="w-full py-3 rounded-xl border border-[#dfb76c]/40 bg-white/5 hover:bg-[#dfb76c]/10 text-[#dfb76c] text-xs font-mono uppercase font-bold tracking-wider transition-all flex items-center justify-center gap-2 cursor-pointer">
              <span>Launch Virtual Mirror →</span>
            </button>

          </div>

        </div>

      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       7. CHAPTER 06 · VIRTUAL FITTING ROOM & MIRROR SIMULATOR
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-16 md:py-24 bg-[#0c0d12] border-b border-white/10 text-white relative overflow-hidden" id="vtrSection">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        
        <!-- Left Column: Copy & Benefits -->
        <div>
          <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-[#dfb76c]/10 border border-[#dfb76c]/30 text-[#dfb76c] text-xs font-mono uppercase tracking-widest mb-4 font-bold">
            <span>📷</span>
            <span>Virtual Fitting Room · AI Try-On</span>
          </div>

          <h2 class="text-3xl sm:text-5xl font-serif text-white mb-4 leading-tight font-light">
            See It On <span class="italic text-gold-gradient">Your Body.</span><br>Before You Acquire.
          </h2>

          <p class="text-stone-300 text-sm leading-relaxed mb-6 max-w-md font-light">
            Calibrate your exact body silhouette and size (XS to 3XL). Our neural drape engine models how double-faced cashmere and raw selvedge denim drape over your frame in real time.
          </p>

          <!-- Feature Pills -->
          <div class="flex flex-wrap gap-2.5 mb-8 text-xs font-mono text-stone-300">
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full"><span class="text-emerald-400">✓</span> Processed securely in browser</span>
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full"><span class="text-emerald-400">✓</span> Precision sizes XS to 3XL</span>
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full"><span class="text-emerald-400">✓</span> 4 body silhouette archetypes</span>
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-full"><span class="text-emerald-400">✓</span> 96% Drape Accuracy</span>
          </div>

          <div class="flex items-center gap-4">
            <button onclick="openVirtualTryOnModal()" class="btn-luxury-primary py-3.5 px-8 text-xs sm:text-sm">
              <span>Launch Virtual Fitting Room</span>
            </button>
            <button onclick="openModelFittingStudioModal()" class="btn-luxury-secondary py-3.5 px-6 text-xs sm:text-sm">
              <span>3-Look Studio</span>
            </button>
          </div>
        </div>

        <!-- Right Column: Interactive Smartphone Mockup -->
        <div class="relative mx-auto w-full max-w-xs sm:max-w-sm">
          <div class="luxury-card p-3 rounded-[36px] border border-white/20 shadow-2xl bg-gradient-to-b from-[#181924] to-[#0d0e14]">
            
            <!-- Phone Notch -->
            <div class="w-24 h-4 bg-black rounded-full mx-auto mb-2 flex items-center justify-center">
              <div class="w-2 h-2 rounded-full bg-stone-800"></div>
            </div>

            <!-- Screen Viewport -->
            <div class="relative aspect-[9/16] rounded-[24px] overflow-hidden bg-black border border-white/10 p-4 flex flex-col justify-between">
              
              <!-- Top Badge in Phone -->
              <div class="flex items-center justify-between z-10">
                <span class="px-2.5 py-1 bg-black/80 border border-[#dfb76c] text-[#dfb76c] text-[9px] font-mono font-bold rounded-full">
                  SIZE M · 96% FIT
                </span>
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
              </div>

              <!-- Vector Model Silhouette Simulation -->
              <div class="relative w-full flex-1 flex items-center justify-center my-2">
                <img src="img/model_look_executive.jpg" alt="Virtual Fit" class="w-full h-full object-cover rounded-xl opacity-85">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/30 pointer-events-none"></div>
              </div>

              <!-- Bottom Drape Metric in Phone -->
              <div class="luxury-glass p-2.5 rounded-xl border border-white/15 z-10">
                <div class="flex items-center justify-between text-[9px] font-mono mb-1">
                  <span class="text-stone-400">AI DRAPE ANALYSIS</span>
                  <span class="text-emerald-400 font-bold">Optimal</span>
                </div>
                <div class="h-1 bg-white/10 rounded-full overflow-hidden mb-1.5">
                  <div class="h-full bg-gradient-to-r from-[#dfb76c] to-emerald-400 w-[96%]"></div>
                </div>
                <p class="text-[9px] text-stone-300 font-sans leading-tight">Shoulders &amp; waist aligned seamlessly to frame.</p>
              </div>

            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       8. CHAPTER 07 · HIGH-URGENCY VIP FLASH DEALS ENGINE
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-16 md:py-20 bg-[#090a0d] border-b border-white/10 text-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center mb-10 sm:mb-12">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-rose-950/60 border border-rose-500/40 text-rose-400 text-xs font-mono uppercase tracking-widest mb-3 font-bold">
          <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
          <span>Last Chance · Flash Privilege · Drop Window Closing</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-serif text-white font-light">
          Today's VIP <span class="italic text-gold-gradient">Privilege Drops.</span>
        </h2>
        <p class="text-stone-400 text-xs sm:text-sm max-w-lg mx-auto font-light mt-1">
          Curated atelier pieces available at member privilege pricing. Stock is strictly numbered — acquire before the release cycle closes.
        </p>
      </div>

      <!-- Flash Deal Cards Grid -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
        <?php foreach ($flash_deals as $fd): ?>
        <div class="trial-product-card group" onclick="openExpressCheckout(<?= $fd['id'] ?>, '<?= addslashes($fd['title']) ?>', <?= $fd['base_price'] ?>, '<?= $fd['primary_image'] ?>')">
          
          <div class="img-wrapper cursor-pointer">
            <img src="<?= htmlspecialchars($fd['primary_image']) ?>" alt="<?= htmlspecialchars($fd['title']) ?>" loading="lazy">
            
            <div class="absolute top-2 sm:top-3 left-2 sm:left-3 flex flex-col gap-1 z-10">
              <span class="px-2 py-0.5 rounded-full bg-rose-600 text-white font-mono font-bold text-[8.5px] uppercase shadow-md">
                <?= $fd['discount_pct'] ?>% OFF
              </span>
            </div>

            <!-- Price tag on image -->
            <div class="absolute bottom-2 left-2 right-2 p-2 luxury-glass rounded-lg z-10 flex items-baseline justify-between">
              <span class="font-serif text-xs sm:text-sm font-bold text-[#dfb76c]" data-price-inr="<?= $fd['base_price'] ?>">₹<?= number_format($fd['base_price'], 0) ?></span>
              <span class="text-[9px] text-stone-400 line-through" data-price-inr="<?= $fd['compare_at_price'] ?>">₹<?= number_format($fd['compare_at_price'], 0) ?></span>
            </div>
          </div>

          <div class="p-3 sm:p-4 flex flex-col justify-between flex-1 bg-[#111218]">
            <div>
              <h3 class="font-serif text-xs sm:text-sm font-bold text-white mb-2 line-clamp-1 group-hover:text-[#dfb76c] transition-colors">
                <?= htmlspecialchars($fd['title']) ?>
              </h3>

              <!-- Scarcity Bar -->
              <div class="mb-3">
                <div class="flex items-center justify-between text-[8.5px] font-mono mb-1">
                  <span class="text-stone-400 uppercase">Stock Remaining</span>
                  <span class="text-rose-400 font-bold">Only <?= $fd['stock_left'] ?> left</span>
                </div>
                <div class="scarcity-track">
                  <div class="scarcity-fill" style="width: <?= 25 * $fd['stock_left'] ?>%"></div>
                </div>
              </div>
            </div>

            <button class="btn-luxury-primary w-full text-[9px] sm:text-[10px] py-2">
              <span>Acquire Drop</span>
            </button>
          </div>

        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       9. CHAPTER 08 · SOCIAL PROOF & CONNOISSEUR STATS
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-14 bg-[#0c0d12] border-b border-white/10 text-white relative overflow-hidden" id="statsSection">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      
      <!-- Metrics Grid -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center mb-12">
        <div class="group">
          <div class="text-3xl sm:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(223,183,108,0.4)">14,800+</div>
          <div class="text-xs font-mono uppercase tracking-widest text-[#dfb76c] mb-1 font-bold">Connoisseurs</div>
          <div class="text-[11px] text-stone-400">Worldwide Collectors</div>
          <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#dfb76c] to-transparent mx-auto mt-3"></div>
        </div>

        <div class="group">
          <div class="text-3xl sm:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(223,183,108,0.4)">4.98★</div>
          <div class="text-xs font-mono uppercase tracking-widest text-[#dfb76c] mb-1 font-bold">Avg. Rating</div>
          <div class="text-[11px] text-stone-400">Verified Client Reviews</div>
          <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#dfb76c] to-transparent mx-auto mt-3"></div>
        </div>

        <div class="group">
          <div class="text-3xl sm:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(223,183,108,0.4)">18h</div>
          <div class="text-xs font-mono uppercase tracking-widest text-[#dfb76c] mb-1 font-bold">Dispatch Speed</div>
          <div class="text-[11px] text-stone-400">Priority White-Glove Air</div>
          <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#dfb76c] to-transparent mx-auto mt-3"></div>
        </div>

        <div class="group">
          <div class="text-3xl sm:text-5xl font-serif font-bold text-white mb-1" style="text-shadow:0 0 20px rgba(223,183,108,0.4)">100%</div>
          <div class="text-xs font-mono uppercase tracking-widest text-[#dfb76c] mb-1 font-bold">Pure Materials</div>
          <div class="text-[11px] text-stone-400">Lab-Certified Provenance</div>
          <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-[#dfb76c] to-transparent mx-auto mt-3"></div>
        </div>
      </div>

    </div>

    <!-- Scrolling Trust Marquee -->
    <div class="marquee-wrapper border-t border-white/10 py-3 bg-black/40">
      <div class="marquee-track text-xs font-mono text-stone-400 uppercase tracking-wider">
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> 256-Bit AES Encrypted Checkout</span>
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> Visa, Mastercard, AMEX &amp; UPI</span>
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> 100% Certified Authentic Fibers</span>
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> Priority BlueDart Insured Express Delivery</span>
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> 14-Day Complimentary Doorstep Returns</span>
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> Cash on Delivery Available</span>
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> 256-Bit AES Encrypted Checkout</span>
        <span class="flex items-center gap-2"><span class="text-[#dfb76c]">✦</span> Visa, Mastercard, AMEX &amp; UPI</span>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       10. CHAPTER 09 · VERIFIED COLLECTOR REVIEWS
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-16 md:py-24 bg-[#090a0d] border-b border-white/10 text-white" id="reviewsSection">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center max-w-xl mx-auto mb-12">
        <span class="text-xs text-[#dfb76c] font-mono uppercase tracking-[0.25em] block mb-2 font-bold">Provenance &amp; Trust</span>
        <h2 class="font-serif text-3xl sm:text-4xl text-white">Voices from the Atelier Collective</h2>
        <p class="text-xs text-stone-400 font-light mt-1">Verified collectors on architectural tailoring, fiber longevity, and white-glove transport.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php foreach ($reviews as $rev): ?>
        <div class="luxury-card p-6 sm:p-8 flex flex-col justify-between">
          <div>
            <div class="flex items-center gap-1 text-amber-400 mb-4">
              <span>★★★★★</span>
              <span class="text-[10px] text-emerald-400 font-mono ml-2">Verified Collector</span>
            </div>
            <p class="font-serif italic text-stone-200 text-sm leading-relaxed mb-6">
              "<?= htmlspecialchars($rev['body']) ?>"
            </p>
          </div>
          <div class="flex items-center gap-3 pt-4 border-t border-white/10">
            <img src="<?= htmlspecialchars($rev['avatar']) ?>" alt="<?= htmlspecialchars($rev['name']) ?>" class="w-10 h-10 rounded-full object-cover border border-[#dfb76c]/40">
            <div>
              <span class="font-serif font-bold text-xs text-white block"><?= htmlspecialchars($rev['name']) ?></span>
              <span class="text-[10px] text-[#dfb76c] font-mono">Acquired <?= htmlspecialchars($rev['product_title'] ?? 'Atelier Piece') ?></span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       11. CHAPTER 10 · PRIVATE ACCESS INVITATION (NEWSLETTER)
  ══════════════════════════════════════════════════════════════ -->
  <section class="py-16 md:py-24 bg-[#0c0d12] border-b border-white/10 text-white relative overflow-hidden" id="newsletterSection">
    <div class="max-w-xl mx-auto px-4 text-center relative z-10">
      <span class="font-mono text-xs text-[#dfb76c] uppercase tracking-[0.25em] block mb-2 font-bold">✦ Private Access ✦</span>
      <h2 class="font-serif text-3xl sm:text-4xl text-white font-bold mb-3 tracking-tight">Request Atelier Invitation</h2>
      <p class="text-stone-400 mb-8 text-xs sm:text-sm font-light leading-relaxed max-w-md mx-auto">
        Receive private access to hand-numbered capsule releases, bespoke fittings, and runway previews.
      </p>

      <form class="flex flex-col sm:flex-row gap-2.5 max-w-md mx-auto" onsubmit="event.preventDefault(); trialToast('Your private invitation has been reserved. Welcome to Lumina.', 'gold'); this.reset();">
        <input type="email" placeholder="Enter your confidential email" required class="flex-1 bg-white/5 px-4 py-3.5 text-xs text-stone-100 border border-white/15 focus:border-[#dfb76c] rounded-xl outline-none shadow-inner font-sans">
        <button type="submit" class="btn-luxury-primary text-xs py-3.5 px-6">
          Request Invitation
        </button>
      </form>

      <div class="mt-6 flex items-center justify-center gap-6 text-[10px] font-mono text-stone-500">
        <span class="flex items-center gap-1">🔒 Confidential &amp; Encrypted</span>
        <span class="flex items-center gap-1">✦ Strict Zero Spam Guarantee</span>
      </div>
    </div>
  </section>

  <!-- ══════════════════════════════════════════════════════════════
       12. LUXURY ATELIER FOOTER
  ══════════════════════════════════════════════════════════════ -->
  <footer class="w-full bg-[#07080b] text-white pt-16 pb-24 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">
        
        <div class="md:col-span-4">
          <span class="font-serif text-2xl font-bold uppercase tracking-[0.18em] text-white block mb-3">LUMINA</span>
          <p class="text-stone-400 text-xs leading-relaxed max-w-xs font-light">
            Autonomous performance haute couture. Curated garments crafted from rare natural fibers for the considered wardrobe.
          </p>
          <div class="mt-6">
            <span class="text-[11px] font-mono text-stone-500">© 2026 LUMINA ATELIER COLLECTIVE. ALL RIGHTS RESERVED.</span>
          </div>
        </div>

        <div class="md:col-span-2 md:col-start-7">
          <h4 class="font-mono text-xs text-[#dfb76c] uppercase tracking-widest mb-4 font-bold">Explore</h4>
          <ul class="space-y-2.5 text-xs text-stone-400 font-sans">
            <li><a href="#chapter1" class="hover:text-[#dfb76c] transition-colors">Runway Lookbook</a></li>
            <li><a href="#expressCapsules" class="hover:text-[#dfb76c] transition-colors">Editorial Capsules</a></li>
            <li><a href="#aiStylistSection" class="hover:text-[#dfb76c] transition-colors">Neural AI Stylist</a></li>
            <li><a href="#vtrSection" class="hover:text-[#dfb76c] transition-colors">Virtual Fitting</a></li>
          </ul>
        </div>

        <div class="md:col-span-2">
          <h4 class="font-mono text-xs text-[#dfb76c] uppercase tracking-widest mb-4 font-bold">Concierge</h4>
          <ul class="space-y-2.5 text-xs text-stone-400 font-sans">
            <li><a href="javascript:void(0)" onclick="openVirtualTryOnModal()" class="hover:text-[#dfb76c] transition-colors">Size Calibration</a></li>
            <li><a href="javascript:void(0)" onclick="openStorefrontWheelModal()" class="hover:text-[#dfb76c] transition-colors">VIP Privilege Wheel</a></li>
            <li><a href="javascript:void(0)" onclick="openExitPopup()" class="hover:text-[#dfb76c] transition-colors">Claim Welcome 50%</a></li>
            <li><a href="index.php" class="text-stone-500 hover:text-white transition-colors">Original Version (Backup)</a></li>
          </ul>
        </div>

        <div class="md:col-span-2">
          <h4 class="font-mono text-xs text-[#dfb76c] uppercase tracking-widest mb-4 font-bold">Provenance</h4>
          <ul class="space-y-2.5 text-xs text-stone-400 font-sans">
            <li><a href="#reviewsSection" class="hover:text-[#dfb76c] transition-colors">Collector Reviews</a></li>
            <li><a href="#statsSection" class="hover:text-[#dfb76c] transition-colors">Fiber Certification</a></li>
            <li><a href="javascript:void(0)" class="hover:text-[#dfb76c] transition-colors">Zero-Waste Protocol</a></li>
          </ul>
        </div>

      </div>

      <!-- Trust Badges Strip -->
      <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs font-mono text-stone-400">
        <div class="flex items-center gap-4">
          <span>🔒 256-Bit SSL</span>
          <span>✦ 100% Authentic</span>
          <span>✈️ Priority Air</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="px-2 py-0.5 bg-white/10 rounded text-[10px]">VISA</span>
          <span class="px-2 py-0.5 bg-white/10 rounded text-[10px]">MASTERCARD</span>
          <span class="px-2 py-0.5 bg-white/10 rounded text-[10px]">AMEX</span>
          <span class="px-2 py-0.5 bg-white/10 rounded text-[10px]">UPI</span>
          <span class="px-2 py-0.5 bg-white/10 rounded text-[10px]">COD</span>
        </div>
      </div>
    </div>
  </footer>

  <!-- ══════════════════════════════════════════════════════════════
       13. MODALS & DRAWERS SYSTEM
  ══════════════════════════════════════════════════════════════ -->

  <!-- Quick Bag (Cart) Drawer -->
  <div id="quickBagOverlay" class="drawer-overlay" onclick="if(event.target===this)closeQuickBagDrawer()">
    <div id="quickBagPanel" class="drawer-panel p-6">
      
      <div class="flex items-center justify-between pb-4 border-b border-white/10">
        <div class="flex items-center gap-2">
          <span class="font-serif text-lg font-bold text-white uppercase">Curated Bag</span>
          <span class="cart-badge-count px-2 py-0.5 bg-[#dfb76c] text-stone-950 rounded-full font-mono text-[10px] font-bold">0</span>
        </div>
        <button onclick="closeQuickBagDrawer()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-stone-200 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Free Shipping Meter -->
      <div class="py-3 border-b border-white/10">
        <div class="flex items-center justify-between text-[11px] font-mono mb-1.5">
          <span id="quickBagShippingText" class="text-stone-300">Add more for Free Express Delivery</span>
        </div>
        <div class="w-full bg-white/10 rounded-full h-1.5 overflow-hidden">
          <div id="quickBagShippingBar" class="h-full bg-gradient-to-r from-[#dfb76c] to-emerald-400 rounded-full transition-all duration-500" style="width: 0%;"></div>
        </div>
      </div>

      <!-- Items List Container -->
      <div id="quickBagItemsList" class="flex-1 overflow-y-auto py-4 space-y-3 custom-scrollbar">
        <!-- Injected by JS -->
      </div>

      <!-- Promo Code Bar -->
      <div class="pt-3 pb-2 border-t border-white/10">
        <div class="flex gap-2">
          <input type="text" id="quickBagCouponInput" placeholder="VIP Code (e.g. LUMINA50)" class="flex-1 bg-white/5 border border-white/15 px-3 py-2 rounded-xl text-xs font-mono uppercase text-white outline-none focus:border-[#dfb76c]">
          <button onclick="applyQuickBagCoupon()" class="px-4 py-2 bg-[#dfb76c] text-stone-950 font-mono text-xs font-bold uppercase rounded-xl hover:opacity-90 transition-all">
            Apply
          </button>
        </div>
      </div>

      <!-- Totals & Checkout -->
      <div class="pt-3 border-t border-white/10 space-y-2">
        <div class="flex justify-between text-xs text-stone-400 font-mono">
          <span>Subtotal:</span>
          <span id="quickBagSubtotal" class="text-white font-bold">₹0</span>
        </div>
        <div id="quickBagDiscountRow" class="hidden flex justify-between text-xs text-emerald-400 font-mono font-bold">
          <span>Privilege Discount (<span id="quickBagDiscountCode"></span>):</span>
          <span id="quickBagDiscountAmount">- ₹0</span>
        </div>
        <div class="flex justify-between text-sm font-serif font-bold text-white pt-2 border-t border-white/10">
          <span>Final Total:</span>
          <span id="quickBagFinalTotal" class="text-lg text-[#dfb76c]">₹0</span>
        </div>

        <button onclick="closeQuickBagDrawer(); openExpressCheckout(1, 'Curated Ensemble', 6999, 'img/cashmere_cocoon_coat.jpg')" class="btn-luxury-primary w-full py-3 mt-2 text-xs">
          <span>Proceed to Express Checkout</span>
        </button>
      </div>

    </div>
  </div>

  <!-- Wardrobe Wishlist Drawer -->
  <div id="wishlistOverlay" class="drawer-overlay" onclick="if(event.target===this)closeWishlistDrawer()">
    <div id="wishlistPanel" class="drawer-panel p-6">
      <div class="flex items-center justify-between pb-4 border-b border-white/10">
        <div class="flex items-center gap-2">
          <span class="font-serif text-lg font-bold text-white uppercase">Wardrobe Wishlist</span>
          <span class="wishlist-badge-count px-2 py-0.5 bg-rose-600 text-white rounded-full font-mono text-[10px] font-bold">0</span>
        </div>
        <button onclick="closeWishlistDrawer()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-stone-200 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div id="wishlistItemsList" class="flex-1 overflow-y-auto py-4 space-y-3 custom-scrollbar">
        <!-- Injected by JS -->
      </div>
    </div>
  </div>

  <!-- Search Modal -->
  <div id="searchModal" class="modal-dialog" onclick="if(event.target===this)closeSearchModal()">
    <div class="modal-content-card p-6">
      <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-4">
        <span class="font-mono text-xs text-[#dfb76c] uppercase font-bold tracking-widest">Search Haute Couture Archives</span>
        <button onclick="closeSearchModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      
      <div class="relative mb-4">
        <input type="text" id="searchModalInput" oninput="handleSearchInput(this.value)" placeholder="Search Cashmere Coats, Denim, Silk Dress, Suiting…" class="w-full bg-white/5 border border-white/15 focus:border-[#dfb76c] rounded-xl px-4 py-3 text-sm text-white outline-none">
      </div>

      <div id="searchResultsContainer" class="max-h-[60vh] overflow-y-auto custom-scrollbar">
        <!-- Injected by JS -->
      </div>
    </div>
  </div>

  <!-- Product Quick View Modal -->
  <div id="atelierProductQuickViewModal" class="modal-dialog" onclick="if(event.target===this)closeProductQuickViewModal()">
    <div class="modal-content-card p-6 max-w-xl">
      <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-4">
        <span class="font-mono text-xs text-[#dfb76c] uppercase font-bold tracking-widest">Atelier Piece Inspection</span>
        <button onclick="closeProductQuickViewModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center mb-4">
        <div class="aspect-[3/4] rounded-xl overflow-hidden bg-black border border-white/10">
          <img id="apqvImage" src="" alt="Product" class="w-full h-full object-cover">
        </div>
        <div class="flex flex-col justify-between space-y-3">
          <div>
            <span class="text-[9px] font-mono uppercase tracking-widest text-[#dfb76c] font-bold block mb-1">Lumina Atelier</span>
            <h4 id="apqvTitle" class="font-serif font-bold text-lg text-white leading-snug">Product Title</h4>
            <span id="apqvPrice" class="font-serif font-bold text-xl text-[#dfb76c] mt-1 block">₹0</span>
          </div>
          <p id="apqvDesc" class="text-xs text-stone-300 font-light leading-relaxed bg-white/5 p-3 rounded-xl border border-white/10">
            Crafted with precision in generational ateliers.
          </p>
          <button onclick="if(TRIAL_STATE.currentQuickViewProduct){ addToCart(TRIAL_STATE.currentQuickViewProduct, 1); closeProductQuickViewModal(); }" class="btn-luxury-primary w-full py-2.5 text-xs">
            <span>Add to Curated Bag</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Atelier Size & Fit Concierge Modal -->
  <div id="atelierFitModal" class="modal-dialog" onclick="if(event.target===this)closeAtelierFitModal()">
    <div class="modal-content-card p-6 max-w-lg">
      <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-4">
        <span class="font-mono text-xs text-[#dfb76c] uppercase font-bold tracking-widest">Select Fit &amp; Size</span>
        <button onclick="closeAtelierFitModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div class="flex gap-4 items-center mb-6">
        <img id="afmProductImg" src="" alt="Fit Item" class="w-20 h-24 object-cover rounded-xl border border-white/10 bg-black flex-shrink-0">
        <div>
          <h4 id="afmProductTitle" class="font-serif text-base font-bold text-white mb-1">Product</h4>
          <span id="afmProductPrice" class="font-serif text-lg font-bold text-[#dfb76c]">₹0</span>
        </div>
      </div>

      <!-- Size Selector -->
      <div class="mb-6">
        <label class="text-[10px] font-mono uppercase text-stone-400 block mb-2 font-bold">Select Size:</label>
        <div class="grid grid-cols-5 gap-2">
          <button onclick="setVtrSize('XS')" class="vtr-size-btn py-2 rounded-xl bg-white/5 border border-white/15 text-stone-200 text-xs font-mono font-bold hover:border-[#dfb76c]" data-size="XS">XS</button>
          <button onclick="setVtrSize('S')" class="vtr-size-btn py-2 rounded-xl bg-white/5 border border-white/15 text-stone-200 text-xs font-mono font-bold hover:border-[#dfb76c]" data-size="S">S</button>
          <button onclick="setVtrSize('M')" class="vtr-size-btn py-2 rounded-xl bg-[#dfb76c] text-stone-950 border border-[#dfb76c] text-xs font-mono font-bold" data-size="M">M</button>
          <button onclick="setVtrSize('L')" class="vtr-size-btn py-2 rounded-xl bg-white/5 border border-white/15 text-stone-200 text-xs font-mono font-bold hover:border-[#dfb76c]" data-size="L">L</button>
          <button onclick="setVtrSize('XL')" class="vtr-size-btn py-2 rounded-xl bg-white/5 border border-white/15 text-stone-200 text-xs font-mono font-bold hover:border-[#dfb76c]" data-size="XL">XL</button>
        </div>
      </div>

      <button onclick="if(TRIAL_STATE.currentAfmProduct){ addToCart(TRIAL_STATE.currentAfmProduct, 1, {size: TRIAL_STATE.vtrSize}); closeAtelierFitModal(); }" class="btn-luxury-primary w-full py-3 text-xs">
        Confirm Acquisition
      </button>
    </div>
  </div>

  <!-- Virtual Try-On Modal -->
  <div id="vtrModal" class="modal-dialog" onclick="if(event.target===this)closeVirtualTryOnModal()">
    <div class="modal-content-card p-6 max-w-2xl">
      <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-4">
        <span class="font-mono text-xs text-[#dfb76c] uppercase font-bold tracking-widest">Virtual Fitting Room · Neural Mirror</span>
        <button onclick="closeVirtualTryOnModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center mb-6">
        <div id="vtrCameraPreviewBox" class="aspect-[3/4] rounded-2xl overflow-hidden bg-black border border-white/15 relative flex flex-col items-center justify-center p-4">
          <img src="img/model_look_executive.jpg" alt="Model Preview" class="w-full h-full object-cover rounded-xl">
          <div class="absolute bottom-3 left-3 right-3 luxury-glass p-2 rounded-xl text-center">
            <span id="vtrFitScore" class="text-[10px] font-mono text-[#dfb76c] font-bold">SIZE M · 96% FIT</span>
          </div>
        </div>

        <div class="space-y-4">
          <div>
            <label class="text-[10px] font-mono uppercase text-stone-400 block mb-2 font-bold">Body Silhouette:</label>
            <div class="grid grid-cols-2 gap-2">
              <button onclick="setVtrSilhouette('tailored')" data-silhouette="tailored" class="vtr-silhouette-btn p-2 rounded-xl border border-[#dfb76c] bg-white/10 text-[#dfb76c] text-[11px] font-mono font-bold">Tailored Cut</button>
              <button onclick="setVtrSilhouette('relaxed')" data-silhouette="relaxed" class="vtr-silhouette-btn p-2 rounded-xl border border-white/15 text-stone-300 text-[11px] font-mono hover:border-stone-400">Relaxed Fit</button>
              <button onclick="setVtrSilhouette('athletic')" data-silhouette="athletic" class="vtr-silhouette-btn p-2 rounded-xl border border-white/15 text-stone-300 text-[11px] font-mono hover:border-stone-400">Athletic</button>
              <button onclick="setVtrSilhouette('oversized')" data-silhouette="oversized" class="vtr-silhouette-btn p-2 rounded-xl border border-white/15 text-stone-300 text-[11px] font-mono hover:border-stone-400">Oversized</button>
            </div>
          </div>

          <div>
            <label class="text-[10px] font-mono uppercase text-stone-400 block mb-2 font-bold">Calibration:</label>
            <button onclick="simulateVtrCamera()" class="btn-luxury-secondary w-full text-xs py-2.5 mb-2">
              <span>📷 Capture / Calibrate</span>
            </button>
          </div>

          <div class="p-3 luxury-glass rounded-xl border border-white/10">
            <p id="vtrFitDrapeStatus" class="text-[11px] text-stone-300 font-sans leading-tight">
              Optimal silhouette alignment for tailored body structure.
            </p>
          </div>
        </div>
      </div>

      <button onclick="closeVirtualTryOnModal(); openExpressCheckout(1, 'The Atelier Cashmere Cocoon Coat', 6999, 'img/cashmere_cocoon_coat.jpg')" class="btn-luxury-primary w-full py-3 text-xs">
        Acquire Piece with Calibrated Fit
      </button>
    </div>
  </div>

  <!-- 3-Look Model Fitting Studio Modal -->
  <div id="atelierModelFittingStudioModal" class="modal-dialog" onclick="if(event.target===this)closeModelFittingStudioModal()">
    <div class="modal-content-card p-6 max-w-4xl">
      <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-4">
        <div class="flex items-center gap-2">
          <span class="font-mono text-xs text-[#dfb76c] uppercase font-bold tracking-widest">Model Fitting Studio</span>
          <span id="amfsLookCounter" class="px-2 py-0.5 bg-white/10 rounded font-mono text-[10px]">01 / 03</span>
        </div>
        <button onclick="closeModelFittingStudioModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <h3 id="amfsHeading" class="font-serif text-xl sm:text-2xl text-white mb-4">The Milan Executive</h3>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center mb-6">
        
        <!-- Left: Model Preview -->
        <div class="lg:col-span-5 relative aspect-[3/4] rounded-2xl overflow-hidden bg-black border border-white/15">
          <img id="amfsModelImage" src="img/model_look_executive.jpg" alt="Ensemble" class="w-full h-full object-cover">
          
          <!-- Arrows on image -->
          <div class="absolute inset-x-2 top-1/2 -translate-y-1/2 flex justify-between pointer-events-none">
            <button onclick="navigateStudioLook(-1)" class="w-8 h-8 rounded-full bg-black/80 text-white flex items-center justify-center pointer-events-auto hover:bg-[#dfb76c] hover:text-stone-950 transition-colors">
              ‹
            </button>
            <button onclick="navigateStudioLook(1)" class="w-8 h-8 rounded-full bg-black/80 text-white flex items-center justify-center pointer-events-auto hover:bg-[#dfb76c] hover:text-stone-950 transition-colors">
              ›
            </button>
          </div>
        </div>

        <!-- Right: 3 Layered Pieces -->
        <div class="lg:col-span-7 space-y-3">
          
          <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/10">
            <img id="amfsCoatImg" src="img/cashmere_cocoon_coat.jpg" class="w-14 h-16 object-cover rounded-lg border border-white/10">
            <div class="flex-1 min-w-0">
              <span class="text-[9px] font-mono text-[#dfb76c] uppercase block">Layer 1 · Outerwear</span>
              <h4 id="amfsCoatTitle" class="font-serif text-sm text-white truncate">The Atelier Cashmere Cocoon Coat</h4>
              <span id="amfsCoatPrice" class="font-serif text-xs font-bold text-[#dfb76c]">₹6,999</span>
            </div>
          </div>

          <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/10">
            <img id="amfsShirtImg" src="img/silk_charmeuse_blouse.jpg" class="w-14 h-16 object-cover rounded-lg border border-white/10">
            <div class="flex-1 min-w-0">
              <span class="text-[9px] font-mono text-[#dfb76c] uppercase block">Layer 2 · Inner Layer</span>
              <h4 id="amfsShirtTitle" class="font-serif text-sm text-white truncate">22-Momme Sandwashed Silk Blouse</h4>
              <span id="amfsShirtPrice" class="font-serif text-xs font-bold text-[#dfb76c]">₹3,499</span>
            </div>
          </div>

          <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl border border-white/10">
            <img id="amfsBottomImg" src="img/italian_pleated_trousers.jpg" class="w-14 h-16 object-cover rounded-lg border border-white/10">
            <div class="flex-1 min-w-0">
              <span class="text-[9px] font-mono text-[#dfb76c] uppercase block">Layer 3 · Trousers</span>
              <h4 id="amfsBottomTitle" class="font-serif text-sm text-white truncate">Italian Pleated Virgin Wool Trousers</h4>
              <span id="amfsBottomPrice" class="font-serif text-xs font-bold text-[#dfb76c]">₹4,499</span>
            </div>
          </div>

          <div class="p-4 luxury-glass rounded-xl flex items-center justify-between border border-[#dfb76c]/40">
            <div>
              <span class="text-[9px] font-mono text-stone-400 uppercase block">Complete Ensemble Total</span>
              <span id="amfsTotalEnsemblePrice" class="font-serif text-xl font-bold text-[#dfb76c]">₹14,997</span>
            </div>
            <button onclick="acquireStudioFullLook()" class="btn-luxury-primary text-xs py-2 px-5">
              Acquire Full Look
            </button>
          </div>

        </div>

      </div>
    </div>
  </div>

  <!-- Lucky Spin Wheel Modal -->
  <div id="storefrontWheelModal" class="modal-dialog" onclick="if(event.target===this)closeStorefrontWheelModal()">
    <div class="modal-content-card p-6 max-w-sm text-center">
      <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-4">
        <span class="font-mono text-xs text-[#dfb76c] uppercase font-bold tracking-widest">✦ VIP Atelier Lucky Wheel ✦</span>
        <button onclick="closeStorefrontWheelModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <h3 class="font-serif text-xl font-bold text-white mb-1">Spin to Win Privilege</h3>
      <p class="text-xs text-stone-400 mb-4">Unlock up to 50% off or complimentary express delivery!</p>

      <div id="sfWheelStage" class="relative w-[220px] h-[220px] mx-auto mb-4">
        <!-- Pin -->
        <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-0 h-0 border-l-[8px] border-r-[8px] border-t-[16px] border-l-transparent border-r-transparent border-t-[#dfb76c] z-20"></div>
        <canvas id="sfWheelCanvas" width="220" height="220" class="rounded-full shadow-2xl border-2 border-[#dfb76c]"></canvas>
        <button onclick="spinStorefrontWheel()" id="sfSpinCap" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-[#090a0d] text-[#dfb76c] font-mono font-bold text-xs border border-[#dfb76c] flex items-center justify-center shadow-2xl cursor-pointer hover:scale-105 transition-transform">
          SPIN
        </button>
      </div>

      <!-- Win Celebration Box -->
      <div id="sfWinBox" class="hidden p-4 bg-gradient-to-b from-[#1c1917] to-black border border-[#dfb76c] rounded-2xl animate-in zoom-in-95 duration-300">
        <div class="text-3xl mb-2">🏆</div>
        <h4 id="sfWinPrizeLabel" class="font-serif text-lg font-bold text-white mb-1">You Won 25% VIP Privilege!</h4>
        <div class="p-2 bg-black/80 rounded-xl border border-white/10 font-mono text-[#dfb76c] font-bold text-lg mb-3 tracking-widest" id="sfWinPromoCode">
          VIP25
        </div>
        <button onclick="closeStorefrontWheelModal(); openQuickBagDrawer();" class="btn-luxury-primary w-full text-xs py-2.5">
          Claim &amp; Shop Now
        </button>
      </div>

    </div>
  </div>

  <!-- Exit Intent / VIP Welcome Privilege Modal -->
  <div id="exitIntentOverlay" class="modal-dialog" onclick="if(event.target===this)closeExitPopup()">
    <div class="modal-content-card p-6 sm:p-8 max-w-lg">
      
      <div class="flex items-center justify-between gap-2 mb-4">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#dfb76c]/15 border border-[#dfb76c]/40 text-[#dfb76c] text-[10px] font-mono uppercase tracking-widest font-bold">
          <span class="w-1.5 h-1.5 rounded-full bg-[#dfb76c] animate-ping"></span>
          <span>✦ VIP Privilege Unlocked ✦</span>
        </div>
        <div class="flex items-center gap-1 text-[11px] font-mono text-stone-300 bg-white/5 border border-white/10 px-2.5 py-1 rounded-full">
          <span>⏳</span>
          <span id="exitCountdown" class="font-bold text-amber-300">09:59</span>
        </div>
      </div>

      <h2 class="text-2xl sm:text-3xl font-serif text-white mb-2 leading-tight font-bold">
        Unlock 50% Off <span class="italic text-[#dfb76c] font-normal">Your First Piece.</span>
      </h2>
      <p class="text-xs sm:text-sm text-stone-300 mb-5 leading-relaxed font-light">
        Welcome to the private atelier. Claim your exclusive welcome privilege and enjoy complimentary white-glove express delivery.
      </p>

      <!-- Primary Coupon Box -->
      <div class="p-3.5 bg-[#dfb76c]/15 border border-[#dfb76c]/60 rounded-2xl flex items-center justify-between gap-3 mb-4">
        <div>
          <span class="text-[9px] font-mono uppercase tracking-wider text-amber-300 block font-bold">VIP Promo Code:</span>
          <span class="text-[#dfb76c] font-mono font-bold text-xl tracking-widest">LUMINA50</span>
        </div>
        <button onclick="claimOfferCoupon('LUMINA50', 50, 'percent')" class="btn-luxury-primary text-xs py-2 px-4 flex-shrink-0">
          Claim 50%
        </button>
      </div>

      <div class="grid grid-cols-2 gap-2 mb-4">
        <div onclick="claimOfferCoupon('FREESHIP', 0, 'shipping')" class="p-2.5 bg-white/5 border border-white/10 rounded-xl flex items-center justify-between cursor-pointer hover:border-[#dfb76c] transition-colors">
          <div>
            <span class="text-[9px] font-mono text-stone-500 uppercase block">Code: FREESHIP</span>
            <span class="text-xs font-bold text-white">Free Express Delivery</span>
          </div>
          <span class="text-[10px] font-mono text-[#dfb76c]">Claim →</span>
        </div>
        <div onclick="claimOfferCoupon('STAY500', 500, 'flat')" class="p-2.5 bg-white/5 border border-white/10 rounded-xl flex items-center justify-between cursor-pointer hover:border-[#dfb76c] transition-colors">
          <div>
            <span class="text-[9px] font-mono text-stone-500 uppercase block">Code: STAY500</span>
            <span class="text-xs font-bold text-white">₹500 Off</span>
          </div>
          <span class="text-[10px] font-mono text-[#dfb76c]">Claim →</span>
        </div>
      </div>

    </div>
  </div>

  <!-- 1-Click Express Checkout Modal -->
  <div id="expressCheckoutModal" class="modal-dialog" onclick="if(event.target===this)closeExpressCheckout()">
    <div class="modal-content-card p-6 max-w-md">
      <div class="flex items-center justify-between pb-3 border-b border-white/10 mb-4">
        <span class="font-mono text-xs text-[#dfb76c] uppercase font-bold tracking-widest">⚡ 1-Click Express Acquisition</span>
        <button onclick="closeExpressCheckout()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-stone-300 flex items-center justify-center transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div class="flex gap-3.5 p-3 bg-white/5 rounded-xl border border-white/10 mb-4 items-center">
        <img id="ecProductImg" src="img/cashmere_cocoon_coat.jpg" class="w-14 h-16 object-cover rounded-lg border border-white/10 bg-black">
        <div class="flex-1 min-w-0">
          <h4 id="ecProductTitle" class="font-serif text-xs sm:text-sm font-bold text-white truncate">Product Title</h4>
          <span id="ecProductPrice" class="font-serif text-sm font-bold text-[#dfb76c]">₹0</span>
        </div>
      </div>

      <form id="expressCheckoutForm" onsubmit="processExpressCheckout(event)" class="space-y-3">
        <div>
          <label class="text-[10px] font-mono uppercase text-stone-400 block mb-1">Full Delivery Name:</label>
          <input type="text" name="customer_name" required placeholder="e.g. Alistair Sterling" class="w-full bg-white/5 border border-white/15 focus:border-[#dfb76c] rounded-xl px-3 py-2 text-xs text-white outline-none">
        </div>
        <div>
          <label class="text-[10px] font-mono uppercase text-stone-400 block mb-1">Phone Number (Order Updates):</label>
          <input type="tel" name="customer_phone" required placeholder="e.g. +91 98765 43210" class="w-full bg-white/5 border border-white/15 focus:border-[#dfb76c] rounded-xl px-3 py-2 text-xs text-white outline-none">
        </div>
        <div>
          <label class="text-[10px] font-mono uppercase text-stone-400 block mb-1">Delivery Address &amp; Pincode:</label>
          <textarea name="customer_address" required rows="2" placeholder="Street, Suite / Villa, City, Pincode" class="w-full bg-white/5 border border-white/15 focus:border-[#dfb76c] rounded-xl px-3 py-2 text-xs text-white outline-none"></textarea>
        </div>

        <div class="pt-2 border-t border-white/10 flex justify-between items-center text-sm font-serif font-bold text-white mb-2">
          <span>Payable Amount:</span>
          <span id="ecFinalTotal" class="text-[#dfb76c] text-base">₹0</span>
        </div>

        <button type="submit" id="ecSubmitBtn" class="btn-luxury-primary w-full py-3 text-xs">
          Complete Order (Cash on Delivery / UPI)
        </button>
      </form>

    </div>
  </div>

  <!-- Mobile Navigation Overlay & Drawer -->
  <div id="mobileNavOverlay" class="drawer-overlay" onclick="if(event.target===this)closeMobileNav()">
    <div id="mobileNavPanel" class="drawer-panel p-6 max-w-xs">
      <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-6">
        <span class="font-serif text-xl font-bold text-white uppercase tracking-widest">LUMINA</span>
        <button onclick="closeMobileNav()" class="w-8 h-8 rounded-full bg-white/10 text-stone-200 flex items-center justify-center">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <nav class="space-y-4 font-mono text-sm uppercase tracking-wider text-stone-300">
        <a href="#chapter1" onclick="closeMobileNav()" class="block py-2 border-b border-white/5 hover:text-[#dfb76c]">Lookbook</a>
        <a href="#expressCapsules" onclick="closeMobileNav()" class="block py-2 border-b border-white/5 hover:text-[#dfb76c]">Collections</a>
        <a href="#aiStylistSection" onclick="closeMobileNav()" class="block py-2 border-b border-white/5 text-[#dfb76c]">AI Stylist</a>
        <a href="#vtrSection" onclick="closeMobileNav()" class="block py-2 border-b border-white/5 hover:text-[#dfb76c]">Virtual Fitting</a>
        <a href="#reviewsSection" onclick="closeMobileNav()" class="block py-2 border-b border-white/5 hover:text-[#dfb76c]">Provenance</a>
      </nav>

      <div class="mt-8 pt-6 border-t border-white/10 space-y-3">
        <button onclick="openStorefrontWheelModal(); closeMobileNav();" class="btn-luxury-secondary w-full text-xs py-2">
          🎡 Lucky Spin Wheel
        </button>
        <button onclick="openExitPopup(); closeMobileNav();" class="btn-luxury-outline w-full text-xs py-2">
          Claim 50% VIP Code
        </button>
      </div>
    </div>
  </div>

  <!-- Sticky Mobile Action Bar (appears upon scroll) -->
  <div id="stickyMobileBar" class="sticky-mobile-bar">
    <div class="flex items-center gap-3">
      <img src="img/cashmere_cocoon_coat.jpg" alt="Featured" class="w-10 h-10 object-cover rounded-lg border border-white/15">
      <div>
        <span class="font-serif text-xs font-bold text-white block line-clamp-1">Cashmere Cocoon Coat</span>
        <span class="font-serif text-xs font-bold text-[#dfb76c]" data-price-inr="6999">₹6,999</span>
      </div>
    </div>
    <button onclick="openExpressCheckout(1, 'The Atelier Cashmere Cocoon Coat', 6999, 'img/cashmere_cocoon_coat.jpg')" class="btn-luxury-primary text-[10px] py-2 px-5 font-extrabold shadow-lg">
      Acquire Now
    </button>
  </div>

  <!-- Global Floating WhatsApp Live Concierge -->
  <a href="https://wa.me/919999999999?text=Hi%20Lumina%20Atelier,%20I%20need%20styling%20advice" target="_blank" rel="noopener" class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full flex items-center justify-center shadow-2xl hover:scale-110 active:scale-95 transition-transform bg-gradient-to-tr from-emerald-600 to-teal-500 text-white cursor-pointer" title="Chat on WhatsApp">
    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
  </a>

  <!-- Dedicated Trial Interactive Engine -->
  <script src="js/trial.js"></script>
</body>
</html>
