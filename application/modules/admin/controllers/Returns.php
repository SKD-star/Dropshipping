<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Returns & Exchanges Management Controller
 * Route: admin/returns
 * Manages 7-Day Doorstep Returns, Size/Color Exchanges, Reverse Pickup AWBs, and Instant Refunds.
 */
class Returns extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->database();
        $this->load->library('form_validation');
        $this->_ensure_tables_exist();
    }

    private function _ensure_tables_exist(): void
    {
        if (!$this->db->table_exists('return_requests')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `return_requests` (
                  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `store_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
                  `order_id` int(10) UNSIGNED NOT NULL,
                  `order_item_id` int(10) UNSIGNED DEFAULT NULL,
                  `customer_id` int(10) UNSIGNED DEFAULT NULL,
                  `type` enum('exchange','refund') NOT NULL DEFAULT 'exchange',
                  `exchange_variant_title` varchar(150) DEFAULT NULL,
                  `reason` varchar(255) NOT NULL,
                  `status` enum('requested','approved','pickup_scheduled','received_qc','refunded','exchanged','rejected') NOT NULL DEFAULT 'requested',
                  `refund_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
                  `refund_mode` enum('store_credit','original_payment','bank_upi') NOT NULL DEFAULT 'store_credit',
                  `reverse_awb` varchar(60) DEFAULT NULL,
                  `carrier` varchar(60) DEFAULT 'Delhivery Reverse Express',
                  `notes` text DEFAULT NULL,
                  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        } else {
            // Table exists: verify and add missing columns
            if (!$this->db->field_exists('type', 'return_requests')) {
                $this->db->query("ALTER TABLE `return_requests` ADD COLUMN `type` ENUM('exchange','refund') NOT NULL DEFAULT 'exchange' AFTER `customer_id`");
            }
            if (!$this->db->field_exists('exchange_variant_title', 'return_requests')) {
                $this->db->query("ALTER TABLE `return_requests` ADD COLUMN `exchange_variant_title` VARCHAR(150) NULL DEFAULT NULL AFTER `type`");
            }
            if (!$this->db->field_exists('reverse_awb', 'return_requests')) {
                $this->db->query("ALTER TABLE `return_requests` ADD COLUMN `reverse_awb` VARCHAR(60) NULL DEFAULT NULL AFTER `refund_amount`");
            }
            if (!$this->db->field_exists('refund_mode', 'return_requests')) {
                $this->db->query("ALTER TABLE `return_requests` ADD COLUMN `refund_mode` ENUM('store_credit','original_payment','bank_upi') NOT NULL DEFAULT 'store_credit' AFTER `refund_amount`");
            }
            if (!$this->db->field_exists('carrier', 'return_requests')) {
                $this->db->query("ALTER TABLE `return_requests` ADD COLUMN `carrier` VARCHAR(60) DEFAULT 'Delhivery Reverse Express' AFTER `reverse_awb`");
            }
            if (!$this->db->field_exists('notes', 'return_requests')) {
                $this->db->query("ALTER TABLE `return_requests` ADD COLUMN `notes` TEXT NULL DEFAULT NULL AFTER `carrier`");
            }
            if (!$this->db->field_exists('store_id', 'return_requests')) {
                $this->db->query("ALTER TABLE `return_requests` ADD COLUMN `store_id` INT(10) UNSIGNED NOT NULL DEFAULT 1 AFTER `id`");
            }
        }

        // Seed sample realistic return & exchange records if table is empty
        if ($this->db->count_all('return_requests') === 0) {
            $cols = $this->db->list_fields('return_requests');
            $samples = [
                [
                    'order_id'               => 1,
                    'order_item_id'          => 1,
                    'customer_id'            => 6,
                    'type'                   => 'exchange',
                    'exchange_variant_title' => 'Black / L(US 40) (Exchange from M)',
                    'reason'                 => 'Size too fitted on shoulders (Need 1 Size Up)',
                    'status'                 => 'requested',
                    'refund_amount'          => 1586.00,
                    'refund_mode'            => 'store_credit',
                    'reverse_awb'            => 'DELREV-99218401',
                    'notes'                  => 'Customer requested doorstep size exchange from Medium to Large.',
                    'created_at'             => date('Y-m-d H:i:s', strtotime('-1 day')),
                ],
                [
                    'order_id'               => 2,
                    'order_item_id'          => 2,
                    'customer_id'            => 8,
                    'type'                   => 'refund',
                    'exchange_variant_title' => null,
                    'reason'                 => 'Color shade mismatch with studio lighting',
                    'status'                 => 'approved',
                    'refund_amount'          => 2199.00,
                    'refund_mode'            => 'original_payment',
                    'reverse_awb'            => 'XPRESS-REV-7740192',
                    'notes'                  => 'Reverse pickup scheduled for tomorrow 10:00 AM.',
                    'created_at'             => date('Y-m-d H:i:s', strtotime('-3 days')),
                ]
            ];

            foreach ($samples as $s) {
                $clean = array_intersect_key($s, array_flip($cols));
                $this->db->insert('return_requests', $clean);
            }
        }
    }

    // ─── Index: RMA Requests & KPI Dashboard ──────────────────
    public function index()
    {
        $status = $this->input->get('status', true) ?: 'all';
        $type   = $this->input->get('type', true) ?: 'all';
        $search = $this->input->get('q', true);

        $has_type = $this->db->field_exists('type', 'return_requests');

        $q = $this->db->select('rr.*, o.order_number, o.guest_email, o.total, oi.product_title, oi.variant_title, oi.quantity, c.name AS customer_name, c.email AS customer_email, c.phone AS customer_phone')
                      ->from('return_requests rr')
                      ->join('orders o', 'o.id = rr.order_id', 'left')
                      ->join('order_items oi', 'oi.id = rr.order_item_id', 'left')
                      ->join('customers c', 'c.id = rr.customer_id', 'left')
                      ->order_by('rr.id', 'DESC');

        if ($status !== 'all') {
            $q->where('rr.status', $status);
        }
        if ($type !== 'all' && $has_type) {
            $q->where('rr.type', $type);
        }
        if (!empty($search)) {
            $q->group_start()
              ->like('o.order_number', $search);
            if ($this->db->field_exists('reverse_awb', 'return_requests')) {
                $q->or_like('rr.reverse_awb', $search);
            }
            $q->or_like('c.email', $search)
              ->or_like('c.name', $search)
              ->group_end();
        }

        $requests = $q->get()->result_array();

        // KPIs
        $ex_q = $this->db->where('status', 'exchanged');
        if ($has_type) {
            $ex_q->where('type', 'exchange');
        }

        $kpi = [
            'total_rma'        => $this->db->count_all_results('return_requests'),
            'pending_approval' => $this->db->where('status', 'requested')->count_all_results('return_requests'),
            'pickup_active'    => $this->db->where('status', 'pickup_scheduled')->count_all_results('return_requests'),
            'exchanges_done'   => $ex_q->count_all_results('return_requests'),
            'refunded_amount'  => (float)($this->db->select_sum('refund_amount')->where('status', 'refunded')->get('return_requests')->row()->refund_amount ?? 0),
        ];

        $data = [
            'title'    => 'Returns & Exchanges Hub — NovaDrop Admin',
            'requests' => $requests,
            'kpi'      => $kpi,
            'status'   => $status,
            'type'     => $type,
            'search'   => $search,
        ];

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/returns/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Approve Return / Exchange ────────────────────────────
    public function approve($id)
    {
        $id = (int)$id;
        $req = $this->db->where('id', $id)->get('return_requests')->row_array();
        if (!$req) { show_404(); }

        $awb = 'DELREV-' . rand(10000000, 99999999);
        $this->db->where('id', $id)->update('return_requests', [
            'status'      => 'pickup_scheduled',
            'reverse_awb' => $awb,
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        $this->audit('return.pickup_scheduled', 'return_requests', $id, [], ['awb' => $awb]);
        $this->session->set_flashdata('success', "RMA #{$id} approved. Reverse pickup AWB generated: {$awb}");
        redirect('admin/returns');
    }

    // ─── Mark Quality Inspection Passed & Settle ──────────────
    public function settle($id)
    {
        $id = (int)$id;
        $req = $this->db->where('id', $id)->get('return_requests')->row_array();
        if (!$req) { show_404(); }

        if ($req['type'] === 'exchange') {
            $this->db->where('id', $id)->update('return_requests', [
                'status'     => 'exchanged',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $this->session->set_flashdata('success', "RMA #{$id}: QC Passed. Replacement size garment dispatched to customer!");
        } else {
            $this->db->where('id', $id)->update('return_requests', [
                'status'     => 'refunded',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $this->session->set_flashdata('success', "RMA #{$id}: QC Passed. Refund of ₹" . number_format($req['refund_amount'], 2) . " credited to customer ({$req['refund_mode']})!");
        }

        $this->audit('return.settled', 'return_requests', $id, [], ['type' => $req['type']]);
        redirect('admin/returns');
    }

    // ─── Reject Return / Exchange ─────────────────────────────
    public function reject($id)
    {
        $id = (int)$id;
        $reason = $this->input->post('reject_reason', true) ?: 'Policy timeline exceeded or tags removed';
        $this->db->where('id', $id)->update('return_requests', [
            'status'     => 'rejected',
            'notes'      => $reason,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->audit('return.rejected', 'return_requests', $id, [], ['reason' => $reason]);
        $this->session->set_flashdata('error', "RMA #{$id} rejected: {$reason}");
        redirect('admin/returns');
    }
}
