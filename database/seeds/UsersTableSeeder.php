<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'd@d.pl',
            'password' => app('hash')->make('ddd'),
            'role' => 'admin',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
