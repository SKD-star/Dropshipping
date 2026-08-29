<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Checkout Controller
 * Multi-step frictionless checkout with address capture, GST split, gateway init, and atomic order creation
 */
class Index extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model(['cart/Cart_model', 'checkout/Checkout_model', 'orders/Order_model']);
    }

    public function start()
    {
        $cart_id = $this->session->userdata('cart_id');
        $items = $cart_id ? $this->Cart_model->get_items($cart_id) : [];

        if (empty($items)) {
            redirect('cart');
            return;
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[80]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[80]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|min_length[10]');
            $this->form_validation->set_rules('address1', 'Street Address', 'required|trim');
            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('state', 'State', 'required|trim');
            $this->form_validation->set_rules('pincode', 'Pincode', 'required|trim');

            if ($this->form_validation->run()) {
                $shipping_address = [
                    'first_name' => $this->input->post('first_name', true),
                    'last_name'  => $this->input->post('last_name', true),
                    'company'    => $this->input->post('company', true),
                    'address1'   => $this->input->post('address1', true),
                    'address2'   => $this->input->post('address2', true),
                    'city'       => $this->input->post('city', true),
                    'state'      => $this->input->post('state', true),
                    'pincode'    => $this->input->post('pincode', true),
                    'country'    => 'IN',
                    'phone'      => $this->input->post('phone', true),
                ];

                $this->session->set_userdata([
                    'checkout_email'    => $this->input->post('email', true),
                    'checkout_shipping' => $shipping_address,
                ]);

                redirect('checkout/payment');
                return;
            }
        }

        $totals = $this->Checkout_model->calculate_totals($cart_id);

        $customer_id = $this->session->userdata('customer_id');
        $customer = $this->session->userdata('customer') ?? [];
        $shipping = $this->session->userdata('checkout_shipping') ?? [];
        $email = $this->session->userdata('checkout_email') ?? '';

        if ($customer_id) {
            if (empty($email) && !empty($customer['email'])) {
                $email = $customer['email'];
            }
            if (empty($shipping)) {
                $saved_addr = $this->db->where('customer_id', $customer_id)->order_by('id', 'DESC')->limit(1)->get('addresses')->row_array();
                if ($saved_addr) {
                    $shipping = [
                        'first_name' => $saved_addr['first_name'] ?? ($customer['first_name'] ?? ''),
                        'last_name'  => $saved_addr['last_name'] ?? ($customer['last_name'] ?? ''),
                        'phone'      => $saved_addr['phone'] ?? ($customer['phone'] ?? ''),
                        'address1'   => $saved_addr['address1'] ?? '',
                        'address2'   => $saved_addr['address2'] ?? '',
                        'city'       => $saved_addr['city'] ?? '',
                        'state'      => $saved_addr['state'] ?? 'Maharashtra',
                        'pincode'    => $saved_addr['pincode'] ?? '',
                        'country'    => $saved_addr['country'] ?? 'IN',
                    ];
                } elseif (!empty($customer)) {
                    $shipping = [
                        'first_name' => $customer['first_name'] ?? '',
                        'last_name'  => $customer['last_name'] ?? '',
                        'phone'      => $customer['phone'] ?? '',
                        'address1'   => '',
                        'address2'   => '',
                        'city'       => '',
                        'state'      => 'Maharashtra',
                        'pincode'    => '',
                        'country'    => 'IN',
                    ];
                }
            }
        }

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'         => 'Checkout — ' . env('APP_NAME', 'LUMINA'),
            'totals'        => $totals,
            'cart'          => $totals,
            'cart_count'    => $this->Cart_model->count_items($cart_id),
            'shipping'      => $shipping,
            'email'         => $email,
            'customer'      => $customer,
            'home_settings' => $home_settings,
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('checkout/start', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function payment()
    {
        $cart_id = $this->session->userdata('cart_id');
        $shipping = $this->session->userdata('checkout_shipping');
        $email = $this->session->userdata('checkout_email');

        if (!$cart_id || empty($shipping) || empty($email)) {
            redirect('checkout');
            return;
        }

        $totals = $this->Checkout_model->calculate_totals($cart_id, $shipping);

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'            => 'Payment — ' . env('APP_NAME', 'LUMINA'),
            'totals'           => $totals,
            'shipping'         => $shipping,
            'email'            => $email,
            'cart_count'       => $this->Cart_model->count_items($cart_id),
            'razorpay_enabled' => !empty(env('RAZORPAY_KEY_ID')),
            'stripe_enabled'   => !empty(env('STRIPE_PUBLIC_KEY')),
            'home_settings'    => $home_settings,
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('checkout/payment', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function confirm()
    {
        $cart_id = $this->session->userdata('cart_id');
        $shipping = $this->session->userdata('checkout_shipping');
        $email = $this->session->userdata('checkout_email');
        $payment_method = $this->input->post('payment_method', true) ?: 'cod';

        if (!$cart_id || empty($shipping) || empty($email)) {
            redirect('checkout');
            return;
        }

        $totals = $this->Checkout_model->calculate_totals($cart_id, $shipping);

        // 1. Create or find address
        $this->db->insert('addresses', array_merge($shipping, [
            'store_id'    => $this->store_id,
            'customer_id' => $this->session->userdata('customer_id') ?: null,
            'created_at'  => date('Y-m-d H:i:s'),
        ]));
        $address_id = $this->db->insert_id();

        // 2. Prepare Order Record
        $order_data = [
            'customer_id'         => $this->session->userdata('customer_id') ?: null,
            'guest_email'         => $email,
            'subtotal'            => $totals['subtotal'],
            'discount_amount'     => $totals['discount_amount'],
            'discount_code'       => $totals['discount_code'],
            'shipping_amount'     => $totals['shipping_amount'],
            'tax_amount'          => $totals['tax_amount'],
            'cgst_amount'         => $totals['cgst_amount'],
            'sgst_amount'         => $totals['sgst_amount'],
            'igst_amount'         => $totals['igst_amount'],
            'total'               => $totals['total'],
            'currency'            => 'INR',
            'shipping_address_id' => $address_id,
            'billing_address_id'  => $address_id,
            'source'              => 'storefront',
            'ip_address'          => $this->input->ip_address(),
            'user_agent'          => substr($this->input->user_agent(), 0, 500),
        ];

        // 3. Atomically create order
        $order_id = $this->Order_model->create_from_cart($cart_id, $order_data);

        if (!$order_id) {
            $this->session->set_flashdata('error', 'Checkout failed. Please check your inventory or try again.');
            redirect('checkout');
            return;
        }

        // 4. Handle Gateway Routing
        if ($payment_method === 'razorpay') {
            redirect('payments/razorpay/init?order_id=' . $order_id);
            return;
        } elseif ($payment_method === 'stripe') {
            redirect('payments/stripe/init?order_id=' . $order_id);
            return;
        } else {
            // Cash on Delivery (COD)
            $this->db->insert('payments', [
                'order_id'   => $order_id,
                'store_id'   => $this->store_id,
                'gateway'    => 'cod',
                'amount'     => $totals['total'],
                'currency'   => 'INR',
                'status'     => 'created',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            // Clear session cart
            $this->session->unset_userdata(['cart_id', 'checkout_shipping', 'checkout_email']);
            redirect('checkout/success/' . $order_id);
            return;
        }
    }

    public function success(int $order_id)
    {
        $order = $this->Order_model->get_with_items($order_id);
        if (!$order) {
            redirect('');
            return;
        }

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'         => 'Order Confirmed #' . $order['order_number'] . ' — ' . env('APP_NAME', 'LUMINA'),
            'order'         => $order,
            'home_settings' => $home_settings,
            'cart_count'    => 0,
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('checkout/success', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

}
