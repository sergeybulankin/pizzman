export default {
    actions: {
        CATALOG_PRODUCTS(ctx) {
            axios.get('/api/catalog-products')
                .then(response => { ctx.commit('CATALOG_PRODUCTS_MUTATIONS', response.data.data) })
                .catch( error => { console.log(error)})
                .finally (() => { ctx.commit('LOADER_CLOSED_MUTATION') })
        },

        SELECTED_ALL_PRODUCTS(ctx) {
            axios.get('/api/selected-all-products')
                .then(response => { ctx.commit('FOOD_PlACEMENT_IN_STORAGE', response.data.data) })
                .catch( error => { console.log(error) })
                .finally (() => { ctx.commit('LOADER_CLOSED_MUTATION') })
        },

        SELECTED_ALL_PRODUCTS_FOR_USERS(ctx) {
            axios.get('/api/selected-all-products-for-users')
                .then(response => { ctx.commit('SELECTED_ALL_PRODUCTS_FOR_USERS_MUTATION', response.data) })
                .catch( error => { console.log(error) })
        },

        SELECTION_BY_CATEGORY(ctx, id) {
            axios.post('/api/selection-by-category', {id: id})
                .then( res => {ctx.commit('SELECTED_PRODUCTS_BY_CATEGORY', res.data.data)})
                .catch (error => (console.log(error)))
                .finally (() => { ctx.commit('LOADER_CLOSED_MUTATION') })
        },

        ADD_TO_DATABASE_FROM_LOCAL_STORAGE(ctx, food) {
            axios.post('/api/add-to-database-from-cart', {food: food})
                .then(response => { console.log('Товар добавился') })
                .catch (error => (console.log(error)));
        },

        HIT_SALES(ctx) {
            axios.get('/api/hit-sales')
                .then(res => {ctx.commit('HIT_SALES_MUTATION', res.data.data)})
                .catch(error => {console.log(error)})
        },

        SELECTED_ALL_PRODUCTS_FOR_POINT(ctx, point) {
            axios.post('/api/selected-food-for-point', {point: point})
                .then(res => {ctx.commit('FOOD_PlACEMENT_IN_STORAGE', res.data.data)})
                .catch(error => {console.log(error)})
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
        },

        CATALOG_PRODUCTS_MUTATIONS(state, products) {
            state.catalog = products;
        },

        LOADER_CLOSED_MUTATION(state) {
            state.loading = false
        },

        HIT_SALES_MUTATION(state, hit) {
            state.hits = hit;
        }
    },
    state: {
        products: [],
        catalog: [],
        cart: [],
        hits: [],
        loading: true
    },
    getters: {
        ALL_PRODUCTS(state) {
            return state.products
        },

        CATALOG(state) {
            return state.catalog
        },

        CART_FOR_USER(state) {
            return state.cart
        },

        HITS(state) {
            return state.hits
        },

        LOADER(state) {
            return state.loading
        }
    }
}