<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodInOrder extends Model
{
    protected $table = 'foods_in_orders';

    public function food_additive()
    {
        return $this->hasMany(FoodAdditive::class, 'id', 'food_id');
    }
}
