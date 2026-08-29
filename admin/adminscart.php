<?php
require_once __DIR__ . '/layout_header.php';

$uid = $_GET['uid'] ?? '';
?>

<div class="container-fluid py-4 cont">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-weight-bold text-dark mb-1"><i class="fas fa-shopping-basket text-primary mr-2"></i> Customer Active Cart Inspector</h3>
            <p class="text-muted mb-0 small">Viewing live cart items and current session basket for customer: <code><?= htmlspecialchars($uid) ?></code></p>
        </div>
        <a href="index.php?q=2" class="btn btn-outline-secondary font-weight-bold" style="border-radius:8px;">
            <i class="fas fa-arrow-left mr-1"></i> Back to CRM Directory
        </a>
    </div>

    <div class="card shadow-sm border-0" style="border-radius:14px; background:var(--bg-surface); overflow:hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Product</th>
                            <th>Color / Size</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $q1 = "SELECT * FROM `adcart` WHERE `uid`='" . $conn->real_escape_string($uid) . "'";
                    $r1 = mysqli_query($conn, $q1);
                    $countrows = ($r1) ? mysqli_num_rows($r1) : 0;

                    if ($countrows > 0) {
                        $ct = 1;
                        $tlmrp = 0;
                        while ($row3 = mysqli_fetch_array($r1)) {
                            $ccid = $row3['ccid'];
                            $qty = (int)$row3['qty'];
                            $size = $row3['size'];

                            $pname = "Product " . $ccid;
                            $mrp = 0;
                            $color = $row3['color'] ?? 'Standard';

                            $res1 = $conn->query("SELECT pname, color, mrp FROM `product` WHERE `ccid` = '" . $conn->real_escape_string($ccid) . "' LIMIT 1");
                            if ($res1 && $row1 = $res1->fetch_assoc()) {
                                $pname = $row1['pname'];
                                $color = $row1['color'] ?: $color;
                                $mrp = (float)$row1['mrp'];
                            } else {
                                $res_ci = $conn->query("SELECT title, base_price FROM `products` WHERE id = '" . (int)$ccid . "' OR slug = '" . $conn->real_escape_string($ccid) . "' LIMIT 1");
                                if ($res_ci && $row_ci = $res_ci->fetch_assoc()) {
                                    $pname = $row_ci['title'];
                                    $mrp = (float)$row_ci['base_price'];
                                }
                            }

                            $tmrp = $mrp * $qty;
                            $tlmrp += $tmrp;
                            ?>
                            <tr>
                                <td><strong><?= $ct ?></strong></td>
                                <td><strong><?= htmlspecialchars($pname) ?></strong></td>
                                <td><span class="badge badge-light border"><?= htmlspecialchars($color) ?> / <?= htmlspecialchars($size) ?></span></td>
                                <td><span class="badge badge-primary px-2 py-1"><?= $qty ?></span></td>
                                <td>₹<?= number_format($mrp, 2) ?></td>
                                <td><strong class="text-success">₹<?= number_format($tmrp, 2) ?></strong></td>
                            </tr>
                            <?php
                            $ct++;
                        }
                        ?>
                        <tr class="table-light">
                            <td colspan="5" class="text-right font-weight-bold">Cart Grand Total:</td>
                            <td><h5 class="font-weight-bold text-success mb-0">₹<?= number_format($tlmrp, 2) ?></h5></td>
                        </tr>
                        <?php
                    } else {
                        echo '<tr><td colspan="6" class="text-center py-5 text-muted"><i class="fas fa-shopping-cart fa-2x mb-3 text-muted"></i><br>No active cart items found for this customer.</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
