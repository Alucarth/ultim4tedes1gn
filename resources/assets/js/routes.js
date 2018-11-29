
import Nav from './components/layout/Nav';
import Toolbar from './components/layout/Toolbar';
import Home from './views/Home';

import ProviderList from './components/provider/Index';
import Login from './components/auth/Login';
import Lumber from './components/lumber/index2.vue';
import Specie from './components/specie/index.vue';
import Storage from './components/storage/index.vue';
import Purchase from './components/purchase/index.vue';
import EditPurchase from './components/purchase/edit.vue';
import Package from './components/package/index.vue';
import EditPackage from './components/package/edit.vue';
import TransferPackage from './components/package/transfer.vue';
import Employee from './components/employee/index.vue';
import Inventory from './components/inventory/index.vue';

import ExcelImport from './components/package/Import.vue';
import ExcelImportPurchases from './components/purchase/import.vue';

   
   export const routes= [
        {
            path: '/',
            name: 'home',
            components:{ 
                default:Home,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
            
        },
        {
            path: '/provider',
            name: 'Provider',
            components:{ 
                default:ProviderList,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
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
            components:{ 
                default:Lumber,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/getLumberData',
            name: 'GetLumberData',
            components:{ 
                default:Lumber,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/specie',
            name: 'Specie',
            components:{ 
                default:Specie,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/type',
            name: 'Type',
            components:{ 
                default:Lumber,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/storage',
            name: 'Storage'    ,
            components:{ 
                default:Storage,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },        
        {
            path: '/purchase',
            name: 'Purchase',
            components:{ 
                default:Purchase,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/purchase/create',
            name: 'PurchaseEdit',
            components:{ 
                default:EditPurchase,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/package',
            name: 'package',
            components:{ 
                default:Package,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/package/create',
            name: 'packageEdit',
            components:{ 
                default:EditPackage,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/package/transfer',
            name: 'packageTransfer',
            components:{ 
                default:TransferPackage,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/employee',
            name: 'employee',
            components:{ 
                default:Employee,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/import_package',
            name: 'import_package',
            components:{ 
                default:ExcelImport,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/import_purchases',
            name: 'import_purchases',
            components:{ 
                default:ExcelImportPurchases,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: { 
                requiresAuth: true
            }    
        },
        {
            path: '/inventory',
            name: 'inventory',
            components: {
                default: Inventory,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
    ];
    