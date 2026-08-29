<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cart Controller
 * Handles view cart, AJAX add/update/remove item, and discount coupon code application
 */
class Index extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('cart/Cart_model');
    }

    public function view()
    {
        $cart_id = $this->_get_or_create_cart_id();
        $cart = $this->Cart_model->get_or_create($cart_id, $this->session->userdata('customer_id'));
        $items = $this->Cart_model->get_items($cart['id']);
        $subtotal = $this->Cart_model->get_subtotal($cart['id']);

        $discount_amount = (float)($cart['discount_amount'] ?? 0);
        $total = max(0, $subtotal - $discount_amount);

        $cart['items'] = $items;
        $cart['subtotal'] = $subtotal;
        $cart['total'] = $total;

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'           => 'Curated Bag — ' . env('APP_NAME', 'LUMINA'),
            'cart'            => $cart,
            'items'           => $items,
            'subtotal'        => $subtotal,
            'discount_amount' => $discount_amount,
            'discount_code'   => $cart['discount_code'] ?? null,
            'total'           => $total,
            'home_settings'   => $home_settings,
            'cart_count'      => $this->Cart_model->count_items($cart['id']),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('cart/index', $data);
        $this->load->view('storefront/layout/footer', $data);
    }


    public function items()
    {
        $cart_id = $this->_get_or_create_cart_id();
        $items = $this->Cart_model->get_items($cart_id);
        $subtotal = $this->Cart_model->get_subtotal($cart_id);
        $count = $this->Cart_model->count_items($cart_id);

        $this->json_success('Cart items retrieved', [
            'items'      => $items,
            'subtotal'   => $subtotal,
            'cart_count' => $count
        ]);
    }

    public function add()
    {
        $variant_id = (int)$this->input->post('variant_id');
        $product_id = (int)$this->input->post('product_id');
        $quantity   = max(1, (int)$this->input->post('quantity', 1));
        $size       = trim($this->input->post('size', true) ?? '');
        $color      = trim($this->input->post('color', true) ?? '');
        $title      = trim($this->input->post('title', true) ?? '');
        $price      = (float)$this->input->post('price');
        $image      = trim($this->input->post('image', true) ?? '');

        $target_id = $variant_id ?: $product_id;
        if (!$target_id) {
            $this->json_error('Invalid item or variant ID');
            return;
        }

        $cart_id = $this->_get_or_create_cart_id();
        $result = $this->Cart_model->add_item($cart_id, $target_id, $quantity, $size, $color, $title, $price, $image);

        if ($result['success']) {
            $items = $this->Cart_model->get_items($cart_id);
            $subtotal = $this->Cart_model->get_subtotal($cart_id);
            $this->json_success($result['message'], [
                'cart_count' => $result['cart_count'],
                'subtotal'   => $subtotal,
                'items'      => $items
            ]);
        } else {
            $this->json_error($result['message']);
        }
    }

    public function update()
    {
        $variant_id = (int)$this->input->post('variant_id');
        $quantity   = (int)$this->input->post('quantity');

        $cart_id = $this->session->userdata('cart_id');
        if (!$cart_id || !$variant_id) {
            $this->json_error('Invalid cart or variant');
            return;
        }

        $result = $this->Cart_model->update_item($cart_id, $variant_id, $quantity);
        if ($result['success']) {
            $subtotal = $this->Cart_model->get_subtotal($cart_id);
            $count = $this->Cart_model->count_items($cart_id);
            $this->json_success($result['message'], ['subtotal' => $subtotal, 'cart_count' => $count]);
        } else {
            $this->json_error($result['message']);
        }
    }

    public function remove()
    {
        $variant_id = (int)$this->input->post('variant_id');
        $cart_id    = $this->session->userdata('cart_id');

        if (!$cart_id || !$variant_id) {
            $this->json_error('Invalid item');
            return;
        }

        $result = $this->Cart_model->remove_item($cart_id, $variant_id);
        $subtotal = $this->Cart_model->get_subtotal($cart_id);
        $count = $this->Cart_model->count_items($cart_id);
        $this->json_success($result['message'], ['subtotal' => $subtotal, 'cart_count' => $count]);
    }

    public function apply_discount()
    {
        $code = trim($this->input->post('code', true) ?? '');
        $cart_id = $this->session->userdata('cart_id');

        if (!$cart_id || empty($code)) {
            $this->json_error('Please enter a valid coupon code.');
            return;
        }

        $customer_id = (int)($this->session->userdata('customer_id') ?: 0);
        $res = $this->Cart_model->apply_discount($cart_id, $code, $customer_id);

        if ($res['success']) {
            $this->json_success($res['message'], $res);
        } else {
            $this->json_error($res['message']);
        }
    }

    private function _get_or_create_cart_id(): string
    {
        $cart_id = $this->session->userdata('cart_id');
        if (!$cart_id && !empty($_COOKIE['nd_cart_id'])) {
            $cart_id = trim($_COOKIE['nd_cart_id']);
        }

        if ($cart_id) {
            $cart = $this->Cart_model->get_or_create($cart_id, $this->session->userdata('customer_id'));
            $cart_id = $cart['id'];
        } else {
            $cart = $this->Cart_model->get_or_create('', $this->session->userdata('customer_id'));
            $cart_id = $cart['id'];
        }

        $this->session->set_userdata('cart_id', $cart_id);
        if (empty($_COOKIE['nd_cart_id']) || $_COOKIE['nd_cart_id'] !== $cart_id) {
            @setcookie('nd_cart_id', $cart_id, time() + (86400 * 30), '/');
        }
        return $cart_id;
    }
}
