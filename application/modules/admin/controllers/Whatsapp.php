<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Whatsapp extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $tickets = [];
        if ($this->db->table_exists('tickets')) {
            $tickets = $this->db->order_by('id', 'DESC')->get('tickets')->result_array();
        }

        $data = [
            'title'   => 'Tickets & Support Broadcast — NovaDrop Admin',
            'tickets' => $tickets,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/whatsapp/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
