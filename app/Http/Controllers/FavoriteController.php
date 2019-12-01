<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Food;
use App\FoodAdditive;
use App\Http\Resources\FavoriteResource;
use App\Http\Resources\FoodResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $favorites = [];

        foreach ($request->favorite as $key => $value) {
            $favorites[] = Food::with('type', 'additive')
                ->where('id', $value)->get();
        }

        $favorites = collect($favorites)->collapse();

        return FoodResource::collection($favorites);
    }

    /**
     * @return mixed
     */
    public function show()
    {
        return view('favorite');
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $favorite = new Favorite();
        $favorite->food_id = $request->product;
        $favorite->user_id = Auth::user()->id;
        $favorite->save();
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        Favorite::where('food_id', $request->product)->where('user_id', Auth::user()->id)->delete();
    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function favoriteForUser()
    {
        $favorites[] = Favorite::select('food_id')
            ->with('food', 'additive')
            ->where('user_id', Auth::user()->id)
            ->get();

        $favorites = collect($favorites)->collapse();

        return FoodResource::collection($favorites);
    }
}
