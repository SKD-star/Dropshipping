<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customer_model
 * Customer profiles, authentication, wishlist, and saved addresses
 */
class Customer_model extends MY_Model
{
    protected string $table        = 'customers';
    protected bool   $store_scoped = true;

    public function register(string $name, string $email, string $password, ?string $phone = null, ?array $meta = null): int|false
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $data = [
            'store_id'       => $this->store_id,
            'name'           => $name,
            'email'          => strtolower(trim($email)),
            'phone'          => $phone,
            'password_hash'  => $hash,
            'is_active'      => 1,
            'meta_json'      => $meta ? json_encode($meta) : null,
            'created_at'     => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('customers', $data);
        return $this->db->insert_id() ?: false;
    }

    public function find_or_create_google_user(array $google_data): ?array
    {
        $email = strtolower(trim($google_data['email'] ?? ''));
        if (empty($email)) return null;

        $existing = $this->db->where('store_id', $this->store_id)
                             ->where('email', $email)
                             ->get('customers')->row_array();

        if ($existing) {
            $meta = !empty($existing['meta_json']) ? json_decode($existing['meta_json'], true) : [];
            $meta['google_id'] = $google_data['id'] ?? ($google_data['sub'] ?? '');
            if (!empty($google_data['picture'])) $meta['avatar'] = $google_data['picture'];
            
            $this->db->where('id', $existing['id'])->update('customers', [
                'email_verified' => 1,
                'meta_json'      => json_encode($meta),
                'updated_at'     => date('Y-m-d H:i:s')
            ]);
            return $this->get_by_id($existing['id']);
        }

        // Register new customer from Google account
        $meta = [
            'provider'  => 'google',
            'google_id' => $google_data['id'] ?? ($google_data['sub'] ?? ''),
            'avatar'    => $google_data['picture'] ?? null,
            'whatsapp_optin' => true
        ];

        $random_pw = bin2hex(random_bytes(16));
        $hash = password_hash($random_pw, PASSWORD_BCRYPT, ['cost' => 12]);

        $this->db->insert('customers', [
            'store_id'       => $this->store_id,
            'name'           => $google_data['name'] ?? explode('@', $email)[0],
            'email'          => $email,
            'phone'          => $google_data['phone'] ?? null,
            'password_hash'  => $hash,
            'email_verified' => 1,
            'is_active'      => 1,
            'meta_json'      => json_encode($meta),
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        $new_id = $this->db->insert_id();
        return $new_id ? $this->get_by_id($new_id) : null;
    }

    public function get_by_id(int $id): ?array
    {
        return $this->find($id);
    }

    public function update_profile(int $customer_id, array $data): bool
    {
        return $this->db->where('id', $customer_id)
                        ->where('store_id', $this->store_id)
                        ->update('customers', $data);
    }

    public function authenticate(string $email, string $password): ?array
    {
        $cust = $this->db->where('store_id', $this->store_id)
                         ->where('email', strtolower(trim($email)))
                         ->where('is_active', 1)
                         ->get('customers')->row_array();

        if ($cust && password_verify($password, $cust['password_hash'])) {
            return $cust;
        }
        return null;
    }

    public function get_wishlist(int $customer_id): array
    {
        return $this->db->select('w.*, p.title, p.slug, pi.url AS image_url, MIN(pv.price) AS min_price')
            ->from('wishlists w')
            ->join('products p', 'p.id = w.product_id')
            ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
            ->join('product_variants pv', 'pv.product_id = p.id AND pv.is_active = 1', 'left')
            ->where('w.customer_id', $customer_id)
            ->where('p.store_id', $this->store_id)
            ->where('p.status', 'active')
            ->group_by('w.id')
            ->get()->result_array();
    }

    public function ensure_otp_table()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `customer_otps` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `store_id` INT DEFAULT 1,
            `identifier` VARCHAR(191) NOT NULL,
            `otp_code` VARCHAR(10) NOT NULL,
            `type` ENUM('phone', 'email') DEFAULT 'phone',
            `expires_at` DATETIME NOT NULL,
            `is_used` TINYINT(1) DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            INDEX (`identifier`),
            INDEX (`otp_code`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function generate_and_send_otp(string $identifier): array
    {
        return $this->generate_and_send_dual_otp($identifier, null);
    }

    public function generate_and_send_dual_otp(?string $phone, ?string $email = null): array
    {
        $this->ensure_otp_table();

        $clean_phone = trim($phone ?? '');
        $clean_email = trim($email ?? '');

        // If identifier was passed in phone position as email
        if (filter_var($clean_phone, FILTER_VALIDATE_EMAIL) && empty($clean_email)) {
            $clean_email = $clean_phone;
            $clean_phone = '';
        }

        if (!empty($clean_phone)) {
            $clean_phone = preg_replace('/[^0-9+]/', '', $clean_phone);
            if (strlen($clean_phone) === 10) {
                $clean_phone = '+91' . $clean_phone;
            }
        }

        $primary_identifier = !empty($clean_phone) ? $clean_phone : $clean_email;
        $type = !empty($clean_phone) ? 'phone' : 'email';

        // Generate secure 6-digit OTP
        $otp_code = (string)mt_rand(100000, 999999);
        $expires_at = date('Y-m-d H:i:s', time() + (10 * 60)); // 10 mins

        // Invalidate older unused OTPs for this identifier
        $this->db->where('identifier', $primary_identifier)->update('customer_otps', ['is_used' => 1]);

        $this->db->insert('customer_otps', [
            'store_id'   => $this->store_id,
            'identifier' => $primary_identifier,
            'otp_code'   => $otp_code,
            'type'       => $type,
            'expires_at' => $expires_at,
            'is_used'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $masked = !empty($clean_phone) 
            ? (substr($clean_phone, 0, 6) . 'XXXX' . substr($clean_phone, -2))
            : $clean_email;

        return [
            'success'    => true,
            'identifier' => $primary_identifier,
            'phone'      => $clean_phone,
            'email'      => $clean_email,
            'type'       => $type,
            'otp_code'   => $otp_code,
            'message'    => "6-Digit verification code sent to " . $masked
        ];
    }

    public function verify_and_login_otp(string $identifier, string $otp_code): array
    {
        return $this->verify_and_login_dual_otp($identifier, null, $otp_code);
    }

    public function verify_and_login_dual_otp(?string $phone, ?string $email, string $otp_code): array
    {
        $this->ensure_otp_table();

        $clean_phone = trim($phone ?? '');
        $clean_email = trim($email ?? '');

        if (filter_var($clean_phone, FILTER_VALIDATE_EMAIL) && empty($clean_email)) {
            $clean_email = $clean_phone;
            $clean_phone = '';
        }

        if (!empty($clean_phone)) {
            $clean_phone = preg_replace('/[^0-9+]/', '', $clean_phone);
            if (strlen($clean_phone) === 10) {
                $clean_phone = '+91' . $clean_phone;
            }
        }

        $primary_identifier = !empty($clean_phone) ? $clean_phone : $clean_email;
        $otp_code = trim($otp_code);

        // Validate OTP against database record only — no master/demo bypass allowed
        $valid_otp = $this->db->where('identifier', $primary_identifier)
                              ->where('otp_code', $otp_code)
                              ->where('is_used', 0)
                              ->where('expires_at >=', date('Y-m-d H:i:s'))
                              ->order_by('id', 'DESC')
                              ->limit(1)
                              ->get('customer_otps')->row_array();

        if (!$valid_otp) {
            return ['success' => false, 'message' => 'Invalid or expired OTP code. Please request a new code.'];
        }

        $this->db->where('id', $valid_otp['id'])->update('customer_otps', ['is_used' => 1]);

        // Look up customer by phone or email
        $customer = null;
        if (!empty($clean_email)) {
            $customer = $this->db->where('store_id', $this->store_id)
                                 ->where('email', strtolower($clean_email))
                                 ->get('customers')->row_array();
        }

        if (!$customer && !empty($clean_phone)) {
            $raw_digits = preg_replace('/[^0-9]/', '', $clean_phone);
            $last_10 = substr($raw_digits, -10);
            $customer = $this->db->where('store_id', $this->store_id)
                                 ->group_start()
                                     ->where('phone', $clean_phone)
                                     ->or_like('phone', $last_10)
                                 ->group_end()
                                 ->get('customers')->row_array();
        }

        // Auto-provision account if new customer
        if (!$customer) {
            $random_pw = bin2hex(random_bytes(16));
            $hash = password_hash($random_pw, PASSWORD_BCRYPT, ['cost' => 12]);
            
            $derived_name = !empty($clean_email) ? ucfirst(explode('@', $clean_email)[0]) : ('Client ' . substr($clean_phone, -4));
            $final_email = !empty($clean_email) ? strtolower($clean_email) : ('client_' . substr(preg_replace('/[^0-9]/', '', $clean_phone), -10) . '@lumina-atelier.com');
            $final_phone = !empty($clean_phone) ? $clean_phone : null;

            $meta = [
                'auth_type' => 'otp_dual',
                'whatsapp_optin' => true,
                'lumina_points' => 100
            ];

            $this->db->insert('customers', [
                'store_id'       => $this->store_id,
                'name'           => $derived_name,
                'email'          => $final_email,
                'phone'          => $final_phone,
                'password_hash'  => $hash,
                'email_verified' => 1,
                'is_active'      => 1,
                'meta_json'      => json_encode($meta),
                'created_at'     => date('Y-m-d H:i:s'),
            ]);

            $new_id = $this->db->insert_id();
            $customer = $this->get_by_id($new_id);
        } else {
            // Update phone or email if missing
            $updates = [];
            if (empty($customer['phone']) && !empty($clean_phone)) {
                $updates['phone'] = $clean_phone;
            }
            if ((empty($customer['email']) || strpos($customer['email'], '@lumina-atelier.com') !== false) && !empty($clean_email)) {
                $updates['email'] = strtolower($clean_email);
            }
            if (!empty($updates)) {
                $this->db->where('id', $customer['id'])->update('customers', $updates);
                $customer = $this->get_by_id($customer['id']);
            }
        }

        return [
            'success'  => true,
            'message'  => 'Authentication successful! Welcome, ' . ($customer['name'] ?? 'Client') . '.',
            'customer' => $customer
        ];
    }

    public function toggle_wishlist(int $customer_id, int $product_id): bool
    {
        $exists = $this->db->where('customer_id', $customer_id)->where('product_id', $product_id)->get('wishlists')->row_array();
        if ($exists) {
            $this->db->where('id', $exists['id'])->delete('wishlists');
            return false; // removed
        } else {
            $this->db->insert('wishlists', [
                'customer_id' => $customer_id,
                'product_id'  => $product_id,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
            return true; // added
        }
    }

    /**
     * Get customer default shipping address
     */
    public function get_default_address(int $customer_id): ?array
    {
        $customer = $this->db->select('id, default_address_id, default_payment_method')
                             ->where('id', $customer_id)
                             ->where('store_id', $this->store_id)
                             ->get('customers')->row_array();

        if (!empty($customer['default_address_id'])) {
            $addr = $this->db->where('id', $customer['default_address_id'])
                             ->where('customer_id', $customer_id)
                             ->get('addresses')->row_array();
            if ($addr) return $addr;
        }

        // Fallback: Check for address with is_default = 1
        $addr = $this->db->where('customer_id', $customer_id)
                         ->where('is_default', 1)
                         ->order_by('id', 'DESC')
                         ->limit(1)
                         ->get('addresses')->row_array();

        if ($addr) return $addr;

        // Fallback: Latest address
        return $this->db->where('customer_id', $customer_id)
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get('addresses')->row_array();
    }

    /**
     * Get all saved addresses for a customer
     */
    public function get_saved_addresses(int $customer_id): array
    {
        return $this->db->where('customer_id', $customer_id)
                        ->order_by('is_default', 'DESC')
                        ->order_by('id', 'DESC')
                        ->get('addresses')->result_array();
    }

    /**
     * Set default address and payment preferences for customer
     */
    public function set_default_preferences(int $customer_id, ?int $address_id = null, ?string $payment_method = null): bool
    {
        $updates = ['updated_at' => date('Y-m-d H:i:s')];

        if ($address_id !== null) {
            // Verify address belongs to customer
            $addr = $this->db->where('id', $address_id)
                             ->where('customer_id', $customer_id)
                             ->get('addresses')->row_array();
            if ($addr) {
                $updates['default_address_id'] = $address_id;
                // Mark in addresses table as default
                $this->db->where('customer_id', $customer_id)->update('addresses', ['is_default' => 0]);
                $this->db->where('id', $address_id)->update('addresses', ['is_default' => 1]);
            }
        }

        if ($payment_method !== null && in_array(strtolower($payment_method), ['cod', 'razorpay', 'stripe'])) {
            $updates['default_payment_method'] = strtolower($payment_method);
        }

        if (count($updates) > 1) {
            return $this->db->where('id', $customer_id)
                            ->where('store_id', $this->store_id)
                            ->update('customers', $updates);
        }

        return true;
    }

    /**
     * Save or update an address for a customer
     */
    public function save_customer_address(int $customer_id, array $data, bool $is_default = false): int|false
    {
        $payload = [
            'store_id'    => $this->store_id,
            'customer_id' => $customer_id,
            'first_name'  => trim($data['first_name'] ?? ''),
            'last_name'   => trim($data['last_name'] ?? ''),
            'company'     => trim($data['company'] ?? ''),
            'address1'    => trim($data['address1'] ?? ''),
            'address2'    => trim($data['address2'] ?? ''),
            'city'        => trim($data['city'] ?? ''),
            'state'       => trim($data['state'] ?? 'Maharashtra'),
            'pincode'     => trim($data['pincode'] ?? ''),
            'country'     => trim($data['country'] ?? 'IN'),
            'phone'       => trim($data['phone'] ?? ''),
            'is_default'  => $is_default ? 1 : 0,
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        if ($is_default) {
            $this->db->where('customer_id', $customer_id)->update('addresses', ['is_default' => 0]);
        }

        $this->db->insert('addresses', $payload);
        $new_id = $this->db->insert_id();

        if ($new_id && $is_default) {
            $this->db->where('id', $customer_id)->update('customers', ['default_address_id' => $new_id]);
        }

        return $new_id ?: false;
    }
}


