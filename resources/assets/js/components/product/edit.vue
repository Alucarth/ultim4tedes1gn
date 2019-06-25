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
                        <v-text-field label="Acabado" v-model="item.completed_type" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Desidad" v-model="item.density" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Alto" v-model="item.high" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Ancho" v-model="item.width" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Precio" v-model="item.amount" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="item.description" ></v-text-field>
                    </v-flex>
                    <!-- <v-switch
                        :label="'Activo'"
                        v-model="item.is_enabled"
                    ></v-switch> -->
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="sendProduct()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(item)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        product: Object
	},
	data:()=>({

	}),
	methods:{
        sendProduct() {
            this.$emit('product',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
	},
    computed:{
        item(){
           let item = this.product
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Producto'
            if(this.item.id) {
                title = 'Editar Producto'
            }
            return title
        },
	}
}
</script>
