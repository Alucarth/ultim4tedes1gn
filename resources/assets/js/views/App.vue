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
          <!-- <notivuecation /> -->
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
          <!-- para los mensajes tipo confirm   -->
          <v-dialog v-model="notification" persistent max-width="290">
            <v-card >
              <v-card-title class="headline">{{title}}</v-card-title>
              <v-card-text> {{ message}} </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn v-for="(button, index) in buttons" @click="resolve(button.value)" :key="index"  flat>{{button.label}}</v-btn>
              </v-card-actions> 
            </v-card>
          </v-dialog>
        </v-container>
    </v-content>
  </v-app>

</template>
<script>

import { componentMixin } from 'notivuecation';

console.log("abriendo app vue");
    export default {
       mixins: [componentMixin],
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
      dconfirm:{
        get(){
          return this.$store.state.dconfirm.dialog;
        },
        set(value)
        {
          this.$store.commit('template/updateConfirmDialog',value);
        }
      },
      response:{
        get(){
          return this.$store.state.template.response;
        },
        set(value)
        {
          this.$store.commit('dconfirm/updateConfirmResponse',value);
        }
      },
      getConfirmTitle(){
        return this.$store.state.dconfirm.title;
      },
      getConfirmContent(){
        return this.$store.state.dconfirm.content;
      }
      
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
      methods:{
        setConfirmResponse(value)
        {
          this.response = value;
          this.dconfirm = false;
        }
      }
    }
</script>
