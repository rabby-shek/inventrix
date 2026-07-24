<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'description',
        'selling_price',
        'cost_price',
        'category_id',
        'brand_id',
        'min_stock',
        'image',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }

    public function adjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

}
