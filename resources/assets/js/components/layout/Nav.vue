<template>
    <v-navigation-drawer
    v-model="drawer"
    fixed app>
    <v-toolbar flat dark :color="$root.themeColor" class="toolbar">
      <router-link to="/">
        <img src="images/logo2.png" width="40px"/>
      </router-link>
      <router-link to="/" class="text">
         Ultimate Design
      </router-link>
    </v-toolbar>

      <v-list dense>
        <v-list-tile to="/">
            <v-list-tile-action>
                <v-icon>home</v-icon>
            </v-list-tile-action>
            <v-list-tile-title >Inicio</v-list-tile-title>
        </v-list-tile>
        <v-list-group prepend-icon="group_work">
            <template v-slot:activator>
                <v-list-tile>
                    <v-list-tile-title>Modulo de Madera</v-list-tile-title>
                </v-list-tile>
            </template>
            <v-list-tile
              v-for="(lumber, i) in lumbers"
              :key="i"
              :to="lumber.link"
            >
              <v-list-tile-title v-text="lumber.text"></v-list-tile-title>
              <v-list-tile-action>
                <v-icon v-text="lumber.icon"></v-icon>
              </v-list-tile-action>
            </v-list-tile>
        </v-list-group>

        <v-list-group prepend-icon="account_circle">
            <template v-slot:activator>
                <v-list-tile>
                    <v-list-tile-title>Modulo RRHH</v-list-tile-title>
                </v-list-tile>
            </template>
            <v-list-tile
              v-for="(item, i) in rrhh"
              :key="i"
              :to="item.link"
            >
              <v-list-tile-title v-text="item.text"></v-list-tile-title>
              <v-list-tile-action>
                <v-icon v-text="item.icon"></v-icon>
              </v-list-tile-action>
            </v-list-tile>
        </v-list-group>

        <v-list-group prepend-icon="shopping_basket">
            <template v-slot:activator>
                <v-list-tile>
                    <v-list-tile-title>Modulo de Insumos</v-list-tile-title>
                </v-list-tile>
            </template>
            <v-list-tile
              v-for="(item, i) in items"
              :key="i"
              :to="item.link"
            >
              <v-list-tile-title v-text="item.text"></v-list-tile-title>
              <v-list-tile-action>
                <v-icon v-text="item.icon"></v-icon>
              </v-list-tile-action>
            </v-list-tile>
        </v-list-group>
        <v-list-group prepend-icon="assignment">
            <template v-slot:activator>
                <v-list-tile>
                    <v-list-tile-title>Modulo de Pedidos</v-list-tile-title>
                </v-list-tile>
            </template>
            <v-list-tile
              v-for="(order, i) in orders"
              :key="i"
              :to="order.link"
            >
              <v-list-tile-title v-text="order.text"></v-list-tile-title>
              <v-list-tile-action>
                <v-icon v-text="order.icon"></v-icon>
              </v-list-tile-action>
            </v-list-tile>
        </v-list-group>
        <v-list-group prepend-icon="home">
            <template v-slot:activator>
                <v-list-tile>
                    <v-list-tile-title>Módulo de Activos Fijos</v-list-tile-title>
                </v-list-tile>
            </template>
            <v-list-tile
              v-for="(asset, i) in assets"
              :key="i"
              :to="asset.link"
            >
              <v-list-tile-title v-text="asset.text"></v-list-tile-title>
              <v-list-tile-action>
                <v-icon v-text="asset.icon"></v-icon>
              </v-list-tile-action>
            </v-list-tile>
        </v-list-group>
        <!-- <template v-for="item in items">
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
        </template> -->
      </v-list>
    </v-navigation-drawer>
</template>
<script>
export default {
    data(){
        return {
            // drawer:null,
           items: [
                // { icon: 'dashboard', text: 'Inicio' , link: '/' },

                { icon: 'store', text: 'Insumos' , link: '/inventory' },
                { icon: 'money', text: 'Compra de Insumos', link: '/buyout' },
                // { icon: 'cloud_upload', text: 'Importar Compras', link: '/import_purchases' },


            ],
          orders: [
            { icon: 'widgets', text: 'Tipo de Productos', link: '/product_type' },
            { icon: 'widgets', text: 'Productos', link: '/product' },
            { icon: 'person', text: 'Clientes' , link: '/client' },
            // { icon: 'assignment', text: 'Tipos de Contrato', link: '/contract_type' },
            { icon: 'library_books', text: 'Contratos', link: '/contract' },
            { icon: 'building', text: 'Obras' , link: '/construction' },
            { icon: 'chrome_reader_mode', text: 'Ordenes', link: '/order' },
          ],
          lumbers:[
                { icon: 'store', text: 'Almacenes' , link: '/storage' },
                { icon: 'local_florist', text: 'Especies' , link: '/specie' },
                { icon: 'group', text: 'Proveedores' , link: '/provider' },
                { icon: 'shopping_cart', text: 'Compra de madera', link: '/purchase' },
                { icon: 'group_work', text: 'Madera' , link: '/lumber' },
                { icon: 'repeat', text: 'Transferencia de Madera', link: '/lumber_transaction' },
                { icon: 'view_agenda', text: 'Paquetes', link: '/package' },
                { icon: 'repeat', text: 'Transferencia de Paquetes', link: '/package/transfer' },
                { icon: 'cloud_upload', text: 'Importar Paquetes', link: '/import_package' },
                { icon: 'attach_money', text: 'Gastos', link: '/expenses' },
                { icon: 'shop_two', text: 'Tipos de Origen', link: '/origin_types' },
                { icon: 'widgets', text: 'Tipos de Oferta', link: '/offer_types' },

          ],
          rrhh:[
                { icon: 'people', text: 'Empleados', link: '/employee' },
                { icon: 'assignment_ind', text: 'Tipos de Empleado', link: '/employee_type' },
                { icon: 'work', text: 'Cargos', link: '/position' },
                { icon: 'markunread_mailbox', text: 'Tipo de Contrato', link: '/employee_contract_type' },
                { icon: 'collections_bookmark', text: 'Areas', link: '/area' },
                { icon: 'rowing', text: 'Tareas', link: '/task' },
          ],
          assets: [
            { icon: 'home', text: 'Activos fijos', link: '/asset' },
          ]
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
<style>
  .toolbar {
    font-weight: bold;
    font-size: 18px;
  }

  .toolbar .text {
    padding-left: 15px;
    color: white;
    text-decoration:none;
  }

  .item-title {
    font-size: 17px;
    font-weight: 500;
  }
  .item-sub-title {
    font-size: 15px;
    font-weight: 500;
  }

  .active {
    font-weight: bold;
  }
</style>
