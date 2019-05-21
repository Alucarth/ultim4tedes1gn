<template>
    <v-flex xs12>
        <v-layout justify-space-between row fill-height>
            <v-flex xs8 style="padding-left: 5px">
                <v-card>
                    <v-card-title>
                        <h3> Paquetes de madera </h3>
                        <!-- <v-spacer></v-spacer> -->
                        <!-- <v-btn color="primary" dark class="mb-2" @click="create()">Nuevo</v-btn> -->
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
                        <vue-bootstrap4-table :classes="classes" 
                            :rows="rows"
                            :columns="columns"
                            :config="config"
                            @on-change-query="onChangeQuery"
                            @on-select-row="getSeletedRows"
                            @on-unselect-row="getSeletedRows"
                            @on-all-select-rows="getSeletedRows"
                            @on-all-unselect-rows="getSeletedRows"
                            :totalRows="total_rows" >
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
                                <!-- <v-icon @click="destroy(props.row)" small>
                                    delete
                                </v-icon> -->
                            </template>
                        </vue-bootstrap4-table>
                    </v-card-text>
                    <edit-package :dialog="dialog" :edit-item="item" @close="close" @package="update"></edit-package>
                
                </v-card>
            </v-flex>
            <v-flex xs4 style="padding-left: 5px;padding-right: 5px">
                <v-card >
                    <v-card-text>
                       
                        <v-layout row wrap>
                            <v-flex shrink pa-1>  
                                <h6 >Transferir a</h6>
                            </v-flex>
                            <v-flex grow pa-1>  
                                <v-combobox label="Almacen"  v-model="transfer.storage" :items="destiny_storages" item-text="name" item-value="id"
                                    placeholder="Seleccione Almacen" persistent-hint>
                                </v-combobox>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs6>  
                                 <v-text-field label="Numero" hint="Ingrese Numero" required v-model="transfer.number"></v-text-field>
                            </v-flex>
                            <v-flex xs6>  
                                <v-menu
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    max-width="290px"
                                    min-width="290px"
                                >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                    v-model="transfer.date"
                                    label="Fecha"
                                    hint="Año-Mes-Dia"
                                    persistent-hint
                                    prepend-icon="event"
                                    readonly
                                    v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="transfer.date" no-title @input="menu2 = false"></v-date-picker>
                                </v-menu>
                            </v-flex>
                           
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex grow pa-1>  
                                 <v-text-field label="Descripcion" hint="Ingrese Descripcion" required v-model="transfer.description"></v-text-field>
                            </v-flex>
                            <v-flex  shrink pa-1>  
                                    <!-- <button class="btn btn-primary">Transferir </button> -->
                                    <v-btn color="primary" small @click="storeTransfer()"> Transferir <i class="material-icons">swap_horiz</i> </v-btn>
                            </v-flex>
                           
                        </v-layout>
                        
                    </v-card-text>
                    <h6> Paquetes Seleccionados: {{this.seleted_rows.length}}</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(item,index) in seleted_rows" :key="index">
                            <span> <v-icon>view_quilt</v-icon>  {{item.code}}</span> 
    
                            <v-chip>{{'en '+item.storage.name}}</v-chip>
                            
                            <!-- <span class="badge badge-primary badge-pill">14</span> -->
                        </li>
                    </ul>
                </v-card>
            </v-flex>
        </v-layout>
    </v-flex>
  
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
        packages: [],
        storages: [],
        destiny_storages: [],
        transfer:{},
        storage:{},
        packaged: null,      
        loading: true,                
        dialog: false,        
        cantidad:0,
        cantidad_pie:0,
        menu2:false,
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
                label: "Cantidad Pz",
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
            checkbox_rows: true,
            rows_selectable: true,
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
        },
        seleted_rows:[]  
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
            // console.log(this.storages);
            this.search();   
        });  
         axios.get('/api/auth/getStorageData')
        .then((response) => {
            
            //console.log(response.data.storages);
            let data = response.data.storages;
            this.destiny_storages = data;

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
        getSeletedRows(datatable)
        {
            this.seleted_rows = datatable.selected_items;
            console.log(datatable);
        },
        storeTransfer(){
            let transfer = this.transfer;
            transfer.items = this.seleted_rows;
            axios.post(`/api/auth/package_transfer`, transfer)            
            .then(response => {                
              console.log(response.data);
              this.$router.push('/package');
              this.$store.dispatch('template/showMessage',{message:'Se realizo la Transaccion de paquetes',color:'success'});
            })
            .catch(function (error) {
                console.log(error);
            });    
            // this.search();
            // console.log(item);        
            // this.dialog =false;
        }
        
    },  
    components: {
        VueBootstrap4Table,
        EditPackage 
    }  
}
</script>
