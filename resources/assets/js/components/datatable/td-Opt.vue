<template>
  <div class="btn-group btn-group-sm">
    <b-alert
        :value="alert"
        :type="alert_type"
        dismissible
        transition="scale-transition"
      >
        {{alert_msg}}
    </b-alert>
    <button class="btn btn-default" title="Display row"
      :class="{ '-nested-comp-open-btn': isDisplayRowVisible }"
      @click="toggleNestedComp('DisplayRow')">
      <i class="fa fa-list-ul"></i>

    </button>
    

    <button class="btn btn-default" data-toggle="tooltip"  data-placement="top" title="Edit"
    @click="makeAction(row)"
    >
      <i class="fa fa-eye"></i>
    </button>
  <!-- <b-modal ref="myModalRef" hide-footer title="Edit">
      <div class="d-block text-center">
        <h3>RECORDS</h3>
      </div>      
      <b-form-group
        id="uuid"        
        label="UUID"
        label-for="input1"        
      >
      <b-form-input type="text"
        placeholder="UUID" v-model="row.uuid"></b-form-input>
      </b-form-group>

      <b-form-group
        id="name"        
        label="Name"
        label-for="input2"                
      >
      <b-form-input type="text"
         placeholder="name"
         v-model="row.name"></b-form-input>
      </b-form-group>

      <b-form-group
        id="description"        
        label="Description"
        label-for="input3"                
      >
      <b-form-input type="text"
        placeholder="Description"
        v-model="row.description"></b-form-input>
      </b-form-group>

      <b-form-group
        id="code"        
        label="Code"
        label-for="input4"        
      >
      <b-form-input type="text"
        placeholder="Code"
        v-model="row.code"></b-form-input>
      </b-form-group>

      <b-button class="mt-3" variant="outline-success" block @click="save(row)">Save</b-button>
      <b-button class="mt-3" variant="outline-danger" block @click="closeModal">Close</b-button>
    </b-modal>   -->
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
    }
    
  },
  // data: {
    
  // },
  mounted () {    
    this.fillStatuses();
    console.log("asdfasdf");
    console.log(this.statuses[1]);
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
