<template>
	<v-dialog v-model="parent_dialog" max-width="800px" max-high="40px" persistent>
            <v-card>
            <v-card-title>
                <span class="headline">{{ title }}</span>
            </v-card-title>
        
            <v-card-text v-if="item">
                <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="item.name" label="Proveedor"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <!-- <v-text-field v-model="item.offer" label="Oferta"></v-text-field> -->
                        <v-combobox
                        v-model="item.offer_types"
                        :items="offer_types_list"
                        item-text = "name"
                        label="Oferta"
                        multiple
                        chips
                        >
                        <template v-slot:selection="data">
                            <v-chip
                            :key="JSON.stringify(data.item)"
                            :selected="data.selected"
                            :disabled="data.disabled"
                            class="v-chip--select-multi"
                            @input="data.parent.selectItem(data.item)"
                            >
                            <v-avatar
                                class="accent white--text"
                                v-text="data.item.name.slice(0, 1).toUpperCase()"
                            ></v-avatar>
                            {{ data.item.name }}
                            </v-chip>
                        </template>
                        </v-combobox>

                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="item.address1" label="Direccion Principal"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="item.address2" label="Direccion Secundaria"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md8>
                    <v-text-field v-model="item.description" label="Descripcion"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                    <v-text-field v-model="item.city" label="Ciudad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="item.balance" label="Balance"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                    <v-text-field v-model="item.debit" label="Debito"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm12 md12>
                    <v-btn
                        dark
                            round
                            color="blue"
                            @click="addContact"
                    >
                    <v-icon>add</v-icon>
                        Agregar Contacto 
                    </v-btn>
                    </v-flex>
                    <v-layout wrap v-for="(contact,index) in item.contacts" :key="index">
                    <v-flex xs12 sm6 md6>
                        <v-text-field v-model="contact.first_name" label="Nombres"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                        <v-text-field  v-model="contact.last_name" label="Apellidos"></v-text-field>
                    </v-flex>
                        <v-flex xs12 sm6 md6>
                        <v-text-field v-model="contact.position"  label="Cargo"></v-text-field>
                    </v-flex>
                        <v-flex xs12 sm6 md3>
                        <v-text-field v-model="contact.email"  label="Email"></v-text-field>
                    </v-flex>
                        <v-flex xs12 sm6 md3>
                        <v-text-field v-model="contact.phone"  label="Telefono"></v-text-field>
                    </v-flex>
                        <v-layout row justify-center>
                            <v-btn
                                icon
                                @click="removeContact(index)"
                            >
                            <v-icon>fa-trash</v-icon>
                            </v-btn>
                </v-layout>
                    </v-layout>
                
                </v-layout>
                
                </v-container>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat  @click="sendClose()">Cancelar</v-btn>
                <v-btn color="blue darken-1" flat @click="sendProvider()" >Guardar</v-btn>
                <!-- <v-btn color="blue darken-1" flat @click="update()" v-else>Actualizar</v-btn> -->
            </v-card-actions>
            </v-card>
        </v-dialog>  
</template>
<script>
export default {
	props:{
		provider: Object,
		dialog: Boolean
	},
	data:()=>({
        offer_types_list:[],
        // offer_types:[],
	}),
	mounted(){
        axios.get('api/auth/offer_types').then(response=>{
                                console.log(response.data); 
                                this.offer_types_list = response.data.offer_types;        
                                });
		console.log(this.provider); 
	},
	methods:{
        sendProvider(){
            this.$emit('provider',this.item);
        },
        sendClose()
        {
            this.$emit('close',false);
        },
        addContact()
        {
            this.item.contacts.push({});
        },
        removeContact(index)
        {
            this.item.contacts.splice(index,1);
        },
	},
	computed:{

        item(){
			let provider = this.provider;
			return provider;
		},
		parent_dialog(){
            // if(this.dialog){
            //     this.provider=null;
            // } 
			return this.dialog;
        },
        title(){
            let title='Crear Proveedor'
            if(this.item.id)
            {
                title = 'Editar Proveedor';
            }
            return title;
        },
	}
	

}
</script>
