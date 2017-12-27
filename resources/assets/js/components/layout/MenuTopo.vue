<template>
  <div>
    <v-navigation-drawer app clipped fixed :mini-variant="mini" v-model="drawer">
      <MenuLista></MenuLista>
    </v-navigation-drawer>

    <v-toolbar app fixed clipped-left color="red darken-4" class="white--text" enable-resize-watcher>
      <v-toolbar-side-icon dark @click.stop="MenuTroca()"></v-toolbar-side-icon>
      <v-toolbar-title>SisPrev - Charqueadas</v-toolbar-title>
    </v-toolbar>
  </div>
</template>

<script>
  import MenuLista from './MenuLista'
  export default {

    components:{
      MenuLista
    },

    data: () => ({
      mini:null,
      drawer: null
    }),

    methods:{
      MenuTroca(){
        this.drawer = !this.drawer
        if(this.drawer==false){
          this.drawer = !this.drawer
          this.mini = !this.mini
        }
      }
    }
  }
</script>
