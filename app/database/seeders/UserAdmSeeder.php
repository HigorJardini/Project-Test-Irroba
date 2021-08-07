<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserAdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name'              => 'Developer',
            'email'             => 'developer@app.com',
            'password'          => bcrypt('password'),
            'aproved'           => true,
            'active'            => true
        ]);

        $role = \App\Models\Role::find(3);

        $user->attachRole($role);
    }
}
