<template>
    <v-card>
        <v-card-title>
            Gastos
        <v-spacer></v-spacer>        
        <v-btn to="/package/create" color="primary" dark class="mb-2">Nuevo</v-btn>
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
        <template slot="expand" >
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
                              
                                 
                </table>                                
            </v-card>
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
            { text: 'Descripcion', value: 'code', type:"text", filter:true, input:''},
            { text: 'Accion', value: '', type:"text", filter:false, input:''},
        ],
        expenses: [],
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
                    console.log("after response");
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
}
</script>
