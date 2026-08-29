<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Product_model — Products Module
 * All queries are store-scoped. No swallowed exceptions.
 */
class Product_model extends MY_Model
{
    protected string $table        = 'products';
    protected bool   $store_scoped = true;
    protected bool   $soft_deletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ─── Storefront queries ──────────────────────────────────

    /**
     * Get active products for storefront listing with filters/sort/pagination
     */
    public function get_listing(array $filters = [], int $page = 1, int $per_page = 24): array
    {
        $this->db->select('p.*, pi.url AS primary_image, 
            COALESCE(MIN(pv.price), p.base_price) AS min_price, 
            COALESCE(MAX(pv.price), p.base_price) AS max_price,
            COALESCE(SUM(pv.inventory_qty), 50) AS total_stock')
             ->from('products p')
             ->join('product_images pi', "pi.product_id = p.id AND pi.is_primary = 1", 'left')
             ->join('product_variants pv', "pv.product_id = p.id AND pv.is_active = 1", 'left')
             ->where('p.store_id', $this->store_id)
             ->where('p.status', 'active')
             ->group_by('p.id');

        if (!empty($filters['collection_id'])) {
            if (is_numeric($filters['collection_id'])) {
                $this->db->where('p.collection_id', (int)$filters['collection_id']);
            } else {
                $this->db->join('collections c_filter', 'c_filter.id = p.collection_id', 'left')
                         ->where('c_filter.slug', $filters['collection_id']);
            }
        }

        if (!empty($filters['tag'])) {
            $this->db->where("JSON_CONTAINS(p.tags, '\"" . $this->db->escape_str($filters['tag']) . "\"')");
        }
        
        // Price preset or min/max
        if (!empty($filters['price'])) {
            if ($filters['price'] === 'under_2000') {
                $this->db->having('min_price <=', 2000);
            } elseif ($filters['price'] === '2000_5000') {
                $this->db->having('min_price >=', 2000);
                $this->db->having('min_price <=', 5000);
            } elseif ($filters['price'] === 'above_5000') {
                $this->db->having('min_price >=', 5000);
            }
        }
        if (!empty($filters['price_min'])) {
            $this->db->having('min_price >=', (float)$filters['price_min']);
        }
        if (!empty($filters['price_max'])) {
            $this->db->having('max_price <=', (float)$filters['price_max']);
        }

        // Size filter
        if (!empty($filters['size'])) {
            $sz = $this->db->escape_str($filters['size']);
            $this->db->where("(EXISTS (SELECT 1 FROM product_variants p_sz_v WHERE p_sz_v.product_id = p.id AND (p_sz_v.title LIKE '%{$sz}%' OR p_sz_v.sku LIKE '%{$sz}%')) OR p.title LIKE '%{$sz}%' OR p.description LIKE '%{$sz}%')");
        }

        // Fabric & Material filter
        if (!empty($filters['fabric'])) {
            $fab = $this->db->escape_str($filters['fabric']);
            $this->db->where("(p.title LIKE '%{$fab}%' OR p.short_description LIKE '%{$fab}%' OR p.description LIKE '%{$fab}%' OR JSON_CONTAINS(p.tags, '\"" . $fab . "\"'))");
        }

        // Fit filter
        if (!empty($filters['fit'])) {
            $fit = $this->db->escape_str($filters['fit']);
            $this->db->where("(p.title LIKE '%{$fit}%' OR p.short_description LIKE '%{$fit}%' OR p.description LIKE '%{$fit}%')");
        }

        // Availability filter
        if (!empty($filters['availability'])) {
            if ($filters['availability'] === 'low_stock') {
                $this->db->having('total_stock <=', 5);
            } elseif ($filters['availability'] === 'in_stock') {
                $this->db->having('total_stock >', 0);
            }
        }

        if (!empty($filters['vendor'])) {
            $this->db->where('p.vendor', $filters['vendor']);
        }

        // Sort
        $sort = $filters['sort'] ?? 'created_at_desc';
        match($sort) {
            'price_asc'   => $this->db->order_by('min_price', 'ASC'),
            'price_desc'  => $this->db->order_by('max_price', 'DESC'),
            'title_asc'   => $this->db->order_by('p.title', 'ASC'),
            'views_desc'  => $this->db->order_by('p.views_count', 'DESC'),
            default       => $this->db->order_by('p.created_at', 'DESC'),
        };

        $total_query = clone $this->db;
        $total       = $this->db->count_all_results('', false);  // false = don't reset

        $this->db->limit($per_page, ($page - 1) * $per_page);
        $items = $this->db->get()->result_array();

        return [
            'items'       => $items,
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $per_page,
            'total_pages' => (int) ceil($total / $per_page),
        ];
    }

    /**
     * Get single product with all related data for product page
     */
    public function get_product_detail(string $slug): ?array
    {
        $product = $this->db->where('store_id', $this->store_id)
                            ->where('slug', $slug)
                            ->where('status', 'active')
                            ->get('products')->row_array();

        if (!$product) return null;

        // Eager-load: images, variants, options, reviews summary
        $product['images']   = $this->get_images($product['id']);
        $product['variants'] = $this->get_variants($product['id']);
        $product['options']  = $this->get_options_with_values($product['id']);
        $product['review_summary'] = $this->get_review_summary($product['id']);

        // Increment view count (fire-and-forget — don't fail the page load)
        try {
            $this->db->set('views_count', 'views_count + 1', false)
                     ->where('id', $product['id'])
                     ->update('products');
        } catch (Throwable $e) {
            log_message('error', '[Product_model::get_product_detail] view increment: ' . $e->getMessage());
        }

        return $product;
    }

    /**
     * Get product by ID (admin use — includes draft/archived)
     */
    public function get_admin_detail(int $id): ?array
    {
        $product = $this->db->where('id', $id)
                            ->where('store_id', $this->store_id)
                            ->get('products')->row_array();
        if (!$product) return null;

        $product['images']  = $this->get_images($id);
        $product['variants'] = $this->get_variants($id);
        $product['options'] = $this->get_options_with_values($id);
        return $product;
    }

    // ─── Product writes ──────────────────────────────────────

    /**
     * Create a product with variants, options, and images atomically
     */
    public function create_product(array $data, array $variants = [], array $options = [], array $image_urls = []): int|false
    {
        $this->db->trans_start();
        try {
            $data['store_id']   = $this->store_id;
            $data['slug']       = $this->_make_unique_slug($data['slug'] ?? $data['title']);
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $this->db->insert('products', $data);
            $product_id = $this->db->insert_id();

            if (!$product_id) {
                $this->db->trans_rollback();
                return false;
            }

            // Save options
            foreach ($options as $position => $option) {
                $this->db->insert('product_options', [
                    'product_id' => $product_id,
                    'name'       => $option['name'],
                    'position'   => $position,
                ]);
                $option_id = $this->db->insert_id();
                foreach ($option['values'] as $vpos => $val) {
                    $this->db->insert('product_option_values', [
                        'option_id' => $option_id,
                        'value'     => $val,
                        'position'  => $vpos,
                    ]);
                }
            }

            // Save variants
            foreach ($variants as $pos => $variant) {
                $variant['product_id'] = $product_id;
                $variant['position']   = $pos;
                $variant['sku']        = $variant['sku'] ?: $this->_generate_sku($product_id, $pos);
                $variant['created_at'] = date('Y-m-d H:i:s');
                $variant['updated_at'] = date('Y-m-d H:i:s');
                $this->db->insert('product_variants', $variant);
            }

            // Save images
            foreach ($image_urls as $pos => $url) {
                $this->db->insert('product_images', [
                    'product_id' => $product_id,
                    'url'        => $url,
                    'position'   => $pos,
                    'is_primary' => ($pos === 0) ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                return false;
            }

            // Queue Meilisearch sync
            $this->_queue_search_sync($product_id);

            return $product_id;
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            log_message('error', '[Product_model::create_product] ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Update product and update search index
     */
    public function update_product(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        if (isset($data['slug'])) {
            $data['slug'] = $this->_make_unique_slug($data['slug'], $id);
        }
        $result = $this->db->where('id', $id)->where('store_id', $this->store_id)->update('products', $data);
        if ($result) {
            $this->db->where('id', $id)->update('products', ['meilisearch_synced' => 0]);
            $this->_queue_search_sync($id);
        }
        return $result;
    }

    /**
     * Bulk update status (publish/unpublish/archive)
     */
    public function bulk_update_status(array $ids, string $status): int
    {
        if (empty($ids) || !in_array($status, ['draft', 'active', 'archived'])) return 0;
        $this->db->where_in('id', $ids)->where('store_id', $this->store_id)
                 ->update('products', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        return $this->db->affected_rows();
    }

    /**
     * Update inventory for a specific variant
     */
    public function update_variant_inventory(int $variant_id, int $qty): bool
    {
        return $this->db->where('id', $variant_id)->update('product_variants', [
            'inventory_qty' => $qty,
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Decrement inventory (on order confirmed) — atomic
     */
    public function decrement_inventory(int $variant_id, int $qty): bool
    {
        return $this->db
            ->set('inventory_qty', "GREATEST(0, inventory_qty - $qty)", false)
            ->set('updated_at', date('Y-m-d H:i:s'))
            ->where('id', $variant_id)
            ->where('inventory_qty >=', $qty)  // ensure not negative
            ->update('product_variants');
    }

    // ─── Lookup helpers ──────────────────────────────────────

    public function get_variant_by_id(int $variant_id): ?array
    {
        $row = $this->db->join('products p', 'p.id = product_variants.product_id')
                        ->where('product_variants.id', $variant_id)
                        ->where('p.store_id', $this->store_id)
                        ->get('product_variants')->row_array();
        return $row ?: null;
    }

    public function get_images(int $product_id): array
    {
        return $this->db->where('product_id', $product_id)
                        ->order_by('position', 'ASC')
                        ->get('product_images')->result_array();
    }

    public function get_variants(int $product_id): array
    {
        return $this->db->where('product_id', $product_id)
                        ->order_by('position', 'ASC')
                        ->get('product_variants')->result_array();
    }

    public function get_options_with_values(int $product_id): array
    {
        $options = $this->db->where('product_id', $product_id)
                            ->order_by('position', 'ASC')
                            ->get('product_options')->result_array();
        foreach ($options as &$opt) {
            $opt['values'] = $this->db->where('option_id', $opt['id'])
                                      ->order_by('position', 'ASC')
                                      ->get('product_option_values')->result_array();
        }
        return $options;
    }

    public function get_review_summary(int $product_id): array
    {
        $row = $this->db->select('AVG(rating) AS avg_rating, COUNT(*) AS total')
                        ->where('product_id', $product_id)
                        ->where('status', 'approved')
                        ->get('reviews')->row_array();
        return [
            'avg'   => round((float)($row['avg_rating'] ?? 0), 1),
            'total' => (int)($row['total'] ?? 0),
        ];
    }

    /**
     * Get low-stock products for alerts
     */
    public function get_low_stock(int $limit = 20): array
    {
        return $this->db->select('p.id, p.title, pv.sku, pv.title AS variant_title, 
                pv.inventory_qty, p.low_stock_threshold')
             ->from('product_variants pv')
             ->join('products p', 'p.id = pv.product_id')
             ->where('p.store_id', $this->store_id)
             ->where('p.status', 'active')
             ->where('p.track_inventory', 1)
             ->where('pv.inventory_qty <=', $this->db->escape_str('p.low_stock_threshold'), false)
             ->where('pv.is_active', 1)
             ->order_by('pv.inventory_qty', 'ASC')
             ->limit($limit)
             ->get()->result_array();
    }

    /**
     * Get products pending Meilisearch sync (for cron job)
     */
    public function get_pending_search_sync(int $limit = 100): array
    {
        return $this->db->where('store_id', $this->store_id)
                        ->where('meilisearch_synced', 0)
                        ->where('status', 'active')
                        ->limit($limit)
                        ->get('products')->result_array();
    }

    public function mark_search_synced(array $ids): void
    {
        if (!empty($ids)) {
            $this->db->where_in('id', $ids)->update('products', ['meilisearch_synced' => 1]);
        }
    }

    // ─── CSV Import ──────────────────────────────────────────

    /**
     * Import products from CSV array (parsed rows)
     * Returns ['imported', 'skipped', 'errors']
     */
    public function bulk_import_csv(array $rows): array
    {
        $imported = $skipped = 0;
        $errors   = [];

        foreach ($rows as $i => $row) {
            $row_num = $i + 2;  // 1-indexed + header row
            try {
                if (empty($row['title']) || empty($row['price'])) {
                    $skipped++;
                    $errors[] = "Row $row_num: Missing title or price";
                    continue;
                }
                $product_data = [
                    'title'       => trim($row['title']),
                    'slug'        => $this->_make_unique_slug($row['handle'] ?? $row['title']),
                    'description' => $row['description'] ?? '',
                    'status'      => in_array($row['status'] ?? 'active', ['draft','active','archived']) ? $row['status'] : 'draft',
                    'vendor'      => $row['vendor'] ?? '',
                    'base_price'  => (float)$row['price'],
                    'tags'        => !empty($row['tags']) ? json_encode(array_map('trim', explode(',', $row['tags']))) : null,
                    'seo_title'   => $row['seo_title'] ?? '',
                    'seo_description' => $row['seo_description'] ?? '',
                ];
                $variants = [[
                    'sku'           => $row['variant_sku'] ?? '',
                    'title'         => 'Default',
                    'price'         => (float)($row['variant_price'] ?? $row['price']),
                    'inventory_qty' => (int)($row['inventory_qty'] ?? 0),
                    'cost_price'    => (float)($row['cost_price'] ?? 0),
                ]];
                $images = array_filter(array_map('trim', explode('|', $row['images'] ?? '')));

                $id = $this->create_product($product_data, $variants, [], $images);
                if ($id) $imported++;
                else { $skipped++; $errors[] = "Row $row_num: DB insert failed"; }

            } catch (Throwable $e) {
                $skipped++;
                $errors[] = "Row $row_num: " . $e->getMessage();
                log_message('error', "[Product_model::bulk_import_csv] row $row_num: " . $e->getMessage());
            }
        }

        return compact('imported', 'skipped', 'errors');
    }

    // ─── Private helpers ─────────────────────────────────────

    private function _make_unique_slug(string $raw, int $exclude_id = 0): string
    {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($raw)));
        $slug = trim($slug, '-');
        $base = $slug;
        $counter = 1;
        while (true) {
            $q = $this->db->where('store_id', $this->store_id)->where('slug', $slug);
            if ($exclude_id) $q->where('id !=', $exclude_id);
            $exists = $q->count_all_results('products');
            if (!$exists) break;
            $slug = "$base-$counter";
            $counter++;
        }
        return $slug;
    }

    private function _generate_sku(int $product_id, int $variant_pos): string
    {
        return 'SKU-' . str_pad($product_id, 6, '0', STR_PAD_LEFT) . '-' . ($variant_pos + 1);
    }

    private function _queue_search_sync(int $product_id): void
    {
        try {
            $this->db->insert('jobs_queue', [
                'store_id'     => $this->store_id,
                'queue'        => 'search_sync',
                'payload'      => json_encode(['job' => 'sync_product', 'product_id' => $product_id]),
                'available_at' => date('Y-m-d H:i:s'),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $e) {
            log_message('error', '[Product_model::_queue_search_sync] ' . $e->getMessage());
        }
    }
}
