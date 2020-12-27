import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export const store = new Vuex.Store({
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
