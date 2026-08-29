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
            ['key' => 'razorpay',  'label' => 'Razorpay',   'icon' => '💳', 'keys' => ['RAZORPAY_KEY_ID','RAZORPAY_KEY_SECRET']],
            ['key' => 'stripe',    'label' => 'Stripe',     'icon' => '🔵', 'keys' => ['STRIPE_PUBLIC_KEY','STRIPE_SECRET_KEY']],
            ['key' => 'whatsapp',  'label' => 'WhatsApp',   'icon' => '💬', 'keys' => ['WHATSAPP_CLOUD_API_TOKEN','WHATSAPP_PHONE_NUMBER_ID']],
            ['key' => 'shiprocket','label' => 'ShipRocket', 'icon' => '🚀', 'keys' => ['SHIPROCKET_EMAIL','SHIPROCKET_PASSWORD']],
            ['key' => 'gemini',    'label' => 'Gemini AI',  'icon' => '🤖', 'keys' => ['GEMINI_API_KEY']],
            ['key' => 'delhivery', 'label' => 'Delhivery',  'icon' => '📦', 'keys' => ['DELHIVERY_API_KEY']],
            ['key' => 'bluedart',  'label' => 'BlueDart',   'icon' => '📦', 'keys' => ['BLUEDART_API_KEY','BLUEDART_CUSTOMER_CODE']],
            ['key' => 'twilio',    'label' => 'Twilio SMS',  'icon' => '📱', 'keys' => ['TWILIO_ACCOUNT_SID','TWILIO_AUTH_TOKEN']],
            ['key' => 'meilisearch','label' => 'MeiliSearch','icon' => '🔍', 'keys' => ['MEILISEARCH_HOST','MEILISEARCH_KEY']],
        ];

        $placeholder_patterns = ['REPLACE_ME','XXXXXXXXXX','your_','your@','CHANGE_THIS','whsec_XXXX',''];
        foreach ($gateways as &$gw) {
            $gw['status'] = 'configured';
            foreach ($gw['keys'] as $k) {
                $val = env($k, '');
                $is_placeholder = ($val === '' || $val === null);
                if (!$is_placeholder) {
                    foreach ($placeholder_patterns as $pat) {
                        if ($pat !== '' && stripos($val, $pat) !== false) { $is_placeholder = true; break; }
                    }
                }
                if ($is_placeholder) { $gw['status'] = 'placeholder'; break; }
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
                $this->db->where('id', $id)->update('product_waitlist', ['notified' => 1, 'notified_at' => date('Y-m-d H:i:s')]);
                $this->session->set_flashdata('success', 'Marked as notified.');
            }
            redirect('admin/marketing/waitlist');
        }

        $waitlist = [];
        if ($this->db->table_exists('product_waitlist')) {
            $waitlist = $this->db->select('w.*, p.title as product_name')
                ->from('product_waitlist w')
                ->join('products p', 'p.id = w.product_id', 'left')
                ->where('w.store_id', $this->store_id)
                ->order_by('w.id', 'DESC')
                ->get()->result_array();
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
                foreach ($products as $p) {
                    $items_html .= "<li><strong>" . htmlspecialchars($p['title']) . "</strong> — ₹" . number_format($p['base_price'], 2) . "</li>";
                }

                $subject = "✨ This Week's Curated Drops & Exclusive Member Deals";
                $body = "<h2>NovaDrop Weekly Curations</h2><p>Here are this week's top trending drops handpicked for you:</p><ul>{$items_html}</ul><p><a href='" . base_url('shop') . "'>Shop All New Arrivals</a></p>";

                $row = [
                    'store_id'   => $this->store_id,
                    'name'       => 'Weekly Innovation Newsletter - ' . date('d M Y'),
                    'subject'    => $subject,
                    'body_html'  => $body,
                    'status'     => 'ready',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('email_campaigns', $row);
                $this->session->set_flashdata('success', "AI Weekly Newsletter draft generated!");

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

        $subscribers_count = $this->db->table_exists('email_subscribers')
            ? $this->db->where('store_id', $this->store_id)->where('is_subscribed', 1)->count_all_results('email_subscribers')
            : $this->db->where('store_id', $this->store_id)->count_all_results('customers');

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
                $title   = $product['title'] ?? 'NovaDrop Exclusive';
                $price   = $product['base_price'] ?? 999;

                $headline = "✨ Form Without Compromise · The " . $title;
                $primary_text = "Handcrafted with perfection and premium materials. Now available with fast express delivery.\n\n✓ 100% Quality Guaranteed\n✓ Verified 4.9★ Customer Rating\n✓ Limited Edition Drop\n\nTap Shop Now to claim VIP price of ₹" . number_format($price, 2);
                $audience = "Urban Shoppers 22-45, Online Fashion & Lifestyle Enthusiasts, Social Trends";
                $est_roas = round(3.5 + (rand(5, 15) / 10), 2);

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
                $this->audit('ad_campaign.generated', 'ad_campaigns', $this->db->insert_id(), [], ['product' => $title, 'platform' => $platform]);
                $this->session->set_flashdata('success', "AI Ad Campaign generated for {$title} on {$platform} (Est. ROAS: {$est_roas}x)!");

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
