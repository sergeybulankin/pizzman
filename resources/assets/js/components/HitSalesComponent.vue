<template>
    <section id="hits">
        <h2 class="text-center header">ХИТЫ ПРОДАЖ</h2>
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" v-for="(product, i) in HITS" :key="i">
                    <div class="one-food">
                        <div class="c-product">
                            <img :src="product.image"  class="img-fluid">
                            <div class="search-heart">
                                <button
                                        @click="changeFavorite(product.id)"
                                        :class="'favorite-' + product.id">
                                    <i class="fa fa-heart"></i>
                                </button>
                                <button
                                        @click="deleteFavorite(product.id)"
                                        class="d-none"
                                        :class="'delete-favorite-' + product.id"><i class="fa fa-heart heart-red"></i>
                                </button>
                            </div>
                        </div>
                        <div class="c-product-info">
                            <a class="product_title">{{ product.name }}</a>

                            <h5><small>{{ product.structure }}</small></h5>
                        </div>

                        <a class="product_title">{{ product.price }} Р</a>

                        <button class="btn btn-block btn-success btn-add_to-cart"
                                @click="changeProduct(product.id)">
                            <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                    </div>
                </div>

            </div><!--row-->
        </div><!--container-->
    </section>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import notifier from 'codex-notifier';

    export default {
        data() {
            return {
                checkedAdditive: []
            }
        },
        mounted() {
          this.HIT_SALES();
        },
        computed: mapGetters(['HITS']),
        methods: {
            ...mapActions([
                'HIT_SALES',
                'SELECTED_PRODUCTS_IN_CART'
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

                // существует следующий момент: если добавить продукт сперва с добавками, а после без
                // то продукт не будет добавляться в корзину
                // для этого на всякий случай сравниваем массивы в корзине на наличие стандартного продукта
                // и если его нет - то добавляем
                if (_.isEmpty(diff) == true) {
                    var search = 0;

                    _.map(this.cart, function (cart) {
                        if (cart.id == id) {
                            if (cart.additive_id['additiveFood'].length == additiveFood.length) {
                                cart.count++;
                            }

                            if (additiveFood == 1) {
                                _.find(cart.additive_id, function (item){
                                    var arr = _.values(item);

                                    var equal = _.isEqual(arr, [1]);

                                    if(equal == true){
                                        search = 0;
                                    }else {
                                        search = 1;
                                    }

                                });
                            }

                        }
                    })

                    if (search == 1) {
                        this.cart.push(changedProduct);
                    }

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

            // window.Laravel.user - записывается в хэдэре,
            // если пользователь авторизовался
            checkUser() {
                return window.Laravel.user;
            }
        }
    }
</script>