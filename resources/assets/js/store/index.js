import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

Vue.config.debug = true;

const debug = process.env.NODE_ENV !== 'production';

import product from './modules/product';
import cart from './modules/cart';

export default new Vuex.Store({
    modules: {
        product,
        cart
    },
    strict: debug
});