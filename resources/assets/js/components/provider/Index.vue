<template>
    <v-card>
        <v-card-title>
        Provedores
        <v-spacer></v-spacer>
            <v-flex xs1 sm1 md1>
                    <v-combobox
                    v-model="paginationRows"
                    :items="pagination_select"
                    label="Mostrar Registros"
                    @change="search()"
                    ></v-combobox>
                    
            </v-flex>
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
        <v-data-table
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
                            <!-- <v-icon small @click="toggleOrder(header.value)" v-if="header.value == filterName ">{{pagination.descending==false?'arrow_upward':'arrow_downward'}}</v-icon> -->
                        </v-flex>
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <td class="text-xs-left" >{{ props.item.name }}</td>
            <!-- <td class="text-xs-left">{{ props.item.offer }}</td> -->
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
                        @click="show(props.item);props.expanded = !props.expanded"
                    >
                        toc
                    </v-icon>
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
        <template slot="expand" slot-scope="props">
            <v-card flat v-if="provider">
                <v-card-text>{{ provider.name }}</v-card-text>
                <v-card-text>{{ provider.offer }}</v-card-text>
                <v-card-text>{{ provider.address1 }}</v-card-text>
                <v-card-text>{{ provider.address2 }}</v-card-text>
                <v-card-text>{{ provider.description }}</v-card-text>
                <v-card-text>{{ provider.city }}</v-card-text>
                <v-card-text>{{ provider.balance }}</v-card-text>
                <v-card-text>{{ provider.debit }}</v-card-text>
            </v-card>
        </template>

        </v-data-table>
        
        <div class="text-xs-center">
           
            <v-pagination
            v-model="page"
            :length="last_page"
            :total-visible="7"
             @input="next"
            ></v-pagination>
           
        </div>
        <div class="text-xs-right">
            
                <v-flex xs11 sm11 md11>
                     Mostrando {{from}}-{{to}} de {{total}} registros 
                </v-flex>

            
        </div>
         
        <br>
    </v-card>
    
</template>
<script>
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
        page:1,
        last_page:1,
        total:0,
        from:0,
        to:0,
        paginationRows:10,
     
        pagination_select:[10,20,30]
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
        getParams(){
            let params={};
            this.headers.forEach(element => {
                params[element.value] = element.input;
            });
            params['order']=this.pagination.descending==true?'asc':'desc';
            params['page']=this.page;
            params['pagination_rows']=this.paginationRows;
            return params;
        },
        next(page){
            this.page = page;
            this.search();
        },
        search(){
            return new Promise((resolve,reject)=>{   
                this.getData('api/auth/provider',this.getParams()).then((data)=>{
                    this.providers = data.data;
                    this.last_page = data.last_page;
                    this.total = data.total;
                    this.from = data.from;
                    this.to = data.to;
                    resolve();
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
                
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;      
            this.search();      
        },
        update () {
            let parameters = this.provider;
            parameters.contacts = this.contacts;                        
            axios.put(`api/auth/provider/${this.provider.id}`, parameters)
            .then(response => {
                this.providers[this.editedIndex] = response.data.provider;
                this.providers[this.editedIndex].contacts = response.data.provider.contacts;
                this.showSuccessMsg();
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
            let success_delete = false;
            axios.delete(`/api/auth/provider/${item.id}`)
            .then(function (response) {
                console.log(response.data.provider);
                success_delete = true;
            })
            .catch(function (error) {
                console.log(error);                
            });  
            this.search();
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
    }
}
</script>
