<div class="content">
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