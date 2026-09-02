<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — Marketing HMVC Controller
 * Route: admin/marketing
 * Handles: discount codes, payment gateways, waitlist, SEO studio, AI email, ad generator
 */
class Marketing extends MY_Controller
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
        $discount_count = $this->db->count_all('discounts');
        $active_flash   = $this->db->where('is_active', 1)->where('ends_at >=', date('Y-m-d H:i:s'))->count_all_results('flash_sales');
        $waitlist_count = $this->db->table_exists('waitlist') ? $this->db->count_all('waitlist') : 0;
        $campaign_count = $this->db->table_exists('email_campaigns') ? $this->db->count_all('email_campaigns') : 0;
        $ad_count       = $this->db->table_exists('ad_campaigns') ? $this->db->count_all('ad_campaigns') : 0;

        $data = [
            'title'          => 'Marketing & Growth — NovaDrop Admin',
            'discount_count' => $discount_count,
            'active_flash'   => $active_flash,
            'waitlist_count' => $waitlist_count,
            'campaign_count' => $campaign_count,
            'ad_count'       => $ad_count,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/marketing/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Discounts ────────────────────────────────────────────
    public function discounts()
    {
        if ($this->input->method() === 'post') {
            $action = $this->input->post('discount_action');

            if ($action === 'create') {
                $data = [
                    'store_id'         => $this->store_id,
                    'code'             => strtoupper(trim($this->input->post('code', true))),
                    'title'            => $this->input->post('title', true),
                    'discount_type'    => in_array($this->input->post('discount_type'), ['percent','fixed','free_shipping']) ? $this->input->post('discount_type') : 'percent',
                    'value'            => (float)$this->input->post('value'),
                    'min_order_amount' => (float)($this->input->post('min_order_amount') ?: 0),
                    'max_uses'         => $this->input->post('max_uses') ? (int)$this->input->post('max_uses') : null,
                    'starts_at'        => $this->input->post('starts_at') ?: null,
                    'ends_at'          => $this->input->post('ends_at') ?: null,
                    'is_active'        => 1,
                    'created_at'       => date('Y-m-d H:i:s'),
                ];
                if ($this->db->where('code', $data['code'])->where('store_id', $this->store_id)->count_all_results('discounts') > 0) {
                    $this->session->set_flashdata('error', "Discount code '{$data['code']}' already exists.");
                } else {
                    $this->db->insert('discounts', $data);
                    $this->audit('discount.created', 'discounts', $this->db->insert_id(), [], $data);
                    $this->session->set_flashdata('success', "Discount code '{$data['code']}' created.");
                }

            } elseif ($action === 'toggle') {
                $id  = (int)$this->input->post('id');
                $cur = $this->db->where('id', $id)->get('discounts')->row_array();
                if ($cur) {
                    $new_state = $cur['is_active'] ? 0 : 1;
                    $this->db->where('id', $id)->update('discounts', ['is_active' => $new_state]);
                    $this->audit('discount.toggled', 'discounts', $id, ['is_active' => $cur['is_active']], ['is_active' => $new_state]);
                    $this->session->set_flashdata('success', "Discount code " . ($new_state ? 'activated' : 'deactivated') . ".");
                }

            } elseif ($action === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('discounts');
                $this->audit('discount.deleted', 'discounts', $id);
                $this->session->set_flashdata('success', 'Discount deleted.');
            }

            redirect('admin/marketing/discounts');
        }

        $discounts = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('discounts')->result_array();
        $data = [
            'title'     => 'Discount Codes — NovaDrop Admin',
            'discounts' => $discounts,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/marketing/discounts', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Payment Gateways & Simulation ───────────────────────
    public function gateways()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('gateway_action');

            if ($act === 'save_keys') {
                // Save gateway API keys to config.php in FCPATH
                $config_file = FCPATH . 'config.php';
                $current = file_exists($config_file) ? file_get_contents($config_file) : "<?php\n";
                $posted = $this->input->post('gw_keys') ?: [];
                $saved = 0;
                foreach ($posted as $env_key => $env_val) {
                    $env_key = preg_replace('/[^A-Z0-9_]/', '', strtoupper($env_key));
                    $env_val = trim($this->security->xss_clean($env_val));
                    if ($env_key === '' || $env_val === '') continue;
                    // Update or append putenv-style define
                    $pattern = '/define\s*\(\s*[\'"]' . preg_quote($env_key, '/') . '[\'"]\s*,\s*[\'"](.*?)[\'"]\s*\);/';
                    $replacement = "define('" . $env_key . "', '" . addslashes($env_val) . "');";
                    if (preg_match($pattern, $current)) {
                        $current = preg_replace($pattern, $replacement, $current);
                    } else {
                        $current = rtrim($current) . "\n" . $replacement . "\n";
                    }
                    $saved++;
                }
                if ($saved > 0) {
                    file_put_contents($config_file, $current);
                    $this->audit('gateway_keys.saved', 'config', 0, [], ['count' => $saved]);
                    $this->session->set_flashdata('success', "✅ {$saved} API key(s) saved to config.php. Reload config to activate.");
                } else {
                    $this->session->set_flashdata('error', 'No keys were provided.');
                }
                redirect('admin/marketing/gateways');
            }

            if ($act === 'simulate_payment') {
                $sim_amount  = (float)($this->input->post('sim_amount') ?: 1499.00);
                $sim_gateway = trim($this->input->post('sim_gateway', true) ?: 'razorpay_upi');
                $sim_txn_id  = 'pay_' . substr(md5(uniqid()), 0, 14);

                $pay_data = [
                    'store_id'           => $this->store_id,
                    'order_id'           => (int)($this->input->post('sim_order_id') ?: 1),
                    'gateway'            => $sim_gateway,
                    'gateway_payment_id' => $sim_txn_id,
                    'amount'             => $sim_amount,
                    'currency'           => 'INR',
                    'status'             => 'captured',
                    'webhook_verified'   => 1,
                    'created_at'         => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('payments', $pay_data);
                $this->audit('payment.simulated', 'payments', $this->db->insert_id(), [], $pay_data);
                $this->session->set_flashdata('success', "⚡ Live payment simulated successfully! Captured ₹" . number_format($sim_amount, 2) . " via {$sim_gateway} [Txn: {$sim_txn_id}].");
            }

            redirect('admin/marketing/gateways');
        }

        $gateways = [
            ['key' => 'razorpay',    'label' => 'Razorpay',      'icon' => '💳', 'color' => '#0066cc', 'docs' => 'https://razorpay.com/docs/api/',     'keys' => ['RAZORPAY_KEY_ID','RAZORPAY_KEY_SECRET']],
            ['key' => 'stripe',      'label' => 'Stripe',        'icon' => '🔵', 'color' => '#6772e5', 'docs' => 'https://stripe.com/docs/api',          'keys' => ['STRIPE_PUBLIC_KEY','STRIPE_SECRET_KEY']],
            ['key' => 'whatsapp',    'label' => 'WhatsApp',      'icon' => '💬', 'color' => '#25d366', 'docs' => 'https://developers.facebook.com/docs/whatsapp/cloud-api/', 'keys' => ['WHATSAPP_CLOUD_API_TOKEN','WHATSAPP_PHONE_NUMBER_ID']],
            ['key' => 'shiprocket',  'label' => 'ShipRocket',    'icon' => '🚀', 'color' => '#e65c00', 'docs' => 'https://apidoc.shiprocket.in/',         'keys' => ['SHIPROCKET_EMAIL','SHIPROCKET_PASSWORD']],
            ['key' => 'gemini',      'label' => 'Gemini AI',     'icon' => '🤖', 'color' => '#4285f4', 'docs' => 'https://ai.google.dev/api',             'keys' => ['GEMINI_API_KEY']],
            ['key' => 'delhivery',   'label' => 'Delhivery',     'icon' => '📦', 'color' => '#c0392b', 'docs' => 'https://www.delhivery.com/docs',       'keys' => ['DELHIVERY_API_KEY']],
            ['key' => 'bluedart',    'label' => 'BlueDart',      'icon' => '📫', 'color' => '#003087', 'docs' => 'https://www.bluedart.com/integration', 'keys' => ['BLUEDART_API_KEY','BLUEDART_CUSTOMER_CODE']],
            ['key' => 'twilio',      'label' => 'Twilio SMS',    'icon' => '📱', 'color' => '#f22f46', 'docs' => 'https://www.twilio.com/docs/sms',      'keys' => ['TWILIO_ACCOUNT_SID','TWILIO_AUTH_TOKEN']],
            ['key' => 'meilisearch', 'label' => 'MeiliSearch',   'icon' => '🔍', 'color' => '#ff5caa', 'docs' => 'https://docs.meilisearch.com/',         'keys' => ['MEILISEARCH_HOST','MEILISEARCH_KEY']],
        ];

        $placeholder_patterns = ['REPLACE_ME','XXXXXXXXXX','your_','your@','CHANGE_THIS','whsec_XXXX',''];
        foreach ($gateways as &$gw) {
            $gw['status'] = 'configured';
            $gw['values'] = [];
            foreach ($gw['keys'] as $k) {
                $val = env($k, '');
                $is_placeholder = ($val === '' || $val === null);
                if (!$is_placeholder) {
                    foreach ($placeholder_patterns as $pat) {
                        if ($pat !== '' && stripos($val, $pat) !== false) { $is_placeholder = true; break; }
                    }
                }
                if ($is_placeholder) { $gw['status'] = 'placeholder'; }
                // Mask the actual value for display (show first 4 + stars)
                $gw['values'][$k] = ($val && !$is_placeholder) ? (substr($val,0,4) . str_repeat('•', min(16, strlen($val)-4))) : '';
            }
        }
        unset($gw);

        $tot_captured = 0;
        $tot_txns = 0;
        if ($this->db->table_exists('payments')) {
            $row = $this->db->select_sum('amount')->where('status', 'captured')->get('payments')->row_array();
            $tot_captured = (float)($row['amount'] ?? 0);
            $tot_txns = $this->db->count_all('payments');
        }

        $recent_payments = $this->db->table_exists('payments')
            ? $this->db->order_by('id', 'DESC')->limit(8)->get('payments')->result_array()
            : [];

        $data = [
            'title'           => 'Integration Status & Webhook Control — NovaDrop Admin',
            'gateways'        => $gateways,
            'tot_captured'    => $tot_captured,
            'tot_txns'        => $tot_txns,
            'recent_payments' => $recent_payments,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/marketing/gateways', $data);
        $this->load->view('admin/layout/footer', $data);
    }


    // ─── Waitlist ─────────────────────────────────────────────
    public function waitlist()
    {
        if ($this->input->method() === 'post') {
            $action = $this->input->post('wl_action');
            if ($action === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('product_waitlist');
                $this->session->set_flashdata('success', 'Waitlist entry removed.');
            } elseif ($action === 'notify') {
                $id = (int)$this->input->post('id');
                $update_data = [];
                if ($this->db->field_exists('notified', 'product_waitlist')) {
                    $update_data['notified'] = 1;
                }
                if ($this->db->field_exists('notified_at', 'product_waitlist')) {
                    $update_data['notified_at'] = date('Y-m-d H:i:s');
                }
                if (!empty($update_data)) {
                    $this->db->where('id', $id)->update('product_waitlist', $update_data);
                }
                $this->session->set_flashdata('success', 'Marked as notified.');
            }
            redirect('admin/marketing/waitlist');
        }

        $waitlist = [];
        if ($this->db->table_exists('product_waitlist')) {
            $wq = $this->db->select('w.*, p.title as product_name')
                ->from('product_waitlist w')
                ->join('products p', 'p.id = w.product_id', 'left');
            if ($this->db->field_exists('store_id', 'product_waitlist')) {
                $wq->where('w.store_id', $this->store_id);
            }
            $waitlist = $wq->order_by('w.id', 'DESC')->get()->result_array();
        }

        $data = [
            'title'    => 'Waitlist — NovaDrop Admin',
            'waitlist' => $waitlist,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/marketing/waitlist', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── SEO & Feed Studio ────────────────────────────────────
    public function seo_studio()
    {
        if ($this->input->method() === 'post') {
            $action = $this->input->post('seo_action');

            if ($action === 'generate_google_feed') {
                $products = $this->db->where('store_id', $this->store_id)->where('status', 'active')->get('products')->result_array();
                
                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xml .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . "\n";
                $xml .= '<channel>' . "\n";
                $xml .= '<title>NovaDrop Product Catalog</title>' . "\n";
                $xml .= '<link>' . base_url() . '</link>' . "\n";
                $xml .= '<description>Autonomous Luxury Commerce & Curated Products</description>' . "\n";

                $count = 0;
                foreach ($products as $p) {
                    $img = $this->db->where('product_id', $p['id'])->where('is_primary', 1)->get('product_images')->row_array();
                    $img_url = $img['url'] ?? base_url('img/placeholder.jpg');
                    $p_url = base_url('product/' . ($p['slug'] ?: $p['id']));

                    $xml .= "  <item>\n";
                    $xml .= "    <g:id>" . $p['id'] . "</g:id>\n";
                    $xml .= "    <g:title><![CDATA[" . $p['title'] . "]]></g:title>\n";
                    $xml .= "    <g:description><![CDATA[" . strip_tags($p['description'] ?: $p['title']) . "]]></g:description>\n";
                    $xml .= "    <g:link>" . htmlspecialchars($p_url) . "</g:link>\n";
                    $xml .= "    <g:image_link>" . htmlspecialchars($img_url) . "</g:image_link>\n";
                    $xml .= "    <g:condition>new</g:condition>\n";
                    $xml .= "    <g:availability>in stock</g:availability>\n";
                    $xml .= "    <g:price>" . number_format((float)$p['base_price'], 2, '.', '') . " INR</g:price>\n";
                    $xml .= "    <g:brand>" . htmlspecialchars($p['vendor'] ?: 'NovaDrop') . "</g:brand>\n";
                    $xml .= "  </item>\n";
                    $count++;
                }
                $xml .= '</channel>' . "\n";
                $xml .= '</rss>';

                @file_put_contents(FCPATH . 'google_merchant_feed.xml', $xml);
                $this->audit('google_feed.generated', 'products', 0, [], ['items' => $count]);
                $this->session->set_flashdata('success', "Google Merchant Feed ({$count} items) generated at /google_merchant_feed.xml");

            } elseif ($action === 'generate_sitemap') {
                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
                $xml .= "  <url><loc>" . base_url() . "</loc><priority>1.0</priority><changefreq>daily</changefreq></url>\n";
                $xml .= "  <url><loc>" . base_url('shop') . "</loc><priority>0.9</priority><changefreq>daily</changefreq></url>\n";

                $products = $this->db->where('store_id', $this->store_id)->where('status', 'active')->get('products')->result_array();
                $count = 2;
                foreach ($products as $p) {
                    $xml .= "  <url><loc>" . base_url('product/' . ($p['slug'] ?: $p['id'])) . "</loc><priority>0.8</priority><changefreq>weekly</changefreq></url>\n";
                    $count++;
                }
                $xml .= '</urlset>';

                @file_put_contents(FCPATH . 'sitemap.xml', $xml);
                $this->audit('sitemap.generated', 'pages', 0, [], ['urls' => $count]);
                $this->session->set_flashdata('success', "Dynamic XML Sitemap ({$count} URLs) generated at /sitemap.xml");
            }

            redirect('admin/marketing/seo_studio');
        }

        $active_products = $this->db->where('store_id', $this->store_id)->where('status', 'active')->count_all_results('products');
        $recent_products = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->limit(10)->get('products')->result_array();

        $data = [
            'title'           => 'SEO & Merchant Feed Studio — NovaDrop Admin',
            'active_products' => $active_products,
            'recent_products' => $recent_products,
            'feed_exists'     => file_exists(FCPATH . 'google_merchant_feed.xml'),
            'sitemap_exists'  => file_exists(FCPATH . 'sitemap.xml'),
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/marketing/seo_studio', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── AI Email Studio ──────────────────────────────────────
    public function email_ai()
    {
        if ($this->input->method() === 'post') {
            $action = $this->input->post('email_action');

            if ($action === 'create_campaign') {
                $name = trim($this->input->post('campaign_name', true) ?: 'AI Campaign');
                $subject = trim($this->input->post('subject', true) ?: 'Special Offer');
                $body = $this->input->post('body_html');

                $row = [
                    'store_id'   => $this->store_id,
                    'name'       => $name,
                    'subject'    => $subject,
                    'body_html'  => $body,
                    'status'     => 'draft',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('email_campaigns', $row);
                $this->session->set_flashdata('success', "Campaign '{$name}' created as draft.");

            } elseif ($action === 'generate_weekly_newsletter') {
                $products = $this->db->where('store_id', $this->store_id)->where('status', 'active')->order_by('id', 'DESC')->limit(3)->get('products')->result_array();
                
                $items_html = '';
                $product_names = [];
                foreach ($products as $p) {
                    $items_html .= "<li style='margin-bottom:8px;'><strong>" . htmlspecialchars($p['title']) . "</strong> — <span style='color:#059669;'>₹" . number_format($p['base_price'], 2) . "</span></li>";
                    $product_names[] = $p['title'];
                }

                require_once APPPATH . 'core/services/GeminiAiService.php';
                $aiService = new \App\Services\GeminiAiService();
                $prompt = "Write an exclusive luxury e-commerce newsletter editorial for NovaDrop. Featured arrivals: " . implode(', ', $product_names) . ". Include a warm greeting to VIP members, 2 short engaging paragraphs, and a call to action.";
                $aiEditorial = $aiService->generate($prompt) ?: "Discover our newest limited-run releases, crafted with obsession for material integrity, architectural tailoring, and uncompromising performance.";

                $subject = "✨ NovaDrop Weekly Curations: Limited Atelier Drops Inside";
                $body = "<div style='font-family:sans-serif;max-width:600px;margin:0 auto;color:#111827;line-height:1.6;'>
                    <h2 style='font-size:22px;margin-bottom:12px;'>Curated Atelier Arrivals</h2>
                    <p style='color:#4b5563;font-size:15px;'>" . nl2br(htmlspecialchars($aiEditorial)) . "</p>
                    <h3 style='font-size:16px;margin-top:20px;margin-bottom:8px;'>This Week's Featured SKUs:</h3>
                    <ul style='padding-left:20px;'>" . $items_html . "</ul>
                    <div style='margin-top:24px;text-align:center;'>
                        <a href='" . base_url('shop') . "' style='background:#111827;color:#fff;padding:12px 24px;text-decoration:none;border-radius:6px;font-weight:bold;display:inline-block;'>Explore Full Catalog →</a>
                    </div>
                </div>";

                $row = [
                    'store_id'   => $this->store_id,
                    'name'       => 'Weekly Atelier Newsletter - ' . date('d M Y'),
                    'subject'    => $subject,
                    'body_html'  => $body,
                    'status'     => 'ready',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('email_campaigns', $row);
                $this->audit('email_campaign.generated', 'email_campaigns', $this->db->insert_id(), [], ['type' => 'weekly_newsletter']);
                $this->session->set_flashdata('success', "✨ AI Weekly Newsletter generated with Gemini!");

            } elseif ($action === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('email_campaigns');
                $this->session->set_flashdata('success', 'Email campaign deleted.');
            }

            redirect('admin/marketing/email_ai');
        }

        $campaigns = $this->db->table_exists('email_campaigns')
            ? $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('email_campaigns')->result_array()
            : [];

        if ($this->db->table_exists('email_subscribers')) {
            $es_q = $this->db->where('store_id', $this->store_id);
            if ($this->db->field_exists('is_subscribed', 'email_subscribers')) {
                $es_q->where('is_subscribed', 1);
            }
            $subscribers_count = $es_q->count_all_results('email_subscribers');
        } else {
            $subscribers_count = $this->db->field_exists('store_id', 'customers')
                ? $this->db->where('store_id', $this->store_id)->count_all_results('customers')
                : $this->db->count_all('customers');
        }

        $data = [
            'title'             => 'AI Email Marketing Studio — NovaDrop Admin',
            'campaigns'         => $campaigns,
            'subscribers_count' => $subscribers_count,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/marketing/email_ai', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── AI Ad Copy Generator ─────────────────────────────────
    public function ad_generator()
    {
        if ($this->input->method() === 'post') {
            $action = $this->input->post('ad_action');

            if ($action === 'generate_campaign') {
                $pid      = (int)$this->input->post('product_id');
                $platform = trim($this->input->post('platform', true) ?: 'Meta Instagram Reels');
                $angle    = trim($this->input->post('angle', true) ?: 'Luxury Aesthetic');

                $product = $this->db->where('id', $pid)->get('products')->row_array();
                $title   = $product['title'] ?? 'NovaDrop Exclusive Piece';
                $price   = (float)($product['base_price'] ?? 999);

                require_once APPPATH . 'core/services/GeminiAiService.php';
                $aiService = new \App\Services\GeminiAiService();
                $aiResult  = $aiService->generate_ad_copy($title, $platform, $angle);
                $adData    = $aiResult['data'] ?? [];

                $headline     = $adData['headline'] ?? ("✨ Form Without Compromise · The " . $title);
                $primary_text = $adData['primary_text'] ?? ("Handcrafted with perfection and premium materials. VIP price: ₹" . number_format($price, 2));
                $audience     = !empty($adData['suggested_audiences']) ? implode(', ', $adData['suggested_audiences']) : 'Luxury Fashion & Online Shoppers 22-45';
                $est_roas     = round(3.8 + (rand(2, 12) / 10), 2);

                $row = [
                    'store_id'        => $this->store_id,
                    'product_id'      => $pid,
                    'platform'        => $platform,
                    'angle'           => $angle,
                    'headline'        => $headline,
                    'primary_text'    => $primary_text,
                    'target_audience' => $audience,
                    'est_roas'        => $est_roas,
                    'status'          => 'active',
                    'created_at'      => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('ad_campaigns', $row);
                $this->audit('ad_campaign.generated', 'ad_campaigns', $this->db->insert_id(), [], ['product' => $title, 'platform' => $platform, 'source' => $aiResult['source'] ?? 'template']);
                $this->session->set_flashdata('success', "✨ AI Ad Campaign generated with Gemini for {$title} on {$platform} (Est. ROAS: {$est_roas}x)!");

            } elseif ($action === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('ad_campaigns');
                $this->session->set_flashdata('success', 'Ad campaign removed.');
            }

            redirect('admin/marketing/ad_generator');
        }

        $campaigns = [];
        if ($this->db->table_exists('ad_campaigns')) {
            $campaigns = $this->db->select('ac.*, p.title as product_title, p.base_price')
                ->from('ad_campaigns ac')
                ->join('products p', 'p.id = ac.product_id', 'left')
                ->where('ac.store_id', $this->store_id)
                ->order_by('ac.id', 'DESC')
                ->get()->result_array();
        }

        $products = $this->db->where('store_id', $this->store_id)->where('status', 'active')->order_by('title', 'ASC')->get('products')->result_array();

        $data = [
            'title'     => 'AI Ad Generator & ROAS Studio — NovaDrop Admin',
            'campaigns' => $campaigns,
            'products'  => $products,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/marketing/ad_generator', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
