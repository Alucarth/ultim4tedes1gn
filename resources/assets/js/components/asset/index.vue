<template>
    <v-card>
        <v-card-title>
            <h3>Activos Fijos</h3> 
        <v-spacer></v-spacer>
        <v-btn  color="primary" dark class="mb-2" small >Actualizar Precios</v-btn>
        <v-btn @click="create()" color="primary" dark class="mb-2" small >Nuevo</v-btn>
        </v-card-title>
        <v-card-text>
             <vue-bootstrap4-table :rows="assets" :columns="columns" :config="config" >
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
        <edit-asset :dialog="dialog" :asset="asset" @close="close" @asset="update" ></edit-asset>
    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditAsset from './edit.vue';
export default {
    data () {
      return {
        assets: [],
        asset: {},
        loading: true,
        dialog: false,
        columns: [
            {
                label: "Codigo",
                name: "code",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Codigo"
                },
                sort: true,
            },
            {
                label: "Nombre",
                name: "name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese nombre"
                },
                sort: true,
            },
            {
                label: "Descripcion",
                name: "description",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese descripcion   "
                },
                sort: true,
            },
            {
                label: "Tipo",
                name: "asset_type.name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Descripcion"
                },
                sort: true,
            },
            {
                label: "Area",
                name: "area.name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Descripcion"
                },
                sort: true,
            },
            {
                label: "Precio",
                name: "actual_price",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Precio"
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
                return this.editedIndex === -1 ? 'Crear nuevo activo fijo' : 'Editar Actijo fijo'
            }
    },
    mounted()
    {
        this.search();
    },
    methods:{
        search() {
            axios.get('/api/auth/asset')
                .then((response)=> {
                    this.assets = response.data;
                })
                .catch((error)=> {
                    console.log(error);
                })
        },
        create() {
            this.asset= {}
            this.dialog = true;
        },
        show(item) {
            axios.get(`/api/auth/asset/${item.id}`)
            .then(response => {
                this.asset = response.data.asset
            })
            .catch(error => {
                console.log(error);
            })
        },
        edit (item) {
            axios.get(`/api/auth/asset/${item.id}/edit`)
            .then(response => {
                this.asset = response.data.asset;
                this.dialog=true;
            })
            .catch(error => {
                console.log(error);
            });
        },
        update (item) {
             axios.post('/api/auth/asset', item)
                  .then(response => {
                        this.$store.dispatch('template/showMessage',{message:'Se Actualizó la lista de contratos',color:'success'});
                        this.search();
                    })
                    .catch(function (error) {
                        this.$store.dispatch('template/showMessage',{message:error,color:'danger'});
                    });
            this.dialog =false;
        },
        destroy (item) {
            Swal.fire({
                title: 'Esta seguro de Eliminar al contrato?',
                text: "Tenga en cuenta que no se puede revertir una ves eliminado!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/api/auth/asset/${item.id}`)
                    .then( (response)=> {
                        Swal.fire(
                            'Borrado!',
                            'El contrato ha sido eliminado.',
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
        EditAsset
    }
}
</script>
