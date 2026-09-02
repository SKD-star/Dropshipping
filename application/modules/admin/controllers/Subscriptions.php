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
        $plan_q = $this->db->order_by('id', 'ASC');
        if ($this->db->field_exists('store_id', 'subscription_plans')) {
            $plan_q->where('store_id', $this->store_id);
        }
        $plans = $plan_q->get('subscription_plans')->result_array();
        
        if (empty($plans)) {
            $cols = $this->db->list_fields('subscription_plans');
            $default_plans = [
                [
                    'name'          => 'VIP Graphic Tee of the Month Club',
                    'title'         => 'VIP Graphic Tee of the Month Club',
                    'plan_name'     => 'VIP Graphic Tee of the Month Club',
                    'description'   => '1 Exclusive 240 GSM heavy cotton streetwear graphic tee auto-delivered to your doorstep each month with free shipping.',
                    'price'         => 999.00,
                    'billing_cycle' => 'monthly',
                    'features_json' => json_encode(['1 Exclusive Heavyweight Tee (240 GSM)', 'Free Doorstep Express Delivery', '15% Off all other catalog items', 'Cancel Anytime']),
                    'trial_days'    => 0,
                    'is_active'     => 1,
                    'sort_order'    => 1,
                    'store_id'      => $this->store_id,
                    'created_at'    => date('Y-m-d H:i:s'),
                ],
                [
                    'name'          => 'Atelier Quarterly Streetwear Mystery Box',
                    'title'         => 'Atelier Quarterly Streetwear Mystery Box',
                    'plan_name'     => 'Atelier Quarterly Streetwear Mystery Box',
                    'description'   => 'Curated 3-item luxury streetwear capsule box (3x Retail Value) delivered every 3 months.',
                    'price'         => 2499.00,
                    'billing_cycle' => 'quarterly',
                    'features_json' => json_encode(['3 Luxury Streetwear Garments Guaranteed', 'Includes 1 Heavy Hoodie + 2 Graphic Tees', 'Priority VIP Doorstep Size Exchanges']),
                    'trial_days'    => 0,
                    'is_active'     => 1,
                    'sort_order'    => 2,
                    'store_id'      => $this->store_id,
                    'created_at'    => date('Y-m-d H:i:s'),
                ]
            ];
            foreach ($default_plans as $dp) {
                $clean_dp = array_intersect_key($dp, array_flip($cols));
                $this->db->insert('subscription_plans', $clean_dp);
            }
            $plan_q2 = $this->db->order_by('id', 'ASC');
            if ($this->db->field_exists('store_id', 'subscription_plans')) {
                $plan_q2->where('store_id', $this->store_id);
            }
            $plans = $plan_q2->get('subscription_plans')->result_array();
        }

        // Normalize plan properties for consistent view rendering
        foreach ($plans as &$p) {
            $p['name']          = $p['name'] ?? ($p['title'] ?? ($p['plan_name'] ?? 'VIP Membership Plan'));
            $p['billing_cycle'] = $p['billing_cycle'] ?? ($p['interval'] ?? ($p['frequency'] ?? 'monthly'));
            $p['description']   = $p['description'] ?? ($p['summary'] ?? 'Curated luxury apparel membership.');
            $p['price']         = (float)($p['price'] ?? ($p['amount'] ?? 999));
        }
        unset($p);

        $subscribers = [];
        if ($this->db->table_exists('customer_subscriptions')) {
            $sub_q = $this->db->order_by('id', 'DESC')->limit(50);
            if ($this->db->field_exists('store_id', 'customer_subscriptions')) {
                $sub_q->where('store_id', $this->store_id);
            }
            $subscribers = $sub_q->get('customer_subscriptions')->result_array();
        }

        $active_count = 0;
        if ($this->db->table_exists('customer_subscriptions')) {
            $ac_q = $this->db->where('status', 'active');
            if ($this->db->field_exists('store_id', 'customer_subscriptions')) {
                $ac_q->where('store_id', $this->store_id);
            }
            $active_count = $ac_q->count_all_results('customer_subscriptions');
        }

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
                $cols = $this->db->list_fields('subscription_plans');
                $row = [
                    'name'           => trim($this->input->post('name', true)),
                    'title'          => trim($this->input->post('name', true)),
                    'plan_name'      => trim($this->input->post('name', true)),
                    'description'    => trim($this->input->post('description', true)),
                    'price'          => (float)$this->input->post('price'),
                    'billing_cycle'  => in_array($this->input->post('billing_cycle'), ['monthly','quarterly','annual']) ? $this->input->post('billing_cycle') : 'monthly',
                    'features_json'  => $this->input->post('features') ? json_encode(array_filter(array_map('trim', explode("\n", $this->input->post('features'))))) : '[]',
                    'trial_days'     => (int)($this->input->post('trial_days') ?: 0),
                    'is_active'      => 1,
                    'sort_order'     => (int)($this->input->post('sort_order') ?: 0),
                    'created_at'     => date('Y-m-d H:i:s'),
                ];
                if ($this->db->field_exists('store_id', 'subscription_plans')) {
                    $row['store_id'] = $this->store_id;
                }
                $clean_row = array_intersect_key($row, array_flip($cols));
                $this->db->insert('subscription_plans', $clean_row);
                $this->audit('subscription_plan.created', 'subscription_plans', $this->db->insert_id(), [], $clean_row);
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
                $subs_using = 0;
                if ($this->db->table_exists('customer_subscriptions')) {
                    $subs_using = $this->db->where('plan_id', $id)->where('status', 'active')->count_all_results('customer_subscriptions');
                }
                if ($subs_using > 0) {
                    $this->session->set_flashdata('error', "Cannot delete: {$subs_using} active subscribers on this plan.");
                } else {
                    $this->db->where('id', $id)->delete('subscription_plans');
                    $this->session->set_flashdata('success', 'Plan deleted.');
                }
            }

            redirect('admin/subscriptions/plans');
        }

        $plan_q = $this->db->order_by('id', 'ASC');
        if ($this->db->field_exists('store_id', 'subscription_plans')) {
            $plan_q->where('store_id', $this->store_id);
        }
        $plans = $plan_q->get('subscription_plans')->result_array();

        // Normalize plan keys + add subscriber count per plan
        foreach ($plans as &$plan) {
            $plan['name']          = $plan['name'] ?? ($plan['title'] ?? ($plan['plan_name'] ?? 'Membership Plan'));
            $plan['billing_cycle'] = $plan['billing_cycle'] ?? ($plan['interval'] ?? ($plan['frequency'] ?? 'monthly'));
            $plan['description']   = $plan['description'] ?? ($plan['summary'] ?? '');
            $plan['price']         = (float)($plan['price'] ?? ($plan['amount'] ?? 0));
            $plan['trial_days']    = (int)($plan['trial_days'] ?? 0);
            $plan['is_active']     = (int)($plan['is_active'] ?? 1);
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
