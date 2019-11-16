<?php

namespace App\Http\Controllers;

use App\Category;
use App\FoodAdditive;
use App\Http\Resources\FoodResource;
use App\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function catalog()
    {
        $foods = Food::all();

        return FoodResource::collection($foods);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $category = Category::orderBy('id', 'ASC')->first();

        $foods = Food::with('type', 'additive')->where('category_id', $category->id)->get();

        return FoodResource::collection($foods);
    }

    /**
     * Выбираем всю информацию о товаре из таблицы исходя из localStorage
     *
     * @param Request $request
     * @return array|static
     */
    public function informationProductInCart(Request $request)
    {
        $foods = [];

        foreach ($request->cart as $key => $value) {
            $foods[] = FoodAdditive::with('food', 'additive')->where('food_id', $value['id'])->where('additive_id', $value['additive_id'])->get();
        }

        $foods = collect($foods)->collapse();

        $foods->map(function ($field) {
            $field['count'] = 1;
        });

        return $foods;
    }


    /**
     * Выборка товаров по категории
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function selectByCategory(Request $request)
    {
        $foods = Food::with('category')->where('category_id', $request->id)->get();

        return FoodResource::collection($foods);
    }
}
