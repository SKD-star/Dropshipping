<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'NovaDrop Commerce · Admin Dashboard') ?></title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" href="<?= base_url('img/blogor.png') ?>" onerror="this.href='<?= base_url('assets/img/blogor.png') ?>'">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
</head>
<body class="<?= isset($_SESSION['mode']) ? $_SESSION['mode'] : 'light-mode' ?>">

<!-- Top Navigation Bar -->
<?php
$seg2 = $this->uri->segment(2) ?: 'dashboard';
$seg3 = $this->uri->segment(3) ?: '';
?>
<div class="navbar custom-navbar nauk">
    <div class="ty">
        <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>" style="display:flex;align-items:center;gap:10px;">
            <img src="<?= base_url('img/blogor.png') ?>" onerror="this.src='<?= base_url('assets/img/blogor.png') ?>'" alt="Logo" class="logo-left" style="height:36px;">
            <span style="font-size: 1.3rem; font-weight: 800; color: #4e73df; letter-spacing: 0.5px;">NOVADROP</span>
        </a>
        <button class="custom-navbar-toggler" id="hamburger-icon" onclick="toggleNavbar()" aria-label="Toggle navigation">
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
        </button>
    </div>
    <div class="custom-navbar-collapse" id="navbar-nav">
        <ul class="custom-navbar-nav">
            <li class="nav-item <?= ($seg2 === 'dashboard') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/dashboard') ?>"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="nav-item <?= in_array($seg2, ['products']) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/products') ?>"><i class="fa fa-shopping-bag"></i> Products</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'vendors') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/vendors') ?>"><i class="fa fa-store"></i> Vendors</a>
            </li>
            <li class="nav-item <?= in_array($seg2, ['customers']) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/customers') ?>"><i class="fa fa-users"></i> Users</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'orders') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/orders') ?>"><i class="fa fa-shopping-cart"></i> Orders</a>
            </li>
            <li class="nav-item <?= in_array($seg2, ['finance', 'payments']) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/finance') ?>"><i class="fa fa-credit-card"></i> Payments</a>
            </li>
            <!-- ── Marketing & Promotions ── -->
            <li class="nav-item <?= ($seg2 === 'marketing') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/marketing') ?>"><i class="fa fa-tag"></i> Marketing</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'promotions') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/promotions') ?>"><i class="fa fa-bolt"></i> Promos</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'loyalty') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/loyalty') ?>"><i class="fa fa-star"></i> Loyalty</a>
            </li>
            <!-- ── AI & Growth ── -->
            <li class="nav-item <?= ($seg2 === 'ai_engine') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/ai_engine') ?>"><i class="fa fa-robot"></i> AI</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'affiliates') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/affiliates') ?>"><i class="fa fa-handshake"></i> Affiliates</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'subscriptions') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/subscriptions') ?>"><i class="fa fa-repeat"></i> Subs</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'cart_recovery') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/cart_recovery') ?>"><i class="fa fa-undo"></i> Recovery</a>
            </li>
            <!-- ── System ── -->
            <li class="nav-item <?= in_array($seg2, ['analytics', 'reports']) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/analytics') ?>"><i class="fa fa-chart-bar"></i> Reports</a>
            </li>
            <li class="nav-item <?= in_array($seg2, ['whatsapp', 'tickets']) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/whatsapp') ?>"><i class="fa fa-headphones"></i> Tickets</a>
            </li>
            <li class="nav-item <?= in_array($seg2, ['audit', 'activity']) ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/audit') ?>"><i class="fa fa-history"></i> Activity</a>
            </li>
            <li class="nav-item <?= ($seg2 === 'settings') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/settings') ?>"><i class="fa fa-cog"></i> Settings</a>
            </li>
        </ul>

        <ul class="custom-navbar-nav ml-auto">
            <li class="nav-item">
                <button class="btn btn-sm btn-outline-secondary me-2" onclick="toggleMode()" style="border-radius:20px;padding:5px 12px;margin-right:10px;" title="Toggle Dark/Light Mode">
                    🌓 Mode
                </button>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/logout') ?>" class="nav-link text-danger" style="font-weight:700;">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<main class="nd-main-wrap">
  <?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success">
    <i class="fa fa-check-circle mr-1"></i>
    <span><?= htmlspecialchars($this->session->flashdata('success')) ?></span>
  </div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger">
    <i class="fa fa-exclamation-circle mr-1"></i>
    <span><?= htmlspecialchars($this->session->flashdata('error')) ?></span>
  </div>
  <?php endif; ?>
