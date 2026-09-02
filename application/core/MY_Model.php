<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NovaDrop — MY_Model
 * Base model with scoped queries (always by store_id),
 * parameterized query enforcement, and soft-delete support.
 */
#[AllowDynamicProperties]
class MY_Model extends CI_Model {

    /** @var string Table name — override in child */
    protected string $table = '';

    /** @var string Primary key */
    protected string $primary_key = 'id';

    /** @var bool Whether this model scope all queries to store_id */
    protected bool $store_scoped = true;

    /** @var int */
    protected int $store_id = 1;

    /** @var bool Soft deletes via deleted_at column */
    protected bool $soft_deletes = false;

    public function __construct()
    {
        parent::__construct();
        $this->store_id = (int)(config_item('store_id') ?? 1);
    }

    // ─── Base Finders ────────────────────────────────────────

    public function find(int $id): ?array
    {
        $q = $this->db->where($this->primary_key, $id);
        if ($this->store_scoped) {
            $q->where('store_id', $this->store_id);
        }
        if ($this->soft_deletes) {
            $q->where('deleted_at IS NULL', null, false);
        }
        $row = $this->db->get($this->table)->row_array();
        return $row ?: null;
    }

    public function get_by_id(int $id): ?array
    {
        return $this->find($id);
    }

    public function find_by(array $conditions): ?array
    {
        $this->_apply_scope();
        $this->db->where($conditions);
        $row = $this->db->get($this->table)->row_array();
        return $row ?: null;
    }

    public function get_all(array $conditions = [], string $order_by = '', int $limit = 0, int $offset = 0): array
    {
        $this->_apply_scope();
        if ($conditions) $this->db->where($conditions);
        if ($order_by) $this->db->order_by($order_by);
        if ($limit) $this->db->limit($limit, $offset);
        if ($this->soft_deletes) {
            $this->db->where('deleted_at IS NULL', null, false);
        }
        return $this->db->get($this->table)->result_array();
    }

    public function count(array $conditions = []): int
    {
        $this->_apply_scope();
        if ($conditions) $this->db->where($conditions);
        if ($this->soft_deletes) {
            $this->db->where('deleted_at IS NULL', null, false);
        }
        return $this->db->count_all_results($this->table);
    }

    // ─── Writes ──────────────────────────────────────────────

    public function create(array $data): int|false
    {
        if ($this->store_scoped && !isset($data['store_id'])) {
            $data['store_id'] = $this->store_id;
        }
        $data = $this->_timestamps($data, 'create');
        if ( ! $this->db->insert($this->table, $data)) {
            return false;
        }
        return $this->db->insert_id();
    }

    public function update_by_id(int $id, array $data): bool
    {
        $data = $this->_timestamps($data, 'update');
        $q = $this->db->where($this->primary_key, $id);
        if ($this->store_scoped) {
            $q->where('store_id', $this->store_id);
        }
        return $this->db->update($this->table, $data);
    }

    public function delete_by_id(int $id): bool
    {
        if ($this->soft_deletes) {
            return $this->update_by_id($id, ['deleted_at' => date('Y-m-d H:i:s')]);
        }
        $q = $this->db->where($this->primary_key, $id);
        if ($this->store_scoped) {
            $q->where('store_id', $this->store_id);
        }
        return $this->db->delete($this->table);
    }

    // ─── Pagination ──────────────────────────────────────────

    public function paginate(int $page, int $per_page = 20, array $conditions = [], string $order_by = 'id DESC'): array
    {
        $offset = ($page - 1) * $per_page;
        $total  = $this->count($conditions);
        $items  = $this->get_all($conditions, $order_by, $per_page, $offset);
        return [
            'items'       => $items,
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $per_page,
            'total_pages' => (int) ceil($total / $per_page),
        ];
    }

    // ─── Private Helpers ─────────────────────────────────────

    private function _apply_scope(): void
    {
        if ($this->store_scoped) {
            $this->db->where('store_id', $this->store_id);
        }
    }

    private function _timestamps(array $data, string $op): array
    {
        $now = date('Y-m-d H:i:s');
        if ($op === 'create') $data['created_at'] = $now;
        $data['updated_at'] = $now;
        return $data;
    }
}
