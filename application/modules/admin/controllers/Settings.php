<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Settings HMVC Controller (Extended)
 * Route: admin/settings
 * Covers: appearance, CMS pages, FAQ, international, announcements, gateways status
 */
class Settings extends MY_Controller
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
        $data = [
            'title' => 'Settings — NovaDrop Admin',
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Appearance / Home Settings ───────────────────────────
    public function appearance()
    {
        if ($this->input->method() === 'post') {
            $settings_to_save = [
                'store_name', 'tagline', 'hero_title', 'hero_subtitle',
                'primary_color', 'accent_color', 'footer_text', 'announcement_bar',
            ];
            foreach ($settings_to_save as $key) {
                $val = $this->input->post($key, true);
                if ($val !== null) {
                    // Upsert into store_settings
                    $existing = $this->db->where('store_id', $this->store_id)->where('key', $key)->count_all_results('store_settings');
                    if ($existing) {
                        $this->db->where('store_id', $this->store_id)->where('key', $key)
                                 ->update('store_settings', ['value' => $val, 'updated_at' => date('Y-m-d H:i:s')]);
                    } else {
                        $this->db->insert('store_settings', [
                            'store_id'   => $this->store_id,
                            'key'        => $key,
                            'value'      => $val,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
            }
            $this->audit('settings.appearance_saved', 'store_settings', 0);
            $this->session->set_flashdata('success', 'Appearance settings saved.');
            redirect('admin/settings/appearance');
        }

        $settings_rows = $this->db->table_exists('store_settings')
            ? $this->db->where('store_id', $this->store_id)->get('store_settings')->result_array()
            : [];
        $settings = [];
        foreach ($settings_rows as $row) { $settings[$row['key']] = $row['value']; }

        $data = ['title' => 'Appearance — NovaDrop Admin', 'settings' => $settings];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/appearance', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Announcements ────────────────────────────────────────
    public function announcements()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('ann_action');
            if ($act === 'create') {
                $this->db->insert('announcements', [
                    'store_id'   => $this->store_id,
                    'message'    => trim($this->input->post('message', true)),
                    'bg_color'   => trim($this->input->post('bg_color', true)) ?: '#4e73df',
                    'text_color' => trim($this->input->post('text_color', true)) ?: '#ffffff',
                    'link_url'   => trim($this->input->post('link_url', true)),
                    'is_active'  => 1,
                    'starts_at'  => $this->input->post('starts_at') ?: null,
                    'ends_at'    => $this->input->post('ends_at') ?: null,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $this->session->set_flashdata('success', 'Announcement created.');
            } elseif ($act === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('announcements')->row_array();
                if ($cur) { $this->db->where('id', $id)->update('announcements', ['is_active' => $cur['is_active'] ? 0 : 1]); }
                $this->session->set_flashdata('success', 'Announcement toggled.');
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('announcements');
                $this->session->set_flashdata('success', 'Announcement deleted.');
            }
            redirect('admin/settings/announcements');
        }

        $announcements = $this->db->table_exists('announcements')
            ? $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('announcements')->result_array()
            : [];

        $data = ['title' => 'Announcements — NovaDrop Admin', 'announcements' => $announcements];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/announcements', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── CMS Pages ────────────────────────────────────────────
    public function pages()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('page_action');
            if ($act === 'save') {
                $id = (int)$this->input->post('id');
                $row = [
                    'title'      => trim($this->input->post('title', true)),
                    'slug'       => strtolower(url_title(trim($this->input->post('slug', true) ?: $this->input->post('title', true)), '-', true)),
                    'content'    => $this->input->post('content'),
                    'meta_title' => trim($this->input->post('meta_title', true)),
                    'meta_desc'  => trim($this->input->post('meta_desc', true)),
                    'is_active'  => $this->input->post('is_active') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                if ($id > 0) {
                    $this->db->where('id', $id)->update('pages', $row);
                } else {
                    $row['store_id']   = $this->store_id;
                    $row['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('pages', $row);
                }
                $this->session->set_flashdata('success', "Page '{$row['title']}' saved.");
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('pages');
                $this->session->set_flashdata('success', 'Page deleted.');
            }
            redirect('admin/settings/pages');
        }

        $edit_id = (int)$this->input->get('edit');
        $edit_page = $edit_id > 0 ? $this->db->where('id', $edit_id)->get('pages')->row_array() : null;
        $pages = $this->db->table_exists('pages')
            ? $this->db->where('store_id', $this->store_id)->order_by('title', 'ASC')->get('pages')->result_array()
            : [];

        $data = ['title' => 'CMS Pages — NovaDrop Admin', 'pages' => $pages, 'edit_page' => $edit_page];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/pages', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── FAQ ──────────────────────────────────────────────────
    public function faq()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('faq_action');
            if ($act === 'save') {
                $id = (int)$this->input->post('id');
                $row = [
                    'question'   => trim($this->input->post('question', true)),
                    'answer'     => trim($this->input->post('answer', true)),
                    'category'   => trim($this->input->post('category', true)) ?: 'General',
                    'sort_order' => (int)($this->input->post('sort_order') ?: 0),
                    'is_active'  => $this->input->post('is_active') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                if ($id > 0) {
                    $this->db->where('id', $id)->update('faqs', $row);
                } else {
                    $row['store_id']   = $this->store_id;
                    $row['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('faqs', $row);
                }
                $this->session->set_flashdata('success', 'FAQ saved.');
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('faqs');
                $this->session->set_flashdata('success', 'FAQ deleted.');
            }
            redirect('admin/settings/faq');
        }

        $faqs = $this->db->table_exists('faqs')
            ? $this->db->where('store_id', $this->store_id)->order_by('sort_order', 'ASC')->order_by('id', 'ASC')->get('faqs')->result_array()
            : [];

        $data = ['title' => 'FAQ Management — NovaDrop Admin', 'faqs' => $faqs];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/faq', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── International ────────────────────────────────────────
    public function international()
    {
        $currencies = $this->db->table_exists('store_currencies')
            ? $this->db->where('store_id', $this->store_id)->get('store_currencies')->result_array()
            : [];
        $languages = $this->db->table_exists('store_languages')
            ? $this->db->where('store_id', $this->store_id)->get('store_languages')->result_array()
            : [];

        $data = [
            'title'      => 'International — NovaDrop Admin',
            'currencies' => $currencies,
            'languages'  => $languages,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/international', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Gateway / Integration Status (mirrors Marketing::gateways) ─
    public function gateways()
    {
        redirect('admin/marketing/gateways');
    }

    // ─── System Health Diagnostics & Self-Healing (Phase 20) ─
    public function health()
    {
        if ($this->input->method() === 'post' && $this->input->post('health_action') === 'self_heal') {
            // 1. Ensure uploads directory exists and is writable
            $upload_dir = FCPATH . 'assets/uploads/';
            if (!is_dir($upload_dir)) { @mkdir($upload_dir, 0777, true); }

            // 2. Ensure cache & session directories exist
            $cache_dir = APPPATH . 'cache/';
            if (!is_dir($cache_dir)) { @mkdir($cache_dir, 0777, true); }

            // 3. Clean up expired sessions
            if ($this->db->table_exists('ci_sessions')) {
                $this->db->query("DELETE FROM `ci_sessions` WHERE `timestamp` < " . (time() - 86400 * 7));
            }

            // 4. Clean up failed stale queue tasks older than 30 days
            if ($this->db->table_exists('ai_agent_tasks')) {
                $this->db->where('status', 'failed')->where('created_at <', date('Y-m-d H:i:s', strtotime('-30 days')))->delete('ai_agent_tasks');
            }

            $this->audit('system.self_heal', 'system', 0);
            $this->session->set_flashdata('success', '✨ Automated Self-Healing Cycle completed! Directories restored & cache pruned.');
            redirect('admin/settings/health');
        }

        // Run comprehensive diagnostic checks
        $diagnostics = [];

        // 1. DB Connectivity & Latency
        $t_start = microtime(true);
        $db_connected = $this->db->simple_query('SELECT 1');
        $db_latency = round((microtime(true) - $t_start) * 1000, 2);
        $diagnostics[] = [
            'name'        => 'MySQL Database Connection',
            'status'      => $db_connected ? 'healthy' : 'critical',
            'value'       => $db_connected ? "Connected ({$db_latency}ms)" : 'Connection Failed',
            'description' => 'Primary database operational and responsive',
        ];

        // 2. Uploads Directory Writeability
        $upload_dir = FCPATH . 'assets/uploads/';
        $upload_writable = is_dir($upload_dir) && is_writable($upload_dir);
        $diagnostics[] = [
            'name'        => 'Assets & Uploads Storage',
            'status'      => $upload_writable ? 'healthy' : 'warning',
            'value'       => $upload_writable ? 'Writable' : (is_dir($upload_dir) ? 'Read Only' : 'Directory Missing'),
            'description' => 'Required for product images and media uploads',
        ];

        // 3. Cache Storage
        $cache_dir = APPPATH . 'cache/';
        $cache_writable = is_dir($cache_dir) && is_writable($cache_dir);
        $diagnostics[] = [
            'name'        => 'CodeIgniter Cache Storage',
            'status'      => $cache_writable ? 'healthy' : 'warning',
            'value'       => $cache_writable ? 'Writable' : 'Permissions Restricted',
            'description' => 'Required for caching dynamic views and query fragments',
        ];

        // 4. Session Storage Engine
        $session_table = $this->db->table_exists('ci_sessions');
        $active_sessions = $session_table ? $this->db->count_all('ci_sessions') : 0;
        $diagnostics[] = [
            'name'        => 'Database Session Engine',
            'status'      => $session_table ? 'healthy' : 'warning',
            'value'       => $session_table ? "Active ({$active_sessions} sessions)" : 'Table Missing',
            'description' => 'Database-backed secure session driver active',
        ];

        // 5. Environment & Security Mode
        $env_mode = defined('ENVIRONMENT') ? ENVIRONMENT : 'development';
        $diagnostics[] = [
            'name'        => 'Application Environment',
            'status'      => 'healthy',
            'value'       => strtoupper($env_mode),
            'description' => 'Active runtime execution environment',
        ];

        // 6. PHP Runtime
        $diagnostics[] = [
            'name'        => 'PHP Engine Version',
            'status'      => version_compare(PHP_VERSION, '7.4.0', '>=') ? 'healthy' : 'warning',
            'value'       => 'PHP ' . PHP_VERSION,
            'description' => 'Compatible with CodeIgniter 3.x HMVC architecture',
        ];

        $data = [
            'title'       => 'System Health & Self-Healing Diagnostics — NovaDrop Admin',
            'diagnostics' => $diagnostics,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/health', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}

