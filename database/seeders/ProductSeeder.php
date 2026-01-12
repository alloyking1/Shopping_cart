<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Computer',
                'price' => 999.99,
                'stock_quantity' => 15,
            ],
            [
                'name' => 'Wireless Mouse',
                'price' => 29.99,
                'stock_quantity' => 50,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'price' => 149.99,
                'stock_quantity' => 30,
            ],
            [
                'name' => 'USB-C Cable',
                'price' => 19.99,
                'stock_quantity' => 75,
            ],
            [
                'name' => 'Monitor 27 inch',
                'price' => 399.99,
                'stock_quantity' => 20,
            ],
            [
                'name' => 'Webcam HD',
                'price' => 79.99,
                'stock_quantity' => 40,
            ],
            [
                'name' => 'Headphones Wireless',
                'price' => 199.99,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'Tablet Stand',
                'price' => 34.99,
                'stock_quantity' => 60,
            ],
            [
                'name' => 'External Hard Drive 1TB',
                'price' => 89.99,
                'stock_quantity' => 35,
            ],
            [
                'name' => 'USB Flash Drive 64GB',
                'price' => 14.99,
                'stock_quantity' => 5, // Low stock for testing
            ],
        ];

        foreach ($products as $product) {
            Product::factory()->create($product);
        }
    }
}
