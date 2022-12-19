<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_store_products extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'category_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'realm_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'image' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'currency' => [
                'type' => 'ENUM("vp","dp","both")'
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
            'visible' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('category_id');
        $this->dbforge->add_key('realm_id');
        $this->dbforge->create_table('store_products', false, ['ENGINE' => 'InnoDB']);

        $this->db->query(add_foreign_key($this->db->dbprefix('store_products'), 'category_id', $this->db->dbprefix('store_categories'), 'id', 'CASCADE'));
    }

    public function down()
    {
        $this->db->query(drop_foreign_key($this->db->dbprefix('store_products'), 'category_id'));

        $this->dbforge->drop_table('store_products');
    }
}
