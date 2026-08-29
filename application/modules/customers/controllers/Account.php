<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer Account Controller
 * Customer dashboard, order tracking, wishlist, saved addresses, and profile
 */
class Account extends MY_Controller
{
    private int $customer_id;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['customers/Customer_model', 'orders/Order_model']);

        $customer = $this->session->userdata('customer');
        if (!$customer) {
            redirect('account/login');
            return;
        }
        $this->customer_id = (int)$customer['id'];
    }

    private function _get_home_settings(): array
    {
        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        return !empty($hs_row) ? $hs_row : [];
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

    public function dashboard()
    {
        $orders = $this->Order_model->get_for_customer($this->customer_id, 1, 5);
        $wishlist = $this->Customer_model->get_wishlist($this->customer_id);

        $data = [
            'title'         => 'My Account — ' . env('APP_NAME', 'NovaDrop'),
            'customer'      => $this->session->userdata('customer'),
            'orders'        => $orders['items'],
            'wishlist'      => $wishlist,
            'home_settings' => $this->_get_home_settings(),
            'cart_count'    => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('customers/account/dashboard', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function orders()
    {
        $page = max(1, (int)$this->input->get('page'));
        $orders = $this->Order_model->get_for_customer($this->customer_id, $page, 10);

        $data = [
            'title'         => 'My Orders — ' . env('APP_NAME', 'NovaDrop'),
            'customer'      => $this->session->userdata('customer'),
            'orders'        => $orders['items'],
            'total'         => $orders['total'],
            'page'          => $orders['page'],
            'total_pages'   => (int)ceil($orders['total'] / 10),
            'home_settings' => $this->_get_home_settings(),
            'cart_count'    => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('customers/account/orders', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function order_detail(int $id)
    {
        $order = $this->Order_model->get_with_items($id);
        if (!$order || $order['customer_id'] != $this->customer_id) {
            show_404();
            return;
        }

        $data = [
            'title'         => 'Order #' . $order['order_number'] . ' — ' . env('APP_NAME', 'NovaDrop'),
            'customer'      => $this->session->userdata('customer'),
            'order'         => $order,
            'home_settings' => $this->_get_home_settings(),
            'cart_count'    => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('customers/account/order_detail', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function wishlist()
    {
        $wishlist = $this->Customer_model->get_wishlist($this->customer_id);

        $data = [
            'title'         => 'My Wishlist — ' . env('APP_NAME', 'NovaDrop'),
            'customer'      => $this->session->userdata('customer'),
            'wishlist'      => $wishlist,
            'home_settings' => $this->_get_home_settings(),
            'cart_count'    => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('customers/account/wishlist', $data);
        $this->load->view('storefront/layout/footer', $data);
    }


    public function toggle_wishlist()
    {
        $product_id = (int)$this->input->post('product_id');
        if (!$product_id) {
            $this->json_error('Invalid product');
            return;
        }
        $added = $this->Customer_model->toggle_wishlist($this->customer_id, $product_id);
        $this->json_success($added ? 'Added to wishlist!' : 'Removed from wishlist', ['added' => $added]);
    }
}
