<!DOCTYPE html>
<html class="scroll-smooth light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= htmlspecialchars($title ?? 'NovaDrop - Autonomous Performance Commerce OS') ?></title>
<meta name="description" content="<?= htmlspecialchars($meta_description ?? 'NovaDrop — Curated ergonomic tools and performance essentials. Designed with intention, crafted to last.') ?>">
<meta property="og:title" content="<?= htmlspecialchars($title ?? 'NovaDrop') ?>">
<meta property="og:description" content="<?= htmlspecialchars($meta_description ?? 'Curated garments and architectural objects. Designed with intention, crafted to last.') ?>">
<?php if (!empty($og_image)): ?>
<meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
<?php endif; ?>
<meta name="twitter:card" content="summary_large_image">
<link rel="manifest" href="<?= base_url('manifest.json') ?>">
<meta name="theme-color" content="#1A1815">
<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('<?= base_url('sw.js') ?>').catch(() => {});
  });
}
</script>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                "colors": {
                    "nd-bg": "#FAF8F5",
                    "nd-surface": "#FFFFFF",
                    "nd-ink": "#1A1815",
                    "nd-ink-muted": "#6B6560",
                    "nd-border": "#E8E3DC",
                    "nd-accent": "#92400e",
                    "nd-accent-hover": "#78350f",
                    "surface": "#FFFFFF",
                    "background": "#FAF8F5",
                    "primary": "#1A1815",
                    "on-primary": "#FFFFFF",
                    "secondary": "#44403C",
                    "on-secondary": "#FFFFFF",
                    "accent": "#92400e",
                    "accent-light": "#d97706",
                    "surface-container": "#F5F3F0",
                    "surface-container-low": "#FAF8F5",
                    "surface-container-high": "#ECEAE6",
                    "outline-variant": "#E8E3DC",
                    "on-surface": "#1A1815",
                    "on-surface-variant": "#6B6560",
                    "error": "#DC2626"
                },
                "borderRadius": {
                    "DEFAULT": "4px",
                    "sm": "4px",
                    "md": "6px",
                    "lg": "8px",
                    "xl": "10px",
                    "full": "9999px"
                },
                "spacing": {
                    "stack-md": "48px",
                    "stack-sm": "24px",
                    "stack-lg": "80px",
                    "margin-desktop": "64px",
                    "container-max": "1440px",
                    "gutter": "32px",
                    "margin-mobile": "16px"
                },
                "fontFamily": {
                    "serif": ["Playfair Display", "Cormorant Garamond", "serif"],
                    "display": ["Playfair Display", "serif"],
                    "subheading": ["Cormorant Garamond", "serif"],
                    "sans": ["Inter", "-apple-system", "sans-serif"],
                    "body-md": ["Inter", "sans-serif"],
                    "body-lg": ["Inter", "sans-serif"],
                    "button": ["Inter", "sans-serif"],
                    "headline-sm": ["Cormorant Garamond", "Playfair Display", "serif"],
                    "display-lg": ["Playfair Display", "serif"],
                    "headline-md": ["Playfair Display", "Cormorant Garamond", "serif"]
                }
            }
        }
    }
</script>
<style>
    :root {
        --nd-bg: #FAF8F5;
        --nd-surface: #FFFFFF;
        --nd-ink: #1A1815;
        --nd-ink-muted: #6B6560;
        --nd-border: #E8E3DC;
        --nd-accent: #92400e;
        --nd-accent-hover: #78350f;
        --nd-text-xs: 12px;
        --nd-text-sm: 14px;
        --nd-text-base: 16px;
        --nd-text-lg: 20px;
        --nd-text-xl: 28px;
        --nd-text-2xl: 40px;
        --nd-text-display: 56px;
        --nd-radius-sm: 4px;
        --nd-radius-md: 6px;
        --nd-radius-lg: 8px;
    }
    body {
        background-color: var(--nd-bg);
        color: var(--nd-ink);
        font-family: 'Inter', -apple-system, sans-serif;
    }
    h1, h2, h3, .font-serif {
        font-family: 'Playfair Display', 'Cormorant Garamond', Georgia, serif;
    }

    /* UI/UX Pro Max — Liquid Glass Design System & Realistic Iconography */
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 350, 'GRAD' 0, 'opsz' 24;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        vertical-align: middle;
        line-height: 1;
        user-select: none;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }
    .icon-gold-glow {
        color: #e9c176;
        filter: drop-shadow(0 0 8px rgba(233, 193, 118, 0.45));
    }
    .icon-metallic-badge {
        background: linear-gradient(135deg, rgba(233, 193, 118, 0.25), rgba(161, 98, 7, 0.1));
        border: 1px solid rgba(233, 193, 118, 0.35);
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.2), 0 2px 6px rgba(0, 0, 0, 0.15);
    }
    .liquid-glass {
        background: rgba(250, 250, 249, 0.88);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(214, 211, 209, 0.6);
    }
    .liquid-glass-dark {
        background: rgba(20, 19, 24, 0.88);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(233, 193, 118, 0.2);
    }
    .ambient-elevation {
        box-shadow: 0 20px 40px -15px rgba(28, 25, 23, 0.07);
    }
    .ambient-elevation-hover {
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .ambient-elevation-hover:hover {
        box-shadow: 0 30px 60px -20px rgba(28, 25, 23, 0.14);
        transform: translateY(-4px);
    }
    .input-line {
        border: none;
        border-bottom: 1px solid #D6D3D1;
        border-radius: 0;
        padding: 12px 0;
        background: transparent;
        transition: border-color 0.25s ease;
    }
    .input-line:focus {
        outline: none;
        box-shadow: none;
        border-bottom-color: #A16207;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.04); border-radius: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #d6d3d1; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.3); }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #a16207; }
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #d6d3d1 rgba(0, 0, 0, 0.04);
    }

    /* ── 3D Spatial & Kinetic Animation Keyframes ── */
    @keyframes float3D {
        0%, 100% { transform: translateY(0) rotateX(0) rotateY(0); }
        50% { transform: translateY(-8px) rotateX(2deg) rotateY(-2deg); }
    }
    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 15px rgba(233, 193, 118, 0.25), 0 0 30px rgba(233, 193, 118, 0.1); }
        50% { box-shadow: 0 0 30px rgba(233, 193, 118, 0.6), 0 0 50px rgba(233, 193, 118, 0.3); }
    }
    @keyframes rotateRing {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes radarWave {
        0% { transform: scale(0.8); opacity: 0.9; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    .animate-float-3d {
        animation: float3D 6s ease-in-out infinite;
    }
    .animate-pulse-glow {
        animation: pulseGlow 3s ease-in-out infinite;
    }
    .animate-rotate-slow {
        animation: rotateRing 20s linear infinite;
    }
    .preserve-3d {
        transform-style: preserve-3d;
    }
    .perspective-1000 {
        perspective: 1000px;
    }
    .perspective-600 {
        perspective: 600px;
    }
    .backface-hidden {
        backface-visibility: hidden;
    }

    /* ── 🛒 60FPS Ultra-Smooth Add to Cart Animation Suite ── */
    @keyframes cartBadgeBounce {
        0% { transform: scale(1); }
        22% { transform: scale(1.55) rotate(-8deg); }
        45% { transform: scale(0.88) rotate(4deg); }
        70% { transform: scale(1.18) rotate(-2deg); }
        100% { transform: scale(1) rotate(0deg); }
    }
    .animate-cart-bounce {
        animation: cartBadgeBounce 0.55s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards !important;
        transform-origin: center center;
    }

    @keyframes cartShockwave {
        0% {
            transform: translate(-50%, -50%) scale(0.4);
            opacity: 1;
            box-shadow: 0 0 0 2px rgba(233, 193, 118, 0.9), 0 0 15px rgba(233, 193, 118, 0.6);
        }
        60% {
            opacity: 0.8;
            box-shadow: 0 0 0 4px rgba(233, 193, 118, 0.6), 0 0 25px rgba(233, 193, 118, 0.4);
        }
        100% {
            transform: translate(-50%, -50%) scale(3.2);
            opacity: 0;
            box-shadow: 0 0 0 1px rgba(233, 193, 118, 0), 0 0 35px rgba(233, 193, 118, 0);
        }
    }
    .cart-shockwave-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        pointer-events: none;
        z-index: 100;
        animation: cartShockwave 0.65s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .flying-cart-item {
        position: fixed;
        z-index: 999999;
        pointer-events: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 45px rgba(161, 98, 7, 0.45), 0 0 0 2px rgba(233, 193, 118, 0.9);
        background: #18181b;
        will-change: transform, opacity;
        transform-origin: center center;
        display: flex;
        align-items: center;
        justify-content: center;
        contain: layout style paint;
    }
    .flying-cart-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    @keyframes stardustFade {
        0% { transform: scale(1.4); opacity: 1; filter: blur(0px); }
        100% { transform: scale(0.1) translateY(10px); opacity: 0; filter: blur(2px); }
    }
    .cart-stardust-particle {
        position: fixed;
        z-index: 999998;
        pointer-events: none;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: radial-gradient(circle, #fff 10%, #fef08a 40%, #e9c176 80%, transparent 100%);
        box-shadow: 0 0 10px rgba(233, 193, 118, 0.9), 0 0 20px rgba(233, 193, 118, 0.5);
        animation: stardustFade 0.55s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    /* Button tactile micro-interaction */
    .btn-cart-feedback {
        position: relative !important;
        overflow: hidden !important;
        transform: scale(0.96) !important;
        transition: transform 0.18s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.18s ease !important;
        box-shadow: 0 0 20px rgba(233, 193, 118, 0.45) !important;
    }
    .btn-cart-feedback::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transform: translateX(-100%);
        animation: btnCartShimmer 0.45s ease-out forwards;
        pointer-events: none;
    }
    @keyframes btnCartShimmer {
        100% { transform: translateX(100%); }
    }

    /* ── Quick Bag Item Real-Time Animations ── */
    @keyframes quickBagItemEnter {
        0% {
            opacity: 0;
            transform: translateY(12px) scale(0.96);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .quick-bag-item-card {
        animation: quickBagItemEnter 0.32s cubic-bezier(0.16, 1, 0.3, 1) both;
        transition: transform 0.32s cubic-bezier(0.2, 0.8, 0.2, 1),
                    opacity 0.32s cubic-bezier(0.2, 0.8, 0.2, 1),
                    max-height 0.35s cubic-bezier(0.2, 0.8, 0.2, 1),
                    margin 0.32s ease,
                    padding 0.32s ease,
                    border 0.32s ease !important;
        will-change: transform, opacity, max-height;
        flex-shrink: 0 !important;
        width: 100% !important;
    }
    .quick-bag-item-removing {
        transform: translateX(50px) scale(0.9) !important;
        opacity: 0 !important;
        max-height: 0px !important;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;
        border-width: 0px !important;
        pointer-events: none !important;
    }

    /* ── Seamless Responsive, Native Mobile App Feel & Translate Integration ── */
    html, body {
        overflow-x: hidden !important;
        max-width: 100vw !important;
        width: 100% !important;
        -webkit-tap-highlight-color: transparent;
    }
    @media (max-width: 767px) {
        body {
            padding-bottom: calc(76px + env(safe-area-inset-bottom, 0px)) !important;
            -webkit-overflow-scrolling: touch;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        *, ::before, ::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
    :focus-visible {
        outline: 2px solid var(--nd-accent, #92400e) !important;
        outline-offset: 2px !important;
    }
    /* ════════════════════════════════════════════════════════════
       UIVERSE ANIMATED HEART LIKE COMPONENT (BY CATRACO)
    ════════════════════════════════════════════════════════════ */
    .heart-container {
      --heart-color: rgb(244, 63, 94);
      position: relative;
      width: 32px;
      height: 32px;
      transition: .3s;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      user-select: none;
      cursor: pointer;
    }

    .heart-container .checkbox {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0;
      z-index: 20;
      cursor: pointer;
      margin: 0;
      inset: 0;
    }

    .heart-container .svg-container {
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      pointer-events: none;
    }

    .heart-container .svg-outline,
    .heart-container .svg-filled {
      fill: var(--heart-color);
      position: absolute;
      width: 17px;
      height: 17px;
      transition: transform .2s ease;
    }

    .heart-container .svg-filled {
      animation: keyframes-svg-filled .6s ease-out;
      display: none;
    }

    .heart-container .svg-celebrate {
      position: absolute;
      animation: keyframes-svg-celebrate .5s;
      animation-fill-mode: forwards;
      display: none;
      stroke: var(--heart-color);
      fill: var(--heart-color);
      stroke-width: 2px;
      pointer-events: none;
      width: 40px;
      height: 40px;
    }

    .heart-container.is-saved .svg-container .svg-filled,
    .heart-container .checkbox:checked ~ .svg-container .svg-filled {
      display: block;
    }

    .heart-container.is-saved .svg-container .svg-outline,
    .heart-container .checkbox:checked ~ .svg-container .svg-outline {
      display: none;
    }

    .heart-container.is-saved .svg-container .svg-celebrate,
    .heart-container .checkbox:checked ~ .svg-container .svg-celebrate {
      display: block;
    }

    .heart-container:hover .svg-outline {
      transform: scale(1.18);
    }

    @keyframes keyframes-svg-filled {
      0% {
        transform: scale(0);
      }
      30% {
        transform: scale(1.35);
      }
      60% {
        transform: scale(0.9);
      }
      100% {
        transform: scale(1);
        filter: brightness(1.2);
      }
    }

    @keyframes keyframes-svg-celebrate {
      0% {
        transform: scale(0);
      }
      50% {
        opacity: 1;
        filter: brightness(1.3);
      }
      100% {
        transform: scale(1.4);
        opacity: 0;
        display: none;
      }
    }

    /* ─── Uiverse Animated Tooltip & Sliding Action Buttons ─── */
    .uiverse-action-btn {
      --height: 32px;
      --tooltip-height: 26px;
      --tooltip-width: 100px;
      --gap-tooltip: 10px;
      position: relative;
      width: 100%;
      height: var(--height);
      border-radius: 0.65rem;
      font-family: inherit;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      overflow: visible;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
    }

    @media (min-width: 640px) {
      .uiverse-action-btn {
        --height: 36px;
        --tooltip-height: 28px;
        --tooltip-width: 110px;
        --gap-tooltip: 12px;
      }
    }

    /* Tooltip Bubble */
    .uiverse-action-btn::before {
      position: absolute;
      content: attr(data-tooltip);
      width: var(--tooltip-width);
      height: var(--tooltip-height);
      background-color: #18181b;
      border: 1px solid rgba(233, 193, 118, 0.45);
      font-size: 0.68rem;
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
      font-weight: 700;
      color: #e9c176;
      border-radius: 0.5rem;
      line-height: var(--tooltip-height);
      text-align: center;
      bottom: calc(var(--height) + var(--gap-tooltip) + 6px);
      left: 50%;
      transform: translateX(-50%);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 4px 10px -2px rgba(0, 0, 0, 0.3);
      pointer-events: none;
      z-index: 60;
      white-space: nowrap;
      letter-spacing: 0.04em;
    }

    /* Tooltip Arrow */
    .uiverse-action-btn::after {
      position: absolute;
      content: '';
      width: 0;
      height: 0;
      border: 5px solid transparent;
      border-top-color: #18181b;
      left: 50%;
      transform: translateX(-50%);
      bottom: calc(var(--height) + var(--gap-tooltip) - 4px);
      pointer-events: none;
      z-index: 60;
    }

    .uiverse-action-btn::after,
    .uiverse-action-btn::before {
      opacity: 0;
      visibility: hidden;
      transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .uiverse-btn-wrapper {
      overflow: hidden;
      position: absolute;
      inset: 0;
      border-radius: inherit;
      width: 100%;
      height: 100%;
    }

    .uiverse-btn-text,
    .uiverse-btn-icon {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.35rem;
      transition: top 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    }

    @media (min-width: 640px) {
      .uiverse-btn-text,
      .uiverse-btn-icon {
        font-size: 0.72rem;
      }
    }

    .uiverse-btn-text {
      top: 0;
    }

    .uiverse-btn-icon {
      top: 100%;
    }

    .uiverse-btn-icon svg {
      width: 14px;
      height: 14px;
    }

    /* Hover State Transitions */
    .uiverse-action-btn:hover .uiverse-btn-text {
      top: -100%;
    }

    .uiverse-action-btn:hover .uiverse-btn-icon {
      top: 0;
    }

    .uiverse-action-btn:hover::before,
    .uiverse-action-btn:hover::after {
      opacity: 1;
      visibility: visible;
    }

    .uiverse-action-btn:hover::before {
      bottom: calc(var(--height) + var(--gap-tooltip));
    }

    .uiverse-action-btn:hover::after {
      bottom: calc(var(--height) + var(--gap-tooltip) - 10px);
    }

    /* Specific Variant 1: Acquire Button */
    .uiverse-acquire-btn {
      background-color: #fafaf9;
      border: 1px solid #e7e5e4;
      color: #1c1917;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .uiverse-acquire-btn:hover {
      background-color: #f5f5f4;
      border-color: #a16207;
      color: #1c1917;
    }

    .uiverse-acquire-btn .uiverse-btn-text {
      color: #1c1917;
    }

    .uiverse-acquire-btn .uiverse-btn-icon {
      color: #a16207;
    }

    /* Specific Variant 2: Buy Button */
    .uiverse-buy-btn {
      background-color: #0c0a09;
      border: 1px solid #1c1917;
      color: #ffffff;
      box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.25);
    }

    .uiverse-buy-btn:hover {
      background-color: #18181b;
      border-color: #e9c176;
    }

    .uiverse-buy-btn .uiverse-btn-text {
      color: #ffffff;
    }

    .uiverse-buy-btn .uiverse-btn-icon {
      color: #e9c176;
    }
</style>
</head>
<body class="bg-background text-on-surface antialiased font-body-md min-h-screen flex flex-col selection:bg-accent-light selection:text-primary overflow-x-hidden w-full max-w-full">

<?php $current_uri = function_exists('uri_string') ? uri_string() : (isset($this->uri) ? $this->uri->uri_string() : ''); ?>

<?php
  $hs = $home_settings ?? [];
  $ann_enabled  = (int)($hs['announcement_enabled'] ?? 1);
  $ann_text     = htmlspecialchars($hs['announcement_text'] ?? 'Complimentary White-Glove Express Dispatch on All Pieces · Apply VIP Code: LUMINA50');
  $ann_bg       = htmlspecialchars($hs['announcement_bg_color'] ?? '#18181b');
  $ann_color    = htmlspecialchars($hs['announcement_text_color'] ?? '#e9c176');
  $ann_link     = htmlspecialchars($hs['announcement_link'] ?? '');
  // Extract VIP code if present in text (pattern: "Code: XXXX")
  preg_match('/Code:\s*([A-Z0-9]+)/i', $ann_text, $m);
  $vip_code = $m[1] ?? 'LUMINA50';
  // Split text around vip code for display
  $ann_prefix = $vip_code ? trim(preg_replace('/·?\s*Apply VIP Code:\s*'.$vip_code.'/i', '', $ann_text)) : $ann_text;
?>
<!-- ── VIP Top Privilege Announcement Bar (Haute Couture Ribbon) ── -->
<?php if ($ann_enabled): ?>
<div class="fixed top-0 left-0 right-0 z-50 h-[32px] sm:h-[36px] border-b border-[#e9c176]/30 text-white text-[10px] sm:text-xs px-3 sm:px-4 flex items-center justify-between shadow-sm select-none font-sans overflow-hidden" style="background: #0a0b0e;">
  <div class="max-w-7xl mx-auto w-full flex items-center justify-between gap-2 px-1 sm:px-4">
    <div class="flex items-center gap-1.5 sm:gap-2 overflow-hidden truncate">
      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gradient-to-r from-amber-400 to-[#e9c176] text-black font-extrabold text-[8.5px] sm:text-[9px] uppercase tracking-wider shadow-sm flex-shrink-0 leading-tight">
        ✦ VIP ATELIER
      </span>
      <?php if ($ann_link): ?>
        <a href="<?= $ann_link ?>" class="text-white/90 truncate hidden sm:inline hover:underline text-[11px] font-medium"><?= $ann_prefix ?></a>
      <?php else: ?>
        <span class="text-white/90 truncate hidden sm:inline text-[11px] font-light"><?= $ann_prefix . ($vip_code ? ' · Code:' : '') ?></span>
      <?php endif; ?>
      <?php if ($vip_code): ?>
      <button type="button" onclick="navigator.clipboard.writeText('<?= $vip_code ?>'); ndToast('VIP Code <?= $vip_code ?> Copied!', 'success');" class="px-2 py-0.5 bg-[#e9c176]/20 border border-[#e9c176]/60 text-[#e9c176] rounded-md hover:bg-[#e9c176] hover:text-black transition-all cursor-pointer font-bold tracking-widest flex items-center gap-1 text-[9px] sm:text-[10px] leading-tight">
        <span><?= $vip_code ?></span>
        <span class="material-symbols-outlined text-[10px] sm:text-[11px]">content_copy</span>
      </button>
      <?php endif; ?>
    </div>
    <div class="flex items-center gap-3 text-[10px] sm:text-[11px] text-white/70 flex-shrink-0">
      <span class="hidden md:flex items-center gap-1.5 text-emerald-400 font-mono text-[10px]">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
        <span>BlueDart Priority Express Active</span>
      </span>
      <span class="text-white/30 hidden sm:inline">|</span>
      <span class="text-white/70 hidden sm:inline text-[11px]">7-Day Doorstep Exchanges</span>
    </div>
  </div>
</div>
<?php endif; ?>


<!-- ── Main Top Navigation Bar (Offset for Top Bar) ── -->
<header class="fixed <?= $ann_enabled ? 'top-[32px] sm:top-[36px]' : 'top-0' ?> left-0 right-0 w-full z-40 bg-white/95 backdrop-blur-2xl border-b border-stone-200/90 text-stone-900 transition-all duration-300 shadow-sm" id="main-header">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 sm:h-20">
    
    <!-- Left Column: Mobile Menu & Primary Desktop Navigation -->
    <div class="flex-1 flex items-center justify-start gap-4 lg:gap-8">
      <!-- Mobile Hamburger Toggle -->
      <button type="button" class="md:hidden w-10 h-10 rounded-full flex items-center justify-center text-stone-900 hover:bg-stone-100 active:scale-95 transition-all cursor-pointer" onclick="toggleMobileNav()" aria-label="Toggle Mobile Menu">
        <span class="material-symbols-outlined text-2xl">menu</span>
      </button>

      <!-- Primary Desktop Links -->
      <nav class="hidden md:flex items-center gap-6 lg:gap-8 whitespace-nowrap" aria-label="Main Navigation">
        <a class="font-label-caps text-xs uppercase tracking-[0.18em] transition-all duration-200 cursor-pointer <?= ($current_uri === '' || $current_uri === 'lookbook') ? 'text-[#a16207] border-b-2 border-[#a16207] pb-1 font-bold' : 'text-stone-700 hover:text-[#a16207] font-medium' ?>" href="<?= base_url() ?>">Lookbook</a>
        <a class="font-label-caps text-xs uppercase tracking-[0.18em] transition-all duration-200 cursor-pointer <?= (strpos($current_uri, 'collections') !== false) ? 'text-[#a16207] border-b-2 border-[#a16207] pb-1 font-bold' : 'text-stone-700 hover:text-[#a16207] font-medium' ?>" href="<?= base_url('collections') ?>">Collections</a>
        <a class="font-label-caps text-xs uppercase tracking-[0.18em] transition-all duration-200 cursor-pointer <?= (strpos($current_uri, 'shop') !== false || strpos($current_uri, 'boutique') !== false) ? 'text-[#a16207] border-b-2 border-[#a16207] pb-1 font-bold' : 'text-stone-700 hover:text-[#a16207] font-medium' ?>" href="<?= base_url('shop') ?>">Boutique</a>
      </nav>
    </div>

    <!-- Center Column: Haute Couture Brand Logo -->
    <div class="flex-shrink-0 flex items-center justify-center px-4">
      <?php $_h_brand = htmlspecialchars($hs['brand_name'] ?? 'NovaDrop'); ?>
      <a class="font-serif text-2xl sm:text-3xl md:text-[28px] tracking-[0.26em] text-stone-950 hover:opacity-85 transition-opacity font-light uppercase select-none" href="<?= base_url() ?>">
        <?= $_h_brand ?><span class="text-[#a16207] font-bold">.</span>
      </a>
    </div>

    <!-- Right Column: Utility Selectors & Action Icons -->
    <div class="flex-1 flex items-center justify-end gap-1.5 sm:gap-2.5 md:gap-3 text-stone-800">

      <!-- ── Language Switcher Dropdown ── -->
      <div class="relative hidden lg:block" id="languageDropdownWrapper">
        <button type="button" onclick="toggleLanguageMenu()" id="currentLanguageBtn" class="flex items-center gap-1 px-2.5 py-1.5 rounded-full border border-stone-300 hover:border-[#a16207] text-xs font-mono text-stone-800 hover:bg-stone-100 transition-all cursor-pointer" aria-label="Select Language">
          <span class="material-symbols-outlined text-[15px] text-[#a16207]">translate</span>
          <span id="headerLanguageCode" class="font-bold">EN</span>
          <span class="material-symbols-outlined text-[13px] text-stone-500">expand_more</span>
        </button>

        <div id="languageDropdownMenu" class="absolute right-0 top-full mt-2 w-44 liquid-glass bg-surface shadow-2xl rounded-DEFAULT border border-outline-variant/60 p-2 hidden flex-col gap-1 z-50 animate-in fade-in slide-in-from-top-2 duration-200">
          <div class="text-[10px] font-label-caps uppercase tracking-wider text-on-surface-variant px-2 py-1 border-b border-outline-variant/30">
            Select Language
          </div>
          <button type="button" onclick="selectStoreLanguage('en', 'English')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇺🇸 English</span>
            <span class="font-mono text-[10px] text-accent">EN</span>
          </button>
          <button type="button" onclick="selectStoreLanguage('hi', 'हिन्दी')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇮🇳 हिन्दी · Hindi</span>
            <span class="font-mono text-[10px] text-accent">HI</span>
          </button>
          <button type="button" onclick="selectStoreLanguage('es', 'Español')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇪🇸 Español</span>
            <span class="font-mono text-[10px] text-accent">ES</span>
          </button>
          <button type="button" onclick="selectStoreLanguage('fr', 'Français')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇫🇷 Français</span>
            <span class="font-mono text-[10px] text-accent">FR</span>
          </button>
          <button type="button" onclick="selectStoreLanguage('de', 'Deutsch')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇩🇪 Deutsch</span>
            <span class="font-mono text-[10px] text-accent">DE</span>
          </button>
          <button type="button" onclick="selectStoreLanguage('ar', 'العربية')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇦🇪 العربية</span>
            <span class="font-mono text-[10px] text-accent">AR</span>
          </button>
          <button type="button" onclick="selectStoreLanguage('ja', '日本語')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇯🇵 日本語</span>
            <span class="font-mono text-[10px] text-accent">JA</span>
          </button>
          <button type="button" onclick="selectStoreLanguage('zh-CN', '中文')" class="lang-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium">
            <span>🇨🇳 中文</span>
            <span class="font-mono text-[10px] text-accent">ZH</span>
          </button>
        </div>
      </div>

      <!-- Currency Switcher Dropdown -->
      <div class="relative hidden sm:block" id="currencyDropdownWrapper">
        <button type="button" onclick="toggleCurrencyMenu()" id="currentCurrencyBtn" class="flex items-center gap-1 px-2.5 py-1.5 rounded-full border border-stone-300 hover:border-[#a16207] text-xs font-mono text-stone-800 hover:bg-stone-100 transition-all cursor-pointer" aria-label="Select Currency">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
          <span id="headerCurrencyCode" class="font-bold">INR (₹)</span>
          <span class="material-symbols-outlined text-[14px] text-stone-500">expand_more</span>
        </button>

        <div id="currencyDropdownMenu" class="absolute right-0 top-full mt-2 w-48 liquid-glass bg-surface shadow-2xl rounded-DEFAULT border border-outline-variant/60 p-2 hidden flex-col gap-1 z-50 animate-in fade-in slide-in-from-top-2 duration-200">
          <div class="text-[10px] font-label-caps uppercase tracking-wider text-on-surface-variant px-2 py-1 border-b border-outline-variant/30">
            Select Currency
          </div>
          <button type="button" onclick="selectStoreCurrency('INR')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="INR">
            <span>🇮🇳 INR · Rupee</span>
            <span class="font-mono text-[11px] text-accent">₹</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('USD')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="USD">
            <span>🇺🇸 USD · Dollar</span>
            <span class="font-mono text-[11px] text-accent">$</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('EUR')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="EUR">
            <span>🇪🇺 EUR · Euro</span>
            <span class="font-mono text-[11px] text-accent">€</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('GBP')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="GBP">
            <span>🇬🇧 GBP · Pound</span>
            <span class="font-mono text-[11px] text-accent">£</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('AED')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="AED">
            <span>🇦🇪 AED · Dirham</span>
            <span class="font-mono text-[11px] text-accent">AED</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('CAD')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="CAD">
            <span>🇨🇦 CAD · Dollar</span>
            <span class="font-mono text-[11px] text-accent">CA$</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('AUD')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="AUD">
            <span>🇦🇺 AUD · Dollar</span>
            <span class="font-mono text-[11px] text-accent">AU$</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('JPY')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="JPY">
            <span>🇯🇵 JPY · Yen</span>
            <span class="font-mono text-[11px] text-accent">¥</span>
          </button>
          <button type="button" onclick="selectStoreCurrency('SGD')" class="currency-opt-btn flex items-center justify-between px-2.5 py-1.5 text-xs text-left rounded hover:bg-surface-container transition-colors text-primary font-medium" data-curr="SGD">
            <span>🇸🇬 SGD · Dollar</span>
            <span class="font-mono text-[11px] text-accent">SG$</span>
          </button>
        </div>
      </div>

      <!-- ── Search Button (Opens Search Widget) ── -->
      <button type="button" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-800 hover:text-[#a16207] hover:bg-stone-100/80 border border-transparent hover:border-stone-200 transition-all hover:scale-105 active:scale-95 cursor-pointer shadow-2xs" onclick="toggleSearchModal()" aria-label="Search Collection" title="Search (Ctrl+K)">
        <span class="material-symbols-outlined text-[19px]">search</span>
      </button>

      <!-- ── Wishlist Saved Wardrobe Button ── -->
      <button type="button" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-800 hover:text-rose-500 hover:bg-rose-50/80 border border-transparent hover:border-rose-200 transition-all hover:scale-105 active:scale-95 relative cursor-pointer shadow-2xs group" onclick="openWishlistDrawer()" aria-label="Saved Wardrobe" title="Saved Wardrobe">
        <span class="material-symbols-outlined text-[19px] group-hover:text-rose-500 transition-colors">favorite</span>
        <span id="wishlistHeaderBadge" class="absolute -top-0.5 -right-0.5 min-w-[17px] h-[17px] px-1 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-[9px] font-mono font-extrabold rounded-full flex items-center justify-center border-2 border-white shadow-sm hidden animate-pulse">0</span>
      </button>

      <!-- ── Account Link ── -->
      <a href="<?= base_url('account') ?>" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full hidden md:flex items-center justify-center text-stone-800 hover:text-[#a16207] hover:bg-amber-50/80 border border-transparent hover:border-amber-200 transition-all hover:scale-105 active:scale-95 shadow-2xs" aria-label="Account Profile" title="Atelier Profile">
        <span class="material-symbols-outlined text-[19px]">person</span>
      </a>

      <!-- ── Curated Bag Button ── -->
      <button type="button" id="headerCartBtn" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-stone-900 bg-stone-100 hover:bg-stone-950 hover:text-[#e9c176] border border-stone-200 hover:border-stone-950 transition-all hover:scale-105 active:scale-95 relative cursor-pointer shadow-xs group" onclick="toggleQuickBagDrawer()" aria-label="Open Curated Bag" title="Curated Bag">
        <span class="material-symbols-outlined text-[19px] group-hover:text-[#e9c176] transition-colors">shopping_bag</span>
        <?php $c_count = isset($cart_count) ? (int)$cart_count : ((isset($this->session) && method_exists($this->session, 'userdata')) ? (int)($this->session->userdata('cart_count') ?? 0) : 0); ?>
        <span id="cartBadgeCount" class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 bg-stone-950 text-white text-[9px] font-mono font-extrabold rounded-full flex items-center justify-center border-2 border-white shadow-md <?= $c_count > 0 ? '' : 'hidden' ?>">
          <?= $c_count ?>
        </span>
      </button>
    </div>

  </div>
</header>

<!-- ── Quick-Bag Slideover Drawer (UI/UX Pro Max Pattern) ── -->
<div id="quickBagOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[9999] hidden transition-opacity duration-300" onclick="if(event.target===this)toggleQuickBagDrawer()" data-lenis-prevent="true" style="overscroll-behavior: contain;">
  <div class="fixed inset-y-0 right-0 max-w-[92vw] sm:max-w-md w-full h-full liquid-glass bg-surface shadow-2xl p-4 sm:p-5 flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-out will-change-transform transform-gpu overflow-hidden" id="quickBagPanel" data-lenis-prevent="true" style="overscroll-behavior: contain;">
    
    <!-- Drawer Header (Fixed) -->
    <div class="flex justify-between items-center pb-3 border-b border-outline-variant/40 flex-shrink-0">
      <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-[#a16207]">shopping_bag</span>
        <h3 class="font-headline-sm text-lg text-primary font-serif font-bold">Curated Bag</h3>
      </div>
      <button type="button" onclick="toggleQuickBagDrawer()" class="w-7 h-7 rounded-full flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors cursor-pointer" aria-label="Close Bag">
        <span class="material-symbols-outlined text-lg">close</span>
      </button>
    </div>

    <!-- Free Express Delivery Progress Bar (Compact) -->
    <div class="py-2 border-b border-stone-200/80 flex-shrink-0" id="quickBagShippingMeter">
      <div class="flex items-center justify-between text-[10px] mb-1">
        <span class="font-mono text-stone-600 flex items-center gap-1 truncate">
          <span class="material-symbols-outlined text-[13px] text-[#a16207]">local_shipping</span>
          <span id="quickBagShippingText">Add more for Free Express Delivery</span>
        </span>
        <span class="font-mono font-bold text-stone-900 ml-2" id="quickBagShippingPct">100%</span>
      </div>
      <div class="w-full bg-stone-100 rounded-full h-1 overflow-hidden">
        <div id="quickBagShippingBar" class="bg-gradient-to-r from-[#a16207] to-amber-400 h-full rounded-full transition-all duration-500" style="width: 100%;"></div>
      </div>
    </div>

    <!-- Drawer Items List (Maximized Flexible Scroll Area) -->
    <div class="py-2.5 flex-1 overflow-y-auto custom-scrollbar flex flex-col gap-2.5 min-h-0 pr-1" id="quickBagItemsList" data-lenis-prevent="true" style="overscroll-behavior: contain;">
      <div class="py-12 text-center text-on-surface-variant text-sm flex flex-col items-center">
        <span class="material-symbols-outlined text-4xl mb-2 text-outline-variant">checkroom</span>
        <p>Your curated selection is ready to be tailored.</p>
      </div>
    </div>

    <!-- Compact Expandable VIP Promo Section -->
    <details class="group border-t border-stone-200/80 pt-2 flex-shrink-0" id="quickBagCouponAccordion">
      <summary class="flex items-center justify-between text-[10.5px] font-mono font-bold text-stone-700 hover:text-stone-950 cursor-pointer list-none select-none py-1">
        <span class="flex items-center gap-1.5 truncate">
          <span class="material-symbols-outlined text-[13px] text-[#a16207]">sell</span>
          <span>Have a promo code?</span>
          <span id="quickBagCouponStatus" class="text-[9.5px] font-mono text-emerald-600 font-bold ml-1 hidden"></span>
        </span>
        <span class="material-symbols-outlined text-xs group-open:rotate-180 transition-transform text-stone-400 flex-shrink-0">expand_more</span>
      </summary>
      
      <div class="pt-1.5 pb-1 flex flex-col gap-1.5">
        <!-- Input + Apply Button -->
        <div class="relative flex items-center">
          <input type="text" id="quickBagCouponInput" placeholder="VIP Code (e.g. LUMINA50)" class="w-full pl-2.5 pr-16 py-1.5 bg-stone-50 border border-stone-200 rounded-lg text-xs font-mono uppercase text-stone-900 placeholder:text-stone-400 focus:outline-none focus:border-stone-950 focus:bg-white transition-all shadow-2xs">
          <button type="button" onclick="applyQuickBagCoupon()" id="quickBagCouponBtn" class="absolute right-1 px-2.5 py-1 bg-stone-950 hover:bg-stone-800 text-white font-mono text-[9.5px] font-bold uppercase tracking-wider rounded-md transition-all cursor-pointer">
            Apply
          </button>
        </div>

        <!-- Tap-To-Apply Quick Pills -->
        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-0.5">
          <button type="button" onclick="setQuickCoupon('LUMINA50')" class="px-2 py-0.5 rounded bg-amber-50 border border-amber-200 hover:border-amber-400 text-[#a16207] text-[8px] font-mono font-bold uppercase flex items-center gap-0.5 flex-shrink-0 transition-all cursor-pointer">
            <span>🏷️ LUMINA50</span>
            <span class="opacity-75">(50%)</span>
          </button>
          <button type="button" onclick="setQuickCoupon('NOVA10')" class="px-2 py-0.5 rounded bg-stone-100 border border-stone-200 hover:border-stone-400 text-stone-700 text-[8px] font-mono font-bold uppercase flex items-center gap-0.5 flex-shrink-0 transition-all cursor-pointer">
            <span>🏷️ NOVA10</span>
            <span class="opacity-75">(10%)</span>
          </button>
          <button type="button" onclick="setQuickCoupon('FREESHIP')" class="px-2 py-0.5 rounded bg-stone-100 border border-stone-200 hover:border-stone-400 text-stone-700 text-[8px] font-mono font-bold uppercase flex items-center gap-0.5 flex-shrink-0 transition-all cursor-pointer">
            <span>🚚 FREESHIP</span>
          </button>
        </div>
      </div>
    </details>

    <!-- Drawer Footer (Compact Fixed) -->
    <div class="border-t border-outline-variant/40 pt-2 flex flex-col gap-2 flex-shrink-0 mt-auto">
      <div class="space-y-0.5 text-xs font-mono">
        <div class="flex justify-between items-center text-stone-500 text-[10.5px]">
          <span>Bag Subtotal:</span>
          <span id="quickBagOriginalSubtotal" data-price-inr="0">₹0</span>
        </div>
        <div id="quickBagDiscountRow" class="hidden flex justify-between items-center text-xs font-mono text-emerald-600 font-bold">
          <span>VIP Discount (<span id="quickBagAppliedCouponCode"></span><span id="quickBagDiscountCode"></span>):</span>
          <span id="quickBagDiscountAmt"><span id="quickBagDiscountAmount">-₹0</span></span>
        </div>
        <div class="flex justify-between items-center text-sm sm:text-base font-bold font-serif text-primary border-t border-dashed border-stone-200 pt-1">
          <span>Estimated Total:</span>
          <span id="quickBagSubtotal" data-price-inr="0">₹0</span>
        </div>
        <!-- Points Earned on Order -->
        <div class="flex items-center justify-between py-1 px-2 mt-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-950 text-[10px] font-mono font-bold" id="quickBagPointsRow">
          <span class="flex items-center gap-1">
            <span>🪙 Order Earns:</span>
            <span id="quickBagPointsVal" class="text-amber-900 font-extrabold">+0 pts</span>
          </span>
          <span class="text-amber-700 font-normal" id="quickBagCashbackVal">(₹0 Cashback Credit)</span>
        </div>
      </div>

      <!-- Streamlined Action Buttons (Side-by-side) -->
      <div class="flex items-center gap-2 pt-0.5">
        <a href="<?= base_url('cart') ?>" class="w-1/3 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-800 font-mono text-[10.5px] uppercase tracking-wider font-bold text-center rounded-xl transition-all cursor-pointer border border-stone-200 truncate">
          Full Bag
        </a>
        <a href="<?= base_url('checkout') ?>" class="flex-1 py-2.5 bg-stone-950 hover:bg-stone-900 text-white font-mono text-xs uppercase tracking-wider font-bold text-center rounded-xl transition-all shadow-md active:scale-95 cursor-pointer flex items-center justify-center gap-1.5">
          <span>Checkout</span>
          <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
      </div>

      <div class="text-center">
        <span class="text-[9px] font-mono text-stone-400 flex items-center justify-center gap-1">
          <span class="material-symbols-outlined text-xs text-[#a16207]">verified_user</span>
          <span>Complimentary insured courier delivery</span>
        </span>
      </div>
    </div>
  </div>
</div>

<!-- ── Mobile Navigation Slide-Over Drawer ── -->
<div id="mobileMenuDrawer" class="fixed inset-0 z-50 hidden md:hidden" role="dialog" aria-modal="true">
  <!-- Backdrop -->
  <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0" id="mobileMenuBackdrop" onclick="toggleMobileNav()"></div>

  <!-- Slide Panel -->
  <div class="fixed inset-y-0 left-0 max-w-[85vw] w-80 bg-surface shadow-2xl border-r border-outline-variant/40 flex flex-col justify-between transform -translate-x-full transition-transform duration-300 ease-out z-10 overflow-y-auto custom-scrollbar" id="mobileMenuPanel">
    <div class="p-5 sm:p-6">
      <!-- Drawer Header -->
      <div class="flex justify-between items-center pb-4 border-b border-outline-variant/30">
        <div class="flex items-center gap-2">
          <span class="font-headline-sm text-2xl text-primary font-serif tracking-widest uppercase"><?= htmlspecialchars($hs['brand_name'] ?? 'NOVADROP') ?></span>
          <span class="text-[9px] font-mono uppercase tracking-wider text-accent bg-accent/10 px-2 py-0.5 rounded-full font-bold">Atelier</span>
        </div>
        <button type="button" onclick="toggleMobileNav()" class="w-9 h-9 rounded-full flex items-center justify-center text-primary hover:bg-surface-container transition-colors cursor-pointer" aria-label="Close Menu">
          <span class="material-symbols-outlined text-2xl">close</span>
        </button>
      </div>

      <!-- Mobile Language & Currency Switchers -->
      <div class="py-4 border-b border-outline-variant/30 grid grid-cols-2 gap-2.5">
        <div>
          <span class="text-[10px] font-label-caps uppercase tracking-wider text-on-surface-variant font-bold block mb-1.5 flex items-center gap-1">
            <span class="material-symbols-outlined text-[13px] text-accent">translate</span> Language
          </span>
          <select onchange="selectStoreLanguage(this.value, this.options[this.selectedIndex].text)" id="mobileLanguageSelect" class="w-full bg-surface-container border border-outline-variant/60 text-xs font-mono rounded-lg px-2 py-2 text-primary outline-none focus:border-accent">
            <option value="en">🇺🇸 EN · English</option>
            <option value="hi">🇮🇳 HI · हिन्दी</option>
            <option value="es">🇪🇸 ES · Español</option>
            <option value="fr">🇫🇷 FR · Français</option>
            <option value="de">🇩🇪 DE · Deutsch</option>
            <option value="ar">🇦🇪 AR · العربية</option>
            <option value="ja">🇯🇵 JA · 日本語</option>
            <option value="zh-CN">🇨🇳 ZH · 中文</option>
          </select>
        </div>
        <div>
          <span class="text-[10px] font-label-caps uppercase tracking-wider text-on-surface-variant font-bold block mb-1.5 flex items-center gap-1">
            <span class="material-symbols-outlined text-[13px] text-emerald-500">payments</span> Currency
          </span>
          <select onchange="selectStoreCurrency(this.value)" id="mobileCurrencySelect" class="w-full bg-surface-container border border-outline-variant/60 text-xs font-mono rounded-lg px-2 py-2 text-primary outline-none focus:border-accent">
            <option value="INR">🇮🇳 INR (₹)</option>
            <option value="USD">🇺🇸 USD ($)</option>
            <option value="EUR">🇪🇺 EUR (€)</option>
            <option value="GBP">🇬🇧 GBP (£)</option>
            <option value="AED">🇦🇪 AED (AED)</option>
            <option value="CAD">🇨🇦 CAD (CA$)</option>
            <option value="AUD">🇦🇺 AUD (AU$)</option>
            <option value="JPY">🇯🇵 JPY (¥)</option>
            <option value="SGD">🇸🇬 SGD (SG$)</option>
          </select>
        </div>
      </div>

      <!-- Navigation Links -->
      <div class="flex flex-col gap-1 py-4">
        <a href="<?= base_url() ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-caps text-xs uppercase tracking-widest text-primary hover:bg-surface-container transition-colors <?= ($current_uri === '' || $current_uri === 'lookbook') ? 'bg-surface-container font-bold text-accent' : '' ?>">
          <span class="material-symbols-outlined text-lg text-accent">auto_awesome_motion</span>
          <span>Runway Lookbook</span>
        </a>
        <a href="<?= base_url('collections') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-caps text-xs uppercase tracking-widest text-primary hover:bg-surface-container transition-colors <?= (strpos($current_uri, 'collections') !== false) ? 'bg-surface-container font-bold text-accent' : '' ?>">
          <span class="material-symbols-outlined text-lg text-accent">style</span>
          <span>Collections</span>
        </a>
        <a href="<?= base_url('shop') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-caps text-xs uppercase tracking-widest text-primary hover:bg-surface-container transition-colors <?= (strpos($current_uri, 'shop') !== false) ? 'bg-surface-container font-bold text-accent' : '' ?>">
          <span class="material-symbols-outlined text-lg text-accent">checkroom</span>
          <span>Boutique Catalog</span>
        </a>
        <a href="<?= base_url('tracking') ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-caps text-xs uppercase tracking-widest text-primary hover:bg-surface-container transition-colors <?= (strpos($current_uri, 'tracking') !== false) ? 'bg-surface-container font-bold text-accent' : '' ?>">
          <span class="material-symbols-outlined text-lg text-accent">local_shipping</span>
          <span>Track Order</span>
        </a>

        <!-- Customer Sign In & Sign Up Action Cards (Mobile Drawer) -->
        <?php $cust = (isset($this->session) && method_exists($this->session, 'userdata')) ? $this->session->userdata('customer') : null; ?>
        <?php if (!$cust): ?>
          <div class="my-2 p-3 bg-stone-50 border border-stone-200/90 rounded-2xl space-y-2">
            <div class="flex items-center justify-between text-[10px] font-mono text-stone-500 uppercase tracking-wider font-bold">
              <span>✦ Atelier Membership ✦</span>
              <span class="text-[#a16207]">15% Privilege</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
              <a href="<?= base_url('account/login') ?>" class="py-2.5 px-3 bg-stone-950 hover:bg-stone-850 text-white rounded-xl text-center font-mono text-xs uppercase tracking-wider font-extrabold shadow-sm active:scale-95 transition-all flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-[#e9c176]">login</span>
                <span>Sign In</span>
              </a>
              <a href="<?= base_url('account/register') ?>" class="py-2.5 px-3 bg-white hover:bg-stone-100 text-stone-950 border border-stone-300 hover:border-stone-900 rounded-xl text-center font-mono text-xs uppercase tracking-wider font-extrabold shadow-2xs active:scale-95 transition-all flex items-center justify-center gap-1.5">
                <span class="material-symbols-outlined text-sm text-stone-700">person_add</span>
                <span>Sign Up</span>
              </a>
            </div>
          </div>
        <?php else: ?>
          <a href="<?= base_url('account') ?>" class="my-2 p-3 bg-stone-950 text-white rounded-2xl flex items-center justify-between shadow-sm border border-stone-800">
            <div class="flex items-center gap-2.5">
              <div class="w-8 h-8 rounded-xl bg-stone-800 text-[#e9c176] font-serif font-bold text-xs flex items-center justify-center">
                <?= strtoupper(substr($cust['name'] ?? 'A', 0, 1)) ?>
              </div>
              <div>
                <p class="font-bold text-xs text-white leading-tight"><?= htmlspecialchars($cust['name'] ?? 'Collector') ?></p>
                <p class="text-[10px] font-mono text-white/60">Atelier Profile &amp; Orders</p>
              </div>
            </div>
            <span class="material-symbols-outlined text-sm text-[#e9c176]">chevron_right</span>
          </a>
        <?php endif; ?>

        <button type="button" onclick="toggleMobileNav(); openVirtualTryOn();" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-caps text-xs uppercase tracking-widest text-[#a16207] bg-amber-50 border border-amber-200 hover:bg-amber-100 transition-colors text-left cursor-pointer font-bold">
          <span class="material-symbols-outlined text-lg text-[#a16207]">camera_alt</span>
          <span>Virtual Mirror Try-On ✦</span>
        </button>
        <button type="button" onclick="toggleMobileNav(); openStylistModal();" class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-label-caps text-xs uppercase tracking-widest text-primary hover:bg-surface-container transition-colors text-left cursor-pointer">
          <span class="material-symbols-outlined text-lg text-accent">auto_awesome</span>
          <span>AI Stylist Concierge</span>
        </button>
      </div>
    </div>

    <!-- Drawer Footer -->
    <div class="p-5 sm:p-6 border-t border-outline-variant/30 bg-surface-container/50">
      <div class="flex items-center justify-between text-xs text-on-surface-variant mb-2">
        <span class="font-mono">White-Glove Transit</span>
        <span class="text-emerald-600 font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active</span>
      </div>
      <p class="text-[10px] text-on-surface-variant font-light leading-relaxed">
        © 2026 LUMINA ATELIER. All Rights Reserved.
      </p>
    </div>
  </div>
</div>

<!-- ── 1-Click In-Site Express Checkout Modal ── -->
<div id="expressCheckoutModal" data-lenis-prevent="true" data-lenis-prevent-wheel="true" data-lenis-prevent-touch="true" class="fixed inset-0 bg-black/75 backdrop-blur-md z-[110] hidden items-center justify-center p-3 sm:p-4 md:p-6 overflow-y-auto" style="overscroll-behavior: contain;" onclick="if(event.target===this)closeExpressCheckout()">
  <div id="expressCheckoutModalInner" data-lenis-prevent="true" data-lenis-prevent-wheel="true" data-lenis-prevent-touch="true" class="liquid-glass bg-white p-5 sm:p-6 md:p-8 rounded-2xl max-w-lg w-full ambient-elevation relative border border-stone-200 shadow-2xl text-stone-900 max-h-[88vh] overflow-y-auto custom-scrollbar my-auto" style="overscroll-behavior: contain; -webkit-overflow-scrolling: touch;">
    
    <!-- Modal Header -->
    <div class="flex justify-between items-start pb-4 border-b border-outline-variant/40 mb-4">
      <div>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 text-[10px] font-mono font-bold uppercase tracking-wider mb-1">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
          <span>1-Click Direct In-Site Order</span>
        </div>
        <h3 class="font-headline-sm text-2xl text-primary font-serif">Instant Atelier Checkout</h3>
      </div>
      <button type="button" onclick="closeExpressCheckout()" class="p-1 text-on-surface-variant hover:text-primary cursor-pointer" aria-label="Close Checkout">
        <span class="material-symbols-outlined text-2xl">close</span>
      </button>
    </div>

    <!-- Product Summary Snippet -->
    <div class="flex items-center gap-4 p-3 bg-surface-container rounded-DEFAULT mb-4 border border-outline-variant/30">
      <img id="ecProductImg" src="" class="w-16 h-18 object-cover rounded-DEFAULT flex-shrink-0 bg-black/10">
      <div class="flex-1 min-w-0">
        <h4 id="ecProductTitle" class="font-serif font-bold text-sm text-primary truncate">Piece Title</h4>
        <div class="flex items-center gap-2 mt-1">
          <span id="ecProductPrice" class="font-serif font-bold text-base text-primary" data-price-inr="0">₹0</span>
          <span class="text-[10px] text-emerald-600 font-semibold bg-emerald-500/10 px-2 py-0.5 rounded">Free Express Delivery</span>
        </div>
        <div class="text-[11px] text-accent font-mono mt-0.5" id="ecPointsEarned">✦ Earn +350 Lumina Points</div>
      </div>
    </div>

    <!-- Express Order Form -->
    <form id="expressOrderForm" onsubmit="handleExpressOrderSubmit(event)" class="space-y-3 text-xs">
      <input type="hidden" id="ecProductId" name="product_id" value="">
      <input type="hidden" id="ecVariantId" name="variant_id" value="">
      <input type="hidden" id="ecBaseInr" name="base_inr" value="0">
      
      <!-- Category-Accurate Size / Fit Selector -->
      <div>
        <div class="flex justify-between items-center mb-1">
          <label class="font-label-caps uppercase tracking-wider text-[10px] text-stone-700 block font-bold">Select Atelier Fit:</label>
          <span id="ecSelectedSizeLabel" class="text-[10px] font-mono font-bold text-[#a16207]">Size M</span>
        </div>
        <div class="flex gap-1.5 font-mono overflow-x-auto no-scrollbar py-0.5" id="ecSizeContainer">
          <!-- Dynamically populated by openExpressCheckout via resolveProductSizes -->
          <label class="flex-1 text-center py-1.5 border border-stone-200 rounded-lg cursor-pointer hover:border-stone-900 text-xs has-[:checked]:border-stone-950 has-[:checked]:bg-stone-950 has-[:checked]:text-[#e9c176] has-[:checked]:font-bold transition-all shadow-2xs">
            <input type="radio" name="ec_size" value="M" checked class="hidden">
            <span>M</span>
          </label>
        </div>
      </div>

      <!-- Atelier Color Selection -->
      <div>
        <div class="flex justify-between items-center mb-1">
          <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant font-bold">Select Atelier Colorway:</label>
          <span id="ecSelectedColorName" class="text-[10px] font-mono font-bold text-accent">Signature Camel</span>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" id="ecColorContainer">
          <label class="flex items-center gap-2 p-2 rounded-lg border border-primary bg-primary/5 cursor-pointer text-[11px] font-medium has-[:checked]:border-accent has-[:checked]:ring-1 has-[:checked]:ring-accent has-[:checked]:bg-accent/10 transition-all">
            <input type="radio" name="ec_color" value="Signature Camel" checked class="hidden" onchange="document.getElementById('ecSelectedColorName').textContent = this.value">
            <span class="w-3.5 h-3.5 rounded-full border border-stone-300 flex-shrink-0 shadow-xs" style="background-color: #c19a6b;"></span>
            <span class="truncate">Camel</span>
          </label>
          <label class="flex items-center gap-2 p-2 rounded-lg border border-outline-variant bg-surface cursor-pointer text-[11px] font-medium has-[:checked]:border-accent has-[:checked]:ring-1 has-[:checked]:ring-accent has-[:checked]:bg-accent/10 transition-all">
            <input type="radio" name="ec_color" value="Obsidian Black" class="hidden" onchange="document.getElementById('ecSelectedColorName').textContent = this.value">
            <span class="w-3.5 h-3.5 rounded-full border border-stone-300 flex-shrink-0 shadow-xs" style="background-color: #1a1a1a;"></span>
            <span class="truncate">Obsidian</span>
          </label>
          <label class="flex items-center gap-2 p-2 rounded-lg border border-outline-variant bg-surface cursor-pointer text-[11px] font-medium has-[:checked]:border-accent has-[:checked]:ring-1 has-[:checked]:ring-accent has-[:checked]:bg-accent/10 transition-all">
            <input type="radio" name="ec_color" value="Oatmeal Melange" class="hidden" onchange="document.getElementById('ecSelectedColorName').textContent = this.value">
            <span class="w-3.5 h-3.5 rounded-full border border-stone-300 flex-shrink-0 shadow-xs" style="background-color: #dcd0c0;"></span>
            <span class="truncate">Oatmeal</span>
          </label>
          <label class="flex items-center gap-2 p-2 rounded-lg border border-outline-variant bg-surface cursor-pointer text-[11px] font-medium has-[:checked]:border-accent has-[:checked]:ring-1 has-[:checked]:ring-accent has-[:checked]:bg-accent/10 transition-all">
            <input type="radio" name="ec_color" value="Forest Emerald" class="hidden" onchange="document.getElementById('ecSelectedColorName').textContent = this.value">
            <span class="w-3.5 h-3.5 rounded-full border border-stone-300 flex-shrink-0 shadow-xs" style="background-color: #1b4332;"></span>
            <span class="truncate">Emerald</span>
          </label>
        </div>
      </div>

      <!-- Quantity Stepper -->
      <div class="flex items-center justify-between py-2 px-3 bg-stone-50 border border-stone-200 rounded-xl shadow-2xs">
        <label class="font-label-caps uppercase tracking-wider text-[10px] text-stone-700 font-bold">Select Quantity:</label>
        <div class="flex items-center gap-2">
          <button type="button" onclick="changeEcQuantity(-1)" class="w-6 h-6 rounded-lg bg-white hover:bg-stone-200 border border-stone-300 flex items-center justify-center font-bold text-xs cursor-pointer shadow-2xs text-stone-800 active:scale-95">-</button>
          <input type="hidden" id="ecQuantity" name="quantity" value="1">
          <span id="ecQuantityDisplay" class="w-6 text-center font-mono font-bold text-xs text-stone-950">1</span>
          <button type="button" onclick="changeEcQuantity(1)" class="w-6 h-6 rounded-lg bg-white hover:bg-stone-200 border border-stone-300 flex items-center justify-center font-bold text-xs cursor-pointer shadow-2xs text-stone-800 active:scale-95">+</button>
        </div>
      </div>

      <!-- Customer Details -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
        <div>
          <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant block mb-1 font-bold">Full Name *</label>
          <input type="text" id="ecFullName" name="full_name" required placeholder="e.g. Elena Rostova" class="w-full px-3 py-2 bg-surface border border-outline-variant rounded text-xs text-primary outline-none focus:border-primary">
        </div>
        <div>
          <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant block mb-1 font-bold">Mobile Number *</label>
          <input type="tel" id="ecPhone" name="phone" required placeholder="e.g. 9876543210" class="w-full px-3 py-2 bg-surface border border-outline-variant rounded text-xs text-primary outline-none focus:border-primary">
        </div>
      </div>

      <div>
        <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant block mb-1 font-bold">Delivery Address *</label>
        <input type="text" id="ecAddress" name="address" required placeholder="Flat / House No, Street, Landmark" class="w-full px-3 py-2 bg-surface border border-outline-variant rounded text-xs text-primary outline-none focus:border-primary">
      </div>

      <div class="grid grid-cols-2 gap-2.5">
        <div>
          <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant block mb-1 font-bold">City *</label>
          <input type="text" id="ecCity" name="city" required placeholder="City / District" class="w-full px-3 py-2 bg-surface border border-outline-variant rounded text-xs text-primary outline-none focus:border-primary">
        </div>
        <div>
          <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant block mb-1 font-bold">Pincode *</label>
          <input type="text" id="ecPincode" name="pincode" required placeholder="Pincode" class="w-full px-3 py-2 bg-surface border border-outline-variant rounded text-xs text-primary outline-none focus:border-primary">
        </div>
      </div>

      <!-- Creator Code / Promo Voucher -->
      <div class="p-2.5 bg-stone-50 border border-stone-200 rounded-xl">
        <div class="flex justify-between items-center mb-1">
          <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant font-bold">Creator Code / VIP Coupon:</label>
          <span id="ecDiscountBadge" class="text-[9px] font-mono text-emerald-600 font-bold hidden">Code Applied!</span>
        </div>
        <div class="flex gap-2">
          <input type="text" id="ecPromoCode" placeholder="Enter code (e.g. PRIYA12, VIP25)" class="flex-1 px-3 py-1.5 bg-white border border-outline-variant rounded text-xs text-primary font-mono uppercase outline-none focus:border-primary">
          <button type="button" onclick="applyExpressPromo()" class="px-3 py-1.5 bg-stone-900 hover:bg-stone-800 text-white font-mono text-xs font-bold uppercase rounded cursor-pointer transition-all">
            Apply
          </button>
        </div>
        <div id="ecDiscountRow" class="hidden mt-1.5 pt-1.5 border-t border-stone-200 flex justify-between items-center text-xs font-mono">
          <span class="text-emerald-700 font-semibold" id="ecDiscountLabel">Privilege Discount:</span>
          <span class="text-emerald-700 font-bold" id="ecDiscountAmount">-₹0</span>
        </div>
      </div>

      <!-- Payment Method Selection -->
      <div>
        <label class="font-label-caps uppercase tracking-wider text-[10px] text-on-surface-variant block mb-1 font-bold">Payment Method:</label>
        <div class="grid grid-cols-2 gap-2">
          <label class="p-2 border border-primary bg-primary/5 rounded flex items-center gap-2 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/10">
            <input type="radio" name="ec_payment" value="cod" checked class="accent-primary">
            <div>
              <span class="font-bold block text-primary text-[11px]">Cash on Delivery</span>
              <span class="text-[10px] text-on-surface-variant">Pay upon delivery</span>
            </div>
          </label>
          <label class="p-2 border border-outline-variant rounded flex items-center gap-2 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/10">
            <input type="radio" name="ec_payment" value="online" class="accent-primary">
            <div>
              <span class="font-bold block text-primary text-[11px]">Instant UPI / Cards</span>
              <span class="text-[10px] text-on-surface-variant">GPay, PhonePe, Cards</span>
            </div>
          </label>
        </div>
      </div>

      <!-- Dual Action Buttons: Add to Bag + Instant Buy -->
      <div class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
        <button type="button" onclick="handleExpressAddToCart()" id="ecAddToCartBtn" class="w-full py-3 px-4 bg-stone-100 hover:bg-stone-200 text-stone-900 border border-stone-300 font-button text-xs uppercase tracking-wider font-bold rounded-xl transition-all shadow-2xs flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
          <span class="material-symbols-outlined text-base text-[#a16207]">shopping_bag</span>
          <span>Add to Curated Bag</span>
        </button>
        <button type="submit" id="ecSubmitBtn" class="w-full py-3 px-4 bg-stone-950 hover:bg-stone-900 text-white font-button text-xs uppercase tracking-wider font-extrabold rounded-xl transition-all shadow-md flex items-center justify-center gap-1.5 cursor-pointer active:scale-95">
          <span class="material-symbols-outlined text-base text-[#e9c176]">bolt</span>
          <span id="ecSubmitBtnText">Instant 1-Click Buy →</span>
        </button>
      </div>

      <div class="text-[10px] text-center text-on-surface-variant flex items-center justify-center gap-2 pt-1">
        <span class="material-symbols-outlined text-xs text-accent">shield</span>
        <span>100% Certified Atelier Provenance · 7-Day Doorstep Exchanges</span>
      </div>

    </form>

  </div>
</div>

<script>
// ── Global Multi-Currency Engine ──
window.LUMINA_CURRENCIES = {
  INR: { symbol: '₹', rate: 1.0, name: 'Indian Rupee', code: 'INR' },
  USD: { symbol: '$', rate: 0.012, name: 'US Dollar', code: 'USD' },
  EUR: { symbol: '€', rate: 0.011, name: 'Euro', code: 'EUR' },
  GBP: { symbol: '£', rate: 0.0095, name: 'British Pound', code: 'GBP' },
  AED: { symbol: 'AED ', rate: 0.044, name: 'UAE Dirham', code: 'AED' },
  CAD: { symbol: 'CA$', rate: 0.016, name: 'Canadian Dollar', code: 'CAD' },
  AUD: { symbol: 'AU$', rate: 0.018, name: 'Australian Dollar', code: 'AUD' },
  JPY: { symbol: '¥', rate: 1.80, name: 'Japanese Yen', code: 'JPY' },
  SGD: { symbol: 'SG$', rate: 0.016, name: 'Singapore Dollar', code: 'SGD' }
};

window.getStoreCurrency = function() {
  return localStorage.getItem('lumina_currency') || 'INR';
};

window.formatPrice = function(inrAmount, customCurrency) {
  const currCode = customCurrency || window.getStoreCurrency();
  const curr = window.LUMINA_CURRENCIES[currCode] || window.LUMINA_CURRENCIES.INR;
  const num = parseFloat(inrAmount) || 0;
  const converted = num * curr.rate;
  
  if (currCode === 'INR' || currCode === 'JPY') {
    return curr.symbol + Math.round(converted).toLocaleString('en-IN');
  } else {
    return curr.symbol + converted.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
};

window.selectStoreCurrency = function(code) {
  if (!window.LUMINA_CURRENCIES[code]) return;
  localStorage.setItem('lumina_currency', code);
  const curr = window.LUMINA_CURRENCIES[code];
  
  const btnText = document.getElementById('headerCurrencyCode');
  if (btnText) btnText.textContent = `${code} (${curr.symbol.trim()})`;
  
  const mobSelect = document.getElementById('mobileCurrencySelect');
  if (mobSelect) mobSelect.value = code;
  
  const menu = document.getElementById('currencyDropdownMenu');
  if (menu) menu.classList.add('hidden');
  
  window.updateAllPricesOnPage();
  
  if (typeof ndToast === 'function') {
    ndToast(`Currency switched to ${curr.name} (${curr.code})`, 'success');
  }
};

window.toggleCurrencyMenu = function() {
  const menu = document.getElementById('currencyDropdownMenu');
  if (menu) menu.classList.toggle('hidden');
};

document.addEventListener('click', function(e) {
  const wrapper = document.getElementById('currencyDropdownWrapper');
  const menu = document.getElementById('currencyDropdownMenu');
  if (wrapper && menu && !wrapper.contains(e.target)) {
    menu.classList.add('hidden');
  }
});

window.updateAllPricesOnPage = function() {
  const currCode = window.getStoreCurrency();
  const curr = window.LUMINA_CURRENCIES[currCode] || window.LUMINA_CURRENCIES.INR;
  
  const btnText = document.getElementById('headerCurrencyCode');
  if (btnText) btnText.textContent = `${currCode} (${curr.symbol.trim()})`;
  
  const mobSelect = document.getElementById('mobileCurrencySelect');
  if (mobSelect) mobSelect.value = currCode;
  
  document.querySelectorAll('[data-price-inr]').forEach(el => {
    const baseInr = parseFloat(el.getAttribute('data-price-inr'));
    if (!isNaN(baseInr)) {
      el.textContent = window.formatPrice(baseInr, currCode);
    }
  });
};

// ── Multi-Language Converter & Google Translate Engine ──
window.toggleLanguageMenu = function() {
  const menu = document.getElementById('languageDropdownMenu');
  if (menu) menu.classList.toggle('hidden');
};

window.selectStoreLanguage = function(langCode, langName) {
  localStorage.setItem('lumina_lang', langCode);
  document.cookie = "googtrans=/en/" + langCode + "; path=/";
  document.cookie = "googtrans=/en/" + langCode + "; domain=" + window.location.hostname + "; path=/";
  
  const btnText = document.getElementById('headerLanguageCode');
  if (btnText) btnText.textContent = langCode.toUpperCase().split('-')[0];
  
  const mobSelect = document.getElementById('mobileLanguageSelect');
  if (mobSelect) mobSelect.value = langCode;
  
  const menu = document.getElementById('languageDropdownMenu');
  if (menu) menu.classList.add('hidden');
  
  // Trigger google translate select if available
  var select = document.querySelector('.goog-te-combo');
  if (select) {
    select.value = langCode;
    select.dispatchEvent(new Event('change'));
  } else {
    location.reload();
  }
  
  if (typeof ndToast === 'function') {
    ndToast('Language switched to ' + langName, 'success');
  }
};

document.addEventListener('click', function(e) {
  const langWrapper = document.getElementById('languageDropdownWrapper');
  const langMenu = document.getElementById('languageDropdownMenu');
  if (langWrapper && langMenu && !langWrapper.contains(e.target)) {
    langMenu.classList.add('hidden');
  }
});

function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en',
    includedLanguages: 'en,hi,es,fr,de,ar,ja,zh-CN',
    autoDisplay: false
  }, 'google_translate_element');
}

// Restore saved language on load
document.addEventListener('DOMContentLoaded', () => {
  const savedLang = localStorage.getItem('lumina_lang');
  if (savedLang) {
    const btnText = document.getElementById('headerLanguageCode');
    if (btnText) btnText.textContent = savedLang.toUpperCase().split('-')[0];
    const mobSelect = document.getElementById('mobileLanguageSelect');
    if (mobSelect) mobSelect.value = savedLang;
  }
});

// ── In-Site 1-Click Express Checkout System ──
window.changeEcQuantity = function(delta) {
  var input = document.getElementById('ecQuantity');
  var display = document.getElementById('ecQuantityDisplay');
  var currentQty = parseInt(input ? input.value : 1) || 1;
  var newQty = Math.max(1, Math.min(20, currentQty + delta));
  if (input) input.value = newQty;
  if (display) display.textContent = newQty;
};

window.openExpressCheckout = function(productId, title, priceInr, imgUrl, variantId, preselectedSize, preselectedColor, preselectedQty) {
  var modal = document.getElementById('expressCheckoutModal');
  if (!modal) return;
  
  document.getElementById('ecProductId').value = productId || '';
  document.getElementById('ecVariantId').value = variantId || productId || '';
  document.getElementById('ecBaseInr').value = priceInr || 0;
  document.getElementById('ecProductTitle').textContent = title || 'Atelier Masterpiece';
  document.getElementById('ecProductImg').src = imgUrl || '<?= base_url('img/cashmere_cocoon_coat.jpg') ?>';
  
  var priceEl = document.getElementById('ecProductPrice');
  priceEl.setAttribute('data-price-inr', priceInr);
  priceEl.textContent = window.formatPrice(priceInr);
  
  var points = Math.round(priceInr * 0.1);
  document.getElementById('ecPointsEarned').textContent = '✦ Earn +' + points + ' Lumina Points';
  
  // Set quantity
  var qtyInput = document.getElementById('ecQuantity');
  var qtyDisplay = document.getElementById('ecQuantityDisplay');
  var initQty = parseInt(preselectedQty) || 1;
  if (qtyInput) qtyInput.value = initQty;
  if (qtyDisplay) qtyDisplay.textContent = initQty;

  // Render category-accurate sizes dynamically (jeans waist sizes, shoes UK sizes, apparel letters, bag One Size)
  var possibleSizes = (typeof window.resolveProductSizes === 'function') ? window.resolveProductSizes(title || '') : ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
  var activeSize = preselectedSize || possibleSizes[Math.min(2, possibleSizes.length - 1)];
  
  var sizeContainer = document.getElementById('ecSizeContainer');
  if (sizeContainer) {
    sizeContainer.innerHTML = possibleSizes.map(function(sz) {
      var isChecked = (sz === activeSize);
      return `
        <label class="flex-1 min-w-[48px] text-center py-1.5 border border-stone-200 rounded-lg cursor-pointer hover:border-stone-900 text-xs has-[:checked]:border-stone-950 has-[:checked]:bg-stone-950 has-[:checked]:text-[#e9c176] has-[:checked]:font-bold transition-all shadow-2xs">
          <input type="radio" name="ec_size" value="${sz}" ${isChecked ? 'checked' : ''} class="hidden" onchange="var lbl=document.getElementById('ecSelectedSizeLabel'); if(lbl) lbl.textContent='Size ' + this.value;">
          <span>${sz}</span>
        </label>
      `;
    }).join('');
  }
  var sizeLbl = document.getElementById('ecSelectedSizeLabel');
  if (sizeLbl) sizeLbl.textContent = 'Size ' + activeSize;

  // Load saved address from localStorage if available
  var saved = JSON.parse(localStorage.getItem('lumina_saved_shipping') || '{}');
  if (saved.fullName) document.getElementById('ecFullName').value = saved.fullName;
  if (saved.phone) document.getElementById('ecPhone').value = saved.phone;
  if (saved.address) document.getElementById('ecAddress').value = saved.address;
  if (saved.city) document.getElementById('ecCity').value = saved.city;
  if (saved.pincode) document.getElementById('ecPincode').value = saved.pincode;
  
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  document.body.style.overflow = 'hidden';
  if (window.lenisInstance && typeof window.lenisInstance.stop === 'function') {
    window.lenisInstance.stop();
  }
};

window.handleExpressAddToCart = function() {
  var prodId = parseInt(document.getElementById('ecProductId').value) || 1;
  var title = document.getElementById('ecProductTitle').textContent || 'Curated Piece';
  var price = parseFloat(document.getElementById('ecBaseInr').value || 0);
  var img = document.getElementById('ecProductImg').src || '';
  
  var sizeRadio = document.querySelector('input[name="ec_size"]:checked');
  var size = sizeRadio ? sizeRadio.value : 'M';
  
  var colorRadio = document.querySelector('input[name="ec_color"]:checked');
  var color = colorRadio ? colorRadio.value : '';

  var qty = parseInt(document.getElementById('ecQuantity')?.value || 1) || 1;

  if (typeof window.addToCart === 'function') {
    window.addToCart({
      id: prodId,
      variant_id: prodId,
      product_id: prodId,
      title: title,
      price: price,
      image: img,
      size: size,
      color: color
    }, qty, '✦ Added ' + qty + 'x "' + title + '" (Size ' + size + ') to Curated Bag!', function() {
      closeExpressCheckout();
      if (typeof toggleQuickBagDrawer === 'function') toggleQuickBagDrawer();
    });
    closeExpressCheckout();
    setTimeout(function() {
      if (typeof toggleQuickBagDrawer === 'function') toggleQuickBagDrawer();
    }, 450);
  }
};

window.closeExpressCheckout = function() {
  var modal = document.getElementById('expressCheckoutModal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    if (window.lenisInstance && typeof window.lenisInstance.start === 'function') {
      window.lenisInstance.start();
    }
  }
};

window.appliedExpressDiscount = 0;
window.appliedExpressCode = '';

window.applyExpressPromo = function() {
  var code = (document.getElementById('ecPromoCode').value || '').trim().toUpperCase();
  if (!code) {
    alert('Please enter a coupon or influencer code.');
    return;
  }
  var baseInr = parseFloat(document.getElementById('ecBaseInr').value || 0);
  if (baseInr <= 0) return;

  var discPct = 0;
  var flatDisc = 0;
  var codeName = code;

  if (code === 'LUMINA50') { discPct = 50; }
  else if (code === 'VIP25') { discPct = 25; }
  else if (code === 'PRIYA12') { discPct = 12; codeName = 'Priya Mehta VIP (12%)'; }
  else if (code === 'RIHAAN15') { discPct = 15; codeName = 'Rihaan Styles VIP (15%)'; }
  else if (code === 'KAVYA10' || code === 'ARJUN10') { discPct = 10; codeName = 'Creator VIP (10%)'; }
  else if (code === 'LUCKY15') { discPct = 15; codeName = 'Lucky Wheel VIP (15%)'; }
  else if (code === 'CASH500') { flatDisc = 500; codeName = '₹500 Cash Voucher'; }
  else if (code === 'FREESHIP') { discPct = 5; codeName = 'Free Priority Express + 5% Off'; }
  else { discPct = 10; codeName = 'VIP Privilege (10%)'; } // friendly fallback for any custom code

  var discountAmount = discPct > 0 ? Math.round(baseInr * (discPct / 100)) : flatDisc;
  if (discountAmount > baseInr) discountAmount = baseInr - 100;
  var finalPrice = Math.max(99, baseInr - discountAmount);

  window.appliedExpressDiscount = discountAmount;
  window.appliedExpressCode = code;

  var priceEl = document.getElementById('ecProductPrice');
  priceEl.innerHTML = '<span class="line-through text-stone-400 text-xs mr-1">₹' + Math.round(baseInr).toLocaleString('en-IN') + '</span> <span class="text-emerald-600">₹' + Math.round(finalPrice).toLocaleString('en-IN') + '</span>';
  
  var discRow = document.getElementById('ecDiscountRow');
  if (discRow) discRow.classList.remove('hidden');
  document.getElementById('ecDiscountLabel').textContent = codeName + ':';
  document.getElementById('ecDiscountAmount').textContent = '-₹' + discountAmount.toLocaleString('en-IN');

  var badge = document.getElementById('ecDiscountBadge');
  if (badge) {
    badge.textContent = '✓ ' + code + ' Applied!';
    badge.classList.remove('hidden');
  }
};

window.handleExpressOrderSubmit = function(e) {
  e.preventDefault();
  var btn = document.getElementById('ecSubmitBtn');
  var btnText = document.getElementById('ecSubmitBtnText');
  btn.disabled = true;
  btnText.textContent = 'Securing Acquisition & Dispatching...';
  
  var variantId = document.getElementById('ecVariantId').value || document.getElementById('ecProductId').value || 1;
  var fullName = document.getElementById('ecFullName').value;
  var phone = document.getElementById('ecPhone').value;
  var address = document.getElementById('ecAddress').value;
  var city = document.getElementById('ecCity').value;
  var pincode = document.getElementById('ecPincode').value;
  var paymentMethod = document.querySelector('input[name="ec_payment"]:checked')?.value || 'cod';
  var size = document.querySelector('input[name="ec_size"]:checked')?.value || 'M';
  var color = document.querySelector('input[name="ec_color"]:checked')?.value || 'Signature Camel';
  var title = document.getElementById('ecProductTitle').textContent || '';
  var price = document.getElementById('ecBaseInr').value || 0;
  var img = document.getElementById('ecProductImg').src || '';

  // Save to localStorage for future frictionless orders
  localStorage.setItem('lumina_saved_shipping', JSON.stringify({ fullName, phone, address, city, pincode }));
  
  // 1. Add to cart via AJAX with size, color, and selected quantity
  var qty = parseInt(document.getElementById('ecQuantity')?.value || 1) || 1;
  var formData = new FormData();
  formData.append('variant_id', variantId);
  formData.append('product_id', variantId);
  formData.append('quantity', qty);
  formData.append('size', size);
  formData.append('color', color);
  formData.append('title', title);
  formData.append('price', price);
  formData.append('image', img);
  formData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
  
  fetch('<?= base_url('cart/add') ?>', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(r => r.json())
    .then(() => {
      // 2. Prepare checkout shipping data
      var names = fullName.split(' ');
      var firstName = names[0] || 'Customer';
      var lastName = names.slice(1).join(' ') || 'Atelier';
      
      var checkoutData = new FormData();
      checkoutData.append('email', (phone.replace(/\D/g, '') || 'collector') + '@lumina-atelier.com');
      checkoutData.append('first_name', firstName);
      checkoutData.append('last_name', lastName);
      checkoutData.append('phone', phone);
      checkoutData.append('address1', address);
      checkoutData.append('city', city);
      checkoutData.append('state', 'State');
      checkoutData.append('pincode', pincode);
      checkoutData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
      
      return fetch('<?= base_url('checkout') ?>', { method: 'POST', body: checkoutData, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    })
    .then(() => {
      // 3. Confirm order directly in-site
      var confirmData = new FormData();
      confirmData.append('payment_method', paymentMethod === 'online' ? 'cod' : 'cod');
      confirmData.append('<?= $this->security->get_csrf_token_name() ?>', '<?= $this->security->get_csrf_hash() ?>');
      
      return fetch('<?= base_url('checkout/confirm') ?>', { method: 'POST', body: confirmData });
    })
    .then(res => {
      if (res.redirected) {
        window.location.href = res.url;
      } else {
        window.location.href = '<?= base_url('checkout') ?>';
      }
    })
    .catch(() => {
      // Fallback: Redirect directly to checkout
      window.location.href = '<?= base_url('checkout') ?>';
    });
};

document.addEventListener('DOMContentLoaded', () => {
  window.updateAllPricesOnPage();
});
</script>

<!-- Hidden Google Translate Element -->
<div id="google_translate_element" style="display:none;"></div>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<main class="flex-grow pt-[96px] sm:pt-[104px] md:pt-[116px]">
