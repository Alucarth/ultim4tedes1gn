<template>
	<v-dialog v-model="dialog" max-width="500px">            
        <v-btn slot="activator" color="primary" dark>Nuevo <v-icon small right>fa-plus-circle</v-icon></v-btn>
		<v-card>
            <v-card-title >
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
                <v-container grid-list-md>
                 <v-layout wrap>                   
                     <v-flex xs12>
                        <v-text-field label="Nombre" v-model="origin_type.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="origin_type.description" ></v-text-field>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="close()">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="save()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(newSpecie)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
	props: ['bus'],
	data:()=>({
		// origin_type:{},
		dialog:false,
		newOriginType: true,
		origin_type:{}
	}),
	methods:{
		close(){
			// this.origin_type = origin_type
			this.newOriginType = true;
			this.dialog = false;
			this.origin_type={}
			this.bus.$emit('closeDialog');
		},
		async save(){
			let result;
			if(this.newOriginType){
				result = await axios.post('/api/auth/origin_type',this.origin_type);
				console.log(result);
				this.$store.dispatch('template/showMessage',{message:'Se registro correctamente ',color:'success'});
			}else{
				result = await axios.patch(`/api/auth/origin_type/${this.origin_type.id}`,this.origin_type);
				this.$store.dispatch('template/showMessage',{message:'Se actualizo correctamente ',color:'success'});
			}

			console.log('guardar');
			this.close();
		}
	},
	computed:{
		formTitle(){
			return this.newOriginType ? 'Registrar Tipo de Origen':'Editar Tipo de Origen';
		}
	},
	created(){
		console.log('origin type:'+this.origin_type);
	},
	mounted(){
		this.origin_type =  axios.get('/api/auth/origin_type/create')
								 .then(response=>{ return response.data});
		this.bus.$on('showDialog',origin_type=>{
			this.origin_type = origin_type;
			this.newOriginType = origin_type ? false : true ;
			this.dialog = true;
		});
	}
	
}
</script>
