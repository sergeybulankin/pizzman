@extends('layout.index')

    @section('yandex')
        @include('components.yandex')
    @endsection()

    @section('search')
        @include('components.search')
    @endsection()

    @section('call')
        @include('components.call')
    @endsection()

    @section('modile-block')
        @include('components.modile-block')
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

    @section('delivery')
        @include('components.delivery')
    @endsection()

    @section('dadata')
        @include('components.dadata')
    @endsection()

    @section('footer')
        @include('components.footer')
    @endsection()