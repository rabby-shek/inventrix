<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StockAdjustment extends Model
{
    protected $fillable = [
        'reference',
        'product_id',
        'warehouse_id',
        'to_warehouse_id',
        'type',
        'quantity',
        'reason',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public static function generateReference()
    {
        do {
            $ref = 'ADJ-' . strtoupper(Str::random(8));
        } while (static::where('reference', $ref)->exists());

        return $ref;
    }
}
