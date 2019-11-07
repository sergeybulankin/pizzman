<!-- МЕНЮ при прокрутке НАЧАЛО-->
<div class="navbar navbar-expand-lg header_fixed_main header_menu fixed-top d-none">
    <div class="navbar-collapse justify-content-md-center ">
        <category-navbar></category-navbar>

        <!--Корзина-->
        <div class="navbar-nav pl-5">
            <div style="position: relative" class="d-flex" onmouseover="get_cart(this)" onmouseout="close_cart(this)">

                <a class="cart d-flex" href="http://laravel.arimle.ru/shopping_basket" >
                    <span class="count">2</span>
                    <i class="fa fa-shopping-cart mr-3" ></i>
                    <div class="amount">1 240<i class="fa fa-rub"></i></div>
                </a>

                <!--Корзина-->
                <div id='cart_info' class="d-none">
                    <ul>
                        <li class="d-flex">
                            <div class="delete_icon">
                                <img src="images/delete_icon.svg"/>
                            </div>

                            <div class="photo-small">
                                <img src="images/demo1-0901996381-1-238x238.jpg"  class="img-fluid">
                            </div>
                            <div class="description">
                                <a><b>Пицца с фаршем</b></a><p><small>1x240<i class="fa fa-rub"></i></small></p>
                            </div>


                        </li>

                        <li class="d-flex">
                            <div class="delete_icon">
                                <img src="images/delete_icon.svg"/>
                            </div>

                            <div class="photo-small">
                                <img src="images/demo1-1050546169-1-238x238.jpg"  class="img-fluid">
                            </div>

                            <div class="description">
                                <a><b>СамыйВкусныйКоктель</b></a><p><small>1x240<i class="fa fa-rub"></i></small></p>
                            </div>
                        </li>
                    </ul>

                    <div class="d-flex justify-content-between subtutorial">
                        <strong>Итого:</strong>
                        <p><b>240<i class="fa fa-rub mr-0"></i></b></p>
                    </div>

                    <div class="d-flex justify-content-around">
                        <a href="http://laravel.arimle.ru/shopping_basket"><button class="btn btn-default">Корзина</button></a>
                        <a href="http://laravel.arimle.ru/checkout"><button class="btn btn-success">Оформить заказ</button></a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
<!-- МЕНЮ при прокрутке КОНЕЦ-->