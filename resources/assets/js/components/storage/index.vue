<template>
    <v-card>
        <v-card-title>
            Almacenes
        <v-spacer></v-spacer>

        <v-dialog v-model="dialog" max-width="500px">            
            <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text v-if="newStorage">
                <v-container grid-list-md>
                 <v-layout wrap>                   
                     <v-flex xs12>
                        <v-text-field label="Nombre" v-model="newStorage.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="newStorage.description" ></v-text-field>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="store(newStorage)" v-if="editedIndex === -1">Guardar</v-btn>
                <v-btn color="blue darken-1" flat @click="update(newStorage)" v-else>Actualizar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>


<v-btn @click="create()" color="primary" dark class="mb-2">Nuevo</v-btn>    
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="storages"
        :search="search"
            :pagination.sync="pagination"
        >
        <template slot="headers" slot-scope="props" >
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
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left" >{{ props.item.id }}</td>            
                <td class="text-xs-left">{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.description }}</td>                    
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
                        @click="edit(props.item)"
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
            <!-- </tr> -->
        </template>
        <template slot="expand" slot-scope="props">
            <v-card flat v-if="storage">
                <v-card-text>{{ storage.name }}</v-card-text>
                <v-card-text>{{ storage.description }}</v-card-text>
            </v-card>
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
            { text: 'ID', value: 'id' },        
            { text: 'Nombre', value: 'name' },
            { text: 'Descripcion', value: 'description' },            
        ],                
        storages: [],        
        storage: null,
        newStorage: null,
        totalStorage: 0,        
        loading: true,
        filterName: 'name',
        filterValue: '',   
        dialog: false,
        editedIndex: -1,          
      }
    },
    computed: {
        formTitle () {
                return this.editedIndex === -1 ? 'Agregar Nuevo Almacen' : 'Editar Almacen'
            }
    },
    mounted()
    {
        this.getStorages().then(
            this.getDataFromApi()
                .then(data => {
                this.storages = data.storages
                this.totalStorage = data.total
                })
        );                
    },
    methods:{
        getDataFromApi () {            
            return new Promise((resolve, reject) => {
            const { sortBy, descending, page, rowsPerPage } = this.pagination

            let items= this.storages;
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
        getStorages(withFilter){
            console.log("starting receiving data");
            return new Promise((resolve,reject)=>{
               this.loading = true
               let filterName = withFilter==true?this.filterName:'name';
               console.log(withFilter);
               axios.get('/api/auth/getStorageData',{ name:filterName,value:this.filterValue})
                    .then((response) => {
                                        // let providers = response.data;
                                        console.log(response.data);
                            this.storages = response.data.storages;
                                        this.loading = false
                                        resolve();
                                    });
                        });
        },
        getResult(withFilter){
            console.log(this.filterName);
            //axios.post('/api/providers/getdata',{name:this.filterName})
              //   .then((response)=>{ console.log(response.data)});
              this.getStorages(withFilter).then(
                        this.getDataFromApi()
                            .then(data => {
                            this.storages = data.storages
                            this.totalStorages = data.total
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
        create() {                                    
            this.editedIndex = -1;
            axios.get('/api/auth/storage/create')
            .then(response => {                                
                this.newStorage = response.data.storage
            })
            .catch(error => {
                console.log(error);
            });
            this.dialog = true;
        },
        store(){
            let index = -1;
            console.log(this.newStorage);
            axios.post('/api/auth/storage', this.newStorage)
            .then(response => {                        
                console.log(response.data.storage);
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;            
        },
        show(item) {                        
            axios.get(`/api/auth/storage/${item.id}`)            
            .then(response => {                
                this.storage = response.data.storage
            })
            .catch(error => {                
                console.log(error);
            });
        },
        edit (item) {
            this.editedIndex = this.storages.indexOf(item);
            axios.get(`/api/auth/storage/${item.id}/edit`)            
            .then(response => {                
                this.newStorage = response.data.storage
            })
            .catch(error => {                
                console.log(error);
            });            
            this.dialog = true
        },
        update (item) {                        
            let index = this.editedIndex;            
            axios.put(`/api/auth/storage/${this.newStorage.id}`, this.newStorage)
            .then(response => {
                this.storages[index].name = response.data.storage.name
                this.storages[index].description = response.data.storage.description
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;            
        },
        destroy (item) {
            let success_delete = false;
            axios.delete(`/api/auth/storage/${item.id}`)
            .then(function (response) {
                console.log(response.data.storage_id);
                success_delete = true;
            })
            .catch(function (error) {
                console.log(error);                
            });            
        },        
        close() {
            this.dialog = false;
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
    }
}
</script>
