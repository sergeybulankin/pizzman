<!--Модальное окно поиска блюд-->
<div class="modal" tabindex="-1" role="dialog" id="search-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content pb-5">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="search-block pb-3">
                        <p>Что Вы желаете найти?</p>
                        <input type="text" name="search-product" placeholder="Введите блюдо...">
                    </div>
                </div>

                <div class="container">

                    <search></search>

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="one-food">
                                <div id="recommend">рекомендуем</div>
                                <div class="c-product">
                                    <img src="images/demo1-0901996381-1-238x238.jpg"  class="img-fluid">
                                    <div class="search-heart">
                                        <button class="success left"><i class="fa fa-search"></i></button>
                                        <button class="success right"><i class="fa fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">Пицца с ветчиной</a>
                                    <div class="c-markers">
                                  <span>
                                      <img data-toggle="tooltip" data-placement="top" title="Вегетарианская" src="images/demo1-1944807851-1.svg" alt="Vegetarian">
                                  </span>
                                        <span class="fa fa-info" data-toggle="popover" title="Пищевая ценность" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120"></span>
                                    </div>

                                    <h5><small>огурцы, помидоры, колбаса, сыр</small></h5>
                                </div>

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> добавка 1
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> добавка 2
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> добавка 3
                                    </label>
                                </div>

                                <a class="product_title">350Р</a>

                                <button class="btn btn-block btn-success btn-add_to-cart"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="one-food">
                                <div class="c-product">
                                    <img src="images/demo1-0902421386-1-238x238.jpg"  class="img-fluid">
                                    <div class="search-heart">
                                        <button class="success left"><i class="fa fa-search"></i></button>
                                        <button class="success right"><i class="fa fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">Пицца с ветчиной</a>
                                    <div class="c-markers">
                                  <span>
                                      <img data-toggle="tooltip" data-placement="top" title="Острая" src="images/demo1-1927616421-1.svg" alt="Spicy">
                                  </span>
                                        <span class="fa fa-info" data-toggle="popover" title="Пищевая ценность" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120"></span>
                                    </div>

                                    <h5><small>огурцы, помидоры, колбаса, сыр</small></h5>
                                </div>

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> добавка 1
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> добавка 2
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> добавка 3
                                    </label>
                                </div>

                                <a class="product_title">350Р</a>

                                <button class="btn btn-block btn-success btn-add_to-cart"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="one-food">
                                <div class="c-product">
                                    <img src="images/demo1-0901188784-1-238x238.jpg"  class="img-fluid">
                                    <div class="search-heart">
                                        <button class="success left"><i class="fa fa-search"></i></button>
                                        <button class="success right"><i class="fa fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">Пицца с ветчиной</a>

                                    <div class="c-markers">
                                  <span>
                                      <img data-toggle="tooltip" data-placement="top" title="Острая" src="images/demo1-1927616421-1.svg" alt="Spicy">
                                  </span>
                                        <span class="fa fa-info" data-toggle="popover" title="Пищевая ценность" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120"></span>
                                    </div>

                                    <h5><small>огурцы, помидоры, колбаса, сыр</small></h5>
                                </div>

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> добавка 1
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> добавка 2
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> добавка 3
                                    </label>
                                </div>

                                <a class="product_title">350Р</a>

                                <button class="btn btn-block btn-success btn-add_to-cart"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="one-food">
                                <div class="c-product">
                                    <img src="images/demo1-0949356538-1-238x238.jpg"  class="img-fluid">
                                    <div class="search-heart">
                                        <button class="success left"><i class="fa fa-search"></i></button>
                                        <button class="success right"><i class="fa fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">Пицца с ветчиной</a>

                                    <div class="c-markers">
                                  <span>
                                    <img data-toggle="tooltip" data-placement="top" title="Острая" src="images/demo1-1927616421-1.svg" alt="Spicy">
                                  </span>
                                        <span class="fa fa-info" data-toggle="popover" title="Пищевая ценность" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120"></span>
                                    </div>

                                    <h5><small>огурцы, помидоры, колбаса, сыр</small></h5>
                                </div>

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> добавка 1
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> добавка 2
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> добавка 3
                                    </label>
                                </div>

                                <a class="product_title">350Р</a>

                                <button class="btn btn-block btn-success btn-add_to-cart">
                                    <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <a href="http://laravel.arimle.ru/view-all-results-of-search">
                            <button class="btn btn-default">посмотреть все результаты</button>
                        </a>
                    </div>
                </div><!--container-->
            </div><!--modal-body-->

        </div><!--modal-content-->
    </div><!--modal-dialog-->
</div>
<!--Модальное окно поиска блюд конец-->