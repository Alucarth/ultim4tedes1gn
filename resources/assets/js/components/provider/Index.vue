<template>
    <v-card>
        <v-card-title>
        Provedores
        <v-spacer></v-spacer>
        <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            single-line
            hide-details
        >
        
        </v-text-field>
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="providers"
        :search="search"
            :pagination.sync="pagination"
        >
        <template slot="headers" scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
                        <v-flex>
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
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert>
        </v-data-table>
    </v-card>
</template>
<script>
export default {
    data () {
      return {
        search: '',
        pagination: {
          sortBy: 'name'
        },
        headers: [
          
          { text: 'Proveedor', value: 'name' },
        //   { text: 'Oferta', value: 'offer' },
          { text: 'Nombres', value: 'first_name' },
          { text: 'Apellidos', value: 'last_name' },
          { text: 'Email', value: 'email' },
          { text: 'Telefono', value: 'phone' },
          { text: 'Cargo', value: 'position' },
          { text: 'Balance', value: 'balance' },
          { text: 'Debito', value: 'debit' },
        ],
        providers: [],
        totalProviders: 0,
        desserts: [],
        loading: true,
        filterName: 'name',
        filterValue: '',
        // menu: false,
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
        );
        
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
               axios.post('/api/providers/getdata',{ name:filterName,value:this.filterValue})
                    .then((response) => {
                                        // let providers = response.data;
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
}
</script>
