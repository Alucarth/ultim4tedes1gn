
import Home from './views/Home';
import Provider from './views/Provider';
import Login from './components/auth/Login';


   
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
            path: '/login',
            name: 'Login',
            component: Login
        }
        
        
    ];
  