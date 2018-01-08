// require('./bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify';
import VueResource from 'vue-resource';
import VeeValidate from 'vee-validate';

import router from './router';
import app from './components/index';
import store from './vuex/store';

Vue.use( Vuetify );
Vue.use( VueResource );
Vue.use( VeeValidate );


window.Vue = require('vue');

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({
    el: '#app',
    store,
    router,
    components:{
      app
    }
});
