<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_store_commands extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'product_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => TRUE
            ],
            'type' => [
                'type' => 'ENUM("item","custom")'
            ],
            'command' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
            'item' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'stackable' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('product_id');
        $this->dbforge->create_table('store_commands', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->dbforge->drop_table('store_commands');
    }
}
