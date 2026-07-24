<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'address',
        'capacity',
        'occupied',
        'manager',
        'status',
    ];

    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }

    public function adjustmentsFrom()
    {
        return $this->hasMany(StockAdjustment::class, 'warehouse_id');
    }

    public function adjustmentsTo()
    {
        return $this->hasMany(StockAdjustment::class, 'to_warehouse_id');
    }

    public function getAvailableAttribute()
    {
        return $this->capacity ? $this->capacity - $this->occupied : 0;
    }

    public function getOccupancyPercentAttribute()
    {
        return $this->capacity ? round(($this->occupied / $this->capacity) * 100) : 0;
    }
}
