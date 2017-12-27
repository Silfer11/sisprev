// require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import VueResource from 'vue-resource';
import veevalidate from 'vee-validate';

import router from './router';
import layout from './components/layout';

Vue.use( Vuetify );
Vue.use( VueResource );
Vue.use( veevalidate );

window.Vue = require('vue');

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({
    el: '#app',
    router,
    components:{
      layout
    }
});
