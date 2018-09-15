<template>
  <v-card>
 
     <v-card-title>
      Provedores
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
     
      <v-dialog v-model="dialog" max-width="800px">
        <v-btn slot="activator" color="primary" dark class="mb-2">Nuevo</v-btn>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12 md12>
                  <v-text-field v-model="editedItem.name" label="Nombre"></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12>
                  <v-text-field v-model="editedItem.offer" label="Oferta"></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12>
                  <v-text-field v-model="editedItem.address1" label="Direccion"></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12>
                  <v-text-field v-model="editedItem.city" label="Ciudad"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="editedItem.debit" label="Debit"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="editedItem.balance" label="Balance"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="close">Cancelar</v-btn>
            <v-btn color="blue darken-1" flat @click.native="save">Guardar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog> 
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="providers"
      :search="search"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.offer }}</td>
        <td class="text-xs-left">{{ props.item.address1 }}</td>
        <td class="text-xs-left">{{ props.item.city }}</td>
        <td class="text-xs-right">{{ props.item.debit }}</td>
        <td class="text-xs-right">{{ props.item.balance }}</td>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
export default {
  data () {
      return {
        search: '',
        headers: [
          {
            text: 'Nombre',
            align: 'left',
            sortable: true,
            value: 'name'
          },
          { text: 'Oferta', value: 'offer' },
          { text: 'Direccion', value: 'address1' },
          { text: 'Ciudad', value: 'city' },
          { text: 'Debit', value: 'debit' },
          { text: 'Balance', value: 'balance' }
        ],
        providers:[],
        editedIndex: -1,
        editedItem: {
          name: '',
          offer: '',
          address1: '',
          city: '',
          debit: 0,
          balance: 0
        },
        defaultItem: {
          name: '',
          offer: '',
          address1: '',
          city: '',
          debit: 0,
          balance: 0
        },
        dialog: false
      }
    },
    created()
    {
     
      self = this;
       axios
           .get('/api/provider')
           .then(function(response) {
                //this.data.loans = response.data;
                //console.log('obteniendo lista ')
                //self.loans = response.data;
                //console.log(response.data);
                self.providers = response.data;
                self.totalProviders = response.data.length;
                self.loading = false;
            });
     
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Nuevo Proveedor' : 'Editar Proveedor'
      }
    },
    watch: {
      dialog (val) {
        val || this.close()
      }
    },
    methods:{
      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.desserts.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          this.desserts.push(this.editedItem)
        }
        this.close()
      }
    }

   
    

}
</script>
