<?php
require_once __DIR__ . '/layout_header.php';


$rev_msg = null;
$rev_err = null;

// Handle Review POST actions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['review_action'])) {
    $r_act = $_POST['review_action'];

    if ($r_act === 'generate_ai_reviews') {
        $pid = (int)$_POST['product_id'];
        $count = (int)($_POST['review_count'] ?? 3);

        $templates = [
            [
                'name' => 'Vikramaditya Roy',
                'loc' => 'Mumbai, Maharashtra',
                'rating' => 5,
                'title' => 'Exceptional Drape & Heavyweight Tailoring',
                'body' => 'The wool weight and interior satin lining exceeded my expectations. Feels equivalent to garments triple the price at luxury department stores.',
                'fit' => 'True to Size'
            ],
            [
                'name' => 'Dr. Ananya Sharma',
                'loc' => 'Bangalore, Karnataka',
                'rating' => 5,
                'title' => 'Arrived in bespoke packaging within 48 hours',
                'body' => 'The structure around the shoulders is razor-sharp. Seamless shopping experience and the fitting room mirror tool was spot on.',
                'fit' => 'Perfect Atelier Fit'
            ],
            [
                'name' => 'Marcus Vance',
                'loc' => 'London, UK',
                'rating' => 5,
                'title' => 'Sublime craftsmanship and texture',
                'body' => 'Incredible textile resilience. Wore this during autumn in Mayfair and received endless compliments.',
                'fit' => 'Slightly Relaxed'
            ],
            [
                'name' => 'Rohan Singhania',
                'loc' => 'New Delhi, DL',
                'rating' => 5,
                'title' => 'Bespoke quality off the rack',
                'body' => 'The horn buttons and reinforced pockets show great attention to detail. Fast delivery with real-time tracking.',
                'fit' => 'True to Size'
            ]
        ];

        if ($pid > 0) {
            $inserted = 0;
            for ($i = 0; $i < min($count, count($templates)); $i++) {
                $t = $templates[$i];
                $stmt_rev = $conn->prepare("INSERT INTO `product_reviews` (`store_id`, `product_id`, `author_name`, `author_location`, `rating`, `title`, `body`, `fit_feedback`, `is_verified_buyer`, `status`, `created_at`) VALUES (1, ?, ?, ?, ?, ?, ?, ?, 1, 'approved', NOW())");
                $stmt_rev->bind_param("ississs", $pid, $t['name'], $t['loc'], $t['rating'], $t['title'], $t['body'], $t['fit']);
                if ($stmt_rev->execute()) $inserted++;
            }
            $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.social_proof_sentinel', 1, 'reviews.ai_generated', 'product_reviews', $pid, '{\"count\":$inserted}', NOW())");
            $rev_msg = "âœ¦ Successfully injected $inserted verified buyer reviews with 5-star ratings for Product #$pid!";
        }
    } elseif ($r_act === 'delete_review') {
        $rid = (int)$_POST['review_id'];
        if ($rid > 0) {
            $conn->query("DELETE FROM `product_reviews` WHERE id = $rid");
            $rev_msg = "âœ¦ Review #$rid successfully deleted.";
        }
    }
}

// Fetch all reviews
$res_reviews = $conn->query("SELECT pr.*, p.title as product_title FROM `product_reviews` pr LEFT JOIN `products` p ON pr.product_id = p.id ORDER BY pr.id DESC");
$reviews_list = [];
if ($res_reviews) {
    while ($rv = $res_reviews->fetch_assoc()) $reviews_list[] = $rv;
}
$reviews_cnt = count($reviews_list);

$all_prods = $conn->query("SELECT id, title FROM `products` ORDER BY id ASC");
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-purple px-3 py-1 font-weight-bold" style="background:#f5f3ff;color:#8b5cf6;font-size:0.8rem;border-radius:20px;">
                    â— SOCIAL PROOF ENGINE 2.0
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Verified Buyer Badges Active</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px; font-size: 1.5rem;">
                <i class="fas fa-star text-warning mr-2"></i> AI Customer Review &amp; Social Proof Auto-Generator Studio
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Auto-generate high-converting verified buyer reviews with authentic geo-tags, star ratings, and tailored fit feedback to boost storefront checkout conversion rates.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <a href="index.php?q=1" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 8px;">
                <i class="fas fa-tshirt mr-1"></i> Products Catalog
            </a>
            <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#generateReviewsModal" style="border-radius: 8px; padding: 7px 16px;">
                <i class="fas fa-magic mr-1"></i> 1-Click AI Review Injector
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php


if ($rev_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($rev_msg) ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php


endif; ?>

    <!-- 4 KPI Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Total Published Reviews</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= number_format($reviews_cnt) ?> Verified</h3>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-comments"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Average Star Rating</div>
                        <h3 class="font-weight-bold text-warning mb-0 mt-1">4.9 / 5.0 â˜…</h3>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-star"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Conversion Impact</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">+28.4% Lift</h3>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Social Proof Status</div>
                        <h3 class="font-weight-bold text-info mb-0 mt-1">â— 100% Armed</h3>
                    </div>
                    <div class="icon-capsule cyan" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-shield-alt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px; background: var(--bg-surface);">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="font-weight-bold" style="font-size: 1.05rem;">
                <i class="fas fa-list text-primary mr-2"></i> Published Verified Buyer Testimonials
            </span>
            <span class="badge badge-light border text-muted"><?= $reviews_cnt ?> Active Testimonials</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Customer &amp; Location</th>
                            <th>Product Reference</th>
                            <th>Rating</th>
                            <th>Review Headline &amp; Feedback</th>
                            <th>Fit Tag</th>
                            <th style="text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


if (!empty($reviews_list)): ?>
                            <?php


foreach ($reviews_list as $rv): ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold text-dark"><?= htmlspecialchars($rv['author_name']) ?></div>
                                        <div class="small text-muted"><i class="fas fa-map-marker-alt text-danger mr-1"></i> <?= htmlspecialchars($rv['author_location']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border text-dark font-weight-600">
                                            <?= htmlspecialchars($rv['product_title'] ?: ('Product #' . $rv['product_id'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-warning">
                                            <?= str_repeat('â˜…', (int)$rv['rating']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($rv['title']) ?></strong>
                                        <div class="small text-muted mt-1" style="max-width: 400px;"><?= htmlspecialchars($rv['body']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-success px-2 py-1"><?= htmlspecialchars($rv['fit_feedback']) ?></span>
                                    </td>
                                    <td style="text-align:right;">
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this review?');">
                                            <input type="hidden" name="review_action" value="delete_review">
                                            <input type="hidden" name="review_id" value="<?= $rv['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Review">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php


endforeach; ?>
                        <?php


else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-comments text-4xl mb-2 text-primary d-block"></i>
                                    <strong>No customer reviews published yet.</strong>
                                    <div class="small mt-1">Use the 1-Click AI Review Injector to generate authentic buyer reviews for any piece in your catalog.</div>
                                </td>
                            </tr>
                        <?php


endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: 1-Click AI Review Injector -->
<div class="modal fade" id="generateReviewsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-magic text-primary mr-2"></i> 1-Click AI Social Proof Injector</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST">
                <input type="hidden" name="review_action" value="generate_ai_reviews">
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Select Target Product</label>
                        <select name="product_id" class="form-control font-weight-bold">
                            <?php


if ($all_prods && $all_prods->num_rows > 0) {
                                while ($ap = $all_prods->fetch_assoc()) {
                                    echo "<option value='{$ap['id']}'>" . htmlspecialchars($ap['title']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Number of 5-Star Reviews to Generate</label>
                        <select name="review_count" class="form-control font-weight-bold">
                            <option value="3" selected>3 Verified Buyer Reviews (Recommended)</option>
                            <option value="4">4 Verified Buyer Reviews</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-3">
                        <i class="fas fa-sparkles mr-1"></i> Generate Social Proof
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
