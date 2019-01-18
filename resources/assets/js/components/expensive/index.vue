<template>
    <v-card>
        <v-card-title>
            Gastos
        <v-spacer></v-spacer>        
        <v-dialog v-model="dialog" max-width="500px">            
            <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text v-if="newExpensive">
                <v-container grid-list-md>
                 <v-layout wrap>                   
                     <v-flex xs12>
                        <v-text-field label="Nombre" v-model="newExpensive.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="newExpensive.description" ></v-text-field>
                    </v-flex>
                 
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="store(newExpensive)" v-if="editedIndex === -1">Guardar</v-btn>
                <v-btn color="blue darken-1" flat @click="update(newExpensive)" v-else>Actualizar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>
        <v-btn @click="create()" color="primary" dark class="mb-2">Nuevo</v-btn>  
    
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="expenses"        
        hide-actions
        >
        <template slot="headers" slot-scope="props" >
           <tr>
                <th v-for="(header,index) in props.headers" :key="index" class="text-xs-left">
                    
                        <v-flex v-if="header.value!='actions'">
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
                               
                        </v-flex>
                </th>
           </tr>
        </template>
        <template slot="items"  slot-scope="props">
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left">{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.description }}</td>      
                <td class="justify-center layout px-0">
                   
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
    

        <!-- <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert> -->
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
        </v-card-text>
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
			{ text: 'Nombre', value: 'name', type:"text", filter:true, input:''},
            { text: 'Descripcion', value: 'description', type:"text", filter:true, input:''},
            { text: 'Accion', value: '', type:"text", filter:false, input:''},
        ],
        expenses: [],
        newExpensive: null,
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
                this.getData('/api/auth/expenses',this.getParams()).then((data)=>{
                    // console.log("after response");
                    this.expenses = data.data;                                        
                    this.last_page = data.last_page;
                    this.total = data.total;
                    this.from = data.from;
                    this.to = data.to;
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
            axios.get('/api/auth/expenses/create')            
            .then(response => {                                
                this.newExpensive = response.data.expensive       
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = true;
        },

        store(){
            let index = -1;
            axios.post('/api/auth/expenses/', this.newExpensive)
            .then(response => {                
                // alert('dato creado');
                if(response.data.status==0){
                    this.$store.dispatch('template/showMessage',{message:'Se registro correctamente el Gasto ',color:'success'});
                }else{
                    this.$store.dispatch('template/showMessage',{message:'No se pudo crear el registro',color:'error'});
                }
            })
            .catch(error => {                
                console.log(error);
            });
            this.search();        
            // this.$store.dispatch('template/showMessage','dato creado');  
            this.dialog = false;
        },
        edit (item) {
            this.editedIndex = this.expenses.indexOf(item)
            //this.editedItem = Object.assign({}, item)
            axios.get(`/api/auth/expenses/${item.id}/edit`)            
            .then(response => {                
                this.newExpensive = response.data.expensive
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = true
        },
        update (item) {                        
            let index = this.editedIndex;            
            axios.put(`/api/auth/expenses/${this.newExpensive.id}`, this.newExpensive)            
            .then(response => {          
                Vue.set(this.expenses, index, response.data.expensive) //es por que la reactividad no es seteable para este caso metodo especial      
                  this.$store.dispatch('template/showMessage',{message:'Se actualizo correctamente ',color:'info'});
            })
            .catch(function (error) {
                console.log(error);
                this.$store.dispatch('template/showMessage',{message:'No se pudo actualizar el registro',color:'error'});
            });            
            this.dialog =false;
        },
        destroy (item) {
            console.log(item);
            axios.delete(`/api/auth/expenses/${item.id}`)
            .then((response)=> {
                if(response.data.status==0)
                {
                    this.$store.dispatch('template/showMessage',{message:'Se elimino el registro ',color:'info'});
                    this.search();//en caso de eliminar el item limpiar

                }else{
                      this.$store.dispatch('template/showMessage',{message:'No se pudo eliminar el registro',color:'error'});
                }
            })
            .catch(function (error) {
                console.log(error);   
                this.$store.dispatch('template/showMessage',{message:'No se pudo eliminar el registro',color:'error'});             
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
}
</script>
