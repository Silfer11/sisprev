<template>
  <v-app id="inspire" light>

    <topoMenu></topoMenu>

    <main>
      <v-content>
        <v-container fluid fill-height>
          <v-layout justify-center align-center>
            <receitas></receitas>
          </v-layout>
        </v-container>
      </v-content>
    </main>

    <rodape></rodape>

  </v-app>
</template>

<script>
  import rodape from '../layout/rodape/Rodape.vue';
  import topoMenu from '../layout/topoMenu/TopoMenu.vue';
  import receitas from '../layout/receitas/Receitas.vue';

  export default {

    components:{
      rodape,
      topoMenu,
      receitas
    },

  }
</script>
