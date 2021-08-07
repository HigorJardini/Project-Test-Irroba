<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

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
            ['name' => 'system-admin-access', 'display_name' => ''],
        ];

        foreach($permissions as $permission){

            Permission::create([
                'name'         => $permission['name'],
                'display_name' => $permission['display_name'],
                'description'  => $permission['display_name']
            ]);

        }
    }
}
