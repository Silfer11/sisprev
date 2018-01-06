import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../components/Content/Login';
import Home from '../components/Content/Home';
import Usuarios from '../components/Content/Usuarios';
import Receitas from '../components/Content/Receitas';
import Despesas from '../components/Content/Despesas';
import AplicacoesFinanceiras from '../components/Content/AplicacoesFinanceiras'

Vue.use( VueRouter );

const routes = new VueRouter({
  routes: [
    {
      path: '/',
      redirect: '/Home'
    },
    {
      path: '/Home',
      name: 'Home',
      component: Home
    },
    {
      path: '/Usuarios',
      name: 'Usuarios',
      component: Usuarios
    },
    {
      path: '/Receitas',
      name: 'Receitas',
      component: Receitas
    },
    {
      path: '/Despesas',
      name: 'Despesas',
      component: Despesas
    },
    {
      path: '/AplicacoesFinanceiras',
      name: 'AplicacoesFinanceiras',
      component: AplicacoesFinanceiras
    }
  ]
})

export default routes
