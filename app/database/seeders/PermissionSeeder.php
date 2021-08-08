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
            ['name' => 'read-users-manage',     'display_name' => 'read-users-manage',    'description' => 'ver configurações de gerenciamento dos usuários'],
            ['name' => 'create-users-manage',   'display_name' => 'create-users-manage',  'description' => 'Criar usuários nas configurações de gerenciamento'],
            ['name' => 'update-users-manage',   'display_name' => 'update-users-manage',  'description' => 'Atualizar usuários nas configurações de gerenciamento'],
            ['name' => 'delete-users',          'display_name' => 'delete-users',         'description' => 'Deletar usuários'],

            ['name' => 'read-metters',     'display_name' => 'read-metters',    'description' => 'Ver listagem de matérias'],
            ['name' => 'create-metters',   'display_name' => 'create-metters',  'description' => 'Criar matérias'],
            ['name' => 'update-metters',   'display_name' => 'update-metters',  'description' => 'Atualizar matérias'],
            ['name' => 'delete-metters',   'display_name' => 'delete-metters',  'description' => 'Deletar matérias'],
        ];

        $role = Role::find(3);

        foreach($permissions as $key => $permission){

            Permission::create([
                'name'         => $permission['name'],
                'display_name' => $permission['display_name'],
                'description'  => $permission['description']
            ]);

            $role->attachPermissions([$key + 1]);
        }
    }
}
