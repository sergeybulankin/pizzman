<template>
    <div style="position: relative">
        <div class='cart_info--mobile'>

            <div class="cart--mobile--title">
                <span class="fa fa-shopping-cart"></span>
                <span v-if="totalProducts <= 0">Ваша корзина пока пуста</span>
                <span v-else>Корзина</span>
            </div>

            <div v-if="totalProducts <= 0" style="margin: 0 0 15px 0;">
                <img src="images/sleeping_cat1.gif" alt="Котик спит" width="150px">
            </div>

            <ul v-for="(item, index) in ALL_PRODUCTS_IN_CART" :key="index" class="cart--mobile">
                <li>
                    <div class="d-flex">
                        <div class="delete_icon--mobile">
                            <img src="/images/delete_icon.svg" @click="deleteProductFromCart(index)"/>
                        </div>

                        <div class="photo-small">
                            <img :src="'http://pizza.admin/images/foods/' + item.food.image" class="img-fluid">
                        </div>

                        <div class="description">
                            <a><b>{{ item.food.name }}</b></a><p><small>{{ item.food.count }}x{{ item.food.price }} <i class="fa fa-rub"></i></small></p>

                            <div class="cart-additive">
                                <span v-for="(additives, additives_index) in item.additive" :key="additives_index">
                                    <span v-for="(additive, additive_index) in additives" :key="additive_index">
                                        <a style="font-size: 12px;"><b>{{ additive.name }}</b></a>
                                        <p style="font-size: 12px"><small>{{ additive.price }} <i class="fa fa-rub"></i></small></p>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <div class="point-delivery-cart--mobile">
                <div class="delivery-cart-description">
                    Тип: <span class="point-delivery-cart-info">{{ typeDelivery }}</span> &nbsp;

                    Точка: <span class="point-delivery-cart-info" v-for="(point, i) in POINT_INFO" :key="i">{{ point.points.address }}</span>
                </div>
            </div>

            <div class="d-flex subtutorial--mobile">
                <strong>Итого: &nbsp; </strong>
                <p><b>{{ totalPrice }} <i class="fa fa-rub mr-0"></i></b></p>
            </div>

            <div class="d-flex" v-if="totalProducts > 0 ">
                <a href="/cart">
                    <button class="btn btn-default cart--mobile--button">Корзина</button>
                </a>

                <form @submit.prevent="sendCart()" id="form" class="row">
                    <button class="btn btn-success success--mobile--button">Оформить заказ</button>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default{
        mounted() {
            this.SELECTED_PRODUCTS_IN_CART(this.cart);
            this.SELECTED_INFO_POINT_DELIVERY(this.pointsDelivery[0]);
        },
        computed: {
                ...mapGetters([
                    'ALL_PRODUCTS_IN_CART',
                    'POINT_INFO'
                ]),

        // window.Laravel.user - записывается в хэдэре,
        // если пользователь авторизовался
        checkUser() {
            return window.Laravel.user;
        },

        totalProducts() {
            this.SELECTED_PRODUCTS_IN_CART(this.cart);
            return this.cart.length;
        },

        totalPrice(){
            this.$store.dispatch('COUNTING_TOTAL_PRICE')
            return this.$store.getters.TOTAl_PRICE_CART;
        },

        typeDelivery() {
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

            return message;
        }
    },
    methods: {
    ...mapActions([
            'SELECTED_PRODUCTS_IN_CART',
            'SEND_CART_IN_DELIVERY',
            'DELETE_PRODUCT_FROM_CART_FOR_USER',
            'SELECTED_ALL_PRODUCTS_FOR_USERS',
            'SELECTED_INFO_POINT_DELIVERY',
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
            this.SEND_CART_IN_DELIVERY(this.ALL_PRODUCTS_IN_CART)
        }
    }
    }
</script>

<style>
    li {
        list-style: none;
    }
</style>