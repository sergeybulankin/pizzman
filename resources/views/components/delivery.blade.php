@if($typeDelivery == 2)
    @section('yandex')
        @include('components.yandex')
    @endsection()
@endif()

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
                    <div class="form-group col-lg-6">
                        <input type="hidden" class="form-control" id="pointMap" value="{{ $pointDeliveryMap->address_delivery->address }}">
                    </div>

                    <div class="form-group col-lg-6">
                        <input type="hidden" class="form-control" id="typeDelivery" value="{{ $typeDelivery }}">
                    </div>
                </div>

                <div class="row w-100 ml-0">
                         <div class="form-group col-lg-6">
                            <label for="name">Ваше имя</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="phone">Телефон</label>
                            <input type="text" class="form-control tel" id="phone" name="phone">
                        </div>
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

                        <input class="d-none calendar" id="time" placeholder="Выбрать дату">
                    </div>
                </div>

                @if($typeDelivery == 2)
                    <div class="row w-100 ml-0 pt-5">
                        <div class="col-lg-12">
                            <h2 class=" text-uppercase font-weight-bold">Введите адрес доставки</h2>
                        </div>
                    </div>
                    <div class="row w-100 ml-0 pt-3" id="courier">
                        <div class="form-group col-lg-12">
                                <search-address></search-address>
                                <input id="kv" name="kv" type="text" id="kv" placeholder="Номер квартиры" /> <br />
                                <input type="hidden" id="suggest" name="hidden_address" class="input" placeholder="Введите адрес">
                                <input type="hidden" id="coord" name="coord" class="input">
                        </div>

                        <div class="map">
                            <p id="notice">Адрес не найден</p>
                            <div id="map"></div>
                            <div id="message"></div>
                            <div id="viewContainer"></div>
                        </div>
                    </div>
                @endif()
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
                                <td class="font-weight-bold">
                                    <p>{{ $product->food_additive[0]->food[0]->name }} <small>× {{ $product->count }}</small></p>
                                    <small>{{ $product->food_additive[0]->additive[0]->name }}</small>
                                </td>
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
                            @if($typeDelivery == 2)
                                <td class="font-weight-bold"><p>Курьером</p></td>
                                <td class="font-weight-bold text-right" id="curierPrice">{{ $courierPrice }} <i class="fa fa-rub"></i></td>
                            @elseif($typeDelivery == 3)
                                <td class="font-weight-bold"><p>Самовывоз</p></td>
                                <td class="font-weight-bold text-right" id="curierPrice">{{ $courierPrice }} <i class="fa fa-rub"></i></td>
                            @elseif($typeDelivery == 1)
                                <td class="font-weight-bold"><p>Приду покушать</p></td>
                                <td class="font-weight-bold text-right" id="curierPrice">{{ $courierPrice }} <i class="fa fa-rub"></i></td>
                            @endif()
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


                <div id="repeatSms" class="repeat-sms">
                    <div class="alert alert-primary" role="alert">
                        Номер телефона некоректен. Введите нормально номер телефона и повторите попытку
                    </div>
                </div>

                <button class="btn btn-default btn-block text-uppercase" type="button" onclick="send_order(this, phone.value)">отправить заказ</button>

                <form action="/pay" method="GET">
                    <button type="submit">Оплатить</button>
                </form>

                <div id="addressError" class="d-none">
                    <div class="alert alert-success" role="alert">
                        Вы не ввели адрес доставки
                    </div>
                </div>

                <div id="answer" class="d-none">
                    <div class="alert alert-success" role="alert">
                        Ваш заказ успешно получен. Мы с вами свяжемся
                    </div>
                </div>

            </div>
        </div>

    </form>

</div>