import Vue from 'vue'
import VueRouter from 'vue-router'
import pawn from '../components/pawn'
Vue.use(VueRouter)
const routes = [
    {
      path: '/',
      name: 'pawn',
      component: pawn
    },
  ]

const router = new VueRouter({
  routes
})

export default router
