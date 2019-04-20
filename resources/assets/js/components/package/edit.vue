<template>
    <v-dialog v-model="parent_dialog"  persistent max-width="1100px">
        <v-card>
            <v-card-title>
                <span class="headline">{{this.title}}</span>
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
                            <v-text-field label="Codigo" hint="Ingrese codigo" required v-model="item.code"></v-text-field>
                           
                        </v-flex>
                        <v-flex xs12>
                            <v-btn
                            color="blue-grey"
                            class="white--text"
                            @click="newLumber()"
                            small
                            >
                            Madera
                            <v-icon right dark small>add</v-icon>
                            </v-btn>
                             <v-chip color="green" text-color="white">
                                <v-avatar class="green darken-4">
                                    <v-icon>group_work</v-icon>
                                </v-avatar>
                                cantidad: {{this.cantidad}}
                            </v-chip>
                            <v-chip color="green" text-color="white">
                                <v-avatar class="green darken-4">
                                    <v-icon>group_work</v-icon>
                                </v-avatar>
                                cantidad Pie: {{this.cantidad_pie}}
                            </v-chip>
                        </v-flex>
                        <v-layout row v-if="lumber">
                            <v-flex xs12 sm6 md2>
                            <v-combobox label="Especie" v-model="lumber.specie" :items="species" item-text="name" item-value="id"
                                placeholder="Seleccione Especie" persistent-hint>
                            </v-combobox>
                            </v-flex>
                            <v-flex xs12 sm6 md2>
                                <v-combobox label="Tipo" v-model="lumber.type" :items="types" item-text="name" item-value="id"
                                    placeholder="Seleccione Tipo" persistent-hint>
                                </v-combobox>
                            </v-flex>
                            <v-flex xs12 sm6 md2>
                                <v-combobox label="Unidad" v-model="lumber.unit" :items="units" item-text="name" item-value="id"
                                    placeholder="Seleccione Unidad" persistent-hint>
                                </v-combobox>
                            </v-flex> 
                            <v-flex xs12 sm2 md1>
                                <v-text-field label="Espesor" hint="Ingrese espesor" required v-model="lumber.density"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm2 md1>
                                <v-text-field label="Ancho" hint="Ingrese ancho" required v-model="lumber.width"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm2 md1>
                                <v-text-field label="Alto" hint="Ingrese Alto" required v-model="lumber.high"></v-text-field>
                            </v-flex>

                            <v-flex xs12 sm2 md1>
                                <v-text-field label="Cantidad Pz" hint="Ingrese cantidad" required v-model="lumber.quantity"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm2 md1>
                                <v-text-field label="Cantidad Pie" hint="Ingrese cantidad" required v-model="lumber.quantity_feet"></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm4 md4>
                                <v-btn small color="success" @click="addLumber()">adionar a paquete</v-btn>
                                <v-btn small color="error" @click="cancel()">cancelar</v-btn>
                            </v-flex>
                        </v-layout>
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
                        

                    </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancelar</v-btn>
                <v-btn color="blue darken-1" flat @click="sendPackage()">{{this.button_text}}</v-btn>

            </v-card-actions>
        </v-card>
    </v-dialog>

</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
export default {
    props:{
        dialog: Boolean,
        editItem: Object,
    },
    data:()=>({
        units:[],
        types:[],
        species:[],
        storages:[],
        lumber:null,
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
                label: "Cantidad Pz",
                name: "pivot.quantity",
                sort: true,
            },
            {
                label: "Cantidad Pie",
                name: "pivot.quantity_feet",
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
        axios.get('/api/auth/getStorageData')
                .then((response) => {
                this.storages= response.data.storages;
                console.log(this.storages);
        });   
        console.log('cargando componente');
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
            this.item.lumbers.splice(index, 1);
        },
        addLumber(){
            let lumber = {
                "id": null,
                "type_id": this.lumber.type.id,
                "specie_id": this.lumber.specie.id,
                "unit_id": this.lumber.unit.id,
                "high": this.lumber.high,
                "width": this.lumber.width,
                "density": this.lumber.density,
                "description": null,
                "created_at": "2019-03-10 18:40:09",
                "updated_at": "2019-03-10 18:40:09",
                "deleted_at": null,
                "pivot": {
                    "package_id": null,
                    "lumber_id": null,
                    "quantity": this.lumber.quantity,
                    "quantity_feet": this.lumber.quantity_feet
                },
                "specie": this.lumber.specie,
                "type": this.lumber.type,
                "unit": this.lumber.unit
            }
            this.item.lumbers.push(lumber);
            this.cancel();
        },
        newLumber(){
            this.lumber ={};
        },
        cancel(){
            this.lumber =null;
        }
    },
    computed:{
        item(){
            let  item = this.editItem;
            this.rows = item.lumbers;
            // console.log(item);
            return item;
        },
        parent_dialog(){
            if(this.dialog){
                this.lumber=null;
            }    
           return this.dialog;
        },
        cantidad(){
            let sum=0;
            if(this.item.lumbers){
                this.item.lumbers.forEach(element => {
                    sum+= parseFloat(element.pivot.quantity)
                });
            }
            this.item.quantity =sum;
            return sum;
        },
        cantidad_pie(){
            let sum=0;
            if(this.item.lumbers){
                
                this.item.lumbers.forEach(element => {
                    sum+= parseFloat(element.pivot.quantity_feet)
                });
            }
            this.item.quantity_feet = sum;
            return sum;
        },
        title(){
            let title='Crear Paquete'
            if(this.item.id)
            {
                title = 'Editar Paquete';
            }
            return title;
        },
        button_text(){
            let text = 'Crear'
            if(this.item.id)
            {
                text = 'Actualizar'
            }
            return text;
        }

    },
    components: {
        VueBootstrap4Table
    }  
   
}
</script>
