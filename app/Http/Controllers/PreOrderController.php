<?php

namespace App\Http\Controllers;

use App\Order;
use App\PreOrder;
use Illuminate\Http\Request;

class PreOrderController extends Controller
{
    /**
     * Добавляем данные из корзины в таблицу заказов
     * Если все добавилось удачно, то перенаправим на страницу заказа
     * с уникальным номером в виде даты/времени добавления (см. vue-компонент)
     *
     * @param Request $request
     */
    public function storeCartInOrder(Request $request)
    {
        $cart = $request->order;

        foreach ($cart as $product) {
            $order = new PreOrder();
            $order->food_additive_id = $product['id'];
            $order->count = $product['count'];
            $order->u_id = $request->u_id;
            $order->status = false;

            if($order->save()) {
                new Order();
            }
        }
    }


    /**
     * Показываем форму с добавленным заказом
     *
     * @param $u_id
     * @param PreOrder $order
     * @return mixed
     */
    public function show($u_id, PreOrder $order)
    {
        $cart = $order->with('food', 'additive')->where('u_id', $u_id)->get();

        $totalPrice = 0;

        $totalWeight = 0;

        $courierPrice = 65;

        $productsCount = count($cart);

        foreach ($cart as $key => $value){
            $totalPrice = $totalPrice + ($value->food[0]->price * $value->count + $value->additive[0]->price * $value->count);
            $totalWeight = $totalWeight + $value->food[0]->weight;
        }

        return view('delivery', compact('cart', 'totalPrice', 'totalWeight', 'courierPrice', 'productsCount'));
    }
}
