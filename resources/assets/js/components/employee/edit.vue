<template>
    <v-dialog v-model="dialog" max-width="700px">
            <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>

            <v-card-text v-if="item">
                <v-container grid-list-md>
                 <v-layout wrap>
                    <v-flex xs6 sm6 md2>
                        <v-text-field label="Item" hint="Ingrese item" required v-model="item.item"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md2>
                        <v-text-field label="C.I." hint="Ingrese cedula de identidad" v-model="item.identity_card"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md4>
                        <v-text-field label="Nombres" hint="Ingrese nombres" required v-model="item.name"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md4>
                        <v-text-field label="Apellidos" hint="Ingrese apellidos" v-model="item.last_name"></v-text-field>
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
                            v-model="item.entry_date"
                            label="Fecha de Ingreso"
                            readonly
                            ></v-text-field>
                            <v-date-picker v-model="item.entry_date" @input="$refs.menu1.save(date)"></v-date-picker>

                        </v-menu>
                    </v-flex>
                    <v-flex xs6 sm6 md3>
                        <v-text-field label="Salario" hint="Ingrese total ganado" v-model="item.salary"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md3>
                        <v-text-field label="Bono" hint="Ingrese bono" v-model="item.bonus"></v-text-field>
                    </v-flex>
                    <v-flex xs6 sm6 md3>
                        <v-text-field label="Hora extra" hint="Ingrese pago por hora extra" v-model="item.extra_hour"></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm12 md4>
                        <v-select
                        label="Cargo"
                        v-model="item.position_id"
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
                        v-model="item.official_area_id"
                        :items="areas"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <!-- <v-flex xs12 sm12 md4>
                        <v-select
                        label="Area Temporal"
                        v-model="item.temporal_area_id"
                        :items="areas"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex> -->
                    <v-flex xs12 sm12 md4>
                        <v-select
                        label="Tipo"
                        v-model="item.employee_type_id"
                        :items="types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm12 md5>
                        <v-select
                        label="Tipo de Contrato"
                        v-model="item.employee_contract_type_id"
                        :items="contract_types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo de contrato`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm12 md2>
                        <v-checkbox
                        :label="`Activo`"
                        v-model="item.active"
                        ></v-checkbox>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>

                <v-btn color="blue darken-1" flat @click="sendEmployee()">Guardar</v-btn>
            </v-card-actions>
            </v-card>
        </v-dialog>
</template>
<script>
export default
{
    props:{
        dialog: Boolean,
        employee: Object
	},
    data:()=>({
        areas: [],
        types: [],
        positions: [],
        contract_types: [],
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        modal: false,
        menu2: false,
    }),
    mounted(){
        this.getAreas();
        this.getTypes();
        this.getPositions();
        this.getContracTypes();
    },
    methods:{
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
        sendEmployee() {
            this.$emit('employee',this.item)
        },
        sendClose() {
            this.$emit('close',false)
        },
    },
    computed:{
        item(){
           let item = this.employee
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Empleado'
            if(this.item.id) {

                title = 'Editar Empleado'
            }
            return title
        },
	}

}
</script>
