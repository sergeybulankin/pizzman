export default {
    actions: {
        SELECTED_PRODUCTS_IN_CART(ctx, cart) {
            axios.post('/api/selected-products-in-cart', {cart: cart})
                .then( res => { ctx.commit('PRODUCTS_IN_CART', res.data) })
                .catch( error => { console.log(error) })
        },

        COUNTING_TOTAL_PRICE(ctx) {
            ctx.commit('TOTAL_PRICE')
        },

        COUNTING_TOTAL_WEIGHT(ctx) {
            ctx.commit('TOTAL_WEIGHT')
        },

        SEND_CART_IN_DELIVERY(ctx, cart, u_id = Date.now()) {
            var type = localStorage.type[1];
            var point = localStorage.pointsDelivery[1];

            axios.post('/api/post-cart-in-delivery', {order: cart, u_id: u_id, type: type, point: point })
                .then(
                    setTimeout( () => window.location.href = '/delivery/' + u_id, 1000)
                    )
                .catch( error => { console.log(error) })
        },

        DELETE_PRODUCT_FROM_CART_FOR_USER(ctx, cart_id) {
            axios.post('/api/delete-product-from-cart', {id: cart_id})
                .then(res => { console.log('Товар удален')  })
                .catch (error => {console.log(error)})
        }
    },
    mutations: {
        PRODUCTS_IN_CART(state, productsInCart) {
            state.productsInCart = productsInCart
            _.groupBy(state.productsInCart, "u_id")
        },

        MINUS(state, index) {
            state.productsInCart[index].food.count--
        },

        PLUS(state, index) {
            state.productsInCart[index].food.count++
        },

        POSITIVE_NUMBERS(state, index) {
            if (state.productsInCart[index].food.count < 1)
                state.productsInCart[index].food.count = 1
        },

        COUNT_PRICE_FOR_PRODUCT_MUTATION(state, index) {
            let additive_price = [];

            _.each(state.productsInCart[index].additive, (additives) => {
                _.each(additives, (additive) => {
                    additive_price[index] = additive.price*state.productsInCart[index].food.count
                })
            })

            state.additivePrice[index] = additive_price[index];
        },

        TOTAL_PRICE(state) {
            let total = [];

            _.each(state.productsInCart, (entry) => {
                total.push(entry.food.price*entry.food.count);

                _.each(entry.additive, (additives) => {
                    _.each(additives, (additive) => {
                        total.push(additive.price*entry.food.count)
                    })
                })
            })
            state.total_price = total.reduce((total, num) => { return total + num }, 0);
        },

        TOTAL_WEIGHT(state) {
            let total = [];

            _.each(state.productsInCart, (entry) => {
                total.push(entry.food.weight*entry.food.count);
            })
            state.total_weight = total.reduce((total, num) => { return total + num }, 0);
        },

        LOADER_CLOSED_MUTATION(state) {
            state.loading = false
        }
    },
    state: {
        productsInCart: [],
        total_price: 0,
        total_weight: 0,
        additivePrice: []
    },
    getters: {
        ALL_PRODUCTS_IN_CART(state) {
            return state.productsInCart
        },

        TOTAl_PRICE_CART(state) {
            return state.total_price
        },

        TOTAl_WEIGHT_CART(state) {
            return state.total_weight
        },

        ADDITIVE_PRICE(state) {
            return state.additivePrice
        }
    }
}