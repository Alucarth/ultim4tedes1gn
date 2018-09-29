<template>
<v-container grid-list-xs>
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

        <v-data-table style="max-width: 100%"
        :headers="headers"
        :items="lumbers"
        :search="search"
            :pagination.sync="pagination"            
        >
        <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">                    
                        <v-flex>
                            <span @click="toggleOrder(index)">{{ header.text }}                                
                            </span>
                            <v-menu
                                    :close-on-content-click="false"                                    
                                    >
                                    <v-btn
                                        slot="activator"
                                        icon
                                        @click="setFilter(header.value)"
                                    >
                                    <v-icon  small>fa-filter</v-icon>
                                    </v-btn>

                                    <v-card>
                                        <v-text-field
                                        v-model="filterValue"
                                        append-icon="search"
                                        :label="`Buscar ${header.text}...`"
                                    
                                        @keydown.enter="getResult(true)"
                                    ></v-text-field>
                                    
                                    </v-card>
                            </v-menu>
                            <v-icon small @click="toggleOrder(index)" v-if="header.value == pagination.sortBy">{{pagination.descending==false?'arrow_upward':'arrow_downward'}}</v-icon>
                        </v-flex>                     
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <tr @click="addToPurchase(props.item)">
                <td class="text-xs-left" >{{ props.item.high }}</td>            
                <td class="text-xs-left">{{ props.item.width }}</td>
                <td class="text-xs-left">{{ props.item.density }}</td>
                <td class="text-xs-left">{{ props.item.specie.name }}</td>
                <td class="text-xs-left">{{ props.item.type.name }}</td>      
                <td class="justify-center layout px-0">
                    <v-icon
                        small
                        class="mr-2"
                        @click="show(props.item);props.expanded = !props.expanded"
                    >
                        toc
                    </v-icon>                    
                </td>      
            </tr>
        </template>
        <template slot="expand" slot-scope="props">
            <v-card flat v-if="lumber">
                <v-card-text>{{ lumber.description }}</v-card-text>
                <v-card-text>{{ lumber.high }}</v-card-text>
            </v-card>
        </template>

        <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert>
        </v-data-table>        
        
        </v-layout>
    </v-card>
      </v-flex>
      <v-flex xs6>
    <v-card>
        <v-card-title>
            Compra
        <v-spacer></v-spacer>
        <v-btn @click="create();" color="primary" dark class="mb-2">Guardar</v-btn>
        </v-card-title>
        <v-layout row wrap>
            <v-flex xs12 sm4 md4>                
                <v-select                  
                        label="Proveedor"
                        v-model="provider.id"
                        :items="types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>

            </v-flex>
            <v-flex xs12 sm4 md4>
                <v-text-field label="CEFO" hint="Ingrese codigo CEFO" required ></v-text-field>
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
                    v-model="date"
                    label="Fecha"          
                    readonly
                    ></v-text-field>
                    <v-date-picker v-model="date" @input="$refs.menu2.save(date)"></v-date-picker>

                </v-menu>
            </v-flex>
        <v-data-table
        style="max-width: 100%"
        :headers="purchase_headers"
        :items="purchase_lumbers"
         hide-actions        
        >
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.specie.name+'-'+props.item.type.name }}</td>
                <td class="text-xs-left" >{{ props.item.high+'X'+props.item.width+'X'+props.item.density }}</td>                                                            
                <td class="text-xs-left">
                    <v-text-field label="Cantidad" hint="Ingrese cantidad" required></v-text-field>
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
        search: '',
        pagination: {
          sortBy: 'name'
        },
        headers: [          
            { text: 'Alto', value: 'Madera' },
            { text: 'Ancho', value: 'Medida' },
            { text: 'Espesor', value: 'density' },
            { text: 'Especie', value: 'specie' },
            { text: 'Tipo', value: 'type' },            
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
      }
    },
    computed: {
        formTitle () {
                return this.editedIndex === -1 ? 'Nuevo' : 'Editar'
            }
    },
    mounted()
    {
        this.getLumber();
        // .then(
        //     this.getDataFromApi()
        //         .then(data => {
        //         this.lumbers = data.lumbers
        //         this.totalLumber = data.total
        //         })
        // );
        this.getSpecies();
        this.getTypes();
        
    },
    methods:{
        getDataFromApi () {            
            // return new Promise((resolve, reject) => {
            // const { sortBy, descending, page, rowsPerPage } = this.pagination

            // let items= this.lumbers;
            // const total = items.length;

            // if (this.pagination.sortBy) {
            //     items = items.sort((a, b) => {
            //     const sortA = a[sortBy]
            //     const sortB = b[sortBy]

            //     if (descending) {
            //         if (sortA < sortB) return 1
            //         if (sortA > sortB) return -1
            //         return 0
            //     } else {
            //         if (sortA < sortB) return -1
            //         if (sortA > sortB) return 1
            //         return 0
            //     }
            //     })
            // }

            // if (rowsPerPage > 0) {
            //     items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
            // }

            //     resolve({
            //     items,
            //     total
            //     });
         
            // })
        },
        getLumber(withFilter){
            console.log("starting receiving data");
            return new Promise((resolve,reject)=>{
               this.loading = true
               let filterName = withFilter==true?this.filterName:'high';
               console.log(withFilter);
               axios.get('/api/auth/getLumberData',{ name:filterName,value:this.filterValue})
                    .then((response) => {
                                        // let providers = response.data;
                                        console.log(response.data);
                            this.lumbers = response.data.lumbers;
                                        this.loading = false
                                        resolve();
                                    });
                        });
        },
        getResult(withFilter){
            console.log(this.filterName);
            //axios.post('/api/providers/getdata',{name:this.filterName})
              //   .then((response)=>{ console.log(response.data)});
              this.getLumber(withFilter).then(
                        this.getDataFromApi()
                            .then(data => {
                            this.lumbers = data.lumbers
                            this.totalLumber = data.total
                            })
                    );
        },
        toggleOrder (index) {
            this.pagination.sortBy = this.headers[index].value
            this.pagination.descending = !this.pagination.descending
             
            
        },
        setFilter(filterName){
            this.filterValue='',
            this.filterName = filterName;
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
        close() {
            this.dialog = false;
        },
        addToPurchase(item) {
            this.purchase_lumbers.push(item);
        },
        removeFromPurchase(index) {
            this.purchase_lumbers.splice(index, 1);
        }
        
    },
    watch: {
        pagination: {
            handler () {
            this.getDataFromApi()
                .then(data => {
                this.desserts = data.items
                this.totalDesserts = data.total
                })
            },
            deep: true
        },
        filterValue (fv) {      
            if (fv =='') {
                this.getResult(false)
            }

        }
    }
}
</script>
