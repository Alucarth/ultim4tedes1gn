<template>

 <v-app id="inspire">
    <v-navigation-drawer
      fixed
      :clipped="$vuetify.breakpoint.mdAndUp"
      app
      v-model="drawer"
    >
      <v-list dense>
        <template v-for="item in items">
          <v-layout
            row
            v-if="item.heading"
            align-center
            :key="item.heading"
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-flex>
          </v-layout>
          <v-list-group
            v-else-if="item.children"
            v-model="item.model"
            :key="item.text"
            :to="item.link"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <v-list-tile slot="activator">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ item.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in item.children"
              :key="i"
           
            >
              <v-list-tile-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ child.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
          <v-list-tile v-else  :key="item.text"  :to="item.link">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar
      color="blue darken-2"
      dark
      app
      :clipped-left="$vuetify.breakpoint.mdAndUp"
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down">Ultimate Design</span>
      </v-toolbar-title>

      <v-spacer></v-spacer>
    

     <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-width="100"
        offset-x
        v-if="currentUser"
      >
        <v-btn 
          slot="activator"
          icon
          large
          
        >
        <v-icon>person</v-icon>
      </v-btn>

      <v-card   light>
        <v-list>
          <v-list-tile avatar>
            <v-list-tile-avatar>
              <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John">
            </v-list-tile-avatar>

            <v-list-tile-content >
              <v-list-tile-title>{{currentUser.name}}</v-list-tile-title>
              <v-list-tile-sub-title>Administrador</v-list-tile-sub-title>
              
            </v-list-tile-content>

          </v-list-tile>
        </v-list>

       


        <v-card-actions>
          <v-spacer></v-spacer>
          <v-tooltip bottom>
            <v-btn
              slot="activator"
              color="primary"
              dark
              flat @click="menu = false"
            >
             <v-icon>reply</v-icon> 
            </v-btn>
            <span>Regresar</span>
          </v-tooltip>
           <v-tooltip bottom>
            <v-btn
              slot="activator"
              color="primary"
              dark
              flat @click="logout"
            >
             <v-icon>exit_to_app</v-icon> 
            </v-btn>
            <span>Cerrar Sesion</span>
          </v-tooltip>
        </v-card-actions>
      </v-card>
    </v-menu>
    <v-btn v-else  flat color="white" to='/login' > Inicar Sesion </v-btn>

    </v-toolbar>
    <v-content>
      <!-- <lumber-index></lumber-index> -->
       <v-container fluid fill-height>
          <v-layout fluid column fill-height>
            <router-view></router-view>            
          </v-layout>
        </v-container>
   

    </v-content>
  </v-app>

</template>
<script>
    export default {
        data: () => ({
      dialog: false,
      drawer: null,
      items: [
        { icon: 'dashboard', text: 'Inicio' , link: '/' },
        { icon: 'group', text: 'Almacenes' , link: '/storage' },
        { icon: 'group', text: 'Madera' , link: '/lumber' },
        { icon: 'group', text: 'Especies' , link: '/specie' },
        { icon: 'group', text: 'Proveedores' , link: '/provider' },  
        { icon: 'money', text: 'Compra de madera', link: '/purchase' },
        { icon: 'view_agenda', text: 'Paquetes', link: '/package' },

      ],
      menu: false, 
      message: false,
    }),
    props: {
      source: String
    },
    methods:{
      logout(){
        this.$store.commit('logout');
        this.$router.push('/login');
      }
    },
    computed:{
      currentUser(){
        return this.$store.getters.currentUser;
      }
    }
    }
</script>
