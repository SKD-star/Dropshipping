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
        $this->load->model(['cart/Cart_model', 'checkout/Checkout_model', 'orders/Order_model', 'customers/Customer_model']);
    }

    public function start()
    {
        // Handle 1-Click Buy Now fallback for guest or customer with no saved address
        $buy_now = (bool)$this->input->get('buy_now');
        $bn_variant_id = (int)$this->input->get('variant_id');
        $bn_qty = max(1, (int)$this->input->get('quantity'));
        $bn_size = $this->input->get('size', true);
        $bn_color = $this->input->get('color', true);

        if ($buy_now && $bn_variant_id) {
            $existing_cart_id = $this->session->userdata('cart_id');
            // Stash existing active cart so Buy Now never clears or pollutes pre-existing items
            if ($existing_cart_id && strpos($existing_cart_id, 'bn_') !== 0) {
                $this->session->set_userdata('stashed_cart_id', $existing_cart_id);
            }

            // Create isolated single-item buy now cart
            $bn_cart_id = 'bn_' . bin2hex(random_bytes(10));
            $this->db->insert('carts', [
                'id'          => $bn_cart_id,
                'store_id'    => $this->store_id,
                'customer_id' => $this->session->userdata('customer_id') ?: null,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
            $this->Cart_model->add_item($bn_cart_id, $bn_variant_id, $bn_qty, $bn_size, $bn_color);
            $this->session->set_userdata([
                'cart_id'         => $bn_cart_id,
                'is_buy_now_flow' => 1,
            ]);
        }

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

                $checkout_email = $this->input->post('email', true);
                $this->session->set_userdata([
                    'checkout_email'    => $checkout_email,
                    'checkout_shipping' => $shipping_address,
                ]);

                // Track in abandoned_carts for automated recovery
                if ($cart_id && !empty($checkout_email) && $this->db->table_exists('abandoned_carts')) {
                    $c_items = $this->Cart_model->get_items($cart_id);
                    $c_total = array_sum(array_map(fn($it) => ($it['quantity'] ?? 1) * ($it['price'] ?? 0), $c_items));
                    $existing_ac = $this->db->where('cart_id', $cart_id)->get('abandoned_carts')->row_array();
                    $ac_data = [
                        'store_id'           => $this->store_id,
                        'cart_id'            => $cart_id,
                        'customer_id'        => $this->session->userdata('customer_id') ?: null,
                        'customer_email'     => $checkout_email,
                        'customer_phone'     => $this->input->post('phone', true) ?: null,
                        'cart_total'         => $c_total,
                        'item_count'         => count($c_items),
                        'cart_snapshot_json' => json_encode($c_items),
                        'recovery_url'       => base_url('cart?recover=' . $cart_id),
                        'status'             => 'abandoned',
                        'abandoned_at'       => date('Y-m-d H:i:s'),
                    ];
                    if ($existing_ac) {
                        $this->db->where('id', $existing_ac['id'])->update('abandoned_carts', $ac_data);
                    } else {
                        $this->db->insert('abandoned_carts', $ac_data);
                    }
                }

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
            'title'         => 'Checkout — ' . env('APP_NAME', 'NovaDrop'),
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
            'title'            => 'Payment — ' . env('APP_NAME', 'NovaDrop'),
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

        // Mark abandoned cart as converted
        if ($this->db->table_exists('abandoned_carts')) {
            $this->db->where('cart_id', $cart_id)->update('abandoned_carts', [
                'status'             => 'converted',
                'converted_order_id' => $order_id,
                'updated_at'         => date('Y-m-d H:i:s'),
            ]);
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

            // Clear or restore session cart
            if ($this->session->userdata('is_buy_now_flow')) {
                $stashed = $this->session->userdata('stashed_cart_id');
                $this->session->unset_userdata(['is_buy_now_flow', 'stashed_cart_id', 'checkout_shipping', 'checkout_email']);
                if ($stashed) {
                    $this->session->set_userdata('cart_id', $stashed);
                } else {
                    $this->session->unset_userdata('cart_id');
                }
            } else {
                $this->session->unset_userdata(['cart_id', 'checkout_shipping', 'checkout_email']);
            }
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

        // IDOR Prevention: verify the viewing user owns this order
        $customer_id       = $this->session->userdata('customer_id');
        $checkout_email    = $this->session->userdata('checkout_email');
        $last_bn_order_id  = (int)$this->session->userdata('last_buy_now_order_id');

        $order_customer_id = (int)($order['customer_id'] ?? 0);
        $order_guest_email = strtolower(trim($order['guest_email'] ?? ''));

        $is_owner = false;
        if ($last_bn_order_id && $last_bn_order_id === (int)$order_id) {
            $is_owner = true;
        } elseif ($customer_id && $order_customer_id === (int)$customer_id) {
            $is_owner = true;
        } elseif (!empty($checkout_email) && !empty($order_guest_email) && strtolower($checkout_email) === $order_guest_email) {
            $is_owner = true;
        }

        if (!$is_owner) {
            show_404();
            return;
        }

        // Clear checkout session now that order is confirmed and viewed
        $this->session->unset_userdata(['checkout_shipping', 'checkout_email', 'last_buy_now_order_id']);

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'         => 'Order Confirmed #' . $order['order_number'] . ' — ' . env('APP_NAME', 'NovaDrop'),
            'order'         => $order,
            'home_settings' => $home_settings,
            'cart_count'    => 0,
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('checkout/success', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    /**
     * AJAX endpoint: Preview 1-Click Buy Now order
     * Re-validates current catalog price and inventory, checks login & default address,
     * computes financial summary, and generates a single-use idempotency token.
     */
    public function buy_now_preview()
    {
        $variant_id = (int)$this->input->post('variant_id');
        $product_id = (int)$this->input->post('product_id');
        $quantity   = max(1, (int)$this->input->post('quantity'));
        $size       = $this->input->post('size', true);
        $color      = $this->input->post('color', true);

        if (!$variant_id && $product_id) {
            $variant_id = $product_id;
        }

        $customer_id = (int)$this->session->userdata('customer_id');

        // 1. Check if user is logged in
        if (!$customer_id) {
            $this->json([
                'eligible' => false,
                'reason'   => 'guest',
                'message'  => 'Please sign in or proceed with fast checkout.',
                'redirect' => base_url('checkout?buy_now=1&variant_id=' . $variant_id . '&quantity=' . $quantity . '&size=' . urlencode($size ?: '') . '&color=' . urlencode($color ?: ''))
            ]);
            return;
        }

        // 2. Check if customer has a saved shipping address
        $default_address = $this->Customer_model->get_default_address($customer_id);
        $saved_addresses = $this->Customer_model->get_saved_addresses($customer_id);

        if (empty($default_address)) {
            $this->json([
                'eligible' => false,
                'reason'   => 'no_address',
                'message'  => 'Add a saved delivery address to activate 1-Click Buy Now.',
                'redirect' => base_url('checkout?buy_now=1&variant_id=' . $variant_id . '&quantity=' . $quantity . '&size=' . urlencode($size ?: '') . '&color=' . urlencode($color ?: ''))
            ]);
            return;
        }

        // 3. Authoritative server-side product & variant validation
        $variant = null;
        if ($size) {
            $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping, pi.url AS image_url')
                                ->from('product_variants pv')
                                ->join('products p', 'p.id = pv.product_id')
                                ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                                ->where('pv.id', $variant_id)
                                ->where('pv.option1_value', $size)
                                ->where('p.store_id', $this->store_id)
                                ->where('p.status', 'active')
                                ->where('pv.is_active', 1)
                                ->get()->row_array();
            if (!$variant) {
                // Try product_id + size
                $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping, pi.url AS image_url')
                                    ->from('product_variants pv')
                                    ->join('products p', 'p.id = pv.product_id')
                                    ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                                    ->where('pv.product_id', $variant_id)
                                    ->where('pv.option1_value', $size)
                                    ->where('p.store_id', $this->store_id)
                                    ->where('p.status', 'active')
                                    ->where('pv.is_active', 1)
                                    ->get()->row_array();
            }
        }

        if (!$variant) {
            $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping, pi.url AS image_url')
                                ->from('product_variants pv')
                                ->join('products p', 'p.id = pv.product_id')
                                ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                                ->where('pv.id', $variant_id)
                                ->where('p.store_id', $this->store_id)
                                ->where('p.status', 'active')
                                ->where('pv.is_active', 1)
                                ->get()->row_array();
        }

        if (!$variant && $product_id) {
            $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping, pi.url AS image_url')
                                ->from('product_variants pv')
                                ->join('products p', 'p.id = pv.product_id')
                                ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                                ->where('pv.product_id', $product_id)
                                ->where('p.store_id', $this->store_id)
                                ->where('p.status', 'active')
                                ->where('pv.is_active', 1)
                                ->order_by('pv.id', 'ASC')
                                ->limit(1)
                                ->get()->row_array();
        }

        if (!$variant) {
            $this->json(['eligible' => false, 'error' => 'This item is currently unavailable in the boutique catalog.'], 404);
            return;
        }

        // 4. Strict inventory check
        $available_stock = (int)($variant['inventory_qty'] ?? 0);
        if ($available_stock < $quantity) {
            $this->json([
                'eligible' => false,
                'error'    => $available_stock > 0 
                    ? "Only {$available_stock} unit(s) available in stock. Please adjust quantity." 
                    : "This item just sold out and is currently out of stock.",
                'stock'    => $available_stock,
            ], 400);
            return;
        }

        // 5. Authoritative unit price calculation
        $unit_price = (float)$variant['price'];
        if ($unit_price <= 0 && !empty($variant['base_price'])) {
            $unit_price = (float)$variant['base_price'];
        }

        $subtotal = round($unit_price * $quantity, 2);
        $shipping_amount = ($subtotal < 500) ? 60.00 : 0.00;

        // GST calculation (18% inclusive)
        $taxable = $subtotal / 1.18;
        $total_tax = round($subtotal - $taxable, 2);
        $grand_total = round($subtotal + $shipping_amount, 2);

        // 6. Generate single-use Idempotency Key
        $idempotency_key = 'bn_' . bin2hex(random_bytes(16));
        $this->db->insert('idempotency_keys', [
            'store_id'        => $this->store_id,
            'idempotency_key' => $idempotency_key,
            'customer_id'     => $customer_id,
            'status'          => 'preview',
            'created_at'      => date('Y-m-d H:i:s'),
            'expires_at'      => date('Y-m-d H:i:s', time() + 1800), // 30 min window
        ]);

        $cust_row = $this->Customer_model->get_by_id($customer_id);
        $default_payment = $cust_row['default_payment_method'] ?? 'cod';

        // Loyalty points data
        $loyalty_pts = (int)($cust_row['loyalty_points'] ?? 0);
        $loyalty_data = [
            'points'       => $loyalty_pts,
            'tier'         => $cust_row['loyalty_tier'] ?? 'Bronze',
            'points_value' => round($loyalty_pts * 0.50, 2), // 1 pt = ₹0.50 discount
        ];

        // Subscription plan data
        $sub_plan = null;
        if ($this->db->table_exists('subscription_plans')) {
            $sub_plan = $this->db->where('is_active', 1)->order_by('id', 'ASC')->limit(1)->get('subscription_plans')->row_array();
        }
        $sub_data = $sub_plan ? [
            'plan_id'      => (int)$sub_plan['id'],
            'plan_title'   => $sub_plan['title'] ?? 'VIP Auto-Replenish',
            'discount_pct' => (float)($sub_plan['discount_on_store'] ?: 10.0),
            'interval'     => $sub_plan['billing_interval'] ?? 'monthly',
        ] : null;

        // 7. Track Abandoned Buy Now Pipeline (Recovery integration)
        if ($this->db->table_exists('abandoned_carts') && $customer_id) {
            $snap = json_encode([
                'channel'       => 'abandoned_buy_now',
                'variant_id'    => (int)$variant['id'],
                'product_title' => $variant['product_title'],
                'unit_price'    => $unit_price,
                'quantity'      => $quantity,
                'subtotal'      => $subtotal,
            ]);
            $this->db->insert('abandoned_carts', [
                'store_id'           => $this->store_id,
                'cart_id'            => 0,
                'cart_hash'          => $idempotency_key,
                'customer_id'        => $customer_id,
                'customer_email'     => $cust_row['email'] ?? '',
                'customer_phone'     => $cust_row['phone'] ?? ($default_address['phone'] ?? ''),
                'cart_total'         => $grand_total,
                'item_count'         => $quantity,
                'cart_snapshot_json' => $snap,
                'recovery_url'       => base_url("checkout?buy_now=1&variant_id={$variant['id']}&quantity={$quantity}"),
                'status'             => 'abandoned',
                'abandoned_at'       => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ]);
        }

        $this->json([
            'eligible'         => true,
            'idempotency_key'  => $idempotency_key,
            'csrf_name'        => $this->security->get_csrf_token_name(),
            'csrf_hash'        => $this->security->get_csrf_hash(),
            'item'             => [
                'product_id'    => (int)$variant['product_id'],
                'variant_id'    => (int)$variant['id'],
                'title'         => $variant['product_title'],
                'variant_title' => $variant['title'],
                'image'         => $variant['image_url'] ?: base_url('img/cashmere_cocoon_coat.jpg'),
                'size'          => $size ?: ($variant['option1_value'] ?? 'Standard'),
                'color'         => $color ?: ($variant['option2_value'] ?? 'Original'),
                'quantity'      => $quantity,
                'unit_price'    => $unit_price,
                'stock'         => $available_stock,
            ],
            'totals'           => [
                'subtotal'        => $subtotal,
                'shipping_amount' => $shipping_amount,
                'tax_amount'      => $total_tax,
                'total'           => $grand_total,
            ],
            'address'          => $default_address,
            'saved_addresses'  => $saved_addresses,
            'payment_method'   => $default_payment,
            'loyalty'          => $loyalty_data,
            'subscription'     => $sub_data,
            'razorpay_enabled' => !empty(env('RAZORPAY_KEY_ID')),
            'stripe_enabled'   => !empty(env('STRIPE_SECRET_KEY')),
        ]);
    }

    /**
     * AJAX endpoint: Finalize 1-Click Buy Now order
     * Re-verifies inventory, authoritative price, address, applies idempotency guard,
     * wraps order creation + inventory decrement in atomic DB transaction,
     * routes payment, and returns redirect without corrupting existing user cart.
     */
    public function buy_now()
    {
        // 1. Rate limiting: 10 calls per minute per IP
        $this->rate_limit('buy_now:' . $this->input->ip_address(), 10, 60);

        // 2. Customer validation
        $customer_id = (int)$this->session->userdata('customer_id');
        if (!$customer_id) {
            $this->json_error('Session expired. Please log in to complete your order.', 401);
            return;
        }

        $customer = $this->Customer_model->get_by_id($customer_id);
        if (!$customer) {
            $this->json_error('Customer account not found.', 404);
            return;
        }

        // 3. Idempotency Key validation
        $idempotency_key = trim($this->input->post('idempotency_key', true) ?? '');
        if (empty($idempotency_key)) {
            $this->json_error('Missing idempotency key. Please refresh the page.', 400);
            return;
        }

        $idemp_row = $this->db->where('idempotency_key', $idempotency_key)->get('idempotency_keys')->row_array();

        if ($idemp_row) {
            // Duplicate submission check: If already completed, return existing order response immediately!
            if ($idemp_row['status'] === 'completed' && !empty($idemp_row['response_json'])) {
                $cached = json_decode($idemp_row['response_json'], true);
                if (is_array($cached)) {
                    $this->json($cached);
                    return;
                }
            }

            if (strtotime($idemp_row['expires_at']) < time()) {
                $this->json_error('Checkout session expired. Please review and place your order again.', 400);
                return;
            }

            if ($idemp_row['status'] === 'pending') {
                if (time() - strtotime($idemp_row['created_at']) < 15) {
                    $this->json_error('Your order is already being processed. Please wait a moment.', 429);
                    return;
                }
            }

            // Lock this idempotency key for active processing
            $this->db->where('id', $idemp_row['id'])->update('idempotency_keys', [
                'status'     => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            // Register new idempotency key with active processing lock
            $this->db->insert('idempotency_keys', [
                'store_id'        => $this->store_id,
                'idempotency_key' => $idempotency_key,
                'customer_id'     => $customer_id ?: null,
                'status'          => 'pending',
                'created_at'      => date('Y-m-d H:i:s'),
                'expires_at'      => date('Y-m-d H:i:s', time() + 1800),
            ]);
        }

        // 4. Input parsing
        $variant_id           = (int)$this->input->post('variant_id');
        $quantity             = max(1, (int)$this->input->post('quantity'));
        $expected_price       = (float)$this->input->post('expected_price');
        $address_id           = (int)$this->input->post('address_id');
        $payment_method       = strtolower(trim($this->input->post('payment_method', true) ?: 'cod'));
        $apply_loyalty_points = (int)$this->input->post('apply_loyalty_points');
        $is_subscription      = (int)$this->input->post('is_subscription');
        $subscription_plan_id = (int)$this->input->post('subscription_plan_id');

        if (!in_array($payment_method, ['cod', 'razorpay', 'stripe'])) {
            $payment_method = 'cod';
        }

        // 5. Strict Server-Side Catalog Revalidation (Never trust client payload)
        $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping')
                            ->from('product_variants pv')
                            ->join('products p', 'p.id = pv.product_id')
                            ->where('pv.id', $variant_id)
                            ->where('p.store_id', $this->store_id)
                            ->where('p.status', 'active')
                            ->where('pv.is_active', 1)
                            ->get()->row_array();

        if (!$variant) {
            $this->json_error('Item is no longer available in the boutique collection.', 404);
            return;
        }

        // Stock check
        $available_stock = (int)($variant['inventory_qty'] ?? 0);
        if ($available_stock < $quantity) {
            $msg = $available_stock > 0 
                ? "Only {$available_stock} unit(s) left in stock. Please adjust quantity." 
                : "This item just sold out.";
            $this->json_error($msg, 400, ['available_stock' => $available_stock]);
            return;
        }

        // Price change check
        $canonical_price = (float)$variant['price'];
        if ($canonical_price <= 0 && !empty($variant['base_price'])) {
            $canonical_price = (float)$variant['base_price'];
        }

        if ($expected_price > 0 && abs($canonical_price - $expected_price) > 0.01) {
            $this->json_error("Price updated to ₹" . number_format($canonical_price, 0) . ". Please review before confirming.", 400, [
                'price_changed' => true,
                'new_price'     => $canonical_price
            ]);
            return;
        }

        // 6. Address Resolution & Validation
        $shipping_address = null;
        if ($address_id > 0) {
            $shipping_address = $this->db->where('id', $address_id)
                                         ->where('customer_id', $customer_id)
                                         ->get('addresses')->row_array();
        }
        if (!$shipping_address) {
            $shipping_address = $this->Customer_model->get_default_address($customer_id);
        }

        if (!$shipping_address || empty($shipping_address['address1']) || empty($shipping_address['city']) || empty($shipping_address['pincode'])) {
            $this->json_error('Invalid or incomplete delivery address. Please verify your address.', 400);
            return;
        }

        // 7. Atomic DB Transaction & Isolated Cart
        $this->db->trans_start();
        try {
            // Generate isolated, single-use cart (Never pollutes active user session cart!)
            $bn_cart_id = 'bn_' . bin2hex(random_bytes(12));
            $this->db->insert('carts', [
                'id'          => $bn_cart_id,
                'store_id'    => $this->store_id,
                'customer_id' => $customer_id,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            $this->db->insert('cart_items', [
                'cart_id'    => $bn_cart_id,
                'variant_id' => $variant['id'],
                'quantity'   => $quantity,
                'unit_price' => $canonical_price,
                'added_at'   => date('Y-m-d H:i:s'),
            ]);

            $totals = $this->Checkout_model->calculate_totals($bn_cart_id, $shipping_address);

            // Subsystem 1: Subscribe & Save Discount (10% standard off store)
            $sub_discount = 0.00;
            if ($is_subscription) {
                $sub_discount = round($totals['subtotal'] * 0.10, 2);
                $totals['discount_amount'] = round($totals['discount_amount'] + $sub_discount, 2);
                $totals['total'] = max(0, round($totals['total'] - $sub_discount, 2));
            }

            // Subsystem 2: Loyalty Points Redemption (1 pt = ₹0.50 discount)
            $pts_to_deduct = 0;
            $pts_discount = 0.00;
            $avail_pts = (int)($customer['loyalty_points'] ?? 0);
            if ($apply_loyalty_points && $avail_pts > 0) {
                $max_pts_val = round($avail_pts * 0.50, 2);
                $pts_discount = min($max_pts_val, $totals['total']);
                $pts_to_deduct = (int)ceil($pts_discount / 0.50);
                $totals['discount_amount'] = round($totals['discount_amount'] + $pts_discount, 2);
                $totals['total'] = max(0, round($totals['total'] - $pts_discount, 2));
            }

            $order_code = null;
            if ($is_subscription && $apply_loyalty_points) {
                $order_code = 'VIP_SUB_AND_POINTS';
            } elseif ($is_subscription) {
                $order_code = 'VIP_SUB_SAVE10';
            } elseif ($apply_loyalty_points) {
                $order_code = 'LOYALTY_PTS';
            }

            $order_data = [
                'customer_id'         => $customer_id,
                'guest_email'         => $customer['email'],
                'subtotal'            => $totals['subtotal'],
                'discount_amount'     => $totals['discount_amount'],
                'discount_code'       => $order_code,
                'shipping_amount'     => $totals['shipping_amount'],
                'tax_amount'          => $totals['tax_amount'],
                'cgst_amount'         => $totals['cgst_amount'],
                'sgst_amount'         => $totals['sgst_amount'],
                'igst_amount'         => $totals['igst_amount'],
                'total'               => $totals['total'],
                'currency'            => 'INR',
                'shipping_address_id' => (int)$shipping_address['id'],
                'billing_address_id'  => (int)$shipping_address['id'],
                'source'              => 'storefront_buynow',
                'channel'             => 'buy_now',
                'ip_address'          => $this->input->ip_address(),
                'user_agent'          => substr($this->input->user_agent(), 0, 500),
            ];

            $order_id = $this->Order_model->create_from_cart($bn_cart_id, $order_data);

            if (!$order_id) {
                $this->db->trans_rollback();
                $this->audit('order.failed.buy_now', 'orders', 0, [], ['channel' => 'buy_now', 'error' => 'Inventory allocation failed']);
                $this->json_error('Order creation failed due to inventory allocation. Please retry.', 500);
                return;
            }

            $order_row = $this->db->where('id', $order_id)->select('order_number')->get('orders')->row_array();
            $order_number = $order_row['order_number'] ?? $order_id;

            // Subsystem 2a: Deduct Redeemed Loyalty Points
            if ($pts_to_deduct > 0) {
                $this->db->where('id', $customer_id)
                         ->set('loyalty_points', "GREATEST(0, COALESCE(loyalty_points,0) - {$pts_to_deduct})", false)
                         ->update('customers');

                $txn = [
                    'store_id'    => $this->store_id,
                    'customer_id' => $customer_id,
                    'points'      => $pts_to_deduct,
                    'type'        => 'debit',
                    'reason'      => "Redeemed on 1-Click Buy Now Order #{$order_number}",
                    'order_id'    => $order_id,
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('loyalty_transactions', $txn);
            }

            // Subsystem 2b: Award Loyalty Points on Purchase (1 pt per ₹10 spent)
            $earned_pts = max(1, (int)floor($totals['total'] / 10));
            $this->db->where('id', $customer_id)
                     ->set('loyalty_points', "COALESCE(loyalty_points,0) + {$earned_pts}", false)
                     ->update('customers');

            $earn_txn = [
                'store_id'    => $this->store_id,
                'customer_id' => $customer_id,
                'points'      => $earned_pts,
                'type'        => 'credit',
                'reason'      => "Earned on 1-Click Buy Now Order #{$order_number}",
                'order_id'    => $order_id,
                'created_at'  => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('loyalty_transactions', $earn_txn);

            // Auto-upgrade Loyalty Tier
            $this->_auto_upgrade_loyalty_tier($customer_id);

            // Subsystem 3: Subscribe & Save Subscription Record
            if ($is_subscription && $this->db->table_exists('customer_subscriptions')) {
                $sub_plan_row = null;
                if ($subscription_plan_id > 0) {
                    $sub_plan_row = $this->db->where('id', $subscription_plan_id)->get('subscription_plans')->row_array();
                }
                if (!$sub_plan_row) {
                    $sub_plan_row = $this->db->where('is_active', 1)->order_by('id', 'ASC')->limit(1)->get('subscription_plans')->row_array();
                }
                $effective_plan_id = $sub_plan_row ? (int)$sub_plan_row['id'] : 1;

                $this->db->insert('customer_subscriptions', [
                    'store_id'            => $this->store_id,
                    'customer_id'         => $customer_id,
                    'order_id'            => $order_id,
                    'plan_id'             => $effective_plan_id,
                    'status'              => 'active',
                    'next_billing_date'   => date('Y-m-d', strtotime('+30 days')),
                    'total_billed_cycles' => 1,
                    'last_payment_status' => ($payment_method === 'cod') ? 'pending' : 'paid',
                    'created_at'          => date('Y-m-d H:i:s'),
                ]);
            }

            // Subsystem 4: Affiliate / Referral Attribution
            $ref_code = $this->get_active_referral_code();
            if (!empty($ref_code) && $this->db->table_exists('influencers')) {
                $influencer = $this->db->where('referral_code', $ref_code)->where('status', 'active')->get('influencers')->row_array();
                if ($influencer) {
                    $comm_pct = (float)($influencer['commission_pct'] ?: 10.0);
                    $comm_amt = round(($comm_pct / 100.0) * $totals['total'], 2);

                    // Update total sales for influencer
                    $this->db->where('id', $influencer['id'])
                             ->set('total_sales', "COALESCE(total_sales,0) + {$totals['total']}", false)
                             ->update('influencers');

                    // Record or update referral metrics
                    if ($this->db->table_exists('referrals')) {
                        $ref_row = $this->db->where('referral_code', $ref_code)->get('referrals')->row_array();
                        if ($ref_row) {
                            $this->db->where('id', $ref_row['id'])
                                     ->set('conversions', 'conversions + 1', false)
                                     ->set('earnings', "earnings + {$comm_amt}", false)
                                     ->set('pending_payout', "pending_payout + {$comm_amt}", false)
                                     ->update('referrals');
                        } else {
                            $this->db->insert('referrals', [
                                'store_id'       => $this->store_id,
                                'referrer_id'    => $influencer['id'],
                                'referee_id'     => $customer_id,
                                'referral_code'  => $ref_code,
                                'clicks'         => 1,
                                'conversions'    => 1,
                                'earnings'       => $comm_amt,
                                'pending_payout' => $comm_amt,
                                'total_paid_out' => 0.00,
                                'tier'           => 1,
                                'is_active'      => 1,
                                'created_at'     => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }

                    // Record pending affiliate payout
                    if ($this->db->table_exists('affiliate_payouts')) {
                        $this->db->insert('affiliate_payouts', [
                            'store_id'    => $this->store_id,
                            'referrer_id' => $influencer['id'],
                            'amount'      => $comm_amt,
                            'method'      => 'bank_transfer',
                            'status'      => 'pending',
                            'note'        => "1-Click Buy Now Order #{$order_number} (Ref: {$ref_code})",
                            'created_at'  => date('Y-m-d H:i:s'),
                        ]);
                    }

                    $this->audit('affiliate.attributed.buy_now', 'influencers', (int)$influencer['id'], [], [
                        'order_id'   => $order_id,
                        'commission' => $comm_amt,
                        'code'       => $ref_code
                    ]);
                }
            }

            // Subsystem 5: Abandoned Buy Now Recovery Pipeline Conversion
            if ($this->db->table_exists('abandoned_carts')) {
                $this->db->where('cart_hash', $idempotency_key)->update('abandoned_carts', [
                    'status'             => 'converted',
                    'converted_order_id' => $order_id,
                    'updated_at'         => date('Y-m-d H:i:s'),
                ]);
            }
            if ($this->db->table_exists('abandoned_cart_log')) {
                $this->db->where('cart_id', $bn_cart_id)->update('abandoned_cart_log', ['status' => 'converted']);
            }

            // Subsystem 6: Audit Trail Logging
            $this->audit('order.placed.buy_now', 'orders', $order_id, [], [
                'channel'         => 'buy_now',
                'order_number'    => $order_number,
                'total'           => $totals['total'],
                'payment_method'  => $payment_method,
                'is_subscription' => $is_subscription,
                'loyalty_applied' => $apply_loyalty_points
            ]);

            // Clean up isolated cart
            $this->db->where('cart_id', $bn_cart_id)->delete('cart_items');
            $this->db->where('id', $bn_cart_id)->delete('carts');

            // 8. Payment Routing
            $response_payload = [];

            if ($payment_method === 'razorpay') {
                require_once APPPATH . 'core/interfaces/PaymentGatewayInterface.php';
                require_once APPPATH . 'core/adapters/RazorpayAdapter.php';
                $adapter = new RazorpayAdapter();
                $order_record = $this->Order_model->get_with_items($order_id);
                $res = $adapter->create_order($order_record);

                if (!$res['success']) {
                    $this->db->trans_rollback();
                    $this->audit('order.failed.buy_now', 'orders', $order_id, [], ['channel' => 'buy_now', 'error' => $res['error'] ?? 'Razorpay init failed']);
                    $this->json_error('Payment gateway error: ' . ($res['error'] ?? 'Initialization failed'), 500);
                    return;
                }

                $this->db->insert('payments', [
                    'order_id'         => $order_id,
                    'store_id'         => $this->store_id,
                    'gateway'          => 'razorpay',
                    'gateway_order_id' => $res['gateway_order_id'],
                    'amount'           => $totals['total'],
                    'currency'         => 'INR',
                    'status'           => 'created',
                    'created_at'       => date('Y-m-d H:i:s'),
                ]);

                $this->db->trans_complete();

                $response_payload = [
                    'success'          => true,
                    'order_id'         => $order_id,
                    'gateway'          => 'razorpay',
                    'gateway_order_id' => $res['gateway_order_id'],
                    'gateway_data'     => $res['gateway_data'] ?? [],
                    'redirect_url'     => base_url('payments/razorpay/init?order_id=' . $order_id),
                ];
            } elseif ($payment_method === 'stripe') {
                require_once APPPATH . 'core/interfaces/PaymentGatewayInterface.php';
                require_once APPPATH . 'core/adapters/StripeAdapter.php';
                $adapter = new StripeAdapter();
                $order_record = $this->Order_model->get_with_items($order_id);
                $res = $adapter->create_order($order_record);

                if (!$res['success'] || empty($res['redirect_url'])) {
                    $this->db->trans_rollback();
                    $this->audit('order.failed.buy_now', 'orders', $order_id, [], ['channel' => 'buy_now', 'error' => $res['error'] ?? 'Stripe init failed']);
                    $this->json_error('Stripe gateway error: ' . ($res['error'] ?? 'Initialization failed'), 500);
                    return;
                }

                $this->db->insert('payments', [
                    'order_id'         => $order_id,
                    'store_id'         => $this->store_id,
                    'gateway'          => 'stripe',
                    'gateway_order_id' => $res['gateway_order_id'],
                    'amount'           => $totals['total'],
                    'currency'         => 'INR',
                    'status'           => 'created',
                    'created_at'       => date('Y-m-d H:i:s'),
                ]);

                $this->db->trans_complete();

                $response_payload = [
                    'success'      => true,
                    'order_id'     => $order_id,
                    'gateway'      => 'stripe',
                    'redirect_url' => $res['redirect_url'],
                ];
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

                $this->db->trans_complete();

                $response_payload = [
                    'success'      => true,
                    'order_id'     => $order_id,
                    'gateway'      => 'cod',
                    'redirect_url' => base_url('checkout/success/' . $order_id),
                ];
            }

            // Subsystem 7: Order Confirmation Notifications (Email & WhatsApp)
            $db_host = function_exists('_env') ? _env('DB_HOST', '127.0.0.1') : (getenv('DB_HOST') ?: '127.0.0.1');
            $db_port = function_exists('_env') ? _env('DB_PORT', '3306') : (getenv('DB_PORT') ?: '3306');
            $db_name = function_exists('_env') ? _env('DB_NAME', 'novadrop') : (getenv('DB_NAME') ?: 'novadrop');
            $db_user = function_exists('_env') ? _env('DB_USER', 'root') : (getenv('DB_USER') ?: 'root');
            $db_pass = function_exists('_env') ? _env('DB_PASS', '') : (getenv('DB_PASS') ?: '');

            $sync_pdo = null;
            try {
                $sync_pdo = new PDO(
                    "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4",
                    $db_user,
                    $db_pass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
                );
            } catch (Throwable $pdo_err) {
                log_message('error', '[buy_now:pdo_init] ' . $pdo_err->getMessage());
            }

            // Vendor Order Routing on committed order
            if ($sync_pdo && file_exists(APPPATH . 'jobs/VendorOrderRoutingJob.php')) {
                try {
                    require_once APPPATH . 'jobs/VendorOrderRoutingJob.php';
                    $vjob = new \App\Jobs\VendorOrderRoutingJob($sync_pdo, (int)$this->store_id);
                    $vjob->handle(['order_id' => $order_id]);
                } catch (Throwable $ve) {
                    log_message('error', '[buy_now:vendor_routing] ' . $ve->getMessage());
                }
            }

            // WhatsApp Order Confirmation
            if (!empty($shipping_address['phone'])) {
                try {
                    require_once APPPATH . 'core/agents/WhatsAppCommerceAgent.php';
                    $wa = new \App\Agents\WhatsAppCommerceAgent($sync_pdo, (int)$this->store_id);
                    $wa->evaluate_and_send_cod_confirmation($order_id);
                    $this->Order_model->add_timeline($order_id, 'system', null, 'notification.whatsapp', "WhatsApp order confirmation queued for " . $shipping_address['phone']);
                } catch (Throwable $e) {
                    log_message('error', '[buy_now:whatsapp] ' . $e->getMessage());
                }
            }

            // Queue confirmation email
            if ($this->db->table_exists('jobs_queue')) {
                $this->db->insert('jobs_queue', [
                    'store_id'     => $this->store_id,
                    'queue'        => 'email',
                    'payload'      => json_encode(['job' => 'send_email', 'order_id' => $order_id, 'template' => 'order_confirmed']),
                    'available_at' => date('Y-m-d H:i:s'),
                    'created_at'   => date('Y-m-d H:i:s'),
                ]);
            }

            // 9. Persist Idempotency State
            $this->db->where('idempotency_key', $idempotency_key)->update('idempotency_keys', [
                'status'        => 'completed',
                'order_id'      => $order_id,
                'response_json' => json_encode($response_payload),
            ]);

            // Track order session ownership for IDOR guard in success view
            $this->session->set_userdata([
                'last_buy_now_order_id' => $order_id,
                'checkout_email'        => $customer['email'],
            ]);

            $this->json($response_payload);

        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', '[buy_now] Exception: ' . $e->getMessage());
            $this->audit('order.failed.buy_now', 'orders', 0, [], ['channel' => 'buy_now', 'error' => $e->getMessage()]);
            $this->json_error('An unexpected error occurred while placing order: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Private helper: Auto-upgrade customer loyalty tier based on cumulative order spend
     */
    private function _auto_upgrade_loyalty_tier(int $cust_id): void
    {
        try {
            $spend_row = $this->db->select_sum('total')
                                  ->where('customer_id', $cust_id)
                                  ->where('payment_status', 'paid')
                                  ->get('orders')->row_array();
            $total_spend = (float)($spend_row['total'] ?? 0);

            $tier_q = $this->db->order_by('min_spend', 'DESC');
            if ($this->db->field_exists('store_id', 'loyalty_tiers')) {
                $tier_q->where('store_id', $this->store_id);
            }
            $tiers = $tier_q->get('loyalty_tiers')->result_array();

            $new_tier = 'Bronze';
            foreach ($tiers as $tier) {
                if ($total_spend >= (float)$tier['min_spend']) {
                    $new_tier = $tier['tier_code'] ?? 'Bronze';
                    break;
                }
            }
            $this->db->where('id', $cust_id)->update('customers', ['loyalty_tier' => $new_tier]);
        } catch (Throwable $e) {
            log_message('error', '[_auto_upgrade_loyalty_tier] ' . $e->getMessage());
        }
    }

    /**
     * AJAX endpoint: Buy Again (1-Click Reorder from Past Order)
     * Re-validates items from past order against current live catalog,
     * checks stock and price, and launches Buy Now confirmation flow.
     */
    public function buy_again()
    {
        $customer_id = (int)$this->session->userdata('customer_id');
        if (!$customer_id) {
            $this->json_error('Please sign in to reorder from your history.', 401);
            return;
        }

        $order_id = (int)$this->input->post('order_id');
        $order = $this->Order_model->get_with_items($order_id);

        if (!$order || (int)$order['customer_id'] !== $customer_id) {
            $this->json_error('Order record not found.', 404);
            return;
        }

        if (empty($order['items'])) {
            $this->json_error('No items found in this order to reorder.', 400);
            return;
        }

        // Take primary item from past order (or if single item)
        $first_item = $order['items'][0];
        $variant_id = (int)$first_item['variant_id'];

        // Re-check live variant
        $variant = $this->db->select('pv.*, p.title AS product_title, p.base_price, p.status, p.requires_shipping, pi.url AS image_url')
                            ->from('product_variants pv')
                            ->join('products p', 'p.id = pv.product_id')
                            ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                            ->where('pv.id', $variant_id)
                            ->where('p.store_id', $this->store_id)
                            ->get()->row_array();

        if (!$variant || (int)$variant['is_active'] !== 1 || $variant['status'] !== 'active') {
            $this->json_error('"' . ($first_item['product_title'] ?? 'Item') . '" is no longer available in the boutique collection.', 400);
            return;
        }

        $stock = (int)$variant['inventory_qty'];
        if ($stock < 1) {
            $this->json_error('"' . ($first_item['product_title'] ?? 'Item') . '" is currently out of stock.', 400);
            return;
        }

        // Pass to buy_now_preview flow
        $_POST['variant_id'] = $variant['id'];
        $_POST['quantity']   = 1;
        $_POST['size']       = $variant['option1_value'] ?? 'Standard';
        $_POST['color']      = $variant['option2_value'] ?? 'Original';
        $this->buy_now_preview();
    }
}

