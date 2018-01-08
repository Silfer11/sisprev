<template>
  <div>
    <MenuTopo></MenuTopo>

    <v-content>
      <v-container fluid fill-height>
        <v-layout justify-center align-center>

          <router-view></router-view>

        </v-layout>
      </v-container>
    </v-content>

    <Rodape></Rodape>
  </div>
</template>

<script>
  import Rodape from './Layout/Rodape';
  import MenuTopo from './Layout/MenuTopo';

  export default {
    data(){
      return {teste: "1"}
    },

    components:{
      Rodape,
      MenuTopo
    }
  }
</script>
