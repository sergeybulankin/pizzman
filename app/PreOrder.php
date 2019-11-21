<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreOrder extends Model
{
    protected $table = 'pre_orders';


    // TODO неверное отношение
    public function food()
    {
        return $this->belongsToMany(Food::class, 'foods_additives', 'id', 'id');
    }

    // TODO неверное отношение
    public function additive()
    {
        return $this->belongsToMany(Additive::class, 'foods_additives', 'id');
    }
}
