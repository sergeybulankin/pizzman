export default {
    actions: {
        SELECTED_ALL_CATEGORIES(ctx) {
            axios.get('/api/selected-categories')
                .then( res => { ctx.commit('CATEGORIES_MUTATION', res.data.data) } )
                .catch( error => {console.log(error)} )
        }
    },
    mutations: {
        CATEGORIES_MUTATION(state, category) {
            state.categories = category
        }
    },
    state: {
        categories: []
    },
    getters: {
        ALL_CATEGORIES(state) {
            return state.categories
        }
    }
}