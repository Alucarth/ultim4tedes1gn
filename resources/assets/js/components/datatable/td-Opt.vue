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
      <v-card>
        <v-card-title>
          <span class="headline">Edición de Madera</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md4>
                <v-text-field label="Alto" hint="Ingrese el alto de la madera" required v-model="actual_row.high"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-text-field label="Ancho" hint="Ingrese el ancho de la madera" v-model="actual_row.width"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-text-field
                  label="Densidad"
                  hint="Ingrese la densidad de la madera"                  
                  required
                  v-model="actual_row.density"
                ></v-text-field>
              </v-flex>                          
              <v-flex xs12 sm6>
                <v-select
                  :items="['0-17', '18-29', '30-54', '54+']"
                  label="Tipo"
                  required
                ></v-select>
              </v-flex>
              <v-flex xs12 sm6>
                <v-autocomplete
                  :items="['Skiing', 'Ice hockey', 'Soccer', 'Basketball', 'Hockey', 'Reading', 'Writing', 'Coding', 'Basejump']"
                  label="Especie"
                ></v-autocomplete>
              </v-flex>
              <v-flex xs12>
                <v-text-field label="Descripción"></v-text-field>
              </v-flex>  
            </v-layout>
          </v-container>          
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" flat @click.native="dialog = false">Guardar</v-btn>
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
    }
    
  },
  // data: {
    
  // },
  mounted () {    
    this.fillStatuses();
    console.log("asdfasdf");
    console.log(this.statuses[1]);
    this.actual_row = this.row;
    //console.log(this.row);
    // jQuery(this.$el).find('button[title]').tooltip();
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
    makeAction(comp) {
      //console.log("first comp");
      //this.$emit('editItem');
      //const { nested } = this
      console.log(comp.id);
      this.$refs.myModalRef.show();
      //this.$parent.editItem(comp);
    },
    closeModal(){
       this.$refs.myModalRef.hide()
    },
    save(comp){
      console.log(comp.id);
      axios.put('/record/'+comp.id, comp)
      .then(function (response) {
        console.log(response.data);        
        this.alert = true;
        this.alert_type = "success";
        this.alert_msg = 'ok';
      })
      .catch(function (error) {
        console.log(error);
        this.alert = true;
        this.alert_type = "error";
        this.alert_msg = 'error on saving';
      });
      this.closeModal();
    },
    fillStatuses () {
      axios
        .get('status')
        .then(response => {
          this.statuses = response.data       
        })
        .catch(error => {
          console.log(error)
        })
    },
  }
}
</script>
<style>
.-nested-comp-open-btn {
  color: #fff !important;
  background-color: #337ab7 !important;
}
</style>
