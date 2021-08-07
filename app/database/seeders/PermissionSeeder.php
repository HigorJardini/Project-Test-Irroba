<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'read-config',           'display_name' => 'read-config',          'description' => 'ver configurações'],
            ['name' => 'read-users',            'display_name' => 'read-users',           'description' => 'ver configurações de usuários'],
            ['name' => 'read-users-aproved',    'display_name' => 'read-users-aproved',   'description' => 'ver configurações de aprovação usuários'],
            ['name' => 'update-users-aproved',  'display_name' => 'update-users-aproved', 'description' => 'Atualizar configurações de aprovação usuários'],
            ['name' => 'delete-users',          'display_name' => 'delete-users',         'description' => 'Deletar usuários'],
            ['name' => 'read-users-list',       'display_name' => 'read-users-list',      'description' => 'ver configurações de listagem dos usuários'],
        ];

        foreach($permissions as $permission){

            Permission::create([
                'name'         => $permission['name'],
                'display_name' => $permission['display_name'],
                'description'  => $permission['description']
            ]);

        }

        $role = Role::find(3);

        $role->attachPermissions([1,2,3,4,5,6]);
    }
}
