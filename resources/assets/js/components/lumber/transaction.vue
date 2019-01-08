<template>
<v-layout row xs12 wrap>
    <v-flex xs12>
        <v-card>
             <v-card-title primary-title>
            <div>
                <h3 class="headline mb-0">Transferencia de Madera entre Paquetes</h3>
               
            </div>
            </v-card-title>
        
        <v-card-text>
            <v-layout xs12 wrap>
                <v-flex xs6 >
                <v-card>
                
                    <v-card-title primary-title>
                    <div>
                       <v-btn @click="showDialog(1)">
                           Seleccionar Paquete
                       </v-btn>
                       
                    </div>
                    </v-card-title>
                    <v-card-text>
                        <v-layout xs12 wrap>
                            <v-flex xs3 v-if="this.packaged!=null">
                                Codigo: {{this.packaged.code}}
                            </v-flex>
                            <v-flex xs5 v-if="this.packaged!=null">
                                Nombre: {{this.packaged.name}}
                            </v-flex>
                            <v-flex xs4 v-if="this.packaged!=null">
                                Almacen: {{this.packaged.storage.name}}
                            </v-flex>
                            <v-flex xs12 v-if="this.packaged!=null">
                                
                            <v-data-table
                                :headers="headers_lumber"
                                :items="packaged.lumbers"
                                hide-actions
                                class="elevation-1"
                            >
                                <template slot="items" slot-scope="props">
                                <td><v-checkbox
                                    v-model="props.item.checked"
                                    primary
                                    hide-details
                                ></v-checkbox></td>
                                <td class="text-xs-right">{{ props.item.specie.name }}</td>
                                <td class="text-xs-right">{{ props.item.type.name }}</td>
                                <td class="text-xs-right">{{ props.item.high }}</td>
                                <td class="text-xs-right">{{ props.item.width }}</td>
                                <td class="text-xs-right">{{ props.item.density }}</td> 
                                <td class="text-xs-right"> <v-text-field v-model="props.item.pivot.quantity"></v-text-field> </td> 
                                </template>
                            </v-data-table>
                                          
                            </v-flex>
                        </v-layout>  
                    </v-card-text>
                    <v-card-actions>
                    <v-btn flat color="orange" @click="transfer(1)"> Transferir <v-icon>keyboard_arrow_right</v-icon> </v-btn>
                    
                    </v-card-actions>
                </v-card>
                </v-flex>
                <v-flex xs6>
                <v-card>
                    <v-card-title primary-title>
                    <div>
                       <v-btn @click="showDialog(2)">
                           Seleccionar Paquete
                       </v-btn>
                       
                    </div>
                    </v-card-title>
                    <v-card-text>
                        <v-layout xs12 wrap>
                            <v-flex xs3 v-if="this.packaged2!=null">
                                Codigo: {{this.packaged2.code}}
                            </v-flex>
                            <v-flex xs5 v-if="this.packaged2!=null">
                                Nombre: {{this.packaged2.name}}
                            </v-flex>
                            <v-flex xs4 v-if="this.packaged2!=null">
                                Almacen: {{this.packaged2.storage.name}}
                            </v-flex>
                            <v-flex xs12 v-if="this.packaged2!=null">
                                
                            <v-data-table
                                :headers="headers_lumber"
                                :items="packaged2.lumbers"
                                hide-actions
                                class="elevation-1"
                            >
                                <template slot="items" slot-scope="props">
                                <td><v-checkbox
                                    v-model="props.item.checked"
                                    primary
                                    hide-details
                                ></v-checkbox></td>
                                <td class="text-xs-right">{{ props.item.specie.name }}</td>
                                <td class="text-xs-right">{{ props.item.type.name }}</td>
                                <td class="text-xs-right">{{ props.item.high }}</td>
                                <td class="text-xs-right">{{ props.item.width }}</td>
                                <td class="text-xs-right">{{ props.item.density }}</td> 
                                <td class="text-xs-right"> <v-text-field v-model="props.item.pivot.quantity"></v-text-field> </td> 
                                </template>
                            </v-data-table>
                                          
                            </v-flex>
                        </v-layout>  
                    </v-card-text>
                    <v-card-actions>
                    <v-btn flat color="orange" @click="transfer(2)"><v-icon>keyboard_arrow_left</v-icon> Transferir </v-btn>
                    
                    </v-card-actions>
                </v-card>
                </v-flex>
            </v-layout>
        </v-card-text>
        </v-card>

        
    </v-flex>
   <!-- dialogo de seleccion de paquete -->
    <v-dialog v-model="dialog" persistent max-width="700px">
      <!-- <v-btn slot="activator" color="primary" dark>Open Dialog</v-btn> -->
      <v-card>
        <v-card-title>
          <span class="headline">Seleccion de Paquete</span>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialog = false"> <v-icon>close</v-icon> </v-btn>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
             <v-data-table
        :headers="headers"
        :items="packages"        
        hide-actions
        >
        <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
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
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.code }}</td>
                <td class="text-xs-left">{{ props.item.name }}</td>      
                <td class="text-xs-left" >{{ props.item.storage.name }}</td>                           
                <td class="justify-center layout px-0">
                    <v-btn @click="selectItem(props.item)">
                        Seleccionar
                    </v-btn>
                    
                </td>      
            <!-- </tr> -->
        </template>
        

        <!-- <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert> -->
        </v-data-table>   
             
            </v-layout>
          </v-container>
        </v-card-text>
       
      </v-card>
    </v-dialog>
</v-layout>
    
</template>
<script>
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
        headers_lumber: [
            { text: 'Sel.', value: 'selected' },
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
        packaged2: null,
        totalPackages: 0,        
        loading: true,                
        dialog: false,
        editedIndex: -1,          
        last_page: 1,
        page: 1,    
        paginationRows: 10,
        checkBox: false,
        dialog_switch:null,
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
                    console.log(data);
                    this.packages = data.data;    
                                                        
                    this.last_page = data.last_page;
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
        selectItem(item){
            
             axios.get(`/api/auth/package/${item.id}`)
            .then(response => {

                if(this.dialog_switch==1){
                    this.packaged = response.data.package
                    this.packaged.lumbers.forEach((item)=>{
                        item.checked=false;
                        // console.log(item);
                        return item;
                    });
                    console.log(this.packaged);
                }else{
                    this.packaged2 = response.data.package
                    this.packaged2.lumbers.forEach((item)=>{
                        item.checked=false;
                        // console.log(item);
                        return item;
                    });
                }
                this.dialog=false;
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
        showDialog(selector){
            this.dialog_switch = selector;
            this.dialog =true;
            this.search();
        },
        toggleAll () {
            // if (this.selected.length) this.selected = []
            // else this.selected = this.desserts.slice()
        },
        checkInput(search)
        {
            if(search=='')
            {
                this.search();
            }
        },
        changeSort (column) {
            if (this.pagination.sortBy === column) {
            this.pagination.descending = !this.pagination.descending
            } else {
            this.pagination.sortBy = column
            this.pagination.descending = false
            }
        },
        itemUpdate(item){
            item.selected =!item.selected;
            console.log(item);
            return item;
        },
        transfer(id){
            
            if(id==1){
                let params = {package_id: this.packaged.id,lumbers: this.packaged.lumbers,package_destiny_id: this.packaged2.id}
                axios.post('/api/auth/transfer_lumber', params)
                .then(response => {                
                    //this.lumbers.push(response.data.lumber);
                    console.log(response.data);
                    // alert('dato creado');    
               
                        this.packaged = response.data.packaged
                        this.packaged.lumbers.forEach((item)=>{
                            item.checked=false;
                            // console.log(item);
                            return item;
                        });
                        // console.log(this.packaged);
              
                        this.packaged2 = response.data.packaged2
                        this.packaged2.lumbers.forEach((item)=>{
                            item.checked=false;
                            // console.log(item);
                            return item;
                        });
                 
                })
                .catch(error => {                
                    console.log(error);
                });
                this.dialog = false;
                console.log(this.packaged);
                
            }else{
                let params = {package_id: this.packaged2.id,lumbers: this.packaged2.lumbers,package_destiny_id: this.packaged.id}
                 axios.post('/api/auth/transfer_lumber', params)
                .then(response => {                
                    //this.lumbers.push(response.data.lumber);
                    console.log(response.data);
                    // alert('dato creado');    
               
                        this.packaged = response.data.packaged2
                        this.packaged.lumbers.forEach((item)=>{
                            item.checked=false;
                            // console.log(item);
                            return item;
                        });
                        // console.log(this.packaged);
              
                        this.packaged2 = response.data.packaged
                        this.packaged2.lumbers.forEach((item)=>{
                            item.checked=false;
                            // console.log(item);
                            return item;
                        });
                 
                })
                .catch(error => {                
                    console.log(error);
                });
                this.dialog = false;
                console.log(this.packaged);
            }
        }

        
    },  
    
}
</script>

