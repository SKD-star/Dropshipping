<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
    }

    public function index()
    {
        $logs = [];
        if ($this->db->table_exists('audit_log')) {
            $logs = $this->db->order_by('id', 'DESC')->limit(100)->get('audit_log')->result_array();
        }

        $data = [
            'title' => 'Activity & Audit Trail — NovaDrop Admin',
            'logs'  => $logs,
            'total' => count($logs),
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/audit/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
