<?php

namespace App\Http\Controllers;

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


    public function show()
    {
        return view('index');
    }


    public function account()
    {
        return view('account');
    }
}
