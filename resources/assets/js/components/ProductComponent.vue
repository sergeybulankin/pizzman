<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body" v-for="(product, index) in ALL_PRODUCTS" :key="product.id">
                        <div class="title">{{ product.title }} - {{ product.id }}</div>

                        <div class="description">{{ product.description }}</div>

                        <div class="price">{{ product.price }}</div>

                        <div :class="'add-product-id-' + product.id">
                            <div class="add-to-cart" @click="changeProduct(product.id)">Добавить</div>
                        </div>

                        <div :class="'delete-product-id-' + product.id">
                            <div class="delete-from-cart">Продукт в корзине</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        created() {
            this.SELECTED_ALL_PRODUCTS();
        },
        mounted() {
            setTimeout (() => { this.CHECK_PRODUCT_IN_CART(this.cart) }, 1000)
        },
        computed: mapGetters(['ALL_PRODUCTS']),
        methods: {
            ...mapActions(['SELECTED_ALL_PRODUCTS', 'CHECK_PRODUCT_IN_CART', 'CHANGE_PRODUCTS']),

            changeProduct(id) {
                this.cart.push(id);

                $(".add-product-id-" + id).css("display", "none");
                $(".delete-product-id-" + id).css("display", "block");
            }
        }
    }
</script>


<style>
    .panel {
        display: flex;
        flex-wrap: wrap;
    }
    .panel-body {
        background-color: yellow;
        width: 300px;
        margin: 30px 0 0 30px;
        padding: 15px;
        flex-direction: row;
    }
    .title {
        margin: 10px 0;
        font-size: 30px;
        font-weight: 600;
    }
    .description {
        margin: 15px 0;
        font-size: 15px;
    }
    .price {
        font-size: 20px;
        color: red;
    }
    .add-to-cart {
        margin: 20px 0 0 0;
        background: black;
        padding: 10px;
        text-align: center;
        color: white;
        cursor: pointer;
    }
    .delete-from-cart {
        margin: 20px 0 0 0;
        background: #a2a2a2;
        padding: 10px;
        text-align: center;
        color: white;
        cursor: pointer;
    }
    .add-to-cart:hover {
        background-color: white;
        color: black;
    }
    [class^="delete-product-id-"] {
        display: none;
    }
</style>