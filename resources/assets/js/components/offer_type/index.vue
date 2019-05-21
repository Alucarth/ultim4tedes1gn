<template>
    <v-card>
        <v-card-title>
           <h3>Tipos de Oferta</h3> 
            <v-spacer></v-spacer>
            <v-btn @click="create();" color="primary" dark class="mb-2" small>Nuevo</v-btn>    
        </v-card-title>
        <v-card-text>
             <vue-bootstrap4-table :rows="offer_types" :columns="columns" :config="config" >
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
        <edit-offer :dialog="dialog" :offer="offer" @close="close" @offer="update"></edit-offer>    
    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditOffer from './edit.vue';
export default {
    data () {
      return {
        headers: [          
            { text: 'ID', value: 'id' },        
            { text: 'Nombre', value: 'name' },
            { text: 'Descripcion', value: 'description' },            
        ],                
        offer_types: [],        
        offer: {},
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
       
      }
    },
    mounted()
    {
        this.search();
    },
    methods:{
       search() {
            axios.get('/api/auth/offer_types')
                    .then((response)=> {
                        console.log(response.data);
                        this.offer_types= response.data.offer_types;
                    })
                    .catch((error)=> {
                        console.log(error);
                    });
        },
        create() {                                    
            this.offer={};
            this.dialog = true;
        },
        edit (item) {
			// this.editedIndex = this.offer_types.indexOf(item);
			console.log(item);
            axios.get(`/api/auth/offer_types/${item.id}/edit`)            
            .then(response => {                
                this.offer = response.data.offer
                this.dialog = true
            })
            .catch(error => {                
                 this.$store.dispatch('template/showMessage',{message:error,color:'danger'});
            });            
        },
        update (item) {    
			console.log(item);
             axios.post('/api/auth/offer_types', item)
            .then(response => {                
                console.log(response.data);
                
                this.$store.dispatch('template/showMessage',{message:'Se Actualizo los Datos del Tipo de Oferta ',color:'success'});
                this.dialog =false;  
                this.search();
            })
            .catch(function (error) {
                this.$store.dispatch('template/showMessage',{message:error,color:'danger'})
            });            
                      
        },
        destroy (item) {
            Swal.fire({
                title: 'Esta seguro de Eliminar al Tipo de Oferta?',
                text: "Tenga en cuenta que no se puede revertir una ves eliminado!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/api/auth/offer_types/${item.id}`)
                    .then( (response)=> {
                                  
                        Swal.fire(
                            'Borrado!',
                            'El tipo de Offerta ha sido eliminado.',
                            'success'
                        )
                        this.search();
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
            this.dialog = false;
        }
        
    },
    components: {
        VueBootstrap4Table,
        EditOffer
    } 
}
</script>
