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

        CHECK_PRODUCT_IN_FAVORITE(ctx, favorite) {
            favorite.forEach((key, value) => {
                $(".favorite-" + key.product).css("display", "none");
                $(".delete-favorite-" + key.id).css("display", "block");
            });
        },
    },
    mutations: {
        ADD_TO_FAVORITE_MUTATION(state, product) {
            state.favorite = product
        },

        SELECT_ALL_FAVORITE_MUTATION(state, favorite) {
            state.favorite = favorite
        }
    },
    state: {
        favorite: []
    },
    getters: {
        ALL_FAVORITE(state) {
            return state.favorite
        }
    }
}