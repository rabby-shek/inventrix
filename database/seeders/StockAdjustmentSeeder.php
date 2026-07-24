<?php

namespace Database\Seeders;

use App\Models\StockItem;
use App\Models\StockAdjustment;
use Illuminate\Database\Seeder;

class StockAdjustmentSeeder extends Seeder
{
    public function run(): void
    {
        $adjustments = [
            // Additions to Main Warehouse (warehouse_id 1)
            ['reference' => 'ADJ-10000001', 'product_id' => 1, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 50, 'reason' => 'Initial stock for iPhone 15 Pro'],
            ['reference' => 'ADJ-10000002', 'product_id' => 2, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 40, 'reason' => 'Initial stock for Samsung Galaxy S24'],
            ['reference' => 'ADJ-10000003', 'product_id' => 3, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 80, 'reason' => 'Bulk order received - Sony headphones'],
            ['reference' => 'ADJ-10000004', 'product_id' => 6, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 150, 'reason' => 'Clothing restock - Nike T-Shirts'],
            ['reference' => 'ADJ-10000005', 'product_id' => 9, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 60, 'reason' => 'New season stock - Nike Air Max 90'],
            // Additions to Downtown Storage (warehouse_id 2)
            ['reference' => 'ADJ-10000006', 'product_id' => 4, 'warehouse_id' => 2, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 25, 'reason' => 'Laptop inventory for Downtown'],
            ['reference' => 'ADJ-10000007', 'product_id' => 5, 'warehouse_id' => 2, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 15, 'reason' => 'TV stock for Downtown'],
            ['reference' => 'ADJ-10000008', 'product_id' => 11, 'warehouse_id' => 2, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 40, 'reason' => 'Kitchen appliances restock'],
            // Additions to Airport Hub (warehouse_id 3)
            ['reference' => 'ADJ-10000009', 'product_id' => 1, 'warehouse_id' => 3, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 30, 'reason' => 'Airport inventory - iPhones'],
            ['reference' => 'ADJ-10000010', 'product_id' => 7, 'warehouse_id' => 3, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 100, 'reason' => 'Athletic wear bulk order'],
            ['reference' => 'ADJ-10000011', 'product_id' => 16, 'warehouse_id' => 3, 'to_warehouse_id' => null, 'type' => 'addition', 'quantity' => 20, 'reason' => 'Apple Watch Ultra 2 stock'],
            // Deductions
            ['reference' => 'ADJ-10000012', 'product_id' => 1, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'deduction', 'quantity' => 5, 'reason' => 'Online order fulfilled - ORD-5001'],
            ['reference' => 'ADJ-10000013', 'product_id' => 6, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'deduction', 'quantity' => 20, 'reason' => 'Retail sale batch - Store #12'],
            ['reference' => 'ADJ-10000014', 'product_id' => 3, 'warehouse_id' => 1, 'to_warehouse_id' => null, 'type' => 'deduction', 'quantity' => 10, 'reason' => 'Damaged items write-off'],
            ['reference' => 'ADJ-10000015', 'product_id' => 4, 'warehouse_id' => 2, 'to_warehouse_id' => null, 'type' => 'deduction', 'quantity' => 3, 'reason' => 'Corporate bulk order - Client XYZ'],
            // Transfers
            ['reference' => 'ADJ-10000016', 'product_id' => 2, 'warehouse_id' => 1, 'to_warehouse_id' => 2, 'type' => 'transfer', 'quantity' => 10, 'reason' => 'Transfer to Downtown for display models'],
            ['reference' => 'ADJ-10000017', 'product_id' => 9, 'warehouse_id' => 1, 'to_warehouse_id' => 3, 'type' => 'transfer', 'quantity' => 15, 'reason' => 'Airport demand fulfillment'],
            ['reference' => 'ADJ-10000018', 'product_id' => 10, 'warehouse_id' => 1, 'to_warehouse_id' => 2, 'type' => 'transfer', 'quantity' => 10, 'reason' => 'Downtown restocking'],
            ['reference' => 'ADJ-10000019', 'product_id' => 13, 'warehouse_id' => 1, 'to_warehouse_id' => 3, 'type' => 'transfer', 'quantity' => 25, 'reason' => 'Airport sports equipment demand'],
            ['reference' => 'ADJ-10000020', 'product_id' => 15, 'warehouse_id' => 2, 'to_warehouse_id' => 1, 'type' => 'transfer', 'quantity' => 8, 'reason' => 'Transfer back to main - excess stock'],
        ];

        foreach ($adjustments as $adjustment) {
            StockAdjustment::create($adjustment);

            // Sync stock items
            if ($adjustment['type'] === 'addition') {
                StockItem::updateOrCreate(
                    ['product_id' => $adjustment['product_id'], 'warehouse_id' => $adjustment['warehouse_id']],
                    ['quantity' => \DB::raw("quantity + {$adjustment['quantity']}")]
                );
            } elseif ($adjustment['type'] === 'deduction') {
                StockItem::where('product_id', $adjustment['product_id'])
                    ->where('warehouse_id', $adjustment['warehouse_id'])
                    ->update(['quantity' => \DB::raw("GREATEST(0, quantity - {$adjustment['quantity']})")]);
            } elseif ($adjustment['type'] === 'transfer') {
                // Deduct from source
                StockItem::where('product_id', $adjustment['product_id'])
                    ->where('warehouse_id', $adjustment['warehouse_id'])
                    ->update(['quantity' => \DB::raw("GREATEST(0, quantity - {$adjustment['quantity']})")]);
                // Add to destination
                StockItem::updateOrCreate(
                    ['product_id' => $adjustment['product_id'], 'warehouse_id' => $adjustment['to_warehouse_id']],
                    ['quantity' => \DB::raw("quantity + {$adjustment['quantity']}")]
                );
            }
        }
    }
}
