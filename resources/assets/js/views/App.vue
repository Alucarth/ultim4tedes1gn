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
        </v-container>
    </v-content>
  </v-app>

</template>
<script>
console.log("abriendo app vue");
    export default {
        data: () => ({
      dialog: false,
    }),
    computed:{
      // currentUser(){
      //   return this.$store.getters.currentUser;
      // }
      getToken(){
        return this.$store.state.auth.token;
      }
    },
    mounted(){
      console.log(this.getToken);

      console.log("setteando token");
      axios.defaults.headers.common['Authorization'] = 'Bearer '+this.getToken;
    }
    }
</script>
