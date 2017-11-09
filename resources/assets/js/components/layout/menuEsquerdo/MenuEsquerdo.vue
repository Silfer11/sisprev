<template>
    <v-list dense>

      <v-list-tile @click="redirecionar('home')">
        <v-list-tile-action>
          <v-icon>home</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Home</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile @click="redirecionar('CadastrarUsuarios')">
        <v-list-tile-action>
          <v-icon>settings</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Cadastrar Usuarios</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile @click="redirecionar('Usuarios')">
        <v-list-tile-action>
          <v-icon>settings</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Usuarios</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile @click="redirecionar('Receitas')">
        <v-list-tile-action>
          <v-icon>dashboard</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Receitas</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-tile @click="redirecionar('Configuracoes')">
        <v-list-tile-action>
          <v-icon>settings</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Configuracoes</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

    </v-list>
</template>

<script>
  export default {
    methods: {
      redirecionar: function (link) {
        window.location.href='http://127.0.0.1:8000/' + link
      }
    }
  }
</script>
