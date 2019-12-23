<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @return mixed
     */
    public function show()
    {
        return view('cart');
    }
}
