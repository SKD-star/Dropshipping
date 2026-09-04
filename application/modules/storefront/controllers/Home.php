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
                $fd['original']     = $orig > $flash ? $orig : 0;
                $fd['discount_pct'] = ($orig > $flash && $orig > 0)
                    ? round((($orig - $flash) / $orig) * 100)
                    : 0;
                $fd['save_amount']  = max(0, $orig - $flash);
                $fd['img']          = !empty($fd['primary_image'])
                    ? $fd['primary_image']
                    : base_url('img/cashmere_cocoon_coat.jpg');

                // Tag / badge metadata used by the view
                $fd['tag']          = !empty($fd['collection_title']) ? strtoupper($fd['collection_title']) : 'SPECIAL SELECTION';
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

            // 9. Hero Slides (multi-slide interactive carousel with background video & image support)
            $hero_slides = [];
            if ($this->db->table_exists('hero_slides')) {
                $sq = $this->db->where('is_active', 1)->order_by('sort_order', 'ASC')->order_by('id', 'ASC');
                if ($this->db->field_exists('store_id', 'hero_slides')) {
                    $sq->where('store_id', $this->store_id);
                }
                $hero_slides = $sq->get('hero_slides')->result_array();
            }

            $data = [
                'title'            => env('APP_NAME', 'NovaDrop') . ' — Autonomous Performance Haute Couture',
                'round_categories' => $round_categories,
                'featured'         => $featured,
                'flash_deals'      => $flash_deals,
                'new_arrivals'     => $new_arrivals,
                'collections'      => $round_categories,
                'reviews'          => $reviews,
                'announcement'     => $announcement,
                'home_settings'    => $home_settings,
                'hero_slides'      => $hero_slides,
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
