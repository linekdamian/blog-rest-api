<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('category_translations')->insert([
            'category_id' => 1,
            'language_id' => 1,
            'name' => 'Pierwsza kategoria',
            'description' => 'Pierwsza kategoria - polski opis.',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('category_translations')->insert([
            'category_id' => 1,
            'language_id' => 2,
            'name' => 'First category',
            'description' => 'Description for first category.',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('categories')->insert([
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('category_translations')->insert([
            'category_id' => 2,
            'language_id' => 1,
            'name' => 'Druga kategoria',
            'description' => 'Druga kategoria - polski opis.',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('category_translations')->insert([
            'category_id' => 2,
            'language_id' => 2,
            'name' => 'Second category',
            'description' => 'Second category - english description.',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
