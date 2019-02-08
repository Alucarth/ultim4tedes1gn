function defer() {
	var deferred = {
		promise: null,
		resolve: null,
		reject: null
	};

	deferred.promise = new Promise((resolve, reject) => {
		deferred.resolve = resolve;
		deferred.reject = reject;
	});

	return deferred;
}
//estes modulo esta en face de construccion por lo cual no se debe utilizar todabia 
export const confirm = {
    namespaced: true,
    state:{
        dialog:false,//para el dialog
        color:'success',
        title:'',
        content:'',
		response: defer(),
		result:false,
    },
    mutations:{
        // updateDrawer(state,drawer){
        //     state.drawer = drawer;
        // },
        // updateShowMessage(state,show_message){
        //     state.show_message = show_message;
        // },
        // setShowMessage(state,{message,show_message,color}){
        //     state.message = message;
        //     state.show_message = show_message;
        //     state.color = color;
        //     // console.log(state.message);
        // },
        updateConfirmDialog(state,dialog){
            state.dialog = dialog;
        },
        updateConfirmResponse(state,response)
        {
			// state.response = response;
			state.dialog =false;
			// console.log(state.response);
			state.response.resolve();
			console.log(state.response);
        },
        async setShowConfirmDialog(state,{title,content}){
			
			state.title = title;
            state.content = content;
			state.dialog =true;
			
			let result = await state.response;
			console.log(result)
			return result;
		},
		async getResponse(state){
			return await state.response;
		}	
        
    },
    actions:{
        // showMessage({commit},{message,color}){
        //     commit('setShowMessage', {message:message,show_message:true,color:color});
        // },
        async showConfirmDialog({commit},{title,content}){
			console.log('se queda esperando');
			
			console.log(commit('setShowConfirmDialog',{title,content}));
			// let result = await commit('getResponse');
			// console.log('devuelve el valor');
			// console.log(result);
			// return result;
        }
	},
	
};