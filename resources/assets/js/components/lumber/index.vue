<template>

 
    <datatable v-bind="$data" @editItem="editItem">      
    </datatable>

</template>

<script>

import Vue from 'vue'
import axios from 'axios'
import Datatable from 'vue2-datatable-component'

Vue.use(Datatable)
import components from '../datatable/'
export default {
  components,
  name: 'LumberTable', 
  props: ['row'],
  data () {
    const amINestedComp = !!this.row
    return {
      supportBackup: true,
      supportNested: true,
      tblClass: 'table-bordered',
      tblStyle: 'color: #666',
      pageSizeOptions: [5, 10, 15, 20],
      columns: (() => {
        const cols = [          
          { title: 'Alto', field: 'high', thComp: 'FilterTh', tdStyle: { fontStyle: 'italic' } },
          { title: 'Ancho', field: 'width', thComp: 'FilterTh', tdStyle: { fontStyle: 'italic' } },
          { title: 'Espesor', field: 'density', thComp: 'FilterTh', tdStyle: { fontStyle: 'italic' } },          
          { title: 'Tipo', field: 'type', thComp: 'FilterTh',tdComp: 'Object', tdStyle: { fontStyle: 'italic' } },          
          { title: 'Especie', field:'specie', thComp: 'FilterTh',tdComp: 'Object', tdStyle: { fontStyle: 'italic' } },            
           { title: 'Operation', tdComp: 'Opt', visible: 'true' }
        ]
        const groupsDef = {
          Normal: ['Alto', 'Ancho', 'Espesor','Tipo','Especie'],
          Sortable: ['Alto'],
          Extra: []
        }
        //return cols;
        return cols.map(col => {
        console.log(col);
          Object.keys(groupsDef).forEach(groupName => {
            if (groupsDef[groupName].includes(col.title)) {
              
              col.group = groupName
            }            
          })
          return col
        })
      })(),
      data: [],
      total: 0,
      selection: [],
      summary: {},                
      query: amINestedComp ? { uid: this.row.friends } : {},      
      xprops: {
        eventbus: new Vue()
      }
    }
  },
  watch: {
    query: {      
      handler () {
        console.log("handling");
        this.handleQueryChange()
      },
      deep: true
    }
  },
  methods: {

    /**
     * Get filtered Record
     * @param   {Record} form
     * @resolve {Record}
     */
    handleQueryChange () {
      axios.get('/api/auth/getLumberData',{
        params: this.query
      }).then((response)=> {        
        this.data = response.data.lumbers;    
        this.total = response.data.total;      
      }).catch(function (error) {
        console.log(error)
      });
    },
    alertSelectedUids () {
      console.log(this.selection);
      alert(this.selection.map(({ id }) => id))
    },
    editItem (item) {
      console.log("here");
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      console.log(item);
      //this.date = item.birth_date
      //this.dialog = true
    },
    showModal () {
      this.$refs.myModalRef.show()
    },
  }
}
</script>
<style>
.w-240 {
  width: 240px;
}
</style>
