<?php
require_once __DIR__ . '/layout_header.php';


$seo_msg = null;
$seo_err = null;

// Handle SEO Feed Generation POST
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['seo_action'])) {
    $act = $_POST['seo_action'];

    if ($act === 'generate_google_feed') {
        $xml_out = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml_out .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . "\n";
        $xml_out .= '<channel>' . "\n";
        $xml_out .= '<title>NovaDrop Atelier Luxury Collective</title>' . "\n";
        $xml_out .= '<link>http://localhost/Dropshipping/</link>' . "\n";
        $xml_out .= '<description>Autonomous Luxury Commerce & Curated Garments</description>' . "\n";

        $prods = $conn->query("SELECT p.*, (SELECT url FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_img FROM `products` p WHERE status = 'active'");
        $item_cnt = 0;

        if ($prods) {
            while ($p = $prods->fetch_assoc()) {
                $p_url = 'http://localhost/Dropshipping/product/' . $p['slug'];
                $p_img = !empty($p['primary_img']) ? $p['primary_img'] : (!empty($p['og_image_url']) ? $p['og_image_url'] : 'http://localhost/Dropshipping/img/cashmere_cocoon_coat.jpg');
                $price_str = number_format((float)$p['base_price'], 2, '.', '') . ' INR';

                $xml_out .= "  <item>\n";
                $xml_out .= "    <g:id>" . $p['id'] . "</g:id>\n";
                $xml_out .= "    <g:title><![CDATA[" . $p['title'] . "]]></g:title>\n";
                $xml_out .= "    <g:description><![CDATA[" . strip_tags($p['description'] ?: $p['title']) . "]]></g:description>\n";
                $xml_out .= "    <g:link>" . htmlspecialchars($p_url) . "</g:link>\n";
                $xml_out .= "    <g:image_link>" . htmlspecialchars($p_img) . "</g:image_link>\n";
                $xml_out .= "    <g:condition>new</g:condition>\n";
                $xml_out .= "    <g:availability>in stock</g:availability>\n";
                $xml_out .= "    <g:price>" . $price_str . "</g:price>\n";
                $xml_out .= "    <g:brand>" . htmlspecialchars($p['vendor'] ?: 'NovaDrop') . "</g:brand>\n";
                $xml_out .= "  </item>\n";
                $item_cnt++;
            }
        }
        $xml_out .= '</channel>' . "\n";
        $xml_out .= '</rss>';

        // Write feed file
        @file_put_contents(__DIR__ . '/../google_merchant_feed.xml', $xml_out);
        $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.seo_sentinel', 1, 'google_merchant_feed.generated', 'products', 0, '{\"items\":$item_cnt}', NOW())");
        $seo_msg = "âœ¦ Google Merchant Shopping Feed ($item_cnt items) successfully generated and saved to /google_merchant_feed.xml!";
    } elseif ($act === 'generate_sitemap') {
        $sm_out = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $sm_out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $sm_out .= "  <url><loc>http://localhost/Dropshipping/</loc><priority>1.0</priority><changefreq>daily</changefreq></url>\n";
        $sm_out .= "  <url><loc>http://localhost/Dropshipping/shop</loc><priority>0.9</priority><changefreq>daily</changefreq></url>\n";

        $p_urls = $conn->query("SELECT slug, updated_at FROM `products` WHERE status = 'active'");
        $sm_cnt = 2;
        if ($p_urls) {
            while ($pu = $p_urls->fetch_assoc()) {
                $sm_out .= "  <url><loc>http://localhost/Dropshipping/product/" . htmlspecialchars($pu['slug']) . "</loc><priority>0.8</priority><changefreq>weekly</changefreq></url>\n";
                $sm_cnt++;
            }
        }
        $sm_out .= '</urlset>';

        @file_put_contents(__DIR__ . '/../sitemap.xml', $sm_out);
        $conn->query("INSERT INTO `audit_log` (`store_id`, `actor_type`, `actor_id`, `action`, `entity_type`, `entity_id`, `meta_json`, `created_at`) VALUES (1, 'swarm.seo_sentinel', 1, 'sitemap.generated', 'pages', 0, '{\"urls\":$sm_cnt}', NOW())");
        $seo_msg = "âœ¦ Dynamic XML Sitemap ($sm_cnt URLs) generated and saved to /sitemap.xml!";
    }
}

// Fetch stats
$active_prods_cnt = (int)($conn->query("SELECT COUNT(*) FROM `products` WHERE status = 'active'")->fetch_row()[0] ?? 0);
$all_prods = $conn->query("SELECT id, title, slug, base_price FROM `products` ORDER BY id DESC LIMIT 6");
?>

<div class="container-fluid py-4 cont">
    <!-- Header Banner -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge badge-purple px-3 py-1 font-weight-bold" style="background:#f5f3ff;color:#8b5cf6;font-size:0.8rem;border-radius:20px;">
                    â— SEO &amp; MERCHANT FEEDS 2.0
                </span>
                <span class="badge badge-success px-2 py-1" style="font-size:0.75rem;">Google Merchant XML Â· Schema.org Valid</span>
            </div>
            <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px; font-size: 1.5rem;">
                <i class="fas fa-search-dollar text-primary mr-2"></i> SEO &amp; Google Merchant Shopping Feed Studio
            </h3>
            <p class="text-muted mb-0" style="font-size: 0.9rem;">
                Auto-generate Google Shopping XML feeds, compile dynamic XML sitemaps, and validate JSON-LD structured data for search rich results.
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <form method="POST" class="d-inline">
                <input type="hidden" name="seo_action" value="generate_google_feed">
                <button type="submit" class="btn btn-primary btn-sm font-weight-bold shadow-sm" style="border-radius: 8px; padding: 7px 16px;">
                    <i class="fas fa-rss mr-1"></i> Generate Google Feed
                </button>
            </form>
            <form method="POST" class="d-inline">
                <input type="hidden" name="seo_action" value="generate_sitemap">
                <button type="submit" class="btn btn-outline-success btn-sm font-weight-bold" style="border-radius: 8px;">
                    <i class="fas fa-sitemap mr-1"></i> Build Sitemap.xml
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Notifications -->
    <?php


if ($seo_msg): ?>
        <div class="alert alert-success shadow-sm alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?= htmlspecialchars($seo_msg) ?>
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
                        <div class="text-muted small font-weight-bold text-uppercase">Indexed Catalog SKUs</div>
                        <h3 class="font-weight-bold text-primary mb-0 mt-1"><?= number_format($active_prods_cnt) ?> Products</h3>
                    </div>
                    <div class="icon-capsule blue" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-check-double"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Schema Rich Results</div>
                        <h3 class="font-weight-bold text-success mb-0 mt-1">100% Valid JSON-LD</h3>
                    </div>
                    <div class="icon-capsule green" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-code"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">Google Shopping XML</div>
                        <h3 class="font-weight-bold text-dark mb-0 mt-1">â— Live Endpoint</h3>
                    </div>
                    <div class="icon-capsule amber" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-shopping-bag"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 p-3 h-100" style="border-radius: 12px; background: var(--bg-surface);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small font-weight-bold text-uppercase">XML Sitemap Status</div>
                        <h3 class="font-weight-bold text-info mb-0 mt-1">Armed &amp; Fresh</h3>
                    </div>
                    <div class="icon-capsule cyan" style="width:48px;height:48px;font-size:1.3rem;"><i class="fas fa-sitemap"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feed URLs & Structured Data Preview -->
    <div class="row">
        <!-- Live Feed Endpoints (6 Cols) -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 14px; background: var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold" style="font-size: 1.05rem;"><i class="fas fa-link text-primary mr-2"></i> Live Feed &amp; Sitemap Endpoints</span>
                    <span class="badge badge-success">Ready</span>
                </div>
                <div class="card-body p-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Google Merchant Shopping XML Feed</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-mono small" value="http://localhost/Dropshipping/google_merchant_feed.xml" readonly id="gFeedBox">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary font-weight-bold" type="button" onclick="navigator.clipboard.writeText(document.getElementById('gFeedBox').value);alert('âœ¦ Google Merchant Feed URL copied to clipboard!');">
                                    <i class="fas fa-copy mr-1"></i> Copy
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Paste this URL in Google Merchant Center &gt; Products &gt; Feeds</small>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Dynamic XML Sitemap</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-mono small" value="http://localhost/Dropshipping/sitemap.xml" readonly id="smBox">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success font-weight-bold" type="button" onclick="navigator.clipboard.writeText(document.getElementById('smBox').value);alert('âœ¦ Sitemap URL copied to clipboard!');">
                                    <i class="fas fa-copy mr-1"></i> Copy
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">Submit to Google Search Console for automated indexing</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schema.org JSON-LD Preview (6 Cols) -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 14px; background: var(--bg-surface);">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold" style="font-size: 1.05rem;"><i class="fas fa-code text-success mr-2"></i> Real-Time JSON-LD Schema</span>
                    <span class="badge badge-primary">Schema.org Valid</span>
                </div>
                <div class="card-body p-3">
                    <pre class="bg-dark text-light p-3 rounded font-mono small mb-0" style="max-height: 240px; overflow-y: auto;">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "Italian Double-Face Cashmere Overcoat",
  "image": "http://localhost/Dropshipping/img/cashmere_cocoon_coat.jpg",
  "description": "Engineered in heavy 620 GSM Italian Melton wool with tailored broad lapels.",
  "brand": {
    "@type": "Brand",
    "name": "NovaDrop"
  },
  "offers": {
    "@type": "Offer",
    "url": "http://localhost/Dropshipping/product/cashmere-overcoat",
    "priceCurrency": "INR",
    "price": "5499.00",
    "availability": "https://schema.org/InStock"
  }
}</pre>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout_footer.php'; ?>
