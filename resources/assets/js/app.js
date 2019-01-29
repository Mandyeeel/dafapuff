
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//載入vue元件
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here


Vue.use(VueMaterial);

Vue.component('admin-basic', require('./components/AdminBasic.vue'));
Vue.component('list-container', require('./components/ListContainer.vue'));
Vue.component('stock-list', require('./components/StockList.vue'));

const app = new Vue({
    el: '#app'
});
