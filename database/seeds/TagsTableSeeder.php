<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tags')->insert([
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('tag_translations')->insert([
            'tag_id' => 1,
            'language_id' => 1,
            'name' => 'Pierwszy tag',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('tag_translations')->insert([
            'tag_id' => 1,
            'language_id' => 2,
            'name' => 'First tag',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('categories')->insert([
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('tag_translations')->insert([
            'tag_id' => 2,
            'language_id' => 1,
            'name' => 'Drugi tag',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('tag_translations')->insert([
            'tag_id' => 2,
            'language_id' => 2,
            'name' => 'Second tag',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
