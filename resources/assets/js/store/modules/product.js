export default {
    actions: {
        CATALOG_PRODUCTS(ctx) {
            axios.get('/api/catalog-products')
                .then(response => { ctx.commit('CATALOG_PRODUCTS_MUTATIONS', response.data.data) })
                .catch( error => { console.log(error)})
        },

        SELECTED_ALL_PRODUCTS(ctx) {
            axios.get('/api/selected-all-products')
                .then(response => { ctx.commit('FOOD_PlACEMENT_IN_STORAGE', response.data.data) })
                .catch( error => { console.log(error) })
        },

        SELECTED_ALL_PRODUCTS_FOR_USERS(ctx) {
            axios.get('/api/selected-all-products-for-users')
                .then(response => { ctx.commit('SELECTED_ALL_PRODUCTS_FOR_USERS_MUTATION', response.data) })
                .catch( error => { console.log(error) })
        },

        SELECTION_BY_CATEGORY(ctx, id) {
            axios.post('/api/selection-by-category', {id: id})
                .then( res => {ctx.commit('SELECTED_PRODUCTS_BY_CATEGORY', res.data.data)})
                .catch (error => (console.log(error)));
        },

        ADD_TO_DATABASE_FROM_LOCAL_STORAGE(ctx, cart) {
            axios.post('/api/add-to-database-from-cart', {cart: cart})
                .then(response => { console.log('Товар добавился') })
                .catch (error => (console.log(error)));
        }
    },
    mutations: {
        FOOD_PlACEMENT_IN_STORAGE(state, products) {
            state.products = products
        },

        SELECTED_PRODUCTS_BY_CATEGORY(state, products) {
            state.products = products
        },

        SELECTED_ALL_PRODUCTS_FOR_USERS_MUTATION(state, products) {
            state.cart = products;
            localStorage.setItem('cart', JSON.stringify(products));

        },

        CATALOG_PRODUCTS_MUTATIONS(state, products) {
            state.catalog = products;
        }
    },
    state: {
        products: [],
        catalog: [],
        cart: localStorage.getItem('cart')
    },
    getters: {
        ALL_PRODUCTS(state) {
            return state.products
        },

        CATALOG(state) {
            return state.catalog
        }

    }
}