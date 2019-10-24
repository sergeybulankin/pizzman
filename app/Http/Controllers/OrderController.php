<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        dd($request->all());
    }


    public function treatment(Request $request)
    {
        dd($request->all());
    }
}
