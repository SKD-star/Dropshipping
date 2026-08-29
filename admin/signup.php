<?php
require_once __DIR__ . '/layout_header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-header">
                    <span><i class="fas fa-user-plus mr-2"></i> Register New Administrator</span>
                </div>
                <div class="card-body p-4">
                    <form action="index.php?q=9&step=1" method="post">
                        <?php if (!empty($showAlert)): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle mr-1"></i> Administrator account created successfully!
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($showError)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle mr-1"></i> <?= htmlspecialchars($showError) ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Operations Manager" autocomplete="off" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Username or Email</label>
                            <input type="text" name="username" class="form-control" placeholder="e.g. ops_admin" autocomplete="off" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Create password" required>
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold text-dark">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" placeholder="Confirm password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block font-weight-bold py-2">
                            <i class="fas fa-user-check mr-1"></i> Create Administrator Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
