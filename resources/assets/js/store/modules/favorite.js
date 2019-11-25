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
                $(".favorite-" + key).css("display", "none");
                $(".delete-favorite-" + key).css("display", "block");
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

        SELECT_ALL_FAVORITE_MUTATION(state, favorite) {
            favorite.forEach((key, value) => {
                state.favorite.push(key.food_id);
            })
            localStorage.setItem('favorite', JSON.stringify(state.favorite));
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