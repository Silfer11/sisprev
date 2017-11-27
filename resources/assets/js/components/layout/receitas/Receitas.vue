<template>
  <v-card>
    <v-card-title>Receitas:

      <v-spacer></v-spacer>

            <v-menu lazy :close-on-content-click="false" v-model="menu" transition="scale-transition" offset-y full-width :nudge-right="40" max-width="290px" min-width="290px">
              <v-text-field slot="activator" label="Data" v-model="date" prepend-icon="event" readonly></v-text-field>
              <v-date-picker type="month" v-model="date" no-title scrollable actions>
                <template slot-scope="{ save, cancel }">
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="cancel">Cancel</v-btn>
                    <v-btn flat color="primary" @click="save">OK</v-btn>
                  </v-card-actions>
                </template>
              </v-date-picker>
            </v-menu>

      <v-spacer></v-spacer>

      <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search"></v-text-field> <v-btn @click='imprimir()' flat>Imprimir</v-btn>
    </v-card-title>

      <v-data-table v-bind:headers="headers" v-bind:items="items" v-bind:search="search">
        <template slot="items" scope="props">
          <tr @click="props.expanded = !props.expanded">
            <td>
              <v-edit-dialog lazy>
                  {{ props.item.receita }}
                <v-text-field slot="input" label="Edit" v-model="props.item.descricao" single-line counter :rules="[max25chars]"></v-text-field>
              </v-edit-dialog>
            </td>
            <td class="text-xs-right">{{ props.item.descricao }}</td>
            <td class="text-xs-right">{{ props.item.origem }}</td>
            <td class="text-xs-right">{{ props.item.aliq }}</td>
            <td class="text-xs-right">{{ props.item.valDevido }}</td>
            <td class="text-xs-right">{{ props.item.data }}</td>
            <td class="text-xs-right">{{ props.item.observacoes }}</td>
            <td class="text-xs-right"><v-icon @click="edit(props.item.id)">edit</v-icon></td>
            <td class="text-xs-right"><v-icon @click="exclude(props.item.id)">delete</v-icon></td>
          </tr>
        </template>
      <template slot="pageText" scope="{ pageStart, pageStop }">
        From {{ pageStart }} to {{ pageStop }}
      </template>
    </v-data-table>

    <template>
      <v-form v-model="valid" ref="form" lazy-validation>

        <v-text-field label="Descricao" v-model="descricao"></v-text-field>

        <v-text-field label="Origem" v-model="origem"></v-text-field>

        <v-text-field label="Aliquota"  v-model="aliq"></v-text-field>

        <v-text-field label="Valor Devido"  v-model="valDevido"></v-text-field>

        <v-text-field label="Data"  v-model="data"></v-text-field>

        <v-text-field label="Observacoes"  v-model="observacoes"></v-text-field>

        <v-btn
          @click="submit"
          :disabled="!valid"
        >
          submit
        </v-btn>
        <v-btn @click="clear">clear</v-btn>
      </v-form>
    </template>
  </v-card>
</template>

<script>
  export default {
    mounted (){
      this.$http.get('/api/receitas/listar').then((req) => this.items = req.data)
    },
    data () {
      return {
        max25chars: (v) => v.length <= 25 || 'Input too long!',
        tmp: '',
        search: '',
        pagination: {},
        headers: [
          { text: 'Descricao', align: 'left', value: 'descricao'},
          { text: 'Origem', value: 'origem' },
          { text: 'Aliquota', value: 'aliq' },
          { text: 'Parcela', value: 'parcela' },
          { text: 'Valor Devido', value: 'valDevido' },
          { text: 'Data', value: 'data' },
          { text: 'Observacoes', value: 'observacoes' }
        ],
        items: [],

        date: null,
        menu: false,
        modal: false,

        valid: false,

        descricao: '',
        origem: '',
        aliq: '',
        parcela: '',
        valDevido: '',
        data: '',
        observacoes: '',

        idRPPS: 1
      }
    },
    methods: {
      imprimir(){
        window.print()
      },
      exclude(id){
        this.$http.post('/api/Receitas/excluir/' + id)
        window.location.reload()
      },
      edit(id){
        window.location.href='http://127.0.0.1:8000/AtualizarUsuarios/' + id
      },
      clear () {
        this.$refs.form.reset()
      },
      submit () {
        if (this.$refs.form.validate()) {
          var cadastro = {
          descricao: this.descricao,
          origem: this.origem,
          aliq: this.aliq,
          parcela: this.parcela,
          valDevido: this.valDevido,
          data: this.data,
          observacoes: this.observacoes,
          idRPPS: this.idRPPS
        }
          console.log(cadastro)
          this.$http.post('/api/receitas/cadastrar', cadastro)
        }
      }
    }
  }
</script>
