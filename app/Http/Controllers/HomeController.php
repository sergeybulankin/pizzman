<?php

namespace App\Http\Controllers;

use App\Account;
use App\FoodInOrder;
use App\Order;
use App\OrderStatus;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $orderStatus = OrderStatus::with('status')->where('order_id', $order['id'])->first();

        $statuses = Status::all();

        $food = FoodInOrder::with('food_additive', 'pizzman_address')->where('order_id', $order['id'])->get();

        return view('tracking', compact('food', 'orderStatus', 'statuses'));
    }

    /**
     * @return mixed
     */
    public function showProfile()
    {
        $account = Account::all()->where('user_id', Auth::user()->id)->first();

        return view('profile', compact('account'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateProfile(Request $request)
    {
        $account = Account::where('id', $request->id)->first();

        $account->name= $request->name;
        $account->second_name= $request->second_name;
        $account->link= $request->link;
        $account->save();

        return redirect()->back()->with('success', 'Данные обновились');
    }

    /**
     * @return mixed
     */
    public function history()
    {
        $orders = Order::with('food', 'order_status')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('history', compact('orders'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteOrder(Request $request)
    {
        $food_in_order = FoodInOrder::where('order_id', $request->id)->delete();

        $order_status = OrderStatus::where('order_id', $request->id)->delete();

        $order = Order::select('id')->where('id', $request->id)->delete();

        return redirect()->back()->with('success', 'Заказ удален');
    }
}
