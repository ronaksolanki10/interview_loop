<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';
    protected $guarded = [];
    protected $timestap = true;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
