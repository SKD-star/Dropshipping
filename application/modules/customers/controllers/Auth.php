<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer Auth Controller
 * Handles customer registration, login, logout, password recovery, and guest cart merge
 */
class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model(['customers/Customer_model', 'cart/Cart_model']);
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

    public function login()
    {
        if ($this->session->userdata('customer')) {
            redirect('account');
            return;
        }

        if ($this->input->method() === 'post') {
            $this->rate_limit('customer_login:' . $this->input->ip_address(), 10, 60);

            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email', true);
                $password = $this->input->post('password');

                $customer = $this->Customer_model->authenticate($email, $password);
                if ($customer) {
                    $this->session->set_userdata([
                        'customer'    => $customer,
                        'customer_id' => $customer['id'],
                    ]);

                    // Merge guest cart if active
                    $guest_cart = $this->session->userdata('cart_id');
                    if ($guest_cart) {
                        $merged_id = $this->Cart_model->merge_guest_cart($guest_cart, $customer['id']);
                        $this->session->set_userdata('cart_id', $merged_id);
                    }

                    $this->session->set_flashdata('success', 'Welcome back, ' . htmlspecialchars($customer['name']) . '!');
                    
                    $redirect_to = $this->input->get_post('redirect', true);
                    if ($redirect_to && in_array($redirect_to, ['checkout', 'checkout/payment', 'cart', 'shop'])) {
                        redirect($redirect_to);
                    } else {
                        redirect('account');
                    }
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Invalid email or password.');
                }
            }
        }

        $data = [
            'title'         => 'Sign In — ' . env('APP_NAME', 'NovaDrop'),
            'home_settings' => $this->_get_home_settings(),
            'cart_count'    => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('customers/auth/login', $data);
        $this->load->view('storefront/layout/footer', $data);
    }


    public function register()
    {
        if ($this->session->userdata('customer')) {
            redirect('account');
            return;
        }

        if ($this->input->method() === 'post') {
            $this->rate_limit('customer_reg:' . $this->input->ip_address(), 5, 60);

            $this->form_validation->set_rules('name', 'Full Name', 'required|trim|max_length[120]');
            $this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[customers.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|min_length[8]');

            if ($this->form_validation->run()) {
                $country_code = $this->input->post('country_code', true) ?: '+91';
                $raw_phone = $this->input->post('phone', true);
                $full_phone = $raw_phone ? ($country_code . ' ' . ltrim($raw_phone, '0')) : null;

                $address = trim($this->input->post('address', true) ?? '');
                $city    = trim($this->input->post('city', true) ?? '');
                $state   = trim($this->input->post('state', true) ?? '');
                $pincode = trim($this->input->post('pincode', true) ?? '');

                $meta = [
                    'address'                   => $address,
                    'city'                      => $city,
                    'state'                     => $state,
                    'pincode'                   => $pincode,
                    'formatted_address'         => implode(', ', array_filter([$address, $city, $state, $pincode])),
                    'whatsapp_optin'            => (bool)$this->input->post('whatsapp_optin'),
                    'whatsapp_phone'            => $full_phone,
                    'design_consultation_alerts' => true,
                    'order_dispatch_alerts'     => true,
                    'lumina_points'             => 150
                ];

                $cust_id = $this->Customer_model->register(
                    $this->input->post('name', true),
                    $this->input->post('email', true),
                    $this->input->post('password'),
                    $full_phone,
                    $meta
                );

                if ($cust_id) {
                    $customer = $this->Customer_model->get_by_id($cust_id);
                    $this->session->set_userdata([
                        'customer'    => $customer,
                        'customer_id' => $cust_id,
                    ]);

                    // Merge guest cart if active
                    $guest_cart = $this->session->userdata('cart_id');
                    if ($guest_cart) {
                        $merged_id = $this->Cart_model->merge_guest_cart($guest_cart, $customer['id']);
                        $this->session->set_userdata('cart_id', $merged_id);
                    }

                    $this->session->set_flashdata('success', 'Atelier account created! Welcome, ' . htmlspecialchars($customer['name']) . '.');
                    redirect('account');
                    return;
                }
            }
        }

        $data = [
            'title'         => 'Create Atelier Account — LUMINA',
            'home_settings' => $this->_get_home_settings(),
            'cart_count'    => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('customers/auth/register', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    /**
     * Google OAuth Login — Server-side ID Token Verification
     * Expects POST: { id_token: <Google ID Token from client-side Google Sign-In } 
     */
    public function google_login()
    {
        // Only accept POST to prevent CSRF via direct URL navigation
        if ($this->input->method() !== 'post') {
            if ($this->input->is_ajax_request()) {
                $this->json_error('Invalid request method.');
            } else {
                redirect('account/login');
            }
            return;
        }

        $id_token = trim($this->input->post('id_token', true) ?? '');

        if (empty($id_token)) {
            if ($this->input->is_ajax_request()) {
                $this->json_error('Google authentication token is missing.');
            } else {
                $this->session->set_flashdata('error', 'Google sign-in failed: missing token.');
                redirect('account/login');
            }
            return;
        }

        // Server-side token verification with Google's tokeninfo endpoint
        $google_client_id = env('GOOGLE_CLIENT_ID', '');
        if (empty($google_client_id)) {
            $this->json_error('Google Sign-In is not configured on this store.');
            return;
        }

        $verify_url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($id_token);
        $ch = curl_init($verify_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $raw = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200 || empty($raw)) {
            log_message('error', '[Customer Auth::google_login] Token verification HTTP ' . $http_code);
            $this->json_error('Google sign-in verification failed. Please try again.');
            return;
        }

        $payload = json_decode($raw, true);
        if (empty($payload) || empty($payload['email']) || empty($payload['sub'])) {
            $this->json_error('Invalid Google token payload.');
            return;
        }

        // Verify audience matches our app to prevent token substitution attacks
        $aud = $payload['aud'] ?? '';
        if ($aud !== $google_client_id) {
            log_message('error', '[Customer Auth::google_login] Audience mismatch: ' . $aud);
            $this->json_error('Google token audience mismatch. Authentication rejected.');
            return;
        }

        // Verify token is not expired
        if (!empty($payload['exp']) && (int)$payload['exp'] < time()) {
            $this->json_error('Google token has expired. Please sign in again.');
            return;
        }

        $google_email = strtolower(trim($payload['email']));
        $google_name  = $payload['name'] ?? explode('@', $google_email)[0];
        $google_sub   = $payload['sub'];
        $google_pic   = $payload['picture'] ?? null;

        $customer = $this->Customer_model->find_or_create_google_user([
            'email'   => $google_email,
            'name'    => $google_name,
            'id'      => $google_sub,
            'sub'     => $google_sub,
            'picture' => $google_pic,
        ]);

        if ($customer) {
            $this->session->set_userdata([
                'customer'    => $customer,
                'customer_id' => $customer['id'],
            ]);

            // Merge guest cart
            $guest_cart = $this->session->userdata('cart_id');
            if ($guest_cart) {
                $merged_id = $this->Cart_model->merge_guest_cart($guest_cart, $customer['id']);
                $this->session->set_userdata('cart_id', $merged_id);
            }

            if ($this->input->is_ajax_request()) {
                $this->json_success('Authenticated with Google successfully!', ['redirect' => base_url('account')]);
                return;
            }

            $this->session->set_flashdata('success', 'Authenticated with Google. Welcome, ' . htmlspecialchars($customer['name']) . '!');
            redirect('account');
            return;
        }

        $this->json_error('Google sign-in could not be completed. Please try again.');
    }

    public function google_callback()
    {
        $this->google_login();
    }

    public function logout()
    {
        $this->session->unset_userdata(['customer', 'customer_id']);
        redirect('');
    }

    public function send_otp()
    {
        $phone = trim($this->input->post('phone', true) ?? '');
        $email = trim($this->input->post('email', true) ?? '');
        $identifier = trim($this->input->post('identifier', true) ?? '');

        if (empty($phone) && !empty($identifier)) {
            if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
                $email = $identifier;
            } else {
                $phone = $identifier;
            }
        }

        if (empty($phone) && empty($email)) {
            $this->json_error('Please enter your mobile phone number or email address.');
            return;
        }

        $res = $this->Customer_model->generate_and_send_dual_otp($phone, $email);
        if ($res['success']) {
            $this->json_success($res['message'], [
                'identifier' => $res['identifier'],
                'phone'      => $res['phone'],
                'email'      => $res['email'],
                'type'       => $res['type'],
                // NOTE: otp_code intentionally NOT returned in response
            ]);
        } else {
            $this->json_error($res['message'] ?? 'Unable to send OTP.');
        }
    }

    public function verify_otp()
    {
        $phone      = trim($this->input->post('phone', true) ?? '');
        $email      = trim($this->input->post('email', true) ?? '');
        $identifier = trim($this->input->post('identifier', true) ?? '');
        $otp_code   = trim($this->input->post('otp_code', true) ?? '');
        $redirect   = $this->input->post('redirect', true) ?: 'account';

        if (empty($phone) && !empty($identifier)) {
            if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
                $email = $identifier;
            } else {
                $phone = $identifier;
            }
        }

        if ((empty($phone) && empty($email)) || empty($otp_code)) {
            $this->json_error('Please provide both your mobile number / email and the 6-digit OTP code.');
            return;
        }

        $res = $this->Customer_model->verify_and_login_dual_otp($phone, $email, $otp_code);
        if ($res['success'] && !empty($res['customer'])) {
            $customer = $res['customer'];
            $this->session->set_userdata([
                'customer'    => $customer,
                'customer_id' => $customer['id'],
            ]);

            // Merge guest cart if active
            $guest_cart = $this->session->userdata('cart_id');
            if ($guest_cart) {
                $merged_id = $this->Cart_model->merge_guest_cart($guest_cart, $customer['id']);
                $this->session->set_userdata('cart_id', $merged_id);
            }

            $dest = in_array($redirect, ['checkout', 'checkout/payment', 'cart', 'shop']) ? base_url($redirect) : base_url('account');
            
            $this->session->set_flashdata('success', 'Welcome, ' . htmlspecialchars($customer['name']) . '! You are securely logged in.');
            
            $this->json_success($res['message'], [
                'redirect' => $dest,
                'customer' => [
                    'id'    => $customer['id'],
                    'name'  => $customer['name'],
                    'email' => $customer['email'],
                    'phone' => $customer['phone'] ?? ''
                ]
            ]);
        } else {
            $this->json_error($res['message'] ?? 'Invalid OTP code.');
        }
    }

    public function forgot_password()
    {
        $data = [
            'title'         => 'Forgot Password — LUMINA',
            'home_settings' => $this->_get_home_settings(),
            'cart_count'    => $this->_get_cart_count(),
        ];
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('customers/auth/forgot_password', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

}
