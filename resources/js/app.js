/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import VueRouter from 'vue-router';
import router from "./router";
import app from "./views/app";
import BootstrapVue from "bootstrap-vue";
import { store } from "./store";

require("./bootstrap");

window.Vue = require("vue");

Vue.use(BootstrapVue);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Default from "./Layout/Wrappers/baseLayout";
import Pages from "./Layout/Wrappers/pagesLayout";
import Apps from "./Layout/Wrappers/appLayout";
import Layouts from "./Layout/Wrappers/layoutsExamples";

Vue.component("default-layout", Default);
Vue.component("pages-layout", Pages);
Vue.component("apps-layout", Apps);
Vue.component("examples-layout", Layouts);

import "./assets/bamburgh.scss";

new Vue({
    router,
    store,
    render: h => h(app)
}).$mount("#app");
