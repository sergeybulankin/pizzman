<template>
    <div>
        <div class="col-lg-12 count-error d-none">
            А товаров то в корзине и нет
        </div>

        <form @submit.prevent="sendCart()" id="form" class="row">
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="d-flex">
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
                            {{ COUNT_PRICE_FOR_PRODUCT_MUTATION(index) }}
                            <tr>
                                <td class="d-flex align-middle">
                                    <div class="delete_icon">
                                        <img src="/images/delete_icon.svg" @click="deleteProductFromCart(index)">
                                    </div>
                                    <div class="photo-small">
                                        <img :src="'http://pizza.admin/images/foods/' + item.food.image" class="img-fluid">
                                    </div>
                                    <div class="description pl-3">
                                        <a><b>{{ item.food.name }}</b></a>
                                    </div>
                                </td>
                                <td class="font-weight-bold align-middle">
                                    {{ item.food.price }}<i class="fa fa-rub"></i>
                                    <span class="description" v-for="(additives, additives_index) in item.additive" :key="additives_index">
                                        <span class="description" v-for="(additive, additive_index) in additives" :key="additive_index">
                                            <div ref="priceAdditive"><small>{{ additive.name }} - {{ additive.price }} <i class="fa fa-rub"></i></small></div>
                                        </span>
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <input type="number" value="1" min="1" max="30" step="1" style="display: none;">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button style="min-width: 2.5rem" class="btn btn-decrement btn-outline-secondary" type="button" @click="MINUS(index)"><strong>-</strong></button>
                                        </div>

                                        <span class="final-count" v-if="item.food.count >= 1">{{ item.food.count }}</span>
                                        <span class="final-count" v-else>{{ POSITIVE_NUMBERS(index) }}</span>

                                        <div class="input-group-append">
                                            <button style="min-width: 2.5rem" class="btn btn-increment btn-outline-secondary" type="button" @click="PLUS(index)"><strong>+</strong></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="font-weight-bold align-middle">{{ item.food.count * item.food.price + ADDITIVE_PRICE[index] }} <i class="fa fa-rub"></i></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="col-lg-4 col-sm-12 col-xs-12 pt-5">
                <div id="cart_form" class="p-3">

                    <div class="d-flex justify-content-between pt-3 pb-3">
                        <h4 class="text-uppercase">Ваша корзина</h4>
                        <h4><small>Товаров - {{ totalProducts }} - {{ totalWeight }} гр</small></h4>
                    </div>

                    <div class="d-flex justify-content-between pt-3 pb-3">
                        <p>Товары({{ totalProducts }})</p> <p>{{ totalPrice }} <i class="fa fa-rub"></i></p>
                    </div>
                    <div class="d-flex justify-content-between subtutorial">
                        <p><b>Итого:</b></p><p>{{ totalPrice }} <i class="fa fa-rub"></i></p>
                    </div>

                    <div class="d-flex justify-content-between subtutorial">
                        <p><b>Тип</b></p><p>{{ typeDeliveryChecked }}</p>
                    </div>

                    <div class="d-flex justify-content-between subtutorial">
                        <span v-if="POINT_INFO.length > 0">
                            <p><b>Точка</b></p><p v-for="(point, i) in POINT_INFO" :key="i">{{ point.points.address }}</p>
                        </span>

                        <span v-if="POINT_INFO.length == 0">
                            <p><b>Точка</b></p><p> Автоматически </p>
                        </span>
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
                    'TOTAl_PRICE_CART',
                    'TOTAl_WEIGHT_CART',
                    'ADDITIVE_PRICE',
                    'POINT_INFO'
                ]),

            checkUser() {
                return window.Laravel.user;
            },

            totalProducts() {
                this.SELECTED_PRODUCTS_IN_CART(this.cart);
                return this.cart.length;
            },

            totalPrice(){
                this.COUNTING_TOTAL_PRICE();
                return this.TOTAl_PRICE_CART;
            },

            totalWeight(){
                this.COUNTING_TOTAL_WEIGHT();
                return this.TOTAl_WEIGHT_CART;
            },

            typeDeliveryChecked() {
                var type = this.type[0];
                var message;

                if (type == 1) {
                    message = 'Приду покушать'
                }
                if (type == 3) {
                    message = 'Самовывоз'
                }
                if(type == 2) {
                    message = 'Курьерска доставка'
                }

                if (this.cart.length == 0) {
                    message = 'Корзина пуста'
                }

                return message;
            }
        },
        methods: {
            ...mapActions([
                'SELECTED_PRODUCTS_IN_CART',
                'COUNTING_TOTAL_PRICE',
                'COUNTING_TOTAL_WEIGHT',
                'SEND_CART_IN_DELIVERY',
                'DELETE_PRODUCT_FROM_CART_FOR_USER'
            ]),

            ...mapMutations([
                'MINUS',
                'PLUS',
                'POSITIVE_NUMBERS',
                'COUNT_PRICE_FOR_PRODUCT_MUTATION',
                'SEND_CART'
            ]),

            deleteProductFromCart(index) {
                _.each(this.cart, (value, key) => {
                    if(value['u_id'] == index) {
                        if(this.checkUser == 1) {
                            this.DELETE_PRODUCT_FROM_CART_FOR_USER(value['u_id']);
                        }

                        this.cart.splice(key, 1);
                    }
                })
                console.log('Товар удален из корзины');
            },

            sendCart(){
                if(this.totalProducts == 0) {
                    $('.count-error').removeClass('d-none')
                    console.log('Корзина пустая');
                }else {
                    this.SEND_CART_IN_DELIVERY(this.ALL_PRODUCTS_IN_CART)
                }
            }
        }
    }
</script>

<style>
    .count-error {
        padding: 8px;
        background: #d1333c;
        color: white;
        font-size: 16px;
        font-weight: 600;
    }
</style>