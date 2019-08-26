<template>
<v-dialog v-model="dialog" persistent max-width="700px">
            <v-card>
            <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            >
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>

            <v-card-text v-if="item">
                <v-container grid-list-md>
                 <v-layout wrap>
                    <v-flex xs6 sm6 md6>
                        <v-text-field  :rules="nameRules" label="Nombre" hint="Ingrese Nombre" required v-model="item.name"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md12>
                        <v-text-field label="Descripcion" hint="Ingrese Descripcion " v-model="item.description"></v-text-field>
                    </v-flex>

                </v-layout>
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="sendClose()">Cancel</v-btn>

                <v-btn color="blue darken-1" flat @click="sendEmployeeType()">Guardar</v-btn>
            </v-card-actions>
            </v-form>
            </v-card>
        </v-dialog>
</template>
<script>
export default
{
    props:{
        dialog: Boolean,
        product_type: Object
	},
    data:()=>({
        valid: true,
        nameRules: [
            v => !!v || 'Nombre requerido'
        ]
    }),
    methods:{
        sendEmployeeType() {
            if(true || this.$refs.form.validate()) {
                this.$emit('product_type',this.item)
            } else {
                console.log('formulario no valido')
            }
        },
        sendClose() {
            this.$emit('close',false)
        },
    },
    computed:{
        item(){
           let item = this.product_type
           return item
        },
        parent_dialog(){
			return this.dialog
        },
        title(){
            let title='Crear Tipo de Producto'
            if(this.item.id) {

                title = 'Editar Tipo de Producto'
            }
            return title
        },
	}
}
</script>
