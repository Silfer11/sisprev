<template>
  <v-tabs fixed centered>
    <v-tabs-bar class="grey">
        <CadReceita v-on:Recarregar="ListarReceitas"></CadReceita>
        <CadReceitaDescricao v-on:Recarregar="ListarReceitas"></CadReceitaDescricao>
        <v-btn @click="createPDF()">imprimir</v-btn>
    </v-tabs-bar>

    <v-card>
      <v-card-title>Receitas Inseridas:

        <v-spacer></v-spacer>

          <v-menu lazy :close-on-content-click="false" v-model="menu_data" transition="scale-transition" offset-y full-width :nudge-right="40" max-width="290px" min-width="290px">
            <v-text-field slot="activator" label="Pesquisar por data" v-model="date" prepend-icon="event" readonly></v-text-field>
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
          <tr @click="props.expanded = !props.expanded">
            <td class="text-xs-center">{{ props.item.receita_descricao.descricao }}</td>
            <td class="text-xs-center">{{ props.item.origem }}</td>
            <td class="text-xs-center">{{ props.item.aliq }}</td>
            <td class="text-xs-center">{{ props.item.parcela }}</td>
            <td class="text-xs-center">{{ props.item.valDevido }}</td>
            <td class="text-xs-center">{{ props.item.data }}</td>
            <td class="text-xs-center"><v-btn icon flat @click="edit(props.item)"><v-icon>edit</v-icon></v-btn></td>
            <td class="text-xs-center"><v-btn icon flat @click="exclude(props.item.id)"><v-icon>delete</v-icon></v-btn></td>
          </tr>
        </template>

        <template slot="expand" scope="props">
          <v-card flat>
            <v-card-text>Observações: {{ props.item.observacoes }}</v-card-text>
          </v-card>
        </template>

        <template slot="pageText" scope="{ pageStart, pageStop }">
          From {{ pageStart }} to {{ pageStop }}
        </template>

      </v-data-table>
    </v-card>

    <span>*Clique na receita desejada para visualizar se há alguma observação da receita</span>

    <template>
      <v-dialog v-model="dialog" persistent max-width="500px">
          <v-card>
            <v-card-title>
              <span class="headline">Editar Receita</span>
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
                      <v-text-field type="number" label="Valor Devido" v-model="valDevido" prefix="$" required></v-text-field>
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
              <v-btn color="blue darken-1" flat @click="salvar">Salvar</v-btn>
            </v-card-actions>
          </v-card>
      </v-dialog>
    </template>
  </v-tabs>
</template>

<script>
  import CadReceita from "./Cadastros/CadReceita";
  import CadReceitaDescricao from "./Cadastros/CadReceitaDescricao";

  export default {
    components:{
      CadReceita,
      CadReceitaDescricao
    },
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
          { text: 'Valor Devido', value: 'valDevido', align: 'center' },
          { text: 'Data', value: 'data', align: 'center' },
          { text: 'Alterar', value: 'editar', align: 'center' },
          { text: 'Excluir', value: 'excluir', align: 'center' }
        ],
        items: [],

        date: new Date().getFullYear() + "-" + (new Date().getMonth()+1),
        menu: false,
        menu_data: false,
        modal: false,
        dialog: false,

        valid: false,
        listarDescricoes: [],

        id: null,
        idDescricao: null,
        origem: null,
        aliq: null,
        parcela: null,
        valDevido: null,
        data: null,
        observacoes: null,

        idRPPS: 1
      }
    },
    methods: {
      exclude(id){
        this.$http.post('/api/receitas/excluir/' + id)
        this.ListarReceitas()
      },
      edit(item){
        this.$http.get('/api/receitas/descricoes/listar').then((req) => this.listarDescricoes = req.data)

        this.id = item.id
        this.idDescricao = item.idDescricao
        this.origem = item.origem
        this.aliq = item.aliq
        this.parcela = item.parcela
        this.valDevido = item.valDevido
        this.data = item.data
        this.observacoes = item.observacoes

        this.dialog = true
      },
      fechar () {
        this.dialog = false
      },
      salvar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
            id: this.id,
            idDescricao: this.idDescricao,
            origem: this.origem,
            aliq: this.aliq,
            parcela: this.parcela,
            valDevido: this.valDevido,
            data: this.data,
            observacoes: this.observacoes,

            idRPPS: this.idRPPS
          }
          this.$http.post('/api/receitas/atualizar', cadastro).then(
            function(){
              this.ListarReceitas()
            }
          )
          this.dialog = false
        }
      },
      TrocaData(){
        this.menu_data = false
        this.ListarReceitas()
      },
      ListarReceitas(){
        this.$http.get('/api/receitas/listar', {params:  {date: this.date}} ).then((req) => this.items = req.data)
      },
      createPDF () {
        var pdf = new jsPDF();
        pdf.addHTML(this.$el, function(){pdf.save('teste.pdf')})
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
