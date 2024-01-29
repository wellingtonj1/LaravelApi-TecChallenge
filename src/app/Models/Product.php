<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'description',
    ];

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product', 'product_id', 'sale_id')
            ->withPivot('quantity');
    }
}
