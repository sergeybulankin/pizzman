<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = Product::all();
        
        //return view('welcome', compact('products'));
        return ProductResource::collection($products);
    }


    /**
     * @return mixed
     */
    public function show()
    {
        return view('welcome');
    }
}
