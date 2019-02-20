<template>
    <v-card>
        <v-card-title>
            Insumos
        <v-spacer></v-spacer>

        <v-dialog v-model="dialog" max-width="500px">            
            <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text v-if="newInventory">
                <v-container grid-list-md>
                 <v-layout wrap>                   
                     <v-flex xs12>
                        <v-text-field label="Code" v-model="newInventory.code" ></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-select                  
                        label="Tipo"
                        v-model="newInventory.inventory_type_id"
                        :items="inventory_types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-select                  
                        label="Familia"
                        v-model="newInventory.family_id"
                        :items="families"
                        item-text="name"
                        item-value="id"
                        :hint="`Familia`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-select                  
                        label="Unidad"
                        v-model="newInventory.unit_id"
                        :items="units"
                        item-text="name"
                        item-value="id"
                        :hint="`Unidad`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs6>
                        <v-text-field label="Stock mínimo" v-model="newInventory.minimum" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="newInventory.description" ></v-text-field>
                    </v-flex>
                    <v-switch
                        :label="'Activo'"
                        v-model="newInventory.active"
                    ></v-switch>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="store(newInventory)" v-if="editedIndex === -1">Guardar</v-btn>
                <v-btn color="blue darken-1" flat @click="update(newInventory)" v-else>Actualizar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>

        
        <v-select
          v-model="area_id"
          :items="areas"
          hide-details
          item-text="name"
           item-value="id"
          label="Seleccione área"
          single-line
        ></v-select>
        <v-btn v-if="area_id != 0" @click="transfer()" color="primary" dark class="mb-2">Realizar trasnferencia </v-btn>

        <v-btn @click="create()" color="primary" dark class="mb-2">Nuevo</v-btn>
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="inventories"
        :searchInventory="searchInventory"
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
                                        append-icon="searchInventory"
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
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left" >{{ props.item.code }}</td>            
                <td class="text-xs-left">{{ props.item.description }}</td>
                <td class="text-xs-left">{{ props.item.type.name }}</td>
                <td class="text-xs-left">{{ props.item.family.name }}</td>                 
                <td class="text-xs-left">{{ props.item.unit.name }}</td>
                
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
            <v-card flat v-if="inventory">
                <table>
                    <tr>
                        <td> 
                            Código
                        </td>
                        <td>
                            <v-card-text>{{ inventory.code }}</v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nombre
                        </td>
                        <td>
                            <v-card-text>{{ inventory.description }}</v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tipo
                        </td>
                        <td>
                            <v-card-text>{{ inventory.type.name }}</v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Familia
                        </td>
                        <td>
                            <v-card-text>{{ inventory.family.name }}</v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Unidad
                        </td>
                        <td>
                            <v-card-text>{{ inventory.unit.name }}</v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Cantidad total
                        </td>
                        <td>
                            <v-card-text>{{ inventory.quantity }}</v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Detalle de ubicación
                        </td>
                        <td>
                             <v-data-table
                                :headers="minitable_headers"
                                :items="inventory.areas"
                                hide-actions
                                class="elevation-1"
                            >
                                <template slot="items" slot-scope="props">
                                    <td>{{ props.item.name }}</td>
                                    <td>{{ props.item.pivot.quantity }}</td>
                                </template>
                            </v-data-table>
                        </td>
                    </tr>
                </table>


            </v-card>
        </template>

        <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your searchInventory for "{{ searchInventory }}" found no results.
        </v-alert>
        </v-data-table>
        
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
            { text: 'Code', value: 'code' },
            { text: 'Descripcion', value: 'description' },            
            { text: 'Typo', value: 'type' },
            { text: 'Familia', value: 'family' },
            { text: 'Unidad', value: 'unit' },            
        ],
        minitable_headers: [
            { text: 'Nombre', value: 'name' },
            { text: 'Cantidad', value: 'quantity' },
        ],
        inventories: [],        
        inventory: null,
        newInventory: null,
        totalInventory: 0,        
        loading: true,
        filterName: 'name',
        filterValue: '',   
        dialog: false,
        editedIndex: -1,    
        units: [],
        families: [],
        inventory_types: [],
        areas: [],
        area_id: 0
      }
    },
    computed: {
        formTitle () {
                return this.editedIndex === -1 ? 'Agregar Nuevo Insumo' : 'Editar Insumo'
            }
    },
    mounted()
    {
        this.searchInventory();
        this.getInventoryTypes();
        this.getFamilies();
        this.getUnits();
        this.getAreas();
    },
    methods:{
        searchInventory() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/inventory',this.getParams()).then((data)=>{                    
                    this.inventories = data.data;                    
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
            this.searchInventory();
        },        
        create() {                                    
            this.editedIndex = -1;
            axios.get('/api/auth/inventory/create')
            .then(response => {     
                console.log(response);
                this.newInventory = response.data.inventory
            })
            .catch(error => {
                console.log(error);
            });
            this.dialog = true;
        },
        store(){
            let index = -1;            
            axios.post('/api/auth/inventory', this.newInventory)
            .then(response => {                    
                this.getinventories();
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;            
        },
        show(item) {                        
            axios.get(`/api/auth/inventory/${item.id}`)            
            .then(response => {                
                this.inventory = response.data.inventory
            })
            .catch(error => {                
                console.log(error);
            });
        },
        edit (item) {
            this.editedIndex = this.inventories.indexOf(item);
            axios.get(`/api/auth/inventory/${item.id}/edit`)            
            .then(response => {                
                this.newInventory = response.data.inventory
            })
            .catch(error => {                
                console.log(error);
            });            
            this.dialog = true
        },
        update (item) {                        
            let index = this.editedIndex;            
            axios.put(`/api/auth/inventory/${this.newInventory.id}`, this.newInventory)
            .then(response => {
                this.inventories[index].name = response.data.inventory.name
                this.inventories[index].description = response.data.inventory.description
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;            
        },
        destroy (item) {
            let success_delete = false;
            axios.delete(`/api/auth/inventory/${item.id}`)
            .then(function (response) {
                console.log(response.data.inventory_id);
                success_delete = true;
            })
            .catch(function (error) {
                console.log(error);                
            });            
        },        
        close() {
            this.dialog = false;
        },
        getInventoryTypes() {            
            axios.get('/api/auth/inventory_type')
            .then(response => {
                this.inventory_types = response.data.inventory_types          
            })
                .catch(error => {
                console.log(error);
            });
        },
        getFamilies() {
            axios.get('/api/auth/family')
            .then(response => {
                this.families = response.data.families          
            })
            .catch(error => {
                console.log(error);
            });
        },
        getUnits() {
            axios.get('/api/auth/unit')
            .then(response => {
                this.units = response.data.units
            })
            .catch(error => {
                console.log(error);
            });
        },
        getAreas () {
            axios.get('/api/auth/area')
            .then(response => {
                this.areas = response.data.areas
            })
            .catch(error => {
                console.log(error);
            });
        },
        transfer() {
            this.$router.replace('inventory/transfer/'+this.area_id);
        }

    }
}
</script>
