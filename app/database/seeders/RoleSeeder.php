<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'student',       'display_name' => 'Aluno'],
            ['name' => 'teacher',       'display_name' => 'professor'],
            ['name' => 'administrator', 'display_name' => 'administrador']
        ];

        foreach($roles as $role){

            Role::create([
                'name'         => $role['name'],
                'display_name' => $role['display_name'],
                'description'  => $role['display_name']
            ]);
            
        }
    }
}
