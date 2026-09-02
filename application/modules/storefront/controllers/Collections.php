<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Storefront Collections Controller
 * Handles /collections — Dedicated Editorial Capsule Collections & Archival Lookbook
 */
class Collections extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('products/Product_model');
    }

    public function index()
    {
        // Fetch database collections if any
        $db_collections = $this->db->where('store_id', $this->store_id)
                                   ->where('is_active', 1)
                                   ->order_by('sort_order', 'ASC')
                                   ->get('collections')->result_array();

        // Curated Editorial Capsules with luxury clothing storytelling & products
        $curated_capsules = [
            [
                'title' => 'Outerwear & Cashmere',
                'slug' => 'outerwear-cashmere',
                'tagline' => 'Architectural Silhouettes & 700 GSM Mongolian Cashmere',
                'description' => 'Tailored from 100% Grade-A Mongolian cashmere and structured Melton wool, designed to drape with museum-grade precision in freezing climates without excess bulk.',
                'image_url' => base_url('img/cashmere_cocoon_coat.jpg'),
                'badge' => 'Archival Edition',
                'min_price' => 3899,
                'items_count' => 12,
                'category_filter' => 'cashmere',
                'palette' => [
                    ['name' => 'Camel Cashmere', 'hex' => '#c29b64', 'img' => base_url('img/cashmere_cocoon_coat.jpg')],
                    ['name' => 'Onyx Noir', 'hex' => '#18181b', 'img' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=800&q=80'],
                    ['name' => 'Oatmeal Melange', 'hex' => '#e2d9cc', 'img' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800&q=80']
                ],
                'lookbook_images' => [
                    base_url('img/cashmere_cocoon_coat.jpg'),
                    'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=800&q=80',
                    'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800&q=80',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80'
                ],
                'products' => [
                    ['id' => 1, 'title' => 'The Atelier Cashmere Cocoon Coat', 'price' => 4999, 'compare_price' => 8999, 'slug' => 'the-atelier-cashmere-cocoon-coat', 'image' => base_url('img/cashmere_cocoon_coat.jpg'), 'fabric' => '700 GSM Cashmere'],
                    ['id' => 6, 'title' => 'Double-Breasted Melton Wool Peacoat', 'price' => 6499, 'compare_price' => 11999, 'slug' => 'double-breasted-melton-wool-peacoat', 'image' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=800&q=80', 'fabric' => 'Melton Virgin Wool'],
                    ['id' => 7, 'title' => 'Mongolian Ribbed Turtleneck Knit', 'price' => 3899, 'compare_price' => 6999, 'slug' => 'mongolian-ribbed-turtleneck-knit', 'image' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=800&q=80', 'fabric' => 'Grade-A Cashmere']
                ]
            ],
            [
                'title' => 'Okayama Selvedge Denim',
                'slug' => 'okayama-denim',
                'tagline' => 'Vintage Shuttle-Loomed Japanese 14.5oz Denim',
                'description' => '14.5oz shuttle-loomed selvedge denim from Okayama, Japan, rope-dyed in authentic natural indigo vats with red-line selvedge ID that develops a distinctive patina.',
                'image_url' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80',
                'badge' => 'Limited Batch',
                'min_price' => 3799,
                'items_count' => 8,
                'category_filter' => 'denim',
                'palette' => [
                    ['name' => 'Deep Natural Indigo', 'hex' => '#1b2a4a', 'img' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80'],
                    ['name' => 'Washed Vintage Blue', 'hex' => '#486581', 'img' => 'https://images.unsplash.com/photo-1542272604-780c96856592?w=800&q=80'],
                    ['name' => 'Raw Charcoal Black', 'hex' => '#212529', 'img' => 'https://images.unsplash.com/photo-1582552938357-32b906df40cb?w=800&q=80']
                ],
                'lookbook_images' => [
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80',
                    'https://images.unsplash.com/photo-1542272604-780c96856592?w=800&q=80',
                    'https://images.unsplash.com/photo-1582552938357-32b906df40cb?w=800&q=80',
                    'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80'
                ],
                'products' => [
                    ['id' => 2, 'title' => 'Vintage Okayama 14.5oz Selvedge Trousers', 'price' => 4899, 'compare_price' => 7999, 'slug' => 'vintage-okayama-selvedge-trousers', 'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80', 'fabric' => '14.5oz Okayama Selvedge'],
                    ['id' => 8, 'title' => 'Type II Shuttle-Loom Denim Jacket', 'price' => 5999, 'compare_price' => 9999, 'slug' => 'type-ii-shuttle-loom-denim-jacket', 'image' => 'https://images.unsplash.com/photo-1542272604-780c96856592?w=800&q=80', 'fabric' => '15oz Raw Indigo'],
                    ['id' => 9, 'title' => 'Washed Indigo Utility Overshirt', 'price' => 3799, 'compare_price' => 5999, 'slug' => 'washed-indigo-utility-overshirt', 'image' => 'https://images.unsplash.com/photo-1582552938357-32b906df40cb?w=800&q=80', 'fabric' => '11oz Selvedge Twill']
                ]
            ],
            [
                'title' => 'Mulberry Silk Eveningwear',
                'slug' => 'mulberry-silk',
                'tagline' => 'Fluid Drapes & 22-Momme Sandwashed Silk',
                'description' => 'Fluid bias-cut evening dresses and blouses crafted from certified 22-momme Mulberry silk with exquisite hand-rolled French seams for effortless liquid contouring.',
                'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',
                'badge' => 'Haute Couture',
                'min_price' => 4299,
                'items_count' => 6,
                'category_filter' => 'silk',
                'palette' => [
                    ['name' => 'Champagne Oyster', 'hex' => '#e8d8c8', 'img' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80'],
                    ['name' => 'Midnight Plum', 'hex' => '#3a1f38', 'img' => 'https://images.unsplash.com/photo-1502716119720-b23a93e5fe1b?w=800&q=80'],
                    ['name' => 'Emerald Forest', 'hex' => '#14382c', 'img' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80']
                ],
                'lookbook_images' => [
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80',
                    'https://images.unsplash.com/photo-1502716119720-b23a93e5fe1b?w=800&q=80',
                    'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80',
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80'
                ],
                'products' => [
                    ['id' => 4, 'title' => '22-Momme Mulberry Silk Bias Slip Dress', 'price' => 5699, 'compare_price' => 9499, 'slug' => 'mulberry-silk-bias-slip-dress', 'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=800&q=80', 'fabric' => '22-Momme Silk'],
                    ['id' => 10, 'title' => 'Sandwashed Silk Charmeuse Blouse', 'price' => 4299, 'compare_price' => 6999, 'slug' => 'sandwashed-silk-charmeuse-blouse', 'image' => 'https://images.unsplash.com/photo-1502716119720-b23a93e5fe1b?w=800&q=80', 'fabric' => 'Grade 6A Mulberry'],
                    ['id' => 11, 'title' => 'Pure Mulberry Silk Evening Scarf', 'price' => 1899, 'compare_price' => 3499, 'slug' => 'pure-mulberry-silk-evening-scarf', 'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=800&q=80', 'fabric' => 'Hand-Rolled Silk']
                ]
            ],
            [
                'title' => 'Tailored Blazers & Suiting',
                'slug' => 'tailored-suiting',
                'tagline' => 'Super 150s Vitale Barberis Italian Wool Suiting',
                'description' => 'Single and double-breasted blazers cut from Super 150s Italian virgin wool with floating horsehair canvas construction that molds to the body over time.',
                'image_url' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=800&q=80',
                'badge' => 'Bespoke Cut',
                'min_price' => 3999,
                'items_count' => 10,
                'category_filter' => 'suiting',
                'palette' => [
                    ['name' => 'Heather Charcoal', 'hex' => '#2b2d42', 'img' => base_url('img/wool_blazer_luxury.jpg')],
                    ['name' => 'Italian Navy', 'hex' => '#14213d', 'img' => base_url('img/italian_pleated_trousers.jpg')],
                    ['name' => 'Pinstripe Shadow', 'hex' => '#343a40', 'img' => base_url('img/melton_wool_peacoat.jpg')]
                ],
                'lookbook_images' => [
                    base_url('img/wool_blazer_luxury.jpg'),
                    base_url('img/italian_pleated_trousers.jpg'),
                    base_url('img/melton_wool_peacoat.jpg'),
                    base_url('img/cashmere_cocoon_coat.jpg')
                ],
                'products' => [
                    ['id' => 5, 'title' => 'Super 150s Double-Breasted Wool Blazer', 'price' => 7999, 'compare_price' => 13999, 'slug' => 'super-150s-double-breasted-blazer', 'image' => base_url('img/wool_blazer_luxury.jpg'), 'fabric' => 'Super 150s Virgin Wool'],
                    ['id' => 10, 'title' => 'Italian Pleated Wool Trousers', 'price' => 3999, 'compare_price' => 6999, 'slug' => 'italian-pleated-wool-trousers', 'image' => base_url('img/italian_pleated_trousers.jpg'), 'fabric' => 'Biella Virgin Wool'],
                    ['id' => 6, 'title' => 'Double-Breasted Melton Wool Peacoat', 'price' => 6499, 'compare_price' => 11999, 'slug' => 'double-breasted-melton-wool-peacoat', 'image' => base_url('img/melton_wool_peacoat.jpg'), 'fabric' => 'Melton Virgin Wool']
                ]
            ],
            [
                'title' => 'Heavyweight French Terry Essentials',
                'slug' => 'heavyweight-essentials',
                'tagline' => '500 GSM Custom Knit Loopback Essentials',
                'description' => 'Substantial 500 GSM loopback cotton jersey garments, custom garment-dyed in muted architectural tones for effortless daily poise and pre-shrunk density.',
                'image_url' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80',
                'badge' => 'Core Capsule',
                'min_price' => 1499,
                'items_count' => 14,
                'category_filter' => 'terry',
                'palette' => [
                    ['name' => 'Washed Obsidian', 'hex' => '#1f2022', 'img' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80'],
                    ['name' => 'Cement Melange', 'hex' => '#adb5bd', 'img' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&q=80'],
                    ['name' => 'Olive Ochre', 'hex' => '#585123', 'img' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&q=80']
                ],
                'lookbook_images' => [
                    'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80',
                    'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&q=80',
                    'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&q=80',
                    'https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80'
                ],
                'products' => [
                    ['id' => 3, 'title' => 'Sculpted 500 GSM Terry Hoodie', 'price' => 3299, 'compare_price' => 5499, 'slug' => 'sculpted-heavyweight-terry-hoodie', 'image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80', 'fabric' => '500 GSM Loopback'],
                    ['id' => 14, 'title' => 'Heavy French Terry Relaxed Joggers', 'price' => 2799, 'compare_price' => 4499, 'slug' => 'heavy-french-terry-joggers', 'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&q=80', 'fabric' => '480 GSM Cotton'],
                    ['id' => 15, 'title' => '280 GSM Structured Heavy T-Shirt', 'price' => 1499, 'compare_price' => 2499, 'slug' => 'structured-heavy-t-shirt', 'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&q=80', 'fabric' => '100% Organic Cotton']
                ]
            ]
        ];

        // Sync curated capsule products with live DB data so admin edits are immediately reflected
        $db_prods = $this->db->select('p.id, p.title, p.slug, p.base_price, p.compare_at_price, pi.url AS primary_image')
                             ->from('products p')
                             ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                             ->where('p.store_id', $this->store_id)
                             ->where('p.status', 'active')
                             ->get()->result_array();
        $prod_map = [];
        foreach ($db_prods as $dp) {
            $prod_map[$dp['id']] = $dp;
        }

        foreach ($curated_capsules as &$cap) {
            if (!empty($cap['products'])) {
                foreach ($cap['products'] as &$cp) {
                    $pid = $cp['id'] ?? 0;
                    if (isset($prod_map[$pid])) {
                        $db_item = $prod_map[$pid];
                        $cp['title']         = $db_item['title'];
                        $cp['price']         = (float)$db_item['base_price'];
                        $cp['compare_price'] = (float)($db_item['compare_at_price'] ?: ($db_item['base_price'] * 1.35));
                        $cp['slug']          = $db_item['slug'];
                        if (!empty($db_item['primary_image'])) {
                            $cp['image'] = $db_item['primary_image'];
                        }
                    }
                }
            }
        }
        unset($cap, $cp);

        // Load home settings for consistent header and footer
        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'            => 'Editorial Collections & Capsules — ' . env('APP_NAME', 'NovaDrop'),
            'meta_description' => 'Explore LUMINA thematic haute-couture capsules and limited archival drops.',
            'db_collections'   => $db_collections,
            'curated_capsules' => $curated_capsules,
            'home_settings'    => $home_settings,
            'cart_count'       => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/collections/index', $data);
        $this->load->view('storefront/layout/footer', $data);
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
