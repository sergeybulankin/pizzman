<template>
    <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" v-for="(favorite, index) in ALL_FAVORITE" :index="index">
            <div class="one-food">
                <div id="recommend">рекомендуем</div>
                <div class="c-product">
                    <img src="images/demo.jpg"  class="img-fluid">
                    <div class="search-heart">
                        <button class="success left"><i class="fa fa-search"></i></button>
                        <button @click="deleteFavorite(favorite.product_id)" :class="'delete-favorite-' + favorite.product_id"><i class="fa fa-trash-o"></i></button>
                    </div>
                </div>
                <div class="c-product-info">
                    <a class="product_title"> {{ favorite.title }} </a>
                    <div class="c-markers">
                            <span>
                                <img data-toggle="tooltip" data-placement="top" title="" src="https://parkofideas.com/foodz/demo4/wp-content/uploads/2019/03/demo1-1944807851-1.svg" alt="Vegetarian" data-original-title="Вегетарианская">
                            </span>
                        <span class="fa fa-info" data-toggle="popover" title="" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120" data-original-title="Пищевая ценность"></span>
                    </div>

                    <h5><small>{{ favorite.description }}</small></h5>
                </div>

                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked=""> добавка 1
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option2" autocomplete="off"> добавка 2
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="options" id="option3" autocomplete="off"> добавка 3
                    </label>
                </div>

                <a class="product_title">{{ favorite.price }} Р</a>

                <div :class="'add-product-id-' + favorite.product_id">
                    <button class="btn btn-block btn-success btn-add_to-cart" @click="changeProduct(favorite.product_id)"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                </div>

                <div :class="'delete-product-id-' + favorite.product_id">
                    <div class="delete-from-cart">Продукт в корзине</div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        created(){
            this.SELECT_ALL_FAVORITE();
        },
        computed: mapGetters(['ALL_FAVORITE']),
        methods: {
            ...mapActions(['SELECT_ALL_FAVORITE', 'DELETE_OF_FAVORITE', 'CHECK_PRODUCT_IN_CART']),

            deleteFavorite(id) {
                this.DELETE_OF_FAVORITE(id);
                $(".favorite-" + id).css("display", "black");
                $(".delete-favorite-" + id).css("display", "none");
            },

            changeProduct(id) {
                this.cart.push(id);
                $(".add-product-id-" + id).css("display", "none");
                $(".delete-product-id-" + id).css("display", "block");
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

    [class^="delete-product-id-"] {
        display: none;
    }

    [class^="favorite-"] {
        display: block;
    }
</style>