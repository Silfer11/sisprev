<template>
  <v-tabs fixed centered>
    <v-tabs-bar class="grey">
        <CadUsuario v-on:Recarregar="ListarUsuarios"></CadUsuario>
    </v-tabs-bar>
    <v-card>
      <v-card-title>
        Usuários cadastrados:
        <v-spacer></v-spacer>

        <v-text-field append-icon="search" label="Pesquisar" single-line hide-details v-model="search"></v-text-field>
      </v-card-title>

      <v-data-table
          v-bind:headers="headers"
          v-bind:items="items"
          v-bind:search="search"
        >
        <template slot="items" scope="props">
          <tr @click="props.expanded = !props.expanded">
            <td class="text-xs-center">{{ props.item.usuario }}</td>
            <td class="text-xs-center">{{ props.item.nome }}</td>
            <td class="text-xs-center">{{ props.item.cpf }}</td>
            <td class="text-xs-center">{{ props.item.email }}</td>
            <td class="text-xs-center"><v-btn icon flat @click="edit(props.item)"><v-icon>edit</v-icon></v-btn></td>
            <td class="text-xs-center"><v-btn icon flat @click="exclude(props.item.id)"><v-icon>delete</v-icon></v-btn></td>
          </tr>
        </template>

        <template slot="pageText" scope="{ pageStart, pageStop }">
          From {{ pageStart }} to {{ pageStop }}
        </template>

        <template slot="expand" scope="props">
          <v-card flat>
            <v-card-tittle>Permissões</v-card-tittle>
            <v-card-text v-if="props.item.permAdmin">Administrador</v-card-text>
            <v-card-text v-if="props.item.permGRec">Gestao de Receitas</v-card-text>
            <v-card-text v-if="props.item.permGFin">Gestor Financeiro</v-card-text>
            <v-card-text v-if="props.item.permLogs">Logs</v-card-text>
          </v-card>
        </template>
      </v-data-table>
    </v-card>
    <span>*Clique no usuario desejado para visualizar suas permissões</span>

    <v-dialog v-model="dialog" persistent max-width="500px">
        <v-card>
          <v-card-title>
            <span class="headline">Cadastrar Usuario</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-form v-model="valid" ref="form" lazy-validation>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field label="Usuario" v-model="usuario" :rules="textRules" :counter="50" required></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field label="Senha" v-model="senha" :rules="textRules" :counter="50" required></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                    <v-text-field label="Nome" v-model="nome" :rules="textRules" :counter="50" required ></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6>
                    <v-text-field label="CPF" v-model="cpf" :rules="textRules" mask="###.###.###-##" :counter="11" required></v-text-field>
                  </v-flex>

                  <v-flex xs12 sm6>
                    <v-text-field label="E-mail" v-model="email" :rules="emailRules" required></v-text-field>
                  </v-flex>

                  <v-flex xs12>
                    <small>Permissões:</small>
                  </v-flex>

                  <v-flex xs12 sm6>
                    <v-checkbox label="Administração" v-model="permAdmin"></v-checkbox>
                  </v-flex>

                  <v-flex xs12 sm6>
                    <v-checkbox label="Gestor de Recursos" v-model="permGRec"></v-checkbox>
                  </v-flex>

                  <v-flex xs12 sm6>
                    <v-checkbox label="Gestor de Finanças" v-model="permGFin"></v-checkbox>
                  </v-flex>

                  <v-flex xs12 sm6>
                    <v-checkbox label="Visualização de Logs" v-model="permLogs"></v-checkbox>
                  </v-flex>
                </v-layout>
              </v-form>
            </v-container>
            <small>*Indica que o campo é obrigatório</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="fechar">Fechar</v-btn>
            <v-btn color="blue darken-1" flat @click="salvar">Salvar</v-btn>
          </v-card-actions>
        </v-card>
    </v-dialog>
  </v-tabs>
</template>
<script>
  import CadUsuario from "./Cadastros/CadUsuario";

  export default {
    components:{
      CadUsuario
    },
    mounted (){
      this.ListarUsuarios()
    },
    data () {
      return {
        valid: false,
        usuario: '',
        senha: '',
        nome: '',
        cpf: '',
        email: '',

        permAdmin: false,
        permGRec: false,
        permGFin: false,
        permLogs: false,

        idRPPS: 1,

        dialog: false,

        max25chars: (v) => v.length <= 25 || 'Input too long!',
        tmp: '',
        search: '',
        pagination: {},
        headers: [
          { text: 'Usuário', value: 'usuario', align: 'center' },
          { text: 'Nome', value: 'nome', align: 'center' },
          { text: 'CPF', value: 'cpf', align: 'center' },
          { text: 'E-Mail', value: 'email', align: 'center' },
          { text: 'Alterar', value: 'editar', align: 'center' },
          { text: 'Excluir', value: 'deletar', align: 'center' }
        ],
        items: [],
        textRules: [
          (v) => !!v || 'O campo deve ser preenchido',
          (v) => v.length <= 40 || 'O campo pode ter no maximo 40 caracteres'
        ],
        emailRules: [
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail invalido',
          (v) => !!v || 'Por favor, preencha o campo E-mail'
        ]
      }
    },
    methods: {
      exclude(id){
        this.$http.post('/api/usuarios/excluir/' + id)
        this.ListarUsuarios()
      },
      edit(item){
        this.id = item.id

        this.usuario = item.usuario
        this.senha = item.senha
        this.nome = item.nome
        this.cpf = item.cpf
        this.email = item.email

        this.permAdmin = item.permAdmin
        this.permGRec = item.permGRec
        this.permGFin = item.permGFin
        this.permLogs = item.permLogs

        this.dialog = true
      },
      fechar () {
        this.dialog = false
      },
      salvar () {
        if (this.$refs.form.validate()) {
          var cadastro = {

            id: this.id,
            usuario: this.usuario,
            senha: this.senha,
            nome: this.nome,
            cpf: this.cpf,
            email: this.email,

            permAdmin: this.permAdmin,
            permGRec: this.permGRec,
            permGFin: this.permGFin,
            permLogs: this.permLogs,

            idRPPS: this.idRPPS
          }
          this.$http.post('/api/usuarios/atualizar', cadastro)

          this.dialog = false
          this.ListarUsuarios()
        }
      },
      ListarUsuarios(){
        this.$http.get('/api/usuarios/listar').then((req) => this.items = req.data)
      }
    },
    events: {
      Recarregar: function() {
        ListarUsuarios()
      }
    }
  }
</script>
