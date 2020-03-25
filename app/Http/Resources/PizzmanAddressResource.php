<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PizzmanAddressResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'address' => $this->address_id,

            'points' => $this->address_delivery
        ];
    }
}
