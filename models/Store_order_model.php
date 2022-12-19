<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_order_model extends BS_Model
{
    protected $table = 'store_orders';

    protected $setCreatedField = true;

    protected $setUpdatedField = true;

    /**
     * Order status
     *
     * @var string
     */
    public const STATUS_COMPLETED  = 'completed';
    public const STATUS_PROCESSING = 'processing';

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
        $query = $this->db->select('store_orders.*, users.nickname, users.username')
            ->from($this->table)
            ->join('users', 'store_orders.user_id = users.id');

        if (array_key_exists('user', $filters) && $filters['user'] !== '') {
            $query->where('store_orders.user_id', $filters['user']);
        }

        if (array_key_exists('search', $filters) && $filters['search'] !== '') {
            $query->group_start()
                ->or_like([
                    'store_orders.id' => $filters['search'],
                    'users.username'  => $filters['search']
                ])
                ->group_end();
        }

        return $query->order_by('store_orders.id', 'DESC')
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
        $query = $this->db->select('store_orders.*, users.nickname, users.username')
            ->from($this->table)
            ->join('users', 'store_orders.user_id = users.id');

        if (array_key_exists('user', $filters) && $filters['user'] !== '') {
            $query->where('store_orders.user_id', $filters['user']);
        }

        if (array_key_exists('search', $filters) && $filters['search'] !== '') {
            $query->group_start()
                ->or_like([
                    'store_orders.id' => $filters['search'],
                    'users.username'  => $filters['search']
                ])
                ->group_end();
        }

        return $query->count_all_results();
    }

    /**
     * Get the latest rows
     *
     * @param int|null $limit
     * @return array
     */
    public function latest($limit = null)
    {
        $limit ??= 5;

        return $this->db->select('store_orders.*, users.nickname, users.username')
            ->from($this->table)
            ->join('users', 'store_orders.user_id = users.id')
            ->order_by('store_orders.id', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}
