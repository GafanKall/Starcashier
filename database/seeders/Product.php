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
                'stock' => 11,
                'categories_id' => 1
            ],
            [
                'image' => 'P3.png',
                'product_name' => 'Onion Ring',
                'price' => 7000,
                'stock' => 3,
                'categories_id' => 4
            ],
            [
                'image' => 'P5.png',
                'product_name' => 'Ice Cream Oreo',
                'price' => 19000,
                'stock' => 5,
                'categories_id' => 3
            ],
            [
                'image' => 'P6.png',
                'product_name' => 'Coca Cola',
                'price' => 9000,
                'stock' => 20,
                'categories_id' => 2
            ],
            [
                'image' => 'P4.png',
                'product_name' => 'Chicken Nugget',
                'price' => 10000,
                'stock' => 15,
                'categories_id' => 5
            ],
            [
                'image' => 'P1.png',
                'product_name' => 'Pizza Mushroom',
                'price' => 10000,
                'stock' => 10,
                'categories_id' => 1
            ],
        ]);
    }
}
