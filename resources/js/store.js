import axios from "axios";
import { param as paramsSerializer } from "jquery";
import Vue from "vue";
import Vuex from "vuex";
import VuexORM from "@vuex-orm/core";
import VuexORMAxios from "@vuex-orm/plugin-axios";
import User from "models/User";
import Pawn from "models/Pawn";
import Payment from "models/Payment";
import PawnItem from "models/PawnItem";
import PawnUserItem from "models/PawnUserItem";
import ItemCategory from "models/ItemCategory";
import ItemDamage from "models/ItemDamage";

VuexORM.use(VuexORMAxios, {
    axios,
    headers: { "X-Requested-With": "XMLHttpRequest" },
    baseURL: "/api",
    paramsSerializer
});

Vue.use(Vuex);

const database = new VuexORM.Database();

database.register(User);
database.register(Pawn);
database.register(Payment);
database.register(PawnItem);
database.register(PawnUserItem);
database.register(ItemCategory);
database.register(ItemDamage);

export const store = new Vuex.Store({
    plugins: [VuexORM.install(database)],

    state: {
        sidebarCollapsed: false,
        sidebarCollapsedMobile: false
    },
    mutations: {
        SET_SIDEBAR_COLLAPSED(state, value) {
            state.sidebarCollapsed = value;
        },
        SET_SIDEBAR_COLLAPSED_MOBILE(state, value) {
            state.sidebarCollapsedMobile = value;
        }
    }
});
