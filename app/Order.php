<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function food()
    {
        return $this->hasMany(FoodInOrder::class, 'id', 'order_id');
    }
}
