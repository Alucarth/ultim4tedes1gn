<template>
	<v-dialog v-model="parent_dialog" max-width="500px" persistent>            
		<v-card>
		<v-card-title>
			<span class="headline">{{ title }}</span>
		</v-card-title>

		<v-card-text v-if="item">
			<v-container grid-list-md>
				<v-layout wrap>                   
					<v-flex xs12>
					<v-text-field label="Nombre" v-model="item.name" ></v-text-field>
				</v-flex>
				<v-flex xs12>
					<v-text-field label="Descripción" v-model="item.description" ></v-text-field>
				</v-flex>
			</v-layout>
			</v-container>
		</v-card-text>

		<v-card-actions>
			<v-spacer></v-spacer>
			<v-btn color="blue darken-1" flat @click="sendClose()">Cancelar</v-btn>
			<v-btn color="blue darken-1" flat @click="sendSpecie()">Guardar</v-btn>
		</v-card-actions>
		</v-card>
	</v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        specie: Object
	},
	data:()=>({

	}),
	methods:{
        sendSpecie(){
            this.$emit('specie',this.item);
        },
        sendClose()
        {
            this.$emit('close',false);
        },
	},
    computed:{
        
        item(){
           let item = this.specie;
           return item;
        },
        parent_dialog(){
            // if(this.dialog){
            //     this.provider=null;
            // } 
			return this.dialog;
        },
        title(){
            let title='Crear Especie'
            if(this.item.id)
            {
                title = 'Editar Especie';
            }
            return title;
        },
	}
}
</script>

