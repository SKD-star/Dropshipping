<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — MY_Controller
 * Base controller for all modules. Loads .env, bootstraps composer autoloader,
 * sets up audit logging, CSRF, and rate limiting.
 */
#[AllowDynamicProperties]
class MY_Controller extends CI_Controller {

    /** @var int Always set — every data query scoped to this */
    protected int $store_id = 1;

    /** @var array|null Authenticated admin user */
    protected ?array $admin_user = null;

    /** @var array|null Authenticated customer */
    protected ?array $current_customer = null;

    public function __construct()
    {
        parent::__construct();

        // Load composer autoloader
        if (file_exists(FCPATH . 'vendor/autoload.php')) {
            require_once FCPATH . 'vendor/autoload.php';
        }

        // Bootstrap .env
        $this->_load_env();

        // Set store_id (single-store now; multi-tenant: resolve from domain)
        $this->store_id = (int) $this->config->item('store_id') ?: 1;

        // Load helpers and libraries universally needed
        $this->load->helper(['url', 'form', 'security', 'language', 'cookie']);
        $this->load->library(['session']);

        // Universal Affiliate / Referral Attribution Capture (?ref=... or ?aff=...)
        $ref_code = $this->input->get('ref', true) ?: ($this->input->get('aff', true) ?: $this->input->get('referral', true));
        if ($ref_code) {
            $ref_clean = strtoupper(substr(preg_replace('/[^A-Za-z0-9_-]/', '', $ref_code), 0, 32));
            if (!empty($ref_clean)) {
                $this->session->set_userdata('nd_referral_code', $ref_clean);
                set_cookie([
                    'name'     => 'nd_affiliate_ref',
                    'value'    => $ref_clean,
                    'expire'   => 30 * 86400,
                    'path'     => '/',
                    'secure'   => false,
                    'httponly' => true,
                ]);
            }
        }
    }

    /**
     * Get active affiliate / referral code from request, session, or cookie
     */
    protected function get_active_referral_code(): ?string
    {
        $code = $this->input->get('ref', true) 
             ?: ($this->input->get('aff', true) 
             ?: ($this->session->userdata('nd_referral_code') 
             ?: $this->input->cookie('nd_affiliate_ref', true)));
        return !empty($code) ? strtoupper(substr(preg_replace('/[^A-Za-z0-9_-]/', '', $code), 0, 32)) : null;
    }

    /**
     * Load .env file using vlucas/phpdotenv if available, else parse manually
     */
    protected function _load_env(): void
    {
        $env_path = FCPATH . '.env';
        if ( ! file_exists($env_path)) {
            return;
        }

        if (class_exists('\Dotenv\Dotenv')) {
            $dotenv = \Dotenv\Dotenv::createImmutable(FCPATH);
            $dotenv->safeLoad();
        } else {
            // Fallback manual parser
            foreach (file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') === false) continue;
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val);
                if ( ! array_key_exists($key, $_SERVER) && ! array_key_exists($key, $_ENV)) {
                    putenv("$key=$val");
                    $_ENV[$key]    = $val;
                    $_SERVER[$key] = $val;
                }
            }
        }
    }

    /**
     * Require admin authentication — redirect to login if not authenticated.
     */
    protected function require_admin(): void
    {
        $user = $this->session->userdata('admin_user');
        if (empty($user) || empty($user['id'])) {
            $admin_id = $this->session->userdata('admin_user_id');
            if ($admin_id) {
                $user = [
                    'id'        => (int)$admin_id,
                    'name'      => $this->session->userdata('admin_name') ?: 'admin',
                    'email'     => $this->session->userdata('admin_email') ?: 'admin@novadrop.in',
                    'role_id'   => (int)($this->session->userdata('admin_role_id') ?: 1),
                    'role_name' => $this->session->userdata('admin_role_name') ?: 'Super Admin',
                ];
                $this->session->set_userdata('admin_user', $user);
                $this->session->set_userdata('admin_permissions', ['*']);
            } elseif (!empty($_SESSION['admin']) && (!empty($_SESSION['loggedin']) || !empty($_SESSION['admid']))) {
                $user = [
                    'id'        => 1,
                    'name'      => $_SESSION['admin'],
                    'email'     => strtolower($_SESSION['admin']) . '@novadrop.in',
                    'role_id'   => 1,
                    'role_name' => 'Super Admin',
                ];
                $this->session->set_userdata('admin_user', $user);
                $this->session->set_userdata('admin_user_id', 1);
                $this->session->set_userdata('admin_name', $user['name']);
                $this->session->set_userdata('admin_email', $user['email']);
                $this->session->set_userdata('admin_permissions', ['*']);
            } else {
                redirect('admin/auth/login');
                exit;
            }
        }
        $this->admin_user = $user;
    }

    /**
     * Check admin permission (e.g. 'products.edit')
     */
    protected function require_permission(string $permission): void
    {
        $this->require_admin();
        // Permissions are stored as array in session after login
        $perms = $this->session->userdata('admin_permissions') ?? [];
        if ( ! in_array($permission, $perms) && ! in_array('*', $perms)) {
            $this->_forbidden("You don't have permission: $permission");
        }
    }

    /**
     * Require customer authentication
     */
    protected function require_customer(): void
    {
        $customer = $this->session->userdata('customer');
        if (empty($customer) || empty($customer['id'])) {
            $this->session->set_userdata('redirect_after_login', current_url());
            redirect('account/login');
            exit;
        }
        $this->current_customer = $customer;
    }

    /**
     * Get currently logged-in customer (null if guest)
     */
    protected function get_customer(): ?array
    {
        return $this->session->userdata('customer') ?: null;
    }

    /**
     * Verify CSRF token on all state-changing requests
     */
    protected function verify_csrf(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $token_name = env('CSRF_TOKEN_NAME', 'csrf_novadrop');
        $submitted  = $this->input->post($token_name) ?? $this->input->get_request_header('X-CSRF-Token');
        $expected   = $this->security->get_csrf_hash();
        if ( ! hash_equals($expected, (string)$submitted)) {
            $this->_error('Invalid CSRF token.', 403);
        }
    }

    /**
     * Simple DB-backed rate limiter
     * @param string $key  e.g. 'auth:127.0.0.1'
     * @param int    $max  max requests
     * @param int    $window seconds
     */
    protected function rate_limit(string $key, int $max = 10, int $window = 60): void
    {
        $cache_key = 'rate_' . md5($key);
        // Use CI file cache or APCu if available
        if (function_exists('apcu_fetch')) {
            $count = apcu_fetch($cache_key) ?: 0;
            if ($count >= $max) {
                $this->_error('Too many requests. Please wait.', 429);
            }
            apcu_store($cache_key, $count + 1, $window);
        }
        // Fallback: session-based (not great for distributed but fine for single-server XAMPP)
        $session_key = 'rl_' . $cache_key;
        $data = $this->session->userdata($session_key) ?: ['count' => 0, 'reset_at' => time() + $window];
        if (time() > $data['reset_at']) {
            $data = ['count' => 0, 'reset_at' => time() + $window];
        }
        $data['count']++;
        if ($data['count'] > $max) {
            $this->_error('Too many requests. Please wait.', 429);
        }
        $this->session->set_userdata($session_key, $data);
    }

    /**
     * Write to audit_log table
     */
    protected function audit(string $action, string $entity_type = '', int $entity_id = 0, array $old = [], array $new = []): void
    {
        try {
            $this->db->insert('audit_log', [
                'store_id'    => $this->store_id,
                'actor_type'  => $this->admin_user ? 'admin' : ($this->current_customer ? 'customer' : 'system'),
                'actor_id'    => $this->admin_user['id'] ?? ($this->current_customer['id'] ?? null),
                'action'      => $action,
                'entity_type' => $entity_type,
                'entity_id'   => $entity_id ?: null,
                'old_values'  => $old ? json_encode($old) : null,
                'new_values'  => $new ? json_encode($new) : null,
                'ip_address'  => $this->input->ip_address(),
                'user_agent'  => substr($this->input->user_agent(), 0, 500),
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $e) {
            log_message('error', '[audit] ' . $e->getMessage());
        }
    }

    /**
     * Structured error logger — logs to error_log table AND CI log file
     */
    protected function log_error(Throwable $e, string $context = '', array $extra = []): void
    {
        $message = $e->getMessage();
        $trace   = $e->getTraceAsString();
        $file    = $e->getFile();
        $line    = $e->getLine();

        log_message('error', "[$context] $message in $file:$line\n$trace");

        try {
            $this->db->insert('error_log', [
                'store_id'   => $this->store_id,
                'severity'   => 'error',
                'context'    => $context ?: get_class($this),
                'message'    => $message,
                'trace'      => $trace,
                'file'       => $file,
                'line'       => $line,
                'extra_json' => $extra ? json_encode($extra) : null,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $inner) {
            log_message('error', '[error_log_write_failed] ' . $inner->getMessage());
        }
    }

    // ─── Output Helpers ──────────────────────────────────────

    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function json_success(string $message = 'OK', array $data = []): void
    {
        $this->json(array_merge(['success' => true, 'message' => $message], $data));
    }

    protected function json_error(string $message, int $status = 400, array $data = []): void
    {
        $this->json(array_merge(['success' => false, 'message' => $message], $data), $status);
    }

    protected function _error(string $msg, int $code = 400): void
    {
        if ($this->input->is_ajax_request()) {
            $this->json_error($msg, $code);
        }
        show_error($msg, $code);
        exit;
    }

    protected function _forbidden(string $msg = 'Forbidden'): void
    {
        $this->_error($msg, 403);
    }
}

// ─── Global helper: env() ───────────────────────────────────
if ( ! function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $val = $_ENV[$key] ?? getenv($key);
        return ($val === false || $val === null) ? $default : $val;
    }
}
