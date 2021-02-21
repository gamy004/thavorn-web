import Vue from "vue";
import NProgress from "nprogress";
import VueRouter from "vue-router";
// import pawn from "../components/pawn";
// import redeem from "../components/redeem";
// import renew from "../components/renew";
// import UpdatePawn from "../components/updatePawn";
// import PageNotFound from "../components/pageNotFound";
// import db from "../components/db";
// import dbUser from "../components/showData/dbUser";
// import dbPawn from "../components/showData/dbPawn";
import * as VIEWS from "../views";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "home",
        component: VIEWS.HOME
    },
    {
        path: "/pawns/create",
        name: "pawn-create",
        component: VIEWS.PAWN.CREATE
    },
    {
        path: "/pawns/extend",
        name: "pawn-extend",
        component: VIEWS.PAWN.EXTEND
    },
    {
        path: "/pawns/close",
        name: "pawn-close",
        component: VIEWS.PAWN.CLOSE
    },
    {
        path: "/data/customers",
        name: "data-customer",
        component: VIEWS.DATA.CUSTOMER
    },
    {
        path: "/data/pawns",
        name: "data-pawn",
        component: VIEWS.DATA.PAWN
    }

    // {
    //   path: '/pawn',
    //   name: 'pawn',
    //   component: pawn,
    //   meta: {
    //     activeMenu: 'pawn'
    //   }
    // },
    // {
    //   path: '/redeem',
    //   name: 'redeem',
    //   component: redeem,
    //   meta: {
    //     activeMenu: 'redeem'
    //   }
    // },
    // {
    //   path: '/renew',
    //   name: 'renew',
    //   component: renew,
    //   meta: {
    //     activeMenu: 'renew'
    //   }
    // },
    // {
    //   path: '/updatepawn',
    //   name: 'updatepawn',
    //   component: UpdatePawn,
    //   meta: {
    //     activeMenu: 'UpdatePawn'
    //   }
    // },
    // {
    //   path: '/db',
    //   name: 'db',
    //   component: db,
    //   meta: {
    //     activeMenu: 'db'
    //   }
    // },
    // {
    //   path: '/dbUser',
    //   name: 'dbUser',
    //   component: dbUser,
    //   meta: {
    //     activeMenu: 'dbUser'
    //   }
    // },
    // {
    //   path: '/dbPawn',
    //   name: 'dbPawn',
    //   component: dbPawn,
    //   meta: {
    //     activeMenu: 'dbPawn'
    //   }
    // },
    // {
    //     path: "*",
    //     component: PageNotFound
    // }
];

const router = new VueRouter({
    scrollBehavior() {
        return window.scrollTo({ top: 0, behavior: "smooth" });
    },
    mode: "history",
    base: __dirname,
    routes,
    linkActiveClass: "is-active"
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    NProgress.set(0.1);
    next();
});

router.afterEach(() => {
    setTimeout(() => NProgress.done(), 500);
});

export default router;
