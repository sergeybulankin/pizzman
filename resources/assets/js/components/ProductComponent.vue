<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body" v-for="product in products" :key="product.id">
                        <div class="title">{{ product.title }} - {{ product.id }}</div>

                        <div class="description">{{ product.description }}</div>

                        <div class="price">{{ product.price }}</div>

                        <div class="add-to-cart" @click="changeProduct(product.id)">Добавить</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: []
            }
        },
        created() {
            this.selectedAllProducts();
        },
        methods: {
            selectedAllProducts() {
                axios.get('/api/selected-all-products')
                    .then(res => { this.products = res.data.data })
                    .catch( error => { console.log(error) })
            },

            changeProduct(id) {
                this.cart.push(id);
            },

            exist(id) {
                $.each(this.cart, function(key, value) {
                    if(value == id) {
                        console.log(id)
                    }
                })
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
    .add-to-cart:hover {
        background-color: white;
        color: black;
    }
</style>