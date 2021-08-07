<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'              => 'Developer',
            'email'             => 'developer@app.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password'          => '$2y$10$mT2M7RjxPc4zpibaeRGsw.SfIrQzH5cyLODM7ZWJ4TtGcd8RiQgp6',
            'remember_token'    => 0,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);
    }
}
