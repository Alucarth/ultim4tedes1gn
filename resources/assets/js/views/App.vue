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
    // export default {
    //     data: () => ({
    //   dialog: false,
    //   drawer: null,
    //   items: [
    //     { icon: 'dashboard', text: 'Inicio' , link: '/' },
    //     { icon: 'store', text: 'Almacenes' , link: '/storage' },
    //     { icon: 'group_work', text: 'Madera' , link: '/lumber' },
    //     { icon: 'local_florist', text: 'Especies' , link: '/specie' },
    //     { icon: 'group', text: 'Proveedores' , link: '/provider' },  
    //     { icon: 'money', text: 'Compra de madera', link: '/purchase' },
    //     { icon: 'view_agenda', text: 'Paquetes', link: '/package' },
    //     { icon: 'work', text: 'Empleados', link: '/employee' },
    //   ],
    //   menu: false, 
    //   message: false,
    // }),
    // props: {
    //   source: String
    // },
    // methods:{
    //   logout(){
    //     this.$store.commit('logout');
    //     this.$router.push('/login');
    //   }
    // },
    // computed:{
    //   currentUser(){
    //     return this.$store.getters.currentUser;
    //   }
    // }
    // }
</script>
