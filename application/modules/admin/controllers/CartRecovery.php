<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — CartRecovery HMVC Controller
 * Route: admin/cart_recovery
 */
class CartRecovery extends MY_Controller
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
        // Recovery stats
        $total_abandoned = $this->db->table_exists('abandoned_cart_log')
            ? $this->db->count_all('abandoned_cart_log') : 0;
        $converted = $this->db->table_exists('abandoned_cart_log')
            ? $this->db->where('status', 'converted')->count_all_results('abandoned_cart_log') : 0;
        $recovery_rate = $total_abandoned > 0 ? round($converted / $total_abandoned * 100, 1) : 0;

        $recent_logs = $this->db->table_exists('abandoned_cart_log')
            ? $this->db->order_by('id', 'DESC')->limit(30)->get('abandoned_cart_log')->result_array()
            : [];

        $browse_logs = $this->db->table_exists('browse_abandonment_log')
            ? $this->db->order_by('id', 'DESC')->limit(20)->get('browse_abandonment_log')->result_array()
            : [];

        $data = [
            'title'           => 'Cart Recovery — NovaDrop Admin',
            'total_abandoned' => $total_abandoned,
            'converted'       => $converted,
            'recovery_rate'   => $recovery_rate,
            'recent_logs'     => $recent_logs,
            'browse_logs'     => $browse_logs,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/cart_recovery/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Sequences ────────────────────────────────────────────
    public function sequences()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('seq_action');

            if ($act === 'create_sequence') {
                $row = [
                    'store_id'  => $this->store_id,
                    'name'      => trim($this->input->post('name', true)),
                    'is_active' => 1,
                ];
                $this->db->insert('abandoned_cart_sequences', $row);
                $this->session->set_flashdata('success', 'Sequence created.');

            } elseif ($act === 'toggle_sequence') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('abandoned_cart_sequences')->row_array();
                if ($cur) { $this->db->where('id', $id)->update('abandoned_cart_sequences', ['is_active' => $cur['is_active'] ? 0 : 1]); }
                $this->session->set_flashdata('success', 'Sequence status toggled.');

            } elseif ($act === 'add_step') {
                $seq_id       = (int)$this->input->post('sequence_id');
                $delay        = (int)($this->input->post('delay_minutes') ?: 60);
                $channel      = in_array($this->input->post('channel'), ['email','whatsapp','sms']) ? $this->input->post('channel') : 'email';
                $template_key = trim($this->input->post('template_key', true));
                $this->db->insert('abandoned_cart_steps', [
                    'sequence_id'    => $seq_id,
                    'delay_minutes'  => $delay,
                    'channel'        => $channel,
                    'template_key'   => $template_key,
                ]);
                $this->session->set_flashdata('success', 'Step added to sequence.');

            } elseif ($act === 'delete_step') {
                $step_id = (int)$this->input->post('step_id');
                $this->db->where('id', $step_id)->delete('abandoned_cart_steps');
                $this->session->set_flashdata('success', 'Step deleted.');
            }
            redirect('admin/cart_recovery/sequences');
        }

        $sequences = [];
        if ($this->db->table_exists('abandoned_cart_sequences')) {
            $seq_q = $this->db->order_by('id', 'ASC');
            if ($this->db->field_exists('store_id', 'abandoned_cart_sequences')) {
                $seq_q->where('store_id', $this->store_id);
            }
            $sequences = $seq_q->get('abandoned_cart_sequences')->result_array();
        }

        // Load steps for each sequence
        foreach ($sequences as &$seq) {
            $seq['steps'] = $this->db->table_exists('abandoned_cart_steps')
                ? $this->db->where('sequence_id', $seq['id'])->order_by('delay_minutes', 'ASC')->get('abandoned_cart_steps')->result_array()
                : [];
        }
        unset($seq);

        $data = ['title' => 'Recovery Sequences — NovaDrop Admin', 'sequences' => $sequences];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/cart_recovery/sequences', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
