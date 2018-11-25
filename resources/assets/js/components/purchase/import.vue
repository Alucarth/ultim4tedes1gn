<template>
    	<v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
            <legend>Importar Compras</legend>
            <v-text-field label="Selecionar excel" @click='pickFile' v-model='excelName' prepend-icon='attach_file'></v-text-field>
            <v-combobox                  
                label="Proveedor"                
                v-model="providerSelected"  
                :items="providers"
                item-text="name"
                item-value="id"
                placeholder="Seleccione un Proveedor"
                persistent-hint>                                
            </v-combobox>
            <input
                type="file"
                style="display: none"
                ref="excel"
                accept="application/vnd.ms-excel"
                @change="onFilePicked"
            >
            <v-btn @click="loadExcel">importar</v-btn> <v-btn @click="store"> Guardar</v-btn>
             TOTAL {{ formatMoney(getTotal) }}
            <v-data-table
                :headers="headers"
                :items="purchases"
                :search="search"
            >
            <template slot="items" slot-scope="props">
                <td class="text-xs-left">
                    <v-checkbox
                        readonly
                        :color="props.item.valid?'success':'warning'"
                        v-model="props.item.valid"
                    ></v-checkbox>
                </td>
                <td class="text-xs-left">{{ props.item.cefo }}</td>
                <td class="text-xs-left">{{ props.item.fecha }}</td>
                <td class="text-xs-left">{{ props.item.specie.name }}</td>
                <!-- <td class="text-xs-left">{{ props.item.codigo }}</td> -->
                <td class="text-xs-left">{{ props.item.type.name }}</td>
                <td class="text-xs-left">{{ props.item.unit.name }}</td>
                <td class="text-xs-left">{{ props.item.espesor }}</td>
                <td class="text-xs-left">{{ props.item.ancho }}</td>
                <td class="text-xs-left">{{ props.item.largo }}</td>
                <td class="text-xs-left">{{ props.item.cantidad }}</td>
                <td class="text-xs-left">{{ props.item.cantidad_pie }}</td>
                <td class="text-xs-left">{{ props.item.precio_unitario }}</td>
                <td class="text-xs-left">
                      <!-- <v-badge :color="props.item.valid==true?'green':'red'" left>
                        <span slot="badge" >!</span> -->
                        <v-icon @click="edit(props.item)">
                            edit
                        </v-icon>
                        <!-- </v-badge> -->
                    <!-- <v-icon>edit</v-icon> -->
                    <v-icon @click="deleteItem(props.item)">delete</v-icon> 
                </td>
                
                
            </template>
            <v-alert slot="no-results" :value="true" color="error" icon="warning">
                Su busqueda para "{{ search }}" no se encontraron resultados.
            </v-alert>
            </v-data-table>

            <v-dialog v-model="dialog" max-width="800px">            
            <v-card >
            <v-card-title>
                <span class="headline">Editar</span>
            </v-card-title>

            <v-card-text v-if="item!=null">
                <v-container grid-list-md>
                 <v-layout wrap>
                    <v-flex xs12 sm6 md6>
                        <v-text-field label="CEFO" hint="Ingrese CEFO" required v-model="item.cefo"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-menu
                        :close-on-content-click="false"
                        v-model="menu2"
                        :nudge-right="40"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        max-width="290px"
                        min-width="290px"
                        >
                        <v-text-field
                            slot="activator"
                            v-model="item.fecha"
                            label="Fecha"
                            hint="Año-Mes-Dia"
                            persistent-hint
                            prepend-icon="event"
                            readonly
                        ></v-text-field>
                        <v-date-picker v-model="item.fecha" no-title @input="menu2 = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs12 sm6 md4> 
                        <v-combobox                  
                            label="Especie"                
                            v-model="item.specie"  
                            :items="species"
                            item-text="name"
                            item-value="id"
                            placeholder="Seleccione Especie"
                            persistent-hint>                                
                        </v-combobox>
                    </v-flex>
                    <v-flex xs12 sm6 md4> 
                        <v-combobox                  
                            label="Tipo"                
                            v-model="item.type"  
                            :items="types"
                            item-text="name"
                            item-value="id"
                            placeholder="Seleccione Tipo"
                            persistent-hint>                                
                        </v-combobox>
                    </v-flex>
                    <v-flex xs12 sm6 md4> 
                        <v-combobox                  
                            label="Unidad"                
                            v-model="item.unit"  
                            :items="units"
                            item-text="name"
                            item-value="id"
                            placeholder="Seleccione Unidad"
                            persistent-hint>                                
                        </v-combobox>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Espesor" hint="Ingrese espesor" required v-model="item.espesor"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Ancho" hint="Ingrese ancho" required v-model="item.ancho"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Largo" hint="Ingrese largo" required v-model="item.largo"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-text-field label="Cantidad" hint="Ingrese cantidad" required v-model="item.cantidad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-text-field label="Cantidad Pie" hint="Ingrese cantidad" required v-model="item.cantidad_pie"></v-text-field>
                    </v-flex>
                    <!-- <v-flex xs12 sm6 md4> -->
                        <!-- <v-text-field label="Ancho" hint="Ingrese el ancho de la madera" v-model="newLumber.width"></v-text-field> -->
                    <!-- </v-flex> -->
                                            
                    <!-- <v-flex xs12 sm6>
                        <v-select                  
                        label="Tipo de madera"
                        v-model="newLumber.type_id"
                        :items="types"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion del tipo seleccionado`"
                        persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-select                  
                        label="Especie"                
                        v-model="newLumber.specie_id"  
                        :items="species"
                        item-text="name"
                        item-value="id"
                        :hint="`Descripcion de la madera seleccionada`"
                        persistent-hint>                                
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="newLumber.description" ></v-text-field>
                    </v-flex>   -->
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
        
                <v-btn color="blue darken-1" flat @click="update()">Actualizar</v-btn>
                
                
            </v-card-actions>
            </v-card>
        </v-dialog>

        </v-flex>
</template>
<script>
export default {
    data: () => ({

		excelName: '',
		excelUrl: '',
		excelFile: '',
        search: '',
        headers: [
            { text: 'Valido', value: 'valid' },
            { text: 'CEFO', value: 'cefo' },
            { text: 'Fecha', value: 'fecha' },
            { text: 'Especie', value: 'especie' },
            // { text: 'Codigo', value: 'codigo' },
            { text: 'Tipo', value: 'tipo' },
            { text: 'Unidad ', value: 'unidad' },
            { text: 'Espesor ', value: 'espesor' },
            { text: 'Ancho ', value: 'ancho' },
            { text: 'Largo ', value: 'largo' },
            { text: 'Cantidad ', value: 'cantidad' },
            { text: 'Canitdad Pie ', value: 'cantidad_pie' },
            { text: 'Precio Unitario', value: 'precio_unitario' },
            { text: 'Accion ' }
        ],
        providerSelected:null,
        providers:[],
        purchases:[],
        species:[],
        types:[],
        units:[],
        dialog:false,
        item: null,
        indexItem : -1,
        menu2: false,
        date: new Date().toISOString().substr(0, 10),
    }),
    methods:{
        pickFile () {
            this.$refs.excel.click ()
        },
        onFilePicked (e) {
            const files = e.target.files
            console.log(files);
			if(files[0] !== undefined) {
				this.excelName = files[0].name
				if(this.excelName.lastIndexOf('.') <= 0) {
					return
				}
				const fr = new FileReader ()
				fr.readAsDataURL(files[0])
				fr.addEventListener('load', () => {
					this.excelUrl = fr.result
					this.excelFile = files[0] // this is an excel file that can be sent to server...
				})
			} else {
				this.excelName = ''
				this.excelFile = ''
				this.excelUrl = ''
			}
        },
        loadExcel(){
            console.log("mandando la hueva");
            var formData = new FormData();
            formData.append("excel", this.excelFile);
            axios.post('api/auth/import_purchases', formData,{
                headers: {
                        'Content-Type': 'multipart/form-data'
                        }
            })
            .then(response => {                
                console.log(response.data);
                this.purchases = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;      
            // this.search();      
        },
        store(){
            console.log("para guardado");
            axios.post('api/auth/save_purchases',{purchases: this.purchases, provider_id:this.providerSelected.id, amount: this.getTotal})
            .then(response => {                
                console.log(response.data);
                // this.purchases = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;      
            // this.search();      
        },
        edit(item){
            this.indexItem = this.purchases.indexOf(item)
            this.item = item;
            console.log(this.item);
            this.dialog = true;
        },
        update(){
            console.log(this.indexItem);
            this.item.valid =true;
            // Vue.purchases[this.indexItem] = this.item;
            Object.assign(this.purchases[this.indexItem], this.item);

            // this.item= item;
            this.dialog = false;
        },
        deleteItem (item) {
            const index = this.purchases.indexOf(item)
            confirm('Esta seguro de Eliminar el resgitro') && this.purchases.splice(index, 1)
        },

        formatMoney(amount)
        {
            return "Bs "+numeral(amount).format("0,0.00");
        },
        close() {
            this.dialog = false;
        },
    
    },
    computed:{
        getTotal(){
            
            let amount = 0 ;
            this.purchases.forEach(item => {
                amount += item.cantidad * item.precio_unitario;
            });
            return amount;
        }
    },
    mounted(){
         axios.get('api/auth/getProviderData')
                .then((response) => {                                       
                    this.providers = response.data;                    
                });  
         axios.get('api/auth/getProviderData')
                .then((response) => {                                       
                    this.species = response.data;                    
                    // console.log(response.data);
                });  
         axios.get('api/auth/type')
                .then((response) => {                                       
                    this.types = response.data.types;                    
                    // console.log(response.data);
                });  
         axios.get('api/auth/unit')
                .then((response) => {                                       
                    this.units = response.data.units;                    
                    console.log(response.data);
                });  

        console.log( new Date('2014-04-03').toISOString().substr(0, 10));
    }
}
</script>
<style>
table.v-table tbody td:first-child, table.v-table tbody td:not(:first-child), table.v-table tbody th:first-child, table.v-table tbody th:not(:first-child), table.v-table thead td:first-child, table.v-table thead td:not(:first-child), table.v-table thead th:first-child, table.v-table thead th:not(:first-child) {
  padding: 0 10px
}
</style>