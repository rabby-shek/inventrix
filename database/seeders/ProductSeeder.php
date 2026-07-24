<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electronics (category_id 1)
            ['name' => 'iPhone 15 Pro', 'sku' => 'ELEC-001', 'description' => 'Apple iPhone 15 Pro 256GB', 'selling_price' => 1199.99, 'cost_price' => 899.99, 'category_id' => 1, 'brand_id' => 1, 'min_stock' => 10, 'status' => 'active'],
            ['name' => 'Samsung Galaxy S24', 'sku' => 'ELEC-002', 'description' => 'Samsung Galaxy S24 Ultra 512GB', 'selling_price' => 1099.99, 'cost_price' => 799.99, 'category_id' => 1, 'brand_id' => 2, 'min_stock' => 10, 'status' => 'active'],
            ['name' => 'Sony WH-1000XM5', 'sku' => 'ELEC-003', 'description' => 'Sony Noise Cancelling Headphones', 'selling_price' => 349.99, 'cost_price' => 229.99, 'category_id' => 1, 'brand_id' => 3, 'min_stock' => 15, 'status' => 'active'],
            ['name' => 'Dell XPS 15', 'sku' => 'ELEC-004', 'description' => 'Dell XPS 15 Laptop i7 16GB 512GB', 'selling_price' => 1599.99, 'cost_price' => 1199.99, 'category_id' => 1, 'brand_id' => 6, 'min_stock' => 5, 'status' => 'active'],
            ['name' => 'LG OLED 55"', 'sku' => 'ELEC-005', 'description' => 'LG 55" OLED Smart TV', 'selling_price' => 1299.99, 'cost_price' => 999.99, 'category_id' => 1, 'brand_id' => 8, 'min_stock' => 3, 'status' => 'active'],
            // Clothing (category_id 2)
            ['name' => 'Nike Dri-FIT T-Shirt', 'sku' => 'CLTH-001', 'description' => 'Nike Dri-FIT Training T-Shirt', 'selling_price' => 34.99, 'cost_price' => 15.99, 'category_id' => 2, 'brand_id' => 4, 'min_stock' => 50, 'status' => 'active'],
            ['name' => 'Adidas Track Jacket', 'sku' => 'CLTH-002', 'description' => 'Adidas 3-Stripes Track Jacket', 'selling_price' => 79.99, 'cost_price' => 39.99, 'category_id' => 2, 'brand_id' => 5, 'min_stock' => 30, 'status' => 'active'],
            ['name' => 'Under Armour Hoodie', 'sku' => 'CLTH-003', 'description' => 'Under Armour Fleece Hoodie', 'selling_price' => 64.99, 'cost_price' => 29.99, 'category_id' => 2, 'brand_id' => 10, 'min_stock' => 25, 'status' => 'active'],
            // Footwear (category_id 3)
            ['name' => 'Nike Air Max 90', 'sku' => 'FOOT-001', 'description' => 'Nike Air Max 90 Men\'s Shoes', 'selling_price' => 129.99, 'cost_price' => 64.99, 'category_id' => 3, 'brand_id' => 4, 'min_stock' => 20, 'status' => 'active'],
            ['name' => 'Adidas Ultraboost', 'sku' => 'FOOT-002', 'description' => 'Adidas Ultraboost Running Shoes', 'selling_price' => 189.99, 'cost_price' => 99.99, 'category_id' => 3, 'brand_id' => 5, 'min_stock' => 15, 'status' => 'active'],
            // Home & Kitchen (category_id 4)
            ['name' => 'Instant Pot Duo 7-in-1', 'sku' => 'HOME-001', 'description' => 'Instant Pot Duo 7-in-1 Electric Pressure Cooker 6Qt', 'selling_price' => 89.99, 'cost_price' => 49.99, 'category_id' => 4, 'brand_id' => null, 'min_stock' => 20, 'status' => 'active'],
            ['name' => 'Dyson V15 Vacuum', 'sku' => 'HOME-002', 'description' => 'Dyson V15 Detect Cordless Vacuum', 'selling_price' => 649.99, 'cost_price' => 449.99, 'category_id' => 4, 'brand_id' => null, 'min_stock' => 5, 'status' => 'active'],
            // Sports (category_id 5)
            ['name' => 'Yoga Mat Premium', 'sku' => 'SPRT-001', 'description' => 'Premium Non-Slip Yoga Mat 6mm', 'selling_price' => 49.99, 'cost_price' => 19.99, 'category_id' => 5, 'brand_id' => null, 'min_stock' => 30, 'status' => 'active'],
            ['name' => 'Dumbbell Set 20kg', 'sku' => 'SPRT-002', 'description' => 'Adjustable Dumbbell Set 20kg Pair', 'selling_price' => 149.99, 'cost_price' => 79.99, 'category_id' => 5, 'brand_id' => null, 'min_stock' => 10, 'status' => 'active'],
            // Accessories (category_id 8)
            ['name' => 'Apple Watch Ultra 2', 'sku' => 'ACCS-001', 'description' => 'Apple Watch Ultra 2 Titanium 49mm', 'selling_price' => 799.99, 'cost_price' => 599.99, 'category_id' => 8, 'brand_id' => 1, 'min_stock' => 10, 'status' => 'active'],
            ['name' => 'Ray-Ban Aviator', 'sku' => 'ACCS-002', 'description' => 'Ray-Ban Aviator Classic Sunglasses', 'selling_price' => 159.99, 'cost_price' => 69.99, 'category_id' => 8, 'brand_id' => null, 'min_stock' => 20, 'status' => 'active'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
