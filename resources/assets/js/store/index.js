import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

Vue.config.debug = true;

const debug = process.env.NODE_ENV !== 'production';

import product from './modules/product';
import cart from './modules/cart';
import categories from './modules/category';
import favorite from './modules/favorite';
import register from './modules/register';

export default new Vuex.Store({
    modules: {
        product,
        cart,
        categories,
        favorite,
        register
    },
    strict: debug
});