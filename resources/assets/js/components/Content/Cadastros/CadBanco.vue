<template>
  <v-dialog v-model="dialog" persistent max-width="500px">
      <v-btn slot="activator"><v-icon>add</v-icon>Cadastrar Banco</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Cadastrar Banco</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form v-model="valid" ref="form" lazy-validation>
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field label="Nome do Banco" v-model="nome" required></v-text-field>
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
        alert: false,
        valid: false,

        nome: null,

        menu: false,
        modal: false,
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
      fechar () {
        this.nome = null
        this.dialog = false
      },
      cadastrar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
            nome: this.nome
          }
          this.$http.post('/api/fundos/bancos/cadastrar', cadastro).then(function(){
            this.$emit('Recarregar')
            this.fechar()
          })
        }
      }
    }
  }
</script>
