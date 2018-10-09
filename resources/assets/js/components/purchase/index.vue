<template>
    <v-card>
        <v-card-title>
            Compras de madera
        <v-spacer></v-spacer>       
        <v-btn to="/purchase/create" color="primary" dark class="mb-2">Nuevo</v-btn>
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
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.cefo }}</td>
                <td class="text-xs-left">{{ props.item.provider.name }}</td>      
                <td class="text-xs-left" >{{ props.item.date }}</td>            
                <td class="text-xs-left">{{ props.item.amount }}</td>                
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
            <v-card flat v-if="purchase">
                <table>
                    <tr>
                        <td> 
                            CEFO
                        </td>
                        <td>
                            <v-card-text>
                                {{ purchase.cefo }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Proveedor
                        </td>
                        <td>
                            <v-card-text>
                                {{ purchase.provider.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Fecha
                        </td>
                        <td>
                            <v-card-text>
                                {{ purchase.date }}
                            </v-card-text>
                        </td>                 
                    </tr>
                    <tr>
                        <td> 
                            Costo
                        </td>
                        <td>
                            <v-card-text>
                                {{ purchase.amount }}
                            </v-card-text>
                        </td>       
                    </tr>
                    <!-- <tr>
                        <td> 
                            Espesor
                        </td>
                        <td>
                            <v-card-text>
                                {{ lumber.density }}
                            </v-card-text>
                        </td>
                    </tr> -->
                    <tr>
                        <td> 
                            Descripción 
                        </td>
                        <td>
                            <v-card-text>
                                {{ purchase.description }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Descripción 
                        </td>
                        <td>
                        <v-data-table                
                            :headers="minitable_geaders"                                        
                            :items="purchase.lumbers"
                            hide-actions
                            class="elevation-1"
                        >
                            <template slot="items" slot-scope="props">
                            <td>{{ props.item.specie.name }}</td>
                            <td>{{ props.item.type.name }}</td>
                            <td>{{ props.item.high }}</td>
                            <td>{{ props.item.width}}</td>
                            <td>{{ props.item.density }}</td>
                            <td>{{ props.item.pivot.quantity }}</td>                            
                            </template>
                        </v-data-table>
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
            { text: 'CEFO', value: 'cefo' },
            { text: 'Proveedor', value: 'provider' },
            { text: 'Fecha', value: 'date' },        
            { text: 'Precio', value: 'amount' },            
        ],
        minitable_geaders: [
            { text: 'Especie', value: 'specie' },
            { text: 'Tipo', value: 'type' },
            { text: 'Alto', value: 'high' },
            { text: 'Ancho', value: 'width' },
            { text: 'Espesor', value: 'density' },
            { text: 'Cantidad', value: 'quantity' },
        ],
        lumbers: [],
        purchases: null,
        purchase: null,
        totalPurchases: 0,        
        loading: true,                
        dialog: false,
        editedIndex: -1,          
        last_page: 1,
        page: 1,    
        paginationRows: 10,
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
    },
    methods:{
        search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/purchase',this.getParams()).then((data)=>{
                    console.log("after response");
                    this.purchases = data.data;                    
                    console.log(this.purchases);
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
        }
        
    },    
}
</script>
