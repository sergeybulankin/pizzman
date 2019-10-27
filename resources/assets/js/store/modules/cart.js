export default {
    actions: {
        SELECTED_PRODUCTS_IN_CART(ctx, cart) {
            axios.post('/api/selected-products-in-cart', {cart: cart})
                .then( res => { ctx.commit('PRODUCTS_IN_CART', res.data) })
                .catch( error => { console.log(error) })
        }
    },
    mutations: {
        PRODUCTS_IN_CART(state, productsInCart) {
            state.productsInCart = productsInCart
        }
    },
    state: {
        productsInCart: []
    },
    getters: {
        ALL_PRODUCTS_IN_CART(state) {
            return state.productsInCart
        },

        TOTAL_PRICE(state) {
            let total = [];

            state.productsInCart.forEach((key, value) => {
                total.push(key.price);
        });

            return total.reduce((total, num) => { return total + num }, 0);
        }
    }
}