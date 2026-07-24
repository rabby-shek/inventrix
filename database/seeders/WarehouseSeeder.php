<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            ['name' => 'Main Warehouse', 'address' => '123 Industrial Blvd, New York, NY 10001', 'capacity' => 5000, 'occupied' => 0, 'manager' => 'John Smith', 'status' => 'active'],
            ['name' => 'Downtown Storage', 'address' => '456 Commerce St, New York, NY 10002', 'capacity' => 2000, 'occupied' => 0, 'manager' => 'Jane Doe', 'status' => 'active'],
            ['name' => 'Airport Hub', 'address' => '789 Airport Rd, Newark, NJ 07101', 'capacity' => 8000, 'occupied' => 0, 'manager' => 'Mike Johnson', 'status' => 'active'],
            ['name' => 'Backup Facility', 'address' => '321 Storage Way, Brooklyn, NY 11201', 'capacity' => 3000, 'occupied' => 0, 'manager' => 'Sarah Wilson', 'status' => 'maintenance'],
            ['name' => 'East Side Depot', 'address' => '555 East Ave, Queens, NY 11101', 'capacity' => 4000, 'occupied' => 0, 'manager' => 'Tom Brown', 'status' => 'active'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::create($warehouse);
        }
    }
}
