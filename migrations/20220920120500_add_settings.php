<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_settings extends CI_Migration
{
    public function up()
    {
        $this->setting_model->insert_batch([
            ['key' => 'store_products_per_page', 'value' => '25', 'type' => 'int'],
            ['key' => 'store_mail_subject', 'value' => 'Purchased items', 'type' => 'string'],
            ['key' => 'store_mail_body', 'value' => 'Thank you for buying in our store!', 'type' => 'string']
        ]);
    }

    public function down()
    {
        $this->setting_model->delete_in('key', [
            'store_products_per_page',
            'store_mail_subject',
            'store_mail_body'
        ]);
    }
}
