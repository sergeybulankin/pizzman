<div class="container" id="checkout">
    <h1 class="text-center text-uppercase font-weight-bold">Оформление заказа</h1>

    <form method="POST" id="form">
        <div class="row pt-5">
            <div class="col-lg-8">

                <div class="row w-100 ml-0">
                    <div class="col-lg-12">
                        <h2 class=" text-uppercase font-weight-bold">Контактные данные</h2>
                    </div>
                </div>

                <div class="row w-100 ml-0">
                    @if (Auth::check())
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Ваше имя</label>
                            <input type="phone" class="form-control" id="name"  name="name" placeholder="{{ $account->name }}" disabled>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Телефон</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="{{ Auth::user()->name }}" disabled>
                        </div>
                    @else
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Ваше имя</label>
                            <input type="phone" class="form-control" id="name" name="name">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Телефон</label>
                            <input type="text" class="form-control phone" id="phone" name="phone">
                        </div>
                    @endif()
                </div>

                <div class="row w-100 ml-0 pt-5">
                    <div class="col-lg-12">
                        <h2 class=" text-uppercase font-weight-bold">Готовность</h2>
                    </div>
                </div>

                <div class="row w-100 ml-0">
                    <div class="col-lg-6">
                        <button class="btn btn-secondary btn-success btn-block active cooking-time" type="button" id="0" onclick="type_of_readiness(this,'quickly')">срочная</button>
                    </div>

                    <div class="col-lg-6">
                        <button class="btn btn-secondary btn-success btn-block cooking-time" type="button" id="1" onclick="type_of_readiness(this,'by_time')">ко времени</button>

                        <!--<div class="d-none" id="time"> ко времени</div>-->
                        <input type="datetime-local" class="d-none" id="time">
                    </div>
                </div>


                <div class="row w-100 ml-0 pt-5">
                    <div class="col-lg-12">
                        <h2 class=" text-uppercase font-weight-bold">Способ получения</h2>
                    </div>
                </div>

                <div class="row w-100 ml-0">
                    <div class="col-lg-6">
                        <button class="btn btn-secondary btn-success btn-block delivery" type="button" id="1" onclick="delivery_type(this,'pickup', {{ $totalPrice }})">самовывоз</button>
                    </div>

                    <div class="col-lg-6">
                        <button class="btn btn-secondary btn-success btn-block active delivery" type="button" id="0" onclick="delivery_type(this,'courier', {{ $totalPrice }})">курьерская доставка</button>
                    </div>
                </div>

                <div class="row w-100 ml-0 d-none pt-3" id="pickup">
                        <div class="col-lg-4">
                            <button class="btn btn-secondary btn-success btn-block active delivery-pickup" type="button" id="{{ $pointDelivery->address_delivery->id }}" onclick="update_active(this)">{{ $pointDelivery->address_delivery->address }}</button>
                        </div>

                </div>

                <div class="row w-100 ml-0 pt-3" id="courier">
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Введите адрес доставки</label>
                            <search-address></search-address>
                            <input id="kv" name="kv" type="text" id="kv" placeholder="Номер квартиры" /> <br />
                            <input type="hidden" id="suggest" name="hidden_address" class="input" placeholder="Введите адрес">

                        @if(Auth::check())
                            @if(($addresses->address)->isEmpty())
                            @else
                                <div style="background-color: lightblue; padding: 4px; margin: 10px 0">
                                    <span>Ваш самый популярный адрес:</span>
                                    <span style="color: blue; cursor: pointer" id="offerAddress" onclick="offerAddress()">{{ $addresses->address[0]->address }}</span>
                                </div>
                            @endif()
                        @endif()
                    </div>

                    <div class="map">
                        <p id="notice">Адрес не найден</p>
                        <div id="map"></div>
                        <div id="message"></div>
                        <div id="viewContainer"></div>
                    </div>
                </div>


                <div class="row w-100 ml-0 pt-5">
                    <div class="col-lg-12">
                        <h2 class=" text-uppercase font-weight-bold">Комментарий</h2>
                    </div>
                </div>

                <div class="row ml-0 w-100 pb-3">
                    <div class="col-lg-12">
                            <textarea class="w-100" row="3">
                            </textarea>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div id="cart_form" class="p-3">
                    <div class="d-flex justify-content-between pt-3 pb-3">
                        <h4 class="text-uppercase">Ваш заказ</h4><h4><small>Товаров - {{ $productsCount }} - {{ $totalWeight }} гр</small></h4>
                    </div>

                    <table class="table shopping_basket">
                        <thead>
                        <tr>
                            <td>Товар</td>
                            <td class="text-right">Цена</td>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($cart as $key => $product)
                            <tr>
                                <td class="font-weight-bold"><p>{{ $product->food_additive[0]->food[0]->name }} {{ $product->food_additive[0]->food[0]->id }} <small>× {{ $product->count }}</small></p></td>
                                <td class="font-weight-bold text-right">{{ $product->food_additive[0]->food[0]->price * $product->count }} <i class="fa fa-rub"></i></td>
                            </tr>
                        @endforeach()
                        </tbody>
                    </table>

                    <table class="table shopping_basket">
                        <thead>
                        <tr>
                            <td>Доставка</td>
                            <td class="text-right">Цена</td>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td class="font-weight-bold"><p>Курьером</p></td>
                            <td class="font-weight-bold text-right" id="curierPrice">{{ $courierPrice }} <i class="fa fa-rub"></i></td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table shopping_basket">
                        <thead>
                        <tr>
                            <td>Итого</td>
                            <td class="text-right">Время доставки</td>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td class="font-weight-bold" id="totalPrice"><p>{{ $totalPrice + $courierPrice }}<i class="fa fa-rub mr-0"></i></p></td>
                            <td class="font-weight-bold text-right"><div id="timeDelivery"></div></td>
                        </tr>
                        </tbody>
                    </table>


                </div>


                @if(Auth::check())
                    <button class="btn btn-default btn-block text-uppercase" type="button"
                            onclick="send_order(this)">отправить заказ</button>
                @else
                    <div id="repeatSms" class="repeat-sms">
                        <div class="alert alert-primary" role="alert">
                            Номер телефона некоректен. Введите нормально номер телефона и повторите попытку
                        </div>
                    </div>

                    <button class="btn btn-default btn-block text-uppercase" type="button" onclick="send_an_order(this, phone.value)">отправить заказ</button>

                    <div id="answerError" class="d-none">
                        <div class="alert alert-success" role="alert">
                            Код не правильный
                        </div>
                    </div>

                    <div id="addressError" class="d-none">
                        <div class="alert alert-success" role="alert">
                            Вы не ввели адрес доставки
                        </div>
                    </div>

                    <div id="sms" class="d-none">
                        <div class="alert alert-primary" id="checkSms" role="alert">
                            На указанный номер телефона был отправлен секретый код, введите его в поле ниже для подтверждения заказа.
                            Этот секретный код будет вашем паролем для авторизации на нашем сайте.
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="text" class="form-control sms" id="sms" name="sms" placeholder="код из смс">
                            </div>

                            <div class="col-lg-12">
                                <button class="btn btn-default btn-block text-uppercase col-lg-12" type="button" onclick="confirmCodeSmsForDeliveryOrder(this)">подвердить2</button>
                            </div>

                        </div>
                    </div>
                @endif()


                <div id="answer" class="d-none">
                    <div class="alert alert-success" role="alert">
                        Ваш заказ успешно получен. Пройдите по <a href="/account/">ссылке</a> для того, чтобы отследить статус заявки.
                    </div>
                </div>

            </div>
        </div>

    </form>

</div>