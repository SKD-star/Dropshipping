<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Storefront Products Controller
 * Handles product detail view with variants, images, dynamic options, reviews, and related products
 */
class Products extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('products/Product_model');
    }

    public function detail(string $slug)
    {
        $product = $this->Product_model->get_product_detail($slug);
        if (!$product) {
            show_404();
            return;
        }

        // Fetch related products from same collection or vendor
        $related = $this->db->select('p.*, pi.url AS primary_image, MIN(pv.price) AS min_price')
            ->from('products p')
            ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
            ->join('product_variants pv', 'pv.product_id = p.id AND pv.is_active = 1', 'left')
            ->where('p.store_id', $this->store_id)
            ->where('p.status', 'active')
            ->where('p.id !=', $product['id'])
            ->group_by('p.id')
            ->order_by('p.views_count', 'DESC')
            ->limit(4)
            ->get()->result_array();

        // Customer reviews
        $reviews = $this->db->where('product_id', $product['id'])
                            ->where('status', 'approved')
                            ->order_by('created_at', 'DESC')
                            ->limit(10)
                            ->get('reviews')->result_array();

        // Vendor Info
        $vendor_info = $this->db->select('v.id, v.business_name, v.contact_name, v.rating, v.total_orders_fulfilled, v.kyc_status, vp.vendor_sku, vp.vendor_stock')
            ->from('vendor_products vp')
            ->join('vendors v', 'v.id = vp.vendor_id')
            ->where('vp.product_id', $product['id'])
            ->where('vp.approval_status', 'approved')
            ->get()->row_array();

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'            => ($product['seo_title'] ?: $product['title']) . ' — ' . env('APP_NAME', 'NovaDrop'),
            'meta_description' => $product['seo_description'] ?: $product['short_description'],
            'og_image'         => !empty($product['images'][0]['url']) ? $product['images'][0]['url'] : null,
            'product'          => $product,
            'vendor_info'      => $vendor_info,
            'related'          => $related,
            'reviews'          => $reviews,
            'home_settings'    => $home_settings,
            'cart_count'       => $this->_get_cart_count(),
        ];


        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/products/detail', $data);
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
