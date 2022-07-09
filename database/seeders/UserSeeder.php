<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uuid = Str::uuid();
        DB::table('users')->insert([
            'id' => $uuid,
            'role_id' => '1',
            'firstName' => 'Admin',
            'lastName' => 'Dragon',
            'username' => 'admin.dragon',
            'email' => 'admin@dragon.com',
            'phoneNumber' => '0123456789',
            'password' => bcrypt('147258369'),
            'status' => 'on',
        ]);
        DB::table('settings')->insert([
            'user_id' => $uuid,
            'display' => 'dark'
        ]);
    }
}
