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
                        <v-text-field label="Número de orden" v-model="item.name" ></v-text-field>
                    </v-flex>
                    <!-- <v-flex xs12>
                        <v-text-field label="Costo" v-model="item.amount" ></v-text-field>
                    </v-flex> -->
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
                    <!-- <v-flex xs12>
                        <v-text-field label="Nombre contrato" v-model="contract.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Monto contrato" v-model="contract.amount" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción contrato" v-model="contract.description" ></v-text-field>
                    </v-flex> -->
                    <v-flex xs12>
                        <v-select
                            label="Obra"
                            v-model="item.construction_id"
                            :items="constructions"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs6>  
                        <v-menu
                            v-model="menu1"
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
                                v-model="item.start_date"
                                label="Fecha de incio"
                                hint="Año-Mes-Dia"
                                persistent-hint
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="item.start_date" no-title @input="menu1 = false"></v-date-picker>                    
                        </v-menu>
                    </v-flex>
                    <!-- <v-flex xs6>  
                        <v-menu
                            v-model="menu2"
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
                                v-model="item.end_date"
                                label="Fecha de fin"
                                hint="Año-Mes-Dia"
                                persistent-hint
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="item.end_date" no-title @input="menu2 = false"></v-date-picker>
                        </v-menu>
                    </v-flex> -->
                    <v-flex xs6>  
                        <v-menu
                            v-model="menu2"
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
                                v-model="item.estimated_date"
                                label="Fecha Estimada"
                                hint="Año-Mes-Dia"
                                persistent-hint
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="item.estimated_date" no-title @input="menu2 = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs6>
                        <v-select
                            label="Tipo de madera"
                            v-model="item.type_id"
                            :items="types"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs6>
                        <v-text-field label="Tipo de Venesta" v-model="item.venesta" ></v-text-field>
                    </v-flex>
                    <v-flex xs6>
                        <v-select
                            label="Estado"
                            v-model="item.status_id"
                            :items="statuses"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs6>
                        <input
                                type="file"
                                style="display: none"
                                ref="pdf"
                                accept="application/pdf"
                                @change="onFilePicked"
                            >
                        <v-flex xs12>
                            <v-text-field label="Detalle de orden PDF" @click='pickFile' v-model='attachment.name' prepend-icon='attach_file'></v-text-field>
                        </v-flex>
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
                        <ul class="list-group">Productos seleccionados
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(product,index) in selected_products" :key="index">
                            <span> {{product.name}}</span>                             
                            <v-text-field label="Cantidad" v-model="product.quantity"></v-text-field>
                            <v-text-field label="Espesor(mm)" v-model="product.density"></v-text-field>
                            <v-text-field label="Altura(mm)" v-model="product.high"></v-text-field>
                            <v-text-field label="Ancho(mm)" v-model="product.width"></v-text-field>
                            <v-text-field label="Descripción" v-model="product.description"></v-text-field>                            
                        </li>
                        </ul>
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
        types: [],
        statuses: [],
        products: [],
        contract: Object,
        menu1: false,
        menu2: false,
        attachment : { name : null,file: null, url: null },
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
                label: "Tipo",
                name: "product_type.name",
                filter: {
                    type: "simple",
                    placeholder: "Tipo de producto"
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
        },
        selected_products: []
	}),
	methods:{
        pickFile () {
            this.$refs.pdf.click ()
        },
        onFilePicked (e) {
            const files = e.target.files
            console.log(files);
			if(files[0] !== undefined) {
				this.attachment.name = files[0].name
				if(this.attachment.name.lastIndexOf('.') <= 0) {
					return
				}
				const fr = new FileReader ()
				fr.readAsDataURL(files[0])
				fr.addEventListener('load', () => {
					this.attachment.url = fr.result
					this.attachment.file = files[0]
				})
			} else {
				this.attachment.name = ''
                this.attachment.file = ''
                this.attachment.url = ''
				//this.excelUrl = ''
			}
        },
        sendOrder() {
            this.item.contract = this.contract
            this.item.products =  this.selected_products
            var form = new FormData()
            let form_data = this.item
            Object.keys(form_data).forEach(key => form.append(key,form_data[key]))
            form.append('file',this.attachment.file)
            let prods = this.selected_products
            prods.forEach(function(prod, index){
                Object.keys(prod).forEach(key => form.append(`products[${index}][${key}]`,prod[key]))
            });
            this.$emit('order',form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            this.selected_products = []
        },
        sendClose() {
            this.selected_products = []
            this.$emit('close',false)
        },
        getContracts() {
            axios.get('/api/auth/contract')
                .then((response)=> {
                    this.contracts= response.data
                })
                .catch((error)=> {
                    console.log(error)
                })
        },
        getTypes() {
            axios.get('/api/auth/type')
                .then((response)=> {
                    this.types = response.data.types
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
        getStatuses() {
            axios.get('/api/auth/status')
                .then((response)=> {
                    this.statuses = response.data
                })
                .catch((erro)=> {
                    console.log(error)
                })
        },
        add(prod) {
            console.log('ading a new element')
            let new_product = _.cloneDeep(prod)
            this.selected_products.push(new_product)
            //console.log(this.item.products.length)
        }
    },
    mounted() {
        this.getContracts()
        this.getConstructions()
        this.getProducts()
        this.getStatuses()
        this.getTypes()
    },
    computed:{
        item(){
           let item = this.order
           //this.selected_products = this.order.products
           //item.products.push(prod)
           //item.products = prod
           //item.contract = Object
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

    components: {
        VueBootstrap4Table
    }
}
</script>
