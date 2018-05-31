<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'       => 'Admin Indodam',
            'username'   => 'indodam_admin',
            'email'      => 'admin@example.net',
            'city'       => 'Banjarmasin',
            'password'   => bcrypt('secret'),
            'role_id'    => 1, // 1:admin, 2:member
            'is_active'  => 1, // 1:active, 0:in_active
            'sponsor_id' => 0,
        ]);
    }
}
