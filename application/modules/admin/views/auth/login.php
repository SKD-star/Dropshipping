<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'Admin Login - NovaDrop') ?></title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" href="<?= base_url('img/blogor.png') ?>" onerror="this.href='<?= base_url('assets/img/blogor.png') ?>'">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
</head>
<body class="light-mode">

    <!-- Dark / Light Mode Toggle Button -->
    <button class="btn-toggle" onclick="toggleMode()" title="Toggle Dark/Light Mode" aria-label="Toggle Theme">
        <i class="fas fa-sun"></i>
    </button>

    <div class="spiral-background"></div>

    <div class="main-container">
        <div class="login-container">
            <div class="mb-3 text-center">
                <img src="<?= base_url('img/blogor.png') ?>" onerror="this.src='<?= base_url('assets/img/blogor.png') ?>'" alt="Logo" style="height: 52px; margin-bottom: 8px;">
                <h2 style="margin-bottom: 4px; font-weight:800; color:#4e73df;">Admin Portal</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem;">NovaDrop Commerce Management</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" style="text-align: left; margin-bottom: 16px;">
                    <i class="fas fa-exclamation-circle mr-1"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success" style="text-align: left; margin-bottom: 16px;">
                    <i class="fas fa-check-circle mr-1"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('admin/login') ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

                <div class="form-group text-left" style="margin-bottom: 16px; text-align: left;">
                    <label style="font-weight: 700; font-size: 0.9rem; margin-bottom: 6px; display: block;">Email or Username</label>
                    <input type="text" name="email" class="form-control" placeholder="admin@novadrop.in" autocomplete="off" required value="<?= htmlspecialchars($email ?? 'admin@novadrop.in') ?>">
                </div>

                <div class="form-group text-left" style="margin-bottom: 20px; text-align: left;">
                    <label style="font-weight: 700; font-size: 0.9rem; margin-bottom: 6px; display: block;">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password (default: admin123)" autocomplete="off" required value="admin123">
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt mr-2"></i> Log In to Dashboard
                </button>

                <p class="login-link mt-4" style="margin-top: 20px; font-size: 0.9rem; color: var(--text-muted);">
                    Default Access: <code>admin@novadrop.in</code> / <code>admin123</code>
                </p>
            </form>
        </div>
    </div>

    <script src="<?= base_url('js/script.js') ?>"></script>
</body>
</html>
