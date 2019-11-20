<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    public function food() {
        return $this->belongsTo(Food::class, 'food_id');
    }
}
