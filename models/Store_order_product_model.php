<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_order_product_model extends BS_Model
{
    protected $table = 'store_orders_products';

    protected $setCreatedField = true;

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
        $query = $this->db->select('store_orders_products.*, store_products.name, realms.realm_name')
            ->from($this->table)
            ->join('store_products', 'store_orders_products.product_id = store_products.id')
            ->join('realms', 'store_orders_products.realm_id = realms.id')
            ->where('store_orders_products.order_id', $filters['order_id']);
        
        if (array_key_exists('search', $filters) && $filters['search'] !== '') {
            $query->group_start()
                ->or_like([
                    'store_orders_products.id' => $filters['search'],
                    'store_products.name'      => $filters['search']
                ])
                ->group_end();
        }

        return $query->order_by('store_orders_products.id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->result();
    }

    /**
     * Get total rows to paginate
     *
     * @param array $filters
     * @return int
     */
    public function total_paginate($filters = [])
    {
        $query = $this->db->select('store_orders_products.*, store_products.name, realms.realm_name')
            ->from($this->table)
            ->join('store_products', 'store_orders_products.product_id = store_products.id')
            ->join('realms', 'store_orders_products.realm_id = realms.id');
        
        if (array_key_exists('search', $filters) && $filters['search'] !== '') {
            $query->group_start()
                ->or_like([
                    'store_orders_products.id' => $filters['search'],
                    'store_products.name'      => $filters['search']
                ])
                ->group_end();
        }

        return $query->count_all_results();
    }
}
