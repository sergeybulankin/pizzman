<template>
    <div>
        <h1>Корзина</h1>
        <div>{{ cart }}</div>
        <div v-for="(product, index) in ALL_PRODUCTS_IN_CART" class="cart" :key="product.id">
            <span class="delete-product-in-cart" @click="deleteProductFromCart(index, product.id)">X - {{ index }}</span>
            <span>{{ product.product_title }}</span>
        </div>
        <div class="total">Всего товаров: {{ totalProducts }} стоимостью <strong>{{ TOTAL_PRICE }}</strong> рублей</div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default{
        mounted() {
            this.SELECTED_PRODUCTS_IN_CART(this.cart);
        },
        computed: {
            ...mapGetters(['ALL_PRODUCTS_IN_CART', 'TOTAL_PRICE']),

            totalProducts() {
                this.SELECTED_PRODUCTS_IN_CART(this.cart);
                return this.cart.length;
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


<style>
    .cart {
        width: 350px;
        padding: 15px;
        background-color: #a6e1ec;
    }
    .delete-product-in-cart {
        font-size: 15px;
        font-weight: 600;
        font-family: "Arial", sans-serif;
        cursor: pointer;
    }
</style>