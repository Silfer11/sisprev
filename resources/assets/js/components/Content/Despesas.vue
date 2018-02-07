<template>
  <v-tabs fixed centered>
    <v-tabs-bar class="grey">
        <CadDespesa v-on:Recarregar="ListarDespesas"></CadDespesa>
        <CadDespesaCategoria v-on:Recarregar="ListarDespesas"></CadDespesaCategoria>
    </v-tabs-bar>

    <v-card>
      <v-card-title>Despesas Inseridas:

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
          <tr @click="props.expanded = !props.expanded">
            <td class="text-xs-center">{{ props.item.despesa_categoria.categoria }}</td>
            <td class="text-xs-center">{{ props.item.valor | formatar_dinheiro }}</td>
            <td class="text-xs-center">{{ props.item.data | formatar_data }}</td>
            <td class="text-xs-center">{{ props.item.descricao }}</td>
            <td class="text-xs-center"><v-btn icon flat @click="edit(props.item)"><v-icon>edit</v-icon></v-btn></td>
            <td class="text-xs-center"><v-btn icon flat @click="exclude(props.item.id)"><v-icon>delete</v-icon></v-btn></td>
          </tr>
        </template>

        <template slot="pageText" scope="{ pageStart, pageStop }">
          From {{ pageStart }} to {{ pageStop }}
        </template>
      </v-data-table>
    </v-card>

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
                    <v-flex xs12>
                      <v-text-field label="Descrição" v-model="descricao" required></v-text-field>
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
                      <v-text-field type="number" label="Valor" v-model="valor" prefix="$" required></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm6 md4>
                      <v-select
                        label="Categoria"
                        required
                        v-model="idCategoria"
                        :items="listarCategorias"
                        item-text="categoria"
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
              <v-btn color="blue darken-1" flat @click="salvar">Salvar</v-btn>
            </v-card-actions>
          </v-card>
      </v-dialog>
    </template>
  </v-tabs>
</template>

<script>
  import CadDespesa from "./Cadastros/CadDespesa";
  import CadDespesaCategoria from "./Cadastros/CadDespesaCategoria";

  export default {
    components:{
      CadDespesa,
      CadDespesaCategoria
    },
    created (){
      this.ListarDespesas()
    },
    data () {
      return {
        max25chars: (v) => v.length <= 25 || 'Input too long!',
        tmp: '',
        search: '',
        pagination: {},
        headers: [
          { text: 'Categoria', value: 'categoria', align: 'center' },
          { text: 'Valor', value: 'valor', align: 'center' },
          { text: 'Data', value: 'data', align: 'center' },
          { text: 'Descrição', value: 'descricao', align: 'center' },
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
        listarCategorias: [],

        id: null,
        descricao: null,
        valor: null,
        data: null,
        idCategoria: null,

        idRPPS: 1
      }
    },
    methods: {
      exclude(id){
        this.$http.post('/api/despesas/excluir/' + id)
        this.ListarDespesas()
      },
      edit(item){
        this.$http.get('/api/despesas/categorias/listar').then((req) => this.listarCategorias = req.data)

        this.id = item.id
        this.descricao = item.descricao
        this.valor = item.valor
        this.data = item.data
        this.idCategoria = item.idCategoria

        this.dialog = true
      },
      fechar () {
        this.dialog = false
      },
      salvar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
            id: this.id,
            descricao: this.descricao,
            valor: this.valor,
            data: this.data,
            idCategoria: this.idCategoria,

            idRPPS: this.idRPPS
          }
          this.$http.post('/api/despesas/atualizar', cadastro).then(
            function(){
              this.ListarDespesas()
            }
          )

          this.dialog = false
        }
      },
      TrocaData(){
        this.menu_data = false
        this.ListarDespesas()
      },
      ListarDespesas(){
        this.$http.get('/api/despesas/listar', {params:  {date: this.date}} ).then((req) => this.items = req.data)
      }
    }
  }
</script>
