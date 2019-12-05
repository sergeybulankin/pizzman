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
     * @param Request $request
     */
    public function storeFromLocalStorage(Request $request)
    {
        $food = $request->food['food'];

        $additive = $request->food['additive'];

        $u_id = $request->food['u_id'];

        // забираем данные из таблицы с добавленными товарами
        $foodInCart = collect(FoodCart::where('food_id', $food)->get());

        // если коллекция пустая, то значит такой товар не добавляли
        // смело доавляем его в таблицу с добавками, которые отметил пользователь
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
            // если же такой товар есть в таблице
            // то забираем все данные с этим товаром и добавками, которые были отмечены
            // и записываем их в массив
            $foodWithAdditive = [];
            foreach ($additive as $key => $value) {
                $foodWithAdditive[] = FoodCart::where('food_id', $food)
                    ->where('additive_id', $value)
                    ->get();
            }

            $foodWithAdditive = collect($foodWithAdditive)->collapse();

            // если коллекция равна еденице и выбранные добавки также равны еденице
            // то значит выбран только стандарт
            // поэтому добавляем только его отдельно или прибавляем еденицу к товару
            if ($foodWithAdditive->count() == 1 && collect($additive)->count() == 1) {
                $food_cart = $foodWithAdditive[0]['additive_id'] == 1 ? $foodWithAdditive[0] : new FoodCart();

                $food_cart->user_id = Auth::user()->id;
                $food_cart->food_id = $food;
                $food_cart->additive_id = 1;
                $food_cart->u_id = $u_id;
                $food_cart->count = $food_cart->count + 1;

                $food_cart->save();
            }else {
                // если коллекция не равна еденице
                // то значит такой товар уже есть в корзине
                // для того чтобы его найти мы сравниваем добавки выбранные пользователем
                // и добавки из таблицы
                // находим совпадение - и добавляем count++
                $groupCartById = [];
                foreach ($foodInCart as $key => $value) {
                    $groupCartById[$value['u_id']][] = $value['additive_id'];
                }

                $uId = '';
                foreach ($groupCartById as $key => $value) {
                    if (count($additive) == count($value)) {
                        $uId = empty(array_diff($additive, $value)) ? $key : 'LOL';
                    }
                }

                $result = FoodCart::all()->where('u_id', $uId);

                // ессли коллекция пустая, то значит товара с такой добавкой нет
                // добавляем эту позицию в таблицу
                if (collect($result)->isEmpty()) {
                    foreach ($additive as $key => $value) {
                        $food_cart = new FoodCart();
                        $food_cart->user_id = Auth::user()->id;
                        $food_cart->food_id = $food;
                        $food_cart->additive_id = $value;
                        $food_cart->u_id = $u_id;
                        $food_cart->count = 1;

                        $food_cart->save();
                    }
                }

                // если нашли товар с добавкой, то прибавляем еденицу
                foreach ($result as $key => $value) {
                    $value->count = $value['count'] + 1;
                    $value->save();
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
