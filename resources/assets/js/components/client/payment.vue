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
                        <v-text-field label="Monto" v-model="item.amount" ></v-text-field>
                    </v-flex>
                    <v-flex xs6>
                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                        >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                v-model="item.date"
                                label="Fecha de pago"
                                hint="Año-Mes-Dia"
                                persistent-hint
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="item.date" no-title @input="menu = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Archivo" v-model="item.file" ></v-text-field>
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
                <v-btn color="blue darken-1" flat @click="sendPayment()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(item)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        client: Object,
        payment: Object

	},
	data:()=>({
        menu: false
	}),
	methods:{
        sendPayment() {
            this.$emit('payment',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
	},
    computed:{
        
        item(){
           let item = this.payment
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){

            let title='Crear Pago'
            if(this.item) {
                title = 'Editar Pago'
            }
            return 'crear pago'//title
        },
	}
}
</script>
