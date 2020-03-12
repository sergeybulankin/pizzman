export default {
    actions: {
        SEND_SMS(ctx) {
            axios.get('/api/send-sms')
                .then( res => { ctx.commit('SEND_SMS_MUTATION', res.data.data) } )
                .catch( error => {console.log(error)} )
        },

        CHECK_CODE_SMS(ctx, data) {
            axios.post('/api/check-sms', {data: data})
                .then(console.log('Проверяем смс-код'))
                .then(res => (ctx.commit('CHECK_CODE_SMS_MUTATION', res.data)))
                .catch(error => {console.log(error)})
        }
    },
    mutations: {
        SEND_SMS_MUTATION(state, sms) {
            state.sms = sms
        },

        CHECK_CODE_SMS_MUTATION(state, answer) {
            state.answer = answer
        },
    },
    state: {
        sms: [],
        answer: []
    },
    getters: {
        SMS(state) {
            return state.sms
        },

        ANSWER(state) {
            return state.answer
        }
    }
}