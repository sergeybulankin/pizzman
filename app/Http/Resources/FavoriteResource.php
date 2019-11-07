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
            'product' => $this->product_id
        ];
    }
}
