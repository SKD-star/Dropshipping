<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-header">
        <span><i class="fa fa-user-plus mr-2"></i> Create Administrator Account</span>
      </div>
      <div class="card-body p-4">
        <form method="POST" action="<?= base_url('admin/users/create') ?>">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

          <div class="form-group mb-3">
            <label class="font-weight-bold">Admin Username or Email 👤</label>
            <input type="text" name="username" class="form-control" placeholder="e.g. manager" required autocomplete="off">
          </div>

          <div class="form-group mb-3">
            <label class="font-weight-bold">Password 🔑</label>
            <input type="password" name="password" class="form-control" placeholder="Create a strong password" required>
          </div>

          <div class="form-group mb-4">
            <label class="font-weight-bold">Confirm Password 🔁</label>
            <input type="password" name="cpassword" class="form-control" placeholder="Re-enter password to confirm" required>
          </div>

          <div class="d-flex justify-content-between">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary font-weight-bold">
              <i class="fa fa-check-circle mr-1"></i> Register Admin
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
