<template>
  <!-- <div class="message-box dialog-mask" @click="$close(false)">
    <div class="dialog-content">
      <header>{{ title }}</header>
      <div class="dialog-body">
        <p>{{ content }}</p>
      </div>
      <footer>
        <el-button type="text" size="mini" @click="$close(true)">Si</el-button>
        <el-button type="text" size="mini" @click="$close(false)">No</el-button>
      </footer>
    </div>
  </div> -->
  <v-dialog v-model='dialog_confirm' persistent max-width="290">
    <v-card>
      <v-card-title class="headline">{{title}}</v-card-title>
      <v-card-text> {{ content}} </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="red darken-1" flat @click="$close(true) ">Si</v-btn>
        <v-btn color="green darken-1" flat @click="$close(false)">No</v-btn>
      </v-card-actions> 
    </v-card>
  </v-dialog>
</template>
<script>
console.log('carcando template hdp');
export default {
    data: () => ({
       dialog: false,
       timeout: 6000,
    }),
    computed:{
      dialog_confirm:{
        get(){
          return this.$store.state.template.dialog_confirm;
        },
        set(value)
        {
          this.$store.commit('template/updateConfirmDialog',value);
        }
      },
    }
}
</script>
