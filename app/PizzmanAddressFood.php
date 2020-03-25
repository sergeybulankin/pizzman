<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PizzmanAddressFood extends Model
{
    protected $table = 'pizzmans_addresses_foods';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function food()
    {
        return $this->hasOne(Food::class, 'id', 'food_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function address()
    {
        return $this->hasManyThrough(Address::class, PizzmanAddress::class, 'address_id', 'id', 'id');
    }
}
