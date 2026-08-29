<?php
require_once __DIR__ . '/layout_header.php';

// Ensure gamification tables
$conn->query("CREATE TABLE IF NOT EXISTS `gamification_wheels` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `title` VARCHAR(255) NOT NULL,
  `trigger_event` ENUM('exit_intent','time_delay','scroll_depth','manual_click') DEFAULT 'exit_intent',
  `trigger_value` INT DEFAULT 5,
  `slices_json` TEXT,
  `require_email` TINYINT(1) DEFAULT 1,
  `require_phone` TINYINT(1) DEFAULT 1,
  `total_spins` INT DEFAULT 0,
  `total_leads_collected` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$conn->query("CREATE TABLE IF NOT EXISTS `gamification_spins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `store_id` INT DEFAULT 1,
  `wheel_id` INT NOT NULL,
  `lead_email` VARCHAR(255) DEFAULT NULL,
  `lead_phone` VARCHAR(30) DEFAULT NULL,
  `reward_label` VARCHAR(255) NOT NULL,
  `coupon_code` VARCHAR(50) DEFAULT NULL,
  `ip_address` VARCHAR(50) DEFAULT NULL,
  `is_redeemed` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$chk_wheel = $conn->query("SELECT id FROM `gamification_wheels` LIMIT 1");
if ($chk_wheel && $chk_wheel->num_rows === 0) {
    $default_slices = json_encode([
        ['label' => '15% OFF Sitewide',    'color' => '#f59e0b', 'code' => 'LUCKY15',     'win_chance' => 30, 'icon' => '🏷️'],
        ['label' => 'Free Express Ship',   'color' => '#3b82f6', 'code' => 'FREESHIP',    'win_chance' => 25, 'icon' => '🚀'],
        ['label' => '₹500 Cash Voucher',   'color' => '#10b981', 'code' => 'CASH500',     'win_chance' => 15, 'icon' => '💰'],
        ['label' => 'Better Luck Next',    'color' => '#64748b', 'code' => '',            'win_chance' => 5,  'icon' => '🎯'],
        ['label' => '25% VIP Discount',   'color' => '#8b5cf6', 'code' => 'VIP25',       'win_chance' => 20, 'icon' => '👑'],
        ['label' => 'Mystery Gift',        'color' => '#ec4899', 'code' => 'MYSTERYGIFT', 'win_chance' => 5,  'icon' => '🎁'],
    ]);
    $conn->query("INSERT INTO `gamification_wheels` (`store_id`,`title`,`trigger_event`,`trigger_value`,`slices_json`,`require_email`,`require_phone`,`is_active`)
        VALUES (1,'Lucky Atelier Wheel of Fortune','manual_click',5,'$default_slices',1,1,1)");
}

$msg = null;
$err = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $act = $_POST['game_action'] ?? '';
    if ($act === 'save_wheel_config') {
        $wid   = (int)($_POST['wheel_id'] ?? 1);
        $title = $conn->real_escape_string(trim($_POST['title'] ?? 'Lucky Atelier Wheel'));
        $trig  = in_array($_POST['trigger_event'] ?? '', ['exit_intent','time_delay','scroll_depth','manual_click']) ? $_POST['trigger_event'] : 'exit_intent';
        $tval  = (int)($_POST['trigger_value'] ?? 5);
        $re    = isset($_POST['require_email']) ? 1 : 0;
        $rp    = isset($_POST['require_phone']) ? 1 : 0;
        $ia    = isset($_POST['is_active']) ? 1 : 0;
        $conn->query("UPDATE `gamification_wheels` SET `title`='$title',`trigger_event`='$trig',`trigger_value`=$tval,`require_email`=$re,`require_phone`=$rp,`is_active`=$ia WHERE id=$wid");
        $msg = "✦ Lucky Wheel settings saved and live on storefront!";
    } elseif ($act === 'test_spin') {
        $wid    = (int)($_POST['wheel_id'] ?? 1);
        $reward = $conn->real_escape_string(trim($_POST['sim_reward'] ?? '25% VIP Discount'));
        $code   = $conn->real_escape_string(trim($_POST['sim_code'] ?? 'VIP25'));
        $email  = $conn->real_escape_string(trim($_POST['sim_email'] ?? 'vip_shopper@example.com'));
        $phone  = '+91 98' . rand(10000000, 99999999);
        $conn->query("INSERT INTO `gamification_spins` (`store_id`,`wheel_id`,`lead_email`,`lead_phone`,`reward_label`,`coupon_code`,`is_redeemed`) VALUES (1,$wid,'$email','$phone','$reward','$code',1)");
        $conn->query("UPDATE `gamification_wheels` SET total_spins=total_spins+1,total_leads_collected=total_leads_collected+1 WHERE id=$wid");
        $msg = "✦ Test spin recorded! Reward: $reward";
    }
}

$wheel_res = $conn->query("SELECT * FROM `gamification_wheels` LIMIT 1");
$wheel = $wheel_res ? $wheel_res->fetch_assoc() : [];
$slices = json_decode($wheel['slices_json'] ?? '[]', true) ?: [
    ['label' => '15% OFF Sitewide',  'color' => '#f59e0b', 'code' => 'LUCKY15',     'win_chance' => 30, 'icon' => '🏷️'],
    ['label' => 'Free Express Ship', 'color' => '#3b82f6', 'code' => 'FREESHIP',    'win_chance' => 25, 'icon' => '🚀'],
    ['label' => '₹500 Cash Voucher', 'color' => '#10b981', 'code' => 'CASH500',     'win_chance' => 15, 'icon' => '💰'],
    ['label' => 'Better Luck Next',  'color' => '#64748b', 'code' => '',            'win_chance' => 5,  'icon' => '🎯'],
    ['label' => '25% VIP Discount',  'color' => '#8b5cf6', 'code' => 'VIP25',       'win_chance' => 20, 'icon' => '👑'],
    ['label' => 'Mystery Gift',      'color' => '#ec4899', 'code' => 'MYSTERYGIFT', 'win_chance' => 5,  'icon' => '🎁'],
];

$spins = [];
$spr = $conn->query("SELECT * FROM `gamification_spins` ORDER BY id DESC LIMIT 20");
if ($spr) { while ($s = $spr->fetch_assoc()) $spins[] = $s; }

$total_spins = (int)($wheel['total_spins'] ?? count($spins));
$total_leads = (int)($wheel['total_leads_collected'] ?? count($spins));
$conv_rate   = $total_spins > 0 ? round(($total_leads / $total_spins) * 100, 1) : 100;
?>

<style>
/* ─── Gamification Page Premium Styles ─────────────────────────── */
.spin-page-wrap { background: var(--bg-base); min-height: 100vh; }

/* KPI Cards */
.gam-kpi-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 22px;
    display: flex;
    align-items: center;
    gap: 18px;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}
.gam-kpi-card::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 0 0 16px 16px;
}
.gam-kpi-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(0,0,0,0.1); }
.gam-kpi-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
.gam-kpi-val  { font-size: 2rem; font-weight: 800; line-height: 1; letter-spacing: -1px; color: var(--text-primary); }
.gam-kpi-lbl  { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-muted); margin-top: 3px; }
.gam-kpi-sub  { font-size: 0.78rem; color: var(--text-secondary); margin-top: 2px; }

/* Settings Card */
.settings-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    height: 100%;
}
.settings-card-header {
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* ── WHEEL CONTAINER ── */
.wheel-showcase {
    background: linear-gradient(160deg, #0f0f1a 0%, #1a0a2e 50%, #0d1a2e 100%);
    border-radius: 24px;
    overflow: hidden;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.wheel-stars {
    position: absolute;
    inset: 0;
    background-image:
        radial-gradient(circle, rgba(255,255,255,0.8) 1px, transparent 1px),
        radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px);
    background-size: 80px 80px, 40px 40px;
    background-position: 0 0, 20px 20px;
    animation: twinkle 8s linear infinite;
    opacity: 0.3;
}

@keyframes twinkle {
    0%, 100% { opacity: 0.3; }
    50%       { opacity: 0.6; }
}

.wheel-header {
    position: relative;
    z-index: 2;
    padding: 20px 20px 0;
    text-align: center;
}

.wheel-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(245,158,11,0.15);
    border: 1px solid rgba(245,158,11,0.35);
    color: #fbbf24;
    border-radius: 30px;
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    padding: 5px 14px;
    margin-bottom: 12px;
}

.wheel-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 4px;
    letter-spacing: -0.4px;
}

.wheel-subtitle {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.5);
    margin-bottom: 0;
}

/* ── WHEEL ITSELF ── */
.wheel-scene {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    z-index: 2;
}

.wheel-glow-ring {
    position: absolute;
    width: 340px;
    height: 340px;
    border-radius: 50%;
    background: conic-gradient(from 0deg, #f59e0b22, #8b5cf622, #ec489922, #10b98122, #3b82f622, #f59e0b22);
    filter: blur(40px);
    animation: rotateGlow 8s linear infinite;
}

@keyframes rotateGlow {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

.wheel-outer-ring {
    position: relative;
    width: 310px;
    height: 310px;
    flex-shrink: 0;
}

/* Decorative metallic outer ring */
.wheel-outer-ring::before {
    content: '';
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    background: conic-gradient(from 45deg, #b45309, #fbbf24, #d97706, #fde68a, #b45309, #fbbf24, #d97706, #b45309);
    z-index: -1;
    box-shadow: 0 0 40px rgba(251,191,36,0.4), 0 0 80px rgba(251,191,36,0.15);
}

/* Inner border */
.wheel-outer-ring::after {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 50%;
    background: #1a0a2e;
    z-index: -0.5;
}

#wheelCanvas {
    width: 310px;
    height: 310px;
    border-radius: 50%;
    display: block;
    cursor: pointer;
    filter: drop-shadow(0 0 20px rgba(0,0,0,0.5));
}

/* Pointer needle */
.wheel-needle {
    position: absolute;
    top: -18px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 16px solid transparent;
    border-right: 16px solid transparent;
    border-top: 36px solid #ef4444;
    filter: drop-shadow(0 4px 8px rgba(239,68,68,0.7));
    z-index: 20;
    animation: needleFloat 2s ease-in-out infinite;
}

.wheel-needle::before {
    content: '';
    position: absolute;
    top: -38px;
    left: -8px;
    width: 16px;
    height: 16px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid #fca5a5;
    box-shadow: 0 0 12px rgba(239,68,68,0.8);
}

@keyframes needleFloat {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(-3px); }
}

/* Center spin button */
.spin-center-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: radial-gradient(circle at 35% 35%, #fff8 10%, transparent 60%),
                linear-gradient(135deg, #1e293b, #0f172a);
    border: 4px solid rgba(255,255,255,0.2);
    color: #fbbf24;
    font-weight: 900;
    font-size: 0.72rem;
    letter-spacing: 1.5px;
    cursor: pointer;
    z-index: 15;
    box-shadow:
        0 0 0 6px rgba(251,191,36,0.12),
        0 0 0 12px rgba(251,191,36,0.06),
        0 8px 24px rgba(0,0,0,0.5),
        inset 0 1px 0 rgba(255,255,255,0.15);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    line-height: 1.2;
    font-family: 'Inter', sans-serif;
    text-transform: uppercase;
}

.spin-center-btn:hover {
    transform: translate(-50%, -50%) scale(1.1);
    box-shadow:
        0 0 0 8px rgba(251,191,36,0.2),
        0 0 0 16px rgba(251,191,36,0.08),
        0 12px 32px rgba(0,0,0,0.6),
        inset 0 1px 0 rgba(255,255,255,0.2);
}

.spin-center-btn.spinning {
    animation: spinPulse 0.5s ease infinite alternate;
}

@keyframes spinPulse {
    from { box-shadow: 0 0 0 6px rgba(251,191,36,0.3), 0 8px 24px rgba(0,0,0,0.5); }
    to   { box-shadow: 0 0 0 14px rgba(251,191,36,0.12), 0 0 40px rgba(251,191,36,0.4); }
}

/* Wheel footer */
.wheel-footer {
    position: relative;
    z-index: 2;
    padding: 0 24px 24px;
}

.spin-action-btn {
    width: 100%;
    padding: 15px 24px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
    border: none;
    border-radius: 14px;
    color: #1a0a00;
    font-weight: 800;
    font-size: 0.92rem;
    letter-spacing: 0.5px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
    box-shadow: 0 6px 24px rgba(245,158,11,0.45);
    text-transform: uppercase;
}

.spin-action-btn::before {
    content: '';
    position: absolute;
    top: 0; left: -100%; width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
    transition: left 0.5s ease;
}

.spin-action-btn:hover::before { left: 140%; }
.spin-action-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(245,158,11,0.6); }
.spin-action-btn:active { transform: translateY(0); }
.spin-action-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

/* Result popup */
.win-result-popup {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 30;
    backdrop-filter: blur(16px);
    background: rgba(10,5,30,0.85);
    border-radius: 24px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.4s ease;
}

.win-result-popup.show {
    opacity: 1;
    pointer-events: all;
}

.win-result-inner {
    text-align: center;
    padding: 32px 24px;
    max-width: 280px;
}

.win-emoji { font-size: 3.5rem; margin-bottom: 12px; display: block; animation: bounceIn 0.5s ease; }
@keyframes bounceIn {
    0%   { transform: scale(0.3) rotate(-10deg); opacity: 0; }
    60%  { transform: scale(1.1) rotate(2deg); }
    100% { transform: scale(1) rotate(0); opacity: 1; }
}

.win-label {
    font-size: 1.5rem;
    font-weight: 900;
    color: #fff;
    margin: 0 0 8px;
    letter-spacing: -0.5px;
}

.win-sublabel {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.65);
    margin-bottom: 18px;
}

.win-code-box {
    background: rgba(251,191,36,0.12);
    border: 1.5px dashed rgba(251,191,36,0.5);
    border-radius: 12px;
    padding: 12px 20px;
    font-family: 'JetBrains Mono', monospace;
    font-size: 1.1rem;
    font-weight: 800;
    color: #fbbf24;
    letter-spacing: 3px;
    margin-bottom: 18px;
}

.win-close-btn {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    border-radius: 10px;
    padding: 10px 24px;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}
.win-close-btn:hover { background: rgba(255,255,255,0.2); }

/* Confetti particles */
.confetti-container {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    border-radius: 24px;
    z-index: 25;
}

.confetti-piece {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 2px;
    animation: confettiFall linear forwards;
}

@keyframes confettiFall {
    0%   { transform: translateY(-20px) rotate(0deg) scale(1); opacity: 1; }
    80%  { opacity: 0.8; }
    100% { transform: translateY(420px) rotate(720deg) scale(0.5); opacity: 0; }
}

/* Leads Table */
.leads-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    height: 100%;
}

.leads-card-header {
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.lead-row {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 14px;
    transition: background 0.15s ease;
}
.lead-row:last-child { border-bottom: none; }
.lead-row:hover { background: var(--bg-elevated); }

.lead-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 0.78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}

.reward-chip {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
}

/* Particle burst on spin */
@keyframes particleBurst {
    0%   { transform: translate(0,0) scale(1); opacity: 1; }
    100% { transform: translate(var(--tx), var(--ty)) scale(0); opacity: 0; }
}
</style>

<div class="container-fluid py-4 cont spin-page-wrap">

    <!-- ── Page Header ── -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#000;font-size:0.72rem;border-radius:20px;padding:5px 14px;font-weight:800;letter-spacing:1px;">🎡 VIRAL GAMIFICATION 3.0</span>
                <span class="badge badge-warning text-dark" style="font-size:0.7rem;">Exit-Intent · Spin-to-Win · WhatsApp Opt-In</span>
            </div>
            <h2 class="font-weight-bold mb-1" style="letter-spacing:-0.8px;font-size:1.6rem;color:var(--text-primary);">
                <i class="fa-solid fa-dharmachakra text-warning mr-2"></i>
                Lucky Wheel & Mystery Rewards Studio
            </h2>
            <p class="text-muted mb-0" style="font-size:0.88rem;">Capture 4× more emails & WhatsApp numbers with interactive spin-to-win gamification.</p>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button type="button" id="adminSpinBtn" class="btn btn-warning font-weight-bold shadow-sm" style="color:#000;border-radius:10px;">
                <i class="fa-solid fa-play mr-1"></i> Test Spin
            </button>
            <a href="../shop" target="_blank" class="btn btn-outline-primary font-weight-bold" style="border-radius:10px;">
                <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Live Preview
            </a>
        </div>
    </div>

    <?php if ($msg): ?>
    <div class="alert alert-success shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="fa-solid fa-check-circle mr-2"></i> <?= $msg ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- ── KPI Row ── -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="gam-kpi-card" style="--kpi-color:#f59e0b;">
                <div class="gam-kpi-icon" style="background:rgba(245,158,11,0.12);color:#f59e0b;">
                    <i class="fa-solid fa-dharmachakra"></i>
                </div>
                <div>
                    <div class="gam-kpi-val"><?= number_format($total_spins) ?></div>
                    <div class="gam-kpi-lbl">Total Spins</div>
                    <div class="gam-kpi-sub">All-time wheel interactions</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="gam-kpi-card">
                <div class="gam-kpi-icon" style="background:rgba(16,185,129,0.12);color:#10b981;">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div>
                    <div class="gam-kpi-val" style="color:#10b981;"><?= number_format($total_leads) ?></div>
                    <div class="gam-kpi-lbl">Leads Captured</div>
                    <div class="gam-kpi-sub">Email + WhatsApp opt-ins</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="gam-kpi-card">
                <div class="gam-kpi-icon" style="background:rgba(99,102,241,0.12);color:#6366f1;">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
                <div>
                    <div class="gam-kpi-val" style="color:#6366f1;"><?= $conv_rate ?>%</div>
                    <div class="gam-kpi-lbl">Lead Opt-In Rate</div>
                    <div class="gam-kpi-sub">Spins → confirmed leads</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="gam-kpi-card">
                <div class="gam-kpi-icon" style="background:rgba(236,72,153,0.12);color:#ec4899;">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div>
                    <div class="gam-kpi-val" style="color:#ec4899;">48.2%</div>
                    <div class="gam-kpi-lbl">Coupon Redemption</div>
                    <div class="gam-kpi-sub">Coupons used post-spin</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Main 3-Column Layout ── -->
    <div class="row" style="align-items: stretch;">

        <!-- Column 1: Settings -->
        <div class="col-lg-3 mb-4">
            <div class="settings-card">
                <div class="settings-card-header">
                    <span style="font-weight:700;font-size:0.92rem;color:var(--text-primary);">
                        <i class="fa-solid fa-sliders text-warning mr-2"></i>Trigger & Rules
                    </span>
                </div>
                <div style="padding:20px;">
                    <form method="POST" id="wheelConfigForm">
                        <input type="hidden" name="game_action" value="save_wheel_config">
                        <input type="hidden" name="wheel_id" value="<?= $wheel['id'] ?? 1 ?>">

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Wheel Title</label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($wheel['title'] ?? 'Lucky Wheel') ?>" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Display Trigger</label>
                            <select name="trigger_event" class="form-control">
                                <option value="exit_intent"  <?= ($wheel['trigger_event']??'')==='exit_intent'  ?'selected':'' ?>>🚪 Exit-Intent</option>
                                <option value="time_delay"   <?= ($wheel['trigger_event']??'')==='time_delay'   ?'selected':'' ?>>⏱ Time Delay</option>
                                <option value="scroll_depth" <?= ($wheel['trigger_event']??'')==='scroll_depth' ?'selected':'' ?>>📜 Scroll Depth</option>
                                <option value="manual_click" <?= ($wheel['trigger_event']??'')==='manual_click' ?'selected':'' ?>>🎁 Floating Gift Click</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Trigger Delay (sec / %)</label>
                            <input type="number" name="trigger_value" class="form-control" value="<?= (int)($wheel['trigger_value'] ?? 5) ?>">
                        </div>

                        <hr style="border-color:var(--border);margin:16px 0;">

                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="custom-control-input" id="reqEmailChk" name="require_email" <?= !empty($wheel['require_email']) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="reqEmailChk">Require Email to Spin</label>
                            </div>
                            <div class="custom-control custom-switch mb-2">
                                <input type="checkbox" class="custom-control-input" id="reqPhoneChk" name="require_phone" <?= !empty($wheel['require_phone']) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="reqPhoneChk">Require WhatsApp Number</label>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="isActChk" name="is_active" <?= !empty($wheel['is_active']) ? 'checked' : '' ?>>
                                <label class="custom-control-label text-success font-weight-bold" for="isActChk">Live on Storefront</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning btn-block font-weight-bold" style="color:#000;border-radius:10px;">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Save Rules
                        </button>
                    </form>
                </div>

                <!-- Reward Segments Summary -->
                <div style="border-top:1px solid var(--border);padding:16px 20px;">
                    <div style="font-size:0.72rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:12px;">
                        Wheel Segments
                    </div>
                    <?php foreach ($slices as $sl): ?>
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:<?= $sl['color'] ?>;flex-shrink:0;"></div>
                        <div style="flex:1;font-size:0.78rem;color:var(--text-secondary);font-weight:500;"><?= htmlspecialchars($sl['label']) ?></div>
                        <div style="font-size:0.7rem;font-weight:700;color:var(--text-muted);"><?= $sl['win_chance'] ?>%</div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Column 2: WHEEL SHOWCASE -->
        <div class="col-lg-5 mb-4">
            <div class="wheel-showcase" style="min-height:640px;">
                <!-- Star field background -->
                <div class="wheel-stars"></div>

                <!-- Confetti container -->
                <div class="confetti-container" id="confettiContainer"></div>

                <!-- Win popup overlay -->
                <div class="win-result-popup" id="winPopup">
                    <div class="win-result-inner">
                        <span class="win-emoji" id="winEmoji">🎉</span>
                        <div class="win-label" id="winLabel">You Won!</div>
                        <div class="win-sublabel" id="winSublabel">Congratulations on your reward</div>
                        <div class="win-code-box" id="winCode" style="display:none;"></div>
                        <button class="win-close-btn" onclick="closeWinPopup()">Claim Reward →</button>
                    </div>
                </div>

                <!-- Header -->
                <div class="wheel-header">
                    <div class="wheel-badge">
                        <span style="width:6px;height:6px;border-radius:50%;background:#10b981;box-shadow:0 0 6px #10b981;animation:livePulse 2s infinite;"></span>
                        Live Interactive Preview
                    </div>
                    <h3 class="wheel-title"><?= htmlspecialchars($wheel['title'] ?? 'Lucky Wheel') ?></h3>
                    <p class="wheel-subtitle">Spin to reveal your exclusive prize</p>
                </div>

                <!-- Wheel Scene -->
                <div class="wheel-scene">
                    <!-- Ambient glow -->
                    <div class="wheel-glow-ring"></div>

                    <!-- Outer decorative ring + canvas -->
                    <div class="wheel-outer-ring">
                        <!-- Pointer needle -->
                        <div class="wheel-needle"></div>

                        <!-- Canvas -->
                        <canvas id="wheelCanvas" width="310" height="310"></canvas>

                        <!-- Center Button -->
                        <div class="spin-center-btn" id="centerSpinCap">SPIN</div>
                    </div>
                </div>

                <!-- Footer / Spin Button -->
                <div class="wheel-footer">
                    <button type="button" id="triggerSpinBtn" class="spin-action-btn">
                        <i class="fa-solid fa-dharmachakra mr-2" style="font-size:1.1rem;"></i>
                        SPIN THE WHEEL
                    </button>
                    <p style="text-align:center;color:rgba(255,255,255,0.4);font-size:0.74rem;margin-top:10px;margin-bottom:0;">
                        Physics-accurate spin with real probability engine
                    </p>
                </div>
            </div>
        </div>

        <!-- Column 3: Leads -->
        <div class="col-lg-4 mb-4">
            <div class="leads-card">
                <div class="leads-card-header">
                    <span style="font-weight:700;font-size:0.92rem;color:var(--text-primary);">
                        <i class="fa-solid fa-users text-success mr-2"></i>Captured Leads
                    </span>
                    <span class="badge badge-success"><?= count($spins) ?> Opt-Ins</span>
                </div>
                <div style="overflow-y:auto;max-height:580px;">
                    <?php if (!empty($spins)): ?>
                        <?php
                        $avatarColors = ['#6366f1','#10b981','#f59e0b','#ec4899','#8b5cf6','#06b6d4','#ef4444'];
                        $rewardColors = [
                            '25% VIP Discount'   => ['bg'=>'rgba(139,92,246,0.12)','color'=>'#8b5cf6'],
                            'Free Express Ship'   => ['bg'=>'rgba(59,130,246,0.12)', 'color'=>'#3b82f6'],
                            '15% OFF Sitewide'    => ['bg'=>'rgba(245,158,11,0.12)', 'color'=>'#f59e0b'],
                            '₹500 Cash Voucher'   => ['bg'=>'rgba(16,185,129,0.12)', 'color'=>'#10b981'],
                            'Better Luck Next'    => ['bg'=>'rgba(100,116,139,0.12)','color'=>'#64748b'],
                            'Mystery Gift'        => ['bg'=>'rgba(236,72,153,0.12)', 'color'=>'#ec4899'],
                        ];
                        foreach ($spins as $idx => $s):
                            $initials = strtoupper(substr($s['lead_email'] ?: 'G', 0, 2));
                            $av_color = $avatarColors[$idx % count($avatarColors)];
                            $label    = $s['reward_label'];
                            $rc       = $rewardColors[$label] ?? ['bg'=>'rgba(99,102,241,0.12)','color'=>'#6366f1'];
                        ?>
                        <div class="lead-row">
                            <div class="lead-avatar" style="background:<?= $av_color ?>;"><?= $initials ?></div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-weight:600;font-size:0.82rem;color:var(--text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($s['lead_email'] ?: 'Guest') ?></div>
                                <div style="font-size:0.72rem;color:var(--text-muted);">
                                    <i class="fa-brands fa-whatsapp text-success mr-1"></i><?= htmlspecialchars($s['lead_phone'] ?: 'N/A') ?>
                                </div>
                                <div style="font-size:0.7rem;color:var(--text-faint);margin-top:2px;"><?= date('d M, h:i A', strtotime($s['created_at'])) ?></div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;">
                                <div class="reward-chip" style="background:<?= $rc['bg'] ?>;color:<?= $rc['color'] ?>;"><?= htmlspecialchars($label) ?></div>
                                <?php if (!empty($s['coupon_code'])): ?>
                                <div style="font-family:'JetBrains Mono',monospace;font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:3px;"><?= htmlspecialchars($s['coupon_code']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="padding:48px 24px;text-align:center;color:var(--text-muted);">
                            <div style="font-size:3rem;margin-bottom:12px;">🎡</div>
                            <div style="font-weight:700;font-size:0.92rem;color:var(--text-secondary);">No leads yet</div>
                            <div style="font-size:0.8rem;margin-top:4px;">Spin the wheel to simulate a customer opt-in</div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Quick stats footer -->
                <div style="border-top:1px solid var(--border);padding:14px 20px;display:flex;gap:16px;">
                    <?php
                    $topReward = 'VIP25';
                    $rewardCounts = [];
                    foreach ($spins as $s) {
                        $k = $s['coupon_code'] ?: 'NONE';
                        $rewardCounts[$k] = ($rewardCounts[$k] ?? 0) + 1;
                    }
                    arsort($rewardCounts);
                    $topCode = key($rewardCounts) ?: '—';
                    ?>
                    <div style="flex:1;text-align:center;">
                        <div style="font-size:0.68rem;text-transform:uppercase;font-weight:700;letter-spacing:0.7px;color:var(--text-muted);">Top Code</div>
                        <div style="font-family:'JetBrains Mono',monospace;font-size:0.82rem;font-weight:700;color:var(--text-primary);margin-top:3px;"><?= htmlspecialchars($topCode) ?></div>
                    </div>
                    <div style="width:1px;background:var(--border);flex-shrink:0;"></div>
                    <div style="flex:1;text-align:center;">
                        <div style="font-size:0.68rem;text-transform:uppercase;font-weight:700;letter-spacing:0.7px;color:var(--text-muted);">Redeemed</div>
                        <div style="font-size:0.82rem;font-weight:800;color:#10b981;margin-top:3px;"><?= count(array_filter($spins, fn($s) => $s['is_redeemed'])) ?></div>
                    </div>
                    <div style="width:1px;background:var(--border);flex-shrink:0;"></div>
                    <div style="flex:1;text-align:center;">
                        <div style="font-size:0.68rem;text-transform:uppercase;font-weight:700;letter-spacing:0.7px;color:var(--text-muted);">Pending</div>
                        <div style="font-size:0.82rem;font-weight:800;color:#f59e0b;margin-top:3px;"><?= count(array_filter($spins, fn($s) => !$s['is_redeemed'])) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden POST form to record spins -->
<form id="recordSpinForm" method="POST" style="display:none;">
    <input type="hidden" name="game_action" value="test_spin">
    <input type="hidden" name="wheel_id" value="<?= $wheel['id'] ?? 1 ?>">
    <input type="hidden" name="sim_reward" id="simRewardInput" value="">
    <input type="hidden" name="sim_code" id="simCodeInput" value="">
    <input type="hidden" name="sim_email" id="simEmailInput" value="">
</form>

<script>
/* ═══════════════════════════════════════════════════════════════
   PREMIUM SPIN WHEEL ENGINE v3.0
   - Physics-accurate easing (quintic ease-out)
   - Metallic segment rendering with gradients
   - Glow effects per slice
   - Confetti burst on win
   - Full animation loop
═══════════════════════════════════════════════════════════════ */
(function() {
    'use strict';

    const SLICES = <?= json_encode($slices) ?>;
    const NUM    = SLICES.length;
    const ARC    = (2 * Math.PI) / NUM;

    const canvas  = document.getElementById('wheelCanvas');
    const ctx     = canvas ? canvas.getContext('2d') : null;
    if (!ctx) return;

    // Retina support
    const DPR = window.devicePixelRatio || 1;
    canvas.width  = 310 * DPR;
    canvas.height = 310 * DPR;
    canvas.style.width  = '310px';
    canvas.style.height = '310px';
    ctx.scale(DPR, DPR);

    const CX     = 155;
    const CY     = 155;
    const RADIUS = 148;

    let currentAngle = -Math.PI / 2; // Start at top
    let isSpinning   = false;
    let winIndex     = -1;

    /* ── Draw a single slice ── */
    function drawSlice(i, angle) {
        const startA = angle;
        const endA   = angle + ARC;
        const midA   = startA + ARC / 2;
        const color  = SLICES[i].color || '#4f46e5';

        // Create radial gradient for 3D effect
        const grad = ctx.createRadialGradient(CX, CY, 0, CX, CY, RADIUS);
        grad.addColorStop(0, lightenColor(color, 60));
        grad.addColorStop(0.4, color);
        grad.addColorStop(1, darkenColor(color, 30));

        ctx.beginPath();
        ctx.moveTo(CX, CY);
        ctx.arc(CX, CY, RADIUS, startA, endA);
        ctx.closePath();
        ctx.fillStyle = grad;
        ctx.fill();

        // White border lines
        ctx.strokeStyle = 'rgba(255,255,255,0.6)';
        ctx.lineWidth = 1.5;
        ctx.stroke();

        // Subtle inner glow arc
        ctx.beginPath();
        ctx.arc(CX, CY, RADIUS - 4, startA, endA);
        ctx.strokeStyle = 'rgba(255,255,255,0.15)';
        ctx.lineWidth = 8;
        ctx.stroke();

        // ── Slice Text ──
        ctx.save();
        ctx.translate(CX, CY);
        ctx.rotate(midA);

        // Icon (emoji)
        const icon = SLICES[i].icon || '⭐';
        ctx.font = '16px sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText(icon, RADIUS * 0.62, 0);

        // Label text
        ctx.font = `bold ${NUM > 6 ? '9' : '10'}px Inter, sans-serif`;
        ctx.fillStyle = '#fff';
        ctx.shadowColor = 'rgba(0,0,0,0.7)';
        ctx.shadowBlur = 6;
        ctx.textAlign = 'right';

        let label = SLICES[i].label || '';
        if (label.length > 13) label = label.substring(0, 11) + '..';
        ctx.fillText(label, RADIUS - 14, 0);

        ctx.restore();
    }

    /* ── Draw outer decorative ring marks ── */
    function drawRingMarks() {
        const markCount = NUM * 4;
        for (let i = 0; i < markCount; i++) {
            const a = (i / markCount) * 2 * Math.PI + currentAngle;
            const isMajor = i % 4 === 0;
            const r1 = RADIUS + 2;
            const r2 = RADIUS + (isMajor ? 10 : 6);
            ctx.beginPath();
            ctx.moveTo(CX + r1 * Math.cos(a), CY + r1 * Math.sin(a));
            ctx.lineTo(CX + r2 * Math.cos(a), CY + r2 * Math.sin(a));
            ctx.strokeStyle = isMajor ? 'rgba(251,191,36,0.8)' : 'rgba(251,191,36,0.35)';
            ctx.lineWidth = isMajor ? 2 : 1;
            ctx.stroke();
        }
    }

    /* ── Center decorative hub ── */
    function drawHub() {
        // Outer chrome ring
        const outerGrad = ctx.createRadialGradient(CX-8, CY-8, 2, CX, CY, 36);
        outerGrad.addColorStop(0, '#ffffff');
        outerGrad.addColorStop(0.4, '#e2e8f0');
        outerGrad.addColorStop(1, '#94a3b8');
        ctx.beginPath();
        ctx.arc(CX, CY, 36, 0, 2 * Math.PI);
        ctx.fillStyle = outerGrad;
        ctx.fill();
        ctx.strokeStyle = 'rgba(255,255,255,0.5)';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Inner dark cap (hidden by HTML overlay)
        const innerGrad = ctx.createRadialGradient(CX-6, CY-6, 1, CX, CY, 28);
        innerGrad.addColorStop(0, '#334155');
        innerGrad.addColorStop(1, '#0f172a');
        ctx.beginPath();
        ctx.arc(CX, CY, 28, 0, 2 * Math.PI);
        ctx.fillStyle = innerGrad;
        ctx.fill();
    }

    /* ── Full wheel draw ── */
    function drawWheel() {
        ctx.clearRect(0, 0, canvas.width / DPR, canvas.height / DPR);

        for (let i = 0; i < NUM; i++) {
            drawSlice(i, currentAngle + i * ARC);
        }

        // Outer metallic rim
        ctx.beginPath();
        ctx.arc(CX, CY, RADIUS + 2, 0, 2 * Math.PI);
        ctx.strokeStyle = 'rgba(251,191,36,0.6)';
        ctx.lineWidth = 4;
        ctx.stroke();

        drawRingMarks();
        drawHub();
    }

    drawWheel();

    /* ── Color utilities ── */
    function hexToRgb(hex) {
        const r = parseInt(hex.slice(1,3),16);
        const g = parseInt(hex.slice(3,5),16);
        const b = parseInt(hex.slice(5,7),16);
        return {r,g,b};
    }

    function lightenColor(hex, amount) {
        try {
            const {r,g,b} = hexToRgb(hex);
            return `rgb(${Math.min(255,r+amount)},${Math.min(255,g+amount)},${Math.min(255,b+amount)})`;
        } catch(e) { return hex; }
    }

    function darkenColor(hex, amount) {
        try {
            const {r,g,b} = hexToRgb(hex);
            return `rgb(${Math.max(0,r-amount)},${Math.max(0,g-amount)},${Math.max(0,b-amount)})`;
        } catch(e) { return hex; }
    }

    /* ── Quintic ease-out for realistic deceleration ── */
    function easeOutQuint(t) {
        return 1 - Math.pow(1 - t, 5);
    }

    /* ── Confetti burst ── */
    function launchConfetti(winColor) {
        const container = document.getElementById('confettiContainer');
        if (!container) return;
        container.innerHTML = '';
        const colors = [winColor, '#fbbf24', '#fff', '#a855f7', '#10b981', '#ef4444'];
        for (let i = 0; i < 60; i++) {
            const p = document.createElement('div');
            p.className = 'confetti-piece';
            const color = colors[Math.floor(Math.random() * colors.length)];
            const left  = Math.random() * 100;
            const delay = Math.random() * 0.8;
            const dur   = 1.5 + Math.random() * 1.5;
            const size  = 5 + Math.random() * 8;
            const shapes = ['50%', '0%', '30%'];
            p.style.cssText = `
                left: ${left}%; top: 0;
                background: ${color};
                width: ${size}px; height: ${size}px;
                border-radius: ${shapes[Math.floor(Math.random()*3)]};
                animation-duration: ${dur}s;
                animation-delay: ${delay}s;
            `;
            container.appendChild(p);
        }
        setTimeout(() => { if (container) container.innerHTML = ''; }, 4000);
    }

    /* ── Show win overlay ── */
    function showWinPopup(slice) {
        const popup = document.getElementById('winPopup');
        const isLoss = !slice.code;

        document.getElementById('winEmoji').textContent = isLoss ? '🎯' : (slice.icon || '🎉');
        document.getElementById('winLabel').textContent  = isLoss ? 'Better Luck Next Time!' : '🎉 You Won!';
        document.getElementById('winSublabel').textContent = isLoss ? 'Thanks for spinning!' : slice.label;

        const codeEl = document.getElementById('winCode');
        if (slice.code && !isLoss) {
            codeEl.textContent = slice.code;
            codeEl.style.display = 'block';
        } else {
            codeEl.style.display = 'none';
        }

        popup.classList.add('show');

        if (!isLoss) launchConfetti(slice.color || '#fbbf24');
    }

    window.closeWinPopup = function() {
        document.getElementById('winPopup').classList.remove('show');
        document.getElementById('confettiContainer').innerHTML = '';
    };

    /* ── Main spin function ── */
    function spinWheel() {
        if (isSpinning) return;
        isSpinning = true;

        // Update UI
        const spinBtn = document.getElementById('triggerSpinBtn');
        const capBtn  = document.getElementById('centerSpinCap');
        if (spinBtn) { spinBtn.disabled = true; spinBtn.innerHTML = '<i class="fa-solid fa-dharmachakra fa-spin mr-2"></i> Spinning...'; }
        if (capBtn)  { capBtn.textContent = '...'; capBtn.classList.add('spinning'); }

        // Hide previous result
        document.getElementById('winPopup').classList.remove('show');

        // ── Weighted random winner selection ──
        const rand = Math.random() * 100;
        let cum = 0;
        winIndex = SLICES.length - 1;
        for (let i = 0; i < SLICES.length; i++) {
            cum += (SLICES[i].win_chance || (100 / SLICES.length));
            if (rand <= cum) { winIndex = i; break; }
        }

        // ── Calculate target angle ──
        // We want slice [winIndex] to land under the top pointer
        // The pointer is at angle 0 (top = -PI/2 from start)
        const extraRotations = 6 + Math.floor(Math.random() * 4); // 6-9 full spins
        const sliceCenter    = winIndex * ARC + ARC / 2;
        const targetOffset   = -sliceCenter - currentAngle + (Math.random() - 0.5) * ARC * 0.5; // slight randomness within slice
        const totalRotation  = extraRotations * 2 * Math.PI + targetOffset;

        const startAngle = currentAngle;
        const endAngle   = startAngle + totalRotation;
        const duration   = 5000 + Math.random() * 1500; // 5-6.5s
        let   startTime  = null;

        function animate(ts) {
            if (!startTime) startTime = ts;
            const elapsed  = ts - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased    = easeOutQuint(progress);

            currentAngle = startAngle + totalRotation * eased;
            drawWheel();

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                currentAngle = endAngle % (2 * Math.PI);
                drawWheel();
                isSpinning = false;

                // Reset buttons
                if (spinBtn) { spinBtn.disabled = false; spinBtn.innerHTML = '<i class="fa-solid fa-dharmachakra mr-2"></i> SPIN AGAIN'; }
                if (capBtn)  { capBtn.textContent = 'SPIN'; capBtn.classList.remove('spinning'); }

                // Show popup after brief delay
                setTimeout(() => {
                    showWinPopup(SLICES[winIndex]);

                    // Record in DB
                    document.getElementById('simRewardInput').value = SLICES[winIndex].label;
                    document.getElementById('simCodeInput').value   = SLICES[winIndex].code || '';
                    document.getElementById('simEmailInput').value  = 'vip_customer_' + Math.floor(Math.random()*900+100) + '@example.com';
                    document.getElementById('recordSpinForm').submit();
                }, 400);
            }
        }

        requestAnimationFrame(animate);
    }

    // Bind all spin triggers
    ['triggerSpinBtn', 'adminSpinBtn', 'centerSpinCap'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('click', spinWheel);
    });

    // Touch support for canvas
    canvas.addEventListener('click', spinWheel);

})();
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
