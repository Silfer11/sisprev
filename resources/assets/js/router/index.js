import Vue from 'vue';
import VueRouter from 'vue-router';

import Login from '../components/Login';
import Layout from '../components/Layout';

import Home from '../components/Content/Home';
import Usuarios from '../components/Content/Usuarios';
import Receitas from '../components/Content/Receitas';
import Despesas from '../components/Content/Despesas';
import AplicacoesFinanceiras from '../components/Content/AplicacoesFinanceiras';

import Receitas_relatorio from '../components/Content/Receitas_relatorio';
import Despesas_relatorio from '../components/Content/Despesas_relatorio';
import AplicacoesFinanceiras_relatorio from '../components/Content/AplicacoesFinanceiras_relatorio';


Vue.use( VueRouter );

const routes = [
  {
    path: '/Login',
    name: 'Login',
    component: Login
  },
  {
    path: '/',
    component: Layout,
    meta: { requiresAuth: true },
    children:[
      {
        path: '/',
        redirect: '/Home'
      },
      {
        path: '/Home',
        name: 'Home',
        meta: { requiresAuth: true },
        component: Home
      },
      {
        path: '/Usuarios',
        name: 'Usuarios',
        meta: { requiresAuth: true },
        component: Usuarios
      },
      {
        path: '/Receitas',
        name: 'Receitas',
        meta: { requiresAuth: true },
        component: Receitas
      },
      {
        path: '/Despesas',
        name: 'Despesas',
        meta: { requiresAuth: true },
        component: Despesas
      },
      {
        path: '/AplicacoesFinanceiras',
        name: 'AplicacoesFinanceiras',
        meta: { requiresAuth: true },
        component: AplicacoesFinanceiras
      },
      {
        path: '/RelatorioReceitas',
        name: 'Receitas_relatorio',
        meta: { requiresAuth: true },
        component: Receitas_relatorio
      },
      {
        path: '/RelatorioDespesas',
        name: 'Despesas_relatorio',
        meta: { requiresAuth: true },
        component: Despesas_relatorio
      },
      {
        path: '/RelatorioAplicacoesFinanceiras',
        name: 'AplicacoesFinanceiras_relatorio',
        meta: { requiresAuth: true },
        component: AplicacoesFinanceiras_relatorio
      }
    ]
  }
]

const router = new VueRouter({
  routes
})

router.beforeEach((to, from, next) => {
  if(router.app.$store !== undefined){
    if (to.matched.some(record => record.meta.requiresAuth)) {
      if(to.path!=="/Login"){
        if (router.app.$store.state.Usuario.cpf !== "") {
          next()
        }else{
          next("Login")
        }
      }else{
        next()
      }
    }else{
      next()
    }
  }else{
    if (to.path !== '/Login') {
      next('Login');
    } else {
      next();
    }
  }
});

export default router
