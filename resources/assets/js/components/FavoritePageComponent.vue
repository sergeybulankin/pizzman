<template>
    <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" v-for="(favorite, index) in ALL_FAVORITE" :index="index">
            <div class="one-food">
                <div id="recommend">рекомендуем</div>
                <div class="c-product">
                    <img src="images/demo.jpg"  class="img-fluid">
                    <div class="search-heart">
                        <button class="success left"><i class="fa fa-search"></i></button>
                        <button
                                @click="deleteFavorite(favorite.food_id)"
                                :class="'delete-favorite-' + favorite.food_id">
                                <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
                <div class="c-product-info">
                    <a class="product_title"> {{ favorite.name }} </a>
                    <div class="c-markers">
                        <span>
                            <img data-toggle="tooltip" data-placement="top" title="" src="https://parkofideas.com/foodz/demo4/wp-content/uploads/2019/03/demo1-1944807851-1.svg" alt="Vegetarian" data-original-title="Вегетарианская">
                        </span>
                        <span class="fa fa-info" data-toggle="popover" title="" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120" data-original-title="Пищевая ценность"></span>
                    </div>

                    <h5><small>{{ favorite.structure }}</small></h5>
                </div>

                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <!--<label class="btn btn-secondary" v-for="(additive, additive_index) in favorite.additives"
                           :class="{ 'active': additive.id === 0 }"
                           :key="additive_index"
                           @click="changeAdditive(additive.id, product.id)">
                        <input type="radio" name="options"
                               :id="'option-' + additive.id"
                               autocomplete="off"> {{ additive.name }}
                    </label>
                </div>

                <input type="hidden"
                       :id="'additive-' + product.id"
                       :class="'additive-' + product.id"
                       :value="0">-->

                <a class="product_title">{{ favorite.price }} Р</a>

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

</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        created(){
            this.SELECT_ALL_FAVORITE();
        },
        computed: mapGetters(['ALL_FAVORITE']),
        methods: {
            ...mapActions([
                    'SELECT_ALL_FAVORITE',
                    'DELETE_OF_FAVORITE',
                    'CHECK_PRODUCT_IN_CART'
                ]),

            deleteFavorite(id) {
                this.DELETE_OF_FAVORITE(id);
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