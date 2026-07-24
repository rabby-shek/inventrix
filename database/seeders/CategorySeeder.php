<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Electronic devices and gadgets', 'status' => 'active'],
            ['name' => 'Clothing', 'slug' => 'clothing', 'description' => 'Apparel and fashion items', 'status' => 'active'],
            ['name' => 'Footwear', 'slug' => 'footwear', 'description' => 'Shoes and boots', 'status' => 'active'],
            ['name' => 'Home & Kitchen', 'slug' => 'home-kitchen', 'description' => 'Home appliances and kitchen items', 'status' => 'active'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports equipment and accessories', 'status' => 'active'],
            ['name' => 'Books', 'slug' => 'books', 'description' => 'Physical and digital books', 'status' => 'active'],
            ['name' => 'Toys', 'slug' => 'toys', 'description' => 'Children toys and games', 'status' => 'active'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Bags, watches, and other accessories', 'status' => 'active'],
            ['name' => 'Health & Beauty', 'slug' => 'health-beauty', 'description' => 'Health care and beauty products', 'status' => 'active'],
            ['name' => 'Clearance', 'slug' => 'clearance', 'description' => 'Discounted and clearance items', 'status' => 'inactive'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
