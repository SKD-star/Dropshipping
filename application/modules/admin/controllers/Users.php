<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function index()
    {
        redirect('admin/customers');
    }

    public function create()
    {
        if ($this->input->method() === 'post') {
            $username = trim($this->input->post('username', true));
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');

            if (empty($username) || empty($password)) {
                $this->session->set_flashdata('error', 'All fields are required.');
            } elseif ($password !== $cpassword) {
                $this->session->set_flashdata('error', 'Passwords do not match.');
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $email = strpos($username, '@') !== false ? $username : ($username . '@novadrop.in');

                $this->db->insert('admin_users', [
                    'store_id'      => 1,
                    'role_id'       => 1,
                    'name'          => $username,
                    'email'         => $email,
                    'password_hash' => $hashed,
                    'is_active'     => 1,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]);

                if ($this->db->table_exists('admin')) {
                    $admid = uniqid();
                    $this->db->insert('admin', [
                        'admid'    => $admid,
                        'astat'    => 'admin',
                        'username' => $username,
                        'password' => $hashed,
                        'date'     => date('Y-m-d H:i:s'),
                    ]);
                }

                $this->session->set_flashdata('success', "Administrator '{$username}' created successfully!");
                redirect('admin/dashboard');
            }
        }

        $data = [
            'title' => 'Create Administrator Account — NovaDrop Admin',
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/users/create', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
