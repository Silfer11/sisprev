<template>
  <v-card>
    <v-card-title>
      Nutrition
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        label="Search"
        single-line
        hide-details
        v-model="search"
      ></v-text-field>
    </v-card-title>
    <v-data-table
        v-bind:headers="headers"
        v-bind:items="items"
        v-bind:search="search"
      >
      <template slot="items" scope="props">
        <td>
          <v-edit-dialog
            lazy
          > {{ props.item.usuario }}
            <v-text-field
              slot="input"
              label="Edit"
              v-model="props.item.usuario"
              single-line
              counter
              :rules="[max25chars]"
            ></v-text-field>
          </v-edit-dialog>
        </td>
        <td class="text-xs-right">{{ props.item.senha }}</td>
        <td class="text-xs-right">{{ props.item.nome }}</td>
        <td class="text-xs-right">{{ props.item.cpf }}</td>
        <td class="text-xs-right">{{ props.item.email }}</td>
        <td class="text-xs-right">{{ props.item.permAdmin }}</td>
        <td class="text-xs-right">{{ props.item.permGRec }}</td>
        <td class="text-xs-right">{{ props.item.permGFin }}</td>
        <td class="text-xs-right">{{ props.item.permLogs }}</td>
      </template>
      <template slot="pageText" scope="{ pageStart, pageStop }">
        From {{ pageStart }} to {{ pageStop }}
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    props: ['usuarios'],
    mounted (){
      this.$http.get('/api/Usuarios').then((req) => this.usuarios = req.data)
      //this.$http.get('./api/teste').then((req) => this.usuarios = req.data)
    },
    data () {
      return {
        max25chars: (v) => v.length <= 25 || 'Input too long!',
        tmp: '',
        search: '',
        pagination: {},
        headers: [
          { text: 'Usuario', align: 'left', value: 'usuario'},
          { text: 'Senha', value: 'senha' },
          { text: 'Nome', value: 'nome' },
          { text: 'CPF', value: 'cpf' },
          { text: 'E-Mail', value: 'email' },
          { text: 'permAdmin', value: 'permAdmin' },
          { text: 'permGRec', value: 'permGRec' },
          { text: 'permGFin', value: 'permGFin' },
          { text: 'permLogs', value: 'permLogs' }
        ],
        items: [{usuario:'teste',senha:'teste',nome:'teste',cpf:'teste',email:'teste',permAdmin:'teste',permGRec:'teste',permGFin:'teste',permLogs:'teste'}]
      }
    }
  }
</script>
