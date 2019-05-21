<template>
    <v-card>
        <v-card-title>
           <v-toolbar flat color="white">
                <v-toolbar-title>Compra de Madera
                    
                </v-toolbar-title>
                <v-spacer></v-spacer>
                
                <v-btn to="/create_purchase" color="primary" dark class="mb-2" small >Nuevo <v-spacer></v-spacer>  <v-icon small>fa-plus-circle</v-icon> </v-btn>
            </v-toolbar>
       
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="purchases"        
        hide-actions
        >
        <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
                        <v-flex v-if="header.value!='actions'">
                            <v-flex v-if="header.filter">
                            <!-- <v-btn flat >{{header.text }} <v-icon  right small> fa-filter</v-icon></v-btn> -->
                            <v-text-field  
                                v-if="header.type=='text'"
                                append-icon="search"
                                :label="header.text"
                                v-model="header.input"
                                @keydown.enter="search()"
                                @keyup.delete="checkInput(header.input)"
                            ></v-text-field>
                            <v-combobox
                                v-if="header.type=='select' && header.items.length>0"
                                v-model="header.input"
                                :items="header.items"
                                :label="header.text"
                                item-text="name"
                                @change="search()"
                            ></v-combobox>
                        </v-flex>
                        <span v-else> {{header.text}} </span>
                    
                    </v-flex>
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.cefo }}</td>
                <td class="text-xs-left">{{ props.item.provider.name }}</td>      
                <td class="text-xs-left" >{{ props.item.date }}</td>            
                <td class="text-xs-left">{{ props.item.amount }}</td>                
                <td class="justify-center layout px-0">
                   
                    <v-icon
                        small
                        class="mr-2"
                        @click="show(props.item)"
                    >
                        toc
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
             <!-- <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert> -->
        </v-data-table>
         <v-card-text>  
            <v-layout row justify-space-between>
            <v-flex xs1 sm2>
                <v-combobox
                    v-model="paginationRows"
                    :items="pagination_select"
                    label="Mostrar Registros"
                    @change="search()"
                ></v-combobox>
            </v-flex>
            <v-flex xs5>
                <v-pagination
                    v-model="page"
                    :length="last_page"
                    :total-visible="10"
                    @input="next"

                > </v-pagination>
            </v-flex>
            <v-flex xs1  sm2>
                <div class="caption"> Mostrando {{from}}-{{to}} de {{total}} </div>
            </v-flex>
            </v-layout>
      
            
        </v-card-text>
        
        <!-- colocar aqui los dialogos -->
        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
        <v-card v-if="purchase">
            <v-toolbar dark color="primary">
            <v-btn icon dark @click="dialog = false">
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>Cefo: {{purchase.cefo}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn dark flat @click="dialog = false">cerrar</v-btn>
            </v-toolbar-items>
            </v-toolbar>
            <v-list three-line subheader>
            <v-subheader>Compra </v-subheader>
            <v-list-tile avatar>
                <v-list-tile-avatar> 
                    <v-icon>fa-user</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                <v-list-tile-title>{{purchase.provider.name}}</v-list-tile-title>
                <v-list-tile-sub-title>Proveedor</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile avatar>
                <v-list-tile-avatar> 
                    <v-icon>fa-calendar</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                <v-list-tile-title>{{purchase.date}}</v-list-tile-title>
                <v-list-tile-sub-title>Fecha</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile avatar>
                <v-list-tile-avatar> 
                    <v-icon>fa-comment</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                <v-list-tile-title>{{purchase.description}}</v-list-tile-title>
                <v-list-tile-sub-title>Descripcion</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            
            </v-list>
            <v-divider></v-divider>
            <v-list three-line subheader>
            <v-subheader>Detalle</v-subheader>
                <v-tabs
                centered
                color="cyan"
                dark
                icons-and-text
            >
                <v-tabs-slider color="yellow"></v-tabs-slider>

                <v-tab href="#tab-1">
                Compras 
                <v-icon>shopping_cart</v-icon>
                </v-tab>

                <v-tab href="#tab-2">
                Gastos
                <v-icon>attach_money</v-icon>
                </v-tab>

                <v-tab-item
                id="tab-1"
                >
                    <v-chip color="green" text-color="white">
                    <v-avatar class="green darken-4"> <v-icon small>fa-money</v-icon> </v-avatar>
                     {{getTotal}} 
                    </v-chip>
                    <v-chip color="green" text-color="white">
                    <v-avatar class="green darken-4"> <v-icon small>functions</v-icon> </v-avatar>
                        cantidad Pz: {{getQuantityPurchase}}
                    </v-chip>
                    <v-chip color="green" text-color="white">
                    <v-avatar class="green darken-4"> <v-icon small>functions</v-icon> </v-avatar>
                        cantidad Pie: {{getQuantityFeetPurchase}}
                    </v-chip>

              
                    <v-data-table
                    :headers="header_purchase"
                    :items="purchase.lumbers"
                    >
                    <template slot="items" slot-scope="props">
                
                        <td class="text-xs-left">{{ props.item.specie.name }}</td>
               
                        <td class="text-xs-left">{{ props.item.type.name }}</td>
                        <td class="text-xs-left">{{ props.item.unit.name }}</td>
                        <td class="text-xs-left">{{ props.item.density  }}</td>
                        <td class="text-xs-left">{{ props.item.width }}</td>
                        <td class="text-xs-left">{{ props.item.high }}</td>
                        <td class="text-xs-left">{{ getState(props.item.pivot.state_id).name }}</td>
                        <td class="text-xs-left">{{ props.item.pivot.quantity }}</td>
                        <td class="text-xs-left">{{ props.item.pivot.quantity_feet }}</td>
                        <td class="text-xs-left">{{ props.item.pivot.amount }}</td>
                        
                        
                    </template>
                    <!-- <v-alert slot="no-results" :value="true" color="error" icon="warning">
                        Su busqueda para "{{ search }}" no se encontraron resultados.
                    </v-alert> -->
                    </v-data-table>
                </v-tab-item>
                <v-tab-item
                id="tab-2"
                >
                
                   
                    
                        <v-chip color="green" text-color="white">
                        <v-avatar class="green darken-4"> <v-icon small>fa-money</v-icon> </v-avatar>
                        <h4>{{getTotalCost}}</h4> 
                        </v-chip>
                        <v-data-table
                            :headers="header_expensive"
                            :items="purchase.expenses"
                        >
                            <template slot="items" slot-scope="props">
                                
                                <td class="text-xs-left">{{ props.item.name }}</td>
                                <td class="text-xs-left">{{ props.item.pivot.cost }}</td>

                            </template>
                            <v-alert slot="no-results" :value="true" color="error" icon="warning">
                                Su busqueda para "{{ search }}" no se encontraron resultados.
                            </v-alert>
                        </v-data-table>
                   
             
                </v-tab-item>
            </v-tabs>
            </v-list>
        </v-card>
        </v-dialog>

    </v-card>
</template>
<script>
export default {
    data () {
      return {        
        pagination: {
          sortBy: 'name'
        },
        headers: [          
            { text: 'CEFO', value: 'cefo' ,input:'', type:'text', filter:true},
            { text: 'Proveedor', value: 'provider' ,input:'', type:'text', filter:true},
            { text: 'Fecha', value: 'date' ,input:'', type:'text', filter:true},        
            { text: 'Precio', value: 'amount' ,input:'', type:'text', filter:true},  
            { text: 'Accion', value: '', type:"text", filter:false, input:''},          
        ],
        header_purchase: [
            { text: 'Especie', value: 'especie' },
            // { text: 'Codigo', value: 'codigo' },
            { text: 'Tipo', value: 'tipo' },
            { text: 'Unidad', value: 'unidad' },
            { text: 'Espesor', value: 'espesor' },
            { text: 'Ancho', value: 'ancho' },
            { text: 'Largo', value: 'largo' },
            { text: 'Estado', value: 'estado' },
            { text: 'Cantidad', value: 'cantidad' },
            { text: 'Canitdad Pie', value: 'cantidad_pie' },
            { text: 'Precio Unitario', value: 'precio_unitario' },
        ],
        header_expensive:[
            { text: 'Nombre', value: 'name'},
            { text: 'Costo Bs', value: 'cost'},
        ],
        lumbers: [],
        purchases: [],
        states:[],
        purchase: null,
        totalPurchases: 0,        
        loading: true,                
        dialog: false,
        editedIndex: -1,          
        last_page: 1,
        page: 1,    
        paginationRows: 10,
        total:0,
        from:0,
        to:0,     
        pagination_select:[10,20,30]
      }
    },
    computed: {
        getTotal(){
            
            let amount = 0 ;
            if(this.purchase){
                amount = this.purchase.amount;
            }
            return "Bs "+numeral(amount).format('0,0.00');
        },
        getQuantityPurchase(){
            
            let amount = 0 ;
            if(this.purchase){
                
                this.purchase.lumbers.forEach(item => {
                    amount += parseFloat(item.pivot.quantity);
                });
            }
            return numeral(amount).format('0,0.00');
        },
        getQuantityFeetPurchase(){
            
            let amount = 0 ;
            if(this.purchase){
                
                this.purchase.lumbers.forEach(item => {
                    amount += parseFloat(item.pivot.quantity_feet);
                });
            }
            return numeral(amount).format('0,0.00');
        },
        getTotalCost(){
            
            let amount = 0 ;
            if(this.purchase){
                
                this.purchase.expenses.forEach(item => {
                    amount += parseFloat(item.pivot.cost);
                });
            }
            return "Bs "+numeral(amount).format('0,0.00');
        },
    },
    mounted()
    {
        axios.get('/api/auth/state/')            
            .then(response => {                                
                this.states = response.data.states;
                console.log(this.states);
                this.search(); 
                //his.newLumber = response.data.lumber                
            })
            .catch(error => {                
                console.log(error);
            });
                 
    },
    methods:{
        search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/purchase',this.getParams()).then((data)=>{
                    console.log("after response");
                    this.purchases = data.data;                    
                    console.log(this.purchases);
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
        create() {                            
            axios.get('/api/auth/lumber/create')            
            .then(response => {                                
                this.newLumber = response.data.lumber                
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = true;
        },
        store(){
            let index = -1;
            axios.post('/api/auth/lumber/', this.newLumber)
            .then(response => {                
                //this.lumbers.push(response.data.lumber);
                alert('dato creado');
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = false;
        },
        show(item) {                        
            axios.get(`/api/auth/purchase/${item.id}`)
            .then(response => {
                this.purchase = response.data.purchase
                console.log(this.purchase);
                this.dialog =true;
            })
            .catch(error => {                
                console.log(error);
            });
        },
        edit (item) {
            this.editedIndex = this.lumbers.indexOf(item)
            //this.editedItem = Object.assign({}, item)
            axios.get(`/api/auth/lumber/${item.id}/edit`)            
            .then(response => {                
                this.newLumber = response.data.lumber
            })
            .catch(error => {                
                console.log(error);
            });
            
            this.dialog = true
        },
        update (item) {                        
            let index = this.editedIndex;            
            axios.put(`/api/auth/lumber/${this.newLumber.id}`, this.newLumber)            
            .then(response => {                
                this.lumbers[index].high = response.data.lumber.high;
                this.lumbers[index].width = response.data.lumber.width;
                this.lumbers[index].density = response.data.lumber.density;
                this.lumbers[index].specie = response.data.lumber.specie;
                this.lumbers[index].type = response.data.lumber.type;
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;
            //this.getLumber();
        },
        destroy (item) {
            let success_delete = false;
            axios.delete(`/api/auth/lumber/${item.id}`)
            .then(function (response) {
                console.log(response.data.lumber_id);                   
                success_delete = true;
            })
            .catch(function (error) {
                console.log(error);                
            });                                    
            this.getLumber();
            
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
        close() {
            this.dialog = false;
        },
        checkInput(search)
        {
            if(search=='')
            {
                this.search();
            }
        },
        getState(id){
            return _.find(this.states, (state) => { return state.id == id }); //solucion temporal XD 
        }
        
    },    
}
</script>
