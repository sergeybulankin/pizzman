<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    
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


    public function show($u_id, Order $order)
    {
        $cart = $order->all()->where('u_id', '=', $u_id);

        return view('delivery', compact('cart'));
    }
}
