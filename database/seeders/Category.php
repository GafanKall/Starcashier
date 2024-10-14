<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category extends Seeder
{
    /**
     * Seed the categories table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['category_name' => 'Food'],
            ['category_name' => 'Drink'],
            ['category_name' => 'Dessert'],
            ['category_name' => 'Snack'],
            ['category_name' => 'Other'],
        ]);
    }
}
