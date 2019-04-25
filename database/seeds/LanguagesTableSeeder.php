<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('languages')->insert([
            'code' => 'pl',
            'name' => 'Polish',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('languages')->insert([
            'code' => 'en',
            'name' => 'English',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
