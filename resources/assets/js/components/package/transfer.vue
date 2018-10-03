<template>
<v-container fluid grid-list-xs>
    <v-layout row wrap>
      <v-flex xs6>
    <v-card class="px-0">
        <v-card-title>
            Transferencia de Almacenes
        <v-spacer></v-spacer>


        <v-btn to="/package/create" color="primary" dark class="mb-2">Nuevo empaquetado</v-btn>
        </v-card-title>


        <v-layout row wrap>

        <v-data-table 
        :headers="headers"
        :items="packages"        
        hide-actions
        style="max-width: 100%"
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
                        </v-flex>
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <tr @click="addToTransfer(props.item)">
                <td class="text-xs-left">{{ props.item.code }}</td>
                <td class="text-xs-left">{{ props.item.name }}</td>      
                <td class="text-xs-left" >{{ props.item.storage.name }}</td>                            
                <!-- <td class="justify-center layout px-0">
                    <v-icon
                        small
                        class="mr-2"
                        @click="show(props.item);props.expanded = !props.expanded"
                    >
                        toc
                    </v-icon>                    
                </td>       -->
            </tr>
        </template>
        <template slot="expand" slot-scope="props">
            <!-- <v-card flat v-if="transfer">
                <table>
                    <tr>
                        <td> 
                            Especie
                        </td>
                        <td>
                            <v-card-text>
                                {{ lumber.specie.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Tipo
                        </td>
                        <td>
                            <v-card-text>
                                {{ lumber.type.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Alto
                        </td>
                        <td>
                            <v-card-text>
                                {{ lumber.high }}
                            </v-card-text>
                        </td>                 
                    </tr>
                    <tr>
                        <td> 
                            Ancho
                        </td>
                        <td>
                            <v-card-text>
                                {{ lumber.width }}
                            </v-card-text>
                        </td>       
                    </tr>
                    <tr>
                        <td> 
                            Espesor
                        </td>
                        <td>
                            <v-card-text>
                                {{ lumber.density }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Descripción 
                        </td>
                        <td>
                            <v-card-text>
                                {{ lumber.description }}
                            </v-card-text>
                        </td>
                    </tr>
                </table>                                
            </v-card> -->
        </template>

        <!-- <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert> -->
        </v-data-table>        
        <div class="text-xs-center">
            <v-pagination
            v-model="page"
            :length="last_page"
            :total-visible="10"
             @input="next"
            ></v-pagination>
        </div> 
        </v-layout>
    </v-card>
      </v-flex>
      <v-flex xs6>
    <v-card>
        <v-card-title>
            A transferir
        <v-spacer></v-spacer>
        <v-btn @click="store();" color="primary" dark class="mb-2">Guardar</v-btn>
        </v-card-title>
        <v-layout row wrap>
            <v-flex xs12 sm4 md4>
                <v-text-field label="Codigo" v-model="transfer.number" hint="Ingrese codigo paquete" required ></v-text-field>
            </v-flex>
            <v-flex xs12 sm4 md4>
                <v-text-field label="Description" v-model="transfer.description" hint="Ingrese descripcion"></v-text-field>
            </v-flex>
            <v-flex xs12 sm4 md4 v-if="storages">                
                <v-select                  
                    label="Almacen"
                    v-model="transfer.storage_destination_id"
                    :items="storages"
                    item-text="name"
                    item-value="id"
                    :hint="`Descripcion del tipo seleccionado`"
                    persistent-hint>
                    </v-select>
            </v-flex>                                    
            <br>
        <v-data-table        
        :headers="transfer_headers"
        :items="transfer_packages"
         hide-actions
        >
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.code }}</td>
                <td class="text-xs-left">{{ props.item.name }}</td>      
                <td class="text-xs-left" >{{ props.item.storage.name }}</td>
                <td class="justify-center layout px-0">                    
                    <v-icon
                        small
                        @click="removeFromTransfer(props.index)"
                    >
                        delete
                    </v-icon>
                </td>      
            <!-- </tr> -->
        </template>               
        </v-data-table>        
        
        </v-layout>
    </v-card>
      </v-flex>
    </v-layout>
</v-container>    
</template>
<script>
export default {
    data () {
      return {        
        pagination: {
          sortBy: 'name'
        },
        headers: [          
            { text: 'Codigo', value: 'code' },
            { text: 'Nombre', value: 'name' },
            { text: 'Almacen', value: 'storage' },
        ],
        transfer_headers: [
            { text: 'Codigo', value: 'code' },
            { text: 'Nombre', value: 'name' },
            { text: 'Almacen', value: 'storage' },            
        ],        
        packages: [],
        transfer_packages: [],    
        transfer: null,    
        totalPackage: 0,        
        loading: true,        
        dialog: false,
        editedIndex: -1,                  
        last_page: 1,
        page: 1,    
        paginationRows: 10,
        storages: [],
        pivot: null,        
      }
    },
    computed: {
        formTitle () {
                return this.editedIndex === -1 ? 'Nuevo' : 'Editar'
            }
    },
    mounted()
    {
        this.create();        
        this.search();        
        this.getStorages();
        
    },
    methods:{
        search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/package',this.getParams()).then((data)=>{
                    console.log("");
                    console.log(data.data);
                    this.packages = data.data;
                    this.last_page = data.last_page;
                    resolve();                    
                });
            });            
        },
        getParams () {
            let params={};
            this.headers.forEach(element => {
                params[element.value] = element.input;
            });
            params['order']=this.pagination.descending==true?'asc':'desc';
            params['page']=this.page;
            params['pagination_rows']=this.paginationRows;
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
        next(page){
            this.page = page;
            this.search();
        }, 
        toggleOrder (index) {
            this.pagination.sortBy = this.headers[index].value
            this.pagination.descending = !this.pagination.descending
             
            
        },
        setFilter(filterName){package_transaction
            this.filterValue='',
            this.filterName = filterName;
        },
        createLumber() {                                    
            axios.get('/api/auth/package/transfer')
            .then(response => {                                
                this.transfer = response.data.transfer;
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = true;
        },
        storeLumber(){

        },
        create () {
            console.log('creating');
            axios.get('/api/auth/package_transaction/create')
            .then(response => {                        
                this.transfer = response.data.transfer;
            })
            .catch(error => {                
                console.log(error);
            });
        },
        store () {                        
            axios.post('/api/auth/package_transaction/', {transfer: this.transfer, packages: this.transfer_packages})
            .then(response => {                                
                alert('Madera empaquetada');
                this.$router.replace('/storage');
            })
            .catch(error => {                
                console.log(error);
            });            
        },
        show(item) {                        
            axios.get(`/api/auth/lumber/${item.id}`)            
            .then(response => {                
                this.lumber = response.data.lumber
            })
            .catch(error => {                
                console.log(error);
            });
        },        
        getSpecies (){
            axios.get('/api/auth/specie')
            .then(response => {
                this.species = response.data.species          
            })
            .catch(error => {
                console.log(error);
            });
        },
        getTypes() {
            axios.get('/api/auth/type')
            .then(response => {
                this.types = response.data.types          
            })
            .catch(error => {
                console.log(error);
            });
        },
        getStorages () {
            axios.get('/api/auth/storage')
            .then(response => {
                console.log(response.data.data);
                this.storages = response.data
            })
            .catch(error => {
                console.log(error);
            });
        },
        close() {
            this.dialog = false;
        },
        addToTransfer(item) {            
            item.quantity = '';
            this.transfer_packages.push(item);
        },
        removeFromTransfer(index) {
            this.transfer_packages.splice(index, 1);
        }
        
    }
}
</script>
