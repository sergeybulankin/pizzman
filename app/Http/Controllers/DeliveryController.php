<?php

namespace App\Http\Controllers;

use App\FoodInOrder;
use App\Order;
use App\PizzmanAddress;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * @param $u_id
     * @return mixed
     */
    public function show($u_id)
    {
        $order = Order::where('u_id', $u_id)->first();

        $cart = FoodInOrder::with('food_additive', 'pizzman_address')
            ->where('order_id', $order['id'])
            ->get();


        $pointPizzmanAddress = [];
        foreach ($cart as $key => $value) {
            foreach ($value->pizzman_address as $k => $v) {
                $pointPizzmanAddress[] = $v->pizzman_address_id;
            }
        }

        $point = array_values((array_unique($pointPizzmanAddress)))[0];

        $pointDelivery = PizzmanAddress::with('pizzman_address_food', 'address_delivery')->where('address_id', $point)->first();

        $totalPrice = 0;

        $totalWeight = 0;

        $courierPrice = 65;

        $productsCount = count($cart);

        foreach ($cart as $key => $value){
            $totalPrice = $totalPrice + ($value->food_additive[0]->food[0]->price * $value->count + $value->food_additive[0]->additive[0]->price * $value->count);
            $totalWeight = $totalWeight + $value->food_additive[0]->food[0]->weight;
        }

        return view('delivery', compact('cart', 'totalPrice', 'totalWeight', 'courierPrice', 'productsCount', 'pointDelivery'));
    }
}
