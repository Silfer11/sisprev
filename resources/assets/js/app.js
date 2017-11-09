// require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import VueResource from 'vue-resource';
import veevalidate from 'vee-validate'

Vue.use( Vuetify );
Vue.use( VueResource );
Vue.use( veevalidate );

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

import home from './components/home/Home.vue';
import cadusuarios from './components/layout.vue';


new Vue({
    el: '#app',
    components:{
      home,
      cadusuarios
    },
});
