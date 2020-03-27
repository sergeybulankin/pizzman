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
        },

        CLEAR_POINT_INFO(ctx) {
            ctx.commit('CLEAR_POINT_INFO_MUTATION');
        }

    },
    mutations: {
        SELECTED_POINTS_DELIVERY_MUTATION(state, points) {
            state.points = points
        },

        SELECTED_INFO_POINT_DELIVERY_MUTATION(state, point) {
            state.point_info = point
        },

        CLEAR_POINT_INFO_MUTATION(state) {
            state.point_point = []
        }
    },
    state: {
        points: [],
        point_info: []
    },
    getters: {
        ALL_POINTS_DELIVERY(state) {
            return state.points
        },

        POINT_INFO(state) {
            return state.point_info
        }
    }
}