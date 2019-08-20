<template>
<v-dialog v-model="dialog" persistent max-width="700px">
            <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>

            <v-card-text v-if="item">
                <v-container grid-list-md>
                 <v-layout wrap>
                    <v-flex xs6 sm6 md3>
                        <v-text-field label="Codigo" hint="Ingrese Codigo" required v-model="item.code"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md9>
                        <v-text-field label="Nombre" hint="Ingrese Nombre" required v-model="item.name"></v-text-field>
                    </v-flex>

                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>

                <v-btn color="blue darken-1" flat @click="sendTask()">Guardar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>
</template>
<script>
export default
{
    props:{
        dialog: Boolean,
        task: Object
	},
    data:()=>({

    }),
    methods:{
        sendTask() {
            this.$emit('task',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
    },
    computed:{
        item(){
           let item = this.task
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Tarea'
            if(this.item.id) {

                title = 'Editar Tarea'
            }
            return title
        },
	}
}
</script>
