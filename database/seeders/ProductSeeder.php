<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $cat = Category::create(['name' => 'shirts']);
        for ($i = 0; $i < 100; $i++){
            Product::create([
                'name' => fake()->name,
                'image' => 'images/J6461vW2Ne1KvwqHOKxck400svA9LE-metacG5nd2luZy5jb20ucG5n-.png',
                'unit_price' => 120,
                'quantity_available' => 122,
                'description' => fake()->text,
                'category_id' => $cat->id,
            ]);

        }

    }
}
