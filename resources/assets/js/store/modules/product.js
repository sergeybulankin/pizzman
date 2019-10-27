export default {
    actions: {
        SELECTED_ALL_PRODUCTS(ctx) {
            axios.get('/api/selected-all-products')
                .then(response => { ctx.commit('FOOD_PlACEMENT_IN_STORAGE', response.data.data) })
                .catch( error => { console.log(error) })
        },

        CHECK_PRODUCT_IN_CART(ctx, cart) {
            cart.forEach((key, value) => {
                $(".add-product-id-" + key).css("display", "none");
                $(".delete-product-id-" + key).css("display", "block");
            });
        }
    },
    mutations: {
        FOOD_PlACEMENT_IN_STORAGE(state, products) {
            state.products = products
        }
    },
    state: {
        products: []
    },
    getters: {
        ALL_PRODUCTS(state) {
            return state.products
        }
    }
}