<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Nutnet\LaravelSms\SmsSender;
use Illuminate\Support\Facades\Cookie;

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


    public function store($phone, $sms)
    {
        $user = new User();
        $user->name = $phone;
        $user->password = bcrypt($sms);
        $user->email = 'admin@admin.com';
        $user->api_token = str_random(60);
        $user->remember_token = str_random(100);

        $user->save();
    }
}
