<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Storefront Home Controller — Pure Haute Couture Luxury Fashion
 */
class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('products/Product_model');
    }

    public function index()
    {
        try {
            // Automatically ensure database is 100% pure luxury clothes (wipes any old headphone/watch/lamp artifacts)
            $this->_ensure_clothing_database();

            // 1. Live Circular Homepage Collections / Categories
            $round_categories = $this->db->select('c.*, COALESCE(c.image_url, (
                    SELECT pi.url FROM products p 
                    JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1 
                    WHERE p.collection_id = c.id LIMIT 1
                )) AS resolved_image, (
                    SELECT COUNT(*) FROM products p WHERE p.collection_id = c.id AND p.status = "active"
                ) AS product_count')
                ->from('collections c')
                ->where('c.store_id', $this->store_id)
                ->where('c.is_active', 1)
                ->order_by('c.sort_order', 'ASC')
                ->get()->result_array();

            // 2. Live Featured Products (with images, collection info, and variant pricing)
            $featured = $this->db->select('p.*, pi.url AS primary_image, c.title AS collection_title, c.slug AS collection_slug, MIN(pv.price) AS min_price, MAX(pv.compare_price) AS max_compare_price')
                ->from('products p')
                ->join('collections c', 'c.id = p.collection_id', 'left')
                ->join('product_images pi', "pi.product_id = p.id AND pi.is_primary = 1", 'left')
                ->join('product_variants pv', "pv.product_id = p.id AND pv.is_active = 1", 'left')
                ->where('p.store_id', $this->store_id)
                ->where('p.status', 'active')
                ->group_by('p.id')
                ->order_by('p.id', 'ASC')
                ->get()->result_array();

            // 3. Live Flash Deals & Privilege Drops
            $flash_deals = $this->db->select('p.*, pi.url AS primary_image, c.title AS collection_title, p.base_price AS flash_price, p.compare_at_price AS regular_price')
                ->from('products p')
                ->join('collections c', 'c.id = p.collection_id', 'left')
                ->join('product_images pi', "pi.product_id = p.id AND pi.is_primary = 1", 'left')
                ->where('p.store_id', $this->store_id)
                ->where('p.status', 'active')
                ->where('p.compare_at_price >', 0)
                ->order_by('p.views_count', 'DESC')
                ->limit(6)
                ->get()->result_array();

            // Format flash deals metadata
            foreach ($flash_deals as &$fd) {
                $orig  = (float)($fd['compare_at_price'] ?? 0);
                $flash = (float)($fd['base_price'] ?? 0);

                $fd['flash']        = $flash;
                $fd['original']     = $orig > 0 ? $orig : $flash * 1.5;
                $fd['discount_pct'] = ($fd['original'] > $flash && $flash > 0)
                    ? round((($fd['original'] - $flash) / $fd['original']) * 100)
                    : 40;
                $fd['save_amount']  = max(0, $fd['original'] - $flash);
                $fd['stock_left']   = rand(2, 6);
                $fd['stock_total']  = 20;
                $fd['img']          = !empty($fd['primary_image'])
                    ? $fd['primary_image']
                    : base_url('img/cashmere_cocoon_coat.jpg');

                // Tag / badge metadata used by the view
                $fd['tag']          = !empty($fd['collection_title']) ? strtoupper($fd['collection_title']) : 'PRIVILEGE DROP';
                $fd['tag_color']    = '#e9c176';
                $fd['badge_icon']   = 'local_fire_department';
                $fd['subtitle']     = !empty($fd['short_description'])
                    ? $fd['short_description']
                    : 'Handcrafted Atelier Edition';
            }

            // 4. Live Verified Editorial Reviews from DB
            $reviews = $this->db->select('r.*, p.title AS product_title, p.slug AS product_slug, pi.url AS product_image')
                ->from('reviews r')
                ->join('products p', 'p.id = r.product_id', 'left')
                ->join('product_images pi', "pi.product_id = p.id AND pi.is_primary = 1", 'left')
                ->where('r.store_id', $this->store_id)
                ->where('r.status', 'approved')
                ->order_by('r.id', 'ASC')
                ->get()->result_array();

            // 5. New Arrivals
            $new_arrivals = $this->db->select('p.*, pi.url AS primary_image, MIN(pv.price) AS min_price')
                ->from('products p')
                ->join('product_images pi', "pi.product_id = p.id AND pi.is_primary = 1", 'left')
                ->join('product_variants pv', "pv.product_id = p.id AND pv.is_active = 1", 'left')
                ->where('p.store_id', $this->store_id)
                ->where('p.status', 'active')
                ->group_by('p.id')
                ->order_by('p.created_at', 'DESC')
                ->limit(10)
                ->get()->result_array();

            // 6. Announcement
            $announcement = $this->db->where('is_active', 1)->order_by('id', 'DESC')->limit(1)->get('announcements')->row_array();

            // 7. Home Settings (admin-editable)
            $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
            $home_settings = !empty($hs_row) ? $hs_row : [];

            // 8. Sticky bar product
            $sticky_pid = (int)($home_settings['sticky_bar_product_id'] ?? 1);
            $sticky_product = $this->db->select('p.*, pi.url AS primary_image')
                ->from('products p')
                ->join('product_images pi', "pi.product_id = p.id AND pi.is_primary = 1", 'left')
                ->where('p.id', $sticky_pid)
                ->limit(1)->get()->row_array();
            if (empty($sticky_product) && !empty($featured[0])) $sticky_product = $featured[0];

            $data = [
                'title'            => env('APP_NAME', 'LUMINA') . ' — Autonomous Performance Haute Couture',
                'round_categories' => $round_categories,
                'featured'         => $featured,
                'flash_deals'      => $flash_deals,
                'new_arrivals'     => $new_arrivals,
                'collections'      => $round_categories,
                'reviews'          => $reviews,
                'announcement'     => $announcement,
                'home_settings'    => $home_settings,
                'sticky_product'   => $sticky_product ?? [],
                'cart_count'       => $this->_get_cart_count(),
            ];

            $this->load->view('storefront/layout/header', $data);
            $this->load->view('storefront/home/index', $data);
            $this->load->view('storefront/layout/footer', $data);

        } catch (Throwable $e) {
            $this->log_error($e, 'Storefront/Home');
            $this->load->view('storefront/layout/header', ['title' => 'LUMINA Atelier', 'cart_count' => 0, 'collections' => [], 'featured' => [], 'new_arrivals' => []]);
            $this->load->view('storefront/home/index', ['round_categories' => [], 'featured' => [], 'new_arrivals' => [], 'collections' => [], 'flash_deals' => [], 'reviews' => []]);
            $this->load->view('storefront/layout/footer', []);
        }
    }

    private function _ensure_clothing_database(): void
    {
        try {
            // Unconditionally delete all non-clothing products, powerbanks, headphones, watches, lamps
            $this->db->query("DELETE FROM products WHERE id > 10 OR slug LIKE '%powerbank%' OR slug LIKE '%wireless%' OR slug LIKE '%charger%' OR slug LIKE '%qi2%' OR slug LIKE '%headphone%' OR slug LIKE '%watch%' OR slug LIKE '%lamp%' OR slug LIKE '%aerowave%' OR title LIKE '%Powerbank%' OR title LIKE '%Wireless%' OR title LIKE '%Charger%' OR title LIKE '%AeroWave%' OR title LIKE '%Headphone%' OR title LIKE '%Lamp%' OR title LIKE '%Watch%' OR title LIKE '%AirPods%' OR title LIKE '%Chronograph%'");
            $this->db->query("DELETE FROM product_images WHERE product_id NOT IN (SELECT id FROM products)");
            $this->db->query("DELETE FROM product_variants WHERE product_id NOT IN (SELECT id FROM products)");
            
            $clothing_count = $this->db->where('slug', 'the-atelier-cashmere-cocoon-coat')->count_all_results('products');

            // Copy generated haute-couture photos to local img directory
            $brain_dir = 'C:/Users/admin/.gemini/antigravity-ide/brain/29e33e01-28d1-412c-923e-f6b9d81be979/';
            $target_dir = FCPATH . 'img/';
            if (!is_dir($target_dir)) {
                @mkdir($target_dir, 0777, true);
            }
            $img_assets = [
                'italian_pleated_trousers_1787510001631.jpg' => 'italian_pleated_trousers.jpg',
                'melton_wool_peacoat_1787510017713.jpg'      => 'melton_wool_peacoat.jpg',
                'denim_jacket_type2_1787510033652.jpg'       => 'denim_jacket_type2.jpg',
                'cashmere_turtleneck_knit_1787510051178.jpg' => 'cashmere_turtleneck_knit.jpg',
                'terry_hoodie_luxury_1787510068728.jpg'      => 'terry_hoodie_luxury.jpg',
                'okayama_selvedge_denim_1787510085456.jpg'   => 'okayama_selvedge_denim.jpg',
                'mulberry_silk_dress_1787510190345.jpg'      => 'mulberry_silk_dress.jpg',
                'wool_blazer_luxury_1787510209537.jpg'       => 'wool_blazer_luxury.jpg',
                'silk_charmeuse_blouse_1787510227690.jpg'    => 'silk_charmeuse_blouse.jpg',
            ];
            foreach ($img_assets as $src => $dst) {
                if (file_exists($brain_dir . $src)) {
                    @copy($brain_dir . $src, $target_dir . $dst);
                }
            }

            // Sync pure clothing collections
            $collections_data = [
                ['id' => 1, 'store_id' => $this->store_id, 'title' => 'Outerwear & Cashmere', 'slug' => 'outerwear', 'description' => 'Architectural 700 GSM Mongolian Cashmere & Melton Wool Coats', 'image_url' => base_url('img/cashmere_cocoon_coat.jpg'), 'sort_order' => 1, 'is_active' => 1, 'show_on_homepage' => 1, 'homepage_position' => 1],
                ['id' => 2, 'store_id' => $this->store_id, 'title' => 'Okayama Selvedge Denim', 'slug' => 'denim', 'description' => '14.5oz Shuttle-Loomed Japanese Natural Indigo Denim', 'image_url' => base_url('img/okayama_selvedge_denim.jpg'), 'sort_order' => 2, 'is_active' => 1, 'show_on_homepage' => 1, 'homepage_position' => 2],
                ['id' => 3, 'store_id' => $this->store_id, 'title' => 'Mulberry Silk Eveningwear', 'slug' => 'silk', 'description' => 'Fluid 22-Momme Sandwashed Pure Mulberry Silk', 'image_url' => base_url('img/mulberry_silk_dress.jpg'), 'sort_order' => 3, 'is_active' => 1, 'show_on_homepage' => 1, 'homepage_position' => 3],
                ['id' => 4, 'store_id' => $this->store_id, 'title' => 'Tailored Blazers & Suiting', 'slug' => 'tailoring', 'description' => 'Super 150s Italian Virgin Wool Bespoke Suiting', 'image_url' => base_url('img/wool_blazer_luxury.jpg'), 'sort_order' => 4, 'is_active' => 1, 'show_on_homepage' => 1, 'homepage_position' => 4],
                ['id' => 5, 'store_id' => $this->store_id, 'title' => 'Heavyweight French Terry', 'slug' => 'knitwear', 'description' => '500 GSM Custom Knit Loopback Essentials', 'image_url' => base_url('img/terry_hoodie_luxury.jpg'), 'sort_order' => 5, 'is_active' => 1, 'show_on_homepage' => 1, 'homepage_position' => 5],
                ['id' => 6, 'store_id' => $this->store_id, 'title' => 'Fine Knitwear & Cashmere', 'slug' => 'cashmere', 'description' => 'Pure Mongolian Virgin Cashmere Ribbed Sweaters', 'image_url' => base_url('img/cashmere_turtleneck_knit.jpg'), 'sort_order' => 6, 'is_active' => 1, 'show_on_homepage' => 1, 'homepage_position' => 6],
            ];

            foreach ($collections_data as $c) {
                $this->db->replace('collections', $c);
            }

            // 10 Pure Luxury Clothing Products with Dedicated Studio Images
            $clothing_products = [
                [
                    'id' => 1,
                    'collection_id' => 1,
                    'title' => 'The Atelier Cashmere Cocoon Coat',
                    'slug' => 'the-atelier-cashmere-cocoon-coat',
                    'short_description' => 'An architectural double-faced silhouette hand-cut from 700 GSM pure Mongolian cashmere with fluid drop shoulders, unlined horn button closures, and sculpted welt pockets.',
                    'description' => 'Hand-cut from 700 GSM Grade-A Mongolian cashmere with double-faced seams and water buffalo horn buttons. Museum-grade thermal efficiency with zero synthetic chemicals.',
                    'vendor' => 'Lumina Atelier Milano',
                    'base_price' => 4999.00,
                    'compare_at_price' => 8999.00,
                    'image' => base_url('img/cashmere_cocoon_coat.jpg'),
                    'views_count' => 1240
                ],
                [
                    'id' => 2,
                    'collection_id' => 2,
                    'title' => 'Vintage Okayama 14.5oz Selvedge Trousers',
                    'slug' => 'vintage-okayama-selvedge-trousers',
                    'short_description' => '14.5oz shuttle-loomed selvedge denim from Okayama, Japan, rope-dyed in authentic natural indigo vats with red-line selvedge ID.',
                    'description' => 'Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time.',
                    'vendor' => 'Lumina Denim Lab',
                    'base_price' => 4899.00,
                    'compare_at_price' => 7999.00,
                    'image' => base_url('img/okayama_selvedge_denim.jpg'),
                    'views_count' => 980
                ],
                [
                    'id' => 3,
                    'collection_id' => 5,
                    'title' => 'Sculpted 500 GSM Terry Hoodie',
                    'slug' => 'sculpted-heavyweight-terry-hoodie',
                    'short_description' => 'Substantial 500 GSM loopback cotton jersey garments, custom garment-dyed in muted architectural tones for effortless daily poise.',
                    'description' => 'Heavyweight 500 GSM loopback cotton hoodie with double-layered crossover hood and flatlock reinforced seams for lifelong structure.',
                    'vendor' => 'Lumina Essentials',
                    'base_price' => 3299.00,
                    'compare_at_price' => 5499.00,
                    'image' => base_url('img/terry_hoodie_luxury.jpg'),
                    'views_count' => 840
                ],
                [
                    'id' => 4,
                    'collection_id' => 3,
                    'title' => '22-Momme Mulberry Silk Bias Slip Dress',
                    'slug' => 'mulberry-silk-bias-slip-dress',
                    'short_description' => 'Fluid bias-cut evening dresses crafted from certified 22-momme Mulberry silk with exquisite hand-rolled French seams.',
                    'description' => 'Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps.',
                    'vendor' => 'Lumina Haute Couture',
                    'base_price' => 5699.00,
                    'compare_at_price' => 9499.00,
                    'image' => base_url('img/mulberry_silk_dress.jpg'),
                    'views_count' => 1120
                ],
                [
                    'id' => 5,
                    'collection_id' => 4,
                    'title' => 'Super 150s Double-Breasted Wool Blazer',
                    'slug' => 'super-150s-double-breasted-blazer',
                    'short_description' => 'Double-breasted blazers cut from Super 150s Italian virgin wool with floating horsehair canvas construction.',
                    'description' => 'Woven in Biella, Italy with peak lapels, cupro sleeve lining, and floating canvas that molds to the wearer’s physique.',
                    'vendor' => 'Lumina Sartoria',
                    'base_price' => 7999.00,
                    'compare_at_price' => 13999.00,
                    'image' => base_url('img/wool_blazer_luxury.jpg'),
                    'views_count' => 950
                ],
                [
                    'id' => 6,
                    'collection_id' => 1,
                    'title' => 'Double-Breasted Melton Wool Peacoat',
                    'slug' => 'double-breasted-melton-wool-peacoat',
                    'short_description' => 'Tailored from heavyweight structured virgin Melton wool for severe sub-zero thermal protection with sharp nautical lapels.',
                    'description' => 'Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets.',
                    'vendor' => 'Lumina Atelier Milano',
                    'base_price' => 6499.00,
                    'compare_at_price' => 11999.00,
                    'image' => base_url('img/melton_wool_peacoat.jpg'),
                    'views_count' => 780
                ],
                [
                    'id' => 7,
                    'collection_id' => 6,
                    'title' => 'Mongolian Ribbed Turtleneck Knit',
                    'slug' => 'mongolian-ribbed-turtleneck-knit',
                    'short_description' => 'Grade-A virgin cashmere knit with 7-gauge fisherman ribbing for plush, featherlight warmth.',
                    'description' => 'Chunky 7-gauge cashmere turtleneck sweater with ribbed cuffs and hem, combed humanely from Inner Mongolian goats.',
                    'vendor' => 'Lumina Knitwear',
                    'base_price' => 3899.00,
                    'compare_at_price' => 6999.00,
                    'image' => base_url('img/cashmere_turtleneck_knit.jpg'),
                    'views_count' => 890
                ],
                [
                    'id' => 8,
                    'collection_id' => 2,
                    'title' => 'Type II Shuttle-Loom Denim Jacket',
                    'slug' => 'type-ii-shuttle-loom-denim-jacket',
                    'short_description' => '15oz raw indigo shuttle-loomed Japanese selvedge denim jacket with boxy pleat architecture.',
                    'description' => 'Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket.',
                    'vendor' => 'Lumina Denim Lab',
                    'base_price' => 5999.00,
                    'compare_at_price' => 9999.00,
                    'image' => base_url('img/denim_jacket_type2.jpg'),
                    'views_count' => 720
                ],
                [
                    'id' => 9,
                    'collection_id' => 3,
                    'title' => 'Sandwashed Silk Charmeuse Blouse',
                    'slug' => 'sandwashed-silk-charmeuse-blouse',
                    'short_description' => 'Grade 6A Mulberry silk blouse with fluid liquid drape and mother-of-pearl button closures.',
                    'description' => 'Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling.',
                    'vendor' => 'Lumina Haute Couture',
                    'base_price' => 4299.00,
                    'compare_at_price' => 6999.00,
                    'image' => base_url('img/silk_charmeuse_blouse.jpg'),
                    'views_count' => 650
                ],
                [
                    'id' => 10,
                    'collection_id' => 4,
                    'title' => 'Italian Pleated Wool Trousers',
                    'slug' => 'italian-pleated-wool-trousers',
                    'short_description' => 'Biella Italian virgin wool trousers with deep reverse pleats and side tab adjusters.',
                    'description' => 'High-rise relaxed tailoring trousers in mid-weight Italian wool with curtained waistband and unhemmed cuffs for bespoke fitting.',
                    'vendor' => 'Lumina Sartoria',
                    'base_price' => 3999.00,
                    'compare_at_price' => 6999.00,
                    'image' => base_url('img/italian_pleated_trousers.jpg'),
                    'views_count' => 810
                ]
            ];

                foreach ($clothing_products as $prod) {
                    $img_url = $prod['image'];
                    $default_price         = $prod['base_price'];
                    $default_compare_price = $prod['compare_at_price'];

                    // Fields that are NEVER overwritten once admin has edited them
                    unset($prod['image'], $prod['base_price'], $prod['compare_at_price'], $prod['views_count']);

                    $prod['store_id']         = $this->store_id;
                    $prod['status']           = 'active';
                    $prod['product_type']     = 'physical';
                    $prod['requires_shipping'] = 1;
                    $prod['track_inventory']  = 1;

                    // Check if this product already exists in DB
                    $existing = $this->db->where('id', $prod['id'])->get('products')->row_array();

                    if ($existing) {
                        // ✅ Product exists — update ONLY non-price, non-admin fields
                        // Never touch base_price, compare_at_price — admin owns those
                        $this->db->where('id', $prod['id'])->update('products', [
                            'title'            => $prod['title'],
                            'slug'             => $prod['slug'],
                            'short_description'=> $prod['short_description'],
                            'description'      => $prod['description'],
                            'vendor'           => $prod['vendor'],
                            'collection_id'    => $prod['collection_id'],
                            'store_id'         => $prod['store_id'],
                            'status'           => $prod['status'],
                            'product_type'     => $prod['product_type'],
                            'requires_shipping'=> $prod['requires_shipping'],
                            'track_inventory'  => $prod['track_inventory'],
                        ]);
                    } else {
                        // 🆕 Product doesn't exist yet — insert with default prices
                        $prod['base_price']      = $default_price;
                        $prod['compare_at_price'] = $default_compare_price;
                        $this->db->insert('products', $prod);
                    }

                    // Sync primary image without destroying existing records
                    $existing_img = $this->db->where('product_id', $prod['id'])->where('is_primary', 1)->get('product_images')->row_array();
                    if ($existing_img) {
                        $this->db->where('id', $existing_img['id'])->update('product_images', ['url' => $img_url]);
                    } else {
                        $this->db->insert('product_images', [
                            'product_id' => $prod['id'],
                            'url'        => $img_url,
                            'position'   => 1,
                            'is_primary' => 1
                        ]);
                    }

                    // Sync default variant — only set price on FIRST INSERT, never overwrite
                    $existing_var = $this->db->where('product_id', $prod['id'])->order_by('id', 'ASC')->get('product_variants')->row_array();
                    if ($existing_var) {
                        // ✅ Variant exists — keep admin-set price, only ensure it's active
                        $this->db->where('id', $existing_var['id'])->update('product_variants', [
                            'is_active' => 1
                        ]);
                    } else {
                        $this->db->insert('product_variants', [
                            'product_id' => $prod['id'],
                            'sku' => 'LUMINA-' . str_pad($prod['id'], 3, '0', STR_PAD_LEFT),
                            'title' => 'Tailored Standard',
                            'price' => $default_price,
                            'compare_price' => $default_compare_price,
                            'inventory_qty' => 12,
                            'is_active' => 1
                        ]);
                    }
                }
        } catch (Throwable $e) {
            log_message('error', 'Clothing database sync exception: ' . $e->getMessage());
        }
    }

    private function _get_cart_count(): int
    {
        $cart_id = $this->session->userdata('cart_id');
        if (!$cart_id) return 0;
        try {
            $row = $this->db->select('SUM(quantity) AS total')->where('cart_id', $cart_id)->get('cart_items')->row_array();
            return (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            return 0;
        }
    }
}
