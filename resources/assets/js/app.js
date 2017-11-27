// require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import VueResource from 'vue-resource';
import veevalidate from 'vee-validate'

Vue.use( Vuetify );
Vue.use( VueResource );
Vue.use( veevalidate );

window.Vue = require('vue');

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

import home from './components/home/Home.vue';
import usuarios from './components/usuarios/Usuarios.vue';
import cadusuario from './components/usuarios/CadastrarUsuario.vue';
import atusuario from './components/usuarios/AtualizarUsuario.vue';
import receitas from './components/receitas/Receitas.vue';
//import teste from './components/layout.vue';


new Vue({
    el: '#app',
    components:{

      //Home
      home,

      //Usuarios
      usuarios,
      cadusuario,
      atusuario,

      //Receitas
      receitas

      //Despesas

      //Logs
    },
});
