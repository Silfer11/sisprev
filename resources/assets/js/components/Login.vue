<template>
    <v-app style="background-image: url(storage/wallpaper_login.jpg); background-repeat: round">
      <v-layout align-center justify-center>
        <v-card>
          <v-tabs grow icons>
            <v-tabs-bar dark color="grey">
              <v-tabs-slider color="red"></v-tabs-slider>
              <v-tabs-item :href="'#beneficiário'">
                <v-icon>people</v-icon>
                Beneficiário
              </v-tabs-item>
              <v-tabs-item :href="'#funcionário'">
                <v-icon>work</v-icon>
                Funcionário
              </v-tabs-item>
            </v-tabs-bar>

              <v-card-title>
                <span class="headline">Bem-vindo ao SISPREV</span>
              </v-card-title>

            <v-tabs-items>
              <v-tabs-content :id="'beneficiário'">
                <v-card flat>
                  <v-card-text class="text-xs-center">
                        <v-form>
                          <v-text-field label="CPF" v-model="cpf" mask="###.###.###-##" :counter="11" required></v-text-field>
                          <v-btn @click="logar_B" outline color="indigo">Logar</v-btn>
                        </v-form>
                  </v-card-text>
                </v-card>
              </v-tabs-content>
              <v-tabs-content :id="'funcionário'">
                <v-card flat>
                  <v-card-text class="text-xs-center">
                        <v-form>
                          <v-text-field label="Usuário" v-model="usuario" required></v-text-field>
                          <v-text-field label="Senha" v-model="senha" type="password" required></v-text-field>
                          <v-btn @click="logar_F" outline color="indigo">Logar</v-btn>
                        </v-form>
                  </v-card-text>
                </v-card>
              </v-tabs-content>
            </v-tabs-items>
          </v-tabs>

        </v-card>
      </v-layout>
    </v-app>
</template>

<script>
  export default{
    data () {
      return {
        usuario: '',
        senha: '',
        cpf: ''
      }
    },
    methods:{
      logar_B(){
        const payload = {
          nome: "Beneficiário",
          usuario: "Beneficiário",
          cpf: this.cpf,
          permAdmin: 'false',
          permGRec: 'false',
          permGFin: 'false',
          permLogs: 'false'
        }
        this.$store.commit('LOGAR', payload)
        this.$router.push('/Home')
      },
      logar_F(){
        var login = {
          usuario : this.usuario,
          senha : this.senha
        }
        this.$http.post("/api/logar/funcionario", login).then(function(response){
          var Usuario = response.body[0]
          const payload = {
            nome: Usuario.nome,
            usuario: Usuario.usuario,
            cpf: Usuario.cpf,
            permAdmin: Usuario.permAdmin,
            permGRec: Usuario.permGRec,
            permGFin: Usuario.permGFin,
            permLogs: Usuario.permLogs
          }
          this.$store.commit('LOGAR', payload)
          this.$router.push('/Home')
        })

      }
    }
  }
</script>
