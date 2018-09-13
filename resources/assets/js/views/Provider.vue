<template>
  <div>
    <!-- <v-toolbar flat color="white">
      <v-toolbar-title>Proveedores</v-toolbar-title>
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <v-btn slot="activator" color="primary" dark class="mb-2">Nevo Proveedor</v-btn>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.name" label="Dessert name"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
            <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar> -->



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
  </div>
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
        providers:[]
      }
    },
    created()
    {
     
      self = this;
       axios
           .get('/api/provider')
           .then(function(response) {
                //this.data.loans = response.data;
                console.log('obteniendo lista ')
                //self.loans = response.data;
                console.log(response.data);
                self.providers = response.data;
                self.totalProviders = response.data.length;
                self.loading = false;
            });
     
    }
   
    

}
</script>
