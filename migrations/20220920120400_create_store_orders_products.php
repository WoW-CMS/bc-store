<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_store_orders_products extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'order_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'product_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'realm_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'guid' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'dp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'vp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('order_id');
        $this->dbforge->add_key('product_id');
        $this->dbforge->add_key('realm_id');
        $this->dbforge->create_table('store_orders_products', false, ['ENGINE' => 'InnoDB']);

        $this->db->query(add_foreign_key($this->db->dbprefix('store_orders_products'), 'order_id', $this->db->dbprefix('store_orders'), 'id', 'CASCADE'));
    }

    public function down()
    {
        $this->db->query(drop_foreign_key($this->db->dbprefix('store_orders_products'), 'order_id'));

        $this->dbforge->drop_table('store_orders_products');
    }
}
