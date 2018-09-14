
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./inspinia');
require('./bootstrap');
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';

window.Vue = require('vue');
Vue.use(VueRouter)
Vue.use(Vuetify);


import App from './views/App';
import Home from './views/Home';
import Provider from './views/Provider';

import Lumber from './components/lumber/index.vue';
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/provider',
            name: 'provider',
            component: Provider
        },
        {
            path: '/lumber',
            name: 'lumber',
            component: Lumber
        }        
    ],
  });
  

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('lumber-index', Lumber);

const app = new Vue({
    el: '#app',
    components: { App },
    router,
  });
  
