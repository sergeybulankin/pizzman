<template>
    <div>
        <nav>
            <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                <div v-for="(category, index) in ALL_CATEGORIES" :key="index">
                    <a class="nav-item nav-link active" data-toggle="tab" aria-selected="true" @click="selectProducts(category.id)">{{ category.name }}</a>
                </div>
                <!--<a class="nav-item nav-link active" id="nav-pizza-tab" data-toggle="tab" href="#nav-pizza" role="tab" aria-controls="nav-pizza" aria-selected="true">
                    Пицца</a>
                <a class="nav-item nav-link" id="nav-baking-tab" data-toggle="tab" href="#nav-baking" role="tab" aria-controls="nav-baking" aria-selected="false">Выпечка</a>
                <a class="nav-item nav-link" id="nav-dessert-tab" data-toggle="tab" href="#nav-dessert" role="tab" aria-controls="nav-dessert" aria-selected="false">Десерты</a>
                <a class="nav-item nav-link" id="nav-drink-tab" data-toggle="tab" href="#nav-drink" role="tab" aria-controls="nav-drink" aria-selected="false">Напитки</a>-->
            </div>
        </nav>


        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-pizza" role="tabpanel" aria-labelledby="nav-pizza-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"  v-for="(product, index) in ALL_PRODUCTS" :key="product.id">
                            <div class="one-food">
                                <div id="recommend">рекомендуем</div>
                                <div class="c-product">
                                    <img src="images/demo.jpg"  class="img-fluid">
                                    <div class="search-heart">
                                        <button class="success left"><i class="fa fa-search"></i></button>
                                        <button class="success right" @click="changeFavorite(product.id)" :class="'favorite-' + product.id"><i class="fa fa-heart"></i></button>
                                        <button class="success right" @click="deleteFavorite(product.id)" :class="'delete-favorite-' + product.id"><i class="fa fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">{{ product.title }} </a>
                                    <div class="c-markers">
                                    <span>
                                        <img data-toggle="tooltip" data-placement="top" title="Вегетарианская" src="images/demo1-1944807851-1.svg" alt="Vegetarian">
                                    </span>
                                        <span class="fa fa-info" data-toggle="popover" title="Пищевая ценность" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120"></span>
                                    </div>

                                    <h5><small>{{ product.description }}</small></h5>
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

                                <a class="product_title">{{ product.price }}</a>

                                <div :class="'add-product-id-' + product.id">
                                    <button class="btn btn-block btn-success btn-add_to-cart" @click="changeProduct(product.id)"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                                </div>

                                <div :class="'delete-product-id-' + product.id">
                                    <div class="delete-from-cart">Продукт в корзине</div>
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
        created() {
            this.SELECTED_ALL_PRODUCTS();
            this.SELECT_ALL_FAVORITE();
        },
        mounted() {
            setTimeout (() => { this.CHECK_PRODUCT_IN_CART(this.cart) }, 1000)
            setTimeout (() => { this.CHECK_PRODUCT_IN_FAVORITE(this.ALL_FAVORITE) }, 1000)
        },
        computed: mapGetters(['ALL_PRODUCTS', 'ALL_CATEGORIES', 'ALL_FAVORITE']),
        methods: {
            ...mapActions(['SELECTED_ALL_PRODUCTS', 'CHECK_PRODUCT_IN_CART', 'CHECK_PRODUCT_IN_FAVORITE', 'SELECTED_ALL_CATEGORIES', 'SELECTION_BY_CATEGORY', 'ADD_TO_FAVORITE', 'SELECT_ALL_FAVORITE']),

            changeProduct(id) {
                this.cart.push(id);
                $(".add-product-id-" + id).css("display", "none");
                $(".delete-product-id-" + id).css("display", "block");
            },

            changeFavorite(id) {
                this.ADD_TO_FAVORITE(id);
                $("#favorite-" + id).css("display", "none");
                $("#delete-favorite-" + id).css("display", "block");
            },

            selectProducts(id) {
                this.SELECTION_BY_CATEGORY(id);
                setTimeout (() => { this.CHECK_PRODUCT_IN_CART(this.cart) }, 200)
            }

        }
    }
</script>


<style>
    .panel {
        display: flex;
        flex-wrap: wrap;
    }
    .panel-body {
        background-color: yellow;
        width: 300px;
        margin: 30px 0 0 30px;
        padding: 15px;
        flex-direction: row;
    }
    .title {
        margin: 10px 0;
        font-size: 30px;
        font-weight: 600;
    }
    .description {
        margin: 15px 0;
        font-size: 15px;
    }
    .price {
        font-size: 20px;
        color: red;
    }
    .add-to-cart {
        margin: 20px 0 0 0;
        background: black;
        padding: 10px;
        text-align: center;
        color: white;
        cursor: pointer;
    }
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

    [class^="delete-favorite-"] {
        display: none;
        border: 1px solid black;
        background: red;
    }
</style>