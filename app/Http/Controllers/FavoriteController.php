<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Resources\FavoriteResource;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $favorites = Favorite::all();

        return FavoriteResource::collection($favorites);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $favorite = new Favorite();
        $favorite->product_id = $request->product;
        $favorite->user_id = 1;
        $favorite->save();
    }

    /**
     * @param Request $request
     */
    public function delete(Request $request)
    {
        Favorite::where('product_id', $request->product)->where('user_id', 1)->delete();
    }

    /**
     * @return mixed
     */
    public function count() {
        $count = Favorite::where('user_id', 1)->get()->count();

        return $count;
    }
}
