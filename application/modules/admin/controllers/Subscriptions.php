<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Subscriptions HMVC Controller
 * Route: admin/subscriptions
 */
class Subscriptions extends MY_Controller
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
        $plans       = $this->db->where('store_id', $this->store_id)->order_by('sort_order', 'ASC')->get('subscription_plans')->result_array();
        $subscribers = $this->db->table_exists('customer_subscriptions')
            ? $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->limit(50)->get('customer_subscriptions')->result_array()
            : [];
        $active_count = $this->db->table_exists('customer_subscriptions')
            ? $this->db->where('status', 'active')->count_all_results('customer_subscriptions')
            : 0;

        $data = [
            'title'        => 'Subscriptions — NovaDrop Admin',
            'plans'        => $plans,
            'subscribers'  => $subscribers,
            'active_count' => $active_count,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/subscriptions/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Plans Management ─────────────────────────────────────
    public function plans()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('plan_action');

            if ($act === 'create') {
                $row = [
                    'store_id'       => $this->store_id,
                    'name'           => trim($this->input->post('name', true)),
                    'description'    => trim($this->input->post('description', true)),
                    'price'          => (float)$this->input->post('price'),
                    'billing_cycle'  => in_array($this->input->post('billing_cycle'), ['monthly','quarterly','annual']) ? $this->input->post('billing_cycle') : 'monthly',
                    'features_json'  => $this->input->post('features') ? json_encode(array_filter(array_map('trim', explode("\n", $this->input->post('features'))))) : '[]',
                    'trial_days'     => (int)($this->input->post('trial_days') ?: 0),
                    'is_active'      => 1,
                    'sort_order'     => (int)($this->input->post('sort_order') ?: 0),
                    'created_at'     => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('subscription_plans', $row);
                $this->audit('subscription_plan.created', 'subscription_plans', $this->db->insert_id(), [], $row);
                $this->session->set_flashdata('success', "Plan '{$row['name']}' created.");

            } elseif ($act === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('subscription_plans')->row_array();
                if ($cur) {
                    $this->db->where('id', $id)->update('subscription_plans', ['is_active' => $cur['is_active'] ? 0 : 1]);
                    $this->session->set_flashdata('success', 'Plan status toggled.');
                }

            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $subs_using = $this->db->table_exists('customer_subscriptions')
                    ? $this->db->where('plan_id', $id)->where('status', 'active')->count_all_results('customer_subscriptions')
                    : 0;
                if ($subs_using > 0) {
                    $this->session->set_flashdata('error', "Cannot delete: {$subs_using} active subscribers on this plan.");
                } else {
                    $this->db->where('id', $id)->delete('subscription_plans');
                    $this->session->set_flashdata('success', 'Plan deleted.');
                }
            }

            redirect('admin/subscriptions/plans');
        }

        $plans = $this->db->where('store_id', $this->store_id)->order_by('sort_order', 'ASC')->get('subscription_plans')->result_array();

        // Add subscriber count per plan
        foreach ($plans as &$plan) {
            $plan['subscriber_count'] = $this->db->table_exists('customer_subscriptions')
                ? $this->db->where('plan_id', $plan['id'])->where('status', 'active')->count_all_results('customer_subscriptions')
                : 0;
        }
        unset($plan);

        $data = ['title' => 'Subscription Plans — NovaDrop Admin', 'plans' => $plans];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/subscriptions/plans', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Cancel a Subscriber ──────────────────────────────────
    public function cancel_subscriber($id)
    {
        $id = (int)$id;
        if ($this->db->table_exists('customer_subscriptions')) {
            $this->db->where('id', $id)->update('customer_subscriptions', [
                'status'     => 'cancelled',
                'cancelled_at' => date('Y-m-d H:i:s'),
            ]);
            $this->audit('subscription.cancelled', 'customer_subscriptions', $id);
        }
        $this->session->set_flashdata('success', "Subscription #{$id} cancelled.");
        redirect('admin/subscriptions');
    }
}
