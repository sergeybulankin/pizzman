<template>
    <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" v-for="(favorite, index) in ALL_FAVORITE" :index="index">
            <div v-for="(food, food_index) in favorite">
                <div class="one-food">
                    <div id="recommend">рекомендуем</div>
                    <div class="c-product">
                        <img :src="'http://pizza.admin/images/foods/' + food.image" class="img-fluid">
                        <div class="search-heart">
                            <button
                                    @click="deleteFavorite(food.id)"
                                    :class="'delete-favorite-' + food.id">
                                    <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </div>
                    <div class="c-product-info">
                        <a class="product_title"> {{ food.name }} </a>
                        <div class="c-markers">
                            <span>
                                <img data-toggle="tooltip" data-placement="top" title="" src="https://parkofideas.com/foodz/demo4/wp-content/uploads/2019/03/demo1-1944807851-1.svg" alt="Vegetarian" data-original-title="Вегетарианская">
                            </span>
                            <span class="fa fa-info" data-toggle="popover" title="" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120" data-original-title="Пищевая ценность"></span>
                        </div>

                        <h5><small>{{ food.structure }}</small></h5>
                    </div>

                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary" v-for="(additive, additive_index) in food.additives"
                               :key="additive_index"
                               :class="{ 'active': additive.id === 1, 'd-none': additive.id === 1 }"
                               @click="changeAdditive($event)">
                            <input type="checkbox" name="options"
                                   :value="additive.id"
                                   :id="food.id"
                                   autocomplete="off"> {{ additive.name }}
                        </label>
                    </div>

                    <a class="product_title">{{ food.price }} Р</a>

                    <div :class="'add-product-id-' + food.id">
                        <button class="btn btn-block btn-success btn-add_to-cart"
                                @click="changeProduct(food.id)">
                                <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                    </div>

                    <div :class="'delete-product-id-' + favorite.product_id">
                        <div class="delete-from-cart">Продукт в корзине</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            return {
                checkedAdditive: []
            }
        },
        mounted() {
            this.SELECT_ALL_FAVORITE(this.favorite);
        },
        computed: {
            ...mapGetters(['ALL_FAVORITE']),

            // window.Laravel.user - записывается в хэдэре,
            // если пользователь авторизовался
            checkUser() {
                return window.Laravel.user;
            }
        },
        methods: {
            ...mapActions([
                    'SELECT_ALL_FAVORITE',
                    'DELETE_OF_FAVORITE',
                    'ADD_TO_DATABASE_FROM_LOCAL_STORAGE',
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
                setTimeout (() => {
                    this.SELECTED_PRODUCTS_IN_CART(this.cart)
                }, 200)

                // если пользователь авторизовован
                // то кидаем весь localStorage в БД
                if (this.checkUser == 1) {
                    var food = {food: id, additive: additiveFood, u_id: u_id};
                    this.ADD_TO_DATABASE_FROM_LOCAL_STORAGE(food)
                }
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
                if (this.checkUser == 1) {
                    this.DELETE_OF_FAVORITE(id);
                }

                _.each(this.favorite, (value, key) => {
                    if (value == id) {
                        this.favorite.splice(key, 1);
                    }
                })

                this.SELECT_ALL_FAVORITE(this.favorite);
            },
        }
    }
</script>


<style>
    .delete-from-cart {
        margin: 20px 0 0 0;
        background: #a2a2a2;
        padding: 10px;
        text-align: center;
        color: white;
        cursor: pointer;
    }

    [class^="delete-product-id-"] {
        display: none;
    }

    [class^="favorite-"] {
        display: block;
    }
</style>