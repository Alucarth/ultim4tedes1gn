<template>
  <div class="btn-group btn-group-sm">
    <!-- <b-alert
        :value="alert"
        :type="alert_type"
        dismissible
        transition="scale-transition"
      >
        {{alert_msg}}
    </b-alert> -->
    <v-btn color="info" title="Display row"
      :class="{ '-nested-comp-open-btn': isDisplayRowVisible }"
      @click="toggleNestedComp('DisplayRow')">
      VER
      <!-- <i class="fa fa-list-ul"></i> -->

    </v-btn>    
    <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="500px">
    <v-btn color="success" slot="activator" dark>
      Editar
    </v-btn>                
      <v-card v-if="actual_row" class="col-md-12">
        <v-card-title class="col-md-12">
          <span class="headline">Edición de Madera</span>
        </v-card-title>
        <v-card-text class="col-md-12">
          <v-container grid-list-md class="col-md-12">
            <v-layout wrap>
              <v-flex xs12 sm6 md4 class="col-md-4">
                <v-text-field label="Alto" hint="Ingrese el alto de la madera" required v-model="actual_row.high"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4 class="col-md-4">
                <v-text-field label="Ancho" hint="Ingrese el ancho de la madera" v-model="actual_row.width"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4 class="col-md-4">
                <v-text-field
                  label="Densidad"
                  hint="Ingrese la densidad de la madera"                  
                  required
                  v-model="actual_row.density"
                ></v-text-field>
              </v-flex>                          
              <v-flex xs12 sm6 class="col-md-6">
                <v-select                  
                  label="Tipo de madera"
                  v-model="actual_row.type"
                  :items="types"
                  item-text="name"
                  item-value="id"
                  :hint="`Descripcion del tipo seleccionado`"
                  persistent-hint>
                </v-select>
              </v-flex>
              <v-flex xs12 sm6 class="col-md-6">
                <v-select                  
                  label="Especie"                
                  v-model="actual_row.specie"  
                  :items="species"
                  item-text="name"
                  item-value="id"
                  :hint="`Descripcion de la madera seleccionada`"
                  persistent-hint>                                
                </v-select>
              </v-flex>
              <v-flex xs12 class="col-md-12">
                <v-text-field label="Descripción"></v-text-field>
              </v-flex>  
            </v-layout>
          </v-container>          
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="updateData">Guardar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>



  </div>
  
</template>
<script>

export default {
  props: ['row', 'nested'],
  data () {
    return{
      statuses: [],
      alert: false,
      alert_type: null,
      alert_msg: null,
      dialog: false,
      actual_row: null,
      species: [],
      types: [],
      editedLumber: null,
    }
    
  },
  // data: {
    
  // },
  mounted () {            
    this.actual_row = this.row;
    //this.getSpecies();        
    //this.getTypes();
  },
  computed: {
    isDisplayRowVisible () {
      if (this.nested.comp !== 'DisplayRow') return
      return this.nested.visible
    },
    isFriendsTableVisible () {
      if (this.nested.comp !== 'FriendsTable') return
      return this.nested.visible
    }
  },
  methods: {
    toggleNestedComp (comp) {
      const { nested } = this
      if (nested.comp === comp) return nested.$toggle()
      nested.$toggle(comp, true)
    },
    closeModal(){
       this.$refs.myModalRef.hide()
    },
    updateData(){
      console.log(this.actual_row.specie);
      axios.put('/api/auth/lumber/'+this.actual_row.id, this.actual_row)
      .then(function (response) {
        console.log(response.data.lumber); 
        //row.  
      })
      .catch(function (error) {
        console.log(error);
        this.alert = true;
        this.alert_type = "error";
        this.alert_msg = 'error on saving';
      });
      this.dialog =false;
    },
    getSpecies (){
      axios.get('/api/auth/specie')
      .then(response => {
          this.species = response.data.species          
      })
      .catch(error => {
        console.log(error);
      });
    },
    getTypes() {
      axios.get('/api/auth/type')
      .then(response => {
          this.types = response.data.types          
      })
      .catch(error => {
        console.log(error);
      });
    }    
  }
}
</script>
<style>
.-nested-comp-open-btn {
  color: #fff !important;
  background-color: #337ab7 !important;
}
</style>
