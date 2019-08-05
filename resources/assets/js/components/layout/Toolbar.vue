<template>
      
    <v-toolbar
    dark
    app
    :color="$root.themeColor">
      <v-toolbar-title>
        <v-toolbar-side-icon @click="drawer=!drawer"></v-toolbar-side-icon>
      </v-toolbar-title>
      <!-- <v-text-field
        flat
        solo-inverted
        append-icon="search"
        label="Search">
      </v-text-field> -->
      <v-spacer></v-spacer>
      <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">
        <v-btn icon large flat slot="activator" :ripple="false">
          <v-avatar size="42px">
            <img src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairDreads01&accessoriesType=Round&hairColor=Black&facialHairType=Blank&clotheType=GraphicShirt&clotheColor=Black&graphicType=SkullOutline&eyeType=Default&eyebrowType=RaisedExcited&mouthType=Default&skinColor=Yellow"/>
          </v-avatar>
        </v-btn>
        <v-list>
          <v-list-tile
            v-for="(item,index) in items"
            :key="index"
            :to="!item.href ? { name: item.name } : null"
            :href="item.href"
            ripple="ripple"
            :disabled="item.disabled"
            :target="item.target"
            @click="menuOptions(item.title)">
            <v-list-tile-action v-if="item.icon">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content >
              <v-list-tile-title  >{{ item.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
     
     <!-- <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-width="100"
        offset-x
        v-if="user"
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
              <v-list-tile-title>{{user.username}}</v-list-tile-title>
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
    </v-menu> -->
    </v-toolbar>
</template>
<script>
console.log("toolbar XD");
import { mapState } from 'vuex';
export default {
    data: () => ({
      menu: false, 
       items: [
        {
          icon: 'account_circle',
          href: '#',
          title: 'Perfil',
        },
        {
          icon: 'settings',
          href: '#',
          title: 'Configuracion',
        },
        {
          icon: 'exit_to_app',
          href: '#',
          title: 'Salir',
        }
      ],
    }),
    computed:{
        drawer:{
          get(){
            return this.$store.state.template.drawer;
          },
          set(value){
            this.$store.commit('template/updateDrawer',value);
          }
        },

        ...mapState({
          user: state => state.auth.user,
        })
        // user(){
        //   console.log("IMPRIMIENDO STORE AUTH  USER ");
        //   // console.log(this.$store.getters(['auth/authStatus']) );
        //    return this.$store.state.auth.user;
        // }
       
    },
    methods:
    {
      menuOptions(title){
        if(title=="Salir"){
          this.logout();
        }  
      },
      logout()
      {
        this.$store.dispatch('auth/logout')
          .then(() => this.$router.push('/login'))
          .catch(err => console.log(err))
      },
      show_user(){
        console.log('open dialog ');
        this.menu=true;
      }
    }
   
}
</script>
