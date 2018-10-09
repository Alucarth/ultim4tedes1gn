<template>
    <v-card>
        <v-card-title>
            Empleados
        <v-spacer></v-spacer>

        <v-dialog v-model="dialog" max-width="700px">            
            <v-card>
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text v-if="newEmployee">
                <v-container grid-list-md>
                 <v-layout wrap>
                    <v-flex xs6 sm6 md2>
                        <v-text-field label="Item" hint="Ingrese item" required v-model="newEmployee.item"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md2>
                        <v-text-field label="C.I." hint="Ingrese cedula de identidad" v-model="newEmployee.identity_card"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md4>
                        <v-text-field label="Nombres" hint="Ingrese nombres" required v-model="newEmployee.name"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md4>
                        <v-text-field label="Apellidos" hint="Ingrese apellidos" v-model="newEmployee.last_name"></v-text-field>
                    </v-flex>
                    
                    <v-flex xs6 sm6 md3>
                        <v-menu
                            ref="menu1"
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
                            v-model="newEmployee.entry_date"
                            label="Fecha de Ingreso"          
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="newEmployee.entry_date" @input="$refs.menu2.save(date)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs6 sm6 md3>
                        <v-text-field label="Salario" hint="Ingrese total ganado" v-model="newEmployee.salary"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md3>
                        <v-text-field label="Bono" hint="Ingrese bono" v-model="newEmployee.bonus"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md3>
                        <v-text-field label="Hora extra" hint="Ingrese pago por hora extra" v-model="newEmployee.extra_hour"></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm12 md4>
                        <v-select                  
                        label="Cargo"
                        v-model="newEmployee.position_id"
                        :items="positions"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm12 md4>
                        <v-select                  
                        label="Area Oficial"
                        v-model="newEmployee.official_area_id"
                        :items="areas"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm12 md4>
                        <v-select                  
                        label="Area Temporal"
                        v-model="newEmployee.temporal_area_id"
                        :items="areas"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm12 md5>
                        <v-select                  
                        label="Tipo"
                        v-model="newEmployee.employee_type_id"
                        :items="types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm12 md5>
                        <v-select                  
                        label="Estado"
                        v-model="newEmployee.employee_contract_type_id"
                        :items="contract_types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm12 md2>
                        <v-checkbox
                        :label="`Activo`"
                        v-model="newEmployee.active"
                        ></v-checkbox>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="store(newEmployee)" v-if="editedIndex === -1">Guardar</v-btn>
                <v-btn color="blue darken-1" flat @click="update(newEmployee)" v-else>Actualizar</v-btn>                                
            </v-card-actions>
            </v-card>
        </v-dialog>


        <v-btn @click="create();" color="primary" dark class="mb-2">Nuevo</v-btn>
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="employees"        
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
                <td class="text-xs-left">{{ props.item.item }}</td>
                <td class="text-xs-left">{{ props.item.identity_card }}</td>      
                <td class="text-xs-left">{{ props.item.last_name }}</td>
                <td class="text-xs-left">{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.official_area.name }}</td>                
                <td class="text-xs-left">{{ props.item.temporal_area.name }}</td>
                <td class="text-xs-left">{{ props.item.position.name }}</td>                
                <td class="text-xs-left">{{ props.item.type.name }}</td>
                <td class="text-xs-left">{{ props.item.active }}</td>
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
            <v-card flat v-if="employee">
                <table>
                    <tr>
                        <td> 
                            &Iacute;tem        
                        </td>
                        <td>
                            <v-card-text>
                                {{  employee.item }}
                            </v-card-text>
                        </td>                    
                    </tr>
                    <tr>
                        <td> 
                            C.I.   
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.identity_card }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Nombres    
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Apellidos   
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.last_name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Fecha de ingreso
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.entry_date }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr v-if="employee.departure_date">
                        <td> 
                            Fecha de Salida    
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.departure_date }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Salario Ganado    
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.salary }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Bono        
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.bonus }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            pago por Horas extras trabajadas
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.extra_hour }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            &Aacute;rea oficial    
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.official_area.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            &Aacute;rea temporal                            
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.temporal_area.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Cargo
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.position.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Estado   
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.contract_type.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Tipo   
                        </td>
                        <td>
                            <v-card-text>
                                {{ employee.type.name }}
                            </v-card-text>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Activo    
                        </td>
                        <td>
                            <v-card-text v-if="employee.active">
                                S&Iacute;
                            </v-card-text>
                            <v-card-text v-else>
                                NO
                            </v-card-text>
                        </td>
                    </tr>
                </table>                                
            </v-card>
        </template>        
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
            { text: 'Item', value: 'item' },
            { text: 'C.I.', value: 'identity_card' },
            { text: 'Apellidos', value: 'last_name' },
            { text: 'Nombres', value: 'name' },
            { text: 'Area Oficial', value: 'official_area' },
            { text: 'Area Temporal', value: 'temporal_area' },
            { text: 'Cargo', value: 'position' },
            { text: 'Tipo', value: 'type' },
            { text: 'Activo', value: 'active' },
        ],
        areas: [],
        types: [],
        positions: [],
        contract_types: [],
        employees: [],
        employee: null,
        newEmployee: null,
        totalEmployees: 0,
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
        this.getAreas();
        this.getTypes();
        this.getPositions();
        this.getContracTypes();
    },
    methods:{
        search() {
            return new Promise((resolve,reject)=>{   
                this.getData('/api/auth/employee',this.getParams()).then((data)=>{
                    this.employees = data.data;                    
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
            this.editedIndex = -1;                        
            axios.get('/api/auth/employee/create')
            .then(response => {                                
                this.newEmployee = response.data.employee
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = true;
        },
        store(){
            let index = -1;
            axios.post('/api/auth/employee/', this.newEmployee)
            .then(response => {                
                alert('dato creado');
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog = false;
        },
        show(item) {                        
            axios.get(`/api/auth/employee/${item.id}`)          
            .then(response => {                
                this.employee = response.data.employee
            })
            .catch(error => {                
                console.log(error);
            });
        },
        edit (item) {
            this.editedIndex = this.employees.indexOf(item)            
            axios.get(`/api/auth/employee/${item.id}/edit`)            
            .then(response => {                
                this.newEmployee = response.data.employee
            })
            .catch(error => {                
                console.log(error);
            });
            
            this.dialog = true
        },
        update (item) {                        
            let index = this.editedIndex;            
            axios.put(`/api/auth/employee/${this.newEmployee.id}`, this.newEmployee)
            .then(response => {                
                this.employees[index].item = response.data.employee.item;
                this.employees[index].identity_card = response.data.employee.identity_card;
                this.employees[index].name = response.data.employee.name;
                this.employees[index].last_name = response.data.employee.last_name;
                this.employees[index].entry_date = response.data.employee.departure_date;
                this.employees[index].salary = response.data.employee.salary;
                this.employees[index].bonus = response.data.employee.bonus;
                this.employees[index].extra_hour = response.data.employee.extra_hour;
                this.employees[index].official_area_id = response.data.employee.official_area_id;
                this.employees[index].temporal_area_id = response.data.employee.temporal_area_id;
                this.employees[index].position_id = response.data.employee.position_id;
                this.employees[index].employee_contract_type_id = response.data.employee.employee_contract_type_id;
                this.employees[index].employee_type_id = response.data.employee.employee_type_id;
                this.employees[index].active = response.data.employee.active;                
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;
            //this.getLumber();
        },
        destroy (item) {

            let success_delete = false;
            axios.delete(`/api/auth/employee/${item.id}`)
            .then(function (response) {                                
                success_delete = true;
            })
            .catch(function (error) {
                console.log(error);                
            });                                                            
        },
        getPositions (){
            axios.get('/api/auth/position')
            .then(response => {
                this.positions = response.data.positions
            })
            .catch(error => {
                console.log(error);
            });
        },
        getTypes() {
            axios.get('/api/auth/employee_type')
            .then(response => {
                this.types = response.data.types          
            })
            .catch(error => {
                console.log(error);
            });
        },
        getAreas() {
            axios.get('/api/auth/area')
            .then(response => {
                this.areas = response.data.areas
            })
            .catch(error => {
                console.log(error);
            });
        },
        getContracTypes() {
            axios.get('/api/auth/employee_contract_type')
            .then(response => {
                this.contract_types = response.data.contract_types
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
