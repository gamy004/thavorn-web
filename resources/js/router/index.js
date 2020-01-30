import Vue from 'vue'
import VueRouter from 'vue-router'
import pawn from '../components/pawn'
import redeem from '../components/redeem'
import renew from '../components/renew'

Vue.use(VueRouter)
const routes = [
    {
      path: '/pawn',
      name: 'pawn',
      component: pawn
    },
    {
      path: '/redeem',
      name: 'redeem',
      component: redeem
    },
    {
      path: '/renew',
      name: 'renew',
      component: renew
    },
  ]

const router = new VueRouter({
  routes
})

export default router
