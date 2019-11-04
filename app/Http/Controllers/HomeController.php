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
        return view('account');
    }
}
