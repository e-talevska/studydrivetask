
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
var VueRouter = require('vue-router').default;

import App from './components/App';
import Welcome from './components/Welcome';
import Login from './components/Login';
import Register from './components/Register';
import Pagination from './components/Pagination';
import ListImages from './components/ListImages';
import ListItems from './components/ListItems';
import Favourite from './components/Favorite';
import Vuelidate from 'vuelidate';
import VueSilentbox from 'vue-silentbox'


Vue.use(VueSilentbox);
Vue.use(Vuelidate);
Vue.use(VueRouter);

Vue.component('Favourite', Favourite);
Vue.component('Pagination', Pagination);
Vue.component('ListItems', ListItems);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Welcome
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/listimages',
            name: 'listimages',
            component: ListImages,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});