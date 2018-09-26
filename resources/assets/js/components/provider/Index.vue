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
                    <v-flex xs12 sm6 md12>
                    <v-text-field v-model="newProvider.direccion2" label="Direccion 2"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md12>
                    <v-text-field v-model="newProvider.city" label="Ciudad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.balance" label="Balance"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="newProvider.debit" label="Debito"></v-text-field>
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
                            <span @click="toggleOrder(header.value)">{{ header.text }}
                                
                            </span>
                            <v-menu 
                                    :close-on-content-click="false"
                                    >
                                    <v-btn
                                        slot="activator"
                                        icon
                                        @click="toggleOrder(header.value)"
                                        v-if="header.sortable!=false"
                                    >
                                    <v-icon  small>fa-filter</v-icon>
                                    </v-btn>
                                    <v-card  >
                                        <v-text-field
                                         outline
                                         hide-details
                                        v-model="filterValue"
                                        append-icon="search"
                                        :label="`Buscar ${header.text}...`"
                                       
                                        @keydown.enter="search(header.value)"
                                    ></v-text-field>
                                    
                                    </v-card>
                            </v-menu>
                            <v-icon small @click="toggleOrder(header.value)" v-if="header.value == filterName ">{{pagination.descending==false?'arrow_upward':'arrow_downward'}}</v-icon>
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
          
          { text: 'Proveedor', value: 'name' },
        //   { text: 'Oferta', value: 'offer' },
          { text: 'Nombres', value: 'first_name' },
          { text: 'Apellidos', value: 'last_name' },
          { text: 'Cargo', value: 'position' },
          { text: 'Email', value: 'email' },
          { text: 'Telefono', value: 'phone' },
          { text: 'Balance', value: 'balance', sortable: false},
          { text: 'Debito', value: 'debit' , sortable: false},
          { text: 'Acciones',value:'actions',  sortable: false },
        ],
        providers: [],
        loading: true,
        filterName: 'name',
        filterValue: '',
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
        this.search('name');
    },
    created(){
          axios.get('/api/provider/create')
                .then((response) => {                                       
                    this.newProvider = response.data.provider; 
                    this.newContact = response.data.contact; 
                });    
    },
    methods:{
        
        getItems(url){
            return new Promise((resolve,reject)=>{
               this.loading = true;
               axios.get(url)
                    .then((response) => {
                        this.loading = false;
                        resolve(response.data);
                    });
            });
        },
        next(page){
            // console.log(page);
            let orderBy = this.pagination.descending==true?'asc':'desc';
            this.getItems('/api/provider?page='+page+'&search='+this.filterValue+'&sorted='+this.filterName+'&order='+orderBy).then((data)=>{
                this.providers = data.data;
                this.last_page = data.last_page;
            });
        },
        search(filter){
            
            this.filterName = filter;
            
            return new Promise((resolve,reject)=>{
                let orderBy = this.pagination.descending==false?'desc':'asc';
                // console.log(orderBy);
                this.getItems('/api/provider?search='+this.filterValue+'&sorted='+this.filterName+'&order='+orderBy).then((data)=>{
                    this.providers = data.data;
                    this.last_page = data.last_page;
                    resolve();
                });
            });
        },
      
        toggleOrder (filter) {
            this.pagination.sortBy = filter;
            this.search(filter).then(()=>{ 
                this.pagination.descending = !this.pagination.descending;
                // console.log('ordenando');
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
        filterValue (fv) {      
            if (fv =='') {
                this.search('name');
            }
        }
    },
    computed:{
        formTitle () {
            return this.editedIndex === -1 ? 'Nuevo Proveedor' : 'Editar Proveedor'
        }
    }
}
</script>
