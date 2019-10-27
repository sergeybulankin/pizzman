<template>
    <div>
        <h1>Корзина</h1>
        <form @submit.prevent="sendCartInDelivery()" id="form">
            <div v-for="(product, index) in productsInCart" class="cart" :key="product.id">

                <span class="delete-product-in-cart" @click="deleteProductFromCart(index)">X</span>
                <span>{{ product.product_title }}</span>

                <span class="minus-count"  @click="product.count--">-</span>
                <span class="final-count" v-if="product.count >= 1">{{ product.count }}</span>
                <span class="final-count" v-else>{{ product.count = 1 }}</span>
                <span class="plus-count" @click="product.count++">+</span>

                <span class="totalPriceProduct">{{ product.count * product.price }}</span>
            </div>
            <div class="total">Всего товаров: {{ totalProducts }} стоимостью <strong>{{ totalPrice }}</strong> рублей</div>

            <div class="btn">
                <button type="submit">Оформить</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                productsInCart: [],

                u_id: Date.now()
            }
        },
        mounted() {
            this.selectedProductsInCart();
        },
        computed: {
            totalProducts() {
                this.selectedProductsInCart();
                return this.cart.length;
            },

            totalPrice() {
                let total = [];

                this.productsInCart.forEach((key, value) => {
                    total.push(key.price * key.count);
                });

                return total.reduce((total, num) => { return total + num }, 0);
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
            },

            sendCartInDelivery() {
                axios.post('/api/post-cart-in-delivery', {order: this.productsInCart, u_id: this.u_id})
                    .then( console.log('Заказ оформлен'),
                            setTimeout( () => window.location.href = '/delivery/' + this.u_id, 1000)
                        )
                    .catch( error => { console.log(error) })
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
    .minus-count {
        padding-left: 50px;
        font-size: 25px;
        cursor: pointer;
    }
    .plus-count {
        font-size: 25px;
        cursor: pointer;
    }
    .final-count {
        padding: 0 15px;
        text-align: center;
    }
    .totalPriceProduct {
        padding-left: 50px;
        font-weight: 600;
    }
    .btn button{
        width: 250px;
        background-color: black;
        color: white;
        margin: 15px 0;
        padding: 15px;
        text-align: center;
        cursor: pointer;
    }
</style>