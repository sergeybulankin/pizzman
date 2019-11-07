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

function sign_up(phone)
{
    var validate = sendSms(phone);

    if(validate != null) {
        $.get("/sms", {phone: phone});

        $("#phone_form").addClass("d-none");
        $("#password_form").removeClass("d-none");
        $("#repeatSms").css("display", "none");
    }
    else {
        $("#repeatPhone").css("display", "block");
    }

}

function confirmCode(code)
{
    $("#password_form").addClass("d-none");
    $(".alert.alert-success").removeClass("d-none");
    var x = get_cookie("key_sms");
    //$.get('/checkSms', {sms: code});
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

function delivery_type(el, type)
{
    update_active(el);

    $("#pickup,#courier").addClass("d-none");
    $("#"+type).removeClass("d-none");


    //TODO исправить этот колхоз
    var priceCurier = 65;
    if (type != 'courier') {
        var newPriceTotal = document.getElementById('totalPrice').textContent - priceCurier;
        document.getElementById('totalPrice').innerHTML = newPriceTotal;
    } else {
        var newPriceTotal = document.getElementById('totalPrice').textContent + priceCurier;
        document.getElementById('totalPrice').innerHTML = newPriceTotal;
    }
}

function send_an_order(el, phone) {
    var validate = sendSms(phone);

    if(validate != null) {
        $.get("/sms", {phone: phone});

        $(el).remove();
        $("#sms").removeClass("d-none");
        $("#repeatSms").remove();
    }
    else {
        //TODO косяк с удадением и отпрвкой формы
        $(el).remove();
        $("#repeatSms").css("display", "block");
    }
}


// проверяем правильность номера телефона
// если все хорошо - отправляем смс-код
function sendSms(phone) {
    const regex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

    return phone.match(regex);
}


function confirm(el, sms)
{
    $(el).remove();
    $("#sms").remove();
    $("#repeatSms").remove();
    $("#answer").removeClass("d-none");

    $.get('/checkSms', {sms: sms});
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
    console.log(123);
}





function get_cookie(cookie_name)
{
    var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );

    if ( results )
        return ( unescape ( results[2] ) );
    else
        return null;
}