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

// подтверждаем заказ и оформляем его
function send_order(el, phone) {
    var cookingTime = $('.active.cooking-time').attr('id');

    var delivery = $('#typeDelivery')[0].value;

    if (delivery == 2) {
        var address = $('#suggest')[0].value;
        var kv = $('#kv')[0].value;
        var coord = $('#coord')[0].value;
    }else {
        var address = null;
        var kv = null;
        var coord = null;
    }

    var url = document.location.href;
    var u_id = url.substring(url.lastIndexOf('/') + 1);
    var date = $('#time')[0].value;
    var validate = sendSms(phone);

    if(validate == 17) {
        $.ajax({
            url: "/confirmOrder",
            method: "GET",
            data: {
                'phone': phone,
                'cookingTime': cookingTime,
                'delivery': delivery,
                'address': address,
                'kv': kv,
                'u_id': u_id,
                'date': date,
                'coord': coord
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

        $(el).remove();
        $("#sms").removeClass("d-none");
        $("#repeatSms").remove();
    }
    else {
        $("#repeatSms").css("display", "block");
    }
}
// ----- DELIVERY ----- //