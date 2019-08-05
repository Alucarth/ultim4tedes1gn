
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');

  require('bootstrap');
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * IMPORTANTE 
 * Sea globalmente el axios baseURL este se obtiene de las variables MIX_
 * que se encuentra en el archivo .env de las confiruaciones de laravel
 * para que este haga efecto a los nuevos cambios se deve volver a correr npm run dev.
 */
window.axios.defaults.baseURL = process.env.MIX_SENTRY_DSN_PUBLIC; 

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

//window.axios.defaults.headers.common['Authorization'] = 'Bearer '+localStorage.getItem('token');


import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import App from './views/App';
import {storage} from './store_modules/storage';
import {autentication} from './store_modules/autentication';


window.Vue = require('vue');
window.numeral = require('numeral');
window.moment = require('moment');
window.Chart = require('chart.js');
window.Swal = require('sweetalert2');

Vue.use(VueRouter)
Vue.use(Vuetify);
Vue.use(Vuex);


Vue.prototype.$http = axios;
const tokenJWT = localStorage.getItem('token')
if (tokenJWT) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = tokenJWT
}
const store = new Vuex.Store({
    modules:{
        template: storage,
        auth: autentication,
        dconfirm: confirm,
    }
});

const router = new VueRouter({
    mode: 'history',
    routes: routes
});
// const confirm = create(Confirm, 'title', 'content');
router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {//add is login aqui
      if (store.getters['auth/isLoggedIn']) {
        next()
        return
      }
      next('/login') 
    } else {
      next() 
    }
});
// ejemplo de vue router
// router.beforeEach((to,from,nwt)=>{
//   if(!to.meta.isPublic && !isAuthenticated()){
//     return next('/login');
//   }
//   if (to.name ==='login' && isAuthenticated()){
//     return next('/');
//   }
//   return next();
// });

// adicionar roles y permisos en el tokken


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
    data: {
        themeColor: '#1D2939',
        userEmail: 'ltorrezs2008@gmail.com',
        userPassword: '123456'
    }
    // confirm
  });
  
