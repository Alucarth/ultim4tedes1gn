<template>
<v-dialog v-model="dialog" >
            <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>

            <v-card-text v-if="item">
                <!-- {{JSON.stringify(item)}} -->
                 <v-layout wrap>
                    <v-flex xs12 sm6 md4>
                        <v-menu
                            ref="menu"
                            v-model="menu"
                            :close-on-content-click="false"
                            :return-value.sync="date"
                            transition="scale-transition"
                            offset-y
                            full-width
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                            <v-text-field
                                v-model="item.date"
                                label="Picker in menu"
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                            </template>
                            <v-date-picker v-model="item.date" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                            <v-btn text color="primary" @click="$refs.menu.save(item.date)">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md2>
                        <v-btn small fab dark color="green" @click="addWorkItem()">
                            <v-icon dark>add</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs12 sm12 md12>

                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Area</th>
                            <th scope="col">Tarea</th>
                            <th scope="col">Orden</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Tiempo</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Observacion</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(work_item,index) in item.work_items" :key="index">

                                <td  v-if="work_item.edit">
                                <v-combobox
                                    v-model="work_item.area"
                                    :items="areas"
                                    label="Area"
                                    item-text="name"
                                ></v-combobox>
                                </td>
                                <td v-else>{{work_item.area.name}}</td>
                                <td v-if="work_item.edit"><v-combobox
                                    v-model="work_item.task"
                                    :items="tasks"
                                    label="Tarea"
                                    item-text="name"

                                ></v-combobox></td>
                                <td v-else>{{work_item.task.name}}</td>
                                <td v-if="work_item.edit"><v-combobox
                                    v-model="work_item.order"
                                    :items="orders"
                                    label="Orden"
                                    item-text="name"

                                ></v-combobox></td>
                                <td v-else>{{work_item.order.name}}</td>
                                <td v-if="work_item.edit">
                                    <v-combobox
                                    v-model="work_item.product"
                                    :items="work_item.order.products"
                                    label="Producto"
                                    item-text="name"
                                    v-if="work_item.order"
                                ></v-combobox>
                                </td>
                                <td v-else>{{work_item.product.name}}</td>

                                <td v-if="work_item.edit">
                                    <v-text-field label="Hora" v-model="work_item.time"></v-text-field>
                                </td>
                                <td v-else>{{work_item.time}}</td>
                                <td> {{convertTime(work_item.time)}}</td>
                                <td v-if="work_item.edit">
                                    <v-text-field label="Cantidad" v-model="work_item.quantity"></v-text-field>
                                </td>
                                <td v-else>
                                    {{work_item.quantity}}
                                </td>
                                <td v-if="work_item.edit">
                                    <v-text-field label="Observacion" v-model="work_item.observation"></v-text-field>
                                </td>
                                <td v-else>
                                    {{work_item.observation}}
                                </td>

                                <!-- falta la descripcion -->
                                <td v-if="work_item.edit">
                                    <v-btn icon  @click="work_item.edit=false">
                                        <v-icon color="success" >save</v-icon>
                                    </v-btn>
                                    <v-icon @click="deleteWorkItem(index)">delete</v-icon>
                                    <!-- <v-btn icon >
                                        <v-icon color="red" @click="deleteWorkItem(index)">cancel</v-icon>
                                    </v-btn> -->
                                </td>
                                <td v-else>
                                    <v-icon @click="work_item.edit=true">edit</v-icon>
                                    <v-icon @click="deleteWorkItem(index)">delete</v-icon>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <!-- {{JSON.stringify(this.item)}} -->
                    </v-flex>

                </v-layout>

            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cerrar</v-btn>
                <v-btn color="blue darken-1" flat @click="sendWork()">Guardar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>
</template>
<script>
export default
{
    props:{
        dialog: Boolean,
        work: Object
	},
    data:()=>({
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        areas:[],
        tasks:[],
        orders:[],
        edit:false,

    }),
    mounted(){
        this.getAreas();
        this.getTasks();
        this.getOrders();
    },
    methods:{
        sendWork() {
            this.$emit('work',this.item)
        },
        sendClose() {
            this.$emit('close',false)
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
        getTasks(){
            axios.get('/api/auth/task')
                 .then((response)=>{
                    // this.employees = response.data;
                    this.tasks = response.data.tasks;
                    console.log(response.data);
                });
        },
        getOrders(){
            axios.get('/api/auth/order')
                 .then((response)=>{
                    // this.employees = response.data;
                    this.orders = response.data;
                    console.log(response.data);
                });
        },
        addWorkItem()
        {
            //  console.log(this.work);
            this.item.work_items.push({area:null,task:null,order:null,product:null,edit:true});
        },
        deleteWorkItem (index) {
            // const index = this.packages.indexOf(item)
            this.item.work_items.splice(index, 1)
        },
        convertTime(time)
        {
            let hour = 0;
            if(time){
                let hours = time.toString().split(':');
                hour =  parseInt(hours[0]);
                let minutes = parseInt(hours[1]);
                hour += (minutes / 60);
            }
            return hour;
        }
    },
    computed:{
        item(){
           let item = this.work
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Tiempo'
            if(this.item.id) {

                title = 'Editar Tiempo'
            }
            return title
        },
	}
}
</script>
