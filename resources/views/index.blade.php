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

    @section('video-block')
        @include('components.video-block')
    @endsection()

    @section('catalog')
        @include('components.catalog')
    @endsection()

    @section('new-food')
        @include('components.new-food')
    @endsection()

    @section('addresses')
        @include('components.addresses')
    @endsection()

    @section('about')
        @include('components.about')
    @endsection()

    @section('reviews')
        @include('components.reviews')
    @endsection()

    @section('hits')
        @include('components.hits')
    @endsection()

    @section('footer')
        @include('components.footer')
    @endsection()