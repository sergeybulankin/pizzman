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
        },

        SELECTION_BY_CATEGORY(ctx, id) {
            axios.post('/api/selection-by-category', {id: id})
                .then( res => {ctx.commit('SELECTED_PRODUCTS_BY_CATEGORY', res.data.data)})
                .catch (error => (console.log(error)));
        }
    },
    mutations: {
        FOOD_PlACEMENT_IN_STORAGE(state, products) {
            state.products = products
        },

        SELECTED_PRODUCTS_BY_CATEGORY(state, products) {
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