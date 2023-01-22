import Vue from 'vue';
import Router from 'vue-router';
import TaskListComponent from "./components/TaskListComponent";
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.bundle.min.js"

/**
 * user
 */
import UserLogin from "./views/user/LoginView";
import UserHome from "./views/user/HomeView";
import UserRegister from "./views/user/RegisterView";
import UserHeaderComponent from "./components/user/HeaderComponent";

/**
 * advertiser
 */
import AdvertiserHeaderComponent from "./components/advertiser/HeaderComponent";
import AdvertiserRegister from "./views/advertiser/RegisterView";
import AdvertiserLogin from "./views/advertiser/LoginView";
import AdvertiserHome from "./views/advertiser/HomeView";
import AdvertiserTemplateCreate from "./views/advertiser/advertise/TemplateCreateView";



/**
 * admin
 */
import AdminHeaderComponent from "./components/admin/HeaderComponent";
import AdminLogin from "./views/admin/LoginView";
import AdminHome from "./views/admin/HomeView";
import AdminUser from "./views/admin/user/UserView";
import AdminNoRegistered from "./views/admin/user/NoRegisteredView";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const USER_ROOT_PATH="/user"
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

Vue.component('user-header-component', UserHeaderComponent);
Vue.component('advertiser-header-component', AdvertiserHeaderComponent);
Vue.component('admin-header-component', AdminHeaderComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Router);
window.Vue = require('vue').default;const router = new Router({
    mode: 'history',
    routes: [
        //アフィリエイター画面
        {
            path: '/tasks',
            name: 'task.list',
            component: TaskListComponent
        },
        {
            path: USER_ROOT_PATH + '/register',
            name: 'user.register',
            component: UserRegister
        },
        {
            path: USER_ROOT_PATH + '/login',
            name: 'user.login',
            component: UserLogin
        },
        {
            path: USER_ROOT_PATH + '/home',
            name: 'user.home',
            component: UserHome
        },
        {
            path: USER_ROOT_PATH + '/advertise',
            name: 'advertise.list',
            component: {
                template: '<div>aaaa</div>'
            }
        },
        //広告主
        {
            path: ADVERTISER_ROOT_PATH + '/register',
            name: 'advertiser.register.',
            component: AdvertiserRegister
        },
        {
            path: ADVERTISER_ROOT_PATH + '/login',
            name: 'advertiser.login',
            component: AdvertiserLogin
        },
        {
            path: ADVERTISER_ROOT_PATH + '/home',
            name: 'advertiser.home',
            component: AdvertiserHome
        },
        {
            path: ADVERTISER_ROOT_PATH + '/template/create',
            name: 'advertiser.template.create',
            component: AdvertiserTemplateCreate
        },
        //管理画面
        {
            path: ADMIN_ROOT_PATH + '/login',
            name: 'admin.login',
            component: AdminLogin,
        },
        {
            path: ADMIN_ROOT_PATH + '/home',
            name: 'admin.home',
            component: AdminHome,
        },
        {
            path: ADMIN_ROOT_PATH + '/user',
            name: 'admin.user',
            component: AdminUser,
        },
        {
            path: ADMIN_ROOT_PATH + '/user/no-registered',
            name: 'admin.noRegistered',
            component: AdminNoRegistered,
        },
        {
            path: ADMIN_ROOT_PATH + '/advertise',
            name: 'admin.list',
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