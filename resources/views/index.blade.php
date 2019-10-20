<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Главная</title>

        <script>
            window.Laravel = { csrfToken: '{{ csrf_token() }}' };
        </script>
    </head>
    <body>
        <div class="content">
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/cart">Корзина</a></li>
                <li><a href="/delivery">Доставка</a></li>
            </ul>



            <div id="app">
                <div style="margin-bottom: 50px;">
                    <cart></cart>
                </div>

                <div>
                    <h1>Пиццы</h1>
                    <products></products>
                </div>
            </div>
        </div>


    <script src="js/app.js" type="text/javascript"></script>
    </body>
</html>
