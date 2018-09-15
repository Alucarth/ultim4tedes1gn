<template>
    <v-card>
        <v-card-title>
        Provedores
        <v-spacer></v-spacer>
        <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            single-line
            hide-details
        ></v-text-field>
        </v-card-title>
        <v-data-table
        :headers="headers"
        :items="providers"
        :search="search"
        >
        <template slot="items"  slot-scope="props">
            <td class="text-xs-left" >{{ props.item.name }}</td>
            <!-- <td class="text-xs-left">{{ props.item.offer }}</td> -->
            <td class="text-xs-left">{{ props.item.first_name }}</td>
            <td class="text-xs-left">{{ props.item.last_name }}</td>
            <td class="text-xs-left">{{ props.item.position }}</td>
            <td class="text-xs-left">{{ props.item.email }}</td>
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-left">{{ props.item.balance }}</td>
            <td class="text-xs-left">{{ props.item.debit }}</td>
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
            Your search for "{{ search }}" found no results.
        </v-alert>
        </v-data-table>
    </v-card>
</template>
<script>
export default {
    data () {
      return {
        search: '',
        headers: [
          
          { text: 'Proveedor', value: 'name' },
        //   { text: 'Oferta', value: 'offer' },
          { text: 'Nombres', value: 'first_name' },
          { text: 'Apellidos', value: 'last_name' },
          { text: 'Email', value: 'email' },
          { text: 'Telefono', value: 'phone' },
          { text: 'Cargo', value: 'position' },
          { text: 'Balance', value: 'balance' },
          { text: 'Debito', value: 'debit' },
        ],
        providers: []
      }
    },
    created()
    {
        axios
           .get('/api/provider')
           .then((response) => {
                this.providers = response.data;            
            });
    }
}
</script>
