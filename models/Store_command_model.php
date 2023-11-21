<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_command_model extends BS_Model
{
    protected $table = 'store_commands';

    /**
     * Command type
     *
     * @var string
     */
    public const TYPE_ITEM   = 'item';
    public const TYPE_CUSTOM = 'custom';

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
