<template>
    <v-card>
        <v-card-title>
            <h3>Tipos de Proucto</h3>
        <v-spacer></v-spacer>
        <v-btn @click="create();" color="primary" dark class="mb-2">Nuevo</v-btn>
        </v-card-title>
        <v-card-text>
             <vue-bootstrap4-table :rows="product_types" :columns="columns" :config="config" >
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
        <edit-type :dialog="dialog" :product_type="product_type" @close="close"  @product_type="update"></edit-type>

    </v-card>
</template>
<script>
import VueBootstrap4Table from 'vue-bootstrap4-table';
import EditType from './edit.vue';
export default {
    data:()=>({
        product_types:[],
        product_type:{},
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
            axios.get('/api/auth/product_type')
                 .then((response)=>{
                    this.product_types = response.data;
                    console.log(response.data);
                });
        },
        create() {
            this.product_type ={};
            this.dialog = true;
        },

        edit (item) {

            axios.get(`/api/auth/product_type/${item.id}/edit`)
            .then(response => {
                this.product_type = response.data
            })
            .catch(error => {
                console.log(error);
            });

            this.dialog = true
        },
        update (item) {
            console.log(item);
            axios.post('/api/auth/product_type', item)
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
            axios.delete(`/api/auth/product_type/${item.id}`)
            .then((response) =>{
                this.$store.dispatch('template/showMessage',{message:'Se Elimino el tipo de producto ',color:'success'});
                this.search();
            })
            .catch((error) => {
                console.log(error);
                 this.search();
            });
        },

        close() {
            this.dialog = false;
        }
    },
    components: {
        VueBootstrap4Table,
        EditType
    }
}
</script>
