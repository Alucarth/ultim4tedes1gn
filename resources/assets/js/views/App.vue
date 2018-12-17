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
    created(){
      console.log(this.getToken);

      console.log("setteando token");
      axios.defaults.headers.common['Authorization'] = 'Bearer '+this.getToken;

      // axios.interceptors.response.use(function (response) {
      //   // Do something with response data
      //     // console.log(response);
      //   return response;
      // }, function (error) {
      //   // Do something with response error
      //   console.log(error.response.status)
      //   if(error.response.status == 401)
      //   {
      //     this.$store.dispatch('auth/logout')
      //     .then(() => this.$router.push('/login'))
      //     .catch(err => console.log(err))
      //   }
      //   return Promise.reject(error);
      // });

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


    }
    }
</script>
