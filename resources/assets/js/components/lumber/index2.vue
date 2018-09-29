<template>
    <v-card>
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

        <!-- <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            single-line
            hide-details
        > -->
        
        <!-- </v-text-field> -->
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="lumbers"        
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
                            <!-- <v-icon small @click="toggleOrder(header.value)" v-if="header.value == filterName ">{{pagination.descending==false?'arrow_upward':'arrow_downward'}}</v-icon> -->
                        </v-flex>
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.specie.name }}</td>
                <td class="text-xs-left">{{ props.item.type.name }}</td>      
                <td class="text-xs-left" >{{ props.item.high }}</td>            
                <td class="text-xs-left">{{ props.item.width }}</td>
                <td class="text-xs-left">{{ props.item.density }}</td>                
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
            <v-card flat v-if="lumber">
                <v-card-text>{{ lumber.description }}</v-card-text>
                <v-card-text>{{ lumber.high }}</v-card-text>
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
            { text: 'Especie', value: 'specie' },
            { text: 'Tipo', value: 'type' },
            { text: 'Alto', value: 'high' },        
            { text: 'Ancho', value: 'width' },
            { text: 'Espesor', value: 'density' },            
        ],
        species: null,
        types: null,
        lumbers: [],
        lumber: null,
        newLumber: null,
        totalLumber: 0,        
        loading: true,
        filterName: 'high',
        filterValue: '',   
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
        this.getSpecies();
        this.getTypes();        
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
        create() {                                    
            axios.get('/api/auth/lumber/create')            
            .then(response => {                
                console.log(response.data.lumber);
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
                this.lumbers.push(response.data.lumber);
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
                this.lumbers[index].specie = response.data.lumber.specie.name;
                this.lumbers[index].type_id = response.data.lumber.type_id;
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;
            this.getLumber();
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
