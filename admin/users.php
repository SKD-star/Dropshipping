<?php
require_once __DIR__ . '/layout_header.php';
/**
 * NovaDrop Advanced Customer CRM & Intelligence Directory
 */

$user_msg = null;
$user_err = null;

// Handle Add Customer POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['user_action'])) {
    $u_act = $_POST['user_action'];
    if ($u_act === 'add_customer') {
        $c_name = trim($_POST['name'] ?? '');
        $c_email = trim($_POST['email'] ?? '');
        $c_phone = trim($_POST['phone'] ?? '');
        $c_disc = (float)($_POST['discount'] ?? 0);
        $c_username = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode('@', $c_email)[0])) ?: ('user_' . rand(100, 999));

        if (!empty($c_email)) {
            $chk_c = $conn->query("SELECT id FROM `customers` WHERE email = '" . $conn->real_escape_string($c_email) . "'");
            if ($chk_c && $chk_c->num_rows > 0) {
                $user_err = "A customer with email '$c_email' already exists.";
            } else {
                $pass_hash = password_hash("Customer@123", PASSWORD_DEFAULT);
                $stmt_ci = $conn->prepare("INSERT INTO `customers` (`store_id`, `email`, `phone`, `name`, `password_hash`, `email_verified`, `is_active`, `created_at`) VALUES (1, ?, ?, ?, ?, 1, 1, NOW())");
                $stmt_ci->bind_param("ssss", $c_email, $c_phone, $c_name, $pass_hash);
                if ($stmt_ci->execute()) {
                    $new_cid = $stmt_ci->insert_id;
                    $uid_str = "cust_" . $new_cid;
                    $conn->query("INSERT IGNORE INTO `user` (`uid`, `username`, `password`, `date`, `lsdate`) VALUES ('$uid_str', '" . $conn->real_escape_string($c_username) . "', '$pass_hash', NOW(), NOW())");
                    $conn->query("INSERT IGNORE INTO `userdet` (`uid`, `username`, `fname`, `email`, `disc`) VALUES ('$uid_str', '" . $conn->real_escape_string($c_username) . "', '" . $conn->real_escape_string($c_name) . "', '" . $conn->real_escape_string($c_email) . "', $c_disc)");
                    $user_msg = "Customer '$c_name' ($c_email) registered successfully in CRM!";
                }
            }
        }
    } elseif ($u_act === 'update_discount') {
        $c_uid = trim($_POST['uid'] ?? '');
        $c_disc = (float)($_POST['discount_rate'] ?? 0);
        if (!empty($c_uid)) {
            $conn->query("UPDATE `userdet` SET `disc` = $c_disc WHERE `uid` = '" . $conn->real_escape_string($c_uid) . "'");
            $user_msg = "Customer VIP discount updated to $c_disc%!";
        }
    }
}

// Compute CRM Metrics
$tot_cust = (int)($conn->query("SELECT COUNT(*) as cnt FROM `customers`")->fetch_assoc()['cnt'] ?? 0);
$vip_cust = (int)($conn->query("SELECT COUNT(DISTINCT customer_id) as cnt FROM `orders` WHERE total >= 5000")->fetch_assoc()['cnt'] ?? 0);
$tot_ltv = (float)($conn->query("SELECT COALESCE(SUM(total), 0) as total FROM `orders` WHERE payment_status = 'paid'")->fetch_assoc()['total'] ?? 0);
$avg_ltv = $tot_cust > 0 ? ($tot_ltv / $tot_cust) : 0;
?>

<div class="container-fluid py-4 cont">
    <!-- Toast / Action Feedback -->
    <?php if ($user_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($user_msg) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
    <?php if ($user_err): ?>
        <div class="alert alert-danger shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i> <?= htmlspecialchars($user_err) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Top CRM Metric KPI Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Total Customers</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1"><?= number_format($tot_cust) ?></h3>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">VIP High-Value Buyers</div>
                        <h3 class="font-weight-bold text-warning mb-0 mt-1"><?= number_format($vip_cust) ?></h3>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-crown"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Total Customer LTV</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">₹<?= number_format($tot_ltv, 2) ?></h3>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-wallet"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Avg Spend Per Customer</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1">₹<?= number_format($avg_ltv, 2) ?></h3>
                    </div>
                    <div class="icon-capsule purple" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main CRM Directory Card -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="font-weight-bold"><i class="fas fa-address-book mr-2 text-primary"></i> Customer CRM & Intelligence Directory</span>
            </div>
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <div style="min-width: 220px;">
                    <input type="text" id="custSearchInput" class="form-control form-control-sm" placeholder="🔍 Search name, email, phone..." onkeyup="filterCustomerTable()">
                </div>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCustomerModal">
                    <i class="fas fa-user-plus mr-1"></i> Add Customer
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="exportCrmToCSV()">
                    <i class="fas fa-file-export mr-1"></i> Export CRM CSV
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover usr-table mb-0" id="customerMasterTable">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Customer Identity</th>
                            <th>Username / Ref</th>
                            <th>Orders Placed</th>
                            <th>Lifetime Spend (LTV)</th>
                            <th>VIP Tier</th>
                            <th>VIP Discount</th>
                            <th>Registered On</th>
                            <th style="text-align: right;">1-Click Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $c = 1;
                        $res_users = $conn->query("SELECT * FROM `customers` ORDER BY id DESC");
                        
                        if ($res_users && $res_users->num_rows > 0) {
                            while ($usr = $res_users->fetch_assoc()) {
                                $cid = $usr['id'];
                                $uid_str = "cust_" . $cid;
                                $fullname = htmlspecialchars($usr['name'] ?: 'Valued Customer');
                                $email = htmlspecialchars($usr['email']);
                                $username = strtolower(explode('@', $email)[0]);
                                $phone = !empty($usr['phone']) ? htmlspecialchars($usr['phone']) : 'Not Provided';
                                $reg_date = date('d M Y', strtotime($usr['created_at']));
                                $initials = strtoupper(substr($fullname, 0, 2));

                                // Fetch discount safely
                                $d_res = $conn->query("SELECT disc FROM `userdet` WHERE uid = '$uid_str' OR email = '" . $conn->real_escape_string($email) . "' LIMIT 1");
                                $disc = ($d_res && $d_row = $d_res->fetch_assoc()) ? (float)$d_row['disc'] : 0.0;

                                // Query real order metrics for this customer
                                $r_ord = $conn->query("SELECT COUNT(*) as ord_cnt, COALESCE(SUM(total), 0) as ltv FROM `orders` WHERE guest_email = '" . $conn->real_escape_string($email) . "' OR customer_id = $cid");
                                $ord_data = $r_ord ? $r_ord->fetch_assoc() : ['ord_cnt' => 0, 'ltv' => 0];
                                $ord_cnt = (int)$ord_data['ord_cnt'];
                                $ltv = (float)$ord_data['ltv'];

                                $tier_badge = 'badge-secondary';
                                $tier_label = 'Standard';
                                if ($ltv >= 10000) {
                                    $tier_badge = 'badge-danger';
                                    $tier_label = 'Platinum VIP';
                                } elseif ($ltv >= 5000) {
                                    $tier_badge = 'badge-warning';
                                    $tier_label = 'Gold VIP';
                                } elseif ($ltv > 0) {
                                    $tier_badge = 'badge-primary';
                                    $tier_label = 'Silver Buyer';
                                }
                                ?>
                                <tr>
                                    <td><strong><?= $c ?></strong></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;box-shadow:0 2px 6px rgba(67,97,238,0.25);">
                                                <?= $initials ?>
                                            </div>
                                            <div>
                                                <div class="font-weight-bold text-dark"><?= $fullname ?></div>
                                                <a href="mailto:<?= $email ?>" class="small text-muted" style="text-decoration:none;"><i class="fas fa-envelope mr-1"></i> <?= $email ?></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>@<?= $username ?></code></td>
                                    <td><span class="badge badge-info"><?= $ord_cnt ?> Orders</span></td>
                                    <td><strong class="text-success">₹<?= number_format($ltv, 2) ?></strong></td>
                                    <td><span class="badge <?= $tier_badge ?> px-2 py-1"><?= $tier_label ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary py-0 px-2 font-weight-bold" onclick="openDiscountModal('<?= $uid_str ?>', '<?= $disc ?>', '<?= addslashes($fullname) ?>')">
                                            <?= $disc ?>% <i class="fas fa-pencil-alt ml-1" style="font-size:0.7rem;"></i>
                                        </button>
                                    </td>
                                    <td><span class="small text-muted"><?= $reg_date ?></span></td>
                                    <td style="text-align: right;">
                                        <a href="https://wa.me/?text=Hello+<?= urlencode($fullname) ?>%2C+welcome+to+NovaDrop+VIP+Club." target="_blank" class="btn btn-sm btn-outline-success mr-1" title="WhatsApp Customer">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="index.php?q=3&search=<?= urlencode($email) ?>" class="btn btn-sm btn-outline-primary mr-1" title="View Customer Orders">
                                            <i class="fas fa-shopping-bag"></i> Orders
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                            }
                        } else {
                            echo '<tr><td colspan="9" class="text-center py-5 text-muted">No registered customers found. Click "+ Add Customer" to create an account.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Add New Customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus text-primary mr-2"></i> Register New Customer Profile</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="user_action" value="add_customer">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Priya Sharma" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="e.g. priya.sharma@gmail.com" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+91 98765 43210">
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="font-weight-bold">VIP Discount (%)</label>
                            <input type="number" step="0.5" name="discount" class="form-control" placeholder="0" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-check mr-1"></i> Register Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal 2: Edit Customer Discount -->
<div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-tags text-primary mr-2"></i> Adjust Customer VIP Privilege</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="user_action" value="update_discount">
                <input type="hidden" name="uid" id="modalDiscUid" value="">
                <div class="modal-body">
                    <p class="text-muted mb-3" id="modalDiscSubtitle">Adjust the storewide discount for this customer account:</p>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Custom VIP Discount Rate (%)</label>
                        <input type="number" step="0.5" min="0" max="100" name="discount_rate" id="modalDiscInput" class="form-control font-weight-bold" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Save Discount Privilege</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function filterCustomerTable() {
    var input = document.getElementById("custSearchInput");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("customerMasterTable");
    var tr = table.getElementsByTagName("tr");
    for (var i = 1; i < tr.length; i++) {
        var tdName = tr[i].getElementsByTagName("td")[1];
        var tdUser = tr[i].getElementsByTagName("td")[2];
        if (tdName || tdUser) {
            var txt = (tdName ? tdName.textContent : "") + " " + (tdUser ? tdUser.textContent : "");
            tr[i].style.display = txt.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
}

function openDiscountModal(uid, disc, name) {
    document.getElementById('modalDiscUid').value = uid;
    document.getElementById('modalDiscInput').value = disc;
    document.getElementById('modalDiscSubtitle').innerText = "Adjust storewide VIP discount for: " + name;
    $('#editDiscountModal').modal('show');
}

function exportCrmToCSV() {
    var table = document.getElementById("customerMasterTable");
    var rows = table.querySelectorAll("tr");
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        for (var j = 0; j < cols.length - 1; j++) {
            var text = cols[j].innerText.replace(/"/g, '""').replace(/\n/g, ' ');
            row.push('"' + text + '"');
        }
        csv.push(row.join(","));
    }
    var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    var downloadLink = document.createElement("a");
    downloadLink.download = "NovaDrop_CRM_Customers_" + new Date().toISOString().slice(0, 10) + ".csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
