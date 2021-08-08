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
            ['name' => 'read-config',                         'display_name' => 'read-config',                         'description' => 'ver configurações'],
            ['name' => 'read-users',                          'display_name' => 'read-users',                          'description' => 'ver configurações de usuários'],
            ['name' => 'read-users-aproved',                  'display_name' => 'read-users-aproved',                  'description' => 'ver configurações de aprovação usuários'],
            ['name' => 'update-users-aproved',                'display_name' => 'update-users-aproved',                'description' => 'Atualizar configurações de aprovação usuários'],
            ['name' => 'read-users-manage',                   'display_name' => 'read-users-manage',                   'description' => 'ver configurações de gerenciamento dos usuários'],
            ['name' => 'create-users-manage',                 'display_name' => 'create-users-manage',                 'description' => 'Criar usuários nas configurações de gerenciamento'],
            ['name' => 'update-users-manage',                 'display_name' => 'update-users-manage',                 'description' => 'Atualizar usuários nas configurações de gerenciamento'],
            ['name' => 'delete-users',                        'display_name' => 'delete-users',                        'description' => 'Deletar usuários'],

            ['name' => 'read-metters',                        'display_name' => 'read-metters',                        'description' => 'Ver listagem de matérias'],
            ['name' => 'create-metters',                      'display_name' => 'create-metters',                      'description' => 'Criar matérias'],
            ['name' => 'update-metters',                      'display_name' => 'update-metters',                      'description' => 'Atualizar matérias'],
            ['name' => 'delete-metters',                      'display_name' => 'delete-metters',                      'description' => 'Deletar matérias'],

            ['name' => 'read-classes',                        'display_name' => 'read-classes',                        'description' => 'Ver listagem de aulas'],
            ['name' => 'create-classes',                      'display_name' => 'create-classes',                      'description' => 'Criar aulas'],
            ['name' => 'update-classes',                      'display_name' => 'update-classes',                      'description' => 'Atualizar aulas'],
            ['name' => 'delete-classes',                      'display_name' => 'delete-classes',                      'description' => 'Deletar aulas'],

            ['name' => 'update-classes-teacher',              'display_name' => 'update-classes-teacher',              'description' => 'Atribuir professora as aulas'],
            
            ['name' => 'request-classes',                     'display_name' => 'request-classes',                     'description' => 'Solicitar entrada participação de aulas'],
            ['name' => 'request-cancel-classes',              'display_name' => 'request-cancel-classes',              'description' => 'Cancelar participação de aulas'],

            ['name' => 'read-all-classes',                    'display_name' => 'read-all-classes',                    'description' => 'Ver todas as aulas'],

            ['name' => 'read-classes-students',               'display_name' => 'read-classes-students',               'description' => 'Ver alunos inscritos na aula'],
            ['name' => 'update-classes-students-request',     'display_name' => 'update-classes-students-request',        'description' => 'Ver solicitações (aceitar ou negar ) para entrar na aula'],
        ];

        $role1 = Role::find(1);
        $role2 = Role::find(2);
        $role3 = Role::find(3);

        foreach($permissions as $key => $permission){

            Permission::create([
                'name'         => $permission['name'],
                'display_name' => $permission['display_name'],
                'description'  => $permission['description']
            ]);

            $role3->attachPermissions([$key + 1]);
        }

        $role1->attachPermissions([13,18,19,20]);
        $role2->attachPermissions([9,13,14,15, 21,22]);
    }
}
