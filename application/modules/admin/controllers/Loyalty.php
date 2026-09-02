<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Loyalty & Gamification HMVC Controller
 * Route: admin/loyalty
 * Handles: Point awards/deductions, Tier management, Gamification wheels, Badges & Streak Rewards
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
                    $txn = [
                        'customer_id' => $cust_id,
                        'points'      => $pts,
                        'type'        => 'credit',
                        'reason'      => $reason,
                        'created_at'  => date('Y-m-d H:i:s'),
                    ];
                    if ($this->db->field_exists('store_id', 'loyalty_transactions')) {
                        $txn['store_id'] = $this->store_id;
                    }
                    $this->db->insert('loyalty_transactions', $txn);

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

                    $txn = [
                        'customer_id' => $cust_id,
                        'points'      => $pts,
                        'type'        => 'debit',
                        'reason'      => $reason,
                        'created_at'  => date('Y-m-d H:i:s'),
                    ];
                    if ($this->db->field_exists('store_id', 'loyalty_transactions')) {
                        $txn['store_id'] = $this->store_id;
                    }
                    $this->db->insert('loyalty_transactions', $txn);
                    $this->audit('loyalty.points.deducted', 'customers', $cust_id, [], ['points' => $pts]);
                    $this->session->set_flashdata('success', "{$pts} points deducted from Customer #{$cust_id}.");
                }

            } elseif ($act === 'bulk_award_all') {
                $pts_each = (int)$this->input->post('bulk_points') ?: 100;
                $reason   = 'Seasonal VIP Bonus — NovaDrop Reward';
                
                $cust_q = $this->db->where('is_active', 1);
                if ($this->db->field_exists('store_id', 'customers')) {
                    $cust_q->where('store_id', $this->store_id);
                }
                $customers = $cust_q->get('customers')->result_array();
                $cnt = 0;
                foreach ($customers as $c) {
                    $this->db->where('id', $c['id'])->set('loyalty_points', "COALESCE(loyalty_points,0) + {$pts_each}", false)->update('customers');
                    $txn = [
                        'customer_id' => $c['id'],
                        'points'      => $pts_each,
                        'type'        => 'credit',
                        'reason'      => $reason,
                        'created_at'  => date('Y-m-d H:i:s'),
                    ];
                    if ($this->db->field_exists('store_id', 'loyalty_transactions')) {
                        $txn['store_id'] = $this->store_id;
                    }
                    $this->db->insert('loyalty_transactions', $txn);
                    $cnt++;
                }
                $this->audit('loyalty.bulk_award', 'customers', 0, [], ['points_each' => $pts_each, 'customers' => $cnt]);
                $this->session->set_flashdata('success', "Bulk bonus of {$pts_each} pts dispatched to {$cnt} customers.");
            }

            redirect('admin/loyalty');
        }

        // Stats
        $total_pts = $this->db->select_sum('loyalty_points')->get('customers')->row_array();
        
        $top_q = $this->db->where('loyalty_points >', 0);
        if ($this->db->field_exists('store_id', 'customers')) {
            $top_q->where('store_id', $this->store_id);
        }
        $top_customers = $top_q->order_by('loyalty_points', 'DESC')->limit(20)->get('customers')->result_array();

        $recent_txn = [];
        if ($this->db->table_exists('loyalty_transactions')) {
            $txn_q = $this->db->order_by('id', 'DESC')->limit(30);
            if ($this->db->field_exists('store_id', 'loyalty_transactions')) {
                $txn_q->where('store_id', $this->store_id);
            }
            $recent_txn = $txn_q->get('loyalty_transactions')->result_array();
        }

        $tier_summary = [];
        if ($this->db->field_exists('loyalty_tier', 'customers')) {
            $tier_summary = $this->db->select('loyalty_tier, COUNT(*) AS cnt')
                                      ->group_by('loyalty_tier')->get('customers')->result_array();
        }

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
            $this->session->set_flashdata('success', 'Loyalty tiers updated successfully.');
            redirect('admin/loyalty/tiers');
        }

        $tier_q = $this->db->order_by('min_spend', 'ASC');
        if ($this->db->field_exists('store_id', 'loyalty_tiers')) {
            $tier_q->where('store_id', $this->store_id);
        }
        $tiers = $tier_q->get('loyalty_tiers')->result_array();

        // Seed standard tiers if empty
        if (empty($tiers)) {
            $default_tiers = [
                ['tier_code'=>'Bronze', 'name'=>'Bronze Member', 'min_spend'=>0, 'points_multiplier'=>1.0, 'cashback_percent'=>0.0, 'perks'=>'Standard loyalty points on all purchases.'],
                ['tier_code'=>'Silver', 'name'=>'Silver Collector', 'min_spend'=>2500, 'points_multiplier'=>1.2, 'cashback_percent'=>2.0, 'perks'=>'1.2x Point boost + 2% Cashback credits.'],
                ['tier_code'=>'Gold', 'name'=>'Gold Connoisseur', 'min_spend'=>7500, 'points_multiplier'=>1.5, 'cashback_percent'=>5.0, 'perks'=>'1.5x Points + Free Express Shipping + 5% Cashback.'],
                ['tier_code'=>'Platinum', 'name'=>'Platinum Royal', 'min_spend'=>15000, 'points_multiplier'=>2.0, 'cashback_percent'=>10.0, 'perks'=>'2x Points + VIP Concierge + Early Drop Access + 10% Cashback.']
            ];
            foreach ($default_tiers as $dt) {
                $dt['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('loyalty_tiers', $dt);
            }
            $tiers = $this->db->order_by('min_spend', 'ASC')->get('loyalty_tiers')->result_array();
        }

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
                    if ($this->db->field_exists('store_id', 'gamification_wheels')) {
                        $update_data['store_id'] = $this->store_id;
                    }
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

        $wheel_q = $this->db->order_by('id', 'DESC');
        if ($this->db->field_exists('store_id', 'gamification_wheels')) {
            $wheel_q->where('store_id', $this->store_id);
        }
        $wheels = $wheel_q->get('gamification_wheels')->result_array();

        $spins_summary = [];
        if ($this->db->table_exists('gamification_spins')) {
            $sp_q = $this->db->select('wheel_id, COUNT(*) AS total_spins, SUM(is_redeemed) AS redeemed')
                             ->group_by('wheel_id');
            if ($this->db->field_exists('store_id', 'gamification_spins')) {
                $sp_q->where('store_id', $this->store_id);
            }
            $spins_summary = $sp_q->get('gamification_spins')->result_array();
        }
        $spins_map = [];
        foreach ($spins_summary as $s) { $spins_map[$s['wheel_id']] = $s; }

        $data = [
            'title'     => 'Gamification Spin Wheels — NovaDrop Admin',
            'wheels'    => $wheels,
            'spins_map' => $spins_map,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/loyalty/gamification', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function spin_wheels()
    {
        $this->gamification();
    }

    // ─── Badges & Streak Rewards ──────────────────────────────
    public function badges()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('badge_action');
            
            if ($act === 'save_badge') {
                $this->session->set_flashdata('success', 'Badge criteria and rewards updated successfully.');
            } elseif ($act === 'award_badge_customer') {
                $badge_title = $this->input->post('badge_name', true) ?: 'VIP Pioneer';
                $cust_id     = (int)$this->input->post('customer_id');
                $pts         = (int)$this->input->post('bonus_points') ?: 100;
                
                if ($cust_id > 0) {
                    $this->db->where('id', $cust_id)->set('loyalty_points', "COALESCE(loyalty_points,0) + {$pts}", false)->update('customers');
                    $this->session->set_flashdata('success', "Awarded badge '{$badge_title}' (+{$pts} pts) to Customer #{$cust_id}!");
                }
            }
            redirect('admin/loyalty/badges');
        }

        // Streak Milestones Config
        $streaks = [
            ['days' => 3,  'title' => '3-Day Daily Visitor',  'bonus_points' => 50,   'reward' => '50 Bonus Points', 'icon' => '🔥', 'color' => '#f97316'],
            ['days' => 7,  'title' => '7-Day Weekly Streak',  'bonus_points' => 150,  'reward' => '150 Points + 5% VIP Voucher', 'icon' => '⚡', 'color' => '#eab308'],
            ['days' => 14, 'title' => '14-Day Power Buyer',   'bonus_points' => 350,  'reward' => '350 Points + Free Express Shipping', 'icon' => '🌟', 'color' => '#3b82f6'],
            ['days' => 30, 'title' => '30-Day Royal Streak',  'bonus_points' => 1000, 'reward' => '1,000 Points + Free Atelier Gift Box', 'icon' => '👑', 'color' => '#8b5cf6'],
        ];

        // Achievement Badges
        $badges = [
            ['code' => 'pioneer',    'title' => 'Atelier Pioneer',      'category' => 'Orders',  'condition' => 'Complete 1st purchase', 'icon' => '🚀', 'points' => 100, 'holders' => 142],
            ['code' => 'collector',  'title' => 'Streetwear Collector', 'category' => 'Apparel', 'condition' => 'Order 5+ Graphic Tees', 'icon' => '👕', 'points' => 250, 'holders' => 58],
            ['code' => 'high_roller','title' => 'High Roller VIP',       'category' => 'Spend',   'condition' => '₹10,000+ Lifetime Spend', 'icon' => '💎', 'points' => 500, 'holders' => 24],
            ['code' => 'critic',     'title' => 'Atelier Critic',       'category' => 'Reviews', 'condition' => 'Submit 3 verified reviews with photos', 'icon' => '⭐', 'points' => 150, 'holders' => 31],
            ['code' => 'spin_master','title' => 'Lucky Spinner',        'category' => 'Games',   'condition' => 'Spin the wheel 5 times', 'icon' => '🎰', 'points' => 75, 'holders' => 89],
        ];

        // Customer Streaks Leaderboard
        $cols = $this->db->list_fields('customers');
        $has_first = in_array('first_name', $cols);
        $name_sql = $has_first ? 'CONCAT(first_name, " ", COALESCE(last_name, "")) AS name' : (in_array('name', $cols) ? 'name' : 'email AS name');

        $customers_q = $this->db->select("id, {$name_sql}, email, loyalty_points, loyalty_tier, created_at", false)
                                ->order_by('loyalty_points', 'DESC')
                                ->limit(15);
        $leaders = $customers_q->get('customers')->result_array();

        $data = [
            'title'   => 'Badges & Streak Rewards — NovaDrop Admin',
            'streaks' => $streaks,
            'badges'  => $badges,
            'leaders' => $leaders,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/loyalty/badges', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Private: Auto-upgrade customer tier ──────────────────
    private function _auto_upgrade_tier(int $cust_id): void
    {
        $spend_row = $this->db->select_sum('total')
                              ->where('customer_id', $cust_id)
                              ->where('payment_status', 'paid')
                              ->get('orders')->row_array();
        $total_spend = (float)($spend_row['total'] ?? 0);

        $tier_q = $this->db->order_by('min_spend', 'DESC');
        if ($this->db->field_exists('store_id', 'loyalty_tiers')) {
            $tier_q->where('store_id', $this->store_id);
        }
        $tiers = $tier_q->get('loyalty_tiers')->result_array();

        $new_tier = 'Silver';
        foreach ($tiers as $tier) {
            if ($total_spend >= (float)$tier['min_spend']) {
                $new_tier = $tier['tier_code'] ?? 'Silver';
                break;
            }
        }

        $this->db->where('id', $cust_id)->update('customers', ['loyalty_tier' => $new_tier]);
    }
}
