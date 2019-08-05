<template>
    <v-card>
        <v-card-title>
            <h3>Cargos</h3>
        <v-spacer></v-spacer>
        <v-btn @click="create();" color="primary" dark class="mb-2">Nuevo</v-btn>
        </v-card-title>
        <v-card-text>
             <vue-bootstrap4-table :rows="positions" :columns="columns" :config="config" >
                <template slot="sort-asc-icon">
                    <i class="fa fa-sort-asc"></i>
                </template>
                <template slot="sort-desc-icon">
                    <i class="fa fa-sort-desc"></i>
                </template>
                <template slot="no-sort-icon">
                    <i class="fa fa-sort"></i>
                </template>
                <!-- <template slot="active" slot-scope="props">
                   <div class="text-xs-center">
                    <v-chip :color="props.row.active?'success':'danger'" :text-color="props.row.active?'white':'danger'" small>{{props.row.active?'Activo':'Inactivo'}}</v-chip>
                    </div>
                </template> -->
                <template slot="option" slot-scope="props">
                    <!-- <v-icon  small>
                        remove_red_eye
                    </v-icon> -->
                    <v-icon @click="edit(props.row)" small>
                        edit
                    </v-icon>
                    <v-icon @click="destroy(props.row)" small>
                        delete
                    </v-icon>
                </template>
            </vue-bootstrap4-table>
        </v-card-text>
        <edit-position :dialog="dialog" :position="position" @close="close"  @position="update"></edit-position>

    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditPosition from './edit.vue';
export default {
    data:()=>({
        positions:[],
        position:{},
        dialog:false,
        columns: [
            {
                label: "Nombre",
                name: "name",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Nombre"
                },
                sort: true,
            },

            {
                label: "Descripcion",
                name: "description",
                filter: {
                    type: "simple",
                    placeholder: "Ingrese Descripcion"
                },
                sort: true,
            },

            {
                label: "Opciones",
                name: "option",
                sort: false,
            }],

        config: {
            checkbox_rows: false,
            rows_selectable: false,
            pagination: true,
            card_mode: false,
            show_refresh_button:  false,
            show_reset_button:  false,
            global_search:  {
                placeholder:  "Enter custom Search text",
                visibility:  false,
                case_sensitive:  false
            },
            per_page_options:  [5,  10,  20,  30],
            server_mode:  false,
        },


    }),
    mounted(){
        this.search();
    },
    methods:{
        search(){
            axios.get('/api/auth/position')
                 .then((response)=>{
                    // this.employees = response.data;
                    this.positions = response.data.positions;
                    console.log(response.data);
                });
        },
        create() {
            this.postion ={};
            this.dialog = true;
        },

        edit (item) {

            axios.get(`/api/auth/position/${item.id}/edit`)
            .then(response => {
                this.position = response.data
            })
            .catch(error => {
                console.log(error);
            });

            this.dialog = true
        },
        update (item) {
            console.log(item);
            axios.post('/api/auth/position', item)
                  .then(response => {
                        this.$store.dispatch('template/showMessage',{message:'Se Actualizó la lista de productos',color:'success'});
                        this.search();
                    })
                    .catch(function (error) {
                        this.$store.dispatch('template/showMessage',{message:error,color:'danger'});
                    });
            this.dialog =false;

        },
        destroy (item) {

            let success_delete = false;
            axios.delete(`/api/auth/position/${item.id}`)
            .then(function (response) {
                success_delete = true;
                this.search();
                 this.$store.dispatch('template/showMessage',{message:'Se Elimino el Cargo ',color:'success'});
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        close() {
            this.dialog = false;
        }
    },
    components: {
        VueBootstrap4Table,
        EditPosition
    }
}
</script>
