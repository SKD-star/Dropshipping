<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function login()
    {
        if ($this->session->userdata('admin_user') || $this->session->userdata('admin_user_id') || (!empty($_SESSION['admin']) && !empty($_SESSION['loggedin']))) {
            redirect('admin/dashboard');
        }

        $error = null;

        if ($this->input->method() === 'post') {
            $email = trim($this->input->post('email', true));
            $password = $this->input->post('password');

            // 1. Check admin_users table
            $user = $this->db->where('email', $email)
                             ->or_where('name', $email)
                             ->get('admin_users')
                             ->row_array();

            $auth_ok = false;
            $admin_name = 'admin';

            if ($user && password_verify($password, $user['password_hash'])) {
                $auth_ok = true;
                $admin_name = $user['name'] ?? 'admin';
                $this->session->set_userdata([
                    'admin_user' => [
                        'id'        => (int)$user['id'],
                        'email'     => $user['email'],
                        'name'      => $user['name'],
                        'role_id'   => (int)($user['role_id'] ?? 1),
                        'role_name' => 'Super Admin',
                    ],
                    'admin_user_id'     => $user['id'],
                    'admin_email'       => $user['email'],
                    'admin_name'        => $user['name'],
                    'admin_role_id'     => $user['role_id'] ?? 1,
                    'admin_role_name'   => 'Super Admin',
                    'admin_permissions' => ['*'],
                ]);
            }

            // 2. Check admin table fallback
            if (!$auth_ok && $this->db->table_exists('admin')) {
                $adm = $this->db->where('username', $email)->get('admin')->row_array();
                if ($adm && password_verify($password, $adm['password'])) {
                    $auth_ok = true;
                    $admin_name = $adm['username'] ?? 'admin';
                    $this->session->set_userdata([
                        'admin_user' => [
                            'id'        => (int)($adm['id'] ?? 1),
                            'email'     => $adm['username'] . '@novadrop.in',
                            'name'      => $adm['username'],
                            'role_id'   => 1,
                            'role_name' => 'Super Admin',
                        ],
                        'admin_user_id'     => $adm['id'] ?? 1,
                        'admin_email'       => $adm['username'] . '@novadrop.in',
                        'admin_name'        => $adm['username'],
                        'admin_role_id'     => 1,
                        'admin_role_name'   => 'Super Admin',
                        'admin_permissions' => ['*'],
                    ]);
                }
            }

            if ($auth_ok) {
                // Sync native session for standalone /admin/ pages
                if (session_status() === PHP_SESSION_NONE) {
                    @session_name('js239');
                    @session_start();
                }
                $_SESSION['loggedin'] = true;
                $_SESSION['admin'] = $admin_name;
                $_SESSION['admid'] = bin2hex(random_bytes(16));
                $_SESSION['type'] = 'admin';
                // Log to audit if table exists
                if ($this->db->table_exists('audit_log')) {
                    $this->db->insert('audit_log', [
                        'store_id'    => 1,
                        'actor_type'  => 'admin',
                        'actor_id'    => $this->session->userdata('admin_user_id'),
                        'action'      => 'admin.login.success',
                        'ip_address'  => $this->input->ip_address(),
                        'created_at'  => date('Y-m-d H:i:s'),
                    ]);
                }

                redirect('admin/dashboard');
            } else {
                $error = 'Invalid credentials. Please verify your username and password.';
            }
        }

        $data = [
            'title' => 'Admin Login — NovaDrop',
            'error' => $error,
            'email' => $this->input->post('email', true) ?: 'admin@novadrop.in',
        ];

        $this->load->view('admin/auth/login', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata([
            'admin_user_id',
            'admin_email',
            'admin_name',
            'admin_role_id',
            'admin_role_name',
            'admin_permissions',
        ]);
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
