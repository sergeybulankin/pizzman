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

function sign_up()
{
    $("#phone_form").addClass("d-none");
    $("#password_form").removeClass("d-none");
}

function confirm()
{
    $("#password_form").addClass("d-none");
    $(".alert.alert-success").removeClass("d-none");
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
}

function send_an_order(el)
{
    $(el).remove();
    $("#sms").removeClass("d-none");
}

function confirm(el)
{
    $(el).remove();
    $("#sms").remove();
    $("#answer").removeClass("d-none");
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