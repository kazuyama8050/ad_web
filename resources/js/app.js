import Vue from 'vue';
import Router from 'vue-router';
import HeaderComponent from "./components/deliveler/HeaderComponent";
import TaskListComponent from "./components/TaskListComponent";
import DelivelerLogin from "./views/deliveler/LoginView";
import DelivelerRegister from "./views/deliveler/RegisterView";
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.bundle.min.js"
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const DELIVELER_ROOT_PATH="/deliveler"
const ADVERTISER_ROOT_PATH="/advertiser"
const ADMIN_ROOT_PATH="/admin"


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('header-component', HeaderComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Router);
window.Vue = require('vue').default;const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/tasks',
            name: 'task.list',
            component: TaskListComponent
        },
        {
            path: DELIVELER_ROOT_PATH + '/register',
            name: 'deliveler.register',
            component: DelivelerRegister
        },
        {
            path: DELIVELER_ROOT_PATH + '/login',
            name: 'deliveler.login',
            component: DelivelerLogin
        },
        {
            path: DELIVELER_ROOT_PATH + '/advertise',
            name: 'advertise.list',
            component: {
                template: '<div>aaaa</div>'
            }
        },
    ]
});

const app = new Vue({
    el: '#app',
    router
});