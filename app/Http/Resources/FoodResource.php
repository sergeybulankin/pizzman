<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FoodResource extends Resource
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
            'name' => $this->name,
            'structure' => $this->structure,
            'price' => $this->price,
            'image' => $this->image,
            'recommend' => $this->recommend,
            'weight' => $this->weight,
            'protein' => $this->protein,
            'calories' => $this->calories,
            'carbohydrates' => $this->carbohydrates,

            'types' => $this->type,

            'additives' => $this->additive,
        ];
    }
}
