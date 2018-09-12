<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="desserts"
      :pagination.sync="pagination"
      :total-items="totalDesserts"
      :loading="loading"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-right">{{ props.item.offer }}</td>
        <td class="text-xs-right">{{ props.item.address1 }}</td>
        <td class="text-xs-right">{{ props.item.city }}</td>
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
        totalDesserts: 0,
        desserts: [],
        loading: true,
        pagination: {},
        headers: [
          {
            text: 'Nombre',
            align: 'left',
            sortable: false,
            value: 'name'
          },
          { text: 'Vende', value: 'offer' },
          { text: 'Direccion', value: 'address1' },
          { text: 'Ciudad', value: 'city' },
          { text: 'Debito', value: 'debit' },
          { text: 'Balance', value: 'balance' }
        ]
      }
    },
    watch: {
      pagination: {
        handler () {
          this.getDataFromApi()
            .then(data => {
              this.desserts = data.items
              this.totalDesserts = data.total
            })
        },
        deep: true
      }
    },
    created(){
       self = this;
       axios
           .get('/api/provider')
           .then(function(response) {
                //this.data.loans = response.data;
                console.log('obteniendo lista ')
                //self.loans = response.data;
                console.log(response.data);
                self.desserts = response.data;
            });

    },
    mounted () {
     
      this.getDataFromApi()
        .then(data => {
          this.desserts = data.items
          this.totalDesserts = data.total
        })
    },
    methods: {
      getDataFromApi () {
        this.loading = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page, rowsPerPage } = this.pagination

          let items = this.getDesserts()
          const total = items.length

          if (this.pagination.sortBy) {
            items = items.sort((a, b) => {
              const sortA = a[sortBy]
              const sortB = b[sortBy]

              if (descending) {
                if (sortA < sortB) return 1
                if (sortA > sortB) return -1
                return 0
              } else {
                if (sortA < sortB) return -1
                if (sortA > sortB) return 1
                return 0
              }
            })
          }

          if (rowsPerPage > 0) {
            items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
          }

          setTimeout(() => {
            this.loading = false
            resolve({
              items,
              total
            })
          }, 1000)
        })
      }
      
    },
    computed:{
      getDesserts () {
        
        return this.desserts;
        
      }
    }

}
</script>
