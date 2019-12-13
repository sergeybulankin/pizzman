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
    /*
     $('[data-toggle="popover"]:not(.cart)').popover({'html':true}).on('shown.bs.popover', function(e) {
     var current_popover = '#' + $(e.target).attr('aria-describedby');
     $(current_popover).find(".popover-header").append('<a class="close" href="#" style="margin-left: 15px; margin-top: -2px;">&times;</a>');



     $(current_popover).find('.close').click(function(){
     $(this).parents(".popover").popover('hide');
     });
     });
     */

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


// отправка кода на телефон при правильном вводе номера
function sign_up(phone)
{
    var validate = sendSms(phone);

    if(validate != null) {
        $.ajax({
            url: "/sms",
            method: "GET",
            data: {'phone': phone},
            success: function(){
                $("#phone_form").addClass("d-none");
                $("#password_form").removeClass("d-none");
                $("#repeatPhone").addClass("d-none");
            },
            error: function () {
                $("#sms").remove();
                $("#repeatPhone").removeClass("d-none");
            }
        })
    }
    else {
        console.log('Номер телефона не введен');
        $("#repeatPhone").removeClass("d-none");
    }

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



// отправка заказа
function send_an_order(el, phone) {
    var validate = sendSms(phone);

    if(validate != null) {
        $.get("/sms", {phone: phone});

        $(el).remove();
        $("#sms").removeClass("d-none");
        $("#repeatSms").remove();
    }
    else {
        $("#repeatSms").css("display", "block");
    }
}


// проверяем правильность номера телефона
// если все хорошо - отправляем смс-код
function sendSms(phone) {
    const regex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

    return phone.match(regex);
}


// проверяем введеный код с сессией смс-кода
function confirmCodeSms(el, sms, phone)
{
    $.ajax({
        url: "/checkSms",
        method: "GET",
        data: {'sms': sms, 'phone': phone},
        success: function(){
            $(el).remove();
            $("#registered").removeClass("d-none");
            setTimeout(function(){
                location.href="/account"
            } , 2000);
        },
        error: function () {
            $("#sms").remove();
            $("#repeatSms").removeClass("d-none");
        }
    })
}



function confirmCodeSmsForDeliveryOrder(el)
{
    var phone = $('.phone#phone')[0].value;

    var sms = $('.sms#sms')[0].value;

    $.ajax({
        url: "/checkSms",
        method: "GET",
        data: {
            'sms': sms,
            'phone': phone
        },
        success: function(){
            console.log('OK');
            $(el).remove();
            $(".alert .alert-primary").addClass('d-none');
            $("#answerError").addClass('d-none');
            $("#registered").removeClass("d-none");

            send_order();
        },
        error: function () {
            console.log('ERROR');
            $("#sms").remove();
            $("#answerError").removeClass("d-none");
        }
    })
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

// подтверждаем заказ и оформляем его
function send_order(el) {
    var cookingTime = $('.active.cooking-time').attr('id');

    var delivery = $('.active.delivery').attr('id');

    var address = $('#suggest')[0].value;

    var kv = $('#kv')[0].value;

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
            'date': date
        },
        success: function(){
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

// копирование самого популярного адреса
function offerAddress() {
    var address = $('#offerAddress')[0].innerText;
    $('#address').val(address);
    $('#suggest').val(address);
}


function close_modal(el)
{
    $(el).parents(".modal").modal('hide');
}

// очистка localStorage после выхода из аккаунта
$(document).ready(function(){
    $('#logout').click(function(){
        localStorage.clear();
    });
});
