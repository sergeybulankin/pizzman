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
                                                @click="deleteFavorite(index, product.id)"
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
                                    <!--<label class="btn btn-secondary" v-for="(additive, additive_index) in product.additives"
                                           :class="{ 'active': additive.id === 0 }"
                                           :key="additive_index"
                                           :id="additive.id"
                                           v-model="checkedAdditive"
                                           @click="changeAdditive($event, additive.id, product.id)">
                                        <input type="checkbox" name="options"
                                               :id="'option-' + additive.id"
                                               autocomplete="off"> {{ additive.name }}
                                    </label>-->
                                    <div v-for="(additive, additive_index) in product.additives" :key="additive_index">
                                        <input type="checkbox"
                                               :value="additive.id"
                                               :id="product.id"
                                               @click="changeAdditive($event)"> {{ additive.name }}
                                    </div>

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
    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            return {
                checkedAdditive: []
            }
        },
        created() {
            console.log('Стартуем!');
            this.SELECTED_ALL_PRODUCTS();

            if(this.checkUser == 1) {
                console.log('Собираем ваше избранное');
                this.SELECT_ALL_FAVORITE();

                console.log('Собираем вашу корзину');
                this.SELECTED_ALL_PRODUCTS_FOR_USERS();
            }
        },
        mounted() {
            setTimeout (() => { this.CHECK_PRODUCT_IN_FAVORITE(this.favorite) }, 1000)
        },
        computed: {
            ...mapGetters([
                    'ALL_PRODUCTS',
                    'ALL_CATEGORIES',
                    'ALL_FAVORITE'
                ]),

            checkUser() {
                // window.Laravel.user - записывается в хэдэре,
                // если пользователь авторизовался
                return window.Laravel.user;
            }
        },
        methods: {
            ...mapActions([
                'SELECTED_ALL_PRODUCTS',
                'SELECTED_ALL_PRODUCTS_FOR_USERS',
                'SELECTION_BY_CATEGORY',
                'ADD_TO_DATABASE_FROM_LOCAL_STORAGE',
                'SELECT_ALL_FAVORITE',
                'CHECK_PRODUCT_IN_FAVORITE',
                'ADD_TO_FAVORITE',
                'COUNT_FAVORITE',
                'DELETE_OF_FAVORITE'
            ]),


            changeProduct(id) {
                let additiveFood = [];
                this.checkedAdditive.forEach((key, value) => {
                    if(key.product == id) {
                        additiveFood.push(parseInt(key.additive))
                    }
                });

                let additiveInCart = [];
                this.cart.forEach((key, value) => {
                    if(key.id == id) {
                        key.additive_id.additiveFood.forEach((k, v) => {
                            additiveInCart.push(k)
                        })
                    }
                });

                var diff = _.difference(additiveFood, additiveInCart, _.isEqual);

                var u_id = Math.floor(Math.random() * (10000 - 50));
                var changedProduct = {u_id: u_id, id: id, additive_id: { additiveFood }, count: 1};

                if (_.isEmpty(diff) == true) {
                    _.map(this.cart, function (cart) {
                        if (cart.id == id) {
                            cart.count++
                        }
                    })
                } else {
                    this.cart.push(changedProduct);
                }

                if (this.cart.length == 0) {
                    this.cart.push(changedProduct);
                }


                // если пользователь авторизовован
                // то кидаем весь localStorage в БД
                if (this.checkUser == 1) {
                    this.ADD_TO_DATABASE_FROM_LOCAL_STORAGE(this.cart)
                }
            },

            changeFavorite(id) {
                if (this.checkUser == 1) {
                    this.ADD_TO_FAVORITE(id)
                }

                this.favorite.push(id);
                $(".favorite-" + id).css("display", "none");
                $(".delete-favorite-" + id).css("display", "block");
            },


            changeAdditive(e) {
                if (e.target.checked == true) {
                    var additive = e.target.value;
                    var product = e.target.id;
                    this.checkedAdditive.push({product: product, additive: additive});
                }else {
                    this.checkedAdditive.pop({product: product, additive: additive});
                }
            },

            deleteFavorite(index, id) {
                if (this.checkUser == 1) {
                    this.DELETE_OF_FAVORITE(id);
                }

                var idx = this.favorite.indexOf(id);

                if (idx != -1) {
                    this.favorite.splice(idx, 1);
                }
                $(".favorite-" + id).css("display", "block");
                $(".delete-favorite-" + id).css("display", "none");
            },

            selectProducts(id) {
                this.SELECTION_BY_CATEGORY(id);
                setTimeout (() => { this.CHECK_PRODUCT_IN_FAVORITE(this.favorite) }, 200)
            }
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
    .add-to-cart:hover {
        background-color: white;
        color: black;
    }
    [class^="delete-product-id-"] {
        display: none;
    }

    [class^="favorite-"] {
        display: block;
    }

    [class^="delete-favorite-"] {
        display: none;
    }
</style>