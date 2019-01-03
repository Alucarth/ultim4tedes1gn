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
            <v-layout xs12 align-center justify-center wrap>
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
                                    :headers="minitable_headers"                                        
                                    :items="packaged.lumbers"
                                    hide-actions
                                    class="elevation-1"
                                >
                                    <template slot="items" slot-scope="props">
                                    <td>
                                        <v-checkbox
                                        v-model="props.item.selected"
                                        primary
                                        hide-details
                                        ></v-checkbox>
                                    </td>
                                    <td>{{ props.item.specie.name }}</td>
                                    <td>{{ props.item.type.name }}</td>
                                    <td>{{ props.item.high }}</td>
                                    <td>{{ props.item.width}}</td>
                                    <td>{{ props.item.density }}</td>
                                    <td v-if="props.item.selected"> <v-text-field v-model="props.item.pivot.quantity" ></v-text-field> </td>                            
                                    <td v-else>{{ props.item.pivot.quantity }}</td>                            
                                    </template>
                                </v-data-table>
                                          
                            </v-flex>
                        </v-layout>  
                    </v-card-text>
                    <v-card-actions>
                    <v-btn flat color="orange">Transferir</v-btn>
                    
                    </v-card-actions>
                </v-card>
                </v-flex>
                <v-flex xs6>
                    <v-card>
                

                    <v-card-title primary-title>
                    <div>
                        <h3 class="headline mb-0">Kangaroo Valley Safari</h3>
                        <div>Located two hours south of Sydney in the <br>Southern Highlands of New South Wales, ...</div>
                    </div>
                    </v-card-title>

                    <v-card-actions>
                    <v-btn flat color="orange">Share</v-btn>
                    <v-btn flat color="orange">Explore</v-btn>
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
            { text: 'Codigo', value: 'code' },
            { text: 'Nombre', value: 'name' },
            { text: 'Almacen', value: 'storage' },
            { text: 'Accion', value: '' },
        ],
        minitable_headers: [
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
                this.getData('/api/auth/package',this.getParams()).then((data)=>{
                    console.log("after response");
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
            //this.editedIndex = this.lumbers.indexOf(item)
            // console.log(item);
             axios.get(`/api/auth/package/${item.id}`)
            .then(response => {
                this.packaged = response.data.package
                this.packaged.lumbers.forEach((item)=>{
                    item.selected=false;
                    // console.log(item);
                    
                    return item;
                });
                console.log(this.packaged);
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
        showDialog(selector){
            this.dialog =true;
            this.search();
        }
        
    },  
    
}
</script>

