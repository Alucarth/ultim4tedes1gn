<template>
    <v-card>
        <v-card-title>
            <span class="headline">Detalle de ordenes</span>
        </v-card-title>
        <v-card-text v-if="item">
            <v-container grid-list-md>
            <v-layout wrap>
                <v-flex xs9>
                    <h4>Datos de la orden</h4>
                <v-flex xs12>
                    <v-text-field readonly label="Número de orden" v-model="item.name" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Contrato" v-model="item.contract_id" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Estado" v-model="item.status_id" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Obra" v-model="item.construction_id" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Detalle PDF" v-model="item.construction.name" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Costo" v-model="item.amount" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Cantidad" v-model="item.quantity" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Descripción" v-model="item.description" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Fecha de inicio" v-model="item.start_date" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Fecha estimada" v-model="item.estimated_date" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Fecha de fin" v-model="item.end_date" ></v-text-field>
                </v-flex>
                </v-flex>
                <v-flex xs3>
                    <h4>
                    Actividad reciente
                    </h4></v-flex>
            </v-layout>
        </v-container>
        </v-card-text>
        <v-card-text>
            <v-card-title>
            <span class="headline">Ordenes</span>
        </v-card-title>
             <vue-bootstrap4-table :rows="item.products" :columns="product_columns" :config="config" >
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
                    <v-icon @click="edit(props.row)" small>
                        edit
                    </v-icon>
                    <v-icon @click="destroy(props.row)" small>
                        delete
                    </v-icon>
                </template>
            </vue-bootstrap4-table>
        </v-card-text>
        <v-card-text>
            <v-card-title>
            <span class="headline">Insumos utilizados</span>
        </v-card-title>
        <vue-bootstrap4-table :rows="inventories" :columns="inventory_columns" :config="config" >
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
                    <v-icon @click="download(props.row)" small>
                        assignment
                    </v-icon>
                </template>
            </vue-bootstrap4-table>
        </v-card-text>

            <!-- <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="sendClient()" >Guardar</v-btn>
            </v-card-actions> -->
            </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table'
export default {
	props:{
        dialog: Boolean,
	},
	data:()=>({
        order: Object,
        products: [],
        inventories: [],
        product_columns: [
            {
                label: "Nombre",
                name: "name",
            },
            {
                label: "Tipo",
                name: "product_type.name",
            },
            {
                label: "Espesor(mm)",
                name: "density",
            },
            {
                label: "Altura(mm)",
                name: "high",
            },
            {
                label: "Ancho(mm)",
                name: "width",
            },
            {
                label: "Cantidad",
                name: "pivot.quantity",
            },
            {
                label: "Descripción",
                name: "description",
            },
            {
                label: "Arreglo",
                name: "array_type",
            },
        ],
        inventory_columns: [],
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
            this.$emit('order',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
        getOrder() {
            let id = this.$route.params.id
            axios.get(`/api/auth/order/${id}`)
            .then(response => {
                this.order = response.data
                console.log('pringing contract')
           console.log(this.order.contract)
            })
            .catch(error => {
                console.log(error);
            })
        },
        // getOrders() {
        //     axios.get(`/api/auth/order`)
        //     .then(response => {
        //         //this.orders = response.data.filter
        //         let temp = response.data
        //         this.orders = temp.filter(order=> order.construction.client.id == this.client.id)
        //     })
        //     .catch(error => {
        //         console.log(error);
        //     })
        // },
        // getPayments() {
        //     axios.get(`/api/auth/payment`)
        //     .then(response => {
        //         let temp = response.data
        //         console.log('filtering payments'+temp.length)
        //         this.payments = temp.filter(payment=> payment.client.id == this.client.id)
        //         console.log(this.payments.length)
        //     })
        //     .catch(error => {
        //         console.log(error);
        //     })
        // },
	},
    computed:{
        item(){
           let item = this.order
           return item
        },
        parent_dialog(){
			return this.dialog
        },
    },
    mounted() {
        this.getOrder()
    },
    components: {
        VueBootstrap4Table,
    }
}
</script>
