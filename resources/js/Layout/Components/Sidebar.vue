<template>
  <div class="app-sidebar app-sidebar--dark" :class="sidebarbg">
    <div class="app-sidebar--header">
      <!-- <div class="nav-logo w-100 text-center">
        <router-link
          tag="a"
          class="d-block"
          active-class="active"
          to="/"
          exact
          v-b-tooltip.hover
          title="Fully built and powered by Vue.js 🚀"
        >
          <img src="assets/img/admin-logo.png" alt="" />
          <span>THAVORN</span>
        </router-link>
      </div> -->
      <button
        class="toggle-sidebar rounded-circle btn btn-sm bg-white shadow-sm-dark text-primary"
        v-b-tooltip.hover
        title="Expand Sidebar"
        v-bind:class="{ 'is-active': sidebarCollapsed }"
        type="button"
        v-on:click="toggleSidebar"
      >
        <font-awesome-icon icon="arrows-alt-h" />
      </button>
    </div>
    <VuePerfectScrollbar class="app-sidebar--content">
      <div class="sidebar-navigation">
        <sidebar-menu showOneChild :menu="menu" show-child />
      </div>
    </VuePerfectScrollbar>
  </div>
</template>

<script>
import Vue from "vue";

Vue.component("truck-icon", TruckIcon);
Vue.component("battery-charging-icon", BatteryChargingIcon);
Vue.component("cpu-icon", CpuIcon);
Vue.component("user-check-icon", UserCheckIcon);
Vue.component("check-circle-icon", CheckCircleIcon);
Vue.component("layout-icon", LayoutIcon);
Vue.component("paper-clip-icon", PaperclipIcon);
Vue.component("layers-icon", LayersIcon);
Vue.component("database-icon", DatabaseIcon);
Vue.component("briefcase-icon", BriefcaseIcon);
Vue.component("map-pin-icon", MapPinIcon);
Vue.component("pie-chart-icon", PieChartIcon);

import { SidebarMenu } from "vue-sidebar-menu";
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import {
  TruckIcon,
  BatteryChargingIcon,
  CpuIcon,
  UserCheckIcon,
  CheckCircleIcon,
  LayoutIcon,
  PaperclipIcon,
  LayersIcon,
  DatabaseIcon,
  BriefcaseIcon,
  MapPinIcon,
  PieChartIcon,
} from "vue-feather-icons";

import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faArrowsAltH,
  faHandHoldingUsd,
  faClock,
  faReply,
  faDatabase,
} from "@fortawesome/free-solid-svg-icons";

library.add(faArrowsAltH, faHandHoldingUsd, faClock, faReply, faDatabase);

export default {
  components: {
    SidebarMenu,
    VuePerfectScrollbar,
  },
  props: {
    sidebarbg: String,
  },
  data() {
    return {
      menu: [
        {
          title: "การจำนำ",
          href: "/pawns/create",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "hand-holding-usd",
            },
          },
        },
        {
          title: "ต่ออายุดอกเบี้ย",
          href: "/pawns/extend",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "clock",
            },
          },
        },
        {
          title: "ไถ่ถอน",
          href: "/pawns/close",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "reply",
            },
          },
        },
        {
          title: "ข้อมูล",
          class: "no-hilighted",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "database",
            },
          },
          child: [
            {
              href: "/data/customers",
              title: "ลูกค้า",
            },
            {
              href: "/data/pawns",
              title: "การจำนำ",
              // class: "pr-2",
              // badge: {
              //   text: "New",
              //   class: "badge badge-first ml-auto order-2",
              // },
            },
          ],
        },
      ],
      collapsed: true,
    };
  },
  computed: {
    sidebarCollapsed: {
      get() {
        return this.$store.state.sidebarCollapsed;
      },
      set(value) {
        this.$store.commit("SET_SIDEBAR_COLLAPSED", value);
      },
    },
  },
  methods: {
    toggleSidebar() {
      this.sidebarCollapsed = !this.sidebarCollapsed;
    },
  },
};
</script>
