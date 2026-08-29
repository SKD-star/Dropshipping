<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller
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
        $search = $this->input->get('q', true);
        $status = $this->input->get('status', true);
        $collection_id = $this->input->get('collection_id', true);

        if (!empty($search)) {
            $this->db->group_start()->like('title', $search)->or_like('vendor', $search)->group_end();
        }
        if (!empty($status)) { $this->db->where('status', $status); }
        if (!empty($collection_id)) { $this->db->where('collection_id', (int)$collection_id); }

        $products    = $this->db->where('store_id', $this->store_id)->order_by('id', 'DESC')->get('products')->result_array();
        $collections = $this->db->where('is_active', 1)->get('collections')->result_array();

        foreach ($products as &$p) {
            $img = $this->db->where('product_id', $p['id'])->where('is_primary', 1)->get('product_images')->row_array();
            $p['primary_image'] = $img['url'] ?? null;
        }
        unset($p);

        $data = [
            'title'        => 'Products — NovaDrop Admin',
            'products'     => $products,
            'collections'  => $collections,
            'search'       => $search,
            'status'       => $status,
            'collection_id'=> $collection_id,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/products/index', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function create()
    {
        if ($this->input->method() === 'post') {
            $pname      = $this->input->post('title', true);
            $base_price = (float)$this->input->post('base_price');
            $col_id     = $this->input->post('collection_id') ?: null;
            $desc       = $this->input->post('description');
            $vendor     = $this->input->post('vendor', true) ?: 'NovaDrop';
            $status     = $this->input->post('status', true) ?: 'active';

            $slug = strtolower(url_title($pname, '-', true));
            if ($this->db->where('slug', $slug)->count_all_results('products') > 0) {
                $slug .= '-' . substr(uniqid(), -4);
            }

            $prod_data = [
                'store_id'         => $this->store_id,
                'collection_id'    => $col_id,
                'title'            => $pname,
                'slug'             => $slug,
                'description'      => $desc,
                'vendor'           => $vendor,
                'status'           => $status,
                'base_price'       => $base_price,
                'compare_at_price' => $base_price * 1.2,
                'is_featured'      => $this->input->post('is_featured') ? 1 : 0,
                'created_at'       => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('products', $prod_data);
            $new_id = $this->db->insert_id();

            $this->db->insert('product_variants', [
                'product_id'       => $new_id,
                'sku'              => 'NOVA-' . rand(1000, 9999),
                'title'            => 'Standard',
                'price'            => $base_price,
                'compare_at_price' => $base_price * 1.2,
                'inventory_qty'    => (int)($this->input->post('stock') ?: 50),
                'is_active'        => 1,
            ]);

            if (!empty($_FILES['image']['name'])) {
                $img_name   = 'prod_' . $new_id . '_' . time() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $upload_dir = FCPATH . 'assets/uploads/';
                @mkdir($upload_dir, 0777, true);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $img_name)) {
                    $this->db->insert('product_images', [
                        'product_id' => $new_id,
                        'url'        => base_url('assets/uploads/' . $img_name),
                        'alt_text'   => $pname,
                        'is_primary' => 1,
                        'position'   => 1,
                    ]);
                }
            }

            $this->audit('product.created', 'products', $new_id, [], $prod_data);
            $this->session->set_flashdata('success', 'Product created successfully!');
            redirect('admin/products');
        }

        $data = [
            'title'       => 'Add Product — NovaDrop Admin',
            'collections' => $this->db->where('is_active', 1)->get('collections')->result_array(),
            'product'     => null,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/products/create', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Edit ─────────────────────────────────────────────────
    public function edit($id)
    {
        $id      = (int)$id;
        $product = $this->db->where('id', $id)->get('products')->row_array();
        if (!$product) { show_404(); }

        if ($this->input->method() === 'post') {
            $old = $product;
            $new_data = [
                'collection_id'    => $this->input->post('collection_id') ?: null,
                'title'            => $this->input->post('title', true),
                'description'      => $this->input->post('description'),
                'vendor'           => $this->input->post('vendor', true) ?: 'NovaDrop',
                'status'           => $this->input->post('status', true) ?: 'active',
                'base_price'       => (float)$this->input->post('base_price'),
                'compare_at_price' => (float)($this->input->post('compare_at_price') ?: $this->input->post('base_price') * 1.2),
                'is_featured'      => $this->input->post('is_featured') ? 1 : 0,
                'updated_at'       => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id', $id)->update('products', $new_data);
            $this->db->where('product_id', $id)->limit(1)->update('product_variants', [
                'price'            => $new_data['base_price'],
                'compare_at_price' => $new_data['compare_at_price'],
            ]);

            if (!empty($_FILES['image']['name'])) {
                $img_name   = 'prod_' . $id . '_' . time() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $upload_dir = FCPATH . 'assets/uploads/';
                @mkdir($upload_dir, 0777, true);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $img_name)) {
                    $this->db->where('product_id', $id)->update('product_images', ['is_primary' => 0]);
                    $this->db->insert('product_images', [
                        'product_id' => $id,
                        'url'        => base_url('assets/uploads/' . $img_name),
                        'alt_text'   => $new_data['title'],
                        'is_primary' => 1,
                        'position'   => 1,
                    ]);
                }
            }

            $this->audit('product.updated', 'products', $id, $old, $new_data);
            $this->session->set_flashdata('success', 'Product updated.');
            redirect('admin/products/edit/' . $id);
        }

        $variants    = $this->db->where('product_id', $id)->get('product_variants')->result_array();
        $images      = $this->db->where('product_id', $id)->order_by('position', 'ASC')->get('product_images')->result_array();
        $collections = $this->db->where('is_active', 1)->get('collections')->result_array();

        $data = [
            'title'       => "Edit: {$product['title']} — NovaDrop Admin",
            'product'     => $product,
            'variants'    => $variants,
            'images'      => $images,
            'collections' => $collections,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/products/edit', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $this->db->where('product_id', $id)->delete('product_variants');
        $this->db->where('product_id', $id)->delete('product_images');
        $this->db->where('id', $id)->delete('products');
        $this->audit('product.deleted', 'products', $id);
        $this->session->set_flashdata('success', 'Product deleted.');
        redirect('admin/products');
    }

    // ─── Stock / Inventory ────────────────────────────────────
    public function stock()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('stock_action');
            if ($act === 'update_qty') {
                $variant_id = (int)$this->input->post('variant_id');
                $qty        = (int)$this->input->post('qty');
                $old = $this->db->where('id', $variant_id)->get('product_variants')->row_array();
                $this->db->where('id', $variant_id)->update('product_variants', ['inventory_qty' => max(0, $qty)]);
                $this->audit('stock.updated', 'product_variants', $variant_id, ['inventory_qty' => $old['inventory_qty'] ?? 0], ['inventory_qty' => $qty]);
                $this->session->set_flashdata('success', "Stock updated for variant #{$variant_id}.");
            } elseif ($act === 'bulk_update') {
                $variants = $this->input->post('variant') ?: [];
                foreach ($variants as $vid => $vdata) {
                    $vid = (int)$vid;
                    $this->db->where('id', $vid)->update('product_variants', [
                        'inventory_qty' => max(0, (int)($vdata['qty'] ?? 0)),
                        'sku'           => trim($vdata['sku'] ?? ''),
                    ]);
                }
                $this->session->set_flashdata('success', 'Bulk stock updated.');
            }
            redirect('admin/products/stock');
        }

        $variants = $this->db
            ->select('pv.*, p.title AS product_title, p.id AS product_id')
            ->from('product_variants pv')
            ->join('products p', 'p.id = pv.product_id', 'left')
            ->where('p.store_id', $this->store_id)
            ->order_by('pv.inventory_qty', 'ASC')
            ->get()->result_array();

        $data = [
            'title'               => 'Inventory — NovaDrop Admin',
            'variants'            => $variants,
            'low_stock_threshold' => 10,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/products/stock', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Categories ───────────────────────────────────────────
    public function categories()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('cat_action');
            if ($act === 'save') {
                $id  = (int)$this->input->post('id');
                $row = [
                    'name'       => trim($this->input->post('name', true)),
                    'slug'       => strtolower(url_title(trim($this->input->post('slug', true) ?: $this->input->post('name', true)), '-', true)),
                    'parent_id'  => $this->input->post('parent_id') ? (int)$this->input->post('parent_id') : null,
                    'sort_order' => (int)($this->input->post('sort_order') ?: 0),
                    'is_active'  => $this->input->post('is_active') ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                if ($id > 0) {
                    $this->db->where('id', $id)->update('categories', $row);
                } else {
                    $row['store_id']   = $this->store_id;
                    $row['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('categories', $row);
                }
                $this->session->set_flashdata('success', "Category '{$row['name']}' saved.");
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('parent_id', $id)->update('categories', ['parent_id' => null]);
                $this->db->where('id', $id)->delete('categories');
                $this->session->set_flashdata('success', 'Category deleted.');
            }
            redirect('admin/products/categories');
        }

        $categories = $this->db->table_exists('categories')
            ? $this->db->where('store_id', $this->store_id)->order_by('sort_order', 'ASC')->get('categories')->result_array()
            : [];

        $data = ['title' => 'Categories — NovaDrop Admin', 'categories' => $categories];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/products/categories', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Reviews ──────────────────────────────────────────────
    public function reviews()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('review_action');
            if ($act === 'approve') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->update('reviews', ['is_approved' => 1]);
                $this->session->set_flashdata('success', 'Review approved.');
            } elseif ($act === 'reject') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->update('reviews', ['is_approved' => 0]);
                $this->session->set_flashdata('success', 'Review hidden.');
            } elseif ($act === 'delete') {
                $id = (int)$this->input->post('id');
                $this->db->where('id', $id)->delete('reviews');
                $this->session->set_flashdata('success', 'Review deleted.');
            }
            redirect('admin/products/reviews');
        }

        $filter = $this->input->get('filter') ?: 'pending';
        if ($filter === 'pending') { $this->db->where('is_approved', 0); }
        elseif ($filter === 'approved') { $this->db->where('is_approved', 1); }

        $reviews = $this->db->table_exists('reviews')
            ? $this->db->select('r.*, p.title AS product_title')
                       ->from('reviews r')
                       ->join('products p', 'p.id = r.product_id', 'left')
                       ->order_by('r.id', 'DESC')
                       ->limit(100)
                       ->get()->result_array()
            : [];

        $data = ['title' => 'Product Reviews — NovaDrop Admin', 'reviews' => $reviews, 'filter' => $filter];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/products/reviews', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    // ─── Universal Supplier & CSV Importer ───────────────────
    public function import()
    {
        if ($this->input->method() === 'post') {
            $act = $this->input->post('importer_action') ?: $this->input->post('import_action');

            if ($act === 'push_supplier_product') {
                $p_title           = trim($this->input->post('title', true) ?: 'Trending Supplier Product');
                $supplier_name     = trim($this->input->post('supplier_name', true) ?: 'Alibaba Global Trade');
                $supplier_cost     = (float)($this->input->post('supplier_cost') ?: 999.00);
                $markup_multiplier = (float)($this->input->post('markup_multiplier') ?: 2.8);
                $base_price        = (float)($this->input->post('selling_price') ?: ($supplier_cost * $markup_multiplier));
                $compare_price     = (float)($this->input->post('compare_at_price') ?: ($base_price * 1.35));
                $cat_id            = $this->input->post('collection_id') ? (int)$this->input->post('collection_id') : null;
                $p_desc            = trim($this->input->post('description'));
                $p_img             = trim($this->input->post('image_url', true) ?: base_url('img/placeholder.jpg'));

                $slug = strtolower(url_title($p_title, '-', true));
                if ($this->db->where('slug', $slug)->count_all_results('products') > 0) {
                    $slug .= '-' . rand(100, 999);
                }

                $prod_row = [
                    'store_id'         => $this->store_id,
                    'collection_id'    => $cat_id,
                    'title'            => $p_title,
                    'slug'             => $slug,
                    'description'      => $p_desc,
                    'vendor'           => $supplier_name,
                    'status'           => 'active',
                    'base_price'       => $base_price,
                    'compare_at_price' => $compare_price,
                    'is_featured'      => 1,
                    'created_at'       => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('products', $prod_row);
                $new_id = $this->db->insert_id();

                // Add primary image
                $this->db->insert('product_images', [
                    'product_id' => $new_id,
                    'url'        => $p_img,
                    'alt_text'   => $p_title,
                    'is_primary' => 1,
                    'position'   => 1,
                ]);

                // Generate standard size variants
                $sizes = ['S', 'M', 'L', 'XL'];
                foreach ($sizes as $sz) {
                    $this->db->insert('product_variants', [
                        'product_id'       => $new_id,
                        'sku'              => 'SUP-' . $new_id . '-' . $sz,
                        'title'            => 'Standard / ' . $sz,
                        'price'            => $base_price,
                        'compare_at_price' => $compare_price,
                        'inventory_qty'    => 50,
                        'is_active'        => 1,
                    ]);
                }

                $this->audit('supplier.product_pushed', 'products', $new_id, [], ['supplier' => $supplier_name, 'cost' => $supplier_cost, 'price' => $base_price]);
                $this->session->set_flashdata('success', "✨ Product '{$p_title}' from {$supplier_name} successfully published to catalog!");
                redirect('admin/products/import');

            } elseif ($act === 'csv_import') {
                if (empty($_FILES['csv_file']['name'])) {
                    $this->session->set_flashdata('error', 'No CSV file selected.');
                    redirect('admin/products/import');
                }

                $tmp    = $_FILES['csv_file']['tmp_name'];
                $rows   = 0;
                $errors = 0;

                if (($handle = fopen($tmp, 'r')) !== false) {
                    fgetcsv($handle); // skip header
                    while (($row = fgetcsv($handle)) !== false) {
                        if (count($row) < 2) { $errors++; continue; }
                        [$title, $price, $stock, $vendor, $description] = array_pad($row, 5, '');
                        $title = trim($title);
                        if (empty($title)) { $errors++; continue; }

                        $slug = strtolower(url_title($title, '-', true));
                        if ($this->db->where('slug', $slug)->count_all_results('products') > 0) {
                            $slug .= '-' . substr(uniqid(), -4);
                        }

                        $this->db->insert('products', [
                            'store_id'    => $this->store_id,
                            'title'       => $title,
                            'slug'        => $slug,
                            'base_price'  => max(0, (float)str_replace(',', '', $price)),
                            'vendor'      => trim($vendor) ?: 'NovaDrop',
                            'description' => trim($description),
                            'status'      => 'active',
                            'created_at'  => date('Y-m-d H:i:s'),
                        ]);
                        $pid = $this->db->insert_id();
                        $this->db->insert('product_variants', [
                            'product_id'    => $pid,
                            'sku'           => 'IMP-' . rand(10000, 99999),
                            'title'         => 'Standard',
                            'price'         => max(0, (float)str_replace(',', '', $price)),
                            'inventory_qty' => max(0, (int)$stock),
                            'is_active'     => 1,
                        ]);
                        $rows++;
                    }
                    fclose($handle);
                }

                $this->audit('products.csv_imported', 'products', 0, [], ['imported' => $rows, 'skipped' => $errors]);
                $this->session->set_flashdata('success', "Import complete: {$rows} products added, {$errors} skipped.");
                redirect('admin/products/import');
            }
        }

        // Verified curated supplier products catalogue
        $verified_supplier_catalog = [
            [
                'title'         => 'Italian Melton Wool Dropped-Shoulder Overcoat',
                'supplier_name' => 'Alibaba Luxury Outerwear Hub',
                'supplier_sku'  => 'SUP-ALB-89301',
                'supplier_cost' => 1499.00,
                'markup'        => 2.8,
                'selling_price' => 4199.00,
                'compare_price' => 5699.00,
                'image_url'     => base_url('img/cashmere_cocoon_coat.jpg'),
                'rating'        => '4.95★',
                'orders_count'  => 1420,
                'badge'         => 'High Margin (64%)',
                'description'   => 'Crafted from Italian Melton wool with drop-shoulder silhouette, horn buttons, and breathable silk lining.'
            ],
            [
                'title'         => 'Minimalist Chronograph Sapphire Watch',
                'supplier_name' => 'CJ Dropshipping Verified Factory',
                'supplier_sku'  => 'SUP-CJD-10294',
                'supplier_cost' => 650.00,
                'markup'        => 3.2,
                'selling_price' => 2099.00,
                'compare_price' => 3199.00,
                'image_url'     => base_url('img/pleated_trouser.jpg'),
                'rating'        => '4.91★',
                'orders_count'  => 3810,
                'badge'         => 'Fast Ship (3 Days)',
                'description'   => '316L surgical steel casing with genuine leather strap and anti-scratch sapphire crystal face.'
            ],
            [
                'title'         => 'Architectural Structured Leather Tote',
                'supplier_name' => 'Taobao Premium Leather Guild',
                'supplier_sku'  => 'SUP-TB-77412',
                'supplier_cost' => 1100.00,
                'markup'        => 2.6,
                'selling_price' => 2899.00,
                'compare_price' => 3899.00,
                'image_url'     => base_url('img/alpaca_sweater.jpg'),
                'rating'        => '4.88★',
                'orders_count'  => 890,
                'badge'         => 'Trending Viral',
                'description'   => 'Full-grain vegetable-tanned leather with reinforced gold hardware and laptop sleeve partition.'
            ]
        ];

        $collections = $this->db->where('is_active', 1)->get('collections')->result_array();

        $data = [
            'title'                     => 'Universal Dropshipping Supplier Importer — NovaDrop Admin',
            'verified_supplier_catalog' => $verified_supplier_catalog,
            'collections'               => $collections,
        ];
        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/products/import', $data);
        $this->load->view('admin/layout/footer', $data);
    }
}
