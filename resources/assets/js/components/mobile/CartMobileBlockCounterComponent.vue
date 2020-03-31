<template>
    <button class="navbar-toggler" type="button" data-toggle="modal" data-target="#menu-mobil">
        <span class="navbar-toggler-icon fa fa-shopping-cart"></span>
        <span class="mobile-count">{{ totalProducts }}</span>
    </button>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        computed: {
            totalProducts() {
                this.SELECTED_PRODUCTS_IN_CART(this.cart);
                return this.cart.length;
            }
        },

        methods: {
            ...mapActions([
                'SELECTED_PRODUCTS_IN_CART'
            ])
        }
    }
</script>