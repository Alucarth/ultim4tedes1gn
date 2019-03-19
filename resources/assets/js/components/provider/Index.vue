<template>
    <v-card>
        <v-card-title>
        <h3>Provedores</h3> 
        <v-spacer></v-spacer>
       
        <v-dialog v-model="dialog" max-width="800px" max-high="40px">
            <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>
        
            <v-card-text v-if="provider">
                <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="provider.name" label="Proveedor"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="provider.offer" label="Oferta"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="provider.address1" label="Direccion Principal"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="provider.address2" label="Direccion Secundaria"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md8>
                    <v-text-field v-model="provider.description" label="Descripcion"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                    <v-text-field v-model="provider.city" label="Ciudad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="provider.balance" label="Balance"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="provider.debit" label="Debito"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md12>
                    <v-btn
                        dark
                            round
                            color="blue"
                            @click="addConactact"
                    >
                    <v-icon>add</v-icon>
                        Agregar Contacto 
                    </v-btn>
                    </v-flex>
                    <v-layout wrap v-for="(contact,index) in contacts" :key="index">
                    <v-flex xs12 sm6 md6>
                        <v-text-field v-model="contact.first_name" label="Nombres"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-text-field  v-model="contact.last_name" label="Apellidos"></v-text-field>
                    </v-flex>
                        <v-flex xs12 sm6 md6>
                        <v-text-field v-model="contact.position"  label="Cargo"></v-text-field>
                    </v-flex>
                        <v-flex xs12 sm6 md3>
                        <v-text-field v-model="contact.email"  label="Email"></v-text-field>
                    </v-flex>
                        <v-flex xs12 sm6 md3>
                        <v-text-field v-model="contact.phone"  label="Telefono"></v-text-field>
                    </v-flex>
                        <v-layout row justify-center>
                            <v-btn
                                icon
                                @click="removeContact(index)"
                            >
                            <v-icon>fa-trash</v-icon>
                            </v-btn>
                </v-layout>
                    </v-layout>
                
                </v-layout>
                
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat  @click="dialog = false">Cancelar</v-btn>
                <v-btn color="blue darken-1" flat @click="store()" v-if="editedIndex === -1">Guardar</v-btn>
                <v-btn color="blue darken-1" flat @click="update()" v-else>Actualizar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>  
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

        <!-- <v-data-table
        :headers="headers"
        :items="providers"
        :pagination.sync="pagination"
        hide-actions
        >
        <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
                        <v-flex v-if="header.value!='actions'">
                            <v-tooltip bottom>
                                <span slot="activator">{{header.text}}</span>
                                <span >{{header.input}}</span>
                            </v-tooltip>
                            <v-menu  v-model="header.menu" :close-on-content-click="false">
                                    <v-btn
                                        slot="activator"
                                        icon
                                        v-if="header.sortable!=false"
                                    >
                                    <v-icon small :color="header.input!=''?'blue':'black'" >fa-filter</v-icon>
                                    </v-btn>
                                    <v-card  >
                                            <v-text-field
                                                outline
                                                hide-details
                                                v-model="header.input"
                                                append-icon="search"
                                                :label="`Buscar ${header.text}...`"                                       
                                                @keydown.enter="search()"
                                                @keyup.delete="checkInput(header.input)"
                                                @keyup.esc="header.menu=false"
                                            ></v-text-field>
                                       
                                    </v-card>
                            </v-menu>
                        </v-flex>
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <td class="text-xs-left" >{{ props.item.name }}</td>
  
            <td class="text-xs-left">{{ props.item.contacts.length>0?props.item.contacts[0].first_name:'' }}</td>
            <td class="text-xs-left">{{ props.item.contacts.length>0?props.item.contacts[0].last_name:'' }}</td>
            <td class="text-xs-left">{{ props.item.contacts.length>0?props.item.contacts[0].position:'' }}</td>
            <td class="text-xs-left">{{ props.item.contacts.length>0?props.item.contacts[0].email:'' }}</td>
            <td class="text-xs-left">{{ props.item.contacts.length>0?props.item.contacts[0].phone:'' }}</td>
            <td class="text-xs-left">{{ props.item.balance }}</td>
            <td class="text-xs-left">{{ props.item.debit }}</td>
            <td class="justify-center layout px-0">
              
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(props.item)"
                >
                    edit
                </v-icon>
                <v-icon
                    small
                    @click="destroy(props.item)"
                >
                    delete
                </v-icon>
            </td>
        </template>
        

        </v-data-table>
         -->

    </v-card>
    
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
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
        provider:null,
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
    created(){
          axios.get('api/auth/provider/create')
                .then((response) => {                                       
                    this.newProvider = response.data.provider; 
                    this.newContact = response.data.contact; 
                    this.provider = this.newProvider;
                });    
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
        getData(url,parameters){
            return new Promise((resolve,reject)=>{
               this.loading = true;
               axios.get(url,{
                        params:parameters
                    })
                    .then((response) => {
                        this.loading = false;
                        resolve(response.data);
                    });
            });
        },
     
        create() {                                    
            this.editedIndex = -1;
            this.provider = Object.assign({}, this.newProvider);
            this.contacts = [];
            this.contacts.push( Object.assign({}, this.newContact));
            this.dialog = true;
            console.log(this.newProvider);
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
            let parameters = this.provider;
            parameters.contacts = this.contacts;
            axios.post('api/auth/provider', parameters)
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
        update () {
            let parameters = this.provider;
            parameters.contacts = this.contacts;                        
            axios.put(`api/auth/provider/${this.provider.id}`, parameters)
            .then(response => {
                // this.providers[this.editedIndex] = response.data.provider;
                // this.providers[this.editedIndex].contacts = response.data.provider.contacts;
                this.search();
                this.$store.dispatch('template/showMessage',{message:'Se Actualizo los Datos del Proveedor ',color:'success'});

            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;            
        },
        editItem (item) {
            this.editedIndex = this.providers.indexOf(item);
            console.log(item);
            axios.get(`/api/auth/provider/${item.id}/edit`)            
            .then(response => {                
                this.provider = response.data.provider;
                this.contacts = response.data.contacts;
            })
            .catch(error => {                
                console.log(error);
            });            
            this.dialog = true
        },
        addConactact()
        {
            this.contacts.push( Object.assign({}, this.newContact));
        },
        removeContact(index)
        {
            this.contacts.splice(index,1);
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
        checkInput(search)
        {
            if(search=='')
            {
                this.search();
            }
        }


    },
    watch: {
      
    },
    computed:{
        formTitle () {
            return this.editedIndex === -1 ? 'Nuevo Proveedor' : 'Editar Proveedor'
        }
    },
     components: {
        VueBootstrap4Table,
        // EditPackage 
    }  
}
</script>
