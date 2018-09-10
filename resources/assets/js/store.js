import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();
export default{
    state:{
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error:false,
        customers:[]

    },
    getters:{
        isLoading(state){
            return state.loading;
        },
        isLoggedIn(state){
            return state.isLoggedIn
        },
        currentUser(state){
            return state.currentUser;
        },
        authError(state){
            return state.auth_error;
        },
        customers(state){
            return state.customers;
        }

    },
    mutations:{
        login(state){
            state.loading =true;
            state.auth_error = null;
        },
        loginSuccess(state,payload){
            state.auth_error =false;
            state.isLoggedIn=true;
            state.loading = false;
            state.currentUser = Object.assign({},payload.user,{token: payload.access_token});

            localStorage.setItem("user",JSON.stringify(state.currentUser));
        },
        logginFailded(state,payload){
            state.loading = false;
            state.auth_error = null;
        },
        logout(state)
        {
            localStorage.removeItem("user");
            state.isLoggedIn=false;
            state.currentUser = null;
        }

    },
    actions:{
        login(context){
            context.commit("login");
        }
    }
    
};