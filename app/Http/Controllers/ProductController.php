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

        $products->map(function ($field) {
            $field['deleted_product_id_from_cart'] = 0;
        });

        return ProductResource::collection($products);
    }


    /**
     * @return mixed
     */
    public function show()
    {
        return view('index');
    }


    /**
     * @param Request $request
     * @return array|static
     */
    public function informationProductInCart(Request $request)
    {
        $products = [];

        foreach ($request->cart as $key => $value) {
            $products[] = Product::where('id', $value)->get();
        }

        $products = collect($products)->collapse();

        $products->map(function ($field) {
            $field['count'] = 1;
        });

        return $products;
    }
}
