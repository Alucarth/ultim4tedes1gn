
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
import StoreData from './store';
import {routes} from './routes';
window.Vue = require('vue');
Vue.use(VueRouter)
Vue.use(Vuetify);
Vue.use(Vuex);

const store = new Vuex.Store(StoreData);
const router = new VueRouter({
        routes,
        mode: 'history'
});
import App from './views/App';
  
router.beforeEach((to,from,next)=>{
    const requireAuth = to.matched.some(record=>record.meta.requireAuth);
    const currenUser = store.state.currentUser;

    if(requireAuth && !currenUser){
        next('/login');
    }else if(to.path == '/login' && currenUser)
    {
        next ('/');
    }else{
        next();
    }
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('lumber-index', require('./components/lumber/index.vue'));

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
  });
  
