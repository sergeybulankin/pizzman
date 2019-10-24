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
    <!------------------------------->

    <style>
        html, body {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            font-size: 13px;
            font-family: sans-serif;
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
            height: 160px;
            width: 376px;
            margin: 0px 12px 18px 12px;
            position: relative;
        }

        .content {
            margin: 20px;
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

        .code {
            display: none;
        }

        .btn {
            width: 250px;
            margin: 20px 0;
            padding: 15px;
            background: black;
            color: white;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="content">
    <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="/cart">Корзина</a></li>
        <li><a href="/delivery">Доставка</a></li>
    </ul>


    <form action="/treatment" method="POST">
        <div class="form">
            <div style="margin-bottom: 50px;">
                <input id="name" name="name" type="text" placeholder="Имя" /> <br />
                <input type="text" name="phone" placeholder="Телефон" />
            </div>

            <div style="margin-top: 50px">
                <input id="address" name="address" type="text" placeholder="Введите адрес" />
                <input id="kv" name="kv" type="text" placeholder="Номер квартиры" /> <br />
                <input type="hidden" id="suggest" name="hidden_address" class="input" placeholder="Введите адрес">
            </div>


            <p id="notice">Адрес не найден</p>
            <div id="map"></div>
            <div id="footer">
                <div id="messageHeader"></div>
                <div id="message"></div>
            </div>
            <div id="viewContainer"></div>
            <div id="time"></div>

            <div class="btn">Отправить</div>
        </div>

        <div class="code">
            <input type="text" id="code" name="code" placeholder="СМС-КОД">
            <input type="SUBMIT" value="Подтвердить">
        </div>
    </form>


</div>


<!-- ПОДКЛЮЧАЕМ API DADATA -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.8.0/dist/css/suggestions.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.8.0/dist/js/jquery.suggestions.min.js"></script>
<!--------------------------->


<script>
    $("input[name='phone']").keyup(function() {
        $(this).val($(this).val().replace(/^(\d{3})(\d{3})(\d)+$/, "($1)$2-$3"));
    });
</script>

<script>
    $('.btn').on('click', () => {
        $('.form').css('display', 'none');
        $('.code').css('display', 'block');
    })
</script>

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
