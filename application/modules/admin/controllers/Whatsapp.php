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
        if ($this->input->method() === 'post') {
            $act = $this->input->post('action_type');

            if ($act === 'update_ticket') {
                $tid = (int)$this->input->post('ticket_id');
                $new_status = $this->input->post('status', true);
                if ($this->db->table_exists('tickets') && $tid > 0) {
                    $this->db->where('id', $tid)->update('tickets', [
                        'status'     => $new_status,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    $this->session->set_flashdata('success', "Ticket #{$tid} updated to {$new_status}.");
                }
            } elseif ($act === 'create_ticket') {
                if ($this->db->table_exists('tickets')) {
                    $cols = $this->db->list_fields('tickets');
                    $t_data = [
                        'tid'        => 'TICK-' . strtoupper(substr(md5(uniqid()), 0, 6)),
                        'name'       => trim($this->input->post('name', true)),
                        'email'      => trim($this->input->post('email', true)),
                        'subject'    => trim($this->input->post('subject', true)),
                        'status'     => 'open',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                    $clean = array_intersect_key($t_data, array_flip($cols));
                    $this->db->insert('tickets', $clean);
                    $this->session->set_flashdata('success', 'Support inquiry ticket logged.');
                }
            } elseif ($act === 'send_broadcast') {
                $audience = $this->input->post('audience_group', true);
                $msg      = trim($this->input->post('broadcast_message', true));
                $this->audit('whatsapp.broadcast_sent', 'marketing', 0, [], ['audience' => $audience, 'length' => strlen($msg)]);
                $this->session->set_flashdata('success', "🚀 Broadcast dispatched to {$audience} successfully!");
            }

            redirect('admin/whatsapp');
        }

        $tickets = [];
        if ($this->db->table_exists('tickets')) {
            $t_q = $this->db->order_by('id', 'DESC');
            if ($this->db->field_exists('store_id', 'tickets')) {
                $t_q->where('store_id', $this->store_id);
            }
            $tickets = $t_q->get('tickets')->result_array();
        }

        // Count customer audience groups
        $total_customers = $this->db->table_exists('customers') ? $this->db->count_all('customers') : 0;

        $data = [
            'title'           => 'Tickets & Support Broadcast — NovaDrop Admin',
            'tickets'         => $tickets,
            'total_customers' => $total_customers,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/whatsapp/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
