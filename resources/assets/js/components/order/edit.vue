<template>
	<v-dialog v-model="parent_dialog" max-width="90%" persistent>
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
                        <v-text-field label="Costo" v-model="item.amount" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-select
                            label="Contrato"
                            v-model="item.contract_id"
                            :items="contracts"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Nombre" v-model="contract.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Monto" v-model="contract.amount" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="contract.description" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-select
                            label="Construccion"
                            v-model="item.construction_id"
                            :items="constructions"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-card-text>
                        <vue-bootstrap4-table :rows="products" :columns="product_columns" :config="config" >
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
                                <v-icon @click="add(props.row)" small>
                                    Agregar
                                </v-icon>
                            </template>
                        </vue-bootstrap4-table>
                    </v-card-text>
                    <v-card-text>
                        <table>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                            <tr v-for="(pro,index) in added_products" :key="index">
                                <td>{{pro.name}}</td>
                                <td>{{pro.description}}</td>
                            </tr>
                        </table>
                    </v-card-text>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="item.description" ></v-text-field>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="sendOrder()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(item)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
export default {
	props:{
        dialog: Boolean,
        order: Object,
	},
	data:()=>({
        contracts: [],
        constructions: [],
        products: [],
        contract: Object,
        product_columns: [{
                label: "Nombre",
                name: "name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese nombre"
                },
                sort: true,
            },
            {
                label: "Acabado",
                name: "completed_type",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Acabado"
                },
                sort: true,
            },
            {
                label: "Descripcion",
                name: "description",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Descripcion"
                },
                sort: true,
            },
            {
                label: "Opciones",
                name: "option",
                sort: false,
            }],
        config: {
            checkbox_rows: false,
            rows_selectable: false,
            pagination: true,
            card_mode: false,
            show_refresh_button:  false,
            show_reset_button:  false,
            global_search:  {
                placeholder:  "Enter custom Search text",
                visibility:  false,
                case_sensitive:  false
            },
            per_page_options:  [5,  10,  20,  30],
            server_mode:  false,
        },
        classes: {
             table : {
                "table-striped " : false,
            },
        }
	}),
	methods:{
        sendOrder() {
            this.item.contract = this.contract
            console.log(this.item)
            this.$emit('order',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
        getContracts() {
            axios.get('/api/auth/contract')
                .then((response)=> {
                    this.contacts= response.data
                })
                .catch((error)=> {
                    console.log(error)
                })
        },
        getConstructions() {
            axios.get('/api/auth/construction')
                .then((response)=> {
                    this.constructions = response.data
                })
                .catch((erro)=> {
                    console.log(error)
                })
        },
        getProducts() {
            axios.get('/api/auth/product')
                .then((response)=> {
                    this.products = response.data
                })
                .catch((erro)=> {
                    console.log(error)
                })
        },
        add(prod) {
            console.log('ading a new element')
            console.log(prod)
            console.log(this.item.products)
            this.item.products.push(prod)
        }
    },
    mounted() {
        this.getContracts()
        this.getConstructions()
        this.getProducts()
    },
    computed:{
        item(){
           let item = this.order
           item.products = []
           item.contract = Object
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear order'
            if(this.item.id) {
                title = 'Editar orders'
            }
            return title
        },
    },
    watch: {
      added_products() {
         //   return this.products
            return  this.item.products
        }
    },
    components: {
        VueBootstrap4Table
    }
}
</script>
