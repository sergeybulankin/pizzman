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
    public function catalog()
    {
        $products = Product::all();

        return ProductResource::collection($products);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $products = Product::all()->where('category_id', 1);

        return ProductResource::collection($products);
    }

    /**
     * Выбираем всю информацию о товаре из таблицы исходя из localStorage
     *
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


    /**
     * Выборка товаров по категории
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function selectByCategory(Request $request)
    {
        $products = Product::with('category')->where('category_id', $request->id)->get();

        return ProductResource::collection($products);
    }
}
