export default {
    actions: {
        SELECTED_POINTS_DELIVERY(ctx) {
            axios.get('/api/selected-points')
                .then( res => { ctx.commit('SELECTED_POINTS_DELIVERY_MUTATION', res.data.data) } )
                .catch( error => {console.log(error)} )
        },

        SELECTED_INFO_POINT_DELIVERY(ctx, point) {
            axios.post('/api/selected-info-point', {point: point})
                .then(res => {ctx.commit('SELECTED_INFO_POINT_DELIVERY_MUTATION', res.data.data)})
                .catch(error => {console.log(error)});
        }
    },
    mutations: {
        SELECTED_POINTS_DELIVERY_MUTATION(state, points) {
            state.points = points
        },

        SELECTED_INFO_POINT_DELIVERY_MUTATION(state, point) {
            state.points = point
        }
    },
    state: {
        points: []
    },
    getters: {
        ALL_POINTS_DELIVERY(state) {
            return state.points
        },

        POINT_INFO(state) {
            return state.points
        }
    }
}