<template>
  <v-dialog v-model="dialog" persistent max-width="500px">
    <v-btn slot="activator"><v-icon>playlist_add</v-icon>Cadastrar Fundo</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Cadastrar Fundo</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form v-model="valid" ref="form" lazy-validation>
              <v-layout wrap>

                <v-flex xs12 sm6>
                  <v-text-field label="Nº da Conta Contábil" v-model="contContab" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-text-field label="Nome" v-model="nome" :counter="50" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-text-field label="Nº do CNPJ" v-model="cnpj" :counter="14" mask="##.###.###/####-##" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-text-field label="Segmento" v-model="segmento" :counter="50" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-text-field label="Índice de Referência" v-model="indReferencia" :counter="50" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-text-field label="Nº da Conta" v-model="conta" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-text-field label="Nível de Risco" v-model="nivelRisco" :counter="50" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-text-field label="Risco" v-model="risco" :counter="50" required></v-text-field>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-select
                    label="Banco"
                    required
                    v-model="idBanco"
                    :items="listarBancos"
                    item-text="nome"
                    item-value="id"
                  ></v-select>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-select
                    label="Enquadramento"
                    required
                    v-model="idEnq"
                    :items="listarEnquadramentos"
                    item-text="tipoAtivo"
                    item-value="id"
                  ></v-select>
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
//'contContab', 'nome', 'CNPJ', 'segmento', 'indReferencia', 'conta', 'nivelRisco', 'risco'
  export default {
    created (){
      this.$http.get('http://127.0.0.1:8000/api/fundos/bancos/listar').then((req) => this.listarBancos = req.data)
      this.$http.get('http://127.0.0.1:8000/api/fundos/enquadramentos/listar').then((req) => this.listarEnquadramentos = req.data)
    },
    data () {
      return {
        alert: false,
        valid: false,

        contContab: null,
        nome: null,
        cnpj: null,
        segmento: null,
        indReferencia: null,
        conta: null,
        nivelRisco: null,
        risco: null,
        idBanco: null,
        idEnq: null,

        listarBancos: [],
        listarEnquadramentos: [],

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
        this.contContab = null
        this.nome = null
        this.cnpj = null
        this.segmento = null
        this.indReferencia = null
        this.conta = null
        this.nivelRisco = null
        this.risco = null
        this.idBanco = null
        this.idEnq = null

        this.dialog = false
      },
      cadastrar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
            contContab: this.contContab,
            nome: this.nome,
            cnpj: this.cnpj,
            segmento: this.segmento,
            indReferencia: this.indReferencia,
            conta: this.conta,
            nivelRisco: this.nivelRisco,
            risco: this.risco,
            idBanco: this.idBanco,
            idEnq: this.idEnq,

            idRPPS: this.idRPPS
          }

          this.$http.post('http://127.0.0.1:8000/api/fundos/cadastrar', cadastro).then(
            (req)=> this.$http.post('http://127.0.0.1:8000/api/fundos/movimentacoes/cadastrar',  {id: req.data} ).then(this.$router.go())
          )

          this.contContab = null
          this.nome = null
          this.cnpj = null
          this.segmento = null
          this.indReferencia = null
          this.conta = null
          this.nivelRisco = null
          this.risco = null
          this.idBanco = null
          this.idEnq = null

          this.dialog = false
        }
      }
    }
  }
</script>
