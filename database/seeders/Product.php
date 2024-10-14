<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Product extends Seeder
{
    /**
     * Seed the products table.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'image' => 'P2.png',
                'product_name' => 'Burger Beef Cheese',
                'price' => 55000,
                'stock' => 100,
                'categories_id' => 1
            ],
            [
                'image' => 'P3.png',
                'product_name' => 'Onion Ring',
                'price' => 7000,
                'stock' => 50,
                'categories_id' => 4
            ],
            [
                'image' => 'P5.png',
                'product_name' => 'Ice Cream Oreo',
                'price' => 19000,
                'stock' => 200,
                'categories_id' => 3
            ],
            [
                'image' => 'P6.png',
                'product_name' => 'Coca Cola',
                'price' => 9000,
                'stock' => 150,
                'categories_id' => 2
            ],
            [
                'image' => 'P4.png',
                'product_name' => 'Chicken Nugget',
                'price' => 10000,
                'stock' => 75,
                'categories_id' => 5
            ],
            [
                'image' => 'P1.png',
                'product_name' => 'Pizza Mushroom',
                'price' => 10000,
                'stock' => 75,
                'categories_id' => 1
            ],
        ]);
    }
}
