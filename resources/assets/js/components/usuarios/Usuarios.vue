<template>
  <v-app id="inspire" light>

    <topoMenu></topoMenu>

    <main>
      <v-content>
        <v-container fluid fill-height>
          <v-layout justify-center align-center>
            <listaUsuarios></listaUsuarios>
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
  import listaUsuarios from '../layout/listaUsuarios/ListaUsuarios.vue';

  export default {

    components:{
      rodape,
      topoMenu,
      listaUsuarios
    },

  }
</script>
