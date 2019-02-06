<template>
 <v-app id="inspire">
    
    <router-view name="toolbar"></router-view>
    <router-view name="nav"></router-view>
    <!--   -->
    <v-content>
      
       <v-container fluid fill-height>
          <v-layout fluid column fill-height>
                <router-view></router-view>         
          </v-layout>
          <!-- para los mensajes tipo alert-->
          <v-snackbar 
            v-model="show_message"
            :timeout="timeout"
            top='top'
            right='right'
            :color="color"
          >
            {{getMessage}}
            <v-btn
              color="white"
              flat
              @click="snackbar = false"
            >
              <v-icon>close</v-icon>
            </v-btn>
          </v-snackbar>
           <dialogs-wrapper transition-name="fade"></dialogs-wrapper>
          <!-- para los mensajes tipo confirm   -->
          <!-- <v-dialog v-model="dialog_confirm" persistent max-width="290">
            <v-card>
              <v-card-title class="headline">{{getConfirmTitle}}</v-card-title>
              <v-card-text> {{ getConfirmContent}} </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red darken-1" flat @click="setConfirmResponse(true) ">Si</v-btn>
                <v-btn color="green darken-1" flat @click="setConfirmResponse(false)">No</v-btn>
              </v-card-actions> 
            </v-card>
          </v-dialog> -->
        </v-container>
    </v-content>
  </v-app>

</template>
<script>
console.log("abriendo app vue");
    export default {
        data: () => ({
       dialog: false,
       timeout: 6000,
    }),
    computed:{
      // currentUser(){
      //   return this.$store.getters.currentUser;
      // }

      getToken(){
        return this.$store.state.auth.token;
      },
      show_message:{
          get(){
            return this.$store.state.template.show_message;
          },
          set(value){
            this.$store.commit('template/updateShowMessage',value);
          }
      },
      getMessage(){
        return this.$store.state.template.message;
      },
      color(){
        return this.$store.state.template.color;
      },
      // dialog_confirm:{
      //   get(){
      //     return this.$store.state.template.dialog_confirm;
      //   },
      //   set(value)
      //   {
      //     this.$store.commit('template/updateConfirmDialog',value);
      //   }
      // },
      // response:{
      //   get(){
      //     return this.$store.state.template.response;
      //   },
      //   set(value)
      //   {
      //     this.$store.commit('template/updateConfirmResponse',value);
      //   }
      // },
      // getConfirmTitle(){
      //   return this.$store.state.template.title;
      // },
      // getConfirmContent(){
      //   return this.$store.state.template.content;
      // }
      
    },
    created(){
      console.log(this.getToken);

      console.log("setteando token");
      axios.defaults.headers.common['Authorization'] = 'Bearer '+this.getToken;

      axios.interceptors.response.use(undefined,(err) => {
        return new Promise( (resolve, reject) => {
          console.log(err.response.status);
          if (err.response.status === 401) {
          // if you ever get an unauthorized, logout the user
            this.$store.dispatch('auth/logout')
            .then(() => this.$router.push('/login'))
            .catch(err => console.log(err))
          // you can also redirect to /login if needed !
          }
          throw err;
        });
      });


      },
      // methods:{
      //   // setConfirmResponse(value)
      //   // {
      //   //   this.response = value;
      //   //   this.dialog_confirm = false;
      //   // }
      // }
    }
</script>
