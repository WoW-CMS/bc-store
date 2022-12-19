<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_command_model extends BS_Model
{
    protected $table = 'store_commands';

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
