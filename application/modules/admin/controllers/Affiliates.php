<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Affiliates HMVC Controller
 * Route: admin/affiliates
 * Handles: influencer accounts, referral tracking, affiliate payouts
 */
class Affiliates extends MY_Controller
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
        $influencer_count = $this->db->table_exists('influencers') ? $this->db->count_all('influencers') : 0;
        $referral_count   = $this->db->table_exists('referrals')   ? $this->db->count_all('referrals') : 0;
        $payout_pending   = $this->db->table_exists('affiliate_payouts')
            ? $this->db->where('status', 'pending')->count_all_results('affiliate_payouts') : 0;

        $data = [
            'title'            => 'Affiliates — NovaDrop Admin',
            'influencer_count' => $influencer_count,
            'referral_count'   => $referral_count,
            'payout_pending'   => $payout_pending,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/affiliates/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Influencers ──────────────────────────────────────────
    public function influencers()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('influencer_action');

            if ($act === 'create') {
                $row = [
                    'store_id'        => $this->store_id,
                    'name'            => trim($this->input->post('name', true)),
                    'email'           => trim($this->input->post('email', true)),
                    'handle'          => trim($this->input->post('handle', true)),
                    'platform'        => $this->input->post('platform', true),
                    'commission_rate' => (float)$this->input->post('commission_rate'),
                    'referral_code'   => strtoupper(substr(md5(uniqid()), 0, 8)),
                    'status'          => 'active',
                    'created_at'      => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('influencers', $row);
                $this->audit('influencer.created', 'influencers', $this->db->insert_id(), [], $row);
                $this->session->set_flashdata('success', "Influencer '{$row['name']}' added.");

            } elseif ($act === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('influencers')->row_array();
                if ($cur) {
                    $new = $cur['status'] === 'active' ? 'inactive' : 'active';
                    $this->db->where('id', $id)->update('influencers', ['status' => $new]);
                    $this->session->set_flashdata('success', "Influencer status set to {$new}.");
                }

            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('influencers');
                $this->session->set_flashdata('success', 'Influencer removed.');
            }
            redirect('admin/affiliates/influencers');
        }

        $influencers = $this->db->table_exists('influencers')
            ? $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('influencers')->result_array()
            : [];

        // Add referral conversion stats
        foreach ($influencers as &$inf) {
            if ($this->db->table_exists('referrals')) {
                $row = $this->db->where('referral_code', $inf['referral_code'])->count_all_results('referrals');
                $inf['referral_count'] = $row;
                $earn_row = $this->db->where('referrer_id', $inf['id'])->select_sum('amount')->get('affiliate_payouts')->row_array();
                $inf['total_earned'] = $earn_row['amount'] ?? 0;
            } else {
                $inf['referral_count'] = 0;
                $inf['total_earned']   = 0;
            }
        }
        unset($inf);

        $data = ['title' => 'Influencers — NovaDrop Admin', 'influencers' => $influencers];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/affiliates/influencers', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Referrals ────────────────────────────────────────────
    public function referrals()
    {
        $referrals = $this->db->table_exists('referrals')
            ? $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->limit(100)->get('referrals')->result_array()
            : [];

        $data = ['title' => 'Referrals — NovaDrop Admin', 'referrals' => $referrals];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/affiliates/referrals', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Affiliate Payouts ────────────────────────────────────
    public function payouts()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('payout_action');
            if ($act === 'approve') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->update('affiliate_payouts', ['status' => 'approved', 'updated_at' => date('Y-m-d H:i:s')]);
                $this->session->set_flashdata('success', "Payout #{$id} approved.");
            } elseif ($act === 'pay') {
                $id  = (int)$this->input->post('id');
                $ref = trim($this->input->post('reference', true)) ?: ('AFF-' . strtoupper(substr(uniqid(), -6)));
                $this->db->where('id', $id)->update('affiliate_payouts', ['status' => 'paid', 'note' => "Paid: {$ref}"]);
                $this->session->set_flashdata('success', "Payout #{$id} marked paid.");
            } elseif ($act === 'reject') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->update('affiliate_payouts', ['status' => 'rejected']);
                $this->session->set_flashdata('success', "Payout #{$id} rejected.");
            }
            redirect('admin/affiliates/payouts');
        }

        $payouts = $this->db->table_exists('affiliate_payouts')
            ? $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('affiliate_payouts')->result_array()
            : [];

        $data = ['title' => 'Affiliate Payouts — NovaDrop Admin', 'payouts' => $payouts];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/affiliates/payouts', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
