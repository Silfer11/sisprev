<template>
  <v-tabs fixed centered>
    <v-tabs-bar class="grey">
        <v-btn @click="createPDF()">Gerar PDF</v-btn>
    </v-tabs-bar>
    <v-card>
      <v-card-title>Relatório das Receitas:

        <v-spacer></v-spacer>

          <v-menu lazy :close-on-content-click="false" v-model="menu_data" transition="scale-transition" offset-y full-width :nudge-right="40" max-width="290px" min-width="290px">
            <v-text-field slot="activator" label="Data do sistema" v-model="date" prepend-icon="event" readonly></v-text-field>
            <v-date-picker type="month" locale="pt-br" v-model="date" no-title scrollable actions>
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
            <td class="text-xs-center">{{ props.item.receita_descricao.descricao }}</td>
            <td class="text-xs-center">{{ props.item.origem }}</td>
            <td class="text-xs-center">{{ props.item.aliq }}</td>
            <td class="text-xs-center">{{ props.item.parcela }}</td>
            <td class="text-xs-center">{{ props.item.data | formatar_data }}</td>
            <td class="text-xs-center">{{ props.item.observacoes }}</td>
            <td class="text-xs-center">{{ props.item.valDevido | formatar_dinheiro }}</td>
          </tr>
        </template>
        <template slot="footer">
          <tr style="font-weight: bold">
            <td class="text-xs-center"></td>
            <td class="text-xs-center"></td>
            <td class="text-xs-center"></td>
            <td class="text-xs-center"></td>
            <td class="text-xs-center"></td>
            <td class="text-xs-center">Valor Total</td>
            <td class="text-xs-center"> {{ calculaTotal() | formatar_dinheiro }}</td>
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
      this.ListarReceitas()
    },
    data () {
      return {
        max25chars: (v) => v.length <= 25 || 'Input too long!',
        tmp: '',
        search: '',
        pagination: {},
        headers: [
          { text: 'Descrição', value: 'descricao', align: 'center' },
          { text: 'Origem', value: 'origem', align: 'center' },
          { text: 'Alíquota', value: 'aliq', align: 'center' },
          { text: 'Parcela', value: 'parcela', align: 'center' },
          { text: 'Data', value: 'data', align: 'center' },
          { text: 'Observações', value: 'observacoes', align: 'center' },
          { text: 'Valor Devido', value: 'valDevido', align: 'center' }
        ],
        items: [],

        date: new Date().getFullYear() + "-" + (new Date().getMonth()+1),
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
        this.ListarReceitas()
      },
      ListarReceitas(){
        this.$http.get('/api/receitas/listar', {params:  {date: this.date}} ).then((req) => this.items = req.data)
      },
      calculaTotal(){
        var total = 0
        for(var i in this.items) {
          var valDevido = this.items[i].valDevido
          total = total + parseFloat(valDevido)
        }
        return total
      },
      createPDF () {

        var pdf = new jsPDF()
        pdf.addHTML(this.$el, function(){pdf.save('Relatório de Receitas.pdf')})
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
