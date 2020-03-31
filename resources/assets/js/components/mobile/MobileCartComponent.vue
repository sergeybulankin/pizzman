<template>
    <div class="d-flex justify-content-around bd-highlight footer_fixed_main fixed-bottom">
        <div class="p-2">
            <a href="/">
                <button class="btn footer-icon"><i class="fa fa-home"></i>Главная</button>
            </a>
        </div>
        <div class="p-2">
            <a href="/favorites">
                <button class="btn footer-icon">
                    <span class="count">{{ totalFavorite }}</span>
                    <i class="fa fa-heart"></i>Избранное
                </button>
            </a>

        </div>
        <div class="p-2">
            <a href="/cart">
                <button class="btn footer-icon">
                    <span class="count"> {{ totalProducts }} </span>
                    <i class="fa fa-shopping-cart"></i>Корзина
                </button>
            </a>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        computed: {
            totalProducts() {
                this.SELECTED_PRODUCTS_IN_CART(this.cart);
                return this.cart.length;
            },

            totalFavorite() {
                return this.favorite.length;
            }
        },

        methods: {
            ...mapActions([
                'SELECTED_PRODUCTS_IN_CART'
            ])
        }
    }
</script>


<style>
    .load {
        text-align: center;
    }

    .heart-red {
        color: red;
    }
</style>