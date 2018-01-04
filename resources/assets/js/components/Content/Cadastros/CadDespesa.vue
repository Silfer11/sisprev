<template>
  <v-dialog v-model="dialog" persistent max-width="500px">
    <v-btn slot="activator"><v-icon>playlist_add</v-icon>Cadastrar Despesa</v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">Cadastrar Despesa</span>
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
                  <v-text-field label="Valor" v-model="valor" prefix="R$" required></v-text-field>
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
          <v-btn color="blue darken-1" flat @click="cadastrar">Cadastrar</v-btn>
        </v-card-actions>
      </v-card>
  </v-dialog>
</template>

<script>
//'id', 'descricao', 'valor', 'data', 'idCategoria', 'idRPPS'
  export default {

    created (){
      this.$http.get('http://127.0.0.1:8000/api/despesas/categorias/listar').then((req) => this.listarCategorias = req.data)
    },
    data () {
      return {
        alert: false,
        valid: false,

        descricao: null,
        valor: null,
        data: null,
        idCategoria: null,

        listarCategorias: [],

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
        this.descricao = null
        this.valor = null
        this.data = null
        this.idCategoria = null

        this.dialog = false
      },
      cadastrar () {
        if (this.$refs.form.validate()) {
          var cadastro = {
            descricao: this.descricao,
            valor: this.valor,
            data: this.data,
            idCategoria: this.idCategoria,

            idRPPS: this.idRPPS
          }
          this.$http.post('/api/despesas/cadastrar', cadastro)

          this.descricao = null
          this.valor = null
          this.data = null
          this.idCategoria = null

          this.dialog = false
          this.$router.go()
        }
      }
    }
  }
</script>
