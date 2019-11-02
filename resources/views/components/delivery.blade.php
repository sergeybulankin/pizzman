<div class="container" id="checkout">
    <h1 class="text-center text-uppercase font-weight-bold">Оформление заказа</h1>

    <form action="/treatment" method="POST">
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
                            <input type="phone" class="form-control" id="name" placeholder="{{ Auth::user()->email }}" disabled>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Телефон</label>
                            <input type="text" class="form-control" id="phone" placeholder="{{ Auth::user()->name }}" disabled>
                        </div>
                    @else
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Ваше имя</label>
                            <input type="phone" class="form-control" id="name">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Телефон</label>
                            <input type="text" class="form-control" id="phone">
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
                        <button class="btn btn-secondary btn-success btn-block active" onclick="type_of_readiness(this,'quickly')">срочная</button>
                    </div>

                    <div class="col-lg-6">
                        <button class="btn btn-secondary btn-success btn-block" onclick="type_of_readiness(this,'by_time')">ко времени</button>

                        <div class="d-none" id="time"> ко времени</div>
                    </div>
                </div>


                <div class="row w-100 ml-0 pt-5">
                    <div class="col-lg-12">
                        <h2 class=" text-uppercase font-weight-bold">Способ получения</h2>
                    </div>
                </div>

                <div class="row w-100 ml-0">
                    <div class="col-lg-6">
                        <button class="btn btn-secondary btn-success btn-block " onclick="delivery_type(this,'pickup')">самовывоз</button>
                    </div>

                    <div class="col-lg-6">
                        <button class="btn btn-secondary btn-success btn-block active" onclick="delivery_type(this,'courier')">курьерская доставка</button>
                    </div>
                </div>

                <div class="row w-100 ml-0 d-none pt-3" id="pickup">
                    <div class="col-lg-4">
                        <button class="btn btn-secondary btn-success btn-block active" onclick="update_active(this)">Адрес №1</button>
                    </div>

                    <div class="col-lg-4">
                        <button class="btn btn-secondary btn-success btn-block " onclick="update_active(this)">Адрес №2</button>
                    </div>

                    <div class="col-lg-4">
                        <button class="btn btn-secondary btn-success btn-block " onclick="update_active(this)">Адрес №3</button>
                    </div>
                </div>

                <div class="row w-100 ml-0 pt-3" id="courier">
                    <div class="form-group col-lg-12">
                        <label for="exampleInputEmail1">Введите адрес доставки</label>
                            <search-address></search-address>
                            <input id="kv" name="kv" type="text" placeholder="Номер квартиры" /> <br />
                            <input type="hidden" id="suggest" name="hidden_address" class="input" placeholder="Введите адрес">
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
                        <h4 class="text-uppercase">Ваш заказ</h4><h4><small>Товаров - {{ $productsCount }} - 2.600 кг</small></h4>
                    </div>

                    <table class="table shopping_basket">
                        <thead>
                        <tr>
                            <td>Товар</td>
                            <td class="text-right">Цена</td>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($cart as $product)
                            <tr>
                                <td class="font-weight-bold"><p>{{ $product->product->product_title }} <small>×{{ $product->count }}</small></p></td>
                                <td class="font-weight-bold text-right">{{ $product->product->price * $product->count }} <i class="fa fa-rub"></i></td>
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
                            <td class="font-weight-bold text-right">{{ $courierPrice }} <i class="fa fa-rub"></i></td>
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
                            <td class="font-weight-bold text-right" id="timeDelivery"><p></p></td>
                        </tr>
                        </tbody>
                    </table>


                </div>

                <button class="btn btn-default btn-block text-uppercase" onclick="send_an_order(this)">отправить заказ</button>

                <div id="sms" class="d-none">
                    <div class="alert alert-primary" role="alert">
                        На указанный номер телефона был отправлен секретый код, введите его в поле ниже для подтверждения заказа.
                        Этот секретный код будет вашем паролем для авторизации на нашем сайте.
                    </div>

                    <div class="row">
                        <div class="form-group col-lg-12">
                            <input type="text" class="form-control" id="name" placeholder="код из смс">
                        </div>

                        <div class="col-lg-12">
                            <button class="btn btn-default btn-block text-uppercase col-lg-12" onclick="confirm(this)">подвердить</button>
                        </div>

                    </div>
                </div>

                <div id="answer" class="d-none">
                    <div class="alert alert-success" role="alert">
                        Ваш заказ успешно получен. Пройдите по <a href="/account/track">ссылке</a> для того, чтобы отследить статус заявки.
                    </div>
                </div>

            </div>
        </div>

    </form>

</div>