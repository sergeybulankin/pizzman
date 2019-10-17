<template>
    <div>
        <h1>Корзина</h1>
        <div>{{ cart }}</div>
        <div v-for="(product, index) in productsInCart" class="cart" :key="product.id">
            <span class="delete-product-in-cart" @click="deleteProductFromCart(index)">X</span>
            <span>{{ product.product_title }}</span>
        </div>
        <div class="total">Всего товаров: {{ total }}</div>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                productsInCart: []
            }
        },
        mounted() {
            this.selectedProductsInCart();
        },
        computed: {
            total() {
                this.selectedProductsInCart();
                return this.cart.length;
            }
        },
        methods: {
            selectedProductsInCart() {
                axios.post('/api/selected-products-in-cart', {cart: this.cart})
                    .then( res => { this.productsInCart = res.data })
                    .catch( error => { console.log(error) })
            },
            deleteProductFromCart(id) {
                this.cart.splice(id, 1);
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