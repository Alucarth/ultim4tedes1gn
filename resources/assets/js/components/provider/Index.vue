<template>
    <v-card>
        <v-card-title>
        Provedores
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="800px">
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
        >
        <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
                        <v-flex v-if="header.value!='actions'">
                            <span @click="toggleOrder(index)">{{ header.text }}
                                
                            </span>
                            <v-menu
                                    :close-on-content-click="false"
                                    
                                    >
                                    <v-btn
                                        slot="activator"
                                        icon
                                        @click="setFilter(header.value)"
                                    >
                                    <v-icon  small>fa-filter</v-icon>
                                    </v-btn>

                                    <v-card>
                                        <v-text-field
                                        v-model="filterValue"
                                        append-icon="search"
                                        :label="`Buscar ${header.text}...`"
                                    
                                        @keydown.enter="getResult(true)"
                                    ></v-text-field>
                                    
                                    </v-card>
                            </v-menu>
                            <v-icon small @click="toggleOrder(index)" v-if="header.value == pagination.sortBy">{{pagination.descending==false?'arrow_upward':'arrow_downward'}}</v-icon>
                        </v-flex>
                 
                   
                    <!-- <v-icon small>fa-filter</v-icon> -->
                  
                  
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
          { text: 'Balance', value: 'balance' },
          { text: 'Debito', value: 'debit' },
          { text: 'Acciones',value:'actions',  sortable: false },
        ],
        providers: [],
        totalProviders: 0,
        loading: true,
        filterName: 'name',
        filterValue: '',
        newProvider: null,
        newContacts:[],
        newContact: null,
        editedItem: -1,
      }
    },
    mounted()
    {
        this.getProviders().then(
            this.getDataFromApi()
                .then(data => {
                this.providers = data.items
                this.totalProviders = data.total
                })
                .catch(error => {                
                    console.log(error);
                })
                    
        );
        
    },
    created(){
          axios.get('/api/provider/create')
                .then((response) => {                                       
                    this.newProvider = response.data.provider; 
                    this.newContact = response.data.contact; 
                });
                    
    },
    methods:{
        getDataFromApi () {
            
            return new Promise((resolve, reject) => {
            const { sortBy, descending, page, rowsPerPage } = this.pagination

            let items= this.providers;            
            const total = items.length;

            if (this.pagination.sortBy) {
                items = items.sort((a, b) => {
                const sortA = a[sortBy]
                const sortB = b[sortBy]

                if (descending) {
                    if (sortA < sortB) return 1
                    if (sortA > sortB) return -1
                    return 0
                } else {
                    if (sortA < sortB) return -1
                    if (sortA > sortB) return 1
                    return 0
                }
                })
            }

            if (rowsPerPage > 0) {
                items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
            }

                resolve({
                items,
                total
                });
         
            })
        },
        getProviders(withFilter){
            return new Promise((resolve,reject)=>{
               this.loading = true
               let filterName = withFilter==true?this.filterName:'name';
               console.log(withFilter);
               axios.post('/api/getProviderData',{ name:filterName,value:this.filterValue})
                    .then((response) => {
                                        console.log(response.data);
                            this.providers = response.data;            
                                        this.loading = false
                                        resolve();
                                    });
                        });
        },
        getResult(withFilter){
            console.log(this.filterName);
            //axios.post('/api/providers/getdata',{name:this.filterName})
              //   .then((response)=>{ console.log(response.data)});
              this.getProviders(withFilter).then(
                        this.getDataFromApi()
                            .then(data => {
                            this.providers = data.items
                            this.totalProviders = data.total
                            })
                    );
        },
        toggleOrder (index) {
            this.pagination.sortBy = this.headers[index].value
            this.pagination.descending = !this.pagination.descending
             
            
        },
        setFilter(filterName){
            this.filterValue='',
            this.filterName = filterName;
        },
        editItem (item) {
            this.editedIndex = this.providers.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            const index = this.providers.indexOf(item)
            confirm('Esta seguro de borrar a este proveedor?') && this.providers.splice(index, 1)
        },
        close () {
            this.dialog = false
            setTimeout(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
            }, 300)
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
        pagination: {
            handler () {
            this.getDataFromApi()
                .then(data => {
                this.desserts = data.items
                this.totalDesserts = data.total
                })
            },
            deep: true
        },
        filterValue (fv) {      
            if (fv =='') {
                this.getResult(false)
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
