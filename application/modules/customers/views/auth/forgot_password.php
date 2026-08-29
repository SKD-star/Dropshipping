<div class="container" style="padding-top:60px;padding-bottom:100px;max-width:440px;margin:0 auto">
  <div style="background:var(--bg-2);border:1px solid var(--border);border-radius:var(--radius);padding:40px 32px">
    <div style="text-align:center;margin-bottom:28px">
      <h1 style="font-size:24px;font-weight:800;margin-bottom:6px">Reset Password</h1>
      <p style="font-size:13px;color:var(--text-2)">Enter your registered email address and we'll send you a password reset link.</p>
    </div>

    <form method="post" action="<?= base_url('account/forgot-password') ?>">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

      <div class="nd-form-group">
        <label class="nd-form-label">Email Address *</label>
        <input type="email" name="email" class="nd-form-control" required placeholder="your.name@example.com">
      </div>

      <button type="submit" class="nd-btn nd-btn-primary" style="width:100%;height:46px;justify-content:center;font-size:15px;margin-top:12px">
        Send Reset Link
      </button>
    </form>

    <div style="text-align:center;margin-top:24px;font-size:13px;color:var(--text-2)">
      Remember your password? <a href="<?= base_url('account/login') ?>" style="color:var(--accent);font-weight:600">Back to Sign In</a>
    </div>
  </div>
</div>
