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
        $addresses = $this->Customer_model->get_saved_addresses($this->customer_id);
        $default_address = $this->Customer_model->get_default_address($this->customer_id);

        $customer_row = $this->Customer_model->get_by_id($this->customer_id);
        $default_payment_method = $customer_row['default_payment_method'] ?? 'cod';

        $data = [
            'title'                  => 'My Account — ' . env('APP_NAME', 'NovaDrop'),
            'customer'               => $this->session->userdata('customer'),
            'customer_record'        => $customer_row,
            'orders'                 => $orders['items'],
            'wishlist'               => $wishlist,
            'addresses'              => $addresses,
            'default_address'        => $default_address,
            'default_payment_method' => $default_payment_method,
            'home_settings'          => $this->_get_home_settings(),
            'cart_count'             => $this->_get_cart_count(),
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

    /**
     * Set 1-Click Buy Now default address and preferred payment method
     */
    public function set_default_preferences()
    {
        $address_id = $this->input->post('default_address_id') !== null ? (int)$this->input->post('default_address_id') : null;
        $payment_method = $this->input->post('default_payment_method', true);

        if ($payment_method !== null && !in_array(strtolower($payment_method), ['cod', 'razorpay', 'stripe'])) {
            $this->json_error('Invalid payment method selected.');
            return;
        }

        $ok = $this->Customer_model->set_default_preferences($this->customer_id, $address_id, $payment_method);
        if ($ok) {
            $this->json_success('1-Click Buy Now preferences updated successfully!');
        } else {
            $this->json_error('Failed to update preferences.');
        }
    }

    /**
     * Save customer address via AJAX or form
     */
    public function save_address()
    {
        $first_name = $this->input->post('first_name', true);
        $last_name  = $this->input->post('last_name', true);
        $phone      = $this->input->post('phone', true);
        $address1   = $this->input->post('address1', true);
        $city       = $this->input->post('city', true);
        $state      = $this->input->post('state', true) ?: 'Maharashtra';
        $pincode    = $this->input->post('pincode', true);
        $is_default = (bool)$this->input->post('is_default');

        if (empty($first_name) || empty($phone) || empty($address1) || empty($city) || empty($pincode)) {
            $this->json_error('Please fill in all required address fields.');
            return;
        }

        $new_id = $this->Customer_model->save_customer_address($this->customer_id, [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'phone'      => $phone,
            'address1'   => $address1,
            'address2'   => $this->input->post('address2', true),
            'city'       => $city,
            'state'      => $state,
            'pincode'    => $pincode,
            'country'    => 'IN',
        ], $is_default);

        if ($new_id) {
            $this->json_success('Address saved successfully!', ['address_id' => $new_id]);
        } else {
            $this->json_error('Failed to save address.');
        }
    }
}

