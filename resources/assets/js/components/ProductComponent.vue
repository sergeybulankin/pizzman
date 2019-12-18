<template>
    <div>
        <nav>
            <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                <div v-for="(category, index) in ALL_CATEGORIES" :key="index">
                    <a class="nav-item nav-link active" data-toggle="tab" aria-selected="true"
                       @click="selectProducts(category.id)">{{ category.name }}
                    </a>
                </div>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-pizza" role="tabpanel" aria-labelledby="nav-pizza-tab">
                <div class="container">
                    <div v-if="LOADER" class="load">
                        <img src="images/loader.gif" alt="">
                        <h4>Загружаем товары...</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"  v-for="(product, index) in ALL_PRODUCTS" :key="index">
                            <div class="one-food">
                                <div id="recommend"
                                     v-if="product.recommend == true">рекомендуем</div>
                                <div class="c-product">
                                    <img :src="product.image" class="img-fluid">
                                    <div class="search-heart">
                                        <button
                                                @click="changeFavorite(product.id)"
                                                :class="'favorite-' + product.id">
                                                <i class="fa fa-heart"></i>
                                        </button>
                                        <button
                                                @click="deleteFavorite(product.id)"
                                                class="d-none"
                                                :class="'delete-favorite-' + product.id"><i class="fa fa-trash-o"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">{{ product.name }} </a>
                                    <span> Масса: {{ product.weight }}г<br>Калорийность: {{ product.calories }}<br>Белки: {{ product.protein }}<br>Углеводы: {{ product.carbohydrates }} <br> <br></span>
                                    <span v-for="(type, index_type) in product.types" :key="index_type"> {{ type.name }}</span>
                                    <div class="c-markers">
                                    <span>
                                        <img data-toggle="tooltip" data-placement="top" title="Вегетарианская" src="images/demo1-1944807851-1.svg" alt="Vegetarian">
                                    </span>
                                        <span class="fa fa-info" data-toggle="popover" title="Пищевая ценность" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120"></span>
                                    </div>

                                    <h5><small>{{ product.structure }}</small></h5>
                                </div>

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary" v-for="(additive, additive_index) in product.additives"
                                           :key="additive_index"
                                           :class="{ 'active': additive.id === 1, 'd-none': additive.id === 1 }"
                                           @click="changeAdditive($event)">
                                        <input type="checkbox" name="options"
                                               :value="additive.id"
                                               :id="product.id"
                                               autocomplete="off"> {{ additive.name }}
                                    </label>
                                </div>

                                <a class="product_title">{{ product.price }} P</a>

                                <div :class="'add-product-id-' + product.id">
                                    <button class="btn btn-block btn-success btn-add_to-cart"
                                            @click="changeProduct(product.id)">
                                            <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import notifier from 'codex-notifier';
    import {ConfirmNotifierOptions, NotifierOptions, PromptNotifierOptions} from 'codex-notifier';

    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            return {
                checkedAdditive: []
            }
        },
        created() {
            console.log(`%c ________________________________________
< здесь могла бы быть ваша реклама >
 ----------------------------------------
        \\   ^__^
         \\  (oo)\\_______
            (__)\\       )\\/\\
                ||----w |
                ||     ||`, "font-family:monospace");
            this.SELECTED_ALL_PRODUCTS();

            if(this.checkUser == 1) {
                console.log('Собираем ваше избранное');
                this.SELECT_ALL_FAVORITE_FOR_USERS();
                setTimeout (() => {this.differenceUserFavorite()}, 1000)

                console.log('Собираем вашу корзину');
                this.SELECTED_ALL_PRODUCTS_FOR_USERS();
                setTimeout (() => {this.differenceUserCart()}, 1000)
            }
        },
        mounted() {
            setTimeout (() => { this.CHECK_PRODUCT_IN_FAVORITE(this.favorite) }, 1000)
        },
        computed: {
            ...mapGetters([
                    'ALL_PRODUCTS',
                    'ALL_CATEGORIES',
                    'ALL_FAVORITE',
                    'CART_FOR_USER',
                    'LOADER'
                ]),

            // window.Laravel.user - записывается в хэдэре,
            // если пользователь авторизовался
            checkUser() {
                return window.Laravel.user;
            }
        },
        methods: {
            ...mapActions([
                'SELECTED_ALL_PRODUCTS',
                'SELECTED_ALL_PRODUCTS_FOR_USERS',
                'SELECTION_BY_CATEGORY',
                'SELECTED_PRODUCTS_IN_CART',
                'ADD_TO_DATABASE_FROM_LOCAL_STORAGE',
                'SELECT_ALL_FAVORITE',
                'SELECT_ALL_FAVORITE_FOR_USERS',
                'CHECK_PRODUCT_IN_FAVORITE',
                'ADD_TO_FAVORITE',
                'COUNT_FAVORITE',
                'DELETE_OF_FAVORITE'
            ]),


            changeProduct(id) {
                // перебираем v-model с добавками
                // если массив пустой, то тогда добавляем id со стандартным типом
                // если массив не пустой, то добавляем к нему id со стандартным типом
                // для того чтобы знать какое блюдо с какой добавкой нужно готовить
                let additiveFood = [];
                if (this.checkedAdditive.length == 0) {
                    additiveFood.push(1)
                }else {
                    additiveFood.push(1)
                    this.checkedAdditive.forEach((key, value) => {
                        if(key.product == id) {
                            additiveFood.push(parseInt(key.additive))
                        }
                    });
                }

                // перебираем массив из localStorage
                // добавляем в массив additiveInCart все добавки, которые соответствуют блюду
                // по которому был совершен клик
                let additiveInCart = [];
                this.cart.forEach((key, value) => {
                    if(key.id == id) {
                        key.additive_id.additiveFood.forEach((k, v) => {
                            additiveInCart.push(k)
                        })
                    }
                });

                // выясняем какая есть разница между массивами
                var diff = _.difference(additiveFood, additiveInCart, _.isEqual);

                // создаем уникальный идентификатор для блюда с (или без) добавок
                // записываем в объект нужные для нас данные:
                // u_id - уникальный ключ
                // id - ключ блюда
                // additive_id - объект с ключами добавок
                // count- количество блюд с такими добавками
                var u_id = Math.floor(Math.random() * (10000 - 50));
                var changedProduct = {u_id: u_id, id: id, additive_id: { additiveFood }, count: 1};

                // сравниваем переменную сравнения массивов
                // если переменная оказалась пустой, то получается это блюдо с добавкой уже в корзине
                // и мы увеличиваем только количество этого блюда, найдя его по id
                // если же разница есть, то записывем в localStorage новое блюдо с добавкой (или без)
                if (_.isEmpty(diff) == true) {
                    _.map(this.cart, function (cart) {
                        if (cart.id == id) {
                            cart.count++
                        }
                    })
                } else {
                    this.cart.push(changedProduct);
                }

                // если localStorage пустой, то сразу записываем туда блюдо
                if (this.cart.length == 0) {
                    this.cart.push(changedProduct);
                }

                // перегружаем localStorage для определения количества товара
                // считаем это не багом, а фичей ¯\_(ツ)_/¯
                setTimeout (() => {
                    this.SELECTED_PRODUCTS_IN_CART(this.cart)
                }, 200)

                // если пользователь авторизовован
                // то кидаем весь localStorage в БД
                // а там пусть серверная часть разбирается
                if (this.checkUser == 1) {
                    var food = {food: id, additive: additiveFood, u_id: u_id};
                    this.ADD_TO_DATABASE_FROM_LOCAL_STORAGE(food)
                }

                notifier.show({
                    message: '<div class="message-alert"><img src="../images/success.png" width="32px"> <span class="notifier-message">Товар добавлен в корзину</span></div>',
                    style: 'success',
                    time: 5000
                });
                console.log('Товар добавлен в корзину');
            },


            changeFavorite(id) {
                console.log('Товар добавлен в избранное')
                if (this.checkUser == 1) {
                    this.ADD_TO_FAVORITE(id)
                }

                this.favorite.push(id);
                $(".favorite-" + id).addClass("d-none");
                $(".delete-favorite-" + id).removeClass("d-none");
            },


            changeAdditive(e) {
                if (e.target.children[0].checked == false) {
                    var additive = e.target.children[0].value;
                    var product = e.target.children[0].id;

                    this.checkedAdditive.push({product: product, additive: additive});
                }else {
                    this.checkedAdditive.pop({product: product, additive: additive});
                }
            },


            deleteFavorite(id) {
                console.log('Товар удален из избранного')
                if (this.checkUser == 1) {
                    this.DELETE_OF_FAVORITE(id);
                }

                _.each(this.favorite, (value, key) => {
                    if (value == id) {
                        this.favorite.splice(key, 1);
                    }
                })

                $(".favorite-" + id).removeClass("d-none");
                $(".delete-favorite-" + id).addClass("d-none");
            },


            selectProducts(id) {
                this.SELECTION_BY_CATEGORY(id);
                setTimeout (() => { this.CHECK_PRODUCT_IN_FAVORITE(this.favorite) }, 200)
            },


            differenceUserCart() {
                this.cart.length = 0;

                _.each(this.CART_FOR_USER, (value, key) => {
                    let additiveFood = [];
                    _.each(value['additive'], (value, key) => {
                        additiveFood.push(value[0]['id']);
                    })

                    var changedProduct = {u_id: key, id: value['food']['id'], additive_id: { additiveFood } , count: value['food']['count']}

                    this.cart.push(changedProduct);
                });
            },

            differenceUserFavorite() {
                this.favorite.length = 0;

                _.each(this.ALL_FAVORITE, (value, key) => {
                    this.favorite.push(value);
                })
            }
        }
    }
</script>


<style>
    .load {
        text-align: center;
    }

    .cdx-notifies {
        position: fixed;
        z-index: 2;
        top: 0;
        left: 85%;
    }
    .cdx-notify {
        position: relative;
        width: 270px;
        margin-top: 15px;
        padding: 13px 16px;
        background: #fff;
        box-shadow: 0 11px 17px 0 rgba(23,32,61,.13);
        border-radius: 0;
        font-size: 14px;
    }
    .cdx-notyfy::before {
        content: '';
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        width: 3px;
        height: calc(100% - 6px);
        margin: 3px;
        border-radius: 0;
        background: transparent;
    }
    .cdx-notify--success {
        background: #fafffe !important;
    }

    .cdx-notify--success::before {
        background: #41ffb1 !important;
        width: 5px;
    }
    .notifier-message {
        margin: 0 0 0 10px;
    }
</style>