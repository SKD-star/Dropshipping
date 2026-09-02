<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($title ?? 'Admin Login — NovaDrop') ?></title>
<meta name="robots" content="noindex, nofollow">
<link rel="icon" href="<?= base_url('img/blogor.png') ?>" onerror="this.href='<?= base_url('assets/img/blogor.png') ?>'">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --bg-body: #f4f6fc;
        --card-bg: #ffffff;
        --text-primary: #1e293b;
        --text-muted: #64748b;
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --border-color: #e2e8f0;
    }
    body {
        background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 50%, #e0e7ff 100%);
        font-family: 'Inter', -apple-system, sans-serif;
        color: var(--text-primary);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 20px;
    }
    .login-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(79, 70, 229, 0.08), 0 1px 3px rgba(0,0,0,0.05);
        max-width: 440px;
        width: 100%;
        padding: 40px 36px;
        position: relative;
        overflow: hidden;
    }
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #4f46e5, #818cf8, #c084fc);
    }
    .brand-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 8px 16px rgba(79, 70, 229, 0.25);
        margin-bottom: 16px;
    }
    .form-control {
        border-radius: 10px;
        border: 1.5px solid var(--border-color);
        padding: 12px 16px;
        height: auto;
        font-size: 0.9rem;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        background-color: #ffffff;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.12);
    }
    .btn-submit {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 13px 20px;
        font-weight: 700;
        font-size: 0.92rem;
        letter-spacing: 0.02em;
        width: 100%;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #4338ca, #3730a3);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }
    .btn-submit:active {
        transform: translateY(0);
    }
    .badge-creds {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.78rem;
        color: var(--text-muted);
        text-align: center;
        margin-top: 20px;
    }
</style>
</head>
<body>

    <div class="login-card text-center">
        <div class="brand-icon">
            <i class="fas fa-layer-group"></i>
        </div>
        <h3 class="font-weight-bold mb-1" style="color: #1e293b; letter-spacing: -0.02em;">Admin Portal</h3>
        <p class="text-muted small mb-4">NovaDrop Multi-Vendor Commerce Platform</p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-left small rounded-lg py-2.5 px-3 mb-3 border-0 shadow-sm" style="background:#fee2e2; color:#991b1b;">
                <i class="fas fa-exclamation-circle mr-1.5"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success text-left small rounded-lg py-2.5 px-3 mb-3 border-0 shadow-sm">
                <i class="fas fa-check-circle mr-1.5"></i> <?= htmlspecialchars($this->session->flashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('admin/login') ?>" class="text-left">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

            <div class="form-group mb-3">
                <label class="small font-weight-bold text-secondary mb-1">Email or Username</label>
                <div class="input-group">
                    <input type="text" name="email" class="form-control" placeholder="admin@novadrop.in" required value="<?= htmlspecialchars($email ?? 'admin@novadrop.in') ?>">
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="small font-weight-bold text-secondary mb-0">Password</label>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required value="admin123">
            </div>

            <button type="submit" class="btn btn-submit">
                <i class="fas fa-sign-in-alt mr-2"></i> Log In to Dashboard
            </button>

            <div class="badge-creds">
                <i class="fas fa-key mr-1 text-primary"></i> Default Access: <code>admin@novadrop.in</code> / <code>admin123</code>
            </div>
        </form>
    </div>

</body>
</html>
