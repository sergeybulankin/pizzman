<?php

namespace App\Http\Controllers;

use App\Account;
use App\FoodInOrder;
use App\Order;
use App\PizzmanAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * @param $u_id
     * @return mixed
     */
    public function show($u_id)
    {
        $order = Order::where('u_id', $u_id)->first();

        $typeDelivery = $order->type_of_delivery;

        $cart = FoodInOrder::with('food_additive', 'pizzman_address')
            ->where('order_id', $order['id'])
            ->get();


        // если точек доставки у товара вовсе нет
        // то добавляем точку, которую выберем по умолчанию - например 1
        $pointPizzmanAddress = [];
        foreach ($cart as $key => $value) {
            if (collect($value->pizzman_address)->isEmpty()) {
                $pointPizzmanAddress[] = 1;
            }else {
                foreach ($value->pizzman_address as $k => $v) {
                    $pointPizzmanAddress[] = $v->pizzman_address_id;
                }
            }
        }

        $point = array_values((array_unique($pointPizzmanAddress)))[0];

        $pointDelivery = PizzmanAddress::with('pizzman_address_food', 'address_delivery')->where('address_id', $point)->first();

        $pointDeliveryMap = PizzmanAddress::with('address_delivery')->where('id', $order->pizzman_address_id)->first();

        $totalPrice = 0;

        $totalWeight = 0;

        if ($typeDelivery == 2) {
            $courierPrice = 65;
        }else {
            $courierPrice = 0;
        }


        $productsCount = count($cart);

        $account = Auth::check() ? Account::select('name')->where('user_id', Auth::user()->id)->first() : '';

        foreach ($cart as $key => $value){
            $totalPrice = $totalPrice + ($value->food_additive[0]->food[0]->price * $value->count + $value->food_additive[0]->additive[0]->price * $value->count);
            $totalWeight = $totalWeight + $value->food_additive[0]->food[0]->weight;
        }

        return view('delivery',
            compact('cart', 'totalPrice', 'totalWeight', 'courierPrice', 'productsCount', 'pointDelivery', 'account', 'addresses', 'pointDeliveryMap', 'typeDelivery'));
    }
}
