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
}
