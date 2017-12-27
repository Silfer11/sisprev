<template>
  <v-dialog v-model="dialog" persistent max-width="500px">
    <v-btn slot="activator"><v-icon>playlist_add</v-icon>Cadastrar Receita</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Cadastrar Receita</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form v-model="valid" ref="form" lazy-validation>
              <v-layout wrap>
                <v-flex xs12 sm8>
                  <v-select
                    label="Descrição"
                    required
                    v-model="idDescricao"
                    :items="listarDescricoes"
                    item-text="descricao"
                    item-value="id"
                  ></v-select>
                </v-flex>

                <v-flex xs12 sm6 md4>
                  <v-select
                    label="Origem"
                    v-model="origem"
                    required
                    :items="['Municipio', 'Câmara', 'FAPS', 'INSS']"
                  ></v-select>
                </v-flex>

                <v-flex xs12 sm6 md4>
                  <v-menu lazy :close-on-content-click="false" v-model="menu" transition="scale-transition" offset-y full-width :nudge-right="40" max-width="290px" min-width="290px">
                    <v-text-field slot="activator" label="Data*" v-model="data" prepend-icon="event" readonly></v-text-field>
                    <v-date-picker type="date" v-model="data" no-title scrollable actions>
                      <template slot-scope="{ save, cancel }">
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn flat color="primary" @click="cancel">Cancel</v-btn>
                          <v-btn flat color="primary" @click="save">OK</v-btn>
                        </v-card-actions>
                      </template>
                    </v-date-picker>
                  </v-menu>
                </v-flex>

                <v-flex xs12 sm6 md4>
                  <v-text-field label="Valor Devido" v-model="valDevido" prefix="R$" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6 md2>
                  <v-text-field label="Aliquota" v-model="aliq" suffix="%"></v-text-field>
                </v-flex>

                <v-flex xs12 sm6 md2>
                  <v-text-field label="Parcela" v-model="parcela" suffix="x"></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field label="Observações" v-model="observacoes" multi-line></v-text-field>
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
    created (){
      this.$http.get('http://127.0.0.1:8000/api/receitas/descricoes/listar').then((req) => this.listarDescricoes = req.data)
    },
    data () {
      return {
        alert: false,
        valid: false,
        idDescricao: null,
        origem: null,
        aliq: null,
        parcela: null,
        valDevido: null,
        data: null,
        observacoes: null,

        listarDescricoes: [],

        idRPPS: 1,
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
        this.idDescricao = null
        this.origem = null
        this.aliq = null
        this.parcela = null
        this.valDevido = null
        this.data = null
        this.observacoes = null

        this.dialog = false
      },
      cadastrar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
            idDescricao: this.idDescricao,
            origem: this.origem,
            aliq: this.aliq,
            parcela: this.parcela,
            valDevido: this.valDevido,
            data: this.data,
            observacoes: this.observacoes,

            idRPPS: this.idRPPS
          }
          this.$http.post('http://127.0.0.1:8000/api/receitas/cadastrar', cadastro)

          this.idDescricao = null
          this.origem = null
          this.aliq = null
          this.parcela = null
          this.valDevido = null
          this.data = null
          this.observacoes = null

          this.dialog = false
          this.$router.go()
        }
      }
    }
  }
</script>
