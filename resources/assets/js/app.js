
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./inspinia');
require('./bootstrap');
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import Notifications from 'vue-notification';
import App from './views/App';
import {storage} from './store_modules/storage';
import {autentication} from './store_modules/autentication';


window.$ = window.jQuery = require('jquery')
window.Vue = require('vue');
Vue.use(Notifications);
Vue.use(VueRouter)
Vue.use(Vuetify);
Vue.use(Vuex);

const store = new Vuex.Store({
    modules:{
        template: storage,
        auth: autentication,
    }
});
const router = new VueRouter({
    mode: 'history',
    routes: routes
});

//proteccion de rutas
router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
      if (store.getters['auth/isLoggedIn']) {
        next()
        return
      }
      next('/login') 
    } else {
      next() 
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
  });
  
