<template>
    <v-card>
        <v-card-title>
        Provedores
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="800px" max-high="40px">
            <v-btn slot="activator" color="primary" dark class="mb-2">Nuevo</v-btn>
            <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>
        
            <v-card-text v-if="newProvider">
                <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.name" label="Proveedor"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.offer" label="Oferta"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md12>
                    <v-text-field v-model="newProvider.direccion1" label="Direccion 1"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.direccion2" label="Direccion 2"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.city" label="Ciudad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.balance" label="Balance"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.debit" label="Debito"></v-text-field>
                    </v-flex>
                    <v-btn
                        absolute
                        dark
                        fab
                        top
                        right
                        color="pink"
                    >
                    <v-icon>add</v-icon>
                    </v-btn>
                    <legend>Contactos</legend>
                    <v-flex xs12 sm6 md6>
                        <v-text-field  label="Nombres"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-text-field  label="Apellidos"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field  label="Cargo"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field  label="Email"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field  label="Telefono"></v-text-field>
                    </v-flex>
                </v-layout>
                
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancelar</v-btn>
                <v-btn color="blue darken-1" flat @click.native="save">Guardar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>        
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
                            <span>{{ header.text }}
                            </span>
                            <v-menu 
                                    :close-on-content-click="false"
                                    >
                                    <v-btn
                                        slot="activator"
                                        icon
                                   
                                        v-if="header.sortable!=false"
                                    >
                                    <v-icon  small>fa-filter</v-icon>
                                    </v-btn>
                                    <v-card  >
                                        <v-text-field
                                         outline
                                         hide-details
                                        v-model="header.input"
                                        append-icon="search"
                                        :label="`Buscar ${header.text}...`"                                       
                                        @keydown.enter="search()"
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
                    @click="editItem(props.item)"
                >
                    edit
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(props.item)"
                >
                    delete
                </v-icon>
            </td>
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
          
          { text: 'Proveedor', value: 'name' ,input:''},
        //   { text: 'Oferta', value: 'offer' },
          { text: 'Nombres', value: 'first_name',input:''},
          { text: 'Apellidos', value: 'last_name',input:''},
          { text: 'Cargo', value: 'position',input:''},
          { text: 'Email', value: 'email',input:''},
          { text: 'Telefono', value: 'phone',input:''},
          { text: 'Balance', value: 'balance',input:'', sortable: false},
          { text: 'Debito', value: 'debit',input:'', sortable: false},
          { text: 'Acciones',value:'actions',input:'',  sortable: false },
        ],
        providers: [],
        loading: true,
        newProvider: null,
        newContacts:[],
        newContact: null,
        editedItem: -1,
        page:1,
        last_page:1
      }
    },
    mounted()
    {
        this.search();
    },
    created(){
          axios.get('/api/provider/create')
                .then((response) => {                                       
                    this.newProvider = response.data.provider; 
                    this.newContact = response.data.contact; 
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
                this.getData('/api/provider',this.getParams()).then((data)=>{
                    this.providers = data.data;
                    this.last_page = data.last_page;
                    resolve();
                });
            });
        },    
        editItem (item) {
            this.editedIndex = this.providers.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        save () {
            // if (this.editedIndex > -1) {
            // Object.assign(this.providers[this.editedIndex], this.editedItem)
            // } else {
                this.providers.push(this.editedItem)
            // }
            this.close()
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
