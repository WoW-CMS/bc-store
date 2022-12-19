<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_product_model extends BS_Model
{
    protected $table = 'store_products';

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
     * Get a limit of rows to display per page
     *
     * @param int $limit
     * @param int $offset
     * @param array $filters
     * @return array
     */
    public function paginate($limit, $offset, $filters = [])
    {
        $query = $this->db->select('store_products.*, store_categories.name AS category, realms.realm_name')
            ->from($this->table)
            ->join('store_categories', 'store_products.category_id = store_categories.id')
            ->join('realms', 'store_products.realm_id = realms.id');

        if (array_key_exists('category', $filters) && $filters['category'] !== '') {
            $query->where('store_products.category_id', $filters['category']);
        }

        if (array_key_exists('visible', $filters)) {
            $query->where('store_products.visible', $filters['visible'] === true ? 1 : 0);
        }

        if (array_key_exists('search', $filters) && $filters['search'] !== '') {
            $query->group_start()
                ->or_like([
                    'store_products.name'   => $filters['search'],
                    'store_categories.name' => $filters['search'],
                    'realms.realm_name'     => $filters['search']
                ])
                ->group_end();
        }

        return $query->order_by('store_products.id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Count total rows to paginate
     *
     * @param array $filters
     * @return int
     */
    public function total_paginate($filters = [])
    {
        $query = $this->db->select('store_products.*, store_categories.name AS category, realms.realm_name')
            ->from($this->table)
            ->join('store_categories', 'store_products.category_id = store_categories.id')
            ->join('realms', 'store_products.realm_id = realms.id');

        if (array_key_exists('category', $filters) && $filters['category'] !== '') {
            $query->where('store_products.category_id', $filters['category']);
        }

        if (array_key_exists('visible', $filters)) {
            $query->where('store_products.visible', $filters['visible'] === true ? 1 : 0);
        }

        if (array_key_exists('search', $filters) && $filters['search'] !== '') {
            $query->group_start()
                ->or_like([
                    'store_products.name'   => $filters['search'],
                    'store_categories.name' => $filters['search'],
                    'realms.realm_name'     => $filters['search']
                ])
                ->group_end();
        }

        return $query->count_all_results();
    }

    /**
     * Get all top products
     *
     * @return array
     */
    public function top()
    {
        return $this->find_all();
    }
}
