
import Nav from './components/layout/Nav';
import Toolbar from './components/layout/Toolbar';
import Home from './views/Home';

import ProviderList from './components/provider/Index';
import Login from './components/auth/Login';
import Lumber from './components/lumber/index2.vue';
import Specie from './components/specie/index.vue';
import Storage from './components/storage/index.vue';
import Purchase from './components/purchase/index.vue';
import Buyout from './components/purchase/indexInventory.vue';
import EditPurchase from './components/purchase/edit.vue';
import EditBuyout from './components/purchase/editInventory.vue';
import Package from './components/package/index.vue';
import EditPackage from './components/package/edit.vue';
import TransferPackage from './components/package/transfer.vue';
import TransferInventory from './components/inventory/transfer.vue';
import ConsumeInventory from './components/inventory/consume.vue';
import Employee from './components/employee/index.vue';
import Inventory from './components/inventory/indexInventory.vue';

import ExcelImport from './components/package/Import.vue';
import ExcelImportPurchases from './components/purchase/import.vue';

import LumberTransaction from './components/lumber/transaction.vue';
import Expensive from './components/expensive/index.vue';
import OriginTypes from './components/origin_type/index.vue';
import OfferTypes from './components/offer_type/index.vue'
import Client from './components/client/index.vue'
import ShowClient from './components/client/show.vue'
import ShowOrder from './components/order/show.vue'
import Construction from './components/construction/index.vue'
import Product from './components/product/index.vue'
import Order from './components/order/index.vue'
import Contract from './components/contract/index.vue'
import Position from './components/position/index.vue'
import Area from './components/area/index.vue'
import Task from './components/task/index.vue'
import EmployeeType from './components/employee_type/index.vue'
import EmployeeContractType from './components/employee_contract_type/index.vue'
import EmployeeWork from './components/employee_work/index.vue'

import ProductType from './components/product_type/index.vue'
import Asset from './components/asset/index.vue'

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
            path: '/buyout',
            name: 'Buyout',
            components:{
                default:Buyout,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        // {
        //     path: '/purchase/create',
        //     name: 'PurchaseEdit',
        //     components:{
        //         default:EditPurchase,
        //         toolbar:Toolbar,
        //         nav: Nav
        //     },
        //     meta: {
        //         requiresAuth: true
        //     }
        // },
        {
            path: '/create_purchase',
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
            path: '/buyout/create',
            name: 'BuyoutEdit',
            components:{
                default:EditBuyout,
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
            path: '/inventory/transfer/:id',
            name: 'inventoryTransfer',
            components:{
                default:TransferInventory,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/inventory/consume/:id',
            name: 'inventoryConsume',
            components:{
                default:ConsumeInventory,
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
        {
            path: '/getInventoryData',
            name: 'GetInventoryData',
            components:{
                default:Inventory,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/lumber_transaction',
            name: 'LumberTransaction',
            components:{
                default:LumberTransaction,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/expenses',
            name: 'expenses',
            components:{
                default:Expensive,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/origin_types',
            name: 'origin_types',
            components:{
                default:OriginTypes,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/offer_types',
            name: 'offer_types',
            components:{
                default:OfferTypes,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/client',
            name: 'Client'    ,
            components:{
                default:Client,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/client/:id',
            name: 'ShowClient'    ,
            components:{
                default:ShowClient,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/order/:id',
            name: 'ShowOrder',
            components:{
                default:ShowOrder,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/construction',
            name: 'Construction',
            components:{
                default:Construction,
                toolbar:Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/product',
            name: 'Product',
            components: {
                default: Product,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/order',
            name: '/Order',
            components: {
                default: Order,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/contract',
            name: '/Contract',
            components: {
                default: Contract,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/position',
            name: '/position',
            components: {
                default: Position,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/area',
            name: '/area',
            components: {
                default: Area,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/employee_type',
            name: '/employee_type',
            components: {
                default: EmployeeType,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/employee_contract_type',
            name: '/employee_contract_type',
            components: {
                default: EmployeeContractType,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/task',
            name: '/task',
            components: {
                default: Task,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/asset',
            name: '/asset',
            components: {
                default: Asset,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/product_type',
            name: '/product_type',
            components: {
                default: ProductType,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        },
        {
            path: '/employee_work/:id',
            name: '/employee_work',
            components: {
                default: EmployeeWork,
                toolbar: Toolbar,
                nav: Nav
            },
            meta: {
                requiresAuth: true
            }
        }
    ];
