<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Resources\FavoriteResource;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{

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
}
