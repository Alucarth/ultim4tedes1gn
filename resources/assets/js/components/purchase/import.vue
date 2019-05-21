<template>
<v-card>
        <v-card-title primary-title>
          <div>
            <h3 class="headline mb-0">Nueva Compra</h3>
          </div>
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md text-xs-center>
                <v-layout row wrap>
                <v-flex xs12>
                    <v-layout row wrap> 
                        <v-flex xs4 sm4 md4>
                            <v-combobox                  
                                label="Proveedor"                
                                v-model="proveedor"  
                                :items="providers"
                                item-text="name"
                                item-value="id"
                                placeholder="Seleccione un Proveedor"
                                persistent-hint>                                
                            </v-combobox>
                           
                        </v-flex>
                        <v-flex xs4 sm4 md4>
                            <v-text-field label="CEFO" hint="Ingrese CEFO" required v-model="cefo"></v-text-field>
                        </v-flex>
                         <v-flex xs4 sm4 md4>
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
                                v-model="fecha"
                                label="Fecha"
                                hint="Año-Mes-Dia"
                                persistent-hint
                                prepend-icon="event"
                                readonly
                            ></v-text-field>
                            <v-date-picker v-model="fecha" no-title @input="menu2 = false"></v-date-picker>
                            </v-menu>
                        </v-flex>
                        <v-flex xs12 sm12 md12>
                            <v-text-field label="Descripcion" hint="Ingrese descripcion" required v-model="descripcion"></v-text-field>
                        </v-flex>
                        <v-flex xs12>
                           
                        </v-flex>
                     
                       
                    </v-layout>

                </v-flex>
                <v-flex xs6>
                    <v-card color="cyan darken-1" class="white--text">
                    <v-card-title>
                        <v-layout row wrap>
                        <v-flex xs2 >
                            <v-icon>functions</v-icon>  
                        </v-flex>
                        <v-flex xs7 >
                           <p class="text-xs-left">Cantidad Pz</p>  
                        </v-flex>
                        <v-flex xs3 >
                            <p class="text-xs-right">{{this.getQuantity}}  </p>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs2 >
                            <v-icon>functions</v-icon>  
                        </v-flex>
                        <v-flex xs7 >
                           <p class="text-xs-left">Cantidad Pie</p>  
                        </v-flex>
                        <v-flex xs3 >
                            <p class="text-xs-right">{{this.getQuantityFeet}}  </p>
                        </v-flex>
                        </v-layout>
                        
                    </v-card-title>
                    <v-divider light></v-divider>
                    <v-card-actions class="pa-3">
                        
                        Total Compras
                        <v-spacer></v-spacer>
                        {{this.formatMoney(this.getTotal)}}
                    </v-card-actions>
                    </v-card>
                </v-flex>
                <v-flex xs6>
                    <v-card color="cyan darken-1" class="white--text">
                    <v-card-title>
                        <v-layout row wrap>
                        <v-flex xs2 >
                            <v-icon>functions</v-icon>  
                        </v-flex>
                        <v-flex xs7 >
                           <p class="text-xs-left">Cantidad de Gastos</p>  
                        </v-flex>
                        <v-flex xs3 >
                            <p class="text-xs-right">{{this.getQuantityExpensive}}  </p>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs2 >
                            <!-- <v-icon>attach_money</v-icon>   -->
                        </v-flex>
                        <v-flex xs7 >
                           <p class="text-xs-left">&nbsp;</p>  
                        </v-flex>
                        <v-flex xs3 >
                            <p class="text-xs-right">&nbsp; </p>
                        </v-flex>
                        </v-layout>
                        
                    </v-card-title>
                    <v-divider light></v-divider>
                    <v-card-actions class="pa-3">
                        
                        Total Gastos
                        <v-spacer></v-spacer>
                        {{this.formatMoney(this.getTotalExpensive)}}
                    </v-card-actions>
                    </v-card>
                </v-flex>
              
                <v-flex xs12>
            
                     <p class="text-xs-left">
                     
                        <v-btn color='success' dark  @click="store()" >Guardar <v-icon  right dark>save</v-icon> </v-btn>
                     </p>
                </v-flex>
                <!-- <v-flex xs6 v-if="details.length >0">
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
                </v-flex> -->
                
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

            <v-tabs
                centered
                color="cyan"
                dark
                icons-and-text
            >
                <v-tabs-slider color="yellow"></v-tabs-slider>

                <v-tab href="#tab-1">
                Compras 
                <v-icon>shopping_cart</v-icon>
                </v-tab>

                <v-tab href="#tab-2">
                Gastos
                <v-icon>attach_money</v-icon>
                </v-tab>

                <v-tab-item
                id="tab-1"
                >
                    <v-btn color='success' small @click="create()" >adcionar <v-icon small right >fa-plus-circle</v-icon> </v-btn>
                    <input
                                type="file"
                                style="display: none"
                                ref="excel"
                                accept="application/vnd.ms-excel"
                                @change="onFilePicked"
                            >
                    
                    <v-btn  @click='pickFile' small color="success"> importar  <v-icon small right >fa-file-excel-o</v-icon> </v-btn>        
                    <v-chip close v-model="chip">
                        <v-avatar>
                            <v-icon small color="success">fa-file-excel-o</v-icon>
                        </v-avatar>
                        {{excelName}}
                    </v-chip>
                    <!-- <v-text-field label="Selecionar excel"  v-model='excelName' prepend-icon='attach_file'></v-text-field> -->
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
                        <!-- <td class="text-xs-left">{{ props.item.cefo }}</td>
                        <td class="text-xs-left">{{ props.item.fecha }}</td> -->
                        <td class="text-xs-left">{{ props.item.specie.name }}</td>
                        <!-- <td class="text-xs-left">{{ props.item.codigo }}</td> -->
                        <td class="text-xs-left">{{ props.item.type.name }}</td>
                        <td class="text-xs-left">{{ props.item.unit.name }}</td>
                        <td class="text-xs-left">{{ props.item.espesor }}</td>
                        <td class="text-xs-left">{{ props.item.ancho }}</td>
                        <td class="text-xs-left">{{ props.item.largo }}</td>
                        <td class="text-xs-left">{{ props.item.state.name }}</td>
                        <td class="text-xs-left">{{ props.item.cantidad }}</td>
                        <td class="text-xs-left">{{ props.item.cantidad_pie }}</td>
                        <td class="text-xs-left">{{ props.item.precio_unitario }}</td>
                        <td class="text-xs-left">{{ props.item.origin_type.name }}</td>
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
                </v-tab-item>
                <v-tab-item
                id="tab-2"
                >
                <v-card flat>
                    <v-card-text> 
                    
                        <v-btn color='success' @click="createExpensive()"  small>adcionar <v-icon right small>fa-plus-circle</v-icon> </v-btn>
                        <v-data-table
                            :headers="header_expensive"
                            :items="purchase_expenses"
                            :search="search"
                        >
                            <template slot="items" slot-scope="props">
                                
                                <td class="text-xs-left">{{ props.item.expensive.name }}</td>
                                <td class="text-xs-left">{{ props.item.cost }}</td>
                                <td class="text-xs-left">
                                    <!-- <v-badge :color="props.item.valid==true?'green':'red'" left>
                                        <span slot="badge" >!</span> -->
                                        <v-icon @click="editeExpensive(props.item)">
                                            edit
                                        </v-icon>
                                        <!-- </v-badge> -->
                                    <!-- <v-icon>edit</v-icon> -->
                                    <v-icon @click="deleteExpensive(props.item)">delete</v-icon> 
                                </td>
                                
                                
                            </template>
                            <v-alert slot="no-results" :value="true" color="error" icon="warning">
                                Su busqueda para "{{ search }}" no se encontraron resultados.
                            </v-alert>
                        </v-data-table>
                    </v-card-text>
                </v-card>
                </v-tab-item>
            </v-tabs>


            <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
        
            

            <!-- Dialogo para edicion de linea -->
            <v-dialog v-model="dialog" max-width="800px">             
            <v-card >
            <v-card-title>
                <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text v-if="item!=null">
                <v-container grid-list-md>
                 <v-layout wrap>
                    
                   
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
                        <v-combobox                  
                            label="Estado"                
                            v-model="item.state"  
                            :items="states"
                            item-text="name"
                            item-value="id"
                            placeholder="Seleccione Estado"
                            persistent-hint>                                
                        </v-combobox>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Cantidad" hint="Ingrese cantidad" required v-model="item.cantidad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Cantidad Pie" hint="Ingrese cantidad" required v-model="item.cantidad_pie"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-text-field label="Precion Unitario" hint="Ingrese precio" required v-model="item.precio_unitario"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4> 
                        <v-combobox                  
                            label="Tipo de Origen"                
                            v-model="item.origin_type"  
                            :items="origin_types"
                            item-text="name"
                            item-value="id"
                            placeholder="Seleccione Tipo de Origen"
                            persistent-hint>                                
                        </v-combobox>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>

                <v-btn v-if='editedIndex === -1' color="blue darken-1" flat @click="addItem(item)" >Crear</v-btn>
                <v-btn v-else color="blue darken-1" flat @click="updateExpensive()">Actualizar</v-btn>
                
                
            </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- dialog del expensive -->
        <v-dialog v-model="dialog_expensive" max-width="600px">             
            <v-card >
            <v-card-title>
                <span class="headline">{{formTitleExpensive}}</span>
            </v-card-title>
         <v-card-text v-if="item_expensive!=null">
                <v-container grid-list-md>
                 <v-layout wrap>
                    
                   
                    <v-flex xs12 sm6 md6> 
                        <v-combobox                  
                            label="Especie"                
                            v-model="item_expensive.expensive"  
                            :items="expenses"
                            item-text="name"
                            item-value="id"
                            placeholder="Seleccione Tipo de Gasto"
                            persistent-hint>                                
                        </v-combobox>
                    </v-flex>
                 
                    <v-flex xs12 sm6 md6>
                        <v-text-field label="Costo" hint="Ingrese costo" required v-model="item_expensive.cost"></v-text-field>
                    </v-flex>
                 
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="storeExpensive(item_expensive)" v-if="expensiveIndex === -1">Guardar</v-btn>
                <v-btn color="blue darken-1" flat @click="updateExpensive(item_expensive)" v-else>Actualizar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update()">Actualizar</v-btn> -->
                
                
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
            // { text: 'CEFO', value: 'cefo' },
            // { text: 'Fecha', value: 'fecha' },
            { text: 'Especie', value: 'especie' },
            // { text: 'Codigo', value: 'codigo' },
            { text: 'Tipo', value: 'tipo' },
            { text: 'Unidad', value: 'unidad' },
            { text: 'Espesor', value: 'espesor' },
            { text: 'Ancho', value: 'ancho' },
            { text: 'Largo', value: 'largo' },
            { text: 'Estado', value: 'estado' },
            { text: 'Cantidad Pz', value: 'cantidad' },
            { text: 'Canitdad Pie', value: 'cantidad_pie' },
            { text: 'Precio Unitario', value: 'precio_unitario' },
            { text: 'Origen', value: 'origen' },
            { text: 'Accion ', value:''}
        ],
        header_expensive:[
            { text: 'Nombre', value: 'name'},
            { text: 'Costo Bs', value: 'cost'},
            { text: 'Accion ', value:''}
        ],
        proveedor:null, //dato global de compra
        fecha: new Date().toISOString().substr(0, 10), //dato global de compra
        cefo: '', //dato global de compra
        descripcion: '', //dato global de compra
        providers:[],
        purchases:[],
        species:[],
        types:[],
        origin_types:[],
        units:[],
        states:[],
        expenses:[],
        purchase_expenses:[],
        dialog:false,
        dialog_expensive:false,
        item: null,
        item_expensive: null,
        expensiveIndex : -1,//para los expensive items
        editedIndex:-1,//para los purchase items
        menu2: false,
        date: new Date().toISOString().substr(0, 10),
        chip:false
    }),
    methods:{
        pickFile () {
            this.$refs.excel.click ()
        },
        onFilePicked (e) {
            const files = e.target.files
            // console.log(files);
            new Promise((resolve,reject)=>{
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
                         console.log(this.excelFile);
                        this.chip=true;
                        resolve()
                    })
                    
                } else {
                    this.excelName = ''
                    this.excelFile = ''
                    this.excelUrl = ''
                    reject();
                }
                
            }).then(console.log('cargo con exito XD'));
            
        },
    
        store(){
            console.log("para guardado");
            axios.post('api/auth/save_purchases',{purchases: this.purchases,purchase_expenses: this.purchase_expenses, provider_id:this.proveedor.id, amount: this.getTotal, fecha: this.fechas, cefo: this.cefo, descripcion:this.descripcion})
            .then(response => {                
                console.log(response.data);
                //adicionar status a las respuesta XD
                // this.purchases = response.data;
                 this.$store.dispatch('template/showMessage',{message:'Se registro correctamente el Gasto ',color:'success'});
            })
            .catch(function (error) {
                console.log(error);
            });            
            this.dialog =false;      
            // this.search();      
        },
        create(){ //para adicionar items manualmente 
            axios.get('api/auth/add_item_purchase')
                .then(response =>{
                    console.log(response.data);
                    this.species = response.data.species;
                    this.units = response.data.units;
                    this.types = response.data.types;
                    this.states = response.data.states;
                    this.editedIndex = -1;
                    this.item = response.data.item;
                    this.dialog = true;
                })  
                .catch(function (error) {
                    console.log(error);
                }); 

        },
        addItem(item){
            console.log(item);
            this.purchases.push(item);
            item.valid =true;
            this.dialog =false;
        },
        edit(item){
            this.editedIndex = this.purchases.indexOf(item)
            this.item = item;
            console.log(this.item);
            this.dialog = true;
        },
        update(){
            console.log(this.indexItem);
            this.item.valid =true;
            // Vue.purchases[this.indexItem] = this.item;
            Object.assign(this.purchases[this.editedIndex], this.item);

            // this.item= item;
            this.dialog = false;
        },
        deleteItem (item) {
           const index = this.purchases.indexOf(item)
           Swal.fire({
                    title: 'Esta seguro de eliminar el item?',
                    text: "Una ves realizada esta accion no podra revertirse!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                        'Item Eliminado!',
                        'el item ha sido elimiado de la lista.',
                        'success'
                        )
                         this.purchases.splice(index, 1);
                    }
                    })
          
          
               
        },

        formatMoney(amount)
        {
            return "Bs "+numeral(amount).format("0,0.00");
        },
        close() {
            this.dialog = false;
        },
        createExpensive() {                            
            axios.get('/api/auth/create_purchase_expensive')            
            .then((response) => {      
                 console.log(response.data);                          
                this.expenses = response.data.expenses
                this.item_expensive = response.data.purchase_expensive;
            })
            .catch(error => {                
                console.log(error);
            });
            this.dialog_expensive = true;
        },
        storeExpensive(item){
            // console.log(item);
            //guardar en lista 
            this.expensiveIndex = -1;
            this.purchase_expenses.push(item);
             this.dialog_expensive = false;
            console.log(this.purchase_expenses);
        },
        editeExpensive(item){
            this.expensiveIndex = this.purchase_expenses.indexOf(item);
            this.item_expensive =item;
            this.dialog_expensive = true;
        },
        updateExpensive(){
            // const index = this.purchase_expenses.indexOf(item);
            Object.assign(this.purchase_expenses[this.expensiveIndex], this.item_expensive);
            this.dialog_expensive = false;
        },
        deleteExpensive (item) {
            console.log(item);
           const index = this.purchase_expenses.indexOf(item)
             Swal.fire({
                    title: 'Esta seguro de eliminar el item?',
                    text: "Una ves realizada esta accion no podra revertirse!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                        'Item Eliminado!',
                        'el item ha sido elimiado de la lista.',
                        'success'
                        )
                          this.purchase_expenses.splice(index, 1);
                    }
                    });
          
               
        },
    
    },
    computed:{
        getTotal(){
            
            let amount = 0 ;
            this.purchases.forEach(item => {
                amount += item.cantidad * item.precio_unitario;
            });
            return amount;
        },
        getQuantity(){
            
            let amount = 0 ;
            this.purchases.forEach(item => {
                amount += parseFloat(item.cantidad);
            });
            return numeral(amount).format('0,0.00');
        },
        getQuantityFeet(){
            
            let amount = 0 ;
            this.purchases.forEach(item => {
                amount = amount + parseFloat(item.cantidad_pie) ;
               // console.log(amount)
            });
            return numeral(amount).format('0,0.00');
        },
        getQuantityExpensive(){
            let quantity = 0 ;
            if(this.purchase_expenses!=null){quantity =this.purchase_expenses.length};
            return numeral(quantity).format('0,0.00');
        },
        getTotalExpensive(){
            let amount = 0 ;
            this.purchase_expenses.forEach(item => {
                amount = amount + parseFloat(item.cost) ;
               // console.log(amount)
            });
            return numeral(amount).format('0,0.00');
        },
        formTitle () {
            return this.editedIndex === -1 ? 'Nuevo' : 'Editar'
        },
        formTitleExpensive () {
            return this.expensiveIndex === -1 ? 'Nuevo' : 'Editar'
        },


    },
    mounted(){
         axios.get('api/auth/getProviderData')
                .then((response) => {                                       
                    console.log(response);
                    this.providers = response.data;                    
                });  
         axios.get('api/auth/getSpecieData')
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
                    // console.log(response.data);
                });  
         axios.get('api/auth/state')
                .then((response) => {                                       
                    this.states = response.data.states;                    
                    console.log(response.data);
                });  
         axios.get('api/auth/getOriginTypesData')
                .then((response) => {                                       
                    this.origin_types = response.data;                    
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