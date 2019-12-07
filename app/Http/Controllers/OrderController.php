<?php

namespace App\Http\Controllers;

use App\Account;
use App\Address;
use App\FoodAdditive;
use App\FoodInOrder;
use App\Order;
use App\OrderStatus;
use App\User;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nutnet\LaravelSms\SmsSender;

class OrderController extends Controller
{
    /**
     * Отправляем смс-код на номер телефона указанный в инпуте
     * Если все хорошо, то записываем смс-код в куки
     *
     * @param SmsSender $smsSender  класс использования пакетом
     * @param Request $request  получаем значение инпута
     */
    public function sendSms(SmsSender $smsSender, Request $request)
    {
        $number = rand(1111, 9999);

        session(['key_sms' => $number]);

        $smsSender->send($request->phone, $number);
    }

    /**
     * Проверяем правильность введеного смс-кода
     * Если код равен куки, то идем в метод store
     * Если ошибка, то показываем её
     * 
     * @param Request $request
     * @return bool
     */
    public function checkSms(Request $request)
    {
        $session_sms = session('key_sms');

        $phone = $request->phone;

        $sms = (int)$request->sms;

        if ($session_sms == $sms) {
            $this->store($phone, $request->sms);
        } else {
            return false;
        }
    }

    /**
     * Добавляем (или обновляем) пользователя
     *
     * @param $phone
     * @param $sms
     */
    public function store($phone, $sms)
    {
        $user = User::where('name', $phone)->first();

        if (empty($user)) {
            $user = new User();
        }

        $user->name = $phone;
        $user->password = bcrypt($sms);
        $user->email = 'admin@admin.com';
        $user->api_token = str_random(60);
        $user->remember_token = str_random(100);
        $user->save();

        $user_id = $user->id;

        $account = new Account();
        $account->user_id = $user_id;
        $account->save();

        $user_role = new UserRole();
        $user_role->user_id = $user_id;
        $user_role->role_id = 1;
        $user_role->save();

        Auth::loginUsingId($user_id);
    }


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
        $u_id = $request->u_id;

        $order = new Order();
        if (Auth::check()) {
            $order->user_id = Auth::user()->id;
        } else {
            $order->user_id = 0;
        }

        $order->type_of_time_id = 0;
        $order->address_id = 0;
        $order->pizzman_address_id = 0;
        $order->type_of_delivery = 0;
        $order->date = Carbon::now();
        $order->note = '';
        $order->u_id = $u_id;

        if ($order->save()) {
            $lastId = $order->id;
        }

        foreach ($cart as $product) {
            foreach ($product['additive'][0] as $additive) {
                $foodAdditive = FoodAdditive::select('id')->where('food_id', $product['food']['id'])->where('additive_id', $additive['id'])->first();

                $foodInOrder = new FoodInOrder();
                $foodInOrder->order_id = $lastId;
                $foodInOrder->food_id = $foodAdditive['id'];
                $foodInOrder->count = $product['food']['count'];
                $foodInOrder->save();
            }
        }

        $orderStatus = new OrderStatus();
        $orderStatus->order_id = $lastId;
        $orderStatus->status_id = 1;
        $orderStatus->save();
    }


    /**
     * Подтверждение заказа
     * 
     * @param Request $request
     */
    public function confirmOrder(Request $request)
    {
        $u_id = $request->u_id;

        $cooking_time = $request->cookingTime;

        $delivery = $request->delivery;

        $pizzman_address = $request->pizzmanAddress;

        $address = $request->address;

        $kv = $request->kv;

        $select_address = Address::where('address', $address)->first();

        if (empty($select_address)) {
            $new_address = new Address();
            $new_address->address = $address;
            $new_address->kv = $kv;
            $new_address->coordinates = 0.00;

            $new_address->save();
            $address_id = $new_address->id;
        }else {
            $address_id = $select_address->id;
        }

        $order = Order::where('u_id', $u_id)->firstOrFail();
        $order->type_of_time_id = $cooking_time;
        $order->pizzman_address_id = $pizzman_address;
        $order->type_of_delivery = $delivery;
        $order->address_id = $address_id;

        $order->save();

        $status = OrderStatus::where('order_id', $order->id)->firstOrFail();
        $status->status_id = 2;

        $status->save();
    }
}
