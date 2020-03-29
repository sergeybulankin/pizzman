<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Пиццман&Калачев</title>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href={{ asset('css/app.css') }} type="text/css" rel="stylesheet">
    <link href={{ asset('css/style.css') }} type="text/css" rel="stylesheet">

    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}',
            user: '{{ (Auth::user()) ? 1 : 0 }}'
        };
    </script>
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src={{ asset('js/library.js') }} type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    @yield('yandex')

    @yield('calendar')
</head>
<body>

<div id="app">

@yield('mobile-block')

@yield('search')

@yield('call')

@yield('favorite-auth')

@yield('fixed-navbar')

<!-- Header 1 уровень Серый - Красный -->
@yield('grey-navbar')

<!--Header 2 уровень -->
@yield('shortcut-navbar')

<!--Header 3 уровень -->
@yield('category-navbar')

<!--видеоролик-->
@yield('video-block')

<!--меню -->
@yield('catalog')

@yield('cart-details')

@yield('delivery')

@yield('new-food')

@yield('addresses')

@yield('about')

@yield('reviews')

@yield('hits')

@yield('footer')

@yield('mobile-cart')

</div>

@yield('dadata')

@yield('delivery-scripts')

<script src={{ asset('js/app.js') }} type="text/javascript"></script>

@yield('calendar-script')

</body>
</html>
