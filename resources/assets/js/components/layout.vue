<template>
  <v-app id="inspire" light>

    <MenuTopo></MenuTopo>

    <v-content>
      <v-container fluid fill-height>
        <v-layout justify-center align-center>

          <router-view></router-view>

        </v-layout>
      </v-container>
    </v-content>

    <Rodape></Rodape>

  </v-app>
</template>

<script>
  import Rodape from './layout/Rodape';
  import MenuTopo from './layout/MenuTopo';

  export default {

    components:{
      Rodape,
      MenuTopo
    }
  }
</script>
