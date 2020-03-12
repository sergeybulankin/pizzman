<?php

namespace App\Http\Controllers;

use App\Food;
use App\Http\Resources\FoodResource;

class HitController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $hits = Food::with('additive')
            ->where('recommend', 1)
            ->limit(4)
            ->get();

        return FoodResource::collection($hits);
    }
}
