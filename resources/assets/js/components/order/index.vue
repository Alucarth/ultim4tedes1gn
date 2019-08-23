<template>
    <v-card>
        <v-card-title>
            <h3>Ordenes</h3>
        <v-spacer></v-spacer>
        <!-- <v-btn to="/package/transfer" color="primary" dark class="mb-2" small>Transferencias</v-btn> -->
        <v-btn @click="create()" color="primary" dark class="mb-2" small>Nuevo</v-btn>
        </v-card-title>
        <v-card-text>
             <vue-bootstrap4-table :rows="orders" :columns="columns" :config="config" >
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
        <edit-order :dialog="dialog" :order="order" @close="close" @order="update" ></edit-order>
    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditOrder from './edit.vue';
export default {
    data () {
      return {
        orders: [],
        order: {},
        loading: true,
        dialog: false,
        columns: [
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
                label: "Fecha Inicio",
                name: "start_date",
                filter: {
                    type: "simple",
                    placeholder: "construccion"
                },
                sort: true
            },
            {
                label: "Fecha Entrega",
                name: "estimated_date",
                filter: {
                    type: "simple",
                    placeholder: "construccion"
                },
                sort: true
            },
            {
                label: "Fecha Cierre",
                name: "end_date",
                filter: {
                    type: "simple",
                    placeholder: "construccion"
                },
                sort: true
            },
            {
                label: "Cliente",
                name: "construction.client.name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Cliente"
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
                label: "Contrato",
                name: "contract.name",
                filter: {
                    type: "simple",
                    placeholder: "Contrato"
                },
                sort: true,
            },
            {
                label: "Cantidad",
                name: "quantity",
                filter: {
                    type: "simple",
                    placeholder: "Cantidad"
                },
                sort: true
            },
            {
                label: "Producto",
                name: "products[0].name",
                filter: {
                    type: "simple",
                    placeholder: "construccion"
                },
                sort: true
            },
            {
                label: "Costo de Producción",
                name: "amount",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese costo"
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
      }
    },
    computed: {
        formTitle () {
                return this.editedIndex === -1 ? 'Crear nueva orden' : 'Editar orden'
            }
    },
    mounted()
    {
        this.search();
    },
    methods:{
        search() {
            axios.get('/api/auth/order')
                .then((response)=> {
                    this.orders = response.data;
                })
                .catch((error)=> {
                    console.log(error);
                })
        },
        create() {
            this.order={}
            this.dialog = true;
        },
        show(item) {
            axios.get(`/api/auth/order/${item.id}`)
            .then(response => {
                this.order = response.data.order
            })
            .catch(error => {
                console.log(error);
            })
        },
        edit (item) {
            axios.get(`/api/auth/order/${item.id}/edit`)
            .then(response => {
                this.order = response.data.order;
                this.dialog=true;
            })
            .catch(error => {
                console.log(error);
            });
        },
        update (item) {
             axios.post('/api/auth/order', item)
                  .then(response => {
                        this.$store.dispatch('template/showMessage',{message:'Se Actualizó la lista de ordenes',color:'success'});
                        this.search();
                    })
                    .catch(function (error) {
                        this.$store.dispatch('template/showMessage',{message:error,color:'danger'});
                    });
            this.dialog =false;
        },
        destroy (item) {
            Swal.fire({
                title: 'Esta seguro de Eliminar la orden?',
                text: "Tenga en cuenta que no se puede revertir una ves eliminado!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/api/auth/order/${item.id}`)
                    .then( (response)=> {
                        Swal.fire(
                            'Borrado!',
                            'La orden ha sido eliminado.',
                            'success'
                        )
                        this.search()
                    })
                    .catch( (error)=> {
                        console.log(error);
                        Swal.fire(
                            'No se pudo Borrar!',
                            ''+error,
                            'error'
                        )
                    });
                }
            })
        },
        close() {
            this.dialog = false;;
        }
    },
    watch: {

    },
    components: {
        VueBootstrap4Table,
        EditOrder
    }
}
</script>
