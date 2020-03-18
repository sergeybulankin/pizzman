$(window).scroll(function(){
    if (pageYOffset>=200)
    {
        $(".header_fixed_main").addClass("d-block");
    }
    else
    {
        $(".header_fixed_main").removeClass("d-block");
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
})

$(document).ready(function () {
    //РџРћРРЎРљ

    $('[data-toggle="popover"]').popover({'html':true});

    $("input[type='number']").inputSpinner();

});

//РїРѕРєР°Р·Р°С‚СЊ СЃРѕРґРµСЂР¶РёРјРѕРµ РєРѕСЂР·РёРЅС‹ РїСЂРё РЅР°РІРµРґРµРЅРёРё РЅР° РёРєРѕРЅРєСѓ
function get_cart(btn)
{
    $(btn).parents("div").find("#cart_info").addClass("d-block");
    $(btn).parents("div").find("#cart_info").removeClass("d-none");
}

//СѓР±СЂР°С‚СЊ СЃРѕРґРµСЂР¶РёРјРѕРµ РєРѕСЂР·РёРЅС‹ РїСЂРё РЅР°РІРµРґРµРЅРёРё РЅР° РёРєРѕРЅРєСѓ
function close_cart(btn)
{
    $(btn).parents("div").find("#cart_info").removeClass("d-block");
    $(btn).parents("div").find("#cart_info").addClass("d-none");
}

function update_active(el)
{
    $(el).parents(".row:eq(0)").find('.btn-success').removeClass("active");
    $(el).addClass("active");
}

function type_of_readiness(el,type)
{
    update_active(el);
    if (type=="by_time")
    {
        $("#time").removeClass("d-none");
    }
    else
    {
        $("#time").addClass("d-none");
    }
}

function update_star(el)
{
    $("#star").children("div").each(function(){
        $(this).removeClass("fa-star");
        $(this).removeClass("fa-star-o");

        if ($(this).index()<=$(el).index())
        {
            $(this).addClass("fa-star");
        }
        else
        {
            $(this).addClass("fa-star-o");
        }
    })
}

function close_modal(el)
{
    $(el).parents(".modal").modal('hide');
}









// ----- DELIVERY ----- //

// возвращаем длину номера телефона
function sendSms(phone) {
    return phone.length;
}

// если с номером все нормально
// то отправляем на этот номер смс
function send_an_order(el, phone) {
    var validate = sendSms(phone);

    if(validate == 17) {
        $.get("/sms", {phone: phone});

        $(el).remove();
        $("#sms").removeClass("d-none");
        $("#repeatSms").remove();
    }
    else {
        $("#repeatSms").css("display", "block");
    }
}

// подтверждение смс у неавторизованного пользователя
function confirmCodeSmsForDeliveryOrder(el)
{
    var phone = $('.tel#phone')[0].value;
    var sms = $('.sms#sms')[0].value;
    var address = $('#suggest')[0].value;
    var delivery = $('.active.delivery').attr('id');

    if (address == '' && delivery == 0) {
        console.log('Не введен адрес доставки');
        $("#addressError").removeClass("d-none");
    }else {
        $.ajax({
            url: "/checkSms",
            method: "GET",
            data: {
                'sms': sms,
                'phone': phone
            },
            success: function(){
                console.log('Заказ оформлен');
                $(el).remove();
                $("#answerError").addClass('d-none');
                $("#addressError").addClass("d-none");
                $("#registered").removeClass("d-none");
                $('#sms').remove();

                send_order();
            },
            error: function () {
                console.log('Ошибка в оформлении заказа');
                $("#checkSms").addClass('d-none');
                $("#answerError").removeClass("d-none");
            }
        })
    }
}

// подтверждаем заказ и оформляем его
function send_order(el) {
    var cookingTime = $('.active.cooking-time').attr('id');
    var delivery = $('.active.delivery').attr('id');
    var address = $('#suggest')[0].value;
    var kv = $('#kv')[0].value;
    var coord = $('#coord')[0].value;
    var note = $('#note')[0].value;
    var url = document.location.href;
    var u_id = url.substring(url.lastIndexOf('/') + 1);
    if (delivery == 1) {
        var pizzmanAddress = $('.active.delivery-pickup').attr('id');
    } else {
        var pizzmanAddress = 0;
    }
    var date = $('#time')[0].value;

    $.ajax({
        url: "/confirmOrder",
        method: "GET",
        data: {
            'cookingTime': cookingTime,
            'delivery': delivery,
            'pizzmanAddress': pizzmanAddress,
            'address': address,
            'kv': kv,
            'u_id': u_id,
            'date': date,
            'coord': coord,
            'note': note
        },
        success: function () {
            localStorage.clear();
            $(el).remove();
            $("#registered").removeClass("d-none");
            $("#answer").removeClass("d-none");
        },
        error: function () {
            $("#sms").remove();
            $("#repeatSms").removeClass("d-none");
        }
    })
}

// изменение доставки и её стоимости
function delivery_type(el, type, totalPrice)
{
    update_active(el);

    $("#pickup,#courier").addClass("d-none");
    $("#"+type).removeClass("d-none");

    var priceCurier = 65;
    if (type != 'courier') {
        document.getElementById('curierPrice').innerHTML = "<p>" + 0 + " <i class='fa fa-rub mr-0'></i></p>";
        document.getElementById('timeDelivery').innerHTML = "";
        document.getElementById('totalPrice').innerHTML = "<p>" + totalPrice + "<i class='fa fa-rub mr-0'></i></p>";
    } else {
        var finalPrice = totalPrice + priceCurier;
        document.getElementById('curierPrice').innerHTML = "<p>" + priceCurier + " <i class='fa fa-rub mr-0'></i></p>";
        document.getElementById('totalPrice').innerHTML = "<p>" + finalPrice + "<i class='fa fa-rub mr-0'></i></p>";
    }
}

// ----- DELIVERY ----- //


// очистка localStorage после выхода из аккаунта
$(document).ready(function(){
    $('#logout').click(function(){
        localStorage.clear();
    });
});















