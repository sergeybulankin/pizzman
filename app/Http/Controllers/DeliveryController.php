<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * @param Request $request
     */
    public function storeCartInOrder(Request $request)
    {
        $cart = $request->order;

        foreach ($cart as $product) {
            $order = new Order();
            $order->cart_id = $product['id'];
            $order->count = $product['count'];
            $order->u_id = $request->u_id;

            if($order->save()) {
                new Order();
            }
        }
    }


    /**
     * @param $u_id
     * @param Order $order
     * @return mixed
     */
    public function show($u_id, Order $order)
    {
        $cart = $order->with('product')->where('u_id', $u_id)->get();

        $totalPrice = 0;

        $courierPrice = 65;

        $productsCount = count($cart);

        foreach ($cart as $key => $value){
            $totalPrice = $totalPrice + ($value->product->price * $value->count);
        }

        return view('delivery', compact('cart', 'totalPrice', 'courierPrice', 'productsCount'));
    }
}
