<template>
<v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 md6 lg6>
          <v-card class="px-0">
            <v-card-title>
                Madera
            <v-spacer></v-spacer>

            <v-dialog v-model="dialog" max-width="500px">            
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>
                    <v-card-text v-if="newInventory">
                        <v-container grid-list-md>
                            <v-layout wrap>                   
                                <v-flex xs12>
                                <v-text-field label="Code" v-model="newInventory.code" ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-select                  
                                label="Tipo"
                                v-model="newInventory.inventory_type_id"
                                :items="inventory_types"
                                item-text="name"
                                item-value="id"
                                :hint="`Descripcion del tipo seleccionado`"
                                persistent-hint>
                                </v-select>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-select                  
                                label="Familia"
                                v-model="newInventory.family_id"
                                :items="families"
                                item-text="name"
                                item-value="id"
                                :hint="`Familia`"
                                persistent-hint>
                                </v-select>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-select                  
                                label="Unidad"
                                v-model="newInventory.unit_id"
                                :items="units"
                                item-text="name"
                                item-value="id"
                                :hint="`Unidad`"
                                persistent-hint>
                                </v-select>
                            </v-flex>
                            <v-flex xs6>
                                <v-text-field label="Stock mínimo" v-model="newInventory.minimum" ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field label="Descripción" v-model="newInventory.description" ></v-text-field>
                            </v-flex>
                            <v-switch
                                :label="'Activo'"
                                v-model="newInventory.active"
                            ></v-switch>
                        </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                        <v-btn color="blue darken-1" flat @click="store(newInventory)" v-if="editedIndex === -1">Guardar</v-btn>
                        <v-btn color="blue darken-1" flat @click="update(newInventory)" v-else>Actualizar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            
            <v-btn @click="create();" color="primary" dark class="mb-2">Nuevo</v-btn>
            </v-card-title>
        <v-data-table 
        :headers="headers"
        :items="inventories"
        hide-actions
        style="max-width: 100%"
        >
     <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
                        <v-flex v-if="header.value!='actions'">
                            <v-tooltip bottom>
                                <span slot="activator">{{header.text}}</span>
                                <span >{{header.input}}</span>
                            </v-tooltip>
                            <v-menu  v-model="header.menu"
                                    :close-on-content-click="false"
                                    >
                                    <v-btn
                                        slot="activator"
                                        icon
                                   
                                        v-if="header.sortable!=false"
                                    >
                                    <v-icon :color="header.input!=''?'blue':'black'" small>fa-filter</v-icon>
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
            <tr @click="addToBuyout(props.item)">
                <td class="text-xs-left">{{ props.item.code }}</td>
                <td class="text-xs-left">{{ props.item.description }}</td>      
                <td class="text-xs-left" >{{ props.item.type.name }}</td>            
                <td class="text-xs-left">{{ props.item.family.name }}</td>
                <td class="text-xs-left">{{ props.item.unit.name }}</td>      
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
            <!-- <v-card flat v-if="lumber">
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
            :total-visible="5"
             @input="next"
            ></v-pagination>
        </div>
        <div class="text-xs-right">
            
            <v-flex xs11 sm11 md11>
                Mostrando {{from}}-{{to}} de {{total}} registros 
            </v-flex>

        </div> 

            </v-card>
        </v-dialog>
      </v-flex>
      <v-flex xs12 md6 lg6>
    <v-card>
        <v-card-title>
            Compra de insumo
        <v-spacer></v-spacer>
        <v-btn @click="store();" color="primary" dark class="mb-2">Guardar</v-btn>
        </v-card-title>
        <v-container grid-list-md>
        <v-layout wrap v-if="buyout">
            <v-flex xs12 sm4 md4 v-if="providers">                
                <v-select                  
                    label="Proveedor"
                    v-model="buyout.provider_id"
                    :items="providers"
                    item-text="name"
                    item-value="id"
                    :hint="`Descripcion del tipo seleccionado`"
                    persistent-hint>
                </v-select>
            </v-flex>
            <v-flex xs12 sm4 md4 v-if="employees">
                <v-select                  
                    label="Encargado"
                    v-model="buyout.employee_id"
                    :items="employees"
                    item-text="name"
                    item-value="id"
                    :hint="`Descripcion del tipo seleccionado`"
                    persistent-hint>
                </v-select>
            </v-flex>            
            <v-flex xs12 sm4 md4>
                <v-text-field label="Costo" v-model="buyout.amount" hint="Ingrese Costo Total" required ></v-text-field>
            </v-flex>
            <v-flex xs12 sm4 md4>
                 <v-menu
                    ref="menu2"
                    :close-on-content-click="false"                    
                    :nudge-right="40"
                    :return-value.sync="date"
                    lazy
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="290px"
                >
                    <v-text-field
                    slot="activator"
                    v-model="buyout.date"
                    label="Fecha"          
                    readonly
                    ></v-text-field>
                    <v-date-picker v-model="buyout.date" @input="$refs.menu2.save(date)"></v-date-picker>

                </v-menu>
            </v-flex>
            <v-flex xs12 sm4 md8>
                <v-text-field label="Descripcion" v-model="buyout.description" hint="description"></v-text-field>
            </v-flex>
            <v-flex xs12 sm12 md12>
                 <v-data-table        
                    :headers="buyout_headers"
                    :items="buyout_inventory"
                    hide-actions        
                    >
                    <template slot="items"  slot-scope="props">
                        <!-- <tr @click="props.expanded = !props.expanded"> -->
                            <td class="text-xs-left">{{ props.item.code }}</td>
                            <td class="text-xs-left" >{{ props.item.description }}</td>
                            <td class="text-xs-left">
                                <v-layout wrap>
                                    <v-flex xs12 sm10 md10>
                                    <v-text-field label="Cantidad" v-model="props.item.quantity" hint="Ingrese cantidad" required></v-text-field>
                                    </v-flex>
                                    

                                </v-layout>
                                
                            </td>
                            <td >
                                <v-flex xs12 sm4 md4>
                                        <v-icon
                                        small
                                        @click="removeFromBuyout(props.index)"
                                    >
                                        delete
                                    </v-icon>
                                    </v-flex>
                            </td>
                              
                        <!-- </tr> -->
                    </template>               
                </v-data-table>     
            </v-flex>
        </v-layout>  
        </v-container>  
        
      
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
            { text: 'Especie', value: 'specie' ,input:'', menu:false},
            { text: 'Tipo', value: 'type' ,input:'', menu:false},
            { text: 'Alto', value: 'high' ,input:'', menu:false},        
            { text: 'Ancho', value: 'width' ,input:'', menu:false},
            { text: 'Espesor', value: 'density' ,input:'', menu:false},            
        ],
        buyout_headers: [
            { text: 'Madera', value: 'Madera' },
            { text: 'Medida', value: 'Madera' },
            { text: 'Cantidad', value: 'Madera' },                 
        ],
        species: null,
        types: null,
        inventories: [],
        buyout_inventory: [],
        inventory: null,
        newInventory: null,
        totalInventory: 0,        
        loading: true,
        filterName: 'high',
        filterValue: '',   
        dialog: false,
        editedIndex: -1,          
        date : null,
         last_page: 1,
        page: 1,    
        paginationRows: 10,
         total:0,
        from:0,
        to:0,     
        pagination_select:[10,20,30],
        providers: [],
        employees: [],
        buyout: null,
        pivot: null,
        pl: [],
      }
    },
    computed: {
        formTitle () {
                return this.editedIndex === -1 ? 'Nuevo' : 'Editar'
            }
    },
    mounted()
    {        
        this.search();
        this.create();
        this.getSpecies();
        this.getTypes();
        this.getProviders();
        this.getEmployees();        
    },
    methods:{
        search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/inventory',this.getParams()).then((data)=>{
                    this.inventories = data.data;                    
                    this.last_page = data.last_page;
                    this.total = data.total;
                    this.from = data.from;
                    this.to = data.to;
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
        setFilter(filterName){
            this.filterValue='',
            this.filterName = filterName;
        },
        createinventory() {                                    
            axios.get('/api/auth/inventory/create')            
            .then(response => {                
                console.log(response.data.inventory);
                this.newInventory = response.data.inventory;                
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = true;
        },
        storeinventory(){

        },
        create () {
            axios.get('/api/auth/buyout/create')            
            .then(response => {                
                //console.log(response.data.pivot);
                this.buyout = response.data.buyout;
                //this.pivot = response.data.pivot;
            })
            .catch(error => {                
                console.log(error);
            });            
        },
        store () {                        
            axios.post('/api/auth/buyout/', {buyout: this.buyout, inventories: this.buyout_inventory})
            .then(response => {                
                //this.inventory.push(response.data.inventory);
                alert('Compra realizada');
                this.$router.replace('/buyout');
            })
            .catch(error => {                
                console.log(error);
            });            
        },
        show(item) {                        
            axios.get(`/api/auth/inventory/${item.id}`)            
            .then(response => {                
                this.inventory = response.data.inventory
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
        getProviders () {
            axios.get('/api/auth/provider')
            .then(response => {
                console.log(response.data.data);
                this.providers = response.data.data
            })
            .catch(error => {
                console.log(error);
            });
        },
        getEmployees () {
            axios.get('/api/auth/employee')
            .then(response => {                
                this.employees = response.data.data
            })
            .catch(error => {
                console.log(error);
            });
        },
        close() {
            this.dialog = false;
        },
        addToBuyout(item) {            
            item.quantity = '';
            this.buyout_inventory.push(item);
        },
        removeFromBuyout(index) {
            this.buyout_inventory.splice(index, 1);
        },
        checkInput(search)
        {
            if(search=='')
            {
                this.search();
            }
        }
        
    }
}
</script>
