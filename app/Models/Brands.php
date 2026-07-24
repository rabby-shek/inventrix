<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'website',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
