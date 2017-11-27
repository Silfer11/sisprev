<template>
  <div>
    <v-navigation-drawer app clipped persistent v-model="drawer" enable-resize-watcher>
      <menuEsquerdo></menuEsquerdo>
    </v-navigation-drawer>

    <v-toolbar app fixed clipped-left color="red darken-4" class="white--text">
      <v-toolbar-side-icon dark @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>SisPrev - Charqueadas</v-toolbar-title>
    </v-toolbar>
  </div>
</template>

<script>
  import menuEsquerdo from '../menuEsquerdo/MenuEsquerdo.vue'
  export default {

    components:{
      menuEsquerdo
    },

    data: () => ({
      drawer: true
    }),
  }
</script>
