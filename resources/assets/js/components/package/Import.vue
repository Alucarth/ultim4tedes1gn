<template>
    <v-card>
        <v-card-title primary-title>
          <div>
            <h3 class="headline mb-0">Importacion de Paquetes</h3>
          </div>
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md text-xs-center>
                <v-layout row wrap>
                <v-flex xs6>
                    <v-layout row wrap> 
                        <v-flex xs12>
                             <v-combobox                  
                                label="Almacen"                
                                v-model="storageSelected"  
                                :items="storages"
                                item-text="name"
                                item-value="id"
                                placeholder="Seleccione un Almacen"
                                persistent-hint>                                
                            </v-combobox>
                            <input
                                type="file"
                                style="display: none"
                                ref="excel"
                                accept="application/vnd.ms-excel"
                                @change="onFilePicked"
                            >
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field label="Selecionar excel" @click='pickFile' v-model='excelName' prepend-icon='attach_file'></v-text-field>
                        </v-flex>
                     
                        <v-flex xs12>
                            <v-btn @click="loadExcel" ><v-icon>file_upload</v-icon>importar </v-btn>
                            <v-btn @click="store"> <v-icon>save</v-icon> Guardar</v-btn>
                        </v-flex>
                    </v-layout>

                </v-flex>
                <v-flex xs6 v-if="details.length >0">
                    <v-card >
                        <v-list two-line>
                        <template v-for="(item, index) in details">
                            <v-subheader
                            v-if="item.header"
                            :key="item.header"
                            >
                            {{ item.header }}
                            </v-subheader>

                            <v-divider
                            v-else-if="item.divider"
                            :inset="item.inset"
                            :key="index"
                            ></v-divider>

                            <v-list-tile
                            v-else
                            :key="item.title"
                            avatar
                        
                            >
                            <v-list-tile-avatar>
                                <v-icon>{{item.icon}}</v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title v-html="item.title"></v-list-tile-title>
                                <v-list-tile-sub-title v-html="item.subtitle"></v-list-tile-sub-title>
                            </v-list-tile-content>
                            </v-list-tile>
                        </template>
                        </v-list>
                    </v-card>
                </v-flex>
                
                </v-layout>
                <!-- <v-layout row>
                    <v-flex xs6>
                        
                    </v-flex>
                </v-layout>
                <v-layout row>
                   <v-flex xs6>
                        
                        
                    </v-flex>
                    <v-flex xs6>
                       
                    </v-flex>
                </v-layout> -->
            </v-container>



            <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
        
            <v-data-table
                :headers="headers"
                :items="packages"
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
                <td class="text-xs-left">{{ props.item.paquete }}</td>
                <td class="text-xs-left">{{ props.item.type.name }}</td>
                <td class="text-xs-left">{{ props.item.unit.name }}</td>
                <td class="text-xs-left">{{ props.item.espesor }}</td>
                <td class="text-xs-left">{{ props.item.ancho }}</td>
                <td class="text-xs-left">{{ props.item.largo }}</td>
                <!-- <td class="text-xs-left">{{ props.item.state.name }}</td> -->
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
                   
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Cantidad" hint="Ingrese cantidad" required v-model="item.cantidad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Cantidad Pie" hint="Ingrese cantidad" required v-model="item.cantidad_pie"></v-text-field>
                    </v-flex>
                 
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
        </v-card-text>
       
    </v-card>
    	
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
            { text: 'Paquete', value: 'paquete' },
            { text: 'Tipo', value: 'tipo' },
            { text: 'Unidad ', value: 'unidad' },
            { text: 'Espesor ', value: 'espesor' },
            { text: 'Ancho ', value: 'ancho' },
            { text: 'Largo ', value: 'largo' },
            { text: 'Cantidad Pz', value: 'cantidad' },
            { text: 'Canitdad Pie ', value: 'cantidad_pie' },
            { text: 'Precio Unitario', value: 'precio_unitario' },
            { text: 'Accion ' }
        ],
        storageSelected:null,
        storages:[],
        packages:[],
        species:[],
        types:[],
        units:[],
        details:[],
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
            axios.post('api/auth/import_package', formData,{
                headers: {
                        'Content-Type': 'multipart/form-data'
                        }
            })
            .then(response => {                
                console.log(response.data);
                this.packages = response.data;
                this.details = [
                    { header: 'Detalle de Paquetes' },
                    {
                        icon: 'functions',
                        title: ''+this.getQuantity,
                        subtitle: 'Cantidad'
                    },
                    { divider: true, inset: true },
                    {
                        icon: 'functions',
                        title: ''+this.getQuantityFeet,
                        subtitle:  'Cantidad Pies'
                    },
                    { divider: true, inset: true },
                    {
                        icon: 'fa-money',
                        title: 'Bs '+this.formatMoney(this.getTotal),
                        subtitle: 'Total',
                    }
                ]
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;      
            // this.search();      
        },
        store(){
            console.log("para guardado");
            axios.post('api/auth/save_packages',{packages:this.packages,storage_id: this.storageSelected.id } )
            .then(response => {                
                console.log(response.data);
                // this.packages = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;      
            // this.search();      
        },
         edit(item){
            this.indexItem = this.packages.indexOf(item)
            this.item = item;
            console.log(this.item);
            this.dialog = true;
        },
        update(){
            console.log(this.indexItem);
            this.item.valid =true;
            // Vue.packages[this.indexItem] = this.item;
            Object.assign(this.packages[this.indexItem], this.item);

            // this.item= item;
            this.dialog = false;
        },
        deleteItem (item) {
            const index = this.packages.indexOf(item)
            confirm('Esta seguro de Eliminar el resgitro') && this.packages.splice(index, 1)
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
            this.packages.forEach(item => {
                amount += item.cantidad * item.precio_unitario;
            });
            return amount;
        },
        getQuantity(){
            
            let amount = 0 ;
            this.packages.forEach(item => {
                amount += item.cantidad;
            });
            return amount;
        },
        getQuantityFeet(){
            
            let amount = 0 ;
            this.packages.forEach(item => {
                amount = amount + parseFloat(item.cantidad_pie) ;
               // console.log(amount)
            });
            return numeral(amount).format('0,0.00');
        }
    },
    mounted(){
        axios.get('api/auth/storage')
                .then((response) => {    
                    console.log(response);                                   
                    this.storages = response.data;                    
                });  
        axios.get('api/auth/type')
                .then((response) => {                                       
                    this.types = response.data.types;                    
                    // console.log(response.data);
                });  
         axios.get('api/auth/unit')
                .then((response) => {                                       
                    this.units = response.data.units;                    
                    // console.log(response.data);
                });  
        axios.get('api/auth/getSpecieData')
                .then((response) => {                                       
                    this.species = response.data;                    
                    // console.log(response.data);
                });  
    }
}
</script>
