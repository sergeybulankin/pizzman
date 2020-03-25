<?php

namespace App\Http\Controllers;

use App\Http\Resources\PizzmanAddressResource;
use App\PizzmanAddress;
use Illuminate\Http\Request;

class PizzmanAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = PizzmanAddress::with('address_delivery')->get();

        return PizzmanAddressResource::collection($points);
    }

    public function info(Request $request)
    {
        $points = PizzmanAddress::with('address_delivery')
            ->where('id', $request->point)
            ->get();

        return PizzmanAddressResource::collection($points);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PizzmanAddress  $pizzmanAddress
     * @return \Illuminate\Http\Response
     */
    public function show(PizzmanAddress $pizzmanAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PizzmanAddress  $pizzmanAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(PizzmanAddress $pizzmanAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PizzmanAddress  $pizzmanAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PizzmanAddress $pizzmanAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PizzmanAddress  $pizzmanAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(PizzmanAddress $pizzmanAddress)
    {
        //
    }
}
