<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Delivery</title>

    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    </script>

    <!-- ПОДКЛЮЧАЕМ API YANDEX MAP -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=38ec5068-da01-4278-9dab-69c6ccfa0954" type="text/javascript"></script>
    <script src="js/search.js" type="text/javascript"></script>
    <script src="js/custom_view.js" type="text/javascript"></script>

    <style>
        html, body {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            font-size: 13px;
            font-family: sans-serif;
        //overflow: hidden;
        }

        #messageHeader {
            height: 20px;
        }

        #footer {
            width: 376px;
            background-color: #f2f2ef;
            padding: 12px;
        }

        #message {
            height: 76px;
        }

        #map {
            height: 460px;
            width: 676px;
            margin: 0px 12px 18px 12px;
            position: relative;
        }

        #header {
            height: 28px;
            width: 376px;
            margin: 12px 10px 12px 12px;
        }

        #button {
            display: inline-block;
            font-size: 11px;
            color: rgb(68,68,68);
            text-decoration: none;
            user-select: none;
            padding: .2em 0.6em;
            outline: none;
            border: 1px solid rgba(0,0,0,.1);
            border-radius: 2px;
            background: rgb(245,245,245) linear-gradient(#f4f4f4, #f1f1f1);
            transition: all .218s ease 0s;
            height: 28px;
            width: 74px;
        }

        #button:hover {
            color: rgb(24,24,24);
            border: 1px solid rgb(198,198,198);
            background: #f7f7f7 linear-gradient(#f7f7f7, #f1f1f1);
            box-shadow: 0 1px 2px rgba(0,0,0,.1);
        }

        #button:active {
            color: rgb(51,51,51);
            border: 1px solid rgb(204,204,204);
            background: rgb(238,238,238) linear-gradient(rgb(238,238,238), rgb(224,224,224));
            box-shadow: 0 1px 2px rgba(0,0,0,.1) inset;
        }

        .input {
            height: 18px;
            margin-right: 10px;
            width: 277px;
            padding: 4px;
            border: 1px solid #999;
            border-radius: 3px;
            box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0);
            transition: .17s linear;
        }

        .input:focus {
            outline: none;
            border: 1px solid #fdd734;
            box-shadow: 0 0 1px 1px #fdd734;
        }

        .input_error, .input_error:focus {
            outline: none;
            border: 1px solid #f33;
            box-shadow: 0 0 1px 1px #f33;
        }

        #notice {
            position: absolute;
            left: 22px;
            margin: 0px;
            top: 44px;
            color: #f33;
            display: none;
        }
        #viewContainer {
            margin: 8px;
        }

        input {
            font-size: 16px;
            padding: 4px;
            margin: 10px 0;
        }
        #address {
            width: 350px;
        }
        #switcher a {
            text-decoration: none;
            border-bottom: 1px dotted blue;
        }
        #switcher a:hover {
            border-bottom: none;
        }
        #switcher li {
            line-height: 1.5
        }
    </style>
</head>
<body>

<div class="content">
    <input id="address" name="address" type="text" placeholder="Введите адрес" />
    <div id="header">
        <input type="text" id="suggest" name="hidden_address" class="input" placeholder="Введите адрес">
        <button type="submit" id="button">Проверить</button>
    </div>
    <p id="notice">Адрес не найден</p>
    <div id="map"></div>
    <div id="footer">
        <div id="messageHeader"></div>
        <div id="message"></div>
    </div>
    <div id="viewContainer"></div>
    <div id="time"></div>
</div>


<!-- ПОДКЛЮЧАЕМ API DADATA -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.8.0/dist/css/suggestions.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.8.0/dist/js/jquery.suggestions.min.js"></script>

<script>
    // API-ключ
    var TOKEN = "7e48cb87bd4db22f24dbee66e2b5add3cb8ab89a";

    function str() {
        $("#address").suggestions({
            token: TOKEN,
            type: "ADDRESS",
            constraints: {
                label: "",
                locations: {
                    kladr_id: "0200001400000"
                }
            },
            // в списке подсказок не показываем область и город
            restrict_value: true
        });

        var $address = $('#address'),
            $hidden_address = $('#suggest');

        $address.on('input', function () {
            $hidden_address.val($address.val());
        });
    }

    str();
</script>

</body>
</html>
