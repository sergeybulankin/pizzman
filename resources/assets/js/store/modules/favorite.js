export default {
    actions: {
        SELECT_ALL_FAVORITE(ctx) {
            axios.get('/api/select-all-favorite')
                .then(response => { ctx.commit('SELECT_ALL_FAVORITE_MUTATION', response.data.data) })
                .catch( error => {console.log(error)} )
        },

        ADD_TO_FAVORITE(ctx, product) {
            axios.post('/api/add-to-favorite', {product: product})
                .then(response => { ctx.commit('ADD_TO_FAVORITE_MUTATION', response.data.data) })
                .catch(error => { console.log(error) })
        },

        DELETE_OF_FAVORITE(ctx, product) {
            axios.post('/api/delete-of-favorite', {product: product})
                .then(response => { ctx.commit('DELETE_OF_FAVORITE_MUTATION', response.data.data) })
                .catch(error => { console.log(error) })
        },

        CHECK_PRODUCT_IN_FAVORITE(ctx, favorite) {
            favorite.forEach((key, value) => {
                $(".favorite-" + key.product).css("display", "none");
                $(".delete-favorite-" + key.id).css("display", "block");
            });
        },

        COUNT_PRODUCTS_IN_FAVORITE(ctx, favorite) {
            axios.get('/api/count-favorites', {favorite: favorite})
                .then(response => { ctx.commit('COUNT_PRODUCTS_IN_FAVORITE_MUTATION', response.data) })
                .catch(error => { console.log(error) })
        }
    },
    mutations: {
        ADD_TO_FAVORITE_MUTATION(state, product) {
            state.favorite = product
        },

        DELETE_OF_FAVORITE_MUTATION(state, product) {
            state.favorite = product
        },

        SELECT_ALL_FAVORITE_MUTATION(state, favorite) {
            state.favorite = favorite
        },

        COUNT_PRODUCTS_IN_FAVORITE_MUTATION(state, favorite) {
            state.count = favorite
        }
    },
    state: {
        favorite: [],
        count: 0
    },
    getters: {
        ALL_FAVORITE(state) {
            return state.favorite
        },

        COUNT(state) {
            return state.count
        }
    }
}