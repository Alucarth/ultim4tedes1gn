
import Home from './views/Home';

import ProviderList from './components/provider/Index';
import Login from './components/auth/Login';
import Lumber from './components/lumber/index2.vue';


   
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
            name: 'Provider',
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
            component: Lumber
        },
        {
            path: '/type',
            name: 'Type',
            component: Lumber
        },
        
    ];
    