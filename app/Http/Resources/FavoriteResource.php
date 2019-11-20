<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FavoriteResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user_id,
            'food' => $this->food_id,

            'food_id' => $this->food->id,
            'name' => $this->food->name,
            'structure' => $this->food->structure,
            'price' => $this->food->price,
        ];
    }
}
