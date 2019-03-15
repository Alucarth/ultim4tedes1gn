<template>
    <v-dialog v-model="dialog"  persistent max-width="1100px">
        <v-card>
            <v-card-title>
                <span class="headline">Editar</span>
            </v-card-title>
            <v-card-text v-if="item!=null">
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12 sm6 md4>
                            <v-combobox label="Almacen" v-model="item.storage" :items="storages" item-text="name" item-value="id"
                                placeholder="Seleccione Almacen" persistent-hint>
                            </v-combobox>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field label="Nombre" hint="Ingrese nombre" required v-model="item.name"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field label="Cantidad" required v-model="item.quantity"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                            <vue-bootstrap4-table   :rows="item.lumbers||[]" :columns="columns" :config="config">
                                <template slot="sort-asc-icon">
                                    <i class="fa fa-sort-asc"></i>
                                </template>
                                <template slot="sort-desc-icon">
                                    <i class="fa fa-sort-desc"></i>
                                </template>
                                <template slot="no-sort-icon">
                                    <i class="fa fa-sort"></i>
                                </template>
                                <template slot="option" slot-scope="props">
                               
                                <v-icon @click="destroy(props)" small>
                                    delete
                                </v-icon>
                            </template>
                            </vue-bootstrap4-table>
                        </v-flex>
                        <!-- <v-flex xs12 sm6 md6>
                            <v-menu :close-on-content-click="false" v-model="menu2" :nudge-right="40" lazy transition="scale-transition"
                                offset-y full-width max-width="290px" min-width="290px">
                                <v-text-field slot="activator" v-model="item.fecha" label="Fecha" hint="Año-Mes-Dia"
                                    persistent-hint prepend-icon="event" readonly></v-text-field>
                                <v-date-picker v-model="item.fecha" no-title @input="menu2 = false"></v-date-picker>
                            </v-menu>
                        </v-flex> -->
                        <!-- <v-flex xs12 sm6 md4>
                            <v-combobox label="Especie" v-model="item.specie" :items="species" item-text="name" item-value="id"
                                placeholder="Seleccione Especie" persistent-hint>
                            </v-combobox>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-combobox label="Tipo" v-model="item.type" :items="types" item-text="name" item-value="id"
                                placeholder="Seleccione Tipo" persistent-hint>
                            </v-combobox>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-combobox label="Unidad" v-model="item.unit" :items="units" item-text="name" item-value="id"
                                placeholder="Seleccione Unidad" persistent-hint>
                            </v-combobox>
                        </v-flex> -->
                        <!-- <v-flex xs12 sm6 md4>
                            <v-text-field label="Espesor" hint="Ingrese espesor" required v-model="item.espesor"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field label="Ancho" hint="Ingrese ancho" required v-model="item.ancho"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field label="Largo" hint="Ingrese largo" required v-model="item.largo"></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm6 md4>
                            <v-text-field label="Cantidad" hint="Ingrese cantidad" required v-model="item.cantidad"></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md4>
                            <v-text-field label="Cantidad Pie" hint="Ingrese cantidad" required v-model="item.cantidad_pie"></v-text-field>
                        </v-flex> -->

                    </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancelar</v-btn>
                <v-btn color="blue darken-1" flat @click="sendPackage()">Actualizar</v-btn>

            </v-card-actions>
        </v-card>
    </v-dialog>

</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
export default {
    props:{
        dialog: Boolean,
        storages: Array,
        editItem: Object,
    },
    data:()=>({
        units:[],
        types:[],
        species:[],
        columns: [
            {
                label: "Especie",
                name: "specie.name",
                filter: {
                    type: "simple",
                    placeholder: "Buscar Especie"
                },
                sort: true,
            },
            {
                label: "Tipo",
                name: "type.name",
                filter: {
                    type: "simple",
                    placeholder: "Buscar Tipo"
                },
                sort: true,
            },
            {
                label: "Unidad",
                name: "unit.name",
                // filter: {
                //     type: "simple",
                //     placeholder: "Buscar Tipo"
                // },
                sort: true,
            },
            {
                label: "Alto",
                name: "high",
                sort: true,
            },
            {
                label: "Ancho",
                name: "width",
                sort: true,
            },
            {
                label: "Espesor",
                name: "density",
                sort: true,
            },
            {
                label: "Cantidad",
                name: "pivot.quantity",
                sort: true,
            },
            {
                label: "Opcion",
                name: "option",
                sort: false,
            }
       
            ],
        config: {
            checkbox_rows: false,
            rows_selectable: false,
            pagination: true,
            card_mode: true,
            show_refresh_button:  false,
            show_reset_button:  false,
            global_search:  {
                placeholder:  "Enter custom Search text",
                visibility:  false,
                case_sensitive:  false
            },
            card_title: "Maderas Empaquetadas",
            per_page: 5, // default 10
            // per_page_options:  [5,  10,  20,  30],
        }
        // item:{},
        // menu2: false,
        // date: new Date().toISOString().substr(0, 10),
    }),
    mounted(){
        axios.get('api/auth/type')
                .then((response) => {                                       
                    this.types = response.data.types;                    
                    // console.log(response.data);
                });  
         axios.get('api/auth/unit')
                .then((response) => {                                       
                    this.units = response.data.units;                    
                    // console.log(response.data);
                });  
        axios.get('api/auth/getSpecieData')
                .then((response) => {                                       
                    this.species = response.data.species;                    
                    console.log(this.species);
                }); 

    },
    methods:{
        sendPackage(){
            this.$emit('package',this.item);
        },
        sendClose()
        {
            this.$emit('close',false);
        },
        destroy(item_select)
        {   
            let found = this.item.lumbers.find((element)=> {
                return item_select.row.id === element.id;
            });
            let index  = this.item.lumbers.indexOf(found);
            console.log(index)
            this.item.lumbers.splice(index, 1);
            console.log(found);
        }
    },
    computed:{
        item(){
            let  item = this.editItem;
            this.rows = item.lumbers;
            // console.log(item);
            return item;
        }
    },
    components: {
        VueBootstrap4Table
    }  
   
}
</script>
