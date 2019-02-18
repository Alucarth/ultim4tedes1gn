<template>
	<v-card>
        <v-card-title>
           <v-toolbar flat color="white">
                <v-toolbar-title>Tipos de Origen
                    
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <EditOriginType :bus="bus" > </EditOriginType>
                <!-- <v-btn to="/create_purchase" color="primary" dark class="mb-2" small >Nuevo <v-spacer></v-spacer>  <v-icon small>fa-plus-circle</v-icon> </v-btn> -->
            </v-toolbar>
       
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="origin_types"        
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
            <v-layout row justify-space-between>
            <v-flex xs1 sm2>
                <v-combobox
                    v-model="paginationRows"
                    :items="pagination_select"
                    label="Mostrar Registros"
                    @change="search()"
                ></v-combobox>
            </v-flex>
            <v-flex xs5>
                <v-pagination
                    v-model="page"
                    :length="last_page"
                    :total-visible="10"
                    @input="next"

                > </v-pagination>
            </v-flex>
            <v-flex xs1  sm2>
                <div class="caption"> Mostrando {{from}}-{{to}} de {{total}} </div>
            </v-flex>
            </v-layout>
      
            
        </v-card-text>
	</v-card>
</template>
<script>
import EditOriginType from './edit';
export default {
	name:'IndexOriginType',
	components:{
		EditOriginType
	},	
	data:()=>({
		pagination: {
          sortBy: 'name'
        },
        headers: [          
            { text: 'Nombre', value: 'name' ,input:'', type:'text', filter:true},
            { text: 'Descripcion', value: 'description' ,input:'', type:'text', filter:true},
            { text: 'Accion', value: '', type:"text", filter:false, input:''},          
		],
		origin_types:[],
		origin_type:{},
		loading: true,                
        dialog: false,
        editedIndex: -1,          
        last_page: 1,
        page: 1,    
        paginationRows: 10,
        total:0,
        from:0,
        to:0,     
		pagination_select:[10,20,30],
		bus: new Vue(),// para comunicacion entre componentes
	}),
	methods:{
		search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/origin_type',this.getParams()).then((data)=>{
                    console.log("after response");
                    this.origin_types = data.data;                    
                    console.log(this.origin_types);
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
		checkInput(search)
        {
            if(search=='')
            {
                this.search();
            }
        },
		// async getOriginType(){
		// 	let origin = await axios.get('/api/auth/origin_type/create')
		// 				.then(response=>{ return response.data});
		// 	console.log(origin);
		// 	return origin;
		// },
		edit(origin_type){
			this.bus.$emit('showDialog',origin_type)
		}
	},
	mounted(){
		this.search();
		this.bus.$on('closeDialog',()=>{
			this.search();
		});

	}
}
</script>

