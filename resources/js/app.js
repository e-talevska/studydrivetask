
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
import Vuelidate from 'vuelidate';

Vue.use(Vuelidate);
Vue.use(VueRouter);


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
            path: '/board',
            name: 'board',
            component: ListImages,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App, Pagination },
    router,
});