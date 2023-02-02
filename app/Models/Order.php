<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];
    protected $timestap = true;

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }
}
