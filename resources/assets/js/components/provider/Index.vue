<template>
    <v-card>
        <v-card-title>
        <h3>Provedores</h3> 
        <v-spacer></v-spacer>
       
        <v-btn @click="create()" color="primary" dark class="mb-2">Nuevo</v-btn>         
        </v-card-title>

        <v-card-text>
             <vue-bootstrap4-table :classes="classes" :rows="providers" :columns="columns" :config="config"  @on-change-query="onChangeQuery"  :totalRows="total_rows">
                <template slot="sort-asc-icon">
                    <i class="fa fa-sort-asc"></i>
                </template>
                <template slot="sort-desc-icon">
                    <i class="fa fa-sort-desc"></i>
                </template>
                <template slot="no-sort-icon">
                    <i class="fa fa-sort"></i>
                </template>
                <template slot="first_name" slot-scope="props">
                   {{props.row.contacts[0]?props.row.contacts[0].first_name:''}}
                </template>
                <template slot="last_name" slot-scope="props">
                   {{props.row.contacts[0]?props.row.contacts[0].last_name:''}}
                </template>
                <template slot="phone" slot-scope="props">
                   {{props.row.contacts[0]?props.row.contacts[0].phone:''}}
                </template>
                <template slot="option" slot-scope="props">
                    <!-- <v-icon  small>
                        remove_red_eye
                    </v-icon> -->
                    <v-icon @click="editItem(props.row)" small>
                        edit
                    </v-icon>
                    <v-icon @click="destroy(props.row)" small>
                        delete
                    </v-icon>
                </template>
            </vue-bootstrap4-table>
        </v-card-text>

        <edit-provider :provider='provider' :dialog='dialog' @close='close' @provider='update' ></edit-provider> 
        
    </v-card>
    
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditProvider from './edit.vue';
export default {
    data () {
      return {
        dialog: false,
        pagination: {
          sortBy: 'name'
        },
        headers: [
          
          { text: 'Proveedor', value: 'name' ,input:'', menu:false },
        //   { text: 'Oferta', value: 'offer' , menu:false },
          { text: 'Nombres', value: 'first_name',input:'', menu:false },
          { text: 'Apellidos', value: 'last_name',input:'', menu:false },
          { text: 'Cargo', value: 'position',input:'', menu:false },
          { text: 'Email', value: 'email',input:'', menu:false },
          { text: 'Telefono', value: 'phone',input:'', menu:false },
          { text: 'Balance', value: 'balance',input:'', sortable: false, menu:false },
          { text: 'Debito', value: 'debit',input:'', sortable: false, menu:false },
          { text: 'Acciones',value:'actions',input:'',  sortable: false , menu:false },
        ],
        providers: [],
        loading: true,
        newProvider: null,
        newContact: null,
        provider:{contacts:[]},
        contacts:[],
        editedIndex: -1,
        // rows:[],
        //desde aqui lo del databale
         columns: [{
                label: "Proveedor",
                name: "name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Proveedor"
                },
                sort: true,
            },
            {
                label: "Oferta",
                name: "offer",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Oferta"
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
                label: "Nombre ",
                name: "first_name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Nombre"
                },
                sort: true,
            },
            {
                label: "Apellidos",
                name: "last_name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Apellidos"
                },
                sort: true,
            },
            {
                label: "Telefono",
                name: "phone",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Telefono"
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
            server_mode:  true,
        },
        queryParams: {
            sort: [],
            filters: [],
            global_search: "",
            per_page: 10,
            page: 1,
        },
        total_rows: 0,
        classes: {
             table : {
                "table-striped " : false,
                
            },
        }  
      }
    },
    mounted()
    {
        this.search();
    },
    methods:{
        search() {
            axios.get('api/auth/provider', {
                        params: this.getParams(this.queryParams)
                    })
                    .then((response)=> {
                        console.log(response.data);
                        this.providers= response.data.data;
                        this.total_rows =response.data.total;
                        // this.cantidad =response.data.cantidad
                        // this.cantidad_pie =response.data.cantidad_pie
    
                    })
                    .catch((error)=> {
                        console.log(error);
                    });
        },
        onChangeQuery(queryParams) {
            // queryParams.filters.push({"type":"simple","name":"storage_id","text":this.storage.id})
            console.log(this.getParams(queryParams));
            this.queryParams = queryParams;
            this.search();
          //  this.fetchData();
        },
        getParams (queryParams) {
            let params={};
            queryParams.filters.forEach(element => {
                if(element.type=='simple'){
                    params[element.name] = element.text;
                }
            });
            if(queryParams.sort.length > 0){
                params['order']= queryParams.sort[0].order;
                params['sort_name']= queryParams.sort[0].name;
            }

            params['page']=queryParams.page;
            params['pagination_rows']=queryParams.per_page;
            return params;
        },
           
        create() {                                    
            this.provider = {contacts:[]};
            this.dialog = true;
            console.log(this.provider);
        },
        show(item) {                        
            axios.get(`/api/auth/provider/${item.id}`)            
            .then(response => {                
                this.provider = response.data.provider
            })
            .catch(error => {                
                console.log(error);
            });
        },
        store(){
             
              
        },
        update (item) {
            console.log(item);
            axios.post('api/auth/provider', item)
            .then(response => {                
                console.log(response.data);
                this.$store.dispatch('template/showMessage',{message:'Se Actualizo los Datos del Proveedor ',color:'success'});
                this.dialog =false;      
                this.search();   
            })
            .catch(function (error) {
                console.log(error);
            });              
                   
        },
        close(dialog){
            this.dialog= dialog;
        },
        editItem (item) {
         
            axios.get(`/api/auth/provider/${item.id}/edit`)            
            .then(response => {                
                this.provider = response.data.provider;
                console.log(this.provider);
                this.dialog = true
            })
            .catch(error => {                
                console.log(error);
            });            
          
        },
       
        destroy (item) {
            Swal.fire({
                title: 'Esta seguro de Eliminar al Proveedor?',
                text: "Tenga en cuenta que no se puede revertir una ves eliminado!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/api/auth/provider/${item.id}`)
                    .then( (response)=> {
                        // console.log(response.data);                   
                        Swal.fire(
                            'Borrado!',
                            'El proveedor ha sido eliminado.',
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

    },
    computed:{
        formTitle () {
            return this.editedIndex === -1 ? 'Nuevo Proveedor' : 'Editar Proveedor'
        }
    },
     components: {
        VueBootstrap4Table,
        EditProvider 
    }  
}
</script>