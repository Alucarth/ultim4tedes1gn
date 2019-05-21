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
				<!-- <v-flex xs12>
					<v-text-field label="Descripción" v-model="item.description" ></v-text-field>
				</v-flex> -->
			</v-layout>
			</v-container>
		</v-card-text>

		<v-card-actions>
			<v-spacer></v-spacer>
			<v-btn color="blue darken-1" flat @click="sendClose()">Cancelar</v-btn>
			<v-btn color="blue darken-1" flat @click="sendOffer()">Guardar</v-btn>
		</v-card-actions>
		</v-card>
	</v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        offer: Object
	},
	data:()=>({

	}),
	methods:{
        sendOffer(){
            this.$emit('offer',this.item);
        },
        sendClose()
        {
            this.$emit('close',false);
        },
	},
    computed:{
        
        item(){
           let item = this.offer;
           return item;
        },
        parent_dialog(){
            // if(this.dialog){
            //     this.provider=null;
            // } 
			return this.dialog;
        },
        title(){
            let title='Crear Oferta'
            if(this.item.id)
            {
                title = 'Editar Oferta';
            }
            return title;
        },
	}
}
</script>

