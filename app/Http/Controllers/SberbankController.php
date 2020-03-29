<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Voronkovich\SberbankAcquiring\Client;
use Voronkovich\SberbankAcquiring\Currency;

class SberbankController extends Controller
{
    public function index()
    {
        $client = new Client(['userName' => 'username', 'password' => 'password']);

        // Required arguments
        $orderId     = 1234;
        $orderAmount = 1000;
        $returnUrl   = 'http://mycoolshop.local/payment-success';

        // You can pass additional parameters like a currency code and etc.
        $params['currency'] = Currency::EUR;
        $params['failUrl']  = 'http://mycoolshop.local/payment-failure';

        $result = $client->registerOrder($orderId, $orderAmount, $returnUrl, $params);

        $paymentOrderId = $result['orderId'];
        $paymentFormUrl = $result['formUrl'];

        header('Location: ' . $paymentFormUrl);
    }
}
