<template>
  <v-dialog v-model="dialog" persistent max-width="500px">
    <v-btn @click="atualizarSelect" slot="activator"><v-icon>add</v-icon>Realizar Movimentação</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Realizar movimentação financeira</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form v-model="valid" ref="form" lazy-validation>
              <v-layout wrap>

                <v-flex>
                  <v-menu lazy :close-on-content-click="false" v-model="menu_data" transition="scale-transition" offset-y full-width :nudge-right="40" max-width="290px" min-width="290px">
                    <v-text-field slot="activator" label="Data da movimentação" v-model="date" prepend-icon="event" readonly></v-text-field>
                    <v-date-picker type="date" locale="pt-br" v-model="date" no-title scrollable actions>
                      <template slot-scope="{ save, cancel }">
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn flat color="primary" @click="cancel">Cancel</v-btn>
                          <v-btn flat color="primary" @click="TrocaData()">OK</v-btn>
                        </v-card-actions>
                      </template>
                    </v-date-picker>
                  </v-menu>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-select
                    label="Fundo de Aplicação"
                    required
                    v-model="idFunApl"
                    :items="listarFundos"
                    item-text="nome"
                    item-value="id"
                  ></v-select>
                </v-flex>

                <v-flex xs12 sm6>
                  <v-select
                    label="Fundo de Resgate"
                    required
                    v-model="idFunRes"
                    :items="listarFundos"
                    item-text="nome"
                    item-value="id"
                  ></v-select>
                </v-flex>

                <v-flex>
                  <v-text-field label="Valor da transferência" v-model="valor" placeholder="0.00" prefix="R$" required></v-text-field>
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
      this.atualizarMovimentacaoAplicacao()
      this.atualizarMovimentacaoResgate()
    },
    data () {
      return {
        alert: false,
        valid: false,

        idFunApl: null,
        idFunRes: null,
        valor: null,
        listarFundos: [],
        movimentacaoAplicacao: [],
        movimentacaoResgate: [],
        idRPPS: 1,

        menu: false,
        modal: false,
        dialog: false,

        menu_data: false,
        date: new Date().getFullYear() + "-" + (new Date().getMonth()+1) + "-" + (new Date().getDate())
      }
    },
    methods: {
      TrocaData(){
        this.menu_data = false
      },
      fechar () {
        this.idFunApl = null
        this.idFunRes = null
        this.Valor = null
        this.dialog = false
      },
      cadastrar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
            idFunApl: this.idFunApl,
            idFunRes: this.idFunRes,
            valor: this.valor,
            date: this.date,
            idRPPS: this.idRPPS
          }
          this.$http.post('/api/fundos/movimentacoes/movimentar', cadastro).then(function(){
            this.$emit('Recarregar')
            this.fechar()
          })
        }
      },
      atualizarSelect(){
        this.$http.get('/api/fundos/listar').then((req) => this.listarFundos = req.data)
      },
      atualizarMovimentacaoAplicacao(){
        var fundoAplicacao = {
          id : this.idFunApl,
          data : this.date
        }

        this.$http.get('/api/fundos/movimentacoes/buscar', fundoAplicacao ).then((req) => this.movimentacaoAplicacao = req.data)
      },
      atualizarMovimentacaoResgate(){
        var fundoAplicacao = {
          id : this.idFunRes,
          data : this.date
        }
        this.$http.get('/api/fundos/movimentacoes/buscar', fundoAplicacao ).then((req) => this.movimentacaoResgate = req.data)
      }
    }
  }
</script>
