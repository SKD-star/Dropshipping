<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Storefront Search Controller
 * Fast search using Meilisearch HTTP client when available, with clean MySQL FULLTEXT / LIKE fallback
 */
class Search extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        $query = trim($this->input->get('q', true) ?? '');
        $page  = max(1, (int)$this->input->get('page'));
        $per_page = 24;

        $results = [];
        $total   = 0;

        if ($query !== '') {
            $results_data = $this->_perform_search($query, $page, $per_page);
            $results = $results_data['items'];
            $total   = $results_data['total'];
        }

        $collections = $this->db->where('store_id', $this->store_id)->where('is_active', 1)->get('collections')->result_array();

        $hs_row = $this->db->where('store_id', $this->store_id)->limit(1)->get('home_settings')->row_array();
        $home_settings = !empty($hs_row) ? $hs_row : [];

        $data = [
            'title'        => "Search results for \"$query\" — " . env('APP_NAME', 'NovaDrop'),
            'query'        => $query,
            'products'     => $results,
            'total'        => $total,
            'page'         => $page,
            'per_page'     => $per_page,
            'total_pages'  => (int)ceil($total / $per_page),
            'collections'  => $collections,
            'home_settings'=> $home_settings,
            'cart_count'   => $this->_get_cart_count(),
        ];

        $this->load->view('storefront/layout/header', $data);
        $this->load->view('storefront/search/index', $data);
        $this->load->view('storefront/layout/footer', $data);
    }

    private function _perform_search(string $query, int $page, int $per_page): array
    {
        // 1. Try Meilisearch if configured
        $host = env('MEILISEARCH_HOST', 'http://127.0.0.1:7700');
        $key  = env('MEILISEARCH_KEY', '');
        if (!empty($host)) {
            $ch = curl_init("$host/indexes/products/search");
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => json_encode([
                    'q'      => $query,
                    'filter' => "store_id = {$this->store_id} AND status = 'active'",
                    'offset' => ($page - 1) * $per_page,
                    'limit'  => $per_page,
                ]),
                CURLOPT_HTTPHEADER     => array_filter(['Content-Type: application/json', $key ? "Authorization: Bearer $key" : '']),
                CURLOPT_TIMEOUT        => 2,
            ]);
            $raw = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($raw && $code === 200) {
                $d = json_decode($raw, true);
                if (isset($d['hits'])) {
                    return [
                        'items' => $d['hits'],
                        'total' => $d['estimatedTotalHits'] ?? count($d['hits']),
                    ];
                }
            }
        }

        // 2. MySQL Fallback
        $s = $this->db->escape_like_str($query);
        $this->db->select('p.*, pi.url AS primary_image, COALESCE(MIN(pv.price), p.base_price) AS min_price')
                 ->from('products p')
                 ->join('product_images pi', 'pi.product_id = p.id AND pi.is_primary = 1', 'left')
                 ->join('product_variants pv', 'pv.product_id = p.id AND pv.is_active = 1', 'left')
                 ->where('p.store_id', $this->store_id)
                 ->where('p.status', 'active')
                 ->group_start()
                     ->like('p.title', $s)
                     ->or_like('p.description', $s)
                     ->or_like('p.vendor', $s)
                 ->group_end()
                 ->group_by('p.id')
                 ->order_by('p.views_count', 'DESC');


        $total_q = clone $this->db;
        $total = $this->db->count_all_results('', false);

        $this->db->limit($per_page, ($page - 1) * $per_page);
        $items = $this->db->get()->result_array();

        return ['items' => $items, 'total' => $total];
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
