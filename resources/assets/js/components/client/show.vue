<template>
    <v-card>
        <v-card-title>
            <span class="headline">Mayor</span>
        </v-card-title>
        <v-card-text v-if="item">
            <v-container grid-list-md>
            <v-layout wrap>
                <v-flex xs9>
                    <h4>Datos del cliente</h4>
                <v-flex xs12>
                    <v-text-field readonly label="Razón Social" v-model="item.name" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="NIT\CI" v-model="item.nit" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Dirección" v-model="item.address" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Representante legal" v-model="item.legal_representative" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Teléfono" v-model="item.phone" ></v-text-field>
                </v-flex>
                <v-flex xs12>
                    <v-text-field readonly label="Descripción" v-model="item.description" ></v-text-field>
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
             <vue-bootstrap4-table :rows="orders" :columns="order_columns" :config="config" >
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
        <vue-bootstrap4-table :rows="payments" :columns="payment_columns" :config="config" >
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
        client: Object,
        orders: [],
        payments: [],
        payment_columns: [
            {
                label: "Fecha",
                name: "date",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Fecha"
                },
                sort: true,
            },
            {
                label: "Monto",
                name: "amount",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese monto"
                },
                sort: true,
            },
            {
                label: "Comprobante",
                name: "option",
                sort: false,
            },
            {
                label: "Descripción",
                name: "description",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese descripción"
                },
                sort: true,
            },
        ],
        order_columns: [
            {
                label: "Código",
                name: "name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Nombre"
                },
                sort: true,
            },
            {
                label: "Costo",
                name: "amount",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese costo"
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
                label: "Contrato",
                name: "contract.name",
                filter: {
                    type: "simple",
                    placeholder: "Contrato"
                },
                sort: true,
            },
            {
                label: "Obra",
                name: "construction.name",
                filter: {
                    type: "simple",
                    placeholder: "construccion"
                },
                sort: true
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
        sendClient() {
            this.$emit('client',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
        getClient() {
            let id = this.$route.params.id
            axios.get(`/api/auth/client/${id}`)
            .then(response => {
                this.client = response.data.client
            })
            .catch(error => {
                console.log(error);
            })
        },
        getOrders() {
            axios.get(`/api/auth/order`)
            .then(response => {
                //this.orders = response.data.filter
                let temp = response.data
                this.orders = temp.filter(order=> order.construction.client.id == this.client.id)
            })
            .catch(error => {
                console.log(error);
            })
        },
        getPayments() {
            axios.get(`/api/auth/payment`)
            .then(response => {
                let temp = response.data
                console.log('filtering payments'+temp.length)
                this.payments = temp.filter(payment=> payment.client.id == this.client.id)
                console.log(this.payments.length)
            })
            .catch(error => {
                console.log(error);
            })
        },
        download(item) {
            console.log(item.file)
          this.$http.get(`api/auth/${item.file}`, {responseType: 'arraybuffer'})
    .then(response => {
      let blob = new Blob([response.data], { type: 'application/pdf' })
      let link = document.createElement('a')
      link.href = window.URL.createObjectURL(blob)
      //link.download = 'test.pdf'
      link.click()
    })
        }
	},
    computed:{
        item(){
           let item = this.client
           return item
        },
        parent_dialog(){
			return this.dialog
        },
    },
    mounted() {
        console.log('gettin in this')
        this.getClient()
        this.getOrders()
        this.getPayments()
    },
    components: {
        VueBootstrap4Table,
    }
}
</script>
