import Vue from 'vue'
import VueRouter from 'vue-router'
import pawn from '../components/pawn'
import redeem from '../components/redeem'
import renew from '../components/renew'
import UpdatePawn from '../components/updatePawn'
import PageNotFound from '../components/pageNotFound'
import db from '../components/db'
import dbUser from '../components/showData/dbUser'
import dbPawn from '../components/showData/dbPawn'

Vue.use(VueRouter)
const routes = [
    {
      path: '/pawn',
      name: 'pawn',
      component: pawn,
      meta: {
        activeMenu: 'pawn'
      }
    },
    {
      path: '/redeem',
      name: 'redeem',
      component: redeem,
      meta: {
        activeMenu: 'redeem'
      }
    },
    {
      path: '/renew',
      name: 'renew',
      component: renew,
      meta: {
        activeMenu: 'renew'
      }
    },
    {
      path: '/updatepawn',
      name: 'updatepawn',
      component: UpdatePawn,
      meta: {
        activeMenu: 'UpdatePawn'
      }
    },
    {
      path: '/db',
      name: 'db',
      component: db,
      meta: {
        activeMenu: 'db'
      }
    },
    {
      path: '/dbUser',
      name: 'dbUser',
      component: dbUser,
      meta: {
        activeMenu: 'dbUser'
      }
    },
    {
      path: '/dbPawn',
      name: 'dbPawn',
      component: dbPawn,
      meta: {
        activeMenu: 'dbPawn'
      }
    },
    {
      path: '*',
      component: PageNotFound
    },
  ]

const router = new VueRouter({
  routes
})

export default router
