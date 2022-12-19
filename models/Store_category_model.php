<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_category_model extends BS_Model
{
    protected $table = 'store_categories';

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Find all rows through key/value pairs
     *
     * @param array $where
     * @param string $type The row type. Either 'array' or 'object'
     * @return array
     */
    public function find_all(array $where = [], $type = 'object')
    {
        $query = $this->db->from($this->table);

        if ($where !== []) {
            $query->where($where);
        }

        return $query->order_by('sort', 'ASC')
            ->get()
            ->result($type);
    }

    /**
     * Get sort column of the last item
     *
     * @param int $parent
     * @return int
     */
    public function last_item_sort($parent = 0)
    {
        $result = $this->db->where(['parent' => $parent])
            ->order_by('sort', 'ASC')
            ->get($this->table)
            ->last_row();

        if (empty($result)) {
            return 0;
        }

        return (int) $result->sort;
    }

    /**
     * Get store categories from the saved cache data
     *
     * @return array
     */
    public function categories()
    {
        $cache = $this->cache->get('store_categories');

        if ($cache !== false) {
            return $cache;
        }

        $categories = $this->find_all(['parent' => 0], 'array');

        if (empty($categories)) {
            return [];
        }

        $items = [];

        foreach ($categories as $category) {
            $items[] = (object) array_merge($category, [
                'childs' => $category['type'] === ITEM_DROPDOWN ? $this->find_all(['parent' => $category['id']]) : (object) []
            ]);
        }

        $this->cache->save('store_categories', $items, 604800);

        return $items;
    }
}
