<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function additive()
    {
        //return $this->hasManyThrough(Additive::class, FoodAdditive::class, 'food_id', 'id', 'food_id', 'id');
        return $this->hasManyThrough(FoodAdditive::class, Additive::class, 'id', 'food_id', 'food_id', 'id');
    }
}
