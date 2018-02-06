// require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import VueResource from 'vue-resource';
import VeeValidate from 'vee-validate';
import numeral from 'numeral';
import moment from 'moment';

import router from './router';
import app from './components/index';
import store from './vuex/store';


Vue.use( Vuetify );
Vue.use( VueResource );
Vue.use( VeeValidate );
Vue.use( numeral );
Vue.use( moment );



window.Vue = require('vue');

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

numeral.register('locale', 'pt-br', {
    delimiters: {
        thousands: '.',
        decimal: ','
    },
    abbreviations: {
        thousand: 'mil',
        million: 'milhões',
        billion: 'bilhões',
        trillion: 'trilhões'
    },
    ordinal : () => 'º',
    currency: {
        symbol: 'R$ '
    }
});
numeral.locale('pt-br');
const formato_dinheiro = '$ 0,0.00';

Vue.filter('formatar_dinheiro', function (val) {
  return numeral(val).format(formato_dinheiro);
});

Vue.filter('formatar_data', function(value) {
  if (value) {
    return moment(String(value)).format('DD/MM/YYYY');
  }
});


// Vue.filter('format_money', {
//   // Model => View
//   read: function (val) {
//      return numeral(val).format(teste);
//   },
//   // View => Model
//   write: function (val, oldVal) {
//     const number = +val.replace(/[^\d.,]/g, '');
//     return isNaN(number) ? 0 : parseFloat(number.toFixed(2))
//   }
// });

new Vue({
    el: '#app',
    store,
    router,
    components:{
      app
    }
});
