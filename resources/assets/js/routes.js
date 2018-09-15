
import Home from './views/Home';
import Provider from './views/Provider';
import ProviderList from './components/provider/Index';
import Login from './components/auth/Login';
import Lumber from './components/lumber/index.vue';


   
   export const routes= [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta:{
                requireAuth:true
            }
        },
        {
            path: '/provider',
            name: 'provider',
            component: Provider,
            meta:{
                requireAuth:true
            }
        },
        {
            path: '/providers',
            name: 'providers',
            component: ProviderList,
            meta:{
                requireAuth:true
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
        }
        
        
    ];
  