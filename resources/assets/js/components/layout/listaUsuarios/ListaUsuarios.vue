<template>
  <v-card>
    <v-card-title>
      Usuarios Cadastrados:
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
        <tr @click="props.expanded = !props.expanded">
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
        <td class="text-xs-right"><v-icon @click="edit(props.item.id)">edit</v-icon></td>
        <td class="text-xs-right"><v-icon @click="exclude(props.item.id)">delete</v-icon></td>
      </tr>
      </template>

      <template slot="pageText" scope="{ pageStart, pageStop }">
        From {{ pageStart }} to {{ pageStop }}
      </template>

      <template slot="expand" scope="props">
      <v-card flat>
        <v-card-text>Perm. administrador: {{ props.item.permAdmin }}; </v-card-text>
        <v-card-text>Perm. gestao de receitas: {{ props.item.permLogs }}; </v-card-text>
        <v-card-text>Perm. gestor financeiro: {{ props.item.permGFin }}; </v-card-text>
        <v-card-text>Perm. Logs: {{ props.item.permLogs }}</v-card-text>
      </v-card>
    </template>
    </v-data-table>
  </v-card>
</template>

<script>
  export default {
    mounted (){
      this.$http.get('/api/usuarios/listar').then((req) => this.items = req.data)
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
          { text: 'E-Mail', value: 'email' }
        ],
        items: []
      }
    },
    methods: {
      exclude(id){
        this.$http.post('/api/usuarios/excluir/' + id)
        window.location.reload()
      },
      edit(id){
        window.location.href='http://127.0.0.1:8000/AtualizarUsuarios/' + id
      }
    }
  }
</script>
