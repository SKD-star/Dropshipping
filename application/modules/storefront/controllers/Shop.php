<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Storefront Shop Controller
 * Handles /shop and /shop/:collection_slug with dynamic filters & sorting
 */
class Shop extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('products/Product_model');
    }

    public function index()
    {
        $this->_render_listing();
    }

    public function collection(string $slug)
    {
        $collection = $this->db->where('store_id', $this->store_id)
                               ->where('slug', $slug)
                               ->where('is_active', 1)
                               ->get('collections')->row_array();

        if (!$collection) {
            show_404();
            return;
        }

        $this->_render_listing($collection);
    }

    private function _render_listing(?array $collection = null)
    {
        $page = max(1, (int)$this->input->get('page'));
        $per_page = 24;

        $filters = [
            'collection_id' => $collection ? $collection['id'] : $this->input->get('collection'),
            'sort'          => $this->input->get('sort') ?: 'created_at_desc',
            'price'         => $this->input->get('price'),
            'price_min'     => $this->input->get('min'),
            'price_max'     => $this->input->get('max'),
            'size'          => $this->input->get('size'),
            'fabric'        => $this->input->get('fabric'),
            'fit'           => $this->input->get('fit'),
            'availability'  => $this->input->get('availability'),
            'tag'           => $this->input->get('tag'),
            'vendor'        => $this->input->get('vendor'),
        ];

        $listing = $this->Product_model->get_listing($filters, $page, $per_page);
        
        // Eager-load secondary images & variants for each product
        if (!empty($listing['items'])) {
            $p_ids = array_column($listing['items'], 'id');
            $all_imgs = $this->db->where_in('product_id', $p_ids)->order_by('position', 'ASC')->get('product_images')->result_array();
            $imgs_by_p = [];
            foreach ($all_imgs as $im) {
                $imgs_by_p[$im['product_id']][] = $im['url'];
            }

            $all_variants = $this->db->where_in('product_id', $p_ids)->where('is_active', 1)->get('product_variants')->result_array();
            $variants_by_p = [];
            foreach ($all_variants as $v) {
                $variants_by_p[$v['product_id']][] = $v;
            }

            foreach ($listing['items'] as &$item) {
                $item['gallery'] = $imgs_by_p[$item['id']] ?? [];
                $item['variants'] = $variants_by_p[$item['id']] ?? [];
                // If only 1 image, pick an aesthetic secondary model look
                if (count($item['gallery']) <= 1) {
                    $fallback_alts = [
                        'cashmere' => base_url('img/model_look_classic.jpg'),
                        'denim'    => base_url('img/mannequin_look_street.jpg'),
                        'terry'    => base_url('img/model_look_street.jpg'),
                        'silk'     => base_url('img/model_look_executive.jpg'),
                        'wool'     => base_url('img/mannequin_look_executive.jpg'),
                        'peacoat'  => base_url('img/mannequin_look_classic.jpg'),
                        'loafer'   => base_url('img/chelsea_leather_boots.jpg'),
                        'boot'     => base_url('img/calfskin_penny_loafers.jpg'),
                    ];
                    $found_alt = null;
                    $t_lower = strtolower($item['title'] . ' ' . ($item['slug'] ?? ''));
                    foreach ($fallback_alts as $k => $alt_url) {
                        if (strpos($t_lower, $k) !== false) {
                            $found_alt = $alt_url;
                            break;
                        }
                    }
                    $item['secondary_image'] = $found_alt ?: base_url('img/model_look_classic.jpg');
                } else {
                    $item['secondary_image'] = $item['gallery'][1] ?? $item['primary_image'];
                }
            }
            unset($item);
        }

        $collections = $this->db->where('store_id', $this->store_id)->where('is_active', 1)->get('collections')->result_array();

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $page_title = $collection ? $collection['title'] : 'All Products';
        $data = [
            'title'            => $page_title . ' — ' . env('APP_NAME', 'NovaDrop'),
            'meta_description' => $collection['seo_description'] ?? 'Explore our premium selection of ' . strtolower($page_title),
            'collection'       => $collection,
            'collections'      => $collections,
            'products'         => $listing['items'],
            'total'            => $listing['total'],
            'page'             => $listing['page'],
            'per_page'         => $listing['per_page'],
            'total_pages'      => $listing['total_pages'],
            'filters'          => $filters,
            'home_settings'    => $home_settings,
            'cart_count'       => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/shop/index', $data);
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
