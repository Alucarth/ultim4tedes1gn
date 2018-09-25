
import Home from './views/Home';
import Provider from './views/Provider';
import ProviderList from './components/provider/Index';
import Login from './components/auth/Login';
import Lumber from './components/lumber/index2.vue';
import Specie from './components/specie/index.vue';
import Storage from './components/storage/index.vue';

   
   export const routes= [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta:{
               // requireAuth:true
            }
        },
        {
            path: '/provider',
            name: 'provider',
            component: Provider,
            meta:{
          //      requireAuth:true
            }
        },
        {
            path: '/providers',
            name: 'providers',
            component: ProviderList,
            meta:{
            //    requireAuth:true
            }
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/lumber',
            name: 'Lumber',
            component: Lumber
        },
        {
            path: '/getLumberData',
            name: 'GetLumberData',
            component: Lumber
        },
        {
            path: '/specie',
            name: 'Specie',
            component: Specie
        },
        {
            path: '/type',
            name: 'Type',
            component: Lumber
        },
        {
            path: '/storage',
            name: 'Storage'    ,
            component: Storage
        }
        
    ];
    