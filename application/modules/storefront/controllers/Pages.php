<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Storefront Pages Controller
 * Handles institutional, concierge, policy, and tracking pages
 */
class Pages extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('products/Product_model');
    }

    private function _get_home_settings(): array
    {
        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        return !empty($hs_row) ? $hs_row : [];
    }

    public function shipping()
    {
        $data = [
            'title'            => 'Shipping, Logistics & White-Glove Transit — ' . env('APP_NAME', 'LUMINA'),
            'meta_description' => 'Learn about LUMINA white-glove insured transit, 18-hour dispatch SLA, and humidity-controlled garment packaging.',
            'home_settings'    => $this->_get_home_settings(),
            'cart_count'       => $this->_get_cart_count(),
        ];
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/pages/shipping', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function provenance()
    {
        $data = [
            'title'            => 'Certified Provenance & Master Craftsmanship — ' . env('APP_NAME', 'LUMINA'),
            'meta_description' => 'Explore the heritage of Grade-A Mongolian Cashmere, Okayama Selvedge Denim, and 22-Momme Mulberry Silk.',
            'home_settings'    => $this->_get_home_settings(),
            'cart_count'       => $this->_get_cart_count(),
        ];
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/pages/provenance', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function terms()
    {
        $data = [
            'title'            => 'Terms of Service & Atelier Privileges — ' . env('APP_NAME', 'LUMINA'),
            'meta_description' => 'LUMINA client terms of service, bespoke exchange policy, and 256-bit encrypted settlement protocol.',
            'home_settings'    => $this->_get_home_settings(),
            'cart_count'       => $this->_get_cart_count(),
        ];
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/pages/terms', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function manifesto()
    {
        $data = [
            'title'            => 'Zero-Waste & Sustainability Manifesto — ' . env('APP_NAME', 'LUMINA'),
            'meta_description' => 'Our commitment to zero-waste small-batch production, organic textiles, and generational craftsmanship.',
            'home_settings'    => $this->_get_home_settings(),
            'cart_count'       => $this->_get_cart_count(),
        ];
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/pages/manifesto', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function tracking()
    {
        $order_number = $this->input->get('order') ? trim($this->input->get('order')) : '';
        $phone_email = $this->input->get('contact') ? trim($this->input->get('contact')) : '';
        $order = null;

        if ($order_number) {
            $order = $this->db->where('order_number', $order_number)
                              ->or_where('id', (int)$order_number)
                              ->get('orders')->row_array();
            if ($order) {
                $order['items'] = $this->db->select('oi.*, p.slug, pi.url AS primary_image')
                                           ->from('order_items oi')
                                           ->join('products p', 'p.id = oi.product_id', 'left')
                                           ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                                           ->where('oi.order_id', $order['id'])
                                           ->get()->result_array();

                if (!empty($order['shipping_address_id'])) {
                    $addr = $this->db->where('id', $order['shipping_address_id'])->get('addresses')->row_array();
                    if ($addr) {
                        $order['shipping_address'] = $addr['first_name'] . ' ' . $addr['last_name'] . ' · ' . $addr['address1'] . ', ' . $addr['city'] . ', ' . $addr['state'] . ' ' . $addr['pincode'];
                    }
                }
            }
        }

        $data = [
            'title'            => 'Live Order & Shipment Tracking — ' . env('APP_NAME', 'LUMINA'),
            'meta_description' => 'Real-time GPS parcel tracking and delivery timeline for your LUMINA order.',
            'order_number'     => $order_number,
            'phone_email'      => $phone_email,
            'order'            => $order,
            'home_settings'    => $this->_get_home_settings(),
            'cart_count'       => $this->_get_cart_count(),
        ];
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/pages/tracking', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    public function stylist()
    {
        $featured = $this->db->select('p.*, pi.url AS primary_image')
                             ->from('products p')
                             ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                             ->where('p.status', 'active')
                             ->limit(6)
                             ->get()->result_array();

        $data = [
            'title'            => 'AI Stylist Concierge & Silhouette Architect — ' . env('APP_NAME', 'LUMINA'),
            'meta_description' => 'Get bespoke sizing, styling advice, and curated lookbook ensembles from the LUMINA AI Stylist.',
            'featured'         => $featured,
            'home_settings'    => $this->_get_home_settings(),
            'cart_count'       => $this->_get_cart_count(),
        ];
        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/pages/stylist', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    private function _get_cart_count(): int
    {
        $cart_id = $this->session->userdata('cart_id');
        if (!$cart_id) return 0;
        try {
            $row = $this->db->select('SUM(quantity) AS total')->where('cart_id', $cart_id)->get('cart_items')->row_array();
            return (int)($row['total'] ?? 0);
        } catch (Throwable $e) {
            return 0;
        }
    }
}

