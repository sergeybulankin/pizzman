
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import lodash from 'lodash';
Vue.prototype._ = lodash;

import persistentState from 'vue-persistent-state';

let cartState = {
    cart: [],
    favorite: [],
    type: [],
    pointsDelivery: []
};

window.Vue.use(persistentState, cartState);

import store from './store/index';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('products', require('./components/ProductComponent.vue'));
Vue.component('cart', require('./components/CartComponent.vue'));
Vue.component('cart-detail', require('./components/CartDetailComponent.vue'));
Vue.component('category-navbar', require('./components/CategoryComponent.vue'));
Vue.component('search-address', require('./components/AddressComponent.vue'));
Vue.component('call-me', require('./components/CallMeComponent.vue'));
Vue.component('favorite', require('./components/FavoriteComponent.vue'));
Vue.component('favorite-page', require('./components/FavoritePageComponent.vue'));
Vue.component('mobile-cart', require('./components/mobile/MobileCartComponent.vue'));
Vue.component('cart-mobile-block', require('./components/mobile/CartMobileBlockComponent.vue'));
Vue.component('cart-counter', require('./components/mobile/CartMobileBlockCounterComponent.vue'));

const app = new Vue({
    el: '#app',
    store
});
