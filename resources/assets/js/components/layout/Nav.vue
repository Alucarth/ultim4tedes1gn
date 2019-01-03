<template>
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
</template>
<script>
export default {
    data(){
        return {
            // drawer:null,
           items: [
                { icon: 'dashboard', text: 'Inicio' , link: '/' },
                { icon: 'store', text: 'Almacenes' , link: '/storage' },
                { icon: 'group_work', text: 'Madera' , link: '/lumber' },
                { icon: 'local_florist', text: 'Especies' , link: '/specie' },
                { icon: 'group', text: 'Proveedores' , link: '/provider' },  
                { icon: 'money', text: 'Compra de madera', link: '/purchase' },
                { icon: 'repeat', text: 'Transferencia de Madera', link: '/lumber_transaction' },
                { icon: 'view_agenda', text: 'Paquetes', link: '/package' },
                { icon: 'cloud_upload', text: 'Importar Compras', link: '/import_purchases' },
                { icon: 'cloud_upload', text: 'Importar Paquetes', link: '/import_package' },
                { icon: 'work', text: 'Empleados', link: '/employee' },
            ],
        }
    },
    computed:{
        drawer:{
          get(){
            return this.$store.state.template.drawer;
          },
          set(value){
            this.$store.commit('template/updateDrawer',value);
          }
        }
    }
}
</script>
