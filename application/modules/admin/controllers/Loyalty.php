<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Loyalty HMVC Controller
 * Route: admin/loyalty
 * Handles: point awards/deductions, tier management, gamification wheels
 */
class Loyalty extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
        $this->load->library('form_validation');
    }

    // ─── Index: Loyalty Overview ──────────────────────────────
    public function index()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('loyalty_action');

            if ($act === 'award_points') {
                $cust_id = (int)$this->input->post('customer_id');
                $pts     = (int)$this->input->post('points');
                $reason  = trim($this->input->post('reason', true) ?: 'Admin Manual Award');

                if ($cust_id > 0 && $pts > 0) {
                    // Update customer points
                    $this->db->where('id', $cust_id)
                             ->set('loyalty_points', "COALESCE(loyalty_points,0) + {$pts}", false)
                             ->update('customers');

                    // Log transaction
                    $this->db->insert('loyalty_transactions', [
                        'store_id'    => $this->store_id,
                        'customer_id' => $cust_id,
                        'points'      => $pts,
                        'type'        => 'credit',
                        'reason'      => $reason,
                        'created_at'  => date('Y-m-d H:i:s'),
                    ]);

                    // Auto-upgrade tier based on total spend
                    $this->_auto_upgrade_tier($cust_id);

                    $this->audit('loyalty.points.awarded', 'customers', $cust_id, [], ['points' => $pts, 'reason' => $reason]);
                    $this->session->set_flashdata('success', "{$pts} points awarded to Customer #{$cust_id}.");
                }

            } elseif ($act === 'deduct_points') {
                $cust_id = (int)$this->input->post('customer_id');
                $pts     = (int)$this->input->post('points');
                $reason  = trim($this->input->post('reason', true) ?: 'Admin Deduction');

                if ($cust_id > 0 && $pts > 0) {
                    $this->db->where('id', $cust_id)
                             ->set('loyalty_points', "GREATEST(0, COALESCE(loyalty_points,0) - {$pts})", false)
                             ->update('customers');
                    $this->db->insert('loyalty_transactions', [
                        'store_id'    => $this->store_id,
                        'customer_id' => $cust_id,
                        'points'      => $pts,
                        'type'        => 'debit',
                        'reason'      => $reason,
                        'created_at'  => date('Y-m-d H:i:s'),
                    ]);
                    $this->audit('loyalty.points.deducted', 'customers', $cust_id, [], ['points' => $pts]);
                    $this->session->set_flashdata('success', "{$pts} points deducted from Customer #{$cust_id}.");
                }

            } elseif ($act === 'bulk_award_all') {
                $pts_each = (int)$this->input->post('bulk_points') ?: 100;
                $reason   = 'Seasonal VIP Bonus — NovaDrop Reward';
                $customers = $this->db->where('is_active', 1)->where('store_id', $this->store_id)->get('customers')->result_array();
                $cnt = 0;
                foreach ($customers as $c) {
                    $this->db->where('id', $c['id'])->set('loyalty_points', "COALESCE(loyalty_points,0) + {$pts_each}", false)->update('customers');
                    $this->db->insert('loyalty_transactions', [
                        'store_id' => $this->store_id, 'customer_id' => $c['id'],
                        'points' => $pts_each, 'type' => 'credit', 'reason' => $reason,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $cnt++;
                }
                $this->audit('loyalty.bulk_award', 'customers', 0, [], ['points_each' => $pts_each, 'customers' => $cnt]);
                $this->session->set_flashdata('success', "Bulk bonus of {$pts_each} pts dispatched to {$cnt} customers.");
            }

            redirect('admin/loyalty');
        }

        // Stats
        $total_pts = $this->db->select_sum('loyalty_points')->get('customers')->row_array();
        $top_customers = $this->db->where('store_id', $this->store_id)->where('loyalty_points >', 0)
                                  ->order_by('loyalty_points', 'DESC')->limit(20)->get('customers')->result_array();
        $recent_txn = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')
                                ->limit(30)->get('loyalty_transactions')->result_array();
        $tier_summary = $this->db->select('loyalty_tier, COUNT(*) AS cnt')
                                  ->group_by('loyalty_tier')->get('customers')->result_array();

        $data = [
            'title'         => 'Loyalty Program — NovaDrop Admin',
            'total_pts'     => $total_pts['loyalty_points'] ?? 0,
            'top_customers' => $top_customers,
            'recent_txn'    => $recent_txn,
            'tier_summary'  => $tier_summary,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/loyalty/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Tier Management ──────────────────────────────────────
    public function tiers()
    {
        if ($this->input->method() === 'post') {
            $tiers_post = $this->input->post('tier') ?? [];
            foreach ($tiers_post as $code => $t) {
                $this->db->where('tier_code', $code)->update('loyalty_tiers', [
                    'points_multiplier' => (float)($t['multiplier'] ?? 1.0),
                    'cashback_percent'  => (float)($t['cashback'] ?? 0),
                    'min_spend'         => (float)($t['min_spend'] ?? 0),
                    'perks'             => trim($t['perks'] ?? ''),
                    'updated_at'        => date('Y-m-d H:i:s'),
                ]);
            }
            $this->audit('loyalty.tiers_updated', 'loyalty_tiers', 0);
            $this->session->set_flashdata('success', 'Loyalty tiers updated.');
            redirect('admin/loyalty/tiers');
        }

        $tiers = $this->db->where('store_id', $this->store_id)->order_by('min_spend', 'ASC')->get('loyalty_tiers')->result_array();
        $data = [
            'title' => 'Loyalty Tiers — NovaDrop Admin',
            'tiers' => $tiers,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/loyalty/tiers', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Gamification Wheels ──────────────────────────────────
    public function gamification()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('game_action');

            if ($act === 'save_wheel_config') {
                $wid    = (int)$this->input->post('wheel_id');
                $slices = $this->input->post('slices_json') ?: '[]';
                // Validate JSON
                if (json_decode($slices) === null) { $slices = '[]'; }

                $update_data = [
                    'title'         => $this->input->post('title', true),
                    'trigger_event' => in_array($this->input->post('trigger_event'), ['exit_intent','time_delay','scroll_depth','manual_click'])
                                        ? $this->input->post('trigger_event') : 'exit_intent',
                    'trigger_value' => (int)$this->input->post('trigger_value'),
                    'require_email' => $this->input->post('require_email') ? 1 : 0,
                    'require_phone' => $this->input->post('require_phone') ? 1 : 0,
                    'is_active'     => $this->input->post('is_active') ? 1 : 0,
                    'slices_json'   => $slices,
                ];

                if ($wid > 0) {
                    $this->db->where('id', $wid)->update('gamification_wheels', $update_data);
                } else {
                    $update_data['store_id']   = $this->store_id;
                    $update_data['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('gamification_wheels', $update_data);
                }
                $this->audit('gamification.wheel_saved', 'gamification_wheels', $wid);
                $this->session->set_flashdata('success', 'Spin wheel configuration saved.');

            } elseif ($act === 'delete_wheel') {
                $wid = (int)$this->input->post('wheel_id');
                $this->db->where('id', $wid)->delete('gamification_spins');
                $this->db->where('id', $wid)->delete('gamification_wheels');
                $this->session->set_flashdata('success', 'Wheel deleted.');
            }

            redirect('admin/loyalty/gamification');
        }

        $wheels = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('gamification_wheels')->result_array();
        $spins_summary = $this->db->select('wheel_id, COUNT(*) AS total_spins, SUM(is_redeemed) AS redeemed')
                                   ->where('store_id', $this->store_id)
                                   ->group_by('wheel_id')
                                   ->get('gamification_spins')->result_array();
        $spins_map = [];
        foreach ($spins_summary as $s) { $spins_map[$s['wheel_id']] = $s; }

        $data = [
            'title'     => 'Gamification — NovaDrop Admin',
            'wheels'    => $wheels,
            'spins_map' => $spins_map,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/loyalty/gamification', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Private: Auto-upgrade customer tier ──────────────────
    private function _auto_upgrade_tier(int $cust_id): void
    {
        $spend_row = $this->db->select_sum('total_amount')
                              ->where('customer_id', $cust_id)
                              ->where('payment_status', 'paid')
                              ->get('orders')->row_array();
        $total_spend = (float)($spend_row['total_amount'] ?? 0);

        $tiers = $this->db->where('store_id', $this->store_id)
                           ->order_by('min_spend', 'DESC')
                           ->get('loyalty_tiers')->result_array();

        $new_tier = 'Silver';
        foreach ($tiers as $tier) {
            if ($total_spend >= (float)$tier['min_spend']) {
                $new_tier = $tier['tier_code'];
                break;
            }
        }

        $this->db->where('id', $cust_id)->update('customers', ['loyalty_tier' => $new_tier]);
    }
}
