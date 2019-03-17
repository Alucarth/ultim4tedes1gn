<template>
    
    <v-card>
        <v-card-title>
            <h3> Paquetes de madera </h3>
            <v-spacer></v-spacer>
            <v-btn color="primary" dark class="mb-2" @click="create()">Nuevo</v-btn>
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
                    <!-- <v-icon  small>
                        remove_red_eye
                    </v-icon> -->
                    <v-icon @click="edit(props)" small>
                        edit
                    </v-icon>
                    <v-icon @click="destroy(props.row)" small>
                        delete
                    </v-icon>
                </template>
            </vue-bootstrap4-table>
        </v-card-text>
        <edit-package :dialog="dialog" :edit-item="item" @close="close" @package="update"></edit-package>
     
    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditPackage from './edit';
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
        cantidad:0,
        cantidad_pie:0,
        item:{},
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
                sort: true,
            },
            {
                label: "Cantidad Pie",
                name: "quantity_feet",
                sort: true,
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
        setStorage(storage){
            this.storage = storage;
            this.search();
        },
        close(dialog){
            this.dialog= dialog;
        },
             
        create() {                            
            this.item = {lumbers:[]};
            this.dialog =true;
        },
        show(item) {                        
            // axios.get(`/api/auth/package/${item.id}`)
            // .then(response => {
            //     this.packaged = response.data.package
            // })
            // .catch(error => {                
            //     console.log(error);
            // });
        },
        async edit (item) {
          
            this.item = await axios.get(`/api/auth/package/${item.row.id}`)
                        .then(response=>{
                            return response.data.package;
                        })
                        .catch(error => {                
                            console.log(error);
                        });
            this.dialog = true;
        },
        update (item) {                        
            // let index = this.editedIndex; 
            // console.log(item);           
            axios.post(`/api/auth/package`, item)            
            .then(response => {                
              console.log(response.data);
              this.$store.dispatch('template/showMessage',{message:'Operacion Exitosa ',color:'success'});
            })
            .catch(function (error) {
                console.log(error);
            });    
            this.search();
            // console.log(item);        
            this.dialog =false;
            
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
                    .then( (response)=> {
                        // console.log(response.data);                   
                        Swal.fire(
                            'Borrado!',
                            'El paquete '+response.data.code+' ha sido eliminado.',
                            'success'
                        )
                        this.search();
                    })
                    .catch( (error)=> {
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
        
    },  
    components: {
        VueBootstrap4Table,
        EditPackage 
    }  
}
</script>
