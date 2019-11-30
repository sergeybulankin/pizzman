<?php

namespace App\Http\Controllers;

use App\FoodInOrder;
use App\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * @param $u_id
     * @return mixed
     */
    public function show($u_id)
    {
        $order = Order::where('u_id', $u_id)->get();

        $cart = FoodInOrder::with('food_additive')
            ->where('order_id', $order[0]['id'])
            ->get();

        $totalPrice = 0;

        $totalWeight = 0;

        $courierPrice = 65;

        $productsCount = count($cart);

        foreach ($cart as $key => $value){
            $totalPrice = $totalPrice + ($value->food_additive[0]->food[0]->price * $value->count + $value->food_additive[0]->additive[0]->price * $value->count);
            $totalWeight = $totalWeight + $value->food_additive[0]->food[0]->weight;
        }

        return view('delivery', compact('cart', 'totalPrice', 'totalWeight', 'courierPrice', 'productsCount'));
    }
}
