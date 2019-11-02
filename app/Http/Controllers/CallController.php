<?php

namespace App\Http\Controllers;

use App\Call;
use Illuminate\Http\Request;

class CallController extends Controller
{
    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $call = new Call();

        $call->name = $request->input('name');
        $call->phone = $request->input('phone');
        $call->noted = $request->input('noted');
        $call->save();
    }
}
