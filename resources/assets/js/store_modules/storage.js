export const storage = {
    namespaced: true,
    state:{
        drawer:null,
        show_message:false,
        message:null,
        color:'success',
    },
    mutations:{
        updateDrawer(state,drawer){
            state.drawer = drawer;
        },
        updateShowMessage(state,show_message){
            state.show_message = show_message;
        },
        setShowMessage(state,{message,show_message,color}){
            state.message = message;
            state.show_message = show_message;
            state.color = color;
            // console.log(state.message);
        },
    },
    actions:{
        showMessage({commit},{message,color}){
            commit('setShowMessage', {message:message,show_message:true,color:color});
        }
    }
};