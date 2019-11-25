<?php

namespace App\Http\Controllers;

use App\Category;
use App\FoodAdditive;
use App\FoodCart;
use App\Http\Resources\FoodResource;
use App\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Формируем корзину для пользователя, который зашел авторизованным
     * Забираем всю информацию из БД, создаем массив требуемый для localStorage и возвращаем 
     * 
     * @return array
     */
    public function cartForUser()
    {
        $cart = FoodCart::select('food_additive_id')->where('user_id', Auth::user()->id)->get();

        $food_additives = [];

        foreach ($cart as $key => $value) {
            $food_additive = FoodAdditive::select('food_id', 'additive_id')->where('id', $value->food_additive_id)->first();
            $food_additives[$key]['id'] = $food_additive->food_id;
            $food_additives[$key]['additive_id'] = $food_additive->additive_id;
        }

        return $food_additives;
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

        $uIds = [];

        $countIds = [];

        foreach ($request->cart as $key => $value) {
            foreach ($value['additive_id']['additiveFood'] as $k => $v) {
                $foods[] = FoodAdditive::with('food', 'additive')
                    ->where('food_id', $value['id'])
                    ->where('additive_id', $v)
                    ->get();
                $uIds[] = $value['u_id'];
                $countIds[] = $value['count'];
            }
        }

        $foods = collect($foods)->collapse();

        foreach ($foods as $k => $v){
            $foods[$k]['u_id'] = $uIds[$k];
            $foods[$k]['count'] = $countIds[$k];
        }

        $foods = $foods->groupBy('u_id');

        $preparedFoods = [];

        foreach ($foods as $key => $value) {
            foreach ($value as $k => $v) {
                $preparedFoods[$key]['food'] = $v->food[0];
                $preparedFoods[$key][$k]['additive'] = $v->additive;
                $preparedFoods[$key]['food']['count'] = $v->count;
            }
        }

        return $preparedFoods;
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


    /**
     * Добавляем в таблицу БД корзину авторизованного пользователя
     * 
     * Делаем да массива - с товарами из корзины и из БД авторизованного пользователя
     * Если есть разница в массивах, то добавляем данные в таблицу 
     * 
     * @param Request $request
     */
    public function storeFromLocalStorage(Request $request)
    {
        $cart = $request->cart;

        $cart_food_db = FoodCart::select('food_additive_id')->where('user_id', Auth::user()->id)->get();

        $cart_additive = [];

        foreach ($cart as $key => $value) {
            $cart_additive[] = FoodAdditive::select('id')->where('food_id', $value['id'])->where('additive_id', $value['additive_id'])->first();
        }

        $differenсe = collect($cart_additive)->diffKeys($cart_food_db);

        foreach ($differenсe as $key => $value) {
            $food_cart = new FoodCart();
            $food_cart->user_id = Auth::user()->id;
            $food_cart->food_additive_id = $value->id;
            $food_cart->save();
        }
    }
    
}
