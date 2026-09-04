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
            $store_name       = trim($this->input->post('store_name', true) ?: 'NovaDrop');
            $tagline          = trim($this->input->post('tagline', true) ?: 'Next-Gen E-Commerce');
            $hero_title       = trim($this->input->post('hero_title', true) ?: 'Discover Trending Products');
            $hero_subtitle    = trim($this->input->post('hero_subtitle', true) ?: 'Curated products with fast delivery across India');
            $primary_color    = trim($this->input->post('primary_color', true) ?: '#4f46e5');
            $accent_color     = trim($this->input->post('accent_color', true) ?: '#10b981');
            $announcement_bar = trim($this->input->post('announcement_bar', true) ?: '');
            $footer_text      = trim($this->input->post('footer_text', true) ?: '© 2026 NovaDrop Inc. All rights reserved.');

            // 1. Save to home_settings table (used directly by storefront!)
            if ($this->db->table_exists('home_settings')) {
                $hs_cols = $this->db->list_fields('home_settings');
                $hs_data = [
                    'brand_name'              => $store_name,
                    'brand_tagline'           => $tagline,
                    'hero_headline'           => $hero_title,
                    'hero_subheadline'        => $hero_subtitle,
                    'hero_label'              => $tagline,
                    'announcement_text'       => $announcement_bar,
                    'announcement_bg_color'   => $primary_color,
                    'announcement_text_color' => '#ffffff',
                    'announcement_enabled'    => !empty($announcement_bar) ? 1 : 0,
                    'copyright_text'          => $footer_text,
                    'updated_at'              => date('Y-m-d H:i:s'),
                ];
                $clean_hs = array_intersect_key($hs_data, array_flip($hs_cols));
                
                $has_store = in_array('store_id', $hs_cols);
                $existing = $has_store 
                    ? $this->db->where('store_id', $this->store_id)->get('home_settings')->row_array()
                    : $this->db->get('home_settings')->row_array();
                
                if ($existing) {
                    if ($has_store) {
                        $this->db->where('store_id', $this->store_id)->update('home_settings', $clean_hs);
                    } else {
                        $this->db->where('id', $existing['id'])->update('home_settings', $clean_hs);
                    }
                } else {
                    if ($has_store) {
                        $clean_hs['store_id'] = $this->store_id;
                    }
                    $this->db->insert('home_settings', $clean_hs);
                }
            }

            // 2. Also save to store_settings table
            $settings_to_save = [
                'store_name'       => $store_name,
                'tagline'          => $tagline,
                'hero_title'       => $hero_title,
                'hero_subtitle'    => $hero_subtitle,
                'primary_color'    => $primary_color,
                'accent_color'     => $accent_color,
                'footer_text'      => $footer_text,
                'announcement_bar' => $announcement_bar,
            ];
            if ($this->db->table_exists('store_settings')) {
                foreach ($settings_to_save as $key => $val) {
                    $sq = $this->db->where('key', $key);
                    if ($this->db->field_exists('store_id', 'store_settings')) {
                        $sq->where('store_id', $this->store_id);
                    }
                    $existing = $sq->count_all_results('store_settings');
                    if ($existing) {
                        $uq = $this->db->where('key', $key);
                        if ($this->db->field_exists('store_id', 'store_settings')) {
                            $uq->where('store_id', $this->store_id);
                        }
                        $uq->update('store_settings', ['value' => $val, 'updated_at' => date('Y-m-d H:i:s')]);
                    } else {
                        $ins = ['key' => $key, 'value' => $val, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                        if ($this->db->field_exists('store_id', 'store_settings')) {
                            $ins['store_id'] = $this->store_id;
                        }
                        $this->db->insert('store_settings', $ins);
                    }
                }
            }

            $this->audit('settings.appearance_saved', 'home_settings', 0);
            $this->session->set_flashdata('success', '✨ Appearance settings saved & applied across storefront!');
            redirect('admin/settings/appearance');
        }

        // Load active settings from home_settings first, then store_settings
        $settings = [
            'store_name'       => 'NovaDrop',
            'tagline'          => 'Next-Gen E-Commerce',
            'hero_title'       => 'Discover Trending Products',
            'hero_subtitle'    => 'Curated products with fast delivery across India',
            'primary_color'    => '#4f46e5',
            'accent_color'     => '#10b981',
            'announcement_bar' => '🔥 Free Express Shipping on prepaid orders above ₹499!',
            'footer_text'      => '© 2026 NovaDrop Inc. All rights reserved.',
        ];

        if ($this->db->table_exists('home_settings')) {
            $hq = $this->db->field_exists('store_id', 'home_settings') ? $this->db->where('store_id', $this->store_id) : $this->db;
            $hs = $hq->limit(1)->get('home_settings')->row_array();
            if (!empty($hs)) {
                if (!empty($hs['brand_name']))                                                        $settings['store_name']       = $hs['brand_name'];
                if (!empty($hs['brand_tagline']))                                                     $settings['tagline']          = $hs['brand_tagline'];
                if (!empty($hs['hero_headline']))                                                     $settings['hero_title']       = $hs['hero_headline'];
                if (!empty($hs['hero_subheadline']))                                                  $settings['hero_subtitle']    = $hs['hero_subheadline'];
                if (!empty($hs['announcement_bg_color']) && $hs['announcement_bg_color'] !== '#ff00f7') $settings['primary_color']    = $hs['announcement_bg_color'];
                if (!empty($hs['announcement_text']))                                                 $settings['announcement_bar'] = $hs['announcement_text'];
                if (!empty($hs['copyright_text']))                                                    $settings['footer_text']      = $hs['copyright_text'];
            }
        }

        if ($this->db->table_exists('store_settings')) {
            $sq = $this->db->field_exists('store_id', 'store_settings') ? $this->db->where('store_id', $this->store_id) : $this->db;
            $rows = $sq->get('store_settings')->result_array();
            foreach ($rows as $r) {
                if (!empty($r['key']) && isset($r['value']) && $r['value'] !== '') {
                    if ($r['key'] === 'primary_color' && ($r['value'] === '#ff00f7' || $r['value'] === '#ff0000')) continue;
                    if ($r['key'] === 'accent_color' && ($r['value'] === '#ff00f7' || $r['value'] === '#ff0000')) continue;
                    $settings[$r['key']] = $r['value'];
                }
            }
        }

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
            if ($act === 'create' || $act === 'save' || $act === 'update') {
                $id       = (int)$this->input->post('id');
                $ann_cols = $this->db->table_exists('announcements') ? $this->db->list_fields('announcements') : [];
                $raw_msg  = trim($this->input->post('message', true) ?: '🔥 Free Express Shipping on prepaid orders above ₹499!');
                $bg_col   = trim($this->input->post('bg_color', true)) ?: '#4f46e5';
                $txt_col  = trim($this->input->post('text_color', true)) ?: '#ffffff';
                $link_url = trim($this->input->post('link_url', true));

                $ann_row = [
                    'message'           => $raw_msg,
                    'text'              => $raw_msg,
                    'content'           => $raw_msg,
                    'announcement_text' => $raw_msg,
                    'title'             => $raw_msg,
                    'bg_color'          => $bg_col,
                    'text_color'        => $txt_col,
                    'link_url'          => $link_url,
                    'is_active'         => 1,
                    'starts_at'         => $this->input->post('starts_at') ?: null,
                    'ends_at'           => $this->input->post('ends_at') ?: null,
                    'updated_at'        => date('Y-m-d H:i:s'),
                ];
                $clean_ann = !empty($ann_cols) ? array_intersect_key($ann_row, array_flip($ann_cols)) : $ann_row;

                if ($id > 0) {
                    $this->db->where('id', $id)->update('announcements', $clean_ann);
                    $this->session->set_flashdata('success', '✨ Announcement banner updated & synced to storefront!');
                } else {
                    if (in_array('store_id', $ann_cols)) {
                        $clean_ann['store_id'] = $this->store_id;
                    }
                    if (in_array('created_at', $ann_cols)) {
                        $clean_ann['created_at'] = date('Y-m-d H:i:s');
                    }
                    $this->db->insert('announcements', $clean_ann);
                    $this->session->set_flashdata('success', '✨ Announcement banner created & published to live storefront!');
                }

                // Sync directly into home_settings for immediate storefront ribbon display
                if ($this->db->table_exists('home_settings')) {
                    $hs_cols = $this->db->list_fields('home_settings');
                    $sync_data = [
                        'announcement_text'       => $raw_msg,
                        'announcement_bg_color'   => $bg_col,
                        'announcement_text_color' => $txt_col,
                        'announcement_link'       => $link_url,
                        'announcement_enabled'    => 1,
                    ];
                    $clean_sync = array_intersect_key($sync_data, array_flip($hs_cols));
                    if (in_array('store_id', $hs_cols)) {
                        $this->db->where('store_id', $this->store_id)->update('home_settings', $clean_sync);
                    } else {
                        $this->db->update('home_settings', $clean_sync);
                    }
                }

            } elseif ($act === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('announcements')->row_array();
                if ($cur) { 
                    $new_state = $cur['is_active'] ? 0 : 1;
                    $this->db->where('id', $id)->update('announcements', ['is_active' => $new_state]);
                    if ($this->db->table_exists('home_settings')) {
                        $this->db->update('home_settings', ['announcement_enabled' => $new_state]);
                    }
                }
                $this->session->set_flashdata('success', 'Announcement status updated.');
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('announcements');
                $this->session->set_flashdata('success', 'Announcement deleted.');
            }
            redirect('admin/settings/announcements');
        }

        $announcements = [];
        if ($this->db->table_exists('announcements')) {
            $aq = $this->db->order_by('id', 'DESC');
            if ($this->db->field_exists('store_id', 'announcements')) {
                $aq->where('store_id', $this->store_id);
            }
            $announcements = $aq->get('announcements')->result_array();
        }

        $data = ['title' => 'Announcements — NovaDrop Admin', 'announcements' => $announcements];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/announcements', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── CMS Pages ────────────────────────────────────────────
    public function pages()
    {
        // Ensure pages table exists
        if (!$this->db->table_exists('pages')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `pages` (
                `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `store_id` INT(11) UNSIGNED DEFAULT 1,
                `title` VARCHAR(255) NOT NULL,
                `page_title` VARCHAR(255) DEFAULT NULL,
                `name` VARCHAR(255) DEFAULT NULL,
                `slug` VARCHAR(255) NOT NULL,
                `content` LONGTEXT DEFAULT NULL,
                `body` LONGTEXT DEFAULT NULL,
                `meta_title` VARCHAR(255) DEFAULT NULL,
                `meta_desc` TEXT DEFAULT NULL,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX (`store_id`),
                INDEX (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        }

        if ($this->input->method() === 'post') {
            $act = $this->input->post('page_action');
            if ($act === 'save') {
                $id = (int)$this->input->post('id');
                $page_cols = $this->db->table_exists('pages') ? $this->db->list_fields('pages') : [];
                
                $raw_title = trim($this->input->post('title', true));
                $raw_slug  = strtolower(url_title(trim($this->input->post('slug', true) ?: $raw_title), '-', true));

                $row = [
                    'title'      => $raw_title,
                    'page_title' => $raw_title,
                    'name'       => $raw_title,
                    'slug'       => $raw_slug,
                    'content'    => $this->input->post('content'),
                    'body'       => $this->input->post('content'),
                    'meta_title' => trim($this->input->post('meta_title', true)),
                    'meta_desc'  => trim($this->input->post('meta_desc', true)),
                    'is_active'  => $this->input->post('is_active') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                if (!empty($page_cols)) {
                    $clean_page = array_intersect_key($row, array_flip($page_cols));
                } else {
                    $clean_page = $row;
                }

                if ($id > 0) {
                    $this->db->where('id', $id)->update('pages', $clean_page);
                } else {
                    if (!empty($page_cols) && in_array('store_id', $page_cols)) {
                        $clean_page['store_id'] = $this->store_id;
                    }
                    if (!empty($page_cols) && in_array('created_at', $page_cols)) {
                        $clean_page['created_at'] = date('Y-m-d H:i:s');
                    }
                    $this->db->insert('pages', $clean_page);
                }
                $this->session->set_flashdata('success', "✨ Page '{$raw_title}' saved successfully!");
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('pages');
                $this->session->set_flashdata('success', 'Page deleted successfully.');
            }
            redirect('admin/settings/pages');
        }

        $edit_id = (int)$this->input->get('edit');
        $edit_page = $edit_id > 0 ? $this->db->where('id', $edit_id)->get('pages')->row_array() : null;
        $pages = [];
        if ($this->db->table_exists('pages')) {
            $pq = $this->db;
            if ($this->db->field_exists('title', 'pages')) {
                $pq = $pq->order_by('title', 'ASC');
            } elseif ($this->db->field_exists('page_title', 'pages')) {
                $pq = $pq->order_by('page_title', 'ASC');
            } elseif ($this->db->field_exists('name', 'pages')) {
                $pq = $pq->order_by('name', 'ASC');
            } else {
                $pq = $pq->order_by('id', 'DESC');
            }

            if ($this->db->field_exists('store_id', 'pages')) {
                $pq = $pq->where('store_id', $this->store_id);
            }
            $pages = $pq->get('pages')->result_array();
        }

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
                    $faq_cols = $this->db->table_exists('faqs') ? $this->db->list_fields('faqs') : [];
                    $row['created_at'] = date('Y-m-d H:i:s');
                    if (!empty($faq_cols) && in_array('store_id', $faq_cols)) {
                        $row['store_id'] = $this->store_id;
                    }
                    $clean_faq = !empty($faq_cols) ? array_intersect_key($row, array_flip($faq_cols)) : $row;
                    $this->db->insert('faqs', $clean_faq);
                }
                $this->session->set_flashdata('success', 'FAQ saved.');
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('faqs');
                $this->session->set_flashdata('success', 'FAQ deleted.');
            }
            redirect('admin/settings/faq');
        }

        $faqs = [];
        if ($this->db->table_exists('faqs')) {
            $fq = $this->db->order_by('sort_order', 'ASC')->order_by('id', 'ASC');
            if ($this->db->field_exists('store_id', 'faqs')) {
                $fq->where('store_id', $this->store_id);
            }
            $faqs = $fq->get('faqs')->result_array();
        }

        $data = ['title' => 'FAQ Management — NovaDrop Admin', 'faqs' => $faqs];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/faq', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── International & Localization ────────────────────────
    public function international()
    {
        // 1. Auto-ensure tables exist
        if (!$this->db->table_exists('store_currencies')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `store_currencies` (
                `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `store_id` INT(11) UNSIGNED DEFAULT 1,
                `code` VARCHAR(10) NOT NULL,
                `name` VARCHAR(100) NOT NULL,
                `symbol` VARCHAR(10) NOT NULL,
                `exchange_rate` DECIMAL(12, 6) DEFAULT 1.000000,
                `is_default` TINYINT(1) DEFAULT 0,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX (`store_id`),
                INDEX (`code`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        }

        if (!$this->db->table_exists('store_languages')) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `store_languages` (
                `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `store_id` INT(11) UNSIGNED DEFAULT 1,
                `code` VARCHAR(10) NOT NULL,
                `name` VARCHAR(100) NOT NULL,
                `native_name` VARCHAR(100) DEFAULT NULL,
                `direction` ENUM('ltr', 'rtl') DEFAULT 'ltr',
                `is_default` TINYINT(1) DEFAULT 0,
                `is_active` TINYINT(1) DEFAULT 1,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX (`store_id`),
                INDEX (`code`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        }

        // Helper closures for auto-seeding
        $seed_currencies = function() {
            $defaults = [
                ['code' => 'INR', 'name' => 'Indian Rupee',           'symbol' => '₹',    'exchange_rate' => 1.000000, 'is_default' => 1, 'is_active' => 1],
                ['code' => 'USD', 'name' => 'United States Dollar',   'symbol' => '$',    'exchange_rate' => 0.012000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'EUR', 'name' => 'Euro',                   'symbol' => '€',    'exchange_rate' => 0.011000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'GBP', 'name' => 'British Pound Sterling', 'symbol' => '£',    'exchange_rate' => 0.009400, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'AED', 'name' => 'United Arab Emirates Dirham', 'symbol' => 'AED', 'exchange_rate' => 0.044000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'CAD', 'name' => 'Canadian Dollar',        'symbol' => 'CA$',  'exchange_rate' => 0.016300, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'AUD', 'name' => 'Australian Dollar',      'symbol' => 'A$',   'exchange_rate' => 0.018200, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'SGD', 'name' => 'Singapore Dollar',       'symbol' => 'S$',   'exchange_rate' => 0.016100, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'JPY', 'name' => 'Japanese Yen',           'symbol' => '¥',    'exchange_rate' => 1.800000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'SAR', 'name' => 'Saudi Riyal',            'symbol' => 'SAR',  'exchange_rate' => 0.045000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'KWD', 'name' => 'Kuwaiti Dinar',          'symbol' => 'KD',   'exchange_rate' => 0.003700, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'QAR', 'name' => 'Qatari Riyal',           'symbol' => 'QR',   'exchange_rate' => 0.043700, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'BHD', 'name' => 'Bahraini Dinar',         'symbol' => 'BD',   'exchange_rate' => 0.004500, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'OMR', 'name' => 'Omani Rial',             'symbol' => 'OMR',  'exchange_rate' => 0.004600, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'NZD', 'name' => 'New Zealand Dollar',     'symbol' => 'NZ$',  'exchange_rate' => 0.019800, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'CHF', 'name' => 'Swiss Franc',            'symbol' => 'CHF',  'exchange_rate' => 0.010500, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'THB', 'name' => 'Thai Baht',              'symbol' => '฿',    'exchange_rate' => 0.420000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'MYR', 'name' => 'Malaysian Ringgit',      'symbol' => 'RM',   'exchange_rate' => 0.053000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'ZAR', 'name' => 'South African Rand',     'symbol' => 'R',    'exchange_rate' => 0.215000, 'is_default' => 0, 'is_active' => 1],
                ['code' => 'BDT', 'name' => 'Bangladeshi Taka',       'symbol' => '৳',    'exchange_rate' => 1.420000, 'is_default' => 0, 'is_active' => 1],
            ];
            $cols = $this->db->list_fields('store_currencies');
            foreach ($defaults as $d) {
                $chk = $this->db->where('code', $d['code'])->count_all_results('store_currencies');
                if (!$chk) {
                    $d['store_id'] = $this->store_id;
                    $d['created_at'] = date('Y-m-d H:i:s');
                    $clean = array_intersect_key($d, array_flip($cols));
                    $this->db->insert('store_currencies', $clean);
                }
            }
        };

        $seed_languages = function() {
            $defaults = [
                ['code' => 'en', 'name' => 'English',    'native_name' => 'English',      'direction' => 'ltr', 'is_default' => 1, 'is_active' => 1],
                ['code' => 'hi', 'name' => 'Hindi',      'native_name' => 'हिन्दी',       'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'es', 'name' => 'Spanish',    'native_name' => 'Español',      'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'fr', 'name' => 'French',     'native_name' => 'Français',     'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'de', 'name' => 'German',     'native_name' => 'Deutsch',      'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'ar', 'name' => 'Arabic',     'native_name' => 'العربية',      'direction' => 'rtl', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'bn', 'name' => 'Bengali',    'native_name' => 'বাংলা',         'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'mr', 'name' => 'Marathi',    'native_name' => 'मराठी',        'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'ta', 'name' => 'Tamil',      'native_name' => 'தமிழ்',        'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'te', 'name' => 'Telugu',     'native_name' => 'తెలుగు',       'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'gu', 'name' => 'Gujarati',   'native_name' => 'ગુજરાતી',      'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'kn', 'name' => 'Kannada',    'native_name' => 'ಕನ್ನಡ',        'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'ml', 'name' => 'Malayalam',  'native_name' => 'മലയാളം',      'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'pa', 'name' => 'Punjabi',    'native_name' => 'ਪੰਜਾਬੀ',       'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'ur', 'name' => 'Urdu',       'native_name' => 'اردو',         'direction' => 'rtl', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'pt', 'name' => 'Portuguese','native_name' => 'Português',    'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'ja', 'name' => 'Japanese',  'native_name' => '日本語',        'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'zh', 'name' => 'Chinese',   'native_name' => '简体中文',     'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'ru', 'name' => 'Russian',   'native_name' => 'Русский',      'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
                ['code' => 'it', 'name' => 'Italian',   'native_name' => 'Italiano',     'direction' => 'ltr', 'is_default' => 0, 'is_active' => 1],
            ];
            $cols = $this->db->list_fields('store_languages');
            foreach ($defaults as $d) {
                $chk = $this->db->where('code', $d['code'])->count_all_results('store_languages');
                if (!$chk) {
                    $d['store_id'] = $this->store_id;
                    $d['created_at'] = date('Y-m-d H:i:s');
                    $clean = array_intersect_key($d, array_flip($cols));
                    $this->db->insert('store_languages', $clean);
                }
            }
        };

        // Auto-seed if currently empty
        $c_cnt = $this->db->count_all_results('store_currencies');
        if ($c_cnt === 0) { $seed_currencies(); }
        $l_cnt = $this->db->count_all_results('store_languages');
        if ($l_cnt === 0) { $seed_languages(); }

        // Handle POST actions
        if ($this->input->method() === 'post') {
            $act = $this->input->post('intl_action');

            if ($act === 'save_currency') {
                $id    = (int)$this->input->post('id');
                $code  = strtoupper(trim($this->input->post('code', true)));
                $name  = trim($this->input->post('name', true));
                $sym   = trim($this->input->post('symbol', true));
                $rate  = (float)($this->input->post('exchange_rate') ?: 1.0);
                $is_df = $this->input->post('is_default') ? 1 : 0;
                $is_ac = $this->input->post('is_active') ? 1 : 0;

                if ($is_df) {
                    $this->db->where('store_id', $this->store_id)->update('store_currencies', ['is_default' => 0]);
                }

                $cdata = [
                    'code'          => $code,
                    'name'          => $name,
                    'symbol'        => $sym,
                    'exchange_rate' => $rate,
                    'is_default'    => $is_df,
                    'is_active'     => $is_ac,
                    'updated_at'    => date('Y-m-d H:i:s'),
                ];
                $cols = $this->db->list_fields('store_currencies');
                $clean = array_intersect_key($cdata, array_flip($cols));

                if ($id > 0) {
                    $this->db->where('id', $id)->update('store_currencies', $clean);
                } else {
                    $clean['store_id'] = $this->store_id;
                    $clean['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('store_currencies', $clean);
                }
                $this->session->set_flashdata('success', "Currency {$code} ({$sym}) saved successfully.");

            } elseif ($act === 'toggle_currency') {
                $id = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('store_currencies')->row_array();
                if ($cur && empty($cur['is_default'])) {
                    $this->db->where('id', $id)->update('store_currencies', ['is_active' => $cur['is_active'] ? 0 : 1]);
                    $this->session->set_flashdata('success', "Currency status updated.");
                }

            } elseif ($act === 'set_default_currency') {
                $id = (int)$this->input->post('id');
                $this->db->where('store_id', $this->store_id)->update('store_currencies', ['is_default' => 0]);
                $this->db->where('id', $id)->update('store_currencies', ['is_default' => 1, 'is_active' => 1, 'exchange_rate' => 1.0]);
                $this->session->set_flashdata('success', "Primary base currency updated.");

            } elseif ($act === 'delete_currency') {
                $id = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('store_currencies')->row_array();
                if ($cur && empty($cur['is_default'])) {
                    $this->db->where('id', $id)->delete('store_currencies');
                    $this->session->set_flashdata('success', "Currency deleted.");
                }

            } elseif ($act === 'save_language') {
                $id    = (int)$this->input->post('id');
                $code  = strtolower(trim($this->input->post('code', true)));
                $name  = trim($this->input->post('name', true));
                $native= trim($this->input->post('native_name', true) ?: $name);
                $dir   = $this->input->post('direction') === 'rtl' ? 'rtl' : 'ltr';
                $is_df = $this->input->post('is_default') ? 1 : 0;
                $is_ac = $this->input->post('is_active') ? 1 : 0;

                if ($is_df) {
                    $this->db->where('store_id', $this->store_id)->update('store_languages', ['is_default' => 0]);
                }

                $ldata = [
                    'code'        => $code,
                    'name'        => $name,
                    'native_name' => $native,
                    'direction'   => $dir,
                    'is_default'  => $is_df,
                    'is_active'   => $is_ac,
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
                $cols = $this->db->list_fields('store_languages');
                $clean = array_intersect_key($ldata, array_flip($cols));

                if ($id > 0) {
                    $this->db->where('id', $id)->update('store_languages', $clean);
                } else {
                    $clean['store_id'] = $this->store_id;
                    $clean['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('store_languages', $clean);
                }
                $this->session->set_flashdata('success', "Language {$name} ({$code}) saved successfully.");

            } elseif ($act === 'toggle_language') {
                $id = (int)$this->input->post('id');
                $lng = $this->db->where('id', $id)->get('store_languages')->row_array();
                if ($lng && empty($lng['is_default'])) {
                    $this->db->where('id', $id)->update('store_languages', ['is_active' => $lng['is_active'] ? 0 : 1]);
                    $this->session->set_flashdata('success', "Language status updated.");
                }

            } elseif ($act === 'set_default_language') {
                $id = (int)$this->input->post('id');
                $this->db->where('store_id', $this->store_id)->update('store_languages', ['is_default' => 0]);
                $this->db->where('id', $id)->update('store_languages', ['is_default' => 1, 'is_active' => 1]);
                $this->session->set_flashdata('success', "Default primary language updated.");

            } elseif ($act === 'delete_language') {
                $id = (int)$this->input->post('id');
                $lng = $this->db->where('id', $id)->get('store_languages')->row_array();
                if ($lng && empty($lng['is_default'])) {
                    $this->db->where('id', $id)->delete('store_languages');
                    $this->session->set_flashdata('success', "Language removed.");
                }

            } elseif ($act === 'seed_all_defaults') {
                $seed_currencies();
                $seed_languages();
                $this->session->set_flashdata('success', "✨ All 20 international currencies and 20 languages successfully seeded!");
            }

            redirect('admin/settings/international');
        }

        $currencies = [];
        if ($this->db->table_exists('store_currencies')) {
            $cq = $this->db->order_by('is_default', 'DESC')->order_by('code', 'ASC');
            if ($this->db->field_exists('store_id', 'store_currencies')) {
                $cq->where('store_id', $this->store_id);
            }
            $currencies = $cq->get('store_currencies')->result_array();
        }

        $languages = [];
        if ($this->db->table_exists('store_languages')) {
            $lq = $this->db->order_by('is_default', 'DESC')->order_by('name', 'ASC');
            if ($this->db->field_exists('store_id', 'store_languages')) {
                $lq->where('store_id', $this->store_id);
            }
            $languages = $lq->get('store_languages')->result_array();
        }

        $data = [
            'title'      => 'International & Multi-Currency Localization — NovaDrop Admin',
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

    // ─── Hero Slider & Video Background Manager ──────────────
    public function hero()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('action');
            if ($act === 'create' || $act === 'update') {
                $id = (int)$this->input->post('id');
                
                $title_main   = trim($this->input->post('title_main', true) ?: 'Couture in Motion.');
                $title_accent = trim($this->input->post('title_accent', true) ?: 'Bespoke Form.');
                $badge        = trim($this->input->post('badge', true) ?: 'Autumn / Winter 2026 Archive · Runway Edition');
                $subtitle     = trim($this->input->post('subtitle', true) ?: '');
                $media_type   = $this->input->post('media_type') === 'video' ? 'video' : 'image';
                $cta_text     = trim($this->input->post('cta_text', true) ?: 'Explore Boutique');
                $cta_url      = trim($this->input->post('cta_url', true) ?: 'shop');
                $sec_text     = trim($this->input->post('secondary_text', true) ?: 'AI Stylist');
                $sec_act      = trim($this->input->post('secondary_action', true) ?: 'openStylistModal()');
                $sort_order   = (int)$this->input->post('sort_order');
                $is_active    = $this->input->post('is_active') !== null ? 1 : 0;
                
                $video_url = trim($this->input->post('video_url', true));
                $image_url = trim($this->input->post('image_url', true));
                
                // Direct video file upload
                if (!empty($_FILES['video_file']['name']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['mp4', 'webm', 'ogg', 'mov'])) {
                        $up_dir = FCPATH . 'assets/videos/';
                        if (!is_dir($up_dir)) @mkdir($up_dir, 0755, true);
                        $fname = 'hero_vid_' . time() . '.' . $ext;
                        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $up_dir . $fname)) {
                            $video_url = 'assets/videos/' . $fname;
                        }
                    }
                }
                
                // Direct image file upload
                if (!empty($_FILES['image_file']['name']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                        $up_dir = FCPATH . 'assets/img/';
                        if (!is_dir($up_dir)) @mkdir($up_dir, 0755, true);
                        $fname = 'hero_img_' . time() . '.' . $ext;
                        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $up_dir . $fname)) {
                            $image_url = 'assets/img/' . $fname;
                        }
                    }
                }
                
                $slide_data = [
                    'store_id'         => $this->store_id,
                    'badge'            => $badge,
                    'title_main'       => $title_main,
                    'title_accent'     => $title_accent,
                    'subtitle'         => $subtitle,
                    'media_type'       => $media_type,
                    'video_url'        => $video_url,
                    'image_url'        => $image_url,
                    'cta_text'         => $cta_text,
                    'cta_url'          => $cta_url,
                    'secondary_text'   => $sec_text,
                    'secondary_action' => $sec_act,
                    'sort_order'       => $sort_order,
                    'is_active'        => $is_active,
                    'updated_at'       => date('Y-m-d H:i:s'),
                ];
                
                if ($id > 0) {
                    $this->db->where('id', $id)->update('hero_slides', $slide_data);
                    $this->session->set_flashdata('success', '✨ Hero Slide updated successfully!');
                } else {
                    $slide_data['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('hero_slides', $slide_data);
                    $this->session->set_flashdata('success', '✨ New Hero Slide created and published to live storefront!');
                }
            } elseif ($act === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('hero_slides')->row_array();
                if ($cur) {
                    $new_state = $cur['is_active'] ? 0 : 1;
                    $this->db->where('id', $id)->update('hero_slides', ['is_active' => $new_state]);
                    $this->session->set_flashdata('success', 'Slide visibility status updated.');
                }
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('hero_slides');
                $this->session->set_flashdata('success', 'Slide removed from hero carousel.');
            }
            redirect('admin/settings/hero');
        }

        $slides = $this->db->where('store_id', $this->store_id)
            ->order_by('sort_order', 'ASC')
            ->order_by('id', 'ASC')
            ->get('hero_slides')
            ->result_array();

        $data = [
            'title'  => 'Hero Slider & Video Background — NovaDrop Admin',
            'slides' => $slides
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/settings/hero', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}

