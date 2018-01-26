<template>
    <v-list dense>

      <v-list-tile to="/Home">
        <v-list-tile-action>
          <v-icon>home</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Home</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-divider v-if="this.$store.state.Usuario.permAdmin===true || this.$store.state.Usuario.permGRec===true ||
      this.$store.state.Usuario.permGRec===true || this.$store.state.Usuario.permGFin===true"></v-divider>

      <v-subheader inset v-if="this.$store.state.Usuario.permAdmin===true || this.$store.state.Usuario.permGRec===true ||
      this.$store.state.Usuario.permGRec===true || this.$store.state.Usuario.permGFin===true">Gerenciamento</v-subheader>

      <v-list-tile to="/Usuarios" v-if="this.$store.state.Usuario.permAdmin===true">
        <v-list-tile-action>
          <v-icon>group</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Usuários</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/Receitas" v-if="this.$store.state.Usuario.permGRec===true">
        <v-list-tile-action>
          <v-icon>attach_money</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Receitas</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/Despesas" v-if="this.$store.state.Usuario.permGRec===true">
        <v-list-tile-action>
          <v-icon>money_off</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Despesas</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/AplicacoesFinanceiras" v-if="this.$store.state.Usuario.permGFin===true">
        <v-list-tile-action>
          <v-icon>trending_up</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Aplicações Financeiras</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/Configuracoes" v-if="this.$store.state.Usuario.usuario!=='Beneficiário' && this.$store.state.Usuario.usuario!== ''">
        <v-list-tile-action>
          <v-icon>settings</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Configurações</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-divider></v-divider>
      <v-subheader inset>Relatórios</v-subheader>

      <v-list-tile to="/RelatorioReceitas">
        <v-list-tile-action>
          <v-icon>equalizer attach_money</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Receitas</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/RelatorioDespesas">
        <v-list-tile-action>
          <v-icon>equalizer money_off</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Despesas</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-tile to="/RelatorioAplicacoesFinanceiras">
        <v-list-tile-action>
          <v-icon>equalizer trending_up</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>Aplicações Financeiras</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

    </v-list>
</template>

<script>
</script>
