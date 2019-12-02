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
        $cart = FoodCart::select('food_id', 'additive_id', 'u_id', 'count')->where('user_id', Auth::user()->id)->get();

        $foods = [];

        $uIds = [];

        $countIds = [];

        foreach ($cart as $key => $value) {
            $foods[] = FoodAdditive::with('food', 'additive')
                ->where('food_id', $value['food_id'])
                ->where('additive_id', $value['additive_id'])
                ->get();
            $uIds[] = $value['u_id'];
            $countIds[] = $value['count'];
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
                $preparedFoods[$key]['additive'][$k] = $v->additive;
                $preparedFoods[$key]['food']['count'] = $v->count;
            }
        }

        return $preparedFoods;
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
                $preparedFoods[$key]['additive'][$k] = $v->additive;
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
        $food = $request->food['food'];

        $additive = $request->food['additive'];

        $u_id = $request->food['u_id'];

        $foodInCart = FoodCart::where('food_id', $food)->get();

        $foodInCart = collect($foodInCart);

        if ($foodInCart->isEmpty()) {
            foreach ($additive as $key => $value) {
                $food_cart = new FoodCart();
                $food_cart->user_id = Auth::user()->id;
                $food_cart->food_id = $food;
                $food_cart->additive_id = $value;
                $food_cart->u_id = $u_id;
                $food_cart->count = 1;

                $food_cart->save();
            }            
        }else {
            $additiveFood = [];

            foreach ($foodInCart as $key => $value) {
                $additiveFood[] = $value['additive_id'];
            }

            $difference = count($additive) < count($additiveFood)
                ? collect($additiveFood)->diffKeys($additive)
                : collect($additive)->diffKeys($additiveFood);

            $difference = collect($difference);

            if ($difference->isEmpty()) {
                foreach ($foodInCart as $key => $value) {
                    $foodInCart[$key]->count = $foodInCart[$key]->count + 1;
                    $foodInCart[$key]->save();
                }
            }else {
                // TODO доделать
                foreach ($difference as $key => $value) {
                    $value != 1 ? $difference[] = 1 : $value;
                }

                $differenceAdditive = collect($additiveFood)->diffKeys($difference);

                foreach ($difference as $key => $value) {
                    $food_cart = new FoodCart();
                    $food_cart->user_id = Auth::user()->id;
                    $food_cart->food_id = $food;
                    $food_cart->additive_id = $value;
                    $food_cart->u_id = $u_id;
                    $food_cart->count = 1;

                    $food_cart->save();
                }
            }
        }
    }

    /**
     * @param Request $request
     */
    public function deleteFromCart(Request $request)
    {
        FoodCart::where('u_id', $request->id)->where('user_id', Auth::user()->id)->delete();
    }
    
}
