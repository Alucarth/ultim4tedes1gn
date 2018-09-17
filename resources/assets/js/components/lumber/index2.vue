<template>
    <v-card>
        <v-card-title>
            Madera
        <v-spacer></v-spacer>
        <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            single-line
            hide-details
        >
        
        </v-text-field>
        </v-card-title>
        <v-data-table
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
            <!-- <tr @click="props.expanded = !props.expanded"> -->
                <td class="text-xs-left" >{{ props.item.high }}</td>            
                <td class="text-xs-left">{{ props.item.width }}</td>
                <td class="text-xs-left">{{ props.item.density }}</td>
                <td class="text-xs-left">{{ props.item.specie }}</td>
                <td class="text-xs-left">{{ props.item.type }}</td>      
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
                        @click="editItem(props.item)"
                    >
                        edit
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(props.item)"
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

        <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert>
        </v-data-table>
        
    </v-card>
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
            { text: 'Alto', value: 'high' },        
            { text: 'Ancho', value: 'width' },
            { text: 'Espesor', value: 'density' },
            { text: 'Especie', value: 'specie' },
            { text: 'Tipo', value: 'type' },            
        ],
        lumbers: [],
        lumber: null,
        totalLumber: 0,
        desserts: [],
        loading: true,
        filterName: 'high',
        filterValue: '',        
      }
    },
    mounted()
    {
        this.getLumber().then(
            this.getDataFromApi()
                .then(data => {
                this.lumbers = data.lumbers
                this.totalLumber = data.total
                })
        );
        
    },
    methods:{
        getDataFromApi () {
            
            return new Promise((resolve, reject) => {
            const { sortBy, descending, page, rowsPerPage } = this.pagination

            let items= this.lumbers;
            const total = items.length;

            if (this.pagination.sortBy) {
                items = items.sort((a, b) => {
                const sortA = a[sortBy]
                const sortB = b[sortBy]

                if (descending) {
                    if (sortA < sortB) return 1
                    if (sortA > sortB) return -1
                    return 0
                } else {
                    if (sortA < sortB) return -1
                    if (sortA > sortB) return 1
                    return 0
                }
                })
            }

            if (rowsPerPage > 0) {
                items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
            }

                resolve({
                items,
                total
                });
         
            })
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
        show(prop) {
            console.log(prop.id+'<<<<<');
            //this.lumber = prop;
            axios.get(`/api/auth/lumber/${prop.id}`)
            //axios.put('/api/auth/lumber/1',null)
            .then(response => {
                console.log('before');
                console.log(response.data.lumber);
                this.lumber = response.data.lumber
            })
            .catch(error => {
                console.log('error');
            console.log(error);
            });
            //this.props.expanded = !this.props.expanded;
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
