<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $search = $this->input->get('q', true);
        if (!empty($search)) {
            $this->db->group_start()
                     ->like('email', $search)
                     ->or_like('first_name', $search)
                     ->or_like('last_name', $search)
                     ->or_like('phone', $search)
                     ->group_end();
        }

        $customers = $this->db->order_by('id', 'DESC')->get('customers')->result_array();

        // Also fetch from user table if present
        $legacy_users = [];
        if ($this->db->table_exists('user')) {
            $legacy_users = $this->db->order_by('id', 'DESC')->get('user')->result_array();
        }

        $data = [
            'title'        => 'Customer Directory — NovaDrop Admin',
            'customers'    => $customers,
            'legacy_users' => $legacy_users,
            'search'       => $search,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/customers/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
