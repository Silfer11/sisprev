<template>
  <v-tabs fixed centered>
    <v-tabs-bar class="grey">
        <v-btn @click="createPDF()">Gerar PDF</v-btn>
    </v-tabs-bar>
    <v-card>
      <v-card-title>Relatório das Aplicações Financeiras:

        <v-spacer></v-spacer>

        <v-menu lazy :close-on-content-click="false" v-model="menu_data" transition="scale-transition" offset-y full-width :nudge-right="40" max-width="290px" min-width="290px">
          <v-text-field slot="activator" label="Data do sistema" v-model="date" prepend-icon="event" readonly></v-text-field>
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

      <v-data-table v-bind:headers="headers" v-bind:items="items" v-bind:search="search">
        <template slot="items" slot-scope="props">
          <tr>
            <td class="text-xs-center">{{ props.item.fundo.banco.nome }}</td>
            <td class="text-xs-center">{{ props.item.fundo.nome }}</td>
            <td class="text-xs-center">{{ props.item.fundo.risco }}</td>

            <td class="text-xs-center">{{ props.item.inicial | formatar_dinheiro }}</td>

            <td class="text-xs-center">{{ props.item.resgate | formatar_dinheiro }}</td>

            <td class="text-xs-center">{{ props.item.aplicacao | formatar_dinheiro }}</td>

            <td class="text-xs-center">
              <span v-if="props.item.final != 0">{{ props.item.final | formatar_dinheiro }}</span>
              <span v-else>{{ CalculaSaldoAtual(props.item) | formatar_dinheiro }}</span>
            </td>
          </tr>
        </template>
        <template slot="footer">
          <tr style="font-weight: bold">
            <td class="text-xs-center">Total</td>
            <td class="text-xs-center"></td>
            <td class="text-xs-center"></td>
            <td class="text-xs-center"> {{ calculaTotalInicial() | formatar_dinheiro }} </td>
            <td class="text-xs-center"> {{ calculaTotalResgate() | formatar_dinheiro }} </td>
            <td class="text-xs-center"> {{ calculaTotalAplicacao() | formatar_dinheiro }} </td>
            <td class="text-xs-center"> {{ calculaTotalFinal() | formatar_dinheiro }}</td>
          </tr>
        </template>


      </v-data-table>
    </v-card>
  </v-tabs>
</template>
<script>
  import * as jspdf from 'jspdf';

  export default {
    created (){
      this.ListarMovimentacoes()
    },
    data () {
      return {
        max25chars: (v) => v.length <= 25 || 'Input too long!',
        tmp: '',
        search: '',
        pagination: {},
        headers: [
          { text: 'Banco', value: 'banco', align: 'center' },
          { text: 'Fundo', value: 'nome', align: 'center' },
          { text: 'Grau de Risco', value: 'risco', align: 'center' },
          { text: 'Saldo inicial do mês', value: 'saldoInicial', align: 'center' },
          { text: 'Resgate', value: 'resgate', align: 'center' },
          { text: 'Aplicação', value: 'aplicacao', align: 'center' },
          { text: 'Saldo final do dia', value: 'saldoFinal', align: 'center' }
        ],
        items: [],

        date: new Date().getFullYear() + "-" + (new Date().getMonth()+1) + "-" + (new Date().getDate()),
        menu: false,
        menu_data: false,
        modal: false,
        dialog: false,

        valid: false,
        listarDescricoes: [],

        idRPPS: 1
      }
    },
    methods: {
      TrocaData(){
        this.menu_data = false
        this.ListarMovimentacoes()
      },
      ListarMovimentacoes(){
        this.$http.get('/api/fundos/movimentacoes/listar', {params:  {date: this.date}} ).then((req) => this.items = req.data)
      },
      CalculaSaldoAtual(valores){
        var SaldoAtual = parseFloat(valores.inicial) + parseFloat(valores.aplicacao) - parseFloat(valores.resgate)
        return SaldoAtual
      },
      calculaTotalInicial(){
        var total = 0
        for(var i in this.items) {
          var inicial = this.items[i].inicial
          total = total + parseFloat(inicial)
        }
        return total
      },
      calculaTotalResgate(){
        var total = 0
        for(var i in this.items) {
          var resgate = this.items[i].resgate
          total = total + parseFloat(resgate)
        }
        return total
      },
      calculaTotalAplicacao(){
        var total = 0
        for(var i in this.items) {
          var aplicacao = this.items[i].aplicacao
          total = total + parseFloat(aplicacao)
        }
        return total
      },
      calculaTotalFinal(){
        var total = 0
        for(var i in this.items) {
          var final = this.items[i].final
          if(this.items[i].final != 0){
            total = total + parseFloat(final)
          }else{
            total = total + parseFloat(this.CalculaSaldoAtual(this.items[i]))
          }
        }
        return total
      },
      createPDF () {

        var pdf = new jsPDF()
        pdf.addHTML(this.$el, function(){pdf.save('Relatório de Movimentações.pdf')})
      },
    // GerarPdf(){
    //   let source      = this.$el
    //   let cache_width = source.width()
    //   let a4          = [595.28, 990.89]
    //
    //   let canvasImage = ''
    //   let winHeight   = a4[1]
    //   let formHeight  = source.height()
    //   let formWidth   = source.width()
    //
    //   let imagePieces = []
    //
    //   imagePieces = [];
    //   imagePieces.length = 0;
    //
    //   source.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
    //
    //   return html2canvas(source, {
    //       imageTimeout: 2000,
    //       removeContainer: true
    //   })
    //   .then(canvas => {
    //     console.log(canvas)
    //     canvasImage = new Image();
    //     canvasImage.src = canvas.toDataURL("image/png");
    //     let totalImgs = Math.round(formHeight/winHeight);
    //
    //     for(let i = 0; i < totalImgs; i++) {
    //         let canvas = document.createElement('canvas'),
    //             ctx = canvas.getContext('2d');
    //         canvas.width = formWidth;
    //         canvas.height = winHeight;
    //         ctx.drawImage(canvasImage, 0, i * winHeight, formWidth, winHeight, 0, 0, canvas.width, canvas.height);
    //         imagePieces.push(canvas.toDataURL("image/png"));
    //     }
    //     console.log(imagePieces.length);
    //     let totalPieces = imagePieces.length - 1;
    //     let doc = new jsPDF({
    //         unit: 'px',
    //         format: 'a4'
    //     });
    //     imagePieces.forEach(function(img){
    //         doc.addImage(img, 'JPEG', 20, 40);
    //         if(totalPieces)
    //             doc.addPage();
    //         totalPieces--;
    //     });
    //     doc.save('techumber-html-to-pdf.pdf');
    //     //source.width(cache_width);
    //   })
    // }

    }
  }
</script>
