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
                        <v-text-field label="Nombre" v-model="item.name" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-autocomplete
                            label="Obra"
                            v-model="item.construction_id"
                            :items="constructions"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-autocomplete>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Costo" v-model="item.amount" ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-select
                            label="Tipo"
                            v-model="item.contract_type_id"
                            :items="contract_types"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-select
                            label="Vendedor"
                            v-model="item.employee_id"
                            :items="employees"
                            item-text="name"
                            item-value="id"
                            :hint="`Descripcion del tipo seleccionado`"
                            persistent-hint>
                        </v-select>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field label="Comisión" v-model="item.sales_commission" ></v-text-field>
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
                    <v-flex xs12>
                        <v-text-field label="Descripción" v-model="item.description" ></v-text-field>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>
                <v-btn color="blue darken-1" flat @click="sendContract()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update(item)" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
    </v-dialog>
</template>
<script>
export default {
	props:{
        dialog: Boolean,
        contract: Object,
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
        sendContract() {
            var form = new FormData()
            let form_contract = this.item
            Object.keys(form_contract).forEach(key => form.append(key,form_contract[key]))
            form.append('file',this.attachment.file);
            this.$emit('contract',form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
        },
        onFileChange(event) {
            console.log('changin file ')
            this.attachment.file = event.target.files[0]
            console.log(this.attachment.file)
        },
        sendClose() {
            this.$emit('close',false)
        },
        getContractTypes() {
            axios.get('/api/auth/contract_type')
                .then((response)=> {
                    this.contract_types = response.data
                })
                .catch((error)=> {
                    console.log(error)
                })
        },
        getConstructions() {
            axios.get('/api/auth/construction')
                .then((response)=> {
                    this.constructions = response.data
                })
                .catch((error)=> {
                    console.log(error)
                })
        },
        getEmployees() {
            axios.get('/api/auth/getEmployeeData')
                .then((response)=> {
                    let temp = response.data
                    this.employees = temp.filter(employee => employee.employee_type_id == 1)
                })
                .catch((error)=> {
                    console.log(error)
                })
        },
    },
    data:()=>({
        contract_types: [],
        constructions: [],
        employees: [],
        attachment : { name : null,file: null, url: null }
    }),
    mounted (){
        this.getContractTypes()
        this.getConstructions()
        this.getEmployees()
    },
    computed:{
        item(){
           let item = this.contract
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Contrato'
            if(this.item.id) {
                title = 'Editar Contrato'
            }
            return title
        },
	}
}
</script>
