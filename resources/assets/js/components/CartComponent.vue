<template>
    <div style="position: relative" class="d-flex" onmouseover="get_cart(this)" onmouseout="close_cart(this)">
        <a class="cart d-flex" href="http://laravel.arimle.ru/shopping_basket" >
            <span class="count">{{ totalProducts }}</span>
            <i class="fa fa-shopping-cart" ></i>
            <div class="amount pt-0">{{ totalPrice }} <i class="fa fa-rub"></i></div>
        </a>

        <div id='cart_info' class="d-none">
            <ul>
                <li class="d-flex" v-for="(product, index) in ALL_PRODUCTS_IN_CART" :key="product.id">
                    <div class="delete_icon">
                        <img src="images/delete_icon.svg" @click="deleteProductFromCart(index, product.id)"/>
                    </div>

                    <div class="photo-small">
                        <img src="images/demo.jpg" class="img-fluid">
                    </div>
                    <div class="description">
                        <a><b>{{ product.product_title }}</b></a><p><small>1x{{ product.price }} <i class="fa fa-rub"></i></small></p>
                    </div>
                </li>
            </ul>

            <div class="d-flex justify-content-between subtutorial">
                <strong>Итого:</strong>
                <p><b>{{ totalPrice }} <i class="fa fa-rub mr-0"></i></b></p>
            </div>

            <div class="d-flex justify-content-around">
                <a href="/cart"><button class="btn btn-default">Корзина</button></a>
                <a href="http://laravel.arimle.ru/checkout"><button class="btn btn-success">Оформить заказ</button></a>
            </div>

        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default{
        mounted() {
            this.SELECTED_PRODUCTS_IN_CART(this.cart);
        },
        computed: {
            ...mapGetters(['ALL_PRODUCTS_IN_CART']),

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
            ...mapActions(['SELECTED_PRODUCTS_IN_CART']),

            deleteProductFromCart(index, id) {
                this.cart.splice(index, 1);

                $(".delete-product-id-" + id).css("display", "none");
                $(".add-product-id-" + id).css("display", "block");
            }
        }
    }
</script>