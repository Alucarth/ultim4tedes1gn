<template>
    
    <v-card>
        <v-card-title>
            <h3> Paquetes de madera </h3>
            <v-spacer></v-spacer>
            <v-btn to="/package/create" color="primary" dark class="mb-2">Nuevo</v-btn>
        </v-card-title>
        <v-card-text>
            <v-flex xs12>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <v-icon color="white">store</v-icon> {{storage.name}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" v-for="(item, index) in storages" :key="index" @click="setStorage(item)" >{{item.name}} </a>
                        </div>
                    </div>
                    <v-chip color="green" text-color="white">
                        <v-avatar class="green darken-4">
                            <v-icon>group_work</v-icon>
                        </v-avatar>
                        cantidad: {{this.cantidad}}
                    </v-chip>
                    <v-chip color="green" text-color="white">
                        <v-avatar class="green darken-4">
                            <v-icon>group_work</v-icon>
                        </v-avatar>
                        cantidad Pie: {{this.cantidad_pie}}
                    </v-chip>
                   
            </v-flex>
            <vue-bootstrap4-table :classes="classes" :rows="rows" :columns="columns" :config="config"  @on-change-query="onChangeQuery"  :totalRows="total_rows">
                <template slot="sort-asc-icon">
                    <i class="fa fa-sort-asc"></i>
                </template>
                <template slot="sort-desc-icon">
                    <i class="fa fa-sort-desc"></i>
                </template>
                <template slot="no-sort-icon">
                    <i class="fa fa-sort"></i>
                </template>
                <template slot="option" slot-scope="props">
                    <v-icon  small>
                        remove_red_eye
                    </v-icon>
                    <v-icon @click="edit(props)" small>
                        edit
                    </v-icon>
                    <v-icon @click="destroy(props)" small>
                        delete
                    </v-icon>
                </template>
            </vue-bootstrap4-table>
        </v-card-text>
        <!-- <v-spacer></v-spacer>        
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
        storage:{},
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
        rows: [],
        columns: [{
                label: "Cod.",
                name: "code",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese codigo"
                },
                sort: true,
            },
            {
                label: "Nombre",
                name: "name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Nombre"
                },
                sort: true,
            },
            {
                label: "Cantidad",
                name: "quantity",
            },
            {
                label: "Cantidad Pie",
                name: "quantity_feet",
            },
            {
                label: "Opciones",
                name: "option",
                sort: false,
            }],
        config: {
            checkbox_rows: false,
            rows_selectable: false,
            pagination: true,
            card_mode: false,
            show_refresh_button:  false,
            show_reset_button:  false,
            global_search:  {
                placeholder:  "Enter custom Search text",
                visibility:  false,
                case_sensitive:  false
            },
            per_page_options:  [5,  10,  20,  30],
            server_mode:  true,
        },
        queryParams: {
            sort: [],
            filters: [],
            global_search: "",
            per_page: 10,
            page: 1,
        },
        total_rows: 0,
        classes: {
             table : {
                "table-striped " : false,
                
            },
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
            this.storages= response.data.storages;
            let item = {id:null,name:'Todos' };
            this.storage = item;
            this.storages.push(item);
            // this.queryParams.filters.push({"type":"simple","name":"storage_id","text":this.storage.id})
            console.log(this.storages);
            this.search();   
        });        
    },
    methods:{
        search() {
            axios.get('/api/auth/package', {
                        params: this.getParams(this.queryParams)
                    })
                    .then((response)=> {
                        console.log(response.data);
                        this.rows= response.data.storages.data;
                        this.total_rows =response.data.storages.total;
                        this.cantidad =response.data.cantidad
                        this.cantidad_pie =response.data.cantidad_pie
    
                    })
                    .catch((error)=> {
                        console.log(error);
                    });
        },
        onChangeQuery(queryParams) {
            // queryParams.filters.push({"type":"simple","name":"storage_id","text":this.storage.id})
            console.log(this.getParams(queryParams));
            this.queryParams = queryParams;
            this.search();
          //  this.fetchData();
        },
        getParams (queryParams) {
            let params={};
            queryParams.filters.forEach(element => {
                if(element.type=='simple'){
                    params[element.name] = element.text;
                }
            });
            if(queryParams.sort.length > 0){
                params['order']= queryParams.sort[0].order;
                params['sort_name']= queryParams.sort[0].name;
            }
            params['storage_id']=this.storage.id;//solo para este caso XD
            params['page']=queryParams.page;
            params['pagination_rows']=queryParams.per_page;
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
        setStorage(storage){
            this.storage = storage;
            this.search();
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
            
            console.log(item);
            Swal.fire({
                title: 'Esta seguro de Eliminar el Paquete?',
                text: "Tenga en cuenta que no se puede revertir una ves eliminado!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/api/auth/package/${item.id}`)
                    .then(function (response) {
                        console.log(response.data.lumber_id);                   
                        Swal.fire(
                            'Borrado!',
                            'El paquete ha sido eliminado.',
                            'success'
                        )
                    })
                    .catch(function (error) {
                        console.log(error);
                        Swal.fire(
                            'No se pudo Borrar!',
                            ''+error,
                            'error'
                        )                
                    });  
                   
                }
            })
                                            
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
