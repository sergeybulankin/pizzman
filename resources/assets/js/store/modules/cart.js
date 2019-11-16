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

        SEND_CART_IN_DELIVERY(ctx, cart, u_id = Date.now()) {
            axios.post('/api/post-cart-in-delivery', {order: cart, u_id: u_id })
                .then(
                    setTimeout( () => window.location.href = '/delivery/' + u_id, 1000)
                    )
                    .catch( error => { console.log(error) })
        }
    },
    mutations: {
        PRODUCTS_IN_CART(state, productsInCart) {
            state.productsInCart = productsInCart
        },

        MINUS(state, index) {
            state.productsInCart[index].count--
        },

        PLUS(state, index) {
            state.productsInCart[index].count++
        },

        POSITIVE_NUMBERS(state, index) {
            if (state.productsInCart[index].count < 1)
                state.productsInCart[index].count = 1
        },

        TOTAL_PRICE(state) {
            let total = [];

            state.productsInCart.forEach((entry) => {
                entry.food.forEach((food) => {
                    total.push(food.price*entry.count);
                })

                entry.additive.forEach((additive) => {
                    total.push(additive.price*entry.count);
                })
            });
            state.total_price = total.reduce((total, num) => { return total + num }, 0);
        }
    },
    state: {
        productsInCart: [],
        total_price: 0
    },
    getters: {
        ALL_PRODUCTS_IN_CART(state) {
            return state.productsInCart
        },

        TOTAl_PRICE_CART(state) {
            return state.total_price
        }
    }
}