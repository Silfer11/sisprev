<template>
  <v-app id="inspire" light>

    <topoMenu></topoMenu>

    <main>
      <v-content>
        <v-container fluid fill-height>
          <v-layout justify-center align-center>
            home
          </v-layout>
        </v-container>
      </v-content>
    </main>

    <rodape></rodape>

  </v-app>
</template>

<script>
  import rodape from '../rodape/Rodape.vue';
  import topoMenu from '../topoMenu/TopoMenu.vue';

  export default {

    components:{
      rodape,
      topoMenu
    },

  }
</script>
