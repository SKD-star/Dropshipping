<div class="row">
    <!-- Registered Users Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card text-center h-100">
            <div class="card-header">
                👥 Registered Users
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Registered Users</h5>
                <p class="card-text">The number of users registered in the system.</p>
                <p class="card-text"><?= number_format($users_count) ?></p>
            </div>
            <a href="<?= base_url('admin/customers') ?>" class="text-decoration-none">
                <div class="card-footer">
                    <span>See in Details</span>
                    <i class="fa fa-arrow-circle-right" style="color: #4e73df;"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Total Orders Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card text-center h-100">
            <div class="card-header">
                📦 Total Orders
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Orders Made</h5>
                <p class="card-text">The number of customer orders placed.</p>
                <p class="card-text"><?= number_format($orders_count) ?></p>
            </div>
            <a href="<?= base_url('admin/orders') ?>" class="text-decoration-none">
                <div class="card-footer">
                    <span>See in Details</span>
                    <i class="fa fa-arrow-circle-right" style="color: #4e73df;"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Orders Failed Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card text-center h-100">
            <div class="card-header">
                ❌ Orders Failed / Cancelled
            </div>
            <div class="card-body">
                <h5 class="card-title">Failed / Cancelled Orders</h5>
                <p class="card-text">Orders requiring review or attention.</p>
                <p class="card-text" style="color: #e74a3b;"><?= number_format($failed_count) ?></p>
            </div>
            <a href="<?= base_url('admin/orders?filter=failed') ?>" class="text-decoration-none">
                <div class="card-footer">
                    <span>See in Details</span>
                    <i class="fa fa-arrow-circle-right" style="color: #4e73df;"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Pending Support Requests Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card text-center h-100">
            <div class="card-header">
                🎧 Pending Support Requests
            </div>
            <div class="card-body">
                <h5 class="card-title">Support Requests</h5>
                <p class="card-text">Support requests awaiting response.</p>
                <p class="card-text" style="color: #f6c23e;"><?= number_format($tickets_count) ?></p>
            </div>
            <a href="<?= base_url('admin/whatsapp') ?>" class="text-decoration-none">
                <div class="card-footer">
                    <span>See in Details</span>
                    <i class="fa fa-arrow-circle-right" style="color: #4e73df;"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Total Payments Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card text-center h-100">
            <div class="card-header">
                💳 Total Payments
            </div>
            <div class="card-body">
                <h5 class="card-title">Total Payments Made</h5>
                <p class="card-text">The total amount of payments processed.</p>
                <p class="card-text" style="color: #1cc88a;">₹<?= number_format($total_payments, 2) ?></p>
            </div>
            <a href="<?= base_url('admin/finance') ?>" class="text-decoration-none">
                <div class="card-footer">
                    <span>See in Details</span>
                    <i class="fa fa-arrow-circle-right" style="color: #4e73df;"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Admin Notification Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card text-center h-100">
            <div class="card-header">
                🔔 Admin Notifications
            </div>
            <div class="card-body">
                <h5 class="card-title">Activity Alerts</h5>
                <p class="card-text">Important notifications & system logs.</p>
                <p class="card-text"><?= number_format($notif_count) ?></p>
            </div>
            <a href="<?= base_url('admin/audit') ?>" class="text-decoration-none">
                <div class="card-footer">
                    <span>See in Details</span>
                    <i class="fa fa-arrow-circle-right" style="color: #4e73df;"></i>
                </div>
            </a>
        </div>
    </div>
</div>
