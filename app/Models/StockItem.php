<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'min_stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function getStatusAttribute()
    {
        if ($this->quantity == 0) return 'out_of_stock';
        if ($this->quantity <= $this->min_stock) return 'low_stock';
        return 'in_stock';
    }
}
