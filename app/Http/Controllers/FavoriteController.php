<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Http\Resources\FavoriteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $favorites = Favorite::with('food')->where('user_id', Auth::user()->id)->get();

        return FavoriteResource::collection($favorites);
    }

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
        Favorite::where('product_id', $request->product)->where('user_id', Auth::user()->id)->delete();
    }

    /**
     * @return mixed
     */
    public function count() {
        $count = Favorite::where('user_id', Auth::user()->id)->get()->count();

        return $count;
    }
}
