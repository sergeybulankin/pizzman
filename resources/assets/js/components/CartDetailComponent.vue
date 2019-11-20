<template>
    <div>
        <form @submit.prevent="sendCart()" id="form" class="row">
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="d-flex pt-5">
                    <table class="table shopping_basket">
                        <thead>
                        <tr>
                            <td>Продукт</td>
                            <td>Цена</td>
                            <td>Количество</td>
                            <td>Итого</td>
                        </tr>
                        </thead>

                        <tbody v-for="(item, index) in ALL_PRODUCTS_IN_CART" class="cart" :key="index">
                            <tr v-for="(product, index_product) in item.food" class="cart" :key="index_product">
                                <td class="d-flex align-middle">
                                    <div class="delete_icon">
                                        <img src="/images/delete_icon.svg" @click="deleteProductFromCart(index)">
                                    </div>
                                    <div class="photo-small">
                                        <img :src="product.image" class="img-fluid">
                                    </div>
                                    <div class="description pl-3">
                                        <a><b>{{ product.name }}</b></a><p><small>{{ product.structure }}</small></p>
                                    </div>
                                </td>
                                <td class="font-weight-bold align-middle">
                                    {{ product.price }}<i class="fa fa-rub"></i>
                                    <span class="description" v-for="(additive, additive_index) in item.additive" :key="additive_index">
                                         <div ref="priceAdditive"><small>{{ additive.price }} <i class="fa fa-rub"></i></small></div>
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <input type="number" value="1" min="1" max="30" step="1" style="display: none;"><div class="input-group  ">
                                    <div class="input-group-prepend">
                                        <button style="min-width: 2.5rem" class="btn btn-decrement btn-outline-secondary" type="button" @click="MINUS(index)"><strong>-</strong></button>
                                    </div>

                                    <span class="final-count" v-if="item.count >= 1">{{ item.count }}</span>
                                    <span class="final-count" v-else>{{ POSITIVE_NUMBERS(index) }}</span>

                                    <div class="input-group-append">
                                    <button style="min-width: 2.5rem" class="btn btn-increment btn-outline-secondary" type="button" @click="PLUS(index)"><strong>+</strong></button>
                                </div>
                                </div></td>
                                <td class="font-weight-bold align-middle">{{ item.count * product.price + item.additive[0].price }} <i class="fa fa-rub"></i></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="col-lg-4 col-sm-12 col-xs-12 pt-5">
                <div id="cart_form" class="p-3">

                    <div class="d-flex justify-content-between pt-3 pb-3">
                        <h4 class="text-uppercase">Ваша корзина</h4><h4><small>Товаров - {{ totalProducts }} - 2.600 кг</small></h4>
                    </div>

                    <div class="d-flex justify-content-between pt-3 pb-3">
                        <p>Товары({{ totalProducts }})</p> <p>{{ totalPrice }} <i class="fa fa-rub"></i></p>
                    </div>
                    <div class="d-flex justify-content-between subtutorial">
                        <p><b>Итого:</b></p><p>{{ totalPrice }} <i class="fa fa-rub"></i></p>
                    </div>
                </div>

                <button class="btn btn-default btn-block text-uppercase">перейти к оформление</button>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapGetters, mapActions, mapMutations } from 'vuex';

    export default{
        mounted() {
            this.SELECTED_PRODUCTS_IN_CART(this.cart);
        },
        computed: {
            ...mapGetters([
                    'ALL_PRODUCTS_IN_CART',
                    'TOTAl_PRICE_CART'
                ]),

            totalProducts() {
                this.SELECTED_PRODUCTS_IN_CART(this.cart);
                return this.cart.length;
            },

            totalPrice(){
                this.$store.dispatch('COUNTING_TOTAL_PRICE')
                return this.$store.getters.TOTAl_PRICE_CART;
            }
        },
        methods: {
            ...mapActions([
                'SELECTED_PRODUCTS_IN_CART',
                'COUNTING_TOTAL_PRICE',
                'SEND_CART_IN_DELIVERY'
            ]),

            ...mapMutations([
                'MINUS',
                'PLUS',
                'TOTAL_PRICE',
                'POSITIVE_NUMBERS',
                'SEND_CART'
            ]),

            deleteProductFromCart(id) {
                this.cart.splice(id, 1);
            },

            sendCart(){
                this.SEND_CART_IN_DELIVERY(this.ALL_PRODUCTS_IN_CART)
            }
        }
    }
</script>