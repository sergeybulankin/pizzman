export default {
    actions: {
        SELECTED_ALL_CATEGORIES(ctx) {
            axios.get('/api/selected-categories')
                .then( res => { ctx.commit('CATEGORIES', res.data.data) } )
                .catch( error => {console.log(error)} )
        }
    },
    mutations: {
        CATEGORIES(state, category) {
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