<template>
    <v-card>
        <v-card-title>
            <h3>Construcciones</h3> 
        <v-spacer></v-spacer>
        <!-- <v-btn to="/package/transfer" color="primary" dark class="mb-2" small>Transferencias</v-btn> -->
        <v-btn @click="create()" color="primary" dark class="mb-2" small >Nuevo</v-btn>
        </v-card-title>
        <v-card-text>
             <vue-bootstrap4-table :rows="constructions" :columns="columns" :config="config" >
                <template slot="sort-asc-icon">
                    <i class="fa fa-sort-asc"></i>
                </template>
                <template slot="sort-desc-icon">
                    <i class="fa fa-sort-desc"></i>
                </template>
                <template slot="no-sort-icon">
                    <i class="fa fa-sort"></i>
                </template>
                <!-- <template slot="is_enabled" slot-scope="props">
                   <div class="text-xs-center">
                    <v-chip :color="props.row.is_enabled?'success':'danger'" :text-color="props.row.is_enabled?'white':'danger'" >{{props.row.is_enabled?'Activo':'Inactivo'}}</v-chip>
                    </div>
                </template> -->
                <template slot="option" slot-scope="props">
                    <!-- <v-icon  small>
                        remove_red_eye
                    </v-icon> -->
                    <v-icon @click="edit(props.row)" small>
                        edit
                    </v-icon>
                    <v-icon @click="destroy(props.row)" small>
                        delete
                    </v-icon>
                </template>
            </vue-bootstrap4-table>
        </v-card-text>      
        <edit-construction :dialog="dialog" :construction="construction" @close="close" @construction="update" ></edit-construction>
    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditConstruction from './edit.vue';
export default {
    data () {
      return {
        constructions: [],
        construction: {}, 
        loading: true,  
        dialog: false,        
        columns: [{
                label: "id",
                name: "id",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Id"
                },
                sort: true,
            },
            {
                label: "Nombre",
                name: "name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Nombre"
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
                label: "Cliete",
                name: "client",
                filter: {
                    type: "simple",
                    placeholder: "cliente"
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
                return this.editedIndex === -1 ? 'Crear nueva construcción' : 'Editar Construcción'
            }
    },
    mounted()
    {
        this.search();           
    },
    methods:{
        search() {
            axios.get('/api/auth/construction')
                .then((response)=> {                        
                    this.construction= response.data;                    
                })
                .catch((error)=> {
                    console.log(error);
                })
        },
        create() {                                    
            this.construction={}
            this.dialog = true;
        },
        show(item) {                        
            axios.get(`/api/auth/construction/${item.id}`)            
            .then(response => {                
                this.construction = response.data.construction
            })
            .catch(error => {                
                console.log(error);
            })
        },
        edit (item) {            
            axios.get(`/api/auth/construction/${item.id}/edit`)            
            .then(response => {                
                this.construction = response.data.construction;
                this.dialog=true;
            })
            .catch(error => {                
                console.log(error);
            });            
        },
        update (item) {                      
             axios.post('/api/auth/construction', item)
                  .then(response => {                        
                        this.$store.dispatch('template/showMessage',{message:'Se Actualizó la lista de clientes',color:'success'});
                        this.search();                        
                    })
                    .catch(function (error) {                        
                        this.$store.dispatch('template/showMessage',{message:error,color:'danger'});
                    });            
            this.dialog =false;          
        },
        destroy (item) {            
            Swal.fire({
                title: 'Esta seguro de Eliminar al Construcción?',
                text: "Tenga en cuenta que no se puede revertir una ves eliminado!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/api/auth/construction/${item.id}`)
                    .then( (response)=> {                        
                        Swal.fire(
                            'Borrado!',
                            'La construcción ha sido eliminado.',
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
        EditClient
    }  
}
</script>
