<template>
<v-dialog v-model="dialog" max-width="800px">
            <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>

            <v-card-text v-if="item">

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
                                v-model="date"
                                label="Picker in menu"
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                            </template>
                            <v-date-picker v-model="date" no-title scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                            <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md2>
                        <v-btn class="mx-1" fab dark color="green" @click="addWorkItem()">
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
                            <th scope="col">Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(work_item,index) in item.work_items" :key="index">
                                <td >
                                <v-combobox
                                    v-model="work_item.area_id"
                                    :items="areas"
                                    label="Area"
                                    item-text="name"
                                    item-value="id"
                                ></v-combobox>
                                </td>
                                <td><v-combobox
                                    v-model="work_item.task_id"
                                    :items="tasks"
                                    label="Tarea"
                                    item-text="name"
                                    item-value="id"
                                ></v-combobox></td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>

                        </tbody>
                    </table>
                    </v-flex>

                </v-layout>

            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>

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
        edit:false,

    }),
    mounted(){
        this.getAreas();
        this.getTasks();
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
        addWorkItem()
        {
            //  console.log(this.work);
            this.item.work_items.push({area_id:null,task_id:null});
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
