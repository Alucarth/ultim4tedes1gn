<template>
    	<v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
            <leyend>Importar Compras</leyend>
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
                <td class="text-xs-left">{{ props.item.cefo }}</td>
                <td class="text-xs-left">{{ props.item.fecha }}</td>
                <td class="text-xs-left">{{ props.item.madera }}</td>
                <!-- <td class="text-xs-left">{{ props.item.codigo }}</td> -->
                <td class="text-xs-left">{{ props.item.tipo }}</td>
                <td class="text-xs-left">{{ props.item.unidad }}</td>
                <td class="text-xs-left">{{ props.item.espesor }}</td>
                <td class="text-xs-left">{{ props.item.ancho }}</td>
                <td class="text-xs-left">{{ props.item.largo }}</td>
                <td class="text-xs-left">{{ props.item.cantidad }}</td>
                <td class="text-xs-left">{{ props.item.cantidad_pie }}</td>
                <td class="text-xs-left">{{ props.item.precio_unitario }}</td>
                <td class="text-xs-left">
                      <v-badge :color="props.item.valid=true?'green':'red'" left>
                        <span slot="badge" >!</span>
                        <v-icon>
                            edit
                        </v-icon>
                        </v-badge>
                    <!-- <v-icon>edit</v-icon> -->
                    <v-icon>delete</v-icon> 
                </td>
                
                
            </template>
            <v-alert slot="no-results" :value="true" color="error" icon="warning">
                Su busqueda para "{{ search }}" no se encontraron resultados.
            </v-alert>
            </v-data-table>
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
            { text: 'CEFO', value: 'cefo' },
            { text: 'Fecha', value: 'fecha' },
            { text: 'Madera', value: 'madera' },
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
        formatMoney(amount)
        {
            return "Bs "+numeral(amount).format("0,0.00");
        }
    
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
    }
}
</script>
