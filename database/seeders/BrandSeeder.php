<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'slug' => 'apple', 'description' => 'Consumer electronics and software', 'website' => 'https://apple.com', 'status' => 'active'],
            ['name' => 'Samsung', 'slug' => 'samsung', 'description' => 'Electronics and technology', 'website' => 'https://samsung.com', 'status' => 'active'],
            ['name' => 'Sony', 'slug' => 'sony', 'description' => 'Electronics, gaming, and entertainment', 'website' => 'https://sony.com', 'status' => 'active'],
            ['name' => 'Nike', 'slug' => 'nike', 'description' => 'Athletic footwear and apparel', 'website' => 'https://nike.com', 'status' => 'active'],
            ['name' => 'Adidas', 'slug' => 'adidas', 'description' => 'Sportswear and footwear', 'website' => 'https://adidas.com', 'status' => 'active'],
            ['name' => 'Dell', 'slug' => 'dell', 'description' => 'Computers and technology', 'website' => 'https://dell.com', 'status' => 'active'],
            ['name' => 'Lenovo', 'slug' => 'lenovo', 'description' => 'PCs, tablets, and smartphones', 'website' => 'https://lenovo.com', 'status' => 'active'],
            ['name' => 'LG', 'slug' => 'lg', 'description' => 'Electronics and home appliances', 'website' => 'https://lg.com', 'status' => 'active'],
            ['name' => 'HP', 'slug' => 'hp', 'description' => 'Personal computers and printers', 'website' => 'https://hp.com', 'status' => 'active'],
            ['name' => 'Under Armour', 'slug' => 'under-armour', 'description' => 'Performance athletic apparel', 'website' => 'https://underarmour.com', 'status' => 'inactive'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
