import Vue from "vue";
import Vuex from "vuex";
import VuexORM from "@vuex-orm/core";
import User from "models/User";
Vue.use(Vuex);

const database = new VuexORM.Database();

database.register(User);

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
