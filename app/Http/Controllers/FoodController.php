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

        //$foods = collect($foods)->collapse();
        return $this->formattedCartForUser($foods, $uIds, $countIds);
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

        //$foods = collect($foods)->collapse();
        return $this->formattedCartForUser($foods, $uIds, $countIds);
    }


    /**
     * Форматируем корзину для отдачи клиенту
     *
     * @param $foods
     * @param $uIds
     * @param $countIds
     * @return array
     */
    public function formattedCartForUser($foods, $uIds, $countIds)
    {
        $foods = collect($foods);

        foreach ($foods as $k => $v){
            $foods[$k]['u_id'] = $uIds[$k];
            $foods[$k]['count'] = $countIds[$k];
        }

        $foods = $foods->groupBy('u_id');

        $preparedFoods = [];

        foreach ($foods as $key => $value) {
            foreach ($value as $k => $v) {
                $preparedFoods[$key]['food'] = $v[0]->food[0];
                $preparedFoods[$key]['additive'][$k] = $v[0]->additive;
                $preparedFoods[$key]['food']['count'] = $value[0]['count'];
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
        // смело добавляем его в таблицу с добавками, которые отметил пользователь
        if ($foodInCart->isEmpty()) {
            $this->storeNewFoodAndAdditive($food, $additive, $u_id);
        }else {
            // если же такой товар есть в таблице
            // то забираем все данные с этим товаром и добавками, которые были отмечены
            // и записываем их в массив
            $foodWithAdditive = $this->selectAllDataFromTable($food, $additive);

            // если коллекция равна еденице и выбранные добавки также равны еденице
            // то значит выбран только стандарт
            // поэтому добавляем только его отдельно или прибавляем еденицу к товару
            if ($foodWithAdditive->count() == 1 && collect($additive)->count() == 1) {
                $this->storeCountStandartFood($foodWithAdditive, $food, $u_id);
            }else {
                // если коллекция не равна еденице
                // то значит такой товар уже есть в корзине
                // для того чтобы его найти мы сравниваем добавки выбранные пользователем
                // и добавки из таблицы
                // находим совпадение - и добавляем count++
                $collectionWithFood = $this->differenceAdditives($foodInCart, $additive);

                // если коллекция пустая, то значит товара с такой добавкой нет
                // добавляем эту позицию в таблицу
                if (collect($collectionWithFood)->isEmpty()) {
                    $this->storeNewFoodAndAdditive($food, $additive, $u_id);
                }

                // если нашли товар с добавкой, то прибавляем еденицу
                foreach ($collectionWithFood as $key => $value) {
                    $value->count = $value['count'] + 1;
                    $value->save();
                }
            }
        }
    }


    /**
     * Добавление нового товара с добавками
     *
     * @param $food
     * @param $additive
     * @param $u_id
     */
    public function storeNewFoodAndAdditive($food, $additive, $u_id)
    {
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


    /**
     * Забираем все данные по товару из таблицы
     *
     * @param $food
     * @param $additive
     * @return static
     */
    public function selectAllDataFromTable($food, $additive)
    {
        $foodWithAdditive = [];
        foreach ($additive as $key => $value) {
            $foodWithAdditive[] = FoodCart::where('food_id', $food)
                ->where('additive_id', $value)
                ->get();
        }

        return $foodWithAdditive = collect($foodWithAdditive)->collapse();
    }


    /**
     * Увеличиваем количество еды на еденицу
     *
     * @param $foodWithAdditive
     * @param $food
     * @param $u_id
     */
    public function storeCountStandartFood($foodWithAdditive, $food, $u_id)
    {
        $food_cart = $foodWithAdditive[0]['additive_id'] == 1 ? $foodWithAdditive[0] : new FoodCart();

        $food_cart->user_id = Auth::user()->id;
        $food_cart->food_id = $food;
        $food_cart->additive_id = 1;
        $food_cart->u_id = $u_id;
        $food_cart->count = $food_cart->count + 1;

        $food_cart->save();
    }


    /**
     * Сравниваем добавки блюд с добавками блюд из таблицы
     *
     * @param $foodInCart
     * @param $additive
     * @return static
     */
    public function differenceAdditives($foodInCart, $additive)
    {
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

        return $result = FoodCart::all()->where('u_id', $uId);
    }


    /**
     * @param Request $request
     */
    public function deleteFromCart(Request $request)
    {
        FoodCart::where('u_id', $request->id)->where('user_id', Auth::user()->id)->delete();
    }
    
}
