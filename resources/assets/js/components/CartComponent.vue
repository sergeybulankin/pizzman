<template>
    <div>
        <h1>Корзина</h1>
        <div>
            <span v-for="product in cart">{{ product }}</span>
        </div>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                cart: []
            }
        },
        mounted() {
            if(localStorage.cart) {
                this.cart = localStorage.cart;
            }
        },
        computed: {

        },
        watch: {
            cart() {
                console.log('WATCH')
            }
        }
    }
</script>