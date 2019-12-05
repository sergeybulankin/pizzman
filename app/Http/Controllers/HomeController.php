<?php

namespace App\Http\Controllers;

use App\FoodInOrder;
use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function auth()
    {
        return view('auth.login');
    }


    /**
     * @return mixed
     */
    public function show()
    {
        return view('index');
    }

    /**
     * @return mixed
     */
    public function account()
    {
        $orders = OrderStatus::with('order', 'status')->where('status_id', '>', 1)->get();
            
        return view('account', compact('orders'));
    }

    /**
     * @param $order_id
     * @return mixed
     */
    public function tracking($order_id)
    {
        $order = Order::where('id', $order_id)->first();

        $status = OrderStatus::with('status')->where('order_id', $order['id'])->get();

        $food = FoodInOrder::with('food_additive', 'pizzman_address')->where('order_id', $order['id'])->get();

        return view('tracking', compact('food', 'status'));
    }
}
