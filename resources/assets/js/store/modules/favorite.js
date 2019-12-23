export default {
    actions: {
        SELECT_ALL_FAVORITE(ctx, favorite) {
            axios.post('/api/select-all-favorite', {favorite: favorite})
                .then(response => { ctx.commit('SELECT_ALL_FAVORITE_MUTATION', response.data) })
                .catch( error => {console.log(error)} )
        },

        SELECT_ALL_FAVORITE_FOR_USERS(ctx) {
            axios.post('/api/select-all-favorite-for-users')
                .then(response => { ctx.commit('SELECT_ALL_FAVORITE_FOR_USERS_MUTATION', response.data.data) })
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
            favorite.forEach((value, key) => {
                $(".favorite-" + value).addClass("d-none");
                $(".delete-favorite-" + value).removeClass("d-none");
            });
        }
    },
    mutations: {
        ADD_TO_FAVORITE_MUTATION(state, product) {
            state.favorite = product
        },

        DELETE_OF_FAVORITE_MUTATION(state, product) {
            state.favorite = product
        },

        SELECT_ALL_FAVORITE_FOR_USERS_MUTATION(state, favorite) {
            _.each(favorite, (value, key) => {
                state.favorite.push(value.food_id)
            })
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