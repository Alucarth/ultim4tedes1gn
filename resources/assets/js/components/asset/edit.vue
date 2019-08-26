<template>
	<v-dialog v-model="parent_dialog" max-width="500px" persistent>
            <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>

            <v-card-text v-if="item">
                <v-container grid-list-md>
                 <v-layout wrap>
                      <v-flex xs12>
                        <v-text-field label="Código" v-model="item.code" ></v-text-field>
                    </v-flex>
                     <v-flex xs12>
                        <v-text-field label="Denominación" v-model="item.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-select
                            label="Tipo"
                            v-model="item.asset_type_id"
                            :items="asset_types"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-select
                            label="Area"
                            v-model="item.area_id"
                            :items="areas"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Costo" v-model="item.price" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Documento de compra" v-model="item.document" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <input
                                type="file"
                                style="display: none"
                                ref="pdf"
                                accept="application/pdf"
                                @change="onFilePicked"
                            >
                        <v-flex xs12>
                            <v-text-field label="Selecionar PDF" @click='pickFile' v-model='attachment.name' prepend-icon='attach_file'></v-text-field>
                        </v-flex>
                    </v-flex>
                    <v-flex xs6>
                        <v-menu
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                        >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                v-model="item.date"
                                label="Fecha de compra"
                                hint="Año-Mes-Dia"
                                persistent-hint
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="item.date" no-title @input="menu = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                    <v-flex xs6>
                        <v-menu
                            v-model="menu1"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                        >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                v-model="item.start_date"
                                label="Fecha de alta"
                                hint="Año-Mes-Dia"
                                persistent-hint
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="item.start_date" no-title @input="menu1 = false"></v-date-picker>
                        </v-menu>
                    </v-flex>
                    
                    <v-flex xs12>
                        <v-text-field label="Cantidad" v-model="item.quantity" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Marca" v-model="item.branch" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Capacidad" v-model="item.capacity" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Tiempo de vida" v-model="item.lifetime" ></v-text-field>
                    </v-flex>
                    <!-- <v-flex xs12>
                        <v-text-field label="Revaluo" v-model="item.revaluation" ></v-text-field>
                    </v-flex> -->
                    <!-- <v-flex xs12>
                        <v-text-field label="Porcentaje de depreciación" v-model="item.depreciation" ></v-text-field>
                    </v-flex> -->
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="item.description" ></v-text-field>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="sendasset()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(item)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        asset: Object,
	},
	methods:{
        pickFile () {
            this.$refs.pdf.click ()
        },
        onFilePicked (e) {
            const files = e.target.files
            console.log(files);
			if(files[0] !== undefined) {
				this.attachment.name = files[0].name
				if(this.attachment.name.lastIndexOf('.') <= 0) {
					return
				}
				const fr = new FileReader ()
				fr.readAsDataURL(files[0])
				fr.addEventListener('load', () => {
					this.attachment.url = fr.result
					this.attachment.file = files[0] // this is an excel file that can be sent to server...
				})
			} else {
				this.attachment.name = ''
                this.attachment.file = ''
                this.attachment.url = ''
				//this.excelUrl = ''
			}
        },
        sendasset() {
            var form = new FormData()
            let actual_form = this.item
            Object.keys(actual_form).forEach(key => form.append(key,actual_form[key]))
            form.append('file',this.attachment.file);
            this.$emit('asset',form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
        },
        sendClose() {
            this.$emit('close',false)
        },
        getAreas() {
            axios.get('/api/auth/area')
                .then((response)=> {
                    this.areas = response.data.areas
                })
                .catch((error)=> {
                    console.log(error)
                })
        },
        getAssetTypes() {
            axios.get('/api/auth/asset_type')
                .then((response)=> {
                    this.asset_types = response.data
                })
                .catch((error)=> {
                    console.log(error)
                })
        }
    },
    data:()=>({
        menu: false,
        menu1: false,
        areas: [],
        asset_types: [],
        attachment : { name : null,file: null, url: null }
    }),
    mounted (){
        this.getAreas()
        this.getAssetTypes()
    },
    computed:{
        item(){
           let item = this.asset
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Activo Fijo'
            if(this.item.id) {
                title = 'Editar Activo Fijo'
            }
            return title
        },
	}
}
</script>
