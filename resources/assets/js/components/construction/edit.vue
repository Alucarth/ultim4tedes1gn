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
                        <v-select
                            label="Cliente"
                            v-model="item.client_id"
                            :items="clients"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Dirección" v-model="item.address" ></v-text-field>
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
                <v-btn color="blue darken-1" flat @click="sendConstruction()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(item)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        construction: Object,
	},
	data:()=>({
        clients: []
	}),
	methods:{
        sendConstruction() {
            this.$emit('construction',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
        getClients() {
            axios.get('/api/auth/client')
                .then((response)=> {
                    console.log(response.data)
                    this.clients= response.data
                })
                .catch((error)=> {
                    console.log(error);
                })
        },
    },
    mounted() {
        this.getClients()
    },
    computed:{
        item(){
           let item = this.construction
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Obra'
            if(this.item.id) {
                title = 'Editar Obra'
            }
            return title
        },
	}
}
</script>
