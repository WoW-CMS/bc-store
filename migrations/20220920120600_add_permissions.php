<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_permissions extends CI_Migration
{
    public function up()
    {
        $this->permission_model->insert_batch([
            ['key' => 'view.store', 'module' => 'store', 'description' => 'Can view store page'],
            ['key' => 'add.categories', 'module' => 'store', 'description' => 'Can add new categories'],
            ['key' => 'edit.categories', 'module' => 'store', 'description' => 'Can edit categories'],
            ['key' => 'delete.categories', 'module' => 'store', 'description' => 'Can delete categories'],
            ['key' => 'add.products', 'module' => 'store', 'description' => 'Can add new products'],
            ['key' => 'edit.products', 'module' => 'store', 'description' => 'Can edit products'],
            ['key' => 'delete.products', 'module' => 'store', 'description' => 'Can delete products']
        ]);

        $permissions = $this->permission_model->find_all(['module' => 'store']);
        $permsLinked = [];

        foreach ($permissions as $permission) {
            if (in_array($permission->key, ['view.store'], true)) {
                $permsLinked[] = ['role_id' => '3', 'permission_id' => $permission->id];
                $permsLinked[] = ['role_id' => '4', 'permission_id' => $permission->id];
                $permsLinked[] = ['role_id' => '5', 'permission_id' => $permission->id];
            }

            if (in_array($permission->key, ['add.categories', 'edit.categories', 'delete.categories', 'add.products', 'edit.products', 'delete.products'], true)) {
                $permsLinked[] = ['role_id' => '5', 'permission_id' => $permission->id];
            }
        }

        $this->role_permission_model->insert_batch($permsLinked);
    }

    public function down()
    {
        $permissions    = $this->permission_model->find_all(['module' => 'store'], 'array');
        $permissionsIds = array_column($permissions, 'id');

        if ($permissionsIds !== []) {
            $this->permission_model->delete_in('id', $permissionsIds);
        }
    }
}
