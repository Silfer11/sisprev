<template>
  <v-app id="inspire" light>

    <topoMenu></topoMenu>

    <main>
      <v-content>
        <v-container fluid fill-height>
          <v-layout justify-center align-center>
            <cadUsuario></cadUsuario>
            <listaUsuarios></listaUsuarios>
          </v-layout>
        </v-container>
      </v-content>
    </main>

    <rodape></rodape>

  </v-app>
</template>

<script>
  import rodape from './rodape/Rodape.vue';
  import topoMenu from './topoMenu/TopoMenu.vue';
  import cadUsuario from './cadUsuario/CadUsuario.vue';
  import listaUsuarios from './listaUsuarios/ListaUsuarios.vue';

  export default {

    components:{
      rodape,
      topoMenu,
      cadUsuario,
      listaUsuarios
    },

  }
</script>
