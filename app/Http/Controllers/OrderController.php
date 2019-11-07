<?php

namespace App\Http\Controllers;

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

        Cookie::queue('key_sms', $number, 999999999);

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
        $cookie_sms = $request->cookie('key_sms');

        $sms = $request->sms;

        if ($cookie_sms === $sms) {
            $this->store();
        } else {
            return false;
        }
    }


    public function store()
    {
        $request = new Request();

        dd($request->all());
    }
}
