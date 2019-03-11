<template>
    <v-card>
        <!-- <v-card-title>
           <h3> Paquetes de madera </h3>
           <v-chip color="green" text-color="white">
            <v-avatar class="green darken-4" >  <v-icon>store</v-icon> </v-avatar>
             {{this.headers[2].input?this.headers[2].input.name:'Todos los Almacenes' }}
            </v-chip>
           <v-chip color="green" text-color="white">
            <v-avatar class="green darken-4" >  <v-icon>group_work</v-icon> </v-avatar>
            cantidad: {{this.cantidad}}
            </v-chip>
           <v-chip color="green" text-color="white">
            <v-avatar class="green darken-4" >  <v-icon>group_work</v-icon> </v-avatar>
            cantidad Pie: {{this.cantidad_pie}}
            </v-chip> -->
           
        <!-- <v-spacer></v-spacer>        
        <v-btn to="/package/create" color="primary" dark class="mb-2">Nuevo</v-btn>
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="packages"        
        hide-actions
        >
        <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
                        <v-flex v-if="header.value!='actions'">
                            <v-flex v-if="header.filter">
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
          
                <td class="text-xs-left">{{ props.item.code }}</td>
                <td class="text-xs-left">{{ props.item.name }}</td>      
                <td class="text-xs-left" >{{ props.item.storage.name }}</td>                           
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
           
        </template>
        <template slot="expand" slot-scope="props">
            <v-card flat v-if="packaged">
                <table>
                    <tr>
                        <td> 
                            C&oacute;digo
                        </td>
                        <td>
                            <v-card-text>
                                {{ packaged.code }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Nombre
                        </td>
                        <td>
                            <v-card-text>
                                {{ packaged.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Fecha
                        </td>
                        <td>
                            <v-card-text>
                                {{ packaged.storage.name }}
                            </v-card-text>
                        </td>                 
                    </tr>                   
                    <tr>
                        <td> 
                            Descripción 
                        </td>
                        <td>
                        <v-data-table                
                            :headers="minitable_headers"                                        
                            :items="packaged.lumbers"
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
        </v-data-table>
       <v-card-text>
            <div class="text-xs-center">
            <v-pagination
                v-model="page"
                :length="last_page"
                :total-visible="10"
                @input="next"
                
            > </v-pagination>
            </div>
            <v-spacer></v-spacer>
            Mostrando {{from}}-{{to}} de {{total}} 
        </v-card-text> -->
        <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config">
        </vue-bootstrap4-table>
    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';

export default {
    data () {
      return {        
        pagination: {
          sortBy: 'name'
        },
        headers: [          
            { text: 'Codigo', value: 'code', type:"text", filter:true, input:''},
            { text: 'Nombre', value: 'name', type:"text", filter:true, input:''},
            { text: 'Almacen', value: 'storage_id', type:"select", filter:true, items:[], input:null},
            { text: 'Accion', value: '', type:"text", filter:false, input:''},
        ],
        minitable_headers: [
            { text: 'Especie', value: 'specie' },
            { text: 'Tipo', value: 'type' },
            { text: 'Alto', value: 'high' },
            { text: 'Ancho', value: 'width' },
            { text: 'Espesor', value: 'density' },
            { text: 'Cantidad', value: 'quantity' },
        ],
        packages: [],
        storages: [],
        packaged: null,
        totalPackages: 0,        
        loading: true,                
        dialog: false,
        editedIndex: -1,          
        last_page: 1,
        page: 1,    
        paginationRows: 10,
        total:0,
        from:0,
        to:0,
        cantidad:0,
        cantidad_pie:0,
        rows: [{
                    "id": 1,
                    "name": {
                        "first_name": "Vladimir",
                        "last_name": "Nitzsche"
                    },
                    "address": {
                        "country": "Mayotte"
                    },
                    "email": "franecki.anastasia@gmail.com",
                },
                {
                    "id": 2,
                    "name": {
                        "first_name": "Irwin",
                        "last_name": "Bayer"
                    },
                    "age": 23,
                    "address": {
                        "country": "Guernsey"
                    },
                    "email": "rlittle@macejkovic.biz",
                },
                {
                    "id": 3,
                    "name": {
                        "first_name": "Don",
                        "last_name": "Herman"
                    },
                    "address": {
                        "country": "Papua New Guinea"
                    },
                    "email": "delia.becker@cormier.com",
                }],
        columns: [{
                label: "id",
                name: "id",
                filter: {
                    type: "simple",
                    placeholder: "id"
                },
                sort: true,
            },
            {
                label: "First Name",
                name: "name.first_name",
                filter: {
                    type: "simple",
                    placeholder: "Enter first name"
                },
                sort: true,
            },
            {
                label: "Email",
                name: "email",
                sort: true,
            },
            {
                label: "Country",
                name: "address.country",
                filter: {
                    type: "simple",
                    placeholder: "Enter country"
                },
            }],
        config: {
            checkbox_rows: true,
            rows_selectable: true,
            card_title: "Vue Bootsrap 4 advanced table"
        }  
      }
    },
    computed: {
        formTitle () {
                return this.editedIndex === -1 ? 'Nuevo' : 'Editar'
            }
    },
    mounted()
    {
        axios.get('/api/auth/getStorageData')
        .then((response) => {
            
            //console.log(response.data.storages);
            this.headers[2].items = response.data.storages;
            console.log(this.headers[2]);
            this.search();   
        });        
    },
    methods:{
        search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/package',this.getParams()).then((data)=>{
                    console.log(data.storages);
                    this.packages = data.storages.data;                                        
                    this.last_page = data.storages.last_page;
                    this.total = data.storages.total;
                    this.from = data.storages.from;
                    this.to = data.storages.to;
                    this.cantidad = data.cantidad;
                    this.cantidad_pie = data.cantidad_pie;
                    resolve();                    
                });
            });
        },
        getParams () {
            let params={};
            this.headers.forEach(element => {
                if(element.type=='text'){
                    params[element.value] = element.input;
                }
                if(element.type=='select')
                {
                    if(element.input!=null)
                    {
                        params[element.value] = element.input.id;

                    }
                    console.log(element.input)
                }
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
            axios.get(`/api/auth/package/${item.id}`)
            .then(response => {
                this.packaged = response.data.package
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
        
    },  
    components: {
        VueBootstrap4Table
    }  
}
</script>
