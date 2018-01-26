<template>
  <v-tabs fixed centered>
    <v-tabs-bar class="grey">
        <CadFundo v-on:Recarregar="ListarMovimentacoes"></CadFundo>
        <CadBanco v-on:Recarregar="ListarMovimentacoes"></CadBanco>
        <CadEnquadramento v-on:ListarMovimentacoes="ListarMovimentacoes"></CadEnquadramento>
        <CadMov v-on:Recarregar="ListarMovimentacoes"></CadMov>
    </v-tabs-bar>
    <v-card>
      <v-card-title>
        Movimentações Inseridas:

        <v-spacer></v-spacer>

          <v-menu lazy :close-on-content-click="false" v-model="menu_data" transition="scale-transition" offset-y full-width :nudge-right="40" max-width="290px" min-width="290px">
            <v-text-field slot="activator" label="Pesquisar por data" v-model="date" prepend-icon="event" readonly></v-text-field>
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
            <td class="text-xs-center">{{ props.item.fundo.banco.nome }}</td>
            <td class="text-xs-center">{{ props.item.fundo.nome }}</td>
            <td class="text-xs-center">{{ props.item.fundo.risco }}</td>

            <td class="text-xs-center">
              <v-btn>
                <v-edit-dialog lazy>

                  R$ {{ props.item.inicial }}

                  <v-text-field
                    slot="input"
                    label="Saldo Inicial"
                    prefix="R$"
                    v-model="props.item.inicial"
                    single-line
                    @change="EditaMovimentacao(props.item)"
                  ></v-text-field>
                </v-edit-dialog>
              </v-btn>
            </td>

            <td class="text-xs-center">R$ {{ props.item.resgate }}</td>

            <td class="text-xs-center">R$ {{ props.item.aplicacao }}</td>

            <td class="text-xs-center">
              <v-btn>
                <v-edit-dialog lazy>

                  R$ {{ props.item.final }}

                  <v-text-field
                    slot="input"
                    label="Saldo Final"
                    prefix="R$"
                    v-model="props.item.final"
                    single-line
                    @change="EditaMovimentacao(props.item)"
                  ></v-text-field>
                </v-edit-dialog>
              </v-btn>
            </td>

            <td class="text-xs-center">

              <span v-if="props.item.final != 0">R$ {{ props.item.final }}</span>
              <span v-else>R$ {{ CalculaSaldoAtual(props.item) }}</span>

            </td>

          </tr>
        </template>

        <template slot="pageText" scope="{ pageStart, pageStop }">
          From {{ pageStart }} to {{ pageStop }}
        </template>
      </v-data-table>
    </v-card>
    <span>*Clique valor para atualiza-lo</span>
  </v-tabs>
</template>
<script>
import CadFundo from "./Cadastros/CadFundo";
import CadBanco from "./Cadastros/CadBanco";
import CadEnquadramento from "./Cadastros/CadEnquadramento";
import CadMov from "./Cadastros/CadMov";

  export default {
    components:{
      CadFundo,
      CadBanco,
      CadEnquadramento,
      CadMov
    },

    created (){
      this.ListarMovimentacoes()
    },

    data () {
      return{
        max25chars: (v) => v.length <= 25 || 'Input too long!',
        tmp: '',
        search: '',
        pagination: {},
        headers: [
          { text: 'Banco', value: 'banco', align: 'center' },
          { text: 'Fundo', value: 'nome', align: 'center' },
          { text: 'Grau de Risco', value: 'risco', align: 'center' },
          { text: 'Saldo Inicial', value: 'saldoInicial', align: 'center' },
          { text: 'Resgate', value: 'resgate', align: 'center' },
          { text: 'Aplicação', value: 'aplicacao', align: 'center' },
          { text: 'Saldo Final do dia', value: 'saldoFinal', align: 'center' },
          { text: 'Saldo atual', value: 'saldoAtual', align: 'center' }
        ],
        items: [],
        menu_data: false,
        date: new Date().getFullYear() + "-" + (new Date().getMonth()+1) + "-" + (new Date().getDate())
      }
    },
    methods: {
      TrocaData(){
        this.menu_data = false
        this.ListarMovimentacoes()
      },
      EditaMovimentacao(mov){
        var atualizar = {
          id: mov.id,
          inicial: mov.inicial,
          resgate: mov.resgate,
          aplicacao: mov.aplicacao,
          final: mov.final,
        }
        this.$http.post('/api/fundos/movimentacoes/atualizar', atualizar)
        ListarMovimentacoes()
      },
      ListarMovimentacoes(){
        this.$http.get('/api/fundos/movimentacoes/listar', {params:  {date: this.date}} ).then((req) => this.items = req.data)
      },
      CalculaSaldoAtual(valores){
        var SaldoAtual = parseFloat(valores.inicial) + parseFloat(valores.aplicacao) - parseFloat(valores.resgate)
        return SaldoAtual
      }
    }

  }
</script>
