<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name'=> 'Category 3',
            'slug'=> Str::slug('Category 3'),
            'description' =>'Category Descreption text',
            'parent_id' => 2,
        ]);
    }
}
