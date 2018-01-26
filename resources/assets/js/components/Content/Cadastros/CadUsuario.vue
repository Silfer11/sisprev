<template>
  <v-dialog v-model="dialog" persistent max-width="500px">
    <v-btn slot="activator"><v-icon>person_add</v-icon>Cadastrar Usuario</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Cadastrar Usuário</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form v-model="valid" ref="form" lazy-validation>
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field label="Usuário" v-model="usuario" :rules="textRules" :counter="50" required></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field label="Senha" v-model="senha" :rules="textRules" :counter="50" type="password" required></v-text-field>
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
          <v-btn color="blue darken-1" flat @click="cadastrar">Cadastrar</v-btn>
        </v-card-actions>
      </v-card>
  </v-dialog>
</template>

<script>
  export default {
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
      fechar(){
        this.usuario = ''
        this.senha = ''
        this.nome = ''
        this.cpf = ''
        this.email = ''

        this.permAdmin = false
        this.permGRec = false
        this.permGFin = false
        this.permLogs = false


        this.dialog = false
      },
      cadastrar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
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

          this.$http.post('/api/usuarios/cadastrar', cadastro).then(function(){
            this.$emit('Recarregar')
            this.fechar()
          })
        }
      }
    }
  }
</script>
