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
                        <v-text-field label="Código" v-model="item.code" ></v-text-field>
                    </v-flex>
                     <v-flex xs12>
                        <v-text-field label="Nombre" v-model="item.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Costo" v-model="item.price" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Ubicación" v-model="item.location" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
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
                                label="Fecha de compra"
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
                        <v-text-field label="Tiempo de vida" v-model="item.lifetime" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Revaluo" v-model="item.revaluation" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Porcentaje de depreciación" v-model="item.depreciation" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="item.description" ></v-text-field>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="sendasset()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(item)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        asset: Object,
	},
	methods:{
        sendasset() {
            this.$emit('asset',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        }
    },
    data:()=>({
        menu: false
    }),
    mounted (){
    },
    computed:{
        item(){
           let item = this.asset
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Activo Fijo'
            if(this.item.id) {
                title = 'Editar Activo Fijo'
            }
            return title
        },
	}
}
</script>
