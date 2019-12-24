@extends('layout.index')

@section('search')
    @include('components.search')
@endsection()

@section('call')
    @include('components.call')
@endsection()

@section('mobile-block')
    @include('components.mobile-block')
@endsection()

@section('fixed-navbar')
    @include('components.fixed-navbar')
@endsection()

@section('grey-navbar')
    @include('components.grey-navbar')
@endsection()

@section('shortcut-navbar')
    @include('components.shortcut-navbar')
@endsection()

@section('category-navbar')
    @include('components.category-navbar')
@endsection()

@section('cart-details')
    @include('components.account')
@endsection()

@section('footer')
    @include('components.footer')
@endsection()