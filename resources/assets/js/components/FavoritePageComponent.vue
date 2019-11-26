<template>
    <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" v-for="(favorite, index) in ALL_FAVORITE" :index="index">
            <div v-for="(food, food_index) in favorite">
                <div class="one-food">
                    <div id="recommend">рекомендуем</div>
                    <div class="c-product">
                        <img :src="food.image"  class="img-fluid">
                        <div class="search-heart">
                            <button
                                    @click="deleteFavorite(favorite.food_id)"
                                    :class="'delete-favorite-' + favorite.food_id">
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
                        <div v-for="(additive, additive_index) in food.additives" :key="additive_index">
                            <input type="checkbox"
                                   :value="additive.id"
                                   :id="food.id"
                                   @click="changeAdditive($event)"> {{ additive.name }}
                        </div>
                    </div>

                    <a class="product_title">{{ food.price }} Р</a>

                    <div :class="'add-product-id-' + favorite.product_id">
                        <button class="btn btn-block btn-success btn-add_to-cart"
                                @click="changeProduct(favorite.product_id)">
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
        mounted() {
            this.SELECT_ALL_FAVORITE(this.favorite);
        },
        computed: mapGetters(['ALL_FAVORITE']),
        methods: {
            ...mapActions([
                    'SELECT_ALL_FAVORITE',
                    'DELETE_OF_FAVORITE'
                ]),

            deleteFavorite(id) {
                this.DELETE_OF_FAVORITE(id);
                this.SELECT_ALL_FAVORITE();
                $(".favorite-" + id).css("display", "black");
                $(".delete-favorite-" + id).css("display", "none");
            },

            changeProduct(id) {
                var additive_id = $('.additive-' + id)[0].value;
                this.cart.push({id: id, additive_id: additive_id});
                $(".add-product-id-" + id).css("display", "none");
                $(".delete-product-id-" + id).css("display", "block");

                // если пользователь авторизовован
                // то кидаем весь localStorage в БД
                if (this.checkUser == 1) {
                    this.ADD_TO_DATABASE_FROM_LOCAL_STORAGE(this.cart)
                }
            },

            // передаем из цикла добавок id
            // чтобы было что добавлять в корзину и заказы
            changeAdditive(id, product_id) {
                $('#additive-' + product_id).val(id);
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