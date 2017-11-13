<template>
  <v-form v-model="valid" ref="form" lazy-validation>

    <v-text-field
      label="Usuario"
      v-model="usuario"
      :rules="textRules"
      :counter="50"
      required
    ></v-text-field>

    <v-text-field
      label="Senha"
      v-model="senha"
      :rules="textRules"
      :counter="50"
      required
    ></v-text-field>

    <v-text-field
      label="Nome"
      v-model="nome"
      :rules="textRules"
      :counter="50"
      required
    ></v-text-field>

    <v-text-field
      label="CPF"
      v-model="cpf"
      :rules="textRules"
      :counter="11"
      required
    ></v-text-field>

    <v-text-field
      label="E-mail"
      v-model="email"
      :rules="emailRules"
      required
    ></v-text-field>

    <v-checkbox
      label="Perm. de Administrador"
      v-model="permAdmin"
    ></v-checkbox>
    <v-checkbox
      label="Perm. de Gest. Recursos"
      v-model="permGRec"
    ></v-checkbox>
    <v-checkbox
      label="Perm. de Gest. Financeira"
      v-model="permGFin"
    ></v-checkbox>
    <v-checkbox
      label="Perm. de Logs"
      v-model="permLogs"
    ></v-checkbox>

    <v-btn
      @click="submit"
      :disabled="!valid"
    >
      submit
    </v-btn>
    <v-btn @click="clear">clear</v-btn>
  </v-form>
</template>

<script>
  export default {
    data: () => ({
      valid: false,
      usuario: '',
      senha: '',
      nome: '',
      cpf: '',
      email: '',

      permAdmin: false,
      permGRec: false,
      permGFin: false,
      permLogs: false,

      idRPPS: 1,

      textRules: [
        (v) => !!v || 'O campo deve ser preenchido',
        (v) => v.length <= 40 || 'O campo pode ter no maximo 40 caracteres'
      ],
      emailRules: [
        (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail invalido',
        (v) => !!v || 'Por favor, preencha o campo E-mail'
      ]
    }),
    methods: {
      clear () {
        this.$refs.form.reset()
      },
      submit () {
        if (this.$refs.form.validate()) {
          var cadastro = {
          usuario: this.usuario,
          senha: this.senha,
          nome: this.nome,
          name: this.nome,
          cpf: this.cpf,
          email: this.email,
          permAdmin: this.permAdmin,
          permGRec: this.permGRec,
          permGFin: this.permGFin,
          permLogs: this.permLogs,
          idRPPS: this.idRPPS
        }
          this.$http.post('/api/usuarios/cadastrar', cadastro)
          this.$refs.form.reset()
          alert("cadastrado")
        }
      }
    }
  }
</script>
}
