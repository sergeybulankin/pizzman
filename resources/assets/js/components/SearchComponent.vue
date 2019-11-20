<template>
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
                        <input type="text" name="search-product" placeholder="Введите блюдо..."
                               v-model="filter">
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div v-for="(product, index) in searchByName" :key="product.id">
                            <div class="one-food">
                                <div id="recommend">рекомендуем</div>
                                <div class="c-product">
                                    <img :src="product.image"  class="img-fluid">
                                    <div class="search-heart">
                                        <button class="success right"><i class="fa fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">{{ product.name }}</a>
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
                                           :class="{ 'active': additive.id === 0 }"
                                           :key="additive_index"
                                           @click="changeAdditive(additive.id, product.id)">
                                        <input type="radio" name="options"
                                               :id="'option-' + additive.id"
                                               autocomplete="off"> {{ additive.name }}
                                    </label>
                                </div>

                                <input type="text"
                                       :id="'additive-' + product.id"
                                       :class="'additive-' + product.id"
                                       :value="0">

                                <a class="product_title">{{ product.price }}</a>

                                <div :class="'add-product-id-' + product.id">
                                    <button class="btn btn-block btn-success btn-add_to-cart"
                                            @click="changeProduct(product.id)">
                                            <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                                </div>

                                <div :class="'delete-product-id-' + product.id">
                                    <div class="delete-from-cart">Продукт в корзине</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--container-->
            </div><!--modal-body-->

        </div><!--modal-content-->
    </div><!--modal-dialog-->
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            return {
                filter: ''
            }
        },
        created() {
            this.CATALOG_PRODUCTS();
        },
        mounted() {
            setTimeout (() => { this.CHECK_PRODUCT_IN_CART(this.cart) }, 1000)
        },
        computed: {
            ...mapGetters(['CATALOG']),

            searchByName: function() {
                var filter = this.filter.trim().toLowerCase();
                if (filter === '') return this.CATALOG;

                return this.CATALOG.filter(function(s) {
                    return s.name.toLowerCase().indexOf(filter) > -1;
                });
            }
        },
        methods: {
            ...mapActions([
                'CATALOG_PRODUCTS',
                'CHECK_PRODUCT_IN_CART',
                'ADD_TO_DATABASE_FROM_LOCAL_STORAGE'
            ]),

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
            },
        }
    }
</script>