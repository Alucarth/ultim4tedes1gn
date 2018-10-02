<template>
<v-container fluid grid-list-xs>
    <v-layout row wrap>
      <v-flex xs6>
    <v-card class="px-0">
        <v-card-title>
            Madera
        <v-spacer></v-spacer>

        <v-dialog v-model="dialog" max-width="500px">            
            <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text v-if="newLumber">
                <v-container grid-list-md>
                 <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Alto" hint="Ingrese el alto de la madera" required v-model="newLumber.high"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Ancho" hint="Ingrese el ancho de la madera" v-model="newLumber.width"></v-text-field>
                    </v-flex>   
                    <v-flex xs12 sm6 md4>
                        <v-text-field
                        label="Densidad"
                        hint="Ingrese la densidad de la madera"                  
                        required
                        v-model="newLumber.density"
                        ></v-text-field>
                    </v-flex>                          
                    <v-flex xs12 sm6>
                        <v-select                  
                        label="Tipo de madera"
                        v-model="newLumber.type_id"
                        :items="types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-select                  
                        label="Especie"                
                        v-model="newLumber.specie_id"  
                        :items="species"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion de la madera seleccionada`"
                        persistent-hint>                                
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="newLumber.description" ></v-text-field>
                    </v-flex>  
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="store(newLumber)" v-if="editedIndex === -1">store</v-btn>
                <v-btn color="blue darken-1" flat @click="update(newLumber)" v-else>update</v-btn>                                
            </v-card-actions>
            </v-card>
        </v-dialog>


        <v-btn @click="create();" color="primary" dark class="mb-2">Nuevo</v-btn>
        </v-card-title>


        <v-layout row wrap>
<!-- // style="max-width: 100%" -->
        <v-data-table 
        :headers="headers"
        :items="lumbers"        
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
                            <!-- <v-icon small @click="toggleOrder(header.value)" v-if="header.value == filterName ">{{pagination.descending==false?'arrow_upward':'arrow_downward'}}</v-icon> -->
                        </v-flex>
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <tr @click="addToPurchase(props.item)">
                <td class="text-xs-left">{{ props.item.specie.name }}</td>
                <td class="text-xs-left">{{ props.item.type.name }}</td>      
                <td class="text-xs-left" >{{ props.item.high }}</td>            
                <td class="text-xs-left">{{ props.item.width }}</td>
                <td class="text-xs-left">{{ props.item.density }}</td>      
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
            <v-card flat v-if="lumber">
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
            </v-card>
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
            Compra
        <v-spacer></v-spacer>
        <v-btn @click="store();" color="primary" dark class="mb-2">Guardar</v-btn>
        </v-card-title>
        <v-layout row wrap>
            <v-flex xs12 sm4 md4 v-if="providers">                
                <v-select                  
                        label="Proveedor"
                        v-model="purchase.provider_id"
                        :items="providers"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>

            </v-flex>
            <v-flex xs12 sm4 md4>
                <v-text-field label="CEFO" v-model="purchase.cefo" hint="Ingrese codigo CEFO" required ></v-text-field>
            </v-flex>
            <v-flex xs12 sm4 md4>
                <v-text-field label="Costo" v-model="purchase.amount" hint="Ingrese Costo Total" required ></v-text-field>
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
                    v-model="purchase.date"
                    label="Fecha"          
                    readonly
                    ></v-text-field>
                    <v-date-picker v-model="purchase.date" @input="$refs.menu2.save(date)"></v-date-picker>

                </v-menu>
            </v-flex>
            <v-flex xs12 sm4 md8>
                <v-text-field label="Descripcion" v-model="purchase.description" hint="description"></v-text-field>
            </v-flex>
            <br>
        <v-data-table        
        :headers="purchase_headers"
        :items="purchase_lumbers"
         hide-actions        
        >
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.specie.name+'-'+props.item.type.name }}</td>
                <td class="text-xs-left" >{{ props.item.high+'X'+props.item.width+'X'+props.item.density }}</td>                                                            
                <td class="text-xs-left">
                    <v-text-field label="Cantidad" v-model="props.item.quantity" hint="Ingrese cantidad" required></v-text-field>
                </td>
                <td class="justify-center layout px-0">                    
                    <v-icon
                        small
                        @click="removeFromPurchase(props.index)"
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
            { text: 'Especie', value: 'specie' },
            { text: 'Tipo', value: 'type' },
            { text: 'Alto', value: 'high' },        
            { text: 'Ancho', value: 'width' },
            { text: 'Espesor', value: 'density' },             
        ],
        purchase_headers: [
            { text: 'Madera', value: 'Madera' },
            { text: 'Medida', value: 'Madera' },
            { text: 'Cantidad', value: 'Madera' },            
        ],
        species: null,
        types: null,
        lumbers: [],
        purchase_lumbers: [],
        lumber: null,
        newLumber: null,
        totalLumber: 0,        
        loading: true,
        filterName: 'high',
        filterValue: '',   
        dialog: false,
        editedIndex: -1,          
        date : null,
        last_page: 1,
        page: 1,    
        paginationRows: 10,
        providers: [],
        purchase: null,
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
        
    },
    methods:{
        search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/lumber',this.getParams()).then((data)=>{
                    this.lumbers = data.data;                    
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
        setFilter(filterName){
            this.filterValue='',
            this.filterName = filterName;
        },
        createLumber() {                                    
            axios.get('/api/auth/lumber/create')            
            .then(response => {                
                console.log(response.data.lumber);
                this.newLumber = response.data.lumber;                
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = true;
        },
        storeLumber(){

        },
        create () {
            axios.get('/api/auth/purchase/create')            
            .then(response => {                
                console.log(response.data.pivot);
                this.purchase = response.data.purchase;                
                this.pivot = response.data.pivot;
            })
            .catch(error => {                
                console.log(error);
            });            
        },
        store () {                        
            axios.post('/api/auth/purchase/', {purchase: this.purchase, lumbers: this.purchase_lumbers})
            .then(response => {                
                //this.lumbers.push(response.data.lumber);
                alert('Compra realizada');
                this.$router.replace('/purchase');
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
        close() {
            this.dialog = false;
        },
        addToPurchase(item) {            
            item.quantity = '';
            this.purchase_lumbers.push(item);
        },
        removeFromPurchase(index) {
            this.purchase_lumbers.splice(index, 1);
        }
        
    }
}
</script>
